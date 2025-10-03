# 🛒 Products API

RESTful API สำหรับจัดการข้อมูลสินค้า รองรับการดึงข้อมูล, เพิ่ม, แก้ไข และลบข้อมูลสินค้า พร้อมระบบกรองและค้นหาข้อมูลขั้นสูง

---

## 📑 สารบัญ

- [คุณสมบัติหลัก](#-คุณสมบัติหลัก)
- [โครงสร้างฐานข้อมูล](#-โครงสร้างฐานข้อมูล)
- [API Endpoints](#-api-endpoints)
- [ตัวอย่างการใช้งาน](#-ตัวอย่างการใช้งาน)
- [HTTP Status Codes](#-http-status-codes)

---

## ✨ คุณสมบัติหลัก

- ✅ CRUD Operations (Create, Read, Update, Delete)
- 🔍 ค้นหาสินค้าจากชื่อและคำอธิบาย
- 🏷️ กรองตามหมวดหมู่, ราคา, คะแนน
- 📊 เรียงลำดับข้อมูล (ราคา, คะแนน, ชื่อ)
- 📄 Pagination สำหรับจัดการข้อมูลจำนวนมาก

---

## 📊 โครงสร้างฐานข้อมูล

### ตาราง `products`

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT (PK, AUTO_INCREMENT) | รหัสสินค้า |
| `title` | VARCHAR(200) | ชื่อสินค้า |
| `price` | DECIMAL(10,2) | ราคา (บาท) |
| `description` | TEXT | คำอธิบายสินค้า |
| `category` | VARCHAR(100) | หมวดหมู่ (electronics, clothing, books, etc.) |
| `image` | VARCHAR(500) | URL รูปภาพสินค้า |
| `rating_rate` | DECIMAL(3,2) | คะแนนรีวิว (0.00-5.00) |
| `rating_count` | INT | จำนวนรีวิว |
| `created_at` | TIMESTAMP | วันที่สร้างข้อมูล |
| `updated_at` | TIMESTAMP | วันที่แก้ไขล่าสุด |

---

## 🔌 API Endpoints

### 1️⃣ ดูสินค้าทั้งหมด

```http
GET /products
```

#### Query Parameters

| Parameter | Type | Description | Example |
|-----------|------|-------------|---------|
| `category` | string | กรองตามหมวดหมู่ | `electronics`, `clothing`, `books` |
| `min_price` | float | ราคาต่ำสุด | `500` |
| `max_price` | float | ราคาสูงสุด | `50000` |
| `min_rating` | float | คะแนนต่ำสุด | `4.0` |
| `search` | string | ค้นหาจากชื่อ/คำอธิบาย | `iphone` |
| `sort` | string | เรียงลำดับ | `price_asc`, `price_desc`, `rating_desc`, `title_asc` |
| `page` | integer | เลขหน้า (default=1) | `2` |
| `per_page` | integer | จำนวนต่อหน้า (default=10) | `5` |

#### ตัวอย่างการใช้งาน

**ดูสินค้าทั้งหมด:**
```http
GET http://localhost/products_api/public/products
```

**ดูสินค้า Electronics ที่มีคะแนนสูงกว่า 4.5:**
```http
GET http://localhost/products_api/public/products?category=electronics&min_rating=4.5&sort=rating_desc
```

**ดูสินค้าราคา 1,000-50,000 บาท:**
```http
GET http://localhost/products_api/public/products?min_price=1000&max_price=50000&sort=price_asc
```

**ค้นหาสินค้ามีคำว่า "iphone":**
```http
GET http://localhost/products_api/public/products?search=iphone
```

**ใช้งานพร้อม Pagination:**
```http
GET http://localhost/products_api/public/products?page=2&per_page=5
```

---

### 2️⃣ ดูสินค้าตาม ID

```http
GET /products/{id}
```

#### ตัวอย่าง

```http
GET http://localhost/products_api/public/products/1
```

---

### 3️⃣ เพิ่มสินค้าใหม่

```http
POST /products
Content-Type: application/json
```

#### Request Body

```json
{
    "title": "Samsung Galaxy S24 Ultra",
    "price": 38900.00,
    "description": "สมาร์ทโฟนรุ่นเรือธงจากซัมซุง",
    "category": "electronics",
    "image": "https://example.com/s24-ultra.jpg",
    "rating_rate": 4.7,
    "rating_count": 89
}
```

#### ตัวอย่างการเรียกใช้

```http
POST http://localhost/products_api/public/products
Content-Type: application/json

{
    "title": "Samsung Galaxy S24 Ultra",
    "price": 38900.00,
    "description": "สมาร์ทโฟนรุ่นเรือธงจากซัมซุง",
    "category": "electronics",
    "image": "https://example.com/s24-ultra.jpg",
    "rating_rate": 4.7,
    "rating_count": 89
}
```

---

### 4️⃣ แก้ไขข้อมูลสินค้า

```http
PUT /products/{id}
PATCH /products/{id}
Content-Type: application/json
```

#### ตัวอย่าง

**แก้ไขราคาและคำอธิบาย:**
```http
PUT http://localhost/products_api/public/products/1
Content-Type: application/json

{
    "price": 32900.00,
    "description": "ราคาพิเศษ Limited Time Only"
}
```

**อัพเดทคะแนนรีวิว:**
```http
PATCH http://localhost/products_api/public/products/1
Content-Type: application/json

{
    "rating_rate": 4.8,
    "rating_count": 150
}
```

---

### 5️⃣ ลบสินค้า

```http
DELETE /products/{id}
```

#### ตัวอย่าง

```http
DELETE http://localhost/products_api/public/products/26
```

---

## 🎯 ตัวอย่างการใช้งาน

### ค้นหาสินค้า Electronics ที่มีคะแนนสูง

```http
GET http://localhost/products_api/public/products?category=electronics&min_rating=4.5&sort=rating_desc
```

### ดูสินค้าราคาประหยัด

```http
GET http://localhost/products_api/public/products?max_price=2000&sort=price_asc
```

### เพิ่มสินค้าใหม่

```http
POST http://localhost/products_api/public/products
Content-Type: application/json

{
    "title": "iPad Air 5th Gen",
    "price": 22900.00,
    "description": "iPad Air รุ่นล่าสุดด้วยชิป M1",
    "category": "electronics",
    "image": "https://example.com/ipad-air.jpg",
    "rating_rate": 4.6,
    "rating_count": 45
}
```

### ลดราคาสินค้า

```http
PUT http://localhost/products_api/public/products/5
Content-Type: application/json

{
    "price": 19900.00
}
```

### ค้นหาสินค้ามีคำว่า "macbook"

```http
GET http://localhost/products_api/public/products?search=macbook
```

---

## ⚠️ HTTP Status Codes

| Status Code | Description |
|-------------|-------------|
| `200` | สำเร็จ (OK) |
| `201` | สร้างสำเร็จ (Created) |
| `400` | ข้อมูลไม่ถูกต้อง (Bad Request) |
| `404` | ไม่พบข้อมูล (Not Found) |
| `405` | Method ไม่รองรับ (Method Not Allowed) |
| `409` | ข้อมูลซ้ำ (Conflict) |
| `500` | เกิดข้อผิดพลาดบนเซิร์ฟเวอร์ (Internal Server Error) |

---

## 📸 ภาพตัวอย่างการทดสอบ

### GET All Products
![GET All Products](https://github.com/user-attachments/assets/8cbace46-8afa-45c7-948f-be186bb8956a)

### GET Product by ID
![GET Product by ID](https://github.com/user-attachments/assets/82301e61-d40f-4d45-8f93-00eb6cd2d69b)

### POST Create Product
![POST Create Product](https://github.com/user-attachments/assets/1b3605ff-eae9-4aa4-a17d-3feb0ec99728)

### PUT Update Product
![PUT Update Product](https://github.com/user-attachments/assets/85eddda3-737a-4897-a787-778b55c3ab17)

### DELETE Product
![DELETE Product](https://github.com/user-attachments/assets/9e4b345e-2b44-4689-ae99-cc645d1463f1)

### API Browser
![API Browser](https://github.com/user-attachments/assets/1a842b4a-00c4-44ce-b5af-7e9f891a135f)

---

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

---

## 👨‍💻 Author

สร้างด้วย ❤️ โดย [Your Name]
