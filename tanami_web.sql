-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2026 at 03:42 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tanami_web`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_batalkan_pesanan_timeout` ()   BEGIN
    -- Cancel order yang sudah lewat 24 jam tanpa bayar
    UPDATE pesanan 
    SET status_pesanan = 'dibatalkan',
        alasan_batal = 'Timeout pembayaran - Sudah 24 jam tidak ada bukti bayar',
        tgl_dibatalkan = NOW(),
        tgl_update = NOW()
    WHERE status_pesanan = 'pending'
      AND batas_bayar < NOW()
      AND bukti_bayar IS NULL;

    -- Release stok yang di-reserve
    UPDATE produk p
    INNER JOIN item_pesanan ip ON p.id_produk = ip.id_produk
    INNER JOIN pesanan ps ON ip.id_pesanan = ps.id_pesanan
    SET p.stok_direserve = p.stok_direserve - ip.jumlah
    WHERE ps.status_pesanan = 'dibatalkan'
      AND ps.tgl_dibatalkan >= DATE_SUB(NOW(), INTERVAL 1 MINUTE);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_selesaikan_pesanan_otomatis` ()   BEGIN
    -- Auto-complete order yang sudah 3 hari sejak delivered
    UPDATE pesanan 
    SET status_pesanan = 'selesai',
        tgl_selesai = NOW(),
        tgl_selesai_otomatis = NOW(),
        tgl_update = NOW()
    WHERE status_pesanan = 'terkirim'
      AND tgl_update < DATE_SUB(NOW(), INTERVAL 3 DAY);

    -- Release escrow ke petani
    UPDATE escrow e
    INNER JOIN pesanan ps ON e.id_pesanan = ps.id_pesanan
    INNER JOIN item_pesanan ip ON ps.id_pesanan = ip.id_pesanan
    SET e.status_escrow = 'dikirim_ke_petani',
        e.tgl_kirim = NOW(),
        e.id_penerima = ip.id_petani,
        e.catatan = 'Auto-complete setelah 3 hari'
    WHERE ps.status_pesanan = 'selesai'
      AND ps.tgl_selesai >= DATE_SUB(NOW(), INTERVAL 1 MINUTE)
      AND e.status_escrow = 'ditahan';
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `escrow`
--

CREATE TABLE `escrow` (
  `id_escrow` int NOT NULL,
  `id_pesanan` int NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `status_escrow` enum('ditahan','dikirim_ke_petani','direfund_ke_pembeli') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ditahan',
  `tgl_ditahan` timestamp NULL DEFAULT NULL,
  `tgl_kirim` timestamp NULL DEFAULT NULL,
  `id_penerima` int DEFAULT NULL COMMENT 'ID petani atau pembeli penerima dana',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histori_status`
--

