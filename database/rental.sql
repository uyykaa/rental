-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2024 at 02:16 PM
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
-- Database: `rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori_akun`
--

CREATE TABLE `kategori_akun` (
  `id_akun` varchar(5) NOT NULL,
  `nama_akun` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_akun`
--

INSERT INTO `kategori_akun` (`id_akun`, `nama_akun`) VALUES
('4-01', 'Pendapatan Sewa'),
('5-02', 'Beban Gaji'),
('5-03', 'Beban Service'),
('6-01', 'Lain-lain');

-- --------------------------------------------------------

--
-- Table structure for table `merek`
--

CREATE TABLE `merek` (
  `id_merek` int(2) NOT NULL,
  `merek` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merek`
--

INSERT INTO `merek` (`id_merek`, `merek`) VALUES
(1, 'Honda'),
(2, 'Toyota'),
(3, 'Suzuki'),
(4, 'Daihatsu'),
(5, 'kiaa');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int(2) NOT NULL,
  `nama` varchar(15) NOT NULL,
  `warna` varchar(10) NOT NULL,
  `no_polisi` varchar(10) NOT NULL,
  `jenis_sewa` varchar(15) NOT NULL,
  `lama_sewa` varchar(8) NOT NULL,
  `jumlah_set` varchar(10) NOT NULL,
  `harga` int(11) NOT NULL,
  `id_merek` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `nama`, `warna`, `no_polisi`, `jenis_sewa`, `lama_sewa`, `jumlah_set`, `harga`, `id_merek`) VALUES
(1, 'Hiace Premio', 'Silver', 'K 4803 TO', 'Paket Lengkap', '18', '14', 1400000, 1),
(2, 'Brio', 'Hitam', 'AB 4950 QJ', 'Lepas Kunci', '12', '6', 350000, 1),
(3, 'Brio', 'Hitam', 'AB 4950 QJ', 'Paket Lengkap', '18', '6', 450000, 1),
(4, 'pregio', 'Silver', 'AD 555 DC', 'Lepas Kunci', '12', '8', 1000, 5),
(5, 'pregio', 'Silver', 'AD 555 DC', 'Paket Lengkap', '18', '8', 1200, 5),
(39, 'Grand New Xenia', 'Putih', 'B 1829 IM', 'Lepas Kunci', '18', '8', 300000, 4);

-- --------------------------------------------------------

--
-- Table structure for table `operasional`
--

