<?php

/**
 * 地图字段类型表单组合处理
 * @param type $field 字段名
 * @param type $value 字段内容
 * @param type $fieldinfo 字段配置
 * @return type
 */
function map($field, $value, $fieldinfo) {
    if ($value) {
        $value = explode("|", $value);
        $mapx = $value[0];
        $mapy = $value[1];
    }
    $html = "<span style='line-height: 1.5;'>X坐标&nbsp;<input type='text' size='20' name='info[" . $field . "][mapx]' id='" . $field . "mapx' value='" . $mapx . "' class='input' />&nbsp;&nbsp;Y坐标&nbsp;<input type='text' size='20' name='info[" . $field . "][mapy]' id='" . $field . "mapy' value='" . $mapy . "' class='input' /></span>";
    return $html;
}