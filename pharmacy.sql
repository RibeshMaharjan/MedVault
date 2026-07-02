-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jun 05, 2026 at 08:38 AM
-- Server version: 8.0.45
-- PHP Version: 8.3.26

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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `pharmacy_id` int NOT NULL,
  `medicine_id` int DEFAULT NULL,
  `quantity` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`pharmacy_id`, `medicine_id`, `quantity`) VALUES
(325, 49, '1'),
(325, 59, '1'),
(328, 41, '1'),
(328, 40, '1'),
(328, 29, '1'),
(335, 46, '1'),
(341, 68, '1'),
(343, 44, '1'),
(343, 30, '1'),
(345, 46, '1');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `medicine_id` int NOT NULL,
  `medicine_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `manufacturer` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `expiration_date` date NOT NULL,
  `dosage` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`medicine_id`, `medicine_name`, `manufacturer`, `price`, `quantity`, `expiration_date`, `dosage`, `image`) VALUES
(1, 'Amoxicillin', 'DEF Pharma', 21, 50, '2024-10-31', 'tablet', '../uploaded_img/../uploaded_img/65eaec84b35323.13358919.Cetirizine.jpg'),
(2, 'Ibuprofen', 'XYZ Healthcare', 16, 5, '2024-11-30', 'tablet', '../uploaded_img/../uploaded_img/65eaec80465a89.51523420.ibuprofen.jpg'),
(3, 'Cetirizine', 'RST Pharmaceuticals', 6, 50, '2023-08-31', 'tablet', '../uploaded_img/../uploaded_img/65eaeca68a4958.76086271.Cetirizine.jpg'),
(4, 'Clarithromycin Capsules', 'STU Healthcare', 24, 60, '2024-05-31', 'capsule', '../uploaded_img/../uploaded_img/65eb0d3768be66.79189083.Clarithromycin.jpg'),
(5, 'Amoxicillin', 'PQR Pharmaceuticals', 10, 100, '2023-10-31', 'tablet', '../uploaded_img/../uploaded_img/65eaecb62e7f02.44627582.amoxicillin.jpg'),
(6, 'Aspirin', 'LMN Pharma', 4, 500, '2023-09-30', 'tablet', '../uploaded_img/../uploaded_img/65eaecad7eb759.41173068.Aspirin.jpg'),
(7, 'Ciprofloxacin Capsules', 'ABC Pharmaceuticals', 16, 1, '2024-12-31', 'capsule', '../uploaded_img/../uploaded_img/65eb02f2829d12.92441478.ciprofloxacin.jpg'),
(8, 'Paracetamol', 'ABC Pharmaceuticals', 600, 6, '2023-12-31', 'tablet', '../uploaded_img/../uploaded_img/65eafee5077664.30444530.paracetamol.jpg'),
(9, 'Paracetamol', 'ABC Pharmaceuticals', 600, 6, '2023-12-31', 'tablet', '../uploaded_img/../uploaded_img/65eafee5077664.30444530.paracetamol.jpg'),
(10, 'Paracetamol', 'ABC Pharmaceuticals', 600, 6, '2023-12-31', 'tablet', '../uploaded_img/../uploaded_img/65eafee5077664.30444530.paracetamol.jpg'),
(11, 'Ampicillin Capsules', 'MNO Pharma', 17, 1, '2024-05-20', 'capsule', '../uploaded_img/../uploaded_img/65eb0d2f7688f2.95035386.Ampicillin.jpg'),
(12, 'Amoxicillin', 'PQR Pharmaceuticals', 10, 2, '2023-10-31', 'tablet', '../uploaded_img/../uploaded_img/65eaecb62e7f02.44627582.amoxicillin.jpg'),
(13, 'Metronidazole Capsules', 'VWX Pharma', 25, 10, '2024-04-30', 'capsule', '../uploaded_img/../uploaded_img/65eb0d405bbd10.95243484.Metronidazole.jpg'),
(14, 'Ibuprofen', 'XYZ Healthcare', 16, 15, '2024-05-30', 'tablet', '../uploaded_img/../uploaded_img/65eaec80465a89.51523420.ibuprofen.jpg'),
(15, 'Amoxicillin', 'PQR Pharmaceuticals', 10, 1, '2023-10-31', 'tablet', '../uploaded_img/../uploaded_img/65eaecb62e7f02.44627582.amoxicillin.jpg'),
(16, 'Paracetamol', 'ABC Pharmaceuticals', 600, 1, '2023-12-31', 'tablet', '../uploaded_img/../uploaded_img/65eafee5077664.30444530.paracetamol.jpg'),
(17, 'Doxycycline Capsules', 'GHI Pharmaceuticals', 400, 10, '2024-05-30', 'capsule', '../uploaded_img/../uploaded_img/65eb07bce43668.94022795.Doxycycline.jpg'),
(18, 'Doxycycline Capsules', 'GHI Pharmaceuticals', 400, 1, '2024-05-30', 'capsule', '../uploaded_img/../uploaded_img/65eb07bce43668.94022795.Doxycycline.jpg'),
(19, 'Ibuprofen', 'XYZ Pharma', 8, 1, '2023-05-30', 'tablet', '../uploaded_img/../uploaded_img/65eaecbd752f19.98655829.ibuprofen.jpg'),
(20, 'Ampicillin Capsules', 'MNO Pharma', 17, 100, '2024-05-20', 'capsule', '../uploaded_img/../uploaded_img/65eb0d2f7688f2.95035386.Ampicillin.jpg'),
(21, 'test', 'imagetest', 50, 1, '2025-09-25', 'tablet', '../uploaded_img/../uploaded_img/66462e9c0ba989.58285218.png'),
(22, 'test', 'tewt', 120, 1, '2027-08-20', 'tablet', '../uploaded_img/../uploaded_img/664627a65e9090.68231886.png');

-- --------------------------------------------------------

--
-- Table structure for table `order_address`
--

CREATE TABLE `order_address` (
  `order_id` int NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `postal` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_address`
--

