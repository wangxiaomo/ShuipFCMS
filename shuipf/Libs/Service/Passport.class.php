<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 前台会员通行证
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Libs\Service;

class Passport extends \Libs\System\Service {

    //存储用户uid的Key
    const userUidKey = 'spf_userid';

    //参数
    protected $options = array();
    //网站配置参数
    protected $config = array();
    //错误信息
    protected $error = null;
    //当前登录会员详细信息
    static protected $userInfo = array();

    /**
     * 连接会员系统
     * @param type $name 服务名
     * @param type $options 参数
     * @return \Libs\Service\class
     */
    public static function connect($name = '', $options = array()) {
        if (false == isModuleInstall('Member')) {
            return new Passport($options);
        }
        if (empty($options['type'])) {
            //网站配置
            $config = cache("Member_Config");
            if ($config['interface']) {
                $type = $config['interface'];
            } else {
                $type = 'Local';
            }
        } else {
            $type = $options['type'];
        }
        //附件存储方案
        $class = strpos($type, '\\') ? $type : 'Libs\\Driver\\Passport\\' . ucwords(strtolower($type));
        if (class_exists($class)) {
            $connect = new $class($options);
        } else {
            E("通行证驱动 {$class} 不存在！");
        }
        return $connect;
    }

    /**
     * 魔术方法
     * @param type $name
     * @return null
     */
    public function __get($name) {
        //从缓存中获取
        if (isset(self::$userInfo[$name])) {
            return self::$userInfo[$name];
        } else {
            $userInfo = $this->getInfo();
            if (!empty($userInfo)) {
                return $userInfo[$name];
            }
            return NULL;
        }
    }

    /**
     * 获取错误信息
     * @return type
     */
    public function getError() {
        return $this->error;
    }

    /**
     * 获取当前登录用户资料
     * @return array 
     */
    public function getInfo() {
        if (empty(self::$userInfo)) {
            self::$userInfo = $this->getLocalUser($this->getCookieUid());
        }
        return !empty(self::$userInfo) ? self::$userInfo : false;
    }

    /**
     * 获取cookie中记录的用户ID
     * @return type 成功返回用户ID，失败返回false
     */
    public function getCookieUid() {
        $userId = \Libs\Util\Encrypt::authcode(cookie(self::userUidKey), 'DECODE');
        return (int) $userId ? : false;
    }

    /**
     * 获取用户信息
     * @param type $identifier 用户/UID
     * @param type $password 明文密码，填写表示验证密码
     * @return array|boolean
     */
    public function getLocalUser($identifier, $password = null) {
        return array();
    }

    /**
     * 获取用户头像 
     * @param type $uid 用户ID
     * @param int $format 头像规格，默认参数90，支持 180,90,45,30
     * @param type $dbs 该参数为true时，表示使用查询数据库的方式，取得完整的头像地址。默认false
     * @return type 返回头像地址
     */
    public function getUserAvatar($uid, $format = 90, $dbs = false) {
        return false;
    }

    /**
     * 用户积分变更
     * @param type $uid 数字为用户ID，其他为用户名
     * @param type $integral 正数增加积分，负数扣除积分
     * @return int 成功返回当前积分数，失败返回false，-1 表示当前积分不够扣除
     */
    public function userIntegration($uid, $integral) {
        return true;
    }

    /**
     * 检验用户是否已经登陆
     */
    public function isLogged() {
        //获取cookie中的用户id
        $uid = $this->getCookieUid();
        if (empty($uid) || $uid < 1) {
            return false;
        }
        return $uid;
    }

    /**
     * 注册用户的登陆状态 (即: 注册cookie + 注册session + 记录登陆信息)
     * @param array $user 用户相信信息 uid , username
     * @param type $is_remeber_me 有效期
     * @return type 成功返回布尔值
     */
    public function registerLogin(array $user, $is_remeber_me = 604800) {
        $key = \Libs\Util\Encrypt::authcode((int) $user['userid'], '');
        cookie(self::userUidKey, $key, (int) $is_remeber_me);
        return true;
    }

    /**
     * 注销登陆
     * @return boolean
     */
    public function logoutLocal() {
        // 注销cookie
        cookie(self::userUidKey, null);
        return true;
    }

    /**
     * 会员登录
     * @param type $identifier 用户/UID
     * @param type $password 明文密码，填写表示验证密码
     * @param type $is_remember_me cookie有效期
     * @return boolean
     */
    public function loginLocal($identifier, $password = null, $is_remember_me = 3600) {
        return false;
    }

    /**
     * 记录登陆信息
     * @param type $uid 用户ID
     */
    public function recordLogin($uid) {
        return true;
    }

    /**
     * 用户注册
     * @param type $username 用户名
     * @param type $password 明文密码
     * @param type $email
     * @param type $_data 附加数据
     * @return int 大于 0:返回用户 ID，表示用户注册成功
     *                              -1:用户名不合法
     *                              -2:包含不允许注册的词语
     *                              -3:用户名已经存在
     *                              -4:Email 格式有误
     *                              -5:Email 不允许注册
     *                              -6:该 Email 已经被注册
     */
    public function userRegister($username, $password, $email, $_data = array()) {
        return false;
    }

    /**
     * 更新用户基本资料
     * @param type $username 用户名
     * @param type $oldpw 旧密码
     * @param type $newpw 新密码，如不修改为空
     * @param type $email Email，如不修改为空
     * @param type $ignoreoldpw 是否忽略旧密码
     * @param type $data 其他信息
     * @return boolean
     */
    public function userEdit($username, $oldpw, $newpw = '', $email = '', $ignoreoldpw = 0, $data = array()) {
        return false;
    }

    /**
     *  删除用户
     * @param type $uid 用户名
     * @return int 1:成功
     *                      0:失败
     */
    public function userDelete($uid) {
        return true;
    }

    /**
     * 删除用户头像
     * @param type $uid 用户名
     * @return int 1:成功
     *                      0:失败
     */
    public function userDeleteAvatar($uid) {
        return false;
    }

    /**
     * 检查 Email 地址
     * @param type $email 邮箱地址
     * @return int 1:成功
     *                      -4:Email 格式有误
     *                      -5:Email 不允许注册
     *                      -6:该 Email 已经被注册
     */
    public function userCheckeMail($email) {
        return false;
    }

    /**
     * 检查用户名
     * @param type $username 用户名
     * @return int 1:成功
     *                      -1:用户名不合法
     *                      -2:包含要允许注册的词语
     *                      -3:用户名已经存在
     */
    public function userCheckUsername($username) {
        return false;
    }

    /**
     * 修改头像
     * @param type $uid 用户 ID
     * @param type $type 头像类型
     *                                       real:真实头像
     *                                       virtual:(默认值) 虚拟头像
     * @param type $returnhtml 是否返回 HTML 代码
     *                                                     1:(默认值) 是，返回设置头像的 HTML 代码
     *                                                     0:否，返回设置头像的 Flash 调用数组
     * @return string:返回设置头像的 HTML 代码
     *                array:返回设置头像的 Flash 调用数组
     */
    public function userAvatarEdit($uid, $type = 'virtual', $returnhtml = 1) {
        return false;
    }

}
