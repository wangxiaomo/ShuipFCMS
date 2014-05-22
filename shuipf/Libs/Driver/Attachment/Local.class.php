<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 本地存储方案
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Libs\Driver\Attachment;

use Libs\Service\Attachment;

class Local extends Attachment {

    /**
     * 架构函数
     * @param array $options 配置参数
     * @access public
     */
    function __construct($options = array()) {
        //网站配置
        $this->config = cache("Config");
        $options = array_merge(array(
            //上传用户ID
            'userid' => 0,
            //上传用户组
            'groupid' => 8,
            //是否后台
            'isadmin' => 0,
            //上传栏目
            'catid' => 0,
            //上传模块
            'module' => 'contents ',
            //是否添加水印
            'watermarkenable' => $this->config['watermarkenable'],
            //生成缩略图
            'thumb' => false,
            //上传时间戳
            'time' => time(),
            //上传目录创建规则
            'dateFormat' => 'Y/m',
                ), $options);
        $this->options = $options;
        //附件访问地址 
        $this->options['sitefileurl'] = $this->config['sitefileurl'];
        //附件存放路径
        $this->options['uploadfilepath'] = C('UPLOADFILEPATH');
        //允许上传的附件大小
        if (empty($this->options['uploadmaxsize'])) {
            $this->options['uploadmaxsize'] = $this->options['isadmin'] ? (int) $this->config['uploadmaxsize'] * 1024 : (int) $this->config['qtuploadmaxsize'] * 1024;
        }
        //允许上传的附件类型
        if (empty($this->options['uploadallowext'])) {
            $this->options['uploadallowext'] = $this->options['isadmin'] ? explode("|", $this->config['uploadallowext']) : explode("|", $this->config['qtuploadallowext']);
        }
        return true;
        //上传目录
        $this->options['savePath'] = D('Attachment')->getFilePath($this->options['module'], $this->options['dateFormat'], $this->options['time']);
        //如果生成缩略图是否移除原图
        $this->options['thumbRemoveOrigin'] = false;
        $this->handler = new \UploadFile();
        //设置上传类型
        $this->handler->allowExts = $this->options['uploadallowext'];
        //设置上传大小
        $this->handler->maxSize = $this->options['uploadmaxsize'];
        //设置本次上传目录，不存在时生成
        $this->handler->savePath = $this->options['savePath'];
    }

}
