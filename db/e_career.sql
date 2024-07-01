-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2024 at 03:58 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_career`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alumni`
--

CREATE TABLE `tbl_alumni` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pengguna` int(10) UNSIGNED DEFAULT NULL,
  `id_kelas` int(10) UNSIGNED DEFAULT NULL,
  `nisn` varchar(10) NOT NULL,
  `nama_alumni` varchar(128) NOT NULL,
  `jk` enum('l','p') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tmp_lahir` varchar(64) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `no_telp` varchar(16) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_alumni`
--

INSERT INTO `tbl_alumni` (`id`, `id_pengguna`, `id_kelas`, `nisn`, `nama_alumni`, `jk`, `alamat`, `tmp_lahir`, `tgl_lahir`, `no_telp`, `email`, `created_at`, `updated_at`) VALUES
(1, 23, 31, '9991814928', 'Okta Alfiansyah', 'l', 'Kertapati', 'Palembang', '1999-10-10', '6262620877990550', 'oktaalfiansyah@gmail.com', '2024-06-30 02:43:23', '2024-06-30 02:43:23'),
(3, 24, 31, '9991814872', 'Bima Satria', 'l', 'Gang Duren', 'Palembang', '2024-05-08', '087765432345', 'bimasatria@gmail.com', '2024-06-30 02:44:24', '2024-06-30 02:44:24'),
(4, NULL, 31, '9997672534', 'Arief Rahman', 'l', 'Jakabaring', 'Palembang', '2024-05-27', '087700111100', 'ariefrahman@gmail.com', '2024-06-30 02:44:24', '2024-06-30 02:44:24'),
(5, NULL, 31, '9987652345', 'Benny Setiawan', 'l', 'Palembang', 'Palembang', '1998-05-01', '6262620819920019', 'bennysetiawan@gmail.com', '2024-06-30 02:44:24', '2024-06-30 02:44:24'),
(6, NULL, 31, '1278567890', 'Nelam Salmah', 'l', 'Palembang', 'Palembang', '1999-06-12', '6262626208786523', 'nelamsalmah@gmail.com', '2024-06-30 13:16:11', '2024-06-30 13:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guru`
--

CREATE TABLE `tbl_guru` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pengguna` int(10) UNSIGNED DEFAULT NULL,
  `id_jabatan` int(10) UNSIGNED DEFAULT NULL,
  `id_pangkat_golongan` int(10) UNSIGNED DEFAULT NULL,
  `id_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `id_jurusan_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `nip` varchar(18) NOT NULL,
  `nama_guru` varchar(128) NOT NULL,
  `jk` enum('l','p') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tmp_lahir` varchar(64) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tahun_ijazah` year(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_guru`
--

