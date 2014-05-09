<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 后台用户角色表
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Model;

use Common\Model\Model;

class RoleModel extends Model {

    //array(验证字段,验证规则,错误提示,[验证条件,附加规则,验证时间])
    protected $_validate = array(
        array('name', 'require', '角色名称不能为空！'),
        array('name', '', '该名称已经存在！', 0, 'unique', 3),
        array('status', 'require', '缺少状态！'),
        array('status', array(0, 1), '状态错误，状态只能是1或者0！', 2, 'in'),
    );
    //array(填充字段,填充内容,[填充条件,附加规则])
    protected $_auto = array(
        array('create_time', 'time', 1, 'function'),
        array('update_time', 'time', 3, 'function'),
        array('listorder', '0'),
    );

    /**
     * 删除角色
     * @param int $roleid 角色ID
     * @return boolean
     */
    public function roleDelete($roleid) {
        if (empty($roleid) || $roleid == 1) {
            return false;
        }
        $status = $this->where(array("id" => $roleid))->delete();
        if ($status !== false) {
            //删除access中的授权信息
            return D("Admin/Access")->where(array("role_id" => $roleid))->delete();
        }
        return false;
    }

    /**
     * 根据角色Id获取角色名
     * @param int $roleId 角色id
     * @return string 返回角色名
     */
    public function getRoleIdName($roleId) {
        return $this->where(array('id' => $roleId))->getField('name');
    }

}
