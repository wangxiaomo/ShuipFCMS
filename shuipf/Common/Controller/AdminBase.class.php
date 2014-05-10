<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 后台Controller
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Common\Controller;

use Admin\Service\User;

//定义是后台
define('IN_ADMIN', true);

class AdminBase extends ShuipFCMS {

    //当前登录用户uid
    public static $uid = 0;
    //当前登录用户会员名称
    public static $username = NULL;
    //当前登录会员详细信息
    public static $userInfo = array();

    //初始化
    protected function _initialize() {
        parent::_initialize();
        //验证登录
        $this->competence();
    }

    /**
     * 验证登录
     * @return boolean
     */
    private function competence() {
        //检查是否登录
        self::$uid = (int) User::getInstance()->isLogin();
        if (empty(self::$uid)) {
            return false;
        }
        //获取当前登录用户信息
        self::$userInfo = User::getInstance()->getUserInfo(self::$uid);
        if (empty(self::$userInfo)) {
            User::getInstance()->logout();
            return false;
        }
        //是否锁定
        if (!self::$userInfo['status']) {
            User::getInstance()->logout();
            $this->error('您的帐号已经被锁定！', U('Public/login'));
            return false;
        }
        self::$username = self::$userInfo['username'];
        return self::$userInfo;
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $message 错误信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
    public function error($message = '', $jumpUrl = '', $ajax = false) {
        parent::error($message, $jumpUrl, $ajax);
    }

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $message 提示信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
    public function success($message = '', $jumpUrl = '', $ajax = false) {
        parent::success($message, $jumpUrl, $ajax);
    }

    /**
     * 分页输出
     * @param type $total 信息总数
     * @param type $size 每页数量
     * @param type $number 当前分页号（页码）
     * @param type $config 配置，会覆盖默认设置
     * @return type
     */
    protected function page($total, $size = 0, $number = 0, $config = array()) {
        $Page = parent::page($total, $size, $number, $config);
        $Page->SetPager('Admin', '<span class="all">共有{recordcount}条信息</span>{first}{prev}{liststart}{list}{listend}{next}{last}');
        return $Page;
    }

}
