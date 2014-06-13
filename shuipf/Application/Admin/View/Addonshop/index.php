<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body>
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">说明</div>
  <div class="prompt_text">
    <ul>
      <li>插件管理可以很好的扩展网站运营中所需功能！</li>
      <li><font color="#FF0000">获取更多插件请到官方网站插件扩展中下载安装！安装非官方发表插件需谨慎，有被清空数据库的危险！</font></li>
      <li>官网地址：<font color="#FF0000">http://www.shuipfcms.com</font>，<a href="http://www.shuipfcms.com" target="_blank">立即前往</a>！</li>
    </ul>
  </div>
  <div class="table_list">
    <table width="100%">
      <thead>
        <tr>
          <td width="100">名称</td>
          <td width="100">标识</td>
          <td align="center">描述</td>
          <td align="center" width="100">作者</td>
          <td align="center" width="50">版本</td>
          <td align="center" width="227">操作</td>
        </tr>
      </thead>
      <volist name="data" id="vo">
      <tr>
        <td><if condition=" $vo['url'] "><a  href="{$vo.url}" target="_blank">{$vo.title}</a><else/>{$vo.title}</if></td>
        <td>{$vo.name}</td>
        <td>{$vo.description}</td>
        <td align="center">{$vo.author}</td>
        <td align="center">{$vo.version}</td>
        <td align="center">
          <?php
		  $op = array();
		  if(!D('Addons/Addons')->isInstall($vo['name'])){
			  $op[] = '<a href="'.U('install',array('name'=>$vo['name'])).'" class="btn btn_submit mr5 Js_install">安装</a>';
		  }else{
			 //有安装，检测升级
			 if($vo['upgrade']){
				 $op[] = '<a href="'.U('upgrade',array('name'=>$vo['name'])).'" class="btn btn_submit mr5 Js_upgrade" id="upgrade_tips_'.$vo['name'].'">升级到最新'.$vo['newVersion'].'</a>';
			 }
		  }
		  echo implode('  ',$op);
		  ?>
         </td>
      </tr>
      </volist>
    </table>
  </div>
  <div class="p10">
        <div class="pages">{$Page}</div>
   </div>
</div>
<script src="{$config_siteurl}statics/js/common.js"></script>
</body>
</html>