<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <form name="myform" id="myform" action="{:U('optimize')}" method="post" class="J_ajaxForm">
    <div class="h_a">数据库中共有{$list|count}张表，共计{$totalsize.table|byteFormat}</div>
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
            <td>碎片</td>
            <td>表大小</td>
            <td>数据</td>
            <td>索引</td>
          </tr>
        </thead>
        <tbody>
        <volist name="list" id="tab">
            <tr>
                <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" value="{$tab.Name}" name="table[]"></td>
                <td>{$i}</td>
                <td align="left">{$tab.Name}</td>
                <td>{$tab.Comment}</td>
                <td>{$tab.Rows}</td>
                <td>{$tab.Engine}</td>
                <td>{$tab.Collation}</td>
                <td>{$tab.Data_free}</td>
                <td>{$tab.size}</td>
                <td>{$tab.Data_length}</td>
                <td>{$tab.Index_length}</td>
            </tr>
        </volist>
        </tbody>
      </table>
      <br>
      <br>
    </div>
    <div class="btn_wrap">
      <div class="btn_wrap_pd">             
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">优化所选</button>
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit" data-action="{:U('repair')}">修复所选</button>
        <span class="pages" style="float:right;">{$Page}</span>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
</body>
</html>