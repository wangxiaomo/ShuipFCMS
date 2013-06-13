<?php

/**
 * 评论标签
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class CommentTagLib {

    public $db, $table_name, $category, $model, $modelid;

    function __construct() {
        $this->category = F("Category");
    }

    /**
     * 获取评论总数
     * 参数名	 是否必须	 默认值	 说明
     * catid	 是	 null	 栏目ID
     * id	 是	 null	 信息ID
     */
    public function get_comment($data) {
        $catid = (int) $data['catid'];
        $id = (int) $data['id'];
        $commentid = "c-$catid-$id";
        //缓存时间
        $cache = (int)$data['cache'];
        $cacheID = md5($commentid);
        
        if($cache && $datacache = S($cacheID)){
            return $datacache;
        }

        if (empty($this->category[$catid])) {
            return false;
        }
        $total = commcount($catid, $id);
        $data = array(
            "commentid" => $commentid,
            "total" => $total,
        );
        //结果进行缓存
        if($cache){
            S($cacheID,$data,$cache);
        }
        return $data;
    }

    /**
     * 评论数据列表
     * 参数名	 是否必须	 默认值	 说明
     * catid	 否	 null	 栏目ID
     * id	 否	 null	 信息ID
     * hot	 否	 0	 排序方式｛0：最新｝ 
     * date	 否	 Y-m-d H:i:s A	时间格式
     */
    public function lists($data) {
        //缓存时间
        $cache = (int)$data['cache'];
        $cacheID = md5(implode(",", $data));
        if($cache && $cachedata = S($cacheID)){
            return $cachedata;
        }
        $catid = (int) $data['catid'];
        $id = (int) $data['id'];
        $commentid = "c-$catid-$id";
        $hot = isset($data['hot']) ? $data['hot'] : 0;
        $date = !empty($data['date']) ? $data['date'] : "Y-m-d H:i:s A";
        //显示条数
        $num = empty($data['num']) ? 20 : (int) $data['num'];
        $where = array();
        $where['approved'] = array("EQ", 1);

        $db = M("Comments");
        $order = array("date" => "DESC");
        if ($hot == 0) {
            $order = array("date" => "DESC");
        }

        if ($catid > 0 && $id > 0) {
            $where['comment_id'] = array("EQ", $commentid);
        }

        $data = $db->where($where)->order($order)->limit($num)->select();
        import("Comment");
        $Comment = new Comment();
        $data = $Comment->showdata($data);
        //头像处理
        foreach ($data as $k => $v) {
            //avatar头像处理
            if((int)$v['user_id']>0){
                $data[$k]['avatar'] = get_avatar((int)$v['user_id']);
            }else{
                $data[$k]['avatar'] = get_avatar($v['author_email']);
            }
            $data[$k]['date'] = date($date, $v['date']);
            if (isset($data[$k]['arrchild'])) {
                $data[$k]['arrchild'] = $this->commentdata($data[$k]['arrchild']);
            }
            $z[] = $data[$k];
        }
        //结果进行缓存
        if($cache){
            S($cacheID,$data,$cache);
        }
        return $data;
    }

    /**
     * 评论排行榜
     * @param type $data 
     */
    public function bang($data) {
        $catid = (int) $data['catid'];
        $id = (int) $data['id'];
        $commentid = "c-$catid-$id";
    }

}

?>
