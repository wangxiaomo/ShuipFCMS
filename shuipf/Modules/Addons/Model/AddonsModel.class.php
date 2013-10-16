<?php

/**
 * 插件模型
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class AddonsModel extends CommonModel {

    //插件所处目录路径
    protected $addonsPath = NULL;

    protected function _initialize() {
        parent::_initialize();
        $this->addonsPath = APP_PATH . 'Addons' . DIRECTORY_SEPARATOR;
    }

    /**
     * 执行行为
     * @param type $behavior 行为规则
     * @param type $params 参数
     * @return boolean
     */
    public function execution($behavior, &$params) {
        $addonName = $behavior['addon'];
        if (empty($addonName) || empty($behavior['action'])) {
            return false;
        }
        //检查执行周期
        if ($behavior['cycle'] && $behavior['max']) {
            $guid = to_guid_string($behavior);
            $where = array(
                'ruleid' => $ruleId,
                'guid' => $guid,
            );
            $where['create_time'] = array('gt', NOW_TIME - intval($behavior['cycle']) * 3600);
            $executionCount = M('BehaviorLog')->where($where)->count('id');
            if ($executionCount >= (int) $behavior['max']) {
                return false;
            }
        }
        $addonsCache = F('Addons');
        if (false == $addonsCache) {
            $this->addons_cache();
        }
        //检查插件是否安装
        if (empty($addonsCache) || !isset($addonsCache[$addonName])) {
            return false;
        }
        $action = $behavior['action'];
        import('Addons.Util.Addon', APP_PATH . C('APP_GROUP_PATH') . '/');
        //获取类名
        $class = $this->getAddonClassName($addonName);
        //执行文件地址
        $filePath = $this->addonsPath . "{$addonName}/{$addonName}Addon.class.php";
        //导入对应插件
        require_cache($filePath);
        if (!class_exists($class)) {
            if (APP_DEBUG) { // 记录行为的执行日志
                trace('[ 插件 ' . $addonName . ' 入口文件不存在] --File:' . $filePath, '', 'INFO');
            }
            return false;
        }
        $obj = get_instance_of($class);
        if (method_exists($obj, $action)) {
            $obj->$action($params);
        } else {
            if (APP_DEBUG) { // 记录行为的执行日志
                trace('[ 插件 ' . $addonName . ' 中方法 ' . $action . ' 不存在] --File:' . $filePath, '', 'INFO');
            }
        }
        return true;
    }

    /**
     * 安装插件
     * @param type $addonName 插件标识
     * @return boolean
     */
    public function installAddon($addonName) {
        if (empty($addonName)) {
            $this->error = '请选择需要安装的插件！';
            return false;
        }
        //获取类名
        $class = $this->getAddonClassName($addonName);
        //导入对应插件
        require_cache($this->addonsPath . "{$addonName}/{$addonName}Addon.class.php");
        if (!class_exists($class)) {
            $this->error = '插件不存在或者插件入口文件有误！';
            return false;
        }
        //实例化插件入口类
        $addonObj = new $class();
        //获取插件信息
        $info = $addonObj->info;
        if (empty($info)) {
            $this->error = '插件信息获取失败！';
            return false;
        }
        //插件信息验证
        $data = $this->token(false)->create($info, 1);
        if (!$data) {
            return false;
        }
        //开始安装
        $install = $addonObj->install();
        if (!$install) {
            $this->error = '执行插件预安装操作失败！';
            return false;
        }
        //添加插件安装记录
        $id = $this->add($data);
        if (!$id) {
            $this->error = '写入插件数据失败！';
            return false;
        }
        $data['id'] = $id;
        //写入插件配置
        $config = $addonObj->getAddonConfig();
        $this->where(array('id' => $id))->save(array('config' => serialize($config)));
        //如果插件有自己的后台
        if ($data['has_adminlist']) {
            $adminlist = $addonObj->adminlist;
            //添加菜单
            $this->addAddonMenu($data, $adminlist);
        }
        //更新插件行为实现
        $this->addonBehavior($addonName);
        //更新缓存
        $this->addons_cache();
        return $id;
    }

    /**
     * 卸载插件
     * @param type $addonId 插件id
     * @return boolean
     */
    public function uninstallAddon($addonId) {
        $addonId = (int) $addonId;
        if (empty($addonId)) {
            $this->error = '请选择需要卸载的插件！';
            return false;
        }
        //获取插件信息
        $info = $this->where(array('id' => $addonId))->find();
        if (empty($info)) {
            $this->error = '该插件不存在！';
            return false;
        }
        $addonName = $info['name'];
        //获取类名
        $class = $this->getAddonClassName($addonName);
        //导入对应插件
        require_cache($this->addonsPath . "{$addonName}/{$addonName}Addon.class.php");
        if (!class_exists($class)) {
            $this->error = '插件不存在或者插件入口文件有误！';
            return false;
        }
        //实例化插件入口类
        $addonObj = new $class();
        //卸载插件
        $uninstall = $addonObj->uninstall();
        if (!$uninstall) {
            $this->error = '执行插件预卸载操作失败！';
            return false;
        }
        //删除插件记录
        if (false !== $this->where(array('id' => $addonId))->delete()) {
            //删除对应附件
            service("Attachment")->api_delete('addons-' . $addonId);
            //删除插件后台菜单
            if ($info['has_adminlist']) {
                $this->delAddonMenu($info);
            }
            //更新缓存
            $this->addons_cache();
            //删除行为挂载点
            M('BehaviorRule')->where(array('addons' => $addonName, 'system' => 0))->delete();
            //更新行为缓存
            D('Behavior')->behavior_cache();
            return true;
        } else {
            $this->error = '卸载插件失败！';
            return false;
        }
    }

    /**
     * 插件状态转换
     * @param type $addonId 插件ID
     * @return boolean
     */
    public function statusAddon($addonId) {
        $addonId = (int) $addonId;
        if (empty($addonId)) {
            $this->error = '请选择需要卸载的插件！';
            return false;
        }
        //获取插件信息
        $info = $this->where(array('id' => $addonId))->find();
        if (empty($info)) {
            $this->error = '该插件不存在！';
            return false;
        }
        $status = $info['status'] ? 0 : 1;
        if (false !== $this->where(array('id' => $addonId))->save(array('status' => $status))) {
            //更新缓存
            $this->addons_cache();
            return true;
        } else {
            $this->error = '插件状态失败！';
            return false;
        }
    }

    /**
     * 获取插件列表
     * @return type
     */
    public function getAddonList() {
        //取得模块目录名称
        $dirs = array_map('basename', glob($this->addonsPath . '*', GLOB_ONLYDIR));
        if ($dirs === FALSE || !file_exists($this->addonsPath)) {
            return false;
        }
        $addons = array();
        //取得已安装插件列表
        $addonsList = $this->where(array('name' => array('in', $dirs)))->select();
        foreach ($addonsList as $addon) {
            $addon['uninstall'] = 0;
            $addon['config'] = unserialize($addon['config']);
            $addons[$addon['name']] = $addon;
        }
        //遍历插件列表
        foreach ($dirs as $value) {
            //是否已经安装过
            if (!isset($addons[$value])) {
                //获取类名
                $class = $this->getAddonClassName($value);
                //导入对应插件
                require_cache($this->addonsPath . $value . "/{$value}Addon.class.php");
                //检查类名是否存在
                if (!class_exists($class)) {
                    Log::record('插件' . $value . '的入口文件不存在！');
                    continue;
                }
                //实例化插件入口类
                $addonObj = new $class();
                //获取插件配置
                $addons[$value] = $addonObj->info;
                if ($addons[$value]) {
                    $addons[$value]['uninstall'] = 1;
                    unset($addons[$value]['status']);
                    //是否有配置
                    $config = $addonObj->getAddonConfig();
                    $addons[$value]['config'] = $config;
                }
            }
        }

        return $addons;
    }

    /**
     * 获取插件类名
     * @param type $name 插件标识
     * @return boolean
     */
    public function getAddonClassName($name) {
        if (empty($name)) {
            $this->error = '插件名称不能为空！';
            return false;
        }
        return $name . 'Addon';
    }

    /**
     * 获取插件目录
     * @return type
     */
    public function getAddonsPath() {
        return $this->addonsPath;
    }

    /**
     * 删除对应插件菜单和权限
     * @param type $info 插件信息
     * @return boolean
     */
    public function delAddonMenu($info) {
        if (empty($info)) {
            return false;
        }
        //查询出“插件后台列表”菜单ID
        $menuId = M("Menu")->where(array("app" => "Addons", "model" => "Addons", "action" => "addonadmin"))->getField('id');
        if (empty($menuId)) {
            return false;
        }
        //删除对应菜单
        M("Menu")->where(array('app' => 'Addons', 'model' => $info['name']))->delete();
        //删除权限
        M("Access")->where(array("g" => "Addons", 'm' => $info['name']))->delete();
        //检查“插件后台列表”菜单下还有没有菜单，没有就隐藏
        $count = M("Menu")->where(array('parentid' => $menuId))->count();
        if (!$count) {
            M("Menu")->where(array('id' => $menuId))->save(array('status' => 0));
        }
        return true;
    }

    /**
     * 添加插件后台管理菜单
     * @param type $info
     * @param type $adminlist
     * @return boolean
     */
    protected function addAddonMenu($info, $adminlist = NULL) {
        if (empty($info)) {
            return false;
        }
        //查询出“插件后台列表”菜单ID
        $menuId = M("Menu")->where(array("app" => "Addons", "model" => "Addons", "action" => "addonadmin"))->getField('id');
        if (empty($menuId)) {
            return false;
        }
        //添加插件后台
        $parentid = M("Menu")->add(
                array(
                    //父ID
                    "parentid" => $menuId,
                    //模块目录名称，也是项目名称
                    "app" => "Addons",
                    //插件名称
                    "model" => $info['name'],
                    //方法名称
                    "action" => "index",
                    //附加参数 例如：a=12&id=777
                    "data" => "isadmin=1",
                    //类型，1：权限认证+菜单，0：只作为菜单
                    "type" => 1,
                    //状态，1是显示，2是不显示
                    "status" => 1,
                    //名称
                    "name" => $info['title'],
                    //备注
                    "remark" => $info['title'] . "插件管理后台！",
                    //排序
                    "listorder" => 0,
                )
        );
        if (!$parentid) {
            return false;
        }
        //显示“插件后台列表”菜单
        M("Menu")->where(array('id' => $menuId))->save(array('status' => 1));
        //插件具体菜单
        if (!empty($adminlist)) {
            foreach ($adminlist as $key => $menu) {
                //检查参数是否存在
                if (empty($menu['name']) || empty($menu['action'])) {
                    continue;
                }
                //如果是index，跳过，因为已经有了。。。
                if ($menu['action'] == 'index') {
                    continue;
                }
                $data = array(
                    //父ID
                    "parentid" => $parentid,
                    //模块目录名称，也是项目名称
                    "app" => "Addons",
                    //文件名称，比如LinksAction.class.php就填写 Links
                    "model" => $info['name'],
                    //方法名称
                    "action" => $menu['action'],
                    //附加参数 例如：a=12&id=777
                    "data" => 'isadmin=1',
                    //类型，1：权限认证+菜单，0：只作为菜单
                    "type" => $menu['type'] ? (int) $menu['type'] : 1,
                    //状态，1是显示，2是不显示
                    "status" => (int) $menu['status'],
                    //名称
                    "name" => $menu['name'],
                    //备注
                    "remark" => $menu['remark'],
                    //排序
                    "listorder" => (int) $menu['listorder'],
                );
                M("Menu")->add($data);
            }
        }
        return true;
    }

    /**
     * 挂载行为
     * @param type $addonName 插件名称
     * @return boolean
     */
    protected function addonBehavior($addonName) {
        if (empty($addonName)) {
            return false;
        }
        //获取类名
        $class = $this->getAddonClassName($addonName);
        //导入对应插件
        require_cache($this->addonsPath . "{$addonName}/{$addonName}Addon.class.php");
        if (!class_exists($class)) {
            return false;
        }
        //获取这个插件总的方法列表，数组
        $methods = get_class_methods($class);
        //取得已经存在的行为列表
        $behavior = M('Behavior')->getField('name', true);
        //交集数组
        $common = array_intersect($behavior, $methods);
        if (empty($common)) {
            return false;
        }
        foreach ($common as $beh) {
            //检查是否有同样的行为
            $behaviorInfo = D('Behavior')->where(array('name' => $beh))->find();
            if ($behaviorInfo) {
                //添加规则
                $data = array(
                    'behaviorid' => $behaviorInfo['id'],
                    'addons' => $addonName,
                    'rule' => "addon:{$addonName}|action:{$beh}",
                    'datetime' => time(),
                );
                M('BehaviorRule')->add($data);
            }
        }
        //更新行为缓存
        D('Behavior')->behavior_cache();
        return true;
    }

    /**
     * 缓存已安装插件缓存
     * @return type
     */
    public function addons_cache() {
        $return = array();
        $data = $this->where(array('status' => 1))->order(array('id' => 'DESC'))->select();
        if (!empty($data)) {
            foreach ($data as $r) {
                $r['config'] = unserialize($r['config']);
                $return[$r['name']] = $r;
            }
        }
        F('Addons', $return);
        return $return;
    }

}