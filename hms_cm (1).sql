-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2025 at 02:08 PM
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
-- Database: `hms_cm`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled',
  `consultation_fee` float(7,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `appointment_type` varchar(255) DEFAULT 'Consultation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `appointment_date`, `appointment_time`, `status`, `consultation_fee`, `notes`, `created_at`, `updated_at`, `appointment_type`) VALUES
(1, 1, 8, '2025-08-19', '11:15:00', 'Completed', 1000.00, 'Urgent requirement for deceased patient.', '2025-07-30 22:22:15', '2025-08-28 02:13:38', 'Consultation'),
(2, 1, 8, '2025-09-17', '12:30:00', 'Scheduled', 1500.00, 'Urgent requirement for deceased patient, suffering with this discease since long.', '2025-07-30 23:40:54', '2025-09-17 00:06:54', 'Emergency'),
(3, 1, 8, '2025-09-12', '17:45:00', 'Scheduled', 1500.00, 'Urgent requirement for deceased patient, suffering with this disease since long.', '2025-07-30 23:54:11', '2025-09-11 01:02:06', 'Consultation'),
(4, 1, 8, '2025-08-19', '10:00:00', 'Cancelled', 1500.00, NULL, '2025-08-18 23:01:00', '2025-08-28 02:13:47', 'Consultation'),
(5, 1, 7, '2025-09-25', '20:15:00', 'Scheduled', 1000.00, NULL, '2025-08-18 23:50:42', '2025-09-11 01:10:27', 'Consultation');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `batch_no` varchar(100) NOT NULL,
  `expiry_date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `mrp` decimal(10,2) NOT NULL DEFAULT 0.00,
  `purchase_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gst_percent` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `product_id`, `purchase_id`, `batch_no`, `expiry_date`, `quantity`, `mrp`, `purchase_price`, `created_at`, `updated_at`, `gst_percent`) VALUES
(1, 1, 1, 'PCM2025A', '2026-01-31', 100, 85.00, 50.00, '2025-08-20 10:17:47', '2025-08-22 10:12:05', 0.00),
(2, 2, 2, 'AMOX2025B', '2025-12-31', 94, 50.00, 30.00, '2025-08-20 10:17:47', '2025-08-28 08:12:51', 0.00),
(3, 3, 3, 'COUGH2025C', '2025-11-30', 95, 35.00, 15.00, '2025-08-20 10:17:47', '2025-08-23 06:59:47', 0.00),
(10, 1, 5, 'B001', '2026-01-01', 113, 85.00, 55.00, '2025-08-23 04:08:43', '2025-08-28 08:07:25', 12.00),
(11, 3, 5, 'B003', '2026-05-31', 40, 150.00, 100.00, '2025-08-23 04:08:43', '2025-08-23 04:08:43', 5.00),
(23, 1, 9, 'B009', '2025-09-27', 1, 100.00, 120.00, '2025-09-05 00:05:42', '2025-09-05 00:05:42', 5.00),
(48, 3, 28, 'B009', '2025-09-23', 1, 100.00, 120.00, '2025-09-10 05:46:12', '2025-09-10 05:46:12', 5.00),
(49, 1, 29, 'B009', '2025-09-23', 1, 100.00, 120.00, '2025-09-10 05:46:55', '2025-09-10 05:46:55', 5.00),
(50, 1, 30, 'B009', '2025-09-24', 1, 100.00, 120.00, '2025-09-10 05:48:20', '2025-09-10 05:48:20', 5.00),
(51, 1, 31, 'B009', '2025-09-24', 1, 100.00, 120.00, '2025-09-10 05:50:40', '2025-09-10 05:50:40', 5.00),
(52, 3, 31, 'B005', '2025-09-18', 0, 80.00, 50.00, '2025-09-10 05:50:40', '2025-09-12 08:01:36', 5.00),
(53, 1, 32, 'B009', '2025-09-24', 1, 100.00, 120.00, '2025-09-10 06:01:21', '2025-09-10 06:01:21', 5.00),
(54, 1, 33, 'B009', '2025-09-24', 1, 100.00, 120.00, '2025-09-10 06:02:35', '2025-09-10 06:02:35', 5.00),
(55, 3, 34, 'B009', '2025-09-24', 1, 100.00, 120.00, '2025-09-10 06:05:00', '2025-09-10 06:05:00', 5.00),
(63, 3, 36, 'B002', '2025-09-17', 0, 100.00, 50.00, '2025-09-10 07:38:32', '2025-09-11 06:50:59', 5.00),
(64, 3, 36, 'B005', '2025-09-25', 1, 80.00, 1000.00, '2025-09-10 07:38:32', '2025-09-10 07:38:32', 120.00),
(65, 1, 37, 'B002', '2025-09-17', 1, 100.00, 50.00, '2025-09-10 07:40:50', '2025-09-10 07:40:50', 5.00),
(70, 1, 6, 'B002', '2026-01-01', 100, 80.00, 50.00, '2025-09-11 03:06:07', '2025-09-11 03:06:07', 12.00),
(71, 2, 6, 'B003', '2025-12-31', 50, 180.00, 120.00, '2025-09-11 03:06:07', '2025-09-11 03:06:07', 5.00),
(72, 5, 7, 'B009', '2025-09-23', 1, 100.00, 120.00, '2025-09-11 03:06:13', '2025-09-11 03:06:13', 5.00),
(73, 2, 8, 'B008', '2025-09-25', 1, 100.00, 120.00, '2025-09-11 03:06:22', '2025-09-11 03:06:22', 5.00),
(74, 2, 8, 'B009', '2025-09-29', 177, 180.00, 120.00, '2025-09-11 03:06:22', '2025-09-11 03:06:22', 5.00),
(79, 3, 35, 'B009', '2025-09-24', 1, 100.00, 120.00, '2025-09-11 05:06:41', '2025-09-11 05:06:41', 5.00),
(80, 1, 35, 'B005', '2025-09-25', 1, 80.00, 1000.00, '2025-09-11 05:06:41', '2025-09-11 05:06:41', 120.00),
(81, 3, 38, 'B00511', '2025-09-24', 1, 8090.00, 1000.00, '2025-09-11 05:07:13', '2025-09-11 05:07:13', 120.00),
(82, 3, 38, 'B002145', '2025-09-23', 9, 200.00, 120.00, '2025-09-11 05:07:13', '2025-09-11 05:07:13', 15.00),
(84, 3, 40, 'B005123', '2025-09-13', 1, 100.00, 50.00, '2025-09-13 02:42:50', '2025-09-13 02:42:50', 12.00),
(86, 3, 42, 'B0051231', '2025-09-12', 1, 100.00, 50.00, '2025-09-13 02:49:58', '2025-09-13 02:49:58', 12.00),
(88, 1, 44, 'B003', '2025-09-13', 12, 12.00, 120.00, '2025-09-13 03:13:49', '2025-09-13 03:13:49', 12.00),
(89, 1, 45, 'B0031', '2025-09-13', 12, 12.00, 120.00, '2025-09-13 03:16:33', '2025-09-13 03:16:33', 12.00),
(90, 3, 46, 'B0091', '2025-09-19', 1, 100.00, 120.00, '2025-09-13 03:24:46', '2025-09-13 03:24:46', 12.00),
(92, 1, 48, 'B0091122', '2025-09-30', 30, 100.00, 1899.00, '2025-09-13 03:36:52', '2025-09-13 03:36:52', 12.00),
(93, 3, 49, 'B0091122123', '2025-09-30', 1, 100.00, 1899.00, '2025-09-13 03:41:44', '2025-09-13 03:41:44', 12.00),
(94, 1, 50, 'B0091', '2025-09-25', 1, 100.00, 1899.00, '2025-09-13 03:43:20', '2025-09-13 03:43:20', 12.00),
(95, 1, 51, 'B00511', '2025-09-24', 3, 100.00, 1899.00, '2025-09-13 03:44:32', '2025-09-13 03:44:32', 12.00),
(96, 5, 52, 'B00511', '2025-09-24', 9, 100.00, 1899.00, '2025-09-13 03:50:21', '2025-09-13 03:50:21', 12.00),
(97, 5, 53, 'B00511', '2025-09-24', 1, 100.00, 1899.00, '2025-09-13 04:00:59', '2025-09-13 04:00:59', 12.00),
(98, 1, 54, 'B00911', '2025-09-23', 8, 100.00, 1899.00, '2025-09-13 04:04:08', '2025-09-13 04:04:08', 12.00),
(99, 2, 55, 'B0051231', '2025-09-18', 9, 100.00, 50.00, '2025-09-13 04:08:56', '2025-09-13 04:08:56', 12.00),
(100, 5, 56, 'B0051231', '2025-09-18', 100, 100.00, 50.00, '2025-09-13 04:11:23', '2025-09-13 04:11:23', 12.00),
(101, 5, 57, 'B0091', '2025-09-12', 9, 100.00, 1899.00, '2025-09-13 04:21:27', '2025-09-13 04:21:27', 12.00),
(102, 5, 57, 'B0091', '2025-09-12', 9, 100.00, 1899.00, '2025-09-13 04:21:27', '2025-09-13 04:21:27', 12.00),
(103, 3, 58, 'B0091', '2025-09-12', 1, 100.00, 1899.00, '2025-09-13 04:45:48', '2025-09-13 04:45:48', 12.00),
(104, 3, 58, 'B0091', '2025-09-12', 1, 100.00, 1899.00, '2025-09-13 04:45:48', '2025-09-13 04:45:48', 12.00),
(105, 5, 59, 'B0091', '2025-09-12', 1, 100.00, 1899.00, '2025-09-13 04:46:18', '2025-09-13 04:46:18', 12.00),
(106, 5, 59, 'B0091', '2025-09-12', 1, 100.00, 1899.00, '2025-09-13 04:46:18', '2025-09-13 04:46:18', 12.00),
(107, 5, 60, 'B00912', '2025-09-25', 4, 100.00, 1899.00, '2025-09-13 04:48:30', '2025-09-13 04:48:30', 12.00),
(108, 5, 60, 'B00912', '2025-09-25', 4, 100.00, 1899.00, '2025-09-13 04:48:30', '2025-09-13 04:48:30', 12.00),
(111, 3, 62, 'B0021111', '2025-09-24', 1, 80.00, 1899.00, '2025-09-15 04:48:26', '2025-09-15 04:48:26', 12.00),
(112, 1, 63, 'B002111111', '2025-09-24', 29, 80.00, 1899.00, '2025-09-15 04:49:18', '2025-09-15 04:49:18', 12.00),
(114, 1, 65, 'B00455', '2025-09-24', 100, 80.00, 1899.00, '2025-09-16 02:49:20', '2025-09-16 02:49:20', 12.00),
(115, 3, 66, 'B00453', '2025-09-24', 1, 80.00, 1899.00, '2025-09-16 02:51:49', '2025-09-16 02:51:49', 12.00),
(116, 2, 67, 'B0045453', '2025-09-24', 1, 80.00, 1899.00, '2025-09-16 02:56:54', '2025-09-16 02:56:54', 12.00),
(121, 5, 68, 'B004567453', '2025-09-24', 6, 180.00, 1899.00, '2025-09-16 06:58:21', '2025-09-16 06:58:21', 12.00),
(122, 3, 68, 'B000611', '2025-09-23', 1, 100.00, 1899.00, '2025-09-16 06:58:21', '2025-09-16 06:58:21', 12.00),
(123, 1, 69, 'B0053456', '2025-09-17', 3, 10.00, 1000.00, '2025-09-18 04:26:10', '2025-09-18 04:26:10', 12.00),
(124, 1, 64, 'B00233', '2025-09-24', 13, 80.00, 1899.00, '2025-09-18 04:35:54', '2025-09-18 04:35:54', 12.00),
(128, 1, 70, 'B0051', '2025-09-19', 1, 100.00, 100.00, '2025-09-18 04:39:52', '2025-09-18 04:39:52', 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `pack_type` int(11) DEFAULT NULL,
  `delivery_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`delivery_days`)),
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_schedules`
--

CREATE TABLE `booking_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_date` date NOT NULL,
  `is_ordered` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'scheduled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_subscriptions`
