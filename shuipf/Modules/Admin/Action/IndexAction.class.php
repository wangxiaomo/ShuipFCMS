<?php

/**
 * 后台首页
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class IndexAction extends AdminbaseAction {

    //后台框架首页
    public function index() {
        $this->assign("SUBMENU_CONFIG", json_encode(D("Menu")->menu_json()));
        $this->display();
    }

    //缓存更新
    public function public_cache() {
        if (isset($_GET['type'])) {
            import("Dir");
            import('Cacheapi');
            $Cache = new Cacheapi();
            $Dir = new Dir();
            $type = I('get.type');
            switch ($type) {
                case "site":
                    try {
                        //删除缓存目录下的文件
                        $Dir->del(RUNTIME_PATH);
                        //删除Data目录
                        $Dir->delDir(RUNTIME_PATH . "Data/");
                        $Dir->delDir(RUNTIME_PATH . "Temp/");
                    } catch (Exception $exc) {
                        
                    }
                    //开始刷新缓存
                    $stop = I('get.stop', 0, 'intval');
                    if ($stop) {
                        $modules = array(
                            array('name' => "菜单，模型，栏目缓存更新成功！", 'function' => 'site_cache', 'param' => ''),
                            array('name' => "模型字段缓存更新成功！", 'function' => 'model_field_cache', 'param' => ''),
                            array('name' => "模型content处理类缓存更新成功！", 'function' => 'model_content_cache', 'param' => ''),
                            array('name' => "应用更新成功！", 'function' => 'appstart_cache', 'param' => ''),
                            array('name' => "敏感词缓存生成成功！", 'function' => 'censorword_cache', 'param' => ''),
                        );
                        //需要更新的缓存信息
                        $cacheInfo = $modules[$stop - 1];
                        if ($cacheInfo) {
                            $function = $cacheInfo['function'];
                            if ($function) {
                                $Cache->$function();
                            }
                            $this->assign("waitSecond", 200);
                            $this->success($cacheInfo['name'], U('Index/public_cache', array('type' => 'site', 'stop' => $stop + 1)));
                            exit;
                        } else {
                            $this->success('缓存更新完毕！', U('Index/public_cache'));
                            exit;
                        }
                    }
                    $this->success("即将更新站点缓存！", U('Index/public_cache', array('type' => 'site', 'stop' => 1)));
                    break;
                case "template":
                    $Dir->delDir(RUNTIME_PATH . "Cache/");
                    $Dir->delDir(RUNTIME_PATH . "Temp/");
                    $this->success("模板缓存清理成功！", U('Index/public_cache'));
                    break;
                case "logs":
                    $Dir->delDir(RUNTIME_PATH . "Logs/");
                    $this->success("站点日志清理成功！", U('Index/public_cache'));
                    break;
                default:
                    $this->error("请选择清楚缓存类型！");
                    break;
            }
        } else {
            $this->display("Index:cache");
        }
    }

    //后台框架首页菜单搜索
    public function public_find() {
        $keyword = I('get.keyword');
        if (!$keyword) {
            $this->error("请输入需要搜索的关键词！");
        }
        $where = array();
        $where['name'] = array("LIKE", "%$keyword%");
        $where['status'] = array("EQ", 1);
        $where['type'] = array("EQ", 1);
        $data = M("Menu")->where($where)->select();
        $menuData = $menuName = array();
        $Module = F("Module");
        foreach ($data as $k => $v) {
            $menuData[ucwords($v['app'])][] = $v;
            $menuName[ucwords($v['app'])] = $Module[ucwords($v['app'])]['name'];
        }
        $this->assign("menuData", $menuData);
        $this->assign("menuName", $menuName);
        $this->assign("keyword", $keyword);
        $this->display();
    }

}
