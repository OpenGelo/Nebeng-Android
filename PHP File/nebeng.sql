-- MySQL dump 10.13  Distrib 5.1.34, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: green_ui_ac_id_iot
-- ------------------------------------------------------
-- Server version	5.1.34-0.dotdeb.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bengkel`
--

DROP TABLE IF EXISTS `bengkel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bengkel` (
  `nama` text NOT NULL,
  `lokasi` text NOT NULL,
  `telp` text NOT NULL,
  `alamat` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bengkel`
--

LOCK TABLES `bengkel` WRITE;
/*!40000 ALTER TABLE `bengkel` DISABLE KEYS */;
INSERT INTO `bengkel` VALUES ('JAR\r\n','Jakarta Pusat\r\n','021-3500777\r\n','Jl. Samanhudi no 17\r\n'),('Fontana\r\n','Jakarta Pusat\r\n','021-6394209\r\n','Jl. Gunung Sahari Raya 12AB\r\n');
/*!40000 ALTER TABLE `bengkel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beri_tebengan`
--

DROP TABLE IF EXISTS `beri_tebengan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beri_tebengan` (
  `user_id` int(11) NOT NULL,
  `id_tebengan` int(11) NOT NULL AUTO_INCREMENT,
  `asal` text COLLATE utf8_unicode_ci NOT NULL,
  `tujuan` text COLLATE utf8_unicode_ci NOT NULL,
  `kapasitas` int(3) NOT NULL,
  `sisa_kapasitas` int(3) DEFAULT NULL,
  `waktu_berangkat` date NOT NULL,
  `jam_berangkat` time NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_tebengan`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `beri_tebengan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beri_tebengan`
--

LOCK TABLES `beri_tebengan` WRITE;
/*!40000 ALTER TABLE `beri_tebengan` DISABLE KEYS */;
INSERT INTO `beri_tebengan` VALUES (12,24,'Kober','Kukusan',2,NULL,'2015-03-19','21:00:00','Tes'),(17,25,'Kukusan','Kukel',1,NULL,'2015-03-19','22:00:00',''),(10,26,'A','B',1,NULL,'2015-03-20','07:00:00',''),(13,27,'B','A',0,0,'2015-03-20','15:00:00',''),(15,28,'C','A',1,1,'2015-03-20','16:00:00',''),(31,29,'A','B',1,1,'2015-03-20','19:00:00',''),(29,34,'FISIP','Jalan Situ Indah No.110, Cimanggis, Indonesia',5,5,'2015-04-22','17:01:00','b');
/*!40000 ALTER TABLE `beri_tebengan` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`green.ui.ac.id`@`localhost`*/ /*!50003 TRIGGER `after_insert_beri_tebengan` AFTER INSERT ON `beri_tebengan` FOR EACH ROW
BEGIN
INSERT INTO log VALUES (NEW.user_id, NEW.id_tebengan,
NEW.asal, NEW.tujuan, NEW.kapasitas, NEW.kapasitas,
NEW.waktu_berangkat, NEW.jam_berangkat, NEW.keterangan, "INSERT", NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`green.ui.ac.id`@`localhost`*/ /*!50003 TRIGGER `after_update_beri_tebengan` AFTER UPDATE ON `beri_tebengan` FOR EACH ROW
BEGIN
INSERT INTO log VALUES (OLD.user_id, OLD.id_tebengan,
OLD.asal, OLD.tujuan, OLD.kapasitas, NEW.sisa_kapasitas,
OLD.waktu_berangkat, OLD.jam_berangkat, OLD.keterangan, "UPDATE", NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`green.ui.ac.id`@`localhost`*/ /*!50003 TRIGGER `after_delete_beri_tebengan` AFTER DELETE ON `beri_tebengan` FOR EACH ROW
BEGIN
INSERT INTO log VALUES (OLD.user_id, OLD.id_tebengan,
OLD.asal, OLD.tujuan, OLD.kapasitas, OLD.sisa_kapasitas,
OLD.waktu_berangkat, OLD.jam_berangkat, OLD.keterangan, "DELETE", NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `cuaca`
--

DROP TABLE IF EXISTS `cuaca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuaca` (
  `lokasi` text NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuaca`
--

LOCK TABLES `cuaca` WRITE;
/*!40000 ALTER TABLE `cuaca` DISABLE KEYS */;
INSERT INTO `cuaca` VALUES ('Depok','Perkiraan Hujan mulai jam 2'),('Bogor','Perkiraan hujan deras mulai jam 3');
/*!40000 ALTER TABLE `cuaca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `user_id` int(11) NOT NULL,
  `id_tebengan` int(11) NOT NULL,
  `asal` text NOT NULL,
  `tujuan` text NOT NULL,
  `kapasitas` int(3) NOT NULL,
  `sisa_kapasitas` int(3) DEFAULT NULL,
  `waktu_berangkat` date NOT NULL,
  `jam_berangkat` time NOT NULL,
  `keterangan` text NOT NULL,
  `query` text NOT NULL,
  `timequery` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (2,5,'X','Y',5,5,'2015-01-26','17:00:00','a','INSERT','2015-01-26 16:31:07'),(2,5,'X','Y',5,5,'2015-01-26','17:00:00','a','UPDATE','2015-01-26 16:40:16'),(1,1,'X','Y',2,NULL,'2015-01-25','18:00:00','test','DELETE','2015-01-28 20:43:43'),(20,3,'FH','Perpusat',3,3,'2015-01-26','16:09:00','','DELETE','2015-01-28 20:43:43'),(2,5,'X','Y',5,5,'2015-01-26','17:00:00','a','DELETE','2015-01-28 20:43:43'),(1,6,'X','Y',1,1,'2015-01-28','23:00:00','test','INSERT','2015-01-28 21:55:22'),(2,7,'Y','X',2,2,'2015-01-28','23:00:00','test1','INSERT','2015-01-28 21:57:49'),(3,8,'A','B',1,1,'2015-01-28','23:30:00','test2','INSERT','2015-01-28 21:58:17'),(1,6,'X','Y',1,1,'2015-01-28','23:00:00','test','DELETE','2015-01-29 14:20:05'),(2,7,'Y','X',2,2,'2015-01-28','23:00:00','test1','DELETE','2015-01-29 14:20:05'),(3,8,'A','B',1,1,'2015-01-28','23:30:00','test2','DELETE','2015-01-29 14:20:05'),(1,9,'X','Y',1,1,'2015-01-29','15:00:00','a','INSERT','2015-01-29 14:26:58'),(1,9,'X','Y',1,1,'2015-01-29','15:00:00','a','DELETE','2015-01-29 14:58:39'),(1,10,'X','Y',1,1,'2015-01-29','16:00:00','test','INSERT','2015-01-29 14:59:25'),(4,11,'Vokasi','FMIPA',4,4,'2015-02-24','22:01:00','','INSERT','2015-02-24 21:53:07'),(4,11,'Vokasi','FMIPA',4,4,'2015-02-24','22:01:00','','DELETE','2015-02-25 08:53:04'),(4,12,'FT','Fasilkom',4,4,'2015-02-25','10:00:00','','INSERT','2015-02-25 08:54:12'),(4,12,'FT','Fasilkom',4,4,'2015-02-25','10:00:00','','DELETE','2015-02-25 08:54:48'),(4,13,'FMIPA','FIK',4,4,'2015-02-25','10:00:00','','INSERT','2015-02-25 09:33:07'),(22,14,'FT','Perpusat',1,1,'2015-03-14','15:00:00','','INSERT','2015-03-14 11:48:39'),(23,15,'ft','cawang',3,3,'2015-03-16','13:01:00','','INSERT','2015-03-16 11:50:37'),(4,13,'FMIPA','FIK',4,4,'2015-02-25','10:00:00','','DELETE','2015-03-16 11:51:35'),(23,15,'ft','cawang',3,2,'2015-03-16','13:01:00','','UPDATE','2015-03-16 11:51:41'),(6,16,'Jalan Koja IV No.1, Beji, Indonesia','Depok City, null, Indonesia',1,1,'2015-03-16','12:06:00','','INSERT','2015-03-16 12:15:12'),(6,16,'Jalan Koja IV No.1, Beji, Indonesia','Depok City, null, Indonesia',1,1,'2015-03-16','12:06:00','','DELETE','2015-03-16 12:16:50'),(6,17,'Jalan Muhamad Alif No.11A, Beji, Indonesia','Depok City, null, Indonesia',1,1,'2015-03-16','13:00:00','','INSERT','2015-03-16 12:17:33'),(23,15,'ft','cawang',3,3,'2015-03-16','13:01:00','','UPDATE','2015-03-16 12:19:06'),(6,17,'Jalan Muhamad Alif No.11A, Beji, Indonesia','Depok City, null, Indonesia',1,0,'2015-03-16','13:00:00','','UPDATE','2015-03-16 12:19:29'),(15,18,'FT','Jalan Chandraga 2 No.18, Pasar Rebo, Indonesia',2,2,'2015-03-16','13:00:00','','INSERT','2015-03-16 12:24:16'),(6,17,'Jalan Muhamad Alif No.11A, Beji, Indonesia','Depok City, null, Indonesia',1,1,'2015-03-16','13:00:00','','UPDATE','2015-03-16 12:24:44'),(15,18,'FT','Jalan Chandraga 2 No.18, Pasar Rebo, Indonesia',2,1,'2015-03-16','13:00:00','','UPDATE','2015-03-16 12:24:54'),(15,18,'FT','Jalan Chandraga 2 No.18, Pasar Rebo, Indonesia',2,1,'2015-03-16','13:00:00','','DELETE','2015-03-16 12:35:17'),(15,19,'','',2,2,'2015-03-18','13:15:00','','INSERT','2015-03-18 00:13:22'),(22,14,'FT','Perpusat',1,1,'2015-03-14','15:00:00','','DELETE','2015-03-18 06:11:53'),(15,19,'','',2,1,'2015-03-18','13:15:00','','UPDATE','2015-03-18 06:12:00'),(4,20,'aaa','oleole',3,3,'2015-03-18','15:35:00','aaaa','INSERT','2015-03-18 11:33:02'),(1,10,'X','Y',1,1,'2015-01-29','16:00:00','test','UPDATE','2015-03-18 13:22:54'),(23,15,'ft','cawang',3,3,'2015-03-16','13:01:00','','UPDATE','2015-03-18 13:25:15'),(1,10,'X','Y',1,1,'2015-03-18','16:00:00','test','DELETE','2015-03-18 15:38:02'),(23,15,'ft','cawang',3,3,'2015-03-18','16:01:00','','DELETE','2015-03-18 15:38:02'),(6,17,'Jalan Muhamad Alif No.11A, Beji, Indonesia','Depok City, null, Indonesia',1,1,'2015-03-16','13:00:00','','DELETE','2015-03-18 15:38:02'),(15,19,'','',2,1,'2015-03-18','13:15:00','','DELETE','2015-03-18 15:38:02'),(4,20,'aaa','oleole',3,3,'2015-03-18','15:35:00','aaaa','DELETE','2015-03-18 15:38:02'),(4,21,'aa','a',3,3,'2015-03-18','17:35:00','yyy','INSERT','2015-03-18 16:35:16'),(29,22,'ft','kober',1,1,'2015-03-19','14:41:00','jln kaki','INSERT','2015-03-19 13:42:13'),(29,22,'ft','kober',1,1,'2015-03-19','14:41:00','jln kaki','DELETE','2015-03-19 13:42:26'),(29,23,'Kukusan','Kober',1,1,'2015-03-19','20:00:00','Tes','INSERT','2015-03-19 19:35:58'),(12,24,'Kober','Kukusan',2,2,'2015-03-19','21:00:00','Tes','INSERT','2015-03-19 19:36:57'),(17,25,'Kukusan','Kukel',1,1,'2015-03-19','22:00:00','','INSERT','2015-03-19 19:37:31'),(29,23,'Kukusan','Kober',1,NULL,'2015-03-19','20:00:00','Tes','UPDATE','2015-03-19 20:01:25'),(29,23,'Kukusan','Kober',0,NULL,'2015-03-19','20:00:00','Tes','DELETE','2015-03-19 22:17:19'),(10,26,'A','B',1,1,'2015-03-20','07:00:00','','INSERT','2015-03-19 22:43:26'),(13,27,'B','A',2,2,'2015-03-20','08:00:00','','INSERT','2015-03-19 22:43:52'),(15,28,'C','A',1,1,'2015-03-20','10:00:00','','INSERT','2015-03-19 22:44:38'),(13,27,'B','A',2,NULL,'2015-03-20','08:00:00','','UPDATE','2015-03-20 12:15:29'),(15,28,'C','A',1,NULL,'2015-03-20','10:00:00','','UPDATE','2015-03-20 12:16:31'),(13,27,'B','A',2,NULL,'2015-03-20','15:00:00','','UPDATE','2015-03-20 12:43:51'),(13,27,'B','A',0,0,'2015-03-20','15:00:00','','UPDATE','2015-03-20 12:50:25'),(15,28,'C','A',1,1,'2015-03-20','16:00:00','','UPDATE','2015-03-20 12:50:31'),(31,29,'A','B',1,1,'2015-03-20','19:00:00','','INSERT','2015-03-20 14:28:25'),(31,29,'A','B',1,1,'2015-03-20','19:00:00','','UPDATE','2015-03-20 17:41:47'),(31,29,'A','B',1,0,'2015-03-20','19:00:00','','UPDATE','2015-03-20 17:54:35'),(31,29,'A','B',1,1,'2015-03-20','19:00:00','','UPDATE','2015-03-20 18:17:52'),(29,30,'Vokasi','FT',4,4,'2015-03-25','12:24:00','mobil','INSERT','2015-03-25 11:24:53'),(29,30,'Vokasi','FT',4,4,'2015-03-25','12:24:00','mobil','DELETE','2015-03-25 11:25:30'),(29,31,'Kober','FT',1,1,'2015-03-25','18:45:00','Ketemu di lobby k :)','INSERT','2015-03-25 11:53:01'),(29,31,'Kober','FT',1,1,'2015-03-25','18:45:00','Ketemu di lobby k :)','DELETE','2015-03-25 11:53:34'),(29,32,'FT','Kober',1,1,'2015-03-25','18:50:00','Ketemu di lobby k FT ya :)','INSERT','2015-03-25 11:54:11'),(29,32,'FT','Kober',1,1,'2015-03-25','18:50:00','Ketemu di lobby k FT ya :)','DELETE','2015-03-30 10:47:09'),(29,33,'FT','Fasilkom',3,3,'2015-04-08','18:57:00','patungan bensin','INSERT','2015-04-08 08:41:47'),(29,33,'FT','Fasilkom',3,3,'2015-04-08','18:57:00','patungan bensin','DELETE','2015-04-22 14:49:11'),(29,34,'FISIP','Jalan Situ Indah No.110, Cimanggis, Indonesia',5,5,'2015-04-22','17:01:00','b','INSERT','2015-04-22 14:50:15'),(32,35,'balairuny','kelapa dua',4,4,'2015-06-30','17:44:00','tes','INSERT','2015-06-30 11:38:38'),(32,35,'balairuny','kelapa dua',4,4,'2015-06-30','17:44:00','tes','DELETE','2015-06-30 11:39:18');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nebeng`
--

DROP TABLE IF EXISTS `nebeng`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nebeng` (
  `id_penebeng` int(11) NOT NULL,
  `id_tebengan` int(11) NOT NULL,
  `waktu_konfirmasi` time DEFAULT NULL,
  PRIMARY KEY (`id_penebeng`),
  KEY `id_tebengan` (`id_tebengan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nebeng`
--

LOCK TABLES `nebeng` WRITE;
/*!40000 ALTER TABLE `nebeng` DISABLE KEYS */;
INSERT INTO `nebeng` VALUES (22,15,'06:12:00');
/*!40000 ALTER TABLE `nebeng` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pospolisi`
--

DROP TABLE IF EXISTS `pospolisi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pospolisi` (
  `lokasi` text NOT NULL,
  `telp` text NOT NULL,
  `alamat` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pospolisi`
--

LOCK TABLES `pospolisi` WRITE;
/*!40000 ALTER TABLE `pospolisi` DISABLE KEYS */;
INSERT INTO `pospolisi` VALUES ('Polsek Metro Gambir \r\n','021-3456422, 3456421\r\n','Jl Cideng Barat Dalam \r\n'),('Polsek Metro Sawah Besar\r\n',' 021-3454363, 850645, 3541728\r\n','Jl Dr.Wahidin No 8\r\n');
/*!40000 ALTER TABLE `pospolisi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spbu`
--

DROP TABLE IF EXISTS `spbu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spbu` (
  `lokasi` text NOT NULL,
  `alamat` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spbu`
--

LOCK TABLES `spbu` WRITE;
/*!40000 ALTER TABLE `spbu` DISABLE KEYS */;
INSERT INTO `spbu` VALUES ('Tambora\r\n','Jl. Perniagaan, Roa Malaka, Jakarta Barat\r\n'),('Tambora\r\n','Jl. Rahayu 2, Angke, Jakarta Barat\r\n');
/*!40000 ALTER TABLE `spbu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timestamp`
--

DROP TABLE IF EXISTS `timestamp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timestamp` (
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timestamp`
--

LOCK TABLES `timestamp` WRITE;
/*!40000 ALTER TABLE `timestamp` DISABLE KEYS */;
INSERT INTO `timestamp` VALUES ('2015-01-29 06:59:48'),('2015-01-29 07:00:00'),('2015-01-29 07:00:03'),('2015-01-29 07:00:10'),('2015-01-29 07:00:11'),('2015-01-29 07:00:11'),('2015-01-29 07:00:12'),('2015-01-29 07:00:13');
/*!40000 ALTER TABLE `timestamp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `traffic`
--

DROP TABLE IF EXISTS `traffic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `traffic` (
  `lokasi` text NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traffic`
--

LOCK TABLES `traffic` WRITE;
/*!40000 ALTER TABLE `traffic` DISABLE KEYS */;
INSERT INTO `traffic` VALUES ('Jalan Margonda Raya, Depok','Kondisi Macet dua arah.'),('Gang Senggol Pocin, Depok','Kondisi Macet.'),('Jl. Sudirman Raya ','macet total'),('Jl. veteran Raya, Bintaro','Ramai Lancar'),('Poris, tangerang','Jalan dialihkan'),('BSD, Tangerang','Macet, ada perbaikan jalan');
/*!40000 ALTER TABLE `traffic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `npm` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `nama` text COLLATE utf8_unicode_ci NOT NULL,
  `role` text COLLATE utf8_unicode_ci NOT NULL,
  `no_handphone` text COLLATE utf8_unicode_ci,
  `email` text COLLATE utf8_unicode_ci,
  `reg_id` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `npm` (`npm`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (5,'1106004411','ria.yuliana11','ria yuliana','','','',''),(7,'1006683002','dina.apriasari','dina','','','',''),(8,'1106019174','ayu.dewita','ayu dewita','','','',''),(9,'1106016525','maghfirotul.amalia','Amalia','','','',''),(10,'1106054725','dina.sulthoni','Dina Sulthoni','','','',''),(12,'1106054795','adhyatma.abbas','ADHYATMA ABBAS','mahasiswa','','',''),(13,'1106004752','abd.majid','ABD MAJID HAMID','mahasiswa','','',''),(14,'1106109106','ruki.harwahyu11','RUKI HARWAHYU','mahasiswa','','',''),(15,'19700707199','riri','Riri Fitri Sari ,Dr. ,Ir. , MM. , MSc','operator-ppsi','','',''),(16,'1206202293','sulistiyaningsih21','SULISTIYANINGSIH','mahasiswa','','',''),(17,'1206202311','sarah.az','SARAH AZ ZAHRA','mahasiswa','','',''),(18,'1206202223','vebrianty.siahaan','VEBRIANTY SIAHAAN','mahasiswa','','',''),(19,'1123456789','test_trigger','test_trigger','','','',''),(20,'1106016191','urwah.syadid','URWAH SYADID ROBBY RODIYAH','mahasiswa','','',''),(21,'1206237372','akbar.sahata','AKBAR SAHATA S','mahasiswa','','',''),(22,'041303029','ruki.h','Ruki Harwahyu','dosen','','',''),(23,'1406584694','misbahuddin','MISBAHUDDIN','mahasiswa','','',''),(29,'1106002186','suryo.satrio','SURYO SATRIO','mahasiswa','081278102985','suryosatrio13@gmail.com','APA91bHPMp4GFghNeUE9hnrRuI60H2NC9r1YAJiq6AcKY-J2jJi6EScHQTP_nJukVPhPguAH24giHSj7UyhkX53XVasTKmXfxNQ2scCRp2Lx9o4M_cTVZcLFE4pMWqGTuXZFT6IFDhnJhaI8yexyuTOephjB0pqTDcsURVHjWXDOMKpO_OMUfwI'),(30,'1206202394','sanadhi.sutandi','SANADHI SUTANDI I MADE','mahasiswa',NULL,NULL,'None'),(31,'1106054731','martin.dominikus','MARTIN DOMINIKUS','mahasiswa',NULL,NULL,'None'),(32,'1106053464','fauzan.helmi','FAUZAN HELMI S.','mahasiswa','085693111036','ujan@ujan.org','APA91bGq_rtRwswRIL5FFgK6nk4sOu3XVXqdXYfRvLA6JvPxPsWwnzBulqnWUDjPekFsbG7gT9VJLxkOhdPAEN57lw61BX0p7o9fPNxxctoeLtI-kAnZNg5iV9P5y18Kx1dCO2T5ucHg'),(33,'1106087692','rasmunandar.rustam','Rasmunandar Rustam','mahasiswa','082220458193','nandar.rustam@gmail.com','APA91bEUtUn4441P2mDmZIFW2j27z8ElDVPb65vCtvzfu1ADQwJ7OsX-R2zM062Ewf1SoNRD6iKx5jwzwWkgTZTDPqfoGxsIsaWTp37iYa-HaejSGqxr9PBokBLkP46DmgFqHMHxmxqu');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'green_ui_ac_id_iot'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-18  2:30:26
