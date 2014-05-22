<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 云平台
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Libs\System;

class Cloud {

    //错误信息
    public $error = NULL;
    //需要发送的数据
    private $data = array();
    //接口
    private $act = NULL;

    //服务器地址
    const serverHot = 'htpp://api.shuipfcms.com/';

    /**
     * 连接云平台系统
     * @access public
     * @return void
     */
    static public function getInstance() {
        static $systemHandier;
        if (empty($systemHandier)) {
            $systemHandier = new Cloud();
        }
        return $systemHandier;
    }

    /**
     * 需要发送的数据
     * @param type $data
     * @return \Libs\System\Cloud
     */
    public function data($data) {
        $this->data = $data;
        return $this;
    }

    /**
     * 执行对应命令
     * @param type $act 例如 version.detection
     * @return type
     */
    public function act($act) {
        if (empty($this->data)) {
            $this->error = '没有数据！';
            return false;
        } else {
            $data = $this->data;
            //重置，以便下一次服务请求
            $this->data = array();
        }
        $this->act = $act;
        return $this->run($data);
    }

    /**
     * 请求
     * @param type $data
     * @return type
     */
    private function run($data) {
        $curl = new \Curl();
        $fields = array(
            'data' => $data,
            'act' => $this->act,
            'identity' => $this->Identity(),
        );
        //curl支持 检测
        if ($curl->create() == false) {
            $this->error = '服务器不支持Curl扩展！';
            return false;
        }
        //请求
        $status = $curl->post(self::serverHot, $fields);
        if (false == $status) {
            $this->error = '无法联系服务器，请稍后再试！';
            return false;
        }
        return json_decode($status, true);
    }

    /**
     * ShuipFCMS官网会员帐号信息
     * @return type
     */
    private function Identity() {
        return json_encode(array(
            'username' => 'demo',
            'password' => 'demo',
        ));
    }

}
