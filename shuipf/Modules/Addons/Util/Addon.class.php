<?php

/**
 * 插件抽象类
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
abstract class Addon {

    //插件名称
    public $addonName = NULL;
    //插件配置文件
    public $configFile = NULL;
    //插件目录
    public $addonPath = NULL;

    /**
     * 架构函数 取得模板对象实例
     * @access public
     */
    final public function __construct() {
        //获取插件名称
        $this->addonName = $this->getAddonName();
        //插件目录
        $this->addonPath = D('Addons/Addons')->getAddonsPath() . $this->addonName . '/';
        //插件配置文件
        if (is_file($this->addonPath . 'Config.php')) {
            $this->configFile = $this->addonPath . 'Config.php';
        }
        //插件初始化
        if (method_exists($this, '_initialize'))
            $this->_initialize();
    }

    /**
     * 获取插件名称
     * @return type
     */
    final public function getAddonName() {
        $class = get_class($this);
        return substr($class, 0, strrpos($class, 'Addon'));
    }

    /**
     * 获取插件配置
     * @staticvar array $_config
     * @param type $name
     * @return type
     */
    final public function getAddonConfig($name = NULL) {
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

    //必须实现安装
    abstract public function install();

    //必须卸载插件方法
    abstract public function uninstall();
}