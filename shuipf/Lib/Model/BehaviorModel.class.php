<?php

/**
 * 行为模型
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class BehaviorModel extends RelationModel {

    //array(验证字段,验证规则,错误提示,[验证条件,附加规则,验证时间])
    protected $_validate = array(
        array('name', 'require', '行为标识不能为空！'),
        array('name', '/^[a-zA-Z][a-zA-Z0-9_]+$/i', '行为标识只支持英文！', 0, 'regex', 3),
        array('name', '', '该行为标识已经存在！', 0, 'unique', 1),
        array('title', 'require', '行为名称不能为空！'),
    );
    //array(填充字段,填充内容,[填充条件,附加规则])
    protected $_auto = array(
        array('status', 1),
        array('system', 0),
        array('datetime', 'time', 1, 'function'),
    );

    /**
     * 解析行为规则
     * 规则定义  table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
     * 规则字段解释：table->要操作的数据表，不需要加表前缀；
     *              field->要操作的字段；
     *              condition->操作的条件，目前支持字符串，默认变量{$self}为执行行为的用户
     *              rule->对字段进行的具体操作，目前支持四则混合运算，如：1+score*2/2-3
     *              cycle->执行周期，单位（小时），表示$cycle小时内最多执行$max次
     *              max->单个周期内的最大执行次数（$cycle和$max必须同时定义，否则无效）
     * 单个行为后可加 ； 连接其他规则
     * @param string $action 行为id或者name
     * @return boolean|array: false解析出错 ， 成功返回规则数组
     */
    public function parseBehavior($action = null) {
        if (empty($action)) {
            return false;
        }
        //参数支持id或者name
        if (is_numeric($action)) {
            $map = array('id' => $action);
        } else {
            $map = array('name' => $action);
        }
        //查询行为信息
        $info = $this->where($map)->find();
        if (empty($info) || $info['status'] != 1) {
            return false;
        }
        //查询规则
        $behaviorRule = M('BehaviorRule');
        $ruleList = $behaviorRule->where(array('behaviorid' => $info['id']))->order(array('listorder' => 'ASC', 'ruleid' => 'ASC'))->getField('ruleid,rule,system,module', true);
        if (empty($ruleList)) {
            return false;
        }

        //解析规则:table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
        $return = array();
        foreach ($ruleList as $key => $ruleInfo) {
            $rule = $ruleInfo['rule'];
            $return[$key] = array(
                'ruleid' => $key,
            );
            //行为文件
            if (substr($rule, 0, 8) == 'phpfile:') {
                $rule = explode('|', $rule);
                $phpfile = str_replace('phpfile:', '', $rule[0]);
                $module = $rule[1] ? ucwords(str_replace('module:', '', $rule[1])) : '';
                //规则类型
                $return[$key]['_type'] = 2;
                $return[$key]['module'] = $module;
                //行为名称
                $return[$key]['behavior'] = ucwords($phpfile);
                //如果不为空，表示是某个模块下的扩展行为
                if (empty($module)) {
                    //判断是否系统行为规则
                    if ($ruleInfo['system']) {
                        //如果是系统行为规则，定位到tp目录中的Behavior
                        $return[$key]['phpfile'] = CORE_PATH . 'Behavior/' . $phpfile . 'Behavior.class.php';
                    } else {
                        $return[$key]['phpfile'] = APP_PATH . 'Lib/Behavior/' . $phpfile . 'Behavior.class.php';
                    }
                } else {
                    $return[$key]['phpfile'] = APP_PATH . C('APP_GROUP_PATH') . '/' . $module . '/Behavior/' . $phpfile . 'Behavior.class.php';
                }
            } else {//简单规则条件
                //$rule = str_replace('{$self}', $self, $rule);
                $rule = explode('|', $rule);
                foreach ($rule as $k => $fields) {
                    $field = empty($fields) ? array() : explode(':', $fields);
                    if (!empty($field)) {
                        $return[$key][$field[0]] = $field[1];
                    }
                }
                //cycle(检查周期)和max(周期内最大执行次数)必须同时存在，否则去掉这两个条件
                if (!array_key_exists('cycle', $return[$key]) || !array_key_exists('max', $return[$key])) {
                    unset($return[$key]['cycle']);
                    unset($return[$key]['max']);
                }
                //规则类型
                $return[$key]['_type'] = 1;
            }
        }
        return $return;
    }

    /**
     * 执行规则行为，也是就是类型为1的规则
     * @param type $rule
     * @param type $params
     * @return boolean
     */
    public function execution($rule = false, &$params = null) {
        if (!$rule) {
            return false;
        }
        $ruleId = $rule['ruleid'];
        if (APP_DEBUG) {
            G($ruleId . 'Start');
            trace('[ 行为规则ID：' . $ruleId . ' ] --START--', '', 'INFO');
        }
        //操作的条件参数处理
        if (!empty($params)) {
            if (is_array($params)) {
                foreach ($params as $name => $value) {
                    $value = "'" . str_replace("'", "\'", $value) . "'";
                    $rule['condition'] = str_replace('{$' . $name . '}', $value, $rule['condition']);
                }
            }
            $value = "'" . str_replace("'", "\'", $params) . "'";
            $rule['condition'] = str_replace('{$self}', $value, $rule['condition']);
        }
        //检查执行周期
        if ($rule['cycle'] && $rule['max']) {
            $guid = to_guid_string($rule);
            $where = array(
                'ruleid' => $ruleId,
                'guid' => $guid,
            );
            $where['create_time'] = array('gt', NOW_TIME - intval($rule['cycle']) * 3600);
            $executionCount = M('BehaviorLog')->where($where)->count('id');
            if ($executionCount >= (int) $rule['max']) {
                return false;
            }
        }
        //执行数据库操作
        $tableName = ucfirst($rule['table']);
        $Model = M($tableName);
        $field = $rule['field'];
        $return = $Model->where($rule['condition'])->setField($field, array('exp', $rule['rule']));
        if (APP_DEBUG) { // 记录行为的执行日志
            trace('[ 行为规则ID：' . $ruleId . ' ] --END-- [ RunTime:' . G($ruleId . 'Start', $ruleId . 'End', 6) . 's ]', '', 'INFO');
        }
        if ($return) {
            if ($rule['cycle'] && $rule['max']) {
                M('BehaviorLog')->add(array(
                    'ruleid' => $ruleId,
                    'guid' => $guid,
                    'create_time' => NOW_TIME,
                ));
            }
        }
        return $return;
    }

    /**
     * 根据行为ID取得对应的行为信息和规则
     * @param type $id 行为ID
     * @return boolean|array
     */
    public function getBehaviorById($id) {
        $id = (int) $id;
        if (empty($id)) {
            $this->error = '参数错误！';
            return false;
        }
        //查询行为是否存在
        $info = $this->where(array('id' => $id))->find();
        if (empty($info)) {
            $this->error = '该行为不存在！';
            return false;
        }
        //查询对应行为的所属规则
        $ruleList = M('BehaviorRule')->where(array('behaviorid' => $id))->order(array('listorder' => 'ASC', 'ruleid' => 'ASC'))->select();
        if (empty($ruleList)) {
            $ruleList = array();
        }
        $info['ruleList'] = $ruleList;
        return $info;
    }

    /**
     * 添加行为，同时添加行为规则
     * @param type $data
     * @return boolean
     */
    public function addBehavior($data) {
        if (empty($data)) {
            $this->error = '数据不能为空！';
            return false;
        }
        //行为规则
        $ruleList = $data['rule'];
        //排序
        $listorder = $data['listorder'];
        //验证数据
        $data = $this->create($data, 1);
        if ($data) {
            $id = $this->add($data);
            if ($id) {
                if (!empty($ruleList)) {
                    $data = array();
                    $time = time();
                    foreach ($ruleList as $key => $rule) {
                        if (!empty($rule)) {
                            $data[] = array(
                                'behaviorid' => $id,
                                'system' => 0,
                                'module' => '',
                                'rule' => $rule,
                                'listorder' => $listorder[$key],
                                'datetime' => $time,
                            );
                        }
                    }
                    //批量添加规则
                    if (!empty($data)) {
                        M('BehaviorRule')->addAll($data);
                    }
                }
                return $id;
            } else {
                $this->error = '行为添加失败！';
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 编辑行为规则
     * @param type $data
     * @return boolean
     */
    public function editBehavior($data) {
        if (empty($data) || empty($data['id'])) {
            $this->error = '数据不能为空！';
            return false;
        }
        //行为ID
        $behaviorId = $data['id'];
        unset($data['id']);
        //行为规则
        $ruleList = $data['rule'];
        //新添加行为规则
        $newruleList = $data['newrule'];
        //排序
        $listorder = $data['listorder'];
        //新添加的排序
        $newlistorder = $data['newlistorder'];
        //验证数据
        $data = $this->create($data, 2);
        if ($data) {
            if (false !== $this->where(array('id' => $behaviorId, 'system' => 0))->save($data)) {
                $behaviorRule = M('BehaviorRule');
                //查询出原本所属该行为的全部规则id
                $oldRuleId = $behaviorRule->where(array('behaviorid' => $behaviorId))->getField('ruleid', true);
                //更新旧的规则
                if (!empty($ruleList)) {
                    foreach ($oldRuleId as $ruleid) {
                        if ($ruleList[$ruleid]) {
                            $behaviorRule->where(array('ruleid' => $ruleid, 'behaviorid' => $behaviorId, 'system' => 0))->save(array(
                                'rule' => $ruleList[$ruleid],
                                'listorder' => $listorder[$ruleid],
                            ));
                        } else {
                            $behaviorRule->where(array('ruleid' => $ruleid, 'behaviorid' => $behaviorId, 'system' => 0))->delete();
                        }
                    }
                } else {
                    //清空
                    $behaviorRule->where(array('behaviorid' => $behaviorId))->delete();
                }
                //新增规则
                if (!empty($newruleList)) {
                    $data = array();
                    $time = time();
                    foreach ($newruleList as $key => $rule) {
                        if (!empty($rule)) {
                            $data[] = array(
                                'behaviorid' => $behaviorId,
                                'system' => 0,
                                'module' => '',
                                'rule' => $rule,
                                'listorder' => $newlistorder[$key],
                                'datetime' => $time,
                            );
                        }
                    }
                    //批量添加规则
                    if (!empty($data)) {
                        $behaviorRule->addAll($data);
                    }
                }
                return true;
            } else {
                $this->error = '更新失败！';
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 删除行为
     * @param type $id 行为ID
     * @return boolean
     */
    public function delBehaviorById($id) {
        $id = (int) $id;
        if (empty($id)) {
            $this->error = '请指定需要删除的行为！';
            return false;
        }
        //查询出该行为
        $info = $this->where(array('id' => $id))->find();
        if (empty($info)) {
            $this->error = '该行为不存在！';
            return false;
        }
        //检查是否系统行为
        if ($info['system']) {
            $this->error = '系统行为不允许删除！';
            return false;
        }
        $behaviorRule = M('BehaviorRule');
        //检查该行为下是否有系统规则
        if ($behaviorRule->where(array('behaviorid' => $id, 'system' => 1))->count()) {
            $this->error = '该行为下存在系统规则，无法进行删除！';
            return false;
        }
        //执行删除
        if (false !== $this->where(array('id' => $id, 'system' => 0))->delete()) {
            //删除行为规则
            $behaviorRule->where(array('behaviorid' => $id))->delete();
            return true;
        } else {
            $this->error = '行为删除失败！';
            return false;
        }
    }

    /**
     * 根据所属模块，删除对应的行为规则
     * @param type $module 模块标识
     * @return boolean
     */
    public function ruleDelByModule($module) {
        if (empty($module)) {
            $this->error = '请指定模块标识！';
            return false;
        }
        $behaviorRule = M('BehaviorRule');
        if (false !== $behaviorRule->where(array('module' => $module, 'system' => 0))->delete()) {
            return true;
        } else {
            $this->error = '删除失败！';
            return false;
        }
    }

    /**
     * 行为状态转换
     * @param type $id 行为ID
     * @return boolean
     */
    public function statusBehaviorById($id) {
        $id = (int) $id;
        if (empty($id)) {
            $this->error = '请指定需要状态转换的行为！';
            return false;
        }
        //查询出该行为
        $info = $this->where(array('id' => $id))->find();
        if (empty($info)) {
            $this->error = '该行为不存在！';
            return false;
        }
        //检查是否系统行为
        if ($info['system']) {
            $this->error = '系统行为不允许进行状态转换！';
            return false;
        }
        $behaviorRule = M('BehaviorRule');
        //检查该行为下是否有系统规则
        if ($behaviorRule->where(array('behaviorid' => $id, 'system' => 1))->count()) {
            $this->error = '该行为下存在系统规则，无法进行状态转换！';
            return false;
        }
        $status = $info['status'] ? 0 : 1;
        //执行状态转换
        if (false !== $this->where(array('id' => $id, 'system' => 0))->save(array('status' => $status))) {
            //删除行为规则
            $behaviorRule->where(array('behaviorid' => $id))->save(array('status' => $status));
            return true;
        } else {
            $this->error = '行为删除失败！';
            return false;
        }
    }

    /**
     * 缓存行为规则
     * @return boolean
     */
    public function behavior_cache() {
        $behaviorList = $this->where(array('status' => 1))->order(array('id' => 'ASC'))->select();
        if (empty($behaviorList)) {
            return false;
        }
        $return = array();
        foreach ($behaviorList as $behavior) {
            $return[$behavior['name']] = $this->parseBehavior($behavior['name']);
        }
        F('Behavior', $return);
        return $return;
    }

    //删除操作时删除缓存
    public function _after_delete($data, $options) {
        parent::_after_delete($data, $options);
        $this->behavior_cache();
    }

    //更新数据后更新缓存
    public function _after_update($data, $options) {
        parent::_after_update($data, $options);
        $this->behavior_cache();
    }

    //插入数据后更新缓存
    public function _after_insert($data, $options) {
        parent::_after_insert($data, $options);
        $this->behavior_cache();
    }

}