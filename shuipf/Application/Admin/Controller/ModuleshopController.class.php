<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 模块商店
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Common\Controller\AdminBase;

class ModuleshopController extends AdminBase {

    //在线模块列表
    public function index() {
        $parameter = array(
            'page' => $_GET[C('VAR_PAGE')],
            'paging' => 10,
        );
        $data = $this->Cloud->data($parameter)->act('get.module.list');
        if (false === $data) {
            $this->error($this->Cloud->getError());
        }
        $page = $this->page($data['total'], $data['paging']);
        $this->assign("Page", $page->show());
        $this->assign('data', $data['data']);
        $this->display();
    }

}
