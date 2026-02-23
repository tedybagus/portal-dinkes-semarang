-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2026 at 02:42 PM
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
-- Database: `news-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `file_path`, `file_name`, `file_type`, `file_size`, `image`, `is_active`, `view_count`, `is_pinned`, `start_date`, `end_date`, `created_at`, `updated_at`, `created_by`) VALUES
(2, 'HKN ke 62 Dinas Kesehatan Kabupaten Semarang', 'HKN ke 62 Dinas Kesehatan Kabupaten Semarang', NULL, NULL, NULL, NULL, 'announcements/images/dEfQ8B12MfQ9AFACTM7QXei3J7L7NUgievFzW5Cs.png', 1, 6, 0, '2026-02-21 16:14:00', '2026-02-22 16:14:00', '2026-02-21 16:14:14', '2026-02-22 03:48:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected','published') NOT NULL DEFAULT 'pending',
  `views` int(11) NOT NULL DEFAULT 0,
  `rejection_reason` text DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `article_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `content`, `image`, `category_id`, `author_id`, `department_id`, `reviewer_id`, `status`, `views`, `rejection_reason`, `reviewed_at`, `published_at`, `article_date`, `created_at`, `updated_at`) VALUES
(1, 'Waspada Super Flu: Kenali Gejala dan Cara Menanganinya', 'waspada-super-flu-kenali-gejala-dan-cara-menanganinya', 'Super flu adalah varian baru virus influenza yang belakangan ini dilaporkan telah masuk ke Indonesia dengan tingkat penularan yang sangat agresif.\r\n\r\nMeskipun secara medis diidentifikasi sebagai influenza A subvarian H3N2 dengan subclade K, kecepatan penyebarannya telah memicu perhatian serius dari otoritas kesehatan global dan nasional karena kemampuannya memicu gejala yang lebih berat dibandingkan flu musiman biasa.\r\n\r\nPenting bagi kamu untuk memahami bahwa varian ini bukan sekadar flu biasa. Dengan risiko komplikasi yang lebih tinggi pada kelompok rentan seperti anak-anak dan lansia, pemahaman mendalam mengenai karakteristik virus ini menjadi krusial.\r\n\r\nYuk, pahami lebih dalam tentang varian baru yang satu ini supaya kamu makin waspada!\r\nApa Itu Super Flu?\r\nIstilah super flu sebenarnya merupakan sebutan populer bagi varian virus influenza yang jauh lebih agresif. Secara ilmiah, virus ini diidentifikasi sebagai influenza A H3N2 subclade K.\r\n\r\nVarian ini pertama kali teridentifikasi oleh CDC Amerika Serikat pada Agustus 2025 dan hingga kini dilaporkan telah menyebar di lebih dari 80 negara di seluruh dunia.\r\n\r\nKarakteristik utama dari super flu adalah kemampuannya menyebar dengan sangat cepat di tengah populasi. Hal ini disebabkan oleh mutasi genetik pada virus yang membuatnya lebih efektif dalam menginfeksi sel pernapasan manusia.\r\n\r\nDi Amerika Serikat saja, varian ini telah menyebabkan jutaan orang terinfeksi, dengan angka rawat inap mencapai puluhan ribu pasien dalam waktu singkat.\r\n\r\nMeskipun bukan terminologi medis resmi, nama super flu digunakan untuk menggambarkan betapa agresifnya subvarian ini dibandingkan influenza musiman biasa.\r\n\r\nSebaran Kasus Super Flu di Indonesia\r\nHingga akhir Desember 2025, Kementerian Kesehatan RI melaporkan setidaknya terdapat 62 kasus super flu yang terkonfirmasi melalui pemeriksaan Whole Genome Sequencing (WGS).\r\n\r\nKasus ini pertama kali terdeteksi masuk ke Indonesia sejak Agustus 2025 dan kini telah tersebar di delapan provinsi. Adapun tiga provinsi dengan jumlah kasus terbanyak antara lain:\r\nJawa Timur\r\nKalimantan Selatan\r\nJawa Barat\r\nData menunjukkan bahwa sebagian besar kasus ditemukan pada perempuan dan kelompok usia anak-anak. Namun, para ahli kesehatan mengingatkan bahwa angka 62 kasus ini kemungkinan besar hanyalah fenomena gunung es.\r\n\r\nMengingat surveilans genomik yang masih terbatas, jumlah kasus super flu di masyarakat diprediksi jauh lebih banyak dari yang tercatat secara resmi.', 'articles/c10X1O71wOjVConuEIDFuZgDLtdkpwyGdofieesr.jpg', 6, 5, 1, 2, 'published', 58, NULL, '2026-02-02 13:54:05', '2026-02-02 13:54:30', '2026-02-02', '2026-02-02 13:53:46', '2026-02-07 17:55:18'),
(2, 'Gerakan Masyarakat Hidup Sehat (GERMAS)', 'gerakan-masyarakat-hidup-sehat-germas', '7 Langkah Gerakan Masyarakat Hidup Sehat\r\nSetidaknya terdapat 7 langkah penting dalam rangka menjalankan Gerakan Masyarakat Hidup Sehat. Ketujuh langkah tersebut merupakan bagian penting dari pembiasaan pola hidup sehat dalam masyarakat guna mencegah berbagai masalah kesehatan yang beresiko dialami oleh masyarakat Indonesia. Berikut ini 7 langkah GERMAS yang dapat menjadi panduan menjalani pola hidup yang lebih sehat.\r\n\r\nMelakukan Aktivitas Fisik\r\nPerilaku kehidupan modern seringkali membuat banyak orang minim melakukan aktivitas fisik; baik itu aktivitas fisik karena bekerja maupun berolah raga. Kemudahan – kemudahan dalam kehidupan sehari – hari karena bantuan teknologi dan minimnya waktu karena banyaknya kesibukan telah menjadikan banyak orang menjalani gaya hidup yang kurang sehat. Bagian germas aktivitas fisik merupakan salah satu gerakan yang diutamakan untuk meningkatkan kualitas kesehatan seseorang.\r\n\r\nMakan Buah dan Sayur\r\nKeinginan untuk makan makanan praktis dan enak seringkali menjadikan berkurangnya waktu untuk makan buah dan sayur yang sebenarnya jauh lebih sehat dan bermanfaat bagi kesehatan tubuh. Beberapa jenis makanan dan minuman seperti junk food dan minuman bersoda sebaiknya dikurangi atau dihentikan konsumsinya. Menambah jumlah konsumsi makanan dari buah dan sayur merupakan contoh GERMAS yang dapat dilakukan oleh siapapun.\r\n\r\nMasalah selanjutnya adalah bagaimana cara mengatasi agar anak mau makan buah dan sayur, untuk hal ini anda dapat mengaplikasikan jurus tips anak mau makan buah dan sayur sebagai berikut yaitu salah satunya dengan mengkreasikan makanan dari buah dan sayur dengan mengubahnya menjadi tampilan yang menarik, contohnya dari karakter kartun yang disukai anak menggunakan buah tomat dan sayur ketimun sehingga tadinya anak susah makan buah dan sayur menjadi mau makan sayur dan buah\r\n\r\nAdapun salah satu kampanye GERMAS adalah kampanye makan buah dan sayur yang memberikan informasi betapa besarnya manfaat  dan kenapa harus makan buah dan sayur setiap hari. Karena anda harus memahami pentingnya kenapa harus makan buah dan sayur setiap hari, berikut adalah dampak akibat kurang makan buah dan sayur untuk kesehatan tubuh, contohnya seperti permasalahan BAB, peningkatan risiko penyakit tidak menular, tekan darah tinggi dan lainnya.\r\n\r\nDengan memahami pentingnya perilaku makan buah dan sayur, diharapkan masyarakat dapat dengan lebih aktif untuk meningkatkan kampanye makan buah dan sayur untuk tingkatkan kesehatan masyarakat di seluruh Indonesia\r\n \r\nTidak Merokok\r\nMerokok merupakan kebiasaan yang banyak memberi dampak buruk bagi kesehatan. Berhenti merokok menjadi bagian penting dari gerakan hidup sehat dan akan berdampak tidak pada diri perokok; tetapi juga bagi orang – orang di sekitarnya. Meminta bantuan ahli melalui hipnosis atau metode bantuan berhenti merokok yang lain dapat menjadi alternatif untuk menghentikan kebiasaan buruk tersebut.\r\n\r\nTidak Mengkonsumsi Minuman Beralkohol\r\nMinuman beralkohol memiliki efek buruk yang serupa dengan merokok; baik itu efek buruk bagi kesehatan hingga efek sosial pada orang – orang di sekitarnya.\r\n\r\nMelakukan Cek Kesehatan Berkala\r\nSalah satu bagian dari arti germas sebagai gerakan masyarakat hidup sehat adalah dengan lebih baik dalam mengelola kesehatan. Diantaranya adalah dengan melakukan cek kesehatan secara rutin dan tidak hanya datang ke rumah sakit atau puskesmas ketika sakit saja. Langkah ini memiliki manfaat untuk dapat memudahkan mendeteksi penyakit atau masalah kesehatan lebih dini. \r\n\r\nAda beragam informasi media cek kesehatan yang memberikan tips cek kesehatan secara berkala, apa saja sebenarnya jenis cek kesehatan berkala yang dapat anda lakukan untuk mengetahui kondisi kesehatan anda? Berikut adalah beberapa contoh pengecekan yang bisa dilakukan.\r\n\r\nCek Kesehatan Berat Badan (BB) dan Tinggi Badan (TB) Secara Rutin\r\nMelakukan Pengecekan Berat Badan berguna agar anda bisa mendapatkan nilai Indeks Massa Tubuh (IMT) yang nantinya dapat menentukan apakah berat badan dan tinggi badan Anda sudah berada dalam kondisi ideal atau berisiko terkena penyakit tidak menular (PTM)\r\n\r\nCek Lingkar Perut Secara Berkala\r\nDengan melakukan Cek Lingkar Perut secara berkala anda bisa mengontrol lemak perut, jika berlebihan dapat menyebabkan penyakit seperti stroke, diabetes hingga serangan jantung\r\n\r\nCek Tekanan Darah\r\nPengecekan Tekanan Darah dapat membantu anda mendeteksi adanya risiko stroke, hipertensi hingga jantung\r\n\r\nCek Kadar Gula Darah Berkala\r\nAnda dapat mengetahui kadar glukosa dalam darah dengan jenis pengecekan kesehatan berkala ini, hasilnya anda dapat mengetahui potensi diabetes\r\n\r\nCek Fungsi Mata Telinga\r\n\r\nCek Kolesterol Tetap\r\nPengecekan Kolesterol terbagi tiga yaitu LDL (Kolesterol \"Buruk\"), HDL (Kolesterol \"Baik\") dan Trigliserida\r\n\r\nCek Arus Puncak Ekspirasi\r\nPengecekan ini adalah salah satu cek kesehatan dalam pengujian fungsi paru, pengecekan ini biasa dilakukan pada penderita asma atau penyakit lainnya untuk menilai kemampuan paru-paru\r\n\r\nCek dan Deteksi Dini Kanker Leher Rahim\r\nPengecekan ini biasanya dilakukan dengan pemeriksaan berkala seperti Test PAP SMEAR dan Test IVA\r\n\r\nCek Sadari Periksa Payudara Sendiri\r\nLalu berikutnya dalam ragam cek kesehatan berkala yaitu dengan pemeriksaan payudara sendiri.\r\n\r\nMenjaga Kebersihan Lingkungan\r\nBagian penting dari germas hidup sehat juga berkaitan dengan meningkatkan kualitas lingkungan; salah satunya dengan lebih serius menjaga kebersihan lingkungan. Menjaga kebersihan lingkungan dalam skala kecil seperti tingkat rumah tangga dapat dilakukan dengan pengelolaan sampah. Langkah lain yang dapat dilakukan adalah menjaga kebersihan guna mengurangi resiko kesehatan seperti mencegah perkembangan vektor penyakit yang ada di lingkungan sekitar.\r\n\r\nMenggunakan Jamban\r\nAspek sanitasi menjadi bagian penting dari gerakan masyarakat hidup sehat; salah satunya dengan menggunakan jamban sebagai sarana pembuangan kotoran. Aktivitas buang kotoran di luar jamban dapat meningkatkan resiko penularan berbagai jenis penyakit sekaligus menurunkan kualitas lingkungan.', 'articles/VJgwzJTp1Pydddbm1QOwn5W9dpXOb542pg2fOFXN.png', 5, 5, 1, 2, 'published', 9, NULL, '2026-02-03 01:36:27', '2026-02-03 01:36:49', '2026-02-03', '2026-02-03 01:36:08', '2026-02-07 17:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `article_comments`
--

CREATE TABLE `article_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_comments`
--

INSERT INTO `article_comments` (`id`, `article_id`, `name`, `comment`, `rating`, `status`, `ip_address`, `user_agent`, `approved_at`, `approved_by`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, 1, 'tedy', 'bagus setiawan', 5, 'approved', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 13:22:02', 1, NULL, '2026-02-03 13:21:29', '2026-02-03 13:22:02'),
(2, 1, 'Aulia Halimatus', 'ngentutan terus nggebret-ngebret', 5, 'rejected', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 1, 'maaf bahasanya kurang sopan', '2026-02-03 14:06:00', '2026-02-03 14:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Berita Utama', 'berita-utama', 'Berita utama dan terkini', 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(2, 'Politik', 'politik', 'Berita seputar politik', 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(3, 'Ekonomi', 'ekonomi', 'Berita ekonomi dan bisnis', 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(4, 'Teknologi', 'teknologi', 'Berita teknologi dan inovasi', 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(5, 'Olahraga', 'olahraga', 'Berita olahraga dan pertandingan', 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(6, 'Kesehatan', 'kesehatan', 'Berita kesehatan dan gaya hidup', 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(7, 'Pendidikan', 'pendidikan', 'Berita pendidikan dan pembelajaran', 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `complaint_service_id` bigint(20) UNSIGNED NOT NULL,
  `reporter_name` varchar(255) NOT NULL,
  `reporter_nik` varchar(16) DEFAULT NULL,
  `reporter_address` text DEFAULT NULL,
  `reporter_phone` varchar(20) NOT NULL,
  `reporter_email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` text DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `evidence_file` varchar(255) DEFAULT NULL,
  `evidence_file_size` varchar(255) DEFAULT NULL,
  `status` enum('submitted','verified','in_progress','resolved','closed','rejected') NOT NULL DEFAULT 'submitted',
  `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
  `admin_notes` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `response_file` varchar(255) DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `satisfaction_rating` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `download_count` int(11) NOT NULL DEFAULT 0,
  `verified_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `ticket_number`, `complaint_service_id`, `reporter_name`, `reporter_nik`, `reporter_address`, `reporter_phone`, `reporter_email`, `subject`, `description`, `location`, `incident_date`, `evidence_file`, `evidence_file_size`, `status`, `priority`, `admin_notes`, `response`, `response_file`, `assigned_to`, `satisfaction_rating`, `feedback`, `view_count`, `download_count`, `verified_at`, `resolved_at`, `closed_at`, `created_at`, `updated_at`) VALUES
(1, 'ADU-20260214-WUO1', 2, 'tedy bagus setiawan', '3322071606940001', 'banyubiru', '085875037200', 'bagusawan08@gmail.com', 'pengaduan nakes', 'pelayanan kurang baik', 'puskesmas leyangan', '2026-02-13', 'complaint-evidence/gdfQj8KLeczl0bxqGUIdCs1p6IVPwnE6xeGiPcT7.pdf', '1.33 MB', 'verified', 'high', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2026-02-14 04:11:28', '2026-02-14 16:04:20'),
(2, 'ADU-20260214-M19C', 1, 'tedy bagus', '3322071606940001', 'banyubiru', '085875037200', 'bagusawan08@gmail.com', 'faskes', 'rsgm tidak melayani sepenuh hati', 'rsgm', '2026-02-12', 'complaint-evidence/Coqt5HIGPmzHdCyErrxhNGSX5ZhNRfRwUisol4qc.pdf', '95.1 KB', 'verified', 'medium', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2026-02-14 04:37:03', '2026-02-14 16:05:16'),
(3, 'ADU-20260214-N9G1', 3, 'bagus', NULL, 'banyubiru', '085875037200', 'tedy.bagus@gmail.com', 'nakes bidan', 'bidan galak sekali marah-marah terus tidak ramah', 'pkm ungaran', '2026-02-12', 'complaint-evidence/PGEanmQUilcxdGdcf52xso1yCmnuGnBQE6RXb7FF.pdf', '862.98 KB', 'resolved', 'high', 'pengaduan saudara sudah kami tindak lanjuti', 'pengaduan saudara sudah kami tindak lanjuti', NULL, 'Budi Ariyawan', 5, 'baik, terimakasih atas respon bapak', 0, 0, NULL, '2026-02-14 16:02:11', '2026-02-14 16:02:43', '2026-02-14 04:39:56', '2026-02-14 16:03:52'),
(4, 'ADU-20260216-FE55', 1, 'Test', NULL, NULL, '08123456789', NULL, 'Test', 'Test description more than 20 chars', NULL, NULL, NULL, NULL, 'submitted', 'medium', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2026-02-16 06:31:35', '2026-02-16 06:31:35'),
(5, 'ADU-20260216-HR50', 1, 'Test User', NULL, NULL, '08123456789', NULL, 'Test Subject', 'Test description with more than 20 characters', NULL, NULL, NULL, NULL, 'submitted', 'medium', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2026-02-16 06:31:55', '2026-02-16 06:31:55'),
(6, 'ADU-20260216-TUGB', 1, 'tedy', '3322071606940001', 'banyubiru', '085875037200', 'tedy@gmail.com', 'layanan fasyankes', 'layanan di puskesmas banyubiru tidak bagus', 'puskesmas banyubiru', '2026-02-13', 'complaint-evidence/ZURqoREsP3oPJ7TkgZ7TuqKmTnNl6atH9hDhlWcJ.pdf', '862.98 KB', 'submitted', 'medium', NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, NULL, NULL, NULL, '2026-02-16 06:33:53', '2026-02-16 06:40:03');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_flows`
--

CREATE TABLE `complaint_flows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `step_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `duration_days` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaint_flows`
--

INSERT INTO `complaint_flows` (`id`, `step_number`, `title`, `description`, `icon`, `duration_days`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pengaduan Diterima', 'Pengaduan Anda telah diterima oleh sistem dan menunggu verifikasi', 'fa-inbox', 0, 1, 1, '2026-02-13 15:31:26', '2026-02-13 15:31:26'),
(2, 2, 'Verifikasi', 'Tim kami sedang memverifikasi kelengkapan data pengaduan Anda', 'fa-check-circle', 2, 2, 1, '2026-02-13 15:31:26', '2026-02-13 15:31:26'),
(3, 3, 'Dalam Proses', 'Pengaduan Anda sedang ditindaklanjuti oleh tim terkait', 'fa-cog', 7, 3, 1, '2026-02-13 15:31:26', '2026-02-13 15:31:26'),
(4, 4, 'Selesai', 'Pengaduan Anda telah diselesaikan dan menunggu feedback', 'fa-check-double', 1, 4, 1, '2026-02-13 15:31:26', '2026-02-13 15:31:26'),
(5, 5, 'Ditutup', 'Pengaduan telah ditutup setelah mendapat feedback dari Anda', 'fa-times-circle', 0, 5, 1, '2026-02-13 15:31:26', '2026-02-13 15:31:26');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_histories`
--

CREATE TABLE `complaint_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `complaint_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('submitted','verified','in_progress','resolved','closed','rejected') NOT NULL,
  `description` text NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaint_histories`
--

INSERT INTO `complaint_histories` (`id`, `complaint_id`, `status`, `description`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'submitted', 'Pengaduan baru diajukan oleh tedy bagus setiawan', 'System', '2026-02-14 04:11:28', '2026-02-14 04:11:28'),
(2, 2, 'submitted', 'Pengaduan baru diajukan oleh tedy bagus', 'System', '2026-02-14 04:37:03', '2026-02-14 04:37:03'),
(3, 3, 'submitted', 'Pengaduan baru diajukan oleh bagus', 'System', '2026-02-14 04:39:56', '2026-02-14 04:39:56'),
(4, 3, 'in_progress', 'Status diubah dari \"Diajukan\" ke \"Sedang Diproses\". Tanggapan: baik akan kami tindak lanjuti laporan saudara', 'Super Administrator', '2026-02-14 14:39:21', '2026-02-14 14:39:21'),
(5, 3, 'resolved', 'Status diubah dari \"Sedang Diproses\" ke \"Diselesaikan\". Tanggapan: pengaduan saudara sudah kami tindak lanjuti', 'Super Administrator', '2026-02-14 16:02:11', '2026-02-14 16:02:11'),
(6, 3, 'closed', 'Pengaduan ditutup dengan rating 5 bintang', 'bagus', '2026-02-14 16:02:43', '2026-02-14 16:02:43'),
(7, 3, 'resolved', 'Status diubah ke Diselesaikan', 'Super Administrator', '2026-02-14 16:03:52', '2026-02-14 16:03:52'),
(8, 2, 'verified', 'Status diubah ke Diverifikasi', 'Super Administrator', '2026-02-14 16:04:12', '2026-02-14 16:04:12'),
(9, 1, 'verified', 'Status diubah ke Diverifikasi', 'Super Administrator', '2026-02-14 16:04:20', '2026-02-14 16:04:20'),
(10, 6, 'submitted', 'Pengaduan baru diajukan oleh tedy', 'System', '2026-02-16 06:33:53', '2026-02-16 06:33:53');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_services`
--

CREATE TABLE `complaint_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#3b82f6',
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaint_services`
--

INSERT INTO `complaint_services` (`id`, `name`, `slug`, `description`, `icon`, `color`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Layanan Kesehatan', 'layanan-kesehatan', 'Pengaduan terkait pelayanan rumah sakit, puskesmas, klinik, dan fasilitas kesehatan lainnya', 'fa-hospital', '#3b82f6', 1, 1, '2026-02-13 15:31:26', '2026-02-13 15:31:26'),
(2, 'Fasilitas Kesehatan', 'fasilitas-kesehatan', 'Pengaduan terkait kondisi gedung, peralatan, kebersihan, dan fasilitas kesehatan', 'fa-building', '#10b981', 2, 1, '2026-02-13 15:31:26', '2026-02-13 15:31:26'),
(3, 'Tenaga Medis', 'tenaga-medis', 'Pengaduan terkait sikap, kompetensi, atau pelayanan tenaga medis dan paramedis', 'fa-user-md', '#8b5cf6', 3, 1, '2026-02-13 15:31:26', '2026-02-13 15:31:26'),
(4, 'Obat & Alat Kesehatan', 'obat-alkes', 'Pengaduan terkait ketersediaan, kualitas, atau distribusi obat dan alat kesehatan', 'fa-pills', '#f59e0b', 4, 1, '2026-02-13 15:31:26', '2026-02-13 15:31:26'),
(5, 'Administrasi & BPJS', 'administrasi-bpjs', 'Pengaduan terkait administrasi pendaftaran, BPJS, dan pelayanan non-medis', 'fa-file-alt', '#06b6d4', 5, 1, '2026-02-13 15:31:26', '2026-02-13 15:31:26'),
(6, 'Lainnya', 'lainnya', 'Pengaduan umum lainnya yang tidak termasuk kategori di atas', 'fa-ellipsis-h', '#64748b', 6, 1, '2026-02-13 15:31:26', '2026-02-13 15:31:26');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `reviewer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `slug`, `reviewer_id`, `created_at`, `updated_at`) VALUES
(1, 'P2P', 'p2p', 2, '2026-02-02 01:48:34', '2026-02-02 01:50:32'),
(2, 'Humas', 'humas', 3, '2026-02-02 01:48:34', '2026-02-02 01:50:32'),
(3, 'IT', 'it', 4, '2026-02-02 01:48:34', '2026-02-02 01:50:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, '9fb236b0-3283-4015-9e91-9568763dbd67', 'database', 'default', '{\"uuid\":\"9fb236b0-3283-4015-9e91-9568763dbd67\",\"displayName\":\"App\\\\Mail\\\\ComplaintSubmitted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\ComplaintSubmitted\\\":3:{s:9:\\\"complaint\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:20:\\\"App\\\\Models\\\\Complaint\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"bagusawan08@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1771042288,\"delay\":null}', 'InvalidArgumentException: View [view.name] not found. in C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:138\nStack trace:\n#0 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(78): Illuminate\\View\\FileViewFinder->findInPaths(\'view.name\', Array)\n#1 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(150): Illuminate\\View\\FileViewFinder->find(\'view.name\')\n#2 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(444): Illuminate\\View\\Factory->make(\'view.name\', Array)\n#3 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(419): Illuminate\\Mail\\Mailer->renderView(\'view.name\', Array)\n#4 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(312): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'view.name\', NULL, NULL, Array)\n#5 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(207): Illuminate\\Mail\\Mailer->send(\'view.name\', Array, Object(Closure))\n#6 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(82): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#9 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#10 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#15 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#16 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#17 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#19 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#20 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#21 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#35 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Application.php(1102): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\xampp\\htdocs\\news-app\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#43 {main}', '2026-02-14 04:49:12'),
(2, '5af4ab22-d914-4810-90eb-460eace5a509', 'database', 'default', '{\"uuid\":\"5af4ab22-d914-4810-90eb-460eace5a509\",\"displayName\":\"App\\\\Mail\\\\ComplaintSubmitted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\ComplaintSubmitted\\\":3:{s:9:\\\"complaint\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:20:\\\"App\\\\Models\\\\Complaint\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"bagusawan08@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1771043823,\"delay\":null}', 'InvalidArgumentException: View [view.name] not found. in C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:138\nStack trace:\n#0 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(78): Illuminate\\View\\FileViewFinder->findInPaths(\'view.name\', Array)\n#1 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(150): Illuminate\\View\\FileViewFinder->find(\'view.name\')\n#2 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(444): Illuminate\\View\\Factory->make(\'view.name\', Array)\n#3 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(419): Illuminate\\Mail\\Mailer->renderView(\'view.name\', Array)\n#4 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(312): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'view.name\', NULL, NULL, Array)\n#5 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(207): Illuminate\\Mail\\Mailer->send(\'view.name\', Array, Object(Closure))\n#6 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(82): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#9 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#10 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#15 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#16 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#17 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#19 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#20 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#21 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#35 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Application.php(1102): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\xampp\\htdocs\\news-app\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#43 {main}', '2026-02-14 04:49:12'),
(3, '7666317f-4d9e-4b39-b48f-87c7f0dffcaf', 'database', 'default', '{\"uuid\":\"7666317f-4d9e-4b39-b48f-87c7f0dffcaf\",\"displayName\":\"App\\\\Mail\\\\ComplaintSubmitted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\ComplaintSubmitted\\\":3:{s:9:\\\"complaint\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:20:\\\"App\\\\Models\\\\Complaint\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:20:\\\"tedy.bagus@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1771043996,\"delay\":null}', 'InvalidArgumentException: View [view.name] not found. in C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php:138\nStack trace:\n#0 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\View\\FileViewFinder.php(78): Illuminate\\View\\FileViewFinder->findInPaths(\'view.name\', Array)\n#1 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\View\\Factory.php(150): Illuminate\\View\\FileViewFinder->find(\'view.name\')\n#2 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(444): Illuminate\\View\\Factory->make(\'view.name\', Array)\n#3 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(419): Illuminate\\Mail\\Mailer->renderView(\'view.name\', Array)\n#4 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(312): Illuminate\\Mail\\Mailer->addContent(Object(Illuminate\\Mail\\Message), \'view.name\', NULL, NULL, Array)\n#5 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(207): Illuminate\\Mail\\Mailer->send(\'view.name\', Array, Object(Closure))\n#6 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#7 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#8 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(82): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#9 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#10 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#11 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#12 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#13 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#14 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#15 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#16 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#17 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#18 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#19 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#20 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#21 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#23 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#24 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#25 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#26 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#27 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#28 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#29 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#30 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#31 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#32 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#33 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#34 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#35 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#36 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#37 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Application.php(1102): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 C:\\xampp\\htdocs\\news-app\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#41 C:\\xampp\\htdocs\\news-app\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\xampp\\htdocs\\news-app\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#43 {main}', '2026-02-14 04:49:12');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `jawaban` text NOT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'Umum',
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `pertanyaan`, `jawaban`, `kategori`, `urutan`, `is_active`, `view_count`, `created_at`, `updated_at`) VALUES
(1, 'Apa itu Portal Kesehatan ini?', 'Portal Kesehatan adalah platform digital resmi Dinas Kesehatan yang menyediakan informasi layanan kesehatan, fasilitas kesehatan, pengaduan masyarakat, dan berbagai informasi kesehatan lainnya.', 'Umum', 1, 1, 0, '2026-02-18 08:23:34', '2026-02-18 08:23:34'),
(2, 'Apakah layanan ini gratis?', 'Ya, semua layanan informasi di portal ini sepenuhnya gratis dan dapat diakses oleh seluruh masyarakat tanpa biaya apapun.', 'Umum', 2, 1, 0, '2026-02-18 08:23:34', '2026-02-18 08:23:34'),
(3, 'Jam operasional layanan kesehatan?', 'Jam operasional berbeda-beda tergantung jenis fasilitas:\n- Puskesmas: Senin–Jumat 07.30–14.00 WIB\n- Rumah Sakit: 24 jam\n- Apotek: bervariasi, cek di halaman Fasyankes', 'Umum', 3, 1, 0, '2026-02-18 08:23:34', '2026-02-18 08:23:34'),
(4, 'Bagaimana cara mengajukan pengaduan?', 'Cara mengajukan pengaduan:\n1. Klik menu Pengaduan di halaman utama\n2. Pilih kategori layanan\n3. Isi formulir dengan lengkap\n4. Upload bukti pendukung (opsional)\n5. Submit dan simpan nomor tiket Anda', 'Pengaduan', 1, 1, 1, '2026-02-18 08:23:34', '2026-02-18 08:23:51'),
(5, 'Berapa lama pengaduan diproses?', 'Pengaduan diproses dalam 3×24 jam kerja. Anda dapat memantau status pengaduan menggunakan nomor tiket yang diberikan saat pengajuan.', 'Pengaduan', 2, 1, 0, '2026-02-18 08:23:34', '2026-02-18 08:23:34'),
(6, 'Bagaimana cara melacak status pengaduan?', 'Masukkan nomor tiket pengaduan Anda di menu \"Lacak Pengaduan\" atau scan QR code yang ada di halaman sukses setelah pengajuan.', 'Pengaduan', 3, 1, 0, '2026-02-18 08:23:34', '2026-02-18 08:23:34'),
(7, 'Bagaimana cara mencari fasilitas kesehatan terdekat?', 'Buka menu Fasyankes, klik \"Lihat Peta\" untuk melihat lokasi semua fasilitas kesehatan. Anda juga dapat memfilter berdasarkan kategori (Puskesmas, Rumah Sakit, Apotek, dll).', 'Fasyankes', 1, 1, 0, '2026-02-18 08:23:34', '2026-02-18 08:23:34'),
(8, 'Apakah data fasilitas kesehatan selalu diperbarui?', 'Ya, data fasilitas kesehatan diperbarui secara berkala oleh tim Dinas Kesehatan. Jika ada data yang tidak akurat, silakan laporkan melalui menu Pengaduan.', 'Fasyankes', 2, 1, 0, '2026-02-18 08:23:34', '2026-02-18 08:23:34'),
(9, 'Bagaimana jika saya mengalami kendala saat masuk (Login) SATUSEHAT Mobile?', 'Jika aplikasi SATUSEHAT Mobile anda mengalami kendala saat masuk (Login) stuck/freeze pada halaman pilih tema, ataupun kendala dengan muncul pemberitahuan \"kode Verifikasi (OTP) tidak tepat\" atau \"Permintaan tidak valid\", anda dapat mencoba lakukan langkah-langkah berikut :\r\n\r\nUntuk pengguna Android:\r\n\r\nJika pengaturan HP menggunakan bahasa indonesia:\r\n\r\nPastikan versi aplikasi sudah yang terbaru, perbarui versi aplikasi di Play StoreMasuk ke \"Pengaturan\" di Handphone\r\nPilih \"Aplikasi\" -> \"SATUSEHAT Mobile\" -> \"Penyimpanan\"\r\nPilih \"Hapus Data\" dan \"Hapus Memori\"\r\nMasuk (login) kembali ke aplikasi dengan akun terdaftar\r\nJika pengaturan HP menggunakan bahasa English:\r\n\r\nPastikan versi aplikasi sudah yang terbaru, perbarui versi aplikasi di Play Store\r\nMasuk ke \"Settings\" di Handphone\r\nPilih \"Apps\" -> \"SATUSEHAT Mobile\" -> \"Storage Usage\"\r\nPilih \"Clear Data\" dan \"Clear Cache\"\r\nMasuk (login) kembali ke aplikasi dengan akun terdaftar\r\nUntuk pengguna iOs:\r\n\r\nJika pengaturan HP menggunakan bahasa indonesia:\r\n\r\nPastikan versi aplikasi sudah yang terbaru, perbarui versi aplikasi di App Store\r\nMasuk ke \"Pengaturan\" di Handphone\r\nPilih \"Umum\" -> \"Penyimpanan iPhone\" -> \"SATUSEHAT Mobile\" -> \"Hapus Aplikasi\"\r\nInstall Kembali aplikasi SATUSEHAT Mobile melalui App Store\r\nMasuk (login) kembali ke aplikasi dengan akun terdaftar\r\nJika pengaturan HP menggunakan bahasa English:\r\n\r\nPastikan versi aplikasi sudah yang terbaru, perbarui versi aplikasi di App Store\r\nMasuk ke \"Settings\" di Handphone\r\nPilih \"General\" -> \"iPhone Storage\" -> \"SATUSEHAT Mobile\" -> \"Delete App\"\r\nInstall Kembali aplikasi SATUSEHAT Mobile melalui App Store\r\nMasuk (login) kembali ke aplikasi dengan akun terdaftar', 'SatuSehat Mobile', 9, 1, 1, '2026-02-20 16:03:16', '2026-02-20 16:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `fasyankes`
--

CREATE TABLE `fasyankes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `klinik_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `alamat` text DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fasyankes`
--

INSERT INTO `fasyankes` (`id`, `klinik_id`, `nama`, `kode`, `alamat`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(2, 1, 'Klinik Utama Rawat Inap Klinik Adi Sehat', '33220300032', 'Jl. Gatot Subroto, Krajan, Rejosari, Kec. Bancak, Kabupaten Semarang, Jawa Tengah 50125', -7.26873056, 110.59475962, '2026-02-02 01:57:48', '2026-02-02 01:57:48'),
(10, 5, 'UPTD Laboratorium Kesehatan Daerah', 'LAB-052', 'JL. Kalipasir, Kalirejo, Kec. Ungaran Tim., Kabupaten Semarang, Jawa Tengah 50515', -7.13231045, 110.41951042, '2026-02-02 03:28:12', '2026-02-02 03:51:00'),
(11, 3, 'RS Umum Bina Kasih', 'RS-157', 'Jl. Naryoatmajan No.27A, Kranggan, Panjang, Kec. Ambarawa, Kabupaten Semarang, Jawa Tengah 50614', -7.26194675, 110.40110293, '2026-02-02 03:45:49', '2026-02-02 03:46:43'),
(13, 5, 'Laboratorium NMC', 'M3322010001', 'Jl. Letjend Suprapto No.37, Sidomulyo, Ungaran Timur, Kabupaten Semarang', -7.13633718, 110.40931651, '2026-02-06 16:31:27', '2026-02-06 16:32:44'),
(26, 2, 'UPTD Puskesmas Getasan', 'PKM-055', 'Jl. P Diponegoro KM 5 Getasan', -7.37559277, 110.43950588, '2026-02-10 03:29:48', '2026-02-10 03:29:48'),
(27, 3, 'RSUD dr. Gunawan Mangunkusumo', 'RS-744', 'Jl. RA Kartini No.101', -7.26757970, 110.40829326, '2026-02-10 03:29:48', '2026-02-10 03:29:48'),
(28, 4, 'Apotek Kimia Farma Ambarawa', 'APT-001', 'Jl. Jendral Sudirman No.88C', -7.25523420, 110.41414979, '2026-02-10 03:29:48', '2026-02-10 03:29:48');

-- --------------------------------------------------------

--
-- Table structure for table `health_profiles`
--

CREATE TABLE `health_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `view_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `download_count` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `health_profiles`
--

INSERT INTO `health_profiles` (`id`, `name`, `file_path`, `file_type`, `created_at`, `updated_at`, `view_count`, `download_count`) VALUES
(1, 'Profil Kesehatan Tahun 2024', 'health-profiles/OqZG30NnaKu0bYCEiUAG9KESRi8CQkmwgeF7iqBd.pdf', 'pdf', '2026-02-03 15:26:45', '2026-02-06 01:31:18', 7, 3),
(2, 'Profil Kesehatan Tahun 2022', 'health-profiles/WkBS0H24uPODoPIEBA6ZZ1fpmPeHZyAICczPiqMR.pdf', 'pdf', '2026-02-03 15:27:54', '2026-02-06 01:31:18', 7, 1),
(3, 'Profil Kesehatan Tahun 2021', 'health-profiles/P0t9S33UovR5o3u65ddwFfgUEBlDHUMm5DjOZC8T.pdf', 'pdf', '2026-02-03 15:28:27', '2026-02-06 02:30:48', 7, 2),
(4, 'Profil Kesehatan Tahun 2023', 'health-profiles/qmx16cYfhCP22pJg5KwMAUn72JyNPz10rHVLu6Bx.pdf', 'pdf', '2026-02-06 02:39:01', '2026-02-06 02:39:01', 0, 0),
(5, 'Profil Kesehatan Tahun 2017', 'health-profiles/0ZMXuO5rpUPQVpwqvArnYZY9HXVRPUwnLsV4ovdl.pdf', 'pdf', '2026-02-06 03:15:01', '2026-02-06 03:15:01', 0, 0),
(6, 'Profil Kesehatan Tahun 2018', 'health-profiles/UXcpG6dshLHd9XmRD1PnEFItqtdamYC51WUjNGtA.pdf', 'pdf', '2026-02-06 03:15:29', '2026-02-06 03:15:29', 0, 0),
(7, 'Profil Kesehatan Tahun 2019', 'health-profiles/hVd0pW3ccc8Y5rRm0qwrFtrfHFq20bs7Ou50GQIM.pdf', 'pdf', '2026-02-06 03:15:54', '2026-02-06 03:15:54', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `type` enum('gallery','hero','banner') NOT NULL DEFAULT 'gallery',
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `title`, `description`, `image_path`, `alt_text`, `type`, `order`, `is_active`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(1, 'HKN ke-62 Dinas Kesehatan Kabupaten Semarang', 'HKN ke-62 Dinas Kesehatan Kabupaten Semarang', 'gallery/1770005580_hkn-ke-62-dinas-kesehatan-kabupaten-semarang.JPG', 'HKN ke-62 Dinas Kesehatan Kabupaten Semarang', 'hero', 0, 1, 1, '2026-02-02 04:13:00', '2026-02-02 04:13:00'),
(2, 'Kepala Dinas Kesehatan Kabupaten Semarang', 'Kepala Dinas Kesehatan Kabupaten Semarang', 'gallery/1770005607_kepala-dinas-kesehatan-kabupaten-semarang.JPG', 'Kepala Dinas Kesehatan Kabupaten Semarang', 'hero', 1, 1, 1, '2026-02-02 04:13:27', '2026-02-02 04:13:27'),
(3, 'HKN Dinas Kesehatan Kabupaten Semarang', NULL, 'gallery/1770005637_hkn-dinas-kesehatan-kabupaten-semarang.JPG', 'HKN Dinas Kesehatan Kabupaten Semarang', 'hero', 2, 1, 1, '2026-02-02 04:13:57', '2026-02-02 04:13:57'),
(4, 'Gerakan Masyarakat Hidup Sehat', NULL, 'gallery/1770132736_gerakan-masyarakat-hidup-sehat.png', 'Gerakan Masyarakat Hidup Sehat', 'hero', 4, 1, 1, '2026-02-03 15:32:16', '2026-02-03 15:32:16'),
(5, 'Survei Kepuasan Masyarakat Tahun 2024 Semester II', NULL, 'gallery/1770169724_survei-kepuasan-masyarakat-tahun-2024-semester-ii.jpeg', 'Survei Kepuasan Masyarakat Tahun 2024 Semester II', 'gallery', 1, 1, 1, '2026-02-04 01:48:44', '2026-02-04 01:48:44'),
(6, 'Survei Kepuasan Masyarakat Tahun 2024 Semester I', NULL, 'gallery/1770169759_survei-kepuasan-masyarakat-tahun-2024-semester-i.jpeg', 'Survei Kepuasan Masyarakat Tahun 2024 Semester I', 'gallery', 2, 1, 1, '2026-02-04 01:49:19', '2026-02-04 01:49:19'),
(7, 'Survei Kepuasan Masyarakat Tahun 2024 Semester I', NULL, 'gallery/1770169790_survei-kepuasan-masyarakat-tahun-2024-semester-i.jpeg', 'Survei Kepuasan Masyarakat Tahun 2024 Semester I', 'gallery', 3, 1, 1, '2026-02-04 01:49:50', '2026-02-04 01:49:50'),
(8, 'Survei Kepuasan Masyarakat Tahun 2025 Semester II', 'Survei Kepuasan Masyarakat Tahun 2025 Semester II', 'gallery/1770396343_survei-kepuasan-masyarakat-tahun-2025-semester-ii.jpg', 'Survei Kepuasan Masyarakat Tahun 2025 Semester II', 'gallery', 4, 1, 1, '2026-02-06 16:45:43', '2026-02-06 16:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `information_faqs`
--

CREATE TABLE `information_faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information_flows`
--

CREATE TABLE `information_flows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `step_number` int(11) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `duration_days` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `information_flows`
--

INSERT INTO `information_flows` (`id`, `title`, `description`, `step_number`, `icon`, `duration_days`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Pengajuan Permohonan', 'Pemohon mengajukan permohonan, baik datang langsung ke meja layanan (offline) atau melalui website Dinas Kesehatan Kabupaten Semarang, email, maupun surat (online/elektronik).', 1, 'fa-file-alt', 1, 1, '2026-02-09 14:56:22', '2026-02-09 15:07:15'),
(2, 'Identitas & Formulir', 'Pemohon wajib mengisi formulir permohonan dengan mencantumkan nama, alamat, rincian informasi yang diminta, dan tujuan penggunaan informasi, serta melampirkan salinan KTP.', 2, 'fas fa-user', 1, 1, '2026-02-09 14:59:08', '2026-02-09 15:07:21'),
(3, 'Registrasi Permohonan', 'PPID mencatat permohonan dan memberikan Tanda Bukti Penerimaan yang memuat nomor pendaftaran dan tanggal diterima.', 3, 'fa-id-card', 1, 1, '2026-02-09 15:02:55', '2026-02-09 15:06:54'),
(4, 'Waktu Pemrosesan', 'PPID memberikan jawaban tertulis (diterima/ditolak) maksimal 10 hari kerja sejak permohonan diterima.\r\nPerpanjangan waktu dapat dilakukan maksimal 7 hari kerja jika informasi belum tersedia atau perlu kajian, dengan pemberitahuan kepada pemohon.', 4, 'fa-clock', 7, 1, '2026-02-09 15:04:16', '2026-02-09 15:10:43'),
(5, 'Penyampaian Informasi', 'Jika diterima, informasi diberikan langsung, melalui salinan (fotokopi), atau diunduh (untuk dokumen elektronik).\r\nJika ditolak, PPID wajib memberikan alasan tertulis berdasarkan pengecualian UU KIP.', 5, 'fa-info', 1, 1, '2026-02-09 15:06:25', '2026-02-09 15:10:14'),
(6, 'Keberatan', 'Jika pemohon tidak puas dengan hasil atau respon PPID, pemohon berhak mengajukan keberatan kepada Atasan PPID maksimal 30 hari kerja setelah tanggapan diterima.', 6, 'fa-comment', 1, 1, '2026-02-09 15:08:32', '2026-02-09 15:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `information_followups`
--

CREATE TABLE `information_followups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `information_request_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `information_followups`
--

INSERT INTO `information_followups` (`id`, `information_request_id`, `status`, `description`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 6, 'processed', 'baik akan kami proses permohonan anda', 'Super Administrator', '2026-02-09 14:32:24', '2026-02-09 14:32:24'),
(3, 6, 'ready', 'File hasil permohonan informasi telah diupload dan siap diambil', 'Super Administrator', '2026-02-09 14:48:54', '2026-02-09 14:48:54'),
(4, 6, 'ready', 'data sudah tersedia', 'Super Administrator', '2026-02-09 14:49:11', '2026-02-09 14:49:11'),
(5, 6, 'verified', 'Permohonan telah diverifikasi dan dinyatakan lengkap', 'Super Administrator', '2026-02-09 14:49:18', '2026-02-09 14:49:18'),
(6, 6, 'completed', 'data sudah kami cukupi. terimakasih', 'Super Administrator', '2026-02-09 14:50:38', '2026-02-09 14:50:38');

-- --------------------------------------------------------

--
-- Table structure for table `information_requests`
--

CREATE TABLE `information_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `registration_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_card_number` varchar(255) NOT NULL,
  `id_card_file` varchar(255) DEFAULT NULL,
  `requester_type` enum('perorangan','kelompok','organisasi') NOT NULL DEFAULT 'perorangan',
  `information_needed` text NOT NULL,
  `information_purpose` text NOT NULL,
  `information_format` enum('softcopy','hardcopy','keduanya') NOT NULL DEFAULT 'softcopy',
  `delivery_method` enum('langsung','pos','email','kurir') NOT NULL DEFAULT 'email',
  `status` enum('submitted','verified','processed','ready','completed','rejected') NOT NULL DEFAULT 'submitted',
  `rejection_reason` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `result_file` varchar(255) DEFAULT NULL,
  `submitted_at` datetime NOT NULL,
  `processed_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `information_requests`
--

INSERT INTO `information_requests` (`id`, `registration_number`, `name`, `address`, `phone`, `email`, `id_card_number`, `id_card_file`, `requester_type`, `information_needed`, `information_purpose`, `information_format`, `delivery_method`, `status`, `rejection_reason`, `admin_notes`, `result_file`, `submitted_at`, `processed_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(6, 'REG-2026-02-0001', 'tedy bagus setiawan', 'Tegalwuni RT 03 RW 06', '085875037200', 'bagusawan08@gmail.com', '3322071606940001', 'id-cards/iIS11OQKtptYw5RG6RimksiDOqrXcaUUoMx4McZe.jpg', 'perorangan', 'Profil kesehatan tahun 20224', 'untuk penelititan', 'softcopy', 'langsung', 'completed', NULL, NULL, 'information-results/BXplTpntim5FPb8LFFwrNafCwncQpIAKOhtU4uKK.pdf', '2026-02-09 21:30:34', '2026-02-09 21:32:24', '2026-02-09 21:50:38', '2026-02-09 14:30:34', '2026-02-09 14:50:38');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(4, 'default', '{\"uuid\":\"91eec47e-9ff2-4e68-9773-c916f2a78fc2\",\"displayName\":\"App\\\\Mail\\\\ComplaintSubmitted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:27:\\\"App\\\\Mail\\\\ComplaintSubmitted\\\":3:{s:9:\\\"complaint\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:20:\\\"App\\\\Models\\\\Complaint\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:1:{i:0;s:7:\\\"service\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:14:\\\"tedy@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"},\"createdAt\":1771223633,\"delay\":null}', 0, NULL, 1771223633, 1771223633);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
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
-- Table structure for table `kliniks`
--

CREATE TABLE `kliniks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT 'info',
  `deskripsi` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kliniks`
--

INSERT INTO `kliniks` (`id`, `nama`, `kode`, `icon`, `color`, `deskripsi`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Klinik', 'KLN', 'fas fa-clinic-medical', 'info', 'Fasilitas pelayanan kesehatan tingkat pertama', 1, '2026-02-02 01:48:35', '2026-02-02 01:48:35'),
(2, 'Puskesmas', 'PKM', 'fas fa-hospital', 'success', 'Pusat Kesehatan Masyarakat', 1, '2026-02-02 01:48:35', '2026-02-02 01:48:35'),
(3, 'Rumah Sakit', 'RS', 'fas fa-hospital-alt', 'danger', 'Fasilitas pelayanan kesehatan rujukan', 1, '2026-02-02 01:48:35', '2026-02-02 01:48:35'),
(4, 'Apotek', 'APT', 'fas fa-pills', 'warning', 'Fasilitas penyedia obat dan alat kesehatan', 1, '2026-02-02 01:48:35', '2026-02-02 01:48:35'),
(5, 'Laboratorium', 'LAB', 'fas fa-flask', 'info', 'Fasilitas pemeriksaan kesehatan', 1, '2026-02-02 01:48:35', '2026-02-02 01:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `route_name` varchar(255) DEFAULT NULL,
  `role_slug` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `icon`, `route_name`, `role_slug`, `parent_id`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'fas fa-tachometer-alt', 'admin.dashboard', 'super_admin', NULL, 1, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(2, 'Manajemen User', 'fas fa-users', NULL, 'super_admin', NULL, 2, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(3, 'Data User', NULL, 'admin.users.index', 'super_admin', 2, 1, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(4, 'Berita', 'fas fa-newspaper', NULL, 'super_admin', NULL, 3, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(5, 'Kategori', NULL, 'admin.categories.index', 'super_admin', 4, 1, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(6, 'Artikel', NULL, 'admin.articles.index', 'super_admin', 4, 2, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(7, 'Pengumuman', 'fas fa-bullhorn', 'admin.announcements.index', 'super_admin', NULL, 4, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(8, 'Menu Website', 'fas fa-bars', 'admin.menus.index', 'super_admin', NULL, 5, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(9, 'Profil Kesehatan', 'fas fa-book', 'admin.health-profiles.index', 'super_admin', NULL, 6, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(10, 'Fasyankes', 'fas fa-hospital', NULL, 'super_admin', NULL, 7, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(11, 'Data Fasyankes', NULL, 'admin.fasyankes.dashboard', 'super_admin', 10, 1, 1, '2026-02-02 01:48:34', '2026-02-16 15:28:46'),
(12, 'Peta Fasyankes', NULL, 'admin.fasyankes.maps', 'super_admin', 10, 2, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(13, 'Kategori Fasyankes', NULL, 'admin.kliniks.index', 'super_admin', 10, 3, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(14, 'Dashboard', 'fas fa-home', 'reviewer.dashboard', 'reviewer', NULL, 1, 1, '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(15, 'Review Artikel', 'fas fa-check-circle', 'reviewer.articles.index', 'reviewer', NULL, 2, 1, '2026-02-02 01:48:35', '2026-02-02 01:48:35'),
(16, 'Dashboard', 'fas fa-home', 'author.dashboard', 'author', NULL, 1, 1, '2026-02-02 01:48:35', '2026-02-02 01:48:35'),
(17, 'Artikel Saya', 'fas fa-pen', 'author.articles.index', 'author', NULL, 2, 1, '2026-02-02 01:48:35', '2026-02-02 01:48:35'),
(18, 'Media', 'fas fa-image', NULL, 'super_admin', NULL, 8, 1, '2026-02-02 04:11:17', '2026-02-02 12:56:21'),
(19, 'Images', 'fas fa-images', 'admin.images.index', 'super_admin', 18, 1, 1, '2026-02-02 04:12:06', '2026-02-02 04:12:06'),
(20, 'Komentar', 'fas fa-comment', 'admin.comments.index', 'super_admin', NULL, 9, 1, '2026-02-03 12:52:27', '2026-02-03 12:52:27'),
(23, 'Profil', 'fas fa-user', NULL, 'super_admin', NULL, 2, 1, '2026-02-03 15:22:44', '2026-02-03 15:22:44'),
(24, 'Visi Misi & Motto', 'fas fa-person-military-to-person', 'admin.visi-misi.index', 'super_admin', 23, 1, 1, '2026-02-03 15:24:28', '2026-02-04 02:45:08'),
(25, 'Struktur Organisasi', NULL, 'admin.struktur-organisasi.index', 'super_admin', 23, 2, 1, '2026-02-03 15:24:51', '2026-02-04 14:37:06'),
(26, 'Tupoksi', NULL, 'admin.tupoksi.index', 'super_admin', 23, 3, 1, '2026-02-03 15:25:06', '2026-02-04 06:00:54'),
(27, 'Profil Pejabat Struktural', NULL, 'admin.pejabat.index', 'super_admin', 23, 4, 1, '2026-02-03 15:25:56', '2026-02-04 14:28:34'),
(28, 'Permohonan Informasi', 'fas fa-info', NULL, 'super_admin', NULL, 10, 1, '2026-02-09 13:42:14', '2026-02-09 13:42:14'),
(29, 'Alur Permohonan', NULL, 'admin.information-flows.index', 'super_admin', 28, 1, 1, '2026-02-09 13:42:32', '2026-02-09 13:42:32'),
(30, 'Kelola Permohonan', NULL, 'admin.information-requests.index', 'super_admin', 28, 2, 1, '2026-02-09 13:43:08', '2026-02-09 13:43:08'),
(31, 'PPID', 'fas fa-book', 'admin.ppid-informations.index', 'super_admin', NULL, 12, 1, '2026-02-11 13:36:41', '2026-02-11 13:38:16'),
(33, 'Complaint', 'fas fa-headset', NULL, 'super_admin', NULL, 11, 1, '2026-02-14 14:34:43', '2026-02-16 07:52:18'),
(34, 'Kritik & Saran', 'fas fa-star', 'admin.reviews.index', 'super_admin', 33, 2, 1, '2026-02-16 07:49:50', '2026-02-16 14:44:35'),
(35, 'complaint', NULL, 'admin.complaints.dashboard', 'super_admin', 33, 1, 1, '2026-02-16 07:52:31', '2026-02-16 07:52:31'),
(36, 'FAQ', 'fas fa-question', 'admin.faqs.index', 'super_admin', NULL, 13, 1, '2026-02-20 15:30:30', '2026-02-20 15:30:30'),
(39, 'Produk Hukum', 'fas fa-gavel', 'admin.produkhukum.index', 'super_admin', NULL, 12, 1, '2026-02-22 04:30:20', '2026-02-22 04:30:20');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_24_123210_create_roles_table', 1),
(5, '2026_01_24_123218_create_categories_table', 1),
(6, '2026_01_24_123225_create_departments_table', 1),
(7, '2026_01_24_123252_create_articles_table', 1),
(8, '2026_01_24_123418_create_announcements_table', 1),
(9, '2026_01_24_123424_create_menus_table', 1),
(10, '2026_01_24_123431_add_role_and_department_to_users_table', 1),
(11, '2026_01_26_214510_create_health_profiles_table', 1),
(12, '2026_01_27_105625_create_kliniks_table', 1),
(13, '2026_01_28_085732_create_fasyankes_table', 1),
(14, '2026_01_29_215320_add_klinik_id_to_fasyankes_table', 1),
(15, '2026_01_30_213543_create_images_table', 1),
(16, '2026_02_02_103616_drop_kategori_column_from_fasyankes_table', 2),
(17, '2026_02_02_222319_add_views_to_articles_table', 3),
(18, '2026_02_03_192009_create_article_comments_table', 4),
(19, '2026_02_04_090418_create_profil_tables', 5),
(20, '2026_02_05_225832_add_counter_to_health_profiles_table', 6),
(21, '2026_02_07_215658_create_information_request_table', 7),
(22, '2026_02_07_215803_create_information_flows_table', 7),
(23, '2026_02_07_230939_create_information_request_tables', 8),
(24, '2026_02_10_232528_create_ppid_tables', 9),
(26, '2026_02_11_210446_create_ppid_tables', 1),
(27, '2026_02_13_213735_create_complaint_tables', 10),
(28, '2026_02_14_215652_add_view_count_to_complaints', 11),
(29, '2026_02_14_231819_add_view_count_to_complaints', 12),
(30, '2026_02_16_132647_fix_complaints_default_values_migration', 13),
(31, '2026_02_16_134729_create_reviews', 14),
(32, '2026_02_18_092557_create_faqs', 15),
(33, '2026_02_18_142749_create_review_services', 16),
(34, '2026_02_18_142855_add_tracking_to_reviews_table', 16),
(35, '2026_02_18_230828_create_standar_pelayanans', 17),
(36, '2026_02_20_234223_add_file_to_announcements_table', 18),
(37, '2026_02_21_231135_add_create_to_announcements_table', 19),
(38, '2026_02_22_110039_create_produk_hukum_table', 20);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pejabat_struktural`
--

CREATE TABLE `pejabat_struktural` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jabatan` varchar(150) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `pendidikan` varchar(100) DEFAULT NULL,
  `riwayat_jabatan` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pejabat_struktural`
--

INSERT INTO `pejabat_struktural` (`id`, `nama`, `jabatan`, `nip`, `foto`, `pendidikan`, `riwayat_jabatan`, `email`, `phone`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Dwi Saiful Noor Hidayat, SKM., MM', 'Kepala Dinas Kesehatan Kabupaten Semarang', '196910032002122008', 'pejabat/oZy6KU8OGRGgJ4e22ljERFGrcCmB45ZmFVfGUku1.png', 'S2 Magister Manajemen', NULL, NULL, NULL, 1, 1, '2026-02-05 03:16:58', '2026-02-09 16:09:22'),
(3, 'Bambang Pujiarto, S.Kep., Ns. MM', 'Sekretaris Dinas Kesehatan', '196905051992031011', 'pejabat/iLg5yUkiNxW11GEkk5LWbyoNcLSNPmryMLCTxFwp.png', 'S2 Magister Manajemen', NULL, NULL, NULL, 2, 1, '2026-02-05 03:21:51', '2026-02-05 03:21:51'),
(4, 'Pramudiyo Teguh Sucipto, SKM., M.Kes', 'Kepala Bidang Pelayanan Kesehatan', '197702082002121004', 'pejabat/OQTGz52MivUNgnCvEZ7rI27Hvxdq41c29YZHxVT2.png', 'S2 Magister Kesehatan', NULL, NULL, NULL, 3, 1, '2026-02-05 03:27:40', '2026-02-05 03:27:40'),
(5, 'dr. Endah Indriati Wurjaningrum', 'Kepala Bidang Pencegahan dan Pengendalian Penyakit', '196910032002122008', 'pejabat/VJwwlcA56Td84sn0oKvYbNiihExm6kIn8EknDc92.png', 'Dokter', NULL, NULL, NULL, 4, 1, '2026-02-05 03:29:49', '2026-02-05 03:29:49'),
(6, 'dr. Kusworo Yulianto, MM', 'Kepala Bidang Kesehatan Masyarakat', '196807072007011017', 'pejabat/2G3styzaDV4JuqlAGuzrD9rqNNH5nsPWzJgS4m9r.png', 'S2 Magister Manajemen', NULL, NULL, NULL, 5, 1, '2026-02-05 03:31:22', '2026-02-05 03:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `ppid_categories`
--

CREATE TABLE `ppid_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#3b82f6',
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ppid_categories`
--

INSERT INTO `ppid_categories` (`id`, `name`, `slug`, `description`, `color`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Informasi Berkala', 'berkala', 'Informasi yang wajib disediakan dan diumumkan secara berkala', '#3b82f6', 1, 1, '2026-02-13 14:52:39', '2026-02-13 14:52:39'),
(2, 'Informasi Serta Merta', 'serta-merta', 'Informasi yang dapat mengancam hajat hidup orang banyak dan ketertiban umum', '#ef4444', 2, 1, '2026-02-13 14:52:39', '2026-02-13 14:52:39'),
(3, 'Informasi Setiap Saat', 'setiap-saat', 'Informasi yang wajib tersedia setiap saat', '#10b981', 3, 1, '2026-02-13 14:52:39', '2026-02-13 14:52:39'),
(4, 'Informasi Dikecualikan', 'dikecualikan', 'Informasi yang rahasia sesuai undang-undang, kepatutan, dan kepentingan umum', '#f59e0b', 4, 1, '2026-02-13 14:52:39', '2026-02-13 14:52:39');

-- --------------------------------------------------------

--
-- Table structure for table `ppid_download_logs`
--

CREATE TABLE `ppid_download_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ppid_information_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `downloaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ppid_informations`
--

CREATE TABLE `ppid_informations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ppid_category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `information_number` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `responsible_unit` varchar(100) DEFAULT NULL,
  `information_format` varchar(50) DEFAULT NULL,
  `year` year(4) NOT NULL DEFAULT year(curdate()),
  `published_date` date DEFAULT NULL,
  `validity_period` date DEFAULT NULL,
  `permanent_validity` tinyint(1) NOT NULL DEFAULT 0,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` varchar(50) DEFAULT NULL,
  `external_link` varchar(255) DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `download_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk_hukum`
--

CREATE TABLE `produk_hukum` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor` varchar(255) NOT NULL,
  `tahun` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `tentang` text NOT NULL,
  `tanggal_penetapan` date NOT NULL,
  `tanggal_berlaku` date DEFAULT NULL,
  `status` enum('berlaku','tidak_berlaku','draft') NOT NULL DEFAULT 'berlaku',
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `download_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk_hukum`
--

INSERT INTO `produk_hukum` (`id`, `nomor`, `tahun`, `kategori`, `tentang`, `tanggal_penetapan`, `tanggal_berlaku`, `status`, `file_path`, `file_name`, `file_size`, `keterangan`, `download_count`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(2, '100.3.3/2384/2025', 2025, 'sk', 'Penetapan Daftar Informasi Publik Dinas Kesehatan Kabupaten Semarang', '2025-08-19', '2026-08-19', 'berlaku', 'produk-hukum/VvViJlefOay9rivnMfYlGuPo8nahcnK4So9rKxH0.pdf', 'SIK DIP DINKES 2025 FIX.pdf', 509435, NULL, 1, 1, 1, '2026-02-22 04:41:50', '2026-02-22 05:44:29'),
(3, '100.3.3/2384.1/2025', 2026, 'sk', 'Penetapan Iinformasi Publik Yang Dikecualikan Dinas\r\nKesehatan Kabupaten Semarang', '2025-08-19', '2026-08-19', 'berlaku', 'produk-hukum/j24cm0oh6xtjnwqGYxJ9R2QLVlSOBWwYczQ0qshE.pdf', 'SK DIK DINKES 2025 FIX.pdf', 429373, NULL, 0, 1, 1, '2026-02-22 04:44:41', '2026-02-22 04:44:41');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_name` varchar(255) NOT NULL,
  `reviewer_email` varchar(255) DEFAULT NULL,
  `reviewer_phone` varchar(255) DEFAULT NULL,
  `reviewer_photo` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `tracking_code` varchar(20) DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `reviewer_name`, `reviewer_email`, `reviewer_phone`, `reviewer_photo`, `rating`, `review_text`, `service_type`, `status`, `approved_at`, `approved_by`, `ip_address`, `tracking_code`, `view_count`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', 'budi.santoso@example.com', '081234567890', NULL, 5, 'Pelayanan sangat memuaskan! Petugas sangat ramah dan profesional. Fasilitasnya bersih dan nyaman. Proses administrasi juga cepat. Sangat recommend untuk yang butuh layanan kesehatan berkualitas!', 'Layanan Kesehatan', 'approved', '2026-02-16 07:10:11', 'Admin', NULL, NULL, 0, '2026-02-01 07:10:11', '2026-02-16 07:10:11'),
(2, 'Siti Nurhaliza', 'siti.nurhaliza@example.com', NULL, NULL, 5, 'Dokternya sangat sabar dalam menjelaskan kondisi kesehatan. Waktu tunggu tidak terlalu lama. Obat yang diberikan juga tepat dan efektif. Terima kasih atas pelayanan yang luar biasa!', 'Layanan Farmasi', 'approved', '2026-02-16 07:10:11', 'Admin', NULL, NULL, 0, '2026-02-04 07:10:11', '2026-02-16 07:10:11'),
(3, 'Ahmad Fauzi', 'ahmad.fauzi@example.com', '082345678901', NULL, 4, 'Secara keseluruhan pelayanan bagus dan memuaskan. Hanya saja kadang antriannya agak lama di jam sibuk. Tapi setelah masuk, pelayanannya oke dan petugas ramah.', 'Layanan Umum', 'approved', '2026-02-16 07:10:11', 'Admin', NULL, NULL, 0, '2026-02-06 07:10:11', '2026-02-16 07:10:11'),
(4, 'Dewi Lestari', 'dewi.lestari@example.com', NULL, NULL, 5, 'Senang sekali dengan pelayanan bidannya. Sangat care, sabar, dan membantu. Ruang tunggunya nyaman dan bersih. Rekomendasi banget untuk ibu hamil yang cari pelayanan terbaik.', 'Layanan Bidan', 'approved', '2026-02-16 07:10:11', 'Admin', NULL, NULL, 0, '2026-02-08 07:10:11', '2026-02-16 07:10:11'),
(5, 'Rizki Pratama', 'rizki.pratama@example.com', '083456789012', NULL, 4, 'Bagus dan profesional. Sudah beberapa kali kesini dan selalu puas dengan layanannya. Staff juga helpful dan informatif. Akan tetap menggunakan layanan ini.', 'Layanan Kesehatan', 'approved', '2026-02-16 07:10:11', 'Admin', NULL, NULL, 0, '2026-02-09 07:10:11', '2026-02-16 07:10:11'),
(6, 'Lina Marlina', 'lina.marlina@example.com', NULL, NULL, 5, 'Pengalaman yang sangat positif! Dari pendaftaran sampai selesai semuanya lancar. Dokternya kompeten dan komunikatif. Tempatnya juga strategis dan mudah dijangkau.', 'Layanan Kesehatan', 'approved', '2026-02-16 07:10:11', 'Admin', NULL, NULL, 0, '2026-02-10 07:10:11', '2026-02-16 07:10:11'),
(7, 'Hendra Gunawan', 'hendra.gunawan@example.com', '084567890123', NULL, 4, 'Pelayanan cukup baik. Harga terjangkau dan kualitas OK. Mungkin bisa ditingkatkan lagi untuk fasilitas ruang tunggunya. Overall recommended!', 'Layanan Farmasi', 'approved', '2026-02-16 07:10:11', 'Admin', NULL, NULL, 0, '2026-02-11 07:10:11', '2026-02-16 07:10:11'),
(8, 'Maya Sari', NULL, NULL, NULL, 5, 'Sangat puas dengan konsultasi gizi yang saya dapat. Ahli gizinya sangat membantu dan memberikan advice yang praktikal. Program dietnya juga efektif. Terima kasih!', 'Layanan Gizi', 'approved', '2026-02-16 07:10:11', 'Admin', NULL, NULL, 0, '2026-02-12 07:10:11', '2026-02-16 07:10:11'),
(9, 'Bambang Suryanto', 'bambang.s@example.com', NULL, NULL, 5, 'Excellent service! Staff sangat ramah dan helpful. Prosedurnya jelas dan transparan. Highly recommended untuk siapa saja yang butuh layanan kesehatan berkualitas.', 'Layanan Kesehatan', 'approved', '2026-02-16 07:10:11', 'Admin', NULL, NULL, 0, '2026-02-13 07:10:11', '2026-02-16 07:10:11'),
(10, 'Rina Wati', 'rina.wati@example.com', '085678901234', NULL, 4, 'Pelayanan memuaskan. Petugas sigap dan ramah. Tempatnya bersih. Sedikit saran mungkin bisa ditambah kursi di ruang tunggu karena kadang penuh.', 'Layanan Umum', 'approved', '2026-02-16 07:10:11', 'Admin', NULL, NULL, 0, '2026-02-14 07:10:11', '2026-02-16 07:10:11'),
(11, 'Andi Wijaya', 'andi.wijaya@example.com', NULL, NULL, 5, 'Review yang luar biasa! Pelayanan sangat baik dan profesional. Sangat merekomendasikan!', 'Layanan Kesehatan', 'approved', '2026-02-16 14:45:52', 'Super Administrator', NULL, NULL, 0, '2026-02-16 02:10:11', '2026-02-16 14:45:52'),
(12, 'Putri Ayu', 'putri.ayu@example.com', NULL, NULL, 3, 'Lumayan bagus, tapi masih ada yang perlu ditingkatkan terutama waktu tunggu.', 'Layanan Umum', 'approved', '2026-02-16 14:45:52', 'Super Administrator', NULL, NULL, 0, '2026-02-16 05:10:11', '2026-02-16 14:45:52'),
(14, 'tedy bagus', 'tedy.bagus@gmail.com', NULL, NULL, 5, 'pelayanan di puskesmas banyubiru sangat memuaskan, petugas rama-ramah sekali.', 'Layanan Kesehatan', 'approved', '2026-02-16 14:57:27', 'Super Administrator', '127.0.0.1', NULL, 0, '2026-02-16 14:55:08', '2026-02-16 14:57:27');

-- --------------------------------------------------------

--
-- Table structure for table `review_services`
--

CREATE TABLE `review_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super_admin', 'Mengelola seluruh sistem', '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(2, 'Author', 'author', 'Menulis dan mengelola artikel', '2026-02-02 01:48:34', '2026-02-02 01:48:34'),
(3, 'Reviewer', 'reviewer', 'Mereview artikel dari penulis', '2026-02-02 01:48:34', '2026-02-02 01:48:34');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Z40dr7bZVuLuQZQOXYzaN6cQw4yx7wxNzi2JK9hi', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0xVdkc5bzZnMHVkWXIzV2twUjBZUUZtSWl4SGFuNkZjdTNiWHZUMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1771739397);

-- --------------------------------------------------------

--
-- Table structure for table `standar_pelayanans`
--

CREATE TABLE `standar_pelayanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'Perizinan',
  `deskripsi` text DEFAULT NULL,
  `persyaratan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`persyaratan`)),
  `catatan` text DEFAULT NULL,
  `icon` varchar(255) NOT NULL DEFAULT 'fa-file-alt',
  `warna` varchar(255) NOT NULL DEFAULT '#f59e0b',
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `standar_pelayanans`
--

INSERT INTO `standar_pelayanans` (`id`, `nama`, `slug`, `kategori`, `deskripsi`, `persyaratan`, `catatan`, `icon`, `warna`, `urutan`, `is_active`, `view_count`, `created_at`, `updated_at`) VALUES
(1, 'Rekomendasi Perizinan Laik Higenitas Sanitasi dan Izin Laik Sehat', 'rekomendasi-perizinan-laik-higenitas-sanitasi-dan-izin-laik-sehat', 'Sanitasi & Higienitas', 'Pelayanan rekomendasi perizinan untuk tempat usaha yang memenuhi standar higienitas dan sanitasi yang ditetapkan.', '[{\"judul\":\"Persyaratan\",\"items\":[\"Surat Permohonan\",\"Fotocopy KTP\",\"Fotocopy NPWP\",\"Akta Perusahaan (Bila Berbadan Hukum)\",\"Denah Lokasi \\/ Peta Sederhana\",\"Denah Tempat Usaha\",\"Izin Usaha\",\"Jika perpanjang dilampirkan izin Laik Higiene Sanitasi yang lama\",\"NIB (Nomor Induk Berusaha)\",\"IMB (Izin Mendirikan Bangunan) \\/ PGM (Persetujuan Bangunan Gudang) Sesuai info tata ruang\"]}]', 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.', 'fa-shield-alt', '#10b981', 1, 1, 0, '2026-02-18 16:14:50', '2026-02-18 16:14:50'),
(2, 'Pemenuhan Komitmen Pengurusan SPP-IRT', 'pemenuhan-komitmen-pengurusan-spp-irt', 'Pangan & IRTP', 'Pelayanan pengurusan Sertifikat Produksi Pangan Industri Rumah Tangga (SPP-IRT) bagi pelaku usaha pangan rumahan.', '[{\"judul\":\"Persyaratan\",\"items\":[\"FC KTP\",\"FC Nomor Induk Berusaha\",\"FC Sertifikat Penyuluhan Keamanan Pangan (PKP) bagi pemohon lama \\/ perpanjang\",\"Foto ukuran 4x6 (Berwarna) 2 lembar\",\"Surat pernyataan bermaterai\",\"Sertifikat IPRT (untuk pemohon perpanjang)\",\"Data industri rumah tangga dan data produk\",\"Desain label yang akan digunakan (Bagi pemohon baru)\",\"Label lama (Bagi pemohon perpanjang)\",\"Surat pernyataan penanggung jawab (Jika ada)\",\"Surat kuasa (Jika diuruskan pihak lain)\",\"Pakta integritas\"]}]', 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.', 'fa-utensils', '#f59e0b', 2, 1, 1, '2026-02-18 16:14:50', '2026-02-18 16:28:22'),
(3, 'Rekomendasi Perizinan Apotek', 'rekomendasi-perizinan-apotek', 'Perizinan Fasyankes', 'Pelayanan rekomendasi perizinan untuk pendirian dan operasional apotek di Kabupaten Semarang.', '[{\"judul\":\"Persyaratan\",\"items\":[\"Surat permohonan kepada DPMPTSP Kab Semarang dari calon APA\",\"Fotokopi STTRA calon APA\",\"Fotokopi SIPA Calon APA\",\"Fotokopi ijazah Apoteker\",\"Fotokopi KTP Calon APA\",\"Fotokopi KTP untuk pemohon perseorangan atau Fotokopi Akta Badan Usaha\",\"Denah bangunan, denah lokasi apotek dan denah apotek terhadap apotek lain\",\"Daftar asisten apoteker dengan mencantumkan Nama, Alamat, Tanggal kelulusan dan SIKPTTK (dilampiri FC Ijazah dan SIKPTTK)\"]}]', 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.', 'fa-pills', '#3b82f6', 3, 1, 0, '2026-02-18 16:14:50', '2026-02-18 16:14:50'),
(4, 'Rekomendasi Perizinan Toko Obat', 'rekomendasi-perizinan-toko-obat', 'Perizinan Fasyankes', 'Pelayanan rekomendasi perizinan untuk pendirian toko obat di Kabupaten Semarang.', '[{\"judul\":\"Persyaratan\",\"items\":[\"Surat permohonan kepada DPMPTSP Kab. Semarang dari calon penanggung jawab toko obat\",\"FC STRTTK Calon Penanggung jawab toko obat\",\"FC SIPTTK Calon penanggung jawab toko obat\",\"FC Ijazah kefarmasian min D3 Farmasi\",\"FC KTP Calon Penanggung jawab toko obat\",\"FC KTP untuk pemohon perseorangan atau FC Akta badan usaha\",\"Denah Bangunan, denah lokasi toko obat dan denah toko obat terhadap toko obat lain\",\"Daftar alat perlengkapan toko obat\"]}]', 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.', 'fa-store', '#8b5cf6', 4, 1, 0, '2026-02-18 16:14:50', '2026-02-18 16:14:50'),
(5, 'Rekomendasi Perizinan Klinik', 'rekomendasi-perizinan-klinik', 'Perizinan Fasyankes', 'Pelayanan rekomendasi perizinan untuk pendirian klinik pratama maupun klinik utama di Kabupaten Semarang.', '[{\"judul\":\"Persyaratan\",\"items\":[\"Permohonan pendirian klinik\",\"FC KTP Pemohon\",\"FC Akta pendirian perusahaan yang sah\",\"FC Hak kepemilikan \\/ penggunaan tanah \\/ sewa minimal 5 tahun\",\"Profil klinik yang memuat struktur organisasi, tenaga dilengkapi SIP, sarana prasarana klinik dan peralatan serta jenis pelayanan\",\"FC izin lingkungan SPPL\\/UKL-UPL\",\"FC izin lokasi \\/ Keterangan lokasi (Rawat inap)\",\"FC IMB\",\"NIB (Nomor Induk Berusaha) dan izin klinik dari OSS\",\"Izin Operasional Klinik (Bila perpanjang)\",\"Penanggung jawab klinik: Klinik Utama (dr spesialis) \\/ Klinik Pratama (Dokter umum \\/ Dokter Gigi)\"]}]', 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.', 'fa-clinic-medical', '#06b6d4', 5, 1, 0, '2026-02-18 16:14:50', '2026-02-18 16:14:50'),
(6, 'Rekomendasi Perizinan Puskesmas', 'rekomendasi-perizinan-puskesmas', 'Perizinan Fasyankes', 'Pelayanan rekomendasi perizinan untuk operasional Puskesmas di wilayah Kabupaten Semarang.', '[{\"judul\":\"Persyaratan\",\"items\":[\"Persyaratan Umum Usaha\",\"Persyaratan Perpanjang\",\"Persyaratan Perubahan Perizinan Berusaha\",\"Persyaratan Khusus\",\"Sarana\",\"Struktur Organisasi\",\"Pelayanan\"]}]', 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.', 'fa-hospital', '#10b981', 6, 1, 0, '2026-02-18 16:14:50', '2026-02-18 16:14:50'),
(7, 'Rekomendasi Perizinan Rumah Sakit', 'rekomendasi-perizinan-rumah-sakit', 'Perizinan Fasyankes', 'Pelayanan rekomendasi perizinan untuk pendirian dan operasional rumah sakit di Kabupaten Semarang.', '[{\"judul\":\"Persyaratan Umum\",\"items\":[\"Berbadan Hukum\",\"Dokumen Profil Rumah Sakit\",\"Dokumen Komitmen untuk melakukan akreditasi untuk Rumah Sakit baru\",\"Surat keterangan pembebasan lahan dari Pemerintah Daerah\",\"Surat keterangan yang dibutuhkan\",\"Dokumen Self Assessment Rumah Sakit yang meliputi jenis pelayanan, sumber daya manusia, sarana, prasarana, dan alat kesehatan\",\"Durasi pemenuhan standar oleh pelaku usaha yang perizinan baru selama 1 (satu) tahun, sejak NIB dan sertifikat standar yang belum terverifikasi terbit\"]}]', 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.', 'fa-hospital-alt', '#ef4444', 7, 1, 0, '2026-02-18 16:14:50', '2026-02-18 16:14:50'),
(8, 'Rekomendasi Perizinan Panti Sehat', 'rekomendasi-perizinan-panti-sehat', 'Perizinan Kesehatan Tradisional', 'Pelayanan rekomendasi perizinan untuk pendirian panti sehat di Kabupaten Semarang.', '[{\"judul\":\"Persyaratan\",\"items\":[\"Persyaratan Umum\",\"Persyaratan Perpanjang\",\"Persyaratan Perubahan\",\"Persyaratan Khusus Usaha\",\"Sarana\",\"Struktur Organisasi SDM\",\"Persyaratan Produk \\/ Jasa \\/ Proses\"]}]', 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.', 'fa-spa', '#f97316', 8, 1, 0, '2026-02-18 16:14:50', '2026-02-18 16:14:50'),
(9, 'Rekomendasi Perizinan Penyehat Tradisional / Hattra / STPT', 'rekomendasi-perizinan-penyehat-tradisional-hattra-stpt', 'Perizinan Kesehatan Tradisional', 'Pelayanan rekomendasi perizinan bagi penyehat tradisional (Hattra) dan penerbitan Surat Terdaftar Penyehat Tradisional (STPT).', '[{\"judul\":\"Persyaratan\",\"items\":[\"Surat permohonan dari penanggung jawab kepada kepala DPMPTSP Kab. Semarang (Bermaterai Rp. 10.000,-)\",\"Surat pernyataan mengenai metode atau teknik pelayanan yang diberikan\",\"FC KTP yang masih berlaku\",\"Pas foto terbaru 4x6 sebanyak 2 lembar\",\"Surat keterangan lokasi tempat praktik dari lurah atau desa\",\"Surat pengantar dari puskesmas\",\"Surat rekomendasi dari Dinkes kabupaten\",\"Surat rekomendasi dari asosiasi sejenis atau surat keterangan dari tempat kegiatan magang\",\"FC sertifikat \\/ ijazah penyehat tradisional (Bila ada)\",\"Denah lokasi menuju sarana Hattra\"]}]', 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.', 'fa-leaf', '#84cc16', 9, 1, 0, '2026-02-18 16:14:50', '2026-02-18 16:14:50'),
(10, 'Rekomendasi Perizinan Griya Sehat', 'rekomendasi-perizinan-griya-sehat', 'Perizinan Kesehatan Tradisional', 'Pelayanan rekomendasi perizinan untuk pendirian griya sehat sebagai fasilitas pelayanan kesehatan tradisional.', '[{\"judul\":\"Persyaratan Umum\",\"items\":[\"Surat permohonan dari penanggung jawab kepada Kepala DPMPTSP Kabupaten Semarang\",\"Dokumen Profil Griya Sehat\",\"Durasi pemenuhan standar oleh pelaku usaha untuk perizinan usaha baru selama 6 (enam) bulan sejak NIB diterbitkan\"]},{\"judul\":\"Persyaratan Khusus\",\"items\":[\"Dokumen sarana, prasarana dan peralatan\",\"Dokumen SIP TKT (Surat Izin Praktik Tenaga Kesehatan Tradisional)\"]},{\"judul\":\"Persyaratan Perpanjang\",\"items\":[\"Dokumen sertifikat standar usaha griya sehat atau surat izin operasional griya sehat yang masih berlaku\",\"Dokumen self assessment griya sehat\"]}]', 'Detail Persyaratan lain bisa scan barcode yang tersedia. Seluruh Pelayanan GRATIS.', 'fa-home', '#14b8a6', 10, 1, 0, '2026-02-18 16:14:50', '2026-02-18 16:14:50'),
(11, 'Pelayanan Pengajuan BPJS PBPU BP Pemda', 'pelayanan-pengajuan-bpjs-pbpu-bp-pemda', 'Jaminan Kesehatan', 'Pelayanan pengajuan kepesertaan BPJS Kesehatan bagi Pekerja Bukan Penerima Upah (PBPU) yang dibiayai oleh Pemerintah Daerah Kabupaten Semarang.', '[{\"judul\":\"Persyaratan\",\"items\":[\"Fotocopy KK\",\"Fotocopy KTP\",\"SKTM (Surat Keterangan Tidak Mampu yang ditandatangani lurah dan camat)\"]},{\"judul\":\"Data Dukung\",\"items\":[\"Buku KIA untuk ibu hamil\",\"Surat keterangan dokter untuk yang sakit kronis \\/ katastropik \\/ ODGJ \\/ sedang di rawat di rumah sakit atau puskesmas dan klinik rawat inap\",\"Surat keterangan dari Dinas Sosial atau dokter bagi penyandang disabilitas\"]}]', 'Seluruh Pelayanan GRATIS.', 'fa-id-card', '#6366f1', 11, 1, 2, '2026-02-18 16:14:50', '2026-02-18 16:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `struktur_organisasi`
--

CREATE TABLE `struktur_organisasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tupoksi`
--

CREATE TABLE `tupoksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `tugas_pokok` text NOT NULL,
  `fungsi` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tupoksi`
--

INSERT INTO `tupoksi` (`id`, `title`, `tugas_pokok`, `fungsi`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Kepala Dinas', '<p>Melaksanakan urusan Pemerintahan Daerah di bidang Kesehatan yang menjadi kewenangan Daerah.</p>', '<p>a. perumusan kebijakan di bidang kesehatan; b. pelaksanaan kebijakan di bidang kesehatan; c. pelaksanaan evaluasi dan pelaporan di bidang kesehatan; d. pelaksanaan administrasi Dinas; dan e. pelaksanaan fungsi lain yang diberikan oleh Bupati terkait dengan tugas dan fungsinya.</p>', 0, 1, '2026-02-05 08:27:38', '2026-02-05 08:27:53'),
(2, 'Sekretariat', '<p>Melaksanakan sebagian tugas Dinas Kesehatan di bidang penyusunan perencanaan, pengelolaan administrasi keuangan,administrasi umum, dan administrasi kepegawaian.</p>', '<p>a. pengelolaan administrasi umum, kepegawaian dan rumah tangga Dinas;</p><p>b. pengelolaan administrasi Keuangan Dinas; dan</p><p>c. pelaksanaan perencanaan, monitoring, evaluasi, dan pelaporan kegiatan Dinas.</p>', 1, 1, '2026-02-05 13:30:18', '2026-02-05 13:30:18'),
(3, 'Subbag Perencanaan', '<p>Melaksanakan sebagian tugas Sekretariat di bidang penyusunan perencanaan Dinas</p>', '<p>a. menyusun program kerja dan anggaran Subbagian Perencanaan;</p>\r\n<p>b. membagi tugas kepada bawahan dan mengarahkan pelaksanaan</p>\r\n<p>kegiatan;</p>\r\n<p>c. menghimpun dan mengoreksi bahan usulan program kegiatan dari</p>\r\n<p>masing-masing Bidang, Subbidang dan Subbagian sesuai dengan</p>\r\n<p>ketentuan Peraturan Perundang-undangan;</p>\r\n<p>d. menyiapkan bahan penyusunan Rencana Kerja dan Anggaran,</p>\r\n<p>Dokumen Pelaksanaan Anggaran dan Dokumen Pelaksanaan</p>\r\n<p>Perubahan Anggaran sesuai dengan ketentuan Peraturan</p>\r\n<p>Perundang-undangan;</p>\r\n<p>e. menyusun bahan dan melaksanakan koordinasi capaian program,</p>\r\n<p>kegiatan dan anggaran;</p>\r\n<p>f. menyusun bahan dan melaksanakan koordinasi pelaporan capaian</p>\r\n<p>kinerja;</p>\r\n<p>g. melakukan monitoring dan evaluasi pelaksanaan program kerja</p>\r\n<p>Dinas;</p>\r\n<p>h. melakukan monitoring dan evaluasi pelaksanaan kegiatan di</p>\r\n<p>lingkungan Dinas;</p>\r\n<p>i. melaksanakan monitoring dan evaluasi pelaksanaan kegiatan</p>\r\n<p>Subbagian Perencanaan;</p>\r\n<p>j. menyusun laporan pertanggungjawaban pelaksanaan kegiatan</p>\r\n<p>Subbagian Perencanaan;</p>\r\n<p>k. menyampaikan saran dan pertimbangan kepada atasan guna</p>\r\n<p>kelancaran pelaksanaan tugas; dan</p>\r\n<p>l. melaksanakan tugas kedinasan lain sesuai dengan ketentuan</p>\r\n<p>Peraturan Perundang-undangan.</p>', 2, 1, '2026-02-05 13:31:29', '2026-02-05 13:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`, `department_id`, `is_active`) VALUES
(1, 'Super Administrator', 'admin@admin.com', NULL, '$2y$12$bLSQeds2WaKllO6qAHy.FOXgQWl08BolyQ0wAtsttUUtDVwsrqXKS', NULL, '2026-02-02 01:50:32', '2026-02-02 01:50:32', 1, 3, 1),
(2, 'Reviewer P2P', 'reviewer.p2p@test.com', NULL, '$2y$12$hqc7AqLZmpUzGA1ROkJxUeYJ29pa4RDuHjJZjktwoMOgA7LSVVklO', NULL, '2026-02-02 01:50:32', '2026-02-02 01:50:32', 3, 1, 1),
(3, 'Reviewer Humas', 'reviewer.humas@test.com', NULL, '$2y$12$aqQBF.GvlGqX8bLjqZFzb.ADH2CrsadOJtEiQez0YkESRQ/yvaUkC', NULL, '2026-02-02 01:50:32', '2026-02-02 01:50:32', 3, 2, 1),
(4, 'Reviewer IT', 'reviewer.it@test.com', NULL, '$2y$12$OvlHyWdy0Hn7KDqlSv2xl.za82Y4Ymv1erwaOONXWuQh.xCocJBnq', NULL, '2026-02-02 01:50:32', '2026-02-02 01:50:32', 3, 3, 1),
(5, 'Penulis P2P', 'author.p2p@test.com', NULL, '$2y$12$UUH3m2EsyfAKMFAke5LSO.YXkHMnRXZTeM0c6.ahlOu5fp4yH6E/2', NULL, '2026-02-02 01:50:33', '2026-02-02 01:50:33', 2, 1, 1),
(6, 'Penulis Humas', 'author.humas@test.com', NULL, '$2y$12$vuEGKVkXD6SlVpNU7iKWQO5objro1/u36bhkDeJ3it3p.cOOauSA2', NULL, '2026-02-02 01:50:33', '2026-02-02 01:50:33', 2, 2, 1),
(7, 'Penulis IT', 'author.it@test.com', NULL, '$2y$12$rJcoHbiFD3/i/lFx2r.vKeqjiqdXaWBi2XIfbPJu95TelbbUM4LCi', NULL, '2026-02-02 01:50:33', '2026-02-02 01:50:33', 2, 3, 1),
(8, 'John Doe', 'john@test.com', NULL, '$2y$12$pxR4YhQiIvF9CGV6h0J/cOAcgLiIP/4N19iizGG.E2smt4emP4ETG', NULL, '2026-02-02 01:50:33', '2026-02-02 01:50:33', 2, 1, 1),
(9, 'Jane Smith', 'jane@test.com', NULL, '$2y$12$DRLFopqy84LH5IDV4q9n6eL7a3osnFQDdigV8mIGTWKXFcFAsRLre', NULL, '2026-02-02 01:50:34', '2026-02-02 01:50:34', 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `visi_misi`
--

CREATE TABLE `visi_misi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `motto` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visi_misi`
--

INSERT INTO `visi_misi` (`id`, `visi`, `misi`, `motto`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(2, '<p><strong>Bersatu, Berdaulat, Berkepribadian, Sejahtera, dan Mandiri (BERDIKARI) Dengan Semangat Gotong Royong Berdasarkan Pancasila Dalam Bingkai NKRI Yang Ber-Bhineka Tunggal Ika</strong></p>', '<p>Meningkatkan Kualitas SDM Unggul Yang Beriman dan Bertaqwa Kepada Tuhan YME, Berkepribadian Serta Menguasai Ilmu Pengetahuan dan Teknologi</p>', 'Dinas Kesehatan Kabupaten Semarang Melindungi Kesehatan Anda & Keluarga', NULL, 1, '2026-02-04 08:11:40', '2026-02-04 08:14:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_created_by_foreign` (`created_by`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_category_id_foreign` (`category_id`),
  ADD KEY `articles_author_id_foreign` (`author_id`),
  ADD KEY `articles_department_id_foreign` (`department_id`),
  ADD KEY `articles_reviewer_id_foreign` (`reviewer_id`);

--
-- Indexes for table `article_comments`
--
ALTER TABLE `article_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_comments_approved_by_foreign` (`approved_by`),
  ADD KEY `article_comments_article_id_status_index` (`article_id`,`status`),
  ADD KEY `article_comments_status_index` (`status`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `complaints_ticket_number_unique` (`ticket_number`),
  ADD KEY `complaints_complaint_service_id_foreign` (`complaint_service_id`),
  ADD KEY `complaints_ticket_number_index` (`ticket_number`),
  ADD KEY `complaints_status_index` (`status`),
  ADD KEY `complaints_created_at_index` (`created_at`);

--
-- Indexes for table `complaint_flows`
--
ALTER TABLE `complaint_flows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaint_histories`
--
ALTER TABLE `complaint_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaint_histories_complaint_id_foreign` (`complaint_id`);

--
-- Indexes for table `complaint_services`
--
ALTER TABLE `complaint_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `complaint_services_slug_unique` (`slug`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_slug_unique` (`slug`),
  ADD KEY `departments_reviewer_id_foreign` (`reviewer_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fasyankes`
--
ALTER TABLE `fasyankes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fasyankes_kode_unique` (`kode`),
  ADD KEY `fasyankes_nama_kode_index` (`nama`,`kode`);

--
-- Indexes for table `health_profiles`
--
ALTER TABLE `health_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_uploaded_by_foreign` (`uploaded_by`),
  ADD KEY `images_type_is_active_index` (`type`,`is_active`),
  ADD KEY `images_order_index` (`order`);

--
-- Indexes for table `information_faqs`
--
ALTER TABLE `information_faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `information_flows`
--
ALTER TABLE `information_flows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `information_followups`
--
ALTER TABLE `information_followups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `information_followups_information_request_id_foreign` (`information_request_id`);

--
-- Indexes for table `information_requests`
--
ALTER TABLE `information_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `information_requests_registration_number_unique` (`registration_number`);

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
-- Indexes for table `kliniks`
--
ALTER TABLE `kliniks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kliniks_kode_unique` (`kode`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_parent_id_foreign` (`parent_id`);

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
-- Indexes for table `pejabat_struktural`
--
ALTER TABLE `pejabat_struktural`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppid_categories`
--
ALTER TABLE `ppid_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ppid_categories_slug_unique` (`slug`);

--
-- Indexes for table `ppid_download_logs`
--
ALTER TABLE `ppid_download_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ppid_download_logs_ppid_information_id_index` (`ppid_information_id`);

--
-- Indexes for table `ppid_informations`
--
ALTER TABLE `ppid_informations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ppid_informations_ppid_category_id_index` (`ppid_category_id`),
  ADD KEY `ppid_informations_year_index` (`year`),
  ADD KEY `ppid_informations_is_public_index` (`is_public`);

--
-- Indexes for table `produk_hukum`
--
ALTER TABLE `produk_hukum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_hukum_created_by_foreign` (`created_by`),
  ADD KEY `produk_hukum_kategori_index` (`kategori`),
  ADD KEY `produk_hukum_tahun_index` (`tahun`),
  ADD KEY `produk_hukum_status_index` (`status`),
  ADD KEY `produk_hukum_kategori_tahun_index` (`kategori`,`tahun`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_tracking_code_unique` (`tracking_code`),
  ADD KEY `reviews_status_index` (`status`),
  ADD KEY `reviews_rating_index` (`rating`),
  ADD KEY `reviews_created_at_index` (`created_at`),
  ADD KEY `reviews_tracking_code_index` (`tracking_code`);

--
-- Indexes for table `review_services`
--
ALTER TABLE `review_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_services_review_id_service_type_index` (`review_id`,`service_type`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `standar_pelayanans`
--
ALTER TABLE `standar_pelayanans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `standar_pelayanans_slug_unique` (`slug`);

--
-- Indexes for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tupoksi`
--
ALTER TABLE `tupoksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_department_id_foreign` (`department_id`);

--
-- Indexes for table `visi_misi`
--
ALTER TABLE `visi_misi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `article_comments`
--
ALTER TABLE `article_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `complaint_flows`
--
ALTER TABLE `complaint_flows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `complaint_histories`
--
ALTER TABLE `complaint_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `complaint_services`
--
ALTER TABLE `complaint_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fasyankes`
--
ALTER TABLE `fasyankes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `health_profiles`
--
ALTER TABLE `health_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `information_faqs`
--
ALTER TABLE `information_faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `information_flows`
--
ALTER TABLE `information_flows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `information_followups`
--
ALTER TABLE `information_followups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `information_requests`
--
ALTER TABLE `information_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kliniks`
--
ALTER TABLE `kliniks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `pejabat_struktural`
--
ALTER TABLE `pejabat_struktural`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ppid_categories`
--
ALTER TABLE `ppid_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ppid_download_logs`
--
ALTER TABLE `ppid_download_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppid_informations`
--
ALTER TABLE `ppid_informations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk_hukum`
--
ALTER TABLE `produk_hukum`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `review_services`
--
ALTER TABLE `review_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `standar_pelayanans`
--
ALTER TABLE `standar_pelayanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tupoksi`
--
ALTER TABLE `tupoksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `visi_misi`
--
ALTER TABLE `visi_misi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `article_comments`
--
ALTER TABLE `article_comments`
  ADD CONSTRAINT `article_comments_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `article_comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_complaint_service_id_foreign` FOREIGN KEY (`complaint_service_id`) REFERENCES `complaint_services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `complaint_histories`
--
ALTER TABLE `complaint_histories`
  ADD CONSTRAINT `complaint_histories_complaint_id_foreign` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `information_followups`
--
ALTER TABLE `information_followups`
  ADD CONSTRAINT `information_followups_information_request_id_foreign` FOREIGN KEY (`information_request_id`) REFERENCES `information_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ppid_download_logs`
--
ALTER TABLE `ppid_download_logs`
  ADD CONSTRAINT `ppid_download_logs_ppid_information_id_foreign` FOREIGN KEY (`ppid_information_id`) REFERENCES `ppid_informations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ppid_informations`
--
ALTER TABLE `ppid_informations`
  ADD CONSTRAINT `ppid_informations_ppid_category_id_foreign` FOREIGN KEY (`ppid_category_id`) REFERENCES `ppid_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `produk_hukum`
--
ALTER TABLE `produk_hukum`
  ADD CONSTRAINT `produk_hukum_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `review_services`
--
ALTER TABLE `review_services`
  ADD CONSTRAINT `review_services_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
