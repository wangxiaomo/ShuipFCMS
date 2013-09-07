<?php

/**
 * 地图字段类型内容获取
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function map($field, $value) {
    $data = explode('|', $value);
    return $data;
}