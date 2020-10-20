-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2020 at 11:04 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan_barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$KKkBGwn5HN36JO7idVtneOOlugumXV56OmSyc5SnoP5O/JdAYJWuu');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(128) NOT NULL,
  `nama_barang` varchar(256) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(128) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `nama_barang`, `harga`, `stok`, `gambar`, `aktif`) VALUES
(213, 'cabe', 'cabe', 12000, 45, 'cabe.png', 1),
(214, 'gula', 'gula', 5000, 0, '019958400_1486368597-Gula2.jpg', 1),
(215, 'garam', 'garam', 3000, 0, 'garam.jpg', 1),
(216, 'kopi', 'kopi abc', 2000, 41, 'kopi.jpg', 1),
(217, 'teh', 'teh', 5000, 6, 'teh.jpg', 1),
(224, '111', 'ketan', 8000, 80, 'Resep-Ketan-Serundeng.jpg', 1),
(225, '1233', 'rokok', 16000, 10, 'magnum_mild_biru.jpg', 1),
(226, '434', 'gula merah', 121, 12, 'gula-aren.jpg', 1),
(227, '12345', 'cabe pedas', 9000, 10, 'cabe.png', 1),
(228, '1234das', 'asas', 1212, 121, 'kopi.jpg', 1),
(229, '67', 'ererer', 2424, 132, 'garam.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chart`
--

CREATE TABLE `chart` (
  `id_chart` int(11) NOT NULL,
  `tahun` varchar(128) NOT NULL,
  `bulan` varchar(128) NOT NULL,
  `penjualan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chart`
--

INSERT INTO `chart` (`id_chart`, `tahun`, `bulan`, `penjualan`) VALUES
(6, '2018', 'January', '300000'),
(7, '2018', 'February', '250000'),
(8, '2018', 'March', '500000'),
(9, '2018', 'April', '300000'),
(10, '2018', 'May', '350000'),
(11, '2018', 'June', '250000'),
(12, '2018', 'July', '150000'),
(13, '2018', 'August', '100000'),
(14, '2018', 'September', '400000'),
(15, '2018', 'October', '989000'),
(16, '2018', 'November', '1000000'),
(17, '2018', 'December', '780000'),
(18, '2019', 'June', '968500'),
(19, '2019', 'July', '1323000');

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_penjualan`, `id_barang`, `jumlah`, `harga`) VALUES
(303, 213, 2, 12000),
(303, 216, 1, 2000),
(303, 217, 1, 5000),
(304, 213, 5, 12000),
(306, 213, 2, 12000),
(306, 226, 2, 121),
(306, 224, 2, 8000),
(306, 225, 3, 16000),
(306, 216, 3, 2000),
(306, 217, 2, 5000),
(307, 228, 1, 1212),
(307, 213, 1, 12000),
(307, 227, 1, 9000),
(308, 228, 1, 1212),
(308, 213, 1, 12000),
(309, 228, 1, 1212),
(309, 213, 1, 12000),
(309, 227, 1, 9000),
(310, 228, 1, 1212),
(310, 213, 1, 12000),
(311, 228, 1, 1212),
(311, 227, 3, 9000),
(311, 226, 2, 121);

-- --------------------------------------------------------

--
-- Table structure for table `konfirmasi`
--

CREATE TABLE `konfirmasi` (
  `id_konfimasi` int(11) NOT NULL,
  `id_penjualan` int(12) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `rekening` varchar(50) NOT NULL,
  `jumlah_uang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `konfirmasi`
--

INSERT INTO `konfirmasi` (`id_konfimasi`, `id_penjualan`, `nama`, `rekening`, `jumlah_uang`) VALUES
(1, 303, 'Ilham Bahari', '0808-0909-8989', '31000'),
(2, 304, 'fitri', '1212121212', '60000'),
(3, 304, 'Mahmud', '8989898989', '60000'),
(4, 304, 'bagus', '090909090', '60000'),
(5, 306, 'ilham', '123123123', '104242'),
(6, 307, 'dika', '111111111', '200000'),
(7, 308, 'asasas', '1111', '122121'),
(8, 310, 'Ilham', '123123123', '13212'),
(9, 311, 'iham', '9999999', '28454');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `tanggal_jual` varchar(128) NOT NULL,
  `jam` varchar(128) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `email`, `tanggal_jual`, `jam`, `status`) VALUES
(303, 'ilham@gmail.com', '2020-05-10', '17:30:06', 3),
(304, 'ilham@gmail.com', '2020-05-10', '22:47:12', 3),
(306, 'ilham@gmail.com', '2020-05-16', '20:23:00', 3),
(307, 'ilham@gmail.com', '2020-06-13', '00:50:43', 2),
(308, 'rivan@gmail.com', '2020-06-15', '18:26:17', 3),
(310, 'ilham@gmail.com', '2020-07-01', '00:07:24', 3),
(311, 'ilham@gmail.com', '2020-07-01', '15:27:43', 3);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `sub_nama` varchar(256) NOT NULL,
  `background` varchar(128) NOT NULL,
  `deskripsi` text NOT NULL,
  `kontak` varchar(256) NOT NULL,
  `footer` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `nama`, `sub_nama`, `background`, `deskripsi`, `kontak`, `footer`) VALUES
(1, 'Penjualan Beras', 'Menjual berbagai jenis beras', 'penggilingan.jpg', 'deskripsi', 'kontak', 'nama website');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email`, `nama`, `password`) VALUES
(1, 'ilham@gmail.com', 'Ilham', '$2y$10$929FrqD4aMkYfrT1A8YW7.wdBS7aSTHGEoW./ST2TqFvAPQOuN2Ia');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `chart`
--
ALTER TABLE `chart`
  ADD PRIMARY KEY (`id_chart`);

--
-- Indexes for table `konfirmasi`
--
ALTER TABLE `konfirmasi`
  ADD PRIMARY KEY (`id_konfimasi`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT for table `chart`
--
ALTER TABLE `chart`
  MODIFY `id_chart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `konfirmasi`
--
ALTER TABLE `konfirmasi`
  MODIFY `id_konfimasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=312;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