--

CREATE TABLE `customer_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Cardiology', 'Heart and blood vessels', '2025-07-29 02:06:39', '2025-07-29 02:06:39'),
(2, 'Orthopedics', 'Bones and muscles', '2025-07-29 02:06:40', '2025-07-29 02:06:40'),
(3, 'Neurology', 'Nervous system', '2025-07-29 02:06:40', '2025-07-29 02:06:40'),
(4, 'Pediatrics', 'Children health', '2025-07-29 02:06:41', '2025-07-29 02:06:41'),
(5, 'Dermatology', 'Have problems with your skin, hair, nails? Do you have moles, scars, acne, or skin allergies? Dermatologists can help.', '2025-07-29 02:06:42', '2025-07-29 03:43:18'),
(6, 'Anesthesiologist', 'These doctors give you drugs to numb your pain or to put you under during surgery, childbirth, or other procedures. They monitor your vital signs while you’re under anesthesia.', '2025-07-29 03:33:08', '2025-07-29 03:33:08');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` varchar(50) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `specialization` text DEFAULT NULL,
  `availability` varchar(255) NOT NULL DEFAULT 'Yes',
  `experience` varchar(255) NOT NULL,
  `consultation_fee` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `doctor_id`, `department_id`, `specialization`, `availability`, `experience`, `consultation_fee`, `deleted_at`, `created_at`, `updated_at`) VALUES
(7, 10, 'Doc-1-CY3LZR', 6, 'Doctor of Medicine (MD) or Doctor of Osteopathic Medicine (DO)', 'Yes', '16 yrs of experience', '10001', NULL, '2025-07-30 01:59:10', '2025-09-16 04:18:41'),
(8, 11, 'Doc-8-I56UNK', 6, 'Doctor of Medicine (MD) or Doctor of Osteopathic Medicine (DO)', 'Yes', '10 yrs of experience with some specils', '1500', NULL, '2025-07-30 02:08:18', '2025-07-30 05:29:12'),
(40, 46, 'Doc-9-BDQOTZ', 6, 'Doctor of Medicine (MD) or Doctor of Osteopathic Medicine (DO)', 'Yes', '17 yrs of experience', '1000', NULL, '2025-09-17 04:27:10', '2025-09-17 04:27:10'),
(41, 47, 'Doc-41-AUTJA9', 6, 'Doctor of Medicine (MD) or Doctor of Osteopathic Medicine (DO)', 'Yes', '16 yrs of experience', '6000', NULL, '2025-09-17 04:54:39', '2025-09-17 04:54:39'),
(42, 48, 'Doc-42-WDHMDQ', 6, 'Doctor of Medicine (MD) or Doctor of Osteopathic Medicine (DO)', 'Yes', '16 yrs of experience', '6000', NULL, '2025-09-17 04:58:27', '2025-09-17 04:58:27'),
(43, 49, 'Doc-43-NTHJ4E', 6, 'Doctor of Medicine (MD) or Doctor of Osteopathic Medicine (DO)', 'Yes', '16 yrs of experience', '6000', NULL, '2025-09-17 05:04:10', '2025-09-17 05:04:10'),
(44, 50, 'Doc-44-BOIBPX', 2, 'Doctor of Medicine (MD) or Doctor of Osteopathic Medicine (DO)', 'Yes', '16 yrs of experience', '6000', NULL, '2025-09-18 00:48:08', '2025-09-18 00:48:08'),
(45, 51, 'Doc-45-NMIPO0', 4, 'Doctor of Medicine (MD) or Doctor of Osteopathic Medicine (DO)', 'Yes', '16 yrs of experience', '6000', NULL, '2025-09-18 01:26:09', '2025-09-18 01:26:09');

-- --------------------------------------------------------

--
-- Table structure for table `doctors_availabilities`
--

CREATE TABLE `doctors_availabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `days_of_week` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `description` longtext DEFAULT NULL,
  `language_spoken` varchar(255) DEFAULT NULL,
  `affiliated_hospital` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors_availabilities`
--

