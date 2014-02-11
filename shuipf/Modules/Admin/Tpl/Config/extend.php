<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <form method='post'  class="J_ajaxForm"  action="{:U('Config/extend')}">
  <input type="hidden" name="action" value="add"/>
  <div class="h_a">添加扩展配置项</div>
  <div class="table_list">
    <table cellpadding="0" cellspacing="0" class="table_form" width="100%">
      <tbody>
        <tr>
          <td width="50">键名:</td>
          <td><input type="text" class="input" name="fieldname" value=""> 注意：只允许英文、数组、下划线</td>
        </tr>
        <tr>
          <td>名称:</td>
          <td><input type="text" class="input" name="setting[title]" value=""></td>
        </tr>
        <tr>
          <td>类型:</td>
          <td><select name="type" onChange="extend_type(this.value)">
              <option value="input" >单行文本框</option>
              <option value="textarea" >多行文本框</option>
              <option value="radio" >单选框</option>
              <option value="password" >密码输入框</option>
            </select></td>
        </tr>
        <tr>
          <td>提示:</td>
          <td><input type="text" class="input length_4" name="setting[tips]" value=""></td>
        </tr>
        <tr>
          <td>CSS样式:</td>
          <td><input type="text" class="input length_4" name="setting[style]" value=""></td>
        </tr>
        <tr class="setting_radio" style="display:none">
          <td>选项:</td>
          <td><textarea name="setting[option]" disabled="true" style="width:380px; height:150px;">选项名称1|选项值1</textarea> 注意：每行一个选项</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="btn_wrap_pd"><button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加</button></div>
  </form>
  <div class="h_a">扩展配置</div>
  <div class="table_full">
    <form method='post'   id="myform" class="J_ajaxForm"  action="{:U('Config/extend')}">
      <table width="100%"  class="table_form">
        <tr>
          <th width="120">邮件发送模式</th>
          <th class="y-bg"><input name="mail_type" checkbox="mail_type" value="1"  type="radio"  checked>
            SMTP 函数发送 </th>
        </tr>
      </table>
      <div class="btn_wrap">
        <div class="btn_wrap_pd">
          <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script>
function extend_type(type){
	if(type == 'radio'){
		$('.setting_radio').show();
		$('.setting_radio textarea').attr('disabled',false);
	}else{
		$('.setting_radio').hide();
		$('.setting_radio textarea').attr('disabled',true);
	}
}
</script>
</body>
</html>