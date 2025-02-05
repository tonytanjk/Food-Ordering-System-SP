-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2025 at 08:02 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account_topups`
--

INSERT INTO `account_topups` (`topup_id`, `user_id`, `topup_amount`, `payment_method`, `transaction_reference`, `topup_date`, `status`, `notes`) VALUES
(8, 37, '10.00', '', NULL, '2025-02-05 06:26:17', 'completed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `food_courts`
--

CREATE TABLE `food_courts` (
  `food_court_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food_courts`
--

INSERT INTO `food_courts` (`food_court_id`, `name`, `location`, `contact_number`) VALUES
(1, 'Food Court 1', 'Level 2\r\nT3B', NULL),
(2, 'Food Court 2', 'Level 1 T1A', NULL),
(3, 'Food Court 3', 'Poly Centre', NULL),
(4, 'Food Court 4', 'Level 1 T18A', NULL),
(5, 'Food Court 5', 'SP Arena', NULL),
(6, 'Food Court 6', 'Level 2 T22', NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`food_item_id`, `food_court_id`, `food_name`, `description`, `price`, `category`, `stall_id`, `image_path`, `buy_count`) VALUES
(23, 1, 'Classic Burger', 'A juicy beef burger with lettuce, tomato, and cheese.', '8.99', 'Fast Food', 1, NULL, 0),
(24, 1, 'Fries', 'Crispy golden fries.', '3.99', 'Fast Food', 2, NULL, 0),
(25, 1, 'Caesar Salad', 'Fresh romaine lettuce with Caesar dressing and croutons.', '6.99', 'Salad', 3, NULL, 0),
(26, 1, 'Margherita Pizza', 'Classic pizza with tomato sauce, mozzarella, and basil.', '9.99', 'Italian', 4, NULL, 0),
(27, 1, 'Chicken Tacos', 'Spicy grilled chicken in soft taco shells.', '7.99', 'Mexican', 5, NULL, 0),
(28, 1, 'Chocolate Shake', 'Rich chocolate milkshake with whipped cream.', '4.99', 'Beverages', 6, NULL, 0),
(29, 2, 'Veggie Wrap', 'Healthy wrap with fresh vegetables and hummus.', '6.99', 'Healthy', 7, NULL, 0),
(30, 2, 'Pepperoni Pizza', 'Cheesy pizza topped with pepperoni slices.', '10.99', 'Italian', 8, NULL, 0),
(31, 2, 'Beef Burrito', 'Large burrito stuffed with spiced beef and cheese.', '8.99', 'Mexican', 9, NULL, 0),
(32, 2, 'Grilled Cheese', 'Crispy grilled cheese sandwich.', '5.99', 'Fast Food', 10, NULL, 0),
(33, 2, 'Vanilla Shake', 'Creamy vanilla milkshake.', '4.99', 'Beverages', 11, NULL, 0),
(34, 2, 'Greek Salad', 'Salad with feta cheese, olives, and cucumber.', '6.99', 'Salad', 12, NULL, 0),
(35, 3, 'Spaghetti Bolognese', 'Classic Italian pasta dish.', '12.99', 'Italian', 13, NULL, 0),
(36, 3, 'Chicken Wrap', 'Grilled chicken wrapped with fresh veggies.', '8.99', 'Healthy', 14, NULL, 0),
(37, 3, 'Tuna Sandwich', 'Fresh tuna with mayo and lettuce.', '7.99', 'Sandwich', 15, NULL, 0),
(38, 3, 'Cheese Pizza', 'Mozzarella cheese pizza with marinara sauce.', '9.99', 'Italian', 16, NULL, 0),
(39, 3, 'Smoothie Bowl', 'Fruit smoothie topped with granola.', '6.99', 'Healthy', 17, NULL, 0),
(40, 3, 'Latte', 'Rich and creamy coffee.', '3.99', 'Beverages', 18, NULL, 0),
(41, 4, 'BBQ Chicken Pizza', 'Pizza topped with BBQ chicken.', '11.99', 'Italian', 19, NULL, 0),
(42, 4, 'Pasta Alfredo', 'Creamy Alfredo pasta.', '13.99', 'Italian', 20, NULL, 0),
(43, 4, 'Fruit Salad', 'Fresh mixed fruit salad.', '5.99', 'Healthy', 21, NULL, 0),
(44, 4, 'Fish Tacos', 'Grilled fish in soft taco shells.', '9.99', 'Mexican', 22, NULL, 0),
(45, 4, 'Berry Smoothie', 'Mixed berry smoothie.', '4.99', 'Beverages', 23, NULL, 0),
(46, 4, 'Grilled Salmon', 'Perfectly grilled salmon with lemon.', '14.99', 'Seafood', 24, NULL, 0),
(47, 5, 'Buffalo Wings', 'Spicy buffalo wings served with ranch.', '7.99', 'Appetizers', 25, NULL, 0),
(48, 5, 'Pancakes', 'Fluffy pancakes with syrup.', '5.99', 'Breakfast', 26, NULL, 0),
(49, 5, 'Veggie Burger', 'Burger with a plant-based patty.', '8.99', 'Fast Food', 27, NULL, 0),
(50, 5, 'Margarita', 'Refreshing margarita drink.', '6.99', 'Beverages', 28, NULL, 0),
(51, 5, 'Ice Cream Sundae', 'Vanilla ice cream topped with chocolate syrup.', '4.99', 'Dessert', 29, NULL, 0),
(52, 5, 'Chicken Alfredo', 'Creamy Alfredo pasta with chicken.', '12.99', 'Italian', 30, NULL, 0),
(53, 6, 'Grilled Steak', 'Juicy grilled steak with herb butter.', '15.99', 'Main Course', 31, NULL, 0),
(54, 6, 'Chicken Caesar Salad', 'Salad with grilled chicken and Caesar dressing.', '9.99', 'Healthy', 32, NULL, 0),
(55, 6, 'Curry Rice', 'Spicy curry served with rice.', '10.99', 'Asian', 33, NULL, 0),
(56, 6, 'Garlic Bread', 'Freshly baked garlic bread.', '3.99', 'Appetizers', 34, NULL, 0),
(57, 6, 'Lemonade', 'Refreshing lemonade.', '2.99', 'Beverages', 35, NULL, 0),
(58, 6, 'Chocolate Cake', 'Rich chocolate dessert.', '5.99', 'Dessert', 36, NULL, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food_stalls`
--

