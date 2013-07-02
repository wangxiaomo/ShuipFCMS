<?php

/**
 * 表单模型字段管理
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class FormaguideFieldModel extends Model_fieldModel {

    /**
     * 根据模型ID，返回表名
     * @param type $modelid
     * @param type $modelid
     * @return string
     */
    protected function getModelTableName($modelid, $issystem) {
        //读取模型配置 以后优化缓存形式
        $model_cache = F("Model_form");
        if(empty($model_cache)){
            $model_cache = D("Model")->Cache(3);
        }
        //表名获取
        $model_table = $model_cache[$modelid]['tablename'];
        return $model_table;
    }

}
