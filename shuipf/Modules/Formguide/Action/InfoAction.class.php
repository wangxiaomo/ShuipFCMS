<?php

/**
 * 表单信息管理
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class InfoAction extends AdminbaseAction {

    //数据库对象
    protected $db = NULL;
    public $formid;

    function _initialize() {
        parent::_initialize();
        $formid = I('request.formid', 0, 'intval');
        $this->formid = $formid;
        if (!empty($this->formid)) {
            $tablename = M('Model')->where(array("modelid" => $this->formid))->getField("tablename");
            $this->db = M(ucwords($tablename));
        }
        $this->assign('formid', $this->formid);
    }

    //信息列表
    public function index() {
        if (empty($this->formid)) {
            $this->error("该表单不存在！");
        }
        $count = $this->db->count();
        $page = $this->page($count, 20);
        $data = $this->db->limit($page->firstRow . ',' . $page->listRows)->order(array("dataid" => "DESC"))->select();

        $this->assign("Page", $page->show('Admin'));
        $this->assign("data", $data);
        $this->display();
    }

    //删除信息
    public function delete() {
        if (IS_POST) {
            $dataid = I('post.dataid');
            if (!is_array($dataid)) {
                $this->error("操作失败！");
            }
            if ($this->db->where(array('dataid' => array('IN', $dataid)))->delete()) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $dataid = I('get.dataid', 0, 'intval');
            if (empty($dataid)) {
                $this->error('该信息不存在！');
            }
            if ($this->db->where(array('dataid' => $dataid))->delete()) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
    }

    //信息查看
    public function public_view() {
        $dataid = I('get.dataid', 0, 'intval');
        if (!$this->formid || !$dataid) {
            $this->error("该信息不存在！<script>setTimeout(function(){window.top.art.dialog.list['check'].close();},1500);</script>");
        }
        if (empty($this->db)) {
            $this->error("该表单不存在！<script>setTimeout(function(){window.top.art.dialog.list['check'].close();},1500);</script>");
        }
        $data = $this->db->where(array("dataid" => $dataid))->find();
        if (!$data) {
            $this->error("该信息不存在！<script>setTimeout(function(){window.top.art.dialog.list['check'].close();},1500);</script>");
        }
        //引入输入表单处理类
        require RUNTIME_PATH . 'content_output.class.php';
        $content_form = new content_output($this->formid);
        $data['modelid'] = $this->formid;
        //字段内容
        $forminfos = $content_form->get($data);
        $fields = $content_form->fields;
        $this->assign("forminfos", $forminfos);
        $this->assign("data", $data);
        $this->assign("fields", $fields);
        $this->display("view");
    }

}