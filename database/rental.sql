-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2024 at 06:22 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `pass` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `email`, `pass`) VALUES
(1, 'Andrean', 'admin123@gmail.com', 'admin');

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
('3-00', 'Modal'),
('4-01', 'Pendapatan Sewa'),
('5-01', 'Beban Gaji'),
('5-02', 'Beban Service');

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
(4, 'Daihatsu');

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
  `jumlah_set` varchar(10) NOT NULL,
  `harga` int(11) NOT NULL,
  `id_merek` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `nama`, `warna`, `no_polisi`, `jenis_sewa`, `jumlah_set`, `harga`, `id_merek`) VALUES
(1, 'Innova Rebon', 'Putih', 'AB 354 BA', 'Lepas Kunci', '8', 850000, 2),
(2, 'Terios', 'Merah', 'B 4950 DC', 'Lepas Kunci', '6', 450000, 4),
(3, 'Jazz', 'Silver', 'K 4803 CG', 'Lepas Kunci', '4', 300000, 1),
(4, 'Hiace Premio ', 'Silver', 'B 154 PC', 'Paket Lengkap', '10', 1400000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `operasional`
--

CREATE TABLE `operasional` (
  `id_operasional` int(2) NOT NULL,
  `id_akun` varchar(5) NOT NULL,
  `nama_operasional` varchar(20) NOT NULL,
  `tanggal_operasional` date NOT NULL,
  `harga` int(8) NOT NULL,
  `kuantitas` int(2) NOT NULL,
  `total_operasional` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `operasional`
--

INSERT INTO `operasional` (`id_operasional`, `id_akun`, `nama_operasional`, `tanggal_operasional`, `harga`, `kuantitas`, `total_operasional`) VALUES
(501, '5-011', 'Biaya Service', '2024-05-29', 1750000, 2, 3500000),
(5, '5-02', 'Biaya Service ', '2024-05-29', 3000000, 1, 3000000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `no_pelanggan` int(2) NOT NULL,
  `nama` varchar(15) NOT NULL,
  `alamat` varchar(20) NOT NULL,
  `no_hp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`no_pelanggan`, `nama`, `alamat`, `no_hp`) VALUES
(1, 'Azka', 'Jl. Paris, Bantul', '089603077352'),
(2, 'Zidny', 'Jl Samas, Bantul', '085432167891'),
(3, 'Elang ', 'Jl. Kaliurang', '0816030773511'),
(4, 'Kirana', 'Jl Seyegan, Sleman', '087762514245');

-- --------------------------------------------------------

--
-- Table structure for table `pendapatan_sewa`
--

CREATE TABLE `pendapatan_sewa` (
  `id_pendapatan` varchar(5) NOT NULL,
  `id_akun` varchar(5) NOT NULL,
  `no_pelanggan` int(2) NOT NULL,
  `id_sewa` int(2) NOT NULL,
  `nama_pendapatan` varchar(20) NOT NULL,
  `tgl_pendapatan` date NOT NULL,
  `jumlah_pendapatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendapatan_sewa`
--

INSERT INTO `pendapatan_sewa` (`id_pendapatan`, `id_akun`, `no_pelanggan`, `id_sewa`, `nama_pendapatan`, `tgl_pendapatan`, `jumlah_pendapatan`) VALUES
('21', '4', 2, 2, 'Pendapatan Sewa', '2024-05-29', 1540000),
('22', '4', 1, 1, 'Pendapatan Sewa', '2024-05-27', 850000),
('0', '4', 3, 1, 'Pendapatan Sewa', '2024-05-29', 750000),
('0', '4-01', 1, 1, 'Pendapatan Sewa', '2024-05-27', 850000),
('2', '4', 2, 2, 'Pendapatan Sewa', '2024-05-29', 1540000);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` varchar(4) NOT NULL,
  `nama` varchar(15) NOT NULL,
  `jabatan` varchar(10) NOT NULL,
  `alamat` varchar(20) NOT NULL,
  `umur` int(2) NOT NULL,
  `kontak` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `jabatan`, `alamat`, `umur`, `kontak`) VALUES
('101', 'Reza widya A', 'Pemilik', 'Jl. Bawuran, Pleret', 22, 2147483647),
('201', 'Andreasn', 'B Keuangan', 'Jl. Paris, Bantul', 30, 856782341);

-- --------------------------------------------------------

--
-- Table structure for table `sewa_kendaraan`
--

CREATE TABLE `sewa_kendaraan` (
  `id_sewa` int(2) NOT NULL,
  `tgl_sewa` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `id_mobil` int(2) NOT NULL,
  `no_pelanggan` int(2) NOT NULL,
  `lama_sewa` varchar(8) NOT NULL,
  `harga` int(11) NOT NULL,
  `denda` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sewa_kendaraan`
--

INSERT INTO `sewa_kendaraan` (`id_sewa`, `tgl_sewa`, `tgl_kembali`, `id_mobil`, `no_pelanggan`, `lama_sewa`, `harga`, `denda`, `total_harga`) VALUES
(1, '2024-06-20', '2024-06-21', 2, 3, '72', 100000, 0, 7200000),
(2, '2024-05-27', '2024-05-27', 1, 1, '18 jam', 850000, 85000, 935000),
(3, '2024-05-29', '2024-05-29', 4, 2, '72', 1000000, 140000, 72140000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

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
-- Indexes for table `sewa_kendaraan`
--
ALTER TABLE `sewa_kendaraan`
  ADD PRIMARY KEY (`id_sewa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
