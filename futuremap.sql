-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Mar 2026 pada 07.37
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `futuremap`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alumni_bridge_questions`
--

CREATE TABLE `alumni_bridge_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `alumni_id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `answer` text DEFAULT NULL,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `answered_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}', 1772600627);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `career_paths`
--

CREATE TABLE `career_paths` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `industry` varchar(255) NOT NULL,
  `avg_salary_min` decimal(15,2) DEFAULT NULL,
  `avg_salary_max` decimal(15,2) DEFAULT NULL,
  `required_skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`required_skills`)),
  `recommended_certifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`recommended_certifications`)),
  `career_progression` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `career_paths`
--

INSERT INTO `career_paths` (`id`, `title`, `slug`, `description`, `industry`, `avg_salary_min`, `avg_salary_max`, `required_skills`, `recommended_certifications`, `career_progression`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Web Developer', 'web-developer', 'Web developer bertanggung jawab untuk membangun dan memelihara website. Mereka bekerja dengan bahasa pemrograman seperti HTML, CSS, JavaScript, dan framework seperti Laravel atau React.', 'Teknologi Informasi', 5000000.00, 15000000.00, '[\"HTML\",\"CSS\",\"JavaScript\",\"PHP\",\"Laravel\",\"Database\"]', '[\"Certified Web Developer\",\"Laravel Certification\",\"JavaScript Developer Certificate\"]', 'Junior Web Developer (0-2 tahun) → Web Developer (2-4 tahun) → Senior Web Developer (4-6 tahun) → Lead Developer/Technical Lead (6+ tahun) → CTO', NULL, '2026-02-22 22:37:19', '2026-02-22 22:37:19'),
(2, 'Data Scientist', 'data-scientist', 'Data Scientist menganalisis dan menginterpretasikan data kompleks untuk membantu perusahaan mengambil keputusan. Mereka menggunakan statistika, machine learning, dan programming.', 'Data & Analytics', 8000000.00, 20000000.00, '[\"Python\",\"R\",\"SQL\",\"Machine Learning\",\"Statistika\",\"Data Visualization\"]', '[\"Certified Data Scientist\",\"Google Data Analytics\",\"IBM Data Science\"]', 'Junior Data Analyst → Data Analyst → Data Scientist → Senior Data Scientist → Head of Data', NULL, '2026-02-22 22:37:19', '2026-02-22 22:37:19'),
(3, 'UI/UX Designer', 'uiux-designer', 'UI/UX Designer bertanggung jawab untuk mendesain tampilan dan pengalaman pengguna aplikasi atau website agar mudah digunakan dan menarik.', 'Desain Digital', 4500000.00, 12000000.00, '[\"Figma\",\"Adobe XD\",\"Sketch\",\"User Research\",\"Wireframing\",\"Prototyping\"]', '[\"Google UX Design\",\"Certified UI\\/UX Designer\",\"Interaction Design Certification\"]', 'Junior Designer → UI/UX Designer → Senior Designer → Design Lead → Head of Design', NULL, '2026-02-22 22:37:19', '2026-02-22 22:37:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `career_path_courses`
--

CREATE TABLE `career_path_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `career_path_id` bigint(20) UNSIGNED NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_code` varchar(255) DEFAULT NULL,
  `university` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_recommended` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `career_path_courses`
--

INSERT INTO `career_path_courses` (`id`, `career_path_id`, `course_name`, `course_code`, `university`, `platform`, `link`, `is_recommended`, `created_at`, `updated_at`) VALUES
(1, 1, 'Belajar Dasar Web Development', NULL, 'Dicoding Academy', 'Dicoding', 'https://www.dicoding.com/', 1, '2026-02-22 22:37:19', '2026-02-22 22:37:19'),
(2, 1, 'Full Stack Web Developer', NULL, 'University of Michigan', 'Coursera', 'https://www.coursera.org/', 1, '2026-02-22 22:37:19', '2026-02-22 22:37:19'),
(3, 2, 'Belajar Dasar Web Development', NULL, 'Dicoding Academy', 'Dicoding', 'https://www.dicoding.com/', 1, '2026-02-22 22:37:19', '2026-02-22 22:37:19'),
(4, 2, 'Full Stack Web Developer', NULL, 'University of Michigan', 'Coursera', 'https://www.coursera.org/', 1, '2026-02-22 22:37:19', '2026-02-22 22:37:19'),
(5, 3, 'Belajar Dasar Web Development', NULL, 'Dicoding Academy', 'Dicoding', 'https://www.dicoding.com/', 1, '2026-02-22 22:37:19', '2026-02-22 22:37:19'),
(6, 3, 'Full Stack Web Developer', NULL, 'University of Michigan', 'Coursera', 'https://www.coursera.org/', 1, '2026-02-22 22:37:19', '2026-02-22 22:37:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Fakultas Ilmu Komputer', 'FASILKOM', 'Fakultas Ilmu Komputer dan Teknologi Informasi', '2026-02-22 21:28:17', '2026-02-22 21:28:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `online_url` varchar(255) DEFAULT NULL,
  `max_participants` int(11) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `price` decimal(15,2) DEFAULT NULL,
  `speakers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`speakers`)),
  `qrcode_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `event_registrations`
--

CREATE TABLE `event_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'registered',
  `registered_at` datetime NOT NULL,
  `checked_in_at` datetime DEFAULT NULL,
  `qrcode` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_listing_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cv_path` varchar(255) NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `match_score` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `applied_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_listing_id`, `user_id`, `cv_path`, `cover_letter`, `status`, `match_score`, `notes`, `applied_at`, `created_at`, `updated_at`) VALUES
(1, 1, 7, '1772157537_7.pdf', 'AKU SEORANG PROGRAMEL HANDAL', 'accepted', 90, NULL, '2026-02-27 01:58:57', '2026-02-26 18:58:57', '2026-02-26 19:47:31'),
(2, 4, 7, '1772164381_7.pdf', NULL, 'accepted', 79, NULL, '2026-02-27 03:53:01', '2026-02-26 20:53:01', '2026-02-26 21:19:39'),
(3, 5, 7, '1772418053_7.pdf', NULL, 'accepted', 78, NULL, '2026-03-02 02:20:53', '2026-03-01 19:20:53', '2026-03-01 19:21:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_listings`
--

CREATE TABLE `job_listings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `benefits` text DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `work_style` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `salary_min` decimal(15,2) DEFAULT NULL,
  `salary_max` decimal(15,2) DEFAULT NULL,
  `major_id` bigint(20) UNSIGNED DEFAULT NULL,
  `min_gpa` decimal(3,2) DEFAULT NULL,
  `min_semester` int(11) DEFAULT NULL,
  `deadline` date NOT NULL,
  `slots` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `applications_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `job_listings`
--

INSERT INTO `job_listings` (`id`, `company_id`, `title`, `description`, `requirements`, `benefits`, `type`, `work_style`, `location`, `salary_min`, `salary_max`, `major_id`, `min_gpa`, `min_semester`, `deadline`, `slots`, `is_active`, `views_count`, `applications_count`, `created_at`, `updated_at`) VALUES
(1, 8, 'DESIGNER UI/UX', 'DSVGSHSH', 'SHSHSHS', 'SHSDHDSHS', 'freelance', 'remote', 'SERPONG', 5000000.00, 8000000.00, 1, 3.65, 6, '2026-02-28', 6, 1, 10, 1, '2026-02-26 00:26:44', '2026-02-26 20:05:00'),
(2, 8, 'WEB DEVELOPER', 'WYUIJKHGFDS', 'ASDXHGFDZS', 'AFGJHGNBXZ', 'parttime', 'hybrid', 'SERPONG', 10000000.00, 15000000.00, 1, 3.80, 6, '2026-02-27', 4, 1, 2, 0, '2026-02-26 00:47:30', '2026-02-26 19:35:36'),
(3, 12, 'FRONT END DEVELOPER', 'ASDFGHJ', 'ASDFGH', 'ASDFGH', 'parttime', 'remote', 'BANTEN', 5000000.00, 15000000.00, 1, 4.00, 6, '2026-03-02', 1, 1, 0, 0, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(4, 12, 'BACK END', 'ASDFGHJ', 'ASDFGH', 'ASDFGHJ', 'fulltime', 'remote', 'SERANG', 10000000.00, 20000000.00, 1, 3.80, 6, '2026-03-09', 1, 1, 4, 1, '2026-02-26 20:51:55', '2026-03-01 19:17:41'),
(5, 8, 'BVCXZGFD', 'KIJHGVF', 'HBGVFCD', 'HGVFD', 'parttime', 'hybrid', 'SERPONG', 5000000.00, 10000000.00, 1, 3.00, 8, '2026-03-06', 1, 1, 4, 1, '2026-03-01 19:19:33', '2026-03-02 23:28:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_skills`
--

CREATE TABLE `job_skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_listing_id` bigint(20) UNSIGNED NOT NULL,
  `skill_id` bigint(20) UNSIGNED NOT NULL,
  `importance_level` int(11) NOT NULL DEFAULT 3,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `job_skills`
--

INSERT INTO `job_skills` (`id`, `job_listing_id`, `skill_id`, `importance_level`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 3, '2026-02-26 00:26:44', '2026-02-26 00:46:07'),
(2, 1, 6, 3, '2026-02-26 00:26:44', '2026-02-26 00:46:07'),
(3, 2, 1, 3, '2026-02-26 00:47:30', '2026-02-26 00:47:30'),
(4, 2, 2, 3, '2026-02-26 00:47:30', '2026-02-26 00:47:30'),
(5, 2, 3, 3, '2026-02-26 00:47:30', '2026-02-26 00:47:30'),
(6, 2, 4, 3, '2026-02-26 00:47:30', '2026-02-26 00:47:30'),
(7, 2, 5, 3, '2026-02-26 00:47:30', '2026-02-26 00:47:30'),
(8, 2, 6, 3, '2026-02-26 00:47:30', '2026-02-26 00:47:30'),
(9, 2, 7, 3, '2026-02-26 00:47:30', '2026-02-26 00:47:30'),
(10, 2, 8, 3, '2026-02-26 00:47:30', '2026-02-26 00:47:30'),
(11, 2, 9, 3, '2026-02-26 00:47:30', '2026-02-26 00:47:30'),
(12, 2, 10, 3, '2026-02-26 00:47:30', '2026-02-26 00:47:30'),
(13, 2, 11, 3, '2026-02-26 00:47:30', '2026-02-26 00:47:30'),
(14, 3, 1, 3, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(15, 3, 2, 3, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(16, 3, 3, 3, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(17, 3, 4, 3, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(18, 3, 5, 3, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(19, 3, 6, 3, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(20, 3, 7, 3, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(21, 3, 8, 3, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(22, 3, 9, 3, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(23, 3, 10, 3, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(24, 3, 11, 3, '2026-02-26 20:50:34', '2026-02-26 20:50:34'),
(25, 4, 1, 3, '2026-02-26 20:51:55', '2026-02-26 20:51:55'),
(26, 4, 2, 3, '2026-02-26 20:51:55', '2026-02-26 20:51:55'),
(27, 4, 3, 3, '2026-02-26 20:51:55', '2026-02-26 20:51:55'),
(28, 4, 4, 3, '2026-02-26 20:51:55', '2026-02-26 20:51:55'),
(29, 4, 5, 3, '2026-02-26 20:51:55', '2026-02-26 20:51:55'),
(30, 4, 6, 3, '2026-02-26 20:51:55', '2026-02-26 20:51:55'),
(31, 4, 7, 3, '2026-02-26 20:51:55', '2026-02-26 20:51:55'),
(32, 4, 8, 3, '2026-02-26 20:51:55', '2026-02-26 20:51:55'),
(33, 4, 9, 3, '2026-02-26 20:51:55', '2026-02-26 20:51:55'),
(34, 4, 10, 3, '2026-02-26 20:51:55', '2026-02-26 20:51:55'),
(35, 4, 11, 3, '2026-02-26 20:51:55', '2026-02-26 20:51:55'),
(36, 5, 1, 3, '2026-03-01 19:19:33', '2026-03-01 19:19:33'),
(37, 5, 2, 3, '2026-03-01 19:19:33', '2026-03-01 19:19:33'),
(38, 5, 3, 3, '2026-03-01 19:19:33', '2026-03-01 19:19:33'),
(39, 5, 4, 3, '2026-03-01 19:19:33', '2026-03-01 19:19:33'),
(40, 5, 5, 3, '2026-03-01 19:19:33', '2026-03-01 19:19:33'),
(41, 5, 6, 3, '2026-03-01 19:19:33', '2026-03-01 19:19:33'),
(42, 5, 7, 3, '2026-03-01 19:19:33', '2026-03-01 19:19:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `majors`
--

CREATE TABLE `majors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `degree_level` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `majors`
--

INSERT INTO `majors` (`id`, `department_id`, `name`, `code`, `degree_level`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Teknik Informatika', 'IF', 'S1', 'Program Studi Teknik Informatika', '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(2, 1, 'Sistem Informasi', 'SI', 'S1', 'Program Studi Sistem Informasi', '2026-02-22 21:28:17', '2026-02-22 21:28:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mentoring_sessions`
--

CREATE TABLE `mentoring_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` bigint(20) UNSIGNED NOT NULL,
  `mentee_id` bigint(20) UNSIGNED NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `duration` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `meeting_link` varchar(255) DEFAULT NULL,
  `topic` text NOT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'scheduled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2026_02_23_040127_create_departments_table', 1),
(4, '2026_02_23_040127_modify_users_table', 1),
(5, '2026_02_23_040128_create_majors_table', 1),
(6, '2026_02_23_040128_create_profiles_table', 1),
(7, '2026_02_23_040129_create_skills_table', 1),
(8, '2026_02_23_040129_create_user_skills_table', 1),
(9, '2026_02_23_040130_create_job_listings_table', 1),
(10, '2026_02_23_040131_create_event_table', 1),
(11, '2026_02_23_040131_create_events_registrations_tabel', 1),
(12, '2026_02_23_040132_create_career_paths_table', 1),
(13, '2026_02_23_040132_create_scholarships_table', 1),
(14, '2026_02_23_040133_create_alumni_bridge_questions_table', 1),
(15, '2026_02_23_040133_create_career_path_courses_table', 1),
(16, '2026_02_23_040133_create_mentoring_sessions_table', 1),
(17, '2026_02_23_040746_create_permission_tables', 1),
(18, '2026_02_23_041202_create_job_skills_table', 1),
(19, '2026_02_23_041245_create_job_applications_table', 1),
(20, '2026_02_24_024930_create_personal_access_tokens_table', 2),
(21, '2026_02_26_073117_modify_salary_columns_in_jobs_table', 3),
(22, '2026_02_27_033829_create_notifications_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 10),
(5, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 8),
(5, 'App\\Models\\User', 9),
(5, 'App\\Models\\User', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `icon`, `color`, `link`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'system', 'User Baru', '5 user baru mendaftar hari ini', 'fa-users', 'blue', '#', 0, NULL, '2026-02-26 14:39:51', '2026-02-26 14:39:51'),
(2, 1, 'job', 'Lowongan Perlu Verifikasi', '3 lowongan baru menunggu verifikasi', 'fa-briefcase', 'yellow', '#', 0, NULL, '2026-02-26 14:39:51', '2026-02-26 14:39:51'),
(3, 2, 'job', 'Lowongan Frontend Developer', 'PT Teknologi Maju membuka lowongan Frontend Developer. Segera daftar!', 'fa-briefcase', 'blue', '/jobs', 0, NULL, '2026-02-20 16:39:51', '2026-02-20 16:39:51'),
(4, 2, 'event', 'Career Preparation Workshop', 'Workshop persiapan karir akan dimulai besok pukul 14:00 WIB', 'fa-calendar', 'green', '/events', 0, NULL, '2026-02-20 16:39:51', '2026-02-20 16:39:51'),
(5, 2, 'scholarship', 'Beasiswa LPDP Dibuka', 'Pendaftaran beasiswa LPDP telah dibuka. Deadline 30 April 2024', 'fa-graduation-cap', 'yellow', '/scholarships', 1, NULL, '2026-02-20 16:39:51', '2026-02-20 16:39:51'),
(6, 3, 'mentoring', 'Permintaan Mentoring', 'Budi Santoso meminta sesi mentoring tentang karir data science', 'fa-handshake', 'indigo', '#', 0, NULL, '2026-02-24 16:39:51', '2026-02-24 16:39:51'),
(7, 3, 'application', 'Review CV', '3 CV mahasiswa menunggu review dari Anda', 'fa-file-alt', 'purple', '#', 1, NULL, '2026-02-24 16:39:51', '2026-02-24 16:39:51'),
(8, 4, 'application', 'Pelamar Baru', 'Ada 5 pelamar baru untuk posisi yang Anda buka', 'fa-users', 'blue', '/my-applications', 0, NULL, '2026-02-26 12:39:51', '2026-02-26 12:39:51'),
(9, 4, 'application', 'CV Perlu Direview', '3 CV menunggu review dari Anda', 'fa-file-alt', 'purple', '/my-applications', 0, NULL, '2026-02-26 12:39:51', '2026-02-26 12:39:51'),
(10, 5, 'system', 'Pertanyaan dari Mahasiswa', 'Ani Wijaya bertanya tentang pengalaman karir di bidang UI/UX', 'fa-question-circle', 'green', '#', 0, NULL, '2026-02-26 10:39:51', '2026-02-26 10:39:51'),
(11, 6, 'job', 'Lowongan Frontend Developer', 'PT Teknologi Maju membuka lowongan Frontend Developer. Segera daftar!', 'fa-briefcase', 'blue', '/jobs', 0, NULL, '2026-02-20 16:39:51', '2026-02-20 16:39:51'),
(12, 6, 'event', 'Career Preparation Workshop', 'Workshop persiapan karir akan dimulai besok pukul 14:00 WIB', 'fa-calendar', 'green', '/events', 0, NULL, '2026-02-20 16:39:51', '2026-02-20 16:39:51'),
(13, 6, 'scholarship', 'Beasiswa LPDP Dibuka', 'Pendaftaran beasiswa LPDP telah dibuka. Deadline 30 April 2024', 'fa-graduation-cap', 'yellow', '/scholarships', 1, NULL, '2026-02-20 16:39:51', '2026-02-20 16:39:51'),
(14, 7, 'job', 'Lowongan Frontend Developer', 'PT Teknologi Maju membuka lowongan Frontend Developer. Segera daftar!', 'fa-briefcase', 'blue', '/jobs', 1, '2026-02-26 21:20:42', '2026-02-20 16:39:51', '2026-02-26 21:20:42'),
(15, 7, 'event', 'Career Preparation Workshop', 'Workshop persiapan karir akan dimulai besok pukul 14:00 WIB', 'fa-calendar', 'green', '/events', 1, '2026-02-26 21:20:42', '2026-02-20 16:39:51', '2026-02-26 21:20:42'),
(16, 7, 'scholarship', 'Beasiswa LPDP Dibuka', 'Pendaftaran beasiswa LPDP telah dibuka. Deadline 30 April 2024', 'fa-graduation-cap', 'yellow', '/scholarships', 1, NULL, '2026-02-20 16:39:51', '2026-02-20 16:39:51'),
(17, 8, 'application', 'Pelamar Baru', 'Ada 5 pelamar baru untuk posisi yang Anda buka', 'fa-users', 'blue', '/my-applications', 1, '2026-02-26 20:47:36', '2026-02-26 12:39:51', '2026-02-26 20:47:36'),
(18, 8, 'application', 'CV Perlu Direview', '3 CV menunggu review dari Anda', 'fa-file-alt', 'purple', '/my-applications', 1, '2026-02-26 20:47:41', '2026-02-26 12:39:51', '2026-02-26 20:47:41'),
(19, 9, 'application', 'Pelamar Baru', 'Ada 5 pelamar baru untuk posisi yang Anda buka', 'fa-users', 'blue', '/my-applications', 0, NULL, '2026-02-26 12:39:51', '2026-02-26 12:39:51'),
(20, 9, 'application', 'CV Perlu Direview', '3 CV menunggu review dari Anda', 'fa-file-alt', 'purple', '/my-applications', 0, NULL, '2026-02-26 12:39:51', '2026-02-26 12:39:51'),
(21, 10, 'system', 'Pertanyaan dari Mahasiswa', 'Ani Wijaya bertanya tentang pengalaman karir di bidang UI/UX', 'fa-question-circle', 'green', '#', 0, NULL, '2026-02-26 10:39:51', '2026-02-26 10:39:51'),
(22, 11, 'mentoring', 'Permintaan Mentoring', 'Budi Santoso meminta sesi mentoring tentang karir data science', 'fa-handshake', 'indigo', '#', 1, '2026-02-26 22:59:29', '2026-02-24 16:39:51', '2026-02-26 22:59:29'),
(23, 11, 'application', 'Review CV', '3 CV mahasiswa menunggu review dari Anda', 'fa-file-alt', 'purple', '#', 1, NULL, '2026-02-24 16:39:51', '2026-02-24 16:39:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `major_id` bigint(20) UNSIGNED DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `gpa` decimal(3,2) DEFAULT NULL,
  `graduation_date` date DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `portfolio_url` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `education_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`education_history`)),
  `work_experience` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`work_experience`)),
  `certifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`certifications`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `major_id`, `semester`, `gpa`, `graduation_date`, `linkedin_url`, `portfolio_url`, `bio`, `cv_path`, `education_history`, `work_experience`, `certifications`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-22 21:28:16', '2026-02-22 21:28:16'),
(2, 2, 1, 5, 3.75, NULL, NULL, NULL, 'Mahasiswa Teknik Informatika semester 5', NULL, NULL, NULL, NULL, '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(3, 5, 1, NULL, NULL, '2021-08-15', NULL, NULL, 'Alumni Teknik Informatika 2021', NULL, NULL, NULL, NULL, '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(4, 3, NULL, NULL, NULL, NULL, NULL, NULL, 'Dosen Fakultas Ilmu Komputer', NULL, NULL, NULL, NULL, '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(5, 4, NULL, NULL, NULL, NULL, NULL, NULL, 'Perusahaan teknologi yang bergerak di bidang pengembangan software', NULL, NULL, NULL, NULL, '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(6, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-22 21:49:16', '2026-02-22 21:49:16'),
(7, 7, NULL, 6, 3.80, NULL, NULL, 'https://github.com/amarferdiansyah', NULL, '1772516863_7_cv.pdf', NULL, NULL, NULL, '2026-02-22 21:51:25', '2026-03-02 22:47:43'),
(8, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-22 23:56:55', '2026-02-22 23:56:55'),
(9, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-23 00:01:10', '2026-02-23 00:01:10'),
(10, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-23 00:02:40', '2026-02-23 00:02:40'),
(11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-23 00:03:51', '2026-02-23 00:03:51'),
(12, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-26 20:48:46', '2026-02-26 20:48:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-02-22 21:28:15', '2026-02-22 21:28:15'),
(2, 'mahasiswa', 'web', '2026-02-22 21:28:15', '2026-02-22 21:28:15'),
(3, 'dosen', 'web', '2026-02-22 21:28:15', '2026-02-22 21:28:15'),
(4, 'alumni', 'web', '2026-02-22 21:28:15', '2026-02-22 21:28:15'),
(5, 'company', 'web', '2026-02-22 21:28:15', '2026-02-22 21:28:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `scholarships`
--

CREATE TABLE `scholarships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `deadline` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `scholarships`
--

INSERT INTO `scholarships` (`id`, `name`, `provider`, `description`, `requirements`, `amount`, `deadline`, `type`, `level`, `link`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Beasiswa Unggulan Kemendikbud', 'Kementerian Pendidikan dan Kebudayaan', 'Program beasiswa untuk mahasiswa berprestasi di seluruh Indonesia.', '- IPK minimal 3.50\n- Aktif dalam organisasi\n- Surat rekomendasi dari dosen', 12000000.00, '2026-04-23', 'academic', 'undergraduate', 'https://beasiswa.kemdikbud.go.id', 1, '2026-02-22 22:08:54', '2026-02-22 22:08:54'),
(2, 'LPDP Beasiswa Magister', 'Lembaga Pengelola Dana Pendidikan', 'Beasiswa penuh untuk program magister dalam dan luar negeri.', '- IPK minimal 3.00\n- Usia maksimal 35 tahun\n- Lulus tes bahasa Inggris', 250000000.00, '2026-05-23', 'government', 'graduate', 'https://lpdp.kemenkeu.go.id', 1, '2026-02-22 22:08:54', '2026-02-22 22:08:54'),
(3, 'Beasiswa Data Science', 'Tech Company Foundation', 'Beasiswa untuk mahasiswa jurusan Ilmu Komputer yang fokus pada Data Science.', '- IPK minimal 3.25\n- Semester 5-7\n- Menguasai dasar pemrograman', 15000000.00, '2026-03-23', 'special', 'undergraduate', 'https://techfoundation.org', 1, '2026-02-22 22:08:54', '2026-02-22 22:08:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('l1TcRIaoU6n3nzjiA245BSqHxP3VdyIXOq9u9igF', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNE8zejljZWl3M01nSWhFcXNkYWxKR2ZuNjR5SDVLOUJOS1pOYlVaZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ub3RpZmljYXRpb25zL3JlY2VudCI7czo1OiJyb3V0ZSI7czoyMDoibm90aWZpY2F0aW9ucy5yZWNlbnQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O30=', 1772519778);

-- --------------------------------------------------------

--
-- Struktur dari tabel `skills`
--

CREATE TABLE `skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `skills`
--

INSERT INTO `skills` (`id`, `name`, `category`, `created_at`, `updated_at`) VALUES
(1, 'PHP', 'technical', '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(2, 'Laravel', 'technical', '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(3, 'JavaScript', 'technical', '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(4, 'React', 'technical', '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(5, 'Python', 'technical', '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(6, 'UI/UX Design', 'technical', '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(7, 'Public Speaking', 'softskill', '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(8, 'Teamwork', 'softskill', '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(9, 'Leadership', 'softskill', '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(10, 'Problem Solving', 'softskill', '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(11, 'English', 'language', '2026-02-22 21:28:17', '2026-02-22 21:28:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `provider` varchar(255) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `nim`, `email_verified_at`, `password`, `phone`, `avatar`, `is_active`, `provider`, `provider_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin FutureMap', 'admin@futuremap.com', NULL, NULL, '$2y$12$wLFyq/G76/58XOePyFR67eAqXbqZgfEssmwReLMD.cpP.tMEI8dAm', NULL, NULL, 1, NULL, NULL, NULL, '2026-02-22 21:28:16', '2026-02-22 21:28:16'),
(2, 'Budi Mahasiswa', 'budi@student.com', '2021001', NULL, '$2y$12$C9FxMkAsWwZcoF60ZCG0ROjewBa5AHeWUotstlEkYUoo//PTE9OtG', NULL, NULL, 1, NULL, NULL, NULL, '2026-02-22 21:28:16', '2026-02-22 21:28:16'),
(3, 'Dr. Siti Dosen', 'siti@lecturer.com', NULL, NULL, '$2y$12$R2gQayjGFqBmyvV89p68neaRtQysmfDxSs8ntspWyQykVoKYUgdRK', NULL, NULL, 1, NULL, NULL, NULL, '2026-02-22 21:28:16', '2026-02-22 21:28:16'),
(4, 'PT Teknologi Maju', 'hr@teknologimaju.com', NULL, NULL, '$2y$12$Hw8ifUjNdUmdyqCW3W/ckuVGct3uj97mFfpkIR6ZB1EhvHw58x2F6', NULL, NULL, 1, NULL, NULL, NULL, '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(5, 'Ani Alumni', 'ani@alumni.com', '2017001', NULL, '$2y$12$6GzSJM/fZ9f6ZebLk5amLOn6wF7WkEM.sCW8bDRbQhCGTzxW6FP8m', NULL, NULL, 1, NULL, NULL, NULL, '2026-02-22 21:28:17', '2026-02-22 21:28:17'),
(6, 'Amar Ferdiansyah', '231730051.amar@uinbanten.ac.id', NULL, NULL, '$2y$12$DIywxEt9z29Lu52oac8bde76rsEQ2.7E.9c6FR9nWwI9/u6Dvvtdu', NULL, NULL, 1, NULL, NULL, NULL, '2026-02-22 21:49:16', '2026-02-22 21:49:16'),
(7, 'Amar Ferdiansyah', 'amarferdi254@gmail.com', '231730051', NULL, '$2y$12$stZqEEy1uIFT20IsgenyXuiGQd7c1/O6tuODciei7fWxbIaeMG5Wq', '083877125957', '1772165914_7.png', 1, NULL, NULL, NULL, '2026-02-22 21:51:25', '2026-02-26 21:18:34'),
(8, 'Amar Create', 'amar123@gmail.com', NULL, NULL, '$2y$12$U579Ets4ocIZaqdee94J6elKGNCD2P0Ovl277GERR1W/94ZL5.7ba', NULL, NULL, 1, NULL, NULL, 'pw0rhRJjCn54JLumDS4PX6bQZ1YWFfNjm2s4K4uZ6JcuqMfcApex2hCc6WdD', '2026-02-22 23:56:55', '2026-02-22 23:56:55'),
(9, 'Amar Create', 'amar@gmail.com', NULL, NULL, '$2y$12$v3110V3xNDqF7XQlHBDDf.7PFOvHNfaYQzMOlIW18ShlbTfqoV7au', NULL, NULL, 1, NULL, NULL, NULL, '2026-02-23 00:01:10', '2026-02-23 00:01:10'),
(10, 'Asa Abdullah', 'asa123@gmail.com', NULL, NULL, '$2y$12$uZI/1eKQWoQrYCuQYJJ0DOIlbYFb0pJpjWCtEb7U.DaTdadO40ku6', NULL, NULL, 1, NULL, NULL, NULL, '2026-02-23 00:02:40', '2026-02-23 00:02:40'),
(11, 'Tri Ahadi', 'tri123@gmail.com', NULL, NULL, '$2y$12$kRv5OWqaUA4roU6tDTYLc.rVlvssH.zcaEONe.2daAK1.ZmKptnCa', NULL, NULL, 1, NULL, NULL, NULL, '2026-02-23 00:03:51', '2026-02-23 00:03:51'),
(12, 'PT.MANUVER', 'bayu123@gmail.com', NULL, NULL, '$2y$12$xj76Wcwfoqtvm/jdlEfUse0ZtrflgxWBcnX/raQvAkNBF1OsyY4FO', NULL, NULL, 1, NULL, NULL, NULL, '2026-02-26 20:48:46', '2026-02-26 20:48:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_skills`
--

CREATE TABLE `user_skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `skill_id` bigint(20) UNSIGNED NOT NULL,
  `proficiency_level` int(11) NOT NULL DEFAULT 3,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_skills`
--

INSERT INTO `user_skills` (`id`, `user_id`, `skill_id`, `proficiency_level`, `created_at`, `updated_at`) VALUES
(6, 2, 1, 4, '2026-02-26 20:39:59', '2026-02-26 20:39:59'),
(7, 2, 2, 4, '2026-02-26 20:39:59', '2026-02-26 20:39:59'),
(8, 2, 3, 4, '2026-02-26 20:39:59', '2026-02-26 20:39:59'),
(9, 2, 7, 4, '2026-02-26 20:39:59', '2026-02-26 20:39:59'),
(10, 2, 10, 4, '2026-02-26 20:39:59', '2026-02-26 20:39:59'),
(11, 7, 6, 3, '2026-03-02 22:46:59', '2026-03-02 22:46:59'),
(12, 7, 2, 3, '2026-03-02 22:47:08', '2026-03-02 22:47:08');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alumni_bridge_questions`
--
ALTER TABLE `alumni_bridge_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_bridge_questions_user_id_foreign` (`user_id`),
  ADD KEY `alumni_bridge_questions_alumni_id_foreign` (`alumni_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `career_paths`
--
ALTER TABLE `career_paths`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `career_paths_slug_unique` (`slug`);

--
-- Indeks untuk tabel `career_path_courses`
--
ALTER TABLE `career_path_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `career_path_courses_career_path_id_foreign` (`career_path_id`);

--
-- Indeks untuk tabel `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`);

--
-- Indeks untuk tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`),
  ADD UNIQUE KEY `events_qrcode_token_unique` (`qrcode_token`);

--
-- Indeks untuk tabel `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_registrations_event_id_user_id_unique` (`event_id`,`user_id`),
  ADD KEY `event_registrations_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_applications_job_listing_id_user_id_unique` (`job_listing_id`,`user_id`),
  ADD KEY `job_applications_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `job_listings`
--
ALTER TABLE `job_listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_listings_company_id_foreign` (`company_id`),
  ADD KEY `job_listings_major_id_foreign` (`major_id`);

--
-- Indeks untuk tabel `job_skills`
--
ALTER TABLE `job_skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_skills_job_listing_id_skill_id_unique` (`job_listing_id`,`skill_id`),
  ADD KEY `job_skills_skill_id_foreign` (`skill_id`);

--
-- Indeks untuk tabel `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `majors_code_unique` (`code`),
  ADD KEY `majors_department_id_foreign` (`department_id`);

--
-- Indeks untuk tabel `mentoring_sessions`
--
ALTER TABLE `mentoring_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentoring_sessions_mentor_id_foreign` (`mentor_id`),
  ADD KEY `mentoring_sessions_mentee_id_foreign` (`mentee_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`),
  ADD KEY `notifications_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indeks untuk tabel `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`),
  ADD KEY `profiles_major_id_foreign` (`major_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nim_unique` (`nim`);

--
-- Indeks untuk tabel `user_skills`
--
ALTER TABLE `user_skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_skills_user_id_skill_id_unique` (`user_id`,`skill_id`),
  ADD KEY `user_skills_skill_id_foreign` (`skill_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alumni_bridge_questions`
--
ALTER TABLE `alumni_bridge_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `career_paths`
--
ALTER TABLE `career_paths`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `career_path_courses`
--
ALTER TABLE `career_path_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `event_registrations`
--
ALTER TABLE `event_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `job_listings`
--
ALTER TABLE `job_listings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `job_skills`
--
ALTER TABLE `job_skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `majors`
--
ALTER TABLE `majors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mentoring_sessions`
--
ALTER TABLE `mentoring_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `user_skills`
--
ALTER TABLE `user_skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `alumni_bridge_questions`
--
ALTER TABLE `alumni_bridge_questions`
  ADD CONSTRAINT `alumni_bridge_questions_alumni_id_foreign` FOREIGN KEY (`alumni_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `alumni_bridge_questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `career_path_courses`
--
ALTER TABLE `career_path_courses`
  ADD CONSTRAINT `career_path_courses_career_path_id_foreign` FOREIGN KEY (`career_path_id`) REFERENCES `career_paths` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD CONSTRAINT `event_registrations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_job_listing_id_foreign` FOREIGN KEY (`job_listing_id`) REFERENCES `job_listings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `job_listings`
--
ALTER TABLE `job_listings`
  ADD CONSTRAINT `job_listings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_listings_major_id_foreign` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `job_skills`
--
ALTER TABLE `job_skills`
  ADD CONSTRAINT `job_skills_job_listing_id_foreign` FOREIGN KEY (`job_listing_id`) REFERENCES `job_listings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `majors`
--
ALTER TABLE `majors`
  ADD CONSTRAINT `majors_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mentoring_sessions`
--
ALTER TABLE `mentoring_sessions`
  ADD CONSTRAINT `mentoring_sessions_mentee_id_foreign` FOREIGN KEY (`mentee_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `mentoring_sessions_mentor_id_foreign` FOREIGN KEY (`mentor_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_major_id_foreign` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`),
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_skills`
--
ALTER TABLE `user_skills`
  ADD CONSTRAINT `user_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_skills_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
