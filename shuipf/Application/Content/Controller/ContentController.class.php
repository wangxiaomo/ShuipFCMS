<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 内容管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Content\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;
use Content\Model\ContentModel;

class ContentController extends AdminBase {

    //当前栏目id
    public $catid = 0;

    //初始化
    protected function _initialize() {
        parent::_initialize();
        $this->catid = I('catid', 0, 'intval');
    }

    //显示内容管理首页
    public function index() {
        $this->display();
    }

    //显示栏目菜单列表 
    public function public_categorys() {
        //是否超级管理员
        $isAdministrator = User::getInstance()->isAdministrator();
        $priv_catids = array();
        //栏目权限 超级管理员例外
        if ($isAdministrator !== true) {
            $role_id = User::getInstance()->role_id;
            $priv_result = M("CategoryPriv")->where(array("roleid" => $role_id, 'action' => 'init'))->select();
            foreach ($priv_result as $_v) {
                $priv_catids[] = $_v['catid'];
            }
        }
        $json = array();
        $categorys = cache("Category");
        foreach ($categorys as $rs) {
            $rs = getCategory($rs['catid']);
            if ($rs['type'] == 2 && $rs['child'] == 0) {
                continue;
            }
            //只显示有init权限的，超级管理员除外
            if ($isAdministrator !== true && !in_array($rs['catid'], $priv_catids)) {
                $arrchildid = explode(',', $rs['arrchildid']);
                $array_intersect = array_intersect($priv_catids, $arrchildid);
                if (empty($array_intersect)) {
                    continue;
                }
            }
            $data = array(
                'catid' => $rs['catid'],
                'parentid' => $rs['parentid'],
                'catname' => $rs['catname'],
                'type' => $rs['type'],
            );
            //终极栏目
            if ($rs['child'] == 0) {
                $data['target'] = "right";
                $data['url'] = U("Content/classlist", array("catid" => $rs['catid']));
                //设置图标 
                $data['icon'] = self::$Cache['Config']['siteurl'] . "statics/js/zTree/zTreeStyle/img/diy/10.png";
            } else {
                $data['isParent'] = true;
            }
            //单页
            if ($rs['type'] == 1 && $rs['child'] == 0) {
                $data['url'] = U("Content/add", array("catid" => $rs['catid']));
                //设置图标 
                $data['icon'] = self::$Cache['Config']['siteurl'] . "statics/js/zTree/zTreeStyle/img/diy/2.png";
            }
            $json[] = $data;
        }
        $this->assign('json', json_encode($json));
        $this->display();
    }

    //栏目信息列表
    public function classlist() {
        //当前栏目信息
        $catInfo = getCategory($this->catid);
        if (empty($catInfo)) {
            $this->error('该栏目不存在！', U('Admin/Main/index'));
        }
        //查询条件
        $where = array();
        $where['catid'] = array('EQ', $this->catid);
        $where['status'] = array('EQ', 99);
        //栏目所属模型
        $modelid = $catInfo['modelid'];
        //栏目扩展配置
        $setting = $catInfo['setting'];
        //检查模型是否被禁用
        if (getModel($modelid, 'disabled')) {
            $this->error('模型被禁用！');
        }
        //当前栏目所属模型字段
        $modelField = cache('ModelField');
        $modelField = $modelField[$modelid]? : array();
        //搜索
        $search = I('get.search');
        if (!empty($search)) {
            $this->assign("search", $search);
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_time)) {
                $start_time = strtotime($start_time);
                $where['inputtime'] = array("EGT", $start_time);
                $this->assign('start_time', $start_time);
            }
            //添加结束时间
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where['inputtime'] = array("ELT", $end_time);
                $this->assign('end_time', $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            //推荐
            $posids = I('get.posids', 0, 'intval');
            if (!empty($posids)) {
                $where["posid"] = array("EQ", $posids);
                $this->assign("posids", $posids);
            }
            //搜索字段
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = \Input::getVar(I('get.keyword'));
            if (!empty($keyword)) {
                $this->assign("searchtype", $searchtype);
                $this->assign("keyword", $keyword);
                $type_array = array('title', 'description', 'username');
                if ($searchtype < 3) {
                    $searchtype = $type_array[$searchtype];
                    $where[$searchtype] = array("LIKE", "%{$keyword}%");
                } elseif ($searchtype == 3) {
                    $where["id"] = array("EQ", (int) $keyword);
                }
            }
            //状态
            $status = I('get.status', 0, 'intval');
            if ($status) {
                $where['status'] = array("EQ", $status);
            }
        }

