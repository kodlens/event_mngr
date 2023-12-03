/*
SQLyog Ultimate v12.14 (64 bit)
MySQL - 10.4.28-MariaDB : Database - event_mngr
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`event_mngr` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `event_mngr`;

/*Table structure for table `academic_years` */

DROP TABLE IF EXISTS `academic_years`;

CREATE TABLE `academic_years` (
  `academic_year_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_code` varchar(255) DEFAULT NULL,
  `academic_year_desc` varchar(255) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`academic_year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `academic_years` */

insert  into `academic_years`(`academic_year_id`,`academic_year_code`,`academic_year_desc`,`active`,`created_at`,`updated_at`) values 
(1,'2022-2023-1','1ST SEMESTER ACADEMIC YEAR 2022-2023',1,NULL,NULL),
(2,'2022-2023-2','2ND SEMESTER ACADEMIC YEAR 2022-2023',0,NULL,NULL),
(3,'2022-2023-S','SUMMER ACADEMIC YEAR 2022-2023',0,NULL,NULL),
(4,'2022-2023-1','1ST SEMESTER ACADEMIC YEAR 2022-2023',1,NULL,NULL),
(5,'2022-2023-2','2ND SEMESTER ACADEMIC YEAR 2022-2023',0,NULL,NULL),
(6,'2022-2023-S','SUMMER ACADEMIC YEAR 2022-2023',0,NULL,NULL),
(7,'2022-2023-1','1ST SEMESTER ACADEMIC YEAR 2022-2023',1,NULL,NULL),
(8,'2022-2023-2','2ND SEMESTER ACADEMIC YEAR 2022-2023',0,NULL,NULL),
(9,'2022-2023-S','SUMMER ACADEMIC YEAR 2022-2023',0,NULL,NULL);

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `department_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `departments` */

insert  into `departments`(`department_id`,`code`,`department`,`active`,`created_at`,`updated_at`) values 
(1,'STE','STE',1,NULL,NULL),
(2,'SET','SET',1,NULL,NULL),
(3,'SAS','SAS',1,NULL,NULL),
(4,'SAES','SAES',1,NULL,NULL),
(5,'SICT','SICT',1,NULL,NULL),
(6,'SBAM','SBAM',1,NULL,NULL),
(7,'STE','STE',1,NULL,NULL),
(8,'SET','SET',1,NULL,NULL),
(9,'SAS','SAS',1,NULL,NULL),
(10,'SAES','SAES',1,NULL,NULL),
(11,'SICT','SICT',1,NULL,NULL),
(12,'SBAM','SBAM',1,NULL,NULL),
(13,'STE','STE',1,NULL,NULL),
(14,'SET','SET',1,NULL,NULL),
(15,'SAS','SAS',1,NULL,NULL),
(16,'SAES','SAES',1,NULL,NULL),
(17,'SICT','SICT',1,NULL,NULL),
(18,'SBAM','SBAM',1,NULL,NULL);

/*Table structure for table `evaluation_answers` */

DROP TABLE IF EXISTS `evaluation_answers`;

CREATE TABLE `evaluation_answers` (
  `evaluation_answer_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `evaluation_id` bigint(20) unsigned NOT NULL,
  `question_id` bigint(20) unsigned NOT NULL,
  `rating` bigint(20) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`evaluation_answer_id`),
  KEY `evaluation_answers_evaluation_id_foreign` (`evaluation_id`),
  KEY `evaluation_answers_question_id_foreign` (`question_id`),
  CONSTRAINT `evaluation_answers_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`evaluation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `evaluation_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `evaluation_answers` */

insert  into `evaluation_answers`(`evaluation_answer_id`,`evaluation_id`,`question_id`,`rating`,`created_at`,`updated_at`) values 
(1,1,1,4,NULL,NULL),
(2,1,2,4,NULL,NULL),
(3,1,3,5,NULL,NULL),
(4,1,4,4,NULL,NULL),
(8,2,1,5,NULL,NULL),
(10,2,2,4,NULL,NULL),
(11,2,3,4,NULL,NULL),
(12,2,4,4,NULL,NULL),
(13,3,1,4,NULL,NULL),
(14,3,2,4,NULL,NULL),
(15,3,3,3,NULL,NULL),
(16,3,4,3,NULL,NULL);

/*Table structure for table `evaluations` */

DROP TABLE IF EXISTS `evaluations`;

CREATE TABLE `evaluations` (
  `evaluation_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`evaluation_id`),
  KEY `evaluations_academic_year_id_foreign` (`academic_year_id`),
  KEY `evaluations_event_id_foreign` (`event_id`),
  KEY `evaluations_user_id_foreign` (`user_id`),
  CONSTRAINT `evaluations_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`academic_year_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `evaluations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `evaluations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `evaluations` */

insert  into `evaluations`(`evaluation_id`,`academic_year_id`,`event_id`,`user_id`,`created_at`,`updated_at`) values 
(1,1,1,3,NULL,NULL),
(2,1,1,4,NULL,NULL),
(3,1,1,6,NULL,NULL);

/*Table structure for table `event_attendances` */

DROP TABLE IF EXISTS `event_attendances`;

CREATE TABLE `event_attendances` (
  `event_attendance_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `in_am` datetime DEFAULT NULL,
  `out_am` datetime DEFAULT NULL,
  `in_pm` datetime DEFAULT NULL,
  `out_pm` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`event_attendance_id`),
  KEY `event_attendances_event_id_foreign` (`event_id`),
  KEY `event_attendances_user_id_foreign` (`user_id`),
  CONSTRAINT `event_attendances_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `event_attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `event_attendances` */

insert  into `event_attendances`(`event_attendance_id`,`event_id`,`user_id`,`in_am`,`out_am`,`in_pm`,`out_pm`,`created_at`,`updated_at`) values 
(3,12,3,'2023-12-03 01:02:09','2023-12-03 01:02:19','2023-12-03 01:02:30',NULL,'2023-12-03 00:59:03','2023-12-03 01:02:30');

/*Table structure for table `event_attendees` */

DROP TABLE IF EXISTS `event_attendees`;

CREATE TABLE `event_attendees` (
  `event_attendee_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `date_request` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date_mark` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`event_attendee_id`),
  KEY `event_attendees_event_id_foreign` (`event_id`),
  KEY `event_attendees_user_id_foreign` (`user_id`),
  CONSTRAINT `event_attendees_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `event_attendees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `event_attendees` */

insert  into `event_attendees`(`event_attendee_id`,`event_id`,`user_id`,`date_request`,`status`,`date_mark`,`created_at`,`updated_at`) values 
(21,12,3,'2023-12-02',1,'2023-12-02','2023-12-02 10:55:12','2023-12-02 10:55:12');

/*Table structure for table `event_types` */

DROP TABLE IF EXISTS `event_types`;

CREATE TABLE `event_types` (
  `event_type_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_type` varchar(255) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`event_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `event_types` */

insert  into `event_types`(`event_type_id`,`event_type`,`active`,`created_at`,`updated_at`) values 
(1,'MEETING',1,NULL,NULL),
(2,'PROGRAM',1,NULL,NULL),
(3,'SEMINAR',1,NULL,NULL),
(4,'SYMPOSIUM',1,NULL,NULL),
(5,'STAKEHOLDERS',1,NULL,NULL);

/*Table structure for table `event_venues` */

DROP TABLE IF EXISTS `event_venues`;

CREATE TABLE `event_venues` (
  `event_venue_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_venue` varchar(255) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`event_venue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `event_venues` */

insert  into `event_venues`(`event_venue_id`,`event_venue`,`active`,`created_at`,`updated_at`) values 
(1,'LEGARDA HALL (Session Hall/Coffee Shop)',1,NULL,NULL),
(2,'NMSC GYMNASIUM',1,NULL,NULL),
(3,'ISOLATION FACILITY',1,NULL,NULL),
(4,'MULTI-PURPOSE CONFERENCE ROOM',1,NULL,NULL),
(5,'PE ACADEMIC BLDG',1,NULL,NULL),
(6,'STE CONFERENCE ROOM',1,NULL,NULL),
(7,'BOARD ROOM',1,NULL,NULL),
(8,'THEATRE ARTS',1,NULL,NULL),
(9,'CONVENTION HALL/BALLROOM',1,NULL,'2023-11-29 00:46:05');

/*Table structure for table `events` */

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `event_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `event_venue_id` bigint(20) unsigned NOT NULL,
  `event_type_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `if_others` varchar(100) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `event_description` text NOT NULL DEFAULT '',
  `content` text NOT NULL DEFAULT '',
  `event_datetime` datetime DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_time_from` time DEFAULT NULL,
  `event_time_to` time DEFAULT NULL,
  `img_path` varchar(255) NOT NULL DEFAULT '',
  `approval_status` tinyint(4) NOT NULL DEFAULT 0,
  `is_open` tinyint(4) NOT NULL DEFAULT 0,
  `is_need_approval` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  KEY `events_academic_year_id_foreign` (`academic_year_id`),
  CONSTRAINT `events_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`academic_year_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `events` */

insert  into `events`(`event_id`,`academic_year_id`,`user_id`,`event_venue_id`,`event_type_id`,`if_others`,`event`,`event_description`,`content`,`event_datetime`,`event_date`,`event_time_from`,`event_time_to`,`img_path`,`approval_status`,`is_open`,`is_need_approval`,`created_at`,`updated_at`) values 
(1,1,2,0,1,NULL,'TES & TDP RELEASE','','ATTENTION FOR ALL TES AND TDP GRANTEES! THERE WILL BE AN UPCOPING RELEASE FOR YOUR GRANTS THIS COMING FRIDAY NOVEMBER 17,2023 IN THE ADMINSTRATION BULDING, RELEASE WILL START AT EXACTLY 8:00AM IN THE MORNING. THANK YOU!','2023-09-22 15:00:00','2023-11-30','08:00:00','11:00:00','gbeDdXVEl7nljb93hFvE4vVc2pA8jhzqH9ChDqHe.jpg',1,0,0,NULL,NULL),
(2,1,2,0,1,NULL,'Monthly Mass','','<p><strong>Announcement Blue Generals.</strong></p><p><br></p><p><br></p><p>We will have a monthly mass this afternoon. All students are required to attend.</p>','2023-11-15 15:00:00','2023-11-30','08:00:00','11:00:00','T6qZYwDpIdOmhDkLvkFUTPV306j7DsoL18ieCxTG.jpg',1,1,0,NULL,NULL),
(3,1,2,0,5,'','SADAW','','<p>asdad</p>','2023-11-15 05:00:00','2023-11-30','08:00:00','11:00:00','imbGihdzL0vKXYwlaQAPuigDfYZAvnJF0ZmPLDq6.jpg',0,0,0,'2023-11-28 22:23:07','2023-11-28 22:27:22'),
(4,1,2,0,1,NULL,'TES & TDP RELEASE','','ATTENTION FOR ALL TES AND TDP GRANTEES! THERE WILL BE AN UPCOPING RELEASE FOR YOUR GRANTS THIS COMING FRIDAY NOVEMBER 17,2023 IN THE ADMINSTRATION BULDING, RELEASE WILL START AT EXACTLY 8:00AM IN THE MORNING. THANK YOU!','2023-09-22 15:00:00','2023-11-30','08:00:00','11:00:00','gbeDdXVEl7nljb93hFvE4vVc2pA8jhzqH9ChDqHe.jpg',1,0,0,NULL,NULL),
(5,1,2,0,1,NULL,'Monthly Mass','','<p><strong>Announcement Blue Generals.</strong></p><p><br></p><p><br></p><p>We will have a monthly mass this afternoon. All students are required to attend.</p>','2023-09-22 15:00:00','2023-11-30','13:00:00','17:00:00','T6qZYwDpIdOmhDkLvkFUTPV306j7DsoL18ieCxTG.jpg',1,1,0,NULL,NULL),
(6,1,2,0,1,NULL,'TES & TDP RELEASE','','ATTENTION FOR ALL TES AND TDP GRANTEES! THERE WILL BE AN UPCOPING RELEASE FOR YOUR GRANTS THIS COMING FRIDAY NOVEMBER 17,2023 IN THE ADMINSTRATION BULDING, RELEASE WILL START AT EXACTLY 8:00AM IN THE MORNING. THANK YOU!','2023-09-22 15:00:00','2023-11-30','08:00:00','11:00:00','gbeDdXVEl7nljb93hFvE4vVc2pA8jhzqH9ChDqHe.jpg',1,0,0,NULL,NULL),
(7,1,2,0,1,NULL,'Monthly Mass','','<p><strong>Announcement Blue Generals.</strong></p><p><br></p><p><br></p><p>We will have a monthly mass this afternoon. All students are required to attend.</p>','2023-09-22 15:00:00','2023-11-30','08:00:00','11:00:00','T6qZYwDpIdOmhDkLvkFUTPV306j7DsoL18ieCxTG.jpg',1,1,0,NULL,NULL),
(8,1,1,0,5,'','asdadwa','','<p>asdawda</p>','2023-11-16 00:00:00','2023-11-30','08:00:00','11:00:00','LTu8UWgSAU4IP4FgVLk6L3hCtRRzEOlKduiDHwrp.jpg',0,0,0,'2023-11-29 01:08:13','2023-11-29 01:08:13'),
(11,1,2,7,5,'','sample events','','<p>This is sample events		</p>',NULL,'2023-12-02','13:00:00','16:00:00','1vB2scL8nSOZnVu2d1jzKs4YdfvQd6eNIAxQY0yv.jpg',0,0,0,'2023-12-01 18:31:19','2023-12-01 18:31:19'),
(12,1,2,7,1,'','this is auto approved','','<p>this is auto approved</p>',NULL,'2023-12-02','13:00:00','17:00:00','72DAoQNMJLXh7mgrsQmBfd6XnmkUSRLHfxzcCV6F.jpg',1,0,0,'2023-12-02 10:42:42','2023-12-02 10:49:14');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

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

/*Data for the table `failed_jobs` */

/*Table structure for table `legends` */

DROP TABLE IF EXISTS `legends`;

CREATE TABLE `legends` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rating` tinyint(4) NOT NULL DEFAULT 0,
  `rating_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `legends` */

insert  into `legends`(`id`,`rating`,`rating_description`,`created_at`,`updated_at`) values 
(1,1,'VERY BAD',NULL,NULL),
(2,2,'BAD',NULL,NULL),
(3,3,'FAIR',NULL,NULL),
(4,4,'GOOD',NULL,NULL),
(5,5,'VERY GOOD',NULL,NULL),
(6,1,'VERY BAD',NULL,NULL),
(7,2,'BAD',NULL,NULL),
(8,3,'FAIR',NULL,NULL),
(9,4,'GOOD',NULL,NULL),
(10,5,'VERY GOOD',NULL,NULL),
(11,1,'VERY BAD',NULL,NULL),
(12,2,'BAD',NULL,NULL),
(13,3,'FAIR',NULL,NULL),
(14,4,'GOOD',NULL,NULL),
(15,5,'VERY GOOD',NULL,NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(208,'2014_10_12_000000_create_users_table',1),
(209,'2014_10_12_100000_create_password_resets_table',1),
(210,'2019_08_19_000000_create_failed_jobs_table',1),
(211,'2019_12_14_000001_create_personal_access_tokens_table',1),
(212,'2023_09_05_222004_create_academic_years_table',1),
(213,'2023_09_05_222005_create_events_table',1),
(214,'2023_09_05_222111_create_event_attendances_table',1),
(215,'2023_09_17_065432_create_questions_table',1),
(216,'2023_10_28_215830_create_event_types_table',1),
(217,'2023_11_20_142857_create_evaluations_table',1),
(218,'2023_11_20_143028_create_legends_table',1),
(219,'2023_11_20_144020_create_departments_table',1),
(220,'2023_11_25_035701_create_evaluation_answers',1),
(221,'2023_11_28_225547_create_event_venues_table',2),
(222,'2023_12_01_163020_create_event_attendees_table',3);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `questions` */

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `question_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL DEFAULT 0,
  `question` text DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `questions` */

insert  into `questions`(`question_id`,`order_no`,`question`,`active`,`created_at`,`updated_at`) values 
(1,1,'What is your level of satisfaction with this events?',1,NULL,NULL),
(2,2,'How likely are you going to tell a friend about this event?',1,NULL,NULL),
(3,3,'How would you rate our event venue and equipment in regards to how it served you keynote?',1,NULL,NULL),
(4,4,'How satisfied were you with the speakers and sessions at our event?',1,NULL,NULL),
(5,1,'What is your level of satisfaction with this events?',1,NULL,NULL),
(6,2,'How likely are you going to tell a friend about this event?',1,NULL,NULL),
(7,3,'How would you rate our event venue and equipment in regards to how it served you keynote?',1,NULL,NULL),
(8,4,'How satisfied were you with the speakers and sessions at our event?',1,NULL,NULL),
(9,1,'What is your level of satisfaction with this events?',1,NULL,NULL),
(10,2,'How likely are you going to tell a friend about this event?',1,NULL,NULL),
(11,3,'How would you rate our event venue and equipment in regards to how it served you keynote?',1,NULL,NULL),
(12,4,'How satisfied were you with the speakers and sessions at our event?',1,NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `qr_code` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `sex` varchar(20) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `department_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_qr_code_unique` (`qr_code`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`qr_code`,`username`,`lname`,`fname`,`mname`,`suffix`,`email`,`contact_no`,`sex`,`role`,`email_verified_at`,`password`,`active`,`department_id`,`remember_token`,`created_at`,`updated_at`) values 
(1,'ABC123','admin','SARSABA','ELNIE CHAN','','','elniechan.sarsaba@nmsc.edu.ph',NULL,'MALE','ADMINISTRATOR','2023-11-20 14:49:07','$2y$10$OXA8AX5.Z2dZCizvqcI8Q.41HiTda5p.ZQgg.Mh4/oTI6Dle8YI06',1,0,NULL,NULL,NULL),
(2,'AAA222','mark','PRIETO','MARK ANTHONY','','','markanthony.prieto@nmsc.edu.ph',NULL,'MALE','ORGANIZER','2023-11-20 14:49:07','$2y$10$h/JNnKQ2SEqXF8M98hVN/.xaA9EBzIjIWRHj2wTlNsnad9BsdEju6',1,0,NULL,NULL,NULL),
(3,'847F4671','sheen','DELOSA','SHEEN','','','sheen.delosa@nmsc.edu.ph',NULL,'FEMALE','STUDENT','2023-11-20 14:49:07','$2y$10$Y9DrZXQvKYntFqnFj9CLpO8VG8K9JNqh3YGp.qpzWbFrSRQNSVApi',1,0,NULL,NULL,NULL),
(4,'D2823EDF','Cherryl','GALLEGO','CHERRYL','LANSAM','','cherryl.gallego@nmsc.edu.ph',NULL,'FEMALE','STUDENT','2023-11-20 14:49:07','$2y$10$qKSSxlni8lJfdvwc3UfaqO66cZJ94R0okvEgVMH0YFS2PQUScJv2m',1,0,NULL,NULL,NULL),
(5,'D2823E111','juan','DELA CRUZ','JUAN','','','juan@nmsc.edu.ph',NULL,'MALE','STUDENT','2023-11-20 14:49:07','$2y$10$9FEQ15NFWPH17Eb2tTJRzumWOBXcvBL4/V1eAT.agY5KNuYcvwHuq',1,0,NULL,NULL,NULL),
(6,'D2823222','jane','GOMEZ','JANE','','','jane@nmsc.edu.ph',NULL,'FEMALE','STUDENT','2023-11-20 14:49:07','$2y$10$wXb87ox54zPcgCrPgDPR0exrZPIiPoSFMl.IVRsNT9HVuj3uSCnPC',1,0,NULL,NULL,NULL),
(7,'D2823333','jenny','GALEZ','JENNY','','','jenny@nmsc.edu.ph',NULL,'FEMALE','STUDENT','2023-11-20 14:49:07','$2y$10$hDvnnOVpChuLha1NaxgNR.ydOzvKWgFDgYoOAzW0thn/ZKgE/1Xye',1,0,NULL,NULL,NULL),
(8,'D2824444','rhea','MENDEZ','RHEA','','','rhea@nmsc.edu.ph',NULL,'FEMALE','STUDENT','2023-11-20 14:49:07','$2y$10$dnZ1p3ep50VttT9Y5wG9R.r5emxI2M0wNpCz8wwBU2KlHFYEw0v32',1,0,NULL,NULL,NULL),
(25,'C7C5E041','event','AA','AA','','','aa@mail.com',NULL,'MALE','EVENT OFFICER','2023-11-30 05:07:51','$2y$10$3wuhWiLOubxckEvro.KzQuSJ0DWMc2GF.LnYdm5DU4OAy/gZtXvoe',0,0,NULL,'2023-11-30 05:07:43','2023-11-30 05:07:51');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