INSERT INTO `doctors_availabilities` (`id`, `user_id`, `doctor_id`, `start_time`, `end_time`, `days_of_week`, `status`, `description`, `language_spoken`, `affiliated_hospital`, `created_at`, `updated_at`) VALUES
(60, NULL, 40, '10:00:00', '12:30:00', 'Tuesday', 1, NULL, NULL, NULL, '2025-09-17 04:27:10', '2025-09-17 04:27:10'),
(61, NULL, 40, '14:00:00', '16:30:00', 'Thurseday', 1, NULL, NULL, NULL, '2025-09-17 04:27:10', '2025-09-17 04:27:10'),
(62, NULL, 41, '16:54:00', '16:54:00', 'Tuesday', 1, NULL, NULL, NULL, '2025-09-17 04:54:39', '2025-09-17 04:54:39'),
(63, NULL, 41, '20:54:00', '19:54:00', 'Wednesday', 1, NULL, NULL, NULL, '2025-09-17 04:54:39', '2025-09-17 04:54:39'),
(69, NULL, 42, '16:57:00', '17:57:00', 'Friday', 1, NULL, NULL, NULL, '2025-09-17 05:00:28', '2025-09-17 05:00:28'),
(70, NULL, 42, '01:58:00', '03:58:00', 'Saturday', 1, NULL, NULL, NULL, '2025-09-17 05:00:28', '2025-09-17 05:00:28'),
(71, NULL, 42, '20:59:00', '19:59:00', 'Sunday', 1, NULL, NULL, NULL, '2025-09-17 05:00:28', '2025-09-17 05:00:28'),
(81, NULL, 8, '10:00:00', '12:30:00', 'Tuesday', 1, NULL, NULL, NULL, '2025-09-17 05:12:43', '2025-09-17 05:12:43'),
(82, NULL, 8, '14:00:00', '18:00:00', 'Friday', 1, NULL, NULL, NULL, '2025-09-17 05:12:43', '2025-09-17 05:12:43'),
(83, NULL, 8, '10:00:00', '13:00:00', 'Thursday', 1, NULL, NULL, NULL, '2025-09-17 05:12:43', '2025-09-17 05:12:43'),
(84, NULL, 8, '18:00:00', '21:00:00', 'Sunday', 1, NULL, NULL, NULL, '2025-09-17 05:12:43', '2025-09-17 05:12:43'),
(91, NULL, 43, '20:04:00', '23:03:00', 'Friday', 1, NULL, NULL, NULL, '2025-09-17 06:46:55', '2025-09-17 06:46:55'),
(92, NULL, 43, '22:04:00', '21:04:00', 'Thursday', 1, NULL, NULL, NULL, '2025-09-17 06:46:55', '2025-09-17 06:46:55'),
(94, NULL, 44, '12:48:00', '14:48:00', 'Saturday', 1, NULL, NULL, NULL, '2025-09-18 00:48:37', '2025-09-18 00:48:37'),
(95, NULL, 45, '13:26:00', '16:26:00', 'Friday', 1, NULL, NULL, NULL, '2025-09-18 01:26:09', '2025-09-18 01:26:09'),
(104, NULL, 7, '18:10:00', '19:10:00', 'Monday', 1, NULL, NULL, NULL, '2025-09-18 02:52:42', '2025-09-18 02:52:42'),
(105, NULL, 7, '14:49:00', '15:49:00', 'Sunday', 1, NULL, NULL, NULL, '2025-09-18 02:52:42', '2025-09-18 02:52:42'),
(106, NULL, 7, '14:52:00', '16:52:00', 'Wednesday', 1, NULL, NULL, NULL, '2025-09-18 02:52:42', '2025-09-18 02:52:42');

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
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2025_07_29_000001_create_departments_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `medical_history` longtext DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `id_proof_type` varchar(255) DEFAULT NULL,
  `insurance_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `patient_id`, `date_of_birth`, `gender`, `phone`, `blood_type`, `medical_history`, `emergency_contact`, `id_proof_type`, `insurance_number`, `address`, `created_at`, `updated_at`, `created_by`, `deleted_at`) VALUES
(1, 1, 'Pat-1-3M8YSF', '2000-11-29', 'Male', '77994313151', 'AB+', NULL, '7799431314', NULL, NULL, 'Kukatpally, 500072', '2025-07-28 06:45:51', '2025-09-01 05:40:07', NULL, NULL),
(2, 13, 'Pat-2-TWASQM', '2000-02-29', 'Male', '9988776657', 'B+', NULL, NULL, NULL, NULL, 'test, testing patient, test, patient values', '2025-08-11 06:21:22', '2025-09-01 08:25:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `payment_mode` enum('Card','Online') NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `card_number_last4` char(4) DEFAULT NULL,
  `upi_id` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(3, 'App\\Models\\User', 1, 'PatientToken', '805a67e13bad112244f12622c402580eda0b71c6c0eb9756785f6d37b9561e1a', '[\"*\"]', '2025-07-29 01:01:05', NULL, '2025-07-28 23:51:48', '2025-07-29 01:01:05'),
(4, 'App\\Models\\User', 2, 'superadmin-token', '69aaa160d7e3563d483f46d4aaeb4d07748c5f94e6a4c2ce8cc635ab2ffb6dd2', '[\"*\"]', '2025-08-29 05:59:00', NULL, '2025-07-29 03:01:46', '2025-08-29 05:59:00'),
(6, 'App\\Models\\User', 11, 'DoctorToken', '615b1253132e43a603471c8d0288a56f578c60b0569f2ceb7813a7348fe8722c', '[\"*\"]', '2025-07-30 05:38:52', NULL, '2025-07-30 05:07:02', '2025-07-30 05:38:52'),
(8, 'App\\Models\\User', 1, 'PatientToken', '6b6eb1f01e03915f0ffc6fe08f4c0390413d7257eb75e12d7b73ab49c47c2a35', '[\"*\"]', '2025-07-31 06:27:39', NULL, '2025-07-31 03:41:17', '2025-07-31 06:27:39'),
(9, 'App\\Models\\User', 12, 'admin-token', 'a7bedbdd99c1c9179b208c6e296f50145f02da9afc934384d648f0161cc53d93', '[\"*\"]', NULL, NULL, '2025-08-04 05:54:46', '2025-08-04 05:54:46'),
(10, 'App\\Models\\User', 12, 'admin-token', 'f64de2b003b913b49b679e3a5abc60f481f297ee0c65411935617d499d69099e', '[\"*\"]', NULL, NULL, '2025-08-04 06:56:50', '2025-08-04 06:56:50'),
(11, 'App\\Models\\User', 12, 'admin-token', '081d52bc5f66e0cf7b6825c62ead5cf946535bad73989afc1751bb5e7948dce8', '[\"*\"]', NULL, NULL, '2025-08-04 06:58:16', '2025-08-04 06:58:16'),
(12, 'App\\Models\\User', 12, 'admin-token', 'a7d0d3427b059c8124d30748cd0ca36e7d83b487cbb1e3f2ac875ff4ede06685', '[\"*\"]', NULL, NULL, '2025-08-04 07:00:05', '2025-08-04 07:00:05'),
(13, 'App\\Models\\User', 12, 'admin-token', 'f2b39f9455b6b67cdc07c5180abadd8b50d9d34153bee0510f7593c66a11f4d0', '[\"*\"]', NULL, NULL, '2025-08-04 07:05:13', '2025-08-04 07:05:13'),
(16, 'App\\Models\\User', 12, 'admin-token', '54080243117fbc3a4a759b3f62029b99be9ebb203e197b3008dbced981e98891', '[\"*\"]', NULL, NULL, '2025-08-05 01:00:03', '2025-08-05 01:00:03'),
(17, 'App\\Models\\User', 12, 'admin-token', 'eace49b948979f429f35006cca74a76206f1ae6d276c5757b1b6a0a19aee9564', '[\"*\"]', NULL, NULL, '2025-08-05 02:14:26', '2025-08-05 02:14:26'),
(18, 'App\\Models\\User', 12, 'admin-token', '22ffc96e32c2a7ad4409ce2a1e89602bf54495b21b2fddcf57440e4c474f6cb4', '[\"*\"]', NULL, NULL, '2025-08-05 04:29:42', '2025-08-05 04:29:42'),
(19, 'App\\Models\\User', 12, 'admin-token', 'deb949ff0c90afd0dbe087497f7b5f1edc873635e36def8718091c936284bbd1', '[\"*\"]', NULL, NULL, '2025-08-06 00:55:45', '2025-08-06 00:55:45'),
(20, 'App\\Models\\User', 12, 'admin-token', 'a3d4640d9671e72da9bb37aaccf9a22a57ba63265615f669ab32f6821197bfac', '[\"*\"]', NULL, NULL, '2025-08-06 04:29:13', '2025-08-06 04:29:13'),
(21, 'App\\Models\\User', 12, 'admin-token', 'ff7183317b00da8becbfa74e30cc3a6866d109b56f9ce5a18b80f0eec6da11ac', '[\"*\"]', NULL, NULL, '2025-08-06 04:37:22', '2025-08-06 04:37:22'),
(22, 'App\\Models\\User', 12, 'admin-token', 'bdcc82cff084596bf21b3f656ba8920a1a4d54602149429f4c83d5d287c70f74', '[\"*\"]', NULL, NULL, '2025-08-06 05:06:46', '2025-08-06 05:06:46'),
(24, 'App\\Models\\User', 12, 'admin-token', 'f02a4dec2ffa8fd1d0a835df86e13d3455202dd78e0b35883e1132f19dcd13c8', '[\"*\"]', NULL, NULL, '2025-08-07 00:40:44', '2025-08-07 00:40:44'),
(25, 'App\\Models\\User', 12, 'admin-token', 'df303c9b5a9a8f68d69fdc55758357c1250badd25718ff407f7a004ace09f4ea', '[\"*\"]', NULL, NULL, '2025-08-07 01:13:08', '2025-08-07 01:13:08'),
(26, 'App\\Models\\User', 12, 'admin-token', 'a1ee8d1f0dbee1e035f2e277b6bed5f7df35bf2f7725382185f4be79f95fb73a', '[\"*\"]', NULL, NULL, '2025-08-07 01:18:08', '2025-08-07 01:18:08'),
(27, 'App\\Models\\User', 12, 'admin-token', '50a0c4304b550657f0d6f88f1a5ff3d5c4adbfa72c60d61bb95aa62add794298', '[\"*\"]', NULL, NULL, '2025-08-07 01:19:24', '2025-08-07 01:19:24'),
(28, 'App\\Models\\User', 12, 'admin-token', '545a478c02331c48249d4c80baa2bb74216831c86fdfd19373590b256452cc1a', '[\"*\"]', NULL, NULL, '2025-08-07 01:21:28', '2025-08-07 01:21:28'),
(29, 'App\\Models\\User', 12, 'admin-token', '4d982b3e54daa4ec666f1356d4a5a4b49b4a2ba51de30470e20a5435e25305fe', '[\"*\"]', NULL, NULL, '2025-08-07 01:33:12', '2025-08-07 01:33:12'),
(30, 'App\\Models\\User', 12, 'admin-token', '28229d0dc10108c783b005019579026eff6aeadf708ce1d22a098334472d0897', '[\"*\"]', NULL, NULL, '2025-08-07 01:35:44', '2025-08-07 01:35:44'),
(31, 'App\\Models\\User', 12, 'admin-token', '3ceaeb453d849a88e088644d7a38a7d016c744959628c01d24751bf56238e23c', '[\"*\"]', NULL, NULL, '2025-08-07 01:37:23', '2025-08-07 01:37:23'),
(32, 'App\\Models\\User', 12, 'admin-token', 'c4284c6bf804f3d5b0545bf7c5eb9d4a9fff2453a38f729d0e496c42e10cd310', '[\"*\"]', NULL, NULL, '2025-08-07 01:39:04', '2025-08-07 01:39:04'),
(33, 'App\\Models\\User', 12, 'admin-token', '4b11b7033aedd53685f60734428323b4428188c1b85bf5ca1819e9c856af9de2', '[\"*\"]', NULL, NULL, '2025-08-07 01:40:02', '2025-08-07 01:40:02'),
(34, 'App\\Models\\User', 12, 'admin-token', '8d15b718916620975f223b2075bd9ee7fed35d94721b4db8a01c1661b05a6746', '[\"*\"]', NULL, NULL, '2025-08-07 01:52:38', '2025-08-07 01:52:38'),
(35, 'App\\Models\\User', 12, 'admin-token', 'b344d83e7dea8637100875e65a417f8c3a55c1fbeefaa9d1a29e20e478f57925', '[\"*\"]', NULL, NULL, '2025-08-07 01:56:26', '2025-08-07 01:56:26'),
(36, 'App\\Models\\User', 12, 'admin-token', 'e6ddc2b20c83d8071aeff923a82ed881cdc5030e3b8149da4af88edea296842e', '[\"*\"]', NULL, NULL, '2025-08-07 02:06:18', '2025-08-07 02:06:18'),
(37, 'App\\Models\\User', 12, 'admin-token', '445eab75a501367607d259c5e26be9d8ded5455745a7ec4da6c06c0b012bbd72', '[\"*\"]', NULL, NULL, '2025-08-07 02:11:55', '2025-08-07 02:11:55'),
(38, 'App\\Models\\User', 12, 'admin-token', '53836a97e3d88f9152d4a5a4c11db21fb3ed0f6c88855ef1d011d1efaac522c5', '[\"*\"]', NULL, NULL, '2025-08-07 02:12:32', '2025-08-07 02:12:32'),
(39, 'App\\Models\\User', 12, 'admin-token', '6640a12cc50e8ca378a535605b0d7732fb5d892da2291c1ab74470d32be80d96', '[\"*\"]', NULL, NULL, '2025-08-07 02:28:29', '2025-08-07 02:28:29'),
(40, 'App\\Models\\User', 12, 'admin-token', '77c518f2ec1759a4ae65e60699111b72d69f83766ce03269c2a7eb57e00d780f', '[\"*\"]', NULL, NULL, '2025-08-07 02:28:57', '2025-08-07 02:28:57'),
(41, 'App\\Models\\User', 12, 'admin-token', 'e9b50861a3df26905c61b44f1d83ba279bd22470811ecf8542429a8cacb78c42', '[\"*\"]', NULL, NULL, '2025-08-07 02:30:18', '2025-08-07 02:30:18'),
(42, 'App\\Models\\User', 12, 'admin-token', 'ac43e6e28654f29b0dc7a5a6c7a3168ebe4bf6064a2aea7c578847f558e43e42', '[\"*\"]', NULL, NULL, '2025-08-07 02:31:07', '2025-08-07 02:31:07'),
(43, 'App\\Models\\User', 12, 'admin-token', 'f223700eb46fbe62178650bf2789a0b29d87019f4f9508b75d478998027cb924', '[\"*\"]', NULL, NULL, '2025-08-07 02:33:37', '2025-08-07 02:33:37'),
(44, 'App\\Models\\User', 12, 'admin-token', '89cb77ac9715f115136a53fba40530d7e72991a2df3d32f18ccf31ee0e2efd13', '[\"*\"]', NULL, NULL, '2025-08-07 02:37:51', '2025-08-07 02:37:51'),
(45, 'App\\Models\\User', 12, 'admin-token', '731fd06fd9e76a2e6d5e3af54616f0b6d98836c5b2401a8ddf02a84d6a2ee78d', '[\"*\"]', NULL, NULL, '2025-08-07 02:38:36', '2025-08-07 02:38:36'),
(46, 'App\\Models\\User', 12, 'admin-token', 'd554eb3936b2adb74f6ce204ac2426a66f068d07e7c046c0036fa8092dfcc539', '[\"*\"]', NULL, NULL, '2025-08-07 02:39:32', '2025-08-07 02:39:32'),
(47, 'App\\Models\\User', 12, 'admin-token', '4798f06e78495d702f39ada8e8c87e1319821885eb5defa61e13cc5bbfab7aa1', '[\"*\"]', NULL, NULL, '2025-08-07 02:43:02', '2025-08-07 02:43:02'),
(48, 'App\\Models\\User', 12, 'admin-token', 'db9ba792a4a2f3881714b2273bb2bca038d412cd3310d37c95bb5d25b406930b', '[\"*\"]', NULL, NULL, '2025-08-07 02:45:00', '2025-08-07 02:45:00'),
(49, 'App\\Models\\User', 12, 'admin-token', '2e05f5a478010b10bc855759413c559c4e14b3d179d253244483d9181d95176b', '[\"*\"]', NULL, NULL, '2025-08-07 02:48:51', '2025-08-07 02:48:51'),
(50, 'App\\Models\\User', 12, 'admin-token', 'fe975484b618d6a4f4f90f5c120f83671d8f6387676355f8276d4382aff71674', '[\"*\"]', NULL, NULL, '2025-08-07 02:50:59', '2025-08-07 02:50:59'),
(51, 'App\\Models\\User', 12, 'admin-token', '4703a74f6b6181b674657b25049b55cdc33b0f6a8811d8af5a5995a8b2fd3acc', '[\"*\"]', NULL, NULL, '2025-08-07 02:54:38', '2025-08-07 02:54:38'),
(52, 'App\\Models\\User', 12, 'admin-token', 'ccd6f3478d83077692f17d1762ed2e92125467a0364d9dcf48f578694f673880', '[\"*\"]', NULL, NULL, '2025-08-07 02:57:43', '2025-08-07 02:57:43'),
(53, 'App\\Models\\User', 12, 'admin-token', '523bf208f61780ac38265dd01217b261873485bd9c78fcc885ad6e78f2886e9f', '[\"*\"]', NULL, NULL, '2025-08-07 03:10:24', '2025-08-07 03:10:24'),
(54, 'App\\Models\\User', 12, 'admin-token', 'e6f45fa56697b1ec24e2a5d1cc600dab996b2fb3a4e06b18bede2d07bbd8b81e', '[\"*\"]', NULL, NULL, '2025-08-07 03:13:20', '2025-08-07 03:13:20'),
(55, 'App\\Models\\User', 12, 'admin-token', '27a00ea0b68b0bf6eeae92c51c12e62b3ee71019d01da0a7a5ee645f0b5533df', '[\"*\"]', NULL, NULL, '2025-08-07 03:20:36', '2025-08-07 03:20:36'),
(56, 'App\\Models\\User', 12, 'admin-token', 'a9173c13c45f23496bff647fbd7cb0b4fc2ee54911fcae2104a2ad26dd7e0789', '[\"*\"]', NULL, NULL, '2025-08-07 03:23:10', '2025-08-07 03:23:10'),
(62, 'App\\Models\\User', 12, 'admin-token', 'dc360b6b568a40eaa1134f235f00ad12a7a201272c605cd86decc03bb2e31215', '[\"*\"]', '2025-08-07 03:42:59', NULL, '2025-08-07 03:42:23', '2025-08-07 03:42:59'),
(63, 'App\\Models\\User', 12, 'admin-token', 'a2f07da1d9a510fac8d48ebadae2701af92ee37b2025da9f28cd45b3f5829ef4', '[\"*\"]', NULL, NULL, '2025-08-07 06:36:10', '2025-08-07 06:36:10'),
(65, 'App\\Models\\User', 12, 'admin-token', 'c5d448fbea82af10a2a05c0dcbe058835b711db05a8963f685d51fe93c045dc6', '[\"*\"]', '2025-08-07 07:09:20', NULL, '2025-08-07 06:52:32', '2025-08-07 07:09:20'),
(66, 'App\\Models\\User', 12, 'admin-token', '8cecceabd8f7e44ea1dd6fa335a06f82f79202ca0e1bb0c976bbf17fb603061e', '[\"*\"]', '2025-08-08 07:14:17', NULL, '2025-08-08 00:56:23', '2025-08-08 07:14:17'),
(68, 'App\\Models\\User', 12, 'admin-token', '1ad215aae80d9a09ebef271c640629e0b83f5f9db0ec7ec92ca3b120b9dd69d0', '[\"*\"]', NULL, NULL, '2025-08-11 02:16:04', '2025-08-11 02:16:04'),
(69, 'App\\Models\\User', 12, 'admin-token', '29b598a14750c6b054c87a6e3123758e81e1119d5275254e11b93e0ae9d5af70', '[\"*\"]', '2025-08-11 02:19:33', NULL, '2025-08-11 02:18:24', '2025-08-11 02:19:33'),
(70, 'App\\Models\\User', 12, 'admin-token', '7b807db76b31585c1d65be475eb091538d0ae13d8a75b4f92890b24f85b5df05', '[\"*\"]', '2025-08-11 10:20:52', NULL, '2025-08-11 05:46:04', '2025-08-11 10:20:52'),
(71, 'App\\Models\\User', 12, 'admin-token', 'e99e3937d5eba50b6237d9982aa93b40182f0f1d1e5ad2054351df25da34947f', '[\"*\"]', NULL, NULL, '2025-08-11 05:46:05', '2025-08-11 05:46:05'),
(72, 'App\\Models\\User', 12, 'admin-token', '8f5c13c01f2b29ec4b6c298dd0d91e9d506e8ca709ae06e213a75a424a50cb68', '[\"*\"]', '2025-08-11 23:55:39', NULL, '2025-08-11 22:38:12', '2025-08-11 23:55:39'),
(73, 'App\\Models\\User', 12, 'admin-token', 'fdd8b63593f5a5d01f9f1ae9174d01684f2cbb5947af467b0430f8ccce0665d0', '[\"*\"]', '2025-08-12 08:59:40', NULL, '2025-08-12 02:14:53', '2025-08-12 08:59:40'),
(75, 'App\\Models\\User', 12, 'admin-token', 'd7d9cac15de6d472a9e17c6ba316dac8f20df0444882003669a1e7ebd01da1e5', '[\"*\"]', NULL, NULL, '2025-08-13 09:10:42', '2025-08-13 09:10:42'),
(76, 'App\\Models\\User', 12, 'admin-token', '56a856385a205b318e440e3a1a94c460462e847503deffea98ade22e0101ccd6', '[\"*\"]', '2025-08-13 09:25:22', NULL, '2025-08-13 09:19:47', '2025-08-13 09:25:22'),
(77, 'App\\Models\\User', 12, 'admin-token', '597f831f61fa84c0f632b20e0aaa21c2078842f317030d20d7ef81806be4db44', '[\"*\"]', NULL, NULL, '2025-08-14 03:05:27', '2025-08-14 03:05:27'),
(78, 'App\\Models\\User', 12, 'admin-token', '396a741d8ba748dd97cbe00dd4c3dbe18f2202ba70c191b45032336586efcc8b', '[\"*\"]', NULL, NULL, '2025-08-14 03:36:24', '2025-08-14 03:36:24'),
(79, 'App\\Models\\User', 12, 'admin-token', '634320cd76179b0515d721269753dc6702b9783481beede56eb242eeabd77422', '[\"*\"]', '2025-08-14 06:45:36', NULL, '2025-08-14 03:48:14', '2025-08-14 06:45:36'),
(80, 'App\\Models\\User', 12, 'admin-token', '0c300571ca0bfedc17cf201acfd04c994e1291e249edcf30572ef1a5ac63dbfb', '[\"*\"]', '2025-08-14 06:59:57', NULL, '2025-08-14 06:45:56', '2025-08-14 06:59:57'),
(81, 'App\\Models\\User', 12, 'admin-token', '4244d9988ce368cb3130dfb006fb367ce0f3b80a28f00582e45e615ed741bc3c', '[\"*\"]', '2025-08-15 03:32:45', NULL, '2025-08-15 01:05:42', '2025-08-15 03:32:45'),
(82, 'App\\Models\\User', 12, 'admin-token', 'e6c79b6daed5945a31b77e542803bc334fd39d4331abab802f2d0a7e1ac40c73', '[\"*\"]', '2025-08-18 08:36:59', NULL, '2025-08-18 08:30:08', '2025-08-18 08:36:59'),
(83, 'App\\Models\\User', 12, 'admin-token', 'b7ef25ed7a483f5a360dca35258cdc5a7f66c66c380b395c9f11dcfd5673a15a', '[\"*\"]', NULL, NULL, '2025-08-18 23:57:31', '2025-08-18 23:57:31'),
(84, 'App\\Models\\User', 12, 'admin-token', 'b0cc4856c233822f307f89a90e4c7778dc0b2b564f8d8b6875e2aa2d15abe1e9', '[\"*\"]', '2025-08-19 07:28:10', NULL, '2025-08-19 00:15:53', '2025-08-19 07:28:10'),
(86, 'App\\Models\\User', 12, 'admin-token', '4908a4d5f66e4d8526b978d1e6457800b951584a8d53abda0ab2b94aac7b1aea', '[\"*\"]', '2025-08-19 09:41:52', NULL, '2025-08-19 09:41:51', '2025-08-19 09:41:52'),
(87, 'App\\Models\\User', 12, 'admin-token', '7b47fab857d88cdf6426aaafcdf8fe1279d9a4497d6ead201e072235bc36837a', '[\"*\"]', '2025-08-20 01:42:16', NULL, '2025-08-19 23:39:19', '2025-08-20 01:42:16'),
(88, 'App\\Models\\User', 12, 'admin-token', '49236b3c8659939b3f8ce3d7cc1c2e3747f0f300e087ec50650722460de16cba', '[\"*\"]', '2025-08-20 07:45:57', NULL, '2025-08-20 07:45:22', '2025-08-20 07:45:57'),
(89, 'App\\Models\\User', 12, 'admin-token', '85de3e6e2b0f8f06537d065e720e71456ea964e7b24d3f735e019ba1d85689c3', '[\"*\"]', '2025-08-21 03:26:55', NULL, '2025-08-21 02:47:59', '2025-08-21 03:26:55'),
(90, 'App\\Models\\User', 12, 'admin-token', 'ebec6f97d77b6f4b63bc3492c84c7e092d3c8de9bd31c676eb0dcd399d680b01', '[\"*\"]', '2025-08-21 05:46:16', NULL, '2025-08-21 05:36:22', '2025-08-21 05:46:16'),
(91, 'App\\Models\\User', 12, 'admin-token', 'f7ca7aa9ed4efe8d69ff8ed3572da8d29ed50d0736b1768eeab0c9d460f2415a', '[\"*\"]', '2025-08-22 02:30:17', NULL, '2025-08-22 00:31:38', '2025-08-22 02:30:17'),
(92, 'App\\Models\\User', 12, 'admin-token', '0aabc0aba836b9f9bf55611f0b3c9aab57f0a81bd57dd39b985174686c114429', '[\"*\"]', '2025-08-22 07:31:36', NULL, '2025-08-22 07:23:12', '2025-08-22 07:31:36'),
(93, 'App\\Models\\User', 12, 'admin-token', '799b3da83501f514bd0f9e51467ede47d303d6dcf3e5bfe5412af107f5771b7f', '[\"*\"]', NULL, NULL, '2025-08-22 07:23:17', '2025-08-22 07:23:17'),
(94, 'App\\Models\\User', 12, 'admin-token', '9fec2aee77abcbcae03a17c2ac419af7a20ebbdc09714ccb277bd4c779479b60', '[\"*\"]', '2025-08-23 07:34:17', NULL, '2025-08-23 07:28:59', '2025-08-23 07:34:17'),
(95, 'App\\Models\\User', 12, 'admin-token', '3f76907b760f68a748e5f6c1895c15eeea71817e327be14d11cd479ce405cd52', '[\"*\"]', '2025-08-25 01:03:49', NULL, '2025-08-25 01:00:27', '2025-08-25 01:03:49'),
(96, 'App\\Models\\User', 12, 'admin-token', '605a42aeef597c461a86e362a82b9de338867776a2b6bd01cbb4e1816fb48c7e', '[\"*\"]', NULL, NULL, '2025-08-25 01:00:30', '2025-08-25 01:00:30'),
(97, 'App\\Models\\User', 12, 'admin-token', '2964e8bffb142cbc73bfbd3ef75f0849a525cb6bbea9269e3bbe8a5293bd27b5', '[\"*\"]', '2025-08-25 06:13:24', NULL, '2025-08-25 01:04:04', '2025-08-25 06:13:24'),
(98, 'App\\Models\\User', 12, 'admin-token', '1e9ebfb358eeba398aa4ea1d38880a0e817e08ccafe3447e23b9de7c1a888e0c', '[\"*\"]', '2025-08-25 07:07:59', NULL, '2025-08-25 06:38:46', '2025-08-25 07:07:59'),
(99, 'App\\Models\\User', 12, 'admin-token', '3a09642305ac53af794e8530f9a1f45b690ecd500c513bc540dc2ba5bb9a0512', '[\"*\"]', '2025-08-26 05:24:31', NULL, '2025-08-26 00:16:53', '2025-08-26 05:24:31'),
(100, 'App\\Models\\User', 12, 'admin-token', '4e6c896d5f758cb2852983d7de1fdeb37e16cca57a76ca6b7f10f4f5999f7030', '[\"*\"]', '2025-08-28 08:12:59', NULL, '2025-08-28 03:38:54', '2025-08-28 08:12:59'),
(101, 'App\\Models\\User', 10, 'DoctorToken', 'ec76c9007b22dbcd89fae2a94fe2dba8b5e56cb4f1e86e1179da13de08d7a356', '[\"*\"]', NULL, NULL, '2025-08-29 00:17:08', '2025-08-29 00:17:08'),
(102, 'App\\Models\\User', 10, 'DoctorToken', '0e7cd9f0102d6cc9a9f157e374ad269b87507a682d1afa80466bb7e73eee1518', '[\"*\"]', NULL, NULL, '2025-08-29 00:17:22', '2025-08-29 00:17:22'),
(103, 'App\\Models\\User', 10, 'DoctorToken', '815d2b0834e8d6dadfa67237583870612e555e708adb5d415cb03cbf76c65634', '[\"*\"]', NULL, NULL, '2025-08-29 00:19:49', '2025-08-29 00:19:49'),
(104, 'App\\Models\\User', 10, 'DoctorToken', '51d7196566642f6b20ebfb66afba8ea62925f46b49f65965716558187e55f380', '[\"*\"]', NULL, NULL, '2025-08-29 00:20:17', '2025-08-29 00:20:17'),
(105, 'App\\Models\\User', 12, 'admin-token', '5d234789e98fbf527865686f86558150f4071f9b5ac864b8df1728ffb5759ec4', '[\"*\"]', NULL, NULL, '2025-08-29 01:35:57', '2025-08-29 01:35:57'),
(106, 'App\\Models\\User', 12, 'admin-token', 'bf4b16a4347e123e3ebbfb9bf0b60e0814914e7c6b4677b05e8040c744f8e92c', '[\"*\"]', NULL, NULL, '2025-08-29 01:35:59', '2025-08-29 01:35:59'),
(107, 'App\\Models\\User', 12, 'admin-token', 'd9d2177ea9215324dd70811eae0540eaa51911278422b41f090ec1dbd3fc2811', '[\"*\"]', NULL, NULL, '2025-08-29 01:48:36', '2025-08-29 01:48:36'),
(108, 'App\\Models\\User', 10, 'DoctorToken', 'b385d952da6ae8b5d06a93c9a8889805e9898b8902cd64de8b37d880270d9f18', '[\"*\"]', NULL, NULL, '2025-08-29 01:49:08', '2025-08-29 01:49:08'),
(109, 'App\\Models\\User', 10, 'DoctorToken', '31042539057273e86c24b18765e64512b4354cf67b21fff3a2bdb87ff35a34bb', '[\"*\"]', NULL, NULL, '2025-08-29 02:01:14', '2025-08-29 02:01:14'),
(115, 'App\\Models\\User', 10, 'DoctorToken', 'a7ea2ccf58ae640dfeff43c21d3d1a0aca4d2d20a4fe81293d0de8ed24ae4c68', '[\"*\"]', NULL, NULL, '2025-08-29 04:59:58', '2025-08-29 04:59:58'),
(126, 'App\\Models\\User', 11, 'DoctorToken', '19977d685755d61258587cd8f7dbce60016eb49f6d5806dbc1c3a18df1d1f217', '[\"*\"]', '2025-08-29 08:55:10', NULL, '2025-08-29 06:29:17', '2025-08-29 08:55:10'),
(136, 'App\\Models\\User', 12, 'admin-token', 'dd8eb195526e12a1bcc1eaa202306e086846d9d40f9ee78eb62db425aaedef5f', '[\"*\"]', '2025-08-30 06:19:42', NULL, '2025-08-30 05:18:01', '2025-08-30 06:19:42'),
(138, 'App\\Models\\User', 2, 'admin-token', '913f8b8e7b05ee65369aaf0754676483070f30222c085848cc83e788bfcf0f8a', '[\"*\"]', NULL, NULL, '2025-08-30 07:11:29', '2025-08-30 07:11:29'),
(140, 'App\\Models\\User', 2, 'admin-token', 'eda59075e8518601b48c55d8db56161d2d368400eafd05b49fadcb51d624b10c', '[\"*\"]', NULL, NULL, '2025-08-30 07:14:39', '2025-08-30 07:14:39'),
(141, 'App\\Models\\User', 2, 'admin-token', 'b43510b6ce864b8d7ab26a3560a5022b9b7c54f1ea7701eee57dedb0052e1b62', '[\"*\"]', NULL, NULL, '2025-08-30 07:21:54', '2025-08-30 07:21:54'),
(142, 'App\\Models\\User', 2, 'admin-token', '96eda3e18b9f07cd362920a6472bb1a4b1ca72fb4b4a53596d3c4c61d9e6d925', '[\"*\"]', NULL, NULL, '2025-08-30 07:23:24', '2025-08-30 07:23:24'),
(148, 'App\\Models\\User', 2, 'admin-token', '4a258dfc75569f5cb7f4115ae56538a40dae57c1e08a80995071d1de1c50dae3', '[\"*\"]', '2025-08-30 08:26:26', NULL, '2025-08-30 08:06:39', '2025-08-30 08:26:26'),
(150, 'App\\Models\\User', 12, 'admin-token', 'b98b8f076d6c780f2a03a045a3a19906e7543d4869191f1f17fa22d9c4038f30', '[\"*\"]', '2025-08-30 08:42:24', NULL, '2025-08-30 08:37:56', '2025-08-30 08:42:24'),
(151, 'App\\Models\\User', 10, 'DoctorToken', 'c8d12d782c5add449747ff03b64f93a83f0ad7b96074c58c0f44ccd4d3f44c03', '[\"*\"]', '2025-08-30 08:43:32', NULL, '2025-08-30 08:43:26', '2025-08-30 08:43:32'),
(153, 'App\\Models\\User', 1, 'admin-token', 'edb6dd1ab2d1ab0739530d46eaa423fdf8b12ef05dccc6277a987a6b94212886', '[\"*\"]', '2025-08-30 08:55:20', NULL, '2025-08-30 08:54:52', '2025-08-30 08:55:20'),
(155, 'App\\Models\\User', 2, 'admin-token', 'dfb029eaf608bbe975016c6180e62c59397b89231d819a7b162065609f66817a', '[\"*\"]', '2025-08-30 09:07:09', NULL, '2025-08-30 09:07:08', '2025-08-30 09:07:09'),
(156, 'App\\Models\\User', 2, 'admin-token', 'c268d088c9324e90edf5d72706f67beccebaa30d18eb113d2c85599cdd45aca1', '[\"*\"]', '2025-09-01 00:29:42', NULL, '2025-09-01 00:23:15', '2025-09-01 00:29:42'),
(158, 'App\\Models\\User', 2, 'admin-token', '6660474b5ac53418c328037811ccc22d94d3ac9c2bd50222b5bd8ac84f661ed2', '[\"*\"]', '2025-09-01 00:48:55', NULL, '2025-09-01 00:48:54', '2025-09-01 00:48:55'),
(162, 'App\\Models\\User', 12, 'admin-token', '56121c3c66e4c4673f242a5c202b600228806fe8aedbe69e19e7eb516ac3dbef', '[\"*\"]', '2025-09-01 00:59:17', NULL, '2025-09-01 00:59:17', '2025-09-01 00:59:17'),
(189, 'App\\Models\\User', 2, 'admin-token', 'ee7c87bea6dd536778be623074eb3d5c524ff851ec76105ffec32be3f809dcf5', '[\"*\"]', '2025-09-01 05:56:03', NULL, '2025-09-01 05:30:29', '2025-09-01 05:56:03'),
(190, 'App\\Models\\User', 2, 'admin-token', '280efadb731cfd5d8cef569c2a30f2946bc89d49e42256966cef26801be0f198', '[\"*\"]', '2025-09-01 08:49:50', NULL, '2025-09-01 06:10:42', '2025-09-01 08:49:50'),
(221, 'App\\Models\\User', 2, 'admin-token', '2b92cf675bbe187443c7311531910f6be3b5c5f8f3dd1b3e7fbaa380c1defdc0', '[\"*\"]', '2025-09-02 07:27:06', NULL, '2025-09-02 06:45:28', '2025-09-02 07:27:06'),
(226, 'App\\Models\\User', 2, 'admin-token', 'd903defeaa0ed78141aa899e2b7fa0d047d4c998f3844bc0f01ebee8fb2ea87a', '[\"*\"]', '2025-09-03 08:17:37', NULL, '2025-09-03 05:38:42', '2025-09-03 08:17:37'),
(230, 'App\\Models\\User', 2, 'admin-token', '2b14d7386ce101a2bcbf05a56c7e96c7082698e63bd37cec055352463d8ec528', '[\"*\"]', '2025-09-04 07:48:43', NULL, '2025-09-04 06:08:39', '2025-09-04 07:48:43'),
(231, 'App\\Models\\User', 2, 'admin-token', '20bb3055a403255bf15566ae7b5921d2cec32146323f2d33a856172e81295513', '[\"*\"]', '2025-09-04 23:16:47', NULL, '2025-09-04 23:11:21', '2025-09-04 23:16:47'),
(232, 'App\\Models\\User', 2, 'admin-token', '505b365f8b94483797e5da034925f3f96d65189ade9bc9b108bb9a1f9c888654', '[\"*\"]', '2025-09-05 02:06:57', NULL, '2025-09-04 23:20:14', '2025-09-05 02:06:57'),
(234, 'App\\Models\\User', 2, 'admin-token', 'ad94fd8f5084d4a9026d6dfde23ed68e342761e6ecac5e7be050120d0f3ce780', '[\"*\"]', '2025-09-05 05:56:05', NULL, '2025-09-05 02:19:27', '2025-09-05 05:56:05'),
(235, 'App\\Models\\User', 2, 'admin-token', '3da46a3b4f4a718a6706822e12ddc849221b044a9da6bd1ce2a4d5c2cc1e0c5d', '[\"*\"]', '2025-09-07 23:40:42', NULL, '2025-09-07 23:40:41', '2025-09-07 23:40:42'),
(236, 'App\\Models\\User', 2, 'admin-token', '58f8b03764ca0eb3a84d4847b4b88afc7db62afb5e05152b44eba127e42a1453', '[\"*\"]', '2025-09-07 23:43:49', NULL, '2025-09-07 23:40:42', '2025-09-07 23:43:49'),
(238, 'App\\Models\\User', 2, 'admin-token', 'ed1bc2d6bb30d570cb171d4173e4ea6c64883433c208399fe37e22230680ca24', '[\"*\"]', '2025-09-08 01:58:05', NULL, '2025-09-08 00:11:20', '2025-09-08 01:58:05'),
(239, 'App\\Models\\User', 2, 'admin-token', 'd1bff613617f695c5c3786a19327bb46b2992a467981d405664a41a3cc88a287', '[\"*\"]', '2025-09-08 02:08:18', NULL, '2025-09-08 01:58:42', '2025-09-08 02:08:18'),
(241, 'App\\Models\\User', 2, 'admin-token', '04406977e25a0a1924bd1b0327353307ff3af29c970b050b5a5a8ec4b4ae6b23', '[\"*\"]', '2025-09-08 08:12:21', NULL, '2025-09-08 02:41:37', '2025-09-08 08:12:21'),
(242, 'App\\Models\\User', 2, 'admin-token', 'c5bcb36d289569e2eafcb7dd1a6c456d063624b94a618b19cea2a052daa66a7f', '[\"*\"]', '2025-09-08 07:58:46', NULL, '2025-09-08 02:46:46', '2025-09-08 07:58:46'),
(243, 'App\\Models\\User', 2, 'admin-token', '15878a00b3ea8a53c94bd27953e7c01fc580238e1f958f4e402ac43326aef922', '[\"*\"]', '2025-09-08 08:33:50', NULL, '2025-09-08 08:25:42', '2025-09-08 08:33:50'),
(244, 'App\\Models\\User', 2, 'admin-token', '2d11d746d12727b9fe0a456c8dce49e38f9f8a01de49ad1da76049c294b622cc', '[\"*\"]', '2025-09-08 23:40:14', NULL, '2025-09-08 23:26:57', '2025-09-08 23:40:14'),
(245, 'App\\Models\\User', 2, 'admin-token', 'd388a64b79b6d86351e34a7ba7ff76eeab475a37aa135d19eebb8402e17abca7', '[\"*\"]', '2025-09-09 00:17:05', NULL, '2025-09-09 00:04:29', '2025-09-09 00:17:05'),
(247, 'App\\Models\\User', 2, 'admin-token', 'c26bbb2c1fd3aef66528329af2ce81dc67d1ae27bf4d24925602216405e4b036', '[\"*\"]', '2025-09-09 00:20:50', NULL, '2025-09-09 00:18:49', '2025-09-09 00:20:50'),
(253, 'App\\Models\\User', 2, 'admin-token', '333df46b4a7b5920dcea7dfaab69c6bcd99adfb55f1f0ca25964b2ff99a1f644', '[\"*\"]', '2025-09-09 08:32:26', NULL, '2025-09-09 07:13:08', '2025-09-09 08:32:26'),
(265, 'App\\Models\\User', 2, 'admin-token', 'f7451fd7b42087879d0440077928e3a8e026d5e7034c826a07a0c38a83d835fd', '[\"*\"]', '2025-09-10 01:55:45', NULL, '2025-09-10 01:55:44', '2025-09-10 01:55:45'),
(269, 'App\\Models\\User', 2, 'admin-token', 'c4746314aa5b14b6f258e65c0f482a86342c1aa7d583a3130243b6191089b184', '[\"*\"]', '2025-09-10 05:48:22', NULL, '2025-09-10 05:19:34', '2025-09-10 05:48:22'),
(272, 'App\\Models\\User', 2, 'admin-token', '287a21905f85bcbb92d08e1abc24e467488d97d0cef15839119b8f931e2a64dd', '[\"*\"]', '2025-09-10 07:43:16', NULL, '2025-09-10 06:32:47', '2025-09-10 07:43:16'),
(273, 'App\\Models\\User', 2, 'admin-token', 'c72bab41289e8fc51af224197eadb0e9ddd22482c884041b3a9d916d159dc53b', '[\"*\"]', '2025-09-11 00:02:33', NULL, '2025-09-10 23:18:14', '2025-09-11 00:02:33'),
(277, 'App\\Models\\User', 2, 'admin-token', '9cfc518d819b6e59ea3fda86dba68be0391fee6e0df09ccafeab215631a3f7bb', '[\"*\"]', '2025-09-11 06:11:24', NULL, '2025-09-11 00:46:46', '2025-09-11 06:11:24'),
(279, 'App\\Models\\User', 2, 'admin-token', '2c5411bec0d3a4306eacd2a944ff865a331e1fb81526f4f496300591bab58cd6', '[\"*\"]', '2025-09-11 08:06:32', NULL, '2025-09-11 06:46:07', '2025-09-11 08:06:32'),
(280, 'App\\Models\\User', 2, 'admin-token', '05cc7bfdc4da769b30acffd65fa4506bc7d01beb92951dfc4d9be10bea5dcc1c', '[\"*\"]', '2025-09-12 01:08:10', NULL, '2025-09-12 00:10:49', '2025-09-12 01:08:10'),
(281, 'App\\Models\\User', 12, 'admin-token', '3e74cbe433efa6f9598bf9f9e3939e0beef141c350d961f63fbdea83c2c85478', '[\"*\"]', '2025-09-12 05:48:29', NULL, '2025-09-12 00:14:44', '2025-09-12 05:48:29'),
(285, 'App\\Models\\User', 2, 'admin-token', '62608cef1089bf07f15c62676ae3623f8270b8a662a067e8ef6a37cd780b2e35', '[\"*\"]', '2025-09-12 08:15:55', NULL, '2025-09-12 06:55:43', '2025-09-12 08:15:55'),
(293, 'App\\Models\\User', 2, 'admin-token', '0636190c8e0c2c05dc6a7d920e525cda06502de238b4460712ba06be23f76d8d', '[\"*\"]', '2025-09-13 05:53:11', NULL, '2025-09-13 05:48:31', '2025-09-13 05:53:11'),
(295, 'App\\Models\\User', 2, 'admin-token', '9744cabcd871f89d167035383e8ad216e80a77565436793e3fe6aa75c619fcbe', '[\"*\"]', '2025-09-13 06:34:02', NULL, '2025-09-13 06:03:51', '2025-09-13 06:34:02'),
(298, 'App\\Models\\User', 2, 'admin-token', '00921f9a059bd95ef59095df3606a295247bd33554106abdca5cad78b40d8dda', '[\"*\"]', '2025-09-15 03:11:38', NULL, '2025-09-15 03:00:07', '2025-09-15 03:11:38'),
(303, 'App\\Models\\User', 2, 'admin-token', '8eb6ca49804fe4e4d018084217fec6f0097289b8fbaa543d50bb95208ce45fc5', '[\"*\"]', '2025-09-15 05:10:10', NULL, '2025-09-15 04:28:39', '2025-09-15 05:10:10'),
(304, 'App\\Models\\User', 2, 'admin-token', '0b7ff4a994d848980b04ff41c423f808f4380f65f9e9b2bb881708661ff56fe4', '[\"*\"]', '2025-09-15 08:32:02', NULL, '2025-09-15 07:14:05', '2025-09-15 08:32:02'),
(307, 'App\\Models\\User', 2, 'admin-token', '8c36eaf1790cc10c2a0c7a7156b0dc20141dede81bf34c82f1e160cf713b0a84', '[\"*\"]', '2025-09-15 23:57:56', NULL, '2025-09-15 23:50:47', '2025-09-15 23:57:56'),
(309, 'App\\Models\\User', 2, 'admin-token', '67edb7ddb16acd78e57ead8b5d3d84546135476205e3912d366c24c9b46fd34a', '[\"*\"]', '2025-09-16 07:29:21', NULL, '2025-09-16 02:41:50', '2025-09-16 07:29:21'),
(311, 'App\\Models\\User', 2, 'admin-token', 'd72e59aae54c2b7cbd9c55556095660c74ffa0e82f26eb490c87f1620f3e6196', '[\"*\"]', '2025-09-17 06:47:11', NULL, '2025-09-17 02:01:27', '2025-09-17 06:47:11'),
(312, 'App\\Models\\User', 2, 'admin-token', 'e1ae88c58fe247bcfc2451cdc8373678f906c94a566c8c5899eec2c2fe29383a', '[\"*\"]', '2025-09-18 02:15:01', NULL, '2025-09-18 00:43:30', '2025-09-18 02:15:01'),
(313, 'App\\Models\\User', 2, 'admin-token', '4d0c48db488dc1f811cfc26292f41968947c1edd4e9e6e7bb966cdbc8dbe84cf', '[\"*\"]', '2025-09-18 04:58:30', NULL, '2025-09-18 02:51:07', '2025-09-18 04:58:30'),
(314, 'App\\Models\\User', 2, 'admin-token', '140d024dfbc41a9c8afc9d13e8c08a39ef71eda77de5f1e1c40cdaa56972e230', '[\"*\"]', '2025-09-18 06:19:49', NULL, '2025-09-18 05:11:39', '2025-09-18 06:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--
-- Error reading structure for table hms_cm.products: #1932 - Table &#039;hms_cm.products&#039; doesn&#039;t exist in engine
-- Error reading data for table hms_cm.products: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `hms_cm`.`products`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Medicines', NULL, 'active', '2025-08-20 10:09:13', '2025-09-12 08:11:26'),
(2, 'Syrups', NULL, 'active', '2025-08-20 10:09:13', '2025-08-20 10:09:13'),
(3, 'Injections', NULL, 'active', '2025-08-20 10:09:13', '2025-08-20 10:09:13'),
(5, 'Inhalers', 'Inhalers are handheld devices used to deliver medication directly to the lungs, typically for respiratory conditions like asthma and COPD.', 'active', '2025-08-21 07:26:38', '2025-08-21 07:26:46');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--
-- Error reading structure for table hms_cm.purchases: #1932 - Table &#039;hms_cm.purchases&#039; doesn&#039;t exist in engine
-- Error reading data for table hms_cm.purchases: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `hms_cm`.`purchases`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(20) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `patient_name` varchar(150) DEFAULT NULL,
  `patient_phone_number` varchar(20) DEFAULT NULL,
  `sale_date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gst_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_type` enum('Cash','Card','Online') NOT NULL DEFAULT 'Cash',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `net_amount` decimal(12,2) GENERATED ALWAYS AS (`total_amount` - `discount`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_no`, `patient_id`, `patient_name`, `patient_phone_number`, `sale_date`, `quantity`, `total_amount`, `discount`, `gst_amount`, `payment_type`, `created_at`, `updated_at`) VALUES