        //实例化模型
        $model = ContentModel::getInstance($modelid);
        //信息总数
        $count = $model->where($where)->count();
        $page = $this->page($count, 20);
        $data = $model->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "DESC"))->select();

        //模板处理
        $template = '';
        //自定义列表
        if (!empty($setting['list_customtemplate'])) {
            $template = "Listtemplate:{$setting['list_customtemplate']}";
        }
        $this->assign($catInfo)
                ->assign("Page", $page->show('Admin'))
                ->assign("catid", $this->catid)
                ->assign("count", $count)
                ->assign("data", $data);
        $this->display($template);
    }

    //添加信息 
    public function add() {
        if (IS_POST) {
            //栏目ID
            $catid = $_POST['info']['catid'] = intval($_POST['info']['catid']);
            if (empty($catid)) {
                $this->error("请指定栏目ID！");
            }
            if (trim($_POST['info']['title']) == '') {
                $this->error("标题不能为空！");
            }
            //获取当前栏目配置
            $category = getCategory($catid);
            //栏目类型为0
            if ($category['type'] == 0) {
                //模型ID
                $this->modelid = getCategory($catid, 'modelid');
                //检查模型是否被禁用
                if ($this->model[$this->modelid]['disabled'] == 1) {
                    $this->error("模型被禁用！");
                }
                //setting 配置
                $setting = $category['setting'];
                import('Content');
                $Content = get_instance_of('Content');
                $status = $Content->add($_POST['info']);
                if ($status) {
                    $this->success("添加成功！");
                } else {
                    $this->error($Content->getError());
                }
            } else if ($category['type'] == 1) {//单页栏目
                $db = D('Page');
                if ($db->savePage($_POST)) {
                    //扩展字段处理
                    if ($_POST['extend']) {
                        D("Category")->extendField($catid, $_POST);
                        //更新缓存
                        getCategory($this->catid, '', true);
                    }
                    import('Html');
                    $html = get_instance_of('Html');
                    $html->category($catid);
                    $this->success('操作成功！');
                } else {
                    $error = $db->getError();
                    $this->error($error ? $error : '操作失败！');
                }
            } else {
                $this->error("该栏目类型无法发布！");
            }
        } else {
            //取得对应模型
            $category = getCategory($this->catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            //判断是否终极栏目
            if ($category['child']) {
                $this->error('只有终极栏目可以发布文章！');
            }
            if ($category['type'] == 0) {
                //模型ID
                $modelid = $category['modelid'];
                //检查模型是否被禁用
                if (getModel($modelid, 'disabled') == 1) {
                    $this->error('该模型已被禁用！');
                }
                //实例化表单类 传入 模型ID 栏目ID 栏目数组
                $content_form = new \content_form($modelid, $this->catid);
                //生成对应字段的输入表单
                $forminfos = $content_form->get();
                //生成对应的JS验证规则
                $formValidateRules = $content_form->formValidateRules;
                //js验证不通过提示语
                $formValidateMessages = $content_form->formValidateMessages;
                //js
                $formJavascript = $content_form->formJavascript;
                //取得当前栏目setting配置信息
                $setting = $category['setting'];

                $this->assign("catid", $this->catid);
                $this->assign("content_form", $content_form);
                $this->assign("forminfos", $forminfos);
                $this->assign("formValidateRules", $formValidateRules);
                $this->assign("formValidateMessages", $formValidateMessages);
                $this->assign("formJavascript", $formJavascript);
                $this->assign("setting", $setting);
                $this->assign("category", $category);
                $this->display();
            } else if ($category['type'] == 1) {//单网页模型
                $info = D('Page')->getPage($this->catid);
                if ($info && $info['style']) {
                    $style = explode(';', $info['style']);
                    $info['style_color'] = $style[0];
                    if ($style[1]) {
                        $info['style_font_weight'] = $style[1];
                    }
                }
                $extend = $category['setting']['extend'];

                $this->assign("catid", $this->catid);
                $this->assign("setting", $setting);
                $this->assign('extend', $extend);
                $this->assign('info', $info);
                $this->assign("category", $category);
                //栏目扩展字段
                $this->assign('extendList', D("Content/Category")->getExtendField($this->catid));
                $this->display('singlepage');
            }
        }
    }

    //编辑信息 
    public function edit() {
        
    }

    //删除
    public function delete() {
        
    }

}
