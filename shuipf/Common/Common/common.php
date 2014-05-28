<?php

// +----------------------------------------------------------------------
// | ShuipFCMS
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

/**
 * 系统缓存缓存管理
 * @param mixed $name 缓存名称
 * @param mixed $value 缓存值
 * @param mixed $options 缓存参数
 * @return mixed
 */
function cache($name, $value = '', $options = null) {
    static $cache = '';
    if (empty($cache)) {
        $cache = \Libs\System\Cache::getInstance();
    }
    // 获取缓存
    if ('' === $value) {
        if (false !== strpos($name, '.')) {
            $vars = explode('.', $name);
            $data = $cache->get($vars[0]);
            return is_array($data) ? $data[$vars[1]] : $data;
        } else {
            return $cache->get($name);
        }
    } elseif (is_null($value)) {//删除缓存
        return $cache->remove($name);
    } else {//缓存数据
        if (is_array($options)) {
            $expire = isset($options['expire']) ? $options['expire'] : NULL;
        } else {
            $expire = is_numeric($options) ? $options : NULL;
        }
        return $cache->set($name, $value, $expire);
    }
}

/**
 * 调试，用于保存数组到txt文件 正式生产删除
 * 用法：array2file($info, SITE_PATH.'/post.txt');
 * @param type $array
 * @param type $filename
 */
function array2file($array, $filename) {
    if (defined("APP_DEBUG") && APP_DEBUG) {
        //修改文件时间
        file_exists($filename) or touch($filename);
        if (is_array($array)) {
            $str = var_export($array, TRUE);
        } else {
            $str = $array;
        }
        return file_put_contents($filename, $str);
    }
    return false;
}

/**
 * 返回ShuipFCMS对象
 * @return Object
 */
function ShuipFCMS() {
    return \Common\Controller\ShuipFCMS::app();
}

/**
 * 快捷方法取得服务
 * @param type $name 服务类型
 * @param type $params 参数
 * @return type
 */
function service($name, $params = array()) {
    return \Libs\System\Service::getInstance($name, $params);
}

/**
 * 生成上传附件验证
 * @param $args   参数
 */
function upload_key($args) {
    return md5($args . md5(C("AUTHCODE") . $_SERVER['HTTP_USER_AGENT']));
}

/**
 * 检查模块是否已经安装
 * @param type $moduleName 模块名称
 * @return boolean
 */
function isModuleInstall($moduleName) {
    $appCache = cache('Module');
    if (isset($appCache[$moduleName])) {
        return true;
    }
    return false;
}

/**
 * 产生一个指定长度的随机字符串,并返回给用户 
 * @param type $len 产生字符串的长度
 * @return string 随机字符串
 */
function genRandomString($len = 6) {
    $chars = array(
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
        "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
        "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
        "3", "4", "5", "6", "7", "8", "9"
    );
    $charsLen = count($chars) - 1;
    // 将数组打乱 
    shuffle($chars);
    $output = "";
    for ($i = 0; $i < $len; $i++) {
        $output .= $chars[mt_rand(0, $charsLen)];
    }
    return $output;
}

/**
 * 分页处理
 * @param type $total 信息总数
 * @param type $size 每页数量
 * @param type $number 当前分页号（页码）
 * @param type $config 配置，会覆盖默认设置
 * @return \Page|array
 */
