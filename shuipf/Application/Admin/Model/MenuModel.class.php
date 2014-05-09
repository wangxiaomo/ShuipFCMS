<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 后台菜单模型
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Model;

use Common\Model\Model;

class MenuModel extends Model {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('name', 'require', '菜单名称不能为空！', 1, 'regex', 3),
        array('app', 'require', '模块不能为空！', 1, 'regex', 3),
        array('controller', 'require', '控制器不能为空！', 1, 'regex', 3),
        array('action', 'require', '方法不能为空！', 1, 'regex', 3),
        array('status', array(0, 1), '状态值的范围不正确！', 2, 'in'),
        array('type', array(0, 1), '状态值的范围不正确！', 2, 'in'),
    );

    /**
     * 获取菜单
     * @return type
     */
    public function getMenuList() {
        $items['0changyong'] = array(
            "id" => "",
            "name" => "常用菜单",
            "parent" => "changyong",
            "url" => U("Menu/public_changyong"),
        );
//        foreach (AdminPanel::model()->getPanelList(AdminBase::$uid) as $r) {
//            $items[$r['menuid'] . '0changyong'] = array(
//                "icon" => "",
//                "id" => $r['menuid'] . '0changyong',
//                "name" => $r['name'],
//                "parent" => "changyong",
//                "url" => AdminBase::U($r['url']),
//            );
//        }
        $changyong = array(
            "changyong" => array(
                "icon" => "",
                "id" => "changyong",
                "name" => "常用",
                "parent" => "",
                "url" => "",
                "items" => $items
            )
        );
        $data = $this->getTree(0);
        return array_merge($changyong, $data ? $data : array());
    }

    /**
     * 按父ID查找菜单子项
     * @param integer $parentid   父菜单ID  
     * @param integer $with_self  是否包括他自己
     */
    public function adminMenu($parentid, $with_self = false) {
        //父节点ID
        $parentid = (int) $parentid;
        $result = $this->where(array('parentid' => $parentid, 'status' => 1))->order('listorder ASC,id ASC')->select();
        if (empty($result)) {
            $result = array();
        }
        if ($with_self) {
            $parentInfo = $this->where(array('id' => $parentid))->find();
            $result2[] = $parentInfo ? $parentInfo : array();
            $result = array_merge($result2, $result);
        }
        //是否超级管理员
        if (\Admin\Service\User::getInstance()->isAdministrator()) {
            //如果角色为 1 直接通过
            return $result;
        }
        $array = array();
        foreach ($result as $v) {
            //方法
            $action = $v['action'];
            //条件
            $where = array('app' => $v['app'], 'controller' => $v['controller'], 'action' => $action, 'role_id' => \Admin\Service\User::getInstance()->role_id);
            //如果是菜单项
            if ($v['type'] == 0) {
                $where['controller'] .= $v['id'];
                $where['action'] .= $v['id'];
            }
            //public开头的通过
            if (preg_match('/^public_/', $action)) {
                $array[] = $v;
            } else {
                if (preg_match('/^ajax_([a-z]+)_/', $action, $_match)) {
                    $action = $_match[1];
                }
                //是否有权限
                if (D('Admin/Access')->isCompetence($where)) {
                    $array[] = $v;
                }
            }
        }
        return $array;
    }

    /**
     * 取得树形结构的菜单
     * @param type $myid
     * @param type $parent
     * @param type $Level
     * @return type
     */
    public function getTree($myid, $parent = "", $Level = 1) {
        $data = $this->adminMenu($myid);
        $Level++;
        if (is_array($data)) {
            foreach ($data as $a) {
                $id = $a['id'];
                $name = $a['app'];
                $controller = $a['controller'];
                $action = $a['action'];
                //附带参数
                $fu = "";
                if ($a['data']) {
                    $fu = "?" . $a['data'];
                }
                $array = array(
                    "icon" => "",
                    "id" => $id . $name,
                    "name" => $a['name'],
                    "parent" => $parent,
                    "url" => U("{$name}/{$controller}/{$action}{$fu}", array("menuid" => $id)),
                );
                $ret[$id . $name] = $array;
                $child = $this->getTree($a['id'], $id, $Level);
                //由于后台管理界面只支持三层，超出的不层级的不显示
                if ($child && $Level <= 3) {
                    $ret[$id . $name]['items'] = $child;
                }
            }
        }
        return $ret;
    }

    /**
     * 获取菜单导航
     * @param type $app
     * @param type $model
     * @param type $action
     */
    public function getMenu() {
        $menuid = I('get.menuid', 0, 'intval');
        $menuid = $menuid ? $menuid : cookie("menuid", "", array("prefix" => ""));
        $info = $this->where(array("id" => $menuid))->getField("id,action,app,controller,parentid,parameter,type,name");
        $find = $this->where(array("parentid" => $menuid, "status" => 1))->getField("id,action,app,controller,parentid,parameter,type,name");
        if ($find) {
            array_unshift($find, $info[$menuid]);
        } else {
            $find = $info;
        }
        foreach ($find as $k => $v) {
            $find[$k]['parameter'] = "menuid={$menuid}&{$find[$k]['parameter']}";
        }
        return $find;
    }

    // 写入数据前的回调方法 包括新增和更新
    protected function _before_write(&$data) {
        if ($data['app']) {
            $data['app'] = ucwords($data['app']);
        }
        if ($data['controller']) {
            $data['controller'] = ucwords($data['controller']);
        }
        if ($data['action']) {
            $data['action'] = strtolower($data['action']);
        }
    }

}
