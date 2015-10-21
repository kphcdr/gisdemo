# Host: localhost  (Version: 5.5.40)
# Date: 2015-10-21 12:44:59
# Generator: MySQL-Front 5.3  (Build 4.120)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "test"
#
CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pnt` point NOT NULL,
  PRIMARY KEY (`id`),
  SPATIAL KEY `pnt` (`pnt`)
) ENGINE=MyISAM AUTO_INCREMENT=1028490 DEFAULT CHARSET=gbk;

