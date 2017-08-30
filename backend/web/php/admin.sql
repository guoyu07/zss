/*
Navicat MySQL Data Transfer
*/

CREATE DATABASE IF NOT EXISTS `wwwroot` DEFAULT CHARSET utf8 COLLATE utf8_general_ci;

use `wwwroot`;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` bigint(20) NOT NULL auto_increment,
  `appid` int(10) NOT NULL,
  `username` varchar(32) default NULL,
  `nickname` varchar(100) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `avatar` char(6) NOT NULL default '',
  `cellphone` varchar(50) default NULL,
  `email` varchar(255) NOT NULL default '',
  `sex` tinyint(1) NOT NULL default '0',
  `reg_time` int(10) NOT NULL default '0',
  `reg_ip` char(16) NOT NULL default '',
  `login_days` int(10) NOT NULL default '0',
  `login_count` int(10) NOT NULL default '0',
  `lastlogin` int(10) NOT NULL default '0',
  `lastip` char(16) NOT NULL default '',
  `disabled` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `app_username` (`appid`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('657', '1001', '13983896955', '', 'ea48576f30be1669971699c09ad05c94', '123456', null, '', '0', '1429692504', '192.168.125.134', '0', '0', '1432798374', '192.168.125.134', '0');

-- ----------------------------
-- Table structure for `admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `id` int(11) NOT NULL auto_increment,
  `role_name` varchar(255) NOT NULL default '-' COMMENT '角色名称',
  `role_desc` varchar(100) NOT NULL default '-' COMMENT '角色描述',
  `creater_id` int(11) NOT NULL default 0 COMMENT '添加角色时创建人的id',
  `creater_name` varchar(30) NOT NULL default '-' COMMENT '添加角色时创建人的名字',
  `update_id` int(11) NOT NULL default 0 COMMENT '更新角色时创建人的id',
  `update_name` varchar(100) NOT NULL default '-' COMMENT '更新角色时创建人的名字',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '角色创建时间',
  `update_time` timestamp NULL default NULL on update CURRENT_TIMESTAMP COMMENT '角色最后一次更新的时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_role
-- ----------------------------
INSERT INTO `admin_role` VALUES ('1', '超级管理员', '超级管理员', '657', '复古风的奶奶', '657', '复古风的奶奶', '2015-05-14 14:53:57', '2015-05-19 20:22:50');
INSERT INTO `admin_role` VALUES ('2', '普通管理员', '普通管理员：由超级管理员分配，权限低于超级管理员！', '657', '复古风的奶奶', 0, '-', '2015-05-15 14:05:44', '2015-05-15 14:05:44');
INSERT INTO `admin_role` VALUES ('3', '普通管理员', '普通管理员：由超级管理员分配，权限低于超级管理员！', '657', '复古风的奶奶', 0, '-', '2015-05-15 14:05:44', '2015-05-15 14:05:44');

-- ----------------------------
-- Table structure for `admin_role_route`
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_route`;
CREATE TABLE `admin_role_route` (
  `id` int(11) NOT NULL auto_increment,
  `route` text NOT NULL COMMENT '角色拥有的菜单路由',
  `role_id` int(11) NOT NULL default 0 COMMENT '角色ID',
  `type` tinyint(2) NOT NULL default '1' COMMENT '路由类型，1代表route字段是一级菜单路由，2代表route是二级菜单路由',  
  `creater_id` int(11) NOT NULL default 0 COMMENT '添加记录时创建人的id',
  `creater_name` varchar(100) NOT NULL default '-' COMMENT '添加记录时创建人的名字',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `update_time` timestamp NULL default NULL on update CURRENT_TIMESTAMP COMMENT '记录最后一次更新的时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_role_route
-- ----------------------------
INSERT INTO `admin_role_route` VALUES ('8', '[\"user\",\"school\"]', '3', '1', '657', '复古风的奶奶', '2015-05-19 16:31:30', '2015-05-19 17:48:22');
INSERT INTO `admin_role_route` VALUES ('9', '{\"user\":[\"user.teacher_add\"],\"school\":[\"school.school_list\"]}', '3', '2', '657', '复古风的奶奶', '2015-05-19 16:31:30', '2015-05-19 17:48:22');
INSERT INTO `admin_role_route` VALUES ('14', '[\"user\",\"school\",\"admin\"]', '2', '1', '657', '复古风的奶奶', '2015-05-20 10:16:46', '2015-05-20 10:16:46');
INSERT INTO `admin_role_route` VALUES ('15', '{\"user\":[\"user.teacher_add\",\"user.student_add\",\"user.teacher_list\",\"user.student_list\"],\"school\":[\"school.school_add\",\"school.school_list\",\"school.class_add\",\"school.class_list\"],\"admin\":[\"admin.addAccount\",\"admin.admin_list\"]}', '2', '2', '657', '复古风的奶奶', '2015-05-20 10:16:46', '2015-05-27 21:14:02');

-- ----------------------------
-- Table structure for `admin_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_role`;
CREATE TABLE `admin_user_role` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default 0 COMMENT '登陆用户id，对应admin_user表id',
  `role_id` varchar(600) NOT NULL default 0 COMMENT '用户对应角色id，对应admin_role表id',
  `creater_id` int(11) NOT NULL default 0 COMMENT '添加记录时创建人的id',
  `creater_name` varchar(30) NOT NULL default '-' COMMENT '添加记录时创建人的名字',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '记录创建时间',
  `update_time` timestamp NULL default NULL on update CURRENT_TIMESTAMP COMMENT '记录最后一次更新的时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user_role
-- ----------------------------
INSERT INTO `admin_user_role` VALUES ('2', '657', '1', '657', '复古风的奶奶', '2015-05-19 17:51:46', '2015-05-19 20:29:38');
