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
                            init.binds();
                            if (init.DEBUG) {
                            	console.log('LOAD次数', init.LOAD);
                                console.log('评论数据：', init.response);
                                console.log('分页数据：', init.cursor);
                            }
                        }
                    }
                });
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
            //绑定各种事件
            binds:function(){
                //对回复按钮绑定点击事件
                jQuery('a.ds-post-reply').bind('click',function(){
                    //jQuery('.replybox_'+$(this).data('comentid')).show();
                    var reply = jQuery(this);
                    var replyparent = reply.parent();
                    var replyactive = replyparent.next();
                    jQuery('.ds-post .ds-replybox').hide();
                    jQuery('.ds-post .ds-comment-footer').removeClass('ds-reply-active');
                    //回复 高亮
                    replyparent.addClass('ds-reply-active');
                    //载入评论框
                    if(replyactive.html() == ''){
                        replyactive.html(addModel.replybox());
                    }
                    replyactive.show();
                });
            },
            htmls:function () {
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
	                				  <div class="ds-post-self">\
										  <div class="ds-avatar">\
                                            <a rel="nofollow author" href="javascript:;;" title="'+rs.author+'"><img src="'+tool.getAvatar(rs.user_id,rs.author_email)+'" alt="'+rs.author+'"></a>\
                                          </div>\
										  <div class="ds-comment-body">\
										    <div class="ds-comment-header"><a class="ds-user-name ds-highlight" href="javascript:;;" rel="nofollow" data-userid="'+rs.user_id+'">'+rs.author+'</a></div>\
										    <p>'+rs.content+'</p>\
										    <div class="ds-comment-footer ds-comment-actions"> \
                                                <span class="ds-time" title="'+tool.getYearsMonthDay(rs.date*1000)+'">'+tool.getTimeBefore(rs.date*1000)+'</span> \
                                                <a class="ds-post-reply" href="javascript:void(0);" data-comentid="'+comentId+'"><span class="ds-ui-icon"></span>回复</a> \
                                                <a class="ds-post-likes" href="javascript:void(0);" data-comentid="'+comentId+'"><span class="ds-ui-icon"></span>顶</a> \
                                            </div>\
                                            <div class="ds-replybox ds-inline-replybox replybox_'+comentId+'" style="display:none;"></div>\
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
								  <li class="ds-post">\
								    <div class="ds-post-self">\
								      <div class="ds-avatar"><a rel="nofollow author" href="javascript:;;" title="'+rs.author+'"><img src="'+tool.getAvatar(rs.user_id,rs.author_email)+'" alt="'+rs.author+'"></a></div>\
								      <div class="ds-comment-body">\
								        <div class="ds-comment-header">\
                                            <a class="ds-user-name ds-highlight" data-qqt-account="" href="javascript:;;" rel="nofollow" data-userid="'+rs.user_id+'">'+rs.author+'</a>\
                                        </div>\
								        <p>'+rs.content+'</p>\
								        <div class="ds-comment-footer ds-comment-actions"> \
                                            <span class="ds-time" title="'+tool.getYearsMonthDay(rs.date*1000)+'">'+tool.getTimeBefore(rs.date*1000)+'</span> \
                                            <a class="ds-post-reply" href="javascript:void(0);" data-comentid="'+comentId+'"><span class="ds-ui-icon"></span>回复</a> \
                                            <a class="ds-post-likes" href="javascript:void(0);" data-comentid="'+comentId+'"><span class="ds-ui-icon"></span>顶</a> \
                                        </div>\
								        <div class="ds-replybox ds-inline-replybox replybox_'+comentId+'"></div>\
								      </div>\
								    </div>\
								  </li>';
                            if(rs.child){
                                addModel.commetnReply(rs.child);
                            }
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
                this.newsCommentBox(thread);
            },
            //回复评论框
            replybox:function(){
                return '<a class="ds-avatar" href="http://duoshuo.com/settings/avatar/" target="_blank" title="设置头像"><img src="http://app.qlogo.cn/mbloghead/ec22b0ee6435895f7da8/50" alt="水平凡"></a>\
                                          <form method="post">\
                                            <div class="ds-textarea-wrapper ds-rounded-top">\
                                              <textarea name="message" placeholder="说点什么吧…"></textarea>\
                                            </div>\
                                            <div class="ds-post-toolbar">\
                                              <div class="ds-post-options ds-gradient-bg"></div>\
                                              <button class="ds-post-button" type="submit">发布</button>\
                                              <div class="ds-toolbar-buttons"><a class="ds-toolbar-button ds-add-emote" title="插入表情"></a></div>\
                                            </div>\
                                          </form>';
            },
            //发表评论框
            newsCommentBox: function (thread) {
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
        },
        //工具
        tool={
            //友好时间
            getTimeBefore: function (time) {
                var ret = "";
                var nowd = new Date();
                var now = nowd.getTime();
                var delay = now - time;
                var t = new Date(time);
                var getHours = t.getHours();
                var getMinutes = t.getMinutes();
                if (delay > (10 * 24 * 60 * 60 * 1000)) {
                    nowd.setTime(time);
                    ret = nowd.toLocaleString();
                } else if (delay >= (24 * 60 * 60 * 1000)) {
                    delay = (delay / (24 * 60 * 60 * 1000));
                    var num = Math.floor(delay);
                    if (num == 1) {
                        ret = "昨天"+getHours+":"+getMinutes;
                    } else if (num == 2) {
                        ret = "前天"+getHours+":"+getMinutes;
                    } else {
                        ret = num + "天前";
                    }
                } else if (delay >= (60 * 60 * 1000)) {
                    delay = (delay / (60 * 60 * 1000))
                    ret = Math.floor(delay) + "小时前";
                } else if (delay >= (60 * 1000)) {
                    delay = (delay / (60 * 1000))
                    ret = Math.floor(delay) + "分钟前";
                } else if (delay >= (1000)) {
                    delay = (delay / (1000))
                    ret = Math.floor(delay) + "秒前";
                } else {
                    ret = "刚刚";
                }

                return ret;
            },
            //获取 年月日的时间格式
            getYearsMonthDay:function(time){
                var dt= new Date(time);
                var year=dt.getFullYear();//获取年
                var month=dt.getMonth();//获取月
                var day=dt.getDay();//获取日
                var hours = dt.getHours();//时
                var minutes = dt.getMinutes();//分
                var seconds = dt.getSeconds();//秒
                return year + '年' + month + '月' + day +'日' + hours + ':' + minutes + ':' + seconds;
            },
            //获取头像地址
            getAvatar:function(uid , email){
                if(Math.floor(uid) > 0){
                    return init.DOMAIN + 'api.php?m=avatar&uid='+ uid;
                }else{
                    return init.DOMAIN + 'api.php?m=avatar&a=gravatar&email='+ email;
                }
            }
        };
    //加载样式
    init.injectStylesheet(init.DOMAIN + init.EMBED_STYLESHEET);
    //加载html结构
    init.htmls();
})(window, jQuery);