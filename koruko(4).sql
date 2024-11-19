-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 19, 2024 at 11:25 AM
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
(1, 1, 'rukoa.webp'),
(2, 2, 'rukob.webp'),
(3, 3, 'rukoc.webp'),
(4, 4, 'rukod.webp'),
(5, 5, 'rukoe.webp'),
(6, 6, 'rukof.webp'),
(7, 7, 'rukog.webp'),
(8, 8, 'rukoh.webp'),
(9, 9, 'rukoi.webp'),
(10, 10, 'rukoj.webp');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gambar_ruko`
--
ALTER TABLE `gambar_ruko`
  ADD PRIMARY KEY (`id_gambar`),
  ADD KEY `id_ruko` (`id_ruko`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gambar_ruko`
--
ALTER TABLE `gambar_ruko`
  MODIFY `id_gambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gambar_ruko`
--
ALTER TABLE `gambar_ruko`
  ADD CONSTRAINT `gambar_ruko_ibfk_1` FOREIGN KEY (`id_ruko`) REFERENCES `ruko` (`id_ruko`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
