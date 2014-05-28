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
        $url = new \Libs\System\Url();
        $model = \Content\Model\ContentModel::getInstance(13);
        $data = $model->relation(true)->find(1);
        $html = new \Libs\System\Html();
        print_r($html->show($data, 0));
//        service('Attachment');
//        G('begin');
//        for ($i = 0; $i < 1000; $i++) {
//            service('Attachment');
//        }
//        G('end');
//        echo G('begin', 'end', 6);
        echo '网站首页';
    }

    public function lists() {
        echo '列表页';
    }

    public function shows() {
        echo '内容页';
    }

}
