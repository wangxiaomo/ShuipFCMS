<?php

/**
 * 插件抽象类
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
abstract class Addon {

    //视图实例对象
    protected $view = null;
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
        //实例化视图类
        $this->view = Think::instance('View');
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

    /**
     * 模板变量赋值
     * @access protected
     * @param mixed $name 要显示的模板变量
     * @param mixed $value 变量的值
     * @return Action
     */
    final protected function assign($name, $value = '') {
        $this->view->assign($name, $value);
        return $this;
    }

    /**
     * 模板显示 调用内置的模板引擎显示方法，
     * @access protected
     * @param string $templateFile 指定要调用的模板文件
     * 默认为空 由系统自动定位模板文件
     * @param string $charset 输出编码
     * @param string $contentType 输出类型
     * @param string $content 输出内容
     * @param string $prefix 模板缓存前缀
     * @return void
     */
    protected function display($templateFile = '') {
        $this->fetch($templateFile);
    }

    /**
     * 输出内容文本可以包括Html
     * @access private
     * @param string $content 输出内容
     * @param string $charset 模板输出字符集
     * @param string $contentType 输出类型
     * @return mixed
     */
    private function render($content, $charset = '', $contentType = '') {
        if (empty($charset))
            $charset = C('DEFAULT_CHARSET');
        if (empty($contentType))
            $contentType = C('TMPL_CONTENT_TYPE');
        // 网页字符编码
        header('Content-Type:' . $contentType . '; charset=' . $charset);
        header('Cache-control: ' . C('HTTP_CACHE_CONTROL'));  // 页面缓存控制
        header('X-Powered-By:ShuipFCMS');
        // 输出模板文件
        echo $content;
    }

    /**
     *  获取输出页面内容
     * 调用内置的模板引擎fetch方法，
     * @access protected
     * @param string $templateFile 指定要调用的模板文件
     * 默认为空 由系统自动定位模板文件
     * @param string $content 模板输出内容
     * @param string $prefix 模板缓存前缀* 
     * @return string
     */
    final protected function fetch($templateFile = '', $content = '', $prefix = '') {
        if (empty($templateFile)) {
            //如果没有填写，尝试直接以当前插件名称
            $templateFile = $this->addonPath . 'Tpl/Behavior/' . $this->addonName . C('TMPL_TEMPLATE_SUFFIX');
        } else {
            $templateFile = $this->addonPath . 'Tpl/Behavior/' . $templateFile . C('TMPL_TEMPLATE_SUFFIX');
        }
        //检查模板
        if (!is_file($templateFile)) {
            if (APP_DEBUG) {
                $log = '插件模板:[' . $templateFile . ']不存在！';
                throw_exception($log);
            }
        }
        // 解析并获取模板内容
        $content = $this->view->fetch($templateFile, $content, $prefix);
        $this->render($content);
    }

    //必须实现安装
    abstract public function install();

    //必须卸载插件方法
    abstract public function uninstall();
}