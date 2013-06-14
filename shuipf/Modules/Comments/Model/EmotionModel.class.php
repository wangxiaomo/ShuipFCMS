<?php

/* * 
 * 表情模型
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */

class EmotionModel extends CommonModel {

    protected $tableName = 'comments_emotion';
    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('emotion_name', 'require', '表情名称不能为空！', 1, 'regex', 3),
        array('emotion_icon', 'require', '表情图标不能为空！', 1, 'regex', 3),
        array('emotion_name', '', '表情名称已经存在！', 0, 'unique', 1),
        array('emotion_icon', '', '表情图标已经存在！', 0, 'unique', 1),
    );

    /**
     * 更新缓存
     * @return type 成功返回true;
     */
    public function emotion_cache() {
        $data = $this->where(array('isused' => 1))->select();
        $cacheList = array();
        foreach($data as $r){
            $cacheList['['.$r['emotion_name'].']'] = $r;
        }
        F("Emotion", $cacheList);
        return $data;
    }

}

?>
