<?php

/**
 * 评论自定义字段
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class FieldAction extends AdminbaseAction {
    
    public $CommentsSetting;
    
    function _initialize() {
        parent::_initialize();
        $this->CommentsSetting = F("Comments_setting");
        if(empty($this->CommentsSetting)){
            $this->error("初始化错误，请更新缓存！");
        }
        $this->assign("show_header",false);
    }

    public function index() {
        $data = M("CommentsField")->order(array("fid" => "DESC"))->select();
        $this->assign("data", $data);
        $this->display();
    }

    /**
     * 添加字段 
     */
    public function add() {
        if (IS_POST) {
            $db = D("CommentsField");
            $data = $db->create();
            if ($data) {
                $data['regular'] = Input::forTag($_POST['regular']);
                if ($db->field_add($data)) {
                    $this->success("添加成功！");
                } else {
                    $this->error("添加失败！");
                }
            } else {
                $this->error($db->getError());
            }
        } else {
            $this->display();
        }
    }

    /**
     * 删除字段 
     */
    public function delete() {
        $fid = $this->_get("fid");
        if (empty($fid)) {
            $this->error("参数错误！");
        }
        $db = D("CommentsField");
        if($db->field_delete($fid)){
            $this->success("自定义字段删除成功！");
        }else{
            $this->error("自定义字段删除失败！");
        }
    }

    /**
     * 编辑字段 
     */
    public function edit() {
        if (IS_POST) {
            $db = D("CommentsField");
            $fid = (int) $this->_post("fid");
            $r = $db->where(array("fid" => $fid))->find();
            $data = $db->create();
            if ($data) {
                unset($data['issystem']);
                $field = $db->ReturnPlFtype($data);
                $data['regular'] = Input::forTag($_POST['regular']);
                if ($db->save($data) === false) {
                    $this->error("更新失败！");
                }
                if ($data['f'] != $r['f']) {
                    if (!$this->checkfield($this->_post("f"))) {
                        $this->error("该字段已经存在！");
                    }
                }
                $stbsum = $this->CommentsSetting;
                if ($r['ftype'] != $data['ftype']) {
                    $Model = new Model();
                    if ($r['issystem'] == 1) {
                        $Model->query("alter table " . C("DB_PREFIX") . "comments change `" . $r['f'] . "` " . $field);
                    } else {
                        for ($i = 1; $i <= $stbsum['stbsum']; $i++) {
                            $Model->query("alter table " . C("DB_PREFIX") . "comments_data_" . $i . " change `" . $r['f'] . "` " . $field);
                        }
                    }
                }
                $this->success("更新成功！", U("Comments/Field/index"));
            } else {
                $this->error($db->getError());
            }
        } else {
            $fid = (int) $this->_get("fid");
            $data = M("CommentsField")->where(array("fid" => $fid))->find();
            if (!$data) {
                $this->error("该自定义字段不存在！");
            }
            $data['regular'] = Input::forTag($data['regular']);
            $this->assign("data", $data);
            $this->display();
        }
    }

    /**
     * 检查字段是否存在
     */
    public function public_checkfield() {
        $f = $this->_get("f");
        if (empty($f)) {
            $this->error("字段名称不能为空！");
        }
        if (!$this->checkfield($f)) {
            $this->error("该字段已经存在！");
        } else {
            $this->success("该字段可以正常使用！");
        }
    }

}

?>
