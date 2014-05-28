<?php

// +----------------------------------------------------------------------
// | ShuipFCMS Controller
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Common\Controller;

use Libs\System\Components;

class ShuipFCMS extends \Think\Controller {

    //缓存
    public static $Cache = array();
    //当前对象
    private static $_app;

    public function __get($name) {
        $parent = parent::__get($name);
        if (empty($parent)) {
            return Components::getInstance()->$name;
        }
        return $parent;
    }

    public function __construct() {
        parent::__construct();
        self::$_app = $this;
    }

    //初始化
    protected function _initialize() {
        $this->initSite();
        //默认跳转时间
        $this->assign("waitSecond", 3000);
    }

    /**
     * 获取ShuipFCMS 对象
     * @return type
     */
    public static function app() {
        return self::$_app;
    }

    /**
     * 初始化站点配置信息
     * @return Arry 配置数组
     */
    protected function initSite() {
        $Config = cache("Config");
        $config_siteurl = $Config['siteurl'];
        defined('CONFIG_SITEURL_MODEL') or define("CONFIG_SITEURL_MODEL", $config_siteurl);
        self::$Cache['Config'] = $Config;
        $this->assign("config_siteurl", $config_siteurl);
        $this->assign("Config", $Config);
    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @return void
     */
    protected function ajaxReturn($data, $type = '') {
        $data['state'] = $data['status'] ? "success" : "fail";
        if (empty($type))
            $type = C('DEFAULT_AJAX_RETURN');
        switch (strtoupper($type)) {
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:text/html; charset=utf-8');
                exit(json_encode($data));
            case 'XML' :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:text/html; charset=utf-8');
                $handler = isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
                exit($handler . '(' . json_encode($data) . ');');
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
            default :
                // 用于扩展其他返回格式数据
                tag('ajax_return', $data);
        }
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

    /**
     * 验证码验证
     * @param type $verify 验证码
     * @param type $type 验证码类型
     * @return boolean
     */
    static public function verify($verify, $type = "verify") {
        return A('Api/Checkcode')->validate($type, $verify);
    }

    //空操作
    public function _empty() {
        $this->error('该页面不存在！');
    }

}
