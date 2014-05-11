<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 网站后台日志管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Common\Controller\AdminBase;

class LogsController extends AdminBase {

    //后台登陆日志
    public function loginlog() {
        if (IS_POST) {
            $this->redirect('loginlog', $_POST);
        }
        $where = array();
        $username = I('username');
        $start_time = I('start_time');
        $end_time = I('end_time');
        $loginip = I('loginip');
        $status = I('status');
        if (!empty($username)) {
            $where['username'] = array('like', '%' . $username . '%');
        }
        if (!empty($start_time) && !empty($end_time)) {
            $where['_string'] = " `logintime` >'$start_time' AND  `logintime`<'$end_time' ";
        }
        if (!empty($loginip)) {
            $where['loginip '] = array('like', '%' . $loginip . '%');
        }
        if ($status != '') {
            $where['status'] = array('eq', $status);
        }
        $model = D("Admin/Loginlog");
        $count = $model->where($where)->count();
        $page = $this->page($count, 20);
        $data = $model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array('id' => 'DESC'))->select();
        $this->assign("Page", $page->show())
                ->assign("data", $data)
                ->assign('where', $where)
                ->display();
    }

    //删除一个月前的登陆日志
    public function deleteloginlog() {
        if (D("Admin/Loginlog")->deleteAMonthago()) {
            $this->success("删除登陆日志成功！");
        } else {
            $this->error("删除登陆日志失败！");
        }
    }

    //操作日志查看
    public function index() {
        if (IS_POST) {
            $this->redirect('index', $_POST);
        }
        $uid = I('uid');
        $start_time = I('start_time');
        $end_time = I('end_time');
        $ip = I('ip');
        $status = I('status');
        if (!empty($uid)) {
            $data['uid'] = array('eq', $uid);
        }
        if (!empty($start_time) && !empty($end_time)) {
            $data['_string'] = " `time` >'$start_time' AND  `time`<'$end_time' ";
        }
        if (!empty($ip)) {
            $data['ip '] = array('like', '%' . $ip . '%');
        }
        if ($status != '') {
            $data['status'] = array('eq', (int) $status);
        }
        if (is_array($data)) {
            $data['_logic'] = 'or';
            $map['_complex'] = $data;
        } else {
            $map = array();
        }
        $count = M("Operationlog")->where($map)->count();
        $page = $this->page($count, 20);
        $Logs = M("Operationlog")->where($map)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        $this->assign("Page", $page->show());
        $this->assign("logs", $Logs);
        $this->display();
    }

    //删除一个月前的操作日志
    public function deletelog() {
        if (D("Admin/Operationlog")->deleteAMonthago()) {
            $this->success("删除操作日志成功！");
        } else {
            $this->error("删除操作日志失败！");
        }
    }

}
