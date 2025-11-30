-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2023 at 06:43 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pandawa`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', '5f4dcc3b5aa765d61d8327deb882cf99');

-- --------------------------------------------------------

--
-- Table structure for table `arsip_dokim`
--

CREATE TABLE `arsip_dokim` (
  `id` int(255) NOT NULL,
  `nomor_permohonan` varchar(255) NOT NULL,
  `nomor_rak` varchar(255) NOT NULL,
  `tanggal_input` date NOT NULL,
  `nip_input` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `tanggal_serah` date NOT NULL,
  `nip_serah` varchar(255) NOT NULL,
  `penerima` varchar(255) NOT NULL,
  `tanggal_arsip` date NOT NULL,
  `nip_arsip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dokim_wna`
--

CREATE TABLE `dokim_wna` (
  `nomor_permohonan` varchar(255) NOT NULL,
  `niora` varchar(255) NOT NULL,
  `nomor_dokim` varchar(255) NOT NULL,
  `nomor_paspor` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kebangsaan` varchar(255) NOT NULL,
  `jenis_kelamin` text NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_layanan` varchar(255) NOT NULL,
  `tanggal_permohonan` date NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal_input` date NOT NULL,
  `nip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `nip` varchar(255) NOT NULL,
  `aktifitas` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rak`
--

CREATE TABLE `rak` (
  `nomor_rak` varchar(255) NOT NULL,
  `kuota` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `nip` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`nip`, `nama`, `password`, `status`) VALUES
('198905092017121001', 'Yudha Kumaladiantara', '5f4dcc3b5aa765d61d8327deb882cf99', 'Aktif'),
('19990101202001011001', 'testing users', '5f4dcc3b5aa765d61d8327deb882cf99', 'Tidak Aktif'),
('199101012017121004', 'HERU SULISTYO', '5f4dcc3b5aa765d61d8327deb882cf99', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `wa`
--

CREATE TABLE `wa` (
  `id_wa` int(1) NOT NULL,
  `token` varchar(255) NOT NULL,
  `pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wa`
--

INSERT INTO `wa` (`id_wa`, `token`, `pesan`) VALUES
(1, 'RvbEx7YL1IeMmvxs#h65', 'Pengurusan Dokumen Keimigrasian dengan Nomor Permohonan {var1} atas nama {name} sudah selesai dan dapat diambil dalam 2 (dua) hari kerja.\r\nTerima Kasih\r\n\r\nKantor Imigrasi Kelas I TPI Balikpapan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arsip_dokim`
--
ALTER TABLE `arsip_dokim`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arsip_dokim`
--
ALTER TABLE `arsip_dokim`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
