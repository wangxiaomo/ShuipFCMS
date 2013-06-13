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
<script type='text/javascript' src='{$Config.siteurl}statics/js/jquery.js'></script>
<script type='text/javascript' src='{$Config.siteurl}statics/blog/js/ls.js'></script>
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
      <h1>跟作者说两句</h1>
      <div id="respond" class="grid">
        <form action="{:U("Comments/Index/add")}" method="post" id="commentform" class="J_Cm">
          <div class="g-u form-left">
            <p>
              <label for="author">昵称<span>（必须）</span></label>
              <input type="text" style="width:190px;" name="author" class="J_CmFormField" id="author" value="" size="28" tabindex="1" aria-required="true">
            </p>
            <p>
              <label for="email">邮箱<span>（必须，不会公开）</span></label>
              <input type="text" style="width:190px;" name="author_email" id="author_email" class="J_CmFormField" value="" size="28" tabindex="2" aria-required="true">
            </p>
            <p>
              <label for="url">网站<span>（url）</span></label>
              <input type="text" style="width:190px;" name="author_url" id="author_url" class="J_CmFormField" value="" size="28" tabindex="3">
            </p>
            <input name="submit" type="submit" id="comment-form-submit" value="提 交">
            <p class="load" style=" height:32px;line-height:32px; display:none;"><img style="vertical-align:middle;" src="{$Config.siteurl}statics/blog/images/load.gif">正在努力发布中... ...</p>
            <input type="hidden" name="comment_id" value="{$id}" id="comment_id">
            <input type="hidden" name="comment_catid" value="{$catid}" id="comment_catid">
            <input type="hidden" name="parent" id="comment_parent" value="0">
            <p></p>
          </div>
          <div class="g-u form-right">
            <label for="comment"> 评论正文 <a href="javascript:void(0)" id="cancel_reply" style="display:none;" onClick="movecfm(null,0,1,null);">取消回复！</a> </label>
            <div class="cm-smilies"> 表情 </div>
            <textarea name="content" id="ComContent" cols="58" rows="10" tabindex="4"></textarea>
          </div>
        </form>
      </div>
      <h1 class="cm-number">评论列表</h1>
      <ol class="comment-list">
        <li style=" height:32px;line-height:32px;"><img style="vertical-align:middle;" src="{$Config.siteurl}statics/blog/images/load.gif">正在努力的加载数据中... ...</li>
        <!--评论循环开始--> 
        <script type="text/tmpl" id="comment-template">
        <li class="comment even thread-even depth-1 comment-item J_CommentListItem" id="li-comment-<%=id%>">
          <div class="comment-single" id="comment-<%=id%>">
            <div class="member member-author comment-author vcard"> 
			   <img alt="<%=author%>" src="<%=avatar%>" class="avatar avatar-50 photo" height="50" width="50"/>
              <div class="figcaption"><b><a href="<%=author_url%>" rel="external nofollow" class="url" target="_blank"><%=author%></a></b></div>
            </div>
            <div class="comment-content comment-body">
              <p><%=content%></p>
              <p class="thdrpy"><a href="javascript:void(0)" onClick="movecfm(event,<%=id%>,<%=id%>,'<%=author%>');">回复</a></p>
              <!--回复开始-->
			  <% ;if (this.arrchild !== undefined) { %>
			  <% ;$.each(arrchild ,function(i,v){ %>
              <div class="pos-rel comment-childs chalt" id="h-comment-<%=v.id%>">
                <div class="pos-rel comment-childs chalt" id="h-comment-<%=v.id%>">
                  <div class="comment-yellow-box pos-rel comment-content-header"> 
				      <span class="comment-author-first-text"><%=v.author%></span> 回复于 <span class="comment-time"><%=v.date%></span> 
				  </div>
                  <div class="comment-content-body grid">
                    <div class="pos-abs avatar-container g-u"> <img alt="<%=v.author%>" src="<%=v.avatar%>" class="avatar avatar-50 photo" height="50" width="50"> </div>
                    <div class="g-u comment-single-content">
                      <p><%=v.content%></p>
					  <p class="thdrpy"><a href="javascript:void(0)" onClick="movecfm(event,<%=id%>,<%=id%>,'<%=v.author%>');">回复</a></p>
                    </div>
                  </div>
                </div>
              </div>
			  <% }); %>
			  <% } %>
              <!--回复结束--> 
            </div>
            <div class="time"><%=date%></div>
			<div class="bianh">#<%=id%></div>
          </div>
        </li>
		</script> 
        <!--评论循环结束-->
      </ol>
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
//评论开始
var comment = new Comment('{$id}','{$catid}',{
	container:".comment-list",
	template:"comment-template",
	domain:"{$Config.siteurl}",
	formid:"#commentform"
});
//更多
if(comment.TotalPages > 1){
	$("#commentgenduo a").click(function(){
		comment.show(comment.page+1);
	});
}
$("#commentform").unbind("submit");
$("#commentform").submit(function(e){
	if($("#author").val()==""){
		art.dialog({
			 id:'error',
             icon: 'error',
             content: "昵称不能为空！",
			 ok:function(){
				 $("#author").focus();
			 }
        });
		return false;
	}
	if($("#author_email").val()==""){
		art.dialog({
			 id:'error',
             icon: 'error',
             content: "邮箱不能为空！",
			 ok:function(){
				 $("#author_email").focus();
			 }
        });
		return false;
	}
	if($("#ComContent").val()==""){
		art.dialog({
			 id:'error',
             icon: 'error',
             content: "还没输入评论内容！",
			 ok:function(){
				 $("#ComContent").focus();
			 }
        });
		return false;
	}
	comment.sub();
	return false;
 });
