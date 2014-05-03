<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 缓存处理
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
     * @param string $type 缓存类型
     * @param array $options  配置数组
     * @return void
     */
    static public function connect($type = 'S', $options = array()) {
        if (empty(self::$handler)) {
            self::$handler = new self();
        }
        return self::$handler;
    }

    /**
     * 获取缓存
     * @param type $name 缓存名称
     * @return null
     */
    public function get($name) {
        $cache = S($name);
        if (!empty($cache)) {
            return $cache;
        } else {
            //尝试生成缓存
        }
        return null;
    }

    /**
     * 写入缓存
     * @param string $name 缓存变量名
     * @param type $value 存储数据
     * @param type $expire 有效时间（秒）
     * @return boolean
     */
    public function set($name, $value, $expire = null) {
        return S($name, $value, $expire);
    }

    /**
     * 删除缓存
     * @param string $name 缓存变量名
     * @return boolean
     */
    public function rm($name) {
        return S($name, NULL);
    }

    /**
     * 使用静态方式调用对象方法
     * @param type $method 方法
     * @param type $args 参数
     * @return type
     */
    static public function __callstatic($method, $args) {
        if (empty(self::$handler)) {
            self::connect();
        }
        //调用缓存驱动的方法
        if (method_exists(self::$handler, $method)) {
            return call_user_func_array(array(self::$handler, $method), $args);
        }
    }

}
