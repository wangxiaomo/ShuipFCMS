<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 附件系统
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Libs\Service;

class Attachment extends \Libs\System\Service {

    /**
     * 操作句柄
     * @var string
     * @access protected
     */
    protected $handler;

    /**
     * 缓存连接参数
     * @var integer
     * @access protected
     */
    protected $options = array();

    /**
     * 连接附件系统
     * @param type $type 类型
     * @param type $options 参数
     * @return \Libs\Service\class
     */
    public static function connect($type = '', $options = array()) {
        echo 'connect<br/>';
        if (!empty($type)) {
            //网站配置
            $config = cache("Config");
            if ((int) $config['ftpstatus']) {
                $type = 'Ftp';
            } else {
                $type = 'Local';
            }
        }
        //附件存储方案
        $class = strpos($type, '\\') ? $type : 'Libs\\Driver\\Attachment\\' . ucwords(strtolower($type));
        if (class_exists($class)) {
            $connect = new $class($options);
        } else {
            E("附件驱动 {$class} 不存在！");
        }
        return $connect;
    }

    /**
     * 通过附件关系删除附件 
     * @param type $keyid 关联ID
     * @return boolean 布尔值
     */
    public function api_delete($keyid) {
        return true;
    }

    /**
     * 附件更新接口.
     * @param string $content 可传入空，html，数组形式url，url地址，传入空时，以cookie方式记录。
     * @param string 传入附件关系表中的组装id
     * @isurl intval 为本地地址时设为1,以cookie形式管理时设置为2
     */
    public function api_update($content, $keyid, $isurl = 0) {
        return true;
    }

}
