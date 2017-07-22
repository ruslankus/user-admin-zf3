/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100124
 Source Host           : localhost
 Source Database       : db-user

 Target Server Type    : MySQL
 Target Server Version : 100124
 File Encoding         : utf-8

 Date: 07/23/2017 00:22:05 AM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `full_name` varchar(512) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `pwd_reset_token` varchar(32) DEFAULT NULL,
  `pwd_reset_token_creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_idx` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('12', 'ruslan@prophp.eu', 'Admin', '$2y$10$qqWfDHk3N1eQelIDXg3DLeIP027jo4xwUyRvLsL2CEl89wotuziQ2', '1', '2017-06-27 19:25:35', '', '2017-07-01 16:18:58'), ('14', 'test@tes.lt', 'wwwwww', '$2y$10$Uql51hgRVE7nHAgSpwTwjehNVe1ZcnuIB/UYGsSy5z4aJRE30mmay', '1', '2017-07-02 21:35:58', null, null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
