<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 内容处理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Libs\System;

use Content\Model\ContentModel;

class Content {

    //数据
    protected $data = array();
    //错误信息
    protected $error = NULL;
    protected $id = 0;
    protected $catid = 0;
    protected $modelid = 0;

    /**
     * 连接内容处理服务
     * @access public
     * @param array $options  配置数组
     * @return void
     */
    static public function getInstance($options = array()) {
        static $systemHandier;
        if (empty($systemHandier)) {
            $systemHandier = new Content($options);
        }
        return $systemHandier;
    }

    /**
     * 获取错误提示
     * @return type
     */
    public function getError() {
        return $this->error;
    }

    /**
     * 设置数据对象值
     * @access public
     * @param mixed $data 数据
     * @return Model
     */
    public function data($data = '') {
        if ('' === $data && !empty($this->data)) {
            return $this->data;
        }
        if (is_object($data)) {
            $data = get_object_vars($data);
        } elseif (is_string($data)) {
            parse_str($data, $data);
        } elseif (!is_array($data)) {
            E(L('_DATA_TYPE_INVALID_'));
        }
        $this->data = $data;
        return $this;
    }

    /**
     * 添加内容
     * @param type $data 数据
     * @return boolean
     */
    public function add($data = '') {
        if (empty($data)) {
            if (!empty($this->data)) {
                $data = $this->data;
                // 重置数据
                $this->data = array();
            } else {
                $this->error = L('_DATA_TYPE_INVALID_');
                return false;
            }
        }
        $this->catid = (int) $data['catid'];
        $this->modelid = getCategory($this->catid, 'modelid');
        //取得表单令牌验证码
        $data[C("TOKEN_NAME")] = $_POST[C("TOKEN_NAME")];
        //标签
        tag("content_add_begin", $data);
        //栏目数据
        $catidinfo = getCategory($data['catid']);
        if (empty($catidinfo)) {
            $this->error = '获取不到栏目数据！';
            return false;
        }
        //setting配置
        $catidsetting = $catidinfo['setting'];
        //前台投稿状态判断
        if (!defined('IN_ADMIN') || (defined('IN_ADMIN') && IN_ADMIN == false)) {
            //前台投稿，根据栏目配置和用户配置
            $Member_group = cache("Member_group");
            $groupid = service('Passport')->groupid;
            //如果会员组设置中设置，投稿不需要审核，直接无视栏目设置
            if ($Member_group[$groupid]['allowpostverify']) {
                $data['status'] = 99;
            } else {
                //前台投稿是否需要审核
                if ($catidsetting['member_check']) {
                    $data['status'] = 1;
                } else {
                    $data['status'] = 99;
                }
            }
            //添加用户名
            $data['username'] = service('Passport')->username;
            $data['sysadd'] = 0;
        } else {
            //添加用户名
            $data['username'] = \Admin\Service\User::getInstance()->username;
            $data['sysadd'] = 1;
        }
        //检查真实发表时间，如果有时间转换为时间戳
        if ($data['inputtime'] && !is_numeric($data['inputtime'])) {
            $data['inputtime'] = strtotime($data['inputtime']);
        } elseif (!$data['inputtime']) {
            $data['inputtime'] = time();
        }
        //更新时间处理
        if ($data['updatetime'] && !is_numeric($data['updatetime'])) {
            $data['updatetime'] = strtotime($data['updatetime']);
        } elseif (!$data['updatetime']) {
            $data['updatetime'] = time();
        }
        //自动提取摘要，如果有设置自动提取，且description为空，且有内容字段才执行
        $this->description($data);
        $model = ContentModel::getInstance($this->modelid);
        $content_input = new \content_input($this->modelid);
        //保存一份旧数据
        $oldata = $data;
        $data = $content_input->get($data, 1);
        if ($data) {
            $data = $model->relation(true)->create($data, 1);
            if (false == $data) {
                $this->error = $model->getError();
                $this->tokenRecovery($oldata);
                return false;
            }
        } else {
            $this->error = $content_input->getError();
            $this->tokenRecovery($oldata);
            return false;
        }
        //自动提取缩略图，从content 中提取
        $this->getThumb($data);
        $oldata['thumb'] = $data['thumb'];
        //添加内容
        $id = $data['id'] = $oldata['id'] = $model->relation(true)->add($data);
        if (false == $id) {
            $this->error = $model->getError();
            $this->tokenRecovery($oldata);
            return false;
        }
        //转向地址
        $urls = array();
        if ($data['islink'] == 1) {
            $urls['url'] = $_POST['linkurl'];
        } else {
            //生成该篇地址
            $urls = $this->generateUrl($data);
        }
        $oldata['url'] = $data['url'] = $urls['url'];
        //更新url
        $model->token(false)->where(array('id' => $id))->save(array('url' => $data['url']));
        //更新到全站搜索
        if ($data['status'] == 99) {
            $this->search_api($id, $data);
        }
        $content_update = new \content_update($this->modelid);
        $content_update->update($data);
        //发布到其他栏目,只能后台发布才可以使用该功能
        if (defined('IN_ADMIN') && IN_ADMIN) {
            if (is_array($_POST['othor_catid'])) {
                foreach ($_POST['othor_catid'] as $classid => $v) {
                    if ($this->catid == $classid) {
                        continue;
                    }
                    $othor_catid[] = $classid;
                }
                //去除重复
                $othor_catid = array_unique($othor_catid);
                $this->othor_catid($othor_catid, $urls['url'], $data, $this->modelid);
            }
        }
        //字段合并
        $model->dataMerger($data);
        //更新附件状态，把相关附件和文章进行管理
        $attachment = service('Attachment');
        $attachment->api_update('', 'c-' . $data['catid'] . '-' . $id, 2);
        //标签
        tag("content_add_end", $data);
        return $id;
    }

