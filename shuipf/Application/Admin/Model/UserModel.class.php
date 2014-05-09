<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 后台用户模型
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Model;

use Common\Model\Model;

class UserModel extends Model {

    //array(验证字段,验证规则,错误提示,[验证条件,附加规则,验证时间])
    protected $_validate = array(
        array('username', 'require', '用户名不能为空！'),
        array('nickname', 'require', '真实姓名不能为空！'),
        array('role_id', 'require', '帐号所属角色不能为空！', 0, 'regex', 1),
        array('password', 'require', '密码不能为空！', 0, 'regex', 1),
        array('email', 'email', '邮箱地址有误！'),
        array('username', '', '帐号名称已经存在！', 0, 'unique', 1),
        array('pwdconfirm', 'password', '两次输入的密码不一样！', 0, 'confirm'),
        array('status', array(0, 1), '状态错误，状态只能是1或者0！', 2, 'in'),
    );
    //array(填充字段,填充内容,[填充条件,附加规则])
    protected $_auto = array(
        array('create_time', 'time', 1, 'function'),
        array('update_time', 'time', 3, 'function'),
    );

    /**
     * 获取用户信息
     * @param type $identifier 用户名或者用户ID
     * @return boolean|array
     */
    public function getUserInfo($identifier, $password = NULL) {
        if (empty($identifier)) {
            return false;
        }
        $map = array();
        //判断是uid还是用户名
        if (is_int($identifier)) {
            $map['id'] = $identifier;
        } else {
            $map['username'] = $identifier;
        }
        $userInfo = $this->where($map)->find();
        if (empty($userInfo)) {
            return false;
        }
        //密码验证
        if (!empty($password) && $this->hashPassword($password, $userInfo['verify']) != $userInfo['password']) {
            return false;
        }
        return $userInfo;
    }

    /**
     * 更新登录状态信息
     * @param type $userId
     * @return type
     */
    public function loginStatus($userId) {
        $this->find((int) $userId);
        $this->last_login_time = time();
        $this->last_login_ip = get_client_ip();
        return $this->save();
    }

    /**
     * 对明文密码，进行加密，返回加密后的密文密码
     * @param string $password 明文密码
     * @param string $verify 认证码
     * @return string 密文密码
     */
    public function hashPassword($password, $verify = "") {
        return md5($password . md5($verify));
    }

}
