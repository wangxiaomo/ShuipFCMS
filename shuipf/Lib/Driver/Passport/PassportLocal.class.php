<?php

/**
 * 通行证服务，使用本地帐号
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class PassportLocal extends PassportService {

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
        $Member = D("Member");
        $encrypt = genRandomString(6);
        $password = $Member->encryption(0, $password, $encrypt);
        $data = array(
            "username" => $username,
            "password" => $password,
            "email" => $email,
            "encrypt" => $encrypt,
        );
        $userid = $Member->add($data);
        if ($userid) {
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
            unset($data['password'], $data['encrypt']);
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
        $dr = C("UPLOADFILEPATH") . "avatar/" . $uid . '/';
        if (service("Attachment")->delDir($dr)) {
            M("Member")->where(array("userid" => $uid))->save(array("userpic" => ""));
            return 1;
        } else {
            return 0;
        }
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
            $find = M("Member")->where(array("email" => $email))->find();
            if ($find) {
                return -6;
            }
            return 1;
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
            $find = M("Member")->where(array("username" => $username))->find();
            if ($find) {
                return -3;
            }
            return 1;
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
        $auth_data = urlencode(authcode($uid, ''));
        $upurl = base64_encode(CONFIG_SITEURL . 'index.php?g=Member&m=Index&a=uploadavatar&auth_data=' . $auth_data);
        $html = '<script type="text/javascript">
    var return_avatar=function(data) {
        if (data == 1) {
            window.location.reload();
        } else {
            alert("failure");
        }
    }
    var flashvars = {
        "upurl": "' . $upurl . '&callback=return_avatar&"
    };
    var params = {
        "align": "middle",
        "play": "true",
        "loop": "false",
        "scale": "showall",
        "wmode": "window",
        "devicefont": "true",
        "id": "Main",
        "bgcolor": "#ffffff",
        "name": "Main",
        "allowscriptaccess": "always"
    };
    var attributes = {

    };
    swfobject.embedSWF("' . CONFIG_SITEURL . 'statics/images/main.swf", "myContent", "490", "434", "9.0.0", "' . CONFIG_SITEURL . 'statics/images/expressInstall.swf", flashvars, params, attributes);
</script>';
        return $html;
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
            180 => "180x180.jpg",
            90 => "90x90.jpg",
            45 => "45x45.jpg",
            30 => "30x30.jpg",
        );
        $format = in_array($format, $avatar) ? $format : 90;
        $userpic = "avatar/{$uid}/" . $avatar[$format];
        if ($userpic) {
            $picurl = CONFIG_SITEFILEURL . $userpic;
        } else {
            $picurl = CONFIG_SITEURL . "statics/images/member/nophoto.gif";
        }
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
        $UserMode = D('Member');
        $user = $UserMode->where($map)->find();
        if (empty($user)) {
            return false;
        }
        //是否需要进行密码验证
        if (!empty($password)) {
            $encrypt = $user["encrypt"];
            //对明文密码进行加密
            $password = $UserMode->encryption($identifier, $password, $encrypt);
            if ($password != $user['password']) {
                //密码错误
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
        $map = array();
        if (is_int($identifier)) {
            $map['userid'] = $identifier;
            $identifier = intval($identifier);
        } else {
            $map['username'] = $identifier;
        }
        $userinfo = $this->getLocalUser($identifier);
        if (empty($userinfo)) {
            //没有该用户
            return -1;
        }
        //是否需要进行密码验证
        if (!empty($password)) {
            $encrypt = $userinfo["encrypt"];
            //对明文密码进行加密
            $password = $db->encryption($identifier, $password, $encrypt);
            if ($password != $userinfo['password']) {
                //密码错误
                return -2;
            }
        }
        //注册用户登陆状态
        if ($this->registerLogin($userinfo, $is_remember_me)) {
            //修改登陆时间，和登陆IP
            $db->where($map)->save(array(
                "lastdate" => time(),
                "lastip" => get_client_ip(),
                "loginnum" => $userinfo['loginnum'] + 1,
            ));
            //记录登陆日志
            $this->recordLogin($user['userid']);
            //登陆成功
            return $userinfo['userid'];
        } else {
            //会员注册登陆状态失败
            return -3;
        }
    }

}