    /**
     * 修改内容
     * @param type $data
     * @return boolean
     */
    public function edit($data = '') {
        if (empty($data)) {
            if (!empty($this->data)) {
                $data = $this->data;
                // 重置数据
                $this->data = array();
            } else {
                $this->error = L('_DATA_TYPE_INVALID_');
                return false;
            }
        }
        $this->id = (int) $data['id'];
        $this->catid = (int) $data['catid'];
        $this->modelid = getCategory($this->catid, 'modelid');
        //取得表单令牌验证码
        $data[C("TOKEN_NAME")] = $_POST[C("TOKEN_NAME")];
        //标签
        tag("content_edit_begin", $data);
        //栏目数据
        $catidinfo = getCategory($this->catid);
        if (empty($catidinfo)) {
            $this->error = '获取不到栏目数据！';
            return false;
        }
        //setting配置
        $catidsetting = $catidinfo['setting'];
        //前台投稿状态判断
        if (!defined('IN_ADMIN') || (defined('IN_ADMIN') && IN_ADMIN == false)) {
            //前台投稿编辑是否需要审核
            if ($catidsetting['member_editcheck']) {
                $data['status'] = 1;
            }
        }
        $model = ContentModel::getInstance($this->modelid);
        //真实发布时间
        $data['inputtime'] = $inputtime = $model->where(array("id" => $this->id))->getField("inputtime");
        //更新时间处理
        if ($data['updatetime'] && !is_numeric($data['updatetime'])) {
            $data['updatetime'] = strtotime($data['updatetime']);
        } elseif (!$data['updatetime']) {
            $data['updatetime'] = time();
        }
        //自动提取摘要，如果有设置自动提取，且description为空，且有内容字段才执行
        $this->description($data);
        //转向地址
        if ($data['islink'] == 1) {
            $urls["url"] = $_POST['linkurl'];
        } else {
            //生成该篇地址
            $urls = $this->generateUrl($data);
        }
        $data['url'] = $urls["url"];
        $content_input = new \content_input($this->modelid);
        //保存一份旧数据
        $oldata = $data;
        $data = $content_input->get($data, 2);
        if ($data) {
            //数据验证
            $data = $model->relation(true)->create($data, 2);
            if (false == $data) {
                $this->error = $model->getError();
                $this->tokenRecovery($data);
                return false;
            }
        } else {
            $this->error = $content_input->getError();
            return false;
        }
        //自动提取缩略图，从content 中提取
        $this->getThumb($data);
        $oldata['thumb'] = $data['thumb'];
        //数据修改，这里使用关联操作
        $status = $model->relation(true)->where(array('id' => $this->id))->save($data);
        if (false === $status) {
            $this->error = $model->getError();
            $this->tokenRecovery($data);
            return false;
        }
        //字段合并
        $model->dataMerger($data);
        //调用回调更新
        $content_update = new \content_update($this->modelid);
        $content_update->update($oldata);
        //更新附件状态，把相关附件和文章进行管理
        $attachment = service('Attachment');
        $attachment->api_update('', 'c-' . $data['catid'] . '-' . $id, 2);
        //更新到全站搜索
        if ($data['status'] == 99) {
            $this->search_api($id, $data, 'updata');
        } else {
            $this->search_api($id, $data, 'delete');
        }
        //标签
        tag("content_edit_end", $data);

        return true;
    }

