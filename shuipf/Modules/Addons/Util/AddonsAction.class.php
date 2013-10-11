<?php

/**
 * 前台插件抽类
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class Addons extends BaseAction {

    //插件标识
    public $addonName = NULL;
    //插件基本信息
    protected $addonInfo = NULL;
    //插件路径
    protected $addonPath = NULL;

    protected function _initialize() {
        parent::_initialize();
        $this->act = ADDON_ACT;
        $this->addonName = MODULE_NAME;
        $this->addonInfo = D('Addons')->where(array('name' => $this->addonName))->find();
        if (empty($this->addonInfo)) {
            $this->error('该插件没有安装！');
        }
        $this->addonPath = D('Addons')->getAddonsPath() . $this->addonName . '/';
        //插件配置文件
        if (is_file($this->addonPath . 'Config.php')) {
            $this->configFile = $this->addonPath . 'Config.php';
        }
    }

    /**
     * 模板显示
     * @param type $templateFile 指定要调用的模板文件
     * @param type $charset 输出编码
     * @param type $contentType 输出类型
     * @param string $content 输出内容
     * 此方法作用在于实现后台模板直接存放在各自项目目录下。例如Admin项目的后台模板，直接存放在Admin/Tpl/目录下
     */
    protected function display($templateFile = '', $charset = '', $contentType = '', $content = '') {
        $this->view->display(parseAddonTemplateFile($templateFile,$this->addonPath), $charset, $contentType, $content);
    }

    /**
     * 获取插件配置
     * @staticvar array $_config
     * @param type $name
     * @return type
     */
    final public function getConfig($name = NULL) {
        static $_config = array();
        if (empty($name)) {
            $name = $this->addonName;
        }
        //检查是否已经存在
        if (isset($_config[$name])) {
            return $_config[$name];
        }
        //查询条件
        $where = array(
            'name' => $name,
            'status' => 1,
        );
        $config = M('Addons')->where($where)->getField('config');
        if ($config) {
            //反序列化
            $config = unserialize($config);
        }
        //直接取插件目录下的Config.php中的配置
        if (empty($config)) {
            $fileConfig = include $this->configFile;
            foreach ($fileConfig as $key => $value) {
                $config[$key] = $value['value'];
            }
        }
        $_config[$name] = $config;
        return $config;
    }

}