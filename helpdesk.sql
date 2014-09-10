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
  `applicant` varchar(100) NOT NULL,
  `implementer` int(11) NOT NULL DEFAULT '1',
  `description` varchar(255) NOT NULL,
  `status` enum('open','in_work','close','canceled') NOT NULL,
  `priority` enum('low','average','high','critical') NOT NULL,
  `date` char(16) NOT NULL,
  `comment` text,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `implementer` (`implementer`),
  CONSTRAINT `bid_ibfk_1` FOREIGN KEY (`implementer`) REFERENCES `implementer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `bid` */

insert  into `bid`(`id`,`name`,`applicant`,`implementer`,`description`,`status`,`priority`,`date`,`comment`,`date_insert`) values (1,'Фываыа','Ываыва',1,'Ываыва','open','low','09-09-2014 13:00','',NULL),(2,'Сломался компьютер','Сергей',2,'Не включается','open','critical','19-09-2014 16:00','',NULL),(3,'Сломался компьютер','Сергей',1,'Не включается','open','critical','19-09-2014 16:00','',NULL),(4,'Сломался компьютер','Ывывы',3,'Не включается','open','critical','19-09-2014 16:00','Фывфыа ыпаывпав ы пваптвлаоплтдщаодъыъып',NULL),(5,'Тельпук','Тельпук',1,'Тельпук','open','low','09-09-2014 14:00','',NULL),(6,'Вапвап','Авпва',1,'Вапавпва','open','low','09-09-2014 14:00','Ппва впрврара еар а',NULL),(7,'Sdfds','Sdfsdf',1,'Sdfds','open','low','09-09-2014 14:00','Sdfds sdfsdf sdfds',NULL),(8,'Dfd','Dfd',1,'Dfdfdf','open','low','09-09-2014 14:00','',NULL),(9,'Пропадают папки','Профтех',1,'Пропадают папки на пк - профтех','open','low','30-09-2014 19:00','Ё111erver share',NULL),(10,'Asdasd','Asdasd',1,'Asdsadsa','open','low','09-09-2014 14:00','',NULL),(11,'','',1,'wewewew','open','','',NULL,'2014-09-09 14:10:33'),(12,'','',1,'wewewe','open','critical','',NULL,'2014-09-09 14:10:51'),(13,'Sdfgsdgd','Erte',1,'Sdfdsf','in_work','low','13-09-2014 17:00','Гднепгшлнепшдгп','2014-09-09 14:28:43'),(14,'Sds','Sds',1,'Sds','close','average','09-09-2014 15:00','Sdsd','2014-09-09 14:38:45'),(15,'Sdsdssdsds','Sdsds',1,'Sdsds','open','low','10-09-2014 11:00','','2014-09-10 10:27:22'),(16,'Dffhfh','Fghfg',1,'Fghfgh','open','low','10-09-2014 11:00','','2014-09-10 10:27:36'),(17,'Asdas','Dftg ee',1,'Asdsada','open','low','10-09-2014 12:00','Xsdfgdf dfhtrfh dertygrtdgdftgy re','2014-09-10 11:32:41'),(18,'Sdfds','Sdfdsf',1,'Sdfdsfds','open','low','10-09-2014 17:00','','2014-09-10 16:32:39'),(19,'Trut6yu','Tyuytuyt',2,'Tyutyu','open','low','10-09-2014 17:00','','2014-09-10 16:33:39'),(20,'','',3,'','open','low','10-09-2014 17:00','','2014-09-10 16:37:32'),(21,'','',3,'','open','low','10-09-2014 17:00','','2014-09-10 16:37:38'),(22,'Fsdgf','Dfgdg',1,'Fdgdfgd','open','low','10-09-2014 17:00','','2014-09-10 16:41:20'),(23,'Ewrtewt','Rtrt',2,'Ertrete','open','low','10-09-2014 18:00','','2014-09-10 17:51:10');

/*Table structure for table `implementer` */

DROP TABLE IF EXISTS `implementer`;

CREATE TABLE `implementer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `implementer` */

insert  into `implementer`(`id`,`name`) values (1,'Администратор'),(2,'Курневич В.В'),(3,'Демидов А.A'),(4,'Тельпук С.В');

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
