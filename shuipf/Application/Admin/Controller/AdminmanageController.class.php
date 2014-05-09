<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 我的面板
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class AdminmanageController extends AdminBase {

    //修改当前登陆状态下的用户个人信息
    public function myinfo() {
        if (IS_POST) {
            $data = array(
                'id' => User::getInstance()->id,
                'nickname' => I('nickname'),
                'email' => I('email'),
                'remark' => I('remark')
            );
            if (D("Admin/User")->create($data)) {
                if (D("Admin/User")->where(array('id' => User::getInstance()->id))->save() !== false) {
                    $this->success("资料修改成功！", U("Adminmanage/myinfo"));
                } else {
                    $this->error("更新失败！");
                }
            } else {
                $this->error(D("Admin/User")->getError());
            }
        } else {
            $this->assign("data", User::getInstance()->getInfo());
            $this->display();
        }
    }

    //后台登陆状态下修改当前登陆人密码
    public function chanpass() {
        $pass = I("post.new_password");
        $username = AppframeAction::$Cache['User']['username'];
        $userid = AppframeAction::$Cache['uid'];
        if (IS_POST) {
            if (I("post.password") == "") {
                $this->error("请输入旧密码！");
            }
            //检验原密码是否正确
            $user = service("PassportAdmin")->getLocalAdminUser($username, I("post.password", "", "trim"));
            if ($user == false) {
                $this->error("旧密码输入错误！");
            }
            if ($pass != I("post.new_pwdconfirm")) {
                $this->error("两次密码不相同！");
            }
            $up = D("User")->ChangePassword($userid, $pass);
            if ($up) {
                $this->assign("jumpUrl", U("Admin/Public/login"));
                //退出登陆
                service("PassportAdmin")->logoutLocalAdmin();
                $this->success("密码已经更新，请从新登陆！", U("Admin/Public/login"));
            } else {
                $this->error("密码更新失败！");
            }
        } else {
            $this->display();
        }
    }

    //验证密码是否正确
    public function public_verifypass() {
        $pass = I("get.password");
        $username = AppframeAction::$Cache['User']['username'];
        if (empty($pass)) {
            $this->error("密码不能为空！");
        }
        $user = service("PassportAdmin")->getLocalAdminUser($username, $pass);
        if ($user != false) {
            $this->success("密码正确！");
        } else {
            $this->error("密码错误！");
        }
    }

}
