<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 后台用户权限模型
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Model;

use Common\Model\Model;

class AccessModel extends Model {

    /**
     * 根据角色ID返回全部权限
     * @param type $roleid 角色ID
     * @return array  
     */
    public function getAccessList($roleid) {
        if (empty($roleid)) {
            return false;
        }
        //查询出该角色拥有的全部权限列表
        $data = $this->where(array('role_id' => $roleid))->select();
        if (empty($data)) {
            return false;
        }
        $accessList = array();
        foreach ($data as $info) {
            unset($info['status']);
            $accessList[] = $info;
        }
        return $accessList;
    }

    /**
     * 检查用户是否有对应权限
     * @param type $map 方法[模块/控制器/方法]，为空自动获取
     * @return type
     */
    public function isCompetence($map = '') {
        if (!is_array($map)) {
            if (!empty($map)) {
                $map = trim($map, '/');
                $map = explode('/', $map);
                if (empty($map)) {
                    return false;
                }
            } else {
                $map = array(GROUP_NAME, CONTROLLER_NAME, ACTION_NAME,);
            }
            if (count($map) >= 3) {
                list($app, $controller, $action) = $map;
            } elseif (count($map) == 1) {
                $app = GROUP_NAME;
                $controller = CONTROLLER_NAME;
                $action = $map[0];
            } elseif (count($map) == 2) {
                $app = GROUP_NAME;
                list($controller, $action) = $map;
            }
            $map = array('role_id' => \Admin\Service\User::getInstance()->role_id, 'app' => $app, 'controller' => $controller, 'action' => $action);
        }
        $count = $this->where($map)->count();
        return $count ? true : false;
    }

}
