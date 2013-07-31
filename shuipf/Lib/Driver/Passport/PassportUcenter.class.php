<?php

/**
 * 通行证服务，使用Ucenter的方式！
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class PassportUcenter extends PassportService {

    function __construct() {
        $this->config = F("Member_Config");
        if (!$this->config['uc_api'] || !$this->config['uc_key'] || !$this->config['uc_appid']) {
            throw_exception('请检查UC通行证配置是否完整！');
        }
        //连接 UCenter 的方式
        define("UC_CONNECT", $this->config['uc_connect']);
        //UCenter 数据库主机
        define("UC_DBHOST", $this->config['uc_dbhost']);
        //UCenter 数据库用户名
        define("UC_DBUSER", $this->config['uc_dbuser']);
        //UCenter 数据库密码.
        define("UC_DBPW", $this->config['uc_dbpw']);
        //UCenter 数据库名称
        define("UC_DBNAME", $this->config['uc_dbname']);
        //UCenter 数据库字符集
        define("UC_DBCHARSET", $this->config['uc_dbcharset']);
        //UCenter 数据库表前缀
        define("UC_DBTABLEPRE", $this->config['uc_dbtablepre']);
        //与 UCenter 的通信密钥, 要与 UCenter 保持一致
        define("UC_KEY", $this->config['uc_key']);
        //UCenter 服务端的 URL 地址
        define("UC_API", $this->config['uc_api']);
        //UCenter 的 IP
        define("UC_IP", $this->config['uc_ip']);
        //UCenter 的字符集
        define("UC_CHARSET", "utf-8");
        //当前应用的 ID
        define("UC_APPID", $this->config['uc_appid']);
        define('UC_PPP', '20');
        //载入uc接口
        return require_cache(SITE_PATH . DIRECTORY_SEPARATOR . "api" . DIRECTORY_SEPARATOR . "uc_client" . DIRECTORY_SEPARATOR . "client.php");
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
     * 用户注册
     * @param type $username 用户名
     * @param type $password 明文密码
     * @param type $email
     * @return int 大于 0:返回用户 ID，表示用户注册成功
     *                              -1:用户名不合法
     *                              -2:包含不允许注册的词语
     *                              -3:用户名已经存在
     *                              -4:Email 格式有误
     *                              -5:Email 不允许注册
     *                              -6:该 Email 已经被注册
     */
    public function user_register($username, $password, $email) {
        //检查用户名
        $ckname = $this->user_checkname($username);
        if ($ckname < 1) {
            return $ckname;
        }
        //检查邮箱
        $ckemail = $this->user_checkemail($email);
        if ($ckemail < 1) {
            return $ckemail;
        }
        $userid = uc_user_register($username, $password, $email);
        if ($userid > 0) {
            //保存到本地
            $Member = D("Member");
            $encrypt = genRandomString(6);
            $password = $Member->encryption(0, $password, $encrypt);
            $data = array(
                "userid" => $userid,
                "username" => $username,
                "password" => $password,
                "email" => $email,
                "encrypt" => $encrypt,
            );
            $Member->add($data);
            return $userid;
        }
        return 0;
    }

    /**
     * 更新用户基本资料
     * @param type $username 用户名
     * @param type $oldpw 旧密码
     * @param type $newpw 新密码，如不修改为空
     * @param type $email Email，如不修改为空
     * @param type $ignoreoldpw 是否忽略旧密码
     * @return int 1:更新成功
     *                      0:没有做任何修改
     *                     -1:旧密码不正确
     *                     -4:Email 格式有误
     *                     -5:Email 不允许注册
     *                     -6:该 Email 已经被注册
     *                     -7:没有做任何修改
     *                     -8:该用户受保护无权限更改
     */
    public function user_edit($username, $oldpw, $newpw, $email, $ignoreoldpw = 0) {
        $Member = D("Member");
        $data = array();
        $status = uc_user_edit($username, $oldpw, $newpw, $email, $ignoreoldpw);
        if ($status < 0) {
            return $status;
        }
        //验证旧密码是否正确
        if ($ignoreoldpw == 0) {
            $info = $Member->where(array("username" => $username))->find();
            $pas = $Member->encryption(0, $oldpw, $info['encrypt']);
            if ($pas != $info['password']) {
                return -1;
            }
        }

        if ($newpw) {
            //随机密码
            $encrypt = genRandomString(6);
            //新密码
            $password = $Member->encryption(0, $newpw, $encrypt);
            $data['password'] = $password;
            $data['encrypt'] = $encrypt;
        } else {
            unset($data['password']);
            unset($data['encrypt']);
        }
        if ($email) {
            $data['email'] = $email;
        } else {
            unset($data['email']);
        }
        if (false !== $Member->where(array("username" => $username))->save($data)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     *  删除用户
     * @param type $uid 用户名
     * @return int 1:成功
     *                      0:失败
     */
    public function user_delete($uid) {
        $modelid = M("Member")->where(array("userid" => $uid))->getField("modelid");
        if (!$modelid) {
            return 0;
        }
        $Model_Member = F("Model_Member");
        $tablename = ucwords($Model_Member[$modelid]['tablename']);
        if (!uc_user_delete($uid)) {
            return 0;
        }
        //删除本地用户数据开始
        if (M("Member")->where(array("userid" => $uid))->delete()) {
            M($tablename)->where(array("userid" => $uid))->delete();
            //删除connect
            M("Connect")->where(array("uid" => $uid))->delete();
            return 1;
        }
        return 0;
    }

    /**
     * 删除用户头像
     * @param type $uid 用户名
     * @return int 1:成功
     *                      0:失败
     */
    public function user_deleteavatar($uid) {
        return uc_user_deleteavatar($uid);
    }

    /**
     * 检查 Email 地址
     * @param type $email 邮箱地址
     * @return int 1:成功
     *                      -4:Email 格式有误
     *                      -5:Email 不允许注册
     *                      -6:该 Email 已经被注册
     */
    public function user_checkemail($email) {
        if (strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email)) {
            return uc_user_checkemail($email);
        }
        return -4;
    }

    /**
     * 检查用户名
     * @param type $username 用户名
     * @return int 1:成功
     *                      -1:用户名不合法
     *                      -2:包含要允许注册的词语
     *                      -3:用户名已经存在
     */
    public function user_checkname($username) {
        $guestexp = '\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8';
        if (!preg_match("/\s+|^c:\\con\\con|[%,\*\"\s\<\>\&]|$guestexp/is", $username)) {
            return uc_user_checkname($username);
        }
        return -1;
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
    public function user_avatar($uid, $type = 'virtual', $returnhtml = 1) {
        return uc_avatar($uid, $type, $returnhtml);
    }

    /**
     * 获取用户头像 
     * @param type $uid 用户ID
     * @param int $format 头像规格，默认参数90，支持 180,90,45,30
     * @param type $dbs 该参数为true时，表示使用查询数据库的方式，取得完整的头像地址。默认false
     * @return type 返回头像地址
     */
    public function user_getavatar($uid, $format = 90, $dbs = false) {
        //该参数为true时，表示使用查询数据库的方式，取得完整的头像地址。
        //比如QQ登陆，使用QQ头像，此时可以使用该种方式
        if ($dbs) {
            $user_getavatar_cache = S("user_getavatar_$uid");
            if ($user_getavatar_cache) {
                return $user_getavatar_cache;
            } else {
                $Member = M("Member");
                $userpic = $Member->where(array("userid" => $uid))->getField("userpic");
                if ($userpic) {
                    S("user_getavatar_$uid", $userpic, 3600);
                } else {
                    $userpic = CONFIG_SITEURL . "statics/images/member/nophoto.gif";
                }
                return $userpic;
            }
        }

        //头像规格
        $avatar = array(
            180 => "big",
            90 => "middle",
            45 => "small",
            30 => "small",
        );
        $format = in_array($format, $avatar) ? $format : 90;
        $picurl = $this->config['uc_api'] . "/avatar.php?uid=" . $uid . "&size=" . $avatar[$format];
        return $picurl;
    }

    /**
     * 前台会员信息
     * 根据提示符(username)和未加密的密码(密码为空时不参与验证)获取本地用户信息，前后台公用方法
     * @param type $identifier 为数字时，表示uid，其他为用户名
     * @param type $password 
     * @return 成功返回用户信息array()，否则返回布尔值false
     */
    public function getLocalUser($identifier, $password = null) {
        static $_getLocalUser = array();
        if (empty($identifier)) {
            return false;
        }
        $kye = md5($identifier);
        if (isset($_getLocalUser[$kye]) && !$password) {
            return $_getLocalUser[$kye];
        }
        $map = array();
        if (is_numeric($identifier) && gettype($identifier) == "integer") {
            $map['userid'] = $identifier;
            $isuid = 1;
        } else {
            $map['username'] = $identifier;
            $isuid = 0;
        }
        $UserMode = M('Member');
        $user = $UserMode->where($map)->find();
        if (!$user) {
            return false;
        }
        if ($password) {
            $user_login = uc_user_login($identifier, $password, $isuid);
            if ($user_login[0] < 1) {
                return false;
            }
        }
        $_getLocalUser[$kye] = $user;
        return $_getLocalUser[$kye];
    }

    /**
     * 使用本地账号登陆 (密码为null时不参与验证)
     * @param type $identifier 用户标识，用户uid或者用户名
     * @param type $password 用户密码，未加密，如果为空，不参与验证
     * @param type $is_remember_me cookie有效期
     * return 返回状态，大于 0:返回用户 ID，表示用户登录成功
     *                                     -1:用户不存在，或者被删除
     *                                     -2:密码错
     *                                     -3会员注册登陆状态失败
     */
    public function loginLocal($identifier, $password = null, $is_remember_me = 3600) {
        $db = D("Member");
        //检查登陆方式
        if (is_numeric($identifier) && gettype($identifier) == "integer") {
            $isuid = 1;
        } else {
            $isuid = 0;
        }
        $user = uc_user_login($identifier, $password, $isuid);
        if ($user[0] > 0) {
            $userid = $user[0];
            $username = $user[1];
            $ucpassword = $user[2];
            $ucemail = $user[3];
            $map = array();
            $map['userid'] = $userid;
            $map['username'] = $username;
            //取得本地相应用户
            $userinfo = $db->where($map)->find();
            //检查是否存在该用户信息
            if (!$userinfo) {
                //UC中有该用户，本地没有时，创建本地会员数据
                $data = array();
                $data['userid'] = $userid;
                $data['username'] = $username;
                $data['nickname'] = $username;
                $data['encrypt'] = genRandomString(6); //随机密码
                $data['password'] = $db->encryption(0, $ucpassword, $data['encrypt']);
                $data['email'] = $ucemail;
                $data['regdate'] = time();
                $data['regip'] = get_client_ip();
                $data['modelid'] = $this->config['defaultmodelid'];
                $data['point'] = $this->config['defualtpoint'];
                $data['amount'] = $this->config['defualtamount'];
                $data['groupid'] = $db->get_usergroup_bypoint($this->config['defualtpoint']);
                $data['checked'] = 1;
                $data['lastdate'] = time();
                $data['loginnum'] = 1;
                $data['lastip'] = get_client_ip();
                $db->add($data);
                $Model_Member = F("Model_Member");
                $tablename = $Model_Member[$data['modelid']]['tablename'];
                M(ucwords($tablename))->add(array("userid" => $userid));
                $userinfo = $data;
            } else {
                //更新密码
                $encrypt = genRandomString(6); //随机密码
                $pw = $db->encryption(0, $ucpassword, $encrypt);
                $db->where(array("userid" => $userid))->save(array("encrypt" => $encrypt, "password" => $pw, "lastdate" => time(), "lastip" => get_client_ip(), 'loginnum' => $userinfo['loginnum'] + 1));
                $userinfo['password'] = $pw;
                $userinfo['encrypt'] = $encrypt;
            }
            if ($this->registerLogin($userinfo, $is_remember_me)) {
                //记录登陆日志
                $this->recordLogin($user['userid']);
                //登陆成功
                return $userinfo['userid'];
            } else {
                //会员注册登陆状态失败
                return -3;
            }
        } else {
            //登陆失败
            return $user[0];
        }
    }

    /**
     * 注册用户的登陆状态 (即: 注册cookie + 注册session + 记录登陆信息)
     * @param array $user 用户相信信息 uid , username
     * @param type $is_remeber_me 有效期
     * @return type 成功返回布尔值
     */
    public function registerLogin(array $user, $is_remeber_me = 604800) {
        parent::registerLogin($user, $is_remeber_me);
        echo uc_user_synlogin($user['userid']);
        return true;
    }

    /**
     * 注销登陆
     */
    public function logoutLocal() {
        parent::logoutLocal();
        echo uc_user_synlogout();
        return true;
    }

}