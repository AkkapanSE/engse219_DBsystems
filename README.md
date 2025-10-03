# 🛒 Products API - RESTful API สำหรับจัดการข้อมูลสินค้า

## 📖 รายละเอียด
REST API สำหรับจัดการฐานข้อมูลสินค้า รองรับการ **ดึงข้อมูล, เพิ่ม, แก้ไข และลบข้อมูลสินค้า**  
พร้อมระบบ **กรองและค้นหาข้อมูลขั้นสูง**

---

## 1️⃣ ดูสินค้าทั้งหมด
**Endpoint:**  
GET /products

php
คัดลอกโค้ด

### Query Parameters
| Parameter   | Type     | Description                     | Example        |
|-------------|----------|---------------------------------|----------------|
| category    | string   | กรองตามหมวดหมู่               | electronics, clothing, books |
| min_price   | float    | ราคาต่ำสุด                     | 500            |
| max_price   | float    | ราคาสูงสุด                     | 50000          |
| min_rating  | float    | คะแนนต่ำสุด                    | 4.0            |
| search      | string   | ค้นหาจากชื่อ/คำอธิบายสินค้า    | iphone         |
| sort        | string   | เรียงลำดับ                     | price_asc, price_desc, rating_desc, title_asc |
| page        | integer  | เลขหน้า (default=1)            | 2              |
| per_page    | integer  | จำนวนต่อหน้า (default=10)      | 5              |

### ตัวอย่างการเรียกใช้
- ดูสินค้าทั้งหมด
```http
GET http://localhost/products_api/public/products
ดูสินค้า Electronics ที่มีคะแนนสูงกว่า 4.5

http
คัดลอกโค้ด
GET http://localhost/products_api/public/products?category=electronics&min_rating=4.5&sort=rating_desc
ดูสินค้าราคา 1000-50000 บาท

http
คัดลอกโค้ด
GET http://localhost/products_api/public/products?min_price=1000&max_price=50000&sort=price_asc
ค้นหาสินค้ามีคำว่า "iphone"

http
คัดลอกโค้ด
GET http://localhost/products_api/public/products?search=iphone
ดูสินค้าทั้งหมดพร้อม pagination

http
คัดลอกโค้ด
GET http://localhost/products_api/public/products?page=2&per_page=5
2️⃣ ดูสินค้าตาม ID
Endpoint:

bash
คัดลอกโค้ด
GET /products/{id}
ตัวอย่าง
http
คัดลอกโค้ด
GET http://localhost/products_api/public/products/1
3️⃣ เพิ่มสินค้าใหม่
Endpoint:

bash
คัดลอกโค้ด
POST /products
Headers:

pgsql
คัดลอกโค้ด
Content-Type: application/json
ตัวอย่าง
http
คัดลอกโค้ด
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
4️⃣ แก้ไขข้อมูลสินค้า
Endpoint:

bash
คัดลอกโค้ด
PUT /products/{id}
PATCH /products/{id}
Headers:

pgsql
คัดลอกโค้ด
Content-Type: application/json
ตัวอย่าง
แก้ไขราคาและคำอธิบาย

http
คัดลอกโค้ด
PUT http://localhost/products_api/public/products/1
Content-Type: application/json

{
    "price": 32900.00,
    "description": "ราคาพิเศษ Limited Time Only"
}
อัพเดทคะแนนรีวิว

http
คัดลอกโค้ด
PATCH http://localhost/products_api/public/products/1
Content-Type: application/json

{
    "rating_rate": 4.8,
    "rating_count": 150
}
5️⃣ ลบสินค้า
Endpoint:

bash
คัดลอกโค้ด
DELETE /products/{id}
ตัวอย่าง
http
คัดลอกโค้ด
DELETE http://localhost/products_api/public/products/26
📊 โครงสร้างฐานข้อมูล
ตาราง products

Column	Type	Description
id	INT (PK, AUTO_INCREMENT)	รหัสสินค้า
title	VARCHAR(200)	ชื่อสินค้า
price	DECIMAL(10,2)	ราคา
description	TEXT	คำอธิบายสินค้า
category	VARCHAR(100)	หมวดหมู่
image	VARCHAR(500)	ลิงก์รูปภาพ
rating_rate	DECIMAL(3,2)	คะแนนรีวิว (0-5)
rating_count	INT	จำนวนรีวิว
created_at	TIMESTAMP	วันที่สร้าง
updated_at	TIMESTAMP	วันที่แก้ไขล่าสุด

🎯 ตัวอย่างการใช้งาน
ค้นหาสินค้า Electronics ที่มีคะแนนสูง

http
คัดลอกโค้ด
GET http://localhost/products_api/public/products?category=electronics&min_rating=4.5&sort=rating_desc
ดูสินค้าราคาประหยัด

http
คัดลอกโค้ด
GET http://localhost/products_api/public/products?max_price=2000&sort=price_asc
เพิ่มสินค้าใหม่

http
คัดลอกโค้ด
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
ลดราคาสินค้า

http
คัดลอกโค้ด
PUT http://localhost/products_api/public/products/5
Content-Type: application/json

{
    "price": 19900.00
}
ค้นหาสินค้ามีคำว่า "macbook"

http
คัดลอกโค้ด
GET http://localhost/products_api/public/products?search=macbook
📸 ภาพตัวอย่างการทดสอบ
GET All Products
<img width="1788" height="1448" alt="image" src="https://github.com/user-attachments/assets/8cbace46-8afa-45c7-948f-be186bb8956a" />

GET Product by ID
<img width="1534" height="1170" alt="image" src="https://github.com/user-attachments/assets/82301e61-d40f-4d45-8f93-00eb6cd2d69b" />

POST Create Product
<img width="1534" height="1170" alt="image" src="https://github.com/user-attachments/assets/1b3605ff-eae9-4aa4-a17d-3feb0ec99728" />

PUT Update Product
<img width="1684" height="1286" alt="image" src="https://github.com/user-attachments/assets/85eddda3-737a-4897-a787-778b55c3ab17" />

DELETE Product
<img width="1138" height="1056" alt="image" src="https://github.com/user-attachments/assets/9e4b345e-2b44-4689-ae99-cc645d1463f1" />

API Browser
<img width="1730" height="470" alt="image" src="https://github.com/user-attachments/assets/1a842b4a-00c4-44ce-b5af-7e9f891a135f" />

⚠️ HTTP Status Codes
Status Code	Description
200	สำเร็จ (OK)
201	สร้างสำเร็จ (Created)
400	ข้อมูลไม่ถูกต้อง (Bad Request)
404	ไม่พบข้อมูล (Not Found)
405	Method ไม่รองรับ (Method Not Allowed)
409	ข้อมูลซ้ำ (Conflict)
500	เกิดข้อผิดพลาดบนเซิร์ฟเวอร์ (Internal Server Error)

