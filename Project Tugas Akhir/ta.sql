-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 18 Sep 2024 pada 22.32
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ta`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosens`
--

CREATE TABLE `dosens` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dosens`
--

INSERT INTO `dosens` (`id`, `user_id`, `nip`, `tanggal_lahir`, `created_at`, `updated_at`) VALUES
(8, 3, '1972030419950110001', NULL, '2024-07-28 06:44:04', '2024-07-28 06:44:04'),
(9, 15, '1972030419950110008', NULL, '2024-07-28 06:45:21', '2024-07-28 06:45:21'),
(11, 13, '198406112019031012', NULL, '2024-08-26 08:49:07', '2024-08-26 08:49:07'),
(12, 4, '198406112019031012', NULL, '2024-08-27 16:09:26', '2024-08-27 16:09:26'),
(13, 20, '198406112019672', NULL, '2024-08-27 16:10:46', '2024-08-27 16:10:46'),
(14, 21, '198512282015041091', NULL, '2024-08-27 16:12:48', '2024-08-27 16:12:48'),
(15, 22, '197203041995081', NULL, '2024-08-27 16:15:55', '2024-08-27 16:15:55'),
(16, 19, '1972030419950142', NULL, '2024-08-27 23:47:46', '2024-08-27 23:47:46'),
(17, 2, '197203041995018', '1982-06-16', '2024-08-28 04:45:32', '2024-09-08 11:04:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `evaluations`
--

CREATE TABLE `evaluations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `dosen_id` bigint UNSIGNED DEFAULT NULL,
  `tendik_id` bigint UNSIGNED DEFAULT NULL,
  `riwayat_pendidikan` int NOT NULL,
  `pelatihan` json NOT NULL,
  `golongan` int NOT NULL,
  `pangkat` int NOT NULL,
  `umur` int NOT NULL,
  `lama_jabatan` int DEFAULT NULL,
  `Pro_Act` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah` float NOT NULL,
  `kompetensi` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `evaluations`
--

INSERT INTO `evaluations` (`id`, `user_id`, `dosen_id`, `tendik_id`, `riwayat_pendidikan`, `pelatihan`, `golongan`, `pangkat`, `umur`, `lama_jabatan`, `Pro_Act`, `jumlah`, `kompetensi`, `created_at`, `updated_at`) VALUES
(9, 1, 8, NULL, 2, '\"{\\\"32\\\":\\\"2\\\"}\"', 3, 3, 3, NULL, NULL, 13, 2.6, '2024-07-28 07:22:05', '2024-09-05 04:53:38'),
(11, 1, NULL, 8, 3, '\"{\\\"36\\\":\\\"2\\\"}\"', 3, 3, 3, 3, NULL, 17, 3.4, '2024-07-28 07:22:55', '2024-07-28 07:22:55'),
(12, 1, NULL, 12, 3, '\"{\\\"73\\\":\\\"3\\\"}\"', 3, 1, 2, 1, NULL, 13, 2.6, '2024-07-28 07:23:20', '2024-08-19 09:05:06'),
(14, 1, NULL, 14, 3, '\"{\\\"51\\\":\\\"3\\\",\\\"52\\\":\\\"2\\\"}\"', 3, 3, 2, 3, NULL, 19, 3.17, '2024-08-04 07:39:06', '2024-08-04 07:39:06'),
(15, 1, 9, NULL, 3, '\"{\\\"33\\\":\\\"3\\\"}\"', 2, 3, 3, NULL, NULL, 14, 2.8, '2024-08-26 08:45:39', '2024-08-26 08:45:39'),
(16, 1, 11, NULL, 2, '\"{\\\"74\\\":\\\"3\\\"}\"', 2, 3, 2, NULL, NULL, 12, 2.4, '2024-08-26 08:49:41', '2024-08-27 03:31:01'),
(17, 1, NULL, 13, 2, '\"{\\\"43\\\":\\\"2\\\"}\"', 2, 3, 2, NULL, NULL, 11, 2.2, '2024-08-27 15:30:05', '2024-08-27 15:30:05'),
(18, 1, 13, NULL, 2, '\"{\\\"76\\\":\\\"2\\\"}\"', 3, 2, 2, NULL, NULL, 11, 2.2, '2024-08-27 16:11:32', '2024-08-27 16:11:32'),
(19, 1, 14, NULL, 2, '\"{\\\"77\\\":\\\"3\\\"}\"', 3, 2, 2, NULL, NULL, 12, 2.4, '2024-08-27 16:13:25', '2024-08-27 16:13:25'),
(20, 1, 15, NULL, 2, '\"{\\\"78\\\":\\\"2\\\"}\"', 3, 3, 2, NULL, NULL, 12, 2.4, '2024-08-27 16:16:28', '2024-08-27 16:16:28'),
(21, 1, 16, NULL, 2, '\"{\\\"79\\\":\\\"3\\\"}\"', 2, 2, 2, NULL, NULL, 11, 2.2, '2024-08-27 23:48:51', '2024-08-27 23:48:51'),
(22, 1, 12, NULL, 2, '\"{\\\"75\\\":\\\"3\\\"}\"', 3, 2, 2, NULL, NULL, 12, 2.4, '2024-08-28 04:16:25', '2024-08-28 04:16:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `keterampilans`
--

CREATE TABLE `keterampilans` (
  `id` bigint UNSIGNED NOT NULL,
  `dosen_id` bigint UNSIGNED DEFAULT NULL,
  `tendik_id` bigint UNSIGNED DEFAULT NULL,
  `golongan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pangkat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `umur` int NOT NULL,
  `lama_jabatan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `keterampilans`
--

INSERT INTO `keterampilans` (`id`, `dosen_id`, `tendik_id`, `golongan`, `pangkat`, `umur`, `lama_jabatan`, `created_at`, `updated_at`) VALUES
(25, 9, NULL, 'III/c', 'Penata Tingkat I', 43, NULL, '2024-07-28 06:45:22', '2024-07-28 06:45:22'),
(55, 8, NULL, 'III/d', 'Penata Tingkat I', 50, NULL, '2024-08-23 06:01:47', '2024-08-23 06:01:47'),
(57, 11, NULL, 'III/a', 'Pengatur Tingkat I', 21, NULL, '2024-08-26 08:49:09', '2024-08-26 08:49:09'),
(58, 12, NULL, 'II/d', 'Penata Muda', 39, NULL, '2024-08-27 16:09:28', '2024-08-27 16:09:28'),
(59, 13, NULL, 'III/b', 'Penata Tingkat I', 43, NULL, '2024-08-27 16:10:46', '2024-08-27 16:10:46'),
(60, 14, NULL, 'II/d', 'Penata Muda', 43, NULL, '2024-08-27 16:12:49', '2024-08-27 16:12:49'),
(61, 15, NULL, 'II/d', 'Penata Muda Tingkat I', 43, NULL, '2024-08-27 16:15:55', '2024-08-27 16:15:55'),
(62, 16, NULL, 'III/d', 'Penata Muda Tingkat I', 45, NULL, '2024-08-27 23:47:51', '2024-08-27 23:47:51'),
(69, NULL, 12, 'Honorer', '-', 25, NULL, '2024-09-05 02:56:36', '2024-09-05 02:56:36'),
(74, NULL, 14, 'IV/b', 'Pembina', 23, 'Dosen selama 15 tahun', '2024-09-05 04:14:20', '2024-09-05 04:14:20'),
(75, NULL, 8, 'III/b', 'Penata Muda Tingkat I', 37, 'Dosen selama 12 tahun', '2024-09-05 11:17:00', '2024-09-05 11:17:00'),
(76, NULL, 13, 'III/b', 'Penata Muda Tingkat I', 36, NULL, '2024-09-05 11:18:35', '2024-09-05 11:18:35'),
(78, 17, NULL, 'III/c', 'Penata Muda Tingkat I', 42, NULL, '2024-09-08 11:04:39', '2024-09-08 11:04:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_kuliah_dosens`
--