CREATE TABLE `operasional` (
  `id_operasional` int(4) NOT NULL,
  `id_akun` varchar(5) NOT NULL,
  `nama_operasional` varchar(20) NOT NULL,
  `tanggal_operasional` date NOT NULL,
  `harga` int(11) NOT NULL,
  `kuantitas` int(2) NOT NULL,
  `total_operasional` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `operasional`
--

INSERT INTO `operasional` (`id_operasional`, `id_akun`, `nama_operasional`, `tanggal_operasional`, `harga`, `kuantitas`, `total_operasional`) VALUES
(501, '5-01', 'Biaya Gaji', '2024-06-05', 40000, 2, 80000),
(502, '5-02', 'Bayar Servic bulanan', '2024-05-29', 1750000, 1, 1750000),
(503, '6-01', 'Biaya Tidak Terduga', '2024-06-30', 50000, 3, 150000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `no_pelanggan` int(2) NOT NULL,
  `nama` varchar(15) NOT NULL,
  `alamat` varchar(20) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`no_pelanggan`, `nama`, `alamat`, `no_hp`, `img`) VALUES
(1, 'Azka', 'Jl. Paris, Bantul', '089603077352', 'fauna.jpg'),
(2, 'Zidny', 'Jl Samas, Bantul', '085432167891', 'pbdd1.jpeg'),
(3, 'Elang ', 'Jl. Kaliurang', '0816030773511', 'Diagram11.jpeg'),
(4, 'Kirana', 'Jl Seyegan, Sleman', '087762514245', 'WIN_20230330_08_08_09_Pro.jpg'),
(5, 'alo', 'sleman', '081', 'ss3.png'),
(11, 'Rio', 'Pleret Bantul', '09877564', 'ss4.png');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `no_bayar` int(2) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `uang_muka` int(11) NOT NULL,
  `denda` int(11) NOT NULL,
  `id_sewa` int(11) NOT NULL,
  `no_pelanggan` varchar(15) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendapatan_sewa`
--

CREATE TABLE `pendapatan_sewa` (
  `id_pendapatan` int(4) NOT NULL,
  `id_akun` varchar(15) NOT NULL,
  `no_pelanggan` varchar(4) NOT NULL,
  `id_sewa` int(2) NOT NULL,
  `nama_pendapatan` varchar(20) NOT NULL,
  `tgl_pendapatan` date NOT NULL,
  `jumlah_pendapatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendapatan_sewa`
--

INSERT INTO `pendapatan_sewa` (`id_pendapatan`, `id_akun`, `no_pelanggan`, `id_sewa`, `nama_pendapatan`, `tgl_pendapatan`, `jumlah_pendapatan`) VALUES
(401, '4-01', '2', 1, 'Pendapatan Sewa', '2024-06-06', 1540000),
(402, '4-01', '3', 3, 'Pendapatan Sewa', '2024-06-21', 500000),
(411, '4-01', '4', 3, 'Pendapatan Sewa', '2024-07-02', 350000),
(412, '4-01', '7', 22, 'Pendapatan Sewa', '2024-07-03', 7000),
(413, '4-01', '5', 23, 'Pendapatan Sewa', '2024-07-03', 2000),
(414, '4-01', '1', 29, 'Pendapatan Sewa', '2024-07-04', 300000);

-- --------------------------------------------------------

--
-- Table structure for table `sewa_kendaraan`
--

CREATE TABLE `sewa_kendaraan` (
  `id_sewa` int(2) NOT NULL,
  `tgl_sewa` date NOT NULL,
  `id_mobil` varchar(4) NOT NULL,
  `no_pelanggan` varchar(4) NOT NULL,
  `jenis_sewa` varchar(15) NOT NULL,
  `lama_sewa` varchar(8) NOT NULL,
  `harga` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sewa_kendaraan`
--

INSERT INTO `sewa_kendaraan` (`id_sewa`, `tgl_sewa`, `id_mobil`, `no_pelanggan`, `jenis_sewa`, `lama_sewa`, `harga`, `total_harga`, `status`) VALUES
(1, '2024-07-02', '1', '2', 'Lepas Kunci', '48', 1400000, 2800000, 1),
(2, '2024-06-20', '2', '3', 'Lepas Kunci', '18', 350000, 350000, 1),
(3, '2024-07-01', '3', '4', 'Paket Lengkap', '72', 450000, 1350000, 1),
(4, '2024-07-03', '4', '5', 'Lepas Kunci', '48', 1000, 2000, 1),
(29, '2024-07-04', '39', '1', 'Lepas Kunci', '24', 300000, 300000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` varchar(25) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role_id` varchar(2) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `no_hp`, `alamat`, `jabatan`, `email`, `password`, `role_id`, `status`) VALUES
(1, 'Bagian Keuangan', '08123155123', 'Bawuran', 'Admin', 'admin123@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '1', 1),
(2, 'Pemilik', '08903077352', 'Bawuran', 'Pemilik', 'pemilik@gmail.com', '58399557dae3c60e23c78606771dfa3d', '', 1),
(3, 'IIS', '081231415689', 'jl. sambisari wkejqwkjrkh', 'karyawan', 'iiskaryawan@gmail.com', 'b19fb11bd01b65832169fd0a44b36ba9', '3', 0),
(4, 'Karyawan', '081092155234', 'Jl. segoroyoso', 'karyawan', 'karyawan@gmail.com', '9e014682c94e0f2cc834bf7348bda428', '3', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori_akun`
--
ALTER TABLE `kategori_akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `merek`
--
ALTER TABLE `merek`
  ADD PRIMARY KEY (`id_merek`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indexes for table `operasional`
--
ALTER TABLE `operasional`
  ADD PRIMARY KEY (`id_operasional`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`no_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`no_bayar`),
  ADD UNIQUE KEY `id_sewa` (`id_sewa`);

--
-- Indexes for table `pendapatan_sewa`
--
ALTER TABLE `pendapatan_sewa`
  ADD PRIMARY KEY (`id_pendapatan`);

--
-- Indexes for table `sewa_kendaraan`
--
ALTER TABLE `sewa_kendaraan`
  ADD PRIMARY KEY (`id_sewa`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `merek`
--
ALTER TABLE `merek`
  MODIFY `id_merek` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `no_pelanggan` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `no_bayar` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendapatan_sewa`
--
ALTER TABLE `pendapatan_sewa`
  MODIFY `id_pendapatan` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=415;

--
-- AUTO_INCREMENT for table `sewa_kendaraan`
--
ALTER TABLE `sewa_kendaraan`
  MODIFY `id_sewa` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
