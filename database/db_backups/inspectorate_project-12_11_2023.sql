-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: inspectorate_project
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `additional_documents`
--

DROP TABLE IF EXISTS `additional_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `additional_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(225) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int DEFAULT NULL COMMENT 'active= 1, inactive= 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `additional_documents`
--

LOCK TABLES `additional_documents` WRITE;
/*!40000 ALTER TABLE `additional_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `additional_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `inspectorate_id` int NOT NULL,
  `designation_id` int DEFAULT NULL,
  `name` varchar(86) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `lastname` varchar(86) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mobile` varchar(16) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(124) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `password` varchar(124) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '1' COMMENT '1=Active,0=Inactive,2=Deleted',
  `created_at` datetime NOT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `role_id` int DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT 'user',
  `admin_type` varchar(225) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `type` (`type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (92,0,NULL,'Super Admin','','01761955765','admin@gmail.com','$2y$10$qBVDA/DLRKUVAS9bW39H9OBorvEDhS6MJGIqut.eZPCidaDLz4MEC',1,'2021-02-07 11:07:04',85,'2021-12-23 09:07:10',1,'IFigu8PO3arK0X6im5qJBiZ2oRD15VxDweo9CXzFcKeNEJxQA0paNrWXcxCH',11,'admin',''),(111,2,NULL,'job fair admin',NULL,'01761955765','job_fair_admin@gmail.com','$2y$10$LiZ4t.Jx06GzrQzJ5rDx9unFOKWN6rR5.apPnz1SIPDnd/M3Nh0xS',2,'2022-05-19 05:44:13',92,'2023-10-16 16:10:21',NULL,NULL,12,'admin',''),(112,3,NULL,'asdad',NULL,'123123','shuvo@gmail.com','$2y$10$6zgT/gZSe8Nm8AgFiWLk6uMosN7kgc9HO8FJ4QNpBqFSA2ZcOfmEe',2,'2023-09-12 03:45:44',92,'2023-10-22 16:06:04',NULL,NULL,16,'subadmin',''),(113,1,NULL,'happy',NULL,'123123','shuvo@gmail.com','$2y$10$WlWmbKIUQ7hR6GnJbRe/A.I73bDRk/7aBDigIrPFWd5bGShc58oxm',2,'2023-09-12 03:46:56',92,'2023-10-22 16:06:00',NULL,NULL,12,'admin',''),(114,0,NULL,'viewer',NULL,'123123','manjur@gmail.com','$2y$10$W8Mu6MvfKpJUGuOR8k15SOY9rrc1EE7Oinyrala4Xz5K8kFqHXiWe',2,'2023-10-16 16:15:29',92,'2023-10-22 16:05:57',NULL,NULL,20,'admin',''),(115,0,NULL,'shuvo',NULL,'123123','shuvo@gmail.com','$2y$10$ti3bZxFcUgHAuOWpNHaeQ.MDPrEBwxN7E5fl4Bn5FHY3q2pMxEtvi',1,'2023-10-22 16:06:39',92,'2023-10-22 16:06:39',NULL,NULL,12,'admin',''),(116,4,NULL,'Admin_ie&i',NULL,'01894833332','adminie&i@gmail.com','$2y$10$enPJb.Pe8sY5F2u68P2q9eWhUouOt0YIIlic2ir0T3T704Mz2/dnS',1,'2023-10-30 04:07:38',92,'2023-10-30 04:07:38',NULL,NULL,22,'admin','inspe_admin'),(117,5,NULL,'Admin_iv&ee',NULL,'01894834539','adminiv&ee@gmail.com','$2y$10$3RQL5zez/uwSyVswswJl7elTX0pCNP6EdjKBQLatPLWNOcM8wKrLK',1,'2023-10-30 04:10:15',92,'2023-10-30 04:10:15',NULL,NULL,21,'admin','inspe_admin'),(118,6,NULL,'Admin_igs&c',NULL,'01894833331','adminigs&c@gmail.com','$2y$10$njBpRlcbwTI.PBWCPoCRdu/p0Z5OlkK6bVhJnsyob50tuLgr9acLC',1,'2023-10-30 04:12:51',92,'2023-10-30 04:12:51',NULL,NULL,23,'admin','inspe_admin'),(119,7,NULL,'Admin_ia&e',NULL,'01894834567','adminia&e@gmail.com','$2y$10$Z19P1AaPJXKtJ7XSHuPxqOMI8CWnW6huMttPHwSOtXU4vTYqyu.ja',1,'2023-10-30 04:14:12',92,'2023-10-30 04:14:12',NULL,NULL,24,'admin','inspe_admin'),(120,4,1,'Test_EM',NULL,'01894833350','testem@gmail.com','$2y$10$YQx2zoUymlfjtzYuTuwIJu1JAH5XHFJVoYfxVzcGuzsDukh1gvQ6m',2,'2023-10-30 05:23:56',116,'2023-10-31 08:13:11',NULL,NULL,26,'admin',''),(121,0,NULL,'admin1238',NULL,'0189483335oo','admin@gmail.com','$2y$10$IazDEsaJlkVvBLSmkWMfv.3jsfOUqYHI4.KGeOtchenJd4SYqv0GG',2,'2023-10-31 07:50:48',92,'2023-10-31 08:13:05',NULL,NULL,12,'admin','inspe_admin'),(122,4,2,'testeng',NULL,'01894833359','testeng@gmail.com','$2y$10$X8ejx.cPvJkolqObe.xpbuTPC9psGVgRp4FbpTZh5Vju8xzgetatK',1,'2023-11-05 02:57:08',116,'2023-11-05 02:57:08',NULL,NULL,29,'admin','inspe_admin'),(123,4,2,'testengg2',NULL,'01894833332','testengg2@gmail.com','$2y$10$8IrZFANDyd9E11rni4RfROnzgF3h8Tt09o4HQuSi277IElnaq.rm2',1,'2023-11-05 05:00:57',116,'2023-11-05 05:00:57',NULL,NULL,29,'admin','inspe_admin');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designations`
--

DROP TABLE IF EXISTS `designations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `designations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(225) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designations`
--

LOCK TABLES `designations` WRITE;
/*!40000 ALTER TABLE `designations` DISABLE KEYS */;
INSERT INTO `designations` VALUES (1,'CR','2023-11-06 06:23:24','2023-11-06 06:23:24'),(2,'DCI','2023-11-06 06:24:54','2023-11-06 06:24:54');
/*!40000 ALTER TABLE `designations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doc_types`
--

DROP TABLE IF EXISTS `doc_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doc_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `processing_date` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doc_types`
--

LOCK TABLES `doc_types` WRITE;
/*!40000 ALTER TABLE `doc_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `doc_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_tracks`
--

DROP TABLE IF EXISTS `document_tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `document_tracks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int DEFAULT NULL,
  `designation_id` int NOT NULL,
  `doc_type_id` int DEFAULT NULL,
  `check_status` int DEFAULT NULL COMMENT '1=checked, 0=not checked',
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_tracks`
--

LOCK TABLES `document_tracks` WRITE;
/*!40000 ALTER TABLE `document_tracks` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dte_managments`
--

DROP TABLE IF EXISTS `dte_managments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dte_managments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(225) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int DEFAULT NULL COMMENT 'active=1 , inactive=0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dte_managments`
--

LOCK TABLES `dte_managments` WRITE;
/*!40000 ALTER TABLE `dte_managments` DISABLE KEYS */;
INSERT INTO `dte_managments` VALUES (1,'Arumored Core',1,'2023-11-06 08:38:29',NULL),(2,'Artillery',1,'2023-11-06 08:40:19','2023-11-06 08:40:19'),(3,'Infantry',1,'2023-11-06 08:40:55','2023-11-06 08:40:55');
/*!40000 ALTER TABLE `dte_managments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dynamic_routes`
--

DROP TABLE IF EXISTS `dynamic_routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dynamic_routes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `inspectorate_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `controller_action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `function_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'get,post',
  `route_type` tinyint(1) DEFAULT '1' COMMENT '1=main,0=public',
  `parameter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active,0=not active',
  `show_in_menu` int DEFAULT '0' COMMENT '0=no,1=yes',
  `ajax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `url` (`url`) USING BTREE,
  KEY `model_name` (`model_name`) USING BTREE,
  KEY `controller_action` (`controller_action`) USING BTREE,
  KEY `method` (`method`) USING BTREE,
  KEY `show_in_menu` (`show_in_menu`) USING BTREE,
  KEY `ajax` (`ajax`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=423 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dynamic_routes`
--

LOCK TABLES `dynamic_routes` WRITE;
/*!40000 ALTER TABLE `dynamic_routes` DISABLE KEYS */;
INSERT INTO `dynamic_routes` VALUES (1,0,'adminDashboard','adminDashboard','AdminDashboard',NULL,'AdminDashboarController','index','get',1,NULL,1,0,'0',NULL,'2021-01-17 22:36:57'),(3,0,'Show Routs','dynamic_route','Route',NULL,'RouteController','dynamic_route','get',1,NULL,1,1,'0','2020-12-23 17:11:03','2021-03-18 09:19:43'),(4,0,'ADD Route','dynamic_route','Route',NULL,'RouteController','save_dynamic_route','Post',1,NULL,1,0,'0','2020-12-23 17:13:07','2020-12-23 17:13:07'),(5,0,'Roles','role/all_role','Role',NULL,'RoleController','all_role','get',1,NULL,1,1,'0','2020-12-23 17:35:33','2021-06-10 07:00:32'),(6,0,'Add Role','role/add_role','Role',NULL,'RoleController','add_role','get',1,NULL,1,1,'0','2020-12-23 17:36:01','2021-06-10 06:59:12'),(8,0,'save role','save_role','Role',NULL,'RoleController','save_role','Post',1,NULL,1,0,'0','2020-12-23 21:10:26','2020-12-26 17:36:28'),(9,0,'Show Users','all_user','User',NULL,'UserController','all_user','get',1,NULL,1,1,'0','2020-12-23 21:40:53','2021-03-18 09:20:11'),(10,0,'save user','save_user','User',NULL,'UserController','save_user','Post',1,NULL,1,0,'0','2020-12-23 21:54:33','2020-12-23 21:54:33'),(11,0,'Edit Role','edit_role','Role',NULL,'RoleController','edit_role','get',1,'{id}',1,0,'0','2020-12-26 16:22:10','2020-12-26 17:28:54'),(12,0,'Update Role','update_role','Role',NULL,'RoleController','update_role','Post',1,'{id}',1,0,'0','2020-12-26 16:46:07','2021-01-11 22:25:35'),(13,0,'Delete Role','delete_role','Role',NULL,'RoleController','delete_role','get',1,'{id}',1,0,'0','2020-12-26 16:56:05','2020-12-26 16:56:05'),(14,0,'Delete Route','delete_route','Route',NULL,'RouteController','delete_route','get',1,'{id}',1,0,'0','2020-12-26 16:59:22','2020-12-26 16:59:22'),(16,0,'Edit Route','edit_route','Route',NULL,'RouteController','edit_route','get',0,'{id}',1,0,'0','2020-12-26 17:03:02','2020-12-26 17:16:35'),(19,0,'Update Route','update_route','Route',NULL,'RouteController','update_route','Post',1,'{id}',1,0,'0','2020-12-26 17:13:20','2020-12-26 17:13:20'),(91,0,'Chnage Password','admin/change_password','AdminDashboard',NULL,'AdminDashboarController','change_password','get',1,NULL,1,0,'0','2021-01-17 22:38:34','2021-01-18 18:20:41'),(92,0,'Save Change Password','admin/save_change_password','AdminDashboard',NULL,'AdminDashboarController','save_change_password','Post',1,NULL,1,0,'0','2021-01-19 18:04:46','2021-01-19 18:04:46'),(93,0,'Edit User','edit_user','User',NULL,'UserController','edit_user','get',1,'{id}',1,0,'1','2021-01-20 21:42:58','2021-01-20 21:42:58'),(94,0,'Upadte User','upadte_user','User',NULL,'UserController','upadte_user','Post',1,NULL,1,0,'0','2021-01-20 22:11:40','2021-01-20 22:27:28'),(95,0,'Suspend user','suspend_user','User',NULL,'UserController','suspend_user','get',1,'{id}',1,0,'0','2021-01-20 22:34:00','2021-01-20 22:34:00'),(96,0,'unsuspend user','unsuspend_user','User',NULL,'UserController','unsuspend_user','get',1,'{id}',1,0,'0','2021-01-20 22:58:06','2021-01-20 22:58:06'),(127,0,'Delete user','delete_user','User',NULL,'UserController','delete_user','get',1,'{id}',1,0,'0','2021-06-10 06:50:43','2021-06-10 06:50:43'),(130,0,'Test Menu','test','ModelMenu',NULL,'MenuController','getLevel3Childern','get',1,'{id}',1,1,'1','2021-06-24 06:27:04','2021-06-24 06:27:04'),(131,0,'Create menu','menu/menu_create','Menu',NULL,'MenuController','create_menu','get',1,NULL,1,1,'0','2021-06-29 17:33:06','2021-06-29 17:33:06'),(133,0,'Save Menu','menu/menu_save','Menu',NULL,'MenuController','menu_save','Post',1,NULL,1,0,'0','2021-07-04 15:03:45','2021-07-04 15:49:37'),(134,0,'ALL Menu','menu/all_menu','Menu',NULL,'MenuController','all_menu','get',1,NULL,1,1,'0','2021-07-04 16:03:13','2021-07-04 16:03:13'),(135,0,'Search Menu','menu/menu_search','Menu',NULL,'MenuController','menu_search','Post',1,NULL,1,0,'1','2021-07-04 17:15:11','2021-07-04 17:15:11'),(138,0,'Edit Menu','menu/edit_menu','Menu',NULL,'MenuController','edit_menu','get',1,'{id}',1,0,'0','2021-07-05 11:49:25','2021-07-05 11:49:25'),(139,0,'Update Menu','menu/update_menu','Menu',NULL,'MenuController','update_menu','Post',1,'{id}',1,0,'0','2021-07-05 11:50:06','2021-07-05 11:58:36'),(274,0,'Change Password form','password/change_pasword','passwordChange',NULL,'AdminDashboarController','change_pasword','get',1,NULL,1,1,'0','2021-12-23 02:34:00','2021-12-23 02:34:00'),(275,0,'Save Change Password','password/save_change_password','passwordChange',NULL,'AdminDashboarController','save_change_password','Post',1,NULL,1,0,'0','2021-12-23 02:34:57','2021-12-23 03:05:49'),(402,4,'Ie&i_testroute','ie&i_create/','Indent',NULL,'Ie&eController','create','get',1,NULL,1,1,'1','2023-10-29 22:24:35','2023-10-30 00:41:22'),(403,5,'Iv&ee_testroute','Create_iv&ee/','IV&EEModel',NULL,'Iv&eeController','create','Post',1,NULL,1,1,'1','2023-10-29 22:26:25','2023-10-29 22:26:25'),(404,6,'Igs&c_testroute','create_igs&c/','IGS&CModel',NULL,'Igs&cController','create','get',1,NULL,1,1,'1','2023-10-29 22:28:48','2023-10-29 22:28:48'),(405,7,'Ia&e_testroute','ia&e_create/','IA&EModel',NULL,'Ia&eController','create','get',1,NULL,1,1,'1','2023-10-29 22:30:26','2023-10-29 22:30:26'),(406,4,'IE&I','TestRoute_IE&I','TestModel_IE&I',NULL,'TestController_IE&I','TestFunction_IE&I','get',1,NULL,1,1,'1','2023-10-30 00:10:14','2023-10-30 00:10:14'),(407,4,'zzzxcc','zxcc','zxc',NULL,'fsd','dfghh','get',1,'dfgdfg',1,1,'1','2023-10-30 00:13:47','2023-10-30 00:14:17'),(409,0,'SFRSD','FSD/','DSFDS',NULL,'ArmyMemberController','TESRTMENU','get',1,'{id}',1,1,'1','2023-10-31 23:12:29','2023-10-31 23:12:29'),(410,4,'tender','tender/create','Tender',NULL,'TenderController','create','get',1,NULL,1,1,'1','2023-10-31 23:35:10','2023-10-31 23:35:10'),(412,4,'indent','indent/view','Indent',NULL,'IndentController','index','get',1,NULL,1,1,'1','2023-11-01 00:56:51','2023-11-01 01:18:51'),(413,4,'prelimgeneral','prelimgeneral/view','PrelimGeneral',NULL,'PrelimGeneralController','index','get',1,NULL,1,1,'1','2023-11-06 00:03:45','2023-11-06 00:03:45'),(414,4,'prelimgencreate','prelimgeneral/create','PrelimGeneral',NULL,'PrelimGeneralController','create','get',1,NULL,1,1,'1','2023-11-06 01:21:27','2023-11-06 01:21:27'),(415,4,'Items Index','items/index','Items',NULL,'ItemsController','index','get',1,NULL,1,1,'1','2023-11-10 20:21:19','2023-11-10 20:21:19'),(416,4,'Get All Items','items/get_all_data','Items',NULL,'ItemsController','getAllData','Post',1,NULL,1,1,'1','2023-11-10 20:21:19','2023-11-10 20:21:19'),(418,4,'Store Item','items/store','Items',NULL,'ItemsController','store','Post',1,NULL,1,1,'1','2023-11-10 20:21:19','2023-11-10 20:21:19'),(419,4,'Edit Item','items/edit','Items',NULL,'ItemsController','edit','Post',1,NULL,1,1,'1','2023-11-10 20:21:19','2023-11-10 20:21:19'),(420,4,'Update Item','items/update','Items',NULL,'ItemsController','update','Post',1,NULL,1,1,'1','2023-11-10 20:21:19','2023-11-10 20:21:19'),(421,4,'Show Item','items/show','Items',NULL,'ItemsController','show','Get',1,NULL,1,1,'1','2023-11-10 20:21:19','2023-11-10 20:21:19'),(422,4,'Destroy Item','items/destroy','Items',NULL,'ItemsController','destroy','Post',1,NULL,1,1,'1','2023-11-10 20:21:19','2023-11-10 20:21:19');
/*!40000 ALTER TABLE `dynamic_routes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `indents`
--

DROP TABLE IF EXISTS `indents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `indents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inspectorate_id` int NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `details` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indents`
--

LOCK TABLES `indents` WRITE;
/*!40000 ALTER TABLE `indents` DISABLE KEYS */;
INSERT INTO `indents` VALUES (1,4,'IE & I','Details of IE&I'),(2,5,'IV&EE','IV&EE details');
/*!40000 ALTER TABLE `indents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inspectorates`
--

DROP TABLE IF EXISTS `inspectorates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inspectorates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `slag` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspectorates`
--

LOCK TABLES `inspectorates` WRITE;
/*!40000 ALTER TABLE `inspectorates` DISABLE KEYS */;
INSERT INTO `inspectorates` VALUES (4,'IE&I','ie&e','2023-10-30 02:39:10','2023-10-30 02:39:10'),(5,'IV&EE','iv&ee','2023-10-30 02:39:10','2023-10-30 02:39:10'),(6,'IGS&C','igs&c','2023-10-30 02:40:24','2023-10-30 02:40:24'),(7,'IA&E','ia&e','2023-10-30 02:40:24','2023-10-30 02:40:24');
/*!40000 ALTER TABLE `inspectorates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_types`
--

DROP TABLE IF EXISTS `item_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int DEFAULT NULL,
  `name` varchar(225) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int DEFAULT NULL COMMENT 'active = 1, inactive =0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_types`
--

LOCK TABLES `item_types` WRITE;
/*!40000 ALTER TABLE `item_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(225) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `attribute` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'Radio','uncontrolled','2023-11-07 02:44:17','2023-11-07 02:44:17'),(2,'Truck(10 ton)','uncontrolled','2023-11-07 02:44:17','2023-11-07 02:44:17'),(4,'Bus','uncontrolled','2023-11-11 16:03:44','2023-11-11 16:03:44'),(6,'Pen','uncontrolled','2023-11-11 16:05:32','2023-11-11 16:05:32'),(8,'Pencil','uncontrolled','2023-11-11 16:12:29','2023-11-11 16:12:29'),(10,'Book','uncontrolled','2023-11-11 16:16:34','2023-11-11 16:16:34'),(12,'Glass','uncontrolled','2023-11-11 16:19:52','2023-11-11 16:19:52'),(14,'Diary','uncontrolled','2023-11-11 16:24:51','2023-11-11 16:24:51'),(16,'Lamp','uncontrolled','2023-11-11 16:27:49','2023-11-11 16:27:49'),(25,'Weapons','uncontrolled','2023-11-11 17:16:11','2023-11-11 18:21:59');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_menu`
--

DROP TABLE IF EXISTS `master_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_menu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int NOT NULL,
  `menu_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `menu_name_bn` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `menu_parent_id` bigint unsigned DEFAULT NULL,
  `menu_is_active` int DEFAULT NULL,
  `menu_icon_class` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `menu_dynamic_route_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_menu_parent_id` (`menu_parent_id`) USING BTREE,
  CONSTRAINT `fk_menu_parent_id` FOREIGN KEY (`menu_parent_id`) REFERENCES `master_menu` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_menu`
--

LOCK TABLES `master_menu` WRITE;
/*!40000 ALTER TABLE `master_menu` DISABLE KEYS */;
INSERT INTO `master_menu` VALUES (1,0,'Dashboard','ড্যাশবোর্ড',NULL,0,'ik-home',1,'2023-09-11 17:27:05','2023-09-11 11:27:05',1,92);
/*!40000 ALTER TABLE `master_menu` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_09_18_033200_create_floors_table',2),(6,'2023_09_19_032952_create_halls_table',3),(7,'2023_09_20_042546_create_shifts_table',4),(8,'2023_09_20_062818_create_hall_accessories_facilities_table',5),(9,'2023_09_21_034616_create_user_categories_table',6),(10,'2023_09_21_052021_create_hall_prices_table',7),(11,'2023_09_24_051424_create_others_prices_table',8),(12,'2023_09_24_063127_create_settings_table',9),(13,'2023_09_25_032226_create_booking_cancellation_rules_table',10),(14,'2023_09_25_054810_create_booking_change_rules_table',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('user@gmail.com','kOhs7z3ESVOCZMtRtya5ZcYkfwk8GVRBIprSLHZyM6KY9LaAcTaXQ3apZv4TP7YY','2022-05-22 00:37:08'),('user@gmail.com','MMmiu9fBl8IRGkf6PJA6SDjff4GSPGHIoEp8DIHTFIXSkeh6kubDy4Lga68lAS7r','2022-05-22 00:38:19'),('user@gmail.com','LIfTsKgvWNigkwFxonbhtUrBFTKzId908bLirwRThMY9D6w5kN4NZHLDzvXfQjoU','2022-05-22 00:38:29'),('user@gmail.com','rBuNN7X6pdcRYGrXtFVjbbbwTkSiksQfKoDDsZh2zWhaeUhSHhDMNYcH2peJWkQd','2022-05-22 00:39:06'),('user@gmail.com','apMaBrO9CbSFvCRVG26bVC85QcTyv3JsLXB1cHuCT53rNommbFWAdpIBTmqwRHqq','2022-05-22 00:39:35'),('user@gmail.com','XXO1M6XBaEfzvNabByWfYVu307KCTQl6FU8bkN6qxHEFZb6REa733fLj5LOYEn8v','2022-05-22 00:40:02'),('rhythms@outlook.com','bxlrulG4eG7yTv3nXTBtcWxvuHbILWlCpDfzq6L2SjDrBnS6XQ1gDIw95kNiaexE','2022-05-22 22:01:00'),('rhythms@outlook.com','6lvEqaGysQpuy2JbN0OVoXvmGWaDtgeAK5MyRuNwZT4fpLRxHqXyUSLFcnMRvdir','2022-05-22 22:05:28'),('rhythms@outlook.com','jJ1oE2sPFjsgmf0DwPlm1fbRxxAeIDgojxvkMhYSGzQi9dcwo3qsO2C9sYDCHa2V','2022-05-22 22:06:17'),('rhythms@outlook.com','WqytRUclAiNYmjWTMYKst3pSzGOvXnyzCpc4TlcvTp6eaHydPPPt9lr7xBfSTQyH','2022-05-22 22:07:17'),('rhythms@outlook.com','RTS5zKRx7LqaCEwMXknmcYzoJcYLUmK6Jj5mbec5I0NjNI4KDihIYqYqosINcu7I','2022-05-22 22:07:20'),('rhythms@outlook.com','KscypHsHe6KYtNFOxEEwDs2pQZefDNCknfuqIcTa6ChpJgcECpbildRAqYHZjYiN','2022-05-22 22:07:47'),('khasrur8@gmail.com','CrhW9E75ckpPk2VgdztcMMumQZ9UzZtVCfX23IVHrVpltOM8gN23gog6BnxLpWP8','2022-05-22 22:42:17'),('3434@sdds','qJxuVUaWRWbD4T68keMzT80HdzGWh3mK7P7dSRYUXDrbmzdpgkIxPesLQneklyxZ','2022-05-22 22:45:11'),('khasrur8@gmail.com','fDTT1sso1nMPvV0zKWjUTuTfLun9vZQFLRtvodYgTdv4eaItF2vOeyfRQggBaBQj','2022-05-22 22:46:06'),('khasrur8@gmail.com','cGUqE3BHV5dP8Hh30wFigi6SUpjCQ4xFhBfEjarFWcEDcAHj4pJGScN44E0bk0JB','2022-05-22 22:58:46'),('khasrur8@gmail.com','vxCGETQiYA7CgEzrMCbzMLJklnWF5jJGfOpjI3GprWUzDMJckfCnz4xlZeVUb0s7','2022-05-22 22:59:22'),('rhythms@outlook.com','b3N8UaLnESp8aI7W3DQjybSOnu5omgghRCJrWcOW26GiyZdh27d1h61eRR8NE45h','2022-05-22 23:03:27'),('rhythms@outlook.com','wYm92Gv1hbEbPE1H9fZVmU06bsrU0wtd4weO1hXzKdVnmLqpClkB3YMUQbcXR56q','2022-05-22 23:03:50'),('rhythms@outlook.com','hb680E4eXdfLBWU9DcOBBCXUToJGSaGq3C5cX93iyasgaafDtsp6r67fRmRZm2cK','2022-05-22 23:05:34'),('rhythms@outlook.com','a4Jhba5fmZ8okVHJGfOICtLGY80nJvMQpdmdsWhr8jPl0xpfPeqC2G6dnLHkSYGw','2022-05-22 23:11:14'),('rhythms@outlook.com','ksA3kgPwy2u6sD9wi7WE7bzs0jBWFhnucnNu6EPivclr9Mcjih2G89VUm3rcVIwD','2022-05-22 23:11:53'),('rhythms@outlook.com','arGpG0T640t7GuONcjoCEcQMqTzDbtcU37JFgcB3547cu1p4Zx9plDUDnv5aruBj','2022-05-22 23:12:22'),('khasrur8@gmail.com','zPkQFcgaHvf3sU2coXIPZx7X6e3OoYcziAb6lz8O1o3ijBysCocJjIq7AgPyDjFJ','2022-05-22 23:12:50'),('khasrur8@gmail.com','5tfnIjLw2bSfuKmTY8aVjcz2Rlg9XvfUkIDVAoQujsIUbKx1zGpC5lwjokEsWALS','2022-05-22 23:33:35'),('user@gmail.com','kOhs7z3ESVOCZMtRtya5ZcYkfwk8GVRBIprSLHZyM6KY9LaAcTaXQ3apZv4TP7YY','2022-05-22 00:37:08'),('user@gmail.com','MMmiu9fBl8IRGkf6PJA6SDjff4GSPGHIoEp8DIHTFIXSkeh6kubDy4Lga68lAS7r','2022-05-22 00:38:19'),('user@gmail.com','LIfTsKgvWNigkwFxonbhtUrBFTKzId908bLirwRThMY9D6w5kN4NZHLDzvXfQjoU','2022-05-22 00:38:29'),('user@gmail.com','rBuNN7X6pdcRYGrXtFVjbbbwTkSiksQfKoDDsZh2zWhaeUhSHhDMNYcH2peJWkQd','2022-05-22 00:39:06'),('user@gmail.com','apMaBrO9CbSFvCRVG26bVC85QcTyv3JsLXB1cHuCT53rNommbFWAdpIBTmqwRHqq','2022-05-22 00:39:35'),('user@gmail.com','XXO1M6XBaEfzvNabByWfYVu307KCTQl6FU8bkN6qxHEFZb6REa733fLj5LOYEn8v','2022-05-22 00:40:02'),('rhythms@outlook.com','bxlrulG4eG7yTv3nXTBtcWxvuHbILWlCpDfzq6L2SjDrBnS6XQ1gDIw95kNiaexE','2022-05-22 22:01:00'),('rhythms@outlook.com','6lvEqaGysQpuy2JbN0OVoXvmGWaDtgeAK5MyRuNwZT4fpLRxHqXyUSLFcnMRvdir','2022-05-22 22:05:28'),('rhythms@outlook.com','jJ1oE2sPFjsgmf0DwPlm1fbRxxAeIDgojxvkMhYSGzQi9dcwo3qsO2C9sYDCHa2V','2022-05-22 22:06:17'),('rhythms@outlook.com','WqytRUclAiNYmjWTMYKst3pSzGOvXnyzCpc4TlcvTp6eaHydPPPt9lr7xBfSTQyH','2022-05-22 22:07:17'),('rhythms@outlook.com','RTS5zKRx7LqaCEwMXknmcYzoJcYLUmK6Jj5mbec5I0NjNI4KDihIYqYqosINcu7I','2022-05-22 22:07:20'),('rhythms@outlook.com','KscypHsHe6KYtNFOxEEwDs2pQZefDNCknfuqIcTa6ChpJgcECpbildRAqYHZjYiN','2022-05-22 22:07:47'),('khasrur8@gmail.com','CrhW9E75ckpPk2VgdztcMMumQZ9UzZtVCfX23IVHrVpltOM8gN23gog6BnxLpWP8','2022-05-22 22:42:17'),('3434@sdds','qJxuVUaWRWbD4T68keMzT80HdzGWh3mK7P7dSRYUXDrbmzdpgkIxPesLQneklyxZ','2022-05-22 22:45:11'),('khasrur8@gmail.com','fDTT1sso1nMPvV0zKWjUTuTfLun9vZQFLRtvodYgTdv4eaItF2vOeyfRQggBaBQj','2022-05-22 22:46:06'),('khasrur8@gmail.com','cGUqE3BHV5dP8Hh30wFigi6SUpjCQ4xFhBfEjarFWcEDcAHj4pJGScN44E0bk0JB','2022-05-22 22:58:46'),('khasrur8@gmail.com','vxCGETQiYA7CgEzrMCbzMLJklnWF5jJGfOpjI3GprWUzDMJckfCnz4xlZeVUb0s7','2022-05-22 22:59:22'),('rhythms@outlook.com','b3N8UaLnESp8aI7W3DQjybSOnu5omgghRCJrWcOW26GiyZdh27d1h61eRR8NE45h','2022-05-22 23:03:27'),('rhythms@outlook.com','wYm92Gv1hbEbPE1H9fZVmU06bsrU0wtd4weO1hXzKdVnmLqpClkB3YMUQbcXR56q','2022-05-22 23:03:50'),('rhythms@outlook.com','hb680E4eXdfLBWU9DcOBBCXUToJGSaGq3C5cX93iyasgaafDtsp6r67fRmRZm2cK','2022-05-22 23:05:34'),('rhythms@outlook.com','a4Jhba5fmZ8okVHJGfOICtLGY80nJvMQpdmdsWhr8jPl0xpfPeqC2G6dnLHkSYGw','2022-05-22 23:11:14'),('rhythms@outlook.com','ksA3kgPwy2u6sD9wi7WE7bzs0jBWFhnucnNu6EPivclr9Mcjih2G89VUm3rcVIwD','2022-05-22 23:11:53'),('rhythms@outlook.com','arGpG0T640t7GuONcjoCEcQMqTzDbtcU37JFgcB3547cu1p4Zx9plDUDnv5aruBj','2022-05-22 23:12:22'),('khasrur8@gmail.com','zPkQFcgaHvf3sU2coXIPZx7X6e3OoYcziAb6lz8O1o3ijBysCocJjIq7AgPyDjFJ','2022-05-22 23:12:50'),('khasrur8@gmail.com','5tfnIjLw2bSfuKmTY8aVjcz2Rlg9XvfUkIDVAoQujsIUbKx1zGpC5lwjokEsWALS','2022-05-22 23:33:35');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_roles`
--

DROP TABLE IF EXISTS `permission_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned NOT NULL,
  `dynamic_route_id` bigint unsigned NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `permission_roles_role_id_foreign` (`role_id`) USING BTREE,
  KEY `permission_roles_dynamic_route_id_foreign` (`dynamic_route_id`) USING BTREE,
  KEY `dynamic_route_id` (`dynamic_route_id`) USING BTREE,
  KEY `role_id` (`role_id`) USING BTREE,
  CONSTRAINT `permission_roles_ibfk_1` FOREIGN KEY (`dynamic_route_id`) REFERENCES `dynamic_routes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19086 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_roles`
--

LOCK TABLES `permission_roles` WRITE;
/*!40000 ALTER TABLE `permission_roles` DISABLE KEYS */;
INSERT INTO `permission_roles` VALUES (10467,16,1,'adminDashboard','2021-06-24 06:43:48','2021-06-24 06:43:48'),(10468,16,91,'admin/change_password','2021-06-24 06:43:48','2021-06-24 06:43:48'),(10469,16,92,'admin/save_change_password','2021-06-24 06:43:48','2021-06-24 06:43:48'),(10470,16,9,'all_user','2021-06-24 06:43:48','2021-06-24 06:43:48'),(10471,16,93,'edit_user','2021-06-24 06:43:48','2021-06-24 06:43:48'),(10472,16,94,'upadte_user','2021-06-24 06:43:48','2021-06-24 06:43:48'),(10473,16,95,'suspend_user','2021-06-24 06:43:48','2021-06-24 06:43:48'),(10474,16,96,'unsuspend_user','2021-06-24 06:43:48','2021-06-24 06:43:48'),(10475,16,130,'test','2021-06-24 06:43:48','2021-06-24 06:43:48'),(13970,12,1,'adminDashboard','2021-12-29 22:37:31','2021-12-29 22:37:31'),(13971,12,91,'admin/change_password','2021-12-29 22:37:31','2021-12-29 22:37:31'),(13972,12,92,'admin/save_change_password','2021-12-29 22:37:31','2021-12-29 22:37:31'),(13986,12,274,'password/change_pasword','2021-12-29 22:37:31','2021-12-29 22:37:31'),(13987,12,275,'password/save_change_password','2021-12-29 22:37:31','2021-12-29 22:37:31'),(18010,28,402,'ie&i_create/','2023-10-29 23:18:53','2023-10-29 23:18:53'),(18012,30,402,'ie&i_create/','2023-10-29 23:19:10','2023-10-29 23:19:10'),(18310,23,1,'adminDashboard','2023-11-01 00:29:45','2023-11-01 00:29:45'),(18311,23,91,'admin/change_password','2023-11-01 00:29:45','2023-11-01 00:29:45'),(18312,23,92,'admin/save_change_password','2023-11-01 00:29:45','2023-11-01 00:29:45'),(18313,23,5,'role/all_role','2023-11-01 00:29:45','2023-11-01 00:29:45'),(18314,23,6,'role/add_role','2023-11-01 00:29:45','2023-11-01 00:29:45'),(18315,23,8,'save_role','2023-11-01 00:29:45','2023-11-01 00:29:45'),(18316,23,11,'edit_role','2023-11-01 00:29:45','2023-11-01 00:29:45'),(18317,23,12,'update_role','2023-11-01 00:29:45','2023-11-01 00:29:45'),(18318,23,13,'delete_role','2023-11-01 00:29:45','2023-11-01 00:29:45'),(18319,23,402,'ie&i_create/','2023-11-01 00:29:45','2023-11-01 00:29:45'),(18320,23,410,'tender/create','2023-11-01 00:29:45','2023-11-01 00:29:45'),(18321,24,1,'adminDashboard','2023-11-01 00:30:03','2023-11-01 00:30:03'),(18322,24,91,'admin/change_password','2023-11-01 00:30:03','2023-11-01 00:30:03'),(18323,24,92,'admin/save_change_password','2023-11-01 00:30:03','2023-11-01 00:30:03'),(18324,24,5,'role/all_role','2023-11-01 00:30:03','2023-11-01 00:30:03'),(18325,24,6,'role/add_role','2023-11-01 00:30:03','2023-11-01 00:30:03'),(18326,24,8,'save_role','2023-11-01 00:30:03','2023-11-01 00:30:03'),(18327,24,11,'edit_role','2023-11-01 00:30:03','2023-11-01 00:30:03'),(18328,24,12,'update_role','2023-11-01 00:30:03','2023-11-01 00:30:03'),(18329,24,13,'delete_role','2023-11-01 00:30:03','2023-11-01 00:30:03'),(18330,24,402,'ie&i_create/','2023-11-01 00:30:03','2023-11-01 00:30:03'),(18331,24,410,'tender/create','2023-11-01 00:30:04','2023-11-01 00:30:04'),(18649,27,402,'ie&i_create/','2023-11-01 21:19:24','2023-11-01 21:19:24'),(18650,27,412,'indent/view','2023-11-01 21:19:24','2023-11-01 21:19:24'),(18736,21,1,'adminDashboard','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18737,21,91,'admin/change_password','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18738,21,92,'admin/save_change_password','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18739,21,5,'role/all_role','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18740,21,6,'role/add_role','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18741,21,8,'save_role','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18742,21,11,'edit_role','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18743,21,12,'update_role','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18744,21,13,'delete_role','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18745,21,9,'all_user','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18746,21,10,'save_user','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18747,21,93,'edit_user','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18748,21,94,'upadte_user','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18749,21,95,'suspend_user','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18750,21,96,'unsuspend_user','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18751,21,127,'delete_user','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18752,21,402,'ie&i_create/','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18753,21,412,'indent/view','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18754,21,410,'tender/create','2023-11-02 02:29:09','2023-11-02 02:29:09'),(18769,26,1,'adminDashboard','2023-11-04 23:59:09','2023-11-04 23:59:09'),(18770,26,91,'admin/change_password','2023-11-04 23:59:09','2023-11-04 23:59:09'),(18771,26,92,'admin/save_change_password','2023-11-04 23:59:09','2023-11-04 23:59:09'),(18772,26,402,'ie&i_create/','2023-11-04 23:59:09','2023-11-04 23:59:09'),(18773,26,412,'indent/view','2023-11-04 23:59:09','2023-11-04 23:59:09'),(18774,29,1,'adminDashboard','2023-11-04 23:59:23','2023-11-04 23:59:23'),(18775,29,91,'admin/change_password','2023-11-04 23:59:24','2023-11-04 23:59:24'),(18776,29,92,'admin/save_change_password','2023-11-04 23:59:24','2023-11-04 23:59:24'),(18777,29,402,'ie&i_create/','2023-11-04 23:59:24','2023-11-04 23:59:24'),(18778,29,412,'indent/view','2023-11-04 23:59:24','2023-11-04 23:59:24'),(18832,22,1,'adminDashboard','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18833,22,91,'admin/change_password','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18834,22,92,'admin/save_change_password','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18835,22,5,'role/all_role','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18836,22,6,'role/add_role','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18837,22,8,'save_role','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18838,22,11,'edit_role','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18839,22,12,'update_role','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18840,22,13,'delete_role','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18841,22,9,'all_user','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18842,22,10,'save_user','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18843,22,93,'edit_user','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18844,22,94,'upadte_user','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18845,22,95,'suspend_user','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18846,22,96,'unsuspend_user','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18847,22,127,'delete_user','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18848,22,130,'test','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18849,22,131,'menu/menu_create','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18850,22,133,'menu/menu_save','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18851,22,134,'menu/all_menu','2023-11-06 00:21:25','2023-11-06 00:21:25'),(18852,22,274,'password/change_pasword','2023-11-06 00:21:26','2023-11-06 00:21:26'),(18853,22,275,'password/save_change_password','2023-11-06 00:21:26','2023-11-06 00:21:26'),(18854,22,402,'ie&i_create/','2023-11-06 00:21:26','2023-11-06 00:21:26'),(18855,22,412,'indent/view','2023-11-06 00:21:26','2023-11-06 00:21:26'),(18856,22,409,'FSD/','2023-11-06 00:21:26','2023-11-06 00:21:26'),(18857,22,410,'tender/create','2023-11-06 00:21:26','2023-11-06 00:21:26'),(18858,22,413,'prelimgeneral/view','2023-11-06 00:21:26','2023-11-06 00:21:26'),(19044,11,1,'adminDashboard','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19045,11,91,'admin/change_password','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19046,11,92,'admin/save_change_password','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19047,11,3,'dynamic_route','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19048,11,4,'dynamic_route','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19049,11,14,'delete_route','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19050,11,16,'edit_route','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19051,11,19,'update_route','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19052,11,5,'role/all_role','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19053,11,6,'role/add_role','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19054,11,8,'save_role','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19055,11,11,'edit_role','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19056,11,12,'update_role','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19057,11,13,'delete_role','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19058,11,9,'all_user','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19059,11,10,'save_user','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19060,11,93,'edit_user','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19061,11,94,'upadte_user','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19062,11,95,'suspend_user','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19063,11,96,'unsuspend_user','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19064,11,127,'delete_user','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19065,11,130,'test','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19066,11,131,'menu/menu_create','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19067,11,133,'menu/menu_save','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19068,11,134,'menu/all_menu','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19069,11,135,'menu/menu_search','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19070,11,138,'menu/edit_menu','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19071,11,139,'menu/update_menu','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19072,11,274,'password/change_pasword','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19073,11,275,'password/save_change_password','2023-11-11 17:12:40','2023-11-11 17:12:40'),(19074,11,402,'ie&i_create/','2023-11-11 17:12:41','2023-11-11 17:12:41'),(19075,11,412,'indent/view','2023-11-11 17:12:41','2023-11-11 17:12:41'),(19076,11,410,'tender/create','2023-11-11 17:12:41','2023-11-11 17:12:41'),(19077,11,413,'prelimgeneral/view','2023-11-11 17:12:41','2023-11-11 17:12:41'),(19078,11,414,'prelimgeneral/create','2023-11-11 17:12:41','2023-11-11 17:12:41'),(19079,11,415,'items/index','2023-11-11 17:12:41','2023-11-11 17:12:41'),(19080,11,416,'items/get_all_data','2023-11-11 17:12:41','2023-11-11 17:12:41'),(19081,11,418,'items/store','2023-11-11 17:12:41','2023-11-11 17:12:41'),(19082,11,419,'items/edit','2023-11-11 17:12:41','2023-11-11 17:12:41'),(19083,11,420,'items/update','2023-11-11 17:12:41','2023-11-11 17:12:41'),(19084,11,421,'items/show','2023-11-11 17:12:41','2023-11-11 17:12:41'),(19085,11,422,'items/destroy','2023-11-11 17:12:41','2023-11-11 17:12:41');
/*!40000 ALTER TABLE `permission_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `premlimgeneral_spec`
--

DROP TABLE IF EXISTS `premlimgeneral_spec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `premlimgeneral_spec` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender` int DEFAULT NULL,
  `reference_no` int DEFAULT NULL,
  `spec_type` varchar(225) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `additional_documents` varchar(225) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `item` int DEFAULT NULL,
  `item_type` int NOT NULL,
  `spec_received_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `received_by` int NOT NULL,
  `checked_status` int NOT NULL,
  `revised_sataus` int NOT NULL,
  `remark` varchar(225) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `premlimgeneral_spec`
--

LOCK TABLES `premlimgeneral_spec` WRITE;
/*!40000 ALTER TABLE `premlimgeneral_spec` DISABLE KEYS */;
/*!40000 ALTER TABLE `premlimgeneral_spec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `inspectorate_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `roles_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (11,0,'Super Admin','super_admin','2021-01-12 00:43:52','2021-01-12 00:43:52'),(12,2,'Admin','admin','2021-01-21 02:25:27','2021-01-21 02:25:27'),(16,3,'SubAdmin','subadmin','2021-04-26 17:53:50','2021-04-26 17:53:50'),(21,5,'IV&EE','ivee','2023-10-29 21:44:10','2023-10-29 21:44:10'),(22,4,'IE&I','iei','2023-10-29 21:45:57','2023-10-31 23:56:37'),(23,6,'IGS&C','igsc','2023-10-29 21:47:11','2023-10-29 21:47:11'),(24,7,'IA&E','iae','2023-10-29 21:47:50','2023-10-29 21:47:50'),(26,4,'EM','em','2023-10-29 22:53:42','2023-10-29 23:18:42'),(27,4,'SIG','sig','2023-10-29 23:17:58','2023-10-29 23:17:58'),(28,4,'DEV','dev','2023-10-29 23:18:53','2023-10-29 23:18:53'),(29,4,'ENGG','engg','2023-10-29 23:19:01','2023-10-29 23:19:01'),(30,4,'ACF','acf','2023-10-29 23:19:10','2023-10-29 23:19:10');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL,
  `name` varchar(86) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `lastname` varchar(86) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(124) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `password` varchar(124) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `submit_status` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT '0' COMMENT '1=sumited, 0=not submited, 2=pending , 3 = Approved',
  `gender` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '1=Active,0=Inactive,2=Deleted',
  `country` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `course` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `disapproval_reason` longtext COLLATE utf8mb3_unicode_ci,
  `passport_status` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `submit_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version` int DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (109,'Test course Member',NULL,NULL,'user@gmail.com','$2y$10$aYztU1Lijx81Z8OW9LRe2OiSpORhbaFSPh6/rvd7IYWCmCF22BIba','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2021-11-28 04:00:05',NULL,'2021-11-28 04:00:05',NULL,NULL),(238,'Jayme Morton',NULL,'Ex sit sint duis of','rycecuwi@mailinator.com','$2y$10$EguyK5cWKbem8a6st7glCOMZxriB9okfZNaPcaAgl51Aic9UG8OQ6','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-18 13:08:45',NULL,'2022-05-18 13:08:45',NULL,NULL),(239,'MD Nazmus Sadat',NULL,'01769006627','sadat0311@gmail.com','$2y$10$aU6tqkD.X8RndGzLiUORDOb8rJfVyIMlzB1Eqn77H6lL1OAcgSB8q','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-18 15:50:52',NULL,'2022-05-18 15:50:52',NULL,NULL),(240,'sss',NULL,'01761955765','labony277@gmail.com','$2y$10$KKErUAYQnP.6FW6Pro.vX.66bd9elN2G53B9KNSQ2X7t.aVxAWkh2','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-19 03:32:05',NULL,'2022-05-19 03:32:05',NULL,NULL),(241,'Md.imam hossain',NULL,'01623898455','imam7bir@gmail.com','$2y$10$MnWNk86WpHDPtbDbIvSbjuSKMaS0t0sUMDelriCIB6Y6k0yXOqTaW','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-19 03:34:08',NULL,'2022-05-19 03:34:08',NULL,NULL),(242,'Scarlett Stafford',NULL,'Exercitation saepe e','kareva@mailinator.com','$2y$10$aKxvd.0uUiZbIM7b6jI0HOOHUP6KwP0I0zamaFrsGUuvGf3Hk.4yy','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-19 03:39:13',NULL,'2022-05-19 03:39:13',NULL,NULL),(243,'Md Sahadad Bin Arif',NULL,'01811111820','bushratasin@gmail.com','$2y$10$qv9D0Qgr.OOhAW2aT0LM6uny9e0A5xNguAzM5PDPvxxAbbxgIKKu6','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-19 07:55:41',NULL,'2022-05-19 07:55:41',NULL,NULL),(244,'Md Delwar Hossain',NULL,'01720944859','delwarhossain28606@gmail.com','$2y$10$CQy.BE22FRXskg4VPubqTey325w4KHhdI0vdRuUc9gVWzKdJpZMrG','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-19 07:58:35',NULL,'2022-05-19 07:58:35',NULL,NULL),(245,'Md Enamul Haque',NULL,'01714707331','enamulhaque32453@gmail.com','$2y$10$co64uKDtrysQYi3ErfqoEO7hGDHck6faYjVl5wReximYzNpfYF2CW','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-19 08:13:57',NULL,'2022-05-19 08:13:57',NULL,NULL),(246,'MD. REZAUL KARIM',NULL,'01724731547','rezaulkarim45593@gmail.com','$2y$10$WrghEIzkor3TBFF8kUeK4ura2vy/GaAKv0sxZ/qjk5iTrtFBp9YRi','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-19 16:10:48',NULL,'2022-05-19 16:10:48',NULL,NULL),(247,'Mohammad Jakir Hossen',NULL,'01740738421','jakirchowdhury00848@gmail.com','$2y$10$wtGZppFroqb9IgwtBLLWnuqtG/CVK10hAuZJi.rNYLGSlLeTSICN2','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-19 16:58:44',NULL,'2022-05-19 16:58:44',NULL,NULL),(248,'Sumaiya Yesmin',NULL,'01762205907','sumaiya1096@gmail.com','$2y$10$mQ/XGHTPDQ/9O6MTUS8q..bLD4gNV4m/POsrCqTfu6tPDPKLPbUNW','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-22 07:21:18',NULL,'2022-05-22 07:21:18',NULL,NULL),(249,'Muhammad Rasel Mia',NULL,'01716-086829','raselahmed1823@gmail.com','$2y$10$2q7Mr/3nDlKt5YonN7rzfuFMqP7a04.U3ncpEiE8feSCl5xHI6ify','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-22 07:57:20',NULL,'2022-05-22 07:57:20',NULL,NULL),(250,'BADRUL ALAM',NULL,'008801616095116','badruluae@gmail.com','$2y$10$EIo1.KNpOW5utbYDN/e16.F9ZTLLbN3Lkz9t24UEYnXxp8w0MyqV6','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-22 10:49:04',NULL,'2022-05-22 10:49:04',NULL,NULL),(251,'Shazzadul Islam',NULL,'01914402850','shazzadbd@gmail.com','$2y$10$GUMQKvLUyHk6jBfKp1X0VO7cH3kVkiVCO3Z7CbsExKK5R2iiuxEum','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-23 03:20:51',NULL,'2022-05-23 03:20:51',NULL,NULL),(252,'Fardin Sabahat Khan',NULL,'01798324475','fardin41@gmail.com','$2y$10$eIKL/X3M0KJKlqFuBmRpIuGrP/8mAnGoLK72JWgQKRlXJeJrjHil2','0',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-23 04:56:15',NULL,'2022-05-23 04:56:15',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-12  6:25:20
