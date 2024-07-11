-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2024 at 05:49 PM
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
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `pharmacy_id` int(11) NOT NULL,
  `medicine_id` int(11) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`pharmacy_id`, `medicine_id`, `quantity`) VALUES
(89, 37, '2'),
(89, 27, '1'),
(89, 48, '2'),
(89, 29, '5'),
(89, 1, '11'),
(89, 41, '3'),
(89, 42, '3'),
(89, 38, '2'),
(89, 46, '1'),
(89, 44, '1'),
(89, 30, '1'),
(89, 59, '1'),
(325, 49, '1'),
(325, 59, '1'),
(328, 41, '1'),
(328, 40, '1'),
(328, 29, '1'),
(332, 28, '1'),
(89, 40, '1');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `medicine_id` int(11) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `expiration_date` date NOT NULL,
  `dosage` varchar(20) NOT NULL,
  `image` varchar(100) NOT NULL
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
(10, 'Paracetamol', 'ABC Pharmaceuticals', 600, 6, '2023-12-31', 'tablet', '../uploaded_img/../uploaded_img/65eafee5077664.30444530.paracetamol.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `order_address`
--

CREATE TABLE `order_address` (
  `order_id` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `postal` int(11) NOT NULL
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
(14050, 'ktm', 'bagmati', 'samakhusi', 75454);

-- --------------------------------------------------------

--
-- Table structure for table `order_completed`
--

CREATE TABLE `order_completed` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `total_products` int(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `order_status` varchar(255) NOT NULL
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
(14050, 332, 1, 1206274080, 6, 600, 'COMPLETED');

-- --------------------------------------------------------

--
-- Table structure for table `order_pending`
--

CREATE TABLE `order_pending` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `total_products` int(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_pending`
--

INSERT INTO `order_pending` (`order_id`, `user_id`, `medicine_id`, `invoice_number`, `total_products`, `amount`, `order_status`) VALUES
(16408, 89, 30, 720704263, 1, 8, 'pending'),
(17801, 325, 49, 1161932613, 1, 25, 'pending'),
(19743, 89, 40, 1872426216, 20, 120, 'pending'),
(25852, 0, 45, 639759943, 1, 23, 'pending'),
(26388, 89, 44, 875518175, 1, 400, 'pending'),
(33711, 89, 1, 569188370, 1, 600, 'pending'),
(33949, 89, 40, 100604680, 100, 600, 'pending'),
(34788, 332, 1, 1708154083, 6, 600, 'pending'),
(43132, 89, 48, 80531716, 1, 24, 'pending'),
(43163, 328, 41, 942736564, 1, 16, 'pending'),
(48347, 89, 29, 870279301, 1, 5, 'pending'),
(49549, 89, 37, 1700156350, 7, 70, 'pending'),
(54304, 89, 40, 288672563, 500, 3000, 'pending'),
(56305, 89, 1, 353150699, 10, 6000, 'pending'),
(56319, 89, 40, 1697005780, 50, 0, 'pending'),
(57557, 89, 27, 1195905562, 1, 16, 'pending'),
(62354, 332, 1, 562888123, 6, 3600, 'pending'),
(67086, 0, 44, 1267960450, 1, 400, 'pending'),
(81577, 89, 1, 1664966557, 1, 600, 'pending'),
(86966, 89, 1, 409718772, 10, 6000, 'pending'),
(88139, 328, 41, 230033320, 1, 16, 'pending'),
(93369, 89, 1, 2037273208, 1, 600, 'pending'),
(94412, 325, 27, 363303791, 100, 1600, 'pending'),
(96256, 328, 41, 202471477, 1, 16, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`user_id`, `name`, `email`, `password`, `role`) VALUES
(18, 'Ribesh Majarjan', 'ribesh@admin.gmail.com', '$2y$10$CwkK7YZ1ZjOtlU7GMaa4R.KlM8tZzOR0AsNls91/uLCrCTzZlZ8.e', 'admin'),
(89, 'Pharmacy', 'pharmacy@gmail.com', '$2y$10$uFb7a4ektQAGS4GbIfn0LuETxc03PTCDoJMJmyFnUHbxlBRS1BhSm', 'user'),
(90, 'ribesh', 'ribe@gmail.com', 'final', 'user'),
(123, 'Rijan Bajracharya', 'rijan@admin.gmail.com', '$2y$10$5/iQmwkH4ETPbzQE.0Wb8OqAL.acnMFUuJ/kolA243PTe5t8il01G', 'admin'),
(125, 'Remon', 'remon@admin.gmail.com', 'remon123', 'admin'),
(126, 'Sujal', 'sujal@admin.gmail.com', 'sujal', 'admin'),
(129, 'test', 'test@gmail.com', 'test', 'user'),
(130, 'test', 'test@admin.gmail.com', 'tes', 'admin'),
(302, 'alerttest', 'alerttest@admin.gmail.com', 'alerttest', 'admin'),
(303, 'asda', 'asd@admin.gmail.com', 'asd', 'admin'),
(319, 'asdad', 'asdad@admin.gmail.com', 'asdad', 'user'),
(325, '123Assura', 'testsignup@gmail.com', '$2y$10$JGLxe2vqP5E1YjVs9q7xFe0uD6Z6QWqigJxvqDW4tFQUcBQJedR/e', 'user'),
(326, 'paracetamol', 'paracetamol@admin.gmail.com', 'paracetamol', 'user'),
(327, 'hasd', 'hasded@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'user'),
(328, 'by', 'by@gmail.com', '$2y$10$6IX6JCxHAFQpSSK.1AFSr.xY22Qic1YjxDOKsoy0ONqtyoLqnNwaq', 'user'),
(329, '56789', '456789@gmail.com', '$2y$10$.tYTK7FYCl3Npw8jl9WDT.QX4NTZHybpm0tdNM3YIkVfJLQiI8YWO', 'user'),
(330, 'admintest', 'admintest789@gmail.com', '$2y$10$2BkBKJVW7Zz8sX61ly.SKuqVNlzPKR/LJ7Ltd9MhHaBLRaASrShM.', 'user'),
(331, 'asura', 'asura@gmail.com', '$2y$10$K2BvB2qzboNl6ELLwcK4x.HW4Gwac/tTP4Y24amtr/uwEG9pw3aFm', 'user'),
(332, 'rujal', 'rujal123@gmail.com', '$2y$10$Jbp9WSQCIMW304TrTpAgB.HwWPgZnN/ejmJT5NvYiFTNq2pBVrBHi', 'user'),
(333, 'pantest', 'pantest@gmail.com', '$2y$10$g5mGb.U8fhw3bkB/Un4m9u/igIayOdL/YxZ6dTSlLmX.QLP7IWcs2', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `small_description` text DEFAULT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `sub_description` text DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `small_description`, `sub_title`, `sub_description`, `phone`, `email`) VALUES
(1, 'WELLNESS STARTS HERE!', 'Welcome to our online pharmacy platform, where convenience meets care. Our website provides a secure and user-friendly environment for individuals to access a range of pharmaceutical services tailored to their needs.', 'WELLNESS STARTS HERE!', 'Experience the ease and efficiency of managing your medications online with our pharmacy platform.', '9840455685', 'medvault@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `name`, `email`, `gender`, `phone`, `dob`, `address`) VALUES
(18, 'Ribesh Majarjan', 'ribesh@admin.gmail.com', 'male', '9802564589', '2002-12-04', 'samakhusi'),
(18, 'Ribesh Majarjan', 'ribesh@admin.gmail.com', 'male', '9802564589', '2002-12-04', 'samakhusi'),
(123, 'Rijan Bajracharya', 'rijan@admin.gmail.com', 'male', '9845621475', '2002-08-09', 'lagan'),
(125, 'Remon Buddhacharya', 'remon@admin.gmail.com', 'male', '8945621423', '2002-05-02', 'swyombhu'),
(126, 'Sujal Maharjana', 'sujal@admin.gmail.com', 'male', '9845123654', '2003-05-14', 'sorakhutte'),
(130, 'test', 'test@admin.gmail.com', 'male', 'test', '2024-05-23', 'test'),
(302, 'alerttest', 'alerttest@admin.gmail.com', 'male', '9840545628', '2002-12-22', 'aalerttest'),
(303, 'asda', 'asd@admin.gmail.com', 'male', '984054628', '2002-12-22', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_medicine`
--

CREATE TABLE `tbl_medicine` (
  `medicine_id` int(11) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `medicine_description` varchar(1000) DEFAULT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `expiration_date` date NOT NULL,
  `dosage` varchar(50) NOT NULL,
  `images` varchar(255) DEFAULT NULL
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
(62, '', NULL, '', 0, 0, '1970-01-01', 'Not Selected', '../uploaded_img/664997fb28dec1.39001385.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pharmacy`
--

CREATE TABLE `tbl_pharmacy` (
  `pharmacy_id` int(11) NOT NULL,
  `pan` int(11) NOT NULL,
  `pharmacy_name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pharmacy`
--

INSERT INTO `tbl_pharmacy` (`pharmacy_id`, `pan`, `pharmacy_name`, `email`, `phone`, `address`) VALUES
(89, 123456, 'Pharmacy', 'pharmacy@gmail.com', '1234567890', 'samakhusi'),
(129, 424242, 'test', 'test@gmail.com', '9840545629', 'thamel1'),
(319, 9845, 'asdad', 'asdad@admin.gmail.com', '9840545628', 'asdad'),
(325, 98745621, '123Assura', 'testsignup@gmail.com', '9841564152', 'swoyambhu'),
(326, 0, 'paracetamol', 'paracetamol@admin.gmail.com', '', ''),
(327, 0, 'hasd', 'hasded@gmail.com', '', ''),
(328, 98415, 'by', 'by@gmail.com', '9841562145', 'thamel'),
(329, 0, '56789', '456789@gmail.com', '', ''),
(330, 0, 'admintest', 'admintest789@gmail.com', '', ''),
(331, 0, 'asura', 'asura@gmail.com', '', ''),
(332, 0, 'rujal', 'rujal123@gmail.com', '', ''),
(333, 564578, 'pantest', 'pantest@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_category_tbl`
--

CREATE TABLE `user_category_tbl` (
  `c_id` int(11) NOT NULL,
  `pharmacy_id` int(11) NOT NULL,
  `category_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_category_tbl`
--

INSERT INTO `user_category_tbl` (`c_id`, `pharmacy_id`, `category_name`) VALUES
(8, 90, 'ribeshtest'),
(12, 89, 'testfinalfinal'),
(13, 89, 'test2'),
(14, 18, 'test'),
(15, 18, 'test2'),
(17, 89, 'test'),
(19, 325, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `user_medicine_tbl`
--

CREATE TABLE `user_medicine_tbl` (
  `m_id` int(11) NOT NULL,
  `pharmacy_id` int(11) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `medicine_desc` varchar(1000) NOT NULL,
  `c_id` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `buy_price` int(11) NOT NULL,
  `sell_price` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `exp_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_medicine_tbl`
--

INSERT INTO `user_medicine_tbl` (`m_id`, `pharmacy_id`, `medicine_name`, `image`, `medicine_desc`, `c_id`, `in_stock`, `buy_price`, `sell_price`, `added_date`, `exp_date`) VALUES
(6, 89, 'paracetamol', '../image/meds_img/660177dee432d2.24768234.', 'ldianall', 13, 50, 60, 120, '2024-05-17 10:22:19', '2024-11-01'),
(8, 18, 'Test', '../image/meds_img/6632294cced396.44170362.', 'test', 8, 50, 20, 30, '2024-05-17 06:30:04', '2024-05-25'),
(9, 89, 'Test', '../image/meds_img/663279e226aee0.87584026.', 'test', 13, 50, 20, 30, '2024-05-17 07:11:43', '2024-05-25'),
(11, 89, 'hello', '../image/meds_img/', 'world', 8, 60, 50, 30, '2024-05-17 07:11:49', '2024-05-25'),
(12, 89, 'final', '', 'daindakdnakn', 8, 50, 20, 60, '2024-05-17 07:03:36', '2024-08-22'),
(13, 89, 'final', '', 'ltekn test', 14, 60, 60, 50, '2024-05-17 06:48:43', '2024-05-31'),
(15, 89, 'test', '', 'test', 8, 50, 50, 50, '2024-05-19 08:22:40', '2020-12-22'),
(17, 325, 'test', '', 'test', 12, 120, 120, 200, '2024-06-13 15:11:17', '2024-06-22');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `total_products` int(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_status` varchar(255) NOT NULL
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
(16408, 89, 30, 720704263, 1, 8, '2024-05-17 05:56:12', 'pending'),
(17801, 325, 49, 1161932613, 1, 25, '2024-06-13 08:37:29', 'pending'),
(19743, 89, 40, 1872426216, 20, 120, '2024-05-01 17:15:56', 'pending'),
(25852, 0, 45, 639759943, 1, 23, '2024-04-29 06:40:20', 'pending'),
(26388, 89, 44, 875518175, 1, 400, '2024-05-19 06:46:05', 'pending'),
(33711, 89, 1, 569188370, 1, 600, '2024-05-01 17:08:07', 'pending'),
(33949, 89, 40, 100604680, 100, 600, '2024-05-01 17:13:07', 'pending'),
(34788, 332, 1, 1708154083, 6, 600, '2024-07-09 06:43:09', 'pending'),
(43132, 89, 48, 80531716, 1, 24, '2024-05-19 07:46:34', 'pending'),
(43163, 328, 41, 942736564, 1, 16, '2024-07-09 06:22:15', 'pending'),
(48347, 89, 29, 870279301, 1, 5, '2024-05-01 17:16:22', 'pending'),
(49549, 89, 37, 1700156350, 7, 70, '2024-05-17 05:55:59', 'pending'),
(54304, 89, 40, 288672563, 500, 3000, '2024-05-01 17:12:13', 'pending'),
(56175, 89, 40, 2030077539, 50, 0, '2024-05-01 16:35:05', 'COMPLETED'),
(56305, 89, 1, 353150699, 10, 6000, '2024-05-01 17:17:38', 'pending'),
(56319, 89, 40, 1697005780, 50, 0, '2024-05-01 17:05:10', 'pending'),
(57557, 89, 27, 1195905562, 1, 16, '2024-05-19 08:20:49', 'pending'),
(62354, 332, 1, 562888123, 6, 3600, '2024-07-09 06:37:52', 'pending'),
(67086, 0, 44, 1267960450, 1, 400, '2024-04-30 10:34:51', 'pending'),
(81577, 89, 1, 1664966557, 1, 600, '2024-05-01 17:19:12', 'pending'),
(86966, 89, 1, 409718772, 10, 6000, '2024-05-01 17:14:50', 'pending'),
(88139, 328, 41, 230033320, 1, 16, '2024-07-09 06:23:06', 'pending'),
(93369, 89, 1, 2037273208, 1, 600, '2024-05-01 17:18:19', 'pending'),
(94412, 325, 27, 363303791, 100, 1600, '2024-06-13 08:37:15', 'pending'),
(96256, 328, 41, 202471477, 1, 16, '2024-07-09 06:27:36', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `user_order_tbl`
--

CREATE TABLE `user_order_tbl` (
  `o_id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL,
  `pharmacy_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_order_tbl`
--

INSERT INTO `user_order_tbl` (`o_id`, `m_id`, `pharmacy_id`, `price`, `quantity`, `total_amount`, `status`, `order_date`) VALUES
(5, 6, 90, 500, 2, 1000, 'pending', '2024-03-06'),
(6, 6, 89, 30, 5, 30, 'completed', '2024-03-16'),
(8, 6, 89, 30, 1, 30, 'pending', '2024-03-04'),
(11, 6, 89, 30, 1, 30, 'pending', '2024-03-02'),
(17, 6, 89, 60, 100, 60, 'pending', '2024-05-25'),
(18, 6, 89, 60, 10, 60, 'pending', '2024-05-25'),
(19, 6, 89, 60, 100, 6000, 'completed', '2024-05-25'),
(21, 6, 89, 60, 1, 60, 'pending', '2002-12-12'),
(22, 12, 89, 20, 10, 200, 'pending', '2024-05-25');

-- --------------------------------------------------------

--
-- Table structure for table `user_sales_tbl`
--

CREATE TABLE `user_sales_tbl` (
  `s_id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL,
  `pharmacy_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `sales_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sales_tbl`
--

INSERT INTO `user_sales_tbl` (`s_id`, `m_id`, `pharmacy_id`, `price`, `quantity`, `total_amount`, `status`, `sales_date`) VALUES
(3, 6, 89, 60, 1, 60, 'pending', '2024-03-30'),
(5, 6, 89, 60, 1, 60, 'pending', '2024-05-25'),
(7, 12, 89, 60, 1, 60, 'pending', '2024-05-25');

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
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_medicine`
--
ALTER TABLE `tbl_medicine`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `user_category_tbl`
--
ALTER TABLE `user_category_tbl`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_medicine_tbl`
--
ALTER TABLE `user_medicine_tbl`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96257;

--
-- AUTO_INCREMENT for table `user_order_tbl`
--
ALTER TABLE `user_order_tbl`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_sales_tbl`
--
ALTER TABLE `user_sales_tbl`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`medicine_id`) REFERENCES `tbl_medicine` (`medicine_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