function page($total, $size = 0, $number = 0, $config = array()) {
    //配置
    $defaultConfig = array(
        //当前分页号
        'number' => $number,
        //接收分页号参数的标识符
        'param' => C("VAR_PAGE"),
        //分页规则
        'rule' => '',
        //是否启用自定义规则
        'isrule' => false,
        //分页模板
        'tpl' => '',
        //分页具体可控制配置参数默认配置
        'tplconfig' => array('listlong' => 6, 'listsidelong' => 2, "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""),
    );
    //分页具体可控制配置参数
    $cfg = array(
        //每次显示几个分页导航链接
        'listlong' => 6,
        //分页链接列表首尾导航页码数量，默认为2，html 参数中有”{liststart}”或”{listend}”时才有效
        'listsidelong' => 2,
        //分页链接列表
        'list' => '*',
        //当前页码的CSS样式名称，默认为”current”
        'currentclass' => 'current',
        //第一页链接的HTML代码，默认为 ”«”，即显示为 «
        'first' => '&laquo;',
        //上一页链接的HTML代码，默认为”‹”,即显示为 ‹
        'prev' => '&#8249;',
        //下一页链接的HTML代码，默认为”›”,即显示为 ›
        'next' => '&#8250;',
        //最后一页链接的HTML代码，默认为”»”,即显示为 »
        'last' => '&raquo;',
        //被省略的页码链接显示为，默认为”…”
        'more' => '...',
        //当处于首尾页时不可用链接的CSS样式名称，默认为”disabled”
        'disabledclass' => 'disabled',
        //页面跳转方式，默认为”input”文本框，可设置为”select”下拉菜单
        'jump' => '',
        //页面跳转文本框或下拉菜单的附加内部代码
        'jumpplus' => '',
        //跳转时要执行的javascript代码，用*代表页码，可用于Ajax分页
        'jumpaction' => '',
        //当跳转方式为下拉菜单时最多同时显示的页码数量，0为全部显示，默认为50
        'jumplong' => 50,
    );
    //覆盖配置
    if (!empty($config) && is_array($config)) {
        $defaultConfig = array_merge($defaultConfig, $config);
    }
    //每页显示信息数量
    $defaultConfig['size'] = $size ? $size : C("PAGE_LISTROWS");
    //把默认配置选项设置到tplconfig
    foreach ($cfg as $key => $value) {
        if (isset($defaultConfig[$key])) {
            $defaultConfig['tplconfig'][$key] = isset($defaultConfig[$key]) ? $defaultConfig[$key] : $value;
        }
    }
    //是否启用自定义规则，规则是一个数组，index和list。不启用的情况下，直接以当前$_GET的参数组成地址
    if ($defaultConfig['isrule'] && empty($defaultConfig['rule'])) {
        //通过全局参数获取分页规则
        $URLRULE = $GLOBALS['URLRULE'] ? $GLOBALS['URLRULE'] : URLRULE;
        $PageLink = array();
        if (!is_array($URLRULE)) {
            $URLRULE = explode('~', $URLRULE);
        }
        $PageLink['index'] = $URLRULE['index'] ? $URLRULE['index'] : $URLRULE[0];
        $PageLink['list'] = $URLRULE['list'] ? $URLRULE['list'] : $URLRULE[1];
        $defaultConfig['rule'] = $PageLink;
    } else if ($defaultConfig['isrule'] && !is_array($defaultConfig['rule'])) {
        $URLRULE = explode('|', $defaultConfig['rule']);
        $PageLink = array();
        $PageLink['index'] = $URLRULE[0];
        $PageLink['list'] = $URLRULE[1];
        $defaultConfig['rule'] = $PageLink;
    }
    $Page = new \Libs\Util\Page($total, $defaultConfig['size'], $defaultConfig['number'], $defaultConfig['list'], $defaultConfig['param'], $defaultConfig['rule'], $defaultConfig['isrule']);
    $Page->SetPager('default', $defaultConfig['tpl'], $defaultConfig['tplconfig']);
    return $Page;
}

/**
 * 获取栏目相关信息
 * @param type $catid 栏目id
 * @param type $field 返回的字段，默认返回全部，数组
 * @param type $newCache 是否强制刷新
 * @return boolean
 */
function getCategory($catid, $field = '', $newCache = false) {
    if (empty($catid)) {
        return false;
    }
    $key = 'getCategory_' . $catid;
    //强制刷新缓存
    if ($newCache) {
        S($key, NULL);
    }
    $cache = S($key);
    if ($cache === 'false') {
        return false;
    }
    if (empty($cache)) {
        //读取数据
        $cache = M('Category')->where(array('catid' => $catid))->find();
        if (empty($cache)) {
            S($key, 'false', 60);
            return false;
        } else {
            //扩展配置
            $cache['setting'] = unserialize($cache['setting']);
            //栏目扩展字段
            $cache['extend'] = $cache['setting']['extend'];
            S($key, $cache, 3600);
        }
    }
    if ($field) {
        //支持var.property，不过只支持一维数组
        if (false !== strpos($field, '.')) {
            $vars = explode('.', $field);
            return $cache[$vars[0]][$vars[1]];
        } else {
            return $cache[$field];
        }
    } else {
        return $cache;
    }
}

/**
 * 获取模型数据
 * @param type $modelid 模型ID
 * @param type $field 返回的字段，默认返回全部，数组
 * @return boolean
 */
function getModel($modelid, $field = '') {
    if (empty($modelid)) {
        return false;
    }
    $key = 'getModel_' . $modelid;
    $cache = S($key);
    if ($cache === 'false') {
        return false;
    }
    if (empty($cache)) {
        //读取数据
        $cache = M('Model')->where(array('modelid' => $modelid))->find();
        if (empty($cache)) {
            S($key, 'false', 60);
            return false;
        } else {
            S($key, $cache, 3600);
        }
    }
    if ($field) {
        return $cache[$field];
    } else {
        return $cache;
    }
}

/**
 * 检测一个数据长度是否超过最小值
 * @param type $value 数据
 * @param type $length 最小长度
 * @return type 
 */
function isMin($value, $length) {
    return mb_strlen($value, 'utf-8') >= (int) $length ? true : false;
}

/**
 * 检测一个数据长度是否超过最大值
 * @param type $value 数据
 * @param type $length 最大长度
 * @return type 
 */
function isMax($value, $length) {
    return mb_strlen($value, 'utf-8') <= (int) $length ? true : false;
}

/**
 * 取得文件扩展
 * @param type $filename 文件名
 * @return type 后缀
 */
function fileext($filename) {
    $pathinfo = pathinfo($filename);
    return $pathinfo['extension'];
}

/**
 * 对 javascript escape 解码
 * @param type $str 
 * @return type
 */
function unescape($str) {
    $ret = '';
    $len = strlen($str);
    for ($i = 0; $i < $len; $i++) {
        if ($str[$i] == '%' && $str[$i + 1] == 'u') {
            $val = hexdec(substr($str, $i + 2, 4));
            if ($val < 0x7f)
                $ret .= chr($val);
            else
            if ($val < 0x800)
                $ret .= chr(0xc0 | ($val >> 6)) . chr(0x80 | ($val & 0x3f));
            else
                $ret .= chr(0xe0 | ($val >> 12)) . chr(0x80 | (($val >> 6) & 0x3f)) . chr(0x80 | ($val & 0x3f));
            $i += 5;
        } else
        if ($str[$i] == '%') {
            $ret .= urldecode(substr($str, $i, 3));
            $i += 2;
        } else
            $ret .= $str[$i];
    }
    return $ret;
}

/**
 * 字符截取
 * @param $string 需要截取的字符串
 * @param $length 长度
 * @param $dot
 */
function str_cut($sourcestr, $length, $dot = '...') {
    $returnstr = '';
    $i = 0;
    $n = 0;
    $str_length = strlen($sourcestr); //字符串的字节数 
    while (($n < $length) && ($i <= $str_length)) {
        $temp_str = substr($sourcestr, $i, 1);
        $ascnum = Ord($temp_str); //得到字符串中第$i位字符的ascii码 
        if ($ascnum >= 224) {//如果ASCII位高与224，
            $returnstr = $returnstr . substr($sourcestr, $i, 3); //根据UTF-8编码规范，将3个连续的字符计为单个字符         
            $i = $i + 3; //实际Byte计为3
            $n++; //字串长度计1
        } elseif ($ascnum >= 192) { //如果ASCII位高与192，
            $returnstr = $returnstr . substr($sourcestr, $i, 2); //根据UTF-8编码规范，将2个连续的字符计为单个字符 
            $i = $i + 2; //实际Byte计为2
            $n++; //字串长度计1
        } elseif ($ascnum >= 65 && $ascnum <= 90) { //如果是大写字母，
            $returnstr = $returnstr . substr($sourcestr, $i, 1);
            $i = $i + 1; //实际的Byte数仍计1个
            $n++; //但考虑整体美观，大写字母计成一个高位字符
        } else {//其他情况下，包括小写字母和半角标点符号，
            $returnstr = $returnstr . substr($sourcestr, $i, 1);
            $i = $i + 1;            //实际的Byte数计1个
            $n = $n + 0.5;        //小写字母和半角标点等与半个高位字符宽...
        }
    }
    if ($str_length > strlen($returnstr)) {
        $returnstr = $returnstr . $dot; //超过长度时在尾处加上省略号
    }
    return $returnstr;
}

/**
 * flash上传初始化
 * 初始化swfupload上传中需要的参数
 * @param $module 模块名称
 * @param $catid 栏目id
 * @param $args 传递参数
 * @param $userid 用户id
 * @param $groupid 用户组id 默认游客
 * @param $isadmin 是否为管理员模式
 */
function initupload($module, $catid, $args, $userid, $groupid = 8, $isadmin = false) {
    if (empty($module)) {
        return false;
    }
    //网站配置
    $config = cache('Config');
    //检查用户是否有上传权限
    if ($isadmin) {
        //后台用户
        //上传大小
        $file_size_limit = intval($config['uploadmaxsize']);
        //上传处理地址
        $upload_url = U('Attachment/Admin/swfupload');
    } else {
        //前台用户
        $Member_group = cache("Member_group");
        if ((int) $Member_group[$groupid]['allowattachment'] < 1 || empty($Member_group)) {
            return false;
        }
        //上传大小
        $file_size_limit = intval($config['qtuploadmaxsize']);
        //上传处理地址
        $upload_url = U('Attachment/Upload/swfupload');
    }
    //当前时间戳
    $sess_id = time();
    //生成验证md5
    $swf_auth_key = md5(C("AUTHCODE") . $sess_id . ($isadmin ? 1 : 0));
    //同时允许的上传个数, 允许上传的文件类型, 是否允许从已上传中选择, 图片高度, 图片宽度,是否添加水印1是
    if (!is_array($args)) {
        //如果不是数组传递，进行分割
        $args = explode(',', $args);
    }
    //参数补充完整
    if (empty($args[1])) {
        //如果允许上传的文件类型为空，启用网站配置的 uploadallowext
        if ($isadmin) {
            $args[1] = $config['uploadallowext'];
        } else {
            $args[1] = $config['qtuploadallowext'];
        }
    }
    //允许上传后缀处理
    $arr_allowext = explode('|', $args[1]);
    foreach ($arr_allowext as $k => $v) {
        $v = '*.' . $v;
        $array[$k] = $v;
    }
    $upload_allowext = implode(';', $array);

    //上传个数
    $file_upload_limit = (int) $args[0] ? (int) $args[0] : 8;
    //swfupload flash 地址
    $flash_url = CONFIG_SITEURL_MODEL . 'statics/js/swfupload/swfupload.swf';

    $init = 'var swfu_' . $module . ' = \'\';
    $(document).ready(function(){
        Wind.use("swfupload",GV.DIMAUB+"statics/js/swfupload/handlers.js",function(){
            swfu_' . $module . ' = new SWFUpload({
                flash_url:"' . $flash_url . '?"+Math.random(),
                upload_url:"' . $upload_url . '",
                file_post_name : "Filedata",
                post_params:{
                    "sessid":"' . $sess_id . '",
                    "module":"' . $module . '",
                    "catid":"' . $catid . '",
                    "uid":"' . $userid . '",
                    "isadmin":"' . $isadmin . '",
                    "groupid":"' . $groupid . '",
                    "watermark_enable":"' . intval($args[5]) . '",
                    "thumb_width":"' . intval($args[3]) . '",
                    "thumb_height":"' . intval($args[4]) . '",
                    "filetype_post":"' . $args[1] . '",
                    "swf_auth_key":"' . $swf_auth_key . '"
                  },
               file_size_limit:"' . $file_size_limit . 'KB",
               file_types:"' . $upload_allowext . '",
               file_types_description:"All Files",
               file_upload_limit:"' . $file_upload_limit . '",
               custom_settings : {progressTarget : "fsUploadProgress",cancelButtonId : "btnCancel"},
               button_image_url: "",
               button_width: 75,
               button_height: 28,
               button_placeholder_id: "buttonPlaceHolder",
               button_text_style: "",
               button_text_top_padding: 3,
               button_text_left_padding: 12,
               button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
               button_cursor: SWFUpload.CURSOR.HAND,
               file_dialog_start_handler : fileDialogStart,
               file_queued_handler : fileQueued,
               file_queue_error_handler:fileQueueError,
               file_dialog_complete_handler:fileDialogComplete,
               upload_progress_handler:uploadProgress,
               upload_error_handler:uploadError,
               upload_success_handler:uploadSuccess,
               upload_complete_handler:uploadComplete
        });
    });
})
';
    return $init;
}

/**
 * 取得URL地址中域名部分
 * @param type $url 
 * @return \url 返回域名
 */
function urlDomain($url) {
    if ($url) {
        $pathinfo = parse_url($url);
        return $pathinfo['scheme'] . "://" . $pathinfo['host'] . "/";
    }
    return false;
}

/**
 * 获取当前页面完整URL地址
 * @return type 地址
 */
function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
}