(1, 'B-1-0000001', NULL, 'SureshKonda', '7799431314', '2025-08-15', 10, 100.00, 5.00, 5.00, 'Cash', '2025-08-20 10:19:10', '2025-08-25 07:54:34'),
(2, 'B-2-0000002', NULL, 'SureshKonda', '7799431314', '2025-08-16', 5, 75.00, 0.00, 3.75, 'Cash', '2025-08-20 10:19:10', '2025-08-25 07:54:34'),
(4, 'B-4-0000004', 1, NULL, NULL, '2025-08-23', 7, 273.25, 0.00, 8.75, 'Cash', '2025-08-23 05:50:49', '2025-08-25 07:17:57'),
(7, NULL, NULL, NULL, NULL, '2025-08-28', 1, 95.20, 0.00, 10.20, 'Cash', '2025-08-28 05:14:23', '2025-08-28 05:14:25'),
(8, NULL, NULL, NULL, NULL, '2025-08-28', 1, 95.20, 0.00, 10.20, 'Cash', '2025-08-28 05:23:10', '2025-08-28 05:23:10'),
(9, NULL, NULL, NULL, NULL, '2025-08-28', 2, 145.20, 0.00, 10.20, 'Cash', '2025-08-28 07:18:55', '2025-08-28 07:18:55'),
(10, NULL, NULL, NULL, NULL, '2025-08-28', 2, 145.20, 0.00, 10.20, 'Cash', '2025-08-28 07:25:49', '2025-08-28 07:25:49'),
(11, NULL, NULL, NULL, NULL, '2025-08-28', 1, 95.20, 0.00, 10.20, 'Cash', '2025-08-28 07:39:29', '2025-08-28 07:39:29'),
(12, NULL, NULL, NULL, NULL, '2025-08-28', 1, 95.20, 0.00, 10.20, 'Cash', '2025-08-28 07:44:22', '2025-08-28 07:44:22'),
(13, NULL, NULL, 'suresh', '7799431314', '2025-08-28', 1, 50.00, 0.00, 0.00, 'Cash', '2025-08-28 07:46:05', '2025-08-28 07:46:05'),
(14, NULL, NULL, 'suresh', '7799431314', '2025-08-28', 1, 95.20, 0.00, 10.20, 'Card', '2025-08-28 08:07:25', '2025-09-01 08:36:25'),
(16, 'B-16-0000016', NULL, 'suresh', '7799431314', '2025-08-28', 1, 50.00, 0.00, 0.00, 'Card', '2025-08-28 08:12:51', '2025-09-01 08:35:49'),
(17, 'B-17-0000017', NULL, 'SureshKondanew', '87978978987', '2025-09-18', 1, 105.00, 0.00, 5.00, 'Cash', '2025-09-11 06:50:59', '2025-09-11 06:50:59'),
(18, 'B-18-0000018', NULL, 'SureshKondanew123', '87978978987', '2025-09-18', 1, 84.00, 0.00, 4.00, 'Cash', '2025-09-12 08:01:36', '2025-09-12 08:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `batch_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `mrp` decimal(12,2) DEFAULT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gst_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `gst_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) GENERATED ALWAYS AS (`quantity` * `price`) STORED,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `batch_id`, `quantity`, `price`, `mrp`, `discount`, `gst_percent`, `gst_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 10, 10.00, NULL, 0.00, 0.00, 0.00, '2025-08-20 10:23:37', '2025-08-20 10:23:37'),
(2, 2, 2, 2, 5, 15.00, NULL, 0.00, 0.00, 0.00, '2025-08-20 10:23:37', '2025-08-20 10:23:37'),
(5, 4, 3, 3, 5, 35.00, NULL, 10.50, 5.00, 8.75, '2025-08-23 06:59:47', '2025-08-23 06:59:47'),
(6, 4, 2, 2, 2, 50.00, NULL, 0.00, 0.00, 0.00, '2025-08-23 06:59:47', '2025-08-23 06:59:47'),
(7, 7, 1, 10, 1, 85.00, NULL, 0.00, 12.00, 10.20, '2025-08-28 05:14:24', '2025-08-28 05:14:24'),
(8, 8, 1, 10, 1, 85.00, NULL, 0.00, 12.00, 10.20, '2025-08-28 05:23:10', '2025-08-28 05:23:10'),
(9, 9, 1, 10, 1, 85.00, NULL, 0.00, 12.00, 10.20, '2025-08-28 07:18:55', '2025-08-28 07:18:55'),
(10, 9, 2, 2, 1, 50.00, NULL, 0.00, 0.00, 0.00, '2025-08-28 07:18:55', '2025-08-28 07:18:55'),
(11, 10, 1, 10, 1, 85.00, NULL, 0.00, 12.00, 10.20, '2025-08-28 07:25:49', '2025-08-28 07:25:49'),
(12, 10, 2, 2, 1, 50.00, NULL, 0.00, 0.00, 0.00, '2025-08-28 07:25:49', '2025-08-28 07:25:49'),
(13, 11, 1, 10, 1, 85.00, NULL, 0.00, 12.00, 10.20, '2025-08-28 07:39:29', '2025-08-28 07:39:29'),
(14, 12, 1, 10, 1, 85.00, NULL, 0.00, 12.00, 10.20, '2025-08-28 07:44:22', '2025-08-28 07:44:22'),
(15, 13, 2, 2, 1, 50.00, NULL, 0.00, 0.00, 0.00, '2025-08-28 07:46:05', '2025-08-28 07:46:05'),
(16, 14, 1, 10, 1, 85.00, NULL, 0.00, 12.00, 10.20, '2025-08-28 08:07:25', '2025-08-28 08:07:25'),
(17, 16, 2, 2, 1, 50.00, NULL, 0.00, 0.00, 0.00, '2025-08-28 08:12:51', '2025-08-28 08:12:51'),
(18, 17, 3, 63, 1, 100.00, NULL, 0.00, 5.00, 5.00, '2025-09-11 06:50:59', '2025-09-11 06:50:59'),
(19, 18, 3, 52, 1, 80.00, NULL, 0.00, 5.00, 4.00, '2025-09-12 08:01:36', '2025-09-12 08:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_number`, `email`, `contact_no`, `address`, `created_at`, `updated_at`) VALUES
(1, 'HealthCare Distributors', NULL, NULL, NULL, 'Hyderabad', '2025-08-08 10:09:13', '0000-00-00 00:00:00'),
(2, 'MediSupply Pvt Ltd', NULL, NULL, NULL, 'Bangalore', '2025-08-20 10:09:13', '2025-08-20 10:09:13'),
(4, 'Sri Laxmi Medical Agencies', '7947424260', 'srilaxmimedicalagencies@gmail.com', NULL, 'Ameerpet, Hyderabad', '2025-08-10 01:34:12', '2025-09-12 06:52:45');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `short_name` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `short_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Tablet', 'tab', NULL, '2025-08-20 10:11:18', '2025-08-20 10:11:18'),
(2, 'Bottle', 'btl', NULL, '2025-08-20 10:11:18', '2025-08-20 10:11:18'),
(3, 'Strip', 'str', NULL, '2025-08-20 10:11:18', '2025-08-20 10:11:18'),
(5, 'Lozenge', 'Lozenge', 'It is a solid preparation consisting of sugar and gum, Used for cough remedy.', '2025-08-22 02:29:06', '2025-08-22 02:29:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `image`, `status`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Suresh Kumar Konda1', 'suresh@konda.com', '$2y$12$U9LUGOaF0399s5erhFZhXugTgV7vv.5GAhUQdjD4aP6NLyXWtGx7K', '77994313151', 'admin', 'http://127.0.0.1:8080/images/users/1756812597_2.jpg', 'active', NULL, NULL, '2025-07-28 06:45:50', '2025-09-10 01:31:23', NULL),
(2, 'Suresh', 'sureshkumar20223@konda.com', '$2y$12$hHYA02c4JKBZCj5lvdksDOyJraV/dZUvMglgqsXTqAvKWv1KExdZO', '7799431316', 'superadmin', 'http://127.0.0.1:8080/images/users/1757762285_AdobeStock_636814944_Preview.jpeg', 'active', NULL, NULL, '2025-07-29 02:55:22', '2025-09-13 05:48:05', NULL),
(10, 'Suresh', 'sureshkumar2020@konda.com', '$2y$12$tAa5VitVDvKwOnVGrXpr0.MKcam.iUCJSi2KOOZTP3JRlzWBymPaK', '7799431315', 'doctor', 'http://127.0.0.1:8080/images/doctors/1756707151_doctorimage.jpg', 'active', NULL, NULL, '2025-07-30 01:59:10', '2025-09-17 06:41:24', NULL),
(11, 'Suresh one', 'sureshkumar20221@konda.com', '$2y$12$yxk3bc6BVeoDafPcWDqCD.Zk/4tQjOes0zVSSkJRNMoNkISft4kUi', '7799431316', 'doctor', 'http://127.0.0.1:8080/images/doctors/1756791110_doctorimage.jpg', 'active', NULL, NULL, '2025-07-30 02:08:18', '2025-09-02 00:01:50', NULL),
(12, 'suresh', 'sureshkumarkonda@ddcloud.in', '$2y$12$ARdZyQZzJZRvStcUo0.fVul72DAOlpxSCaWY0wTiSOCQYLIQ06xtm', '7799431314', 'frontdesk', 'http://127.0.0.1:8080/images/users/1756812719_1756803389_doctorimage.jpg', 'active', NULL, NULL, '2025-08-04 04:06:46', '2025-09-02 06:39:38', NULL),
(13, 'testing patient one', 'testingpatient@gmail.com', '$2y$12$9V6xGtnjpYllO/lBErKTsONhznn1La9Fi6AsD8PKyrY5e/YGceYj6', '9988776657', 'patient', 'http://127.0.0.1:8080/images/doctors/1756707151_doctorimage.jpg', 'active', NULL, NULL, '2025-08-11 06:21:21', '2025-08-11 08:59:46', NULL),
(46, 'Suresh', 'sureshkumar2022@konda.com', '$2y$12$OBZCcCs7QO5wX.n55m8ifOS0SvI1dol6Dt1i96VWornaXZNopPole', '7799431316', 'doctor', NULL, 'active', NULL, NULL, '2025-09-17 04:27:10', '2025-09-17 04:27:10', NULL),
(47, 'kumarvbbbb', 'kumar081298vllkkbbbbbnnnb@gmail.com', '$2y$12$rVsJyxrb7/qoC4XuY4DP/uhlmt9F6gQO/KFCNLOP88aIFlzEWnifi', '7799431315', 'doctor', NULL, 'active', NULL, NULL, '2025-09-17 04:54:39', '2025-09-17 04:54:39', NULL),
(48, 'kumar', 'kumar12233@gmail.com', '$2y$12$lxNapDyHmk0HgxPALbSNdeyZJjPA8NvG1kVkRI3alxQEdyAgdhvQC', '7799431315', 'doctor', NULL, 'active', NULL, NULL, '2025-09-17 04:58:27', '2025-09-17 04:58:27', NULL),
(49, 'kumar', 'kumar12bbb233988@gmail.com', '$2y$12$vqof.RGvBQ55.GeOO4Xo.e8FUOZOfwzYnn7QKHGExdnE1t0TvOgMO', '7799431315', 'doctor', NULL, 'active', NULL, NULL, '2025-09-17 05:04:10', '2025-09-17 06:46:55', NULL),
(50, 'kumar new', 'kumarccc12bbb233@gmail.com', '$2y$12$MOu11eQGE0uQHW8s71KcBO93KjOejrnpPVQ9WFfA2KwpcXqw06w8S', '7799431315', 'doctor', NULL, 'active', NULL, NULL, '2025-09-18 00:48:08', '2025-09-18 00:48:37', NULL),
(51, 'kumar', 'kumarccc1jj2bbb233@gmail.com', '$2y$12$DK5GRAbRIxHUuad5tPuEB./p0BiUTro03D7.6Dpl.F/1EyGkf..Fu', '7799431315', 'doctor', NULL, 'active', NULL, NULL, '2025-09-18 01:26:09', '2025-09-18 01:26:09', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_appointments_patient` (`patient_id`),
  ADD KEY `fk_appointments_doctor` (`doctor_id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_batch_no` (`batch_no`),
  ADD KEY `idx_expiry_date` (`expiry_date`),
  ADD KEY `fk_batches_purchase` (`purchase_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`);

--
-- Indexes for table `booking_schedules`
--
ALTER TABLE `booking_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_schedules_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `customer_subscriptions`
--
ALTER TABLE `customer_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_user_id_foreign` (`user_id`);

--
-- Indexes for table `doctors_availabilities`
--
ALTER TABLE `doctors_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_availabilities_user_id_foreign` (`user_id`),
  ADD KEY `fk_doctors` (`doctor_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_user_id_foreign` (`user_id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_sale` (`sale_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_category_name` (`name`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`invoice_no`),
  ADD KEY `idx_patient_id` (`patient_id`),
  ADD KEY `idx_sale_date` (`sale_date`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sale_id` (`sale_id`),
  ADD KEY `idx_batch_id` (`batch_id`),
  ADD KEY `fk_saleitems_product` (`product_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_supplier_name` (`name`),
  ADD KEY `idx_supplier_contact` (`contact_number`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_unit_name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_schedules`
--
ALTER TABLE `booking_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_subscriptions`
--
ALTER TABLE `customer_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `doctors_availabilities`
--
ALTER TABLE `doctors_availabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_appointments_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appointments_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `batches_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_batches_purchase` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_schedules`
--
ALTER TABLE `booking_schedules`
  ADD CONSTRAINT `booking_schedules_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors_availabilities`
--
ALTER TABLE `doctors_availabilities`
  ADD CONSTRAINT `doctors_availabilities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_doctors` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD CONSTRAINT `fk_payment_sale` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `fk_sale_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_saleitems_batch` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`),
  ADD CONSTRAINT `fk_saleitems_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_saleitems_sale` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
