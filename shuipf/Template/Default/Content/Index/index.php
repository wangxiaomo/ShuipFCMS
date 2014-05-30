<content action="lists" catid="66"  order="id DESC" num="4" page="$page" output="1">
循环列表，默认返回数据是$data
<?php
print_r($data);
?>
<ul>
<volist name="data" id="vo">
    <li>标题：{$vo.title}，地址：{$vo.url}</li>
</volist>
</ul>
分页：{$pages}
</content>