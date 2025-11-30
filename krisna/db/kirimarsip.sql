-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2024 at 01:22 AM
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
-- Database: `kirimarsip`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99');

-- --------------------------------------------------------

--
-- Table structure for table `arsipterkirim`
--

CREATE TABLE `arsipterkirim` (
  `nomor_permohonan` varchar(255) NOT NULL,
  `no_dokim` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal_kirim` date NOT NULL,
  `nip_kirim` varchar(255) NOT NULL,
  `seksi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `arsipterkirim`
--

INSERT INTO `arsipterkirim` (`nomor_permohonan`, `no_dokim`, `nama`, `tanggal_kirim`, `nip_kirim`, `seksi`) VALUES
('310094191230003', '2C21MD0338-X', 'SHERRILL LEE GRANT', '2023-08-02', 'triaini', 'tikim'),
('310094191230010', '2C21MD0354-X', 'ERIK MATTHEW BORGGREN', '2023-08-02', 'triaini', 'tikim'),
('310094193230005', '2C21MD0356-X', 'WONG CHIAT SEONG', '2023-08-02', 'triaini', 'tikim'),
('310094193230013', '1G01MD0014-X', 'CLOUDHEA MORRIS', '2023-08-02', 'triaini', 'tikim'),
('310094198230036', '2C21MD0359-X', 'LEE KOK SEANG', '2023-08-02', 'triaini', 'tikim'),
('310094199230005', '2C11MD0097-X', 'JOUNG HYEJOUNG', '2023-08-02', 'triaini', 'tikim'),
('310094199230006', '2C11MD0095-X', 'KIM TAEI', '2023-08-02', 'triaini', 'tikim'),
('310094199230007', '2C11MD0096-X', 'KIM JAE', '2023-08-02', 'triaini', 'tikim'),
('310094201230004', '2B21MD0101-X', 'JORINA HERLINDE G VAN ROEYEN', '2023-08-02', 'triaini', 'tikim'),
('310094201230007', '2C21MD0355-X', 'TIMOTHY PAUL RICHARDS', '2023-08-02', 'triaini', 'tikim'),
('310094202230002', '2C21MD0361-X', 'WONG CHING YONG', '2023-08-02', 'triaini', 'tikim'),
('310094202230005', '2C21MD0360-X', 'HEE JUNG JUNG', '2023-08-02', 'triaini', 'tikim'),
('310094205230016', '2M12MD0041-X', 'WALTER TREVOR DIAS', '2023-08-02', 'triaini', 'tikim'),
('310094205230017', '2B21MD0102-X', 'YOUNG SUN SEO', '2023-08-02', 'triaini', 'tikim'),
('310094205230019', '2C21MD0362-X', 'JOEL LEIGH ARKLESS', '2023-08-02', 'triaini', 'tikim'),
('310094206230011', '2C21MD0364-X', 'HARISH KUMAR DODDABELAVANGALA NAGARAJU', '2023-08-02', 'triaini', 'tikim'),
('310094206230012', '2C21MD0365-X', 'SANTHAKUMAR PRABHAKARAN', '2023-08-02', 'triaini', 'tikim'),
('310094206230015', '2B21MD0103-X', 'AHMAD BIN SAPARAN', '2023-08-02', 'triaini', 'tikim'),
('310094206230017', '2C21MD0368-X', 'XIANGYU LI', '2023-08-02', 'triaini', 'tikim'),
('310094206230018', '2C23MD0013-X', 'LONG FENG ', '2023-08-02', 'triaini', 'tikim'),
('310094206230019', '2C23MD0012-X', 'CHUNSONG JIANG', '2023-08-02', 'triaini', 'tikim'),
('310094206230020', '2C21MD0363-X', 'THOMAS JOSEPH WILLIAM NEUMAIR', '2023-08-02', 'triaini', 'tikim'),
('310094207230003', '2B11MD0062-X', 'HU LIZHI', '2023-08-02', 'triaini', 'tikim'),
('310094207230004', '2B11MD0063-X', 'WU ZHI', '2023-08-02', 'triaini', 'tikim'),
('310094207230010', '2B21MD0104-X', 'CHELSEA LOVIANA MCCALLUM', '2023-08-02', 'triaini', 'tikim'),
('310094207230011', '2C21MD0366-X', 'XIAOGANG MIAO', '2023-08-02', 'triaini', 'tikim'),
('310094207230012', '2C21MD0367-X', 'XIAODONG WANG', '2023-08-02', 'triaini', 'tikim'),
('310094208230001', '2C11MD0098-X', 'MUHAMMAD ZAFAROL SHAH BIN LOKMAN ', '2023-08-02', 'triaini', 'tikim'),
('310094209230003', '2C21MD0371-X', 'CHANHEE JEON', '2023-08-02', 'triaini', 'tikim'),
('310094209230004', '2C21MD0370-X', 'WON GEE KIM', '2023-08-02', 'triaini', 'tikim'),
('310094209230005', '2C21MD0369-X', 'BYEUNGHO NA', '2023-08-02', 'triaini', 'tikim'),
('310094209230007', '2B11MD0061-X', 'WEI SU', '2023-08-02', 'triaini', 'tikim'),
('310094209230015', '2B11MD0065-X', 'YANG DEMENG', '2023-08-02', 'triaini', 'tikim');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `nip` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `posisi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`nip`, `nama`, `password`, `status`, `posisi`) VALUES
('197606112003121005', 'Ali Husni', '5f4dcc3b5aa765d61d8327deb882cf99', 'aktif', 'tikim'),
('198007022010121001', 'FIRMAN MUCHLISIN', '5f4dcc3b5aa765d61d8327deb882cf99', 'aktif', 'tikim'),
('198312092003121001', 'Adrian Soetrisno', '5f4dcc3b5aa765d61d8327deb882cf99', 'aktif', 'tikim'),
('198508052003121001', 'Ibram Heriko', '5f4dcc3b5aa765d61d8327deb882cf99', 'aktif', 'tikim'),
('198609112009121007', 'Beny Septada', '5f4dcc3b5aa765d61d8327deb882cf99', 'tidak aktif', 'tikim'),
('198905092017121001', 'Yudha Kumaladiantara', '5f4dcc3b5aa765d61d8327deb882cf99', 'aktif', 'tikim'),
('198907212017121001', 'Anggie Dhonny Purnama', '5f4dcc3b5aa765d61d8327deb882cf99', 'aktif', 'tikim'),
('199211302017121001', 'ADAM LISTYANTO', '5f4dcc3b5aa765d61d8327deb882cf99', 'aktif', 'tikim'),
('199909162019011001', 'HABIL ASHARI', '5f4dcc3b5aa765d61d8327deb882cf99', 'aktif', 'tikim'),
('bharki', 'Abdul Bharki Fahlevi', '5f4dcc3b5aa765d61d8327deb882cf99', 'aktif', 'inteldakim'),
('david', 'David Nur', '5f4dcc3b5aa765d61d8327deb882cf99', 'Aktif', 'tikim'),
('triaini', 'Tri Aini Novitasari', '5f4dcc3b5aa765d61d8327deb882cf99', 'aktif', 'tikim');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arsipterkirim`
--
ALTER TABLE `arsipterkirim`
  ADD PRIMARY KEY (`nomor_permohonan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
