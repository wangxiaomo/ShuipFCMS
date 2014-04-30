<?php

// +----------------------------------------------------------------------
// | ShuipFCMS
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Common\Behavior;

use Think\Hook;

defined('THINK_PATH') or exit();

class AppInitBehavior {

    public function run(&$param) {
        // 注册AUTOLOAD方法
        spl_autoload_register('Common\Behavior\AppInitBehavior::autoload');
    }

    /**
     * 类库自动加载
     * @param string $class 对象类名
     * @return void
     */
    static public function autoload($class) {
        
    }

}
