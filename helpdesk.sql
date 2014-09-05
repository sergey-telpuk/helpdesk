/*
SQLyog Ultimate v11.52 (64 bit)
MySQL - 5.5.38-0ubuntu0.14.04.1 : Database - helpdesk
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`helpdesk` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `helpdesk`;

/*Table structure for table `bid` */

DROP TABLE IF EXISTS `bid`;

CREATE TABLE `bid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `applicant` varchar(100) DEFAULT NULL,
  `implementer` varchar(100) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `status` enum('open','in_work','close','canceled') NOT NULL,
  `priority` enum('low','average','high','critical') NOT NULL,
  `date` datetime NOT NULL,
  `file` varchar(100) DEFAULT NULL,
  `screen` varchar(100) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `bid` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `level_access` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`login`,`password`,`level_access`) values (1,'admin','1234','Administrator');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
