<?php

/**
 * 地图字段类型数据获取
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return type
 */
function map($field, $value) {
    foreach ($value as $r) {
        $data.='|' . $r;
    }
    return substr($data, 1);
}