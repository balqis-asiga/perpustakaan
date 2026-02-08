-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2026 at 07:10 PM
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
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_admin`) VALUES
(1, 'admin', 'admin123', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nis`, `nama`, `kelas`, `username`, `password`) VALUES
(63, '23011665', 'ADRIYAN PUTRA ARIYANTO', 'XII PPLG A', 'adriyan', '123'),
(64, '23011666', 'AFAN BILAL MAULANA', 'XII PPLG A', 'afan', '123'),
(65, '23011667', 'AINA HANIN ASSYIFA', 'XII PPLG A', 'aina', '123'),
(66, '23011668', 'ANDHIKA PRADANA', 'XII PPLG A', 'andhika', '123'),
(67, '23011669', 'ARFAN HAQIQI BAIHAQI', 'XII PPLG A', 'arfan', '123'),
(68, '23011670', 'BALQIS ASIGA ROIHANAH', 'XII PPLG A', 'balqis', '123'),
(69, '23011671', 'BILAL ATHA HIDAYAT', 'XII PPLG A', 'bilal', '123'),
(70, '23011672', 'CALYA ATMA AURYN', 'XII PPLG A', 'calya', '123'),
(71, '23011673', 'CLAUDIA PUTRI ADILA', 'XII PPLG A', 'claudia', '123'),
(72, '23011674', 'DHAFID WAHYU KUSUMO', 'XII PPLG A', 'dhafid', '123'),
(73, '24022001', 'RANGGA PRATAMA', 'XI TJKT A', 'rangga', '123'),
(74, '24022002', 'SALSABILA PUTRI', 'XI TJKT A', 'salsa', '123'),
(75, '24022003', 'DANIEL ARYA', 'XI TJKT B', 'daniel', '123'),
(76, '24022004', 'NADIA AZZAHRA', 'XI TJKT B', 'nadia', '123'),
(77, '24022005', 'FIKRI RAMADHAN', 'XI TJKT C', 'fikri', '123'),
(78, '25033001', 'ALDI SAPUTRA', 'X TE A', 'aldi', '123'),
(79, '25033002', 'PUTRI MAHARANI', 'X TE A', 'putri', '123'),
(80, '25044001', 'BIMA YUDHA', 'X DPIB', 'bima', '123'),
(81, '25044002', 'RANIA LESTARI', 'X DPIB', 'rania', '123'),
(82, '25055001', 'FAJAR MAULANA', 'XI GEO', 'fajar', '123'),
(83, '25055002', 'TIARA ANGGRAENI', 'XI GEO', 'tiara', '123'),
(84, '25066001', 'RIDHO AKBAR', 'XII TKL', 'ridho', '123'),
(85, '25066002', 'MEISYA KAMILA', 'XII TKL', 'meisya', '123'),
(86, '25077001', 'RAKA WIJAYA', 'XI TM', 'raka', '123'),
(87, '25077002', 'NURUL HIKMAH', 'XI TM', 'nurul', '123'),
(88, '25088001', 'YUSUF PRATAMA', 'X TO', 'yusuf', '123'),
(89, '25088002', 'NISA AMALIA', 'X TO', 'nisa', '123'),
(90, '25099001', 'IQBAL FIRDAUS', 'XI TJKT C', 'iqbal', '123'),
(91, '25099002', 'ZAHRA HANIFA', 'XI TJKT C', 'zahra', '123'),
(92, '25100001', 'ALYA PUTRI', 'XII PPLG B', 'alya', '123'),
(93, '25100002', 'RIFKI HAKIM', 'XII PPLG B', 'rifki', '123');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `stok` int(11) NOT NULL,
  `isbn` varchar(30) DEFAULT NULL,
  `rak` varchar(20) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `stok`, `isbn`, `rak`, `deskripsi`, `id_kategori`) VALUES
(1, 'Matematika', 'Balqis', 'PT Jaya Selalu', '2026', 22, '9789791227009', 'A4', '', 3),
(2, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang', '2005', 5, '9789791227002', 'A1', 'Novel inspiratif tentang anak-anak Belitung.', 1),
(3, 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', '1980', 3, '9789799731001', 'A2', 'Novel sejarah perjuangan bangsa Indonesia.', 1),
(4, 'Atomic Habits', 'James Clear', 'Gramedia', '2018', 4, '9786020633176', 'B1', 'Buku pengembangan diri tentang kebiasaan kecil.', 2),
(5, 'Sapiens', 'Yuval Noah Harari', 'KPG', '2014', 2, '9786024244164', 'B2', 'Sejarah singkat umat manusia.', 2),
(6, 'Matematika Kelas X', 'Sukino', 'Erlangga', '2020', 7, '9789790994567', 'C1', 'Buku pelajaran matematika SMA.', 3),
(7, 'Bahasa Indonesia Kelas XI', 'Kemendikbud', 'Kemendikbud', '2021', 6, '9786024270005', 'C2', 'Materi resmi bahasa Indonesia kelas XI.', 3),
(8, 'Fisika Dasar', 'Halliday', 'Erlangga', '2010', 5, '9789790991234', 'C3', 'Konsep fisika dasar untuk siswa.', 3),
(9, 'Pemrograman Web PHP', 'Budi Raharjo', 'Informatika', '2019', 4, '9786021514993', 'D1', 'Panduan membangun website dengan PHP.', 4),
(10, 'Dasar IoT ESP32', 'Andi Publisher', 'Andi', '2022', 3, '9786020456789', 'D2', 'Belajar Internet of Things menggunakan ESP32.', 4),
(11, 'Teknologi AI Modern', 'Open Edu', 'TechPress', '2023', 2, '9786029998888', 'D3', 'Pengantar Artificial Intelligence masa kini.', 4);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Fiksi'),
(2, 'Non Fiksi'),
(3, 'Pelajaran'),
(4, 'Teknologi');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan','Terlambat') NOT NULL,
  `tanggal_harus_kembali` date DEFAULT NULL,
  `denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `fk_buku_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_transaksi_anggota` (`id_anggota`),
  ADD KEY `fk_transaksi_buku` (`id_buku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `fk_buku_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksi_buku` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
