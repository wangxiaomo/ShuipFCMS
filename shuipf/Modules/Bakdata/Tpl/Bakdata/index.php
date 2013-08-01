<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <form name="myform" id="myform" action="{:U('backup')}" method="post" class="J_ajaxForm">
    <div class="h_a">数据库中共有{$tables}张表，共计{$total}</div>
    <div class="table_list">
      <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td width="20"><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></td>
            <td>ID</td>
            <td>表名</td>
            <td>表用途</td>
            <td>记录行数</td>
            <td>引擎类型</td>
            <td>字符集</td>
            <td>表大小</td>
          </tr>
        </thead>
        <tbody>
        <volist name="list" id="tab">
            <tr>
                <td> <input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" value="{$tab.Name}" name="table[]"></td>
                <td>{$i}</td>
                <td>{$tab.Name}</td>
                <td>{$tab.Comment}</td>
                <td>{$tab.Rows}</td>
                <td>{$tab.Engine}</td>
                <td>{$tab.Collation}</td>
                <td>{$tab.size}</td>
            </tr>
        </volist>
        </tbody>
      </table>
      <br>
      <br>
    </div>
    <div class="btn_wrap">
      <div class="btn_wrap_pd">             
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">备份所选数据表</button>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
</body>
</html>