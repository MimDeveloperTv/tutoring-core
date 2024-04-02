-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 13, 2023 at 04:26 PM
-- Server version: 8.0.24
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cloudclinic_formbuilder`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_tokens`
--

CREATE TABLE `access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `owner_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `used_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `user_collection_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `user_collection_id`, `section_id`, `name`, `type`, `active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'd5c698c9-ebd5-4966-8ea4-69508cdea7b9', NULL, 'فرم معاینه عمومی بیمارستان نور', NULL, 1, NULL, NULL, NULL),
(12, '0', 11, 'test', NULL, 1, NULL, '2023-10-15 11:32:23', '2023-10-15 11:32:23'),
(13, '0', 11, 'test', NULL, 1, NULL, '2023-10-15 11:35:20', '2023-10-15 11:35:20'),
(14, '0', 11, 'test', NULL, 1, NULL, '2023-10-15 11:35:32', '2023-10-15 11:35:32'),
(15, '0', 11, 't2', NULL, 1, NULL, '2023-10-15 11:36:02', '2023-10-15 11:36:02'),
(16, '0', 11, 't2', NULL, 1, NULL, '2023-10-15 11:38:17', '2023-10-15 11:38:17'),
(24, '0', 11, '54465', NULL, 1, NULL, '2023-10-15 11:48:47', '2023-10-15 11:48:47'),
(26, '0', 11, '54465456', NULL, 1, NULL, '2023-10-15 11:51:41', '2023-10-15 11:51:41'),
(27, '0', 11, 'testtttt', NULL, 1, NULL, '2023-10-15 11:52:10', '2023-10-15 11:52:10'),
(28, '0', 11, 'testtttt433', NULL, 1, NULL, '2023-10-15 11:53:58', '2023-10-15 11:53:58'),
(29, '0', 11, 'testtttt433', NULL, 1, NULL, '2023-10-15 11:57:38', '2023-10-15 11:57:38'),
(31, '0', 11, 'Femto', NULL, 1, NULL, '2023-10-15 12:46:09', '2023-10-15 12:46:09'),
(32, '0', 11, 'فرم اپتومتری', NULL, 1, NULL, '2023-10-16 10:00:56', '2023-10-16 10:00:56'),
(33, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 11, 'testtest', NULL, 0, NULL, '2023-10-16 10:08:16', '2023-10-16 11:03:35'),
(34, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 11, 'testtest', NULL, 1, NULL, '2023-10-16 11:03:35', '2023-10-16 11:03:35'),
(35, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 11, 'optometry', NULL, 1, NULL, '2023-10-16 11:08:18', '2023-10-16 11:08:18'),
(36, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 11, 'Haya', NULL, 1, NULL, '2023-10-17 05:06:26', '2023-10-17 05:06:26'),
(38, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 11, 'test', NULL, 1, NULL, '2023-10-18 08:11:25', '2023-10-18 08:11:25'),
(39, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 11, 'file uploader', NULL, 1, NULL, '2023-10-18 08:46:27', '2023-10-18 08:46:27'),
(40, 'd5c698c9-ebd5-4966-8ea4-69508cdea7b9', 11, 'test', NULL, 1, NULL, '2023-10-18 08:49:17', '2023-10-18 08:49:17'),
(45, NULL, 11, 'pentacam form', NULL, 1, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(46, NULL, 11, 'pentacam form', NULL, 1, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(47, NULL, 11, 'pentacam form', NULL, 1, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(48, NULL, 11, 'pentacam form', NULL, 1, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(49, NULL, 11, 'pentacam form', NULL, 1, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(50, NULL, NULL, 'PRK Surgery', NULL, 1, NULL, NULL, NULL),
(51, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 11, 'Optometry Form', NULL, 1, NULL, '2023-10-18 12:59:50', '2023-10-18 12:59:50'),
(52, '6bd5d37f-d9c7-450b-9624-af7064ecef67', 11, 'Optometry', NULL, 1, NULL, '2023-10-25 11:14:41', '2023-10-25 11:14:41'),
(53, '09a715e8-72b1-4965-a64d-5bcf4ff6d026', 11, 'Optometry Form', NULL, 1, NULL, '2023-10-26 05:23:42', '2023-10-26 05:23:42'),
(54, '09a715e8-72b1-4965-a64d-5bcf4ff6d026', 11, 'OpForm', NULL, 1, NULL, '2023-10-26 05:25:39', '2023-10-26 05:25:39'),
(55, '6bd5d37f-d9c7-450b-9624-af7064ecef67', 11, 'فرم معاینه', NULL, 1, NULL, '2023-10-28 11:12:04', '2023-10-28 11:12:04'),
(56, '6bd5d37f-d9c7-450b-9624-af7064ecef67', 11, 'optometry2', NULL, 1, NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(57, '6bd5d37f-d9c7-450b-9624-af7064ecef67', 11, 'Testing', NULL, 1, NULL, '2023-11-09 08:22:40', '2023-11-09 08:22:40');

-- --------------------------------------------------------

--
-- Table structure for table `form_groups`
--

CREATE TABLE `form_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `row_number` tinyint NOT NULL DEFAULT '0',
  `col_number` tinyint NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_groups`
--

INSERT INTO `form_groups` (`id`, `form_id`, `title`, `row_number`, `col_number`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'عمومی', 0, 0, NULL, NULL, NULL),
(4, 12, 'test', 0, 0, NULL, '2023-10-15 11:32:23', '2023-10-15 11:32:23'),
(5, 13, 'test', 0, 0, NULL, '2023-10-15 11:35:20', '2023-10-15 11:35:20'),
(6, 14, 'test', 0, 0, NULL, '2023-10-15 11:35:32', '2023-10-15 11:35:32'),
(7, 15, 'ww', 0, 0, NULL, '2023-10-15 11:36:02', '2023-10-15 11:36:02'),
(8, 16, 'ww', 0, 0, NULL, '2023-10-15 11:38:17', '2023-10-15 11:38:17'),
(16, 24, '4556', 0, 0, NULL, '2023-10-15 11:48:47', '2023-10-15 11:48:47'),
(18, 26, '4556', 0, 0, NULL, '2023-10-15 11:51:41', '2023-10-15 11:51:41'),
(19, 27, 'tesd', 0, 0, NULL, '2023-10-15 11:52:10', '2023-10-15 11:52:10'),
(20, 28, 'tesd324', 0, 0, NULL, '2023-10-15 11:53:58', '2023-10-15 11:53:58'),
(21, 29, 'tesd324', 0, 0, NULL, '2023-10-15 11:57:38', '2023-10-15 11:57:38'),
(23, 31, 'pupile offset', 0, 0, NULL, '2023-10-15 12:46:09', '2023-10-15 12:46:09'),
(24, 31, 'sph', 1, 0, NULL, '2023-10-15 12:46:09', '2023-10-15 12:46:09'),
(25, 31, 'cyl', 1, 1, NULL, '2023-10-15 12:46:09', '2023-10-15 12:46:09'),
(26, 31, 'axis', 1, 2, NULL, '2023-10-15 12:46:09', '2023-10-15 12:46:09'),
(27, 32, 'اپتومتری', 0, 0, NULL, '2023-10-16 10:00:56', '2023-10-16 10:00:56'),
(28, 33, 'we', 0, 0, NULL, '2023-10-16 10:08:16', '2023-10-16 10:08:16'),
(29, 34, 'we', 0, 0, NULL, '2023-10-16 11:03:35', '2023-10-16 11:03:35'),
(30, 35, 'Op', 0, 0, NULL, '2023-10-16 11:08:18', '2023-10-16 11:08:18'),
(31, 36, 'Color', 0, 0, NULL, '2023-10-17 05:06:26', '2023-10-17 05:06:26'),
(32, 38, 't', 0, 0, NULL, '2023-10-18 08:11:25', '2023-10-18 08:11:25'),
(33, 38, 't', 0, 1, NULL, '2023-10-18 08:11:25', '2023-10-18 08:11:25'),
(34, 39, 'for test', 0, 0, NULL, '2023-10-18 08:46:27', '2023-10-18 08:46:27'),
(35, 40, 't', 0, 0, NULL, '2023-10-18 08:49:17', '2023-10-18 08:49:17'),
(36, 40, 't', 0, 1, NULL, '2023-10-18 08:49:17', '2023-10-18 08:49:17'),
(37, 45, NULL, 0, 0, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(38, 45, NULL, 1, 0, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(39, 45, NULL, 2, 0, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(40, 45, NULL, 3, 0, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(41, 45, NULL, 4, 0, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(42, 45, NULL, 5, 0, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(43, 45, NULL, 6, 0, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(44, 45, NULL, 7, 0, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(45, 45, NULL, 8, 0, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(46, 46, NULL, 0, 0, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(47, 46, NULL, 1, 0, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(48, 46, NULL, 2, 0, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(49, 46, NULL, 3, 0, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(50, 46, NULL, 4, 0, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(51, 46, NULL, 5, 0, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(52, 46, NULL, 6, 0, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(53, 46, NULL, 7, 0, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(54, 46, NULL, 8, 0, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(55, 47, NULL, 0, 0, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(56, 47, NULL, 1, 0, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(57, 47, NULL, 2, 0, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(58, 47, NULL, 3, 0, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(59, 47, NULL, 4, 0, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(60, 47, NULL, 5, 0, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(61, 47, NULL, 6, 0, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(62, 47, NULL, 7, 0, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(63, 47, NULL, 8, 0, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(64, 48, NULL, 0, 0, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(65, 48, NULL, 1, 0, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(66, 48, NULL, 2, 0, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(67, 48, NULL, 3, 0, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(68, 48, NULL, 4, 0, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(69, 48, NULL, 5, 0, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(70, 48, NULL, 6, 0, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(71, 48, NULL, 7, 0, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(72, 48, NULL, 8, 0, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(73, 49, NULL, 0, 0, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(74, 49, NULL, 1, 0, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(75, 49, NULL, 2, 0, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(76, 49, NULL, 3, 0, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(77, 49, NULL, 4, 0, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(78, 49, NULL, 5, 0, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(79, 49, NULL, 6, 0, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(80, 49, NULL, 7, 0, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(81, 49, NULL, 8, 0, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(82, 51, 'Optometry', 0, 0, NULL, '2023-10-18 12:59:50', '2023-10-18 12:59:50'),
(83, 52, 'Optometry', 0, 0, NULL, '2023-10-25 11:14:41', '2023-10-25 11:14:41'),
(84, 52, 'OD', 1, 0, NULL, '2023-10-25 11:14:41', '2023-10-25 11:14:41'),
(85, 52, 'OS', 1, 1, NULL, '2023-10-25 11:14:41', '2023-10-25 11:14:41'),
(86, 54, 'OD', 0, 0, NULL, '2023-10-26 05:25:39', '2023-10-26 05:25:39'),
(87, 54, 'OS', 0, 1, NULL, '2023-10-26 05:25:39', '2023-10-26 05:25:39'),
(88, 54, 'Data Entry', 1, 0, NULL, '2023-10-26 05:25:39', '2023-10-26 05:25:39'),
(89, 55, 'OS', 0, 0, NULL, '2023-10-28 11:12:04', '2023-10-28 11:12:04'),
(90, 55, 'OD', 0, 1, NULL, '2023-10-28 11:12:04', '2023-10-28 11:12:04'),
(91, 55, 'comment', 1, 0, NULL, '2023-10-28 11:12:04', '2023-10-28 11:12:04'),
(92, 56, 'optometry', 0, 0, NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(93, 56, 'tt', 1, 0, NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(94, 56, 'ttt', 1, 1, NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(95, 56, 'tttt', 1, 2, NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(96, 56, 'result', 2, 0, NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(97, 57, NULL, 0, 0, NULL, '2023-11-09 08:22:40', '2023-11-09 08:22:40');

-- --------------------------------------------------------

--
-- Table structure for table `form_group_fields`
--

CREATE TABLE `form_group_fields` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_group_id` bigint UNSIGNED DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `element` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `require` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_group_fields`
--

INSERT INTO `form_group_fields` (`id`, `key`, `form_group_id`, `label`, `type`, `element`, `require`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'نام', 'text', NULL, 0, NULL, NULL, NULL),
(2, 'gender', 1, 'جنسیت', 'radioButton', NULL, 1, NULL, NULL, NULL),
(4, NULL, 4, 'Title', 'paint', NULL, 1, NULL, '2023-10-15 11:32:23', '2023-10-15 11:32:23'),
(5, NULL, 5, 'Title', 'paint', NULL, 1, NULL, '2023-10-15 11:35:20', '2023-10-15 11:35:20'),
(6, NULL, 6, 'Title', 'paint', NULL, 1, NULL, '2023-10-15 11:35:32', '2023-10-15 11:35:32'),
(7, NULL, 7, 'This is Optometry Form', 'optometry', NULL, 1, NULL, '2023-10-15 11:36:02', '2023-10-15 11:36:02'),
(8, NULL, 8, 'This is Optometry Form', 'optometry', NULL, 1, NULL, '2023-10-15 11:38:17', '2023-10-15 11:38:17'),
(16, NULL, 16, 'Title', 'paint', NULL, 1, NULL, '2023-10-15 11:48:47', '2023-10-15 11:48:47'),
(18, NULL, 18, 'Title', 'checkBox', NULL, 1, NULL, '2023-10-15 11:51:41', '2023-10-15 11:51:41'),
(19, NULL, 18, 'Title', 'paint', NULL, 1, NULL, '2023-10-15 11:51:41', '2023-10-15 11:51:41'),
(20, NULL, 19, 'Title', 'TextField', NULL, 1, NULL, '2023-10-15 11:52:10', '2023-10-15 11:52:10'),
(21, NULL, 19, 'Title', 'checkBox', NULL, 1, NULL, '2023-10-15 11:52:10', '2023-10-15 11:52:10'),
(22, NULL, 19, 'Title', 'paint', NULL, 1, NULL, '2023-10-15 11:52:10', '2023-10-15 11:52:10'),
(23, NULL, 19, 'Title', 'radioButton', NULL, 1, NULL, '2023-10-15 11:52:10', '2023-10-15 11:52:10'),
(24, NULL, 19, 'This is Optometry Form', 'optometry', NULL, 1, NULL, '2023-10-15 11:52:10', '2023-10-15 11:52:10'),
(25, NULL, 20, 'Title', 'TextField', NULL, 1, NULL, '2023-10-15 11:53:58', '2023-10-15 11:53:58'),
(26, NULL, 20, 'Title', 'checkBox', NULL, 1, NULL, '2023-10-15 11:53:58', '2023-10-15 11:53:58'),
(27, NULL, 20, 'Title', 'paint', NULL, 1, NULL, '2023-10-15 11:53:58', '2023-10-15 11:53:58'),
(28, NULL, 20, 'Title', 'radioButton', NULL, 1, NULL, '2023-10-15 11:53:58', '2023-10-15 11:53:58'),
(29, NULL, 20, 'This is Optometry Form', 'optometry', NULL, 1, NULL, '2023-10-15 11:53:58', '2023-10-15 11:53:58'),
(30, NULL, 21, 'Title', 'TextField', NULL, 1, NULL, '2023-10-15 11:57:38', '2023-10-15 11:57:38'),
(31, NULL, 21, 'Title', 'checkBox', NULL, 1, NULL, '2023-10-15 11:57:38', '2023-10-15 11:57:38'),
(32, NULL, 21, 'Title', 'paint', NULL, 1, NULL, '2023-10-15 11:57:38', '2023-10-15 11:57:38'),
(33, NULL, 21, 'Title', 'radioButton', NULL, 1, NULL, '2023-10-15 11:57:38', '2023-10-15 11:57:38'),
(34, NULL, 21, 'This is Optometry Form', 'optometry', NULL, 1, NULL, '2023-10-15 11:57:38', '2023-10-15 11:57:38'),
(35, NULL, 23, 'Title', 'heading', NULL, 1, NULL, '2023-10-15 12:46:09', '2023-10-15 12:46:09'),
(36, NULL, 24, 'SPH', 'TextField', NULL, 1, NULL, '2023-10-15 12:46:09', '2023-10-15 12:46:09'),
(37, NULL, 25, 'CYL', 'TextField', NULL, 1, NULL, '2023-10-15 12:46:09', '2023-10-15 12:46:09'),
(38, NULL, 26, 'Axis', 'TextField', NULL, 1, NULL, '2023-10-15 12:46:09', '2023-10-15 12:46:09'),
(39, NULL, 27, 'This is Optometry Form', 'optometry', NULL, 1, NULL, '2023-10-16 10:00:56', '2023-10-16 10:00:56'),
(40, NULL, 28, 'Title', 'checkBox', NULL, 1, NULL, '2023-10-16 10:08:16', '2023-10-16 10:08:16'),
(41, NULL, 29, 'Title', 'checkBox', NULL, 1, NULL, '2023-10-16 11:03:35', '2023-10-16 11:03:35'),
(42, NULL, 29, 'Title', 'radioButton', NULL, 1, NULL, '2023-10-16 11:03:35', '2023-10-16 11:03:35'),
(43, NULL, 30, 'This is Optometry Form', 'optometry', NULL, 1, NULL, '2023-10-16 11:08:18', '2023-10-16 11:08:18'),
(44, NULL, 32, 'This is Optometry Form', 'optometry', NULL, 1, NULL, '2023-10-18 08:11:25', '2023-10-18 08:11:25'),
(45, NULL, 33, 'Title', 'paint', NULL, 1, NULL, '2023-10-18 08:11:25', '2023-10-18 08:11:25'),
(46, NULL, 34, 'Title', 'file', NULL, 1, NULL, '2023-10-18 08:46:27', '2023-10-18 08:46:27'),
(47, NULL, 35, 'This is Optometry Form', 'optometry', NULL, 1, NULL, '2023-10-18 08:49:17', '2023-10-18 08:49:17'),
(48, NULL, 36, 'Title', 'paint', NULL, 1, NULL, '2023-10-18 08:49:17', '2023-10-18 08:49:17'),
(49, 'ELE', 37, 'ELE_BFS_8mm .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(50, 'CUR', 38, 'CUR .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(51, 'PAC', 39, 'PAC .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(52, 'SUMMARY', 40, 'SUMMARY .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(53, 'INDEX', 41, 'INDEX .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(54, 'CHAMBER', 42, 'CHAMBER .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(55, 'PACHY', 43, 'PACHY .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(56, '_4MAPS_REF', 44, '4MAPS_REF .jpg', 'file', NULL, 1, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(57, 'OTHER_FILES', 45, 'other files', 'multi_file', NULL, 1, NULL, '2023-10-18 08:59:19', '2023-10-18 08:59:19'),
(58, 'ELE', 46, 'ELE_BFS_8mm .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(59, 'CUR', 47, 'CUR .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(60, 'PAC', 48, 'PAC .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(61, 'SUMMARY', 49, 'SUMMARY .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(62, 'INDEX', 50, 'INDEX .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(63, 'CHAMBER', 51, 'CHAMBER .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(64, 'PACHY', 52, 'PACHY .csv', 'file', NULL, 1, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(65, '_4MAPS_REF', 53, '4MAPS_REF .jpg', 'file', NULL, 1, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(66, 'OTHER_FILES', 54, 'other files', 'multi_file', NULL, 1, NULL, '2023-10-18 08:59:50', '2023-10-18 08:59:50'),
(67, 'ELE', 55, 'ELE_BFS_8mm .csv', 'file', NULL, 1, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(68, 'CUR', 56, 'CUR .csv', 'file', NULL, 1, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(69, 'PAC', 57, 'PAC .csv', 'file', NULL, 1, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(70, 'SUMMARY', 58, 'SUMMARY .csv', 'file', NULL, 1, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(71, 'INDEX', 59, 'INDEX .csv', 'file', NULL, 1, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(72, 'CHAMBER', 60, 'CHAMBER .csv', 'file', NULL, 1, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(73, 'PACHY', 61, 'PACHY .csv', 'file', NULL, 1, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(74, '_4MAPS_REF', 62, '4MAPS_REF .jpg', 'file', NULL, 1, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(75, 'OTHER_FILES', 63, 'other files', 'multi_file', NULL, 1, NULL, '2023-10-18 09:00:43', '2023-10-18 09:00:43'),
(76, 'ELE', 64, 'ELE_BFS_8mm .csv', 'file', NULL, 1, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(77, 'CUR', 65, 'CUR .csv', 'file', NULL, 1, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(78, 'PAC', 66, 'PAC .csv', 'file', NULL, 1, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(79, 'SUMMARY', 67, 'SUMMARY .csv', 'file', NULL, 1, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(80, 'INDEX', 68, 'INDEX .csv', 'file', NULL, 1, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(81, 'CHAMBER', 69, 'CHAMBER .csv', 'file', NULL, 1, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(82, 'PACHY', 70, 'PACHY .csv', 'file', NULL, 1, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(83, '_4MAPS_REF', 71, '4MAPS_REF .jpg', 'file', NULL, 1, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(84, 'OTHER_FILES', 72, 'other files', 'multi_file', NULL, 1, NULL, '2023-10-18 11:43:37', '2023-10-18 11:43:37'),
(85, 'ELE', 73, 'ELE_BFS_8mm .csv', 'file', 'input', 1, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(86, 'CUR', 74, 'CUR .csv', 'file', 'input', 1, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(87, 'PAC', 75, 'PAC .csv', 'file', 'input', 1, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(88, 'SUMMARY', 76, 'SUMMARY .csv', 'file', 'input', 1, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(89, 'INDEX', 77, 'INDEX .csv', 'file', 'input', 1, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(90, 'CHAMBER', 78, 'CHAMBER .csv', 'file', 'input', 1, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(91, 'PACHY', 79, 'PACHY .csv', 'file', 'input', 1, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(92, '_4MAPS_REF', 80, '4MAPS_REF .jpg', 'file', 'input', 1, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(93, 'OTHER_FILES', 81, 'other files', 'multi_file', 'input', 1, NULL, '2023-10-18 11:44:39', '2023-10-18 11:44:39'),
(94, NULL, 82, 'This is Optometry Form', 'optometry', 'input', 1, NULL, '2023-10-18 12:59:50', '2023-10-18 12:59:50'),
(95, NULL, 83, 'This is Optometry Form', 'optometry', 'input', 1, NULL, '2023-10-25 11:14:41', '2023-10-25 11:14:41'),
(96, NULL, 84, 'Title', 'paint', 'input', 1, NULL, '2023-10-25 11:14:41', '2023-10-25 11:14:41'),
(97, NULL, 85, 'Title', 'paint', 'input', 1, NULL, '2023-10-25 11:14:41', '2023-10-25 11:14:41'),
(98, NULL, 86, 'Title', 'paint', 'input', 1, NULL, '2023-10-26 05:25:39', '2023-10-26 05:25:39'),
(99, NULL, 87, 'Title', 'paint', 'input', 1, NULL, '2023-10-26 05:25:39', '2023-10-26 05:25:39'),
(100, NULL, 88, 'This is Optometry Form', 'optometry', 'input', 1, NULL, '2023-10-26 05:25:39', '2023-10-26 05:25:39'),
(101, NULL, 89, 'Title', 'checkBox', 'input', 1, NULL, '2023-10-28 11:12:04', '2023-10-28 11:12:04'),
(102, NULL, 90, 'Title', 'checkBox', 'input', 1, NULL, '2023-10-28 11:12:04', '2023-10-28 11:12:04'),
(103, NULL, 91, 'Hand writing', 'paint', 'input', 1, NULL, '2023-10-28 11:12:04', '2023-10-28 11:12:04'),
(104, NULL, 92, 'This is Optometry Form', 'optometry', 'input', 1, NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(105, NULL, 93, 'Title', 'checkBox', 'input', 1, NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(106, NULL, 94, 'Title', 'textField', 'input', 1, NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(107, NULL, 95, 'Title', 'radioButton', 'input', 1, NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(108, NULL, 96, 'This is Optometry Form', 'resultOptometry', 'static', 1, NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(109, NULL, 97, 'Title', 'textField', 'input', 1, NULL, '2023-11-09 08:22:40', '2023-11-09 08:22:40');

-- --------------------------------------------------------

--
-- Table structure for table `form_group_field_options`
--

CREATE TABLE `form_group_field_options` (
  `id` bigint UNSIGNED NOT NULL,
  `form_group_field_id` bigint UNSIGNED DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_group_field_options`
