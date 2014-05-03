/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50041
Source Host           : 127.0.0.1:3306
Source Database       : shuipfcms

Target Server Type    : MYSQL
Target Server Version : 50041
File Encoding         : 65001

Date: 2013-06-22 22:34:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for shuipfcms_config
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_config`;
CREATE TABLE `shuipfcms_config` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `varname` varchar(20) NOT NULL DEFAULT '',
  `info` varchar(100) NOT NULL DEFAULT '',
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shuipfcms_config
-- ----------------------------
INSERT INTO `shuipfcms_config` VALUES ('1', 'sitename', '网站名称', '1', 'ShuipFCMS内容管理系统');
INSERT INTO `shuipfcms_config` VALUES ('2', 'siteurl', '网站网址', '1', '/');
INSERT INTO `shuipfcms_config` VALUES ('3', 'sitefileurl', '附件地址', '1', '/d/file/');
INSERT INTO `shuipfcms_config` VALUES ('4', 'siteemail', '站点邮箱', '1', 'admin@abc3210.com');
INSERT INTO `shuipfcms_config` VALUES ('6', 'siteinfo', '网站介绍', '1', 'ShuipFCMS网站管理系统,是一款完全开源免费的PHP+MYSQL系统.核心采用了Thinkphp框架等众多开源软件,同时核心功能也作为开源软件发布');
INSERT INTO `shuipfcms_config` VALUES ('7', 'sitekeywords', '网站关键字', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('8', 'uploadmaxsize', '允许上传附件大小', '1', '20240');
INSERT INTO `shuipfcms_config` VALUES ('9', 'uploadallowext', '允许上传附件类型', '1', 'jpg|jpeg|gif|bmp|png|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|rar|zip|swf');
INSERT INTO `shuipfcms_config` VALUES ('10', 'qtuploadmaxsize', '前台允许上传附件大小', '1', '200');
INSERT INTO `shuipfcms_config` VALUES ('11', 'qtuploadallowext', '前台允许上传附件类型', '1', 'jpg|jpeg|gif');
INSERT INTO `shuipfcms_config` VALUES ('12', 'watermarkenable', '是否开启图片水印', '1', '1');
INSERT INTO `shuipfcms_config` VALUES ('13', 'watermarkminwidth', '水印-宽', '1', '300');
INSERT INTO `shuipfcms_config` VALUES ('14', 'watermarkminheight', '水印-高', '1', '100');
INSERT INTO `shuipfcms_config` VALUES ('15', 'watermarkimg', '水印图片', '1', '/statics/images/mark_bai.png');
INSERT INTO `shuipfcms_config` VALUES ('16', 'watermarkpct', '水印透明度', '1', '80');
INSERT INTO `shuipfcms_config` VALUES ('17', 'watermarkquality', 'JPEG 水印质量', '1', '85');
INSERT INTO `shuipfcms_config` VALUES ('18', 'watermarkpos', '水印位置', '1', '7');
INSERT INTO `shuipfcms_config` VALUES ('19', 'indextp', '首页模板', '1', 'index.php');
INSERT INTO `shuipfcms_config` VALUES ('20', 'theme', '主题风格', '1', 'Default');
INSERT INTO `shuipfcms_config` VALUES ('21', 'generate', '是否生成首页', '1', '1');
INSERT INTO `shuipfcms_config` VALUES ('22', 'tagurl', 'TagURL规则', '1', '8');
INSERT INTO `shuipfcms_config` VALUES ('23', 'ftpstatus', 'FTP上传', '1', '0');
INSERT INTO `shuipfcms_config` VALUES ('24', 'ftpuser', 'FTP用户名', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('25', 'ftppassword', 'FTP密码', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('26', 'ftphost', 'FTP服务器地址', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('27', 'ftpport', 'FTP服务器端口', '1', '21');
INSERT INTO `shuipfcms_config` VALUES ('28', 'ftppasv', 'FTP是否开启被动模式', '1', '1');
INSERT INTO `shuipfcms_config` VALUES ('29', 'ftpssl', 'FTP是否使用SSL连接', '1', '0');
INSERT INTO `shuipfcms_config` VALUES ('30', 'ftptimeout', 'FTP超时时间', '1', '10');
INSERT INTO `shuipfcms_config` VALUES ('31', 'ftpuppat', 'FTP上传目录', '1', '/');
INSERT INTO `shuipfcms_config` VALUES ('32', 'mail_type', '邮件发送模式', '1', '1');
INSERT INTO `shuipfcms_config` VALUES ('33', 'mail_server', '邮件服务器', '1', 'smtp.qq.com');
INSERT INTO `shuipfcms_config` VALUES ('34', 'mail_port', '邮件发送端口', '1', '25');
INSERT INTO `shuipfcms_config` VALUES ('35', 'mail_from', '发件人地址', '1', 'admin@abc3210.com');
INSERT INTO `shuipfcms_config` VALUES ('36', 'mail_auth', 'AUTH LOGIN验证', '1', '1');
INSERT INTO `shuipfcms_config` VALUES ('37', 'mail_user', '邮箱用户名', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('38', 'mail_password', '邮箱密码', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('39', 'mail_fname', '发件人名称', '1', 'ShuipFCMS管理员');
INSERT INTO `shuipfcms_config` VALUES ('40', 'fileexclude', '远程下载过滤域名', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('41', 'index_urlruleid', '首页URL规则', '1', '11');
INSERT INTO `shuipfcms_config` VALUES ('42', 'domainaccess', '指定域名访问', '1', '0');

-- ----------------------------
-- Table structure for shuipfcms_config_field
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_config_field`;
CREATE TABLE `shuipfcms_config_field` (
  `fid` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '自增长id',
  `fieldname` varchar(30) NOT NULL COMMENT '字段名',
  `type` varchar(10) NOT NULL COMMENT '类型,input',
  `setting` mediumtext NOT NULL COMMENT '其他',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站配置，扩展字段列表';

-- ----------------------------
-- Table structure for `shuipfcms_user`
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_user`;
CREATE TABLE `shuipfcms_user` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `username` varchar(64) NOT NULL COMMENT '用户名',
  `nickname` varchar(50) NOT NULL COMMENT '昵称/姓名',
  `password` char(32) NOT NULL COMMENT '密码',
  `bind_account` varchar(50) NOT NULL COMMENT '绑定帐户',
  `last_login_time` int(11) unsigned default '0' COMMENT '上次登录时间',
  `last_login_ip` varchar(40) default NULL COMMENT '上次登录IP',
  `verify` varchar(32) default NULL COMMENT '证验码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL COMMENT '更新时间',
  `status` tinyint(1) NOT NULL default '0' COMMENT '状态',
  `role_id` tinyint(4) unsigned NOT NULL default '0' COMMENT '对应角色ID',
  `info` text NOT NULL COMMENT '信息',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `account` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Table structure for `shuipfcms_behavior`
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_behavior`;
CREATE TABLE `shuipfcms_behavior` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT '主键',
  `name` char(30) NOT NULL COMMENT '行为唯一标识',
  `title` char(80) NOT NULL default '' COMMENT '行为说明',
  `remark` char(140) NOT NULL default '' COMMENT '行为描述',
  `type` tinyint(1) NOT NULL default '1' COMMENT '1-控制器，2-视图',
  `status` tinyint(2) NOT NULL COMMENT '状态（0：禁用，1：正常）',
  `system` tinyint(1) NOT NULL default '0' COMMENT '是否系统',
  `module` char(20) NOT NULL COMMENT '所属模块',
  `datetime` int(11) unsigned NOT NULL default '0' COMMENT '修改时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统行为表';

-- ----------------------------
-- Records of shuipfcms_behavior
-- ----------------------------
INSERT INTO `shuipfcms_behavior` VALUES ('1', 'app_init', '应用初始化标签位', '应用初始化标签位', '1', '1', '1', '', '1381021393');
INSERT INTO `shuipfcms_behavior` VALUES ('2', 'path_info', 'PATH_INFO检测标签位', 'PATH_INFO检测标签位', '1', '1', '1', '', '1381021411');
INSERT INTO `shuipfcms_behavior` VALUES ('3', 'app_begin', '应用开始标签位', '应用开始标签位', '1', '1', '1', '', '1381021424');
INSERT INTO `shuipfcms_behavior` VALUES ('4', 'action_name', '操作方法名标签位', '操作方法名标签位', '1', '1', '1', '', '1381021437');
INSERT INTO `shuipfcms_behavior` VALUES ('5', 'action_begin', '控制器开始标签位', '控制器开始标签位', '1', '1', '1', '', '1381021450');
INSERT INTO `shuipfcms_behavior` VALUES ('6', 'view_begin', '视图输出开始标签位', '视图输出开始标签位', '1', '1', '1', '', '1381021463');
INSERT INTO `shuipfcms_behavior` VALUES ('7', 'view_parse', '视图解析标签位', '视图解析标签位', '1', '1', '1', '', '1381021476');
INSERT INTO `shuipfcms_behavior` VALUES ('8', 'template_filter', '模板内容解析标签位', '模板内容解析标签位', '1', '1', '1', '', '1381021488');
INSERT INTO `shuipfcms_behavior` VALUES ('9', 'view_filter', '视图输出过滤标签位', '视图输出过滤标签位', '1', '1', '1', '', '1381021621');
INSERT INTO `shuipfcms_behavior` VALUES ('10', 'view_end', '视图输出结束标签位', '视图输出结束标签位', '1', '1', '1', '', '1381021631');
INSERT INTO `shuipfcms_behavior` VALUES ('11', 'action_end', '控制器结束标签位', '控制器结束标签位', '1', '1', '1', '', '1381021642');
INSERT INTO `shuipfcms_behavior` VALUES ('12', 'app_end', '应用结束标签位', '应用结束标签位', '1', '1', '1', '', '1381021654');
INSERT INTO `shuipfcms_behavior` VALUES ('13', 'appframe_rbac_init', '后台权限控制', '后台权限控制', '1', '1', '1', '', '1381023560');

-- ----------------------------
-- Table structure for `shuipfcms_behavior_rule`
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_behavior_rule`;
CREATE TABLE `shuipfcms_behavior_rule` (
  `ruleid` int(11) NOT NULL auto_increment COMMENT '主键',
  `behaviorid` int(11) NOT NULL COMMENT '行为id',
  `system` tinyint(1) NOT NULL default '0' COMMENT '是否系统',
  `module` char(20) NOT NULL COMMENT '规则所属模块',
  `addons` char(20) NOT NULL COMMENT '规则所属插件',
  `rule` text NOT NULL COMMENT '行为规则',
  `listorder` tinyint(3) NOT NULL default '0' COMMENT '排序',
  `datetime` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY  (`ruleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='行为规则';

-- ----------------------------
-- Records of shuipfcms_behavior_rule
-- ----------------------------
INSERT INTO `shuipfcms_behavior_rule` VALUES ('1', '1', '1', '', '', 'phpfile:BuildLiteBehavior', '0', '1381021858');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('2', '3', '1', '', '', 'phpfile:ReadHtmlCacheBehavior', '0', '1381021885');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('3', '12', '1', '', '', 'phpfile:ShowPageTraceBehavior', '0', '1381021904');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('4', '7', '1', '', '', 'phpfile:ParseTemplateBehavior', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('5', '8', '1', '', '', 'phpfile:ContentReplaceBehavior', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('6', '9', '1', '', '', 'phpfile:WriteHtmlCacheBehavior', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('7', '1', '1', '', '', 'phpfile:AppInitBehavior|module:Common', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('8', '3', '1', '', '', 'phpfile:AppBeginBehavior|module:Common', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('9', '6', '1', '', '', 'phpfile:ViewBeginBehavior|module:Common', '0', '1381021954');

-- ----------------------------
-- Table structure for `shuipfcms_behavior_log`
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_behavior_log`;
CREATE TABLE `shuipfcms_behavior_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `ruleid` int(10) NOT NULL COMMENT '行为ID',
  `guid` char(50) NOT NULL COMMENT '标识',
  `create_time` int(10) NOT NULL COMMENT '执行行为的时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='执行行为日志';