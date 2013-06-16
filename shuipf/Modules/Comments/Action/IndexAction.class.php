<?php

/**
 * 评论
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class IndexAction extends BaseAction {

    public $setting;
    protected $db;

    /**
     * 生成树型结构所需要的2维数组
     * @var array
     */
    protected $arr = array();

    function _initialize() {
        parent::_initialize();
        $this->setting = F("Comments_setting");
        if (!$this->setting) {
            $this->setting = D("Comments")->comments_cache();
        }
        $this->db = D("Comments");
    }

    //显示信息评论,json格式
    public function json() {
        G('run');
        //信息ID
        $id = I('get.id', 0, 'intval');
        //栏目ID
        $catid = I('get.catid', 0, 'intval');
        //评论标识id
        $comment_id = "c-$catid-$id";
        if (!$id || !$catid) {
            $this->error('参数错误！');
        }
        //每页显示评论信息量
        $pageSize = I('get.size', 20, 'intval');
        //当前分页号
        $page = I('get.page', 1, 'intval');
        //条件
        $where = array(
            'comment_id' => $comment_id,
            'approved' => 1,
            'parent' => 0, //非回复类评论
        );

        $commentCount = $this->db->where($where)->count();
        $pages = page($commentCount, $pageSize, $page, 6, '');
        //评论主表数据
        $commentData = $this->db->where($where)->order($this->setting['order'])->limit($pages->firstRow . ',' . $pages->listRows)->select();
        foreach ($commentData as $r) {
            $this->getParentComment($r['id']);
            $this->arr[] = $r;
        }
        //取详细数据
        $listComment = array();
        foreach ($this->arr as $r) {
            $listArr[$r['stb']][] = $r['id'];
        }
        foreach ($listArr as $stb => $ids) {
            if ((int) $stb > 0) {
                $list = M($this->db->viceTableName($stb))->where(array('id' => array('IN', $ids)))->select();
                foreach ($list as $r) {
                    //替换表情
                    if ($r['content']) {
                        $this->db->replaceExpression($r['content']);
                    }
                    $listComment[$r['id']] = $r;
                }
            }
        }
        //评论主表数据和副表数据合并
        foreach ($this->arr as $k => $r) {
            if ((int) $r['id']) {
                $this->arr[$k] = array_merge($r, $listComment[$r['id']]);
            }
        }
        //取得树状结构数组
        $treeArray = $this->get_tree_array();
        //最终返回数组
        $return = array(
            //当前登陆会员信息
            'users' => array(
                'user_id' => self::$Cache['uid'],
                'name' => self::$Cache['username'],
            ),
            //评论列表
            'response' => $treeArray,
            //分页相关
            'cursor' => array(
                'total' => $pages->Total_Pages,//总页数
                C("VAR_PAGE") => $page,//当前分页号
            )
        );
        echo '程序处理时间：'.G('run','end')."s \r\n";
        print_r($return);
        exit;
    }

    //显示某篇信息的评论页面
    public function comment() {
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
                //设置评论间隔时间，cookie没啥样的感觉-__,-!
                if ($this->setting['expire']) {
                    $this->cookie($post['comment_id'], '1', array('expire' => (int) $this->setting['expire'] * 60));
                }
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

    /**
     * 使用递归的方式查询出回复评论...效率如何俺也不清楚，能力限制了。。
     * @param type $id
     * @return boolean
     */
    protected function getParentComment($id) {
        if (!$id) {
            return false;
        }
        $where = array(
            'parent' => $id,
            'approved' => 1,
        );
        $count = $this->db->where($where)->count();
        //如果大于5条以上，只显示最久的第一条，和最新的3条
        if ($count > 5) {
            $oldData = $this->db->where($where)->order(array('date' => 'ASC'))->find();
            $newsData = $this->db->where($where)->limit(3)->order(array('date' => 'DESC'))->select();
            //数组从新排序
            sort($newsData);
            array_unshift($newsData, $oldData, array(
                'id' => 'load',
                'comment_id' => $oldData['comment_id'],
                'parent' => $oldData['parent'],
                'info' => '已经省略中间部分...',
            ));
            $data = $newsData;
        } else {
            $data = $this->db->where($where)->select();
        }
        if ($data) {
            foreach ($data as $r) {
                $this->getParentComment((int) $r['id']);
                $this->arr[] = $r;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 得到子级数组
     * @param int
     * @return array
     */
    protected function get_child($myid) {
        $a = $newarr = array();
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {
                if ($a['parent'] == $myid)
                    $newarr[$id] = $a;
            }
        }
        return $newarr ? $newarr : false;
    }

    /**
     * 得到树型结构数组
     * @param int $myid，开始父id
     */
    protected function get_tree_array($myid = 0) {
        $retarray = array();
        //一级栏目数组
        $child = $this->get_child($myid);
        if (is_array($child)) {
            //数组长度
            $total = count($child);
            foreach ($child as $id => $value) {
                @extract($value);
                $retarray[$value['id']] = $value;
                $retarray[$value['id']]["child"] = $this->get_tree_array($id, '');
            }
        }
        return $retarray;
    }

}

?>
