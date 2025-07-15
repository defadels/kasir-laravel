-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 05, 2025 at 12:54 PM
-- Server version: 8.3.0
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir-laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:29:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:15:\"view-categories\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:17:\"create-categories\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:15:\"edit-categories\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:17:\"delete-categories\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:13:\"view-products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:15:\"create-products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:13:\"edit-products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:15:\"delete-products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:12:\"manage-stock\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:17:\"view-transactions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:19:\"create-transactions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"edit-transactions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:19:\"delete-transactions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:21:\"view-all-transactions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:10:\"view-users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:12:\"create-users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:10:\"edit-users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:12:\"delete-users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:12:\"view-reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:18:\"view-daily-reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:19:\"view-weekly-reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:20:\"view-monthly-reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:14:\"view-dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:10:\"access-pos\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:13:\"process-sales\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:17:\"view-stock-alerts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:16:\"manage-inventory\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:14:\"print-receipts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:19:\"export-transactions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"owner\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"kasir\";s:1:\"c\";s:3:\"web\";}}}', 1751780011);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'ATK (Alat Tulis Kantor)', 'atk-alat-tulis-kantor', 'Pensil, bulpen, map, amplop, penggaris, penghapus, dan perlengkapan tulis lainnya', NULL, 1, '2025-07-03 21:16:07', '2025-07-03 21:16:07'),
(2, 'Print & Fotocopy', 'print-fotocopy', 'Layanan print dan fotocopy dengan variasi harga berwarna dan hitam putih', NULL, 1, '2025-07-03 21:16:07', '2025-07-03 21:16:07'),
(3, 'Sparepart HP - Kualitas KW', 'sparepart-hp-kualitas-kw', 'Suku cadang handphone kualitas KW (replika) dengan harga terjangkau', NULL, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(4, 'Sparepart HP - Original Merk', 'sparepart-hp-original-merk', 'Suku cadang handphone original dari pabrikan dengan kualitas terbaik', NULL, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(5, 'Sparepart HP - Original After Market', 'sparepart-hp-original-after-market', 'Suku cadang handphone original after market dengan kualitas standar tinggi', NULL, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_04_032347_create_permission_tables', 1),
(5, '2025_07_04_040037_create_categories_table', 1),
(6, '2025_07_04_040050_create_products_table', 1),
(7, '2025_07_04_040053_create_transactions_table', 1),
(8, '2025_07_04_040102_create_transaction_details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view-categories', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(2, 'create-categories', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(3, 'edit-categories', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(4, 'delete-categories', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(5, 'view-products', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(6, 'create-products', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(7, 'edit-products', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(8, 'delete-products', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(9, 'manage-stock', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(10, 'view-transactions', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(11, 'create-transactions', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(12, 'edit-transactions', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(13, 'delete-transactions', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(14, 'view-all-transactions', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(15, 'view-users', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(16, 'create-users', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(17, 'edit-users', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(18, 'delete-users', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(19, 'view-reports', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(20, 'view-daily-reports', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(21, 'view-weekly-reports', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(22, 'view-monthly-reports', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(23, 'view-dashboard', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(24, 'access-pos', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(25, 'process-sales', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(26, 'view-stock-alerts', 'web', '2025-07-03 21:16:05', '2025-07-03 21:16:05'),
(27, 'manage-inventory', 'web', '2025-07-03 21:16:06', '2025-07-03 21:16:06'),
(28, 'print-receipts', 'web', '2025-07-03 21:49:43', '2025-07-03 21:49:43'),
(29, 'export-transactions', 'web', '2025-07-03 21:49:43', '2025-07-03 21:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint UNSIGNED NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `cost_price` decimal(15,2) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `min_stock` int NOT NULL DEFAULT '0',
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pcs',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `track_stock` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `description`, `category_id`, `price`, `cost_price`, `stock`, `min_stock`, `unit`, `image`, `is_active`, `track_stock`, `created_at`, `updated_at`) VALUES
(1, 'Pensil 2B', 'ATK001', 'Pensil 2B kualitas standar untuk menulis dan menggambar', 1, '2000.00', '1200.00', 500, 50, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(2, 'Bulpen Biru Standar', 'ATK002', 'Pulpen tinta biru standar untuk keperluan sehari-hari', 1, '3000.00', '1800.00', 300, 30, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(3, 'Map Plastik A4', 'ATK003', 'Map plastik ukuran A4 untuk menyimpan dokumen', 1, '5000.00', '3000.00', 199, 20, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-04 22:01:06'),
(4, 'Amplop Putih Kecil', 'ATK004', 'Amplop putih ukuran kecil untuk surat', 1, '1500.00', '800.00', 1000, 100, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(5, 'Penggaris Plastik 30cm', 'ATK005', 'Penggaris plastik transparant 30cm', 1, '4000.00', '2500.00', 150, 15, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(6, 'Penghapus Putih', 'ATK006', 'Penghapus putih standar untuk pensil', 1, '2500.00', '1500.00', 199, 25, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-04 22:01:06'),
(7, 'Print Berwarna', 'PRT001', 'Layanan print dokumen berwarna per lembar', 2, '1000.00', '600.00', 0, 0, 'lembar', NULL, 1, 0, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(8, 'Print Hitam Putih', 'PRT002', 'Layanan print dokumen hitam putih per lembar', 2, '500.00', '300.00', 0, 0, 'lembar', NULL, 1, 0, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(9, 'Fotocopy Berwarna', 'FCY001', 'Layanan fotocopy dokumen berwarna per lembar', 2, '800.00', '400.00', 0, 0, 'lembar', NULL, 1, 0, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(10, 'Fotocopy Hitam Putih', 'FCY002', 'Layanan fotocopy dokumen hitam putih per lembar', 2, '200.00', '100.00', 0, 0, 'lembar', NULL, 1, 0, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(11, 'LCD iPhone 12 KW', 'KW001', 'LCD iPhone 12 kualitas KW (replika)', 3, '250000.00', '150000.00', 20, 3, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(12, 'Baterai Samsung A52 KW', 'KW002', 'Baterai Samsung Galaxy A52 kualitas KW', 3, '80000.00', '50000.00', 15, 2, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(13, 'Kamera Belakang Xiaomi Redmi Note 10 KW', 'KW003', 'Kamera belakang Xiaomi Redmi Note 10 kualitas KW', 3, '120000.00', '75000.00', 10, 2, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(14, 'LCD iPhone 12 Original', 'ORI001', 'LCD iPhone 12 original dari pabrikan Apple', 4, '1200000.00', '900000.00', 5, 1, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(15, 'Baterai Samsung A52 Original', 'ORI002', 'Baterai Samsung Galaxy A52 original dari Samsung', 4, '350000.00', '250000.00', 8, 1, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(16, 'Housing iPhone 13 Original', 'ORI003', 'Housing/casing iPhone 13 original Apple', 4, '800000.00', '600000.00', 3, 1, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(17, 'LCD iPhone 12 After Market', 'AFT001', 'LCD iPhone 12 original after market berkualitas tinggi', 5, '600000.00', '400000.00', 12, 2, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(18, 'Baterai Samsung A52 After Market', 'AFT002', 'Baterai Samsung Galaxy A52 after market kualitas tinggi', 5, '180000.00', '120000.00', 18, 3, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(19, 'Kamera Belakang Xiaomi Redmi Note 10 After Market', 'AFT003', 'Kamera belakang Xiaomi Redmi Note 10 after market', 5, '300000.00', '200000.00', 8, 2, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08'),
(20, 'Housing Samsung A52 After Market', 'AFT004', 'Housing/casing Samsung Galaxy A52 after market', 5, '200000.00', '130000.00', 15, 2, 'pcs', NULL, 1, 1, '2025-07-03 21:16:08', '2025-07-03 21:16:08');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'owner', 'web', '2025-07-03 21:16:06', '2025-07-03 21:16:06'),
(2, 'kasir', 'web', '2025-07-03 21:16:06', '2025-07-03 21:16:06');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(1, 2),
(5, 2),
(10, 2),
(11, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(28, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('YYUowXY4O7mZlre0BDG7u2cCZ4cpflUTf6t0q6py', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoib3NuUEltTFRNeE5LZ2Y1Qml1THA5NEdjZE9KdldkR1ZzT2lmUXhBOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9hcGkvZGFzaGJvYXJkL2RhdGEiO31zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1751694024);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `transaction_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `tax_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(15,2) NOT NULL,
  `paid_amount` decimal(15,2) NOT NULL,
  `change_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `payment_method` enum('cash','card','qris','transfer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `status` enum('pending','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `transaction_date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_code`, `user_id`, `customer_name`, `customer_phone`, `subtotal`, `tax_amount`, `discount_amount`, `total_amount`, `paid_amount`, `change_amount`, `payment_method`, `status`, `notes`, `transaction_date`, `created_at`, `updated_at`) VALUES
(1, 'TR202507050001', 2, 'Muhammad Fadhil Adha', '082273318016', '9300.00', '0.00', '0.00', '9300.00', '15000.00', '5700.00', 'cash', 'completed', 'Ambil hari ini.', '2025-07-04 22:01:06', '2025-07-04 22:01:06', '2025-07-04 22:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` bigint UNSIGNED NOT NULL,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `quantity` int NOT NULL,
  `discount_per_item` decimal(15,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `product_name`, `product_sku`, `unit_price`, `quantity`, `discount_per_item`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'Penghapus Putih', 'ATK006', '2500.00', 1, '0.00', '2500.00', '2025-07-04 22:01:06', '2025-07-04 22:01:06'),
(2, 1, 8, 'Print Hitam Putih', 'PRT002', '500.00', 2, '0.00', '1000.00', '2025-07-04 22:01:06', '2025-07-04 22:01:06'),
(3, 1, 9, 'Fotocopy Berwarna', 'FCY001', '800.00', 1, '0.00', '800.00', '2025-07-04 22:01:06', '2025-07-04 22:01:06'),
(4, 1, 3, 'Map Plastik A4', 'ATK003', '5000.00', 1, '0.00', '5000.00', '2025-07-04 22:01:06', '2025-07-04 22:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Owner Toko', 'owner@kasir.com', '2025-07-03 21:16:07', '$2y$12$PCuMHEu7EMH6XiMk.qvdaeWt.eeGGvvTJU1w8jun.FSwHxZ3nKw5q', NULL, '2025-07-03 21:16:07', '2025-07-03 21:16:07'),
(2, 'Kasir', 'kasir@kasir.com', '2025-07-03 21:16:07', '$2y$12$qnYmObt.wyd3SRBHtBISqObEaZF5f7OoDC3s9b9hSpBByc46TJ3Ly', NULL, '2025-07-03 21:16:07', '2025-07-03 21:16:07'),
(3, 'Test User', 'test@example.com', '2025-07-03 21:16:08', '$2y$12$oavfLWD2304UnEXTdrlE8.FIE0Lh2lCrHJ/lI6quPwXa6Gnxq.pDy', '1JRjkzUzkL', '2025-07-03 21:16:09', '2025-07-03 21:16:09');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
  ADD UNIQUE KEY `transactions_transaction_code_unique` (`transaction_code`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_details_product_id_foreign` (`product_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
