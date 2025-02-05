-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2025 at 05:09 PM
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
-- Database: `projectcsad`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_topups`
--

CREATE TABLE `account_topups` (
  `topup_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topup_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('credit_card','debit_card','paypal','cash','other') NOT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `topup_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed','failed') DEFAULT 'completed',
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_courts`
--

CREATE TABLE `food_courts` (
  `food_court_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_courts`
--

INSERT INTO `food_courts` (`food_court_id`, `name`, `location`, `contact_number`, `image_path`) VALUES
(1, 'Food Court 1', 'Level 2\r\nT3B', NULL, NULL),
(2, 'Food Court 2', 'Level 1 T1A', NULL, NULL),
(3, 'Food Court 3', 'Poly Centre', NULL, NULL),
(4, 'Food Court 4', 'Level 1 T18A', NULL, NULL),
(5, 'Food Court 5', 'SP Arena', NULL, NULL),
(6, 'Food Court 6', 'Level 2 T22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `food_item_id` int(11) NOT NULL,
  `food_court_id` int(11) DEFAULT NULL,
  `food_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `stall_id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `buy_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`food_item_id`, `food_court_id`, `food_name`, `description`, `price`, `category`, `stall_id`, `image_path`, `buy_count`) VALUES
(7, 1, 'Steamed Chicken Rice', '', 1.50, NULL, 1, '../uploads/Steamed_Chicken_Rice.jpg', NULL),
(9, 2, 'Nasi Padang', '', 2.50, NULL, 5, '../uploads/nasi-padang.jpg', NULL),
(10, 1, 'Roasted Chicken Rice', '', 2.50, NULL, 1, NULL, NULL),
(16, 1, 'Soup', '', 1.00, NULL, 1, NULL, NULL),
(17, 1, '1/2 Chicken', '', 8.00, NULL, 1, NULL, NULL),
(18, 1, 'Chicken Rice Value Set', '', 4.00, NULL, 1, '../uploads/unknown_food.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `food_stalls`
--

CREATE TABLE `food_stalls` (
  `stall_id` int(11) NOT NULL,
  `stall_name` varchar(100) NOT NULL,
  `food_court_id` int(11) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `availability` enum('Open','Closed','Temporarily Closed') DEFAULT 'Open',
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stall_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_stalls`
--

INSERT INTO `food_stalls` (`stall_id`, `stall_name`, `food_court_id`, `contact_number`, `availability`, `opening_time`, `closing_time`, `description`, `stall_picture`) VALUES
(1, 'Chicken Rice', 1, NULL, 'Open', '11:00:00', '17:00:00', NULL, NULL),
(5, 'Nasi Padang', 2, NULL, 'Open', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `most_ordered`
--

CREATE TABLE `most_ordered` (
  `most_ordered_id` int(11) NOT NULL,
  `food_item_id` int(11) NOT NULL,
  `food_court_id` int(11) NOT NULL,
  `order_count` int(11) NOT NULL DEFAULT 0,
  `last_updated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending',
  `payment_method` varchar(50) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `tracking_id` varchar(255) NOT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `status`, `payment_method`, `order_date`, `tracking_id`, `reason`) VALUES
(43, 1, 2.50, 'Completed', 'Credit Card', '2025-01-31 01:55:53', 'ORDER_679BBD2980C2D', NULL),
(44, 1, 3.00, 'Completed', 'Credit Card', '2025-01-31 01:58:01', 'ORDER_679BBDA905A12', NULL),
(45, 1, 1.50, 'Pending', 'Credit Card', '2025-01-31 02:13:21', 'ORDER_679BC141EDFE5', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `food_item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `food_item_id`, `quantity`, `price`) VALUES
(45, 43, 9, 1, 2.50),
(46, 44, 7, 2, 1.50),
(47, 45, 7, 1, 1.50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `account_balance` decimal(10,2) DEFAULT 0.00,
  `roles` varchar(15) DEFAULT NULL,
  `stall_id` int(11) DEFAULT NULL,
  `food_court_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `phone`, `profile_picture`, `account_balance`, `roles`, `stall_id`, `food_court_id`) VALUES
(1, 'test', 'test@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', '12345', '../uploads/profile_pic.jpg', 38.50, 'customer', NULL, NULL),
(2, 'test2', '', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 1, 1),
(5, 'test3', 'aa', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, 0.00, 'customer', NULL, NULL),
(7, 'test4', 'tt', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, 0.00, 'vendor', 5, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_topups`
--
ALTER TABLE `account_topups`
  ADD PRIMARY KEY (`topup_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `food_courts`
--
ALTER TABLE `food_courts`
  ADD PRIMARY KEY (`food_court_id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`food_item_id`),
  ADD KEY `stall_id` (`stall_id`),
  ADD KEY `food_court_id` (`food_court_id`);

--
-- Indexes for table `food_stalls`
--
ALTER TABLE `food_stalls`
  ADD PRIMARY KEY (`stall_id`),
  ADD KEY `food_stalls_ibfk_1` (`food_court_id`);

--
-- Indexes for table `most_ordered`
--
ALTER TABLE `most_ordered`
  ADD PRIMARY KEY (`most_ordered_id`),
  ADD KEY `food_item_id` (`food_item_id`),
  ADD KEY `food_court_id` (`food_court_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `food_item_id` (`food_item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `stall_id` (`stall_id`),
  ADD KEY `food_court_id` (`food_court_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_topups`
--
ALTER TABLE `account_topups`
  MODIFY `topup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `food_courts`
--
ALTER TABLE `food_courts`
  MODIFY `food_court_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `food_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `food_stalls`
--
ALTER TABLE `food_stalls`
  MODIFY `stall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `most_ordered`
--
ALTER TABLE `most_ordered`
  MODIFY `most_ordered_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_topups`
--
ALTER TABLE `account_topups`
  ADD CONSTRAINT `account_topups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `food_items`
--
ALTER TABLE `food_items`
  ADD CONSTRAINT `food_items_ibfk_1` FOREIGN KEY (`food_court_id`) REFERENCES `food_stalls` (`food_court_id`),
  ADD CONSTRAINT `food_items_ibfk_2` FOREIGN KEY (`stall_id`) REFERENCES `food_stalls` (`stall_id`);

--
-- Constraints for table `food_stalls`
--
ALTER TABLE `food_stalls`
  ADD CONSTRAINT `food_stalls_ibfk_1` FOREIGN KEY (`food_court_id`) REFERENCES `food_courts` (`food_court_id`);

--
-- Constraints for table `most_ordered`
--
ALTER TABLE `most_ordered`
  ADD CONSTRAINT `most_ordered_ibfk_1` FOREIGN KEY (`food_item_id`) REFERENCES `food_items` (`food_item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `most_ordered_ibfk_2` FOREIGN KEY (`food_court_id`) REFERENCES `food_courts` (`food_court_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`food_item_id`) REFERENCES `food_items` (`food_item_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`stall_id`) REFERENCES `food_stalls` (`stall_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`food_court_id`) REFERENCES `food_courts` (`food_court_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
