<?php

/**
 * 数据读取，主要用于前台数据显示
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class content_output {

    //信息ID
    protected $id = 0;
    //栏目ID
    protected $catid = 0;
    //模型ID
    protected $modelid = 0;
    //字段信息
    protected $fields = array();
    //模型缓存
    protected $model = array();
    //数据
    protected $data = array();
    //最近错误信息
    protected $error = '';
    // 数据表名（不包含表前缀）
    protected $tablename = '';

    function __construct($modelid) {
        $this->model = F("Model");
        $this->modelid = $modelid;
        if (empty($this->model[$this->modelid])) {
            return false;
        }
        $this->fields = F("Model_field_" . $this->modelid);
        $this->tablename = trim($this->model[$this->modelid]['tablename']);
    }

    /**
     * 数据处理
     * @param type $data
     * @return type
     */
    function get($data) {
        $this->data = $data;
        $this->catid = $data['catid'];
        $this->id = $data['id'];
        $info = array();
        foreach ($this->fields as $field => $fieldInfo) {
            if (!isset($data[$field])) {
                continue;
            }
            //字段类型
            $func = $fieldInfo['formtype'];
            //字段内容
            $value = $data[$field];
            $result = method_exists($this, $func) ? $this->$func($field, $value) : $value;
            if ($result !== false) {
                $info[$field] = $result;
            }
        }
        return $info;
    }

    ##{字段处理函数}##
}