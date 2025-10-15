-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20250927.af95a2e028
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 15, 2025 at 02:29 AM
-- Server version: 8.4.3
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gipk_db`
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
-- Table structure for table `kendaraan_models`
--

CREATE TABLE `kendaraan_models` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pelapor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kendaraan` bigint UNSIGNED NOT NULL,
  `no_polisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` enum('Motor','Mobil','Truck') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pemeriksa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oli_mesin` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oli_power_steering` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oli_rem` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_kendaraan` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otomatis_starter` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radiator` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `baterai_aki` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wipers_depan` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wipers_belakang` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban_depan` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban_belakang` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lampu_depan` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lampu_belakang` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lampu_rem` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `klakson` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kebersihan` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kunci_roda` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dongkrak` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kotak_p3k` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segitiga_pengaman` enum('✔','✖') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kendaraan_models`
--

INSERT INTO `kendaraan_models` (`id`, `user_id`, `image`, `nama_pelapor`, `id_kendaraan`, `no_polisi`, `merk`, `tahun`, `jenis`, `tanggal`, `status`, `pemeriksa`, `oli_mesin`, `oli_power_steering`, `oli_rem`, `body_kendaraan`, `otomatis_starter`, `radiator`, `baterai_aki`, `wipers_depan`, `wipers_belakang`, `ban_depan`, `ban_belakang`, `lampu_depan`, `lampu_belakang`, `lampu_rem`, `klakson`, `kebersihan`, `kunci_roda`, `dongkrak`, `kotak_p3k`, `segitiga_pengaman`, `created_at`, `updated_at`) VALUES
(15, 5, '3N30zUhbbXaDp8NSRm1BzriW7FPeVmgx2RMw7Eqy.jpg', 'Albertus Sony', 2, 'DP 0247 TO', 'Mercedes', '2009', 'Truck', '2025-10-07', '✖', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '2025-10-01 18:15:11', '2025-10-02 00:01:56'),
(16, 5, 'FKX8xO4CKPcHlRebqfsfEmKduY3cVLCm7Lvxu1JL.jpg', 'Albertus Sony', 2, 'DP 0247 TO', 'Mercedes', '2009', 'Truck', '2025-10-14', '✔', 'Ariel Stevano', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✖', '✔', '✖', '✔', '✔', '✔', '✔', '✖', '✖', '✔', '✔', '✖', '✔', '2025-10-01 18:15:42', '2025-10-02 00:01:52'),
(17, 5, 'YYlriDH0p5v5fJQ3HAmeWAPFbIre84NTK93vxWxZ.jpg', 'Albertus Sony', 2, 'DP 0247 TO', 'Mercedes', '2009', 'Truck', '2025-10-21', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '2025-10-01 18:16:13', '2025-10-02 00:01:48'),
(18, 6, 'QV760s930fUDM8KM68CntkJJ50LSm1BIbRIJ6wcn.jpg', 'Mikhael Puntito', 3, 'AB 1204 ZP', 'Mazda', '2022', 'Mobil', '2025-10-10', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '2025-10-01 18:17:35', '2025-10-01 18:57:32'),
(19, 6, 'NBEwxwV1D2TEkSNNSIAKVxeBYWhqnTtz2z1O1J7W.jpg', 'Mikhael Puntito', 3, 'AB 1204 ZP', 'Mazda', '2022', 'Mobil', '2025-10-17', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '2025-10-01 18:18:12', '2025-10-01 19:03:30'),
(20, 6, 'Zq1cnOCIzUBwIg7DOkhwnsDYa7AIG0G27GPY5Bsf.jpg', 'Mikhael Puntito', 3, 'AB 1204 ZP', 'Mazda', '2022', 'Mobil', '2025-10-24', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '2025-10-01 18:18:34', '2025-10-01 19:03:35'),
(21, 5, 'SIneVa91i6g1Fbtg3VR6V6qqDViEdeooZwDiNNul.jpg', 'Albertus Sony', 2, 'DP 0247 TO', 'Mercedes', '2009', 'Truck', '2025-09-03', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '2025-10-02 00:24:44', '2025-10-10 01:28:56'),
(22, 5, 'IxEVcOoEMEaTofjbPXCh91WGomC9CdI55fQtUvze.jpg', 'Albertus Sony', 2, 'DP 0247 TO', 'Mercedes', '2009', 'Truck', '2025-09-17', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✖', '✔', '✖', '2025-10-02 00:25:07', '2025-10-02 00:43:55'),
(23, 5, 'unls6LVKVNfcfZkxowWz6w1pMw2aHWisKJ03zX9J.jpg', 'Albertus Sony', 2, 'DP 0247 TO', 'Mercedes', '2009', 'Truck', '2025-06-09', '✔', 'Dwiki Widianto', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '2025-10-02 00:25:32', '2025-10-09 00:04:46'),
(24, 8, 'f4rpzgwuuLF4ytBKJWkLDYeqjrdxMVZclC5Ak2L2.jpg', 'Mateus Situmorang', 2, 'DP 0247 TO', 'Mercedes', '2009', 'Truck', '2025-10-28', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '2025-10-02 00:50:40', '2025-10-02 01:23:48'),
(26, 5, 'OWeeOyQpid5QfyniLP9eT5qlhnxK1aNsAOwdxj7p.jpg', 'Albertus Sony', 9, 'AB 8620 JJ', 'Isuzu', '2025', 'Truck', '2025-10-14', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '2025-10-13 19:33:22', '2025-10-13 19:34:14'),
(27, 5, 'wdClZIaPh5KGpzWB66egrtpIY9QLbJEkoFbzvh9Q.jpg', 'Albertus Sony', 2, 'DP 0247 TO', 'Mercedes', '2009', 'Truck', '2025-10-31', NULL, NULL, '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '2025-10-14 00:01:15', '2025-10-14 00:01:15'),
(28, 5, 'G9Ix97anryvIiSMeJbsfOPnDNTGoJ67TIrg9cPtK.jpg', 'Albertus Sony', 2, 'DP 0247 TO', 'Mercedes', '2009', 'Truck', '2025-10-13', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '2025-10-14 00:42:46', '2025-10-14 00:50:50'),
(29, 13, '3eEqruzHE4tttipUmN5BI8qa0ajVBWwvqzlCxxMA.jpg', 'Josep Daniel', 9, 'AB 8620 JJ', 'Isuzu', '2025', 'Truck', '2025-09-14', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '2025-10-14 00:44:40', '2025-10-14 00:49:00'),
(30, 13, 'cxvH4ZFcAVFjnE2jGJQbV5c7GqAsL0eqB9tLkbU2.jpg', 'Josep Daniel', 9, 'AB 8620 JJ', 'Isuzu', '2025', 'Truck', '2025-09-13', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '2025-10-14 00:45:23', '2025-10-14 00:48:50'),
(31, 13, 'z2ImJ6XbGm8DNo2NL2ENCaudalYN0PpbsVlarSbp.jpg', 'Josep Daniel', 9, 'AB 8620 JJ', 'Isuzu', '2025', 'Truck', '2025-09-16', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '2025-10-14 00:46:23', '2025-10-14 00:48:39'),
(32, 5, 'wxkA1cam99UorpYZDfj1g8v8QMoCEKJIxOFUQ2x5.jpg', 'Albertus Sony', 9, 'AB 8620 JJ', 'Isuzu', '2025', 'Truck', '2025-10-10', '✔', 'Ariel Stevano', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '✖', '✔', '✔', '✔', '✔', '✔', '✔', '✔', '2025-10-14 01:12:48', '2025-10-14 01:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `masterdata_models`
--

CREATE TABLE `masterdata_models` (
  `id` bigint UNSIGNED NOT NULL,
  `no_polisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` enum('Motor','Mobil','Truck') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `masterdata_models`
--

INSERT INTO `masterdata_models` (`id`, `no_polisi`, `merk`, `tahun`, `jenis`, `created_at`, `updated_at`) VALUES
(1, 'AD 1234 CC', 'Isuzu', '2015', 'Truck', '2025-09-30 19:59:45', '2025-09-30 19:59:45'),
(2, 'DP 0247 TO', 'Mercedes', '2009', 'Truck', '2025-09-30 20:00:25', '2025-09-30 20:00:25'),
(3, 'AB 1204 ZP', 'Mazda', '2022', 'Mobil', '2025-09-30 20:00:36', '2025-09-30 20:00:36'),
(4, 'AB 1976 SL', 'Honda', '2017', 'Motor', '2025-09-30 20:00:51', '2025-10-03 00:54:19'),
(7, 'G 0000 KU', 'Suzuki', '2021', 'Mobil', '2025-10-03 01:01:07', '2025-10-10 01:05:18'),
(8, 'F 8429 PUK', 'Hyundai', '2020', 'Mobil', '2025-10-10 01:05:59', '2025-10-10 01:05:59'),
(9, 'AB 8620 JJ', 'Isuzu', '2025', 'Truck', '2025-10-13 19:32:39', '2025-10-13 19:32:39');

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
(7, '0001_01_01_000000_create_users_table', 1),
(8, '0001_01_01_000001_create_cache_table', 1),
(9, '0001_01_01_000002_create_jobs_table', 1),
(10, '2025_09_17_012040_create_penggunas_table', 1),
(11, '2025_09_22_042845_create_kendaraan_models_table', 1),
(12, '2025_09_25_072837_create_masterdata_models_table', 1);

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
-- Table structure for table `pengguna_models`
--

CREATE TABLE `pengguna_models` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna_models`
--

