-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 20, 2024 at 10:37 PM
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
-- Database: `koruko`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `nama_admin` varchar(30) NOT NULL,
  `sandi` varchar(255) NOT NULL,
  `gambar_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`nama_admin`, `sandi`, `gambar_admin`) VALUES
('admin', '$2y$10$mUwxU6Lz4RW4nqma/FU1MOAtQ.EsxWtHbFwy5G5IBmHlipucnw9.6', 'profil_admin.png');

-- --------------------------------------------------------

--
-- Table structure for table `gambar_ruko`
--

CREATE TABLE `gambar_ruko` (
  `id_gambar` int(11) NOT NULL,
  `id_ruko` int(11) NOT NULL,
  `gambar_properti` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gambar_ruko`
--

INSERT INTO `gambar_ruko` (`id_gambar`, `id_ruko`, `gambar_properti`) VALUES
(23, 1, 'ruko_1_673e4da620b88.webp'),
(24, 1, 'ruko_1_673e4da620e96.webp'),
(25, 1, 'ruko_1_673e4da621087.webp'),
(26, 2, 'ruko_2_673e4dc96b0dd.webp'),
(30, 4, 'ruko_4_673e4e015b6fc.jpeg'),
(31, 4, 'ruko_4_673e4e015b920.webp'),
(32, 4, 'ruko_4_673e4e015c550.webp'),
(33, 3, 'ruko_3_673e4e3c57695.webp'),
(34, 3, 'ruko_3_673e4e3c5803f.webp'),
(35, 3, 'ruko_3_673e4e3c581ee.jpeg'),
(36, 21, 'ruko_21_673e5666aab18.webp'),
(37, 21, 'ruko_21_673e5666aaf42.webp');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `nama_pengguna` varchar(20) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `sandi` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `gambar_user` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`nama_pengguna`, `nama_lengkap`, `sandi`, `email`, `telepon`, `gambar_user`) VALUES
('injil35', 'Injil Karepowan', '$2y$10$mUwxU6Lz4RW4nqma/FU1MOAtQ.EsxWtHbFwy5G5IBmHlipucnw9.6', 'injil@gmail.com', '089988887777', NULL),
('Koruko', 'Koruko', '$2y$10$9O2Tq83ZpXmOplMkD1/K3OyNG8dp1ZK1ZIx1c63mZSXdJHZ2Qb1KS', 'Koruko@gmail.com', '08111122223', 'Koruko_1732133017.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `ruko`
--

CREATE TABLE `ruko` (
  `id_ruko` int(11) NOT NULL,
  `nama_pengguna` varchar(30) NOT NULL,
  `nama_ruko` varchar(30) NOT NULL,
  `harga_jual` bigint(20) DEFAULT NULL,
  `harga_sewa` bigint(20) DEFAULT NULL,
  `kota` varchar(30) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `luas_bangunan` int(11) NOT NULL DEFAULT 0,
  `luas_tanah` int(11) DEFAULT 0,
  `jmlh_kmr_tdr` int(11) NOT NULL DEFAULT 0,
  `jmlh_kmr_mandi` int(11) NOT NULL DEFAULT 0,
  `jmlh_lantai` int(11) NOT NULL DEFAULT 0,
  `jmlh_garasi` int(11) NOT NULL DEFAULT 0,
  `tanggal` date NOT NULL,
  `status` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruko`
--

INSERT INTO `ruko` (`id_ruko`, `nama_pengguna`, `nama_ruko`, `harga_jual`, `harga_sewa`, `kota`, `alamat`, `luas_bangunan`, `luas_tanah`, `jmlh_kmr_tdr`, `jmlh_kmr_mandi`, `jmlh_lantai`, `jmlh_garasi`, `tanggal`, `status`, `deskripsi`) VALUES
(1, 'Koruko', 'Ruko Koruko', 100000, 10000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250000, 0, 0, 0, 0, '2024-11-14', 1, 'Ini Rumah Keren\"'),
(2, 'Koruko', 'Ruko Koruko 2', 0, 200000, 'Sangatta', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren\"'),
(3, 'Koruko', 'Ruko Koruko 3', 0, 200000, 'Bontang', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren\"\"'),
(4, 'Koruko', 'Ruko Koruko 4', 0, 200000, 'Balikpapan', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren\"'),
(5, 'Koruko', 'Ruko Koruko 5', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(6, 'Koruko', 'Ruko Koruko 6', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(7, 'Koruko', 'Ruko Koruko 7', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(8, 'Koruko', 'Ruko Koruko 8', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(9, 'Koruko', 'Ruko Koruko 9', 255, 0, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-19', 1, ''),
(12, 'Koruko', 'Ruko Koruko 12', 255, 0, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-19', 1, ''),
(13, 'Koruko', 'Ruko Koruko 13', 255, 0, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-19', 1, ''),
(14, 'Koruko', 'Ruko Koruko 14', 255, 0, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-19', 1, ''),
(15, 'Koruko', 'Ruko Koruko 15', 255, 0, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-19', 1, ''),
(16, 'Koruko', 'Ruko Koruko 16', 255, 0, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-19', 1, ''),
(17, 'Koruko', 'Ruko Koruko 17', 255, 0, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-19', 1, ''),
(18, 'Koruko', 'Ruko Koruko 18', 255, 0, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-19', 1, ''),
(19, 'Koruko', 'Ruko Koruko 19', 255, 0, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-19', 1, ''),
(20, 'Koruko', 'Ruko Koruko 20', 255, 0, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-19', 1, ''),
(21, 'Koruko', 'Ruko Koruko 21', 255, 0, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-19', 1, '\"');

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE `website` (
  `judul` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `deskripsi_tentang` text NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `instagram` text NOT NULL,
  `facebook` text NOT NULL,
  `youtube` text NOT NULL,
  `twitter` text NOT NULL,
  `deskripsi_footer` text NOT NULL,
  `logo_web` varchar(255) NOT NULL,
  `gambar_tentang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website`
--

INSERT INTO `website` (`judul`, `email`, `telepon`, `alamat`, `deskripsi_tentang`, `visi`, `misi`, `instagram`, `facebook`, `youtube`, `twitter`, `deskripsi_footer`, `logo_web`, `gambar_tentang`) VALUES
('Koruko', 'Koruko@gmail.com', '081122223333', 'Jalan wahid hasyim 2 Kos sempaja', 'Koruko adalah platform digital yang menyediakan informasi terpercaya mengenai ruko  di Samarinda. Kami hadir untuk membantu Anda dalam menemukan hunian atau ruang usaha yang sesuai dengan kebutuhan dan anggaran Anda, dengan berbagai pilihan properti yang terletak di lokasi strategis. Melalui layanan kami, Anda dapat menemukan deskripsi lengkap, foto, serta informasi kontak yang memudahkan proses pencarian tempat tinggal atau ruang usaha di Samarinda. Kami berkomitmen untuk memberikan pengalaman terbaik dengan informasi yang selalu diperbarui dan akurat, menjadikan pencarian properti menjadi lebih mudah dan efisien.', 'Menjadi platform digital terdepan di Samarinda yang menyediakan informasi lengkap, akurat, dan terpercaya tentang properti, khususnya ruko , sehingga memudahkan masyarakat untuk menemukan hunian yang aman, nyaman, dan sesuai dengan kebutuhan. Kami bercita-cita untuk mendukung pertumbuhan ekonomi lokal dengan menghadirkan ekosistem properti yang transparan, inovatif, dan ramah pengguna, sehingga setiap orang dapat dengan mudah mendapatkan tempat tinggal atau ruang usaha yang ideal.', 'Kami berkomitmen untuk menyediakan informasi properti yang lengkap, akurat, dan terpercaya, agar para pengguna dapat membuat keputusan terbaik dalam memilih hunian atau ruang usaha. Dengan menjalin kerja sama yang erat bersama pemilik properti, kami memastikan setiap tempat yang ditawarkan memenuhi standar kualitas dan keamanan yang tinggi. Selain itu, kami terus mengembangkan teknologi dan fitur inovatif untuk memberikan pengalaman pencarian yang cepat, mudah, dan nyaman, sehingga pengguna dapat menemukan properti yang sesuai dengan kebutuhan mereka tanpa kesulitan.', 'https://www.instagram.com/rjiansyahh/', 'https://www.instagram.com/rjiansyahh/', 'https://www.instagram.com/rjiansyahh/', 'https://www.instagram.com/rjiansyahh/', 'Koruko adalah platform  yang bertujuan untuk membantu  menemukan ruko idaman untuk disewa atau dibeli. Kami menyediakan informasi lengkap dan terkini tentang harga, lokasi, dan fitur-fitur lainnya untuk membantu Anda dalam proses pencarian.', 'koruko_purple.png', 'gambar_tentang.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`nama_admin`);

--
-- Indexes for table `gambar_ruko`
--
ALTER TABLE `gambar_ruko`
  ADD PRIMARY KEY (`id_gambar`),
  ADD KEY `id_ruko` (`id_ruko`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`nama_pengguna`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telepon` (`telepon`);

--
-- Indexes for table `ruko`
--
ALTER TABLE `ruko`
  ADD PRIMARY KEY (`id_ruko`),
  ADD KEY `nama_pengguna` (`nama_pengguna`);

--
-- Indexes for table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`judul`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gambar_ruko`
--
ALTER TABLE `gambar_ruko`
  MODIFY `id_gambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ruko`
--
ALTER TABLE `ruko`
  MODIFY `id_ruko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gambar_ruko`
--
ALTER TABLE `gambar_ruko`
  ADD CONSTRAINT `gambar_ruko_ibfk_1` FOREIGN KEY (`id_ruko`) REFERENCES `ruko` (`id_ruko`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ruko`
--
ALTER TABLE `ruko`
  ADD CONSTRAINT `ruko_ibfk_1` FOREIGN KEY (`nama_pengguna`) REFERENCES `pengguna` (`nama_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
