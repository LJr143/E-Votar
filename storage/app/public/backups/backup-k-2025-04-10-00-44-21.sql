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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_files`
--

LOCK TABLES `backup_files` WRITE;
/*!40000 ALTER TABLE `backup_files` DISABLE KEYS */;
INSERT INTO `backup_files` VALUES (1,1,'backups/backup-test1-2025-04-09-22-22-49.sql',84328,26,'2025-04-09 14:22:54','2025-04-09 14:22:54');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_schedules`
--

LOCK TABLES `backup_schedules` WRITE;
/*!40000 ALTER TABLE `backup_schedules` DISABLE KEYS */;
INSERT INTO `backup_schedules` VALUES (1,'test1','custom','\"{\\\"custom_time\\\":\\\"22:22\\\"}\"','2025-04-10 14:22:00','2025-04-09 14:22:53',26,'2025-04-09 14:22:01','2025-04-09 14:22:53'),(2,'test 2','hourly','\"[]\"','2025-04-09 17:00:00',NULL,26,'2025-04-09 16:32:44','2025-04-09 16:32:44'),(3,'test 3','weekly','\"{\\\"day_of_week\\\":\\\"monday\\\"}\"','2025-04-13 16:00:00',NULL,26,'2025-04-09 16:32:55','2025-04-09 16:32:55'),(4,'test 4','daily','\"[]\"','2025-04-10 16:00:00',NULL,26,'2025-04-09 16:33:15','2025-04-09 16:33:15'),(5,'test 5','monthly','\"{\\\"day_of_month\\\":1}\"','2025-04-30 16:00:00',NULL,26,'2025-04-09 16:33:32','2025-04-09 16:33:32'),(6,'test 6','daily','\"[]\"','2025-04-10 16:00:00',NULL,26,'2025-04-09 16:34:38','2025-04-09 16:34:38'),(7,'bh','daily','\"[]\"','2025-04-10 16:00:00',NULL,26,'2025-04-09 16:34:47','2025-04-09 16:34:47'),(8,'n','daily','\"[]\"','2025-04-10 16:00:00',NULL,26,'2025-04-09 16:35:07','2025-04-09 16:35:07'),(9,'jbjk','daily','\"[]\"','2025-04-10 16:00:00',NULL,26,'2025-04-09 16:35:19','2025-04-09 16:35:19'),(10,'j','daily','\"[]\"','2025-04-10 16:00:00',NULL,26,'2025-04-09 16:35:24','2025-04-09 16:35:24'),(11,'k','daily','\"[]\"','2025-04-10 16:00:00',NULL,26,'2025-04-09 16:35:29','2025-04-09 16:35:29');
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
INSERT INTO `cache` VALUES ('356a192b7913b04c54574d18c28d46e6395428ab','i:1;',1744214343),('356a192b7913b04c54574d18c28d46e6395428ab:timer','i:1744214343;',1744214343),('spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:67:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:13:\"view election\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:7;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:15:\"create election\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:13:\"edit election\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"delete election\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:21:\"view election results\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:7;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:15:\"view vote tally\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:7;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:16:\"create candidate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:14:\"edit candidate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:16:\"delete candidate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:14:\"view candidate\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:7;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"view party list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:7;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"create party list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:15:\"edit party list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:17:\"delete party list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:10:\"view voter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:12:\"create voter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:10:\"edit voter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:12:\"delete voter\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:10:\"view users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:12:\"create users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:10:\"edit users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"delete users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:13:\"view colleges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:7;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:15:\"create colleges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:13:\"edit colleges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:15:\"delete colleges\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:13:\"view programs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:7;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:15:\"create programs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:13:\"edit programs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:15:\"delete programs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:11:\"view majors\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:7;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:13:\"create majors\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:11:\"edit majors\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:13:\"delete majors\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:17:\"view active users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:15:\"view ip records\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:16:\"print ip records\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:17:\"export ip records\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:17:\"delete ip records\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:16:\"block ip records\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:16:\"allow ip records\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:20:\"view database backup\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:22:\"create database backup\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:22:\"export database backup\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:22:\"delete database backup\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:19:\"run database backup\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:5;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:15:\"export election\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:23:\"export election results\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:17:\"export vote tally\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:17:\"export candidates\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:16:\"export positions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:15:\"export councils\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:17:\"export party list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:13:\"export voters\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:18:\"export users admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:15:\"import election\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:16:\"import positions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:15:\"import councils\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:17:\"import party list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:13:\"import voters\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:23:\"view website management\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:27:\"create website announcement\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:13:\"view feedback\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:16:\"view system logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:7;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:18:\"create system logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:16:\"edit system logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:18:\"delete system logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}}s:5:\"roles\";a:6:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"superadmin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:7;s:1:\"b\";s:7:\"faculty\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:23:\"student-council-watcher\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:21:\"local-council-watcher\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:17:\"technical_officer\";s:1:\"c\";s:3:\"web\";}}}',1744293461);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `councils`
--

