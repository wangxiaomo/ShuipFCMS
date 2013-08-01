<?php

/**
 * Some rights reserved：黑色空白
 * Contact email:omyweb@qq.com
 */
define("DatabaseBackDir", RUNTIME_PATH . "/Data/"); //系统备份数据库文件存放目录
return array(
    //"DatabaseBackDir" => APP_PATH."Modules/".GROUP_NAME."/Data/",//项目缓存路径
    /*
     * 系统备份数据库时每个sql分卷大小，单位字节
     */
    'sqlFileSize' => 5242880, //该值不可太大，否则会导致内存溢出备份、恢复失败，合理大小在512K~10M间，建议5M一卷
        //10M=1024*1024*10=10485760
        //5M=5*1024*1024=5242880
);