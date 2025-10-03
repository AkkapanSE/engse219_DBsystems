-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 03, 2025 at 06:25 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webapi_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL CHECK (`price` >= 0),
  `description` text DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `image` varchar(500) DEFAULT NULL,
  `rating_rate` decimal(3,2) DEFAULT 0.00 CHECK (`rating_rate` >= 0 and `rating_rate` <= 5),
  `rating_count` int(11) DEFAULT 0 CHECK (`rating_count` >= 0),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `description`, `category`, `image`, `rating_rate`, `rating_count`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 15 Pro', 34900.00, 'iPhone 15 Pro với titanium grade 5', 'electronics', 'https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg', 4.80, 120, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(2, 'Samsung Galaxy S24', 29900.00, 'สมาร์ทโฟนสุดล้ำกับ AI', 'electronics', 'https://fakestoreapi.com/img/71-3HjGNDUL._AC_SY879._SX._UX._SY._UY_.jpg', 4.60, 89, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(3, 'MacBook Air M3', 42900.00, 'แลปท็อปเบาสุดพลังด้วยชิป M3', 'electronics', 'https://fakestoreapi.com/img/71li-ujtlUL._AC_UX679_.jpg', 4.90, 67, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(4, 'iPad Pro 12.9', 37900.00, 'iPad Pro ขนาด 12.9 นิ้ว', 'electronics', 'https://fakestoreapi.com/img/71YXzeOuslL._AC_UY879_.jpg', 4.70, 45, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(5, 'AirPods Pro', 9900.00, 'หูฟังไร้สายสุดพรีเมียม', 'electronics', 'https://fakestoreapi.com/img/71pWzhdJNwL._AC_UL640_QL65_ML3_.jpg', 4.50, 156, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(6, 'Nike Air Force 1', 4200.00, 'รองเท้าแบสketball คลาสสิก', 'clothing', 'https://fakestoreapi.com/img/61pHAEJ4NML._AC_UX679_.jpg', 4.30, 78, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(7, 'Adidas Ultraboost', 5600.00, 'รองเท้าวิ่งเทคโนโลยี Boost', 'clothing', 'https://fakestoreapi.com/img/61IBBVJvSDL._AC_SY879_.jpg', 4.60, 92, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(8, 'Levi\'s 511 Jeans', 1900.00, 'กางเกงยีนส์ฟิตตรง', 'clothing', 'https://fakestoreapi.com/img/61U7T1koQqL._AC_SX679_.jpg', 4.20, 34, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(9, 'Uniqlo T-Shirt', 390.00, 'เสื้อทีเชิ้ตคอตตอน 100%', 'clothing', 'https://fakestoreapi.com/img/71HblAHs5xL._AC_UY879_-2.jpg', 4.00, 123, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(10, 'The Lord of the Rings', 650.00, 'นวนิยายแฟนตาซีคลาสสิก', 'books', 'https://fakestoreapi.com/img/71kWymZ+c+L._AC_UX679_.jpg', 4.90, 56, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(11, 'Harry Potter Collection', 3200.00, 'ชุดหนังสือแฮร์รี่ พอตเตอร์', 'books', 'https://fakestoreapi.com/img/61mtL65D4cL._AC_SX679_.jpg', 4.80, 78, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(12, 'Python Programming', 850.00, 'หนังสือเรียนการเขียนโปรแกรม Python', 'books', 'https://fakestoreapi.com/img/61U7T1koQqL._AC_SX679_.jpg', 4.40, 23, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(13, 'IKEA Desk', 4500.00, 'โต๊ะทำงานไม้ลามิเนต', 'furniture', 'https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg', 4.10, 45, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(14, 'Office Chair', 3200.00, 'เก้าอี้ออฟฟิศปรับระดับได้', 'furniture', 'https://fakestoreapi.com/img/71-3HjGNDUL._AC_SY879._SX._UX._SY._UY_.jpg', 4.30, 67, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(15, 'Bookshelf', 2800.00, 'ตู้หนังสือไม้ 5 ชั้น', 'furniture', 'https://fakestoreapi.com/img/71li-ujtlUL._AC_UX679_.jpg', 4.20, 34, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(16, 'Sony WH-1000XM4', 8900.00, 'หูฟังไร้สายลดเสียงรบกวน', 'electronics', 'https://fakestoreapi.com/img/71YXzeOuslL._AC_UY879_.jpg', 4.70, 89, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(17, 'Canon EOS R6', 68900.00, 'กล้องมิเรอร์เลส full-frame', 'electronics', 'https://fakestoreapi.com/img/71pWzhdJNwL._AC_UL640_QL65_ML3_.jpg', 4.80, 23, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(18, 'PlayStation 5', 17900.00, 'คอนโซลเกมรุ่นล่าสุด', 'electronics', 'https://fakestoreapi.com/img/61pHAEJ4NML._AC_UX679_.jpg', 4.90, 156, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(19, 'Xbox Series X', 16900.00, 'คอนโซลเกมจาก Microsoft', 'electronics', 'https://fakestoreapi.com/img/61IBBVJvSDL._AC_SY879_.jpg', 4.70, 78, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(20, 'Nintendo Switch', 12900.00, 'คอนโซลเกมแบบพกพา', 'electronics', 'https://fakestoreapi.com/img/61U7T1koQqL._AC_SX679_.jpg', 4.60, 92, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(21, 'Samsung 4K TV', 25900.00, 'ทีวี 4K ขนาด 55 นิ้ว', 'electronics', 'https://fakestoreapi.com/img/71HblAHs5xL._AC_UY879_-2.jpg', 4.50, 45, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(22, 'Dell Monitor', 8900.00, 'จอคอมพิวเตอร์ 27 นิ้ว', 'electronics', 'https://fakestoreapi.com/img/71kWymZ+c+L._AC_UX679_.jpg', 4.30, 67, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(23, 'Logitech Keyboard', 2200.00, 'คีย์บอร์ด mechanical', 'electronics', 'https://fakestoreapi.com/img/61mtL65D4cL._AC_SX679_.jpg', 4.40, 89, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(24, 'Apple Watch Series 9', 15900.00, 'นาฬิกาสมาร์ทจาก Apple', 'electronics', 'https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg', 4.60, 56, '2025-10-03 03:02:50', '2025-10-03 03:02:50'),
(25, 'Kindle Paperwhite', 5900.00, 'เครื่องอ่านหนังสืออิเล็กทรอนิกส์', 'electronics', 'https://fakestoreapi.com/img/71-3HjGNDUL._AC_SY879._SX._UX._SY._UY_.jpg', 4.50, 78, '2025-10-03 03:02:50', '2025-10-03 03:02:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
