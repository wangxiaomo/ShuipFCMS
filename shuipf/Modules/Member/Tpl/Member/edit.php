<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <form name="myform" action="{:U('Member/edit')}" method="post" class="J_ajaxForm">
    <input type="hidden" name="userid" value="{$data.userid}" />
    <input type="hidden" name="_email" value="{$data.email}" />
    <input type="hidden" name="username" value="{$data.username}" />
    <div class="h_a">基本信息</div>
    <div class="table_full"> 
    <table width="100%" class="table_form">
		<tr>
			<th width="80">用户名</th> 
			<td>{$data.username}</td>
		</tr>
		<tr>
			<th>头像</th> 
			<td><img src="{:getavatar($data['userid'])}" onerror="this.src='{$config_siteurl}statics/images/member/nophoto.gif'" height=90 width=90><input type="checkbox" name="delavatar" id="delavatar" class="input" value="1" ><label for="delavatar">删除头像</label></td>
		</tr>
		<tr>
			<th>是否审核</th> 
			<td><input name="checked" type="radio" value="1" <if condition=" $data['checked'] eq '1' "> checked</if>  />审核通过 <label class="type"><input name="checked" type="radio" value="0"  <if condition=" $data['checked'] eq '0' "> checked</if> />待审核</td>
		</tr>
		<tr>
			<th>密码</th> 
			<td><input type="password" name="password" id="password" class="input"/></td>
		</tr>
		<tr>
			<th>确认密码</th> 
			<td><input type="password" name="pwdconfirm" id="pwdconfirm" class="input"/></td>
		</tr>
		<tr>
			<th>昵称</th> 
			<td><input type="text" name="nickname" id="nickname" value="{$data.nickname}" class="input"/></td>
		</tr>
		<tr>
			<th>邮箱</th>
			<td>
			<input type="text" name="email" value="{$data.email}" class="input" id="email" size="30"/>
			</td>
		</tr>
		<tr>
			<th>会员组</th>
			<td><?php echo Form::select($groupCache, $data['groupid'], 'name="groupid"'); ?> 非vip会员用户组与积分绑定，如只修改会员组请设置该会员为vip</td>
		</tr>
		<tr>
			<th>积分点数</th>
			<td>
			<input type="text" name="point" value="{$data.point}" class="input" id="point" size="10"/> 请输入积分点数，积分点数将影响会员用户组
			</td>
		</tr>
        <tr>
			<th>vip会员</th>
			<td>
			是否为vip会员 <input name="vip" type="checkbox" class="input" value="1" <if condition=" $data['vip'] ">checked</if> /> 过期时间 <input type="text" class="input length_3 J_datetime" name="overduedate" id="overduedate" value="{$data.overduedate|date='Y-m-d H:i',###}" size="21" class="date"/>
			</td>
		</tr>
		<tr>
			<th>会员模型</th>
			<td><?php echo Form::select($groupsModel, $data['modelid'], 'name="modelid" onchange="changemodel($(this).val())"'); ?></td>
		</tr>
	</table>
    <div class="h_a">详细信息</div>
    <table width="100%" class="table_form">
	<?php foreach($forminfos['base'] as $k=>$v) {?>
		<tr>
			<th width="80"><?php echo $v['name']?></th> 
			<td><?php echo $v['form']?></td>
		</tr>
	<?php }?>
	</table>
    </div>
    <div class="">
      <div class="btn_wrap_pd">
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">编辑</button>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
</body>
</html>