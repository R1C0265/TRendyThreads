-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 11, 2023 at 01:56 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jk_productions`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `cart_state` int NOT NULL COMMENT '0 - no items in cart\r\n1 - items in cart\r\n2 - items sold from cart',
  `cartDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `purchase_id` int DEFAULT NULL,
  `product_amount_added` int NOT NULL,
  `u_id` int NOT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `cart_product_constraint` (`product_id`),
  KEY `cart_purchase_constraint` (`purchase_id`),
  KEY `cart_customer_constraint` (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `product_id`, `cart_state`, `cartDate`, `purchase_id`, `product_amount_added`, `u_id`) VALUES
(2, 1, 1, '2023-07-05 12:09:26', NULL, 20, 31),
(3, 2, 1, '2023-07-07 06:40:05', NULL, 5, 31);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` text NOT NULL,
  `product_amount` text NOT NULL,
  `product_category` text NOT NULL,
  `product_price` text NOT NULL,
  `product_image_location` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '../images/products/shoppin_cart%202.png',
  `product_image_alt` varchar(124) DEFAULT 'an image of your selected product',
  `product_description` text,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_amount`, `product_category`, `product_price`, `product_image_location`, `product_image_alt`, `product_description`) VALUES
(1, 'JK Golf Shirts', '200', 'Golf Shirts', '15000', '../images/products/jk golf shirt.jpeg', NULL, NULL),
(2, 'JK T-Shirts', '190', 'T-Shirts', '15000', '../images/products/OIF.jfif', NULL, NULL),
(3, 'Puma Soccer Boots', '20', 'Soccer Boots', '65000', '../images/products/download.jfif', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE IF NOT EXISTS `purchases` (
  `purchase_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `purchase_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `u_id` int NOT NULL AUTO_INCREMENT,
  `u_name` varchar(50) NOT NULL,
  `u_email` varchar(70) NOT NULL,
  `u_password` varchar(70) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '70352f41061eda4ff3c322094af068ba70c3b38b',
  `u_type` int NOT NULL COMMENT '1-admin, 2-jk_productions, 3-customer, ',
  `u_img` varchar(70) NOT NULL DEFAULT 'user.svg',
  `u_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_email`, `u_password`, `u_type`, `u_img`, `u_stamp`) VALUES
(1, 'Kondwani Chimatiro', 'kho@gmail.com', '70352f41061eda4ff3c322094af068ba70c3b38b', 1, 'user.svg', '2021-07-05 08:38:40'),
(2, 'Susan Chinyama', 'susanchinyama@gmail.com', '70352f41061eda4ff3c322094af068ba70c3b38b', 1, 'user.svg', '2021-07-05 08:38:35'),
(3, 'Clifford Ghambi', 'cliffordghambi@gmail.com', '70352f41061eda4ff3c322094af068ba70c3b38b', 2, 'photo_2021-03-11_16-32-22.jpg', '2021-07-05 08:38:35'),
(4, 'Tchilli Alindiamawo', 'Tchillialindiamawo@gmail.com', '70352f41061eda4ff3c322094af068ba70c3b38b', 2, 'photo_2021-03-18_16-01-12.jpg', '2021-07-05 08:26:11'),
(5, 'Eric Kabambe', 'erickabambe@gmail.com', '70352f41061eda4ff3c322094af068ba70c3b38b', 3, 'photo_2021-03-18_16-01-12.jpg', '2021-07-05 08:26:11'),
(6, 'Jimmy Kazembe', 'jimmykazembe@gmail.com', '70352f41061eda4ff3c322094af068ba70c3b38b', 3, 'photo_2021-03-18_16-01-12.jpg', '2021-07-05 08:26:11'),
(31, 'John Kittle', 'jk@gmail.com', '70352f41061eda4ff3c322094af068ba70c3b38b', 3, 'user.svg', '2022-06-01 12:03:46'),
(33, 'rico', 'admin@admin.admin', '70352f41061eda4ff3c322094af068ba70c3b38b', 2, 'user.svg', '2022-06-01 12:30:59'),
(34, 'RR', 'rr@gmail.com', '70352f41061eda4ff3c322094af068ba70c3b38b', 3, 'user.svg', '2022-06-06 13:14:40'),
(36, 'Chadwick Boseman', 'bd@gmail.com', '70352f41061eda4ff3c322094af068ba70c3b38b', 3, 'user.svg', '2022-06-06 20:35:48'),
(37, 'Tough Bwana', 'zgr@gmail.com', '70352f41061eda4ff3c322094af068ba70c3b38b', 3, 'user.svg', '2022-06-06 20:35:49');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_customer_constraint` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`),
  ADD CONSTRAINT `cart_product_constraint` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `cart_purchase_constraint` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`purchase_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
