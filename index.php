<?php

/**
 * 项目入口文件
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
//开启调试模式
define("APP_DEBUG", true);
define('SITE_PATH', getcwd());
define('APP_NAME', 'Shuipf');
define('APP_PATH', SITE_PATH . '/shuipf/');
define('TEMPLATE_PATH', APP_PATH . 'Template/');
define('CONF_PATH', APP_PATH . 'Conf/');

$alias = include CONF_PATH . 'site.php';
$SITE_MAPS = $alias['SITE_MAPS'];
$request_domain = $_SERVER['SERVER_NAME'];
if(isset($SITE_MAPS) && isset($SITE_MAPS[$request_domain])){
    define('RUNTIME_PATH', SITE_PATH . '\/#runtime/' . $SITE_MAPS[$request_domain]['RUNTIME_PATH'] . '/');
    define('SITE_CONFIG', serialize($SITE_MAPS[$request_domain]));
}else{
    define('RUNTIME_PATH', SITE_PATH . '\/#runtime/');
}

//大小写忽略处理
foreach (array("g", "m") as $v) {
    if (isset($_GET[$v])) {
        $_GET[$v] = ucwords($_GET[$v]);
    }
}
if (!file_exists(APP_PATH . 'Conf/dataconfig.php')) {
    header("Location: install/");
    exit;
}
//载入框架核心文件
require APP_PATH . 'Core/ThinkPHP.php';
