#交流
* QQ群：49219815
* 网址：[http://www.abc3210.com](http://www.abc3210.com)

----
#ShuipFCMS简介 
* ShuipFCMS 基于[ThinlPHP](http://www.thinlphp.cn)框架开发，采用独立分组的方式开发的内容管理系统。；
* 支持模块安装/卸载，模型自定义，整合UCenter通行证等。

##主要模块介绍：
* Admin模块：后台管理模块。

* Models模块：模型管理模块。

* Search模块：搜索模块。

* Attachment模块：附件管理模块。

* Collection模块：采集模块。

* Comments模块：评论模块。

* Contents模块：内容模块。

* Cron模块：计划任务模块。

* Domains模块：域名绑定模块。

* Template模块：模板管理模块。

---
##模板标签简单介绍：
```html
标签：<Form/>
作用：生成各种表单元素
用法示例：<Form function="date" parameter="name,$valeu"/>
参数说明：
	@function		表示所使用的方法名称，方法来源于Form.class.php这个类。
	@parameter		所需要传入的参数，支持变量！
	
标签：<template/>
作用：引入其他模板
用法示例：<template file="Member/footer.php"/>
参数说明：
	@file				表示需要应用的模板路径。(这里需要说明的是，只能引入当前主题下的模板文件)
```

---

## 界面预览：
 ![mahua](http://file.abc3210.com/d/file/contents/2013/01/50f8dfd9cf91d.jpg)