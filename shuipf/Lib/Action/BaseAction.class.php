<?php

/**
 * 前台Action
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
//定义是后台
defined('IN_ADMIN') or define('IN_ADMIN', false);

class BaseAction extends AppframeAction {

    public $TemplatePath, $Theme, $ThemeDefault;

    //初始化
    protected function _initialize() {
        parent::_initialize();
        //非后台
        if (IN_ADMIN === false) {
            //前台关闭表单令牌
            C("TOKEN_ON", false);
            //初始化前台会员登录信息
            $this->initUser();
        }
        //前台模板初始化
        $this->templateInitialize();
    }

    /**
     * 前台模板初始化
     */
    protected function templateInitialize() {
        //当前启用主题名称
        $themeName = empty(AppframeAction::$Cache["Config"]['theme']) ? "Default" : AppframeAction::$Cache["Config"]['theme'];
        //设置前台提示信息模板
        if (is_file(TEMPLATE_PATH . $themeName . "/" . "error" . C("TMPL_TEMPLATE_SUFFIX")) && IN_ADMIN == false) {
            C("TMPL_ACTION_ERROR", TEMPLATE_PATH . $themeName . "/" . "error" . C("TMPL_TEMPLATE_SUFFIX"));
        }
        if (is_file(TEMPLATE_PATH . $themeName . "/" . "success" . C("TMPL_TEMPLATE_SUFFIX")) && IN_ADMIN == false) {
            C("TMPL_ACTION_SUCCESS", TEMPLATE_PATH . $themeName . "/" . "success" . C("TMPL_TEMPLATE_SUFFIX"));
        }
        //模板路径
        $this->TemplatePath = TEMPLATE_PATH;
        //默认主题风格
        $this->ThemeDefault = "Default";
        //主题风格
        $this->Theme = $themeName;
        //模块静态资源目录，例如CSS JS等
        $this->assign('model_extresdir', CONFIG_SITEURL_MODEL . MODEL_EXTRESDIR);
    }

    /**
     * 模板显示 调用内置的模板引擎显示方法，
     * @access protected
     * @param string $templateFile 指定要调用的模板文件 默认为空 由系统自动定位模板文件
     * @param string $charset 输出编码
     * @param string $contentType 输出类型
     * @param string $content 输出内容
     * @param string $prefix 模板缓存前缀
     * @return void
     */
    protected function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
        parent::display($this->parseTemplateFile($templateFile), $charset, $contentType, $content, $prefix);
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
    protected function fetch($templateFile = '', $content = '', $prefix = '') {
        return parent::fetch($this->parseTemplateFile($templateFile), $content, $prefix);
    }

    /**
     * 模板路径
     * @param type $templateFile
     * @return boolean|string 
     */
    protected function parseTemplateFile($templateFile = '') {
        $templateFile = parseTemplateFile($templateFile);
        if (false === $templateFile) {
            if (APP_DEBUG) {
                // 模块不存在 抛出异常
                throw_exception("当前页面模板不存在（详细信息已经记录到网站日志）！");
            } else {
                send_http_status(404);
                exit;
            }
        }
        return $templateFile;
    }

    /**
     * 分页输出
     * @param type $total 信息总数
     * @param type $size 每页数量
     * @param type $number 当前分页号（页码）
     * @param type $config 配置，会覆盖默认设置
     * @return type
     */
    protected function page($total, $size = 0, $number = 0, $config = array()) {
        return page($total, $size, $number, $config);
    }

}
