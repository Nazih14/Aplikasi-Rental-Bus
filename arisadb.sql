-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2015 at 02:15 AM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `arisadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `nama_depan` varchar(30) NOT NULL,
  `nama_belakang` varchar(30) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama_depan`, `nama_belakang`, `username`, `password`) VALUES
(1, 'Devin', 'Sebastian Rizky', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE IF NOT EXISTS `berita` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `isi` longtext NOT NULL,
  `tgl_terbit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `penulis` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `isi`, `tgl_terbit`, `penulis`) VALUES
(5, 'Cuci Gudang-Big Sale Bus Harapan Jaya dibawah tahun 2000', '<p style="text-align: justify;">Dijual segera armada-armada Bus Harapan Jaya dibawah tahun 2000. Baik AC maupun NON AC. Kondisi armada sehat dan jalan. Harga bersahabat dan dapat dinego.</p>\r\n\r\n<p><img alt="" src="/poarisa/upload_file/images/2015.jpg" style="height:325px; width:500px" /></p>\r\n\r\n<p style="text-align: justify;">Bagi pembeli yang berminat dapat menghubungi Bapak Bintoro di 0355- 321620/ 321624 pada jam kantor (janjian jadwal lihat armada sesuai jenis bus yang diinginkan calon pembeli). Terima kasih</p>\r\n', '2015-01-05 01:09:56', 'Devin');

-- --------------------------------------------------------

--
-- Table structure for table `daftar_bis`
--

CREATE TABLE IF NOT EXISTS `daftar_bis` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nama_bus` varchar(20) NOT NULL,
  `tipe` enum('Seat A','Seat B') NOT NULL DEFAULT 'Seat A',
  `status` enum('Ada','Berangkat') NOT NULL DEFAULT 'Ada',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama_bis` (`nama_bus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `daftar_bis`
--

INSERT INTO `daftar_bis` (`id`, `nama_bus`, `tipe`, `status`) VALUES
(1, 'Arisa A1', 'Seat A', 'Berangkat'),
(2, 'Arisa A2', 'Seat A', 'Berangkat'),
(3, 'Arisa A3', 'Seat A', 'Ada'),
(4, 'Arisa B1', 'Seat B', 'Ada'),
(5, 'Arisa B2', 'Seat B', 'Ada'),
(6, 'Arisa B3', 'Seat B', 'Ada');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE IF NOT EXISTS `galeri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `nama_gambar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `harga_sewa`
--

CREATE TABLE IF NOT EXISTS `harga_sewa` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `tujuan` text NOT NULL,
  `lama` int(2) NOT NULL,
  `seat_a` int(8) NOT NULL DEFAULT '0',
  `seat_b` int(8) NOT NULL DEFAULT '0',
  `kategori` enum('Paket','NB') NOT NULL DEFAULT 'Paket',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `harga_sewa`
--

INSERT INTO `harga_sewa` (`id`, `tujuan`, `lama`, `seat_a`, `seat_b`, `kategori`) VALUES
(1, 'Jakarta', 2, 6500000, 4750000, 'Paket'),
(2, 'Bandung/Bogor', 2, 6500000, 5500000, 'Paket'),
(3, 'Bandung/Jakarta', 2, 7500000, 6500000, 'Paket'),
(4, 'Malang', 2, 8000000, 7000000, 'Paket'),
(5, 'Ziarah 9 Wali', 2, 12500000, 11000000, 'Paket'),
(6, 'Jogjakarta', 2, 4500000, 4000000, 'Paket'),
(7, 'Bali', 2, 15000000, 12500000, 'Paket'),
(8, 'Semarang', 1, 2700000, 2500000, 'Paket'),
(9, 'Lombok', 2, 17500000, 15000000, 'Paket'),
(10, 'Madura', 2, 10000000, 9000000, 'Paket'),
(11, 'Overtime', 2, 250000, 250000, 'NB');

-- --------------------------------------------------------

--
-- Table structure for table `info_rekening`
--

CREATE TABLE IF NOT EXISTS `info_rekening` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `no_rek` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `info_rekening`
--

INSERT INTO `info_rekening` (`id`, `nama`, `bank`, `no_rek`) VALUES
(1, 'Devin Sebastian Rizky', 'BRI', '054901004649000');

-- --------------------------------------------------------

--
-- Table structure for table `konfirmasi_order`
--

CREATE TABLE IF NOT EXISTS `konfirmasi_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kode_order` varchar(10) NOT NULL,
  `jml_transfer` int(8) NOT NULL,
  `bank` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `no_rek` int(20) NOT NULL,
  `ke_rek` varchar(50) NOT NULL,
  `tgl_konfirmasi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_pemesanan` (`kode_order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `konfirmasi_order`
--

INSERT INTO `konfirmasi_order` (`id`, `kode_order`, `jml_transfer`, `bank`, `nama`, `no_rek`, `ke_rek`, `tgl_konfirmasi`) VALUES
(1, '1', 700000000, 'BRI', 'Arya Wiguna', 2147483647, 'BRI', '2014-11-03 11:26:16');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE IF NOT EXISTS `kontak` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `alamat` text NOT NULL,
  `tlp` varchar(12) NOT NULL,
  `sms` varchar(12) NOT NULL,
  `email` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id`, `alamat`, `tlp`, `sms`, `email`) VALUES
(1, 'Jl. Raya Ketandan Wiradesa Pekalongan', '089667177000', '085642811000', 'poarisa@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `konten`
--

CREATE TABLE IF NOT EXISTS `konten` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `isi` longtext NOT NULL,
  `kategori` enum('utama','cara') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `konten`
--

INSERT INTO `konten` (`id`, `judul`, `isi`, `kategori`) VALUES
(1, 'Selamat Datang di Website PO. Arisa Pekalongan', '<p><img alt="" src="/poarisa/upload_file/images/g_testimoni.png" style="height:300px; width:600px" /></p>\r\n\r\n<p style="text-align:justify">&nbsp;</p>\r\n\r\n<div style="font-family: sans-serif, Arial, Verdana, ''Trebuchet MS''; font-size: 13px; color: rgb(51, 51, 51); background-color: rgb(255, 255, 255); margin-top: 20px; margin-right: 20px; margin-bottom: 20px; margin-left: 20px; line-height: 1.6; cursor: text; ">\r\n<p style="text-align:justify">PO. Arisa pekalongan.</p>\r\n\r\n<p style="text-align:justify">PO. Arisa adalah sebuah pelayanan jasa yang bergerak dibidang penyewaan bus wisata. PO. Arisa ini beralamatkan di Jl. Raya Ketandan Wiradesa Pekalongan.</p>\r\n\r\n<p style="text-align:justify">Perusaahaan ini dikelola oleh Bpk. H. Wihanoto yang sudah berdiri selama 7 tahun ini menjadi salah satu pelayanan jasa yang mementingkan pelayanan yang lebih baik.</p>\r\n\r\n<p style="text-align:justify">Contact center : 087710103274</p>\r\n\r\n<div>&nbsp;</div>\r\n</div>\r\n', 'utama'),
(2, 'Cara Pemesanan Bus', '<p style="text-align:justify">Cara untuk memesan PO. Arisa Pekalongan</p>\r\n\r\n<p style="text-align:justify">1. Masukan kode order sesuai dengan nama bus di form harga sewa</p>\r\n\r\n<p style="text-align:justify">2. Masukan nama BANK pemesan sesuai dengan yang ditentukan</p>\r\n\r\n<p style="text-align:justify">3. Masukan BANK dengan atas nama pemilik yang sesuai</p>\r\n\r\n<p style="text-align:justify">4. Masukan jumlah tunai nominal biaya harga sesuai dengan ketentuan</p>\r\n\r\n<p style="text-align:justify">5. Konfirmasi dengan memilih tombol selesai</p>\r\n\r\n<p style="text-align:justify">Isikan Formulir Pendaftaraan :</p>\r\n\r\n<p style="text-align:justify">1. Masukan Nama lengkap sesuai formulir</p>\r\n\r\n<p style="text-align:justify">2. Masukan Alamat pemesan</p>\r\n\r\n<p style="text-align:justify">3. Masukan nomer telephone pemesan</p>\r\n\r\n<p style="text-align:justify">4. Pilih tujuan wisata</p>\r\n\r\n<p style="text-align:justify">5. Pilih jumlah kursi seat</p>\r\n\r\n<p style="text-align:justify">6. Pilih Tanggal pemberangkatan</p>\r\n\r\n<p style="text-align:justify">7. Masukan Lama perjalanan yang akan dipesan</p>\r\n\r\n<p style="text-align:justify">8. Pilih selesai.</p>\r\n', 'cara');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_order`
--

CREATE TABLE IF NOT EXISTS `laporan_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kode_order` int(10) NOT NULL,
  `overtime` int(1) NOT NULL,
  `biaya_overtime` int(8) NOT NULL,
  `total` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kode_order` int(10) NOT NULL,
  `tgl_order` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pemesan` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `tlp` varchar(12) NOT NULL,
  `tujuan` varchar(30) NOT NULL,
  `jml_bus_a` int(2) NOT NULL DEFAULT '0',
  `jml_bus_b` int(2) NOT NULL DEFAULT '0',
  `tgl_berangkat` date NOT NULL,
  `lama_pjln` int(2) NOT NULL DEFAULT '0',
  `total_biaya` int(12) DEFAULT '0',
  `konfirmasi` enum('Sudah','Belum') NOT NULL DEFAULT 'Belum',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_pemesanan` (`kode_order`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `kode_order`, `tgl_order`, `pemesan`, `alamat`, `tlp`, `tujuan`, `jml_bus_a`, `jml_bus_b`, `tgl_berangkat`, `lama_pjln`, `total_biaya`, `konfirmasi`) VALUES
(1, 1, '2014-04-29 04:10:26', 'Arya Wiguna', 'Jln. Merak, Rt. 20/07 No.23, Bojong, Pekalongan', '089667177000', 'Bandung/Bogor', 2, 1, '2014-06-12', 5, 700000000, 'Sudah');

-- --------------------------------------------------------

--
-- Table structure for table `profil_po`
--

CREATE TABLE IF NOT EXISTS `profil_po` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `isi` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `profil_po`
--

INSERT INTO `profil_po` (`id`, `judul`, `isi`) VALUES
(1, 'PO. Arisa Pekalongan', '<p style="text-align:justify">PO. Arisa pekalongan.</p>\r\n\r\n<p style="text-align:justify">PO. Arisa adalah sebuah pelayanan jasa yang bergerak dibidang penyewaan bus wisata. PO. Arisa ini beralamatkan di Jl. Raya Ketandan Wiradesa Pekalongan.</p>\r\n\r\n<p style="text-align:justify">Perusaahaan ini dikelola oleh Bpk. H. Wihanoto yang sudah berdiri selama 7 tahun ini menjadi salah satu pelayanan jasa yang mementingkan pelayanan yang lebih baik.</p>\r\n\r\n<p style="text-align:justify">Contact center : 087710103274</p>\r\n\r\n<p style="text-align:justify">&nbsp;</p>\r\n');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
