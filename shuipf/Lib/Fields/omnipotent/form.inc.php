<?php

/**
 * 万能字段字段类型表单处理
 * @param type $field 字段名 
 * @param type $value 字段内容
 * @param type $fieldinfo 字段配置
 * @return type
 */
function omnipotent($field, $value, $fieldinfo) {
    $setting = unserialize($fieldinfo['setting']);
    $formtext = str_replace('{FIELD_VALUE}', $value, $setting["formtext"]);
    $formtext = str_replace('{MODELID}', $this->modelid, $formtext);
    preg_match_all('/{FUNC\((.*)\)}/', $formtext, $_match);
    foreach ($_match[1] as $key => $match_func) {
        $string = '';
        $params = explode('~~', $match_func);
        $user_func = $params[0];
        $string = $user_func($params[1]);
        $formtext = str_replace($_match[0][$key], $string, $formtext);
    }
    $id = $this->id ? $this->id : 0;
    $formtext = str_replace('{ID}', $id, $formtext);
    //错误提示
    $errortips = $fieldinfo['errortips'];
    if ($fieldinfo['minlength']) {
        //验证规则
        $this->formValidateRules['info[' . $field . ']'] = array("required" => true);
        //验证不通过提示
        $this->formValidateMessages['info[' . $field . ']'] = array("required" => $errortips ? $errortips : $fieldinfo['name'] . "不能为空！");
    }
    return $formtext;
}