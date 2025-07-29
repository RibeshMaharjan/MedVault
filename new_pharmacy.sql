-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2025 at 06:01 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `user_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`user_id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Ribesh Majarjan', 'ribesh@admin.gmail.com', '$2y$10$o7av./7KPx0v4ZQkv8zFtO8ndiStiuF24hKdMubatnx5IGaVQMOT.', 'admin'),
(3, 'Pharmacy', 'pharmacy@gmail.com', '$2y$10$m5h/krzwRHZ01TA2.HpMV.VdhK5LWga1JiVMXlOTX/Q8vEdTMfIsC', 'user'),
(4, 'Rijan', 'rijan@gmail.com', '$2y$10$Rrupt.FheoLa7TVoKtYSRuja0NktoO9eR98Q.5TKIPrDJpMrchvP.', 'user'),
(5, 'Rijan Bajracharya', 'rijan@admin.gmail.com', '$2y$10$UcWazRmpIn1eQLMuuxR9LO6tezjPB2u0HT9RrsyZqTzpC/bZg1hh2', 'admin'),
(7, 'IamBakhra', 'bakhra@gmail.com', '$2y$10$0KC0jt75fmGocJ3JbNeHf.XtXJzrLd9EINULjHqqD.eRLH6Qlc2BK', 'user'),
(8, 'Sujal Maharjan', 'sujal@gmail.com', '$2y$10$pRKFdIvU32Ls6A/vCtwVn.rJ0VQAQxeOjH2Y.bYFuYAf2wd7CLb7C', 'user'),
(12, 'Test user', 'user@gmail.com', '$2y$10$GcdcnKpAOVk1pXaao06WcuJfENsBaSDC3XPTTBAxL2vDx2duOzqWW', 'user'),
(13, 'Add Test', 'addtest@gmail.com', '$2y$10$od4nrSGg5qWlqpla4Jws9O2wU7mPDjnq5LnRpwHncbojpM9fMzC0G', 'user'),
(28, 'Asura Pharma', 'asurapharma@gmail.com', '$2y$10$6aaACAUnH5NBMaXoEzH5iO5Sj1486UCirfTuoWhJ1NrdSWlH8qegK', 'user'),
(31, 'Rijan Pharma', 'rijanpharma@gmail.com', '$2y$10$ugJ5bUWa9lrVy32indGPIOw1zz/xOzEGT2BrjwuF/piAWmKwvK50.', 'user'),
(32, 'Remon Buddhacharya', 'remon@gmail.com', '$2y$10$2w/c.p0baRcFAQS52my09ORud.u0AxkSLWQAgdSTLytOfnUsM4cFa', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `name`, `email`, `gender`, `phone`, `dob`, `address`) VALUES
(1, 'Ribesh Maharjan', 'ribesh@admin.gmail.com', 'Male', '987513654', '2002-12-04', 'Sakamkhusi'),
(5, 'Rijan Bajracharya', 'rijan@admin.gmail.com', 'Male', '9845124657', '2003-12-18', 'Lagan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pharmacy`
--

CREATE TABLE `tbl_pharmacy` (
  `pharmacy_id` int NOT NULL,
  `pharmacy_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isverified` tinyint(1) DEFAULT '0',
  `reg_document` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `verification_request_date` timestamp NULL DEFAULT NULL,
  `verification_date` timestamp NULL DEFAULT NULL,
  `verification_notes` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pharmacy`
--

INSERT INTO `tbl_pharmacy` (`pharmacy_id`, `pharmacy_name`, `email`, `phone`, `address`, `isverified`, `reg_document`, `pan`, `verification_request_date`, `verification_date`, `verification_notes`) VALUES
(4, 'Rijan', 'rijan@gmail.com', '9874512361', 'Lagan', 1, 'uploads/verification/4_1745589628.png', '451245612', '2025-04-25 14:00:28', '2025-04-25 14:24:21', 'You are Verified'),
(7, 'IamBakhra', 'bakhra@gmail.com', '', '', 1, 'uploads/verification/7_1745602595.jpg', '545121467', '2025-04-25 17:36:35', '2025-04-25 17:37:10', 'You are verified'),
(12, 'Test user', 'user@gmail.com', '7845126547', 'sdfsdfsdfsf', 0, 'uploads/verification/12_1746501712.png', '984512345', '2025-05-06 03:21:52', '2025-05-05 21:36:10', 'no valid'),
(13, 'Add Test', 'addtest@gmail.com', '', '', 0, '', '', '2025-05-08 06:57:17', NULL, ''),
(28, 'Asura Pharma', 'asurapharma@gmail.com', '9845124578', 'Samakhusi, Kathmandu', 0, 'uploads/verification/28_1746721340.png', '984512547', '2025-05-08 16:22:20', NULL, ''),
(31, 'Rijan Pharma', 'rijanpharma@gmail.com', '', '', 0, '', '984512547', '2025-05-08 11:10:03', NULL, ''),
(32, 'Remon Buddhacharya', 'remon@gmail.com', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_category_tbl`
--

CREATE TABLE `user_category_tbl` (
  `c_id` int NOT NULL,
  `pharmacy_id` int NOT NULL,
  `category_name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_category_tbl`
--

INSERT INTO `user_category_tbl` (`c_id`, `pharmacy_id`, `category_name`) VALUES
(1, 4, 'Tablets'),
(2, 4, 'Capsules'),
(3, 4, 'Syrups'),
(4, 4, 'Injections'),
(5, 4, 'Ointments'),
(6, 4, 'Drops');

-- --------------------------------------------------------

--
-- Table structure for table `user_medicine_tbl`
--

CREATE TABLE `user_medicine_tbl` (
  `m_id` int NOT NULL,
  `pharmacy_id` int NOT NULL,
  `medicine_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `medicine_desc` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `c_id` int NOT NULL,
  `in_stock` int NOT NULL,
  `buy_price` int NOT NULL,
  `sell_price` int NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `exp_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_medicine_tbl`
--

INSERT INTO `user_medicine_tbl` (`m_id`, `pharmacy_id`, `medicine_name`, `medicine_desc`, `c_id`, `in_stock`, `buy_price`, `sell_price`, `added_date`, `exp_date`) VALUES
(1, 4, 'Paracetamol 500mg', 'Pain reliever and fever reducer', 1, 51, 50, 70, '2025-05-31 06:17:24', '2025-08-12'),
(2, 4, 'Amoxicillin 250mg', 'Antibiotic for bacterial infections', 1, 2220, 180, 220, '2025-05-16 22:35:27', '2025-10-15'),
(3, 4, 'Metformin 500mg', 'Diabetes medication', 1, 300, 120, 150, '2025-04-25 07:53:01', '2025-11-30'),
(4, 4, 'Amlodipine 5mg', 'Blood pressure medication', 1, 0, 240, 280, '2025-05-13 15:23:32', '2025-09-30'),
(5, 4, 'Cetirizine 10mg', 'Antihistamine for allergies', 1, 400, 80, 100, '2025-04-25 07:53:01', '2025-12-15'),
(6, 4, 'Omeprazole 20mg', 'Acid reflux medication', 2, 250, 160, 190, '2025-04-25 07:53:01', '2025-11-15'),
(7, 4, 'Doxycycline 100mg', 'Antibiotic', 2, 150, 280, 320, '2025-04-25 07:53:01', '2025-10-30'),
(8, 4, 'Gabapentin 300mg', 'Nerve pain medication', 2, 180, 450, 500, '2025-04-25 07:53:01', '2025-12-20'),
(9, 4, 'Fluoxetine 20mg', 'Antidepressant', 2, 120, 380, 420, '2025-04-25 07:53:01', '2025-11-25'),
(10, 4, 'Vitamin D3 1000IU', 'Vitamin supplement', 2, 300, 140, 170, '2025-04-25 07:53:01', '2025-10-20'),
(11, 4, 'Cough Syrup 100ml', 'For dry cough relief', 3, 100, 180, 220, '2025-04-25 07:53:01', '2025-11-30'),
(12, 4, 'Children\'s Paracetamol', 'Fever reducer for children', 3, 150, 160, 190, '2025-04-25 07:53:01', '2025-12-15'),
(13, 4, 'Antacid Suspension', 'For acid reflux relief', 3, 120, 140, 170, '2025-04-25 07:53:01', '2025-10-25'),
(14, 4, 'Iron Supplement Syrup', 'Iron deficiency treatment', 3, 80, 280, 320, '2025-04-25 07:53:01', '2025-11-20'),
(15, 4, 'Multivitamin Syrup', 'General vitamin supplement', 3, 100, 220, 260, '2025-04-25 07:53:01', '2025-12-10'),
(16, 4, 'Insulin Regular', 'Diabetes treatment', 4, 50, 480, 540, '2025-04-25 07:53:01', '2025-09-30'),
(17, 4, 'B12 Injection', 'Vitamin B12 supplement', 4, 80, 380, 420, '2025-04-25 07:53:01', '2025-10-15'),
(18, 4, 'Tetanus Toxoid', 'Tetanus prevention', 4, 100, 280, 320, '2025-04-25 07:53:01', '2025-11-30'),
(19, 4, 'Diclofenac Injection', 'Pain relief injection', 4, 120, 180, 220, '2025-04-25 07:53:01', '2025-12-15'),
(20, 4, 'Dexamethasone', 'Anti-inflammatory', 4, 90, 320, 360, '2025-04-25 07:53:01', '2025-10-20'),
(21, 4, 'Antibiotic Cream', 'For skin infections', 5, 150, 140, 170, '2025-04-25 07:53:01', '2025-12-15'),
(22, 4, 'Anti-fungal Ointment', 'For fungal infections', 5, 120, 180, 220, '2025-04-25 07:53:01', '2025-11-30'),
(23, 4, 'Pain Relief Gel', 'Topical pain reliever', 5, 100, 240, 280, '2025-04-25 07:53:01', '2025-10-15'),
(24, 4, 'Burn Cream', 'For minor burns', 5, 80, 160, 190, '2025-04-25 07:53:01', '2025-12-20'),
(25, 4, 'Moisturizing Cream', 'For dry skin', 5, 200, 120, 150, '2025-04-25 07:53:01', '2025-11-15'),
(26, 4, 'Eye Drops', 'For dry eyes', 6, 150, 180, 220, '2025-04-25 07:53:01', '2025-12-31'),
(27, 4, 'Ear Drops', 'For ear infections', 6, 100, 160, 190, '2025-04-25 07:53:01', '2025-11-30'),
(28, 4, 'Nasal Drops', 'For nasal congestion', 6, 120, 140, 170, '2025-04-25 07:53:01', '2025-10-15'),
(29, 4, 'Allergy Eye Drops', 'For eye allergies', 6, 90, 220, 260, '2025-04-25 07:53:01', '2025-12-20'),
(30, 4, 'Antibiotic Eye Drops', 'For eye infections', 6, 80, 280, 320, '2025-04-25 07:53:01', '2025-11-15'),
(34, 4, 'Testing', 'Testing og the meddince add', 2, 500, 200, 250, '2025-04-27 22:18:30', '2025-04-30'),
(37, 4, 'testin', 'asdadsa', 1, 20, 10, 5, '2025-05-16 10:15:16', '2025-07-18'),
(38, 32, 'Paracetamol', 'asdjnaksjdnajkn', 1, 200, 100, 200, '2025-05-16 10:54:48', '2025-07-23'),
(39, 4, 'flexon', 'medicine', 1, 100, 100, 110, '2025-05-16 22:25:53', '2025-07-09');

-- --------------------------------------------------------

--
-- Table structure for table `user_order_tbl`
--

CREATE TABLE `user_order_tbl` (
  `o_id` int NOT NULL,
  `m_id` int NOT NULL,
  `pharmacy_id` int NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `total_amount` int NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_order_tbl`
--

INSERT INTO `user_order_tbl` (`o_id`, `m_id`, `pharmacy_id`, `price`, `quantity`, `total_amount`, `status`, `order_date`) VALUES
(3, 2, 4, 180, 30, 5400, 'completed', '2025-03-21'),
(4, 3, 4, 120, 40, 4800, 'completed', '2025-03-15'),
(5, 5, 4, 80, 50, 4000, 'completed', '2025-03-15'),
(6, 1, 4, 50, 50, 2500, 'completed', '2025-03-30'),
(7, 2, 4, 180, 30, 5400, 'completed', '2025-03-30'),
(8, 3, 4, 120, 40, 4800, 'completed', '2025-03-30'),
(9, 5, 4, 80, 50, 4000, 'completed', '2025-03-30'),
(10, 1, 4, 50, 50, 2500, 'completed', '2025-04-14'),
(11, 2, 4, 180, 30, 5400, 'completed', '2025-04-14'),
(12, 3, 4, 120, 40, 4800, 'completed', '2025-04-14'),
(13, 5, 4, 80, 50, 4000, 'completed', '2025-04-14'),
(14, 1, 4, 50, 50, 2500, 'completed', '2025-04-29'),
(15, 2, 4, 180, 30, 5400, 'completed', '2025-04-29'),
(16, 3, 4, 120, 40, 4800, 'completed', '2025-04-29'),
(17, 5, 4, 80, 50, 4000, 'completed', '2025-04-29'),
(18, 4, 4, 240, 20, 4800, 'completed', '2025-03-20'),
(19, 6, 4, 160, 25, 4000, 'completed', '2025-03-20'),
(20, 7, 4, 280, 15, 4200, 'completed', '2025-03-20'),
(21, 10, 4, 140, 30, 4200, 'completed', '2025-03-20'),
(22, 4, 4, 240, 20, 4800, 'completed', '2025-04-19'),
(23, 6, 4, 160, 25, 4000, 'completed', '2025-04-19'),
(24, 7, 4, 280, 15, 4200, 'completed', '2025-04-19'),
(25, 10, 4, 140, 30, 4200, 'completed', '2025-04-19'),
(26, 8, 4, 450, 10, 4500, 'completed', '2025-03-25'),
(27, 9, 4, 380, 10, 3800, 'completed', '2025-03-25'),
(28, 11, 4, 180, 15, 2700, 'completed', '2025-03-25'),
(29, 12, 4, 160, 15, 2400, 'completed', '2025-03-25'),
(30, 8, 4, 450, 10, 4500, 'completed', '2025-04-24'),
(31, 9, 4, 380, 10, 3800, 'completed', '2025-04-24'),
(32, 11, 4, 180, 15, 2700, 'completed', '2025-04-24'),
(33, 12, 4, 160, 15, 2400, 'completed', '2025-04-24'),
(37, 1, 4, 50, 5, 250, 'completed', '2025-05-16'),
(38, 2, 4, 180, 50, 9000, 'completed', '2025-05-16'),
(51, 1, 4, 50, 50, 2500, 'pending', '2025-05-16'),
(52, 2, 4, 180, 30, 5400, 'pending', '2025-05-16'),
(53, 3, 4, 120, 40, 4800, 'pending', '2025-05-16'),
(54, 4, 4, 240, 20, 4800, 'pending', '2025-05-19'),
(55, 5, 4, 80, 50, 4000, 'pending', '2025-05-19'),
(56, 6, 4, 160, 25, 4000, 'pending', '2025-05-19'),
(57, 7, 4, 280, 15, 4200, 'pending', '2025-05-22'),
(58, 8, 4, 450, 10, 4500, 'pending', '2025-05-22'),
(59, 9, 4, 380, 10, 3800, 'pending', '2025-05-22'),
(60, 10, 4, 140, 30, 4200, 'pending', '2025-05-25'),
(61, 11, 4, 180, 15, 2700, 'pending', '2025-05-25'),
(62, 12, 4, 160, 15, 2400, 'pending', '2025-05-25'),
(63, 1, 4, 50, 50, 2500, 'pending', '2025-05-28'),
(64, 2, 4, 180, 30, 5400, 'pending', '2025-05-28'),
(65, 3, 4, 120, 40, 4800, 'pending', '2025-05-28'),
(66, 4, 4, 240, 20, 4800, 'pending', '2025-05-31'),
(67, 5, 4, 80, 50, 4000, 'pending', '2025-05-31'),
(68, 6, 4, 160, 25, 4000, 'pending', '2025-05-31'),
(69, 1, 4, 50, 1, 50, 'pending', '2025-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `user_sales_tbl`
--

CREATE TABLE `user_sales_tbl` (
  `s_id` int NOT NULL,
  `m_id` int NOT NULL,
  `pharmacy_id` int NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `total_amount` int NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `sales_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sales_tbl`
--

INSERT INTO `user_sales_tbl` (`s_id`, `m_id`, `pharmacy_id`, `price`, `quantity`, `total_amount`, `status`, `sales_date`) VALUES
(2, 1, 4, 60, 3, 180, 'completed', '2025-05-14'),
(3, 2, 4, 220, 2, 440, 'completed', '2025-05-14'),
(4, 5, 4, 100, 5, 500, 'completed', '2025-05-13'),
(5, 11, 4, 220, 1, 220, 'completed', '2025-05-13'),
(6, 3, 4, 150, 4, 600, 'completed', '2025-05-12'),
(7, 7, 4, 320, 1, 320, 'completed', '2025-05-12'),
(8, 1, 4, 60, 5, 300, 'completed', '2025-05-11'),
(9, 4, 4, 280, 2, 560, 'completed', '2025-05-11'),
(10, 6, 4, 190, 3, 570, 'completed', '2025-05-10'),
(11, 10, 4, 170, 6, 1020, 'completed', '2025-05-10'),
(12, 2, 4, 220, 1, 220, 'completed', '2025-05-09'),
(13, 8, 4, 500, 1, 500, 'completed', '2025-05-09'),
(14, 1, 4, 60, 4, 240, 'completed', '2025-05-08'),
(15, 5, 4, 100, 3, 300, 'completed', '2025-05-08'),
(16, 3, 4, 150, 2, 300, 'completed', '2025-05-07'),
(17, 9, 4, 420, 1, 420, 'completed', '2025-05-07'),
(18, 1, 4, 60, 6, 360, 'completed', '2025-05-06'),
(19, 12, 4, 190, 2, 380, 'completed', '2025-05-06'),
(20, 4, 4, 280, 1, 280, 'completed', '2025-05-05'),
(21, 7, 4, 320, 2, 640, 'completed', '2025-05-05'),
(22, 1, 4, 60, 4, 240, 'completed', '2025-05-04'),
(23, 6, 4, 190, 2, 380, 'completed', '2025-05-04'),
(24, 2, 4, 220, 3, 660, 'completed', '2025-05-03'),
(25, 11, 4, 220, 1, 220, 'completed', '2025-05-03'),
(26, 1, 4, 60, 5, 300, 'completed', '2025-05-02'),
(27, 5, 4, 100, 4, 400, 'completed', '2025-05-02'),
(28, 3, 4, 150, 2, 300, 'completed', '2025-05-01'),
(29, 8, 4, 500, 1, 500, 'completed', '2025-05-01'),
(30, 1, 4, 60, 3, 180, 'completed', '2025-04-30'),
(31, 4, 4, 280, 2, 560, 'completed', '2025-04-30'),
(32, 2, 4, 220, 1, 220, 'completed', '2025-04-29'),
(33, 10, 4, 170, 3, 510, 'completed', '2025-04-29'),
(34, 1, 4, 60, 4, 240, 'completed', '2025-04-28'),
(35, 7, 4, 320, 1, 320, 'completed', '2025-04-28'),
(36, 3, 4, 150, 3, 450, 'completed', '2025-04-27'),
(37, 9, 4, 420, 1, 420, 'completed', '2025-04-27'),
(38, 1, 4, 60, 5, 300, 'completed', '2025-04-26'),
(39, 5, 4, 100, 2, 200, 'completed', '2025-04-26'),
(40, 2, 4, 220, 2, 440, 'completed', '2025-04-25'),
(41, 12, 4, 190, 1, 190, 'completed', '2025-04-25'),
(42, 1, 4, 60, 3, 180, 'completed', '2025-04-24'),
(43, 6, 4, 190, 2, 380, 'completed', '2025-04-24'),
(44, 3, 4, 150, 4, 600, 'completed', '2025-04-23'),
(45, 11, 4, 220, 1, 220, 'completed', '2025-04-23'),
(46, 1, 4, 60, 6, 360, 'completed', '2025-04-22'),
(47, 4, 4, 280, 1, 280, 'completed', '2025-04-22'),
(48, 2, 4, 220, 2, 440, 'completed', '2025-04-21'),
(49, 8, 4, 500, 1, 500, 'completed', '2025-04-21'),
(50, 1, 4, 60, 4, 240, 'completed', '2025-04-20'),
(51, 5, 4, 100, 3, 300, 'completed', '2025-04-20'),
(52, 3, 4, 150, 2, 300, 'completed', '2025-04-19'),
(53, 10, 4, 170, 2, 340, 'completed', '2025-04-19'),
(54, 1, 4, 60, 5, 300, 'completed', '2025-04-18'),
(55, 7, 4, 320, 1, 320, 'completed', '2025-04-18'),
(56, 2, 4, 220, 3, 660, 'completed', '2025-04-17'),
(57, 9, 4, 420, 1, 420, 'completed', '2025-04-17'),
(58, 1, 4, 60, 4, 240, 'completed', '2025-04-16'),
(59, 6, 4, 190, 2, 380, 'completed', '2025-04-16'),
(60, 3, 4, 150, 3, 450, 'completed', '2025-04-15'),
(61, 12, 4, 190, 1, 190, 'completed', '2025-04-15'),
(62, 1, 4, 60, 5, 300, 'completed', '2025-04-14'),
(63, 5, 4, 100, 2, 200, 'completed', '2025-04-14'),
(64, 2, 4, 220, 2, 440, 'completed', '2025-04-13'),
(65, 11, 4, 220, 1, 220, 'completed', '2025-04-13'),
(66, 1, 4, 60, 3, 180, 'completed', '2025-04-12'),
(67, 4, 4, 280, 1, 280, 'completed', '2025-04-12'),
(68, 3, 4, 150, 4, 600, 'completed', '2025-04-11'),
(69, 8, 4, 500, 1, 500, 'completed', '2025-04-11'),
(70, 1, 4, 60, 6, 360, 'completed', '2025-04-10'),
(71, 7, 4, 320, 1, 320, 'completed', '2025-04-10'),
(72, 2, 4, 220, 2, 440, 'completed', '2025-04-09'),
(73, 10, 4, 170, 3, 510, 'completed', '2025-04-09'),
(74, 1, 4, 60, 4, 240, 'completed', '2025-04-08'),
(75, 6, 4, 190, 2, 380, 'completed', '2025-04-08'),
(76, 3, 4, 150, 3, 450, 'completed', '2025-04-07'),
(77, 9, 4, 420, 1, 420, 'completed', '2025-04-07'),
(78, 1, 4, 60, 5, 300, 'completed', '2025-04-06'),
(79, 5, 4, 100, 2, 200, 'completed', '2025-04-06'),
(80, 2, 4, 220, 1, 220, 'completed', '2025-04-05'),
(81, 12, 4, 190, 1, 190, 'completed', '2025-04-05'),
(82, 1, 4, 60, 15, 900, 'completed', '2025-04-04'),
(83, 4, 4, 280, 1, 280, 'completed', '2025-04-04'),
(84, 3, 4, 150, 2, 300, 'completed', '2025-04-03'),
(85, 11, 4, 220, 1, 220, 'completed', '2025-04-03'),
(86, 1, 4, 60, 4, 240, 'completed', '2025-04-02'),
(87, 8, 4, 500, 3, 1500, 'completed', '2025-04-02'),
(88, 2, 4, 220, 2, 440, 'completed', '2025-04-01'),
(89, 7, 4, 320, 1, 320, 'completed', '2025-04-01'),
(90, 1, 4, 60, 3, 180, 'completed', '2025-03-31'),
(91, 5, 4, 100, 2, 200, 'completed', '2025-03-31'),
(92, 3, 4, 150, 1, 150, 'completed', '2025-03-30'),
(93, 10, 4, 170, 2, 340, 'completed', '2025-03-30'),
(94, 1, 4, 60, 4, 240, 'completed', '2025-03-29'),
(95, 6, 4, 190, 1, 190, 'completed', '2025-03-29'),
(96, 2, 4, 220, 3, 660, 'completed', '2025-03-28'),
(97, 9, 4, 420, 1, 420, 'completed', '2025-03-28'),
(98, 1, 4, 60, 5, 300, 'completed', '2025-03-27'),
(99, 4, 4, 280, 1, 280, 'completed', '2025-03-27'),
(100, 3, 4, 150, 2, 300, 'completed', '2025-03-26'),
(101, 1, 4, 60, 5, 300, 'completed', '2025-05-15'),
(102, 3, 4, 150, 3, 450, 'completed', '2025-05-15'),
(103, 8, 4, 500, 1, 500, 'completed', '2025-05-15'),
(104, 2, 4, 220, 2, 440, 'completed', '2025-05-16'),
(105, 5, 4, 100, 4, 400, 'completed', '2025-05-16'),
(106, 10, 4, 170, 2, 340, 'completed', '2025-05-16'),
(107, 1, 4, 60, 6, 360, 'completed', '2025-05-17'),
(108, 4, 4, 280, 1, 280, 'completed', '2025-05-17'),
(109, 12, 4, 190, 2, 380, 'completed', '2025-05-17'),
(110, 3, 4, 150, 3, 450, 'completed', '2025-05-18'),
(111, 6, 4, 190, 2, 380, 'completed', '2025-05-18'),
(112, 9, 4, 420, 1, 420, 'completed', '2025-05-18'),
(113, 1, 4, 60, 4, 240, 'completed', '2025-05-19'),
(114, 7, 4, 320, 2, 640, 'completed', '2025-05-19'),
(115, 11, 4, 220, 1, 220, 'completed', '2025-05-19'),
(116, 2, 4, 220, 3, 660, 'completed', '2025-05-20'),
(117, 5, 4, 100, 5, 500, 'completed', '2025-05-20'),
(118, 8, 4, 500, 1, 500, 'completed', '2025-05-20'),
(119, 1, 4, 60, 7, 420, 'completed', '2025-05-21'),
(120, 4, 4, 280, 2, 560, 'completed', '2025-05-21'),
(121, 10, 4, 170, 3, 510, 'completed', '2025-05-21'),
(122, 3, 4, 150, 4, 600, 'completed', '2025-05-22'),
(123, 6, 4, 190, 3, 570, 'completed', '2025-05-22'),
(124, 12, 4, 190, 2, 380, 'completed', '2025-05-22'),
(125, 1, 4, 60, 5, 300, 'completed', '2025-05-23'),
(126, 7, 4, 320, 1, 320, 'completed', '2025-05-23'),
(127, 9, 4, 420, 1, 420, 'completed', '2025-05-23'),
(128, 2, 4, 220, 2, 440, 'completed', '2025-05-24'),
(129, 5, 4, 100, 3, 300, 'completed', '2025-05-24'),
(130, 11, 4, 220, 1, 220, 'completed', '2025-05-24'),
(131, 1, 4, 60, 6, 360, 'completed', '2025-05-25'),
(132, 4, 4, 280, 2, 560, 'completed', '2025-05-25'),
(133, 8, 4, 500, 1, 500, 'completed', '2025-05-25'),
(134, 3, 4, 150, 3, 450, 'completed', '2025-05-26'),
(135, 6, 4, 190, 2, 380, 'completed', '2025-05-26'),
(136, 10, 4, 170, 2, 340, 'completed', '2025-05-26'),
(137, 1, 4, 60, 4, 240, 'completed', '2025-05-27'),
(138, 7, 4, 320, 2, 640, 'completed', '2025-05-27'),
(139, 12, 4, 190, 1, 190, 'completed', '2025-05-27'),
(140, 2, 4, 220, 3, 660, 'completed', '2025-05-28'),
(141, 5, 4, 100, 4, 400, 'completed', '2025-05-28'),
(142, 9, 4, 420, 1, 420, 'completed', '2025-05-28'),
(143, 1, 4, 60, 5, 300, 'completed', '2025-05-29'),
(144, 4, 4, 280, 1, 280, 'completed', '2025-05-29'),
(145, 11, 4, 220, 2, 440, 'completed', '2025-05-29'),
(146, 3, 4, 150, 4, 600, 'completed', '2025-05-30'),
(147, 6, 4, 190, 3, 570, 'completed', '2025-05-30'),
(148, 8, 4, 500, 1, 500, 'completed', '2025-05-30'),
(149, 1, 4, 60, 7, 420, 'completed', '2025-05-31'),
(150, 7, 4, 320, 2, 640, 'completed', '2025-05-31'),
(151, 10, 4, 170, 3, 510, 'completed', '2025-05-31'),
(152, 6, 4, 190, 2, 380, 'pending', '2025-06-01'),
(153, 7, 4, 320, 2, 640, 'pending', '2025-06-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `tbl_pharmacy`
--
ALTER TABLE `tbl_pharmacy`
  ADD PRIMARY KEY (`pharmacy_id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`);

--
-- Indexes for table `user_category_tbl`
--
ALTER TABLE `user_category_tbl`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`);

--
-- Indexes for table `user_medicine_tbl`
--
ALTER TABLE `user_medicine_tbl`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `user_medicine_tbl_ibfk_1` (`c_id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`);

--
-- Indexes for table `user_order_tbl`
--
ALTER TABLE `user_order_tbl`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `m_id` (`m_id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`);

--
-- Indexes for table `user_sales_tbl`
--
ALTER TABLE `user_sales_tbl`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `m_id` (`m_id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user_category_tbl`
--
ALTER TABLE `user_category_tbl`
  MODIFY `c_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_medicine_tbl`
--
ALTER TABLE `user_medicine_tbl`
  MODIFY `m_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user_order_tbl`
--
ALTER TABLE `user_order_tbl`
  MODIFY `o_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `user_sales_tbl`
--
ALTER TABLE `user_sales_tbl`
  MODIFY `s_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD CONSTRAINT `tbl_admin_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `role` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pharmacy`
--
ALTER TABLE `tbl_pharmacy`
  ADD CONSTRAINT `tbl_pharmacy_ibfk_1` FOREIGN KEY (`pharmacy_id`) REFERENCES `role` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_category_tbl`
--
ALTER TABLE `user_category_tbl`
  ADD CONSTRAINT `user_category_tbl_ibfk_1` FOREIGN KEY (`pharmacy_id`) REFERENCES `role` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_medicine_tbl`
--
ALTER TABLE `user_medicine_tbl`
  ADD CONSTRAINT `user_medicine_tbl_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `user_category_tbl` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_medicine_tbl_ibfk_2` FOREIGN KEY (`pharmacy_id`) REFERENCES `role` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_order_tbl`
--
ALTER TABLE `user_order_tbl`
  ADD CONSTRAINT `user_order_tbl_ibfk_1` FOREIGN KEY (`m_id`) REFERENCES `user_medicine_tbl` (`m_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_order_tbl_ibfk_2` FOREIGN KEY (`pharmacy_id`) REFERENCES `role` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_sales_tbl`
--
ALTER TABLE `user_sales_tbl`
  ADD CONSTRAINT `user_sales_tbl_ibfk_1` FOREIGN KEY (`m_id`) REFERENCES `user_medicine_tbl` (`m_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_sales_tbl_ibfk_2` FOREIGN KEY (`pharmacy_id`) REFERENCES `role` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
