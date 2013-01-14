-- MySQL dump 10.13  Distrib 5.5.16, for Linux (i686)
--
-- Host: localhost    Database: todoplan
-- ------------------------------------------------------
-- Server version	5.5.16-log

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
-- Table structure for table `task_item`
--

DROP TABLE IF EXISTS `task_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_id` int(11) NOT NULL,
  `title` varchar(4096) NOT NULL,
  `content` text,
  `starred` tinyint(4) NOT NULL DEFAULT '0',
  `done` tinyint(4) NOT NULL DEFAULT '0',
  `sort_id` int(11) DEFAULT '0',
  `due_date` datetime DEFAULT NULL,
  `remind_time` datetime DEFAULT NULL,
  `gmt_done` datetime DEFAULT NULL,
  `gmt_update` datetime NOT NULL,
  `gmt_create` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COMMENT='todo plan task item';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_item`
--

LOCK TABLES `task_item` WRITE;
/*!40000 ALTER TABLE `task_item` DISABLE KEYS */;
INSERT INTO `task_item` VALUES (40,999,'task11',NULL,0,0,6,NULL,NULL,'2013-01-10 15:05:08','2013-01-10 15:05:08','2013-01-09 13:04:13'),(39,999,'task10',NULL,0,0,2,NULL,NULL,'2013-01-09 16:18:21','2013-01-09 16:18:21','2013-01-09 13:00:06'),(38,999,'task09',NULL,0,1,2,NULL,NULL,'2013-01-11 13:13:11','2013-01-11 13:13:11','2013-01-09 12:59:23'),(37,999,'task08',NULL,0,0,23,NULL,NULL,'2013-01-11 14:00:33','2013-01-11 14:00:33','2013-01-09 11:21:41'),(36,999,'task07',NULL,0,0,20,NULL,NULL,'2013-01-10 22:55:47','2013-01-10 22:55:47','2013-01-09 11:21:38'),(35,999,'task06',NULL,0,0,19,NULL,NULL,'2013-01-10 22:55:47','2013-01-10 22:55:47','2013-01-09 11:21:36'),(33,999,'task04',NULL,0,0,17,NULL,NULL,'2013-01-10 22:55:46','2013-01-10 22:55:46','2013-01-09 11:21:29'),(30,999,'task01',NULL,0,0,5,NULL,NULL,'2013-01-10 14:45:21','2013-01-10 14:45:21','2013-01-09 11:21:20'),(31,999,'task02',NULL,0,0,15,NULL,NULL,'2013-01-10 22:55:46','2013-01-10 22:55:46','2013-01-09 11:21:23'),(32,999,'task03',NULL,0,0,16,NULL,NULL,'2013-01-10 22:55:46','2013-01-10 22:55:46','2013-01-09 11:21:26'),(34,999,'task05',NULL,0,0,18,NULL,NULL,'2013-01-10 22:55:47','2013-01-10 22:55:47','2013-01-09 11:21:33'),(41,999,'task12',NULL,0,0,7,NULL,NULL,'2013-01-10 15:05:32','2013-01-10 15:05:32','2013-01-09 15:00:43'),(42,999,'te',NULL,0,1,1,NULL,NULL,'2013-01-11 11:47:44','2013-01-11 11:47:44','2013-01-10 11:28:34'),(43,998,'test1',NULL,0,0,1,NULL,NULL,'2013-01-10 22:41:50','2013-01-10 22:41:50','2013-01-10 11:29:49'),(44,998,'test2',NULL,0,0,2,NULL,NULL,'2013-01-10 22:41:51','2013-01-10 22:41:51','2013-01-10 11:29:51'),(45,999,'list-0',NULL,0,0,22,NULL,NULL,'2013-01-11 13:21:30','2013-01-11 13:21:30','2013-01-10 19:02:06'),(46,999,'test`1',NULL,0,0,8,NULL,NULL,'2013-01-10 19:02:27','2013-01-10 19:02:27','2013-01-10 19:02:12'),(48,999,'list1',NULL,0,0,10,NULL,NULL,'2013-01-10 21:29:12','2013-01-10 21:29:12','2013-01-10 20:17:15'),(49,999,'list2',NULL,0,0,9,NULL,NULL,'2013-01-10 21:29:11','2013-01-10 21:29:11','2013-01-10 20:17:16'),(50,999,'list3',NULL,0,0,14,NULL,NULL,'2013-01-10 22:55:45','2013-01-10 22:55:45','2013-01-10 20:17:19'),(51,999,'list4',NULL,0,0,12,NULL,NULL,'2013-01-10 21:49:18','2013-01-10 21:49:18','2013-01-10 20:17:20'),(52,999,'list5',NULL,0,0,11,NULL,NULL,'2013-01-10 21:49:02','2013-01-10 21:49:02','2013-01-10 20:17:22'),(53,999,'list6',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 20:17:24','2013-01-10 20:17:24'),(54,999,'list7',NULL,0,1,5,NULL,NULL,'2013-01-11 19:09:22','2013-01-11 19:09:22','2013-01-10 20:17:34'),(55,999,'list8',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 20:17:41','2013-01-10 20:17:41'),(56,999,'test1',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 21:59:30','2013-01-10 21:59:30'),(57,999,'list23',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 22:01:31','2013-01-10 22:01:31'),(58,999,'ggoo',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 22:01:45','2013-01-10 22:01:45'),(59,999,'test111',NULL,0,0,13,NULL,NULL,'2013-01-10 22:02:46','2013-01-10 22:02:46','2013-01-10 22:02:32'),(60,999,'test',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 22:39:46','2013-01-10 22:39:46'),(61,999,'xixihaha',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 22:39:51','2013-01-10 22:39:51'),(62,999,'sadfa',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 22:39:52','2013-01-10 22:39:52'),(63,999,'asf',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 22:39:53','2013-01-10 22:39:53'),(64,999,'ffsdaf',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 22:39:54','2013-01-10 22:39:54'),(65,999,'eei',NULL,0,1,4,NULL,NULL,'2013-01-11 13:59:10','2013-01-11 13:59:10','2013-01-10 22:39:55'),(66,999,'qxig',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 22:39:57','2013-01-10 22:39:57'),(67,998,'test3',NULL,0,0,3,NULL,NULL,'2013-01-11 14:01:40','2013-01-11 14:01:40','2013-01-10 22:41:22'),(68,998,'test4',NULL,0,1,2,NULL,NULL,'2013-01-11 13:29:33','2013-01-11 13:29:33','2013-01-10 22:41:35'),(69,998,'test5',NULL,0,0,0,NULL,NULL,NULL,'2013-01-10 22:41:57','2013-01-10 22:41:57'),(70,998,'test6',NULL,0,1,1,NULL,NULL,'2013-01-10 22:58:56','2013-01-10 22:58:56','2013-01-10 22:44:46'),(71,997,'test1',NULL,0,0,1,NULL,NULL,'2013-01-10 22:58:37','2013-01-10 22:58:37','2013-01-10 22:58:35'),(72,1003,'testxx',NULL,0,0,1,NULL,NULL,'2013-01-11 15:58:15','2013-01-11 15:58:15','2013-01-11 11:40:23'),(73,1004,'test1',NULL,0,0,2,NULL,NULL,'2013-01-11 15:58:24','2013-01-11 15:58:24','2013-01-11 11:40:35'),(74,1008,'newTask1',NULL,0,0,1,NULL,NULL,'2013-01-11 13:11:52','2013-01-11 13:11:52','2013-01-11 13:11:43'),(75,999,'测试一个中文 ',NULL,0,1,3,NULL,NULL,'2013-01-11 13:22:03','2013-01-11 13:22:03','2013-01-11 13:14:05'),(76,1004,'new test',NULL,0,0,1,NULL,NULL,'2013-01-11 15:58:24','2013-01-11 15:58:24','2013-01-11 15:58:21'),(83,999,'\\\\Tempfile.hz.ali.com\\电影基地\\',NULL,0,0,24,NULL,NULL,NULL,'2013-01-11 18:22:56','2013-01-11 18:22:56');
/*!40000 ALTER TABLE `task_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_list`
--

DROP TABLE IF EXISTS `task_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `list_title` varchar(1024) NOT NULL,
  `deletable` tinyint(4) NOT NULL DEFAULT '1',
  `sort_id` int(11) DEFAULT '0',
  `gmt_update` datetime NOT NULL,
  `gmt_create` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1024 DEFAULT CHARSET=utf8 COMMENT='todo plan task list';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_list`
--

LOCK TABLES `task_list` WRITE;
/*!40000 ALTER TABLE `task_list` DISABLE KEYS */;
INSERT INTO `task_list` VALUES (999,1,'Inbox',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(998,1,'测试一下列表',1,12,'2013-01-11 15:54:32','1000-00-00 00:00:00'),(1000,1,'测试任务',1,1,'2013-01-11 15:54:40','2013-01-11 11:34:00'),(1001,1,'测试1',1,2,'2013-01-11 15:54:52','2013-01-11 11:35:09'),(1002,1,'测试2',1,3,'2013-01-11 15:56:45','2013-01-11 11:38:59'),(1003,1,'测试3',1,4,'2013-01-11 15:56:51','2013-01-11 11:39:21'),(1004,1,'new1',1,5,'2013-01-11 11:40:30','2013-01-11 11:40:30'),(1005,1,'xx',1,6,'2013-01-11 11:41:49','2013-01-11 11:41:49'),(1006,1,'ssd',1,7,'2013-01-11 11:41:53','2013-01-11 11:41:53'),(1007,1,'ss',1,8,'2013-01-11 11:43:05','2013-01-11 11:43:05'),(1008,1,'newList1',1,10,'2013-01-11 15:50:03','2013-01-11 13:11:36'),(1009,1,'列表5',1,13,'2013-01-11 16:08:53','2013-01-11 15:57:07');
/*!40000 ALTER TABLE `task_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `password` varchar(512) NOT NULL DEFAULT '' COMMENT 'md5 password if use todoplan login',
  `email` varchar(45) DEFAULT NULL,
  `login_type` varchar(16) NOT NULL DEFAULT 'local' COMMENT 'login from local site or out website',
  `gmt_update` datetime NOT NULL,
  `gmt_crate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-01-12  1:34:36