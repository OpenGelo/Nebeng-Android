-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 08, 2013 at 04:06 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `iot`
--

-- --------------------------------------------------------

--
-- Table structure for table `beri_tebengan`
--

CREATE TABLE IF NOT EXISTS `beri_tebengan` (
  `id_tebengan` int(11) NOT NULL,
  `npm` varchar(11) collate utf8_unicode_ci NOT NULL,
  `nama` varchar(20) collate utf8_unicode_ci NOT NULL,
  `asal` text collate utf8_unicode_ci NOT NULL,
  `tujuan` text collate utf8_unicode_ci NOT NULL,
  `kapasitas` smallint(6) NOT NULL,
  `waktu_berangkat` datetime default NULL,
  PRIMARY KEY  (`npm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `beri_tebengan`
--


-- --------------------------------------------------------

--
-- Table structure for table `konfirmasi_pemberi`
--

CREATE TABLE IF NOT EXISTS `konfirmasi_pemberi` (
  `npm_penebeng` varchar(11) collate utf8_unicode_ci NOT NULL,
  `nama_penebeng` varchar(11) collate utf8_unicode_ci NOT NULL,
  `asal` text collate utf8_unicode_ci NOT NULL,
  `tujuan` text collate utf8_unicode_ci NOT NULL,
  `waktu_berangkat` datetime NOT NULL,
  `konfirmasi` smallint(1) default NULL,
  `waktu_konfirmasi` datetime NOT NULL,
  PRIMARY KEY  (`npm_penebeng`),
  KEY `nama_penebeng` (`nama_penebeng`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `konfirmasi_pemberi`
--


-- --------------------------------------------------------

--
-- Table structure for table `konfirmasi_penebeng`
--

CREATE TABLE IF NOT EXISTS `konfirmasi_penebeng` (
  `npm_pemberi` varchar(11) collate utf8_unicode_ci NOT NULL,
  `nama_pemberi` varchar(20) collate utf8_unicode_ci NOT NULL,
  `asal` text collate utf8_unicode_ci NOT NULL,
  `tujuan` text collate utf8_unicode_ci NOT NULL,
  `waktu_berangkat` datetime NOT NULL,
  `waktu_konfirmasi` datetime NOT NULL,
  PRIMARY KEY  (`npm_pemberi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `konfirmasi_penebeng`
--


-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `session_id` int(11) NOT NULL,
  `npm` varchar(11) collate utf8_unicode_ci NOT NULL,
  `last_login` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`npm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `login`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `npm` varchar(11) collate utf8_unicode_ci NOT NULL,
  `username` varchar(20) collate utf8_unicode_ci NOT NULL,
  `password` text collate utf8_unicode_ci NOT NULL,
  `nama` text collate utf8_unicode_ci NOT NULL,
  `jenis_kelamin` varchar(1) collate utf8_unicode_ci NOT NULL,
  `alamat` text collate utf8_unicode_ci NOT NULL,
  `email` text collate utf8_unicode_ci NOT NULL,
  `kendaraan` text collate utf8_unicode_ci NOT NULL,
  `no_hp` text collate utf8_unicode_ci NOT NULL,
  `no_telp` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`npm`),
  KEY `id` (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `beri_tebengan`
--
ALTER TABLE `beri_tebengan`
  ADD CONSTRAINT `beri_tebengan_ibfk_1` FOREIGN KEY (`npm`) REFERENCES `user` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `konfirmasi_pemberi`
--
ALTER TABLE `konfirmasi_pemberi`
  ADD CONSTRAINT `konfirmasi_pemberi_ibfk_1` FOREIGN KEY (`npm_penebeng`) REFERENCES `user` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `konfirmasi_penebeng`
--
ALTER TABLE `konfirmasi_penebeng`
  ADD CONSTRAINT `konfirmasi_penebeng_ibfk_1` FOREIGN KEY (`npm_pemberi`) REFERENCES `user` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `FK_login` FOREIGN KEY (`npm`) REFERENCES `user` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_pemberi` FOREIGN KEY (`npm`) REFERENCES `user` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;
