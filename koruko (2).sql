-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 20, 2024 at 10:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
(1, 'Koruko', 'Ruko Koruko', 100000, 10000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250000, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(2, 'Koruko', 'Ruko Koruko 2', 3000000, NULL, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(3, 'Koruko', 'Ruko Koruko 3', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(4, 'Koruko', 'Ruko Koruko 4', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(5, 'Koruko', 'Ruko Koruko 5', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(6, 'Koruko', 'Ruko Koruko 6', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(7, 'Koruko', 'Ruko Koruko 7', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(8, 'Koruko', 'Ruko Koruko 8', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(9, 'Koruko', 'Ruko Koruko 9', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Ini Rumah Keren'),
(10, 'Koruko', 'Ruko Koruko 10', NULL, 200000, 'Samarinda', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 2, 'Ini Rumah Keren'),
(11, 'Koruko', 'Ruko Koruko 13', NULL, 200000, 'Balikpapan', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(12, 'Koruko', 'Ruko Koruko 15', NULL, 200000, 'Jawa', 'Jalan Sempaja Gg Sempaja', 200, 250, 0, 0, 0, 0, '2024-11-13', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(13, 'Koruko', 'Ruko Koruko 25', 100000, 10000, 'Samarinda', 'Haji Masdar', 200, 250000, 0, 0, 0, 0, '2024-11-13', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(14, 'Koruko', 'Ruko Koruko 26', 100000, 10000, 'Samarinda', 'Haji Masdar', 200, 250000, 0, 0, 0, 0, '2024-11-13', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(15, 'Koruko', 'Ruko Koruko 27', 100000, 10000, 'Samarinda', 'Haji Masdar', 200, 250000, 0, 0, 0, 0, '2024-11-13', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(16, 'Koruko', 'Ruko Koruko 28', 100000, 10000, 'Samarinda', 'Haji Masdar', 200, 250000, 0, 0, 0, 0, '2024-11-13', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(17, 'Koruko', 'Ruko Koruko 29', 100000, 10000, 'Samarinda', 'Haji Masdar', 200, 250000, 0, 0, 0, 0, '2024-11-13', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(18, 'Koruko', 'Ruko Koruko 30', 100000, 10000, 'Samarinda', 'Haji Masdar', 200, 250000, 0, 0, 0, 0, '2024-11-13', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(19, 'Koruko', 'Ruko Koruko 31', 100000, 10000, 'Samarinda', 'Haji Masdar', 200, 250000, 0, 0, 0, 0, '2024-11-13', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(20, 'Koruko', 'Ruko Koruko 32', 100000, 10000, 'Samarinda', 'Haji Masdar', 200, 250000, 0, 0, 0, 0, '2024-11-13', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(21, 'Koruko', 'Ruko Koruko 32', 100000, 10000, 'Samarinda', 'Haji Masdar', 200, 250000, 0, 0, 0, 0, '2024-11-13', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `ruko`
--
ALTER TABLE `ruko`
  MODIFY `id_ruko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ruko`
--
ALTER TABLE `ruko`
  ADD CONSTRAINT `ruko_ibfk_1` FOREIGN KEY (`nama_pengguna`) REFERENCES `pengguna` (`nama_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