INSERT INTO `order_address` (`order_id`, `city`, `province`, `street`, `postal`) VALUES
(36, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(37, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(38, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(39, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(40, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(44, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(47, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(36, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(37, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(38, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(39, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(40, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(44, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(47, 'Kathmandu', 'bagamti', 'samakhsui', 845),
(25852, 'ktm', 'bagmati', 'samakhusi', 845),
(67086, 'ktm', 'bagmati', 'samakhusi', 845),
(56175, 'ktm', 'bagmati', 'samakhusi', 845),
(56319, 'ktm', 'bagmati', 'samakhusi', 845),
(33711, 'ktm', 'bagmati', 'samakhusi', 845),
(54304, 'ktm', 'bagmati', 'samakhusi', 845),
(33949, 'ktm', 'bagmati', 'samakhusi', 845),
(86966, 'ktm', 'bagmati', 'samakhusi', 845),
(19743, 'ktm', 'bagmati', 'samakhusi', 845),
(48347, 'ktm', 'bagmati', 'samakhusi', 845),
(56305, 'ktm', 'bagmati', 'samakhusi', 845),
(93369, 'ktm', 'bagmati', 'samakhusi', 845),
(81577, 'ktm', 'bagmati', 'samakhusi', 845),
(49549, 'ktm', 'bagmati', 'samakhusi', 845),
(16408, 'ktm', 'bagmati', 'samakhusi', 845),
(26388, 'ktm', 'bagmati', 'samakhusi', 845),
(43132, 'ktm', 'bagmati', 'samakhusi', 845),
(57557, 'ktm', 'bagmati', 'samakhusi', 845),
(94412, 'ktm', 'bagmati', 'samakhusi', 845),
(17801, 'ktm', 'bagmati', 'samakhusi', 845),
(43163, 'ktm', 'bagmati', 'samakhusi', 845),
(88139, 'ktm', 'bagmati', 'samakhusi', 845),
(96256, 'ktm', 'bagmati', 'samakhusi', 845),
(62354, 'ktm', 'bagmati', 'samakhusi', 75454),
(34788, 'ktm', 'bagmati', 'samakhusi', 75454),
(14050, 'ktm', 'bagmati', 'samakhusi', 75454),
(58606, 'ktm', 'bagmati', 'samakhusi', 845),
(94334, 'kathmandu', 'bagmati', 'samakhusi', 845),
(80533, 'ktm', 'bagmati', 'samakhusi', 845),
(70623, 'ktm', 'bagmati', 'samakhusi', 845),
(55693, 'ktm', 'bagmati', 'samakhusi', 845),
(67320, 'ktm', 'bagmati', 'samakhusi', 845),
(73090, 'ktm', 'bagmati', 'samakhusi', 845),
(49982, 'ktm', 'bagmati', 'samakhusi', 845),
(33301, 'ktm', 'bagmati', 'samakhusi', 845),
(66569, 'ktm', 'bagmati', 'samakhusi', 845),
(30228, 'ktm', 'bagmati', 'samakhusi', 845),
(16796, 'ktm', 'bagmati', 'samakhusi', 845);

-- --------------------------------------------------------

--
-- Table structure for table `order_completed`
--

CREATE TABLE `order_completed` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `medicine_id` int NOT NULL,
  `invoice_number` int NOT NULL,
  `total_products` int NOT NULL,
  `amount` int NOT NULL,
  `order_status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_completed`
--

INSERT INTO `order_completed` (`order_id`, `user_id`, `medicine_id`, `invoice_number`, `total_products`, `amount`, `order_status`) VALUES
(40, 89, 28, 843474316, 50, 1050, 'COMPLETED'),
(39, 89, 28, 1059066821, 50, 1050, 'COMPLETED'),
(36, 89, 28, 585198250, 5, 105, 'COMPLETED'),
(37, 89, 28, 1997059983, 5, 105, 'COMPLETED'),
(40, 89, 28, 843474316, 50, 1050, 'COMPLETED'),
(39, 89, 28, 1059066821, 50, 1050, 'COMPLETED'),
(36, 89, 28, 585198250, 5, 105, 'COMPLETED'),
(37, 89, 28, 1997059983, 5, 105, 'COMPLETED'),
(36, 89, 28, 585198250, 5, 105, 'COMPLETED'),
(38, 89, 28, 80453203, 50, 1050, 'COMPLETED'),
(56175, 89, 40, 2030077539, 50, 0, 'COMPLETED'),
(47, 0, 38, 816609579, 500, 2000, 'COMPLETED'),
(44, 0, 40, 628135818, 50, 300, 'COMPLETED'),
(14050, 332, 1, 1206274080, 6, 600, 'COMPLETED'),
(16408, 89, 30, 720704263, 1, 8, 'COMPLETED'),
(17801, 325, 49, 1161932613, 1, 25, 'COMPLETED'),
(19743, 89, 40, 1872426216, 20, 120, 'COMPLETED');

-- --------------------------------------------------------

--
-- Table structure for table `order_pending`
--

CREATE TABLE `order_pending` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `medicine_id` int NOT NULL,
  `invoice_number` int NOT NULL,
  `total_products` int NOT NULL,
  `amount` int NOT NULL,
  `order_status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_pending`
--

INSERT INTO `order_pending` (`order_id`, `user_id`, `medicine_id`, `invoice_number`, `total_products`, `amount`, `order_status`) VALUES
(16796, 0, 60, 1882782524, 1, 120, 'pending'),
(25852, 0, 45, 639759943, 1, 23, 'pending'),
(26388, 89, 44, 875518175, 1, 400, 'pending'),
(30228, 0, 61, 2011195794, 1, 50, 'pending'),
(33301, 343, 30, 49143488, 1, 8, 'pending'),
(33711, 89, 1, 569188370, 1, 600, 'pending'),
(33949, 89, 40, 100604680, 100, 600, 'pending'),
(34788, 332, 1, 1708154083, 6, 600, 'pending'),
(43132, 89, 48, 80531716, 1, 24, 'pending'),
(43163, 328, 41, 942736564, 1, 16, 'pending'),
(48347, 89, 29, 870279301, 1, 5, 'pending'),
(49549, 89, 37, 1700156350, 7, 70, 'pending'),
(49982, 343, 44, 622474967, 1, 400, 'pending'),
(54304, 89, 40, 288672563, 500, 3000, 'pending'),
(55693, 89, 37, 1738191621, 1, 10, 'pending'),
(56305, 89, 1, 353150699, 10, 6000, 'pending'),
(56319, 89, 40, 1697005780, 50, 0, 'pending'),
(57557, 89, 27, 1195905562, 1, 16, 'pending'),
(58606, 335, 46, 61027118, 1, 17, 'pending'),
(62354, 332, 1, 562888123, 6, 3600, 'pending'),
(66569, 345, 46, 1090476391, 100, 1700, 'pending'),
(67086, 0, 44, 1267960450, 1, 400, 'pending'),
(67320, 89, 1, 68699549, 1, 600, 'pending'),
(70623, 89, 27, 1759209151, 15, 240, 'pending'),
(73090, 343, 44, 1938624537, 10, 4000, 'pending'),
(80533, 89, 49, 1467308308, 10, 250, 'pending'),
(81577, 89, 1, 1664966557, 1, 600, 'pending'),
(86966, 89, 1, 409718772, 10, 6000, 'pending'),
(88139, 328, 41, 230033320, 1, 16, 'pending'),
(93369, 89, 1, 2037273208, 1, 600, 'pending'),
(94334, 89, 37, 701311092, 2, 20, 'pending'),
(94412, 325, 27, 363303791, 100, 1600, 'pending'),
(96256, 328, 41, 202471477, 1, 16, 'pending');

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
(18, 'Ribesh Majarjan', 'ribesh@admin.gmail.com', '$2y$10$s0GYtiGf4GU0i8eqrdwoeeK0VshD/wpgGiasIJakuLIWphI82MhpS', 'admin'),
(89, 'Pharmacy', 'pharmacy@gmail.com', '$2y$10$s0GYtiGf4GU0i8eqrdwoeeK0VshD/wpgGiasIJakuLIWphI82MhpS', 'user'),
(90, 'ribesh', 'ribe@gmail.com', '$2y$10$s0GYtiGf4GU0i8eqrdwoeeK0VshD/wpgGiasIJakuLIWphI82MhpS', 'user'),
(123, 'Rijan Bajracharya', 'rijan@admin.gmail.com', '$2y$10$s0GYtiGf4GU0i8eqrdwoeeK0VshD/wpgGiasIJakuLIWphI82MhpS', 'admin'),
(125, 'Remon', 'remon@admin.gmail.com', '$2y$10$I.vKlQpB.GrA0bPTmO62A.Eswy4CB2CExaDEp4bvtPBh0V5ceFBJe', 'admin'),
(129, 'test', 'test@gmail.com', 'test', 'user'),
(319, 'asdad', 'asdad@admin.gmail.com', 'asdad', 'user'),
(325, '123Assura', 'testsignup@gmail.com', '$2y$10$JGLxe2vqP5E1YjVs9q7xFe0uD6Z6QWqigJxvqDW4tFQUcBQJedR/e', 'user'),
(326, 'paracetamol', 'paracetamol@admin.gmail.com', 'paracetamol', 'user'),
(328, 'by', 'by@gmail.com', '$2y$10$6IX6JCxHAFQpSSK.1AFSr.xY22Qic1YjxDOKsoy0ONqtyoLqnNwaq', 'user'),
(333, 'pantest', 'pantest@gmail.com', '$2y$10$g5mGb.U8fhw3bkB/Un4m9u/igIayOdL/YxZ6dTSlLmX.QLP7IWcs2', 'user'),
(334, 'error', 'error@gmail.com', '$2y$10$yG1Nyq1S3D.oF3wHfOCo4e8rsvimSYXybAuPz1BiCKI6BC1WP./ou', 'user'),
(335, 'krees', 'krees@gmail', '$2y$10$jeHLWaQgYL26AJunIuuDr.h.oLqCQAifdBQFLvdTGws2KM/hnS7V6', 'user'),
(336, 'newpharmacy', 'newpharmacy@gmail.com', '$2y$10$NNSJmawC/5F7kpWSK43BtO/UyMAaTQd6Gi6uendMQP73DJX4LvqJi', 'user'),
(338, 'password', 'password@gmail.com', '$2y$10$SN62t.7Vr2JS6Zrxtw6/aOxqHRxocgHMNvGAmnU6MteR5tQtga57G', 'user'),
(341, 'danesh', 'da@gmail.com', '$2y$10$XZ/FpaoRuVgiL7Fk6LXXNeyDdRdKGYrozXEfVh5KnmU53HxT5fF2K', 'user'),
(343, 'sam', 'sam@gmail.com', '$2y$10$T5zVlaAWYrbffE3gHtssfOhb0aFjpufjpTGeN0ncX7J6KbleQCEva', 'user'),
(345, 'sam pharmacy', 'sampharmacy@gmail.com', '$2y$10$G5F8ICj9KHaa9qU3468UmelraCLf2Ea/1HUXkP6tAN3ndf9Ug8Kcm', 'user'),
(346, 'signuptest', 'signup@gmail.com', '$2y$10$Ln5M7dDGDHlerT2pIjtH0OUoKMBGC1EYQt3JzBRobhq0bzoFRdnrK', 'user'),
(347, 'testin', 'ribesh@test.com', '$2y$10$bimB0ZodRcSNmK5Iw6IiZuLbkEZQWR3poxiCoztoBja6WGNsLuAuO', 'user'),
(348, 'asdasda', 'testing@password.com', '$2y$10$s0GYtiGf4GU0i8eqrdwoeeK0VshD/wpgGiasIJakuLIWphI82MhpS', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `small_description` text COLLATE utf8mb4_general_ci,
  `sub_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sub_description` text COLLATE utf8mb4_general_ci,
  `phone` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `small_description`, `sub_title`, `sub_description`, `phone`, `email`) VALUES
(1, 'WELLNESS STARTS HERE!!!!', 'Welcome to our online pharmacy platform, where convenience meets care. Our website provides a secure and user-friendly environment for individuals to access a range of pharmaceutical services tailored to their needs.', 'WELLNESS STARTS HERE!!!', 'Experience the ease and efficiency of managing your medications online with our pharmacy platform.', '9840455685', 'medvault@gmail.com');

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
(18, 'Ribesh Majarjan', 'ribesh@admin.gmail.com', 'male', '9802564589', '2002-12-04', 'samakhusi'),
(18, 'Ribesh Majarjan', 'ribesh@admin.gmail.com', 'male', '9802564589', '2002-12-04', 'samakhusi'),
(123, 'Rijan Bajracharya', 'rijan@admin.gmail.com', 'male', '9845621475', '2002-08-09', 'lagan'),
(125, 'Remon Buddhacharya', 'remon@admin.gmail.com', 'male', '8945621423', '2002-05-02', 'swyombhu');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_medicine`
--

CREATE TABLE `tbl_medicine` (
  `medicine_id` int NOT NULL,
  `medicine_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `medicine_description` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `manufacturer` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `expiration_date` date NOT NULL,
  `dosage` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `images` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_medicine`
--

INSERT INTO `tbl_medicine` (`medicine_id`, `medicine_name`, `medicine_description`, `manufacturer`, `price`, `quantity`, `expiration_date`, `dosage`, `images`) VALUES
(1, 'Paracetamol', 'Paracetamol is a medicine used for mild to moderate pain.\r\nParacetamol 500mg', 'ABC Pharmaceuticals', 600, 100, '2023-12-31', 'tablet', '../uploaded_img/65eafee5077664.30444530.paracetamol.jpg'),
(27, 'Ibuprofen', 'Nonprescription ibuprofen is used to reduce fever and to relieve minor aches and pain from headaches, muscle aches, arthritis, menstrual periods, the common cold, toothaches, and backaches.', 'XYZ Healthcare', 16, 50, '2024-05-30', 'tablet', '../uploaded_img/65eaec80465a89.51523420.ibuprofen.jpg'),
(28, 'Amoxicillin', NULL, 'DEF Pharma', 21, 30, '2024-10-31', 'tablet', '../uploaded_img/65eaec84b35323.13358919.Cetirizine.jpg'),
(29, 'Paracetamol', NULL, 'ABC Pharmaceuticals', 5, 100, '2024-05-30', 'tablet', '../uploaded_img/65eaec99384290.35758204.paracetamol.jpg'),
(30, 'Ibuprofen', NULL, 'XYZ Pharma', 8, 75, '2023-05-30', 'tablet', '../uploaded_img/65eaecbd752f19.98655829.ibuprofen.jpg'),
(37, 'Amoxicillin', NULL, 'PQR Pharmaceuticals', 10, 50, '2023-10-31', 'tablet', '../uploaded_img/65eaecb62e7f02.44627582.amoxicillin.jpg'),
(38, 'Aspirin', NULL, 'LMN Pharma', 4, 120, '2023-09-30', 'tablet', '../uploaded_img/65eaecad7eb759.41173068.Aspirin.jpg'),
(40, 'Cetirizine', NULL, 'RST Pharmaceuticals', 6, 90, '2023-08-31', 'tablet', '../uploaded_img/65eaeca68a4958.76086271.Cetirizine.jpg'),
(41, 'Ciprofloxacin Capsules', NULL, 'ABC Pharmaceuticals', 16, 50, '2024-12-31', 'capsule', '../uploaded_img/65eb02f2829d12.92441478.ciprofloxacin.jpg'),
(42, 'Naproxen', NULL, 'XYZ Healthcare', 130, 100, '2024-11-30', 'capsule', '../uploaded_img/65eb0302cb59f2.30715562.Naproxen.jpg'),
(43, 'Ranitidine Capsule', NULL, 'DEF Pharma', 19, 30, '2024-10-31', 'capsule', '../uploaded_img/65eb0464112798.20942857.Ranitidine.jpg'),
(44, 'Doxycycline Capsules', NULL, 'GHI Pharmaceuticals', 400, 70, '2024-05-30', 'capsule', '../uploaded_img/65eb07bce43668.94022795.Doxycycline.jpg'),
(46, 'Ampicillin Capsules', NULL, 'MNO Pharma', 17, 60, '2024-05-20', 'capsule', '../uploaded_img/65eb0d2f7688f2.95035386.Ampicillin.jpg'),
(48, 'Clarithromycin Capsules', NULL, 'STU Healthcare', 24, 85, '2024-05-31', 'capsule', '../uploaded_img/65eb0d3768be66.79189083.Clarithromycin.jpg'),
(49, 'Metronidazole Capsules', NULL, 'VWX Pharma', 25, 55, '2024-04-30', 'capsule', '../uploaded_img/65eb0d405bbd10.95243484.Metronidazole.jpg'),
(59, 'test', NULL, 'manu', 4200, 20, '2024-05-25', 'capsule', '../uploaded_img/66462b8cb064a1.21205651.png'),
(60, 'test', NULL, 'tewt', 120, 20, '2027-08-20', 'tablet', '../uploaded_img/664627a65e9090.68231886.png'),
(61, 'test', NULL, 'imagetest', 50, 20, '2025-09-25', 'tablet', '../uploaded_img/66462e9c0ba989.58285218.png'),
(62, 'newmedicine', NULL, 'asda', 2300, 12, '1970-01-01', 'tablet', '../uploaded_img/66904caf635c93.95158811.jpg'),
(65, 'asadd', NULL, 'asdad', 20, 20, '2030-12-12', 'tablet', '../uploaded_img/66904ca3d024c6.20791652.jpg'),
(68, 'newmedicine', NULL, 'newmanud', 23000, 12, '2030-12-12', 'tablet', '../uploaded_img/66901aac5c1055.38583994.jpg'),
(70, 'new cetamol', NULL, 'dfs co', 50, 20, '2030-01-20', 'tablet', '../uploaded_img/669089b1969010.41432018.jpg'),
(71, 'testing', NULL, 'tsting', 12, 20, '2030-12-12', 'capsule', '../uploaded_img/66909c17c629d9.40420607.jpg'),
(72, 'trestinggg', NULL, 'trsting', 120, 3, '2030-12-12', 'tablet', '../uploaded_img/66909c3ff0abd8.91383333.jpg'),
(73, 'testing', NULL, 'testing', 300, 20, '2024-05-10', 'capsule', '../uploaded_img/66909c736d8124.25609616.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pharmacy`
--

CREATE TABLE `tbl_pharmacy` (
  `pharmacy_id` int NOT NULL,
  `pan` int DEFAULT NULL,
  `pharmacy_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isverified` tinyint(1) NOT NULL DEFAULT '0',
  `license_number` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reg_document` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `verification_request_date` datetime DEFAULT NULL,
  `verification_date` datetime DEFAULT NULL,
  `verification_notes` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pharmacy`
--

INSERT INTO `tbl_pharmacy` (`pharmacy_id`, `pan`, `pharmacy_name`, `email`, `phone`, `address`) VALUES
(129, 424242, 'test', 'test@gmail.com', '9840545629', 'thamel1'),
(319, 9845, 'asdad', 'asdad@admin.gmail.com', '9840545628', 'asdad'),
(325, 98745621, '123Assura', 'testsignup@gmail.com', '9841564152', 'swoyambhu'),
(328, 98415, 'by', 'by@gmail.com', '9841562145', 'thamel'),
(333, 564578, 'pantest', 'pantest@gmail.com', '', ''),
(334, 2147483647, 'error', 'error@gmail.com', '', ''),
(335, 3564, 'krees', 'krees@gmail', '', ''),
(336, 45612, 'newpharmacy', 'newpharmacy@gmail.com', '9841562342', 'thamel'),
(338, 121213, 'password', 'password@gmail.com', '', ''),
(341, 101010, 'danesh', 'da@gmail.com', '', ''),
(343, 12345, 'sam', 'sam@gmail.com', '', ''),
(345, 9845236, 'sam pharmacy', 'sampharmacy@gmail.com', '9841564231', 'jyatha'),
(346, 987456123, 'signuptest', 'signup@gmail.com', '', ''),
(347, NULL, 'testin', 'ribesh@test.com', NULL, NULL),
(348, NULL, 'asdasda', 'testing@password.com', NULL, NULL);

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
(8, 90, 'ribeshtest'),
(14, 18, 'test'),
(15, 18, 'test2'),
(19, 325, 'test'),
(20, 89, 'tablets'),
(21, 89, 'capsule'),
(22, 345, 'tablets');

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
(8, 18, 'Test', 'test', 8, 50, 20, 30, '2024-05-17 06:30:04', '2024-05-25'),
(15, 89, 'test', 'test', 8, 50, 50, 50, '2024-05-19 08:22:40', '2020-12-22'),
(22, 89, 'cetamol 2', 'medicine', 20, 50, 50, 60, '2024-07-11 17:30:10', '2030-11-12'),
(24, 89, 'asdasd', 'asdasdad', 20, 12, 1200, 1300, '2024-07-11 21:48:05', '2030-12-12'),
(25, 89, 'painkiller 5', 'medicine', 20, 50, 20, 25, '2024-07-12 01:21:19', '2030-12-11'),
(26, 345, 'tesmedicine', 'tesing', 22, 20, 2000, 3000, '2024-07-12 02:37:00', '2023-12-12'),
(50, 89, 'Paracetamol 500mg', 'Analgesic and antipyretic', 20, 500, 10, 15, '2026-01-01 00:00:00', '2028-12-31'),
(51, 89, 'Amoxicillin 250mg', 'Antibiotic for bacterial infections', 21, 300, 18, 25, '2026-01-01 00:00:00', '2028-12-31'),
(52, 89, 'Ibuprofen 400mg', 'Anti-inflammatory pain relief', 20, 200, 14, 20, '2026-01-01 00:00:00', '2028-12-31'),
(53, 89, 'Vitamin C 500mg', 'Immunity boosting supplement', 20, 400, 22, 30, '2026-01-01 00:00:00', '2028-12-31'),
(54, 89, 'Metformin 500mg', 'Oral diabetes medication', 20, 150, 12, 18, '2026-01-01 00:00:00', '2028-12-31'),
(55, 89, 'alu', 'kjbjaskjcbajkbchas cjkas hkac', 20, 20, 100, 200, '2026-05-22 01:49:28', '2026-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `medicine_id` int NOT NULL,
  `invoice_number` int NOT NULL,
  `total_products` int NOT NULL,
  `amount` int NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`order_id`, `user_id`, `medicine_id`, `invoice_number`, `total_products`, `amount`, `order_date`, `order_status`) VALUES
(36, 89, 28, 585198250, 5, 105, '2024-03-19 03:39:43', 'COMPLETED'),
(37, 89, 28, 1997059983, 5, 105, '2024-03-25 13:44:31', 'COMPLETED'),
(38, 89, 28, 80453203, 50, 1050, '2024-05-01 16:31:02', 'COMPLETED'),
(39, 89, 28, 1059066821, 50, 1050, '2024-03-16 08:15:40', 'COMPLETED'),
(40, 89, 28, 843474316, 50, 1050, '2024-03-16 08:14:20', 'COMPLETED'),
(44, 0, 40, 628135818, 50, 300, '2024-05-19 06:29:30', 'COMPLETED'),
(47, 0, 38, 816609579, 500, 2000, '2024-05-01 17:01:29', 'COMPLETED'),
(14050, 332, 1, 1206274080, 6, 600, '2024-07-10 06:38:55', 'COMPLETED'),
(16408, 89, 30, 720704263, 1, 8, '2024-07-11 10:27:51', 'COMPLETED'),
(16796, 0, 60, 1882782524, 1, 120, '2024-09-13 14:17:33', 'pending'),
(17801, 325, 49, 1161932613, 1, 25, '2024-07-11 18:11:42', 'COMPLETED'),
(19743, 89, 40, 1872426216, 20, 120, '2024-07-12 02:49:56', 'COMPLETED'),
(25852, 0, 45, 639759943, 1, 23, '2024-04-29 06:40:20', 'pending'),
(26388, 89, 44, 875518175, 1, 400, '2024-05-19 06:46:05', 'pending'),
(30228, 0, 61, 2011195794, 1, 50, '2024-09-13 14:16:55', 'pending'),
(33301, 343, 30, 49143488, 1, 8, '2024-07-12 02:14:47', 'pending'),
(33711, 89, 1, 569188370, 1, 600, '2024-05-01 17:08:07', 'pending'),
(33949, 89, 40, 100604680, 100, 600, '2024-05-01 17:13:07', 'pending'),
(34788, 332, 1, 1708154083, 6, 600, '2024-07-09 06:43:09', 'pending'),
(43132, 89, 48, 80531716, 1, 24, '2024-05-19 07:46:34', 'pending'),
(43163, 328, 41, 942736564, 1, 16, '2024-07-09 06:22:15', 'pending'),
(48347, 89, 29, 870279301, 1, 5, '2024-05-01 17:16:22', 'pending'),
(49549, 89, 37, 1700156350, 7, 70, '2024-05-17 05:55:59', 'pending'),
(49982, 343, 44, 622474967, 1, 400, '2024-07-12 02:06:55', 'pending'),
(54304, 89, 40, 288672563, 500, 3000, '2024-05-01 17:12:13', 'pending'),
(55693, 89, 37, 1738191621, 1, 10, '2024-07-11 17:53:59', 'pending'),
(56175, 89, 40, 2030077539, 50, 0, '2024-05-01 16:35:05', 'COMPLETED'),
(56305, 89, 1, 353150699, 10, 6000, '2024-05-01 17:17:38', 'pending'),
(56319, 89, 40, 1697005780, 50, 0, '2024-05-01 17:05:10', 'pending'),
(57557, 89, 27, 1195905562, 1, 16, '2024-05-19 08:20:49', 'pending'),
(58606, 335, 46, 61027118, 1, 17, '2024-07-11 14:12:48', 'pending'),
(62354, 332, 1, 562888123, 6, 3600, '2024-07-09 06:37:52', 'pending'),
(66569, 345, 46, 1090476391, 100, 1700, '2024-07-12 02:33:17', 'pending'),
(67086, 0, 44, 1267960450, 1, 400, '2024-04-30 10:34:51', 'pending'),
(67320, 89, 1, 68699549, 1, 600, '2024-07-11 18:05:50', 'pending'),
(70623, 89, 27, 1759209151, 15, 240, '2024-07-11 17:28:04', 'pending'),
(73090, 343, 44, 1938624537, 10, 4000, '2024-07-12 02:04:23', 'pending'),
(80533, 89, 49, 1467308308, 10, 250, '2024-07-11 17:22:59', 'pending'),
(81577, 89, 1, 1664966557, 1, 600, '2024-05-01 17:19:12', 'pending'),
(86966, 89, 1, 409718772, 10, 6000, '2024-05-01 17:14:50', 'pending'),
(88139, 328, 41, 230033320, 1, 16, '2024-07-09 06:23:06', 'pending'),
(93369, 89, 1, 2037273208, 1, 600, '2024-05-01 17:18:19', 'pending'),
(94334, 89, 37, 701311092, 2, 20, '2024-07-11 17:15:11', 'pending'),
(94412, 325, 27, 363303791, 100, 1600, '2024-06-13 08:37:15', 'pending'),
(96256, 328, 41, 202471477, 1, 16, '2024-07-09 06:27:36', 'pending');

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
(23, 22, 89, 50, 10, 500, 'pending', '2030-11-22'),
(24, 25, 89, 20, 10, 200, 'pending', '2024-12-07'),
(25, 26, 345, 2000, 3, 6000, 'completed', '2026-12-12'),
(100, 51, 89, 25, 8, 200, 'pending', '2026-02-21'),
(101, 50, 89, 15, 7, 105, 'completed', '2026-02-22'),
(102, 54, 89, 18, 13, 234, 'pending', '2026-02-23'),
(103, 50, 89, 15, 10, 150, 'pending', '2026-02-23'),
(104, 53, 89, 30, 8, 240, 'completed', '2026-02-24'),
(105, 54, 89, 18, 14, 252, 'pending', '2026-02-26'),
(106, 50, 89, 15, 17, 255, 'completed', '2026-02-27'),
(107, 52, 89, 20, 25, 500, 'completed', '2026-02-28'),
(108, 52, 89, 20, 6, 120, 'completed', '2026-03-01'),
(109, 52, 89, 20, 11, 220, 'pending', '2026-03-02'),
(110, 53, 89, 30, 25, 750, 'completed', '2026-03-02'),
(111, 52, 89, 20, 9, 180, 'completed', '2026-03-02'),
(112, 54, 89, 18, 20, 360, 'completed', '2026-03-03'),
(113, 53, 89, 30, 24, 720, 'completed', '2026-03-04'),
(114, 53, 89, 30, 24, 720, 'cancelled', '2026-03-04'),
(115, 54, 89, 18, 13, 234, 'cancelled', '2026-03-04'),
(116, 51, 89, 25, 19, 475, 'completed', '2026-03-05'),
(117, 52, 89, 20, 21, 420, 'pending', '2026-03-05'),
(118, 51, 89, 25, 9, 225, 'completed', '2026-03-06'),
(119, 51, 89, 25, 22, 550, 'cancelled', '2026-03-06'),
(120, 54, 89, 18, 5, 90, 'completed', '2026-03-06'),
(121, 51, 89, 25, 6, 150, 'completed', '2026-03-07'),
(122, 54, 89, 18, 7, 126, 'completed', '2026-03-07'),
(123, 53, 89, 30, 22, 660, 'completed', '2026-03-08'),
(124, 52, 89, 20, 19, 380, 'cancelled', '2026-03-09'),
(125, 53, 89, 30, 8, 240, 'completed', '2026-03-09'),
(126, 50, 89, 15, 15, 225, 'completed', '2026-03-09'),
(127, 50, 89, 15, 25, 375, 'completed', '2026-03-10'),
(128, 51, 89, 25, 13, 325, 'pending', '2026-03-11'),
(129, 51, 89, 25, 22, 550, 'completed', '2026-03-11'),
(130, 54, 89, 18, 23, 414, 'completed', '2026-03-11'),
(131, 50, 89, 15, 52, 780, 'completed', '2026-03-12'),
(132, 50, 89, 15, 47, 705, 'completed', '2026-03-12'),
(133, 51, 89, 25, 57, 1425, 'pending', '2026-03-12'),
(134, 51, 89, 25, 53, 1325, 'completed', '2026-03-12'),
(135, 52, 89, 20, 54, 1080, 'completed', '2026-03-12'),
(136, 50, 89, 15, 12, 180, 'completed', '2026-03-13'),
(137, 50, 89, 15, 17, 255, 'completed', '2026-03-14'),
(138, 53, 89, 30, 14, 420, 'completed', '2026-03-14'),
(139, 54, 89, 18, 6, 108, 'pending', '2026-03-15'),
(140, 50, 89, 15, 6, 90, 'completed', '2026-03-15'),
(141, 54, 89, 18, 21, 378, 'completed', '2026-03-15'),
(142, 50, 89, 15, 12, 180, 'completed', '2026-03-16'),
(143, 54, 89, 18, 12, 216, 'completed', '2026-03-16'),
(144, 50, 89, 15, 24, 360, 'completed', '2026-03-16'),
(145, 53, 89, 30, 9, 270, 'pending', '2026-03-17'),
(146, 52, 89, 20, 19, 380, 'completed', '2026-03-17'),
(147, 54, 89, 18, 11, 198, 'completed', '2026-03-18'),
(148, 53, 89, 30, 22, 660, 'pending', '2026-03-19'),
(149, 50, 89, 15, 9, 135, 'completed', '2026-03-20'),
(150, 50, 89, 15, 22, 330, 'completed', '2026-03-20'),
(151, 52, 89, 20, 24, 480, 'completed', '2026-03-20'),
(152, 52, 89, 20, 6, 120, 'completed', '2026-03-21'),
(153, 53, 89, 30, 13, 390, 'completed', '2026-03-21'),
(154, 53, 89, 30, 22, 660, 'pending', '2026-03-23'),
(155, 54, 89, 18, 5, 90, 'completed', '2026-03-23'),
(156, 51, 89, 25, 22, 550, 'completed', '2026-03-23'),
(157, 50, 89, 15, 16, 240, 'completed', '2026-03-24'),
(158, 51, 89, 25, 8, 200, 'completed', '2026-03-24'),
(159, 53, 89, 30, 5, 150, 'completed', '2026-03-25'),
(160, 50, 89, 15, 20, 300, 'completed', '2026-03-26'),
(161, 53, 89, 30, 16, 480, 'completed', '2026-03-26'),
(162, 52, 89, 20, 13, 260, 'cancelled', '2026-03-27'),
(163, 52, 89, 20, 16, 320, 'pending', '2026-03-27'),
(164, 52, 89, 20, 6, 120, 'completed', '2026-03-28'),
(165, 53, 89, 30, 16, 480, 'pending', '2026-03-28'),
(166, 52, 89, 20, 18, 360, 'pending', '2026-03-28'),
(167, 50, 89, 15, 18, 270, 'completed', '2026-03-29'),
(168, 54, 89, 18, 11, 198, 'completed', '2026-03-29'),
(169, 53, 89, 30, 15, 450, 'completed', '2026-03-30'),
(170, 52, 89, 20, 22, 440, 'completed', '2026-03-30'),
(171, 53, 89, 30, 17, 510, 'pending', '2026-03-30'),
(172, 51, 89, 25, 18, 450, 'pending', '2026-03-31'),
(173, 54, 89, 18, 25, 450, 'completed', '2026-03-31'),
(174, 50, 89, 15, 14, 210, 'completed', '2026-04-01'),
(175, 54, 89, 18, 15, 270, 'completed', '2026-04-01'),
(176, 51, 89, 25, 14, 350, 'completed', '2026-04-01'),
(177, 53, 89, 30, 24, 720, 'pending', '2026-04-02'),
(178, 51, 89, 25, 9, 225, 'pending', '2026-04-03'),
(179, 50, 89, 15, 8, 120, 'pending', '2026-04-03'),
(180, 54, 89, 18, 12, 216, 'cancelled', '2026-04-04'),
(181, 52, 89, 20, 19, 380, 'pending', '2026-04-05'),
(182, 54, 89, 18, 18, 324, 'pending', '2026-04-05'),
(183, 54, 89, 18, 19, 342, 'cancelled', '2026-04-05'),
(184, 51, 89, 25, 13, 325, 'completed', '2026-04-06'),
(185, 52, 89, 20, 12, 240, 'completed', '2026-04-06'),
(186, 51, 89, 25, 7, 175, 'completed', '2026-04-07'),
(187, 52, 89, 20, 22, 440, 'completed', '2026-04-07'),
(188, 50, 89, 15, 11, 165, 'pending', '2026-04-07'),
(189, 53, 89, 30, 22, 660, 'pending', '2026-04-08'),
(190, 54, 89, 18, 24, 432, 'cancelled', '2026-04-08'),
(191, 50, 89, 15, 17, 255, 'completed', '2026-04-09'),
(192, 53, 89, 30, 10, 300, 'pending', '2026-04-09'),
(193, 53, 89, 30, 10, 300, 'completed', '2026-04-10'),
(194, 54, 89, 18, 41, 738, 'completed', '2026-04-11'),
(195, 51, 89, 25, 60, 1500, 'completed', '2026-04-11'),
(196, 50, 89, 15, 40, 600, 'completed', '2026-04-11'),
(197, 51, 89, 25, 40, 1000, 'completed', '2026-04-11'),
(198, 51, 89, 25, 44, 1100, 'pending', '2026-04-11'),
(199, 52, 89, 20, 8, 160, 'completed', '2026-04-12'),
(200, 52, 89, 20, 24, 480, 'pending', '2026-04-13'),
(201, 52, 89, 20, 7, 140, 'completed', '2026-04-14'),
(202, 52, 89, 20, 5, 100, 'pending', '2026-04-14'),
(203, 53, 89, 30, 9, 270, 'completed', '2026-04-15'),
(204, 54, 89, 18, 25, 450, 'completed', '2026-04-15'),
(205, 54, 89, 18, 20, 360, 'completed', '2026-04-15'),
(206, 53, 89, 30, 23, 690, 'pending', '2026-04-16'),
(207, 51, 89, 25, 16, 400, 'pending', '2026-04-17'),
(208, 52, 89, 20, 13, 260, 'cancelled', '2026-04-17'),
(209, 54, 89, 18, 12, 216, 'pending', '2026-04-18'),
(210, 53, 89, 30, 19, 570, 'pending', '2026-04-18'),
(211, 54, 89, 18, 16, 288, 'completed', '2026-04-19'),
(212, 54, 89, 18, 16, 288, 'completed', '2026-04-19'),
(213, 54, 89, 18, 15, 270, 'completed', '2026-04-19'),
(214, 51, 89, 25, 15, 375, 'completed', '2026-04-20'),
(215, 54, 89, 18, 10, 180, 'completed', '2026-04-20'),
(216, 53, 89, 30, 13, 390, 'pending', '2026-04-20'),
(217, 52, 89, 20, 5, 100, 'pending', '2026-04-22'),
(218, 51, 89, 25, 25, 625, 'cancelled', '2026-04-23'),
(219, 53, 89, 30, 8, 240, 'cancelled', '2026-04-23'),
(220, 54, 89, 18, 14, 252, 'completed', '2026-04-23'),
(221, 50, 89, 15, 17, 255, 'completed', '2026-04-24'),
(222, 54, 89, 18, 18, 324, 'pending', '2026-04-25'),
(223, 54, 89, 18, 24, 432, 'completed', '2026-04-26'),
(224, 50, 89, 15, 11, 165, 'pending', '2026-04-26'),
(225, 50, 89, 15, 18, 270, 'completed', '2026-04-27'),
(226, 53, 89, 30, 7, 210, 'pending', '2026-04-28'),
(227, 52, 89, 20, 25, 500, 'completed', '2026-04-28'),
(228, 51, 89, 25, 18, 450, 'completed', '2026-04-28'),
(229, 54, 89, 18, 23, 414, 'cancelled', '2026-04-29'),
(230, 53, 89, 30, 8, 240, 'completed', '2026-04-29'),
(231, 54, 89, 18, 6, 108, 'cancelled', '2026-04-30'),
(232, 52, 89, 20, 23, 460, 'completed', '2026-05-01'),
(233, 51, 89, 25, 20, 500, 'completed', '2026-05-01'),
(234, 53, 89, 30, 13, 390, 'completed', '2026-05-01'),
(235, 52, 89, 20, 15, 300, 'pending', '2026-05-02'),
(236, 51, 89, 25, 15, 375, 'completed', '2026-05-02'),
(237, 52, 89, 20, 13, 260, 'completed', '2026-05-03'),
(238, 52, 89, 20, 24, 480, 'pending', '2026-05-04'),
(239, 53, 89, 30, 6, 180, 'completed', '2026-05-04'),
(240, 54, 89, 18, 9, 162, 'cancelled', '2026-05-04'),
(241, 50, 89, 15, 22, 330, 'completed', '2026-05-05'),
(242, 51, 89, 25, 8, 200, 'completed', '2026-05-05'),
(243, 50, 89, 15, 25, 375, 'pending', '2026-05-05'),
(244, 53, 89, 30, 22, 660, 'completed', '2026-05-06'),
(245, 52, 89, 20, 5, 100, 'completed', '2026-05-07'),
(246, 52, 89, 20, 23, 460, 'completed', '2026-05-07'),
(247, 53, 89, 30, 9, 270, 'completed', '2026-05-07'),
(248, 52, 89, 20, 11, 220, 'cancelled', '2026-05-08'),
(249, 51, 89, 25, 23, 575, 'completed', '2026-05-08'),
(250, 53, 89, 30, 17, 510, 'cancelled', '2026-05-09'),
(251, 51, 89, 25, 20, 500, 'cancelled', '2026-05-09'),
(252, 51, 89, 25, 21, 525, 'cancelled', '2026-05-09'),
(253, 52, 89, 20, 59, 1180, 'pending', '2026-05-10'),
(254, 50, 89, 15, 50, 750, 'pending', '2026-05-10'),
(255, 52, 89, 20, 60, 1200, 'pending', '2026-05-10'),
(256, 54, 89, 18, 41, 738, 'completed', '2026-05-10'),
(257, 51, 89, 25, 60, 1500, 'completed', '2026-05-10'),
(258, 51, 89, 25, 42, 1050, 'pending', '2026-05-10'),
(259, 50, 89, 15, 60, 900, 'completed', '2026-05-10'),
(260, 52, 89, 20, 6, 120, 'completed', '2026-05-11'),
(261, 51, 89, 25, 10, 250, 'completed', '2026-05-12'),
(262, 54, 89, 18, 17, 306, 'pending', '2026-05-12'),
(263, 51, 89, 25, 20, 500, 'cancelled', '2026-05-12'),
(264, 52, 89, 20, 5, 100, 'cancelled', '2026-05-13'),
(265, 53, 89, 30, 14, 420, 'pending', '2026-05-13'),
(266, 52, 89, 20, 25, 500, 'cancelled', '2026-05-14'),
(267, 52, 89, 20, 19, 380, 'pending', '2026-05-14'),
(268, 51, 89, 25, 17, 425, 'cancelled', '2026-05-14'),
(269, 52, 89, 20, 14, 280, 'completed', '2026-05-15'),
(270, 53, 89, 30, 13, 390, 'completed', '2026-05-15'),
(271, 50, 89, 15, 24, 360, 'pending', '2026-05-15'),
(272, 51, 89, 25, 24, 600, 'completed', '2026-05-16'),
(273, 51, 89, 25, 7, 175, 'cancelled', '2026-05-17'),
(274, 52, 89, 20, 18, 360, 'completed', '2026-05-17'),
(275, 51, 89, 25, 22, 550, 'cancelled', '2026-05-17'),
(276, 52, 89, 20, 8, 160, 'completed', '2026-05-18'),
(277, 50, 89, 15, 9, 135, 'pending', '2026-05-18'),
(278, 51, 89, 25, 17, 425, 'cancelled', '2026-05-18'),
(279, 50, 89, 15, 19, 285, 'completed', '2026-05-19'),
(280, 52, 89, 20, 23, 460, 'completed', '2026-05-19'),
(281, 52, 89, 20, 8, 160, 'pending', '2026-05-19'),
(282, 54, 89, 18, 12, 216, 'pending', '2026-05-20'),
(283, 53, 89, 30, 14, 420, 'pending', '2026-05-20'),
(284, 53, 89, 30, 8, 240, 'completed', '2026-05-21'),
(285, 54, 89, 18, 9, 162, 'completed', '2026-05-21');

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
(9, 22, 89, 60, 10, 600, 'completed', '2025-12-07'),
(10, 22, 89, 60, 10, 600, 'completed', '2024-10-01'),
(11, 22, 89, 60, 8, 480, 'completed', '2024-10-03'),
(12, 22, 89, 60, 12, 720, 'completed', '2024-10-05'),
(13, 24, 89, 1300, 2, 2600, 'completed', '2024-10-07'),
(14, 25, 89, 25, 20, 500, 'completed', '2024-10-10'),
(15, 22, 89, 60, 15, 900, 'completed', '2024-10-12'),
(16, 24, 89, 1300, 1, 1300, 'completed', '2024-10-15'),
(17, 22, 89, 60, 12, 720, 'completed', '2024-11-02'),
(18, 24, 89, 1300, 3, 3900, 'completed', '2024-11-05'),
(19, 25, 89, 25, 25, 625, 'completed', '2024-11-08'),
(20, 22, 89, 60, 18, 1080, 'completed', '2024-11-11'),
(21, 24, 89, 1300, 2, 2600, 'completed', '2024-11-15'),
(22, 25, 89, 25, 30, 750, 'completed', '2024-11-18'),
(23, 22, 89, 60, 25, 1500, 'completed', '2024-12-01'),
(24, 24, 89, 1300, 5, 6500, 'completed', '2024-12-05'),
(25, 25, 89, 25, 40, 1000, 'completed', '2024-12-10'),
(26, 22, 89, 60, 30, 1800, 'completed', '2024-12-15'),
(27, 24, 89, 1300, 4, 5200, 'completed', '2024-12-20'),
(28, 25, 89, 25, 50, 1250, 'completed', '2024-12-25'),
(29, 22, 89, 60, 15, 900, 'completed', '2025-01-03'),
(30, 24, 89, 1300, 2, 2600, 'completed', '2025-01-07'),
(31, 25, 89, 25, 28, 700, 'completed', '2025-01-11'),
(32, 22, 89, 60, 16, 960, 'completed', '2025-01-15'),
(33, 24, 89, 1300, 1, 1300, 'completed', '2025-01-20'),
(34, 25, 89, 25, 32, 800, 'completed', '2025-01-25'),
(35, 22, 89, 60, 35, 2100, 'completed', '2025-02-01'),
(36, 24, 89, 1300, 6, 7800, 'completed', '2025-02-05'),
(37, 25, 89, 25, 60, 1500, 'completed', '2025-02-10'),
(38, 22, 89, 60, 40, 2400, 'completed', '2025-02-15'),
(39, 24, 89, 1300, 5, 6500, 'completed', '2025-02-20'),
(40, 25, 89, 25, 55, 1375, 'completed', '2025-02-25'),
(41, 22, 89, 60, 20, 1200, 'completed', '2025-03-01'),
(42, 24, 89, 1300, 3, 3900, 'completed', '2025-03-05'),
(43, 25, 89, 25, 35, 875, 'completed', '2025-03-10'),
(44, 22, 89, 60, 22, 1320, 'completed', '2025-03-15'),
(45, 24, 89, 1300, 2, 2600, 'completed', '2025-03-20'),
(46, 25, 89, 25, 38, 950, 'completed', '2025-03-25'),
(47, 22, 89, 60, 25, 1500, 'completed', '2025-04-01'),
(100, 52, 89, 20, 42, 840, 'completed', '2026-02-21'),
(101, 54, 89, 18, 64, 1152, 'completed', '2026-02-22'),
(102, 50, 89, 15, 23, 345, 'completed', '2026-02-23'),
(103, 51, 89, 25, 15, 375, 'completed', '2026-02-23'),
(104, 53, 89, 30, 8, 240, 'completed', '2026-02-23'),
(105, 51, 89, 25, 14, 350, 'completed', '2026-02-24'),
(106, 52, 89, 20, 16, 320, 'completed', '2026-02-24'),
(107, 52, 89, 20, 9, 180, 'completed', '2026-02-26'),
(108, 53, 89, 30, 12, 360, 'completed', '2026-02-26'),
(109, 50, 89, 15, 19, 285, 'completed', '2026-02-26'),
(110, 51, 89, 25, 7, 175, 'completed', '2026-02-27'),
(111, 50, 89, 15, 17, 255, 'completed', '2026-02-27'),
(112, 52, 89, 20, 10, 200, 'completed', '2026-02-27'),
(113, 52, 89, 20, 53, 1060, 'completed', '2026-02-28'),
(114, 51, 89, 25, 10, 250, 'completed', '2026-03-01'),
(115, 53, 89, 30, 12, 360, 'completed', '2026-03-01'),
(116, 52, 89, 20, 19, 380, 'completed', '2026-03-01'),
(117, 53, 89, 30, 10, 300, 'completed', '2026-03-02'),
(118, 50, 89, 15, 20, 300, 'completed', '2026-03-02'),
(119, 52, 89, 20, 17, 340, 'completed', '2026-03-03'),
(120, 54, 89, 18, 19, 342, 'completed', '2026-03-03'),
(121, 52, 89, 20, 14, 280, 'completed', '2026-03-03'),
(122, 51, 89, 25, 24, 600, 'completed', '2026-03-04'),
(123, 50, 89, 15, 18, 270, 'completed', '2026-03-05'),
(124, 52, 89, 20, 11, 220, 'completed', '2026-03-05'),
(125, 50, 89, 15, 14, 210, 'completed', '2026-03-05'),
(126, 52, 89, 20, 50, 1000, 'completed', '2026-03-06'),
(127, 50, 89, 15, 78, 1170, 'completed', '2026-03-07'),
(128, 54, 89, 18, 63, 1134, 'completed', '2026-03-08'),
(129, 53, 89, 30, 9, 270, 'completed', '2026-03-09'),
(130, 54, 89, 18, 16, 288, 'completed', '2026-03-09'),
(131, 52, 89, 20, 18, 360, 'completed', '2026-03-09'),
(132, 54, 89, 18, 53, 954, 'completed', '2026-03-10'),
(133, 52, 89, 20, 32, 640, 'completed', '2026-03-11'),
(134, 53, 89, 30, 46, 1380, 'completed', '2026-03-12'),
(135, 50, 89, 15, 43, 645, 'completed', '2026-03-12'),
(136, 53, 89, 30, 51, 1530, 'completed', '2026-03-12'),
(137, 53, 89, 30, 53, 1590, 'completed', '2026-03-12'),
(138, 53, 89, 30, 63, 1890, 'completed', '2026-03-12'),
(139, 50, 89, 15, 61, 915, 'completed', '2026-03-12'),
(140, 54, 89, 18, 16, 288, 'completed', '2026-03-13'),
(141, 50, 89, 15, 27, 405, 'completed', '2026-03-13'),
(142, 51, 89, 25, 26, 650, 'completed', '2026-03-14'),
(143, 50, 89, 15, 38, 570, 'completed', '2026-03-14'),
(144, 53, 89, 30, 11, 330, 'completed', '2026-03-15'),
(145, 51, 89, 25, 16, 400, 'completed', '2026-03-15'),
(146, 51, 89, 25, 12, 300, 'completed', '2026-03-15'),
(147, 51, 89, 25, 36, 900, 'completed', '2026-03-16'),
(148, 54, 89, 18, 20, 360, 'completed', '2026-03-17'),
(149, 52, 89, 20, 16, 320, 'completed', '2026-03-17'),
(150, 52, 89, 20, 16, 320, 'completed', '2026-03-17'),
(151, 53, 89, 30, 21, 630, 'completed', '2026-03-18'),
(152, 50, 89, 15, 25, 375, 'completed', '2026-03-19'),
(153, 52, 89, 20, 19, 380, 'completed', '2026-03-19'),
(154, 54, 89, 18, 56, 1008, 'completed', '2026-03-20'),
(155, 52, 89, 20, 61, 1220, 'completed', '2026-03-21'),
(156, 52, 89, 20, 44, 880, 'completed', '2026-03-23'),
(157, 54, 89, 18, 15, 270, 'completed', '2026-03-24'),
(158, 53, 89, 30, 8, 240, 'completed', '2026-03-24'),
(159, 50, 89, 15, 21, 315, 'completed', '2026-03-24'),
(160, 54, 89, 18, 27, 486, 'completed', '2026-03-25'),
(161, 51, 89, 25, 19, 475, 'completed', '2026-03-25'),
(162, 51, 89, 25, 18, 450, 'completed', '2026-03-26'),
(163, 51, 89, 25, 15, 375, 'completed', '2026-03-26'),
(164, 50, 89, 15, 57, 855, 'completed', '2026-03-27'),
(165, 54, 89, 18, 23, 414, 'completed', '2026-03-28'),
(166, 50, 89, 15, 24, 360, 'completed', '2026-03-28'),
(167, 52, 89, 20, 18, 360, 'completed', '2026-03-28'),
(168, 53, 89, 30, 42, 1260, 'completed', '2026-03-29'),
(169, 52, 89, 20, 14, 280, 'completed', '2026-03-30'),
(170, 50, 89, 15, 17, 255, 'completed', '2026-03-30'),
(171, 54, 89, 18, 14, 252, 'completed', '2026-03-30'),
(172, 54, 89, 18, 16, 288, 'completed', '2026-03-31'),
(173, 53, 89, 30, 13, 390, 'completed', '2026-03-31'),
(174, 50, 89, 15, 19, 285, 'completed', '2026-03-31'),
(175, 51, 89, 25, 24, 600, 'completed', '2026-04-01'),
(176, 53, 89, 30, 15, 450, 'completed', '2026-04-01'),
(177, 50, 89, 15, 55, 825, 'completed', '2026-04-02'),
(178, 53, 89, 30, 12, 360, 'completed', '2026-04-03'),
(179, 53, 89, 30, 16, 480, 'completed', '2026-04-03'),
(180, 54, 89, 18, 67, 1206, 'completed', '2026-04-04'),
(181, 51, 89, 25, 25, 625, 'completed', '2026-04-05'),
(182, 54, 89, 18, 34, 612, 'completed', '2026-04-05'),
(183, 52, 89, 20, 26, 520, 'completed', '2026-04-06'),
(184, 52, 89, 20, 31, 620, 'completed', '2026-04-06'),
(185, 50, 89, 15, 20, 300, 'completed', '2026-04-07'),
(186, 51, 89, 25, 12, 300, 'completed', '2026-04-07'),
(187, 53, 89, 30, 9, 270, 'completed', '2026-04-07'),
(188, 50, 89, 15, 25, 375, 'completed', '2026-04-08'),
(189, 53, 89, 30, 7, 210, 'completed', '2026-04-08'),
(190, 52, 89, 20, 17, 340, 'completed', '2026-04-08'),
(191, 52, 89, 20, 57, 1140, 'completed', '2026-04-09'),
(192, 54, 89, 18, 12, 216, 'completed', '2026-04-10'),
(193, 53, 89, 30, 5, 150, 'completed', '2026-04-10'),
(194, 50, 89, 15, 21, 315, 'completed', '2026-04-10'),
(195, 52, 89, 20, 46, 920, 'completed', '2026-04-11'),
(196, 53, 89, 30, 50, 1500, 'completed', '2026-04-11'),
(197, 52, 89, 20, 64, 1280, 'completed', '2026-04-11'),
(198, 53, 89, 30, 48, 1440, 'completed', '2026-04-11'),
(199, 53, 89, 30, 48, 1440, 'completed', '2026-04-11'),
(200, 50, 89, 15, 55, 825, 'completed', '2026-04-11'),
(201, 51, 89, 25, 18, 450, 'completed', '2026-04-12'),
(202, 52, 89, 20, 19, 380, 'completed', '2026-04-12'),
(203, 51, 89, 25, 12, 300, 'completed', '2026-04-12'),
(204, 53, 89, 30, 13, 390, 'completed', '2026-04-13'),
(205, 51, 89, 25, 10, 250, 'completed', '2026-04-13'),
(206, 54, 89, 18, 17, 306, 'completed', '2026-04-13'),
(207, 52, 89, 20, 63, 1260, 'completed', '2026-04-14'),
(208, 53, 89, 30, 38, 1140, 'completed', '2026-04-15'),
(209, 51, 89, 25, 17, 425, 'completed', '2026-04-16'),
(210, 52, 89, 20, 28, 560, 'completed', '2026-04-16'),
(211, 50, 89, 15, 39, 585, 'completed', '2026-04-17'),
(212, 52, 89, 20, 25, 500, 'completed', '2026-04-17'),
(213, 50, 89, 15, 32, 480, 'completed', '2026-04-18'),
(214, 51, 89, 25, 13, 325, 'completed', '2026-04-18'),
(215, 51, 89, 25, 18, 450, 'completed', '2026-04-18'),
(216, 51, 89, 25, 25, 625, 'completed', '2026-04-19'),
(217, 51, 89, 25, 23, 575, 'completed', '2026-04-19'),
(218, 52, 89, 20, 28, 560, 'completed', '2026-04-20'),
(219, 51, 89, 25, 19, 475, 'completed', '2026-04-20'),
(220, 52, 89, 20, 16, 320, 'completed', '2026-04-22'),
(221, 51, 89, 25, 15, 375, 'completed', '2026-04-22'),
(222, 51, 89, 25, 16, 400, 'completed', '2026-04-22'),
(223, 50, 89, 15, 28, 420, 'completed', '2026-04-23'),
(224, 54, 89, 18, 26, 468, 'completed', '2026-04-23'),
(225, 51, 89, 25, 19, 475, 'completed', '2026-04-24'),
(226, 52, 89, 20, 31, 620, 'completed', '2026-04-24'),
(227, 50, 89, 15, 30, 450, 'completed', '2026-04-25'),
(228, 51, 89, 25, 19, 475, 'completed', '2026-04-25'),
(229, 50, 89, 15, 31, 465, 'completed', '2026-04-25'),
(230, 53, 89, 30, 17, 510, 'completed', '2026-04-26'),
(231, 53, 89, 30, 14, 420, 'completed', '2026-04-26'),
(232, 54, 89, 18, 25, 450, 'completed', '2026-04-26'),
(233, 50, 89, 15, 21, 315, 'completed', '2026-04-27'),
(234, 51, 89, 25, 12, 300, 'completed', '2026-04-27'),
(235, 54, 89, 18, 16, 288, 'completed', '2026-04-27'),
(236, 50, 89, 15, 38, 570, 'completed', '2026-04-28'),
(237, 52, 89, 20, 29, 580, 'completed', '2026-04-28'),
(238, 51, 89, 25, 14, 350, 'completed', '2026-04-29'),
(239, 51, 89, 25, 11, 275, 'completed', '2026-04-29'),
(240, 50, 89, 15, 21, 315, 'completed', '2026-04-29'),
(241, 53, 89, 30, 12, 360, 'completed', '2026-04-30'),
(242, 54, 89, 18, 24, 432, 'completed', '2026-04-30'),
(243, 53, 89, 30, 15, 450, 'completed', '2026-04-30'),
(244, 52, 89, 20, 14, 280, 'completed', '2026-05-01'),
(245, 50, 89, 15, 23, 345, 'completed', '2026-05-01'),
(246, 54, 89, 18, 16, 288, 'completed', '2026-05-01'),
(247, 53, 89, 30, 22, 660, 'completed', '2026-05-02'),
(248, 53, 89, 30, 26, 780, 'completed', '2026-05-02'),
(249, 53, 89, 30, 28, 840, 'completed', '2026-05-03'),
(250, 50, 89, 15, 52, 780, 'completed', '2026-05-03'),
(251, 50, 89, 15, 30, 450, 'completed', '2026-05-04'),
(252, 53, 89, 30, 15, 450, 'completed', '2026-05-04'),
(253, 50, 89, 15, 25, 375, 'completed', '2026-05-04'),
(254, 53, 89, 30, 10, 300, 'completed', '2026-05-05'),
(255, 50, 89, 15, 25, 375, 'completed', '2026-05-05'),
(256, 51, 89, 25, 16, 400, 'completed', '2026-05-05'),
(257, 52, 89, 20, 24, 480, 'completed', '2026-05-06'),
(258, 52, 89, 20, 22, 440, 'completed', '2026-05-06'),
(259, 53, 89, 30, 16, 480, 'completed', '2026-05-06'),
(260, 54, 89, 18, 17, 306, 'completed', '2026-05-07'),
(261, 50, 89, 15, 23, 345, 'completed', '2026-05-07'),
(262, 53, 89, 30, 12, 360, 'completed', '2026-05-07'),
(263, 52, 89, 20, 35, 700, 'completed', '2026-05-08'),
(264, 54, 89, 18, 36, 648, 'completed', '2026-05-08'),
(265, 52, 89, 20, 75, 1500, 'completed', '2026-05-09'),
(266, 50, 89, 15, 54, 810, 'completed', '2026-05-10'),
(267, 50, 89, 15, 56, 840, 'completed', '2026-05-10'),
(268, 53, 89, 30, 40, 1200, 'completed', '2026-05-10'),
(269, 51, 89, 25, 53, 1325, 'completed', '2026-05-10'),
(270, 51, 89, 25, 42, 1050, 'completed', '2026-05-10'),
(271, 53, 89, 30, 65, 1950, 'completed', '2026-05-10'),
(272, 52, 89, 20, 58, 1160, 'completed', '2026-05-11'),
(273, 51, 89, 25, 23, 575, 'completed', '2026-05-12'),
(274, 54, 89, 18, 35, 630, 'completed', '2026-05-12'),
(275, 53, 89, 30, 35, 1050, 'completed', '2026-05-13'),
(276, 53, 89, 30, 37, 1110, 'completed', '2026-05-14'),
(277, 53, 89, 30, 36, 1080, 'completed', '2026-05-15'),
(278, 54, 89, 18, 79, 1422, 'completed', '2026-05-16'),
(279, 50, 89, 15, 25, 375, 'completed', '2026-05-17'),
(280, 52, 89, 20, 25, 500, 'completed', '2026-05-17'),
(281, 50, 89, 15, 30, 450, 'completed', '2026-05-17'),
(282, 54, 89, 18, 22, 396, 'completed', '2026-05-18'),
(283, 51, 89, 25, 16, 400, 'completed', '2026-05-18'),
(284, 53, 89, 30, 13, 390, 'completed', '2026-05-18'),
(285, 50, 89, 15, 47, 705, 'completed', '2026-05-19'),
(286, 50, 89, 15, 45, 675, 'completed', '2026-05-19'),
(287, 54, 89, 18, 77, 1386, 'completed', '2026-05-20'),
(288, 50, 89, 15, 69, 1035, 'completed', '2026-05-21'),
(289, 25, 89, 25, 25, 625, 'pending', '2026-05-22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `product_id` (`medicine_id`),
  ADD KEY `product_id_2` (`medicine_id`),
  ADD KEY `product_id_3` (`medicine_id`),
  ADD KEY `product_id_4` (`medicine_id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `order_address`
--
ALTER TABLE `order_address`
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_completed`
--
ALTER TABLE `order_completed`
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_pending`
--
ALTER TABLE `order_pending`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_id_2` (`order_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `tbl_medicine`
--
ALTER TABLE `tbl_medicine`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `tbl_pharmacy`
--
ALTER TABLE `tbl_pharmacy`
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
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`);

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
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `medicine_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=349;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_medicine`
--
ALTER TABLE `tbl_medicine`
  MODIFY `medicine_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `user_category_tbl`
--
ALTER TABLE `user_category_tbl`
  MODIFY `c_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_medicine_tbl`
--
ALTER TABLE `user_medicine_tbl`
  MODIFY `m_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96257;

--
-- AUTO_INCREMENT for table `user_order_tbl`
--
ALTER TABLE `user_order_tbl`
  MODIFY `o_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `user_sales_tbl`
--
ALTER TABLE `user_sales_tbl`
  MODIFY `s_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`medicine_id`) REFERENCES `tbl_medicine` (`medicine_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`pharmacy_id`) REFERENCES `tbl_pharmacy` (`pharmacy_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_address`
--
ALTER TABLE `order_address`
  ADD CONSTRAINT `order_address_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `user_orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_completed`
--
ALTER TABLE `order_completed`
  ADD CONSTRAINT `order_completed_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `user_orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_pending`
--
ALTER TABLE `order_pending`
  ADD CONSTRAINT `order_pending_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `user_orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
