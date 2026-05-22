-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: 127.0.0.1    Database: webte2_z4
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `iso_code` char(2) NOT NULL,
  `capital` varchar(255) NOT NULL,
  `currency_code` char(3) NOT NULL,
  `currency_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_iso_code_unique` (`iso_code`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Spain','es','Madrid','EUR','Euro','2026-05-05 15:15:04','2026-05-05 15:15:04'),(2,'Italy','it','Rome','EUR','Euro','2026-05-05 15:15:04','2026-05-05 15:15:04'),(3,'Greece','gr','Athens','EUR','Euro','2026-05-05 15:15:04','2026-05-05 15:15:04'),(4,'Croatia','hr','Zagreb','EUR','Euro','2026-05-05 15:15:04','2026-05-05 15:15:04'),(5,'Austria','at','Vienna','EUR','Euro','2026-05-05 15:15:05','2026-05-05 15:15:05'),(6,'Czech Republic','cz','Prague','CZK','Czech koruna','2026-05-05 15:15:05','2026-05-05 15:15:05'),(7,'Hungary','hu','Budapest','HUF','Hungarian forint','2026-05-05 15:15:05','2026-05-05 15:15:05'),(8,'France','fr','Paris','EUR','Euro','2026-05-05 15:15:05','2026-05-05 15:15:05'),(9,'Netherlands','nl','Amsterdam','EUR','Euro','2026-05-05 15:15:05','2026-05-05 15:15:05'),(10,'Switzerland','ch','Bern','CHF','Swiss franc','2026-05-05 15:15:05','2026-05-05 15:15:05'),(11,'Portugal','pt','Lisbon','EUR','Euro','2026-05-05 15:15:05','2026-05-05 15:15:05'),(12,'Turkey','tr','Ankara','TRY','Turkish lira','2026-05-05 15:15:05','2026-05-05 15:15:05');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destination_destination_type`
--

DROP TABLE IF EXISTS `destination_destination_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `destination_destination_type` (
  `destination_id` bigint(20) unsigned NOT NULL,
  `destination_type_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`destination_id`,`destination_type_id`),
  KEY `destination_destination_type_destination_type_id_foreign` (`destination_type_id`),
  CONSTRAINT `destination_destination_type_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `destination_destination_type_destination_type_id_foreign` FOREIGN KEY (`destination_type_id`) REFERENCES `destination_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destination_destination_type`
--

LOCK TABLES `destination_destination_type` WRITE;
/*!40000 ALTER TABLE `destination_destination_type` DISABLE KEYS */;
INSERT INTO `destination_destination_type` VALUES (1,1),(1,3),(1,4),(2,1),(2,4),(3,3),(3,4),(4,3),(4,4),(5,3),(5,4),(6,1),(6,5),(7,1),(7,3),(7,4),(8,1),(8,3),(9,3),(9,4),(10,3),(10,4),(11,3),(11,4),(12,3),(12,4),(13,4),(13,5),(14,2),(14,4),(15,2),(15,4),(15,5),(16,2),(16,5),(17,1),(17,2),(17,5),(18,1),(18,3),(18,4),(19,1),(19,2),(19,5),(20,3),(20,4);
/*!40000 ALTER TABLE `destination_destination_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destination_types`
--

DROP TABLE IF EXISTS `destination_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `destination_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `destination_types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destination_types`
--

LOCK TABLES `destination_types` WRITE;
/*!40000 ALTER TABLE `destination_types` DISABLE KEYS */;
INSERT INTO `destination_types` VALUES (1,'more a pláž','2026-05-05 15:15:05','2026-05-05 15:15:05'),(2,'hory a príroda','2026-05-05 15:15:05','2026-05-05 15:15:05'),(3,'historické mestá','2026-05-05 15:15:05','2026-05-05 15:15:05'),(4,'mestský výlet','2026-05-05 15:15:05','2026-05-05 15:15:05'),(5,'aktivity a dobrodružstvo','2026-05-05 15:15:05','2026-05-05 15:15:05');
/*!40000 ALTER TABLE `destination_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `destinations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `nearest_weather_city` varchar(255) NOT NULL,
  `flight_hours_from_vienna` decimal(4,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `destinations_country_id_name_unique` (`country_id`,`name`),
  KEY `destinations_flight_hours_from_vienna_index` (`flight_hours_from_vienna`),
  CONSTRAINT `destinations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destinations`
--

LOCK TABLES `destinations` WRITE;
/*!40000 ALTER TABLE `destinations` DISABLE KEYS */;
INSERT INTO `destinations` VALUES (1,1,'Barcelona','Stredomorské mesto s plážami, architektúrou Gaudího a živou mestskou atmosférou.','https://loremflickr.com/900/620/barcelona,spain,travel?lock=100',41.3874000,2.1686000,'Barcelona',2.30,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(2,1,'Valencia','Slnečné pobrežné mesto s plážami, modernou architektúrou a príjemným tempom.','https://loremflickr.com/900/620/valencia,spain,travel?lock=101',39.4699000,-0.3763000,'Valencia',2.60,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(3,2,'Rome','Historická metropola s antickými pamiatkami, múzeami a talianskou gastronómiou.','https://loremflickr.com/900/620/rome,italy,travel?lock=102',41.9028000,12.4964000,'Rome',1.60,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(4,2,'Florence','Renesančné mesto vhodné pre umenie, históriu a pokojnejší kultúrny pobyt.','https://loremflickr.com/900/620/florence,italy,travel?lock=103',43.7696000,11.2558000,'Florence',1.50,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(5,3,'Athens','Staroveké pamiatky, mestský život a dobrý východiskový bod na grécke pobrežie.','https://loremflickr.com/900/620/athens,greece,travel?lock=104',37.9838000,23.7275000,'Athens',2.20,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(6,3,'Santorini','Kykladský ostrov s bielymi dedinami, výhľadmi na kalderu a letnou dovolenkovou atmosférou.','https://loremflickr.com/900/620/santorini,greece,travel?lock=105',36.3932000,25.4615000,'Thira',2.40,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(7,4,'Split','Dalmátske mesto pri mori s Diokleciánovým palácom a dostupnými ostrovmi.','https://loremflickr.com/900/620/split,croatia,travel?lock=106',43.5081000,16.4402000,'Split',1.20,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(8,4,'Dubrovnik','Pevnostné historické mesto nad Jadranom, vhodné na kombináciu mora a pamiatok.','https://loremflickr.com/900/620/dubrovnik,croatia,travel?lock=107',42.6507000,18.0944000,'Dubrovnik',1.40,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(9,5,'Vienna','Elegantné hlavné mesto s múzeami, kaviarňami, koncertmi a historickou architektúrou.','https://loremflickr.com/900/620/vienna,austria,travel?lock=108',48.2082000,16.3738000,'Vienna',0.00,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(10,6,'Prague','Romantické historické mesto s hradom, Karlovým mostom a dostupným víkendovým programom.','https://loremflickr.com/900/620/prague,czech,travel?lock=109',50.0755000,14.4378000,'Prague',0.80,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(11,7,'Budapest','Dunajská metropola s termálnymi kúpeľmi, výhľadmi a výraznou večernou atmosférou.','https://loremflickr.com/900/620/budapest,hungary,travel?lock=110',47.4979000,19.0402000,'Budapest',0.80,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(12,8,'Paris','Kultúrna metropola s ikonickými pamiatkami, galériami a mestskými prechádzkami.','https://loremflickr.com/900/620/paris,france,travel?lock=111',48.8566000,2.3522000,'Paris',2.10,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(13,9,'Amsterdam','Mesto kanálov, múzeí a bicyklov, vhodné na aktívny mestský výlet.','https://loremflickr.com/900/620/amsterdam,netherlands,travel?lock=112',52.3676000,4.9041000,'Amsterdam',2.00,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(14,10,'Zurich','Švajčiarske mesto pri jazere, vhodné na mestský pobyt aj výlety do prírody.','https://loremflickr.com/900/620/zurich,switzerland,travel?lock=113',47.3769000,8.5417000,'Zurich',1.40,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(15,5,'Innsbruck','Alpské mesto obklopené horami, vhodné na turistiku, zimné športy a prírodu.','https://loremflickr.com/900/620/innsbruck,austria,mountains?lock=114',47.2692000,11.4041000,'Innsbruck',1.00,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(16,10,'Zermatt','Horská destinácia pod Matterhornom, ideálna na turistiku, lyžovanie a alpské výhľady.','https://loremflickr.com/900/620/zermatt,switzerland,mountains?lock=115',46.0207000,7.7491000,'Zermatt',2.00,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(17,11,'Madeira','Zelený ostrov s miernym počasím, oceánom, levádami a prírodnými výletmi.','https://loremflickr.com/900/620/madeira,portugal,travel?lock=116',32.7607000,-16.9595000,'Funchal',4.70,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(18,11,'Lisbon','Atlantická metropola s výhľadmi, historickými štvrťami a dostupnými plážami v okolí.','https://loremflickr.com/900/620/lisbon,portugal,travel?lock=117',38.7223000,-9.1393000,'Lisbon',3.60,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(19,1,'Mallorca','Baleársky ostrov s plážami, horskými cestami a širokou ponukou letných aktivít.','https://loremflickr.com/900/620/mallorca,spain,beach?lock=118',39.6953000,3.0176000,'Palma',2.40,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(20,12,'Istanbul','Mesto medzi Európou a Áziou s bazármi, mešitami, históriou a výraznou atmosférou.','https://loremflickr.com/900/620/istanbul,turkey,travel?lock=119',41.0082000,28.9784000,'Istanbul',2.20,'2026-05-05 15:15:05','2026-05-05 15:15:05');
/*!40000 ALTER TABLE `destinations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_05_000001_create_countries_table',1),(5,'2026_05_05_000002_create_destination_types_table',1),(6,'2026_05_05_000003_create_destinations_table',1),(7,'2026_05_05_000004_create_destination_destination_type_table',1),(8,'2026_05_05_000005_create_monthly_weather_table',1),(9,'2026_05_05_000006_create_visits_table',1),(10,'2026_05_05_000007_create_searches_table',1),(11,'2026_05_05_000008_create_search_type_table',1),(12,'2026_05_05_000009_create_search_destination_table',1),(13,'2026_05_05_000010_add_image_url_to_destinations_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monthly_weather`
--

DROP TABLE IF EXISTS `monthly_weather`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monthly_weather` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `destination_id` bigint(20) unsigned NOT NULL,
  `month` tinyint(3) unsigned NOT NULL,
  `avg_temp` decimal(4,1) NOT NULL,
  `min_temp` decimal(4,1) NOT NULL,
  `max_temp` decimal(4,1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `monthly_weather_destination_id_month_unique` (`destination_id`,`month`),
  KEY `monthly_weather_month_index` (`month`),
  CONSTRAINT `monthly_weather_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monthly_weather`
--

LOCK TABLES `monthly_weather` WRITE;
/*!40000 ALTER TABLE `monthly_weather` DISABLE KEYS */;
INSERT INTO `monthly_weather` VALUES (1,1,1,10.0,6.0,14.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(2,1,2,11.0,7.0,15.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(3,1,3,13.0,9.0,17.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(4,1,4,15.0,11.0,19.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(5,1,5,18.0,13.5,22.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(6,1,6,22.0,17.5,26.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(7,1,7,25.0,20.0,30.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(8,1,8,26.0,21.0,31.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(9,1,9,23.0,18.5,27.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(10,1,10,19.0,14.5,23.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(11,1,11,14.0,10.0,18.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(12,1,12,11.0,7.0,15.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(13,2,1,11.0,7.0,15.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(14,2,2,12.0,8.0,16.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(15,2,3,14.0,10.0,18.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(16,2,4,16.0,12.0,20.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(17,2,5,19.0,14.5,23.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(18,2,6,23.0,18.5,27.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(19,2,7,26.0,21.0,31.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(20,2,8,26.0,21.0,31.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(21,2,9,24.0,19.5,28.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(22,2,10,20.0,15.5,24.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(23,2,11,15.0,11.0,19.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(24,2,12,12.0,8.0,16.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(25,3,1,8.0,4.0,12.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(26,3,2,9.0,5.0,13.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(27,3,3,12.0,8.0,16.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(28,3,4,15.0,11.0,19.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(29,3,5,19.0,14.5,23.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(30,3,6,23.0,18.5,27.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(31,3,7,26.0,21.0,31.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(32,3,8,26.0,21.0,31.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(33,3,9,22.0,17.5,26.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(34,3,10,18.0,13.5,22.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(35,3,11,13.0,9.0,17.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(36,3,12,9.0,5.0,13.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(37,4,1,6.0,2.5,9.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(38,4,2,8.0,4.0,12.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(39,4,3,11.0,7.0,15.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(40,4,4,14.0,10.0,18.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(41,4,5,18.0,13.5,22.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(42,4,6,22.0,17.5,26.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(43,4,7,25.0,20.0,30.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(44,4,8,25.0,20.0,30.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(45,4,9,21.0,16.5,25.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(46,4,10,16.0,12.0,20.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(47,4,11,11.0,7.0,15.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(48,4,12,7.0,3.5,10.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(49,5,1,10.0,6.0,14.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(50,5,2,11.0,7.0,15.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(51,5,3,13.0,9.0,17.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(52,5,4,17.0,13.0,21.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(53,5,5,22.0,17.5,26.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(54,5,6,27.0,22.0,32.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(55,5,7,30.0,25.0,35.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(56,5,8,30.0,25.0,35.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(57,5,9,26.0,21.0,31.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(58,5,10,21.0,16.5,25.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(59,5,11,16.0,12.0,20.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(60,5,12,12.0,8.0,16.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(61,6,1,12.0,8.0,16.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(62,6,2,13.0,9.0,17.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(63,6,3,15.0,11.0,19.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(64,6,4,18.0,13.5,22.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(65,6,5,22.0,17.5,26.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(66,6,6,26.0,21.0,31.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(67,6,7,28.0,23.0,33.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(68,6,8,28.0,23.0,33.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(69,6,9,25.0,20.0,30.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(70,6,10,21.0,16.5,25.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(71,6,11,17.0,13.0,21.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(72,6,12,14.0,10.0,18.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(73,7,1,8.0,4.0,12.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(74,7,2,9.0,5.0,13.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(75,7,3,12.0,8.0,16.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(76,7,4,16.0,12.0,20.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(77,7,5,20.0,15.5,24.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(78,7,6,24.0,19.5,28.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(79,7,7,27.0,22.0,32.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(80,7,8,27.0,22.0,32.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(81,7,9,23.0,18.5,27.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(82,7,10,18.0,13.5,22.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(83,7,11,13.0,9.0,17.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(84,7,12,9.0,5.0,13.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(85,8,1,9.0,5.0,13.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(86,8,2,10.0,6.0,14.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(87,8,3,12.0,8.0,16.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(88,8,4,15.0,11.0,19.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(89,8,5,20.0,15.5,24.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(90,8,6,24.0,19.5,28.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(91,8,7,27.0,22.0,32.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(92,8,8,27.0,22.0,32.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(93,8,9,23.0,18.5,27.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(94,8,10,18.0,13.5,22.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(95,8,11,14.0,10.0,18.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(96,8,12,10.0,6.0,14.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(97,9,1,1.0,-2.5,4.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(98,9,2,3.0,-0.5,6.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(99,9,3,7.0,3.5,10.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(100,9,4,12.0,8.0,16.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(101,9,5,17.0,13.0,21.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(102,9,6,20.0,15.5,24.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(103,9,7,22.0,17.5,26.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(104,9,8,22.0,17.5,26.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(105,9,9,17.0,13.0,21.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(106,9,10,12.0,8.0,16.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(107,9,11,6.0,2.5,9.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(108,9,12,2.0,-1.5,5.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(109,10,1,0.0,-3.5,3.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(110,10,2,2.0,-1.5,5.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(111,10,3,6.0,2.5,9.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(112,10,4,11.0,7.0,15.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(113,10,5,16.0,12.0,20.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(114,10,6,19.0,14.5,23.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(115,10,7,21.0,16.5,25.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(116,10,8,20.0,15.5,24.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(117,10,9,16.0,12.0,20.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(118,10,10,10.0,6.0,14.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(119,10,11,5.0,1.5,8.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(120,10,12,1.0,-2.5,4.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(121,11,1,1.0,-2.5,4.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(122,11,2,3.0,-0.5,6.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(123,11,3,8.0,4.0,12.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(124,11,4,13.0,9.0,17.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(125,11,5,18.0,13.5,22.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(126,11,6,22.0,17.5,26.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(127,11,7,24.0,19.5,28.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(128,11,8,24.0,19.5,28.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(129,11,9,19.0,14.5,23.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(130,11,10,13.0,9.0,17.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(131,11,11,7.0,3.5,10.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(132,11,12,2.0,-1.5,5.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(133,12,1,5.0,1.5,8.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(134,12,2,6.0,2.5,9.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(135,12,3,9.0,5.0,13.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(136,12,4,12.0,8.0,16.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(137,12,5,16.0,12.0,20.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(138,12,6,19.0,14.5,23.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(139,12,7,21.0,16.5,25.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(140,12,8,21.0,16.5,25.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(141,12,9,18.0,13.5,22.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(142,12,10,13.0,9.0,17.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(143,12,11,8.0,4.0,12.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(144,12,12,6.0,2.5,9.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(145,13,1,4.0,0.5,7.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(146,13,2,4.0,0.5,7.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(147,13,3,7.0,3.5,10.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(148,13,4,10.0,6.0,14.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(149,13,5,14.0,10.0,18.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(150,13,6,17.0,13.0,21.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(151,13,7,19.0,14.5,23.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(152,13,8,18.0,13.5,22.5,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(153,13,9,16.0,12.0,20.0,'2026-05-05 15:15:05','2026-05-05 15:15:05'),(154,13,10,12.0,8.0,16.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(155,13,11,8.0,4.0,12.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(156,13,12,5.0,1.5,8.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(157,14,1,1.0,-2.5,4.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(158,14,2,2.0,-1.5,5.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(159,14,3,6.0,2.5,9.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(160,14,4,10.0,6.0,14.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(161,14,5,14.0,10.0,18.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(162,14,6,18.0,13.5,22.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(163,14,7,20.0,15.5,24.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(164,14,8,19.0,14.5,23.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(165,14,9,15.0,11.0,19.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(166,14,10,10.0,6.0,14.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(167,14,11,5.0,1.5,8.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(168,14,12,2.0,-1.5,5.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(169,15,1,-1.0,-5.0,3.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(170,15,2,1.0,-2.5,4.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(171,15,3,5.0,1.5,8.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(172,15,4,9.0,5.0,13.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(173,15,5,14.0,10.0,18.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(174,15,6,17.0,13.0,21.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(175,15,7,19.0,14.5,23.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(176,15,8,18.0,13.5,22.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(177,15,9,14.0,10.0,18.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(178,15,10,9.0,5.0,13.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(179,15,11,4.0,0.5,7.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(180,15,12,0.0,-3.5,3.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(181,16,1,-6.0,-10.0,-2.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(182,16,2,-5.0,-9.0,-1.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(183,16,3,-2.0,-6.0,2.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(184,16,4,1.0,-2.5,4.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(185,16,5,5.0,1.5,8.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(186,16,6,9.0,5.0,13.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(187,16,7,12.0,8.0,16.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(188,16,8,11.0,7.0,15.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(189,16,9,8.0,4.0,12.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(190,16,10,4.0,0.5,7.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(191,16,11,-1.0,-5.0,3.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(192,16,12,-5.0,-9.0,-1.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(193,17,1,16.0,12.0,20.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(194,17,2,16.0,12.0,20.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(195,17,3,17.0,13.0,21.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(196,17,4,17.0,13.0,21.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(197,17,5,19.0,14.5,23.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(198,17,6,21.0,16.5,25.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(199,17,7,23.0,18.5,27.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(200,17,8,24.0,19.5,28.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(201,17,9,23.0,18.5,27.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(202,17,10,22.0,17.5,26.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(203,17,11,19.0,14.5,23.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(204,17,12,17.0,13.0,21.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(205,18,1,11.0,7.0,15.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(206,18,2,12.0,8.0,16.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(207,18,3,14.0,10.0,18.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(208,18,4,15.0,11.0,19.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(209,18,5,18.0,13.5,22.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(210,18,6,21.0,16.5,25.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(211,18,7,23.0,18.5,27.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(212,18,8,24.0,19.5,28.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(213,18,9,23.0,18.5,27.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(214,18,10,19.0,14.5,23.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(215,18,11,15.0,11.0,19.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(216,18,12,12.0,8.0,16.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(217,19,1,10.0,6.0,14.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(218,19,2,11.0,7.0,15.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(219,19,3,13.0,9.0,17.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(220,19,4,15.0,11.0,19.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(221,19,5,19.0,14.5,23.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(222,19,6,23.0,18.5,27.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(223,19,7,26.0,21.0,31.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(224,19,8,26.0,21.0,31.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(225,19,9,23.0,18.5,27.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(226,19,10,19.0,14.5,23.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(227,19,11,14.0,10.0,18.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(228,19,12,11.0,7.0,15.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(229,20,1,6.0,2.5,9.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(230,20,2,6.0,2.5,9.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(231,20,3,8.0,4.0,12.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(232,20,4,12.0,8.0,16.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(233,20,5,17.0,13.0,21.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(234,20,6,22.0,17.5,26.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(235,20,7,25.0,20.0,30.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(236,20,8,25.0,20.0,30.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(237,20,9,21.0,16.5,25.5,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(238,20,10,16.0,12.0,20.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(239,20,11,12.0,8.0,16.0,'2026-05-05 15:15:06','2026-05-05 15:15:06'),(240,20,12,8.0,4.0,12.0,'2026-05-05 15:15:06','2026-05-05 15:15:06');
/*!40000 ALTER TABLE `monthly_weather` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `search_destination`
--

DROP TABLE IF EXISTS `search_destination`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_destination` (
  `search_id` bigint(20) unsigned NOT NULL,
  `destination_id` bigint(20) unsigned NOT NULL,
  `score` smallint(5) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`search_id`,`destination_id`),
  KEY `search_destination_destination_id_foreign` (`destination_id`),
  KEY `search_destination_score_index` (`score`),
  CONSTRAINT `search_destination_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `search_destination_search_id_foreign` FOREIGN KEY (`search_id`) REFERENCES `searches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search_destination`
--

LOCK TABLES `search_destination` WRITE;
/*!40000 ALTER TABLE `search_destination` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_destination` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `search_type`
--

DROP TABLE IF EXISTS `search_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_type` (
  `search_id` bigint(20) unsigned NOT NULL,
  `destination_type_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`search_id`,`destination_type_id`),
  KEY `search_type_destination_type_id_foreign` (`destination_type_id`),
  CONSTRAINT `search_type_destination_type_id_foreign` FOREIGN KEY (`destination_type_id`) REFERENCES `destination_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `search_type_search_id_foreign` FOREIGN KEY (`search_id`) REFERENCES `searches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search_type`
--

LOCK TABLES `search_type` WRITE;
/*!40000 ALTER TABLE `search_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `searches`
--

DROP TABLE IF EXISTS `searches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `searches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `destination_id` bigint(20) unsigned DEFAULT NULL,
  `month` tinyint(3) unsigned DEFAULT NULL,
  `duration_days` smallint(5) unsigned NOT NULL,
  `temperature_preference` varchar(255) NOT NULL,
  `distance_preference` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `searches_destination_id_foreign` (`destination_id`),
  KEY `searches_month_index` (`month`),
  KEY `searches_temperature_preference_index` (`temperature_preference`),
  KEY `searches_distance_preference_index` (`distance_preference`),
  CONSTRAINT `searches_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `searches`
--

LOCK TABLES `searches` WRITE;
/*!40000 ALTER TABLE `searches` DISABLE KEYS */;
/*!40000 ALTER TABLE `searches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `visitor_hash` char(64) NOT NULL,
  `time_period` enum('morning','afternoon','evening','night') NOT NULL,
  `is_unique` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visits_visitor_hash_index` (`visitor_hash`),
  KEY `visits_time_period_index` (`time_period`),
  KEY `visits_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits`
--

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
/*!40000 ALTER TABLE `visits` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-05 17:15:20
