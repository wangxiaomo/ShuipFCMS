<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<footer id="footer"> <i class="hd"></i>
  <div class="bd">
    <section class="content grid">
      <aside class="authors g-u">
        <header> <span class="en">authors</span><span class="zh">作者们</span> </header>
        <article>
          <ul>
            <li class="grid"> <a href="/" target="_blank">
              <div class="avatar-parent g-u"> <img alt="水平凡" src="<?=get_avatar(1);?>" class="avatar avatar-50 photo" height="50" width="50"> </div>
              <div class="info g-u">
                <h4 class="name"> 水平凡 </h4>
                <p class="desc"> 浪迹在网络上的80后！ </p>
              </div>
              </a> </li>
          </ul>
        </article>
      </aside>
      <article class="articles g-u">
        <header> <span class="en">articles</span><span class="zh">随机推荐文章</span> </header>
        <ul class="grid">
          <get sql="SELECT * FROM think_article  WHERE status=99 ORDER BY Rand()" num="6">
            <volist name="data" id="vo">
              <li class="article g-u"> <a href="{$vo.url}" title="点此前往 {$vo.title} " target="_blank"> <img width="93" height="44" src="<if condition=" empty($vo['thumb']) ">{$Config.siteurl}statics/blog/images/no-has-thumbnail.png
                <else />
                {$vo['thumb']}
                </if>
                " class="attachment-96x44 wp-post-image" alt="点此前往 {$vo.title} " title="点此前往 {$vo.title} "> <span class="title"> {$vo.title} </span> </a> </li>
            </volist>
          </get>
        </ul>
      </article>
      <aside class="histories g-u">
        <header> <span class="en">histories</span><span class="zh">你曾浏览过的文章</span> </header>
        <ul class="J_Histories">
        </ul>
      </aside>
    </section>
  </div>
  <div class="ft">
    <div class="copyright">湘ICP备08001074号-3 | <a href="http://www.abc3210.com/" title="ShuipFCMS驱动" target="_blank">ShuipFCMS驱动</a> | <a href="http://list.qq.com/cgi-bin/qf_invite?id=e512d0ea31b1586853c3069a9398031843a6a15400e986f8" target="_blank">邮件订阅</a> | <a target="_blank" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=XGhobmVkbW9kbxwtLXI-MzE" style="text-decoration:none;">给我写信</a> </div>
  </div>
</footer>