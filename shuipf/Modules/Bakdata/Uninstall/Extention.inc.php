<?php

/**
 * 模块安装，菜单/权限配置
 */
defined('UNINSTALL') or exit('Access Denied');
//删除菜单/权限数据
M("Menu")->where(array("app" => "Bakdata"))->delete();
M("Access")->where(array("g" => "Bakdata"))->delete();
?>