INSERT INTO `pengguna_models` (`id`, `username`, `nama`, `password`, `department`, `role`, `created_at`, `updated_at`) VALUES
(4, 'ariel', 'Ariel Stevano', '$2y$12$ZkeC6eWwO/arn6lytZuqf.xp6DqAERmOkdeTFx5j2nto2PoWZl0nm', 'GA', 1, '2025-09-30 21:27:29', '2025-09-30 21:27:29'),
(5, 'sony', 'Albertus Sony', '$2y$12$btBw74ShQfA1mbaf4IrcWeGLWSiEGFqbjcZyke.aVsqlAO9iPofQK', 'HR', 0, '2025-09-30 21:29:46', '2025-09-30 21:29:46'),
(6, 'tito', 'Mikhael Puntito', '$2y$12$uLA6jbra0QVJWZ1CTzCKF.aIaJ5bt1wLqtjIcNSVhj6mqEaGJdmre', 'Factory', 0, '2025-09-30 21:34:56', '2025-09-30 21:34:56'),
(7, 'dwiki', 'Dwiki Widianto', '$2y$12$1pCmzR8jVoxfwqvV6BFdbeD4/bHlNEIr96q2vYaO7PFr1TxU9t7MG', 'MIS', 2, '2025-10-01 00:11:40', '2025-10-01 00:11:40'),
(8, 'uus', 'Mateus Situmorang', '$2y$12$YylsKIJN.hAo9nTuiEyIoOu6rRKn8S1.Thu2f2e2H9nKYBAY.pFqe', 'QC', 0, '2025-10-02 00:49:46', '2025-10-02 00:49:46'),
(9, 'awe', 'Valeriandy', '$2y$12$aVer0.ZLr0GQrKrj3IncGu0oLgWqqlex/u5BwFLZhyRbWqcegpEja', 'Production', 0, '2025-10-02 01:56:56', '2025-10-02 01:56:56'),
(13, 'ocep', 'Josep Daniel', '$2y$12$vjKgcmDJQSuHab9QBFgbHOh4SieOBgMCWdwMAX/mxr.bIcMLZNGb2', 'PPIC', 0, '2025-10-09 20:42:33', '2025-10-09 20:42:33');

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
('ZEzz71hkL0u0oAF00KPWj4I7kqYUMtJne1qcnvLi', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NjoiaHR0cDovL3RlbXBsYXRlLWxhcmF2ZWwxMi1tYWluLnRlc3QvbWFzdGVyZGF0YSI7fXM6NjoiX3Rva2VuIjtzOjQwOiJTSER6dkxPT1pIb3pVRzFlYXc2MFpyRUNyYm92SzI0SmRSdWZvOWdJIjtzOjQ6InVzZXIiO2E6NTp7czoyOiJpZCI7aTo3O3M6ODoidXNlcm5hbWUiO3M6NToiZHdpa2kiO3M6NDoibmFtYSI7czoxNDoiRHdpa2kgV2lkaWFudG8iO3M6MTE6ImRlcGFydGVtZW50IjtzOjM6Ik1JUyI7czo0OiJyb2xlIjtpOjI7fX0=', 1760492224);

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
-- Indexes for table `kendaraan_models`
--
ALTER TABLE `kendaraan_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kendaraan` (`id_kendaraan`);

--
-- Indexes for table `masterdata_models`
--
ALTER TABLE `masterdata_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengguna_models`
--
ALTER TABLE `pengguna_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengguna_models_username_unique` (`username`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `kendaraan_models`
--
ALTER TABLE `kendaraan_models`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `masterdata_models`
--
ALTER TABLE `masterdata_models`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pengguna_models`
--
ALTER TABLE `pengguna_models`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kendaraan_models`
--
ALTER TABLE `kendaraan_models`
  ADD CONSTRAINT `fk_kendaraan` FOREIGN KEY (`id_kendaraan`) REFERENCES `masterdata_models` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
