(function(e,jQuery){
	var n = e.document,
		u = n.getElementsByTagName("head")[0] || n.getElementsByTagName("body")[0],
		//初始化方法
		init = {
			version: 130603,
			DEBUG:true,
			DOMAIN: "http://lvyou.abc3210.com/",
            EMBED_STYLESHEET: "statics/js/comment/css/embed.css?version="+this.version,
            GET_JSONP: "index.php?g=Comments&a=json",
            //分页信息
            cursor:{
            	'total':0,
            	'page':1,
            	'size':20
            },

            catid:15,
            id:3,
            //评论数据
            response:{},
            getComment:function(){
            	jQuery.ajax({
            		type: "GET",
            		url: this.DOMAIN+this.GET_JSONP,
            		dataType: "jsonp",
            		jsonp:'callback',
            		data:{'catid':this.catid,'id':this.id,'page':this.cursor.page},
            		success:function(data){
            			if(data.status){
            				init.response = data.data.response;
            				init.cursor = data.data.cursor;

            				var thread = jQuery('#ds-reset');
            				jQuery('#ds-waiting').remove();
            				addModel.commentsInfo(thread);
            				if(init.DEBUG){
            					console.log('评论数据：',init.response);
            					console.log('分页数据：',init.cursor);
            				}
            			}
            		}
            	});
            },
            //获取cookis
            getCookie: function (e) {
                var r = " " + e + "=",
                    i = n.cookie.split(";"),
                    s = 0,
                    o, u, a;
                for (; s < i.length; s++) {
                    o = " " + i[s], u = o.indexOf(r);
                    if (u >= 0 && u + r.length == (a = o.indexOf("=") + 1)) return decodeURIComponent(o.substring(a, o.length).replace(/\+/g, ""))
                }
                return t
            },
            //加载样式
            injectStylesheet: function (e) {
                var t = n.createElement("link");
                t.type = "text/css", t.rel = "stylesheet", t.href = e, u.appendChild(t)
            },
            htmls:function(){
            	var thread = jQuery('#ds-reset');
            	thread.append('<div id="ds-waiting"></div>');
            	this.getComment();
            }
		},
		addModel = {
			//加载导航
			commentsInfo:function(thread){
				//显示评论数，和 最新，最早，最热排序导航
				thread.append('<div class="ds-comments-info">\
							    <div class="ds-sort"><a class="ds-order-desc ds-current">最新</a><a class="ds-order-asc">最早</a><a class="ds-order-hot">最热</a></div>\
							    <span class="ds-comment-count"><a class="ds-comments-tab-duoshuo ds-current" href="javascript:void(0);"><span class="ds-highlight">24</span>条评论</a></span> \
							   </div>');
				//加载评论
				this.comments(thread);
			},
			//加载评论
			comments:function(thread){
				thread.append('<ul class="ds-comments" style="opacity: 1; ">\
								  <li class="ds-post"></li>\
							   </ul>');
				var post = jQuery('.ds-post');
				post.append('<div class="ds-post-self">\
							  <div class="ds-avatar"><a rel="nofollow author" target="_blank" href="#" title="水平凡"><img src="http://app.qlogo.cn/mbloghead/ec22b0ee6435895f7da8/50" alt="水平凡"></a></div>\
							  <div class="ds-comment-body">\
							    <div class="ds-comment-header"><a class="ds-user-name ds-highlight" data-qqt-account="" href="#" rel="nofollow" target="_blank" data-user-id="940614">水平凡</a></div>\
							    <p>我就测是下~~~~</p>\
							    <div class="ds-comment-footer ds-comment-actions ds-reply-active"> <span class="ds-time" title="2013年6月16日 07:55:36">17分钟前</span> <a class="ds-post-reply" href="javascript:void(0);"><span class="ds-ui-icon"></span>回复</a> <a class="ds-post-likes" href="javascript:void(0);"><span class="ds-ui-icon"></span>顶</a> <a class="ds-post-report" href="javascript:void(0);"><span class="ds-ui-icon"></span>举报</a> <a class="ds-post-delete" href="javascript:void(0);"><span class="ds-ui-icon"></span>删除</a> </div>\
							  </div>\
							</div>');
				//加载回复
				post.append('<ul class="ds-children">\
							  <li class="ds-post">\
							    <div class="ds-post-self">\
							      <div class="ds-avatar"><a rel="nofollow author" target="_blank" href="#" title="水平凡"><img src="http://app.qlogo.cn/mbloghead/ec22b0ee6435895f7da8/50" alt="水平凡"></a></div>\
							      <div class="ds-comment-body">\
							        <div class="ds-comment-header"><a class="ds-user-name ds-highlight" data-qqt-account="" href="#" rel="nofollow" target="_blank" data-user-id="940614">水平凡</a></div>\
							        <p>在盖楼下？</p>\
							        <div class="ds-comment-footer ds-comment-actions ds-reply-active"> <span class="ds-time" title="2013年6月16日 07:55:36">17分钟前</span> <a class="ds-post-reply" href="javascript:void(0);"><span class="ds-ui-icon"></span>回复</a> <a class="ds-post-likes" href="javascript:void(0);"><span class="ds-ui-icon"></span>顶</a> <a class="ds-post-report" href="javascript:void(0);"><span class="ds-ui-icon"></span>举报</a> <a class="ds-post-delete" href="javascript:void(0);"><span class="ds-ui-icon"></span>删除</a> </div>\
							        <div class="ds-replybox ds-inline-replybox" style=""><a class="ds-avatar" href="http://duoshuo.com/settings/avatar/" target="_blank" title="设置头像"><img src="http://app.qlogo.cn/mbloghead/ec22b0ee6435895f7da8/50" alt="水平凡"></a>\
							          <form method="post">\
							            <div class="ds-textarea-wrapper ds-rounded-top">\
							              <textarea name="message" placeholder="说点什么吧…"></textarea>\
							            </div>\
							            <div class="ds-post-toolbar">\
							              <div class="ds-post-options ds-gradient-bg"></div>\
							              <button class="ds-post-button" type="submit">发布</button>\
							              <div class="ds-toolbar-buttons"><a class="ds-toolbar-button ds-add-emote" title="插入表情"></a></div>\
							            </div>\
							          </form>\
							        </div>\
							      </div>\
							    </div>\
							    <ul class="ds-children">\
							    </ul>\
							  </li>\
							</ul>');
				//加载分页
				this.paginator(thread);
			},
			//分页处理
			paginator:function(thread){
				thread.append('<div class="ds-paginator" style="">\
							      <div class="ds-border"></div>\
							      <a data-page="1" href="javascript:void(0);">1</a> <span class="page-break">...</span> <a data-page="6" href="javascript:void(0);">6</a> <a data-page="7" href="javascript:void(0);">7</a> <a data-page="8" href="javascript:void(0);" class="ds-current">8</a>\
							  </div>\
							  <a name="respond"></a>');
				this.replybox(thread);
			},
			//评论框
			replybox:function(thread){
				thread.append('<div class="ds-replybox">\
							    <div class="ds-user">\
							      <table style="float:right;" class="user-set">\
							        <tr>\
							          <td>帐号设置</td>\
							          <td>水平凡</td>\
							        </tr>\
							      </table>\
							      <table>\
							        <tr>\
							          <td>用户名：</td>\
							          <td><input name="uname" placeholder="用户名"/></td>\
							          <td>网址：</td>\
							          <td><input name="url" placeholder="http://"/></td>\
							        </tr>\
							      </table>\
							    </div>\
							    <a class="ds-avatar" href="#" target="_blank" title="设置头像"><img src="http://app.qlogo.cn/mbloghead/ec22b0ee6435895f7da8/50" alt="水平凡"></a>\
							    <form method="post">\
							      <div class="ds-textarea-wrapper ds-rounded-top">\
							        <textarea name="message" placeholder="说点什么吧…"></textarea>\
							      </div>\
							      <div class="ds-post-toolbar">\
							        <div class="ds-post-options ds-gradient-bg"></div>\
							        <button class="ds-post-button" type="submit">发布</button>\
							        <div class="ds-toolbar-buttons"><a class="ds-toolbar-button ds-add-emote" title="插入表情"></a></div>\
							      </div>\
							    </form>\
							  </div>');
			}
		};
	//加载样式
    init.injectStylesheet(init.DOMAIN+init.EMBED_STYLESHEET);
    //加载html结构
    init.htmls();
})(window,jQuery);