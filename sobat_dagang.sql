-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 06:19 AM
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
-- Database: `sobat_dagang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(191) NOT NULL,
  `id_index_kategori` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `id_index_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Beras Varietas Kristal (Premium)/Kg', 1, NULL, NULL),
(2, 'Beras Varietas Santana (Premium)/Kg', 1, NULL, NULL),
(3, 'Beras Varietas 74 (Premium)/Kg', 1, NULL, NULL),
(4, 'Beras Bulog (Medium)/Kg', 1, NULL, NULL),
(5, 'Beras Varietas Banda (Medium)/Kg', 1, NULL, NULL),
(6, 'Gula Pasir Kristal Putih/Kg', 11, NULL, NULL),
(7, 'Minyak Goreng Tanpa Merek Curah (Sputnik)/Ltr', 12, NULL, NULL),
(8, 'Minyak Goreng Kemasan Sederhana Bantal /Ltr (fortune)', 12, NULL, NULL),
(9, 'Minyak Goreng Kemasan Premium (Bimoli)/ Ltr', 12, NULL, NULL),
(10, 'Minyak Goreng ( Minyak Kita Bantal ) / Ltr', 12, NULL, NULL),
(11, 'Tepung Terigu Kompas/Kg', 13, NULL, NULL),
(12, 'Daging Ayam Broiler/Kg', 3, NULL, NULL),
(13, 'Daging Ayam Kampung/Kg', 3, NULL, NULL),
(14, 'Daging Sapi Paha Depan/Kg', 6, NULL, NULL),
(15, 'Daging Sapi Paha Belakang/Kg', 6, NULL, NULL),
(16, 'Daging Sapi Has Luar (Sirloin)/Kg', 6, NULL, NULL),
(17, 'Daging Sapi Has Dalam (Ternderloin)/Kg', 6, NULL, NULL),
(18, 'Daging Sapi Sandung Lamur (Brisket)/Kg', 6, NULL, NULL),
(19, 'Daging Sapi Tetelan/Kg', 6, NULL, NULL),
(20, 'Daging Sapi Impor Beku/Kg', 6, NULL, NULL),
(21, 'Telur Ayam Ras/Kg', 5, NULL, NULL),
(22, 'Telur Ayam Kampung/Kg', 5, NULL, NULL),
(23, 'Susu Bubuk Balita Dancow Vanila/350gr', 14, NULL, NULL),
(24, 'Susu Bubuk Balita SGM Vanila/400gr', 14, NULL, NULL),
(25, 'Susu Kental Manis Frisian Flag/gr', 14, NULL, NULL),
(26, 'Tahu/Kg', 8, NULL, NULL),
(27, 'Tempe/Kg', 9, NULL, NULL),
(28, 'Bawang Merah (Enrekang)/Kg', 4, NULL, NULL),
(29, 'Bawang Putih (Honan)/Kg', 4, NULL, NULL),
(30, 'Bawang Bombay/kg', 6, NULL, NULL),
(31, 'Ikan Tuna/Kg', 7, NULL, NULL),
(32, 'Ikan Bandeng/Kg', 7, NULL, NULL),
(33, 'Ikan Teri Asin/Kg', 7, NULL, NULL),
(34, 'Ikan Asin/Kg', 7, NULL, NULL),
(35, 'Ikan Cakalang/Kg', 7, NULL, NULL),
(36, 'Ikan Kembung/Kg', 7, NULL, NULL),
(37, 'Garam Bata/Kg', 15, NULL, NULL),
(38, 'Garam Halus/Kg', 15, NULL, NULL),
(39, 'Kedelai Lokal/Kg', 16, NULL, NULL),
(40, 'Kedelai Impor/Kg', 16, NULL, NULL),
(41, 'Mie Instan/Pcs', 17, NULL, NULL),
(42, 'Cabe Merah Keriting/Kg', 2, NULL, NULL),
(43, 'Cabe Merah Besar/Kg', 2, NULL, NULL),
(44, 'Cabe Rawit Merah/Kg', 2, NULL, NULL),
(45, 'Cabe Rawit Hijau/Kg', 2, NULL, NULL),
(46, 'Kacang Tanah/Kg', 18, NULL, NULL),
(47, 'Kacang Hijau/Kg', 18, NULL, NULL),
(48, 'Ubi Ketela Pohon/Kg', 19, NULL, NULL),
(49, 'Jagung Pipilan Kuning/Kg', 20, NULL, NULL),
(50, 'Harga Pupuk Bersubsidi Urea/Kg', 21, NULL, NULL),
(51, 'Harga Pupuk Bersubsidi NPK Phonska/Kg', 21, NULL, NULL),
(52, 'Harga Pupuk Bersubsidi Organik Petroganik/Kg', 21, NULL, NULL),
(53, 'Harga Pupuk Bersubsidi SP-36/Kg', 21, NULL, NULL),
(54, 'Harga Pupuk Bersubsidi ZA/Kg', 21, NULL, NULL),
(55, 'Harga LPG Bersubsidi/3Kg', 22, NULL, NULL),
(56, 'Semen Tonasa/40Kg', 23, NULL, NULL),
(57, 'Semen Bosowa/40Kg', 23, NULL, NULL),
(58, 'Besi Beton 6mm/Btg', 24, NULL, NULL),
(59, 'Besi Beton 8mm/Btg', 24, NULL, NULL),
(60, 'Besi Beton 10mm/Btg', 24, NULL, NULL),
(61, 'Besi Beton 12mm/Btg', 24, NULL, NULL),
(62, 'Baja Ringan/Btg', 25, NULL, NULL),
(63, 'Triplek 6mm/Lmbr', 26, NULL, NULL),
(64, 'Kayu Balok/Btg', 27, NULL, NULL),
(65, 'Kayu Papan/Lmbr', 27, NULL, NULL),
(66, 'Paku 3cm/Kg', 28, NULL, NULL),
(67, 'Paku 4cm/Kg', 28, NULL, NULL),
(68, 'Paku 5cm/Kg', 28, NULL, NULL),
(69, 'Paku 7cm/Kg', 28, NULL, NULL),
(70, 'Paku 10cm/Kg', 28, NULL, NULL),
(71, 'Benih Padi/Kg', 29, NULL, NULL),
(72, 'Benih Jagung/Kg', 29, NULL, NULL),
(73, 'Benih Kedelai/Kg', 29, NULL, NULL),
(74, 'Udang Basah Sedang/kg', 30, NULL, NULL),
(75, 'Jeruk Lokal/kg', 31, NULL, NULL),
(76, 'Pisang Ambon/Sisir', 31, NULL, NULL),
(77, 'Sawi Hijau', 32, NULL, NULL),
(78, 'Tomat', 10, NULL, NULL),
(79, 'Ketimun', 22, NULL, NULL),
(80, 'Kentang', 33, NULL, NULL),
(81, 'Kangkung', 34, NULL, NULL),
(82, 'Kacang Panjang', 35, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barang_pelaporan`
--

CREATE TABLE `barang_pelaporan` (
  `id_barang_pelaporan` bigint(20) UNSIGNED NOT NULL,
  `id_kategori_barang_pelaporan` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bentuk_pengelolaan_limbah`
--

CREATE TABLE `bentuk_pengelolaan_limbah` (
  `id_bentuk` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `jenis_limbah` varchar(191) DEFAULT NULL,
  `jumlah_limbah` double NOT NULL DEFAULT 0,
  `jenis_limbah_b3` varchar(191) DEFAULT NULL,
  `jumlah_limbah_b3` double NOT NULL DEFAULT 0,
  `tps_limbah_b3` varchar(191) DEFAULT NULL,
  `pihak_berizin` varchar(191) DEFAULT NULL,
  `internal_industri` varchar(191) DEFAULT NULL,
  `parameter_limbah_cair` varchar(191) DEFAULT NULL,
  `jumlah_limbah_cair` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bentuk_pengelolaan_limbah`
--

INSERT INTO `bentuk_pengelolaan_limbah` (`id_bentuk`, `id_ikm`, `jenis_limbah`, `jumlah_limbah`, `jenis_limbah_b3`, `jumlah_limbah_b3`, `tps_limbah_b3`, `pihak_berizin`, `internal_industri`, `parameter_limbah_cair`, `jumlah_limbah_cair`, `created_at`, `updated_at`) VALUES
(1, 1, 'Contoh', 98, 'Contoh', 98, 'Contoh', 'Contoh', 'Contoh', 'debit_inlet', 98, '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 'Contoh', 98, 'Contoh', 98, 'Contoh', 'Contoh', 'Contoh', 'debit_inlet', 98, '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` bigint(20) UNSIGNED NOT NULL,
  `id_disdag` bigint(20) UNSIGNED DEFAULT NULL,
  `judul` varchar(191) NOT NULL,
  `isi` text NOT NULL,
  `lampiran` varchar(191) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `id_disdag`, `judul`, `isi`, `lampiran`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dinas Perdagangan Gelar Operasi Pasar Murah untuk Stabilkan Harga Bahan Pokok', '<p data-start=\"60\" data-end=\"499\" style=\"text-align: justify; \">Dalam upaya menjaga stabilitas harga bahan pokok menjelang Hari Raya Idul Fitri, Dinas Perdagangan Kota Surabaya menggelar Operasi Pasar Murah di 10 titik strategis mulai 2 hingga 10 Mei 2025. Kegiatan ini bertujuan untuk membantu masyarakat memperoleh kebutuhan pokok dengan harga yang lebih terjangkau.</p><p data-start=\"501\" data-end=\"781\" style=\"text-align: justify;\">Kepala Dinas Perdagangan, Bapak Hadi Santoso, mengatakan bahwa kegiatan ini merupakan hasil kerja sama dengan Bulog dan beberapa distributor besar. Barang-barang yang disediakan meliputi beras, minyak goreng, gula pasir, tepung terigu, dan telur dengan harga di bawah harga pasar.</p><p data-start=\"501\" data-end=\"781\" style=\"text-align: justify;\">\"Operasi pasar ini merupakan bentuk nyata kehadiran pemerintah dalam menjamin ketersediaan dan keterjangkauan harga kebutuhan pokok bagi masyarakat,\" ujar Hadi.</p><p>\r\n\r\n\r\n</p><p data-start=\"945\" data-end=\"1215\" style=\"text-align: justify; \">Masyarakat menyambut baik kegiatan ini, terutama warga di wilayah padat penduduk seperti Kecamatan Tambaksari dan Simokerto. Selain menekan inflasi daerah, kegiatan ini juga diharapkan mampu mendorong daya beli masyarakat di tengah naiknya kebutuhan menjelang hari raya.</p>', 'lampiran/kMl4Mxsqj4o83GppVN2APmgwk8JM03AVDPqWNkoF.jpg', '2025-06-09', '2025-06-09 07:37:52', '2025-06-09 07:37:52');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_alat_ukur`
--

CREATE TABLE `data_alat_ukur` (
  `id_data_alat` bigint(20) UNSIGNED NOT NULL,
  `id_uttp` bigint(20) UNSIGNED NOT NULL,
  `tanggal_exp` date NOT NULL,
  `notifikasi_terkirim` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_alat_ukur`
--

INSERT INTO `data_alat_ukur` (`id_data_alat`, `id_uttp`, `tanggal_exp`, `notifikasi_terkirim`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-06-17', 1, 'Valid', '2025-06-09 21:19:30', '2025-06-09 21:20:00'),
(2, 2, '2025-06-17', 1, 'Valid', '2025-06-09 23:38:18', '2025-06-09 23:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `data_ikm`
--

CREATE TABLE `data_ikm` (
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `nama_ikm` varchar(191) NOT NULL,
  `luas` varchar(191) NOT NULL,
  `nama_pemilik` varchar(191) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `kecamatan` varchar(191) NOT NULL,
  `kelurahan` varchar(191) NOT NULL,
  `komoditi` varchar(191) NOT NULL,
  `jenis_industri` varchar(191) NOT NULL,
  `alamat` text NOT NULL,
  `nib` varchar(191) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `tenaga_kerja` int(11) NOT NULL,
  `level` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_ikm`
--

INSERT INTO `data_ikm` (`id_ikm`, `nama_ikm`, `luas`, `nama_pemilik`, `jenis_kelamin`, `kecamatan`, `kelurahan`, `komoditi`, `jenis_industri`, `alamat`, `nib`, `no_telp`, `tenaga_kerja`, `level`, `created_at`, `updated_at`) VALUES
(1, 'Ternak udang', 'Contoh', 'Uceng Gacor', 'Laki-laki', 'Bacukiki', 'WT. Bacukiki', 'Komoditi 1', 'Sandang', 'Contoh', 'Contoh', '081234567890', 98, 1960, '2025-06-09 21:09:43', '2025-06-09 21:10:08'),
(2, 'Air Besih', 'Contoh', 'Bahrul', 'Laki-laki', 'Bacukiki Barat', 'Lumpue', 'Komoditi 1', 'Pangan', 'Contoh', 'Contoh', '081234567890', 98, 110200688, '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `disdag`
--

CREATE TABLE `disdag` (
  `id_disdag` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(191) NOT NULL,
  `nip` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `telp` varchar(191) DEFAULT NULL,
  `role` enum('master_admin','admin_perdagangan','admin_industri','admin_metrologi','kabid_perdagangan','kabid_industri','kabid_metrologi','kepala_dinas') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disdag`
--

INSERT INTO `disdag` (`id_disdag`, `password`, `nip`, `email`, `telp`, `role`, `created_at`, `updated_at`) VALUES
(1, '$2y$12$/lWOW.YPtOHrvEB6xKZUcuc5dLTXYbPYKEttngdFXkfE6WH.doZbu', '196501011990031001', 'master_admin@disdag.local', '08123456789', 'master_admin', '2025-06-09 12:25:12', '2025-06-09 12:25:12'),
(2, '$2y$12$AIkF3j9fg/9gnqqQC4m6muK5miZZvuy8y58uayb4sOCCvjP5EaSUu', '197201021993041002', 'admin_perdagangan@disdag.local', '08123456789', 'admin_perdagangan', '2025-06-09 12:25:13', '2025-06-09 12:25:13'),
(3, '$2y$12$R4sM1mqNOk8t5acV6dwlwe9bqwTrw5VUkOO43M.Fmfre/3rkdBe0K', '197305031994051003', 'admin_industri@disdag.local', '08123456789', 'admin_industri', '2025-06-09 12:25:13', '2025-06-09 12:25:13'),
(4, '$2y$12$Ss1Y5K4FJP3NHZ0TVXX17uNLbuRRHNOc99HKl/X0ihuSOdarbV0ra', '197406041995061004', 'admin_metrologi@disdag.local', '08123456789', 'admin_metrologi', '2025-06-09 12:25:14', '2025-06-09 12:25:14'),
(5, '$2y$12$.pqMsDhbrCVOYeFlyNyKB.k.gwdsPCw85tiozOikV0FSYpoNZDrTW', '197507051996071005', 'kabid_perdagangan@disdag.local', '08123456789', 'kabid_perdagangan', '2025-06-09 12:25:15', '2025-06-09 12:25:15'),
(6, '$2y$12$lbUiSbgCWP8JLDlyLwCW7eE/t32WrQjCowpOQO4kgl9xexaeQ9oSa', '197608061997081006', 'kabid_industri@disdag.local', '08123456789', 'kabid_industri', '2025-06-09 12:25:15', '2025-06-09 12:25:15'),
(7, '$2y$12$XWWGwVZy3kplmSdpi36.ROXSQ.4bsxGJ9wuLRXm5PDrzWECU80Mqi', '197709071998091007', 'kabid_metrologi@disdag.local', '08123456789', 'kabid_metrologi', '2025-06-09 12:25:16', '2025-06-09 12:25:16'),
(8, '$2y$12$ac9tl3h9PQ6ouh9Bgu.j2ucbGDgg79oIaPvqMz1CVeGr97241mxZG', '197810081999101008', 'kepala_dinas@disdag.local', '08123456789', 'kepala_dinas', '2025-06-09 12:25:17', '2025-06-09 12:25:17');

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE `distributor` (
  `id_distributor` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nib` varchar(191) NOT NULL,
  `status` enum('menunggu','ditolak','diterima') NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `distributor`
--

INSERT INTO `distributor` (`id_distributor`, `id_user`, `nib`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'nib_dokumen/1749482938_Tugas Diskusi ERD.pdf', 'diterima', '2025-06-09 07:28:58', '2025-06-09 07:29:45'),
(2, 3, 'nib_dokumen/1749541400_Tugas Diskusi ERD.pdf', 'diterima', '2025-06-09 23:43:20', '2025-06-09 23:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `document_user`
--

CREATE TABLE `document_user` (
  `id_document` bigint(20) UNSIGNED NOT NULL,
  `id_permohonan` char(36) NOT NULL,
  `npwp` varchar(191) DEFAULT NULL,
  `akta_perusahaan` varchar(191) DEFAULT NULL,
  `foto_ktp` varchar(191) DEFAULT NULL,
  `foto_usaha` varchar(191) DEFAULT NULL,
  `dokument_nib` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_user`
--

INSERT INTO `document_user` (`id_document`, `id_permohonan`, `npwp`, `akta_perusahaan`, `foto_ktp`, `foto_usaha`, `dokument_nib`, `created_at`, `updated_at`) VALUES
(1, '8a7d2f66-e700-44fe-9df5-4cb659bc4441', 'DokumentUser/znbGnZ0Rcm9fw7xFU2S4Q36Cn5L8ToApbB51adIp.pdf', 'DokumentUser/2Pn8syo5qTa7Q9NK061270gWHXcCS2slKfSQ7H6f.pdf', 'DokumentUser/sp8qAVTSL8GWXe2eGNi9a5nRU72cmDHcJ0LZ6TlD.jpg', 'DokumentUser/rPgFnKIAo3Ite0RZVzlfZ5E2uVQDD2WPSSLECQm0.jpg', 'DokumentUser/bff2dxO7TtLtJ8NR9Y8NFuQYPUXq9aQRHB7Q3Gwe.pdf', '2025-06-09 07:21:54', '2025-06-09 07:21:54'),
(2, '53531f96-0dd0-4d16-81dc-7e72998c59d2', 'DokumentUser/e4vIlQTl6txdRCVh1USsf3T57Q6myi7w6VtXmMT7.pdf', 'DokumentUser/tRrX6ffOuWlgSCugki5xMzqKwItWNd1cYbIciCAQ.pdf', 'DokumentUser/gVZqbC7wRUNDbamaPiYXLEN8sKXRaR4TOXmBz6gZ.jpg', 'DokumentUser/kceZkY1O1Mffmwb3L1GgLuHc7oJswI6N16GNrpw1.jpg', 'DokumentUser/kcqgAj0JZ4xwTIfSOkRzF2IiHs6HJNEjrIgS7P1x.pdf', '2025-06-09 08:31:44', '2025-06-09 08:33:11'),
(3, 'a0780478-e8f7-4801-988c-0b34ea4a228a', 'DokumentUser/J9KQN7Wn7LXdHdFeIK6yB53JIxeFTEkSBMeDuAc0.pdf', NULL, 'DokumentUser/AyuYbYawZg0NxWewlWmPH3bbR4gwBn1x3zqRE3Nd.jpg', 'DokumentUser/QEjcQ1Dik7B7aZ4UOF3JOXe7thGi83QWhPnY0RnV.jpg', 'DokumentUser/o1iWcTzzldDgIMoJFEPTG8NnnXPhVCSMdF4ze47q.pdf', '2025-06-09 20:36:59', NULL),
(4, '3e233770-942b-49a4-ae1a-c80d7db790e1', 'DokumentUser/DR1sxXSWwSZqvj5pjvXQaXTr56D6hMV0OuatLL5g.pdf', 'DokumentUser/HXcgkdXVLL6KZ0hefVieogkGsNpuBCIRaAtQzgj9.pdf', 'DokumentUser/Xmp6pjYQ7p2bXGtw3FU0X8lCQvFO5uT0lhptIamk.jpg', 'DokumentUser/YsTUQTwE5RjZeWVs8fB926npatMC1Xfz0GJv9gMY.jpg', 'DokumentUser/nXxoIhsXu9zbTHpik9IeDMQFHazszHGH3cIwXU4b.pdf', '2025-06-09 20:36:59', '2025-06-09 20:37:20'),
(5, 'e861e3ab-2317-4f65-9a43-50c73676c8c4', 'DokumentUser/hMkbTvvcnJj3l7l8wbDN8Xv4ctxqEKxgP3fwWti7.pdf', 'DokumentUser/uEUS2LU0OvxE24uTS7gDPqgfMHhISClFFmR2PNP8.pdf', 'DokumentUser/XFdu4rDVRRXThl0WPYy72uhdOOUA3oTfuQq3X6Zo.jpg', 'DokumentUser/aPhWfsR9x3wgh12M3JVDNJ2kR8gh04iRP8bvfQTR.jpg', 'DokumentUser/0lPzEiybuInzmUIXfC8jjtPmckArsVJnaRW2W4wh.pdf', '2025-06-09 22:39:32', '2025-06-09 22:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pertanyaan` varchar(191) NOT NULL,
  `jawaban` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `pertanyaan`, `jawaban`, `created_at`, `updated_at`) VALUES
(1, 'Apakah Bumi Datar ?', 'Tidak', '2025-06-10 00:04:31', '2025-06-10 00:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `form_permohonan`
--

CREATE TABLE `form_permohonan` (
  `id_permohonan` char(36) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `kecamatan` varchar(191) NOT NULL,
  `kelurahan` varchar(191) NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `jenis_surat` varchar(191) NOT NULL,
  `titik_koordinat` varchar(191) NOT NULL,
  `file_surat` varchar(191) DEFAULT NULL,
  `file_balasan` varchar(191) DEFAULT NULL,
  `status` enum('menunggu','ditolak','diterima','disimpan') NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_permohonan`
--

INSERT INTO `form_permohonan` (`id_permohonan`, `id_user`, `kecamatan`, `kelurahan`, `tgl_pengajuan`, `jenis_surat`, `titik_koordinat`, `file_surat`, `file_balasan`, `status`, `created_at`, `updated_at`) VALUES
('3e233770-942b-49a4-ae1a-c80d7db790e1', 1, 'bacukiki_barat', 'sumpang_minangae', '2025-06-10', 'surat_rekomendasi_industri', '-4.023224535629776, 119.63393738026438', 'DokumentUser/cQpp1QSSh49QnIV22R6nzuj4PIUq7giF5iC65E4F.pdf', 'surat/rekomendasi-fee9aa41-b18a-49f9-8995-e4d841bf16bf.pdf', 'diterima', '2025-06-09 20:36:59', '2025-06-09 20:51:16'),
('53531f96-0dd0-4d16-81dc-7e72998c59d2', 1, 'bacukiki_barat', 'kampung_baru', '2025-06-09', 'surat_keterangan_perdagangan', '-4.023224535629776, 119.63393738026438', 'DokumentUser/FAyeFqmxoJpm471ZAdGg4JAHnH1NZuEksA8GAaHR.pdf', 'surat/rekomendasi-b9e8c4e8-04fb-4ba0-93d3-32320e8e21d2.pdf', 'diterima', '2025-06-09 08:31:44', '2025-06-10 00:15:52'),
('8a7d2f66-e700-44fe-9df5-4cb659bc4441', 1, 'soreang', 'ujung_lare', '2025-06-09', 'surat_rekomendasi_perdagangan', '-4.023224535629776, 119.63393738026438', 'DokumentUser/ANUUvffgzAllJHe1jhCUu6taHpTp63Uk5LAzshDM.pdf', 'surat/rekomendasi-264826ec-5de4-4dc7-b5ae-e6eb27e815fd.pdf', 'diterima', '2025-06-09 07:21:54', '2025-06-09 07:27:32'),
('a0780478-e8f7-4801-988c-0b34ea4a228a', 1, 'bacukiki_barat', 'sumpang_minangae', '2025-06-10', 'surat_rekomendasi_industri', '-4.023224535629776, 119.63393738026438', 'DokumentUser/t7GGgbKzjGbSuBZAMMpAM6DL0kBNPfEG00pLZPSz.pdf', NULL, 'disimpan', '2025-06-09 20:36:59', NULL),
('e861e3ab-2317-4f65-9a43-50c73676c8c4', 3, 'soreang', 'lakessi', '2025-06-10', 'surat_rekomendasi_industri', '-83472399.3723973', 'DokumentUser/mNLw75hlj597t9N7H9r5DyUOPCRdVOD2P7XqQk2q.pdf', 'surat/rekomendasi-59cd2add-e8f0-45c9-8446-fe3f321fec8b.pdf', 'diterima', '2025-06-09 22:39:32', '2025-06-09 22:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `forum_diskusi`
--

CREATE TABLE `forum_diskusi` (
  `id_pengaduan` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `id_disdag` bigint(20) UNSIGNED DEFAULT NULL,
  `chat` text NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forum_diskusi`
--

INSERT INTO `forum_diskusi` (`id_pengaduan`, `id_user`, `id_disdag`, `chat`, `waktu`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'hai', '2025-06-09 21:06:11', 'user', '2025-06-09 21:06:11', '2025-06-09 21:06:11'),
(2, NULL, 1, 'hai juga bang', '2025-06-09 21:07:16', 'terkirim', '2025-06-09 21:07:16', '2025-06-09 21:07:16'),
(4, 3, NULL, 'Haii', '2025-06-09 23:50:29', 'user', '2025-06-09 23:50:29', '2025-06-09 23:50:29'),
(5, 3, NULL, 'hallo', '2025-06-09 23:51:15', 'user', '2025-06-09 23:51:15', '2025-06-09 23:51:15'),
(6, NULL, 1, 'haloooo', '2025-06-09 23:51:35', 'terkirim', '2025-06-09 23:51:35', '2025-06-09 23:51:35'),
(7, 3, NULL, 'hai contoh', '2025-06-09 23:59:58', 'user', '2025-06-09 23:59:58', '2025-06-09 23:59:58'),
(8, NULL, 1, 'hai contoh juga', '2025-06-10 00:00:31', 'terkirim', '2025-06-10 00:00:31', '2025-06-10 00:00:31');

-- --------------------------------------------------------

--
-- Table structure for table `index_harga`
--

CREATE TABLE `index_harga` (
  `id_index` bigint(20) UNSIGNED NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `id_index_kategori` bigint(20) UNSIGNED NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `tanggal` date NOT NULL,
  `lokasi` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `index_harga`
--

INSERT INTO `index_harga` (`id_index`, `id_barang`, `id_index_kategori`, `harga`, `tanggal`, `lokasi`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 16000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:02', '2025-06-09 12:26:02'),
(2, 2, 1, 13100.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:02', '2025-06-09 12:26:02'),
(3, 3, 1, 13000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:02', '2025-06-09 12:26:02'),
(4, 4, 1, 12000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:02', '2025-06-09 12:26:02'),
(5, 5, 1, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(6, 6, 11, 18000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(7, 7, 12, 17550.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(8, 8, 12, 17000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(9, 9, 12, 20000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(10, 10, 12, 15500.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(11, 11, 13, 10500.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(12, 12, 3, 31400.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(13, 13, 3, 50000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(14, 14, 6, 130000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(15, 15, 6, 130000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(16, 16, 6, 130000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(17, 17, 6, 130000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(18, 18, 6, 130000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(19, 19, 6, 100000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(20, 20, 6, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(21, 21, 5, 29400.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(22, 22, 5, 50000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(23, 23, 14, 42200.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(24, 24, 14, 43800.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:03', '2025-06-09 12:26:03'),
(25, 25, 14, 12500.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(26, 26, 8, 10000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(27, 27, 9, 15000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(28, 28, 4, 38300.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(29, 29, 4, 45000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(30, 30, 4, 36700.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(31, 31, 7, 35000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(32, 32, 7, 30000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(33, 33, 7, 95000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(34, 34, 7, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(35, 35, 7, 28300.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(36, 36, 7, 30000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(37, 37, 15, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(38, 38, 15, 10000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(39, 39, 16, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(40, 40, 16, 13000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(41, 41, 17, 3000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(42, 42, 2, 40000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:04', '2025-06-09 12:26:04'),
(43, 43, 2, 37700.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(44, 44, 2, 73300.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(45, 45, 2, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(46, 46, 18, 30000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(47, 47, 18, 20000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(48, 48, 19, 10000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(49, 49, 20, 5000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(50, 50, 21, 2250.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(51, 51, 21, 2300.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(52, 52, 21, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(53, 53, 21, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(54, 54, 21, 1700.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(55, 55, 22, 18500.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(56, 56, 23, 65000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(57, 57, 23, 60000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(58, 58, 24, 35000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(59, 59, 24, 50000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(60, 60, 24, 77000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(61, 61, 24, 105000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:05', '2025-06-09 12:26:05'),
(62, 62, 25, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(63, 63, 26, 65000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(64, 64, 27, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(65, 65, 27, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(66, 66, 28, 20000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(67, 67, 28, 20000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(68, 68, 28, 18000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(69, 69, 28, 18000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(70, 70, 28, 18000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(71, 71, 29, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(72, 72, 29, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(73, 73, 29, 0.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(74, 74, 30, 50000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(75, 75, 31, 10000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(76, 76, 31, 15000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(77, 77, 32, 10000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(78, 78, 10, 14000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(79, 79, 22, 25000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(80, 80, 33, 10000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:06', '2025-06-09 12:26:06'),
(81, 81, 34, 15000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(82, 82, 35, 10000.00, '2025-06-09', 'Pasar Sumpang', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(83, 1, 1, 16000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(84, 2, 1, 13100.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(85, 3, 1, 13000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(86, 4, 1, 12000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(87, 5, 1, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(88, 6, 11, 18000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(89, 7, 12, 17550.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(90, 8, 12, 17000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(91, 9, 12, 20000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(92, 10, 12, 15500.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(93, 11, 13, 10500.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(94, 12, 3, 31400.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(95, 13, 3, 50000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(96, 14, 6, 130000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(97, 15, 6, 130000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(98, 16, 6, 130000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:07', '2025-06-09 12:26:07'),
(99, 17, 6, 130000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:08', '2025-06-09 12:26:08'),
(100, 18, 6, 130000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(101, 19, 6, 100000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(102, 20, 6, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(103, 21, 5, 29400.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(104, 22, 5, 50000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(105, 23, 14, 42200.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(106, 24, 14, 43800.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(107, 25, 14, 12500.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(108, 26, 8, 10000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(109, 27, 9, 15000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(110, 28, 4, 38300.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(111, 29, 4, 45000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(112, 30, 4, 36700.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(113, 31, 7, 35000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(114, 32, 7, 30000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(115, 33, 7, 95000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(116, 34, 7, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(117, 35, 7, 28300.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(118, 36, 7, 30000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(119, 37, 15, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(120, 38, 15, 10000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:09', '2025-06-09 12:26:09'),
(121, 39, 16, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(122, 40, 16, 13000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(123, 41, 17, 3000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(124, 42, 2, 40000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(125, 43, 2, 37700.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(126, 44, 2, 73300.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(127, 45, 2, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(128, 46, 18, 30000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(129, 47, 18, 20000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(130, 48, 19, 10000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(131, 49, 20, 5000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(132, 50, 21, 2250.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(133, 51, 21, 2300.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(134, 52, 21, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(135, 53, 21, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(136, 54, 21, 1700.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(137, 55, 22, 18500.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(138, 56, 23, 65000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:10', '2025-06-09 12:26:10'),
(139, 57, 23, 60000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(140, 58, 24, 35000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(141, 59, 24, 50000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(142, 60, 24, 77000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(143, 61, 24, 105000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(144, 62, 25, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(145, 63, 26, 65000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(146, 64, 27, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(147, 65, 27, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(148, 66, 28, 20000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(149, 67, 28, 20000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(150, 68, 28, 18000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(151, 69, 28, 18000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(152, 70, 28, 18000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(153, 71, 29, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(154, 72, 29, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(155, 73, 29, 0.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(156, 74, 30, 50000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(157, 75, 31, 10000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(158, 76, 31, 15000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(159, 77, 32, 10000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:11', '2025-06-09 12:26:11'),
(160, 78, 10, 14000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:12', '2025-06-09 12:26:12'),
(161, 79, 22, 25000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:12', '2025-06-09 12:26:12'),
(162, 80, 33, 10000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:12', '2025-06-09 12:26:12'),
(163, 81, 34, 15000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:12', '2025-06-09 12:26:12'),
(164, 82, 35, 10000.00, '2025-06-09', 'Pasar Lakessi', '2025-06-09 12:26:12', '2025-06-09 12:26:12'),
(165, 1, 1, 13273.00, '2025-06-02', 'Pasar Sumpang', NULL, NULL),
(166, 1, 1, 13301.00, '2025-06-03', 'Pasar Sumpang', NULL, NULL),
(167, 1, 1, 13329.00, '2025-06-04', 'Pasar Sumpang', NULL, NULL),
(168, 1, 1, 13303.00, '2025-06-05', 'Pasar Sumpang', NULL, NULL),
(169, 1, 1, 13377.00, '2025-06-06', 'Pasar Sumpang', NULL, NULL),
(170, 1, 1, 13400.00, '2025-06-07', 'Pasar Sumpang', NULL, NULL),
(171, 1, 1, 13420.00, '2025-06-08', 'Pasar Sumpang', NULL, NULL),
(172, 1, 1, 13825.00, '2025-06-02', 'Pasar Lakessi', NULL, NULL),
(173, 1, 1, 13847.00, '2025-06-03', 'Pasar Lakessi', NULL, NULL),
(174, 1, 1, 13851.00, '2025-06-04', 'Pasar Lakessi', NULL, NULL),
(175, 1, 1, 13858.00, '2025-06-05', 'Pasar Lakessi', NULL, NULL),
(176, 1, 1, 13877.00, '2025-06-06', 'Pasar Lakessi', NULL, NULL),
(177, 1, 1, 13899.00, '2025-06-07', 'Pasar Lakessi', NULL, NULL),
(178, 1, 1, 13905.00, '2025-06-08', 'Pasar Lakessi', NULL, NULL),
(179, 2, 1, 13180.00, '2025-06-02', 'Pasar Sumpang', NULL, NULL),
(180, 2, 1, 13190.00, '2025-06-03', 'Pasar Sumpang', NULL, NULL),
(181, 2, 1, 13200.00, '2025-06-04', 'Pasar Sumpang', NULL, NULL),
(182, 2, 1, 13222.00, '2025-06-05', 'Pasar Sumpang', NULL, NULL),
(183, 2, 1, 13220.00, '2025-06-06', 'Pasar Sumpang', NULL, NULL),
(184, 2, 1, 13240.00, '2025-06-07', 'Pasar Sumpang', NULL, NULL),
(185, 2, 1, 13255.00, '2025-06-08', 'Pasar Sumpang', NULL, NULL),
(186, 2, 1, 14028.00, '2025-06-02', 'Pasar Lakessi', NULL, NULL),
(187, 2, 1, 14050.00, '2025-06-03', 'Pasar Lakessi', NULL, NULL),
(188, 2, 1, 14074.00, '2025-06-04', 'Pasar Lakessi', NULL, NULL),
(189, 2, 1, 14091.00, '2025-06-05', 'Pasar Lakessi', NULL, NULL),
(190, 2, 1, 14104.00, '2025-06-06', 'Pasar Lakessi', NULL, NULL),
(191, 2, 1, 14120.00, '2025-06-07', 'Pasar Lakessi', NULL, NULL),
(192, 2, 1, 14140.00, '2025-06-08', 'Pasar Lakessi', NULL, NULL),
(193, 3, 1, 13887.00, '2025-06-02', 'Pasar Sumpang', NULL, NULL),
(194, 3, 1, 13909.00, '2025-06-03', 'Pasar Sumpang', NULL, NULL),
(195, 3, 1, 13917.00, '2025-06-04', 'Pasar Sumpang', NULL, NULL),
(196, 3, 1, 13968.00, '2025-06-05', 'Pasar Sumpang', NULL, NULL),
(197, 3, 1, 13959.00, '2025-06-06', 'Pasar Sumpang', NULL, NULL),
(198, 3, 1, 13970.00, '2025-06-07', 'Pasar Sumpang', NULL, NULL),
(199, 3, 1, 13980.00, '2025-06-08', 'Pasar Sumpang', NULL, NULL),
(200, 3, 1, 12977.00, '2025-06-02', 'Pasar Lakessi', NULL, NULL),
(201, 3, 1, 12993.00, '2025-06-03', 'Pasar Lakessi', NULL, NULL),
(202, 3, 1, 12999.00, '2025-06-04', 'Pasar Lakessi', NULL, NULL),
(203, 3, 1, 13031.00, '2025-06-05', 'Pasar Lakessi', NULL, NULL),
(204, 3, 1, 13093.00, '2025-06-06', 'Pasar Lakessi', NULL, NULL),
(205, 3, 1, 13110.00, '2025-06-07', 'Pasar Lakessi', NULL, NULL),
(206, 3, 1, 13125.00, '2025-06-08', 'Pasar Lakessi', NULL, NULL),
(207, 1, 1, 13000.00, '2025-06-10', 'Pasar Lakessi', '2025-06-09 20:40:53', '2025-06-09 20:40:53');

-- --------------------------------------------------------

--
-- Table structure for table `index_kategori`
--

CREATE TABLE `index_kategori` (
  `id_index_kategori` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `index_kategori`
--

INSERT INTO `index_kategori` (`id_index_kategori`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Beras', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(2, 'Cabe', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(3, 'Ayam', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(4, 'Bawang', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(5, 'Telur', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(6, 'Daging', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(7, 'Ikan', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(8, 'Tahu', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(9, 'Tempe', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(10, 'Tomat', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(11, 'Gula', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(12, 'Minyak Goreng', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(13, 'Tepung', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(14, 'Susu', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(15, 'Garam', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(16, 'Kedelai', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(17, 'Mie Instan', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(18, 'Kacang', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(19, 'Ubi Ketela', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(20, 'Jagung Pipilan', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(21, 'Pupuk Bersubsidi', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(22, 'LPG Bersubsidi', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(23, 'Semen', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(24, 'Besi Beton', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(25, 'Baja Ringan', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(26, 'Triplek', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(27, 'Kayu', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(28, 'Paku', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(29, 'Benih', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(30, 'Udang Basah', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(31, 'Buah-buahan', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(32, 'Sayuran', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(33, 'Kentang', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(34, 'Kangkung', '2025-06-09 12:25:43', '2025-06-09 12:25:43'),
(35, 'Kacang Panjang', '2025-06-09 12:25:43', '2025-06-09 12:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `tenaga_kerja_tetap` int(11) NOT NULL,
  `tenaga_kerja_tidak_tetap` int(11) NOT NULL,
  `tenaga_kerja_laki_laki` int(11) NOT NULL,
  `tenaga_kerja_perempuan` int(11) NOT NULL,
  `sd` int(11) NOT NULL,
  `smp` int(11) NOT NULL,
  `sma_smk` int(11) NOT NULL,
  `d1_d3` int(11) NOT NULL,
  `s1_d4` int(11) NOT NULL,
  `s2` int(11) NOT NULL,
  `s3` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `id_ikm`, `tenaga_kerja_tetap`, `tenaga_kerja_tidak_tetap`, `tenaga_kerja_laki_laki`, `tenaga_kerja_perempuan`, `sd`, `smp`, `sma_smk`, `d1_d3`, `s1_d4`, `s2`, `s3`, `created_at`, `updated_at`) VALUES
(1, 1, 98, 0, 98, 0, 98, 0, 0, 0, 0, 0, 0, '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 98, 0, 98, 0, 98, 0, 0, 0, 0, 0, 0, '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_barang_pelaporan`
--

CREATE TABLE `kategori_barang_pelaporan` (
  `id_kategori_barang_pelaporan` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listrik`
--

CREATE TABLE `listrik` (
  `id_listrik` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `sumber` varchar(191) NOT NULL,
  `banyaknya` double NOT NULL DEFAULT 0,
  `nilai` bigint(20) NOT NULL DEFAULT 0,
  `peruntukkan` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `listrik`
--

INSERT INTO `listrik` (`id_listrik`, `id_ikm`, `sumber`, `banyaknya`, `nilai`, `peruntukkan`, `created_at`, `updated_at`) VALUES
(1, 1, 'pln', 98, 98, 'Contoh', '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 'pln', 98, 98, 'Contoh', '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `mesin_produksi`
--

CREATE TABLE `mesin_produksi` (
  `id_mesin` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `jenis_mesin` varchar(191) NOT NULL,
  `nama_mesin` varchar(191) NOT NULL,
  `merk_type` varchar(191) NOT NULL,
  `teknologi` varchar(191) NOT NULL,
  `negara_pembuat` varchar(191) NOT NULL,
  `tahun_perolehan` int(11) NOT NULL,
  `tahun_pembuatan` int(11) NOT NULL,
  `jumlah_unit` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mesin_produksi`
--

INSERT INTO `mesin_produksi` (`id_mesin`, `id_ikm`, `jenis_mesin`, `nama_mesin`, `merk_type`, `teknologi`, `negara_pembuat`, `tahun_perolehan`, `tahun_pembuatan`, `jumlah_unit`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mesin', 'Contoh', 'Contoh', 'Contoh', 'Contoh', 2000, 2000, 98, '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 'Mesin', 'Contoh', 'Contoh', 'Contoh', 'Contoh', 2000, 2000, 98, '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_26_164150_create_disdag_table', 1),
(5, '2025_04_26_164536_create_berita_table', 1),
(6, '2025_04_27_154301_create_user_table', 1),
(7, '2025_04_28_120000_create_uttp_table', 1),
(8, '2025_04_28_121746_create_data_alat_ukur_table', 1),
(9, '2025_05_01_125413_create_distributor_table', 1),
(10, '2025_05_01_132307_create_kategori_barang_pelaporan_table', 1),
(11, '2025_05_01_132610_create_barang_pelaporan_table', 1),
(12, '2025_05_01_133122_create_rencana_kebutuhan_distributor_table', 1),
(13, '2025_05_01_133603_create_toko_table', 1),
(14, '2025_05_01_134203_create_stok_opname_table', 1),
(15, '2025_05_04_150736_create_index_kategori_table', 1),
(16, '2025_05_05_144358_create_barang_table', 1),
(17, '2025_05_05_151323_create_index_harga_table', 1),
(18, '2025_05_07_132826_create_form_permohonan_table', 1),
(19, '2025_05_07_134534_create_document_user_table', 1),
(20, '2025_05_08_234441_surat_metrologi', 1),
(21, '2025_05_12_214739_create_forum_diskusi_table', 1),
(22, '2025_05_16_224304_surat_balasan_metrologi', 1),
(23, '2025_05_18_160950_create_data_ikm_table', 1),
(24, '2025_05_18_161024_create_persentase_pemilik_table', 1),
(25, '2025_05_18_161125_create_karyawan_table', 1),
(26, '2025_05_18_161524_create_pemakaian_bahan_table', 1),
(27, '2025_05_18_161753_create_penggunaan_air_table', 1),
(28, '2025_05_18_162001_create_pengeluaran_table', 1),
(29, '2025_05_18_164222_create_penggunaan_bahan_bakar_table', 1),
(30, '2025_05_18_165530_create_listrik_table', 1),
(31, '2025_05_18_165840_create_mesin_produksi_table', 1),
(32, '2025_05_18_170434_create_produksi_table', 1),
(33, '2025_05_18_170651_create_persediaan_table', 1),
(34, '2025_05_18_170753_create_pendapatan_table', 1),
(35, '2025_05_18_170918_create_modal_table', 1),
(36, '2025_05_18_171042_create_bentuk_pengelolaan_limbah_table', 1),
(37, '2025_05_20_123024_create_sertifikasi_halal_table', 1),
(38, '2025_05_26_194815_create_faq_table', 1),
(39, '2025_05_28_062844_create_password_resets_table', 1),
(40, '2025_06_16_000840_create_pengaduan_distributors_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `modal`
--

CREATE TABLE `modal` (
  `id_modal` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `jenis_barang` varchar(191) NOT NULL,
  `pembelian_penambahan_perbaikan` bigint(20) NOT NULL DEFAULT 0,
  `pengurangan_barang_modal` bigint(20) NOT NULL DEFAULT 0,
  `penyusutan_barang` bigint(20) NOT NULL DEFAULT 0,
  `nilai_taksiran` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modal`
--

INSERT INTO `modal` (`id_modal`, `id_ikm`, `jenis_barang`, `pembelian_penambahan_perbaikan`, `pengurangan_barang_modal`, `penyusutan_barang`, `nilai_taksiran`, `created_at`, `updated_at`) VALUES
(1, 1, 'tanah', 98, 98, 98, 98, '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 'mesin dan perlengkapan', 100000000, 10000, 100, 100000, '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemakaian_bahan`
--

CREATE TABLE `pemakaian_bahan` (
  `id_pemakaian_bahan` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `nama_bahan` varchar(191) NOT NULL,
  `jenis_bahan` varchar(191) NOT NULL,
  `spesifikasi` varchar(191) NOT NULL,
  `kode_hs` varchar(191) NOT NULL,
  `satuan_standar` varchar(191) NOT NULL,
  `jumlah_dalam_negeri` int(11) NOT NULL,
  `nilai_dalam_negeri` bigint(20) NOT NULL,
  `jumlah_impor` int(11) NOT NULL,
  `nilai_impor` bigint(20) NOT NULL,
  `negara_asal_impor` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemakaian_bahan`
--

INSERT INTO `pemakaian_bahan` (`id_pemakaian_bahan`, `id_ikm`, `nama_bahan`, `jenis_bahan`, `spesifikasi`, `kode_hs`, `satuan_standar`, `jumlah_dalam_negeri`, `nilai_dalam_negeri`, `jumlah_impor`, `nilai_impor`, `negara_asal_impor`, `created_at`, `updated_at`) VALUES
(1, 1, 'Contoh', 'Bahan Baku', 'Contoh', 'Contoh', 'kg', 98, 98, 98, 98, 'Contoh', '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 'Contoh', 'Bahan Baku', 'Contoh', 'Contoh', 'ton', 98, 98, 98, 98, 'Contoh', '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `pendapatan`
--

CREATE TABLE `pendapatan` (
  `id_pendapatan` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `nilai` bigint(20) NOT NULL DEFAULT 0,
  `sumber` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pendapatan`
--

INSERT INTO `pendapatan` (`id_pendapatan`, `id_ikm`, `nilai`, `sumber`, `created_at`, `updated_at`) VALUES
(1, 1, 98, 'Contoh', '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 10000000, 'Contoh', '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan_distributors`
--

CREATE TABLE `pengaduan_distributors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(191) NOT NULL,
  `isi` text NOT NULL,
  `status` enum('menunggu','selesai') NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `upah_gaji` bigint(20) NOT NULL DEFAULT 0,
  `pengeluaran_industri_distribusi` bigint(20) NOT NULL DEFAULT 0,
  `pengeluaran_rnd` bigint(20) NOT NULL DEFAULT 0,
  `pengeluaran_tanah` bigint(20) NOT NULL DEFAULT 0,
  `pengeluaran_gedung` bigint(20) NOT NULL DEFAULT 0,
  `pengeluaran_mesin` bigint(20) NOT NULL DEFAULT 0,
  `lainnya` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`id_pengeluaran`, `id_ikm`, `upah_gaji`, `pengeluaran_industri_distribusi`, `pengeluaran_rnd`, `pengeluaran_tanah`, `pengeluaran_gedung`, `pengeluaran_mesin`, `lainnya`, `created_at`, `updated_at`) VALUES
(1, 1, 98, 98, 98, 98, 98, 98, 98, '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 10000, 10000, 10000, 10000, 10000, 10000, 10000, '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan_air`
--

CREATE TABLE `penggunaan_air` (
  `id_air` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `sumber_air` varchar(191) NOT NULL,
  `banyaknya_penggunaan_m3` double NOT NULL DEFAULT 0,
  `biaya` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penggunaan_air`
--

INSERT INTO `penggunaan_air` (`id_air`, `id_ikm`, `sumber_air`, `banyaknya_penggunaan_m3`, `biaya`, `created_at`, `updated_at`) VALUES
(1, 1, 'air_permukaan', 98, 98, '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 'perusahaan_penyedia_air', 98, 98, '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan_bahan_bakar`
--

CREATE TABLE `penggunaan_bahan_bakar` (
  `id_bahan_bakar` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `jenis_bahan_bakar` varchar(191) NOT NULL,
  `satuan_standar` varchar(191) NOT NULL,
  `banyaknya_proses_produksi` double NOT NULL DEFAULT 0,
  `nilai_proses_produksi` bigint(20) NOT NULL DEFAULT 0,
  `banyaknya_pembangkit_tenaga_listrik` double NOT NULL DEFAULT 0,
  `nilai_pembangkit_tenaga_listrik` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penggunaan_bahan_bakar`
--

INSERT INTO `penggunaan_bahan_bakar` (`id_bahan_bakar`, `id_ikm`, `jenis_bahan_bakar`, `satuan_standar`, `banyaknya_proses_produksi`, `nilai_proses_produksi`, `banyaknya_pembangkit_tenaga_listrik`, `nilai_pembangkit_tenaga_listrik`, `created_at`, `updated_at`) VALUES
(1, 1, 'bensin', 'liter', 98, 98, 98, 98, '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 'pelumas', 'liter', 98, 98, 98, 98, '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `persediaan`
--

CREATE TABLE `persediaan` (
  `id_persediaan` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `jenis_persediaan` varchar(191) NOT NULL,
  `awal` bigint(20) NOT NULL DEFAULT 0,
  `akhir` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `persediaan`
--

INSERT INTO `persediaan` (`id_persediaan`, `id_ikm`, `jenis_persediaan`, `awal`, `akhir`, `created_at`, `updated_at`) VALUES
(1, 1, 'persediaan_bahan', 98, 98, '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 'persediaan_bahan', 10000, 10000, '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `persentase_pemilik`
--

CREATE TABLE `persentase_pemilik` (
  `id_persentase` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `pemerintah_pusat` decimal(5,2) NOT NULL,
  `pemerintah_daerah` decimal(5,2) NOT NULL,
  `swasta_nasional` decimal(5,2) NOT NULL,
  `asing` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `persentase_pemilik`
--

INSERT INTO `persentase_pemilik` (`id_persentase`, `id_ikm`, `pemerintah_pusat`, `pemerintah_daerah`, `swasta_nasional`, `asing`, `created_at`, `updated_at`) VALUES
(1, 1, 10.00, 10.00, 10.00, 70.00, '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 10.00, 10.00, 10.00, 70.00, '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `produksi`
--

CREATE TABLE `produksi` (
  `id_produksi` bigint(20) UNSIGNED NOT NULL,
  `id_ikm` bigint(20) UNSIGNED NOT NULL,
  `jenis_produksi` varchar(191) NOT NULL,
  `kbli` varchar(191) NOT NULL,
  `kode_hs` varchar(191) NOT NULL,
  `spesifikasi` varchar(191) NOT NULL,
  `banyaknya` int(11) NOT NULL DEFAULT 0,
  `nilai` bigint(20) NOT NULL DEFAULT 0,
  `satuan` varchar(191) NOT NULL,
  `presentase_produk_ekspor` double NOT NULL DEFAULT 0,
  `negara_tujuan_ekspor` varchar(191) DEFAULT NULL,
  `kapasitas_terpasang_per_tahun` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produksi`
--

INSERT INTO `produksi` (`id_produksi`, `id_ikm`, `jenis_produksi`, `kbli`, `kode_hs`, `spesifikasi`, `banyaknya`, `nilai`, `satuan`, `presentase_produk_ekspor`, `negara_tujuan_ekspor`, `kapasitas_terpasang_per_tahun`, `created_at`, `updated_at`) VALUES
(1, 1, 'Contoh', 'Contoh', 'Contoh', 'Contoh', 98, 98, 'kg', 98, 'Contoh', 1900, '2025-06-09 21:09:43', '2025-06-09 21:09:43'),
(2, 2, 'Minya VCO', 'Contoh', 'Contoh', 'Contoh', 100, 98, 'liter', 98, 'Contoh', 1900, '2025-06-09 23:10:01', '2025-06-09 23:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `rencana_kebutuhan_distributor`
--

CREATE TABLE `rencana_kebutuhan_distributor` (
  `id_rancangan` bigint(20) UNSIGNED NOT NULL,
  `id_barang_pelaporan` bigint(20) UNSIGNED DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rencana_kebutuhan_distributor`
--

INSERT INTO `rencana_kebutuhan_distributor` (`id_rancangan`, `id_barang_pelaporan`, `tahun`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, NULL, '2025', 10000, '2025-06-09 07:30:32', '2025-06-09 07:30:32'),
(2, NULL, '2025', 10000, '2025-06-09 23:45:23', '2025-06-09 23:45:23');

-- --------------------------------------------------------

--
-- Table structure for table `sertifikasi_halal`
--

CREATE TABLE `sertifikasi_halal` (
  `id_halal` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `id_ikm` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_usaha` varchar(191) NOT NULL,
  `alamat` text NOT NULL,
  `no_sertifikasi_halal` varchar(191) NOT NULL,
  `tanggal_sah` date NOT NULL,
  `tanggal_exp` date NOT NULL,
  `sertifikat` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sertifikasi_halal`
--

INSERT INTO `sertifikasi_halal` (`id_halal`, `id_user`, `id_ikm`, `nama_usaha`, `alamat`, `no_sertifikasi_halal`, `tanggal_sah`, `tanggal_exp`, `sertifikat`, `status`, `created_at`, `updated_at`) VALUES
(2, NULL, NULL, 'Air Bersih', 'Jl, macan', '0928322', '2025-05-01', '2025-06-10', 'sertifikat_halal/1749540054Data.pdf', 'Berlaku', '2025-06-09 23:20:23', '2025-06-09 23:20:54');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('lMg46mbO68SjVkowEiTGBeHWTQ04qaQ1nUnIh8na', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiN0RLRG5BYmc1WW5jc1diRjU0cmJNdEVrMmxsbTRFWlBRN0pkMHBUVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly9zb2JhdGRhZ2FuZy5nby5pZC9rYWJpZC1wZXJkYWdhbmdhbi9kYXNoYm9hcmQiO31zOjUzOiJsb2dpbl9kaXNkYWdfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O3M6OToiaWRfZGlzZGFnIjtpOjU7fQ==', 1750085431),
('PZ7svx4vO9ih3xcJZOn1ihSxRvzbxtRTPM03wwMB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiQXl5RmVvSGlHOThTYlJvOW1hakZDaWI4Mk41ejFYWmJ5cE1OS0NaYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750085008);

-- --------------------------------------------------------

--
-- Table structure for table `stok_opname`
--

CREATE TABLE `stok_opname` (
  `id_stok_opname` bigint(20) UNSIGNED NOT NULL,
  `id_distributor` bigint(20) UNSIGNED NOT NULL,
  `id_toko` bigint(20) UNSIGNED NOT NULL,
  `stok_awal` int(11) NOT NULL,
  `penyaluran` int(11) NOT NULL,
  `stok_akhir` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_barang` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_opname`
--

INSERT INTO `stok_opname` (`id_stok_opname`, `id_distributor`, `id_toko`, `stok_awal`, `penyaluran`, `stok_akhir`, `tanggal`, `nama_barang`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 10, 9, 1, '2025-06-01', 'UREA', '2025-06-09 07:31:15', '2025-06-09 07:31:15'),
(2, 1, 1, 22, 18, 4, '2025-06-01', 'NPK', '2025-06-09 07:31:45', '2025-06-16 04:45:58'),
(3, 1, 1, 19, 17, 2, '2025-06-01', 'NPK-FK', '2025-06-09 07:32:01', '2025-06-09 07:32:01'),
(4, 1, 1, 18, 15, 3, '2025-06-09', 'NPK', '2025-06-09 07:32:23', '2025-06-09 07:32:23'),
(5, 1, 1, 20, 19, 1, '2025-06-09', 'UREA', '2025-06-09 07:32:39', '2025-06-09 07:32:39'),
(6, 1, 1, 21, 19, 2, '2025-06-09', 'NPK-FK', '2025-06-09 07:32:53', '2025-06-09 07:32:53'),
(7, 2, 2, 20, 19, 1, '2025-06-01', 'NPK', '2025-06-09 23:46:47', '2025-06-09 23:46:47'),
(8, 2, 2, 20, 17, 3, '2025-06-10', 'NPK', '2025-06-09 23:47:45', '2025-06-09 23:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluar_metrologi`
--

CREATE TABLE `surat_keluar_metrologi` (
  `id_surat_balasan` varchar(191) NOT NULL,
  `id_surat` varchar(191) NOT NULL,
  `tanggal` varchar(191) NOT NULL,
  `path_dokumen` varchar(191) DEFAULT NULL,
  `isi_surat` text DEFAULT NULL,
  `status_surat_keluar` enum('Menunggu','Disetujui','Ditolak','Draft') NOT NULL DEFAULT 'Menunggu',
  `status_kepalaBidang` enum('Menunggu','Disetujui','Ditolak','Draft') NOT NULL DEFAULT 'Menunggu',
  `status_kadis` enum('Menunggu','Disetujui','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `keterangan_kadis` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_keluar_metrologi`
--

INSERT INTO `surat_keluar_metrologi` (`id_surat_balasan`, `id_surat`, `tanggal`, `path_dokumen`, `isi_surat`, `status_surat_keluar`, `status_kepalaBidang`, `status_kadis`, `keterangan_kadis`, `created_at`, `updated_at`) VALUES
('01/02/Perdagangan', '58/01/Industri', '2025-06-10', 'surat_balasan/01_02_Perdagangan_20250610_045241.pdf', '<p>scdfgggggfgdgfd</p>', 'Menunggu', 'Disetujui', 'Disetujui', NULL, '2025-06-09 20:52:54', '2025-06-09 20:53:51'),
('02/02/Perdagangan', '15/0/Metro', '2025-06-10', 'surat_balasan/02_02_Perdagangan_20250610_073210.pdf', '<p>Diterima</p>', 'Menunggu', 'Disetujui', 'Disetujui', NULL, '2025-06-09 23:32:23', '2025-06-09 23:34:08');

-- --------------------------------------------------------

--
-- Table structure for table `surat_metrologi`
--

CREATE TABLE `surat_metrologi` (
  `id_surat` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `alamat_alat` varchar(191) DEFAULT NULL,
  `jenis_surat` enum('tera','tera_ulang') NOT NULL DEFAULT 'tera',
  `dokumen` varchar(191) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_surat_masuk` enum('Menunggu','Disetujui','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `status_admin` enum('Menunggu','Diproses','Ditolak','Menunggu Persetujuan','Diterima','Butuh Revisi','Selesai') NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_metrologi`
--

INSERT INTO `surat_metrologi` (`id_surat`, `user_id`, `alamat_alat`, `jenis_surat`, `dokumen`, `keterangan`, `status_surat_masuk`, `status_admin`, `created_at`, `updated_at`) VALUES
('15/0/Metro', 3, '-129923.384384', 'tera', 'surat_masuk_metrologi/15_0_Metro_3.pdf', NULL, 'Disetujui', 'Diterima', '2025-06-09 23:27:01', '2025-06-09 23:34:08'),
('58/01/Industri', 1, '-42291829.0293201', 'tera', 'surat_masuk_metrologi/58_01_Industri_1.pdf', NULL, 'Disetujui', 'Diterima', '2025-06-09 20:38:00', '2025-06-09 20:53:51');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id_toko` bigint(20) UNSIGNED NOT NULL,
  `id_rancangan` bigint(20) UNSIGNED NOT NULL,
  `id_distributor` bigint(20) UNSIGNED NOT NULL,
  `nama_toko` varchar(191) NOT NULL,
  `no_register` varchar(191) NOT NULL,
  `kecamatan` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id_toko`, `id_rancangan`, `id_distributor`, `nama_toko`, `no_register`, `kecamatan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Kepiting Gacor', '0921332', 'Bacukiki Barat', '2025-06-09 07:30:32', '2025-06-09 07:30:32'),
(2, 2, 2, 'Toko Uceng', '0923', 'Soreang', '2025-06-09 23:45:23', '2025-06-09 23:45:23');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `kecamatan` varchar(191) NOT NULL,
  `kelurahan` varchar(191) NOT NULL,
  `kabupaten` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `nik` varchar(191) NOT NULL,
  `nib` varchar(191) DEFAULT NULL,
  `nama` varchar(191) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `telp` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `avatar` varchar(191) DEFAULT 'assets/img/profil.jpeg',
  `verifikasi_token` varchar(191) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `kecamatan`, `kelurahan`, `kabupaten`, `password`, `nik`, `nib`, `nama`, `alamat_lengkap`, `jenis_kelamin`, `telp`, `email`, `avatar`, `verifikasi_token`, `is_verified`, `created_at`, `updated_at`) VALUES
(1, 'Bacukiki', 'WT. Bacukiki', 'Kota Parepare', '$2y$12$hAGNGNoxHUJrxD66p03cuOYydrMdLHmrrMsB94TT8qFVvH0x6L0pq', '3275091401010003', '2144123281', 'Robert smith y', 'jl,singa', 'Laki-laki', '083155990993', 'robertsmithy185@gmail.com', '1749530326_Robert Item.jpg', NULL, 1, '2025-06-09 05:51:28', '2025-06-09 20:38:46'),
(3, 'Ujung', 'Ujung Bulu', 'Kota Parepare', '$2y$12$j2oWUrk/mRYPTIAXCqkIjOg6Ga7lxQelCZ9uYwr/TA./2bRlicprK', '3275091401010001', '1234567889', 'Andi magfira maqbul', 'andifff12@gmail.com', 'Perempuan', '083155990993', 'andifff12@gmail.com', '1749537321_Robert Item.jpg', NULL, 1, '2025-06-09 22:33:26', '2025-06-09 22:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uttp`
--

CREATE TABLE `uttp` (
  `id_uttp` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_penginputan` date DEFAULT NULL,
  `no_registrasi` varchar(191) DEFAULT NULL,
  `nama_usaha` varchar(191) DEFAULT NULL,
  `jenis_alat` varchar(191) DEFAULT NULL,
  `nama_alat` varchar(191) DEFAULT NULL,
  `merk_type` varchar(191) DEFAULT NULL,
  `nomor_seri` varchar(191) DEFAULT NULL,
  `jumlah_alat` int(11) DEFAULT NULL,
  `alat_penguji` varchar(191) DEFAULT NULL,
  `ctt` varchar(191) DEFAULT NULL,
  `spt_keperluan` varchar(191) DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `terapan` varchar(191) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `sertifikat_path` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uttp`
--

INSERT INTO `uttp` (`id_uttp`, `id_user`, `tanggal_penginputan`, `no_registrasi`, `nama_usaha`, `jenis_alat`, `nama_alat`, `merk_type`, `nomor_seri`, `jumlah_alat`, `alat_penguji`, `ctt`, `spt_keperluan`, `tanggal_selesai`, `terapan`, `keterangan`, `sertifikat_path`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-06-17', '2039112', 'Ternak udang', 'MAS-TE', '100', 'Udang Gacor', '21203', NULL, 'AT', 'SL6', '20122321', '2024-06-17', NULL, 'Tera Ulang', 'sertifikat/rDzhIpMnmCscPQ7anVx7CUGFxRfFnCcnvdd5ExKC.pdf', '2025-06-09 21:19:30', '2025-06-09 21:19:30'),
(2, 3, '2024-06-17', '2039111', 'PT Pertamina', 'VOL-PUBBM', '10000', 'Bensin', '21203', NULL, 'BUS', 'J4', '20122321', '2024-06-17', NULL, 'Tera', 'sertifikat/TgyOYVHa8rCN7UW2LqJSNEFqCMnFo5M98dCKrtt3.pdf', '2025-06-09 23:38:18', '2025-06-09 23:38:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `barang_id_index_kategori_foreign` (`id_index_kategori`);

--
-- Indexes for table `barang_pelaporan`
--
ALTER TABLE `barang_pelaporan`
  ADD PRIMARY KEY (`id_barang_pelaporan`),
  ADD KEY `barang_pelaporan_id_kategori_barang_pelaporan_foreign` (`id_kategori_barang_pelaporan`);

--
-- Indexes for table `bentuk_pengelolaan_limbah`
--
ALTER TABLE `bentuk_pengelolaan_limbah`
  ADD PRIMARY KEY (`id_bentuk`),
  ADD KEY `bentuk_pengelolaan_limbah_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`),
  ADD KEY `berita_id_disdag_foreign` (`id_disdag`);

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
-- Indexes for table `data_alat_ukur`
--
ALTER TABLE `data_alat_ukur`
  ADD PRIMARY KEY (`id_data_alat`),
  ADD KEY `data_alat_ukur_id_uttp_foreign` (`id_uttp`);

--
-- Indexes for table `data_ikm`
--
ALTER TABLE `data_ikm`
  ADD PRIMARY KEY (`id_ikm`);

--
-- Indexes for table `disdag`
--
ALTER TABLE `disdag`
  ADD PRIMARY KEY (`id_disdag`),
  ADD UNIQUE KEY `disdag_nip_unique` (`nip`),
  ADD UNIQUE KEY `disdag_email_unique` (`email`);

--
-- Indexes for table `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`id_distributor`),
  ADD KEY `distributor_id_user_foreign` (`id_user`);

--
-- Indexes for table `document_user`
--
ALTER TABLE `document_user`
  ADD PRIMARY KEY (`id_document`),
  ADD KEY `document_user_id_permohonan_foreign` (`id_permohonan`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_permohonan`
--
ALTER TABLE `form_permohonan`
  ADD PRIMARY KEY (`id_permohonan`),
  ADD KEY `form_permohonan_id_user_foreign` (`id_user`);

--
-- Indexes for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `forum_diskusi_id_user_foreign` (`id_user`),
  ADD KEY `forum_diskusi_id_disdag_foreign` (`id_disdag`);

--
-- Indexes for table `index_harga`
--
ALTER TABLE `index_harga`
  ADD PRIMARY KEY (`id_index`),
  ADD KEY `index_harga_id_barang_foreign` (`id_barang`),
  ADD KEY `index_harga_id_index_kategori_foreign` (`id_index_kategori`);

--
-- Indexes for table `index_kategori`
--
ALTER TABLE `index_kategori`
  ADD PRIMARY KEY (`id_index_kategori`);

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
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD KEY `karyawan_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `kategori_barang_pelaporan`
--
ALTER TABLE `kategori_barang_pelaporan`
  ADD PRIMARY KEY (`id_kategori_barang_pelaporan`);

--
-- Indexes for table `listrik`
--
ALTER TABLE `listrik`
  ADD PRIMARY KEY (`id_listrik`),
  ADD KEY `listrik_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `mesin_produksi`
--
ALTER TABLE `mesin_produksi`
  ADD PRIMARY KEY (`id_mesin`),
  ADD KEY `mesin_produksi_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modal`
--
ALTER TABLE `modal`
  ADD PRIMARY KEY (`id_modal`),
  ADD KEY `modal_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pemakaian_bahan`
--
ALTER TABLE `pemakaian_bahan`
  ADD PRIMARY KEY (`id_pemakaian_bahan`),
  ADD KEY `pemakaian_bahan_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `pendapatan`
--
ALTER TABLE `pendapatan`
  ADD PRIMARY KEY (`id_pendapatan`),
  ADD KEY `pendapatan_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `pengaduan_distributors`
--
ALTER TABLE `pengaduan_distributors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaduan_distributors_user_id_foreign` (`user_id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`),
  ADD KEY `pengeluaran_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `penggunaan_air`
--
ALTER TABLE `penggunaan_air`
  ADD PRIMARY KEY (`id_air`),
  ADD KEY `penggunaan_air_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `penggunaan_bahan_bakar`
--
ALTER TABLE `penggunaan_bahan_bakar`
  ADD PRIMARY KEY (`id_bahan_bakar`),
  ADD KEY `penggunaan_bahan_bakar_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `persediaan`
--
ALTER TABLE `persediaan`
  ADD PRIMARY KEY (`id_persediaan`),
  ADD KEY `persediaan_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `persentase_pemilik`
--
ALTER TABLE `persentase_pemilik`
  ADD PRIMARY KEY (`id_persentase`),
  ADD KEY `persentase_pemilik_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `produksi`
--
ALTER TABLE `produksi`
  ADD PRIMARY KEY (`id_produksi`),
  ADD KEY `produksi_id_ikm_foreign` (`id_ikm`);

--
-- Indexes for table `rencana_kebutuhan_distributor`
--
ALTER TABLE `rencana_kebutuhan_distributor`
  ADD PRIMARY KEY (`id_rancangan`),
  ADD KEY `rencana_kebutuhan_distributor_id_barang_pelaporan_foreign` (`id_barang_pelaporan`);

--
-- Indexes for table `sertifikasi_halal`
--
ALTER TABLE `sertifikasi_halal`
  ADD PRIMARY KEY (`id_halal`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD PRIMARY KEY (`id_stok_opname`),
  ADD KEY `stok_opname_id_distributor_foreign` (`id_distributor`),
  ADD KEY `stok_opname_id_toko_foreign` (`id_toko`);

--
-- Indexes for table `surat_keluar_metrologi`
--
ALTER TABLE `surat_keluar_metrologi`
  ADD PRIMARY KEY (`id_surat_balasan`),
  ADD KEY `surat_keluar_metrologi_id_surat_foreign` (`id_surat`);

--
-- Indexes for table `surat_metrologi`
--
ALTER TABLE `surat_metrologi`
  ADD PRIMARY KEY (`id_surat`),
  ADD KEY `surat_metrologi_user_id_foreign` (`user_id`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_toko`),
  ADD KEY `toko_id_rancangan_foreign` (`id_rancangan`),
  ADD KEY `toko_id_distributor_foreign` (`id_distributor`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `user_nik_unique` (`nik`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `uttp`
--
ALTER TABLE `uttp`
  ADD PRIMARY KEY (`id_uttp`),
  ADD KEY `uttp_id_user_foreign` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `barang_pelaporan`
--
ALTER TABLE `barang_pelaporan`
  MODIFY `id_barang_pelaporan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bentuk_pengelolaan_limbah`
--
ALTER TABLE `bentuk_pengelolaan_limbah`
  MODIFY `id_bentuk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_alat_ukur`
--
ALTER TABLE `data_alat_ukur`
  MODIFY `id_data_alat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_ikm`
--
ALTER TABLE `data_ikm`
  MODIFY `id_ikm` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `disdag`
--
ALTER TABLE `disdag`
  MODIFY `id_disdag` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `distributor`
--
ALTER TABLE `distributor`
  MODIFY `id_distributor` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `document_user`
--
ALTER TABLE `document_user`
  MODIFY `id_document` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  MODIFY `id_pengaduan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `index_harga`
--
ALTER TABLE `index_harga`
  MODIFY `id_index` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `index_kategori`
--
ALTER TABLE `index_kategori`
  MODIFY `id_index_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategori_barang_pelaporan`
--
ALTER TABLE `kategori_barang_pelaporan`
  MODIFY `id_kategori_barang_pelaporan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listrik`
--
ALTER TABLE `listrik`
  MODIFY `id_listrik` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mesin_produksi`
--
ALTER TABLE `mesin_produksi`
  MODIFY `id_mesin` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `modal`
--
ALTER TABLE `modal`
  MODIFY `id_modal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pemakaian_bahan`
--
ALTER TABLE `pemakaian_bahan`
  MODIFY `id_pemakaian_bahan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pendapatan`
--
ALTER TABLE `pendapatan`
  MODIFY `id_pendapatan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengaduan_distributors`
--
ALTER TABLE `pengaduan_distributors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penggunaan_air`
--
ALTER TABLE `penggunaan_air`
  MODIFY `id_air` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penggunaan_bahan_bakar`
--
ALTER TABLE `penggunaan_bahan_bakar`
  MODIFY `id_bahan_bakar` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `persediaan`
--
ALTER TABLE `persediaan`
  MODIFY `id_persediaan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `persentase_pemilik`
--
ALTER TABLE `persentase_pemilik`
  MODIFY `id_persentase` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produksi`
--
ALTER TABLE `produksi`
  MODIFY `id_produksi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rencana_kebutuhan_distributor`
--
ALTER TABLE `rencana_kebutuhan_distributor`
  MODIFY `id_rancangan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sertifikasi_halal`
--
ALTER TABLE `sertifikasi_halal`
  MODIFY `id_halal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stok_opname`
--
ALTER TABLE `stok_opname`
  MODIFY `id_stok_opname` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uttp`
--
ALTER TABLE `uttp`
  MODIFY `id_uttp` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_id_index_kategori_foreign` FOREIGN KEY (`id_index_kategori`) REFERENCES `index_kategori` (`id_index_kategori`) ON DELETE CASCADE;

--
-- Constraints for table `barang_pelaporan`
--
ALTER TABLE `barang_pelaporan`
  ADD CONSTRAINT `barang_pelaporan_id_kategori_barang_pelaporan_foreign` FOREIGN KEY (`id_kategori_barang_pelaporan`) REFERENCES `kategori_barang_pelaporan` (`id_kategori_barang_pelaporan`) ON DELETE CASCADE;

--
-- Constraints for table `bentuk_pengelolaan_limbah`
--
ALTER TABLE `bentuk_pengelolaan_limbah`
  ADD CONSTRAINT `bentuk_pengelolaan_limbah_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_id_disdag_foreign` FOREIGN KEY (`id_disdag`) REFERENCES `disdag` (`id_disdag`) ON DELETE CASCADE;

--
-- Constraints for table `data_alat_ukur`
--
ALTER TABLE `data_alat_ukur`
  ADD CONSTRAINT `data_alat_ukur_id_uttp_foreign` FOREIGN KEY (`id_uttp`) REFERENCES `uttp` (`id_uttp`) ON DELETE CASCADE;

--
-- Constraints for table `distributor`
--
ALTER TABLE `distributor`
  ADD CONSTRAINT `distributor_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `document_user`
--
ALTER TABLE `document_user`
  ADD CONSTRAINT `document_user_id_permohonan_foreign` FOREIGN KEY (`id_permohonan`) REFERENCES `form_permohonan` (`id_permohonan`) ON DELETE CASCADE;

--
-- Constraints for table `form_permohonan`
--
ALTER TABLE `form_permohonan`
  ADD CONSTRAINT `form_permohonan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `forum_diskusi`
--
ALTER TABLE `forum_diskusi`
  ADD CONSTRAINT `forum_diskusi_id_disdag_foreign` FOREIGN KEY (`id_disdag`) REFERENCES `disdag` (`id_disdag`) ON DELETE CASCADE,
  ADD CONSTRAINT `forum_diskusi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `index_harga`
--
ALTER TABLE `index_harga`
  ADD CONSTRAINT `index_harga_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE,
  ADD CONSTRAINT `index_harga_id_index_kategori_foreign` FOREIGN KEY (`id_index_kategori`) REFERENCES `index_kategori` (`id_index_kategori`) ON DELETE CASCADE;

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `listrik`
--
ALTER TABLE `listrik`
  ADD CONSTRAINT `listrik_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `mesin_produksi`
--
ALTER TABLE `mesin_produksi`
  ADD CONSTRAINT `mesin_produksi_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `modal`
--
ALTER TABLE `modal`
  ADD CONSTRAINT `modal_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `pemakaian_bahan`
--
ALTER TABLE `pemakaian_bahan`
  ADD CONSTRAINT `pemakaian_bahan_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `pendapatan`
--
ALTER TABLE `pendapatan`
  ADD CONSTRAINT `pendapatan_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `pengaduan_distributors`
--
ALTER TABLE `pengaduan_distributors`
  ADD CONSTRAINT `pengaduan_distributors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD CONSTRAINT `pengeluaran_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `penggunaan_air`
--
ALTER TABLE `penggunaan_air`
  ADD CONSTRAINT `penggunaan_air_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `penggunaan_bahan_bakar`
--
ALTER TABLE `penggunaan_bahan_bakar`
  ADD CONSTRAINT `penggunaan_bahan_bakar_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `persediaan`
--
ALTER TABLE `persediaan`
  ADD CONSTRAINT `persediaan_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `persentase_pemilik`
--
ALTER TABLE `persentase_pemilik`
  ADD CONSTRAINT `persentase_pemilik_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `produksi`
--
ALTER TABLE `produksi`
  ADD CONSTRAINT `produksi_id_ikm_foreign` FOREIGN KEY (`id_ikm`) REFERENCES `data_ikm` (`id_ikm`) ON DELETE CASCADE;

--
-- Constraints for table `rencana_kebutuhan_distributor`
--
ALTER TABLE `rencana_kebutuhan_distributor`
  ADD CONSTRAINT `rencana_kebutuhan_distributor_id_barang_pelaporan_foreign` FOREIGN KEY (`id_barang_pelaporan`) REFERENCES `barang_pelaporan` (`id_barang_pelaporan`) ON DELETE CASCADE;

--
-- Constraints for table `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD CONSTRAINT `stok_opname_id_distributor_foreign` FOREIGN KEY (`id_distributor`) REFERENCES `distributor` (`id_distributor`) ON DELETE CASCADE,
  ADD CONSTRAINT `stok_opname_id_toko_foreign` FOREIGN KEY (`id_toko`) REFERENCES `toko` (`id_toko`) ON DELETE CASCADE;

--
-- Constraints for table `surat_keluar_metrologi`
--
ALTER TABLE `surat_keluar_metrologi`
  ADD CONSTRAINT `surat_keluar_metrologi_id_surat_foreign` FOREIGN KEY (`id_surat`) REFERENCES `surat_metrologi` (`id_surat`) ON DELETE CASCADE;

--
-- Constraints for table `surat_metrologi`
--
ALTER TABLE `surat_metrologi`
  ADD CONSTRAINT `surat_metrologi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `toko`
--
ALTER TABLE `toko`
  ADD CONSTRAINT `toko_id_distributor_foreign` FOREIGN KEY (`id_distributor`) REFERENCES `distributor` (`id_distributor`) ON DELETE CASCADE,
  ADD CONSTRAINT `toko_id_rancangan_foreign` FOREIGN KEY (`id_rancangan`) REFERENCES `rencana_kebutuhan_distributor` (`id_rancangan`) ON DELETE CASCADE;

--
-- Constraints for table `uttp`
--
ALTER TABLE `uttp`
  ADD CONSTRAINT `uttp_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