//代码高亮
SyntaxHighlighter.highlight();

var commentformid = "commentform";
var USERINFO = false;
var atreply = "author";
var rpPel = null;
var Commentarea = null;

function $s() {
    if (arguments.length == 1)
    return get$(arguments[0]);
    var elements = [];
    $c(arguments).each(function (el) {
        elements.push(get$(el));
    });
    return elements;
}

function get$(el) {
    if (typeof el == 'string')
    el = document.getElementById(el);
    return el;
}

function $c(array) {
    var nArray = [];
    for (i = 0; el = array[i]; i++) nArray.push(el);
    return nArray;
}

function commentarea() {
    var fi = $s(commentformid).getElementsByTagName('textarea');
    for (var i = 0; i < fi.length; i++) {
        if (fi[i].name == 'content') {
            return fi[i];
        }
    }
    return null;
}

function movecfm(event, Id, dp, author) {

    var cfm = $s(commentformid);
    if (cfm == null) {
        alert("ERROR:\nCan't find the 'commentformid' div.");
        return false;
    }
    var reRootElement = $s("cancel_reply");
    if (reRootElement == null) {
        alert("Error:\nNo anchor tag called 'cancel_reply'.");
        return false;
    }
    var replyId = $s("comment_parent");
    if (replyId == null) {
        alert("Error:\nNo form field called 'comment_parent'.");
        return false;
    }
    var dpId = $s("comment_parent");
    if (Commentarea == null)
    Commentarea = commentarea();
    if (parseInt(Id)) {
        if (cfm.style.display == "none") {
            alert("New Comment is submiting, please wait a moment");
            return false;
        }
        if (event == null)
        event = window.event;
        rpPel = event.srcElement ? event.srcElement : event.target;
        rpPel = rpPel.parentNode.parentNode;
        var OId = $s("comment-" + Id);
        if (OId == null) {
            //alert("Error:\nNo comment called 'comment-xxx'.");
            //return false;
            OId = rpPel;
        }
        replyId.value = Id;
        if (dpId)
        dpId.value = dp;
        reRootElement.style.display = "block";
        if ($s("cfmguid") == null) {
            var c = document.createElement("div");
            c.id = "cfmguid";
            c.style.display = "none";
            cfm.parentNode.insertBefore(c, cfm);
        }
        cfm.parentNode.removeChild(cfm);
        OId.appendChild(cfm);
        if (Commentarea && Commentarea.display != "none") {
            Commentarea.focus();
            if (atreply == 'author')
            Commentarea.value = '@' + author + ', ';
            else if (atreply == 'authorlink')
            Commentarea.value = '@' + author + ', ';
        }
        cfm.style.display = "block";
    } else {
        replyId.value = "0";
        if (dpId)
        dpId.value = "0";
        reRootElement.style.display = "none";
        var c = $s("cfmguid");
        if (c) {
            cfm.parentNode.removeChild(cfm);
            c.parentNode.insertBefore(cfm, c);
        }
        if (parseInt(dp) && Commentarea && Commentarea.display != "none") {
            Commentarea.focus();
            Commentarea.value = '';
        }
    }
    return true;
}              
</script> 
<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js" charset="utf-8"></script> 
<!-- UJian Button BEGIN --> 
<script type="text/javascript" src="http://v1.ujian.cc/code/ujian.js?type=slide"></script> 
<!-- UJian Button END -->
</body>
</html>