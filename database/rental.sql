-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2024 at 06:18 AM
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
-- Table structure for table `harga`
--

CREATE TABLE `harga` (
  `id_harga` int(2) NOT NULL,
  `id_mobil` varchar(15) NOT NULL,
  `jenis_paket` varchar(25) NOT NULL,
  `lama_sewa` int(5) NOT NULL,
  `harga` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `harga`
--

INSERT INTO `harga` (`id_harga`, `id_mobil`, `jenis_paket`, `lama_sewa`, `harga`, `status`) VALUES
(1, '2', 'Lepas Kunci', 12, 250000, 1),
(2, '1', 'Paket Komplit', 18, 1400000, 1),
(6, '6', 'Paket Komplit', 18, 700000, 0),
(7, '4', 'Lepas Kunci', 12, 10000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_akun`
--

CREATE TABLE `kategori_akun` (
  `id_akun` varchar(5) NOT NULL,
  `nama_akun` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_akun`
--

INSERT INTO `kategori_akun` (`id_akun`, `nama_akun`) VALUES
('2-01', 'Utang'),
('3-00', 'Modal'),
('4-01', 'Pendapatan Sewa'),
('5-02', 'Biaya Gaji'),
('5-03', 'Biaya Service'),
('6-01', 'Biaya Lain-lain');

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
  `jumlah_set` varchar(10) NOT NULL,
  `id_merek` int(2) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `nama`, `warna`, `no_polisi`, `jumlah_set`, `id_merek`, `status`) VALUES
(1, 'Hiace Premio', 'Silver', 'K 4803 TO', '14', 1, '1'),
(2, 'Brio', 'Hitam', 'AB 4950 QJ', '5', 1, '0'),
(4, 'pregio', 'Silver', 'AD 555 DC', '8', 5, '0'),
(6, 'Grand New Xenia', 'Silver', 'B 1829 IM', '5', 4, '1');

-- --------------------------------------------------------

--
-- Table structure for table `modal`
--

CREATE TABLE `modal` (
  `id_modal` int(3) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_akun` varchar(20) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modal`
--

INSERT INTO `modal` (`id_modal`, `tanggal`, `nama_akun`, `nominal`) VALUES
(300, '2024-07-01', 'Modal', 1000000);

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
(502, '5-02', 'Biaya Servic', '2024-05-29', 1750000, 1, 1750000),
(503, '6-01', 'Biaya Lain-lain', '2024-06-30', 50000, 3, 150000),
(504, '6-01', 'Biaya Pajak', '2024-07-11', 10000, 3, 30000),
(505, '2-01', 'Utang Usaha', '2024-07-11', 10000, 1, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(2) NOT NULL,
  `nama` varchar(15) NOT NULL,
  `alamat` varchar(20) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `img` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `alamat`, `no_hp`, `img`) VALUES
(1, 'Azka', 'Jl. Paris, Bantul', '089603077352', 'fauna.jpg'),
(2, 'Zidny', 'Jl Samas, Bantul', '085432167891', 'pbdd1.jpeg'),
(3, 'Elang ', 'Jl. Kaliurang', '0816030773511', 'Diagram11.jpeg'),
(4, 'Kirana', 'Jl Seyegan, Sleman', '087762514245', 'ss3.png'),
(5, 'alo', 'sleman', '081', 'ss3.png'),
(12, 'Reza ', 'Jl. Bawuran, Pleret', '0856789123', 'Screenshot (29).png');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `no_bayar` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `uang_muka` int(11) NOT NULL,
  `denda` int(11) NOT NULL,
  `id_sewa` int(11) NOT NULL,
  `no_pelanggan` varchar(15) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `is_sewa_done` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`no_bayar`, `tanggal_bayar`, `uang_muka`, `denda`, `id_sewa`, `no_pelanggan`, `total_bayar`, `is_sewa_done`, `status`) VALUES
(1, '2024-07-15', 200000, 0, 1, '1', 1200000, 1, '1'),
(2, '2024-07-14', 150000, 150000, 2, '3', 350000, 0, '0'),
(3, '2024-07-15', 500000, 500000, 3, '4', 3000, 0, '0'),
(4, '2024-07-16', 100000, 0, 4, '12', 1300000, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `pendapatan_sewa`
--

CREATE TABLE `pendapatan_sewa` (
  `id_pendapatan` int(4) NOT NULL,
  `id_akun` varchar(15) NOT NULL,
  `id_pelanggan` varchar(4) NOT NULL,
  `id_sewa` int(2) NOT NULL,
  `nama_pendapatan` varchar(20) NOT NULL,
  `tgl_pendapatan` date NOT NULL,
  `jumlah_pendapatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendapatan_sewa`
--

INSERT INTO `pendapatan_sewa` (`id_pendapatan`, `id_akun`, `id_pelanggan`, `id_sewa`, `nama_pendapatan`, `tgl_pendapatan`, `jumlah_pendapatan`) VALUES
(6, '4-01', '1', 1, 'Pendapatan Sewa', '2024-07-15', 1200000),
(8, '4-01', '12', 4, 'Pendapatan Sewa', '2024-07-16', 1300000);

-- --------------------------------------------------------

--
-- Table structure for table `sewa_kendaraan`
--

CREATE TABLE `sewa_kendaraan` (
  `id_sewa` int(2) NOT NULL,
  `tgl_sewa` date NOT NULL,
  `id_mobil` varchar(4) NOT NULL,
  `id_pelanggan` varchar(4) NOT NULL,
  `jenis_sewa` varchar(15) NOT NULL,
  `lama_sewa` varchar(8) NOT NULL,
  `harga` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_paid` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sewa_kendaraan`
--

INSERT INTO `sewa_kendaraan` (`id_sewa`, `tgl_sewa`, `id_mobil`, `id_pelanggan`, `jenis_sewa`, `lama_sewa`, `harga`, `total_harga`, `status`, `is_paid`) VALUES
(1, '2024-07-15', '1', '1', '1', '12', 1400000, 1400000, 1, 1),
(2, '2024-07-14', '2', '3', '1', '12', 350000, 350000, 0, 0),
(3, '2024-07-15', '4', '4', '2', '72', 1000, 3000, 0, 0),
(4, '2024-07-16', '1', '12', '2', '12', 1400000, 1400000, 1, 1);

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
(1, 'Bagian Keuangan', '856789123', 'Jl. Samas', 'Admin', 'admin123@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '1', 1),
(2, 'Pemilik', '089603077352', 'Jl. Bantul', 'Pemilik', 'pemilik@gmail.com', '58399557dae3c60e23c78606771dfa3d', '2', 1),
(3, 'IIS', '08954321456', 'Jl. Wonosari', 'karyawan', 'iiskaryawan@gmail.com', '9e014682c94e0f2cc834bf7348bda428', '3', 0),
(4, 'Karyawan', '08765432167', 'Jl. Semar', 'karyawan', 'karyawan@gmail.com', '9e014682c94e0f2cc834bf7348bda428', '3', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `harga`
--
ALTER TABLE `harga`
  ADD PRIMARY KEY (`id_harga`);

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
-- Indexes for table `modal`
--
ALTER TABLE `modal`
  ADD PRIMARY KEY (`id_modal`);

--
-- Indexes for table `operasional`
--
ALTER TABLE `operasional`
  ADD PRIMARY KEY (`id_operasional`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

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
-- AUTO_INCREMENT for table `harga`
--
ALTER TABLE `harga`
  MODIFY `id_harga` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `merek`
--
ALTER TABLE `merek`
  MODIFY `id_merek` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `modal`
--
ALTER TABLE `modal`
  MODIFY `id_modal` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;

--
-- AUTO_INCREMENT for table `operasional`
--
ALTER TABLE `operasional`
  MODIFY `id_operasional` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=506;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `no_bayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pendapatan_sewa`
--
ALTER TABLE `pendapatan_sewa`
  MODIFY `id_pendapatan` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sewa_kendaraan`
--
ALTER TABLE `sewa_kendaraan`
  MODIFY `id_sewa` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
