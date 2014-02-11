<?php

/* * 
 * 网站配置模型
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */

class ConfigModel extends CommonModel {

    /**
     * 增加扩展配置项
     * @param type $data
     * @return boolean
     */
    public function extendAdd($data) {
        if (empty($data)) {
            $this->error = '数据不能为空！';
            return false;
        }
        if (empty($data['setting']['title'])) {
            $this->error = '名称不能为空！';
            return false;
        }
        $db = M('ConfigField');
        //验证规则
        $validate = array(
            array('fieldname', 'require', '键名不能为空！', 1, 'regex', 3),
            array('type', 'require', '类型不能为空！', 1, 'regex', 3),
            array('fieldname', '/^[a-z_0-9]+$/i', '键名只支持英文、数字、下划线！', 0, 'regex', 3),
        );
        $data = $db->validate($validate)->create($data);
        if ($data) {
            $data['setting'] = serialize($data['setting']);
            $id = $db->add($data);
            if ($id) {
                return $id;
            } else {
                $this->error = '添加失败！';
                return false;
            }
        } else {
            $this->error = $db->getError();
            return false;
        }
    }

    /**
     * 更新网站配置项
     * @param type $data 数据
     * @return boolean
     */
    public function saveConfig($data) {
        if (empty($data) || !is_array($data)) {
            $this->error = '配置数据不能为空！';
            return false;
        }
        //令牌验证
        if (!$this->autoCheckToken($data)) {
            $this->error = L('_TOKEN_ERROR_');
            return false;
        }
        //去除token
        unset($data[C("TOKEN_NAME")]);
        foreach ($data as $key => $value) {
            if (empty($key)) {
                continue;
            }
            $saveData = array();
            $saveData["value"] = trim($value);
            if ($this->where(array("varname" => $key))->save($saveData) === false) {
                $this->error = "更新到{$key}项时，更新失败！";
                return false;
            }
        }
        return true;
    }

    /**
     * 保存高级配置
     * @param type $data 配置信息
     * @return boolean
     */
    public function addition($data) {
        if (empty($data)) {
            $this->error = '没有数据！';
            return false;
        }
        //配置文件地址
        $filename = SITE_PATH . '/shuipf/Conf/addition.php';
        //检查文件是否可写
        if (is_writable($filename) == false) {
            $this->error = '请检查[shuipf/Conf/addition.php]文件权限是否可写！';
            return false;
        }
        if (isset($data[C('TOKEN_NAME')])) {
            unset($data[C('TOKEN_NAME')]);
        }
        //默认值
        $data['DEFAULT_GROUP'] = $data['DEFAULT_GROUP'] ? $data['DEFAULT_GROUP'] : "Contents";
        $data['TOKEN_ON'] = (int) $data['TOKEN_ON'] ? true : false;
        $data['URL_MODEL'] = isset($data['URL_MODEL']) ? (int) $data['URL_MODEL'] : 0;
        $data['DEFAULT_TIMEZONE'] = $data['DEFAULT_TIMEZONE'] ? $data['DEFAULT_TIMEZONE'] : "PRC";
        $data['DATA_CACHE_TYPE'] = $data['DATA_CACHE_TYPE'] ? $data['DATA_CACHE_TYPE'] : "File";
        $data['DEFAULT_LANG'] = $data['DEFAULT_LANG'] ? $data['DEFAULT_LANG'] : "zh-cn";
        $data['DEFAULT_AJAX_RETURN'] = $data['DEFAULT_AJAX_RETURN'] ? $data['DEFAULT_AJAX_RETURN'] : "JSON";
        $data['SESSION_OPTIONS'] = $data['SESSION_OPTIONS'] ? $data['SESSION_OPTIONS'] : array();
        $data['URL_PATHINFO_DEPR'] = $data['URL_PATHINFO_DEPR'] ? $data['URL_PATHINFO_DEPR'] : "/";
        //URL区分大小写设置
        $data['URL_CASE_INSENSITIVE'] = (int) $data['URL_CASE_INSENSITIVE'] ? true : false;
        //云平台开关
        $data['CLOUD_ON'] = (int) $data['CLOUD_ON'] ? true : false;
        //函数加载
        $data['LOAD_EXT_FILE'] = trim($data['LOAD_EXT_FILE']);
        //默认分页模板
        $data['PAGE_TEMPLATE'] = str_replace("\n", "", trim($data['PAGE_TEMPLATE']));

        //**********************检测一些设置，会导致网站瘫痪的**********************
        //缓存类型检测
        if ($data['DATA_CACHE_TYPE'] == 'Memcache') {
            if (class_exists('Memcache') == false) {
                $this->error = '您的环境不支持Memcache，无法开启！';
                return false;
            }
        }
        //***********************END************************************

        file_exists($filename) or touch($filename);
        $return = var_export($data, TRUE);
        if ($return) {
            if (file_put_contents($filename, "<?php \r\n return " . $return . ";")) {
                return true;
            } else {
                $this->error = '搞基配置更新失败！';
                return false;
            }
        } else {
            $this->error = '配置数据为空！';
            return false;
        }
    }

    /**
     * 更新缓存
     * @return type
     */
    public function config_cache() {
        $data = M("Config")->getField("varname,value");
        F("Config", $data);
        return $data;
    }

    /**
     * 后台有更新/编辑则删除缓存
     * @param type $data
     */
    public function _before_write($data) {
        parent::_before_write($data);
        F("Config", NULL);
    }

    //删除操作时删除缓存
    public function _after_delete($data, $options) {
        parent::_after_delete($data, $options);
        $this->config_cache();
    }

    //更新数据后更新缓存
    public function _after_update($data, $options) {
        parent::_after_update($data, $options);
        $this->config_cache();
    }

    //插入数据后更新缓存
    public function _after_insert($data, $options) {
        parent::_after_insert($data, $options);
        $this->config_cache();
    }

}
