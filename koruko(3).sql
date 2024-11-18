-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 18, 2024 at 07:47 AM
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
('admin', '$2y$10$5pEj7Yuo/6EjQnoePV.jB.NA0IikIv0zuZaVNbkjuBc3ka5lujyo6', 'profil_admin.png');

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
(1, 1, 'rukoa.webp');

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
('Kedua', 'Orang Kedua', '$2y$10$PWoILy9caioORmvT1ohVtO1qnOe41abWcx2ijLoXze2m.ULVbyj9u', 'kedua@gmail.com', '0822223333', NULL),
('Koruko', 'Koruko', '$2y$10$5pEj7Yuo/6EjQnoePV.jB.NA0IikIv0zuZaVNbkjuBc3ka5lujyo6', 'Koruko@gmail.com', '0811112222', NULL),
('pengguna', 'Pengguna', '$2y$10$G.rsNaDmzbyf5qC4YDE2DeMdO7PEREK8PCmq3OgWQHQqjW4FBnsL.', 'pengguna@gmail.com', '083333444455', NULL),
('username', 'nama lengkap', '$2y$10$d.bYMTw837nNYACF1/CQGO2JouDjC3O9GKA/SOSKUFxp39v0lrIN2', 'user@gmail.com', '0811111111', NULL);

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
  `luas_bangunan` int(11) NOT NULL,
  `luas_tanah` int(11) NOT NULL,
  `jmlh_kmr_tdr` int(11) NOT NULL,
  `jmlh_kmr_mandi` int(11) NOT NULL,
  `jmlh_lantai` int(11) NOT NULL,
  `jmlh_garasi` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruko`
--

INSERT INTO `ruko` (`id_ruko`, `nama_pengguna`, `nama_ruko`, `harga_jual`, `harga_sewa`, `kota`, `alamat`, `luas_bangunan`, `luas_tanah`, `jmlh_kmr_tdr`, `jmlh_kmr_mandi`, `jmlh_lantai`, `jmlh_garasi`, `tanggal`, `status`, `deskripsi`) VALUES
(1, 'Koruko', 'Ruko Koruko', 100000, 10000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 0, 'Ini Rumah Keren');

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
('Koruko', 'Koruko@gmail.com', '081122223333', NULL, 'Deskripsi Tentang', 'Visi Tentang', 'Misi Tentang', '', '', '', '', 'Deskripsi Footer', 'koruko_purple.png', '');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gambar_ruko`
--
ALTER TABLE `gambar_ruko`
  MODIFY `id_gambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ruko`
--
ALTER TABLE `ruko`
  MODIFY `id_ruko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
