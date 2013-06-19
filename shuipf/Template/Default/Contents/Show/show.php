<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<!doctype html>
<!--[if lt IE 8 ]> <html class="no-js ie6-7"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<title>
<if condition=" isset($SEO['title']) && !empty($SEO['title']) ">{$SEO['title']}</if>
{$SEO['site_title']}</title>
<link rel="stylesheet" href="{$Config.siteurl}statics/blog/css/style.css" type="text/css" media="screen" />
<link rel='stylesheet' id='wp-recentcomments-css'  href='{$Config.siteurl}statics/blog/css/wp-recentcomments.css?ver=2.0.6' type='text/css' media='screen' />
<link rel="alternate" type="application/rss+xml" title="{$SEO['site_title']} - Rss" href="{$Config.siteurl}index.php?m=Rss&rssid={$catid}" />
<meta name="generator" content="ThinkPHP Shuipf" />
<meta name="description" content="{$SEO['description']}" />
<meta name="keywords" content="{$SEO['keyword']}" />
<link rel="canonical" href="{$Config.siteurl}" />
<!--[if IE 7]>
<style type="text/css">
#sidebar {
    padding-top:40px;
}
.cm #commentform p {
	float:none;
	clear:none;
}
</style>
<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "{$config_siteurl}",
    JS_ROOT: "statics/js/"
};
</script>
<script type='text/javascript' src='{$Config.siteurl}statics/js/jquery.js'></script>
<script type='text/javascript' src='{$Config.siteurl}statics/blog/js/ls.js'></script>
<script type="text/javascript" src="{$config_siteurl}statics/js/ajaxForm.js"></script>
<!--html5 SHIV的调用-->
<script type='text/javascript' src='{$Config.siteurl}statics/blog/js/html5.js'></script>
</head>
<body  class="single single-post postid-111 single-format-standard">
<!--header START-->
<template file="Contents/header.php"/>
<!--header END-->
<div id="main" class="grid"> 
  <!--主体内容开始-->
  <div id="content" class="g-u" role="主内容">
    <article data-id="{$id}" id="post-{$id}" class="post-4976 post type-post status-publish format-standard hentry category-jq-plus tag-jq tag-jquery tag-366 block J_SinglePost">
      <header>
        <h1 class="entry-title J_SinglePostTitle">{$title}</h1>
        <p class="info">发布于
          <time><b>{$updatetime}</b></time>
          ，归属于<b>
          <?php
                        $_key=array();
                        $_key=array();
                        foreach($tags as $k){
                            $_key[]='<a href="'.$k['url'].'" target="_blank">'.$k['tag'].'</a>';
                        }
                        echo join(",",$_key);
           ?>
          </b>。
          <comment action="get_comment" catid="$catid" id="$id"> <a href="javascript:;;" onClick="slide('#respond');" title="《{$title}》上的评论">前<b>{$data.total}</b>个座位已被强势霸占！</a> </comment>
          共有<b  id="hits">0</b>人围观&nbsp;&nbsp;&nbsp;&nbsp; </p>
      </header>
      <div class="bd entry-content"> {$content}
        <if condition=" $voteid "> 
          <script language="javascript" src="{$Config.siteurl}index.php?g=Vote&m=Index&a=show&action=js&subjectid={$voteid}&type=2"></script> 
        </if>
        <if condition=" !empty($download) ">
          <ul class="tow-columns clearfix">
            <volist name="download" id="vo">
              <li class="l"><a href="{$vo.fileurl}" target="_blank" class="btn-download" title="下载所需积分{$vo.point}">{$vo.filename}</a></li>
            </volist>
          </ul>
        </if>
        {$pages} </div>
      <div class="bd entry-content">
        <p>上一篇：<a href="{$previous_page.url}" target="_blank">{$previous_page.title}</a>
          <if condition=" $previous_page['updatetime'] "><span style="font-size:12px;color:#A5A5A5;">({$previous_page.updatetime|date="Y-m-d",###})</span></if>
        </p>
        <p>下一篇：<a href="{$next_page.url}" target="_blank">{$next_page.title}</a>
          <if condition=" $next_page['updatetime'] "><span style="white-space:normal;font-size:12px;color:#A5A5A5;">({$next_page.updatetime|date="Y-m-d",###})</span></if>
        </p>
      </div>
      <footer class="grid">
        <div class="author J_Author g-u" data-email="442981383@qq.com">
          <figure> <img alt="水平凡" src="http://0.gravatar.com/avatar/6fe959902c4ed835333ea5355388df60?s=96" class="avatar avatar-70 photo" height="70" width="70">
            <figcaption><b><a href="#" title="由 水平凡 发表">水平凡</a></b></figcaption>
          </figure>
        </div>
        <div class="hi g-u">
          <p>感谢阅读这篇文章，如果你遇到了问题，可以在文章底部留言，你可以通过以下方式联络到 水平凡：
            1、<a href="http://t.qq.com/shuipf" target="_blank">进入我的微博首页跟随我</a> 2、我的email：442981383@qq.com</p>
          <p class="sub-title">辛勤码日志中...求分享...O(∩_∩)O</p>
          <div id="ckepop" class="gird"> 
            <!-- JiaThis Button BEGIN -->
            <div id="ckepop"> <span class="jiathis_txt">分享到：</span> <a class="jiathis_button_qzone"></a> <a class="jiathis_button_tsina"></a> <a class="jiathis_button_tqq"></a> <a class="jiathis_button_renren"></a> <a class="jiathis_button_kaixin001"></a> <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a> </div>
            <!-- JiaThis Button END --> 
          </div>
        </div>
      </footer>
    </article>
    <content action="relation" relation="$relation" catid="$catid"  order="id DESC" num="5" keywords="$keywords" nid="$id">
      <if condition=" $data ">
      <div class="similar block grid">
        <div class="ad g-u"> 广告 </div>
        <ul class="similar-list g-u">
          <volist name="data" id="vo">
            <li>
              <h1><a class="title entry-title" role="title" href="{$vo.url}" title="点此前往{$vo.title}" rel="bookmark">{$vo.title}</a> </h1>
              <div class="image"> <a href="{$vo.url}" title="点此前往{$vo.title}"> <img width="93" height="44" src="<if condition=" empty($vo['thumb']) ">{$Config.siteurl}statics/blog/images/no-has-thumbnail.png
                <else />
                {$vo['thumb']}
                </if>
                " class="attachment-96x44 wp-post-image" alt="kissy-mods" title="kissy-mods"> </a> </div>
              <footer class="info"> {$vo.description|str_cut=###,80} </footer>
            </li>
          </volist>
        </ul>
        <s class="tag tag-similar">同类</s> </div>
      </if>
    </content>
    <div class="cm block">
      <div id="ds-reset"></div>
    </div>
  </div>
  <!--主体内容结束-->
  <template file="Contents/sidebar.php"/> 
</div>
<template file="Contents/footer.php"/> 
<!--[if lte IE 6]>
<script src="http://letskillie6.googlecode.com/svn/trunk/2/zh_CN.js"></script>
<![endif]--> 
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F6a7ac600fcf5ef3f164732dcea2e2ba5' type='text/javascript'%3E%3C/script%3E"));
</script> 
<script language="javascript" type="text/javascript" src="{$Config.siteurl}statics/js/artDialog/artDialog.js?skin=blue"></script> 
<script type="text/javascript" charset="utf-8" src="{$Config.siteurl}statics/js/lazyload.js"></script> 
<!--代码高亮--> 
<script type="text/javascript" charset="utf-8" src="{$Config.siteurl}statics/js/ueditor/third-party/SyntaxHighlighter/shCore.js"></script>
<link rel="stylesheet" type="text/css" href="{$Config.siteurl}statics/js/ueditor/third-party/SyntaxHighlighter/shCoreDefault.css"/>
<script type="text/javascript">
// jquery.autoIMG.js - 2010-04-02 - Tang Bin - http://planeArt.cn/ - MIT Licensed
(function ($) {
    // 检测是否支持css2.1 max-width属性
    var isMaxWidth = 'maxWidth' in document.documentElement.style,
        // 检测是否IE7浏览器
        isIE7 = !-[1, ] && !('prototype' in Image) && isMaxWidth;

    $.fn.autoIMG = function () {
        var maxWidth = this.width();
		if(maxWidth>666){
			maxWidth = 666;
		}
        return this.find('img').each(function (i, img) {
            // 如果支持max-width属性则使用此，否则使用下面方式
            if (isMaxWidth) return img.style.maxWidth = maxWidth + 'px';
            var src = img.src;

            // 隐藏原图
            img.style.display = 'none';
            img.removeAttribute('src');

            // 获取图片头尺寸数据后立即调整图片
            imgReady(src, function (width, height) {
                // 等比例缩小
                if (width > maxWidth) {
                    height = maxWidth / width * height, width = maxWidth;
                    img.style.width = width + 'px';
                    img.style.height = height + 'px';
                };
                // 显示原图
                img.style.display = '';
                img.setAttribute('src', src);
            });

        });
    };

    // IE7缩放图片会失真，采用私有属性通过三次插值解决
    isIE7 && (function (c, d, s) {
        s = d.createElement('style');
        d.getElementsByTagName('head')[0].appendChild(s);
        s.styleSheet && (s.styleSheet.cssText += c) || s.appendChild(d.createTextNode(c))
    })('img { -ms-interpolation-mode:bicubic }', document);

    /**
     * 图片头数据加载就绪事件
     * @see		http://www.planeart.cn/?p=1121
     * @param	{String}	图片路径
     * @param	{Function}	尺寸就绪 (参数1接收width; 参数2接收height)
     * @param	{Function}	加载完毕 (可选. 参数1接收width; 参数2接收height)
     * @param	{Function}	加载错误 (可选)
     */
    var imgReady = (function () {
        var list = [],
            intervalId = null,

            // 用来执行队列
            tick = function () {
                var i = 0;
                for (; i < list.length; i++) {
                    list[i].end ? list.splice(i--, 1) : list[i]();
                };
                !list.length && stop();
            },

            // 停止所有定时器队列
            stop = function () {
                clearInterval(intervalId);
                intervalId = null;
            };

        return function (url, ready, load, error) {
            var check, width, height, newWidth, newHeight, img = new Image();

            img.src = url;

            // 如果图片被缓存，则直接返回缓存数据
            if (img.complete) {
                ready(img.width, img.height);
                load && load(img.width, img.height);
                return;
            };
            // 检测图片大小的改变
            width = img.width;
            height = img.height;
            check = function () {
                newWidth = img.width;
                newHeight = img.height;
                if (newWidth !== width || newHeight !== height ||
                // 如果图片已经在其他地方加载可使用面积检测
                newWidth * newHeight > 1024) {
                    ready(newWidth, newHeight);
                    check.end = true;
                };
            };
            check();
            // 加载错误后的事件
            img.onerror = function () {
                error && error();
                check.end = true;
                img = img.onload = img.onerror = null;
            };
            // 完全加载完毕的事件
            img.onload = function () {
                load && load(img.width, img.height);
                !check.end && check();
                // IE gif动画会循环执行onload，置空onload即可
                img = img.onload = img.onerror = null;
            };
            // 加入队列中定期执行
            if (!check.end) {
                list.push(check);
                // 无论何时只允许出现一个定时器，减少浏览器性能损耗
                if (intervalId === null) intervalId = setInterval(tick, 40);
            };
        };
    })();

})(jQuery);
$(document).ready(function (){
	$("#content article p").autoIMG();
	var val;
	$('.J_CmFormField').bind('blur',function(){
		LS.item($(this).attr('id'),$(this).val());
	}).each(function(){
		val = LS.item($(this).attr('id'));
		if(val != null) $(this).val(val);
	});
	$("img").lazyload({
		placeholder:"{$Config.siteurl}statics/images/image-pending.gif",
		effect:"fadeIn"
	});
	//点击
	$.get("{$Config.siteurl}api.php?m=Hits&catid={$catid}&id={$id}",function(data){
		$("#hits").html(data.views);
	},"json");
	var histories = new Histories();
	histories.appendTo('.J_Histories');
	var data = {
		'id' : '{$id}',
		'title' : "{$title}",
		'url' : '{$url}'
	};
	histories.save(data);
});
//代码高亮
SyntaxHighlighter.highlight();    
//评论
var commentsQuery = {
    'catid': '{$catid}',
    'id': '{$id}',
    'size': 10
};
(function () {
    var ds = document.createElement('script');
    ds.type = 'text/javascript';
    ds.async = true;
    ds.src = GV.DIMAUB+'statics/js/comment/embed.js';
    ds.charset = 'UTF-8';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ds);
})();
//评论结束
</script> 
<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js" charset="utf-8"></script> 
<!-- UJian Button BEGIN --> 
<script type="text/javascript" src="http://v1.ujian.cc/code/ujian.js?type=slide"></script> 
<!-- UJian Button END -->
</body>
</html>