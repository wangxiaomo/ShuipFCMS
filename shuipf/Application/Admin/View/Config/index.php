<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
    <Admintemplate file="Common/Nav"/>
    <div class="h_a">站点配置</div>
    <div class="table_full">
    <form method='post'   id="myform" class="J_ajaxForm"  action="{:U('Config/index')}">
      <table cellpadding=0 cellspacing=0 width="100%" class="table_form" >
      
       <tr>
	     <th width="140">站点名称:</th>
	     <td><input type="text" class="input"  name="sitename" value="{$Site.sitename}" size="40"></td>
      </tr>
      <tr>
	     <th width="140">网站访问地址:</th>
	     <td><input type="text" class="input"  name="siteurl" value="{$Site.siteurl}" size="40"> <span class="gray"> 请以“/”结尾</span></td>
      </tr>
      <tr>
	     <th width="140">附件访问地址:</th>
	     <td><input type="text" class="input"  name="sitefileurl" value="{$Site.sitefileurl}" size="40"> <span class="gray"> 非上传目录设置</span></td>
      </tr>
      <tr>
	     <th width="140">联系邮箱:</th>
	     <td><input type="text" class="input"  name="siteemail" value="{$Site.siteemail}" size="40"> </td>
      </tr>
      <tr>
	     <th width="140">网站关键字:</th>
	     <td><input type="text" class="input"  name="sitekeywords" value="{$Site.sitekeywords}" size="40"> </td>
      </tr>
      <tr>
	     <th width="140">网站简介:</th>
	     <td><textarea name="siteinfo" style="width:380px; height:150px;">{$Site.siteinfo}</textarea> </td>
      </tr>
      <tr>
	     <th width="140">后台指定域名访问:</th>
	     <td><select name="domainaccess" id="domainaccess" >
            <option value="1" <if condition="$Site['domainaccess'] eq '1' "> selected</if>>开启指定域名访问</option>
            <option value="0" <if condition="$Site['domainaccess'] eq '0' "> selected</if>>关闭指定域名访问</option>
          </select> <span class="gray"> （该功能需要配合“域名绑定”模块使用，需要在域名绑定模块中添加域名！）</span></td>
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
<script type="text/javascript">
function generates(genid){
	//生成静态
	if(genid == 1){
		$("#index_ruleid_1").show();
		$("#index_ruleid_1 select").attr("disabled",false);
		$("#index_ruleid_0").hide();
		$("#index_ruleid_0 select").attr("disabled","disabled");
	}else{
		$("#index_ruleid_0").show();
		$("#index_ruleid_0 select").attr("disabled",false);
		$("#index_ruleid_1").hide();
		$("#index_ruleid_1 select").attr("disabled","disabled");
	}
}
</script>
</body>
</html>