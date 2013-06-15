<?php

/**
 * 评论
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class IndexAction extends BaseAction {

    public $setting;
    protected $db;

    function _initialize() {
        parent::_initialize();
        $this->setting = F("Comments_setting");
        if (!$this->setting) {
            $this->setting = D("Comments")->comments_cache();
        }
        $this->db = D("Comments");
    }

    //显示某篇信息的评论页面
    public function index() {
        //所属文章id
        $comment_id = I('get.commentid', '', '');
        //评论
        $id = I('get.id', 0, 'intval');
        if (!$comment_id && !$id) {
            $this->error('缺少参数！');
        }
    }

    //添加评论 
    public function add() {
        if (IS_POST) {
            $catid = I('post.comment_catid', 0, 'intval');
            $id = I('post.comment_id', 0, 'intval');
            if (false === $this->db->noAllowComments($catid, $id)) {
                $this->error("该信息不允许评论！");
            }
            $post = I('post.');
            $post['comment_id'] = "c-{$catid}-{$id}";

            //检查评论间隔时间
            $co = $this->cookie($post['comment_id']);
            if ($co) {
                $this->error("评论发布间隔为" . $this->setting['expire'] . "秒！");
            }

            //判断游客是否有发表权限
            if ((int) $this->setting['guest'] < 1) {
                if (!isset(AppframeAction::$Cache['uid']) && empty(AppframeAction::$Cache['uid'])) {
                    $this->error("游客不允许参与评论！");
                }
            }

            //验证码判断开始
            if ($this->setting['code'] == 1) {
                $verify = I('post.verify');
                if (empty($verify) || !$this->verify($verify)) {
                    $this->error("验证码错误，请重新输入！");
                }
            }

            //评论内容长度验证
            $content = I('post.content');
            if (false === $this->db->check($content, '0,' . (int) $this->setting['strlength'], 'length')) {
                $this->error("评论内容超出系统设置允许的最大长度" . $this->setting['strlength'] . "字节！");
            }

            $commentsId = $this->db->addComments($post);
            if (false !== $commentsId) {
                if ($commentsId === -1) {
                    $this->error($this->db->getError());
                } else {
                    $this->success("评论发表成功！");
                }
            } else {
                $this->error($this->db->getError());
            }
        } else {
            $this->error("请使用post方式新增评论！");
        }
    }

}

?>