INSERT INTO `food_stalls` (`stall_id`, `stall_name`, `food_court_id`, `contact_number`, `availability`, `opening_time`, `closing_time`, `description`, `stall_picture`) VALUES
(1, 'Stall 1 - FC1', 1, '1000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 1 serves fresh juices.', NULL),
(2, 'Stall 2 - FC1', 1, '1000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 1 serves gourmet sandwiches.', NULL),
(3, 'Stall 3 - FC1', 1, '1000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 1 serves Italian pasta.', NULL),
(4, 'Stall 4 - FC1', 1, '1000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 1 serves grilled burgers.', NULL),
(5, 'Stall 5 - FC1', 1, '1000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 1 serves Chinese cuisine.', NULL),
(6, 'Stall 6 - FC1', 1, '1000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 1 serves desserts.', NULL),
(7, 'Stall 1 - FC2', 2, '2000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 2 serves vegan salads.', NULL),
(8, 'Stall 2 - FC2', 2, '2000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 2 serves sushi.', NULL),
(9, 'Stall 3 - FC2', 2, '2000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 2 serves grilled chicken.', NULL),
(10, 'Stall 4 - FC2', 2, '2000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 2 serves shawarma.', NULL),
(11, 'Stall 5 - FC2', 2, '2000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 2 serves baked goods.', NULL),
(12, 'Stall 6 - FC2', 2, '2000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 2 serves smoothies.', NULL),
(13, 'Stall 1 - FC3', 3, '3000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 3 serves Mexican tacos.', NULL),
(14, 'Stall 2 - FC3', 3, '3000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 3 serves Indian curries.', NULL),
(15, 'Stall 3 - FC3', 3, '3000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 3 serves Lebanese wraps.', NULL),
(16, 'Stall 4 - FC3', 3, '3000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 3 serves Korean BBQ.', NULL),
(17, 'Stall 5 - FC3', 3, '3000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 3 serves pizza.', NULL),
(18, 'Stall 6 - FC3', 3, '3000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 3 serves ice cream.', NULL),
(19, 'Stall 1 - FC4', 4, '4000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 4 serves fried snacks.', NULL),
(20, 'Stall 2 - FC4', 4, '4000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 4 serves coffee.', NULL),
(21, 'Stall 3 - FC4', 4, '4000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 4 serves BBQ platters.', NULL),
(22, 'Stall 4 - FC4', 4, '4000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 4 serves soups.', NULL),
(23, 'Stall 5 - FC4', 4, '4000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 4 serves steaks.', NULL),
(24, 'Stall 6 - FC4', 4, '4000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 4 serves dumplings.', NULL),
(25, 'Stall 1 - FC5', 5, '5000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 5 serves ramen.', NULL),
(26, 'Stall 2 - FC5', 5, '5000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 5 serves bubble tea.', NULL),
(27, 'Stall 3 - FC5', 5, '5000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 5 serves burgers.', NULL),
(28, 'Stall 4 - FC5', 5, '5000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 5 serves seafood.', NULL),
(29, 'Stall 5 - FC5', 5, '5000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 5 serves vegetarian meals.', NULL),
(30, 'Stall 6 - FC5', 5, '5000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 5 serves pastries.', NULL),
(31, 'Stall 1 - FC6', 6, '6000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 6 serves Mediterranean food.', NULL),
(32, 'Stall 2 - FC6', 6, '6000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 6 serves fresh juices.', NULL),
(33, 'Stall 3 - FC6', 6, '6000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 6 serves fast food.', NULL),
(34, 'Stall 4 - FC6', 6, '6000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 6 serves BBQ dishes.', NULL),
(35, 'Stall 5 - FC6', 6, '6000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 6 serves noodles.', NULL),
(36, 'Stall 6 - FC6', 6, '6000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 6 serves cupcakes.', NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `phone`, `profile_picture`, `account_balance`, `roles`, `stall_id`, `food_court_id`) VALUES
(1, 'fc1_s1', 'fc1_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 1, 1),
(2, 'fc1_s2', 'fc1_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 2, 1),
(3, 'fc1_s3', 'fc1_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 3, 1),
(4, 'fc1_s4', 'fc1_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 4, 1),
(5, 'fc1_s5', 'fc1_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 5, 1),
(6, 'fc1_s6', 'fc1_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 6, 1),
(7, 'fc2_s1', 'fc2_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 1, 2),
(8, 'fc2_s2', 'fc2_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 2, 2),
(9, 'fc2_s3', 'fc2_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 3, 2),
(10, 'fc2_s4', 'fc2_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 4, 2),
(11, 'fc2_s5', 'fc2_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 5, 2),
(12, 'fc2_s6', 'fc2_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 6, 2),
(13, 'fc3_s1', 'fc3_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 1, 3),
(14, 'fc3_s2', 'fc3_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 2, 3),
(15, 'fc3_s3', 'fc3_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 3, 3),
(16, 'fc3_s4', 'fc3_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 4, 3),
(17, 'fc3_s5', 'fc3_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 5, 3),
(18, 'fc3_s6', 'fc3_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 6, 3),
(19, 'fc4_s1', 'fc4_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 1, 4),
(20, 'fc4_s2', 'fc4_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 2, 4),
(21, 'fc4_s3', 'fc4_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 3, 4),
(22, 'fc4_s4', 'fc4_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 4, 4),
(23, 'fc4_s5', 'fc4_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 5, 4),
(24, 'fc4_s6', 'fc4_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 6, 4),
(25, 'fc5_s1', 'fc5_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 1, 5),
(26, 'fc5_s2', 'fc5_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 2, 5),
(27, 'fc5_s3', 'fc5_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 3, 5),
(28, 'fc5_s4', 'fc5_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 4, 5),
(29, 'fc5_s5', 'fc5_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 5, 5),
(30, 'fc5_s6', 'fc5_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 6, 5),
(31, 'fc6_s1', 'fc6_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 1, 6),
(32, 'fc6_s2', 'fc6_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 2, 6),
(33, 'fc6_s3', 'fc6_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 3, 6),
(34, 'fc6_s4', 'fc6_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 4, 6),
(35, 'fc6_s5', 'fc6_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 5, 6),
(36, 'fc6_s6', 'fc6_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 6, 6),
(37, 'c1', 'c1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', '1234567890', '../uploads/profile_pic (2).jpg', '10.00', 'customer', NULL, NULL);

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
  MODIFY `topup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `food_courts`
--
ALTER TABLE `food_courts`
  MODIFY `food_court_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `food_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `food_stalls`
--
ALTER TABLE `food_stalls`
  MODIFY `stall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `most_ordered`
--
ALTER TABLE `most_ordered`
  MODIFY `most_ordered_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
