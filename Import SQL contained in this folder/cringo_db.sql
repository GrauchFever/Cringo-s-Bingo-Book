-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 09:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cringo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(35) NOT NULL,
  `user_surname` varchar(35) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(10) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`user_id`, `user_name`, `user_surname`, `user_email`, `user_phone`, `user_password`) VALUES
(1, 'Gerhard', 'Rauch', 'gerhard.dreyer.rauch@gmail.com', '0646533348', '$2y$10$mf.yK.wErPM/hvCLFj8UKuh2I6aFGkXZ6zGLhBbOUEtV9rP17.TRi');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_category` varchar(100) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `user_id`, `product_name`, `product_description`, `product_price`, `product_category`, `stock_quantity`, `image_url`, `date_added`, `is_active`) VALUES
(1, 1, 'The Ball Man', 'This man has invented ball scratching techniques beyond your imagination', 250.00, 'Other', 1, 'uploads/products/product_6842795f6c1f66.45536421.png', '2025-06-06 07:15:11', 1),
(6, 1, 'The Shrimp Man', 'This is an Absolute Shrinema moment, everyone. Best day of my life I\'ve had.', 500.00, 'Other', 1, 'uploads/products/product_6842a2fb40de00.59472209.png', '2025-06-06 10:12:43', 1),
(7, 1, 'Are you sure?', 'Are you sure?\r\nAre you sure?\r\nAre you sure?\r\nAre you sure?\r\nAre you sure?', 20.00, 'Other', 5, 'uploads/products/product_6842b81418cab9.54450777.png', '2025-06-06 11:42:44', 1),
(8, 1, 'Bnnuy', 'This is a bunny from an animation found on youtube. Can\'t remember the exact video\'s name, but it looks ps2-esque. So maybe that\'s enough info', 10.00, 'Other', 1, 'uploads/products/product_6843f8bbc77ad4.39152852.png', '2025-06-07 10:30:51', 1),
(9, 1, 'V1 Coin', 'I\'ve been playing Ultrakill a lot lately, and it does actually become pretty easy once you get used to it. Just don\'t be afraid when your health gets low, because if you hesitate, you die.', 29.00, 'Other', 1, 'uploads/products/product_6843f90eaac298.57159563.webp', '2025-06-07 10:32:14', 1),
(10, 1, 'Half Price', 'Unlike the title, this product is not, in fact, at half price. Sorry to disappoint you.', 1000.00, 'Other', 1, 'uploads/products/product_68442b32554388.94408375.png', '2025-06-07 14:06:10', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
