Products API - RESTful API สำหรับจัดการข้อมูลสินค้า
📖 รายละเอียด
REST API สำหรับจัดการฐานข้อมูลสินค้า รองรับการดึงข้อมูล, เพิ่ม, แก้ไข และลบข้อมูลสินค้า พร้อมระบบกรองและค้นหาข้อมูลขั้นสูง

1️⃣ ดูสินค้าทั้งหมด
GET /products

Query Parameters
Parameter	Type	Description	Example
category	string	กรองตามหมวดหมู่	electronics, clothing, books
min_price	float	ราคาต่ำสุด	500
max_price	float	ราคาสูงสุด	50000
min_rating	float	คะแนนต่ำสุด	4.0
search	string	ค้นหาจากชื่อสินค้าหรือคำอธิบาย	iphone
sort	string	เรียงลำดับ	price_asc, price_desc, rating_desc, title_asc
page	integer	หน้าที่ต้องการ	1 (default)
per_page	integer	จำนวนต่อหน้า	10 (default)
ตัวอย่างการเรียกใช้
ดูสินค้าทั้งหมด

text
GET http://localhost/products_api/public/products
ดูสินค้า Electronics ที่มีคะแนนสูงกว่า 4.5

text
GET http://localhost/products_api/public/products?category=electronics&min_rating=4.5&sort=rating_desc
ดูสินค้าราคา 1000-50000 บาท

text
GET http://localhost/products_api/public/products?min_price=1000&max_price=50000&sort=price_asc
ค้นหาสินค้ามีคำว่า "iphone"

text
GET http://localhost/products_api/public/products?search=iphone
ดูสินค้าทั้งหมดพร้อม pagination

text
GET http://localhost/products_api/public/products?page=2&per_page=5
2️⃣ ดูสินค้าตาม ID
GET /products/{id}

ตัวอย่างการเรียกใช้
text
GET http://localhost/products_api/public/products/1
3️⃣ เพิ่มสินค้าใหม่
POST /products

Request Headers
text
Content-Type: application/json
ตัวอย่างการเรียกใช้
text
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
PUT /products/{id} หรือ PATCH /products/{id}

Request Headers
text
Content-Type: application/json
ตัวอย่างการเรียกใช้
แก้ไขราคาและคำอธิบาย

text
PUT http://localhost/products_api/public/products/1
Content-Type: application/json

{
    "price": 32900.00,
    "description": "ราคาพิเศษ Limited Time Only"
}
อัพเดทคะแนนรีวิว

text
PATCH http://localhost/products_api/public/products/1
Content-Type: application/json

{
    "rating_rate": 4.8,
    "rating_count": 150
}
5️⃣ ลบสินค้า
DELETE /products/{id}

ตัวอย่างการเรียกใช้
text
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
ตัวอย่างที่ 1: ค้นหาสินค้า Electronics ที่มีคะแนนสูง
text
GET http://localhost/products_api/public/products?category=electronics&min_rating=4.5&sort=rating_desc
ตัวอย่างที่ 2: ดูสินค้าราคาประหยัด
text
GET http://localhost/products_api/public/products?max_price=2000&sort=price_asc
ตัวอย่างที่ 3: เพิ่มสินค้าใหม่
text
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
ตัวอย่างที่ 4: ลดราคาสินค้า
text
PUT http://localhost/products_api/public/products/5
Content-Type: application/json

{
    "price": 19900.00
}
ตัวอย่างที่ 5: ค้นหาสินค้ามีคำว่า "macbook"
text

GET http://localhost/products_api/public/products?search=macbook
📸 ภาพตัวอย่างการทดสอบ
1. GET All Products
ดึงข้อมูลสินค้าทั้งหมดในระบบ

text
GET http://localhost/products_api/public/products
2. GET Product by ID
ดึงข้อมูลสินค้าตาม ID ที่ระบุ

text
GET http://localhost/products_api/public/products/1
3. POST Create Product
เพิ่มสินค้าใหม่เข้าสู่ระบบ

text
POST http://localhost/products_api/public/products
4. PUT Update Product
แก้ไขข้อมูลสินค้าที่มีอยู่

text
PUT http://localhost/products_api/public/products/1
5. DELETE Product
ลบสินค้าออกจากระบบ

text
DELETE http://localhost/products_api/public/products/26
6. GET with Filters
ค้นหาและกรองข้อมูลสินค้า

text
http://localhost/products_api/public/products
7. api browser
ดึงข้อมูลสินค้าทั้งหมดในระบบ


text
GET http://localhost/products_api/public/products?category=electronics&min_price=10000&max_price=50000&sort=price_asc
⚠️ HTTP Status Codes
Status Code	Description
200	สำเร็จ (OK)
201	สร้างสำเร็จ (Created)
400	ข้อมูลไม่ถูกต้อง (Bad Request)
404	ไม่พบข้อมูล (Not Found)
405	Method ไม่รองรับ (Method Not Allowed)
409	ข้อมูลซ้ำ (Conflict)
500	เกิดข้อผิดพลาดบนเซิร์ฟเวอร์ (Internal Server Error)
