<?php

// +----------------------------------------------------------------------
// | ShuipFCMS Controller
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------
use Think\Controller;

class ShuipFCMSController extends Controller {

    //缓存
    public static $Cache = array();

    //初始化
    protected function _initialize() {
        $this->initSite();
        //默认跳转时间
        $this->assign("waitSecond", 2000);
    }

    /**
     * 初始化站点配置信息
     * @return Arry 配置数组
     */
    protected function initSite() {
        $Config = cache("Config");
        $config_siteurl = $Config['siteurl'];
        defined('CONFIG_SITEURL_MODEL') or define("CONFIG_SITEURL_MODEL", $config_siteurl);
        self::$Cache['Config'] = $Config;
        $this->assign("config_siteurl", $config_siteurl);
        $this->assign("Config", $Config);
    }

}
