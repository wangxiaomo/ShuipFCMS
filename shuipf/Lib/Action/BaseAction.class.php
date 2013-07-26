<?php

/**
 * 前台Action
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class BaseAction extends AppframeAction {

    public $TemplatePath, $Theme, $ThemeDefault;

    protected function _initialize() {
        parent::_initialize();
        //定义是前台
        define('IN_ADMIN', false);
        //前台关闭表单令牌
        C("TOKEN_ON", false);
        $this->initUser();
        //初始化模型
        $this->initModel();
        $this->tmpinit();
        //============全局模板变量==============
        //栏目数组
        $this->assign("Categorys", F("Category"));
        //模型数组
        $this->assign("Model", F("Model"));
        //推荐位数组
        $this->assign("Position", F("Position"));
        //URL规则数组
        $this->assign("Urlrules", F("urlrules"));
    }

    /**
     * 模板配置初始化 
     */
    final private function tmpinit() {
        //模板路径
        $this->TemplatePath = TEMPLATE_PATH;
        //默认主题风格
        $this->ThemeDefault = "Default";
        //主题风格
        $this->Theme = empty(AppframeAction::$Cache["Config"]['theme']) ? $this->ThemeDefault : AppframeAction::$Cache["Config"]['theme'];
        //设置前台提示信息模板
        if (file_exists_case($this->TemplatePath . $this->Theme . "/" . "error" . C("TMPL_TEMPLATE_SUFFIX")) && IN_ADMIN == false) {
            C("TMPL_ACTION_ERROR", $this->TemplatePath . $this->Theme . "/" . "error" . C("TMPL_TEMPLATE_SUFFIX"));
        }
        if (file_exists_case($this->TemplatePath . $this->Theme . "/" . "success" . C("TMPL_TEMPLATE_SUFFIX")) && IN_ADMIN == false) {
            C("TMPL_ACTION_SUCCESS", $this->TemplatePath . $this->Theme . "/" . "success" . C("TMPL_TEMPLATE_SUFFIX"));
        }
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
    private function parseTemplateFile($templateFile = '') {
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
     * @staticvar array $_pageCache
     * @param type $Total_Size 信息总数
     * @param type $Page_Size 每页显示信息数量
     * @param type $Current_Page 当前分页号
     * @param type $List_Page 每次显示几个分页导航链接
     * @param type $PageParam 接收分页号参数的标识符
     * @param type $PageLink 分页规则 
     *                          array(
      "index"=>"http://www.abc3210.com/192.html",//这种是表示当前是首页，无需加分页1
      "list"=>"http://www.abc3210.com/192-{page}.html",//这种表示分页非首页时启用
      )
     * @param type $static 是否开启静态
     * @param string $TP 模板
     * @param array $Tp_Config 模板配置
     * @return array|\Page
     */
    protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 0, $List_Page = 6, $PageParam = '', $PageLink = '', $static = FALSE, $TP = "", $Tp_Config = "") {
        $Page = page($Total_Size, $Page_Size, $Current_Page, $List_Page, $PageParam, $PageLink, $static, $TP, $Tp_Config);
        $Page->SetPager('Admin', '共有{recordcount}条信息&nbsp;{pageindex}/{pagecount}&nbsp;{first}{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}{last}&nbsp;转到{jump}页', array("listlong" => "6", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
        return $Page;
    }

}

?>
