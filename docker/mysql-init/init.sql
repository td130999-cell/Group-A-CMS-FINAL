/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.19-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: wordpress
-- ------------------------------------------------------
-- Server version	10.11.19-MariaDB-ubu2204

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
-- Table structure for table `wp_actionscheduler_actions`
--

DROP TABLE IF EXISTS `wp_actionscheduler_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_actionscheduler_actions` (
  `action_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hook` varchar(191) NOT NULL,
  `status` varchar(20) NOT NULL,
  `scheduled_date_gmt` datetime DEFAULT '0000-00-00 00:00:00',
  `scheduled_date_local` datetime DEFAULT '0000-00-00 00:00:00',
  `priority` tinyint(3) unsigned NOT NULL DEFAULT 10,
  `args` varchar(191) DEFAULT NULL,
  `schedule` longtext DEFAULT NULL,
  `group_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `last_attempt_gmt` datetime DEFAULT '0000-00-00 00:00:00',
  `last_attempt_local` datetime DEFAULT '0000-00-00 00:00:00',
  `claim_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `extended_args` varchar(8000) DEFAULT NULL,
  PRIMARY KEY (`action_id`),
  KEY `hook_status_scheduled_date_gmt` (`hook`(163),`status`,`scheduled_date_gmt`),
  KEY `status_scheduled_date_gmt` (`status`,`scheduled_date_gmt`),
  KEY `scheduled_date_gmt` (`scheduled_date_gmt`),
  KEY `args` (`args`),
  KEY `group_id` (`group_id`),
  KEY `last_attempt_gmt` (`last_attempt_gmt`),
  KEY `claim_id_status_priority_scheduled_date_gmt` (`claim_id`,`status`,`priority`,`scheduled_date_gmt`),
  KEY `status_last_attempt_gmt` (`status`,`last_attempt_gmt`),
  KEY `status_claim_id` (`status`,`claim_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_actionscheduler_actions`
--

LOCK TABLES `wp_actionscheduler_actions` WRITE;
/*!40000 ALTER TABLE `wp_actionscheduler_actions` DISABLE KEYS */;
INSERT INTO `wp_actionscheduler_actions` VALUES
(7,'action_scheduler_run_recurring_actions_schedule_hook','complete','2026-10-07 02:37:33','2026-10-07 02:37:33',20,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791340653;s:18:\"\0*\0first_timestamp\";i:1791340653;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791340653;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',1,1,'2026-10-07 03:28:08','2026-10-07 03:28:08',1,NULL),
(8,'action_scheduler/migration_hook','complete','2026-10-07 02:38:37','2026-10-07 02:38:37',10,'[]','O:30:\"ActionScheduler_SimpleSchedule\":2:{s:22:\"\0*\0scheduled_timestamp\";i:1791340717;s:41:\"\0ActionScheduler_SimpleSchedule\0timestamp\";i:1791340717;}',2,1,'2026-10-07 03:28:00','2026-10-07 03:28:00',1,NULL),
(9,'woocommerce_run_update_callback','complete','2026-10-07 02:52:09','2026-10-07 02:52:09',10,'{\"update_callback\":[\"Automattic\\\\WooCommerce\\\\Internal\\\\VariationGallery\\\\Migration\",\"run\"]}','O:30:\"ActionScheduler_SimpleSchedule\":2:{s:22:\"\0*\0scheduled_timestamp\";i:1791341529;s:41:\"\0ActionScheduler_SimpleSchedule\0timestamp\";i:1791341529;}',3,1,'2026-10-07 03:28:01','2026-10-07 03:28:01',1,NULL),
(10,'wc-admin_process_pending_orders_batch','complete','2026-10-07 02:52:11','2026-10-07 02:52:11',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791341531;s:18:\"\0*\0first_timestamp\";i:1791341531;s:13:\"\0*\0recurrence\";i:43200;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791341531;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:43200;}',4,1,'2026-10-07 03:28:01','2026-10-07 03:28:01',1,NULL),
(11,'woocommerce_update_marketplace_suggestions','complete','2026-10-07 02:52:22','2026-10-07 02:52:22',10,'[]','O:30:\"ActionScheduler_SimpleSchedule\":2:{s:22:\"\0*\0scheduled_timestamp\";i:1791341542;s:41:\"\0ActionScheduler_SimpleSchedule\0timestamp\";i:1791341542;}',5,1,'2026-10-07 03:28:02','2026-10-07 03:28:02',1,NULL),
(12,'woocommerce_tracker_send_event_wrapper','complete','2026-10-07 02:53:07','2026-10-07 02:53:07',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791341587;s:18:\"\0*\0first_timestamp\";i:1791341587;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791341587;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',6,1,'2026-10-07 03:28:07','2026-10-07 03:28:07',1,NULL),
(13,'fetch_patterns','failed','2026-10-07 02:52:57','2026-10-07 02:52:57',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791341577;s:18:\"\0*\0first_timestamp\";i:1791341577;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791341577;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',6,1,'2026-10-07 03:28:02','2026-10-07 03:28:02',1,NULL),
(14,'wc-admin_process_pending_orders_batch','pending','2026-10-07 15:28:01','2026-10-07 15:28:01',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791386881;s:18:\"\0*\0first_timestamp\";i:1791341531;s:13:\"\0*\0recurrence\";i:43200;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791386881;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:43200;}',4,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(15,'fetch_patterns','pending','2026-10-08 03:28:02','2026-10-08 03:28:02',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791430082;s:18:\"\0*\0first_timestamp\";i:1791341577;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791430082;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',6,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(16,'woocommerce_tracker_send_event_wrapper','pending','2026-10-08 03:28:07','2026-10-08 03:28:07',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791430087;s:18:\"\0*\0first_timestamp\";i:1791341587;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791430087;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',6,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(17,'woocommerce_scheduled_sales','pending','2026-10-08 00:00:00','2026-10-08 00:00:00',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791417600;s:18:\"\0*\0first_timestamp\";i:1791417600;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791417600;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',6,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(18,'woocommerce_cancel_unpaid_orders','pending','2026-10-07 04:28:07','2026-10-07 04:28:07',10,'[]','O:30:\"ActionScheduler_SimpleSchedule\":2:{s:22:\"\0*\0scheduled_timestamp\";i:1791347287;s:41:\"\0ActionScheduler_SimpleSchedule\0timestamp\";i:1791347287;}',6,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(19,'woocommerce_cleanup_personal_data','pending','2026-10-07 03:28:17','2026-10-07 03:28:17',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791343697;s:18:\"\0*\0first_timestamp\";i:1791343697;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791343697;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',6,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(20,'woocommerce_cleanup_logs','pending','2026-10-08 03:00:00','2026-10-08 03:00:00',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791428400;s:18:\"\0*\0first_timestamp\";i:1791428400;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791428400;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',6,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(21,'woocommerce_cleanup_sessions','pending','2026-10-08 06:00:00','2026-10-08 06:00:00',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791439200;s:18:\"\0*\0first_timestamp\";i:1791439200;s:13:\"\0*\0recurrence\";i:43200;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791439200;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:43200;}',6,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(22,'woocommerce_geoip_updater','pending','2026-10-08 06:00:00','2026-10-08 06:00:00',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791439200;s:18:\"\0*\0first_timestamp\";i:1791439200;s:13:\"\0*\0recurrence\";i:1296000;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791439200;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:1296000;}',6,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(23,'woocommerce_cleanup_rate_limits_wrapper','pending','2026-10-08 03:00:00','2026-10-08 03:00:00',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791428400;s:18:\"\0*\0first_timestamp\";i:1791428400;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791428400;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',6,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(24,'wc_admin_daily_wrapper','pending','2026-10-08 03:00:00','2026-10-08 03:00:00',10,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791428400;s:18:\"\0*\0first_timestamp\";i:1791428400;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791428400;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',6,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(25,'generate_category_lookup_table_wrapper','pending','2026-10-07 03:28:17','2026-10-07 03:28:17',10,'[]','O:30:\"ActionScheduler_SimpleSchedule\":2:{s:22:\"\0*\0scheduled_timestamp\";i:1791343697;s:41:\"\0ActionScheduler_SimpleSchedule\0timestamp\";i:1791343697;}',6,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(26,'woocommerce_refresh_order_count_cache','pending','2026-10-07 15:28:07','2026-10-07 15:28:07',10,'[\"shop_order\"]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791386887;s:18:\"\0*\0first_timestamp\";i:1791386887;s:13:\"\0*\0recurrence\";i:43200;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791386887;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:43200;}',7,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(27,'woocommerce_refresh_product_count_cache','pending','2026-10-07 15:28:08','2026-10-07 15:28:08',10,'[\"product\"]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791386888;s:18:\"\0*\0first_timestamp\";i:1791386888;s:13:\"\0*\0recurrence\";i:43200;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791386888;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:43200;}',7,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(28,'action_scheduler_run_actions_cleanup_hook','complete','2026-10-08 03:00:00','2026-10-08 03:00:00',0,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791428400;s:18:\"\0*\0first_timestamp\";i:1791428400;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791428400;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',1,1,'2026-10-09 03:54:07','2026-10-09 03:54:07',3,NULL),
(29,'action_scheduler_run_recurring_actions_schedule_hook','pending','2026-10-08 03:28:08','2026-10-08 03:28:08',20,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791430088;s:18:\"\0*\0first_timestamp\";i:1791340653;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791430088;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',1,0,'2026-10-09 03:54:06','2026-10-09 03:54:06',0,NULL),
(30,'action_scheduler_run_actions_cleanup_hook','pending','2026-10-10 03:54:07','2026-10-10 03:54:07',0,'[]','O:32:\"ActionScheduler_IntervalSchedule\":5:{s:22:\"\0*\0scheduled_timestamp\";i:1791604447;s:18:\"\0*\0first_timestamp\";i:1791428400;s:13:\"\0*\0recurrence\";i:86400;s:49:\"\0ActionScheduler_IntervalSchedule\0start_timestamp\";i:1791604447;s:53:\"\0ActionScheduler_IntervalSchedule\0interval_in_seconds\";i:86400;}',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,NULL);
/*!40000 ALTER TABLE `wp_actionscheduler_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_actionscheduler_claims`
--

DROP TABLE IF EXISTS `wp_actionscheduler_claims`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_actionscheduler_claims` (
  `claim_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_created_gmt` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`claim_id`),
  KEY `date_created_gmt` (`date_created_gmt`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_actionscheduler_claims`
--

LOCK TABLES `wp_actionscheduler_claims` WRITE;
/*!40000 ALTER TABLE `wp_actionscheduler_claims` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_actionscheduler_claims` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_actionscheduler_groups`
--

DROP TABLE IF EXISTS `wp_actionscheduler_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_actionscheduler_groups` (
  `group_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`group_id`),
  KEY `slug` (`slug`(191))
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_actionscheduler_groups`
--

LOCK TABLES `wp_actionscheduler_groups` WRITE;
/*!40000 ALTER TABLE `wp_actionscheduler_groups` DISABLE KEYS */;
INSERT INTO `wp_actionscheduler_groups` VALUES
(1,'ActionScheduler'),
(2,'action-scheduler-migration'),
(3,'woocommerce-db-updates'),
(4,'wc-admin-data'),
(5,''),
(6,'woocommerce'),
(7,'count');
/*!40000 ALTER TABLE `wp_actionscheduler_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_actionscheduler_logs`
--

DROP TABLE IF EXISTS `wp_actionscheduler_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_actionscheduler_logs` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` bigint(20) unsigned NOT NULL,
  `message` text NOT NULL,
  `log_date_gmt` datetime DEFAULT '0000-00-00 00:00:00',
  `log_date_local` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`log_id`),
  KEY `action_id` (`action_id`),
  KEY `log_date_gmt` (`log_date_gmt`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_actionscheduler_logs`
--

LOCK TABLES `wp_actionscheduler_logs` WRITE;
/*!40000 ALTER TABLE `wp_actionscheduler_logs` DISABLE KEYS */;
INSERT INTO `wp_actionscheduler_logs` VALUES
(1,7,'action created','2026-10-07 02:37:33','2026-10-07 02:37:33'),
(2,8,'action created','2026-10-07 02:37:37','2026-10-07 02:37:37'),
(3,9,'action created','2026-10-07 02:52:09','2026-10-07 02:52:09'),
(4,10,'action created','2026-10-07 02:52:11','2026-10-07 02:52:11'),
(5,11,'action created','2026-10-07 02:52:22','2026-10-07 02:52:22'),
(6,12,'action created','2026-10-07 02:52:57','2026-10-07 02:52:57'),
(7,13,'action created','2026-10-07 02:52:57','2026-10-07 02:52:57'),
(8,8,'action started via WP Cron','2026-10-07 03:28:00','2026-10-07 03:28:00'),
(9,8,'action complete via WP Cron','2026-10-07 03:28:00','2026-10-07 03:28:00'),
(10,9,'action started via WP Cron','2026-10-07 03:28:00','2026-10-07 03:28:00'),
(11,9,'action complete via WP Cron','2026-10-07 03:28:01','2026-10-07 03:28:01'),
(12,10,'action started via WP Cron','2026-10-07 03:28:01','2026-10-07 03:28:01'),
(13,10,'action complete via WP Cron','2026-10-07 03:28:01','2026-10-07 03:28:01'),
(14,14,'action created','2026-10-07 03:28:01','2026-10-07 03:28:01'),
(15,11,'action started via WP Cron','2026-10-07 03:28:01','2026-10-07 03:28:01'),
(16,11,'action complete via WP Cron','2026-10-07 03:28:02','2026-10-07 03:28:02'),
(17,13,'action started via WP Cron','2026-10-07 03:28:02','2026-10-07 03:28:02'),
(18,13,'action failed via WP Cron: Scheduled action for fetch_patterns will not be executed as no callbacks are registered.','2026-10-07 03:28:02','2026-10-07 03:28:02'),
(19,15,'action created','2026-10-07 03:28:02','2026-10-07 03:28:02'),
(20,12,'action started via WP Cron','2026-10-07 03:28:02','2026-10-07 03:28:02'),
(21,12,'action complete via WP Cron','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(22,16,'action created','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(23,7,'action started via WP Cron','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(24,17,'action created','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(25,18,'action created','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(26,19,'action created','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(27,20,'action created','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(28,21,'action created','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(29,22,'action created','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(30,23,'action created','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(31,24,'action created','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(32,25,'action created','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(33,26,'action created','2026-10-07 03:28:07','2026-10-07 03:28:07'),
(34,27,'action created','2026-10-07 03:28:08','2026-10-07 03:28:08'),
(35,28,'action created','2026-10-07 03:28:08','2026-10-07 03:28:08'),
(36,7,'action complete via WP Cron','2026-10-07 03:28:08','2026-10-07 03:28:08'),
(37,29,'action created','2026-10-07 03:28:08','2026-10-07 03:28:08'),
(38,28,'action started via WP Cron','2026-10-09 03:54:06','2026-10-09 03:54:06'),
(39,28,'action complete via WP Cron','2026-10-09 03:54:07','2026-10-09 03:54:07'),
(40,30,'action created','2026-10-09 03:54:07','2026-10-09 03:54:07');
/*!40000 ALTER TABLE `wp_actionscheduler_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_commentmeta`
--

DROP TABLE IF EXISTS `wp_commentmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_commentmeta`
--

LOCK TABLES `wp_commentmeta` WRITE;
/*!40000 ALTER TABLE `wp_commentmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_commentmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT 0,
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT 0,
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT 'comment',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT 0,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10)),
  KEY `woo_idx_comment_type` (`comment_type`),
  KEY `woo_idx_comment_date_type` (`comment_date_gmt`,`comment_type`,`comment_approved`,`comment_post_ID`),
  KEY `woo_idx_comment_approved_type` (`comment_approved`,`comment_type`,`comment_post_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_comments`
--

LOCK TABLES `wp_comments` WRITE;
/*!40000 ALTER TABLE `wp_comments` DISABLE KEYS */;
INSERT INTO `wp_comments` VALUES
(1,1,'A WordPress Commenter','wapuu@wordpress.example','https://wordpress.org/','','2026-10-07 00:26:01','2026-10-07 00:26:01','Hi, this is a comment.\nTo get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard.\nCommenter avatars come from <a href=\"https://gravatar.com/\">Gravatar</a>.',0,'1','','comment',0,0);
/*!40000 ALTER TABLE `wp_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_ff_scheduled_actions`
--

DROP TABLE IF EXISTS `wp_ff_scheduled_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_ff_scheduled_actions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) DEFAULT NULL,
  `form_id` bigint(20) unsigned DEFAULT NULL,
  `origin_id` bigint(20) unsigned DEFAULT NULL,
  `feed_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(255) DEFAULT 'submission_action',
  `status` varchar(255) DEFAULT NULL,
  `data` longtext DEFAULT NULL,
  `note` tinytext DEFAULT NULL,
  `retry_count` int(10) unsigned DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_ff_scheduled_actions`
--

LOCK TABLES `wp_ff_scheduled_actions` WRITE;
/*!40000 ALTER TABLE `wp_ff_scheduled_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_ff_scheduled_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_fluentform_entry_details`
--

DROP TABLE IF EXISTS `wp_fluentform_entry_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_fluentform_entry_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) unsigned DEFAULT NULL,
  `submission_id` bigint(20) unsigned DEFAULT NULL,
  `field_name` varchar(255) DEFAULT NULL,
  `sub_field_name` varchar(255) DEFAULT NULL,
  `field_value` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_fluentform_entry_details`
--

LOCK TABLES `wp_fluentform_entry_details` WRITE;
/*!40000 ALTER TABLE `wp_fluentform_entry_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_fluentform_entry_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_fluentform_form_analytics`
--

DROP TABLE IF EXISTS `wp_fluentform_form_analytics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_fluentform_form_analytics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `source_url` text NOT NULL,
  `platform` char(30) DEFAULT NULL,
  `browser` char(30) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `ip` char(15) DEFAULT NULL,
  `count` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id_ip` (`form_id`,`ip`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_fluentform_form_analytics`
--

LOCK TABLES `wp_fluentform_form_analytics` WRITE;
/*!40000 ALTER TABLE `wp_fluentform_form_analytics` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_fluentform_form_analytics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_fluentform_form_meta`
--

DROP TABLE IF EXISTS `wp_fluentform_form_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_fluentform_form_meta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned DEFAULT NULL,
  `meta_key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id_meta_key` (`form_id`,`meta_key`(191)),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_fluentform_form_meta`
--

LOCK TABLES `wp_fluentform_form_meta` WRITE;
/*!40000 ALTER TABLE `wp_fluentform_form_meta` DISABLE KEYS */;
INSERT INTO `wp_fluentform_form_meta` VALUES
(1,1,'template_name','basic_contact_form'),
(2,1,'formSettings','{\"confirmation\":{\"redirectTo\":\"samePage\",\"messageToShow\":\"Thank you for your message. We will get in touch with you shortly\",\"customPage\":null,\"samePageFormBehavior\":\"hide_form\",\"customUrl\":null},\"restrictions\":{\"limitNumberOfEntries\":{\"enabled\":false,\"numberOfEntries\":null,\"period\":\"total\",\"limitReachedMsg\":\"Maximum number of entries exceeded.\"},\"scheduleForm\":{\"enabled\":false,\"start\":null,\"end\":null,\"selectedDays\":[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\",\"Saturday\",\"Sunday\"],\"pendingMsg\":\"Form submission is not started yet.\",\"expiredMsg\":\"Form submission is now closed.\"},\"requireLogin\":{\"enabled\":false,\"requireLoginMsg\":\"You must be logged in to submit the form.\"},\"denyEmptySubmission\":{\"enabled\":false,\"message\":\"Sorry, you cannot submit an empty form. Let\'s hear what you wanna say.\"}},\"layout\":{\"labelPlacement\":\"top\",\"helpMessagePlacement\":\"with_label\",\"errorMessagePlacement\":\"inline\",\"cssClassName\":\"\",\"asteriskPlacement\":\"asterisk-right\"},\"delete_entry_on_submission\":\"no\",\"appendSurveyResult\":{\"enabled\":false,\"showLabel\":false,\"showCount\":false}}'),
(3,1,'advancedValidationSettings','{\"status\":false,\"type\":\"all\",\"conditions\":[{\"field\":\"\",\"operator\":\"=\",\"value\":\"\"}],\"error_message\":\"\",\"validation_type\":\"fail_on_condition_met\"}'),
(4,1,'double_optin_settings','{\"status\":\"no\",\"confirmation_message\":\"Please check your email inbox to confirm this submission\",\"email_body_type\":\"global\",\"email_subject\":\"Please confirm your form submission\",\"email_body\":\"<h2>Please Confirm Your Submission</h2><p>&nbsp;</p><p style=\"text-align: center;\"><a style=\"color: #ffffff; background-color: #454545; font-size: 16px; border-radius: 5px; text-decoration: none; font-weight: normal; font-style: normal; padding: 0.8rem 1rem; border-color: #0072ff;\" href=\"#confirmation_url#\">Confirm Submission</a></p><p>&nbsp;</p><p>If you received this email by mistake, simply delete it. Your form submission won\'t proceed if you don\'t click the confirmation link above.</p>\",\"email_field\":\"\",\"skip_if_logged_in\":\"yes\",\"skip_if_fc_subscribed\":\"no\"}'),
(5,2,'template_name','inline_subscription'),
(6,2,'formSettings','{\"confirmation\":{\"redirectTo\":\"samePage\",\"messageToShow\":\"Thank you for your message. We will get in touch with you shortly\",\"customPage\":null,\"samePageFormBehavior\":\"hide_form\",\"customUrl\":null},\"restrictions\":{\"limitNumberOfEntries\":{\"enabled\":false,\"numberOfEntries\":null,\"period\":\"total\",\"limitReachedMsg\":\"Maximum number of entries exceeded.\"},\"scheduleForm\":{\"enabled\":false,\"start\":null,\"end\":null,\"pendingMsg\":\"Form submission is not started yet.\",\"expiredMsg\":\"Form submission is now closed.\"},\"requireLogin\":{\"enabled\":false,\"requireLoginMsg\":\"You must be logged in to submit the form.\"},\"denyEmptySubmission\":{\"enabled\":false,\"message\":\"Sorry, you cannot submit an empty form. Let\'s hear what you wanna say.\"}},\"layout\":{\"labelPlacement\":\"top\",\"helpMessagePlacement\":\"with_label\",\"errorMessagePlacement\":\"inline\",\"asteriskPlacement\":\"asterisk-right\"}}'),
(7,2,'notifications','{\"name\":\"Admin Notification Email\",\"sendTo\":{\"type\":\"email\",\"email\":\"{wp.admin_email}\",\"field\":\"email\",\"routing\":[{\"email\":null,\"field\":null,\"operator\":\"=\",\"value\":null}]},\"fromName\":\"\",\"fromEmail\":\"\",\"replyTo\":\"\",\"bcc\":\"\",\"subject\":\"[{inputs.names}] New Form Submission\",\"message\":\"<p>{all_data}<\\/p> <p>This form submitted at: {embed_post.permalink}<\\/p>\",\"conditionals\":{\"status\":false,\"type\":\"all\",\"conditions\":[{\"field\":null,\"operator\":\"=\",\"value\":null}]},\"enabled\":false,\"email_template\":\"\"}'),
(8,2,'step_data_persistency_status','no'),
(9,2,'_primary_email_field','email');
/*!40000 ALTER TABLE `wp_fluentform_form_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_fluentform_forms`
--

DROP TABLE IF EXISTS `wp_fluentform_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_fluentform_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `status` varchar(45) DEFAULT 'Draft',
  `appearance_settings` text DEFAULT NULL,
  `form_fields` longtext DEFAULT NULL,
  `has_payment` tinyint(1) NOT NULL DEFAULT 0,
  `type` varchar(45) DEFAULT NULL,
  `conditions` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_fluentform_forms`
--

LOCK TABLES `wp_fluentform_forms` WRITE;
/*!40000 ALTER TABLE `wp_fluentform_forms` DISABLE KEYS */;
INSERT INTO `wp_fluentform_forms` VALUES
(1,'Contact Form Demo','published',NULL,'{\"fields\":[{\"index\":0,\"element\":\"input_name\",\"attributes\":{\"name\":\"names\",\"data-type\":\"name-element\"},\"settings\":{\"container_class\":\"\",\"admin_field_label\":\"Name\",\"conditional_logics\":[]},\"fields\":{\"first_name\":{\"element\":\"input_text\",\"attributes\":{\"type\":\"text\",\"name\":\"first_name\",\"value\":\"\",\"id\":\"\",\"class\":\"\",\"placeholder\":\"First Name\"},\"settings\":{\"container_class\":\"\",\"label\":\"First Name\",\"help_message\":\"\",\"visible\":true,\"validation_rules\":{\"required\":{\"value\":false,\"message\":\"This field is required\"}},\"conditional_logics\":[]},\"editor_options\":{\"template\":\"inputText\"}},\"middle_name\":{\"element\":\"input_text\",\"attributes\":{\"type\":\"text\",\"name\":\"middle_name\",\"value\":\"\",\"id\":\"\",\"class\":\"\",\"placeholder\":\"\",\"required\":false},\"settings\":{\"container_class\":\"\",\"label\":\"Middle Name\",\"help_message\":\"\",\"error_message\":\"\",\"visible\":false,\"validation_rules\":{\"required\":{\"value\":false,\"message\":\"This field is required\"}},\"conditional_logics\":[]},\"editor_options\":{\"template\":\"inputText\"}},\"last_name\":{\"element\":\"input_text\",\"attributes\":{\"type\":\"text\",\"name\":\"last_name\",\"value\":\"\",\"id\":\"\",\"class\":\"\",\"placeholder\":\"Last Name\",\"required\":false},\"settings\":{\"container_class\":\"\",\"label\":\"Last Name\",\"help_message\":\"\",\"error_message\":\"\",\"visible\":true,\"validation_rules\":{\"required\":{\"value\":false,\"message\":\"This field is required\"}},\"conditional_logics\":[]},\"editor_options\":{\"template\":\"inputText\"}}},\"editor_options\":{\"title\":\"Name Fields\",\"element\":\"name-fields\",\"icon_class\":\"ff-edit-name\",\"template\":\"nameFields\"},\"uniqElKey\":\"el_1570866006692\"},{\"index\":1,\"element\":\"input_email\",\"attributes\":{\"type\":\"email\",\"name\":\"email\",\"value\":\"\",\"id\":\"\",\"class\":\"\",\"placeholder\":\"Email Address\"},\"settings\":{\"container_class\":\"\",\"label\":\"Email\",\"label_placement\":\"\",\"help_message\":\"\",\"admin_field_label\":\"\",\"validation_rules\":{\"required\":{\"value\":true,\"message\":\"This field is required\"},\"email\":{\"value\":true,\"message\":\"This field must contain a valid email\"}},\"conditional_logics\":[]},\"editor_options\":{\"title\":\"Email Address\",\"icon_class\":\"ff-edit-email\",\"template\":\"inputText\"},\"uniqElKey\":\"el_1570866012914\"},{\"index\":2,\"element\":\"input_text\",\"attributes\":{\"type\":\"text\",\"name\":\"subject\",\"value\":\"\",\"class\":\"\",\"placeholder\":\"Subject\"},\"settings\":{\"container_class\":\"\",\"label\":\"Subject\",\"label_placement\":\"\",\"admin_field_label\":\"Subject\",\"help_message\":\"\",\"validation_rules\":{\"required\":{\"value\":false,\"message\":\"This field is required\"}},\"conditional_logics\":{\"type\":\"any\",\"status\":false,\"conditions\":[{\"field\":\"\",\"value\":\"\",\"operator\":\"\"}]}},\"editor_options\":{\"title\":\"Simple Text\",\"icon_class\":\"ff-edit-text\",\"template\":\"inputText\"},\"uniqElKey\":\"el_1570878958648\"},{\"index\":3,\"element\":\"textarea\",\"attributes\":{\"name\":\"message\",\"value\":\"\",\"id\":\"\",\"class\":\"\",\"placeholder\":\"Your Message\",\"rows\":4,\"cols\":2},\"settings\":{\"container_class\":\"\",\"label\":\"Your Message\",\"admin_field_label\":\"\",\"label_placement\":\"\",\"help_message\":\"\",\"validation_rules\":{\"required\":{\"value\":true,\"message\":\"This field is required\"}},\"conditional_logics\":{\"type\":\"any\",\"status\":false,\"conditions\":[{\"field\":\"\",\"value\":\"\",\"operator\":\"\"}]}},\"editor_options\":{\"title\":\"Text Area\",\"icon_class\":\"ff-edit-textarea\",\"template\":\"inputTextarea\"},\"uniqElKey\":\"el_1570879001207\"}],\"submitButton\":{\"uniqElKey\":\"el_1524065200616\",\"element\":\"button\",\"attributes\":{\"type\":\"submit\",\"class\":\"\"},\"settings\":{\"align\":\"left\",\"button_style\":\"default\",\"container_class\":\"\",\"help_message\":\"\",\"background_color\":\"#1a7efb\",\"button_size\":\"md\",\"color\":\"#ffffff\",\"button_ui\":{\"type\":\"default\",\"text\":\"Submit Form\",\"img_url\":\"\"}},\"editor_options\":{\"title\":\"Submit Button\"}}}',0,'',NULL,1,'2026-10-07 02:56:19','2026-10-07 02:56:19'),
(2,'Subscription Form','published',NULL,'{\"fields\":[{\"index\":1,\"element\":\"container\",\"attributes\":[],\"settings\":{\"container_class\":\"\",\"conditional_logics\":{\"type\":\"any\",\"status\":false,\"conditions\":[{\"field\":\"\",\"value\":\"\",\"operator\":\"\"}]}},\"columns\":[{\"fields\":[{\"index\":1,\"element\":\"input_email\",\"attributes\":{\"type\":\"email\",\"name\":\"email\",\"value\":\"\",\"id\":\"\",\"class\":\"\",\"placeholder\":\"Your Email Address\"},\"settings\":{\"container_class\":\"\",\"label\":\"\",\"label_placement\":\"\",\"help_message\":\"\",\"admin_field_label\":\"Email\",\"validation_rules\":{\"required\":{\"value\":true,\"message\":\"This field is required\"},\"email\":{\"value\":true,\"message\":\"This field must contain a valid email\"}},\"conditional_logics\":[],\"is_unique\":\"no\",\"unique_validation_message\":\"Email address need to be unique.\"},\"editor_options\":{\"title\":\"Email Address\",\"icon_class\":\"ff-edit-email\",\"template\":\"inputText\"},\"uniqElKey\":\"el_16231279686950.8779857923682932\"}]},{\"fields\":[{\"index\":15,\"element\":\"custom_submit_button\",\"attributes\":{\"class\":\"\",\"type\":\"submit\"},\"settings\":{\"button_style\":\"\",\"button_size\":\"md\",\"align\":\"left\",\"container_class\":\"\",\"current_state\":\"normal_styles\",\"background_color\":\"\",\"color\":\"\",\"hover_styles\":{\"backgroundColor\":\"#ffffff\",\"borderColor\":\"#1a7efb\",\"color\":\"#1a7efb\",\"borderRadius\":\"\",\"minWidth\":\"100%\"},\"normal_styles\":{\"backgroundColor\":\"#1a7efb\",\"borderColor\":\"#1a7efb\",\"color\":\"#ffffff\",\"borderRadius\":\"\",\"minWidth\":\"100%\"},\"button_ui\":{\"text\":\"Subscribe\",\"type\":\"default\",\"img_url\":\"\"},\"conditional_logics\":{\"type\":\"any\",\"status\":false,\"conditions\":[{\"field\":\"\",\"value\":\"\",\"operator\":\"\"}]}},\"editor_options\":{\"title\":\"Custom Submit Button\",\"icon_class\":\"dashicons dashicons-arrow-right-alt\",\"template\":\"customButton\"},\"uniqElKey\":\"el_16231279798380.5947400167493171\"}]}],\"editor_options\":{\"title\":\"Two Column Container\",\"icon_class\":\"ff-edit-column-2\"},\"uniqElKey\":\"el_16231279284710.40955091024524304\"}],\"submitButton\":{\"uniqElKey\":\"el_1524065200616\",\"element\":\"button\",\"attributes\":{\"type\":\"submit\",\"class\":\"\"},\"settings\":{\"align\":\"left\",\"button_style\":\"default\",\"container_class\":\"\",\"help_message\":\"\",\"background_color\":\"#1a7efb\",\"button_size\":\"md\",\"color\":\"#ffffff\",\"button_ui\":{\"type\":\"default\",\"text\":\"Subscribe\",\"img_url\":\"\"}},\"editor_options\":{\"title\":\"Submit Button\"}}}',0,'form',NULL,1,'2026-10-07 02:56:19','2026-10-07 02:56:19');
/*!40000 ALTER TABLE `wp_fluentform_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_fluentform_logs`
--

DROP TABLE IF EXISTS `wp_fluentform_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_fluentform_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_source_id` int(10) unsigned DEFAULT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `source_id` int(10) unsigned DEFAULT NULL,
  `component` varchar(255) DEFAULT NULL,
  `status` char(30) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_fluentform_logs`
--

LOCK TABLES `wp_fluentform_logs` WRITE;
/*!40000 ALTER TABLE `wp_fluentform_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_fluentform_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_fluentform_submission_meta`
--

DROP TABLE IF EXISTS `wp_fluentform_submission_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_fluentform_submission_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `response_id` bigint(20) unsigned DEFAULT NULL,
  `form_id` int(10) unsigned DEFAULT NULL,
  `meta_key` varchar(45) DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `response_id_meta_key` (`response_id`,`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_fluentform_submission_meta`
--

LOCK TABLES `wp_fluentform_submission_meta` WRITE;
/*!40000 ALTER TABLE `wp_fluentform_submission_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_fluentform_submission_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_fluentform_submissions`
--

DROP TABLE IF EXISTS `wp_fluentform_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_fluentform_submissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned DEFAULT NULL,
  `serial_number` int(10) unsigned DEFAULT NULL,
  `response` longtext DEFAULT NULL,
  `source_url` varchar(255) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `status` varchar(45) DEFAULT 'unread' COMMENT 'possible values: read, unread, trashed',
  `is_favourite` tinyint(1) NOT NULL DEFAULT 0,
  `browser` varchar(45) DEFAULT NULL,
  `device` varchar(45) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `payment_status` varchar(45) DEFAULT NULL,
  `payment_method` varchar(45) DEFAULT NULL,
  `payment_type` varchar(45) DEFAULT NULL,
  `currency` varchar(45) DEFAULT NULL,
  `payment_total` float DEFAULT NULL,
  `total_paid` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id_status` (`form_id`,`status`),
  KEY `form_id_created_at` (`form_id`,`created_at`),
  KEY `user_id` (`user_id`),
  KEY `serial_number` (`serial_number`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_fluentform_submissions`
--

LOCK TABLES `wp_fluentform_submissions` WRITE;
/*!40000 ALTER TABLE `wp_fluentform_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_fluentform_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT 1,
  `link_rating` int(11) NOT NULL DEFAULT 0,
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_links`
--

LOCK TABLES `wp_links` WRITE;
/*!40000 ALTER TABLE `wp_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`),
  KEY `autoload` (`autoload`)
) ENGINE=InnoDB AUTO_INCREMENT=582 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_options`
--

LOCK TABLES `wp_options` WRITE;
/*!40000 ALTER TABLE `wp_options` DISABLE KEYS */;
INSERT INTO `wp_options` VALUES
(1,'cron','a:22:{i:1791518073;a:1:{s:26:\"action_scheduler_run_queue\";a:1:{s:32:\"0d04ed39571b55704c122d726248bbac\";a:3:{s:8:\"schedule\";s:12:\"every_minute\";s:4:\"args\";a:1:{i:0;s:7:\"WP Cron\";}s:8:\"interval\";i:60;}}}i:1791518179;a:1:{s:29:\"fluentform_do_scheduled_tasks\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:21:\"ff_every_five_minutes\";s:4:\"args\";a:0:{}s:8:\"interval\";i:300;}}}i:1791519968;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1791521520;a:1:{s:20:\"jetpack_clean_nonces\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1791521523;a:1:{s:33:\"wc_admin_process_orders_milestone\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1791521536;a:1:{s:29:\"wc_admin_unsnooze_admin_notes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1791522322;a:1:{s:35:\"rank_math/content-ai/update_prompts\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1791548790;a:1:{s:21:\"wp_update_user_counts\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1791552361;a:1:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1791554161;a:1:{s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1791555961;a:1:{s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1791557529;a:1:{s:45:\"woocommerce_marketplace_cron_fetch_promotions\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1791590400;a:2:{s:35:\"rank_math/redirection/clean_trashed\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:30:\"rank_math/links/internal_links\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1791591967;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1791591968;a:1:{s:41:\"wp_privacy_personal_data_cleanup_requests\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1791591990;a:2:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1791591995;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1791600720;a:1:{s:20:\"jetpack_v2_heartbeat\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1791600979;a:1:{s:42:\"fluentform_do_email_report_scheduled_tasks\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1791945293;a:1:{s:30:\"wp_delete_temp_updater_backups\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1792023967;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}','on'),
(2,'siteurl','http://localhost:8000','on'),
(3,'home','http://localhost:8000','on'),
(4,'blogname','Group A CMS','on'),
(5,'blogdescription','','on'),
(6,'users_can_register','0','on'),
(7,'admin_email','admin@gmail.com','on'),
(8,'start_of_week','1','on'),
(9,'use_balanceTags','0','on'),
(10,'use_smilies','1','on'),
(11,'require_name_email','1','on'),
(12,'comments_notify','1','on'),
(13,'posts_per_rss','10','on'),
(14,'rss_use_excerpt','0','on'),
(15,'mailserver_url','mail.example.com','on'),
(16,'mailserver_login','login@example.com','on'),
(17,'mailserver_pass','','on'),
(18,'mailserver_port','110','on'),
(19,'default_category','1','on'),
(20,'default_comment_status','open','on'),
(21,'default_ping_status','open','on'),
(22,'default_pingback_flag','0','on'),
(23,'posts_per_page','10','on'),
(24,'date_format','F j, Y','on'),
(25,'time_format','g:i a','on'),
(26,'links_updated_date_format','F j, Y g:i a','on'),
(27,'comment_moderation','0','on'),
(28,'moderation_notify','1','on'),
(29,'permalink_structure','','on'),
(30,'rewrite_rules','','on'),
(31,'hack_file','0','on'),
(32,'blog_charset','UTF-8','on'),
(33,'moderation_keys','','off'),
(34,'active_plugins','a:3:{i:0;s:25:\"fluentform/fluentform.php\";i:1;s:30:\"seo-by-rank-math/rank-math.php\";i:2;s:27:\"woocommerce/woocommerce.php\";}','on'),
(35,'category_base','','on'),
(36,'ping_sites','https://rpc.pingomatic.com/','on'),
(37,'comment_max_links','2','on'),
(38,'gmt_offset','0','on'),
(39,'default_email_category','1','on'),
(40,'recently_edited','','off'),
(41,'template','coffee-cafe-corner','on'),
(42,'stylesheet','coffee-cafe-corner','on'),
(43,'comment_registration','0','on'),
(44,'html_type','text/html','on'),
(45,'use_trackback','0','on'),
(46,'default_role','subscriber','on'),
(47,'db_version','61833','on'),
(48,'uploads_use_yearmonth_folders','1','on'),
(49,'upload_path','','on'),
(50,'blog_public','0','on'),
(51,'default_link_category','2','on'),
(52,'show_on_front','posts','on'),
(53,'tag_base','','on'),
(54,'show_avatars','1','on'),
(55,'avatar_rating','G','on'),
(56,'upload_url_path','','on'),
(57,'thumbnail_size_w','150','on'),
(58,'thumbnail_size_h','150','on'),
(59,'thumbnail_crop','1','on'),
(60,'medium_size_w','300','on'),
(61,'medium_size_h','300','on'),
(62,'avatar_default','mystery','on'),
(63,'large_size_w','1024','on'),
(64,'large_size_h','1024','on'),
(65,'image_default_link_type','none','on'),
(66,'image_default_size','','on'),
(67,'image_default_align','','on'),
(68,'close_comments_for_old_posts','0','on'),
(69,'close_comments_days_old','14','on'),
(70,'thread_comments','1','on'),
(71,'thread_comments_depth','5','on'),
(72,'page_comments','0','on'),
(73,'comments_per_page','50','on'),
(74,'default_comments_page','newest','on'),
(75,'comment_order','asc','on'),
(76,'sticky_posts','a:0:{}','on'),
(77,'widget_categories','a:0:{}','on'),
(78,'widget_text','a:0:{}','on'),
(79,'widget_rss','a:0:{}','on'),
(80,'uninstall_plugins','a:0:{}','off'),
(81,'timezone_string','','on'),
(82,'page_for_posts','0','on'),
(83,'page_on_front','0','on'),
(84,'default_post_format','0','on'),
(85,'link_manager_enabled','0','on'),
(86,'finished_splitting_shared_terms','1','on'),
(87,'site_icon','0','on'),
(88,'medium_large_size_w','768','on'),
(89,'medium_large_size_h','0','on'),
(90,'wp_page_for_privacy_policy','3','on'),
(91,'show_comments_cookies_opt_in','1','on'),
(92,'admin_email_lifespan','1806884761','on'),
(93,'disallowed_keys','','off'),
(94,'comment_previously_approved','1','on'),
(95,'auto_plugin_theme_update_emails','a:0:{}','off'),
(96,'auto_update_core_dev','enabled','on'),
(97,'auto_update_core_minor','enabled','on'),
(98,'auto_update_core_major','enabled','on'),
(99,'wp_force_deactivated_plugins','a:0:{}','on'),
(100,'wp_attachment_pages_enabled','0','on'),
(101,'wp_notes_notify','1','on'),
(102,'initial_db_version','61833','on'),
(103,'wp_user_roles','a:7:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:140:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:23:\"rank_math_edit_htaccess\";b:1;s:16:\"rank_math_titles\";b:1;s:17:\"rank_math_general\";b:1;s:17:\"rank_math_sitemap\";b:1;s:21:\"rank_math_404_monitor\";b:1;s:22:\"rank_math_link_builder\";b:1;s:22:\"rank_math_redirections\";b:1;s:22:\"rank_math_role_manager\";b:1;s:19:\"rank_math_analytics\";b:1;s:23:\"rank_math_site_analysis\";b:1;s:25:\"rank_math_onpage_analysis\";b:1;s:24:\"rank_math_onpage_general\";b:1;s:25:\"rank_math_onpage_advanced\";b:1;s:24:\"rank_math_onpage_snippet\";b:1;s:23:\"rank_math_onpage_social\";b:1;s:20:\"rank_math_content_ai\";b:1;s:19:\"rank_math_admin_bar\";b:1;s:18:\"manage_woocommerce\";b:1;s:16:\"create_customers\";b:1;s:24:\"view_woocommerce_reports\";b:1;s:12:\"edit_product\";b:1;s:12:\"read_product\";b:1;s:14:\"delete_product\";b:1;s:13:\"edit_products\";b:1;s:20:\"edit_others_products\";b:1;s:16:\"publish_products\";b:1;s:21:\"read_private_products\";b:1;s:15:\"delete_products\";b:1;s:23:\"delete_private_products\";b:1;s:25:\"delete_published_products\";b:1;s:22:\"delete_others_products\";b:1;s:21:\"edit_private_products\";b:1;s:23:\"edit_published_products\";b:1;s:20:\"manage_product_terms\";b:1;s:18:\"edit_product_terms\";b:1;s:20:\"delete_product_terms\";b:1;s:20:\"assign_product_terms\";b:1;s:15:\"edit_shop_order\";b:1;s:15:\"read_shop_order\";b:1;s:17:\"delete_shop_order\";b:1;s:16:\"edit_shop_orders\";b:1;s:23:\"edit_others_shop_orders\";b:1;s:19:\"publish_shop_orders\";b:1;s:24:\"read_private_shop_orders\";b:1;s:18:\"delete_shop_orders\";b:1;s:26:\"delete_private_shop_orders\";b:1;s:28:\"delete_published_shop_orders\";b:1;s:25:\"delete_others_shop_orders\";b:1;s:24:\"edit_private_shop_orders\";b:1;s:26:\"edit_published_shop_orders\";b:1;s:23:\"manage_shop_order_terms\";b:1;s:21:\"edit_shop_order_terms\";b:1;s:23:\"delete_shop_order_terms\";b:1;s:23:\"assign_shop_order_terms\";b:1;s:16:\"edit_shop_coupon\";b:1;s:16:\"read_shop_coupon\";b:1;s:18:\"delete_shop_coupon\";b:1;s:17:\"edit_shop_coupons\";b:1;s:24:\"edit_others_shop_coupons\";b:1;s:20:\"publish_shop_coupons\";b:1;s:25:\"read_private_shop_coupons\";b:1;s:19:\"delete_shop_coupons\";b:1;s:27:\"delete_private_shop_coupons\";b:1;s:29:\"delete_published_shop_coupons\";b:1;s:26:\"delete_others_shop_coupons\";b:1;s:25:\"edit_private_shop_coupons\";b:1;s:27:\"edit_published_shop_coupons\";b:1;s:24:\"manage_shop_coupon_terms\";b:1;s:22:\"edit_shop_coupon_terms\";b:1;s:24:\"delete_shop_coupon_terms\";b:1;s:24:\"assign_shop_coupon_terms\";b:1;s:27:\"fluentform_dashboard_access\";b:1;s:24:\"fluentform_forms_manager\";b:1;s:25:\"fluentform_entries_viewer\";b:1;s:25:\"fluentform_manage_entries\";b:1;s:24:\"fluentform_view_payments\";b:1;s:26:\"fluentform_manage_payments\";b:1;s:27:\"fluentform_settings_manager\";b:1;s:22:\"fluentform_full_access\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:39:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:23:\"rank_math_site_analysis\";b:1;s:25:\"rank_math_onpage_analysis\";b:1;s:24:\"rank_math_onpage_general\";b:1;s:24:\"rank_math_onpage_snippet\";b:1;s:23:\"rank_math_onpage_social\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:14:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:25:\"rank_math_onpage_analysis\";b:1;s:24:\"rank_math_onpage_general\";b:1;s:24:\"rank_math_onpage_snippet\";b:1;s:23:\"rank_math_onpage_social\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}s:8:\"customer\";a:2:{s:4:\"name\";s:8:\"Customer\";s:12:\"capabilities\";a:1:{s:4:\"read\";b:1;}}s:12:\"shop_manager\";a:2:{s:4:\"name\";s:12:\"Shop manager\";s:12:\"capabilities\";a:93:{s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:4:\"read\";b:1;s:18:\"read_private_pages\";b:1;s:18:\"read_private_posts\";b:1;s:10:\"edit_posts\";b:1;s:10:\"edit_pages\";b:1;s:20:\"edit_published_posts\";b:1;s:20:\"edit_published_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"edit_private_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:17:\"edit_others_pages\";b:1;s:13:\"publish_posts\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_posts\";b:1;s:12:\"delete_pages\";b:1;s:20:\"delete_private_pages\";b:1;s:20:\"delete_private_posts\";b:1;s:22:\"delete_published_pages\";b:1;s:22:\"delete_published_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:19:\"delete_others_pages\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:17:\"moderate_comments\";b:1;s:12:\"upload_files\";b:1;s:6:\"export\";b:1;s:6:\"import\";b:1;s:10:\"list_users\";b:1;s:18:\"edit_theme_options\";b:1;s:18:\"manage_woocommerce\";b:1;s:16:\"create_customers\";b:1;s:24:\"view_woocommerce_reports\";b:1;s:12:\"edit_product\";b:1;s:12:\"read_product\";b:1;s:14:\"delete_product\";b:1;s:13:\"edit_products\";b:1;s:20:\"edit_others_products\";b:1;s:16:\"publish_products\";b:1;s:21:\"read_private_products\";b:1;s:15:\"delete_products\";b:1;s:23:\"delete_private_products\";b:1;s:25:\"delete_published_products\";b:1;s:22:\"delete_others_products\";b:1;s:21:\"edit_private_products\";b:1;s:23:\"edit_published_products\";b:1;s:20:\"manage_product_terms\";b:1;s:18:\"edit_product_terms\";b:1;s:20:\"delete_product_terms\";b:1;s:20:\"assign_product_terms\";b:1;s:15:\"edit_shop_order\";b:1;s:15:\"read_shop_order\";b:1;s:17:\"delete_shop_order\";b:1;s:16:\"edit_shop_orders\";b:1;s:23:\"edit_others_shop_orders\";b:1;s:19:\"publish_shop_orders\";b:1;s:24:\"read_private_shop_orders\";b:1;s:18:\"delete_shop_orders\";b:1;s:26:\"delete_private_shop_orders\";b:1;s:28:\"delete_published_shop_orders\";b:1;s:25:\"delete_others_shop_orders\";b:1;s:24:\"edit_private_shop_orders\";b:1;s:26:\"edit_published_shop_orders\";b:1;s:23:\"manage_shop_order_terms\";b:1;s:21:\"edit_shop_order_terms\";b:1;s:23:\"delete_shop_order_terms\";b:1;s:23:\"assign_shop_order_terms\";b:1;s:16:\"edit_shop_coupon\";b:1;s:16:\"read_shop_coupon\";b:1;s:18:\"delete_shop_coupon\";b:1;s:17:\"edit_shop_coupons\";b:1;s:24:\"edit_others_shop_coupons\";b:1;s:20:\"publish_shop_coupons\";b:1;s:25:\"read_private_shop_coupons\";b:1;s:19:\"delete_shop_coupons\";b:1;s:27:\"delete_private_shop_coupons\";b:1;s:29:\"delete_published_shop_coupons\";b:1;s:26:\"delete_others_shop_coupons\";b:1;s:25:\"edit_private_shop_coupons\";b:1;s:27:\"edit_published_shop_coupons\";b:1;s:24:\"manage_shop_coupon_terms\";b:1;s:22:\"edit_shop_coupon_terms\";b:1;s:24:\"delete_shop_coupon_terms\";b:1;s:24:\"assign_shop_coupon_terms\";b:1;}}}','on'),
(104,'fresh_site','1','off'),
(105,'user_count','1','off'),
(106,'widget_block','a:6:{i:2;a:1:{s:7:\"content\";s:19:\"<!-- wp:search /-->\";}i:3;a:1:{s:7:\"content\";s:154:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Recent Posts</h2><!-- /wp:heading --><!-- wp:latest-posts /--></div><!-- /wp:group -->\";}i:4;a:1:{s:7:\"content\";s:227:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Recent Comments</h2><!-- /wp:heading --><!-- wp:latest-comments {\"displayAvatar\":false,\"displayDate\":false,\"displayExcerpt\":false} /--></div><!-- /wp:group -->\";}i:5;a:1:{s:7:\"content\";s:146:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Archives</h2><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:group -->\";}i:6;a:1:{s:7:\"content\";s:150:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Categories</h2><!-- /wp:heading --><!-- wp:categories /--></div><!-- /wp:group -->\";}s:12:\"_multiwidget\";i:1;}','auto'),
(107,'sidebars_widgets','a:2:{s:19:\"wp_inactive_widgets\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}s:13:\"array_version\";i:3;}','auto'),
(108,'widget_pages','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(109,'widget_calendar','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(110,'widget_archives','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(111,'widget_media_audio','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(112,'widget_media_image','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(113,'widget_media_gallery','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(114,'widget_media_video','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(115,'widget_meta','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(116,'widget_search','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(117,'widget_recent-posts','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(118,'widget_recent-comments','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(119,'widget_tag_cloud','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(120,'widget_nav_menu','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(121,'widget_custom_html','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(122,'_transient_wp_core_block_css_files','a:2:{s:7:\"version\";s:5:\"7.1.3\";s:5:\"files\";a:624:{i:0;s:31:\"accordion-heading/style-rtl.css\";i:1;s:35:\"accordion-heading/style-rtl.min.css\";i:2;s:27:\"accordion-heading/style.css\";i:3;s:31:\"accordion-heading/style.min.css\";i:4;s:28:\"accordion-item/style-rtl.css\";i:5;s:32:\"accordion-item/style-rtl.min.css\";i:6;s:24:\"accordion-item/style.css\";i:7;s:28:\"accordion-item/style.min.css\";i:8;s:29:\"accordion-panel/style-rtl.css\";i:9;s:33:\"accordion-panel/style-rtl.min.css\";i:10;s:25:\"accordion-panel/style.css\";i:11;s:29:\"accordion-panel/style.min.css\";i:12;s:23:\"accordion/style-rtl.css\";i:13;s:27:\"accordion/style-rtl.min.css\";i:14;s:19:\"accordion/style.css\";i:15;s:23:\"accordion/style.min.css\";i:16;s:22:\"archives/style-rtl.css\";i:17;s:26:\"archives/style-rtl.min.css\";i:18;s:18:\"archives/style.css\";i:19;s:22:\"archives/style.min.css\";i:20;s:20:\"audio/editor-rtl.css\";i:21;s:24:\"audio/editor-rtl.min.css\";i:22;s:16:\"audio/editor.css\";i:23;s:20:\"audio/editor.min.css\";i:24;s:19:\"audio/style-rtl.css\";i:25;s:23:\"audio/style-rtl.min.css\";i:26;s:15:\"audio/style.css\";i:27;s:19:\"audio/style.min.css\";i:28;s:19:\"audio/theme-rtl.css\";i:29;s:23:\"audio/theme-rtl.min.css\";i:30;s:15:\"audio/theme.css\";i:31;s:19:\"audio/theme.min.css\";i:32;s:21:\"avatar/editor-rtl.css\";i:33;s:25:\"avatar/editor-rtl.min.css\";i:34;s:17:\"avatar/editor.css\";i:35;s:21:\"avatar/editor.min.css\";i:36;s:20:\"avatar/style-rtl.css\";i:37;s:24:\"avatar/style-rtl.min.css\";i:38;s:16:\"avatar/style.css\";i:39;s:20:\"avatar/style.min.css\";i:40;s:25:\"breadcrumbs/style-rtl.css\";i:41;s:29:\"breadcrumbs/style-rtl.min.css\";i:42;s:21:\"breadcrumbs/style.css\";i:43;s:25:\"breadcrumbs/style.min.css\";i:44;s:21:\"button/editor-rtl.css\";i:45;s:25:\"button/editor-rtl.min.css\";i:46;s:17:\"button/editor.css\";i:47;s:21:\"button/editor.min.css\";i:48;s:20:\"button/style-rtl.css\";i:49;s:24:\"button/style-rtl.min.css\";i:50;s:16:\"button/style.css\";i:51;s:20:\"button/style.min.css\";i:52;s:22:\"buttons/editor-rtl.css\";i:53;s:26:\"buttons/editor-rtl.min.css\";i:54;s:18:\"buttons/editor.css\";i:55;s:22:\"buttons/editor.min.css\";i:56;s:21:\"buttons/style-rtl.css\";i:57;s:25:\"buttons/style-rtl.min.css\";i:58;s:17:\"buttons/style.css\";i:59;s:21:\"buttons/style.min.css\";i:60;s:22:\"calendar/style-rtl.css\";i:61;s:26:\"calendar/style-rtl.min.css\";i:62;s:18:\"calendar/style.css\";i:63;s:22:\"calendar/style.min.css\";i:64;s:25:\"categories/editor-rtl.css\";i:65;s:29:\"categories/editor-rtl.min.css\";i:66;s:21:\"categories/editor.css\";i:67;s:25:\"categories/editor.min.css\";i:68;s:24:\"categories/style-rtl.css\";i:69;s:28:\"categories/style-rtl.min.css\";i:70;s:20:\"categories/style.css\";i:71;s:24:\"categories/style.min.css\";i:72;s:19:\"code/editor-rtl.css\";i:73;s:23:\"code/editor-rtl.min.css\";i:74;s:15:\"code/editor.css\";i:75;s:19:\"code/editor.min.css\";i:76;s:18:\"code/style-rtl.css\";i:77;s:22:\"code/style-rtl.min.css\";i:78;s:14:\"code/style.css\";i:79;s:18:\"code/style.min.css\";i:80;s:18:\"code/theme-rtl.css\";i:81;s:22:\"code/theme-rtl.min.css\";i:82;s:14:\"code/theme.css\";i:83;s:18:\"code/theme.min.css\";i:84;s:22:\"columns/editor-rtl.css\";i:85;s:26:\"columns/editor-rtl.min.css\";i:86;s:18:\"columns/editor.css\";i:87;s:22:\"columns/editor.min.css\";i:88;s:21:\"columns/style-rtl.css\";i:89;s:25:\"columns/style-rtl.min.css\";i:90;s:17:\"columns/style.css\";i:91;s:21:\"columns/style.min.css\";i:92;s:33:\"comment-author-name/style-rtl.css\";i:93;s:37:\"comment-author-name/style-rtl.min.css\";i:94;s:29:\"comment-author-name/style.css\";i:95;s:33:\"comment-author-name/style.min.css\";i:96;s:29:\"comment-content/style-rtl.css\";i:97;s:33:\"comment-content/style-rtl.min.css\";i:98;s:25:\"comment-content/style.css\";i:99;s:29:\"comment-content/style.min.css\";i:100;s:26:\"comment-date/style-rtl.css\";i:101;s:30:\"comment-date/style-rtl.min.css\";i:102;s:22:\"comment-date/style.css\";i:103;s:26:\"comment-date/style.min.css\";i:104;s:31:\"comment-edit-link/style-rtl.css\";i:105;s:35:\"comment-edit-link/style-rtl.min.css\";i:106;s:27:\"comment-edit-link/style.css\";i:107;s:31:\"comment-edit-link/style.min.css\";i:108;s:32:\"comment-reply-link/style-rtl.css\";i:109;s:36:\"comment-reply-link/style-rtl.min.css\";i:110;s:28:\"comment-reply-link/style.css\";i:111;s:32:\"comment-reply-link/style.min.css\";i:112;s:30:\"comment-template/style-rtl.css\";i:113;s:34:\"comment-template/style-rtl.min.css\";i:114;s:26:\"comment-template/style.css\";i:115;s:30:\"comment-template/style.min.css\";i:116;s:42:\"comments-pagination-numbers/editor-rtl.css\";i:117;s:46:\"comments-pagination-numbers/editor-rtl.min.css\";i:118;s:38:\"comments-pagination-numbers/editor.css\";i:119;s:42:\"comments-pagination-numbers/editor.min.css\";i:120;s:34:\"comments-pagination/editor-rtl.css\";i:121;s:38:\"comments-pagination/editor-rtl.min.css\";i:122;s:30:\"comments-pagination/editor.css\";i:123;s:34:\"comments-pagination/editor.min.css\";i:124;s:33:\"comments-pagination/style-rtl.css\";i:125;s:37:\"comments-pagination/style-rtl.min.css\";i:126;s:29:\"comments-pagination/style.css\";i:127;s:33:\"comments-pagination/style.min.css\";i:128;s:29:\"comments-title/editor-rtl.css\";i:129;s:33:\"comments-title/editor-rtl.min.css\";i:130;s:25:\"comments-title/editor.css\";i:131;s:29:\"comments-title/editor.min.css\";i:132;s:23:\"comments/editor-rtl.css\";i:133;s:27:\"comments/editor-rtl.min.css\";i:134;s:19:\"comments/editor.css\";i:135;s:23:\"comments/editor.min.css\";i:136;s:22:\"comments/style-rtl.css\";i:137;s:26:\"comments/style-rtl.min.css\";i:138;s:18:\"comments/style.css\";i:139;s:22:\"comments/style.min.css\";i:140;s:20:\"cover/editor-rtl.css\";i:141;s:24:\"cover/editor-rtl.min.css\";i:142;s:16:\"cover/editor.css\";i:143;s:20:\"cover/editor.min.css\";i:144;s:19:\"cover/style-rtl.css\";i:145;s:23:\"cover/style-rtl.min.css\";i:146;s:15:\"cover/style.css\";i:147;s:19:\"cover/style.min.css\";i:148;s:22:\"details/editor-rtl.css\";i:149;s:26:\"details/editor-rtl.min.css\";i:150;s:18:\"details/editor.css\";i:151;s:22:\"details/editor.min.css\";i:152;s:21:\"details/style-rtl.css\";i:153;s:25:\"details/style-rtl.min.css\";i:154;s:17:\"details/style.css\";i:155;s:21:\"details/style.min.css\";i:156;s:20:\"embed/editor-rtl.css\";i:157;s:24:\"embed/editor-rtl.min.css\";i:158;s:16:\"embed/editor.css\";i:159;s:20:\"embed/editor.min.css\";i:160;s:19:\"embed/style-rtl.css\";i:161;s:23:\"embed/style-rtl.min.css\";i:162;s:15:\"embed/style.css\";i:163;s:19:\"embed/style.min.css\";i:164;s:19:\"embed/theme-rtl.css\";i:165;s:23:\"embed/theme-rtl.min.css\";i:166;s:15:\"embed/theme.css\";i:167;s:19:\"embed/theme.min.css\";i:168;s:19:\"file/editor-rtl.css\";i:169;s:23:\"file/editor-rtl.min.css\";i:170;s:15:\"file/editor.css\";i:171;s:19:\"file/editor.min.css\";i:172;s:18:\"file/style-rtl.css\";i:173;s:22:\"file/style-rtl.min.css\";i:174;s:14:\"file/style.css\";i:175;s:18:\"file/style.min.css\";i:176;s:23:\"footnotes/style-rtl.css\";i:177;s:27:\"footnotes/style-rtl.min.css\";i:178;s:19:\"footnotes/style.css\";i:179;s:23:\"footnotes/style.min.css\";i:180;s:23:\"freeform/editor-rtl.css\";i:181;s:27:\"freeform/editor-rtl.min.css\";i:182;s:19:\"freeform/editor.css\";i:183;s:23:\"freeform/editor.min.css\";i:184;s:22:\"gallery/editor-rtl.css\";i:185;s:26:\"gallery/editor-rtl.min.css\";i:186;s:18:\"gallery/editor.css\";i:187;s:22:\"gallery/editor.min.css\";i:188;s:21:\"gallery/style-rtl.css\";i:189;s:25:\"gallery/style-rtl.min.css\";i:190;s:17:\"gallery/style.css\";i:191;s:21:\"gallery/style.min.css\";i:192;s:21:\"gallery/theme-rtl.css\";i:193;s:25:\"gallery/theme-rtl.min.css\";i:194;s:17:\"gallery/theme.css\";i:195;s:21:\"gallery/theme.min.css\";i:196;s:20:\"group/editor-rtl.css\";i:197;s:24:\"group/editor-rtl.min.css\";i:198;s:16:\"group/editor.css\";i:199;s:20:\"group/editor.min.css\";i:200;s:19:\"group/style-rtl.css\";i:201;s:23:\"group/style-rtl.min.css\";i:202;s:15:\"group/style.css\";i:203;s:19:\"group/style.min.css\";i:204;s:19:\"group/theme-rtl.css\";i:205;s:23:\"group/theme-rtl.min.css\";i:206;s:15:\"group/theme.css\";i:207;s:19:\"group/theme.min.css\";i:208;s:21:\"heading/style-rtl.css\";i:209;s:25:\"heading/style-rtl.min.css\";i:210;s:17:\"heading/style.css\";i:211;s:21:\"heading/style.min.css\";i:212;s:19:\"html/editor-rtl.css\";i:213;s:23:\"html/editor-rtl.min.css\";i:214;s:15:\"html/editor.css\";i:215;s:19:\"html/editor.min.css\";i:216;s:19:\"icon/editor-rtl.css\";i:217;s:23:\"icon/editor-rtl.min.css\";i:218;s:15:\"icon/editor.css\";i:219;s:19:\"icon/editor.min.css\";i:220;s:18:\"icon/style-rtl.css\";i:221;s:22:\"icon/style-rtl.min.css\";i:222;s:14:\"icon/style.css\";i:223;s:18:\"icon/style.min.css\";i:224;s:20:\"image/editor-rtl.css\";i:225;s:24:\"image/editor-rtl.min.css\";i:226;s:16:\"image/editor.css\";i:227;s:20:\"image/editor.min.css\";i:228;s:19:\"image/style-rtl.css\";i:229;s:23:\"image/style-rtl.min.css\";i:230;s:15:\"image/style.css\";i:231;s:19:\"image/style.min.css\";i:232;s:19:\"image/theme-rtl.css\";i:233;s:23:\"image/theme-rtl.min.css\";i:234;s:15:\"image/theme.css\";i:235;s:19:\"image/theme.min.css\";i:236;s:29:\"latest-comments/style-rtl.css\";i:237;s:33:\"latest-comments/style-rtl.min.css\";i:238;s:25:\"latest-comments/style.css\";i:239;s:29:\"latest-comments/style.min.css\";i:240;s:27:\"latest-posts/editor-rtl.css\";i:241;s:31:\"latest-posts/editor-rtl.min.css\";i:242;s:23:\"latest-posts/editor.css\";i:243;s:27:\"latest-posts/editor.min.css\";i:244;s:26:\"latest-posts/style-rtl.css\";i:245;s:30:\"latest-posts/style-rtl.min.css\";i:246;s:22:\"latest-posts/style.css\";i:247;s:26:\"latest-posts/style.min.css\";i:248;s:18:\"list/style-rtl.css\";i:249;s:22:\"list/style-rtl.min.css\";i:250;s:14:\"list/style.css\";i:251;s:18:\"list/style.min.css\";i:252;s:22:\"loginout/style-rtl.css\";i:253;s:26:\"loginout/style-rtl.min.css\";i:254;s:18:\"loginout/style.css\";i:255;s:22:\"loginout/style.min.css\";i:256;s:19:\"math/editor-rtl.css\";i:257;s:23:\"math/editor-rtl.min.css\";i:258;s:15:\"math/editor.css\";i:259;s:19:\"math/editor.min.css\";i:260;s:18:\"math/style-rtl.css\";i:261;s:22:\"math/style-rtl.min.css\";i:262;s:14:\"math/style.css\";i:263;s:18:\"math/style.min.css\";i:264;s:25:\"media-text/editor-rtl.css\";i:265;s:29:\"media-text/editor-rtl.min.css\";i:266;s:21:\"media-text/editor.css\";i:267;s:25:\"media-text/editor.min.css\";i:268;s:24:\"media-text/style-rtl.css\";i:269;s:28:\"media-text/style-rtl.min.css\";i:270;s:20:\"media-text/style.css\";i:271;s:24:\"media-text/style.min.css\";i:272;s:19:\"more/editor-rtl.css\";i:273;s:23:\"more/editor-rtl.min.css\";i:274;s:15:\"more/editor.css\";i:275;s:19:\"more/editor.min.css\";i:276;s:30:\"navigation-link/editor-rtl.css\";i:277;s:34:\"navigation-link/editor-rtl.min.css\";i:278;s:26:\"navigation-link/editor.css\";i:279;s:30:\"navigation-link/editor.min.css\";i:280;s:29:\"navigation-link/style-rtl.css\";i:281;s:33:\"navigation-link/style-rtl.min.css\";i:282;s:25:\"navigation-link/style.css\";i:283;s:29:\"navigation-link/style.min.css\";i:284;s:38:\"navigation-overlay-close/style-rtl.css\";i:285;s:42:\"navigation-overlay-close/style-rtl.min.css\";i:286;s:34:\"navigation-overlay-close/style.css\";i:287;s:38:\"navigation-overlay-close/style.min.css\";i:288;s:33:\"navigation-submenu/editor-rtl.css\";i:289;s:37:\"navigation-submenu/editor-rtl.min.css\";i:290;s:29:\"navigation-submenu/editor.css\";i:291;s:33:\"navigation-submenu/editor.min.css\";i:292;s:25:\"navigation/editor-rtl.css\";i:293;s:29:\"navigation/editor-rtl.min.css\";i:294;s:21:\"navigation/editor.css\";i:295;s:25:\"navigation/editor.min.css\";i:296;s:24:\"navigation/style-rtl.css\";i:297;s:28:\"navigation/style-rtl.min.css\";i:298;s:20:\"navigation/style.css\";i:299;s:24:\"navigation/style.min.css\";i:300;s:23:\"nextpage/editor-rtl.css\";i:301;s:27:\"nextpage/editor-rtl.min.css\";i:302;s:19:\"nextpage/editor.css\";i:303;s:23:\"nextpage/editor.min.css\";i:304;s:24:\"page-list/editor-rtl.css\";i:305;s:28:\"page-list/editor-rtl.min.css\";i:306;s:20:\"page-list/editor.css\";i:307;s:24:\"page-list/editor.min.css\";i:308;s:23:\"page-list/style-rtl.css\";i:309;s:27:\"page-list/style-rtl.min.css\";i:310;s:19:\"page-list/style.css\";i:311;s:23:\"page-list/style.min.css\";i:312;s:24:\"paragraph/editor-rtl.css\";i:313;s:28:\"paragraph/editor-rtl.min.css\";i:314;s:20:\"paragraph/editor.css\";i:315;s:24:\"paragraph/editor.min.css\";i:316;s:23:\"paragraph/style-rtl.css\";i:317;s:27:\"paragraph/style-rtl.min.css\";i:318;s:19:\"paragraph/style.css\";i:319;s:23:\"paragraph/style.min.css\";i:320;s:28:\"playlist-track/style-rtl.css\";i:321;s:32:\"playlist-track/style-rtl.min.css\";i:322;s:24:\"playlist-track/style.css\";i:323;s:28:\"playlist-track/style.min.css\";i:324;s:23:\"playlist/editor-rtl.css\";i:325;s:27:\"playlist/editor-rtl.min.css\";i:326;s:19:\"playlist/editor.css\";i:327;s:23:\"playlist/editor.min.css\";i:328;s:22:\"playlist/style-rtl.css\";i:329;s:26:\"playlist/style-rtl.min.css\";i:330;s:18:\"playlist/style.css\";i:331;s:22:\"playlist/style.min.css\";i:332;s:35:\"post-author-biography/style-rtl.css\";i:333;s:39:\"post-author-biography/style-rtl.min.css\";i:334;s:31:\"post-author-biography/style.css\";i:335;s:35:\"post-author-biography/style.min.css\";i:336;s:30:\"post-author-name/style-rtl.css\";i:337;s:34:\"post-author-name/style-rtl.min.css\";i:338;s:26:\"post-author-name/style.css\";i:339;s:30:\"post-author-name/style.min.css\";i:340;s:26:\"post-author/editor-rtl.css\";i:341;s:30:\"post-author/editor-rtl.min.css\";i:342;s:22:\"post-author/editor.css\";i:343;s:26:\"post-author/editor.min.css\";i:344;s:25:\"post-author/style-rtl.css\";i:345;s:29:\"post-author/style-rtl.min.css\";i:346;s:21:\"post-author/style.css\";i:347;s:25:\"post-author/style.min.css\";i:348;s:33:\"post-comments-count/style-rtl.css\";i:349;s:37:\"post-comments-count/style-rtl.min.css\";i:350;s:29:\"post-comments-count/style.css\";i:351;s:33:\"post-comments-count/style.min.css\";i:352;s:33:\"post-comments-form/editor-rtl.css\";i:353;s:37:\"post-comments-form/editor-rtl.min.css\";i:354;s:29:\"post-comments-form/editor.css\";i:355;s:33:\"post-comments-form/editor.min.css\";i:356;s:32:\"post-comments-form/style-rtl.css\";i:357;s:36:\"post-comments-form/style-rtl.min.css\";i:358;s:28:\"post-comments-form/style.css\";i:359;s:32:\"post-comments-form/style.min.css\";i:360;s:32:\"post-comments-link/style-rtl.css\";i:361;s:36:\"post-comments-link/style-rtl.min.css\";i:362;s:28:\"post-comments-link/style.css\";i:363;s:32:\"post-comments-link/style.min.css\";i:364;s:26:\"post-content/style-rtl.css\";i:365;s:30:\"post-content/style-rtl.min.css\";i:366;s:22:\"post-content/style.css\";i:367;s:26:\"post-content/style.min.css\";i:368;s:23:\"post-date/style-rtl.css\";i:369;s:27:\"post-date/style-rtl.min.css\";i:370;s:19:\"post-date/style.css\";i:371;s:23:\"post-date/style.min.css\";i:372;s:27:\"post-excerpt/editor-rtl.css\";i:373;s:31:\"post-excerpt/editor-rtl.min.css\";i:374;s:23:\"post-excerpt/editor.css\";i:375;s:27:\"post-excerpt/editor.min.css\";i:376;s:26:\"post-excerpt/style-rtl.css\";i:377;s:30:\"post-excerpt/style-rtl.min.css\";i:378;s:22:\"post-excerpt/style.css\";i:379;s:26:\"post-excerpt/style.min.css\";i:380;s:34:\"post-featured-image/editor-rtl.css\";i:381;s:38:\"post-featured-image/editor-rtl.min.css\";i:382;s:30:\"post-featured-image/editor.css\";i:383;s:34:\"post-featured-image/editor.min.css\";i:384;s:33:\"post-featured-image/style-rtl.css\";i:385;s:37:\"post-featured-image/style-rtl.min.css\";i:386;s:29:\"post-featured-image/style.css\";i:387;s:33:\"post-featured-image/style.min.css\";i:388;s:34:\"post-navigation-link/style-rtl.css\";i:389;s:38:\"post-navigation-link/style-rtl.min.css\";i:390;s:30:\"post-navigation-link/style.css\";i:391;s:34:\"post-navigation-link/style.min.css\";i:392;s:27:\"post-template/style-rtl.css\";i:393;s:31:\"post-template/style-rtl.min.css\";i:394;s:23:\"post-template/style.css\";i:395;s:27:\"post-template/style.min.css\";i:396;s:24:\"post-terms/style-rtl.css\";i:397;s:28:\"post-terms/style-rtl.min.css\";i:398;s:20:\"post-terms/style.css\";i:399;s:24:\"post-terms/style.min.css\";i:400;s:31:\"post-time-to-read/style-rtl.css\";i:401;s:35:\"post-time-to-read/style-rtl.min.css\";i:402;s:27:\"post-time-to-read/style.css\";i:403;s:31:\"post-time-to-read/style.min.css\";i:404;s:24:\"post-title/style-rtl.css\";i:405;s:28:\"post-title/style-rtl.min.css\";i:406;s:20:\"post-title/style.css\";i:407;s:24:\"post-title/style.min.css\";i:408;s:26:\"preformatted/style-rtl.css\";i:409;s:30:\"preformatted/style-rtl.min.css\";i:410;s:22:\"preformatted/style.css\";i:411;s:26:\"preformatted/style.min.css\";i:412;s:24:\"pullquote/editor-rtl.css\";i:413;s:28:\"pullquote/editor-rtl.min.css\";i:414;s:20:\"pullquote/editor.css\";i:415;s:24:\"pullquote/editor.min.css\";i:416;s:23:\"pullquote/style-rtl.css\";i:417;s:27:\"pullquote/style-rtl.min.css\";i:418;s:19:\"pullquote/style.css\";i:419;s:23:\"pullquote/style.min.css\";i:420;s:23:\"pullquote/theme-rtl.css\";i:421;s:27:\"pullquote/theme-rtl.min.css\";i:422;s:19:\"pullquote/theme.css\";i:423;s:23:\"pullquote/theme.min.css\";i:424;s:39:\"query-pagination-numbers/editor-rtl.css\";i:425;s:43:\"query-pagination-numbers/editor-rtl.min.css\";i:426;s:35:\"query-pagination-numbers/editor.css\";i:427;s:39:\"query-pagination-numbers/editor.min.css\";i:428;s:31:\"query-pagination/editor-rtl.css\";i:429;s:35:\"query-pagination/editor-rtl.min.css\";i:430;s:27:\"query-pagination/editor.css\";i:431;s:31:\"query-pagination/editor.min.css\";i:432;s:30:\"query-pagination/style-rtl.css\";i:433;s:34:\"query-pagination/style-rtl.min.css\";i:434;s:26:\"query-pagination/style.css\";i:435;s:30:\"query-pagination/style.min.css\";i:436;s:25:\"query-title/style-rtl.css\";i:437;s:29:\"query-title/style-rtl.min.css\";i:438;s:21:\"query-title/style.css\";i:439;s:25:\"query-title/style.min.css\";i:440;s:25:\"query-total/style-rtl.css\";i:441;s:29:\"query-total/style-rtl.min.css\";i:442;s:21:\"query-total/style.css\";i:443;s:25:\"query-total/style.min.css\";i:444;s:20:\"query/editor-rtl.css\";i:445;s:24:\"query/editor-rtl.min.css\";i:446;s:16:\"query/editor.css\";i:447;s:20:\"query/editor.min.css\";i:448;s:19:\"quote/style-rtl.css\";i:449;s:23:\"quote/style-rtl.min.css\";i:450;s:15:\"quote/style.css\";i:451;s:19:\"quote/style.min.css\";i:452;s:19:\"quote/theme-rtl.css\";i:453;s:23:\"quote/theme-rtl.min.css\";i:454;s:15:\"quote/theme.css\";i:455;s:19:\"quote/theme.min.css\";i:456;s:23:\"read-more/style-rtl.css\";i:457;s:27:\"read-more/style-rtl.min.css\";i:458;s:19:\"read-more/style.css\";i:459;s:23:\"read-more/style.min.css\";i:460;s:18:\"rss/editor-rtl.css\";i:461;s:22:\"rss/editor-rtl.min.css\";i:462;s:14:\"rss/editor.css\";i:463;s:18:\"rss/editor.min.css\";i:464;s:17:\"rss/style-rtl.css\";i:465;s:21:\"rss/style-rtl.min.css\";i:466;s:13:\"rss/style.css\";i:467;s:17:\"rss/style.min.css\";i:468;s:21:\"search/editor-rtl.css\";i:469;s:25:\"search/editor-rtl.min.css\";i:470;s:17:\"search/editor.css\";i:471;s:21:\"search/editor.min.css\";i:472;s:20:\"search/style-rtl.css\";i:473;s:24:\"search/style-rtl.min.css\";i:474;s:16:\"search/style.css\";i:475;s:20:\"search/style.min.css\";i:476;s:20:\"search/theme-rtl.css\";i:477;s:24:\"search/theme-rtl.min.css\";i:478;s:16:\"search/theme.css\";i:479;s:20:\"search/theme.min.css\";i:480;s:24:\"separator/editor-rtl.css\";i:481;s:28:\"separator/editor-rtl.min.css\";i:482;s:20:\"separator/editor.css\";i:483;s:24:\"separator/editor.min.css\";i:484;s:23:\"separator/style-rtl.css\";i:485;s:27:\"separator/style-rtl.min.css\";i:486;s:19:\"separator/style.css\";i:487;s:23:\"separator/style.min.css\";i:488;s:23:\"separator/theme-rtl.css\";i:489;s:27:\"separator/theme-rtl.min.css\";i:490;s:19:\"separator/theme.css\";i:491;s:23:\"separator/theme.min.css\";i:492;s:24:\"shortcode/editor-rtl.css\";i:493;s:28:\"shortcode/editor-rtl.min.css\";i:494;s:20:\"shortcode/editor.css\";i:495;s:24:\"shortcode/editor.min.css\";i:496;s:24:\"site-logo/editor-rtl.css\";i:497;s:28:\"site-logo/editor-rtl.min.css\";i:498;s:20:\"site-logo/editor.css\";i:499;s:24:\"site-logo/editor.min.css\";i:500;s:23:\"site-logo/style-rtl.css\";i:501;s:27:\"site-logo/style-rtl.min.css\";i:502;s:19:\"site-logo/style.css\";i:503;s:23:\"site-logo/style.min.css\";i:504;s:27:\"site-tagline/editor-rtl.css\";i:505;s:31:\"site-tagline/editor-rtl.min.css\";i:506;s:23:\"site-tagline/editor.css\";i:507;s:27:\"site-tagline/editor.min.css\";i:508;s:26:\"site-tagline/style-rtl.css\";i:509;s:30:\"site-tagline/style-rtl.min.css\";i:510;s:22:\"site-tagline/style.css\";i:511;s:26:\"site-tagline/style.min.css\";i:512;s:25:\"site-title/editor-rtl.css\";i:513;s:29:\"site-title/editor-rtl.min.css\";i:514;s:21:\"site-title/editor.css\";i:515;s:25:\"site-title/editor.min.css\";i:516;s:24:\"site-title/style-rtl.css\";i:517;s:28:\"site-title/style-rtl.min.css\";i:518;s:20:\"site-title/style.css\";i:519;s:24:\"site-title/style.min.css\";i:520;s:26:\"social-link/editor-rtl.css\";i:521;s:30:\"social-link/editor-rtl.min.css\";i:522;s:22:\"social-link/editor.css\";i:523;s:26:\"social-link/editor.min.css\";i:524;s:27:\"social-links/editor-rtl.css\";i:525;s:31:\"social-links/editor-rtl.min.css\";i:526;s:23:\"social-links/editor.css\";i:527;s:27:\"social-links/editor.min.css\";i:528;s:26:\"social-links/style-rtl.css\";i:529;s:30:\"social-links/style-rtl.min.css\";i:530;s:22:\"social-links/style.css\";i:531;s:26:\"social-links/style.min.css\";i:532;s:21:\"spacer/editor-rtl.css\";i:533;s:25:\"spacer/editor-rtl.min.css\";i:534;s:17:\"spacer/editor.css\";i:535;s:21:\"spacer/editor.min.css\";i:536;s:20:\"spacer/style-rtl.css\";i:537;s:24:\"spacer/style-rtl.min.css\";i:538;s:16:\"spacer/style.css\";i:539;s:20:\"spacer/style.min.css\";i:540;s:23:\"tab-list/editor-rtl.css\";i:541;s:27:\"tab-list/editor-rtl.min.css\";i:542;s:19:\"tab-list/editor.css\";i:543;s:23:\"tab-list/editor.min.css\";i:544;s:22:\"tab-list/style-rtl.css\";i:545;s:26:\"tab-list/style-rtl.min.css\";i:546;s:18:\"tab-list/style.css\";i:547;s:22:\"tab-list/style.min.css\";i:548;s:23:\"tab-panel/style-rtl.css\";i:549;s:27:\"tab-panel/style-rtl.min.css\";i:550;s:19:\"tab-panel/style.css\";i:551;s:23:\"tab-panel/style.min.css\";i:552;s:20:\"table/editor-rtl.css\";i:553;s:24:\"table/editor-rtl.min.css\";i:554;s:16:\"table/editor.css\";i:555;s:20:\"table/editor.min.css\";i:556;s:19:\"table/style-rtl.css\";i:557;s:23:\"table/style-rtl.min.css\";i:558;s:15:\"table/style.css\";i:559;s:19:\"table/style.min.css\";i:560;s:19:\"table/theme-rtl.css\";i:561;s:23:\"table/theme-rtl.min.css\";i:562;s:15:\"table/theme.css\";i:563;s:19:\"table/theme.min.css\";i:564;s:18:\"tabs/style-rtl.css\";i:565;s:22:\"tabs/style-rtl.min.css\";i:566;s:14:\"tabs/style.css\";i:567;s:18:\"tabs/style.min.css\";i:568;s:23:\"tag-cloud/style-rtl.css\";i:569;s:27:\"tag-cloud/style-rtl.min.css\";i:570;s:19:\"tag-cloud/style.css\";i:571;s:23:\"tag-cloud/style.min.css\";i:572;s:28:\"template-part/editor-rtl.css\";i:573;s:32:\"template-part/editor-rtl.min.css\";i:574;s:24:\"template-part/editor.css\";i:575;s:28:\"template-part/editor.min.css\";i:576;s:27:\"template-part/theme-rtl.css\";i:577;s:31:\"template-part/theme-rtl.min.css\";i:578;s:23:\"template-part/theme.css\";i:579;s:27:\"template-part/theme.min.css\";i:580;s:24:\"term-count/style-rtl.css\";i:581;s:28:\"term-count/style-rtl.min.css\";i:582;s:20:\"term-count/style.css\";i:583;s:24:\"term-count/style.min.css\";i:584;s:30:\"term-description/style-rtl.css\";i:585;s:34:\"term-description/style-rtl.min.css\";i:586;s:26:\"term-description/style.css\";i:587;s:30:\"term-description/style.min.css\";i:588;s:23:\"term-name/style-rtl.css\";i:589;s:27:\"term-name/style-rtl.min.css\";i:590;s:19:\"term-name/style.css\";i:591;s:23:\"term-name/style.min.css\";i:592;s:28:\"term-template/editor-rtl.css\";i:593;s:32:\"term-template/editor-rtl.min.css\";i:594;s:24:\"term-template/editor.css\";i:595;s:28:\"term-template/editor.min.css\";i:596;s:27:\"term-template/style-rtl.css\";i:597;s:31:\"term-template/style-rtl.min.css\";i:598;s:23:\"term-template/style.css\";i:599;s:27:\"term-template/style.min.css\";i:600;s:27:\"text-columns/editor-rtl.css\";i:601;s:31:\"text-columns/editor-rtl.min.css\";i:602;s:23:\"text-columns/editor.css\";i:603;s:27:\"text-columns/editor.min.css\";i:604;s:26:\"text-columns/style-rtl.css\";i:605;s:30:\"text-columns/style-rtl.min.css\";i:606;s:22:\"text-columns/style.css\";i:607;s:26:\"text-columns/style.min.css\";i:608;s:19:\"verse/style-rtl.css\";i:609;s:23:\"verse/style-rtl.min.css\";i:610;s:15:\"verse/style.css\";i:611;s:19:\"verse/style.min.css\";i:612;s:20:\"video/editor-rtl.css\";i:613;s:24:\"video/editor-rtl.min.css\";i:614;s:16:\"video/editor.css\";i:615;s:20:\"video/editor.min.css\";i:616;s:19:\"video/style-rtl.css\";i:617;s:23:\"video/style-rtl.min.css\";i:618;s:15:\"video/style.css\";i:619;s:19:\"video/style.min.css\";i:620;s:19:\"video/theme-rtl.css\";i:621;s:23:\"video/theme-rtl.min.css\";i:622;s:15:\"video/theme.css\";i:623;s:19:\"video/theme.min.css\";}}','on'),
(126,'_site_transient_update_core','O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-7.1.3.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-7.1.3.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-7.1.3-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-7.1.3-new-bundled.zip\";s:7:\"partial\";s:0:\"\";s:8:\"rollback\";s:0:\"\";}s:7:\"current\";s:5:\"7.1.3\";s:7:\"version\";s:5:\"7.1.3\";s:11:\"php_version\";s:3:\"7.4\";s:13:\"mysql_version\";s:5:\"5.5.5\";s:11:\"new_bundled\";s:3:\"6.7\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1791518051;s:15:\"version_checked\";s:5:\"7.1.3\";s:12:\"translations\";a:0:{}}','off'),
(131,'_site_transient_timeout_browser_8a56ddc17d5dc536f819edcc326d5df6','1791937594','off'),
(132,'_site_transient_browser_8a56ddc17d5dc536f819edcc326d5df6','a:10:{s:4:\"name\";s:6:\"Chrome\";s:7:\"version\";s:9:\"154.0.0.0\";s:8:\"platform\";s:7:\"Windows\";s:10:\"update_url\";s:29:\"https://www.google.com/chrome\";s:7:\"img_src\";s:43:\"http://s.w.org/images/browsers/chrome.png?1\";s:11:\"img_src_ssl\";s:44:\"https://s.w.org/images/browsers/chrome.png?1\";s:15:\"current_version\";s:2:\"18\";s:7:\"upgrade\";b:0;s:8:\"insecure\";b:0;s:6:\"mobile\";b:0;}','off'),
(133,'_site_transient_timeout_php_check_825d724ef8a07ad45ef5228b904e4a0f','1791937595','off'),
(134,'_site_transient_php_check_825d724ef8a07ad45ef5228b904e4a0f','a:5:{s:19:\"recommended_version\";s:3:\"8.3\";s:15:\"minimum_version\";s:3:\"7.4\";s:12:\"is_supported\";b:0;s:9:\"is_secure\";b:1;s:13:\"is_acceptable\";b:1;}','off'),
(135,'can_compress_scripts','0','on'),
(152,'theme_mods_twentytwentyfive','a:2:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1791335356;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:3:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";}s:9:\"sidebar-2\";a:2:{i:0;s:7:\"block-5\";i:1;s:7:\"block-6\";}}}}','off'),
(153,'_transient_wp_styles_for_blocks','a:2:{s:4:\"hash\";s:32:\"dc89e03ae5ee92076c7c39811dd2c608\";s:6:\"blocks\";a:9:{s:32:\"832dc2d864d79097d8b8b493ad93453b\";s:0:\"\";s:32:\"45d3e0c4afcbd8cf25cb1ba51abfb3d7\";s:46:\":root :where(.wp-block-icon svg){width: 24px;}\";s:32:\"feca6e996f694be2d29599793228e0d7\";s:0:\"\";s:32:\"5eef131663eddaf830554df656fc2968\";s:0:\"\";s:32:\"c99c05932c6685777ec5b856698fcc7d\";s:0:\"\";s:32:\"dec8d648f30b13caec8e61374591787d\";s:0:\"\";s:32:\"6c35533f7a92cce94808323603db9fc8\";s:0:\"\";s:32:\"6a0505cd5c78a87ed77570cda43c1132\";s:0:\"\";s:32:\"25a66f156386551185570f72a9f7d44e\";s:69:\":root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}\";}}','on'),
(154,'current_theme','Coffee Cafe Corner','auto'),
(155,'theme_mods_coffee-cafe-corner','a:5:{i:0;b:0;s:19:\"wp_classic_sidebars\";a:0:{}s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1791335359;s:4:\"data\";a:1:{s:19:\"wp_inactive_widgets\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}}}s:18:\"nav_menu_locations\";a:2:{s:18:\"footer-quick-links\";i:16;s:14:\"footer-company\";i:17;}s:18:\"custom_css_post_id\";i:-1;}','off'),
(156,'theme_switched','','auto'),
(164,'_site_transient_wp_plugin_dependencies_plugin_data','a:0:{}','off'),
(165,'recently_activated','a:0:{}','off'),
(174,'action_scheduler_hybrid_store_demarkation','6','auto'),
(175,'schema-ActionScheduler_StoreSchema','8.0.1791340653','auto'),
(176,'schema-ActionScheduler_LoggerSchema','3.0.1791340653','auto'),
(177,'rank_math_known_post_types','a:3:{s:4:\"post\";s:4:\"post\";s:4:\"page\";s:4:\"page\";s:10:\"attachment\";s:10:\"attachment\";}','auto'),
(178,'rank_math_modules','a:13:{i:0;s:12:\"link-counter\";i:1;s:9:\"analytics\";i:2;s:12:\"seo-analysis\";i:3;s:7:\"sitemap\";i:4;s:12:\"rich-snippet\";i:5;s:11:\"woocommerce\";i:6;s:10:\"buddypress\";i:7;s:7:\"bbpress\";i:8;s:3:\"acf\";i:9;s:11:\"web-stories\";i:10;s:10:\"content-ai\";i:11;s:16:\"instant-indexing\";i:12;s:13:\"ai-visibility\";}','auto'),
(179,'rank-math-options-general','a:47:{s:19:\"strip_category_base\";s:3:\"off\";s:24:\"attachment_redirect_urls\";s:2:\"on\";s:27:\"attachment_redirect_default\";s:21:\"http://localhost:8000\";s:23:\"nofollow_external_links\";s:3:\"off\";s:20:\"nofollow_image_links\";s:3:\"off\";s:25:\"new_window_external_links\";s:2:\"on\";s:11:\"add_img_alt\";s:3:\"off\";s:14:\"img_alt_format\";s:11:\" %filename%\";s:13:\"add_img_title\";s:3:\"off\";s:16:\"img_title_format\";s:22:\"%title% %count(title)%\";s:11:\"breadcrumbs\";s:3:\"off\";s:21:\"breadcrumbs_separator\";s:1:\"-\";s:16:\"breadcrumbs_home\";s:2:\"on\";s:22:\"breadcrumbs_home_label\";s:4:\"Home\";s:26:\"breadcrumbs_archive_format\";s:15:\"Archives for %s\";s:25:\"breadcrumbs_search_format\";s:14:\"Results for %s\";s:21:\"breadcrumbs_404_label\";s:25:\"404 Error: page not found\";s:31:\"breadcrumbs_ancestor_categories\";s:3:\"off\";s:21:\"breadcrumbs_blog_page\";s:3:\"off\";s:16:\"404_monitor_mode\";s:6:\"simple\";s:17:\"404_monitor_limit\";i:100;s:35:\"404_monitor_ignore_query_parameters\";s:2:\"on\";s:24:\"redirections_header_code\";s:3:\"301\";s:18:\"redirections_debug\";s:3:\"off\";s:23:\"console_caching_control\";s:2:\"90\";s:21:\"console_email_reports\";s:2:\"on\";s:23:\"console_email_frequency\";s:7:\"monthly\";s:22:\"wc_remove_product_base\";s:3:\"off\";s:23:\"wc_remove_category_base\";s:3:\"off\";s:31:\"wc_remove_category_parent_slugs\";s:3:\"off\";s:18:\"rss_before_content\";s:0:\"\";s:17:\"rss_after_content\";s:0:\"\";s:19:\"wc_remove_generator\";s:2:\"on\";s:24:\"remove_shop_snippet_data\";s:2:\"on\";s:18:\"frontend_seo_score\";s:3:\"off\";s:29:\"frontend_seo_score_post_types\";a:1:{i:0;s:4:\"post\";}s:27:\"frontend_seo_score_position\";s:3:\"top\";s:10:\"setup_mode\";s:8:\"advanced\";s:21:\"content_ai_post_types\";a:2:{i:0;s:4:\"post\";i:1;s:4:\"page\";}s:18:\"content_ai_country\";s:3:\"all\";s:15:\"content_ai_tone\";s:6:\"Formal\";s:19:\"content_ai_audience\";s:16:\"General Audience\";s:19:\"content_ai_language\";s:10:\"US English\";s:15:\"analytics_stats\";s:2:\"on\";s:15:\"toc_block_title\";s:17:\"Table of Contents\";s:20:\"toc_block_list_style\";s:2:\"ul\";s:15:\"llms_post_types\";a:2:{i:0;s:4:\"post\";i:1;s:4:\"page\";}}','auto'),
(180,'rank-math-options-titles','a:107:{s:24:\"noindex_empty_taxonomies\";s:2:\"on\";s:15:\"title_separator\";s:1:\"-\";s:17:\"capitalize_titles\";s:3:\"off\";s:17:\"twitter_card_type\";s:19:\"summary_large_image\";s:19:\"knowledgegraph_type\";s:6:\"person\";s:19:\"knowledgegraph_name\";s:11:\"Group A CMS\";s:12:\"website_name\";s:11:\"Group A CMS\";s:19:\"local_business_type\";s:12:\"Organization\";s:20:\"local_address_format\";s:43:\"{address} {locality}, {region} {postalcode}\";s:13:\"opening_hours\";a:7:{i:0;a:2:{s:3:\"day\";s:6:\"Monday\";s:4:\"time\";s:11:\"09:00-17:00\";}i:1;a:2:{s:3:\"day\";s:7:\"Tuesday\";s:4:\"time\";s:11:\"09:00-17:00\";}i:2;a:2:{s:3:\"day\";s:9:\"Wednesday\";s:4:\"time\";s:11:\"09:00-17:00\";}i:3;a:2:{s:3:\"day\";s:8:\"Thursday\";s:4:\"time\";s:11:\"09:00-17:00\";}i:4;a:2:{s:3:\"day\";s:6:\"Friday\";s:4:\"time\";s:11:\"09:00-17:00\";}i:5;a:2:{s:3:\"day\";s:8:\"Saturday\";s:4:\"time\";s:11:\"09:00-17:00\";}i:6;a:2:{s:3:\"day\";s:6:\"Sunday\";s:4:\"time\";s:11:\"09:00-17:00\";}}s:20:\"opening_hours_format\";s:3:\"off\";s:14:\"homepage_title\";s:34:\"%sitename% %page% %sep% %sitedesc%\";s:20:\"homepage_description\";s:0:\"\";s:22:\"homepage_custom_robots\";s:3:\"off\";s:23:\"disable_author_archives\";s:3:\"off\";s:15:\"url_author_base\";s:6:\"author\";s:20:\"author_custom_robots\";s:2:\"on\";s:13:\"author_robots\";a:1:{i:0;s:7:\"noindex\";}s:20:\"author_archive_title\";s:30:\"%name% %sep% %sitename% %page%\";s:19:\"author_add_meta_box\";s:2:\"on\";s:21:\"disable_date_archives\";s:2:\"on\";s:18:\"date_archive_title\";s:30:\"%date% %page% %sep% %sitename%\";s:12:\"search_title\";s:38:\"%search_query% %page% %sep% %sitename%\";s:9:\"404_title\";s:31:\"Page Not Found %sep% %sitename%\";s:19:\"date_archive_robots\";a:1:{i:0;s:7:\"noindex\";}s:14:\"noindex_search\";s:2:\"on\";s:24:\"noindex_archive_subpages\";s:3:\"off\";s:26:\"noindex_password_protected\";s:3:\"off\";s:32:\"pt_download_default_rich_snippet\";s:7:\"product\";s:29:\"author_slack_enhanced_sharing\";s:2:\"on\";s:13:\"pt_post_title\";s:24:\"%title% %sep% %sitename%\";s:19:\"pt_post_description\";s:9:\"%excerpt%\";s:14:\"pt_post_robots\";a:1:{i:0;s:5:\"index\";}s:21:\"pt_post_custom_robots\";s:3:\"off\";s:28:\"pt_post_default_rich_snippet\";s:7:\"article\";s:28:\"pt_post_default_article_type\";s:11:\"BlogPosting\";s:28:\"pt_post_default_snippet_name\";s:11:\"%seo_title%\";s:28:\"pt_post_default_snippet_desc\";s:17:\"%seo_description%\";s:30:\"pt_post_slack_enhanced_sharing\";s:2:\"on\";s:17:\"pt_post_ls_use_fk\";s:6:\"titles\";s:20:\"pt_post_add_meta_box\";s:2:\"on\";s:20:\"pt_post_bulk_editing\";s:7:\"editing\";s:24:\"pt_post_link_suggestions\";s:2:\"on\";s:24:\"pt_post_primary_taxonomy\";s:8:\"category\";s:13:\"pt_page_title\";s:24:\"%title% %sep% %sitename%\";s:19:\"pt_page_description\";s:9:\"%excerpt%\";s:14:\"pt_page_robots\";a:1:{i:0;s:5:\"index\";}s:21:\"pt_page_custom_robots\";s:3:\"off\";s:28:\"pt_page_default_rich_snippet\";s:7:\"article\";s:28:\"pt_page_default_article_type\";s:7:\"Article\";s:28:\"pt_page_default_snippet_name\";s:11:\"%seo_title%\";s:28:\"pt_page_default_snippet_desc\";s:17:\"%seo_description%\";s:30:\"pt_page_slack_enhanced_sharing\";s:2:\"on\";s:17:\"pt_page_ls_use_fk\";s:6:\"titles\";s:20:\"pt_page_add_meta_box\";s:2:\"on\";s:20:\"pt_page_bulk_editing\";s:7:\"editing\";s:24:\"pt_page_link_suggestions\";s:2:\"on\";s:19:\"pt_attachment_title\";s:24:\"%title% %sep% %sitename%\";s:25:\"pt_attachment_description\";s:9:\"%excerpt%\";s:20:\"pt_attachment_robots\";a:1:{i:0;s:7:\"noindex\";}s:27:\"pt_attachment_custom_robots\";s:2:\"on\";s:34:\"pt_attachment_default_rich_snippet\";s:3:\"off\";s:34:\"pt_attachment_default_article_type\";s:7:\"Article\";s:34:\"pt_attachment_default_snippet_name\";s:11:\"%seo_title%\";s:34:\"pt_attachment_default_snippet_desc\";s:17:\"%seo_description%\";s:36:\"pt_attachment_slack_enhanced_sharing\";s:3:\"off\";s:26:\"pt_attachment_add_meta_box\";s:3:\"off\";s:16:\"pt_product_title\";s:24:\"%title% %sep% %sitename%\";s:22:\"pt_product_description\";s:9:\"%excerpt%\";s:17:\"pt_product_robots\";a:1:{i:0;s:5:\"index\";}s:24:\"pt_product_custom_robots\";s:3:\"off\";s:31:\"pt_product_default_rich_snippet\";s:7:\"product\";s:31:\"pt_product_default_article_type\";s:7:\"Article\";s:31:\"pt_product_default_snippet_name\";s:11:\"%seo_title%\";s:31:\"pt_product_default_snippet_desc\";s:17:\"%seo_description%\";s:33:\"pt_product_slack_enhanced_sharing\";s:2:\"on\";s:20:\"pt_product_ls_use_fk\";s:6:\"titles\";s:23:\"pt_product_add_meta_box\";s:2:\"on\";s:23:\"pt_product_bulk_editing\";s:7:\"editing\";s:27:\"pt_product_link_suggestions\";s:2:\"on\";s:27:\"pt_product_primary_taxonomy\";s:11:\"product_cat\";s:18:\"pt_web-story_title\";s:24:\"%title% %sep% %sitename%\";s:24:\"pt_web-story_description\";s:9:\"%excerpt%\";s:19:\"pt_web-story_robots\";a:1:{i:0;s:5:\"index\";}s:26:\"pt_web-story_custom_robots\";s:3:\"off\";s:33:\"pt_web-story_default_rich_snippet\";s:7:\"article\";s:33:\"pt_web-story_default_article_type\";s:7:\"Article\";s:33:\"pt_web-story_default_snippet_name\";s:11:\"%seo_title%\";s:33:\"pt_web-story_default_snippet_desc\";s:17:\"%seo_description%\";s:35:\"pt_web-story_slack_enhanced_sharing\";s:3:\"off\";s:25:\"pt_web-story_add_meta_box\";s:3:\"off\";s:18:\"tax_category_title\";s:23:\"%term% %sep% %sitename%\";s:19:\"tax_category_robots\";a:1:{i:0;s:5:\"index\";}s:25:\"tax_category_add_meta_box\";s:2:\"on\";s:26:\"tax_category_custom_robots\";s:3:\"off\";s:24:\"tax_category_description\";s:18:\"%term_description%\";s:35:\"tax_category_slack_enhanced_sharing\";s:2:\"on\";s:25:\"tax_category_bulk_editing\";i:0;s:18:\"tax_post_tag_title\";s:23:\"%term% %sep% %sitename%\";s:19:\"tax_post_tag_robots\";a:1:{i:0;s:7:\"noindex\";}s:25:\"tax_post_tag_add_meta_box\";s:3:\"off\";s:26:\"tax_post_tag_custom_robots\";s:2:\"on\";s:24:\"tax_post_tag_description\";s:18:\"%term_description%\";s:35:\"tax_post_tag_slack_enhanced_sharing\";s:2:\"on\";s:25:\"tax_post_tag_bulk_editing\";i:0;s:31:\"remove_product_cat_snippet_data\";s:2:\"on\";s:31:\"remove_product_tag_snippet_data\";s:2:\"on\";}','auto'),
(181,'rank-math-options-sitemap','a:16:{s:14:\"items_per_page\";i:200;s:14:\"include_images\";s:2:\"on\";s:22:\"include_featured_image\";s:3:\"off\";s:13:\"exclude_roles\";a:2:{i:0;s:11:\"contributor\";i:1;s:10:\"subscriber\";}s:12:\"html_sitemap\";s:2:\"on\";s:20:\"html_sitemap_display\";s:9:\"shortcode\";s:17:\"html_sitemap_sort\";s:9:\"published\";s:23:\"html_sitemap_seo_titles\";s:6:\"titles\";s:15:\"authors_sitemap\";s:2:\"on\";s:15:\"pt_post_sitemap\";s:2:\"on\";s:15:\"pt_page_sitemap\";s:2:\"on\";s:21:\"pt_attachment_sitemap\";s:3:\"off\";s:18:\"pt_product_sitemap\";s:2:\"on\";s:20:\"pt_web-story_sitemap\";s:3:\"off\";s:20:\"tax_category_sitemap\";s:2:\"on\";s:20:\"tax_post_tag_sitemap\";s:3:\"off\";}','auto'),
(182,'rank-math-options-instant-indexing','a:2:{s:15:\"bing_post_types\";a:2:{i:0;s:4:\"post\";i:1;s:4:\"page\";}s:16:\"indexnow_api_key\";s:32:\"e9fbaea83bfb4c4ebebce74598cc0fac\";}','auto'),
(185,'rank_math_version','1.0.280','auto'),
(186,'rank_math_db_version','1','auto'),
(187,'rank_math_install_date','1791340654','auto'),
(189,'action_scheduler_lock_async-request-runner','6ac845232edc58.44707507|1791509855','no'),
(190,'rank_math_notifications','a:1:{i:0;a:2:{s:7:\"message\";s:360:\"Rank Math has detected a new post type: <code>product</code>. You may want to check the settings of the <a href=\"http://localhost:8000/wp-admin/admin.php?page=rank-math-options-titles&view=post-type-product\">Titles &amp; Meta page</a> and <a href=\"http://localhost:8000/wp-admin/admin.php?page=rank-math-options-sitemap&view=post-type-product\">the Sitemap</a>.\";s:7:\"options\";a:5:{s:2:\"id\";s:13:\"new_post_type\";s:7:\"classes\";s:16:\"rank-math-notice\";s:4:\"type\";s:4:\"info\";s:6:\"screen\";s:3:\"any\";s:10:\"capability\";s:0:\"\";}}}','auto'),
(191,'mcp_jwt_secret','d6dd012d6304fcbeb2a849ac1d44fad45b5b85296b1e0e81ae7fe3f0372ee072','off'),
(194,'wpmedia_mcp_oauth_rewrite_version','1','off'),
(197,'rank_math_registration_skip','1','auto'),
(198,'rank_math_review_notice_date','1792550345','off'),
(199,'rank_math_pro_notice_date','1792204745','off'),
(200,'rank_math_review_posts_converted','1','auto'),
(201,'_transient_rank_math_first_submenu_id','rank-math','on'),
(208,'woocommerce_newly_installed','no','auto'),
(209,'woocommerce_order_stats_has_fulfillment_column','no','off'),
(210,'woocommerce_schema_version','920','auto'),
(211,'woocommerce_store_address','','on'),
(212,'woocommerce_store_address_2','','on'),
(213,'woocommerce_store_city','','on'),
(214,'woocommerce_default_country','US:CA','on'),
(215,'woocommerce_store_postcode','','on'),
(216,'woocommerce_allowed_countries','all','on'),
(217,'woocommerce_all_except_countries','','on'),
(218,'woocommerce_specific_allowed_countries','','on'),
(219,'woocommerce_ship_to_countries','','on'),
(220,'woocommerce_specific_ship_to_countries','','on'),
(221,'woocommerce_default_customer_address','base','on'),
(222,'woocommerce_address_autocomplete_enabled','no','on'),
(223,'woocommerce_calc_taxes','no','on'),
(224,'woocommerce_enable_coupons','yes','on'),
(225,'woocommerce_calc_discounts_sequentially','no','off'),
(226,'woocommerce_currency','USD','on'),
(227,'woocommerce_currency_pos','left','on'),
(228,'woocommerce_price_thousand_sep',',','on'),
(229,'woocommerce_price_decimal_sep','.','on'),
(230,'woocommerce_price_num_decimals','2','on'),
(231,'woocommerce_shop_page_id','7','on'),
(232,'woocommerce_cart_redirect_after_add','no','on'),
(233,'woocommerce_enable_ajax_add_to_cart','yes','on'),
(234,'woocommerce_placeholder_image','6','on'),
(235,'woocommerce_weight_unit','lbs','on'),
(236,'woocommerce_dimension_unit','in','on'),
(237,'woocommerce_enable_reviews','yes','on'),
(238,'woocommerce_review_rating_verification_label','yes','off'),
(239,'woocommerce_review_rating_verification_required','no','off'),
(240,'woocommerce_enable_review_rating','yes','on'),
(241,'woocommerce_review_rating_required','yes','off'),
(242,'woocommerce_manage_stock','yes','on'),
(243,'woocommerce_hold_stock_minutes','60','off'),
(244,'woocommerce_notify_low_stock','yes','off'),
(245,'woocommerce_notify_no_stock','yes','off'),
(246,'woocommerce_notify_backorder','yes','off'),
(247,'woocommerce_stock_email_recipient','admin@gmail.com','off'),
(248,'woocommerce_notify_low_stock_amount','2','off'),
(249,'woocommerce_notify_no_stock_amount','0','on'),
(250,'woocommerce_hide_out_of_stock_items','no','on'),
(251,'woocommerce_stock_format','','on'),
(252,'woocommerce_file_download_method','force','off'),
(253,'woocommerce_downloads_redirect_fallback_allowed','no','off'),
(254,'woocommerce_downloads_require_login','no','off'),
(255,'woocommerce_downloads_grant_access_after_payment','yes','off'),
(256,'woocommerce_downloads_deliver_inline','','off'),
(257,'woocommerce_downloads_add_hash_to_filename','yes','on'),
(258,'woocommerce_downloads_count_partial','yes','on'),
(260,'woocommerce_attribute_lookup_direct_updates','no','on'),
(261,'woocommerce_attribute_lookup_optimized_updates','no','on'),
(262,'woocommerce_product_match_featured_image_by_sku','no','on'),
(263,'woocommerce_prices_include_tax','no','on'),
(264,'woocommerce_tax_based_on','shipping','on'),
(265,'woocommerce_shipping_tax_class','inherit','on'),
(266,'woocommerce_tax_round_at_subtotal','no','on'),
(267,'woocommerce_tax_classes','','on'),
(268,'woocommerce_tax_display_shop','excl','on'),
(269,'woocommerce_tax_display_cart','excl','on'),
(270,'woocommerce_price_display_suffix','','on'),
(271,'woocommerce_tax_total_display','itemized','off'),
(272,'woocommerce_enable_shipping_calc','yes','off'),
(273,'woocommerce_shipping_cost_requires_address','no','on'),
(274,'woocommerce_shipping_hide_rates_when_free','no','off'),
(275,'woocommerce_ship_to_destination','billing','off'),
(276,'woocommerce_shipping_debug_mode','no','on'),
(277,'woocommerce_enable_guest_checkout','yes','off'),
(278,'woocommerce_enable_checkout_login_reminder','no','off'),
(279,'woocommerce_enable_delayed_account_creation','no','off'),
(280,'woocommerce_enable_signup_and_login_from_checkout','no','off'),
(281,'woocommerce_enable_myaccount_registration','no','off'),
(282,'woocommerce_registration_generate_password','yes','off'),
(283,'woocommerce_registration_generate_username','yes','off'),
(284,'woocommerce_erasure_request_removes_order_data','no','off'),
(285,'woocommerce_erasure_request_removes_download_data','no','off'),
(286,'woocommerce_allow_bulk_remove_personal_data','no','off'),
(287,'woocommerce_registration_privacy_policy_text','Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our [privacy_policy].','on'),
(288,'woocommerce_checkout_privacy_policy_text','Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our [privacy_policy].','on'),
(289,'woocommerce_delete_inactive_accounts','a:2:{s:6:\"number\";s:0:\"\";s:4:\"unit\";s:6:\"months\";}','off'),
(290,'woocommerce_trash_pending_orders','','off'),
(291,'woocommerce_trash_failed_orders','','off'),
(292,'woocommerce_trash_cancelled_orders','','off'),
(293,'woocommerce_anonymize_refunded_orders','a:2:{s:6:\"number\";s:0:\"\";s:4:\"unit\";s:6:\"months\";}','off'),
(294,'woocommerce_anonymize_completed_orders','a:2:{s:6:\"number\";s:0:\"\";s:4:\"unit\";s:6:\"months\";}','off'),
(295,'woocommerce_email_from_address','admin@gmail.com','off'),
(296,'woocommerce_email_reply_to_enabled','no','off'),
(297,'woocommerce_email_reply_to_name','','off'),
(298,'woocommerce_email_reply_to_address','','off'),
(299,'woocommerce_email_header_image','','off'),
(300,'woocommerce_email_header_image_width','120','on'),
(301,'woocommerce_email_header_alignment','left','on'),
(302,'woocommerce_email_font_family','Helvetica','on'),
(303,'woocommerce_email_footer_text','{site_title}<br />{store_address}','off'),
(304,'woocommerce_email_base_color','#663A1E','off'),
(305,'woocommerce_email_background_color','#f0ebe4','off'),
(306,'woocommerce_email_body_background_color','#f0ebe4','off'),
(307,'woocommerce_email_text_color','#6B7280','off'),
(308,'woocommerce_email_footer_text_color','#6B7280','off'),
(309,'woocommerce_email_auto_sync_with_theme','yes','off'),
(310,'woocommerce_pos_store_address','','on'),
(311,'woocommerce_pos_store_phone','','on'),
(312,'woocommerce_pos_store_email','admin@gmail.com','on'),
(313,'woocommerce_pos_refund_returns_policy','','on'),
(314,'woocommerce_cart_page_id','8','off'),
(315,'woocommerce_checkout_page_id','9','off'),
(316,'woocommerce_myaccount_page_id','10','off'),
(317,'woocommerce_terms_page_id','','off'),
(318,'woocommerce_force_ssl_checkout','no','on'),
(319,'woocommerce_unforce_ssl_checkout','no','on'),
(320,'woocommerce_checkout_pay_endpoint','order-pay','on'),
(321,'woocommerce_checkout_order_received_endpoint','order-received','on'),
(322,'woocommerce_myaccount_add_payment_method_endpoint','add-payment-method','on'),
(323,'woocommerce_myaccount_delete_payment_method_endpoint','delete-payment-method','on'),
(324,'woocommerce_myaccount_set_default_payment_method_endpoint','set-default-payment-method','on'),
(325,'woocommerce_myaccount_orders_endpoint','orders','on'),
(326,'woocommerce_myaccount_view_order_endpoint','view-order','on'),
(327,'woocommerce_myaccount_downloads_endpoint','downloads','on'),
(328,'woocommerce_myaccount_edit_account_endpoint','edit-account','on'),
(329,'woocommerce_myaccount_edit_address_endpoint','edit-address','on'),
(330,'woocommerce_myaccount_payment_methods_endpoint','payment-methods','on'),
(331,'woocommerce_myaccount_lost_password_endpoint','lost-password','on'),
(332,'woocommerce_logout_endpoint','customer-logout','on'),
(333,'woocommerce_allow_tracking','yes','on'),
(334,'woocommerce_show_marketplace_suggestions','yes','off'),
(335,'woocommerce_custom_orders_table_enabled','yes','on'),
(336,'woocommerce_analytics_enabled','yes','on'),
(337,'woocommerce_feature_rate_limit_checkout_enabled','no','on'),
(338,'woocommerce_feature_order_withdrawal_enabled','no','on'),
(339,'woocommerce_queue_flush_rewrite_rules','no','auto'),
(340,'woocommerce_feature_order_attribution_enabled','yes','on'),
(341,'woocommerce_hpos_datastore_caching_enabled','no','on'),
(342,'woocommerce_feature_remote_logging_enabled','yes','on'),
(343,'woocommerce_feature_deferred_transactional_emails_enabled','no','on'),
(344,'woocommerce_feature_customer_review_request_enabled','no','on'),
(345,'woocommerce_feature_email_improvements_enabled','yes','on'),
(348,'woocommerce_email_improvements_disabled_count','1','auto'),
(349,'woocommerce_email_improvements_first_disabled_at','2026-10-07 02:51:50','auto'),
(350,'woocommerce_email_improvements_last_disabled_at','2026-10-07 02:51:50','auto'),
(351,'woocommerce_feature_blueprint_enabled','yes','on'),
(352,'woocommerce_feature_cost_of_goods_sold_enabled','no','on'),
(353,'woocommerce_feature_product_gallery_videos_enabled','no','on'),
(354,'woocommerce_hpos_fts_index_enabled','no','on'),
(355,'woocommerce_feature_abandoned_cart_recovery_enabled','no','on'),
(356,'woocommerce_feature_block_email_editor_enabled','no','on'),
(357,'woocommerce_feature_wc_visual_attribute_enabled','no','on'),
(358,'woocommerce_feature_mcp_integration_enabled','no','on'),
(359,'woocommerce_feature_destroy-empty-sessions_enabled','no','on'),
(360,'woocommerce_feature_rest_api_caching_enabled','no','on'),
(361,'woocommerce_cart_save_for_later_enabled','no','on'),
(362,'woocommerce_product_wishlist_enabled','no','on'),
(363,'woocommerce_feature_product_instance_caching_enabled','yes','on'),
(364,'woocommerce_feature_block_editor_unified_assets_enabled','no','on'),
(365,'woocommerce_single_image_width','600','on'),
(366,'woocommerce_thumbnail_image_width','300','on'),
(367,'woocommerce_checkout_highlight_required_fields','yes','on'),
(368,'woocommerce_demo_store','no','off'),
(369,'wc_downloads_approved_directories_mode','enabled','auto'),
(370,'woocommerce_permalinks','a:5:{s:12:\"product_base\";s:7:\"product\";s:13:\"category_base\";s:16:\"product-category\";s:8:\"tag_base\";s:11:\"product-tag\";s:14:\"attribute_base\";s:0:\"\";s:22:\"use_verbose_page_rules\";b:0;}','auto'),
(371,'current_theme_supports_woocommerce','yes','auto'),
(372,'product_cat_children','a:0:{}','auto'),
(373,'default_product_cat','15','auto'),
(374,'rank_math_indexnow_log','a:4:{i:0;a:5:{s:3:\"url\";s:32:\"http://localhost:8000/?page_id=7\";s:6:\"status\";i:429;s:17:\"manual_submission\";b:0;s:7:\"message\";s:17:\"Too Many Requests\";s:4:\"time\";i:1791341513;}i:1;a:5:{s:3:\"url\";s:32:\"http://localhost:8000/?page_id=8\";s:6:\"status\";i:429;s:17:\"manual_submission\";b:0;s:7:\"message\";s:17:\"Too Many Requests\";s:4:\"time\";i:1791341514;}i:2;a:5:{s:3:\"url\";s:32:\"http://localhost:8000/?page_id=9\";s:6:\"status\";i:429;s:17:\"manual_submission\";b:0;s:7:\"message\";s:17:\"Too Many Requests\";s:4:\"time\";i:1791341514;}i:3;a:5:{s:3:\"url\";s:33:\"http://localhost:8000/?page_id=10\";s:6:\"status\";i:429;s:17:\"manual_submission\";b:0;s:7:\"message\";s:17:\"Too Many Requests\";s:4:\"time\";i:1791341515;}}','off'),
(375,'woocommerce_refund_returns_page_id','11','auto'),
(378,'woocommerce_paypal_settings','a:25:{s:7:\"enabled\";s:2:\"no\";s:5:\"title\";s:6:\"PayPal\";s:11:\"description\";s:85:\"Pay via PayPal; you can pay with your credit card if you don\'t have a PayPal account.\";s:5:\"email\";s:15:\"admin@gmail.com\";s:8:\"advanced\";s:0:\"\";s:8:\"testmode\";s:2:\"no\";s:13:\"paymentaction\";s:4:\"sale\";s:14:\"paypal_buttons\";s:3:\"yes\";s:14:\"invoice_prefix\";s:3:\"WC-\";s:13:\"send_shipping\";s:3:\"yes\";s:16:\"address_override\";s:2:\"no\";s:5:\"debug\";s:2:\"no\";s:9:\"image_url\";s:0:\"\";s:16:\"ipn_notification\";s:3:\"yes\";s:14:\"receiver_email\";s:15:\"admin@gmail.com\";s:14:\"identity_token\";s:0:\"\";s:11:\"api_details\";s:0:\"\";s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:20:\"sandbox_api_username\";s:0:\"\";s:20:\"sandbox_api_password\";s:0:\"\";s:21:\"sandbox_api_signature\";s:0:\"\";s:28:\"transact_onboarding_complete\";s:2:\"no\";s:12:\"_should_load\";s:2:\"no\";}','on'),
(379,'woocommerce_version','11.1.2','auto'),
(380,'woocommerce_db_version','11.1.2','auto'),
(381,'woocommerce_store_id','dd72ab33-52c8-4fa6-91bb-0072102756b9','auto'),
(382,'woocommerce_admin_install_timestamp','1791341515','auto'),
(383,'woocommerce_inbox_variant_assignment','4','auto'),
(384,'woocommerce_remote_variant_assignment','87','auto'),
(385,'woocommerce_attribute_lookup_enabled','no','auto'),
(387,'rank_math_sitemap_cache_files','a:0:{}','auto'),
(388,'_transient_jetpack_autoloader_plugin_paths','a:1:{i:0;s:29:\"{{WP_PLUGIN_DIR}}/woocommerce\";}','on'),
(389,'woocommerce_admin_notices','a:0:{}','auto'),
(390,'_transient_wc_attribute_taxonomies','a:0:{}','on'),
(391,'woocommerce_maxmind_geolocation_settings','a:1:{s:15:\"database_prefix\";s:32:\"Djnzg4RW9Qe1ca8bgPPMztJvakrQknJt\";}','on'),
(392,'_transient_woocommerce_webhook_ids_status_active','a:0:{}','on'),
(393,'widget_woocommerce_widget_cart','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(394,'widget_woocommerce_layered_nav_filters','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(395,'widget_woocommerce_layered_nav','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(396,'widget_woocommerce_price_filter','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(397,'widget_woocommerce_product_categories','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(398,'widget_woocommerce_product_search','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(399,'widget_woocommerce_product_tag_cloud','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(400,'widget_woocommerce_products','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(401,'widget_woocommerce_recently_viewed_products','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(402,'widget_woocommerce_top_rated_products','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(403,'widget_woocommerce_recent_reviews','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(404,'widget_woocommerce_rating_filter','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(405,'widget_wc_brands_brand_description','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(406,'widget_woocommerce_brand_nav','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(407,'widget_wc_brands_brand_thumbnails','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(410,'_transient_woocommerce_product_task_has_product_transient','no','on'),
(411,'_site_transient_timeout_woocommerce_blocks_patterns','1793933524','off'),
(412,'_site_transient_woocommerce_blocks_patterns','a:2:{s:7:\"version\";s:6:\"11.1.2\";s:8:\"patterns\";a:41:{i:0;a:10:{s:5:\"title\";s:6:\"Banner\";s:4:\"slug\";s:25:\"woocommerce-blocks/banner\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:29:\"WooCommerce, featured-selling\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:10:\"banner.php\";}i:1;a:10:{s:5:\"title\";s:23:\"Coming Soon Entire Site\";s:4:\"slug\";s:35:\"woocommerce/coming-soon-entire-site\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:5:\"false\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:27:\"coming-soon-entire-site.php\";}i:2;a:10:{s:5:\"title\";s:22:\"Coming Soon Store Only\";s:4:\"slug\";s:34:\"woocommerce/coming-soon-store-only\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:5:\"false\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:26:\"coming-soon-store-only.php\";}i:3;a:10:{s:5:\"title\";s:11:\"Coming Soon\";s:4:\"slug\";s:23:\"woocommerce/coming-soon\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:5:\"false\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:15:\"coming-soon.php\";}i:4;a:10:{s:5:\"title\";s:29:\"Content Right with Image Left\";s:4:\"slug\";s:48:\"woocommerce-blocks/content-right-with-image-left\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:18:\"WooCommerce, About\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:28:\"content-right-image-left.php\";}i:5;a:10:{s:5:\"title\";s:29:\"Featured Category Cover Image\";s:4:\"slug\";s:48:\"woocommerce-blocks/featured-category-cover-image\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:18:\"WooCommerce, Intro\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:33:\"featured-category-cover-image.php\";}i:6;a:10:{s:5:\"title\";s:24:\"Featured Category Triple\";s:4:\"slug\";s:43:\"woocommerce-blocks/featured-category-triple\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:29:\"WooCommerce, featured-selling\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:28:\"featured-category-triple.php\";}i:7;a:10:{s:5:\"title\";s:12:\"Large Footer\";s:4:\"slug\";s:31:\"woocommerce-blocks/footer-large\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:25:\"core/template-part/footer\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:16:\"footer-large.php\";}i:8;a:10:{s:5:\"title\";s:23:\"Footer with Simple Menu\";s:4:\"slug\";s:37:\"woocommerce-blocks/footer-simple-menu\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:25:\"core/template-part/footer\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:22:\"footer-simple-menu.php\";}i:9;a:10:{s:5:\"title\";s:19:\"Footer with 3 Menus\";s:4:\"slug\";s:38:\"woocommerce-blocks/footer-with-3-menus\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:25:\"core/template-part/footer\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:23:\"footer-with-3-menus.php\";}i:10;a:10:{s:5:\"title\";s:28:\"Four Image Grid Content Left\";s:4:\"slug\";s:47:\"woocommerce-blocks/four-image-grid-content-left\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:18:\"WooCommerce, About\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:32:\"four-image-grid-content-left.php\";}i:11;a:10:{s:5:\"title\";s:20:\"Centered Header Menu\";s:4:\"slug\";s:39:\"woocommerce-blocks/header-centered-menu\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:25:\"core/template-part/header\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:27:\"header-centered-pattern.php\";}i:12;a:10:{s:5:\"title\";s:23:\"Distraction Free Header\";s:4:\"slug\";s:42:\"woocommerce-blocks/header-distraction-free\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:25:\"core/template-part/header\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:27:\"header-distraction-free.php\";}i:13;a:10:{s:5:\"title\";s:16:\"Essential Header\";s:4:\"slug\";s:35:\"woocommerce-blocks/header-essential\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:25:\"core/template-part/header\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:20:\"header-essential.php\";}i:14;a:10:{s:5:\"title\";s:12:\"Large Header\";s:4:\"slug\";s:31:\"woocommerce-blocks/header-large\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:25:\"core/template-part/header\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:16:\"header-large.php\";}i:15;a:10:{s:5:\"title\";s:14:\"Minimal Header\";s:4:\"slug\";s:33:\"woocommerce-blocks/header-minimal\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:25:\"core/template-part/header\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:18:\"header-minimal.php\";}i:16;a:10:{s:5:\"title\";s:46:\"Heading with Three Columns of Content and Link\";s:4:\"slug\";s:66:\"woocommerce-blocks/heading-with-three-columns-of-content-with-link\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:21:\"WooCommerce, Services\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:51:\"heading-with-three-columns-of-content-with-link.php\";}i:17;a:10:{s:5:\"title\";s:20:\"Hero Product 3 Split\";s:4:\"slug\";s:39:\"woocommerce-blocks/hero-product-3-split\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:29:\"WooCommerce, featured-selling\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:24:\"hero-product-3-split.php\";}i:18;a:10:{s:5:\"title\";s:23:\"Hero Product Chessboard\";s:4:\"slug\";s:42:\"woocommerce-blocks/hero-product-chessboard\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:29:\"WooCommerce, featured-selling\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:27:\"hero-product-chessboard.php\";}i:19;a:10:{s:5:\"title\";s:18:\"Hero Product Split\";s:4:\"slug\";s:37:\"woocommerce-blocks/hero-product-split\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:18:\"WooCommerce, Intro\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:22:\"hero-product-split.php\";}i:20;a:10:{s:5:\"title\";s:33:\"Centered Content with Image Below\";s:4:\"slug\";s:52:\"woocommerce-blocks/centered-content-with-image-below\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:18:\"WooCommerce, Intro\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:43:\"intro-centered-content-with-image-below.php\";}i:21;a:10:{s:5:\"title\";s:22:\"Just Arrived Full Hero\";s:4:\"slug\";s:41:\"woocommerce-blocks/just-arrived-full-hero\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:18:\"WooCommerce, Intro\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:26:\"just-arrived-full-hero.php\";}i:22;a:10:{s:5:\"title\";s:33:\"No Products Found - Clear Filters\";s:4:\"slug\";s:43:\"woocommerce/no-products-found-clear-filters\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:2:\"no\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:29:\"no-products-found-filters.php\";}i:23;a:10:{s:5:\"title\";s:17:\"No Products Found\";s:4:\"slug\";s:29:\"woocommerce/no-products-found\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:2:\"no\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:21:\"no-products-found.php\";}i:24;a:10:{s:5:\"title\";s:19:\"Default Coming Soon\";s:4:\"slug\";s:36:\"woocommerce/page-coming-soon-default\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:5:\"false\";s:13:\"templateTypes\";s:11:\"coming-soon\";s:6:\"source\";s:28:\"page-coming-soon-default.php\";}i:25;a:10:{s:5:\"title\";s:25:\"Coming Soon Image Gallery\";s:4:\"slug\";s:42:\"woocommerce/page-coming-soon-image-gallery\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:5:\"false\";s:13:\"templateTypes\";s:11:\"coming-soon\";s:6:\"source\";s:34:\"page-coming-soon-image-gallery.php\";}i:26;a:10:{s:5:\"title\";s:30:\"Coming Soon Minimal Left Image\";s:4:\"slug\";s:47:\"woocommerce/page-coming-soon-minimal-left-image\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:5:\"false\";s:13:\"templateTypes\";s:11:\"coming-soon\";s:6:\"source\";s:39:\"page-coming-soon-minimal-left-image.php\";}i:27;a:10:{s:5:\"title\";s:24:\"Coming Soon Modern Black\";s:4:\"slug\";s:41:\"woocommerce/page-coming-soon-modern-black\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:5:\"false\";s:13:\"templateTypes\";s:11:\"coming-soon\";s:6:\"source\";s:33:\"page-coming-soon-modern-black.php\";}i:28;a:10:{s:5:\"title\";s:29:\"Coming Soon Split Right Image\";s:4:\"slug\";s:46:\"woocommerce/page-coming-soon-split-right-image\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:5:\"false\";s:13:\"templateTypes\";s:11:\"coming-soon\";s:6:\"source\";s:38:\"page-coming-soon-split-right-image.php\";}i:29;a:10:{s:5:\"title\";s:34:\"Coming Soon with Header and Footer\";s:4:\"slug\";s:47:\"woocommerce/page-coming-soon-with-header-footer\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:5:\"false\";s:13:\"templateTypes\";s:11:\"coming-soon\";s:6:\"source\";s:39:\"page-coming-soon-with-header-footer.php\";}i:30;a:10:{s:5:\"title\";s:28:\"Product Collection 3 Columns\";s:4:\"slug\";s:47:\"woocommerce-blocks/product-collection-3-columns\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:32:\"product-collection-3-columns.php\";}i:31;a:10:{s:5:\"title\";s:28:\"Product Collection 4 Columns\";s:4:\"slug\";s:47:\"woocommerce-blocks/product-collection-4-columns\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:29:\"WooCommerce, featured-selling\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:32:\"product-collection-4-columns.php\";}i:32;a:10:{s:5:\"title\";s:28:\"Product Collection 5 Columns\";s:4:\"slug\";s:47:\"woocommerce-blocks/product-collection-5-columns\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:29:\"WooCommerce, featured-selling\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:32:\"product-collection-5-columns.php\";}i:33;a:10:{s:5:\"title\";s:47:\"Product Collection: Featured Products 5 Columns\";s:4:\"slug\";s:65:\"woocommerce-blocks/product-collection-featured-products-5-columns\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:29:\"WooCommerce, featured-selling\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:50:\"product-collection-featured-products-5-columns.php\";}i:34;a:10:{s:5:\"title\";s:15:\"Product Gallery\";s:4:\"slug\";s:48:\"woocommerce-blocks/product-query-product-gallery\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:29:\"WooCommerce, featured-selling\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:36:\"core/query/woocommerce/product-query\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:33:\"product-query-product-gallery.php\";}i:35;a:10:{s:5:\"title\";s:14:\"Product Search\";s:4:\"slug\";s:31:\"woocommerce/product-search-form\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:2:\"no\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:23:\"product-search-form.php\";}i:36;a:10:{s:5:\"title\";s:16:\"Related Products\";s:4:\"slug\";s:35:\"woocommerce-blocks/related-products\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:11:\"WooCommerce\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:5:\"false\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:20:\"related-products.php\";}i:37;a:10:{s:5:\"title\";s:33:\"Social: Follow Us on Social Media\";s:4:\"slug\";s:51:\"woocommerce-blocks/social-follow-us-in-social-media\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:25:\"WooCommerce, social-media\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:36:\"social-follow-us-in-social-media.php\";}i:38;a:10:{s:5:\"title\";s:22:\"Testimonials 3 Columns\";s:4:\"slug\";s:41:\"woocommerce-blocks/testimonials-3-columns\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:20:\"WooCommerce, Reviews\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:26:\"testimonials-3-columns.php\";}i:39;a:10:{s:5:\"title\";s:18:\"Testimonial Single\";s:4:\"slug\";s:38:\"woocommerce-blocks/testimonials-single\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:20:\"WooCommerce, Reviews\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:23:\"testimonials-single.php\";}i:40;a:10:{s:5:\"title\";s:37:\"Three Columns with Images and Content\";s:4:\"slug\";s:56:\"woocommerce-blocks/three-columns-with-images-and-content\";s:11:\"description\";s:0:\"\";s:13:\"viewportWidth\";s:0:\"\";s:10:\"categories\";s:21:\"WooCommerce, Services\";s:8:\"keywords\";s:0:\"\";s:10:\"blockTypes\";s:0:\"\";s:8:\"inserter\";s:0:\"\";s:13:\"templateTypes\";s:0:\"\";s:6:\"source\";s:41:\"three-columns-with-images-and-content.php\";}}}','off'),
(415,'woocommerce_admin_pes_incentive_woopayments_store_had_woopayments','no','auto'),
(416,'woocommerce_admin_pes_incentive_woopayments_store_had_woopayments_version','2','auto'),
(417,'woocommerce_hooked_blocks_version','11.1.2','auto'),
(418,'woocommerce_custom_orders_table_created','yes','auto'),
(419,'woocommerce_coming_soon','yes','auto'),
(420,'woocommerce_store_pages_only','yes','auto'),
(421,'woocommerce_email_improvements_default_enabled','yes','auto'),
(424,'woocommerce_email_improvements_first_enabled_at','2026-10-07 02:52:11','auto'),
(425,'woocommerce_email_improvements_last_enabled_at','2026-10-07 02:52:11','auto'),
(426,'woocommerce_email_improvements_enabled_count','1','auto'),
(427,'woocommerce_back_in_stock_allow_signups','yes','auto'),
(428,'woocommerce_analytics_scheduled_import','yes','auto'),
(429,'woocommerce_admin_scheduler_last_processed_order_modified_date','2026-10-07 03:28:01','off'),
(430,'woocommerce_admin_scheduler_last_processed_order_id','0','off'),
(431,'woocommerce_initial_installed_version','11.1.2','off'),
(432,'woocommerce_gateway_order','a:6:{s:19:\"_wc_pes_woopayments\";i:0;s:25:\"_wc_pes_paypal_full_stack\";i:1;s:33:\"_wc_offline_payment_methods_group\";i:2;s:4:\"bacs\";i:3;s:6:\"cheque\";i:4;s:3:\"cod\";i:5;}','auto'),
(437,'wc_blocks_db_schema_version','260','auto'),
(438,'wc_remote_inbox_notifications_stored_state','O:8:\"stdClass\":2:{s:22:\"there_were_no_products\";b:1;s:22:\"there_are_now_products\";b:0;}','off'),
(439,'_transient_timeout_woocommerce_blocks_asset_api_script_data','1794110624','off'),
(440,'_transient_woocommerce_blocks_asset_api_script_data','{\"script_data\":{\"assets\\/client\\/blocks\\/wc-settings.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-settings.js\",\"version\":\"5cdaba16c87338181b77\",\"dependencies\":[\"wc-types\",\"wp-hooks\",\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/wc-types.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-types.js\",\"version\":\"c4b7280ca0810ce973be\",\"dependencies\":[\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/wc-entities.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-entities.js\",\"version\":\"bcb2165cc1d82aabfed2\",\"dependencies\":[\"wc-settings\",\"wp-core-data\",\"wp-data\",\"wp-deprecated\",\"wp-i18n\",\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/wc-blocks-middleware.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-blocks-middleware.js\",\"version\":\"2c049fe250c153b7cac8\",\"dependencies\":[\"wp-api-fetch\",\"wp-polyfill\",\"wp-url\"]},\"assets\\/client\\/blocks\\/wc-blocks-data.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-blocks-data.js\",\"version\":\"afe6cbed0b2d6966962a\",\"dependencies\":[\"wc-blocks-checkout-events\",\"wc-blocks-registry\",\"wc-settings\",\"wc-types\",\"wp-api-fetch\",\"wp-data\",\"wp-data-controls\",\"wp-deprecated\",\"wp-dom\",\"wp-element\",\"wp-hooks\",\"wp-html-entities\",\"wp-i18n\",\"wp-is-shallow-equal\",\"wp-notices\",\"wp-polyfill\",\"wp-url\"]},\"assets\\/client\\/blocks\\/wc-blocks-registry.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-blocks-registry.js\",\"version\":\"8cf98119f62dbfe139c2\",\"dependencies\":[\"react-jsx-runtime\",\"wc-settings\",\"wp-data\",\"wp-deprecated\",\"wp-element\",\"wp-hooks\",\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/wc-blocks-shared-context.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-blocks-shared-context.js\",\"version\":\"621353d8a3a7c8d44b41\",\"dependencies\":[\"react-jsx-runtime\",\"wp-element\",\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/wc-blocks-shared-hocs.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-blocks-shared-hocs.js\",\"version\":\"781196b1e16b60e862cb\",\"dependencies\":[\"react-jsx-runtime\",\"wc-blocks-data-store\",\"wc-blocks-shared-context\",\"wc-types\",\"wp-data\",\"wp-element\",\"wp-i18n\",\"wp-is-shallow-equal\",\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/blocks-components.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/blocks-components.js\",\"version\":\"024deac35759b91da09e\",\"dependencies\":[\"wc-cart-checkout-base\",\"wc-cart-checkout-vendors\",\"react\",\"react-dom\",\"react-jsx-runtime\",\"wc-blocks-data-store\",\"wc-sanitize\",\"wc-settings\",\"wc-types\",\"wp-a11y\",\"wp-compose\",\"wp-data\",\"wp-deprecated\",\"wp-element\",\"wp-html-entities\",\"wp-i18n\",\"wp-notices\",\"wp-polyfill\",\"wp-primitives\"]},\"assets\\/client\\/blocks\\/wc-blocks-vendors.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-blocks-vendors.js\",\"version\":\"4d03e7985472169505ea\",\"dependencies\":[\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/wc-blocks.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-blocks.js\",\"version\":\"96be36fcbe4ca4aab4d9\",\"dependencies\":[\"react-jsx-runtime\",\"wp-blocks\",\"wp-compose\",\"wp-dom-ready\",\"wp-element\",\"wp-hooks\",\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/price-format.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/price-format.js\",\"version\":\"0df720e448f7ab3c5d0d\",\"dependencies\":[\"wc-settings\",\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/wc-blocks-frontend-vendors-frontend.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-blocks-frontend-vendors-frontend.js\",\"version\":\"680d02d748b4d3807a03\",\"dependencies\":[\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/wc-cart-checkout-vendors-frontend.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-cart-checkout-vendors-frontend.js\",\"version\":\"d075c6ab8086318714ff\",\"dependencies\":[\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/wc-cart-checkout-base-frontend.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-cart-checkout-base-frontend.js\",\"version\":\"fb0069b802d50bd5bf47\",\"dependencies\":[\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/blocks-checkout.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/blocks-checkout.js\",\"version\":\"1082650d449aab026b31\",\"dependencies\":[\"wc-cart-checkout-base\",\"wc-cart-checkout-vendors\",\"react\",\"react-dom\",\"react-jsx-runtime\",\"wc-blocks-checkout-events\",\"wc-blocks-components\",\"wc-blocks-data-store\",\"wc-blocks-registry\",\"wc-sanitize\",\"wc-settings\",\"wc-types\",\"wp-a11y\",\"wp-compose\",\"wp-data\",\"wp-deprecated\",\"wp-element\",\"wp-html-entities\",\"wp-i18n\",\"wp-is-shallow-equal\",\"wp-notices\",\"wp-polyfill\",\"wp-primitives\",\"wp-warning\"]},\"assets\\/client\\/blocks\\/blocks-checkout-events.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/blocks-checkout-events.js\",\"version\":\"1cd9ffa6e3cff96ad1b2\",\"dependencies\":[\"wc-types\",\"wp-polyfill\"]},\"assets\\/client\\/blocks\\/wc-schema-parser.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/blocks\\/wc-schema-parser.js\",\"version\":\"63baa6fbe2326b07d735\",\"dependencies\":[\"wp-polyfill\"]},\"assets\\/client\\/admin\\/sanitize\\/index.js\":{\"src\":\"http:\\/\\/localhost:8000\\/wp-content\\/plugins\\/woocommerce\\/assets\\/client\\/admin\\/sanitize\\/index.js\",\"version\":\"6cc3684099bd6a5547b8\",\"dependencies\":[]}},\"version\":\"wc-11.1.2\",\"hash\":\"dce27d294ea66d4d062bf6ce27340560\"}','off'),
(445,'woocommerce_checkout_phone_field','optional','auto'),
(447,'woocommerce_checkout_company_field','hidden','auto'),
(448,'woocommerce_checkout_address_2_field','optional','auto'),
(454,'_transient_timeout_woocommerce_admin_remote_free_extensions_specs','1791946358','off'),
(455,'_transient_woocommerce_admin_remote_free_extensions_specs','a:1:{s:5:\"en_US\";a:5:{s:10:\"obw/basics\";O:8:\"stdClass\":3:{s:3:\"key\";s:10:\"obw/basics\";s:5:\"title\";s:14:\"Get the basics\";s:7:\"plugins\";a:4:{i:0;O:8:\"stdClass\":6:{s:4:\"name\";s:11:\"WooPayments\";s:11:\"description\";s:154:\"Accept credit cards and other popular payment methods with <a href=\"https://woocommerce.com/products/woocommerce-payments\" target=\"_blank\">WooPayments</a>\";s:10:\"is_visible\";a:2:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:39:{i:0;s:2:\"US\";i:1;s:2:\"PR\";i:2;s:2:\"AU\";i:3;s:2:\"CA\";i:4;s:2:\"DE\";i:5;s:2:\"ES\";i:6;s:2:\"FR\";i:7;s:2:\"GB\";i:8;s:2:\"IE\";i:9;s:2:\"IT\";i:10;s:2:\"NZ\";i:11;s:2:\"AT\";i:12;s:2:\"BE\";i:13;s:2:\"NL\";i:14;s:2:\"PL\";i:15;s:2:\"PT\";i:16;s:2:\"CH\";i:17;s:2:\"HK\";i:18;s:2:\"SG\";i:19;s:2:\"CY\";i:20;s:2:\"DK\";i:21;s:2:\"EE\";i:22;s:2:\"FI\";i:23;s:2:\"GR\";i:24;s:2:\"LU\";i:25;s:2:\"LT\";i:26;s:2:\"LV\";i:27;s:2:\"NO\";i:28;s:2:\"MT\";i:29;s:2:\"SI\";i:30;s:2:\"SK\";i:31;s:2:\"BG\";i:32;s:2:\"CZ\";i:33;s:2:\"HR\";i:34;s:2:\"HU\";i:35;s:2:\"RO\";i:36;s:2:\"SE\";i:37;s:2:\"JP\";i:38;s:2:\"AE\";}s:9:\"operation\";s:2:\"in\";}i:1;O:8:\"stdClass\":6:{s:4:\"type\";s:6:\"option\";s:12:\"transformers\";a:2:{i:0;O:8:\"stdClass\":2:{s:3:\"use\";s:12:\"dot_notation\";s:9:\"arguments\";O:8:\"stdClass\":1:{s:4:\"path\";s:8:\"industry\";}}i:1;O:8:\"stdClass\":2:{s:3:\"use\";s:12:\"array_column\";s:9:\"arguments\";O:8:\"stdClass\":1:{s:3:\"key\";s:4:\"slug\";}}}s:11:\"option_name\";s:30:\"woocommerce_onboarding_profile\";s:9:\"operation\";s:9:\"!contains\";s:5:\"value\";s:31:\"cbd-other-hemp-derived-products\";s:7:\"default\";a:0:{}}}s:14:\"is_built_by_wc\";b:1;s:14:\"min_wp_version\";s:3:\"5.9\";s:3:\"key\";s:20:\"woocommerce-payments\";}i:1;O:8:\"stdClass\":5:{s:4:\"name\";s:20:\"WooCommerce Shipping\";s:11:\"description\";s:119:\"Print shipping labels with <a href=\"https://woocommerce.com/products/shipping\" target=\"_blank\">WooCommerce Shipping</a>\";s:10:\"is_visible\";a:3:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:1:{i:0;s:2:\"US\";}s:9:\"operation\";s:2:\"in\";}i:1;O:8:\"stdClass\":2:{s:4:\"type\";s:3:\"not\";s:7:\"operand\";a:1:{i:0;O:8:\"stdClass\":2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:20:\"woocommerce-shipping\";}}}}i:2;O:8:\"stdClass\":2:{s:4:\"type\";s:2:\"or\";s:8:\"operands\";a:2:{i:0;a:1:{i:0;O:8:\"stdClass\":6:{s:4:\"type\";s:6:\"option\";s:12:\"transformers\";a:2:{i:0;O:8:\"stdClass\":2:{s:3:\"use\";s:12:\"dot_notation\";s:9:\"arguments\";O:8:\"stdClass\":1:{s:4:\"path\";s:13:\"product_types\";}}i:1;O:8:\"stdClass\":1:{s:3:\"use\";s:5:\"count\";}}s:11:\"option_name\";s:30:\"woocommerce_onboarding_profile\";s:5:\"value\";i:1;s:7:\"default\";a:0:{}s:9:\"operation\";s:2:\"!=\";}}i:1;a:1:{i:0;O:8:\"stdClass\":6:{s:4:\"type\";s:6:\"option\";s:12:\"transformers\";a:1:{i:0;O:8:\"stdClass\":2:{s:3:\"use\";s:12:\"dot_notation\";s:9:\"arguments\";O:8:\"stdClass\":1:{s:4:\"path\";s:15:\"product_types.0\";}}}s:11:\"option_name\";s:30:\"woocommerce_onboarding_profile\";s:5:\"value\";s:9:\"downloads\";s:7:\"default\";s:0:\"\";s:9:\"operation\";s:2:\"!=\";}}}}}s:14:\"is_built_by_wc\";b:1;s:3:\"key\";s:20:\"woocommerce-shipping\";}i:2;O:8:\"stdClass\":5:{s:4:\"name\";s:15:\"WooCommerce Tax\";s:11:\"description\";s:111:\"Get automated sales tax with <a href=\"https://woocommerce.com/products/tax\" target=\"_blank\">WooCommerce Tax</a>\";s:10:\"is_visible\";a:2:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:11:{i:0;s:2:\"US\";i:1;s:2:\"FR\";i:2;s:2:\"GB\";i:3;s:2:\"DE\";i:4;s:2:\"CA\";i:5;s:2:\"AU\";i:6;s:2:\"GR\";i:7;s:2:\"BE\";i:8;s:2:\"PT\";i:9;s:2:\"DK\";i:10;s:2:\"SE\";}s:9:\"operation\";s:2:\"in\";}i:1;O:8:\"stdClass\":2:{s:4:\"type\";s:3:\"not\";s:7:\"operand\";a:1:{i:0;O:8:\"stdClass\":2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:20:\"woocommerce-services\";}}}}}s:14:\"is_built_by_wc\";b:1;s:3:\"key\";s:24:\"woocommerce-services:tax\";}i:3;O:8:\"stdClass\":6:{s:4:\"name\";s:7:\"Jetpack\";s:11:\"description\";s:110:\"Enhance speed and security with <a href=\"https://woocommerce.com/products/jetpack\" target=\"_blank\">Jetpack</a>\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":2:{s:4:\"type\";s:3:\"not\";s:7:\"operand\";a:1:{i:0;O:8:\"stdClass\":2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:7:\"jetpack\";}}}}}s:14:\"is_built_by_wc\";b:0;s:14:\"min_wp_version\";s:3:\"6.0\";s:3:\"key\";s:7:\"jetpack\";}}}s:8:\"obw/grow\";O:8:\"stdClass\":3:{s:3:\"key\";s:8:\"obw/grow\";s:5:\"title\";s:15:\"Grow your store\";s:7:\"plugins\";a:3:{i:0;O:8:\"stdClass\":6:{s:4:\"name\";s:8:\"MailPoet\";s:11:\"description\";s:115:\"Level up your email marketing with <a href=\"https://woocommerce.com/products/mailpoet\" target=\"_blank\">MailPoet</a>\";s:10:\"manage_url\";s:35:\"admin.php?page=mailpoet-newsletters\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":5:{s:4:\"type\";s:6:\"option\";s:11:\"option_name\";s:37:\"woocommerce_remote_variant_assignment\";s:5:\"value\";a:2:{i:0;i:1;i:1;i:84;}s:7:\"default\";b:0;s:9:\"operation\";s:5:\"range\";}}s:14:\"is_built_by_wc\";b:1;s:3:\"key\";s:8:\"mailpoet\";}i:1;O:8:\"stdClass\":8:{s:4:\"name\";s:22:\"Google for WooCommerce\";s:11:\"description\";s:126:\"Drive sales with <a href=\"https://woocommerce.com/products/google-listings-and-ads\" target=\"_blank\">Google for WooCommerce</a>\";s:9:\"image_url\";s:94:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/google.svg\";s:10:\"manage_url\";s:46:\"admin.php?page=wc-admin&path=%2Fgoogle%2Fstart\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":2:{s:4:\"type\";s:3:\"not\";s:7:\"operand\";a:1:{i:0;O:8:\"stdClass\":2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:23:\"google-listings-and-ads\";}}}}}s:14:\"is_built_by_wc\";b:1;s:15:\"min_php_version\";s:3:\"7.4\";s:3:\"key\";s:23:\"google-listings-and-ads\";}i:2;O:8:\"stdClass\":8:{s:4:\"name\";s:25:\"Pinterest for WooCommerce\";s:11:\"description\";s:76:\"Get your products in front of Pinners searching for ideas and things to buy.\";s:9:\"image_url\";s:97:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/pinterest.png\";s:10:\"manage_url\";s:51:\"admin.php?page=wc-admin&path=%2Fpinterest%2Flanding\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":5:{s:4:\"type\";s:6:\"option\";s:11:\"option_name\";s:37:\"woocommerce_remote_variant_assignment\";s:5:\"value\";a:2:{i:0;i:61;i:1;i:120;}s:7:\"default\";b:0;s:9:\"operation\";s:5:\"range\";}}s:14:\"is_built_by_wc\";b:1;s:15:\"min_php_version\";s:3:\"7.3\";s:3:\"key\";s:25:\"pinterest-for-woocommerce\";}}}s:15:\"task-list/reach\";O:8:\"stdClass\":3:{s:3:\"key\";s:15:\"task-list/reach\";s:5:\"title\";s:22:\"Reach out to customers\";s:7:\"plugins\";a:3:{i:0;O:8:\"stdClass\":6:{s:4:\"name\";s:8:\"MailPoet\";s:11:\"description\";s:111:\"Create and send purchase follow-up emails, newsletters, and promotional campaigns straight from your dashboard.\";s:9:\"image_url\";s:96:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/mailpoet.svg\";s:10:\"manage_url\";s:35:\"admin.php?page=mailpoet-newsletters\";s:14:\"is_built_by_wc\";b:1;s:3:\"key\";s:12:\"mailpoet:alt\";}i:1;O:8:\"stdClass\":6:{s:4:\"name\";s:7:\"Klaviyo\";s:11:\"description\";s:138:\"Grow and retain customers with intelligent, impactful email and SMS marketing automation and a consolidated view of customer interactions.\";s:9:\"image_url\";s:95:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/klaviyo.png\";s:10:\"manage_url\";s:31:\"admin.php?page=klaviyo_settings\";s:14:\"is_built_by_wc\";b:0;s:3:\"key\";s:11:\"klaviyo:alt\";}i:2;O:8:\"stdClass\":6:{s:4:\"name\";s:9:\"Mailchimp\";s:11:\"description\";s:78:\"Send targeted campaigns, recover abandoned carts and much more with Mailchimp.\";s:9:\"image_url\";s:97:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/mailchimp.svg\";s:10:\"manage_url\";s:36:\"admin.php?page=mailchimp-woocommerce\";s:14:\"is_built_by_wc\";b:0;s:3:\"key\";s:29:\"mailchimp-for-woocommerce:alt\";}}}s:14:\"task-list/grow\";O:8:\"stdClass\":3:{s:3:\"key\";s:14:\"task-list/grow\";s:5:\"title\";s:15:\"Grow your store\";s:7:\"plugins\";a:4:{i:0;O:8:\"stdClass\":6:{s:4:\"name\";s:22:\"Google for WooCommerce\";s:11:\"description\";s:134:\"Reach more shoppers and drive sales for your store. Integrate with Google to list your products for free and launch paid ad campaigns.\";s:9:\"image_url\";s:94:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/google.svg\";s:10:\"manage_url\";s:46:\"admin.php?page=wc-admin&path=%2Fgoogle%2Fstart\";s:14:\"is_built_by_wc\";b:1;s:3:\"key\";s:27:\"google-listings-and-ads:alt\";}i:1;O:8:\"stdClass\":7:{s:4:\"name\";s:22:\"TikTok for WooCommerce\";s:9:\"image_url\";s:94:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/tiktok.svg\";s:11:\"description\";s:118:\"Grow your online sales by promoting your products on TikTok to over one billion monthly active users around the world.\";s:10:\"manage_url\";s:21:\"admin.php?page=tiktok\";s:10:\"is_visible\";a:2:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:40:{i:0;s:2:\"US\";i:1;s:2:\"CA\";i:2;s:2:\"MX\";i:3;s:2:\"AT\";i:4;s:2:\"BE\";i:5;s:2:\"CZ\";i:6;s:2:\"DK\";i:7;s:2:\"FI\";i:8;s:2:\"FR\";i:9;s:2:\"DE\";i:10;s:2:\"GR\";i:11;s:2:\"HU\";i:12;s:2:\"IE\";i:13;s:2:\"IT\";i:14;s:2:\"NL\";i:15;s:2:\"PL\";i:16;s:2:\"PT\";i:17;s:2:\"RO\";i:18;s:2:\"ES\";i:19;s:2:\"SE\";i:20;s:2:\"GB\";i:21;s:2:\"CH\";i:22;s:2:\"NO\";i:23;s:2:\"AU\";i:24;s:2:\"NZ\";i:25;s:2:\"SG\";i:26;s:2:\"MY\";i:27;s:2:\"PH\";i:28;s:2:\"ID\";i:29;s:2:\"VN\";i:30;s:2:\"TH\";i:31;s:2:\"KR\";i:32;s:2:\"IL\";i:33;s:2:\"AE\";i:34;s:2:\"RU\";i:35;s:2:\"UA\";i:36;s:2:\"TR\";i:37;s:2:\"SA\";i:38;s:2:\"BR\";i:39;s:2:\"JP\";}s:9:\"operation\";s:2:\"in\";}i:1;O:8:\"stdClass\":5:{s:4:\"type\";s:6:\"option\";s:11:\"option_name\";s:37:\"woocommerce_remote_variant_assignment\";s:5:\"value\";a:2:{i:0;i:1;i:1;i:60;}s:7:\"default\";b:0;s:9:\"operation\";s:5:\"range\";}}s:14:\"is_built_by_wc\";b:0;s:3:\"key\";s:19:\"tiktok-for-business\";}i:2;O:8:\"stdClass\":7:{s:4:\"name\";s:25:\"Pinterest for WooCommerce\";s:11:\"description\";s:159:\"Get your products in front of Pinterest users searching for ideas and things to buy. Get started with Pinterest and make your entire product catalog browsable.\";s:9:\"image_url\";s:97:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/pinterest.png\";s:10:\"manage_url\";s:51:\"admin.php?page=wc-admin&path=%2Fpinterest%2Flanding\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":5:{s:4:\"type\";s:6:\"option\";s:11:\"option_name\";s:37:\"woocommerce_remote_variant_assignment\";s:5:\"value\";a:2:{i:0;i:61;i:1;i:120;}s:7:\"default\";b:0;s:9:\"operation\";s:5:\"range\";}}s:14:\"is_built_by_wc\";b:1;s:3:\"key\";s:29:\"pinterest-for-woocommerce:alt\";}i:3;O:8:\"stdClass\":8:{s:4:\"name\";s:26:\"Meta Ads & Pixel by Kliken\";s:11:\"description\";s:150:\"Automate Facebook & Instagram marketing with Kliken. Launch ads and schedule a month of posts in 5 minutes—first 5 free! Plans start at just $20/mo.\";s:9:\"image_url\";s:94:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/kliken.svg\";s:10:\"manage_url\";s:40:\"admin.php?page=kliken-ads-pixel-for-meta\";s:14:\"is_built_by_wc\";b:0;s:16:\"install_external\";b:0;s:10:\"is_visible\";b:1;s:3:\"key\";s:29:\"kliken-ads-pixel-for-meta:alt\";}}}s:17:\"obw/core-profiler\";O:8:\"stdClass\":3:{s:3:\"key\";s:17:\"obw/core-profiler\";s:5:\"title\";s:15:\"Grow your store\";s:7:\"plugins\";a:16:{i:0;O:8:\"stdClass\":11:{s:4:\"name\";s:11:\"WooPayments\";s:11:\"description\";s:54:\"Offer safe and convenient ways to pay with WooPayments\";s:10:\"is_visible\";a:2:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:39:{i:0;s:2:\"US\";i:1;s:2:\"PR\";i:2;s:2:\"AU\";i:3;s:2:\"CA\";i:4;s:2:\"DE\";i:5;s:2:\"ES\";i:6;s:2:\"FR\";i:7;s:2:\"GB\";i:8;s:2:\"IE\";i:9;s:2:\"IT\";i:10;s:2:\"NZ\";i:11;s:2:\"AT\";i:12;s:2:\"BE\";i:13;s:2:\"NL\";i:14;s:2:\"PL\";i:15;s:2:\"PT\";i:16;s:2:\"CH\";i:17;s:2:\"HK\";i:18;s:2:\"SG\";i:19;s:2:\"CY\";i:20;s:2:\"DK\";i:21;s:2:\"EE\";i:22;s:2:\"FI\";i:23;s:2:\"GR\";i:24;s:2:\"LU\";i:25;s:2:\"LT\";i:26;s:2:\"LV\";i:27;s:2:\"NO\";i:28;s:2:\"MT\";i:29;s:2:\"SI\";i:30;s:2:\"SK\";i:31;s:2:\"BG\";i:32;s:2:\"CZ\";i:33;s:2:\"HR\";i:34;s:2:\"HU\";i:35;s:2:\"RO\";i:36;s:2:\"SE\";i:37;s:2:\"JP\";i:38;s:2:\"AE\";}s:9:\"operation\";s:2:\"in\";}i:1;O:8:\"stdClass\":6:{s:4:\"type\";s:6:\"option\";s:12:\"transformers\";a:2:{i:0;O:8:\"stdClass\":2:{s:3:\"use\";s:12:\"dot_notation\";s:9:\"arguments\";O:8:\"stdClass\":1:{s:4:\"path\";s:8:\"industry\";}}i:1;O:8:\"stdClass\":2:{s:3:\"use\";s:12:\"array_column\";s:9:\"arguments\";O:8:\"stdClass\":1:{s:3:\"key\";s:4:\"slug\";}}}s:11:\"option_name\";s:30:\"woocommerce_onboarding_profile\";s:9:\"operation\";s:9:\"!contains\";s:5:\"value\";s:31:\"cbd-other-hemp-derived-products\";s:7:\"default\";a:0:{}}}s:14:\"is_built_by_wc\";b:1;s:14:\"min_wp_version\";s:3:\"5.9\";s:3:\"key\";s:20:\"woocommerce-payments\";s:5:\"label\";s:25:\"Get paid with WooPayments\";s:9:\"image_url\";s:120:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-woo-rebrand-2.svg\";s:15:\"learn_more_link\";s:123:\"https://woocommerce.com/products/woocommerce-payments?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:5;s:12:\"requires_jpc\";b:1;}i:1;O:8:\"stdClass\":9:{s:4:\"name\";s:20:\"WooCommerce Shipping\";s:11:\"description\";s:41:\"Print discounted USPS, UPS and DHL labels\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";s:2:\"US\";s:9:\"operation\";s:1:\"=\";}}s:14:\"is_built_by_wc\";b:1;s:3:\"key\";s:20:\"woocommerce-shipping\";s:5:\"label\";s:42:\"Save on shipping with WooCommerce Shipping\";s:9:\"image_url\";s:120:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-woo-rebrand-2.svg\";s:15:\"learn_more_link\";s:114:\"https://woocommerce.com/woocommerce-shipping?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:3;}i:2;O:8:\"stdClass\":10:{s:4:\"name\";s:11:\"ShipStation\";s:9:\"image_url\";s:118:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-shipstation.svg\";s:10:\"manage_url\";s:26:\"admin.php?page=shipstation\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:4:{i:0;s:2:\"CA\";i:1;s:2:\"GB\";i:2;s:2:\"AU\";i:3;s:2:\"NZ\";}s:9:\"operation\";s:2:\"in\";}}s:14:\"is_built_by_wc\";b:1;s:3:\"key\";s:35:\"woocommerce-shipstation-integration\";s:5:\"label\";s:49:\"Print discounted shipping labels with ShipStation\";s:11:\"description\";s:56:\"Automate your order fulfillment and save on top carriers\";s:15:\"learn_more_link\";s:66:\"https://wordpress.org/plugins/woocommerce-shipstation-integration/\";s:16:\"install_priority\";i:3;}i:3;O:8:\"stdClass\":10:{s:4:\"name\";s:8:\"Packlink\";s:9:\"image_url\";s:115:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-packlink.svg\";s:10:\"manage_url\";s:36:\"admin.php?page=packlink-pro-shipping\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:9:{i:0;s:2:\"FR\";i:1;s:2:\"ES\";i:2;s:2:\"IT\";i:3;s:2:\"DE\";i:4;s:2:\"NL\";i:5;s:2:\"AT\";i:6;s:2:\"BE\";i:7;s:2:\"IE\";i:8;s:2:\"PT\";}s:9:\"operation\";s:2:\"in\";}}s:14:\"is_built_by_wc\";b:0;s:3:\"key\";s:21:\"packlink-pro-shipping\";s:5:\"label\";s:46:\"Print discounted shipping labels with Packlink\";s:11:\"description\";s:56:\"Automate your order fulfillment and save on top carriers\";s:15:\"learn_more_link\";s:52:\"https://wordpress.org/plugins/packlink-pro-shipping/\";s:16:\"install_priority\";i:3;}i:4;O:8:\"stdClass\":10:{s:4:\"name\";s:31:\"PayPal Payments for WooCommerce\";s:11:\"description\";s:61:\"Offer more ways to pay with this all-in-one checkout solution\";s:14:\"is_built_by_wc\";b:0;s:15:\"install_options\";a:1:{i:0;O:8:\"stdClass\":2:{s:4:\"name\";s:26:\"woocommerce_paypal_branded\";s:5:\"value\";s:8:\"profiler\";}}s:10:\"is_visible\";a:2:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:39:{i:0;s:2:\"US\";i:1;s:2:\"PR\";i:2;s:2:\"AU\";i:3;s:2:\"CA\";i:4;s:2:\"DE\";i:5;s:2:\"ES\";i:6;s:2:\"FR\";i:7;s:2:\"GB\";i:8;s:2:\"IE\";i:9;s:2:\"IT\";i:10;s:2:\"NZ\";i:11;s:2:\"AT\";i:12;s:2:\"BE\";i:13;s:2:\"NL\";i:14;s:2:\"PL\";i:15;s:2:\"PT\";i:16;s:2:\"CH\";i:17;s:2:\"HK\";i:18;s:2:\"SG\";i:19;s:2:\"CY\";i:20;s:2:\"DK\";i:21;s:2:\"EE\";i:22;s:2:\"FI\";i:23;s:2:\"GR\";i:24;s:2:\"LU\";i:25;s:2:\"LT\";i:26;s:2:\"LV\";i:27;s:2:\"NO\";i:28;s:2:\"MT\";i:29;s:2:\"SI\";i:30;s:2:\"SK\";i:31;s:2:\"BG\";i:32;s:2:\"CZ\";i:33;s:2:\"HR\";i:34;s:2:\"HU\";i:35;s:2:\"RO\";i:36;s:2:\"SE\";i:37;s:2:\"JP\";i:38;s:2:\"AE\";}s:9:\"operation\";s:3:\"!in\";}i:1;O:8:\"stdClass\":4:{s:4:\"type\";s:14:\"plugin_version\";s:6:\"plugin\";s:11:\"woocommerce\";s:7:\"version\";s:10:\"9.8.0-rc.1\";s:8:\"operator\";s:2:\">=\";}}s:3:\"key\";s:27:\"woocommerce-paypal-payments\";s:5:\"label\";s:41:\"Maximize conversions with PayPal Payments\";s:9:\"image_url\";s:113:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-paypal.svg\";s:15:\"learn_more_link\";s:130:\"https://woocommerce.com/products/woocommerce-paypal-payments?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:5;}i:5;O:8:\"stdClass\":9:{s:4:\"name\";s:31:\"PayPal Payments for WooCommerce\";s:11:\"description\";s:60:\"Offer additional flexible payment options with PayPal Wallet\";s:14:\"is_built_by_wc\";b:0;s:10:\"is_visible\";a:2:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:39:{i:0;s:2:\"US\";i:1;s:2:\"PR\";i:2;s:2:\"AU\";i:3;s:2:\"CA\";i:4;s:2:\"DE\";i:5;s:2:\"ES\";i:6;s:2:\"FR\";i:7;s:2:\"GB\";i:8;s:2:\"IE\";i:9;s:2:\"IT\";i:10;s:2:\"NZ\";i:11;s:2:\"AT\";i:12;s:2:\"BE\";i:13;s:2:\"NL\";i:14;s:2:\"PL\";i:15;s:2:\"PT\";i:16;s:2:\"CH\";i:17;s:2:\"HK\";i:18;s:2:\"SG\";i:19;s:2:\"CY\";i:20;s:2:\"DK\";i:21;s:2:\"EE\";i:22;s:2:\"FI\";i:23;s:2:\"GR\";i:24;s:2:\"LU\";i:25;s:2:\"LT\";i:26;s:2:\"LV\";i:27;s:2:\"NO\";i:28;s:2:\"MT\";i:29;s:2:\"SI\";i:30;s:2:\"SK\";i:31;s:2:\"BG\";i:32;s:2:\"CZ\";i:33;s:2:\"HR\";i:34;s:2:\"HU\";i:35;s:2:\"RO\";i:36;s:2:\"SE\";i:37;s:2:\"JP\";i:38;s:2:\"AE\";}s:9:\"operation\";s:2:\"in\";}i:1;O:8:\"stdClass\":4:{s:4:\"type\";s:14:\"plugin_version\";s:6:\"plugin\";s:11:\"woocommerce\";s:7:\"version\";s:10:\"9.8.0-rc.1\";s:8:\"operator\";s:2:\">=\";}}s:3:\"key\";s:39:\"woocommerce-paypal-payments:wallet-only\";s:5:\"label\";s:38:\"Give shoppers a variety of ways to pay\";s:9:\"image_url\";s:113:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-paypal.svg\";s:15:\"learn_more_link\";s:130:\"https://woocommerce.com/products/woocommerce-paypal-payments?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:5;}i:6;O:8:\"stdClass\":11:{s:4:\"name\";s:7:\"Jetpack\";s:11:\"description\";s:53:\"Keep your store online with full security and backups\";s:10:\"is_visible\";b:1;s:14:\"is_built_by_wc\";b:0;s:14:\"min_wp_version\";s:3:\"6.0\";s:3:\"key\";s:7:\"jetpack\";s:5:\"label\";s:49:\"Protect your store and your shoppers with Jetpack\";s:9:\"image_url\";s:114:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-jetpack.svg\";s:15:\"learn_more_link\";s:110:\"https://woocommerce.com/products/jetpack?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:8;s:12:\"requires_jpc\";b:1;}i:7;O:8:\"stdClass\":11:{s:4:\"name\";s:25:\"Pinterest for WooCommerce\";s:11:\"description\";s:55:\"Get your products in front of a highly engaged audience\";s:9:\"image_url\";s:116:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-pinterest.svg\";s:10:\"manage_url\";s:51:\"admin.php?page=wc-admin&path=%2Fpinterest%2Flanding\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":5:{s:4:\"type\";s:6:\"option\";s:11:\"option_name\";s:37:\"woocommerce_remote_variant_assignment\";s:5:\"value\";a:2:{i:0;i:61;i:1;i:120;}s:7:\"default\";b:0;s:9:\"operation\";s:5:\"range\";}}s:14:\"is_built_by_wc\";b:1;s:15:\"min_php_version\";s:3:\"7.3\";s:3:\"key\";s:25:\"pinterest-for-woocommerce\";s:5:\"label\";s:37:\"Showcase your products with Pinterest\";s:15:\"learn_more_link\";s:128:\"https://woocommerce.com/products/pinterest-for-woocommerce?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:2;}i:8;O:8:\"stdClass\":10:{s:4:\"name\";s:8:\"MailPoet\";s:11:\"description\";s:58:\"Attract and retain shoppers with email marketing campaigns\";s:10:\"manage_url\";s:35:\"admin.php?page=mailpoet-newsletters\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":5:{s:4:\"type\";s:6:\"option\";s:11:\"option_name\";s:37:\"woocommerce_remote_variant_assignment\";s:5:\"value\";a:2:{i:0;i:1;i:1;i:84;}s:7:\"default\";b:0;s:9:\"operation\";s:5:\"range\";}}s:14:\"is_built_by_wc\";b:1;s:3:\"key\";s:8:\"mailpoet\";s:5:\"label\";s:34:\"Reach your customers with MailPoet\";s:9:\"image_url\";s:115:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-mailpoet.svg\";s:15:\"learn_more_link\";s:111:\"https://woocommerce.com/products/mailpoet?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:7;}i:9;O:8:\"stdClass\":10:{s:4:\"name\";s:7:\"Klaviyo\";s:11:\"description\";s:56:\"Build personalized email and SMS campaigns using Klaviyo\";s:9:\"image_url\";s:95:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/klaviyo.png\";s:10:\"manage_url\";s:31:\"admin.php?page=klaviyo_settings\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":5:{s:4:\"type\";s:6:\"option\";s:11:\"option_name\";s:37:\"woocommerce_remote_variant_assignment\";s:5:\"value\";a:2:{i:0;i:85;i:1;i:120;}s:7:\"default\";b:0;s:9:\"operation\";s:5:\"range\";}}s:14:\"is_built_by_wc\";b:0;s:3:\"key\";s:7:\"klaviyo\";s:5:\"label\";s:24:\"Boost sales with Klaviyo\";s:15:\"learn_more_link\";s:126:\"https://woocommerce.com/products/klaviyo-for-woocommerce?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:7;}i:10;O:8:\"stdClass\":11:{s:4:\"name\";s:22:\"Google for WooCommerce\";s:11:\"description\";s:57:\"Create ads for your products straight from your dashboard\";s:9:\"image_url\";s:113:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-google.svg\";s:10:\"manage_url\";s:46:\"admin.php?page=wc-admin&path=%2Fgoogle%2Fstart\";s:10:\"is_visible\";b:1;s:14:\"is_built_by_wc\";b:1;s:15:\"min_php_version\";s:3:\"7.4\";s:3:\"key\";s:23:\"google-listings-and-ads\";s:5:\"label\";s:39:\"Drive sales with Google for WooCommerce\";s:15:\"learn_more_link\";s:126:\"https://woocommerce.com/products/google-listings-and-ads?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:6;}i:11;O:8:\"stdClass\":9:{s:4:\"name\";s:15:\"WooCommerce Tax\";s:11:\"description\";s:62:\"Automatically calculate how much sales tax should be collected\";s:10:\"is_visible\";a:1:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:11:{i:0;s:2:\"US\";i:1;s:2:\"FR\";i:2;s:2:\"GB\";i:3;s:2:\"DE\";i:4;s:2:\"CA\";i:5;s:2:\"AU\";i:6;s:2:\"GR\";i:7;s:2:\"BE\";i:8;s:2:\"PT\";i:9;s:2:\"DK\";i:10;s:2:\"SE\";}s:9:\"operation\";s:2:\"in\";}}s:14:\"is_built_by_wc\";b:1;s:3:\"key\";s:24:\"woocommerce-services:tax\";s:5:\"label\";s:44:\"Get automated tax rates with WooCommerce Tax\";s:9:\"image_url\";s:120:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-woo-rebrand-2.svg\";s:15:\"learn_more_link\";s:106:\"https://woocommerce.com/products/tax?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:4;}i:12;O:8:\"stdClass\":10:{s:4:\"name\";s:22:\"TikTok for WooCommerce\";s:9:\"image_url\";s:113:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-tiktok.svg\";s:11:\"description\";s:59:\"Sync your store with TikTok to create engaging ad campaigns\";s:10:\"manage_url\";s:21:\"admin.php?page=tiktok\";s:10:\"is_visible\";a:2:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:40:{i:0;s:2:\"US\";i:1;s:2:\"CA\";i:2;s:2:\"MX\";i:3;s:2:\"AT\";i:4;s:2:\"BE\";i:5;s:2:\"CZ\";i:6;s:2:\"DK\";i:7;s:2:\"FI\";i:8;s:2:\"FR\";i:9;s:2:\"DE\";i:10;s:2:\"GR\";i:11;s:2:\"HU\";i:12;s:2:\"IE\";i:13;s:2:\"IT\";i:14;s:2:\"NL\";i:15;s:2:\"PL\";i:16;s:2:\"PT\";i:17;s:2:\"RO\";i:18;s:2:\"ES\";i:19;s:2:\"SE\";i:20;s:2:\"GB\";i:21;s:2:\"CH\";i:22;s:2:\"NO\";i:23;s:2:\"AU\";i:24;s:2:\"NZ\";i:25;s:2:\"SG\";i:26;s:2:\"MY\";i:27;s:2:\"PH\";i:28;s:2:\"ID\";i:29;s:2:\"VN\";i:30;s:2:\"TH\";i:31;s:2:\"KR\";i:32;s:2:\"IL\";i:33;s:2:\"AE\";i:34;s:2:\"RU\";i:35;s:2:\"UA\";i:36;s:2:\"TR\";i:37;s:2:\"SA\";i:38;s:2:\"BR\";i:39;s:2:\"JP\";}s:9:\"operation\";s:2:\"in\";}i:1;O:8:\"stdClass\":5:{s:4:\"type\";s:6:\"option\";s:11:\"option_name\";s:37:\"woocommerce_remote_variant_assignment\";s:5:\"value\";a:2:{i:0;i:1;i:1;i:60;}s:7:\"default\";b:0;s:9:\"operation\";s:5:\"range\";}}s:14:\"is_built_by_wc\";b:0;s:3:\"key\";s:19:\"tiktok-for-business\";s:5:\"label\";s:31:\"Create ad campaigns with TikTok\";s:15:\"learn_more_link\";s:125:\"https://woocommerce.com/products/tiktok-for-woocommerce?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:1;}i:13;O:8:\"stdClass\":10:{s:4:\"name\";s:12:\"Snapchat Ads\";s:11:\"description\";s:59:\"Reach an untapped audience on Snapchat and drive more sales\";s:9:\"image_url\";s:115:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-snapchat.svg\";s:10:\"manage_url\";s:48:\"admin.php?page=wc-admin&path=%2Fsnapchat%2Fstart\";s:14:\"is_built_by_wc\";b:1;s:10:\"is_visible\";b:1;s:3:\"key\";s:24:\"snapchat-for-woocommerce\";s:5:\"label\";s:36:\"Find new customers with Snapchat Ads\";s:15:\"learn_more_link\";s:112:\"https://woocommerce.com/products/snapchat/?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:1;}i:14;O:8:\"stdClass\":10:{s:4:\"name\";s:10:\"Reddit Ads\";s:11:\"description\";s:50:\"Seamlessly sync your products and start Reddit Ads\";s:9:\"image_url\";s:113:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-reddit.svg\";s:10:\"manage_url\";s:46:\"admin.php?page=wc-admin&path=%2Freddit%2Fsetup\";s:14:\"is_built_by_wc\";b:1;s:10:\"is_visible\";b:1;s:3:\"key\";s:22:\"reddit-for-woocommerce\";s:5:\"label\";s:37:\"Reach ready-to-buy shoppers on Reddit\";s:15:\"learn_more_link\";s:110:\"https://woocommerce.com/products/reddit/?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:1;}i:15;O:8:\"stdClass\":10:{s:4:\"name\";s:29:\"Print on Demand with Printful\";s:9:\"image_url\";s:115:\"https://woocommerce.com/wp-content/plugins/wccom-plugins/obw-free-extensions/images/core-profiler/logo-printful.png\";s:11:\"description\";s:65:\"Design and easily sell custom print products online with Printful\";s:10:\"manage_url\";s:0:\"\";s:10:\"is_visible\";a:2:{i:0;O:8:\"stdClass\":3:{s:4:\"type\";s:21:\"base_location_country\";s:5:\"value\";a:9:{i:0;s:2:\"AU\";i:1;s:2:\"GB\";i:2;s:2:\"CA\";i:3;s:2:\"ES\";i:4;s:2:\"DE\";i:5;s:2:\"FR\";i:6;s:2:\"NL\";i:7;s:2:\"BE\";i:8;s:2:\"LU\";}s:9:\"operation\";s:2:\"in\";}i:1;O:8:\"stdClass\":6:{s:4:\"type\";s:6:\"option\";s:12:\"transformers\";a:1:{i:0;O:8:\"stdClass\":2:{s:3:\"use\";s:12:\"dot_notation\";s:9:\"arguments\";O:8:\"stdClass\":1:{s:4:\"path\";s:10:\"industry.0\";}}}s:11:\"option_name\";s:30:\"woocommerce_onboarding_profile\";s:5:\"value\";s:24:\"clothing_and_accessories\";s:7:\"default\";s:0:\"\";s:9:\"operation\";s:1:\"=\";}}s:14:\"is_built_by_wc\";b:0;s:3:\"key\";s:33:\"printful-shipping-for-woocommerce\";s:5:\"label\";s:29:\"Print on Demand with Printful\";s:15:\"learn_more_link\";s:111:\"https://woocommerce.com/products/printful?utm_source=storeprofiler&utm_medium=product&utm_campaign=freefeatures\";s:16:\"install_priority\";i:9;}}}}}','off'),
(456,'woocommerce_onboarding_profile_progress','a:1:{s:29:\"core_profiler_completed_steps\";a:1:{s:12:\"intro-opt-in\";a:1:{s:12:\"completed_at\";s:20:\"2026-10-07T02:52:57Z\";}}}','auto'),
(457,'woocommerce_allow_tracking_first_optin','1791341577','auto'),
(458,'woocommerce_allow_tracking_last_modified','1791341577','auto'),
(459,'wc_has_tracked_default_theme','1','auto'),
(461,'_site_transient_timeout_woocommerce_new_version','1791946393','off'),
(462,'_site_transient_woocommerce_new_version','','off'),
(467,'fluentform_entry_details_migrated','yes','off'),
(468,'fluentform_db_fluentform_logs_added','1','off'),
(469,'fluentform_scheduled_actions_migrated','yes','off'),
(470,'_fluentform_global_form_settings','a:2:{s:6:\"layout\";a:5:{s:14:\"labelPlacement\";s:3:\"top\";s:17:\"asteriskPlacement\";s:14:\"asterisk-right\";s:20:\"helpMessagePlacement\";s:10:\"with_label\";s:21:\"errorMessagePlacement\";s:6:\"inline\";s:12:\"cssClassName\";s:0:\"\";}s:4:\"misc\";a:5:{s:18:\"isIpLogingDisabled\";b:0;s:19:\"isAnalyticsDisabled\";b:1;s:21:\"file_upload_locations\";s:0:\"\";s:20:\"admin_top_nav_status\";s:3:\"yes\";s:23:\"default_admin_date_time\";s:9:\"time_diff\";}}','off'),
(471,'_fluentform_installed_version','6.2.15','off'),
(472,'fluentform_global_modules_status','a:9:{s:9:\"mailchimp\";s:2:\"no\";s:14:\"activecampaign\";s:2:\"no\";s:16:\"campaign_monitor\";s:2:\"no\";s:17:\"constatantcontact\";s:2:\"no\";s:11:\"getresponse\";s:2:\"no\";s:8:\"icontact\";s:2:\"no\";s:7:\"webhook\";s:2:\"no\";s:6:\"zapier\";s:2:\"no\";s:5:\"slack\";s:2:\"no\";}','off'),
(476,'widget_fluentform_widget','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),
(477,'fluentform_empty_manager_scopes_normalized','6.2.15','off'),
(478,'jetpack_connection_active_plugins','a:1:{s:11:\"woocommerce\";a:1:{s:4:\"name\";s:11:\"WooCommerce\";}}','auto'),
(489,'woocommerce_share_key','nTAPftN7isJ5pko6ZimZtNZKHxgMM4I1','auto'),
(490,'_transient_shipping-transient-version','1791343158','on'),
(491,'_transient_timeout_wc_shipping_method_count','1793935158','off'),
(492,'_transient_wc_shipping_method_count','a:4:{s:7:\"version\";s:10:\"1791343158\";s:6:\"legacy\";i:0;s:7:\"enabled\";i:0;s:8:\"disabled\";i:0;}','off'),
(493,'recovery_keys','a:0:{}','off'),
(495,'finished_updating_comment_type','1','auto'),
(497,'action_scheduler_migration_status','complete','auto'),
(498,'as_has_wp_comment_logs','no','on'),
(499,'wc_variation_gallery_migration_completed_at','1791343681','auto'),
(500,'woocommerce_marketplace_suggestions','a:2:{s:11:\"suggestions\";a:27:{i:0;a:1:{s:21:\"recommendations-count\";i:5;}i:1;a:4:{s:4:\"slug\";s:28:\"product-edit-meta-tab-header\";s:7:\"context\";a:1:{i:0;s:28:\"product-edit-meta-tab-header\";}s:5:\"title\";s:22:\"Recommended extensions\";s:13:\"allow-dismiss\";b:0;}i:2;a:7:{s:4:\"slug\";s:39:\"product-edit-meta-tab-footer-browse-all\";s:7:\"context\";a:1:{i:0;s:28:\"product-edit-meta-tab-footer\";}s:9:\"link-text\";s:21:\"Discover more options\";s:3:\"url\";s:64:\"https://woocommerce.com/product-category/woocommerce-extensions/\";s:7:\"iam-url\";s:55:\"admin.php?page=wc-admin&tab=extensions&path=/extensions\";s:8:\"promoted\";s:31:\"category-woocommerce-extensions\";s:13:\"allow-dismiss\";b:0;}i:3;a:4:{s:4:\"slug\";s:19:\"orders-empty-header\";s:7:\"context\";a:1:{i:0;s:24:\"orders-list-empty-header\";}s:5:\"title\";s:20:\"Tools for your store\";s:13:\"allow-dismiss\";b:0;}i:4;a:7:{s:4:\"slug\";s:30:\"orders-empty-footer-browse-all\";s:7:\"context\";a:1:{i:0;s:24:\"orders-list-empty-footer\";}s:9:\"link-text\";s:21:\"Discover more options\";s:3:\"url\";s:64:\"https://woocommerce.com/product-category/woocommerce-extensions/\";s:7:\"iam-url\";s:55:\"admin.php?page=wc-admin&tab=extensions&path=/extensions\";s:8:\"promoted\";s:31:\"category-woocommerce-extensions\";s:13:\"allow-dismiss\";b:0;}i:5;a:4:{s:4:\"slug\";s:35:\"products-empty-header-product-types\";s:7:\"context\";a:1:{i:0;s:26:\"products-list-empty-header\";}s:5:\"title\";s:23:\"Other types of products\";s:13:\"allow-dismiss\";b:0;}i:6;a:7:{s:4:\"slug\";s:32:\"products-empty-footer-browse-all\";s:7:\"context\";a:1:{i:0;s:26:\"products-list-empty-footer\";}s:9:\"link-text\";s:21:\"Discover more options\";s:3:\"url\";s:64:\"https://woocommerce.com/product-category/woocommerce-extensions/\";s:7:\"iam-url\";s:55:\"admin.php?page=wc-admin&tab=extensions&path=/extensions\";s:8:\"promoted\";s:31:\"category-woocommerce-extensions\";s:13:\"allow-dismiss\";b:0;}i:7;a:9:{s:4:\"slug\";s:42:\"orders-list-empty-body-table-rate-shipping\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:19:\"table-rate-shipping\";s:4:\"icon\";s:101:\"https://woocommerce.com/wp-content/uploads/2012/07/Table_Rate_Shipping_icon-marketplace-160x160-2.png\";s:5:\"title\";s:19:\"Table Rate Shipping\";s:4:\"copy\";s:123:\"Advanced, flexible shipping. Define multiple shipping rates based on location, price, weight, shipping class or item count.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:53:\"https://woocommerce.com/products/table-rate-shipping/\";s:9:\"is_pinned\";b:1;}i:8;a:9:{s:4:\"slug\";s:40:\"orders-list-empty-body-shipment-tracking\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:17:\"shipment-tracking\";s:4:\"icon\";s:99:\"https://woocommerce.com/wp-content/uploads/2012/05/Shipment_Tracking_icon-marketplace-160x160-2.png\";s:5:\"title\";s:17:\"Shipment Tracking\";s:4:\"copy\";s:49:\"Add shipment tracking information to your orders.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:51:\"https://woocommerce.com/products/shipment-tracking/\";s:9:\"is_pinned\";b:1;}i:9;a:9:{s:4:\"slug\";s:56:\"orders-list-empty-body-conditional-shipping-and-payments\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:33:\"conditional-shipping-and-payments\";s:4:\"icon\";s:111:\"https://woocommerce.com/wp-content/uploads/2015/03/Conditional_Shipping_Payments_icon-marketplace-160x160-1.png\";s:5:\"title\";s:33:\"Conditional Shipping and Payments\";s:4:\"copy\";s:91:\"Use conditional logic to restrict the shipping and payment options available on your store.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:67:\"https://woocommerce.com/products/conditional-shipping-and-payments/\";s:9:\"is_pinned\";b:1;}i:10;a:9:{s:4:\"slug\";s:46:\"orders-list-empty-body-shipstation-integration\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:23:\"shipstation-integration\";s:4:\"icon\";s:73:\"https://woocommerce.com/wp-content/uploads/2012/08/ShipStation-Icon-1.png\";s:5:\"title\";s:11:\"ShipStation\";s:4:\"copy\";s:113:\"Ship your WooCommerce orders with confidence, save on top carriers, and automate your processes with ShipStation.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:57:\"https://woocommerce.com/products/shipstation-integration/\";s:9:\"is_pinned\";b:1;}i:11;a:9:{s:4:\"slug\";s:41:\"orders-list-empty-body-woocommerce-zapier\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:18:\"woocommerce-zapier\";s:4:\"icon\";s:76:\"https://woocommerce.com/wp-content/uploads/2013/09/Zapier-App-Icon-160-1.png\";s:5:\"title\";s:18:\"Zapier Integration\";s:4:\"copy\";s:153:\"WooCommerce connected to 9,000+ apps, with AI steps inside your workflows and plain-English store management through Claude or ChatGPT. No code required.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:52:\"https://woocommerce.com/products/woocommerce-zapier/\";s:9:\"is_pinned\";b:1;}i:12;a:9:{s:4:\"slug\";s:34:\"orders-list-empty-body-automatewoo\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:11:\"automatewoo\";s:4:\"icon\";s:70:\"https://woocommerce.com/wp-content/uploads/2019/10/woo-AutomateWoo.png\";s:5:\"title\";s:11:\"AutomateWoo\";s:4:\"copy\";s:121:\"Powerful marketing automation for WooCommerce. AutomateWoo has the tools you need to grow your store and make more money.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:45:\"https://woocommerce.com/products/automatewoo/\";s:9:\"is_pinned\";b:1;}i:13;a:9:{s:4:\"slug\";s:51:\"orders-list-empty-body-print-invoices-packing-lists\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:28:\"print-invoices-packing-lists\";s:4:\"icon\";s:78:\"https://woocommerce.com/wp-content/uploads/2015/06/skyverge-wc-icon-b2vhw6.png\";s:5:\"title\";s:32:\"Print Invoices and Packing Lists\";s:4:\"copy\";s:77:\"Generate invoices, packing slips, and pick lists for your WooCommerce orders.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:62:\"https://woocommerce.com/products/print-invoices-packing-lists/\";s:9:\"is_pinned\";b:1;}i:14;a:9:{s:4:\"slug\";s:31:\"orders-list-empty-body-printful\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:8:\"printful\";s:4:\"icon\";s:77:\"https://woocommerce.com/wp-content/uploads/2024/07/Printful_Logo_icon_1-1.jpg\";s:5:\"title\";s:25:\"Printful: Print on Demand\";s:4:\"copy\";s:127:\"Sell custom embroidery and print items without inventory or upfront costs. Start or grow your ecommerce business with Printful!\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:42:\"https://woocommerce.com/products/printful/\";s:9:\"is_pinned\";b:1;}i:15;a:9:{s:4:\"slug\";s:53:\"orders-list-empty-body-envia-shipping-and-fulfillment\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:30:\"envia-shipping-and-fulfillment\";s:4:\"icon\";s:84:\"https://woocommerce.com/wp-content/uploads/2022/09/icono-envia-color160x160.png?w=80\";s:5:\"title\";s:30:\"Envia Shipping and Fulfillment\";s:4:\"copy\";s:57:\"Streamline shipping worldwide with Envia for WooCommerce.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:64:\"https://woocommerce.com/products/envia-shipping-and-fulfillment/\";s:9:\"is_pinned\";b:1;}i:16;a:9:{s:4:\"slug\";s:31:\"orders-list-empty-body-picklist\";s:7:\"context\";s:22:\"orders-list-empty-body\";s:7:\"product\";s:8:\"picklist\";s:4:\"icon\";s:75:\"https://woocommerce.com/wp-content/uploads/2023/11/pick-list-icon-160x.webp\";s:5:\"title\";s:9:\"Pick List\";s:4:\"copy\";s:138:\"Fast, accurate order fulfillment for WooCommerce — with batch picking, live picking, printable documents, and optional barcode scanning.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:42:\"https://woocommerce.com/products/picklist/\";s:9:\"is_pinned\";b:1;}i:17;a:9:{s:4:\"slug\";s:42:\"product-edit-meta-tab-body-product-add-ons\";s:7:\"context\";s:26:\"product-edit-meta-tab-body\";s:7:\"product\";s:15:\"product-add-ons\";s:4:\"icon\";s:96:\"https://woocommerce.com/wp-content/uploads/2013/05/Product_Addons_icon-marketplace-160x160-2.png\";s:5:\"title\";s:15:\"Product Add-Ons\";s:4:\"copy\";s:94:\"Offer add-ons like gift wrapping, special messages or other special options for your products.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:49:\"https://woocommerce.com/products/product-add-ons/\";s:9:\"is_pinned\";b:1;}i:18;a:9:{s:4:\"slug\";s:42:\"product-edit-meta-tab-body-product-bundles\";s:7:\"context\";s:26:\"product-edit-meta-tab-body\";s:7:\"product\";s:15:\"product-bundles\";s:4:\"icon\";s:97:\"https://woocommerce.com/wp-content/uploads/2012/07/Product_Bundles_icon-marketplace-160x160-2.png\";s:5:\"title\";s:15:\"Product Bundles\";s:4:\"copy\";s:84:\"Offer personalized product bundles, bulk discount packages, and assembled products.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:49:\"https://woocommerce.com/products/product-bundles/\";s:9:\"is_pinned\";b:1;}i:19;a:9:{s:4:\"slug\";s:47:\"product-edit-meta-tab-body-woocommerce-bookings\";s:7:\"context\";s:26:\"product-edit-meta-tab-body\";s:7:\"product\";s:20:\"woocommerce-bookings\";s:4:\"icon\";s:90:\"https://woocommerce.com/wp-content/uploads/2014/05/Bookings_icon-marketplace-160x160-1.png\";s:5:\"title\";s:20:\"WooCommerce Bookings\";s:4:\"copy\";s:497:\"WooCommerce Bookings is the official WooCommerce extension that lets store owners sell appointments, reservations, rentals, or classes with bookable time or date slots. It supports fixed time slots or flexible ranges, group and individual pricing, and resources — staff, rooms, or equipment — each with its own availability to prevent double-booking. It syncs with Google Calendar and works with any WooCommerce payment gateway. It\'s a paid annual extension with a 30-day money-back guarantee.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:54:\"https://woocommerce.com/products/woocommerce-bookings/\";s:9:\"is_pinned\";b:1;}i:20;a:9:{s:4:\"slug\";s:52:\"product-edit-meta-tab-body-woocommerce-subscriptions\";s:7:\"context\";s:26:\"product-edit-meta-tab-body\";s:7:\"product\";s:25:\"woocommerce-subscriptions\";s:4:\"icon\";s:99:\"https://woocommerce.com/wp-content/uploads/2012/09/Woo_Subscriptions_icon-marketplace-160x160-2.png\";s:5:\"title\";s:25:\"WooCommerce Subscriptions\";s:4:\"copy\";s:514:\"WooCommerce Subscriptions is a WooCommerce extension that lets customers subscribe to your products or services and pay on a weekly, monthly, or annual basis. It integrates with over 25 payment gateways for automatic recurring payments and supports automatic rebilling on failed subscription payments. Subscribers can manage their own plan — upgrading, downgrading, suspending, or canceling — and update their shipping address or payment method. It\'s a paid annual extension with a 30-day money-back guarantee.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:59:\"https://woocommerce.com/products/woocommerce-subscriptions/\";s:9:\"is_pinned\";b:1;}i:21;a:9:{s:4:\"slug\";s:45:\"product-edit-meta-tab-body-composite-products\";s:7:\"context\";s:26:\"product-edit-meta-tab-body\";s:7:\"product\";s:18:\"composite-products\";s:4:\"icon\";s:100:\"https://woocommerce.com/wp-content/uploads/2013/06/Composite_Products_icon-marketplace-160x160-1.png\";s:5:\"title\";s:18:\"Composite Products\";s:4:\"copy\";s:85:\"Create product kit builders and custom product configurators using existing products.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:52:\"https://woocommerce.com/products/composite-products/\";s:9:\"is_pinned\";b:1;}i:22;a:9:{s:4:\"slug\";s:50:\"product-edit-meta-tab-body-woocommerce-memberships\";s:7:\"context\";s:26:\"product-edit-meta-tab-body\";s:7:\"product\";s:23:\"woocommerce-memberships\";s:4:\"icon\";s:78:\"https://woocommerce.com/wp-content/uploads/2015/06/skyverge-wc-icon-b2vhw6.png\";s:5:\"title\";s:23:\"WooCommerce Memberships\";s:4:\"copy\";s:139:\"Power your membership association, online magazine, elearning sites, and more with access control to content/products and member discounts.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:57:\"https://woocommerce.com/products/woocommerce-memberships/\";s:9:\"is_pinned\";b:1;}i:23;a:9:{s:4:\"slug\";s:35:\"product-edit-meta-tab-body-printful\";s:7:\"context\";s:26:\"product-edit-meta-tab-body\";s:7:\"product\";s:8:\"printful\";s:4:\"icon\";s:77:\"https://woocommerce.com/wp-content/uploads/2024/07/Printful_Logo_icon_1-1.jpg\";s:5:\"title\";s:25:\"Printful: Print on Demand\";s:4:\"copy\";s:127:\"Sell custom embroidery and print items without inventory or upfront costs. Start or grow your ecommerce business with Printful!\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:42:\"https://woocommerce.com/products/printful/\";s:9:\"is_pinned\";b:1;}i:24;a:9:{s:4:\"slug\";s:37:\"product-edit-meta-tab-body-gift-cards\";s:7:\"context\";s:26:\"product-edit-meta-tab-body\";s:7:\"product\";s:10:\"gift-cards\";s:4:\"icon\";s:92:\"https://woocommerce.com/wp-content/uploads/2020/03/Gift_Cards_icon-marketplace-160x160-1.png\";s:5:\"title\";s:10:\"Gift Cards\";s:4:\"copy\";s:495:\"Gift Cards for WooCommerce is the official WooCommerce extension for selling prepaid, multi-purpose digital gift cards that customers redeem online. It supports Simple and Variable gift certificates, expiring codes, custom delivery dates, and multiple recipients, and lets store owners track, search, and report on issued, used, and expired codes. Unlike a coupon, it treats gift cards as prepaid balances for accurate accounting. It\'s a paid annual extension with a 30-day money-back guarantee.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:44:\"https://woocommerce.com/products/gift-cards/\";s:9:\"is_pinned\";b:1;}i:25;a:9:{s:4:\"slug\";s:52:\"product-edit-meta-tab-body-wholesale-for-woocommerce\";s:7:\"context\";s:26:\"product-edit-meta-tab-body\";s:7:\"product\";s:25:\"wholesale-for-woocommerce\";s:4:\"icon\";s:82:\"https://woocommerce.com/wp-content/uploads/2019/09/Wholesale-For-WooCommerce-5.png\";s:5:\"title\";s:41:\"Wholesale For WooCommerce - B2B Ecommerce\";s:4:\"copy\";s:134:\"Run your B2C + B2B eCommerce store with the best AI-Powered WooCommerce B2B plugin for pricing, quotes, bulk orders, and sales agents.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:59:\"https://woocommerce.com/products/wholesale-for-woocommerce/\";s:9:\"is_pinned\";b:1;}i:26;a:9:{s:4:\"slug\";s:69:\"product-edit-meta-tab-body-quantity-discounts-pricing-for-woocommerce\";s:7:\"context\";s:26:\"product-edit-meta-tab-body\";s:7:\"product\";s:42:\"quantity-discounts-pricing-for-woocommerce\";s:4:\"icon\";s:85:\"https://woocommerce.com/wp-content/uploads/2021/07/image_2022_08_12T13_26_36_952Z.png\";s:5:\"title\";s:28:\"Quantity Discounts & Pricing\";s:4:\"copy\";s:112:\"Enable discounts on quantity ranges or set price per quantity for specific products, categories, and user roles.\";s:11:\"button-text\";s:10:\"Learn More\";s:3:\"url\";s:76:\"https://woocommerce.com/products/quantity-discounts-pricing-for-woocommerce/\";s:9:\"is_pinned\";b:1;}}s:7:\"updated\";i:1791343681;}','off'),
(501,'woocommerce_tracker_last_send','1791343682','auto'),
(502,'jetpack_options','a:1:{s:14:\"last_heartbeat\";i:1791518102;}','auto'),
(514,'woocommerce_tracker_ua','a:1:{i:0;s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36\";}','off'),
(517,'_transient_woocommerce_shipping_task_zone_count_transient','0','on'),
(522,'_transient_woocommerce_reports-transient-version','1791354717','on'),
(523,'_transient_timeout_wc_report_orders_stats_ba2196a7af7ec8f95b637ec92b033538','1791959517','off'),
(524,'_transient_wc_report_orders_stats_ba2196a7af7ec8f95b637ec92b033538','a:2:{s:7:\"version\";s:10:\"1791354717\";s:5:\"value\";O:8:\"stdClass\":5:{s:6:\"totals\";O:8:\"stdClass\":15:{s:12:\"orders_count\";i:0;s:14:\"num_items_sold\";i:0;s:11:\"gross_sales\";d:0;s:11:\"total_sales\";d:0;s:7:\"coupons\";d:0;s:13:\"coupons_count\";i:0;s:7:\"refunds\";d:0;s:5:\"taxes\";d:0;s:8:\"shipping\";d:0;s:11:\"net_revenue\";d:0;s:19:\"avg_items_per_order\";d:0;s:15:\"avg_order_value\";d:0;s:15:\"total_customers\";i:0;s:8:\"products\";i:0;s:8:\"segments\";a:0:{}}s:9:\"intervals\";a:2:{i:0;a:6:{s:8:\"interval\";s:7:\"2026-41\";s:10:\"date_start\";s:19:\"2026-10-05 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-05 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-07 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-07 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":14:{s:12:\"orders_count\";i:0;s:14:\"num_items_sold\";i:0;s:11:\"gross_sales\";d:0;s:11:\"total_sales\";d:0;s:7:\"coupons\";d:0;s:13:\"coupons_count\";i:0;s:7:\"refunds\";d:0;s:5:\"taxes\";d:0;s:8:\"shipping\";d:0;s:11:\"net_revenue\";d:0;s:19:\"avg_items_per_order\";d:0;s:15:\"avg_order_value\";d:0;s:15:\"total_customers\";i:0;s:8:\"segments\";a:0:{}}}i:1;a:6:{s:8:\"interval\";s:7:\"2026-40\";s:10:\"date_start\";s:19:\"2026-10-01 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-01 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-04 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-04 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":14:{s:12:\"orders_count\";i:0;s:14:\"num_items_sold\";i:0;s:11:\"gross_sales\";d:0;s:11:\"total_sales\";d:0;s:7:\"coupons\";d:0;s:13:\"coupons_count\";i:0;s:7:\"refunds\";d:0;s:5:\"taxes\";d:0;s:8:\"shipping\";d:0;s:11:\"net_revenue\";d:0;s:19:\"avg_items_per_order\";d:0;s:15:\"avg_order_value\";d:0;s:15:\"total_customers\";i:0;s:8:\"segments\";a:0:{}}}}s:5:\"total\";i:2;s:5:\"pages\";i:1;s:7:\"page_no\";i:1;}}','off'),
(525,'_transient_timeout_wc_report_products_stats_2f4ac76f0b3fe83f24c733ae83897bf5','1791959518','off'),
(526,'_transient_wc_report_products_stats_2f4ac76f0b3fe83f24c733ae83897bf5','a:2:{s:7:\"version\";s:10:\"1791354717\";s:5:\"value\";O:8:\"stdClass\":5:{s:6:\"totals\";O:8:\"stdClass\":6:{s:10:\"items_sold\";i:0;s:11:\"net_revenue\";d:0;s:12:\"orders_count\";i:0;s:14:\"products_count\";i:0;s:16:\"variations_count\";i:0;s:8:\"segments\";a:0:{}}s:9:\"intervals\";a:2:{i:0;a:6:{s:8:\"interval\";s:7:\"2026-41\";s:10:\"date_start\";s:19:\"2026-10-05 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-05 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-07 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-07 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":6:{s:10:\"items_sold\";i:0;s:11:\"net_revenue\";d:0;s:12:\"orders_count\";i:0;s:14:\"products_count\";i:0;s:16:\"variations_count\";i:0;s:8:\"segments\";a:0:{}}}i:1;a:6:{s:8:\"interval\";s:7:\"2026-40\";s:10:\"date_start\";s:19:\"2026-10-01 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-01 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-04 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-04 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":6:{s:10:\"items_sold\";i:0;s:11:\"net_revenue\";d:0;s:12:\"orders_count\";i:0;s:14:\"products_count\";i:0;s:16:\"variations_count\";i:0;s:8:\"segments\";a:0:{}}}}s:5:\"total\";i:2;s:5:\"pages\";i:1;s:7:\"page_no\";i:1;}}','off'),
(527,'_transient_timeout_wc_report_variations_stats_bea538710ed55643dcc5a49b8a67bc86','1791959518','off'),
(528,'_transient_wc_report_variations_stats_bea538710ed55643dcc5a49b8a67bc86','a:2:{s:7:\"version\";s:10:\"1791354717\";s:5:\"value\";O:8:\"stdClass\":5:{s:6:\"totals\";O:8:\"stdClass\":5:{s:10:\"items_sold\";i:0;s:11:\"net_revenue\";d:0;s:12:\"orders_count\";i:0;s:16:\"variations_count\";i:0;s:8:\"segments\";a:0:{}}s:9:\"intervals\";a:2:{i:0;a:6:{s:8:\"interval\";s:7:\"2026-41\";s:10:\"date_start\";s:19:\"2026-10-05 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-05 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-07 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-07 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":5:{s:10:\"items_sold\";i:0;s:11:\"net_revenue\";d:0;s:12:\"orders_count\";i:0;s:16:\"variations_count\";i:0;s:8:\"segments\";a:0:{}}}i:1;a:6:{s:8:\"interval\";s:7:\"2026-40\";s:10:\"date_start\";s:19:\"2026-10-01 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-01 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-04 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-04 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":5:{s:10:\"items_sold\";i:0;s:11:\"net_revenue\";d:0;s:12:\"orders_count\";i:0;s:16:\"variations_count\";i:0;s:8:\"segments\";a:0:{}}}}s:5:\"total\";i:2;s:5:\"pages\";i:1;s:7:\"page_no\";i:1;}}','off'),
(529,'_transient_timeout_wc_report_orders_stats_97d107a233e53e11858a59ec2b0ab433','1791959518','off'),
(530,'_transient_wc_report_orders_stats_97d107a233e53e11858a59ec2b0ab433','a:2:{s:7:\"version\";s:10:\"1791354717\";s:5:\"value\";O:8:\"stdClass\":5:{s:6:\"totals\";O:8:\"stdClass\":4:{s:11:\"net_revenue\";d:0;s:8:\"products\";i:0;s:13:\"coupons_count\";i:0;s:8:\"segments\";a:0:{}}s:9:\"intervals\";a:7:{i:0;a:6:{s:8:\"interval\";s:10:\"2026-10-01\";s:10:\"date_start\";s:19:\"2026-10-01 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-01 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-01 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-01 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":3:{s:11:\"net_revenue\";d:0;s:13:\"coupons_count\";i:0;s:8:\"segments\";a:0:{}}}i:1;a:6:{s:8:\"interval\";s:10:\"2026-10-02\";s:10:\"date_start\";s:19:\"2026-10-02 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-02 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-02 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-02 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":3:{s:11:\"net_revenue\";d:0;s:13:\"coupons_count\";i:0;s:8:\"segments\";a:0:{}}}i:2;a:6:{s:8:\"interval\";s:10:\"2026-10-03\";s:10:\"date_start\";s:19:\"2026-10-03 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-03 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-03 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-03 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":3:{s:11:\"net_revenue\";d:0;s:13:\"coupons_count\";i:0;s:8:\"segments\";a:0:{}}}i:3;a:6:{s:8:\"interval\";s:10:\"2026-10-04\";s:10:\"date_start\";s:19:\"2026-10-04 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-04 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-04 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-04 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":3:{s:11:\"net_revenue\";d:0;s:13:\"coupons_count\";i:0;s:8:\"segments\";a:0:{}}}i:4;a:6:{s:8:\"interval\";s:10:\"2026-10-05\";s:10:\"date_start\";s:19:\"2026-10-05 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-05 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-05 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-05 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":3:{s:11:\"net_revenue\";d:0;s:13:\"coupons_count\";i:0;s:8:\"segments\";a:0:{}}}i:5;a:6:{s:8:\"interval\";s:10:\"2026-10-06\";s:10:\"date_start\";s:19:\"2026-10-06 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-06 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-06 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-06 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":3:{s:11:\"net_revenue\";d:0;s:13:\"coupons_count\";i:0;s:8:\"segments\";a:0:{}}}i:6;a:6:{s:8:\"interval\";s:10:\"2026-10-07\";s:10:\"date_start\";s:19:\"2026-10-07 00:00:00\";s:14:\"date_start_gmt\";s:19:\"2026-10-07 00:00:00\";s:8:\"date_end\";s:19:\"2026-10-07 23:59:59\";s:12:\"date_end_gmt\";s:19:\"2026-10-07 23:59:59\";s:9:\"subtotals\";O:8:\"stdClass\":3:{s:11:\"net_revenue\";d:0;s:13:\"coupons_count\";i:0;s:8:\"segments\";a:0:{}}}}s:5:\"total\";i:7;s:5:\"pages\";i:1;s:7:\"page_no\";i:1;}}','off'),
(531,'_transient_timeout_wc_low_stock_count','1793946718','off'),
(532,'_transient_wc_low_stock_count','0','off'),
(533,'_transient_timeout_wc_outofstock_count','1793946718','off'),
(534,'_transient_wc_outofstock_count','0','off'),
(545,'category_children','a:0:{}','auto'),
(553,'_transient_timeout_as_is_ensure_recurring_actions_scheduled','1791521646','off'),
(554,'_transient_as_is_ensure_recurring_actions_scheduled','1','off'),
(556,'_transient_timeout__woocommerce_helper_subscriptions','1791518954','off'),
(557,'_transient__woocommerce_helper_subscriptions','a:0:{}','off'),
(558,'_site_transient_timeout_theme_roots','1791519854','off'),
(559,'_site_transient_theme_roots','a:4:{s:18:\"coffee-cafe-corner\";s:7:\"/themes\";s:16:\"twentytwentyfive\";s:7:\"/themes\";s:16:\"twentytwentyfour\";s:7:\"/themes\";s:17:\"twentytwentythree\";s:7:\"/themes\";}','off'),
(560,'_site_transient_update_themes','O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1791518060;s:7:\"checked\";a:4:{s:18:\"coffee-cafe-corner\";s:5:\"0.0.8\";s:16:\"twentytwentyfive\";s:3:\"1.5\";s:16:\"twentytwentyfour\";s:3:\"1.6\";s:17:\"twentytwentythree\";s:3:\"1.7\";}s:8:\"response\";a:1:{s:18:\"coffee-cafe-corner\";a:6:{s:5:\"theme\";s:18:\"coffee-cafe-corner\";s:11:\"new_version\";s:5:\"0.0.9\";s:3:\"url\";s:48:\"https://wordpress.org/themes/coffee-cafe-corner/\";s:7:\"package\";s:66:\"https://downloads.wordpress.org/theme/coffee-cafe-corner.0.0.9.zip\";s:8:\"requires\";s:3:\"6.2\";s:12:\"requires_php\";s:3:\"7.2\";}}s:9:\"no_update\";a:3:{s:16:\"twentytwentyfive\";a:6:{s:5:\"theme\";s:16:\"twentytwentyfive\";s:11:\"new_version\";s:3:\"1.5\";s:3:\"url\";s:46:\"https://wordpress.org/themes/twentytwentyfive/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/theme/twentytwentyfive.1.5.zip\";s:8:\"requires\";s:3:\"6.7\";s:12:\"requires_php\";s:3:\"7.2\";}s:16:\"twentytwentyfour\";a:6:{s:5:\"theme\";s:16:\"twentytwentyfour\";s:11:\"new_version\";s:3:\"1.6\";s:3:\"url\";s:46:\"https://wordpress.org/themes/twentytwentyfour/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/theme/twentytwentyfour.1.6.zip\";s:8:\"requires\";s:3:\"6.4\";s:12:\"requires_php\";s:3:\"7.0\";}s:17:\"twentytwentythree\";a:6:{s:5:\"theme\";s:17:\"twentytwentythree\";s:11:\"new_version\";s:3:\"1.7\";s:3:\"url\";s:47:\"https://wordpress.org/themes/twentytwentythree/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/theme/twentytwentythree.1.7.zip\";s:8:\"requires\";s:3:\"6.1\";s:12:\"requires_php\";s:3:\"5.6\";}}s:12:\"translations\";a:0:{}}','off'),
(561,'_site_transient_update_plugins','O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1791518062;s:8:\"response\";a:1:{s:27:\"woocommerce/woocommerce.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:25:\"w.org/plugins/woocommerce\";s:4:\"slug\";s:11:\"woocommerce\";s:6:\"plugin\";s:27:\"woocommerce/woocommerce.php\";s:11:\"new_version\";s:6:\"11.2.0\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/woocommerce/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/woocommerce.11.2.0.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:56:\"https://ps.w.org/woocommerce/assets/icon.svg?rev=3640790\";s:3:\"svg\";s:56:\"https://ps.w.org/woocommerce/assets/icon.svg?rev=3640790\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/woocommerce/assets/banner-1544x500.png?rev=3640790\";s:2:\"1x\";s:66:\"https://ps.w.org/woocommerce/assets/banner-772x250.png?rev=3640790\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"7.0\";s:6:\"tested\";s:5:\"7.1.3\";s:12:\"requires_php\";s:3:\"7.4\";s:16:\"requires_plugins\";a:0:{}}}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:5:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:5:\"5.7.2\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/akismet.5.7.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:60:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=2818463\";s:2:\"1x\";s:60:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=2818463\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:63:\"https://ps.w.org/akismet/assets/banner-1544x500.png?rev=2900731\";s:2:\"1x\";s:62:\"https://ps.w.org/akismet/assets/banner-772x250.png?rev=2900731\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.8\";}s:25:\"fluentform/fluentform.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:24:\"w.org/plugins/fluentform\";s:4:\"slug\";s:10:\"fluentform\";s:6:\"plugin\";s:25:\"fluentform/fluentform.php\";s:11:\"new_version\";s:6:\"6.2.15\";s:3:\"url\";s:41:\"https://wordpress.org/plugins/fluentform/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/fluentform.6.2.15.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:63:\"https://ps.w.org/fluentform/assets/icon-256x256.png?rev=3354580\";s:2:\"1x\";s:63:\"https://ps.w.org/fluentform/assets/icon-128x128.png?rev=3354580\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:66:\"https://ps.w.org/fluentform/assets/banner-1544x500.png?rev=3354580\";s:2:\"1x\";s:65:\"https://ps.w.org/fluentform/assets/banner-772x250.png?rev=3354580\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.4\";}s:9:\"hello.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/hello-dolly.1.7.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855\";s:2:\"1x\";s:64:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/hello-dolly/assets/banner-1544x500.jpg?rev=2645582\";s:2:\"1x\";s:66:\"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.6\";}s:21:\"mailpoet/mailpoet.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:22:\"w.org/plugins/mailpoet\";s:4:\"slug\";s:8:\"mailpoet\";s:6:\"plugin\";s:21:\"mailpoet/mailpoet.php\";s:11:\"new_version\";s:6:\"5.41.0\";s:3:\"url\";s:39:\"https://wordpress.org/plugins/mailpoet/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/plugin/mailpoet.5.41.0.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:61:\"https://ps.w.org/mailpoet/assets/icon-256x256.png?rev=3284564\";s:2:\"1x\";s:61:\"https://ps.w.org/mailpoet/assets/icon-128x128.png?rev=3284564\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/mailpoet/assets/banner-1544x500.png?rev=3284564\";s:2:\"1x\";s:63:\"https://ps.w.org/mailpoet/assets/banner-772x250.png?rev=3284564\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"7.0\";}s:30:\"seo-by-rank-math/rank-math.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:30:\"w.org/plugins/seo-by-rank-math\";s:4:\"slug\";s:16:\"seo-by-rank-math\";s:6:\"plugin\";s:30:\"seo-by-rank-math/rank-math.php\";s:11:\"new_version\";s:7:\"1.0.280\";s:3:\"url\";s:47:\"https://wordpress.org/plugins/seo-by-rank-math/\";s:7:\"package\";s:67:\"https://downloads.wordpress.org/plugin/seo-by-rank-math.1.0.280.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:61:\"https://ps.w.org/seo-by-rank-math/assets/icon.svg?rev=3438330\";s:3:\"svg\";s:61:\"https://ps.w.org/seo-by-rank-math/assets/icon.svg?rev=3438330\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/seo-by-rank-math/assets/banner-1544x500.png?rev=2639678\";s:2:\"1x\";s:71:\"https://ps.w.org/seo-by-rank-math/assets/banner-772x250.png?rev=2639678\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.7\";}}s:7:\"checked\";a:6:{s:19:\"akismet/akismet.php\";s:5:\"5.7.2\";s:25:\"fluentform/fluentform.php\";s:6:\"6.2.15\";s:9:\"hello.php\";s:5:\"1.7.2\";s:21:\"mailpoet/mailpoet.php\";s:6:\"5.41.0\";s:30:\"seo-by-rank-math/rank-math.php\";s:7:\"1.0.280\";s:27:\"woocommerce/woocommerce.php\";s:6:\"11.1.2\";}}','off'),
(562,'_transient_timeout_woocommerce_marketplace_promotions_v2','1791604463','off'),
(563,'_transient_woocommerce_marketplace_promotions_v2','a:1:{s:6:\"promos\";a:1:{i:0;a:10:{s:2:\"id\";s:18:\"automatewoo-orders\";s:13:\"date_from_gmt\";s:16:\"2026-09-21 00:00\";s:11:\"date_to_gmt\";s:16:\"2026-10-19 00:00\";s:6:\"format\";s:21:\"rule-based-promo-card\";s:5:\"pages\";a:1:{i:0;a:1:{s:4:\"page\";s:9:\"wc-orders\";}}s:5:\"title\";a:1:{s:5:\"en_US\";s:43:\"Recover the sales you\'re losing at checkout\";}s:7:\"content\";a:1:{s:5:\"en_US\";s:164:\"AutomateWoo emails shoppers who leave without paying, thanks the ones who buy, and wins back customers who\'ve gone quiet. Set it up once and it runs on every order.\";}s:9:\"cta_label\";a:1:{s:5:\"en_US\";s:13:\"Recover sales\";}s:8:\"cta_link\";s:113:\"https://woocommerce.com/products/automatewoo/?utm_source=ordersscreen&utm_medium=product&utm_campaign=automatewoo\";s:11:\"local_rules\";a:3:{i:0;a:4:{s:4:\"type\";s:6:\"option\";s:11:\"option_name\";s:26:\"woocommerce_allow_tracking\";s:9:\"operation\";s:1:\"=\";s:5:\"value\";s:3:\"yes\";}i:1;a:3:{s:4:\"type\";s:11:\"order_count\";s:9:\"operation\";s:2:\">=\";s:5:\"value\";i:500;}i:2;a:2:{s:4:\"type\";s:3:\"not\";s:7:\"operand\";a:2:{s:4:\"type\";s:2:\"or\";s:8:\"operands\";a:10:{i:0;a:2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:11:\"automatewoo\";}}i:1;a:2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:29:\"woo-cart-abandonment-recovery\";}}i:2;a:2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:9:\"cartflows\";}}i:3;a:2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:13:\"cartflows-pro\";}}i:4;a:2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:24:\"woo-save-abandoned-carts\";}}i:5;a:2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:26:\"woocommerce-abandoned-cart\";}}i:6;a:2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:16:\"omnisend-connect\";}}i:7;a:2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:25:\"shopmagic-for-woocommerce\";}}i:8;a:2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:24:\"wp-marketing-automations\";}}i:9;a:2:{s:4:\"type\";s:17:\"plugins_activated\";s:7:\"plugins\";a:1:{i:0;s:28:\"wp-marketing-automations-pro\";}}}}}}}}}','off'),
(564,'_transient_timeout_wc_term_counts','1794110063','off'),
(565,'_transient_wc_term_counts','a:0:{}','off'),
(566,'_transient_health-check-site-status-result','{\"good\":18,\"recommended\":9,\"critical\":0}','on'),
(567,'_site_transient_timeout_wp_theme_files_patterns-db89f73a06a1113117bdb547b7bb5760','1791519917','off'),
(568,'_site_transient_wp_theme_files_patterns-db89f73a06a1113117bdb547b7bb5760','a:2:{s:7:\"version\";s:5:\"0.0.8\";s:8:\"patterns\";a:16:{s:7:\"404.php\";a:3:{s:5:\"title\";s:3:\"404\";s:4:\"slug\";s:22:\"coffee-cafe-corner/404\";s:11:\"description\";s:0:\"\";}s:17:\"archive-title.php\";a:4:{s:5:\"title\";s:13:\"Archive Title\";s:4:\"slug\";s:32:\"coffee-cafe-corner/archive-title\";s:11:\"description\";s:0:\"\";s:10:\"categories\";a:2:{i:0;s:18:\"coffee-cafe-corner\";i:1;s:13:\"archive-title\";}}s:11:\"archive.php\";a:3:{s:5:\"title\";s:7:\"Archive\";s:4:\"slug\";s:26:\"coffee-cafe-corner/archive\";s:11:\"description\";s:0:\"\";}s:10:\"footer.php\";a:3:{s:5:\"title\";s:6:\"Footer\";s:4:\"slug\";s:25:\"coffee-cafe-corner/footer\";s:11:\"description\";s:0:\"\";}s:10:\"header.php\";a:5:{s:5:\"title\";s:6:\"Header\";s:4:\"slug\";s:25:\"coffee-cafe-corner/header\";s:11:\"description\";s:0:\"\";s:10:\"categories\";a:1:{i:0;s:6:\"header\";}s:10:\"blockTypes\";a:1:{i:0;s:25:\"core/template-part/header\";}}s:15:\"hero-banner.php\";a:3:{s:5:\"title\";s:11:\"Hero Banner\";s:4:\"slug\";s:30:\"coffee-cafe-corner/hero-banner\";s:11:\"description\";s:0:\"\";}s:17:\"homepage-blog.php\";a:3:{s:5:\"title\";s:13:\"Homepage Blog\";s:4:\"slug\";s:32:\"coffee-cafe-corner/homepage-blog\";s:11:\"description\";s:0:\"\";}s:22:\"index-header-image.php\";a:4:{s:5:\"title\";s:18:\"Index Header Image\";s:4:\"slug\";s:37:\"coffee-cafe-corner/index-header-image\";s:11:\"description\";s:0:\"\";s:10:\"categories\";a:2:{i:0;s:18:\"coffee-cafe-corner\";i:1;s:18:\"index-header-image\";}}s:9:\"index.php\";a:3:{s:5:\"title\";s:5:\"Index\";s:4:\"slug\";s:24:\"coffee-cafe-corner/index\";s:11:\"description\";s:0:\"\";}s:14:\"page-title.php\";a:4:{s:5:\"title\";s:10:\"Page Title\";s:4:\"slug\";s:29:\"coffee-cafe-corner/page-title\";s:11:\"description\";s:0:\"\";s:10:\"categories\";a:2:{i:0;s:18:\"coffee-cafe-corner\";i:1;s:10:\"page-title\";}}s:17:\"search-result.php\";a:4:{s:5:\"title\";s:13:\"Search Result\";s:4:\"slug\";s:32:\"coffee-cafe-corner/search-result\";s:11:\"description\";s:0:\"\";s:10:\"categories\";a:2:{i:0;s:18:\"coffee-cafe-corner\";i:1;s:13:\"search-result\";}}s:10:\"search.php\";a:3:{s:5:\"title\";s:6:\"Search\";s:4:\"slug\";s:25:\"coffee-cafe-corner/search\";s:11:\"description\";s:0:\"\";}s:12:\"services.php\";a:3:{s:5:\"title\";s:8:\"Services\";s:4:\"slug\";s:27:\"coffee-cafe-corner/services\";s:11:\"description\";s:0:\"\";}s:11:\"sidebar.php\";a:3:{s:5:\"title\";s:7:\"Sidebar\";s:4:\"slug\";s:26:\"coffee-cafe-corner/sidebar\";s:11:\"description\";s:0:\"\";}s:28:\"single-post-left-sidebar.php\";a:3:{s:5:\"title\";s:24:\"Single Post Left Sidebar\";s:4:\"slug\";s:43:\"coffee-cafe-corner/single-post-left-sidebar\";s:11:\"description\";s:0:\"\";}s:10:\"single.php\";a:3:{s:5:\"title\";s:6:\"Single\";s:4:\"slug\";s:25:\"coffee-cafe-corner/single\";s:11:\"description\";s:0:\"\";}}}','off'),
(569,'_transient_doing_cron','1791518420.1201701164245605468750','on'),
(570,'footer_brand_name','QUILLS COFFEE','yes'),
(571,'footer_address_street','800 E Main Street','yes'),
(572,'footer_address_city','Louisville, KY 40206','yes'),
(573,'footer_phone','502-861-5844','yes'),
(574,'footer_email','hello@quillscoffee.com','yes'),
(575,'footer_currency','USD','yes'),
(576,'footer_lang','EN','yes'),
(577,'footer_social_facebook','https://facebook.com/','yes'),
(578,'footer_social_instagram','https://instagram.com/','yes'),
(579,'footer_copyright','© 2026, Quills Coffee . Website by Cronk Studios','yes'),
(580,'_transient_product_query-transient-version','1791518418','on'),
(581,'coffee_cafe_corner_menus_seeded','1','auto');
/*!40000 ALTER TABLE `wp_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_postmeta`
--

LOCK TABLES `wp_postmeta` WRITE;
/*!40000 ALTER TABLE `wp_postmeta` DISABLE KEYS */;
INSERT INTO `wp_postmeta` VALUES
(1,2,'_wp_page_template','default'),
(2,3,'_wp_page_template','default'),
(3,6,'_wp_attached_file','woocommerce-placeholder.webp'),
(4,6,'_wp_attachment_metadata','a:6:{s:5:\"width\";i:1200;s:6:\"height\";i:1200;s:4:\"file\";s:28:\"woocommerce-placeholder.webp\";s:8:\"filesize\";i:9892;s:5:\"sizes\";a:4:{s:6:\"medium\";a:5:{s:4:\"file\";s:36:\"woocommerce-placeholder-300x300.webp\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/webp\";s:8:\"filesize\";i:1760;}s:5:\"large\";a:5:{s:4:\"file\";s:38:\"woocommerce-placeholder-1024x1024.webp\";s:5:\"width\";i:1024;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/webp\";s:8:\"filesize\";i:6324;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:36:\"woocommerce-placeholder-150x150.webp\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/webp\";s:8:\"filesize\";i:1082;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:36:\"woocommerce-placeholder-768x768.webp\";s:5:\"width\";i:768;s:6:\"height\";i:768;s:9:\"mime-type\";s:10:\"image/webp\";s:8:\"filesize\";i:4394;}}s:10:\"image_meta\";a:13:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}s:3:\"alt\";s:0:\"\";}}'),
(5,7,'rank_math_internal_links_processed','1'),
(6,8,'rank_math_internal_links_processed','1'),
(7,9,'rank_math_internal_links_processed','1'),
(8,10,'rank_math_internal_links_processed','1'),
(9,11,'rank_math_internal_links_processed','1'),
(10,2,'rank_math_internal_links_processed','1'),
(11,1,'rank_math_internal_links_processed','1'),
(12,12,'_menu_item_type','custom'),
(13,12,'_menu_item_menu_item_parent','0'),
(14,12,'_menu_item_object_id','12'),
(15,12,'_menu_item_object','custom'),
(16,12,'_menu_item_target',''),
(17,12,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(18,12,'_menu_item_xfn',''),
(19,12,'_menu_item_url','http://localhost:8000/'),
(20,13,'_menu_item_type','custom'),
(21,13,'_menu_item_menu_item_parent','0'),
(22,13,'_menu_item_object_id','13'),
(23,13,'_menu_item_object','custom'),
(24,13,'_menu_item_target',''),
(25,13,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(26,13,'_menu_item_xfn',''),
(27,13,'_menu_item_url','http://localhost:8000/about-us/'),
(28,14,'_menu_item_type','custom'),
(29,14,'_menu_item_menu_item_parent','0'),
(30,14,'_menu_item_object_id','14'),
(31,14,'_menu_item_object','custom'),
(32,14,'_menu_item_target',''),
(33,14,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(34,14,'_menu_item_xfn',''),
(35,14,'_menu_item_url','mailto:hello@quillscoffee.com'),
(36,15,'_menu_item_type','custom'),
(37,15,'_menu_item_menu_item_parent','0'),
(38,15,'_menu_item_object_id','15'),
(39,15,'_menu_item_object','custom'),
(40,15,'_menu_item_target',''),
(41,15,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(42,15,'_menu_item_xfn',''),
(43,15,'_menu_item_url','http://localhost:8000/barista-application/'),
(44,16,'_menu_item_type','custom'),
(45,16,'_menu_item_menu_item_parent','0'),
(46,16,'_menu_item_object_id','16'),
(47,16,'_menu_item_object','custom'),
(48,16,'_menu_item_target',''),
(49,16,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(50,16,'_menu_item_xfn',''),
(51,16,'_menu_item_url','http://localhost:8000/terms-of-service/'),
(52,17,'_menu_item_type','custom'),
(53,17,'_menu_item_menu_item_parent','0'),
(54,17,'_menu_item_object_id','17'),
(55,17,'_menu_item_object','custom'),
(56,17,'_menu_item_target',''),
(57,17,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(58,17,'_menu_item_xfn',''),
(59,17,'_menu_item_url','http://localhost:8000/refund-policy/'),
(60,18,'_menu_item_type','custom'),
(61,18,'_menu_item_menu_item_parent','0'),
(62,18,'_menu_item_object_id','18'),
(63,18,'_menu_item_object','custom'),
(64,18,'_menu_item_target',''),
(65,18,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(66,18,'_menu_item_xfn',''),
(67,18,'_menu_item_url','http://localhost:8000/coffee/'),
(68,19,'_menu_item_type','custom'),
(69,19,'_menu_item_menu_item_parent','0'),
(70,19,'_menu_item_object_id','19'),
(71,19,'_menu_item_object','custom'),
(72,19,'_menu_item_target',''),
(73,19,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(74,19,'_menu_item_xfn',''),
(75,19,'_menu_item_url','http://localhost:8000/subscriptions/'),
(76,20,'_menu_item_type','custom'),
(77,20,'_menu_item_menu_item_parent','0'),
(78,20,'_menu_item_object_id','20'),
(79,20,'_menu_item_object','custom'),
(80,20,'_menu_item_target',''),
(81,20,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(82,20,'_menu_item_xfn',''),
(83,20,'_menu_item_url','http://localhost:8000/brew-gear/'),
(84,21,'_menu_item_type','custom'),
(85,21,'_menu_item_menu_item_parent','0'),
(86,21,'_menu_item_object_id','21'),
(87,21,'_menu_item_object','custom'),
(88,21,'_menu_item_target',''),
(89,21,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(90,21,'_menu_item_xfn',''),
(91,21,'_menu_item_url','http://localhost:8000/merch/'),
(92,22,'_menu_item_type','custom'),
(93,22,'_menu_item_menu_item_parent','0'),
(94,22,'_menu_item_object_id','22'),
(95,22,'_menu_item_object','custom'),
(96,22,'_menu_item_target',''),
(97,22,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(98,22,'_menu_item_xfn',''),
(99,22,'_menu_item_url','http://localhost:8000/gift-cards/'),
(100,23,'_menu_item_type','custom'),
(101,23,'_menu_item_menu_item_parent','0'),
(102,23,'_menu_item_object_id','23'),
(103,23,'_menu_item_object','custom'),
(104,23,'_menu_item_target',''),
(105,23,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(106,23,'_menu_item_xfn',''),
(107,23,'_menu_item_url','http://localhost:8000/visit/'),
(108,24,'_menu_item_type','custom'),
(109,24,'_menu_item_menu_item_parent','0'),
(110,24,'_menu_item_object_id','24'),
(111,24,'_menu_item_object','custom'),
(112,24,'_menu_item_target',''),
(113,24,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),
(114,24,'_menu_item_xfn',''),
(115,24,'_menu_item_url','http://localhost:8000/about/');
/*!40000 ALTER TABLE `wp_postmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT 0,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(255) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT 0,
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`),
  KEY `type_status_author` (`post_type`,`post_status`,`post_author`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_posts`
--

LOCK TABLES `wp_posts` WRITE;
/*!40000 ALTER TABLE `wp_posts` DISABLE KEYS */;
INSERT INTO `wp_posts` VALUES
(1,1,'2026-10-07 00:26:01','2026-10-07 00:26:01','<!-- wp:paragraph -->\n<p>Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>\n<!-- /wp:paragraph -->','Hello world!','','publish','open','open','','hello-world','','','2026-10-07 00:26:01','2026-10-07 00:26:01','',0,'http://localhost:8000/?p=1',0,'post','',1),
(2,1,'2026-10-07 00:26:01','2026-10-07 00:26:01','<!-- wp:paragraph -->\n<p>This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\">\n<!-- wp:paragraph -->\n<p>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin\' caught in the rain.)</p>\n<!-- /wp:paragraph -->\n</blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>...or something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\">\n<!-- wp:paragraph -->\n<p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p>\n<!-- /wp:paragraph -->\n</blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>As a new WordPress user, you should go to <a href=\"http://localhost:8000/wp-admin/\">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>\n<!-- /wp:paragraph -->','Sample Page','','publish','closed','open','','sample-page','','','2026-10-07 00:26:01','2026-10-07 00:26:01','',0,'http://localhost:8000/?page_id=2',0,'page','',0),
(3,1,'2026-10-07 00:26:01','2026-10-07 00:26:01','<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Who we are</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Our website address is: http://localhost:8000.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Comments</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Media</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Cookies</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>If you visit our login page, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Embedded content from other websites</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Who we share your data with</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you request a password reset, your IP address will be included in the reset email.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">How long we retain your data</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">What rights you have over your data</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Where your data is sent</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Visitor comments may be checked through an automated spam detection service.</p>\n<!-- /wp:paragraph -->\n','Privacy Policy','','draft','closed','open','','privacy-policy','','','2026-10-07 00:26:01','2026-10-07 00:26:01','',0,'http://localhost:8000/?page_id=3',0,'page','',0),
(4,1,'2026-10-07 00:26:35','0000-00-00 00:00:00','','Auto Draft','','auto-draft','open','open','','','','','2026-10-07 00:26:35','0000-00-00 00:00:00','',0,'http://localhost:8000/?p=4',0,'post','',0),
(5,1,'2026-10-07 01:09:12','2026-10-07 01:09:12','<!-- wp:page-list /-->','Navigation','','publish','closed','closed','','navigation','','','2026-10-07 01:09:12','2026-10-07 01:09:12','',0,'http://localhost:8000/?p=5',0,'wp_navigation','',0),
(6,1,'2026-10-07 02:51:51','2026-10-07 02:51:51','','woocommerce-placeholder','','inherit','open','closed','','woocommerce-placeholder','','','2026-10-07 02:51:51','2026-10-07 02:51:51','',0,'http://localhost:8000/wp-content/uploads/2026/10/woocommerce-placeholder.webp',0,'attachment','image/webp',0),
(7,1,'2026-10-07 02:51:52','2026-10-07 02:51:52','','Shop','','publish','closed','closed','','shop','','','2026-10-07 02:51:52','2026-10-07 02:51:52','',0,'http://localhost:8000/?page_id=7',0,'page','',0),
(8,1,'2026-10-07 02:51:53','2026-10-07 02:51:53','<!-- wp:woocommerce/cart -->\n<div class=\"wp-block-woocommerce-cart alignwide is-loading\"><!-- wp:woocommerce/filled-cart-block -->\n<div class=\"wp-block-woocommerce-filled-cart-block\"><!-- wp:woocommerce/cart-items-block -->\n<div class=\"wp-block-woocommerce-cart-items-block\"><!-- wp:woocommerce/cart-line-items-block -->\n<div class=\"wp-block-woocommerce-cart-line-items-block\"></div>\n<!-- /wp:woocommerce/cart-line-items-block -->\n\n<!-- wp:woocommerce/product-collection {\"queryId\":0,\"query\":{\"perPage\":3,\"pages\":1,\"offset\":0,\"postType\":\"product\",\"order\":\"asc\",\"orderBy\":\"title\",\"search\":\"\",\"exclude\":[],\"inherit\":false,\"taxQuery\":{},\"isProductCollectionBlock\":true,\"featured\":false,\"woocommerceOnSale\":false,\"woocommerceStockStatus\":[\"instock\",\"outofstock\",\"onbackorder\"],\"woocommerceAttributes\":[],\"woocommerceHandPickedProducts\":[],\"filterable\":false,\"relatedBy\":{\"categories\":true,\"tags\":true}},\"tagName\":\"div\",\"displayLayout\":{\"type\":\"flex\",\"columns\":3,\"shrinkColumns\":true},\"dimensions\":{\"widthType\":\"fill\"},\"collection\":\"woocommerce/product-collection/cross-sells\",\"hideControls\":[\"filterable\"],\"queryContextIncludes\":[\"collection\"]} -->\n<div class=\"wp-block-woocommerce-product-collection\"><!-- wp:heading {\"textAlign\":\"left\",\"style\":{\"spacing\":{\"margin\":{\"bottom\":\"1rem\"}}}} -->\n<h2 class=\"wp-block-heading has-text-align-left\" style=\"margin-bottom:1rem\">You may be interested in&hellip;</h2>\n\n<!-- /wp:heading -->\n\n<!-- wp:woocommerce/product-template -->\n<!-- wp:woocommerce/product-image {\"showSaleBadge\":false,\"imageSizing\":\"thumbnail\",\"isDescendentOfQueryLoop\":true} -->\n<!-- wp:woocommerce/product-sale-badge {\"align\":\"right\"} /-->\n<!-- /wp:woocommerce/product-image -->\n\n<!-- wp:post-title {\"textAlign\":\"center\",\"isLink\":true,\"style\":{\"spacing\":{\"margin\":{\"bottom\":\"0.75rem\",\"top\":\"0\"}},\"typography\":{\"lineHeight\":\"1.4\"}},\"fontSize\":\"medium\",\"__woocommerceNamespace\":\"woocommerce/product-collection/product-title\"} /-->\n\n<!-- wp:woocommerce/product-price {\"isDescendentOfQueryLoop\":true,\"textAlign\":\"center\",\"fontSize\":\"small\"} /-->\n\n<!-- wp:woocommerce/product-button {\"textAlign\":\"center\",\"isDescendentOfQueryLoop\":true,\"fontSize\":\"small\"} /-->\n<!-- /wp:woocommerce/product-template --></div>\n<!-- /wp:woocommerce/product-collection --></div>\n\n<!-- /wp:woocommerce/cart-items-block -->\n\n<!-- wp:woocommerce/cart-totals-block -->\n<div class=\"wp-block-woocommerce-cart-totals-block\"><!-- wp:woocommerce/cart-order-summary-block -->\n<div class=\"wp-block-woocommerce-cart-order-summary-block\"><!-- wp:woocommerce/cart-order-summary-heading-block -->\n<div class=\"wp-block-woocommerce-cart-order-summary-heading-block\"></div>\n<!-- /wp:woocommerce/cart-order-summary-heading-block -->\n\n<!-- wp:woocommerce/cart-order-summary-coupon-form-block -->\n<div class=\"wp-block-woocommerce-cart-order-summary-coupon-form-block\"></div>\n<!-- /wp:woocommerce/cart-order-summary-coupon-form-block -->\n\n<!-- wp:woocommerce/cart-order-summary-subtotal-block -->\n<div class=\"wp-block-woocommerce-cart-order-summary-subtotal-block\"></div>\n<!-- /wp:woocommerce/cart-order-summary-subtotal-block -->\n\n<!-- wp:woocommerce/cart-order-summary-fee-block -->\n<div class=\"wp-block-woocommerce-cart-order-summary-fee-block\"></div>\n<!-- /wp:woocommerce/cart-order-summary-fee-block -->\n\n<!-- wp:woocommerce/cart-order-summary-discount-block -->\n<div class=\"wp-block-woocommerce-cart-order-summary-discount-block\"></div>\n<!-- /wp:woocommerce/cart-order-summary-discount-block -->\n\n<!-- wp:woocommerce/cart-order-summary-shipping-block -->\n<div class=\"wp-block-woocommerce-cart-order-summary-shipping-block\"></div>\n<!-- /wp:woocommerce/cart-order-summary-shipping-block -->\n\n<!-- wp:woocommerce/cart-order-summary-taxes-block -->\n<div class=\"wp-block-woocommerce-cart-order-summary-taxes-block\"></div>\n<!-- /wp:woocommerce/cart-order-summary-taxes-block --></div>\n<!-- /wp:woocommerce/cart-order-summary-block -->\n\n<!-- wp:woocommerce/cart-express-payment-block -->\n<div class=\"wp-block-woocommerce-cart-express-payment-block\"></div>\n<!-- /wp:woocommerce/cart-express-payment-block -->\n\n<!-- wp:woocommerce/proceed-to-checkout-block -->\n<div class=\"wp-block-woocommerce-proceed-to-checkout-block\"></div>\n<!-- /wp:woocommerce/proceed-to-checkout-block -->\n\n<!-- wp:woocommerce/cart-accepted-payment-methods-block -->\n<div class=\"wp-block-woocommerce-cart-accepted-payment-methods-block\"></div>\n<!-- /wp:woocommerce/cart-accepted-payment-methods-block --></div>\n<!-- /wp:woocommerce/cart-totals-block --></div>\n<!-- /wp:woocommerce/filled-cart-block -->\n\n<!-- wp:woocommerce/empty-cart-block -->\n<div class=\"wp-block-woocommerce-empty-cart-block\"><!-- wp:heading {\"textAlign\":\"center\",\"className\":\"with-empty-cart-icon wc-block-cart__empty-cart__title\"} -->\n<h2 class=\"wp-block-heading has-text-align-center with-empty-cart-icon wc-block-cart__empty-cart__title\">Your cart is currently empty!</h2>\n<!-- /wp:heading -->\n\n<!-- wp:separator {\"className\":\"is-style-dots\"} -->\n<hr class=\"wp-block-separator has-alpha-channel-opacity is-style-dots\"/>\n<!-- /wp:separator -->\n\n<!-- wp:heading {\"textAlign\":\"center\"} -->\n<h2 class=\"wp-block-heading has-text-align-center\">New in store</h2>\n<!-- /wp:heading -->\n\n<!-- wp:woocommerce/product-new {\"columns\":4,\"rows\":1} /--></div>\n<!-- /wp:woocommerce/empty-cart-block --></div>\n<!-- /wp:woocommerce/cart -->','Cart','','publish','closed','closed','','cart','','','2026-10-07 02:51:53','2026-10-07 02:51:53','',0,'http://localhost:8000/?page_id=8',0,'page','',0),
(9,1,'2026-10-07 02:51:54','2026-10-07 02:51:54','<!-- wp:woocommerce/checkout -->\n<div class=\"wp-block-woocommerce-checkout alignwide wc-block-checkout is-loading\"><!-- wp:woocommerce/checkout-fields-block -->\n<div class=\"wp-block-woocommerce-checkout-fields-block\"><!-- wp:woocommerce/checkout-express-payment-block -->\n<div class=\"wp-block-woocommerce-checkout-express-payment-block\"></div>\n<!-- /wp:woocommerce/checkout-express-payment-block -->\n\n<!-- wp:woocommerce/checkout-contact-information-block -->\n<div class=\"wp-block-woocommerce-checkout-contact-information-block\"></div>\n<!-- /wp:woocommerce/checkout-contact-information-block -->\n\n<!-- wp:woocommerce/checkout-shipping-method-block -->\n<div class=\"wp-block-woocommerce-checkout-shipping-method-block\"></div>\n<!-- /wp:woocommerce/checkout-shipping-method-block -->\n\n<!-- wp:woocommerce/checkout-pickup-options-block -->\n<div class=\"wp-block-woocommerce-checkout-pickup-options-block\"></div>\n<!-- /wp:woocommerce/checkout-pickup-options-block -->\n\n<!-- wp:woocommerce/checkout-shipping-address-block -->\n<div class=\"wp-block-woocommerce-checkout-shipping-address-block\"></div>\n<!-- /wp:woocommerce/checkout-shipping-address-block -->\n\n<!-- wp:woocommerce/checkout-billing-address-block -->\n<div class=\"wp-block-woocommerce-checkout-billing-address-block\"></div>\n<!-- /wp:woocommerce/checkout-billing-address-block -->\n\n<!-- wp:woocommerce/checkout-shipping-methods-block -->\n<div class=\"wp-block-woocommerce-checkout-shipping-methods-block\"></div>\n<!-- /wp:woocommerce/checkout-shipping-methods-block -->\n\n<!-- wp:woocommerce/checkout-payment-block -->\n<div class=\"wp-block-woocommerce-checkout-payment-block\"></div>\n<!-- /wp:woocommerce/checkout-payment-block -->\n\n<!-- wp:woocommerce/checkout-additional-information-block -->\n<div class=\"wp-block-woocommerce-checkout-additional-information-block\"></div>\n<!-- /wp:woocommerce/checkout-additional-information-block -->\n\n<!-- wp:woocommerce/checkout-order-note-block -->\n<div class=\"wp-block-woocommerce-checkout-order-note-block\"></div>\n<!-- /wp:woocommerce/checkout-order-note-block -->\n\n<!-- wp:woocommerce/checkout-terms-block -->\n<div class=\"wp-block-woocommerce-checkout-terms-block\"></div>\n<!-- /wp:woocommerce/checkout-terms-block -->\n\n<!-- wp:woocommerce/checkout-actions-block -->\n<div class=\"wp-block-woocommerce-checkout-actions-block\"></div>\n<!-- /wp:woocommerce/checkout-actions-block --></div>\n<!-- /wp:woocommerce/checkout-fields-block -->\n\n<!-- wp:woocommerce/checkout-totals-block -->\n<div class=\"wp-block-woocommerce-checkout-totals-block\"><!-- wp:woocommerce/checkout-order-summary-block -->\n<div class=\"wp-block-woocommerce-checkout-order-summary-block\"><!-- wp:woocommerce/checkout-order-summary-cart-items-block -->\n<div class=\"wp-block-woocommerce-checkout-order-summary-cart-items-block\"></div>\n<!-- /wp:woocommerce/checkout-order-summary-cart-items-block -->\n\n<!-- wp:woocommerce/checkout-order-summary-coupon-form-block -->\n<div class=\"wp-block-woocommerce-checkout-order-summary-coupon-form-block\"></div>\n<!-- /wp:woocommerce/checkout-order-summary-coupon-form-block -->\n\n<!-- wp:woocommerce/checkout-order-summary-subtotal-block -->\n<div class=\"wp-block-woocommerce-checkout-order-summary-subtotal-block\"></div>\n<!-- /wp:woocommerce/checkout-order-summary-subtotal-block -->\n\n<!-- wp:woocommerce/checkout-order-summary-fee-block -->\n<div class=\"wp-block-woocommerce-checkout-order-summary-fee-block\"></div>\n<!-- /wp:woocommerce/checkout-order-summary-fee-block -->\n\n<!-- wp:woocommerce/checkout-order-summary-discount-block -->\n<div class=\"wp-block-woocommerce-checkout-order-summary-discount-block\"></div>\n<!-- /wp:woocommerce/checkout-order-summary-discount-block -->\n\n<!-- wp:woocommerce/checkout-order-summary-shipping-block -->\n<div class=\"wp-block-woocommerce-checkout-order-summary-shipping-block\"></div>\n<!-- /wp:woocommerce/checkout-order-summary-shipping-block -->\n\n<!-- wp:woocommerce/checkout-order-summary-taxes-block -->\n<div class=\"wp-block-woocommerce-checkout-order-summary-taxes-block\"></div>\n<!-- /wp:woocommerce/checkout-order-summary-taxes-block --></div>\n<!-- /wp:woocommerce/checkout-order-summary-block --></div>\n<!-- /wp:woocommerce/checkout-totals-block --></div>\n<!-- /wp:woocommerce/checkout -->','Checkout','','publish','closed','closed','','checkout','','','2026-10-07 02:51:54','2026-10-07 02:51:54','',0,'http://localhost:8000/?page_id=9',0,'page','',0),
(10,1,'2026-10-07 02:51:54','2026-10-07 02:51:54','<!-- wp:shortcode -->[woocommerce_my_account]<!-- /wp:shortcode -->','My account','','publish','closed','closed','','my-account','','','2026-10-07 02:51:54','2026-10-07 02:51:54','',0,'http://localhost:8000/?page_id=10',0,'page','',0),
(11,1,'2026-10-07 02:51:55','0000-00-00 00:00:00','<!-- wp:paragraph -->\n<p><b>This is a sample page.</b></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Overview</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Our refund and returns policy lasts 30 days. If 30 days have passed since your purchase, we can’t offer you a full refund or exchange.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>To be eligible for a return, your item must be unused and in the same condition that you received it. It must also be in the original packaging.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Several types of goods are exempt from being returned. Perishable goods such as food, flowers, newspapers or magazines cannot be returned. We also do not accept products that are intimate or sanitary goods, hazardous materials, or flammable liquids or gases.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Additional non-returnable items:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:list -->\n<ul>\n<li>Gift cards</li>\n<li>Downloadable software products</li>\n<li>Some health and personal care items</li>\n</ul>\n<!-- /wp:list -->\n\n<!-- wp:paragraph -->\n<p>To complete your return, we require a receipt or proof of purchase.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Please do not send your purchase back to the manufacturer.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>There are certain situations where only partial refunds are granted:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:list -->\n<ul>\n<li>Book with obvious signs of use</li>\n<li>CD, DVD, VHS tape, software, video game, cassette tape, or vinyl record that has been opened.</li>\n<li>Any item not in its original condition, is damaged or missing parts for reasons not due to our error.</li>\n<li>Any item that is returned more than 30 days after delivery</li>\n</ul>\n<!-- /wp:list -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Refunds</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Once your return is received and inspected, we will send you an email to notify you that we have received your returned item. We will also notify you of the approval or rejection of your refund.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>If you are approved, then your refund will be processed, and a credit will automatically be applied to your credit card or original method of payment, within a certain amount of days.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"level\":3} -->\n<h3 class=\"wp-block-heading\">Late or missing refunds</h3>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>If you haven’t received a refund yet, first check your bank account again.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Then contact your credit card company, it may take some time before your refund is officially posted.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Next contact your bank. There is often some processing time before a refund is posted.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>If you’ve done all of this and you still have not received your refund yet, please contact us at {email address}.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"level\":3} -->\n<h3 class=\"wp-block-heading\">Sale items</h3>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Only regular priced items may be refunded. Sale items cannot be refunded.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Exchanges</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>We only replace items if they are defective or damaged. If you need to exchange it for the same item, send us an email at {email address} and send your item to: {physical address}.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Gifts</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>If the item was marked as a gift when purchased and shipped directly to you, you’ll receive a gift credit for the value of your return. Once the returned item is received, a gift certificate will be mailed to you.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>If the item wasn’t marked as a gift when purchased, or the gift giver had the order shipped to themselves to give to you later, we will send a refund to the gift giver and they will find out about your return.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Shipping returns</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>To return your product, you should mail your product to: {physical address}.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>You will be responsible for paying for your own shipping costs for returning your item. Shipping costs are non-refundable. If you receive a refund, the cost of return shipping will be deducted from your refund.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Depending on where you live, the time it may take for your exchanged product to reach you may vary.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>If you are returning more expensive items, you may consider using a trackable shipping service or purchasing shipping insurance. We don’t guarantee that we will receive your returned item.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Need help?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>Contact us at {email} for questions related to refunds and returns.</p>\n<!-- /wp:paragraph -->','Refund and Returns Policy','','draft','closed','closed','','refund_returns','','','2026-10-07 02:51:55','0000-00-00 00:00:00','',0,'http://localhost:8000/?page_id=11',0,'page','',0),
(12,0,'2026-10-09 04:00:17','2026-10-09 04:00:17','','Home','','publish','closed','closed','','home','','','2026-10-09 04:00:17','2026-10-09 04:00:17','',0,'http://localhost:8000/?p=12',1,'nav_menu_item','',0),
(13,0,'2026-10-09 04:00:17','2026-10-09 04:00:17','','About Us','','publish','closed','closed','','about-us','','','2026-10-09 04:00:17','2026-10-09 04:00:17','',0,'http://localhost:8000/?p=13',2,'nav_menu_item','',0),
(14,0,'2026-10-09 04:00:18','2026-10-09 04:00:18','','Email Us','','publish','closed','closed','','email-us','','','2026-10-09 04:00:18','2026-10-09 04:00:18','',0,'http://localhost:8000/?p=14',3,'nav_menu_item','',0),
(15,0,'2026-10-09 04:00:18','2026-10-09 04:00:18','','Barista Application','','publish','closed','closed','','barista-application','','','2026-10-09 04:00:18','2026-10-09 04:00:18','',0,'http://localhost:8000/?p=15',4,'nav_menu_item','',0),
(16,0,'2026-10-09 04:00:18','2026-10-09 04:00:18','','Terms of Service','','publish','closed','closed','','terms-of-service','','','2026-10-09 04:00:18','2026-10-09 04:00:18','',0,'http://localhost:8000/?p=16',5,'nav_menu_item','',0),
(17,0,'2026-10-09 04:00:18','2026-10-09 04:00:18','','Refund policy','','publish','closed','closed','','refund-policy','','','2026-10-09 04:00:18','2026-10-09 04:00:18','',0,'http://localhost:8000/?p=17',6,'nav_menu_item','',0),
(18,0,'2026-10-09 04:00:18','2026-10-09 04:00:18','','Coffee','','publish','closed','closed','','coffee','','','2026-10-09 04:00:18','2026-10-09 04:00:18','',0,'http://localhost:8000/?p=18',1,'nav_menu_item','',0),
(19,0,'2026-10-09 04:00:18','2026-10-09 04:00:18','','Subscriptions','','publish','closed','closed','','subscriptions','','','2026-10-09 04:00:18','2026-10-09 04:00:18','',0,'http://localhost:8000/?p=19',2,'nav_menu_item','',0),
(20,0,'2026-10-09 04:00:18','2026-10-09 04:00:18','','Brew Gear','','publish','closed','closed','','brew-gear','','','2026-10-09 04:00:18','2026-10-09 04:00:18','',0,'http://localhost:8000/?p=20',3,'nav_menu_item','',0),
(21,0,'2026-10-09 04:00:18','2026-10-09 04:00:18','','Merch','','publish','closed','closed','','merch','','','2026-10-09 04:00:18','2026-10-09 04:00:18','',0,'http://localhost:8000/?p=21',4,'nav_menu_item','',0),
(22,0,'2026-10-09 04:00:18','2026-10-09 04:00:18','','Gift Cards','','publish','closed','closed','','gift-cards','','','2026-10-09 04:00:18','2026-10-09 04:00:18','',0,'http://localhost:8000/?p=22',5,'nav_menu_item','',0),
(23,0,'2026-10-09 04:00:18','2026-10-09 04:00:18','','Visit','','publish','closed','closed','','visit','','','2026-10-09 04:00:18','2026-10-09 04:00:18','',0,'http://localhost:8000/?p=23',6,'nav_menu_item','',0),
(24,0,'2026-10-09 04:00:18','2026-10-09 04:00:18','','About','','publish','closed','closed','','about','','','2026-10-09 04:00:18','2026-10-09 04:00:18','',0,'http://localhost:8000/?p=24',7,'nav_menu_item','',0);
/*!40000 ALTER TABLE `wp_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_rank_math_internal_links`
--

DROP TABLE IF EXISTS `wp_rank_math_internal_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_rank_math_internal_links` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  `target_post_id` bigint(20) unsigned NOT NULL,
  `type` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `link_direction` (`post_id`,`type`),
  KEY `target_post_id` (`target_post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_rank_math_internal_links`
--

LOCK TABLES `wp_rank_math_internal_links` WRITE;
/*!40000 ALTER TABLE `wp_rank_math_internal_links` DISABLE KEYS */;
INSERT INTO `wp_rank_math_internal_links` VALUES
(1,'http://localhost:8000/wp-admin/',2,0,'external');
/*!40000 ALTER TABLE `wp_rank_math_internal_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_rank_math_internal_meta`
--

DROP TABLE IF EXISTS `wp_rank_math_internal_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_rank_math_internal_meta` (
  `object_id` bigint(20) unsigned NOT NULL,
  `internal_link_count` int(10) unsigned DEFAULT 0,
  `external_link_count` int(10) unsigned DEFAULT 0,
  `incoming_link_count` int(10) unsigned DEFAULT 0,
  PRIMARY KEY (`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_rank_math_internal_meta`
--

LOCK TABLES `wp_rank_math_internal_meta` WRITE;
/*!40000 ALTER TABLE `wp_rank_math_internal_meta` DISABLE KEYS */;
INSERT INTO `wp_rank_math_internal_meta` VALUES
(1,0,0,0),
(2,0,1,0),
(7,0,0,0),
(8,0,0,0),
(9,0,0,0),
(10,0,0,0),
(11,0,0,0);
/*!40000 ALTER TABLE `wp_rank_math_internal_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_term_relationships`
--

DROP TABLE IF EXISTS `wp_term_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_term_relationships`
--

LOCK TABLES `wp_term_relationships` WRITE;
/*!40000 ALTER TABLE `wp_term_relationships` DISABLE KEYS */;
INSERT INTO `wp_term_relationships` VALUES
(1,1,0),
(12,16,0),
(13,16,0),
(14,16,0),
(15,16,0),
(16,16,0),
(17,16,0),
(18,17,0),
(19,17,0),
(20,17,0),
(21,17,0),
(22,17,0),
(23,17,0),
(24,17,0);
/*!40000 ALTER TABLE `wp_term_relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_term_taxonomy`
--

LOCK TABLES `wp_term_taxonomy` WRITE;
/*!40000 ALTER TABLE `wp_term_taxonomy` DISABLE KEYS */;
INSERT INTO `wp_term_taxonomy` VALUES
(1,1,'category','',0,1),
(2,2,'product_type','',0,0),
(3,3,'product_type','',0,0),
(4,4,'product_type','',0,0),
(5,5,'product_type','',0,0),
(6,6,'product_visibility','',0,0),
(7,7,'product_visibility','',0,0),
(8,8,'product_visibility','',0,0),
(9,9,'product_visibility','',0,0),
(10,10,'product_visibility','',0,0),
(11,11,'product_visibility','',0,0),
(12,12,'product_visibility','',0,0),
(13,13,'product_visibility','',0,0),
(14,14,'product_visibility','',0,0),
(15,15,'product_cat','',0,0),
(16,16,'nav_menu','',0,6),
(17,17,'nav_menu','',0,7);
/*!40000 ALTER TABLE `wp_term_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_termmeta`
--

DROP TABLE IF EXISTS `wp_termmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_termmeta`
--

LOCK TABLES `wp_termmeta` WRITE;
/*!40000 ALTER TABLE `wp_termmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_termmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_terms`
--

LOCK TABLES `wp_terms` WRITE;
/*!40000 ALTER TABLE `wp_terms` DISABLE KEYS */;
INSERT INTO `wp_terms` VALUES
(1,'Uncategorized','uncategorized',0),
(2,'simple','simple',0),
(3,'grouped','grouped',0),
(4,'variable','variable',0),
(5,'external','external',0),
(6,'exclude-from-search','exclude-from-search',0),
(7,'exclude-from-catalog','exclude-from-catalog',0),
(8,'featured','featured',0),
(9,'outofstock','outofstock',0),
(10,'rated-1','rated-1',0),
(11,'rated-2','rated-2',0),
(12,'rated-3','rated-3',0),
(13,'rated-4','rated-4',0),
(14,'rated-5','rated-5',0),
(15,'Uncategorized','uncategorized',0),
(16,'Quick Links','quick-links',0),
(17,'Company','company',0);
/*!40000 ALTER TABLE `wp_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_usermeta`
--

LOCK TABLES `wp_usermeta` WRITE;
/*!40000 ALTER TABLE `wp_usermeta` DISABLE KEYS */;
INSERT INTO `wp_usermeta` VALUES
(1,1,'nickname','admin'),
(2,1,'first_name',''),
(3,1,'last_name',''),
(4,1,'description',''),
(5,1,'rich_editing','true'),
(6,1,'syntax_highlighting','true'),
(7,1,'infinite_scrolling','true'),
(8,1,'comment_shortcuts','false'),
(9,1,'admin_color','modern'),
(10,1,'use_ssl','0'),
(11,1,'show_admin_bar_front','true'),
(12,1,'locale',''),
(13,1,'wp_capabilities','a:1:{s:13:\"administrator\";b:1;}'),
(14,1,'wp_user_level','10'),
(15,1,'dismissed_wp_pointers',''),
(16,1,'show_welcome_panel','1'),
(17,1,'session_tokens','a:7:{s:64:\"5d8249dd0a899f79c27af3b1d8d6c3548aa21a3e18f0c765489224f82826824d\";a:4:{s:10:\"expiration\";i:1791505589;s:2:\"ip\";s:10:\"172.18.0.1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36\";s:5:\"login\";i:1791332789;}s:64:\"2c8607195177d7a0514d1b9a702257dc67df3eb97d1bf2f3e288fbe446d9506c\";a:4:{s:10:\"expiration\";i:1791508124;s:2:\"ip\";s:10:\"172.18.0.1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36\";s:5:\"login\";i:1791335324;}s:64:\"b761a6d27e6f802665b731b65aac71997aec7b910466e96c0044c3c9556f7c24\";a:4:{s:10:\"expiration\";i:1791508126;s:2:\"ip\";s:10:\"172.18.0.1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36\";s:5:\"login\";i:1791335326;}s:64:\"9d9bb2658bd701be1953e77563de601f66feb957ba4fc287c2e08c8495e98933\";a:4:{s:10:\"expiration\";i:1791508137;s:2:\"ip\";s:10:\"172.18.0.1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36\";s:5:\"login\";i:1791335337;}s:64:\"c37a352521bf6e0a463db32565e28b44224a981c6e77e0835e386df2d950cc3c\";a:4:{s:10:\"expiration\";i:1791527407;s:2:\"ip\";s:10:\"172.18.0.1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36\";s:5:\"login\";i:1791354607;}s:64:\"713da3dfad3ab727788d73ebf65e893a18807d813e89c3f2edfcf6e9062c40d2\";a:4:{s:10:\"expiration\";i:1791527418;s:2:\"ip\";s:10:\"172.18.0.1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36\";s:5:\"login\";i:1791354618;}s:64:\"69427fb31600ab8040801617cf37cda85a24a498e88184a24b07baa3b8ffbc7c\";a:4:{s:10:\"expiration\";i:1791527454;s:2:\"ip\";s:10:\"172.18.0.1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36\";s:5:\"login\";i:1791354654;}}'),
(18,1,'wp_dashboard_quick_press_last_post_id','4'),
(19,1,'community-events-location','a:1:{s:2:\"ip\";s:10:\"172.18.0.0\";}'),
(20,1,'manageedit-postcolumnshidden','a:3:{i:0;s:0:\"\";i:1;s:15:\"rank_math_title\";i:2;s:21:\"rank_math_description\";}'),
(21,1,'manageedit-postcolumnshidden_default','1'),
(22,1,'manageedit-pagecolumnshidden','a:3:{i:0;s:0:\"\";i:1;s:15:\"rank_math_title\";i:2;s:21:\"rank_math_description\";}'),
(23,1,'manageedit-pagecolumnshidden_default','1'),
(24,1,'last_update','1791341515'),
(25,1,'_woocommerce_persistent_cart_1','a:1:{s:4:\"cart\";a:0:{}}'),
(26,1,'_woocommerce_tracks_anon_id','woo:F4Ufx4AMnLCADDYG0Ey6fz5L'),
(27,1,'manageedit-productcolumnshidden','a:3:{i:0;s:0:\"\";i:1;s:15:\"rank_math_title\";i:2;s:21:\"rank_math_description\";}'),
(28,1,'manageedit-productcolumnshidden_default','1'),
(29,1,'wc_last_active','1791356155');
/*!40000 ALTER TABLE `wp_usermeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(255) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT 0,
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_users`
--

LOCK TABLES `wp_users` WRITE;
/*!40000 ALTER TABLE `wp_users` DISABLE KEYS */;
INSERT INTO `wp_users` VALUES
(1,'admin','$wp$2y$10$2PgtSuhg.Fj5YlnQyFTdVe5VXSHcNEYCF9UI1VwjZ3v1.s0bzKABW','admin','admin@gmail.com','http://localhost:8000','2026-10-07 00:26:01','',0,'admin');
/*!40000 ALTER TABLE `wp_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_admin_note_actions`
--

DROP TABLE IF EXISTS `wp_wc_admin_note_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_admin_note_actions` (
  `action_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `note_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `query` longtext NOT NULL,
  `status` varchar(255) NOT NULL,
  `actioned_text` varchar(255) NOT NULL,
  `nonce_action` varchar(255) DEFAULT NULL,
  `nonce_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`action_id`),
  KEY `note_id` (`note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_admin_note_actions`
--

LOCK TABLES `wp_wc_admin_note_actions` WRITE;
/*!40000 ALTER TABLE `wp_wc_admin_note_actions` DISABLE KEYS */;
INSERT INTO `wp_wc_admin_note_actions` VALUES
(1,1,'notify-refund-returns-page','Edit page','http://localhost:8000/wp-admin/post.php?post=11&action=edit','actioned','',NULL,NULL),
(2,2,'learn-more','Learn more','https://woocommerce.com/posts/ecommerce-shipping-solutions-guide/?utm_source=inbox_note&utm_medium=product&utm_campaign=learn-more','actioned','',NULL,NULL),
(3,3,'optimizing-the-checkout-flow','Learn more','https://woocommerce.com/posts/optimizing-woocommerce-checkout?utm_source=inbox_note&utm_medium=product&utm_campaign=optimizing-the-checkout-flow','actioned','',NULL,NULL),
(4,4,'qualitative-feedback-from-new-users','Share feedback','https://automattic.survey.fm/woopayments-new-user-feedback','actioned','',NULL,NULL),
(5,5,'share-feedback','Share feedback','http://automattic.survey.fm/paypal-feedback','unactioned','',NULL,NULL),
(6,6,'get-started','Get started','https://woocommerce.com/products/google-listings-and-ads?utm_source=inbox_note&utm_medium=product&utm_campaign=get-started','actioned','',NULL,NULL),
(7,7,'update-wc-subscriptions-3-0-15','View latest version','http://localhost:8000/wp-admin/&page=wc-addons&section=helper','actioned','',NULL,NULL),
(8,8,'update-wc-core-5-4-0','How to update WooCommerce','https://docs.woocommerce.com/document/how-to-update-woocommerce/','actioned','',NULL,NULL),
(9,11,'ppxo-pps-install-paypal-payments-1','View upgrade guide','https://docs.woocommerce.com/document/woocommerce-paypal-payments/paypal-payments-upgrade-guide/','actioned','',NULL,NULL),
(10,12,'ppxo-pps-install-paypal-payments-2','View upgrade guide','https://docs.woocommerce.com/document/woocommerce-paypal-payments/paypal-payments-upgrade-guide/','actioned','',NULL,NULL),
(11,13,'learn-more','Learn more','https://woocommerce.com/posts/critical-vulnerability-detected-july-2021/?utm_source=inbox_note&utm_medium=product&utm_campaign=learn-more','unactioned','',NULL,NULL),
(12,13,'dismiss','Dismiss','','actioned','',NULL,NULL),
(13,14,'learn-more','Learn more','https://woocommerce.com/posts/critical-vulnerability-detected-july-2021/?utm_source=inbox_note&utm_medium=product&utm_campaign=learn-more','unactioned','',NULL,NULL),
(14,14,'dismiss','Dismiss','','actioned','',NULL,NULL),
(15,15,'learn-more','Learn more','https://woocommerce.com/posts/critical-vulnerability-detected-july-2021/?utm_source=inbox_note&utm_medium=product&utm_campaign=learn-more','unactioned','',NULL,NULL),
(16,15,'dismiss','Dismiss','','actioned','',NULL,NULL),
(17,16,'learn-more','Learn more','https://woocommerce.com/posts/critical-vulnerability-detected-july-2021/?utm_source=inbox_note&utm_medium=product&utm_campaign=learn-more','unactioned','',NULL,NULL),
(18,16,'dismiss','Dismiss','','actioned','',NULL,NULL),
(19,17,'share-feedback','Share feedback','https://automattic.survey.fm/store-management','unactioned','',NULL,NULL),
(20,18,'learn-more','Learn more','https://developer.woocommerce.com/2022/03/10/woocommerce-3-5-10-6-3-1-security-releases/','unactioned','',NULL,NULL),
(21,18,'woocommerce-core-paypal-march-2022-dismiss','Dismiss','','actioned','',NULL,NULL),
(22,19,'learn-more','Learn more','https://developer.woocommerce.com/2022/03/10/woocommerce-3-5-10-6-3-1-security-releases/','unactioned','',NULL,NULL),
(23,19,'dismiss','Dismiss','','actioned','',NULL,NULL),
(24,20,'pinterest_03_2022_update','Update Instructions','https://woocommerce.com/document/pinterest-for-woocommerce/?utm_source=inbox_note&utm_medium=product&utm_campaign=pinterest_03_2022_update#section-3','actioned','',NULL,NULL),
(25,21,'store_setup_survey_survey_q2_2022_share_your_thoughts','Tell us how it’s going','https://automattic.survey.fm/store-setup-survey-2022','actioned','',NULL,NULL),
(26,22,'needs-update-eway-payment-gateway-rin-action-button-2022-12-20','See available updates','http://localhost:8000/wp-admin/update-core.php','unactioned','',NULL,NULL),
(27,22,'needs-update-eway-payment-gateway-rin-dismiss-button-2022-12-20','Dismiss','#','actioned','',NULL,NULL),
(28,23,'updated-eway-payment-gateway-rin-action-button-2022-12-20','See all updates','http://localhost:8000/wp-admin/update-core.php','unactioned','',NULL,NULL),
(29,23,'updated-eway-payment-gateway-rin-dismiss-button-2022-12-20','Dismiss','#','actioned','',NULL,NULL),
(30,24,'share-navigation-survey-feedback','Share feedback','https://automattic.survey.fm/new-ecommerce-plan-navigation','actioned','',NULL,NULL),
(31,25,'woopay-beta-merchantrecruitment-activate-04MAY23','Activate WooPay','http://localhost:8000/wp-admin/admin.php?page=wc-settings&tab=checkout&section=woocommerce_payments&method=platform_checkout','actioned','',NULL,NULL),
(32,25,'woopay-beta-merchantrecruitment-activate-learnmore-04MAY23','Learn More','https://woocommerce.com/woopay-businesses/?utm_source=inbox_note&utm_medium=product&utm_campaign=woopay-beta-merchantrecruitment-activate-learnmore-04MAY23','unactioned','',NULL,NULL),
(33,26,'woocommerce-wcpay-march-2023-update-needed-button','See Blog Post','https://developer.woocommerce.com/2023/03/23/critical-vulnerability-detected-in-woocommerce-payments-what-you-need-to-know','unactioned','',NULL,NULL),
(34,26,'woocommerce-wcpay-march-2023-update-needed-dismiss-button','Dismiss','#','actioned','',NULL,NULL),
(35,27,'tap_to_pay_iphone_q2_2023_no_wcpay','Simplify my payments','https://woocommerce.com/products/woocommerce-payments/?utm_source=inbox_note&utm_medium=product&utm_campaign=tap_to_pay_iphone_q2_2023_no_wcpay','actioned','',NULL,NULL),
(36,28,'extension-settings','See available updates','http://localhost:8000/wp-admin/update-core.php','unactioned','',NULL,NULL),
(37,28,'dismiss','Dismiss','#','actioned','',NULL,NULL),
(38,29,'woopay-beta-merchantrecruitment-update-WCPay-04MAY23','Update WooCommerce Payments','http://localhost:8000/wp-admin/plugins.php?plugin_status=all','unactioned','',NULL,NULL),
(39,29,'woopay-beta-merchantrecruitment-update-activate-04MAY23','Activate WooPay','http://localhost:8000/wp-admin/admin.php?page=wc-settings&tab=checkout&section=woocommerce_payments&method=platform_checkout','actioned','',NULL,NULL),
(40,30,'woopay-beta-existingmerchants-noaction-documentation-27APR23','Documentation','https://woocommerce.com/document/woopay-merchant-documentation/?utm_source=inbox_note&utm_medium=product&utm_campaign=woopay-beta-existingmerchants-noaction-documentation-27APR23','actioned','',NULL,NULL),
(41,31,'woopay-beta-existingmerchants-update-WCPay-27APR23','Update WooCommerce Payments','http://localhost:8000/wp-admin/plugins.php?plugin_status=all','actioned','',NULL,NULL),
(42,32,'woopay-beta-merchantrecruitment-short-activate-04MAY23','Activate WooPay','http://localhost:8000/wp-admin/admin.php?page=wc-settings&tab=checkout&section=woocommerce_payments&method=platform_checkout','actioned','',NULL,NULL),
(43,32,'woopay-beta-merchantrecruitment-short-activate-learnmore-04MAY23','Learn More','https://woocommerce.com/woopay-businesses/?utm_source=inbox_note&utm_medium=product&utm_campaign=woopay-beta-merchantrecruitment-short-activate-learnmore-04MAY23','actioned','',NULL,NULL),
(44,33,'woopay-beta-merchantrecruitment-short-update-WCPay-04MAY23','Update WooCommerce Payments','http://localhost:8000/wp-admin/plugins.php?plugin_status=all','unactioned','',NULL,NULL),
(45,33,'woopay-beta-merchantrecruitment-short-update-activate-04MAY23','Activate WooPay','http://localhost:8000/wp-admin/admin.php?page=wc-settings&tab=checkout&section=woocommerce_payments&method=platform_checkout','actioned','',NULL,NULL),
(46,34,'woopay-beta-merchantrecruitment-short-activate-button-09MAY23','Activate WooPay','http://localhost:8000/wp-admin/admin.php?page=wc-settings&tab=checkout&section=woocommerce_payments&method=platform_checkout','unactioned','',NULL,NULL),
(47,34,'woopay-beta-merchantrecruitment-short-activate-learnmore-button2-09MAY23','Learn More','https://woocommerce.com/woopay-businesses/?utm_source=inbox_note&utm_medium=product&utm_campaign=woopay-beta-merchantrecruitment-short-activate-learnmore-button2-09MAY23','unactioned','',NULL,NULL),
(48,35,'woopay-beta-merchantrecruitment-short-update-WCPay-09MAY23','Update WooCommerce Payments','http://localhost:8000/wp-admin/plugins.php?plugin_status=all','unactioned','',NULL,NULL),
(49,35,'woopay-beta-merchantrecruitment-short-update-activate-09MAY23','Activate WooPay','http://localhost:8000/wp-admin/admin.php?page=wc-settings&tab=checkout&section=woocommerce_payments&method=platform_checkout','unactioned','',NULL,NULL),
(50,36,'woocommerce-WCSubscriptions-June-2023-updated-needed-Plugin-Settings','See available updates','http://localhost:8000/wp-admin/plugins.php?plugin_status=all','unactioned','',NULL,NULL),
(51,36,'woocommerce-WCSubscriptions-June-2023-updated-needed-dismiss','Dismiss','#','actioned','',NULL,NULL),
(52,37,'woocommerce-WCReturnsWarranty-June-2023-updated-needed','See available updates','http://localhost:8000/wp-admin/plugins.php?plugin_status=all','unactioned','',NULL,NULL),
(53,37,'woocommerce-WCReturnsWarranty-June-2023-updated-needed','Dismiss','#','actioned','',NULL,NULL),
(54,38,'woocommerce-WCOPC-June-2023-updated-needed','See available updates','http://localhost:8000/wp-admin/plugins.php?plugin_status=all','actioned','',NULL,NULL),
(55,38,'woocommerce-WCOPC-June-2023-updated-needed','Dismiss','http://localhost:8000/wp-admin/#','actioned','',NULL,NULL),
(56,39,'woocommerce-WCGC-July-2023-update-needed','See available updates','http://localhost:8000/wp-admin/plugins.php?plugin_status=all','unactioned','',NULL,NULL),
(57,39,'woocommerce-WCGC-July-2023-update-needed','Dismiss','#','actioned','',NULL,NULL),
(58,40,'learn-more','Learn more','https://woocommerce.com/document/fedex/?utm_medium=product&utm_source=inbox_note&utm_campaign=learn-more#july-2023-api-outage','unactioned','',NULL,NULL),
(59,41,'plugin-list','See available updates','http://localhost:8000/wp-admin/plugins.php?plugin_status=all','unactioned','',NULL,NULL),
(60,41,'dismiss','Dismiss','http://localhost:8000/wp-admin/admin.php?page=wc-admin','actioned','',NULL,NULL),
(61,42,'woocommerce-WCStripe-Aug-2023-update-needed','See available updates','http://localhost:8000/wp-admin/update-core.php?','unactioned','',NULL,NULL),
(62,42,'dismiss','Dismiss','#','actioned','',NULL,NULL),
(63,43,'dismiss','Dismiss','#','actioned','',NULL,NULL),
(64,44,'dismiss','Dismiss','#','actioned','',NULL,NULL),
(65,45,'avalara_q3-2023_noAvaTax','Automate my sales tax','https://woocommerce.com/products/woocommerce-avatax/?utm_source=inbox_note&utm_medium=product&utm_campaign=avalara_q3-2023_noAvaTax','unactioned','',NULL,NULL),
(66,46,'woocommerce-usermeta-Sept2023-productvendors','See available updates','http://localhost:8000/wp-admin/plugins.php','unactioned','',NULL,NULL),
(67,46,'dismiss','Dismiss','http://localhost:8000/wp-admin/#','actioned','',NULL,NULL),
(68,47,'woocommerce-STRIPE-Oct-2023-update-needed','See available updates','http://localhost:8000/wp-admin/update-core.php','unactioned','',NULL,NULL),
(69,47,'dismiss','Dismiss','#','actioned','',NULL,NULL),
(70,48,'amazon-mcf-review-button-2023-12-07','Leave a review','https://woocommerce.com/products/woocommerce-amazon-fulfillment/?review&utm_source=inbox_note&utm_medium=product&utm_campaign=amazon-mcf-review-button-2023-12-07','actioned','',NULL,NULL),
(71,48,'amazon-mcf-support-button-2023-12-07','Request support','https://woocommerce.com/my-account/contact-support/?utm_source=inbox_note&utm_medium=product&utm_campaign=amazon-mcf-support-button-2023-12-07','actioned','',NULL,NULL),
(72,49,'view_docs','Learn about Deposit schedules','https://woocommerce.com/document/woopayments/deposits/deposit-schedule/?utm_source=inbox_note&utm_medium=product&utm_campaign=view_docs#available-funds','unactioned','',NULL,NULL),
(73,50,'sirt-woo-2024-11-xss-admin','See available updates','http://localhost:8000/wp-admin/update-core.php?','unactioned','',NULL,NULL),
(74,50,'sirt-woo-2024-11-xss-admin','Dismiss','#','actioned','',NULL,NULL),
(75,51,'paypal-braintree-sdk-depreciation-2025-02-20-button','Upgrade now','http://localhost:8000/wp-admin/wp-admin/plugins.php','actioned','',NULL,NULL),
(76,52,'uk-vat-notice-button-2025-04-30','Learn more about this extension','https://wordpress.org/plugins/eu-vat-for-woocommerce/','actioned','',NULL,NULL),
(77,53,'paypal-braintree-sdk-depreciation-2025-05-30-button','Update now','http://localhost:8000/wp-admin/wp-admin/plugins.php','unactioned','',NULL,NULL),
(78,54,'woo-dotcom-course-2026-06-09','Visit the course','https://wordpress.com/support/courses/build-your-store-with-woocommerce/','actioned','',NULL,NULL),
(79,55,'google-for-woocommerce-mapi-update-button','Update now','http://localhost:8000/wp-admin/plugins.php','unactioned','',NULL,NULL),
(80,55,'google-for-woocommerce-mapi-update-dismiss','Dismiss','#','actioned','',NULL,NULL);
/*!40000 ALTER TABLE `wp_wc_admin_note_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_admin_notes`
--

DROP TABLE IF EXISTS `wp_wc_admin_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_admin_notes` (
  `note_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `locale` varchar(20) NOT NULL,
  `title` longtext NOT NULL,
  `content` longtext NOT NULL,
  `content_data` longtext DEFAULT NULL,
  `status` varchar(200) NOT NULL,
  `source` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_reminder` datetime DEFAULT NULL,
  `is_snoozable` tinyint(1) NOT NULL DEFAULT 0,
  `layout` varchar(20) NOT NULL DEFAULT '',
  `image` varchar(200) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `icon` varchar(200) NOT NULL DEFAULT 'info',
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_admin_notes`
--

LOCK TABLES `wp_wc_admin_notes` WRITE;
/*!40000 ALTER TABLE `wp_wc_admin_notes` DISABLE KEYS */;
INSERT INTO `wp_wc_admin_notes` VALUES
(1,'wc-refund-returns-page','info','en_US','Setup a Refund and Returns Policy page to boost your store\'s credibility.','We have created a sample draft Refund and Returns Policy page for you. Please have a look and update it to fit your store.','{}','unactioned','woocommerce-core','2026-10-07 02:52:10',NULL,0,'plain','',0,0,'info'),
(2,'your-first-product','info','en_US','Your first product','That’s huge! You’re well on your way to building a successful online store — now it’s time to think about how you’ll fulfill your orders.<br /><br />Read our shipping guide to learn best practices and options for putting together your shipping strategy. And for WooCommerce stores in the United States, you can print discounted shipping labels via USPS with <a href=\"https://href.li/?https://woocommerce.com/shipping\" target=\"_blank\">WooCommerce Shipping</a>.','{}','pending','woocommerce.com','2026-10-07 02:56:20',NULL,0,'plain','',0,0,'info'),
(3,'wc-admin-optimizing-the-checkout-flow','info','en_US','Optimizing the checkout flow','It’s crucial to get your store’s checkout as smooth as possible to avoid losing sales. Let’s take a look at how you can optimize the checkout experience for your shoppers.','{}','pending','woocommerce.com','2026-10-07 02:56:20',NULL,0,'plain','',0,0,'info'),
(4,'wc-payments-qualitative-feedback','info','en_US','WooPayments setup - let us know what you think','Congrats on enabling WooPayments for your store. Please share your feedback in this 2 minute survey to help us improve the setup process.','{}','pending','woocommerce.com','2026-10-07 02:56:20',NULL,0,'plain','',0,0,'info'),
(5,'share-your-feedback-on-paypal','info','en_US','Share your feedback on PayPal','Share your feedback in this 2 minute survey about how we can make the process of accepting payments more useful for your store.','{}','pending','woocommerce.com','2026-10-07 02:56:20',NULL,0,'plain','',0,0,'info'),
(6,'google_listings_and_ads_install','marketing','en_US','Drive traffic and sales with Google','Reach online shoppers to drive traffic and sales for your store by showcasing products across Google, for free or with ads.','{}','pending','woocommerce.com','2026-10-07 02:56:20',NULL,0,'plain','',0,0,'info'),
(7,'wc-subscriptions-security-update-3-0-15','info','en_US','WooCommerce Subscriptions security update!','We recently released an important security update to WooCommerce Subscriptions. To ensure your site’s data is protected, please upgrade <strong>WooCommerce Subscriptions to version 3.0.15</strong> or later.<br /><br />Click the button below to view and update to the latest Subscriptions version, or log in to <a href=\"https://woocommerce.com/my-dashboard\">WooCommerce.com Dashboard</a> and navigate to your <strong>Downloads</strong> page.<br /><br />We recommend always using the latest version of WooCommerce Subscriptions, and other software running on your site, to ensure maximum security.<br /><br />If you have any questions we are here to help — just <a href=\"https://woocommerce.com/my-account/create-a-ticket/\">open a ticket</a>.','{}','pending','woocommerce.com','2026-10-07 02:56:20',NULL,0,'plain','',0,0,'info'),
(8,'woocommerce-core-update-5-4-0','info','en_US','Update to WooCommerce 5.4.1 now','WooCommerce 5.4.1 addresses a checkout issue discovered in WooCommerce 5.4. We recommend upgrading to WooCommerce 5.4.1 as soon as possible.','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(9,'wcpay-promo-2020-11','marketing','en_US','wcpay-promo-2020-11','wcpay-promo-2020-11','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(10,'wcpay-promo-2020-12','marketing','en_US','wcpay-promo-2020-12','wcpay-promo-2020-12','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(11,'ppxo-pps-upgrade-paypal-payments-1','info','en_US','Get the latest PayPal extension for WooCommerce','Heads up! There’s a new PayPal on the block!<br /><br />Now is a great time to upgrade to our latest <a href=\"https://woocommerce.com/products/woocommerce-paypal-payments/\" target=\"_blank\">PayPal extension</a> to continue to receive support and updates with PayPal.<br /><br />Get access to a full suite of PayPal payment methods, extensive currency and country coverage, and pay later options with the all-new PayPal extension for WooCommerce.','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(12,'ppxo-pps-upgrade-paypal-payments-2','info','en_US','Upgrade your PayPal experience!','Get access to a full suite of PayPal payment methods, extensive currency and country coverage, offer subscription and recurring payments, and the new PayPal pay later options.<br /><br />Start using our <a href=\"https://woocommerce.com/products/woocommerce-paypal-payments/\" target=\"_blank\">latest PayPal today</a> to continue to receive support and updates.','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(13,'woocommerce-core-sqli-july-2021-need-to-update','update','en_US','Action required: Critical vulnerabilities in WooCommerce','In response to a critical vulnerability identified on July 13, 2021, we are working with the WordPress Plugins Team to deploy software updates to stores running WooCommerce (versions 3.3 to 5.5) and the WooCommerce Blocks feature plugin (versions 2.5 to 5.5).<br /><br />Our investigation into this vulnerability is ongoing, but <strong>we wanted to let you know now about the importance of updating immediately</strong>.<br /><br />For more information on which actions you should take, as well as answers to FAQs, please urgently review our blog post detailing this issue.','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(14,'woocommerce-blocks-sqli-july-2021-need-to-update','update','en_US','Action required: Critical vulnerabilities in WooCommerce Blocks','In response to a critical vulnerability identified on July 13, 2021, we are working with the WordPress Plugins Team to deploy software updates to stores running WooCommerce (versions 3.3 to 5.5) and the WooCommerce Blocks feature plugin (versions 2.5 to 5.5).<br /><br />Our investigation into this vulnerability is ongoing, but <strong>we wanted to let you know now about the importance of updating immediately</strong>.<br /><br />For more information on which actions you should take, as well as answers to FAQs, please urgently review our blog post detailing this issue.','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(15,'woocommerce-core-sqli-july-2021-store-patched','update','en_US','Solved: Critical vulnerabilities patched in WooCommerce','In response to a critical vulnerability identified on July 13, 2021, we worked with the WordPress Plugins Team to deploy software updates to stores running WooCommerce (versions 3.3 to 5.5) and the WooCommerce Blocks feature plugin (versions 2.5 to 5.5).<br /><br /><strong>Your store has been updated to the latest secure version(s)</strong>. For more information and answers to FAQs, please review our blog post detailing this issue.','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(16,'woocommerce-blocks-sqli-july-2021-store-patched','update','en_US','Solved: Critical vulnerabilities patched in WooCommerce Blocks','In response to a critical vulnerability identified on July 13, 2021, we worked with the WordPress Plugins Team to deploy software updates to stores running WooCommerce (versions 3.3 to 5.5) and the WooCommerce Blocks feature plugin (versions 2.5 to 5.5).<br /><br /><strong>Your store has been updated to the latest secure version(s)</strong>. For more information and answers to FAQs, please review our blog post detailing this issue.','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(17,'habit-moment-survey','marketing','en_US','We’re all ears! Share your experience so far with WooCommerce','We’d love your input to shape the future of WooCommerce together. Feel free to share any feedback, ideas or suggestions that you have.','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(18,'woocommerce-core-paypal-march-2022-updated','update','en_US','Security auto-update of WooCommerce','<strong>Your store has been updated to the latest secure version of WooCommerce</strong>. We worked with WordPress to deploy PayPal Standard security updates for stores running WooCommerce (version 3.5 to 6.3). It’s recommended to disable PayPal Standard, and use <a href=\"https://woocommerce.com/products/woocommerce-paypal-payments/\" target=\"_blank\">PayPal Payments</a> to accept PayPal.','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(19,'woocommerce-core-paypal-march-2022-updated-nopp','update','en_US','Security auto-update of WooCommerce','<strong>Your store has been updated to the latest secure version of WooCommerce</strong>. We worked with WordPress to deploy security updates related to PayPal Standard payment gateway for stores running WooCommerce (version 3.5 to 6.3).','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(20,'pinterest_03_2022_update','marketing','en_US','Your Pinterest for WooCommerce plugin is out of date!','Update to the latest version of Pinterest for WooCommerce to continue using this plugin and keep your store connected with Pinterest. To update, visit <strong>Plugins &gt; Installed Plugins</strong>, and click on “update now” under Pinterest for WooCommerce.','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(21,'store_setup_survey_survey_q2_2022','survey','en_US','How is your store setup going?','Our goal is to make sure you have all the right tools to start setting up your store in the smoothest way possible.\r\nWe’d love to know if we hit our mark and how we can improve. To collect your thoughts, we made a 2-minute survey.','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(22,'needs-update-eway-payment-gateway-rin-2022-12-20','update','en_US','Security vulnerability patched in WooCommerce Eway Gateway','In response to a potential vulnerability identified in WooCommerce Eway Gateway versions 3.1.0 to 3.5.0, we’ve worked to deploy security fixes and have released an updated version.\r\nNo external exploits have been detected, but we recommend you update to your latest supported version 3.1.26, 3.2.3, 3.3.1, 3.4.6, or 3.5.1','{}','pending','woocommerce.com','2026-10-07 02:56:21',NULL,0,'plain','',0,0,'info'),
(23,'updated-eway-payment-gateway-rin-2022-12-20','update','en_US','WooCommerce Eway Gateway has been automatically updated','Your store is now running the latest secure version of WooCommerce Eway Gateway. We worked with the WordPress Plugins team to deploy a software update to stores running WooCommerce Eway Gateway (versions 3.1.0 to 3.5.0) in response to a security vulnerability that was discovered.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(24,'ecomm-wc-navigation-survey-2023','info','en_US','Navigating WooCommerce on WordPress.com','We are improving the WooCommerce navigation on WordPress.com and would love your help to make it better! Please share your experience with us in this 2-minute survey.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(25,'woopay-beta-merchantrecruitment-04MAY23','info','en_US','Increase conversions with WooPay — our fastest checkout yet','WooPay, a new express checkout feature built into WooCommerce Payments, is now available —and we’re inviting you to be one of the first to try it. \r\n<br><br>\r\nBoost conversions by offering your customers a simple, secure way to pay with a single click.\r\n<br><br>\r\nGet started in seconds.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(26,'woocommerce-wcpay-march-2023-update-needed','update','en_US','Action required: Security update for WooCommerce Payments','<strong>Your store requires a security update for WooCommerce Payments</strong>. Please update to the latest version of WooCommerce Payments immediately to address a potential vulnerability discovered on March 22. For more information on how to update, visit this WooCommerce Developer Blog Post.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(27,'tap_to_pay_iphone_q2_2023_no_wcpay','marketing','en_US','Accept in-person contactless payments on your iPhone','Tap to Pay on iPhone and WooCommerce Payments is quick, secure, and simple to set up — no extra terminals or card readers are needed. Accept contactless debit and credit cards, Apple Pay, and other NFC digital wallets in person.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(28,'woocommerce-WCPreOrders-april-2023-update-needed','update','en_US','Action required: Security update of WooCommerce Pre-Orders extension','<strong>Your store requires a security update for the WooCommerce Pre-Orders extension</strong>. Please update the WooCommerce Pre-Orders extension immediately to address a potential vulnerability discovered on April 11.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(29,'woopay-beta-merchantrecruitment-update-04MAY23','info','en_US','Increase conversions with WooPay — our fastest checkout yet','WooPay, a new express checkout feature built into WooCommerce Payments, is now available — and you’re invited to try it. \r\n<br /><br />\r\nBoost conversions by offering your customers a simple, secure way to pay with a single click.\r\n<br /><br />\r\nUpdate WooCommerce Payments to get started.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(30,'woopay-beta-existingmerchants-noaction-27APR23','info','en_US','WooPay is back!','Thanks for previously trying WooPay, the express checkout feature built into WooCommerce Payments. We’re excited to announce that WooPay availability has resumed. No action is required on your part.\r\n<br /><br />\r\nYou can now continue boosting conversions by offering your customers a simple, secure way to pay with a single click.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(31,'woopay-beta-existingmerchants-update-27APR23','info','en_US','WooPay is back!','Thanks for previously trying WooPay, the express checkout feature built into WooCommerce Payments. We’re excited to announce that WooPay availability has resumed.\r\n<br /><br />\r\n\r\nUpdate to the latest WooCommerce Payments version to continue boosting conversions by offering your customers a simple, secure way to pay with a single click.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(32,'woopay-beta-merchantrecruitment-short-04MAY23','info','en_US','Increase conversions with WooPay — our fastest checkout yet','Be one of the first to try WooPay, a new express checkout feature for WooCommerce Payments. \r\n<br><br>\r\nBoost conversions by letting customers pay with a single click.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(33,'woopay-beta-merchantrecruitment-short-update-04MAY23','info','en_US','Increase conversions with WooPay — our fastest checkout yet','Be one of the first to try WooPay, our new express checkout feature. <br>Boost conversions by letting customers pay with a single click. <br><br>Update to the latest version of WooCommerce Payments to get started.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(34,'woopay-beta-merchantrecruitment-short-09MAY23','info','en_US','Increase conversions with WooPay — our fastest checkout yet','Be one of the first to try WooPay, a new express checkout feature for WooCommerce Payments. \r\n<br><br>\r\nBoost conversions by letting customers pay with a single click.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(35,'woopay-beta-merchantrecruitment-short-update-09MAY23','info','en_US','Increase conversions with WooPay — our fastest checkout yet','Be one of the first to try WooPay, our new express checkout feature. <br>Boost conversions by letting customers pay with a single click. <br><br>Update to the latest version of WooCommerce Payments to get started.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(36,'woocommerce-WCSubscriptions-June-2023-updated-needed','marketing','en_US','Action required: Security update of WooCommerce Subscriptions','<strong>Your store requires a security update for the WooCommerce Subscriptions plugin</strong>. Please update the WooCommerce Subscriptions plugin immediately to address a potential vulnerability.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(37,'woocommerce-WCReturnsWarranty-June-2023-updated-needed','update','en_US','Action required: Security update of WooCommerce Returns and Warranty Requests extension','<strong>Your store requires a security update for the Returns and Warranty Requests extension</strong>.  Please update to the latest version of the WooCommerce Returns and Warranty Requests extension immediately to address a potential vulnerability discovered on May 31.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(38,'woocommerce-WCOPC-June-2023-updated-needed','update','en_US','Action required: Security update of WooCommerce One Page Checkout','<strong>Your shop requires a security update to address a vulnerability in the WooCommerce One Page Checkout extension</strong>. The fix for this vulnerability was released for this extension on June 13th. Please update immediately.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(39,'woocommerce-WCGC-July-2023-update-needed','update','en_US','Action required: Security update of WooCommerce GoCardless Extension','<strong>Your shop requires a security update to address a vulnerability in the WooCommerce GoCardless extension</strong>. The fix for this vulnerability was released on July 4th. Please update immediately.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(40,'woocommerce-shipping-fedex-api-outage-2023-07-16','warning','en_US','Scheduled FedEx API outage — July 2023','On July 16 there will be a full outage of the FedEx API from 04:00 to 08:00 AM UTC. Due to planned maintenance by FedEx, you\'ll be unable to provide FedEx shipping rates during this time. Follow the link below for more information and recommendations on how to minimize impact.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(41,'wcship-2023-07-hazmat-update-needed','update','en_US','Action required: USPS HAZMAT compliance update for WooCommerce Shipping & Tax extension','<strong>Your store requires an update for the WooCommerce Shipping extension</strong>. Please update to the latest version of the WooCommerce Shipping &amp; Tax extension immediately to ensure compliance with new USPS HAZMAT rules currently in effect.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(42,'woocommerce-WCStripe-Aug-2023-update-needed','update','en_US','Action required: Security update for WooCommerce Stripe plugin','<strong>Your shop requires an important security update for the  WooCommerce Stripe plugin</strong>. The fix for this vulnerability was released on July 31. Please update immediately.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(43,'woocommerce-WCStripe-Aug-2023-security-updated','update','en_US','Security update of WooCommerce Stripe plugin','<strong>Your store has been updated to the latest secure version of the WooCommerce Stripe plugin</strong>. This update was released on July 31.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(44,'woocommerce-WooPayments-Aug-2023-security-updated','update','en_US','Security update of WooPayments (WooCommerce Payments) plugin','<strong>Your store has been updated to the more secure version of WooPayments (WooCommerce Payments)</strong>. This update was released on July 31.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(45,'avalara_q3-2023_noAvaTax','marketing','en_US','Automatically calculate VAT in real time','Take the effort out of determining tax rates and sell confidently across borders with automated tax management from Avalara AvaTax— including built-in VAT calculation when you sell into or across the EU and UK. Save time and stay compliant when you let Avalara do the heavy lifting.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(46,'woocommerce-usermeta-Sept2023-productvendors','update','en_US','Your store requires a security update','<strong>Your shop needs an update to address a vulnerability in WooCommerce.</strong> The fix was released on Sept 15. Please update WooCommerce to the latest version immediately. <a href=\"https://developer.woocommerce.com/2023/09/16/woocommerce-vulnerability-reintroduced-from-7-0-1/\" />Read our developer update</a> for more information.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(47,'woocommerce-STRIPE-Oct-2023-update-needed','update','en_US','Action required: Security update for WooCommerce Stripe Gateway','<strong>Your shop requires a security update to address a vulnerability in the WooCommerce Stripe Gateway</strong>. The fix for this vulnerability was released on October 17. Please update immediately.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(48,'amazon-mcf-reviews-2023-12-07','marketing','en_US','Enjoying Amazon MCF for WooCommerce?','We\'re Never Settle, the developers behind Amazon MCF for WooCommerce, and would be deeply honored to have your review. Reviews help immensely as other users can learn how MCF can solve their needs too! Not happy or need help? Please reach out for support and we’d love to make things right!','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(49,'remove_estimated_deposits_2024','marketing','en_US','Estimated deposits are going away','To provide more accurate deposit information and support the expansion of instant deposits, estimated deposit details will no longer be available in WooPayments. We recommend upgrading to the latest version of WooPayments for more detailed balance status information.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(50,'sirt-woo-2024-11-xss-admin','update','en_US','An important update is required for WooCommerce','This update addresses a security vulnerability that could allow unauthorized access to administrative privileges on your site. <a href=\"https://developer.woocommerce.com/2024/12/03/woocommerce-9-4-3-and-woocommerce-9-3-4-available-now/\">Learn more</a>.\r\n<br><br>\r\n<strong>Please ensure your site is updated to the latest version to stay secure.</strong>','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(51,'paypal-braintree-sdk-depreciation-2025-02-20','update','en_US','Update required for your PayPal Braintree extension','To continue securely accepting payments, you must update your PayPal Braintree extension to version 3.2.4 or newer before June 30, 2025. Your current extension version will not support payment processing after this date due to an SSL certificate update.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(52,'uk-vat-notice-2025-04-30','warning','en_US','UK VAT numbers are no longer supported','Due to recent HM Revenue &amp; Customs (HMRC) VAT API changes, your EU VAT Number for WooCommerce extension can no longer validate UK VAT numbers. HMRC now requires merchants to register an API key, which this extension does not currently support. We recommend EU/UK VAT Validation Manager for WooCommerce as a replacement','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(53,'paypal-braintree-sdk-depreciation-2025-05-30','update','en_US','Action required: Update the PayPal Braintree extension','Your PayPal Braintree extension is using an outdated SDK and will stop processing payments after June 30, 2025, due to a root SSL certificate expiration. To avoid service disruption, update to version 3.2.4 or newer immediately.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(54,'woo-dotcom-course-2026-06-09','marketing','en_US','Learn how to build your store with WooCommerce','In this free course, we\'ll help you set up and run your online store with clear, practical guidance.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info'),
(55,'google-for-woocommerce-mapi-update','update','en_US','Action Required by October 12, 2026: Your products will stop showing on Google','You need to update Google for WooCommerce to the latest version (3.9.4) to continue syncing your products to Google Merchant Center without issues. The Google for WooCommerce version you have installed uses the legacy Content API which has been deprecated and replaced by the advanced <a href=\"https://support.google.com/merchants/answer/16494522?hl=en\">Google Merchant API</a>.','{}','pending','woocommerce.com','2026-10-07 02:56:22',NULL,0,'plain','',0,0,'info');
/*!40000 ALTER TABLE `wp_wc_admin_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_category_lookup`
--

DROP TABLE IF EXISTS `wp_wc_category_lookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_category_lookup` (
  `category_tree_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`category_tree_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_category_lookup`
--

LOCK TABLES `wp_wc_category_lookup` WRITE;
/*!40000 ALTER TABLE `wp_wc_category_lookup` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_category_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_customer_lookup`
--

DROP TABLE IF EXISTS `wp_wc_customer_lookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_customer_lookup` (
  `customer_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `username` varchar(60) NOT NULL DEFAULT '',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date_last_active` timestamp NULL DEFAULT NULL,
  `date_registered` timestamp NULL DEFAULT NULL,
  `country` char(2) NOT NULL DEFAULT '',
  `postcode` varchar(20) NOT NULL DEFAULT '',
  `city` varchar(100) NOT NULL DEFAULT '',
  `state` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_customer_lookup`
--

LOCK TABLES `wp_wc_customer_lookup` WRITE;
/*!40000 ALTER TABLE `wp_wc_customer_lookup` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_customer_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_download_log`
--

DROP TABLE IF EXISTS `wp_wc_download_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_download_log` (
  `download_log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` datetime NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `user_ip_address` varchar(100) DEFAULT '',
  PRIMARY KEY (`download_log_id`),
  KEY `permission_id` (`permission_id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_download_log`
--

LOCK TABLES `wp_wc_download_log` WRITE;
/*!40000 ALTER TABLE `wp_wc_download_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_download_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_email_unsubscribes`
--

DROP TABLE IF EXISTS `wp_wc_email_unsubscribes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_email_unsubscribes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email_hash` char(64) NOT NULL,
  `email_kind` varchar(64) NOT NULL,
  `action` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email_hash_kind` (`email_hash`,`email_kind`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_email_unsubscribes`
--

LOCK TABLES `wp_wc_email_unsubscribes` WRITE;
/*!40000 ALTER TABLE `wp_wc_email_unsubscribes` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_email_unsubscribes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_order_addresses`
--

DROP TABLE IF EXISTS `wp_wc_order_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_order_addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `address_type` varchar(20) DEFAULT NULL,
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `company` text DEFAULT NULL,
  `address_1` text DEFAULT NULL,
  `address_2` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `state` text DEFAULT NULL,
  `postcode` text DEFAULT NULL,
  `country` text DEFAULT NULL,
  `email` varchar(320) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `address_type_order_id` (`address_type`,`order_id`),
  KEY `order_id` (`order_id`),
  KEY `email` (`email`(191)),
  KEY `phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_order_addresses`
--

LOCK TABLES `wp_wc_order_addresses` WRITE;
/*!40000 ALTER TABLE `wp_wc_order_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_order_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_order_coupon_lookup`
--

DROP TABLE IF EXISTS `wp_wc_order_coupon_lookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_order_coupon_lookup` (
  `order_id` bigint(20) unsigned NOT NULL,
  `coupon_id` bigint(20) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `discount_amount` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`order_id`,`coupon_id`),
  KEY `coupon_id` (`coupon_id`),
  KEY `date_created` (`date_created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_order_coupon_lookup`
--

LOCK TABLES `wp_wc_order_coupon_lookup` WRITE;
/*!40000 ALTER TABLE `wp_wc_order_coupon_lookup` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_order_coupon_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_order_operational_data`
--

DROP TABLE IF EXISTS `wp_wc_order_operational_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_order_operational_data` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `created_via` varchar(100) DEFAULT NULL,
  `woocommerce_version` varchar(20) DEFAULT NULL,
  `prices_include_tax` tinyint(1) DEFAULT NULL,
  `coupon_usages_are_counted` tinyint(1) DEFAULT NULL,
  `download_permission_granted` tinyint(1) DEFAULT NULL,
  `cart_hash` varchar(100) DEFAULT NULL,
  `new_order_email_sent` tinyint(1) DEFAULT NULL,
  `order_key` varchar(100) DEFAULT NULL,
  `order_stock_reduced` tinyint(1) DEFAULT NULL,
  `date_paid_gmt` datetime DEFAULT NULL,
  `date_completed_gmt` datetime DEFAULT NULL,
  `shipping_tax_amount` decimal(26,8) DEFAULT NULL,
  `shipping_total_amount` decimal(26,8) DEFAULT NULL,
  `discount_tax_amount` decimal(26,8) DEFAULT NULL,
  `discount_total_amount` decimal(26,8) DEFAULT NULL,
  `recorded_sales` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`),
  KEY `order_key` (`order_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_order_operational_data`
--

LOCK TABLES `wp_wc_order_operational_data` WRITE;
/*!40000 ALTER TABLE `wp_wc_order_operational_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_order_operational_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_order_product_lookup`
--

DROP TABLE IF EXISTS `wp_wc_order_product_lookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_order_product_lookup` (
  `order_item_id` bigint(20) unsigned NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `variation_id` bigint(20) unsigned NOT NULL,
  `customer_id` bigint(20) unsigned DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `product_qty` int(11) NOT NULL,
  `product_net_revenue` double NOT NULL DEFAULT 0,
  `product_gross_revenue` double NOT NULL DEFAULT 0,
  `coupon_amount` double NOT NULL DEFAULT 0,
  `tax_amount` double NOT NULL DEFAULT 0,
  `shipping_amount` double NOT NULL DEFAULT 0,
  `shipping_tax_amount` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`order_item_id`,`order_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `customer_id` (`customer_id`),
  KEY `date_created` (`date_created`),
  KEY `customer_product_date` (`customer_id`,`product_id`,`date_created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_order_product_lookup`
--

LOCK TABLES `wp_wc_order_product_lookup` WRITE;
/*!40000 ALTER TABLE `wp_wc_order_product_lookup` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_order_product_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_order_stats`
--

DROP TABLE IF EXISTS `wp_wc_order_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_order_stats` (
  `order_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_created_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_paid` datetime DEFAULT '0000-00-00 00:00:00',
  `date_completed` datetime DEFAULT '0000-00-00 00:00:00',
  `num_items_sold` int(11) NOT NULL DEFAULT 0,
  `total_sales` double NOT NULL DEFAULT 0,
  `tax_total` double NOT NULL DEFAULT 0,
  `shipping_total` double NOT NULL DEFAULT 0,
  `net_total` double NOT NULL DEFAULT 0,
  `returning_customer` tinyint(1) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `date_created` (`date_created`),
  KEY `customer_id` (`customer_id`),
  KEY `status` (`status`),
  KEY `idx_date_paid_status_parent` (`date_paid`,`status`,`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_order_stats`
--

LOCK TABLES `wp_wc_order_stats` WRITE;
/*!40000 ALTER TABLE `wp_wc_order_stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_order_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_order_tax_lookup`
--

DROP TABLE IF EXISTS `wp_wc_order_tax_lookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_order_tax_lookup` (
  `order_id` bigint(20) unsigned NOT NULL,
  `tax_rate_id` bigint(20) unsigned NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shipping_tax` double NOT NULL DEFAULT 0,
  `order_tax` double NOT NULL DEFAULT 0,
  `total_tax` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`order_id`,`tax_rate_id`),
  KEY `tax_rate_id` (`tax_rate_id`),
  KEY `date_created` (`date_created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_order_tax_lookup`
--

LOCK TABLES `wp_wc_order_tax_lookup` WRITE;
/*!40000 ALTER TABLE `wp_wc_order_tax_lookup` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_order_tax_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_orders`
--

DROP TABLE IF EXISTS `wp_wc_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_orders` (
  `id` bigint(20) unsigned NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `tax_amount` decimal(26,8) DEFAULT NULL,
  `total_amount` decimal(26,8) DEFAULT NULL,
  `customer_id` bigint(20) unsigned DEFAULT NULL,
  `billing_email` varchar(320) DEFAULT NULL,
  `date_created_gmt` datetime DEFAULT NULL,
  `date_updated_gmt` datetime DEFAULT NULL,
  `parent_order_id` bigint(20) unsigned DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `payment_method_title` text DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `customer_note` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `date_created` (`date_created_gmt`),
  KEY `customer_id_billing_email` (`customer_id`,`billing_email`(171)),
  KEY `customer_id_status` (`customer_id`,`status`),
  KEY `billing_email` (`billing_email`(191)),
  KEY `transaction_id` (`transaction_id`(20)),
  KEY `type_status_date` (`type`,`status`,`date_created_gmt`),
  KEY `parent_order_id` (`parent_order_id`),
  KEY `date_updated` (`date_updated_gmt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_orders`
--

LOCK TABLES `wp_wc_orders` WRITE;
/*!40000 ALTER TABLE `wp_wc_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_orders_meta`
--

DROP TABLE IF EXISTS `wp_wc_orders_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_orders_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meta_key_value` (`meta_key`(50),`meta_value`(20)),
  KEY `order_id_meta_key_meta_value` (`order_id`,`meta_key`(100),`meta_value`(82))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_orders_meta`
--

LOCK TABLES `wp_wc_orders_meta` WRITE;
/*!40000 ALTER TABLE `wp_wc_orders_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_orders_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_product_attributes_lookup`
--

DROP TABLE IF EXISTS `wp_wc_product_attributes_lookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_product_attributes_lookup` (
  `product_id` bigint(20) NOT NULL,
  `product_or_parent_id` bigint(20) NOT NULL,
  `taxonomy` varchar(32) NOT NULL,
  `term_id` bigint(20) NOT NULL,
  `is_variation_attribute` tinyint(1) NOT NULL,
  `in_stock` tinyint(1) NOT NULL,
  PRIMARY KEY (`product_or_parent_id`,`term_id`,`product_id`,`taxonomy`),
  KEY `is_variation_attribute_term_id` (`is_variation_attribute`,`term_id`),
  KEY `taxonomy_term_id_in_stock_product_or_parent_id` (`taxonomy`,`term_id`,`in_stock`,`product_or_parent_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_product_attributes_lookup`
--

LOCK TABLES `wp_wc_product_attributes_lookup` WRITE;
/*!40000 ALTER TABLE `wp_wc_product_attributes_lookup` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_product_attributes_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_product_download_directories`
--

DROP TABLE IF EXISTS `wp_wc_product_download_directories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_product_download_directories` (
  `url_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(256) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`url_id`),
  KEY `url` (`url`(191))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_product_download_directories`
--

LOCK TABLES `wp_wc_product_download_directories` WRITE;
/*!40000 ALTER TABLE `wp_wc_product_download_directories` DISABLE KEYS */;
INSERT INTO `wp_wc_product_download_directories` VALUES
(1,'file:///var/www/html/wp-content/uploads/woocommerce_uploads/',1),
(2,'http://localhost:8000/wp-content/uploads/woocommerce_uploads/',1);
/*!40000 ALTER TABLE `wp_wc_product_download_directories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_product_meta_lookup`
--

DROP TABLE IF EXISTS `wp_wc_product_meta_lookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_product_meta_lookup` (
  `product_id` bigint(20) NOT NULL,
  `sku` varchar(100) DEFAULT '',
  `global_unique_id` varchar(100) DEFAULT '',
  `virtual` tinyint(1) DEFAULT 0,
  `downloadable` tinyint(1) DEFAULT 0,
  `min_price` decimal(19,4) DEFAULT NULL,
  `max_price` decimal(19,4) DEFAULT NULL,
  `onsale` tinyint(1) DEFAULT 0,
  `stock_quantity` double DEFAULT NULL,
  `stock_status` varchar(100) DEFAULT 'instock',
  `rating_count` bigint(20) DEFAULT 0,
  `average_rating` decimal(3,2) DEFAULT 0.00,
  `total_sales` bigint(20) DEFAULT 0,
  `tax_status` varchar(100) DEFAULT 'taxable',
  `tax_class` varchar(100) DEFAULT '',
  PRIMARY KEY (`product_id`),
  KEY `virtual` (`virtual`),
  KEY `downloadable` (`downloadable`),
  KEY `stock_status` (`stock_status`),
  KEY `stock_quantity` (`stock_quantity`),
  KEY `onsale` (`onsale`),
  KEY `min_max_price` (`min_price`,`max_price`),
  KEY `sku` (`sku`(50))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_product_meta_lookup`
--

LOCK TABLES `wp_wc_product_meta_lookup` WRITE;
/*!40000 ALTER TABLE `wp_wc_product_meta_lookup` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_product_meta_lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_rate_limits`
--

DROP TABLE IF EXISTS `wp_wc_rate_limits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_rate_limits` (
  `rate_limit_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rate_limit_key` varchar(200) NOT NULL,
  `rate_limit_expiry` bigint(20) unsigned NOT NULL,
  `rate_limit_remaining` smallint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`rate_limit_id`),
  UNIQUE KEY `rate_limit_key` (`rate_limit_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_rate_limits`
--

LOCK TABLES `wp_wc_rate_limits` WRITE;
/*!40000 ALTER TABLE `wp_wc_rate_limits` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_rate_limits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_reserved_stock`
--

DROP TABLE IF EXISTS `wp_wc_reserved_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_reserved_stock` (
  `order_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `stock_quantity` double NOT NULL DEFAULT 0,
  `timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expires` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `product_id_expires` (`product_id`,`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_reserved_stock`
--

LOCK TABLES `wp_wc_reserved_stock` WRITE;
/*!40000 ALTER TABLE `wp_wc_reserved_stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_reserved_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_tax_rate_classes`
--

DROP TABLE IF EXISTS `wp_wc_tax_rate_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_tax_rate_classes` (
  `tax_rate_class_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`tax_rate_class_id`),
  UNIQUE KEY `slug` (`slug`(191))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_tax_rate_classes`
--

LOCK TABLES `wp_wc_tax_rate_classes` WRITE;
/*!40000 ALTER TABLE `wp_wc_tax_rate_classes` DISABLE KEYS */;
INSERT INTO `wp_wc_tax_rate_classes` VALUES
(1,'Reduced rate','reduced-rate'),
(2,'Zero rate','zero-rate');
/*!40000 ALTER TABLE `wp_wc_tax_rate_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_wc_webhooks`
--

DROP TABLE IF EXISTS `wp_wc_webhooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_wc_webhooks` (
  `webhook_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(200) NOT NULL,
  `name` text NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `delivery_url` text NOT NULL,
  `secret` text NOT NULL,
  `topic` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_created_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `api_version` smallint(4) NOT NULL,
  `failure_count` smallint(10) NOT NULL DEFAULT 0,
  `pending_delivery` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`webhook_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_wc_webhooks`
--

LOCK TABLES `wp_wc_webhooks` WRITE;
/*!40000 ALTER TABLE `wp_wc_webhooks` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_wc_webhooks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_api_keys`
--

DROP TABLE IF EXISTS `wp_woocommerce_api_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_api_keys` (
  `key_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `permissions` varchar(10) NOT NULL,
  `consumer_key` char(64) NOT NULL,
  `consumer_secret` char(43) NOT NULL,
  `nonces` longtext DEFAULT NULL,
  `truncated_key` char(7) NOT NULL,
  `last_access` datetime DEFAULT NULL,
  PRIMARY KEY (`key_id`),
  KEY `consumer_key` (`consumer_key`),
  KEY `consumer_secret` (`consumer_secret`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_api_keys`
--

LOCK TABLES `wp_woocommerce_api_keys` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_api_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_api_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_attribute_taxonomies`
--

DROP TABLE IF EXISTS `wp_woocommerce_attribute_taxonomies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_attribute_taxonomies` (
  `attribute_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(200) NOT NULL,
  `attribute_label` varchar(200) DEFAULT NULL,
  `attribute_type` varchar(20) NOT NULL,
  `attribute_orderby` varchar(20) NOT NULL,
  `attribute_public` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`attribute_id`),
  KEY `attribute_name` (`attribute_name`(20))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_attribute_taxonomies`
--

LOCK TABLES `wp_woocommerce_attribute_taxonomies` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_attribute_taxonomies` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_attribute_taxonomies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_downloadable_product_permissions`
--

DROP TABLE IF EXISTS `wp_woocommerce_downloadable_product_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_downloadable_product_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `download_id` varchar(36) NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `order_key` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `downloads_remaining` varchar(9) DEFAULT NULL,
  `access_granted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access_expires` datetime DEFAULT NULL,
  `download_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`permission_id`),
  KEY `download_order_key_product` (`product_id`,`order_id`,`order_key`(16),`download_id`),
  KEY `download_order_product` (`download_id`,`order_id`,`product_id`),
  KEY `order_id` (`order_id`),
  KEY `user_order_remaining_expires` (`user_id`,`order_id`,`downloads_remaining`,`access_expires`),
  KEY `idx_user_email` (`user_email`(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_downloadable_product_permissions`
--

LOCK TABLES `wp_woocommerce_downloadable_product_permissions` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_downloadable_product_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_downloadable_product_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_log`
--

DROP TABLE IF EXISTS `wp_woocommerce_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_log` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` datetime NOT NULL,
  `level` smallint(4) NOT NULL,
  `source` varchar(200) NOT NULL,
  `message` longtext NOT NULL,
  `context` longtext DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_log`
--

LOCK TABLES `wp_woocommerce_log` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_order_itemmeta`
--

DROP TABLE IF EXISTS `wp_woocommerce_order_itemmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_order_itemmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_item_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `order_item_id` (`order_item_id`),
  KEY `meta_key` (`meta_key`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_order_itemmeta`
--

LOCK TABLES `wp_woocommerce_order_itemmeta` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_order_itemmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_order_itemmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_order_items`
--

DROP TABLE IF EXISTS `wp_woocommerce_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_order_items` (
  `order_item_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_item_name` text NOT NULL,
  `order_item_type` varchar(200) NOT NULL DEFAULT '',
  `order_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_order_items`
--

LOCK TABLES `wp_woocommerce_order_items` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_payment_tokenmeta`
--

DROP TABLE IF EXISTS `wp_woocommerce_payment_tokenmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_payment_tokenmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_token_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `payment_token_id` (`payment_token_id`),
  KEY `meta_key` (`meta_key`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_payment_tokenmeta`
--

LOCK TABLES `wp_woocommerce_payment_tokenmeta` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_payment_tokenmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_payment_tokenmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_payment_tokens`
--

DROP TABLE IF EXISTS `wp_woocommerce_payment_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_payment_tokens` (
  `token_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gateway_id` varchar(200) NOT NULL,
  `token` text NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `type` varchar(200) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`token_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_payment_tokens`
--

LOCK TABLES `wp_woocommerce_payment_tokens` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_payment_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_payment_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_sessions`
--

DROP TABLE IF EXISTS `wp_woocommerce_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_sessions` (
  `session_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session_key` char(32) NOT NULL,
  `session_value` longtext NOT NULL,
  `session_expiry` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `session_key` (`session_key`),
  KEY `session_expiry` (`session_expiry`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_sessions`
--

LOCK TABLES `wp_woocommerce_sessions` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_sessions` DISABLE KEYS */;
INSERT INTO `wp_woocommerce_sessions` VALUES
(1,'1','a:1:{s:8:\"customer\";s:784:\"a:28:{s:2:\"id\";s:1:\"1\";s:13:\"date_modified\";s:25:\"2026-10-07T02:51:55+00:00\";s:10:\"first_name\";s:0:\"\";s:9:\"last_name\";s:0:\"\";s:7:\"company\";s:0:\"\";s:5:\"phone\";s:0:\"\";s:5:\"email\";s:15:\"admin@gmail.com\";s:7:\"address\";s:0:\"\";s:9:\"address_1\";s:0:\"\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:0:\"\";s:5:\"state\";s:2:\"CA\";s:8:\"postcode\";s:0:\"\";s:7:\"country\";s:2:\"US\";s:19:\"shipping_first_name\";s:0:\"\";s:18:\"shipping_last_name\";s:0:\"\";s:16:\"shipping_company\";s:0:\"\";s:14:\"shipping_phone\";s:0:\"\";s:16:\"shipping_address\";s:0:\"\";s:18:\"shipping_address_1\";s:0:\"\";s:18:\"shipping_address_2\";s:0:\"\";s:13:\"shipping_city\";s:0:\"\";s:14:\"shipping_state\";s:2:\"CA\";s:17:\"shipping_postcode\";s:0:\"\";s:16:\"shipping_country\";s:2:\"US\";s:13:\"is_vat_exempt\";s:0:\"\";s:19:\"calculated_shipping\";s:0:\"\";s:9:\"meta_data\";a:0:{}}\";}',1791946328);
/*!40000 ALTER TABLE `wp_woocommerce_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_shipping_zone_locations`
--

DROP TABLE IF EXISTS `wp_woocommerce_shipping_zone_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_shipping_zone_locations` (
  `location_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `zone_id` bigint(20) unsigned NOT NULL,
  `location_code` varchar(200) NOT NULL,
  `location_type` varchar(40) NOT NULL,
  PRIMARY KEY (`location_id`),
  KEY `zone_id` (`zone_id`),
  KEY `location_type_code` (`location_type`(10),`location_code`(20))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_shipping_zone_locations`
--

LOCK TABLES `wp_woocommerce_shipping_zone_locations` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zone_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zone_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_shipping_zone_methods`
--

DROP TABLE IF EXISTS `wp_woocommerce_shipping_zone_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_shipping_zone_methods` (
  `zone_id` bigint(20) unsigned NOT NULL,
  `instance_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `method_id` varchar(200) NOT NULL,
  `method_order` bigint(20) unsigned NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`instance_id`),
  KEY `zone_id` (`zone_id`),
  KEY `method_id` (`method_id`(20))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_shipping_zone_methods`
--

LOCK TABLES `wp_woocommerce_shipping_zone_methods` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zone_methods` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zone_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_shipping_zones`
--

DROP TABLE IF EXISTS `wp_woocommerce_shipping_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_shipping_zones` (
  `zone_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `zone_name` varchar(200) NOT NULL,
  `zone_order` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`zone_id`),
  KEY `zone_order_id` (`zone_order`,`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_shipping_zones`
--

LOCK TABLES `wp_woocommerce_shipping_zones` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zones` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_shipping_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_tax_rate_locations`
--

DROP TABLE IF EXISTS `wp_woocommerce_tax_rate_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_tax_rate_locations` (
  `location_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_code` varchar(200) NOT NULL,
  `tax_rate_id` bigint(20) unsigned NOT NULL,
  `location_type` varchar(40) NOT NULL,
  PRIMARY KEY (`location_id`),
  KEY `tax_rate_id` (`tax_rate_id`),
  KEY `location_type_code` (`location_type`(10),`location_code`(20))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_tax_rate_locations`
--

LOCK TABLES `wp_woocommerce_tax_rate_locations` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_tax_rate_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_tax_rate_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_woocommerce_tax_rates`
--

DROP TABLE IF EXISTS `wp_woocommerce_tax_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_woocommerce_tax_rates` (
  `tax_rate_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tax_rate_country` varchar(2) NOT NULL DEFAULT '',
  `tax_rate_state` varchar(200) NOT NULL DEFAULT '',
  `tax_rate` varchar(8) NOT NULL DEFAULT '',
  `tax_rate_name` varchar(200) NOT NULL DEFAULT '',
  `tax_rate_priority` bigint(20) unsigned NOT NULL,
  `tax_rate_compound` int(1) NOT NULL DEFAULT 0,
  `tax_rate_shipping` int(1) NOT NULL DEFAULT 1,
  `tax_rate_order` bigint(20) unsigned NOT NULL,
  `tax_rate_class` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`tax_rate_id`),
  KEY `tax_rate_country` (`tax_rate_country`),
  KEY `tax_rate_state` (`tax_rate_state`(2)),
  KEY `tax_rate_class` (`tax_rate_class`(10)),
  KEY `tax_rate_priority` (`tax_rate_priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_woocommerce_tax_rates`
--

LOCK TABLES `wp_woocommerce_tax_rates` WRITE;
/*!40000 ALTER TABLE `wp_woocommerce_tax_rates` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_tax_rates` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-09  4:05:41
