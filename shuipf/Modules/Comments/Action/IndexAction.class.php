<?php

/**
 * 评论
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class IndexAction extends BaseAction {

    public $setting;

    function _initialize() {
        parent::_initialize();
        $this->setting = F("Comments_setting");
        if(!$this->setting){
            $this->setting = D("Comments")->comments_cache();
        }
        import('Comment');
    }

    public function index() {
        $Comment = new Comment();
        //所属文章id
        $comment_id = $this->_get("commentid");
        //评论
        $id = $this->_get("id");
        if (!empty($comment_id)) {
            $status = $Comment->show($comment_id);
        } else if ($id > 0) {
            
        } else {
            $this->error("缺少参数！");
        }
    }

    /**
     * 添加评论 
     */
    public function add() {
        if (IS_POST) {
            foreach ($_POST as $k => $v) {
                $_POST[$k] = Input::hsc($v);
            }
            $catid = (int) $_POST['comment_catid'];
            $id = (int) $_POST['comment_id'];
            if ($this->comoff($catid, $id) == false) {
                $this->error("该信息不允许评论！");
            }
            $co = $this->cookie("c-$catid-" . $id);
            if(!empty($co)){
                if (IS_AJAX) {
                        $this->ajaxReturn(array(
                            "error" => "expire"
                                ), "评论发布间隔为".$this->setting['expire']."秒！", false);
                    } else {
                        $this->error("评论发布间隔为".$this->setting['expire']."秒！");
                    }
            }

            //判断游客是否有发表权限
            if ((int) $this->setting['guest'] < 1) {
                if (!isset(AppframeAction::$Cache['uid']) && empty(AppframeAction::$Cache['uid'])) {
                    if (IS_AJAX) {
                        $this->ajaxReturn(array(
                            "error" => "guest"
                                ), "游客不允许参与评论！", false);
                    } else {
                        $this->error("游客不允许参与评论！");
                    }
                }
            }

            //验证码判断开始
            if ($this->setting['code'] == 1) {
                if (empty($_POST['verify']) || !$this->verify($_POST['verify'])) {
                    if (IS_AJAX) {
                        $this->ajaxReturn(array(
                            "error" => "verify"
                                ), "验证码错误，请重新输入！", false);
                    } else {
                        $this->error("验证码错误，请重新输入！");
                    }
                }
            }

            if (iconv_strlen($_POST['content']) > (int) $this->setting['strlength']) {
                return $this->error("评论内容超出系统设置允许的最大长度" . $this->setting['strlength'] . "字节！");
            }

            $db = M("Comments");

            C("TOKEN_ON", false);
            if ($data = $db->create()) {
                $Comment = new Comment();
                $data = array_merge($_POST, $data);
                $data['user_id'] = AppframeAction::$Cache['uid'];
                if (empty($catid) || empty($_POST['comment_id'])) {
                    $this->error("参数有误！");
                }
                $data['comment_id'] = "c-$catid-" . $_POST['comment_id'];

                $status = $Comment->add($data);
                if ($status['status']) {
                    if (!empty($this->setting['expire'])) {
                        $this->cookie($data['comment_id'], 1, array(
                            "expire" => $this->setting['expire']
                        ));
                    }
                    if($this->setting['check'] >0){
                        $status['status'] = 3;
                        $status["info"] = "评论发送成功，但需要审核后才显示！";
                    }
                    if (IS_AJAX) {
                        $this->ajaxReturn($status['data'], $status["info"], $status['status']);
                    } else {
                        $this->success($status["info"]);
                    }
                } else {
                    $this->error($status['info']);
                }
            } else {
                $this->error($db->getError());
            }
        } else {
            $this->error("请使用post方式新增评论！");
        }
    }

    /**
     * 检查当前信息是否允许评论 
     */
    protected function comoff($catid, $id) {
        $model = F("Model");
        $category = F("Category");
        if (empty($category[$catid])) {
            return false;
        }
        $modelid = $category[$catid]['modelid'];
        if (empty($model[$modelid])) {
            return false;
        }
        $tablename = ucwords($model[$modelid]['tablename']);
        $db = M($tablename . "_data");
        $allow_comment = $db->where(array("id" => $id))->getField("allow_comment");
        if ((int) $allow_comment <= 0) {
            return false;
        } else {
            return true;
        }
    }

}

?>
