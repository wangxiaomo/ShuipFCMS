<?php

/**
 * 行为配置定义
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
$tags = array();
//应用初始化标签位
$tags['app_init'][] = 'Appframe';
//应用开始标签位
$tags['app_begin'][] = 'Appcheck';
//RABC
$tags['appframe_rbac_init'][] = 'Rbac';
//content_add_begin 内容添加开始 @data 添加内容原始数据
//content_add_end 内容添加完成 @data 添加内容经过content_input处理后的数据
//content_edit_begin 内容编辑开始 @data 编辑内容原始数据
//content_edit_end 内容编辑结束 @data 编辑内容后的数据content_input处理后
//content_delete_begin 删除内容前，被删除的文章内容数组
//content_delete_end 删除内容后 被删除的文章内容数组
//content_check_begin 审核前 被审核的信息数据
//content_check_end 审核后 被审核的信息数据
//comment_add_begin 评论添加开始 @data 添加评论原始数据
//comment_add_end 评论添加结束 @data 入库数据
//comment_edit_begin 编辑评论开始 @data 编辑评论提交数据
//comment_edit_end 编辑评论结束 @data 更新数据
//comment_delete_begin 删除评论开始 $ids 需要删除的评论ID
//comment_delete_end 删除评论结束 $ids 需要删除的评论ID
//comment_check_begin 评论审核开始  需要审核的评论ID，和审核状态
//comment_check_end 评论审核结束   需要审核的评论ID，和审核状态


return $tags;