/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50536
Source Host           : 127.0.0.1:3306
Source Database       : shuipfcms

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2014-05-22 18:24:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for shuipfcms_access
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_access`;
CREATE TABLE `shuipfcms_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `app` varchar(20) NOT NULL COMMENT '模块',
  `controller` varchar(20) NOT NULL COMMENT '控制器',
  `action` varchar(20) NOT NULL COMMENT '方法',
  `status` tinyint(4) DEFAULT '0' COMMENT '是否有效',
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色权限表';

-- ----------------------------
-- Records of shuipfcms_access
-- ----------------------------


-- ----------------------------
-- Table structure for shuipfcms_admin_panel
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_admin_panel`;
CREATE TABLE `shuipfcms_admin_panel` (
  `mid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '菜单ID',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` char(32) NOT NULL COMMENT '菜单名',
  `url` char(255) NOT NULL COMMENT '菜单地址',
  UNIQUE KEY `userid` (`mid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='常用菜单';

-- ----------------------------
-- Records of shuipfcms_admin_panel
-- ----------------------------

-- ----------------------------
-- Table structure for shuipfcms_behavior
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_behavior`;
CREATE TABLE `shuipfcms_behavior` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL COMMENT '行为唯一标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) NOT NULL DEFAULT '' COMMENT '行为描述',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-控制器，2-视图',
  `status` tinyint(2) NOT NULL COMMENT '状态（0：禁用，1：正常）',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统',
  `module` char(20) NOT NULL COMMENT '所属模块',
  `datetime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='系统行为表';

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
-- Table structure for shuipfcms_behavior_log
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_behavior_log`;
CREATE TABLE `shuipfcms_behavior_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `ruleid` int(10) NOT NULL COMMENT '行为ID',
  `guid` char(50) NOT NULL COMMENT '标识',
  `create_time` int(10) NOT NULL COMMENT '执行行为的时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='行为日志';

-- ----------------------------
-- Records of shuipfcms_behavior_log
-- ----------------------------

-- ----------------------------
-- Table structure for shuipfcms_behavior_rule
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_behavior_rule`;
CREATE TABLE `shuipfcms_behavior_rule` (
  `ruleid` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `behaviorid` int(11) NOT NULL COMMENT '行为id',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统',
  `module` char(20) NOT NULL COMMENT '规则所属模块',
  `addons` char(20) NOT NULL COMMENT '规则所属插件',
  `rule` text NOT NULL COMMENT '行为规则',
  `listorder` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `datetime` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`ruleid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='行为规则表';

