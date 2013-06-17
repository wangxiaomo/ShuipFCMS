(function (e, jQuery) {
    var n = e.document,
        u = n.getElementsByTagName("head")[0] || n.getElementsByTagName("body")[0],
        //初始化方法
        init = {
            version: 130603,
            DEBUG: false,
            DOMAIN: "http://lvyou.abc3210.com/",
            EMBED_STYLESHEET: "statics/js/comment/css/embed.css?version=" + this.version,
            GET_JSONP: "index.php?g=Comments&a=json",
            LOAD:0,
            //分页信息
            cursor: {
                'total': 0, //总信息数
                'pagetotal': 0, //总分页数
                'page': 1, //当前分页
                'size': 20 //每页显示数量
            },

            catid: 15,
            id: 3,
            //评论数据
            response: {},
            getComment: function () {
                jQuery.ajax({
                    type: "GET",
                    url: this.DOMAIN + this.GET_JSONP,
                    dataType: "jsonp",
                    jsonp: 'callback',
                    data: {
                        'catid': this.catid,
                        'id': this.id,
                        'page': this.cursor.page,
                        'size':2//每页显示评论数
                    },
                    success: function (data) {
                        if (data.status) {
                            init.response = data.data.response;
                            init.cursor = data.data.cursor;

                            var thread = jQuery('#ds-reset');
                            if(init.LOAD == 0){
                            	jQuery('#ds-waiting').remove();
                            	addModel.commentsInfo(thread);
                            }else{
                            	addModel.comments(thread);
                            }
                            init.LOAD += 1;
                            if (init.DEBUG) {
                            	console.log('LOAD次数', init.LOAD);
                                console.log('评论数据：', init.response);
                                console.log('分页数据：', init.cursor);
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
            //加载分页
            goPage: function () {
                var totalPage = this.cursor.pagetotal; //总页数
                var pageSize = this.cursor.size; //每页显示行数
                var currentPage = this.cursor.page; //当前页数
                var str = '';
                var strHighlight = 'class="ds-current"';
                if(currentPage > totalPage){
                	currentPage = totalPage;
                }
                if(currentPage < 1){
                	currentPage = 1;
                }
                //默认显示当前分页前两个
                var cPage = currentPage - 2;
                if(cPage > 1){
                	//if(cPage > 2){
                		str = '<a data-page="1" href="javascript:void(0);">1</a> ';
                	//}
                	if(cPage > 2){
                		str += '<span class="page-break">...</span>';
                	}
                	for(var i = cPage;i < currentPage; i++){
                		str += '<a data-page="'+i+'" href="javascript:void(0);" >'+i+'</a> ';
                	}
                }else{
                	for(var i = 1;i < currentPage; i++){
                		str += '<a data-page="'+i+'" href="javascript:void(0);">'+i+'</a> ';
                	}
                }
                //当前页
                str += '<a data-page="'+currentPage+'" href="javascript:void(0);" '+strHighlight+'>'+currentPage+'</a> ';
                //显示后两个
                var hPage = currentPage + 2;
                if(totalPage >= hPage){
                	for(var i = currentPage + 1;i <= hPage; i++){
                		str += '<a data-page="'+i+'" href="javascript:void(0);">'+i+'</a> ';
                	}
                	if(totalPage > currentPage+2){
                		if(totalPage -hPage >= 2){
                			str += '<span class="page-break">...</span>';
                		}
                		str += '<a data-page="'+totalPage+'" href="javascript:void(0);">'+totalPage+'</a> ';
                	}
                }else{
                	for(var i = currentPage + 1;i <= totalPage; i++){
                		str += '<a data-page="'+i+'" href="javascript:void(0);">'+i+'</a> ';
                	}

                }
                return str;
            },
            htmls: function () {
                var thread = jQuery('#ds-reset');
                thread.append('<div id="ds-waiting"></div>');
                this.getComment();
            }
        },
        addModel = {
            //加载导航
            commentsInfo: function (thread) {
                //显示评论数，和 最新，最早，最热排序导航
                thread.append('<div class="ds-comments-info">\
							    <div class="ds-sort"><a class="ds-order-desc ds-current">最新</a><a class="ds-order-asc">最早</a><a class="ds-order-hot">最热</a></div>\
							    <span class="ds-comment-count"><a class="ds-comments-tab-duoshuo ds-current" href="javascript:void(0);"><span class="ds-highlight">0</span>条评论</a></span> \
							   </div>');
                //显示评论数
                jQuery('.ds-highlight').html(init.cursor.total);
                //加载评论
                this.comments(thread);
            },
            //加载评论
            comments: function (thread) {
            	var post;
            	//如果非第一次加载，不append插入元素
            	if(init.LOAD){
            		jQuery('.ds-comments').empty();
            	}else{
            		thread.append('<ul class="ds-comments" style="opacity: 1; "></ul>');
            	}
                post = jQuery('.ds-comments');
                jQuery.each(init.response, function(comentId,rs){
                	if(rs.content){
                		post.append('<li class="ds-post">\
	                				  <div class="ds-post-self" data-comentid="'+comentId+'">\
										  <div class="ds-avatar"><a rel="nofollow author" target="_blank" href="#" title="'+rs.author+'"><img src="http://app.qlogo.cn/mbloghead/ec22b0ee6435895f7da8/50" alt="'+rs.author+'"></a></div>\
										  <div class="ds-comment-body">\
										    <div class="ds-comment-header"><a class="ds-user-name ds-highlight" data-qqt-account="" href="#" rel="nofollow" target="_blank" data-user-id="940614">'+rs.author+'</a></div>\
										    <p>'+rs.content+'</p>\
										    <div class="ds-comment-footer ds-comment-actions ds-reply-active"> <span class="ds-time" title="2013年6月16日 07:55:36">17分钟前</span> <a class="ds-post-reply" href="javascript:void(0);"><span class="ds-ui-icon"></span>回复</a> <a class="ds-post-likes" href="javascript:void(0);"><span class="ds-ui-icon"></span>顶</a> <a class="ds-post-report" href="javascript:void(0);"><span class="ds-ui-icon"></span>举报</a> <a class="ds-post-delete" href="javascript:void(0);"><span class="ds-ui-icon"></span>删除</a> </div>\
										  </div>\
									  </div>\
									</li>');
						//加载回复列表
						if(rs.child){
							addModel.commetnReply(rs);
						}
					}
                });
                //加载分页
                this.paginator(thread);
                return true;
            },
            //加载评论
            commetnReply:function(json) {
                var post = jQuery('.ds-comments');
                var strHtml = '';
                //加载回复
                if (json.child) {
                	jQuery.each(json.child,function(comentId,rs){
                		if(rs.display == 'none'){
                			strHtml += '<li class="ds-post">\
										    <div class="ds-post-self">\
										      <div class="ds-comment-body">\
										        <p>已经省略一部分评论...全部加载</p>\
										      </div>\
										    </div>\
										  </li>';
                		}else{
                			strHtml +='\
								  <li class="ds-post" data-comentid="'+comentId+'">\
								    <div class="ds-post-self">\
								      <div class="ds-avatar"><a rel="nofollow author" target="_blank" href="#" title="'+rs.author+'"><img src="http://app.qlogo.cn/mbloghead/ec22b0ee6435895f7da8/50" alt="'+rs.author+'"></a></div>\
								      <div class="ds-comment-body">\
								        <div class="ds-comment-header"><a class="ds-user-name ds-highlight" data-qqt-account="" href="#" rel="nofollow" target="_blank" data-user-id="940614">'+rs.author+'</a></div>\
								        <p>'+rs.content+'</p>\
								        <div class="ds-comment-footer ds-comment-actions ds-reply-active"> <span class="ds-time" title="2013年6月16日 07:55:36">17分钟前</span> <a class="ds-post-reply" href="javascript:void(0);"><span class="ds-ui-icon"></span>回复</a> <a class="ds-post-likes" href="javascript:void(0);"><span class="ds-ui-icon"></span>顶</a> <a class="ds-post-report" href="javascript:void(0);"><span class="ds-ui-icon"></span>举报</a> <a class="ds-post-delete" href="javascript:void(0);"><span class="ds-ui-icon"></span>删除</a> </div>\
								        <div class="ds-replybox ds-inline-replybox" style="display: none;"><a class="ds-avatar" href="http://duoshuo.com/settings/avatar/" target="_blank" title="设置头像"><img src="http://app.qlogo.cn/mbloghead/ec22b0ee6435895f7da8/50" alt="水平凡"></a>\
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
								  </li>';
                		}
                	});
					post.append('<ul class="ds-children" id="commetnReply_'+json.id+'">'+strHtml+'</ul>');
                }
            },
            //分页处理
            paginator: function (thread) {
            	//如果有存在分页才载入
            	if(init.cursor.pagetotal > 1){
            		if(init.LOAD){
            			jQuery('.ds-paginator').empty();
            			jQuery('.ds-paginator').append('<div class="ds-border"></div>' + init.goPage());
            		}else{
            			thread.append('<div class="ds-paginator" style="">\
									      <div class="ds-border"></div>\
									   </div>\
									   <a name="respond"></a>');
            			jQuery('.ds-paginator').append(init.goPage());
            		}
            		//对分页加点击事件
            		jQuery('.ds-paginator a').click(function(){
            			init.cursor.page = jQuery(this).html();
            			jQuery(this).die("click");
            			init.getComment();
            		});
            	}
            	//显示评论框
                this.replybox(thread);
            },
            //评论框
            replybox: function (thread) {
            	if(init.LOAD){
            		return true;
            	}
                thread.append('<div class="ds-replybox" style="zoom:1;">\
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
    init.injectStylesheet(init.DOMAIN + init.EMBED_STYLESHEET);
    //加载html结构
    init.htmls();
})(window, jQuery);