-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2025 at 02:11 PM
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
-- Database: `skinsync`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `walkin_name` varchar(255) DEFAULT NULL,
  `walkin_phone` varchar(255) DEFAULT NULL,
  `walkin_email` varchar(255) DEFAULT NULL,
  `is_walkin` tinyint(1) NOT NULL DEFAULT 0,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time_slot` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `payment_data` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `walkin_name`, `walkin_phone`, `walkin_email`, `is_walkin`, `service_id`, `package_id`, `branch_id`, `date`, `time_slot`, `status`, `payment_method`, `payment_status`, `payment_data`, `created_at`, `updated_at`) VALUES
(41, NULL, NULL, NULL, NULL, 1, 1, NULL, 1, '2025-09-03', '10:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-02 05:15:42', '2025-09-02 05:30:51'),
(42, NULL, 'Leo', NULL, NULL, 1, 15, NULL, 1, '2025-09-03', '09:00-10:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-02 05:20:34', '2025-09-02 05:30:54'),
(44, NULL, 'buset', NULL, NULL, 1, 9, NULL, 1, '2025-09-03', '10:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-02 05:31:15', '2025-09-02 06:38:29'),
(45, NULL, 'cleibnt name', NULL, NULL, 1, 2, NULL, 1, '2025-09-10', '10:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-02 06:22:23', '2025-09-02 06:38:32'),
(46, NULL, 'guset', NULL, NULL, 1, 1, NULL, 1, '2025-09-03', '10:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-02 06:44:28', '2025-09-03 05:32:01'),
(52, NULL, 'asdafasd', NULL, NULL, 1, 6, NULL, 1, '2025-09-03', '11:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-02 07:21:58', '2025-09-03 05:32:03'),
(53, NULL, 'asfagfasd', NULL, NULL, 1, 10, NULL, 1, '2025-09-02', '19:00-20:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-02 07:22:34', '2025-09-03 05:31:59'),
(54, NULL, 'faghtrgsr', NULL, NULL, 1, 2, NULL, 1, '2025-09-03', '12:00-13:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-02 07:44:37', '2025-09-03 05:32:05'),
(56, NULL, 'afawsdcfaw', NULL, NULL, 1, 2, NULL, 1, '2025-09-10', '08:00-09:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-02 14:20:15', '2025-09-03 05:32:07'),
(62, NULL, 'asdasd', NULL, NULL, 1, 1, NULL, 1, '2025-09-04', '10:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-03 04:15:39', '2025-09-03 05:32:15'),
(66, NULL, 'asfdaSFa', NULL, NULL, 1, 1, NULL, 1, '2025-09-04', '13:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-03 04:58:16', '2025-09-03 05:32:21'),
(75, NULL, 'asfasdasd', NULL, NULL, 1, 1, NULL, 1, '2025-09-04', '12:00-13:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-03 05:40:56', '2025-09-03 06:29:58'),
(78, NULL, 'reffgsdfas', NULL, NULL, 1, 1, NULL, 1, '2025-09-04', '14:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-03 06:14:28', '2025-09-03 06:29:59'),
(79, NULL, 'adasdavcazxc', NULL, NULL, 1, 1, NULL, 1, '2025-09-05', '12:00-13:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-03 06:20:28', '2025-09-03 06:24:40'),
(80, NULL, 'fghjfghdfgh', NULL, NULL, 1, 1, NULL, 1, '2025-09-05', '12:00-13:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-03 06:28:59', '2025-09-03 06:30:01'),
(81, NULL, 'asdasdaSD', NULL, NULL, 1, 1, NULL, 1, '2025-09-03', '16:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-03 06:30:19', '2025-09-11 09:11:19'),
(82, NULL, 'ASFDASFGASD', NULL, NULL, 1, 7, NULL, 1, '2025-09-03', '14:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-03 06:31:19', '2025-09-11 09:11:14'),
(84, NULL, 'sdfafd', NULL, NULL, 1, 1, NULL, 1, '2025-09-11', '14:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-11 05:17:52', '2025-09-11 06:30:54'),
(85, NULL, 'asddad', NULL, NULL, 1, 1, NULL, 1, '2025-09-12', '14:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-11 06:30:25', '2025-09-11 09:11:24'),
(87, NULL, 'ASDASD', NULL, NULL, 1, 12, NULL, 1, '2025-09-12', '12:00-13:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-11 08:57:06', '2025-09-11 09:11:28'),
(90, NULL, 'dafafgasdd', NULL, NULL, 1, 1, NULL, 1, '2025-09-12', '12:00-13:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-11 11:24:48', '2025-10-08 07:48:06'),
(92, NULL, 'sdasdasdasda', NULL, NULL, 1, 1, NULL, 1, '2025-09-13', '16:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-12 13:57:13', '2025-09-12 14:39:28'),
(93, NULL, 'samleguest', NULL, NULL, 1, 4, NULL, 1, '2025-09-13', '13:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-12 14:30:34', '2025-10-08 07:48:10'),
(94, NULL, 'je', NULL, NULL, 1, 3, NULL, 1, '2025-09-13', '14:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-12 14:32:18', '2025-10-08 07:48:14'),
(99, 5, NULL, NULL, NULL, 0, 7, NULL, 1, '2025-05-17', '13:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-17 00:42:43', '2025-10-08 07:40:20'),
(100, 2, NULL, NULL, NULL, 0, 8, NULL, 1, '2025-05-12', '15:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-11 20:42:43', '2025-10-08 07:40:17'),
(101, 5, NULL, NULL, NULL, 0, 69, NULL, 1, '2025-05-20', '12:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-19 21:42:43', '2025-10-08 07:40:21'),
(102, 5, NULL, NULL, NULL, 0, 15, NULL, 1, '2025-05-07', '11:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-06 19:42:43', '2025-10-08 07:19:42'),
(105, 5, NULL, NULL, NULL, 0, 35, NULL, 1, '2025-05-24', '11:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-23 21:42:43', '2025-10-08 07:40:52'),
(106, 2, NULL, NULL, NULL, 0, 56, NULL, 1, '2025-04-28', '15:00-13:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-04-27 22:42:43', '2025-10-08 07:19:37'),
(110, 2, NULL, NULL, NULL, 0, 86, NULL, 1, '2025-05-22', '10:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-21 22:42:43', '2025-10-08 07:40:52'),
(111, 2, NULL, NULL, NULL, 0, 109, NULL, 2, '2025-04-30', '13:00-11:00', 'active', NULL, 'unpaid', NULL, '2025-04-29 23:42:43', '2025-04-29 23:42:43'),
(112, 2, NULL, NULL, NULL, 0, 24, NULL, 2, '2025-05-13', '11:00-12:00', 'active', NULL, 'unpaid', NULL, '2025-05-13 03:42:43', '2025-05-13 03:42:43'),
(113, 2, NULL, NULL, NULL, 0, 36, NULL, 2, '2025-05-07', '14:00-15:00', 'active', NULL, 'unpaid', NULL, '2025-05-07 00:42:43', '2025-05-07 00:42:43'),
(115, 2, NULL, NULL, NULL, 0, 31, NULL, 2, '2025-05-11', '10:00-14:00', 'active', NULL, 'unpaid', NULL, '2025-05-10 22:42:43', '2025-05-10 22:42:43'),
(117, 5, NULL, NULL, NULL, 0, 126, NULL, 2, '2025-05-23', '13:00-10:00', 'active', NULL, 'unpaid', NULL, '2025-05-22 19:42:43', '2025-05-22 19:42:43'),
(158, 2, NULL, NULL, NULL, 0, 37, NULL, 1, '2025-06-01', '15:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-31 19:42:44', '2025-10-08 07:40:54'),
(160, 2, NULL, NULL, NULL, 0, 60, NULL, 1, '2025-05-30', '16:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-29 22:42:44', '2025-10-08 07:40:51'),
(161, 2, NULL, NULL, NULL, 0, 28, NULL, 1, '2025-06-12', '15:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-11 22:42:44', '2025-10-08 07:41:04'),
(162, 5, NULL, NULL, NULL, 0, 89, NULL, 1, '2025-06-07', '12:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-07 03:42:44', '2025-10-08 07:40:59'),
(163, 5, NULL, NULL, NULL, 0, 105, NULL, 1, '2025-06-15', '14:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-15 03:42:44', '2025-10-08 07:41:06'),
(166, 2, NULL, NULL, NULL, 0, 34, NULL, 1, '2025-06-06', '16:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-06 03:42:44', '2025-10-08 07:40:59'),
(167, 2, NULL, NULL, NULL, 0, 42, NULL, 1, '2025-06-01', '14:00-16:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-31 22:42:44', '2025-10-08 07:40:55'),
(168, 5, NULL, NULL, NULL, 0, 11, NULL, 1, '2025-06-09', '15:00-16:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-09 01:42:44', '2025-10-08 07:41:00'),
(170, 2, NULL, NULL, NULL, 0, 45, NULL, 1, '2025-06-09', '15:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-08 22:42:44', '2025-10-08 07:41:00'),
(172, 2, NULL, NULL, NULL, 0, 125, NULL, 2, '2025-06-22', '11:00-17:00', 'active', NULL, 'unpaid', NULL, '2025-06-21 23:42:44', '2025-06-21 23:42:44'),
(176, 2, NULL, NULL, NULL, 0, 55, NULL, 2, '2025-05-31', '9:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-05-31 01:42:44', '2025-05-31 01:42:44'),
(177, 2, NULL, NULL, NULL, 0, 40, NULL, 2, '2025-06-10', '9:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-06-10 02:42:44', '2025-06-10 02:42:44'),
(203, 5, NULL, NULL, NULL, 0, 127, NULL, 1, '2025-07-15', '15:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-14 19:42:44', '2025-10-08 07:41:27'),
(204, 2, NULL, NULL, NULL, 0, 19, NULL, 1, '2025-07-06', '12:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-05 23:42:44', '2025-10-08 07:41:16'),
(205, 2, NULL, NULL, NULL, 0, 71, NULL, 1, '2025-07-19', '16:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-18 22:42:44', '2025-10-08 07:41:30'),
(206, 5, NULL, NULL, NULL, 0, 111, NULL, 1, '2025-07-21', '12:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-20 19:42:44', '2025-10-08 07:41:32'),
(208, 5, NULL, NULL, NULL, 0, 62, NULL, 1, '2025-07-11', '12:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-11 00:42:44', '2025-10-08 07:41:13'),
(209, 5, NULL, NULL, NULL, 0, 54, NULL, 1, '2025-07-13', '13:00-13:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-13 03:42:44', '2025-10-08 07:41:27'),
(210, 2, NULL, NULL, NULL, 0, 118, NULL, 1, '2025-07-06', '10:00-13:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-06 02:42:44', '2025-10-08 07:41:15'),
(211, 5, NULL, NULL, NULL, 0, 60, NULL, 1, '2025-07-08', '9:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-07 21:42:44', '2025-10-08 07:41:14'),
(212, 5, NULL, NULL, NULL, 0, 5, NULL, 1, '2025-07-20', '16:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-20 02:42:44', '2025-10-08 07:41:29'),
(213, 2, NULL, NULL, NULL, 0, 4, NULL, 1, '2025-07-18', '9:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-17 20:42:44', '2025-10-08 07:41:31'),
(214, 2, NULL, NULL, NULL, 0, 83, NULL, 1, '2025-07-07', '15:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-06 22:42:44', '2025-10-08 07:41:15'),
(215, 2, NULL, NULL, NULL, 0, 21, NULL, 1, '2025-07-10', '15:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-10 02:42:44', '2025-10-08 07:41:13'),
(217, 2, NULL, NULL, NULL, 0, 11, NULL, 2, '2025-07-25', '9:00-14:00', 'active', NULL, 'unpaid', NULL, '2025-07-24 21:42:44', '2025-07-24 21:42:44'),
(218, 5, NULL, NULL, NULL, 0, 91, NULL, 2, '2025-07-14', '10:00-15:00', 'active', NULL, 'unpaid', NULL, '2025-07-13 21:42:44', '2025-07-13 21:42:44'),
(220, 2, NULL, NULL, NULL, 0, 8, NULL, 2, '2025-07-21', '9:00-16:00', 'active', NULL, 'unpaid', NULL, '2025-07-20 19:42:44', '2025-07-20 19:42:44'),
(224, 2, NULL, NULL, NULL, 0, 20, NULL, 2, '2025-07-12', '14:00-10:00', 'active', NULL, 'unpaid', NULL, '2025-07-11 19:42:44', '2025-07-11 19:42:44'),
(225, 2, NULL, NULL, NULL, 0, 33, NULL, 2, '2025-07-01', '16:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-07-01 02:42:44', '2025-07-01 02:42:44'),
(226, 5, NULL, NULL, NULL, 0, 68, NULL, 2, '2025-07-01', '9:00-10:00', 'active', NULL, 'unpaid', NULL, '2025-07-01 00:42:44', '2025-07-01 00:42:44'),
(227, 2, NULL, NULL, NULL, 0, 118, NULL, 2, '2025-06-29', '15:00-16:00', 'active', NULL, 'unpaid', NULL, '2025-06-28 21:42:44', '2025-06-28 21:42:44'),
(228, 2, NULL, NULL, NULL, 0, 56, NULL, 2, '2025-07-09', '10:00-12:00', 'active', NULL, 'unpaid', NULL, '2025-07-09 01:42:44', '2025-07-09 01:42:44'),
(229, 5, NULL, NULL, NULL, 0, 35, NULL, 2, '2025-07-15', '14:00-10:00', 'active', NULL, 'unpaid', NULL, '2025-07-14 20:42:44', '2025-07-14 20:42:44'),
(258, 2, NULL, NULL, NULL, 0, 73, NULL, 1, '2025-08-23', '16:00-16:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-08-22 21:42:44', '2025-10-08 07:41:51'),
(259, 5, NULL, NULL, NULL, 0, 62, NULL, 1, '2025-08-08', '15:00-16:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-08-08 01:42:44', '2025-10-08 07:41:38'),
(260, 2, NULL, NULL, NULL, 0, 88, NULL, 1, '2025-08-04', '14:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-08-04 01:42:44', '2025-10-08 07:41:37'),
(261, 5, NULL, NULL, NULL, 0, 36, NULL, 1, '2025-08-10', '12:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-08-10 03:42:44', '2025-10-08 07:41:49'),
(265, 5, NULL, NULL, NULL, 0, 4, NULL, 2, '2025-08-09', '10:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-08-08 21:42:44', '2025-08-08 21:42:44'),
(266, 5, NULL, NULL, NULL, 0, 123, NULL, 2, '2025-08-09', '14:00-15:00', 'active', NULL, 'unpaid', NULL, '2025-08-08 22:42:44', '2025-08-08 22:42:44'),
(267, 5, NULL, NULL, NULL, 0, 104, NULL, 2, '2025-08-11', '16:00-17:00', 'active', NULL, 'unpaid', NULL, '2025-08-10 23:42:44', '2025-08-10 23:42:44'),
(268, 2, NULL, NULL, NULL, 0, 63, NULL, 2, '2025-08-18', '9:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-08-17 19:42:44', '2025-08-17 19:42:44'),
(296, 2, NULL, NULL, NULL, 0, 121, NULL, 1, '2025-09-20', '11:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-20 02:42:44', '2025-10-08 07:41:23'),
(297, 5, NULL, NULL, NULL, 0, 119, NULL, 1, '2025-09-22', '11:00-16:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-22 03:42:44', '2025-10-08 07:41:22'),
(299, 5, NULL, NULL, NULL, 0, 51, NULL, 1, '2025-09-16', '10:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-15 21:42:44', '2025-10-08 07:41:24'),
(300, 2, NULL, NULL, NULL, 0, 67, NULL, 1, '2025-09-17', '14:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-16 19:42:44', '2025-10-08 07:41:24'),
(301, 5, NULL, NULL, NULL, 0, 22, NULL, 1, '2025-09-03', '13:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-02 22:42:44', '2025-10-08 07:41:45'),
(302, 2, NULL, NULL, NULL, 0, 62, NULL, 1, '2025-09-04', '9:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-04 00:42:44', '2025-10-08 07:41:45'),
(303, 2, NULL, NULL, NULL, 0, 5, NULL, 2, '2025-09-11', '13:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-09-10 21:42:44', '2025-09-10 21:42:44'),
(304, 2, NULL, NULL, NULL, 0, 77, NULL, 2, '2025-09-07', '10:00-17:00', 'active', NULL, 'unpaid', NULL, '2025-09-06 23:42:44', '2025-09-06 23:42:44'),
(305, 5, NULL, NULL, NULL, 0, 59, NULL, 2, '2025-09-16', '16:00-12:00', 'active', NULL, 'unpaid', NULL, '2025-09-15 21:42:44', '2025-09-15 21:42:44'),
(306, 5, NULL, NULL, NULL, 0, 70, NULL, 2, '2025-09-21', '11:00-10:00', 'active', NULL, 'unpaid', NULL, '2025-09-20 20:42:44', '2025-09-20 20:42:44'),
(308, 5, NULL, NULL, NULL, 0, 8, NULL, 2, '2025-09-14', '11:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-09-13 22:42:44', '2025-09-13 22:42:44'),
(310, 2, NULL, NULL, NULL, 0, 7, NULL, 2, '2025-09-10', '15:00-14:00', 'active', NULL, 'unpaid', NULL, '2025-09-10 00:42:44', '2025-09-10 00:42:44'),
(311, 5, NULL, NULL, NULL, 0, 59, NULL, 2, '2025-09-16', '11:00-12:00', 'active', NULL, 'unpaid', NULL, '2025-09-16 02:42:44', '2025-09-16 02:42:44'),
(339, 2, NULL, NULL, NULL, 0, 126, NULL, 1, '2025-10-13', '16:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-13 03:42:44', '2025-10-08 07:40:36'),
(340, 5, NULL, NULL, NULL, 0, 63, NULL, 1, '2025-10-08', '10:00-10:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-07 23:42:44', '2025-10-08 07:40:43'),
(341, 2, NULL, NULL, NULL, 0, 3, NULL, 1, '2025-10-12', '10:00-16:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-12 03:42:44', '2025-10-08 07:40:41'),
(342, 2, NULL, NULL, NULL, 0, 106, NULL, 1, '2025-10-16', '15:00-16:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-16 03:42:44', '2025-10-08 07:40:34'),
(343, 2, NULL, NULL, NULL, 0, 17, NULL, 1, '2025-10-19', '13:00-10:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-19 00:42:44', '2025-10-08 07:40:33'),
(346, 5, NULL, NULL, NULL, 0, 81, NULL, 2, '2025-10-05', '16:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-10-04 22:42:44', '2025-10-04 22:42:44'),
(350, 2, NULL, NULL, NULL, 0, 117, NULL, 2, '2025-10-25', '11:00-15:00', 'active', NULL, 'unpaid', NULL, '2025-10-25 02:42:44', '2025-10-25 02:42:44'),
(351, 2, NULL, NULL, NULL, 0, 19, NULL, 2, '2025-10-07', '9:00-17:00', 'active', NULL, 'unpaid', NULL, '2025-10-06 23:42:44', '2025-10-06 23:42:44'),
(354, 5, NULL, NULL, NULL, 0, 80, NULL, 2, '2025-10-25', '16:00-11:00', 'active', NULL, 'unpaid', NULL, '2025-10-25 00:42:44', '2025-10-25 00:42:44'),
(355, 5, NULL, NULL, NULL, 0, 22, NULL, 2, '2025-10-18', '16:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-10-18 02:42:44', '2025-10-18 02:42:44'),
(356, 5, NULL, NULL, NULL, 0, 50, NULL, 2, '2025-10-06', '10:00-11:00', 'active', NULL, 'unpaid', NULL, '2025-10-05 22:42:44', '2025-10-05 22:42:44'),
(386, 2, NULL, NULL, NULL, 0, 97, NULL, 1, '2025-05-10', '13:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-10 02:42:50', '2025-10-08 07:27:58'),
(387, 5, NULL, NULL, NULL, 0, 19, NULL, 1, '2025-05-08', '15:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-08 03:42:50', '2025-10-08 07:27:57'),
(389, 5, NULL, NULL, NULL, 0, 51, NULL, 1, '2025-05-19', '12:00-10:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-19 01:42:50', '2025-10-08 07:40:21'),
(390, 2, NULL, NULL, NULL, 0, 18, NULL, 1, '2025-05-07', '10:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-07 02:42:50', '2025-10-08 07:27:54'),
(391, 2, NULL, NULL, NULL, 0, 108, NULL, 1, '2025-05-13', '16:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-13 03:42:50', '2025-10-08 07:40:18'),
(392, 2, NULL, NULL, NULL, 0, 102, NULL, 1, '2025-05-11', '16:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-11 01:42:50', '2025-10-08 07:27:59'),
(393, 2, NULL, NULL, NULL, 0, 4, NULL, 1, '2025-05-13', '16:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-12 23:42:50', '2025-10-08 07:40:18'),
(394, 2, NULL, NULL, NULL, 0, 70, NULL, 2, '2025-05-07', '12:00-16:00', 'active', NULL, 'unpaid', NULL, '2025-05-06 20:42:50', '2025-05-06 20:42:50'),
(395, 2, NULL, NULL, NULL, 0, 27, NULL, 2, '2025-05-22', '12:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-05-21 21:42:50', '2025-05-21 21:42:50'),
(397, 2, NULL, NULL, NULL, 0, 105, NULL, 2, '2025-05-12', '14:00-12:00', 'active', NULL, 'unpaid', NULL, '2025-05-11 23:42:50', '2025-05-11 23:42:50'),
(398, 5, NULL, NULL, NULL, 0, 23, NULL, 2, '2025-05-07', '10:00-16:00', 'active', NULL, 'unpaid', NULL, '2025-05-06 19:42:50', '2025-05-06 19:42:50'),
(399, 2, NULL, NULL, NULL, 0, 14, NULL, 2, '2025-05-13', '14:00-16:00', 'active', NULL, 'unpaid', NULL, '2025-05-13 03:42:50', '2025-05-13 03:42:50'),
(400, 5, NULL, NULL, NULL, 0, 75, NULL, 2, '2025-05-11', '14:00-17:00', 'active', NULL, 'unpaid', NULL, '2025-05-10 21:42:50', '2025-05-10 21:42:50'),
(403, 2, NULL, NULL, NULL, 0, 68, NULL, 2, '2025-05-05', '12:00-12:00', 'active', NULL, 'unpaid', NULL, '2025-05-04 19:42:50', '2025-05-04 19:42:50'),
(404, 5, NULL, NULL, NULL, 0, 118, NULL, 2, '2025-04-28', '14:00-10:00', 'active', NULL, 'unpaid', NULL, '2025-04-28 03:42:50', '2025-04-28 03:42:50'),
(444, 5, NULL, NULL, NULL, 0, 64, NULL, 1, '2025-06-09', '14:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-09 01:42:51', '2025-10-08 07:41:01'),
(445, 5, NULL, NULL, NULL, 0, 71, NULL, 1, '2025-05-31', '9:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-05-31 03:42:51', '2025-10-08 07:40:54'),
(446, 5, NULL, NULL, NULL, 0, 91, NULL, 1, '2025-06-05', '10:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-04 20:42:51', '2025-10-08 07:40:58'),
(447, 5, NULL, NULL, NULL, 0, 113, NULL, 1, '2025-06-14', '13:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-14 02:42:51', '2025-10-08 07:41:05'),
(449, 2, NULL, NULL, NULL, 0, 81, NULL, 1, '2025-06-11', '11:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-10 21:42:51', '2025-10-08 07:41:03'),
(450, 2, NULL, NULL, NULL, 0, 97, NULL, 1, '2025-06-13', '15:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-13 03:42:51', '2025-10-08 07:41:05'),
(451, 5, NULL, NULL, NULL, 0, 93, NULL, 1, '2025-06-12', '10:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-11 19:42:51', '2025-10-08 07:41:04'),
(455, 5, NULL, NULL, NULL, 0, 107, NULL, 1, '2025-06-02', '16:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-01 22:42:51', '2025-10-08 07:40:57'),
(456, 2, NULL, NULL, NULL, 0, 64, NULL, 2, '2025-06-06', '13:00-11:00', 'active', NULL, 'unpaid', NULL, '2025-06-05 21:42:51', '2025-06-05 21:42:51'),
(457, 2, NULL, NULL, NULL, 0, 21, NULL, 2, '2025-05-31', '9:00-15:00', 'active', NULL, 'unpaid', NULL, '2025-05-31 02:42:51', '2025-05-31 02:42:51'),
(458, 5, NULL, NULL, NULL, 0, 20, NULL, 2, '2025-06-21', '10:00-15:00', 'active', NULL, 'unpaid', NULL, '2025-06-21 02:42:51', '2025-06-21 02:42:51'),
(460, 5, NULL, NULL, NULL, 0, 62, NULL, 2, '2025-05-31', '12:00-14:00', 'active', NULL, 'unpaid', NULL, '2025-05-30 19:42:51', '2025-05-30 19:42:51'),
(461, 2, NULL, NULL, NULL, 0, 25, NULL, 2, '2025-06-21', '13:00-17:00', 'active', NULL, 'unpaid', NULL, '2025-06-21 00:42:51', '2025-06-21 00:42:51'),
(463, 2, NULL, NULL, NULL, 0, 3, NULL, 2, '2025-06-19', '11:00-14:00', 'active', NULL, 'unpaid', NULL, '2025-06-19 01:42:51', '2025-06-19 01:42:51'),
(500, 5, NULL, NULL, NULL, 0, 89, NULL, 1, '2025-07-09', '11:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-08 22:42:51', '2025-10-08 07:41:14'),
(502, 2, NULL, NULL, NULL, 0, 57, NULL, 1, '2025-07-10', '9:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-09 22:42:51', '2025-10-08 07:41:26'),
(503, 5, NULL, NULL, NULL, 0, 5, NULL, 1, '2025-06-30', '15:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-29 21:42:51', '2025-10-08 07:41:09'),
(504, 2, NULL, NULL, NULL, 0, 118, NULL, 1, '2025-07-21', '15:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-20 21:42:51', '2025-10-08 07:41:33'),
(506, 5, NULL, NULL, NULL, 0, 99, NULL, 1, '2025-06-30', '15:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-30 03:42:51', '2025-10-08 07:41:11'),
(507, 5, NULL, NULL, NULL, 0, 24, NULL, 1, '2025-07-12', '14:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-11 21:42:51', '2025-10-08 07:41:12'),
(508, 5, NULL, NULL, NULL, 0, 111, NULL, 1, '2025-07-18', '15:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-17 19:42:51', '2025-10-08 07:41:31'),
(509, 2, NULL, NULL, NULL, 0, 47, NULL, 1, '2025-07-15', '11:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-15 01:42:51', '2025-10-08 07:41:31'),
(510, 5, NULL, NULL, NULL, 0, 126, NULL, 1, '2025-06-30', '14:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-06-29 22:42:51', '2025-10-08 07:41:10'),
(512, 5, NULL, NULL, NULL, 0, 56, NULL, 1, '2025-07-18', '11:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-18 00:42:51', '2025-10-08 07:41:30'),
(514, 5, NULL, NULL, NULL, 0, 66, NULL, 2, '2025-07-05', '10:00-17:00', 'active', NULL, 'unpaid', NULL, '2025-07-04 21:42:51', '2025-07-04 21:42:51'),
(515, 2, NULL, NULL, NULL, 0, 48, NULL, 2, '2025-07-03', '16:00-16:00', 'active', NULL, 'unpaid', NULL, '2025-07-02 20:42:51', '2025-07-02 20:42:51'),
(516, 5, NULL, NULL, NULL, 0, 110, NULL, 2, '2025-07-02', '16:00-10:00', 'active', NULL, 'unpaid', NULL, '2025-07-02 00:42:51', '2025-07-02 00:42:51'),
(517, 2, NULL, NULL, NULL, 0, 82, NULL, 2, '2025-07-17', '9:00-14:00', 'active', NULL, 'unpaid', NULL, '2025-07-17 03:42:51', '2025-07-17 03:42:51'),
(518, 5, NULL, NULL, NULL, 0, 26, NULL, 2, '2025-07-04', '15:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-07-04 00:42:51', '2025-07-04 00:42:51'),
(519, 2, NULL, NULL, NULL, 0, 8, NULL, 2, '2025-07-12', '11:00-10:00', 'active', NULL, 'unpaid', NULL, '2025-07-12 03:42:51', '2025-07-12 03:42:51'),
(520, 2, NULL, NULL, NULL, 0, 16, NULL, 2, '2025-07-06', '13:00-14:00', 'active', NULL, 'unpaid', NULL, '2025-07-06 03:42:51', '2025-07-06 03:42:51'),
(521, 2, NULL, NULL, NULL, 0, 70, NULL, 2, '2025-07-22', '11:00-15:00', 'active', NULL, 'unpaid', NULL, '2025-07-21 20:42:51', '2025-07-21 20:42:51'),
(522, 2, NULL, NULL, NULL, 0, 123, NULL, 2, '2025-07-22', '15:00-17:00', 'active', NULL, 'unpaid', NULL, '2025-07-21 20:42:51', '2025-07-21 20:42:51'),
(552, 5, NULL, NULL, NULL, 0, 63, NULL, 1, '2025-08-08', '11:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-08-08 03:42:51', '2025-10-08 07:41:38'),
(554, 2, NULL, NULL, NULL, 0, 90, NULL, 1, '2025-08-18', '13:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-08-18 03:42:51', '2025-10-08 07:41:50'),
(556, 5, NULL, NULL, NULL, 0, 17, NULL, 1, '2025-08-11', '13:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-08-10 20:42:51', '2025-10-08 07:41:49'),
(557, 5, NULL, NULL, NULL, 0, 77, NULL, 1, '2025-08-22', '10:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-08-22 01:42:51', '2025-10-08 07:41:51'),
(558, 5, NULL, NULL, NULL, 0, 49, NULL, 1, '2025-07-28', '15:00-15:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-07-27 23:42:51', '2025-10-08 07:41:36'),
(560, 5, NULL, NULL, NULL, 0, 108, NULL, 2, '2025-08-19', '11:00-11:00', 'active', NULL, 'unpaid', NULL, '2025-08-19 00:42:51', '2025-08-19 00:42:51'),
(561, 5, NULL, NULL, NULL, 0, 6, NULL, 2, '2025-08-04', '15:00-14:00', 'active', NULL, 'unpaid', NULL, '2025-08-03 23:42:51', '2025-08-03 23:42:51'),
(562, 2, NULL, NULL, NULL, 0, 66, NULL, 2, '2025-08-04', '15:00-15:00', 'active', NULL, 'unpaid', NULL, '2025-08-03 20:42:51', '2025-08-03 20:42:51'),
(563, 5, NULL, NULL, NULL, 0, 5, NULL, 2, '2025-08-14', '11:00-12:00', 'active', NULL, 'unpaid', NULL, '2025-08-14 01:42:51', '2025-08-14 01:42:51'),
(566, 2, NULL, NULL, NULL, 0, 106, NULL, 2, '2025-08-16', '12:00-12:00', 'active', NULL, 'unpaid', NULL, '2025-08-15 21:42:51', '2025-08-15 21:42:51'),
(593, 2, NULL, NULL, NULL, 0, 50, NULL, 1, '2025-09-16', '11:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-15 19:42:51', '2025-10-08 07:41:43'),
(595, 2, NULL, NULL, NULL, 0, 106, NULL, 1, '2025-09-22', '9:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-22 02:42:51', '2025-10-08 07:41:22'),
(597, 5, NULL, NULL, NULL, 0, 43, NULL, 1, '2025-09-02', '12:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-01 20:42:51', '2025-10-08 07:41:46'),
(598, 5, NULL, NULL, NULL, 0, 120, NULL, 1, '2025-09-20', '9:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-19 23:42:51', '2025-10-08 07:41:23'),
(600, 2, NULL, NULL, NULL, 0, 37, NULL, 1, '2025-09-23', '13:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-22 20:42:51', '2025-10-08 07:41:21'),
(601, 2, NULL, NULL, NULL, 0, 50, NULL, 1, '2025-09-15', '9:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-14 19:42:51', '2025-10-08 07:41:44'),
(602, 5, NULL, NULL, NULL, 0, 83, NULL, 2, '2025-09-13', '12:00-12:00', 'active', NULL, 'unpaid', NULL, '2025-09-13 02:42:51', '2025-09-13 02:42:51'),
(603, 5, NULL, NULL, NULL, 0, 20, NULL, 2, '2025-09-11', '11:00-11:00', 'active', NULL, 'unpaid', NULL, '2025-09-11 00:42:51', '2025-09-11 00:42:51'),
(605, 2, NULL, NULL, NULL, 0, 44, NULL, 2, '2025-09-06', '13:00-14:00', 'active', NULL, 'unpaid', NULL, '2025-09-06 03:42:51', '2025-09-06 03:42:51'),
(606, 5, NULL, NULL, NULL, 0, 103, NULL, 2, '2025-09-23', '14:00-13:00', 'active', NULL, 'unpaid', NULL, '2025-09-23 01:42:51', '2025-09-23 01:42:51'),
(637, 5, NULL, NULL, NULL, 0, 97, NULL, 1, '2025-10-09', '11:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-09 01:42:51', '2025-10-08 07:40:41'),
(638, 5, NULL, NULL, NULL, 0, 72, NULL, 1, '2025-09-28', '14:00-13:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-09-27 22:42:51', '2025-10-08 07:41:20'),
(639, 2, NULL, NULL, NULL, 0, 69, NULL, 1, '2025-10-04', '13:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-03 23:42:51', '2025-10-08 07:40:44'),
(641, 5, NULL, NULL, NULL, 0, 122, NULL, 1, '2025-10-15', '14:00-12:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-15 03:42:51', '2025-10-08 07:40:34'),
(644, 2, NULL, NULL, NULL, 0, 37, NULL, 1, '2025-10-06', '11:00-17:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-06 00:42:51', '2025-10-08 07:40:43'),
(647, 2, NULL, NULL, NULL, 0, 102, NULL, 1, '2025-10-06', '16:00-10:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-05 21:42:51', '2025-10-08 07:40:43'),
(648, 5, NULL, NULL, NULL, 0, 104, NULL, 1, '2025-10-17', '13:00-11:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-17 02:42:51', '2025-10-08 07:40:33'),
(649, 2, NULL, NULL, NULL, 0, 17, NULL, 1, '2025-10-24', '16:00-14:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-23 20:42:51', '2025-10-08 07:40:32'),
(650, 2, NULL, NULL, NULL, 0, 13, NULL, 2, '2025-09-28', '15:00-16:00', 'active', NULL, 'unpaid', NULL, '2025-09-28 00:42:51', '2025-09-28 00:42:51'),
(651, 2, NULL, NULL, NULL, 0, 49, NULL, 2, '2025-10-05', '13:00-17:00', 'active', NULL, 'unpaid', NULL, '2025-10-04 19:42:51', '2025-10-04 19:42:51'),
(652, 5, NULL, NULL, NULL, 0, 68, NULL, 2, '2025-10-21', '15:00-17:00', 'active', NULL, 'unpaid', NULL, '2025-10-21 03:42:51', '2025-10-21 03:42:51'),
(653, 2, NULL, NULL, NULL, 0, 86, NULL, 2, '2025-10-23', '13:00-16:00', 'active', NULL, 'unpaid', NULL, '2025-10-23 01:42:51', '2025-10-23 01:42:51'),
(693, NULL, 'asdasd', NULL, NULL, 1, 1, NULL, 1, '2025-10-08', '16:00-17:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-08 08:04:02', '2025-10-08 08:04:15'),
(702, NULL, 'asdadasd', NULL, NULL, 1, 1, NULL, 1, '2025-10-08', '17:00-18:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-08 09:55:31', '2025-10-08 10:02:29'),
(703, NULL, 'asdadasd', NULL, NULL, 1, 1, NULL, 1, '2025-10-08', '17:00-18:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-08 09:58:35', '2025-10-08 10:02:39'),
(704, NULL, 'asdadasd', NULL, NULL, 1, 1, NULL, 1, '2025-10-08', '17:00-18:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-08 09:58:39', '2025-10-08 10:02:41'),
(705, NULL, 'asdadasd', NULL, NULL, 1, 1, NULL, 1, '2025-10-08', '17:00-18:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-08 09:58:44', '2025-10-08 10:02:17'),
(706, NULL, 'asdadasd', NULL, NULL, 1, 1, NULL, 1, '2025-10-08', '17:00-18:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-08 10:00:39', '2025-10-08 10:02:15'),
(707, NULL, 'asdadasd', NULL, NULL, 1, 2, NULL, 1, '2025-10-08', '18:00-19:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-08 10:01:40', '2025-10-08 10:02:45'),
(708, NULL, 'asdasd', NULL, NULL, 1, 2, NULL, 1, '2025-10-08', '18:00-19:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-08 10:01:57', '2025-10-08 10:02:33'),
(709, NULL, '1', NULL, NULL, 1, 1, NULL, 1, '2025-10-08', '18:00-19:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-08 10:03:11', '2025-10-08 10:04:09'),
(710, NULL, '1', NULL, NULL, 1, 1, NULL, 1, '2025-10-08', '18:00-19:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-08 10:03:52', '2025-10-08 10:04:08'),
(713, NULL, 'adasd', NULL, NULL, 1, 1, NULL, 1, '2025-10-08', '18:00-19:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-08 10:21:36', '2025-10-08 10:21:52'),
(716, 22, NULL, NULL, NULL, 0, 1, NULL, 1, '2025-10-29', '12:00-13:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-25 08:19:13', '2025-10-25 08:22:04'),
(717, 22, NULL, NULL, NULL, 0, 1, NULL, 1, '2025-10-29', '12:00-13:00', 'cancelled', NULL, 'unpaid', NULL, '2025-10-25 08:21:55', '2025-10-25 08:22:09'),
(725, NULL, 'asdada', NULL, NULL, 1, 1, NULL, 1, '2025-10-28', '12:00-13:00', 'Cancelled', NULL, 'unpaid', NULL, '2025-10-25 15:04:20', '2025-11-01 03:48:55'),
(735, 21, NULL, NULL, NULL, 0, 14, NULL, 2, '2025-11-12', '10:00-11:00', 'active', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-10-31 04:32:08', '2025-10-31 04:32:08'),
(738, NULL, 'guset', NULL, NULL, 1, 1, NULL, 1, '2025-11-05', '12:00-13:00', 'cancelled', NULL, 'unpaid', NULL, '2025-11-01 03:53:37', '2025-11-01 13:48:24'),
(739, NULL, 'asd', NULL, NULL, 1, NULL, 8, 1, '2025-11-04', '13:00-14:00', 'cancelled', NULL, 'unpaid', NULL, '2025-11-01 03:56:08', '2025-11-01 13:48:30'),
(740, NULL, 'asda', NULL, NULL, 1, 1, NULL, 1, '2025-11-04', '13:00-14:00', 'cancelled', NULL, 'unpaid', NULL, '2025-11-01 03:58:26', '2025-11-01 13:48:34'),
(746, 29, NULL, NULL, NULL, 0, 14, NULL, 1, '2025-11-27', '21:00-22:00', 'cancelled', 'card', 'paid', '\"{\\\"card_type\\\":\\\"visa\\\",\\\"card_number\\\":\\\"1234 5846 4613 1151\\\",\\\"card_expiry\\\":\\\"13\\/37\\\",\\\"card_cvv\\\":\\\"132\\\",\\\"billing_first_name\\\":\\\"Burdagul\\\",\\\"billing_last_name\\\":\\\"Gulapa\\\",\\\"billing_address\\\":\\\"Treelane 2 Blk 9 Lot 5\\\",\\\"billing_city\\\":\\\"Imus City\\\",\\\"billing_zip\\\":\\\"4103\\\",\\\"billing_country\\\":\\\"Philippines\\\",\\\"billing_phone\\\":\\\"6564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD5654\\\",\\\"save_card\\\":true}\"', '2025-11-03 22:06:26', '2025-11-08 16:37:22'),
(747, 24, NULL, NULL, NULL, 0, NULL, 9, 1, '2025-11-25', '19:00-20:00', 'cancelled', 'card', 'pending', '\"{\\\"card_type\\\":\\\"visa\\\",\\\"card_number\\\":\\\"8761 2389 6128 7961\\\",\\\"card_expiry\\\":\\\"67\\/18\\\",\\\"card_cvv\\\":\\\"127\\\",\\\"billing_first_name\\\":\\\"kjasdfklajfwuieyruiwyrw\\\",\\\"billing_last_name\\\":\\\"hjkasfkjashdfjksbnmxcvnmbxc\\\",\\\"billing_address\\\":\\\"isdfujweiouyqwieu2983472893424\\\",\\\"billing_city\\\":\\\"asdfasdfasdkfhkjhweewr\\\",\\\"billing_zip\\\":\\\"98234723786427864212\\\",\\\"billing_country\\\":\\\"kjasdfjkasfweuiywiuyrw\\\",\\\"billing_phone\\\":\\\"98712349812748912748912741241234\\\",\\\"save_card\\\":false}\"', '2025-11-04 16:08:38', '2025-11-04 16:09:27'),
(753, 33, NULL, NULL, NULL, 0, 11, NULL, 2, '2025-11-18', '10:00-11:00', 'cancelled', 'card', 'pending', '\"{\\\"card_type\\\":\\\"visa\\\",\\\"card_number\\\":\\\"1234 5678 9012 3456\\\",\\\"card_expiry\\\":\\\"07\\/33\\\",\\\"card_cvv\\\":\\\"567\\\",\\\"billing_first_name\\\":\\\"Leo ezekiel\\\",\\\"billing_last_name\\\":\\\"Genodiala\\\",\\\"billing_address\\\":\\\"Blk 3a lot 5 casimiro westville phase2 bayabas st. Bacoor cavite\\\",\\\"billing_city\\\":\\\"Cavite\\\",\\\"billing_zip\\\":\\\"4102\\\",\\\"billing_country\\\":\\\"Philippines\\\",\\\"billing_phone\\\":\\\"+639602512409\\\",\\\"save_card\\\":true}\"', '2025-11-06 18:44:43', '2025-11-07 20:27:50'),
(754, 8, NULL, NULL, NULL, 0, 16, NULL, 1, '2025-11-11', '18:00-19:00', 'cancelled', 'card', 'pending', '\"{\\\"card_type\\\":\\\"mastercard\\\",\\\"card_number\\\":\\\"2134 5151 2751 3251\\\",\\\"card_expiry\\\":\\\"12\\/34\\\",\\\"card_cvv\\\":\\\"713\\\",\\\"billing_first_name\\\":\\\"jhsgfhfasdfas11313fasdfsf231123\\\",\\\"billing_last_name\\\":\\\"asfasfasfsf1231231\\\",\\\"billing_address\\\":\\\"ksadfkjsadfh321k34jh1j412k4\\\",\\\"billing_city\\\":\\\"legends lang nakakaalam\\\",\\\"billing_zip\\\":\\\"12341243141342426452452734\\\",\\\"billing_country\\\":\\\"biringan\\\",\\\"billing_phone\\\":\\\"09812301283091283012381203012313\\\",\\\"save_card\\\":true}\"', '2025-11-07 19:54:56', '2025-11-08 22:10:21'),
(755, 35, NULL, NULL, NULL, 0, 17, NULL, 1, '2025-11-11', '13:00-14:00', 'cancelled', 'card', 'pending', '\"{\\\"card_type\\\":\\\"visa\\\",\\\"card_number\\\":\\\"4121 2441 2412\\\",\\\"card_expiry\\\":\\\"05\\/26\\\",\\\"card_cvv\\\":\\\"412\\\",\\\"billing_first_name\\\":\\\"Eric\\\",\\\"billing_last_name\\\":\\\"Belanio\\\",\\\"billing_address\\\":\\\"Greentown Villas 1 mambog 3\\\",\\\"billing_city\\\":\\\"Bacoor\\\",\\\"billing_zip\\\":\\\"4102\\\",\\\"billing_country\\\":\\\"Philippines\\\",\\\"billing_phone\\\":\\\"09946301335\\\",\\\"save_card\\\":false}\"', '2025-11-07 20:08:59', '2025-11-12 11:13:12'),
(757, 24, NULL, NULL, NULL, 0, 9, NULL, 1, '2025-11-11', '15:00-16:00', 'cancelled', 'card', 'pending', '\"{\\\"card_type\\\":\\\"mastercard\\\",\\\"card_number\\\":\\\"1234 1234 3124 1324\\\",\\\"card_expiry\\\":\\\"12\\/32\\\",\\\"card_cvv\\\":\\\"123\\\",\\\"billing_first_name\\\":\\\"asdfasfasf\\\",\\\"billing_last_name\\\":\\\"asfasfsdafsa\\\",\\\"billing_address\\\":\\\"fasdfasdfasdfasfasd\\\",\\\"billing_city\\\":\\\"fsdfasfasfas\\\",\\\"billing_zip\\\":\\\"1241\\\",\\\"billing_country\\\":\\\"asdfsafasdfasdfsdafasd\\\",\\\"billing_phone\\\":\\\"23412431241\\\",\\\"save_card\\\":false}\"', '2025-11-07 22:45:54', '2025-11-07 22:46:34'),
(758, 40, NULL, NULL, NULL, 0, 1, NULL, 2, '2025-11-17', '14:00-15:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-08 13:49:46', '2025-11-08 13:50:44'),
(759, 43, NULL, NULL, NULL, 0, 47, NULL, 1, '2025-11-13', '10:00-11:00', 'cancelled', 'card', 'pending', '\"{\\\"card_type\\\":\\\"visa\\\",\\\"card_number\\\":\\\"1231 5411 5123 12\\\",\\\"card_expiry\\\":\\\"05\\/25\\\",\\\"card_cvv\\\":\\\"123\\\",\\\"billing_first_name\\\":\\\"Eric\\\",\\\"billing_last_name\\\":\\\"Belanio\\\",\\\"billing_address\\\":\\\"Mambog 3 Bacoor\\\",\\\"billing_city\\\":\\\"Breac\\\",\\\"billing_zip\\\":\\\"4102\\\",\\\"billing_country\\\":\\\"Philippines\\\",\\\"billing_phone\\\":\\\"09123131242\\\",\\\"save_card\\\":false}\"', '2025-11-08 16:26:01', '2025-11-08 17:16:15'),
(760, 43, NULL, NULL, NULL, 0, 4, NULL, 1, '2025-11-12', '10:00-11:00', 'cancelled', 'gcash', 'pending', '\"{\\\"gcash_payment\\\":true,\\\"gcash_number\\\":\\\"09602512409\\\"}\"', '2025-11-08 16:30:25', '2025-11-08 17:16:15'),
(761, 43, NULL, NULL, NULL, 0, 15, NULL, 1, '2025-11-12', '15:00-16:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-08 16:30:59', '2025-11-08 17:16:15'),
(762, 43, NULL, NULL, NULL, 0, 44, NULL, 1, '2025-11-12', '10:00-11:00', 'cancelled', 'gcash', 'refunded', '\"{\\\"gcash_payment\\\":true,\\\"gcash_number\\\":\\\"09602512409\\\"}\"', '2025-11-08 16:31:19', '2025-11-08 17:05:25'),
(763, 43, NULL, NULL, NULL, 0, 18, NULL, 1, '2025-11-15', '10:00 - 11:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-08 16:31:53', '2025-11-08 17:16:15'),
(764, 43, NULL, NULL, NULL, 0, 5, NULL, 1, '2025-11-12', '10:00-11:00', 'completed', 'gcash', 'paid', '\"{\\\"gcash_payment\\\":true,\\\"gcash_number\\\":\\\"09602512409\\\"}\"', '2025-11-08 16:32:46', '2025-11-08 17:02:26'),
(765, 43, NULL, NULL, NULL, 0, 12, NULL, 1, '2025-11-12', '10:00-11:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-08 16:33:07', '2025-11-08 16:37:59'),
(766, 46, NULL, NULL, NULL, 0, 1, NULL, 1, '2025-11-14', '18:00-19:00', 'completed', 'card', 'paid', '\"{\\\"card_type\\\":\\\"visa\\\",\\\"card_number\\\":\\\"1234 5141 4541 4144\\\",\\\"card_expiry\\\":\\\"05\\/29\\\",\\\"card_cvv\\\":\\\"444\\\",\\\"billing_first_name\\\":\\\"dejavu\\\",\\\"billing_last_name\\\":\\\"secret\\\",\\\"billing_address\\\":\\\"dyan lang\\\",\\\"billing_city\\\":\\\"kanto\\\",\\\"billing_zip\\\":\\\"4555\\\",\\\"billing_country\\\":\\\"pilipinas\\\",\\\"billing_phone\\\":\\\"09858639424\\\",\\\"save_card\\\":false}\"', '2025-11-08 19:31:04', '2025-11-12 14:45:27'),
(767, 35, NULL, NULL, NULL, 0, 10, NULL, 1, '2025-11-13', '15:00-16:00', 'cancelled', 'card', 'pending', '\"{\\\"card_type\\\":\\\"visa\\\",\\\"card_number\\\":\\\"1241 2412 4112 4123\\\",\\\"card_expiry\\\":\\\"10\\/27\\\",\\\"card_cvv\\\":\\\"123\\\",\\\"billing_first_name\\\":\\\"Eric\\\",\\\"billing_last_name\\\":\\\"Belanio\\\",\\\"billing_address\\\":\\\"Mambog\\\",\\\"billing_city\\\":\\\"Bacoor\\\",\\\"billing_zip\\\":\\\"4102\\\",\\\"billing_country\\\":\\\"Philippines\\\",\\\"billing_phone\\\":\\\"09123124121\\\",\\\"save_card\\\":false}\"', '2025-11-10 13:54:06', '2025-11-12 11:13:14'),
(768, 35, NULL, NULL, NULL, 0, 9, NULL, 1, '2025-11-13', '15:00-16:00', 'cancelled', 'gcash', 'pending', '\"{\\\"gcash_payment\\\":true,\\\"gcash_number\\\":\\\"09602512409\\\"}\"', '2025-11-10 13:55:05', '2025-11-12 11:13:16'),
(769, 35, NULL, NULL, NULL, 0, 2, NULL, 1, '2025-11-13', '14:00-15:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-10 13:55:25', '2025-11-12 11:13:17'),
(770, 35, NULL, NULL, NULL, 0, 2, NULL, 1, '2025-11-13', '15:00-16:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-10 13:56:52', '2025-11-12 11:13:18'),
(771, 35, NULL, NULL, NULL, 0, 21, NULL, 1, '2025-11-13', '15:00-16:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-10 13:57:35', '2025-11-12 11:13:20'),
(772, 35, NULL, NULL, NULL, 0, 5, NULL, 1, '2025-11-13', '15:00-16:00', 'cancelled', 'gcash', 'pending', '\"{\\\"gcash_payment\\\":true,\\\"gcash_number\\\":\\\"09602512409\\\"}\"', '2025-11-10 13:59:21', '2025-11-12 07:51:41'),
(773, 35, NULL, NULL, NULL, 0, 13, NULL, 2, '2025-11-13', '15:00-16:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-10 14:04:34', '2025-11-12 11:13:21'),
(774, 35, NULL, NULL, NULL, 0, 2, NULL, 2, '2025-11-13', '15:00-16:00', 'cancelled', 'gcash', 'pending', '\"{\\\"gcash_payment\\\":true,\\\"gcash_number\\\":\\\"0917 123 4567\\\"}\"', '2025-11-10 14:06:17', '2025-11-12 11:13:22'),
(775, 35, NULL, NULL, NULL, 0, 14, NULL, 2, '2025-11-13', '15:00-16:00', 'cancelled', 'gcash', 'pending', '\"{\\\"gcash_payment\\\":true,\\\"gcash_number\\\":\\\"0917 123 4567\\\"}\"', '2025-11-10 14:06:45', '2025-11-12 11:13:24'),
(776, 35, NULL, NULL, NULL, 0, 7, NULL, 2, '2025-11-13', '15:00-16:00', 'cancelled', 'gcash', 'pending', '\"{\\\"gcash_payment\\\":true,\\\"gcash_number\\\":\\\"0917 123 4567\\\"}\"', '2025-11-10 14:07:03', '2025-11-12 11:13:25'),
(777, 35, NULL, NULL, NULL, 0, 5, NULL, 2, '2025-11-13', '15:00-16:00', 'cancelled', 'gcash', 'pending', '\"{\\\"gcash_payment\\\":true,\\\"gcash_number\\\":\\\"0917 123 4567\\\"}\"', '2025-11-10 14:07:23', '2025-11-12 11:13:27'),
(778, 35, NULL, NULL, NULL, 0, 7, NULL, 2, '2025-11-13', '15:00-16:00', 'cancelled', 'gcash', 'pending', '\"{\\\"gcash_payment\\\":true,\\\"gcash_number\\\":\\\"0917 123 4567\\\"}\"', '2025-11-10 14:07:51', '2025-11-12 11:13:28'),
(779, 33, NULL, NULL, NULL, 0, 2, NULL, 1, '2025-11-14', '10:00-11:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-10 17:32:07', '2025-11-12 14:48:50'),
(780, 48, NULL, NULL, NULL, 0, 3, NULL, 2, '2025-11-17', '12:00-13:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-11 23:29:29', '2025-11-11 23:31:59'),
(781, 35, NULL, NULL, NULL, 0, 3, NULL, 1, '2025-11-18', '10:00 - 11:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-12 11:11:57', '2025-11-12 11:13:29'),
(782, 33, NULL, NULL, NULL, 0, 2, NULL, 1, '2025-12-03', '10:00 - 11:00', 'cancelled', 'gcash', 'refunded', '\"{\\\"gcash_payment\\\":true,\\\"gcash_number\\\":\\\"09602512409\\\"}\"', '2025-11-12 14:48:01', '2025-11-12 10:20:25'),
(783, 24, NULL, NULL, NULL, 0, 13, NULL, 1, '2025-11-15', '17:00-18:00', 'cancelled', 'card', 'pending', '\"{\\\"card_type\\\":\\\"visa\\\",\\\"card_number\\\":\\\"1234 2142 3412 4124\\\",\\\"card_expiry\\\":\\\"10\\/33\\\",\\\"card_cvv\\\":\\\"413\\\",\\\"billing_first_name\\\":\\\"fdsfasfasf\\\",\\\"billing_last_name\\\":\\\"safsafsdfasdfsad\\\",\\\"billing_address\\\":\\\"fasfsadfasfas\\\",\\\"billing_city\\\":\\\"fsafsadfsdafsadfa\\\",\\\"billing_zip\\\":\\\"2134\\\",\\\"billing_country\\\":\\\"asfasfsafasd\\\",\\\"billing_phone\\\":\\\"23421341234\\\",\\\"save_card\\\":false}\"', '2025-11-12 14:48:09', '2025-11-12 09:58:52'),
(784, 33, NULL, NULL, NULL, 0, 2, NULL, 1, '2025-11-18', '12:00-13:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-12 10:15:52', '2025-11-12 10:20:55'),
(785, 33, NULL, NULL, NULL, 0, 1, NULL, 1, '2025-12-03', '18:00 - 19:00', 'cancelled', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-12 10:34:26', '2025-11-12 10:36:24'),
(786, 33, NULL, NULL, NULL, 0, 8, NULL, 1, '2025-11-19', '17:00-18:00', 'active', 'cash', 'unpaid', '\"{\\\"payment_at_branch\\\":true}\"', '2025-11-12 13:02:05', '2025-11-12 13:02:05');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `telephone_number` varchar(255) DEFAULT NULL,
  `operating_days` text DEFAULT NULL,
  `gcash_number` varchar(255) DEFAULT NULL,
  `gcash_qr` varchar(255) DEFAULT NULL,
  `closed_dates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`closed_dates`)),
  `location_detail` varchar(255) DEFAULT NULL,
  `hours` text DEFAULT NULL,
  `map_src` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `time_slot` varchar(255) DEFAULT NULL,
  `break_start` time DEFAULT NULL,
  `break_end` time DEFAULT NULL,
  `slot_capacity` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `key`, `name`, `address`, `city`, `contact_number`, `telephone_number`, `operating_days`, `gcash_number`, `gcash_qr`, `closed_dates`, `location_detail`, `hours`, `map_src`, `created_at`, `updated_at`, `time_slot`, `break_start`, `break_end`, `slot_capacity`, `active`) VALUES
(1, 'banilad', 'Banilad Town Centre', '2nd Level, Banilad Town Centre, Gov. M. Cuenco Ave., Cebu City', 'Manila', '09171234567', '03212345', 'Tuesday,Wednesday,Thursday,Friday,Saturday', '09602512409', 'storage/gcash/gcash_qr_1_1762251340.jpg', NULL, '(2nd level of Banilad Town Centre)', '<div class=\"hours-display\"><div class=\"day-group\"><span class=\"days\"><strong>Tue - Sat</strong>:</span> <span class=\"hours\">10:00 am - 10:00 pm</span></div><div class=\"day-group\"><span class=\"days\"><strong>Mon</strong>:</span> <span class=\"hours\">Closed</span></div><div class=\"day-group\"><span class=\"days\"><strong>Sun</strong>:</span> <span class=\"hours\">Closed</span></div></div>', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.263004968588!2d123.9016596739544!3d10.320824489801565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9990509381945%3A0x73e7592e1d0f982f!2sSkin911%20Medical!5e0!3m2!1sen!2sph!4v1755606033060!5m2!1sen!2sph', '2025-08-25 12:49:27', '2025-11-12 12:45:31', '10:00 - 22:00', '11:00:00', '12:00:00', 5, 1),
(2, 'ayala', 'Ayala Center Cebu', 'Archbishop Reyes Ave, Cebu City, 6000 Cebu', 'Cebu', '09822345671', '08223456', 'Monday,Tuesday,Wednesday,Thursday,Friday', NULL, NULL, NULL, '(Ayala Center Cebu)', '<div class=\"hours-display\"><div class=\"day-group\"><span class=\"days\"><strong>Mon - Fri</strong>:</span> <span class=\"hours\">9:00 am - 7:00 pm</span></div><div class=\"day-group\"><span class=\"days\"><strong>Sat</strong>:</span> <span class=\"hours\">Closed</span></div><div class=\"day-group\"><span class=\"days\"><strong>Sun</strong>:</span> <span class=\"hours\">Closed</span></div></div>', 'https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d3925.295290702664!2d123.90181517053274!3d10.318236315795497!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x33a9993c27f7ca1d%3A0x5b901072be141a1!2sArchbishop%20Reyes%20Ave%2C%20Cebu%20City%2C%206000%20Cebu!3m2!1d10.320865699999999!2d123.9041927!5e0!3m2!1sen!2sph!4v1755874091860!5m2!1sen!2sph', '2025-08-25 12:49:27', '2025-11-12 11:20:49', '09:00 - 19:00', '11:00:00', '12:00:00', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `branch_service`
--

CREATE TABLE `branch_service` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `custom_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch_service`
--

INSERT INTO `branch_service` (`id`, `branch_id`, `service_id`, `price`, `duration`, `active`, `custom_description`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1100.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(2, 2, 2, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(3, 2, 3, 2800.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(4, 2, 4, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(5, 2, 5, 4500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(6, 2, 6, 3000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(7, 2, 7, 3000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(8, 2, 8, 2700.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(9, 2, 9, 5000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(10, 2, 10, 1500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(11, 2, 11, 6500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(12, 2, 12, 3000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(13, 2, 13, 4500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(14, 2, 14, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(15, 2, 15, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(16, 2, 16, 2500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(17, 2, 17, 4000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(18, 2, 18, 2500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(19, 2, 19, 3500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(20, 2, 20, 5000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(21, 2, 21, 7000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(22, 2, 22, 5000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(23, 2, 23, 9000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(24, 2, 24, 4000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(25, 2, 25, 7500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(26, 2, 26, 8000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(27, 2, 27, 7500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(28, 2, 28, 9500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(29, 2, 29, 8000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(30, 2, 30, 9000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(31, 2, 31, 10000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(32, 2, 32, 1100.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(33, 2, 33, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(34, 2, 34, 2800.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(35, 2, 35, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(36, 2, 36, 4500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(37, 2, 37, 3000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(38, 2, 38, 3000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(39, 2, 39, 2700.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(40, 2, 40, 5000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(41, 2, 41, 1500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(42, 2, 42, 6500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(43, 2, 43, 3000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(44, 2, 44, 4500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(45, 2, 45, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(46, 2, 46, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(47, 2, 47, 2500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(48, 2, 48, 4000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(49, 2, 49, 2500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(50, 2, 50, 3500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(51, 2, 51, 5000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(52, 2, 52, 7000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(53, 2, 53, 5000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(54, 2, 54, 9000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(55, 2, 55, 4000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(56, 2, 56, 7500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(57, 2, 57, 8000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(58, 2, 58, 7500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(59, 2, 59, 9500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(60, 2, 60, 8000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(61, 2, 61, 9000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(62, 2, 62, 10000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(63, 2, 63, 1100.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(64, 2, 64, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(65, 2, 65, 2800.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(66, 2, 66, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(67, 2, 67, 4500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(68, 2, 68, 3000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(69, 2, 69, 3000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(70, 2, 70, 2700.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(71, 2, 71, 5000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(72, 2, 72, 1500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(73, 2, 73, 6500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(74, 2, 74, 3000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(75, 2, 75, 4500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(76, 2, 76, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(77, 2, 77, 2000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(78, 2, 78, 2500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(79, 2, 79, 4000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(80, 2, 80, 2500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(81, 2, 81, 3500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(82, 2, 82, 5000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(83, 2, 83, 7000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(84, 2, 84, 5000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(85, 2, 85, 9000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(86, 2, 86, 4000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(87, 2, 87, 7500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(88, 2, 88, 8000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(89, 2, 89, 7500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(90, 2, 90, 9500.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(91, 2, 91, 8000.00, 1, 1, NULL, '2025-09-01 12:36:11', '2025-09-03 04:25:59'),
(92, 2, 92, 9000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(93, 2, 93, 10000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(94, 1, 1, 1400.00, 2, 1, NULL, '2025-09-03 04:53:09', '2025-09-11 05:30:18'),
(95, 1, 2, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-10-08 09:20:59'),
(96, 1, 3, 2800.00, 3, 1, NULL, '2025-09-01 12:36:12', '2025-10-08 09:50:08'),
(97, 1, 4, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-10-08 09:51:40'),
(98, 1, 5, 4500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(99, 1, 6, 3000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(100, 1, 7, 3000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(101, 1, 8, 2700.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(102, 1, 9, 5000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(103, 1, 10, 1500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(104, 1, 11, 6500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(105, 1, 12, 3000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(106, 1, 13, 4500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(107, 1, 14, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(108, 1, 15, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(109, 1, 16, 2500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(110, 1, 17, 4000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(111, 1, 18, 2500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(112, 1, 19, 3500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(113, 1, 20, 5000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(114, 1, 21, 7000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(115, 1, 22, 5000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(116, 1, 23, 9000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(117, 1, 24, 4000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(118, 1, 25, 7500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(119, 1, 26, 8000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(120, 1, 27, 7500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(121, 1, 28, 9500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(122, 1, 29, 8000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(123, 1, 30, 9000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(124, 1, 31, 10000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(125, 1, 32, 1100.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(126, 1, 33, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(127, 1, 34, 2800.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(128, 1, 35, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(129, 1, 36, 4500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(130, 1, 37, 3000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(131, 1, 38, 3000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(132, 1, 39, 2700.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(133, 1, 40, 5000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(134, 1, 41, 1500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(135, 1, 42, 6500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(136, 1, 43, 3000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(137, 1, 44, 4500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(138, 1, 45, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(139, 1, 46, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(140, 1, 47, 2500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(141, 1, 48, 4000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(142, 1, 49, 2500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(143, 1, 50, 3500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(144, 1, 51, 5000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(145, 1, 52, 7000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(146, 1, 53, 5000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(147, 1, 54, 9000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(148, 1, 55, 4000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(149, 1, 56, 7500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(150, 1, 57, 8000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(151, 1, 58, 7500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(152, 1, 59, 9500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(153, 1, 60, 8000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(154, 1, 61, 9000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(155, 1, 62, 10000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(156, 1, 63, 1100.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(157, 1, 64, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(158, 1, 65, 2800.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(159, 1, 66, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(160, 1, 67, 4500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(161, 1, 68, 3000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(162, 1, 69, 3000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(163, 1, 70, 2700.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(164, 1, 71, 5000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(165, 1, 72, 1500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(166, 1, 73, 6500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(167, 1, 74, 3000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(168, 1, 75, 4500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(169, 1, 76, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(170, 1, 77, 2000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(171, 1, 78, 2500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(172, 1, 79, 4000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(173, 1, 80, 2500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(174, 1, 81, 3500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(175, 1, 82, 5000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(176, 1, 83, 7000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(177, 1, 84, 5000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(178, 1, 85, 9000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(179, 1, 86, 4000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(180, 1, 87, 7500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(181, 1, 88, 8000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(182, 1, 89, 7500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(183, 1, 90, 9500.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(184, 1, 91, 8000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(185, 1, 92, 9000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59'),
(186, 1, 93, 10000.00, 1, 1, NULL, '2025-09-01 12:36:12', '2025-09-03 04:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sender_type` enum('client','staff') NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `staff_id`, `branch_id`, `message`, `image`, `sender_type`, `is_read`, `created_at`, `updated_at`) VALUES
(3, 5, NULL, 1, 'asd', NULL, 'client', 1, '2025-10-19 14:38:02', '2025-10-19 15:00:52'),
(4, 5, NULL, 2, 'hello', NULL, 'client', 1, '2025-10-19 14:44:55', '2025-11-08 14:27:35'),
(5, 5, NULL, 2, 'asd', NULL, 'client', 1, '2025-10-19 14:44:56', '2025-11-08 14:27:35'),
(6, 5, NULL, 2, 'asd', NULL, 'client', 1, '2025-10-19 14:44:56', '2025-11-08 14:27:35'),
(7, 5, NULL, 2, 'af', NULL, 'client', 1, '2025-10-19 14:44:57', '2025-11-08 14:27:35'),
(8, 5, NULL, 2, 'efgsd', NULL, 'client', 1, '2025-10-19 14:44:57', '2025-11-08 14:27:35'),
(9, 5, NULL, 2, 'sad', NULL, 'client', 1, '2025-10-19 14:47:47', '2025-11-08 14:27:35'),
(10, 5, NULL, 2, 'asd', NULL, 'client', 1, '2025-10-19 14:47:48', '2025-11-08 14:27:35'),
(11, 5, NULL, 2, 'asd', NULL, 'client', 1, '2025-10-19 14:47:57', '2025-11-08 14:27:35'),
(12, 5, NULL, 2, 'asdd', NULL, 'client', 1, '2025-10-19 14:47:58', '2025-11-08 14:27:35'),
(13, 5, NULL, 2, 'asd', NULL, 'client', 1, '2025-10-19 15:00:46', '2025-11-08 14:27:35'),
(14, 5, NULL, 2, 'asd', NULL, 'client', 1, '2025-10-19 15:00:47', '2025-11-08 14:27:35'),
(15, 5, 9, 1, 'asd', NULL, 'staff', 1, '2025-10-19 15:00:53', '2025-10-19 16:44:32'),
(16, 5, 9, 1, 'sd', NULL, 'staff', 1, '2025-10-19 15:00:54', '2025-10-19 16:44:33'),
(17, 5, NULL, 2, 'test', NULL, 'client', 1, '2025-10-19 15:01:31', '2025-11-08 14:27:35'),
(18, 5, NULL, 1, 'test', NULL, 'client', 1, '2025-10-19 15:01:48', '2025-10-19 15:01:53'),
(19, 5, 9, 1, 'niceee', NULL, 'staff', 1, '2025-10-19 15:03:44', '2025-10-19 16:44:33'),
(20, 5, NULL, 1, 'asd', NULL, 'client', 1, '2025-10-19 15:04:39', '2025-10-19 15:04:45'),
(22, 5, 9, 1, 'ads', NULL, 'staff', 1, '2025-10-19 15:09:14', '2025-10-19 16:44:33'),
(23, 5, 9, 1, 'd', NULL, 'staff', 1, '2025-10-19 15:09:14', '2025-10-19 16:44:33'),
(24, 5, NULL, 1, 'ad', NULL, 'client', 1, '2025-10-19 15:09:23', '2025-10-19 15:09:25'),
(25, 5, NULL, 1, 'asd', NULL, 'client', 1, '2025-10-19 15:09:23', '2025-10-19 15:09:25'),
(27, 5, 9, 1, 'hrllo', NULL, 'staff', 1, '2025-10-19 15:12:59', '2025-10-19 16:44:33'),
(28, NULL, NULL, 1, 'asd', NULL, 'client', 1, '2025-10-19 15:18:37', '2025-10-19 15:18:43'),
(29, NULL, NULL, 1, 'asd', NULL, 'client', 1, '2025-10-19 15:18:38', '2025-10-19 15:18:43'),
(30, 21, NULL, 1, 'Hi', NULL, 'client', 1, '2025-10-19 15:21:12', '2025-10-19 15:21:19'),
(31, 21, 9, 1, 'hello', NULL, 'staff', 1, '2025-10-19 15:21:23', '2025-10-19 15:21:24'),
(32, 21, NULL, 1, 'Ok', NULL, 'client', 1, '2025-10-19 15:21:52', '2025-10-19 15:21:53'),
(34, 21, 9, 1, 'nareceive mo?', NULL, 'staff', 1, '2025-10-19 15:22:17', '2025-10-19 15:22:19'),
(35, 21, NULL, 1, 'Ou', NULL, 'client', 1, '2025-10-19 15:22:35', '2025-10-19 15:23:42'),
(36, 21, NULL, 1, 'K', NULL, 'client', 1, '2025-10-19 15:22:48', '2025-10-19 15:23:42'),
(37, 22, NULL, 1, 'hello', NULL, 'client', 1, '2025-10-25 08:20:01', '2025-10-25 08:20:45'),
(38, 22, 9, 1, 'hi', NULL, 'staff', 1, '2025-10-25 08:20:50', '2025-10-25 08:20:53'),
(39, NULL, NULL, 1, 'sample', NULL, 'client', 1, '2025-10-30 11:59:44', '2025-10-30 12:00:10'),
(40, NULL, 9, 1, 'test\\', NULL, 'staff', 1, '2025-10-30 12:01:50', '2025-11-05 09:51:43'),
(41, NULL, NULL, 1, 'sfafa', NULL, 'client', 1, '2025-10-30 12:02:33', '2025-10-30 12:02:43'),
(42, NULL, 9, 1, 'staf', NULL, 'staff', 1, '2025-10-30 12:05:32', '2025-11-05 09:51:43'),
(43, NULL, NULL, 1, 'asdas', NULL, 'client', 1, '2025-10-30 12:05:56', '2025-10-30 12:05:58'),
(44, NULL, NULL, 1, 'sam', 'chat_images/1761927968_6904e320dd672.jpg', 'client', 1, '2025-10-31 16:26:08', '2025-10-31 16:26:16'),
(45, NULL, 9, 1, NULL, 'chat_images/1761927984_6904e330a9c0e.png', 'staff', 1, '2025-10-31 16:26:24', '2025-11-05 09:51:43'),
(46, NULL, NULL, 1, 'thank you', NULL, 'client', 1, '2025-10-31 16:26:36', '2025-11-01 03:49:42'),
(49, 30, NULL, 1, 'Hello', NULL, 'client', 1, '2025-11-03 22:47:34', '2025-11-04 12:25:48'),
(50, NULL, NULL, 2, 'Hello, Good afternoon. Can I ask more about the details of a specific service?', NULL, 'client', 0, '2025-11-04 12:23:37', '2025-11-04 12:23:37'),
(51, 30, 9, 1, 'asdasdas', NULL, 'staff', 1, '2025-11-04 12:26:16', '2025-11-04 12:26:16'),
(52, 30, 9, 1, 'asd', NULL, 'staff', 1, '2025-11-04 12:26:17', '2025-11-04 12:26:17'),
(53, 30, 9, 1, 'sd', NULL, 'staff', 1, '2025-11-04 12:26:17', '2025-11-04 12:26:17'),
(54, 30, 9, 1, 'sd', NULL, 'staff', 1, '2025-11-04 12:26:17', '2025-11-04 12:26:17'),
(55, NULL, NULL, 1, 'Hello, Good afternoon. Can I ask what is the benefits of a specific service regarding my skin.', NULL, 'client', 1, '2025-11-04 12:27:15', '2025-11-04 12:28:30'),
(56, NULL, 9, 1, 'yownnn', NULL, 'staff', 1, '2025-11-04 12:28:33', '2025-11-07 19:26:38'),
(57, NULL, NULL, 1, 'Yan yan', NULL, 'client', 1, '2025-11-04 12:28:49', '2025-11-04 12:28:53'),
(58, NULL, NULL, 1, 'Send ako picture ah', NULL, 'client', 1, '2025-11-04 12:28:55', '2025-11-04 12:28:58'),
(59, NULL, 9, 1, 'try', 'chat_images/1762230572_6909812c76c94.png', 'staff', 1, '2025-11-04 12:29:32', '2025-11-07 19:26:38'),
(60, NULL, NULL, 1, 'Ayaw mag send', 'chat_images/1762230577_6909813184670.jpeg', 'client', 1, '2025-11-04 12:29:37', '2025-11-04 12:29:38'),
(61, NULL, NULL, 1, 'Ayan', NULL, 'client', 1, '2025-11-04 12:29:39', '2025-11-04 12:29:42'),
(62, NULL, 9, 1, 'kita sau ung sinend klo??', NULL, 'staff', 1, '2025-11-04 12:30:02', '2025-11-07 19:26:38'),
(63, NULL, NULL, 1, 'Diko kita', NULL, 'client', 1, '2025-11-04 12:30:16', '2025-11-04 12:30:17'),
(64, NULL, 9, 1, 'anothre ffixx gegeg', NULL, 'staff', 1, '2025-11-04 12:30:38', '2025-11-07 19:26:38'),
(65, NULL, NULL, 1, 'Di padin kuys', NULL, 'client', 1, '2025-11-04 12:32:28', '2025-11-04 12:32:28'),
(66, NULL, NULL, 1, 'Di KO padin makita', NULL, 'client', 1, '2025-11-04 12:32:34', '2025-11-04 12:32:38'),
(67, NULL, NULL, 1, 'Sarap', 'chat_images/1762230779_690981fba9e40.jpg', 'client', 1, '2025-11-04 12:32:59', '2025-11-04 12:33:03'),
(68, NULL, NULL, 1, 'Ako Naman di ako makapag send Ng walang kasamang text', NULL, 'client', 1, '2025-11-04 12:33:09', '2025-11-04 12:33:13'),
(69, NULL, 9, 1, 'wala pa din sakin send mo sc sa gc', NULL, 'staff', 1, '2025-11-04 12:33:18', '2025-11-07 19:26:38'),
(70, NULL, NULL, 1, 'Diko ma click yung send button pag image Lang naka attached', NULL, 'client', 1, '2025-11-04 12:33:25', '2025-11-04 12:33:28'),
(71, NULL, NULL, 1, 'Ayaw apindo', 'chat_images/1762230847_6909823f3633b.jpg', 'client', 1, '2025-11-04 12:34:07', '2025-11-04 12:34:09'),
(72, NULL, 9, 1, 'gesi gesi noted yan', NULL, 'staff', 1, '2025-11-04 12:39:45', '2025-11-07 19:26:38'),
(73, NULL, NULL, 1, 'Send', 'chat_images/1762231334_69098426b6d6f.jpg', 'client', 1, '2025-11-04 12:42:14', '2025-11-04 12:42:16'),
(74, NULL, NULL, 1, 'Kita mo?', NULL, 'client', 1, '2025-11-04 12:42:19', '2025-11-04 12:42:22'),
(75, 24, NULL, 1, 'wowers', NULL, 'client', 1, '2025-11-04 16:09:59', '2025-11-04 16:11:25'),
(76, 24, 9, 1, 'eto malupet pre', 'chat_images/1762243899_6909b53b8513d.jfif', 'staff', 1, '2025-11-04 16:11:39', '2025-11-10 15:03:49'),
(77, NULL, NULL, 1, 'try', 'chat_images/1762246226_6909be5295d8e.png', 'client', 1, '2025-11-04 16:50:26', '2025-11-04 16:50:48'),
(78, NULL, NULL, 1, 'try', 'chat_images/1762247648_6909c3e02b60d.jpg', 'client', 1, '2025-11-04 17:14:08', '2025-11-04 17:25:00'),
(87, NULL, NULL, 1, 'HEllo', NULL, 'client', 1, '2025-11-04 17:24:14', '2025-11-04 17:24:23'),
(99, NULL, NULL, 1, 'Hello nakapag bayad na po ako ng booking', NULL, 'client', 1, '2025-11-04 18:01:32', '2025-11-04 18:05:34'),
(100, NULL, NULL, 1, 'sds', 'chat_images/1762250549_6909cf355ada3.jpg', 'client', 1, '2025-11-04 18:02:29', '2025-11-04 18:05:34'),
(101, NULL, 9, 1, 'adas', 'chat_images/1762250779_6909d01b13bf3.jpg', 'staff', 1, '2025-11-04 18:06:19', '2025-11-07 19:26:38'),
(103, NULL, NULL, 1, 'sda', 'chat_images/1762250881_6909d08185d47.jpg', 'client', 1, '2025-11-04 18:08:01', '2025-11-04 18:08:04'),
(104, NULL, 9, 1, 'asdas', 'chat_images/1762250917_6909d0a52eb94.png', 'staff', 1, '2025-11-04 18:08:37', '2025-11-07 19:26:38'),
(106, NULL, NULL, 1, 'asdas', 'chat_images/1762250940_6909d0bc6b88e.png', 'client', 1, '2025-11-04 18:09:00', '2025-11-04 18:09:02'),
(107, 24, NULL, 1, 'a', NULL, 'client', 1, '2025-11-04 18:09:14', '2025-11-04 18:09:36'),
(108, NULL, NULL, 1, 'sdadas', 'chat_images/1762250964_6909d0d4c023e.png', 'client', 1, '2025-11-04 18:09:24', '2025-11-04 18:09:26'),
(109, NULL, 9, 1, 'adsada', 'chat_images/1762251028_6909d1141930d.png', 'staff', 1, '2025-11-04 18:10:28', '2025-11-07 19:26:38'),
(110, NULL, NULL, 1, 'Hello, I would like to ask what kind of treatment is suitable for this kind of skin condition in my face', NULL, 'client', 1, '2025-11-04 18:12:09', '2025-11-04 18:12:19'),
(111, NULL, NULL, 1, 'Eto po', 'chat_images/1762251147_6909d18bef0ac.jpg', 'client', 1, '2025-11-04 18:12:27', '2025-11-04 18:12:37'),
(112, NULL, NULL, 1, 'sdas', 'chat_images/1762251189_6909d1b5919d6.png', 'client', 1, '2025-11-04 18:13:09', '2025-11-04 18:13:15'),
(113, NULL, NULL, 1, 'sda', 'chat_images/1762251226_6909d1da94e51.png', 'client', 1, '2025-11-04 18:13:46', '2025-11-04 18:13:47'),
(114, NULL, NULL, 1, 'asda', 'chat_images/1762251720_6909d3c8ee4b5.jpg', 'client', 1, '2025-11-04 18:22:00', '2025-11-04 18:22:18'),
(115, NULL, NULL, 1, 'adsa', 'chat_images/1762251728_6909d3d0e557f.jpg', 'client', 1, '2025-11-04 18:22:08', '2025-11-04 18:22:18'),
(116, NULL, 9, 1, NULL, 'chat_images/1762251750_6909d3e6c7539.jpg', 'staff', 1, '2025-11-04 18:22:30', '2025-11-07 19:26:38'),
(117, NULL, NULL, 1, 'asdad', 'chat_images/1762251777_6909d4017cfcb.jpg', 'client', 1, '2025-11-04 18:22:57', '2025-11-04 18:23:02'),
(118, NULL, NULL, 1, 's', 'chat_images/1762252117_6909d5551bd9e.jpg', 'client', 1, '2025-11-04 18:28:37', '2025-11-04 18:41:20'),
(119, NULL, NULL, 1, 'asd', 'chat_images/1762252125_6909d55df1702.png', 'client', 0, '2025-11-04 18:28:45', '2025-11-04 18:28:45'),
(120, NULL, 9, 1, NULL, 'chat_images/1762252880_6909d85009450.jpg', 'staff', 1, '2025-11-04 18:41:20', '2025-11-07 19:26:38'),
(121, NULL, NULL, 1, 'Gcash', 'chat_images/1762252893_6909d85d1c197.jpg', 'client', 1, '2025-11-04 18:41:33', '2025-11-04 18:41:35'),
(122, NULL, NULL, 1, 'DSADADS', NULL, 'client', 1, '2025-11-05 22:25:13', '2025-11-05 22:26:06'),
(123, NULL, NULL, 1, 'SADSA', 'chat_images/1762352719_690b5e4f6ed87.jpg', 'client', 1, '2025-11-05 22:25:19', '2025-11-05 22:26:06'),
(124, NULL, NULL, 1, 'sad', 'chat_images/1762352778_690b5e8ab49ee.jpg', 'client', 1, '2025-11-05 22:26:18', '2025-11-05 22:26:55'),
(125, NULL, 9, 1, NULL, 'chat_images/1762352825_690b5eb93e7a2.png', 'staff', 1, '2025-11-05 22:27:05', '2025-11-05 22:27:05'),
(126, NULL, 9, 1, NULL, 'chat_images/1762353197_690b602d8c1a6.png', 'staff', 1, '2025-11-05 22:33:17', '2025-11-05 22:33:17'),
(127, NULL, NULL, 1, 'sda', 'chat_images/1762353203_690b60338a8aa.jpg', 'client', 1, '2025-11-05 22:33:23', '2025-11-05 22:33:27'),
(128, NULL, NULL, 1, 'dsa', 'chat_images/1762353217_690b60411c02b.jpg', 'client', 1, '2025-11-05 22:33:37', '2025-11-05 22:33:50'),
(129, NULL, NULL, 1, 'ddsadas', 'chat_images/1762353224_690b6048df26b.jpg', 'client', 1, '2025-11-05 22:33:44', '2025-11-05 22:33:50'),
(130, NULL, 9, 1, NULL, 'chat_images/1762355422_690b68de8369e.png', 'staff', 1, '2025-11-05 23:10:22', '2025-11-05 23:10:22'),
(131, NULL, 9, 1, NULL, 'chat_images/1762355649_690b69c16b2b6.png', 'staff', 1, '2025-11-05 23:14:09', '2025-11-05 23:14:09'),
(132, 33, NULL, 1, 'a', 'chat_images/1762355750_690b6a26d528f.jpg', 'client', 1, '2025-11-05 23:15:50', '2025-11-05 23:15:56'),
(133, 33, 9, 1, NULL, 'chat_images/1762355764_690b6a3415184.png', 'staff', 1, '2025-11-05 23:16:04', '2025-11-12 13:04:21'),
(134, 33, NULL, 1, 'adasd', 'chat_images/1762355934_690b6aded7b69.jpg', 'client', 1, '2025-11-05 23:18:54', '2025-11-05 23:18:56'),
(135, 33, 9, 1, NULL, 'chat_images/1762356209_690b6bf17fa36.png', 'staff', 1, '2025-11-05 23:23:29', '2025-11-12 13:04:21'),
(136, 33, 9, 1, NULL, 'chat_images/1762356324_690b6c6440749.png', 'staff', 1, '2025-11-05 23:25:24', '2025-11-12 13:04:22'),
(137, 33, NULL, 1, 'asdas', 'chat_images/1762356350_690b6c7e5a561.jpg', 'client', 1, '2025-11-05 23:25:50', '2025-11-05 23:25:54'),
(138, 33, NULL, 1, 'asd', 'chat_images/1762357174_690b6fb6e8107.jpg', 'client', 1, '2025-11-05 23:39:34', '2025-11-05 23:39:40'),
(139, 33, 9, 1, NULL, 'chat_images/1762357188_690b6fc43722e.png', 'staff', 1, '2025-11-05 23:39:48', '2025-11-12 13:04:22'),
(140, NULL, NULL, 1, 'sdas', 'chat_images/1762358123_690b736b90df8.jpg', 'client', 1, '2025-11-05 23:55:23', '2025-11-05 23:55:43'),
(141, NULL, NULL, 1, 'GCASH', 'chat_images/1762358146_690b73829b32a.jpg', 'client', 1, '2025-11-05 23:55:46', '2025-11-05 23:55:50'),
(142, NULL, 9, 1, NULL, 'chat_images/1762358150_690b7386a5b21.png', 'staff', 1, '2025-11-05 23:55:50', '2025-11-05 23:55:50'),
(143, NULL, 9, 1, NULL, 'chat_images/1762358639_690b756f2e384.png', 'staff', 1, '2025-11-06 00:03:59', '2025-11-06 00:03:59'),
(144, NULL, 9, 1, 'asdasd', 'chat_images/1762358857_690b7649ce6a3.png', 'staff', 1, '2025-11-06 00:07:37', '2025-11-06 00:07:37'),
(145, NULL, NULL, 1, 'sdad', 'uploads/chat_images/1762358886_690b766690720.jpg', 'client', 1, '2025-11-06 00:08:06', '2025-11-06 00:13:28'),
(146, NULL, NULL, 1, 'adsada', 'uploads/chat_images/1762358894_690b766e5aa7e.jpg', 'client', 1, '2025-11-06 00:08:14', '2025-11-06 00:13:28'),
(148, NULL, 9, 1, NULL, 'chat_images/1762359225_690b77b9f2f48.png', 'staff', 1, '2025-11-06 00:13:45', '2025-11-06 00:13:45'),
(149, NULL, NULL, 1, 'rere', 'chat_images/1762359228_690b77bc89677.jpg', 'client', 1, '2025-11-06 00:13:48', '2025-11-06 00:13:51'),
(150, 33, NULL, 1, 'asd', 'chat_images/1762359619_690b794392fca.jfif', 'client', 1, '2025-11-06 00:20:19', '2025-11-06 00:20:23'),
(151, 33, 9, 1, NULL, 'chat_images/1762359741_690b79bda5561.png', 'staff', 1, '2025-11-06 00:22:21', '2025-11-12 13:04:22'),
(152, 33, 9, 1, NULL, 'chat_images/1762360135_690b7b47acce9.png', 'staff', 1, '2025-11-06 00:28:55', '2025-11-12 13:04:22'),
(153, 33, 9, 1, NULL, 'chat_images/1762360887_690b7e3797f37.png', 'staff', 1, '2025-11-06 00:41:27', '2025-11-12 13:04:22'),
(154, 33, NULL, 1, 'asdas', 'chat_images/1762360994_690b7ea2c0486.jpg', 'client', 1, '2025-11-06 00:43:14', '2025-11-06 00:43:15'),
(155, 33, NULL, 1, 'asdas', 'chat_images/1762361068_690b7eec5aafe.jpg', 'client', 1, '2025-11-06 00:44:28', '2025-11-07 15:52:05'),
(156, NULL, NULL, 1, 'Check', NULL, 'client', 1, '2025-11-07 15:50:22', '2025-11-07 15:52:02'),
(157, NULL, NULL, 1, 'Check', NULL, 'client', 1, '2025-11-07 15:50:24', '2025-11-07 15:52:02'),
(158, NULL, NULL, 1, 'Connect to staff', NULL, 'client', 1, '2025-11-07 15:50:39', '2025-11-07 15:52:02'),
(159, NULL, NULL, 1, 'Hello', NULL, 'client', 1, '2025-11-07 15:51:01', '2025-11-07 15:52:02'),
(160, NULL, NULL, 1, 'SDAd', 'chat_images/1762501869_690da4ed3dd1a.jpg', 'client', 1, '2025-11-07 15:51:09', '2025-11-07 15:52:02'),
(161, NULL, 9, 1, 'Wth', NULL, 'staff', 1, '2025-11-07 15:52:19', '2025-11-07 15:52:19'),
(162, NULL, NULL, 1, 'e', NULL, 'client', 1, '2025-11-07 15:52:39', '2025-11-07 15:52:43'),
(163, NULL, NULL, 1, 'wewqeqw', NULL, 'client', 1, '2025-11-07 15:53:31', '2025-11-07 15:54:08'),
(164, NULL, NULL, 1, 'qewqeqw', NULL, 'client', 1, '2025-11-07 15:53:34', '2025-11-07 15:54:08'),
(165, NULL, NULL, 1, 'Hello', NULL, 'client', 1, '2025-11-07 15:54:11', '2025-11-07 15:54:13'),
(166, NULL, 9, 1, NULL, 'chat_images/1762502060_690da5ac57552.jpg', 'staff', 1, '2025-11-07 15:54:20', '2025-11-07 15:54:20'),
(167, NULL, NULL, 1, 'He', NULL, 'client', 1, '2025-11-07 15:54:38', '2025-11-07 15:54:40'),
(168, NULL, 9, 1, NULL, 'chat_images/1762502090_690da5ca7b4b4.jpg', 'staff', 1, '2025-11-07 15:54:50', '2025-11-07 15:54:50'),
(169, NULL, NULL, 1, 'g', NULL, 'client', 1, '2025-11-07 15:55:01', '2025-11-07 15:55:01'),
(170, NULL, 9, 1, NULL, 'chat_images/1762502126_690da5eecd2f5.png', 'staff', 1, '2025-11-07 15:55:26', '2025-11-07 15:55:26'),
(171, NULL, NULL, 1, 'G', NULL, 'client', 1, '2025-11-07 15:56:00', '2025-11-07 15:56:02'),
(172, NULL, NULL, 1, 'Gcash', 'chat_images/1762502166_690da61661f65.jpg', 'client', 1, '2025-11-07 15:56:06', '2025-11-07 15:56:07'),
(173, NULL, 9, 1, 'Gege', 'chat_images/1762502183_690da62785c58.jpg', 'staff', 1, '2025-11-07 15:56:23', '2025-11-07 15:56:23'),
(174, NULL, NULL, 1, 'Ha', NULL, 'client', 1, '2025-11-07 15:57:29', '2025-11-07 15:57:37'),
(175, NULL, 9, 1, NULL, 'chat_images/1762502271_690da67f990ef.jpg', 'staff', 1, '2025-11-07 15:57:51', '2025-11-07 15:57:51'),
(176, NULL, NULL, 1, 'G', 'chat_images/1762502344_690da6c8e200d.jpg', 'client', 1, '2025-11-07 15:59:04', '2025-11-07 15:59:07'),
(178, NULL, NULL, 1, 'Dasd', NULL, 'client', 1, '2025-11-07 16:00:09', '2025-11-07 16:00:14'),
(179, 35, NULL, 1, 'Hello', NULL, 'client', 1, '2025-11-07 18:32:56', '2025-11-07 18:32:59'),
(188, NULL, 9, 1, 'qeqweqw', NULL, 'staff', 1, '2025-11-07 18:39:24', '2025-11-07 18:39:24'),
(189, NULL, 9, 1, 'wqeqeqw', NULL, 'staff', 1, '2025-11-07 18:40:05', '2025-11-07 18:40:05'),
(191, NULL, NULL, 1, 'qewqeqw', NULL, 'client', 1, '2025-11-07 18:40:20', '2025-11-07 18:40:22'),
(194, NULL, 9, 1, 'GEGE', NULL, 'staff', 1, '2025-11-07 19:25:24', '2025-11-07 19:25:24'),
(197, NULL, 9, 1, 'aseasdasdasd', NULL, 'staff', 1, '2025-11-07 19:26:15', '2025-11-07 19:26:15'),
(198, 35, NULL, 1, 'Hello', NULL, 'client', 1, '2025-11-07 19:26:57', '2025-11-07 19:27:01'),
(199, 35, NULL, 1, 'Hello', NULL, 'client', 1, '2025-11-07 19:27:02', '2025-11-07 19:27:07'),
(200, 35, 9, 1, 'htdog', NULL, 'staff', 1, '2025-11-07 19:27:07', '2025-11-12 12:02:20'),
(203, 24, 9, 1, 'LIGO na', NULL, 'staff', 1, '2025-11-07 19:28:23', '2025-11-10 15:03:49'),
(205, 24, NULL, 1, 'yon salamat', NULL, 'client', 1, '2025-11-07 19:28:38', '2025-11-07 19:28:40'),
(206, 24, 9, 1, 'asdasdasdfg', NULL, 'staff', 1, '2025-11-07 19:28:43', '2025-11-10 15:03:49'),
(209, 24, NULL, 1, 'LKAJDSLA', NULL, 'client', 1, '2025-11-07 19:29:52', '2025-11-07 19:29:53'),
(210, 24, NULL, 1, 'ASDF', NULL, 'client', 1, '2025-11-07 19:29:53', '2025-11-07 19:29:54'),
(211, 24, NULL, 1, 'SADF', NULL, 'client', 1, '2025-11-07 19:29:54', '2025-11-07 19:29:54'),
(212, 24, NULL, 1, 'ASDF', NULL, 'client', 1, '2025-11-07 19:29:55', '2025-11-07 19:29:55'),
(213, 24, NULL, 1, 'ASDF', NULL, 'client', 1, '2025-11-07 19:29:56', '2025-11-07 19:29:56'),
(214, 24, NULL, 1, 'ASDF', NULL, 'client', 1, '2025-11-07 19:29:56', '2025-11-07 19:29:58'),
(215, 24, NULL, 1, 'FDS', NULL, 'client', 1, '2025-11-07 19:29:57', '2025-11-07 19:29:58'),
(216, 24, NULL, 1, 'SDFSFA', NULL, 'client', 1, '2025-11-07 19:29:59', '2025-11-07 19:30:00'),
(219, 24, 38, 1, 'wew', NULL, 'staff', 1, '2025-11-07 21:16:40', '2025-11-10 15:03:49'),
(221, 40, NULL, 2, 'Test', NULL, 'client', 1, '2025-11-08 13:45:35', '2025-11-08 13:57:56'),
(222, 40, 42, 2, 'Test', NULL, 'staff', 1, '2025-11-08 13:58:01', '2025-11-08 13:58:01'),
(223, 40, 42, 2, 'Check', NULL, 'staff', 1, '2025-11-08 13:58:03', '2025-11-08 13:58:03'),
(224, 43, NULL, 2, 'Hello', NULL, 'client', 1, '2025-11-08 16:44:25', '2025-11-10 16:36:41'),
(225, 43, NULL, 1, 'ehllo', NULL, 'client', 1, '2025-11-08 16:45:06', '2025-11-08 16:45:13'),
(226, 43, NULL, 1, 'Hello', NULL, 'client', 1, '2025-11-08 16:45:07', '2025-11-08 16:45:13'),
(227, 43, NULL, 1, 'Test', NULL, 'client', 1, '2025-11-08 16:45:08', '2025-11-08 16:45:13'),
(228, 43, NULL, 1, 'test', NULL, 'client', 1, '2025-11-08 16:45:09', '2025-11-08 16:45:13'),
(229, 43, 9, 1, ':)', NULL, 'staff', 1, '2025-11-08 16:45:23', '2025-11-08 16:45:24'),
(230, 35, NULL, 2, 'Hee', NULL, 'client', 1, '2025-11-10 15:12:57', '2025-11-10 16:36:39'),
(231, 35, NULL, 2, 'Geee', NULL, 'client', 1, '2025-11-10 15:12:59', '2025-11-10 16:36:39'),
(232, 35, NULL, 2, 'Ge', NULL, 'client', 1, '2025-11-10 15:13:00', '2025-11-10 16:36:39'),
(233, 35, NULL, 1, 'Mneu', NULL, 'client', 1, '2025-11-10 15:14:01', '2025-11-10 16:34:37'),
(234, 35, NULL, 1, 'Menu', NULL, 'client', 1, '2025-11-10 15:14:02', '2025-11-10 16:34:37'),
(235, 35, NULL, 1, 'Tesst', NULL, 'client', 1, '2025-11-10 15:14:04', '2025-11-10 16:34:37'),
(236, 35, NULL, 1, 'Test', NULL, 'client', 1, '2025-11-10 15:14:04', '2025-11-10 16:34:37'),
(237, 35, NULL, 1, 'TEst', NULL, 'client', 1, '2025-11-10 15:14:05', '2025-11-10 16:34:37'),
(238, 35, NULL, 1, 'Test', NULL, 'client', 1, '2025-11-10 15:14:06', '2025-11-10 16:34:37'),
(239, 35, NULL, 1, 'Checkkkk', NULL, 'client', 1, '2025-11-10 15:14:07', '2025-11-10 16:34:37'),
(240, 35, NULL, 1, 'Helllooo', NULL, 'client', 1, '2025-11-10 15:14:09', '2025-11-10 16:34:37'),
(241, 35, NULL, 1, 'test', NULL, 'client', 1, '2025-11-10 15:14:10', '2025-11-10 16:34:37'),
(242, 35, NULL, 2, 'Test', NULL, 'client', 1, '2025-11-10 15:15:17', '2025-11-10 16:36:39'),
(243, 35, NULL, 2, 'Test', NULL, 'client', 1, '2025-11-10 15:15:18', '2025-11-10 16:36:39'),
(244, 35, NULL, 2, 'Test', NULL, 'client', 1, '2025-11-10 15:15:19', '2025-11-10 16:36:39'),
(245, 35, NULL, 2, 'Test', NULL, 'client', 1, '2025-11-10 15:15:21', '2025-11-10 16:36:39'),
(246, 35, NULL, 1, 'Test', NULL, 'client', 1, '2025-11-10 15:15:24', '2025-11-10 16:34:37'),
(247, 35, NULL, 1, 'Test', NULL, 'client', 1, '2025-11-10 15:15:25', '2025-11-10 16:34:37'),
(248, 35, NULL, 1, 'Test', NULL, 'client', 1, '2025-11-10 15:22:44', '2025-11-10 16:34:37'),
(249, 35, NULL, 1, 'Test', NULL, 'client', 1, '2025-11-10 15:22:45', '2025-11-10 16:34:37'),
(250, 35, NULL, 2, 'Test', NULL, 'client', 1, '2025-11-10 15:22:48', '2025-11-10 16:36:39'),
(251, 35, NULL, 2, 'Test', NULL, 'client', 1, '2025-11-10 15:22:49', '2025-11-10 16:36:39'),
(252, 33, NULL, 1, NULL, 'chat_images/1762826240_69129800e6e4f.jpg', 'client', 1, '2025-11-11 09:57:20', '2025-11-12 14:43:30'),
(253, 35, NULL, 1, NULL, 'chat_images/1762920155_691406dba477e.png', 'client', 1, '2025-11-12 12:02:35', '2025-11-12 14:43:34'),
(254, 35, 9, 1, NULL, 'chat_images/1762929834_69142caa2be7a.png', 'staff', 1, '2025-11-12 14:43:54', '2025-11-12 14:43:54');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"14a72a11-6f36-4652-9b2b-1ca946555880\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760884681,\"delay\":null}', 0, NULL, 1760884681, 1760884681),
(2, 'default', '{\"uuid\":\"38140461-75bb-42b3-a93a-b3dddd047cda\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760884681,\"delay\":null}', 0, NULL, 1760884681, 1760884681),
(3, 'default', '{\"uuid\":\"59bb7a08-303b-4437-9f2c-f4be6df8a97b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760884682,\"delay\":null}', 0, NULL, 1760884682, 1760884682),
(4, 'default', '{\"uuid\":\"0199d7b9-751c-4c7e-907a-bf2ceea3ed6b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760885095,\"delay\":null}', 0, NULL, 1760885095, 1760885095),
(5, 'default', '{\"uuid\":\"79cf6faa-5724-45e2-95f2-7640a8fc0628\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760885096,\"delay\":null}', 0, NULL, 1760885096, 1760885096),
(6, 'default', '{\"uuid\":\"f326e0f4-cabf-4830-b6a4-4c697e77a09f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760885096,\"delay\":null}', 0, NULL, 1760885096, 1760885096),
(7, 'default', '{\"uuid\":\"d4c47de2-51dc-4c98-ad94-ce45d84b7bbc\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760885097,\"delay\":null}', 0, NULL, 1760885097, 1760885097),
(8, 'default', '{\"uuid\":\"c23c6ed9-7295-4c74-82d5-005ed6c69643\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760885097,\"delay\":null}', 0, NULL, 1760885097, 1760885097),
(9, 'default', '{\"uuid\":\"7a3f4ec8-7d5e-44bb-9ac9-0f9450d7f483\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760885267,\"delay\":null}', 0, NULL, 1760885267, 1760885267),
(10, 'default', '{\"uuid\":\"e51f9a01-f0bc-4d06-acd0-725144fe84c7\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760885268,\"delay\":null}', 0, NULL, 1760885268, 1760885268),
(11, 'default', '{\"uuid\":\"70458b50-467a-4c0e-b611-39206b8152ec\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760885277,\"delay\":null}', 0, NULL, 1760885277, 1760885277),
(12, 'default', '{\"uuid\":\"1b0811b6-29d9-412d-8486-0c2708d51c53\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:12;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760885278,\"delay\":null}', 0, NULL, 1760885278, 1760885278),
(13, 'default', '{\"uuid\":\"eb5c7114-e14f-4233-a7ef-9073e4570140\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:13;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886046,\"delay\":null}', 0, NULL, 1760886046, 1760886046),
(14, 'default', '{\"uuid\":\"092958c0-856a-4d0e-871f-c5aff1b3bd3e\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886047,\"delay\":null}', 0, NULL, 1760886047, 1760886047),
(15, 'default', '{\"uuid\":\"f4b090cc-70fb-4c71-b946-4c6d0250e6a0\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:15;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886053,\"delay\":null}', 0, NULL, 1760886053, 1760886053),
(16, 'default', '{\"uuid\":\"dd2f7169-e098-455a-b4d0-d6fdae5d5fd3\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886054,\"delay\":null}', 0, NULL, 1760886054, 1760886054),
(17, 'default', '{\"uuid\":\"d44d0bd6-7a31-445b-b56a-b0bd93e0fad7\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:17;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886091,\"delay\":null}', 0, NULL, 1760886091, 1760886091),
(18, 'default', '{\"uuid\":\"7b91e474-37e7-486c-83e5-721e00cedd13\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886108,\"delay\":null}', 0, NULL, 1760886108, 1760886108),
(19, 'default', '{\"uuid\":\"3208ce35-a8a0-4926-8cb0-a154c6be3577\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:19;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886224,\"delay\":null}', 0, NULL, 1760886224, 1760886224),
(20, 'default', '{\"uuid\":\"e956fd35-9299-4893-8190-1f9745655c52\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:20;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886279,\"delay\":null}', 0, NULL, 1760886279, 1760886279),
(21, 'default', '{\"uuid\":\"0f0ae9dc-b688-4a6d-a193-7c89914943d3\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886294,\"delay\":null}', 0, NULL, 1760886294, 1760886294),
(22, 'default', '{\"uuid\":\"b1a9b442-309d-42f4-8d6e-8f2b128addeb\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886554,\"delay\":null}', 0, NULL, 1760886554, 1760886554),
(23, 'default', '{\"uuid\":\"1d726c3d-8c97-4d31-9599-90ce82d44179\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886554,\"delay\":null}', 0, NULL, 1760886554, 1760886554),
(24, 'default', '{\"uuid\":\"d3a50d78-be78-466e-b322-5a5a90b01822\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:24;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886563,\"delay\":null}', 0, NULL, 1760886563, 1760886563),
(25, 'default', '{\"uuid\":\"802e8c7b-e286-43c7-96a0-7c1cae04c416\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:25;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886563,\"delay\":null}', 0, NULL, 1760886563, 1760886563),
(26, 'default', '{\"uuid\":\"2e1ab3b1-7379-45c5-a969-6612a99d38ec\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:26;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886574,\"delay\":null}', 0, NULL, 1760886574, 1760886574),
(27, 'default', '{\"uuid\":\"dfd85a4e-ed56-4d22-ac1c-f78c729266dc\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760886779,\"delay\":null}', 0, NULL, 1760886779, 1760886779),
(28, 'default', '{\"uuid\":\"1370a28e-1601-43bc-8b85-984392bc3a1f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:28;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760887117,\"delay\":null}', 0, NULL, 1760887117, 1760887117),
(29, 'default', '{\"uuid\":\"bcf9c882-7e1e-4911-ac9a-c6d20933d764\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760887118,\"delay\":null}', 0, NULL, 1760887118, 1760887118),
(30, 'default', '{\"uuid\":\"9e1869b7-defd-4cf0-97d1-9850526161eb\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760887272,\"delay\":null}', 0, NULL, 1760887272, 1760887272),
(31, 'default', '{\"uuid\":\"39311dd3-47e9-48cb-b931-747164bb5754\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760887283,\"delay\":null}', 0, NULL, 1760887283, 1760887283),
(32, 'default', '{\"uuid\":\"66822f9c-0183-438e-a994-b12f9c3bd062\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760887312,\"delay\":null}', 0, NULL, 1760887312, 1760887312),
(33, 'default', '{\"uuid\":\"26b27a7c-2af4-4ded-8a9c-e078c3a45fbc\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:33;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760887321,\"delay\":null}', 0, NULL, 1760887321, 1760887321),
(34, 'default', '{\"uuid\":\"9bfafd8b-0f09-485e-a715-1b0df545b891\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:34;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760887337,\"delay\":null}', 0, NULL, 1760887337, 1760887337),
(35, 'default', '{\"uuid\":\"f9fe8df3-8a0e-4d84-a344-f8d47614e65f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:35;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760887355,\"delay\":null}', 0, NULL, 1760887355, 1760887355),
(36, 'default', '{\"uuid\":\"831d0773-f9f2-4f9b-8372-057d5d58a29a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:36;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1760887368,\"delay\":null}', 0, NULL, 1760887368, 1760887368),
(37, 'default', '{\"uuid\":\"73c43618-e7b9-4cda-8f59-d6736187b669\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:37;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761380401,\"delay\":null}', 0, NULL, 1761380401, 1761380401),
(38, 'default', '{\"uuid\":\"c89380c9-64a8-47fa-ab3c-6caac61dc31e\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:38;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761380450,\"delay\":null}', 0, NULL, 1761380450, 1761380450),
(39, 'default', '{\"uuid\":\"a4c463d6-89c8-47f4-a65c-73b4b0f00cea\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:39;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761825584,\"delay\":null}', 0, NULL, 1761825584, 1761825584);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(40, 'default', '{\"uuid\":\"00cc8dd8-b838-4699-b206-7ebea9f2113a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:40;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761825710,\"delay\":null}', 0, NULL, 1761825710, 1761825710),
(41, 'default', '{\"uuid\":\"5f94e08c-043e-4639-9b97-c1fed69c3a08\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:41;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761825753,\"delay\":null}', 0, NULL, 1761825753, 1761825753),
(42, 'default', '{\"uuid\":\"fdaddf57-be5c-45b0-af3f-3848ce78f5f5\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:42;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761825932,\"delay\":null}', 0, NULL, 1761825932, 1761825932),
(43, 'default', '{\"uuid\":\"a188d9c3-25d3-4d64-999a-c438f9c8e245\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:43;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761825956,\"delay\":null}', 0, NULL, 1761825956, 1761825956),
(44, 'default', '{\"uuid\":\"bdea4117-13c7-4f2f-9b7a-ad4f353ebf2c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:44;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761927968,\"delay\":null}', 0, NULL, 1761927968, 1761927968),
(45, 'default', '{\"uuid\":\"ab800ebf-3767-44e6-bb84-ffc9ec4aebd7\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:45;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761927984,\"delay\":null}', 0, NULL, 1761927984, 1761927984),
(46, 'default', '{\"uuid\":\"6f664067-f6ae-4b02-b5f8-b87867888240\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:46;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1761927996,\"delay\":null}', 0, NULL, 1761927996, 1761927996),
(47, 'default', '{\"uuid\":\"0c2c84aa-8c88-4a8b-b193-4014424f57a5\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:47;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762177304,\"delay\":null}', 0, NULL, 1762177304, 1762177304),
(48, 'default', '{\"uuid\":\"e1ec08e6-2675-4724-b7a6-b6de5f39a83d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:48;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762177337,\"delay\":null}', 0, NULL, 1762177337, 1762177337),
(49, 'default', '{\"uuid\":\"7652b93c-6ee0-4b45-b70a-b2af45e72a21\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:49;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762181254,\"delay\":null}', 0, NULL, 1762181254, 1762181254),
(50, 'default', '{\"uuid\":\"2b0f2fdc-9110-4441-acbf-b9b6e9c16e95\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:50;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230217,\"delay\":null}', 0, NULL, 1762230217, 1762230217),
(51, 'default', '{\"uuid\":\"c1c39cfe-72ed-419e-91c3-f2beeafe3c17\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:51;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230376,\"delay\":null}', 0, NULL, 1762230376, 1762230376),
(52, 'default', '{\"uuid\":\"0a2cc1d6-c197-4119-8426-0898ccddc79a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:52;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230377,\"delay\":null}', 0, NULL, 1762230377, 1762230377),
(53, 'default', '{\"uuid\":\"6a1eb4d1-8914-4143-b881-71142f041736\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:53;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230377,\"delay\":null}', 0, NULL, 1762230377, 1762230377),
(54, 'default', '{\"uuid\":\"50e2476b-56ba-48de-8424-469901bbab7c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:54;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230377,\"delay\":null}', 0, NULL, 1762230377, 1762230377),
(55, 'default', '{\"uuid\":\"4fbc0026-8ca8-4232-ba29-bc357978d2fd\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:55;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230435,\"delay\":null}', 0, NULL, 1762230435, 1762230435),
(56, 'default', '{\"uuid\":\"d678557b-454f-4479-9ac5-01204189fe79\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:56;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230513,\"delay\":null}', 0, NULL, 1762230513, 1762230513),
(57, 'default', '{\"uuid\":\"0b3124e7-38c4-4fff-b897-077bd32350fd\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:57;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230529,\"delay\":null}', 0, NULL, 1762230529, 1762230529),
(58, 'default', '{\"uuid\":\"1ead310d-fca5-4e44-a4cb-96ed1ec0dda0\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:58;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230535,\"delay\":null}', 0, NULL, 1762230535, 1762230535),
(59, 'default', '{\"uuid\":\"a5548e86-fee4-4e09-9eea-01cb2da19ffd\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:59;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230572,\"delay\":null}', 0, NULL, 1762230572, 1762230572),
(60, 'default', '{\"uuid\":\"8f1ff01a-b19e-4aa5-bb92-7bb2572329ae\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:60;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230577,\"delay\":null}', 0, NULL, 1762230577, 1762230577),
(61, 'default', '{\"uuid\":\"17b5ba0c-1916-46bd-b212-0deb87a0369c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:61;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230579,\"delay\":null}', 0, NULL, 1762230579, 1762230579),
(62, 'default', '{\"uuid\":\"eb5e828f-31a6-4837-9699-2ff75879522c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:62;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230602,\"delay\":null}', 0, NULL, 1762230602, 1762230602),
(63, 'default', '{\"uuid\":\"f085fe06-26e0-47d8-a96b-75d674eb47c6\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:63;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230616,\"delay\":null}', 0, NULL, 1762230616, 1762230616),
(64, 'default', '{\"uuid\":\"b4a42faa-c62c-4dfb-8d16-9e5978221a8d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:64;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230638,\"delay\":null}', 0, NULL, 1762230638, 1762230638),
(65, 'default', '{\"uuid\":\"37481b5e-07ae-4384-8479-a376f49e745a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:65;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230748,\"delay\":null}', 0, NULL, 1762230748, 1762230748),
(66, 'default', '{\"uuid\":\"f0747d68-b2c5-42e0-a60c-c55c61a8a41f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:66;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230754,\"delay\":null}', 0, NULL, 1762230754, 1762230754),
(67, 'default', '{\"uuid\":\"2d460517-557f-41f1-9d0d-c4635f34cce8\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:67;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230779,\"delay\":null}', 0, NULL, 1762230779, 1762230779),
(68, 'default', '{\"uuid\":\"12367edc-e2ee-460f-8a70-74f5b761ea3d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:68;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230789,\"delay\":null}', 0, NULL, 1762230789, 1762230789),
(69, 'default', '{\"uuid\":\"39416386-ef11-4b4b-9cba-615ee5f5e540\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:69;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230798,\"delay\":null}', 0, NULL, 1762230798, 1762230798),
(70, 'default', '{\"uuid\":\"a3c61fa1-9931-4595-9272-26dfed326472\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:70;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230805,\"delay\":null}', 0, NULL, 1762230805, 1762230805),
(71, 'default', '{\"uuid\":\"6de06e35-de01-43f6-8b31-d26b070ff308\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:71;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762230847,\"delay\":null}', 0, NULL, 1762230847, 1762230847),
(72, 'default', '{\"uuid\":\"a8914eeb-1f53-4959-8e89-ecb766dd217d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:72;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762231185,\"delay\":null}', 0, NULL, 1762231185, 1762231185),
(73, 'default', '{\"uuid\":\"f9dd7a3a-2223-4fc2-b74a-53f20648fbf1\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:73;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762231334,\"delay\":null}', 0, NULL, 1762231334, 1762231334),
(74, 'default', '{\"uuid\":\"7aabad98-2d62-4089-9e65-38f2e05497d7\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:74;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762231339,\"delay\":null}', 0, NULL, 1762231339, 1762231339),
(75, 'default', '{\"uuid\":\"61a02c65-3ca6-48db-8343-ab989aa19f90\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:75;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762243799,\"delay\":null}', 0, NULL, 1762243799, 1762243799),
(76, 'default', '{\"uuid\":\"15871011-f5fe-4232-a8b8-6dc70c5f4e81\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:76;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762243899,\"delay\":null}', 0, NULL, 1762243899, 1762243899),
(77, 'default', '{\"uuid\":\"4545c52b-d700-44c2-80a6-628cfe774779\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:77;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762246226,\"delay\":null}', 0, NULL, 1762246226, 1762246226),
(78, 'default', '{\"uuid\":\"78d64d3f-5c5f-4143-9ea3-e4c5a5b804da\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:78;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762247648,\"delay\":null}', 0, NULL, 1762247648, 1762247648);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(79, 'default', '{\"uuid\":\"34d75b25-a4de-4cbd-91fb-173a3fe421df\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:79;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762247781,\"delay\":null}', 0, NULL, 1762247781, 1762247781),
(80, 'default', '{\"uuid\":\"94eb8224-8db6-40e5-b2c2-32b9f3a995b4\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:80;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762247789,\"delay\":null}', 0, NULL, 1762247789, 1762247789),
(81, 'default', '{\"uuid\":\"1316610b-3676-4cf5-b3ba-4835ce8abb41\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:81;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762247803,\"delay\":null}', 0, NULL, 1762247803, 1762247803),
(82, 'default', '{\"uuid\":\"4b33a24b-3eb7-4e0e-b242-d73e70bd6266\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762247939,\"delay\":null}', 0, NULL, 1762247939, 1762247939),
(83, 'default', '{\"uuid\":\"160aba03-93b9-47f0-8383-7ff1c2388690\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:83;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762247946,\"delay\":null}', 0, NULL, 1762247946, 1762247946),
(84, 'default', '{\"uuid\":\"4acd3bf2-cd9f-49aa-a0a9-d0371b2f81dc\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:84;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762247968,\"delay\":null}', 0, NULL, 1762247968, 1762247968),
(85, 'default', '{\"uuid\":\"cd31558b-c236-4ffd-bda9-93960538da7c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:85;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248027,\"delay\":null}', 0, NULL, 1762248027, 1762248027),
(86, 'default', '{\"uuid\":\"23c1c936-d1b4-49c2-a453-685f93e2bd3e\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:86;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248034,\"delay\":null}', 0, NULL, 1762248034, 1762248034),
(87, 'default', '{\"uuid\":\"3a914832-45fa-4ff6-83c8-34f6c34c672c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:87;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248254,\"delay\":null}', 0, NULL, 1762248254, 1762248254),
(88, 'default', '{\"uuid\":\"b282c94e-4ac5-41b4-a74e-7d125dfeaae7\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:88;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248276,\"delay\":null}', 0, NULL, 1762248276, 1762248276),
(89, 'default', '{\"uuid\":\"5b956f9d-c88d-4eba-9270-f54ec860c49a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:89;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248291,\"delay\":null}', 0, NULL, 1762248291, 1762248291),
(90, 'default', '{\"uuid\":\"e832fbdf-c388-49d5-b23c-79cfa7be7a27\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:90;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248295,\"delay\":null}', 0, NULL, 1762248295, 1762248295),
(91, 'default', '{\"uuid\":\"31bb34ac-37a0-4116-954f-a0da3ad7682b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:91;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248304,\"delay\":null}', 0, NULL, 1762248304, 1762248304),
(92, 'default', '{\"uuid\":\"bd26c91d-31fc-431a-a205-9adbe7908594\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:92;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248312,\"delay\":null}', 0, NULL, 1762248312, 1762248312),
(93, 'default', '{\"uuid\":\"3d574e3e-3261-47b7-b1e2-c4ca00b7d092\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:93;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248318,\"delay\":null}', 0, NULL, 1762248318, 1762248318),
(94, 'default', '{\"uuid\":\"6d25ca85-a7db-4322-83ed-be4f0d09be99\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:94;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248322,\"delay\":null}', 0, NULL, 1762248322, 1762248322),
(95, 'default', '{\"uuid\":\"2a7d3da0-cbc1-4d19-a86b-d5d28393e0d3\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:95;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248330,\"delay\":null}', 0, NULL, 1762248330, 1762248330),
(96, 'default', '{\"uuid\":\"95f7bda4-7f5b-475a-a2e8-d914166646aa\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:96;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248462,\"delay\":null}', 0, NULL, 1762248462, 1762248462),
(97, 'default', '{\"uuid\":\"ee630837-36ac-46df-b239-1c68c37e9200\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:97;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248474,\"delay\":null}', 0, NULL, 1762248474, 1762248474),
(98, 'default', '{\"uuid\":\"3b1261d7-2550-41ac-b817-958cedc0430b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:98;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762248490,\"delay\":null}', 0, NULL, 1762248490, 1762248490),
(99, 'default', '{\"uuid\":\"1560f6e6-9e62-4583-bc69-3f676380c0eb\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:99;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762250492,\"delay\":null}', 0, NULL, 1762250492, 1762250492),
(100, 'default', '{\"uuid\":\"1b09c97b-2042-42a0-a311-53581991ee6c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:100;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762250549,\"delay\":null}', 0, NULL, 1762250549, 1762250549),
(101, 'default', '{\"uuid\":\"961560ed-9219-4d96-bad6-3972e5d40286\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:101;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762250779,\"delay\":null}', 0, NULL, 1762250779, 1762250779),
(102, 'default', '{\"uuid\":\"0f85e1df-24d2-4193-9d29-1b4d0a08f38d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:102;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762250874,\"delay\":null}', 0, NULL, 1762250874, 1762250874),
(103, 'default', '{\"uuid\":\"a8392d07-8428-4ccb-a32b-97d5c607721e\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:103;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762250881,\"delay\":null}', 0, NULL, 1762250881, 1762250881),
(104, 'default', '{\"uuid\":\"7c8713e1-a817-4dbf-bc0b-7f46d2df3b35\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:104;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762250917,\"delay\":null}', 0, NULL, 1762250917, 1762250917),
(105, 'default', '{\"uuid\":\"58d67eb3-55f2-4cc9-9204-c1fb74b631a9\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:105;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762250933,\"delay\":null}', 0, NULL, 1762250933, 1762250933),
(106, 'default', '{\"uuid\":\"b699a2ce-7fa1-47fb-83bf-9d7524ce6269\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:106;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762250940,\"delay\":null}', 0, NULL, 1762250940, 1762250940),
(107, 'default', '{\"uuid\":\"24fee54f-d617-4ddc-b038-bdad8d782f42\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:107;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762250954,\"delay\":null}', 0, NULL, 1762250954, 1762250954),
(108, 'default', '{\"uuid\":\"bcdf3653-0e74-4b8d-bbb7-c0b3cf5c5f81\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:108;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762250964,\"delay\":null}', 0, NULL, 1762250964, 1762250964),
(109, 'default', '{\"uuid\":\"3c85cf34-7004-4542-99ab-510e7a9e55be\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:109;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762251028,\"delay\":null}', 0, NULL, 1762251028, 1762251028),
(110, 'default', '{\"uuid\":\"51c3c8f4-03dd-4289-85af-62091cffb572\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:110;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762251129,\"delay\":null}', 0, NULL, 1762251129, 1762251129),
(111, 'default', '{\"uuid\":\"4b83b2ff-ff1d-46f6-addd-e9df184b6da7\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:111;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762251147,\"delay\":null}', 0, NULL, 1762251147, 1762251147),
(112, 'default', '{\"uuid\":\"a078209a-45d0-4ea4-a63c-a28c6f54d000\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:112;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762251189,\"delay\":null}', 0, NULL, 1762251189, 1762251189),
(113, 'default', '{\"uuid\":\"9347a4b6-eabf-4a3d-9dd5-95c3eef07623\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:113;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762251226,\"delay\":null}', 0, NULL, 1762251226, 1762251226),
(114, 'default', '{\"uuid\":\"fec9494b-458d-451e-a291-6a4fea08b02b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:114;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762251720,\"delay\":null}', 0, NULL, 1762251720, 1762251720),
(115, 'default', '{\"uuid\":\"6a1adecf-48cd-4183-9b8b-d4b3adaff087\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:115;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762251728,\"delay\":null}', 0, NULL, 1762251728, 1762251728),
(116, 'default', '{\"uuid\":\"00344785-253a-41a8-8276-1a3b03a05658\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:116;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762251750,\"delay\":null}', 0, NULL, 1762251750, 1762251750),
(117, 'default', '{\"uuid\":\"9505bb29-00e1-4f4e-9a94-10e19a465080\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:117;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762251777,\"delay\":null}', 0, NULL, 1762251777, 1762251777);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(118, 'default', '{\"uuid\":\"0968c964-23fa-4ce9-a580-e96761b50941\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:118;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762252117,\"delay\":null}', 0, NULL, 1762252117, 1762252117),
(119, 'default', '{\"uuid\":\"256c6485-bb02-4c9d-b395-a79d9a2d55a3\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:119;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762252125,\"delay\":null}', 0, NULL, 1762252125, 1762252125),
(120, 'default', '{\"uuid\":\"a040acad-51fd-4998-97e8-5b27d59d824e\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:120;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762252880,\"delay\":null}', 0, NULL, 1762252880, 1762252880),
(121, 'default', '{\"uuid\":\"81ff1877-51d5-4042-8049-b9048810fdc0\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:121;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762252893,\"delay\":null}', 0, NULL, 1762252893, 1762252893),
(122, 'default', '{\"uuid\":\"29940719-cbee-4c73-99db-df59416af2e0\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:122;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762352713,\"delay\":null}', 0, NULL, 1762352713, 1762352713),
(123, 'default', '{\"uuid\":\"125b8c14-e23f-4d9a-bbd5-c1fd206ddb28\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:123;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762352719,\"delay\":null}', 0, NULL, 1762352719, 1762352719),
(124, 'default', '{\"uuid\":\"e1c14bc9-5e22-4963-abbe-78ae8659a186\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:124;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762352778,\"delay\":null}', 0, NULL, 1762352778, 1762352778),
(125, 'default', '{\"uuid\":\"1b5a8d80-4765-47fc-a2e0-aaf9ef85f23c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:125;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762352825,\"delay\":null}', 0, NULL, 1762352825, 1762352825),
(126, 'default', '{\"uuid\":\"e47c6010-f5ce-4c1e-a9a8-bec4910b0618\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:126;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762353197,\"delay\":null}', 0, NULL, 1762353197, 1762353197),
(127, 'default', '{\"uuid\":\"9b30392f-9697-4098-9d00-be4b1314167a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:127;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762353203,\"delay\":null}', 0, NULL, 1762353203, 1762353203),
(128, 'default', '{\"uuid\":\"7ba1f546-709a-4281-9a35-ec25cb6069bf\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:128;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762353217,\"delay\":null}', 0, NULL, 1762353217, 1762353217),
(129, 'default', '{\"uuid\":\"44298e11-9dfc-4b99-b6a7-94c0908a07f6\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:129;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762353224,\"delay\":null}', 0, NULL, 1762353224, 1762353224),
(130, 'default', '{\"uuid\":\"75f21a4d-19cc-448f-a2e6-3c898bdf92b3\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:130;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762355422,\"delay\":null}', 0, NULL, 1762355422, 1762355422),
(131, 'default', '{\"uuid\":\"461e16cb-bda2-4e62-94dd-ac2229289b68\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:131;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762355649,\"delay\":null}', 0, NULL, 1762355649, 1762355649),
(132, 'default', '{\"uuid\":\"2c245267-a9bb-43b6-9b5d-1c8d43e4582d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:132;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762355750,\"delay\":null}', 0, NULL, 1762355750, 1762355750),
(133, 'default', '{\"uuid\":\"6bdca34b-3855-41a1-9ae0-3207a673b0f6\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:133;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762355764,\"delay\":null}', 0, NULL, 1762355764, 1762355764),
(134, 'default', '{\"uuid\":\"0f8ed4a8-9539-46fe-92b7-9190395e645d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:134;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762355934,\"delay\":null}', 0, NULL, 1762355934, 1762355934),
(135, 'default', '{\"uuid\":\"ff75eec7-972d-4207-9dfc-3ad5dff66d7b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:135;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762356209,\"delay\":null}', 0, NULL, 1762356209, 1762356209),
(136, 'default', '{\"uuid\":\"e4f514cc-6195-4516-a211-bf3b4a425263\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:136;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762356324,\"delay\":null}', 0, NULL, 1762356324, 1762356324),
(137, 'default', '{\"uuid\":\"02f9f2f9-a24f-441d-b890-cd4e7d3c65b6\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:137;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762356350,\"delay\":null}', 0, NULL, 1762356350, 1762356350),
(138, 'default', '{\"uuid\":\"f4ca789f-9318-40ad-90ec-113aa78957f9\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:138;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762357174,\"delay\":null}', 0, NULL, 1762357174, 1762357174),
(139, 'default', '{\"uuid\":\"4c34f651-aada-45b5-8b78-20951a5c0fbd\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:139;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762357188,\"delay\":null}', 0, NULL, 1762357188, 1762357188),
(140, 'default', '{\"uuid\":\"fb5075e0-b799-4ba6-bad2-c39388a01df2\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:140;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762358123,\"delay\":null}', 0, NULL, 1762358123, 1762358123),
(141, 'default', '{\"uuid\":\"ee3fa10e-ed1d-470d-a339-0ea5d59f92d8\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:141;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762358146,\"delay\":null}', 0, NULL, 1762358146, 1762358146),
(142, 'default', '{\"uuid\":\"7a375716-879e-485f-8b51-5d44b2651b23\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:142;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762358150,\"delay\":null}', 0, NULL, 1762358150, 1762358150),
(143, 'default', '{\"uuid\":\"d8ce9910-3394-4411-a502-aeaeda1e9ee8\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:143;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762358639,\"delay\":null}', 0, NULL, 1762358639, 1762358639),
(144, 'default', '{\"uuid\":\"14117a65-68da-411b-8cf9-bfd40d20cf00\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:144;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762358857,\"delay\":null}', 0, NULL, 1762358857, 1762358857),
(145, 'default', '{\"uuid\":\"170d8b5b-fb81-4e80-9de3-9abc45d05ec9\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:145;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762358886,\"delay\":null}', 0, NULL, 1762358886, 1762358886),
(146, 'default', '{\"uuid\":\"77bdb4b3-0e28-4c9a-aeae-b68289350c75\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:146;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762358894,\"delay\":null}', 0, NULL, 1762358894, 1762358894),
(147, 'default', '{\"uuid\":\"8cd519f3-ef30-4f62-993c-00dcc05a7542\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:147;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762359222,\"delay\":null}', 0, NULL, 1762359222, 1762359222),
(148, 'default', '{\"uuid\":\"aad9b0db-1a53-43fb-b0e7-e5348c9d62b5\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:148;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762359226,\"delay\":null}', 0, NULL, 1762359226, 1762359226),
(149, 'default', '{\"uuid\":\"41fa61e2-0d0f-4206-b7ff-5d2798448de6\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:149;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762359228,\"delay\":null}', 0, NULL, 1762359228, 1762359228),
(150, 'default', '{\"uuid\":\"e8f4898c-48f2-4508-9186-788652839a90\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:150;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762359619,\"delay\":null}', 0, NULL, 1762359619, 1762359619),
(151, 'default', '{\"uuid\":\"e3e9a4e6-c5b9-410d-9388-bec5f5676713\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:151;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762359741,\"delay\":null}', 0, NULL, 1762359741, 1762359741),
(152, 'default', '{\"uuid\":\"502359ab-b062-41cb-b156-b8af0443cee2\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:152;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762360135,\"delay\":null}', 0, NULL, 1762360135, 1762360135),
(153, 'default', '{\"uuid\":\"41741344-835a-4219-8f27-9725ff3a7163\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:153;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762360887,\"delay\":null}', 0, NULL, 1762360887, 1762360887),
(154, 'default', '{\"uuid\":\"d2cad8be-3b46-4489-b8c7-f84db1e0f8ef\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:154;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762360994,\"delay\":null}', 0, NULL, 1762360994, 1762360994),
(155, 'default', '{\"uuid\":\"41850d92-b9e6-4563-8593-c32cd410c2b8\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:155;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762361068,\"delay\":null}', 0, NULL, 1762361068, 1762361068),
(156, 'default', '{\"uuid\":\"7f847e26-2320-4ee1-bfaa-fcf3e9e0cf49\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:156;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762501822,\"delay\":null}', 0, NULL, 1762501822, 1762501822);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(157, 'default', '{\"uuid\":\"9e0e22c9-a793-4af3-b652-2a9dca7e4ee1\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:157;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762501824,\"delay\":null}', 0, NULL, 1762501824, 1762501824),
(158, 'default', '{\"uuid\":\"dd724597-c268-4906-8e34-3e4f451746d3\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:158;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762501839,\"delay\":null}', 0, NULL, 1762501839, 1762501839),
(159, 'default', '{\"uuid\":\"20b11cd7-d147-457f-b514-a02ae4f2a036\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:159;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762501861,\"delay\":null}', 0, NULL, 1762501861, 1762501861),
(160, 'default', '{\"uuid\":\"5478d9af-bcae-40b0-ab0a-611c55dcc82f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:160;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762501869,\"delay\":null}', 0, NULL, 1762501869, 1762501869),
(161, 'default', '{\"uuid\":\"540f5b73-8c48-4aae-9d07-cba0af8ef44d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:161;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762501939,\"delay\":null}', 0, NULL, 1762501939, 1762501939),
(162, 'default', '{\"uuid\":\"505d2e42-b14f-4806-9ca7-2387b396e8a8\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:162;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762501959,\"delay\":null}', 0, NULL, 1762501959, 1762501959),
(163, 'default', '{\"uuid\":\"2946d69a-8f01-4dae-9a62-24c563fc0880\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:163;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502011,\"delay\":null}', 0, NULL, 1762502011, 1762502011),
(164, 'default', '{\"uuid\":\"2e073156-89e3-4478-9406-b43efdd7b193\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:164;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502014,\"delay\":null}', 0, NULL, 1762502014, 1762502014),
(165, 'default', '{\"uuid\":\"3b37fd0e-ac82-4cf4-8063-b3a20700063b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:165;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502051,\"delay\":null}', 0, NULL, 1762502051, 1762502051),
(166, 'default', '{\"uuid\":\"0187f329-fdc2-4178-94c6-21eca770d5e4\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:166;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502060,\"delay\":null}', 0, NULL, 1762502060, 1762502060),
(167, 'default', '{\"uuid\":\"a80acd91-8c9f-43d2-a4a5-1819770abb3d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:167;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502078,\"delay\":null}', 0, NULL, 1762502078, 1762502078),
(168, 'default', '{\"uuid\":\"60c5388e-31eb-4e0c-a9eb-f85e04cafe41\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:168;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502090,\"delay\":null}', 0, NULL, 1762502090, 1762502090),
(169, 'default', '{\"uuid\":\"1c1e7a51-7bb2-4c75-89bb-dd6d8c2ed955\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:169;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502101,\"delay\":null}', 0, NULL, 1762502101, 1762502101),
(170, 'default', '{\"uuid\":\"8f63198d-bce2-4594-93ed-833f61ce1de0\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:170;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502126,\"delay\":null}', 0, NULL, 1762502126, 1762502126),
(171, 'default', '{\"uuid\":\"53f53dc2-c480-490b-aed7-721537344d76\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:171;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502160,\"delay\":null}', 0, NULL, 1762502160, 1762502160),
(172, 'default', '{\"uuid\":\"1a54232e-4062-4ca5-be76-9705b85cdc8b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:172;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502166,\"delay\":null}', 0, NULL, 1762502166, 1762502166),
(173, 'default', '{\"uuid\":\"e03d4424-86a6-44c8-85fd-1df79949aecb\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:173;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502183,\"delay\":null}', 0, NULL, 1762502183, 1762502183),
(174, 'default', '{\"uuid\":\"19abd5bf-e81c-42a7-a18c-76ed22e5c73d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:174;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502249,\"delay\":null}', 0, NULL, 1762502249, 1762502249),
(175, 'default', '{\"uuid\":\"6e323277-c041-4c7f-96bd-ee7f9e3de48c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:175;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502271,\"delay\":null}', 0, NULL, 1762502271, 1762502271),
(176, 'default', '{\"uuid\":\"b1ed36e5-0ef5-4ea1-b0d7-cbef9b3ba9a8\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:176;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502344,\"delay\":null}', 0, NULL, 1762502344, 1762502344),
(177, 'default', '{\"uuid\":\"f0bd5f9b-d959-49b5-8f5a-11c746528ff8\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:177;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502373,\"delay\":null}', 0, NULL, 1762502373, 1762502373),
(178, 'default', '{\"uuid\":\"44ae0107-a005-4b1c-a0e3-71900185965a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:178;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762502409,\"delay\":null}', 0, NULL, 1762502409, 1762502409),
(179, 'default', '{\"uuid\":\"a0bff40c-4000-4a74-9ad5-fbb631da17a4\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:179;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762511576,\"delay\":null}', 0, NULL, 1762511576, 1762511576),
(180, 'default', '{\"uuid\":\"89ea460f-fdf8-4ade-8582-1fefa7e920ab\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:180;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762511587,\"delay\":null}', 0, NULL, 1762511587, 1762511587),
(181, 'default', '{\"uuid\":\"0ad93888-48e0-4c5e-a6df-cd15686184e9\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:181;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762511607,\"delay\":null}', 0, NULL, 1762511607, 1762511607),
(182, 'default', '{\"uuid\":\"82c52e90-5bea-480e-95c7-7ae34cef9f6c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:182;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762511653,\"delay\":null}', 0, NULL, 1762511653, 1762511653),
(183, 'default', '{\"uuid\":\"921739c6-bc2c-41c4-9141-c52f7f3f4ac0\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:183;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762511761,\"delay\":null}', 0, NULL, 1762511761, 1762511761),
(184, 'default', '{\"uuid\":\"0c558451-caab-4e47-bbfb-c4f92acb3d7a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:184;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762511827,\"delay\":null}', 0, NULL, 1762511827, 1762511827),
(185, 'default', '{\"uuid\":\"e56ad8bb-19dd-4ddf-870b-c918b07bedee\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:185;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762511850,\"delay\":null}', 0, NULL, 1762511850, 1762511850),
(186, 'default', '{\"uuid\":\"ef45d56c-0e7a-4d0f-8e8a-595e75b3c571\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:186;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762511877,\"delay\":null}', 0, NULL, 1762511877, 1762511877),
(187, 'default', '{\"uuid\":\"7a046de1-9ce7-4d22-bf42-c36c3fa82693\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:187;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762511897,\"delay\":null}', 0, NULL, 1762511897, 1762511897),
(188, 'default', '{\"uuid\":\"366e4825-67de-4ab6-998f-44e975c3621f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:188;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762511964,\"delay\":null}', 0, NULL, 1762511964, 1762511964),
(189, 'default', '{\"uuid\":\"fd298bdd-f379-4c12-ab58-a48a4a77a9d7\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:189;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762512005,\"delay\":null}', 0, NULL, 1762512005, 1762512005),
(190, 'default', '{\"uuid\":\"59e93222-1268-4508-9b7e-6e1204c4711d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:190;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762512008,\"delay\":null}', 0, NULL, 1762512008, 1762512008),
(191, 'default', '{\"uuid\":\"e79e8b7d-ee51-468a-9a65-f4fb6d22177d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:191;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762512020,\"delay\":null}', 0, NULL, 1762512020, 1762512020),
(192, 'default', '{\"uuid\":\"d73edf1b-3fc6-4691-b56a-ee534ccf8975\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:192;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762512033,\"delay\":null}', 0, NULL, 1762512033, 1762512033),
(193, 'default', '{\"uuid\":\"e8bd1d40-c7ce-4914-8f4f-b8e00ee62f5a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:193;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762512104,\"delay\":null}', 0, NULL, 1762512104, 1762512104),
(194, 'default', '{\"uuid\":\"1285fc7d-c851-4a03-b853-47323de67df5\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:194;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514724,\"delay\":null}', 0, NULL, 1762514724, 1762514724),
(195, 'default', '{\"uuid\":\"a956cb55-3af7-4f5d-8763-53b751419918\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:195;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514751,\"delay\":null}', 0, NULL, 1762514751, 1762514751);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(196, 'default', '{\"uuid\":\"1d0c3230-5bb6-479e-88cb-61b5cb9e2e6b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:196;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514774,\"delay\":null}', 0, NULL, 1762514774, 1762514774),
(197, 'default', '{\"uuid\":\"54476e32-0a1e-4854-a01d-1a942062effd\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:197;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514775,\"delay\":null}', 0, NULL, 1762514775, 1762514775),
(198, 'default', '{\"uuid\":\"0527d844-9a5e-440a-8566-e07ae1f9f54a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:198;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514817,\"delay\":null}', 0, NULL, 1762514817, 1762514817),
(199, 'default', '{\"uuid\":\"f5535ad8-f8e8-4e27-8ef8-d9069b0b031c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:199;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514822,\"delay\":null}', 0, NULL, 1762514822, 1762514822),
(200, 'default', '{\"uuid\":\"44e6b984-964b-42d5-9a84-d5f6521a7a18\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:200;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514827,\"delay\":null}', 0, NULL, 1762514827, 1762514827),
(201, 'default', '{\"uuid\":\"7f5ba826-45a3-4122-99d0-137f48d4d74f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:201;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514834,\"delay\":null}', 0, NULL, 1762514834, 1762514834),
(202, 'default', '{\"uuid\":\"1cbf8815-b8e0-423c-932d-c77e8c0882a0\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:202;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514886,\"delay\":null}', 0, NULL, 1762514886, 1762514886),
(203, 'default', '{\"uuid\":\"8d62d512-59dc-43f6-ac9e-49d38e5f3afc\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:203;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514903,\"delay\":null}', 0, NULL, 1762514903, 1762514903),
(204, 'default', '{\"uuid\":\"e3990578-8c70-4318-a0a1-ba444f60234e\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:204;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514910,\"delay\":null}', 0, NULL, 1762514910, 1762514910),
(205, 'default', '{\"uuid\":\"dcb1f36a-1d48-4572-adac-53f7a36062c5\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:205;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514918,\"delay\":null}', 0, NULL, 1762514918, 1762514918),
(206, 'default', '{\"uuid\":\"c99c0122-27c4-40c8-80c0-98a7054b013b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:206;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514923,\"delay\":null}', 0, NULL, 1762514923, 1762514923),
(207, 'default', '{\"uuid\":\"fed63d23-bf6d-4a87-8ede-b8d3b235071d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:207;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514951,\"delay\":null}', 0, NULL, 1762514951, 1762514951),
(208, 'default', '{\"uuid\":\"5e443840-e795-4bc9-a049-aaddeb5ed81f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:208;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514955,\"delay\":null}', 0, NULL, 1762514955, 1762514955),
(209, 'default', '{\"uuid\":\"e68b20cc-f781-4833-b042-4e83ff709792\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:209;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514992,\"delay\":null}', 0, NULL, 1762514992, 1762514992),
(210, 'default', '{\"uuid\":\"2de3a5a4-339e-4ed2-a82a-b1e99d3c479a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:210;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514993,\"delay\":null}', 0, NULL, 1762514993, 1762514993),
(211, 'default', '{\"uuid\":\"c693f2e8-bade-48dc-9908-9e53b9a03ffe\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:211;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514994,\"delay\":null}', 0, NULL, 1762514994, 1762514994),
(212, 'default', '{\"uuid\":\"869d50fb-1e83-45f9-8447-99925d85721f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:212;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514995,\"delay\":null}', 0, NULL, 1762514995, 1762514995),
(213, 'default', '{\"uuid\":\"0c81d380-4223-4334-8f06-a673c585a985\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:213;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514996,\"delay\":null}', 0, NULL, 1762514996, 1762514996),
(214, 'default', '{\"uuid\":\"cd761477-6ebd-42bd-aaa6-6daaf6573df7\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:214;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514996,\"delay\":null}', 0, NULL, 1762514996, 1762514996),
(215, 'default', '{\"uuid\":\"44209818-cb43-455c-a4a2-b67ec94a454b\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:215;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514997,\"delay\":null}', 0, NULL, 1762514997, 1762514997),
(216, 'default', '{\"uuid\":\"9f0ce113-0695-44cc-8c19-49a925f48033\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:216;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762514999,\"delay\":null}', 0, NULL, 1762514999, 1762514999),
(217, 'default', '{\"uuid\":\"b816eb13-67cb-44cb-9793-dfdaf63b780f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:217;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762515086,\"delay\":null}', 0, NULL, 1762515086, 1762515086),
(218, 'default', '{\"uuid\":\"95cca57f-7333-40e9-995d-93f0c221f759\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:218;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762518061,\"delay\":null}', 0, NULL, 1762518061, 1762518061),
(219, 'default', '{\"uuid\":\"adf4057a-4c0e-465c-ba30-6c7c2dd7c30a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:219;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762521400,\"delay\":null}', 0, NULL, 1762521400, 1762521400),
(220, 'default', '{\"uuid\":\"59e44ebd-e795-4f32-b3c7-06b17a8a5aef\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:220;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762530792,\"delay\":null}', 0, NULL, 1762530792, 1762530792),
(221, 'default', '{\"uuid\":\"56ceff14-3bd7-4a6e-8d00-e414661c3640\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:221;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762580735,\"delay\":null}', 0, NULL, 1762580735, 1762580735),
(222, 'default', '{\"uuid\":\"d833ab37-f34d-41f6-9c97-5979f3ef3fb9\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:222;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762581481,\"delay\":null}', 0, NULL, 1762581481, 1762581481),
(223, 'default', '{\"uuid\":\"fe777cbe-c41f-4bf9-bcc5-a264f204f1f6\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:223;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762581483,\"delay\":null}', 0, NULL, 1762581483, 1762581483),
(224, 'default', '{\"uuid\":\"85e56938-dda9-4935-acc9-a3f360f103ef\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:224;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762591465,\"delay\":null}', 0, NULL, 1762591465, 1762591465),
(225, 'default', '{\"uuid\":\"7e2d9683-a1c5-4d1b-8a63-523695ed140c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:225;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762591506,\"delay\":null}', 0, NULL, 1762591506, 1762591506),
(226, 'default', '{\"uuid\":\"b2a966bc-fc85-4d80-8df7-05a8dbc39d9c\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:226;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762591507,\"delay\":null}', 0, NULL, 1762591507, 1762591507),
(227, 'default', '{\"uuid\":\"001ba701-13b5-4a0e-af89-1c66099889c5\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:227;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762591508,\"delay\":null}', 0, NULL, 1762591508, 1762591508),
(228, 'default', '{\"uuid\":\"337c98e2-6803-47ea-9787-fd8f08cf397f\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:228;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762591509,\"delay\":null}', 0, NULL, 1762591509, 1762591509),
(229, 'default', '{\"uuid\":\"54d7d220-dce4-4395-a9cc-9a2efb95d559\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:229;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762591523,\"delay\":null}', 0, NULL, 1762591523, 1762591523),
(230, 'default', '{\"uuid\":\"13111e86-5444-44e3-a573-23be291ae545\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:230;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758777,\"delay\":null}', 0, NULL, 1762758777, 1762758777),
(231, 'default', '{\"uuid\":\"cd8af46f-0ce6-4283-8fd3-26853dba180a\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:231;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758779,\"delay\":null}', 0, NULL, 1762758779, 1762758779),
(232, 'default', '{\"uuid\":\"eb82d4ff-254d-45c7-a40f-276ed87caab5\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:232;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758780,\"delay\":null}', 0, NULL, 1762758780, 1762758780),
(233, 'default', '{\"uuid\":\"30dde5a6-76f7-4f2a-86c2-7cf592c2f00e\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:233;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758841,\"delay\":null}', 0, NULL, 1762758841, 1762758841),
(234, 'default', '{\"uuid\":\"222bfef1-2b3a-4592-af60-f171bd0ec9ca\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:234;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758842,\"delay\":null}', 0, NULL, 1762758842, 1762758842);
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(235, 'default', '{\"uuid\":\"69112b83-27b0-4dd6-b353-aae485d3cfb3\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:235;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758844,\"delay\":null}', 0, NULL, 1762758844, 1762758844),
(236, 'default', '{\"uuid\":\"51b90941-7f63-45b4-8617-3cac7ee59743\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:236;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758844,\"delay\":null}', 0, NULL, 1762758844, 1762758844),
(237, 'default', '{\"uuid\":\"f8cb3d66-d024-4800-9a9a-e8e52ad61d27\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:237;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758845,\"delay\":null}', 0, NULL, 1762758845, 1762758845),
(238, 'default', '{\"uuid\":\"2514e3f8-4d58-47bf-aaf4-09750da80acd\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:238;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758846,\"delay\":null}', 0, NULL, 1762758846, 1762758846),
(239, 'default', '{\"uuid\":\"8abb40e4-ed44-4823-9378-eb25ef15c994\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:239;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758847,\"delay\":null}', 0, NULL, 1762758847, 1762758847),
(240, 'default', '{\"uuid\":\"bd346454-b88b-42c3-ba13-9ced129e7a0d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:240;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758849,\"delay\":null}', 0, NULL, 1762758849, 1762758849),
(241, 'default', '{\"uuid\":\"990c7408-e599-4457-bf01-5a57b7b45540\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:241;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758850,\"delay\":null}', 0, NULL, 1762758850, 1762758850),
(242, 'default', '{\"uuid\":\"7f2c66e6-a785-4ca8-9179-99fef26fe8a3\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:242;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758917,\"delay\":null}', 0, NULL, 1762758917, 1762758917),
(243, 'default', '{\"uuid\":\"92565873-e7c5-420b-b95f-3514cb09c786\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:243;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758918,\"delay\":null}', 0, NULL, 1762758918, 1762758918),
(244, 'default', '{\"uuid\":\"a66f67df-f151-448a-8053-d37d6ead3a69\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:244;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758919,\"delay\":null}', 0, NULL, 1762758919, 1762758919),
(245, 'default', '{\"uuid\":\"10f27268-ba53-47bc-832b-522b641dc725\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:245;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758921,\"delay\":null}', 0, NULL, 1762758921, 1762758921),
(246, 'default', '{\"uuid\":\"ea2b4697-c389-42d6-9b7e-d3287caa0f50\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:246;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758924,\"delay\":null}', 0, NULL, 1762758924, 1762758924),
(247, 'default', '{\"uuid\":\"43b45b94-431b-4731-92a3-3facd2df87fa\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:247;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762758925,\"delay\":null}', 0, NULL, 1762758925, 1762758925),
(248, 'default', '{\"uuid\":\"5ce0948a-4a14-4164-9e66-47220fbe5846\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:248;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762759364,\"delay\":null}', 0, NULL, 1762759364, 1762759364),
(249, 'default', '{\"uuid\":\"6f4c954e-08e4-4b42-a47a-3ee9645d20b8\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:249;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762759365,\"delay\":null}', 0, NULL, 1762759365, 1762759365),
(250, 'default', '{\"uuid\":\"1b9a31c2-c828-4bff-bd29-3703fb724a9d\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:250;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762759368,\"delay\":null}', 0, NULL, 1762759368, 1762759368),
(251, 'default', '{\"uuid\":\"23bbf43a-b57a-42d3-873b-94dae107d887\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:251;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762759369,\"delay\":null}', 0, NULL, 1762759369, 1762759369),
(252, 'default', '{\"uuid\":\"c9bec84d-1858-4aae-b912-8f30108766f0\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:252;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762826240,\"delay\":null}', 0, NULL, 1762826240, 1762826240),
(253, 'default', '{\"uuid\":\"df129b5c-bb3d-46eb-98fb-3445e5b4d0cb\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:253;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762920155,\"delay\":null}', 0, NULL, 1762920155, 1762920155),
(254, 'default', '{\"uuid\":\"bb0652b9-75ee-4b95-9b3e-407060904b39\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:11:\\\"chatMessage\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ChatMessage\\\";s:2:\\\"id\\\";i:254;s:9:\\\"relations\\\";a:3:{i:0;s:4:\\\"user\\\";i:1;s:5:\\\"staff\\\";i:2;s:6:\\\"branch\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762929834,\"delay\":null}', 0, NULL, 1762929834, 1762929834);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_type` varchar(255) NOT NULL DEFAULT 'user',
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `forwarded_to_staff` tinyint(1) NOT NULL DEFAULT 0,
  `staff_notification_sent` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `sender_type`, `branch_id`, `message`, `image`, `is_read`, `forwarded_to_staff`, `staff_notification_sent`, `created_at`, `updated_at`) VALUES
(1, 1, 'user', NULL, 'Opening Hours', NULL, 0, 0, 0, '2025-09-19 02:36:07', '2025-09-19 02:36:07'),
(2, NULL, 'bot', NULL, 'Our studio is open today from 10am to 10pm.', NULL, 0, 0, 0, '2025-09-19 02:36:07', '2025-09-19 02:36:07'),
(3, 1, 'user', NULL, 'Booking Policy', NULL, 0, 0, 0, '2025-09-19 02:36:12', '2025-09-19 02:36:12'),
(4, NULL, 'bot', NULL, 'Please arrive 10 minutes early. Cancellations within 24 hours are non-refundable.', NULL, 0, 0, 0, '2025-09-19 02:36:12', '2025-09-19 02:36:12'),
(5, 1, 'user', NULL, 'Payment Methods', NULL, 0, 0, 0, '2025-09-19 02:36:15', '2025-09-19 02:36:15'),
(6, NULL, 'bot', NULL, 'We accept cash, card, and GCash.', NULL, 0, 0, 0, '2025-09-19 02:36:15', '2025-09-19 02:36:15'),
(7, 1, 'user', NULL, 'Services', NULL, 0, 0, 0, '2025-09-19 02:36:16', '2025-09-19 02:36:16'),
(8, NULL, 'bot', NULL, 'Check our Services page for available treatments and durations.', NULL, 0, 0, 0, '2025-09-19 02:36:16', '2025-09-19 02:36:16'),
(9, 1, 'user', NULL, 'Services', NULL, 0, 0, 0, '2025-09-19 02:36:29', '2025-09-19 02:36:29'),
(10, NULL, 'bot', NULL, 'Check our Services page for available treatments and durations.', NULL, 0, 0, 0, '2025-09-19 02:36:29', '2025-09-19 02:36:29'),
(11, 1, 'user', NULL, 'Payment Methods', NULL, 0, 0, 0, '2025-09-19 02:36:51', '2025-09-19 02:36:51'),
(12, NULL, 'bot', NULL, 'We accept cash, card, and GCash.', NULL, 0, 0, 0, '2025-09-19 02:36:51', '2025-09-19 02:36:51'),
(13, 1, 'user', NULL, 'Booking Policy', NULL, 0, 0, 0, '2025-09-19 02:36:54', '2025-09-19 02:36:54'),
(14, NULL, 'bot', NULL, 'Please arrive 10 minutes early. Cancellations within 24 hours are non-refundable.', NULL, 0, 0, 0, '2025-09-19 02:36:54', '2025-09-19 02:36:54'),
(15, 1, 'user', NULL, 'Services', NULL, 0, 0, 0, '2025-09-19 02:44:55', '2025-09-19 02:44:55'),
(16, NULL, 'bot', NULL, 'Check our Services page for available treatments and durations.', NULL, 0, 0, 0, '2025-09-19 02:44:55', '2025-09-19 02:44:55'),
(17, 1, 'user', NULL, 'Opening Hours', NULL, 0, 0, 0, '2025-09-19 02:46:50', '2025-09-19 02:46:50'),
(18, NULL, 'bot', NULL, 'Our studio is open today from 10am to 10pm.', NULL, 0, 0, 0, '2025-09-19 02:46:50', '2025-09-19 02:46:50'),
(19, 1, 'user', NULL, 'Opening Hours', NULL, 0, 0, 0, '2025-09-19 03:08:50', '2025-09-19 03:08:50'),
(20, NULL, 'bot', NULL, 'Our studio is open today from 10am to 10pm.', NULL, 0, 0, 0, '2025-09-19 03:08:50', '2025-09-19 03:08:50'),
(21, 1, 'user', NULL, 'Booking Policy', NULL, 0, 0, 0, '2025-09-19 03:08:52', '2025-09-19 03:08:52'),
(22, NULL, 'bot', NULL, 'Please arrive 10 minutes early. Cancellations within 24 hours are non-refundable.', NULL, 0, 0, 0, '2025-09-19 03:08:52', '2025-09-19 03:08:52'),
(23, 1, 'user', NULL, 'hello', NULL, 0, 0, 0, '2025-09-19 03:08:56', '2025-09-19 03:08:56'),
(24, 1, 'user', NULL, 'hllo', NULL, 0, 0, 0, '2025-09-19 04:33:40', '2025-09-19 04:33:40'),
(25, 1, 'user', NULL, 'asdasd', NULL, 0, 0, 0, '2025-09-19 04:35:25', '2025-09-19 04:35:25'),
(26, 1, 'user', NULL, 'Payment Methods', NULL, 0, 0, 0, '2025-09-19 04:36:51', '2025-09-19 04:36:51'),
(27, NULL, 'bot', NULL, 'We accept cash, card, and GCash.', NULL, 0, 0, 0, '2025-09-19 04:36:51', '2025-09-19 04:36:51'),
(28, 1, 'user', NULL, 'Payment Methods', NULL, 0, 0, 0, '2025-09-19 04:36:53', '2025-09-19 04:36:53'),
(29, NULL, 'bot', NULL, 'We accept cash, card, and GCash.', NULL, 0, 0, 0, '2025-09-19 04:36:53', '2025-09-19 04:36:53'),
(30, 1, 'user', NULL, 'Booking Policy', NULL, 0, 0, 0, '2025-09-19 04:36:54', '2025-09-19 04:36:54'),
(31, NULL, 'bot', NULL, 'Please arrive 10 minutes early. Cancellations within 24 hours are non-refundable.', NULL, 0, 0, 0, '2025-09-19 04:36:54', '2025-09-19 04:36:54'),
(32, 1, 'user', NULL, 'Services', NULL, 0, 0, 0, '2025-09-19 04:36:58', '2025-09-19 04:36:58'),
(33, NULL, 'bot', NULL, 'Check our Services page for available treatments and durations.', NULL, 0, 0, 0, '2025-09-19 04:36:58', '2025-09-19 04:36:58'),
(34, 1, 'user', NULL, 'helo', NULL, 0, 0, 0, '2025-09-19 04:37:04', '2025-09-19 04:37:04'),
(35, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 04:38:54', '2025-09-19 04:38:54'),
(36, 1, 'user', NULL, 'opening hourse', NULL, 0, 0, 0, '2025-09-19 04:39:02', '2025-09-19 04:39:02'),
(37, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-19 04:39:02', '2025-09-19 04:39:02'),
(38, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 04:39:07', '2025-09-19 04:39:07'),
(39, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 04:40:07', '2025-09-19 04:40:07'),
(40, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 04:59:08', '2025-09-19 04:59:08'),
(41, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 05:39:45', '2025-09-19 05:39:45'),
(42, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 06:09:06', '2025-09-19 06:09:06'),
(43, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 06:20:43', '2025-09-19 06:20:43'),
(44, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 06:38:03', '2025-09-19 06:38:03'),
(45, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 06:38:08', '2025-09-19 06:38:08'),
(46, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 06:38:14', '2025-09-19 06:38:14'),
(47, NULL, 'bot', NULL, 'To book, please visit: /client/booking', NULL, 0, 0, 0, '2025-09-19 06:38:20', '2025-09-19 06:38:20'),
(48, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 06:52:16', '2025-09-19 06:52:16'),
(49, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 06:52:31', '2025-09-19 06:52:31'),
(50, 1, 'user', NULL, 'help', NULL, 0, 0, 0, '2025-09-19 06:53:24', '2025-09-19 06:53:24'),
(51, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-19 06:53:30', '2025-09-19 06:53:30'),
(52, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-19 06:53:30', '2025-09-19 06:53:30'),
(53, 1, 'user', NULL, 'help', NULL, 0, 0, 0, '2025-09-19 06:53:34', '2025-09-19 06:53:34'),
(54, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 06:53:36', '2025-09-19 06:53:36'),
(55, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-19 06:53:44', '2025-09-19 06:53:44'),
(56, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 06:56:50', '2025-09-19 06:56:50'),
(57, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-19 06:59:39', '2025-09-19 06:59:39'),
(58, NULL, 'bot', NULL, 'To book, please visit: /client/booking', NULL, 0, 0, 0, '2025-09-19 06:59:44', '2025-09-19 06:59:44'),
(59, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 07:04:26', '2025-09-19 07:04:26'),
(60, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 07:07:35', '2025-09-19 07:07:35'),
(61, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 07:09:27', '2025-09-19 07:09:27'),
(62, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 07:10:59', '2025-09-19 07:10:59'),
(63, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 07:11:00', '2025-09-19 07:11:00'),
(64, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 07:11:00', '2025-09-19 07:11:00'),
(65, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 07:14:21', '2025-09-19 07:14:21'),
(66, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-19 07:14:23', '2025-09-19 07:14:23'),
(67, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 07:14:32', '2025-09-19 07:14:32'),
(68, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-19 07:14:36', '2025-09-19 07:14:36'),
(69, NULL, 'bot', NULL, 'To book, please visit: /client/booking', NULL, 0, 0, 0, '2025-09-19 07:14:38', '2025-09-19 07:14:38'),
(70, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 07:19:39', '2025-09-19 07:19:39'),
(71, NULL, 'bot', NULL, 'To book, please visit: /client/booking', NULL, 0, 0, 0, '2025-09-19 07:19:41', '2025-09-19 07:19:41'),
(72, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 07:19:46', '2025-09-19 07:19:46'),
(73, NULL, 'bot', NULL, 'To book, please visit: /client/booking', NULL, 0, 0, 0, '2025-09-19 07:48:40', '2025-09-19 07:48:40'),
(74, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 07:49:55', '2025-09-19 07:49:55'),
(75, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-19 07:57:00', '2025-09-19 07:57:00'),
(76, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-19 07:58:28', '2025-09-19 07:58:28'),
(77, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-19 08:02:59', '2025-09-19 08:02:59'),
(78, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 08:03:01', '2025-09-19 08:03:01'),
(79, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-19 08:09:21', '2025-09-19 08:09:21'),
(80, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-19 08:22:05', '2025-09-19 08:22:05'),
(81, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 08:22:06', '2025-09-19 08:22:06'),
(82, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 08:23:04', '2025-09-19 08:23:04'),
(83, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-19 13:54:10', '2025-09-19 13:54:10'),
(84, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-19 14:16:30', '2025-09-19 14:16:30'),
(85, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-19 15:03:56', '2025-09-19 15:03:56'),
(86, NULL, 'bot', NULL, 'To book, please visit: /client/booking', NULL, 0, 0, 0, '2025-09-19 15:03:58', '2025-09-19 15:03:58'),
(87, 1, 'user', NULL, 'opening hours', NULL, 0, 0, 0, '2025-09-23 07:32:21', '2025-09-23 07:32:21'),
(88, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-23 07:32:21', '2025-09-23 07:32:21'),
(89, 1, 'user', NULL, 'hours', NULL, 0, 0, 0, '2025-09-23 07:32:25', '2025-09-23 07:32:25'),
(90, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-23 07:32:25', '2025-09-23 07:32:25'),
(91, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 07:51:53', '2025-09-23 07:51:53'),
(92, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 07:52:13', '2025-09-23 07:52:13'),
(93, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 07:57:39', '2025-09-23 07:57:39'),
(94, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 07:57:41', '2025-09-23 07:57:41'),
(95, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 07:59:45', '2025-09-23 07:59:45'),
(96, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 07:59:47', '2025-09-23 07:59:47'),
(97, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 07:59:56', '2025-09-23 07:59:56'),
(98, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 07:59:58', '2025-09-23 07:59:58'),
(99, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 08:04:21', '2025-09-23 08:04:21'),
(100, 1, 'user', NULL, 'hours', NULL, 0, 0, 0, '2025-09-23 08:04:26', '2025-09-23 08:04:26'),
(101, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 08:04:31', '2025-09-23 08:04:31'),
(102, 1, 'user', NULL, 'opening horus', NULL, 0, 0, 0, '2025-09-23 08:04:37', '2025-09-23 08:04:37'),
(103, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 08:04:39', '2025-09-23 08:04:39'),
(104, 1, 'user', NULL, 'hours', NULL, 0, 0, 0, '2025-09-23 08:26:46', '2025-09-23 08:26:46'),
(105, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 08:26:48', '2025-09-23 08:26:48'),
(106, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 08:27:57', '2025-09-23 08:27:57'),
(107, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-23 08:28:27', '2025-09-23 08:28:27'),
(108, NULL, 'bot', NULL, 'To book, please visit: /client/booking', NULL, 0, 0, 0, '2025-09-23 08:28:28', '2025-09-23 08:28:28'),
(109, NULL, 'bot', NULL, 'To book, please visit: /client/booking', NULL, 0, 0, 0, '2025-09-23 08:28:34', '2025-09-23 08:28:34'),
(110, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-23 08:28:38', '2025-09-23 08:28:38'),
(111, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 08:28:40', '2025-09-23 08:28:40'),
(112, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 08:28:41', '2025-09-23 08:28:41'),
(113, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 08:29:28', '2025-09-23 08:29:28'),
(114, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 08:30:27', '2025-09-23 08:30:27'),
(115, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 08:30:31', '2025-09-23 08:30:31'),
(116, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 08:30:33', '2025-09-23 08:30:33'),
(117, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 08:35:55', '2025-09-23 08:35:55'),
(118, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:35:57', '2025-09-23 08:35:57'),
(119, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:35:57', '2025-09-23 08:35:57'),
(120, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 08:36:09', '2025-09-23 08:36:09'),
(121, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 08:36:10', '2025-09-23 08:36:10'),
(122, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 08:36:10', '2025-09-23 08:36:10'),
(123, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 08:36:15', '2025-09-23 08:36:15'),
(124, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 08:36:18', '2025-09-23 08:36:18'),
(125, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 08:36:18', '2025-09-23 08:36:18'),
(126, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 08:37:31', '2025-09-23 08:37:31'),
(127, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 08:37:33', '2025-09-23 08:37:33'),
(128, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:33', '2025-09-23 08:37:33'),
(129, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 08:37:34', '2025-09-23 08:37:34'),
(130, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:34', '2025-09-23 08:37:34'),
(131, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 08:37:34', '2025-09-23 08:37:34'),
(132, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:34', '2025-09-23 08:37:34'),
(133, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 08:37:35', '2025-09-23 08:37:35'),
(134, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:35', '2025-09-23 08:37:35'),
(135, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 08:37:36', '2025-09-23 08:37:36'),
(136, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:36', '2025-09-23 08:37:36'),
(137, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 08:37:36', '2025-09-23 08:37:36'),
(138, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:36', '2025-09-23 08:37:36'),
(139, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:37:37', '2025-09-23 08:37:37'),
(140, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:37:37', '2025-09-23 08:37:37'),
(141, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 08:37:49', '2025-09-23 08:37:49'),
(142, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 08:37:50', '2025-09-23 08:37:50'),
(143, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:50', '2025-09-23 08:37:50'),
(144, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 08:37:50', '2025-09-23 08:37:50'),
(145, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:50', '2025-09-23 08:37:50'),
(146, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 08:37:51', '2025-09-23 08:37:51'),
(147, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:51', '2025-09-23 08:37:51'),
(148, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:37:51', '2025-09-23 08:37:51'),
(149, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:37:51', '2025-09-23 08:37:51'),
(150, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:37:52', '2025-09-23 08:37:52'),
(151, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:37:52', '2025-09-23 08:37:52'),
(152, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:37:52', '2025-09-23 08:37:52'),
(153, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:37:52', '2025-09-23 08:37:52'),
(154, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:37:52', '2025-09-23 08:37:52'),
(155, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:37:52', '2025-09-23 08:37:52'),
(156, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 08:37:53', '2025-09-23 08:37:53'),
(157, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:53', '2025-09-23 08:37:53'),
(158, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 08:37:53', '2025-09-23 08:37:53'),
(159, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:53', '2025-09-23 08:37:53'),
(160, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 08:37:53', '2025-09-23 08:37:53'),
(161, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:53', '2025-09-23 08:37:53'),
(162, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 08:37:53', '2025-09-23 08:37:53'),
(163, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 08:37:53', '2025-09-23 08:37:53'),
(164, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:37:54', '2025-09-23 08:37:54'),
(165, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:37:54', '2025-09-23 08:37:54'),
(166, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:37:54', '2025-09-23 08:37:54'),
(167, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:37:54', '2025-09-23 08:37:54'),
(168, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:37:54', '2025-09-23 08:37:54'),
(169, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:37:54', '2025-09-23 08:37:54'),
(170, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:40:49', '2025-09-23 08:40:49'),
(171, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:40:49', '2025-09-23 08:40:49'),
(172, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:40:49', '2025-09-23 08:40:49'),
(173, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:40:49', '2025-09-23 08:40:49'),
(174, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 08:43:11', '2025-09-23 08:43:11'),
(175, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:43:12', '2025-09-23 08:43:12'),
(176, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:43:12', '2025-09-23 08:43:12'),
(177, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:43:12', '2025-09-23 08:43:12'),
(178, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:43:12', '2025-09-23 08:43:12'),
(179, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:43:13', '2025-09-23 08:43:13'),
(180, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:43:13', '2025-09-23 08:43:13'),
(181, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:43:13', '2025-09-23 08:43:13'),
(182, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:43:13', '2025-09-23 08:43:13'),
(183, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:43:13', '2025-09-23 08:43:13'),
(184, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:43:13', '2025-09-23 08:43:13'),
(185, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 08:43:14', '2025-09-23 08:43:14'),
(186, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 08:43:14', '2025-09-23 08:43:14'),
(187, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 08:43:14', '2025-09-23 08:43:14'),
(188, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 08:43:14', '2025-09-23 08:43:14'),
(189, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:45:58', '2025-09-23 08:45:58'),
(190, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:45:58', '2025-09-23 08:45:58'),
(191, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 08:45:59', '2025-09-23 08:45:59'),
(192, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 08:45:59', '2025-09-23 08:45:59'),
(193, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 08:46:09', '2025-09-23 08:46:09'),
(194, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 08:46:10', '2025-09-23 08:46:10'),
(195, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 08:46:10', '2025-09-23 08:46:10'),
(196, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 08:46:10', '2025-09-23 08:46:10'),
(197, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 08:46:10', '2025-09-23 08:46:10'),
(198, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 08:46:11', '2025-09-23 08:46:11'),
(199, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 08:46:11', '2025-09-23 08:46:11'),
(200, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 08:46:11', '2025-09-23 08:46:11'),
(201, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 08:46:11', '2025-09-23 08:46:11'),
(202, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 14:17:06', '2025-09-23 14:17:06'),
(203, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:17:08', '2025-09-23 14:17:08'),
(204, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:17:08', '2025-09-23 14:17:08'),
(205, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:17:08', '2025-09-23 14:17:08'),
(206, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:17:08', '2025-09-23 14:17:08'),
(207, 1, 'user', NULL, 'opening hours', NULL, 0, 0, 0, '2025-09-23 14:21:54', '2025-09-23 14:21:54'),
(208, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:21:56', '2025-09-23 14:21:56'),
(209, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:21:56', '2025-09-23 14:21:56'),
(210, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:21:56', '2025-09-23 14:21:56'),
(211, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:21:56', '2025-09-23 14:21:56'),
(212, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:21:56', '2025-09-23 14:21:56'),
(213, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:21:56', '2025-09-23 14:21:56'),
(214, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:21:57', '2025-09-23 14:21:57'),
(215, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:21:57', '2025-09-23 14:21:57'),
(216, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:21:57', '2025-09-23 14:21:57'),
(217, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:21:57', '2025-09-23 14:21:57'),
(218, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:21:58', '2025-09-23 14:21:58'),
(219, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:21:58', '2025-09-23 14:21:58'),
(220, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:21:58', '2025-09-23 14:21:58'),
(221, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:21:58', '2025-09-23 14:21:58'),
(222, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:21:59', '2025-09-23 14:21:59'),
(223, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:21:59', '2025-09-23 14:21:59'),
(224, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:21:59', '2025-09-23 14:21:59'),
(225, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:21:59', '2025-09-23 14:21:59'),
(226, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:21:59', '2025-09-23 14:21:59'),
(227, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:21:59', '2025-09-23 14:21:59'),
(228, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:22:00', '2025-09-23 14:22:00'),
(229, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:22:00', '2025-09-23 14:22:00'),
(230, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 14:22:00', '2025-09-23 14:22:00'),
(231, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 14:22:00', '2025-09-23 14:22:00'),
(232, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 14:22:00', '2025-09-23 14:22:00'),
(233, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 14:22:00', '2025-09-23 14:22:00'),
(234, 1, 'user', 5, 'select_branch_hours:5', NULL, 0, 0, 0, '2025-09-23 14:22:01', '2025-09-23 14:22:01'),
(235, NULL, 'bot', 5, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:22:01', '2025-09-23 14:22:01'),
(236, 1, 'user', 5, 'select_branch_hours:5', NULL, 0, 0, 0, '2025-09-23 14:22:01', '2025-09-23 14:22:01'),
(237, NULL, 'bot', 5, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:22:01', '2025-09-23 14:22:01'),
(238, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 14:23:38', '2025-09-23 14:23:38'),
(239, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:23:39', '2025-09-23 14:23:39'),
(240, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:23:39', '2025-09-23 14:23:39'),
(241, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:23:39', '2025-09-23 14:23:39'),
(242, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:23:39', '2025-09-23 14:23:39'),
(243, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:23:40', '2025-09-23 14:23:40'),
(244, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:23:40', '2025-09-23 14:23:40'),
(245, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:23:40', '2025-09-23 14:23:40'),
(246, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:23:40', '2025-09-23 14:23:40'),
(247, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:23:40', '2025-09-23 14:23:40'),
(248, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:23:40', '2025-09-23 14:23:40'),
(249, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:23:41', '2025-09-23 14:23:41'),
(250, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:23:41', '2025-09-23 14:23:41'),
(251, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:23:41', '2025-09-23 14:23:41'),
(252, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:23:41', '2025-09-23 14:23:41'),
(253, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:23:41', '2025-09-23 14:23:41'),
(254, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:23:41', '2025-09-23 14:23:41'),
(255, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:23:41', '2025-09-23 14:23:41'),
(256, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:23:41', '2025-09-23 14:23:41'),
(257, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:23:41', '2025-09-23 14:23:41'),
(258, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:23:41', '2025-09-23 14:23:41'),
(259, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:23:42', '2025-09-23 14:23:42'),
(260, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:23:42', '2025-09-23 14:23:42'),
(261, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 14:25:45', '2025-09-23 14:25:45'),
(262, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:25:45', '2025-09-23 14:25:45'),
(263, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:25:45', '2025-09-23 14:25:45'),
(264, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:25:46', '2025-09-23 14:25:46'),
(265, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:25:46', '2025-09-23 14:25:46'),
(266, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:25:46', '2025-09-23 14:25:46'),
(267, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:25:46', '2025-09-23 14:25:46'),
(268, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:25:46', '2025-09-23 14:25:46'),
(269, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:25:46', '2025-09-23 14:25:46'),
(270, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:27:38', '2025-09-23 14:27:38'),
(271, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:27:38', '2025-09-23 14:27:38'),
(272, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:27:38', '2025-09-23 14:27:38'),
(273, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:27:38', '2025-09-23 14:27:38'),
(274, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:27:39', '2025-09-23 14:27:39'),
(275, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:27:39', '2025-09-23 14:27:39'),
(276, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 14:27:47', '2025-09-23 14:27:47'),
(277, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:27:47', '2025-09-23 14:27:47'),
(278, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:27:47', '2025-09-23 14:27:47'),
(279, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:27:48', '2025-09-23 14:27:48'),
(280, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:27:48', '2025-09-23 14:27:48'),
(281, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:27:48', '2025-09-23 14:27:48'),
(282, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:27:48', '2025-09-23 14:27:48'),
(283, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:27:48', '2025-09-23 14:27:48'),
(284, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:27:48', '2025-09-23 14:27:48'),
(285, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:27:49', '2025-09-23 14:27:49'),
(286, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:27:49', '2025-09-23 14:27:49'),
(287, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 14:29:56', '2025-09-23 14:29:56'),
(288, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 14:29:56', '2025-09-23 14:29:56'),
(289, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 14:30:20', '2025-09-23 14:30:20'),
(290, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 14:30:20', '2025-09-23 14:30:20'),
(291, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:30:21', '2025-09-23 14:30:21'),
(292, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:30:21', '2025-09-23 14:30:21'),
(293, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:30:21', '2025-09-23 14:30:21'),
(294, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:30:21', '2025-09-23 14:30:21'),
(295, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:30:24', '2025-09-23 14:30:24'),
(296, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:30:24', '2025-09-23 14:30:24'),
(297, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:30:25', '2025-09-23 14:30:25'),
(298, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:30:25', '2025-09-23 14:30:25'),
(299, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:30:25', '2025-09-23 14:30:25'),
(300, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:30:25', '2025-09-23 14:30:25'),
(301, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:30:25', '2025-09-23 14:30:25'),
(302, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:30:25', '2025-09-23 14:30:25'),
(303, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:30:25', '2025-09-23 14:30:25'),
(304, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:30:25', '2025-09-23 14:30:25'),
(305, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 14:30:26', '2025-09-23 14:30:26'),
(306, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 14:30:26', '2025-09-23 14:30:26'),
(307, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:30:26', '2025-09-23 14:30:26'),
(308, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:30:26', '2025-09-23 14:30:26'),
(309, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:30:26', '2025-09-23 14:30:26'),
(310, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:30:26', '2025-09-23 14:30:26'),
(311, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:30:26', '2025-09-23 14:30:26'),
(312, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:30:26', '2025-09-23 14:30:26'),
(313, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:30:27', '2025-09-23 14:30:27'),
(314, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:30:27', '2025-09-23 14:30:27'),
(315, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:30:27', '2025-09-23 14:30:27'),
(316, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:30:27', '2025-09-23 14:30:27'),
(317, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:30:27', '2025-09-23 14:30:27'),
(318, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:30:27', '2025-09-23 14:30:27'),
(319, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:32:31', '2025-09-23 14:32:31'),
(320, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:32:31', '2025-09-23 14:32:31'),
(321, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:32:31', '2025-09-23 14:32:31'),
(322, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:32:31', '2025-09-23 14:32:31'),
(323, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:32:32', '2025-09-23 14:32:32'),
(324, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:32:32', '2025-09-23 14:32:32'),
(325, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:32:32', '2025-09-23 14:32:32'),
(326, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:32:32', '2025-09-23 14:32:32'),
(327, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 14:32:37', '2025-09-23 14:32:37'),
(328, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:32:38', '2025-09-23 14:32:38'),
(329, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:32:38', '2025-09-23 14:32:38'),
(330, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:32:39', '2025-09-23 14:32:39'),
(331, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:32:39', '2025-09-23 14:32:39'),
(332, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:32:39', '2025-09-23 14:32:39'),
(333, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:32:39', '2025-09-23 14:32:39'),
(334, 1, 'user', NULL, 'opening\\', NULL, 0, 0, 0, '2025-09-23 14:36:51', '2025-09-23 14:36:51'),
(335, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:36:53', '2025-09-23 14:36:53'),
(336, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:36:53', '2025-09-23 14:36:53'),
(337, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:36:53', '2025-09-23 14:36:53'),
(338, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:36:53', '2025-09-23 14:36:53'),
(339, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:36:53', '2025-09-23 14:36:53'),
(340, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:36:53', '2025-09-23 14:36:53'),
(341, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:36:54', '2025-09-23 14:36:54'),
(342, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:36:54', '2025-09-23 14:36:54'),
(343, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:36:54', '2025-09-23 14:36:54'),
(344, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:36:54', '2025-09-23 14:36:54'),
(345, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:36:54', '2025-09-23 14:36:54'),
(346, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:36:54', '2025-09-23 14:36:54'),
(347, 1, 'user', 2, 'select_branch_hours:2', NULL, 0, 0, 0, '2025-09-23 14:36:54', '2025-09-23 14:36:54'),
(348, NULL, 'bot', 2, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:36:54', '2025-09-23 14:36:54'),
(349, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 14:36:55', '2025-09-23 14:36:55'),
(350, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 14:36:55', '2025-09-23 14:36:55'),
(351, 1, 'user', 4, 'select_branch_hours:4', NULL, 0, 0, 0, '2025-09-23 14:36:55', '2025-09-23 14:36:55'),
(352, NULL, 'bot', 4, 'Mon - Sun10:00 am - 10:00 pm', NULL, 0, 0, 0, '2025-09-23 14:36:55', '2025-09-23 14:36:55'),
(353, 1, 'user', 5, 'select_branch_hours:5', NULL, 0, 0, 0, '2025-09-23 14:36:55', '2025-09-23 14:36:55'),
(354, NULL, 'bot', 5, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:36:55', '2025-09-23 14:36:55'),
(355, 1, 'user', 5, 'select_branch_hours:5', NULL, 0, 0, 0, '2025-09-23 14:36:55', '2025-09-23 14:36:55'),
(356, NULL, 'bot', 5, 'Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-23 14:36:55', '2025-09-23 14:36:55'),
(357, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:36:56', '2025-09-23 14:36:56'),
(358, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:36:56', '2025-09-23 14:36:56'),
(359, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 14:41:42', '2025-09-23 14:41:42'),
(360, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:41:43', '2025-09-23 14:41:43'),
(361, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:41:43', '2025-09-23 14:41:43'),
(362, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:41:43', '2025-09-23 14:41:43'),
(363, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:41:43', '2025-09-23 14:41:43'),
(364, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:41:44', '2025-09-23 14:41:44'),
(365, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:41:44', '2025-09-23 14:41:44'),
(366, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:41:44', '2025-09-23 14:41:44'),
(367, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:41:44', '2025-09-23 14:41:44'),
(368, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:41:44', '2025-09-23 14:41:44'),
(369, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:41:44', '2025-09-23 14:41:44'),
(370, 1, 'user', 1, 'select_branch_hours:1', NULL, 0, 0, 0, '2025-09-23 14:41:44', '2025-09-23 14:41:44'),
(371, NULL, 'bot', 1, 'MonTue - SunClosed10:00 am - 07:30 pm', NULL, 0, 0, 0, '2025-09-23 14:41:44', '2025-09-23 14:41:44'),
(372, 1, 'user', 3, 'select_branch_hours:3', NULL, 0, 0, 0, '2025-09-23 14:41:44', '2025-09-23 14:41:44'),
(373, NULL, 'bot', 3, 'Mon - SatSun9:00 am - 6:00 pmClosed', NULL, 0, 0, 0, '2025-09-23 14:41:44', '2025-09-23 14:41:44'),
(374, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 14:42:44', '2025-09-23 14:42:44'),
(375, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-23 14:42:44', '2025-09-23 14:42:44'),
(376, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 14:45:30', '2025-09-23 14:45:30'),
(377, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-23 14:45:30', '2025-09-23 14:45:30'),
(378, NULL, 'bot', NULL, 'To book, please visit: /client/booking', NULL, 0, 0, 0, '2025-09-23 14:45:34', '2025-09-23 14:45:34'),
(379, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 14:45:40', '2025-09-23 14:45:40'),
(380, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 14:50:52', '2025-09-23 14:50:52'),
(381, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:50:54', '2025-09-23 14:50:54'),
(382, 1, 'user', NULL, 'branch_hours_2', NULL, 0, 0, 0, '2025-09-23 14:50:58', '2025-09-23 14:50:58'),
(383, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 14:54:09', '2025-09-23 14:54:09'),
(384, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:54:10', '2025-09-23 14:54:10'),
(385, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:54:12', '2025-09-23 14:54:12'),
(386, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:55:35', '2025-09-23 14:55:35'),
(387, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:57:53', '2025-09-23 14:57:53'),
(388, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:57:54', '2025-09-23 14:57:54'),
(389, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:57:54', '2025-09-23 14:57:54'),
(390, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:58:00', '2025-09-23 14:58:00'),
(391, 1, 'user', NULL, 'branch_hours_4', NULL, 0, 0, 0, '2025-09-23 14:58:03', '2025-09-23 14:58:03'),
(392, 1, 'user', NULL, 'branch_hours_4', NULL, 0, 0, 0, '2025-09-23 14:58:04', '2025-09-23 14:58:04'),
(393, 1, 'user', NULL, 'branch_hours_2', NULL, 0, 0, 0, '2025-09-23 14:58:05', '2025-09-23 14:58:05'),
(394, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:58:06', '2025-09-23 14:58:06'),
(395, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:58:06', '2025-09-23 14:58:06'),
(396, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:58:07', '2025-09-23 14:58:07'),
(397, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 14:58:29', '2025-09-23 14:58:29'),
(398, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 14:58:30', '2025-09-23 14:58:30'),
(399, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 15:02:07', '2025-09-23 15:02:07'),
(400, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 15:06:04', '2025-09-23 15:06:04'),
(401, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 15:06:05', '2025-09-23 15:06:05'),
(402, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 15:06:06', '2025-09-23 15:06:06'),
(403, 1, 'user', NULL, 'branch_hours_2', NULL, 0, 0, 0, '2025-09-23 15:06:06', '2025-09-23 15:06:06'),
(404, 1, 'user', NULL, 'branch_hours_4', NULL, 0, 0, 0, '2025-09-23 15:06:08', '2025-09-23 15:06:08'),
(405, 1, 'user', NULL, 'branch_hours_5', NULL, 0, 0, 0, '2025-09-23 15:06:08', '2025-09-23 15:06:08'),
(406, 1, 'user', NULL, 'branch_hours_4', NULL, 0, 0, 0, '2025-09-23 15:06:09', '2025-09-23 15:06:09'),
(407, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 15:13:47', '2025-09-23 15:13:47'),
(408, NULL, 'bot', NULL, 'To book, please visit: /client/booking', NULL, 0, 0, 0, '2025-09-23 15:15:39', '2025-09-23 15:15:39'),
(409, 1, 'user', NULL, 'branch_hours_5', NULL, 0, 0, 0, '2025-09-23 15:15:42', '2025-09-23 15:15:42'),
(410, 1, 'user', NULL, 'opening hours', NULL, 0, 0, 0, '2025-09-23 15:15:48', '2025-09-23 15:15:48'),
(411, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 15:16:09', '2025-09-23 15:16:09'),
(412, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-23 15:16:13', '2025-09-23 15:16:13'),
(413, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 15:16:22', '2025-09-23 15:16:22'),
(414, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 15:16:24', '2025-09-23 15:16:24'),
(415, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 15:16:25', '2025-09-23 15:16:25'),
(416, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 15:44:52', '2025-09-23 15:44:52'),
(417, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 15:45:23', '2025-09-23 15:45:23'),
(418, 1, 'user', NULL, 'branch_hours_2', NULL, 0, 0, 0, '2025-09-23 15:45:36', '2025-09-23 15:45:36'),
(419, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 15:47:50', '2025-09-23 15:47:50'),
(420, 1, 'user', NULL, 'branch_hours_1', NULL, 0, 0, 0, '2025-09-23 15:47:51', '2025-09-23 15:47:51'),
(421, 1, 'user', NULL, 'branch_hours_3', NULL, 0, 0, 0, '2025-09-23 15:47:53', '2025-09-23 15:47:53'),
(422, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-23 15:52:56', '2025-09-23 15:52:56'),
(423, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-23 15:52:56', '2025-09-23 15:52:56'),
(424, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-25 13:46:59', '2025-09-25 13:46:59'),
(425, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-25 13:46:59', '2025-09-25 13:46:59'),
(426, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-25 14:00:06', '2025-09-25 14:00:06'),
(427, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-25 14:00:06', '2025-09-25 14:00:06'),
(428, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\" or \"book\".', NULL, 0, 0, 0, '2025-09-25 14:00:22', '2025-09-25 14:00:22'),
(429, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 14:04:53', '2025-09-25 14:04:53'),
(430, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 14:04:55', '2025-09-25 14:04:55'),
(431, 1, 'bot', 2, 'Great! I\'ve connected you to Ayala Center Cebu. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 14:04:57', '2025-09-25 14:04:57'),
(432, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 14:05:32', '2025-09-25 14:05:32'),
(433, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-25 14:05:34', '2025-09-25 14:05:34'),
(434, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-25 14:05:34', '2025-09-25 14:05:34'),
(435, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 14:05:36', '2025-09-25 14:05:36');
INSERT INTO `messages` (`id`, `user_id`, `sender_type`, `branch_id`, `message`, `image`, `is_read`, `forwarded_to_staff`, `staff_notification_sent`, `created_at`, `updated_at`) VALUES
(436, NULL, 'bot', NULL, 'To book, please visit: /client/booking', NULL, 0, 0, 0, '2025-09-25 14:05:38', '2025-09-25 14:05:38'),
(437, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 14:05:44', '2025-09-25 14:05:44'),
(438, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 14:05:46', '2025-09-25 14:05:46'),
(439, 1, 'bot', 2, 'Great! I\'ve connected you to Ayala Center Cebu. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 14:05:48', '2025-09-25 14:05:48'),
(440, NULL, 'bot', NULL, 'Sorry, I did not understand. Try: \"opening hours\", \"book\", or \"connect to staff\".', NULL, 0, 0, 0, '2025-09-25 14:09:53', '2025-09-25 14:09:53'),
(441, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 14:15:17', '2025-09-25 14:15:17'),
(442, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 14:15:19', '2025-09-25 14:15:19'),
(443, 1, 'user', 2, 'connect_branch:2', NULL, 0, 1, 0, '2025-09-25 14:15:20', '2025-09-25 14:15:20'),
(444, 1, 'bot', 2, 'I\'ve forwarded your message to Ayala Center Cebu staff. They will respond to you shortly. If you need immediate assistance, you can also visit us directly or call our branch.', NULL, 0, 0, 0, '2025-09-25 14:15:20', '2025-09-25 14:15:20'),
(445, 1, 'user', 2, 'hello', NULL, 0, 1, 0, '2025-09-25 14:15:42', '2025-09-25 14:15:42'),
(446, 1, 'bot', 2, 'I\'ve forwarded your message to Ayala Center Cebu staff. They will respond to you shortly. If you need immediate assistance, you can also visit us directly or call our branch.', NULL, 0, 0, 0, '2025-09-25 14:15:42', '2025-09-25 14:15:42'),
(447, 1, 'user', 2, 'hello', NULL, 0, 1, 0, '2025-09-25 14:15:46', '2025-09-25 14:15:46'),
(448, 1, 'bot', 2, 'I\'ve forwarded your message to Ayala Center Cebu staff. They will respond to you shortly. If you need immediate assistance, you can also visit us directly or call our branch.', NULL, 0, 0, 0, '2025-09-25 14:15:46', '2025-09-25 14:15:46'),
(449, 1, 'user', 2, 'hi', NULL, 0, 1, 0, '2025-09-25 14:17:36', '2025-09-25 14:17:36'),
(450, 1, 'bot', 2, 'I\'ve forwarded your message to Ayala Center Cebu staff. They will respond to you shortly. If you need immediate assistance, you can also visit us directly or call our branch.', NULL, 0, 0, 0, '2025-09-25 14:17:36', '2025-09-25 14:17:36'),
(451, 1, 'user', 2, 'zsad', NULL, 0, 1, 0, '2025-09-25 14:20:14', '2025-09-25 14:20:14'),
(452, 1, 'bot', 2, 'I\'ve forwarded your message to Ayala Center Cebu staff. They will respond to you shortly. If you need immediate assistance, you can also visit us directly or call our branch.', NULL, 0, 0, 0, '2025-09-25 14:20:14', '2025-09-25 14:20:14'),
(453, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 14:21:08', '2025-09-25 14:21:08'),
(454, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 14:21:10', '2025-09-25 14:21:10'),
(455, 1, 'user', 2, 'connect_branch:1', NULL, 0, 1, 0, '2025-09-25 14:21:12', '2025-09-25 14:21:12'),
(456, 1, 'bot', 2, 'I\'ve forwarded your message to Ayala Center Cebu staff. They will respond to you shortly. If you need immediate assistance, you can also visit us directly or call our branch.', NULL, 0, 0, 0, '2025-09-25 14:21:12', '2025-09-25 14:21:12'),
(457, 1, 'user', 2, 'hi', NULL, 0, 1, 0, '2025-09-25 14:21:15', '2025-09-25 14:21:15'),
(458, 1, 'bot', 2, 'I\'ve forwarded your message to Ayala Center Cebu staff. They will respond to you shortly. If you need immediate assistance, you can also visit us directly or call our branch.', NULL, 0, 0, 0, '2025-09-25 14:21:15', '2025-09-25 14:21:15'),
(459, 1, 'user', 2, 'hi', NULL, 0, 1, 0, '2025-09-25 14:23:41', '2025-09-25 14:23:41'),
(460, 1, 'bot', 2, 'I\'ve forwarded your message to Ayala Center Cebu staff. They will respond to you shortly. If you need immediate assistance, you can also visit us directly or call our branch.', NULL, 0, 0, 0, '2025-09-25 14:23:41', '2025-09-25 14:23:41'),
(461, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 14:27:22', '2025-09-25 14:27:22'),
(462, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-25 14:27:25', '2025-09-25 14:27:25'),
(463, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-25 14:27:25', '2025-09-25 14:27:25'),
(464, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 14:52:40', '2025-09-25 14:52:40'),
(465, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-09-25 14:52:42', '2025-09-25 14:52:42'),
(466, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-09-25 14:52:42', '2025-09-25 14:52:42'),
(467, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 14:52:45', '2025-09-25 14:52:45'),
(468, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 14:52:47', '2025-09-25 14:52:47'),
(469, 1, 'user', 2, 'connect_branch:1', NULL, 0, 1, 0, '2025-09-25 14:52:49', '2025-09-25 14:52:49'),
(470, 1, 'bot', 2, 'I\'ve forwarded your message to Ayala Center Cebu staff. They will respond to you shortly. If you need immediate assistance, you can also visit us directly or call our branch.', NULL, 0, 0, 0, '2025-09-25 14:52:49', '2025-09-25 14:52:49'),
(471, 1, 'user', NULL, 'MENU', NULL, 0, 0, 0, '2025-09-25 15:08:05', '2025-09-25 15:08:05'),
(472, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:08:07', '2025-09-25 15:08:07'),
(473, 1, 'user', 2, 'connect_branch:4', NULL, 0, 1, 0, '2025-09-25 15:08:07', '2025-09-25 15:08:07'),
(474, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:08:07', '2025-09-25 15:08:07'),
(475, 1, 'user', 2, 'hi', NULL, 0, 1, 0, '2025-09-25 15:08:10', '2025-09-25 15:08:10'),
(476, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:08:10', '2025-09-25 15:08:10'),
(477, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:08:24', '2025-09-25 15:08:24'),
(478, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:08:27', '2025-09-25 15:08:27'),
(479, 1, 'user', 2, 'connect_branch:1', NULL, 0, 1, 0, '2025-09-25 15:08:28', '2025-09-25 15:08:28'),
(480, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:08:28', '2025-09-25 15:08:28'),
(481, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:08:31', '2025-09-25 15:08:31'),
(482, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:08:36', '2025-09-25 15:08:36'),
(483, 1, 'user', 2, 'connect_branch:1', NULL, 0, 1, 0, '2025-09-25 15:08:37', '2025-09-25 15:08:37'),
(484, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:08:37', '2025-09-25 15:08:37'),
(485, 1, 'user', 2, 'hello', NULL, 0, 1, 0, '2025-09-25 15:08:45', '2025-09-25 15:08:45'),
(486, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:08:45', '2025-09-25 15:08:45'),
(487, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:27:09', '2025-09-25 15:27:09'),
(488, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:27:11', '2025-09-25 15:27:11'),
(489, 1, 'user', 2, 'connect_branch:1', NULL, 0, 1, 0, '2025-09-25 15:27:12', '2025-09-25 15:27:12'),
(490, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:27:12', '2025-09-25 15:27:12'),
(491, 1, 'user', 2, 'hello', NULL, 0, 1, 0, '2025-09-25 15:27:17', '2025-09-25 15:27:17'),
(492, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:27:17', '2025-09-25 15:27:17'),
(493, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:27:35', '2025-09-25 15:27:35'),
(494, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:27:37', '2025-09-25 15:27:37'),
(495, 1, 'user', 2, 'connect_branch:1', NULL, 0, 1, 0, '2025-09-25 15:27:39', '2025-09-25 15:27:39'),
(496, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:27:39', '2025-09-25 15:27:39'),
(497, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:27:43', '2025-09-25 15:27:43'),
(498, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:27:44', '2025-09-25 15:27:44'),
(499, 1, 'user', 2, 'connect_branch:5', NULL, 0, 1, 0, '2025-09-25 15:27:45', '2025-09-25 15:27:45'),
(500, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:27:45', '2025-09-25 15:27:45'),
(501, 1, 'user', 2, 'haha', NULL, 0, 1, 0, '2025-09-25 15:27:55', '2025-09-25 15:27:55'),
(502, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:27:55', '2025-09-25 15:27:55'),
(503, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:27:57', '2025-09-25 15:27:57'),
(504, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:27:59', '2025-09-25 15:27:59'),
(505, 1, 'user', 2, 'connect_branch:2', NULL, 0, 1, 0, '2025-09-25 15:28:00', '2025-09-25 15:28:00'),
(506, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:28:00', '2025-09-25 15:28:00'),
(507, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:28:04', '2025-09-25 15:28:04'),
(508, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:28:05', '2025-09-25 15:28:05'),
(509, 1, 'user', 2, 'connect_branch:3', NULL, 0, 1, 0, '2025-09-25 15:28:06', '2025-09-25 15:28:06'),
(510, 1, 'bot', 2, 'Message sent to Ayala Center Cebu staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:28:06', '2025-09-25 15:28:06'),
(511, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:31:27', '2025-09-25 15:31:27'),
(512, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:31:35', '2025-09-25 15:31:35'),
(513, 1, 'bot', 2, 'Great! I\'ve connected you to Ayala Center Cebu. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 15:31:37', '2025-09-25 15:31:37'),
(514, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:31:40', '2025-09-25 15:31:40'),
(515, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:31:43', '2025-09-25 15:31:43'),
(516, 1, 'bot', 1, 'Great! I\'ve connected you to Banilad Town Centre. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 15:31:44', '2025-09-25 15:31:44'),
(517, 1, 'user', 1, 'hello', NULL, 1, 1, 0, '2025-09-25 15:31:59', '2025-09-25 15:32:03'),
(518, 1, 'bot', 1, 'Message sent to Banilad Town Centre staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:31:59', '2025-09-25 15:31:59'),
(519, 1, 'user', NULL, 'menui', NULL, 0, 0, 0, '2025-09-25 15:34:07', '2025-09-25 15:34:07'),
(520, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:34:08', '2025-09-25 15:34:08'),
(521, 1, 'bot', 4, 'Great! I\'ve connected you to SM City Cebu. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 15:34:09', '2025-09-25 15:34:09'),
(522, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:34:12', '2025-09-25 15:34:12'),
(523, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:34:13', '2025-09-25 15:34:13'),
(524, 1, 'bot', 1, 'Great! I\'ve connected you to Banilad Town Centre. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 15:34:14', '2025-09-25 15:34:14'),
(525, 1, 'user', 1, 'hleolo', NULL, 1, 1, 0, '2025-09-25 15:34:17', '2025-09-25 15:34:22'),
(526, 1, 'staff', 1, 'hi', NULL, 1, 0, 0, '2025-09-25 15:44:46', '2025-09-25 15:44:46'),
(527, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:45:01', '2025-09-25 15:45:01'),
(528, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:45:02', '2025-09-25 15:45:02'),
(529, 1, 'bot', 1, 'Great! I\'ve connected you to Banilad Town Centre. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 15:45:03', '2025-09-25 15:45:03'),
(530, 1, 'user', 1, 'hello', NULL, 1, 1, 0, '2025-09-25 15:45:06', '2025-09-25 15:45:13'),
(531, 1, 'bot', 1, 'Message sent to Banilad Town Centre staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:45:06', '2025-09-25 15:45:06'),
(532, 1, 'staff', 1, 'hello', NULL, 1, 0, 0, '2025-09-25 15:45:16', '2025-09-25 15:45:16'),
(533, 1, 'staff', 1, 'hello', NULL, 1, 0, 0, '2025-09-25 15:50:08', '2025-09-25 15:50:08'),
(534, 1, 'staff', 1, 'heello', NULL, 1, 0, 0, '2025-09-25 15:54:26', '2025-09-25 15:54:26'),
(535, 1, 'staff', 1, 'hello', NULL, 1, 0, 0, '2025-09-25 15:59:15', '2025-09-25 15:59:15'),
(536, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 15:59:22', '2025-09-25 15:59:22'),
(537, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 15:59:24', '2025-09-25 15:59:24'),
(538, 1, 'bot', 1, 'Great! I\'ve connected you to Banilad Town Centre. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 15:59:25', '2025-09-25 15:59:25'),
(539, 1, 'user', 1, 'hiiiee', NULL, 1, 1, 0, '2025-09-25 15:59:28', '2025-09-25 15:59:37'),
(540, 1, 'bot', 1, 'Message sent to Banilad Town Centre staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 15:59:28', '2025-09-25 15:59:28'),
(541, 1, 'staff', 1, 'hello', NULL, 1, 0, 0, '2025-09-25 15:59:41', '2025-09-25 15:59:41'),
(542, 1, 'staff', 1, 'hello', NULL, 1, 0, 0, '2025-09-25 16:06:24', '2025-09-25 16:06:24'),
(543, 1, 'staff', 1, 'asdasd', NULL, 1, 0, 0, '2025-09-25 16:06:27', '2025-09-25 16:06:27'),
(544, 1, 'staff', 1, 'asd', NULL, 1, 0, 0, '2025-09-25 16:06:27', '2025-09-25 16:06:27'),
(545, 1, 'staff', 1, 'd', NULL, 1, 0, 0, '2025-09-25 16:06:28', '2025-09-25 16:06:28'),
(546, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 16:06:38', '2025-09-25 16:06:38'),
(547, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 16:06:40', '2025-09-25 16:06:40'),
(548, 1, 'bot', 1, 'Great! I\'ve connected you to Banilad Town Centre. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 16:06:41', '2025-09-25 16:06:41'),
(549, 1, 'staff', 1, 'hello', NULL, 1, 0, 0, '2025-09-25 16:06:50', '2025-09-25 16:06:50'),
(550, 1, 'staff', 1, 'hello', NULL, 1, 0, 0, '2025-09-25 16:11:17', '2025-09-25 16:11:17'),
(551, 1, 'user', 1, 'he', NULL, 1, 1, 0, '2025-09-25 16:12:05', '2025-09-25 16:12:15'),
(552, 1, 'bot', 1, 'Message sent to Banilad Town Centre staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 16:12:05', '2025-09-25 16:12:05'),
(553, 1, 'user', 1, 'asd', NULL, 1, 1, 0, '2025-09-25 16:12:06', '2025-09-25 16:12:15'),
(554, 1, 'user', 1, 'asd', NULL, 1, 1, 0, '2025-09-25 16:12:07', '2025-09-25 16:12:15'),
(555, 1, 'user', 1, 'asd', NULL, 1, 1, 0, '2025-09-25 16:12:08', '2025-09-25 16:12:15'),
(556, 1, 'user', 1, 'sad', NULL, 1, 1, 0, '2025-09-25 16:12:10', '2025-09-25 16:12:15'),
(557, 1, 'user', 1, 'sd', NULL, 1, 1, 0, '2025-09-25 16:12:10', '2025-09-25 16:12:15'),
(558, 1, 'user', 1, 'asd', NULL, 1, 1, 0, '2025-09-25 16:12:10', '2025-09-25 16:12:15'),
(559, 1, 'user', 1, 'connect', NULL, 1, 1, 0, '2025-09-25 16:15:33', '2025-09-25 16:15:46'),
(560, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-09-25 16:15:36', '2025-09-25 16:15:36'),
(561, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 16:15:38', '2025-09-25 16:15:38'),
(562, 1, 'bot', 1, 'Great! I\'ve connected you to Banilad Town Centre. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 16:15:39', '2025-09-25 16:15:39'),
(563, 1, 'user', 1, 'heasda', NULL, 1, 1, 0, '2025-09-25 16:15:43', '2025-09-25 16:15:46'),
(564, 1, 'staff', 1, 'hi', NULL, 1, 0, 0, '2025-09-25 16:15:49', '2025-09-25 16:15:49'),
(565, 1, 'staff', 1, 'asdadasd', NULL, 1, 0, 0, '2025-09-25 16:18:26', '2025-09-25 16:18:26'),
(566, 1, 'client', 1, 'menui', NULL, 0, 1, 0, '2025-09-25 16:22:44', '2025-09-25 16:22:44'),
(567, 1, 'client', 1, 'hi', NULL, 0, 1, 0, '2025-09-25 16:22:47', '2025-09-25 16:22:47'),
(568, 1, 'client', 1, 'asdasd', NULL, 0, 1, 0, '2025-09-25 16:32:00', '2025-09-25 16:32:00'),
(569, 1, 'client', 1, ']ad', NULL, 0, 1, 0, '2025-09-25 16:32:01', '2025-09-25 16:32:01'),
(570, 1, 'client', 1, 'd', NULL, 0, 1, 0, '2025-09-25 16:32:02', '2025-09-25 16:32:02'),
(571, 1, 'client', 1, 'asd', NULL, 0, 1, 0, '2025-09-25 16:32:02', '2025-09-25 16:32:02'),
(572, 1, 'user', NULL, 'branches', NULL, 0, 0, 0, '2025-09-25 16:43:08', '2025-09-25 16:43:08'),
(573, NULL, 'bot', 2, 'Opening hours for Ayala Center Cebu: Mon - Sun10:00 am - 09:00 pm', NULL, 0, 0, 0, '2025-09-25 16:43:10', '2025-09-25 16:43:10'),
(574, 1, 'user', 1, 'hello', NULL, 1, 1, 0, '2025-09-25 16:43:18', '2025-09-25 16:43:45'),
(575, 1, 'bot', 1, 'Message sent to Banilad Town Centre staff. They will respond to you shortly through this chat.', NULL, 0, 0, 0, '2025-09-25 16:43:18', '2025-09-25 16:43:18'),
(576, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 16:43:29', '2025-09-25 16:43:29'),
(577, 1, 'bot', 1, 'Great! I\'ve connected you to Banilad Town Centre. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 16:43:31', '2025-09-25 16:43:31'),
(578, 1, 'staff', 1, 'hii', NULL, 1, 0, 0, '2025-09-25 16:43:47', '2025-09-25 16:43:47'),
(579, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-09-25 16:44:01', '2025-09-25 16:44:01'),
(580, 1, 'bot', 1, 'Great! I\'ve connected you to Banilad Town Centre. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-09-25 16:44:04', '2025-09-25 16:44:04'),
(581, 1, 'user', 1, 'helll', NULL, 1, 1, 0, '2025-09-25 16:44:08', '2025-09-25 16:44:15'),
(582, 1, 'user', 1, 'asd', NULL, 1, 1, 0, '2025-09-25 16:44:09', '2025-09-25 16:44:15'),
(583, 1, 'user', 1, 'asd', NULL, 1, 1, 0, '2025-09-25 16:44:09', '2025-09-25 16:44:15'),
(584, 1, 'user', 1, 'asd', NULL, 1, 1, 0, '2025-09-25 16:44:10', '2025-09-25 16:44:15'),
(585, 1, 'staff', 1, 'hello', NULL, 1, 0, 0, '2025-09-25 16:44:19', '2025-09-25 16:44:19'),
(586, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-10-13 14:59:29', '2025-10-13 14:59:29'),
(587, 1, 'user', NULL, 'opening', NULL, 0, 0, 0, '2025-10-13 14:59:31', '2025-10-13 14:59:31'),
(588, NULL, 'bot', NULL, 'Our studio is open 10:00 AM to 10:00 PM daily.', NULL, 0, 0, 0, '2025-10-13 14:59:31', '2025-10-13 14:59:31'),
(589, 1, 'user', NULL, 'menu', NULL, 0, 0, 0, '2025-10-13 14:59:36', '2025-10-13 14:59:36'),
(590, 1, 'user', NULL, 'connect_staff', NULL, 0, 0, 0, '2025-10-13 14:59:40', '2025-10-13 14:59:40'),
(591, 1, 'bot', 1, 'Great! I\'ve connected you to Banilad Town Centre. Our staff will assist you shortly.', NULL, 0, 0, 0, '2025-10-13 14:59:43', '2025-10-13 14:59:43'),
(592, 1, 'staff', 1, 'asdasdasd\\', NULL, 1, 0, 0, '2025-10-13 14:59:52', '2025-10-13 14:59:52'),
(593, 1, 'staff', 1, 'asd', NULL, 1, 0, 0, '2025-10-13 14:59:53', '2025-10-13 14:59:53'),
(594, 1, 'staff', 1, 'sdasd', NULL, 1, 0, 0, '2025-10-13 14:59:54', '2025-10-13 14:59:54'),
(595, 1, 'staff', 1, 'asdada', NULL, 1, 0, 0, '2025-10-18 17:21:33', '2025-10-18 17:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_22_000004_create_branches_table', 2),
(5, '2025_08_25_000002_create_services_table', 2),
(6, '2025_08_22_000003_create_bookings_table', 3),
(7, '2025_08_22_000000_create_purchased_services_table', 4),
(8, '2025_08_23_000001_add_status_to_purchased_services_table', 5),
(9, '2025_08_23_000002_add_booking_id_to_purchased_services_table', 5),
(10, '2025_08_25_000003_add_treatment_details_to_services_table', 6),
(11, '2025_08_25_221413_add_image_to_services_table', 7),
(12, '2025_08_25_235000_add_role_to_users_table', 8),
(13, '2025_08_26_000005_create_transactions_table', 9),
(14, '2025_08_26_000001_create_promos_table', 10),
(15, '2025_08_26_000002_add_time_slot_and_slot_capacity_to_branches_table', 11),
(16, '2025_08_30_000012_add_branch_id_to_users_table', 12),
(17, '2025_09_01_000002_add_branch_id_to_promos_table', 13),
(18, '2025_09_01_000003_create_promo_service_table', 14),
(19, '2025_09_01_000004_add_category_to_promos_table', 14),
(20, '2025_09_01_000005_add_branch_id_to_services_table', 15),
(21, '2025_09_01_000006_create_branch_service_table', 16),
(22, '2025_09_01_000007_populate_branch_service_with_global_services', 17),
(23, '2025_09_01_000008_create_packages_table', 18),
(24, '2025_09_01_000009_add_active_to_branches_table', 19),
(25, '2025_09_01_000010_add_active_to_users_table', 20),
(26, '2025_09_01_000011_update_bookings_make_service_nullable_and_add_package_id', 21),
(27, '2025_09_02_000001_make_user_nullable_and_add_is_walkin_to_bookings', 22),
(28, '2025_09_02_000002_add_walkin_name_to_bookings', 23),
(29, '2025_09_02_000000_add_break_columns_to_branches_table', 24),
(30, '2025_09_03_000000_add_duration_to_services_table', 25),
(31, '2025_09_03_000001_add_duration_to_branch_service_table', 26),
(32, '2025_09_18_000001_add_profile_fields_to_users_table', 27),
(33, '2025_09_18_000100_create_messages_table', 28),
(34, '2025_09_23_000000_create_staff_table', 29),
(35, '2025_09_25_221211_add_forwarded_to_staff_to_messages_table', 30),
(36, '2025_09_25_230445_add_staff_notification_sent_to_messages_table', 31),
(37, '2025_09_26_005405_drop_staff_table', 32),
(38, '2025_10_08_140224_add_unique_constraint_to_branches_name', 33),
(39, '2025_09_26_204821_add_map_src_to_branches_table', 33),
(40, '2025_10_08_155503_add_contact_fields_to_bookings_table', 34),
(41, '2025_10_08_173548_add_active_column_to_services_table', 35),
(42, '2025_10_08_175946_make_user_id_nullable_in_purchased_services_table', 35),
(43, '2025_10_09_170155_add_contact_info_to_branches_table', 36),
(44, '2025_10_09_170212_add_contact_info_to_branches_table', 36),
(45, '2025_10_19_005506_create_chat_messages_table', 37),
(46, '2025_10_25_000001_add_closed_dates_to_branches_table', 38),
(47, '2025_10_25_190019_add_gcash_fields_to_branches_table', 39),
(48, '2025_10_25_213135_add_payment_fields_to_bookings_table', 40),
(49, '2025_10_29_191552_add_billing_info_to_bookings_table', 41),
(50, '2025_10_29_192720_drop_billing_info_from_bookings_table', 42),
(51, '2025_10_29_195621_add_saved_card_data_to_users_table', 43),
(52, '2025_10_29_221124_add_preferences_to_users_table', 44),
(53, '2025_10_30_000001_add_image_to_messages_table', 45),
(54, '2025_10_30_000002_make_message_nullable_in_messages_table', 46),
(55, '2025_11_01_001808_add_image_to_chat_messages_table', 47),
(56, '2025_11_01_172230_add_two_factor_columns_to_users_table', 48),
(57, '2025_11_12_155048_create_notifications_table', 49),
(58, '2025_11_12_155056_create_notifications_table', 50),
(59, '2025_11_12_183818_add_city_to_branches_table', 51);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('success','error','warning','info') NOT NULL DEFAULT 'info',
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `read`, `booking_id`, `data`, `created_at`, `updated_at`) VALUES
(1, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 08:16:41', '2025-11-12 13:03:48'),
(2, 2, 'Booking Cancelled', 'Your booking has been cancelled by staff.', 'warning', 0, 100, '{\"action\":\"cancelled\"}', '2025-11-12 08:20:18', '2025-11-12 08:20:18'),
(3, 2, 'Booking Completed', 'Your booking has been completed successfully.', 'success', 0, 100, '{\"action\":\"completed\"}', '2025-11-12 08:20:18', '2025-11-12 08:20:18'),
(4, 2, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 0, 100, '{\"action\":\"reminder\"}', '2025-11-12 08:20:18', '2025-11-12 08:20:18'),
(5, 2, 'Refund Processed', 'Your refund has been processed successfully.', 'info', 0, 100, '{\"action\":\"refund\",\"amount\":500}', '2025-11-12 08:20:18', '2025-11-12 08:20:18'),
(6, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 08:22:59', '2025-11-12 13:03:48'),
(7, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 08:23:10', '2025-11-12 13:03:48'),
(8, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 08:30:10', '2025-11-12 13:03:48'),
(9, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 08:35:08', '2025-11-12 13:03:48'),
(10, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 08:38:05', '2025-11-12 13:03:48'),
(11, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 08:45:07', '2025-11-12 13:03:48'),
(12, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 08:45:21', '2025-11-12 13:03:48'),
(13, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 08:51:58', '2025-11-12 13:03:48'),
(14, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 09:00:24', '2025-11-12 13:03:48'),
(15, 24, 'Booking Cancelled', 'Your booking has been cancelled by staff.', 'warning', 0, 783, NULL, '2025-11-12 09:58:52', '2025-11-12 09:58:52'),
(16, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 09:59:26', '2025-11-12 13:03:48'),
(17, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 09:59:26', '2025-11-12 13:03:48'),
(18, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 09:59:27', '2025-11-12 13:03:48'),
(19, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 10:05:25', '2025-11-12 13:03:48'),
(20, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 10:08:41', '2025-11-12 13:03:48'),
(21, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 10:09:30', '2025-11-12 13:03:48'),
(22, 33, 'Appointment Reminder', 'You have an upcoming appointment. Please check your email for details.', 'info', 1, 782, NULL, '2025-11-12 10:12:56', '2025-11-12 13:03:48'),
(23, 33, 'Booking Confirmed', 'Your appointment has been successfully booked! A confirmation email has been sent.', 'success', 1, 784, NULL, '2025-11-12 10:15:55', '2025-11-12 13:03:48'),
(24, 33, 'Booking Completed', 'Your booking has been completed successfully.', 'success', 1, 782, NULL, '2025-11-12 10:18:58', '2025-11-12 13:03:48'),
(25, 33, 'Refund Processed', 'Your refund has been processed successfully.', 'info', 1, 782, NULL, '2025-11-12 10:20:25', '2025-11-12 13:03:48'),
(26, 33, 'Booking Cancelled', 'Your booking has been cancelled by staff.', 'warning', 1, 784, NULL, '2025-11-12 10:20:55', '2025-11-12 13:03:48'),
(27, 33, 'Booking Confirmed', 'Your appointment has been successfully booked! A confirmation email has been sent.', 'success', 1, 785, NULL, '2025-11-12 10:34:29', '2025-11-12 13:03:48'),
(28, 33, 'Booking Rescheduled', 'Your booking has been rescheduled to Dec 03, 2025 at 18:00 - 19:00', 'info', 1, 785, NULL, '2025-11-12 10:36:14', '2025-11-12 13:03:48'),
(29, 33, 'Booking Cancelled', 'Your booking for Dec 03, 2025 has been cancelled.', 'warning', 1, 785, NULL, '2025-11-12 10:36:28', '2025-11-12 13:03:48'),
(30, 33, 'Booking Confirmed', 'Your appointment has been successfully booked! A confirmation email has been sent.', 'success', 1, 786, NULL, '2025-11-12 13:02:11', '2025-11-12 13:03:48');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `description`, `price`, `branch_id`, `active`, `created_at`, `updated_at`) VALUES
(8, 'Christmas Package', NULL, 5000.00, 1, 1, '2025-09-12 14:43:39', '2025-09-12 14:43:39'),
(9, 'halloween', NULL, 3500.00, 1, 1, '2025-10-08 09:51:15', '2025-10-08 09:51:15'),
(10, 'Skin Perfect', 'Combination of Diamond Peel with Complete Facial with additional Immuno Gold + Vitamin C', 5000.00, 56, 1, '2025-11-04 17:46:28', '2025-11-04 17:46:28');

-- --------------------------------------------------------

--
-- Table structure for table `package_service`
--

CREATE TABLE `package_service` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_service`
--

INSERT INTO `package_service` (`id`, `package_id`, `service_id`, `quantity`, `created_at`, `updated_at`) VALUES
(17, 8, 3, 1, '2025-09-12 14:43:39', '2025-09-12 14:43:39'),
(18, 8, 4, 1, '2025-09-12 14:43:39', '2025-09-12 14:43:39'),
(19, 9, 1, 1, '2025-10-08 09:51:15', '2025-10-08 09:51:15'),
(20, 9, 2, 1, '2025-10-08 09:51:15', '2025-10-08 09:51:15'),
(21, 10, 2, 1, '2025-11-04 17:46:28', '2025-11-04 17:46:28'),
(22, 10, 10, 1, '2025-11-04 17:46:28', '2025-11-04 17:46:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('jebelanio29@gmail.com', '$2y$12$ZSaYMgLZk54GtwLaZgKb8e2PxdDDV1cG95yL0yqa9BHoNp8uRFgcu', '2025-11-06 00:04:45'),
('leogenodiala@gmail.com', '$2y$12$RO4JtXZS053FZhRnL/OrkuFEuzqPhU0CZScCsUTpwujLHYsHoa3E.', '2025-11-06 00:00:26'),
('neelsen_16@yahoo.com', '$2y$12$0vNtJkjKnuNsjtwBoJH4GutU1/vLxiZJj0aKLgznEbiPFqEvxdiO6', '2025-11-07 21:45:53'),
('safotef398@fandoe.com', '$2y$12$nQGiu6BijK7pfSDmTNzimew91Isu3Rk5KytjGgCM4/W/xkvDMQLJG', '2025-11-03 21:47:08');

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `discount` decimal(5,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`id`, `branch_id`, `code`, `title`, `description`, `category`, `discount`, `start_date`, `end_date`, `active`, `created_at`, `updated_at`) VALUES
(3, 1, '1234', '123123', 'qwaedqasda', NULL, 12.00, '2025-09-01', '2025-11-03', 1, '2025-09-01 10:56:28', '2025-10-31 17:05:22'),
(5, 1, '1231412', 'asdadadaw', 'adasda', 'Facial Services', 10.00, '2025-09-02', '2025-09-30', 1, '2025-09-01 12:47:12', '2025-09-02 14:39:02'),
(6, 1, '52312312', 'GVSDFAF', NULL, 'Immuno Boosters', 20.00, '2025-09-02', '2025-09-10', 1, '2025-09-02 15:15:18', '2025-09-02 15:15:18'),
(7, 1, 'asdasd', 'chrsitmas', NULL, 'Facial Services', 50.00, '2025-09-12', '2025-09-15', 1, '2025-09-12 14:48:32', '2025-09-12 14:48:32'),
(8, 1, '123123', 'halloween', NULL, NULL, 100.00, '2025-09-12', '2025-09-30', 1, '2025-09-12 15:00:55', '2025-09-12 15:00:55'),
(9, 2, 'legendslangnakakaalam', 'wew', 'one time off', 'Facial Services', 14.50, '2025-11-08', '2025-12-08', 1, '2025-11-08 16:56:49', '2025-11-08 16:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `promo_service`
--

CREATE TABLE `promo_service` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promo_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promo_service`
--

INSERT INTO `promo_service` (`id`, `promo_id`, `service_id`, `created_at`, `updated_at`) VALUES
(7, 5, 8, NULL, NULL),
(8, 9, 1, NULL, NULL),
(9, 9, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchased_services`
--

CREATE TABLE `purchased_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchased_services`
--

INSERT INTO `purchased_services` (`id`, `user_id`, `service_id`, `booking_id`, `price`, `description`, `status`, `created_at`, `updated_at`) VALUES
(109, NULL, 2, 707, 2000.00, '', 'active', '2025-10-08 10:01:40', '2025-10-08 10:01:40'),
(110, NULL, 2, 708, 2000.00, '', 'active', '2025-10-08 10:01:57', '2025-10-08 10:01:57'),
(111, NULL, 1, 709, 1200.00, '', 'active', '2025-10-08 10:03:11', '2025-10-08 10:03:11'),
(112, NULL, 1, 710, 1200.00, '', 'active', '2025-10-08 10:03:52', '2025-10-08 10:03:52'),
(115, NULL, 1, 713, 1200.00, '', 'active', '2025-10-08 10:21:36', '2025-10-08 10:21:36'),
(118, 22, 1, 716, 1200.00, '', 'cancelled', '2025-10-25 08:19:13', '2025-10-25 08:22:04'),
(119, 22, 1, 717, 1200.00, '', 'cancelled', '2025-10-25 08:21:55', '2025-10-25 08:22:09'),
(128, NULL, 1, 725, 1200.00, '', 'active', '2025-10-25 15:04:20', '2025-10-25 15:04:20'),
(138, 21, 14, 735, 2000.00, '', 'active', '2025-10-31 04:32:08', '2025-10-31 04:32:08'),
(141, NULL, 1, 738, 1200.00, '', 'active', '2025-11-01 03:53:37', '2025-11-01 03:53:37'),
(142, NULL, 3, 739, 2800.00, '', 'active', '2025-11-01 03:56:08', '2025-11-01 03:56:08'),
(143, NULL, 4, 739, 2000.00, '', 'active', '2025-11-01 03:56:08', '2025-11-01 03:56:08'),
(144, NULL, 1, 740, 1200.00, '', 'active', '2025-11-01 03:58:26', '2025-11-01 03:58:26'),
(152, 29, 14, 746, 2000.00, '', 'active', '2025-11-03 22:06:26', '2025-11-03 22:06:26'),
(153, 24, 1, 747, 1200.00, '', 'cancelled', '2025-11-04 16:08:38', '2025-11-04 16:09:27'),
(154, 24, 2, 747, 2000.00, '', 'cancelled', '2025-11-04 16:08:38', '2025-11-04 16:09:27'),
(161, 33, 11, 753, 6500.00, '', 'cancelled', '2025-11-06 18:44:43', '2025-11-07 20:27:50'),
(162, 8, 16, 754, 2500.00, '', 'active', '2025-11-07 19:54:56', '2025-11-07 19:54:56'),
(163, 35, 17, 755, 4000.00, '', 'cancelled', '2025-11-07 20:08:59', '2025-11-12 11:13:12'),
(165, 24, 9, 757, 5000.00, '', 'cancelled', '2025-11-07 22:45:54', '2025-11-07 22:46:34'),
(166, 40, 1, 758, 1200.00, '', 'cancelled', '2025-11-08 13:49:46', '2025-11-08 13:50:44'),
(167, 43, 47, 759, 2500.00, '', 'cancelled', '2025-11-08 16:26:01', '2025-11-08 17:16:15'),
(168, 43, 4, 760, 2000.00, '', 'cancelled', '2025-11-08 16:30:25', '2025-11-08 17:16:15'),
(169, 43, 15, 761, 2000.00, '', 'cancelled', '2025-11-08 16:30:59', '2025-11-08 17:16:15'),
(170, 43, 44, 762, 4500.00, '', 'refunded', '2025-11-08 16:31:19', '2025-11-08 17:05:25'),
(171, 43, 18, 763, 2500.00, '', 'cancelled', '2025-11-08 16:31:53', '2025-11-08 17:16:15'),
(172, 43, 5, 764, 4500.00, '', 'active', '2025-11-08 16:32:46', '2025-11-08 16:32:46'),
(173, 43, 12, 765, 3000.00, '', 'active', '2025-11-08 16:33:07', '2025-11-08 16:33:07'),
(174, 46, 1, 766, 1200.00, '', 'active', '2025-11-08 19:31:04', '2025-11-08 19:31:04'),
(175, 35, 10, 767, 1500.00, '', 'cancelled', '2025-11-10 13:54:06', '2025-11-12 11:13:14'),
(176, 35, 9, 768, 5000.00, '', 'cancelled', '2025-11-10 13:55:05', '2025-11-12 11:13:16'),
(177, 35, 2, 769, 2000.00, '', 'cancelled', '2025-11-10 13:55:25', '2025-11-12 11:13:17'),
(178, 35, 2, 770, 2000.00, '', 'cancelled', '2025-11-10 13:56:52', '2025-11-12 11:13:18'),
(179, 35, 21, 771, 7000.00, '', 'cancelled', '2025-11-10 13:57:35', '2025-11-12 11:13:20'),
(180, 35, 5, 772, 4500.00, '', 'active', '2025-11-10 13:59:21', '2025-11-10 13:59:21'),
(181, 35, 13, 773, 4500.00, '', 'cancelled', '2025-11-10 14:04:34', '2025-11-12 11:13:21'),
(182, 35, 2, 774, 2000.00, '', 'cancelled', '2025-11-10 14:06:17', '2025-11-12 11:13:22'),
(183, 35, 14, 775, 2000.00, '', 'cancelled', '2025-11-10 14:06:45', '2025-11-12 11:13:24'),
(184, 35, 7, 776, 3000.00, '', 'cancelled', '2025-11-10 14:07:03', '2025-11-12 11:13:25'),
(185, 35, 5, 777, 4500.00, '', 'cancelled', '2025-11-10 14:07:23', '2025-11-12 11:13:27'),
(186, 35, 7, 778, 3000.00, '', 'cancelled', '2025-11-10 14:07:51', '2025-11-12 11:13:28'),
(187, 33, 2, 779, 2000.00, '', 'active', '2025-11-10 17:32:07', '2025-11-10 17:32:07'),
(188, 48, 3, 780, 2800.00, '', 'cancelled', '2025-11-11 23:29:29', '2025-11-11 23:31:59'),
(189, 35, 3, 781, 2800.00, '', 'cancelled', '2025-11-12 11:11:57', '2025-11-12 11:13:29'),
(190, 33, 2, 782, 2000.00, '', 'refunded', '2025-11-12 14:48:01', '2025-11-12 10:20:26'),
(191, 24, 13, 783, 4500.00, '', 'active', '2025-11-12 14:48:09', '2025-11-12 14:48:09'),
(192, 33, 2, 784, 2000.00, '', 'active', '2025-11-12 10:15:52', '2025-11-12 10:15:52'),
(193, 33, 1, 785, 1200.00, '', 'cancelled', '2025-11-12 10:34:26', '2025-11-12 10:36:24'),
(194, 33, 8, 786, 2700.00, '', 'active', '2025-11-12 13:02:05', '2025-11-12 13:02:05');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `treatment_details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `branch_id`, `name`, `image`, `category`, `price`, `duration`, `description`, `treatment_details`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Skin911 Complete Facial', NULL, 'Facial Services', 1200.00, 1, NULL, NULL, NULL, '2025-09-01 12:48:03'),
(2, NULL, 'Diamond Peel with complete facial', NULL, 'Facial Services', 2000.00, 1, NULL, NULL, NULL, NULL),
(3, NULL, 'Hydrafacial', NULL, 'Facial Services', 2800.00, 1, NULL, NULL, NULL, NULL),
(4, NULL, 'Wart removal (face and neck)', NULL, 'Facial Services', 2000.00, 1, NULL, NULL, NULL, NULL),
(5, NULL, 'Microneedling', NULL, 'Facial Services', 4500.00, 1, NULL, NULL, NULL, NULL),
(6, NULL, 'Skin Rejuvenation Laser + Facial', NULL, 'Facial Services', 3000.00, 1, NULL, NULL, NULL, NULL),
(7, NULL, 'Pigmentation Laser + Facial', NULL, 'Facial Services', 3000.00, 1, NULL, NULL, NULL, NULL),
(8, NULL, 'Acne laser + Acne Facial', NULL, 'Facial Services', 2700.00, 1, NULL, NULL, NULL, NULL),
(9, NULL, 'HIFU Ultralift', NULL, 'Facial Services', 5000.00, 1, NULL, NULL, NULL, NULL),
(10, NULL, 'Immuno gold + Vitamin C', NULL, 'Immuno Boosters', 1500.00, 1, NULL, NULL, NULL, NULL),
(11, NULL, 'Elea White Drip', NULL, 'Immuno Boosters', 6500.00, 1, NULL, NULL, NULL, NULL),
(12, NULL, 'Cindella Drip', NULL, 'Immuno Boosters', 3000.00, 1, NULL, NULL, NULL, NULL),
(13, NULL, 'Luminous White Drip', NULL, 'Immuno Boosters', 4500.00, 1, NULL, NULL, NULL, NULL),
(14, NULL, 'Collagen Injection', NULL, 'Immuno Boosters', 2000.00, 1, NULL, NULL, NULL, NULL),
(15, NULL, 'Placenta Injection', NULL, 'Immuno Boosters', 2000.00, 1, NULL, NULL, NULL, NULL),
(16, NULL, 'Radio frequency RF', NULL, 'Slimming Services', 2500.00, 1, NULL, NULL, NULL, NULL),
(17, NULL, 'Lipo Cavitation + RF', NULL, 'Slimming Services', 4000.00, 1, NULL, NULL, NULL, NULL),
(18, NULL, 'Lipo-cavitation', NULL, 'Slimming Services', 2500.00, 1, NULL, NULL, NULL, NULL),
(19, NULL, 'Diode Lipo Laser', NULL, 'Slimming Services', 3500.00, 1, NULL, NULL, NULL, NULL),
(20, NULL, 'TRIO slim', NULL, 'Slimming Services', 5000.00, 1, NULL, NULL, NULL, NULL),
(21, NULL, 'Underarms', NULL, 'Permanent Hair Removal', 7000.00, 1, NULL, NULL, NULL, NULL),
(22, NULL, 'Bikini', NULL, 'Permanent Hair Removal', 5000.00, 1, NULL, NULL, NULL, NULL),
(23, NULL, 'Full Brazilian', NULL, 'Permanent Hair Removal', 9000.00, 3, NULL, NULL, NULL, '2025-10-08 09:22:08'),
(24, NULL, 'Mustache', NULL, 'Permanent Hair Removal', 4000.00, 1, NULL, NULL, NULL, NULL),
(25, NULL, 'Beard', NULL, 'Permanent Hair Removal', 7500.00, 1, NULL, NULL, NULL, NULL),
(26, NULL, 'Mustache & Beard', NULL, 'Permanent Hair Removal', 8000.00, 1, NULL, NULL, NULL, NULL),
(27, NULL, 'Half Legs', NULL, 'Permanent Hair Removal', 7500.00, 1, NULL, NULL, NULL, NULL),
(28, NULL, 'Full Legs', NULL, 'Permanent Hair Removal', 9500.00, 1, NULL, NULL, NULL, NULL),
(29, NULL, 'Full Arms', NULL, 'Permanent Hair Removal', 8000.00, 1, NULL, NULL, NULL, NULL),
(30, NULL, 'Full Face', NULL, 'Permanent Hair Removal', 9000.00, 1, NULL, NULL, NULL, NULL),
(31, NULL, 'Chest/Back', NULL, 'Permanent Hair Removal', 10000.00, 1, NULL, NULL, NULL, NULL),
(32, NULL, 'Skin911 Complete Facial', NULL, 'Facial Services', 1100.00, 1, NULL, 'A deep cleansing facial that rejuvenates and hydrates your skin. Ideal for all skin types and helps restore a healthy glow.', NULL, NULL),
(33, NULL, 'Diamond Peel with complete facial', NULL, 'Facial Services', 2000.00, 1, NULL, 'Removes dead skin cells and improves skin texture. Perfect for reducing fine lines and brightening complexion.', NULL, NULL),
(34, NULL, 'Hydrafacial', NULL, 'Facial Services', 2800.00, 1, NULL, 'Hydrates and cleanses the skin using advanced technology. Leaves your skin feeling refreshed and deeply moisturized.', NULL, NULL),
(35, NULL, 'Wart removal (face and neck)', NULL, 'Facial Services', 2000.00, 1, NULL, 'Safe and effective removal of facial and neck warts. Quick procedure with minimal discomfort and downtime.', NULL, NULL),
(36, NULL, 'Microneedling', NULL, 'Facial Services', 4500.00, 1, NULL, 'Stimulates collagen production for smoother skin. Reduces scars, wrinkles, and improves overall skin texture.', NULL, NULL),
(37, NULL, 'Skin Rejuvenation Laser + Facial', NULL, 'Facial Services', 3000.00, 1, NULL, 'Laser treatment combined with facial for rejuvenation. Helps reduce pigmentation and signs of aging.', NULL, NULL),
(38, NULL, 'Pigmentation Laser + Facial', NULL, 'Facial Services', 3000.00, 1, NULL, 'Targets pigmentation issues for a more even skin tone. Effective for sun spots and melasma.', NULL, NULL),
(39, NULL, 'Acne laser + Acne Facial', NULL, 'Facial Services', 2700.00, 1, NULL, 'Laser and facial treatment for acne-prone skin. Minimizes breakouts and promotes clearer skin.', NULL, NULL),
(40, NULL, 'HIFU Ultralift', NULL, 'Facial Services', 5000.00, 1, NULL, 'Non-surgical lifting and tightening of the skin. Results in firmer, more youthful appearance.', NULL, NULL),
(41, NULL, 'Immuno gold + Vitamin C', NULL, 'Immuno Boosters', 1500.00, 1, NULL, 'Boosts immunity and skin health. Enhances skin radiance and overall wellness.', NULL, NULL),
(42, NULL, 'Elea White Drip', NULL, 'Immuno Boosters', 6500.00, 1, NULL, 'Brightens and whitens skin tone. Provides antioxidant protection and hydration.', NULL, NULL),
(43, NULL, 'Cindella Drip', NULL, 'Immuno Boosters', 3000.00, 1, NULL, 'Antioxidant drip for skin radiance. Revitalizes dull skin and supports detoxification.', NULL, NULL),
(44, NULL, 'Luminous White Drip', NULL, 'Immuno Boosters', 4500.00, 1, NULL, 'Intensive whitening and brightening treatment. Improves skin clarity and luminosity.', NULL, NULL),
(45, NULL, 'Collagen Injection', NULL, 'Immuno Boosters', 2000.00, 1, NULL, 'Improves skin elasticity and firmness. Helps reduce wrinkles and maintain youthful skin.', NULL, NULL),
(46, NULL, 'Placenta Injection', NULL, 'Immuno Boosters', 2000.00, 1, NULL, 'Promotes skin regeneration and healing. Supports cell renewal for healthier skin.', NULL, NULL),
(47, NULL, 'Radio frequency RF', NULL, 'Slimming Services', 2500.00, 1, NULL, 'Non-invasive slimming and contouring. Tightens skin and reduces stubborn fat.', NULL, NULL),
(48, NULL, 'Lipo Cavitation + RF', NULL, 'Slimming Services', 4000.00, 1, NULL, 'Fat reduction and skin tightening combo. Effective for body sculpting and cellulite reduction.', NULL, NULL),
(49, NULL, 'Lipo-cavitation', NULL, 'Slimming Services', 2500.00, 1, NULL, 'Ultrasound fat reduction treatment. Targets localized fat deposits for a slimmer look.', NULL, NULL),
(50, NULL, 'Diode Lipo Laser', NULL, 'Slimming Services', 3500.00, 1, NULL, 'Laser-based fat reduction. Safe and painless way to contour your body.', NULL, NULL),
(51, NULL, 'TRIO slim', NULL, 'Slimming Services', 5000.00, 1, NULL, 'Triple-action slimming treatment. Combines multiple technologies for maximum results.', NULL, NULL),
(52, NULL, 'Underarms', NULL, 'Permanent Hair Removal', 7000.00, 1, NULL, 'Permanent hair removal for underarms. Leaves skin smooth and hair-free for longer.', NULL, NULL),
(53, NULL, 'Bikini', NULL, 'Permanent Hair Removal', 5000.00, 1, NULL, 'Permanent hair removal for bikini area. Gentle and effective for sensitive skin.', NULL, NULL),
(54, NULL, 'Full Brazilian', NULL, 'Permanent Hair Removal', 9000.00, 1, NULL, 'Permanent hair removal for full Brazilian area. Achieve long-lasting smoothness and comfort.', NULL, NULL),
(55, NULL, 'Mustache', NULL, 'Permanent Hair Removal', 4000.00, 1, NULL, 'Permanent hair removal for mustache. Quick and precise treatment for facial hair.', NULL, NULL),
(56, NULL, 'Beard', NULL, 'Permanent Hair Removal', 7500.00, 1, NULL, 'Permanent hair removal for beard. Suitable for all beard types and skin tones.', NULL, NULL),
(57, NULL, 'Mustache & Beard', NULL, 'Permanent Hair Removal', 8000.00, 1, NULL, 'Permanent hair removal for mustache and beard. Comprehensive solution for facial hair removal.', NULL, NULL),
(58, NULL, 'Half Legs', NULL, 'Permanent Hair Removal', 7500.00, 1, NULL, 'Permanent hair removal for half legs. Enjoy smooth legs with minimal maintenance.', NULL, NULL),
(59, NULL, 'Full Legs', NULL, 'Permanent Hair Removal', 9500.00, 1, NULL, 'Permanent hair removal for full legs. Ideal for those seeking complete leg smoothness.', NULL, NULL),
(60, NULL, 'Full Arms', NULL, 'Permanent Hair Removal', 8000.00, 1, NULL, 'Permanent hair removal for full arms. Effective for both men and women.', NULL, NULL),
(61, NULL, 'Full Face', NULL, 'Permanent Hair Removal', 9000.00, 1, NULL, 'Permanent hair removal for full face. Achieve flawless, hair-free facial skin.', NULL, NULL),
(62, NULL, 'Chest/Back', NULL, 'Permanent Hair Removal', 10000.00, 1, NULL, 'Permanent hair removal for chest and back. Great for larger areas and long-lasting results.', NULL, NULL),
(63, NULL, 'Skin911 Complete Facial', 'img/services/skin1.jpg', 'Facial Services', 1100.00, 1, NULL, 'A deep cleansing facial that rejuvenates and hydrates your skin. Ideal for all skin types and helps restore a healthy glow.', NULL, NULL),
(64, NULL, 'Diamond Peel with complete facial', 'img/services/skin2.jpg', 'Facial Services', 2000.00, 1, NULL, 'Removes dead skin cells and improves skin texture. Perfect for reducing fine lines and brightening complexion.', NULL, NULL),
(65, NULL, 'Hydrafacial', 'img/services/skin3.jpg', 'Facial Services', 2800.00, 1, NULL, 'Hydrates and cleanses the skin using advanced technology. Leaves your skin feeling refreshed and deeply moisturized.', NULL, NULL),
(66, NULL, 'Wart removal (face and neck)', 'img/services/skin4.jpg', 'Facial Services', 2000.00, 1, NULL, 'Safe and effective removal of facial and neck warts. Quick procedure with minimal discomfort and downtime.', NULL, NULL),
(67, NULL, 'Microneedling', 'img/services/skin5.jpg', 'Facial Services', 4500.00, 1, NULL, 'Stimulates collagen production for smoother skin. Reduces scars, wrinkles, and improves overall skin texture.', NULL, NULL),
(68, NULL, 'Skin Rejuvenation Laser + Facial', 'img/services/skin1.jpg', 'Facial Services', 3000.00, 1, NULL, 'Laser treatment combined with facial for rejuvenation. Helps reduce pigmentation and signs of aging.', NULL, NULL),
(69, NULL, 'Pigmentation Laser + Facial', 'img/services/skin2.jpg', 'Facial Services', 3000.00, 1, NULL, 'Targets pigmentation issues for a more even skin tone. Effective for sun spots and melasma.', NULL, NULL),
(70, NULL, 'Acne laser + Acne Facial', 'img/services/skin3.jpg', 'Facial Services', 2700.00, 1, NULL, 'Laser and facial treatment for acne-prone skin. Minimizes breakouts and promotes clearer skin.', NULL, NULL),
(71, NULL, 'HIFU Ultralift', 'img/services/skin4.jpg', 'Facial Services', 5000.00, 1, NULL, 'Non-surgical lifting and tightening of the skin. Results in firmer, more youthful appearance.', NULL, NULL),
(72, NULL, 'Immuno gold + Vitamin C', 'img/services/skin5.jpg', 'Immuno Boosters', 1500.00, 1, NULL, 'Boosts immunity and skin health. Enhances skin radiance and overall wellness.', NULL, NULL),
(73, NULL, 'Elea White Drip', 'img/services/skin1.jpg', 'Immuno Boosters', 6500.00, 1, NULL, 'Brightens and whitens skin tone. Provides antioxidant protection and hydration.', NULL, NULL),
(74, NULL, 'Cindella Drip', 'img/services/skin2.jpg', 'Immuno Boosters', 3000.00, 1, NULL, 'Antioxidant drip for skin radiance. Revitalizes dull skin and supports detoxification.', NULL, NULL),
(75, NULL, 'Luminous White Drip', 'img/services/skin3.jpg', 'Immuno Boosters', 4500.00, 1, NULL, 'Intensive whitening and brightening treatment. Improves skin clarity and luminosity.', NULL, NULL),
(76, NULL, 'Collagen Injection', 'img/services/skin4.jpg', 'Immuno Boosters', 2000.00, 1, NULL, 'Improves skin elasticity and firmness. Helps reduce wrinkles and maintain youthful skin.', NULL, NULL),
(77, NULL, 'Placenta Injection', 'img/services/skin5.jpg', 'Immuno Boosters', 2000.00, 1, NULL, 'Promotes skin regeneration and healing. Supports cell renewal for healthier skin.', NULL, NULL),
(78, NULL, 'Radio frequency RF', 'img/services/skin1.jpg', 'Slimming Services', 2500.00, 1, NULL, 'Non-invasive slimming and contouring. Tightens skin and reduces stubborn fat.', NULL, NULL),
(79, NULL, 'Lipo Cavitation + RF', 'img/services/skin2.jpg', 'Slimming Services', 4000.00, 1, NULL, 'Fat reduction and skin tightening combo. Effective for body sculpting and cellulite reduction.', NULL, NULL),
(80, NULL, 'Lipo-cavitation', 'img/services/skin3.jpg', 'Slimming Services', 2500.00, 1, NULL, 'Ultrasound fat reduction treatment. Targets localized fat deposits for a slimmer look.', NULL, NULL),
(81, NULL, 'Diode Lipo Laser', 'img/services/skin4.jpg', 'Slimming Services', 3500.00, 1, NULL, 'Laser-based fat reduction. Safe and painless way to contour your body.', NULL, NULL),
(82, NULL, 'TRIO slim', 'img/services/skin5.jpg', 'Slimming Services', 5000.00, 1, NULL, 'Triple-action slimming treatment. Combines multiple technologies for maximum results.', NULL, NULL),
(83, NULL, 'Underarms', 'img/services/skin1.jpg', 'Permanent Hair Removal', 7000.00, 1, NULL, 'Permanent hair removal for underarms. Leaves skin smooth and hair-free for longer.', NULL, NULL),
(84, NULL, 'Bikini', 'img/services/skin2.jpg', 'Permanent Hair Removal', 5000.00, 1, NULL, 'Permanent hair removal for bikini area. Gentle and effective for sensitive skin.', NULL, NULL),
(85, NULL, 'Full Brazilian', 'img/services/skin3.jpg', 'Permanent Hair Removal', 9000.00, 1, NULL, 'Permanent hair removal for full Brazilian area. Achieve long-lasting smoothness and comfort.', NULL, NULL),
(86, NULL, 'Mustache', 'img/services/skin4.jpg', 'Permanent Hair Removal', 4000.00, 1, NULL, 'Permanent hair removal for mustache. Quick and precise treatment for facial hair.', NULL, NULL),
(87, NULL, 'Beard', 'img/services/skin5.jpg', 'Permanent Hair Removal', 7500.00, 1, NULL, 'Permanent hair removal for beard. Suitable for all beard types and skin tones.', NULL, NULL),
(88, NULL, 'Mustache & Beard', 'img/services/skin1.jpg', 'Permanent Hair Removal', 8000.00, 1, NULL, 'Permanent hair removal for mustache and beard. Comprehensive solution for facial hair removal.', NULL, NULL),
(89, NULL, 'Half Legs', 'img/services/skin2.jpg', 'Permanent Hair Removal', 7500.00, 1, NULL, 'Permanent hair removal for half legs. Enjoy smooth legs with minimal maintenance.', NULL, NULL),
(90, NULL, 'Full Legs', 'img/services/skin3.jpg', 'Permanent Hair Removal', 9500.00, 1, NULL, 'Permanent hair removal for full legs. Ideal for those seeking complete leg smoothness.', NULL, NULL),
(91, NULL, 'Full Arms', 'img/services/skin4.jpg', 'Permanent Hair Removal', 8000.00, 1, NULL, 'Permanent hair removal for full arms. Effective for both men and women.', NULL, NULL),
(92, NULL, 'Full Face', 'img/services/skin5.jpg', 'Permanent Hair Removal', 9000.00, 1, NULL, 'Permanent hair removal for full face. Achieve flawless, hair-free facial skin.', NULL, NULL),
(93, NULL, 'Chest/Back', 'img/services/skin1.jpg', 'Permanent Hair Removal', 10000.00, 1, NULL, 'Permanent hair removal for chest and back. Great for larger areas and long-lasting results.', NULL, NULL),
(97, NULL, 'Skin911 Complete Facial', 'img/services/skin1.jpg', 'Facial Services', 1100.00, 1, NULL, 'A deep cleansing facial that rejuvenates and hydrates your skin. Ideal for all skin types and helps restore a healthy glow.', NULL, NULL),
(98, NULL, 'Diamond Peel with complete facial', 'img/services/skin2.jpg', 'Facial Services', 2000.00, 1, NULL, 'Removes dead skin cells and improves skin texture. Perfect for reducing fine lines and brightening complexion.', NULL, NULL),
(99, NULL, 'Hydrafacial', 'img/services/skin3.jpg', 'Facial Services', 2800.00, 1, NULL, 'Hydrates and cleanses the skin using advanced technology. Leaves your skin feeling refreshed and deeply moisturized.', NULL, NULL),
(100, NULL, 'Wart removal (face and neck)', 'img/services/skin4.jpg', 'Facial Services', 2000.00, 1, NULL, 'Safe and effective removal of facial and neck warts. Quick procedure with minimal discomfort and downtime.', NULL, NULL),
(101, NULL, 'Microneedling', 'img/services/skin5.jpg', 'Facial Services', 4500.00, 1, NULL, 'Stimulates collagen production for smoother skin. Reduces scars, wrinkles, and improves overall skin texture.', NULL, NULL),
(102, NULL, 'Skin Rejuvenation Laser + Facial', 'img/services/skin1.jpg', 'Facial Services', 3000.00, 1, NULL, 'Laser treatment combined with facial for rejuvenation. Helps reduce pigmentation and signs of aging.', NULL, NULL),
(103, NULL, 'Pigmentation Laser + Facial', 'img/services/skin2.jpg', 'Facial Services', 3000.00, 1, NULL, 'Targets pigmentation issues for a more even skin tone. Effective for sun spots and melasma.', NULL, NULL),
(104, NULL, 'Acne laser + Acne Facial', 'img/services/skin3.jpg', 'Facial Services', 2700.00, 1, NULL, 'Laser and facial treatment for acne-prone skin. Minimizes breakouts and promotes clearer skin.', NULL, NULL),
(105, NULL, 'HIFU Ultralift', 'img/services/skin4.jpg', 'Facial Services', 5000.00, 1, NULL, 'Non-surgical lifting and tightening of the skin. Results in firmer, more youthful appearance.', NULL, NULL),
(106, NULL, 'Immuno gold + Vitamin C', 'img/services/skin5.jpg', 'Immuno Boosters', 1500.00, 1, NULL, 'Boosts immunity and skin health. Enhances skin radiance and overall wellness.', NULL, NULL),
(107, NULL, 'Elea White Drip', 'img/services/skin1.jpg', 'Immuno Boosters', 6500.00, 1, NULL, 'Brightens and whitens skin tone. Provides antioxidant protection and hydration.', NULL, NULL),
(108, NULL, 'Cindella Drip', 'img/services/skin2.jpg', 'Immuno Boosters', 3000.00, 1, NULL, 'Antioxidant drip for skin radiance. Revitalizes dull skin and supports detoxification.', NULL, NULL),
(109, NULL, 'Luminous White Drip', 'img/services/skin3.jpg', 'Immuno Boosters', 4500.00, 1, NULL, 'Intensive whitening and brightening treatment. Improves skin clarity and luminosity.', NULL, NULL),
(110, NULL, 'Collagen Injection', 'img/services/skin4.jpg', 'Immuno Boosters', 2000.00, 1, NULL, 'Improves skin elasticity and firmness. Helps reduce wrinkles and maintain youthful skin.', NULL, NULL),
(111, NULL, 'Placenta Injection', 'img/services/skin5.jpg', 'Immuno Boosters', 2000.00, 1, NULL, 'Promotes skin regeneration and healing. Supports cell renewal for healthier skin.', NULL, NULL),
(112, NULL, 'Radio frequency RF', 'img/services/skin1.jpg', 'Slimming Services', 2500.00, 1, NULL, 'Non-invasive slimming and contouring. Tightens skin and reduces stubborn fat.', NULL, NULL),
(113, NULL, 'Lipo Cavitation + RF', 'img/services/skin2.jpg', 'Slimming Services', 4000.00, 1, NULL, 'Fat reduction and skin tightening combo. Effective for body sculpting and cellulite reduction.', NULL, NULL),
(114, NULL, 'Lipo-cavitation', 'img/services/skin3.jpg', 'Slimming Services', 2500.00, 1, NULL, 'Ultrasound fat reduction treatment. Targets localized fat deposits for a slimmer look.', NULL, NULL),
(115, NULL, 'Diode Lipo Laser', 'img/services/skin4.jpg', 'Slimming Services', 3500.00, 1, NULL, 'Laser-based fat reduction. Safe and painless way to contour your body.', NULL, NULL),
(116, NULL, 'TRIO slim', 'img/services/skin5.jpg', 'Slimming Services', 5000.00, 1, NULL, 'Triple-action slimming treatment. Combines multiple technologies for maximum results.', NULL, NULL),
(117, NULL, 'Underarms', 'img/services/skin1.jpg', 'Permanent Hair Removal', 7000.00, 1, NULL, 'Permanent hair removal for underarms. Leaves skin smooth and hair-free for longer.', NULL, NULL),
(118, NULL, 'Bikini', 'img/services/skin2.jpg', 'Permanent Hair Removal', 5000.00, 1, NULL, 'Permanent hair removal for bikini area. Gentle and effective for sensitive skin.', NULL, NULL),
(119, NULL, 'Full Brazilian', 'img/services/skin3.jpg', 'Permanent Hair Removal', 9000.00, 1, NULL, 'Permanent hair removal for full Brazilian area. Achieve long-lasting smoothness and comfort.', NULL, NULL),
(120, NULL, 'Mustache', 'img/services/skin4.jpg', 'Permanent Hair Removal', 4000.00, 1, NULL, 'Permanent hair removal for mustache. Quick and precise treatment for facial hair.', NULL, NULL),
(121, NULL, 'Beard', 'img/services/skin5.jpg', 'Permanent Hair Removal', 7500.00, 1, NULL, 'Permanent hair removal for beard. Suitable for all beard types and skin tones.', NULL, NULL),
(122, NULL, 'Mustache & Beard', 'img/services/skin1.jpg', 'Permanent Hair Removal', 8000.00, 1, NULL, 'Permanent hair removal for mustache and beard. Comprehensive solution for facial hair removal.', NULL, NULL),
(123, NULL, 'Half Legs', 'img/services/skin2.jpg', 'Permanent Hair Removal', 7500.00, 1, NULL, 'Permanent hair removal for half legs. Enjoy smooth legs with minimal maintenance.', NULL, NULL),
(124, NULL, 'Full Legs', 'img/services/skin3.jpg', 'Permanent Hair Removal', 9500.00, 1, NULL, 'Permanent hair removal for full legs. Ideal for those seeking complete leg smoothness.', NULL, NULL),
(125, NULL, 'Full Arms', 'img/services/skin4.jpg', 'Permanent Hair Removal', 8000.00, 1, NULL, 'Permanent hair removal for full arms. Effective for both men and women.', NULL, NULL),
(126, NULL, 'Full Face', 'img/services/skin5.jpg', 'Permanent Hair Removal', 9000.00, 1, NULL, 'Permanent hair removal for full face. Achieve flawless, hair-free facial skin.', NULL, NULL),
(127, NULL, 'Chest/Back', 'img/services/skin1.jpg', 'Permanent Hair Removal', 10000.00, 1, NULL, 'Permanent hair removal for chest and back. Great for larger areas and long-lasting results.', NULL, NULL),
(128, NULL, 'Test 2-Hour Service', NULL, '', 1000.00, 2, 'A test service that takes 2 hours', NULL, '2025-10-08 09:08:37', '2025-11-05 22:23:31'),
(129, NULL, 'Test 3-Hour Service', NULL, '', 1500.00, 3, 'A test service that takes 3 hours', NULL, '2025-10-08 09:16:42', '2025-11-05 22:23:31');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1FV07o2pEB22B6R2saVrehxXj0M5d5zAlsA9eSXi', 24, '180.190.130.67', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR09PU3FWZ3pNZW51MXA1cjdvZGwxVGpsb2IyRjJja1RnNkx4RkZOWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc2tpbjkxMS5zaXRlL2NsaWVudC9ob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjQ7fQ==', 1762930771),
('2hq0TcS0wRrNZHJjzKrAGugonMVUELXQXR0A0leE', NULL, '180.190.130.67', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRWFkcjVOZHJvbENCOFFiOVFTNEtIdVFwa0Y3S0NCS0F6TExXQ2lOTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vc2tpbjkxMS5zaXRlLz9zaG93TG9naW49MSI7fX0=', 1762930633),
('gUSA0R30E1eLIXIkuunXmOXulm9AdSxYterg3bbx', NULL, '89.104.110.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNHo1bzlBT1ZSV2Z5UnNNNVB2c3NwOXZ6cWZ1bGZBSlE3Y0lNUGthRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vc2tpbjkxMS5zaXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762929341),
('hi2q21V9N2IUM6TPaneQCDserPFePWzgfUnwlKDe', NULL, '40.88.21.235', 'DuckDuckBot/1.1; (+http://duckduckgo.com/duckduckbot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNXlLM25WS1pSbjAxMUlTblNLa0tURXNFeFZtNVpYMXpFRWg2b0F0cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vc2tpbjkxMS5zaXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762930115),
('IC4mEvk9X7Ds0hWFs2PsTUHZ4GoKiCqd1LP2vXN9', NULL, '185.38.241.101', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOVpNNE1zeTFZdFlRTk44Zk91d1ZlekJLQjY0WGZsQ3BHMWs1MGtuZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vc2tpbjkxMS5zaXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762925375),
('ijq67DP904CXxEzKVdOBZOzdiEmbJIoFbC98QV9z', 33, '2001:4451:afc:f900:285a:6508:615b:808a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNkVXaUR3d2htRFRSdmlMZng4cGFHNXlDS29wQm1SczUycGhlZlI2RCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vc2tpbjkxMS5zaXRlL2NsaWVudC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMzt9', 1762932785),
('ISfMvVuCxYhStfuPNqmijLzSNot2G7VHBvqb2yvN', 35, '158.62.4.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNWVTV0VLQkNkOERZM25qNndDUHdla2ZiTHRhVnUyalczcXlMZ3J3aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc2tpbjkxMS5zaXRlL2NsaWVudC9ib29raW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MzU7czoxMjoiMmZhX3ZlcmlmaWVkIjtiOjE7fQ==', 1762932979),
('KVpZFsG8PfuhL6K4uRCPwa4Su7h7YjGV3rvlr2Db', NULL, '1.37.67.198', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicVl6MDlpS1hzaTd4UE5GNWRiUGd2WE12U1FpZVFsdG1UZmg4cWh4cCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMjoiaHR0cHM6Ly9za2luOTExLnNpdGUvY2xpZW50L2hvbWUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNjoiaHR0cHM6Ly9za2luOTExLnNpdGUvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1762925354),
('pBa86ltQKlokzMOxwLiKuZTyAzypQBkFo7ojq4J8', 33, '2001:4451:afc:f900:b1d2:312b:6e97:5d82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic09sdmp2cDU0ZlkzdnFIUVhDV05GeDhFZWJ2anBRN0FKYlZiQVpHViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc2tpbjkxMS5zaXRlL2NsaWVudC9ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MzM7fQ==', 1762930543),
('pXq9ZT13NAhGTiLLpB9iWR91NPfGKHZH0tGPLV74', 33, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQmNTVU1JRWIwdlV2cEQwY1ZlNU96cHZSdm1vV1M4ZloxbkZPbEhCWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvbWVzc2FnZXMvbmV3P3NpbmNlPTAiO31zOjUwOiJsb2dpbl9jZW9fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjMzO30=', 1762952879),
('QsHsiazt58kZ13KgKPbR6O3qRtKYrXiw9pyK26ql', 24, '180.190.130.67', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMTh1cGEybUE5TE5nOWpvNHhnM3JpdFRnVkFIMHVXaFUyV1dhMkRsYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjQ7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vc2tpbjkxMS5zaXRlL2NsaWVudC9kYXNoYm9hcmQiO319', 1762930092),
('t2k0yoYEABCJPiC09ktK8rBYMAEu4glK3kiKNLmr', 24, '180.190.130.67', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTWVZeVR3amNBWE5OcGI1RnA5bWNJblhNYXBkZGFhUlJjVW93RHZuZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc2tpbjkxMS5zaXRlL2NsaWVudC9wcm9maWxlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjQ7fQ==', 1762930450),
('tCgu3As19HDoOOAEVpYVmLxu9WvI7SdVN739ti0J', 24, '180.190.130.67', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVjRnZlNFUUFQeHBTWjZYalFvTk9jZzBmbXltZXVmbjl1aHZTSDNNViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc2tpbjkxMS5zaXRlL2NsaWVudC9ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjQ7fQ==', 1762930641),
('XIMjxLKrINvZ3GnVRxRTYcT8uI9zmnkFW6OXO2UQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibTNLb3RLeGFMMGFueGNLSzNqQnBsZ0FxUTR0RlBXSmxhd050NkJvcyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdGFmZi9hcHBvaW50bWVudHMiO31zOjUyOiJsb2dpbl9zdGFmZl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjk7fQ==', 1762952504),
('XtZz9pQVzPq4NvGTuHvrpqE7uouyQX6aZJlSbAK7', NULL, '2001:4451:afc:f900:285a:6508:615b:808a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZVFrY05ZRjhLODJieGNWMWVvSXA4eFIxUERFNnRSNXlhNlN0YjZQRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vc2tpbjkxMS5zaXRlL3N0YWZmL2FwcG9pbnRtZW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX3N0YWZmXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6OTt9', 1762930632),
('xx7MbRizhdW8ExbjeZsR7lA6CZTgTzgpDPrFollE', 33, '2001:4451:afc:f900:b1d2:312b:6e97:5d82', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieXEwRkYyTThFM2Jia2VkeEdBR2NjaUUyYXR0OVZRSXY4a2tVbmFsWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc2tpbjkxMS5zaXRlL2NsaWVudC9ob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MzM7fQ==', 1762931098),
('ZTd8SzuaZwtIWSm2uqDqqiNqDuiUtSqA2X011NW0', NULL, '118.194.228.7', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzhnQjZMUDV3d3dVVkNLVHI0TEN5aE9XeVMxOVE4Ym5rU0tVYVFMdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vc2tpbjkxMS5zaXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762931520);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `service_id`, `branch_id`, `staff_id`, `amount`, `payment_method`, `created_at`, `updated_at`) VALUES
(17, 4, NULL, 4, 2000.00, 'Cash', '2025-08-26 11:26:08', '2025-08-26 11:26:08'),
(18, 3, NULL, 4, 2800.00, 'Card', '2025-08-26 11:26:16', '2025-08-26 11:26:16'),
(19, 5, NULL, 4, 4500.00, 'E-wallet', '2025-08-31 13:50:01', '2025-08-31 13:50:01'),
(20, 1, 1, 9, 1200.00, 'Cash', '2025-09-12 13:58:18', '2025-09-12 13:58:18'),
(21, 1, 1, 9, 1400.00, 'Cash', '2025-09-12 13:58:32', '2025-09-12 13:58:32'),
(22, 1, 1, 9, 1200.00, 'Card', '2025-09-12 13:58:35', '2025-09-12 13:58:35'),
(23, 3, 1, 9, 2800.00, 'Cash', '2025-09-12 13:58:37', '2025-09-12 13:58:37'),
(24, 1, 1, 9, 1200.00, 'Cash', '2025-09-12 13:58:38', '2025-09-12 13:58:38'),
(25, 1, 1, 9, 1200.00, 'Cash', '2025-09-12 13:58:39', '2025-09-12 13:58:39'),
(26, 4, 1, 9, 2000.00, 'Cash', '2025-09-12 14:01:51', '2025-09-12 14:01:51'),
(27, 8, 1, 9, 2700.00, 'Cash', '2025-09-12 14:33:48', '2025-09-12 14:33:48'),
(28, 4, 1, 9, 2000.00, 'Card', '2025-09-12 14:38:13', '2025-09-12 14:38:13'),
(29, 7, 1, NULL, 771.00, 'card', '2025-05-17 00:42:43', '2025-05-17 00:42:43'),
(30, 8, 1, NULL, 1867.00, 'card', '2025-05-11 20:42:43', '2025-05-11 20:42:43'),
(31, 69, 1, NULL, 2067.00, 'cash', '2025-05-19 21:42:43', '2025-05-19 21:42:43'),
(32, 15, 1, NULL, 567.00, 'cash', '2025-05-06 19:42:43', '2025-05-06 19:42:43'),
(33, 7, 1, NULL, 1913.00, 'gcash', '2025-05-13 23:42:43', '2025-05-13 23:42:43'),
(34, 97, 1, NULL, 576.00, 'cash', '2025-05-16 03:42:43', '2025-05-16 03:42:43'),
(35, 35, 1, NULL, 2629.00, 'gcash', '2025-05-23 21:42:43', '2025-05-23 21:42:43'),
(36, 56, 1, NULL, 2757.00, 'card', '2025-04-27 22:42:43', '2025-04-27 22:42:43'),
(37, 33, 1, NULL, 1560.00, 'cash', '2025-05-07 20:42:43', '2025-05-07 20:42:43'),
(38, 64, 1, NULL, 2249.00, 'card', '2025-05-01 21:42:43', '2025-05-01 21:42:43'),
(39, 19, 1, NULL, 1838.00, 'cash', '2025-05-23 21:42:43', '2025-05-23 21:42:43'),
(40, 86, 1, NULL, 2645.00, 'card', '2025-05-21 22:42:43', '2025-05-21 22:42:43'),
(41, 109, 2, NULL, 2877.00, 'card', '2025-04-29 23:42:43', '2025-04-29 23:42:43'),
(42, 24, 2, NULL, 1740.00, 'gcash', '2025-05-13 03:42:43', '2025-05-13 03:42:43'),
(43, 36, 2, NULL, 1731.00, 'card', '2025-05-07 00:42:43', '2025-05-07 00:42:43'),
(44, 69, 2, NULL, 636.00, 'card', '2025-05-09 22:42:43', '2025-05-09 22:42:43'),
(45, 31, 2, NULL, 2485.00, 'cash', '2025-05-10 22:42:43', '2025-05-10 22:42:43'),
(46, 44, 2, NULL, 810.00, 'gcash', '2025-05-22 01:42:43', '2025-05-22 01:42:43'),
(47, 126, 2, NULL, 1997.00, 'cash', '2025-05-22 19:42:43', '2025-05-22 19:42:43'),
(48, 32, NULL, NULL, 2228.00, 'card', '2025-05-03 02:42:43', '2025-05-03 02:42:43'),
(49, 76, NULL, NULL, 1616.00, 'card', '2025-05-22 00:42:43', '2025-05-22 00:42:43'),
(50, 42, NULL, NULL, 856.00, 'cash', '2025-05-16 21:42:43', '2025-05-16 21:42:43'),
(51, 120, NULL, NULL, 1880.00, 'cash', '2025-04-28 20:42:43', '2025-04-28 20:42:43'),
(52, 32, NULL, NULL, 2969.00, 'cash', '2025-05-16 20:42:43', '2025-05-16 20:42:43'),
(53, 28, NULL, NULL, 1112.00, 'cash', '2025-05-21 03:42:43', '2025-05-21 03:42:43'),
(54, 36, NULL, NULL, 839.00, 'gcash', '2025-05-08 01:42:43', '2025-05-08 01:42:43'),
(55, 118, NULL, NULL, 1089.00, 'cash', '2025-05-08 00:42:43', '2025-05-08 00:42:43'),
(56, 9, NULL, NULL, 1198.00, 'cash', '2025-05-07 22:42:43', '2025-05-07 22:42:43'),
(57, 43, NULL, NULL, 2923.00, 'card', '2025-05-10 01:42:43', '2025-05-10 01:42:43'),
(58, 68, NULL, NULL, 2035.00, 'gcash', '2025-05-06 03:42:43', '2025-05-06 03:42:43'),
(59, 17, NULL, NULL, 931.00, 'card', '2025-04-30 20:42:43', '2025-04-30 20:42:43'),
(60, 74, NULL, NULL, 2515.00, 'gcash', '2025-05-04 00:42:43', '2025-05-04 00:42:43'),
(61, 1, NULL, NULL, 2856.00, 'gcash', '2025-05-09 03:42:43', '2025-05-09 03:42:43'),
(62, 122, NULL, NULL, 535.00, 'gcash', '2025-05-25 03:42:43', '2025-05-25 03:42:43'),
(63, 55, NULL, NULL, 2858.00, 'card', '2025-05-06 23:42:43', '2025-05-06 23:42:43'),
(64, 89, NULL, NULL, 726.00, 'gcash', '2025-05-02 23:42:43', '2025-05-02 23:42:43'),
(65, 76, NULL, NULL, 1536.00, 'cash', '2025-05-10 00:42:43', '2025-05-10 00:42:43'),
(66, 66, NULL, NULL, 1083.00, 'gcash', '2025-05-21 20:42:43', '2025-05-21 20:42:43'),
(67, 15, NULL, NULL, 1820.00, 'card', '2025-05-17 19:42:43', '2025-05-17 19:42:43'),
(68, 48, NULL, NULL, 2232.00, 'card', '2025-05-12 02:42:43', '2025-05-12 02:42:43'),
(69, 123, NULL, NULL, 1490.00, 'card', '2025-05-11 01:42:43', '2025-05-11 01:42:43'),
(70, 20, NULL, NULL, 1610.00, 'card', '2025-05-11 23:42:43', '2025-05-11 23:42:43'),
(71, 72, NULL, NULL, 2315.00, 'gcash', '2025-05-05 23:42:43', '2025-05-05 23:42:43'),
(72, 112, NULL, NULL, 679.00, 'gcash', '2025-05-13 19:42:43', '2025-05-13 19:42:43'),
(73, 16, NULL, NULL, 2404.00, 'card', '2025-05-04 03:42:43', '2025-05-04 03:42:43'),
(74, 119, NULL, NULL, 2868.00, 'gcash', '2025-05-16 02:42:43', '2025-05-16 02:42:43'),
(75, 2, NULL, NULL, 2738.00, 'card', '2025-05-22 22:42:43', '2025-05-22 22:42:43'),
(76, 78, NULL, NULL, 2757.00, 'card', '2025-05-19 22:42:43', '2025-05-19 22:42:43'),
(77, 91, NULL, NULL, 2653.00, 'cash', '2025-05-06 21:42:43', '2025-05-06 21:42:43'),
(78, 8, NULL, NULL, 524.00, 'cash', '2025-04-27 22:42:43', '2025-04-27 22:42:43'),
(79, 70, NULL, NULL, 2956.00, 'card', '2025-05-13 21:42:43', '2025-05-13 21:42:43'),
(80, 83, NULL, NULL, 1066.00, 'gcash', '2025-05-09 23:42:43', '2025-05-09 23:42:43'),
(81, 66, NULL, NULL, 2556.00, 'cash', '2025-05-10 03:42:43', '2025-05-10 03:42:43'),
(82, 126, NULL, NULL, 2138.00, 'gcash', '2025-05-22 20:42:43', '2025-05-22 20:42:43'),
(83, 13, NULL, NULL, 2335.00, 'card', '2025-05-08 20:42:43', '2025-05-08 20:42:43'),
(84, 92, NULL, NULL, 966.00, 'card', '2025-05-19 22:42:43', '2025-05-19 22:42:43'),
(85, 112, NULL, NULL, 820.00, 'card', '2025-05-11 01:42:43', '2025-05-11 01:42:43'),
(86, 117, NULL, NULL, 2941.00, 'cash', '2025-04-29 01:42:43', '2025-04-29 01:42:43'),
(87, 11, NULL, NULL, 2991.00, 'gcash', '2025-05-03 22:42:43', '2025-05-03 22:42:43'),
(88, 37, 1, NULL, 2570.00, 'gcash', '2025-05-31 19:42:44', '2025-05-31 19:42:44'),
(89, 3, 1, NULL, 1005.00, 'card', '2025-06-14 01:42:44', '2025-06-14 01:42:44'),
(90, 60, 1, NULL, 1380.00, 'gcash', '2025-05-29 22:42:44', '2025-05-29 22:42:44'),
(91, 28, 1, NULL, 1543.00, 'cash', '2025-06-11 22:42:44', '2025-06-11 22:42:44'),
(92, 89, 1, NULL, 942.00, 'gcash', '2025-06-07 03:42:44', '2025-06-07 03:42:44'),
(93, 105, 1, NULL, 920.00, 'cash', '2025-06-15 03:42:44', '2025-06-15 03:42:44'),
(94, 125, 1, NULL, 1081.00, 'gcash', '2025-06-08 21:42:44', '2025-06-08 21:42:44'),
(95, 21, 1, NULL, 2031.00, 'card', '2025-05-29 23:42:44', '2025-05-29 23:42:44'),
(96, 34, 1, NULL, 1789.00, 'card', '2025-06-06 03:42:44', '2025-06-06 03:42:44'),
(97, 42, 1, NULL, 2189.00, 'card', '2025-05-31 22:42:44', '2025-05-31 22:42:44'),
(98, 11, 1, NULL, 1556.00, 'card', '2025-06-09 01:42:44', '2025-06-09 01:42:44'),
(99, 117, 1, NULL, 2844.00, 'card', '2025-06-24 01:42:44', '2025-06-24 01:42:44'),
(100, 45, 1, NULL, 1784.00, 'card', '2025-06-08 22:42:44', '2025-06-08 22:42:44'),
(101, 92, 2, NULL, 1303.00, 'card', '2025-06-07 21:42:44', '2025-06-07 21:42:44'),
(102, 125, 2, NULL, 793.00, 'gcash', '2025-06-21 23:42:44', '2025-06-21 23:42:44'),
(103, 92, 2, NULL, 2362.00, 'card', '2025-06-13 23:42:44', '2025-06-13 23:42:44'),
(104, 74, 2, NULL, 2492.00, 'card', '2025-06-09 00:42:44', '2025-06-09 00:42:44'),
(105, 37, 2, NULL, 1709.00, 'card', '2025-06-11 21:42:44', '2025-06-11 21:42:44'),
(106, 55, 2, NULL, 2440.00, 'gcash', '2025-05-31 01:42:44', '2025-05-31 01:42:44'),
(107, 40, 2, NULL, 1241.00, 'cash', '2025-06-10 02:42:44', '2025-06-10 02:42:44'),
(108, 124, NULL, NULL, 1391.00, 'gcash', '2025-06-06 00:42:44', '2025-06-06 00:42:44'),
(109, 7, NULL, NULL, 1136.00, 'gcash', '2025-05-30 19:42:44', '2025-05-30 19:42:44'),
(110, 41, NULL, NULL, 1741.00, 'cash', '2025-06-05 00:42:44', '2025-06-05 00:42:44'),
(111, 18, NULL, NULL, 852.00, 'gcash', '2025-06-12 22:42:44', '2025-06-12 22:42:44'),
(112, 41, NULL, NULL, 1232.00, 'card', '2025-06-01 01:42:44', '2025-06-01 01:42:44'),
(113, 70, NULL, NULL, 2785.00, 'card', '2025-06-17 19:42:44', '2025-06-17 19:42:44'),
(114, 76, NULL, NULL, 2488.00, 'gcash', '2025-06-01 22:42:44', '2025-06-01 22:42:44'),
(115, 65, NULL, NULL, 1223.00, 'gcash', '2025-06-18 21:42:44', '2025-06-18 21:42:44'),
(116, 2, NULL, NULL, 589.00, 'card', '2025-05-29 23:42:44', '2025-05-29 23:42:44'),
(117, 78, NULL, NULL, 1920.00, 'cash', '2025-06-18 22:42:44', '2025-06-18 22:42:44'),
(118, 67, NULL, NULL, 1240.00, 'card', '2025-06-14 23:42:44', '2025-06-14 23:42:44'),
(119, 38, NULL, NULL, 2898.00, 'cash', '2025-06-15 19:42:44', '2025-06-15 19:42:44'),
(120, 76, NULL, NULL, 1287.00, 'card', '2025-06-01 23:42:44', '2025-06-01 23:42:44'),
(121, 70, NULL, NULL, 1267.00, 'card', '2025-05-31 01:42:44', '2025-05-31 01:42:44'),
(122, 25, NULL, NULL, 2906.00, 'cash', '2025-06-03 21:42:44', '2025-06-03 21:42:44'),
(123, 55, NULL, NULL, 610.00, 'gcash', '2025-06-12 01:42:44', '2025-06-12 01:42:44'),
(124, 33, NULL, NULL, 1343.00, 'card', '2025-06-20 22:42:44', '2025-06-20 22:42:44'),
(125, 43, NULL, NULL, 983.00, 'gcash', '2025-05-29 22:42:44', '2025-05-29 22:42:44'),
(126, 32, NULL, NULL, 2512.00, 'cash', '2025-06-12 03:42:44', '2025-06-12 03:42:44'),
(127, 24, NULL, NULL, 1668.00, 'cash', '2025-06-19 22:42:44', '2025-06-19 22:42:44'),
(128, 64, NULL, NULL, 1755.00, 'cash', '2025-06-09 20:42:44', '2025-06-09 20:42:44'),
(129, 83, NULL, NULL, 1994.00, 'card', '2025-06-20 20:42:44', '2025-06-20 20:42:44'),
(130, 109, NULL, NULL, 1469.00, 'gcash', '2025-06-13 19:42:44', '2025-06-13 19:42:44'),
(131, 123, NULL, NULL, 2789.00, 'cash', '2025-06-19 03:42:44', '2025-06-19 03:42:44'),
(132, 48, NULL, NULL, 600.00, 'gcash', '2025-06-09 22:42:44', '2025-06-09 22:42:44'),
(133, 127, 1, NULL, 1602.00, 'card', '2025-07-14 19:42:44', '2025-07-14 19:42:44'),
(134, 19, 1, NULL, 2549.00, 'gcash', '2025-07-05 23:42:44', '2025-07-05 23:42:44'),
(135, 71, 1, NULL, 2434.00, 'gcash', '2025-07-18 22:42:44', '2025-07-18 22:42:44'),
(136, 111, 1, NULL, 2485.00, 'card', '2025-07-20 19:42:44', '2025-07-20 19:42:44'),
(137, 39, 1, NULL, 1520.00, 'card', '2025-07-22 19:42:44', '2025-07-22 19:42:44'),
(138, 62, 1, NULL, 1417.00, 'gcash', '2025-07-11 00:42:44', '2025-07-11 00:42:44'),
(139, 54, 1, NULL, 659.00, 'cash', '2025-07-13 03:42:44', '2025-07-13 03:42:44'),
(140, 118, 1, NULL, 767.00, 'card', '2025-07-06 02:42:44', '2025-07-06 02:42:44'),
(141, 60, 1, NULL, 1183.00, 'card', '2025-07-07 21:42:44', '2025-07-07 21:42:44'),
(142, 5, 1, NULL, 1090.00, 'card', '2025-07-20 02:42:44', '2025-07-20 02:42:44'),
(143, 4, 1, NULL, 583.00, 'gcash', '2025-07-17 20:42:44', '2025-07-17 20:42:44'),
(144, 83, 1, NULL, 711.00, 'card', '2025-07-06 22:42:44', '2025-07-06 22:42:44'),
(145, 21, 1, NULL, 1559.00, 'cash', '2025-07-10 02:42:44', '2025-07-10 02:42:44'),
(146, 35, 1, NULL, 2133.00, 'cash', '2025-07-20 20:42:44', '2025-07-20 20:42:44'),
(147, 11, 2, NULL, 984.00, 'card', '2025-07-24 21:42:44', '2025-07-24 21:42:44'),
(148, 91, 2, NULL, 937.00, 'card', '2025-07-13 21:42:44', '2025-07-13 21:42:44'),
(149, 56, 2, NULL, 1181.00, 'gcash', '2025-07-01 23:42:44', '2025-07-01 23:42:44'),
(150, 8, 2, NULL, 1798.00, 'card', '2025-07-20 19:42:44', '2025-07-20 19:42:44'),
(151, 102, 2, NULL, 626.00, 'gcash', '2025-07-19 02:42:44', '2025-07-19 02:42:44'),
(152, 127, 2, NULL, 673.00, 'gcash', '2025-07-24 20:42:44', '2025-07-24 20:42:44'),
(153, 107, 2, NULL, 2538.00, 'cash', '2025-07-12 00:42:44', '2025-07-12 00:42:44'),
(154, 20, 2, NULL, 2601.00, 'gcash', '2025-07-11 19:42:44', '2025-07-11 19:42:44'),
(155, 33, 2, NULL, 632.00, 'gcash', '2025-07-01 02:42:44', '2025-07-01 02:42:44'),
(156, 68, 2, NULL, 882.00, 'card', '2025-07-01 00:42:44', '2025-07-01 00:42:44'),
(157, 118, 2, NULL, 969.00, 'gcash', '2025-06-28 21:42:44', '2025-06-28 21:42:44'),
(158, 56, 2, NULL, 2834.00, 'cash', '2025-07-09 01:42:44', '2025-07-09 01:42:44'),
(159, 35, 2, NULL, 1326.00, 'gcash', '2025-07-14 20:42:44', '2025-07-14 20:42:44'),
(160, 14, NULL, NULL, 2066.00, 'card', '2025-07-20 20:42:44', '2025-07-20 20:42:44'),
(161, 7, NULL, NULL, 2435.00, 'card', '2025-07-17 22:42:44', '2025-07-17 22:42:44'),
(162, 124, NULL, NULL, 2570.00, 'gcash', '2025-07-17 03:42:44', '2025-07-17 03:42:44'),
(163, 8, NULL, NULL, 1111.00, 'cash', '2025-07-13 22:42:44', '2025-07-13 22:42:44'),
(164, 71, NULL, NULL, 2211.00, 'gcash', '2025-07-16 03:42:44', '2025-07-16 03:42:44'),
(165, 114, NULL, NULL, 1889.00, 'gcash', '2025-07-08 22:42:44', '2025-07-08 22:42:44'),
(166, 6, NULL, NULL, 1750.00, 'card', '2025-06-28 03:42:44', '2025-06-28 03:42:44'),
(167, 111, NULL, NULL, 2854.00, 'gcash', '2025-07-23 02:42:44', '2025-07-23 02:42:44'),
(168, 89, NULL, NULL, 898.00, 'cash', '2025-07-17 23:42:44', '2025-07-17 23:42:44'),
(169, 114, NULL, NULL, 1053.00, 'cash', '2025-07-05 19:42:44', '2025-07-05 19:42:44'),
(170, 62, NULL, NULL, 1203.00, 'cash', '2025-07-23 03:42:44', '2025-07-23 03:42:44'),
(171, 42, NULL, NULL, 647.00, 'gcash', '2025-07-22 01:42:44', '2025-07-22 01:42:44'),
(172, 88, NULL, NULL, 988.00, 'cash', '2025-07-10 22:42:44', '2025-07-10 22:42:44'),
(173, 12, NULL, NULL, 589.00, 'card', '2025-06-27 20:42:44', '2025-06-27 20:42:44'),
(174, 22, NULL, NULL, 952.00, 'gcash', '2025-07-08 01:42:44', '2025-07-08 01:42:44'),
(175, 41, NULL, NULL, 1723.00, 'gcash', '2025-06-28 00:42:44', '2025-06-28 00:42:44'),
(176, 125, NULL, NULL, 1929.00, 'cash', '2025-07-18 01:42:44', '2025-07-18 01:42:44'),
(177, 99, NULL, NULL, 2842.00, 'gcash', '2025-07-18 23:42:44', '2025-07-18 23:42:44'),
(178, 9, NULL, NULL, 2129.00, 'cash', '2025-07-01 03:42:44', '2025-07-01 03:42:44'),
(179, 103, NULL, NULL, 2740.00, 'card', '2025-07-13 22:42:44', '2025-07-13 22:42:44'),
(180, 120, NULL, NULL, 2926.00, 'card', '2025-07-07 00:42:44', '2025-07-07 00:42:44'),
(181, 47, NULL, NULL, 551.00, 'cash', '2025-07-06 23:42:44', '2025-07-06 23:42:44'),
(182, 115, NULL, NULL, 1211.00, 'cash', '2025-07-09 03:42:44', '2025-07-09 03:42:44'),
(183, 77, NULL, NULL, 939.00, 'gcash', '2025-07-12 22:42:44', '2025-07-12 22:42:44'),
(184, 27, NULL, NULL, 1778.00, 'gcash', '2025-07-06 03:42:44', '2025-07-06 03:42:44'),
(185, 13, NULL, NULL, 880.00, 'gcash', '2025-07-01 02:42:44', '2025-07-01 02:42:44'),
(186, 105, NULL, NULL, 2023.00, 'cash', '2025-06-27 20:42:44', '2025-06-27 20:42:44'),
(187, 93, NULL, NULL, 2301.00, 'gcash', '2025-07-23 21:42:44', '2025-07-23 21:42:44'),
(188, 73, 1, NULL, 2907.00, 'cash', '2025-08-22 21:42:44', '2025-08-22 21:42:44'),
(189, 62, 1, NULL, 2761.00, 'gcash', '2025-08-08 01:42:44', '2025-08-08 01:42:44'),
(190, 88, 1, NULL, 1278.00, 'cash', '2025-08-04 01:42:44', '2025-08-04 01:42:44'),
(191, 36, 1, NULL, 2014.00, 'gcash', '2025-08-10 03:42:44', '2025-08-10 03:42:44'),
(192, 59, 1, NULL, 2370.00, 'gcash', '2025-08-02 20:42:44', '2025-08-02 20:42:44'),
(193, 37, 2, NULL, 850.00, 'cash', '2025-08-17 00:42:44', '2025-08-17 00:42:44'),
(194, 59, 2, NULL, 1785.00, 'gcash', '2025-08-18 01:42:44', '2025-08-18 01:42:44'),
(195, 4, 2, NULL, 2698.00, 'card', '2025-08-08 21:42:44', '2025-08-08 21:42:44'),
(196, 123, 2, NULL, 1166.00, 'card', '2025-08-08 22:42:44', '2025-08-08 22:42:44'),
(197, 104, 2, NULL, 1883.00, 'gcash', '2025-08-10 23:42:44', '2025-08-10 23:42:44'),
(198, 63, 2, NULL, 2923.00, 'gcash', '2025-08-17 19:42:44', '2025-08-17 19:42:44'),
(199, 99, 2, NULL, 2630.00, 'cash', '2025-08-12 00:42:44', '2025-08-12 00:42:44'),
(200, 108, NULL, NULL, 1163.00, 'card', '2025-08-07 01:42:44', '2025-08-07 01:42:44'),
(201, 43, NULL, NULL, 2234.00, 'gcash', '2025-08-16 20:42:44', '2025-08-16 20:42:44'),
(202, 121, NULL, NULL, 2905.00, 'cash', '2025-08-13 21:42:44', '2025-08-13 21:42:44'),
(203, 87, NULL, NULL, 2503.00, 'card', '2025-08-23 22:42:44', '2025-08-23 22:42:44'),
(204, 59, NULL, NULL, 835.00, 'gcash', '2025-08-03 01:42:44', '2025-08-03 01:42:44'),
(205, 124, NULL, NULL, 1750.00, 'card', '2025-08-22 00:42:44', '2025-08-22 00:42:44'),
(206, 97, NULL, NULL, 548.00, 'gcash', '2025-08-01 20:42:44', '2025-08-01 20:42:44'),
(207, 50, NULL, NULL, 2418.00, 'card', '2025-08-15 19:42:44', '2025-08-15 19:42:44'),
(208, 90, NULL, NULL, 508.00, 'card', '2025-08-10 20:42:44', '2025-08-10 20:42:44'),
(209, 127, NULL, NULL, 1894.00, 'card', '2025-07-29 21:42:44', '2025-07-29 21:42:44'),
(210, 121, NULL, NULL, 669.00, 'gcash', '2025-08-03 03:42:44', '2025-08-03 03:42:44'),
(211, 74, NULL, NULL, 2327.00, 'card', '2025-07-27 20:42:44', '2025-07-27 20:42:44'),
(212, 102, NULL, NULL, 589.00, 'card', '2025-08-04 19:42:44', '2025-08-04 19:42:44'),
(213, 63, NULL, NULL, 1972.00, 'gcash', '2025-08-15 20:42:44', '2025-08-15 20:42:44'),
(214, 29, NULL, NULL, 2194.00, 'cash', '2025-08-06 01:42:44', '2025-08-06 01:42:44'),
(215, 66, NULL, NULL, 2290.00, 'gcash', '2025-08-07 21:42:44', '2025-08-07 21:42:44'),
(216, 91, NULL, NULL, 1656.00, 'cash', '2025-07-28 22:42:44', '2025-07-28 22:42:44'),
(217, 88, NULL, NULL, 1513.00, 'gcash', '2025-08-15 23:42:44', '2025-08-15 23:42:44'),
(218, 30, NULL, NULL, 1871.00, 'gcash', '2025-08-17 22:42:44', '2025-08-17 22:42:44'),
(219, 81, NULL, NULL, 1957.00, 'gcash', '2025-08-08 02:42:44', '2025-08-08 02:42:44'),
(220, 101, NULL, NULL, 2611.00, 'cash', '2025-07-29 01:42:44', '2025-07-29 01:42:44'),
(221, 22, NULL, NULL, 2110.00, 'gcash', '2025-07-28 23:42:44', '2025-07-28 23:42:44'),
(222, 16, NULL, NULL, 596.00, 'cash', '2025-08-15 00:42:44', '2025-08-15 00:42:44'),
(223, 61, NULL, NULL, 2670.00, 'gcash', '2025-07-31 02:42:44', '2025-07-31 02:42:44'),
(224, 111, NULL, NULL, 909.00, 'card', '2025-07-29 03:42:44', '2025-07-29 03:42:44'),
(225, 105, 1, NULL, 1217.00, 'gcash', '2025-08-28 20:42:44', '2025-08-28 20:42:44'),
(226, 121, 1, NULL, 1282.00, 'card', '2025-09-20 02:42:44', '2025-09-20 02:42:44'),
(227, 119, 1, NULL, 2598.00, 'cash', '2025-09-22 03:42:44', '2025-09-22 03:42:44'),
(228, 97, 1, NULL, 1418.00, 'gcash', '2025-09-09 00:42:44', '2025-09-09 00:42:44'),
(229, 51, 1, NULL, 2056.00, 'gcash', '2025-09-15 21:42:44', '2025-09-15 21:42:44'),
(230, 67, 1, NULL, 1784.00, 'gcash', '2025-09-16 19:42:44', '2025-09-16 19:42:44'),
(231, 22, 1, NULL, 699.00, 'cash', '2025-09-02 22:42:44', '2025-09-02 22:42:44'),
(232, 62, 1, NULL, 2636.00, 'card', '2025-09-04 00:42:44', '2025-09-04 00:42:44'),
(233, 5, 2, NULL, 1867.00, 'card', '2025-09-10 21:42:44', '2025-09-10 21:42:44'),
(234, 77, 2, NULL, 1083.00, 'card', '2025-09-06 23:42:44', '2025-09-06 23:42:44'),
(235, 59, 2, NULL, 613.00, 'cash', '2025-09-15 21:42:44', '2025-09-15 21:42:44'),
(236, 70, 2, NULL, 2359.00, 'gcash', '2025-09-20 20:42:44', '2025-09-20 20:42:44'),
(237, 106, 2, NULL, 1787.00, 'cash', '2025-09-12 20:42:44', '2025-09-12 20:42:44'),
(238, 8, 2, NULL, 1057.00, 'cash', '2025-09-13 22:42:44', '2025-09-13 22:42:44'),
(239, 117, 2, NULL, 602.00, 'card', '2025-09-10 03:42:44', '2025-09-10 03:42:44'),
(240, 7, 2, NULL, 972.00, 'card', '2025-09-10 00:42:44', '2025-09-10 00:42:44'),
(241, 59, 2, NULL, 828.00, 'cash', '2025-09-16 02:42:44', '2025-09-16 02:42:44'),
(242, 16, NULL, NULL, 2060.00, 'cash', '2025-09-14 03:42:44', '2025-09-14 03:42:44'),
(243, 30, NULL, NULL, 1161.00, 'cash', '2025-08-30 20:42:44', '2025-08-30 20:42:44'),
(244, 50, NULL, NULL, 1571.00, 'cash', '2025-09-19 00:42:44', '2025-09-19 00:42:44'),
(245, 53, NULL, NULL, 1663.00, 'cash', '2025-09-15 23:42:44', '2025-09-15 23:42:44'),
(246, 74, NULL, NULL, 2799.00, 'gcash', '2025-09-17 22:42:44', '2025-09-17 22:42:44'),
(247, 13, NULL, NULL, 1170.00, 'cash', '2025-08-28 21:42:44', '2025-08-28 21:42:44'),
(248, 8, NULL, NULL, 2819.00, 'cash', '2025-09-12 00:42:44', '2025-09-12 00:42:44'),
(249, 28, NULL, NULL, 2813.00, 'cash', '2025-09-08 21:42:44', '2025-09-08 21:42:44'),
(250, 123, NULL, NULL, 574.00, 'cash', '2025-08-28 21:42:44', '2025-08-28 21:42:44'),
(251, 5, NULL, NULL, 1585.00, 'gcash', '2025-08-31 23:42:44', '2025-08-31 23:42:44'),
(252, 66, NULL, NULL, 934.00, 'gcash', '2025-09-13 03:42:44', '2025-09-13 03:42:44'),
(253, 69, NULL, NULL, 2966.00, 'gcash', '2025-09-01 00:42:44', '2025-09-01 00:42:44'),
(254, 102, NULL, NULL, 519.00, 'cash', '2025-09-09 03:42:44', '2025-09-09 03:42:44'),
(255, 10, NULL, NULL, 2566.00, 'gcash', '2025-09-01 01:42:44', '2025-09-01 01:42:44'),
(256, 123, NULL, NULL, 1863.00, 'gcash', '2025-09-05 01:42:44', '2025-09-05 01:42:44'),
(257, 42, NULL, NULL, 2603.00, 'card', '2025-09-18 22:42:44', '2025-09-18 22:42:44'),
(258, 39, NULL, NULL, 1307.00, 'gcash', '2025-09-09 03:42:44', '2025-09-09 03:42:44'),
(259, 33, NULL, NULL, 1385.00, 'gcash', '2025-09-14 23:42:44', '2025-09-14 23:42:44'),
(260, 18, NULL, NULL, 2817.00, 'gcash', '2025-09-07 21:42:44', '2025-09-07 21:42:44'),
(261, 107, NULL, NULL, 2304.00, 'card', '2025-09-01 02:42:44', '2025-09-01 02:42:44'),
(262, 97, NULL, NULL, 2471.00, 'card', '2025-09-13 21:42:44', '2025-09-13 21:42:44'),
(263, 28, NULL, NULL, 1639.00, 'gcash', '2025-09-04 01:42:44', '2025-09-04 01:42:44'),
(264, 80, NULL, NULL, 1245.00, 'card', '2025-09-17 23:42:44', '2025-09-17 23:42:44'),
(265, 9, NULL, NULL, 2263.00, 'gcash', '2025-09-05 21:42:44', '2025-09-05 21:42:44'),
(266, 10, NULL, NULL, 1858.00, 'cash', '2025-09-09 23:42:44', '2025-09-09 23:42:44'),
(267, 2, NULL, NULL, 2396.00, 'cash', '2025-08-27 19:42:44', '2025-08-27 19:42:44'),
(268, 102, NULL, NULL, 2371.00, 'cash', '2025-09-14 19:42:44', '2025-09-14 19:42:44'),
(269, 126, 1, NULL, 1647.00, 'cash', '2025-10-13 03:42:44', '2025-10-13 03:42:44'),
(270, 63, 1, NULL, 2650.00, 'card', '2025-10-07 23:42:44', '2025-10-07 23:42:44'),
(271, 3, 1, NULL, 2266.00, 'cash', '2025-10-12 03:42:44', '2025-10-12 03:42:44'),
(272, 106, 1, NULL, 1124.00, 'cash', '2025-10-16 03:42:44', '2025-10-16 03:42:44'),
(273, 17, 1, NULL, 884.00, 'card', '2025-10-19 00:42:44', '2025-10-19 00:42:44'),
(274, 61, 1, NULL, 2563.00, 'card', '2025-10-14 01:42:44', '2025-10-14 01:42:44'),
(275, 91, 1, NULL, 2066.00, 'gcash', '2025-10-21 00:42:44', '2025-10-21 00:42:44'),
(276, 81, 2, NULL, 862.00, 'gcash', '2025-10-04 22:42:44', '2025-10-04 22:42:44'),
(277, 10, 2, NULL, 2068.00, 'gcash', '2025-10-16 22:42:44', '2025-10-16 22:42:44'),
(278, 98, 2, NULL, 2148.00, 'cash', '2025-10-19 22:42:44', '2025-10-19 22:42:44'),
(279, 25, 2, NULL, 945.00, 'card', '2025-10-19 19:42:44', '2025-10-19 19:42:44'),
(280, 117, 2, NULL, 1653.00, 'card', '2025-10-25 02:42:44', '2025-10-25 02:42:44'),
(281, 19, 2, NULL, 2997.00, 'cash', '2025-10-06 23:42:44', '2025-10-06 23:42:44'),
(282, 73, 2, NULL, 744.00, 'card', '2025-10-04 02:42:44', '2025-10-04 02:42:44'),
(283, 18, 2, NULL, 1147.00, 'card', '2025-10-13 02:42:44', '2025-10-13 02:42:44'),
(284, 80, 2, NULL, 2157.00, 'cash', '2025-10-25 00:42:44', '2025-10-25 00:42:44'),
(285, 22, 2, NULL, 1260.00, 'card', '2025-10-18 02:42:44', '2025-10-18 02:42:44'),
(286, 50, 2, NULL, 1217.00, 'gcash', '2025-10-05 22:42:44', '2025-10-05 22:42:44'),
(287, 2, NULL, NULL, 1981.00, 'gcash', '2025-09-30 22:42:44', '2025-09-30 22:42:44'),
(288, 42, NULL, NULL, 1901.00, 'card', '2025-10-04 00:42:44', '2025-10-04 00:42:44'),
(289, 92, NULL, NULL, 2199.00, 'gcash', '2025-09-28 21:42:44', '2025-09-28 21:42:44'),
(290, 11, NULL, NULL, 570.00, 'gcash', '2025-10-23 21:42:44', '2025-10-23 21:42:44'),
(291, 46, NULL, NULL, 931.00, 'gcash', '2025-09-28 20:42:44', '2025-09-28 20:42:44'),
(292, 76, NULL, NULL, 2905.00, 'card', '2025-09-29 01:42:44', '2025-09-29 01:42:44'),
(293, 46, NULL, NULL, 2891.00, 'gcash', '2025-10-02 02:42:44', '2025-10-02 02:42:44'),
(294, 72, NULL, NULL, 1161.00, 'cash', '2025-09-29 19:42:44', '2025-09-29 19:42:44'),
(295, 124, NULL, NULL, 1027.00, 'gcash', '2025-10-13 23:42:44', '2025-10-13 23:42:44'),
(296, 79, NULL, NULL, 952.00, 'cash', '2025-10-06 21:42:44', '2025-10-06 21:42:44'),
(297, 127, NULL, NULL, 796.00, 'cash', '2025-10-23 20:42:44', '2025-10-23 20:42:44'),
(298, 43, NULL, NULL, 2112.00, 'cash', '2025-09-30 22:42:44', '2025-09-30 22:42:44'),
(299, 119, NULL, NULL, 1058.00, 'gcash', '2025-10-23 22:42:44', '2025-10-23 22:42:44'),
(300, 31, NULL, NULL, 2287.00, 'card', '2025-10-25 01:42:44', '2025-10-25 01:42:44'),
(301, 12, NULL, NULL, 1432.00, 'gcash', '2025-10-17 22:42:44', '2025-10-17 22:42:44'),
(302, 108, NULL, NULL, 1878.00, 'gcash', '2025-10-22 22:42:44', '2025-10-22 22:42:44'),
(303, 70, NULL, NULL, 2670.00, 'gcash', '2025-10-02 00:42:44', '2025-10-02 00:42:44'),
(304, 110, NULL, NULL, 762.00, 'gcash', '2025-10-11 02:42:44', '2025-10-11 02:42:44'),
(305, 93, NULL, NULL, 2966.00, 'card', '2025-10-18 01:42:44', '2025-10-18 01:42:44'),
(306, 86, NULL, NULL, 1086.00, 'card', '2025-10-24 01:42:44', '2025-10-24 01:42:44'),
(307, 25, NULL, NULL, 1787.00, 'card', '2025-10-18 00:42:44', '2025-10-18 00:42:44'),
(308, 18, NULL, NULL, 1624.00, 'gcash', '2025-10-14 03:42:44', '2025-10-14 03:42:44'),
(309, 61, NULL, NULL, 2238.00, 'cash', '2025-10-04 01:42:44', '2025-10-04 01:42:44'),
(310, 3, NULL, NULL, 2871.00, 'cash', '2025-10-19 02:42:44', '2025-10-19 02:42:44'),
(311, 73, NULL, NULL, 568.00, 'card', '2025-10-12 20:42:44', '2025-10-12 20:42:44'),
(312, 55, NULL, NULL, 1104.00, 'card', '2025-10-21 22:42:44', '2025-10-21 22:42:44'),
(313, 38, NULL, NULL, 2895.00, 'card', '2025-09-29 22:42:44', '2025-09-29 22:42:44'),
(314, 81, NULL, NULL, 1207.00, 'card', '2025-10-17 00:42:44', '2025-10-17 00:42:44'),
(315, 30, NULL, NULL, 2927.00, 'cash', '2025-09-30 20:42:44', '2025-09-30 20:42:44'),
(316, 97, 1, NULL, 2505.00, 'cash', '2025-05-10 02:42:50', '2025-05-10 02:42:50'),
(317, 19, 1, NULL, 2242.00, 'cash', '2025-05-08 03:42:50', '2025-05-08 03:42:50'),
(318, 39, 1, NULL, 2958.00, 'gcash', '2025-05-18 00:42:50', '2025-05-18 00:42:50'),
(319, 51, 1, NULL, 2460.00, 'cash', '2025-05-19 01:42:50', '2025-05-19 01:42:50'),
(320, 18, 1, NULL, 2182.00, 'card', '2025-05-07 02:42:50', '2025-05-07 02:42:50'),
(321, 108, 1, NULL, 2534.00, 'cash', '2025-05-13 03:42:50', '2025-05-13 03:42:50'),
(322, 102, 1, NULL, 2477.00, 'gcash', '2025-05-11 01:42:50', '2025-05-11 01:42:50'),
(323, 4, 1, NULL, 1329.00, 'cash', '2025-05-12 23:42:50', '2025-05-12 23:42:50'),
(324, 70, 2, NULL, 1928.00, 'card', '2025-05-06 20:42:50', '2025-05-06 20:42:50'),
(325, 27, 2, NULL, 1246.00, 'gcash', '2025-05-21 21:42:50', '2025-05-21 21:42:50'),
(326, 59, 2, NULL, 1617.00, 'gcash', '2025-05-23 00:42:50', '2025-05-23 00:42:50'),
(327, 105, 2, NULL, 2184.00, 'cash', '2025-05-11 23:42:50', '2025-05-11 23:42:50'),
(328, 23, 2, NULL, 771.00, 'cash', '2025-05-06 19:42:50', '2025-05-06 19:42:50'),
(329, 14, 2, NULL, 2611.00, 'gcash', '2025-05-13 03:42:50', '2025-05-13 03:42:50'),
(330, 75, 2, NULL, 1698.00, 'cash', '2025-05-10 21:42:50', '2025-05-10 21:42:50'),
(331, 124, 2, NULL, 659.00, 'card', '2025-05-22 03:42:50', '2025-05-22 03:42:50'),
(332, 64, 2, NULL, 791.00, 'gcash', '2025-05-17 03:42:50', '2025-05-17 03:42:50'),
(333, 68, 2, NULL, 2315.00, 'cash', '2025-05-04 19:42:50', '2025-05-04 19:42:50'),
(334, 118, 2, NULL, 630.00, 'card', '2025-04-28 03:42:50', '2025-04-28 03:42:50'),
(335, 93, NULL, NULL, 1113.00, 'card', '2025-05-13 02:42:50', '2025-05-13 02:42:50'),
(336, 65, NULL, NULL, 2161.00, 'card', '2025-05-23 20:42:50', '2025-05-23 20:42:50'),
(337, 17, NULL, NULL, 2013.00, 'gcash', '2025-05-25 03:42:50', '2025-05-25 03:42:50'),
(338, 52, NULL, NULL, 1050.00, 'card', '2025-04-27 21:42:50', '2025-04-27 21:42:50'),
(339, 70, NULL, NULL, 1592.00, 'cash', '2025-05-03 23:42:50', '2025-05-03 23:42:50'),
(340, 53, NULL, NULL, 2360.00, 'card', '2025-05-22 00:42:50', '2025-05-22 00:42:50'),
(341, 81, NULL, NULL, 2007.00, 'card', '2025-05-20 01:42:50', '2025-05-20 01:42:50'),
(342, 35, NULL, NULL, 2979.00, 'gcash', '2025-05-09 02:42:50', '2025-05-09 02:42:50'),
(343, 7, NULL, NULL, 1718.00, 'cash', '2025-05-03 00:42:50', '2025-05-03 00:42:50'),
(344, 69, NULL, NULL, 1469.00, 'cash', '2025-05-11 00:42:50', '2025-05-11 00:42:50'),
(345, 21, NULL, NULL, 2510.00, 'gcash', '2025-05-10 02:42:50', '2025-05-10 02:42:50'),
(346, 117, NULL, NULL, 611.00, 'cash', '2025-05-16 01:42:50', '2025-05-16 01:42:50'),
(347, 16, NULL, NULL, 813.00, 'card', '2025-05-20 23:42:50', '2025-05-20 23:42:50'),
(348, 121, NULL, NULL, 2219.00, 'card', '2025-05-04 20:42:50', '2025-05-04 20:42:50'),
(349, 51, NULL, NULL, 753.00, 'cash', '2025-05-07 02:42:50', '2025-05-07 02:42:50'),
(350, 125, NULL, NULL, 1323.00, 'card', '2025-05-12 01:42:50', '2025-05-12 01:42:50'),
(351, 102, NULL, NULL, 1858.00, 'gcash', '2025-05-13 21:42:50', '2025-05-13 21:42:50'),
(352, 110, NULL, NULL, 2337.00, 'cash', '2025-05-20 03:42:50', '2025-05-20 03:42:50'),
(353, 55, NULL, NULL, 2747.00, 'cash', '2025-05-21 19:42:50', '2025-05-21 19:42:50'),
(354, 15, NULL, NULL, 1096.00, 'cash', '2025-05-01 19:42:50', '2025-05-01 19:42:50'),
(355, 37, NULL, NULL, 1081.00, 'gcash', '2025-05-25 00:42:50', '2025-05-25 00:42:50'),
(356, 28, NULL, NULL, 2438.00, 'card', '2025-05-15 21:42:50', '2025-05-15 21:42:50'),
(357, 98, NULL, NULL, 1743.00, 'gcash', '2025-05-11 20:42:50', '2025-05-11 20:42:50'),
(358, 13, NULL, NULL, 1316.00, 'card', '2025-05-22 03:42:50', '2025-05-22 03:42:50'),
(359, 75, NULL, NULL, 1667.00, 'gcash', '2025-05-18 00:42:50', '2025-05-18 00:42:50'),
(360, 89, NULL, NULL, 1391.00, 'cash', '2025-05-20 21:42:50', '2025-05-20 21:42:50'),
(361, 125, NULL, NULL, 1003.00, 'cash', '2025-05-08 19:42:50', '2025-05-08 19:42:50'),
(362, 74, NULL, NULL, 1814.00, 'card', '2025-05-23 23:42:50', '2025-05-23 23:42:50'),
(363, 15, NULL, NULL, 1620.00, 'cash', '2025-05-16 02:42:50', '2025-05-16 02:42:50'),
(364, 1, NULL, NULL, 2885.00, 'cash', '2025-05-16 19:42:50', '2025-05-16 19:42:50'),
(365, 86, NULL, NULL, 1558.00, 'gcash', '2025-05-14 01:42:50', '2025-05-14 01:42:50'),
(366, 125, NULL, NULL, 1791.00, 'card', '2025-05-23 00:42:50', '2025-05-23 00:42:50'),
(367, 122, NULL, NULL, 2713.00, 'card', '2025-05-06 23:42:50', '2025-05-06 23:42:50'),
(368, 5, NULL, NULL, 1092.00, 'gcash', '2025-04-30 02:42:50', '2025-04-30 02:42:50'),
(369, 117, NULL, NULL, 1207.00, 'cash', '2025-05-20 03:42:50', '2025-05-20 03:42:50'),
(370, 55, NULL, NULL, 2513.00, 'card', '2025-05-08 20:42:50', '2025-05-08 20:42:50'),
(371, 7, NULL, NULL, 2084.00, 'gcash', '2025-05-01 19:42:50', '2025-05-01 19:42:50'),
(372, 108, NULL, NULL, 938.00, 'card', '2025-05-03 20:42:50', '2025-05-03 20:42:50'),
(373, 29, NULL, NULL, 2679.00, 'gcash', '2025-05-06 02:42:50', '2025-05-06 02:42:50'),
(374, 64, 1, NULL, 1976.00, 'cash', '2025-06-09 01:42:51', '2025-06-09 01:42:51'),
(375, 71, 1, NULL, 2863.00, 'card', '2025-05-31 03:42:51', '2025-05-31 03:42:51'),
(376, 91, 1, NULL, 2972.00, 'card', '2025-06-04 20:42:51', '2025-06-04 20:42:51'),
(377, 113, 1, NULL, 1830.00, 'gcash', '2025-06-14 02:42:51', '2025-06-14 02:42:51'),
(378, 81, 1, NULL, 705.00, 'gcash', '2025-05-28 19:42:51', '2025-05-28 19:42:51'),
(379, 81, 1, NULL, 1282.00, 'cash', '2025-06-10 21:42:51', '2025-06-10 21:42:51'),
(380, 97, 1, NULL, 2331.00, 'card', '2025-06-13 03:42:51', '2025-06-13 03:42:51'),
(381, 93, 1, NULL, 1060.00, 'cash', '2025-06-11 19:42:51', '2025-06-11 19:42:51'),
(382, 102, 1, NULL, 1186.00, 'gcash', '2025-06-15 02:42:51', '2025-06-15 02:42:51'),
(383, 106, 1, NULL, 1103.00, 'card', '2025-06-06 02:42:51', '2025-06-06 02:42:51'),
(384, 50, 1, NULL, 1181.00, 'cash', '2025-06-15 21:42:51', '2025-06-15 21:42:51'),
(385, 107, 1, NULL, 871.00, 'cash', '2025-06-01 22:42:51', '2025-06-01 22:42:51'),
(386, 64, 2, NULL, 605.00, 'gcash', '2025-06-05 21:42:51', '2025-06-05 21:42:51'),
(387, 21, 2, NULL, 2170.00, 'gcash', '2025-05-31 02:42:51', '2025-05-31 02:42:51'),
(388, 20, 2, NULL, 2992.00, 'gcash', '2025-06-21 02:42:51', '2025-06-21 02:42:51'),
(389, 42, 2, NULL, 2172.00, 'cash', '2025-06-02 01:42:51', '2025-06-02 01:42:51'),
(390, 62, 2, NULL, 808.00, 'cash', '2025-05-30 19:42:51', '2025-05-30 19:42:51'),
(391, 25, 2, NULL, 1836.00, 'gcash', '2025-06-21 00:42:51', '2025-06-21 00:42:51'),
(392, 48, 2, NULL, 962.00, 'cash', '2025-05-31 00:42:51', '2025-05-31 00:42:51'),
(393, 3, 2, NULL, 1679.00, 'cash', '2025-06-19 01:42:51', '2025-06-19 01:42:51'),
(394, 30, NULL, NULL, 940.00, 'cash', '2025-05-28 01:42:51', '2025-05-28 01:42:51'),
(395, 102, NULL, NULL, 1280.00, 'cash', '2025-06-19 01:42:51', '2025-06-19 01:42:51'),
(396, 117, NULL, NULL, 2439.00, 'cash', '2025-06-14 19:42:51', '2025-06-14 19:42:51'),
(397, 89, NULL, NULL, 2824.00, 'gcash', '2025-06-02 03:42:51', '2025-06-02 03:42:51'),
(398, 45, NULL, NULL, 2169.00, 'card', '2025-05-28 23:42:51', '2025-05-28 23:42:51'),
(399, 76, NULL, NULL, 1481.00, 'gcash', '2025-05-31 20:42:51', '2025-05-31 20:42:51'),
(400, 54, NULL, NULL, 968.00, 'gcash', '2025-06-05 22:42:51', '2025-06-05 22:42:51'),
(401, 89, NULL, NULL, 2741.00, 'cash', '2025-06-04 02:42:51', '2025-06-04 02:42:51'),
(402, 26, NULL, NULL, 826.00, 'card', '2025-06-05 23:42:51', '2025-06-05 23:42:51'),
(403, 2, NULL, NULL, 2345.00, 'gcash', '2025-06-07 03:42:51', '2025-06-07 03:42:51'),
(404, 1, NULL, NULL, 1418.00, 'cash', '2025-06-09 02:42:51', '2025-06-09 02:42:51'),
(405, 36, NULL, NULL, 955.00, 'cash', '2025-06-12 19:42:51', '2025-06-12 19:42:51'),
(406, 126, NULL, NULL, 2881.00, 'cash', '2025-06-14 22:42:51', '2025-06-14 22:42:51'),
(407, 72, NULL, NULL, 2114.00, 'cash', '2025-06-23 03:42:51', '2025-06-23 03:42:51'),
(408, 18, NULL, NULL, 2187.00, 'card', '2025-06-03 21:42:51', '2025-06-03 21:42:51'),
(409, 99, NULL, NULL, 1493.00, 'cash', '2025-06-08 19:42:51', '2025-06-08 19:42:51'),
(410, 4, NULL, NULL, 1854.00, 'cash', '2025-06-04 23:42:51', '2025-06-04 23:42:51'),
(411, 104, NULL, NULL, 1573.00, 'card', '2025-06-10 23:42:51', '2025-06-10 23:42:51'),
(412, 100, NULL, NULL, 885.00, 'card', '2025-06-02 23:42:51', '2025-06-02 23:42:51'),
(413, 77, NULL, NULL, 2139.00, 'gcash', '2025-06-14 03:42:51', '2025-06-14 03:42:51'),
(414, 42, NULL, NULL, 714.00, 'cash', '2025-06-10 03:42:51', '2025-06-10 03:42:51'),
(415, 25, NULL, NULL, 1228.00, 'card', '2025-06-08 02:42:51', '2025-06-08 02:42:51'),
(416, 107, NULL, NULL, 525.00, 'gcash', '2025-06-16 02:42:51', '2025-06-16 02:42:51'),
(417, 3, NULL, NULL, 968.00, 'cash', '2025-06-18 19:42:51', '2025-06-18 19:42:51'),
(418, 26, NULL, NULL, 1238.00, 'cash', '2025-06-16 23:42:51', '2025-06-16 23:42:51'),
(419, 62, NULL, NULL, 1373.00, 'card', '2025-06-04 01:42:51', '2025-06-04 01:42:51'),
(420, 18, NULL, NULL, 1284.00, 'cash', '2025-06-23 03:42:51', '2025-06-23 03:42:51'),
(421, 81, NULL, NULL, 546.00, 'card', '2025-05-27 19:42:51', '2025-05-27 19:42:51'),
(422, 89, NULL, NULL, 2222.00, 'cash', '2025-06-15 19:42:51', '2025-06-15 19:42:51'),
(423, 109, NULL, NULL, 2985.00, 'cash', '2025-06-08 03:42:51', '2025-06-08 03:42:51'),
(424, 14, NULL, NULL, 784.00, 'card', '2025-06-22 02:42:51', '2025-06-22 02:42:51'),
(425, 20, NULL, NULL, 2283.00, 'cash', '2025-06-13 00:42:51', '2025-06-13 00:42:51'),
(426, 73, NULL, NULL, 657.00, 'card', '2025-05-29 00:42:51', '2025-05-29 00:42:51'),
(427, 107, NULL, NULL, 2972.00, 'card', '2025-06-08 21:42:51', '2025-06-08 21:42:51'),
(428, 20, NULL, NULL, 734.00, 'gcash', '2025-06-05 00:42:51', '2025-06-05 00:42:51'),
(429, 60, NULL, NULL, 1173.00, 'gcash', '2025-06-07 19:42:51', '2025-06-07 19:42:51'),
(430, 89, 1, NULL, 1244.00, 'gcash', '2025-07-08 22:42:51', '2025-07-08 22:42:51'),
(431, 116, 1, NULL, 1967.00, 'gcash', '2025-07-05 21:42:51', '2025-07-05 21:42:51'),
(432, 57, 1, NULL, 892.00, 'card', '2025-07-09 22:42:51', '2025-07-09 22:42:51'),
(433, 5, 1, NULL, 2773.00, 'gcash', '2025-06-29 21:42:51', '2025-06-29 21:42:51'),
(434, 118, 1, NULL, 2083.00, 'card', '2025-07-20 21:42:51', '2025-07-20 21:42:51'),
(435, 21, 1, NULL, 2389.00, 'gcash', '2025-07-24 19:42:51', '2025-07-24 19:42:51'),
(436, 99, 1, NULL, 1992.00, 'card', '2025-06-30 03:42:51', '2025-06-30 03:42:51'),
(437, 24, 1, NULL, 1398.00, 'card', '2025-07-11 21:42:51', '2025-07-11 21:42:51'),
(438, 111, 1, NULL, 2646.00, 'gcash', '2025-07-17 19:42:51', '2025-07-17 19:42:51'),
(439, 47, 1, NULL, 2117.00, 'gcash', '2025-07-15 01:42:51', '2025-07-15 01:42:51'),
(440, 126, 1, NULL, 2142.00, 'card', '2025-06-29 22:42:51', '2025-06-29 22:42:51'),
(441, 102, 1, NULL, 581.00, 'gcash', '2025-06-29 01:42:51', '2025-06-29 01:42:51'),
(442, 56, 1, NULL, 1652.00, 'cash', '2025-07-18 00:42:51', '2025-07-18 00:42:51'),
(443, 13, 1, NULL, 616.00, 'card', '2025-07-25 00:42:51', '2025-07-25 00:42:51'),
(444, 66, 2, NULL, 1051.00, 'gcash', '2025-07-04 21:42:51', '2025-07-04 21:42:51'),
(445, 48, 2, NULL, 2422.00, 'card', '2025-07-02 20:42:51', '2025-07-02 20:42:51'),
(446, 110, 2, NULL, 1790.00, 'card', '2025-07-02 00:42:51', '2025-07-02 00:42:51'),
(447, 82, 2, NULL, 1515.00, 'gcash', '2025-07-17 03:42:51', '2025-07-17 03:42:51'),
(448, 26, 2, NULL, 2035.00, 'cash', '2025-07-04 00:42:51', '2025-07-04 00:42:51'),
(449, 8, 2, NULL, 2826.00, 'gcash', '2025-07-12 03:42:51', '2025-07-12 03:42:51'),
(450, 16, 2, NULL, 1293.00, 'gcash', '2025-07-06 03:42:51', '2025-07-06 03:42:51'),
(451, 70, 2, NULL, 2515.00, 'cash', '2025-07-21 20:42:51', '2025-07-21 20:42:51'),
(452, 123, 2, NULL, 2353.00, 'cash', '2025-07-21 20:42:51', '2025-07-21 20:42:51'),
(453, 79, NULL, NULL, 1990.00, 'cash', '2025-07-05 01:42:51', '2025-07-05 01:42:51'),
(454, 26, NULL, NULL, 1236.00, 'gcash', '2025-06-30 01:42:51', '2025-06-30 01:42:51'),
(455, 120, NULL, NULL, 1560.00, 'gcash', '2025-07-10 20:42:51', '2025-07-10 20:42:51'),
(456, 91, NULL, NULL, 1739.00, 'cash', '2025-07-21 20:42:51', '2025-07-21 20:42:51'),
(457, 85, NULL, NULL, 2075.00, 'cash', '2025-07-20 23:42:51', '2025-07-20 23:42:51'),
(458, 44, NULL, NULL, 2660.00, 'card', '2025-07-08 03:42:51', '2025-07-08 03:42:51'),
(459, 120, NULL, NULL, 2616.00, 'cash', '2025-07-07 02:42:51', '2025-07-07 02:42:51'),
(460, 18, NULL, NULL, 630.00, 'gcash', '2025-07-10 19:42:51', '2025-07-10 19:42:51'),
(461, 124, NULL, NULL, 1673.00, 'cash', '2025-06-28 23:42:51', '2025-06-28 23:42:51'),
(462, 49, NULL, NULL, 2408.00, 'gcash', '2025-07-07 22:42:51', '2025-07-07 22:42:51'),
(463, 17, NULL, NULL, 2375.00, 'gcash', '2025-07-23 00:42:51', '2025-07-23 00:42:51'),
(464, 116, NULL, NULL, 901.00, 'gcash', '2025-07-23 00:42:51', '2025-07-23 00:42:51'),
(465, 41, NULL, NULL, 1802.00, 'cash', '2025-06-29 02:42:51', '2025-06-29 02:42:51'),
(466, 64, NULL, NULL, 1985.00, 'gcash', '2025-06-28 00:42:51', '2025-06-28 00:42:51'),
(467, 65, NULL, NULL, 2356.00, 'card', '2025-07-08 23:42:51', '2025-07-08 23:42:51'),
(468, 104, NULL, NULL, 2597.00, 'card', '2025-07-07 03:42:51', '2025-07-07 03:42:51'),
(469, 43, NULL, NULL, 2066.00, 'card', '2025-07-01 03:42:51', '2025-07-01 03:42:51'),
(470, 107, NULL, NULL, 762.00, 'card', '2025-07-15 00:42:51', '2025-07-15 00:42:51'),
(471, 100, NULL, NULL, 1025.00, 'gcash', '2025-07-11 19:42:51', '2025-07-11 19:42:51'),
(472, 59, NULL, NULL, 1235.00, 'card', '2025-07-01 00:42:51', '2025-07-01 00:42:51'),
(473, 112, NULL, NULL, 2110.00, 'card', '2025-07-02 03:42:51', '2025-07-02 03:42:51'),
(474, 19, NULL, NULL, 2637.00, 'gcash', '2025-07-05 20:42:51', '2025-07-05 20:42:51'),
(475, 4, NULL, NULL, 2913.00, 'card', '2025-07-07 03:42:51', '2025-07-07 03:42:51'),
(476, 20, NULL, NULL, 2265.00, 'card', '2025-07-14 00:42:51', '2025-07-14 00:42:51'),
(477, 25, NULL, NULL, 921.00, 'gcash', '2025-07-07 00:42:51', '2025-07-07 00:42:51'),
(478, 56, NULL, NULL, 2056.00, 'card', '2025-07-21 00:42:51', '2025-07-21 00:42:51'),
(479, 68, NULL, NULL, 2012.00, 'gcash', '2025-07-09 20:42:51', '2025-07-09 20:42:51'),
(480, 88, NULL, NULL, 1341.00, 'card', '2025-07-05 20:42:51', '2025-07-05 20:42:51'),
(481, 114, NULL, NULL, 1450.00, 'gcash', '2025-07-24 19:42:51', '2025-07-24 19:42:51'),
(482, 63, 1, NULL, 1322.00, 'cash', '2025-08-08 03:42:51', '2025-08-08 03:42:51'),
(483, 46, 1, NULL, 1460.00, 'card', '2025-08-14 01:42:51', '2025-08-14 01:42:51'),
(484, 90, 1, NULL, 722.00, 'gcash', '2025-08-18 03:42:51', '2025-08-18 03:42:51'),
(485, 125, 1, NULL, 1424.00, 'cash', '2025-07-28 20:42:51', '2025-07-28 20:42:51'),
(486, 17, 1, NULL, 2463.00, 'gcash', '2025-08-10 20:42:51', '2025-08-10 20:42:51'),
(487, 77, 1, NULL, 2498.00, 'cash', '2025-08-22 01:42:51', '2025-08-22 01:42:51'),
(488, 49, 1, NULL, 2956.00, 'gcash', '2025-07-27 23:42:51', '2025-07-27 23:42:51'),
(489, 105, 2, NULL, 2621.00, 'cash', '2025-07-28 23:42:51', '2025-07-28 23:42:51'),
(490, 108, 2, NULL, 1118.00, 'cash', '2025-08-19 00:42:51', '2025-08-19 00:42:51'),
(491, 6, 2, NULL, 2185.00, 'card', '2025-08-03 23:42:51', '2025-08-03 23:42:51'),
(492, 66, 2, NULL, 1033.00, 'gcash', '2025-08-03 20:42:51', '2025-08-03 20:42:51'),
(493, 5, 2, NULL, 2922.00, 'cash', '2025-08-14 01:42:51', '2025-08-14 01:42:51'),
(494, 93, 2, NULL, 2993.00, 'gcash', '2025-08-17 21:42:51', '2025-08-17 21:42:51'),
(495, 117, 2, NULL, 1179.00, 'card', '2025-08-23 23:42:51', '2025-08-23 23:42:51'),
(496, 106, 2, NULL, 771.00, 'card', '2025-08-15 21:42:51', '2025-08-15 21:42:51'),
(497, 19, NULL, NULL, 792.00, 'gcash', '2025-07-29 00:42:51', '2025-07-29 00:42:51'),
(498, 93, NULL, NULL, 2961.00, 'cash', '2025-08-11 20:42:51', '2025-08-11 20:42:51'),
(499, 12, NULL, NULL, 2377.00, 'gcash', '2025-08-24 00:42:51', '2025-08-24 00:42:51'),
(500, 69, NULL, NULL, 1319.00, 'card', '2025-08-03 02:42:51', '2025-08-03 02:42:51'),
(501, 64, NULL, NULL, 1387.00, 'card', '2025-08-03 19:42:51', '2025-08-03 19:42:51'),
(502, 54, NULL, NULL, 1040.00, 'gcash', '2025-08-11 03:42:51', '2025-08-11 03:42:51'),
(503, 119, NULL, NULL, 544.00, 'cash', '2025-08-10 02:42:51', '2025-08-10 02:42:51'),
(504, 86, NULL, NULL, 1456.00, 'gcash', '2025-08-05 21:42:51', '2025-08-05 21:42:51'),
(505, 97, NULL, NULL, 2148.00, 'gcash', '2025-08-18 21:42:51', '2025-08-18 21:42:51'),
(506, 108, NULL, NULL, 1702.00, 'card', '2025-08-10 03:42:51', '2025-08-10 03:42:51'),
(507, 53, NULL, NULL, 1114.00, 'cash', '2025-08-12 01:42:51', '2025-08-12 01:42:51'),
(508, 31, NULL, NULL, 2780.00, 'cash', '2025-08-19 19:42:51', '2025-08-19 19:42:51'),
(509, 7, NULL, NULL, 1723.00, 'cash', '2025-08-09 21:42:51', '2025-08-09 21:42:51'),
(510, 59, NULL, NULL, 1678.00, 'card', '2025-08-23 23:42:51', '2025-08-23 23:42:51'),
(511, 58, NULL, NULL, 2788.00, 'card', '2025-08-03 19:42:51', '2025-08-03 19:42:51'),
(512, 98, NULL, NULL, 2659.00, 'cash', '2025-08-08 19:42:51', '2025-08-08 19:42:51'),
(513, 19, NULL, NULL, 963.00, 'card', '2025-07-28 22:42:51', '2025-07-28 22:42:51'),
(514, 63, NULL, NULL, 2414.00, 'cash', '2025-08-18 22:42:51', '2025-08-18 22:42:51'),
(515, 86, NULL, NULL, 512.00, 'cash', '2025-08-21 19:42:51', '2025-08-21 19:42:51'),
(516, 58, NULL, NULL, 2005.00, 'gcash', '2025-07-30 00:42:51', '2025-07-30 00:42:51'),
(517, 80, NULL, NULL, 2551.00, 'cash', '2025-08-16 21:42:51', '2025-08-16 21:42:51'),
(518, 107, NULL, NULL, 2702.00, 'card', '2025-08-17 03:42:51', '2025-08-17 03:42:51'),
(519, 64, NULL, NULL, 2640.00, 'cash', '2025-08-07 03:42:51', '2025-08-07 03:42:51'),
(520, 70, NULL, NULL, 2300.00, 'cash', '2025-08-12 20:42:51', '2025-08-12 20:42:51'),
(521, 32, NULL, NULL, 2824.00, 'card', '2025-08-10 23:42:51', '2025-08-10 23:42:51'),
(522, 78, 1, NULL, 2731.00, 'card', '2025-09-05 19:42:51', '2025-09-05 19:42:51'),
(523, 50, 1, NULL, 609.00, 'card', '2025-09-15 19:42:51', '2025-09-15 19:42:51'),
(524, 10, 1, NULL, 1053.00, 'card', '2025-09-23 02:42:51', '2025-09-23 02:42:51'),
(525, 106, 1, NULL, 618.00, 'cash', '2025-09-22 02:42:51', '2025-09-22 02:42:51'),
(526, 24, 1, NULL, 1817.00, 'card', '2025-09-07 03:42:51', '2025-09-07 03:42:51'),
(527, 43, 1, NULL, 1911.00, 'card', '2025-09-01 20:42:51', '2025-09-01 20:42:51'),
(528, 120, 1, NULL, 2828.00, 'cash', '2025-09-19 23:42:51', '2025-09-19 23:42:51'),
(529, 60, 1, NULL, 2908.00, 'cash', '2025-09-18 02:42:51', '2025-09-18 02:42:51'),
(530, 37, 1, NULL, 2111.00, 'cash', '2025-09-22 20:42:51', '2025-09-22 20:42:51'),
(531, 50, 1, NULL, 1203.00, 'card', '2025-09-14 19:42:51', '2025-09-14 19:42:51'),
(532, 83, 2, NULL, 2282.00, 'cash', '2025-09-13 02:42:51', '2025-09-13 02:42:51'),
(533, 20, 2, NULL, 2035.00, 'gcash', '2025-09-11 00:42:51', '2025-09-11 00:42:51'),
(534, 66, 2, NULL, 2199.00, 'card', '2025-09-23 00:42:51', '2025-09-23 00:42:51'),
(535, 44, 2, NULL, 566.00, 'card', '2025-09-06 03:42:51', '2025-09-06 03:42:51'),
(536, 103, 2, NULL, 1089.00, 'gcash', '2025-09-23 01:42:51', '2025-09-23 01:42:51'),
(537, 52, 2, NULL, 2900.00, 'card', '2025-09-23 03:42:51', '2025-09-23 03:42:51'),
(538, 116, 2, NULL, 2478.00, 'cash', '2025-09-14 01:42:51', '2025-09-14 01:42:51'),
(539, 90, NULL, NULL, 1627.00, 'gcash', '2025-09-13 01:42:51', '2025-09-13 01:42:51'),
(540, 17, NULL, NULL, 1147.00, 'gcash', '2025-09-14 02:42:51', '2025-09-14 02:42:51'),
(541, 76, NULL, NULL, 1686.00, 'gcash', '2025-08-28 20:42:51', '2025-08-28 20:42:51'),
(542, 22, NULL, NULL, 1734.00, 'cash', '2025-09-04 22:42:51', '2025-09-04 22:42:51'),
(543, 40, NULL, NULL, 1182.00, 'gcash', '2025-09-06 03:42:51', '2025-09-06 03:42:51'),
(544, 120, NULL, NULL, 2836.00, 'cash', '2025-09-08 01:42:51', '2025-09-08 01:42:51'),
(545, 119, NULL, NULL, 2582.00, 'gcash', '2025-09-03 03:42:51', '2025-09-03 03:42:51'),
(546, 109, NULL, NULL, 2303.00, 'card', '2025-09-18 21:42:51', '2025-09-18 21:42:51'),
(547, 14, NULL, NULL, 916.00, 'cash', '2025-09-12 21:42:51', '2025-09-12 21:42:51'),
(548, 65, NULL, NULL, 770.00, 'card', '2025-09-07 22:42:51', '2025-09-07 22:42:51'),
(549, 85, NULL, NULL, 2841.00, 'gcash', '2025-09-17 23:42:51', '2025-09-17 23:42:51'),
(550, 92, NULL, NULL, 1358.00, 'gcash', '2025-09-22 20:42:51', '2025-09-22 20:42:51'),
(551, 3, NULL, NULL, 2754.00, 'card', '2025-09-02 20:42:51', '2025-09-02 20:42:51'),
(552, 91, NULL, NULL, 1217.00, 'cash', '2025-09-07 01:42:51', '2025-09-07 01:42:51'),
(553, 23, NULL, NULL, 2930.00, 'cash', '2025-09-17 23:42:51', '2025-09-17 23:42:51'),
(554, 17, NULL, NULL, 1036.00, 'cash', '2025-09-07 23:42:51', '2025-09-07 23:42:51'),
(555, 105, NULL, NULL, 736.00, 'card', '2025-09-22 23:42:51', '2025-09-22 23:42:51'),
(556, 110, NULL, NULL, 1239.00, 'card', '2025-09-19 01:42:51', '2025-09-19 01:42:51'),
(557, 43, NULL, NULL, 1003.00, 'cash', '2025-09-21 00:42:51', '2025-09-21 00:42:51'),
(558, 69, NULL, NULL, 2756.00, 'cash', '2025-09-03 20:42:51', '2025-09-03 20:42:51'),
(559, 75, NULL, NULL, 880.00, 'cash', '2025-09-17 02:42:51', '2025-09-17 02:42:51'),
(560, 123, NULL, NULL, 1996.00, 'gcash', '2025-08-31 19:42:51', '2025-08-31 19:42:51'),
(561, 89, NULL, NULL, 1727.00, 'card', '2025-09-04 02:42:51', '2025-09-04 02:42:51'),
(562, 54, NULL, NULL, 1702.00, 'card', '2025-09-10 03:42:51', '2025-09-10 03:42:51'),
(563, 37, NULL, NULL, 1649.00, 'gcash', '2025-08-28 23:42:51', '2025-08-28 23:42:51'),
(564, 80, NULL, NULL, 1639.00, 'gcash', '2025-08-28 20:42:51', '2025-08-28 20:42:51'),
(565, 32, 1, NULL, 2738.00, 'gcash', '2025-10-02 02:42:51', '2025-10-02 02:42:51'),
(566, 114, 1, NULL, 2675.00, 'cash', '2025-10-08 23:42:51', '2025-10-08 23:42:51'),
(567, 97, 1, NULL, 541.00, 'gcash', '2025-10-09 01:42:51', '2025-10-09 01:42:51'),
(568, 72, 1, NULL, 1072.00, 'cash', '2025-09-27 22:42:51', '2025-09-27 22:42:51'),
(569, 69, 1, NULL, 2066.00, 'cash', '2025-10-03 23:42:51', '2025-10-03 23:42:51'),
(570, 73, 1, NULL, 1467.00, 'gcash', '2025-10-11 21:42:51', '2025-10-11 21:42:51'),
(571, 122, 1, NULL, 1333.00, 'gcash', '2025-10-15 03:42:51', '2025-10-15 03:42:51'),
(572, 28, 1, NULL, 1154.00, 'cash', '2025-10-18 02:42:51', '2025-10-18 02:42:51'),
(573, 116, 1, NULL, 1903.00, 'cash', '2025-10-13 20:42:51', '2025-10-13 20:42:51'),
(574, 37, 1, NULL, 1616.00, 'cash', '2025-10-06 00:42:51', '2025-10-06 00:42:51'),
(575, 62, 1, NULL, 517.00, 'cash', '2025-10-12 20:42:51', '2025-10-12 20:42:51'),
(576, 56, 1, NULL, 1172.00, 'card', '2025-10-13 19:42:51', '2025-10-13 19:42:51'),
(577, 102, 1, NULL, 2291.00, 'cash', '2025-10-05 21:42:51', '2025-10-05 21:42:51'),
(578, 104, 1, NULL, 1925.00, 'gcash', '2025-10-17 02:42:51', '2025-10-17 02:42:51'),
(579, 17, 1, NULL, 1203.00, 'gcash', '2025-10-23 20:42:51', '2025-10-23 20:42:51'),
(580, 13, 2, NULL, 1526.00, 'gcash', '2025-09-28 00:42:51', '2025-09-28 00:42:51'),
(581, 49, 2, NULL, 1943.00, 'gcash', '2025-10-04 19:42:51', '2025-10-04 19:42:51'),
(582, 68, 2, NULL, 2401.00, 'gcash', '2025-10-21 03:42:51', '2025-10-21 03:42:51'),
(583, 86, 2, NULL, 764.00, 'card', '2025-10-23 01:42:51', '2025-10-23 01:42:51'),
(584, 120, 2, NULL, 2960.00, 'card', '2025-10-02 19:42:51', '2025-10-02 19:42:51'),
(585, 111, NULL, NULL, 1894.00, 'gcash', '2025-10-23 03:42:51', '2025-10-23 03:42:51'),
(586, 88, NULL, NULL, 2585.00, 'cash', '2025-09-28 21:42:51', '2025-09-28 21:42:51'),
(587, 31, NULL, NULL, 938.00, 'cash', '2025-10-16 02:42:51', '2025-10-16 02:42:51'),
(588, 104, NULL, NULL, 585.00, 'card', '2025-10-11 19:42:51', '2025-10-11 19:42:51'),
(589, 118, NULL, NULL, 1623.00, 'gcash', '2025-10-16 01:42:51', '2025-10-16 01:42:51'),
(590, 51, NULL, NULL, 1970.00, 'card', '2025-10-08 23:42:51', '2025-10-08 23:42:51'),
(591, 15, NULL, NULL, 1537.00, 'card', '2025-10-16 19:42:51', '2025-10-16 19:42:51'),
(592, 80, NULL, NULL, 858.00, 'gcash', '2025-10-16 03:42:51', '2025-10-16 03:42:51'),
(593, 127, NULL, NULL, 2952.00, 'card', '2025-10-06 01:42:51', '2025-10-06 01:42:51'),
(594, 43, NULL, NULL, 1447.00, 'gcash', '2025-10-21 03:42:51', '2025-10-21 03:42:51'),
(595, 101, NULL, NULL, 1319.00, 'cash', '2025-10-02 22:42:51', '2025-10-02 22:42:51'),
(596, 73, NULL, NULL, 1127.00, 'cash', '2025-10-08 20:42:51', '2025-10-08 20:42:51'),
(597, 29, NULL, NULL, 2264.00, 'cash', '2025-10-12 03:42:51', '2025-10-12 03:42:51'),
(598, 53, NULL, NULL, 1469.00, 'gcash', '2025-10-24 02:42:51', '2025-10-24 02:42:51'),
(599, 74, NULL, NULL, 2007.00, 'card', '2025-10-14 19:42:51', '2025-10-14 19:42:51'),
(600, 62, NULL, NULL, 2150.00, 'cash', '2025-10-04 00:42:51', '2025-10-04 00:42:51'),
(601, 70, NULL, NULL, 2731.00, 'gcash', '2025-10-04 19:42:51', '2025-10-04 19:42:51'),
(602, 86, NULL, NULL, 851.00, 'card', '2025-10-05 21:42:51', '2025-10-05 21:42:51'),
(603, 84, NULL, NULL, 1256.00, 'cash', '2025-10-16 19:42:51', '2025-10-16 19:42:51'),
(604, 126, NULL, NULL, 2817.00, 'gcash', '2025-10-10 02:42:51', '2025-10-10 02:42:51'),
(605, 3, NULL, NULL, 903.00, 'gcash', '2025-10-12 02:42:51', '2025-10-12 02:42:51'),
(606, 17, NULL, NULL, 569.00, 'gcash', '2025-10-03 23:42:51', '2025-10-03 23:42:51'),
(607, 41, NULL, NULL, 2600.00, 'card', '2025-10-06 23:42:51', '2025-10-06 23:42:51'),
(608, 86, NULL, NULL, 546.00, 'card', '2025-10-06 20:42:51', '2025-10-06 20:42:51'),
(609, 120, NULL, NULL, 827.00, 'card', '2025-09-29 19:42:51', '2025-09-29 19:42:51'),
(610, 77, NULL, NULL, 2933.00, 'cash', '2025-09-30 22:42:51', '2025-09-30 22:42:51'),
(611, 30, NULL, NULL, 2785.00, 'cash', '2025-10-11 19:42:51', '2025-10-11 19:42:51'),
(612, 123, NULL, NULL, 1287.00, 'card', '2025-10-24 21:42:51', '2025-10-24 21:42:51'),
(613, 23, NULL, NULL, 987.00, 'card', '2025-10-02 21:42:51', '2025-10-02 21:42:51'),
(614, 123, NULL, NULL, 1610.00, 'card', '2025-10-18 21:42:51', '2025-10-18 21:42:51'),
(615, 2, 1, 9, 2000.00, 'Cash', '2025-10-27 15:46:27', '2025-10-27 15:46:27'),
(616, 3, 1, 9, 2800.00, 'Cash', '2025-10-27 15:51:14', '2025-10-27 15:51:14'),
(617, 1, 2, 45, 1200.00, 'Cash', '2025-11-08 16:57:40', '2025-11-08 16:57:40');
INSERT INTO `transactions` (`id`, `service_id`, `branch_id`, `staff_id`, `amount`, `payment_method`, `created_at`, `updated_at`) VALUES
(618, 1, 1, 9, 1200.00, 'Cash', '2025-11-10 17:39:49', '2025-11-10 17:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `google2fa_secret` varchar(255) DEFAULT NULL,
  `google2fa_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `google2fa_enabled_at` timestamp NULL DEFAULT NULL,
  `mobile_phone` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`preferences`)),
  `role` varchar(255) NOT NULL DEFAULT 'client',
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `saved_card_data` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `google2fa_secret`, `google2fa_enabled`, `google2fa_enabled_at`, `mobile_phone`, `telephone`, `address`, `birthday`, `preferences`, `role`, `branch_id`, `remember_token`, `saved_card_data`, `created_at`, `updated_at`, `active`) VALUES
(2, 'Test Client', 'client@test.com', NULL, '$2y$12$rjKQ.Q7tQ8fpwIjmV70aHeOKIV7IhA3w.Ha8ARe50Tz57Nftj/kza', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'client', NULL, NULL, NULL, '2025-08-25 15:27:02', '2025-09-26 10:38:55', 1),
(4, 'Sample Staff', 'staff@example.com', NULL, '$2y$12$rHh5Q/.FDGkXnHDK5GiYfOkyMrk/4Dvs2LlXVbOn3xE5lPfYos8NW', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'staff', NULL, 'qOVORNmz28jBOUNZZOQf7NF5jOHn0wv9w1d9pp7XZR9LmlyBgCWWa7QsPtYo', NULL, '2025-08-25 15:28:54', '2025-09-01 15:20:51', 1),
(5, 'z3eke', 'lezekgenodiala@gmail.com', NULL, '$2y$12$oW0aWQgyKZdreRkIUbvxZ.CPku9wc8QDpewQlhUBhXYPPVzAhezPm', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'client', NULL, NULL, NULL, '2025-08-26 07:14:14', '2025-08-26 07:14:14', 1),
(7, 'CEO', 'ceo@skin911.com', '2025-09-26 10:38:55', '$2y$12$jeOcf4A/axzxHWlM4PT3qeCJ.QUw/SQfK2Qbh4edELP6MyjNyk8Vm', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'ceo', NULL, NULL, NULL, '2025-09-26 10:38:55', '2025-09-26 10:38:55', 1),
(8, 'adminBanilad', 'admin1@skin911.com', NULL, '$2y$12$7We6F3hIGgYY3PUvJ4iufuayLf9MV/oN2U.VhKWbza6t/kKTz5S6K', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 1, NULL, '{\"mastercard\":{\"card_number\":\"eyJpdiI6IklKeFRNdWVRcG5ocVNkUkVRZ28zdFE9PSIsInZhbHVlIjoiUVo1ZG1uZU9OQlpBRkZ6NjFhSlRMcDBrdDZBVlgrdit4SGQzL1NRd0pKbz0iLCJtYWMiOiI3ZjJhNDBkODYzMmEwNDg0ZmY4Njk3NjAwZDVlODFkNGUxMWM2ODczNTVjN2Q0YjMzZWU0ZDAyNzI2MzE5YWJkIiwidGFnIjoiIn0=\",\"card_expiry\":\"12\\/34\",\"billing_first_name\":\"jhsgfhfasdfas11313fasdfsf231123\",\"billing_last_name\":\"asfasfasfsf1231231\",\"billing_address\":\"ksadfkjsadfh321k34jh1j412k4\",\"billing_city\":\"legends lang nakakaalam\",\"billing_zip\":\"12341243141342426452452734\",\"billing_country\":\"biringan\",\"billing_phone\":\"09812301283091283012381203012313\"}}', '2025-08-30 04:12:25', '2025-11-07 19:54:56', 1),
(9, 'staff2', 'staff2@example.com', NULL, '$2y$12$StLHW4mZ0doLUoSD.dQNJ.NPSDP8L9qJylFqlBcafmPQhYiE2uqqW', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'staff', 1, 'euOq71b8rQMcaLMmf3GPv1uTdR4pyDkeJwWXxbRinvmA3bSaihTPW8yEwIKl', NULL, '2025-09-01 09:40:49', '2025-10-08 02:47:01', 1),
(10, 'leo', 'leo@leo.com', NULL, '$2y$12$aEzeWwLaSgTnc47w/yecM..opgK4I276IdhEm2k71rY/llOC0dH3m', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'staff', 1, NULL, NULL, '2025-09-01 14:17:06', '2025-09-02 04:37:11', 1),
(11, 'adminAyala', 'admin2@gmail.com', NULL, '$2y$12$r8UDo30qo3YcQG.sCubyBuCUDaGomyAX2Qwobwi2l6J9TFWe2QpK2', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 2, NULL, NULL, '2025-09-12 13:38:13', '2025-09-26 12:34:11', 1),
(16, 'Sample Staff', 'staffuser@example.com', NULL, '$2y$12$jLkLveKufE5dmFmNF/esIOQxndmdmhykYKHIF2tvsiwmlodC13lBK', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'staff', NULL, NULL, NULL, '2025-09-26 10:38:24', '2025-09-26 10:38:55', 1),
(17, 'Admin', 'admin@skin911.com', '2025-09-26 10:38:56', '$2y$12$gxqPisFtzZrNvEEZ3vCCpuu/eMMqfV1osJYgjXmR6uieIg0yY.NVm', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 1, NULL, NULL, '2025-09-26 10:38:56', '2025-09-26 11:55:31', 1),
(19, 'QuezonStaff', 'staffQuezon@example.com', NULL, '$2y$12$AVSk1OD0MEKllhTgt44LT.KjpJDEKz3AbLEjHpqX3Fz7NpfxrGNAm', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'staff', NULL, NULL, NULL, '2025-09-26 13:02:45', '2025-09-26 13:02:45', 1),
(21, 'Test', 'test@gmail.com', NULL, '$2y$12$Jk8KOX2oJEwHFhtrIM69d.kyU2Yq05rCFGSCzXouAm.Ix1WbrE2IW', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[]', 'client', NULL, NULL, NULL, '2025-10-19 15:20:26', '2025-10-31 05:24:20', 1),
(22, 'test', 'tets@sample.com', NULL, '$2y$12$u/Z8AbOj.q2likOaWyka3e0hQby9nxmur6vsy/NBvPK7tNFxYoO42', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'client', NULL, NULL, NULL, '2025-10-25 08:18:50', '2025-10-25 08:18:50', 1),
(23, 'prefer', 'leo@sample.com', NULL, '$2y$12$jBbCSg//ceNd1TBOnhHE8eGjQM1XHVSmKoKG6WmSgDtfddMt7Pk1q', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[\"Facial\",\"Slimming\"]', 'client', NULL, NULL, NULL, '2025-10-29 14:41:49', '2025-10-29 14:41:49', 1),
(24, 'James Andrew Velasco', 'jamesvelasco13197@gmail.com', NULL, '$2y$12$BTcWsJR4DhLE9pq.bfGrbeZ/R4oBt7wvC.JrJuQwukudrk2GVLFZW', '4JDZ7AZ3F2DM6XMN', 0, NULL, NULL, NULL, NULL, NULL, '[\"Facial\"]', 'client', NULL, 'SOaCXBLqcfucRvAte06lDjMFZdGXnbzHF4Ho59rn8KRbEFa5dyYR3eXDgsL1', NULL, '2025-11-03 21:15:10', '2025-11-07 21:46:19', 1),
(26, 'emman aggelion', 'emman@gmail.com', NULL, '$2y$12$6RTKXHt47UqO/xooDudyhuhXDfIuWnPiR/iKC4NjHmtT1ZXebukOG', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[\"Facial\",\"Slimming\"]', 'client', NULL, NULL, NULL, '2025-11-03 21:18:04', '2025-11-03 21:18:04', 1),
(27, 'rein', 'reinanjamespalugod@gmail.com', NULL, '$2y$12$1fE6pB/gEgjg/c1o3HoCke6u98jiBAUBaRj0AfmFHpbmMGfYP2e4u', 'WXJXWEN2KVI43ISL', 0, NULL, NULL, NULL, NULL, NULL, '[\"Facial\"]', 'client', NULL, NULL, NULL, '2025-11-03 21:18:59', '2025-11-03 21:19:59', 1),
(28, 'Burdagul', 'safotef398@fandoe.com', NULL, '$2y$12$wdWbH/iv86vsRs/MJxt6K.RKCD9iOpS8fT1rTeGcoqJtT/2jjPIMG', 'GYE2XGRNOT3BRDWP', 0, NULL, NULL, NULL, NULL, NULL, '[\"Laser\"]', 'client', NULL, 'j7WfySWhmJ1qOhAOTthyfHwcZAWr9Ae9yUsmxrUofYp1vy6jjjlqZ94t4rPF', NULL, '2025-11-03 21:31:05', '2025-11-03 21:43:49', 1),
(29, 'Burdagul', 'neelsen_16@yahoo.com', NULL, '$2y$12$Ch2Bx1KV5MC4FKJqSsbKBuZAfjdsI7nsANEPGL476WHrxJ/KAmT2y', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[\"Facial\",\"Laser\",\"Slimming\",\"Immuno\",\"Hair Removal\"]', 'client', NULL, NULL, '{\"visa\":{\"card_number\":\"1234 5846 4613 1151\",\"card_expiry\":\"13\\/37\",\"billing_first_name\":\"Burdagul\",\"billing_last_name\":\"Gulapa\",\"billing_address\":\"Treelane 2 Blk 9 Lot 5\",\"billing_city\":\"Imus City\",\"billing_zip\":\"4103\",\"billing_country\":\"Philippines\",\"billing_phone\":\"6564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD56546564654@@(#*aDJA@(!(*)!(*#)(@#OAIJDOAISD5654\"}}', '2025-11-03 21:49:32', '2025-11-03 22:06:26', 1),
(30, 'Lee', 'leeann.m.genodiala@gmail.com', NULL, '$2y$12$SsqZuZMS/z26ljVkZl8DaOfpSWp8G6tX7stn5nSXG7SWHq9uj/ZvC', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[\"Facial\"]', 'client', NULL, NULL, NULL, '2025-11-03 22:46:24', '2025-11-03 22:46:24', 1),
(31, 'Leonardo', 'liverm91@gmail.com', NULL, '$2y$12$pe7nHSW8fxXuL/bnBg3YceeAIah8gIqDoWWJRyUFaRKfIjAY5oVbO', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[\"Facial\"]', 'client', NULL, NULL, NULL, '2025-11-03 23:02:05', '2025-11-03 23:02:05', 1),
(33, 'Leo ezekiel Genodiala', 'ezekgenodiala@gmail.com', NULL, '$2y$12$GMc/lvr4uytZ5daUnLmgp.oJhxtAmR/gp6jWUNtqOMzYkkhV65wKC', 'LV2QVQ2MRDBVGFZ4', 0, NULL, '09602512409', '0321234567', 'Blk 3a lot 5 casimiro westville phase2 bayabas st. Bacoor cavite', '2006-07-06', '[\"Facial\",\"Laser\"]', 'client', NULL, 'CcLzAWM7riZAoH0aMFFELhEGOPZqsXEJ5H31Sg7TddJBO84kabcM1QAQVdrF', '{\"visa\":{\"card_number\":\"eyJpdiI6IkVGWlJTakVhblFsKzVLNzV6UUhYNkE9PSIsInZhbHVlIjoiOWFiaHlnMUkvb1hmUHFKRDRCS29odk1mZWQzL29EQ2FPMEVBd1NqZWV3Yz0iLCJtYWMiOiI0NzIxNWM1ODIxYmMxMWIyZGMwYTA4YWU1M2M2YjY2ZGUyY2YyMWYwMGJiMGVhZWY5ZjA4MzRkYzYxYzkxOGVmIiwidGFnIjoiIn0=\",\"card_expiry\":\"07\\/33\",\"billing_first_name\":\"Leo ezekiel\",\"billing_last_name\":\"Genodiala\",\"billing_address\":\"Blk 3a lot 5 casimiro westville phase2 bayabas st. Bacoor cavite\",\"billing_city\":\"Cavite\",\"billing_zip\":\"4102\",\"billing_country\":\"Philippines\",\"billing_phone\":\"+639602512409\"}}', '2025-11-05 20:31:40', '2025-11-12 07:43:42', 1),
(34, 'emman agellon', 'emmanagellon094@gmail.com', NULL, '$2y$12$yKTIkw4NCvwoaSKGAW3AGeqJklpVKw4HDffdIN2nbvuO507PLv7Gm', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[\"Facial\"]', 'client', NULL, NULL, NULL, '2025-11-07 14:16:12', '2025-11-07 14:16:12', 1),
(35, 'John Eric Belanio', 'ericbelanio29@gmail.com', NULL, '$2y$12$O0jcURNKvdPgEb7UY4kE/OuMFh.9FeyS4U/BmONoraI5Hb66yDIaa', '7XFMBSTYVBM6OYID', 1, '2025-11-10 14:19:23', NULL, NULL, NULL, NULL, '[\"Laser\",\"Slimming\"]', 'client', NULL, 'kugaZmnvlqPN3WZrlritAf1TLbmx3pURrZkhmXFsDkyA8XgD7Fem731gMG6G', NULL, '2025-11-07 17:50:06', '2025-11-10 14:19:23', 1),
(38, 'staff3', 'staff3@example.com', NULL, '$2y$12$JRzFvE.NYLYHFOg323kM9e/OPrRDlO9frcBgmEqcP6/IgljLmPVrG', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'staff', 1, NULL, NULL, '2025-11-07 21:01:25', '2025-11-07 21:01:25', 1),
(39, 'Guen Harvie Acuatin', 'harvieacuatin@gmail.com', NULL, '$2y$12$I6sDnRAeWfhh0JDBq42fHe5aUhcH4R8dFP.mQazPhjpay7dIipqju', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[]', 'client', NULL, NULL, NULL, '2025-11-08 12:42:00', '2025-11-08 12:42:00', 1),
(40, 'Louie Jay Mermonde', 'louiejaymermonde@gmail.com', NULL, '$2y$12$Ikr/zp13TbFhjY3t1CkwqepqSK/C/Kw8PPQlmgI3CfZs9dPHcCneq', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[\"Facial\",\"Laser\",\"Slimming\",\"Immuno\",\"Hair Removal\"]', 'client', NULL, NULL, NULL, '2025-11-08 13:44:46', '2025-11-08 13:44:46', 1),
(41, 'Aivan Gavrielle Moico', 'moicoaivan@gmail.com', NULL, '$2y$12$AWBES6V.Oqvqf1/QRmTnd.JoDhm6phnXJ.jhWWiptyJU3oxSpA5iS', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[]', 'client', NULL, NULL, NULL, '2025-11-08 13:56:06', '2025-11-08 13:56:06', 1),
(42, 'Eric', 'staff_ayala@gmail.com', NULL, '$2y$12$c91xCH2oumF8Y.Jq0ZXfTeP7D1z1Uu0dAi2PHjJ2tjCxwTSO7QmUy', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'staff', 2, 'mo2qW0ZV5e87Z3YQsTzKAZt6g1TBRouUmXW7LtJRRGjfc0s5FYmwhIzvYEPK', NULL, '2025-11-08 13:56:26', '2025-11-10 14:14:42', 1),
(43, 'eric', 'gungame231@gmail.com', NULL, '$2y$12$hR246elz/u.OrTw2.v1XseW3W66SKPoew/t8PeNptmJ6veyGAqv1q', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[\"Facial\",\"Slimming\"]', 'client', NULL, NULL, NULL, '2025-11-08 16:19:27', '2025-11-08 16:19:27', 1),
(44, 'adminEric', 'something@something.com', NULL, '$2y$12$vjSkRLZeo8jUmDecGUoCmu/IGhfXpgqZ0F.O.yK2kGUoSORqkK6Tq', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 2, NULL, NULL, '2025-11-08 16:52:04', '2025-11-08 16:52:04', 1),
(45, 'velasco', 'velasco@velasco.com', NULL, '$2y$12$T3d0cB1CUdkNyFUuVh9Ef.bFpj7nVRQW5S8ej4GHsrkvdCi5L0Uua', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'staff', 2, NULL, NULL, '2025-11-08 16:55:30', '2025-11-08 16:55:30', 1),
(46, 'Mark Ivan Dela Cuesta', 'mrkvn241@gmail.com', NULL, '$2y$12$u2repV9YteDhsREDD0BQxO/MHB4GzBxdoGjbbCX34DKX66InTgb6.', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[\"Facial\"]', 'client', NULL, NULL, NULL, '2025-11-08 19:24:10', '2025-11-08 19:24:10', 1),
(47, 'Kim Christian Abratigue', 'kempoy1717@gmail.com', NULL, '$2y$12$6LfCjYwQX2AfiLIer6A0WeKsvKHOl7GrNjjt3Qo1ycGiT9.mim2QK', NULL, 0, NULL, NULL, NULL, NULL, NULL, '[\"Slimming\"]', 'client', NULL, 'yTkIKe8UKhuipiebcjA1YFAUfl08O6Fo2YOgojpaGc2grTkF7oZGasRSuJsh', NULL, '2025-11-08 22:33:54', '2025-11-08 22:33:54', 1),
(48, 'test', 'sdf@sdf.sdf', NULL, '$2y$12$lX8vZtbFFm8lcWfdojemku9eG7I5bSFObYa.huHRaO306CXMJ/7.q', '7GCEOYC7LEXTQGJP', 0, NULL, '09123456789', '0212345677', 'test', '2025-11-02', '[\"Facial\"]', 'client', NULL, NULL, NULL, '2025-11-11 23:26:52', '2025-11-11 23:28:03', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_service_id_foreign` (`service_id`),
  ADD KEY `bookings_branch_id_foreign` (`branch_id`),
  ADD KEY `bookings_package_id_foreign` (`package_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_key_unique` (`key`),
  ADD UNIQUE KEY `branches_name_unique` (`name`);

--
-- Indexes for table `branch_service`
--
ALTER TABLE `branch_service`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branch_service_branch_id_service_id_unique` (`branch_id`,`service_id`),
  ADD KEY `branch_service_service_id_foreign` (`service_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_user_id_index` (`user_id`),
  ADD KEY `chat_messages_staff_id_index` (`staff_id`),
  ADD KEY `chat_messages_branch_id_index` (`branch_id`),
  ADD KEY `chat_messages_created_at_index` (`created_at`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packages_branch_id_index` (`branch_id`);

--
-- Indexes for table `package_service`
--
ALTER TABLE `package_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_service_package_id_index` (`package_id`),
  ADD KEY `package_service_service_id_index` (`service_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promos_code_unique` (`code`),
  ADD KEY `promos_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `promo_service`
--
ALTER TABLE `promo_service`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promo_service_promo_id_service_id_unique` (`promo_id`,`service_id`),
  ADD KEY `promo_service_service_id_foreign` (`service_id`);

--
-- Indexes for table `purchased_services`
--
ALTER TABLE `purchased_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchased_services_user_id_foreign` (`user_id`),
  ADD KEY `purchased_services_service_id_foreign` (`service_id`),
  ADD KEY `purchased_services_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_service_id_foreign` (`service_id`),
  ADD KEY `transactions_branch_id_foreign` (`branch_id`),
  ADD KEY `transactions_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_branch_id_foreign` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=787;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `branch_service`
--
ALTER TABLE `branch_service`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=473;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=596;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `package_service`
--
ALTER TABLE `package_service`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `promo_service`
--
ALTER TABLE `promo_service`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `purchased_services`
--
ALTER TABLE `purchased_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=619;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `branch_service`
--
ALTER TABLE `branch_service`
  ADD CONSTRAINT `branch_service_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branch_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_messages_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `chat_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `package_service`
--
ALTER TABLE `package_service`
  ADD CONSTRAINT `package_service_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promos`
--
ALTER TABLE `promos`
  ADD CONSTRAINT `promos_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `promo_service`
--
ALTER TABLE `promo_service`
  ADD CONSTRAINT `promo_service_promo_id_foreign` FOREIGN KEY (`promo_id`) REFERENCES `promos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `promo_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchased_services`
--
ALTER TABLE `purchased_services`
  ADD CONSTRAINT `purchased_services_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchased_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchased_services_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