LOCK TABLES `councils` WRITE;
/*!40000 ALTER TABLE `councils` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `election_positions`
--

LOCK TABLES `election_positions` WRITE;
/*!40000 ALTER TABLE `election_positions` DISABLE KEYS */;
INSERT INTO `election_positions` VALUES (1,1,1,'2025-04-09 15:58:14','2025-04-09 15:58:14'),(2,1,2,'2025-04-09 15:58:14','2025-04-09 15:58:14'),(3,1,3,'2025-04-09 15:58:14','2025-04-09 15:58:14'),(4,1,4,'2025-04-09 15:58:14','2025-04-09 15:58:14'),(5,1,5,'2025-04-09 15:58:14','2025-04-09 15:58:14'),(6,1,6,'2025-04-09 15:58:14','2025-04-09 15:58:14'),(7,1,7,'2025-04-09 15:58:14','2025-04-09 15:58:14'),(8,1,8,'2025-04-09 15:58:14','2025-04-09 15:58:14'),(9,1,9,'2025-04-09 15:58:14','2025-04-09 15:58:14'),(10,1,10,'2025-04-09 15:58:14','2025-04-09 15:58:14'),(11,1,11,'2025-04-09 15:58:14','2025-04-09 15:58:14'),(12,1,12,'2025-04-09 15:58:15','2025-04-09 15:58:15'),(13,1,13,'2025-04-09 15:58:15','2025-04-09 15:58:15'),(14,1,14,'2025-04-09 15:58:15','2025-04-09 15:58:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elections`
--

LOCK TABLES `elections` WRITE;
/*!40000 ALTER TABLE `elections` DISABLE KEYS */;
INSERT INTO `elections` VALUES (1,'Student and Local Election 2023','student-and-local-election-2023-67f69916ceddc',1,2,'2025-04-09 15:58:00','2025-04-12 15:58:00','ongoing','elections/images/NgEabY7oPAz5DzryzCfm8WKjmVQQL58Cd4Ax4i3b.png','2025-04-09 15:58:14','2025-04-09 15:58:14');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `face_data`
--

LOCK TABLES `face_data` WRITE;
/*!40000 ALTER TABLE `face_data` DISABLE KEYS */;
INSERT INTO `face_data` VALUES (1,26,1,'faces/face_1744207232_7LGGNt9h6O.jpg',100.00,'[-0.0763687863945961, 0.17386385798454285, 0.05461335554718971, -0.1112300232052803, -0.09310975670814514, 0.0002062329585896805, -0.06607825309038162, -0.0925787016749382, 0.23039035499095917, -0.13942550122737885, 0.27946579456329346, -0.02588574215769768, -0.1729312390089035, -0.006429353728890419, -0.07448971271514893, 0.2240050733089447, -0.18489143252372744, -0.14251041412353516, -0.03107905015349388, 0.024682531133294106, 0.03499425947666168, 0.006521725561469793, -0.039235156029462814, 0.05905526503920555, -0.07884255796670914, -0.3868479132652282, -0.10031095892190932, -0.06486973166465759, 0.027249617502093315, -0.050161562860012054, -0.007436750922352076, -0.03703423961997032, -0.17705118656158447, -0.06312905997037888, 0.06092649325728416, 0.04549660161137581, -0.04570968821644783, -0.0663936585187912, 0.1879172921180725, -0.02349306270480156, -0.26501408219337463, -0.002489604288712144, 0.14580783247947693, 0.2677226960659027, 0.12984512746334076, 0.07608967274427414, 0.025681305676698685, -0.17006397247314453, 0.1163305938243866, -0.1907215416431427, 0.05147651955485344, 0.11487846821546556, 0.020387712866067886, 0.1410776525735855, 0.030695879831910133, -0.11298249661922456, 0.029000259935855865, 0.17394015192985535, -0.19045232236385343, 0.023829832673072815, 0.07309570163488388, -0.02048972249031067, -0.02209014818072319, -0.09211540222167967, 0.3173825740814209, 0.12555694580078125, -0.15797321498394012, -0.18266156315803528, 0.14005284011363983, -0.15431678295135498, -0.09226159006357192, 0.04433193802833557, -0.09244755655527116, -0.17252805829048157, -0.2910062074661255, 0.010899754241108894, 0.4503571093082428, 0.1577480584383011, -0.1547715961933136, 0.04598335921764374, -0.0720415785908699, -0.05776854231953621, 0.10516473650932312, 0.16458159685134888, 0.020278390496969223, 0.003795596770942211, -0.017863962799310684, -0.03124441020190716, 0.26542603969573975, -0.02067817561328411, 0.01659756526350975, 0.21311193704605105, -0.03036094829440117, 0.04126020148396492, -0.03905244171619415, 0.09617955982685088, -0.15933629870414734, 0.02252127975225449, -0.15710152685642242, -0.08025606721639633, -0.02645222842693329, 0.05211944878101349, 0.01155483815819025, 0.1536170244216919, -0.22820095717906952, 0.17475029826164246, 0.03269672393798828, 0.012147448025643826, 0.06815990805625916, 0.11645437031984328, -0.007951503619551659, -0.13439007103443146, 0.11395194381475449, -0.2226255089044571, 0.23237089812755585, 0.14196579158306122, 0.06026838347315788, 0.13969066739082336, 0.1011810302734375, 0.09210866689682008, 0.0147006344050169, -0.056500982493162155, -0.185840904712677, -0.04312552511692047, 0.03849022835493088, -0.05083002895116806, 0.10150961577892303, -0.00872762780636549]','2025-04-09 14:00:34','2025-04-09 14:00:34'),(2,26,2,'faces/face_1744207234_yHgQbe3yn8.jpg',100.00,'[-0.11782488971948624, 0.13220232725143433, 0.04010097682476044, -0.12479817122220992, -0.107178695499897, -0.002272369572892785, -0.04956331104040146, -0.0964553877711296, 0.20952261984348297, -0.11892979592084885, 0.2911144196987152, -0.07582952082157135, -0.21197034418582916, -0.014089745469391346, -0.1138266995549202, 0.22295445203781128, -0.1853976845741272, -0.12697787582874298, -0.043679624795913696, 0.03927699103951454, 0.06583154946565628, -0.014551917091012, -0.04278970509767532, 0.06421369314193726, -0.09858836978673936, -0.3710415363311768, -0.08461911976337433, -0.05296464264392853, -0.016831539571285248, -0.05457738786935806, -0.003305744845420122, -0.046717338263988495, -0.2308667153120041, -0.09185834974050522, 0.04107855260372162, 0.04784010723233223, -0.021097980439662933, -0.10577492415905, 0.1815400123596191, -0.03393089398741722, -0.2774791121482849, 0.03626960143446922, 0.139849916100502, 0.2341991662979126, 0.09433601796627045, 0.0542045496404171, 0.007056984584778547, -0.17541411519050598, 0.08386882394552231, -0.2083253562450409, 0.020296726375818253, 0.12201523035764694, 0.000297680904623121, 0.09003659337759018, -0.00588034326210618, -0.12121335417032242, 0.04007891938090325, 0.1711864471435547, -0.1788625866174698, 0.01256329659372568, 0.07684867829084396, -0.021923670545220375, -0.009974590502679348, -0.09929760545492172, 0.2577603757381439, 0.11346475780010223, -0.1524568796157837, -0.1606182157993317, 0.11108572781085968, -0.13096514344215393, -0.040168073028326035, 0.04895380139350891, -0.08832139521837234, -0.22080086171627045, -0.28857970237731934, 0.026397638022899628, 0.4632111787796021, 0.16166678071022034, -0.17329470813274384, 0.04616277664899826, -0.08475973457098007, -0.03681396692991257, 0.12201585620641708, 0.1690998375415802, 0.05466564744710922, 0.03074990212917328, -0.037533678114414215, 0.008949216455221176, 0.25124692916870117, -0.020863816142082214, 0.02003857120871544, 0.2533051073551178, -0.012301561422646046, 0.023904411122202873, -0.02588910609483719, 0.09675724804401398, -0.14892810583114624, 0.019667839631438255, -0.12899047136306763, -0.03167547658085823, 0.006506953854113817, 0.05040701478719711, 0.016046207398176193, 0.136756032705307, -0.20522816479206085, 0.12511417269706726, 0.022546827793121334, -0.013780586421489716, 0.05045168846845627, 0.06664092093706131, 0.02133522555232048, -0.1125117763876915, 0.09550126641988754, -0.2166523635387421, 0.21187180280685425, 0.1498878449201584, 0.049227308481931686, 0.1515631228685379, 0.12088228017091752, 0.06549729406833649, 0.028763942420482635, -0.03913871571421623, -0.1839817315340042, -0.04338261857628822, 0.03845640644431114, -0.04772463068366051, 0.13832861185073853, -0.022682208567857742]','2025-04-09 14:00:34','2025-04-09 14:00:34'),(3,26,3,'faces/face_1744207234_VdGfBcswhC.jpg',100.00,'[-0.12079541385173798, 0.16016846895217896, 0.09103900194168092, -0.08476901799440384, -0.13060787320137024, 0.02679700404405594, -0.04143384471535683, -0.10465450584888458, 0.21583855152130127, -0.12615558505058289, 0.2632123529911041, -0.03707032650709152, -0.21185748279094696, 0.015263290144503117, -0.03688109293580055, 0.19341883063316345, -0.1935751736164093, -0.14781172573566437, -0.021629951894283295, 0.04245487228035927, 0.034872982650995255, 0.013161915354430676, 0.006233683787286282, 0.04104006290435791, -0.05420864000916481, -0.4426704645156861, -0.10305919498205184, -0.049082688987255096, 0.06536401808261871, -0.07155366986989975, -0.05797506123781204, -0.020394466817379, -0.19136478006839752, -0.050409700721502304, 0.05272454023361206, 0.10662379115819932, -0.07863019406795502, -0.1245097517967224, 0.15823543071746826, -0.0009715984924696386, -0.25542259216308594, -0.004139792174100876, 0.05610785260796547, 0.2655334174633026, 0.17001399397850037, 0.027194030582904816, 0.01838934980332851, -0.16787457466125488, 0.07578299939632416, -0.22929157316684723, 0.03386306017637253, 0.16524231433868408, 0.0014439579099416733, 0.11621049791574478, 0.0031338841654360294, -0.146732896566391, 0.015862297266721725, 0.10315190255641936, -0.21669210493564608, -0.003743091830983758, 0.08854439854621887, -0.018178477883338928, -0.016709422692656517, -0.10615449398756029, 0.2590501606464386, 0.17181870341300964, -0.1516350507736206, -0.2039971947669983, 0.10642581433057784, -0.16017137467861176, -0.02525750547647476, 0.05928417295217514, -0.15108978748321533, -0.22169937193393707, -0.21268834173679352, 0.01275055669248104, 0.4596940279006958, 0.16010528802871704, -0.1595238596200943, 0.0019474243745207789, -0.09763222932815552, -0.05142989382147789, 0.08788947016000748, 0.1939198076725006, 0.04676096513867378, 0.025668516755104065, -0.05412759631872177, 0.03718971833586693, 0.2006540298461914, -0.05981294438242912, -0.014657849445939064, 0.22746962308883667, -0.027836734429001808, 0.04882282391190529, -0.001357866101898253, 0.10920731723308565, -0.14316080510616302, 0.029364947229623795, -0.17759671807289124, -0.0957757979631424, -0.05025029182434082, 0.033634185791015625, -0.0004788991354871541, 0.14266864955425262, -0.16561050713062286, 0.19621683657169345, 0.02659754827618599, 0.00283200666308403, 0.041640911251306534, -0.017414912581443787, -0.002001967281103134, -0.09422925114631651, 0.12316879630088806, -0.2362251877784729, 0.21963700652122495, 0.1744929403066635, 0.03757366165518761, 0.17130805552005768, 0.05881776660680771, 0.08272373676300049, 0.021206406876444817, -0.051231447607278824, -0.17309977114200592, -0.0033645627554506063, -0.005733801051974297, -0.017145108431577682, 0.049179162830114365, -0.04339181259274483]','2025-04-09 14:00:34','2025-04-09 14:00:34'),(4,26,4,'faces/face_1744207234_ilOh2uDNta.jpg',100.00,'[-0.08243641257286072, 0.11655405908823012, 0.06206779181957245, -0.12388495355844498, -0.09219759702682497, 0.026606576517224312, -0.050805483013391495, -0.09195395559072496, 0.22410042583942413, -0.15868312120437622, 0.2807198762893677, -0.059931907802820206, -0.24511246383190155, 0.07494908571243286, -0.0908064916729927, 0.20525608956813812, -0.2886676788330078, -0.10924022644758224, -0.009511135518550873, -0.009266884066164494, 0.050087735056877136, -0.000546737399417907, -0.013473665341734886, 0.05978488549590111, -0.08268311619758606, -0.3725839853286743, -0.08929858356714249, -0.08409444987773895, 0.06399474292993546, -0.008358335122466087, -0.019708454608917236, -0.0241400096565485, -0.2429138720035553, -0.006356991361826658, 0.017319943755865097, 0.020582951605319977, -0.03400624915957451, -0.10389813035726549, 0.20124530792236328, -0.010159587487578392, -0.25083473324775696, -0.03408558666706085, 0.08579426258802414, 0.22641952335834503, 0.14494523406028748, -0.007324039936065674, -0.0282035730779171, -0.09441090375185011, 0.04141029343008995, -0.24087873101234436, 0.043075453490018845, 0.13947074115276337, 0.061724305152893066, 0.14352825284004211, 0.00016419666644651443, -0.16100816428661346, 0.022118711844086647, 0.12106157839298248, -0.17177332937717438, 0.0003277584328316152, 0.03776313364505768, -0.04368968307971954, 0.02932124026119709, -0.06158726289868355, 0.2890968322753906, 0.1335974633693695, -0.13784386217594147, -0.18482139706611633, 0.11260800063610076, -0.14834921061992645, -0.02255302667617798, 0.08986802399158478, -0.11096557974815369, -0.19740189611911776, -0.2401009052991867, 0.010106420144438744, 0.4411070048809051, 0.15866537392139435, -0.1786920726299286, 0.04567081481218338, -0.0942249447107315, -0.0900786519050598, 0.12295021116733552, 0.15821237862110138, 0.042624324560165405, 0.0692698061466217, -0.029506737366318703, 0.02294330671429634, 0.2167176604270935, -0.07594998925924301, -0.04758710414171219, 0.2564736008644104, -0.05371210351586342, -0.008399569429457188, 0.02653152495622635, 0.0822877436876297, -0.09851757436990738, -0.02082888036966324, -0.1571040004491806, -0.08336862921714783, -0.024091685190796852, 0.00899451319128275, -0.047242991626262665, 0.10944824665784836, -0.21581774950027463, 0.1329556703567505, 0.02555848099291325, -0.05792858451604843, 0.018678542226552963, 0.04572445526719093, -0.02271627821028233, -0.10046833008527756, 0.15420714020729065, -0.27390822768211365, 0.22582745552062988, 0.15670941770076752, 0.011369695886969566, 0.19178320467472076, 0.03070568665862083, 0.0673435777425766, -0.0057620517909526825, -0.0617859922349453, -0.1240791082382202, -0.05613016337156296, 0.04318965598940849, -0.013968677259981632, 0.11257510632276536, -0.038750652223825455]','2025-04-09 14:00:34','2025-04-09 14:00:34'),(5,26,5,'faces/face_1744207234_UPyXjK3JgJ.jpg',100.00,'[-0.08718333393335342, 0.13875292241573334, 0.09072805196046828, -0.10606227070093156, -0.15728843212127686, -0.0010054572485387323, -0.04062337055802345, -0.059834688901901245, 0.20716311037540436, -0.13657400012016296, 0.29820460081100464, -0.05200307071208954, -0.18768823146820068, 0.058539651334285736, -0.0880948007106781, 0.234778955578804, -0.1931183785200119, -0.12350519746541976, -0.0761016309261322, -0.003939405549317598, 0.02633337490260601, -0.021776577457785606, -0.0668589249253273, 0.03804648667573929, -0.1057431548833847, -0.3793908953666687, -0.0534270852804184, -0.0597534216940403, 0.03056069277226925, -0.04096284881234169, 0.005573540460318327, -0.0249850619584322, -0.17824725806713104, -0.07139724493026733, 0.05957040190696716, 0.04543657228350639, -0.05738856643438339, -0.07944115251302719, 0.17745524644851685, -0.02532093971967697, -0.27273768186569214, 0.05079353228211403, 0.107072614133358, 0.25101491808891296, 0.09131720662117004, 0.056611791253089905, 0.056058745831251144, -0.1559591442346573, 0.09945447742938995, -0.22551433742046356, 0.014641924761235714, 0.10962405800819396, 0.01991284266114235, 0.11607390642166138, 0.03801870346069336, -0.12548644840717316, 0.02954253181815147, 0.16058163344860077, -0.18282034993171692, 0.04147535562515259, 0.0959778130054474, -0.012234537862241268, -0.011041954159736632, -0.12609833478927612, 0.2863977551460266, 0.11187379062175752, -0.17391858994960785, -0.15894058346748352, 0.09788398444652556, -0.1222437471151352, -0.06784273684024811, 0.04603877291083336, -0.08999460190534592, -0.18222178518772125, -0.2950586676597595, 0.024093767628073692, 0.5009366273880005, 0.161175474524498, -0.17660635709762573, 0.003458852181211114, -0.07888029515743256, -0.03593337908387184, 0.10586776584386826, 0.1491396427154541, 0.018904615193605423, 0.015291382558643818, -0.02072869800031185, -0.008930911310017109, 0.23706035315990448, -0.03410667926073074, -0.003791303839534521, 0.20913107693195343, -0.014191948808729649, 0.025363199412822723, -0.05300658196210861, 0.09903492778539658, -0.18282052874565125, -0.004806092940270901, -0.1227801963686943, -0.06977758556604385, -0.01342760305851698, 0.033145252615213394, 0.014344319701194763, 0.1199456751346588, -0.20776408910751343, 0.17159871757030487, -0.01045255083590746, 0.01494891382753849, 0.03712330758571625, 0.13170376420021057, -0.015353555791079998, -0.09966406971216202, 0.12209520488977432, -0.22757482528686523, 0.21339021623134613, 0.18476155400276184, 0.04236438870429993, 0.12621590495109558, 0.12387591600418092, 0.030780039727687836, 0.005058521870523691, -0.0047147879377007484, -0.15521404147148132, -0.07059615850448608, 0.00884263589978218, -0.05684683471918106, 0.1151200458407402, -0.01469176635146141]','2025-04-09 14:00:34','2025-04-09 14:00:34');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ip_records`
--

LOCK TABLES `ip_records` WRITE;
/*!40000 ALTER TABLE `ip_records` DISABLE KEYS */;
INSERT INTO `ip_records` VALUES (1,NULL,'127.0.0.1','allowed','2025-04-09 15:30:56','2025-04-09 13:54:34','2025-04-09 15:30:56'),(2,1,'127.0.0.1','allowed','2025-04-09 16:44:09','2025-04-09 13:57:39','2025-04-09 16:44:09'),(3,26,'127.0.0.1','allowed','2025-04-09 16:44:06','2025-04-09 14:06:28','2025-04-09 16:44:06');
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'0001_01_05_000004_create_campuses_table',1),(4,'0001_01_06_000003_create_colleges_table',1),(5,'0001_01_06_000004_create_councils_table',1),(6,'0001_01_06_000005_create_programs_table',1),(7,'0001_01_06_000006_create_program_majors_table',1),(8,'0001_01_06_000010_create_users_table',1),(9,'2025_01_06_035243_add_two_factor_columns_to_users_table',1),(10,'2025_01_06_035347_create_personal_access_tokens_table',1),(11,'2025_01_06_042432_create_permission_tables',1),(12,'2025_01_09_080427_election_types',1),(13,'2025_01_09_080428_create_elections_table',1),(14,'2025_01_09_151536_create_positions_table',1),(15,'2025_01_09_185954_create_election_positions_table',1),(16,'2025_01_13_070722_create_party_lists_table',1),(17,'2025_01_13_091335_create_candidates_table',1),(18,'2025_01_17_163157_create_election_excluded_voters_table',1),(19,'2025_02_04_020807_create_ip_records_table',1),(20,'2025_02_14_095644_create_votes_table',1),(21,'2025_02_22_071543_create_voter_encode_votes_table',1),(22,'2025_03_22_100105_create_council_position_settings_table',1),(23,'2025_03_25_001610_create_face_data_table',1),(24,'2025_04_09_125329_create_backup_schedules_table',1),(25,'2025_04_09_130448_create_backup_files_table',1);
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
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(6,'App\\Models\\User',2),(6,'App\\Models\\User',3),(6,'App\\Models\\User',4),(6,'App\\Models\\User',5),(6,'App\\Models\\User',6),(6,'App\\Models\\User',7),(6,'App\\Models\\User',8),(6,'App\\Models\\User',9),(6,'App\\Models\\User',10),(6,'App\\Models\\User',11),(6,'App\\Models\\User',12),(6,'App\\Models\\User',13),(6,'App\\Models\\User',14),(6,'App\\Models\\User',15),(6,'App\\Models\\User',16),(6,'App\\Models\\User',17),(6,'App\\Models\\User',18),(6,'App\\Models\\User',19),(6,'App\\Models\\User',20),(6,'App\\Models\\User',21),(6,'App\\Models\\User',22),(6,'App\\Models\\User',23),(6,'App\\Models\\User',24),(6,'App\\Models\\User',25),(5,'App\\Models\\User',26);
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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view election','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(2,'create election','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(3,'edit election','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(4,'delete election','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(5,'view election results','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(6,'view vote tally','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(7,'create candidate','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(8,'edit candidate','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(9,'delete candidate','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(10,'view candidate','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(11,'view party list','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(12,'create party list','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(13,'edit party list','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(14,'delete party list','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(15,'view voter','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(16,'create voter','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(17,'edit voter','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(18,'delete voter','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(19,'view users','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(20,'create users','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(21,'edit users','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(22,'delete users','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(23,'view colleges','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(24,'create colleges','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(25,'edit colleges','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(26,'delete colleges','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(27,'view programs','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(28,'create programs','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(29,'edit programs','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(30,'delete programs','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(31,'view majors','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(32,'create majors','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(33,'edit majors','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(34,'delete majors','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(35,'view active users','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(36,'view ip records','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(37,'print ip records','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(38,'export ip records','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(39,'delete ip records','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(40,'block ip records','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(41,'allow ip records','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(42,'view database backup','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(43,'create database backup','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(44,'export database backup','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(45,'delete database backup','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(46,'run database backup','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(47,'export election','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(48,'export election results','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(49,'export vote tally','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(50,'export candidates','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(51,'export positions','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(52,'export councils','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(53,'export party list','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(54,'export voters','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(55,'export users admin','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(56,'import election','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(57,'import positions','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(58,'import councils','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(59,'import party list','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(60,'import voters','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(61,'view website management','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(62,'create website announcement','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(63,'view feedback','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(64,'view system logs','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(65,'create system logs','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(66,'edit system logs','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(67,'delete system logs','web','2025-04-09 13:53:41','2025-04-09 13:53:41');
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
INSERT INTO `positions` VALUES (1,2,'President',1,NULL,NULL),(2,2,'Internal Vice President',1,NULL,NULL),(3,2,'External Vice President',1,NULL,NULL),(4,2,'General Secretary',1,NULL,NULL),(5,2,'General Treasurer',1,NULL,NULL),(6,2,'Public Information Officer',1,NULL,NULL),(7,3,'Governor',1,NULL,NULL),(8,3,'Vice Governor',1,NULL,NULL),(9,3,'Secretary',1,NULL,NULL),(10,3,'Treasurer',1,NULL,NULL),(11,3,'Auditor',1,NULL,NULL),(12,3,'Senator',1,NULL,NULL),(13,3,'Senator',1,NULL,NULL),(14,3,'Senator',1,NULL,NULL);
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
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(64,1),(65,1),(66,1),(67,1),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(23,2),(24,2),(25,2),(26,2),(27,2),(28,2),(29,2),(30,2),(31,2),(32,2),(33,2),(34,2),(47,2),(48,2),(49,2),(50,2),(51,2),(52,2),(53,2),(54,2),(55,2),(56,2),(57,2),(58,2),(59,2),(60,2),(61,2),(62,2),(63,2),(64,2),(65,2),(66,2),(67,2),(5,3),(6,3),(5,4),(6,4),(35,5),(36,5),(37,5),(38,5),(39,5),(40,5),(41,5),(42,5),(43,5),(44,5),(45,5),(46,5),(1,7),(5,7),(6,7),(10,7),(11,7),(23,7),(27,7),(31,7),(64,7);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(2,'admin','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(3,'student-council-watcher','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(4,'local-council-watcher','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(5,'technical_officer','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(6,'voter','web','2025-04-09 13:53:41','2025-04-09 13:53:41'),(7,'faculty','web','2025-04-09 13:53:41','2025-04-09 13:53:41');
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
INSERT INTO `sessions` VALUES ('10tBvtmvZS1mbpM4xZRYblpmD5XUosFavHH4TqC2',26,'127.0.0.1','Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Mobile Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYnVUSEdRQVQ1OFAzU2dCTnNnS1hhYk1HMTRZSTV3dVhSUEQ3QmJuSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjY7czoxNjoic2VsZWN0ZWRFbGVjdGlvbiI7aToxO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vdGVjaG5pY2FsL2RhdGFiYXNlL2JhY2t1cCI7fXM6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=',1744217047),('w28UywSagk22g7x9E13j4qG9cBQB2vW7bzKZ96Gq',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','YTo3OntzOjY6Il90b2tlbiI7czo0MDoiQmJFTUFIaGpZTEhrT3ZNSHVjcmdpQ0YwTGpoT1haOGRUQjdLMUVJaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zeXN0ZW0vdXNlcnMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTA6InNob3dTcGxhc2giO2I6MTtzOjIyOiJQSFBERUJVR0JBUl9TVEFDS19EQVRBIjthOjA6e31zOjE2OiJzZWxlY3RlZEVsZWN0aW9uIjtpOjE7fQ==',1744217049);
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Kristine Mae','Vargas','L',NULL,'Female','2002-11-04','kmlvargas00120@usep.edu.ph',NULL,'+639958905771','4th Year','2021-00120',2,2,1,1,'kmlvargas00120@usep.edu.ph',NULL,'$2y$12$BirRZkW3m2t.jRjiD2BSQ.44mdFT06CHQL8/5I/e15FVoln.J.vNC',NULL,NULL,NULL,NULL,NULL,NULL,'Active',NULL,'2025-04-09 13:57:27','2025-04-09 13:57:27'),(2,'John','Doe','A','Jr','Male','2002-04-11','juan1.delacruz@example.com',NULL,'09123456787','4','2020-12346',2,2,1,1,'juan1.delacruz@example.com',NULL,'$2y$12$7vNhHh3LrpbF/2nmqvsqKePiCZlUZMUFu2/cYJXF/9E0gMreq11/u',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:29','2025-04-09 13:58:29'),(3,'Jasmine','Perez','M',NULL,'Female','2002-04-12','jmp@usep.edu.ph',NULL,'09123456781','4','2020-12347',2,2,1,1,'jmp@usep.edu.ph',NULL,'$2y$12$JmCNwjrpzKezSEui/HJtR.6XtCHH9FwtDwvx4wNIUJN/LbgksTDdq',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:29','2025-04-09 13:58:29'),(4,'Katrina','Rosales','V',NULL,'Female','2002-04-13','kvr@usep.edu.ph',NULL,'09123456782','4','2020-12348',2,2,1,1,'kvr@usep.edu.ph',NULL,'$2y$12$mKDkXFz0CKWpvEnJR7XF0udp9xEoeVVokQ6wzuIW4wO4kgHiBXe3S',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:30','2025-04-09 13:58:30'),(5,'Jaisa Mae','Maquilan','S',NULL,'Female','2002-04-14','jmsm@usep.edu.ph',NULL,'09123456783','4','2020-12349',2,2,1,1,'jmsm@usep.edu.ph',NULL,'$2y$12$eN8bThFdeI0C3HipyraScuPAhli4T6wGCSv7T/Pi7LbFTxD8caHvq',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:31','2025-04-09 13:58:31'),(6,'Robert','Dela Cruz','A',NULL,'Female','2002-04-15','radc@usep.edu.ph',NULL,'09123456784','4','2020-12350',2,2,1,1,'radc@usep.edu.ph',NULL,'$2y$12$R3I.Iw/drRQe5xzCa2LW9.WlYh7mi6VtnZhKYGrgQwvdTfFrGIdXe',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:31','2025-04-09 13:58:31'),(7,'Jasper','Getubig','Q',NULL,'Female','2002-04-16','jqg@usep.edu.ph',NULL,'09123456785','4','2020-12351',2,2,1,1,'jqg@usep.edu.ph',NULL,'$2y$12$Q.7zRqWranoTfc97r399NOPpPYt3rby0qyozX7XORbjBDvt426Wy6',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:32','2025-04-09 13:58:32'),(8,'Rose Marie','Vargas','Y',NULL,'Female','2002-04-17','rmyv@usep.edu.ph',NULL,'09123456786','4','2020-12352',2,2,1,1,'rmyv@usep.edu.ph',NULL,'$2y$12$6WLnsDYgp6Sp4sBI2rpnbeslKlGrW8k1CwZikO0fiXhTjokcSKZTO',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:32','2025-04-09 13:58:32'),(9,'Joseph','Esparcia','T',NULL,'Female','2002-04-18','jte@usep.edu.ph',NULL,'09123456788','4','2020-12353',2,2,1,1,'jte@usep.edu.ph',NULL,'$2y$12$m7xNql1sZgLSAQzMoQqicuETKhm6nf9QMMcxLkDY1HTWLxlMSr4wG',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:33','2025-04-09 13:58:33'),(10,'River','Restauro','K',NULL,'Female','2002-04-19','rkr@usep.edu.ph',NULL,'09123456789','4','2020-12354',2,2,1,1,'rkr@usep.edu.ph',NULL,'$2y$12$sNuuqB85kuHW3/Q7BWuA9uc8F0G6kky2vNKYMCN8T1ogzgxLH1m.C',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:34','2025-04-09 13:58:34'),(11,'Anthony','Ang','L',NULL,'Female','2002-04-20','ala@usep.edu.ph',NULL,'09123456790','4','2020-12355',2,2,1,1,'ala@usep.edu.ph',NULL,'$2y$12$nC.fsaxJvEiqftAg8kZ.9ui9IWGKGNBtwEtdyVrLt63005hFJnvFy',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:34','2025-04-09 13:58:34'),(12,'Miguel','Franceloso','D',NULL,'Female','2002-04-21','mdf@usep.edu.ph',NULL,'09123456791','4','2020-12356',2,2,1,1,'mdf@usep.edu.ph',NULL,'$2y$12$YsfcFMdBO0OGKxkWfuV6bODHhp9mnxavZrUfclb48paDHPx5TzONu',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:35','2025-04-09 13:58:35'),(13,'Daisy','Bayaca','C',NULL,'Female','2002-04-22','dcb@usep.edu.ph',NULL,'09123456792','4','2020-12357',2,2,1,1,'dcb@usep.edu.ph',NULL,'$2y$12$BVcP5htgvbAbNYWDW480vuYdBvkWzZwg2sWAlmSBp7hGGF6Iecug2',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:35','2025-04-09 13:58:35'),(14,'Kristine Anne','Balayan','N',NULL,'Female','2002-04-23','kanb@usep.edu.ph',NULL,'09123456793','4','2020-12358',2,2,1,1,'kanb@usep.edu.ph',NULL,'$2y$12$U8JLjq2d5gyknIIZ22VXvujTt/xc1KrJkQDjZf23Wkb8R9cDcQVJu',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:36','2025-04-09 13:58:36'),(15,'Lyka Faith','Malabad','M',NULL,'Female','2002-04-24','lfmm@usep.edu.ph',NULL,'09123456794','4','2020-12359',2,2,1,1,'lfmm@usep.edu.ph',NULL,'$2y$12$92Jfe8ltraRoZqtXJecuL.5hg0lvFk3q3osVsAoskUWIdlApW15nS',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:36','2025-04-09 13:58:36'),(16,'Ricel','Fudolin','R',NULL,'Female','2002-04-25','rrf@usep.edu.ph',NULL,'09123456795','4','2020-12360',2,2,1,1,'rrf@usep.edu.ph',NULL,'$2y$12$8L21ort40Ulbp1wKjUHpte/h0LFCgXFhIW9y3x6rZORiS8pQKGAle',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:37','2025-04-09 13:58:37'),(17,'Jessica','Aracena','I',NULL,'Female','2002-04-26','jia@usep.edu.ph',NULL,'09123456796','4','2020-12361',2,2,1,1,'jia@usep.edu.ph',NULL,'$2y$12$pPVZULcjkH57NsS9LxHSHuOQTWjMSsN2Qg5jaX/jssPSfBIGAmOLe',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:38','2025-04-09 13:58:38'),(18,'Kirsten','Fernandez','L',NULL,'Female','2002-04-27','klf@usep.edu.ph',NULL,'09123456797','4','2020-12362',2,2,1,1,'klf@usep.edu.ph',NULL,'$2y$12$fIp/vtL/x3lClhoqBS6UJO9.am7okBRpmHRbDkuYMHtBQONbrAr1G',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:39','2025-04-09 13:58:39'),(19,'Jad','Bustamante','O',NULL,'Female','2002-04-28','job@usep.edu.ph',NULL,'09123456798','4','2020-12363',2,2,1,1,'job@usep.edu.ph',NULL,'$2y$12$3mbVmKPZkkQ2vt2aQtUSyOwCF3F5mMy1YA.7uWYlKkRV4n77GJ8v6',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:40','2025-04-09 13:58:40'),(20,'Jean','Supiter','P',NULL,'Female','2002-04-29','jps@usep.edu.ph',NULL,'09123456799','4','2020-12364',2,2,1,1,'jps@usep.edu.ph',NULL,'$2y$12$RAvUdRhD88h9kWaIWh6K2u9DJJ/8lX2zDqxrFGuLHMpFkz1U0u6ii',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:40','2025-04-09 13:58:40'),(21,'Mikyla','Palmes','S',NULL,'Female','2002-04-30','msp@usep.edu.ph',NULL,'09123456100','4','2020-12365',2,2,1,1,'msp@usep.edu.ph',NULL,'$2y$12$8JuUDoMMK7z/pph8IOMPT.yiiK4w192oMaU0WgDWLAYJ2Ur3Mz.Qy',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:41','2025-04-09 13:58:41'),(22,'Nova','Zozobrado','A',NULL,'Female','2002-05-01','naz@usep.edu.ph',NULL,'09123456101','4','2020-12366',2,2,1,1,'naz@usep.edu.ph',NULL,'$2y$12$9rl7Ul53QXrdXpLP0bwOn.APRswy00Y61e3q5gFmkYdY6TfgfjBy6',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:41','2025-04-09 13:58:41'),(23,'Carla','Pagas','W',NULL,'Female','2002-05-02','cwp@usep.edu.ph',NULL,'09123456102','4','2020-12367',2,2,1,1,'cwp@usep.edu.ph',NULL,'$2y$12$qddmBwytzHHbJ2EQzA/pGuwdVdNGPZA68AK2TL1Vc2Q4m5mVaRN.6',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:42','2025-04-09 13:58:42'),(24,'Marian','Daluro','F',NULL,'Female','2002-05-03','mfd@usep.edu.ph',NULL,'09123456103','4','2020-12368',2,2,1,1,'mfd@usep.edu.ph',NULL,'$2y$12$FjIHLswAyVss8QGoh8BFc.JNt/pEkzZogMDHEAZeZuSVLy8aAea42',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:42','2025-04-09 13:58:42'),(25,'Sheena','Corpuz','C',NULL,'Female','2002-05-04','scc@usep.edu.ph',NULL,'09123456104','4','2020-12369',2,2,1,1,'scc@usep.edu.ph',NULL,'$2y$12$YPx5NetKqcgYk18NFJcGReDNBEk2iIkZSv6iI8WHThvAWhBijvYES',NULL,NULL,NULL,NULL,NULL,NULL,'Pending Verification',NULL,'2025-04-09 13:58:43','2025-04-09 13:58:43'),(26,'Hannagene','Globasa','G',NULL,'Female','2002-05-05','hgg@usep.edu.ph',NULL,'09123456105','4','2020-12370',2,2,1,1,'hgg@usep',NULL,'$2y$12$YLvztSgJHtjmC1J3C0yABefA.ORQdc854Hjv1RFGs6ovx2pTyx7pi',NULL,NULL,NULL,NULL,NULL,NULL,'Active',NULL,'2025-04-09 13:58:44','2025-04-09 14:04:20');
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

-- Dump completed on 2025-04-10  0:44:22
