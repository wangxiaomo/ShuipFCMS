<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 辅助F方法的缓存处理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Libs\System;

class Cache {

    /**
     * 操作句柄
     * @var string
     * @access protected
     */
    static protected $handler;

    /**
     * 连接缓存系统
     * @access public
     * @param string $type 文件类型
     * @param array $options  配置数组
     * @return void
     */
    static public function connect($type = 'File', $options = array()) {
        $class = 'Think\\Storage\\Driver\\' . ucwords($type);
        self::$handler = new $class($options);
    }

}
