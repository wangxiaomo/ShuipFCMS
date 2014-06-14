<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 编辑器
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Attachment\Controller;

class UeditorController extends AttachmentsController {

    //编辑器初始配置
    private $confing = array(
        /* 上传图片配置项 */
        'imageActionName' => 'uploadimage',
        'imageFieldName' => 'upfilesss',
        'imageMaxSize' => 2048000, /* 上传大小限制，单位B */
        'imageAllowFiles' => array('.png', '.jpg', '.jpeg', '.gif', '.bmp'),
        'imageCompressEnable' => true,
        'imageCompressBorder' => 1600,
        'imageInsertAlign' => 'none',
        'imageUrlPrefix' => '',
        'imagePathFormat' => '',
        /* 涂鸦图片上传配置项 */
        'scrawlActionName' => 'uploadscrawl',
        'scrawlFieldName' => 'upfile',
        'scrawlPathFormat' => '',
        'scrawlMaxSize' => 2048000,
        'scrawlUrlPrefix' => '',
        'scrawlInsertAlign' => 'none',
        /* 截图工具上传 */
        'snapscreenActionName' => 'uploadimage',
        'snapscreenPathFormat' => '',
        'snapscreenUrlPrefix' => '',
        'snapscreenInsertAlign' => 'none',
        /* 抓取远程图片配置 */
        'catcherLocalDomain' => array('127.0.0.1', 'localhost', 'img.baidu.com'),
        'catcherActionName' => 'catchimage',
        'catcherFieldName' => 'source',
        'catcherPathFormat' => '',
        'catcherUrlPrefix' => '',
        'catcherMaxSize' => 2048000,
        'catcherAllowFiles' => array('.png', '.jpg', '.jpeg', '.gif', '.bmp'),
        /* 上传视频配置 */
        'videoActionName' => 'uploadvideo',
        'videoFieldName' => 'upfile',
        'videoPathFormat' => '',
        'videoUrlPrefix' => '',
        'videoMaxSize' => 102400000,
        'videoAllowFiles' => array(".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg", ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"),
        /* 上传文件配置 */
        'fileActionName' => 'uploadfile',
        'fileFieldName' => 'upfile',
        'filePathFormat' => '',
        'fileUrlPrefix' => '',
        'fileMaxSize' => 51200000,
        'fileAllowFiles' => array(".flv", ".swf",),
        /* 列出指定目录下的图片 */
        'imageManagerActionName' => 'listimage',
        'imageManagerListPath' => '',
        'imageManagerListSize' => 20,
        'imageManagerUrlPrefix' => '',
        'imageManagerInsertAlign' => 'none',
        'imageManagerAllowFiles' => array('.png', '.jpg', '.jpeg', '.gif', '.bmp'),
        /* 列出指定目录下的文件 */
        'fileManagerActionName' => 'listfile',
        'fileManagerListPath' => '',
        'fileManagerUrlPrefix' => '',
        'fileManagerListSize' => '',
        'fileManagerAllowFiles' => array(".flv", ".swf",),
    );

    //初始化
    protected function _initialize() {
        defined('Ueditor') or define('Ueditor', true);
        parent::_initialize();
        if ($this->isadmin) {
            //上传大小
            $this->confing['imageMaxSize'] = $this->confing['scrawlMaxSize'] = $this->confing['catcherMaxSize'] = $this->confing['videoMaxSize'] = $this->confing['fileMaxSize'] = self::$Cache['Config']['uploadmaxsize'] * 1024;
            //上传文件类型
            $uploadallowext = explode('|', self::$Cache['Config']['uploadallowext']);
            foreach ($uploadallowext as $k => $rs) {
                $uploadallowext[$k] = ".{$rs}";
            }
            $this->confing['fileAllowFiles'] = $uploadallowext;
        } else {
            $this->confing['imageMaxSize'] = $this->confing['scrawlMaxSize'] = $this->confing['catcherMaxSize'] = $this->confing['videoMaxSize'] = $this->confing['fileMaxSize'] = self::$Cache['Config']['qtuploadmaxsize'] * 1024;
            //上传文件类型
            $uploadallowext = explode('|', self::$Cache['Config']['qtuploadallowext']);
            foreach ($uploadallowext as $k => $rs) {
                $uploadallowext[$k] = ".{$rs}";
            }
            $this->confing['fileAllowFiles'] = $uploadallowext;
        }
    }

    //编辑器配置
    public function run() {
        $action = I('get.action');
        switch ($action) {
            case 'config':
                $result = $this->confing;
                break;
            //上传图片
            case 'uploadimage':
                $result = array(
                    'state' => 'SUCCESS', //成功返回标准，否则是错误提示
                    'url' => '/d/file/content/2014/06/539c18ca68b41.jpg', //成功地址
                    'title' => 'title', //上传后的文件名
                    'original' => 'original', //原来的
                );
                break;
            default:
                $result = array(
                    'state' => '请求地址出错'
                );
                break;
        }
        exit(json_encode($result));
    }

}
