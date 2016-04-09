CREATE DATABASE  IF NOT EXISTS `thelodge` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `thelodge`;
-- MySQL dump 10.13  Distrib 5.6.13, for osx10.6 (i386)
--
-- Host: localhost    Database: thelodge
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'robinsve404@gmail.com','Robin','Svensson','f3885ad30b913668defebc354d2362c903b1e103');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_times`
--

DROP TABLE IF EXISTS `book_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_times` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(45) DEFAULT NULL,
  `time_from` varchar(45) DEFAULT NULL,
  `time_to` varchar(45) DEFAULT NULL,
  `seats` varchar(45) DEFAULT '0',
  `note` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_times`
--

LOCK TABLES `book_times` WRITE;
/*!40000 ALTER TABLE `book_times` DISABLE KEYS */;
INSERT INTO `book_times` VALUES (1,'7','1443722400','1443733200','10',NULL),(2,'7','1444773600','1444845600','12',NULL);
/*!40000 ALTER TABLE `book_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` varchar(45) DEFAULT NULL,
  `order_id` varchar(45) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT 'PRODUCT',
  `item_id` varchar(45) DEFAULT NULL COMMENT 'Only used when containing and extras',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (1,'2','13',3,'Robin','Svensson','+46738553322','robinsve404@gmail.com','PRODUCT',NULL),(2,'2','13',1,'Robin','Svensson','+46738553322','robinsve404@gmail.com','EXTRAS','2'),(3,'2','18',2,'Robin','Svensson','+46738553322','robinsve404@gmail.com','PRODUCT',NULL),(4,'2','18',1,'Robin','Svensson','+46738553322','robinsve404@gmail.com','EXTRAS','2');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extras`
--

DROP TABLE IF EXISTS `extras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `desc` text,
  `price` int(11) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extras`
--

LOCK TABLES `extras` WRITE;
/*!40000 ALTER TABLE `extras` DISABLE KEYS */;
INSERT INTO `extras` VALUES (1,'Champagne till maten','d5a58057fb.jpg','En flaska champagne',1500,'fixed',1),(2,'penga','78554ca553.jpg','dasd',123,'fixed',0);
/*!40000 ALTER TABLE `extras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extras_relations`
--

DROP TABLE IF EXISTS `extras_relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extras_relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) DEFAULT NULL,
  `extras` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extras_relations`
--

LOCK TABLES `extras_relations` WRITE;
/*!40000 ALTER TABLE `extras_relations` DISABLE KEYS */;
INSERT INTO `extras_relations` VALUES (1,1,1);
/*!40000 ALTER TABLE `extras_relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `src` varchar(255) DEFAULT NULL,
  `active` varchar(45) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'bf3ec22b3c.jpg','1'),(2,'f214a45e55.jpg','1'),(3,'28313dc852.jpg','1');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `used` int(11) DEFAULT '0',
  `cost` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,'PRODUCT',2,0,1495),(2,2,4,'SUM',3000,0,1),(14,4,4,'SUM',3790,0,1),(5,5,4,'SUM',2500,1750,1),(6,6,2,'PRODUCT',2,0,1895),(16,7,4,'SUM',1495,150,1),(13,8,4,'SUM',3118,0,1),(17,10,2,'PRODUCT',3,0,1895),(15,9,4,'SUM',23722,0,1),(28,13,2,'PRODUCT',1,0,1895),(27,11,4,'SUM',4613,922,1),(37,12,1,'EXTRAS',1,0,1500),(36,12,1,'PRODUCT',7,0,1495),(29,13,1,'EXTRAS',1,0,1500);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items_history`
--

DROP TABLE IF EXISTS `order_items_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `used` int(11) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items_history`
--

LOCK TABLES `order_items_history` WRITE;
/*!40000 ALTER TABLE `order_items_history` DISABLE KEYS */;
INSERT INTO `order_items_history` VALUES (1,8,1,'PRODUCT',1,0,1495),(2,8,1,'EXTRAS',1,0,1500),(3,8,2,'EXTRAS',1,0,123),(4,4,2,'PRODUCT',2,0,1895),(5,9,4,'SUM',22222,0,1),(6,9,1,'EXTRAS',1,0,1500),(7,7,1,'PRODUCT',1,0,1495),(8,11,1,'PRODUCT',2,0,1495),(9,11,1,'EXTRAS',1,0,1500),(10,11,2,'EXTRAS',1,0,123);
/*!40000 ALTER TABLE `order_items_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postal` varchar(255) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `shipping_alternative` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `message` text,
  `code` varchar(255) DEFAULT NULL,
  `payment` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `shipped` int(11) DEFAULT '0',
  `expires` int(255) DEFAULT '63072000',
  `status` varchar(255) DEFAULT 'PENDING',
  `type` varchar(255) DEFAULT 'CUSTOMER',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'Göran','Svensson','robinsve404@gmail.com','ö odarslov 463','22592','Lund','SE','31231231',3,NULL,'dsadas','ac9a0457',NULL,1456431030,0,5356800,'APPROVED','COMPLAINT'),(2,'Robin','Svensson','robinsve404@gmail.com','ö odarslov 463','22592','Lund','SE','123123123',3,NULL,'hej123','46ae91c5',NULL,1456431097,0,32140800,'APPROVED','MARKETING'),(4,'Robin','Svensson','robinsve404@gmail.com','ö odarslov 463','22592','Lund','SE','0738552233',3,NULL,'hej','07b07f27',NULL,1456432234,0,7776000,'APPROVED','MARKETING'),(5,'Robin','Svensson','robinsve404@gmail.com','ö odarslov 463','22592','Lund','SE','12312312',3,NULL,'hej123','6e939841',NULL,1456432438,0,472608000,'APPROVED','COMPLAINT'),(6,'Robin','Svensson','robinsve404@gmail.com','ö odarslov 463','22592','Lund','SE','321312',3,NULL,'2das','d8290e6b',NULL,1456432485,0,5184000,'APPROVED','MARKETING'),(7,'Robin','Svensson','robinsve404@gmail.com','ö odarslov 463','22592','Lund','SE','321312',3,NULL,'2221','dc2906fe',NULL,1456432844,0,117504000,'APPROVED','MARKETING'),(8,'Robin','Svensson','robinsve404@gmail.com','ö odarslov 463','22592','Lund','SE','321312',3,NULL,'2221','db18224b',NULL,1456432953,0,54432000,'APPROVED','MARKETING'),(9,'Robin','Svensson','robinsve404@gmail.com','ö odarslov 463','22592','Lund','SE','123',3,NULL,'hej','c2c9a436',NULL,1456432982,0,70848000,'APPROVED','MARKETING'),(10,'robin','Svensson','ro@gmail.com','hej 123','22592','lunn','SE','055545466',2,'1','','bda7ffb2','c670c298c91a4465b071b01d39c89f50',1456434684,0,63072000,'APPROVED','CUSTOMER'),(11,'Robin','Svensson','robinsve404@gmail.com','ö odarslov 463','22592','Lund','SE','33123123',3,NULL,'dsa','8781238c',NULL,1456435234,0,133920000,'APPROVED','MARKETING'),(12,'Robin','Svensson','robinsve404@gmail.com','ö odarslov 463','22592','Lund','SE','+46738553322',1,'1','hej','ef4bc0e1','877376203a5c402cb0249943d37713af',1457337721,0,63072000,'PENDING','CUSTOMER'),(13,'Robin','Svensson','robinsve404@gmail.com','ö odarslov 463','22592','Lund','SE','0738553322',3,NULL,'hej','62e3f309',NULL,1456476872,0,7776000,'APPROVED','COMPLAINT');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(45) DEFAULT NULL,
  `desc` text,
  `price` int(11) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Vardagslyx','9e8032987d.jpg','Detta paket är för dig som vill bo över mellan måndag och torsdag, ej tillgång till Spa.\r\n\r\n3-rätters middag\r\nÖvernattning i cabin/dubbelrum\r\nFrukost\r\nVår Spa-avdelning är endast öppen fredag-söndag men andra öppettider kan förekomma, så fråga oss gärna!\r\nTillgång till Spa kostar i så fall 295kr/person för 2 h.\r\n\r\nPris 1495kr/person/natt',1495,'person',1),(2,'Friday at the lodge','937c959676.jpg','Detta paket är för dig som vill komma till oss en fredag.\r\n\r\nTapas/Snackstallrik när ni ankommer kl 15\r\nTillgång till Spa avdelningen (2h)\r\n4-rätters gourmetmiddag\r\nÖvernattning i ett av våra mysiga dubbelrum/cabins\r\nFrukostbuffé\r\n\r\nPris 1895kr/person/natt',1895,'person',1),(3,'Weekend De Luxe','61bbf8ff1d.jpg','Detta paket är för dig som vill skämma bort dig ordentligt, antingen en fredag till lördag\r\neller lördag till söndag.\r\n\r\nMousserande vin & handgjorda tryfflar väntar på rummet\r\nAfternoon Tea (lör) eller Tapasbuffé (fre) när ni ankommer kl 14\r\nTillgång till Spa avdelningen (2h)\r\n4-rätters gourmetmiddag\r\nUtprovat vinpaket med fyra glas vin till maten\r\nÖvernattning i ett av våra mysiga dubbelrum/cabins\r\nFrukostbuffé\r\n\r\nPris 2950 kr/person/natt',2950,'person',1),(4,'Valfritt belopp','93fff91f09.jpg','Valfri summa som kan spenderas.',1,'sum',1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-01 11:05:14
