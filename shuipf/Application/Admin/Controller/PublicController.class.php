<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 后台模块公共方法
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class PublicController extends AdminBase {

    //后台登陆界面
    public function login() {
        //如果已经登录
        if (User::getInstance()->isLogin()) {
            $this->redirect(U('Index/index'));
        }
        $this->display();
    }

    //后台登陆验证
    public function tologin() {
        //记录登陆失败者IP
        $ip = get_client_ip();
        $username = I("post.username", "", "trim");
        $password = I("post.password", "", "trim");
        $code = I("post.code", "", "trim");
        if (empty($username) || empty($password)) {
            $this->error("用户名或者密码不能为空，请重新输入！", U("Public/login"));
        }
        if (empty($code)) {
            $this->error("请输入验证码！", U("Public/login"));
        }
        //验证码开始验证
        if (!$this->verify($code)) {
            $this->error("验证码错误，请重新输入！", U("Public/login"));
        }
        if (User::getInstance()->login($username, $password)) {
            $forward = cookie("forward");
            if (!$forward) {
                $forward = U("Admin/Index/index");
            } else {
                cookie("forward", NULL);
            }
            //增加登陆成功行为调用
            $admin_public_tologin = array(
                'username' => $username,
                'ip' => $ip,
            );
            tag('admin_public_tologin', $admin_public_tologin);
            $this->redirect('Index/index');
        } else {
            $this->error("用户名或者密码错误，登陆失败！", U("Public/login"));
        }
    }

    //退出登陆
    public function logout() {
        if (User::getInstance()->logout()) {
            //手动登出时，清空forward
            cookie("forward", NULL);
            $this->success('注销成功！', U("Admin/Public/login"));
        }
    }
}
