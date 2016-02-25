/*
Navicat MySQL Data Transfer

Source Server         : Localhost@mysql
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : songs

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2016-02-02 21:26:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for albums
-- ----------------------------
DROP TABLE IF EXISTS `albums`;
CREATE TABLE `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artists_name` varchar(50) NOT NULL,
  `album_name` varchar(50) NOT NULL,
  `year` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of albums
-- ----------------------------
INSERT INTO `albums` VALUES ('1', 'Ari Lasso', 'Keseimbangan', '2010', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `albums` VALUES ('2', 'Noah', 'Second Chance', '2014', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `albums` VALUES ('3', 'Noah', 'Seperti Seharusnya', '2012', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `albums` VALUES ('4', 'Noah', 'Sebuah Cerita', '2008', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `albums` VALUES ('5', 'Noah', 'Bintang di Surga', '2004', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `albums` VALUES ('6', 'Linkin Park', 'Live in Texas', '2003', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `albums` VALUES ('7', 'Linkin Park', 'Hybrid Theory', '2000', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for songs
-- ----------------------------
DROP TABLE IF EXISTS `songs`;
CREATE TABLE `songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `song_title` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3585 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of songs
-- ----------------------------
INSERT INTO `songs` VALUES ('1', '1', 'Rahasia Perempuan', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('2', '2', 'Tulus', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('3', '3', 'Hasrat Sekejap', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('4', '4', 'Jalanku Tak Panjang', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('5', '5', 'Cinta Sejati', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('6', '6', 'Hampa', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('7', '7', 'Ironis', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('8', '1', 'Jika Aku Bukanlah Aku', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('9', '2', 'Gagal', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('10', '3', 'Yang Terbaik', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('11', '4', 'Somewhere I Belong', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('12', '5', 'Papercut', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('13', '6', 'Runaway', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('14', '7', 'By Myself', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('15', '1', 'Rahasia Perempuan', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('16', '2', 'Tulus', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('17', '3', 'Hasrat Sekejap', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('18', '4', 'Jalanku Tak Panjang', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('19', '5', 'Cinta Sejati', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('20', '6', 'Hampa', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('21', '7', 'Ironis', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('22', '1', 'Jika Aku Bukanlah Aku', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('23', '2', 'Gagal', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('24', '3', 'Yang Terbaik', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('25', '4', 'Somewhere I Belong', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('26', '5', 'Papercut', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('27', '6', 'Runaway', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `songs` VALUES ('28', '7', 'By Myself', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
