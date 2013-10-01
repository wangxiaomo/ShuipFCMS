<?php

/**
 * 分页选择方式字段处理
 * @param type $field 字段名
 * @param type $value 字段内容
 * @return int
 */
function pages($field, $value) {
    $this->infoData[$this->ContentModel->getRelationName()]['paginationtype'] = empty($this->data['paginationtype']) ? 1 : $this->data['paginationtype'];
    $this->infoData[$this->ContentModel->getRelationName()]['maxcharperpage'] = empty($this->data['maxcharperpage']) ? 10000 : $this->data['maxcharperpage'];
    return $value;
}