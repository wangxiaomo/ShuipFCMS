<?php

/**
 * 自定义列表
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class CustomlistAction extends AdminbaseAction {

    private $db = NULL;

    //初始
    protected function _initialize() {
        parent::_initialize();
        $this->db = D('Template/Customlist');
    }

    //列表首页
    public function index() {
        $where = array();
        $count = $this->db->where($where)->count();
        $page = $this->page($count, 20);
        $data = $this->db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();

        $this->assign("Page", $page->show('Admin'));
        $this->assign('data', $data);
        $this->display();
    }

    //添加列表
    public function add() {
        if (IS_POST) {
            if ($this->db->addCustomlist($_POST)) {
                $this->success('添加成功！');
            } else {
                $error = $this->db->getError();
                $this->error($error ? $error : '自定义列表添加失败！');
            }
        } else {
            $this->templateAndRule();
            $this->display();
        }
    }

    //编辑
    public function edit() {
        if (IS_POST) {
            if ($this->db->editCustomlist($_POST)) {
                $this->success('修改成功！', U('index'));
            } else {
                $error = $this->db->getError();
                $this->error($error ? $error : '自定义列表修改失败！');
            }
        } else {
            $id = I('get.id', 0, 'intval');
            $info = $this->db->where(array('id' => $id))->find();
            if (empty($info)) {
                $this->error('该自定义列表不存在！');
            }

            $this->templateAndRule($info);
            $this->assign('info', $info);
            $this->display();
        }
    }

    //删除
    public function delete() {
        $id = I('get.id', 0, 'intval');
        if ($this->db->deleteCustomlist($id)) {
            $this->success('删除成功！');
        } else {
            $error = $this->db->getError();
            $this->error($error ? $error : '删除失败！');
        }
    }

    /**
     * 初始模板和URL规则信息
     * @param type $info
     */
    private function templateAndRule($info = array('urlruleid' => '')) {
        $filepath = TEMPLATE_PATH . (empty(AppframeAction::$Cache["Config"]['theme']) ? "Default" : AppframeAction::$Cache["Config"]['theme']) . DIRECTORY_SEPARATOR . "Contents" . DIRECTORY_SEPARATOR;
        $tp_list = str_replace($filepath . "List" . DIRECTORY_SEPARATOR, "", glob($filepath . "List" . DIRECTORY_SEPARATOR . 'list*'));

        $this->assign('list_html_ruleid', Form::urlrule('template', 'list', 1, $info['urlruleid'], 'name="urlruleid"'));
        $this->assign('tp_list', $tp_list);
    }

}
