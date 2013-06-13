<?php

/**
 * 评论
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class Comment {

    public $setting, $stb, $field, $comment_id;

    function __construct() {
        $this->setting = F("Comments_setting");
        $this->stb = $this->setting['stb'];
        $this->field = M("Comments_field")->select();
    }

    //发表评论
    public function add($data = array(), $approved = "") {
        if ((int) $this->setting['status'] == 0) {
            return $this->error("系统已经关闭评论！");
        }
        //系统字段
        $system = array(
            "comment_id" => $data['comment_id'],
            "author_ip" => get_client_ip(),
            "date" => time(),
            "approved" => empty($approved) ? (($this->setting['check'] == 1) ? 0 : 1) : $approved,
            "agent" => substr($_SERVER['HTTP_USER_AGENT'], 0, 254),
            "parent" => isset($data['parent']) ? (int) $data['parent'] : 0,
            "user_id" => (int) $data['user_id'],
            "stb" => $this->stb
        );
        $main = $secondary = array();
        //自定义字段分主表，副表
        foreach ($this->field as $k => $v) {
            if ($v['issystem'] == 1) {
                $main[$v['f']] = $data[$v['f']];
            } else {
                $secondary[$v['f']] = $data[$v['f']];
            }
            //非空验证
            if ($v['ismust'] == 1) {
                if (empty($data[$v['f']])) {
                    return $this->error((empty($v['fzs']) ? $v['fname'] . "不能为空！" : $v['fzs']), false, $v);
                }
            }
            if (!empty($data[$v['f']])) {
                //正则验证
                if (!empty($v['regular'])) {
                    if (!preg_match($v['regular'], $data[$v['f']])) {
                        return $this->error($v['fname'] . "输入的信息有误！");
                    }
                }
            }
        }

        if (empty($data['content'])) {
            return $this->error("评论内容不能为空！");
        }

        //评论敏感词过滤处理
        $Censor_Status = 1;
        if (defined("IN_ADMIN") && IN_ADMIN == false) {
            $Filter = service("Filter");
            $status = $Filter->check($data['content']);
            //表示需要审核
            if ($status == -1) {
                $system['approved'] = 0;
                $Censor_Status = 0;
            }
            //禁止发表
            if ($status == 0) {
                return $this->error($Filter->getError());
            }
        }

        $main = array_merge($main, $system);
        $cid = M("Comments")->data($main)->add();
        if ($cid == false) {
            return $this->error("评论新增失败！");
        }
        $secondary['id'] = $cid;
        $secondary = array_merge($secondary, array(
            "comment_id" => $main['comment_id'],
            "content" => $data['content']
                ));
        $status = M("Comments_data_" . $this->stb)->data($secondary)->add();

        if ($status) {
            //敏感词过滤处理结果提示
            if ($Censor_Status) {
                return $this->success("评论新增成功！", true, array_merge($main, $secondary));
            } else {
                return $this->error($Filter->getError());
            }
        } else {
            return $this->error("评论新增失败！");
        }
    }

    //编辑评论
    public function edit($data = array()) {
        $r = M("Comments")->where(array("id" => $data['id']))->find();
        if (!$r) {
            $this->error("该评论不存在！");
        }
        $main = $secondary = array();
        //自定义字段分主表，副表
        foreach ($this->field as $k => $v) {
            if ($v['issystem'] == 1) {
                $main[$v['f']] = $data[$v['f']];
            } else {
                $secondary[$v['f']] = $data[$v['f']];
            }
            //非空验证
            if ($v['ismust'] == 1) {
                if (empty($data[$v['f']])) {
                    return $this->error(empty($v['fzs']) ? $v['fname'] . "不能为空！" : $v['fzs']);
                }
            }
            if (!empty($data[$v['f']])) {
                //正则验证
                if (!empty($v['regular'])) {
                    if (!preg_match($v['regular'], $data[$v['f']])) {
                        return $this->error($v['fname'] . "输入的信息有误！");
                    }
                }
            }
        }

        if (empty($data['content'])) {
            return $this->error("评论内容不能为空！");
        }

        $cid = M("Comments")->where(array("id" => $data['id']))->data($main)->save();
        if ($cid == false && is_bool($cid)) {
            return $this->error("评论更新失败！");
        }

        $secondary = array_merge($secondary, array(
            "content" => $data['content']
                ));
        $status = M("Comments_data_" . $r['stb'])->where(array("id" => $data['id']))->data($secondary)->save();
        if (is_bool($status) && $status == false) {
            return $this->error("评论更新失败！");
        } else {
            return $this->success("评论更新成功！");
        }
    }

    //评论删除。通过id删除
    public function delete($id) {
        $db = M("Comments");
        $stb = $db->where(array("id" => $id))->getField("stb");
        if ($stb) {
            if (M("Comments")->where(array("id" => $id))->delete()) {
                M("Comments_data_" . $stb)->where(array("id" => $id))->delete();
                return $this->success("评论删除成功！");
            } else {
                return $this->error("评论删除失败！");
            }
        }
        return $this->error("评论删除失败！");
    }

    //评论删除，通过所属id删除，也就是comment_id的参数
    public function deletecommentid($comment_id) {
        $r = M("Comments")->where(array("comment_id" => $comment_id))->select();
        if ($r) {
            foreach ($r as $k => $v) {
                $this->delete($v['id']);
            }
        }
        return $this->success("评论删除成功！");
    }

    //评论状态转换
    public function status($id) {
        $r = M("Comments")->where(array("id" => $id))->find();
        if (!$r) {
            return $this->error("该评论不存在！");
        }
        $approved = ($r['approved'] == 1) ? 0 : 1;
        $status = M("Comments")->where(array("id" => $id))->data(array("approved" => $approved))->save();
        if ($status !== false) {
            return $this->success("状态切换成功！");
        } else {
            return $this->error("状态切换失败！");
        }
    }

    /**
     * 显示全部评论！ 
     * @param $id 当传入的是数字的时候，为评论id，其他为comment_id的参数
     */
    public function show($id, $num = 20) {

        if (empty($id)) {
            return $this->error("参数不正确！");
        }
        $db = M("Comments");
        if (is_numeric($id)) {
            $r = $db->where(array("id" => $id, "approved" => 1))->find();
            $this->comment_id = $r['comment_id'];
            $status = $this->datalouc($this->showdata($r));
            if ($status) {
                return $this->success("", true, $status);
            } else {
                return $this->error("该评论不存在或者正在审核中！");
            }
        } else {
            $this->comment_id = $id;
            $comment_id = $id;
            $where = array("comment_id" => $comment_id, "approved" => 1);
            import('Util.Page',APP_PATH.'Lib');
            $count = $db->where(array_merge($where, array('parent' => 0)))->count();
            if($count == 0){
                return $this->success("暂无相关数据！");
            }
            $page = new Page($count, $num, 1, 6, C("VAR_PAGE"), '', FALSE);
            //不包含回复评论
            $r = $db->where(array_merge($where, array('parent' => 0)))->order($this->setting['order'])->limit($page->firstRow . ',' . $page->listRows)->select();
            $status['list'] = $this->datalouc($this->showdata($r));
            $status['Current_page'] = $page->Current_page; //当前分页
            $status['Total_Pages'] = $page->Total_Pages; //总分页数
            $status['Page_size'] = $page->Page_size; //页显示的条目数
            $status['count'] = $count; //评论总数
            if ($status) {
                return $this->success("", true, $status);
            } else {
                return $this->success("暂无相关数据！");
            }
        }
    }

    /**
     * 评论数据主表分表合并数据 
     * @param $r 传入comments表数据
     */
    public function showdata($r = array()) {
        if (empty($r)) {
            return false;
        }
        //检查是一维数组还是二维数组
        if (count($r) == count($r, 1)) {
            $r2 = M("Comments_data_" . $r['stb'])->where(array("id" => $r['id']))->find();
            $data = array_merge($r, $r2);
            //判断是否有回复
            $count = M("Comments")->where(array("parent" => $data['id'],"approved"=>1))->count();
            if ($count > 0) {
                $r3 = M("Comments")->where(array("parent" => $data['id'],"approved"=>1))->select();
                $arrchild = $this->showdata($r3);
                $data["arrchild"] = $arrchild[$r['id']]['arrchild'];
            }
            return $data;
        } else {

            foreach ($r as $k => $v) {
                $r2 = M("Comments_data_" . $v['stb'])->where(array("id" => $v['id']))->find();
                unset($v['agent']);
                $data[$v['id']] = array_merge($v, $r2);
            }

            return $data;
        }
    }

    /**
     * 把评论数组重新组合，
     * AAAA
     *    AAAAA
     *    AAAAA
     * @param type $data 
     */
    protected function datalouc($data = array()) {
        $i = 1;
        $db = M("Comments");
        foreach ($data as $k => $v) {
            $r = $db->where(array("parent" => $v['id'],"approved"=>1))->order($this->setting['order'])->select();
            if ($r) {
                $data[$v['id']]['arrchild'] = $this->showdata($r);
            } else {
                $data[$v['id']]["ol"] = $i;
                $i++;
            }
        }
        return $data;
    }

    /**
     * 内容过滤
     * @param type $content 
     */
    protected function filter($content) {
        return true;
    }

    /**
     * 错误返回 
     */
    protected function error($info, $status = false, $data = array()) {
        return $this->success($info, $status, $data);
    }

    /**
     * 正确返回
     */
    protected function success($info, $status = true, $data = array()) {
        return array(
            "info" => $info,
            "status" => $status,
            "data" => $data,
        );
    }

}

?>
