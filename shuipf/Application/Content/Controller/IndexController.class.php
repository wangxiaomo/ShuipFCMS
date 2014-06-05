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

    //首页
    public function index() {
//        print_r($this->Content->check(64, 1, 99));
//        $model = \Content\Model\ContentModel::getInstance(13);
//        $data = $model->relation(true)->find(64);
//        $this->Html->show($data);
//        exit;
//        $url = new \Libs\System\Url();
//        $model = \Content\Model\ContentModel::getInstance(13);
        //$data = $model->relation(true)->find(1);
//        $html = new \Libs\System\Html();
        //$content = \Libs\System\Content::getInstance()->add();
        //print_r($content);exit;
//        print_r($html->index());
//        service('Attachment');
//        G('begin');
//        for ($i = 0; $i < 1000; $i++) {
//            service('Attachment');
//        }
//        G('end');
//        echo G('begin', 'end', 6);
        //echo '网站首页';
        //tag('content_edit_begin');
        //echo md5('ShuipFCMS_Comments');exit;
        $this->display();
    }

    //列表
    public function lists() {
        echo '列表页';
    }

    //内容页
    public function shows() {
        echo '内容页';
    }

    //tags标签
    public function tags() {
        $tagid = I('get.tagid', 0, 'intval');
        $tag = I('get.tag', '', '');
        $where = array();
        if (!empty($tagid)) {
            $where['tagid'] = $tagid;
        } else if (!empty($tag)) {
            $where['tag'] = $tag;
        }
    }

}
