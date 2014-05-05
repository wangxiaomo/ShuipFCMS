<?php

// +----------------------------------------------------------------------
// | ShuipFCMS
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Common\Behavior;

use Libs\System\Cache;

defined('THINK_PATH') or exit();

class AppInitBehavior {

    //执行入口
    public function run(&$param) {
        // 注册AUTOLOAD方法
        spl_autoload_register('Common\Behavior\AppInitBehavior::autoload');
        //检查是否安装
        $this->richterInstall();
        //站点初始化
        $this->initialization();
    }

    /**
     * 是否安装检测
     */
    private function richterInstall() {
        //日志目录
        if (!is_dir(LOG_PATH)) {
            mkdir(LOG_PATH);
        }
        $dbHost = C('DB_HOST');
        if (empty($dbHost) && !defined('INSTALL')) {
            redirect('./install.php');
        }
    }

    //初始化
    private function initialization() {
        //产品版本号
        define("SHUIPF_VERSION", C("SHUIPF_VERSION"));
        //产品流水号
        define("SHUIPF_BUILD", C("SHUIPF_BUILD"));
        //产品名称
        define("SHUIPF_APPNAME", C("SHUIPF_APPNAME"));
        //MODULE_ALLOW_LIST配置
        $moduleList = cache('Module');
        $moduleAllowList = array('Admin', 'Api', 'Content');
        foreach ($moduleList as $rs) {
            $moduleAllowList[] = $rs['module'];
        }
        C('MODULE_ALLOW_LIST', $moduleAllowList);
    }

    /**
     * 类库自动加载
     * @param string $class 对象类名
     * @return void
     */
    static public function autoload($class) {
        echo '错误：' . $class . '<br/>';
        exit;
    }

}
