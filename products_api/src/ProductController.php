<?php
class ProductController {
    private $conn;
    private $response;

    public function __construct($db) {
        $this->conn = $db;
        $this->response = new Response();
    }

    // GET all products
    public function getAllProducts() {
        $query = "SELECT * FROM products";
        
        // Filtering
        $where = [];
        $params = [];
        
        if (isset($_GET['category']) && $_GET['category'] !== '') {
            $where[] = "category = :category";
            $params[':category'] = $_GET['category'];
        }
        
        if (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
            $where[] = "price >= :min_price";
            $params[':min_price'] = $_GET['min_price'];
        }
        
        if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
            $where[] = "price <= :max_price";
            $params[':max_price'] = $_GET['max_price'];
        }
        
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        
        // Sorting
        if (isset($_GET['sort'])) {
            $sortMapping = [
                'price_asc' => 'price ASC',
                'price_desc' => 'price DESC',
                'rating_desc' => 'rating_rate DESC',
                'title_asc' => 'title ASC'
            ];
            $query .= " ORDER BY " . ($sortMapping[$_GET['sort']] ?? 'id ASC');
        } else {
            $query .= " ORDER BY id ASC";
        }
        
        // Pagination
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $per_page = isset($_GET['per_page']) ? min(50, max(1, intval($_GET['per_page']))) : 10;
        $offset = ($page - 1) * $per_page;
        $query .= " LIMIT :limit OFFSET :offset";
        $params[':limit'] = $per_page;
        $params[':offset'] = $offset;

        $stmt = $this->conn->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        
        $stmt->execute();
        
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get total count for pagination
        $countQuery = "SELECT COUNT(*) as total FROM products";
        if (!empty($where)) {
            $countQuery .= " WHERE " . implode(" AND ", $where);
        }
        $countStmt = $this->conn->prepare($countQuery);
        
        $countParams = array_filter($params, function($key) {
            return $key !== ':limit' && $key !== ':offset';
        }, ARRAY_FILTER_USE_KEY);
        
        foreach ($countParams as $key => $value) {
            $countStmt->bindValue($key, $value, is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        
        $countStmt->execute();
        $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $this->response->sendSuccess([
            'products' => $products,
            'pagination' => [
                'page' => $page,
                'per_page' => $per_page,
                'total' => $total,
                'total_pages' => ceil($total / $per_page)
            ]
        ]);
    }

    // GET single product
    public function getSingleProduct($id) {
        if (!is_numeric($id)) {
            $this->response->sendError(400, "Invalid product ID");
            return;
        }

        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->response->sendSuccess($product);
        } else {
            $this->response->sendError(404, "Product not found");
        }
    }

    // POST create product
    public function createProduct() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            $this->response->sendError(400, "Invalid JSON data");
            return;
        }

        // Validation
        $required = ['title', 'price', 'category'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $this->response->sendError(400, "Missing required field: $field");
                return;
            }
        }

        if (!is_numeric($data['price']) || $data['price'] < 0) {
            $this->response->sendError(400, "Price must be a positive number");
            return;
        }

        $query = "INSERT INTO products 
                 (title, price, description, category, image, rating_rate, rating_count) 
                 VALUES (:title, :price, :description, :category, :image, :rating_rate, :rating_count)";
        
        $stmt = $this->conn->prepare($query);
        
        try {
            $stmt->execute([
                ':title' => $data['title'],
                ':price' => $data['price'],
                ':description' => $data['description'] ?? '',
                ':category' => $data['category'],
                ':image' => $data['image'] ?? '',
                ':rating_rate' => $data['rating_rate'] ?? 0,
                ':rating_count' => $data['rating_count'] ?? 0
            ]);

            $lastId = $this->conn->lastInsertId();
            $this->getSingleProduct($lastId); // Return the created product
        } catch (PDOException $e) {
            $this->response->sendError(500, "Failed to create product: " . $e->getMessage());
        }
    }

    // PUT update product
    public function updateProduct($id) {
        if (!is_numeric($id)) {
            $this->response->sendError(400, "Invalid product ID");
            return;
        }

        // Check if product exists
        $checkQuery = "SELECT id FROM products WHERE id = :id";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->rowCount() === 0) {
            $this->response->sendError(404, "Product not found");
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            $this->response->sendError(400, "Invalid JSON data");
            return;
        }

        // Build update query dynamically based on provided fields
        $allowedFields = ['title', 'price', 'description', 'category', 'image', 'rating_rate', 'rating_count'];
        $updates = [];
        $params = [':id' => $id];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $updates[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }

        if (empty($updates)) {
            $this->response->sendError(400, "No valid fields to update");
            return;
        }

        // Validate price if provided
        if (isset($data['price']) && (!is_numeric($data['price']) || $data['price'] < 0)) {
            $this->response->sendError(400, "Price must be a positive number");
            return;
        }

        $query = "UPDATE products SET " . implode(', ', $updates) . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        try {
            $stmt->execute($params);
            $this->getSingleProduct($id); // Return the updated product
        } catch (PDOException $e) {
            $this->response->sendError(500, "Failed to update product: " . $e->getMessage());
        }
    }

    // DELETE product
    public function deleteProduct($id) {
        if (!is_numeric($id)) {
            $this->response->sendError(400, "Invalid product ID");
            return;
        }

        // Check if product exists
        $checkQuery = "SELECT id FROM products WHERE id = :id";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->rowCount() === 0) {
            $this->response->sendError(404, "Product not found");
            return;
        }

        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            $this->response->sendSuccess([], "Product deleted successfully");
        } catch (PDOException $e) {
            $this->response->sendError(500, "Failed to delete product: " . $e->getMessage());
        }
    }
}
?>