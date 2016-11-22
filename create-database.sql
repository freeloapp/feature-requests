/*
SQLyog Community v12.2.1 (64 bit)
MySQL - 5.5.53-0+deb8u1 : Database - tmp
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `ideas` */

DROP TABLE IF EXISTS `ideas`;

CREATE TABLE `ideas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(100) DEFAULT NULL,
  `idea` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `dislikes` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `cookie` varchar(255) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

/*Data for the table `ideas` */

insert  into `ideas`(`id`,`groupname`,`idea`,`likes`,`dislikes`,`active`,`cookie`,`ip`,`email`) values

(1,'Integrace','Slack',0,0,1,NULL,NULL,NULL),

(2,'Integrace','Google Drive',0,0,1,NULL,NULL,NULL),

(3,'Integrace','Dropbox',0,0,1,NULL,NULL,NULL),

(4,'Úkoly','Labely/štítky k úkolům',0,0,1,NULL,NULL,NULL),

(5,'Úkoly','Opakované úkoly',0,0,1,NULL,NULL,NULL);

/*Table structure for table `ideas_log` */

DROP TABLE IF EXISTS `ideas_log`;

CREATE TABLE `ideas_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ideas_id` int(11) DEFAULT NULL,
  `cookie` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `ip` varchar(32) COLLATE utf8_czech_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `vote` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`cookie`),
  KEY `ideas_id` (`ideas_id`),
  CONSTRAINT `ideas_log_ibfk_1` FOREIGN KEY (`ideas_id`) REFERENCES `ideas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=556 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
