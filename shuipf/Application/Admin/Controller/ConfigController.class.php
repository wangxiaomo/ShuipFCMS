<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 站点配置
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Common\Controller\AdminBase;

class ConfigController extends AdminBase {

    private $Config = null;

    protected function _initialize() {
        parent::_initialize();
        $this->Config = D('Common/Config');
        $configList = $this->Config->getField("varname,value");
        $this->assign('Site', $configList);
    }

    //网站基本设置
    public function index() {
        if (IS_POST) {
            if ($this->Config->saveConfig($_POST)) {
                $this->success("更新成功！");
            } else {
                $error = $this->Config->getError();
                $this->error($error ? $error : "配置更新失败！");
            }
        } else {
            $this->display();
        }
    }

    //邮箱参数
    public function mail() {
        if (IS_POST) {
            $this->index();
        } else {
            $this->display();
        }
    }

    //附件参数
    public function attach() {
        if (IS_POST) {
            $this->index();
        } else {
            $this->display();
        }
    }

    //高级配置
    public function addition() {
        if (IS_POST) {
            if ($this->Config->addition($_POST)) {
                $this->success("修改成功，即将更新缓存！", U("Admin/Index/public_cache", "type=site"));
            } else {
                $error = $this->Config->getError();
                $this->error($error ? $error : "高级配置更新失败！");
            }
        } else {
            $addition = include COMMON_PATH . 'Conf/addition.php';
            if (empty($addition) || !is_array($addition)) {
                $addition = array();
            }
            $this->assign("addition", $addition);
            $this->display();
        }
    }

    //扩展配置
    public function extend() {
        if (IS_POST) {
            $action = I('post.action');
            if ($action) {
                //添加扩展项
                if ($action == 'add') {
                    $data = array(
                        'fieldname' => trim(I('post.fieldname')),
                        'type' => trim(I('post.type')),
                        'setting' => I('post.setting'),
                        C("TOKEN_NAME") => I('post.' . C("TOKEN_NAME")),
                    );
                    if ($this->Config->extendAdd($data) !== false) {
                        $this->success('扩展配置项添加成功！', U('Config/extend'));
                        return true;
                    } else {
                        $error = $this->Config->getError();
                        $this->error($error ? $error : '添加失败！');
                    }
                }
            } else {
                //更新扩展项配置
                if ($this->Config->saveExtendConfig($_POST)) {
                    $this->success("更新成功！");
                } else {
                    $error = $this->Config->getError();
                    $this->error($error ? $error : "配置更新失败！");
                }
            }
        } else {
            $action = I('get.action');
            $db = M('ConfigField');
            if ($action) {
                if ($action == 'delete') {
                    $fid = I('get.fid', 0, 'intval');
                    if ($this->Config->extendDel($fid)) {
                        cache('Config', NULL);
                        $this->success("扩展配置项删除成功！");
                        return true;
                    } else {
                        $error = $this->Config->getError();
                        $this->error($error ? $error : "扩展配置项删除失败！");
                    }
                }
            }
            $extendList = $db->order(array('fid' => 'DESC'))->select();
            $this->assign('extendList', $extendList);
            $this->display();
        }
    }

}