CREATE TABLE `histori_status` (
  `id_histori` int NOT NULL,
  `id_pesanan` int NOT NULL,
  `status_lama` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_baru` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pengubah` int DEFAULT NULL COMMENT 'ID user yang ubah status',
  `alasan` text COLLATE utf8mb4_unicode_ci,
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_pesanan`
--

CREATE TABLE `item_pesanan` (
  `id_item` int NOT NULL,
  `id_pesanan` int NOT NULL,
  `id_produk` int NOT NULL,
  `id_petani` int NOT NULL COMMENT 'Denormalized untuk laporan',
  `jumlah` int NOT NULL,
  `harga_snapshot` decimal(10,2) NOT NULL COMMENT 'Harga saat checkout',
  `subtotal` decimal(10,2) NOT NULL,
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `slug_kategori`, `deskripsi`, `tgl_dibuat`) VALUES
(1, 'Sayuran', 'sayuran', 'Berbagai jenis sayuran segar', '2025-12-29 13:58:18'),
(2, 'Buah', 'buah', 'Buah-buahan segar berkualitas', '2025-12-29 13:58:18'),
(3, 'Tanaman Hias', 'tanaman-hias', 'Tanaman hias untuk dekorasi', '2025-12-29 13:58:18'),
(4, 'Bibit', 'bibit', 'Bibit tanaman berkualitas', '2025-12-29 13:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `id_produk` int NOT NULL,
  `jumlah` int NOT NULL,
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id_kota` int NOT NULL,
  `nama_kota` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinsi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ongkir` decimal(10,2) NOT NULL,
  `is_aktif` tinyint(1) DEFAULT '1',
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id_kota`, `nama_kota`, `provinsi`, `ongkir`, `is_aktif`, `tgl_dibuat`) VALUES
(1, 'Jakarta', 'DKI Jakarta', '20000.00', 1, '2025-12-29 13:58:18'),
(2, 'Bogor', 'Jawa Barat', '15000.00', 1, '2025-12-29 13:58:18'),
(3, 'Bandung', 'Jawa Barat', '25000.00', 1, '2025-12-29 13:58:18'),
(4, 'Tangerang', 'Banten', '18000.00', 1, '2025-12-29 13:58:18'),
(5, 'Bekasi', 'Jawa Barat', '17000.00', 1, '2025-12-29 13:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `kupon`
--

CREATE TABLE `kupon` (
  `id_kupon` int NOT NULL,
  `kode_kupon` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_diskon` enum('nominal','persen') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal_diskon` decimal(10,2) DEFAULT NULL,
  `persen_diskon` decimal(5,2) DEFAULT NULL,
  `min_belanja` decimal(10,2) DEFAULT '0.00',
  `limit_total` int DEFAULT NULL,
  `limit_per_user` int DEFAULT '1',
  `tgl_mulai` timestamp NOT NULL,
  `tgl_selesai` timestamp NOT NULL,
  `is_aktif` tinyint(1) DEFAULT '1',
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kupon`
--

INSERT INTO `kupon` (`id_kupon`, `kode_kupon`, `tipe_diskon`, `nominal_diskon`, `persen_diskon`, `min_belanja`, `limit_total`, `limit_per_user`, `tgl_mulai`, `tgl_selesai`, `is_aktif`, `tgl_dibuat`) VALUES
(1, 'PROMO10', 'nominal', '10000.00', NULL, '50000.00', NULL, 1, '2025-11-29 00:00:00', '2026-01-29 23:59:59', 1, '2025-12-29 13:58:18'),
(2, 'DISKON20', 'persen', NULL, '20.00', '100000.00', NULL, 2, '2025-12-14 00:00:00', '2026-01-14 23:59:59', 1, '2025-12-29 13:58:18'),
(3, 'NEWUSER', 'nominal', '15000.00', NULL, '30000.00', NULL, 1, '2025-12-22 00:00:00', '2026-02-28 23:59:59', 1, '2025-12-29 13:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `pemakaian_kupon`
--

CREATE TABLE `pemakaian_kupon` (
  `id_pemakaian` int NOT NULL,
  `id_kupon` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `id_pesanan` int NOT NULL,
  `diskon_dipakai` decimal(10,2) NOT NULL,
  `tgl_pakai` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Hash bcrypt',
  `role_pengguna` enum('admin','petani','pembeli') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `tgl_daftar` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `email`, `password`, `role_pengguna`, `alamat`, `no_hp`, `is_verified`, `tgl_daftar`, `tgl_update`) VALUES
(1, 'Admin System', 'admin@tanami.com', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'admin', NULL, '081234567890', 1, '2025-12-01 10:00:00', '2025-12-29 13:58:18'),
(2, 'Pak Tono', 'tono@petani.com', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'petani', 'Bogor, Jawa Barat', '081234567891', 1, '2025-12-01 10:00:00', '2025-12-29 13:58:18'),
(3, 'Bu Siti', 'siti@petani.com', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'petani', 'Bandung, Jawa Barat', '081234567892', 1, '2025-12-01 10:00:00', '2025-12-29 13:58:18'),
(4, 'Budi Santoso', 'budi@pembeli.com', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'pembeli', 'Jakarta Selatan', '081234567893', 1, '2025-12-15 10:00:00', '2025-12-29 13:58:18'),
(5, 'Ani Wijaya', 'ani@pembeli.com', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'pembeli', 'Tangerang', '081234567894', 1, '2025-12-15 10:00:00', '2025-12-29 13:58:18'),
(6, 'Dedi Kurniawan', 'dedi@pembeli.com', '$2y$10$abcdefghijklmnopqrstuvwxyz', 'pembeli', 'Bekasi', '081234567895', 1, '2025-12-15 10:00:00', '2025-12-29 13:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int NOT NULL,
  `id_pembeli` int NOT NULL,
  `id_kota_tujuan` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `ongkir` decimal(10,2) NOT NULL,
  `diskon` decimal(10,2) DEFAULT '0.00',
  `total_bayar` decimal(10,2) NOT NULL,
  `status_pesanan` enum('pending','menunggu_verifikasi','dibayar','diproses','dikirim','terkirim','selesai','dibatalkan','minta_refund','direfund') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_verifikasi` timestamp NULL DEFAULT NULL,
  `id_verifikator` int DEFAULT NULL COMMENT 'ID petani/admin yang verifikasi',
  `alasan_tolak` text COLLATE utf8mb4_unicode_ci,
  `no_resi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batas_bayar` timestamp NULL DEFAULT NULL COMMENT '24 jam dari checkout',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_selesai` timestamp NULL DEFAULT NULL COMMENT 'Waktu pembeli konfirmasi selesai',
  `id_konfirmasi` int DEFAULT NULL COMMENT 'ID pembeli yang konfirmasi',
  `tgl_selesai_otomatis` timestamp NULL DEFAULT NULL COMMENT 'Auto-complete setelah 3 hari',
  `alasan_batal` text COLLATE utf8mb4_unicode_ci,
  `tgl_dibatalkan` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `pesanan`
--
DELIMITER $$
CREATE TRIGGER `trg_log_perubahan_status` AFTER UPDATE ON `pesanan` FOR EACH ROW BEGIN
    IF OLD.status_pesanan != NEW.status_pesanan THEN
        INSERT INTO histori_status (
            id_pesanan, 
            status_lama, 
            status_baru, 
            alasan
        ) VALUES (
            NEW.id_pesanan, 
            OLD.status_pesanan, 
            NEW.status_pesanan, 
            NEW.alasan_batal
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int NOT NULL,
  `id_petani` int NOT NULL,
  `id_kategori` int NOT NULL,
  `nama_produk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_produk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `stok_direserve` int NOT NULL DEFAULT '0',
  `satuan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'kg, pcs, ikat, dll',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_aktif` tinyint(1) DEFAULT '1',
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_petani`, `id_kategori`, `nama_produk`, `slug_produk`, `harga`, `stok`, `stok_direserve`, `satuan`, `deskripsi`, `foto`, `is_aktif`, `tgl_dibuat`, `tgl_update`) VALUES
(1, 2, 1, 'Wortel Organik', 'wortel-organik', '10000.00', 50, 0, 'kg', 'Wortel organik segar dari Bogor', NULL, 1, '2025-12-29 13:58:18', '2025-12-29 13:58:18'),
(2, 2, 2, 'Tomat Merah', 'tomat-merah', '12000.00', 40, 0, 'kg', 'Tomat merah segar dan manis', NULL, 1, '2025-12-29 13:58:18', '2025-12-29 13:58:18'),
(3, 2, 1, 'Bayam Hijau', 'bayam-hijau', '8000.00', 30, 0, 'kg', 'Bayam hijau organik', NULL, 1, '2025-12-29 13:58:18', '2025-12-29 13:58:18'),
(4, 3, 2, 'Apel Malang', 'apel-malang', '25000.00', 20, 0, 'kg', 'Apel Malang premium', NULL, 1, '2025-12-29 13:58:18', '2025-12-29 13:58:18'),
(5, 3, 3, 'Monstera Deliciosa', 'monstera', '150000.00', 10, 0, 'pot', 'Tanaman hias Monstera cantik', NULL, 1, '2025-12-29 13:58:18', '2025-12-29 13:58:18'),
(6, 3, 4, 'Bibit Cabai Rawit', 'bibit-cabai', '5000.00', 100, 0, 'pack', 'Bibit cabai rawit unggul', NULL, 1, '2025-12-29 13:58:18', '2025-12-29 13:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `rekening_petani`
--

CREATE TABLE `rekening_petani` (
  `id_rekening` int NOT NULL,
  `id_petani` int NOT NULL,
  `nama_bank` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rekening` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atas_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_utama` tinyint(1) DEFAULT '0',
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rekening_petani`
--

INSERT INTO `rekening_petani` (`id_rekening`, `id_petani`, `nama_bank`, `no_rekening`, `atas_nama`, `is_utama`, `tgl_dibuat`) VALUES
(1, 2, 'BCA', '1234567890', 'TONO SUSILO', 1, '2025-12-29 13:58:18'),
(2, 3, 'Mandiri', '0987654321', 'SITI AMINAH', 1, '2025-12-29 13:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int NOT NULL,
  `id_item_pesanan` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `id_produk` int NOT NULL COMMENT 'Denormalized',
  `rating` int NOT NULL,
  `komentar` text COLLATE utf8mb4_unicode_ci,
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_ringkasan_pesanan`
-- (See below for the actual view)
--
CREATE TABLE `v_ringkasan_pesanan` (
`id_pesanan` int
,`status_pesanan` enum('pending','menunggu_verifikasi','dibayar','diproses','dikirim','terkirim','selesai','dibatalkan','minta_refund','direfund')
,`total_bayar` decimal(10,2)
,`tgl_dibuat` timestamp
,`batas_bayar` timestamp
,`nama_pembeli` varchar(100)
,`email_pembeli` varchar(100)
,`status_escrow` enum('ditahan','dikirim_ke_petani','direfund_ke_pembeli')
,`jumlah_escrow` decimal(10,2)
,`tgl_ditahan` timestamp
,`flag_pesanan` varchar(17)
);

-- --------------------------------------------------------

--
-- Structure for view `v_ringkasan_pesanan`
--
DROP TABLE IF EXISTS `v_ringkasan_pesanan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ringkasan_pesanan`  AS SELECT `p`.`id_pesanan` AS `id_pesanan`, `p`.`status_pesanan` AS `status_pesanan`, `p`.`total_bayar` AS `total_bayar`, `p`.`tgl_dibuat` AS `tgl_dibuat`, `p`.`batas_bayar` AS `batas_bayar`, `u`.`nama_lengkap` AS `nama_pembeli`, `u`.`email` AS `email_pembeli`, `e`.`status_escrow` AS `status_escrow`, `e`.`jumlah` AS `jumlah_escrow`, `e`.`tgl_ditahan` AS `tgl_ditahan`, (case when ((`p`.`status_pesanan` = 'pending') and (`p`.`batas_bayar` < now())) then 'EXPIRED' when (`p`.`status_pesanan` = 'pending') then 'MENUNGGU_BAYAR' when ((`p`.`status_pesanan` = 'terkirim') and (`p`.`tgl_update` < (now() - interval 3 day))) then 'SIAP_AUTO_SELESAI' else 'AKTIF' end) AS `flag_pesanan` FROM ((`pesanan` `p` join `pengguna` `u` on((`p`.`id_pembeli` = `u`.`id_pengguna`))) left join `escrow` `e` on((`p`.`id_pesanan` = `e`.`id_pesanan`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `escrow`
--
ALTER TABLE `escrow`
  ADD PRIMARY KEY (`id_escrow`),
  ADD UNIQUE KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_penerima` (`id_penerima`),
  ADD KEY `idx_pesanan_escrow` (`id_pesanan`),
  ADD KEY `idx_status_escrow` (`status_escrow`);

--
-- Indexes for table `histori_status`
--
ALTER TABLE `histori_status`
  ADD PRIMARY KEY (`id_histori`),
  ADD KEY `id_pengubah` (`id_pengubah`),
  ADD KEY `idx_pesanan_histori` (`id_pesanan`),
  ADD KEY `idx_status_perubahan` (`status_baru`,`tgl_dibuat`);

--
-- Indexes for table `item_pesanan`
--
ALTER TABLE `item_pesanan`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `idx_pesanan` (`id_pesanan`),
  ADD KEY `idx_petani` (`id_petani`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `slug_kategori` (`slug_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD UNIQUE KEY `unik_keranjang` (`id_pengguna`,`id_produk`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `idx_pengguna` (`id_pengguna`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id_kota`),
  ADD UNIQUE KEY `nama_kota` (`nama_kota`);

--
-- Indexes for table `kupon`
--
ALTER TABLE `kupon`
  ADD PRIMARY KEY (`id_kupon`),
  ADD UNIQUE KEY `kode_kupon` (`kode_kupon`),
  ADD KEY `idx_kode` (`kode_kupon`),
  ADD KEY `idx_aktif` (`is_aktif`,`tgl_selesai`);

--
-- Indexes for table `pemakaian_kupon`
--
ALTER TABLE `pemakaian_kupon`
  ADD PRIMARY KEY (`id_pemakaian`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `idx_kupon_user` (`id_kupon`,`id_pengguna`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role_pengguna`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_kota_tujuan` (`id_kota_tujuan`),
  ADD KEY `id_verifikator` (`id_verifikator`),
  ADD KEY `id_konfirmasi` (`id_konfirmasi`),
  ADD KEY `idx_pembeli_status` (`id_pembeli`,`status_pesanan`),
  ADD KEY `idx_batas_bayar` (`batas_bayar`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `slug_produk` (`slug_produk`),
  ADD KEY `idx_petani` (`id_petani`),
  ADD KEY `idx_kategori` (`id_kategori`),
  ADD KEY `idx_slug` (`slug_produk`),
  ADD KEY `idx_aktif` (`is_aktif`);

--
-- Indexes for table `rekening_petani`
--
ALTER TABLE `rekening_petani`
  ADD PRIMARY KEY (`id_rekening`),
  ADD KEY `idx_petani` (`id_petani`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD UNIQUE KEY `id_item_pesanan` (`id_item_pesanan`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `idx_produk` (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `escrow`
--
ALTER TABLE `escrow`
  MODIFY `id_escrow` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_status`
--
ALTER TABLE `histori_status`
  MODIFY `id_histori` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_pesanan`
--
ALTER TABLE `item_pesanan`
  MODIFY `id_item` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kota`
--
ALTER TABLE `kota`
  MODIFY `id_kota` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kupon`
--
ALTER TABLE `kupon`
  MODIFY `id_kupon` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pemakaian_kupon`
--
ALTER TABLE `pemakaian_kupon`
  MODIFY `id_pemakaian` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rekening_petani`
--
ALTER TABLE `rekening_petani`
  MODIFY `id_rekening` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `escrow`
--
ALTER TABLE `escrow`
  ADD CONSTRAINT `escrow_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE RESTRICT,
  ADD CONSTRAINT `escrow_ibfk_2` FOREIGN KEY (`id_penerima`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL;

--
-- Constraints for table `histori_status`
--
ALTER TABLE `histori_status`
  ADD CONSTRAINT `histori_status_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE,
  ADD CONSTRAINT `histori_status_ibfk_2` FOREIGN KEY (`id_pengubah`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL;

--
-- Constraints for table `item_pesanan`
--
ALTER TABLE `item_pesanan`
  ADD CONSTRAINT `item_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_pesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE RESTRICT,
  ADD CONSTRAINT `item_pesanan_ibfk_3` FOREIGN KEY (`id_petani`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;

--
-- Constraints for table `pemakaian_kupon`
--
ALTER TABLE `pemakaian_kupon`
  ADD CONSTRAINT `pemakaian_kupon_ibfk_1` FOREIGN KEY (`id_kupon`) REFERENCES `kupon` (`id_kupon`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemakaian_kupon_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemakaian_kupon_ibfk_3` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_pembeli`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT,
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_kota_tujuan`) REFERENCES `kota` (`id_kota`) ON DELETE RESTRICT,
  ADD CONSTRAINT `pesanan_ibfk_3` FOREIGN KEY (`id_verifikator`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL,
  ADD CONSTRAINT `pesanan_ibfk_4` FOREIGN KEY (`id_konfirmasi`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_petani`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE,
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE RESTRICT;

--
-- Constraints for table `rekening_petani`
--
ALTER TABLE `rekening_petani`
  ADD CONSTRAINT `rekening_petani_ibfk_1` FOREIGN KEY (`id_petani`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`id_item_pesanan`) REFERENCES `item_pesanan` (`id_item`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `evt_batalkan_timeout` ON SCHEDULE EVERY 1 HOUR STARTS '2025-12-29 13:58:18' ON COMPLETION NOT PRESERVE ENABLE DO CALL sp_batalkan_pesanan_timeout()$$

CREATE DEFINER=`root`@`localhost` EVENT `evt_selesaikan_otomatis` ON SCHEDULE EVERY 6 HOUR STARTS '2025-12-29 13:58:18' ON COMPLETION NOT PRESERVE ENABLE DO CALL sp_selesaikan_pesanan_otomatis()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
