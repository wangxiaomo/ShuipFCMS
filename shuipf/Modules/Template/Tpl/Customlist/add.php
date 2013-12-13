<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">添加自定义页面</div>
  <form name="myform" id="myform" action="{:U("Template/Customlist/add")}" method="post" class="J_ajaxForm">
    <div class="table_full">
      <table cellpadding="0" cellspacing="0" class="table_form" width="100%">
        <tbody>
          <tr>
            <th width="120">自定义列表标题名称</th>
            <td><input type="text" class="input" name="name" value="" ></td>
          </tr>
          <tr>
            <th width="120">网页标题</th>
            <td><input type="text" class="input" name="title" value="" ></td>
          </tr>
          <tr>
            <th width="120">网页关键词</th>
            <td><input type="text" class="input" name="keywords" value=""  style="width:300px;"> </td>
          </tr>
          <tr>
            <th width="120">网页描述</th>
            <td><textarea name="description" style="width:95%; height:100px"></textarea></td>
          </tr>
          <tr>
            <th width="120">数据统计SQL</th>
            <td><input type="text" class="input" name="totalsql" value=""  style="width:95%;"> <br/>
            <span class="gray">如：select count(*) as total from shuipfcms_article where catid = 1</span></td>
          </tr>
          <tr>
            <th width="120">数据查询SQL</th>
            <td><input type="text" class="input" name="listsql" value=""  style="width:95%;"> <br/>
            <span class="gray">如：select * from shuipfcms_article where catid = 1 order by id desc</span></td>
          </tr>
          <tr>
            <th width="120">每页显示多少条</th>
            <td><input type="text" class="input" name="lencord" value="20"> </td>
          </tr>
          <tr>
            <th width="120">URL规则</th>
            <td><span class="gray"><label><input name="isurltype" type="radio" value="1" checked>使用已有规则：</label></span>{$list_html_ruleid}  
            <span class="gray"><label><input name="isurltype" type="radio" value="2">或者</label></span> <input type="text" class="input" name="urlrule" value="" style="width:300px;"> 
            <br/>
            <span class="gray"><literal>
            规则使用说明：
            <br/>1、只能使用一下变量 年->{$year}，月->{$month}，日->{$day}，自定义列表ID->{$id}，分页号->{$page}
            <br/>2、URL规则是定义生成目录路径，所以是从网站根目录开始算起。
            <br/>3、规则是成对，以“|”分开。例如：customlist/{$id}.html|customlist/{$id}_{$page}.html
            </span></literal>
            </td>
          </tr>
          <tr>
            <th width="120">列表模板</th>
            <td><select name="listpath" id="listpath" onChange="onlistpath(this.value)">
                  <option value="" selected>==使用模板代码==</option>
                  <volist name="tp_list" id="vo">
                    <option value="{$vo}">{$vo}</option>
                  </volist>
                </select> <span class="gray">新增模板以show_x<?php echo C("TMPL_TEMPLATE_SUFFIX")?>形式</span> </td>
          </tr>
          <tr id="template">
            <th>模板内容</th>
            <td><textarea name="template" style="width:95%; height:400px" validate="required:true, minlength:4"></textarea></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="btn_wrap">
      <div class="btn_wrap_pd">
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加自定义列表</button>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script>
function onlistpath(value){
	if(value == ''){
		$('#template').show();
	}else{
		$('#template').hide();
	}
}
</script>
</body>
</html>