<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <div class="nav">
    <ul class="cc">
      <li><a href="{:U("Field/index",array("formid"=>$formid))}">表单字段管理</a></li>
      <li><a href="{:U("Field/add",array("formid"=>$formid))}">添加字段</a></li>
    </ul>
  </div>
  <div class="h_a">字段配置</div>
  <form name="myform" id="myform" action="{:U("Field/edit")}" method="post" class="J_ajaxForm">
  <div class="table_full">
  <table width="100%">
      <tr>
        <th width="300"><strong>字段类型</strong><br /></th>
        <td>
          <input name="formtype" value="{$data.formtype}" type="hidden" />
          <select name="" id="formtype" onChange="javascript:field_setting(this.value);" disabled>
            <option value='' >请选择字段类型</option>
            <volist name="all_field" id="vo">
            <option value="{$key}" <if condition="$data['formtype'] eq $key"> selected</if>>{$vo}</option>
            </volist>
          </select></td>
      </tr>
      <tr>
        <th width="25%"><font color="red">*</font> <strong>字段名</strong><br />
          只能由英文字母、数字和下划线组成，并且仅能字母开头，不以下划线结尾 </th>
        <td><input type="text" name="field" id="field" size="20" class="input" value="{$data.field}" ></td>
      </tr>
      <tr>
        <th><font color="red">*</font> <strong>字段别名</strong><br />
          例如：文章标题</th>
        <td><input type="text" name="name" id="name" size="30" class="input" value="{$data.name}"></td>
      </tr>
      <tr>
        <th><strong>字段提示</strong><br />
          显示在字段别名下方作为表单输入提示</th>
        <td><textarea name="tips" rows="2" cols="20" id="tips" style="height:40px; width:80%">{$data.tips}</textarea></td>
      </tr>
      <tr>
        <th><strong>相关参数</strong><br />
          设置表单相关属性</th>
        <td>{$form_data}</td>
      </tr>
      <tr>
        <th><strong>字符长度取值范围</strong><br />
          系统将在表单提交时检测数据长度范围是否符合要求，如果不想限制长度请留空</th>
        <td>最小值：
          <input type="text" name="minlength" id="field_minlength" value="{$data.minlength}" size="5" class="input">
          最大值：
          <input type="text" name="maxlength" id="field_maxlength" value="{$data.maxlength}" size="5" class="input"></td>
      </tr>
      <tr>
        <th><strong>数据校验正则</strong><br />
          系统将通过此正则校验表单提交的数据合法性，如果不想校验数据请留空</th>
        <td><input type="text" name="pattern" id="pattern" value="{$data.pattern}" size="40" class="input">
          <select name="pattern_select" onChange="javascript:$('#pattern').val(this.value)">
            <option value="">常用正则</option>
            <option value="/^[0-9.-]+$/">数字</option>
            <option value="/^[0-9-]+$/">整数</option>
            <option value="/^[a-z]+$/i">字母</option>
            <option value="/^[0-9a-z]+$/i">数字+字母</option>
            <option value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
            <option value="/^[0-9]{5,20}$/">QQ</option>
            <option value="/^http:\/\//">超级链接</option>
            <option value="/^(1)[0-9]{10}$/">手机号码</option>
            <option value="/^[0-9-]{6,13}$/">电话号码</option>
          </select></td>
      </tr>
      <tr>
        <th><strong>数据校验未通过的提示信息</strong></th>
        <td><input type="text" name="errortips" value="{$data.errortips}" size="50" class="input"></td>
      </tr>
      <tr>
        <th><strong>前台信息处理函数</strong><br />用法：直接填写函数名称，如果有附带参数可以在函数名后面加###参数1,参数2.完整例子：usfun###a1,a2</th>
        <td><input type="text" name="setting[frontfun]" value="{$setting.frontfun}" size="50" class="input"> 
        <input name="setting[frontfun_type]" type="radio" value="1" <if condition="$setting['frontfun_type'] eq '1'"> checked</if> >入库前 
        <input type="radio" name="setting[frontfun_type]" value="2" <if condition="$setting['frontfun_type'] eq '2'"> checked</if>>入库后 
        <input type="radio" name="setting[frontfun_type]" value="3" <if condition="$setting['frontfun_type'] eq '3'"> checked</if>>入库前后</td>
      </tr>
      <tr>
        <th><strong>值唯一</strong></th>
        <td><input type="radio" name="isunique" value="1" id="field_allow_isunique1" <if condition="$data['isunique'] eq '1'"> checked</if> >
          是
          <input type="radio" name="isunique" value="0" id="field_allow_isunique0" <if condition="$data['isunique'] eq '0'"> checked</if> >
          否</td>
      </tr>
      <tr>
        <th><strong>是否显示</strong></th>
        <td><input type="radio" name="isadd" value="1"  <if condition="$data['isadd'] eq '1'"> checked</if>/>
          是
          <input type="radio" name="isadd" value="0" <if condition="$data['isadd'] eq '0'"> checked</if>/>
          否</td>
      </tr>
      <tr> 
         <th><strong>作为万能字段的附属字段</strong><br>必须与万能字段结合起来使用，否则内容添加的时候不会正常显示，使用时直接在使用“{当前字段名}”例如{keywords}</th>
         <td><input type="radio" name="isomnipotent" value="1" <if condition="$data['isomnipotent'] eq '1'"> checked</if> <?php  if(in_array($data['field'],$forbid_fields)) echo 'disabled'; ?>/> 是 <input type="radio" name="isomnipotent" value="0"  <if condition="$data['isomnipotent'] eq '0'"> checked</if>/> 否</td>
      </tr>
    </table>
    </div>
    <div class="btn_wrap">
      <div class="btn_wrap_pd">             
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
        <input name="modelid" type="hidden" value="{$modelid}">
        <input name="formid" type="hidden" value="{$formid}">
        <input name="fieldid" type="hidden" value="{$fieldid}">
        <input name="oldfield" type="hidden" value="{$data.field}">
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
</body>
</html>