<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 标签解析库
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Common\TagLib;

use Think\Template\TagLib;

class Shuipf extends TagLib {

    // 标签定义
    protected $tags = array(
        //后台模板标签
        'admintemplate' => array("attr" => "file", "close" => 0),
    );

    /**
     * 模板包含标签 
     * 格式：<admintemplate file="模块/控制器/模板名"/>
     * @param type $attr 属性字符串
     * @param type $content 标签内容
     * @return string 标签解析后的内容 
     */
    public function _admintemplate($attr, $content) {
        $file = explode("/", $attr['file']);
        $counts = count($file);
        if ($counts < 2) {
            return '';
        } else if ($counts < 3) {
            $file_path = "Admin/" . C('DEFAULT_V_LAYER') . "/{$attr['file']}";
        } else {
            $file_path = "$file[0]/" . C('DEFAULT_V_LAYER') . "/{$file[1]}/{$file[2]}";
        }
        //模板路径
        $TemplatePath = APP_PATH . $file_path . C("TMPL_TEMPLATE_SUFFIX");
        //判断模板是否存在
        if (file_exists_case($TemplatePath)) {
            //读取内容
            $tmplContent = file_get_contents($TemplatePath);
            //解析模板内容
            $parseStr = $this->tpl->parse($tmplContent);
            return $parseStr;
        }
        return '';
    }

}
