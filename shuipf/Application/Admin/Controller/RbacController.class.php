<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 系统权限配置，用户角色管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Common\Controller\AdminBase;

class RbacController extends AdminBase {

    //角色管理首页
    public function rolemanage() {
        $tree = new \Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $roleList = D("Admin/Role")->getTreeArray();
        foreach ($roleList as $k => $rs) {
            $operating = '';
            if ($rs['id'] == 1) {
                $operating = '<font color="#cccccc">权限设置</font> | <a href="' . U('Management/manager', array('role_id' => $rs['id'])) . '">成员管理</a> | <font color="#cccccc">修改</font> | <font color="#cccccc">删除</font>';
            } else {
                $operating = '<a href="' . U("Rbac/authorize", array("id" => $rs["id"])) . '">权限设置</a> | <a href="' . U('Management/manager', array('role_id' => $rs['id'])) . '">成员管理</a> | <a href="' . U('Rbac/roleedit', array('id' => $rs['id'])) . '">修改</a> | <a class="J_ajax_del" href="' . U('Rbac/roledelete', array('id' => $rs['id'])) . '">删除</a>';
            }
            $roleList[$k]['operating'] = $operating;
        }
        $str = "<tr>
          <td>\$id</td>
          <td>\$spacer\$name</td>
          <td>\$remark</td>
          <td align='center'><font color='red'>√</font></td>
          <td align='center'>\$operating</td>
        </tr>";
        $tree->init($roleList);
        $this->assign("role", $tree->get_tree(0, $str));
        $this->assign("data", D("Admin/Role")->order(array("listorder" => "asc", "id" => "desc"))->select())
                ->display();
    }

    //添加角色
    public function roleadd() {
        if (IS_POST) {
            if (D("Admin/Role")->create()) {
                if (D("Admin/Role")->add()) {
                    $this->success("添加角色成功！", U("Rbac/rolemanage"));
                } else {
                    $this->error("添加失败！");
                }
            } else {
                $error = D("Admin/Role")->getError();
                $this->error($error ? $error : '添加失败！');
            }
        } else {
            $this->display();
        }
    }

    /**
     * 删除角色
     */
    public function roledelete() {
        $id = I('get.id', 0, 'intval');
        if (D("Admin/Role")->roleDelete($id)) {
            $this->success("删除成功！", U('Rbac/rolemanage'));
        } else {
            $error = D("Admin/Role")->getError();
            $this->error($error ? $error : '删除失败！');
        }
    }

    //编辑角色
    public function roleedit() {
        $id = I('request.id', 0, 'intval');
        if (empty($id)) {
            $this->error('请选择需要编辑的角色！');
        }
        if (1 == $id) {
            $this->error("超级管理员角色不能被修改！");
        }
        if (IS_POST) {
            if (D("Admin/Role")->create()) {
                if (D("Admin/Role")->where(array('id' => $id))->save()) {
                    $this->success("修改成功！", U('Rbac/rolemanage'));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $error = D("Admin/Role")->getError();
                $this->error($error ? $error : '修改失败！');
            }
        } else {
            $data = D("Admin/Role")->where(array("id" => $id))->find();
            if (empty($data)) {
                $this->error("该角色不存在！", U('rolemanage'));
            }
            $this->assign("data", $data)
                    ->display();
        }
    }

    //角色授权
    public function authorize() {
        if (IS_POST) {
            $roleid = I('post.roleid', 0, 'intval');
            if (!$roleid) {
                $this->error("需要授权的角色不存在！");
            }
            //被选中的菜单项
            $menuidAll = explode(',', I('post.menuid', ''));
            if (is_array($menuidAll) && count($menuidAll) > 0) {
                //取得菜单数据
                $menu_info = cache('Menu');
                $addauthorize = array();
                //检测数据合法性
                foreach ($menuidAll as $menuid) {
                    if (empty($menu_info[$menuid])) {
                        continue;
                    }
                    $info = array(
                        'app' => $menu_info[$menuid]['app'],
                        'controller' => $menu_info[$menuid]['controller'],
                        'action' => $menu_info[$menuid]['action'],
                        'type' => $menu_info[$menuid]['type'],
                    );
                    //菜单项
                    if ($info['type'] == 0) {
                        $info['app'] = $info['app'];
                        $info['controller'] = $info['controller'] . $menuid;
                        $info['action'] = $info['action'] . $menuid;
                    }
                    $info['role_id'] = $roleid;
                    $info['status'] = $info['type'] ? 1 : 0;
                    $addauthorize[] = $info;
                }
                if (D('Admin/Access')->batchAuthorize($addauthorize, $roleid)) {
                    $this->success("授权成功！", U("Rbac/rolemanage"));
                } else {
                    $error = D("Admin/Access")->getError();
                    $this->error($error ? $error : '授权失败！');
                }
            } else {
                $this->error("没有接收到数据，执行清除授权成功！");
            }
        } else {
            //角色ID
            $roleid = I('get.id', 0, 'intval');
            if (empty($roleid)) {
                $this->error("参数错误！");
            }
            //菜单缓存
            $result = cache("Menu");
            //获取已权限表数据
            $priv_data = D("Admin/Role")->getAccessList($roleid);
            $json = array();
            foreach ($result as $rs) {
                $data = array(
                    'id' => $rs['id'],
                    'checked' => $rs['id'],
                    'parentid' => $rs['parentid'],
                    'name' => $rs['name'] . ($rs['type'] == 0 ? "(菜单项)" : ""),
                    'checked' => D("Admin/Role")->isCompetence($rs, $roleid, $priv_data) ? true : false,
                );
                $json[] = $data;
            }
            $this->assign('json', json_encode($json))
                    ->assign("roleid", $roleid)
                    ->assign('name', D("Admin/Role")->getRoleIdName($roleid))
                    ->display();
        }
    }

}