-- ----------------------------
-- Records of shuipfcms_behavior_rule
-- ----------------------------
INSERT INTO `shuipfcms_behavior_rule` VALUES ('1', '1', '1', '', '', 'phpfile:BuildLiteBehavior', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('2', '3', '1', '', '', 'phpfile:ReadHtmlCacheBehavior', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('3', '12', '1', '', '', 'phpfile:ShowPageTraceBehavior', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('4', '7', '1', '', '', 'phpfile:ParseTemplateBehavior', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('5', '8', '1', '', '', 'phpfile:ContentReplaceBehavior', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('6', '9', '1', '', '', 'phpfile:WriteHtmlCacheBehavior', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('7', '1', '1', '', '', 'phpfile:AppInitBehavior|module:Common', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('8', '3', '1', '', '', 'phpfile:AppBeginBehavior|module:Common', '0', '1381021954');
INSERT INTO `shuipfcms_behavior_rule` VALUES ('9', '6', '1', '', '', 'phpfile:ViewBeginBehavior|module:Common', '0', '1381021954');

-- ----------------------------
-- Table structure for shuipfcms_cache
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_cache`;
CREATE TABLE `shuipfcms_cache` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `key` char(100) NOT NULL COMMENT '缓存key值',
  `name` char(100) NOT NULL COMMENT '名称',
  `module` char(20) NOT NULL COMMENT '模块名称',
  `model` char(30) NOT NULL COMMENT '模型名称',
  `action` char(30) NOT NULL COMMENT '方法名',
  `param` char(255) NOT NULL COMMENT '参数',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统',
  PRIMARY KEY (`id`),
  KEY `ckey` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='缓存更新列队';

-- ----------------------------
-- Records of shuipfcms_cache
-- ----------------------------
INSERT INTO `shuipfcms_cache` VALUES ('1', 'Config', '网站配置', '', 'Config', 'config_cache', '', '1');
INSERT INTO `shuipfcms_cache` VALUES ('2', 'Module', '可用模块列表', '', 'Module', 'module_cache', '', '1');
INSERT INTO `shuipfcms_cache` VALUES ('3', 'Behavior', '行为列表', '', 'Behavior', 'behavior_cache', '', '1');
INSERT INTO `shuipfcms_cache` VALUES ('4', 'Menu', '后台菜单', 'Admin', 'Menu', 'menu_cache', '', '0');
INSERT INTO `shuipfcms_cache` VALUES ('5', 'Category', '栏目索引', 'Content', 'Category', 'category_cache', '', '0');
INSERT INTO `shuipfcms_cache` VALUES ('6', 'Model', '模型列表', 'Content', 'Model', 'model_cache', '', '0');
INSERT INTO `shuipfcms_cache` VALUES ('7', 'Urlrules', 'URL规则', 'Content', 'Urlrule', 'urlrule_cache', '', '0');
INSERT INTO `shuipfcms_cache` VALUES ('8', 'ModelField', '模型字段', 'Content', 'ModelField', 'model_field_cache', '', '0');

-- ----------------------------
-- Table structure for shuipfcms_category
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_category`;
CREATE TABLE `shuipfcms_category` (
  `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `module` varchar(15) NOT NULL COMMENT '所属模块',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类别',
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `domain` varchar(200) DEFAULT NULL COMMENT '栏目绑定域名',
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `arrparentid` varchar(255) NOT NULL COMMENT '所有父ID',
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否存在子栏目，1存在',
  `arrchildid` mediumtext NOT NULL COMMENT '所有子栏目ID',
  `catname` varchar(30) NOT NULL COMMENT '栏目名称',
  `image` varchar(100) NOT NULL COMMENT '栏目图片',
  `description` mediumtext NOT NULL COMMENT '栏目描述',
  `parentdir` varchar(100) NOT NULL COMMENT '父目录',
  `catdir` varchar(30) NOT NULL COMMENT '栏目目录',
  `url` varchar(100) NOT NULL COMMENT '链接地址',
  `hits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目点击数',
  `setting` mediumtext NOT NULL COMMENT '相关配置信息',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `sethtml` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否生成静态',
  `letter` varchar(30) NOT NULL COMMENT '栏目拼音',
  PRIMARY KEY (`catid`),
  KEY `module` (`module`,`parentid`,`listorder`,`catid`),
  KEY `siteid` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shuipfcms_category
-- ----------------------------
INSERT INTO `shuipfcms_category` VALUES ('1', 'content', '0', '2', '', '0', '0', '0', '1', '下载', '', 'ShuipFCMS - 简单而强大的内容管理系统，开源、安全值得信赖！', '', 'download', '/download.shtml', '0', 'a:20:{s:13:\"listoffmoving\";s:1:\"1\";s:13:\"showoffmoving\";s:1:\"1\";s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:81:\"ShuipFCMS - 简单而强大的内容管理系统，开源、安全值得信赖！\";s:13:\"meta_keywords\";s:40:\"ShuipFCMS下载,ShuipFCMS最新版下载\";s:16:\"meta_description\";s:81:\"ShuipFCMS - 简单而强大的内容管理系统，开源、安全值得信赖！\";s:13:\"list_template\";s:17:\"list_download.php\";s:13:\"show_template\";s:8:\"show.php\";s:19:\"list_customtemplate\";s:8:\"download\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:2:\"14\";s:11:\"show_ruleid\";s:1:\"4\";}', '1', '1', '1', 'xiazai');
INSERT INTO `shuipfcms_category` VALUES ('2', 'content', '0', '3', '', '0', '0', '1', '2,3,4,17,19', '案例', '', '他们正在使用ShuipFCMS~案例提交请发送到admin#abc3210.com邮箱！', '', 'case', '/case/', '0', 'a:19:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:12:\"案例展示\";s:13:\"meta_keywords\";s:29:\"案例,ShuipFCMS案例,示例\";s:16:\"meta_description\";s:45:\"展示一些比较优秀的ShuipFCMS案例！\";s:17:\"category_template\";s:17:\"category_case.php\";s:13:\"list_template\";s:8:\"list.php\";s:13:\"show_template\";s:8:\"show.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:1:\"4\";}', '2', '1', '1', 'anli');
INSERT INTO `shuipfcms_category` VALUES ('3', 'content', '0', '3', '', '2', '0', '0', '3', '信息资讯', '', '', 'case/', 'info', '/case/info/', '0', 'a:18:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"list_template\";s:13:\"list_case.php\";s:13:\"show_template\";s:13:\"show_case.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"15\";}', '0', '1', '1', 'xinxizixun');
INSERT INTO `shuipfcms_category` VALUES ('4', 'content', '0', '3', '', '2', '0', '0', '4', '行业门户', '', '', 'case/', 'portal', '/case/portal/', '0', 'a:18:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"list_template\";s:13:\"list_case.php\";s:13:\"show_template\";s:13:\"show_case.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"15\";}', '0', '1', '1', 'xingyemenhu');
INSERT INTO `shuipfcms_category` VALUES ('5', 'content', '0', '1', '', '0', '0', '1', '5,6,7,8,9', '帮助', '', 'ShuipFCMS系统的使用帮助文档，助您更快上手使用！加群(49219815)得到更多帮助。', '', 'help', '/help/', '0', 'a:16:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:21:\"ShuipFCMS使用帮助\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:17:\"category_template\";s:17:\"category_help.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";N;}', '3', '1', '1', 'bangzhu');
INSERT INTO `shuipfcms_category` VALUES ('6', 'content', '0', '1', '', '5', '0', '0', '6', '模板制作', '', '', 'help/', 'template', '/help/template/', '0', 'a:18:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"list_template\";s:13:\"list_help.php\";s:13:\"show_template\";s:13:\"show_help.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"15\";}', '0', '1', '1', 'mobanzhizuo');
INSERT INTO `shuipfcms_category` VALUES ('7', 'content', '0', '1', '', '5', '0', '0', '7', '安装使用', '', '', 'help/', 'use', '/help/use/', '0', 'a:19:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:17:\"category_template\";s:12:\"category.php\";s:13:\"list_template\";s:13:\"list_help.php\";s:13:\"show_template\";s:13:\"show_help.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"15\";}', '0', '1', '1', 'anzhuangshiyong');
INSERT INTO `shuipfcms_category` VALUES ('8', 'content', '0', '1', '', '5', '0', '0', '8', '二次开发', '', '', 'help/', 'develop', '/help/develop/', '0', 'a:19:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:17:\"category_template\";s:12:\"category.php\";s:13:\"list_template\";s:13:\"list_help.php\";s:13:\"show_template\";s:13:\"show_help.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"15\";}', '0', '1', '1', 'ercikaifa');
INSERT INTO `shuipfcms_category` VALUES ('17', 'content', '0', '3', '', '2', '0', '0', '17', '企业', '', '', 'case/', 'enterprise', '/case/enterprise/', '0', 'a:19:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:17:\"category_template\";s:12:\"category.php\";s:13:\"list_template\";s:13:\"list_case.php\";s:13:\"show_template\";s:13:\"show_case.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"16\";}', '0', '1', '1', 'qiye');
INSERT INTO `shuipfcms_category` VALUES ('9', 'content', '0', '1', '', '5', '0', '0', '9', '其他', '', '', 'help/', 'other', '/help/other/', '0', 'a:19:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:17:\"category_template\";s:12:\"category.php\";s:13:\"list_template\";s:13:\"list_help.php\";s:13:\"show_template\";s:13:\"show_help.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"15\";}', '0', '1', '1', 'qita');
INSERT INTO `shuipfcms_category` VALUES ('10', 'content', '0', '5', '', '0', '0', '1', '10,11,12', '扩展', '', 'ShuipFCMS 扩展，减轻你的开发负担，安全、方便、快捷、简单！加群(49219815)得到更多帮助。', '', 'extend', '/extend/', '0', 'a:16:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:18:\"应用插件扩展\";s:13:\"meta_keywords\";s:54:\"模块扩展,插件扩展,ShuipFCMS扩展,应用扩展\";s:16:\"meta_description\";s:82:\"ShuipFCMS 扩展，减轻你的开发负担，安全、方便、快捷、简单！\";s:17:\"category_template\";s:18:\"category_addon.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";N;}', '4', '1', '1', 'kuozhan');
INSERT INTO `shuipfcms_category` VALUES ('11', 'content', '0', '5', '', '10', '0', '0', '11', '模块', '', 'ShuipFCMS 扩展，减轻你的开发负担，安全、方便、快捷、简单！', 'extend/', 'module', '/extend/module/', '0', 'a:18:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:12:\"模块扩展\";s:13:\"meta_keywords\";s:54:\"模块扩展,插件扩展,ShuipFCMS扩展,应用扩展\";s:16:\"meta_description\";s:83:\"ShuipFCMS 扩展，减轻你的开发负担，安全、方便、快捷、简单！\"\";s:13:\"list_template\";s:14:\"list_addon.php\";s:13:\"show_template\";s:14:\"show_addon.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"15\";}', '0', '1', '1', 'mokuai');
INSERT INTO `shuipfcms_category` VALUES ('12', 'content', '0', '5', '', '10', '0', '0', '12', '插件', '', 'ShuipFCMS 扩展，减轻你的开发负担，安全、方便、快捷、简单！', 'extend/', 'addon', '/extend/addon/', '0', 'a:18:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:12:\"插件扩展\";s:13:\"meta_keywords\";s:48:\"插件,插件扩展,ShuipFCMS扩展,应用扩展\";s:16:\"meta_description\";s:83:\"ShuipFCMS 扩展，减轻你的开发负担，安全、方便、快捷、简单！\"\";s:13:\"list_template\";s:14:\"list_addon.php\";s:13:\"show_template\";s:14:\"show_addon.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"15\";}', '0', '1', '1', 'chajian');
INSERT INTO `shuipfcms_category` VALUES ('55', 'content', '1', '0', '', '24', '0', '1', '55', '模块开发', '', '', 'document/development/', 'develop', '/index.php?a=lists&catid=55', '0', 'a:8:{s:13:\"listoffmoving\";s:1:\"1\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'mokuaikaifa');
INSERT INTO `shuipfcms_category` VALUES ('13', 'content', '0', '6', '', '0', '0', '1', '13,14,15', '模板', '', 'ShuipFCMS模板发布、分享平台，用户可以在这里找到喜欢的模板下载。', '', 'template', '/template/', '0', 'a:16:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:15:\"ShuipFCMS模板\";s:13:\"meta_keywords\";s:64:\"ShuipFCMS模板,ShuipFCMS模板,模板,免费模板,企业模板\";s:16:\"meta_description\";s:90:\"ShuipFCMS模板发布、分享平台，用户可以在这里找到喜欢的模板下载。\";s:17:\"category_template\";s:21:\"category_template.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";N;}', '5', '1', '1', 'moban');
INSERT INTO `shuipfcms_category` VALUES ('14', 'content', '0', '6', '', '13', '0', '0', '14', '博客类', '', '', 'template/', 'blog', '/template/blog/', '0', 'a:18:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:21:\"博客类风格模板\";s:13:\"meta_keywords\";s:47:\"博客类风模板,ShuipFCMS模板,免费模板\";s:16:\"meta_description\";s:30:\"提供博客类风格模板！\";s:13:\"list_template\";s:17:\"list_template.php\";s:13:\"show_template\";s:17:\"show_template.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"15\";}', '0', '1', '1', 'bokelei');
INSERT INTO `shuipfcms_category` VALUES ('15', 'content', '0', '6', '', '13', '0', '0', '15', '其他', '', '', 'template/', 'other', '/template/other/', '0', 'a:18:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:12:\"其他模板\";s:13:\"meta_keywords\";s:41:\"其他模板,免费模板,ShuipFCMS模板\";s:16:\"meta_description\";s:36:\"其他类型ShuipFCMS模板下载！\";s:13:\"list_template\";s:17:\"list_template.php\";s:13:\"show_template\";s:17:\"show_template.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"15\";}', '0', '1', '1', 'qita');
INSERT INTO `shuipfcms_category` VALUES ('16', 'content', '0', '7', '', '0', '0', '0', '16', '新闻动态', '', 'ShuipFCMS最新动态！', '', 'news', '/news/', '0', 'a:14:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"list_template\";s:8:\"list.php\";s:13:\"show_template\";s:8:\"show.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"16\";s:6:\"extend\";a:1:{s:2:\"ss\";s:0:\"\";}}', '0', '1', '1', 'xinwendongtai');
INSERT INTO `shuipfcms_category` VALUES ('18', 'content', '2', '9999', null, '0', '', '0', '', '产品授权', '', '产品授权', '', '0', 'http://www.shuipfcms.com/authorize.shtml', '0', 'a:2:{s:15:\"category_ruleid\";N;s:11:\"show_ruleid\";N;}', '0', '1', '0', 'chanpinshouquan');
INSERT INTO `shuipfcms_category` VALUES ('19', 'content', '0', '3', '', '2', '0', '0', '19', '博客类', '', '', 'case/', 'blog', '/case/blog/', '0', 'a:18:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:12:\"member_check\";s:1:\"1\";s:12:\"member_admin\";s:1:\"1\";s:16:\"member_editcheck\";s:1:\"1\";s:19:\"member_generatelish\";s:1:\"0\";s:15:\"member_addpoint\";s:1:\"0\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"list_template\";s:13:\"list_case.php\";s:13:\"show_template\";s:13:\"show_case.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"1\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";s:2:\"15\";}', '0', '1', '1', 'bokelei');
INSERT INTO `shuipfcms_category` VALUES ('20', 'content', '1', '0', 'http://document.shuipfcms.com/', '0', '0', '1', '20,21,28,29,30,52,22,45,46,47,48,49,50,51,59,60,23,24,55,56,57,54,25,53,61,27,31,44,32,33,34,35,36,37,38,39,40,41,42,58,26,43', '在线手册', '', '', '', 'document', 'http://document.shuipfcms.com/', '0', 'a:7:{s:10:\"meta_title\";s:21:\"ShuipFCMS在线手册\";s:13:\"meta_keywords\";s:38:\"在线收藏,开发手册,使用手册\";s:16:\"meta_description\";s:67:\"ShuipFCMS系列开发手册在线版，当前更新到 1.5.0 版本\";s:13:\"page_template\";s:17:\"page_document.php\";s:6:\"ishtml\";s:1:\"1\";s:15:\"category_ruleid\";s:1:\"2\";s:11:\"show_ruleid\";N;}', '6', '0', '1', 'zaixianshouce');
INSERT INTO `shuipfcms_category` VALUES ('28', 'content', '1', '0', '', '21', '0', '0', '28', '安装', '', '', 'document/introduction/', 'instal', '/index.php?a=lists&catid=28', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'anzhuang');
INSERT INTO `shuipfcms_category` VALUES ('21', 'content', '1', '0', null, '20', '0', '1', '21', '简介', '', '', 'document/', 'introduction', '/index.php?a=lists&catid=21', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'jianjie');
INSERT INTO `shuipfcms_category` VALUES ('22', 'content', '1', '0', '', '20', '0', '1', '22', '后台使用帮助', '', '', 'document/', 'adminhellp', '/index.php?a=lists&catid=22', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'houtaishiyongbangzhu');
INSERT INTO `shuipfcms_category` VALUES ('23', 'content', '1', '0', '', '20', '0', '1', '23', '架构设计', '', '', 'document/', 'architecture', '/index.php?a=lists&catid=23', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '0', '0', 'jiagousheji');
INSERT INTO `shuipfcms_category` VALUES ('24', 'content', '1', '0', '', '20', '0', '1', '24', '二次开发指南', '', '', 'document/', 'development', '/index.php?a=lists&catid=24', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'ercikaifazhinan');
INSERT INTO `shuipfcms_category` VALUES ('25', 'content', '1', '0', '', '20', '0', '1', '25', '模板制作', '', '', 'document/', 'template', '/index.php?a=lists&catid=25', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'mobanzhizuo');
INSERT INTO `shuipfcms_category` VALUES ('26', 'content', '1', '0', '', '20', '0', '1', '26', '附录', '', '', 'document/', 'appendix', '/index.php?a=lists&catid=26', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'fulu');
INSERT INTO `shuipfcms_category` VALUES ('43', 'content', '1', '0', '', '26', '0', '0', '43', '系统函数库', '', '', 'document/appendix/', 'fun', '/index.php?a=lists&catid=43', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'xitonghanshuku');
INSERT INTO `shuipfcms_category` VALUES ('27', 'content', '1', '0', null, '25', '0', '0', '27', '模板目录结构', '', '', 'document/template/', 'jiegou', '/index.php?a=lists&catid=27', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '1', '1', '0', 'mobanmulujiegou');
INSERT INTO `shuipfcms_category` VALUES ('29', 'content', '1', '0', '', '21', '0', '0', '29', '模块安装', '', '', 'document/introduction/', 'model_instal', '/index.php?a=lists&catid=29', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'mokuaianzhuang');
INSERT INTO `shuipfcms_category` VALUES ('30', 'content', '1', '0', '', '21', '0', '0', '30', '插件安装', '', '', 'document/introduction/', 'addon_instal', '/index.php?a=lists&catid=30', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'chajiananzhuang');
INSERT INTO `shuipfcms_category` VALUES ('31', 'content', '1', '0', '', '25', '0', '0', '31', '基本语法', '', '', 'document/template/', 'grammar', '/index.php?a=lists&catid=31', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '2', '1', '0', 'jibenyufa');
INSERT INTO `shuipfcms_category` VALUES ('32', 'content', '1', '0', '', '25', '0', '1', '32', '标签使用', '', '', 'document/template/', 'label', '/index.php?a=lists&catid=32', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '4', '1', '0', 'biaoqianshiyong');
INSERT INTO `shuipfcms_category` VALUES ('33', 'content', '1', '0', '', '32', '0', '0', '33', 'content', '', '', 'document/template/label/', 'content', '/index.php?a=lists&catid=33', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'content');
INSERT INTO `shuipfcms_category` VALUES ('34', 'content', '1', '0', '', '32', '0', '0', '34', 'spf', '', '', 'document/template/label/', 'spf', '/index.php?a=lists&catid=34', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'spf');
INSERT INTO `shuipfcms_category` VALUES ('35', 'content', '1', '0', '', '32', '0', '0', '35', 'tags', '', '', 'document/template/label/', 'tags', '/index.php?a=lists&catid=35', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'tags');
INSERT INTO `shuipfcms_category` VALUES ('36', 'content', '1', '0', '', '32', '0', '0', '36', 'comment', '', '', 'document/template/label/', 'comment', '/index.php?a=lists&catid=36', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'comment');
INSERT INTO `shuipfcms_category` VALUES ('37', 'content', '1', '0', '', '32', '0', '0', '37', 'position', '', '', 'document/template/label/', 'position', '/index.php?a=lists&catid=37', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'position');
INSERT INTO `shuipfcms_category` VALUES ('38', 'content', '1', '0', '', '32', '0', '0', '38', 'get', '', '', 'document/template/label/', 'get', '/index.php?a=lists&catid=38', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'get');
INSERT INTO `shuipfcms_category` VALUES ('39', 'content', '1', '0', '', '32', '0', '0', '39', 'template', '', '', 'document/template/label/', 'template', '/index.php?a=lists&catid=39', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'template');
INSERT INTO `shuipfcms_category` VALUES ('40', 'content', '1', '0', '', '32', '0', '0', '40', 'navigate', '', '', 'document/template/label/', 'navigate', '/index.php?a=lists&catid=40', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'navigate');
INSERT INTO `shuipfcms_category` VALUES ('41', 'content', '1', '0', '', '32', '0', '0', '41', 'pre', '', '', 'document/template/label/', 'pre', '/index.php?a=lists&catid=41', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'pre');
INSERT INTO `shuipfcms_category` VALUES ('42', 'content', '1', '0', '', '32', '0', '0', '42', 'next', '', '', 'document/template/label/', 'next', '/index.php?a=lists&catid=42', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'next');
INSERT INTO `shuipfcms_category` VALUES ('44', 'content', '1', '0', '', '25', '0', '0', '44', '分页配置', '', '', 'document/template/', 'page', '/index.php?a=lists&catid=44', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '3', '1', '0', 'fenyepeizhi');
INSERT INTO `shuipfcms_category` VALUES ('45', 'content', '1', '0', '', '22', '0', '0', '45', '后台介绍', '', '', 'document/adminhellp/', 'admin', '/index.php?a=lists&catid=45', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'houtaijieshao');
INSERT INTO `shuipfcms_category` VALUES ('46', 'content', '1', '0', '', '22', '0', '0', '46', '网站配置', '', '', 'document/adminhellp/', 'config', '/index.php?a=lists&catid=46', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'wangzhanpeizhi');
INSERT INTO `shuipfcms_category` VALUES ('47', 'content', '1', '0', '', '22', '0', '0', '47', '栏目创建', '', '', 'document/adminhellp/', 'addclass', '/index.php?a=lists&catid=47', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'lanmuchuangjian');
INSERT INTO `shuipfcms_category` VALUES ('48', 'content', '1', '0', '', '22', '0', '0', '48', '推荐位使用', '', '', 'document/adminhellp/', 'posit', '/index.php?a=lists&catid=48', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'tuijianweishiyong');
INSERT INTO `shuipfcms_category` VALUES ('49', 'content', '1', '0', '', '22', '0', '0', '49', '内容静态生成', '', '', 'document/adminhellp/', 'html', '/index.php?a=lists&catid=49', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'neirongjingtaishengcheng');
INSERT INTO `shuipfcms_category` VALUES ('50', 'content', '1', '0', '', '22', '0', '0', '50', '内容模型使用', '', '', 'document/adminhellp/', 'model', '/index.php?a=lists&catid=50', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'neirongmoxingshiyong');
INSERT INTO `shuipfcms_category` VALUES ('51', 'content', '1', '0', '', '22', '0', '0', '51', 'URL规则管理', '', '', 'document/adminhellp/', 'url', '/index.php?a=lists&catid=51', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'urlguizeguanli');
INSERT INTO `shuipfcms_category` VALUES ('52', 'content', '1', '0', '', '21', '0', '0', '52', '网站迁移/域名更换', '', '', 'document/introduction/', 'qian', '/index.php?a=lists&catid=52', '0', 'a:7:{s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'wangzhanqianyi/yuminggenghuan');
INSERT INTO `shuipfcms_category` VALUES ('53', 'content', '1', '0', '', '25', '0', '0', '53', '常用变量', '', '', 'document/template/', 'variable', '/index.php?a=lists&catid=53', '0', 'a:8:{s:13:\"listoffmoving\";s:1:\"1\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'changyongbianliang');
INSERT INTO `shuipfcms_category` VALUES ('54', 'content', '1', '0', '', '24', '0', '0', '54', '自定义函数扩展', '', '', 'document/development/', 'extend', '/index.php?a=lists&catid=54', '0', 'a:8:{s:13:\"listoffmoving\";s:1:\"1\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'zidingyihanshukuozhan');
INSERT INTO `shuipfcms_category` VALUES ('56', 'content', '1', '0', '', '55', '0', '0', '56', '制作安装程序', '', '', 'document/development/develop/', 'install', '/index.php?a=lists&catid=56', '0', 'a:8:{s:13:\"listoffmoving\";s:1:\"1\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'zhizuoanzhuangchengxu');
INSERT INTO `shuipfcms_category` VALUES ('57', 'content', '1', '0', '', '55', '0', '0', '57', '制作卸载程序', '', '', 'document/development/develop/', 'uninstall', '/index.php?a=lists&catid=57', '0', 'a:8:{s:13:\"listoffmoving\";s:1:\"1\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'zhizuoxiezaichengxu');
INSERT INTO `shuipfcms_category` VALUES ('58', 'content', '1', '0', '', '32', '0', '0', '58', 'blockcache', '', '', 'document/template/label/', 'blockcache', '/index.php?a=lists&catid=58', '0', 'a:8:{s:13:\"listoffmoving\";s:1:\"1\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'blockcache');
INSERT INTO `shuipfcms_category` VALUES ('59', 'content', '1', '0', '', '22', '0', '0', '59', '单页使用', '', '', 'document/adminhellp/', 'page', '/index.php?a=lists&catid=59', '0', 'a:8:{s:13:\"listoffmoving\";s:1:\"1\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'danyeshiyong');
INSERT INTO `shuipfcms_category` VALUES ('60', 'content', '1', '0', '', '22', '0', '0', '60', '自定义列表使用', '', '', 'document/adminhellp/', 'customlist', '/index.php?a=lists&catid=60', '0', 'a:8:{s:13:\"listoffmoving\";s:1:\"1\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'zidingyiliebiaoshiyong');
INSERT INTO `shuipfcms_category` VALUES ('61', 'content', '1', '0', '', '25', '0', '0', '61', '常用模板标签', '', '', 'document/template/', 'biaoqian', '/index.php?a=lists&catid=61', '0', 'a:8:{s:13:\"listoffmoving\";s:1:\"1\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:13:\"page_template\";s:8:\"page.php\";s:6:\"ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";N;}', '0', '1', '0', 'changyongmobanbiaoqian');
INSERT INTO `shuipfcms_category` VALUES ('63', 'content', '0', '1', '', '0', '0', '0', '63', 'ss', '', '', '', 'ss', '/index.php?a=lists&catid=63', '0', 'a:14:{s:12:\"generatehtml\";s:1:\"1\";s:12:\"generatelish\";s:1:\"0\";s:10:\"meta_title\";s:0:\"\";s:13:\"meta_keywords\";s:0:\"\";s:16:\"meta_description\";s:0:\"\";s:17:\"category_template\";s:12:\"category.php\";s:13:\"list_template\";s:8:\"list.php\";s:13:\"show_template\";s:8:\"show.php\";s:19:\"list_customtemplate\";s:0:\"\";s:6:\"ishtml\";s:1:\"0\";s:9:\"repagenum\";s:0:\"\";s:14:\"content_ishtml\";s:1:\"0\";s:15:\"category_ruleid\";s:1:\"1\";s:11:\"show_ruleid\";s:1:\"4\";}', '0', '1', '0', 'ss');

-- ----------------------------
-- Table structure for shuipfcms_category_field
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_category_field`;
CREATE TABLE `shuipfcms_category_field` (
  `fid` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '自增长id',
  `catid` smallint(5) DEFAULT NULL COMMENT '栏目ID',
  `fieldname` varchar(30) NOT NULL COMMENT '字段名',
  `type` varchar(10) NOT NULL COMMENT '类型,input',
  `setting` mediumtext NOT NULL COMMENT '其他',
  `createtime` int(10) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='栏目扩展字段列表';

-- ----------------------------
-- Records of shuipfcms_category_field
-- ----------------------------
INSERT INTO `shuipfcms_category_field` VALUES ('1', '16', 'ss', 'textarea', 'a:4:{s:5:\"title\";s:2:\"ss\";s:4:\"tips\";s:0:\"\";s:5:\"style\";s:0:\"\";s:6:\"option\";s:24:\"选项名称1|选项值1\";}', '1400653423');

-- ----------------------------
-- Table structure for shuipfcms_category_priv
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_category_priv`;
CREATE TABLE `shuipfcms_category_priv` (
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `roleid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '角色或者组ID',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为管理员 1、管理员',
  `action` char(30) NOT NULL COMMENT '动作',
  KEY `catid` (`catid`,`roleid`,`is_admin`,`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目权限表';

-- ----------------------------
-- Records of shuipfcms_category_priv
-- ----------------------------
INSERT INTO `shuipfcms_category_priv` VALUES ('6', '4', '0', 'add');
INSERT INTO `shuipfcms_category_priv` VALUES ('6', '5', '0', 'add');
INSERT INTO `shuipfcms_category_priv` VALUES ('6', '6', '0', 'add');

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
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='网站配置表';

-- ----------------------------
-- Records of shuipfcms_config
-- ----------------------------
INSERT INTO `shuipfcms_config` VALUES ('1', 'sitename', '网站名称', '1', 'ShuipFCMS内容管理系统');
INSERT INTO `shuipfcms_config` VALUES ('2', 'siteurl', '网站网址', '1', '/');
INSERT INTO `shuipfcms_config` VALUES ('3', 'sitefileurl', '附件地址', '1', '/d/file/');
INSERT INTO `shuipfcms_config` VALUES ('4', 'siteemail', '站点邮箱', '1', 'ad@qq.com');
INSERT INTO `shuipfcms_config` VALUES ('6', 'siteinfo', '网站介绍', '1', 'ShuipFCMS网站管理系统,是一款完全开源免费的PHP+MYSQL系统.核心采用了Thinkphp框架等众多开源软件,同时核心功能也作为开源软件发布');
INSERT INTO `shuipfcms_config` VALUES ('7', 'sitekeywords', '网站关键字', '1', 'ShuipFCMS内容管理系统');
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
INSERT INTO `shuipfcms_config` VALUES ('19', 'theme', '主题风格', '1', 'Default');
INSERT INTO `shuipfcms_config` VALUES ('20', 'ftpstatus', 'FTP上传', '1', '0');
INSERT INTO `shuipfcms_config` VALUES ('21', 'ftpuser', 'FTP用户名', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('22', 'ftppassword', 'FTP密码', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('23', 'ftphost', 'FTP服务器地址', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('24', 'ftpport', 'FTP服务器端口', '1', '21');
INSERT INTO `shuipfcms_config` VALUES ('25', 'ftppasv', 'FTP是否开启被动模式', '1', '1');
INSERT INTO `shuipfcms_config` VALUES ('26', 'ftpssl', 'FTP是否使用SSL连接', '1', '0');
INSERT INTO `shuipfcms_config` VALUES ('27', 'ftptimeout', 'FTP超时时间', '1', '10');
INSERT INTO `shuipfcms_config` VALUES ('28', 'ftpuppat', 'FTP上传目录', '1', '/');
INSERT INTO `shuipfcms_config` VALUES ('29', 'mail_type', '邮件发送模式', '1', '1');
INSERT INTO `shuipfcms_config` VALUES ('30', 'mail_server', '邮件服务器', '1', 'smtp.qq.com');
INSERT INTO `shuipfcms_config` VALUES ('31', 'mail_port', '邮件发送端口', '1', '25');
INSERT INTO `shuipfcms_config` VALUES ('32', 'mail_from', '发件人地址', '1', 'admin@abc3210.com');
INSERT INTO `shuipfcms_config` VALUES ('33', 'mail_auth', '密码验证', '1', '1');
INSERT INTO `shuipfcms_config` VALUES ('34', 'mail_user', '邮箱用户名', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('35', 'mail_password', '邮箱密码', '1', '');
INSERT INTO `shuipfcms_config` VALUES ('36', 'mail_fname', '发件人名称', '1', 'ShuipFCMS管理员');
INSERT INTO `shuipfcms_config` VALUES ('37', 'domainaccess', '指定域名访问', '1', '0');

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
-- Records of shuipfcms_config_field
-- ----------------------------

-- ----------------------------
-- Table structure for shuipfcms_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_loginlog`;
CREATE TABLE `shuipfcms_loginlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `username` char(30) NOT NULL COMMENT '登录帐号',
  `logintime` int(10) NOT NULL COMMENT '登录时间戳',
  `loginip` char(20) NOT NULL COMMENT '登录IP',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态,1为登录成功，0为登录失败',
  `password` varchar(30) NOT NULL DEFAULT '' COMMENT '尝试错误密码',
  `info` varchar(255) NOT NULL COMMENT '其他说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台登陆日志表';

-- ----------------------------
-- Records of shuipfcms_loginlog
-- ----------------------------


-- ----------------------------
-- Table structure for shuipfcms_menu
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_menu`;
CREATE TABLE `shuipfcms_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `parentid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `app` char(20) NOT NULL COMMENT '应用标识',
  `controller` char(20) NOT NULL COMMENT '控制键',
  `action` char(20) NOT NULL COMMENT '方法',
  `parameter` char(255) NOT NULL COMMENT '附加参数',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否禁用',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序ID',
  PRIMARY KEY (`id`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of shuipfcms_menu
-- ----------------------------
INSERT INTO `shuipfcms_menu` VALUES ('2', '我的面板', '0', 'Admin', 'Config', 'index', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('3', '设置', '0', 'Admin', 'Config', 'index', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('4', '个人信息', '2', 'Admin', 'Adminmanage', 'myinfo', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('5', '修改个人信息', '4', 'Admin', 'Adminmanage', 'myinfo', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('6', '修改密码', '4', 'Admin', 'Adminmanage', 'chanpass', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('7', '系统设置', '3', 'Admin', 'Config', 'index', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('8', '站点配置', '7', 'Admin', 'Config', 'index', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('9', '邮箱配置', '8', 'Admin', 'Config', 'mail', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('10', '附件配置', '8', 'Admin', 'Config', 'attach', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('11', '高级配置', '8', 'Admin', 'Config', 'addition', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('12', '扩展配置', '8', 'Admin', 'Config', 'extend', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('13', '行为管理', '7', 'Admin', 'Behavior', 'index', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('14', '行为日志', '13', 'Admin', 'Behavior', 'logs', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('15', '编辑行为', '13', 'Admin', 'Behavior', 'edit', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('16', '删除行为', '13', 'Admin', 'Behavior', 'delete', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('17', '后台菜单管理', '7', 'Admin', 'Menu', 'index', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('18', '添加菜单', '17', 'Admin', 'Menu', 'add', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('19', '修改', '17', 'Admin', 'Menu', 'edit', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('20', '删除', '17', 'Admin', 'Menu', 'delete', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('21', '管理员设置', '3', 'Admin', 'Management', 'index', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('22', '管理员管理', '21', 'Admin', 'Management', 'manager', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('23', '添加管理员', '22', 'Admin', 'Management', 'adminadd', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('24', '编辑管理信息', '22', 'Admin', 'Management', 'edit', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('25', '删除管理员', '22', 'Admin', 'Management', 'delete', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('26', '角色管理', '21', 'Admin', 'Rbac', 'rolemanage', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('27', '添加角色', '26', 'Admin', 'Rbac', 'roleadd', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('28', '删除角色', '26', 'Admin', 'Rbac', 'roledelete', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('29', '角色编辑', '26', 'Admin', 'Rbac', 'roleedit', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('30', '角色授权', '26', 'Admin', 'Rbac', 'authorize', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('31', '日志管理', '3', 'Admin', 'Logs', 'index', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('32', '后台登陆日志', '31', 'Admin', 'Logs', 'loginlog', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('33', '后台操作日志', '31', 'Admin', 'Logs', 'index', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('34', '删除一个月前的登陆日志', '32', 'Admin', 'Logs', 'deleteloginlog', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('35', '删除一个月前的操作日志', '33', 'Admin', 'Logs', 'deletelog', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('36', '添加行为', '13', 'Admin', 'Behavior', 'add', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('37', '模块', '0', 'Admin', 'Module', 'index', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('38', '在线云平台', '37', 'Admin', 'Cloud', 'index', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('39', '模块商店', '38', 'Admin', 'Moduleshop', 'index', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('40', '插件商店', '38', 'Admin', 'Addonshop', 'index', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('41', '在线升级', '38', 'Admin', 'Upgrade', 'index', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('42', '本地模块管理', '37', 'Admin', 'Module', 'index', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('43', '模块管理', '42', 'Admin', 'Module', 'index', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('44', '内容', '0', 'Content', 'Index', 'index', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('45', '内容管理', '44', 'Content', 'Content', 'index', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('46', '内容相关设置', '44', 'Content', 'Category', 'index', '', '0', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('47', '栏目列表', '46', 'Content', 'Category', 'index', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('48', '添加栏目', '47', 'Content', 'Category', 'add', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('49', '添加单页', '47', 'Content', 'Category', 'singlepage', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('50', '添加外部链接栏目', '47', 'Content', 'Category', 'wadd', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('51', '编辑栏目', '47', 'Content', 'Category', 'edit', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('52', '删除栏目', '47', 'Content', 'Category', 'delete', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('53', '栏目属性转换', '47', 'Content', 'Category', 'categoryshux', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('54', '模型管理', '46', 'Content', 'Models', 'index', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('55', '创建新模型', '54', 'Content', 'Models', 'add', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('56', '删除模型', '54', 'Content', 'Models', 'delete', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('57', '编辑模型', '54', 'Content', 'Models', 'edit', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('58', '模型禁用', '54', 'Content', 'Models', 'disabled', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('59', '模型导入', '54', 'Content', 'Models', 'import', '', '1', '1', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('60', '字段管理', '54', 'Content', 'Field', 'index', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('61', '字段修改', '60', 'Content', 'Field', 'edit', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('62', '字段删除', '60', 'Content', 'Field', 'delete', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('63', '字段状态', '60', 'Content', 'Field', 'disabled', '', '1', '0', '', '0');
INSERT INTO `shuipfcms_menu` VALUES ('64', '模型预览', '60', 'Content', 'Field', 'priview', '', '1', '0', '', '0');

-- ----------------------------
-- Table structure for shuipfcms_model
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_model`;
CREATE TABLE `shuipfcms_model` (
  `modelid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL COMMENT '模型名称',
  `description` char(100) NOT NULL COMMENT '描述',
  `tablename` char(20) NOT NULL COMMENT '表名',
  `setting` text NOT NULL COMMENT '配置信息',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `items` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '信息数',
  `enablesearch` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启全站搜索',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否禁用 1禁用',
  `default_style` char(30) NOT NULL COMMENT '风格',
  `category_template` char(30) NOT NULL COMMENT '栏目模板',
  `list_template` char(30) NOT NULL COMMENT '列表模板',
  `show_template` char(30) NOT NULL COMMENT '内容模板',
  `js_template` varchar(30) NOT NULL COMMENT 'JS模板',
  `sort` tinyint(3) NOT NULL COMMENT '排序',
  `type` tinyint(1) NOT NULL COMMENT '模块标识',
  PRIMARY KEY (`modelid`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shuipfcms_model
-- ----------------------------
INSERT INTO `shuipfcms_model` VALUES ('1', '帮助模型', '帮助', 'article', '', '0', '0', '1', '0', '', '', '', '', '', '0', '0');
INSERT INTO `shuipfcms_model` VALUES ('2', '下载模型', '下载模型', 'download', '', '1383027997', '0', '1', '0', '', '', '', '', '', '0', '0');
INSERT INTO `shuipfcms_model` VALUES ('3', '案例', '用户案例', 'case', '', '1383099138', '0', '1', '0', '', '', '', '', '', '0', '0');
INSERT INTO `shuipfcms_model` VALUES ('4', '普通会员', '普通会员', 'member_ordinary', '', '1383183465', '0', '1', '0', '', '', '', '', '', '0', '2');
INSERT INTO `shuipfcms_model` VALUES ('5', '商品模型', '商品', 'shop', '', '1383276225', '0', '1', '0', '', '', '', '', '', '0', '0');
INSERT INTO `shuipfcms_model` VALUES ('6', '模板模型', '模板模型', 'template', '', '1384321502', '0', '1', '0', '', '', '', '', '', '0', '0');
INSERT INTO `shuipfcms_model` VALUES ('7', '新闻模型', '新闻', 'news', '', '1384327291', '0', '1', '0', '', '', '', '', '', '0', '0');

-- ----------------------------
-- Table structure for shuipfcms_model_field
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_model_field`;
CREATE TABLE `shuipfcms_model_field` (
  `fieldid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `field` varchar(20) NOT NULL COMMENT '字段名',
  `name` varchar(30) NOT NULL COMMENT '别名',
  `tips` text NOT NULL COMMENT '字段提示',
  `css` varchar(30) NOT NULL COMMENT '表单样式',
  `minlength` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最小值',
  `maxlength` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最大值',
  `pattern` varchar(255) NOT NULL COMMENT '数据校验正则',
  `errortips` varchar(255) NOT NULL COMMENT '数据校验未通过的提示信息',
  `formtype` varchar(20) NOT NULL COMMENT '字段类型',
  `setting` mediumtext NOT NULL,
  `formattribute` varchar(255) NOT NULL,
  `unsetgroupids` varchar(255) NOT NULL,
  `unsetroleids` varchar(255) NOT NULL,
  `iscore` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否内部字段 1是',
  `issystem` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否系统字段 1 是',
  `isunique` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '值唯一',
  `isbase` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '作为基本信息',
  `issearch` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '作为搜索条件',
  `isadd` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '在前台投稿中显示',
  `isfulltext` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '作为全站搜索信息',
  `isposition` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否入库到推荐位',
  `listorder` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 禁用 0启用',
  `isomnipotent` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fieldid`),
  KEY `modelid` (`modelid`,`disabled`),
  KEY `field` (`field`,`modelid`)
) ENGINE=MyISAM AUTO_INCREMENT=214 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shuipfcms_model_field
-- ----------------------------
INSERT INTO `shuipfcms_model_field` VALUES ('1', '1', 'catid', '栏目', '', '', '1', '6', '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'a:1:{s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '1', '0', '1', '1', '1', '0', '0', '1', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('2', '1', 'typeid', '类别', '', '', '0', '0', '', '', 'typeid', 'a:2:{s:9:\"minnumber\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '', '', '1', '1', '0', '1', '1', '1', '0', '0', '2', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('3', '1', 'title', '标题', '', 'inputtitle', '1', '160', '', '请输入标题', 'title', 'N;', '', '', '', '0', '1', '0', '1', '1', '1', '1', '1', '3', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('4', '1', 'keywords', '关键词', '多关键词之间用空格隔开', '', '0', '100', '', '', 'keyword', 'a:2:{s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '1', '1', '1', '1', '0', '4', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('5', '1', 'description', '摘要', '', '', '0', '0', '', '', 'textarea', 'a:4:{s:5:\"width\";s:2:\"98\";s:6:\"height\";s:3:\"200\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '1', '6', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('6', '1', 'updatetime', '发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '0', '1', '0', '0', '0', '0', '0', '0', '15', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('7', '1', 'content', '内容', '<style type=\"text/css\">\n.content_attr {\n	border: 1px solid #CCC;\n	padding: 5px 8px;\n	background: #FFC;\n	margin-top: 6px\n}\n</style>\n<div class=\"content_attr\">\n<input name=\"add_introduce\" type=\"checkbox\"  value=\"1\" checked> 是否截取内容\n<input type=\"text\" name=\"introcude_length\" class=\"input\" value=\"200\" size=\"3\"> 字符至内容摘要\n<input type=\'checkbox\' name=\'auto_thumb\' value=\"1\" checked> 是否获取内容第\n<input type=\"text\" name=\"auto_thumb_no\" class=\"input\" value=\"1\" size=\"2\" class=\"\"> 张图片作为标题图片\n</div>', '', '1', '999999', '', '内容不能为空', 'editor', 'a:7:{s:7:\"toolbar\";s:4:\"full\";s:9:\"mbtoolbar\";s:5:\"basic\";s:12:\"defaultvalue\";s:0:\"\";s:15:\"enablesaveimage\";s:1:\"1\";s:6:\"height\";s:0:\"\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '0', '0', '1', '0', '1', '1', '0', '7', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('8', '1', 'thumb', '缩略图', '', '', '0', '100', '', '', 'image', 'a:10:{s:5:\"width\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:9:\"show_type\";s:1:\"1\";s:15:\"upload_allowext\";s:20:\"jpg|jpeg|gif|png|bmp\";s:9:\"watermark\";s:1:\"1\";s:13:\"isselectimage\";s:1:\"1\";s:12:\"images_width\";s:3:\"266\";s:13:\"images_height\";s:3:\"200\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '0', '0', '1', '0', '1', '8', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('9', '1', 'relation', '相关文章', '', '', '0', '255', '', '', 'omnipotent', 'a:4:{s:8:\"formtext\";s:465:\"<input type=\"hidden\" name=\"info[relation]\" id=\"relation\" value=\"{FIELD_VALUE}\" style=\"50\" >\n<ul class=\"list-dot\" id=\"relation_text\">\n</ul>\n<input type=\"button\" value=\"添加相关\" onClick=\"omnipotent(\'selectid\',GV.DIMAUB+\'index.php?a=public_relationlist&m=Content&g=Contents&modelid={MODELID}\',\'添加相关文章\',1)\" class=\"btn\">\n<span class=\"edit_content\">\n  <input type=\"button\" value=\"显示已有\" onClick=\"show_relation({MODELID},{ID})\" class=\"btn\">\n</span>\";s:9:\"fieldtype\";s:7:\"varchar\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '0', '0', '0', '0', '0', '1', '0', '12', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('10', '1', 'pages', '分页方式', '', '', '0', '0', '', '', 'pages', '', '', '-99', '-99', '0', '0', '0', '1', '0', '0', '0', '0', '13', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('11', '1', 'inputtime', '真实发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '0', '0', '1', '14', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('12', '1', 'url', 'URL', '', '', '0', '100', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '1', '18', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('13', '1', 'listorder', '排序', '', '', '0', '6', '', '', 'number', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '19', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('14', '1', 'template', '内容页模板', '', '', '0', '30', '', '', 'template', 'N;', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '20', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('15', '1', 'allow_comment', '允许评论', '', '', '0', '0', '', '', 'box', 'a:9:{s:7:\"options\";s:33:\"允许评论|1\r\n不允许评论|0\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:5:\"width\";s:2:\"88\";s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"1\";s:10:\"filtertype\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '21', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('16', '1', 'status', '状态', '', '', '0', '2', '', '', 'box', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '22', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('17', '1', 'username', '用户名', '', '', '0', '20', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '23', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('18', '1', 'islink', '转向链接', '', '', '0', '0', '', '', 'islink', '', '', '', '', '0', '1', '0', '0', '0', '1', '0', '0', '16', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('19', '1', 'copyfrom', '来源', '', '', '0', '0', '', '', 'copyfrom', 'a:1:{s:12:\"defaultvalue\";s:0:\"\";}', '', '', '', '0', '0', '0', '1', '0', '1', '0', '0', '5', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('104', '5', 'buys', '购买数', '', '', '0', '0', '', '', 'number', 'a:9:{s:9:\"minnumber\";s:1:\"1\";s:9:\"maxnumber\";s:0:\"\";s:13:\"decimaldigits\";s:1:\"0\";s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '0', '0', '8', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('21', '1', 'download', '下载', '', '', '0', '0', '', '', 'downfiles', 'a:7:{s:15:\"upload_allowext\";s:31:\"gif|jpg|jpeg|png|bmp|rar|zip|7z\";s:13:\"isselectimage\";s:1:\"0\";s:13:\"upload_number\";s:2:\"20\";s:12:\"downloadlink\";s:1:\"1\";s:12:\"downloadtype\";s:1:\"1\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '0', '0', '1', '0', '1', '0', '0', '10', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('22', '1', 'posid', '推荐位', '', '', '0', '0', '', '', 'posid', 'a:2:{s:5:\"width\";s:3:\"125\";s:12:\"defaultvalue\";s:0:\"\";}', '', '', '', '0', '1', '0', '1', '0', '0', '0', '0', '11', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('23', '1', 'prefix', '自定义文件名', '', '', '0', '255', '', '', 'text', 'a:5:{s:4:\"size\";s:2:\"27\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '0', '0', '1', '1', '0', '17', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('24', '1', 'tags', 'TAGS', '多关之间用空格或者“,”隔开', '', '0', '0', '', '', 'tags', 'a:4:{s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '0', '0', '0', '4', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('25', '2', 'status', '状态', '', '', '0', '2', '', '', 'box', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '18', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('26', '2', 'username', '用户名', '', '', '0', '20', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '19', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('27', '2', 'islink', '转向链接', '', '', '0', '0', '', '', 'islink', '', '', '', '', '0', '1', '0', '0', '0', '1', '0', '0', '20', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('28', '2', 'template', '内容页模板', '', '', '0', '30', '', '', 'template', 'a:2:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '0', '0', '0', '0', '0', '0', '0', '16', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('29', '2', 'allow_comment', '允许评论', '', '', '0', '0', '', '', 'box', 'a:9:{s:7:\"options\";s:33:\"允许评论|1\r\n不允许评论|0\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:5:\"width\";s:2:\"88\";s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"1\";s:10:\"filtertype\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '17', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('31', '2', 'inputtime', '真实发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '0', '0', '1', '13', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('32', '2', 'posid', '推荐位', '', '', '0', '0', '', '', 'posid', 'a:4:{s:5:\"width\";s:3:\"125\";s:12:\"defaultvalue\";s:0:\"\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '1', '0', '0', '0', '1', '14', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('33', '2', 'url', 'URL', '', '', '0', '100', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '1', '15', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('34', '2', 'listorder', '排序', '', '', '0', '6', '', '', 'number', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '21', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('35', '2', 'relation', '相关文章', '', '', '0', '255', '', '', 'omnipotent', 'a:4:{s:8:\"formtext\";s:471:\"<input type=\"hidden\" name=\"info[relation]\" id=\"relation\" value=\"{FIELD_VALUE}\" style=\"50\" >\r\n<ul class=\"list-dot\" id=\"relation_text\">\r\n</ul>\r\n<input type=\"button\" value=\"添加相关\" onClick=\"omnipotent(\'selectid\',GV.DIMAUB+\'index.php?a=public_relationlist&m=Content&g=Contents&modelid={MODELID}\',\'添加相关文章\',1)\" class=\"btn\">\r\n<span class=\"edit_content\">\r\n  <input type=\"button\" value=\"显示已有\" onClick=\"show_relation({MODELID},{ID})\" class=\"btn\">\r\n</span>\";s:9:\"fieldtype\";s:7:\"varchar\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '0', '0', '0', '0', '0', '1', '0', '11', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('36', '2', 'thumb', '缩略图', '', '', '0', '100', '', '', 'image', 'a:9:{s:4:\"size\";s:2:\"50\";s:12:\"defaultvalue\";s:0:\"\";s:9:\"show_type\";s:1:\"1\";s:14:\"upload_maxsize\";s:4:\"1024\";s:15:\"upload_allowext\";s:20:\"jpg|jpeg|gif|png|bmp\";s:9:\"watermark\";s:1:\"0\";s:13:\"isselectimage\";s:1:\"1\";s:12:\"images_width\";s:0:\"\";s:13:\"images_height\";s:0:\"\";}', '', '', '', '0', '1', '0', '0', '0', '1', '0', '1', '10', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('37', '2', 'catid', '栏目', '', '', '1', '6', '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'a:1:{s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '1', '0', '1', '1', '1', '0', '0', '1', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('38', '2', 'typeid', '类别', '', '', '0', '0', '', '', 'typeid', 'a:2:{s:9:\"minnumber\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '', '', '1', '1', '0', '1', '1', '1', '0', '0', '2', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('39', '2', 'title', '标题', '', 'inputtitle', '1', '80', '', '请输入标题', 'title', 'a:2:{s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '1', '1', '1', '1', '1', '3', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('40', '2', 'keywords', '关键词', '多关键词之间用空格隔开', '', '0', '40', '', '', 'keyword', 'a:2:{s:4:\"size\";s:3:\"100\";s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '1', '0', '1', '1', '1', '1', '0', '4', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('41', '2', 'tags', 'TAGS', '多关之间用空格或者“,”隔开', '', '0', '0', '', '', 'tags', 'a:4:{s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '0', '0', '0', '4', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('42', '2', 'description', '摘要', '', '', '0', '255', '', '', 'textarea', 'a:6:{s:5:\"width\";s:2:\"98\";s:6:\"height\";s:2:\"46\";s:12:\"defaultvalue\";s:60:\"此版修复一些网友反馈的Bug，同时优化程序！\";s:10:\"enablehtml\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '1', '5', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('43', '2', 'updatetime', '发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '0', '1', '0', '0', '0', '0', '0', '0', '12', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('44', '2', 'updatelog', '更新日志', '<style type=\"text/css\">.content_attr{ border:1px solid #CCC; padding:5px 8px; background:#FFC; margin-top:6px}</style><div class=\"content_attr\"><label><input name=\"add_introduce\" type=\"checkbox\"  value=\"1\" checked>是否截取内容</label><input type=\"text\" name=\"introcude_length\" value=\"200\" size=\"3\">字符至内容摘要\n<label><input type=\'checkbox\' name=\'auto_thumb\' value=\"1\" checked>是否获取内容第</label><input type=\"text\" name=\"auto_thumb_no\" value=\"1\" size=\"2\" class=\"\">张图片作为标题图片\n</div>', '', '1', '999999', '', '内容不能为空', 'editor', 'a:6:{s:7:\"toolbar\";s:5:\"basic\";s:12:\"defaultvalue\";s:0:\"\";s:15:\"enablesaveimage\";s:1:\"1\";s:6:\"height\";s:0:\"\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '0', '0', '1', '0', '1', '1', '0', '9', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('45', '2', 'softwaresize', '软件大小', '', '', '0', '0', '', '', 'text', 'a:7:{s:4:\"size\";s:2:\"50\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '0', '6', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('46', '2', 'updated', '更新日期', '', '', '0', '0', '', '', 'datetime', 'a:7:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:5:\"Y-m-d\";s:11:\"defaulttype\";s:1:\"1\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '0', '0', '7', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('47', '2', 'recommend', '推荐配置', '', '', '0', '0', '', '', 'text', 'a:7:{s:4:\"size\";s:3:\"200\";s:12:\"defaultvalue\";s:25:\"MySQL5.5 + PHP 5.2+ Nginx\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '0', '8', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('48', '2', 'version', '版本', '', '', '0', '0', '', '', 'text', 'a:7:{s:4:\"size\";s:3:\"200\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '0', '5', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('49', '2', 'download', '本地下载', '', '', '0', '0', '', '', 'downfile', 'a:11:{s:5:\"width\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:15:\"upload_allowext\";s:31:\"gif|jpg|jpeg|png|bmp|zip|rar|7z\";s:9:\"watermark\";s:1:\"0\";s:13:\"isselectimage\";s:1:\"1\";s:10:\"statistics\";s:9:\"downloads\";s:12:\"downloadlink\";s:1:\"1\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '0', '0', '8', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('50', '2', 'downloads', '下载次数', '', '', '0', '0', '', '', 'number', 'a:9:{s:9:\"minnumber\";s:1:\"1\";s:9:\"maxnumber\";s:0:\"\";s:13:\"decimaldigits\";s:1:\"0\";s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '0', '0', '8', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('51', '2', 'downloadbaidu', '百度网盘下载', '', '', '0', '0', '', '', 'text', 'a:7:{s:4:\"size\";s:3:\"300\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '0', '8', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('52', '3', 'status', '状态', '', '', '0', '2', '', '', 'box', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '16', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('53', '3', 'username', '用户名', '', '', '0', '20', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '17', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('55', '3', 'template', '内容页模板', '', '', '0', '30', '', '', 'template', 'a:2:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '0', '0', '0', '0', '0', '0', '0', '14', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('56', '3', 'allow_comment', '允许评论', '', '', '0', '0', '', '', 'box', 'a:9:{s:7:\"options\";s:33:\"允许评论|1\r\n不允许评论|0\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:5:\"width\";s:2:\"88\";s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"1\";s:10:\"filtertype\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '15', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('72', '3', 'imgs', '案例截图', '', '', '0', '0', '', '', 'images', 'a:7:{s:15:\"upload_allowext\";s:20:\"gif|jpg|jpeg|png|bmp\";s:13:\"isselectimage\";s:1:\"0\";s:13:\"upload_number\";s:2:\"10\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '0', '0', '1', '0', '1', '0', '0', '6', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('58', '3', 'inputtime', '真实发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '0', '0', '1', '11', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('59', '3', 'posid', '推荐位', '', '', '0', '0', '', '', 'posid', 'a:4:{s:5:\"width\";s:3:\"125\";s:12:\"defaultvalue\";s:0:\"\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '1', '0', '0', '0', '1', '12', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('60', '3', 'url', 'URL', '', '', '0', '100', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '1', '13', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('61', '3', 'listorder', '排序', '', '', '0', '6', '', '', 'number', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '18', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('62', '3', 'relation', '相关文章', '', '', '0', '255', '', '', 'omnipotent', 'a:4:{s:8:\"formtext\";s:471:\"<input type=\"hidden\" name=\"info[relation]\" id=\"relation\" value=\"{FIELD_VALUE}\" style=\"50\" >\r\n<ul class=\"list-dot\" id=\"relation_text\">\r\n</ul>\r\n<input type=\"button\" value=\"添加相关\" onClick=\"omnipotent(\'selectid\',GV.DIMAUB+\'index.php?a=public_relationlist&m=Content&g=Contents&modelid={MODELID}\',\'添加相关文章\',1)\" class=\"btn\">\r\n<span class=\"edit_content\">\r\n  <input type=\"button\" value=\"显示已有\" onClick=\"show_relation({MODELID},{ID})\" class=\"btn\">\r\n</span>\";s:9:\"fieldtype\";s:7:\"varchar\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '0', '0', '0', '0', '0', '1', '0', '9', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('63', '3', 'thumb', '缩略图', '', '', '0', '100', '', '', 'image', 'a:10:{s:5:\"width\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:9:\"show_type\";s:1:\"1\";s:15:\"upload_allowext\";s:20:\"jpg|jpeg|gif|png|bmp\";s:9:\"watermark\";s:1:\"0\";s:13:\"isselectimage\";s:1:\"1\";s:12:\"images_width\";s:3:\"310\";s:13:\"images_height\";s:3:\"180\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '0', '0', '1', '0', '1', '8', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('64', '3', 'catid', '栏目', '', '', '1', '6', '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'a:1:{s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '1', '0', '1', '1', '1', '0', '0', '1', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('65', '3', 'typeid', '类别', '', '', '0', '0', '', '', 'typeid', 'a:2:{s:9:\"minnumber\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '', '', '1', '1', '0', '1', '1', '1', '0', '0', '2', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('66', '3', 'title', '标题', '', 'inputtitle', '1', '80', '', '请输入标题', 'title', '', '', '', '', '0', '1', '0', '1', '1', '1', '1', '1', '3', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('67', '3', 'keywords', '关键词', '多关键词之间用空格隔开', '', '0', '40', '', '', 'keyword', 'a:2:{s:4:\"size\";s:3:\"100\";s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '1', '0', '1', '1', '1', '1', '0', '4', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('68', '3', 'tags', 'TAGS', '多关之间用空格或者“,”隔开', '', '0', '0', '', '', 'tags', 'a:4:{s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '0', '0', '0', '4', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('69', '3', 'description', '摘要', '', '', '0', '255', '', '', 'textarea', 'a:4:{s:5:\"width\";s:2:\"98\";s:6:\"height\";s:2:\"46\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '1', '5', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('70', '3', 'updatetime', '发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '0', '1', '0', '0', '0', '0', '0', '0', '10', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('71', '3', 'content', '案例介绍', '<style type=\"text/css\">.content_attr{ border:1px solid #CCC; padding:5px 8px; background:#FFC; margin-top:6px}</style><div class=\"content_attr\"><label><input name=\"add_introduce\" type=\"checkbox\"  value=\"1\" checked>是否截取内容</label><input type=\"text\" name=\"introcude_length\" value=\"200\" size=\"3\">字符至内容摘要\n<label><input type=\'checkbox\' name=\'auto_thumb\' value=\"1\" checked>是否获取内容第</label><input type=\"text\" name=\"auto_thumb_no\" value=\"1\" size=\"2\" class=\"\">张图片作为标题图片\n</div>', '', '1', '999999', '', '内容不能为空', 'editor', 'a:7:{s:7:\"toolbar\";s:5:\"basic\";s:9:\"mbtoolbar\";s:5:\"basic\";s:12:\"defaultvalue\";s:0:\"\";s:15:\"enablesaveimage\";s:1:\"1\";s:6:\"height\";s:0:\"\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '0', '0', '1', '0', '1', '1', '0', '7', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('73', '5', 'status', '状态', '', '', '0', '2', '', '', 'box', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '27', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('74', '5', 'username', '用户名', '', '', '0', '20', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '28', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('93', '5', 'originalprice', '原价', '原价*100倍', '', '0', '0', '', '', 'number', 'a:9:{s:9:\"minnumber\";s:1:\"1\";s:9:\"maxnumber\";s:0:\"\";s:13:\"decimaldigits\";s:1:\"0\";s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '0', '0', '6', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('76', '5', 'template', '内容页模板', '', '', '0', '30', '', '', 'template', 'a:2:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '0', '0', '0', '0', '0', '0', '0', '25', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('77', '5', 'allow_comment', '允许评论', '', '', '0', '0', '', '', 'box', 'a:9:{s:7:\"options\";s:33:\"允许评论|1\r\n不允许评论|0\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:5:\"width\";s:2:\"88\";s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"1\";s:10:\"filtertype\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '26', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('79', '5', 'inputtime', '真实发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '0', '0', '1', '22', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('80', '5', 'posid', '推荐位', '', '', '0', '0', '', '', 'posid', 'a:4:{s:5:\"width\";s:3:\"125\";s:12:\"defaultvalue\";s:0:\"\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '0', '0', '0', '0', '1', '23', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('81', '5', 'url', 'URL', '', '', '0', '100', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '1', '24', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('82', '5', 'listorder', '排序', '', '', '0', '6', '', '', 'number', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '29', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('94', '5', 'price', '价格', '价格*100倍', '', '0', '0', '', '', 'number', 'a:9:{s:9:\"minnumber\";s:1:\"1\";s:9:\"maxnumber\";s:0:\"\";s:13:\"decimaldigits\";s:1:\"0\";s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '0', '0', '7', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('95', '5', 'mark', '标识', '', '', '0', '0', '', '', 'text', 'a:7:{s:4:\"size\";s:3:\"200\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '0', '9', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('84', '5', 'thumb', '图标', '', '', '0', '100', '', '', 'image', 'a:10:{s:5:\"width\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:9:\"show_type\";s:1:\"1\";s:15:\"upload_allowext\";s:20:\"jpg|jpeg|gif|png|bmp\";s:9:\"watermark\";s:1:\"0\";s:13:\"isselectimage\";s:1:\"1\";s:12:\"images_width\";s:0:\"\";s:13:\"images_height\";s:0:\"\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '0', '0', '1', '0', '1', '20', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('85', '5', 'catid', '栏目', '', '', '1', '6', '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'a:1:{s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '1', '0', '1', '1', '1', '0', '0', '1', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('86', '5', 'typeid', '类别', '', '', '0', '0', '', '', 'typeid', 'a:2:{s:9:\"minnumber\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '', '', '1', '1', '0', '1', '1', '1', '0', '0', '2', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('87', '5', 'title', '标题', '', 'inputtitle', '1', '80', '', '请输入标题', 'title', '', '', '', '', '0', '1', '0', '1', '1', '1', '1', '1', '3', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('88', '5', 'keywords', '关键词', '多关键词之间用空格隔开', '', '0', '40', '', '', 'keyword', 'a:2:{s:4:\"size\";s:3:\"100\";s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '1', '0', '1', '1', '1', '1', '0', '4', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('89', '5', 'tags', 'TAGS', '多关之间用空格或者“,”隔开', '', '0', '0', '', '', 'tags', 'a:4:{s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '0', '0', '0', '5', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('90', '5', 'description', '摘要', '', '', '0', '0', '', '', 'editor', 'a:7:{s:7:\"toolbar\";s:5:\"basic\";s:9:\"mbtoolbar\";s:5:\"basic\";s:12:\"defaultvalue\";s:0:\"\";s:15:\"enablesaveimage\";s:1:\"0\";s:6:\"height\";s:3:\"200\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '1', '13', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('91', '5', 'updatetime', '发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '0', '1', '0', '0', '0', '0', '0', '0', '21', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('92', '5', 'content', '更新记录', '<style type=\"text/css\">.content_attr{ border:1px solid #CCC; padding:5px 8px; background:#FFC; margin-top:6px}</style><div class=\"content_attr\"><label><input name=\"add_introduce\" type=\"checkbox\"  value=\"1\" checked>是否截取内容</label><input type=\"text\" name=\"introcude_length\" value=\"200\" size=\"3\">字符至内容摘要\n<label><input type=\'checkbox\' name=\'auto_thumb\' value=\"1\" checked>是否获取内容第</label><input type=\"text\" name=\"auto_thumb_no\" value=\"1\" size=\"2\" class=\"\">张图片作为标题图片\n</div>', '', '1', '999999', '', '内容不能为空', 'editor', 'a:7:{s:7:\"toolbar\";s:5:\"basic\";s:9:\"mbtoolbar\";s:5:\"basic\";s:12:\"defaultvalue\";s:0:\"\";s:15:\"enablesaveimage\";s:1:\"1\";s:6:\"height\";s:0:\"\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '0', '0', '1', '0', '1', '1', '0', '19', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('96', '5', 'version', '版本', '', '', '0', '0', '', '', 'text', 'a:7:{s:4:\"size\";s:2:\"50\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '0', '11', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('97', '5', 'package', '安装包', '可以写目录名称，直接打包对应目录！', '', '0', '0', '', '', 'downfile', 'a:11:{s:5:\"width\";s:3:\"400\";s:12:\"defaultvalue\";s:0:\"\";s:15:\"upload_allowext\";s:3:\"zip\";s:9:\"watermark\";s:1:\"0\";s:13:\"isselectimage\";s:1:\"1\";s:10:\"statistics\";s:0:\"\";s:12:\"downloadlink\";s:1:\"1\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '0', '0', '1', '0', '1', '0', '0', '14', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('98', '5', 'uppackage', '升级包', '升级包名称格式：0.9.0_upgrade_1.1.0', '', '0', '0', '', '', 'downfiles', 'a:9:{s:15:\"upload_allowext\";s:3:\"zip\";s:13:\"isselectimage\";s:1:\"0\";s:13:\"upload_number\";s:2:\"10\";s:10:\"statistics\";s:0:\"\";s:12:\"downloadlink\";s:1:\"1\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '0', '0', '1', '0', '1', '0', '0', '15', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('99', '5', 'adaptation', '最低支持版本', '', '', '0', '0', '', '', 'text', 'a:7:{s:4:\"size\";s:2:\"50\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '0', '16', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('100', '5', 'coding', '编码', '', '', '0', '0', '', '', 'box', 'a:12:{s:7:\"options\";s:27:\"UTF-8|1\nGBK|2\nGBK和UTF-8|0\";s:7:\"boxtype\";s:6:\"select\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:2:\"-1\";s:5:\"width\";s:2:\"80\";s:4:\"size\";s:1:\"1\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"1\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '0', '0', '17', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('101', '5', 'depend', '依赖', '依赖所属模块或者插件', '', '0', '0', '', '', 'text', 'a:7:{s:4:\"size\";s:3:\"300\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '0', '18', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('102', '5', 'shoptype', '商品类型', '', '', '1', '0', '', '', 'box', 'a:12:{s:7:\"options\";s:26:\"模块|module\n插件|addon\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"varchar\";s:9:\"minnumber\";s:1:\"1\";s:5:\"width\";s:2:\"80\";s:4:\"size\";s:1:\"1\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"outputtype\";s:1:\"1\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '0', '0', '10', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('103', '5', 'softwaresize', '软件大小', '', '', '0', '0', '', '', 'text', 'a:7:{s:4:\"size\";s:2:\"50\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '0', '12', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('105', '5', 'images', '应用截图', '', '', '0', '0', '', '', 'images', 'a:7:{s:15:\"upload_allowext\";s:20:\"gif|jpg|jpeg|png|bmp\";s:13:\"isselectimage\";s:1:\"0\";s:13:\"upload_number\";s:2:\"10\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '0', '0', '1', '0', '1', '0', '0', '18', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('106', '4', 'qq', '联系QQ', '', '', '0', '0', '', '', 'text', 'a:3:{s:4:\"size\";s:3:\"226\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";}', '', '', '', '0', '1', '0', '1', '0', '1', '0', '0', '0', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('107', '6', 'status', '状态', '', '', '0', '2', '', '', 'box', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '17', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('108', '6', 'username', '用户名', '', '', '0', '20', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '18', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('109', '6', 'islink', '转向链接', '', '', '0', '0', '', '', 'islink', '', '', '', '', '0', '1', '0', '0', '0', '1', '0', '0', '19', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('110', '6', 'template', '内容页模板', '', '', '0', '30', '', '', 'template', 'a:2:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '0', '0', '0', '0', '0', '0', '0', '15', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('111', '6', 'allow_comment', '允许评论', '', '', '0', '0', '', '', 'box', 'a:9:{s:7:\"options\";s:33:\"允许评论|1\r\n不允许评论|0\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:5:\"width\";s:2:\"88\";s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"1\";s:10:\"filtertype\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '16', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('112', '6', 'pages', '分页方式', '', '', '0', '0', '', '', 'pages', '', '', '-99', '-99', '0', '0', '0', '1', '0', '0', '0', '0', '10', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('113', '6', 'inputtime', '真实发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '0', '0', '1', '12', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('114', '6', 'posid', '推荐位', '', '', '0', '0', '', '', 'posid', 'a:4:{s:5:\"width\";s:3:\"125\";s:12:\"defaultvalue\";s:0:\"\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '1', '0', '0', '0', '1', '13', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('115', '6', 'url', 'URL', '', '', '0', '100', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '1', '14', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('116', '6', 'listorder', '排序', '', '', '0', '6', '', '', 'number', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '20', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('117', '6', 'relation', '相关文章', '', '', '0', '255', '', '', 'omnipotent', 'a:4:{s:8:\"formtext\";s:471:\"<input type=\"hidden\" name=\"info[relation]\" id=\"relation\" value=\"{FIELD_VALUE}\" style=\"50\" >\r\n<ul class=\"list-dot\" id=\"relation_text\">\r\n</ul>\r\n<input type=\"button\" value=\"添加相关\" onClick=\"omnipotent(\'selectid\',GV.DIMAUB+\'index.php?a=public_relationlist&m=Content&g=Contents&modelid={MODELID}\',\'添加相关文章\',1)\" class=\"btn\">\r\n<span class=\"edit_content\">\r\n  <input type=\"button\" value=\"显示已有\" onClick=\"show_relation({MODELID},{ID})\" class=\"btn\">\r\n</span>\";s:9:\"fieldtype\";s:7:\"varchar\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '0', '0', '0', '0', '0', '1', '0', '9', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('118', '6', 'thumb', '缩略图', '', '', '0', '100', '', '', 'image', 'a:10:{s:5:\"width\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";s:9:\"show_type\";s:1:\"1\";s:15:\"upload_allowext\";s:20:\"jpg|jpeg|gif|png|bmp\";s:9:\"watermark\";s:1:\"0\";s:13:\"isselectimage\";s:1:\"1\";s:12:\"images_width\";s:3:\"310\";s:13:\"images_height\";s:3:\"180\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '0', '0', '1', '0', '1', '8', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('119', '6', 'catid', '栏目', '', '', '1', '6', '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'a:1:{s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '1', '0', '1', '1', '1', '0', '0', '1', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('120', '6', 'typeid', '类别', '', '', '0', '0', '', '', 'typeid', 'a:2:{s:9:\"minnumber\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '', '', '1', '1', '0', '1', '1', '1', '0', '0', '2', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('121', '6', 'title', '标题', '', 'inputtitle', '1', '80', '', '请输入标题', 'title', '', '', '', '', '0', '1', '0', '1', '1', '1', '1', '1', '3', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('122', '6', 'keywords', '关键词', '多关键词之间用空格隔开', '', '0', '40', '', '', 'keyword', 'a:2:{s:4:\"size\";s:3:\"100\";s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '1', '0', '1', '1', '1', '1', '0', '4', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('123', '6', 'tags', 'TAGS', '多关之间用空格或者“,”隔开', '', '0', '0', '', '', 'tags', 'a:4:{s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '0', '0', '0', '4', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('124', '6', 'description', '摘要', '', '', '0', '255', '', '', 'textarea', 'a:4:{s:5:\"width\";s:2:\"98\";s:6:\"height\";s:2:\"46\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '1', '5', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('125', '6', 'updatetime', '发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '0', '1', '0', '0', '0', '0', '0', '0', '11', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('126', '6', 'content', '介绍', '<style type=\"text/css\">.content_attr{ border:1px solid #CCC; padding:5px 8px; background:#FFC; margin-top:6px}</style><div class=\"content_attr\"><label><input name=\"add_introduce\" type=\"checkbox\"  value=\"1\" checked>是否截取内容</label><input type=\"text\" name=\"introcude_length\" value=\"200\" size=\"3\">字符至内容摘要\n<label><input type=\'checkbox\' name=\'auto_thumb\' value=\"1\" checked>是否获取内容第</label><input type=\"text\" name=\"auto_thumb_no\" value=\"1\" size=\"2\" class=\"\">张图片作为标题图片\n</div>', '', '1', '999999', '', '内容不能为空', 'editor', 'a:7:{s:7:\"toolbar\";s:5:\"basic\";s:9:\"mbtoolbar\";s:5:\"basic\";s:12:\"defaultvalue\";s:0:\"\";s:15:\"enablesaveimage\";s:1:\"1\";s:6:\"height\";s:0:\"\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '0', '0', '1', '0', '1', '1', '0', '7', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('127', '6', 'images', '风格效果图', '', '', '0', '0', '', '', 'images', 'a:7:{s:15:\"upload_allowext\";s:20:\"gif|jpg|jpeg|png|bmp\";s:13:\"isselectimage\";s:1:\"0\";s:13:\"upload_number\";s:2:\"10\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '0', '0', '1', '0', '1', '0', '0', '6', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('128', '6', 'download', '主题下载', '', '', '0', '0', '', '', 'downfiles', 'a:9:{s:15:\"upload_allowext\";s:10:\"zip|rar|7z\";s:13:\"isselectimage\";s:1:\"0\";s:13:\"upload_number\";s:2:\"10\";s:10:\"statistics\";s:9:\"downloads\";s:12:\"downloadlink\";s:1:\"1\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '0', '0', '5', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('129', '6', 'downloads', '下载次数', '', '', '0', '0', '', '', 'number', 'a:9:{s:9:\"minnumber\";s:1:\"1\";s:9:\"maxnumber\";s:0:\"\";s:13:\"decimaldigits\";s:1:\"0\";s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '0', '0', '5', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('130', '7', 'status', '状态', '', '', '0', '2', '', '', 'box', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '15', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('131', '7', 'username', '用户名', '', '', '0', '20', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '16', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('132', '7', 'islink', '转向链接', '', '', '0', '0', '', '', 'islink', '', '', '', '', '0', '1', '0', '0', '0', '1', '0', '0', '17', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('133', '7', 'template', '内容页模板', '', '', '0', '30', '', '', 'template', 'a:2:{s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '0', '0', '0', '0', '0', '0', '0', '13', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('134', '7', 'allow_comment', '允许评论', '', '', '0', '0', '', '', 'box', 'a:9:{s:7:\"options\";s:33:\"允许评论|1\r\n不允许评论|0\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:7:\"tinyint\";s:9:\"minnumber\";s:1:\"1\";s:5:\"width\";s:2:\"88\";s:4:\"size\";s:0:\"\";s:12:\"defaultvalue\";s:1:\"1\";s:10:\"outputtype\";s:1:\"1\";s:10:\"filtertype\";s:1:\"0\";}', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '14', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('135', '7', 'pages', '分页方式', '', '', '0', '0', '', '', 'pages', '', '', '-99', '-99', '0', '0', '0', '1', '0', '0', '0', '0', '9', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('136', '7', 'inputtime', '真实发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '1', '1', '0', '0', '0', '0', '0', '1', '11', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('137', '7', 'posid', '推荐位', '', '', '0', '0', '', '', 'posid', 'a:4:{s:5:\"width\";s:3:\"125\";s:12:\"defaultvalue\";s:0:\"\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '1', '0', '1', '0', '0', '0', '1', '11', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('138', '7', 'url', 'URL', '', '', '0', '100', '', '', 'text', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '1', '12', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('139', '7', 'listorder', '排序', '', '', '0', '6', '', '', 'number', '', '', '', '', '1', '1', '0', '1', '0', '0', '0', '0', '18', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('140', '7', 'relation', '相关文章', '', '', '0', '255', '', '', 'omnipotent', 'a:4:{s:8:\"formtext\";s:471:\"<input type=\"hidden\" name=\"info[relation]\" id=\"relation\" value=\"{FIELD_VALUE}\" style=\"50\" >\r\n<ul class=\"list-dot\" id=\"relation_text\">\r\n</ul>\r\n<input type=\"button\" value=\"添加相关\" onClick=\"omnipotent(\'selectid\',GV.DIMAUB+\'index.php?a=public_relationlist&m=Content&g=Contents&modelid={MODELID}\',\'添加相关文章\',1)\" class=\"btn\">\r\n<span class=\"edit_content\">\r\n  <input type=\"button\" value=\"显示已有\" onClick=\"show_relation({MODELID},{ID})\" class=\"btn\">\r\n</span>\";s:9:\"fieldtype\";s:7:\"varchar\";s:12:\"backstagefun\";s:0:\"\";s:8:\"frontfun\";s:0:\"\";}', '', '', '', '0', '0', '0', '0', '0', '0', '1', '0', '8', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('141', '7', 'thumb', '缩略图', '', '', '0', '100', '', '', 'image', 'a:9:{s:4:\"size\";s:2:\"50\";s:12:\"defaultvalue\";s:0:\"\";s:9:\"show_type\";s:1:\"1\";s:14:\"upload_maxsize\";s:4:\"1024\";s:15:\"upload_allowext\";s:20:\"jpg|jpeg|gif|png|bmp\";s:9:\"watermark\";s:1:\"0\";s:13:\"isselectimage\";s:1:\"1\";s:12:\"images_width\";s:0:\"\";s:13:\"images_height\";s:0:\"\";}', '', '', '', '0', '1', '0', '0', '0', '1', '0', '1', '7', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('142', '7', 'catid', '栏目', '', '', '1', '6', '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'a:1:{s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '1', '0', '1', '1', '1', '0', '0', '1', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('143', '7', 'typeid', '类别', '', '', '0', '0', '', '', 'typeid', 'a:2:{s:9:\"minnumber\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '', '', '1', '1', '0', '1', '1', '1', '0', '0', '2', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('144', '7', 'title', '标题', '', 'inputtitle', '1', '80', '', '请输入标题', 'title', '', '', '', '', '0', '1', '0', '1', '1', '1', '1', '1', '3', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('145', '7', 'keywords', '关键词', '多关键词之间用空格隔开', '', '0', '40', '', '', 'keyword', 'a:2:{s:4:\"size\";s:3:\"100\";s:12:\"defaultvalue\";s:0:\"\";}', '', '-99', '-99', '0', '1', '0', '1', '1', '1', '1', '0', '4', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('146', '7', 'tags', 'TAGS', '多关之间用空格或者“,”隔开', '', '0', '0', '', '', 'tags', 'a:4:{s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '0', '0', '0', '4', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('147', '7', 'description', '摘要', '', '', '0', '255', '', '', 'textarea', 'a:4:{s:5:\"width\";s:2:\"98\";s:6:\"height\";s:2:\"46\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"enablehtml\";s:1:\"0\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '1', '5', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('148', '7', 'updatetime', '发布时间', '', '', '0', '0', '', '', 'datetime', 'a:3:{s:9:\"fieldtype\";s:3:\"int\";s:6:\"format\";s:11:\"Y-m-d H:i:s\";s:11:\"defaulttype\";s:1:\"0\";}', '', '', '', '0', '1', '0', '0', '0', '0', '0', '0', '10', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('149', '7', 'content', '内容', '<style type=\"text/css\">.content_attr{ border:1px solid #CCC; padding:5px 8px; background:#FFC; margin-top:6px}</style><div class=\"content_attr\"><label><input name=\"add_introduce\" type=\"checkbox\"  value=\"1\" checked>是否截取内容</label><input type=\"text\" name=\"introcude_length\" value=\"200\" size=\"3\">字符至内容摘要\r\n<label><input type=\'checkbox\' name=\'auto_thumb\' value=\"1\" checked>是否获取内容第</label><input type=\"text\" name=\"auto_thumb_no\" value=\"1\" size=\"2\" class=\"\">张图片作为标题图片\r\n</div>', '', '1', '999999', '', '内容不能为空', 'editor', 'a:6:{s:7:\"toolbar\";s:4:\"full\";s:12:\"defaultvalue\";s:0:\"\";s:13:\"enablekeylink\";s:1:\"1\";s:10:\"replacenum\";s:1:\"2\";s:9:\"link_mode\";s:1:\"0\";s:15:\"enablesaveimage\";s:1:\"1\";}', '', '', '', '0', '0', '0', '1', '0', '1', '1', '0', '6', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('150', '3', 'website', '网址地址', '', '', '1', '0', '', '', 'text', 'a:7:{s:4:\"size\";s:3:\"300\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '0', '6', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('151', '5', 'sign', '签名', '', '', '1', '0', '', '', 'text', 'a:7:{s:4:\"size\";s:3:\"250\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '1', '0', '1', '0', '1', '1', '0', '9', '0', '0');
INSERT INTO `shuipfcms_model_field` VALUES ('192', '5', 'remind', '升级提醒', '', '', '0', '0', '', '', 'textarea', 'a:8:{s:5:\"width\";s:3:\"100\";s:6:\"height\";s:2:\"46\";s:12:\"defaultvalue\";s:0:\"\";s:10:\"enablehtml\";s:1:\"1\";s:12:\"backstagefun\";s:0:\"\";s:17:\"backstagefun_type\";s:1:\"1\";s:8:\"frontfun\";s:0:\"\";s:13:\"frontfun_type\";s:1:\"1\";}', '', '', '', '0', '0', '0', '1', '0', '1', '1', '0', '15', '0', '0');

-- ----------------------------
-- Table structure for shuipfcms_module
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_module`;
CREATE TABLE `shuipfcms_module` (
  `module` varchar(15) NOT NULL COMMENT '模块',
  `modulename` varchar(20) NOT NULL COMMENT '模块名称',
  `iscore` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '内置模块',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否可用',
  `version` varchar(50) NOT NULL DEFAULT '' COMMENT '版本',
  `setting` mediumtext NOT NULL COMMENT '设置信息',
  `installtime` int(10) NOT NULL COMMENT '安装时间',
  `updatetime` int(10) NOT NULL COMMENT '更新时间',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`module`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='已安装模块列表';

-- ----------------------------
-- Records of shuipfcms_module
-- ----------------------------
INSERT INTO `shuipfcms_module` VALUES ('Content', '内容模块', '0', '1', '1.0.0', '', '1400315541', '1400315541', '0');

-- ----------------------------
-- Table structure for shuipfcms_operationlog
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_operationlog`;
CREATE TABLE `shuipfcms_operationlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `uid` smallint(6) NOT NULL COMMENT '操作帐号ID',
  `time` int(10) NOT NULL COMMENT '操作时间',
  `ip` char(20) NOT NULL DEFAULT '' COMMENT 'IP',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态,0错误提示，1为正确提示',
  `info` text NOT NULL COMMENT '其他说明',
  `get` varchar(255) NOT NULL COMMENT 'get数据',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `username` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台操作日志表';

-- ----------------------------
-- Records of shuipfcms_operationlog
-- ----------------------------

-- ----------------------------
-- Table structure for shuipfcms_role
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_role`;
CREATE TABLE `shuipfcms_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '角色名称',
  `parentid` smallint(6) NOT NULL COMMENT '父角色ID',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL COMMENT '更新时间',
  `listorder` int(3) NOT NULL DEFAULT '0' COMMENT '排序字段',
  PRIMARY KEY (`id`),
  KEY `parentId` (`parentid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='角色信息列表';

-- ----------------------------
-- Records of shuipfcms_role
-- ----------------------------
INSERT INTO `shuipfcms_role` VALUES ('1', '超级管理员', '0', '1', '拥有网站最高管理员权限！', '1329633709', '1329633709', '0');
INSERT INTO `shuipfcms_role` VALUES ('2', '站点管理员', '1', '1', '站点管理员', '1329633722', '1399780945', '0');
INSERT INTO `shuipfcms_role` VALUES ('3', '发布人员', '2', '1', '发布人员', '1329633733', '1399798954', '0');

-- ----------------------------
-- Table structure for shuipfcms_urlrule
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_urlrule`;
CREATE TABLE `shuipfcms_urlrule` (
  `urlruleid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id',
  `module` varchar(15) NOT NULL COMMENT '所属模块',
  `file` varchar(20) NOT NULL COMMENT '所属文件',
  `ishtml` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '生成静态规则 1 静态',
  `urlrule` varchar(255) NOT NULL COMMENT 'url规则',
  `example` varchar(255) NOT NULL COMMENT '示例',
  PRIMARY KEY (`urlruleid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shuipfcms_urlrule
-- ----------------------------
INSERT INTO `shuipfcms_urlrule` VALUES ('1', 'content', 'category', '0', 'index.php?a=lists&catid={$catid}|index.php?a=lists&catid={$catid}&page={$page}', '动态：index.php?a=lists&catid=1&page=1');
INSERT INTO `shuipfcms_urlrule` VALUES ('2', 'content', 'category', '1', '{$categorydir}{$catdir}/index.shtml|{$categorydir}{$catdir}/index_{$page}.shtml', '静态：news/china/1000.shtml');
INSERT INTO `shuipfcms_urlrule` VALUES ('3', 'content', 'show', '1', '{$year}/{$catdir}_{$month}/{$id}.shtml|{$year}/{$catdir}_{$month}/{$id}_{$page}.shtml', '静态：2010/catdir_07/1_2.shtml');
INSERT INTO `shuipfcms_urlrule` VALUES ('4', 'content', 'show', '0', 'index.php?a=shows&catid={$catid}&id={$id}|index.php?a=shows&catid={$catid}&id={$id}&page={$page}', '动态：index.php?m=Index&a=shows&catid=1&id=1');
INSERT INTO `shuipfcms_urlrule` VALUES ('5', 'content', 'category', '1', 'news/{$catid}.shtml|news/{$catid}-{$page}.shtml', '静态：news/1.shtml');
INSERT INTO `shuipfcms_urlrule` VALUES ('6', 'content', 'category', '0', 'list-{$catid}.html|list-{$catid}-{$page}.html', '伪静态：list-1-1.html');
INSERT INTO `shuipfcms_urlrule` VALUES ('7', 'tags', 'tags', '0', 'index.php?g=Tags&tagid={$tagid}|index.php?g=Tags&tagid={$tagid}&page={$page}', '动态：index.php?g=Tags&tagid=1');
INSERT INTO `shuipfcms_urlrule` VALUES ('8', 'tags', 'tags', '0', 'index.php?g=Tags&tag={$tag}|/index.php?g=Tags&tag={$tag}&page={$page}', '动态：index.php?g=Tags&tag=标签');
INSERT INTO `shuipfcms_urlrule` VALUES ('9', 'tags', 'tags', '0', 'tag-{$tag}.html|tag-{$tag}-{$page}.html', '伪静态：tag-标签.html');
INSERT INTO `shuipfcms_urlrule` VALUES ('10', 'tags', 'tags', '0', 'tag-{$tagid}.html|tag-{$tagid}-{$page}.html', '伪静态：tag-1.html');
INSERT INTO `shuipfcms_urlrule` VALUES ('11', 'content', 'index', '1', 'index.html|index_{$page}.html', '静态：index_2.html');
INSERT INTO `shuipfcms_urlrule` VALUES ('12', 'content', 'index', '0', 'index.html|index_{$page}.html', '伪静态：index_2.html');
INSERT INTO `shuipfcms_urlrule` VALUES ('13', 'content', 'index', '0', 'index.php|index.php?page={$page}', '动态：index.php?page=2');
INSERT INTO `shuipfcms_urlrule` VALUES ('14', 'content', 'category', '1', 'download.shtml|download_{$page}.shtml', '静态：download.shtml');
INSERT INTO `shuipfcms_urlrule` VALUES ('15', 'content', 'show', '1', '{$categorydir}{$id}.shtml|{$categorydir}{$id}_{$page}.shtml', '静态：/父栏目/1.shtml');
INSERT INTO `shuipfcms_urlrule` VALUES ('16', 'content', 'show', '1', '{$catdir}/{$id}.shtml|{$catdir}/{$id}_{$page}.shtml', '示例：/栏目/1.html');

-- ----------------------------
-- Table structure for shuipfcms_user
-- ----------------------------
DROP TABLE IF EXISTS `shuipfcms_user`;
CREATE TABLE `shuipfcms_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL COMMENT '用户名',
  `nickname` varchar(50) NOT NULL COMMENT '昵称/姓名',
  `password` char(32) NOT NULL COMMENT '密码',
  `bind_account` varchar(50) NOT NULL COMMENT '绑定帐户',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `last_login_ip` varchar(40) NOT NULL COMMENT '上次登录IP',
  `verify` varchar(32) NOT NULL COMMENT '证验码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `role_id` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '对应角色ID',
  `info` text NOT NULL COMMENT '信息',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台用户表';
