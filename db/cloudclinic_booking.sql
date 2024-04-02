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
-- Database: `cloudclinic_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addressable_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addressable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(8,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `title`, `addressable_id`, `addressable_type`, `latitude`, `longitude`, `description`, `phone`, `deleted_at`, `created_at`, `updated_at`) VALUES
(11, 'مطب 1', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 'App\\Models\\UserCollection', NULL, NULL, 'خیابان مطهری ، پلاک 26', NULL, NULL, '2023-10-25 14:46:11', '2023-10-25 14:46:11'),
(12, 'Day Clinic - Branch 1', '09a715e8-72b1-4965-a64d-5bcf4ff6d026', 'App\\Models\\UserCollection', NULL, NULL, 'Tehran, Valiasr St,', NULL, NULL, '2023-10-26 08:58:01', '2023-10-26 08:58:01');

-- --------------------------------------------------------

--
-- Table structure for table `consumers`
--

CREATE TABLE `consumers` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_collection_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consumers`
--

INSERT INTO `consumers` (`id`, `user_id`, `user_collection_id`, `fullname`, `avatar`, `deleted_at`, `created_at`, `updated_at`) VALUES
('1382aa4e-a17d-4564-94f5-d94ad327555a', '0f309e1c-b74b-40ce-aedf-f2245c07886c', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 'Johan Carlberg', NULL, NULL, '2023-11-11 18:29:45', '2023-11-11 18:29:45'),
('2aa26d18-9284-4067-be42-7278642fb5df', '289560de-5566-4d67-9230-c19021848d8d', '09a715e8-72b1-4965-a64d-5bcf4ff6d026', 'Reza Lotfi', NULL, NULL, '2023-10-27 16:00:54', '2023-10-27 16:00:54'),
('41ed1e14-86ec-4380-a17d-897a1b1eb76a', 'e722dcda-e494-4bb6-bd39-a54aa0629970', '09a715e8-72b1-4965-a64d-5bcf4ff6d026', 'John Doe', NULL, NULL, '2023-10-26 09:05:47', '2023-10-26 09:05:47'),
('444f0330-cb28-471f-982f-b83ad59f3954', '9f9bdd79-28bf-4036-8b62-5d205e5ecc4c', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 'Ali GUlzar', NULL, NULL, '2023-10-25 14:58:42', '2023-10-25 14:58:42'),
('4a9e7f80-81a2-43e0-a534-c8920b6b10d9', 'ae3b2905-7687-43db-937e-ecf46764ec14', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 'بیمار بیماریان', NULL, NULL, '2023-10-28 14:47:22', '2023-10-28 14:47:22'),
('57d4c2a1-f767-4dcb-aeda-d85a2134a34e', '3f9a79c7-c0a4-47fe-b33c-6dc74e095673', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 'sam namiranian', NULL, NULL, '2023-10-27 16:08:01', '2023-10-27 16:08:01'),
('59e20260-d5de-4131-aafa-192426f7c0d5', 'fdcfd8e9-3526-47cd-abf4-fa4348650d2e', '09a715e8-72b1-4965-a64d-5bcf4ff6d026', 'bimar bimar', NULL, NULL, '2023-10-27 14:13:10', '2023-10-27 14:13:10'),
('67accbc4-2fa4-47d5-9984-6b82cb75bb98', '470ff7a0-272b-40a7-a585-d7f60cf7450b', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 'test sort', NULL, NULL, '2023-11-01 15:02:44', '2023-11-01 15:02:44'),
('8a0c44f9-64e7-400f-afaf-0467ad408a97', '1a05e8e9-9a15-44ee-be9d-90e1701fcfc3', '09a715e8-72b1-4965-a64d-5bcf4ff6d026', 'jadi hasani', NULL, NULL, '2023-11-01 13:43:55', '2023-11-01 13:43:55'),
('c8c2bb0a-2826-41f1-90bc-f782d683546c', '9937c96d-f2ec-437a-add5-7506a3bb3477', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 'Alison Becker', NULL, NULL, '2023-11-10 17:41:11', '2023-11-10 17:41:11'),
('db9a540b-73a8-49ea-a2ba-fe0a4ddbe47d', 'c29a031c-0fd4-4249-88ec-69fbea149760', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 'Yes Nosdf', NULL, NULL, '2023-11-09 11:39:23', '2023-11-09 11:39:23'),
('e6f611a8-a83c-48f4-8c55-ad3e9a315b16', '99d252fb-c34e-4891-b5e9-f499c3f7d8d1', '09a715e8-72b1-4965-a64d-5bcf4ff6d026', 'Ali yousefi', NULL, NULL, '2023-10-28 19:54:53', '2023-10-28 19:54:53'),
('fb287712-a729-4c69-9efa-2cced1df9607', '9dd51e85-d539-481c-bf9b-e6eb616d1f42', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 'bimar3 bimar', NULL, NULL, '2023-10-28 08:13:24', '2023-10-28 08:13:24');

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
(2, '2023_09_17_111053_create_consumers_table', 1),
(3, '2023_09_18_072751_create_service_categories_table', 1),
(4, '2023_09_18_072818_create_service_models_table', 1),
(5, '2023_09_18_072822_create_services_table', 1),
(6, '2023_09_18_072826_create_service_applications_table', 1),
(7, '2023_09_18_074057_create_addresses_table', 1),
(8, '2023_09_18_074059_create_service_application_places_table', 1),
(9, '2023_09_18_074223_create_service_application_items_table', 1),
(10, '2023_09_18_074809_create_operators_table', 1),
(11, '2023_09_18_075824_create_operator_weekly_availabilities_table', 1),
(12, '2023_09_18_075957_create_operator_exception_availabilities_table', 1),
(13, '2023_09_18_080126_create_operator_yearly_availabilities_table', 1),
(14, '2023_09_18_080152_create_reserves_table', 1),
(15, '2023_09_18_120342_create_reserve_items_table', 1),
(16, '2023_10_17_100658_create_service_requests_table', 2),
(17, '2023_10_21_142244_create_service_model_items_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `operators`
--

CREATE TABLE `operators` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_collection_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operators`
--

INSERT INTO `operators` (`id`, `user_id`, `user_collection_id`, `active`, `fullname`, `avatar`, `deleted_at`, `created_at`, `updated_at`) VALUES
('09419fb5-7adb-443d-b10e-05e38785060c', '3c14e3f7-c05d-4c40-8a78-c0f9ab2a04c5', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 1, 'پزشک پزشکیان', NULL, NULL, '2023-10-28 14:44:59', '2023-10-28 14:44:59'),
('12fe91e4-ff62-4bfd-ac7b-5bf6dbec69ff', '19e576de-739e-48e5-a813-5004719d0469', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 1, 't1 t1', NULL, NULL, '2023-11-01 13:36:57', '2023-11-01 13:36:57'),
('15256492-33c5-477c-89b5-66dad0793293', 'a51309dc-9bbe-48ac-a1c1-7f5d3ff048eb', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 1, 'admin admin', NULL, NULL, '2023-10-25 15:15:04', '2023-10-25 15:15:04'),
('36ac3ed9-475b-4c86-86ee-cc0c46a8e689', '3bde7a51-a9fd-4a7d-a427-c243807bad9a', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 1, 't2 t2', NULL, NULL, '2023-11-01 14:00:57', '2023-11-01 14:00:57'),
('384ba1f8-b2b7-42fa-87f6-c29f40a87826', 'f336f366-857d-4735-a0d9-a1aa21b9bd18', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 1, 'sam namiranian', NULL, NULL, '2023-10-25 14:43:20', '2023-10-25 14:43:20'),
('741c3152-8ed9-48f1-89b7-d4fe78ef90cb', 'd741c636-f808-4bd9-874c-f00b37574281', '6bd5d37f-d9c7-450b-9624-af7064ecef67', 1, 'Hello Nothing', NULL, NULL, '2023-11-09 12:11:57', '2023-11-09 12:11:57'),
('7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 'bf7205fb-e9c7-4729-83b3-bea7a5e246fd', '09a715e8-72b1-4965-a64d-5bcf4ff6d026', 1, 'Ali Yousefi', NULL, NULL, '2023-10-27 15:52:28', '2023-10-27 15:52:28');

-- --------------------------------------------------------

--
-- Table structure for table `operator_exception_availabilities`
--

CREATE TABLE `operator_exception_availabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `service_application_id` bigint UNSIGNED NOT NULL,
  `place_id` bigint UNSIGNED DEFAULT NULL,
  `from` timestamp NULL DEFAULT NULL,
  `to` timestamp NULL DEFAULT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `onAnotherSite` tinyint(1) NOT NULL DEFAULT '0',
  `isAvailable` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `operator_weekly_availabilities`
--

CREATE TABLE `operator_weekly_availabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `service_application_id` bigint UNSIGNED NOT NULL,
  `place_id` bigint UNSIGNED DEFAULT NULL,
  `weekday` enum('0','1','2','3','4','5','6') COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` int DEFAULT NULL,
  `to` int DEFAULT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `onAnotherSite` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operator_weekly_availabilities`
--

INSERT INTO `operator_weekly_availabilities` (`id`, `service_application_id`, `place_id`, `weekday`, `from`, `to`, `online`, `onAnotherSite`, `deleted_at`, `created_at`, `updated_at`) VALUES
(44, 10, 21, '0', 420, 780, 0, 0, '2023-10-25 15:01:13', '2023-10-25 14:47:51', '2023-10-25 15:01:13'),
(45, 11, 22, '1', 720, 1020, 0, 0, '2023-10-25 15:01:13', '2023-10-25 14:47:51', '2023-10-25 15:01:13'),
(46, 10, 21, '0', 420, 1410, 0, 0, '2023-10-26 09:00:08', '2023-10-25 15:01:13', '2023-10-26 09:00:08'),
(47, 11, 22, '1', 720, 1020, 0, 0, '2023-10-26 09:00:08', '2023-10-25 15:01:13', '2023-10-26 09:00:08'),
(48, 12, 23, '0', 420, 1410, 0, 0, '2023-10-26 09:00:19', '2023-10-26 09:00:08', '2023-10-26 09:00:19'),
(49, 12, 23, '0', 420, 1410, 0, 0, '2023-10-30 14:27:34', '2023-10-26 09:00:19', '2023-10-30 14:27:34'),
(50, 12, 23, '3', 420, 1020, 0, 0, '2023-10-30 14:27:34', '2023-10-26 09:00:19', '2023-10-30 14:27:34'),
(51, 12, 23, '5', 420, 690, 0, 0, '2023-10-30 14:27:34', '2023-10-26 09:00:19', '2023-10-30 14:27:34'),
(52, 13, 25, '0', 420, 930, 0, 0, '2023-10-30 10:07:42', '2023-10-27 14:09:43', '2023-10-30 10:07:42'),
(53, 14, 26, '0', 420, 1050, 0, 0, '2023-11-01 08:13:54', '2023-10-27 15:57:59', '2023-11-01 08:13:54'),
(54, 14, 26, '1', 420, 1020, 0, 0, '2023-11-01 08:13:54', '2023-10-27 15:57:59', '2023-11-01 08:13:54'),
(55, 14, 26, '2', 420, 1020, 0, 0, '2023-11-01 08:13:54', '2023-10-27 15:57:59', '2023-11-01 08:13:54'),
(56, 14, 26, '3', 420, 1020, 0, 0, '2023-11-01 08:13:54', '2023-10-27 15:57:59', '2023-11-01 08:13:54'),
(57, 14, 26, '4', 420, 1080, 0, 0, '2023-11-01 08:13:54', '2023-10-27 15:57:59', '2023-11-01 08:13:54'),
(58, 16, 27, '0', 510, 750, 0, 0, '2023-11-01 13:34:26', '2023-10-28 14:46:00', '2023-11-01 13:34:26'),
(59, 16, 27, '2', 510, 750, 0, 0, '2023-11-01 13:34:26', '2023-10-28 14:46:00', '2023-11-01 13:34:26'),
(60, 16, 27, '4', 420, 690, 0, 0, '2023-11-01 13:34:26', '2023-10-28 14:46:00', '2023-11-01 13:34:26'),
(61, 17, 28, '0', 420, 930, 0, 0, NULL, '2023-10-30 10:07:42', '2023-10-30 10:07:42'),
(62, 10, 21, '0', 420, 1410, 0, 0, '2023-10-31 16:47:20', '2023-10-30 14:27:34', '2023-10-31 16:47:20'),
(63, 10, 21, '1', 420, 510, 0, 0, '2023-10-31 16:47:20', '2023-10-30 14:27:34', '2023-10-31 16:47:20'),
(64, 10, 21, '3', 420, 1020, 0, 0, '2023-10-31 16:47:20', '2023-10-30 14:27:34', '2023-10-31 16:47:20'),
(65, 14, 26, '0', 420, 1050, 0, 0, '2023-11-01 11:46:32', '2023-11-01 08:13:54', '2023-11-01 11:46:32'),
(66, 14, 26, '1', 420, 1020, 0, 0, '2023-11-01 11:46:32', '2023-11-01 08:13:54', '2023-11-01 11:46:32'),
(67, 14, 26, '2', 420, 1020, 0, 0, '2023-11-01 11:46:32', '2023-11-01 08:13:54', '2023-11-01 11:46:32'),
(68, 14, 26, '3', 420, 1020, 0, 0, '2023-11-01 11:46:32', '2023-11-01 08:13:54', '2023-11-01 11:46:32'),
(69, 14, 26, '4', 420, 1080, 0, 0, '2023-11-01 11:46:32', '2023-11-01 08:13:54', '2023-11-01 11:46:32'),
(70, 14, 26, '0', 420, 1050, 0, 0, NULL, '2023-11-01 11:46:32', '2023-11-01 11:46:32'),
(71, 14, 26, '1', 420, 1020, 0, 0, NULL, '2023-11-01 11:46:32', '2023-11-01 11:46:32'),
(72, 14, 26, '2', 420, 1020, 0, 0, NULL, '2023-11-01 11:46:32', '2023-11-01 11:46:32'),
(73, 14, 26, '3', 420, 1020, 0, 0, NULL, '2023-11-01 11:46:32', '2023-11-01 11:46:32'),
(74, 14, 26, '4', 420, 1080, 0, 0, NULL, '2023-11-01 11:46:32', '2023-11-01 11:46:32'),
(75, 18, 30, '0', 420, 600, 0, 0, '2023-11-01 13:34:27', '2023-11-01 13:34:26', '2023-11-01 13:34:27'),
(76, 18, 30, '1', 420, 600, 0, 0, '2023-11-01 13:34:27', '2023-11-01 13:34:26', '2023-11-01 13:34:27'),
(77, 18, 30, '2', 420, 600, 0, 0, '2023-11-01 13:34:27', '2023-11-01 13:34:26', '2023-11-01 13:34:27'),
(78, 18, 30, '3', 420, 600, 0, 0, '2023-11-01 13:34:27', '2023-11-01 13:34:26', '2023-11-01 13:34:27'),
(79, 18, 30, '4', 420, 600, 0, 0, '2023-11-01 13:34:27', '2023-11-01 13:34:26', '2023-11-01 13:34:27'),
(80, 18, 30, '0', 420, 600, 0, 0, NULL, '2023-11-01 13:34:27', '2023-11-01 13:34:27'),
(81, 18, 30, '1', 420, 600, 0, 0, NULL, '2023-11-01 13:34:27', '2023-11-01 13:34:27'),
(82, 18, 30, '2', 420, 600, 0, 0, NULL, '2023-11-01 13:34:27', '2023-11-01 13:34:27'),
(83, 18, 30, '3', 420, 600, 0, 0, NULL, '2023-11-01 13:34:27', '2023-11-01 13:34:27'),
(84, 18, 30, '4', 420, 600, 0, 0, NULL, '2023-11-01 13:34:27', '2023-11-01 13:34:27'),
(85, 19, 31, '4', 420, 600, 0, 0, NULL, '2023-11-01 13:51:28', '2023-11-01 13:51:28'),
(86, 20, 32, '4', 570, 930, 0, 0, NULL, '2023-11-01 14:01:20', '2023-11-01 14:01:20'),
(87, 10, 33, '4', 480, 540, 0, 0, '2023-11-06 13:17:17', '2023-11-01 16:08:57', '2023-11-06 13:17:17'),
(88, 12, 23, '0', 420, 630, 0, 0, NULL, '2023-11-06 13:17:17', '2023-11-06 13:17:17'),
(89, 12, 23, '1', 420, 600, 0, 0, NULL, '2023-11-06 13:17:17', '2023-11-06 13:17:17'),
(90, 12, 23, '2', 420, 630, 0, 0, NULL, '2023-11-06 13:17:17', '2023-11-06 13:17:17'),
(91, 12, 23, '3', 420, 600, 0, 0, NULL, '2023-11-06 13:17:17', '2023-11-06 13:17:17'),
(92, 10, 33, '4', 480, 540, 0, 0, NULL, '2023-11-06 13:17:17', '2023-11-06 13:17:17');

-- --------------------------------------------------------

--
-- Table structure for table `operator_yearly_availabilities`
--

CREATE TABLE `operator_yearly_availabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `service_application_id` bigint UNSIGNED NOT NULL,
  `place_id` bigint UNSIGNED DEFAULT NULL,
  `date` timestamp NOT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `onAnotherSite` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `reserves`
--

CREATE TABLE `reserves` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consumer_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_application_place_id` bigint UNSIGNED NOT NULL,
  `service_model_item_id` bigint UNSIGNED NOT NULL,
  `payment_status` enum('PENDING','SUCCESS','FAILED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `status` enum('NEW','CANCELED','COMPLETED','REVIEWED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NEW',
  `amount` decimal(14,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` int NOT NULL,
  `to` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reserves`
--

INSERT INTO `reserves` (`id`, `consumer_id`, `operator_id`, `service_application_place_id`, `service_model_item_id`, `payment_status`, `status`, `amount`, `currency`, `from`, `to`, `deleted_at`, `created_at`, `updated_at`) VALUES
('1768aba7-5c2c-4b72-a77a-24aa66fdd027', '4a9e7f80-81a2-43e0-a534-c8920b6b10d9', '15256492-33c5-477c-89b5-66dad0793293', 28, 15, 'PENDING', 'NEW', '100.00', 'IR-RIAL', 1700883900, 1700884500, NULL, '2023-11-11 14:22:31', '2023-11-11 14:22:31'),
('1efba492-c01e-46c1-b351-b5c7e6395195', 'e6f611a8-a83c-48f4-8c55-ad3e9a315b16', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 26, 47, 'PENDING', 'NEW', '10.00', 'IR-RIAL', 1698556200, 1698557100, NULL, '2023-10-28 19:59:11', '2023-10-28 19:59:11'),
('1fe028f5-367e-49e6-886e-2318e03f4ac0', '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 23, 47, 'PENDING', 'NEW', '10.00', 'IR-RIAL', 1699767000, 1699767900, NULL, '2023-11-09 10:48:06', '2023-11-09 10:48:06'),
('211ed873-4ae6-4ab8-9f9b-eb583f00cc3f', 'e6f611a8-a83c-48f4-8c55-ad3e9a315b16', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 26, 47, 'PENDING', 'NEW', '10.00', 'IR-RIAL', 1698556200, 1698557100, NULL, '2023-10-28 19:59:14', '2023-10-28 19:59:14'),
('2174ad75-d55e-48e6-b771-ad7baeb8ecbd', '444f0330-cb28-471f-982f-b83ad59f3954', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 21, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1698489300, 1698490500, NULL, '2023-10-25 15:39:07', '2023-10-25 15:39:07'),
('32304767-d18b-4e95-952b-b8dd72c68922', '41ed1e14-86ec-4380-a17d-897a1b1eb76a', '15256492-33c5-477c-89b5-66dad0793293', 25, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1698477300, 1698478500, NULL, '2023-10-27 14:11:59', '2023-10-27 14:11:59'),
('427e0b61-642b-4d22-96c8-e268c1a94b84', 'fb287712-a729-4c69-9efa-2cced1df9607', '15256492-33c5-477c-89b5-66dad0793293', 25, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1698471300, 1698472500, NULL, '2023-10-28 10:32:49', '2023-10-28 10:32:49'),
('4bd81a90-efae-40e2-a24b-2024f82c12be', '4a9e7f80-81a2-43e0-a534-c8920b6b10d9', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 23, 47, 'PENDING', 'NEW', '1000.00', 'IR-RIAL', 1699333800, 1699334700, NULL, '2023-11-06 13:18:04', '2023-11-06 13:18:04'),
('4e7b6989-01cf-4bba-9c33-1d2212fcf74a', '444f0330-cb28-471f-982f-b83ad59f3954', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 22, 7, 'PENDING', 'NEW', '200000.00', 'IR-RIAL', 1698573900, 1698577800, NULL, '2023-10-25 16:00:10', '2023-10-25 16:00:10'),
('524144de-bfe6-42c3-a70b-d4d8d01747e2', '444f0330-cb28-471f-982f-b83ad59f3954', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 23, 47, 'PENDING', 'NEW', '10.00', 'IR-RIAL', 1699765800, 1699766700, NULL, '2023-11-07 09:19:35', '2023-11-07 09:19:35'),
('648e920f-06f0-4440-81a4-2cbd1a4699ce', '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 23, 47, 'PENDING', 'NEW', '10.00', 'IR-RIAL', 1698465000, 1698465900, NULL, '2023-10-28 08:34:13', '2023-10-28 08:34:13'),
('68855b00-8673-46eb-b4fb-0a4de764606f', '2aa26d18-9284-4067-be42-7278642fb5df', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 26, 47, 'PENDING', 'NEW', '10.00', 'IR-RIAL', 1698667800, 1698668700, NULL, '2023-10-27 16:04:29', '2023-10-27 16:04:29'),
('6f9e3093-4de5-4e8e-850f-2dd63a501c75', '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 23, 47, 'PENDING', 'NEW', '10.00', 'IR-RIAL', 1698733800, 1698734700, NULL, '2023-10-28 11:52:16', '2023-10-28 11:52:16'),
('74e1bb4e-b6c9-43de-ae79-2cf4bdf2ca45', '8a0c44f9-64e7-400f-afaf-0467ad408a97', '36ac3ed9-475b-4c86-86ee-cc0c46a8e689', 32, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1699435200, 1699436400, NULL, '2023-11-01 14:03:33', '2023-11-01 14:03:33'),
('7a6edd50-37f6-4128-9eec-8692c8bf79e5', 'c8c2bb0a-2826-41f1-90bc-f782d683546c', '12fe91e4-ff62-4bfd-ac7b-5bf6dbec69ff', 31, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1700629800, 1700631000, NULL, '2023-11-11 17:08:22', '2023-11-11 17:08:22'),
('7bf8f106-9880-440d-8e49-46bc9ebd9eb8', '4a9e7f80-81a2-43e0-a534-c8920b6b10d9', '15256492-33c5-477c-89b5-66dad0793293', 28, 15, 'PENDING', 'NEW', '50.00', 'IR-RIAL', 1700887500, 1700888100, NULL, '2023-10-30 10:09:26', '2023-10-30 10:09:26'),
('8543a554-24c5-40f1-a057-0b1b52007edb', '444f0330-cb28-471f-982f-b83ad59f3954', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 21, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1698489300, 1698490500, NULL, '2023-10-25 15:55:48', '2023-10-25 15:55:48'),
('89e43890-63a9-4479-951a-31aaeed670d5', '444f0330-cb28-471f-982f-b83ad59f3954', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 22, 8, 'PENDING', 'NEW', '500.00', 'IR-RIAL', 1698579600, 1698583500, NULL, '2023-10-25 18:31:57', '2023-10-25 18:31:57'),
('a27f2d82-5c05-4807-8426-84196e056ebe', '2aa26d18-9284-4067-be42-7278642fb5df', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 26, 47, 'PENDING', 'NEW', '555.00', 'IR-RIAL', 1698550200, 1698551100, NULL, '2023-10-28 20:34:51', '2023-10-28 20:34:51'),
('a76a26b6-c511-474a-9091-0723b0c82f32', 'e6f611a8-a83c-48f4-8c55-ad3e9a315b16', '36ac3ed9-475b-4c86-86ee-cc0c46a8e689', 32, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1698824400, 1698825600, NULL, '2023-11-01 14:01:49', '2023-11-01 14:01:49'),
('ac4989f3-fb0d-4221-8ad4-ccd3705fbdbc', '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 21, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1698742500, 1698743700, NULL, '2023-10-30 14:27:57', '2023-10-30 14:27:57'),
('acbb94c7-9211-4800-ba0d-d15b7d21c5ac', '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 21, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1698741000, 1698742200, NULL, '2023-10-30 17:27:23', '2023-10-30 17:27:23'),
('adde09ef-fb46-48df-b206-33afe5c58315', '41ed1e14-86ec-4380-a17d-897a1b1eb76a', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 23, 47, 'PENDING', 'NEW', '10.00', 'IR-RIAL', 1698474600, 1698475500, NULL, '2023-10-27 14:58:19', '2023-10-27 14:58:19'),
('b1592f18-6911-4fa5-b49e-23552111c358', 'e6f611a8-a83c-48f4-8c55-ad3e9a315b16', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 23, 47, 'PENDING', 'NEW', '1505.00', 'IR-RIAL', 1698726600, 1698727500, NULL, '2023-10-28 20:20:39', '2023-10-28 20:20:39'),
('b8029638-8589-4181-ace3-a121dc686a2c', '57d4c2a1-f767-4dcb-aeda-d85a2134a34e', '09419fb5-7adb-443d-b10e-05e38785060c', 30, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1699242900, 1699244100, NULL, '2023-11-01 13:34:56', '2023-11-01 13:34:56'),
('bf54357d-629c-4911-a947-4a1cf15eba54', '2aa26d18-9284-4067-be42-7278642fb5df', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 26, 47, 'PENDING', 'NEW', '555.00', 'IR-RIAL', 1698550200, 1698551100, NULL, '2023-10-28 20:34:53', '2023-10-28 20:34:53'),
('dba1ba1b-bb4c-4299-94eb-8dafd5199357', '4a9e7f80-81a2-43e0-a534-c8920b6b10d9', '09419fb5-7adb-443d-b10e-05e38785060c', 27, 47, 'PENDING', 'NEW', '10000.00', 'IR-RIAL', 1698815400, 1698816600, NULL, '2023-11-01 12:18:58', '2023-11-01 12:18:58'),
('ddb6743a-758a-4ab4-a3de-ce074b4159eb', '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 23, 47, 'PENDING', 'NEW', '10.00', 'IR-RIAL', 1698516600, 1698517500, NULL, '2023-10-28 14:28:29', '2023-10-28 14:28:29'),
('ec53d171-d26a-4f16-8b1e-6f4d07e9684b', 'fb287712-a729-4c69-9efa-2cced1df9607', '12fe91e4-ff62-4bfd-ac7b-5bf6dbec69ff', 31, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1698809400, 1698810600, NULL, '2023-11-01 13:51:50', '2023-11-01 13:51:50'),
('fac9cbf5-f84b-452a-9057-361151593271', 'db9a540b-73a8-49ea-a2ba-fe0a4ddbe47d', '09419fb5-7adb-443d-b10e-05e38785060c', 30, 48, 'PENDING', 'NEW', '52000.00', 'IR-RIAL', 1699680900, 1699682100, NULL, '2023-11-09 11:54:38', '2023-11-09 11:54:38');

-- --------------------------------------------------------

--
-- Table structure for table `reserve_items`
--

CREATE TABLE `reserve_items` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `service_model_id` bigint UNSIGNED NOT NULL,
  `user_collection_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_id` bigint UNSIGNED DEFAULT NULL,
  `default_price` int NOT NULL,
  `default_duration` int NOT NULL,
  `default_break` int NOT NULL,
  `default_capacity` int NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_model_id`, `user_collection_id`, `form_id`, `default_price`, `default_duration`, `default_break`, `default_capacity`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'cf0441ba-6c8b-4b07-969a-4cf7f3bb02f4', 14, 86000, 15, 3, 2, NULL, '2023-10-10 15:37:55', '2023-10-10 15:37:55'),
