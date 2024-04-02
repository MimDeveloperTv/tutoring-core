-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 13, 2023 at 04:27 PM
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
-- Database: `front_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_diagnoses`
--

CREATE TABLE `ai_diagnoses` (
  `id` bigint UNSIGNED NOT NULL,
  `medical_record` bigint UNSIGNED NOT NULL,
  `patient_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eye_type` enum('od','os') COLLATE utf8mb4_unicode_ci NOT NULL,
  `pentacam` json DEFAULT NULL,
  `eyesys` json DEFAULT NULL,
  `grade` json DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_diagnoses`
--

CREATE TABLE `doctor_diagnoses` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eye_type` enum('od','os') COLLATE utf8mb4_unicode_ci NOT NULL,
  `topography` json DEFAULT NULL,
  `grade` json DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `errors`
--

CREATE TABLE `errors` (
  `id` bigint UNSIGNED NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('SEEN','NEW') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NEW',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `error_messages`
--

CREATE TABLE `error_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `error_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examinations`
--

CREATE TABLE `examinations` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examination_records`
--

CREATE TABLE `examination_records` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eye_variables`
--

CREATE TABLE `eye_variables` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eye_type` enum('od','os') COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` enum('pentacam','optometry') COLLATE utf8mb4_unicode_ci NOT NULL,
  `K1_D` double(10,2) DEFAULT NULL,
  `K2_D` double(10,2) DEFAULT NULL,
  `pachy_min` double(10,2) DEFAULT NULL,
  `KM_D` double(10,2) DEFAULT NULL,
  `astig_topo` double(10,2) DEFAULT NULL,
  `Axis_flat` double(10,2) DEFAULT NULL,
  `ac_depth` double(10,2) DEFAULT NULL,
  `subjective_ref_sph` double(10,2) DEFAULT NULL,
  `subjective_ref_cyl` double(10,2) DEFAULT NULL,
  `PupilX` double(10,2) DEFAULT NULL,
  `PupilY` double(10,2) DEFAULT NULL,
  `subjective_ref_axis` double(10,2) DEFAULT NULL,
  `subjective_ref_bcva` double(10,2) DEFAULT NULL,
  `optometry_ucva` double(10,2) DEFAULT NULL,
  `mixed_data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_histories`
--

CREATE TABLE `medical_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dryness` tinyint(1) NOT NULL DEFAULT '0',
  `chronic_tearing` tinyint(1) NOT NULL DEFAULT '0',
  `chronic_allergy` tinyint(1) NOT NULL DEFAULT '0',
  `blepharitis` tinyint(1) NOT NULL DEFAULT '0',
  `contact_lens_use` tinyint(1) NOT NULL DEFAULT '0',
  `recurrent_corneal_erosion` tinyint(1) NOT NULL DEFAULT '0',
  `previous_ocular_trauma` tinyint(1) NOT NULL DEFAULT '0',
  `previous_ocular_surgery` tinyint(1) NOT NULL DEFAULT '0',
  `any_other_ocular_diseases` tinyint(1) NOT NULL DEFAULT '0',
  `diabetes` tinyint(1) NOT NULL DEFAULT '0',
  `blood_pressure` tinyint(1) NOT NULL DEFAULT '0',
  `known_medication_allergy` tinyint(1) NOT NULL DEFAULT '0',
  `known_allergy_to_food_metals_or_others` tinyint(1) NOT NULL DEFAULT '0',
  `collagen_systemic_diseases` tinyint(1) NOT NULL DEFAULT '0',
  `use_of_anti_coagulants` tinyint(1) NOT NULL DEFAULT '0',
  `or_steroids` tinyint(1) NOT NULL DEFAULT '0',
  `or_isotretinoin` tinyint(1) NOT NULL DEFAULT '0',
  `or_immunosuppressant` tinyint(1) NOT NULL DEFAULT '0',
  `or_sumatriptan` tinyint(1) NOT NULL DEFAULT '0',
  `pregnancy` tinyint(1) NOT NULL DEFAULT '0',
  `lactation` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prescriber_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prescription_id` bigint UNSIGNED NOT NULL,
  `prescription_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prescription_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_item` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operator_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('NEW','DRAFT','SUBMIT') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NEW',
  `created_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `record` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`id`, `patient_id`, `prescriber_id`, `prescription_id`, `prescription_type`, `prescription_name`, `service_item`, `operator_id`, `status`, `created_by`, `record`, `created_at`, `updated_at`) VALUES
(1, '2aa26d18-9284-4067-be42-7278642fb5df', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 63, 'PRESCRIPTION', 'معاینه عمومی چشم - معاینه عمومی چشم', 'معاینه عمومی چشم', '384ba1f8-b2b7-42fa-87f6-c29f40a87826', 'NEW', NULL, '[{\"id\":45,\"name\":\"pentacam form\",\"type\":null,\"active\":1},{\"id\":46,\"name\":\"pentacam form\",\"type\":null,\"active\":1},{\"id\":47,\"name\":\"pentacam form\",\"type\":null,\"active\":1},{\"id\":48,\"name\":\"pentacam form\",\"type\":null,\"active\":1},{\"id\":49,\"name\":\"pentacam form\",\"type\":null,\"active\":1},{\"id\":50,\"name\":\"PRK Surgery\",\"type\":null,\"active\":1}]', '2023-11-09 10:48:07', '2023-11-09 10:48:07'),
(2, 'db9a540b-73a8-49ea-a2ba-fe0a4ddbe47d', '09419fb5-7adb-443d-b10e-05e38785060c', 64, 'PRESCRIPTION', 'اپتومتری - اپتومتری', 'اپتومتری', '09419fb5-7adb-443d-b10e-05e38785060c', 'NEW', NULL, '{\"id\":52,\"name\":\"Optometry\",\"type\":null,\"active\":true,\"rows\":[{\"cols\":[{\"name\":\"Optometry\",\"child\":[{\"type\":\"optometry\",\"element\":\"input\",\"fieldSetting\":{\"key\":null,\"label\":\"This is Optometry Form\",\"value\":\"\",\"options\":[]},\"required\":null}]}]},{\"cols\":[{\"name\":\"OD\",\"child\":[{\"type\":\"paint\",\"element\":\"input\",\"fieldSetting\":{\"key\":null,\"label\":\"Title\",\"value\":\"\",\"options\":[]},\"required\":null}]},{\"name\":\"OS\",\"child\":[{\"type\":\"paint\",\"element\":\"input\",\"fieldSetting\":{\"key\":null,\"label\":\"Title\",\"value\":\"\",\"options\":[]},\"required\":null}]}]}]}', '2023-11-09 11:54:39', '2023-11-09 11:54:39'),
(3, '4a9e7f80-81a2-43e0-a534-c8920b6b10d9', '15256492-33c5-477c-89b5-66dad0793293', 65, 'TREATMENT', 'Smile - od', 'od', '15256492-33c5-477c-89b5-66dad0793293', 'NEW', NULL, '{\"Diopter\":[{\"title\":\"sph\",\"value\":null,\"error\":0},{\"title\":\"cyl\",\"value\":null},{\"title\":\"axis\",\"value\":null}],\"Optical Zone\":[{\"title\":\"mm\",\"value\":null}],\"Max Ablation\":[{\"title\":\"um\",\"value\":null,\"error\":0}],\"RSB\":[{\"title\":\"um\",\"value\":null,\"error\":0}],\"Treatment Pack Size\":[{\"title\":\"Treatment Pack Size\",\"value\":\"S (9.5)\"}],\"Lenticule Parameters\":[{\"title\":\"Min Thichkness\",\"value\":\"15\"},{\"title\":\"Side cut angle\",\"value\":\"100\"}],\"Cap Parameters\":[{\"title\":\"Diameter\",\"value\":\"7.7\"},{\"title\":\"Thichkness\",\"value\":\"120\"},{\"title\":\"Side cut angle\",\"value\":\"90\"}],\"Incision Parameters\":[{\"title\":\"Angle\",\"value\":\"45\"},{\"title\":\"Width\",\"value\":\"3\"}]}', '2023-11-11 14:22:32', '2023-11-11 14:22:32'),
(4, 'c8c2bb0a-2826-41f1-90bc-f782d683546c', '12fe91e4-ff62-4bfd-ac7b-5bf6dbec69ff', 66, 'PRESCRIPTION', 'اپتومتری - اپتومتری', 'اپتومتری', '12fe91e4-ff62-4bfd-ac7b-5bf6dbec69ff', 'NEW', NULL, '{\"id\":52,\"name\":\"Optometry\",\"type\":null,\"active\":true,\"rows\":[{\"cols\":[{\"name\":\"Optometry\",\"child\":[{\"type\":\"optometry\",\"element\":\"input\",\"fieldSetting\":{\"key\":null,\"label\":\"This is Optometry Form\",\"value\":\"\",\"options\":[]},\"required\":null}]}]},{\"cols\":[{\"name\":\"OD\",\"child\":[{\"type\":\"paint\",\"element\":\"input\",\"fieldSetting\":{\"key\":null,\"label\":\"Title\",\"value\":\"\",\"options\":[]},\"required\":null}]},{\"name\":\"OS\",\"child\":[{\"type\":\"paint\",\"element\":\"input\",\"fieldSetting\":{\"key\":null,\"label\":\"Title\",\"value\":\"\",\"options\":[]},\"required\":null}]}]}]}', '2023-11-11 17:08:23', '2023-11-11 17:08:23');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_09_12_090815_create_patients_table', 1),
(6, '2023_09_12_090831_create_operators_table', 1),
(7, '2023_09_12_090917_create_prescriptions_table', 1),
(8, '2023_09_12_101016_create_patient_files_table', 1),
(9, '2023_09_12_124600_create_prescription_categories_table', 1),
(10, '2023_09_12_131437_create_departments_table', 1),
(11, '2023_09_12_131451_create_services_table', 1),
(12, '2023_09_12_131630_create_examinations_table', 1),
(13, '2023_09_12_131703_create_examination_records_table', 1),
(14, '2023_09_12_131810_create_prescription_records_table', 1),
(15, '2023_09_17_152605_create_personnels_table', 1),
(16, '2023_10_07_050704_create_appointments_table', 1),
(17, '2023_10_09_045217_create_optometries_table', 1),
(18, '2023_10_09_085024_create_eye_variables_table', 1),
(19, '2023_10_09_110423_create_ai_diagnoses_table', 1),
(20, '2023_10_09_110434_create_doctor_diagnoses_table', 1),
(21, '2023_10_11_081102_create_medical_histories_table', 1),
(22, '2023_10_16_145115_create_media_table', 1),
(23, '2023_10_18_105540_create_medical_records_table', 1),
(24, '2023_10_24_102847_create_errors_table', 1),
(25, '2023_10_24_103034_create_error_messages_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `operators`
--

CREATE TABLE `operators` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operators`
--

INSERT INTO `operators` (`id`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
('741c3152-8ed9-48f1-89b7-d4fe78ef90cb', 'd741c636-f808-4bd9-874c-f00b37574281', NULL, '2023-11-09 12:11:57', '2023-11-09 12:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `optometries`
--

CREATE TABLE `optometries` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
('1382aa4e-a17d-4564-94f5-d94ad327555a', '0f309e1c-b74b-40ce-aedf-f2245c07886c', NULL, '2023-11-11 18:29:45', '2023-11-11 18:29:45'),
('c8c2bb0a-2826-41f1-90bc-f782d683546c', '9937c96d-f2ec-437a-add5-7506a3bb3477', NULL, '2023-11-10 17:41:11', '2023-11-10 17:41:11'),
('db9a540b-73a8-49ea-a2ba-fe0a4ddbe47d', 'c29a031c-0fd4-4249-88ec-69fbea149760', NULL, '2023-11-09 11:39:23', '2023-11-09 11:39:23');

-- --------------------------------------------------------

--
-- Table structure for table `patient_files`
--

CREATE TABLE `patient_files` (
  `id` bigint UNSIGNED NOT NULL,
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
-- Table structure for table `personnels`
--

CREATE TABLE `personnels` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personnels`
--

INSERT INTO `personnels` (`id`, `user_id`, `firstname`, `lastname`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'b64abe55-d47d-421d-999f-af0950e54bde', 'ali', 'yousefi', NULL, '2023-11-08 14:56:59', '2023-11-08 14:56:59');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_model_id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_categories`
--

CREATE TABLE `prescription_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_records`
--

CREATE TABLE `prescription_records` (
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `national_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` bigint UNSIGNED NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('MALE','FEMALE','OTHERS') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OTHERS',
  `avatar` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `national_code`, `email`, `mobile`, `password`, `firstname`, `lastname`, `birth_date`, `gender`, `avatar`, `isActive`, `api_token`, `email_verified_at`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
('0f309e1c-b74b-40ce-aedf-f2245c07886c', '1232323223', NULL, 9123232325, NULL, 'Johan', 'Carlberg', '2023-11-02', 'MALE', NULL, 1, NULL, NULL, NULL, NULL, '2023-11-11 18:29:44', '2023-11-11 18:29:44'),
('9937c96d-f2ec-437a-add5-7506a3bb3477', '1234567890', 'alison@gmail.com', 9121111112, '$2y$10$wGjSQnuQ6YPDSkvi62FnTOM/9MrZm/6tPnl8cy6tixpslzbbopF92', 'Alison', 'Becker', '1402-08-10', 'FEMALE', NULL, 1, NULL, NULL, NULL, NULL, '2023-11-10 17:41:10', '2023-11-10 17:41:10'),
('b64abe55-d47d-421d-999f-af0950e54bde', '33333333', 'hamid@gmail.com', 11111111111, '$2y$10$ZkAOI5bmLMHUrVc1e.GYdO0ZZaTzsYKzCO7pSpoBtLH1Iz5vwj7ra', 'ali', 'yousefi', '2023-11-08', 'OTHERS', NULL, 1, '69e62fe3aaadb6fd7568cb9725e66a345160ba37', NULL, NULL, NULL, '2023-11-08 14:56:59', '2023-11-09 11:05:22'),
('c29a031c-0fd4-4249-88ec-69fbea149760', '1010010101', 'yesno@gmail.com', 9120000000, '$2y$10$oMED3goIeAbmXvx7eJkz5.rkSKMog68euwbJUuwDxtMbNmZV851p2', 'Yes', 'Nosdf', '2023-11-23', 'MALE', NULL, 1, NULL, NULL, NULL, NULL, '2023-11-09 11:39:22', '2023-11-09 11:39:22'),
('d741c636-f808-4bd9-874c-f00b37574281', '102232323', '11111111111', 9123232323, '$2y$10$eOkZQYy8RPmNsX4Du0vKYe83Swb9MYv.LpxKZUuc3q/7fGceaNSMa', 'Hello', 'Nothing', '2023-11-13', 'FEMALE', 'C:\\fakepath\\Vaprowave.jpg', 1, NULL, NULL, NULL, NULL, '2023-11-09 12:11:56', '2023-11-09 12:11:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_diagnoses`
--
ALTER TABLE `ai_diagnoses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ai_diagnoses_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_operator_id_foreign` (`operator_id`),
  ADD KEY `appointments_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_diagnoses`
--
ALTER TABLE `doctor_diagnoses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_diagnoses_patient_id_foreign` (`patient_id`),
  ADD KEY `doctor_diagnoses_operator_id_foreign` (`operator_id`);

--
-- Indexes for table `errors`
--
ALTER TABLE `errors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `error_messages`
--
ALTER TABLE `error_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examinations`
--
ALTER TABLE `examinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examination_records`
--
ALTER TABLE `examination_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eye_variables`
--
ALTER TABLE `eye_variables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eye_variables_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `medical_histories`
--
ALTER TABLE `medical_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_histories_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
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
  ADD KEY `operators_user_id_foreign` (`user_id`);

--
-- Indexes for table `optometries`
--
ALTER TABLE `optometries`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `patient_files`
--
ALTER TABLE `patient_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `personnels`
--
ALTER TABLE `personnels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personnels_user_id_foreign` (`user_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescriptions_patient_id_foreign` (`patient_id`),
  ADD KEY `prescriptions_operator_id_foreign` (`operator_id`);

--
-- Indexes for table `prescription_categories`
--
ALTER TABLE `prescription_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription_records`
--
ALTER TABLE `prescription_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_national_code_unique` (`national_code`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_diagnoses`
--
ALTER TABLE `ai_diagnoses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_diagnoses`
--
ALTER TABLE `doctor_diagnoses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `errors`
--
ALTER TABLE `errors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `error_messages`
--
ALTER TABLE `error_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examinations`
--
ALTER TABLE `examinations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examination_records`
--
ALTER TABLE `examination_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eye_variables`
--
ALTER TABLE `eye_variables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_histories`
--
ALTER TABLE `medical_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `optometries`
--
ALTER TABLE `optometries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_files`
--
ALTER TABLE `patient_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personnels`
--
ALTER TABLE `personnels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_categories`
--
ALTER TABLE `prescription_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_records`
--
ALTER TABLE `prescription_records`
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
-- Constraints for table `ai_diagnoses`
--
ALTER TABLE `ai_diagnoses`
  ADD CONSTRAINT `ai_diagnoses_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_diagnoses`
--
ALTER TABLE `doctor_diagnoses`
  ADD CONSTRAINT `doctor_diagnoses_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_diagnoses_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eye_variables`
--
ALTER TABLE `eye_variables`
  ADD CONSTRAINT `eye_variables_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medical_histories`
--
ALTER TABLE `medical_histories`
  ADD CONSTRAINT `medical_histories_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `operators`
--
ALTER TABLE `operators`
  ADD CONSTRAINT `operators_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `personnels`
--
ALTER TABLE `personnels`
  ADD CONSTRAINT `personnels_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prescriptions_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
