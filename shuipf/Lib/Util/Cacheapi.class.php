<?php

/**
 * 缓存更新
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class Cacheapi {

    //重新生成  Category Model Menu
    public function site_cache() {
        D("Config")->config_cache();
        D("Category")->category_cache();
        D("Model")->model_cache();
        //后台菜单
        D("Menu")->menu_cache();
        //评论配置缓存
        D("Comments")->comments_cache();
        //URL规则
        $this->urlrule_cache();
    }

    // 更新模型缓存方法
    public function model_content_cache() {
        D("Content_cache")->model_content_cache();
        //推荐位缓存更新
        $this->position_cache();
    }

    //生成模型字段缓存 
    public function model_field_cache() {
        D("Model_field")->model_field_cache();
    }

    //生成 Urlrule URL规则缓存 
    public function urlrule_cache() {
        D("Urlrule")->public_cache_urlrule();
    }

    //推荐位缓存
    public function position_cache() {
        D("Position")->position_cache();
    }

    //可用应用列表缓存 
    public function appstart_cache() {
        D("Module")->module_cache();
    }

    //生成敏感词缓存
    public function censorword_cache() {
        D("Censor")->censorword_cache();
    }

    //插件缓存更新
    public function addons_cache() {
        if(isModuleInstall('Addons')){
            D('Addons/Addons')->addons_cache();
        }
    }

}