CREATE TABLE `mata_kuliah_dosens` (
  `id` bigint UNSIGNED NOT NULL,
  `dosen_id` bigint UNSIGNED NOT NULL,
  `mata_kuliah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mata_kuliah_dosens`
--

INSERT INTO `mata_kuliah_dosens` (`id`, `dosen_id`, `mata_kuliah`, `created_at`, `updated_at`) VALUES
(31, 9, 'struktur data', '2024-07-28 06:45:21', '2024-07-28 06:45:21'),
(32, 9, 'basis data', '2024-07-28 06:45:21', '2024-07-28 06:45:21'),
(45, 8, 'Jaringan Komputer Dasar', '2024-08-23 06:01:46', '2024-08-23 06:01:46'),
(46, 8, 'Kewirausahaan', '2024-08-23 06:01:46', '2024-08-23 06:01:46'),
(47, 11, 'PPBO', '2024-08-26 08:49:07', '2024-08-26 08:49:07'),
(48, 11, 'Pemrograman Visual', '2024-08-26 08:49:07', '2024-08-26 08:49:07'),
(49, 12, 'Sistem Keamanan Informasi', '2024-08-27 16:09:26', '2024-08-27 16:09:26'),
(50, 12, 'Pemrograman Web', '2024-08-27 16:09:26', '2024-08-27 16:09:26'),
(51, 13, 'Pemrograman Visual', '2024-08-27 16:10:46', '2024-08-27 16:10:46'),
(52, 14, 'Algoritma Pemrograman', '2024-08-27 16:12:48', '2024-08-27 16:12:48'),
(53, 15, 'Algoritma Pemrograman', '2024-08-27 16:15:55', '2024-08-27 16:15:55'),
(54, 16, 'Design Web', '2024-08-27 23:47:46', '2024-08-27 23:47:46'),
(63, 17, 'Algoritma Pemrograman', '2024-09-08 11:04:38', '2024-09-08 11:04:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_20_044358_add_profile_picture_to_users_table', 1),
(6, '2024_06_28_000203_create_dosens_table', 1),
(7, '2024_06_28_000204_create_tendiks_table', 1),
(8, '2024_06_28_000216_create_mata_kuliah_dosens_table', 1),
(9, '2024_06_28_000230_create_pelatihans_table', 1),
(10, '2024_06_28_000241_create_riwayat_pendidikans_table', 1),
(11, '2024_06_28_000251_create_keterampilans_table', 1),
(12, '2024_06_30_130124_create_evaluations_table', 1),
(13, '2024_07_28_131633_add_user_id_to_pelatihans_table', 2),
(14, '2024_07_28_132139_add_user_id_to_pelatihans_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelatihans`
--

CREATE TABLE `pelatihans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `dosen_id` bigint UNSIGNED DEFAULT NULL,
  `tendik_id` bigint UNSIGNED DEFAULT NULL,
  `nama_pelatihan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_sertifikat` date NOT NULL,
  `sertifikat_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pelatihans`
--

INSERT INTO `pelatihans` (`id`, `user_id`, `dosen_id`, `tendik_id`, `nama_pelatihan`, `expired_sertifikat`, `sertifikat_path`, `created_at`, `updated_at`) VALUES
(32, 3, 8, NULL, 'Universal Design of Learning', '2024-08-03', 'sertifikat/VBxGLDBaK146VFC3FgLnrsjHxaJ7rN4FerlRQPoU.png', '2024-07-28 06:44:05', '2024-07-28 06:44:05'),
(33, 15, 9, NULL, 'Basis Data', '2024-08-16', 'sertifikat/xieokpNVtUP9cmrQGXDEhgCAmsEPFVUV6MixCKNh.png', '2024-07-28 06:45:21', '2024-07-28 06:45:21'),
(36, 6, NULL, 8, 'Peningkatan Manajemen Jurusan', '2024-08-22', 'sertifikat/gKly9DBSfaalITXGYVK13GlTY87v4JSpjWoO4efL.png', '2024-07-28 06:53:12', '2024-07-28 06:53:12'),
(43, 7, NULL, 13, 'Peningkatan Manajemen Jurusan', '2024-07-30', 'sertifikat/4qUtbD9L7y1twD8i6X4CldmPB1VkOMdBf3M1Tzb8.png', '2024-07-28 07:13:11', '2024-07-28 07:13:11'),
(51, 5, NULL, 14, 'Peningkatan Manajemen Jurusan', '2024-07-25', 'sertifikat/EIGQjW89aSBDBgSamCU2lVrDlbEVHKGEXUxk5nF9.gif', '2024-08-04 07:38:02', '2024-08-04 07:38:02'),
(52, 5, NULL, 14, 'Universal Design of Learning', '2024-08-10', 'sertifikat/GfXht7KWnU1U6RrUT4lAm0ZrLrYHtW3L8wJ6kM6M.gif', '2024-08-04 07:38:02', '2024-08-04 07:38:02'),
(73, 10, NULL, 12, 'Kearsipan', '2024-08-31', 'sertifikat/HavfobESo5AqQh4MwMk1Xdv51Db8xTDFiUdkWoFG.jpg', '2024-08-19 08:54:39', '2024-08-23 06:41:06'),
(74, 13, 11, NULL, 'Java', '2024-08-31', 'sertifikat/SIwbfKMXjsK1ueJTkilwtPbZsoYFGc6koa6bMjKk.jpg', '2024-08-26 08:49:08', '2024-08-26 08:49:08'),
(75, 4, 12, NULL, 'Sistem Keamanan Informasi', '2024-08-31', 'sertifikat/IZ8DXGa8aU1yonJxy2L9eSDauP6cpLAZCmjHgjfZ.png', '2024-08-27 16:09:28', '2024-08-27 16:09:28'),
(76, 20, 13, NULL, 'Universal Design of Learning', '2024-08-15', 'sertifikat/1E9KHNAxPQkpFg3Pdi7tUx2zzyqmUH11AAExTKo5.pdf', '2024-08-27 16:10:46', '2024-08-27 16:10:46'),
(77, 21, 14, NULL, 'Pemrograman Pascal', '2024-09-26', 'sertifikat/6rRuFg7QAjK35qkYmmvJtRQJFkhheKrnu7zTjfQd.pdf', '2024-08-27 16:12:48', '2024-08-27 16:12:48'),
(78, 22, 15, NULL, 'Universal Design of Learning', '2024-08-30', 'sertifikat/9NeQfDXQjIaMSqVY955Oc3s1nvCvV7olKsNtaGdL.png', '2024-08-27 16:15:55', '2024-08-27 16:15:55'),
(79, 19, 16, NULL, 'Design Web', '2024-08-31', 'sertifikat/4DXFv3Am75An0voe4njjGRzfTNwgu0MgiFGJYKZa.png', '2024-08-27 23:47:50', '2024-08-27 23:47:50'),
(80, 2, 17, NULL, 'android', '2024-08-31', 'sertifikat/abYvW7Gk7CWu3nxfkv5j35B3itQTy4O0i8RwbOzv.png', '2024-08-28 04:45:33', '2024-08-28 04:45:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
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
-- Struktur dari tabel `riwayat_pendidikans`
--

CREATE TABLE `riwayat_pendidikans` (
  `id` bigint UNSIGNED NOT NULL,
  `dosen_id` bigint UNSIGNED DEFAULT NULL,
  `tendik_id` bigint UNSIGNED DEFAULT NULL,
  `riwayat_pendidikan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `riwayat_pendidikans`
--

INSERT INTO `riwayat_pendidikans` (`id`, `dosen_id`, `tendik_id`, `riwayat_pendidikan`, `created_at`, `updated_at`) VALUES
(45, 9, NULL, 'S1 Fakultas Teknik Untan', '2024-07-28 06:45:21', '2024-07-28 06:45:21'),
(46, 9, NULL, 'S1 STTI RESPATI Yogyakarta', '2024-07-28 06:45:21', '2024-07-28 06:45:21'),
(86, 8, NULL, 'D4 Teknik Elektro ITB', '2024-08-23 06:01:47', '2024-08-23 06:01:47'),
(87, 8, NULL, 'S2 Teknik Elektro', '2024-08-23 06:01:47', '2024-08-23 06:01:47'),
(89, 11, NULL, 'S1 Fakultas Teknik Untan', '2024-08-26 08:49:09', '2024-08-26 08:49:09'),
(90, 11, NULL, 'S2 Teknik Elektro', '2024-08-26 08:49:09', '2024-08-26 08:49:09'),
(91, 12, NULL, 'S1 Fakultas Teknik Untan', '2024-08-27 16:09:28', '2024-08-27 16:09:28'),
(92, 12, NULL, 'S2 Teknik Elektro', '2024-08-27 16:09:28', '2024-08-27 16:09:28'),
(93, 13, NULL, 'S1 Fakultas Teknik Untan', '2024-08-27 16:10:46', '2024-08-27 16:10:46'),
(94, 13, NULL, 'S2 Teknik Elektro', '2024-08-27 16:10:46', '2024-08-27 16:10:46'),
(95, 14, NULL, 'D4 Politeknik ITS', '2024-08-27 16:12:48', '2024-08-27 16:12:48'),
(96, 15, NULL, 'S1 Fakultas Teknik Untan', '2024-08-27 16:15:55', '2024-08-27 16:15:55'),
(97, 15, NULL, 'S2 Teknik Elektro', '2024-08-27 16:15:55', '2024-08-27 16:15:55'),
(98, 16, NULL, 'S1 Fakultas Teknik Untan', '2024-08-27 23:47:50', '2024-08-27 23:47:50'),
(99, 16, NULL, 'S2 Teknik Elektro', '2024-08-27 23:47:51', '2024-08-27 23:47:51'),
(111, NULL, 12, 'S1 Hukum', '2024-09-05 02:56:36', '2024-09-05 02:56:36'),
(120, NULL, 14, 'S1 Fakultas Teknik Untan', '2024-09-05 04:14:19', '2024-09-05 04:14:19'),
(121, NULL, 14, 'D4 Politeknik ITS', '2024-09-05 04:14:20', '2024-09-05 04:14:20'),
(122, NULL, 8, 'S2 Teknik Elektro', '2024-09-05 11:16:59', '2024-09-05 11:16:59'),
(123, NULL, 13, 'S2 Teknik Elektro', '2024-09-05 11:18:35', '2024-09-05 11:18:35'),
(126, 17, NULL, 'D4 Politeknik ITS', '2024-09-08 11:04:39', '2024-09-08 11:04:39'),
(127, 17, NULL, 'S2 Teknik Elektro', '2024-09-08 11:04:39', '2024-09-08 11:04:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tendiks`
--

CREATE TABLE `tendiks` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tendiks`
--

INSERT INTO `tendiks` (`id`, `user_id`, `nip`, `jabatan`, `tanggal_lahir`, `created_at`, `updated_at`) VALUES
(8, 6, '19851228201504664', 'Koordinator Program Studi', '1987-03-04', '2024-07-28 06:53:12', '2024-09-05 11:16:59'),
(12, 10, '1972030419950110001', 'Staf Administrasi Prodi', NULL, '2024-07-28 07:02:45', '2024-09-05 02:56:36'),
(13, 7, '19840611201903098', 'Sekretaris Jurusan', '1988-06-14', '2024-07-28 07:13:11', '2024-09-05 11:18:35'),
(14, 5, '1972030419950110009', 'Ketua Jurusan', '2001-06-11', '2024-08-04 07:38:02', '2024-09-05 04:14:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `profile_picture`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Neny Firdyanti, ST, MT.', 'neny@example.com', '2024-07-02 20:32:58', '$2y$12$iNm6BIp2dky6OLQbinYD5.AxRhkYelrod1pPiJVclJM2Rn7d7kLoC', 'Quality Assurance', 'profile_pictures/37XbjiSTpQTHcELMEyCEx9XK4WnSRpvDCC0thOTG.jpg', '7KraB9tmawvPDkuNxqYBzvCx43oDvyIt4BAOVA3702VaDlLA70lQDCFmNg91', '2024-07-02 20:32:58', '2024-08-25 07:31:59'),
(2, 'Fitri Wibowo, S.ST., MT.', 'fitri12@example.com', '2024-07-02 20:32:58', '$2y$12$SUS5EtKHs/YsA1qbM9oV/OhnXz1ogFlmtU29Sn.hF/0EABMCVCmua', 'Dosen', 'profile_pictures/tPA50UGufRsD242iFCweL6njqTXqoxgzKdpH2Gos.jpg', '4LqY4SNX63uSetupTkobg97b5FjXYkL0UVCQDcJBcvQjssK5xbfEYpI9TKNs', '2024-07-02 20:32:58', '2024-07-28 02:22:41'),
(3, 'Yasir Arafat, SST., MT.', 'yasir@example.com', '2024-07-02 20:32:58', '$2y$12$rfU5/b9.8uOgNc2udcbljuUVadyeDhwquN7mH17prj2kxzYAxvJ5q', 'Dosen', 'profile_pictures/4vRlkMbaSXEc90rYkl5a7vRE2WhuQ54s8UhcAJZS.jpg', 'KWlIONBT4E89RN5Y18zYGQPkK9gnObJtrE7MAbaHv9VJdcsvYfuRS9S6vjE7', '2024-07-02 20:32:58', '2024-08-23 06:00:35'),
(4, 'Lindung Siswanto, S.Kom., M.Eng.', 'lindung@example.com', '2024-07-02 20:33:00', '$2y$12$3w4gh65n6gvVDK3ihKtXaOT4Ph6GFJIfewHRwpljTUL7iQNBFKifC', 'Dosen', 'profile_pictures/9YG1WF1Ky8FNeCkMbRltAYZWIDhOgxjrZxVadlLP.jpg', 'dpIiuymq2Iw8abKpgGuEW4OxaiwvYGZv8csj9rFELKLtxLKsIEffCuobs3Oe', '2024-07-02 20:33:01', '2024-07-03 06:40:53'),
(5, 'Hasan, ST, MT.', 'hasan@example.com', '2024-07-02 20:33:01', '$2y$12$3w4gh65n6gvVDK3ihKtXaOT4Ph6GFJIfewHRwpljTUL7iQNBFKifC', 'Ketua Jurusan', 'profile_pictures/wBIgTcdI1wdUOnwx8lmP65ub46FdZabM9bIv2OdV.jpg', 'ipekDPrOd5VjSUAPcxnp0byLFlR7WtVjJL7BpiRpm0dZJgwmp2gkyRpPZrfJ', '2024-07-02 20:33:01', '2024-07-02 20:49:51'),
(6, 'Mariana Syamsudin, PhD.', 'mariana@example.org', '2024-07-02 20:33:01', '$2y$12$3w4gh65n6gvVDK3ihKtXaOT4Ph6GFJIfewHRwpljTUL7iQNBFKifC', 'Koordinator Program Studi', 'profile_pictures/lKsL5RnMidRaasNaTamCGYh99iYYbslBOloWmjJn.jpg', 'LcOWxoFkozsE097twmHReho73lLTekx9TImPYNyuXpmvcyn5qgFp4QsdcBus', '2024-07-02 20:33:01', '2024-07-21 04:18:42'),
(7, 'Wiwit Indah Rahayu, ST., MT.', 'wiwit@example.com', '2024-07-02 20:33:05', '$2y$12$n7viIgCEGrvWl1MSE3cg1etEofhJJ/DCs9vjJrq/HvMBFPETX5.Qa', 'Sekretaris Jurusan', 'profile_pictures/W13UvoGzXsxehDhty5KIezTijqdSWKtzg0pKDCK3.jpg', 'jtNqtH0flDEKk7475XlqYp4Coh8KtiwVPHWVEaob6fNAaYyvv6eQwzPCEtLV', '2024-07-02 20:33:06', '2024-07-10 06:06:12'),
(8, 'Tommi Suryanto, S.Kom., M.Kom', 'tommi@example.com', '2024-07-02 20:33:06', '$2y$12$wiOdyGikiPktPddrlgZliu3Ltls0qeArYc4Bzj0YTsQu6.bWwNRNa', 'Kalab TI', NULL, 'DemHCCfXWqoC02dlEN3kFeJdpjuKZS3zYagCIASQIBNpsyBXXKzPRPGPYbNV', '2024-07-02 20:33:06', '2024-07-02 20:33:06'),
(9, 'Hairuddin, ST.', 'hairudin@example.com', '2024-07-02 20:33:06', '$2y$12$wiOdyGikiPktPddrlgZliu3Ltls0qeArYc4Bzj0YTsQu6.bWwNRNa', 'Teknisi Lab TI', NULL, 'eGYzlvYkcL', '2024-07-02 20:33:06', '2024-07-02 20:33:06'),
(10, 'Siti Sarah, S.M', 'siti@example.com', '2024-07-02 20:33:08', '$2y$12$9AJDNgg1A3mi48DUFYPp9uDQNh8hqr7uhgEtUeaXgeraXu7ciswsm', 'Staf Administrasi Prodi', 'profile_pictures/Xw0ggCniWYmpyp2qGK3POruupAutgarE7DwBWdqn.jpg', 'lm7MKgdzx8fxQTcShXuDrl9ip42CfPJYbzuBBjEIm1Z8SZIMdbDNwUwhZNvB', '2024-07-02 20:33:08', '2024-08-23 06:01:02'),
(11, 'Puji Hartono, A.Md', 'puji@example.com', '2024-07-02 20:33:08', '$2y$12$d5aPqGs.M/kTLvQ1v0ohUefImBcFZmygm3u07UMItht.uPaTz9csG', 'Teknisi Lab TI', NULL, 'nCshJssIS9', '2024-07-02 20:33:08', '2024-07-02 20:33:08'),
(12, 'Bayu, A.Md', 'bayu@example.com', '2024-07-02 20:33:08', '$2y$12$d5aPqGs.M/kTLvQ1v0ohUefImBcFZmygm3u07UMItht.uPaTz9csG', 'Teknisi Lab TI', NULL, 'm9XPoh5hfq', '2024-07-02 20:33:08', '2024-07-02 20:33:08'),
(13, 'Suheri, ST., M.Cs.', 'suheri@example.com', '2024-01-24 12:36:34', '$2y$12$iNm6BIp2dky6OLQbinYD5.AxRhkYelrod1pPiJVclJM2Rn7d7kLoC', 'Dosen', NULL, 'ySoyBRzcEmuOSGSaRPcvnQLSa8A3dEhk6MHlHHs4fIGoAnkici5ri0Fv3yRC', '2024-01-24 12:36:34', '2024-01-31 12:36:34'),
(15, 'Sarah Bibi, S.ST., M.Pd.', 'sarah@example.com', NULL, '$2y$12$Ip.8O8TLKVlV07uFtpij3.4IHneAhLKZMkpNKYuNXrGK6U0QxowNG', 'Dosen', NULL, NULL, '2024-07-26 01:16:24', '2024-07-26 01:16:24'),
(17, 'Akmal Muhammad Ridho', 'akmal@example.com', NULL, '$2y$12$pLLgiGcnUWYiDcMwISnR9eY/b3rsr9t./b/9B7ZMY6gKZbE3vvd32', 'Penjaminan Mutu & Pengembangan Pembelajaran', 'profile_pictures/zrx5mtRIXCtfsCZyWMyRg4cJ2kzhc56OAwYGM0iz.png', NULL, '2024-08-23 07:12:50', '2024-08-24 19:45:12'),
(18, 'Neny Firdyanti, ST, MT.', 'neny@gmail.com', NULL, '$2y$12$iX1FxdNnZwZyRMRu6YMyMuvCfWCGAxWoxKJQ3nHEjTOg8reS9V.tS', 'Dosen', 'profile_pictures/3Uth0P1MIQJN9cvdz5tBh2pNa1HF8yY01RgGPgBY.jpg', NULL, '2024-08-25 07:48:16', '2024-08-25 07:53:21'),
(19, 'Ferry Faisal, ST.,MT.', 'ferry@example.com', NULL, '$2y$12$dxULRLhUN0PocriyuKAJ2O.QcOa3qb1R1sIhqOTWCeZXOXhaQoDQm', 'Dosen', NULL, NULL, '2024-08-27 15:33:02', '2024-08-27 15:33:02'),
(20, 'Budianingsih, ST, MT', 'budianingsih@example.com', NULL, '$2y$12$IUNJxchCLEjiQX0mBD.gEe1ifKgMsYLxLS0HWY8Xcln2v.QaxLCLu', 'Dosen', NULL, NULL, '2024-08-27 15:33:50', '2024-08-27 15:33:50'),
(21, 'Muhammad Hasbi, ST, MT', 'hasbi@example.com', NULL, '$2y$12$s8FQIjCoSDM4IQOUJ4bJhenfIIJ5dpB5ZZ1MZr7NDGoim7/GXWjVW', 'Dosen', NULL, NULL, '2024-08-27 15:34:50', '2024-08-27 15:34:50'),
(22, 'Pausta Yugianus, S.Kom, MT', 'pausta@example.com', NULL, '$2y$12$BNl5vq30lEH49aXnQnAdbOqaL/hIHsFufllsMzzF3PFdaMtu4HrnW', 'Dosen', NULL, NULL, '2024-08-27 15:35:28', '2024-08-27 15:35:28'),
(23, 'Muhammad Diponegoro, S.Kom., M.Cs', 'didi@example.com', NULL, '$2y$12$/VkLOkUmfthWqwqSkBiqmOji1uu46zHzZ/WCoL5KucG.zOwZKtlHy', 'Dosen', NULL, NULL, '2024-08-27 15:37:04', '2024-08-27 15:37:04'),
(24, 'Tri Bowo Atmojo, ST., M.Cs', 'tri@example.com', NULL, '$2y$12$1AxF6YUbeNhG5S3qo5kKT.dd6yfyaHfo6qcJBBoAvSBW4sQ5wfzGm', 'Dosen', NULL, NULL, '2024-08-27 15:37:54', '2024-08-27 15:37:54'),
(25, 'Novi Aryani Fitri, ST., M.Tr.Kom', 'novi@eample.com', NULL, '$2y$12$ceg4kXLfVkrtSdk94svkL.X0/SIUBd1b5evwC3LPibTSBPRL2D/i6', 'Dosen', NULL, NULL, '2024-08-27 15:38:32', '2024-08-27 15:38:32'),
(26, 'Safri Adam, S.Kom., M.Kom', 'safri@example.com', NULL, '$2y$12$w.QNFUADhR8vTT6PYsSJSOIiPwoi4CCdp3ut.rJz/v7AALJG936VC', 'Dosen', NULL, NULL, '2024-08-27 15:39:09', '2024-08-27 15:39:09'),
(27, 'Suharsono, S.Kom., M.Kom', 'suharsono@example.com', NULL, '$2y$12$0SUWvTXH0PqP/ZoRhun1V.mfV9M4FkQEZSpx9lQl9PLE0N02o2hRa', 'Dosen', NULL, NULL, '2024-08-27 15:39:51', '2024-08-27 15:39:51');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dosens`
--
ALTER TABLE `dosens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dosens_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluations_user_id_foreign` (`user_id`),
  ADD KEY `evaluations_dosen_id_foreign` (`dosen_id`),
  ADD KEY `evaluations_tendik_id_foreign` (`tendik_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `keterampilans`
--
ALTER TABLE `keterampilans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keterampilans_dosen_id_foreign` (`dosen_id`),
  ADD KEY `keterampilans_tendik_id_foreign` (`tendik_id`);

--
-- Indeks untuk tabel `mata_kuliah_dosens`
--
ALTER TABLE `mata_kuliah_dosens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mata_kuliah_dosens_dosen_id_foreign` (`dosen_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pelatihans`
--
ALTER TABLE `pelatihans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelatihans_dosen_id_foreign` (`dosen_id`),
  ADD KEY `pelatihans_tendik_id_foreign` (`tendik_id`),
  ADD KEY `pelatihans_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `riwayat_pendidikans`
--
ALTER TABLE `riwayat_pendidikans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_pendidikans_dosen_id_foreign` (`dosen_id`),
  ADD KEY `riwayat_pendidikans_tendik_id_foreign` (`tendik_id`);

--
-- Indeks untuk tabel `tendiks`
--
ALTER TABLE `tendiks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tendiks_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dosens`
--
ALTER TABLE `dosens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `keterampilans`
--
ALTER TABLE `keterampilans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT untuk tabel `mata_kuliah_dosens`
--
ALTER TABLE `mata_kuliah_dosens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pelatihans`
--
ALTER TABLE `pelatihans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat_pendidikans`
--
ALTER TABLE `riwayat_pendidikans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT untuk tabel `tendiks`
--
ALTER TABLE `tendiks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dosens`
--
ALTER TABLE `dosens`
  ADD CONSTRAINT `dosens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluations_tendik_id_foreign` FOREIGN KEY (`tendik_id`) REFERENCES `tendiks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `keterampilans`
--
ALTER TABLE `keterampilans`
  ADD CONSTRAINT `keterampilans_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `keterampilans_tendik_id_foreign` FOREIGN KEY (`tendik_id`) REFERENCES `tendiks` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mata_kuliah_dosens`
--
ALTER TABLE `mata_kuliah_dosens`
  ADD CONSTRAINT `mata_kuliah_dosens_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelatihans`
--
ALTER TABLE `pelatihans`
  ADD CONSTRAINT `pelatihans_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelatihans_tendik_id_foreign` FOREIGN KEY (`tendik_id`) REFERENCES `tendiks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelatihans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `riwayat_pendidikans`
--
ALTER TABLE `riwayat_pendidikans`
  ADD CONSTRAINT `riwayat_pendidikans_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `riwayat_pendidikans_tendik_id_foreign` FOREIGN KEY (`tendik_id`) REFERENCES `tendiks` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tendiks`
--
ALTER TABLE `tendiks`
  ADD CONSTRAINT `tendiks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
