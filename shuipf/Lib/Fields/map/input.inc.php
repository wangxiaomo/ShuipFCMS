<?php

/**
 * 地图字段类型数据获取
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function map($field, $value) {
    //因为是 有 x y 坐标，是以数组的形式
    if (is_array($value)) {
        $data = implode('|', $value);
    } else {
        $data = $value;
    }
    return $data;
}