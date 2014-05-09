<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 后台用户服务
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Service;

class User {

    //存储用户uid的Key
    const userUidKey = 'spf_userid';
    //超级管理员角色id
    const administratorRoleId = 1;

    /**
     * 连接后台用户服务
     * @staticvar \Admin\Service\Cache $systemHandier
     * @return \Admin\Service\Cache
     */
    static public function getInstance() {
        static $handier = NULL;
        if (empty($handier)) {
            $handier = new User();
        }
        return $handier;
    }

    /**
     * 魔术方法
     * @param type $name
     * @return null
     */
    public function __get($name) {
        if (isset(\Common\Controller\AdminBase::$userInfo[$name])) {
            return \Common\Controller\AdminBase::$userInfo[$name];
        } else {
            return null;
        }
    }

    /**
     * 获取当前登录用户资料
     * @return array 
     */
    public function getInfo() {
        return \Common\Controller\AdminBase::$userInfo;
    }

    /**
     * 检验用户是否已经登陆
     * @return boolean 失败返回false，成功返回当前登陆用户基本信息
     */
    public function isLogin() {
        $userId = \Libs\Util\Encrypt::authcode(session(self::userUidKey), 'DECODE');
        if (empty($userId)) {
            return false;
        }
        return (int) $userId;
    }

    //登录后台
    public function login($identifier, $password) {
        if (empty($identifier) || empty($password)) {
            return false;
        }
        //验证
        $userInfo = $this->getUserInfo($identifier, $password);
        if (false == $userInfo) {
            return false;
        }
        $this->registerLogin($userInfo);
        return true;
    }

    /**
     * 检查当前用户是否超级管理员
     * @param type $db 是否查库确认
     * @return boolean
     */
    public function isAdministrator($authId = null) {
        $authId = $authId ? $authId : $this->isLogin();
        if (empty($authId)) {
            return false;
        }
        $userInfo = $this->getInfo();
        if (empty($userInfo)) {
            $userInfo = $this->getUserInfo((int) $authId);
        }
        if ($userInfo['role_id'] == self::administratorRoleId) {
            return true;
        }
        return false;
    }

    /**
     * 注销登录状态
     * @return boolean
     */
    public function logout() {
        session('[destroy]');
        return true;
    }

    /**
     * 注册用户登录状态
     * @param array $userInfo 用户信息
     */
    protected function registerLogin(array $userInfo) {
        //写入session
        session(self::userUidKey, \Libs\Util\Encrypt::authcode((int) $userInfo['id'], ''));
        //更新状态
        D('Admin/User')->loginStatus((int) $userInfo['id']);
        //注册权限
        \Libs\System\RBAC::saveAccessList((int) $userInfo['id']);
    }

    /**
     * 获取用户信息
     * @param type $identifier 用户名或者用户ID
     * @return boolean|array
     */
    public function getUserInfo($identifier, $password = NULL) {
        if (empty($identifier)) {
            return false;
        }
        return D('Admin/User')->getUserInfo($identifier, $password);
    }

}
