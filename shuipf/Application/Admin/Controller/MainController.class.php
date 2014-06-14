<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 后台框架首页
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Common\Controller\AdminBase;

class MainController extends AdminBase {

    public function index() {
        $license = S('server_license');
        if (empty($license)) {
            $license = $this->Cloud->data(array('domain' => $_SERVER['SERVER_NAME']))->act('get.license');
            if (empty($license)) {
                $license = array('name' => '非授权用户',);
            } else {
                S('server_license', $license, 3600);
            }
        }
        $latestversion = S('server_latestversion');
        if (empty($latestversion)) {
            $latestversion = $this->Cloud->act('get.latestversion');
            S('server_latestversion', $latestversion, 3600);
        }
        $notice = S('server_notice');
        if (empty($notice)) {
            $notice = $this->Cloud->act('get.notice');
            S('server_notice', $notice, 3600);
        }
        if (empty($_COOKIE['notice_' . $notice['id']])) {
            $this->assign('notice', $notice);
        }
        //服务器信息
        $info = array(
            '操作系统' => PHP_OS,
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            'MYSQL版本' => mysql_get_server_info(),
            '产品名称' => '<font color="#FF0000">' . SHUIPF_APPNAME . '</font>' . "&nbsp;&nbsp;&nbsp; [<a href='http://www.shuipfcms.com' target='_blank'>访问官网</a>]",
            '用户类型' => '<font color="#FF0000">' . $license['name'] . '</font>',
            '产品版本' => '<font color="#FF0000">' . SHUIPF_VERSION . '</font>，最新版本：' . $latestversion['version']? : '获取失败',
            '产品流水号' => '<font color="#FF0000">' . SHUIPF_BUILD . '</font>，最新流水号：' . $latestversion['build']? : '获取失败',
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . "秒",
            '剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        );

        $this->assign('server_info', $info);
        $this->display();
    }

}
