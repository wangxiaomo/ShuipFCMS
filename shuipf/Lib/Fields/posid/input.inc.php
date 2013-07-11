<?php

function posid($field, $value) {
    if (empty($value) || !is_array($value)) {
        return 0;
    }
    $number = count($value);
    $value = $number == 1 ? 0 : 1;
    return $value;
}

?>
