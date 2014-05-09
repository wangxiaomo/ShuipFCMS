<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body>
<div class="wrap">
  <div id="home_toptip"></div>
  <h2 class="h_a">系统信息</h2>
  <div class="home_info">
    <ul>
      <volist name="server_info" id="vo">
        <li> <em>{$key}</em> <span>{$vo}</span> </li>
      </volist>
    </ul>
  </div>
  <h2 class="h_a">开发团队</h2>
  <div class="home_info" id="home_devteam">
    <ul>
      <li> <em>版权所有</em> <span><a href="http://www.shuipfcms.com" target="_blank">www.shuipfcms.com</a></span> </li>
      <li> <em>负责人</em> <span>水平凡</span> </li>
      <li> <em>微博</em> <span><a href="http://t.qq.com/shuipf" target="_blank">http://t.qq.com/shuipf</a></span> </li>
      <li> <em>联系邮箱</em> <span>admin@abc3210.com</span> </li>
      <li> <em>捐赠</em> <span>您因如果使用ShuipFCMS而受益或者感到愉悦，您还可以这样帮助ShuipFCMS成长~<br/>捐赠地址：<a href="https://me.alipay.com/shuipf" target="_blank">https://me.alipay.com/shuipf</a></span> </li>
      <li> <em><font color="#0000FF">在线使用手册</font></em> <span><a href="http://document.shuipfcms.com/" target="_blank">http://document.shuipfcms.com/</a></span> </li>
    </ul>
  </div>
  <h2 class="h_a" style="display:none">问题反馈</h2>
  <div class="table_full" style="display:none">
  <form method="post" action="http://www.abc3210.com/index.php?g=Formguide&a=post" id="RegForm" name="RegForm">
  <table width="100%" class="table_form">
  <input type="hidden" name="formid" value="4"/>
		<tr>
			<th width="80">类型<font color="red">*</font></th> 
			<td><select name='info[type]' id='type' ><option value="1" >意见反馈</option><option value="2" >Bug反馈</option></select></td>
		</tr>
        <tr>
			<th width="80">反馈者<font color="red">*</font></th> 
			<td><input type="text" name="info[name]"  class="input" id="name" /></td>
		</tr>
		<tr>
			<th>联系邮箱<font color="red">*</font></th> 
			<td><input type="text" name="info[email]"  class="input" id="email" /></td>
		</tr>
        <tr>
			<th>反馈内容<font color="red">*</font></th> 
			<td><textarea id="content" name="info[content]" style="width:600px; height:150px;"></textarea></td>
		</tr>
	</table>
  </div>
  <div class="" style="display:none">
      <div class="btn_wrap_pd">             
        <button class="btn btn_submit mr10" type="submit">提交</button>
      </div>
  </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js"></script> 
<script>
$("#btn_submit").click(function(){
	$("#tips_success").fadeTo(500,1);
});
</script>
</body>
</html>