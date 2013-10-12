<?php

/**
 * 模块安装，基本配置
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
return array(
    'module' => 'Addons',
    'modulename' => '插件管理',
    'introduce' => '插件管理是ShuipFCMS官方开发的高级扩展，支持插件的安装和创建~。',
    'author' => '水平凡',
    'authorsite' => 'http://www.shuipfcms.com/',
    'authoremail' => 'admin@abc3210.com',
    'version' => '1.0.0',
    'adaptation' => '1.1.0',
    'tags' => array(
        'behavior_dispatch' => array(
            'title' => '行为路由扩展',
            'remark' => '对于新扩展的行为类型，进行定位解析！',
            'type' => 1,
            'phpfile:BehaviorDispatch|module:Addons'
        ),
    ),
);