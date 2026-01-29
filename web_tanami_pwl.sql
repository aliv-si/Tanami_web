-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2026 at 02:15 PM
-- Server version: 8.0.44-0ubuntu0.22.04.2
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_tanami_pwl`
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
-- Table structure for table `escrow`
--

CREATE TABLE `escrow` (
  `id_escrow` bigint UNSIGNED NOT NULL,
  `id_pesanan` bigint UNSIGNED NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `status_escrow` enum('ditahan','dikirim_ke_petani','direfund_ke_pembeli') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ditahan',
  `tgl_ditahan` timestamp NULL DEFAULT NULL,
  `tgl_kirim` timestamp NULL DEFAULT NULL,
  `id_penerima` bigint UNSIGNED DEFAULT NULL COMMENT 'ID petani atau pembeli penerima dana',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `escrow`
--

INSERT INTO `escrow` (`id_escrow`, `id_pesanan`, `jumlah`, `status_escrow`, `tgl_ditahan`, `tgl_kirim`, `id_penerima`, `catatan`, `tgl_dibuat`) VALUES
(1, 6, '59000.00', 'ditahan', '2026-01-29 07:13:56', NULL, NULL, NULL, '2026-01-29 14:13:56'),
(2, 7, '22500.00', 'ditahan', '2026-01-29 07:13:56', NULL, NULL, NULL, '2026-01-29 14:13:56'),
(3, 15, '115000.00', 'ditahan', '2026-01-29 07:13:57', NULL, NULL, NULL, '2026-01-29 14:13:57'),
(4, 16, '108000.00', 'ditahan', '2026-01-29 07:13:57', NULL, NULL, NULL, '2026-01-29 14:13:57'),
(5, 17, '108000.00', 'ditahan', '2026-01-29 07:13:57', NULL, NULL, NULL, '2026-01-29 14:13:57'),
(6, 18, '32000.00', 'ditahan', '2026-01-29 07:13:57', NULL, NULL, NULL, '2026-01-29 14:13:57'),
(7, 19, '30000.00', 'direfund_ke_pembeli', '2026-01-29 07:13:57', '2026-01-21 07:13:57', 12, 'Refund approved - produk rusak', '2026-01-29 14:13:57'),
(8, 23, '618000.00', 'dikirim_ke_petani', '2025-12-30 09:13:57', '2026-01-03 07:13:57', 2, NULL, '2026-01-29 14:13:57'),
(9, 24, '122000.00', 'dikirim_ke_petani', '2026-01-02 09:13:57', '2026-01-09 07:13:57', 2, NULL, '2026-01-29 14:13:57'),
(10, 25, '49000.00', 'dikirim_ke_petani', '2026-01-05 09:13:57', '2026-01-10 07:13:57', 3, NULL, '2026-01-29 14:13:57'),
(11, 26, '41000.00', 'dikirim_ke_petani', '2026-01-08 09:13:57', '2026-01-12 07:13:57', 3, NULL, '2026-01-29 14:13:57'),
(12, 27, '71000.00', 'dikirim_ke_petani', '2026-01-11 09:13:57', '2026-01-15 07:13:57', 3, NULL, '2026-01-29 14:13:57'),
(13, 28, '30000.00', 'dikirim_ke_petani', '2026-01-14 09:13:58', '2026-01-18 07:13:58', 2, NULL, '2026-01-29 14:13:58'),
(14, 29, '153000.00', 'dikirim_ke_petani', '2026-01-17 09:13:58', '2026-01-24 07:13:58', 3, NULL, '2026-01-29 14:13:58'),
(15, 30, '95000.00', 'dikirim_ke_petani', '2026-01-20 09:13:58', '2026-01-25 07:13:58', 2, NULL, '2026-01-29 14:13:58'),
(16, 31, '39500.00', 'dikirim_ke_petani', '2026-01-23 09:13:58', '2026-01-30 07:13:58', 2, NULL, '2026-01-29 14:13:58'),
(17, 32, '115000.00', 'dikirim_ke_petani', '2026-01-26 09:13:58', '2026-01-29 07:13:58', 2, NULL, '2026-01-29 14:13:58');

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
-- Table structure for table `histori_status`
--

CREATE TABLE `histori_status` (
  `id_histori` bigint UNSIGNED NOT NULL,
  `id_pesanan` bigint UNSIGNED NOT NULL,
  `status_lama` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_baru` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pengubah` bigint UNSIGNED DEFAULT NULL COMMENT 'ID user yang ubah status',
  `alasan` text COLLATE utf8mb4_unicode_ci,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `histori_status`
--

INSERT INTO `histori_status` (`id_histori`, `id_pesanan`, `status_lama`, `status_baru`, `id_pengubah`, `alasan`, `tgl_dibuat`) VALUES
(1, 8, NULL, 'selesai', 16, NULL, '2026-01-29 07:13:57'),
(2, 9, NULL, 'selesai', 15, NULL, '2026-01-29 07:13:57'),
(3, 10, NULL, 'selesai', 12, NULL, '2026-01-29 07:13:57'),
(4, 11, NULL, 'selesai', 17, NULL, '2026-01-29 07:13:57'),
(5, 12, NULL, 'selesai', 11, NULL, '2026-01-29 07:13:57'),
(6, 20, 'pending', 'dibatalkan', 10, NULL, '2026-01-29 07:13:57'),
(7, 22, 'menunggu_verifikasi', 'dibatalkan', 2, 'Bukti tidak valid', '2026-01-29 07:13:57'),
(8, 1, NULL, 'pending', 15, NULL, '2026-01-29 07:13:56'),
(9, 2, NULL, 'pending', 11, NULL, '2026-01-29 07:13:56'),
(10, 3, NULL, 'pending', 12, NULL, '2026-01-29 07:13:56'),
(11, 4, NULL, 'pending', 16, NULL, '2026-01-29 07:13:56'),
(12, 4, 'pending', 'menunggu_verifikasi', 16, NULL, '2026-01-29 10:13:56'),
(13, 5, NULL, 'pending', 11, NULL, '2026-01-29 07:13:56'),
(14, 5, 'pending', 'menunggu_verifikasi', 11, NULL, '2026-01-29 10:13:56'),
(15, 6, NULL, 'pending', 17, NULL, '2026-01-29 07:13:56'),
(16, 6, 'pending', 'menunggu_verifikasi', 17, NULL, '2026-01-29 17:13:56'),
(17, 6, 'menunggu_verifikasi', 'dibayar', 3, NULL, '2026-01-29 11:13:56'),
(18, 6, 'dibayar', 'diproses', 3, NULL, '2026-01-29 19:13:56'),
(19, 6, 'diproses', 'dikirim', 3, NULL, '2026-01-30 03:13:56'),
(20, 6, 'dikirim', 'terkirim', 3, NULL, '2026-01-31 14:13:56'),
(21, 7, NULL, 'pending', 12, NULL, '2026-01-29 07:13:56'),
(22, 7, 'pending', 'menunggu_verifikasi', 12, NULL, '2026-01-29 13:13:56'),
(23, 7, 'menunggu_verifikasi', 'dibayar', 2, NULL, '2026-01-29 23:13:56'),
(24, 7, 'dibayar', 'diproses', 2, NULL, '2026-01-29 19:13:56'),
(25, 7, 'diproses', 'dikirim', 2, NULL, '2026-01-30 19:13:56'),
(26, 7, 'dikirim', 'terkirim', 2, NULL, '2026-01-30 03:13:56'),
(27, 13, NULL, 'pending', 19, NULL, '2026-01-29 07:13:57'),
(28, 13, 'pending', 'menunggu_verifikasi', 19, NULL, '2026-01-29 15:13:57'),
(29, 14, NULL, 'pending', 10, NULL, '2026-01-29 07:13:57'),
(30, 14, 'pending', 'menunggu_verifikasi', 10, NULL, '2026-01-29 11:13:57'),
(31, 15, NULL, 'pending', 16, NULL, '2026-01-29 07:13:57'),
(32, 15, 'pending', 'menunggu_verifikasi', 16, NULL, '2026-01-29 16:13:57'),
(33, 15, 'menunggu_verifikasi', 'dibayar', 3, NULL, '2026-01-30 01:13:57'),
(34, 16, NULL, 'pending', 13, NULL, '2026-01-29 07:13:57'),
(35, 16, 'pending', 'menunggu_verifikasi', 13, NULL, '2026-01-29 13:13:57'),
(36, 16, 'menunggu_verifikasi', 'dibayar', 3, NULL, '2026-01-29 23:13:57'),
(37, 16, 'dibayar', 'diproses', 3, NULL, '2026-01-30 01:13:57'),
(38, 17, NULL, 'pending', 11, NULL, '2026-01-29 07:13:57'),
(39, 17, 'pending', 'menunggu_verifikasi', 11, NULL, '2026-01-29 19:13:57'),
(40, 17, 'menunggu_verifikasi', 'dibayar', 3, NULL, '2026-01-29 15:13:57'),
(41, 17, 'dibayar', 'diproses', 3, NULL, '2026-01-30 16:13:57'),
(42, 17, 'diproses', 'dikirim', 3, NULL, '2026-01-30 15:13:57'),
(43, 18, NULL, 'pending', 16, NULL, '2026-01-29 07:13:57'),
(44, 18, 'pending', 'menunggu_verifikasi', 16, NULL, '2026-01-29 09:13:57'),
(45, 18, 'menunggu_verifikasi', 'dibayar', 2, NULL, '2026-01-29 13:13:57'),
(46, 18, 'dibayar', 'diproses', 2, NULL, '2026-01-29 19:13:57'),
(47, 18, 'diproses', 'dikirim', 2, NULL, '2026-01-29 19:13:57'),
(48, 18, 'dikirim', 'terkirim', 2, NULL, '2026-01-30 23:13:57'),
(49, 18, 'terkirim', 'minta_refund', 16, NULL, '2026-01-30 13:13:57'),
(50, 19, NULL, 'pending', 12, NULL, '2026-01-29 07:13:57'),
(51, 19, 'pending', 'menunggu_verifikasi', 12, NULL, '2026-01-29 10:13:57'),
(52, 19, 'menunggu_verifikasi', 'dibayar', 2, NULL, '2026-01-29 21:13:57'),
(53, 19, 'dibayar', 'diproses', 2, NULL, '2026-01-30 13:13:57'),
(54, 19, 'diproses', 'dikirim', 2, NULL, '2026-01-30 11:13:57'),
(55, 19, 'dikirim', 'terkirim', 2, NULL, '2026-01-30 08:13:57'),
(56, 19, 'terkirim', 'minta_refund', 12, NULL, '2026-01-30 13:13:57'),
(57, 19, 'minta_refund', 'direfund', 1, 'Refund disetujui admin', '2026-02-01 05:13:57'),
(58, 21, NULL, 'pending', 15, NULL, '2026-01-29 07:13:57'),
(59, 21, 'pending', 'dibatalkan', NULL, 'Pesanan dibatalkan', '2026-01-29 10:13:57'),
(60, 23, NULL, 'pending', 15, NULL, '2025-12-30 07:13:57'),
(61, 23, 'pending', 'menunggu_verifikasi', 15, NULL, '2025-12-30 10:13:57'),
(62, 23, 'menunggu_verifikasi', 'dibayar', 2, NULL, '2025-12-30 13:13:57'),
(63, 23, 'dibayar', 'diproses', 2, NULL, '2025-12-31 01:13:57'),
(64, 23, 'diproses', 'dikirim', 2, NULL, '2025-12-30 19:13:57'),
(65, 23, 'dikirim', 'terkirim', 2, NULL, '2026-01-01 19:13:57'),
(66, 23, 'terkirim', 'selesai', 15, 'Konfirmasi penerimaan barang', '2025-12-31 19:13:57'),
(67, 24, NULL, 'pending', 14, NULL, '2026-01-02 07:13:57'),
(68, 24, 'pending', 'menunggu_verifikasi', 14, NULL, '2026-01-02 12:13:57'),
(69, 24, 'menunggu_verifikasi', 'dibayar', 2, NULL, '2026-01-03 05:13:57'),
(70, 24, 'dibayar', 'diproses', 2, NULL, '2026-01-02 16:13:57'),
(71, 24, 'diproses', 'dikirim', 2, NULL, '2026-01-03 03:13:57'),
(72, 24, 'dikirim', 'terkirim', 2, NULL, '2026-01-03 18:13:57'),
(73, 24, 'terkirim', 'selesai', 14, 'Konfirmasi penerimaan barang', '2026-01-03 19:13:57'),
(74, 25, NULL, 'pending', 13, NULL, '2026-01-05 07:13:57'),
(75, 25, 'pending', 'menunggu_verifikasi', 13, NULL, '2026-01-05 19:13:57'),
(76, 25, 'menunggu_verifikasi', 'dibayar', 3, NULL, '2026-01-06 05:13:57'),
(77, 25, 'dibayar', 'diproses', 3, NULL, '2026-01-06 10:13:57'),
(78, 25, 'diproses', 'dikirim', 3, NULL, '2026-01-07 07:13:57'),
(79, 25, 'dikirim', 'terkirim', 3, NULL, '2026-01-06 03:13:57'),
(80, 25, 'terkirim', 'selesai', 13, 'Konfirmasi penerimaan barang', '2026-01-08 07:13:57'),
(81, 26, NULL, 'pending', 13, NULL, '2026-01-08 07:13:57'),
(82, 26, 'pending', 'menunggu_verifikasi', 13, NULL, '2026-01-08 12:13:57'),
(83, 26, 'menunggu_verifikasi', 'dibayar', 3, NULL, '2026-01-08 21:13:57'),
(84, 26, 'dibayar', 'diproses', 3, NULL, '2026-01-09 13:13:57'),
(85, 26, 'diproses', 'dikirim', 3, NULL, '2026-01-08 23:13:57'),
(86, 26, 'dikirim', 'terkirim', 3, NULL, '2026-01-09 18:13:57'),
(87, 26, 'terkirim', 'selesai', 13, 'Konfirmasi penerimaan barang', '2026-01-11 07:13:57'),
(88, 27, NULL, 'pending', 12, NULL, '2026-01-11 07:13:57'),
(89, 27, 'pending', 'menunggu_verifikasi', 12, NULL, '2026-01-11 11:13:57'),
(90, 27, 'menunggu_verifikasi', 'dibayar', 3, NULL, '2026-01-11 23:13:57'),
(91, 27, 'dibayar', 'diproses', 3, NULL, '2026-01-11 16:13:57'),
(92, 27, 'diproses', 'dikirim', 3, NULL, '2026-01-13 03:13:57'),
(93, 27, 'dikirim', 'terkirim', 3, NULL, '2026-01-12 08:13:57'),
(94, 27, 'terkirim', 'selesai', 12, 'Konfirmasi penerimaan barang', '2026-01-12 19:13:57'),
(95, 28, NULL, 'pending', 16, NULL, '2026-01-14 07:13:58'),
(96, 28, 'pending', 'menunggu_verifikasi', 16, NULL, '2026-01-14 09:13:58'),
(97, 28, 'menunggu_verifikasi', 'dibayar', 2, NULL, '2026-01-14 17:13:58'),
(98, 28, 'dibayar', 'diproses', 2, NULL, '2026-01-14 22:13:58'),
(99, 28, 'diproses', 'dikirim', 2, NULL, '2026-01-14 15:13:58'),
(100, 28, 'dikirim', 'terkirim', 2, NULL, '2026-01-16 09:13:58'),
(101, 28, 'terkirim', 'selesai', 16, 'Konfirmasi penerimaan barang', '2026-01-16 07:13:58'),
(102, 29, NULL, 'pending', 12, NULL, '2026-01-17 07:13:58'),
(103, 29, 'pending', 'menunggu_verifikasi', 12, NULL, '2026-01-17 18:13:58'),
(104, 29, 'menunggu_verifikasi', 'dibayar', 3, NULL, '2026-01-17 19:13:58'),
(105, 29, 'dibayar', 'diproses', 3, NULL, '2026-01-17 22:13:58'),
(106, 29, 'diproses', 'dikirim', 3, NULL, '2026-01-19 07:13:58'),
(107, 29, 'dikirim', 'terkirim', 3, NULL, '2026-01-18 03:13:58'),
(108, 29, 'terkirim', 'selesai', 12, 'Konfirmasi penerimaan barang', '2026-01-19 07:13:58'),
(109, 30, NULL, 'pending', 15, NULL, '2026-01-20 07:13:58'),
(110, 30, 'pending', 'menunggu_verifikasi', 15, NULL, '2026-01-20 11:13:58'),
(111, 30, 'menunggu_verifikasi', 'dibayar', 2, NULL, '2026-01-21 07:13:58'),
(112, 30, 'dibayar', 'diproses', 2, NULL, '2026-01-21 04:13:58'),
(113, 30, 'diproses', 'dikirim', 2, NULL, '2026-01-21 11:13:58'),
(114, 30, 'dikirim', 'terkirim', 2, NULL, '2026-01-22 14:13:58'),
(115, 30, 'terkirim', 'selesai', 15, 'Konfirmasi penerimaan barang', '2026-01-23 01:13:58'),
(116, 31, NULL, 'pending', 10, NULL, '2026-01-23 07:13:58'),
(117, 31, 'pending', 'menunggu_verifikasi', 10, NULL, '2026-01-23 19:13:58'),
(118, 31, 'menunggu_verifikasi', 'dibayar', 2, NULL, '2026-01-23 13:13:58'),
(119, 31, 'dibayar', 'diproses', 2, NULL, '2026-01-24 10:13:58'),
(120, 31, 'diproses', 'dikirim', 2, NULL, '2026-01-24 07:13:58'),
(121, 31, 'dikirim', 'terkirim', 2, NULL, '2026-01-25 04:13:58'),
(122, 31, 'terkirim', 'selesai', 10, 'Konfirmasi penerimaan barang', '2026-01-25 13:13:58'),
(123, 32, NULL, 'pending', 19, NULL, '2026-01-26 07:13:58'),
(124, 32, 'pending', 'menunggu_verifikasi', 19, NULL, '2026-01-26 16:13:58'),
(125, 32, 'menunggu_verifikasi', 'dibayar', 2, NULL, '2026-01-26 19:13:58'),
(126, 32, 'dibayar', 'diproses', 2, NULL, '2026-01-27 07:13:58'),
(127, 32, 'diproses', 'dikirim', 2, NULL, '2026-01-26 23:13:58'),
(128, 32, 'dikirim', 'terkirim', 2, NULL, '2026-01-27 08:13:58'),
(129, 32, 'terkirim', 'selesai', 19, 'Konfirmasi penerimaan barang', '2026-01-28 13:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `item_pesanan`
--

CREATE TABLE `item_pesanan` (
  `id_item` bigint UNSIGNED NOT NULL,
  `id_pesanan` bigint UNSIGNED NOT NULL,
  `id_produk` bigint UNSIGNED NOT NULL,
  `id_petani` bigint UNSIGNED NOT NULL COMMENT 'Denormalized untuk laporan',
  `jumlah` int NOT NULL,
  `harga_snapshot` decimal(10,2) NOT NULL COMMENT 'Harga saat checkout',
  `subtotal` decimal(10,2) NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_pesanan`
