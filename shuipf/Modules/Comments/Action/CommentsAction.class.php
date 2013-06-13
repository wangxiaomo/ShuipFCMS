<?php

/**
 * 后台评论管理Action
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class CommentsAction extends AdminbaseAction {
    
    public function _initialize() {
        parent::_initialize();
        import('Comment');
    }

    /**
     * 显示全部评论 
     */
    public function index() {
        if (IS_POST) {
            $ids = $_POST['ids'];
            if (empty($ids)) {
                $this->error("没有信息被选择！");
            }
            $db = M("Comments");
            $Comment = new Comment();
            foreach($ids as $k=>$id){
                $Comment->delete($id);
            }
            $this->success("删除评论成功！");
        } else {
            $keyword = $this->_get("keyword");
            $searchtype = (int) $this->_get("searchtype");
            $type = array(
                0 => "content", //评论内容
                1 => "author", //评论作者
                2 => "comment_id"//所属文章id
            );
            $where = array();
            $where["approved"] = array("EQ", 1);
            if (!empty($keyword) && isset($type[$searchtype])) {
                $where[$type[$searchtype]] = array("LIKE", "%" . $keyword . "%");
            }
            $db = M("Comments");
            $Category = F("Category");
            $Model = F("Model");
            $count = $db->where($where)->count();
            $page = $this->page($count, 20);
            $data = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "DESC"))->select();
            foreach ($data as $k => $v) {
                $r = M("Comments_data_" . $v['stb'])->where(array("id" => $v['id']))->find();
                $aid = explode("-", $v['comment_id']);
                $catid = $aid[1];
                $id = $aid[2];
                $title = M(ucwords($Model[$Category[$catid]['modelid']]["tablename"]))->where(array("id" => $id))->find();
                $title['article_id'] = $title['id'];
                unset($title['id']);
                $data[$k] = array_merge($title, $data[$k], $r);
            }
            $this->assign("Page", $page->show('Admin'));
            $this->assign("data", $data);
            $this->display();
        }
    }

    /**
     * 评论审核 
     */
    public function check() {
        $db = M("Comments");
        if (IS_POST) {
            $ids = $_POST['ids'];
            if (empty($ids)) {
                $this->error("没有信息被选择！");
            }
            $ids = implode(",", $ids);
            $db = M("Comments");
            $where['id'] = array("IN", $ids);
            $status = $db->where($where)->data(array("approved" => 1))->save();
            if ($status !== false) {
                $this->success("审核成功！");
            } else {
                $this->error("审核失败！");
            }
        } else {
            $id = (int) $this->_get("id");
            if ($id > 0) {
                
            } else {
                $Category = F("Category");
                $Model = F("Model");
                $where = array();
                $where["approved"] = array("EQ", '0');
                $count = $db->where($where)->count();
                $page = $this->page($count, 20);
                $data = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "DESC"))->select();
                foreach ($data as $k => $v) {
                    $r = M("Comments_data_" . $v['stb'])->where(array("id" => $v['id']))->find();
                    $aid = explode("-", $v['comment_id']);
                    $catid = $aid[1];
                    $id = $aid[2];
                    $title = M(ucwords($Model[$Category[$catid]['modelid']]["tablename"]))->where(array("id" => $id))->find();
                    $title['article_id'] = $title['id'];
                    unset($title['id']);
                    $data[$k] = array_merge($title, $data[$k], $r);
                }
                $this->assign("Page", $page->show('Admin'));
                $this->assign("data", $data);
                $this->display();
            }
        }
    }

    /**
     * 评论编辑 
     */
    public function edit() {
        if (IS_POST) {
            $Comment = new Comment();
            $db = M("Comments");
            foreach ($_POST as $k => $v) {
                $_POST[$k] = Input::hsc($v);
            }
            if ($data = $db->create()) {
                $data = array_merge($_POST, $data);
                $status = $Comment->edit($data);
                if ($status['status']) {
                    $this->success("更新成功！", U("Comments/Comments/index"));
                } else {
                    $this->error($status['info']);
                }
            } else {
                $this->error($db->getError());
            }
        } else {
            $id = (int) $this->_get("id");
            if ($id <= 0) {
                $this->error("参数有误！");
            }
            $r = M("Comments")->where(array("id" => $id))->find();
            if ($r) {
                $r2 = M("Comments_data_" . $r['stb'])->where(array("id" => $id))->find();
                $data = array_merge($r, $r2);
                $data['content'] = Input::forTarea($data['content']);
                //取得自定义字段
                $field = M("Comments_field")->order(array("fid" => "DESC"))->select();

                $this->assign("data", $data);
                $this->assign("field", $field);
                $this->display();
            } else {
                $this->error("该评论不存在！");
            }
        }
    }

    /**
     * 删除评论 
     */
    public function delete() {
        $id = (int) $this->_get("id");
        if ($id <= 0) {
            $this->error("参数有误！");
        }
        $r = M("Comments")->where(array("id" => $id))->find();
        if ($r) {
            $Comment = new Comment();
            $status = $Comment->delete($id);
            if ($status["status"]) {
                $this->success("评论删除成功！");
            } else {
                $this->error($status['info']);
            }
        } else {
            $this->error("该评论不存在！");
        }
    }

    /**
     * 垃圾评论 
     */
    public function spamcomment() {
        $id = (int) $this->_get("id");
        if ($id <= 0) {
            $this->error("参数有误！");
        }
        $r = M("Comments")->where(array("id" => $id))->find();
        if ($r) {
            $Comment = new Comment();
            $status = $Comment->status($id);
            if ($status["status"]) {
                $this->success("状态转换成功！");
            } else {
                $this->error($status['info']);
            }
        } else {
            $this->error("该评论不存在！");
        }
    }

    /**
     * 回复评论 
     */
    public function replycomment() {
        if (IS_POST) {
            $db = M("Comments");
            C("TOKEN_ON", false);
            $data = $db->create();
            if ($data) {
                $Comment = new Comment();
                $data = array_merge($_POST, $data);
                $data['user_id'] = AppframeAction::$Cache['uid'];
                $catid = $_POST['comment_catid'];
                if (empty($catid) || empty($_POST['comment_id'])) {
                    $this->error("参数有误！");
                }
                $data['comment_id'] = "c-$catid-" . $_POST['comment_id'];
                $status = $Comment->add($data, 1);
                if ($status['status']) {
                    $this->success("评论回复成功！",U("Comments/index"));
                } else {
                    $this->error($status['info']);
                }
            } else {
                $this->error($db->getError());
            }
        } else {
            $id = (int) $this->_get("id");
            if ($id <= 0) {
                $this->error("参数有误！");
            }
            $r = M("Comments")->where(array("id" => $id))->find();
            if ($r) {
                $r2 = M("Comments_data_" . $r['stb'])->where(array("id" => $id))->find();
                $data = array_merge($r, $r2);
                $data['content'] = Input::forTarea($data['content']);
                //取得自定义字段
                $field = M("Comments_field")->where(array("system"=>0))->order(array("fid" => "DESC"))->select();
                $ca = explode("-", $data["comment_id"]);
                //如果是回复评论，也就是approved不等于0的评论
                if (!$r['parent'] == 0) {
                    $this->assign("parent", $data['parent']);
                } else {
                    $this->assign("parent", $data['id']);
                }
                import("Form");
                $this->assign("author_url",AppframeAction::$Cache['Config']['siteurl']);
                $this->assign("author_email",AppframeAction::$Cache['User']['email']);
                $this->assign("author",AppframeAction::$Cache['username']);
                $this->assign("data", $data);
                $this->assign("catid", $ca[1]);
                $this->assign("commentid", $ca[2]);
                $this->assign("field", $field);
                $this->display();
            } else {
                $this->error("该评论不存在！");
            }
        }
    }

    /**
     * 评论配置 
     */
    public function config() {
        $db = M("CommentsSetting");
        if (IS_POST) {
            $guest = isset($_POST['guest']) && intval($_POST['guest']) ? intval($_POST['guest']) : 0;
            $check = isset($_POST['check']) && intval($_POST['check']) ? intval($_POST['check']) : 0;
            $code = isset($_POST['code']) && intval($_POST['code']) ? intval($_POST['code']) : 0;
            $stb = isset($_POST['stb']) && intval($_POST['stb']) ? intval($_POST['stb']) : 1;
            $order = isset($_POST['order']) && $this->_post("order")  ? $this->_post("order") : "id ASC";
            $strlength = isset($_POST['strlength']) && intval($_POST['strlength']) ? intval($_POST['strlength']) : 0;
            $status = isset($_POST['status']) && intval($_POST['status']) ? intval($_POST['status']) : 0;
            $expire  = isset($_POST['expire']) && intval($_POST['expire']) ? intval($_POST['expire']) : 0;
            $data = array(
                "guest" => $guest,
                "check" => $check,
                "code" => $code,
                "stb" => $stb,
                "order" => $order,
                "strlength" => $strlength,
                "status" => $status,
                "expire" => $expire,
            );
            
            $where = $db->find();
            if ($db->where($where)->save($data) !== false) {
                F("Comments_setting", $data);
                $this->success("更新成功！", U("Comments/Comments/config"));
            } else {
                $this->error("更新失败！", U("Comments/Comments/config"));
            }
        } else {
            $data = $db->find();
            $this->assign("data", $data);
            $this->display();
        }
    }

    /**
     * 分表 
     */
    public function fenbiao() {
        $db = M("Comments_setting");
        $r = $db->find();
        $stbsum = $r['stbsum'];

        for ($i = 1; $i <= $stbsum; $i++) {
            $d = M("Comments_data_" . $i);
            $data[] = array(
                "id" => $i,
                "count" => $d->count(),
                "tablename" => C("DB_PREFIX") . "comments_data_" . $i
            );
        }

        $this->assign("data", $data);
        $this->assign("r", $r);
        $this->display();
    }

    /**
     * 创建一张新的分表 
     */
    public function addfenbiao() {
        if(D("CommentsField")->addfenbiao()){
            $this->success("分表创建成功！");
        }else{
            $this->error("创建分表失败！");
        }
    }

}

?>
