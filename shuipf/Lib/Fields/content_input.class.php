<?php

/**
 * 处理数据，为入库前做数据处理
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class content_input {

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

    /**
     * 构造函数
     * @param type $modelid 模型ID
     * @param type $Action 传入this
     */
    function __construct($modelid) {
        $this->model = F("Model");
        $this->modelid = $modelid;
        if (empty($this->model[$this->modelid])) {
            $this->error('该模型不存在！');
            return false;
        }
        $this->fields = F("Model_field_" . $this->modelid);
        $this->tablename = trim($this->model[$this->modelid]['tablename']);
    }

    /**
     * 魔术方法，获取配置
     * @param type $name
     * @return type
     */
    public function __get($name) {
        return isset($this->data[$name]) ? $this->data[$name] : (isset($this->$name) ? $this->$name : NULL);
    }

    /**
     *  魔术方法，设置options参数
     * @param type $name
     * @param type $value
     */
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * 数据入库前处理
     * @param type $data
     * @param type $type 状态1插入数据，2更新数据，3包含以上两种
     * @return boolean|string 
     */
    public function get($data, $type = 3) {
        //数据
        $this->data = $data;
        //栏目id
        $this->catid = (int) $data['catid'];
        //获取内容模型对象
        $ContentModel = ContentModel::getInstance($this->modelid);
        $info = array();
        foreach ($this->fields as $field => $fieldInfo) {
            //特殊分页字段
            //此处还需优化，最好是交给字段input.inc.php处理
            if ('pages' == $field) {
                $info[$ContentModel->getRelationName()]['paginationtype'] = $this->data['paginationtype'];
                $info[$ContentModel->getRelationName()]['maxcharperpage'] = $this->data['maxcharperpage'];
                unset($data['paginationtype'], $data['maxcharperpage']);
            }
            //如果是更新状态下，没有数据的，跳过
            if ($type == 2) {
                if (!isset($this->data[$field])) {
                    continue;
                }
            }
            //字段内容
            $value = $this->data[$field];
            //字段别名
            $name = $fieldInfo['name'];
            //最小值
            $minlength = (int) $fieldInfo['minlength'];
            //最大值
            $maxlength = (int) $fieldInfo['maxlength'];
            //数据校验正则
            $pattern = $fieldInfo['pattern'];
            //数据校验未通过的提示信息
            $errortips = empty($fieldInfo['errortips']) ? $name . ' 不符合要求！' : $fieldInfo['errortips'];
            //配置
            $setting = unserialize($fieldInfo['setting']);
            //是否主表
            $issystem = $fieldInfo['issystem'] ? true : false;

            //验证条件
            if (in_array($type, array(1, 3))) {
                //新增时，必须验证
                $condition = 1;
            } else {
                //当存在值时验证
                $condition = 2;
            }
            //进行长度验证 
            if ($minlength) {
                $ContentModel->addValidate(array($field, 'require', $name . ' 不能为空！', $condition, 'regex', 3), $issystem);
                $ContentModel->addValidate(array($field, 'isMin', $name . ' 不得小于 ' . $minlength . "个字符！", $condition, 'function', 3, array($minlength)), $issystem);
            }
            if ($maxlength) {
                $ContentModel->addValidate(array($field, 'isMax', $name . ' 不得多于 ' . $maxlength . "个字符！", $condition, 'function', 3, array($maxlength)), $issystem);
            }
            //数据校验正则
            if ($pattern) {
                $ContentModel->addValidate(array($field, $pattern, $errortips, 2, 'regex', 3), $issystem);
            }
            //值唯一
            if ($fieldInfo['isunique']) {
                $ContentModel->addValidate(array($field, '', $name . " 该值必须不重复！", 2, 'unique', 3), $issystem);
            }

            //字段类型
            $func = $fieldInfo['formtype'];
            //检测对应字段方法是否存在，存在则执行此方法，并传入字段名和字段值
            if (method_exists($this, $func)) {
                $value = $this->$func($field, $value);
            }

            //字段扩展，可以对字段内容进行再次处理，类似ECMS字段处理函数
            if ($setting['backstagefun'] || $setting['frontfun']) {
                load("@.treatfun");
                $backstagefun = explode("###", $setting['backstagefun']);
                $usfun = $backstagefun[0];
                $usparam = $backstagefun[1];
                //前后台
                if (defined("IN_ADMIN") && IN_ADMIN) {
                    //检查方法是否存在
                    if (function_exists($usfun)) {
                        //判断是入库执行类型
                        if ((int) $setting['backstagefun_type'] == 1 || (int) $setting['backstagefun_type'] == 3) {
                            //调用自定义函数，参数传入：模型id，栏目ID，信息ID，字段内容，字段名，操作类型，附加参数
                            // 例子 demo($modelid ,$value , $catid , $id, $field ,$action ,$param){}
                            $id = 0;
                            try {
                                $value = call_user_func($usfun, $this->modelid, $this->catid, $id, $value, $field, ACTION_NAME, $usparam);
                            } catch (Exception $exc) {
                                //记录日志
                                Log::write("模型id:" . $this->modelid . ",错误信息：调用自定义函数" . $usfun . "出现错误！");
                            }
                        }
                    }
                } else {
                    //前台投稿处理自定义函数处理
                    //判断当前用户组是否拥有使用字段处理函数的权限，该功能暂时木有，以后加上
                    if (true) {
                        $backstagefun = explode("###", $setting['frontfun']);
                        $usfun = $backstagefun[0];
                        $usparam = $backstagefun[1];
                        //检查方法是否存在
                        if (function_exists($usfun)) {
                            //判断是入库执行类型
                            if ((int) $setting['backstagefun_type'] == 1 || (int) $setting['backstagefun_type'] == 3) {
                                //调用自定义函数，参数传入：模型id，栏目ID，信息ID，字段内容，字段名，操作类型，附加参数
                                // 例子 demo($modelid ,$value , $catid , $id, $field ,$action ,$param){}
                                $id = 0;
                                try {
                                    $value = call_user_func($usfun, $this->modelid, $this->catid, $id, $value, $field, ACTION_NAME, $usparam);
                                } catch (Exception $exc) {
                                    //记录日志
                                    Log::write("模型id:" . $this->modelid . ",错误信息：调用自定义函数" . $usfun . "出现错误！");
                                }
                            }
                        }
                    }
                }
            }

            //当没有返回时，或者为 null 时，等于空字符串，null有时会出现mysql 语法错误。
            if (is_null($value)) {
                $value = '';
            }
            try {
                unset($data[$field]);
            } catch (Exception $exc) {
                
            }
            //把系统字段和模型字段分开
            if ($issystem) {
                $info[$field] = $value;
            } else {
                $info[$ContentModel->getRelationName()][$field] = $value;
            }
        }
        //取得标题颜色
        if (isset($_POST['style_color'])) {
            //颜色选择为隐藏域 在这里进行取值
            $info['style'] = $_POST['style_color'] ? strip_tags($_POST['style_color']) : '';
            //标题加粗等样式
            if (isset($_POST['style_font_weight'])) {
                $info['style'] = $info['style'] . ($_POST['style_font_weight'] ? ';' : '') . strip_tags($_POST['style_font_weight']);
            }
        }
        //如果$data还有存在模型字段以外的值，进行合并
        if (!empty($data)) {
            $info = array_merge($data, $info);
        }
        return $info;
    }

    /**
     * 错误信息
     * @param type $message 错误信息
     * @param type $fields 字段
     */
    public function error($message, $fields = false) {
        $this->error = $message;
    }

    /**
     * 获取错误信息
     * @return type
     */
    public function getError() {
        return $this->error;
    }

    ##{字段处理函数}##
}
