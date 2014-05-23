<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 网站前台
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Content\Controller;

use Common\Controller\Base;

class IndexController extends Base {

    public function index() {
        echo '网站首页';
    }

    public function lists() {
        echo '列表页';
    }

    public function shows() {
        echo '内容页';
    }

}