    /**
     * 同步发布
     * @param type $othor_catid 需要同步发布到的栏目ID
     * @param type $linkurl 原信息地址
     * @param type $data 原数据，以关联表的数据格式
     * @param type $modelid 原信息模型ID
     * @return boolean
     */
    public function othor_catid($othor_catid, $linkurl, $data, $modelid) {
        //数据检测
        if (!$linkurl || !$othor_catid || !$data || !$modelid) {
            return false;
        }
        C('TOKEN_ON', false);
        //去除ID
        unset($data['id']);
        $model = ContentModel::getInstance($modelid);
        //循环需要同步发布的栏目
        foreach ($othor_catid as $cid) {
            //获取需要同步栏目所属模型ID
            $mid = getCategory($cid, 'modelid');
            //判断模型是否相同
            if ($modelid == $mid) {//相同
                $data['catid'] = $cid;
                $_categorys = getCategory($data['catid']);
                //修复当被推送的文章是推荐位的文章时，推送后会把相应属性也推送过去
                $data['posid'] = 0;
                $newid = $model->relation(true)->add($data);
                if (!$newid) {
                    continue;
                }
                $othordata = $data;
                $othordata['id'] = $newid;
                if (isset($othordata[$model->getRelationName()]['id'])) {
                    $othordata[$model->getRelationName()]['id'] = $newid;
                }
                //更新URL地址
                if ((int) $othordata['islink'] == 1) {
                    $nurls = $othordata['url'];
                    //更新地址
                    $model->where(array('id' => $newid))->save(array('url' => $nurls));
                    $othordata['url'] = $nurls;
                } else {
                    $nurls = $this->generateUrl($othordata);
                    //更新地址
                    $model->where(array('id' => $newid))->save(array('url' => $nurls['url']));
                    $othordata['url'] = $nurls['url'];
                }
                if (is_array($nurls) && $_categorys['setting']['content_ishtml'] && $othordata['status'] == 99) {
                    //生成静态
                    $this->generateShow($othordata, 0, "add");
                }
            } else {
                //不同模型，则以链接的形式添加，也就是转向地址
                $dataarray = array('title' => $data['title'],
                    'style' => $data['style'],
                    'thumb' => $data['thumb'],
                    'keywords' => $data['keywords'],
                    'description' => $data['description'],
                    'status' => $data['status'],
                    'catid' => $cid,
                    'url' => $linkurl,
                    'sysadd' => 1,
                    'username' => $data['username'],
                    'inputtime' => $data['inputtime'],
                    'updatetime' => $data['updatetime'],
                    'islink' => 1
                );
                $newid = ContentModel::getInstance($mid)->relation(true)->add($dataarray);
            }
        }
        return true;
    }

    /**
     * 更新搜索数据
     * @param type $id 信息id
     * @param type $data 数据
     * @param type $action 动作
     */
    private function search_api($id = 0, $data = array(), $action = 'add') {
        if (!isModuleInstall('Search')) {
            return false;
        }
        $db = D('Search/Search');
        //检查当前模型是否有在搜索数据源中
        $searchConfig = cache("Search_config");
        if (!in_array($this->modelid, $searchConfig['modelid'])) {
            return false;
        }
        return $db->search_api($id, $data, $this->modelid, $action);
    }

    /**
     * 获取URL规则处理后的
     * @param type $data
     * @return type
     */
    protected function generateUrl($data,$page = 1) {
        $url = new Url();
        return $url->show($data);
    }

    /**
     * 获取标题图片
     * @param type $data
     */
    protected function getThumb(&$data) {
        $model = ContentModel::getInstance($this->modelid);
        //取得副表下标
        $getRelationName = $model->getRelationName();
        //自动提取缩略图，从content 中提取
        if (empty($data['thumb'])) {
            $isContent = isset($data['content']) ? 1 : 0;
            $content = $isContent ? $data['content'] : $data[$getRelationName]['content'];
            $auto_thumb_no = I('.auto_thumb_no', 1, 'intval') - 1;
            if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
                $oldata['thumb'] = $data['thumb'] = $matches[3][$auto_thumb_no];
            }
        }
    }

    /**
     * 自动获取简介
     * @param type $data
     */
    protected function description(&$data) {
        //自动提取摘要，如果有设置自动提取，且description为空，且有内容字段才执行
        if (isset($_POST['add_introduce']) && $data['description'] == '' && isset($data['content'])) {
            $content = $data['content'];
            $introcude_length = intval($_POST['introcude_length']);
            $data['description'] = str_cut(str_replace(array("\r\n", "\t", '[page]', '[/page]', '&ldquo;', '&rdquo;', '&nbsp;'), '', strip_tags($content)), $introcude_length);
        }
    }

    /**
     * 对验证过的token进行复原
     * @param type $data 数据
     */
    protected function tokenRecovery($data = array()) {
        if (empty($data)) {
            $data = $_POST;
        }
        //TOKEN_NAME
        $tokenName = C('TOKEN_NAME');
        if (empty($data[$tokenName])) {
            return false;
        }
        list($tokenKey, $tokenValue) = explode('_', $data[$tokenName]);
        //如果验证失败，重现对TOKEN进行复原生效
        $_SESSION[$tokenName][$tokenKey] = $tokenValue;
        return true;
    }

}