INSERT INTO `tbl_guru` (`id`, `id_pengguna`, `id_jabatan`, `id_pangkat_golongan`, `id_pendidikan`, `id_jurusan_pendidikan`, `nip`, `nama_guru`, `jk`, `alamat`, `tmp_lahir`, `tgl_lahir`, `tahun_ijazah`, `created_at`, `updated_at`) VALUES
(1, 25, 1, 1, 9, 4, '196506121990022003', 'Sukarti', 'l', 'Palembang', 'Palembang', '2024-05-01', 2009, '2024-05-23 08:29:39', '2024-06-27 18:20:41'),
(4, NULL, 5, 9, 9, 4, '199204202015031006', 'Della Rizky Andini', 'l', 'Plaju', 'Palembang', '2024-05-06', 2014, '2024-05-25 17:52:18', '2024-06-24 12:14:30'),
(5, NULL, 5, 9, 9, 4, '198912252019022005', 'Sudaryani', 'p', 'Plaju', 'Prabumulih', '2020-04-30', 2011, '2024-05-25 17:53:27', '2024-06-24 12:11:48'),
(6, NULL, 5, 9, 9, 4, '1988103020201901', 'Sulastinah', 'p', 'Plaju', 'Prabumulih', '2024-05-05', 2010, '2024-05-26 09:59:45', '2024-06-24 12:11:48'),
(7, NULL, 4, 5, 10, 37, '1234567890123456', 'Abdul Kadir, M.Kom.', 'l', 'Depok', 'Depok', '2024-04-30', 2010, '2024-06-10 15:46:11', '2024-06-24 12:14:30'),
(8, NULL, 5, 5, 9, 33, '9999999999888777', 'Nur Widyasti', 'p', 'Palembang', 'Palembang', '2024-03-31', 2010, '2024-06-10 18:02:33', '2024-06-24 12:14:30'),
(9, NULL, 5, 4, 9, 34, '1979762520140320', 'Susmayasari', 'p', 'Palembang', 'Palembang', '2024-05-26', 2014, '2024-06-10 19:01:29', '2024-06-24 12:14:30'),
(10, 35, 5, 4, 9, 4, '1989986520190220', 'Nunsianah', 'p', 'Plaju', 'Palembang', '2024-05-26', 2010, '2024-06-10 19:02:12', '2024-06-27 14:46:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jabatan`
--

CREATE TABLE `tbl_jabatan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jabatan`
--

INSERT INTO `tbl_jabatan` (`id`, `nama_jabatan`, `created_at`, `updated_at`) VALUES
(1, 'Kepala Sekolah', '2024-05-20 12:45:34', NULL),
(2, 'Wakil Kepala Sekolah', '2024-05-20 12:45:34', NULL),
(3, 'Bendahara', '2024-05-20 12:45:34', NULL),
(4, 'Tata Usaha/Administrasi', '2024-05-20 12:45:34', NULL),
(5, 'Wali Kelas', '2024-05-20 12:45:34', NULL),
(6, 'Piket', '2024-05-20 12:45:34', NULL),
(7, 'Bimbingan Konseling', '2024-05-20 12:45:34', NULL),
(8, 'Penjaga Sekolah', '2024-05-20 12:45:34', NULL),
(9, 'Kebersihan', '2024-05-20 12:45:34', '2024-05-20 12:53:45'),
(10, 'Tenaga Administrasi Sekolah', '2024-05-20 12:45:34', NULL),
(11, 'Perpustakaan', '2024-05-20 12:45:34', NULL),
(12, 'Operator', '2024-05-20 12:45:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jenis_pekerjaan`
--

CREATE TABLE `tbl_jenis_pekerjaan` (
  `id` int(10) UNSIGNED NOT NULL,
  `jenis_pekerjaan` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jenis_pekerjaan`
--

INSERT INTO `tbl_jenis_pekerjaan` (`id`, `jenis_pekerjaan`, `created_at`, `updated_at`) VALUES
(1, 'Full Time', '2024-06-30 01:13:59', '2024-06-30 14:04:31'),
(2, 'Part Time', '2024-06-30 01:13:59', '2024-06-30 14:04:34'),
(3, 'Internship', '2024-06-30 01:13:59', '2024-06-30 14:04:39'),
(4, 'Remote', '2024-06-30 01:13:59', '2024-06-30 14:04:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jenis_perusahaan`
--

CREATE TABLE `tbl_jenis_perusahaan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_jenis` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jenis_perusahaan`
--

INSERT INTO `tbl_jenis_perusahaan` (`id`, `nama_jenis`, `created_at`, `updated_at`) VALUES
(1, 'Industri', '2024-06-26 11:15:49', NULL),
(2, 'Perdangan', '2024-06-26 11:15:57', NULL),
(3, 'Jasa', '2024-06-26 11:16:06', NULL),
(4, 'Ekstraktif', '2024-06-26 11:16:16', NULL),
(5, 'Agraris', '2024-06-26 11:16:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jurusan_pendidikan`
--

CREATE TABLE `tbl_jurusan_pendidikan` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `nama_jurusan` varchar(128) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jurusan_pendidikan`
--

INSERT INTO `tbl_jurusan_pendidikan` (`id`, `id_pendidikan`, `nama_jurusan`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Tidak Ada', '2024-05-11 19:22:50', NULL),
(2, 4, 'IPA', '2024-05-11 19:22:50', '2024-05-13 14:09:23'),
(3, 4, 'IPS', '2024-05-11 19:22:50', '2024-05-13 14:09:34'),
(4, 9, 'Sistem Informasi', '2024-05-11 19:22:50', '2024-05-13 14:09:58'),
(5, 9, 'Psikologi', '2024-05-11 19:22:50', '2024-05-13 14:10:04'),
(8, 4, 'Lainnya', '2024-05-13 14:13:00', NULL),
(9, 5, 'Lainnya', '2024-05-13 14:13:01', NULL),
(10, 6, 'Lainnya', '2024-05-13 14:13:01', NULL),
(11, 7, 'Lainnya', '2024-05-13 14:13:01', NULL),
(12, 8, 'Lainnya', '2024-05-13 14:13:01', NULL),
(13, 9, 'Lainnya', '2024-05-13 14:13:01', NULL),
(14, 10, 'Lainnya', '2024-05-13 14:13:01', NULL),
(15, 11, 'Lainnya', '2024-05-13 14:13:01', NULL),
(16, 9, 'Teknik Elektro', '2024-05-13 16:37:09', NULL),
(28, 8, 'Some \\&quot;\'  string &amp;amp; to Sanitize &amp;lt; !$@%', '2024-05-13 18:05:45', '2024-05-13 18:12:16'),
(29, 9, 'Pendidikan Agama Islam', '2024-05-17 05:11:41', NULL),
(30, 9, 'Hukum', '2024-05-19 18:35:55', NULL),
(32, 9, 'Psikologi', '2024-05-23 04:32:24', NULL),
(33, 9, 'Bahasa Indonesia', '2024-05-23 10:55:19', NULL),
(34, 9, 'Fisika', '2024-05-23 16:27:45', NULL),
(35, 9, 'Matematika', '2024-05-25 17:35:34', NULL),
(36, 9, 'Geografi', '2024-05-26 09:59:36', NULL),
(37, 10, 'Sistem Informasi', '2024-06-10 15:56:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_keahlian_alumni`
--

CREATE TABLE `tbl_keahlian_alumni` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_alumni` int(10) UNSIGNED NOT NULL,
  `nama_keahlian` varchar(128) NOT NULL,
  `file_keahlian` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_keahlian_alumni`
--

INSERT INTO `tbl_keahlian_alumni` (`id`, `id_alumni`, `nama_keahlian`, `file_keahlian`, `created_at`, `updated_at`) VALUES
(5, 1, 'Problem Solving', '961a51ca2ba7a323ae29ea897441e86d7d2e4488494d5590572f1e05df8f52bc.pdf', '2024-06-24 19:39:28', NULL),
(6, 3, 'CCNA', 'fc31ae21393b48613f0e01f9769188a310b4e27bd1bb8d2e132347e7892aa9dc.pdf', '2024-06-24 19:57:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelas`
--

CREATE TABLE `tbl_kelas` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_wali_kelas` int(10) UNSIGNED DEFAULT NULL,
  `nama_kelas` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kelas`
--

INSERT INTO `tbl_kelas` (`id`, `id_wali_kelas`, `nama_kelas`, `created_at`, `updated_at`) VALUES
(1, 8, 'X TKJ 1', '2024-06-30 02:43:08', NULL),
(2, 8, 'X TKJ 2', '2024-06-30 02:43:08', NULL),
(3, 8, 'X TKJ 3', '2024-06-30 02:43:08', NULL),
(4, 8, 'X AP 1', '2024-06-30 02:43:08', NULL),
(5, 8, 'X AP 2', '2024-06-30 02:43:08', NULL),
(6, 8, 'X AP 3', '2024-06-30 02:43:08', NULL),
(7, 8, 'X AK 1', '2024-06-30 02:43:08', NULL),
(8, 8, 'X AK 2', '2024-06-30 02:43:08', NULL),
(9, 8, 'X AK 3', '2024-06-30 02:43:08', NULL),
(10, 8, 'X TKR 1', '2024-06-30 02:43:08', NULL),
(11, 8, 'X TKR 2', '2024-06-30 02:43:08', NULL),
(12, 8, 'X TKR 3', '2024-06-30 02:43:08', NULL),
(13, 8, 'X ADM 1', '2024-06-30 02:43:08', NULL),
(14, 8, 'X ADM 2', '2024-06-30 02:43:08', NULL),
(15, 8, 'X ADM 3', '2024-06-30 02:43:08', NULL),
(16, 8, 'XI TKJ 1', '2024-06-30 02:43:08', NULL),
(17, 8, 'XI TKJ 2', '2024-06-30 02:43:08', NULL),
(18, 8, 'XI TKJ 3', '2024-06-30 02:43:08', NULL),
(19, 8, 'XI AP 1', '2024-06-30 02:43:08', NULL),
(20, 8, 'XI AP 2', '2024-06-30 02:43:08', NULL),
(21, 8, 'XI AP 3', '2024-06-30 02:43:08', NULL),
(22, 8, 'XI AK 1', '2024-06-30 02:43:08', NULL),
(23, 8, 'XI AK 2', '2024-06-30 02:43:08', NULL),
(24, 8, 'XI AK 3', '2024-06-30 02:43:08', NULL),
(25, 8, 'XI TKR 1', '2024-06-30 02:43:08', NULL),
(26, 8, 'XI TKR 2', '2024-06-30 02:43:08', NULL),
(27, 8, 'XI TKR 3', '2024-06-30 02:43:08', NULL),
(28, 8, 'XI ADM 1', '2024-06-30 02:43:08', NULL),
(29, 8, 'XI ADM 2', '2024-06-30 02:43:08', NULL),
(30, 8, 'XI ADM 3', '2024-06-30 02:43:08', NULL),
(31, 8, 'XII TKJ 1', '2024-06-30 02:43:08', NULL),
(32, 8, 'XII TKJ 2', '2024-06-30 02:43:08', NULL),
(33, 8, 'XII TKJ 3', '2024-06-30 02:43:08', NULL),
(34, 8, 'XII AP 1', '2024-06-30 02:43:08', NULL),
(35, 8, 'XII AP 2', '2024-06-30 02:43:08', NULL),
(36, 8, 'XII AP 3', '2024-06-30 02:43:08', NULL),
(37, 8, 'XII AK 1', '2024-06-30 02:43:08', NULL),
(38, 8, 'XII AK 2', '2024-06-30 02:43:08', NULL),
(39, 8, 'XII AK 3', '2024-06-30 02:43:08', NULL),
(40, 8, 'XII TKR 1', '2024-06-30 02:43:08', NULL),
(41, 8, 'XII TKR 2', '2024-06-30 02:43:08', NULL),
(42, 8, 'XII TKR 3', '2024-06-30 02:43:08', NULL),
(43, 8, 'XII ADM 1', '2024-06-30 02:43:08', NULL),
(44, 8, 'XII ADM 2', '2024-06-30 02:43:08', NULL),
(45, 8, 'XII ADM 3', '2024-06-30 02:43:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_klasifikasi_pekerjaan`
--

CREATE TABLE `tbl_klasifikasi_pekerjaan` (
  `id` int(10) UNSIGNED NOT NULL,
  `klasifikasi_pekerjaan` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_klasifikasi_pekerjaan`
--

INSERT INTO `tbl_klasifikasi_pekerjaan` (`id`, `klasifikasi_pekerjaan`, `created_at`, `updated_at`) VALUES
(1, 'Akuntansi', '2024-06-30 01:06:47', NULL),
(2, 'Administrasi & Dukungan Perkantoran', '2024-06-30 01:06:47', NULL),
(3, 'Periklanan, Seni & Media', '2024-06-30 01:06:47', NULL),
(4, 'Perbankan & Layanan Finansial', '2024-06-30 01:06:47', NULL),
(5, 'Call Center & Layanan Konsumen', '2024-06-30 01:06:47', NULL),
(6, 'CEO & Manajemen Umum', '2024-06-30 01:06:47', NULL),
(7, 'Layanan & Pengembangan Masyarakat', '2024-06-30 01:06:47', NULL),
(8, 'Konstruksi', '2024-06-30 01:06:47', NULL),
(9, 'Konsultasi & Strategi', '2024-06-30 01:06:47', NULL),
(10, 'Desain & Arsitektur', '2024-06-30 01:06:47', NULL),
(11, 'Pendidikan & Pelatihan', '2024-06-30 01:06:47', NULL),
(12, 'Teknik', '2024-06-30 01:06:47', NULL),
(13, 'Pertanian, Hewan & Konservasi', '2024-06-30 01:06:47', NULL),
(14, 'Pemerintahan & Pertahanan', '2024-06-30 01:06:47', NULL),
(15, 'Kesehatan & Medis', '2024-06-30 01:06:47', NULL),
(16, 'Hospitaliti & Pariwisata', '2024-06-30 01:06:47', NULL),
(17, 'Sumber Daya Manusia & Perekrutan', '2024-06-30 01:06:47', NULL),
(18, 'Teknologi Informasi & Komunikasi', '2024-06-30 01:06:47', NULL),
(19, 'Asuransi & Dana Pensiun', '2024-06-30 01:06:47', NULL),
(20, 'Hukum', '2024-06-30 01:06:47', NULL),
(21, 'Manufaktur, Transportasi & Logistik', '2024-06-30 01:06:47', NULL),
(22, 'Pemasaran & Komunikasi', '2024-06-30 01:06:47', NULL),
(23, 'Pertambangan, Sumber Daya Alam & Energi', '2024-06-30 01:06:47', NULL),
(24, 'Real Estat & Properti', '2024-06-30 01:06:47', NULL),
(25, 'Ritel & Produk Konsumen', '2024-06-30 01:06:47', NULL),
(26, 'Penjualan', '2024-06-30 01:06:47', NULL),
(27, 'Sains & Teknologi', '2024-06-30 01:06:47', NULL),
(28, 'Pekerjaan Lepas', '2024-06-30 01:06:47', NULL),
(29, 'Olahraga & Rekreasi', '2024-06-30 01:06:47', NULL),
(30, 'Keterampilan & Jasa', '2024-06-30 01:06:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lamaran_pekerjaan`
--

CREATE TABLE `tbl_lamaran_pekerjaan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_lowongan` int(10) UNSIGNED NOT NULL,
  `id_alumni` int(10) UNSIGNED NOT NULL,
  `status_lamaran` enum('tidak_lolos','pemberkasan','interview','lolos','lainnya') NOT NULL,
  `keterangan_lamaran` varchar(1000) NOT NULL COMMENT 'Alasan dari status',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_lamaran_pekerjaan`
--

INSERT INTO `tbl_lamaran_pekerjaan` (`id`, `id_lowongan`, `id_alumni`, `status_lamaran`, `keterangan_lamaran`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 'interview', '', '2024-07-01 13:58:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lowongan`
--

CREATE TABLE `tbl_lowongan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_perusahaan` int(10) UNSIGNED NOT NULL,
  `id_jenis_pekerjaan` int(10) UNSIGNED DEFAULT NULL,
  `id_klasifikasi_pekerjaan` int(10) UNSIGNED DEFAULT NULL,
  `nama_lowongan` varchar(128) NOT NULL,
  `penempatan` varchar(128) NOT NULL,
  `batas_bawah_gaji` int(11) DEFAULT NULL,
  `batas_atas_gaji` int(11) DEFAULT NULL,
  `tipe_gaji` enum('harian','mingguan','bulanan','tahunan') DEFAULT 'bulanan',
  `keterangan_lowongan` varchar(5000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_lowongan`
--

INSERT INTO `tbl_lowongan` (`id`, `id_perusahaan`, `id_jenis_pekerjaan`, `id_klasifikasi_pekerjaan`, `nama_lowongan`, `penempatan`, `batas_bawah_gaji`, `batas_atas_gaji`, `tipe_gaji`, `keterangan_lowongan`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 18, 'Fullstack Web Developer', 'Palembang', 5000000, 10000000, 'bulanan', 'test', '2024-06-30 01:25:50', NULL),
(2, 6, 1, 12, 'Web Programmer', 'Jakarta Selatan', 6500000, 8500000, 'bulanan', '**Qualifications and Experience**\r\n\r\n* Required for Bachelor Degree (S1) Information System or relevant study\r\n* Previous working experience as Web Programmer or Developer min. 2 year(s)\r\n* Proficiency skill in Framework NET (MVC/MVP) and .NET Core\r\n* Proficiency skill in RDBMS concept (Function, Stored Procedure)\r\n* Proficiency skill in OPEN/REST API concept\r\n* Mastering Programming Language C#, ASP.NET, HTML and CSS\r\n* Deep Understanding about OOP concept\r\n* Adaptive and Able to work in team\r\n* A Good Problem Solver\r\n \r\n\r\n**Tasks and Responsibilities**\r\n\r\n* Developing applications using programming languages that can be used in the .NET framework\r\n* Performing quality checks on applications prior to launch and addressing any errors or bugs found\r\n* Conducting routine maintenance on company applications to ensure responsiveness and functionality, and developing new applications when necessary\r\n \r\n\r\n**Benefits**\r\n\r\n* Basic Salary\r\n* THR (Proportional before 1year)\r\n* Incentive and Bonus Performance (after probation)\r\n* Meal Allowance\r\n* BPJS\r\n* Health Insurance\r\n* Sports/Fitness Allowance\r\n* Hybrid (WFH) 4:1                      ', '2024-06-30 23:35:15', '2024-07-01 11:50:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pangkat_golongan`
--

CREATE TABLE `tbl_pangkat_golongan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_pangkat_golongan` varchar(128) NOT NULL,
  `tipe` enum('pns','pppk','gtt','honor') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pangkat_golongan`
--

INSERT INTO `tbl_pangkat_golongan` (`id`, `nama_pangkat_golongan`, `tipe`, `created_at`, `updated_at`) VALUES
(1, 'Golongan Ia (Juru Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(2, 'Golongan Ib (Juru Muda Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(3, 'Golongan Ic (Juru)', 'pns', '2024-05-15 17:21:54', NULL),
(4, 'Golongan Id (Juru Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(5, 'Golongan IIa (Pengatur muda)', 'pns', '2024-05-15 17:21:54', NULL),
(6, 'Golongan IIb (Pengatur Muda Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(7, 'Golongan IIc (Pengatur)', 'pns', '2024-05-15 17:21:54', NULL),
(8, 'Golongan IId (Pengatur tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(9, 'Golongan IIIa (Penata Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(10, 'Golongan IIIb (Penata Muda Tingkat 1)', 'pns', '2024-05-15 17:21:54', NULL),
(11, 'Golongan IIIc (Penata)', 'pns', '2024-05-15 17:21:54', NULL),
(12, 'Golongan IIId (Penata Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(13, 'Golongan IVa (Pembina)', 'pns', '2024-05-15 17:21:54', NULL),
(14, 'Golongan IVb (Pembina Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(15, 'Golongan IVc (Pembina Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(16, 'Golongan IVd (Pembina Madya)', 'pns', '2024-05-15 17:21:54', NULL),
(17, 'Golongan IVe (Pembina Utama)', 'pns', '2024-05-15 17:21:54', NULL),
(18, 'Tidak ada', NULL, '2024-05-15 18:23:14', '2024-05-20 11:50:30'),
(19, 'PPPK', 'pppk', '2024-05-20 11:36:07', NULL),
(20, 'GTT', 'gtt', '2024-05-20 11:36:07', NULL),
(21, 'Honor', 'honor', '2024-05-20 11:49:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pendidikan`
--

CREATE TABLE `tbl_pendidikan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_pendidikan` varchar(16) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pendidikan`
--

INSERT INTO `tbl_pendidikan` (`id`, `nama_pendidikan`, `created_at`, `updated_at`) VALUES
(1, 'tidak_sekolah', '2024-05-11 19:21:02', '2024-05-13 16:25:34'),
(2, 'SD', '2024-05-11 19:21:03', NULL),
(3, 'SMP', '2024-05-11 19:21:03', NULL),
(4, 'SLTA', '2024-05-11 19:21:03', NULL),
(5, 'DI', '2024-05-11 19:21:03', NULL),
(6, 'DII', '2024-05-11 19:21:03', NULL),
(7, 'DIII', '2024-05-11 19:21:03', NULL),
(8, 'DIV', '2024-05-11 19:21:03', NULL),
(9, 'S1', '2024-05-11 19:21:03', NULL),
(10, 'S2', '2024-05-11 19:21:03', NULL),
(11, 'S3', '2024-05-11 19:21:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `hak_akses` enum('admin','guru','kepala_sekolah','alumni','perusahaan') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id`, `username`, `password`, `hak_akses`, `created_at`, `last_login`) VALUES
(9, 'admin', '$2y$10$VSwsaud3aHkzE3VzMfuGCO9YizH7A7wVnx7Xfi9kUDiJdhDY53Msy', 'admin', '2024-06-10 14:42:24', '2024-07-01 06:49:08'),
(23, 'okta467', '$2y$10$0BEb6jl.Z7dieqJQHShYruxxEarz6AsswLg4EoAImdC0XAirF/OEO', 'alumni', '2024-06-24 18:13:00', '2024-06-30 19:00:26'),
(24, 'bimasatria', '$2y$10$PJ0tlPZHqurX0xzM2NA.XO3AXBpKr6oPbWI6m2u2V8haaDMfpk2J.', 'alumni', '2024-06-24 18:17:17', NULL),
(25, '196506121990022003', '$2y$10$r6i9ouw57cTTevcboVpfxuaaeGE.LqvH0ivtFunGnpjhus3jtxu1q', 'kepala_sekolah', '2024-06-24 18:29:06', '2024-06-27 13:22:34'),
(33, 'bankbri', '$2y$10$TN/rveG929csN1Cbx3xhAeR0cNtWVTNlgafk9Z37E0ZgkCUqNmx66', 'perusahaan', '2024-06-26 13:30:09', '2024-06-29 19:35:47'),
(34, 'iconplus', '$2y$10$nQRKxiCx.1L39VwkwEF3buNhiqt7TuDHat6P5IiWucR0VPSZeCBKa', 'perusahaan', '2024-06-27 00:30:37', NULL),
(35, '1989986520190220', '$2y$10$I32/sA1ZI3lAnUTAOmbNV.AnHZaLXF0tjOLOfO8kFdZ14v8am73Te', 'guru', '2024-06-27 14:46:25', NULL),
(36, 'paninasset', '$2y$10$DF.BZjYIVNy9kPkyMsPnjOTengyiL./OJMgg/xwdpxf3u1Ig4DENS', 'perusahaan', '2024-06-30 23:32:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_perusahaan`
--

CREATE TABLE `tbl_perusahaan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pengguna` int(10) UNSIGNED DEFAULT NULL,
  `id_jenis_perusahaan` int(10) UNSIGNED DEFAULT NULL,
  `nama_perusahaan` varchar(128) NOT NULL,
  `alamat_perusahaan` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_perusahaan`
--

INSERT INTO `tbl_perusahaan` (`id`, `id_pengguna`, `id_jenis_perusahaan`, `nama_perusahaan`, `alamat_perusahaan`, `created_at`, `updated_at`) VALUES
(3, 33, 1, 'PT Bank Rakyat Indonesia Tbk.', 'Gedung BRI JL Jenderal Sudirman Kav. 44-46, Jakarta, 10210, Indonesia', '2024-06-26 11:42:03', '2024-06-26 13:30:09'),
(5, 34, 3, 'PT Icon Plus', 'SBU SUMBAGSEL, Jl. Demang Lebar Daun No.375, Demang Lebar Daun, Kec. Ilir Bar. I, Kota Palembang, Sumatera Selatan, 30131', '2024-06-27 00:30:37', NULL),
(6, 36, 3, 'PT Panin Asset Management', 'Stock Exchange Building Tower I Lt. 3 Suite 306 Jl. Jend. Sudirman Kav. 52-53 Jakarta 12190', '2024-06-30 23:32:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prestasi_alumni`
--

CREATE TABLE `tbl_prestasi_alumni` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_alumni` int(10) UNSIGNED NOT NULL,
  `nama_prestasi` varchar(128) NOT NULL,
  `file_prestasi` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_prestasi_alumni`
--

INSERT INTO `tbl_prestasi_alumni` (`id`, `id_alumni`, `nama_prestasi`, `file_prestasi`, `created_at`, `updated_at`) VALUES
(1, 1, 'Juara II GEMASTIK Competitive Programming 2019', 'b9fb7507212ec7b29585f9c1bb021e48ec4e98ea532edb9dabccac3fe1190436.pdf', '2024-06-24 14:44:19', '2024-06-24 17:09:59'),
(3, 1, 'Ekoji Challenge II', 'cd851f19da9ef1aa4bd9394e0155f5b5c39db5fad66bb4a86950080a2e1a06ea.pdf', '2024-06-30 01:53:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tahun_seleksi`
--

CREATE TABLE `tbl_tahun_seleksi` (
  `id` int(10) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_tahun_seleksi`
--

INSERT INTO `tbl_tahun_seleksi` (`id`, `tahun`, `created_at`, `updated_at`) VALUES
(1, 2021, '2024-05-28 05:11:49', '2024-06-13 15:21:31'),
(2, 2022, '2024-05-28 04:52:33', '2024-06-13 15:21:28'),
(3, 2023, '2024-05-28 04:54:00', '2024-06-13 15:21:23'),
(4, 2024, '2024-06-24 17:13:17', '2024-06-24 17:15:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_alumni`
--
ALTER TABLE `tbl_alumni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `id_jurusan_pendidikan` (`id_jurusan_pendidikan`),
  ADD KEY `id_pangkat_golongan` (`id_pangkat_golongan`),
  ADD KEY `id_pendidikan` (`id_pendidikan`),
  ADD KEY `id_jabatan` (`id_jabatan`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jenis_pekerjaan`
--
ALTER TABLE `tbl_jenis_pekerjaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jenis_perusahaan`
--
ALTER TABLE `tbl_jenis_perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pendidikan` (`id_pendidikan`);

--
-- Indexes for table `tbl_keahlian_alumni`
--
ALTER TABLE `tbl_keahlian_alumni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_alumni`);

--
-- Indexes for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_wali_kelas` (`id_wali_kelas`);

--
-- Indexes for table `tbl_klasifikasi_pekerjaan`
--
ALTER TABLE `tbl_klasifikasi_pekerjaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_lamaran_pekerjaan`
--
ALTER TABLE `tbl_lamaran_pekerjaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lowongan` (`id_lowongan`),
  ADD KEY `id_alumni` (`id_alumni`);

--
-- Indexes for table `tbl_lowongan`
--
ALTER TABLE `tbl_lowongan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_perusahaan` (`id_perusahaan`),
  ADD KEY `id_jenis_pekerjaan` (`id_jenis_pekerjaan`),
  ADD KEY `id_kategori_pekerjaan` (`id_klasifikasi_pekerjaan`);

--
-- Indexes for table `tbl_pangkat_golongan`
--
ALTER TABLE `tbl_pangkat_golongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pendidikan`
--
ALTER TABLE `tbl_pendidikan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbl_perusahaan`
--
ALTER TABLE `tbl_perusahaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_jenis_perusahaan` (`id_jenis_perusahaan`);

--
-- Indexes for table `tbl_prestasi_alumni`
--
ALTER TABLE `tbl_prestasi_alumni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_alumni`);

--
-- Indexes for table `tbl_tahun_seleksi`
--
ALTER TABLE `tbl_tahun_seleksi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_alumni`
--
ALTER TABLE `tbl_alumni`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_jenis_pekerjaan`
--
ALTER TABLE `tbl_jenis_pekerjaan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_jenis_perusahaan`
--
ALTER TABLE `tbl_jenis_perusahaan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_keahlian_alumni`
--
ALTER TABLE `tbl_keahlian_alumni`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_klasifikasi_pekerjaan`
--
ALTER TABLE `tbl_klasifikasi_pekerjaan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_lamaran_pekerjaan`
--
ALTER TABLE `tbl_lamaran_pekerjaan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_lowongan`
--
ALTER TABLE `tbl_lowongan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_pangkat_golongan`
--
ALTER TABLE `tbl_pangkat_golongan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_pendidikan`
--
ALTER TABLE `tbl_pendidikan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_perusahaan`
--
ALTER TABLE `tbl_perusahaan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_prestasi_alumni`
--
ALTER TABLE `tbl_prestasi_alumni`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_tahun_seleksi`
--
ALTER TABLE `tbl_tahun_seleksi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_alumni`
--
ALTER TABLE `tbl_alumni`
  ADD CONSTRAINT `tbl_alumni_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_alumni_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD CONSTRAINT `tbl_guru_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_2` FOREIGN KEY (`id_pangkat_golongan`) REFERENCES `tbl_pangkat_golongan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_3` FOREIGN KEY (`id_pendidikan`) REFERENCES `tbl_pendidikan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_4` FOREIGN KEY (`id_jurusan_pendidikan`) REFERENCES `tbl_jurusan_pendidikan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_5` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  ADD CONSTRAINT `tbl_jurusan_pendidikan_ibfk_1` FOREIGN KEY (`id_pendidikan`) REFERENCES `tbl_pendidikan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_keahlian_alumni`
--
ALTER TABLE `tbl_keahlian_alumni`
  ADD CONSTRAINT `tbl_keahlian_alumni_ibfk_1` FOREIGN KEY (`id_alumni`) REFERENCES `tbl_alumni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD CONSTRAINT `tbl_kelas_ibfk_1` FOREIGN KEY (`id_wali_kelas`) REFERENCES `tbl_guru` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_lamaran_pekerjaan`
--
ALTER TABLE `tbl_lamaran_pekerjaan`
  ADD CONSTRAINT `tbl_lamaran_pekerjaan_ibfk_1` FOREIGN KEY (`id_lowongan`) REFERENCES `tbl_lowongan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_lamaran_pekerjaan_ibfk_2` FOREIGN KEY (`id_alumni`) REFERENCES `tbl_alumni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_lowongan`
--
ALTER TABLE `tbl_lowongan`
  ADD CONSTRAINT `tbl_lowongan_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `tbl_perusahaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_lowongan_ibfk_2` FOREIGN KEY (`id_jenis_pekerjaan`) REFERENCES `tbl_jenis_pekerjaan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_lowongan_ibfk_3` FOREIGN KEY (`id_klasifikasi_pekerjaan`) REFERENCES `tbl_klasifikasi_pekerjaan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_perusahaan`
--
ALTER TABLE `tbl_perusahaan`
  ADD CONSTRAINT `tbl_perusahaan_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_perusahaan_ibfk_2` FOREIGN KEY (`id_jenis_perusahaan`) REFERENCES `tbl_jenis_perusahaan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_prestasi_alumni`
--
ALTER TABLE `tbl_prestasi_alumni`
  ADD CONSTRAINT `tbl_prestasi_alumni_ibfk_1` FOREIGN KEY (`id_alumni`) REFERENCES `tbl_alumni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
