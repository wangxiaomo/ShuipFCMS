<?php

/**
 * 模块安装，菜单/权限配置
 * Some rights reserved：黑色空白
 * Contact email:omyweb@qq.com
 */
defined('INSTALL') or exit('Access Denied');
//添加一个菜单到后台“模块->模块列表”ID等于常量 MENUID
$parentid = M("Menu")->add(array(
    //父ID
    "parentid" => MENUID,
    //模块目录名称，也是项目名称
    "app" => "Bakdata",
    //文件名称，比如 IndexAction.class.php就填写 Index
    "model" => "Bakdata",
    //方法名称
    "action" => "index",
    //附加参数 例如：a=12&id=777
    "data" => "",
    //类型，后台是1。
    "type" => 1,
    //状态，1是显示，2是不显示
    "status" => 1,
    //名称
    "name" => "数据备份",
    //备注
    "remark" => "数据备份模块",
    //排序
    "listorder" => 1
        ));
//添加其他需要加入权限认证的方法，后台进行权限认证时不通过。
//提示：比如一些删除，修改这类方法需要配合参数使用，该类不适合直接显示出来，可以把status设置为0
//招生项目
M("Menu")->add(array("parentid" => $parentid, "app" => "Bakdata", "model" => "Bakdata", "action" => "repair", "data" => "", "type" => 1, "status" => 1, "name" => "修复与优化", "remark" => "", "listorder" => 2));
M("Menu")->add(array("parentid" => $parentid, "app" => "Bakdata", "model" => "Bakdata", "action" => "restore", "data" => "", "type" => 1, "status" => 1, "name" => "备份文件管理", "remark" => "", "listorder" => 3));
M("Menu")->add(array("parentid" => $parentid, "app" => "Bakdata", "model" => "Bakdata", "action" => "zipList", "data" => "", "type" => 1, "status" => 1, "name" => "数据zip管理", "remark" => "", "listorder" => 4));

M("Menu")->add(array("parentid" => $parentid, "app" => "Bakdata", "model" => "Bakdata", "action" => "backup", "data" => "", "type" => 1, "status" => 0, "name" => "备份数据库", "remark" => "", "listorder" => 0));
M("Menu")->add(array("parentid" => $parentid, "app" => "Bakdata", "model" => "Bakdata", "action" => "optimize", "data" => "", "type" => 1, "status" => 0, "name" => "数据优化", "remark" => "", "listorder" => 0));
M("Menu")->add(array("parentid" => $parentid, "app" => "Bakdata", "model" => "Bakdata", "action" => "downFile", "data" => "", "type" => 1, "status" => 0, "name" => "下载数据库", "remark" => "", "listorder" => 0));
M("Menu")->add(array("parentid" => $parentid, "app" => "Bakdata", "model" => "Bakdata", "action" => "delSqlFiles", "data" => "", "type" => 1, "status" => 0, "name" => "删除文件", "remark" => "", "listorder" => 0));
M("Menu")->add(array("parentid" => $parentid, "app" => "Bakdata", "model" => "Bakdata", "action" => "restoreData", "data" => "", "type" => 1, "status" => 0, "name" => "数据导入", "remark" => "", "listorder" => 0));
M("Menu")->add(array("parentid" => $parentid, "app" => "Bakdata", "model" => "Bakdata", "action" => "zipSql", "data" => "", "type" => 1, "status" => 0, "name" => "压缩SQL为ZIP", "remark" => "", "listorder" => 0));
M("Menu")->add(array("parentid" => $parentid, "app" => "Bakdata", "model" => "Bakdata", "action" => "sendSql", "data" => "", "type" => 1, "status" => 0, "name" => "发送Sql文件", "remark" => "", "listorder" => 0));
M("Menu")->add(array("parentid" => $parentid, "app" => "Bakdata", "model" => "Bakdata", "action" => "unzipSqlfile", "data" => "", "type" => 1, "status" => 0, "name" => "解压文件文件", "remark" => "", "listorder" => 0));
?>