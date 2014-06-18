<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body>
<div class="wrap J_check_wrap" id="loadhtml">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">说明</div>
  <div class="prompt_text">
    <ul>
      <li>模块管理可以很好的扩展网站运营中所需功能！</li>
      <li><font color="#FF0000">获取更多模块请到官方网站模块扩展中下载安装！安装非官方发表模块需谨慎，有被清空数据库的危险！</font></li>
      <li>官网地址：<font color="#FF0000">http://www.shuipfcms.com</font>，<a href="http://www.shuipfcms.com" target="_blank">立即前往</a>！</li>
    </ul>
  </div>
  <div class="loading">loading...</div>
</div>
<script src="{$config_siteurl}statics/js/common.js"></script>
<script>
$(function(){
	$.get('{:U("index")}',{ page:'{$page}' },function(data){
		$('#loadhtml').append(data);
		$('div.loading').hide();
	});
});
</script>
</body>
</html>