/**
 * 对URL中有中文的部分进行编码处理
 * @param type $url 地址 http://www.abc3210.com/s?wd=博客
 * @return type ur;编码后的地址 http://www.abc3210.com/s?wd=%E5%8D%9A%20%E5%AE%A2
 */
function cn_urlencode($url) {
    $pregstr = "/[\x{4e00}-\x{9fa5}]+/u"; //UTF-8中文正则
    if (preg_match_all($pregstr, $url, $matchArray)) {//匹配中文，返回数组
        foreach ($matchArray[0] as $key => $val) {
            $url = str_replace($val, urlencode($val), $url); //将转译替换中文
        }
        if (strpos($url, ' ')) {//若存在空格
            $url = str_replace(' ', '%20', $url);
        }
    }
    return $url;
}

/**
 * 获取模版文件 格式 主题://模块/控制器/方法
 * @param type $templateFile
 * @return boolean|string 
 */
function parseTemplateFile($templateFile = '') {
    static $TemplateFileCache = array();
    //模板路径
    $TemplatePath = TEMPLATE_PATH;
    //模板主题
    $Theme = empty(\Common\Controller\ShuipFCMS::$Cache["Config"]['theme']) ? 'Default' : \Common\Controller\ShuipFCMS::$Cache["Config"]['theme'];
    //如果有指定 GROUP_MODULE 则模块名直接是GROUP_MODULE，否则使用 MODULE_NAME，这样做的目的是防止其他模块需要生成
    $group = defined('GROUP_MODULE') ? GROUP_MODULE : MODULE_NAME;
    if ($templateFile != '' && strpos($templateFile, '://')) {
        $exp = explode('://', $templateFile);
        $Theme = $exp[0];
        $templateFile = $exp[1];
    }
    // 分析模板文件规则
    $depr = C('TMPL_FILE_DEPR');
    //模板标识
    if ('' == $templateFile) {
        $templateFile = $TemplatePath . $Theme . '/' . $group . '/' . CONTROLLER_NAME . '/' . ACTION_NAME . C('TMPL_TEMPLATE_SUFFIX');
    }
    $key = md5($templateFile);
    if (isset($TemplateFileCache[$key])) {
        return $TemplateFileCache[$key];
    }
    if (false === strpos($templateFile, '/') && false === strpos($templateFile, C('TMPL_TEMPLATE_SUFFIX'))) {
        $templateFile = $TemplatePath . $Theme . '/' . $group . '/' . CONTROLLER_NAME . '/' . $templateFile . C('TMPL_TEMPLATE_SUFFIX');
    } else if (false === strpos($templateFile, C('TMPL_TEMPLATE_SUFFIX'))) {
        $path = explode('/', $templateFile);
        $action = array_pop($path);
        $controller = !empty($path) ? array_pop($path) : CONTROLLER_NAME;
        if (!empty($path)) {
            $group = array_pop($path)? : $group;
        }
        $depr = defined('MODULE_NAME') ? C('TMPL_FILE_DEPR') : '/';
        $templateFile = $TemplatePath . $Theme . '/' . $group . '/' . $controller . $depr . $action . C('TMPL_TEMPLATE_SUFFIX');
    }
    //区分大小写的文件判断，如果不存在，尝试一次使用默认主题
    if (!file_exists_case($templateFile)) {
        $log = '模板:[' . $templateFile . '] 不存在！';
        \Think\Log::record($log);
        //启用默认主题模板
        $templateFile = str_replace($TemplatePath . $Theme, $TemplatePath . 'Default', $templateFile);
        //判断默认主题是否存在，不存在直接报错提示
        if (!file_exists_case($templateFile)) {
            if (defined('APP_DEBUG') && APP_DEBUG) {
                E($log);
            }
            $TemplateFileCache[$key] = false;
            return false;
        }
    }
    $TemplateFileCache[$key] = $templateFile;
    return $TemplateFileCache[$key];
}
