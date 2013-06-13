<?php

/**
 * 使用JSON数据格式获取数据，用于JS调用
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class GetjsonpAction extends Action {

    function _initialize() {
        
    }

    /**
     * 输出到页面
     * @param type $info
     * @param type $status
     * @param type $data 
     */
    protected function show($info, $status = true, $data = array()) {
        //header('Content-type: text/json');
        header('Content-type: application/json');
        $return = array(
            "info" => $info,
            "status" => $status,
            "data" => $data
        );

        if (isset($_GET['callback'])) {
            echo $this->jsonp($return);
            exit;
        } else {
            echo $this->json($return);
            exit;
        }
    }

    /**
     * 评论 不带分页
     * @return boolean 
     */
    public function comment() {
        $id = (int) $this->_get("id");
        $catid = (int) $this->_get("catid");
        $comment_id = "c-$catid-$id";
        if (empty($comment_id)) {
            return false;
        }
        import("Comment");
        $Comment = new Comment();
        $status = $Comment->show($comment_id, 20);
        $status['data']['list'] = $this->commentdata($status['data']['list']);

        $this->show($status['info'], $status['status'], $status['data']);
    }

    protected function commentdata($data, $i = 1) {
        foreach ($data as $k => $v) {
            //去除敏感信息
            try {
                unset($data[$k]['author_email'], $data[$k]['author_ip']);
            } catch (Exception $exc) {
                
            }
            //avatar头像处理
            if ((int) $v['user_id'] > 0) {
                $data[$k]['avatar'] = get_avatar((int) $v['user_id']);
            } else {
                $data[$k]['avatar'] = get_avatar($v['author_email']);
            }
            $data[$k]['date'] = date("Y-m-d H:i:s A", $v['date']);
            if (isset($data[$k]['arrchild'])) {
                $data[$k]['arrchild'] = $this->commentdata($data[$k]['arrchild'], 2);
            }
            if ($i == 1) {
                $z[] = $data[$k];
            } else {
                $z[$v['id']] = $data[$k];
            }
        }
        return $z;
    }

    /**
     *  JSON格式输出
     * @param type $info
     * @param type $status
     * @param type $data
     * @return type 
     */
    protected function json($data = array()) {
        return json_encode($data);
    }

    /**
     * 使用JSONP方式输出
     * @param type $info
     * @param type $status
     * @param type $data
     * @return type 
     */
    protected function jsonp($data = array()) {
        $callback = $this->_get("callback");
        return $callback . "(" . $this->json($data) . ");";
    }

}

?>