--

INSERT INTO `item_pesanan` (`id_item`, `id_pesanan`, `id_produk`, `id_petani`, `jumlah`, `harga_snapshot`, `subtotal`, `tgl_dibuat`) VALUES
(1, 1, 19, 2, 2, '7500.00', '15000.00', '2026-01-29 14:13:56'),
(2, 2, 26, 2, 2, '35000.00', '70000.00', '2026-01-29 14:13:56'),
(3, 3, 16, 2, 2, '150000.00', '300000.00', '2026-01-29 14:13:56'),
(4, 4, 6, 3, 1, '12000.00', '12000.00', '2026-01-29 14:13:56'),
(5, 5, 10, 2, 1, '18000.00', '18000.00', '2026-01-29 14:13:56'),
(6, 6, 9, 3, 2, '22000.00', '44000.00', '2026-01-29 14:13:56'),
(7, 7, 19, 2, 1, '7500.00', '7500.00', '2026-01-29 14:13:56'),
(8, 8, 25, 3, 1, '32000.00', '32000.00', '2026-01-29 14:13:56'),
(9, 9, 8, 3, 2, '28000.00', '56000.00', '2026-01-29 14:13:57'),
(10, 10, 19, 2, 2, '7500.00', '15000.00', '2026-01-29 14:13:57'),
(11, 11, 3, 2, 1, '10000.00', '10000.00', '2026-01-29 14:13:57'),
(12, 12, 12, 2, 1, '25000.00', '25000.00', '2026-01-29 14:13:57'),
(13, 13, 5, 3, 4, '45000.00', '180000.00', '2026-01-29 14:13:57'),
(14, 14, 5, 3, 3, '45000.00', '135000.00', '2026-01-29 14:13:57'),
(15, 15, 5, 3, 2, '45000.00', '90000.00', '2026-01-29 14:13:57'),
(16, 16, 5, 3, 2, '45000.00', '90000.00', '2026-01-29 14:13:57'),
(17, 17, 5, 3, 2, '45000.00', '90000.00', '2026-01-29 14:13:57'),
(18, 18, 19, 2, 2, '7500.00', '15000.00', '2026-01-29 14:13:57'),
(19, 19, 3, 2, 1, '10000.00', '10000.00', '2026-01-29 14:13:57'),
(20, 20, 26, 2, 1, '35000.00', '35000.00', '2026-01-29 14:13:57'),
(21, 21, 5, 3, 2, '45000.00', '90000.00', '2026-01-29 14:13:57'),
(22, 22, 7, 2, 1, '35000.00', '35000.00', '2026-01-29 14:13:57'),
(23, 23, 16, 2, 4, '150000.00', '600000.00', '2026-01-29 14:13:57'),
(24, 24, 26, 2, 3, '35000.00', '105000.00', '2026-01-29 14:13:57'),
(25, 25, 23, 3, 4, '8000.00', '32000.00', '2026-01-29 14:13:57'),
(26, 26, 20, 3, 4, '6000.00', '24000.00', '2026-01-29 14:13:57'),
(27, 27, 8, 3, 2, '28000.00', '56000.00', '2026-01-29 14:13:57'),
(28, 28, 18, 2, 3, '5000.00', '15000.00', '2026-01-29 14:13:58'),
(29, 29, 25, 3, 4, '32000.00', '128000.00', '2026-01-29 14:13:58'),
(30, 30, 1, 2, 5, '15000.00', '75000.00', '2026-01-29 14:13:58'),
(31, 31, 19, 2, 3, '7500.00', '22500.00', '2026-01-29 14:13:58'),
(32, 32, 4, 2, 4, '25000.00', '100000.00', '2026-01-29 14:13:58');

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
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `slug_kategori`, `deskripsi`, `tgl_dibuat`) VALUES
(1, 'Sayuran', 'sayuran', 'Berbagai jenis sayuran segar', '2026-01-29 07:13:55'),
(2, 'Buah', 'buah', 'Buah-buahan segar berkualitas', '2026-01-29 07:13:55'),
(3, 'Tanaman Hias', 'tanaman-hias', 'Tanaman hias untuk dekorasi', '2026-01-29 07:13:55'),
(4, 'Bibit', 'bibit', 'Bibit tanaman berkualitas', '2026-01-29 07:13:55');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` bigint UNSIGNED NOT NULL,
  `id_pengguna` bigint UNSIGNED NOT NULL,
  `id_produk` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_pengguna`, `id_produk`, `jumlah`, `tgl_dibuat`, `tgl_update`) VALUES
