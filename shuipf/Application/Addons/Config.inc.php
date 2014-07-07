<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 插件模块配置
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------
return array(
    //模块名称
    'modulename' => '插件管理',
    //模块简介
    'introduce' => '插件管理是ShuipFCMS官方开发的高级扩展，支持插件的安装和创建~。',
    //模块介绍地址
    'address' => 'http://www.shuipfcms.com',
    //模块作者
    'author' => '水平凡',
    //作者地址
    'authorsite' => 'http://www.shuipfcms.com',
    //作者邮箱
    'authoremail' => 'admin@abc3210.com',
    //版本号，请不要带除数字外的其他字符
    'version' => '1.1.1',
    //适配最低ShuipFCMS版本，
    'adaptation' => '2.0.0',
    //签名
    'sign' => '912b7e22bd9d86dddb1d460ca90581eb',
    //依赖模块
    'depend' => array(),
    //缓存，格式：缓存key=>array('module','model','action')
    'cache' => array(
        'Addons' => array(
            'name' => '插件列表',
            'model' => 'Addons',
            'action' => 'addons_cache',
        ),
    ),
);
