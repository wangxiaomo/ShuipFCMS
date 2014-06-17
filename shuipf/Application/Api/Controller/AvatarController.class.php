<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 获取头像
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Api\Controller;

use Common\Controller\ShuipFCMS;

class AvatarController extends ShuipFCMS {

    /**
     * 根据用户uid获取系统用户头像
     * http://www.abc3210.com/api.php?m=avatar&uid=用户id
     */
    public function index() {
        $uid = isset($_GET['uid']) ? $_GET['uid'] : 0;
        $size = isset($_GET['size']) ? $_GET['size'] : 90;
        $random = isset($_GET['random']) ? $_GET['random'] : '';
        $connect = isset($_GET['connect']) ? true : false;
        if (empty($random)) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Last-Modified:" . date('r'));
            header("Expires: " . date('r', time() + 86400));
        }
        $avatar_url = service("Passport")->getUserAvatar((int) $uid, (int) $size, $connect);
        header('Location: ' . $avatar_url);
    }

    /**
     * 根据邮箱地址，获取gravatar头像
     * http://www.abc3210.com/api.php?m=avatar&a=gravatar&email=用户邮箱
     */
    public function gravatar() {
        $id_or_email = I('get.email');
        $size = I('get.size', 96);
        $default = I('get.default');
        $alt = I('get.alt', false);
        header('Location: ' . $this->getAvatar($id_or_email, $size, $default, $alt));
    }

    /**
     *  通过用户邮箱，取得gravatar头像
     * @since 2.5
     * @param int|string|object $id_or_email 一个用户ID，电子邮件地址
     * @param int $size 头像图片的大小
     * @param string $default 如果没有可用的头像是使用默认图像的URL
     * @param string $alt 替代文字使用中的形象标记。默认为空白
     * @return string <img>
     */
    protected function getAvatar($id_or_email, $size = '96', $default = '', $alt = false) {
        //头像大小
        if (!is_numeric($size))
            $size = '96';
        //邮箱地址
        $email = '';
        //如果是数字，表示使用会员头像 暂时没有写！
        if (is_int($id_or_email)) {
            $id = (int) $id_or_email;
            $userdata = service("Passport")->getLocalUser($id);
            $email = $userdata['email'];
        } else {
            $email = $id_or_email;
        }
        //设置默认头像
        if (empty($default)) {
            $default = 'mystery';
        }
        if (!empty($email))
            $email_hash = md5(strtolower($email));

        if (!empty($email))
            $host = sprintf("http://%d.gravatar.com", ( hexdec($email_hash[0]) % 2));
        else
            $host = 'http://0.gravatar.com';
        if ('mystery' == $default)
            $default = "$host/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}"; // ad516503a11cd5ca435acc9bb6523536 == md5('unknown@gravatar.com')
        elseif (!empty($email) && 'gravatar_default' == $default)
            $default = '';
        elseif ('gravatar_default' == $default)
            $default = "$host/avatar/s={$size}";
        elseif (empty($email))
            $default = "$host/avatar/?d=$default&amp;s={$size}";
        if (!empty($email)) {
            $out = "$host/avatar/";
            $out .= $email_hash;
            $out .= '?s=' . $size;
            $out .= '&amp;d=' . urlencode($default);
            $avatar = $out;
        } else {
            $avatar = $default;
        }
        return $avatar;
    }

}
