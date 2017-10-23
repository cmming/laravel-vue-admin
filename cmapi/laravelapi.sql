/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : 192.168.0.88:3306
Source Database       : laravelapi

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-10-23 18:42:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('4', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('5', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('6', '2017_09_12_084232_create_videos_table', '1');
INSERT INTO `migrations` VALUES ('7', '2017_09_13_025943_create_t_vr_user_ori_videos_table', '2');
INSERT INTO `migrations` VALUES ('9', '2017_10_09_170542_create_premission_roles', '3');
INSERT INTO `migrations` VALUES ('10', '2017_10_11_160330_create_user_roles', '4');
INSERT INTO `migrations` VALUES ('12', '2017_10_14_153710_create_premission_resources', '5');
INSERT INTO `migrations` VALUES ('15', '2017_10_23_100439_create_router_table', '6');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for premisison_resources
-- ----------------------------
DROP TABLE IF EXISTS `premisison_resources`;
CREATE TABLE `premisison_resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `premission_id` int(11) NOT NULL,
  `resources_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `premisison_resources_premission_id_unique` (`premission_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of premisison_resources
-- ----------------------------
INSERT INTO `premisison_resources` VALUES ('4', '8', '[\"1,2\"]', '2017-10-16 10:04:22', '2017-10-16 14:32:39');
INSERT INTO `premisison_resources` VALUES ('3', '7', '[\"1,0\",\"1,1\"]', '2017-10-14 17:07:35', '2017-10-16 14:30:39');
INSERT INTO `premisison_resources` VALUES ('5', '9', '[\"0,0\",\"0,1\",\"0,2\",\"0,3\",\"0,4\",\"0,5\"]', '2017-10-16 10:59:43', '2017-10-23 14:55:04');
INSERT INTO `premisison_resources` VALUES ('6', '10', '[\"2\",\"3\"]', '2017-10-16 17:10:26', '2017-10-16 17:10:26');
INSERT INTO `premisison_resources` VALUES ('7', '11', '[\"5\",\"5,0\"]', '2017-10-23 15:13:32', '2017-10-23 15:13:32');

-- ----------------------------
-- Table structure for routers
-- ----------------------------
DROP TABLE IF EXISTS `routers`;
CREATE TABLE `routers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `componentPath` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iconFont` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `routers_path_unique` (`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of routers
-- ----------------------------

-- ----------------------------
-- Table structure for routers_rel
-- ----------------------------
DROP TABLE IF EXISTS `routers_rel`;
CREATE TABLE `routers_rel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `son_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `routers_rel_son_id_unique` (`son_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of routers_rel
-- ----------------------------

-- ----------------------------
-- Table structure for router_premission_rel
-- ----------------------------
DROP TABLE IF EXISTS `router_premission_rel`;
CREATE TABLE `router_premission_rel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `router_id` int(11) NOT NULL,
  `premisison_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `premisison_id` (`router_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of router_premission_rel
-- ----------------------------

-- ----------------------------
-- Table structure for t_vr_user_ori_resources
-- ----------------------------
DROP TABLE IF EXISTS `t_vr_user_ori_resources`;
CREATE TABLE `t_vr_user_ori_resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `file_size` int(11) NOT NULL DEFAULT '0',
  `file_type` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `file_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of t_vr_user_ori_resources
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'cm1', '294225707@qq.com', '$2y$10$2tFPFcNzb6bygQMMBdB.oe5FFKKXYQ39eu4ctuWMdMRSngVTDYQLK', '9b9kDrNtiS4UG8sWadzfzoooda02rN56pAk9xGlJ4qa6ZoxcmS9eP1txLxAl', '2017-08-24 15:04:23', '2017-09-01 14:37:16');
INSERT INTO `users` VALUES ('2', 'cm2', '294225708@qq.com', '$2y$10$JNWx0hsX6PadpCNnkIpfke/IXBJtg5yWfTsqJgU4cUsKd1h/EWS6m', 'AKKL1IAq0DthpIl4o7nH2ELbp2O6svQGGWx8iznZd4kcwyZj3dU4h0GgQVLl', '2017-08-24 16:08:55', '2017-09-01 12:07:30');

-- ----------------------------
-- Table structure for users_roles
-- ----------------------------
DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE `users_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_roles
-- ----------------------------
INSERT INTO `users_roles` VALUES ('4', '4', '1', null, null);
INSERT INTO `users_roles` VALUES ('6', '100025', '2', null, null);
INSERT INTO `users_roles` VALUES ('8', '4', '2', null, null);

-- ----------------------------
-- Table structure for users_roles_copy
-- ----------------------------
DROP TABLE IF EXISTS `users_roles_copy`;
CREATE TABLE `users_roles_copy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_roles_copy
-- ----------------------------

-- ----------------------------
-- Table structure for user_premissions
-- ----------------------------
DROP TABLE IF EXISTS `user_premissions`;
CREATE TABLE `user_premissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_premissions_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_premissions
-- ----------------------------
INSERT INTO `user_premissions` VALUES ('7', 'userOri', '用户原创修改1', '2017-10-10 11:50:10', '2017-10-14 14:58:10');
INSERT INTO `user_premissions` VALUES ('8', 'userORiTmp', '用户原创申请', '2017-10-10 15:25:42', '2017-10-16 10:58:03');
INSERT INTO `user_premissions` VALUES ('9', 'userRolePremission', '用户角色权限管理', '2017-10-16 10:57:22', '2017-10-16 10:57:22');
INSERT INTO `user_premissions` VALUES ('10', 'dataCenter', '数据中心', '2017-10-16 17:10:13', '2017-10-16 17:10:13');
INSERT INTO `user_premissions` VALUES ('11', 'example', '综合实例', '2017-10-23 15:13:19', '2017-10-23 15:13:19');

-- ----------------------------
-- Table structure for user_premission_role
-- ----------------------------
DROP TABLE IF EXISTS `user_premission_role`;
CREATE TABLE `user_premission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `premission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_premission_role_role_id_premission_id_unique` (`role_id`,`premission_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_premission_role
-- ----------------------------
INSERT INTO `user_premission_role` VALUES ('10', '1', '7', null, null);
INSERT INTO `user_premission_role` VALUES ('11', '1', '8', null, null);
INSERT INTO `user_premission_role` VALUES ('16', '1', '9', null, null);
INSERT INTO `user_premission_role` VALUES ('8', '2', '8', null, null);
INSERT INTO `user_premission_role` VALUES ('13', '1', '10', null, null);
INSERT INTO `user_premission_role` VALUES ('14', '2', '7', null, null);
INSERT INTO `user_premission_role` VALUES ('15', '2', '10', null, null);
INSERT INTO `user_premission_role` VALUES ('17', '1', '11', null, null);

-- ----------------------------
-- Table structure for user_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_roles
-- ----------------------------
INSERT INTO `user_roles` VALUES ('1', '管理员', '所有权限', '2017-10-10 14:35:38', '2017-10-16 11:03:51');
INSERT INTO `user_roles` VALUES ('2', '普通员工', '等级13', '2017-10-10 14:37:09', '2017-10-19 17:49:20');

-- ----------------------------
-- Table structure for videos
-- ----------------------------
DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_free` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of videos
-- ----------------------------
