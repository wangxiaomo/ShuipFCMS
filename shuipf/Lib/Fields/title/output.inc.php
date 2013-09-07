<?php

/**
 * 标题字段，读取时处理
 * @param type $field 字段名称
 * @param type $value 字段内容
 * @return type
 */
function title($field, $value) {
    $value = htmlspecialchars($value);
    return $value;
}