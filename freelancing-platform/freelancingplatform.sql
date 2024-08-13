-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 13, 2024 at 11:31 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freelancingplatform`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Yassir', 'yassirfri318@gmail.com', NULL, '$2y$10$HbAJ1jBqFCu/qRyZ2Bf6rOj/2Xxea0EIMZUSYsspNiXLThKDTv.3i', NULL, '2024-08-11 09:52:43', '2024-08-11 09:52:43');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

DROP TABLE IF EXISTS `deposits`;
CREATE TABLE IF NOT EXISTS `deposits` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `deposits_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `user_id`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(6, 4, '1500.00', 'pending', '2024-08-09 16:14:08', '2024-08-09 16:14:08'),
(7, 4, '100.00', 'pending', '2024-08-09 22:22:28', '2024-08-09 22:22:28'),
(8, 4, '100.00', 'pending', '2024-08-09 22:25:23', '2024-08-09 22:25:23'),
(9, 4, '100.00', 'pending', '2024-08-09 22:26:06', '2024-08-09 22:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_08_01_212103_create_admins_table', 2),
(6, '2024_08_01_230340_add_profile_picture_and_description_to_users_table', 3),
(7, '2024_08_01_230445_create_deposits_table', 3),
(8, '2024_08_01_230717_create_withdrawals_table', 3),
(9, '2024_08_05_123949_create_services_table', 4),
(10, '2024_08_05_124006_create_reviews_table', 4),
(11, '2024_08_05_124022_create_orders_table', 4),
(12, '2024_08_05_133315_create_notifications_table', 5),
(13, '2024_08_05_141203_add_verification_fields_to_users_table', 6),
(14, '2024_08_06_095127_add_image_and_tag_to_services_table', 7),
(15, '2024_08_06_113347_create_verification_requests_table', 8),
(16, '2024_08_07_231625_create_offers_table', 9),
(17, '2024_08_07_232206_add_offer_fields_to_orders_table', 10),
(18, '2024_08_08_232137_add_order_id_to_reviews_table', 11),
(19, '2024_08_09_181431_add_order_id_to_notifications_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `notifiable_id` int DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  KEY `notifications_order_id_foreign` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `notifiable_id`, `order_id`, `title`, `message`, `is_read`, `notifiable_type`, `created_at`, `updated_at`) VALUES
(11, 5, NULL, NULL, 'New Offer Received', 'You have received a new offer for can you build my web application worth $100.00', 1, NULL, '2024-08-10 12:03:59', '2024-08-12 16:09:59'),
(12, 4, NULL, NULL, NULL, NULL, 1, NULL, '2024-08-10 12:04:59', '2024-08-12 16:09:31'),
(13, 5, NULL, NULL, 'Order Created', 'An order has been created for can you build my web application worth $100.00', 1, NULL, '2024-08-10 12:04:59', '2024-08-12 16:09:59'),
(14, 4, NULL, NULL, 'Order Submitted', 'Your order for you need hosting here is your app has been submitted.', 1, NULL, '2024-08-10 12:05:51', '2024-08-12 16:09:31'),
(15, 5, NULL, NULL, 'Submission Approved', 'Your submission for you need hosting here is your app has been approved.', 1, NULL, '2024-08-10 12:06:18', '2024-08-12 16:09:59'),
(16, 5, NULL, NULL, 'New Offer Received', 'You have received a new offer for build me a web application with laravel worth $100.00', 1, NULL, '2024-08-10 12:09:09', '2024-08-12 16:09:59'),
(17, 4, NULL, NULL, NULL, NULL, 1, NULL, '2024-08-10 12:09:26', '2024-08-12 16:09:31'),
(18, 5, NULL, NULL, 'Order Created', 'An order has been created for build me a web application with laravel worth $100.00', 1, NULL, '2024-08-10 12:09:26', '2024-08-12 16:09:59'),
(19, 4, NULL, NULL, 'Order Submitted', 'Your order for application built has been submitted.', 1, NULL, '2024-08-10 12:09:51', '2024-08-12 16:09:31'),
(20, 5, NULL, NULL, 'Submission Approved', 'Your submission for application built has been approved.', 1, NULL, '2024-08-10 12:10:16', '2024-08-12 16:09:59'),
(21, 5, NULL, NULL, 'New Offer Received', 'You have received a new offer for asdmfasdf worth $100.00', 1, NULL, '2024-08-10 13:21:26', '2024-08-12 16:09:59'),
(22, 5, NULL, NULL, 'New Offer Received', 'You have received a new offer for adskflasdfsd worth $100.00', 1, NULL, '2024-08-10 13:36:19', '2024-08-12 16:09:59'),
(23, 4, NULL, NULL, NULL, NULL, 1, NULL, '2024-08-10 13:36:36', '2024-08-12 16:09:31'),
(24, 5, NULL, NULL, 'Order Created', 'An order has been created for adskflasdfsd worth $100.00', 1, NULL, '2024-08-10 13:36:36', '2024-08-12 16:09:59'),
(25, 5, NULL, NULL, 'New Offer Received', 'You have received a new offer for afadsfasdf worth $100.00', 1, NULL, '2024-08-10 13:45:53', '2024-08-12 16:09:59'),
(26, 4, NULL, NULL, NULL, NULL, 1, NULL, '2024-08-10 13:46:40', '2024-08-12 16:09:31'),
(27, 5, NULL, NULL, 'Order Created', 'An order has been created for afadsfasdf worth $100.00', 1, NULL, '2024-08-10 13:46:40', '2024-08-12 16:09:59'),
(28, 4, NULL, NULL, 'Order Submitted', 'Your order for asdfasdfa has been submitted.', 1, NULL, '2024-08-10 13:47:07', '2024-08-12 16:09:31'),
(29, 5, NULL, NULL, 'Submission Approved', 'Your submission for asdfasdfa has been approved.', 1, NULL, '2024-08-10 13:48:07', '2024-08-12 16:09:59'),
(30, 4, NULL, NULL, 'New Offer Received', 'You have received a new offer for adsfasdf worth $100.00', 1, NULL, '2024-08-10 13:50:14', '2024-08-12 16:09:31'),
(31, 5, NULL, NULL, NULL, NULL, 1, NULL, '2024-08-10 13:50:34', '2024-08-12 16:09:59'),
(32, 4, NULL, NULL, 'Order Created', 'An order has been created for adsfasdf worth $100.00', 1, NULL, '2024-08-10 13:50:34', '2024-08-12 16:09:31'),
(33, 5, NULL, NULL, 'New Offer Received', 'You have received a new offer for ssfasdf worth $100.00', 1, NULL, '2024-08-11 16:24:14', '2024-08-12 16:09:59'),
(34, 5, NULL, NULL, 'New Offer Received', 'You have received a new offer for oiewuirioq worth $100.00', 1, NULL, '2024-08-12 16:06:47', '2024-08-12 16:09:59'),
(35, 4, NULL, NULL, NULL, NULL, 1, NULL, '2024-08-12 16:07:26', '2024-08-12 16:09:31'),
(36, 5, NULL, NULL, 'Order Created', 'An order has been created for ssfasdf worth $100.00', 1, NULL, '2024-08-12 16:07:26', '2024-08-12 16:09:59'),
(37, 4, NULL, NULL, 'Order Submitted', 'Your order for ajlddfjqioewr has been submitted.', 1, NULL, '2024-08-12 16:08:23', '2024-08-12 16:09:31'),
(38, 5, NULL, NULL, 'Submission Approved', 'Your submission for ajlddfjqioewr has been approved.', 1, NULL, '2024-08-12 16:09:11', '2024-08-12 16:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
CREATE TABLE IF NOT EXISTS `offers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint UNSIGNED NOT NULL,
  `seller_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `fee` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deadline` date NOT NULL,
  `revisions` int DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `offers_buyer_id_foreign` (`buyer_id`),
  KEY `offers_seller_id_foreign` (`seller_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `buyer_id`, `seller_id`, `amount`, `fee`, `description`, `deadline`, `revisions`, `status`, `created_at`, `updated_at`) VALUES
(38, 4, 5, '100.00', 5, 'asdmfasdf', '2024-08-24', NULL, 'approved', '2024-08-10 13:21:25', '2024-08-10 13:31:10'),
(39, 4, 5, '100.00', 5, 'adskflasdfsd', '2024-08-14', NULL, 'approved', '2024-08-10 13:36:19', '2024-08-10 13:36:36'),
(40, 4, 5, '100.00', 5, 'afadsfasdf', '2024-08-14', NULL, 'approved', '2024-08-10 13:45:53', '2024-08-10 13:46:40'),
(41, 5, 4, '100.00', 5, 'adsfasdf', '2024-08-22', NULL, 'approved', '2024-08-10 13:50:14', '2024-08-10 13:50:34'),
(42, 4, 5, '100.00', 5, 'ssfasdf', '2024-08-23', NULL, 'approved', '2024-08-11 16:24:10', '2024-08-12 16:07:25'),
(43, 4, 5, '100.00', 5, 'oiewuirioq', '2024-08-22', NULL, 'pending', '2024-08-12 16:06:44', '2024-08-12 16:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint UNSIGNED NOT NULL,
  `seller_id` bigint UNSIGNED NOT NULL,
  `review_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','completed','cancelled','in-progress','on-hold') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `amount` decimal(10,2) NOT NULL,
  `fee` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `offer_id` bigint UNSIGNED DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_buyer_id_foreign` (`buyer_id`),
  KEY `orders_seller_id_foreign` (`seller_id`),
  KEY `orders_review_id_foreign` (`review_id`),
  KEY `orders_offer_id_foreign` (`offer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `buyer_id`, `seller_id`, `review_id`, `status`, `description`, `amount`, `fee`, `created_at`, `updated_at`, `offer_id`, `deadline`, `attachment`) VALUES
(25, 4, 5, 4, 'completed', 'asdfasdfa', '100.00', 10, '2024-08-10 13:46:40', '2024-08-11 16:24:31', 40, '2024-08-14', NULL),
(26, 5, 4, NULL, 'in-progress', 'adsfasdf', '100.00', 10, '2024-08-10 13:50:34', '2024-08-10 13:50:34', 41, '2024-08-22', NULL),
(27, 4, 5, 5, 'completed', 'ajlddfjqioewr', '100.00', 10, '2024-08-12 16:07:25', '2024-08-12 16:09:21', 42, '2024-08-23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `stars` tinyint UNSIGNED NOT NULL COMMENT 'Rating from 1 to 5',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_buyer_id_foreign` (`buyer_id`),
  KEY `reviews_order_id_foreign` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `buyer_id`, `order_id`, `stars`, `comment`, `created_at`, `updated_at`) VALUES
(4, 4, 25, 5, 'test', '2024-08-11 16:24:31', '2024-08-11 16:24:31'),
(5, 4, 27, 4, 'joqewoiruqew', '2024-08-12 16:09:21', '2024-08-12 16:09:21');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `seller_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_seller_id_foreign` (`seller_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification_paper` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` int NOT NULL DEFAULT '0',
  `verification_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `profile_picture`, `description`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `verified`, `verification_paper`, `balance`, `verification_id`) VALUES
(4, 'yassir', 'YASSIR FRI', 'yassirfri318@gmail.com', 'profile_pictures/BdGWtJabzQEmD8cDUIqTWO7Kwm2SEGm7rj95uIYS.jpg', 'web', NULL, '$2y$10$qO7xRbbeZORdDk8JjG/2T.tG.V8xaXqlp0s9zlDe17QE6cEVVJ986', NULL, '2024-08-09 16:12:17', '2024-08-13 22:25:39', 1, NULL, 1385, NULL),
(5, 'ziad', 'ziad fri', 'ziadfri318@gmail.com', NULL, 'I develop web applications', NULL, '$2y$10$Or3cD6ChoBqerkLhCoMBh.3qOhV5o.5bu8O7OlZq9TgXo3wT9T.Ca', NULL, '2024-08-09 16:13:47', '2024-08-13 22:29:54', 0, NULL, 275, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `verification_requests`
--

DROP TABLE IF EXISTS `verification_requests`;
CREATE TABLE IF NOT EXISTS `verification_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `verification_paper` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verification_requests_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verification_requests`
--

INSERT INTO `verification_requests` (`id`, `user_id`, `verification_paper`, `verification_image`, `status`, `created_at`, `updated_at`) VALUES
(7, 4, 'verification_papers/4/id_paper.jpg', 'verification_papers/4/id_image.jpg', 'approved', '2024-08-11 21:52:43', '2024-08-11 21:53:06'),
(8, 5, 'verification_papers/5/id_paper.jpg', 'verification_papers/5/id_image.jpg', 'approved', '2024-08-12 16:11:33', '2024-08-12 16:14:22'),
(9, 4, 'verification_papers/4/id_paper.jpg', 'verification_papers/4/id_image.jpg', 'rejected', '2024-08-12 17:24:55', '2024-08-12 17:30:11');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

DROP TABLE IF EXISTS `withdrawals`;
CREATE TABLE IF NOT EXISTS `withdrawals` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `withdrawals_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `user_id`, `amount`, `state`, `created_at`, `updated_at`) VALUES
(2, 5, '300.00', 'completed', '2024-08-10 12:28:07', '2024-08-13 22:26:25'),
(3, 5, '100.00', 'denied', '2024-08-10 12:28:56', '2024-08-13 22:25:47'),
(4, 4, '100.00', 'completed', '2024-08-13 10:27:57', '2024-08-13 22:25:39'),
(5, 5, '100.00', 'completed', '2024-08-13 22:29:00', '2024-08-13 22:29:54');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deposits`
--
ALTER TABLE `deposits`
  ADD CONSTRAINT `deposits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offers_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verification_requests`
--
ALTER TABLE `verification_requests`
  ADD CONSTRAINT `verification_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
