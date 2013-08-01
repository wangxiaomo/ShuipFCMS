<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <form name="myform" id="myform" action="{:U('delSqlFiles')}" method="post" class="J_ajaxForm">
    <div class="h_a">系统数据库备份目录下共有{$files}个SQL备份文件，共计{$total}</div>
    <div class="table_list">
      <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td width="20"><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></td>
            <td>SQL文件名</td>
            <td>备份时间</td>
            <td>类型</td>
            <td>文件大小</td>
            <td>文件备注</td>
            <td>导入</td>
          </tr>
        </thead>
        <tbody>
        <volist name="list" id="sql">
            <tr>
                <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" value="{$sql.name}" name="sqlFiles[]"></td>
                <td align="left"><a href="{:U('downFile',array('file'=>$sql['name'],'type'=>'sql'))}" target="_blank">{$sql.name}</a></td>
                <td>{$sql.time}</td>
                <td>{$sql.type}</td>
                <td>{$sql.size}</td>
                <td class="description" title="{$sql.description}">查看备注信息</td>
                <td><a href="{:U('restoreData',array('sqlPre'=>$sql['pre']))}" class="btn" title="{$sql['pre']}">导入</a></td>
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
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit" data-action="{:U('zipSql')}">压缩SQL为ZIP</button>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
</body>
</html>