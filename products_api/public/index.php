<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

require_once '../src/Database.php';
require_once '../src/ProductController.php';
require_once '../src/Response.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ProductController($db);
$response = new Response();

// Get the request path
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];

// Remove the script name from request URI to get the path
$path = str_replace(dirname($script_name), '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);
$path_components = array_values(array_filter(explode('/', $path)));

$endpoint = $path_components[0] ?? '';
$id = $path_components[1] ?? null;

// Debug output
error_log("Request URI: " . $request_uri);
error_log("Script Name: " . $script_name);
error_log("Path: " . $path);
error_log("Endpoint: " . $endpoint);
error_log("ID: " . ($id ?? 'null'));

// If accessing root, show welcome message
if (empty($endpoint) || $endpoint === 'index.php') {
    $response->send([
        'message' => 'Products API is running!',
        'endpoints' => [
            'GET /products' => 'Get all products',
            'GET /products/{id}' => 'Get single product',
            'POST /products' => 'Create new product',
            'PUT /products/{id}' => 'Update product',
            'DELETE /products/{id}' => 'Delete product'
        ],
        'test_links' => [
            'Get all products' => '/products_api/public/products',
            'Get product by ID' => '/products_api/public/products/1'
        ]
    ]);
    exit;
}

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if ($endpoint === 'products') {
                if ($id) {
                    $controller->getSingleProduct($id);
                } else {
                    $controller->getAllProducts();
                }
            } else {
                $response->sendError(404, "Endpoint '$endpoint' not found. Available: /products");
            }
            break;

        case 'POST':
            if ($endpoint === 'products') {
                $controller->createProduct();
            } else {
                $response->sendError(404, "Endpoint not found");
            }
            break;

        case 'PUT':
            if ($endpoint === 'products' && $id) {
                $controller->updateProduct($id);
            } else {
                $response->sendError(404, "Endpoint not found");
            }
            break;

        case 'DELETE':
            if ($endpoint === 'products' && $id) {
                $controller->deleteProduct($id);
            } else {
                $response->sendError(404, "Endpoint not found");
            }
            break;

        default:
            $response->sendError(405, "Method not allowed");
            break;
    }
} catch (Exception $e) {
    $response->sendError(500, "Server error: " . $e->getMessage());
}
?>