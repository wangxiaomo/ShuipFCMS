<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="favicon.ico" rel="shortcut icon" />
<link rel="canonical" href="{$config_siteurl}" />
<title><if condition=" isset($SEO['title']) && !empty($SEO['title']) ">{$SEO['title']}</if>{$SEO['site_title']}</title>
<meta name="description" content="{$SEO['description']}" />
<meta name="keywords" content="{$SEO['keyword']}" />
<link href="{$config_siteurl}statics/default/css/index.css" rel="stylesheet" type="text/css" />
<link href="{$config_siteurl}statics/default/css/layout.css" rel="stylesheet" type="text/css" />
<script src="{$config_siteurl}statics/js/jquery.js" type="text/javascript"></script>
<script src="{$config_siteurl}statics/default/js/w3cer.js" type="text/javascript"></script>
<script src="{$config_siteurl}statics/default/js/jquery.eislideshow.js"></script>
<script src="{$config_siteurl}statics/default/js/jquery.easing.1.3.js"></script>
<script src="{$config_siteurl}statics/default/js/s3Slider.js" type="text/javascript"></script>
<base target="_blank" />
</head>
<body>
<template file="Contents/header.php"/>
<div class="map"><span class="home_ico">当前位置：<a href="{$config_siteurl}">{$Config.sitename}</a></span>
  <p style="float:right;padding-right:15px;"></p>
</div>
<div class="w972 margin8">
    <div class="wrapper">
        <div id="ei-slider" class="ei-slider">
            <ul class="ei-slider-large">
                <li>
                    <img src="http://www.thcmc.com.cn/images/large/6.jpg" alt="image06"/>
                    <div class="ei-title">
                        <h2><!--<a href="#">设计师：任立伟</a>--></h2>
                        <h3><!--万达酒店--></h3>
                    </div>
                </li>
                <li>
                    <img src="http://www.thcmc.com.cn/images/large/1.jpg" alt="image01" />
                    <div class="ei-title">
                        <h2><!--<a href="#">尊贵古典的中式宫廷文化</a>--></h2>
                        <h3><!--酒店配饰--></h3>
                    </div>
                </li>
                <li>
                    <img src="http://www.thcmc.com.cn/images/large/2.jpg" alt="image02" />
                    <div class="ei-title">
                        <h2><!--<a href="#">温州江滨九号会所</a>--></h2>
                        <h3><!--会所配饰--></h3>
                    </div>
                </li>
                <li>
                    <img src="http://www.thcmc.com.cn/images/large/3.jpg" alt="image03"/>
                    <div class="ei-title">
                        <h2><!--Tranquilent--></h2>
                        <h3><!--Compatriot--></h3>
                    </div>
                </li>
                <li>
                    <img src="http://www.thcmc.com.cn/images/large/4.jpg" alt="image04"/>
                    <div class="ei-title">
                        <h2><!--Insecure--></h2>
                        <h3><!--Hussler--></h3>
                    </div>
                </li>
                <li>
                    <img src="http://www.thcmc.com.cn/images/large/5.jpg" alt="image05"/>
                    <div class="ei-title">
                        <h2><!--Loving--></h2>
                        <h3><!--Rebel--></h3>
                    </div>
                </li>
                <li>
                    <img src="http://www.thcmc.com.cn/images/large/7.jpg" alt="image07"/>
                    <div class="ei-title">
                        <h2><!--Photography by--></h2>
                        <h3><!--<a target="_blank" href="">Bartek Lurka</a>--></h3>
                    </div>
                </li>
            </ul><!-- ei-slider-large -->
            <ul class="ei-slider-thumbs">
                <li class="ei-slider-element">Current</li>
    <li><a href="#">Slide 6</a><!--<img src="images/thumbs/6.jpg" alt="thumb06" />--></li>
            <li><a href="#">Slide 1</a><!--<img src="images/thumbs/1.jpg" alt="thumb01" />--></li>
            <li><a href="#">Slide 2</a><!--<img src="images/thumbs/2.jpg" alt="thumb02" />--></li>
            <li><a href="#">Slide 3</a><!--<img src="images/thumbs/3.jpg" alt="thumb03" />--></li>
            <li><a href="#">Slide 4</a><!--<img src="images/thumbs/4.jpg" alt="thumb04" />--></li>
            <li><a href="#">Slide 5</a><!--<img src="images/thumbs/5.jpg" alt="thumb05" />--></li>
            <li><a href="#">Slide 7</a><!--<img src="images/thumbs/7.jpg" alt="thumb07" />--></li>
            </ul><!-- ei-slider-thumbs -->
        </div><!-- ei-slider -->
    </div><!-- wrapper -->
