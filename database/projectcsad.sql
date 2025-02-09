-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 04:20 PM
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

--
-- Dumping data for table `account_topups`
--

INSERT INTO `account_topups` (`topup_id`, `user_id`, `topup_amount`, `payment_method`, `transaction_reference`, `topup_date`, `status`, `notes`) VALUES
(8, 37, 10.00, '', NULL, '2025-02-05 06:26:17', 'completed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `food_courts`
--

CREATE TABLE `food_courts` (
  `food_court_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`food_item_id`, `food_court_id`, `food_name`, `description`, `price`, `category`, `stall_id`, `image_path`, `buy_count`) VALUES
(7, 1, 'Steamed Chicken Rice', '', 1.50, NULL, 1, '../uploads/Steamed_Chicken_Rice.jpg', NULL),
(9, 2, 'Nasi Padang', '', 2.50, NULL, 5, '../uploads/nasi-padang.jpg', NULL),
(10, 1, 'Roasted Chicken Rice', '', 2.50, NULL, 1, '../uploads/Roasted_Chicken_Rice.jpg', NULL),
(16, 1, 'Soup', '', 1.00, NULL, 1, '../uploads/Soup.jpg', NULL),
(17, 1, '1/2 Chicken', '', 8.00, NULL, 1, '../uploads/half_chicken.jpg', NULL),
(18, 1, 'Chicken Rice Value Set', '', 4.00, NULL, 1, '../uploads/Chicken_Rice_Value_Set.jpg', NULL),
(24, 2, 'Mee Soto', '', 2.50, NULL, 5, '../uploads/Mee_soto.jpg', NULL),
(25, 2, 'Nasi Goreng', '', 3.00, NULL, 5, '../uploads/Nasi_goreng.jpg', NULL),
(26, 2, 'Nasi Lemak', '', 3.00, NULL, 5, '../uploads/Nasi_lemak.jpg', NULL),
(27, 3, 'Chicken Chop', '', 5.00, NULL, 6, '../uploads/chickenchop.jpg', NULL),
(28, 3, 'Spaghetti and meatballs', '', 6.00, NULL, 6, '../uploads/spaghettimeatballs.jpg', NULL),
(29, 3, 'Spaghetti', '', 4.00, NULL, 6, '../uploads/spaghetti.jpg', NULL),
(30, 3, 'Fish and Chips', '', 4.00, NULL, 6, '../uploads/fishandchips.jpg', NULL),
(31, 4, 'Egg Fried Rice', '', 2.50, NULL, 7, '../uploads/eggfriedrice.jpg', NULL),
(32, 4, 'Egg Fried Rice with chicken', '', 3.50, NULL, 7, '../uploads/eggfriedricewithchicken.jpg', NULL),
(33, 4, 'Egg Fried Rice with beef', '', 4.00, NULL, 7, '../uploads/eggfriedricewithbeef.jpg', NULL),
(54, 1, 'korean street toast', '', 3.00, 'Healthy', 2, '../uploads/fc1/fc1kst.jpg', 0),
(59, 1, 'Avocado toast', '', 3.00, 'Healthy', 2, '../uploads/fc1/fc1at.jpg', 0),
(60, 1, 'Ham Cheese sandwich', '', 3.00, 'Healthy', 2, '../uploads/fc1/fc1hcs.jpg', 0),
(61, 1, 'Carbonara', '', 6.00, 'Healthy', 3, '../uploads/fc1/fc1c.jpg', 0),
(62, 1, 'Aglio Olio', '', 4.00, 'Healthy', 3, '../uploads/fc1/fc1ao.jpg', 0),
(63, 1, 'Marinara Pasta', '', 5.00, 'Healthy', 3, '../uploads/fc1/fc1mp.jpg', 0),
(64, 1, 'Veggie burger', '', 4.50, 'Healthy', 4, '../uploads/fc1/fc1vb.jpg', 0),
(65, 1, 'Beef burger', '', 5.50, 'Healthy', 4, '../uploads/fc1/fc1bb.jpg', 0),
(66, 1, 'Beef burger', '', 5.00, 'Healthy', 4, '../uploads/fc1/fc1cb.jpg', 0),
(67, 2, 'Udon', '', 5.00, 'Healthy', 8, '../uploads/fc2/fc2u.jpg', 0),
(68, 2, 'California roll', '', 4.00, 'Healthy', 8, '../uploads/fc2/fc2cr.jpg', 0),
(69, 2, 'Egg Nigiri', '', 3.00, 'Healthy', 8, '../uploads/fc2/fc2en.jpg', 0),
(70, 2, 'Grilled Chicken Breast', '', 6.00, 'Healthy', 9, '../uploads/fc2/fc2gcb.jpg', 0),
(71, 2, 'Grilled Chicken Leg', '', 6.00, 'Healthy', 9, '../uploads/fc2/fc2gcl.jpg', 0),
(72, 2, 'Chicken Shawarma', '', 5.50, 'Healthy', 10, '../uploads/fc2/fc2cs.jpg', 0),
(73, 2, 'Beef Shawarma', '', 6.00, 'Healthy', 10, '../uploads/fc2/fc2bs.jpg', 0),
(74, 2, 'Lamb Shawarma', '', 7.00, 'Healthy', 10, '../uploads/fc2/fc2ls.jpg', 0),
(75, 2, 'Chocolate cake', '', 4.00, 'Sweet', 11, '../uploads/fc2/fc2cc.jpg', 0),
(76, 2, 'Brownie', '', 2.00, 'Sweet', 11, '../uploads/fc2/fc2b.jpg', 0),
(77, 2, 'Green Smoothie', '', 2.00, 'Healthy', 12, '../uploads/fc2/fc2gs.jpg', 0),
(78, 2, 'Strawberry Smoothie', '', 2.50, 'Healthy', 12, '../uploads/fc2/fc2ss.jpg', 0),
(79, 2, 'Strawberry Smoothie', '', 3.00, 'Healthy', 12, '../uploads/fc2/fc2mb.jpg', 0),
(80, 2, 'Chicken Taco', '', 5.50, 'Healthy', 13, '../uploads/fc3/fc3ct.jpg', 0),
(81, 2, 'Beef Taco', '', 6.50, 'Healthy', 13, '../uploads/fc3/fc3bt.jpg', 0),
(82, 2, 'Quesadilla', '', 4.50, 'Healthy', 13, '../uploads/fc3/fc3q.jpg', 0),
(83, 2, 'Butter Chicken Curry', '', 6.00, 'Healthy', 14, '../uploads/fc3/fc3bc.jpg', 0),
(84, 2, 'Chicken Curry', '', 6.00, 'Healthy', 14, '../uploads/fc3/fc3pc.jpg', 0),
(85, 2, 'Chicken Wrap', '', 5.00, 'Healthy', 15, '../uploads/fc3/fc3cs.jpg', 0),
(86, 2, 'Falafel Wrap', '', 5.00, 'Healthy', 15, '../uploads/fc3/fc3fw.jpg', 0),
(87, 2, 'Keema Wrap', '', 5.00, 'Healthy', 15, '../uploads/fc3/fc3kw.jpg', 0),
(88, 2, 'Bimbimbap', '', 5.00, 'Healthy', 16, '../uploads/fc3/fc3bbp.jpg', 0),
(89, 2, 'Clear Stew', '', 3.00, 'Healthy', 16, '../uploads/fc3/fc3clrc.jpg', 0),
(90, 2, 'Tteokbokki', '', 3.00, 'Healthy', 16, '../uploads/fc3/fc3t.jpg', 0),
(91, 2, 'Pepperoni Pizza slice', '', 2.00, 'Healthy', 17, '../uploads/fc3/fc3pp.jpg', 0),
(92, 2, 'Veggie Pizza slice', '', 2.00, 'Healthy', 17, '../uploads/fc3/fc3vp.jpg', 0),
(93, 2, 'Meat Galore slice', '', 2.00, 'Healthy', 17, '../uploads/fc3/fc3mg.jpg', 0),
(94, 3, 'Banana Split', '', 4.50, 'Sweet', 18, '../uploads/fc3/fc3bs.jpg', 0),
(95, 3, 'Sundae', '', 3.00, 'Sweet', 18, '../uploads/fc3/fc3s.jpg', 0),
(96, 3, 'Vanilla Soft serve', '', 1.00, 'Sweet', 18, '../uploads/fc3/fc3wc.jpg', 0),
(97, 4, 'Chicken Nuggets', '', 1.00, 'Snack', 19, '../uploads/fc4/fc4cn.jpg', 0),
(98, 4, 'Popcorn Chicken', '', 1.00, 'Snack', 19, '../uploads/fc4/fc4pc.jpg', 0),
(99, 4, 'Fries', '', 1.50, 'Snack', 19, '../uploads/fc4/fc4f.jpg', 0),
(100, 4, 'Espresso', '', 1.50, 'Drink', 20, '../uploads/fc4/fc4e.jpg', 0),
(101, 4, 'Cappucino', '', 2.00, 'Drink', 20, '../uploads/fc4/fc4c.jpg', 0),
(102, 4, 'Latte', '', 2.00, 'Drink', 20, '../uploads/fc4/fc4l.jpg', 0),
(103, 4, 'BBQ ribs', '', 6.00, 'Meat', 21, '../uploads/fc4/fc4br.jpg', 0),
(104, 4, 'BBQ Chicken', '', 5.00, 'Meat', 21, '../uploads/fc4/fc4bc.jpg', 0),
(105, 4, 'BBQ Kebab', '', 2.00, 'Meat', 21, '../uploads/fc4/fc4bk.jpg', 0),
(106, 4, 'Chicken noodle soup', '', 1.00, 'Healthy', 22, '../uploads/fc4/fc4cns.jpg', 0),
(107, 4, 'Chicken Veggie soup', '', 1.00, 'Healthy', 22, '../uploads/fc4/fc4cv.jpg', 0),
(108, 4, 'Minestrone', '', 1.00, 'Healthy', 22, '../uploads/fc4/fc4m.jpg', 0),
(109, 4, 'Steak', '', 7.00, 'Meat', 23, '../uploads/fc4/fc4s.jpg', 0),
(110, 4, 'Butter Basted Steak', '', 8.00, 'Meat', 23, '../uploads/fc4/fc4bs.jpg', 0),
(111, 4, 'Soup dumpling', '', 3.00, 'Meat', 24, '../uploads/fc4/fc4sd.jpg', 0),
(112, 4, 'Pan seared dumpling', '', 3.00, 'Meat', 24, '../uploads/fc4/fc4pd.jpg', 0),
(113, 4, 'Gyoza', '', 3.00, 'Meat', 24, '../uploads/fc4/fc4g.jpg', 0),
(114, 5, 'Tonkotsu ramen', '', 5.00, 'Healthy', 25, '../uploads/fc5/fc5tr.jpg', 0),
(115, 5, 'Shoyu ramen', '', 5.00, 'Healthy', 25, '../uploads/fc5/fc5sr.jpg', 0),
(116, 5, 'Brown Sugar', '', 3.00, 'Sweet', 26, '../uploads/fc5/fc5bs.jpg', 0),
(117, 5, 'Thai Milk Tea', '', 3.00, 'Sweet', 26, '../uploads/fc5/fc5tt.jpg', 0),
(118, 5, 'Green Tea', '', 2.50, 'Sweet', 26, '../uploads/fc5/fc5gt.jpg', 0),
(119, 5, 'Egg Burger', '', 5.50, 'Meat', 27, '../uploads/fc5/fc5eb.jpg', 0),
(120, 5, 'Loaded Burger', '', 6.50, 'Meat', 27, '../uploads/fc5/fc5lb.jpg', 0),
(121, 5, 'Beef Burger', '', 5.00, 'Meat', 27, '../uploads/fc5/fc5bb.jpg', 0),
(122, 5, 'Clams', '', 5.00, 'Seafood', 28, '../uploads/fc5/fc5cl.jpg', 0),
(123, 5, 'Crab', '', 7.00, 'Seafood', 28, '../uploads/fc5/fc5c.jpg', 0),
(124, 5, 'Lobster', '', 10.00, 'Seafood', 28, '../uploads/fc5/fc5l.jpg', 0),
(125, 5, 'Vegetarian Paella', '', 4.00, 'Healthy', 29, '../uploads/fc5/fc5p.jpg', 0),
(126, 5, 'Vegetarian Curry', '', 4.00, 'Healthy', 29, '../uploads/fc5/fc5vc.jpg', 0),
(127, 5, 'Salad', '', 3.00, 'Healthy', 29, '../uploads/fc5/fc5s.jpg', 0),
(128, 5, 'Fruit Tart', '', 3.00, 'Sweet', 30, '../uploads/fc5/fc5ft.jpg', 0),
(129, 5, 'Croissant', '', 2.00, 'Sweet', 30, '../uploads/fc5/fc5cr.jpg', 0),
(130, 5, 'Macaroon', '', 2.00, 'Sweet', 30, '../uploads/fc5/fc5m.jpg', 0),
(131, 6, 'Chickpea Salad', '', 4.00, 'Healthy', 31, '../uploads/fc5/fc5cs.jpg', 0),
(132, 6, 'Ratatouiie', '', 4.00, 'Healthy', 31, '../uploads/fc5/fc5r.jpg', 0),
(133, 6, 'Chickpea Salad', '', 4.00, 'Healthy', 31, '../uploads/fc6/fc6cs.jpg', 0),
(134, 6, 'Ratatouiie', '', 4.00, 'Healthy', 31, '../uploads/fc6/fc6r.jpg', 0),
(135, 6, 'Orange Juice', '', 1.50, 'Juice', 32, '../uploads/fc6/fc6oj.jpg', 0),
(136, 6, 'Strawberry Juice', '', 1.50, 'Juice', 32, '../uploads/fc6/fc6sj.jpg', 0),
(137, 6, 'Green Juice', '', 1.50, 'Juice', 32, '../uploads/fc6/fc6gj.jpg', 0),
(138, 6, 'Fried Chicken Bucket', '', 12.00, 'Meat', 33, '../uploads/fc6/fc6b.jpg', 0),
(139, 6, 'Chicken', '', 4.00, 'Meat', 34, '../uploads/fc6/fc6c.jpg', 0),
(140, 6, 'Kebab', '', 2.00, 'Meat', 34, '../uploads/fc6/fc6k.jpg', 0),
(141, 6, 'Steak', '', 7.00, 'Meat', 34, '../uploads/fc6/fc6s.jpg', 0),
(142, 6, 'Singapore Noodles', '', 3.00, 'Healthy', 35, '../uploads/fc6/fc6sn.jpg', 0),
(143, 6, 'Ground Beef Noodles', '', 4.00, 'Healthy', 35, '../uploads/fc6/fc6gbn.jpg', 0),
(144, 6, 'Spicy Korean Noodles', '', 4.00, 'Healthy', 35, '../uploads/fc6/fc6skn.jpg', 0),
(145, 6, 'Funfetti Cupcakes', '', 3.00, 'Healthy', 36, '../uploads/fc6/fc6fc.jpg', 0),
(146, 6, 'Chocolate Cupcakes', '', 2.00, 'Sweet', 36, '../uploads/fc6/fc6cc.jpg', 0),
(147, 6, 'Strawberry Cupcakes', '', 2.00, 'Sweet', 36, '../uploads/fc6/fc6sc.jpg', 0);

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
(0, '', 5, '', 'Open', '09:00:00', '21:00:00', '', NULL),
(1, 'Stall 1 - FC1', 1, '1000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 1 serves Chicken rice.', '../uploads/Steamed_Chicken_Rice.jpg'),
(2, 'Stall 2 - FC1', 1, '1000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 1 serves gourmet sandwiches.', '../uploads/sandwichstall2fc1.jpg'),
(3, 'Stall 3 - FC1', 1, '1000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 1 serves Italian pasta.', '../uploads/pastastall3fc1.jpg'),
(4, 'Stall 4 - FC1', 1, '1000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 1 serves grilled burgers.', '../uploads/burgersstall4fc1.jpg'),
(5, 'Stall 5 - FC1', 1, '1000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 1 serves Nasi padang.', '../uploads/Nasi_padang_FC2.jpeg'),
(6, 'Stall 6 - FC1', 1, '1000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 1 serves Western food.', '../uploads/Western_FC3.jpg'),
(7, 'Stall 1 - FC2', 2, '2000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 2 serves Fried rice.', '../uploads/friedrice_FC4.jpg'),
(8, 'Stall 2 - FC2', 2, '2000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 2 serves Japanese food.', '../uploads/Japanese_FC6.jpg'),
(9, 'Stall 3 - FC2', 2, '2000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 2 serves grilled chicken.', '../uploads/grilledchickenstall3fc2.jpg'),
(10, 'Stall 4 - FC2', 2, '2000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 2 serves shawarma.', '../uploads/shawarmastall4fc2.jpg'),
(11, 'Stall 5 - FC2', 2, '2000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 2 serves baked goods.', '../uploads/bakedstall5fc2.jpg'),
(12, 'Stall 6 - FC2', 2, '2000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 2 serves smoothies.', '../uploads/smoothiestall6fc2.jpg'),
(13, 'Stall 1 - FC3', 3, '3000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 3 serves Mexican tacos.', '../uploads/fc3/fc3taco.jpg'),
(14, 'Stall 2 - FC3', 3, '3000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 3 serves Indian curries.', '../uploads/fc3/fc3indian.jpg'),
(15, 'Stall 3 - FC3', 3, '3000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 3 serves Lebanese wraps.', '../uploads/fc3/fc3wraps.jpg'),
(16, 'Stall 4 - FC3', 3, '3000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 3 serves Korean Food.', '../uploads/Korean_FC4.jpg'),
(17, 'Stall 5 - FC3', 3, '3000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 3 serves pizza.', '../uploads/fc3/fc3pizza.jpg'),
(18, 'Stall 6 - FC3', 3, '3000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 3 serves ice cream.', '../uploads/fc3/fc3icecream.jpg'),
(19, 'Stall 1 - FC4', 4, '4000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 4 serves fried snacks.', '../uploads/fc4/fc4fried.jpg'),
(20, 'Stall 2 - FC4', 4, '4000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 4 serves coffee.', '../uploads/fc4/fc4coffee.jpg'),
(21, 'Stall 3 - FC4', 4, '4000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 4 serves BBQ platters.', '../uploads/fc4/fc4bbq.jpg'),
(22, 'Stall 4 - FC4', 4, '4000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 4 serves soups.', '../uploads/fc4/fc4soup.jpg'),
(23, 'Stall 5 - FC4', 4, '4000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 4 serves steaks.', '../uploads/fc4/fc4steak.jpg'),
(24, 'Stall 6 - FC4', 4, '4000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 4 serves dumplings.', '../uploads/fc4/fc4dumpling.jpeg'),
(25, 'Stall 1 - FC5', 5, '5000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 5 serves ramen.', '../uploads/fc5/fc5ramen.jpg'),
(26, 'Stall 2 - FC5', 5, '5000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 5 serves bubble tea.', '../uploads/fc5/fc5bubbletea.jpg'),
(27, 'Stall 3 - FC5', 5, '5000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 5 serves burgers.', '../uploads/fc5/fc5burger.jpg'),
(28, 'Stall 4 - FC5', 5, '5000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 5 serves seafood.', '../uploads/fc5/fc5seafood.jpg'),
(29, 'Stall 5 - FC5', 5, '5000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 5 serves vegetarian meals.', '../uploads/fc5/fc5vegetarian.jpg'),
(30, 'Stall 6 - FC5', 5, '5000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 5 serves pastries.', '../uploads/fc5/fc5pastries.jpg'),
(31, 'Stall 1 - FC6', 6, '6000000001', 'Open', '09:00:00', '21:00:00', 'Stall 1 in Food Court 6 serves Mediterranean food.', '../uploads/fc6/fc6mediterranean.jpg'),
(32, 'Stall 2 - FC6', 6, '6000000002', 'Open', '09:00:00', '21:00:00', 'Stall 2 in Food Court 6 serves fresh juices.', '../uploads/fc6/fc6juice.jpg'),
(33, 'Stall 3 - FC6', 6, '6000000003', 'Open', '09:00:00', '21:00:00', 'Stall 3 in Food Court 6 serves fast food.', '../uploads/fc6/fc6kfc.jpg'),
(34, 'Stall 4 - FC6', 6, '6000000004', 'Open', '09:00:00', '21:00:00', 'Stall 4 in Food Court 6 serves BBQ dishes.', '../uploads/fc6/fc6bbq.jpg'),
(35, 'Stall 5 - FC6', 6, '6000000005', 'Open', '09:00:00', '21:00:00', 'Stall 5 in Food Court 6 serves noodles.', '../uploads/fc6/fc6noodles.jpg'),
(36, 'Stall 6 - FC6', 6, '6000000006', 'Open', '09:00:00', '21:00:00', 'Stall 6 in Food Court 6 serves cupcakes.', '../uploads/fc6/fc6cupcakes.jpg');

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
(50, 37, 4.50, 'Cancelled', 'Credit Card', '2025-02-09 23:01:57', 'ORDER_67A8C365521EE', 'NA');

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
(52, 50, 7, 1, 1.50),
(53, 50, 54, 1, 3.00);

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
(1, 'fc1_s1', 'fc1_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 1, 1),
(2, 'fc1_s2', 'fc1_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 2, 1),
(3, 'fc1_s3', 'fc1_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 3, 1),
(4, 'fc1_s4', 'fc1_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 4, 1),
(5, 'fc1_s5', 'fc1_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 5, 1),
(6, 'fc1_s6', 'fc1_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 6, 1),
(7, 'fc2_s1', 'fc2_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 7, 2),
(8, 'fc2_s2', 'fc2_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 8, 2),
(9, 'fc2_s3', 'fc2_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 9, 2),
(10, 'fc2_s4', 'fc2_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 10, 2),
(11, 'fc2_s5', 'fc2_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 11, 2),
(12, 'fc2_s6', 'fc2_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 12, 2),
(13, 'fc3_s1', 'fc3_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 13, 3),
(14, 'fc3_s2', 'fc3_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 14, 3),
(15, 'fc3_s3', 'fc3_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 15, 3),
(16, 'fc3_s4', 'fc3_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 16, 3),
(17, 'fc3_s5', 'fc3_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 17, 3),
(18, 'fc3_s6', 'fc3_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 18, 3),
(19, 'fc4_s1', 'fc4_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 19, 4),
(20, 'fc4_s2', 'fc4_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 20, 4),
(21, 'fc4_s3', 'fc4_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 21, 4),
(22, 'fc4_s4', 'fc4_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 22, 4),
(23, 'fc4_s5', 'fc4_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 23, 4),
(24, 'fc4_s6', 'fc4_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 24, 4),
(25, 'fc5_s1', 'fc5_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 25, 5),
(26, 'fc5_s2', 'fc5_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 26, 5),
(27, 'fc5_s3', 'fc5_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 27, 5),
(28, 'fc5_s4', 'fc5_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 28, 5),
(29, 'fc5_s5', 'fc5_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 29, 5),
(30, 'fc5_s6', 'fc5_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 30, 5),
(31, 'fc6_s1', 'fc6_s1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 31, 6),
(32, 'fc6_s2', 'fc6_s2@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 32, 6),
(33, 'fc6_s3', 'fc6_s3@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 33, 6),
(34, 'fc6_s4', 'fc6_s4@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 34, 6),
(35, 'fc6_s5', 'fc6_s5@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 35, 6),
(36, 'fc6_s6', 'fc6_s6@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', NULL, NULL, NULL, 'vendor', 36, 6),
(37, 'c1', 'c1@example.com', '$2y$10$0UDqRcrXtf6UUuE/ZU9/me94orx4iNwFPZTFyid.yAam06HP7G46S', '1234567890', '../uploads/profile_pic (2).jpg', 10.00, 'customer', NULL, NULL);

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
  MODIFY `food_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `most_ordered`
--
ALTER TABLE `most_ordered`
  MODIFY `most_ordered_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

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
