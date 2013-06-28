<?php

//多好文本框
function textarea($field, $value) {
    $setting = unserialize($this->fields[$field]['setting']);
    if (!$setting['enablehtml']) {
        $value = strip_tags($value);
    }
    return $value;
}

?>