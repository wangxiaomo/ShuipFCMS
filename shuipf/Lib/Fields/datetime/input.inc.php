<?php

function datetime($field, $value) {
    $setting = unserialize($this->fields[$field]['setting']);
    if ($setting['fieldtype'] == 'int') {
        if(!is_numeric($value)){
            $value = strtotime($value);
        }
    }
    return $value;
}

?>