</div>
</div>
<script type="text/javascript">
  jQuery(".focusBox").slide({ titCell:".num li", mainCell:".pic",effect:"fold", autoPlay:true,trigger:"click",startFun:function(i){jQuery(".focusBox .txt li").eq(i).animate({"bottom":0}).siblings().animate({"bottom":-36});}});
</script>
<div class="w972 margin8 top_banner">
  <div class="index_left left">
      <!--
      <div class="top_right right">
        <div class="top_info">
          <h2><span class="more right"><a href="{:getCategory(7,'url')}" target="_blank">更多&gt;&gt;</a></span><span class="h2_txt">站长推荐</span></h2>
          <div id="ztlist1" class="ztlist" style="display:block">
          <position action="position" posid="3">
          <volist name="data" id="vo">
            <dl>
              <dt><a href="{$vo.data.url}" title="{$vo.data.title}"><img src="{$vo.data.thumb}" alt="{$vo.data.title}" /></a></dt>
              <dd class="info_tt"><a href="{$vo.data.url}" title="{$vo.data.title}">{$vo.data.title}</a></dd>
              <dd class="info_txt">{$vo.data.description}</dd>
            </dl>
          </volist>
          </position>
          </div>
        </div>
      </div>
      -->
    </div>
    <!--index_TOP_RIGHT end-->
    <!--网页特效-->
    <div class="index_tab">
      <h2 class="h2">网页特效</h2>
      <ul class="tabs" id="tabs">
        <li><a href="{:getCategory(16,'url')}" tab="tab1" hidefocus="true" title="焦点幻灯片">JS幻灯片</a></li>
        <li><a href="{:getCategory(17,'url')}" tab="tab2" hidefocus="true" title="导航菜单">导航菜单</a></li>
      </ul>
      <div style="clear:both"></div>
      <ul class="tab_conbox">
        <li id="tab1" class="tab_con" style="display:block;">
        <content action="lists" catid="16"  order="id DESC" num="3">
        <volist name="data" id="vo">
          <dl>
            <dt><a href="{$vo.url}"><img src="{$vo.thumb}" alt="{$vo.title}"/></a></dt>
            <dd class="span1"><a href="{$vo.url}"  title="{$vo.title}">{$vo.title|str_cut=###,15}</a></dd>
            <dd class="span2"><a href="{:getCategory(16,'url')}" title="JS幻灯片">JS幻灯片</a>&nbsp;/&nbsp;{$vo.updatetime|date="m-d",###} </dd>
          </dl>
        </volist>
        </content>
          <div style="clear:both"></div>
        </li>
        <li id="tab2" class="tab_con">
         <content action="lists" catid="17"  order="id DESC" num="3">
         <volist name="data" id="vo">
          <dl>
            <dt><a href="{$vo.url}"><img src="{$vo.thumb}" alt="{$vo.title}"/></a></dt>
            <dd class="span1"><a href="{$vo.url}"  title="{$vo.title}">{$vo.title|str_cut=###,15}</a></dd>
            <dd class="span2"><a href="{:getCategory(17,'url')}" title="导航菜单">导航菜单</a>&nbsp;/&nbsp;{$vo.updatetime|date="m-d",###} </dd>
          </dl>
         </volist>
        </content>
          <div style="clear:both"></div>
        </li>
      </ul>
    </div>

    <!--网页素材-->
    <div class="index_tab">
      <h2 class="h2">建站素材</h2>
      <ul class="tabs" id="tabss">
        <li><a href="{:getCategory(18,'url')}" tab="tab1s" hidefocus="true">PNG图标</a></li>
        <li><a href="{:getCategory(19,'url')}" tab="tab2s" hidefocus="true">GIF图标</a></li>
      </ul>
      <div style="clear:both"></div>
      <ul class="tab_conbox">
        <li id="tab1s" class="tab_cons" style="display: block; ">
        <content action="lists" catid="18"  order="id DESC" num="3">
        <volist name="data" id="vo">
          <dl>
            <dt><a href="{$vo.url}"><img src="{$vo.thumb}" alt="{$vo.title}"/></a></dt>
            <dd class="span1"><a href="{$vo.url}"  title="{$vo.title}">{$vo.title|str_cut=###,15}</a></dd>
            <dd class="span2"><a href="{:getCategory(18,'url')}" title="PNG图标">PNG图标</a>&nbsp;/&nbsp;{$vo.updatetime|date="m-d",###} </dd>
          </dl>
        </volist>
        </content>
          <div style="clear:both"></div>
        </li>
        <li id="tab2s" class="tab_con">
         <content action="lists" catid="19"  order="id DESC" num="3">
         <volist name="data" id="vo">
          <dl>
            <dt><a href="{$vo.url}"><img src="{$vo.thumb}" alt="{$vo.title}"/></a></dt>
            <dd class="span1"><a href="{$vo.url}"  title="{$vo.title}">{$vo.title|str_cut=###,15}</a></dd>
            <dd class="span2"><a href="{:getCategory(19,'url')}" title="GIF图标">GIF图标</a>&nbsp;/&nbsp;{$vo.updatetime|date="m-d",###} </dd>
          </dl>
         </volist>
        </content>
          <div style="clear:both"></div>
        </li>
      </ul>
  </div>
  <div class="index_right right top_right">
    <div class="update">
      <h2><span class="h2_txt">最近更新</span></h2>
      <script>
        $(function(){
			$("#update li:even").css("background","#f2f2f2")
		})
        </script>
      <ul id="update">
      <get sql="SELECT * FROM shuipfcms_article  WHERE status=99 ORDER BY inputtime DESC" num="8">
      <volist name="data" id="vo">
        <li>[<a href='{:getCategory($vo['catid'],'url')}'>{:getCategory($vo['catid'],'catname')}</a>] <a href="{$vo.url}" title="{$vo.title}">{$vo.title}</a></li>
      </volist>
      </get>
      </ul>
    </div>
    <div class="hot_news">
      <h2><span class="h2_txt">热门点击</span></h2>
      <ul>
      <content action="hits" modelid="1"  order="weekviews DESC" num="7">
      <volist name="data" id="vo">
        <li><a href="{$vo.url}" title="{$vo.title}">{$vo.title|str_cut=###,15}</a></li>
      </volist>
      </content>
      </ul>
    </div>
  </div>
  <div style="clear:both"></div>
  <!--top part end-->
</div>
<!--top part end-->
<div class="w972s margin8">
  <div class="web_jc">
    <h2><span class="more right"><a href="{:getCategory(1,'url')}" target="_blank">更多>></a></span><span class="h2_txt">网页教程</span></h2>
    <content action="hits" catid="1"  order="weekviews DESC" num="1">
    <volist name="data" id="vo">
    <dl>
      <dt><a href="{$vo.url}" target="_blank" title="{$vo.title}"><img src="<if condition="$vo['thumb']">{$vo.thumb}<else />{$config_siteurl}statics/default/images/defaultpic.gif</if>" alt="{$vo.title}" /></a></dt>
      <dd class="textname"><a href="{$vo.url}" title="{$vo.title}">{$vo.title|str_cut=###,15}</a></dd>
      <dd  class="texttxt" title="{$vo.description}">{$vo.description|str_cut=###,40}</dd>
      <div style="clear:both"></div>
    </volist>
    </content>
    </dl>
    <ul>
    <content action="lists" catid="1"  order="id DESC" num="7">
    <volist name="data" id="vo">
      <li><a href="{$vo.url}" title="{$vo.title}"><span class="right"> {$vo.updatetime|date="m-d",###}</span>{$vo.title|str_cut=###,18}</a></li>
    </volist>
    </content>
    </ul>
  </div>
  <div class="web_jc" style="margin-left:8px;">
    <h2><span class="more right"><a href="{:getCategory(2,'url')}" target="_blank">更多>></a></span><span class="h2_txt">前端开发</span></h2>
    <content action="hits" catid="2"  order="weekviews DESC" num="1">
    <volist name="data" id="vo">
    <dl>
      <dt><a href="{$vo.url}" target="_blank" title="{$vo.title}"><img src="<if condition="$vo['thumb']">{$vo.thumb}<else />{$config_siteurl}statics/default/images/defaultpic.gif</if>" alt="{$vo.title}" /></a></dt>
      <dd class="textname"><a href="{$vo.url}" title="{$vo.title}">{$vo.title|str_cut=###,15}</a></dd>
      <dd  class="texttxt" title="{$vo.description}">{$vo.description|str_cut=###,40}</dd>
      <div style="clear:both"></div>
    </volist>
    </content>
    </dl>
    <ul>
    <content action="lists" catid="2"  order="id DESC" num="7">
    <volist name="data" id="vo">
      <li><a href="{$vo.url}" title="{$vo.title}"><span class="right"> {$vo.updatetime|date="m-d",###}</span>{$vo.title|str_cut=###,18}</a></li>
    </volist>
    </content>
    </ul>
  </div>
  <div class="web_jc" style="margin-left:7px;">
    <h2><span class="more right"><a href="{:getCategory(3,'url')}" target="_blank">更多>></a></span><span class="h2_txt">PS教程</span></h2>
    <content action="hits" catid="3"  order="weekviews DESC" num="1">
    <volist name="data" id="vo">
    <dl>
      <dt><a href="{$vo.url}" target="_blank" title="{$vo.title}"><img src="<if condition="$vo['thumb']">{$vo.thumb}<else />{$config_siteurl}statics/default/images/defaultpic.gif</if>" alt="{$vo.title}" /></a></dt>
      <dd class="textname"><a href="{$vo.url}" title="{$vo.title}">{$vo.title|str_cut=###,15}</a></dd>
      <dd  class="texttxt" title="{$vo.description}">{$vo.description|str_cut=###,40}</dd>
      <div style="clear:both"></div>
    </volist>
    </content>
    </dl>
    <ul>
    <content action="lists" catid="3"  order="id DESC" num="7">
    <volist name="data" id="vo">
      <li><a href="{$vo.url}" title="{$vo.title}"><span class="right"> {$vo.updatetime|date="m-d",###}</span>{$vo.title|str_cut=###,18}</a></li>
    </volist>
    </content>
    </ul>
  </div>
  <div style="clear:both"></div>
</div>
<div class="big_ad1 margin8" style="padding: 0;">
  <img src="http://placekitten.com/970/102" />
</div>
<div class="w972s margin8">
  <div class="web_jc">
    <h2><span class="more right"><a href="{:getCategory(6,'url')}" target="_blank">更多>></a></span><span class="h2_txt">SEO优化</span></h2>
    <content action="hits" catid="6"  order="weekviews DESC" num="1">
    <volist name="data" id="vo">
    <dl>
      <dt><a href="{$vo.url}" target="_blank" title="{$vo.title}"><img src="<if condition="$vo['thumb']">{$vo.thumb}<else />{$config_siteurl}statics/default/images/defaultpic.gif</if>" alt="{$vo.title}" /></a></dt>
      <dd class="textname"><a href="{$vo.url}" title="{$vo.title}">{$vo.title|str_cut=###,15}</a></dd>
      <dd  class="texttxt" title="{$vo.description}">{$vo.description|str_cut=###,40}</dd>
      <div style="clear:both"></div>
    </volist>
    </content>
    </dl>
    <ul>
    <content action="lists" catid="6"  order="id DESC" num="7">
    <volist name="data" id="vo">
      <li><a href="{$vo.url}" title="{$vo.title}"><span class="right"> {$vo.updatetime|date="m-d",###}</span>{$vo.title|str_cut=###,18}</a></li>
    </volist>
    </content>
    </ul>
  </div>
  <div class="web_jc" style="margin-left:8px;">
    <h2><span class="more right"><a href="{:getCategory(7,'url')}" target="_blank">更多>></a></span><span class="h2_txt">站长杂谈</span></h2>
    <content action="hits" catid="7"  order="weekviews DESC" num="1">
    <volist name="data" id="vo">
    <dl>
      <dt><a href="{$vo.url}" target="_blank" title="{$vo.title}"><img src="<if condition="$vo['thumb']">{$vo.thumb}<else />{$config_siteurl}statics/default/images/defaultpic.gif</if>" alt="{$vo.title}" /></a></dt>
      <dd class="textname"><a href="{$vo.url}" title="{$vo.title}">{$vo.title|str_cut=###,15}</a></dd>
      <dd  class="texttxt" title="{$vo.description}">{$vo.description|str_cut=###,40}</dd>
      <div style="clear:both"></div>
    </volist>
    </content>
    </dl>
    <ul>
    <content action="lists" catid="7"  order="id DESC" num="7">
    <volist name="data" id="vo">
      <li><a href="{$vo.url}" title="{$vo.title}"><span class="right"> {$vo.updatetime|date="m-d",###}</span>{$vo.title|str_cut=###,18}</a></li>
    </volist>
    </content>
    </ul>
  </div>
  <div class="web_jc" style="margin-left:7px;">
    <h2><span class="more right"><a href="{:getCategory(9,'url')}" target="_blank">更多>></a></span><span class="h2_txt">常用软件</span></h2>
    <content action="hits" catid="9"  order="weekviews DESC" num="1">
    <volist name="data" id="vo">
    <dl>
      <dt><a href="{$vo.url}" target="_blank" title="{$vo.title}"><img src="<if condition="$vo['thumb']">{$vo.thumb}<else />{$config_siteurl}statics/default/images/defaultpic.gif</if>" alt="{$vo.title}" /></a></dt>
      <dd class="textname"><a href="{$vo.url}" title="{$vo.title}">{$vo.title|str_cut=###,15}</a></dd>
      <dd  class="texttxt" title="{$vo.description}">{$vo.description|str_cut=###,40}</dd>
      <div style="clear:both"></div>
    </volist>
    </content>
    </dl>
    <ul>
    <content action="lists" catid="9"  order="id DESC" num="7">
    <volist name="data" id="vo">
      <li><a href="{$vo.url}" title="{$vo.title}"><span class="right"> {$vo.updatetime|date="m-d",###}</span>{$vo.title|str_cut=###,18}</a></li>
    </volist>
    </content>
    </ul>
  </div>
  <div style="clear:both"></div>
</div>
<template file="Contents/footer.php"/>
<script type="text/javascript">
$(function (){
  $(window).toTop({showHeight : 100,});
  $('#ei-slider').eislideshow({
      animation     : 'center',
      autoplay      : true,
      slideshow_interval  : 3000,
      titlesFactor    : 0
  });
});
</script>
</body>
</html>
