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
    <div class="block">
      <section class="profile">
        <h1 class="author-page-h1" id=""> 水平凡的档案 </h1>
        <dl>
          <dt>真名</dt>
          <dd>GongJingPing<i>（自己用输入法打...）</i></dd>
          <dt>网名</dt>
          <dd>水平凡<i>（水的平凡，和不可缺少...）</i></dd>
          <dt>邮箱</dt>
          <dd>admin@abc3210.com<i>（非诚勿扰...）</i></dd>
          <dt>蜗居</dt>
          <dd>厦门<i>（美丽的鹭岛城市）</i></dd>
          <dt>职业</dt>
          <dd id="">挨踢程序员<i>（工龄1年，混江湖中，求包养...）</i></dd>
          <dt>就职公司</dt>
          <dd>厦门小鱼网<i>（不是你想象中的那么好，也不是你想象中的那么糟）</i></dd>
          <dt>毕业学院</dt>
          <dd>软件学院<i>（有山、有水、有人家...当然也有妹子-__,-!）</i></dd>
          <dt>爱好</dt>
          <dd>看书 | 数码 | 乒乓球 | 羽毛球 | Girl<i>（其实就是个彻头彻尾的宅男...）</i></dd>
          <dt>自恋宣言</dt>
          <dd>下辈子我一定要投胎做女人，然后嫁个象我这样的男人....<i>（无语ing...）</i></dd>
        </dl>
      </section>
      <h1 class="author-page-h1">水平凡的微博 </h1>
      <div class="wei-bo">
        <iframe frameborder="0" scrolling="no" src="http://v.t.qq.com/show/show.php?n=shuipf&w=0&h=498&fl=2&l=30&o=27&c=0&si=14649fa8cd3e130cc5e28df4dc385966e8a4f55f" width="100%" height="498"></iframe>
      </div>
    </div>
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
$(document).ready(function (){
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
</body>
</html>