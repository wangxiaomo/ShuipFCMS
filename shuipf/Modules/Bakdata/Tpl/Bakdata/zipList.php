<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <form name="myform" id="myform" action="{:U('delZipFiles')}" method="post" class="J_ajaxForm">
    <div class="h_a">共有{$files}个压缩包文件，共计{$total}</div>
    <div class="table_list">
      <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td width="20"><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></td>
            <td>压缩包名称</td>
            <td>打包时间</td>
            <td>文件大小</td>
            <td>解压</td>
          </tr>
        </thead>
        <tbody>
        <volist name="list" id="zip">
            <tr>
               <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" value="{$zip.file}" name="zipFiles[]"></td>
              <td><a href="{:U('downFile',array('file'=>$zip['file'],'type'=>'zip'))}" target="_blank">{$zip.file}</a></td>
              <td>{$zip.time}</td>
                <td>{$zip.size}</td>
                <td><button class="btn unzip" file="{$zip.file}">解压</button></td>
            </tr>
        </volist>
        </tbody>
      </table>
      <br>
      <br>
    </div>
    <div class="">
      <div class="btn_wrap_pd">             
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">删除所选</button>
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit" data-action="{:U('unzipSqlfile')}">解压缩所选</button>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
</body>
</html>