<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 内容模型
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Content\Model;

use Common\Model\Model;

class ContentModel extends Model {

    //当前模型id
    public $modelid = 0;
    //自动验证 array(验证字段,验证规则,错误提示,[验证条件,附加规则,验证时间])
    protected $_validate = array();
    //自动完成 array(填充字段,填充内容,[填充条件,附加规则])
    protected $_auto = array();

    /**
     * 取得内容模型实例
     * @param type $modelid 模型ID
     * @return obj
     */
    static public function getInstance($modelid) {
        //静态成品变量 保存全局实例
        static $_instance = NULL;
        if (is_null($_instance[$modelid]) || !isset($_instance[$modelid])) {
            //内容模型缓存
            $modelCache = cache("Model");
            if (empty($modelCache[$modelid])) {
                return false;
            }
            $tableName = $modelCache[$modelid]['tablename'];
            $_instance[$modelid] = new ContentModel(ucwords($tableName));
            //内容模型
            if ($modelCache[$modelid]['type'] == 0) {
                $_instance[$modelid]->_validate = array(
                    //栏目
                    array('catid', 'require', '请选择栏目！', 1, 'regex', 1),
                    array('catid', 'isUltimate', '该模型非终极栏目，无法添加信息！', 1, 'callback', 1),
                    //标题
                    array('title', 'require', '标题必须填写！', 1, 'regex', 1),
                );
            }
            //设置模型id
            $_instance[$modelid]->modelid = $modelid;
        }
        return $_instance[$modelid];
    }

    /**
     * 关联定义
     * @param array $tableName 关联定义条件。
     * 如果是数组，直接定义配置好的关联条件，如果是字符串，则当作表名进行定义一对一关联条件！
     */
    public function relationShipsDefine($tableName) {
        if (is_array($tableName)) {
            $this->_link = $tableName;
        } else {
            $tableName = ucwords($tableName);
            //进行内容表关联定义
            $this->_link = array(
                //主表 附表关联
                $this->getRelationName($tableName) => array(
                    "mapping_type" => HAS_ONE,
                    "class_name" => $tableName . "_data",
                    "foreign_key" => "id"
                ),
            );
        }
        return $this->_link;
    }

    /**
     * 获取关联定义名称
     * @param type $tableName 表名
     * @return type
     */
    public function getRelationName($tableName = '') {
        if (empty($tableName)) {
            $tableName = $this->name;
        }
        return ucwords($tableName) . 'Data';
    }

    /**
     * 是否终极栏目
     * @param type $catid
     * @return boolean
     */
    public function isUltimate($catid) {
        if (getCategory($catid, 'child')) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 内容模型处理类生成
     */
    public function model_content_cache() {
        //字段类型存放目录
        $fields_path = APP_PATH . 'Content/Fields/';
        //内置字段类型列表
        $fields = include $fields_path . 'fields.inc.php';
        $fields = $fields? : array();
        //更新内容模型数据处理相关类
        $classtypes = array('form', 'input', 'output', 'update', 'delete');
        //缓存生成路径
        $cachemodepath = RUNTIME_PATH;
        foreach ($classtypes as $classtype) {
            $content_cache_data = file_get_contents($fields_path . "content_$classtype.class.php");
            $cache_data = '';
            //循环字段列表，把各个字段的 form.inc.php 文件合并到 缓存 content_form.class.php 文件
            foreach ($fields as $field => $fieldvalue) {
                //检查文件是否存在
                if (file_exists($fields_path . $field . DIRECTORY_SEPARATOR . $classtype . '.inc.php')) {
                    //读取文件，$classtype.inc.php 
                    $ca = file_get_contents($fields_path . $field . DIRECTORY_SEPARATOR . $classtype . '.inc.php');
                    $cache_data .= str_replace(array("<?php", "?>"), "", $ca);
                }
            }
            $content_cache_data = str_replace('##{字段处理函数}##', $cache_data, $content_cache_data);
            //写入缓存
            file_put_contents($cachemodepath . 'content_' . $classtype . '.class.php', $content_cache_data);
            //设置权限
            chmod($cachemodepath . 'content_' . $classtype . '.class.php', 0777);
            unset($cache_data);
        }
    }

}
