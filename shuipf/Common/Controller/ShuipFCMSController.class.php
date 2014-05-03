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
        //默认跳转时间
        $this->assign("waitSecond", 2000);
    }

}
