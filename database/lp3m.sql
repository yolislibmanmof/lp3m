-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 17, 2026 at 02:05 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lp3m`
--

-- --------------------------------------------------------

--
-- Table structure for table `aik_activities`
--

CREATE TABLE `aik_activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('kajian','pembinaan','dakwah','sosial','pendidikan','ramadhan','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kajian',
  `activity_date` date NOT NULL,
  `location` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `user_name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_role` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_type` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `entity_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_value` longtext COLLATE utf8mb4_unicode_ci,
  `new_value` longtext COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `user_name`, `user_role`, `action`, `entity_type`, `entity_id`, `entity_label`, `old_value`, `new_value`, `ip_address`, `user_agent`, `url`, `created_at`) VALUES
(1, 1, 'Admin LP3M', 'super_admin', 'create', 'surveys', 1, 'TES SURVEI', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '/lp3m/admin/index.php?page=survei-simpan', '2026-09-08 21:43:29'),
(2, 1, 'Admin LP3M', 'super_admin', 'update', 'surveys', 1, 'TES SURVEI', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '/lp3m/admin/index.php?page=survei-update', '2026-09-08 21:45:22'),
(3, 1, 'Admin LP3M', 'super_admin', 'toggle', 'system', NULL, 'Maintenance mode', NULL, '{\"on\":true}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '/lp3m/admin/index.php?page=backup-maintenance', '2026-09-08 23:45:26'),
(4, 1, 'Admin LP3M', 'super_admin', 'toggle', 'system', NULL, 'Maintenance mode', NULL, '{\"on\":false}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '/lp3m/admin/index.php?page=backup-maintenance', '2026-09-08 23:49:37'),
(5, 1, 'Admin LP3M', 'super_admin', 'update', 'system_settings', NULL, 'chatbot_config', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '/lp3m/admin/index.php?page=chatbot-config-save', '2026-09-09 08:15:55'),
(6, 1, 'Admin LP3M', 'super_admin', 'create', 'videos', 1, 'TESTING', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '/lp3m/admin/index.php?page=video-simpan', '2026-09-09 16:23:42');

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE `backups` (
  `id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind` enum('db','files') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'db',
  `size_bytes` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `tables_count` int(11) NOT NULL DEFAULT '0',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `broadcasts`
--

CREATE TABLE `broadcasts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `segment` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'subscribers',
  `status` enum('draft','sent','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `sent_at` datetime DEFAULT NULL,
  `sent_count` int(11) NOT NULL DEFAULT '0',
  `fail_count` int(11) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `broadcasts`
--

INSERT INTO `broadcasts` (`id`, `title`, `content`, `segment`, `status`, `sent_at`, `sent_count`, `fail_count`, `created_by`, `created_at`) VALUES
(4, 'TES', 'TES', 'subscribers', 'sent', '2026-09-09 13:17:28', 1, 0, 1, '2026-09-09 06:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `broadcast_logs`
--

CREATE TABLE `broadcast_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `broadcast_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('sent','failed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `error` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `broadcast_logs`
--

INSERT INTO `broadcast_logs` (`id`, `broadcast_id`, `email`, `status`, `error`, `created_at`) VALUES
(5, 4, 'julianusmitankesik57@gmail.com', 'sent', NULL, '2026-09-09 06:04:34'),
(6, 4, 'julianusmitankesik57@gmail.com', 'sent', NULL, '2026-09-09 06:16:04'),
(7, 4, 'julianusmitankesik57@gmail.com', 'sent', NULL, '2026-09-09 06:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holder_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holder_identity` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_type` enum('pelatihan','workshop','seminar','kkn','pengabdian','penelitian','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pelatihan',
  `issue_date` date NOT NULL,
  `signer_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Kepala LP3M',
  `signer_title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Kepala LP3M/LPPAIK',
  `signer_signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'classic',
  `status` enum('valid','revoked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'valid',
  `revoke_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `code`, `holder_name`, `holder_identity`, `activity_title`, `activity_type`, `issue_date`, `signer_name`, `signer_title`, `signer_signature`, `template`, `status`, `revoke_reason`, `created_at`, `updated_at`) VALUES
(1, 'LP3M-2026-83354E', 'Yolis Libman', '0011334455677', 'Workshop Penulisan Artikel Jurnal Bereputasi Internasional', 'workshop', '2026-09-07', 'Falentinus Hurint', 'Kepala LP3M', 'signatures/file-20260907-074257-a7eb0ddd.png', 'classic', 'valid', NULL, '2026-09-07 07:13:32', '2026-09-07 23:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_knowledge`
--

CREATE TABLE `chatbot_knowledge` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'umum',
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '50',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot_knowledge`
--

INSERT INTO `chatbot_knowledge` (`id`, `category`, `keywords`, `question`, `answer`, `priority`, `active`, `created_at`) VALUES
(1, 'layanan', 'penelitian, riset, proposal, skema', 'Bagaimana cara mengajukan proposal penelitian?', 'Untuk mengajukan proposal penelitian:\n1. Login sebagai Dosen\n2. Buka menu Penelitian → Ajukan Proposal\n3. Isi formulir (skema, judul, anggaran, tim)\n4. Unggah dokumen proposal\n5. Klik Simpan sebagai Draft atau Kirim untuk Review\n\nSkema tersedia: Internal, Hibah Dikti, Hibah Internasional.', 90, 1, '2026-09-09 00:05:16'),
(2, 'layanan', 'pengabdian, KKN, desa binaan', 'Bagaimana mendaftar program pengabdian?', 'Pendaftaran pengabdian:\n1. Login sebagai Dosen\n2. Menu Pengabdian & KKN → Pengajuan Baru\n3. Pilih skema: Reguler, KKN Tematik, atau Desa Binaan\n4. Isi data mitra, lokasi, dan rencana kegiatan\n5. Submit untuk persetujuan Ketua LP3M', 85, 1, '2026-09-09 00:05:16'),
(3, 'layanan', 'hibah, dana, pendanaan', 'Informasi hibah yang tersedia?', 'Hibah yang dibuka tahun ini:\n• Hibah Internal UNIMOF (Rp 5-15 jt)\n• Hibah Dikti Skema Dasar & Terapan\n• Hibah DRTPM Kemenristek\n• Hibah Kerja Sama Industri\n\nCek menu Hibah & Pendanaan untuk detail tenggat & persyaratan.', 88, 1, '2026-09-09 00:05:16'),
(4, 'layanan', 'sertifikat, verifikasi, keaslian', 'Cara verifikasi sertifikat?', 'Verifikasi sertifikat LP3M:\n1. Buka halaman publik → Verifikasi Sertifikat\n2. Masukkan kode sertifikat (format: LP3M-XXXX-XXXX)\n3. Sistem menampilkan status VALID/TIDAK VALID\n4. Unduh PDF resmi jika valid', 80, 1, '2026-09-09 00:05:16'),
(5, 'layanan', 'plagiat, similaritas, turnitin', 'Cara cek plagiarisme?', 'Layanan Cek Plagiat:\n1. Login admin atau publik\n2. Menu Cek Plagiat → Upload Dokumen\n3. Unggah file PDF/DOCX (maks 10 MB)\n4. Sistem analisis 1-5 menit\n5. Unduh laporan similaritas + saran', 82, 1, '2026-09-09 00:05:16'),
(6, 'layanan', 'survei, EDOM, kepuasan', 'Cara ikut survei kepuasan?', 'Survei Kepuasan LP3M:\n1. Buka halaman publik → Survei Kepuasan\n2. Pilih survei yang terbuka\n3. Isi pertanyaan (bisa anonim)\n4. Submit → dapatkan kode partisipasi\n5. Partisipasi Anda membantu peningkatan mutu layanan.', 75, 1, '2026-09-09 00:05:16'),
(7, 'info', 'jam kerja, kantor, alamat, lokasi', 'Alamat dan jam kerja LP3M?', '📍 Alamat:\nJl. Wairklau, Maumere, Sikka, NTT\n\n🕒 Jam Layanan:\nSenin-Jumat, 08.00-16.00 WITA\nSabtu-Minggu & hari libur: TUTUP\n\n📞 Telp: +62 380 000 000\n✉️ Email: lp3m@unimof.ac.id', 95, 1, '2026-09-09 00:05:16'),
(8, 'info', 'kontak, email, telepon, whatsapp', 'Bagaimana menghubungi LP3M?', 'Kontak LP3M UNIMOF:\n📧 Email: lp3m@unimof.ac.id\n📞 Telp: +62 380 000 000\n🌐 Website: lp3m.unimof.ac.id\n📍 Alamat: Jl. Wairklau, Maumere, NTT\n\nUntuk pertanyaan cepat, chat bot ini siap 24/7!', 92, 1, '2026-09-09 00:05:16'),
(9, 'info', 'AIK, Muhammadiyah, pengajian', 'Apa itu AIK?', 'AIK (Al-Islam dan Kemuhammadiyahan) adalah salah satu pilar Catur Dharma LP3M. Kegiatannya meliputi:\n• Pengajian rutin dosen & tendik\n• Kajian Ramadhan\n• Pelatihan kader Muhammadiyah\n• Pembinaan nilai Islam dalam riset\n\nLihat menu AIK untuk jadwal terbaru.', 78, 1, '2026-09-09 00:05:16'),
(10, 'info', 'HAKI, paten, hak cipta, merek', 'Apa itu HAKI dan cara mendaftarnya?', 'HAKI (Hak Kekayaan Intelektual) meliputi:\n• Paten (invensi)\n• Hak Cipta (karya tulis, software, seni)\n• Merek (logo produk)\n• Desain Industri\n\nProses:\n1. Login → Menu HAKI → Ajukan Pendaftaran\n2. Unggah dokumen karya\n3. Review oleh tim HAKI LP3M\n4. Submission ke DJKI Kemenkumham', 83, 1, '2026-09-09 00:05:16'),
(11, 'teknis', 'login, password, lupa, akun', 'Lupa password akun?', 'Reset password:\n1. Buka halaman login admin\n2. Klik \"Lupa Password?\"\n3. Masukkan email terdaftar\n4. Cek email untuk link reset\n5. Buat password baru\n\nJika email tidak diterima, hubungi admin LP3M di lp3m@unimof.ac.id', 70, 1, '2026-09-09 00:05:16'),
(12, 'teknis', 'error, masalah, bug, bantuan', 'Ada masalah teknis di website?', 'Jika menemukan kendala:\n1. Coba refresh halaman (Ctrl+F5)\n2. Hapus cache browser\n3. Gunakan browser terbaru (Chrome/Firefox)\n4. Jika masih bermasalah, laporkan ke: lp3m@unimof.ac.id dengan screenshot error', 65, 1, '2026-09-09 00:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_logs`
--

CREATE TABLE `chatbot_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bot_response` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` enum('local','ai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local',
  `confidence` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `feedback` enum('none','good','bad') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot_logs`
--

INSERT INTO `chatbot_logs` (`id`, `session_id`, `user_message`, `bot_response`, `source`, `confidence`, `feedback`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 'sess_981lfecd', 'Alamat & jam kerja?', '📍 Alamat:\nJl. Wairklau, Maumere, Sikka, NTT\n\n🕒 Jam Layanan:\nSenin-Jumat, 08.00-16.00 WITA\nSabtu-Minggu & hari libur: TUTUP\n\n📞 Telp: +62 380 000 000\n✉️ Email: lp3m@unimof.ac.id', 'local', 90, 'none', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 00:31:40'),
(2, 'sess_981lfecd', 'Cara cek plagiat?', 'Layanan Cek Plagiat:\n1. Login admin atau publik\n2. Menu Cek Plagiat → Upload Dokumen\n3. Unggah file PDF/DOCX (maks 10 MB)\n4. Sistem analisis 1-5 menit\n5. Unduh laporan similaritas + saran', 'local', 71, 'none', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 00:43:03'),
(3, 'sess_981lfecd', 'Informasi hibah yang tersedia?', 'Saya menemukan beberapa topik yang mungkin relevan:\n\n• **Informasi hibah yang tersedia?**\n\nKlik salah satu atau tanyakan lebih spesifik.', 'local', 33, 'none', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 00:43:23'),
(4, 'sess_981lfecd', 'Informasi hibah yang tersedia?', 'Saya menemukan beberapa topik yang mungkin relevan:\n\n• **Informasi hibah yang tersedia?**\n\nKlik salah satu atau tanyakan lebih spesifik.', 'local', 33, 'none', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 00:43:32'),
(5, 'sess_981lfecd', 'apa saja layanan yang tersedia?', 'Saya menemukan beberapa topik yang mungkin relevan:\n\n• **Informasi hibah yang tersedia?**\n• **Cara ikut survei kepuasan?**\n• **Bagaimana cara mengajukan proposal penelitian?**\n\nKlik salah satu atau tanyakan lebih spesifik.', 'local', 27, 'none', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 00:43:50'),
(6, 'sess_981lfecd', 'Bagaimana cara mengajukan proposal penelitian?', 'Saya menemukan beberapa topik yang mungkin relevan:\n\n• **Bagaimana cara mengajukan proposal penelitian?**\n\nKlik salah satu atau tanyakan lebih spesifik.', 'local', 50, 'none', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 00:44:09'),
(7, 'sess_981lfecd', 'Bagaimana cara mengajukan proposal penelitian?', 'Saya menemukan beberapa topik yang mungkin relevan:\n\n• **Bagaimana cara mengajukan proposal penelitian?**\n\nKlik salah satu atau tanyakan lebih spesifik.', 'local', 50, 'none', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 00:44:21'),
(8, 'sess_981lfecd', 'Alamat & jam kerja?', '📍 Alamat:\nJl. Wairklau, Maumere, Sikka, NTT\n\n🕒 Jam Layanan:\nSenin-Jumat, 08.00-16.00 WITA\nSabtu-Minggu & hari libur: TUTUP\n\n📞 Telp: +62 380 000 000\n✉️ Email: lp3m@unimof.ac.id', 'local', 90, 'none', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 00:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `community_services`
--

CREATE TABLE `community_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('pengabdian','kkn','desa_binaan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pengabdian',
  `leader` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `members` text COLLATE utf8mb4_unicode_ci,
  `location` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` smallint(5) UNSIGNED NOT NULL,
  `aik_integration` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_hours` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_embed` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `address`, `phone`, `whatsapp`, `email`, `office_hours`, `map_embed`, `updated_at`) VALUES
(1, 'Kampus UNIGO.  Limboto, Kabupaten Gorontalo, Provinsi Gorontalo - Jalan A.A. Wahab No. 247.', '+62 382 123 456', '6281234567890', 'info@unigo.ac.id', 'Senin - Jumat: 08.00 - 16.00 WITA', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2513.277378080862!2d122.98108881614235!3d0.6273910880501966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32792e0399ab155b%3A0x95829a9e9b1fdf04!2sGorontalo%20University!5e0!3m2!1sen!2sid!4v1788686386950!5m2!1sen!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"strict-origin-when-cross-origin\"></iframe>', '2026-09-06 09:36:14');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('template','pedoman','sop','formulir','surat','aik','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'template',
  `description` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `download_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `event_type` enum('penelitian','pengabdian','pelatihan','seminar','workshop','aik','rapat','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_all_day` tinyint(1) DEFAULT '0',
  `location` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organizer` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_participants` int(10) UNSIGNED DEFAULT NULL,
  `registered_count` int(10) UNSIGNED DEFAULT '0',
  `registration_link` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published','cancelled','completed') COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `reminder_h7` tinyint(1) DEFAULT '1',
  `reminder_h3` tinyint(1) DEFAULT '1',
  `reminder_h1` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_type`, `start_date`, `end_date`, `start_time`, `end_time`, `is_all_day`, `location`, `organizer`, `max_participants`, `registered_count`, `registration_link`, `banner_path`, `status`, `reminder_h7`, `reminder_h3`, `reminder_h1`, `created_at`, `updated_at`) VALUES
(1, 'Workshop Penulisan Jurnal Scopus Q1-Q2', NULL, 'workshop', '2026-09-20', '2026-09-21', NULL, NULL, 0, 'Aula UNIMOF', 'LP3M UNIMOF', NULL, 0, NULL, NULL, 'published', 1, 1, 1, '2026-09-08 00:58:26', '2026-09-08 00:58:26'),
(2, 'Seminar Nasional Hasil Penelitian 2026', NULL, 'seminar', '2026-10-15', '2026-10-15', NULL, NULL, 0, 'Hotel Sylvia Maumere', 'LP3M UNIMOF', NULL, 0, NULL, NULL, 'published', 1, 1, 1, '2026-09-08 00:58:26', '2026-09-08 00:58:26'),
(3, 'Penerjunan KKN Tematik 2026', NULL, 'pengabdian', '2026-09-25', '2026-11-25', NULL, NULL, 0, '10 Desa di Sikka', 'LP3M UNIMOF', NULL, 0, NULL, NULL, 'published', 1, 1, 1, '2026-09-08 00:58:26', '2026-09-08 00:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int(11) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Bagaimana cara mengajukan proposal penelitian internal?', 'Anda dapat mengunduh template proposal terbaru di menu Unduhan, lalu mengumpulkannya secara fisik ke kantor LP3M atau mengunggahnya melalui sistem sesuai jadwal yang tertera di menu Hibah.', 1, 1, '2026-09-06 08:15:54', '2026-09-06 08:15:54'),
(2, 'Kapan jadwal pembukaan hibah penelitian tahun ini?', 'Jadwal hibah biasanya dibuka pada awal semester ganjil (Agustus-September). Pantau terus menu Hibah Aktif atau ikuti media sosial resmi LP3M UNIMOF.', 2, 1, '2026-09-06 08:15:54', '2026-09-06 08:15:54'),
(3, 'Apakah mahasiswa boleh terlibat dalam pengabdian masyarakat?', 'Tentu saja! Mahasiswa sangat didorong untuk terlibat, baik sebagai peserta KKN maupun asisten dosen dalam skema pengabdian masyarakat.', 3, 1, '2026-09-06 08:15:54', '2026-09-06 08:15:54');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Kegiatan',
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `event_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `category`, `image_path`, `description`, `event_date`, `created_at`) VALUES
(1, 'WORKSHOP', 'Kegiatan', 'gallery/gal-20260908-201939-180b4f32.jpg', 'TESTING SLIDER', '2026-09-08', '2026-09-08 12:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `grants`
--

CREATE TABLE `grants` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('penelitian','pengabdian','publikasi','lainnya') COLLATE utf8mb4_unicode_ci DEFAULT 'penelitian',
  `deadline` date NOT NULL,
  `funding_amount` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `link_proposal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_registration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('open','closing_soon','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grants`
--

INSERT INTO `grants` (`id`, `title`, `source`, `type`, `deadline`, `funding_amount`, `description`, `link_proposal`, `link_registration`, `status`, `created_at`) VALUES
(1, 'Hibah Penelitian Internal Pemula 2026', 'LP3M', 'penelitian', '2026-10-15', 'Rp 5.000.000', 'Skema penelitian untuk dosen pemula/asesor.', '', '', 'open', '2026-09-06 02:15:00'),
(2, 'Hibah Pengabdian Masyarakat Desa Binaan', 'LP3M', 'pengabdian', '2026-09-30', 'Rp 7.500.000', 'Fokus pada pemberdayaan desa mitra.', '', '', 'closing_soon', '2026-09-06 02:15:00'),
(3, 'Penelitian Fundamental Reguler (PFR)', 'Kemendiktisaintek', 'penelitian', '2026-12-01', 'Max Rp 75.000.000', 'Hibah nasional untuk dosen S2/S3.', NULL, NULL, 'open', '2026-09-06 02:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `integrations_log`
--

CREATE TABLE `integrations_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider` enum('sinta_csv','crossref_doi','scholar','orcid') COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` enum('import','fetch','scrape','error') COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_type` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `input_query` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items_count` int(11) NOT NULL DEFAULT '0',
  `status` enum('success','partial','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'success',
  `message` text COLLATE utf8mb4_unicode_ci,
  `payload_json` longtext COLLATE utf8mb4_unicode_ci,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intellectual_properties`
--

CREATE TABLE `intellectual_properties` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('hak_cipta','paten','merek','desain_industri') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hak_cipta',
  `inventors` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft_internal','review_internal','diajukan_djki','perbaikan','sertifikat_terbit') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft_internal',
  `year` smallint(5) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('umum','penelitian','pengabdian','publikasi','haki','aik','pengumuman','agenda') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'umum',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `published_at` datetime DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `category`, `content`, `thumbnail`, `status`, `is_featured`, `views`, `published_at`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'UJI COBA BERITA', 'uji-coba-berita', 'pengumuman', 'Ini adalah uji coba fitur berita, jangan kepo ya !', 'news/file-20260906-134308-9b9cba15.png', 'published', 1, 34, '2026-09-06 13:43:08', 1, '2026-09-06 13:43:08', '2026-10-17 14:04:44');

-- --------------------------------------------------------

--
-- Table structure for table `news_tags`
--

CREATE TABLE `news_tags` (
  `news_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('info','success','warning','error','reminder') COLLATE utf8mb4_unicode_ci DEFAULT 'info',
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '?',
  `is_read` tinyint(1) DEFAULT '0',
  `is_global` tinyint(1) DEFAULT '0',
  `module_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plagiarism_checks`
--

CREATE TABLE `plagiarism_checks` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submitter_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submitter_email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitter_identity` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_type` enum('skripsi','tesis','disertasi','jurnal','artikel','makalah','proposal','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint(20) UNSIGNED DEFAULT '0',
  `word_count` int(10) UNSIGNED DEFAULT '0',
  `similarity_score` decimal(5,2) DEFAULT NULL,
  `unique_score` decimal(5,2) DEFAULT NULL,
  `ai_score` decimal(5,2) DEFAULT NULL,
  `sources_found` int(10) UNSIGNED DEFAULT '0',
  `status` enum('queued','processing','completed','failed') COLLATE utf8mb4_unicode_ci DEFAULT 'queued',
  `result_json` longtext COLLATE utf8mb4_unicode_ci,
  `source_text` mediumtext COLLATE utf8mb4_unicode_ci,
  `extract_method` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extract_pages` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `extract_chars` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `report_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checked_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plagiarism_sources`
--

CREATE TABLE `plagiarism_sources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `check_id` int(10) UNSIGNED NOT NULL,
  `source_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_title` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_type` enum('internet','publication','student_paper','journal','book') COLLATE utf8mb4_unicode_ci DEFAULT 'internet',
  `match_percentage` decimal(5,2) DEFAULT '0.00',
  `matched_text` text COLLATE utf8mb4_unicode_ci,
  `snippet` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `podcasts`
--

CREATE TABLE `podcasts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `episode` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diskusi',
  `audio_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plays` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` enum('published','draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `published_at` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE `publications` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doi` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('jurnal','prosiding','buku','book_chapter','artikel_populer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'jurnal',
  `level` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Nasional',
  `authors` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` smallint(5) UNSIGNED NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `doi_verified` tinyint(1) NOT NULL DEFAULT '0',
  `sinta_id` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scholar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `researches`
--

CREATE TABLE `researches` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `scheme` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal',
  `field` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leader` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `members` text COLLATE utf8mb4_unicode_ci,
  `funding` int(10) UNSIGNED DEFAULT '0',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `output_target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviewers`
--

CREATE TABLE `reviewers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nidn` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institution` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expertise` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('internal','eksternal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal',
  `rating` decimal(3,2) DEFAULT '5.00',
  `total_assignments` int(10) UNSIGNED DEFAULT '0',
  `total_completed` int(10) UNSIGNED DEFAULT '0',
  `honorarium_standard` bigint(20) UNSIGNED DEFAULT '0',
  `bank_account` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviewer_assignments`
--

CREATE TABLE `reviewer_assignments` (
  `id` int(10) UNSIGNED NOT NULL,
  `reviewer_id` int(10) UNSIGNED NOT NULL,
  `module_type` enum('research','community','haki','publication','plagiarism') COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` int(10) UNSIGNED NOT NULL,
  `assigned_by` int(10) UNSIGNED DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deadline` date DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `status` enum('pending','in_progress','completed','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `review_notes` text COLLATE utf8mb4_unicode_ci,
  `rating_given` decimal(3,2) DEFAULT NULL,
  `honorarium_paid` bigint(20) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'site_brand', 'LP3M', '2026-09-04 10:16:49'),
(2, 'footer_text', '© 2026 LP3M. Sistem Informasi Berbasis Catur Dharma Perguruan Tinggi Muhammadiyah.', '2026-09-04 08:43:14'),
(3, 'home_hero_title', 'Sistem Informasi LP3M', '2026-09-04 08:43:14'),
(4, 'home_hero_text', 'Platform layanan terpadu untuk Penelitian, Pengabdian kepada Masyarakat, Publikasi, HAKI, dan Al-Islam Kemuhammadiyahan berbasis Catur Dharma Perguruan Tinggi Muhammadiyah.', '2026-09-04 08:43:14'),
(5, 'home_hero_button_text', 'Tentang Lembaga', '2026-09-04 08:43:14'),
(6, 'home_section_title', 'Modul Utama', '2026-09-04 08:43:14'),
(7, 'home_card1_title', 'Penelitian', '2026-09-04 08:43:14'),
(8, 'home_card1_text', 'Pengelolaan proposal penelitian, review, laporan kemajuan, laporan akhir, dan luaran penelitian dosen.', '2026-09-04 08:43:14'),
(9, 'home_card2_title', 'Pengabdian', '2026-09-04 08:43:14'),
(10, 'home_card2_text', 'Pengelolaan pengabdian kepada masyarakat, KKN, desa binaan, mitra, dan dokumentasi kegiatan lapangan.', '2026-09-04 08:43:14'),
(11, 'home_card3_title', 'Publikasi & HAKI', '2026-09-04 08:43:14'),
(12, 'home_card3_text', 'Database publikasi ilmiah, jurnal, buku, prosiding, hak cipta, paten, dan kekayaan intelektual.', '2026-09-04 08:43:14'),
(13, 'home_card4_title', 'AIK / Catur Dharma', '2026-09-04 08:43:14'),
(14, 'home_card4_text', 'Dokumentasi dan integrasi nilai Al-Islam dan Kemuhammadiyahan dalam seluruh aktivitas catur dharma perguruan tinggi.', '2026-09-04 08:43:14'),
(15, 'about_hero_title', 'Tentang LP3M', '2026-09-04 10:16:49'),
(16, 'about_hero_text', 'Lembaga yang mengelola penelitian, pengabdian kepada masyarakat, serta integrasi Al-Islam dan Kemuhammadiyahan dalam pelaksanaan Catur Dharma Perguruan Tinggi Muhammadiyah.', '2026-09-04 08:43:14'),
(17, 'about_profile_text', 'LP3M adalah lembaga penunjang akademik untuk seluruh Universitas Muhammadiyah, yang bertugas mengoordinasikan, melaksanakan, dan mengembangkan kegiatan penelitian, pengabdian kepada masyarakat, serta pembinaan Al-Islam dan Kemuhammadiyahan.', '2026-09-05 12:05:20'),
(18, 'about_history_text', 'Cikal bakal lembaga ini bermula dari unit penelitian Seluruh Kampus Muhammadiyah. Seiring transformasi yang terjadi, seluruh Universitas Muhammadiyah membuat lembaga ini berkembang menjadi LP3M/LPPAIK yang menaungi penelitian, pengabdian, dan Al-Islam Kemuhammadiyahan.', '2026-09-05 12:05:20'),
(19, 'about_vision_text', 'Menjadi lembaga penelitian, pengabdian, dan pembinaan Al-Islam Kemuhammadiyahan yang unggul, berkemajuan, dan berdampak bagi masyarakat.', '2026-09-04 08:43:14'),
(20, 'about_mission_text', '1. Mengembangkan penelitian berkualitas yang bermanfaat bagi ilmu pengetahuan dan masyarakat.\r\n2. Meningkatkan pengabdian kepada masyarakat yang memberdayakan.\r\n3. Mengintegrasikan nilai Al-Islam dan Kemuhammadiyahan dalam seluruh kegiatan.\r\n4. Memperluas publikasi ilmiah dan kekayaan intelektual.', '2026-09-04 08:43:14'),
(21, 'about_structure_text', 'Ketua | Yolis Libman\r\nSekretaris | Milan\r\nDivisi Penelitian | Vela\r\nDivisi Pengabdian | Kiano\r\nDivisi AIK | Petrus', '2026-09-05 12:05:20'),
(43, 'logo_path', 'settings/file-20260908-191551-1c9b347f.png', '2026-09-08 11:15:51'),
(65, 'favicon_path', 'settings/file-20260908-193747-9bd354a5.ico', '2026-09-08 11:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','unsubscribed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `source` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'footer',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `name`, `token`, `status`, `source`, `created_at`) VALUES
(7, 'julianusmitankesik57@gmail.com', NULL, '12ea34b1d8bc5bf7a89944829ebd884b', 'active', 'footer', '2026-09-09 06:04:04');

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `target_audience` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'umum',
  `status` enum('draft','open','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `title`, `description`, `target_audience`, `status`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'TES SURVEI', 'INI ADALAH TEST SEMATA', 'umum', 'open', '2026-09-08', '2026-09-11', '2026-09-08 14:43:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `survey_answers`
--

CREATE TABLE `survey_answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `response_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `rating_value` tinyint(4) DEFAULT NULL,
  `choice_value` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_value` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `survey_answers`
--

INSERT INTO `survey_answers` (`id`, `response_id`, `question_id`, `rating_value`, `choice_value`, `text_value`) VALUES
(1, 1, 2, NULL, 'Sangat Puas', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `survey_questions`
--

CREATE TABLE `survey_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('rating','choice','text') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rating',
  `options` text COLLATE utf8mb4_unicode_ci,
  `required` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `survey_questions`
--

INSERT INTO `survey_questions` (`id`, `survey_id`, `question`, `type`, `options`, `required`, `sort_order`, `created_at`) VALUES
(2, 1, 'Apakah pelayanan kami memuaskan kalian?', 'choice', '[\"Sangat Puas\",\"Puas\",\"Kurang Puas\"]', 1, 0, '2026-09-08 14:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `survey_responses`
--

CREATE TABLE `survey_responses` (
  `id` int(10) UNSIGNED NOT NULL,
  `survey_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `respondent_name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respondent_email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respondent_role` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `survey_responses`
--

INSERT INTO `survey_responses` (`id`, `survey_id`, `token`, `respondent_name`, `respondent_email`, `respondent_role`, `ip_address`, `created_at`) VALUES
(1, 1, '859936883203041a', 'Falentinus', 'libmanozhez57@gmail.com', 'Dosen', '::1', '2026-09-08 14:45:36');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `skey` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `svalue` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`skey`, `svalue`, `updated_at`) VALUES
('chatbot_ai_key', '', '2026-09-09 01:15:55'),
('chatbot_ai_model', 'google/gemini-2.0-flash-exp:free', '2026-09-09 01:15:55'),
('chatbot_ai_prompt', 'Anda adalah \"Siti\", asisten virtual resmi LP3M (Lembaga Penelitian, Pengabdian kepada Masyarakat, dan Al-Islam Kemuhammadiyahan ).\r\n\r\nKepribadian: ramah, profesional, singkat (maks 4 kalimat), menggunakan bahasa Indonesia baku yang hangat. Selalu akhiri dengan ajakan bertindak jika memungkinkan.\r\n\r\nTopik yang bisa dijawab: penelitian, pengabdian, publikasi, HAKI, AIK, hibah, sertifikat, cek plagiat, survei kepuasan, jadwal, dan kontak LP3M.\r\n\r\nJika ditanya di luar konteks LP3M/pendidikan tinggi, tolak dengan sopan dan arahkan ke topik yang relevan.\r\n\r\nContoh jawaban:\r\n\"Untuk mengajukan hibah internal, login sebagai Dosen lalu buka menu Hibah → Pengajuan Baru. Tenggat periode ini adalah 30 Oktober 2026. Ada yang bisa saya bantu lebih lanjut?\"', '2026-09-09 01:15:55'),
('maintenance', '0', '2026-09-08 16:49:37'),
('maintenance_message', 'Sistem informasi LP3M sedang dalam peningkatan layanan. Kami akan kembali dalam beberapa saat. Terima kasih atas pengertian Anda.', '2026-09-08 16:45:26');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin_lp3m','dosen','reviewer','pimpinan','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin_lp3m',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nidn` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institution` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `scholar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sinta_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orcid` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `is_active`, `created_at`, `updated_at`, `phone`, `last_login_at`, `photo`, `nidn`, `institution`, `bio`, `scholar_url`, `sinta_url`, `orcid`) VALUES
(1, 'Admin LP3M', 'admin@unimof.ac.id', '$2y$10$yaX8lkyVswj5aTCPkIGh5u4QiHLgBwkA/aXyHlPgOVXvviY3Z2A36', 'super_admin', 1, '2026-09-04 06:56:55', '2026-09-04 06:56:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'lainnya',
  `source` enum('youtube','vimeo','mp4') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'youtube',
  `youtube_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` enum('published','draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `published_at` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `description`, `category`, `source`, `youtube_id`, `video_url`, `thumbnail`, `duration`, `views`, `status`, `published_at`, `created_by`, `created_at`) VALUES
(1, 'TESTING', '', 'lainnya', 'youtube', 'Lbxa4Ys27bg', NULL, NULL, NULL, 2, 'published', '2026-09-09 17:23:42', 1, '2026-09-09 09:23:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aik_activities`
--
ALTER TABLE `aik_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_aik_user` (`user_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_entity` (`entity_type`,`entity_id`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kind` (`kind`);

--
-- Indexes for table `broadcasts`
--
ALTER TABLE `broadcasts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_bc_status` (`status`);

--
-- Indexes for table `broadcast_logs`
--
ALTER TABLE `broadcast_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_bl_broadcast` (`broadcast_id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `chatbot_knowledge`
--
ALTER TABLE `chatbot_knowledge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cat` (`category`),
  ADD KEY `idx_active` (`active`);
ALTER TABLE `chatbot_knowledge` ADD FULLTEXT KEY `idx_search` (`keywords`,`question`,`answer`);

--
-- Indexes for table `chatbot_logs`
--
ALTER TABLE `chatbot_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_session` (`session_id`),
  ADD KEY `idx_feedback` (`feedback`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `community_services`
--
ALTER TABLE `community_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cs_user` (`user_id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_documents_user` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_dates` (`start_date`,`end_date`),
  ADD KEY `idx_type` (`event_type`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grants`
--
ALTER TABLE `grants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `integrations_log`
--
ALTER TABLE `integrations_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_provider` (`provider`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `intellectual_properties`
--
ALTER TABLE `intellectual_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ip_user` (`user_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_news_user` (`user_id`);

--
-- Indexes for table `news_tags`
--
ALTER TABLE `news_tags`
  ADD PRIMARY KEY (`news_id`,`tag_id`),
  ADD KEY `fk_nt_tags` (`tag_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`,`is_read`),
  ADD KEY `idx_created` (`created_at`),
  ADD KEY `idx_module` (`module_type`,`module_id`);

--
-- Indexes for table `plagiarism_checks`
--
ALTER TABLE `plagiarism_checks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_code` (`code`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_submitter` (`submitter_email`);

--
-- Indexes for table `plagiarism_sources`
--
ALTER TABLE `plagiarism_sources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_check` (`check_id`),
  ADD KEY `idx_percentage` (`match_percentage`);

--
-- Indexes for table `podcasts`
--
ALTER TABLE `podcasts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pod_status` (`status`),
  ADD KEY `idx_pod_cat` (`category`);

--
-- Indexes for table `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pub_user` (`user_id`),
  ADD KEY `idx_doi` (`doi`);

--
-- Indexes for table `researches`
--
ALTER TABLE `researches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_research_status` (`status`),
  ADD KEY `idx_research_year` (`year`),
  ADD KEY `idx_research_scheme` (`scheme`);

--
-- Indexes for table `reviewers`
--
ALTER TABLE `reviewers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_active` (`is_active`),
  ADD KEY `idx_expertise` (`expertise`(100));

--
-- Indexes for table `reviewer_assignments`
--
ALTER TABLE `reviewer_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviewer_id` (`reviewer_id`),
  ADD KEY `idx_module` (`module_type`,`module_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_deadline` (`deadline`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_sub_email` (`email`),
  ADD KEY `idx_sub_status` (`status`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_answers`
--
ALTER TABLE `survey_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sa_response` (`response_id`),
  ADD KEY `fk_sa_question` (`question_id`);

--
-- Indexes for table `survey_questions`
--
ALTER TABLE `survey_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sq_survey` (`survey_id`);

--
-- Indexes for table `survey_responses`
--
ALTER TABLE `survey_responses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_token` (`token`),
  ADD KEY `fk_sr_survey` (`survey_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`skey`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vid_status` (`status`),
  ADD KEY `idx_vid_cat` (`category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aik_activities`
--
ALTER TABLE `aik_activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `backups`
--
ALTER TABLE `backups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `broadcasts`
--
ALTER TABLE `broadcasts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `broadcast_logs`
--
ALTER TABLE `broadcast_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chatbot_knowledge`
--
ALTER TABLE `chatbot_knowledge`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `chatbot_logs`
--
ALTER TABLE `chatbot_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `community_services`
--
ALTER TABLE `community_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grants`
--
ALTER TABLE `grants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `integrations_log`
--
ALTER TABLE `integrations_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intellectual_properties`
--
ALTER TABLE `intellectual_properties`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plagiarism_checks`
--
ALTER TABLE `plagiarism_checks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plagiarism_sources`
--
ALTER TABLE `plagiarism_sources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `podcasts`
--
ALTER TABLE `podcasts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `researches`
--
ALTER TABLE `researches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviewers`
--
ALTER TABLE `reviewers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviewer_assignments`
--
ALTER TABLE `reviewer_assignments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `survey_answers`
--
ALTER TABLE `survey_answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `survey_questions`
--
ALTER TABLE `survey_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `survey_responses`
--
ALTER TABLE `survey_responses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aik_activities`
--
ALTER TABLE `aik_activities`
  ADD CONSTRAINT `fk_aik_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `community_services`
--
ALTER TABLE `community_services`
  ADD CONSTRAINT `fk_cs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `fk_documents_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `intellectual_properties`
--
ALTER TABLE `intellectual_properties`
  ADD CONSTRAINT `fk_ip_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `news_tags`
--
ALTER TABLE `news_tags`
  ADD CONSTRAINT `fk_nt_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_nt_tags` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `plagiarism_sources`
--
ALTER TABLE `plagiarism_sources`
  ADD CONSTRAINT `plagiarism_sources_ibfk_1` FOREIGN KEY (`check_id`) REFERENCES `plagiarism_checks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `publications`
--
ALTER TABLE `publications`
  ADD CONSTRAINT `fk_pub_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviewer_assignments`
--
ALTER TABLE `reviewer_assignments`
  ADD CONSTRAINT `reviewer_assignments_ibfk_1` FOREIGN KEY (`reviewer_id`) REFERENCES `reviewers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `survey_answers`
--
ALTER TABLE `survey_answers`
  ADD CONSTRAINT `fk_sa_question` FOREIGN KEY (`question_id`) REFERENCES `survey_questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sa_response` FOREIGN KEY (`response_id`) REFERENCES `survey_responses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `survey_questions`
--
ALTER TABLE `survey_questions`
  ADD CONSTRAINT `fk_sq_survey` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `survey_responses`
--
ALTER TABLE `survey_responses`
  ADD CONSTRAINT `fk_sr_survey` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
