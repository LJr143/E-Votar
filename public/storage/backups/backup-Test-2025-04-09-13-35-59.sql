-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: evotar
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `backup_files`
--

DROP TABLE IF EXISTS `backup_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `backup_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `backup_schedule_id` bigint unsigned NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `backup_files_backup_schedule_id_foreign` (`backup_schedule_id`),
  KEY `backup_files_created_by_foreign` (`created_by`),
  CONSTRAINT `backup_files_backup_schedule_id_foreign` FOREIGN KEY (`backup_schedule_id`) REFERENCES `backup_schedules` (`id`) ON DELETE CASCADE,
  CONSTRAINT `backup_files_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_files`
--

LOCK TABLES `backup_files` WRITE;
/*!40000 ALTER TABLE `backup_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `backup_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup_schedules`
--

DROP TABLE IF EXISTS `backup_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `backup_schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_parameters` json DEFAULT NULL,
  `next_backup_at` timestamp NULL DEFAULT NULL,
  `last_backup_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `backup_schedules_name_unique` (`name`),
  KEY `backup_schedules_created_by_foreign` (`created_by`),
  CONSTRAINT `backup_schedules_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_schedules`
--

LOCK TABLES `backup_schedules` WRITE;
/*!40000 ALTER TABLE `backup_schedules` DISABLE KEYS */;
INSERT INTO `backup_schedules` VALUES (5,'Test','daily','\"[]\"','2025-04-09 16:00:00',NULL,2,'2025-04-09 05:35:54','2025-04-09 05:35:54');
/*!40000 ALTER TABLE `backup_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:26:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:13:\"view election\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:15:\"create election\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:13:\"edit election\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"delete election\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:21:\"view election results\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:15:\"view vote tally\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:16:\"create candidate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:14:\"edit candidate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:16:\"delete candidate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:14:\"view candidate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"view party list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"create party list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:15:\"edit party list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:17:\"delete party list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:10:\"view voter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:12:\"create voter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:10:\"edit voter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:12:\"delete voter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:10:\"view users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:12:\"create users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:10:\"edit users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"delete users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:16:\"view system logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:18:\"create system logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:16:\"edit system logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:18:\"delete system logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"superadmin\";s:1:\"c\";s:3:\"web\";}}}',1744261808);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
-- Table structure for table `campuses`
--

DROP TABLE IF EXISTS `campuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `campuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campuses`
--

LOCK TABLES `campuses` WRITE;
/*!40000 ALTER TABLE `campuses` DISABLE KEYS */;
INSERT INTO `campuses` VALUES (1,'Obrero-Main Campus',NULL,NULL),(2,'Tagum Unit',NULL,NULL),(3,'Mabini Unit',NULL,NULL),(4,'Mintal Campus',NULL,NULL),(5,'Malabog Extension Campus',NULL,NULL);
/*!40000 ALTER TABLE `campuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `candidates`
--

DROP TABLE IF EXISTS `candidates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `candidates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `election_id` bigint unsigned NOT NULL,
  `election_position_id` bigint unsigned NOT NULL,
  `party_list_id` bigint unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidates_user_id_foreign` (`user_id`),
  KEY `candidates_election_id_foreign` (`election_id`),
  KEY `candidates_election_position_id_foreign` (`election_position_id`),
  KEY `candidates_party_list_id_foreign` (`party_list_id`),
  CONSTRAINT `candidates_election_id_foreign` FOREIGN KEY (`election_id`) REFERENCES `elections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `candidates_election_position_id_foreign` FOREIGN KEY (`election_position_id`) REFERENCES `election_positions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `candidates_party_list_id_foreign` FOREIGN KEY (`party_list_id`) REFERENCES `party_lists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `candidates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidates`
--

LOCK TABLES `candidates` WRITE;
/*!40000 ALTER TABLE `candidates` DISABLE KEYS */;
/*!40000 ALTER TABLE `candidates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colleges`
--

DROP TABLE IF EXISTS `colleges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colleges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `campus_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `colleges_campus_id_foreign` (`campus_id`),
  CONSTRAINT `colleges_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colleges`
--

LOCK TABLES `colleges` WRITE;
/*!40000 ALTER TABLE `colleges` DISABLE KEYS */;
INSERT INTO `colleges` VALUES (1,2,'College of Agricultural and Bio-systems Engineering',NULL,NULL),(2,2,'College of Teacher Education and Technology',NULL,NULL),(3,2,'College of Engineering',NULL,NULL),(4,1,'College of Engineering',NULL,NULL),(5,1,'College of Information and Computing',NULL,NULL);
/*!40000 ALTER TABLE `colleges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `council_position_settings`
--

DROP TABLE IF EXISTS `council_position_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `council_position_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `council_id` bigint unsigned NOT NULL,
  `position_id` bigint unsigned NOT NULL,
  `separate_by_major` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `council_position_settings_council_id_foreign` (`council_id`),
  KEY `council_position_settings_position_id_foreign` (`position_id`),
  CONSTRAINT `council_position_settings_council_id_foreign` FOREIGN KEY (`council_id`) REFERENCES `councils` (`id`),
  CONSTRAINT `council_position_settings_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `council_position_settings`
--

LOCK TABLES `council_position_settings` WRITE;
/*!40000 ALTER TABLE `council_position_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `council_position_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `councils`
--

DROP TABLE IF EXISTS `councils`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `councils` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `councils`
--

LOCK TABLES `councils` WRITE;
/*!40000 ALTER TABLE `councils` DISABLE KEYS */;
INSERT INTO `councils` VALUES (1,'Society of Information Technology Students',NULL,NULL),(2,'Society of Agricultural and Bio-systems Engineering',NULL,NULL),(3,'Association of Future Secondary Education Teachers',NULL,NULL),(4,'Association of Early Childhood Education Students',NULL,NULL),(5,'Future Technical Vocational Education Teachers',NULL,NULL),(6,'Organization of Future Special Needs Education Teachers',NULL,NULL),(7,'Organization of Future Elementary Education Teachers',NULL,NULL);
/*!40000 ALTER TABLE `councils` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `election_excluded_voters`
--

DROP TABLE IF EXISTS `election_excluded_voters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `election_excluded_voters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `election_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `election_excluded_voters_user_id_foreign` (`user_id`),
  KEY `election_excluded_voters_election_id_foreign` (`election_id`),
  CONSTRAINT `election_excluded_voters_election_id_foreign` FOREIGN KEY (`election_id`) REFERENCES `elections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `election_excluded_voters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `election_excluded_voters`
--

LOCK TABLES `election_excluded_voters` WRITE;
/*!40000 ALTER TABLE `election_excluded_voters` DISABLE KEYS */;
/*!40000 ALTER TABLE `election_excluded_voters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `election_positions`
--

DROP TABLE IF EXISTS `election_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `election_positions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `election_id` bigint unsigned NOT NULL,
  `position_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `election_positions_election_id_foreign` (`election_id`),
  KEY `election_positions_position_id_foreign` (`position_id`),
  CONSTRAINT `election_positions_election_id_foreign` FOREIGN KEY (`election_id`) REFERENCES `elections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `election_positions_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `election_positions`
--

LOCK TABLES `election_positions` WRITE;
/*!40000 ALTER TABLE `election_positions` DISABLE KEYS */;
INSERT INTO `election_positions` VALUES (1,1,1,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(2,1,2,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(3,1,3,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(4,1,4,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(5,1,5,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(6,1,6,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(7,1,7,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(8,1,8,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(9,1,9,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(10,1,10,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(11,1,11,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(12,1,12,'2025-04-06 18:35:54','2025-04-06 18:35:54'),(15,2,1,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(16,2,2,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(17,2,3,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(18,2,4,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(19,2,5,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(20,2,6,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(21,2,7,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(22,2,8,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(23,2,9,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(24,2,10,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(25,2,11,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(26,2,12,'2025-04-08 17:01:37','2025-04-08 17:01:37'),(29,3,1,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(30,3,2,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(31,3,3,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(32,3,4,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(33,3,5,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(34,3,6,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(35,3,7,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(36,3,8,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(37,3,9,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(38,3,10,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(39,3,11,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(40,3,12,'2025-04-08 17:08:13','2025-04-08 17:08:13'),(43,4,1,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(44,4,2,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(45,4,3,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(46,4,4,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(47,4,5,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(48,4,6,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(49,4,7,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(50,4,8,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(51,4,9,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(52,4,10,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(53,4,11,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(54,4,12,'2025-04-08 17:11:06','2025-04-08 17:11:06'),(57,5,1,'2025-04-08 17:15:03','2025-04-08 17:15:03'),(58,5,2,'2025-04-08 17:15:03','2025-04-08 17:15:03'),(59,5,3,'2025-04-08 17:15:03','2025-04-08 17:15:03'),(60,5,4,'2025-04-08 17:15:03','2025-04-08 17:15:03'),(61,5,5,'2025-04-08 17:15:04','2025-04-08 17:15:04'),(62,5,6,'2025-04-08 17:15:04','2025-04-08 17:15:04'),(63,5,7,'2025-04-08 17:15:04','2025-04-08 17:15:04'),(64,5,8,'2025-04-08 17:15:04','2025-04-08 17:15:04'),(65,5,9,'2025-04-08 17:15:04','2025-04-08 17:15:04'),(66,5,10,'2025-04-08 17:15:04','2025-04-08 17:15:04'),(67,5,11,'2025-04-08 17:15:04','2025-04-08 17:15:04'),(68,5,12,'2025-04-08 17:15:04','2025-04-08 17:15:04'),(71,6,1,'2025-04-08 17:19:07','2025-04-08 17:19:07'),(72,6,2,'2025-04-08 17:19:07','2025-04-08 17:19:07'),(73,6,3,'2025-04-08 17:19:08','2025-04-08 17:19:08'),(74,6,4,'2025-04-08 17:19:08','2025-04-08 17:19:08'),(75,6,5,'2025-04-08 17:19:08','2025-04-08 17:19:08'),(76,6,6,'2025-04-08 17:19:08','2025-04-08 17:19:08'),(77,6,7,'2025-04-08 17:19:08','2025-04-08 17:19:08'),(78,6,8,'2025-04-08 17:19:08','2025-04-08 17:19:08'),(79,6,9,'2025-04-08 17:19:08','2025-04-08 17:19:08'),(80,6,10,'2025-04-08 17:19:08','2025-04-08 17:19:08'),(81,6,11,'2025-04-08 17:19:08','2025-04-08 17:19:08'),(82,6,12,'2025-04-08 17:19:08','2025-04-08 17:19:08'),(85,7,1,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(86,7,2,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(87,7,3,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(88,7,4,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(89,7,5,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(90,7,6,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(91,7,7,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(92,7,8,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(93,7,9,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(94,7,10,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(95,7,11,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(96,7,12,'2025-04-08 17:20:12','2025-04-08 17:20:12'),(99,8,1,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(100,8,2,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(101,8,3,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(102,8,4,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(103,8,5,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(104,8,6,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(105,8,7,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(106,8,8,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(107,8,9,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(108,8,10,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(109,8,11,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(110,8,12,'2025-04-08 17:21:43','2025-04-08 17:21:43'),(113,9,1,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(114,9,2,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(115,9,3,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(116,9,4,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(117,9,5,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(118,9,6,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(119,9,7,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(120,9,8,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(121,9,9,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(122,9,10,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(123,9,11,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(124,9,12,'2025-04-08 17:23:08','2025-04-08 17:23:08'),(127,10,1,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(128,10,2,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(129,10,3,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(130,10,4,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(131,10,5,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(132,10,6,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(133,10,7,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(134,10,8,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(135,10,9,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(136,10,10,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(137,10,11,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(138,10,12,'2025-04-08 17:24:42','2025-04-08 17:24:42'),(141,11,1,'2025-04-08 17:28:46','2025-04-08 17:28:46'),(142,11,2,'2025-04-08 17:28:46','2025-04-08 17:28:46'),(143,11,3,'2025-04-08 17:28:46','2025-04-08 17:28:46'),(144,11,4,'2025-04-08 17:28:46','2025-04-08 17:28:46'),(145,11,5,'2025-04-08 17:28:46','2025-04-08 17:28:46'),(146,11,6,'2025-04-08 17:28:47','2025-04-08 17:28:47'),(147,11,7,'2025-04-08 17:28:47','2025-04-08 17:28:47'),(148,11,8,'2025-04-08 17:28:47','2025-04-08 17:28:47'),(149,11,9,'2025-04-08 17:28:47','2025-04-08 17:28:47'),(150,11,10,'2025-04-08 17:28:47','2025-04-08 17:28:47'),(151,11,11,'2025-04-08 17:28:47','2025-04-08 17:28:47'),(152,11,12,'2025-04-08 17:28:47','2025-04-08 17:28:47'),(155,12,1,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(156,12,2,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(157,12,3,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(158,12,4,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(159,12,5,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(160,12,6,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(161,12,7,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(162,12,8,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(163,12,9,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(164,12,10,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(165,12,11,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(166,12,12,'2025-04-08 17:31:06','2025-04-08 17:31:06'),(169,13,1,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(170,13,2,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(171,13,3,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(172,13,4,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(173,13,5,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(174,13,6,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(175,13,7,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(176,13,8,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(177,13,9,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(178,13,10,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(179,13,11,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(180,13,12,'2025-04-08 17:33:29','2025-04-08 17:33:29'),(183,14,1,'2025-04-08 17:35:01','2025-04-08 17:35:01'),(184,14,2,'2025-04-08 17:35:01','2025-04-08 17:35:01'),(185,14,3,'2025-04-08 17:35:01','2025-04-08 17:35:01'),(186,14,4,'2025-04-08 17:35:01','2025-04-08 17:35:01'),(187,14,5,'2025-04-08 17:35:01','2025-04-08 17:35:01'),(188,14,6,'2025-04-08 17:35:01','2025-04-08 17:35:01'),(189,14,7,'2025-04-08 17:35:01','2025-04-08 17:35:01'),(190,14,8,'2025-04-08 17:35:01','2025-04-08 17:35:01'),(191,14,9,'2025-04-08 17:35:01','2025-04-08 17:35:01'),(192,14,10,'2025-04-08 17:35:01','2025-04-08 17:35:01'),(193,14,11,'2025-04-08 17:35:01','2025-04-08 17:35:01'),(194,14,12,'2025-04-08 17:35:01','2025-04-08 17:35:01');
/*!40000 ALTER TABLE `election_positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `election_types`
--

DROP TABLE IF EXISTS `election_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `election_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `election_types`
--

LOCK TABLES `election_types` WRITE;
/*!40000 ALTER TABLE `election_types` DISABLE KEYS */;
INSERT INTO `election_types` VALUES (1,'Student and Local Council Election',NULL,NULL),(2,'Student Council Election',NULL,NULL),(3,'Local Council Election',NULL,NULL),(4,'Special Election',NULL,NULL);
/*!40000 ALTER TABLE `election_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elections`
--

DROP TABLE IF EXISTS `elections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `elections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` bigint unsigned NOT NULL,
  `campus_id` bigint unsigned NOT NULL,
  `date_started` timestamp NULL DEFAULT NULL,
  `date_ended` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `elections_slug_unique` (`slug`),
  KEY `elections_type_foreign` (`type`),
  KEY `elections_campus_id_foreign` (`campus_id`),
  CONSTRAINT `elections_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`),
  CONSTRAINT `elections_type_foreign` FOREIGN KEY (`type`) REFERENCES `election_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elections`
--

LOCK TABLES `elections` WRITE;
/*!40000 ALTER TABLE `elections` DISABLE KEYS */;
INSERT INTO `elections` VALUES (1,'Student and Local Council Election 2025','student-and-local-council-election-2025-67f2c98a01a2a',1,2,'2025-04-06 18:35:00','2025-04-18 18:35:00','ongoing','elections/images/ReSbSvFT4qUe9htzpAO6VdrdstSEtTspoKlcRZzB.png','2025-04-06 18:35:54','2025-04-06 18:35:54'),(2,'Student and Local Council Election 2026','student-and-local-council-election-2026-67f556717bb58',1,2,'2025-04-08 17:01:00','2025-04-10 17:01:00','ongoing','elections/images/HH9QuY9yB0MkPC6VQoH4Vv7MtRanr4r1LH8tTxPl.jpg','2025-04-08 17:01:37','2025-04-08 17:01:37'),(3,'Student and Local Council Election 2027','student-and-local-council-election-2027-67f557fd7af35',1,2,'2025-04-08 17:07:00','2025-04-09 17:07:00','ongoing','elections/images/JVeca9XOd5eGb7BkB2VpXgdQfBs17rrrQZTI0hAG.jpg','2025-04-08 17:08:13','2025-04-08 17:08:13'),(4,'Student and Local Council Election 2028','student-and-local-council-election-2028-67f558aa38ffe',1,2,'2025-04-08 17:10:00','2025-04-09 17:10:00','ongoing','elections/images/MbVZMN1r1dGd71wuC9b6fxQCNTQOqHxMtPEDGPvu.jpg','2025-04-08 17:11:06','2025-04-08 17:11:06'),(5,'Student and Local Council Election 2029','student-and-local-council-election-2029-67f55997dd422',1,2,'2025-04-08 17:14:00','2025-04-10 17:14:00','ongoing','elections/images/uw99ZjbYQcz3QQmau5n5dmb9TUTDg0XjNtQYngKl.jpg','2025-04-08 17:15:03','2025-04-08 17:15:03'),(6,'Student and Local Council Election 2030','student-and-local-council-election-2030-67f55a8be1a04',1,2,'2025-04-08 17:18:00','2025-04-09 17:18:00','ongoing','elections/images/90cWwXBgUiYuVBOiEoHV0e5iR15g6RlZMkqaR4t7.jpg','2025-04-08 17:19:07','2025-04-08 17:19:07'),(7,'Student and Local Council Election 2040','student-and-local-council-election-2040-67f55acc5d636',1,2,'2025-04-08 17:20:00','2025-04-09 17:20:00','ongoing','elections/images/ho9IHexsxbi4LLsnUaqVGdZUXb3UcTAgunvNcRZz.jpg','2025-04-08 17:20:12','2025-04-08 17:20:12'),(8,'Student and Local Council Election 2045','student-and-local-council-election-2045-67f55b27a34ac',1,2,'2025-04-08 17:21:00','2025-04-09 17:21:00','ongoing','elections/images/VHWTdQnDqJBNY7P5eIQpJK98BiHzDboXZKkId9bt.jpg','2025-04-08 17:21:43','2025-04-08 17:21:43'),(9,'Student and Local Council Election 2090','student-and-local-council-election-2090-67f55b7cb6b34',1,2,'2025-04-08 17:23:00','2025-04-09 17:23:00','ongoing','elections/images/YwUkA2Iaqdv7wyilYU9IJwLpkLXPomwa2ckesyMp.jpg','2025-04-08 17:23:08','2025-04-08 17:23:08'),(10,'Student and Local Council Election 2046','student-and-local-council-election-2046-67f55bda8ae85',1,2,'2025-04-08 17:24:00','2025-04-16 17:24:00','ongoing','elections/images/kMu3yDqCTl2D2M1t7vbuF8717tuilVEJkK5ads72.jpg','2025-04-08 17:24:42','2025-04-08 17:24:42'),(11,'Student and Local Council Election 2047','student-and-local-council-election-2047-67f55cced39f6',1,2,'2025-04-08 17:28:00','2025-04-13 17:28:00','ongoing','elections/images/DC4UZKBtexzcKH1CmmQoTAB3wbIR7EQHeAx1quFH.jpg','2025-04-08 17:28:46','2025-04-08 17:28:46'),(12,'Student and Local Council Election 2048','student-and-local-council-election-2048-67f55d5a77b89',1,2,'2025-04-08 17:30:00','2025-04-13 17:30:00','ongoing','elections/images/DHHWQxzca8XvZL0dUNkwC7mrXuzXeznZJDy3f8pX.jpg','2025-04-08 17:31:06','2025-04-08 17:31:06'),(13,'Student and Local Council Election 2039','student-and-local-council-election-2039-67f55de916541',1,2,'2025-04-08 17:33:00','2025-04-13 17:33:00','ongoing','elections/images/SaS1OnYyLyfsOHsEaX77JsUAhoTCQB19d1svjOgF.jpg','2025-04-08 17:33:29','2025-04-08 17:33:29'),(14,'Student and Local Council Election 2098','student-and-local-council-election-2098-67f55e451db85',1,2,'2025-04-08 17:34:00','2025-04-09 17:34:00','ongoing','elections/images/Tt76iGMtcR4FjRtHCR4zcanF8cI3WdbdF6Qw5wxU.jpg','2025-04-08 17:35:01','2025-04-08 17:35:01');
/*!40000 ALTER TABLE `elections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `face_data`
--

DROP TABLE IF EXISTS `face_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `face_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `angle` tinyint NOT NULL COMMENT '0=front, 1=left, 2=right, 3=up, 4=down',
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quality_score` decimal(5,2) NOT NULL,
  `descriptor` json NOT NULL COMMENT 'Face descriptor data for recognition',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `face_data_user_id_index` (`user_id`),
  CONSTRAINT `face_data_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `face_data`
--

LOCK TABLES `face_data` WRITE;
/*!40000 ALTER TABLE `face_data` DISABLE KEYS */;
INSERT INTO `face_data` VALUES (105,172,1,'faces/face_1744087454_8r7eSov39y.jpg',100.00,'[-0.15900301933288574, 0.146482452750206, 0.05371257662773132, -0.09421712160110474, -0.11724334210157394, -0.03984815999865532, -0.06499582529067993, -0.11675180494785307, 0.14782975614070892, -0.07592654228210449, 0.2398625612258911, -0.0814681425690651, -0.21603775024414065, -0.20112791657447815, 0.022938434034585953, 0.1781511753797531, -0.16026867926120758, -0.15077640116214752, -0.041572920978069305, -0.05910719186067581, 0.0724417194724083, -0.01339070126414299, 0.045854438096284866, 0.06867596507072449, -0.1900695115327835, -0.3636811077594757, -0.1112508550286293, -0.0769699215888977, -0.07186847180128098, -0.0625004991889, -0.1191738024353981, 0.060799308121204376, -0.19346082210540771, -0.1075439155101776, 0.02345462515950203, 0.13889533281326294, -0.004479409195482731, -0.02160762250423431, 0.13206130266189575, -0.020973801612854004, -0.16670136153697968, -0.04731243848800659, 0.08827988058328629, 0.2499196231365204, 0.20706495642662048, 0.005480255000293255, 0.056849729269742966, -0.026646433398127556, 0.1148243099451065, -0.1475471407175064, 0.03821764513850212, 0.14257097244262695, 0.10610459744930267, 0.05357028543949127, 0.04727859050035477, -0.11685186624526978, 0.01902005821466446, 0.1087687611579895, -0.09238872677087784, -0.009313533082604408, 0.06701864302158356, -0.14129909873008728, -0.08351173251867294, -0.039123497903347015, 0.26838693022727966, 0.11713049560785294, -0.1008227989077568, -0.17196305096149445, 0.1464255154132843, -0.06579659879207611, -0.06745152920484543, 0.05850350484251976, -0.20231278240680697, -0.13805563747882843, -0.34849804639816284, 0.018866363912820816, 0.4132442772388458, 0.08884548395872116, -0.2723708152770996, -0.0051106614992022514, -0.08325919508934021, 0.04374314844608307, 0.11591137200593948, 0.1121027022600174, -0.04606936499476433, 0.10123410820961, -0.19273774325847623, 0.05097753554582596, 0.2019539475440979, -0.06184838339686394, -0.05108243599534035, 0.1988588720560074, 0.06811174005270004, 0.11516676843166351, 0.09578727185726166, 0.022234393283724785, -0.061419449746608734, -0.03223269432783127, -0.16760076582431793, -0.0003629927523434162, 0.06389477849006653, -0.05517273396253586, -0.05615159124135971, 0.1061405912041664, -0.10275713354349136, 0.1083432212471962, 0.05277125909924507, 0.03033341094851494, -0.13061116635799408, -0.02460130862891674, -0.08278662711381912, -0.06954445689916611, 0.09217728674411774, -0.19469912350177765, 0.10084835439920424, 0.1578313410282135, 0.004655607510358095, 0.16002514958381653, 0.0917176827788353, 0.07621245831251144, -0.03798219934105873, -0.035710010677576065, -0.08434507995843887, -0.03369785472750664, 0.08821843564510345, -0.0038254880346357822, 0.12981733679771423, 0.032524120062589645]','2025-04-08 04:44:17','2025-04-08 04:44:17'),(106,172,2,'faces/face_1744087457_srdAWbuaUV.jpg',100.00,'[-0.1444849669933319, 0.13130468130111694, 0.07340927422046661, -0.1063779443502426, -0.09940244257450104, -0.10449402779340744, -0.031004425138235092, -0.1521114856004715, 0.11521250009536745, -0.10984013229608536, 0.2750560939311981, -0.04729751497507095, -0.1892031282186508, -0.22030210494995117, 0.030616559088230133, 0.1745717227458954, -0.13351154327392578, -0.204710453748703, -0.04387295991182327, -0.07360957562923431, 0.052581626921892166, -0.025287926197052, 0.017121654003858566, 0.061766330152750015, -0.15995654463768005, -0.32332149147987366, -0.1260298788547516, -0.06168859452009201, -0.052642397582530975, -0.07793500274419785, -0.05039984732866287, 0.07182340323925018, -0.2228294014930725, -0.07305970042943954, -0.005987720564007759, 0.07768803834915161, -0.003917977213859558, -0.004975245334208012, 0.1492593139410019, -0.0030098995193839073, -0.19021514058113095, -0.05118006095290184, 0.07747896760702133, 0.23715731501579285, 0.20306849479675293, -0.005956684239208698, 0.04587281495332718, -0.03195231407880783, 0.08771379292011261, -0.1183214858174324, 0.007880866527557373, 0.13614612817764282, 0.10822635143995284, 0.05249730870127678, 0.023377615958452225, -0.11057185381650925, 0.03656782954931259, 0.07016461342573166, -0.0970904603600502, -0.008404064923524857, 0.062033288180828094, -0.179690882563591, -0.08942645788192749, -0.03196878358721733, 0.271901398897171, 0.06899737566709518, -0.08763229846954346, -0.1652573049068451, 0.1739223599433899, -0.07717964798212051, -0.1002432331442833, 0.0715722069144249, -0.19117623567581177, -0.11126179993152618, -0.3474622070789337, 0.04282272607088089, 0.36696428060531616, 0.06791108846664429, -0.23024646937847135, 0.03392794355750084, -0.0668129101395607, 0.04494311660528183, 0.08092367649078369, 0.08693927526473999, -0.0823729857802391, 0.08969355374574661, -0.17864534258842468, 0.05003412067890167, 0.2092547118663788, -0.0383339487016201, -0.046814870089292526, 0.18529242277145383, 0.007718202192336321, 0.12319041043519974, 0.08221377432346344, 0.00737539492547512, -0.036775141954422, -0.009036129340529442, -0.1338934749364853, 0.010390039533376694, 0.07757063955068588, -0.06756749749183655, -0.045637406408786774, 0.12630657851696014, -0.09788227081298828, 0.10348140448331831, 0.0252540186047554, 0.03967798873782158, -0.13821427524089813, 0.011878667399287224, -0.08178003132343292, -0.07187385857105255, 0.057500652968883514, -0.16098034381866455, 0.17620450258255005, 0.1696026474237442, 0.014750474132597446, 0.10612630844116212, 0.1164836585521698, 0.054479796439409256, -0.06667495518922806, -0.04972255229949951, -0.10085292160511015, -0.028054632246494293, 0.1177479326725006, -0.03619866073131561, 0.15091504156589508, 0.03189380094408989]','2025-04-08 04:44:17','2025-04-08 04:44:17'),(107,172,3,'faces/face_1744087457_vhVCeVNNOA.jpg',100.00,'[-0.17687000334262848, 0.12175025045871736, 0.09514393657445908, -0.10628385096788406, -0.0775175541639328, -0.07655216753482819, -0.016428520902991295, -0.113638773560524, 0.17685337364673617, -0.13065072894096377, 0.21147720515727997, 0.0025576199404895306, -0.18544024229049683, -0.18162865936756137, 0.02362890727818012, 0.1338863968849182, -0.12679550051689148, -0.21677960455417633, -0.06390677392482758, -0.07080462574958801, 0.059979259967803955, 0.008916799910366535, 0.0240838211029768, 0.05030154809355736, -0.10815145075321198, -0.33317023515701294, -0.18611767888069153, -0.1132921501994133, -0.020037470385432243, -0.090657539665699, -0.05934477224946022, -0.01127905398607254, -0.19730879366397855, -0.07986253499984741, -0.06375070661306381, 0.02578859217464924, -0.00989329256117344, -0.02712208218872547, 0.14063934981822968, 0.024983467534184456, -0.2034054398536682, -0.06832379847764969, 0.0485285222530365, 0.221551775932312, 0.1944311559200287, 0.03746190294623375, 0.020908046513795853, -0.00967351160943508, 0.04019295796751976, -0.16637246310710907, 0.06962733715772629, 0.14365020394325256, 0.14948846399784088, 0.04967174679040909, 0.0511678010225296, -0.15550199151039124, 0.01423194259405136, 0.033905334770679474, -0.14455832540988922, 0.03802647814154625, 0.004616330843418837, -0.1423414945602417, -0.0989973396062851, 0.02311205491423607, 0.26943084597587585, 0.15778429806232452, -0.08120932430028915, -0.1778092384338379, 0.21002455055713656, -0.15403638780117035, -0.07092215865850449, 0.0844106525182724, -0.16991271078586578, -0.1297118216753006, -0.31633058190345764, 0.03680857643485069, 0.3869931101799011, 0.08984257280826569, -0.21569478511810303, 0.02542652189731598, -0.1444992572069168, 0.03915286809206009, 0.031884171068668365, 0.09106984734535216, -0.14124029874801636, 0.1161663979291916, -0.16932272911071777, -0.003531975671648979, 0.16312681138515472, -0.024980846792459488, -0.08040061593055725, 0.21274717152118683, 0.03231994807720184, 0.09585237503051758, 0.10920798033475876, 0.013110832311213017, -0.005435837432742119, -0.07823328673839569, -0.1278161257505417, -0.028637293726205822, 0.07122616469860077, -0.08956938236951828, -0.0902751237154007, 0.1127168983221054, -0.12522582709789276, 0.0949510857462883, 0.035936955362558365, -0.01948320679366589, -0.14269818365573883, 0.020681239664554596, -0.10130561888217926, -0.10024332255125046, 0.11143829673528673, -0.17027458548545835, 0.14226606488227844, 0.20209082961082456, -0.01768406294286251, 0.1593751460313797, 0.10519421100616456, 0.08686649799346924, -0.06345906853675842, -0.07525409013032913, -0.08642833679914474, -0.026792850345373154, 0.09932216256856918, -0.019273634999990463, 0.10582731664180756, 0.06584387272596359]','2025-04-08 04:44:17','2025-04-08 04:44:17'),(108,172,4,'faces/face_1744087457_QOfX43DnCK.jpg',100.00,'[-0.1387016922235489, 0.17689768970012665, 0.04752693325281143, -0.0848698541522026, -0.08662698417901993, -0.07836487144231796, -0.058897752314805984, -0.10013537108898164, 0.1831802129745483, -0.1045546755194664, 0.2126103788614273, -0.03998330608010292, -0.2025241255760193, -0.1282004714012146, 0.017198938876390457, 0.1594620645046234, -0.15793339908123016, -0.15439201891422272, -0.03311410918831825, -0.05570182204246521, 0.06347811222076416, -0.0076529462821781635, 0.033328235149383545, 0.07662373036146164, -0.12817350029945374, -0.3469679653644562, -0.12899257242679596, -0.05627729371190071, -0.03994522988796234, -0.07190927863121033, -0.10035649687051772, 0.059323862195014954, -0.19930563867092133, -0.11094534397125244, 0.02032342366874218, 0.12844718992710114, 0.0006408514454960823, 0.004783293232321739, 0.1677221953868866, 0.008267044089734554, -0.15593653917312622, -0.06087145581841469, 0.05010133981704712, 0.2865397334098816, 0.1884869635105133, 0.03113049454987049, 0.045644596219062805, 0.010666673071682451, 0.07903716713190079, -0.12935692071914673, 0.03275296837091446, 0.15467984974384308, 0.14275436103343964, 0.06785893440246582, 0.034343842417001724, -0.12752553820610046, 0.02725272625684738, 0.107314333319664, -0.11906839162111282, 0.009644155390560629, 0.07955072820186615, -0.1538180261850357, -0.05000235140323639, -0.007084941025823355, 0.31408795714378357, 0.10010967403650284, -0.11585015803575516, -0.13573087751865387, 0.1673688441514969, -0.08602216094732285, -0.0631793737411499, 0.034218527376651764, -0.17271190881729126, -0.14392605423927307, -0.29143115878105164, 0.023141605779528614, 0.38315993547439575, 0.10770940035581587, -0.2532634139060974, 0.011879535391926764, -0.08068936318159103, 0.00749363424256444, 0.10099262744188307, 0.11228985339403152, -0.06473904103040695, 0.11607852578163148, -0.16230127215385437, 0.03705703467130661, 0.21230141818523407, -0.014616680331528189, -0.07642246782779694, 0.17631062865257263, 0.03272924944758415, 0.1002609133720398, 0.08043266832828522, -0.0010987194254994392, -0.036802973598241806, -0.04353327304124832, -0.17712682485580444, 0.011561870574951172, 0.011117213405668736, -0.0851169303059578, -0.10225810110569, 0.10338810086250304, -0.11754897981882095, 0.11485159397125244, 0.0478641614317894, 0.012923238798975945, -0.17425431311130524, 0.02115379273891449, -0.1168641448020935, -0.06443653255701065, 0.1104256883263588, -0.2081894725561142, 0.15938377380371094, 0.18022510409355164, -0.016719669103622437, 0.16462479531764984, 0.07181645929813385, 0.06934194266796112, 0.002001275308430195, -0.059205312281847, -0.08680350333452225, -0.08332324028015137, 0.09557318687438963, -0.017217598855495453, 0.1688055843114853, 0.03502100706100464]','2025-04-08 04:44:17','2025-04-08 04:44:17'),(109,172,5,'faces/face_1744087457_kp1cCtPwT7.jpg',100.00,'[-0.14635109901428223, 0.1347218006849289, 0.05347114801406861, -0.09448401629924774, -0.1094721332192421, -0.05034743994474411, -0.071998730301857, -0.12127427756786346, 0.13268247246742249, -0.08347421139478683, 0.22961071133613584, -0.06507833302021027, -0.21902112662792209, -0.2114994376897812, 0.012254184111952782, 0.17412467300891876, -0.1370871514081955, -0.17252890765666962, -0.041463449597358704, -0.04383307695388794, 0.08224890381097794, -0.02136298082768917, 0.04557657614350319, 0.05432489514350891, -0.1709185093641281, -0.3454384207725525, -0.1204455941915512, -0.06363757699728012, -0.06703173369169235, -0.05649293214082718, -0.12147995829582214, 0.05388757213950157, -0.19292739033699036, -0.10550856590270996, 0.027711747214198112, 0.12647895514965057, 0.006902920547872782, -0.014034681022167206, 0.12754586338996887, -0.02720859833061695, -0.1860397756099701, -0.03365439176559448, 0.09681202471256256, 0.23277711868286133, 0.21147078275680545, 0.01171812228858471, 0.0540698766708374, -0.056300755590200424, 0.11959998309612274, -0.15017399191856384, 0.05259881913661957, 0.14263616502285004, 0.11128076165914536, 0.06297677010297775, 0.03654462844133377, -0.1168656125664711, 0.028441939502954483, 0.1079757809638977, -0.08716937154531479, -0.004396010190248489, 0.06451554596424103, -0.13928036391735077, -0.08830247819423676, -0.04615054652094841, 0.24700097739696503, 0.1004173755645752, -0.10801989585161208, -0.1878674328327179, 0.1249987930059433, -0.0864216759800911, -0.0752774327993393, 0.07374779134988785, -0.19730710983276367, -0.12984874844551086, -0.3616914451122284, 0.017034467309713364, 0.4130815863609314, 0.0952974483370781, -0.2669273316860199, 0.0126327034085989, -0.08330459892749786, 0.0456833615899086, 0.11038734763860704, 0.11465313285589218, -0.04983454942703247, 0.10311955958604813, -0.1915683150291443, 0.031404100358486176, 0.20657220482826233, -0.06673549115657806, -0.05101069435477257, 0.19575445353984833, 0.06871646642684937, 0.14296306669712067, 0.0906222015619278, 0.043690115213394165, -0.05503259599208832, -0.0400322824716568, -0.16517274081707, -0.007427192758768797, 0.048804230988025665, -0.04963764175772667, -0.05711767449975014, 0.10136646777391434, -0.09454280138015748, 0.10992101579904556, 0.045455191284418106, 0.04488575831055641, -0.12059998512268066, -0.020969854667782784, -0.06826077401638031, -0.08204547315835953, 0.0705002099275589, -0.1875404268503189, 0.10065194964408876, 0.1630009114742279, 0.021101336926221848, 0.14602278172969818, 0.1126132234930992, 0.08209087699651718, -0.04244108498096466, -0.0392305925488472, -0.0827116146683693, -0.02825724519789219, 0.09354494512081146, -0.002760929986834526, 0.13063468039035797, 0.030480433255434036]','2025-04-08 04:44:17','2025-04-08 04:44:17'),(110,173,1,'faces/face_1744087997_7o2Vu6KAxe.jpg',100.00,'[-0.16882631182670593, 0.1444329470396042, 0.052118852734565735, -0.096222423017025, -0.1269122213125229, -0.06676038354635239, -0.05896521359682083, -0.11652853339910509, 0.14947375655174255, -0.0957258939743042, 0.2177889049053192, -0.0788717269897461, -0.21644453704357147, -0.1881761848926544, 0.031020499765872955, 0.18180181086063385, -0.15641532838344574, -0.1646442860364914, -0.05748175084590912, -0.05104260519146919, 0.07548895478248596, -0.03309103474020958, 0.024391207844018936, 0.08659378439188004, -0.16674649715423584, -0.39979997277259827, -0.12115145474672318, -0.07777919620275497, -0.05647661536931992, -0.06952129304409027, -0.11359980702400208, 0.035308849066495895, -0.19473810493946075, -0.08436547964811325, -0.019703131169080738, 0.12757092714309692, 0.008078307844698429, -0.030800817534327507, 0.12120915949344636, -0.011757969856262209, -0.19692718982696533, -0.06547892093658447, 0.06226347014307976, 0.24393820762634277, 0.2112252116203308, 0.0023854239843785763, 0.07089030742645264, -0.0052748629823327065, 0.10828515142202376, -0.14901860058307648, 0.02929873019456863, 0.13444784283638, 0.08349000662565231, 0.04742563143372536, 0.05253535136580467, -0.10299499332904816, -0.0026122871786355972, 0.1396058052778244, -0.1333978772163391, -0.011039036326110365, 0.0574834868311882, -0.14903001487255096, -0.0998985469341278, -0.06613919138908386, 0.2770957946777344, 0.13809125125408173, -0.10624610632658003, -0.155101016163826, 0.16963821649551392, -0.10353204607963562, -0.05474809929728508, 0.019722122699022293, -0.17864899337291718, -0.14355972409248352, -0.3383811116218567, 0.03489343822002411, 0.3949817717075348, 0.1143980473279953, -0.25016626715660095, 0.002753328997641802, -0.08598853647708893, 0.023455524817109108, 0.10941381752490996, 0.10702110081911088, -0.031581953167915344, 0.1124040260910988, -0.18251951038837433, 0.056939225643873215, 0.1853579133749008, -0.048218924552202225, -0.00032810564152896404, 0.208850160241127, 0.04191838577389717, 0.09239104390144348, 0.06837338209152222, 0.021787606179714203, -0.08519528061151505, -0.020938090980052948, -0.14769938588142395, 0.010054878890514374, 0.05560750141739845, -0.06056911870837211, -0.04804132506251335, 0.07723578065633774, -0.097574882209301, 0.10912667959928513, 0.050597578287124634, 0.02799964509904385, -0.13407665491104126, -0.030905261635780334, -0.07799665629863739, -0.08481404185295105, 0.09312395006418228, -0.18352892994880676, 0.10685022920370102, 0.1694440245628357, -0.003774063428863883, 0.17232076823711395, 0.07245887070894241, 0.0752134695649147, -0.03532494977116585, -0.06384599208831787, -0.10697218775749208, -0.01791355572640896, 0.10023074597120284, -0.01792433299124241, 0.11057879775762558, 0.03531363606452942]','2025-04-08 04:53:18','2025-04-08 04:53:18'),(111,173,2,'faces/face_1744087998_GQn8mb0CXM.jpg',100.00,'[-0.17381078004837036, 0.1253952980041504, 0.07895126193761826, -0.09058859944343568, -0.13234807550907135, -0.08482225239276886, -0.03202991932630539, -0.1225544884800911, 0.13025164604187012, -0.07878178358078003, 0.2532891035079956, -0.016102856025099754, -0.1393965780735016, -0.2283823937177658, 0.015222154557704926, 0.16672582924365997, -0.11954599618911745, -0.21960808336734772, -0.014831677079200745, -0.05564780533313751, 0.0728113055229187, -0.042985741049051285, 0.03406297415494919, 0.06649509817361832, -0.1466148942708969, -0.3439387083053589, -0.12333646416664124, -0.054577019065618515, -0.026908759027719498, -0.07814730703830719, -0.023295708000659943, 0.07072669267654419, -0.22861401736736295, -0.08481888473033905, -0.015698207542300224, 0.12631210684776306, -0.027607012540102005, -0.0008413027971982956, 0.15203890204429626, -0.013496989384293556, -0.20586229860782623, -0.047919195145368576, 0.05640227720141411, 0.2558435797691345, 0.18831022083759308, 0.02624097280204296, 0.047515083104372025, -0.02015272155404091, 0.06830030679702759, -0.1462445855140686, 0.05403677001595497, 0.16481076180934906, 0.08902168273925781, 0.027540603652596474, 0.045580457895994186, -0.099044568836689, 0.03702721744775772, 0.08059637993574142, -0.08141621202230453, -0.02746720425784588, 0.023375222459435463, -0.1337437480688095, -0.0644296184182167, -0.06948113441467285, 0.24564945697784424, 0.08176619559526443, -0.06929048895835876, -0.13845586776733398, 0.1569654643535614, -0.07039017975330353, -0.10675929486751556, 0.06243505701422691, -0.18353332579135895, -0.1252761036157608, -0.35829591751098633, 0.04321200028061867, 0.42078638076782227, 0.07468563318252563, -0.2174406498670578, 0.04360589012503624, -0.051935214549303055, 0.02788565307855606, 0.07268308848142624, 0.10224374383687972, -0.08401715755462646, 0.0889633521437645, -0.1791045069694519, 0.038895007222890854, 0.17391784489154816, -0.03564304858446121, -0.04044625535607338, 0.1593443751335144, 0.025689980015158653, 0.12735077738761902, 0.0691029354929924, 0.01237439550459385, -0.014511429704725742, 0.027140295132994652, -0.1399773359298706, -0.001348243560642004, 0.06582211703062057, -0.04296891391277313, -0.05273091793060303, 0.11497500538825987, -0.12184979766607285, 0.09952114522457124, 0.05160461738705635, 0.03438606858253479, -0.12825265526771543, 0.01578175090253353, -0.09208518266677856, -0.07562779635190964, 0.05967950448393822, -0.16640058159828186, 0.16727270185947418, 0.19718898832798004, -0.017900025472044945, 0.13879354298114777, 0.14294184744358063, 0.06432312726974487, -0.0460263267159462, -0.06089943647384643, -0.10122302174568176, -0.010146372951567171, 0.10166605561971664, -0.039584409445524216, 0.11047743260860445, 0.05736587196588516]','2025-04-08 04:53:18','2025-04-08 04:53:18'),(112,173,3,'faces/face_1744087998_lDBOpTa3PN.jpg',100.00,'[-0.17225584387779236, 0.12849120795726776, 0.10753224790096284, -0.06624235957860947, -0.06575456261634827, -0.06736237555742264, 0.006748408079147339, -0.09740067273378372, 0.16608068346977234, -0.14779168367385864, 0.23578055202960968, -0.02724249847233295, -0.19488562643527985, -0.1756080836057663, 0.03192826360464096, 0.15214595198631287, -0.13501489162445068, -0.24042926728725433, -0.06919033825397491, -0.06615444272756577, 0.07265239953994751, -0.02762828767299652, 0.007631766144186258, 0.030269097536802292, -0.11101310700178146, -0.3584214746952057, -0.1720944344997406, -0.06973717361688614, -0.00854202825576067, -0.07379802316427231, -0.06599138677120209, -0.028427869081497192, -0.24671301245689392, -0.0717313289642334, -0.06619606167078018, 0.045148588716983795, -0.03210384026169777, -0.05646877363324165, 0.15465402603149414, 0.010724946856498718, -0.212079718708992, -0.06244202330708504, 0.04019485414028168, 0.23138006031513217, 0.18621273338794708, 0.028750834986567497, 0.021262276917696, -0.00937515590339899, 0.027965331450104713, -0.15016791224479675, 0.058802638202905655, 0.15983237326145172, 0.1653861403465271, 0.05410819500684738, 0.03352437540888786, -0.1427602618932724, 0.01308782584965229, 0.05978243052959442, -0.09962654113769533, 0.002673218958079815, 0.003412823658436537, -0.1526002436876297, -0.07611881196498871, -0.0023074178025126457, 0.2628214359283447, 0.1103900820016861, -0.06606582552194595, -0.18675701320171356, 0.1946782022714615, -0.1272718459367752, -0.04890906438231468, 0.08083505183458328, -0.16289693117141724, -0.15005549788475037, -0.3100002706050873, 0.06213286891579628, 0.4070772528648377, 0.062449533492326736, -0.20287775993347168, 0.04928014054894447, -0.11347607523202896, 0.020531753078103065, 0.0609281100332737, 0.1228710040450096, -0.11210264265537262, 0.11348848044872284, -0.18706603348255155, 0.02756832167506218, 0.19201862812042236, -0.05435222014784813, -0.06914094090461731, 0.17759668827056885, 0.006278318352997303, 0.07119463384151459, 0.0839366465806961, -0.022457392886281013, 0.0015326868742704391, -0.010524878278374672, -0.10955961048603058, -0.008588449098169804, 0.07289954274892807, -0.08146786689758301, -0.11029002815485, 0.0910687819123268, -0.12789639830589294, 0.05986634269356728, 0.04072975739836693, -0.012390942312777042, -0.12260694056749344, -0.01240849867463112, -0.1141725704073906, -0.10001174360513689, 0.08491548150777817, -0.20539629459381104, 0.13849656283855438, 0.21476702392101288, -0.037491124123334885, 0.1640428900718689, 0.11699046194553377, 0.08989530056715012, -0.024687154218554497, -0.06142217665910721, -0.1344529390335083, -0.012520215474069118, 0.1110844686627388, -0.00078234588727355, 0.10540039837360382, 0.048134103417396545]','2025-04-08 04:53:18','2025-04-08 04:53:18'),(113,173,4,'faces/face_1744087998_KqQpslSOcM.jpg',100.00,'[-0.1470180302858353, 0.16763369739055634, 0.06354733556509018, -0.08096034824848175, -0.07457214593887329, -0.0776062086224556, -0.07257572561502457, -0.09672117978334428, 0.19212400913238523, -0.11170386523008348, 0.22169283032417297, -0.03712785616517067, -0.19758340716362, -0.1468881368637085, 0.02851325273513794, 0.15011915564537048, -0.17929363250732422, -0.15759533643722534, -0.02378062903881073, -0.058477044105529785, 0.06211627274751663, 0.00960015505552292, 0.03334346041083336, 0.056865446269512177, -0.1404755413532257, -0.394443154335022, -0.15371017158031464, -0.1001785174012184, -0.006961452774703503, -0.061582352966070175, -0.09482786804437636, 0.04530220478773117, -0.1829165518283844, -0.09482401609420776, -0.013900852762162684, 0.11545543372631072, 0.001229534624144435, -0.00585747417062521, 0.15222205221652985, 0.044945936650037766, -0.14941680431365967, -0.07681559026241302, 0.004322082735598087, 0.30408763885498047, 0.17808100581169128, 0.028649678453803062, 0.0433630496263504, 0.04764312505722046, 0.03911763429641723, -0.1453874409198761, 0.023517634719610218, 0.16102904081344604, 0.13388952612876892, 0.05663904920220375, 0.05468764901161194, -0.1310718059539795, 0.02315458655357361, 0.09227578341960908, -0.1795329600572586, -0.006215198431164026, 0.04306970164179802, -0.13813403248786926, -0.06620419025421143, 0.00438655773177743, 0.3379789888858795, 0.14289802312850952, -0.11952684819698334, -0.10837507247924805, 0.18907004594802856, -0.07324765622615814, -0.03364386409521103, 0.0032668737694621086, -0.1838594526052475, -0.14022007584571838, -0.27307820320129395, 0.04054732993245125, 0.3886396586894989, 0.07774848490953445, -0.24700871109962463, 0.01572009176015854, -0.0907961279153824, -0.01573045551776886, 0.08385790884494781, 0.0963175818324089, -0.07670076191425323, 0.1125367432832718, -0.15352989733219147, 0.04653007537126541, 0.14892332255840302, -0.028956467285752296, -0.04583935812115669, 0.17076660692691803, 0.004848143085837364, 0.08460885286331177, 0.0911400094628334, -0.006127214524894953, -0.05311525985598564, -0.03610154986381531, -0.1550368219614029, 0.013269709423184397, 0.03909962996840477, -0.0959509015083313, -0.10461440682411194, 0.09075425565242767, -0.10895997285842896, 0.11373919248580933, 0.07675754278898239, -0.032858431339263916, -0.15723779797554016, -0.007243963424116373, -0.11672262102365494, -0.07370245456695557, 0.13439007103443146, -0.21179142594337463, 0.16522705554962158, 0.19063429534435272, -0.03220533952116966, 0.19742299616336825, 0.051424652338027954, 0.0539473257958889, -0.0267542265355587, -0.05962235853075981, -0.10693183541297913, -0.06975080072879791, 0.0839187428355217, -0.03060062602162361, 0.11310655623674391, 0.027042396366596225]','2025-04-08 04:53:18','2025-04-08 04:53:18'),(114,173,5,'faces/face_1744087998_CvUtktvfSv.jpg',100.00,'[-0.16329264640808103, 0.13719476759433746, 0.07380402088165283, -0.102824829518795, -0.09580717980861664, -0.05138663202524185, -0.07524222135543823, -0.12252619862556458, 0.14499199390411377, -0.07985063642263412, 0.24133872985839844, -0.04810724034905434, -0.20163485407829285, -0.19712573289871216, 0.007665670476853848, 0.17860761284828186, -0.16417723894119263, -0.17827840149402618, -0.054570723325014114, -0.06525116413831711, 0.06223106011748314, -0.02276027947664261, 0.016813768073916435, 0.06540040671825409, -0.15284396708011627, -0.35941794514656067, -0.09865712374448776, -0.046158354729413986, -0.02727795392274857, -0.06354671716690063, -0.08696979284286499, 0.06078089401125908, -0.2265847623348236, -0.09009640663862228, 0.0024047205224633217, 0.13311904668807983, -0.0009212677832692862, -0.01642717607319355, 0.12451973557472228, -0.03235190734267235, -0.1794048547744751, -0.02918676845729351, 0.08017749339342117, 0.2244027554988861, 0.2275240570306778, 0.032291289418935776, 0.04816780611872673, -0.06486009806394577, 0.11286043375730516, -0.15527260303497314, 0.0294258426874876, 0.16226336359977722, 0.0997251272201538, 0.05010833591222763, 0.043380893766880035, -0.14945246279239657, -0.0036910567432641983, 0.1042991578578949, -0.07018564641475677, -0.017707837745547295, -0.003708242904394865, -0.12334263324737547, -0.06296330690383911, -0.05986809358000755, 0.24770985543727875, 0.078886479139328, -0.09985464066267014, -0.14168383181095123, 0.15939706563949585, -0.07268492877483368, -0.05452549085021019, 0.06318008899688721, -0.17441074550151825, -0.1458277404308319, -0.3462778627872467, 0.024144474416971207, 0.41690728068351746, 0.0818634182214737, -0.2752625048160553, 0.04000719636678696, -0.07413268089294434, 0.01115130539983511, 0.09746231883764268, 0.12452265620231628, -0.06431526690721512, 0.09436091780662537, -0.17485830187797546, 0.03558482229709625, 0.20771874487400055, -0.044586338102817535, -0.019443968310952187, 0.20158390700817108, 0.05135926604270935, 0.1271481812000275, 0.07722369581460953, 0.02914559282362461, -0.06687291711568832, -0.0268546212464571, -0.17265163362026217, -0.04679412767291069, 0.055200085043907166, -0.0179477259516716, -0.05427495390176773, 0.10228259861469267, -0.09857337921857834, 0.1083294004201889, 0.06849171221256256, 0.039356403052806854, -0.10917198657989502, -0.007498353719711304, -0.04409373551607132, -0.09773796796798706, 0.08725141733884811, -0.17577792704105377, 0.11590804159641266, 0.17634078860282898, -0.00986584648489952, 0.17253221571445465, 0.11527687311172484, 0.08931364864110947, -0.03439473733305931, -0.04374397173523903, -0.0778060108423233, -0.013366750441491604, 0.09664071351289748, -0.016140107065439224, 0.12141264975070952, 0.03256600722670555]','2025-04-08 04:53:18','2025-04-08 04:53:18'),(115,174,1,'faces/face_1744088299_wBmbCLitPo.jpg',100.00,'[-0.1286684423685074, 0.16311581432819366, 0.06411712616682053, -0.08962517231702805, -0.10336289554834366, -0.05779587849974632, -0.06843473762273788, -0.10157628357410432, 0.15513458847999573, -0.09215592592954636, 0.2266729474067688, -0.06452033668756485, -0.21047966182231903, -0.1944222003221512, -0.0031274547800421715, 0.19032920897006989, -0.15702205896377563, -0.1571185141801834, -0.04703965783119202, -0.03417738154530525, 0.07917311042547226, -0.025945937260985374, 0.0208011232316494, 0.05846197530627251, -0.16188958287239075, -0.35952478647232056, -0.10906030982732771, -0.07657255232334137, -0.052447766065597534, -0.04387916252017021, -0.12436194717884064, 0.052765510976314545, -0.1841777265071869, -0.1101849004626274, 0.005869449116289616, 0.1175846830010414, 0.017497114837169647, -0.0114258686080575, 0.12496806681156158, -0.02004312351346016, -0.1810176223516464, -0.0366102010011673, 0.08146684616804123, 0.25009122490882874, 0.2201596796512604, 0.01912631466984749, 0.07125028967857361, -0.009504870511591434, 0.1056765615940094, -0.16021917760372162, 0.028085922822356224, 0.11679890006780624, 0.1040193811058998, 0.0677047148346901, 0.04277867823839187, -0.122765451669693, 0.002348099835216999, 0.12188831716775894, -0.11881829053163528, -0.001157680293545127, 0.05557787790894509, -0.14713118970394137, -0.09463867545127869, -0.045449499040842056, 0.2863047122955322, 0.12567636370658877, -0.11675608158111572, -0.17075298726558685, 0.1587369292974472, -0.10431841015815736, -0.05356818065047264, 0.04694373533129692, -0.1749034821987152, -0.10120093822479248, -0.33838510513305664, 0.017460817471146584, 0.3977908492088318, 0.0935644432902336, -0.25357359647750854, -0.0022379099391400814, -0.08282791823148727, 0.03720744699239731, 0.11117495596408844, 0.09748471528291702, -0.022889873012900352, 0.09190289676189424, -0.17457298934459686, 0.017998768016695976, 0.20812006294727323, -0.05587444454431534, -0.033228207379579544, 0.1867290884256363, 0.04630265757441521, 0.0929643288254738, 0.06406717747449875, 0.022737285122275352, -0.06164735183119774, -0.030971815809607502, -0.1519414186477661, 0.013707581907510756, 0.03816663473844528, -0.0642804428935051, -0.0673133060336113, 0.08644901216030121, -0.09546051919460297, 0.09217192232608797, 0.037101373076438904, 0.044847846031188965, -0.11840847134590148, -0.01414567232131958, -0.08389703929424286, -0.0757029801607132, 0.1037025973200798, -0.18484552204608917, 0.1268109232187271, 0.1604776829481125, -0.005776535719633102, 0.14269013702869415, 0.08486482501029968, 0.07708942890167236, -0.032533787190914154, -0.05051081255078316, -0.0916915163397789, -0.053744371980428696, 0.08690162003040314, -0.03201289847493172, 0.13518086075782776, 0.02491729147732258]','2025-04-08 04:58:19','2025-04-08 04:58:19'),(116,174,2,'faces/face_1744088299_aTRyFqJSjz.jpg',100.00,'[-0.18750792741775513, 0.14211933314800262, 0.1027764454483986, -0.08162975311279297, -0.1259428709745407, -0.06254086643457413, -0.04542586952447891, -0.1155128926038742, 0.13302333652973175, -0.08383168280124664, 0.2794650197029114, -0.01449587568640709, -0.182501420378685, -0.2030889987945557, 0.034184373915195465, 0.18475374579429624, -0.13431258499622345, -0.1893106549978256, -0.03712940961122513, -0.06749027967453003, 0.0554841086268425, -0.024957844987511635, 0.02531568706035614, 0.05961048603057861, -0.16076701879501343, -0.3485814332962036, -0.09181677550077438, -0.09365609288215636, -0.05411609262228012, -0.06990119814872742, -0.05498246476054192, 0.038466908037662506, -0.19928303360939023, -0.09678277373313904, -0.00851798988878727, 0.09920980781316756, -0.015086653642356396, 0.004898435436189175, 0.14177700877189636, -0.020571133121848103, -0.2021506428718567, -0.028435131534934044, 0.0693315714597702, 0.255745530128479, 0.1838759332895279, 0.01869907043874264, 0.04782842844724655, -0.0264221653342247, 0.0761418417096138, -0.14254459738731384, 0.005199642851948738, 0.12922988831996918, 0.10175330936908722, 0.02568690851330757, 0.0642750933766365, -0.13167732954025269, 0.02858693152666092, 0.06974226236343384, -0.1069900318980217, -0.020238474011421204, 0.027203205972909927, -0.14223867654800415, -0.05570745468139648, -0.06366812437772751, 0.281168669462204, 0.08060722053050995, -0.07721930742263794, -0.13693076372146606, 0.1531084179878235, -0.05164236202836037, -0.08010312169790268, 0.07491383701562881, -0.18848101794719696, -0.13418227434158325, -0.33476758003234863, 0.03334861993789673, 0.3892492353916168, 0.0747152790427208, -0.25432088971138, 0.01640952378511429, -0.06653433293104172, 0.02848675101995468, 0.07954545319080353, 0.09430236369371414, -0.049240197986364365, 0.08239305019378662, -0.17311060428619385, 0.018291987478733063, 0.17866066098213196, -0.0480474978685379, -0.011878862977027891, 0.1777738332748413, 0.0406809002161026, 0.09577606618404388, 0.07603104412555695, 0.0031795036047697067, -0.06823444366455078, -0.0008863224647939205, -0.16085141897201538, -0.0175864826887846, 0.03316887840628624, -0.0442831851541996, -0.030848681926727295, 0.09099975973367692, -0.1258798986673355, 0.08303176611661911, 0.04253164678812027, 0.016033414751291275, -0.14229318499565125, 0.01805062405765057, -0.06779743731021881, -0.07507435232400894, 0.08078065514564514, -0.1691119223833084, 0.16336697340011597, 0.19469258189201355, -0.0048788757994771, 0.14020656049251556, 0.10957828909158708, 0.04229850694537163, -0.0761357843875885, -0.027876663953065872, -0.09455615282058716, -0.01669452153146267, 0.09688403457403184, -0.06371823698282242, 0.12715250253677368, 0.03856066614389419]','2025-04-08 04:58:19','2025-04-08 04:58:19'),(117,174,3,'faces/face_1744088299_VtwBB7Eewl.jpg',100.00,'[-0.15883302688598633, 0.11690010875463486, 0.09191212058067322, -0.053129419684410095, -0.08190367370843887, -0.06801559031009674, -0.025901341810822487, -0.13568945229053497, 0.13655611872673035, -0.13705453276634216, 0.2350105494260788, -0.050772711634635925, -0.21899493038654327, -0.18070527911186215, -0.006689626257866621, 0.17958465218544006, -0.13946302235126495, -0.18434907495975497, -0.05701408162713051, -0.06497064232826233, 0.060818541795015335, -0.03587409481406212, 0.03283769264817238, 0.020978452637791634, -0.11963101476430892, -0.3658091425895691, -0.12939119338989258, -0.07390719652175903, -0.05440552532672882, -0.05217590928077698, -0.092863529920578, 0.04877950996160507, -0.2072712928056717, -0.10974545776844025, -0.01227287296205759, 0.08748730272054672, 0.007861308753490448, 0.0022442638874053955, 0.1572764813899994, -0.030730554834008217, -0.1820311099290848, -0.039061687886714935, 0.09355740994215012, 0.23950132727622983, 0.18731996417045593, 0.030165299773216248, 0.023390034213662148, -0.02198520489037037, 0.0845271497964859, -0.14494824409484863, 0.040237460285425186, 0.12642031908035278, 0.09044674038887024, 0.06352472305297852, 0.06981361657381058, -0.12556329369544983, 0.04525567591190338, 0.06916148960590363, -0.0784807875752449, 0.012588856741786005, 0.051736652851104736, -0.16231267154216766, -0.04431707412004471, 0.015687447041273117, 0.25595036149024963, 0.06939341872930527, -0.06182203441858291, -0.15518896281719208, 0.15403367578983307, -0.0871402844786644, -0.046980779618024826, 0.03948725759983063, -0.17975302040576935, -0.12134723365306854, -0.3344283699989319, 0.034700557589530945, 0.4419781565666199, 0.0820341482758522, -0.22397062182426453, 0.047157417982816696, -0.07177068293094635, -0.006102369632571936, 0.15474754571914673, 0.1058274507522583, -0.04124101251363754, 0.0814083069562912, -0.1883775144815445, 0.029420308768749237, 0.1973395198583603, -0.030196547508239743, -0.07194697856903076, 0.17147323489189148, 0.01006641425192356, 0.09601740539073944, 0.10389821231365204, 0.016418591141700745, -0.06296682357788086, -0.017245415598154068, -0.1762204468250275, -0.01507902890443802, 0.06002698466181755, -0.0671347826719284, -0.07707148790359497, 0.08830138295888901, -0.09214568883180618, 0.05948502570390701, 0.026160869747400284, 0.0344230942428112, -0.1284056007862091, 0.002969495952129364, -0.1043086051940918, -0.058689139783382416, 0.06869518756866455, -0.16929732263088226, 0.15644191205501556, 0.17318612337112427, -0.02704121172428131, 0.14210890233516693, 0.11710970103740692, 0.05684985965490341, -0.024378180503845215, -0.031242549419403076, -0.10346535593271255, -0.05312880873680115, 0.09918387979269028, 0.004652267321944237, 0.15420033037662506, 0.04039054363965988]','2025-04-08 04:58:19','2025-04-08 04:58:19'),(118,174,4,'faces/face_1744088299_Hyrjv4uLqb.jpg',100.00,'[-0.1459416002035141, 0.1714039146900177, 0.05540519207715988, -0.0723673552274704, -0.09006772935390472, -0.06816458702087402, -0.06909584254026413, -0.08667024224996567, 0.16579855978488922, -0.09790711849927902, 0.22169120609760284, -0.04382184147834778, -0.2045065462589264, -0.17431877553462982, 0.003324683755636215, 0.1774701476097107, -0.18469063937664032, -0.15442727506160736, -0.0471954382956028, -0.049579985439777374, 0.06844363361597061, -0.017054235562682152, 0.04086572304368019, 0.06243283674120903, -0.13681761920452118, -0.36419594287872314, -0.10601051151752472, -0.08194460719823837, -0.026276396587491035, -0.05969826877117157, -0.1223350316286087, 0.04527175799012184, -0.1974949687719345, -0.11364604532718658, 0.00599930714815855, 0.11229319870471954, 0.014845438301563265, 0.0008609853684902191, 0.14991988241672516, -0.0217817947268486, -0.1480085402727127, -0.06662073731422424, 0.06083007901906967, 0.2835616171360016, 0.20327100157737732, 0.02466808818280697, 0.04904354363679886, 0.01112205721437931, 0.08692840486764908, -0.1506495326757431, 0.03346537798643112, 0.13197289407253265, 0.10256867855787276, 0.07103713601827621, 0.05024448037147522, -0.12403225898742676, 0.013029219582676888, 0.10577397048473358, -0.11010867357254028, 0.007353965193033218, 0.058461304754018784, -0.13784664869308472, -0.06986105442047119, -0.027700645849108696, 0.31866005063056946, 0.11417734622955322, -0.10560618340969086, -0.15814155340194702, 0.16711154580116272, -0.09117160737514496, -0.04456561058759689, 0.02823011763393879, -0.1635185331106186, -0.10831371694803238, -0.30415859818458557, 0.007474594749510288, 0.383409321308136, 0.09924058616161346, -0.25381502509117126, 0.0046248300932347775, -0.08907593041658401, -0.0007471810095012188, 0.1178158074617386, 0.09205330908298492, -0.05133243277668953, 0.12011987715959548, -0.18103575706481936, 0.04249384254217148, 0.20483088493347168, -0.03257199004292488, -0.0495511032640934, 0.18408221006393433, 0.04273321479558945, 0.07838166505098343, 0.09076535701751708, -0.001130692777223885, -0.05499795824289322, -0.03323032706975937, -0.18858841061592105, 0.013455590233206747, 0.03621669113636017, -0.07794620096683502, -0.08395147323608398, 0.08809004724025726, -0.08093437552452087, 0.08189345896244049, 0.05022553354501724, 0.034287188202142715, -0.1468110233545303, 0.0008831426966935396, -0.12229425460100174, -0.08053036779165268, 0.108692966401577, -0.17963312566280365, 0.15111474692821503, 0.15802235901355743, 0.003271540394052863, 0.1554366946220398, 0.07332491129636765, 0.07203565537929535, -0.023343218490481377, -0.05317679047584534, -0.08436490595340729, -0.05855993181467056, 0.0899064689874649, -0.02004574052989483, 0.15159884095191956, 0.03638046234846115]','2025-04-08 04:58:19','2025-04-08 04:58:19'),(119,174,5,'faces/face_1744088299_HyZ3UzZlhe.jpg',100.00,'[-0.17335808277130127, 0.12494082003831863, 0.05456433445215225, -0.10588007420301436, -0.11472129076719284, -0.053251877427101135, -0.08404721319675446, -0.11958924680948256, 0.16228853166103363, -0.09532084316015244, 0.21675175428390503, -0.041504718363285065, -0.211525559425354, -0.18502533435821533, 0.015384943224489687, 0.1723240166902542, -0.15509845316410065, -0.1823003888130188, -0.03324073553085327, -0.07024583220481873, 0.06413830071687698, -0.02016010507941246, 0.026294078677892685, 0.06534410268068314, -0.18185511231422424, -0.3580370545387268, -0.1339324116706848, -0.06583887338638306, -0.0703992173075676, -0.05077387019991875, -0.10787356644868852, 0.03670760616660118, -0.21467146277427673, -0.10903844237327576, 0.01781657338142395, 0.14721375703811646, 0.007540134713053703, -0.02822278067469597, 0.11644040793180466, -0.006323931738734245, -0.1650039106607437, -0.04958654195070267, 0.0752774327993393, 0.24047134816646576, 0.20856966078281405, -0.0024019312113523483, 0.05100215971469879, -0.03914792090654373, 0.10758961737155914, -0.15735214948654175, 0.04838100075721741, 0.14428983628749847, 0.09595758467912674, 0.05976302549242973, 0.05647216737270355, -0.10994450747966766, 0.01960120350122452, 0.12276177108287813, -0.08895561099052429, 0.003469406859949231, 0.050895147025585175, -0.1502840518951416, -0.09386789053678513, -0.05546427518129349, 0.2544645369052887, 0.11639568209648132, -0.10389375686645508, -0.18126612901687625, 0.15259969234466553, -0.07594741135835648, -0.08017830550670624, 0.042928870767354965, -0.18134987354278564, -0.14412786066532135, -0.3677026927471161, 0.03941033035516739, 0.4078434705734253, 0.11367852240800858, -0.2752590477466583, 0.02747175469994545, -0.08580178022384644, 0.041122641414403915, 0.10783907026052476, 0.11323241144418716, -0.035064008086919785, 0.11244794726371764, -0.18725118041038513, 0.04136071726679802, 0.1967436522245407, -0.0424560084939003, -0.0446934849023819, 0.20062056183815, 0.04654761403799057, 0.13172005116939545, 0.10340479016304016, 0.05071282386779785, -0.07056953012943268, -0.044506072998046875, -0.17790193855762482, -0.015061899088323116, 0.07149560004472733, -0.03727182745933533, -0.05579958111047745, 0.10242316871881484, -0.08360789716243744, 0.09755384922027588, 0.04862813279032707, 0.020826280117034912, -0.13218702375888824, -0.018570654094219208, -0.08617442101240158, -0.08819042146205902, 0.0869617909193039, -0.19631455838680267, 0.11151394993066788, 0.1702542006969452, -0.007540835998952389, 0.17418508231639862, 0.1101653054356575, 0.07471386343240738, -0.04236961156129837, -0.04713328927755356, -0.07914218306541443, -0.03583294525742531, 0.07534544169902802, 0.008386628702282906, 0.11796849966049194, 0.04257296025753021]','2025-04-08 04:58:19','2025-04-08 04:58:19'),(120,2,1,'faces/face_1744093482_CyilEhpiX9.jpg',100.00,'[-0.1841759979724884, 0.1707644164562225, 0.07510143518447876, -0.08616740256547928, -0.12150346487760544, -0.02603818103671074, -0.05608523264527321, -0.12092870473861694, 0.14028239250183103, -0.11580346524715424, 0.26758724451065063, -0.08251835405826569, -0.2067347913980484, -0.18410925567150116, -0.006944339722394943, 0.1771666407585144, -0.145549476146698, -0.16984286904335022, -0.06544128805398941, -0.040223218500614166, 0.06256303936243057, -0.015752892941236496, 0.018215343356132507, 0.040761202573776245, -0.1656324863433838, -0.3729691207408905, -0.11081406474113464, -0.06242590397596359, -0.07351920008659363, -0.0800541564822197, -0.0951879620552063, 0.02607877552509308, -0.2187238484621048, -0.09373563528060912, -0.003767712041735649, 0.12713509798049927, -0.01032199803739786, -0.010571244172751904, 0.12793150544166565, -0.05346827954053879, -0.1887367218732834, -0.048553332686424255, 0.0853649377822876, 0.24649913609027865, 0.17738394439220428, -0.005987317301332951, 0.03383408486843109, -0.02791064605116844, 0.09225886315107346, -0.14083875715732574, 0.03712976351380348, 0.12622061371803284, 0.08439917117357254, 0.04886455461382866, 0.04667083919048309, -0.10753262042999268, 0.0031718192622065544, 0.14333052933216095, -0.06532122194766998, -0.005502237007021904, 0.05597357824444771, -0.1702442467212677, -0.09393537044525146, -0.04816555976867676, 0.23387648165225983, 0.11061114072799684, -0.07549317181110382, -0.20751500129699707, 0.15677911043167114, -0.07356398552656174, -0.05090815573930741, 0.07626666128635406, -0.16429820656776428, -0.1354132890701294, -0.34456169605255127, 0.027011822909116745, 0.4313776195049286, 0.08062717318534851, -0.2513367235660553, -0.010074743069708347, -0.07807767391204834, 0.022954758256673813, 0.11340461671352386, 0.09040500223636629, -0.03229717165231705, 0.0841795951128006, -0.21036292612552643, 0.048290498554706573, 0.2224358767271042, -0.04822131618857384, -0.04021060094237328, 0.17169855535030365, 0.03679773584008217, 0.07425189763307571, 0.081332266330719, 0.015585333108901978, -0.07276888936758041, -0.021464690566062927, -0.1595588177442551, -0.001471254974603653, 0.04902419447898865, -0.07084576040506363, -0.0958659127354622, 0.11075547337532043, -0.10570548474788666, 0.0977562963962555, 0.043977126479148865, 0.02757127955555916, -0.1178549900650978, -0.016447752714157104, -0.0709347128868103, -0.0717458501458168, 0.10063906759023666, -0.18245558440685272, 0.11050977557897568, 0.1599539816379547, -0.0011431029997766018, 0.16445010900497437, 0.10692433267831802, 0.07336223870515823, -0.037589047104120255, -0.03395698964595795, -0.12543445825576782, -0.05174613371491432, 0.07816218584775925, -0.00849946029484272, 0.12301556766033173, 0.02459609881043434]','2025-04-08 06:24:42','2025-04-08 06:24:42'),(121,2,2,'faces/face_1744093482_UhbeOsZFEk.jpg',100.00,'[-0.16710779070854187, 0.1880311816930771, 0.12228766828775406, -0.07768070697784424, -0.1238619014620781, -0.019299056380987167, -0.050518184900283813, -0.12556646764278412, 0.1407082825899124, -0.09864729642868042, 0.2802930176258087, -0.023236017674207687, -0.2102766185998917, -0.20037813484668732, 0.03472672775387764, 0.16489411890506744, -0.11541607230901718, -0.20650577545166016, -0.04350976645946503, -0.08846477419137955, 0.07451392710208893, -0.006720873061567545, 0.015469787642359734, 0.0404178649187088, -0.18354451656341553, -0.3632546663284302, -0.10877811908721924, -0.08783189952373505, -0.05571362376213074, -0.09167662262916564, -0.042705848813056946, 0.022756673395633698, -0.2533716857433319, -0.0917116403579712, -0.018061377108097076, 0.11092299222946168, -0.020439013838768005, 0.018274404108524323, 0.11368495225906372, -0.030427798628807068, -0.1851274073123932, -0.03247391805052757, 0.07812007516622543, 0.22391121089458463, 0.18391841650009155, 0.03301980346441269, 0.05147666111588478, 0.004058717750012875, 0.058319561183452606, -0.1247026026248932, 0.02058391645550728, 0.16735097765922546, 0.12488771975040436, 0.06278981268405914, 0.03277919813990593, -0.111638143658638, 0.015761002898216248, 0.09530829638242722, -0.14635440707206726, -0.005069723352789879, 0.05582530051469803, -0.1864334940910339, -0.07800508290529251, -0.0035026157274842262, 0.26496925950050354, 0.11052708327770232, -0.07254818081855774, -0.16062043607234955, 0.16805171966552734, -0.08613967150449753, -0.06005388870835304, 0.07157458364963531, -0.18366634845733645, -0.11936916410923004, -0.3166235089302063, 0.0507124662399292, 0.4051038920879364, 0.057367898523807526, -0.2256876528263092, 0.020336922258138657, -0.07811429351568222, 0.05155515298247337, 0.04814735054969787, 0.07036784291267395, -0.05579520761966705, 0.08108706772327423, -0.16493472456932068, 0.062180615961551666, 0.17935052514076233, -0.036102525889873505, -0.0122116319835186, 0.18117234110832217, 0.017399853095412254, 0.06675680726766586, 0.09330989420413972, 0.026652047410607334, -0.06267815083265305, -0.034422725439071655, -0.1208110898733139, -0.008009575307369232, -0.001899796538054943, -0.06726660579442978, -0.052563413977622986, 0.06840042769908905, -0.11338618397712708, 0.1016744077205658, 0.020899761468172073, 0.013077559880912304, -0.1623605638742447, 0.0025975683238357306, -0.05872836709022522, -0.07833231985569, 0.08904440701007843, -0.19586019217967987, 0.18139345943927765, 0.17482611536979675, -0.06967243552207947, 0.16145703196525574, 0.09271391481161118, 0.08847733587026596, -0.05739864706993103, -0.0635855570435524, -0.07908686995506287, -0.07141292840242386, 0.08568643033504486, -0.05017786473035813, 0.14360669255256653, 0.019825752824544907]','2025-04-08 06:24:42','2025-04-08 06:24:42'),(122,2,3,'faces/face_1744093482_uqzg7G5qTX.jpg',100.00,'[-0.19848227500915527, 0.1761990338563919, 0.08781155943870544, -0.0464664064347744, -0.1130923330783844, 0.000011347699910402298, -0.020350491628050804, -0.1460959166288376, 0.16170205175876615, -0.16413530707359314, 0.21630966663360596, -0.0734429806470871, -0.2342425435781479, -0.15591548383235931, 0.0056619420647621155, 0.15130192041397095, -0.12612399458885193, -0.21254922449588776, -0.11523565649986268, -0.08103285729885101, 0.01874604821205139, -0.050598420202732086, 0.017990337684750557, 0.03836444765329361, -0.11750875413417816, -0.3878990709781647, -0.12185412645339966, -0.05824621021747589, -0.024322176352143288, -0.08116421103477478, -0.10169883072376253, -0.002818961627781391, -0.25766295194625854, -0.0939188227057457, -0.07147455215454102, 0.07488875836133957, -0.012234564870595932, 0.0005179177969694138, 0.1544528305530548, -0.0835949182510376, -0.18407317996025083, -0.07667284458875656, 0.07413681596517563, 0.21061544120311737, 0.17550300061702728, 0.028423184528946877, 0.006215546280145645, -0.017324164509773254, 0.07256229966878891, -0.15129822492599487, 0.07441774010658264, 0.14903302490711212, 0.13447624444961548, 0.051532499492168427, 0.05169670283794403, -0.13683857023715973, -0.02089880593121052, 0.07640358060598373, -0.06410674750804901, 0.013899952173233032, 0.0450030192732811, -0.15945115685462952, -0.08933893591165543, -0.020900852978229523, 0.27002424001693726, 0.12487740814685822, -0.04152950271964073, -0.1785699725151062, 0.2094913274049759, -0.11449074000120164, 0.01559527963399887, 0.05343086272478104, -0.12817956507205963, -0.1424618512392044, -0.3136161267757416, 0.06463215500116348, 0.41242361068725586, 0.10152778029441832, -0.21180614829063416, 0.0074561359360814095, -0.11181677132844924, 0.0027058999985456467, 0.08582717180252075, 0.06807472556829453, -0.11037783324718475, 0.09066248685121536, -0.17830465734004974, 0.07425849884748459, 0.2026422917842865, -0.032681480050086975, -0.04901357367634773, 0.19080492854118347, 0.03548186272382736, 0.03910153731703758, 0.10048740357160568, 0.0034172353334724903, -0.055573489516973495, -0.03919288516044617, -0.16613872349262238, 0.027169257402420044, 0.07533030956983566, -0.08031522482633591, -0.07671870291233063, 0.07540041953325272, -0.09191308170557022, 0.05873120576143265, 0.02217123471200466, 0.012642252258956432, -0.11276957392692566, -0.008127344772219658, -0.12886154651641846, -0.11413615196943284, 0.12266234308481216, -0.188324972987175, 0.11696385592222214, 0.14174430072307587, -0.05018282309174538, 0.18238557875156405, 0.1107763573527336, 0.11787204444408415, -0.0022357115522027016, -0.04365644231438637, -0.09821002185344696, -0.04913594201207161, 0.13690981268882751, -0.018376300111413, 0.11971133202314375, 0.0673668384552002]','2025-04-08 06:24:42','2025-04-08 06:24:42'),(123,2,4,'faces/face_1744093483_x3vliOAbGS.jpg',100.00,'[-0.14934827387332916, 0.16584503650665283, 0.06082824245095253, -0.059976693242788315, -0.11225740611553192, -0.0737481415271759, -0.07070522010326385, -0.1225331649184227, 0.14679966866970062, -0.11548900604248048, 0.23869308829307556, -0.04947279766201973, -0.22696270048618317, -0.14526712894439697, 0.0008529620245099068, 0.14754673838615415, -0.13787245750427246, -0.1613207310438156, -0.0596492700278759, -0.032223284244537354, 0.05546687915921211, -0.021080834791064262, 0.023147717118263245, 0.0449286587536335, -0.14089035987854004, -0.3565082848072052, -0.11512485891580582, -0.04889875650405884, -0.05417659133672714, -0.07096561044454575, -0.09724555164575575, 0.007566404528915882, -0.22488786280155185, -0.10415412485599518, 0.007859787903726101, 0.1225382685661316, 0.001009722938761115, 0.009948127903044224, 0.1551567316055298, -0.025838807225227356, -0.18480773270130155, -0.08184566348791122, 0.05470593273639679, 0.25572633743286133, 0.15954914689064026, 0.033674970269203186, 0.04212166741490364, -0.002636173740029335, 0.07293080538511276, -0.15292276442050934, 0.049937956035137177, 0.14673654735088348, 0.12416452169418336, 0.05178520083427429, 0.04220312833786011, -0.13068121671676636, 0.00819376390427351, 0.13893349468708038, -0.1140442043542862, 0.022926490753889084, 0.06958364695310593, -0.15593628585338593, -0.07585789263248444, -0.01438391860574484, 0.3095738887786865, 0.1390727162361145, -0.10269330441951752, -0.16896994411945343, 0.1785540133714676, -0.10320698469877244, -0.06213310360908508, 0.036140598356723785, -0.14472399652004242, -0.13885340094566345, -0.3294805586338043, 0.01268551405519247, 0.408902108669281, 0.09107988327741624, -0.26222506165504456, -0.009899843484163284, -0.08624903857707977, 0.015469707548618317, 0.1136021763086319, 0.09282854944467545, -0.046869613230228424, 0.11634574085474014, -0.18545076251029968, 0.0403255894780159, 0.21919628977775577, -0.0353533960878849, -0.05896897614002228, 0.16569948196411133, 0.023157037794589996, 0.0768820121884346, 0.08541750907897949, 0.011710862629115582, -0.0638047382235527, -0.04481774941086769, -0.15681809186935425, 0.01022854633629322, 0.0545344278216362, -0.07532132416963577, -0.07601236552000046, 0.11302103102207184, -0.09456763416528702, 0.0929766595363617, 0.034199971705675125, 0.011106726713478563, -0.12599247694015503, 0.010319175198674202, -0.09448575973510742, -0.09668972343206406, 0.10192342102527618, -0.2025534212589264, 0.1868664175271988, 0.15481141209602356, -0.03668886795639992, 0.15991146862506866, 0.07035938650369644, 0.07770593464374542, -0.005380529910326004, -0.03864191100001335, -0.09422516077756882, -0.09557051211595537, 0.0605480782687664, -0.02227017283439636, 0.15758545696735382, 0.02886391058564186]','2025-04-08 06:24:43','2025-04-08 06:24:43'),(124,2,5,'faces/face_1744093483_g5YREyego9.jpg',100.00,'[-0.18669086694717407, 0.1905018389225006, 0.0801146924495697, -0.08657623827457428, -0.0801030695438385, -0.05200586095452309, -0.05373447760939598, -0.12825621664524078, 0.13287833333015442, -0.08339757472276688, 0.27814579010009766, -0.05724295601248741, -0.1897476464509964, -0.19034919142723083, -0.010231928899884224, 0.1984205991029739, -0.16123370826244354, -0.17929644882678986, -0.08340540528297424, -0.036789700388908386, 0.06589393317699432, -0.02699535526335239, 0.0020207655616104603, 0.043096210807561874, -0.1281561702489853, -0.3440272808074951, -0.08450452238321304, -0.028264744207262993, -0.008726577274501324, -0.05888645350933075, -0.08694135397672653, 0.014691597782075403, -0.2408561408519745, -0.11842098832130432, 0.009316466748714449, 0.12082115560770036, -0.010340645909309387, -0.02397295832633972, 0.13749277591705322, -0.07512171566486359, -0.19662511348724365, -0.009828463196754456, 0.1173957735300064, 0.24465760588645935, 0.21143926680088043, 0.018641125410795212, 0.043736532330513, -0.07362577319145203, 0.09329218417406082, -0.16351205110549927, 0.030162306502461433, 0.1217709332704544, 0.1034918576478958, 0.0702933520078659, 0.01706979051232338, -0.13808801770210266, -0.004035926423966885, 0.1288370043039322, -0.07689295709133148, -0.0008037362713366747, 0.04471829906105995, -0.16116271913051605, -0.07384166121482849, -0.06148654595017433, 0.2353464663028717, 0.07984419167041779, -0.1034674420952797, -0.18062986433506012, 0.135427325963974, -0.08067193627357483, -0.037808846682310104, 0.07536806166172028, -0.13030244410037994, -0.1330774575471878, -0.36853933334350586, 0.035333301872015, 0.41996973752975464, 0.07816416025161743, -0.23905085027217865, 0.0254888404160738, -0.0764470249414444, 0.013882680796086788, 0.08680123835802078, 0.10707564651966096, -0.055532753467559814, 0.07102387398481369, -0.1885581910610199, 0.037582360208034515, 0.2372579425573349, -0.040428996086120605, -0.01610639877617359, 0.18601790070533752, 0.04010448604822159, 0.07153455168008804, 0.048545680940151215, 0.06475048512220383, -0.07821593433618546, -0.021927427500486377, -0.15023842453956604, -0.018566954880952835, 0.04777603596448898, -0.05011925101280213, -0.05251074582338333, 0.1131305694580078, -0.12203311920166016, 0.09869077801704408, 0.04319405555725098, 0.05575212836265564, -0.0771903246641159, -0.008841706439852715, -0.030343417078256607, -0.0943889394402504, 0.07755011320114136, -0.16803209483623505, 0.13188686966896057, 0.18096782267093656, 0.0026793559081852436, 0.1573515683412552, 0.1308489888906479, 0.08671355992555618, -0.02354024350643158, -0.026471471413969994, -0.0998113453388214, -0.038249190896749496, 0.07730011641979218, -0.012997363694012163, 0.14640238881111145, 0.04289393872022629]','2025-04-08 06:24:43','2025-04-08 06:24:43');
/*!40000 ALTER TABLE `face_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `ip_records`
--

DROP TABLE IF EXISTS `ip_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ip_records` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('allowed','blocked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allowed',
  `last_seen_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ip_records_user_id_foreign` (`user_id`),
  CONSTRAINT `ip_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ip_records`
--

LOCK TABLES `ip_records` WRITE;
/*!40000 ALTER TABLE `ip_records` DISABLE KEYS */;
INSERT INTO `ip_records` VALUES (106,2,'127.0.0.1','allowed','2025-04-09 05:35:38','2025-04-09 04:17:59','2025-04-09 05:35:38'),(107,174,'127.0.0.1','allowed','2025-04-09 05:35:39','2025-04-09 04:18:18','2025-04-09 05:35:39');
/*!40000 ALTER TABLE `ip_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,'default','{\"uuid\":\"2a70e499-49e3-43ca-be41-8e10cd92a08e\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744117404,1744117404),(2,'default','{\"uuid\":\"1bab92bd-5cab-4e73-a6ee-a808424fcdf5\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744117436,1744117436),(3,'default','{\"uuid\":\"402e4312-3789-4f44-924d-a0914f003fd8\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744117511,1744117511),(4,'default','{\"uuid\":\"b8296407-9cbb-46d3-b1eb-d7b1dbe2ebb2\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744117843,1744117843),(5,'default','{\"uuid\":\"7f08891b-3007-426e-b17d-8232d759bf8f\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744117956,1744117956),(6,'default','{\"uuid\":\"96b9c0d5-1238-44ff-afe7-350124d8139e\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744117963,1744117963),(7,'default','{\"uuid\":\"ba324bcb-ecdf-48ba-883d-6fc189facac8\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:24;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744118291,1744118291),(8,'default','{\"uuid\":\"85ac6f0f-467d-4cbf-8c04-6a20a46ccef4\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744118306,1744118306),(9,'default','{\"uuid\":\"993904e3-52ea-4b4b-b5c0-6612fbfde82d\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744118345,1744118345),(10,'default','{\"uuid\":\"87d7f187-a2d9-4a13-9306-feb6b26c6654\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744118436,1744118436),(11,'default','{\"uuid\":\"0a8e29e1-65e4-4232-bd80-aca3190c24ef\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744118496,1744118496),(12,'default','{\"uuid\":\"719545ee-66d2-4d1f-98cf-32da31e6aa32\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744118500,1744118500),(13,'default','{\"uuid\":\"8ad492e3-9e4d-4af5-aa09-76fe6990296c\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:27;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744118933,1744118933),(14,'default','{\"uuid\":\"a97bc6c1-a90e-4267-b55b-f84628e277a8\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:29;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744119261,1744119261),(15,'default','{\"uuid\":\"734ec60e-b0a2-4d69-915e-647ef628cd14\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744119403,1744119403),(16,'default','{\"uuid\":\"b35fa730-f8d5-4480-85f3-4185ecb69463\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:30;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744119438,1744119438),(17,'default','{\"uuid\":\"924d8452-fb55-4628-9fe1-a93978a01d7c\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:31;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744119528,1744119528),(18,'default','{\"uuid\":\"487ed46e-f796-4439-aa5c-71e189419833\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:32;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744120200,1744120200),(19,'default','{\"uuid\":\"2d86bdb8-55ab-4c8c-b293-92ce5eb4d2a0\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:33;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744120449,1744120449),(20,'default','{\"uuid\":\"7fdb4408-3c81-4aad-a9c3-2654ed2b7cbb\",\"displayName\":\"App\\\\Events\\\\IpRecordCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\IpRecordCreated\\\":1:{s:8:\\\"ipRecord\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:19:\\\"App\\\\Models\\\\IpRecord\\\";s:2:\\\"id\\\";i:34;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}',0,NULL,1744120704,1744120704);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'0001_01_05_000004_create_campuses_table',1),(4,'0001_01_06_000003_create_colleges_table',1),(5,'0001_01_06_000004_create_councils_table',1),(6,'0001_01_06_000005_create_programs_table',1),(7,'0001_01_06_000006_create_program_majors_table',1),(8,'0001_01_06_000010_create_users_table',1),(9,'2025_01_06_035243_add_two_factor_columns_to_users_table',1),(10,'2025_01_06_035347_create_personal_access_tokens_table',1),(11,'2025_01_06_042432_create_permission_tables',1),(12,'2025_01_09_080427_election_types',1),(13,'2025_01_09_080428_create_elections_table',1),(14,'2025_01_09_151536_create_positions_table',1),(15,'2025_01_09_185954_create_election_positions_table',1),(16,'2025_01_13_070722_create_party_lists_table',1),(17,'2025_01_13_091335_create_candidates_table',1),(18,'2025_01_17_163157_create_election_excluded_voters_table',1),(19,'2025_02_04_020807_create_ip_records_table',1),(20,'2025_02_14_095644_create_votes_table',1),(21,'2025_02_22_071543_create_voter_encode_votes_table',1),(22,'2025_03_22_100105_create_council_position_settings_table',1),(23,'2025_03_25_001610_create_face_data_table',1),(26,'2025_04_09_125329_create_backup_schedules_table',2),(27,'2025_04_09_130448_create_backup_files_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(4,'App\\Models\\User',2),(5,'App\\Models\\User',3),(5,'App\\Models\\User',4),(5,'App\\Models\\User',5),(5,'App\\Models\\User',6),(5,'App\\Models\\User',7),(5,'App\\Models\\User',8),(5,'App\\Models\\User',9),(5,'App\\Models\\User',10),(5,'App\\Models\\User',11),(5,'App\\Models\\User',12),(5,'App\\Models\\User',13),(5,'App\\Models\\User',14),(5,'App\\Models\\User',15),(5,'App\\Models\\User',16),(5,'App\\Models\\User',17),(5,'App\\Models\\User',18),(5,'App\\Models\\User',19),(5,'App\\Models\\User',20),(5,'App\\Models\\User',21),(5,'App\\Models\\User',22),(5,'App\\Models\\User',23),(5,'App\\Models\\User',24),(5,'App\\Models\\User',25),(5,'App\\Models\\User',26),(5,'App\\Models\\User',27),(5,'App\\Models\\User',28),(5,'App\\Models\\User',29),(5,'App\\Models\\User',30),(5,'App\\Models\\User',31),(5,'App\\Models\\User',32),(5,'App\\Models\\User',33),(5,'App\\Models\\User',34),(5,'App\\Models\\User',35),(5,'App\\Models\\User',36),(5,'App\\Models\\User',37),(5,'App\\Models\\User',38),(5,'App\\Models\\User',39),(5,'App\\Models\\User',40),(5,'App\\Models\\User',41),(5,'App\\Models\\User',42),(5,'App\\Models\\User',43),(5,'App\\Models\\User',44),(5,'App\\Models\\User',45),(5,'App\\Models\\User',46),(5,'App\\Models\\User',47),(5,'App\\Models\\User',48),(5,'App\\Models\\User',49),(5,'App\\Models\\User',50),(5,'App\\Models\\User',51),(5,'App\\Models\\User',52),(5,'App\\Models\\User',53),(5,'App\\Models\\User',54),(5,'App\\Models\\User',55),(5,'App\\Models\\User',56),(5,'App\\Models\\User',57),(5,'App\\Models\\User',58),(5,'App\\Models\\User',59),(5,'App\\Models\\User',60),(5,'App\\Models\\User',61),(5,'App\\Models\\User',62),(5,'App\\Models\\User',63),(5,'App\\Models\\User',64),(5,'App\\Models\\User',65),(5,'App\\Models\\User',66),(5,'App\\Models\\User',67),(5,'App\\Models\\User',68),(5,'App\\Models\\User',69),(5,'App\\Models\\User',70),(5,'App\\Models\\User',71),(5,'App\\Models\\User',72),(5,'App\\Models\\User',73),(5,'App\\Models\\User',74),(5,'App\\Models\\User',75),(5,'App\\Models\\User',76),(5,'App\\Models\\User',77),(5,'App\\Models\\User',78),(5,'App\\Models\\User',79),(5,'App\\Models\\User',80),(5,'App\\Models\\User',81),(5,'App\\Models\\User',82),(5,'App\\Models\\User',83),(5,'App\\Models\\User',84),(5,'App\\Models\\User',85),(5,'App\\Models\\User',86),(5,'App\\Models\\User',87),(5,'App\\Models\\User',88),(5,'App\\Models\\User',89),(5,'App\\Models\\User',90),(5,'App\\Models\\User',91),(5,'App\\Models\\User',92),(5,'App\\Models\\User',93),(5,'App\\Models\\User',94),(5,'App\\Models\\User',95),(5,'App\\Models\\User',96),(5,'App\\Models\\User',97),(5,'App\\Models\\User',98),(5,'App\\Models\\User',99),(5,'App\\Models\\User',100),(5,'App\\Models\\User',101),(5,'App\\Models\\User',102),(5,'App\\Models\\User',103),(5,'App\\Models\\User',104),(5,'App\\Models\\User',105),(5,'App\\Models\\User',106),(5,'App\\Models\\User',107),(5,'App\\Models\\User',108),(5,'App\\Models\\User',109),(5,'App\\Models\\User',110),(5,'App\\Models\\User',111),(5,'App\\Models\\User',112),(5,'App\\Models\\User',113),(5,'App\\Models\\User',114),(5,'App\\Models\\User',115),(5,'App\\Models\\User',116),(5,'App\\Models\\User',117),(5,'App\\Models\\User',118),(5,'App\\Models\\User',119),(5,'App\\Models\\User',120),(5,'App\\Models\\User',121),(5,'App\\Models\\User',122),(5,'App\\Models\\User',123),(5,'App\\Models\\User',124),(5,'App\\Models\\User',125),(5,'App\\Models\\User',126),(5,'App\\Models\\User',127),(5,'App\\Models\\User',128),(5,'App\\Models\\User',129),(5,'App\\Models\\User',130),(5,'App\\Models\\User',131),(5,'App\\Models\\User',132),(5,'App\\Models\\User',133),(5,'App\\Models\\User',134),(5,'App\\Models\\User',135),(5,'App\\Models\\User',136),(5,'App\\Models\\User',137),(5,'App\\Models\\User',138),(5,'App\\Models\\User',139),(5,'App\\Models\\User',140),(5,'App\\Models\\User',141),(5,'App\\Models\\User',142),(5,'App\\Models\\User',143),(5,'App\\Models\\User',144),(5,'App\\Models\\User',145),(5,'App\\Models\\User',146),(5,'App\\Models\\User',147),(5,'App\\Models\\User',148),(5,'App\\Models\\User',149),(5,'App\\Models\\User',150),(5,'App\\Models\\User',151),(5,'App\\Models\\User',152),(5,'App\\Models\\User',153),(5,'App\\Models\\User',154),(5,'App\\Models\\User',155),(5,'App\\Models\\User',156),(5,'App\\Models\\User',157),(5,'App\\Models\\User',158),(5,'App\\Models\\User',159),(5,'App\\Models\\User',160),(5,'App\\Models\\User',161),(5,'App\\Models\\User',162),(5,'App\\Models\\User',163),(5,'App\\Models\\User',168),(5,'App\\Models\\User',169),(5,'App\\Models\\User',170),(5,'App\\Models\\User',171),(5,'App\\Models\\User',172),(5,'App\\Models\\User',173),(5,'App\\Models\\User',174);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `party_lists`
--

DROP TABLE IF EXISTS `party_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `party_lists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `party_lists`
--

LOCK TABLES `party_lists` WRITE;
/*!40000 ALTER TABLE `party_lists` DISABLE KEYS */;
INSERT INTO `party_lists` VALUES (1,'Yanong Agila',NULL,NULL),(2,'Paragon',NULL,NULL);
/*!40000 ALTER TABLE `party_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view election','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(2,'create election','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(3,'edit election','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(4,'delete election','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(5,'view election results','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(6,'view vote tally','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(7,'create candidate','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(8,'edit candidate','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(9,'delete candidate','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(10,'view candidate','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(11,'view party list','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(12,'create party list','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(13,'edit party list','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(14,'delete party list','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(15,'view voter','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(16,'create voter','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(17,'edit voter','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(18,'delete voter','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(19,'view users','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(20,'create users','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(21,'edit users','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(22,'delete users','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(23,'view system logs','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(24,'create system logs','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(25,'edit system logs','web','2025-04-06 18:32:49','2025-04-06 18:32:49'),(26,'delete system logs','web','2025-04-06 18:32:49','2025-04-06 18:32:49');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `positions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `election_type_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_winners` int unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `positions_election_type_id_foreign` (`election_type_id`),
  CONSTRAINT `positions_election_type_id_foreign` FOREIGN KEY (`election_type_id`) REFERENCES `election_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
INSERT INTO `positions` VALUES (1,2,'President',1,NULL,NULL),(2,2,'Internal Vice President',1,NULL,NULL),(3,2,'External Vice President',1,NULL,NULL),(4,2,'General Secretary',1,NULL,NULL),(5,2,'General Treasurer',1,NULL,NULL),(6,2,'Public Information Officer',1,NULL,NULL),(7,3,'Governor',1,NULL,NULL),(8,3,'Vice Governor',1,NULL,NULL),(9,3,'Secretary',1,NULL,NULL),(10,3,'Treasurer',1,NULL,NULL),(11,3,'Auditor',1,NULL,NULL),(12,3,'Senator',1,NULL,NULL);
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_majors`
--

DROP TABLE IF EXISTS `program_majors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_majors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `program_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `program_majors_program_id_foreign` (`program_id`),
  CONSTRAINT `program_majors_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_majors`
--

LOCK TABLES `program_majors` WRITE;
/*!40000 ALTER TABLE `program_majors` DISABLE KEYS */;
INSERT INTO `program_majors` VALUES (1,1,'Information Security',NULL,NULL),(2,5,'Filipino',NULL,NULL),(3,5,'English',NULL,NULL),(4,5,'Math',NULL,NULL),(5,3,'Agricultural Crop Production',NULL,NULL),(6,3,'Animal Production',NULL,NULL);
/*!40000 ALTER TABLE `program_majors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `programs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `college_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `council_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `programs_college_id_foreign` (`college_id`),
  KEY `programs_council_id_foreign` (`council_id`),
  CONSTRAINT `programs_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`),
  CONSTRAINT `programs_council_id_foreign` FOREIGN KEY (`council_id`) REFERENCES `councils` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programs`
--

LOCK TABLES `programs` WRITE;
/*!40000 ALTER TABLE `programs` DISABLE KEYS */;
INSERT INTO `programs` VALUES (1,2,'Bachelor of Science in Information Technology',NULL,NULL,NULL),(2,3,'Bachelor of Science in Agricultural and Bio-systems Engineering',NULL,NULL,NULL),(3,2,'Bachelor of Technical-Vocation Teacher Education',NULL,NULL,NULL),(4,2,'Bachelor of Elementary Education',NULL,NULL,NULL),(5,2,'Bachelor of Secondary Education',NULL,NULL,NULL),(6,2,'Bachelor of Early Childhood Education',NULL,NULL,NULL);
/*!40000 ALTER TABLE `programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin','web','2025-04-06 18:32:48','2025-04-06 18:32:48'),(2,'admin','web','2025-04-06 18:32:48','2025-04-06 18:32:48'),(3,'watcher','web','2025-04-06 18:32:48','2025-04-06 18:32:48'),(4,'technical_officer','web','2025-04-06 18:32:48','2025-04-06 18:32:48'),(5,'voter','web','2025-04-06 18:32:48','2025-04-06 18:32:48');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
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
INSERT INTO `sessions` VALUES ('c4eyoiXo0neHYBnN0YMTJQf2SLASvjirJMuIyCf6',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYWw4S3RpejU1Rkd5Sk9nUlRyMTN5U3pFNmRDaUR3ZW1NNU9vZElZUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90ZWNobmljYWwvZGF0YWJhc2UvYmFja3VwIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjE2OiJzZWxlY3RlZEVsZWN0aW9uIjtpOjE0O3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=',1744176954),('YXmxDsG85z4XjxlxgokS0iKKTB4FFL2pINZcmLKK',174,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSXNSeVdRdXlXVmhYMGZ2T2prVlZzQ0pESE5oMDcyWlZVbmxaVGdnQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC92b3Rlci9hdmFpbGFibGUvZWxlY3Rpb24iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNzQ7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9fQ==',1744176940);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_initial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `campus_id` bigint unsigned NOT NULL,
  `college_id` bigint unsigned NOT NULL,
  `program_id` bigint unsigned NOT NULL,
  `program_major_id` bigint unsigned DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `face_descriptor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_number_unique` (`phone_number`),
  UNIQUE KEY `users_student_id_unique` (`student_id`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_campus_id_foreign` (`campus_id`),
  KEY `users_college_id_foreign` (`college_id`),
  KEY `users_program_id_foreign` (`program_id`),
  KEY `users_program_major_id_foreign` (`program_major_id`),
  CONSTRAINT `users_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`id`),
  CONSTRAINT `users_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`),
  CONSTRAINT `users_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`),
  CONSTRAINT `users_program_major_id_foreign` FOREIGN KEY (`program_major_id`) REFERENCES `program_majors` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Superadmin','Admin','W','Jr','Male','2001-11-10','lmrana00023@usep.edu.ph',NULL,'09096763914','1st Year','2021-00001',2,2,1,1,'superadmin@example',NULL,'$2y$12$JVKwH/7ff6PNdH06c1gbUuS8R0O5e1uS77B67UN.ProE3gADhYy8W',NULL,NULL,NULL,NULL,NULL,NULL,'Active',NULL,'2025-04-06 18:34:49','2025-04-06 18:34:49'),(2,'Matt','Pollich','H',NULL,'Male','1978-12-01','percival83@example.org',NULL,'09521010972','4th Year','20243990',2,2,5,3,'technicalOfficer1@example','2025-04-06 18:36:26','$2y$12$VzfipepYDI5y8bVDA/cM4.akyftkSdUxQIdkAjoOmcRfjUz8u8URO',NULL,NULL,NULL,'ya7LdiEaetCz8Jlje2duhRAEr2u7Ufc8LIDQfiMcDdgN8RNo90NyBfeU31a2',NULL,NULL,'Active',NULL,'2025-04-06 18:36:26','2025-04-08 06:39:01'),(3,'Mavis','Kuhn','Z',NULL,'Male','1996-03-06','roxane.kovacek@example.org',NULL,'09855751030','4th Year','20249927',2,2,5,3,'frankie.herman','2025-04-06 18:36:26','$2y$12$1LTvkyF1zze10EhXJFjJP.l1vu3q3aslBk/DPwVuTwJQEoWKz4y5C',NULL,NULL,NULL,'sx5jwYZCqq',NULL,NULL,'Active',NULL,'2025-04-06 18:36:26','2025-04-07 11:30:12'),(4,'Myrl','Wilkinson','B',NULL,'Male','2001-03-15','ogutmann@example.com',NULL,'09465132682','2nd Year','20249776',2,2,5,3,'gaetano26','2025-04-06 18:36:26','$2y$12$Up1xVblBnvX6KkcnQumt7OQDqdp0px/yMtMEOphlCWrx4IqVscFsK',NULL,NULL,NULL,'XPk8H9YNV3',NULL,NULL,'Deactivated',NULL,'2025-04-06 18:36:26','2025-04-07 11:07:01'),(5,'Cortez','Breitenberg','R',NULL,'Female','2014-09-07','daisy54@example.com',NULL,'09744574127','1st Year','20240977',2,2,5,1,'kautzer.adolfo','2025-04-06 18:36:26','$2y$12$iri1tusTGfnz85bKB6d4sOQaUlbzwE4t5QMR18CgXEDdVmnw/W/Fy',NULL,NULL,NULL,'gJaxCfEZu0',NULL,NULL,'Deactivated',NULL,'2025-04-06 18:36:27','2025-04-07 11:07:57'),(6,'Lauryn','Hill','T',NULL,'Female','1976-07-19','moen.esteban@example.net',NULL,'09442985602','4th Year','20247739',2,2,5,2,'cormier.valentina','2025-04-06 18:36:27','$2y$12$wUMGnQrSyrjPpBt2wfdrLO06V2nDj3gRcna7oo.qXckETSIBOWSFO',NULL,NULL,NULL,'AevXZaTrOl',NULL,NULL,'Deactivated',NULL,'2025-04-06 18:36:27','2025-04-07 11:09:42'),(7,'Barrett','Hodkiewicz','S',NULL,'Male','1986-07-18','gfahey@example.net',NULL,'09634234291','4th Year','20243505',2,2,5,2,'dennis.dibbert','2025-04-06 18:36:27','$2y$12$3os1Q5micqFCDQeinwtrmu3VaFWl3FBC7bXaXIBWhF0R6GuAI8xRi',NULL,NULL,NULL,'QKZi2Z2yvJ',NULL,NULL,'Deactivated',NULL,'2025-04-06 18:36:27','2025-04-07 11:10:35'),(8,'Raphael','Abshire','C',NULL,'Female','1976-07-11','mmills@example.com',NULL,'09499021675','3rd Year','20243860',2,2,5,2,'quinn76','2025-04-06 18:36:27','$2y$12$LDjleAlPkos41B0Kv1q8TuPPKPK2y8AmKw/D.Lw7Bnf4S1kod1r9.',NULL,NULL,NULL,'zy5gucUstb',NULL,NULL,'Deactivated',NULL,'2025-04-06 18:36:27','2025-04-07 11:11:10'),(9,'Itzel','Pagac','Y',NULL,'Male','2023-10-09','jay13@example.org',NULL,'09288990825','4th Year','20241817',2,2,5,1,'johann26','2025-04-06 18:36:27','$2y$12$7rb4.09n9RjUHezxyz.meOCCsmJaX007cAqyRrPE6XEjtYG3roBRW',NULL,NULL,NULL,'aWFMGAofa3',NULL,NULL,'Deactivated',NULL,'2025-04-06 18:36:28','2025-04-07 11:13:30'),(10,'Colleen','Hegmann','A',NULL,'Male','2023-09-14','bkiehn@example.net',NULL,'09538403272','3rd Year','20240517',2,2,5,1,'america.johnson','2025-04-06 18:36:28','$2y$12$0iQ1v/ljcIWUd3ba0N1gu.9k7eHgCfl32bkaA8XMLrFVrvPZwxq/.',NULL,NULL,NULL,'Y6vlxBz2XH',NULL,NULL,'Active',NULL,'2025-04-06 18:36:28','2025-04-06 18:36:28'),(11,'Maudie','Hermiston','Y',NULL,'Male','2022-01-31','dickens.arjun@example.org',NULL,'09668728419','3rd Year','20243752',2,2,5,1,'clay53','2025-04-06 18:36:28','$2y$12$jchjnl2C1vjSntz2FiPS3eIqad3/gAXxxGTfW/d7SeXBLjZcPwgNK',NULL,NULL,NULL,'AHOLAEFt36',NULL,NULL,'Active',NULL,'2025-04-06 18:36:28','2025-04-06 18:36:28'),(12,'Dan','Daugherty','Z',NULL,'Male','1973-04-08','moore.jacynthe@example.net',NULL,'09345101037','1st Year','20241277',2,2,5,3,'trantow.bethany','2025-04-06 18:36:28','$2y$12$LBo2hKEugtfiRzXh7Ngtpux.aasK15oDNND5YEL0Kj/LTb.YF7U6y',NULL,NULL,NULL,'iXruST3har',NULL,NULL,'Active',NULL,'2025-04-06 18:36:28','2025-04-06 18:36:28'),(13,'Ignatius','Hessel','S',NULL,'Female','2009-11-18','oankunding@example.org',NULL,'09215509274','2nd Year','20242457',2,2,5,1,'fdavis','2025-04-06 18:36:28','$2y$12$GFI3fqY5bubsPagLZZ7XPe.kF2KKWzvsaR70UI9WvjjgjsbFaceEa',NULL,NULL,NULL,'hIrPiHc2kv',NULL,NULL,'Active',NULL,'2025-04-06 18:36:28','2025-04-06 18:36:28'),(14,'Cassandra','Cummings','Y',NULL,'Female','1982-01-03','mueller.maurice@example.org',NULL,'09891742120','3rd Year','20243703',2,2,5,3,'srohan','2025-04-06 18:36:28','$2y$12$gwWiSPTfYsU4aoA6.uysyucFwKdtefw4SN9FR9.fhFxH5wIQChECO',NULL,NULL,NULL,'SWJV7CjA7K',NULL,NULL,'Active',NULL,'2025-04-06 18:36:29','2025-04-06 18:36:29'),(15,'Velda','Zboncak','J',NULL,'Male','2024-08-26','patience44@example.org',NULL,'09487784005','1st Year','20247270',2,2,5,2,'mittie.bode','2025-04-06 18:36:29','$2y$12$7gcLWbrQ/U3Eumu6zxapsee7j8.h7e.0pNceNwhQzCkTYgY3as/2G',NULL,NULL,NULL,'sKHuHDFV3c',NULL,NULL,'Active',NULL,'2025-04-06 18:36:29','2025-04-06 18:36:29'),(16,'Cristal','Shields','K',NULL,'Female','2024-09-27','lowe.bridgette@example.com',NULL,'09582304776','2nd Year','20249852',2,2,5,2,'sid46','2025-04-06 18:36:29','$2y$12$jWN4n6pNoCCkq227yu16su6sl2W7EmubZSafGXmAvYmLyOVoOC3B2',NULL,NULL,NULL,'IDMy5v3ZUA',NULL,NULL,'Active',NULL,'2025-04-06 18:36:29','2025-04-06 18:36:29'),(17,'Guido','Hegmann','B',NULL,'Male','2020-08-07','kwehner@example.com',NULL,'09095232890','3rd Year','20245727',2,2,5,2,'blanche.heaney','2025-04-06 18:36:29','$2y$12$yxOL3AvAc3C0qAwXqX9ZPuBFOYLuK4pifNI61wpolKWsF7zLrWPhu',NULL,NULL,NULL,'5cFmYbgf8Q',NULL,NULL,'Active',NULL,'2025-04-06 18:36:29','2025-04-06 18:36:29'),(18,'Electa','Maggio','H',NULL,'Female','1984-02-08','daugherty.rudolph@example.com',NULL,'09722491123','1st Year','20240928',2,2,5,3,'caleigh35','2025-04-06 18:36:29','$2y$12$HkZXRkdSZdbTNc2UKLEzW.98Jdn.tLVQeXjTFFZt6wV7O0kZIx27y',NULL,NULL,NULL,'Y7m1lDYfEr',NULL,NULL,'Active',NULL,'2025-04-06 18:36:30','2025-04-06 18:36:30'),(19,'Christophe','Lebsack','E',NULL,'Male','2020-05-06','bogan.elmira@example.net',NULL,'09825772795','1st Year','20245808',2,2,5,1,'kaycee04','2025-04-06 18:36:30','$2y$12$ArrDJ7c9sCD20W2jnSjMa.23rHwPgnJf03Lrjjiw2fCRkeRcvtuu.',NULL,NULL,NULL,'6YaMxFttHa',NULL,NULL,'Active',NULL,'2025-04-06 18:36:30','2025-04-06 18:36:30'),(20,'Vincenzo','Bins','E',NULL,'Female','1984-08-12','hannah.russel@example.org',NULL,'09363157064','2nd Year','20246067',2,2,5,3,'armstrong.sallie','2025-04-06 18:36:30','$2y$12$fLNBe91OFGBFBBalxj.kqOWSgfAdkuN2CTcce.JvO4uFI2t8QhCBW',NULL,NULL,NULL,'EjZ4KYxOXD',NULL,NULL,'Active',NULL,'2025-04-06 18:36:30','2025-04-06 18:36:30'),(21,'Jaylen','McCullough','O',NULL,'Female','1989-10-02','ritchie.noel@example.com',NULL,'09070984321','1st Year','20246744',2,2,5,3,'clemmie.predovic','2025-04-06 18:36:30','$2y$12$OQF9ASvqvjKIjGJosRl7p.PFZ8R70W06t6/euIsYfkPeCScRyRBjy',NULL,NULL,NULL,'ih2nLj3e59',NULL,NULL,'Active',NULL,'2025-04-06 18:36:30','2025-04-06 18:36:30'),(22,'Ladarius','Kunde','Y',NULL,'Male','2007-05-28','cortez99@example.net',NULL,'09372154196','2nd Year','20243480',2,2,5,3,'nkertzmann','2025-04-06 18:36:30','$2y$12$/AFZIfJOJczu6YJYi9wgEexi5rcyHFkXSOpXnYWMrk2u3U8VEq6jG',NULL,NULL,NULL,'CzVaHdbOFU',NULL,NULL,'Active',NULL,'2025-04-06 18:36:31','2025-04-06 18:36:31'),(23,'Jermain','Mueller','E',NULL,'Female','1990-06-20','xkshlerin@example.net',NULL,'09746924455','4th Year','20245089',2,2,5,1,'viviane79','2025-04-06 18:36:31','$2y$12$i9ZXh9YtN7JT9U1ddhWd0e8FWOJDDET6l7JTCmejKXwZ0P.8lvIAS',NULL,NULL,NULL,'sYDfmlpmSw',NULL,NULL,'Active',NULL,'2025-04-06 18:36:31','2025-04-06 18:36:31'),(24,'Emelia','O\'Connell','U',NULL,'Male','2008-04-17','yrempel@example.net',NULL,'09600653895','1st Year','20248122',2,2,5,3,'jayce03','2025-04-06 18:36:31','$2y$12$rs96CuPxZ3vr8tdziB9KROXhfayNT8f1At1obOFSdK5VbWP9QSISS',NULL,NULL,NULL,'zOjXfX8tLs',NULL,NULL,'Active',NULL,'2025-04-06 18:36:31','2025-04-06 18:36:31'),(25,'Nellie','Boyle','L',NULL,'Female','2015-12-13','bailey.tillman@example.net',NULL,'09751501909','4th Year','20242573',2,2,5,2,'kgerlach','2025-04-06 18:36:31','$2y$12$zm4rr626GDoPWunKbflacOk8SbOXzG7JdoBtxn/x.A.t6doEXi0.y',NULL,NULL,NULL,'7Avc5cR1rW',NULL,NULL,'Active',NULL,'2025-04-06 18:36:31','2025-04-06 18:36:31'),(26,'Tom','Ebert','J',NULL,'Male','2011-03-11','kerluke.darryl@example.net',NULL,'09264640592','2nd Year','20246467',2,2,5,3,'dewitt04','2025-04-06 18:36:31','$2y$12$JQOHtWF0EyDa0eRPcK1FJu5U66cvRHOkGPICWXXPtZK6ebtDkaFr.',NULL,NULL,NULL,'xY8EdukCmX',NULL,NULL,'Active',NULL,'2025-04-06 18:36:32','2025-04-06 18:36:32'),(27,'Hallie','King','N',NULL,'Male','1996-06-09','gleason.kiel@example.org',NULL,'09576199615','2nd Year','20249520',2,2,5,2,'gutkowski.derick','2025-04-06 18:36:32','$2y$12$gxLxFw8jcsYqiX32ALWgxub84wOj9rWLnP1aw9OKjJcomdrXb..6a',NULL,NULL,NULL,'83COjnYY1L',NULL,NULL,'Active',NULL,'2025-04-06 18:36:32','2025-04-06 18:36:32'),(28,'Levi','Barrows','I',NULL,'Male','1974-01-21','demond03@example.net',NULL,'09603911158','1st Year','20247332',2,2,5,3,'rfeil','2025-04-06 18:36:32','$2y$12$6j5JQTAsjG1egoHKLpYSzO47JP0ExUQi3TjFYDQs.8EE6HqEgTlu2',NULL,NULL,NULL,'LxqsQ2y0gH',NULL,NULL,'Active',NULL,'2025-04-06 18:36:32','2025-04-06 18:36:32'),(29,'Ward','Grimes','X',NULL,'Male','1998-12-19','anne.oconnell@example.net',NULL,'09392761041','3rd Year','20242861',2,2,5,1,'berniece70','2025-04-06 18:36:32','$2y$12$nRoOIujJN3wdBjzIJpmIwuHQOaIoL6J3GNwNf2F8yLQx4ZnsG3d.W',NULL,NULL,NULL,'zaSzIS72Mq',NULL,NULL,'Active',NULL,'2025-04-06 18:36:32','2025-04-06 18:36:32'),(30,'Sage','Bogan','L',NULL,'Female','1981-02-21','hudson.archibald@example.org',NULL,'09704389217','4th Year','20240653',2,2,5,1,'rjohnston','2025-04-06 18:36:32','$2y$12$PoKZlX..b4NU5u1.zZBbYuJxUc8PMylCgya88pdr/JI.g51WZOAgi',NULL,NULL,NULL,'5f8o7kcBWL',NULL,NULL,'Active',NULL,'2025-04-06 18:36:33','2025-04-06 18:36:33'),(31,'Camryn','Bosco','K',NULL,'Male','2016-10-21','aditya.tillman@example.org',NULL,'09189166674','2nd Year','20240172',2,2,5,2,'jhoppe','2025-04-06 18:36:33','$2y$12$BBM4Y0q1dONmBldX31clVOsD.mueiLf29/cwl4dVS8kguVPKDnMkG',NULL,NULL,NULL,'fpOGndB8fu',NULL,NULL,'Active',NULL,'2025-04-06 18:36:33','2025-04-06 18:36:33'),(32,'Randal','Zboncak','Y',NULL,'Male','1997-07-16','aidan95@example.org',NULL,'09759284667','1st Year','20240620',2,2,5,1,'skertzmann','2025-04-06 18:36:33','$2y$12$rFl/HP7qYZx.ESVg/KCOm.lmidqOpapZRzZ3RAqjmu6m.xkMUdZ4S',NULL,NULL,NULL,'Xw9OeaqjOy',NULL,NULL,'Active',NULL,'2025-04-06 18:36:33','2025-04-06 18:36:33'),(33,'Nash','Lowe','F',NULL,'Male','1991-07-23','verona.durgan@example.net',NULL,'09816256959','3rd Year','20240045',2,2,5,2,'iwaters','2025-04-06 18:36:33','$2y$12$v3T7mlyC5cHn1tk.BzUuxe2Gec3WdH5cWJi2cZ.HUtnOfoPJF1QYq',NULL,NULL,NULL,'CP9t6yrBzO',NULL,NULL,'Active',NULL,'2025-04-06 18:36:33','2025-04-06 18:36:33'),(34,'Gail','Hoppe','V',NULL,'Female','1993-01-10','sarina.effertz@example.org',NULL,'09291853421','3rd Year','20245744',2,2,5,1,'xweissnat','2025-04-06 18:36:33','$2y$12$0XpUzZToPZwuGMdikpOiVOiGayGAg7mNgofZ5FpM89Y87Q4RRzw6S',NULL,NULL,NULL,'CwVUSwWW26',NULL,NULL,'Active',NULL,'2025-04-06 18:36:33','2025-04-06 18:36:33'),(35,'Providenci','Mann','C',NULL,'Female','1977-01-28','nitzsche.noah@example.net',NULL,'09184736955','1st Year','20240351',2,2,5,3,'beatty.mellie','2025-04-06 18:36:33','$2y$12$nszWZ9Fbb.D1q9O3VL1TzOiBhc8iuIvsAAqJumc2vxiSDnE8qkmMO',NULL,NULL,NULL,'9lKf5zzcy3',NULL,NULL,'Active',NULL,'2025-04-06 18:36:34','2025-04-06 18:36:34'),(36,'Dax','Mann','B',NULL,'Female','2000-02-01','kmoore@example.com',NULL,'09254754418','2nd Year','20241672',2,2,5,2,'conroy.rosina','2025-04-06 18:36:34','$2y$12$UHrWqaHK5.GM/ifPihNXxOgBKUKWDdmPD.JxgeWYdE/8uAOuPVSra',NULL,NULL,NULL,'0xCZ4T1KLy',NULL,NULL,'Active',NULL,'2025-04-06 18:36:34','2025-04-06 18:36:34'),(37,'Dahlia','Moen','I',NULL,'Male','2021-07-16','elouise71@example.net',NULL,'09124660315','1st Year','20241975',2,2,5,3,'florian.labadie','2025-04-06 18:36:34','$2y$12$CnjpcD4Zmx5edWLEOnudyOJPIf1QwXUocdw/Gi3w2ATdp0uBeYLBe',NULL,NULL,NULL,'VRFkjzV7Hd',NULL,NULL,'Active',NULL,'2025-04-06 18:36:34','2025-04-06 18:36:34'),(38,'Connie','Rau','L',NULL,'Male','1979-06-22','brendan41@example.org',NULL,'09389495584','1st Year','20247361',2,2,5,1,'borer.brandyn','2025-04-06 18:36:34','$2y$12$.8sl.0Tbg91tW1yWN3aQzeW9xU90UzYWcBAMyXT4pk/Fd5jGMojs.',NULL,NULL,NULL,'xtPrRugSYb',NULL,NULL,'Active',NULL,'2025-04-06 18:36:34','2025-04-06 18:36:34'),(39,'Erin','Bergstrom','I',NULL,'Female','1994-06-29','tanya05@example.com',NULL,'09414039848','1st Year','20246715',2,2,5,1,'hskiles','2025-04-06 18:36:34','$2y$12$Sg.3OxTBs/vPl2jR6KquaOgojzZlOnb/M7gp2kKORU.ZuuHCuRLfi',NULL,NULL,NULL,'ZOSi9Y9wGI',NULL,NULL,'Active',NULL,'2025-04-06 18:36:35','2025-04-06 18:36:35'),(40,'Micaela','Bartoletti','Z',NULL,'Male','1998-11-19','johnson.merle@example.net',NULL,'09664272334','3rd Year','20249870',2,2,5,1,'urunte','2025-04-06 18:36:35','$2y$12$cfjRpR7/R5B.mL9NMtCcjuJEjeLA6FnrX7lhcpedgCnSPQWmtiBoi',NULL,NULL,NULL,'h4tIMWZkq3',NULL,NULL,'Active',NULL,'2025-04-06 18:36:35','2025-04-06 18:36:35'),(41,'Mac','Parker','M',NULL,'Male','2010-03-02','landen.gerlach@example.org',NULL,'09769705452','1st Year','20245695',2,2,5,1,'nia08','2025-04-06 18:36:35','$2y$12$0JP0UAXPkctoTWuQ8/32O.DnIHxU7pIydQn/5QFTrQgDJ6YVv/eQG',NULL,NULL,NULL,'8ihtXKZzdE',NULL,NULL,'Active',NULL,'2025-04-06 18:36:35','2025-04-06 18:36:35'),(42,'Arnaldo','Kris','J',NULL,'Male','1998-04-15','wuckert.brandy@example.org',NULL,'09519262638','2nd Year','20240473',2,2,5,3,'wschinner','2025-04-06 18:36:35','$2y$12$rmbTalbC6fW6SreheJCiPuEghNII8igECBfaP2N2J1xhWsSj93gI.',NULL,NULL,NULL,'tyIrvUPMvX',NULL,NULL,'Active',NULL,'2025-04-06 18:36:35','2025-04-06 18:36:35'),(43,'Carley','Bashirian','X',NULL,'Male','2020-05-29','volkman.eleanore@example.net',NULL,'09334691574','4th Year','20243825',2,2,5,2,'stehr.jazmyne','2025-04-06 18:36:35','$2y$12$y.tRxEynyzftLr//wC3XeeEhtPQVO49gyFXU/g7u7rqPt/VVVLbY.',NULL,NULL,NULL,'qjldd6J39f',NULL,NULL,'Active',NULL,'2025-04-06 18:36:36','2025-04-06 18:36:36'),(44,'Peter','Schmitt','F',NULL,'Female','2020-07-06','gregorio.weber@example.org',NULL,'09945017467','2nd Year','20246384',2,2,5,1,'armstrong.josephine','2025-04-06 18:36:36','$2y$12$K/eIN9syM1cC.rBnF34IfOYH7vYbAXZ.jHnnKXHXGCCd3xg5A0OdW',NULL,NULL,NULL,'9cfzPKt1OG',NULL,NULL,'Active',NULL,'2025-04-06 18:36:36','2025-04-06 18:36:36'),(45,'Keegan','Gusikowski','Z',NULL,'Female','2000-10-31','klocko.thalia@example.com',NULL,'09462579169','3rd Year','20240773',2,2,5,3,'aglae38','2025-04-06 18:36:36','$2y$12$BtxuPDIrB0TKZFDb8OyDIOzgmapflWF2bCd05v5vqEI7nXGzj/5Oa',NULL,NULL,NULL,'Q6CwRUAi5F',NULL,NULL,'Active',NULL,'2025-04-06 18:36:36','2025-04-06 18:36:36'),(46,'Gaston','Dare','Z',NULL,'Male','2000-05-15','wquigley@example.org',NULL,'09969917685','4th Year','20246685',2,2,5,2,'katelynn.deckow','2025-04-06 18:36:36','$2y$12$zq2/P5M10f9T2DE.9TzYweCNUop.sOtZhYwlr.JmRdP/e3KvX86zq',NULL,NULL,NULL,'NheoQ9Drms',NULL,NULL,'Active',NULL,'2025-04-06 18:36:36','2025-04-06 18:36:36'),(47,'Ramiro','Bosco','V',NULL,'Female','1997-05-24','ugibson@example.net',NULL,'09466491523','4th Year','20242874',2,2,5,1,'schneider.doyle','2025-04-06 18:36:36','$2y$12$oFhbxOuYcCkP85FO5NRuLerhr.WIOKneWUBitGVxiCi.oGMZNsr82',NULL,NULL,NULL,'VqwsIYahBC',NULL,NULL,'Active',NULL,'2025-04-06 18:36:37','2025-04-06 18:36:37'),(48,'Ron','Schmeler','E',NULL,'Male','2010-09-29','talon42@example.net',NULL,'09904287542','1st Year','20244186',2,2,5,3,'blangworth','2025-04-06 18:36:37','$2y$12$imNhihgbYNJMVFdul3G5cu65Q70JYT8bHtaBj5L9W75L2ypQCagHy',NULL,NULL,NULL,'YJVeapoE9c',NULL,NULL,'Active',NULL,'2025-04-06 18:36:37','2025-04-06 18:36:37'),(49,'Quentin','Strosin','L',NULL,'Female','2008-02-26','ryann91@example.com',NULL,'09785533903','2nd Year','20242674',2,2,5,2,'kane.bahringer','2025-04-06 18:36:37','$2y$12$uVjNURno7ZhCL0oJ1WzsKumRRk7B5.sFNqvYrBdKYDKJws90CMwOO',NULL,NULL,NULL,'hBCgU5zGpb',NULL,NULL,'Active',NULL,'2025-04-06 18:36:37','2025-04-06 18:36:37'),(50,'Jakob','Lindgren','C',NULL,'Male','1970-02-24','lukas21@example.net',NULL,'09599803900','1st Year','20246572',2,2,5,1,'arlene.anderson','2025-04-06 18:36:37','$2y$12$gwn6EZ8Wyd5FkwJ3f0eH4ONt2veXX2AYDk0LUGLOubrWqRgYrc.QS',NULL,NULL,NULL,'qumNUMaU45',NULL,NULL,'Active',NULL,'2025-04-06 18:36:37','2025-04-06 18:36:37'),(51,'Rosario','Howe','R',NULL,'Female','1999-01-22','carolina21@example.net',NULL,'09355443988','4th Year','20249096',2,2,5,1,'pacocha.rudolph','2025-04-06 18:36:37','$2y$12$yMyb/8CjLhWBTXSBC0rBd.k6PQ4njWIXLrBlp2.TM82li8Gvb4Hpq',NULL,NULL,NULL,'ldcDOFFE5i',NULL,NULL,'Active',NULL,'2025-04-06 18:36:37','2025-04-06 18:36:37'),(52,'Taya','Toy','E',NULL,'Female','1986-12-01','orin.williamson@example.com',NULL,'09905253282','4th Year','20244434',2,2,5,2,'river60','2025-04-06 18:36:37','$2y$12$fqXL4bICvpczgqT80mBky.sW9u4..QgHdGAAO/CYibJzmYGgqDByy',NULL,NULL,NULL,'pMseVU6uvc',NULL,NULL,'Active',NULL,'2025-04-06 18:36:38','2025-04-06 18:36:38'),(53,'Ardella','Wehner','O',NULL,'Male','2008-06-28','ipfannerstill@example.com',NULL,'09679624032','3rd Year','20243822',2,2,5,2,'darrel61','2025-04-06 18:36:38','$2y$12$D1fArX.8A60m4kHOjaxB.u1Reo7ypu63hz5Iur3TYFX0SOSxvSVvq',NULL,NULL,NULL,'McMl3qL9dW',NULL,NULL,'Active',NULL,'2025-04-06 18:36:38','2025-04-06 18:36:38'),(54,'Elva','Auer','P',NULL,'Female','1972-12-07','eugenia.metz@example.org',NULL,'09866357164','1st Year','20241897',2,2,5,1,'uhyatt','2025-04-06 18:36:38','$2y$12$CHs45UkQN6sRn0HkCy8VB.oo1JR3H150t723AhLypwzfL8Nmyhiri',NULL,NULL,NULL,'53BxnXh0AA',NULL,NULL,'Active',NULL,'2025-04-06 18:36:38','2025-04-06 18:36:38'),(55,'Davon','Conroy','V',NULL,'Female','2022-04-05','manuel.welch@example.net',NULL,'09221822119','1st Year','20241204',2,2,5,3,'schowalter.jarrell','2025-04-06 18:36:38','$2y$12$NgpGtoRwTQr2jYuP/P4xS.BykkNNJ2k8iH7EgOlwWGW2nUOIYxP1C',NULL,NULL,NULL,'6HEzVtoLU3',NULL,NULL,'Active',NULL,'2025-04-06 18:36:38','2025-04-06 18:36:38'),(56,'Raheem','Terry','B',NULL,'Male','1991-06-09','vandervort.martin@example.com',NULL,'09555910067','2nd Year','20245846',2,2,5,3,'west.daniela','2025-04-06 18:36:38','$2y$12$f2/jfkL5mknk/l2wTAiEFuy6nMZHKBM2AqO.u63ej1tETmm2dd2w2',NULL,NULL,NULL,'viWUeOSoti',NULL,NULL,'Active',NULL,'2025-04-06 18:36:39','2025-04-06 18:36:39'),(57,'Nelle','Schmeler','P',NULL,'Female','1978-03-23','valentin46@example.org',NULL,'09072141302','3rd Year','20241329',2,2,5,1,'bernie23','2025-04-06 18:36:39','$2y$12$kBjjswwcl3L/X1tZAxLfuud2C.A/RRrASbEuyVFmZB7Utkzzx3R1.',NULL,NULL,NULL,'aBtrUmMvks',NULL,NULL,'Active',NULL,'2025-04-06 18:36:39','2025-04-06 18:36:39'),(58,'Al','Kuhn','A',NULL,'Male','1984-12-26','twila.reichert@example.com',NULL,'09715156269','2nd Year','20244251',2,2,5,2,'ellie.wilkinson','2025-04-06 18:36:39','$2y$12$isMQeOJNKu6rkxrbrrweeOpCTFemvnFjsCJcSj.8IyP3c90ysq54O',NULL,NULL,NULL,'PYN6sd3NJh',NULL,NULL,'Active',NULL,'2025-04-06 18:36:39','2025-04-06 18:36:39'),(59,'Jeramie','Ryan','Q',NULL,'Male','1977-01-22','joannie.russel@example.net',NULL,'09154308429','1st Year','20248383',2,2,5,2,'elfrieda.schumm','2025-04-06 18:36:39','$2y$12$oldSm0sSnPswIDOY1acjcO93.qjv3U3WcqpnvzzdOkDPvRLV9WD2O',NULL,NULL,NULL,'eptWNdDid1',NULL,NULL,'Active',NULL,'2025-04-06 18:36:39','2025-04-06 18:36:39'),(60,'Helmer','Windler','D',NULL,'Male','2021-09-13','nitzsche.calista@example.com',NULL,'09248104642','1st Year','20244236',2,2,5,1,'ohirthe','2025-04-06 18:36:39','$2y$12$3ooaUeuKiQyldH7nYzIYNuT.d3VUy2i2NwrmHzdHX3yEnXwgrdbp.',NULL,NULL,NULL,'amcmDqrCnp',NULL,NULL,'Active',NULL,'2025-04-06 18:36:40','2025-04-06 18:36:40'),(61,'Mollie','Grant','W',NULL,'Female','1973-04-15','lhirthe@example.net',NULL,'09022013459','2nd Year','20241545',2,2,5,3,'cwaters','2025-04-06 18:36:40','$2y$12$EcVi2ATeHEGLPhJcf7us7OWs42f95/FG3DRDS9YWd815FNkvENTwa',NULL,NULL,NULL,'CIEAvnvlyN',NULL,NULL,'Active',NULL,'2025-04-06 18:36:40','2025-04-06 18:36:40'),(62,'Junior','Quigley','O',NULL,'Male','1998-11-12','kuvalis.hollie@example.net',NULL,'09601885640','4th Year','20245952',2,2,5,2,'macey27','2025-04-06 18:36:40','$2y$12$8AZNjzR4lX1lCWb69mplo.VWZcF0w9dJ2e0otyJP4m0x2m8fNKdBq',NULL,NULL,NULL,'cvFXgkgPXY',NULL,NULL,'Active',NULL,'2025-04-06 18:36:40','2025-04-06 18:36:40'),(63,'Sheridan','Beier','G',NULL,'Female','2018-11-11','schmidt.roberta@example.net',NULL,'09954933046','2nd Year','20246152',2,2,5,1,'orn.alford','2025-04-06 18:36:40','$2y$12$9Mo/6zSyjJAGy.eCPJ.fiujSJTEgUeW9BwL3QtDE9POUnRrKSnomi',NULL,NULL,NULL,'E9UDvlIh1P',NULL,NULL,'Active',NULL,'2025-04-06 18:36:40','2025-04-06 18:36:40'),(64,'Gilbert','Raynor','P',NULL,'Male','2022-08-22','hreichel@example.net',NULL,'09394195103','1st Year','20249477',2,2,5,2,'mariela52','2025-04-06 18:36:40','$2y$12$We5k6RjkUFi0O642DcV5RuMfMuiIz/l.DOwr5BV5DXmx4Hrre3dMy',NULL,NULL,NULL,'2yLWIYMNud',NULL,NULL,'Active',NULL,'2025-04-06 18:36:41','2025-04-06 18:36:41'),(65,'Rowland','Lesch','T',NULL,'Female','2013-06-04','pbrekke@example.com',NULL,'09855568233','1st Year','20241530',2,2,5,2,'myrtie84','2025-04-06 18:36:41','$2y$12$.Qm77.6QRCUDQKnWOAbfqe2euQ6LNcnbTxLzxuqunixvKyCTxioOS',NULL,NULL,NULL,'olVzCN12z2',NULL,NULL,'Active',NULL,'2025-04-06 18:36:41','2025-04-06 18:36:41'),(66,'Rodrigo','O\'Reilly','Z',NULL,'Female','1988-08-01','kianna.olson@example.org',NULL,'09012251336','3rd Year','20247141',2,2,5,2,'alexandria91','2025-04-06 18:36:41','$2y$12$.OMoorV32zY9xUFu6Bjn9.Yr3wgkh1..UEIvyMJIcx4Hjeg0LxrU2',NULL,NULL,NULL,'7uYD36qe4k',NULL,NULL,'Active',NULL,'2025-04-06 18:36:41','2025-04-06 18:36:41'),(67,'Destiny','Kling','M',NULL,'Female','2018-12-02','jannie.anderson@example.net',NULL,'09551704366','2nd Year','20248411',2,2,5,1,'nya.mcdermott','2025-04-06 18:36:41','$2y$12$/FUkqhbOd6YPTiLV/7cdMOrYl/brtoxvXbt9RZTgrgO3Fofy8IA2K',NULL,NULL,NULL,'epPukVsEu5',NULL,NULL,'Active',NULL,'2025-04-06 18:36:41','2025-04-06 18:36:41'),(68,'Cleora','Ernser','E',NULL,'Male','2013-03-30','mschmitt@example.org',NULL,'09957446665','3rd Year','20246055',2,2,5,1,'boyer.nels','2025-04-06 18:36:41','$2y$12$SZGGi5.dgjeEgqUMXMxlH.1XSqwo5NhWeFeM4Jf8E5RFQAquS8fXO',NULL,NULL,NULL,'PEPUboTQoR',NULL,NULL,'Active',NULL,'2025-04-06 18:36:41','2025-04-06 18:36:41'),(69,'Garret','Bauch','R',NULL,'Male','1989-08-20','hailey05@example.org',NULL,'09502346036','1st Year','20247805',2,2,5,2,'frami.zoie','2025-04-06 18:36:41','$2y$12$1oObCa4q27mrYV9h37IaauUmxzoqno4r02pRKY51BLVYDfDL2Dpve',NULL,NULL,NULL,'RC5Ua4zEx0',NULL,NULL,'Active',NULL,'2025-04-06 18:36:42','2025-04-06 18:36:42'),(70,'Aliza','Bode','K',NULL,'Male','1988-11-20','lilliana59@example.org',NULL,'09234345394','1st Year','20246959',2,2,5,1,'shields.breanna','2025-04-06 18:36:42','$2y$12$W2RRSri2/CJ7yAiqGrMn7O0pTyRzLlnEhjxOBtGXMpIFH9C3a3csm',NULL,NULL,NULL,'pCOSN1yTN4',NULL,NULL,'Active',NULL,'2025-04-06 18:36:42','2025-04-06 18:36:42'),(71,'Tierra','Feest','T',NULL,'Male','2015-11-13','braun.hallie@example.com',NULL,'09093777645','1st Year','20242112',2,2,5,3,'camylle17','2025-04-06 18:36:42','$2y$12$ZYnPGUMuBcozIXMl7kSDJupScsOKL8R9koDcpWjzqyXq6O8bLoCQu',NULL,NULL,NULL,'d2SU6CJzgh',NULL,NULL,'Active',NULL,'2025-04-06 18:36:42','2025-04-06 18:36:42'),(72,'Retha','Douglas','Q',NULL,'Male','1980-05-10','qschinner@example.org',NULL,'09401840773','2nd Year','20244621',2,2,5,3,'hauck.kristopher','2025-04-06 18:36:42','$2y$12$GX35Giuhq4L2Zs612pPG9O1ltXfxpitbyyuTeBYVJyCwx9oTMd/xS',NULL,NULL,NULL,'wUecDfIbEN',NULL,NULL,'Active',NULL,'2025-04-06 18:36:42','2025-04-06 18:36:42'),(73,'Jamie','Pagac','K',NULL,'Female','2011-06-12','katrine29@example.org',NULL,'09218440976','1st Year','20248085',2,2,5,1,'blick.theresa','2025-04-06 18:36:42','$2y$12$ISnZZ1P6N4vRr1QB3JUL6OPdCVwBQm/WHqEz88U9TckQ.P.RriY/y',NULL,NULL,NULL,'L6MhzmspW0',NULL,NULL,'Active',NULL,'2025-04-06 18:36:43','2025-04-06 18:36:43'),(74,'Micheal','Thiel','M',NULL,'Female','1974-11-12','geichmann@example.com',NULL,'09744447626','1st Year','20244839',2,2,5,1,'austyn49','2025-04-06 18:36:43','$2y$12$MUu52P7fmAj2N1UPtCdpsuHJQrpdvek3nKLXMs1Jb9lEfTEdYt/ei',NULL,NULL,NULL,'u9Hztyve4b',NULL,NULL,'Active',NULL,'2025-04-06 18:36:43','2025-04-06 18:36:43'),(75,'Lura','Stanton','I',NULL,'Male','2010-11-25','dziemann@example.org',NULL,'09029525830','3rd Year','20246144',2,2,5,1,'linnea62','2025-04-06 18:36:43','$2y$12$KDclpWipFPs.H1p1XUOxVeKlmZkW5KY3wQTQDfhBkp7WRr8cjgKHi',NULL,NULL,NULL,'ZDLVXsjOpt',NULL,NULL,'Active',NULL,'2025-04-06 18:36:43','2025-04-06 18:36:43'),(76,'Corrine','Keeling','N',NULL,'Male','2003-10-06','gerardo81@example.org',NULL,'09702832144','3rd Year','20246666',2,2,5,1,'titus.fisher','2025-04-06 18:36:43','$2y$12$1uHJvwNLNjmWAyOCdlT.uOX2yO5IIgLYEoTRJagu/Gud5Dr/x0p8m',NULL,NULL,NULL,'jqCQ5UaLBF',NULL,NULL,'Active',NULL,'2025-04-06 18:36:43','2025-04-06 18:36:43'),(77,'Jarvis','Dickens','M',NULL,'Male','1993-07-31','slebsack@example.org',NULL,'09726445306','1st Year','20245323',2,2,5,3,'alexander.koss','2025-04-06 18:36:43','$2y$12$dpr/IOzmaF3xidAT3O/7Te3oYeBaA1CuQeADZtWeTaH5V14y.QCcK',NULL,NULL,NULL,'rKFbyYT6FR',NULL,NULL,'Active',NULL,'2025-04-06 18:36:44','2025-04-06 18:36:44'),(78,'Wilfred','Dibbert','B',NULL,'Male','1972-05-21','stracke.sydni@example.com',NULL,'09832351398','2nd Year','20244679',2,2,5,1,'uyost','2025-04-06 18:36:44','$2y$12$E7xy/E8iA6soM4F0dEwFKO7AgBUH2I7/UBLR8Y1F6URdH1r0NeDaW',NULL,NULL,NULL,'Mm0LNLhtIX',NULL,NULL,'Active',NULL,'2025-04-06 18:36:44','2025-04-06 18:36:44'),(79,'Karine','Johns','Q',NULL,'Female','1985-11-01','xdickens@example.com',NULL,'09692040615','3rd Year','20247409',2,2,5,2,'toni65','2025-04-06 18:36:44','$2y$12$zarT147MTqdfV3JiLmVvu.gL6Hx1ZT8i9KljJ3QwPk.LcSLXnoLgm',NULL,NULL,NULL,'IQEYqsh1wC',NULL,NULL,'Active',NULL,'2025-04-06 18:36:44','2025-04-06 18:36:44'),(80,'Nya','Bergnaum','S',NULL,'Male','2013-06-20','rowe.kaitlyn@example.org',NULL,'09002913381','1st Year','20244537',2,2,5,2,'kunde.ross','2025-04-06 18:36:44','$2y$12$3e1TLaWoo2gPlMcUr0bgquPsWOjxwIqo1yHNj7X5KXPoMSl0OYY8G',NULL,NULL,NULL,'mFBRgfJov0',NULL,NULL,'Active',NULL,'2025-04-06 18:36:44','2025-04-06 18:36:44'),(81,'Destin','Smith','H',NULL,'Female','2001-10-26','mellie82@example.net',NULL,'09277544773','1st Year','20246442',2,2,5,2,'vupton','2025-04-06 18:36:44','$2y$12$tNG11BkA89QwnNZKU9uAq.brtkjBH1F5eQGIxav/kFPyrLuz4gA.i',NULL,NULL,NULL,'debA5BYdUM',NULL,NULL,'Active',NULL,'2025-04-06 18:36:45','2025-04-06 18:36:45'),(82,'Demond','Fahey','R',NULL,'Male','2004-08-19','sylvan13@example.org',NULL,'09449045668','2nd Year','20242943',2,2,5,3,'isabell04','2025-04-06 18:36:45','$2y$12$1x./rh8pFXP730P2OZvP0eOfUU8kw3Ab6m23no88OjSMxl3xezYY.',NULL,NULL,NULL,'kflMSoMZnK',NULL,NULL,'Active',NULL,'2025-04-06 18:36:45','2025-04-06 18:36:45'),(83,'Arvilla','Schmeler','H',NULL,'Male','2007-12-31','anderson.dan@example.net',NULL,'09402454425','3rd Year','20241837',2,2,5,1,'jarod.anderson','2025-04-06 18:36:45','$2y$12$qnw6n59oQQK5tuij10yUAuBsh1254SRwP67wc/.RAJVfuy8DH2OEy',NULL,NULL,NULL,'K5tQSktILM',NULL,NULL,'Active',NULL,'2025-04-06 18:36:45','2025-04-06 18:36:45'),(84,'Lyla','Hodkiewicz','H',NULL,'Female','1978-05-04','jakubowski.juliana@example.com',NULL,'09556746387','1st Year','20241338',2,2,5,1,'camila.mertz','2025-04-06 18:36:45','$2y$12$WRKRPWyCylCY.uqfe9KwK.JRaKwVdfLK0wsc6t5mN1yfTfV70ZpzC',NULL,NULL,NULL,'BTvJaRQ0cf',NULL,NULL,'Active',NULL,'2025-04-06 18:36:45','2025-04-06 18:36:45'),(85,'Grayson','Mayer','D',NULL,'Male','1993-02-17','bernice.schaefer@example.com',NULL,'09707701224','1st Year','20241606',2,2,5,1,'steuber.colt','2025-04-06 18:36:45','$2y$12$y/.GZRIaRhyyLiIb8aTpMOUbAfVC6W1yp7SrHsKpjR6508zjRhCg.',NULL,NULL,NULL,'BKiQmMwkYT',NULL,NULL,'Active',NULL,'2025-04-06 18:36:45','2025-04-06 18:36:45'),(86,'Waino','Ratke','N',NULL,'Male','1994-06-22','feeney.ubaldo@example.net',NULL,'09552791179','1st Year','20249834',2,2,5,1,'abel50','2025-04-06 18:36:45','$2y$12$hosQBqCsrequYSALOHFIn.CIFe6jCLywD5g9gvzgOKtP.bHROyAaa',NULL,NULL,NULL,'dTGWI0uVER',NULL,NULL,'Active',NULL,'2025-04-06 18:36:46','2025-04-06 18:36:46'),(87,'Hershel','Hansen','A',NULL,'Female','1992-02-05','kyla52@example.net',NULL,'09674064355','1st Year','20243569',2,2,5,3,'kirsten33','2025-04-06 18:36:46','$2y$12$jdxcx6J6/AQxXMMHeQ5T2uNfSHKroPm5kPnozurrwp7xoz1BKrCFi',NULL,NULL,NULL,'clu8pg2zel',NULL,NULL,'Active',NULL,'2025-04-06 18:36:46','2025-04-06 18:36:46'),(88,'Yvonne','Konopelski','F',NULL,'Female','2020-11-13','bogan.jaquan@example.com',NULL,'09339143882','4th Year','20246315',2,2,5,1,'shad.kuhn','2025-04-06 18:36:46','$2y$12$2XIVuGWDSy5g3pPXg1vjp.lgknsO4QdGTkZMTXqXfjtxEWh7Ut95K',NULL,NULL,NULL,'BUIQ1jZPFM',NULL,NULL,'Active',NULL,'2025-04-06 18:36:46','2025-04-06 18:36:46'),(89,'Jamey','Heaney','D',NULL,'Female','2004-03-22','yheathcote@example.net',NULL,'09443077408','3rd Year','20242987',2,2,5,3,'telly.vonrueden','2025-04-06 18:36:46','$2y$12$GG1iJgv3cd7T0gFMr1k/deShAKX5Bg4XbI7Z5N0YBUiWBOyWdwinO',NULL,NULL,NULL,'oiJDK4kkDv',NULL,NULL,'Active',NULL,'2025-04-06 18:36:46','2025-04-06 18:36:46'),(90,'Daron','Zulauf','M',NULL,'Female','1989-04-13','lance58@example.com',NULL,'09763116695','3rd Year','20245479',2,2,5,3,'maybell.schoen','2025-04-06 18:36:46','$2y$12$gDamFZn/rnHhi803jcNxiOZlW6hxaEltWAtO7fFczosXN9yUif/Z2',NULL,NULL,NULL,'z97AXk9Fqb',NULL,NULL,'Active',NULL,'2025-04-06 18:36:47','2025-04-06 18:36:47'),(91,'Mac','Schaden','Z',NULL,'Male','1978-03-14','elva.casper@example.com',NULL,'09915355823','1st Year','20245978',2,2,5,2,'zemlak.jamil','2025-04-06 18:36:47','$2y$12$2J8dMCI3GX.yakTsDHQ7LeEl65XsseeTaKoYzZOweayRL0UCTPpk6',NULL,NULL,NULL,'hVokxiRTfW',NULL,NULL,'Active',NULL,'2025-04-06 18:36:47','2025-04-06 18:36:47'),(92,'Rosendo','Brakus','L',NULL,'Male','2015-06-03','kassandra70@example.com',NULL,'09682275456','3rd Year','20242505',2,2,5,1,'verdman','2025-04-06 18:36:47','$2y$12$vzgxQDuZW2dRtqQb/Mbxz.gye753aa8C1cK/L7zZGxMls.ioGUQaK',NULL,NULL,NULL,'s7w0R9cpRi',NULL,NULL,'Active',NULL,'2025-04-06 18:36:47','2025-04-06 18:36:47'),(93,'Bell','Hamill','J',NULL,'Male','2025-03-26','thiel.darius@example.org',NULL,'09476034854','1st Year','20245041',2,2,5,2,'jeremy.mills','2025-04-06 18:36:47','$2y$12$AdqZ0w5f7Szxz3ellw2UweOK3KTy9mqvaGS8sStosdUdyftNC.Nme',NULL,NULL,NULL,'SQZucJo3eY',NULL,NULL,'Active',NULL,'2025-04-06 18:36:47','2025-04-06 18:36:47'),(94,'Ezra','Cremin','L',NULL,'Male','1991-12-20','hyatt.cristina@example.org',NULL,'09534511357','1st Year','20245299',2,2,5,3,'rvonrueden','2025-04-06 18:36:47','$2y$12$muXRn8pl9NC0Wv8kGm3nmeZgmEURN0XJZl3AH9HY4XVWpgb8EjOUO',NULL,NULL,NULL,'h9NI8ds4Po',NULL,NULL,'Active',NULL,'2025-04-06 18:36:48','2025-04-06 18:36:48'),(95,'Nyasia','Brakus','Y',NULL,'Male','1986-10-27','zula.hegmann@example.net',NULL,'09601002934','2nd Year','20245902',2,2,5,2,'sberge','2025-04-06 18:36:48','$2y$12$XGU5BqkSwpty4BLwJHqYzuzH6TeVcrxVn43MNVETr4J3E5v4IY0ZO',NULL,NULL,NULL,'Z8c42YFOf5',NULL,NULL,'Active',NULL,'2025-04-06 18:36:48','2025-04-06 18:36:48'),(96,'Richard','Baumbach','M',NULL,'Female','1987-10-10','minnie71@example.org',NULL,'09187495586','3rd Year','20246175',2,2,5,2,'pouros.peggie','2025-04-06 18:36:48','$2y$12$ZMydvsB9ZepCsIHuLcjnCOlK7evIs1qdvKqmYnNUdgN3BnyxvARU2',NULL,NULL,NULL,'IpfhAscI8p',NULL,NULL,'Active',NULL,'2025-04-06 18:36:48','2025-04-06 18:36:48'),(97,'Aric','Green','F',NULL,'Female','1994-03-30','jeffery.greenfelder@example.com',NULL,'09408853938','3rd Year','20247235',2,2,5,2,'morar.kaylee','2025-04-06 18:36:48','$2y$12$IcqXzaDH22NgFmxjSDp44uyVhtqZo41GfQ.unmtOyDv2WDbpSBgIS',NULL,NULL,NULL,'CvsnaEr9II',NULL,NULL,'Active',NULL,'2025-04-06 18:36:48','2025-04-06 18:36:48'),(98,'Alysson','Schimmel','E',NULL,'Male','1975-01-23','tressa.rolfson@example.com',NULL,'09985698714','2nd Year','20244416',2,2,5,3,'kenyatta27','2025-04-06 18:36:48','$2y$12$J9qTcYQabyEpspApvx.t/.ZVx6jjkEimRcR.2OXRn/J.Y3ctIjJce',NULL,NULL,NULL,'RBs9N9scwc',NULL,NULL,'Active',NULL,'2025-04-06 18:36:49','2025-04-06 18:36:49'),(99,'Eddie','Willms','F',NULL,'Male','2009-10-26','hilpert.sister@example.org',NULL,'09992671434','2nd Year','20241875',2,2,5,1,'richard15','2025-04-06 18:36:49','$2y$12$hQWF/klogjvtyZhYn3xgnu7Uht/J/xTj2CmOGnIlmiWE46sLJstdS',NULL,NULL,NULL,'WSZFfuyOsW',NULL,NULL,'Active',NULL,'2025-04-06 18:36:49','2025-04-06 18:36:49'),(100,'Laisha','Herzog','X',NULL,'Male','1998-12-19','jwintheiser@example.net',NULL,'09567638805','2nd Year','20244307',2,2,5,1,'jammie06','2025-04-06 18:36:49','$2y$12$et77JcR0tdRUCIkFe14Kle5c9gvv2kGFSNVCDp/EoHxGKbyWmGg6y',NULL,NULL,NULL,'ljsx2j61aw',NULL,NULL,'Active',NULL,'2025-04-06 18:36:49','2025-04-06 18:36:49'),(101,'Loraine','Kutch','O',NULL,'Male','2009-01-30','mmueller@example.net',NULL,'09702229101','3rd Year','20246464',2,2,5,2,'jennyfer.jakubowski','2025-04-06 18:36:49','$2y$12$vh7ZMmU68zeYygJyp695TuGHeD/V4Z/rqVwNQ/zhpHxVNyNTNxIR6',NULL,NULL,NULL,'t2rbAv9qAg',NULL,NULL,'Active',NULL,'2025-04-06 18:36:49','2025-04-06 18:36:49'),(102,'Clemens','Goldner','I',NULL,'Male','2002-08-29','price.isac@example.com',NULL,'09142452362','1st Year','20249446',2,2,5,1,'effertz.joesph','2025-04-06 18:36:49','$2y$12$vsJXP/eN4pvWx/jiKgzuNe2G60IyRjn744x.eglEz5bZF3Zfct2Z2',NULL,NULL,NULL,'lqBXbwlk2S',NULL,NULL,'Active',NULL,'2025-04-06 18:36:49','2025-04-06 18:36:49'),(103,'Eric','Skiles','P',NULL,'Female','2015-10-17','price.maybell@example.org',NULL,'09984004867','2nd Year','20248115',2,2,5,3,'bechtelar.marina','2025-04-06 18:36:49','$2y$12$9V3nz22Q/L/K3C3r3SUl0.8ITMSsKfBkdabcmRS7d1/XDL8JBUMt2',NULL,NULL,NULL,'R2fE55DyG8',NULL,NULL,'Active',NULL,'2025-04-06 18:36:50','2025-04-06 18:36:50'),(104,'Laney','Goldner','N',NULL,'Male','1973-10-16','schroeder.lamar@example.net',NULL,'09802145976','4th Year','20241301',2,2,5,3,'lauriane.koch','2025-04-06 18:36:50','$2y$12$ZVEGHAFbkIrRpwaKpvjgmO0q4Cap1K368DeMrQQ1/LjVhelQJlwvO',NULL,NULL,NULL,'eXU4SHxw4U',NULL,NULL,'Active',NULL,'2025-04-06 18:36:50','2025-04-06 18:36:50'),(105,'Keanu','O\'Keefe','S',NULL,'Male','1981-09-18','bonnie.mertz@example.org',NULL,'09651711220','1st Year','20244385',2,2,5,2,'alexandro56','2025-04-06 18:36:50','$2y$12$lzT8Esymnk/zm7KdOCliOuTcPsodEUy0PbjM0oCYi/kbBQGn64aQG',NULL,NULL,NULL,'YkmCSeEveU',NULL,NULL,'Active',NULL,'2025-04-06 18:36:50','2025-04-06 18:36:50'),(106,'Lonie','Thiel','V',NULL,'Female','1986-12-21','vhuel@example.org',NULL,'09884020212','1st Year','20243803',2,2,5,3,'mariam62','2025-04-06 18:36:50','$2y$12$Ys2dbHBWuPP5odZoqFDpYuflT0otSvTD3oqwBCcB9.7TTa0oMu8pS',NULL,NULL,NULL,'LEbBrbyRV3',NULL,NULL,'Active',NULL,'2025-04-06 18:36:50','2025-04-06 18:36:50'),(107,'Sydni','Schroeder','D',NULL,'Male','2008-10-31','kennedy.auer@example.com',NULL,'09416122537','2nd Year','20243267',2,2,5,1,'bauch.michelle','2025-04-06 18:36:50','$2y$12$ujKeM.UCNAa5X0uMLBSx0OPZSVEv6TLVmlaQf5ORC5adZfXM9GgK2',NULL,NULL,NULL,'019Wg83DO1',NULL,NULL,'Active',NULL,'2025-04-06 18:36:51','2025-04-06 18:36:51'),(108,'Axel','Quigley','P',NULL,'Male','1980-07-04','opal.carter@example.com',NULL,'09344009369','4th Year','20248075',2,2,5,2,'rath.meda','2025-04-06 18:36:51','$2y$12$JrbzR9dpVBPT3.yUweF0u.R9Fp9/GIWHPSKs9F7pl8gOdhDmj31FC',NULL,NULL,NULL,'t58peeiJN0',NULL,NULL,'Active',NULL,'2025-04-06 18:36:51','2025-04-06 18:36:51'),(109,'Jarret','Hirthe','W',NULL,'Male','1982-02-26','kristina.von@example.org',NULL,'09674073447','4th Year','20249112',2,2,5,1,'vern.okuneva','2025-04-06 18:36:51','$2y$12$O0ARxdCuONAlbX7F4EyztOOjIIaVWGdMC02D91BSXROHzcR0ESTuK',NULL,NULL,NULL,'GMocX3RTbh',NULL,NULL,'Active',NULL,'2025-04-06 18:36:51','2025-04-06 18:36:51'),(110,'Jadyn','Yundt','V',NULL,'Female','2020-06-22','collier.darrin@example.org',NULL,'09455738277','1st Year','20244708',2,2,5,3,'nathan.reilly','2025-04-06 18:36:51','$2y$12$5xJOZ4rdu8MwSJ439Z4/A.GBRwrp4mO.MoH/vt0lPvSz3JvqSqyPy',NULL,NULL,NULL,'166DnAvybi',NULL,NULL,'Active',NULL,'2025-04-06 18:36:51','2025-04-06 18:36:51'),(111,'Mateo','Kihn','H',NULL,'Male','2017-12-20','langosh.libby@example.org',NULL,'09727114452','1st Year','20249354',2,2,5,3,'glehner','2025-04-06 18:36:51','$2y$12$oVSdTuKWe7uhF.FLbxqw1Oz87MiCCGbqcc.wIhzq994Gyi5Mdks9.',NULL,NULL,NULL,'r6ty5CTf2u',NULL,NULL,'Active',NULL,'2025-04-06 18:36:52','2025-04-06 18:36:52'),(112,'Kelly','Hartmann','J',NULL,'Female','1981-05-06','isabel89@example.com',NULL,'09288774790','4th Year','20240215',2,2,5,2,'mraz.erica','2025-04-06 18:36:52','$2y$12$4t2W9y5yo9ilBYNct.9dIekuYJTgMhFGA27aobGtcF6l03.9MGQJW',NULL,NULL,NULL,'kczMvv6F4Z',NULL,NULL,'Active',NULL,'2025-04-06 18:36:52','2025-04-06 18:36:52'),(113,'Destiny','Abbott','Z',NULL,'Male','2015-04-13','cassin.marvin@example.com',NULL,'09073585770','4th Year','20240594',2,2,5,3,'kaylin22','2025-04-06 18:36:52','$2y$12$PvsZFAG0bK4DRLLYV9P7V.we94gdKCnlIzfEBWZqg5dcOBqzDXQIi',NULL,NULL,NULL,'BXb0mcPAiS',NULL,NULL,'Active',NULL,'2025-04-06 18:36:52','2025-04-06 18:36:52'),(114,'Chaya','Kub','V',NULL,'Female','2000-11-15','ohara.dana@example.org',NULL,'09397710221','4th Year','20245838',2,2,5,1,'cremin.charlene','2025-04-06 18:36:52','$2y$12$6k9ke3bopwlJWmmGAcCh/eKoTFJ.myIxwjF3D4fxWxf.RhIH3j5PW',NULL,NULL,NULL,'HbmZXHfi6c',NULL,NULL,'Active',NULL,'2025-04-06 18:36:52','2025-04-06 18:36:52'),(115,'Laverna','Gislason','S',NULL,'Female','2009-08-05','parisian.jazmyne@example.net',NULL,'09354195841','4th Year','20245108',2,2,5,1,'lauretta19','2025-04-06 18:36:52','$2y$12$aSt0xY3kJQSOdqzgnO8e2OrdoB/xWu7LswVZLqeLQDvxahONBPACy',NULL,NULL,NULL,'exlaELyCt5',NULL,NULL,'Active',NULL,'2025-04-06 18:36:52','2025-04-06 18:36:52'),(116,'Gregoria','Jacobs','V',NULL,'Male','1999-11-09','maggio.frieda@example.com',NULL,'09702280912','2nd Year','20247513',2,2,5,2,'igusikowski','2025-04-06 18:36:52','$2y$12$lLAg178JrHINu.MM.PkIqu/mnXiAB7ZnDAC7QkR.oltoJrGVnq2zC',NULL,NULL,NULL,'Tcu7BahWU5',NULL,NULL,'Active',NULL,'2025-04-06 18:36:53','2025-04-06 18:36:53'),(117,'Viviane','Rodriguez','D',NULL,'Female','1990-12-31','ebba92@example.com',NULL,'09723715038','4th Year','20243673',2,2,5,1,'ewehner','2025-04-06 18:36:53','$2y$12$xxr3jyTvK/snWIoisoxC7uAFrqvd7yW25rBW/1jWrA06obciY1n0a',NULL,NULL,NULL,'LQprwRDBWg',NULL,NULL,'Active',NULL,'2025-04-06 18:36:53','2025-04-06 18:36:53'),(118,'Sarah','Okuneva','A',NULL,'Female','1983-03-06','furman.ledner@example.org',NULL,'09073259700','1st Year','20246209',2,2,5,2,'hahn.fae','2025-04-06 18:36:53','$2y$12$/ZT3ytXLyiu28zk7VFFWQueMBmDjCJ0hnNUcMrHnS2ice/cCqZG4.',NULL,NULL,NULL,'p97K7XcT3p',NULL,NULL,'Active',NULL,'2025-04-06 18:36:53','2025-04-06 18:36:53'),(119,'Camryn','Murphy','V',NULL,'Male','1993-10-09','mertz.kelli@example.com',NULL,'09074547987','4th Year','20247505',2,2,5,2,'abbott.katharina','2025-04-06 18:36:53','$2y$12$Ipf2oKtxVspqzHRx7ew23.pbnfe4SzsigZ9bOnN1sysM7dJS6OIiq',NULL,NULL,NULL,'5NDZb5V8Ba',NULL,NULL,'Active',NULL,'2025-04-06 18:36:53','2025-04-06 18:36:53'),(120,'Mathias','Luettgen','Z',NULL,'Female','2019-06-17','rowe.dino@example.net',NULL,'09127492365','1st Year','20241710',2,2,5,1,'dedric.brown','2025-04-06 18:36:53','$2y$12$D/TaaOIlcZLNXpbiYm1YuuJf8qJnv7bXD7kcI1TYRBY3Dk3oxibwO',NULL,NULL,NULL,'K26XJOf2WY',NULL,NULL,'Active',NULL,'2025-04-06 18:36:54','2025-04-06 18:36:54'),(121,'Ines','Emard','T',NULL,'Male','2020-11-16','mable.howell@example.org',NULL,'09886664595','2nd Year','20247528',2,2,5,3,'bcarroll','2025-04-06 18:36:54','$2y$12$HQjpFdQp9v3.mU6LvvqvEOkPGj5eFqKNxvJrU0z4L1B3tyA6WVqJC',NULL,NULL,NULL,'e5Wr6l0VcZ',NULL,NULL,'Active',NULL,'2025-04-06 18:36:54','2025-04-06 18:36:54'),(122,'Joy','Hayes','X',NULL,'Female','1979-05-02','elaina.will@example.org',NULL,'09742822029','3rd Year','20244735',2,2,5,3,'kstiedemann','2025-04-06 18:36:54','$2y$12$sRbf9qloUTLrQYk6Milfiecl.smLZjJ.L46ZYSUxf5EWiB6nVIm7G',NULL,NULL,NULL,'0OPogTqps9',NULL,NULL,'Active',NULL,'2025-04-06 18:36:54','2025-04-06 18:36:54'),(123,'Osvaldo','Lindgren','P',NULL,'Male','1980-03-29','boehm.eugene@example.org',NULL,'09406302000','1st Year','20244453',2,2,5,2,'ycrooks','2025-04-06 18:36:54','$2y$12$Urpc8rK1Xn.xUtwYJQfZ4O62isOvzhOkHq6ul9x6DQBPN9ETfJbmS',NULL,NULL,NULL,'LDN6dNCQEq',NULL,NULL,'Active',NULL,'2025-04-06 18:36:54','2025-04-06 18:36:54'),(124,'Rene','Pfeffer','U',NULL,'Female','1977-03-25','icollier@example.org',NULL,'09291418352','1st Year','20244264',2,2,5,3,'reggie.schoen','2025-04-06 18:36:54','$2y$12$0UJdFtkgQioS/zmIlcsTd.72nALJ9UjK0zFb94uhvWPe3r6Z3RVBO',NULL,NULL,NULL,'sr9iYvhmzO',NULL,NULL,'Active',NULL,'2025-04-06 18:36:55','2025-04-06 18:36:55'),(125,'Brent','Lubowitz','T',NULL,'Male','1970-06-09','shany.vonrueden@example.net',NULL,'09313982306','1st Year','20247278',2,2,5,3,'fjones','2025-04-06 18:36:55','$2y$12$f8ucq7h52eSTVAS6NB9d9O3seDiJwqaURaT5g1S9/u9PRF1CDZLim',NULL,NULL,NULL,'0VD5t8PTFY',NULL,NULL,'Active',NULL,'2025-04-06 18:36:55','2025-04-06 18:36:55'),(126,'Stone','O\'Keefe','E',NULL,'Male','1970-02-06','maximillian.kemmer@example.org',NULL,'09242355209','2nd Year','20244197',2,2,5,3,'rtillman','2025-04-06 18:36:55','$2y$12$ESe6r/JdpXax3.o0Z7ZggOzOIZvt2WKgO1f55yo727x0SXqnCuJ16',NULL,NULL,NULL,'LLqv7E3u4C',NULL,NULL,'Active',NULL,'2025-04-06 18:36:55','2025-04-06 18:36:55'),(127,'Liliane','Zulauf','D',NULL,'Male','2001-07-06','mueller.ezekiel@example.net',NULL,'09948754535','4th Year','20242715',2,2,5,2,'kshlerin.lilla','2025-04-06 18:36:55','$2y$12$euY.4ejQLLlmL9XB/rz8hOQt5onz9Uni1jR3TbrFJoWjAsWu38.1C',NULL,NULL,NULL,'Mpf4kdjF1W',NULL,NULL,'Active',NULL,'2025-04-06 18:36:55','2025-04-06 18:36:55'),(128,'Alfred','Wisozk','B',NULL,'Male','2022-02-10','medhurst.imogene@example.com',NULL,'09126140036','4th Year','20245494',2,2,5,1,'nkozey','2025-04-06 18:36:55','$2y$12$4ILoRP.gLoJYvR./DsT3KeCbSn5pFLAdpXVkY5vcoXuCdVVPO2zpq',NULL,NULL,NULL,'8sltYa4r7S',NULL,NULL,'Active',NULL,'2025-04-06 18:36:56','2025-04-06 18:36:56'),(129,'Shanel','Hessel','H',NULL,'Male','1995-06-12','pwhite@example.org',NULL,'09634927225','2nd Year','20240408',2,2,5,3,'daniela.murazik','2025-04-06 18:36:56','$2y$12$tPItsFtFpGMZEv7dbAQoCOLzXCFb6Z8nQZzO4lXknBvruGwWbuLmS',NULL,NULL,NULL,'38VLqle1SE',NULL,NULL,'Active',NULL,'2025-04-06 18:36:56','2025-04-06 18:36:56'),(130,'Daryl','Batz','D',NULL,'Female','1993-09-03','mreilly@example.org',NULL,'09874092283','3rd Year','20249492',2,2,5,1,'little.barney','2025-04-06 18:36:56','$2y$12$rQm12soAIiUKF8g7pqFuPenizqlCYv2ZMePA3EJuWCgIgpS/Plolm',NULL,NULL,NULL,'twC6qvxXd8',NULL,NULL,'Active',NULL,'2025-04-06 18:36:56','2025-04-06 18:36:56'),(131,'Pasquale','Adams','S',NULL,'Male','2006-04-28','elisha.swift@example.net',NULL,'09471882913','4th Year','20249451',2,2,5,3,'eino.ratke','2025-04-06 18:36:56','$2y$12$JkBKJtvOShwjDZ1td.ac7.7PhQkZLiM4DpbqoKPqDzIwKrdaXLO1u',NULL,NULL,NULL,'58n3TPJ022',NULL,NULL,'Active',NULL,'2025-04-06 18:36:56','2025-04-06 18:36:56'),(132,'Dovie','Botsford','N',NULL,'Female','2015-09-13','grant.mariela@example.net',NULL,'09025038765','2nd Year','20242056',2,2,5,1,'vwisozk','2025-04-06 18:36:56','$2y$12$BsG192JzuxZmXs7J5ENtROOxuZKc91NYuoXqwuP.A/lJ95MP3sitm',NULL,NULL,NULL,'S791pOAMTc',NULL,NULL,'Active',NULL,'2025-04-06 18:36:56','2025-04-06 18:36:56'),(133,'Tara','Roob','Z',NULL,'Female','1999-01-07','harold91@example.org',NULL,'09204299815','1st Year','20242584',2,2,5,2,'fkuphal','2025-04-06 18:36:56','$2y$12$vegWBRp7CocIo4sx41.a0ekFeiyk1mBzPPiu5vRiTdfGSqapnUr2G',NULL,NULL,NULL,'b0fo2SwxJD',NULL,NULL,'Active',NULL,'2025-04-06 18:36:57','2025-04-06 18:36:57'),(134,'Gavin','Collier','D',NULL,'Female','1986-03-13','stokes.tyshawn@example.net',NULL,'09961409223','2nd Year','20247812',2,2,5,2,'burnice50','2025-04-06 18:36:57','$2y$12$mCt860NjD4sMBuhrR0ZysOdnAI8btztbtGOIp9j13APfvl6Er2Qja',NULL,NULL,NULL,'NJpUuEB2xQ',NULL,NULL,'Active',NULL,'2025-04-06 18:36:57','2025-04-06 18:36:57'),(135,'Guadalupe','Walter','Q',NULL,'Female','1973-06-13','orland28@example.org',NULL,'09300745218','4th Year','20240183',2,2,5,2,'monroe87','2025-04-06 18:36:57','$2y$12$23Qif4AxwRsKa7wrWyRgv.unyOuhobeSVkZMNpebKnT1is3QwCoG6',NULL,NULL,NULL,'rmAIuE8yH3',NULL,NULL,'Active',NULL,'2025-04-06 18:36:57','2025-04-06 18:36:57'),(136,'Jessie','Rutherford','F',NULL,'Female','1972-03-04','adrienne44@example.org',NULL,'09389507241','4th Year','20241832',2,2,5,1,'nico.yundt','2025-04-06 18:36:57','$2y$12$yr2QMjTGRw/P4tk0nrdB0.hkZJ6w.65bq4wbmaKFwby.pvsy3DuR.',NULL,NULL,NULL,'pxor6bAtFL',NULL,NULL,'Active',NULL,'2025-04-06 18:36:57','2025-04-06 18:36:57'),(137,'Laron','Ryan','E',NULL,'Male','2019-06-25','pamela.okuneva@example.org',NULL,'09208631777','3rd Year','20241218',2,2,5,1,'powlowski.carleton','2025-04-06 18:36:57','$2y$12$8whoMYb78K5oDjaURc7AHeCDiSQG6bVcYhA0iISunM9LssDDQohyy',NULL,NULL,NULL,'SlPIPsm1YF',NULL,NULL,'Active',NULL,'2025-04-06 18:36:58','2025-04-06 18:36:58'),(138,'Dereck','Gleason','X',NULL,'Female','1978-06-02','wisozk.jessika@example.com',NULL,'09671741442','1st Year','20247934',2,2,5,1,'ryleigh92','2025-04-06 18:36:58','$2y$12$ORt.Rt235RIsWIEJYSdUDefmWphb7tYPAosdxOAuWuiyrvGeDPFN.',NULL,NULL,NULL,'6UsqDDbO6a',NULL,NULL,'Active',NULL,'2025-04-06 18:36:58','2025-04-06 18:36:58'),(139,'Nils','Ratke','F',NULL,'Male','2009-03-25','ziemann.camila@example.org',NULL,'09430694788','4th Year','20248538',2,2,5,1,'rolando.bogisich','2025-04-06 18:36:58','$2y$12$aSKxV7KtbAwI0Udauh9hdOWadpGTsfdkOYAK11vCQTMs449FupS4G',NULL,NULL,NULL,'yYktVROmJv',NULL,NULL,'Active',NULL,'2025-04-06 18:36:58','2025-04-06 18:36:58'),(140,'Greta','Bosco','B',NULL,'Female','2006-12-17','satterfield.lucy@example.com',NULL,'09802591462','2nd Year','20247960',2,2,5,2,'akuhn','2025-04-06 18:36:58','$2y$12$09L28tS7Zs82nkoMGxQS/OSUVuinJryQfONpWlSqMaNt5Bwn4aEqK',NULL,NULL,NULL,'beCa8ny4P7',NULL,NULL,'Active',NULL,'2025-04-06 18:36:58','2025-04-06 18:36:58'),(141,'Mark','Hermann','S',NULL,'Male','2013-02-22','wiegand.jadyn@example.org',NULL,'09253208623','3rd Year','20241950',2,2,5,1,'idietrich','2025-04-06 18:36:58','$2y$12$hmjL2kmPFryQvxzoMeTKwODZicwLgsQzVyOTvZweKBs.7T6VU37C2',NULL,NULL,NULL,'TsFnVhoaBW',NULL,NULL,'Active',NULL,'2025-04-06 18:36:59','2025-04-06 18:36:59'),(142,'Janet','Denesik','E',NULL,'Female','1977-03-27','marian.mayert@example.org',NULL,'09011339168','3rd Year','20241462',2,2,5,3,'ocrona','2025-04-06 18:36:59','$2y$12$zPWZreXWQVznS.LmXWER4eA.qkI0nTD31taJehDP/4urs3OiYYEae',NULL,NULL,NULL,'uhLYfUCEwE',NULL,NULL,'Active',NULL,'2025-04-06 18:36:59','2025-04-06 18:36:59'),(143,'Itzel','Crona','M',NULL,'Female','1996-10-12','murray48@example.net',NULL,'09366986602','1st Year','20244027',2,2,5,1,'kale.langworth','2025-04-06 18:36:59','$2y$12$pTBd1sbNoMtDxImCERLesecK8Ye3C167EZJ5iCrEQEtbrZrcy8wMK',NULL,NULL,NULL,'VrutVVVO55',NULL,NULL,'Active',NULL,'2025-04-06 18:36:59','2025-04-06 18:36:59'),(144,'Marcelino','Johnston','W',NULL,'Male','1987-06-12','celia24@example.com',NULL,'09649694117','1st Year','20242737',2,2,5,2,'andres80','2025-04-06 18:36:59','$2y$12$QITK5JJN/uoibjpJt0wkOuOfKIN0t5oickIYzNuQgIuYHGK0CjNw6',NULL,NULL,NULL,'antI40UHhQ',NULL,NULL,'Active',NULL,'2025-04-06 18:36:59','2025-04-06 18:36:59'),(145,'Dannie','Roberts','O',NULL,'Female','2017-12-24','karl.mclaughlin@example.net',NULL,'09235421620','4th Year','20242173',2,2,5,1,'zgorczany','2025-04-06 18:36:59','$2y$12$FCE79K6l7P35/3IPIHqyr.MT18cyZN/NMsO/8g2UVpDrGHWlbjqBu',NULL,NULL,NULL,'3ocL13Hrah',NULL,NULL,'Active',NULL,'2025-04-06 18:37:00','2025-04-06 18:37:00'),(146,'Alycia','Lowe','T',NULL,'Female','2011-12-26','yswift@example.com',NULL,'09241140255','4th Year','20241327',2,2,5,3,'al68','2025-04-06 18:37:00','$2y$12$W4q3O9xnj50E1MaBKjFa7uPiqz0OKqKvbJkZ0Jt21K46P.J0POwhu',NULL,NULL,NULL,'fsw7YgX8yu',NULL,NULL,'Active',NULL,'2025-04-06 18:37:00','2025-04-06 18:37:00'),(147,'Tamia','Reichel','K',NULL,'Female','2014-08-01','forrest.bergstrom@example.net',NULL,'09271400576','4th Year','20245120',2,2,5,2,'winona.roberts','2025-04-06 18:37:00','$2y$12$dgvPBfqgp.c0IBTZCgz5Yu9U90fPpVIWym9I.KAbPvTQzmjyUx/z2',NULL,NULL,NULL,'nPmGrnXg6f',NULL,NULL,'Active',NULL,'2025-04-06 18:37:00','2025-04-06 18:37:00'),(148,'Karelle','Runolfsdottir','E',NULL,'Male','2016-06-23','rking@example.net',NULL,'09506728751','1st Year','20243806',2,2,5,1,'toney.carroll','2025-04-06 18:37:00','$2y$12$iyXtW3sPUenHLPT2FrXdgeTrJfiaw9spgFlRzXJfKwq32EK64yBLq',NULL,NULL,NULL,'vr6riyW8Dt',NULL,NULL,'Active',NULL,'2025-04-06 18:37:00','2025-04-06 18:37:00'),(149,'Brian','Purdy','X',NULL,'Male','1991-07-27','wanda65@example.net',NULL,'09412349738','1st Year','20248389',2,2,5,3,'deon.hamill','2025-04-06 18:37:00','$2y$12$gTo9i0Y3Ir0/AnMbORPbReYTo9MegTaThtOKV139xcvxkTt1SuR.y',NULL,NULL,NULL,'qlNiYVaTgH',NULL,NULL,'Active',NULL,'2025-04-06 18:37:00','2025-04-06 18:37:00'),(150,'Alda','Swift','V',NULL,'Female','2015-08-04','jeanne20@example.com',NULL,'09072180577','4th Year','20249058',2,2,5,1,'bethel.williamson','2025-04-06 18:37:00','$2y$12$BoCfkpblnUXhstEfc2FqU.RsXJSlMiFtAIyj2CeKdEFQvPLWLJGFO',NULL,NULL,NULL,'2RV2rk60ou',NULL,NULL,'Active',NULL,'2025-04-06 18:37:01','2025-04-06 18:37:01'),(151,'Breanne','Kihn','I',NULL,'Male','2015-08-15','pietro.pouros@example.org',NULL,'09162394041','4th Year','20245459',2,2,5,2,'omckenzie','2025-04-06 18:37:01','$2y$12$bnnEIrn8RwKY11m2ItgWXOw5sQBnjWedlZk07gg6mNJJmYEJoi9Ya',NULL,NULL,NULL,'y2cUhjz5YS',NULL,NULL,'Active',NULL,'2025-04-06 18:37:01','2025-04-06 18:37:01'),(152,'Kianna','Boehm','A',NULL,'Female','1997-11-30','chilpert@example.net',NULL,'09470339963','3rd Year','20240035',2,2,5,1,'sophie.bartoletti','2025-04-06 18:37:01','$2y$12$FJfTG10pxeOWlo/tYomi/O0.5h/haV2uhhb9JZ0I8np.KCMUnNafy',NULL,NULL,NULL,'S3lFd8LRpF',NULL,NULL,'Active',NULL,'2025-04-06 18:37:01','2025-04-06 18:37:01'),(153,'Jeff','Swaniawski','B',NULL,'Female','1986-01-02','nrice@example.org',NULL,'09181869354','1st Year','20248634',2,2,5,2,'flossie.sipes','2025-04-06 18:37:01','$2y$12$QH442uRz7r6gfdgYoEkMLOVCBQFy/zXDYO.GczRrWD4y.7uFeAMgK',NULL,NULL,NULL,'vOxdFst3pQ',NULL,NULL,'Active',NULL,'2025-04-06 18:37:01','2025-04-06 18:37:01'),(154,'Elwyn','Reilly','G',NULL,'Female','1994-09-19','mrippin@example.net',NULL,'09350161429','4th Year','20243535',2,2,5,2,'kwilliamson','2025-04-06 18:37:01','$2y$12$p.1IE7r07IXurzssvYuN1.wCRnz5DqIpjQGe2JBQZgpfmp/ZuyGjK',NULL,NULL,NULL,'bkv3x9k64s',NULL,NULL,'Active',NULL,'2025-04-06 18:37:02','2025-04-06 18:37:02'),(155,'Sarai','Jenkins','H',NULL,'Female','1984-05-11','sboehm@example.org',NULL,'09337942666','4th Year','20245877',2,2,5,1,'lambert23','2025-04-06 18:37:02','$2y$12$PkAGDE6Hu4PtqwM7YXkUjusIFzuSMBQgU6JbrvBY2Q9APbMVWsxLq',NULL,NULL,NULL,'gGTMQDO6lp',NULL,NULL,'Active',NULL,'2025-04-06 18:37:02','2025-04-06 18:37:02'),(156,'Jackson','Von','R',NULL,'Male','1989-04-12','addie.waters@example.net',NULL,'09887753452','3rd Year','20244113',2,2,5,2,'torp.gwen','2025-04-06 18:37:02','$2y$12$atB0zyjxslTkDwam/qL0oOM0gaMNFXdL1TYkDtpUDVhe4DAaQOREm',NULL,NULL,NULL,'QHj0tUGE7X',NULL,NULL,'Active',NULL,'2025-04-06 18:37:02','2025-04-06 18:37:02'),(157,'Marilou','Kiehn','B',NULL,'Male','2012-10-27','shanahan.gerhard@example.org',NULL,'09960721237','2nd Year','20244623',2,2,5,2,'kheaney','2025-04-06 18:37:02','$2y$12$f6c6CwHFoc5H33en6iiiH.wyx0CGlVm/EtcOgcC5huNacdx9moip.',NULL,NULL,NULL,'pnjxtw0DcJ',NULL,NULL,'Active',NULL,'2025-04-06 18:37:02','2025-04-06 18:37:02'),(158,'Krystina','Kub','Y',NULL,'Male','2001-01-03','conner29@example.net',NULL,'09033968478','2nd Year','20240434',2,2,5,2,'brooklyn84','2025-04-06 18:37:02','$2y$12$/tijRHdAxe5vcukNT44XUOWYxDp/L8CHhiIU3lafjFkFTDojLDebO',NULL,NULL,NULL,'sEP4TuEwCi',NULL,NULL,'Active',NULL,'2025-04-06 18:37:03','2025-04-06 18:37:03'),(159,'Oren','McKenzie','O',NULL,'Female','2006-05-19','elias.dubuque@example.com',NULL,'09986021923','1st Year','20244955',2,2,5,2,'tswaniawski','2025-04-06 18:37:03','$2y$12$9nv3eVLy.a273aAK1iCDR.aN7pTXUJqsKEnpU4Wz.WaL0zJxcmzTq',NULL,NULL,NULL,'wZ4Tg2ZpZZ',NULL,NULL,'Active',NULL,'2025-04-06 18:37:03','2025-04-06 18:37:03'),(160,'Jaqueline','Hyatt','G',NULL,'Female','2002-04-09','shansen@example.org',NULL,'09728544920','3rd Year','20248703',2,2,5,2,'esteban.quitzon','2025-04-06 18:37:03','$2y$12$aCgpoIMttAWoR9GZ9l9QO.R.bZTupCxCDbqsXDw.VKN6BXuATvD32',NULL,NULL,NULL,'UqlgLKoYNh',NULL,NULL,'Active',NULL,'2025-04-06 18:37:03','2025-04-06 18:37:03'),(161,'Genevieve','Haley','C',NULL,'Female','2023-12-11','tressa94@example.com',NULL,'09137969895','2nd Year','20242431',2,2,5,3,'west.oleta','2025-04-06 18:37:03','$2y$12$JvN6xtNEojbdB8tMu2JyAuUQ383H5D7uCgX3K1c7URsjkEWbzijI.',NULL,NULL,NULL,'ijgJYEqZsE',NULL,NULL,'Active',NULL,'2025-04-06 18:37:03','2025-04-06 18:37:03'),(162,'Arno','Gottlieb','W',NULL,'Male','2006-03-31','darrel.swaniawski@example.com',NULL,'09083891265','4th Year','20249977',2,2,5,1,'tjacobi','2025-04-06 18:37:03','$2y$12$.cR4yBiDOqf3FBuDRlPbnui1l.Wo0vZWUU6PKUJ.KCrpagevDSiQG',NULL,NULL,NULL,'3EOfXozOVM',NULL,NULL,'Active',NULL,'2025-04-06 18:37:04','2025-04-06 18:37:04'),(163,'Duncan','Stark','C',NULL,'Female','1998-07-03','stacey.swift@example.net',NULL,'09537980895','2nd Year','20248832',2,2,5,2,'lea.heathcote','2025-04-06 18:37:04','$2y$12$4y/8phn/hvupiIupYgec4ub3Okq.CVNGCyA34vrspErN6YtSiye.a',NULL,NULL,NULL,'PPmo1U0Tf0',NULL,NULL,'Active',NULL,'2025-04-06 18:37:04','2025-04-06 18:37:04'),(172,'Juan','Dela Cruz','M','Jr','Male','2002-10-11','juan.delacruz@example.com',NULL,'09123456789','3','2020-12345',2,2,1,1,'juan.delacruz@example.com',NULL,'$2y$12$BdO.tJ6I0Fe1W8zJ479oEOvupJfNej0h.7cSEid1.Wt2uX8hbI11a',NULL,NULL,NULL,NULL,NULL,NULL,'Active',NULL,'2025-04-08 04:43:24','2025-04-08 04:44:14'),(173,'Sample','Voter','S',NULL,'Female','2002-10-09','sample123@usep.edu.ph',NULL,'09123476789','5','2021-00827',2,2,1,1,'sample123@usep.edu.ph',NULL,'$2y$12$5pKDkFW4cslRGpCeG0sh3.qSvUh44M/syRZvBLZtR/akpySeV/fl.',NULL,NULL,NULL,NULL,NULL,NULL,'Active',NULL,'2025-04-08 04:43:25','2025-04-08 04:53:17'),(174,'Samples','Ple','S',NULL,'prefer-not-to-say','2002-11-10','jessie121@example.com',NULL,'09702826778','1st','2021-00027',2,2,1,1,'voter@example',NULL,'$2y$12$VzfipepYDI5y8bVDA/cM4.akyftkSdUxQIdkAjoOmcRfjUz8u8URO',NULL,NULL,NULL,NULL,NULL,NULL,'Active',NULL,'2025-04-08 04:57:54','2025-04-08 04:57:54');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voter_encode_votes`
--

DROP TABLE IF EXISTS `voter_encode_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `voter_encode_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `election_id` bigint unsigned NOT NULL,
  `encoded_image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `encrypted_data` blob NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `voter_encode_votes_user_id_foreign` (`user_id`),
  KEY `voter_encode_votes_election_id_foreign` (`election_id`),
  CONSTRAINT `voter_encode_votes_election_id_foreign` FOREIGN KEY (`election_id`) REFERENCES `elections` (`id`),
  CONSTRAINT `voter_encode_votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voter_encode_votes`
--

LOCK TABLES `voter_encode_votes` WRITE;
/*!40000 ALTER TABLE `voter_encode_votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `voter_encode_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `candidate_id` bigint unsigned NOT NULL,
  `election_id` bigint unsigned NOT NULL,
  `election_type_id` bigint unsigned NOT NULL,
  `position_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `votes_user_id_foreign` (`user_id`),
  KEY `votes_candidate_id_foreign` (`candidate_id`),
  KEY `votes_election_id_foreign` (`election_id`),
  KEY `votes_election_type_id_foreign` (`election_type_id`),
  KEY `votes_position_id_foreign` (`position_id`),
  CONSTRAINT `votes_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`),
  CONSTRAINT `votes_election_id_foreign` FOREIGN KEY (`election_id`) REFERENCES `elections` (`id`),
  CONSTRAINT `votes_election_type_id_foreign` FOREIGN KEY (`election_type_id`) REFERENCES `election_types` (`id`),
  CONSTRAINT `votes_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  CONSTRAINT `votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes`
--

LOCK TABLES `votes` WRITE;
/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-09 13:36:00