--

INSERT INTO `form_group_field_options` (`id`, `form_group_field_id`, `value`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'زن', NULL, NULL, NULL),
(2, 2, 'مرد', NULL, NULL, NULL),
(3, 18, 'option1', NULL, '2023-10-15 11:51:41', '2023-10-15 11:51:41'),
(4, 18, 'option2', NULL, '2023-10-15 11:51:41', '2023-10-15 11:51:41'),
(5, 21, 'option1', NULL, '2023-10-15 11:52:10', '2023-10-15 11:52:10'),
(6, 21, 'option2', NULL, '2023-10-15 11:52:10', '2023-10-15 11:52:10'),
(7, 23, 'option1', NULL, '2023-10-15 11:52:10', '2023-10-15 11:52:10'),
(8, 23, 'option2', NULL, '2023-10-15 11:52:10', '2023-10-15 11:52:10'),
(9, 26, 'option1', NULL, '2023-10-15 11:53:58', '2023-10-15 11:53:58'),
(10, 26, 'option2', NULL, '2023-10-15 11:53:58', '2023-10-15 11:53:58'),
(11, 28, 'option1', NULL, '2023-10-15 11:53:58', '2023-10-15 11:53:58'),
(12, 28, 'option2', NULL, '2023-10-15 11:53:58', '2023-10-15 11:53:58'),
(13, 31, 'option1', NULL, '2023-10-15 11:57:38', '2023-10-15 11:57:38'),
(14, 31, 'option2', NULL, '2023-10-15 11:57:38', '2023-10-15 11:57:38'),
(15, 33, 'option1', NULL, '2023-10-15 11:57:38', '2023-10-15 11:57:38'),
(16, 33, 'option2', NULL, '2023-10-15 11:57:38', '2023-10-15 11:57:38'),
(17, 35, 'option1', NULL, '2023-10-15 12:46:09', '2023-10-15 12:46:09'),
(18, 35, 'option2', NULL, '2023-10-15 12:46:09', '2023-10-15 12:46:09'),
(19, 40, 'option1', NULL, '2023-10-16 10:08:16', '2023-10-16 10:08:16'),
(20, 40, 'option2', NULL, '2023-10-16 10:08:16', '2023-10-16 10:08:16'),
(21, 41, 'option1', NULL, '2023-10-16 11:03:35', '2023-10-16 11:03:35'),
(22, 41, 'option2', NULL, '2023-10-16 11:03:35', '2023-10-16 11:03:35'),
(23, 42, 'option1', NULL, '2023-10-16 11:03:35', '2023-10-16 11:03:35'),
(24, 42, 'option2', NULL, '2023-10-16 11:03:35', '2023-10-16 11:03:35'),
(25, 101, 'option1', NULL, '2023-10-28 11:12:04', '2023-10-28 11:12:04'),
(26, 101, 'option2', NULL, '2023-10-28 11:12:04', '2023-10-28 11:12:04'),
(27, 102, 'option1', NULL, '2023-10-28 11:12:04', '2023-10-28 11:12:04'),
(28, 102, 'option2', NULL, '2023-10-28 11:12:04', '2023-10-28 11:12:04'),
(29, 105, 'option1', NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(30, 105, 'option2', NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(31, 106, 'option1', NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(32, 106, 'option2', NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(33, 107, 'option1', NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(34, 107, 'option2', NULL, '2023-11-01 10:00:05', '2023-11-01 10:00:05'),
(35, 109, 'option1', NULL, '2023-11-09 08:22:40', '2023-11-09 08:22:40'),
(36, 109, 'option2', NULL, '2023-11-09 08:22:40', '2023-11-09 08:22:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_09_01_204530_create_forms_table', 1),
(3, '2023_09_01_204553_create_form_groups_table', 1),
(4, '2023_09_01_204613_create_form_group_fields_table', 1),
(5, '2023_09_01_204703_create_form_group_field_options_table', 1),
(6, '2023_09_03_045558_create_services_table', 1),
(7, '2023_09_03_045627_create_access_tokens_table', 1),
(8, '2023_10_01_162139_add_type_to_forms_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ENABLE','DISABLE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_tokens`
--
ALTER TABLE `access_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_groups`
--
ALTER TABLE `form_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_groups_form_id_foreign` (`form_id`);

--
-- Indexes for table `form_group_fields`
--
ALTER TABLE `form_group_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_group_fields_form_group_id_foreign` (`form_group_id`);

--
-- Indexes for table `form_group_field_options`
--
ALTER TABLE `form_group_field_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_group_field_options_form_group_field_id_foreign` (`form_group_field_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_tokens`
--
ALTER TABLE `access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `form_groups`
--
ALTER TABLE `form_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `form_group_fields`
--
ALTER TABLE `form_group_fields`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `form_group_field_options`
--
ALTER TABLE `form_group_field_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `form_groups`
--
ALTER TABLE `form_groups`
  ADD CONSTRAINT `form_groups_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `form_group_fields`
--
ALTER TABLE `form_group_fields`
  ADD CONSTRAINT `form_group_fields_form_group_id_foreign` FOREIGN KEY (`form_group_id`) REFERENCES `form_groups` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `form_group_field_options`
--
ALTER TABLE `form_group_field_options`
  ADD CONSTRAINT `form_group_field_options_form_group_field_id_foreign` FOREIGN KEY (`form_group_field_id`) REFERENCES `form_group_fields` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