(1, 10, 9, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(2, 10, 14, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(3, 10, 25, 2, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(4, 10, 26, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(5, 11, 10, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(6, 11, 23, 2, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(7, 11, 25, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(8, 12, 7, 2, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(9, 12, 9, 3, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(10, 12, 18, 2, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(11, 13, 8, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(12, 13, 9, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(13, 13, 15, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(14, 13, 26, 3, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(15, 14, 3, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(16, 14, 9, 2, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(17, 14, 25, 3, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(18, 15, 4, 2, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(19, 15, 9, 2, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(20, 16, 6, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(21, 16, 25, 3, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(22, 17, 5, 2, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(23, 17, 26, 3, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(24, 18, 14, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(25, 18, 18, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(26, 18, 26, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(27, 19, 8, 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(28, 19, 10, 2, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(29, 19, 14, 3, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(30, 19, 15, 2, '2026-01-29 07:13:56', '2026-01-29 07:13:56');

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id_kota` bigint UNSIGNED NOT NULL,
  `nama_kota` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinsi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ongkir` decimal(10,2) NOT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id_kota`, `nama_kota`, `provinsi`, `ongkir`, `is_aktif`, `tgl_dibuat`) VALUES
(1, 'Jakarta', 'DKI Jakarta', '20000.00', 1, '2026-01-29 07:13:55'),
(2, 'Bogor', 'Jawa Barat', '15000.00', 1, '2026-01-29 07:13:55'),
(3, 'Bandung', 'Jawa Barat', '25000.00', 1, '2026-01-29 07:13:55'),
(4, 'Tangerang', 'Banten', '18000.00', 1, '2026-01-29 07:13:55'),
(5, 'Bekasi', 'Jawa Barat', '17000.00', 1, '2026-01-29 07:13:55');

-- --------------------------------------------------------

--
-- Table structure for table `kupon`
--

CREATE TABLE `kupon` (
  `id_kupon` bigint UNSIGNED NOT NULL,
  `kode_kupon` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_diskon` enum('nominal','persen') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal_diskon` decimal(10,2) DEFAULT NULL,
  `persen_diskon` decimal(5,2) DEFAULT NULL,
  `min_belanja` decimal(10,2) NOT NULL DEFAULT '0.00',
  `limit_total` int DEFAULT NULL,
  `limit_per_user` int NOT NULL DEFAULT '1',
  `tgl_mulai` timestamp NOT NULL,
  `tgl_selesai` timestamp NOT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kupon`
--

INSERT INTO `kupon` (`id_kupon`, `kode_kupon`, `tipe_diskon`, `nominal_diskon`, `persen_diskon`, `min_belanja`, `limit_total`, `limit_per_user`, `tgl_mulai`, `tgl_selesai`, `is_aktif`, `tgl_dibuat`) VALUES
(1, 'PROMO10', 'nominal', '10000.00', NULL, '50000.00', NULL, 1, '2025-11-28 17:00:00', '2026-01-29 16:59:59', 1, '2026-01-29 07:13:56'),
(2, 'DISKON20', 'persen', NULL, '20.00', '100000.00', NULL, 2, '2025-12-13 17:00:00', '2026-01-14 16:59:59', 1, '2026-01-29 07:13:56'),
(3, 'NEWUSER', 'nominal', '15000.00', NULL, '30000.00', NULL, 1, '2025-12-21 17:00:00', '2026-02-28 16:59:59', 1, '2026-01-29 07:13:56');

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
(1, '0001_01_01_000000_create_pengguna_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_08_000001_create_kategori_table', 1),
(5, '2026_01_08_000002_create_kota_table', 1),
(6, '2026_01_08_000003_create_kupon_table', 1),
(7, '2026_01_08_000004_create_produk_table', 1),
(8, '2026_01_08_000005_create_keranjang_table', 1),
(9, '2026_01_08_000006_create_rekening_petani_table', 1),
(10, '2026_01_08_000007_create_pesanan_table', 1),
(11, '2026_01_08_000008_create_item_pesanan_table', 1),
(12, '2026_01_08_000009_create_escrow_table', 1),
(13, '2026_01_08_000010_create_histori_status_table', 1),
(14, '2026_01_08_000011_create_pemakaian_kupon_table', 1),
(15, '2026_01_08_000012_create_ulasan_table', 1),
(16, '2026_01_12_000001_add_alasan_refund_to_pesanan_table', 1),
(17, '2026_01_13_090047_add_foto_to_pengguna_table', 1),
(18, '2026_01_25_174215_create_pesan_kontak_table', 1);

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
-- Table structure for table `pemakaian_kupon`
--

CREATE TABLE `pemakaian_kupon` (
  `id_pemakaian` bigint UNSIGNED NOT NULL,
  `id_kupon` bigint UNSIGNED NOT NULL,
  `id_pengguna` bigint UNSIGNED NOT NULL,
  `id_pesanan` bigint UNSIGNED NOT NULL,
  `diskon_dipakai` decimal(10,2) NOT NULL,
  `tgl_pakai` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemakaian_kupon`
--

INSERT INTO `pemakaian_kupon` (`id_pemakaian`, `id_kupon`, `id_pengguna`, `id_pesanan`, `diskon_dipakai`, `tgl_pakai`) VALUES
(1, 3, 15, 9, '15000.00', '2026-01-29 14:13:59');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Hash bcrypt',
  `role_pengguna` enum('admin','petani','pembeli') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_daftar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `email`, `password`, `role_pengguna`, `alamat`, `no_hp`, `foto`, `is_verified`, `email_verified_at`, `remember_token`, `tgl_daftar`, `tgl_update`) VALUES
(1, 'Admin System', 'admin@tanami.com', '$2y$12$2yb8g5cHjqE1Tn.2tLSPh.wWWmQ6jj0HyF7jwAVE5zPG.cNF3UVqK', 'admin', 'Kantor Pusat Tanami', '081234567890', NULL, 1, NULL, NULL, '2025-07-29 07:13:51', '2026-01-29 07:13:51'),
(2, 'Admin Support', 'support@tanami.com', '$2y$12$A1vjb3zZejNxbq2rrgd8Ke2f.K..vd2v0fRg4gTQ0af8N4EiEuHZi', 'admin', 'Kantor Cabang Jakarta', '081234567891', NULL, 1, NULL, NULL, '2025-10-29 07:13:51', '2026-01-29 07:13:51'),
(3, 'Pak Tono', 'tono@petani.com', '$2y$12$7xwzvrK0iGfo5EC3abcDxONRTZBUIb.iQYlF1T4lxNVIeZFCgMYFu', 'petani', 'Bogor, Jawa Barat', '081402292487', NULL, 1, NULL, NULL, '2025-10-31 07:13:52', '2026-01-29 07:13:52'),
(4, 'Bu Siti', 'siti@petani.com', '$2y$12$wdxR1LtR07NxIrzZ2/jfA.ti0O2B2NbY/1/UatLr.i9XBu4dvrKqq', 'petani', 'Bandung, Jawa Barat', '084193173217', NULL, 1, NULL, NULL, '2025-11-30 07:13:52', '2026-01-29 07:13:52'),
(5, 'Pak Ahmad', 'ahmad@petani.com', '$2y$12$QMzolCRGYB3VfZdTWfU4He04pO2SUuGSSxau3liqwqTd/qBCgiF.q', 'petani', 'Malang, Jawa Timur', '082606944229', NULL, 1, NULL, NULL, '2025-12-15 07:13:52', '2026-01-29 07:13:52'),
(6, 'Bu Dewi', 'dewi@petani.com', '$2y$12$2onu0ey4g/TNMXVnBFLCgeRVuBf5qeQ/8X3zIA7if4f.1KIYx1fUy', 'petani', 'Yogyakarta', '083377693814', NULL, 1, NULL, NULL, '2025-12-30 07:13:52', '2026-01-29 07:13:52'),
(7, 'Pak Joko', 'joko@petani.com', '$2y$12$TiDOOl.g4sQxbJxdCbWz5uIcQRa9FKZxprkqTWzxVPpsUFWAMnbFO', 'petani', 'Solo, Jawa Tengah', '085920649875', NULL, 1, NULL, NULL, '2026-01-09 07:13:53', '2026-01-29 07:13:53'),
(8, 'Bu Ratna', 'ratna@petani.com', '$2y$12$tea498UpR/b8KURf.7mOIOGJRUXKvBuKSs5noaD/.sB6.bVoMw1uq', 'petani', 'Surabaya, Jawa Timur', '085373937223', NULL, 0, NULL, NULL, '2026-01-19 07:13:53', '2026-01-29 07:13:53'),
(9, 'Pak Udin', 'udin@petani.com', '$2y$12$VpD8mQAiB9EVJoeIx/z7/epw5OY8kGIFFER1ESlBOc105A7mDPGr2', 'petani', 'Semarang, Jawa Tengah', '081938769487', NULL, 0, NULL, NULL, '2026-01-24 07:13:53', '2026-01-29 07:13:53'),
(10, 'Budi Santoso', 'budi@pembeli.com', '$2y$12$7r3Jk11XHy4u11MGf4yKgOgqi78eLco2j4QGd3YpT9hMHl.XJ/rs.', 'pembeli', 'Jakarta Selatan', '087312498109', NULL, 1, NULL, NULL, '2025-10-21 07:13:53', '2026-01-29 07:13:53'),
(11, 'Ani Wijaya', 'ani@pembeli.com', '$2y$12$zrEmJZkvgDR9uBHrQi./JOrPHxHBYA2L7Q3PGxN/1mpCt2sixDsEm', 'pembeli', 'Tangerang', '086977884496', NULL, 1, NULL, NULL, '2025-11-10 07:13:54', '2026-01-29 07:13:54'),
(12, 'Dedi Kurniawan', 'dedi@pembeli.com', '$2y$12$tVOTs4cX3F2IAZbGZSUY.u/.mkqIO3sGNV1z24n9mYYDPdIrs/V4K', 'pembeli', 'Bekasi', '085404802159', NULL, 1, NULL, NULL, '2025-11-30 07:13:54', '2026-01-29 07:13:54'),
(13, 'Citra Lestari', 'citra@pembeli.com', '$2y$12$sMBSOYaGz2r.GMrG.tEOy.DmS7PgD1ZY7Ka8JcefNThOXDynPU7hm', 'pembeli', 'Depok', '086967964907', NULL, 1, NULL, NULL, '2025-12-15 07:13:54', '2026-01-29 07:13:54'),
(14, 'Eko Prasetyo', 'eko@pembeli.com', '$2y$12$r/IB.GzMw86tqjlpsWTbZeTNtgVHlWpSBoAi/m6e1/tE/SXyjS8gC', 'pembeli', 'Bogor', '088509778701', NULL, 1, NULL, NULL, '2025-12-30 07:13:54', '2026-01-29 07:13:54'),
(15, 'Fitri Handayani', 'fitri@pembeli.com', '$2y$12$4W6V0QSkv9xPSdK0J2WJOeFduIRIe1sI5U/j/UHyIwD7f86BxUCfy', 'pembeli', 'Jakarta Timur', '084905708227', NULL, 1, NULL, NULL, '2026-01-04 07:13:54', '2026-01-29 07:13:54'),
(16, 'Gilang Ramadhan', 'gilang@pembeli.com', '$2y$12$TzTDScrYSToWe0oHBuv0ZuSe6jP0rrr7U6uxWnn5GxnX/INeHSOW.', 'pembeli', 'Jakarta Barat', '084378985353', NULL, 1, NULL, NULL, '2026-01-09 07:13:55', '2026-01-29 07:13:55'),
(17, 'Hana Putri', 'hana@pembeli.com', '$2y$12$9nlGnkYJNwYZjdiTZCChQuV3ajfnnR2dff3Avdt427irNqNylaL5W', 'pembeli', 'Bandung', '086700022045', NULL, 1, NULL, NULL, '2026-01-14 07:13:55', '2026-01-29 07:13:55'),
(18, 'Indra Wijaya', 'indra@pembeli.com', '$2y$12$TO2Q7bUwzbpNMc2vDswY/OlWAVxfJWNGY1JEiynp3n.9Kw/cpB.ue', 'pembeli', 'Surabaya', '082211603918', NULL, 1, NULL, NULL, '2026-01-19 07:13:55', '2026-01-29 07:13:55'),
(19, 'Jihan Amalia', 'jihan@pembeli.com', '$2y$12$wk2qERw5awQNxItnAM39LeXZhjOjuQcGNlOdWV9/LgccD4iVxZDVi', 'pembeli', 'Yogyakarta', '081691658334', NULL, 0, NULL, NULL, '2026-01-24 07:13:55', '2026-01-29 07:13:55');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` bigint UNSIGNED NOT NULL,
  `id_pembeli` bigint UNSIGNED NOT NULL,
  `id_kota_tujuan` bigint UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `ongkir` decimal(10,2) NOT NULL,
  `diskon` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_bayar` decimal(10,2) NOT NULL,
  `status_pesanan` enum('pending','menunggu_verifikasi','dibayar','diproses','dikirim','terkirim','selesai','dibatalkan','minta_refund','direfund') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_verifikasi` timestamp NULL DEFAULT NULL,
  `id_verifikator` bigint UNSIGNED DEFAULT NULL COMMENT 'ID petani/admin yang verifikasi',
  `alasan_tolak` text COLLATE utf8mb4_unicode_ci,
  `no_resi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batas_bayar` timestamp NULL DEFAULT NULL COMMENT '24 jam dari checkout',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_selesai` timestamp NULL DEFAULT NULL COMMENT 'Waktu pembeli konfirmasi selesai',
  `id_konfirmasi` bigint UNSIGNED DEFAULT NULL COMMENT 'ID pembeli yang konfirmasi',
  `tgl_selesai_otomatis` timestamp NULL DEFAULT NULL COMMENT 'Auto-complete setelah 3 hari',
  `alasan_batal` text COLLATE utf8mb4_unicode_ci,
  `alasan_refund` text COLLATE utf8mb4_unicode_ci COMMENT 'Alasan permintaan refund dari pembeli',
  `tgl_dibatalkan` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_pembeli`, `id_kota_tujuan`, `subtotal`, `ongkir`, `diskon`, `total_bayar`, `status_pesanan`, `bukti_bayar`, `tgl_verifikasi`, `id_verifikator`, `alasan_tolak`, `no_resi`, `batas_bayar`, `catatan`, `tgl_dibuat`, `tgl_update`, `tgl_selesai`, `id_konfirmasi`, `tgl_selesai_otomatis`, `alasan_batal`, `alasan_refund`, `tgl_dibatalkan`) VALUES
(1, 15, 2, '15000.00', '15000.00', '0.00', '30000.00', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-01-30 07:13:56', NULL, '2026-01-29 07:13:56', '2026-01-29 07:13:56', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 11, 5, '70000.00', '17000.00', '0.00', '87000.00', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-01-30 07:13:56', NULL, '2026-01-29 07:13:56', '2026-01-29 07:13:56', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 12, 2, '300000.00', '15000.00', '0.00', '315000.00', 'pending', NULL, NULL, NULL, NULL, NULL, '2026-01-30 07:13:56', NULL, '2026-01-29 07:13:56', '2026-01-29 07:13:56', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 16, 2, '12000.00', '15000.00', '0.00', '27000.00', 'menunggu_verifikasi', 'bukti-bayar/sample_4.jpg', NULL, NULL, NULL, NULL, '2026-01-30 07:13:56', NULL, '2026-01-29 07:13:56', '2026-01-29 07:13:56', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 11, 3, '18000.00', '25000.00', '0.00', '43000.00', 'menunggu_verifikasi', 'bukti-bayar/sample_5.jpg', NULL, NULL, NULL, NULL, '2026-01-30 07:13:56', NULL, '2026-01-29 07:13:56', '2026-01-29 07:13:56', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 17, 2, '44000.00', '15000.00', '0.00', '59000.00', 'terkirim', 'bukti-bayar/sample_6.jpg', '2026-01-24 07:13:56', 3, NULL, 'JNE9416795687', '2026-01-30 07:13:56', NULL, '2026-01-29 07:13:56', '2026-01-29 07:13:56', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 12, 2, '7500.00', '15000.00', '0.00', '22500.00', 'terkirim', 'bukti-bayar/sample_7.jpg', '2026-01-25 07:13:56', 2, NULL, 'JNE5197280799', '2026-01-30 07:13:56', NULL, '2026-01-29 07:13:56', '2026-01-29 07:13:56', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 16, 5, '32000.00', '17000.00', '0.00', '49000.00', 'selesai', 'bukti-bayar/sample_8.jpg', '2026-01-14 07:13:57', 3, NULL, 'SICEPAT5325906435', '2026-01-30 07:13:56', NULL, '2026-01-29 07:13:56', '2026-01-29 07:13:57', '2026-01-18 07:13:57', 16, NULL, NULL, NULL, NULL),
(9, 15, 3, '56000.00', '25000.00', '15000.00', '66000.00', 'selesai', 'bukti-bayar/sample_9.jpg', '2026-01-15 07:13:57', 3, NULL, 'SICEPAT4232202955', '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:59', '2026-01-15 07:13:57', 15, NULL, NULL, NULL, NULL),
(10, 12, 2, '15000.00', '15000.00', '0.00', '30000.00', 'selesai', 'bukti-bayar/sample_10.jpg', '2026-01-14 07:13:57', 2, NULL, 'SICEPAT6588119854', '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', '2026-01-24 07:13:57', 12, NULL, NULL, NULL, NULL),
(11, 17, 3, '10000.00', '25000.00', '0.00', '35000.00', 'selesai', 'bukti-bayar/sample_11.jpg', '2026-01-16 07:13:57', 2, NULL, 'SICEPAT6897967021', '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', '2026-01-14 07:13:57', 17, NULL, NULL, NULL, NULL),
(12, 11, 5, '25000.00', '17000.00', '0.00', '42000.00', 'selesai', 'bukti-bayar/sample_12.jpg', '2026-01-12 07:13:57', 2, NULL, 'SICEPAT8348773639', '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', '2026-01-17 07:13:57', 11, NULL, NULL, NULL, NULL),
(13, 19, 4, '180000.00', '18000.00', '0.00', '198000.00', 'menunggu_verifikasi', 'bukti-bayar/petani_sample_13.jpg', NULL, NULL, NULL, NULL, '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 10, 4, '135000.00', '18000.00', '0.00', '153000.00', 'menunggu_verifikasi', 'bukti-bayar/petani_sample_14.jpg', NULL, NULL, NULL, NULL, '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 16, 3, '90000.00', '25000.00', '0.00', '115000.00', 'dibayar', 'bukti-bayar/petani_verified_15.jpg', '2026-01-28 22:13:57', 3, NULL, NULL, '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 13, 4, '90000.00', '18000.00', '0.00', '108000.00', 'diproses', 'bukti-bayar/petani_proses_16.jpg', '2026-01-28 07:13:57', 3, NULL, NULL, '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 11, 4, '90000.00', '18000.00', '0.00', '108000.00', 'dikirim', 'bukti-bayar/petani_kirim_17.jpg', '2026-01-27 07:13:57', 3, NULL, 'JNT2389502365', '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 16, 5, '15000.00', '17000.00', '0.00', '32000.00', 'minta_refund', 'bukti-bayar/refund_request.jpg', '2026-01-24 07:13:57', 2, NULL, 'ANTERAJA1766712376', '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', NULL, NULL, NULL, NULL, 'Produk tidak sesuai dengan deskripsi', NULL),
(19, 12, 1, '10000.00', '20000.00', '0.00', '30000.00', 'direfund', 'bukti-bayar/refunded.jpg', '2026-01-19 07:13:57', 2, NULL, NULL, '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', NULL, NULL, NULL, NULL, 'Produk rusak saat pengiriman', NULL),
(20, 10, 3, '35000.00', '25000.00', '0.00', '60000.00', 'dibatalkan', NULL, NULL, NULL, NULL, NULL, '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', NULL, NULL, NULL, 'Pembeli membatalkan pesanan', NULL, '2026-01-26 07:13:57'),
(21, 15, 2, '90000.00', '15000.00', '0.00', '105000.00', 'dibatalkan', NULL, NULL, NULL, NULL, NULL, '2026-01-23 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', NULL, NULL, NULL, 'Batas waktu pembayaran habis', NULL, '2026-01-24 07:13:57'),
(22, 10, 5, '35000.00', '17000.00', '0.00', '52000.00', 'dibatalkan', 'bukti-bayar/rejected.jpg', NULL, NULL, 'Bukti pembayaran tidak valid/blur', NULL, '2026-01-30 07:13:57', NULL, '2026-01-29 07:13:57', '2026-01-29 07:13:57', NULL, NULL, NULL, 'Verifikasi pembayaran ditolak', NULL, '2026-01-25 07:13:57'),
(23, 15, 4, '600000.00', '18000.00', '0.00', '618000.00', 'selesai', 'bukti-bayar/historical_23.jpg', '2025-12-30 19:13:57', 2, NULL, 'HIST1209071079', '2026-01-30 07:13:57', NULL, '2025-12-30 07:13:57', '2026-01-29 07:13:57', '2026-01-03 07:13:57', 15, NULL, NULL, NULL, NULL),
(24, 14, 5, '105000.00', '17000.00', '0.00', '122000.00', 'selesai', 'bukti-bayar/historical_24.jpg', '2026-01-02 14:13:57', 2, NULL, 'HIST4596678009', '2026-01-30 07:13:57', NULL, '2026-01-02 07:13:57', '2026-01-29 07:13:57', '2026-01-09 07:13:57', 14, NULL, NULL, NULL, NULL),
(25, 13, 5, '32000.00', '17000.00', '0.00', '49000.00', 'selesai', 'bukti-bayar/historical_25.jpg', '2026-01-05 17:13:57', 3, NULL, 'HIST6422934045', '2026-01-30 07:13:57', NULL, '2026-01-05 07:13:57', '2026-01-29 07:13:57', '2026-01-10 07:13:57', 13, NULL, NULL, NULL, NULL),
(26, 13, 5, '24000.00', '17000.00', '0.00', '41000.00', 'selesai', 'bukti-bayar/historical_26.jpg', '2026-01-08 15:13:57', 3, NULL, 'HIST6518713427', '2026-01-30 07:13:57', NULL, '2026-01-08 07:13:57', '2026-01-29 07:13:57', '2026-01-12 07:13:57', 13, NULL, NULL, NULL, NULL),
(27, 12, 2, '56000.00', '15000.00', '0.00', '71000.00', 'selesai', 'bukti-bayar/historical_27.jpg', '2026-01-11 19:13:57', 3, NULL, 'HIST9764779001', '2026-01-30 07:13:57', NULL, '2026-01-11 07:13:57', '2026-01-29 07:13:57', '2026-01-15 07:13:57', 12, NULL, NULL, NULL, NULL),
(28, 16, 2, '15000.00', '15000.00', '0.00', '30000.00', 'selesai', 'bukti-bayar/historical_28.jpg', '2026-01-14 13:13:58', 2, NULL, 'HIST2719763556', '2026-01-30 07:13:57', NULL, '2026-01-14 07:13:58', '2026-01-29 07:13:58', '2026-01-18 07:13:58', 16, NULL, NULL, NULL, NULL),
(29, 12, 3, '128000.00', '25000.00', '0.00', '153000.00', 'selesai', 'bukti-bayar/historical_29.jpg', '2026-01-17 12:13:58', 3, NULL, 'HIST4921548039', '2026-01-30 07:13:58', NULL, '2026-01-17 07:13:58', '2026-01-29 07:13:58', '2026-01-24 07:13:58', 12, NULL, NULL, NULL, NULL),
(30, 15, 1, '75000.00', '20000.00', '0.00', '95000.00', 'selesai', 'bukti-bayar/historical_30.jpg', '2026-01-20 15:13:58', 2, NULL, 'HIST5761241031', '2026-01-30 07:13:58', NULL, '2026-01-20 07:13:58', '2026-01-29 07:13:58', '2026-01-25 07:13:58', 15, NULL, NULL, NULL, NULL),
(31, 10, 5, '22500.00', '17000.00', '0.00', '39500.00', 'selesai', 'bukti-bayar/historical_31.jpg', '2026-01-23 17:13:58', 2, NULL, 'HIST2099810972', '2026-01-30 07:13:58', NULL, '2026-01-23 07:13:58', '2026-01-29 07:13:58', '2026-01-30 07:13:58', 10, NULL, NULL, NULL, NULL),
(32, 19, 2, '100000.00', '15000.00', '0.00', '115000.00', 'selesai', 'bukti-bayar/historical_32.jpg', '2026-01-26 11:13:58', 2, NULL, 'HIST7781898449', '2026-01-30 07:13:58', NULL, '2026-01-26 07:13:58', '2026-01-29 07:13:58', '2026-01-29 07:13:58', 19, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pesan_kontak`
--

CREATE TABLE `pesan_kontak` (
  `id_pesan` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subjek` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` bigint UNSIGNED NOT NULL,
  `id_petani` bigint UNSIGNED NOT NULL,
  `id_kategori` bigint UNSIGNED NOT NULL,
  `nama_produk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_produk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `stok_direserve` int NOT NULL DEFAULT '0',
  `satuan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'kg, pcs, ikat, dll',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_petani`, `id_kategori`, `nama_produk`, `slug_produk`, `harga`, `stok`, `stok_direserve`, `satuan`, `deskripsi`, `foto`, `is_aktif`, `tgl_dibuat`, `tgl_update`) VALUES
(1, 2, 1, 'Wortel Organik Premium', 'wortel-organik-premium', '15000.00', 100, 5, 'kg', 'Wortel organik segar dari dataran tinggi Bogor. Dipanen langsung dari kebun tanpa pestisida. Kaya vitamin A dan serat, cocok untuk jus, salad, atau masakan sehari-hari.', 'produk/wortel_organik.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(2, 2, 1, 'Bayam Hijau Segar', 'bayam-hijau-segar', '8000.00', 50, 0, 'ikat', 'Bayam hijau organik, dipetik pagi hari untuk menjaga kesegaran. Kaya zat besi dan vitamin K. Ideal untuk tumis, sup, atau salad.', 'produk/bayam_hijau.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(3, 2, 1, 'Kangkung Hidroponik', 'kangkung-hidroponik', '10000.00', 80, 3, 'ikat', 'Kangkung hidroponik berkualitas tinggi. Lebih bersih dan bebas hama. Batang renyah dan daun segar.', 'produk/kangkung_hidroponik.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(4, 2, 1, 'Brokoli Organik', 'brokoli-organik', '25000.00', 30, 2, 'kg', 'Brokoli organik segar dari dataran tinggi. Kaya antioksidan dan vitamin C. Cocok untuk tumis, sup, atau dikukus.', 'produk/brokoli_organik.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(5, 3, 1, 'Cabai Merah Keriting', 'cabai-merah-keriting', '45000.00', 25, 0, 'kg', 'Cabai merah keriting segar dengan tingkat kepedasan sedang. Cocok untuk sambal dan masakan pedas.', 'produk/cabai_merah.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(6, 3, 1, 'Selada Romaine', 'selada-romaine', '12000.00', 40, 0, 'pcs', 'Selada romaine hidroponik, renyah dan segar. Perfect untuk salad Caesar atau sandwich.', 'produk/selada_romaine.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(7, 2, 2, 'Tomat Cherry Merah', 'tomat-cherry-merah', '35000.00', 45, 5, 'kg', 'Tomat cherry merah manis, cocok untuk salad atau snack sehat. Kaya lycopene dan vitamin C.', 'produk/tomat_cherry.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(8, 3, 2, 'Apel Malang Premium', 'apel-malang-premium', '28000.00', 60, 10, 'kg', 'Apel Malang asli, manis dan renyah. Dipetik langsung dari kebun di lereng Gunung Bromo.', 'produk/apel_malang.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(9, 3, 2, 'Jeruk Pontianak', 'jeruk-pontianak', '22000.00', 75, 0, 'kg', 'Jeruk Pontianak manis tanpa biji. Kaya vitamin C, cocok untuk jus atau dimakan langsung.', 'produk/jeruk_pontianak.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(10, 2, 2, 'Pepaya California', 'pepaya-california', '18000.00', 35, 0, 'kg', 'Pepaya California orange, manis dan lembut. Cocok untuk dessert atau jus.', 'produk/pepaya_california.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(11, 3, 2, 'Pisang Cavendish', 'pisang-cavendish', '20000.00', 50, 8, 'sisir', 'Pisang Cavendish grade A, manis dan tidak cepat busuk. Ideal untuk snack sehat atau smoothie.', 'produk/pisang_cavendish.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(12, 2, 2, 'Semangka Merah', 'semangka-merah', '25000.00', 20, 0, 'buah', 'Semangka merah tanpa biji, manis dan segar. Berat rata-rata 3-4 kg per buah.', 'produk/semangka_merah.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(13, 3, 3, 'Monstera Deliciosa', 'monstera-deliciosa', '175000.00', 15, 2, 'pot', 'Monstera Deliciosa dengan daun berlubang cantik. Tinggi 40-50cm dengan pot diameter 20cm. Indoor plant favorit!', 'produk/monstera_deliciosa.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(14, 3, 3, 'Calathea Makoyana', 'calathea-makoyana', '85000.00', 20, 0, 'pot', 'Calathea Makoyana dengan motif daun unik seperti lukisan. Prayer plant yang bergerak mengikuti cahaya.', 'produk/calathea_makoyana.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(15, 2, 3, 'Philodendron Birkin', 'philodendron-birkin', '125000.00', 12, 1, 'pot', 'Philodendron Birkin dengan garis-garis putih elegan pada daun hijau. Tanaman hias premium.', 'produk/philodendron_birkin.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(16, 2, 3, 'Alocasia Black Velvet', 'alocasia-black-velvet', '150000.00', 8, 0, 'pot', 'Alocasia Black Velvet dengan daun hitam beludru dan urat putih. Tanaman eksotis collector item.', 'produk/alocasia_black_velvet.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(17, 3, 3, 'Sansevieria Moonshine', 'sansevieria-moonshine', '65000.00', 25, 3, 'pot', 'Sansevieria Moonshine dengan daun silver-green. Low maintenance, cocok untuk pemula.', 'produk/sansevieria_moonshine.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(18, 2, 4, 'Bibit Cabai Rawit', 'bibit-cabai-rawit', '5000.00', 200, 15, 'pack', 'Bibit cabai rawit unggul, 1 pack berisi 20 biji. Tingkat perkecambahan 85%. Siap tanam dalam polybag.', 'produk/bibit_cabai_rawit.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(19, 2, 4, 'Bibit Tomat Cherry', 'bibit-tomat-cherry', '7500.00', 150, 0, 'pack', 'Bibit tomat cherry premium, 1 pack berisi 15 biji. Varietas produktif dengan buah manis.', 'produk/bibit_tomat_cherry.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(20, 3, 4, 'Bibit Terong Ungu', 'bibit-terong-ungu', '6000.00', 120, 5, 'pack', 'Bibit terong ungu lokal, 1 pack berisi 25 biji. Hasil panen melimpah dan tahan hama.', 'produk/bibit_terong_ungu.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(21, 3, 4, 'Bibit Bayam Hijau', 'bibit-bayam-hijau', '3500.00', 250, 10, 'pack', 'Bibit bayam hijau organik, 1 pack berisi 50 biji. Cepat tumbuh, panen dalam 25-30 hari.', 'produk/bibit_bayam_hijau.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(22, 2, 4, 'Bibit Kangkung', 'bibit-kangkung', '3000.00', 300, 0, 'pack', 'Bibit kangkung darat premium, 1 pack berisi 50 biji. Mudah ditanam di pot atau lahan terbuka.', 'produk/bibit_kangkung.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(23, 3, 4, 'Bibit Selada Keriting', 'bibit-selada-keriting', '8000.00', 100, 0, 'pack', 'Bibit selada keriting hidroponik, 1 pack berisi 30 biji. Cocok untuk sistem NFT atau DFT.', 'produk/bibit_selada_keriting.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(24, 2, 1, 'Sawi Hijau Organik', 'sawi-hijau-organik', '9000.00', 0, 0, 'ikat', 'Sawi hijau organik segar, cocok untuk tumis atau sup.', 'produk/sawi_hijau.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(25, 3, 2, 'Mangga Harum Manis', 'mangga-harum-manis', '32000.00', 40, 5, 'kg', 'Mangga Harum Manis matang pohon, aroma harum dan rasa manis sempurna.', 'produk/mangga_harum_manis.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(26, 2, 3, 'Pothos Golden', 'pothos-golden', '35000.00', 30, 0, 'pot', 'Pothos Golden dengan variegasi kuning. Tanaman gantung yang mudah dirawat.', 'produk/pothos_golden.png', 1, '2026-01-29 07:13:56', '2026-01-29 07:13:56'),
(27, 3, 1, 'Timun Jepang', 'timun-jepang', '15000.00', 55, 0, 'kg', 'Timun Jepang segar dan renyah, cocok untuk lalapan atau asinan.', 'produk/timun_jepang.png', 0, '2026-01-29 07:13:56', '2026-01-29 07:13:56');

-- --------------------------------------------------------

--
-- Table structure for table `rekening_petani`
--

CREATE TABLE `rekening_petani` (
  `id_rekening` bigint UNSIGNED NOT NULL,
  `id_petani` bigint UNSIGNED NOT NULL,
  `nama_bank` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rekening` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atas_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_utama` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rekening_petani`
--

INSERT INTO `rekening_petani` (`id_rekening`, `id_petani`, `nama_bank`, `no_rekening`, `atas_nama`, `is_utama`, `tgl_dibuat`) VALUES
(1, 2, 'BCA', '1234567890', 'TONO SUSILO', 1, '2026-01-29 07:13:56'),
(2, 3, 'Mandiri', '0987654321', 'SITI AMINAH', 1, '2026-01-29 07:13:56');

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

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` bigint UNSIGNED NOT NULL,
  `id_item_pesanan` bigint UNSIGNED NOT NULL,
  `id_pengguna` bigint UNSIGNED NOT NULL,
  `id_produk` bigint UNSIGNED NOT NULL COMMENT 'Denormalized',
  `rating` int UNSIGNED NOT NULL,
  `komentar` text COLLATE utf8mb4_unicode_ci,
  `tgl_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_item_pesanan`, `id_pengguna`, `id_produk`, `rating`, `komentar`, `tgl_dibuat`) VALUES
(1, 8, 16, 25, 2, 'Kurang puas, beberapa sayuran sudah layu saat diterima.', '2026-01-20 06:13:57'),
(2, 9, 15, 8, 2, 'Kurang puas, beberapa sayuran sudah layu saat diterima.', '2026-01-16 19:13:57'),
(3, 10, 12, 19, 5, 'Produk sangat segar dan berkualitas! Pengiriman juga cepat. Recommended!', '2026-01-26 13:13:57'),
(4, 11, 17, 3, 4, 'Pengalaman belanja menyenangkan, produk sesuai ekspektasi.', '2026-01-14 20:13:57'),
(5, 12, 11, 12, 3, 'Produk cukup baik, tapi ada beberapa yang kurang segar.', '2026-01-17 12:13:57'),
(6, 23, 15, 16, 5, 'Mantap! Wortelnya manis dan renyah. Pasti order lagi.', '2026-01-04 16:13:57'),
(7, 24, 14, 26, 5, 'Mantap! Wortelnya manis dan renyah. Pasti order lagi.', '2026-01-10 00:13:57'),
(8, 25, 13, 23, 4, 'Kualitas oke, harga bersaing. Next time order lebih banyak.', '2026-01-12 03:13:57'),
(9, 26, 13, 20, 4, 'Sayuran segar, cuma packagingnya bisa lebih ditingkatkan.', '2026-01-14 20:13:57'),
(10, 27, 12, 8, 5, 'Kualitas premium, packaging rapi. Worth every penny!', '2026-01-15 19:13:57'),
(11, 28, 16, 18, 5, 'Mantap! Wortelnya manis dan renyah. Pasti order lagi.', '2026-01-21 05:13:58'),
(12, 29, 12, 25, 5, 'Sudah langganan dari dulu, tidak pernah mengecewakan. Terima kasih!', '2026-01-26 15:13:58'),
(13, 30, 15, 1, 5, 'Kualitas premium, packaging rapi. Worth every penny!', '2026-01-26 23:13:58'),
(14, 31, 10, 19, 5, 'Mantap! Wortelnya manis dan renyah. Pasti order lagi.', '2026-02-01 19:13:58'),
(15, 32, 19, 4, 4, 'Kualitas oke, harga bersaing. Next time order lebih banyak.', '2026-01-31 00:13:58');

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
-- Indexes for table `escrow`
--
ALTER TABLE `escrow`
  ADD PRIMARY KEY (`id_escrow`),
  ADD UNIQUE KEY `escrow_id_pesanan_unique` (`id_pesanan`),
  ADD KEY `escrow_id_penerima_foreign` (`id_penerima`),
  ADD KEY `idx_pesanan_escrow` (`id_pesanan`),
  ADD KEY `idx_status_escrow` (`status_escrow`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `histori_status`
--
ALTER TABLE `histori_status`
  ADD PRIMARY KEY (`id_histori`),
  ADD KEY `histori_status_id_pengubah_foreign` (`id_pengubah`),
  ADD KEY `idx_pesanan_histori` (`id_pesanan`),
  ADD KEY `idx_status_perubahan` (`status_baru`,`tgl_dibuat`);

--
-- Indexes for table `item_pesanan`
--
ALTER TABLE `item_pesanan`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `item_pesanan_id_produk_foreign` (`id_produk`),
  ADD KEY `idx_pesanan` (`id_pesanan`),
  ADD KEY `idx_petani` (`id_petani`);

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
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `kategori_slug_kategori_unique` (`slug_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD UNIQUE KEY `unik_keranjang` (`id_pengguna`,`id_produk`),
  ADD KEY `keranjang_id_produk_foreign` (`id_produk`),
  ADD KEY `idx_pengguna` (`id_pengguna`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id_kota`),
  ADD UNIQUE KEY `kota_nama_kota_unique` (`nama_kota`);

--
-- Indexes for table `kupon`
--
ALTER TABLE `kupon`
  ADD PRIMARY KEY (`id_kupon`),
  ADD UNIQUE KEY `kupon_kode_kupon_unique` (`kode_kupon`),
  ADD KEY `idx_aktif` (`is_aktif`,`tgl_selesai`);

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
-- Indexes for table `pemakaian_kupon`
--
ALTER TABLE `pemakaian_kupon`
  ADD PRIMARY KEY (`id_pemakaian`),
  ADD KEY `pemakaian_kupon_id_pengguna_foreign` (`id_pengguna`),
  ADD KEY `pemakaian_kupon_id_pesanan_foreign` (`id_pesanan`),
  ADD KEY `idx_kupon_user` (`id_kupon`,`id_pengguna`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `pengguna_email_unique` (`email`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `pesanan_id_kota_tujuan_foreign` (`id_kota_tujuan`),
  ADD KEY `pesanan_id_verifikator_foreign` (`id_verifikator`),
  ADD KEY `pesanan_id_konfirmasi_foreign` (`id_konfirmasi`),
  ADD KEY `idx_pembeli_status` (`id_pembeli`,`status_pesanan`),
  ADD KEY `idx_batas_bayar` (`batas_bayar`);

--
-- Indexes for table `pesan_kontak`
--
ALTER TABLE `pesan_kontak`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `produk_slug_produk_unique` (`slug_produk`),
  ADD KEY `idx_petani` (`id_petani`),
  ADD KEY `idx_kategori` (`id_kategori`),
  ADD KEY `idx_aktif` (`is_aktif`);

--
-- Indexes for table `rekening_petani`
--
ALTER TABLE `rekening_petani`
  ADD PRIMARY KEY (`id_rekening`),
  ADD KEY `idx_petani` (`id_petani`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD UNIQUE KEY `ulasan_id_item_pesanan_unique` (`id_item_pesanan`),
  ADD KEY `ulasan_id_pengguna_foreign` (`id_pengguna`),
  ADD KEY `idx_produk` (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `escrow`
--
ALTER TABLE `escrow`
  MODIFY `id_escrow` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_status`
--
ALTER TABLE `histori_status`
  MODIFY `id_histori` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `item_pesanan`
--
ALTER TABLE `item_pesanan`
  MODIFY `id_item` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `kota`
--
ALTER TABLE `kota`
  MODIFY `id_kota` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kupon`
--
ALTER TABLE `kupon`
  MODIFY `id_kupon` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pemakaian_kupon`
--
ALTER TABLE `pemakaian_kupon`
  MODIFY `id_pemakaian` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `pesan_kontak`
--
ALTER TABLE `pesan_kontak`
  MODIFY `id_pesan` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `rekening_petani`
--
ALTER TABLE `rekening_petani`
  MODIFY `id_rekening` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `escrow`
--
ALTER TABLE `escrow`
  ADD CONSTRAINT `escrow_id_penerima_foreign` FOREIGN KEY (`id_penerima`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL,
  ADD CONSTRAINT `escrow_id_pesanan_foreign` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE RESTRICT;

--
-- Constraints for table `histori_status`
--
ALTER TABLE `histori_status`
  ADD CONSTRAINT `histori_status_id_pengubah_foreign` FOREIGN KEY (`id_pengubah`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL,
  ADD CONSTRAINT `histori_status_id_pesanan_foreign` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;

--
-- Constraints for table `item_pesanan`
--
ALTER TABLE `item_pesanan`
  ADD CONSTRAINT `item_pesanan_id_pesanan_foreign` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_pesanan_id_petani_foreign` FOREIGN KEY (`id_petani`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT,
  ADD CONSTRAINT `item_pesanan_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE RESTRICT;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `keranjang_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;

--
-- Constraints for table `pemakaian_kupon`
--
ALTER TABLE `pemakaian_kupon`
  ADD CONSTRAINT `pemakaian_kupon_id_kupon_foreign` FOREIGN KEY (`id_kupon`) REFERENCES `kupon` (`id_kupon`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemakaian_kupon_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemakaian_kupon_id_pesanan_foreign` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_id_konfirmasi_foreign` FOREIGN KEY (`id_konfirmasi`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL,
  ADD CONSTRAINT `pesanan_id_kota_tujuan_foreign` FOREIGN KEY (`id_kota_tujuan`) REFERENCES `kota` (`id_kota`) ON DELETE RESTRICT,
  ADD CONSTRAINT `pesanan_id_pembeli_foreign` FOREIGN KEY (`id_pembeli`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT,
  ADD CONSTRAINT `pesanan_id_verifikator_foreign` FOREIGN KEY (`id_verifikator`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE RESTRICT,
  ADD CONSTRAINT `produk_id_petani_foreign` FOREIGN KEY (`id_petani`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE;

--
-- Constraints for table `rekening_petani`
--
ALTER TABLE `rekening_petani`
  ADD CONSTRAINT `rekening_petani_id_petani_foreign` FOREIGN KEY (`id_petani`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_id_item_pesanan_foreign` FOREIGN KEY (`id_item_pesanan`) REFERENCES `item_pesanan` (`id_item`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulasan_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulasan_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
