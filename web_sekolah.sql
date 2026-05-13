-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2026 at 05:25 PM
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
-- Database: `web_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `id`) VALUES
('admin', '$2y$10$LPaVJuQCgl7jZsQwrfGCQuWdHcHl1HA4Oi22e..Z4/oL5YJ9Kx2eq', 1);

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal_posting` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `isi`, `gambar`, `tanggal_posting`) VALUES
(4, 'judul berita', 'isi berita', '1778681887_bunsdrew on TikTok.jpg', '2026-05-13 21:18:07');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id`, `judul`, `gambar`, `deskripsi`, `tanggal_upload`) VALUES
(1, 'judul foto', '1778681748_46992160_1892221997561139_3517656796145647616_n.jpg', 'deskripsi foto', '2026-05-13 14:15:48');

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `nama_sekolah` varchar(100) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `sejarah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id`, `nama_sekolah`, `logo`, `alamat`, `visi`, `misi`, `sejarah`) VALUES
(1, 'SD NEGERI KAJEN 01', '', 'Jalan Ronggokusumo, Kajen, Margoyoso, Pati, Jawa Tengah', 'Membentuk manusia yang trampil, kreatif, berprestasi, serta peduli lingkungan yang dilandasi iman dan taqwa', '1. Melaksanakan pembinaan dan bimbingan terhadap pelaksanaan ajaran agama secara berkesinambungan.\r\n2. Melaksanakan pembelajaran yang aktif, kreatif, efektif, dan menyenangkan (PAKEM) untuk mengembangkan potensi siswa secara optimal.\r\n3. Mengembangkan kreativitas dan keterampilan anak didik melalui berbagai kegiatan ekstrakurikuler dan praktik langsung.\r\n4. Membiasakan perilaku luhur, budi pekerti yang baik, serta menanamkan rasa disiplin dan tanggung jawab pada seluruh warga sekolah.\r\n5. Menciptakan lingkungan sekolah yang bersih, sehat, asri, dan nyaman guna mendukung proses belajar mengajar.', 'Dahulu kala di Desa Kajen, sekitar tahun 1978, ada sebuah cita-cita besar untuk memajukan pendidikan warga desa. Saat itu, Bapak Jazuli (Kepala Desa) dan Bapak Achmad Rifai (Ketua LKMD) bahu-membahu mewujudkan kehadiran sebuah sekolah dasar di atas lahan milik desa.Melalui program SD Inpres, berdirilah SD Negeri Kajen. Awalnya, sekolah ini hanyalah sebuah bangunan sederhana dengan 6 ruang kelas. Namun, seiring berjalannya waktu dan meningkatnya jumlah anak-anak yang ingin belajar, bangunan sekolah diperluas pada tahun 1994.Kini, sekolah tersebut telah tumbuh menjadi tempat belajar yang membanggakan. Dengan semangat \"Membentuk manusia yang trampil, kreatif, dan bertaqwa\", SD Negeri Kajen terus berupaya menjaga keasrian lingkungan dan prestasi siswanya agar tetap menjadi cahaya pendidikan di wilayah Margoyoso.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
