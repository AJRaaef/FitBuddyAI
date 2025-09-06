-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2025 at 07:55 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitbuddyai`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'Admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(20) DEFAULT 'Active',
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `full_name`, `email`, `password`, `phone_number`, `role`, `created_at`, `updated_at`, `status`, `profile_picture`) VALUES
(1, 'John Doe', 'admin@example.com', '$2y$10$BV3WSKwsnXmvK0pxwVaJZONf/cXaSx8iq1//FQPfjVcGk93gtcXQa', '+1234567890', 'Super Admin', '2025-09-04 10:26:07', '2025-09-04 10:28:38', 'Active', 'profile_images/admin1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `health_feedback_suggestions`
--

CREATE TABLE `health_feedback_suggestions` (
  `suggestion_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `suggestion` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `health_feedback_suggestions`
--

INSERT INTO `health_feedback_suggestions` (`suggestion_id`, `user_id`, `suggestion`, `created_at`) VALUES
(2, 8, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 11:55:05'),
(3, 8, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 11:55:26'),
(4, 8, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 11:55:26'),
(5, 8, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 11:55:35'),
(6, 8, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 11:55:55'),
(7, 9, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 11:57:22'),
(8, 10, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:03:19'),
(9, 10, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:34:04'),
(10, 11, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:54:19'),
(11, 11, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:54:43'),
(12, 11, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:54:43'),
(13, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:55:20'),
(14, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:55:24'),
(15, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:56:20'),
(16, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:56:21'),
(17, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:56:25'),
(18, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:56:25'),
(19, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:56:25'),
(20, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:56:26'),
(21, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:56:38'),
(22, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:59:52'),
(23, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:59:53'),
(24, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 12:59:53'),
(25, 14, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 13:41:37'),
(26, 14, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 13:41:58'),
(27, 14, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 13:43:20'),
(28, 14, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 13:43:22'),
(29, 14, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 13:44:07'),
(30, 14, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 13:45:23'),
(31, 14, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 13:51:56'),
(32, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 13:54:34'),
(33, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:00:44'),
(34, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:08:01'),
(35, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:08:26'),
(36, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:08:33'),
(37, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:08:41'),
(38, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:09:45'),
(39, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:09:55'),
(40, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:10:11'),
(41, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:17:52'),
(42, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:18:10'),
(43, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:20:35'),
(44, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:20:36'),
(45, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:22:28'),
(46, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:22:39'),
(47, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:22:42'),
(48, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:23:17'),
(49, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:23:24'),
(50, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:23:26'),
(51, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:24:25'),
(52, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:29:27'),
(53, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 14:29:37'),
(54, 15, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 22:50:30'),
(55, 16, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 22:53:55'),
(56, 16, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 22:54:54'),
(57, 16, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 22:55:16'),
(58, 16, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 22:55:21'),
(59, 16, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 22:55:27'),
(60, 16, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 23:05:34'),
(61, 16, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 23:05:35'),
(62, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 23:05:49'),
(63, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 23:06:03'),
(64, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 23:06:09'),
(65, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 23:06:12'),
(66, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 23:10:04'),
(67, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-04 23:10:05'),
(68, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 23:11:27'),
(69, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 23:12:28'),
(70, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 23:15:06'),
(71, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 23:15:10'),
(72, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 23:17:22'),
(73, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 23:17:23'),
(74, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 23:17:24'),
(75, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 23:18:33'),
(76, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 23:18:34'),
(77, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-04 23:18:53'),
(78, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 00:11:24'),
(79, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 00:11:24'),
(80, 17, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 00:23:50'),
(81, 17, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 00:23:51'),
(82, 17, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 00:23:58'),
(83, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 00:36:12'),
(84, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 00:36:13'),
(85, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 00:36:31'),
(86, 17, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 01:47:09'),
(87, 17, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 01:47:10'),
(88, 17, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 01:47:12'),
(89, 17, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 01:47:22'),
(90, 17, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 01:47:46'),
(91, 17, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 02:02:01'),
(92, 17, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 02:02:02'),
(93, 17, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 02:04:32'),
(94, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:28:08'),
(95, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:28:10'),
(96, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:30:37'),
(97, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:30:39'),
(98, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:48:51'),
(99, 17, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:48:53'),
(100, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 02:49:05'),
(101, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 02:49:11'),
(102, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 02:49:18'),
(103, 6, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-05 02:49:53'),
(104, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:51:25'),
(105, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:51:26'),
(106, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:51:41'),
(107, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:51:50'),
(108, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:53:22'),
(109, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:53:35'),
(110, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:54:05'),
(111, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 02:54:10'),
(112, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:02:27'),
(113, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:02:28'),
(114, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:02:28'),
(115, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:04:22'),
(116, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:04:23'),
(117, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:04:31'),
(118, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:04:37'),
(119, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:04:41'),
(120, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:04:52'),
(121, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:04:57'),
(122, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:05:08'),
(123, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:05:19'),
(124, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:05:30'),
(125, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:08:20'),
(126, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:09:14'),
(127, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:09:33'),
(128, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:09:43'),
(129, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:09:46'),
(130, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:10:01'),
(131, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:10:07'),
(132, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:11:30'),
(133, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:12:26'),
(134, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:37:16'),
(135, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:37:17'),
(136, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:37:23'),
(137, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 03:37:26'),
(138, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 04:49:07'),
(139, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 04:49:09'),
(140, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 04:49:16'),
(141, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 04:49:20'),
(142, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 08:35:51'),
(143, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 08:35:55'),
(144, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 08:35:57'),
(145, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 08:36:01'),
(146, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 09:26:29'),
(147, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 10:16:22'),
(148, 1, 'Health Feedback: Adopt a low-fat diet and stay active to improve liver health. | Possible Risks: Fatty Liver', '2025-09-05 15:53:26'),
(149, 1, 'Health Feedback: Adopt a low-fat diet and stay active to improve liver health. | Possible Risks: Fatty Liver', '2025-09-05 16:14:17'),
(150, 1, 'Health Feedback: Adopt a low-fat diet and stay active to improve liver health. | Possible Risks: Fatty Liver', '2025-09-05 16:17:58'),
(151, 1, 'Health Feedback: Adopt a low-fat diet and stay active to improve liver health.', '2025-09-05 16:20:31'),
(152, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 16:47:26'),
(153, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 16:58:28'),
(154, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 17:05:04'),
(155, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 17:13:44'),
(156, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 17:17:52'),
(157, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 17:17:54'),
(158, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 17:44:27'),
(159, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 17:44:28'),
(160, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 17:48:21'),
(161, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 17:52:53'),
(162, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-05 17:59:36'),
(163, 19, 'Health Feedback: Focus on balanced diet and regular activity for better health.', '2025-09-06 01:23:08'),
(164, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 01:36:45'),
(165, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 02:04:42'),
(166, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 02:09:18'),
(167, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 02:16:32'),
(168, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 02:19:58'),
(169, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 02:27:52'),
(170, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 02:35:01'),
(171, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 02:39:45'),
(172, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 02:43:07'),
(173, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 05:26:20'),
(174, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 08:15:34'),
(175, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 08:18:43'),
(176, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 08:20:13'),
(177, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 08:24:35'),
(178, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 08:27:19'),
(179, 6, 'Health Feedback: Healthy BMI! Keep up the good work 😊', '2025-09-06 08:29:15');

-- --------------------------------------------------------

--
-- Table structure for table `health_tips`
--

CREATE TABLE `health_tips` (
  `tip_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `health_tips`
--

INSERT INTO `health_tips` (`tip_id`, `title`, `description`, `image_url`, `created_at`, `admin_id`) VALUES
(1, 'Stay Hydrated', 'Drinking enough water each day is crucial for maintaining energy levels, regulating body temperature, and supporting overall health. Aim for at least 8 glasses of water daily.', 'uploads/hydration.jpg', '2025-09-04 11:40:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('workout','nutrition','goal','health') NOT NULL,
  `source_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `source_id`, `is_read`, `created_at`) VALUES
(1, 6, 'New Meal Plan', 'We\'ve suggested Roti with Dhal Curry for your Breakfast with 350 calories', 'nutrition', NULL, 1, '2025-09-04 08:14:10'),
(2, 6, 'New Meal Plan', 'We\'ve suggested Rice and Curry (Chicken) for your Lunch with 650 calories', 'nutrition', NULL, 1, '2025-09-04 08:14:10'),
(3, 6, 'New Meal Plan', 'We\'ve suggested Rice and Curry (Fish) for your Lunch with 600 calories', 'nutrition', NULL, 1, '2025-09-04 08:14:10'),
(4, 6, 'New Meal Plan', 'We\'ve suggested Crab Curry with Rice for your Lunch with 580 calories', 'nutrition', NULL, 1, '2025-09-04 08:14:10'),
(5, 6, 'New Meal Plan', 'We\'ve suggested Prawn Curry with Rice for your Lunch with 560 calories', 'nutrition', NULL, 1, '2025-09-04 08:14:10'),
(6, 6, 'New Workout Plan', 'We\'ve suggested Swimming for 30 minutes with Low intensity', 'workout', NULL, 1, '2025-09-04 08:14:10'),
(7, 6, 'New Workout Plan', 'We\'ve suggested Rowing Machine for 20 minutes with Medium intensity', 'workout', NULL, 1, '2025-09-04 08:14:10'),
(8, 6, 'New Workout Plan', 'We\'ve suggested Hiking for 45 minutes with Medium intensity', 'workout', NULL, 1, '2025-09-04 08:14:10'),
(9, 6, 'New Workout Plan', 'We\'ve suggested Push Ups for 15 minutes with Medium intensity', 'workout', NULL, 1, '2025-09-04 08:14:10'),
(10, 6, 'New Workout Plan', 'We\'ve suggested Single Leg Deadlift for 15 minutes with Medium intensity', 'workout', NULL, 1, '2025-09-04 08:14:10'),
(11, 1, 'New Meal Plan', 'We\'ve suggested Oatmeal with Berries for your Breakfast with 350 calories', 'nutrition', NULL, 0, '2025-09-04 12:43:03'),
(12, 1, 'New Meal Plan', 'We\'ve suggested Salmon with Quinoa for your Dinner with 500 calories', 'nutrition', NULL, 0, '2025-09-04 12:43:03'),
(13, 1, 'New Meal Plan', 'We\'ve suggested Whole Grain Toast with Avocado for your Breakfast with 320 calories', 'nutrition', NULL, 0, '2025-09-04 12:43:03'),
(14, 1, 'New Meal Plan', 'We\'ve suggested Apple with Almond Butter for your Snack with 200 calories', 'nutrition', NULL, 0, '2025-09-04 12:43:03'),
(15, 1, 'New Meal Plan', 'We\'ve suggested Mediterranean Bowl for your Lunch with 450 calories', 'nutrition', NULL, 0, '2025-09-04 12:43:03'),
(16, 1, 'New Workout Plan', 'We\'ve suggested Walking for 30 minutes with Low intensity', 'workout', NULL, 0, '2025-09-04 12:43:03'),
(17, 1, 'New Workout Plan', 'We\'ve suggested Chair Squats for 10 minutes with Low intensity', 'workout', NULL, 0, '2025-09-04 12:43:03'),
(18, 1, 'New Workout Plan', 'We\'ve suggested Light Jogging for 20 minutes with Medium intensity', 'workout', NULL, 0, '2025-09-04 12:43:03'),
(19, 1, 'New Workout Plan', 'We\'ve suggested Lunges for 15 minutes with Medium intensity', 'workout', NULL, 0, '2025-09-04 12:43:03'),
(20, 1, 'New Workout Plan', 'We\'ve suggested Yoga for 30 minutes with Low intensity', 'workout', NULL, 0, '2025-09-04 12:43:03'),
(21, 15, 'New Meal Plan', 'We\'ve suggested Hoppers (Appa) with Egg for your Breakfast with 280 calories', 'nutrition', NULL, 0, '2025-09-04 17:53:25'),
(22, 15, 'New Meal Plan', 'We\'ve suggested Pittu with Coconut and Potato Curry for your Breakfast with 380 calories', 'nutrition', NULL, 0, '2025-09-04 17:53:25'),
(23, 15, 'New Meal Plan', 'We\'ve suggested Uppuma (Spiced Semolina) for your Breakfast with 300 calories', 'nutrition', NULL, 0, '2025-09-04 17:53:25'),
(24, 15, 'New Meal Plan', 'We\'ve suggested Egg Hopper with Coconut Sambal for your Breakfast with 290 calories', 'nutrition', NULL, 0, '2025-09-04 17:53:25'),
(25, 15, 'New Meal Plan', 'We\'ve suggested Dosa with Coconut Chutney for your Breakfast with 280 calories', 'nutrition', NULL, 0, '2025-09-04 17:53:25'),
(26, 15, 'New Workout Plan', 'We\'ve suggested Chair Squats for 10 minutes with Low intensity', 'workout', NULL, 0, '2025-09-04 17:53:25'),
(27, 15, 'New Workout Plan', 'We\'ve suggested Walking for 30 minutes with Low intensity', 'workout', NULL, 0, '2025-09-04 17:53:25'),
(28, 15, 'New Workout Plan', 'We\'ve suggested Light Jogging for 20 minutes with Medium intensity', 'workout', NULL, 0, '2025-09-04 17:53:25'),
(29, 15, 'New Workout Plan', 'We\'ve suggested Dance Aerobics for 30 minutes with Medium intensity', 'workout', NULL, 0, '2025-09-04 17:53:25'),
(30, 15, 'New Workout Plan', 'We\'ve suggested Zumba for 40 minutes with Medium intensity', 'workout', NULL, 0, '2025-09-04 17:53:25'),
(31, 16, 'New Meal Plan', 'We\'ve suggested Hoppers (Appa) with Egg for your Breakfast with 280 calories', 'nutrition', NULL, 0, '2025-09-05 02:25:19'),
(32, 16, 'New Meal Plan', 'We\'ve suggested Egg Hopper with Coconut Sambal for your Breakfast with 290 calories', 'nutrition', NULL, 0, '2025-09-05 02:25:19'),
(33, 16, 'New Meal Plan', 'We\'ve suggested Dosa with Coconut Chutney for your Breakfast with 280 calories', 'nutrition', NULL, 0, '2025-09-05 02:25:19'),
(34, 16, 'New Meal Plan', 'We\'ve suggested Rice and Curry (Vegetable) for your Lunch with 500 calories', 'nutrition', NULL, 0, '2025-09-05 02:25:19'),
(35, 16, 'New Meal Plan', 'We\'ve suggested Jackfruit Curry with Rice for your Lunch with 480 calories', 'nutrition', NULL, 0, '2025-09-05 02:25:19'),
(36, 16, 'New Workout Plan', 'We\'ve suggested Chair Squats for 10 minutes with Low intensity', 'workout', NULL, 0, '2025-09-05 02:25:19'),
(37, 16, 'New Workout Plan', 'We\'ve suggested Walking for 30 minutes with Low intensity', 'workout', NULL, 0, '2025-09-05 02:25:19'),
(38, 16, 'New Workout Plan', 'We\'ve suggested Light Jogging for 20 minutes with Medium intensity', 'workout', NULL, 0, '2025-09-05 02:25:19'),
(39, 16, 'New Workout Plan', 'We\'ve suggested Dance Aerobics for 30 minutes with Medium intensity', 'workout', NULL, 0, '2025-09-05 02:25:19'),
(40, 16, 'New Workout Plan', 'We\'ve suggested Zumba for 40 minutes with Medium intensity', 'workout', NULL, 0, '2025-09-05 02:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `nutrition_suggestions`
--

CREATE TABLE `nutrition_suggestions` (
  `suggestion_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `suggestion` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `replay`
--

CREATE TABLE `replay` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `replay` text DEFAULT 'waiting for reply',
  `admin_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `replay`
--

INSERT INTO `replay` (`message_id`, `user_id`, `message`, `replay`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 6, 'Hello', 'Hello is everything ok', 1, '2025-09-04 11:32:42', '2025-09-04 11:35:22'),
(2, 6, 'yes', 'ok now worries', 1, '2025-09-04 11:35:35', '2025-09-04 11:43:43'),
(3, 6, 'What Happen to Webiste', 'Nothing Cool', 1, '2025-09-04 12:09:36', '2025-09-04 12:09:49'),
(4, 17, 'Hi', 'Hello', 1, '2025-09-05 06:17:19', '2025-09-05 06:18:35'),
(5, 17, 'Hi', 'waiting for reply', NULL, '2025-09-05 06:18:41', '2025-09-05 06:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `weight_kg` float DEFAULT NULL,
  `height_cm` float DEFAULT NULL,
  `activity_level` varchar(90) DEFAULT NULL,
  `dietary_pref` varchar(20) DEFAULT NULL,
  `fitness_goal` varchar(50) DEFAULT NULL,
  `disease` varchar(255) DEFAULT NULL,
  `allergy` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `bmi` float DEFAULT NULL,
  `bmr` float DEFAULT NULL,
  `calories_per_kg` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(20) DEFAULT 'Active',
  `profile_picture` varchar(255) DEFAULT NULL,
  `sugar_value` double DEFAULT NULL,
  `sugar_label` enum('Very Low','Low','Little Low','Normal','Little High','High','Very High') DEFAULT NULL,
  `cholostrol_value` double DEFAULT NULL,
  `cholostrol_label` enum('Very Low','Low','Little Low','Normal','Little High','High','Very High') DEFAULT NULL,
  `systolic_pressure` int(11) DEFAULT NULL,
  `diastolic_pressure` int(11) DEFAULT NULL,
  `pressure_label` enum('Very Low','Low','Little Low','Normal','Little High','High','Very High') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `gender`, `date_of_birth`, `age`, `weight_kg`, `height_cm`, `activity_level`, `dietary_pref`, `fitness_goal`, `disease`, `allergy`, `location`, `bmi`, `bmr`, `calories_per_kg`, `created_at`, `updated_at`, `status`, `profile_picture`, `sugar_value`, `sugar_label`, `cholostrol_value`, `cholostrol_label`, `systolic_pressure`, `diastolic_pressure`, `pressure_label`) VALUES
(1, 'Kamal', 'Khan', 'jhon@gmail.com', '$2y$10$BV3WSKwsnXmvK0pxwVaJZONf/cXaSx8iq1//FQPfjVcGk93gtcXQa', '+1 (555) 123-45', 'Male', '2009-02-03', 30, 67, 150, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', 'Colombo,Srilanka', 29.78, 1463, 21.84, '2025-09-03 09:24:23', '2025-09-04 14:59:20', 'Active', 'uploads/1756894797_OIP.webp', 95, 'Normal', 180, 'Normal', 120, 80, 'Normal'),
(5, 'Jhon', 'Khan', 'testing12@gmail.com', '$2y$10$hzSFIGQlP0Nl78sX3ZP29.CUt2MFWQOuqEw5l6UsBj3oB0oxpIK12', '+1 (555) 123-45', 'Female', '2009-02-03', 30, 50, 150, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Colombo,Srilanka', 22.22, 1127, 22.54, '2025-09-03 12:43:26', '2025-09-04 04:17:34', 'Active', 'uploads/1756903406_Screenshot 2025-08-12 105203.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Raaef', 'Jaleel', 'raaef@gmail.com', '$2y$10$hzSFIGQlP0Nl78sX3ZP29.CUt2MFWQOuqEw5l6UsBj3oB0oxpIK12', '0123456729', 'Male', '2002-03-01', 23, 50, 162, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', 'Colombo,Srilanka', 19.05, 1403, 28.06, '2025-09-04 05:37:18', '2025-09-06 05:38:51', 'Active', 'uploads/1756964238_premium_photo-1689568126014-06fea9d5d341.jpeg', 90, 'Normal', 210, 'Little High', 120, 80, 'Normal'),
(15, 'Checking', 'Chech', 'check@gmail.com', '$2y$10$wUlGGIA.yNvLgVhE0AwD1ef9iTh1BcewtxMGjJoZuHMK40jLsD322', '0123456729', 'Male', '2004-02-04', 21, 60, 180, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', 'Colombo,Srilanka', 18.5185, 1625, 27.0833, '2025-09-04 17:23:56', '2025-09-04 17:23:59', 'Active', 'uploads/1757006636_yoga.jpg', 120, 'Normal', 200, 'Normal', 120, 80, 'Normal'),
(16, 'Checking', 'Chech', 'checksd12@gmail.com', '$2y$10$BFFotKSbDwp262S/PqIr4Ot6gmuOXPh.9W9q1YuSqC7n/wc3Pc2QC', '0123456729', 'Male', '2004-02-04', 21, 65, 157, 'Lightly Active', 'Non-Vegetarian', 'weight loss', 'Hypertension', 'Peanuts', 'Colombo,Srilanka', 26.3702, 1531.25, 23.5577, '2025-09-05 02:23:16', '2025-09-05 02:23:21', 'Active', 'uploads/1757038996_greek_yogurt_nuts.jpg', 140, 'Little High', 200, 'Normal', 120, 80, 'Normal'),
(17, 'Kumar', 'Kumaran', 'kumar@gmail.com', '$2y$10$mI1OYE72HqBnt1BZmeXwMeEkSwSavlMXCqH3Iwkfuc66zEHyi8QWa', '1234567', 'Male', '2000-05-16', 25, 60, 180, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Colombo,Srilanka', 18.5185, 1605, 26.75, '2025-09-05 02:41:16', '2025-09-05 06:35:57', 'Active', 'uploads/1757040076_greek_yogurt_nuts.jpg', 120, 'Normal', 200, 'Normal', 120, 80, 'Normal'),
(19, 'sdf', 'asf', 'asdf@gmail.com', '$2y$10$G3arWbmIRdjK6vu2Y7OcBOWEJgygQhm.MBtDEWTNkDAnZTu37k8.m', '0779260818', 'Male', '1994-02-06', 31, 60, 185, 'Lightly Active', 'Vegetarian', 'weight gain', 'Hypertension', 'Peanuts', 'Colombo,Srilanka', 17.531, 1606.25, 26.7708, '2025-09-06 04:51:03', '2025-09-06 04:51:08', 'Active', 'uploads/1757134263_greek_yogurt_nuts.jpg', 120, 'Normal', 200, 'Normal', 120, 80, 'Normal');

-- --------------------------------------------------------

--
-- Table structure for table `user_nutrition_data`
--

CREATE TABLE `user_nutrition_data` (
  `tracking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `weight_kg` float NOT NULL,
  `height_cm` float NOT NULL,
  `bmi` float NOT NULL,
  `bmr` float NOT NULL,
  `calories_per_kg` float NOT NULL,
  `activity_level` varchar(50) NOT NULL,
  `dietary_pref` varchar(50) NOT NULL,
  `fitness_goal` varchar(50) NOT NULL,
  `disease` text DEFAULT NULL,
  `allergy` text DEFAULT NULL,
  `pressure_level` varchar(20) DEFAULT NULL,
  `sugar_level` varchar(20) DEFAULT NULL,
  `age` int(11) NOT NULL,
  `nutrition_suggestion` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_nutrition_data`
--

INSERT INTO `user_nutrition_data` (`tracking_id`, `user_id`, `weight_kg`, `height_cm`, `bmi`, `bmr`, `calories_per_kg`, `activity_level`, `dietary_pref`, `fitness_goal`, `disease`, `allergy`, `pressure_level`, `sugar_level`, `age`, `nutrition_suggestion`, `created_at`, `updated_at`) VALUES
(28, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-03 23:48:23', '2025-09-03 23:48:23'),
(29, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-03 23:58:22', '2025-09-03 23:58:22'),
(30, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 00:09:17', '2025-09-04 00:09:17'),
(31, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 00:12:28', '2025-09-04 00:12:28'),
(32, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 00:12:29', '2025-09-04 00:12:29'),
(33, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 00:16:15', '2025-09-04 00:16:15'),
(34, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 00:16:16', '2025-09-04 00:16:16'),
(35, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 00:33:25', '2025-09-04 00:33:25'),
(36, 5, 45, 150, 20, 1077, 23.93, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:33:48', '2025-09-04 00:33:48'),
(37, 5, 55, 150, 24.44, 1177, 21.4, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:36:14', '2025-09-04 00:36:14'),
(38, 5, 55, 150, 24.44, 1177, 21.4, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:36:14', '2025-09-04 00:36:14'),
(39, 5, 55, 150, 24.44, 1177, 21.4, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:36:15', '2025-09-04 00:36:15'),
(40, 5, 55, 150, 24.44, 1177, 21.4, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:37:52', '2025-09-04 00:37:52'),
(41, 5, 99, 150, 44, 1617, 16.33, 'Lightly Active', 'Omnivore', 'weight loss', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Weight Loss Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 00:38:10', '2025-09-04 00:38:10'),
(42, 5, 99, 150, 44, 1617, 16.33, 'Lightly Active', 'Omnivore', 'weight loss', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Weight Loss Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 00:38:10', '2025-09-04 00:38:10'),
(43, 5, 44, 150, 19.56, 1067, 24.25, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:39:30', '2025-09-04 00:39:30'),
(44, 5, 44, 150, 19.56, 1067, 24.25, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:39:31', '2025-09-04 00:39:31'),
(45, 5, 44, 150, 19.56, 1067, 24.25, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:39:41', '2025-09-04 00:39:41'),
(46, 5, 20, 150, 8.89, 827, 41.35, 'Lightly Active', 'Omnivore', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:39:58', '2025-09-04 00:39:58'),
(47, 5, 20, 150, 8.89, 827, 41.35, 'Lightly Active', 'Omnivore', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:47:07', '2025-09-04 00:47:07'),
(48, 5, 20, 150, 8.89, 827, 41.35, 'Lightly Active', 'Omnivore', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:47:08', '2025-09-04 00:47:08'),
(49, 5, 50, 150, 22.22, 1127, 22.54, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:47:37', '2025-09-04 00:47:37'),
(50, 5, 50, 150, 22.22, 1127, 22.54, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:47:37', '2025-09-04 00:47:37'),
(51, 5, 50, 150, 22.22, 1127, 22.54, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:48:28', '2025-09-04 00:48:28'),
(52, 5, 50, 150, 22.22, 1127, 22.54, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 00:48:29', '2025-09-04 00:48:29'),
(53, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 00:48:40', '2025-09-04 00:48:40'),
(54, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 01:06:56', '2025-09-04 01:06:56'),
(55, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 01:06:57', '2025-09-04 01:06:57'),
(56, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 01:06:57', '2025-09-04 01:06:57'),
(57, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 01:07:17', '2025-09-04 01:07:17'),
(58, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 01:07:17', '2025-09-04 01:07:17'),
(59, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 01:36:53', '2025-09-04 01:36:53'),
(60, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 01:36:55', '2025-09-04 01:36:55'),
(61, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 01:54:12', '2025-09-04 01:54:12'),
(62, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 01:54:13', '2025-09-04 01:54:13'),
(63, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 01:54:14', '2025-09-04 01:54:14'),
(64, 5, 50, 150, 22.22, 1127, 22.54, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 01:54:38', '2025-09-04 01:54:38'),
(65, 5, 50, 150, 22.22, 1127, 22.54, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:03:10', '2025-09-04 02:03:10'),
(66, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:08:41', '2025-09-04 02:08:41'),
(67, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:09:06', '2025-09-04 02:09:06'),
(68, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:17:54', '2025-09-04 02:17:54'),
(69, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:17:56', '2025-09-04 02:17:56'),
(70, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:17:57', '2025-09-04 02:17:57'),
(71, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:26:35', '2025-09-04 02:26:35'),
(72, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:28:27', '2025-09-04 02:28:27'),
(73, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:37:13', '2025-09-04 02:37:13'),
(74, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:41:32', '2025-09-04 02:41:32'),
(75, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:45:58', '2025-09-04 02:45:58'),
(76, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:45:59', '2025-09-04 02:45:59'),
(77, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 02:50:39', '2025-09-04 02:50:39'),
(78, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 03:01:21', '2025-09-04 03:01:21'),
(79, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 03:39:56', '2025-09-04 03:39:56'),
(80, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 03:41:35', '2025-09-04 03:41:35'),
(81, 6, 65, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:00:18', '2025-09-04 04:00:18'),
(82, 6, 80, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:17:44', '2025-09-04 04:17:44'),
(83, 6, 80, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:17:45', '2025-09-04 04:17:45'),
(84, 6, 80, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:17:45', '2025-09-04 04:17:45'),
(85, 6, 80, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:17:52', '2025-09-04 04:17:52'),
(86, 6, 22, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:18:13', '2025-09-04 04:18:13'),
(87, 6, 22, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:18:14', '2025-09-04 04:18:14'),
(88, 6, 22, 162, 24.7676, 1552.5, 23.8846, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:18:23', '2025-09-04 04:18:23'),
(89, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:18:46', '2025-09-04 04:18:46'),
(90, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:24:43', '2025-09-04 04:24:43'),
(91, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:24:44', '2025-09-04 04:24:44'),
(92, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:24:44', '2025-09-04 04:24:44'),
(93, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:44:49', '2025-09-04 04:44:49'),
(94, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:44:51', '2025-09-04 04:44:51'),
(95, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:49:58', '2025-09-04 04:49:58'),
(96, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:49:59', '2025-09-04 04:49:59'),
(97, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:51:23', '2025-09-04 04:51:23'),
(98, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:56:28', '2025-09-04 04:56:28'),
(99, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 04:56:29', '2025-09-04 04:56:29'),
(100, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 07:55:52', '2025-09-04 07:55:52'),
(101, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 07:56:59', '2025-09-04 07:56:59'),
(102, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:02:36', '2025-09-04 08:02:36'),
(103, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:02:36', '2025-09-04 08:02:36'),
(104, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:05:58', '2025-09-04 08:05:58'),
(105, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:05:59', '2025-09-04 08:05:59'),
(106, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:07:01', '2025-09-04 08:07:01'),
(107, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:07:36', '2025-09-04 08:07:36'),
(108, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:11:03', '2025-09-04 08:11:03'),
(109, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:11:04', '2025-09-04 08:11:04'),
(110, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:13:45', '2025-09-04 08:13:45'),
(111, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:13:46', '2025-09-04 08:13:46'),
(112, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:14:04', '2025-09-04 08:14:04'),
(113, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:14:04', '2025-09-04 08:14:04'),
(114, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:14:04', '2025-09-04 08:14:04'),
(115, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:14:05', '2025-09-04 08:14:05'),
(116, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:34:27', '2025-09-04 08:34:27'),
(117, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:34:28', '2025-09-04 08:34:28'),
(118, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', 'Normal', 'Normal', 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 08:39:57', '2025-09-04 08:39:57'),
(119, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 08:58:01', '2025-09-04 08:58:01'),
(120, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 08:58:05', '2025-09-04 08:58:05'),
(121, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 08:58:05', '2025-09-04 08:58:05'),
(122, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 09:11:49', '2025-09-04 09:11:49'),
(123, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Diabetic-Friendly Foods, Low-Sodium Foods, Low-Fat / Heart-Healthy Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-04 09:11:50', '2025-09-04 09:11:50'),
(124, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 09:12:49', '2025-09-04 09:12:49'),
(125, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 09:12:50', '2025-09-04 09:12:50'),
(126, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 09:12:50', '2025-09-04 09:12:50'),
(127, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Diabetic-Friendly Foods, Low-Sodium Foods', '2025-09-04 09:13:11', '2025-09-04 09:13:11'),
(128, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 09:15:06', '2025-09-04 09:15:06'),
(129, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 09:15:06', '2025-09-04 09:15:06');
INSERT INTO `user_nutrition_data` (`tracking_id`, `user_id`, `weight_kg`, `height_cm`, `bmi`, `bmr`, `calories_per_kg`, `activity_level`, `dietary_pref`, `fitness_goal`, `disease`, `allergy`, `pressure_level`, `sugar_level`, `age`, `nutrition_suggestion`, `created_at`, `updated_at`) VALUES
(130, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 09:47:39', '2025-09-04 09:47:39'),
(131, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', 'Normal', 'Normal', 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 10:43:43', '2025-09-04 10:43:43'),
(132, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:28:05', '2025-09-04 11:28:05'),
(133, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:30:03', '2025-09-04 11:30:03'),
(134, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:30:04', '2025-09-04 11:30:04'),
(135, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:41:55', '2025-09-04 11:41:55'),
(136, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:41:56', '2025-09-04 11:41:56'),
(137, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:42:41', '2025-09-04 11:42:41'),
(138, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:42:42', '2025-09-04 11:42:42'),
(139, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:42:42', '2025-09-04 11:42:42'),
(140, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:42:42', '2025-09-04 11:42:42'),
(141, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:43:00', '2025-09-04 11:43:00'),
(142, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:43:00', '2025-09-04 11:43:00'),
(143, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:43:00', '2025-09-04 11:43:00'),
(144, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:43:25', '2025-09-04 11:43:25'),
(145, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 11:43:34', '2025-09-04 11:43:34'),
(146, 7, 55, 180, 16.9753, 1505, 27.3636, 'Sedentary', 'Non-Vegetarian', 'Pending', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Low-Sodium Foods, Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 11:46:48', '2025-09-04 11:46:48'),
(147, 7, 55, 180, 16.9753, 1505, 27.3636, 'Sedentary', 'Non-Vegetarian', 'Pending', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Low-Sodium Foods, Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 11:52:52', '2025-09-04 11:52:52'),
(148, 8, 55, 180, 16.9753, 1500, 27.2727, 'Lightly Active', 'Vegetarian', 'Pending', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Low-Sodium Foods, Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 11:55:05', '2025-09-04 11:55:05'),
(149, 8, 55, 180, 16.9753, 1500, 27.2727, 'Lightly Active', 'Vegetarian', 'Pending', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Low-Sodium Foods, Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 11:55:26', '2025-09-04 11:55:26'),
(150, 8, 55, 180, 16.9753, 1500, 27.2727, 'Lightly Active', 'Vegetarian', 'Pending', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Low-Sodium Foods, Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 11:55:26', '2025-09-04 11:55:26'),
(151, 8, 55, 180, 16.9753, 1500, 27.2727, 'Lightly Active', 'Vegetarian', 'Pending', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Low-Sodium Foods, Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 11:55:35', '2025-09-04 11:55:35'),
(152, 8, 55, 180, 16.9753, 1500, 27.2727, 'Lightly Active', 'Vegetarian', 'Pending', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Low-Sodium Foods, Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 11:55:55', '2025-09-04 11:55:55'),
(153, 9, 55, 180, 16.9753, 1505, 27.3636, 'Sedentary', 'Vegan', 'Pending', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Low-Sodium Foods, Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 11:57:22', '2025-09-04 11:57:22'),
(154, 10, 55, 180, 16.9753, 1505, 27.3636, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:03:19', '2025-09-04 12:03:19'),
(155, 10, 55, 180, 16.9753, 1505, 27.3636, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:34:04', '2025-09-04 12:34:04'),
(156, 11, 55, 180, 16.9753, 1505, 27.3636, 'Lightly Active', 'Omnivore', 'weight gain', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:54:19', '2025-09-04 12:54:19'),
(157, 11, 55, 180, 16.9753, 1505, 27.3636, 'Lightly Active', 'Omnivore', 'weight gain', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:54:43', '2025-09-04 12:54:43'),
(158, 11, 55, 180, 16.9753, 1505, 27.3636, 'Lightly Active', 'Omnivore', 'weight gain', 'Hypertension', 'Peanuts', NULL, NULL, 35, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:54:43', '2025-09-04 12:54:43'),
(159, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:55:20', '2025-09-04 12:55:20'),
(160, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:55:24', '2025-09-04 12:55:24'),
(161, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:56:20', '2025-09-04 12:56:20'),
(162, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:56:21', '2025-09-04 12:56:21'),
(163, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:56:25', '2025-09-04 12:56:25'),
(164, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:56:25', '2025-09-04 12:56:25'),
(165, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:56:25', '2025-09-04 12:56:25'),
(166, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:56:26', '2025-09-04 12:56:26'),
(167, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:56:38', '2025-09-04 12:56:38'),
(168, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:59:52', '2025-09-04 12:59:52'),
(169, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:59:53', '2025-09-04 12:59:53'),
(170, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 12:59:53', '2025-09-04 12:59:53'),
(171, 14, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 13:41:37', '2025-09-04 13:41:37'),
(172, 14, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 13:41:58', '2025-09-04 13:41:58'),
(173, 14, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 13:43:20', '2025-09-04 13:43:20'),
(174, 14, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 13:43:22', '2025-09-04 13:43:22'),
(175, 14, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 13:44:07', '2025-09-04 13:44:07'),
(176, 14, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 13:45:23', '2025-09-04 13:45:23'),
(177, 14, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 13:51:56', '2025-09-04 13:51:56'),
(178, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 13:54:34', '2025-09-04 13:54:34'),
(179, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:00:44', '2025-09-04 14:00:44'),
(180, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:08:01', '2025-09-04 14:08:01'),
(181, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:08:26', '2025-09-04 14:08:26'),
(182, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:08:32', '2025-09-04 14:08:32'),
(183, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:08:41', '2025-09-04 14:08:41'),
(184, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:09:45', '2025-09-04 14:09:45'),
(185, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:09:55', '2025-09-04 14:09:55'),
(186, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:10:11', '2025-09-04 14:10:11'),
(187, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:17:52', '2025-09-04 14:17:52'),
(188, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:18:10', '2025-09-04 14:18:10'),
(189, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:20:35', '2025-09-04 14:20:35'),
(190, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:20:36', '2025-09-04 14:20:36'),
(191, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:22:28', '2025-09-04 14:22:28'),
(192, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:22:39', '2025-09-04 14:22:39'),
(193, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:22:42', '2025-09-04 14:22:42'),
(194, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:23:17', '2025-09-04 14:23:17'),
(195, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:23:24', '2025-09-04 14:23:24'),
(196, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:23:26', '2025-09-04 14:23:26'),
(197, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:24:25', '2025-09-04 14:24:25'),
(198, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:29:27', '2025-09-04 14:29:27'),
(199, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 14:29:37', '2025-09-04 14:29:37'),
(200, 15, 60, 180, 18.5185, 1625, 27.0833, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 22:50:30', '2025-09-04 22:50:30'),
(201, 16, 65, 157, 26.3702, 1531.25, 23.5577, 'Lightly Active', 'Non-Vegetarian', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 22:53:55', '2025-09-04 22:53:55'),
(202, 16, 65, 157, 26.3702, 1531.25, 23.5577, 'Lightly Active', 'Non-Vegetarian', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 22:54:54', '2025-09-04 22:54:54'),
(203, 16, 65, 157, 26.3702, 1531.25, 23.5577, 'Lightly Active', 'Non-Vegetarian', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 22:55:16', '2025-09-04 22:55:16'),
(204, 16, 65, 157, 26.3702, 1531.25, 23.5577, 'Lightly Active', 'Non-Vegetarian', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 22:55:21', '2025-09-04 22:55:21'),
(205, 16, 65, 157, 26.3702, 1531.25, 23.5577, 'Lightly Active', 'Non-Vegetarian', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 22:55:27', '2025-09-04 22:55:27'),
(206, 16, 65, 157, 26.3702, 1531.25, 23.5577, 'Lightly Active', 'Non-Vegetarian', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 23:05:34', '2025-09-04 23:05:34'),
(207, 16, 65, 157, 26.3702, 1531.25, 23.5577, 'Lightly Active', 'Non-Vegetarian', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 21, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-04 23:05:35', '2025-09-04 23:05:35'),
(208, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:05:49', '2025-09-04 23:05:49'),
(209, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:06:03', '2025-09-04 23:06:03'),
(210, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:06:09', '2025-09-04 23:06:09'),
(211, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:06:12', '2025-09-04 23:06:12'),
(212, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:10:04', '2025-09-04 23:10:04'),
(213, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:10:05', '2025-09-04 23:10:05'),
(214, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:11:27', '2025-09-04 23:11:27'),
(215, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:12:28', '2025-09-04 23:12:28'),
(216, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:15:06', '2025-09-04 23:15:06'),
(217, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:15:10', '2025-09-04 23:15:10'),
(218, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:17:22', '2025-09-04 23:17:22'),
(219, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:17:23', '2025-09-04 23:17:23'),
(220, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:17:24', '2025-09-04 23:17:24'),
(221, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:18:33', '2025-09-04 23:18:33'),
(222, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:18:34', '2025-09-04 23:18:34'),
(223, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-04 23:18:53', '2025-09-04 23:18:53'),
(224, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 00:11:24', '2025-09-05 00:11:24'),
(225, 17, 60, 180, 18.5185, 1610, 26.8333, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 00:11:24', '2025-09-05 00:11:24'),
(226, 17, 99, 180, 30.56, 2000, 20.2, 'Sedentary', 'Non-Vegetarian', 'weight loss', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Weight Loss Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-05 00:23:50', '2025-09-05 00:23:50'),
(227, 17, 99, 180, 30.56, 2000, 20.2, 'Sedentary', 'Non-Vegetarian', 'weight loss', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Weight Loss Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-05 00:23:51', '2025-09-05 00:23:51'),
(228, 17, 99, 180, 30.56, 2000, 20.2, 'Sedentary', 'Non-Vegetarian', 'weight loss', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Low-Fat ,  Heart-Healthy Foods | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Weight Loss Foods, Vitamin-Rich & Antioxidant Foods', '2025-09-05 00:23:58', '2025-09-05 00:23:58'),
(229, 17, 60, 180, 18.52, 1610, 26.83, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 00:36:12', '2025-09-05 00:36:12'),
(230, 17, 60, 180, 18.52, 1610, 26.83, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 00:36:13', '2025-09-05 00:36:13'),
(231, 17, 60, 180, 18.52, 1610, 26.83, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 'None', NULL, NULL, 24, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Balanced Meal with Protein & Carbs | Dinner: Light, Balanced Dinner | Snack: High-Fiber Snacks | Suggested Categories: Balanced Energy Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 00:36:31', '2025-09-05 00:36:31'),
(232, 17, 50, 180, 15.43, 1505, 30.1, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 01:47:09', '2025-09-05 01:47:09'),
(233, 17, 50, 180, 15.43, 1505, 30.1, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 01:47:10', '2025-09-05 01:47:10'),
(234, 17, 50, 180, 15.43, 1505, 30.1, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 01:47:12', '2025-09-05 01:47:12');
INSERT INTO `user_nutrition_data` (`tracking_id`, `user_id`, `weight_kg`, `height_cm`, `bmi`, `bmr`, `calories_per_kg`, `activity_level`, `dietary_pref`, `fitness_goal`, `disease`, `allergy`, `pressure_level`, `sugar_level`, `age`, `nutrition_suggestion`, `created_at`, `updated_at`) VALUES
(235, 17, 50, 180, 15.43, 1505, 30.1, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 01:47:22', '2025-09-05 01:47:22'),
(236, 17, 50, 180, 15.43, 1505, 30.1, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 01:47:46', '2025-09-05 01:47:46'),
(237, 17, 50, 180, 15.43, 1505, 30.1, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:02:01', '2025-09-05 02:02:01'),
(238, 17, 50, 180, 15.43, 1505, 30.1, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:02:02', '2025-09-05 02:02:02'),
(239, 17, 50, 180, 15.43, 1505, 30.1, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:04:32', '2025-09-05 02:04:32'),
(240, 17, 60, 180, 18.5185, 1605, 26.75, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:28:08', '2025-09-05 02:28:08'),
(241, 17, 60, 180, 18.5185, 1605, 26.75, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:28:10', '2025-09-05 02:28:10'),
(242, 17, 60, 180, 18.5185, 1605, 26.75, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:30:37', '2025-09-05 02:30:37'),
(243, 17, 60, 180, 18.5185, 1605, 26.75, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:30:39', '2025-09-05 02:30:39'),
(244, 17, 60, 180, 18.5185, 1605, 26.75, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:48:51', '2025-09-05 02:48:51'),
(245, 17, 60, 180, 18.5185, 1605, 26.75, 'Sedentary', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 25, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:48:53', '2025-09-05 02:48:53'),
(246, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:49:05', '2025-09-05 02:49:05'),
(247, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:49:11', '2025-09-05 02:49:11'),
(248, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:49:18', '2025-09-05 02:49:18'),
(249, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:49:53', '2025-09-05 02:49:53'),
(250, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:51:25', '2025-09-05 02:51:25'),
(251, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:51:26', '2025-09-05 02:51:26'),
(252, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:51:41', '2025-09-05 02:51:41'),
(253, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:51:50', '2025-09-05 02:51:50'),
(254, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:53:22', '2025-09-05 02:53:22'),
(255, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:53:35', '2025-09-05 02:53:35'),
(256, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:54:05', '2025-09-05 02:54:05'),
(257, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 02:54:10', '2025-09-05 02:54:10'),
(258, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:02:27', '2025-09-05 03:02:27'),
(259, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:02:28', '2025-09-05 03:02:28'),
(260, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:02:28', '2025-09-05 03:02:28'),
(261, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:04:22', '2025-09-05 03:04:22'),
(262, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:04:23', '2025-09-05 03:04:23'),
(263, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:04:31', '2025-09-05 03:04:31'),
(264, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:04:37', '2025-09-05 03:04:37'),
(265, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:04:41', '2025-09-05 03:04:41'),
(266, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:04:52', '2025-09-05 03:04:52'),
(267, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:04:57', '2025-09-05 03:04:57'),
(268, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:05:08', '2025-09-05 03:05:08'),
(269, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:05:19', '2025-09-05 03:05:19'),
(270, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:05:30', '2025-09-05 03:05:30'),
(271, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:08:20', '2025-09-05 03:08:20'),
(272, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:09:14', '2025-09-05 03:09:14'),
(273, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:09:33', '2025-09-05 03:09:33'),
(274, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:09:43', '2025-09-05 03:09:43'),
(275, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:09:46', '2025-09-05 03:09:46'),
(276, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:10:01', '2025-09-05 03:10:01'),
(277, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:10:07', '2025-09-05 03:10:07'),
(278, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:11:30', '2025-09-05 03:11:30'),
(279, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:12:26', '2025-09-05 03:12:26'),
(280, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:37:16', '2025-09-05 03:37:16'),
(281, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:37:17', '2025-09-05 03:37:17'),
(282, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:37:23', '2025-09-05 03:37:23'),
(283, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 03:37:26', '2025-09-05 03:37:26'),
(284, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 04:49:07', '2025-09-05 04:49:07'),
(285, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 04:49:09', '2025-09-05 04:49:09'),
(286, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 04:49:16', '2025-09-05 04:49:16'),
(287, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 04:49:20', '2025-09-05 04:49:20'),
(288, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 08:35:51', '2025-09-05 08:35:51'),
(289, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 08:35:55', '2025-09-05 08:35:55'),
(290, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 08:35:57', '2025-09-05 08:35:57'),
(291, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 08:36:01', '2025-09-05 08:36:01'),
(292, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 09:26:29', '2025-09-05 09:26:29'),
(293, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 10:16:22', '2025-09-05 10:16:22'),
(294, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-05 15:53:26', '2025-09-05 15:53:26'),
(295, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-05 16:14:17', '2025-09-05 16:14:17'),
(296, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-05 16:17:58', '2025-09-05 16:17:58'),
(297, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', 'Peanuts', NULL, NULL, 30, 'Recommended Nutrition Plan: Breakfast: Balanced Breakfast with Protein & Fiber | Lunch: Low-Calorie, High-Fiber Foods | Dinner: Low-Carbohydrate Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, High-Fiber Foods, Low-Carbohydrate Foods, Low-Sodium Foods, Weight Loss Foods', '2025-09-05 16:20:31', '2025-09-05 16:20:31'),
(298, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 16:47:26', '2025-09-05 16:47:26'),
(299, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 16:58:28', '2025-09-05 16:58:28'),
(300, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 17:05:04', '2025-09-05 17:05:04'),
(301, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 17:13:44', '2025-09-05 17:13:44'),
(302, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 17:17:52', '2025-09-05 17:17:52'),
(303, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 17:17:54', '2025-09-05 17:17:54'),
(304, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 17:44:27', '2025-09-05 17:44:27'),
(305, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 17:44:28', '2025-09-05 17:44:28'),
(306, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 17:48:21', '2025-09-05 17:48:21'),
(307, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 17:52:53', '2025-09-05 17:52:53'),
(308, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-05 17:59:36', '2025-09-05 17:59:36'),
(309, 19, 60, 185, 17.531, 1606.25, 26.7708, 'Lightly Active', 'Vegetarian', 'weight gain', 'Hypertension', 'Peanuts', NULL, NULL, 31, 'Recommended Nutrition Plan: Breakfast: Protein & Calorie-Dense Foods | Lunch: Calorie-Dense, Nutrient-Rich Foods | Dinner: Light, Balanced Dinner | Snack: Protein & Healthy Fat Snacks | Suggested Categories: Weight Gain Foods, Low-Sodium Foods, Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 01:23:08', '2025-09-06 01:23:08'),
(310, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 01:36:45', '2025-09-06 01:36:45'),
(311, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 02:04:42', '2025-09-06 02:04:42'),
(312, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 02:09:18', '2025-09-06 02:09:18'),
(313, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 02:16:32', '2025-09-06 02:16:32'),
(314, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 02:19:58', '2025-09-06 02:19:58'),
(315, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 02:27:52', '2025-09-06 02:27:52'),
(316, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 02:35:01', '2025-09-06 02:35:01'),
(317, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 02:39:45', '2025-09-06 02:39:45'),
(318, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 02:43:07', '2025-09-06 02:43:07'),
(319, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 05:26:20', '2025-09-06 05:26:20'),
(320, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 08:15:34', '2025-09-06 08:15:34'),
(321, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 08:18:43', '2025-09-06 08:18:43'),
(322, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 08:20:13', '2025-09-06 08:20:13'),
(323, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 08:24:35', '2025-09-06 08:24:35'),
(324, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 08:27:19', '2025-09-06 08:27:19'),
(325, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'muscle building', 'No Disease', 'None', NULL, NULL, 23, 'Recommended Nutrition Plan: Breakfast: High-Protein Foods with Complex Carbs | Lunch: High-Protein Foods with Veggies | Dinner: Protein-Rich Foods | Snack: High-Fiber Snacks | Suggested Categories: High-Protein Foods, Complex Carbohydrates (Energy Foods), Vitamin-Rich & Antioxidant Foods, Hydrating Foods', '2025-09-06 08:29:15', '2025-09-06 08:29:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_recorded` timestamp NOT NULL DEFAULT current_timestamp(),
  `age` int(11) DEFAULT NULL,
  `weight_kg` decimal(5,2) DEFAULT NULL,
  `height_cm` decimal(5,2) DEFAULT NULL,
  `activity_level` varchar(50) DEFAULT NULL,
  `sugar_value` int(11) DEFAULT NULL,
  `cholostrol_value` int(11) DEFAULT NULL,
  `systolic_pressure` int(11) DEFAULT NULL,
  `diastolic_pressure` int(11) DEFAULT NULL,
  `sugar_label` enum('Very Low','Low','Little Low','Normal','Little High','High','Very High') DEFAULT NULL,
  `cholostrol_label` enum('Very Low','Low','Little Low','Normal','Little High','High','Very High') DEFAULT NULL,
  `pressure_label` enum('Very Low','Low','Little Low','Normal','Little High','High','Very High') DEFAULT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  `bmr` decimal(6,2) DEFAULT NULL,
  `calories_per_kg` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_progress`
--

INSERT INTO `user_progress` (`progress_id`, `user_id`, `date_recorded`, `age`, `weight_kg`, `height_cm`, `activity_level`, `sugar_value`, `cholostrol_value`, `systolic_pressure`, `diastolic_pressure`, `sugar_label`, `cholostrol_label`, `pressure_label`, `bmi`, `bmr`, `calories_per_kg`) VALUES
(1, 6, '2025-09-04 07:47:28', 23, '75.00', '162.00', 'Moderately Active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28.58', '1652.50', '22.03'),
(2, 6, '2025-09-04 07:47:35', 23, '80.00', '162.00', 'Moderately Active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30.48', '1702.50', '21.28'),
(3, 6, '2025-09-04 07:48:09', 23, '22.00', '162.00', 'Moderately Active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8.38', '1122.50', '51.02'),
(4, 6, '2025-09-04 07:54:37', 23, '30.00', '162.00', 'Moderately Active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11.43', '1202.50', '40.08'),
(5, 17, '2025-09-05 05:35:01', 25, '50.00', '180.00', '0', 120, 0, 120, 80, '', 'Very Low', 'Normal', '15.43', '1505.00', '30.10'),
(6, 17, '2025-09-05 05:46:36', 25, '50.00', '180.00', '0', 120, 0, 120, 80, '', 'Very Low', 'Normal', '15.43', '1505.00', '30.10'),
(7, 17, '2025-09-05 05:47:38', 25, '50.00', '180.00', '0', 120, 200, 120, 80, '', 'Normal', 'Normal', '15.43', '1505.00', '30.10'),
(8, 17, '2025-09-05 05:48:14', 25, '50.00', '180.00', '0', 120, 200, 120, 80, '', 'Normal', 'Normal', '15.43', '1505.00', '30.10'),
(9, 17, '2025-09-05 05:49:03', 25, '50.00', '180.00', '0', 120, 200, 120, 80, '', 'Normal', 'Normal', '15.43', '1505.00', '30.10'),
(10, 17, '2025-09-05 05:50:37', 25, '50.00', '180.00', '0', 120, 200, 120, 80, '', 'Normal', 'Normal', '15.43', '1505.00', '30.10'),
(11, 17, '2025-09-05 05:50:40', 25, '50.00', '180.00', '0', 120, 200, 120, 80, '', 'Normal', 'Normal', '15.43', '1505.00', '30.10'),
(12, 17, '2025-09-05 05:52:28', 25, '50.00', '180.00', '0', 120, 200, 120, 80, '', 'Normal', 'Normal', '15.43', '1505.00', '30.10'),
(13, 17, '2025-09-05 05:57:48', 25, '60.00', '180.00', '0', 120, 200, 120, 80, '', 'Normal', 'Normal', '18.52', '1605.00', '26.75');

-- --------------------------------------------------------

--
-- Table structure for table `user_suggested_nutrition`
--

CREATE TABLE `user_suggested_nutrition` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `meal_type` varchar(50) NOT NULL,
  `calories` int(11) NOT NULL,
  `protein` decimal(5,1) NOT NULL,
  `carbs` decimal(5,1) NOT NULL,
  `fats` decimal(5,1) NOT NULL,
  `suggestion` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `meal_time` time DEFAULT NULL,
  `is_eaten` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_suggested_nutrition`
--

INSERT INTO `user_suggested_nutrition` (`id`, `user_id`, `food_name`, `meal_type`, `calories`, `protein`, `carbs`, `fats`, `suggestion`, `image_path`, `meal_time`, `is_eaten`, `created_at`) VALUES
(96, 8, 'Hoppers (Appa) with Egg', 'Breakfast', 280, '10.0', '35.0', '12.0', 'Fermented rice flour bowl with egg center. Low in calories.', 'images/hopper_egg.jpg', '08:00:00', 0, '2025-09-04 15:25:28'),
(97, 8, 'Pittu with Coconut and Potato Curry', 'Breakfast', 380, '7.0', '55.0', '15.0', 'Steamed rice and coconut cylinders with potato curry.', 'images/pittu.jpg', '08:00:00', 0, '2025-09-04 15:25:28'),
(98, 8, 'Uppuma (Spiced Semolina)', 'Breakfast', 300, '8.0', '45.0', '10.0', 'Savory semolina cooked with vegetables and spices.', 'images/uppuma.jpg', '08:00:00', 0, '2025-09-04 15:25:28'),
(99, 8, 'Egg Hopper with Coconut Sambal', 'Breakfast', 290, '11.0', '30.0', '14.0', 'Crispy bowl-shaped pancake with egg and coconut sambal.', 'images/egg_hopper.jpg', '08:00:00', 0, '2025-09-04 15:25:28'),
(100, 8, 'Dosa with Coconut Chutney', 'Breakfast', 280, '8.0', '45.0', '8.0', 'Fermented lentil and rice crepe with coconut chutney.', 'images/dosa.jpg', '08:00:00', 0, '2025-09-04 15:25:28'),
(101, 11, 'Hoppers (Appa) with Egg', 'Breakfast', 280, '10.0', '35.0', '12.0', 'Fermented rice flour bowl with egg center. Low in calories.', 'images/hopper_egg.jpg', '08:00:00', 0, '2025-09-04 16:24:54'),
(102, 11, 'Pittu with Coconut and Potato Curry', 'Breakfast', 380, '7.0', '55.0', '15.0', 'Steamed rice and coconut cylinders with potato curry.', 'images/pittu.jpg', '08:00:00', 0, '2025-09-04 16:24:54'),
(103, 11, 'Uppuma (Spiced Semolina)', 'Breakfast', 300, '8.0', '45.0', '10.0', 'Savory semolina cooked with vegetables and spices.', 'images/uppuma.jpg', '08:00:00', 0, '2025-09-04 16:24:54'),
(104, 11, 'Egg Hopper with Coconut Sambal', 'Breakfast', 290, '11.0', '30.0', '14.0', 'Crispy bowl-shaped pancake with egg and coconut sambal.', 'images/egg_hopper.jpg', '08:00:00', 0, '2025-09-04 16:24:54'),
(105, 11, 'Dosa with Coconut Chutney', 'Breakfast', 280, '8.0', '45.0', '8.0', 'Fermented lentil and rice crepe with coconut chutney.', 'images/dosa.jpg', '08:00:00', 0, '2025-09-04 16:24:54'),
(111, 15, 'Hoppers (Appa) with Egg', 'Breakfast', 280, '10.0', '35.0', '12.0', 'Fermented rice flour bowl with egg center. Low in calories.', 'images/hopper_egg.jpg', '08:00:00', 0, '2025-09-04 17:48:09'),
(112, 15, 'Pittu with Coconut and Potato Curry', 'Breakfast', 380, '7.0', '55.0', '15.0', 'Steamed rice and coconut cylinders with potato curry.', 'images/pittu.jpg', '08:00:00', 0, '2025-09-04 17:48:09'),
(113, 15, 'Uppuma (Spiced Semolina)', 'Breakfast', 300, '8.0', '45.0', '10.0', 'Savory semolina cooked with vegetables and spices.', 'images/uppuma.jpg', '08:00:00', 0, '2025-09-04 17:48:09'),
(114, 15, 'Egg Hopper with Coconut Sambal', 'Breakfast', 290, '11.0', '30.0', '14.0', 'Crispy bowl-shaped pancake with egg and coconut sambal.', 'images/egg_hopper.jpg', '08:00:00', 0, '2025-09-04 17:48:09'),
(115, 15, 'Dosa with Coconut Chutney', 'Breakfast', 280, '8.0', '45.0', '8.0', 'Fermented lentil and rice crepe with coconut chutney.', 'images/dosa.jpg', '08:00:00', 0, '2025-09-04 17:48:09'),
(116, 16, 'Hoppers (Appa) with Egg', 'Breakfast', 280, '10.0', '35.0', '12.0', 'Fermented rice flour bowl with egg center. Low in calories.', 'images/hopper_egg.jpg', '08:00:00', 0, '2025-09-05 02:24:56'),
(117, 16, 'Egg Hopper with Coconut Sambal', 'Breakfast', 290, '11.0', '30.0', '14.0', 'Crispy bowl-shaped pancake with egg and coconut sambal.', 'images/egg_hopper.jpg', '08:00:00', 0, '2025-09-05 02:24:56'),
(118, 16, 'Dosa with Coconut Chutney', 'Breakfast', 280, '8.0', '45.0', '8.0', 'Fermented lentil and rice crepe with coconut chutney.', 'images/dosa.jpg', '08:00:00', 0, '2025-09-05 02:24:56'),
(119, 16, 'Rice and Curry (Vegetable)', 'Lunch', 500, '15.0', '85.0', '12.0', 'Rice with assortment of vegetable curries. Plant-based nutrition.', 'images/rice_vegetable_curry.jpg', '12:30:00', 0, '2025-09-05 02:24:56'),
(120, 16, 'Jackfruit Curry with Rice', 'Lunch', 480, '12.0', '85.0', '10.0', 'Young jackfruit cooked in spices. Meat-like texture, plant-based.', 'images/jackfruit_curry.jpg', '12:30:00', 0, '2025-09-05 02:24:56'),
(141, 17, 'Kiribath with Lunumiris', 'Breakfast', 420, '8.0', '65.0', '15.0', 'Traditional milk rice with spicy sambal. Good for special occasions.', 'images/kiribath.jpg', '08:00:00', 0, '2025-09-05 02:45:09'),
(142, 17, 'String Hoppers (Idiyappam) with Coconut Sambal', 'Breakfast', 320, '5.0', '60.0', '8.0', 'Steamed rice noodles with grated coconut sambal. Gluten-free option.', 'images/string_hoppers.jpg', '08:00:00', 0, '2025-09-05 02:45:09'),
(143, 17, 'Coconut Roti with Onion and Chili', 'Breakfast', 320, '6.0', '35.0', '18.0', 'Coconut infused flatbread with onions and chilies.', 'images/coconut_roti.jpg', '08:00:00', 0, '2025-09-05 02:45:09'),
(144, 17, 'Pol Roti with Seeni Sambol', 'Breakfast', 340, '5.0', '40.0', '18.0', 'Coconut flatbread with caramelized onion relish.', 'images/pol_roti.jpg', '08:00:00', 0, '2025-09-05 02:45:09'),
(145, 17, 'Yellow Rice with Coconut Milk', 'Breakfast', 380, '6.0', '60.0', '14.0', 'Fragrant rice cooked in coconut milk with turmeric.', 'images/yellow_rice.jpg', '08:00:00', 0, '2025-09-05 02:45:09'),
(286, 6, 'Roti with Dhal Curry', 'Breakfast', 350, '12.0', '45.0', '14.0', 'Whole wheat flatbread with lentil curry. Good protein source.', 'images/roti_dhal.jpg', '08:00:00', 0, '2025-09-06 11:54:40'),
(287, 6, 'Rice and Curry (Chicken)', 'Lunch', 650, '30.0', '80.0', '20.0', 'Traditional Sri Lankan rice with chicken curry and side dishes.', 'images/rice_chicken_curry.jpg', '12:30:00', 0, '2025-09-06 11:54:40'),
(288, 6, 'Rice and Curry (Fish)', 'Lunch', 600, '25.0', '80.0', '18.0', 'Traditional rice with fish curry. Rich in omega-3 fatty acids.', 'images/rice_fish_curry.jpg', '12:30:00', 0, '2025-09-06 11:54:40'),
(289, 6, 'Crab Curry with Rice', 'Lunch', 580, '40.0', '75.0', '15.0', 'Spicy crab curry with rice. Rich in protein and minerals.', 'images/crab_curry.jpg', '12:30:00', 0, '2025-09-06 11:54:40'),
(290, 6, 'Prawn Curry with Rice', 'Lunch', 560, '35.0', '75.0', '14.0', 'Creamy prawn curry with rice. Good source of selenium.', 'images/prawn_curry.jpg', '12:30:00', 0, '2025-09-06 11:54:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_suggested_workouts`
--

CREATE TABLE `user_suggested_workouts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exercise_name` varchar(255) NOT NULL,
  `exercise_type` varchar(50) DEFAULT NULL,
  `duration_min` int(11) DEFAULT NULL,
  `frequency_day` int(11) DEFAULT NULL,
  `intensity` varchar(50) DEFAULT NULL,
  `suggestion` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_suggested_workouts`
--

INSERT INTO `user_suggested_workouts` (`id`, `user_id`, `exercise_name`, `exercise_type`, `duration_min`, `frequency_day`, `intensity`, `suggestion`, `image_path`, `created_at`) VALUES
(181, 8, 'Tai Chi', 'Balance', 25, 3, 'Low', 'Improves balance and relaxation, safe for older adults.', 'images/taichi.jpg', '2025-09-04 15:25:37'),
(182, 8, 'Resistance Band Curls', 'Strength', 15, 4, 'Low', 'Safe bicep strengthening using resistance bands.', 'images/band_curls.jpg', '2025-09-04 15:25:37'),
(183, 8, 'Walking', 'Cardio', 30, 5, 'Low', 'Light cardio for heart health and weight management.', 'images/walking.jpg', '2025-09-04 15:25:37'),
(184, 8, 'Chair Squats', 'Strength', 10, 3, 'Low', 'Safe squats for beginners and older adults.', 'images/chairsquart', '2025-09-04 15:25:37'),
(185, 8, 'Light Jogging', 'Cardio', 20, 4, 'Medium', 'Improves stamina and burns calories safely.', 'images/jogging.jpg', '2025-09-04 15:25:37'),
(186, 10, 'Walking', 'Cardio', 30, 5, 'Low', 'Light cardio for heart health and weight management.', 'images/walking.jpg', '2025-09-04 15:33:38'),
(187, 10, 'Chair Squats', 'Strength', 10, 3, 'Low', 'Safe squats for beginners and older adults.', 'images/chairsquart', '2025-09-04 15:33:38'),
(188, 10, 'Tai Chi', 'Balance', 25, 3, 'Low', 'Improves balance and relaxation, safe for older adults.', 'images/taichi.jpg', '2025-09-04 15:33:38'),
(189, 10, 'Water Aerobics', 'Cardio', 35, 3, 'Low', 'Low impact cardio ideal for joint issues or rehabilitation.', 'images/water_aerobics.jpg', '2025-09-04 15:33:38'),
(190, 10, 'Stretching', 'Flexibility', 20, 5, 'Low', 'Safe for healthy users to improve flexibility and posture.', 'images/stretching.jpg', '2025-09-04 15:33:38'),
(191, 11, 'Tai Chi', 'Balance', 25, 3, 'Low', 'Improves balance and relaxation, safe for older adults.', 'images/taichi.jpg', '2025-09-04 16:24:56'),
(192, 11, 'Resistance Band Curls', 'Strength', 15, 4, 'Low', 'Safe bicep strengthening using resistance bands.', 'images/band_curls.jpg', '2025-09-04 16:24:56'),
(193, 11, 'Walking', 'Cardio', 30, 5, 'Low', 'Light cardio for heart health and weight management.', 'images/walking.jpg', '2025-09-04 16:24:56'),
(194, 11, 'Chair Squats', 'Strength', 10, 3, 'Low', 'Safe squats for beginners and older adults.', 'images/chairsquart', '2025-09-04 16:24:56'),
(195, 11, 'Light Jogging', 'Cardio', 20, 4, 'Medium', 'Improves stamina and burns calories safely.', 'images/jogging.jpg', '2025-09-04 16:24:56'),
(201, 14, 'Chair Squats', 'Strength', 10, 3, 'Low', 'Safe squats for beginners and older adults.', 'images/chairsquart', '2025-09-04 17:11:51'),
(202, 14, 'Walking', 'Cardio', 30, 5, 'Low', 'Light cardio for heart health and weight management.', 'images/walking.jpg', '2025-09-04 17:11:51'),
(203, 14, 'Light Jogging', 'Cardio', 20, 4, 'Medium', 'Improves stamina and burns calories safely.', 'images/jogging.jpg', '2025-09-04 17:11:51'),
(204, 14, 'Dance Aerobics', 'Cardio', 30, 4, 'Medium', 'Fun cardio workout that improves coordination and mood.', 'images/dance_aerobics.jpg', '2025-09-04 17:11:51'),
(205, 14, 'Zumba', 'Cardio', 40, 3, 'Medium', 'Dance-based cardio that makes exercise fun.', 'images/zumba.jpg', '2025-09-04 17:11:51'),
(231, 15, 'Chair Squats', 'Strength', 10, 3, 'Low', 'Safe squats for beginners and older adults.', 'images/chairsquart', '2025-09-04 17:59:13'),
(232, 15, 'Walking', 'Cardio', 30, 5, 'Low', 'Light cardio for heart health and weight management.', 'images/walking.jpg', '2025-09-04 17:59:13'),
(233, 15, 'Light Jogging', 'Cardio', 20, 4, 'Medium', 'Improves stamina and burns calories safely.', 'images/jogging.jpg', '2025-09-04 17:59:13'),
(234, 15, 'Dance Aerobics', 'Cardio', 30, 4, 'Medium', 'Fun cardio workout that improves coordination and mood.', 'images/dance_aerobics.jpg', '2025-09-04 17:59:13'),
(235, 15, 'Zumba', 'Cardio', 40, 3, 'Medium', 'Dance-based cardio that makes exercise fun.', 'images/zumba.jpg', '2025-09-04 17:59:13'),
(236, 16, 'Chair Squats', 'Strength', 10, 3, 'Low', 'Safe squats for beginners and older adults.', 'images/chairsquart', '2025-09-05 02:24:39'),
(237, 16, 'Walking', 'Cardio', 30, 5, 'Low', 'Light cardio for heart health and weight management.', 'images/walking.jpg', '2025-09-05 02:24:39'),
(238, 16, 'Light Jogging', 'Cardio', 20, 4, 'Medium', 'Improves stamina and burns calories safely.', 'images/jogging.jpg', '2025-09-05 02:24:39'),
(239, 16, 'Dance Aerobics', 'Cardio', 30, 4, 'Medium', 'Fun cardio workout that improves coordination and mood.', 'images/dance_aerobics.jpg', '2025-09-05 02:24:39'),
(240, 16, 'Zumba', 'Cardio', 40, 3, 'Medium', 'Dance-based cardio that makes exercise fun.', 'images/zumba.jpg', '2025-09-05 02:24:39'),
(306, 17, 'Child\'s Pose', 'Flexibility', 10, 5, '0', 'Restorative stretch for back, hips, and shoulders.', 'images/childs_pose.jpg', '2025-09-05 05:17:23'),
(307, 17, 'Quad Stretch', 'Flexibility', 10, 5, '0', 'Targets front thigh muscles for better flexibility.', 'images/quad_stretch.jpg', '2025-09-05 05:17:23'),
(308, 17, 'Butterfly Stretch', 'Flexibility', 10, 5, '0', 'Opens hips and improves groin flexibility.', 'images/butterfly_stretch.jpg', '2025-09-05 05:17:23'),
(309, 17, 'Triceps Stretch', 'Flexibility', 10, 5, '0', 'Targets the back of the arms for improved mobility.', 'images/triceps_stretch.jpg', '2025-09-05 05:17:23'),
(310, 17, 'Cross-Body Shoulder Stretch', 'Flexibility', 10, 5, '0', 'Improves shoulder mobility and reduces tension.', 'images/shoulder_stretch.jpg', '2025-09-05 05:17:23'),
(396, 6, 'Swimming', 'Cardio', 30, 3, '0', 'Low impact cardio suitable for all adults, good for joint health.', 'images/swimming.jpg', '2025-09-06 11:50:16'),
(397, 6, 'Rowing Machine', 'Cardio', 20, 3, '0', 'Full body cardio workout with low joint impact.', 'images/rowing.jpg', '2025-09-06 11:50:16'),
(398, 6, 'Stair Climbing', 'Cardio', 20, 4, '0', 'Builds lower body strength and cardiovascular endurance.', 'images/stair_climbing.jpg', '2025-09-06 11:50:16'),
(399, 6, 'Hiking', 'Cardio', 45, 2, '0', 'Outdoor cardio that connects you with nature.', 'images/hiking.jpg', '2025-09-06 11:50:16'),
(400, 6, 'Push Ups', 'Strength', 15, 4, '0', 'Builds upper body and core strength safely.', 'images/pushups.jpg', '2025-09-06 11:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_tracking`
--

CREATE TABLE `user_tracking` (
  `tracking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `weight_kg` float NOT NULL,
  `height_cm` float NOT NULL,
  `bmi` float NOT NULL,
  `bmr` float NOT NULL,
  `calories_per_kg` float NOT NULL,
  `activity_level` varchar(50) DEFAULT NULL,
  `dietary_pref` varchar(50) DEFAULT NULL,
  `fitness_goal` varchar(50) DEFAULT NULL,
  `disease` varchar(100) DEFAULT NULL,
  `sugar_value` int(11) DEFAULT NULL,
  `cholostrol_value` int(11) DEFAULT NULL,
  `systolic_pressure` int(11) DEFAULT NULL,
  `diastolic_pressure` int(11) DEFAULT NULL,
  `sugar_label` enum('Very Low','Low','Little Low','Normal','Little High','High','Very High') DEFAULT NULL,
  `cholostrol_label` enum('Very Low','Low','Little Low','Normal','Little High','High','Very High') DEFAULT NULL,
  `pressure_label` enum('Very Low','Low','Little Low','Normal','Little High','High','Very High') DEFAULT NULL,
  `allergy` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_tracking`
--

INSERT INTO `user_tracking` (`tracking_id`, `user_id`, `weight_kg`, `height_cm`, `bmi`, `bmr`, `calories_per_kg`, `activity_level`, `dietary_pref`, `fitness_goal`, `disease`, `sugar_value`, `cholostrol_value`, `systolic_pressure`, `diastolic_pressure`, `sugar_label`, `cholostrol_label`, `pressure_label`, `allergy`, `age`, `status`, `created_at`, `updated_at`) VALUES
(15, 5, 90, 200, 22.5, 1889, 20.99, 'Lightly Active', 'Omnivore', 'Weight Gain', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 20, 'active', '2025-09-03 18:56:14', '2025-09-03 18:56:14'),
(16, 5, 95, 200, 23.75, 1939, 20.41, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 20, 'active', '2025-09-03 19:04:20', '2025-09-03 19:04:20'),
(17, 5, 95, 200, 23.75, 1889, 19.88, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 30, 'active', '2025-09-03 19:10:21', '2025-09-03 19:10:21'),
(18, 5, 10, 200, 2.5, 1039, 103.9, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 30, 'active', '2025-09-03 19:11:28', '2025-09-03 19:11:28'),
(19, 5, 90, 150, 40, 1527, 16.97, 'Lightly Active', 'Omnivore', 'weight gain', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 30, 'active', '2025-09-03 19:20:55', '2025-09-03 19:20:55'),
(20, 5, 45, 150, 20, 1077, 23.93, 'Lightly Active', 'Omnivore', 'weight loss', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 30, 'active', '2025-09-03 19:46:45', '2025-09-03 19:46:45'),
(21, 1, 65, 180, 20.06, 1700, 26.15, 'Sedentary', 'Omnivore', 'Weight Loss', 'Hypertension', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 16, 'active', '2025-09-04 06:04:02', '2025-09-04 06:04:02'),
(22, 1, 65, 180, 20.06, 1700, 26.15, 'Sedentary', 'Omnivore', 'maintain fitness', 'high cholesterol', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 16, 'active', '2025-09-04 06:05:36', '2025-09-04 06:05:36'),
(23, 1, 50, 150, 22.22, 1313, 26.26, 'Sedentary', 'Omnivore', 'maintain fitness', 'high cholesterol', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Peanuts', 26, 'active', '2025-09-04 06:13:41', '2025-09-04 06:13:41'),
(24, 1, 90, 150, 40, 1713, 19.03, 'Sedentary', 'Omnivore', 'maintain fitness', 'high cholesterol', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Peanuts', 26, 'active', '2025-09-04 06:15:06', '2025-09-04 06:15:06'),
(25, 1, 90, 150, 40, 1693, 18.81, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Peanuts', 30, 'active', '2025-09-04 06:27:17', '2025-09-04 06:27:17'),
(26, 5, 55, 150, 24.44, 1177, 21.4, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 30, 'active', '2025-09-04 09:36:07', '2025-09-04 09:36:07'),
(27, 5, 99, 150, 44, 1617, 16.33, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 30, 'active', '2025-09-04 09:38:03', '2025-09-04 09:38:03'),
(28, 5, 44, 150, 19.56, 1067, 24.25, 'Lightly Active', 'Omnivore', 'weight loss', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 30, 'active', '2025-09-04 09:39:23', '2025-09-04 09:39:23'),
(29, 5, 20, 150, 8.89, 827, 41.35, 'Lightly Active', 'Omnivore', 'maintain fitness', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 30, 'active', '2025-09-04 09:39:49', '2025-09-04 09:39:49'),
(30, 5, 50, 150, 22.22, 1127, 22.54, 'Lightly Active', 'Omnivore', 'weight gain', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 30, 'active', '2025-09-04 09:47:30', '2025-09-04 09:47:30'),
(31, 1, 50, 150, 22.22, 1293, 25.86, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Peanuts', 30, 'active', '2025-09-04 10:07:10', '2025-09-04 10:07:10'),
(32, 6, 30, 162, 11.43, 1203, 40.1, 'Moderately Active', 'Non-Vegetarian', 'maintain fitness', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 23, 'active', '2025-09-04 13:18:37', '2025-09-04 13:18:37'),
(33, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'maintain fitness', 'Hypertension, Diabetes, High Cholesterol, Fatty Liver', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Peanuts', 30, 'active', '2025-09-04 18:12:23', '2025-09-04 18:12:23'),
(34, 1, 67, 150, 29.78, 1463, 21.84, 'Sedentary', 'Omnivore', 'weight loss', 'Hypertension', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Peanuts', 30, 'active', '2025-09-04 18:14:59', '2025-09-04 18:14:59'),
(35, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 23, 'active', '2025-09-04 21:56:15', '2025-09-04 21:56:15'),
(36, 6, 55, 162, 20.96, 1453, 26.42, 'Moderately Active', 'Non-Vegetarian', 'weight gain', 'No Disease', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'None', 23, 'active', '2025-09-04 21:56:48', '2025-09-04 21:56:48'),
(37, 15, 60, 180, 18.52, 1625, 27.08, 'Lightly Active', 'Vegetarian', 'maintain fitness', 'Hypertension', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Peanuts', 21, 'active', '2025-09-04 23:29:54', '2025-09-04 23:29:54'),
(38, 17, 99, 180, 30.56, 2000, 20.2, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 0, 0, 0, 0, 'Very Low', 'Very Low', 'Very Low', 'None', 24, 'active', '2025-09-05 09:16:27', '2025-09-05 09:16:27'),
(39, 17, 99, 180, 30.56, 2000, 20.2, 'Sedentary', 'Non-Vegetarian', 'weight loss', 'No Disease', 0, 0, 0, 0, 'Very Low', 'Very Low', 'Very Low', 'None', 24, 'active', '2025-09-05 09:17:41', '2025-09-05 09:17:41'),
(47, 17, 60, 180, 18.52, 1610, 26.83, 'Sedentary', 'Non-Vegetarian', 'weight loss', 'No Disease', 120, 200, 120, 80, 'Normal', 'Normal', 'Normal', 'None', 24, 'active', '2025-09-05 09:45:31', '2025-09-05 09:45:31'),
(48, 17, 60, 180, 18.52, 1605, 26.75, 'Sedentary', 'Non-Vegetarian', 'maintain fitness', 'No Disease', 120, 200, 120, 80, 'Normal', 'Normal', 'Normal', 'None', 25, 'active', '2025-09-05 09:48:18', '2025-09-05 09:48:18'),
(49, 17, 50, 180, 15.43, 1505, 30.1, 'Sedentary', 'Non-Vegetarian', 'Weight Loss', 'No Disease', 120, 200, 120, 80, 'Normal', 'Normal', 'Normal', 'None', 25, 'active', '2025-09-05 10:46:29', '2025-09-05 10:46:29'),
(50, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'Weight Loss', 'No Disease', 0, 0, 0, 0, 'Very Low', 'Very Low', 'Very Low', 'None', 23, 'active', '2025-09-05 11:50:15', '2025-09-05 11:50:15'),
(51, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'Weight Loss', 'No Disease', 90, 120, 120, 80, 'Normal', 'Low', 'Normal', 'None', 23, 'active', '2025-09-05 11:51:11', '2025-09-05 11:51:11'),
(52, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'Weight Loss', 'No Disease', 90, 200, 120, 80, 'Normal', 'Normal', 'Normal', 'None', 23, 'active', '2025-09-05 11:54:54', '2025-09-05 11:54:54'),
(53, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'Weight Loss', 'No Disease', 90, 150, 120, 80, 'Normal', 'Low', 'Normal', 'None', 23, 'active', '2025-09-05 12:02:16', '2025-09-05 12:02:16'),
(54, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'Weight Loss', 'No Disease', 90, 200, 120, 80, 'Normal', 'Normal', 'Normal', 'None', 23, 'active', '2025-09-05 12:06:47', '2025-09-05 12:06:47'),
(55, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'Weight Loss', 'No Disease', 90, 210, 120, 80, 'Normal', 'Little High', 'Normal', 'None', 23, 'active', '2025-09-05 12:07:36', '2025-09-05 12:07:36'),
(56, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'Weight Loss', 'No Disease', 90, 210, 120, 80, 'Normal', 'Little High', 'Normal', 'None', 23, 'active', '2025-09-06 11:04:50', '2025-09-06 11:04:50'),
(57, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'Weight Loss', 'No Disease', 90, 210, 120, 80, 'Normal', 'Little High', 'Normal', 'None', 23, 'active', '2025-09-06 11:05:33', '2025-09-06 11:05:33'),
(58, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Non-Vegetarian', 'Weight Loss', 'No Disease', 90, 210, 120, 80, 'Normal', 'Little High', 'Normal', 'None', 23, 'active', '2025-09-06 11:07:36', '2025-09-06 11:07:36'),
(59, 6, 50, 162, 19.05, 1403, 28.06, 'Moderately Active', 'Vegetarian', 'Weight Loss', 'No Disease', 90, 210, 120, 80, 'Normal', 'Little High', 'Normal', 'None', 23, 'active', '2025-09-06 11:08:48', '2025-09-06 11:08:48');

-- --------------------------------------------------------

--
-- Table structure for table `workout_exercises`
--

CREATE TABLE `workout_exercises` (
  `exercise_id` int(11) NOT NULL,
  `exercise_name` varchar(100) NOT NULL,
  `exercise_type` varchar(50) NOT NULL,
  `age_group` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `bmi_category` varchar(50) NOT NULL,
  `disease_condition` varchar(100) DEFAULT 'None',
  `activity_level` varchar(50) NOT NULL,
  `workout_goal` varchar(50) NOT NULL,
  `duration_min` int(11) NOT NULL,
  `frequency_day` int(11) NOT NULL,
  `intensity` varchar(50) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `suggestion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `workout_goal_suggestions`
--

CREATE TABLE `workout_goal_suggestions` (
  `suggestion_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `suggestion` text NOT NULL,
  `workout_duration` int(11) DEFAULT NULL,
  `workout_frequency` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `health_feedback_suggestions`
--
ALTER TABLE `health_feedback_suggestions`
  ADD PRIMARY KEY (`suggestion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `health_tips`
--
ALTER TABLE `health_tips`
  ADD PRIMARY KEY (`tip_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nutrition_suggestions`
--
ALTER TABLE `nutrition_suggestions`
  ADD PRIMARY KEY (`suggestion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `replay`
--
ALTER TABLE `replay`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_nutrition_data`
--
ALTER TABLE `user_nutrition_data`
  ADD PRIMARY KEY (`tracking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_suggested_nutrition`
--
ALTER TABLE `user_suggested_nutrition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_suggested_workouts`
--
ALTER TABLE `user_suggested_workouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_tracking`
--
ALTER TABLE `user_tracking`
  ADD PRIMARY KEY (`tracking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `workout_exercises`
--
ALTER TABLE `workout_exercises`
  ADD PRIMARY KEY (`exercise_id`);

--
-- Indexes for table `workout_goal_suggestions`
--
ALTER TABLE `workout_goal_suggestions`
  ADD PRIMARY KEY (`suggestion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `health_feedback_suggestions`
--
ALTER TABLE `health_feedback_suggestions`
  MODIFY `suggestion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `health_tips`
--
ALTER TABLE `health_tips`
  MODIFY `tip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `nutrition_suggestions`
--
ALTER TABLE `nutrition_suggestions`
  MODIFY `suggestion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `replay`
--
ALTER TABLE `replay`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_nutrition_data`
--
ALTER TABLE `user_nutrition_data`
  MODIFY `tracking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_suggested_nutrition`
--
ALTER TABLE `user_suggested_nutrition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT for table `user_suggested_workouts`
--
ALTER TABLE `user_suggested_workouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- AUTO_INCREMENT for table `user_tracking`
--
ALTER TABLE `user_tracking`
  MODIFY `tracking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `workout_exercises`
--
ALTER TABLE `workout_exercises`
  MODIFY `exercise_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `workout_goal_suggestions`
--
ALTER TABLE `workout_goal_suggestions`
  MODIFY `suggestion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `health_feedback_suggestions`
--
ALTER TABLE `health_feedback_suggestions`
  ADD CONSTRAINT `health_feedback_suggestions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `health_tips`
--
ALTER TABLE `health_tips`
  ADD CONSTRAINT `health_tips_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `nutrition_suggestions`
--
ALTER TABLE `nutrition_suggestions`
  ADD CONSTRAINT `nutrition_suggestions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `replay`
--
ALTER TABLE `replay`
  ADD CONSTRAINT `replay_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `replay_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE SET NULL;

--
-- Constraints for table `user_nutrition_data`
--
ALTER TABLE `user_nutrition_data`
  ADD CONSTRAINT `user_nutrition_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_suggested_nutrition`
--
ALTER TABLE `user_suggested_nutrition`
  ADD CONSTRAINT `user_suggested_nutrition_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_suggested_workouts`
--
ALTER TABLE `user_suggested_workouts`
  ADD CONSTRAINT `user_suggested_workouts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_tracking`
--
ALTER TABLE `user_tracking`
  ADD CONSTRAINT `user_tracking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `workout_goal_suggestions`
--
ALTER TABLE `workout_goal_suggestions`
  ADD CONSTRAINT `workout_goal_suggestions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
