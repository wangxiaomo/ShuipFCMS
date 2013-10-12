<?php

/**
 * 行为路由扩展
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class BehaviorDispatchBehavior extends Behavior {

    public function run(&$params) {
        if (empty($params)) {
            return false;
        }
        $rule = array();
        if (substr($params['behavior'], 0, 6) == 'addon:') {//简单规则条件
            $ruleList = explode('|', $params['behavior']);
            foreach ($ruleList as $k => $fields) {
                $field = empty($fields) ? array() : explode(':', $fields);
                if (!empty($field)) {
                    $rule[$field[0]] = $field[1];
                }
            }
            //cycle(检查周期)和max(周期内最大执行次数)必须同时存在，否则去掉这两个条件
            if (!array_key_exists('cycle', $rule) || !array_key_exists('max', $rule)) {
                unset($rule['cycle']);
                unset($rule['max']);
            }
            //执行
            D('Addons/Addons')->execution($rule, $params['params']);
        }
    }

}