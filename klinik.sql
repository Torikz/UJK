-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 24, 2026 at 01:06 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_klinik`
--

-- --------------------------------------------------------

--
-- Table structure for table `asesmen`
--

CREATE TABLE `asesmen` (
  `id` int NOT NULL,
  `kunjunganid` int DEFAULT NULL,
  `keluhan_utama` text,
  `keluhan_tambahan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `asesmen`
--

INSERT INTO `asesmen` (`id`, `kunjunganid`, `keluhan_utama`, `keluhan_tambahan`) VALUES
(3, 1, 'Demam', 'Pilek');

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan`
--

CREATE TABLE `kunjungan` (
  `id` int NOT NULL,
  `pendaftaranpasienid` int DEFAULT NULL,
  `jeniskunjungan` varchar(50) DEFAULT NULL,
  `tglkunjungan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kunjungan`
--

INSERT INTO `kunjungan` (`id`, `pendaftaranpasienid`, `jeniskunjungan`, `tglkunjungan`) VALUES
(1, 1, 'IGD', '2026-01-09'),
(2, 2, 'Poli Gigi', '2026-01-09'),
(3, 3, 'Konsultasi', '2026-01-09');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `norm` varchar(20) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `norm`, `alamat`) VALUES
(1, 'Leanne Graham', 'REG-943', 'Kulas Light'),
(2, 'Ervin Howell', 'REG-911', 'Victor Plains'),
(3, 'Clementine Bauch', 'REG-505', 'Douglas Extension'),
(4, 'Patricia Lebsack', 'REG-348', 'Hoeger Mall'),
(5, 'Chelsey Dietrich', 'REG-693', 'Skiles Walks'),
(6, 'Mrs. Dennis Schulist', 'REG-123', 'Norberto Crossing'),
(7, 'Kurtis Weissnat', 'REG-876', 'Rex Trail'),
(8, 'Nicholas Runolfsdottir V', 'REG-391', 'Ellsworth Summit'),
(9, 'Glenna Reichert', 'REG-527', 'Dayna Park'),
(10, 'Clementina DuBuque', 'REG-236', 'Kattie Turnpike'),
(16, 'Mrs. Dennis Schulist', 'REG-652', 'Norberto Crossing'),
(17, 'Kurtis Weissnat', 'REG-224', 'Rex Trail'),
(18, 'Nicholas Runolfsdottir V', 'REG-240', 'Ellsworth Summit'),
(19, 'Glenna Reichert', 'REG-417', 'Dayna Park'),
(22, 'Maya', 'REG-333', 'Sukoharjo'),
(23, 'Ganjar MD', 'REG-332', 'Surakarta');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int NOT NULL,
  `pasienid` int DEFAULT NULL,
  `noregistrasi` varchar(50) DEFAULT NULL,
  `tglregistrasi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `pasienid`, `noregistrasi`, `tglregistrasi`) VALUES
(1, 2, 'REG-20260109145030', '2026-01-09'),
(2, 22, 'REG-20260109150949', '2026-01-09'),
(3, 23, 'REG-20260109152606', '2026-01-10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admisi','perawat') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$uZ1.k.s3.1.1.1.1.1.1.1.1.1.1.1.1', 'superadmin'),
(2, 'admisi', '$2y$10$uZ1.k.s3.1.1.1.1.1.1.1.1.1.1.1.1', 'admisi'),
(3, 'perawat', '$2y$10$uZ1.k.s3.1.1.1.1.1.1.1.1.1.1.1.1', 'perawat');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asesmen`
--
ALTER TABLE `asesmen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kunjunganid` (`kunjunganid`);

--
-- Indexes for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftaranpasienid` (`pendaftaranpasienid`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasienid` (`pasienid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asesmen`
--
ALTER TABLE `asesmen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asesmen`
--
ALTER TABLE `asesmen`
  ADD CONSTRAINT `asesmen_ibfk_1` FOREIGN KEY (`kunjunganid`) REFERENCES `kunjungan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD CONSTRAINT `kunjungan_ibfk_1` FOREIGN KEY (`pendaftaranpasienid`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`pasienid`) REFERENCES `pasien` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
