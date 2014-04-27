<?php

// +----------------------------------------------------------------------
// | ShuipFCMS
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.co, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------
// 检测PHP环境
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    die('require PHP > 5.3.0 !');
}
//当前目录路径
define('SITE_PATH', getcwd() . '/');
//项目路径
define('PROJECT_PATH', SITE_PATH . 'shuipf/');
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', True);
//模式
define('APP_MODE', 'shuipf');
//应用公共配置目录
define('CONF_PATH', PROJECT_PATH . 'Conf/');
// 应用公共目录
define('COMMON_PATH', PROJECT_PATH . 'Common/');
//应用语言配置
define('LANG_PATH', PROJECT_PATH . 'Lang/');
// 定义应用目录
define('APP_PATH', PROJECT_PATH . 'Modules/');
//应用静态目录
define('HTML_PATH', PROJECT_PATH . 'Html/');
//应用运行缓存目录
define("RUNTIME_PATH", SITE_PATH . "#runtime/");
// 引入ThinkPHP入口文件
require PROJECT_PATH . 'Core/ThinkPHP.php';