(2, 1, 'd5c698c9-ebd5-4966-8ea4-69508cdea7b9', 14, 86000, 15, 3, 2, NULL, '2023-10-14 15:05:13', '2023-10-14 15:05:13'),
(3, 2, 'd5c698c9-ebd5-4966-8ea4-69508cdea7b9', 14, 86000, 15, 3, 2, NULL, '2023-10-14 15:41:56', '2023-10-14 15:41:56'),
(4, 1, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 51, 100, 20, 5, 50, NULL, '2023-10-14 15:48:01', '2023-10-14 15:48:01'),
(5, 11, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 51, 100, 10, 10, 20, NULL, '2023-10-14 15:58:45', '2023-10-14 15:58:45'),
(6, 24, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 51, 50000, 20, 5, 20, NULL, '2023-10-16 12:31:03', '2023-10-16 12:31:03'),
(7, 25, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 51, 100000, 10, 5, 10, NULL, '2023-10-16 13:29:08', '2023-10-16 13:29:08'),
(8, 4, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 51, 100000, 50, 10, 1, NULL, '2023-10-18 13:50:04', '2023-10-18 13:50:04'),
(9, 2, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 39, 100, 60, 10, 2, NULL, '2023-10-22 10:18:15', '2023-10-22 10:18:15'),
(10, 13, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 35, 500, 20, 5, 1, NULL, '2023-10-22 10:24:47', '2023-10-22 10:24:47'),
(11, 7, 'fa58b307-d910-4a2c-be3a-1cdb73db2241', 14, 86000, 15, 3, 2, NULL, '2023-10-24 14:20:23', '2023-10-24 14:20:23'),
(12, 25, '6bd5d37f-d9c7-450b-9624-af7064ecef67', 56, 52000, 20, 5, 2, NULL, '2023-10-25 14:45:18', '2023-10-25 14:45:18'),
(13, 4, '6bd5d37f-d9c7-450b-9624-af7064ecef67', NULL, 200000, 65, 30, 1, NULL, '2023-10-25 14:46:42', '2023-10-25 14:46:42'),
(14, 25, '09a715e8-72b1-4965-a64d-5bcf4ff6d026', NULL, 10, 15, 5, 2, NULL, '2023-10-26 08:53:18', '2023-10-26 08:53:18'),
(15, 24, '09a715e8-72b1-4965-a64d-5bcf4ff6d026', 54, 10, 15, 5, 3, NULL, '2023-10-26 08:56:52', '2023-10-26 08:56:52'),
(16, 24, '6bd5d37f-d9c7-450b-9624-af7064ecef67', 55, 10000, 20, 5, 2, NULL, '2023-10-28 14:43:55', '2023-10-28 14:43:55'),
(17, 8, '6bd5d37f-d9c7-450b-9624-af7064ecef67', NULL, 50, 10, 5, 1, NULL, '2023-10-30 10:06:42', '2023-10-30 10:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `service_applications`
--

CREATE TABLE `service_applications` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `operator_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_id` bigint UNSIGNED DEFAULT NULL,
  `price` int DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `break` int DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `onAnotherSite` tinyint(1) NOT NULL DEFAULT '0',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_applications`
--

INSERT INTO `service_applications` (`id`, `service_id`, `operator_id`, `form_id`, `price`, `duration`, `break`, `capacity`, `online`, `onAnotherSite`, `isActive`, `deleted_at`, `created_at`, `updated_at`) VALUES
(10, 12, '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 56, 52000, 20, 5, 2, 0, 0, 1, NULL, '2023-10-25 14:47:10', '2023-10-25 14:47:10'),
(11, 13, '384ba1f8-b2b7-42fa-87f6-c29f40a87826', NULL, 200000, 65, 30, 1, 0, 0, 1, NULL, '2023-10-25 14:47:18', '2023-10-25 14:47:18'),
(12, 15, '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 54, 10, 15, 5, 3, 0, 0, 1, NULL, '2023-10-26 08:59:14', '2023-10-26 08:59:14'),
(13, 12, '15256492-33c5-477c-89b5-66dad0793293', 56, 52000, 20, 5, 2, 0, 0, 1, NULL, '2023-10-27 14:09:26', '2023-10-27 14:09:26'),
(14, 15, '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 54, 10, 15, 5, 3, 0, 0, 1, NULL, '2023-10-27 15:56:33', '2023-10-27 15:56:33'),
(15, 14, '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', NULL, 10, 15, 5, 2, 0, 0, 1, NULL, '2023-10-27 15:56:41', '2023-10-27 15:56:41'),
(16, 16, '09419fb5-7adb-443d-b10e-05e38785060c', 55, 10000, 20, 5, 2, 0, 0, 1, NULL, '2023-10-28 14:45:22', '2023-10-28 14:45:22'),
(17, 17, '15256492-33c5-477c-89b5-66dad0793293', NULL, 50, 10, 5, 1, 0, 0, 1, NULL, '2023-10-30 10:07:25', '2023-10-30 10:07:25'),
(18, 12, '09419fb5-7adb-443d-b10e-05e38785060c', 56, 52000, 20, 5, 2, 0, 0, 1, NULL, '2023-11-01 13:33:45', '2023-11-01 13:33:45'),
(19, 12, '12fe91e4-ff62-4bfd-ac7b-5bf6dbec69ff', 56, 52000, 20, 5, 2, 0, 0, 1, NULL, '2023-11-01 13:45:27', '2023-11-01 13:45:27'),
(20, 12, '36ac3ed9-475b-4c86-86ee-cc0c46a8e689', 56, 52000, 20, 5, 2, 0, 0, 1, NULL, '2023-11-01 14:01:08', '2023-11-01 14:01:08'),
(21, 13, '741c3152-8ed9-48f1-89b7-d4fe78ef90cb', 52, 200000, 65, 30, 10, 0, 0, 1, NULL, '2023-11-12 18:39:42', '2023-11-12 18:39:42');

-- --------------------------------------------------------

--
-- Table structure for table `service_application_items`
--

CREATE TABLE `service_application_items` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_application_places`
--

CREATE TABLE `service_application_places` (
  `id` bigint UNSIGNED NOT NULL,
  `service_application_id` bigint UNSIGNED NOT NULL,
  `address_id` bigint UNSIGNED NOT NULL,
  `parallel` tinyint(1) NOT NULL DEFAULT '0',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_application_places`
--

INSERT INTO `service_application_places` (`id`, `service_application_id`, `address_id`, `parallel`, `isActive`, `deleted_at`, `created_at`, `updated_at`) VALUES
(21, 10, 11, 0, 1, NULL, '2023-10-25 14:47:51', '2023-10-25 14:47:51'),
(22, 11, 11, 0, 1, NULL, '2023-10-25 14:47:51', '2023-10-25 14:47:51'),
(23, 12, 12, 0, 1, NULL, '2023-10-26 09:00:08', '2023-10-26 09:00:08'),
(25, 13, 11, 0, 1, NULL, '2023-10-27 14:09:43', '2023-10-27 14:09:43'),
(26, 14, 12, 0, 1, NULL, '2023-10-27 15:57:59', '2023-10-27 15:57:59'),
(27, 16, 11, 0, 1, NULL, '2023-10-28 14:46:00', '2023-10-28 14:46:00'),
(28, 17, 11, 0, 1, NULL, '2023-10-30 10:07:42', '2023-10-30 10:07:42'),
(30, 18, 11, 0, 1, NULL, '2023-11-01 13:34:26', '2023-11-01 13:34:26'),
(31, 19, 11, 0, 1, NULL, '2023-11-01 13:51:28', '2023-11-01 13:51:28'),
(32, 20, 11, 0, 1, NULL, '2023-11-01 14:01:20', '2023-11-01 14:01:20'),
(33, 10, 12, 0, 1, NULL, '2023-11-01 16:08:57', '2023-11-01 16:08:57');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('EXAMINATION','PRESCRIPTION','TREATMENT') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PRESCRIPTION',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `type`, `parent_id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'TREATMENT', NULL, 'جراحی', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(2, 'TREATMENT', 1, 'Cornea Surgery', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(3, 'TREATMENT', 2, 'Refractive Surgery', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(4, 'TREATMENT', 2, 'KCN Surgery', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(5, 'TREATMENT', 4, 'Cxl', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(6, 'TREATMENT', 4, 'Ring', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(7, 'TREATMENT', 4, 'Keratoplasty', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(8, 'TREATMENT', 1, 'Eyelid and Plastic Surgery', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(9, 'TREATMENT', 1, 'Glaucoma Surgery', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(10, 'TREATMENT', 1, 'Retina Surgery', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(11, 'PRESCRIPTION', NULL, 'معاینه', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(12, 'PRESCRIPTION', NULL, 'تصویربرداری', NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `service_models`
--

CREATE TABLE `service_models` (
  `id` bigint UNSIGNED NOT NULL,
  `service_category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `condition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calculation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `are_items_independent` tinyint(1) NOT NULL DEFAULT '0',
  `non_prescription` tinyint(1) NOT NULL DEFAULT '0',
  `form_id` bigint DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_models`
--

INSERT INTO `service_models` (`id`, `service_category_id`, `name`, `description`, `condition`, `calculation`, `isActive`, `are_items_independent`, `non_prescription`, `form_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Cataract Surgery', NULL, NULL, '', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(2, 2, 'Pupilloplasty', NULL, NULL, 'prk', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(3, 2, 'Pterygium', NULL, NULL, '', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(4, 3, 'PRK', NULL, 'refractive_prk', 'prk', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(5, 3, 'TRANS-PRK', NULL, 'refractive_transprk', 'trans_prk', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(6, 3, 'Lasik', NULL, 'refractive_lasik', 'lasik', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(7, 3, 'FemtoLasik', NULL, 'refractive_femtolasik', 'femtolasik', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(8, 3, 'Smile', NULL, 'refractive_smile', 'smile', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(9, 3, 'RLE', NULL, 'refractive_rle', '', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(10, 3, 'PIOL', NULL, 'refractive_piol', '', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(11, 3, 'Multifocal-Toric IOL', NULL, NULL, '', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(12, 5, 'Standard', NULL, 'kcn_cxl', 'cxl', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(13, 5, 'Hypotonic', NULL, 'kcn_cxl', 'cxl', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(14, 5, 'Accelerates', NULL, 'kcn_cxl', 'cxl', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(15, 6, 'Intacts', NULL, 'kcn_ring_intacs', 'kcn_ring_intacs', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(16, 6, 'Intacts-SK', NULL, 'kcn_ring_intacsSK', 'kcn_ring_intacs_sk', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(17, 6, 'Keraring', NULL, 'kcn_ring_keraring', 'kcn_ring_keraring', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(18, 6, 'Feraring', NULL, 'kcn_ring_ferrara', 'kcn_ring_feraring', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(19, 6, 'Myoring', NULL, 'kcn_ring_Myoring', 'kcn_ring_myoring', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(20, 7, 'PK', NULL, NULL, '', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(21, 7, 'Anterior', NULL, NULL, '', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(22, 7, 'Posterior', NULL, NULL, '', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(23, 7, 'Large-Graft', NULL, NULL, '', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(24, 11, 'معاینه عمومی چشم', NULL, NULL, '', 1, 0, 1, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(25, 11, 'اپتومتری', NULL, NULL, '', 1, 0, 1, 52, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(26, 12, 'pentacam', NULL, NULL, '', 1, 0, 0, 47, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58'),
(27, 12, 'eyesys', NULL, NULL, '', 1, 0, 0, NULL, NULL, '2023-10-10 15:24:58', '2023-10-10 15:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `service_model_items`
--

CREATE TABLE `service_model_items` (
  `id` bigint UNSIGNED NOT NULL,
  `service_model_id` bigint UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_model_items`
--

INSERT INTO `service_model_items` (`id`, `service_model_id`, `label`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'od', NULL, NULL, NULL),
(2, 1, 'os', NULL, NULL, NULL),
(3, 2, 'od', NULL, NULL, NULL),
(4, 2, 'os', NULL, NULL, NULL),
(5, 3, 'od', NULL, NULL, NULL),
(6, 3, 'os', NULL, NULL, NULL),
(7, 4, 'od', NULL, NULL, NULL),
(8, 4, 'os', NULL, NULL, NULL),
(9, 5, 'od', NULL, NULL, NULL),
(10, 5, 'os', NULL, NULL, NULL),
(11, 6, 'od', NULL, NULL, NULL),
(12, 6, 'os', NULL, NULL, NULL),
(13, 7, 'od', NULL, NULL, NULL),
(14, 7, 'os', NULL, NULL, NULL),
(15, 8, 'od', NULL, NULL, NULL),
(16, 8, 'os', NULL, NULL, NULL),
(17, 9, 'od', NULL, NULL, NULL),
(18, 9, 'os', NULL, NULL, NULL),
(19, 10, 'od', NULL, NULL, NULL),
(20, 10, 'os', NULL, NULL, NULL),
(21, 11, 'od', NULL, NULL, NULL),
(22, 11, 'os', NULL, NULL, NULL),
(23, 12, 'od', NULL, NULL, NULL),
(24, 12, 'os', NULL, NULL, NULL),
(25, 13, 'od', NULL, NULL, NULL),
(26, 13, 'os', NULL, NULL, NULL),
(27, 14, 'od', NULL, NULL, NULL),
(28, 14, 'os', NULL, NULL, NULL),
(29, 15, 'od', NULL, NULL, NULL),
(30, 15, 'os', NULL, NULL, NULL),
(31, 16, 'od', NULL, NULL, NULL),
(32, 16, 'os', NULL, NULL, NULL),
(33, 17, 'od', NULL, NULL, NULL),
(34, 17, 'os', NULL, NULL, NULL),
(35, 19, 'od', NULL, NULL, NULL),
(36, 19, 'os', NULL, NULL, NULL),
(37, 20, 'od', NULL, NULL, NULL),
(38, 20, 'os', NULL, NULL, NULL),
(39, 21, 'od', NULL, NULL, NULL),
(40, 21, 'os', NULL, NULL, NULL),
(41, 22, 'od', NULL, NULL, NULL),
(42, 22, 'os', NULL, NULL, NULL),
(43, 23, 'od', NULL, NULL, NULL),
(44, 23, 'os', NULL, NULL, NULL),
(45, 18, 'od', NULL, NULL, NULL),
(46, 18, 'os', NULL, NULL, NULL),
(47, 24, 'معاینه عمومی چشم', NULL, NULL, NULL),
(48, 25, 'اپتومتری', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `consumer_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_model_item_id` bigint UNSIGNED NOT NULL,
  `visibility` enum('PUBLIC','PRIVATE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PRIVATE',
  `status` enum('PENDING','ACCEPT','CANCELED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `accepted_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accepted_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `consumer_id`, `operator_id`, `service_model_item_id`, `visibility`, `status`, `accepted_by`, `accepted_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(32, '444f0330-cb28-471f-982f-b83ad59f3954', '15256492-33c5-477c-89b5-66dad0793293', 7, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-10-25 16:00:10', NULL, '2023-10-25 15:15:14', '2023-10-25 16:00:10'),
(33, '444f0330-cb28-471f-982f-b83ad59f3954', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 48, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-10-25 15:39:07', NULL, '2023-10-25 15:39:07', '2023-10-25 15:39:07'),
(34, '444f0330-cb28-471f-982f-b83ad59f3954', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 48, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-10-25 15:55:48', NULL, '2023-10-25 15:55:48', '2023-10-25 15:55:48'),
(35, '444f0330-cb28-471f-982f-b83ad59f3954', '15256492-33c5-477c-89b5-66dad0793293', 8, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-10-25 18:31:57', NULL, '2023-10-25 16:54:55', '2023-10-25 18:31:57'),
(36, '444f0330-cb28-471f-982f-b83ad59f3954', '15256492-33c5-477c-89b5-66dad0793293', 4, 'PRIVATE', 'PENDING', NULL, NULL, NULL, '2023-10-25 16:57:29', '2023-10-25 16:57:29'),
(37, '41ed1e14-86ec-4380-a17d-897a1b1eb76a', '15256492-33c5-477c-89b5-66dad0793293', 48, 'PRIVATE', 'ACCEPT', '15256492-33c5-477c-89b5-66dad0793293', '2023-10-27 14:11:59', NULL, '2023-10-27 14:11:59', '2023-10-27 14:11:59'),
(38, '41ed1e14-86ec-4380-a17d-897a1b1eb76a', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 47, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-10-27 14:58:19', NULL, '2023-10-27 14:58:19', '2023-10-27 14:58:19'),
(41, '2aa26d18-9284-4067-be42-7278642fb5df', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 47, 'PRIVATE', 'ACCEPT', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', '2023-10-27 16:04:29', NULL, '2023-10-27 16:04:29', '2023-10-27 16:04:29'),
(42, '57d4c2a1-f767-4dcb-aeda-d85a2134a34e', '15256492-33c5-477c-89b5-66dad0793293', 47, 'PRIVATE', 'PENDING', NULL, NULL, NULL, '2023-10-28 08:21:24', '2023-10-28 08:21:24'),
(43, '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 47, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-10-28 08:34:13', NULL, '2023-10-28 08:34:13', '2023-10-28 08:34:13'),
(44, 'fb287712-a729-4c69-9efa-2cced1df9607', '15256492-33c5-477c-89b5-66dad0793293', 48, 'PRIVATE', 'ACCEPT', '15256492-33c5-477c-89b5-66dad0793293', '2023-10-28 10:32:49', NULL, '2023-10-28 10:32:49', '2023-10-28 10:32:49'),
(45, '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 47, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-10-28 11:52:16', NULL, '2023-10-28 11:52:16', '2023-10-28 11:52:16'),
(46, '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 47, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-10-28 14:28:29', NULL, '2023-10-28 14:28:29', '2023-10-28 14:28:29'),
(47, 'e6f611a8-a83c-48f4-8c55-ad3e9a315b16', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 47, 'PRIVATE', 'ACCEPT', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', '2023-10-28 19:59:11', NULL, '2023-10-28 19:59:11', '2023-10-28 19:59:11'),
(48, 'e6f611a8-a83c-48f4-8c55-ad3e9a315b16', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 47, 'PRIVATE', 'ACCEPT', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', '2023-10-28 19:59:14', NULL, '2023-10-28 19:59:14', '2023-10-28 19:59:14'),
(49, 'e6f611a8-a83c-48f4-8c55-ad3e9a315b16', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 47, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-10-28 20:20:39', NULL, '2023-10-28 20:20:39', '2023-10-28 20:20:39'),
(50, '2aa26d18-9284-4067-be42-7278642fb5df', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 47, 'PRIVATE', 'ACCEPT', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', '2023-10-28 20:34:51', NULL, '2023-10-28 20:34:51', '2023-10-28 20:34:51'),
(51, '2aa26d18-9284-4067-be42-7278642fb5df', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', 47, 'PRIVATE', 'ACCEPT', '7b0b26d2-2e48-42fb-9e93-743e1ea78cae', '2023-10-28 20:34:53', NULL, '2023-10-28 20:34:53', '2023-10-28 20:34:53'),
(52, '4a9e7f80-81a2-43e0-a534-c8920b6b10d9', '15256492-33c5-477c-89b5-66dad0793293', 15, 'PRIVATE', 'ACCEPT', '15256492-33c5-477c-89b5-66dad0793293', '2023-10-30 10:09:26', NULL, '2023-10-30 10:08:17', '2023-10-30 10:09:26'),
(53, '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 48, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-10-30 14:27:57', NULL, '2023-10-30 14:27:57', '2023-10-30 14:27:57'),
(54, '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 48, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-10-30 17:27:23', NULL, '2023-10-30 17:27:23', '2023-10-30 17:27:23'),
(55, '4a9e7f80-81a2-43e0-a534-c8920b6b10d9', '09419fb5-7adb-443d-b10e-05e38785060c', 47, 'PRIVATE', 'ACCEPT', '09419fb5-7adb-443d-b10e-05e38785060c', '2023-11-01 12:18:58', NULL, '2023-11-01 12:18:58', '2023-11-01 12:18:58'),
(56, '57d4c2a1-f767-4dcb-aeda-d85a2134a34e', '09419fb5-7adb-443d-b10e-05e38785060c', 48, 'PRIVATE', 'ACCEPT', '09419fb5-7adb-443d-b10e-05e38785060c', '2023-11-01 13:34:56', NULL, '2023-11-01 13:34:56', '2023-11-01 13:34:56'),
(57, 'fb287712-a729-4c69-9efa-2cced1df9607', '12fe91e4-ff62-4bfd-ac7b-5bf6dbec69ff', 48, 'PRIVATE', 'ACCEPT', '12fe91e4-ff62-4bfd-ac7b-5bf6dbec69ff', '2023-11-01 13:51:50', NULL, '2023-11-01 13:51:50', '2023-11-01 13:51:50'),
(58, 'e6f611a8-a83c-48f4-8c55-ad3e9a315b16', '36ac3ed9-475b-4c86-86ee-cc0c46a8e689', 48, 'PRIVATE', 'ACCEPT', '36ac3ed9-475b-4c86-86ee-cc0c46a8e689', '2023-11-01 14:01:49', NULL, '2023-11-01 14:01:49', '2023-11-01 14:01:49'),
(59, '8a0c44f9-64e7-400f-afaf-0467ad408a97', '36ac3ed9-475b-4c86-86ee-cc0c46a8e689', 48, 'PRIVATE', 'ACCEPT', '36ac3ed9-475b-4c86-86ee-cc0c46a8e689', '2023-11-01 14:03:33', NULL, '2023-11-01 14:03:33', '2023-11-01 14:03:33'),
(60, '8a0c44f9-64e7-400f-afaf-0467ad408a97', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 6, 'PRIVATE', 'PENDING', NULL, NULL, NULL, '2023-11-01 16:23:02', '2023-11-01 16:23:02'),
(61, '4a9e7f80-81a2-43e0-a534-c8920b6b10d9', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 47, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-11-06 13:18:04', NULL, '2023-11-06 13:18:04', '2023-11-06 13:18:04'),
(62, '444f0330-cb28-471f-982f-b83ad59f3954', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 47, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-11-07 09:19:35', NULL, '2023-11-07 09:19:35', '2023-11-07 09:19:35'),
(63, '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 47, 'PRIVATE', 'ACCEPT', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', '2023-11-09 10:48:06', NULL, '2023-11-09 10:48:06', '2023-11-09 10:48:06'),
(64, 'db9a540b-73a8-49ea-a2ba-fe0a4ddbe47d', '09419fb5-7adb-443d-b10e-05e38785060c', 48, 'PRIVATE', 'ACCEPT', '09419fb5-7adb-443d-b10e-05e38785060c', '2023-11-09 11:54:38', NULL, '2023-11-09 11:54:38', '2023-11-09 11:54:38'),
(65, '4a9e7f80-81a2-43e0-a534-c8920b6b10d9', '15256492-33c5-477c-89b5-66dad0793293', 15, 'PRIVATE', 'ACCEPT', '15256492-33c5-477c-89b5-66dad0793293', '2023-11-11 14:22:31', NULL, '2023-11-11 14:22:31', '2023-11-11 14:22:31'),
(66, 'c8c2bb0a-2826-41f1-90bc-f782d683546c', '12fe91e4-ff62-4bfd-ac7b-5bf6dbec69ff', 48, 'PRIVATE', 'ACCEPT', '12fe91e4-ff62-4bfd-ac7b-5bf6dbec69ff', '2023-11-11 17:08:22', NULL, '2023-11-11 17:08:22', '2023-11-11 17:08:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consumers`
--
ALTER TABLE `consumers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operators`
--
ALTER TABLE `operators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `operator_exception_availabilities`
--
ALTER TABLE `operator_exception_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `operator_exception_availabilities_service_application_id_foreign` (`service_application_id`),
  ADD KEY `operator_exception_availabilities_place_id_foreign` (`place_id`);

--
-- Indexes for table `operator_weekly_availabilities`
--
ALTER TABLE `operator_weekly_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `operator_weekly_availabilities_service_application_id_foreign` (`service_application_id`),
  ADD KEY `operator_weekly_availabilities_place_id_foreign` (`place_id`);

--
-- Indexes for table `operator_yearly_availabilities`
--
ALTER TABLE `operator_yearly_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `operator_yearly_availabilities_service_application_id_foreign` (`service_application_id`),
  ADD KEY `operator_yearly_availabilities_place_id_foreign` (`place_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reserves_consumer_id_foreign` (`consumer_id`),
  ADD KEY `reserves_operator_id_foreign` (`operator_id`) USING BTREE,
  ADD KEY `reserves_service_application_place_id_foreign` (`service_application_place_id`),
  ADD KEY `reserves_service_model_item_id_foreign` (`service_model_item_id`);

--
-- Indexes for table `reserve_items`
--
ALTER TABLE `reserve_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_service_model_id_foreign` (`service_model_id`);

--
-- Indexes for table `service_applications`
--
ALTER TABLE `service_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_application_items`
--
ALTER TABLE `service_application_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_application_places`
--
ALTER TABLE `service_application_places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_application_places_service_application_id_foreign` (`service_application_id`),
  ADD KEY `service_application_places_address_id_foreign` (`address_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_models`
--
ALTER TABLE `service_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_models_service_category_id_foreign` (`service_category_id`);

--
-- Indexes for table `service_model_items`
--
ALTER TABLE `service_model_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_model_items_service_model_id_foreign` (`service_model_id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_requests_consumer_id_foreign` (`consumer_id`),
  ADD KEY `service_requests_operator_id_foreign` (`operator_id`),
  ADD KEY `service_requests_accepted_by_foreign` (`accepted_by`),
  ADD KEY `service_requests_service_model_item_id_foreign` (`service_model_item_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `operator_exception_availabilities`
--
ALTER TABLE `operator_exception_availabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `operator_weekly_availabilities`
--
ALTER TABLE `operator_weekly_availabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `operator_yearly_availabilities`
--
ALTER TABLE `operator_yearly_availabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserve_items`
--
ALTER TABLE `reserve_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `service_applications`
--
ALTER TABLE `service_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `service_application_items`
--
ALTER TABLE `service_application_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_application_places`
--
ALTER TABLE `service_application_places`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `service_models`
--
ALTER TABLE `service_models`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `service_model_items`
--
ALTER TABLE `service_model_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `operator_exception_availabilities`
--
ALTER TABLE `operator_exception_availabilities`
  ADD CONSTRAINT `operator_exception_availabilities_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `service_application_places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `operator_exception_availabilities_service_application_id_foreign` FOREIGN KEY (`service_application_id`) REFERENCES `service_applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `operator_weekly_availabilities`
--
ALTER TABLE `operator_weekly_availabilities`
  ADD CONSTRAINT `operator_weekly_availabilities_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `service_application_places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `operator_weekly_availabilities_service_application_id_foreign` FOREIGN KEY (`service_application_id`) REFERENCES `service_applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `operator_yearly_availabilities`
--
ALTER TABLE `operator_yearly_availabilities`
  ADD CONSTRAINT `operator_yearly_availabilities_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `service_application_places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `operator_yearly_availabilities_service_application_id_foreign` FOREIGN KEY (`service_application_id`) REFERENCES `service_applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reserves`
--
ALTER TABLE `reserves`
  ADD CONSTRAINT `reserves_consumer_id_foreign` FOREIGN KEY (`consumer_id`) REFERENCES `consumers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reserves_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `reserves_service_application_place_id_foreign` FOREIGN KEY (`service_application_place_id`) REFERENCES `service_application_places` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `reserves_service_model_item_id_foreign` FOREIGN KEY (`service_model_item_id`) REFERENCES `service_model_items` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_service_model_id_foreign` FOREIGN KEY (`service_model_id`) REFERENCES `service_models` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_application_places`
--
ALTER TABLE `service_application_places`
  ADD CONSTRAINT `service_application_places_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_application_places_service_application_id_foreign` FOREIGN KEY (`service_application_id`) REFERENCES `service_applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_models`
--
ALTER TABLE `service_models`
  ADD CONSTRAINT `service_models_service_category_id_foreign` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_model_items`
--
ALTER TABLE `service_model_items`
  ADD CONSTRAINT `service_model_items_service_model_id_foreign` FOREIGN KEY (`service_model_id`) REFERENCES `service_models` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_accepted_by_foreign` FOREIGN KEY (`accepted_by`) REFERENCES `operators` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_requests_consumer_id_foreign` FOREIGN KEY (`consumer_id`) REFERENCES `consumers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_requests_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_requests_service_model_item_id_foreign` FOREIGN KEY (`service_model_item_id`) REFERENCES `service_model_items` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
