<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<script id="tmpl-task-item" type="text/x-jquery-tmpl">
<li class="task-item" rel="${id}">
	<a href="#task/${id}" class="item-title" data-target="#item_content_${id}">
		<span class="add-on task-checkbox">
			<i class="icon ${icon}"></i>
		</span>
		<span class="title">${title}</span>
		<span class="holder"></span>
		<span class="task-edit-title opacity75">
			<i class="icon-collapse icon-chevron-down"></i>
			<i class="icon-edit"></i>
			<i class="icon-remove"></i>
		</span>
	</a>
	<div id="item_content_${id}" class="collapse ">
		<div class="item-detail note">
			<textarea class='expanding' placeholder="输入任务描述...">${content}</textarea>
		</div>
	</div>
</li>
</script>
<script id="tmpl-list-item" type="text/x-jquery-tmpl">
<li class="task-list ${delableClass}" rel="${id}">
	<a href="#list/${id}" class="noeditor">
		<i class="${icon}"></i>
		<span class="title">${list_title}</span>
	</a>
</li>
</script>
<script id="tmpl-list-update" type="text/x-jquery-tmpl">
<a href="#list/${id}/edit" class="editor" style="height: 31px; line-height: 31px; padding-top: 0px; padding-bottom: 0px">
	<i class="icon-chevron-right editor"></i>
	<input type="text" name="updateList" id="updateList" maxlength="63" class="input-small update editor"
		placeholder="新名称..." oldvalue="${title}" value="${title}">
</a>
</script>
<script id="tmpl-input-editor" type="text/x-jquery-tmpl">
<span class="input-container">
	<input type="text" name="input-update" id="input-update" maxlength="63" class="${size} update editor"
		placeholder="新名称..." oldvalue="${title}" value="${title}">
</span>
</script>
<script type="text/javascript">
<!--
// base 
(function($, window){
	var tp = {
		__init : function () {
			this.config = this.config || {};
			for ( m in this) {
				if (this[m].__init && typeof(this[m].__init) == "function") {
					this[m].__init();
				}
			}
		},
		fn : {
			msg : function (m) {
				alert(m);
			},
			ajaxForm: function(form, handler) {
				$(form).live('submit', function(event) {
				    var $form = $(this);
				    $.ajax({
				        type: $form.attr('method'),
				        url: $form.attr('action'),
				        data: $form.serialize(),
				        dataType: 'json',
				        success: function(data, status) {
				        	if (handler && typeof(handler) == "function") {
				        		handler.call($form, data, status);
							}
				        }
				    });

				    event.preventDefault();
				});
			}
		},
		mix : function (name, object, ov) {
			if (ov || !(name in this)) {
				this[name] = object;
				if (object.__init && typeof(object.__init) == "function") {
					object.__init();
				}
			}
		}
	};
	tp.__init();
	window.TP = tp;
})($, window);

// input editor 
(function($, tp){
	var InputEditor = function(elem, size) {
		this.element = elem;
		this.size = size || "input-small";
		this.trigger = function(text) {
			console.log(text);
		};
		this.showInput = function() {
			this.remove();
			var title = this.element.find('span.title').text();
			var editorWrapper = $('#tmpl-input-editor').tmpl({title: title, size: this.size});
			$(editorWrapper).click(function(e) {
				e.stopPropagation();
			    return false;
			});
			this.element.find('span.title').hide();
			this.element.find('span.holder').append(editorWrapper);
			var editor = this.element.find('input.editor');
			editor.focus();
			this.bindEvent(editor);
		}
		this.bindEvent = function(editor) {
			var $this = this;
			$(editor).parent().click(function(e){
				e.stopPropagation();
			    return false;
			});
			$(document).click(function(e){
				$this.commit();
			});
			$(editor).keybind('keydown', {
				'return': function(o) {
					$this.commit();
				},
				'escape': function(o){
					$this.remove();
				}
			});
		},
		this.commit = function() {
			var editor = this.element.find('input.editor');
			if (editor.size() > 0) {
				var text = editor.val();
				if(text != editor.attr('oldvalue')) {
					this.trigger && this.trigger(text);
				}
			}
			this.remove();
		}
		this.remove = function() {
			this.element.find('span.holder').html('');
			this.element.find('span.title').show();
		}
	};
	tp.mix("editor", {
		InputEditor: InputEditor
	});
})($, window.TP);

// item 
(function($, tp){
	var item = {
		__init : function (item, done) {
		}
	};
	item.view = {
		scroll: null,
		addItem : function (item, done) {
			if (done) {
				item.icon = "task-checked";
			} else {
				item.icon = "task-checkbox";
			}
			var item = $('#tmpl-task-item').tmpl(item);
			if (done) {
				item.prependTo('ul.done-tasks');
			} else {
				item.appendTo('ul.todo-tasks');
			}
			this.bindEvent(item);
			this.onChangeItem();
		},
		onChangeItem: function() {
			var doneSize = $('ul.done-tasks>li.task-item').size();
			if (doneSize > 0) {
				$('h3.completed').show();
			} else {
				$('h3.completed').hide();
			}
			// 最后一步重新计算scroll 
			if (this.scroll != null) {
				this.scroll.refresh();
			}
		},
		bindEvent : function(elem) {
			var $this = this;
			$('span.task-checkbox', elem).click(function(e) {
				var itemElem = $(this).parent().parent();
				var undo = itemElem.parent().hasClass('done-tasks');
				var id = itemElem.attr('rel')
				item.controller.done(id, undo, function(reps){
					// 从todolist删除，加入donelist
					itemElem.remove();
				});
				e.stopPropagation();
			    return false;
			});
			$('i.icon-remove', elem).click(function(e){
				var element = $(this).parent().parent();
				var id = $(element).parent().attr('rel');
				var title = $(element).find('span.title').text();
				if (confirm("确定删除 [" + title + "] ?")) {
					TP.item.controller.deleteItem(id, function(reps){
						$(element).parent().remove();
					});
				}
				e.stopPropagation();
			    return false;
			});
			$('i.icon-edit', elem).click(function(e){
				var element = $(this).parent().parent();
				var inputEditor = new tp.editor.InputEditor($(element), "input-item-editor");
				inputEditor.showInput();
				var id = $(element).parent().attr('rel');
				inputEditor.trigger = function(title) {
					TP.item.controller.updateItem({id: id, title: title}, function(reps) {
						$('span.title', element).text(reps.item.title);
					});
				};
				e.stopPropagation();
			    return false;
			});
			var titleElem = $('a.item-title', elem);
			
			var collaspe = $(elem).find('div.collapse');
			$(collaspe).collapse({toggle: false});
			$(collaspe).on('hidden', function () {
				var icon = $(elem).find('i.icon-collapse');
				$(icon).removeClass('icon-chevron-up');
				$(icon).addClass('icon-chevron-down');
				$(titleElem).removeClass('expand');
				$this.onChangeItem();
			});
			$(collaspe).on('shown', function () {
				var icon = $(elem).find('i.icon-collapse');
				$(icon).removeClass('icon-chevron-down');
				$(icon).addClass('icon-chevron-up');
				$(titleElem).addClass('expand');
				$this.onChangeItem();
			});
			var textarea = $(elem).find('textarea.expanding');
			var expandingTextarea = $(textarea).expandingTextarea();
			$(textarea).blur(function(e){
				var $this = $(this);
				if (expandingTextarea.isChange()) {
					var text = expandingTextarea.getValue();
					var id = $(elem).attr('rel');
					TP.item.controller.updateItem({id: id, content: text}, function(reps) {
						expandingTextarea.setValue(reps.item.content);
					});
				}
			});
			$(titleElem).click(function(e) {
				if($(collaspe).hasClass('in')){
					$(collaspe).collapse('hide');
				} else {
					$(titleElem).addClass('expand'); //fix last item radius 
					$(collaspe).collapse('show');
				}
			});
		}
	};
	item.controller = {
		createItem : function(content, listId, handler) {
			$.post("?r=item/create", {title: content, list_id: listId}, function(reps) {
				if (reps.success) {
					item.view.addItem(reps.item);
					if (handler && typeof(handler) == "function") {
						handler(reps);
					}
				} else {
					TP.fn.msg("添加任务失败");
				}
			},"json");
		},
		getAll : function (listId) {
			$('ul.todo-tasks').empty();
			$.post("?r=item/all", {done: false, list_id: listId}, function(reps){
				for (idx in reps) {
					item.view.addItem(reps[idx], false);
				}
			},"json");
			$('ul.done-tasks').empty();
			$.post("?r=item/all", {done: true, list_id: listId}, function(reps){
				for (idx in reps) {
					item.view.addItem(reps[idx], true);
				}
			},"json");
		},
		done : function(id, undo, handler) {
			$.post("?r=item/done", {id: id, undo: undo}, function(reps){
				if (reps.success) {
					item.view.addItem(reps.item, !undo);
					if (handler && typeof(handler) == "function") {
						handler(reps);
						TP.item.view.onChangeItem();
					}
				} else {
					TP.fn.msg("任务状态更新失败");
				}
			},"json");
		},
		updateItem: function(data, handler) {
			// data: {id: id, title: content}
			for (idx in data) {
				if (!(data[idx] && data[idx] != "")) {
					return;
				}
			}
			$.post("?r=item/update", data , function(reps){
				if (reps.success) {
					if (handler && typeof(handler) == "function") {
						handler(reps);
					}
				} else {
					TP.fn.msg("更新列表失败");
				}
			},"json");
		},
		deleteItem: function(id, handler) {
			$.post("?r=item/delete", {id: id}, function(reps){
				if (reps.success) {
					if (handler && typeof(handler) == "function") {
						handler(reps);
					}
				} else {
					TP.fn.msg("删除列表失败");
				}
			},"json");
		}
	};
	tp.mix("item", item);
})($, window.TP);

//list 
(function($, tp){
	var list = {
		init : function (item, done) {
			list.controller.getAll();
		}
	};

	list.view = {
		scroll: null,
		selectId : -1,
		isSelect: function(item) {
			return item.id == this.selectId || (this.selectId < 0 && item.deletable == 0);
		},
		onChangeItem: function() {
			// 最后一步重新计算scroll 
			if (this.scroll != null) {
				this.scroll.refresh();
			}
		},
		setTitle: function(elem) {
			// set title 
			var title = $(elem).find('span.title').text();
			$('span#label_list_title').text(title);
			if (!$(elem).hasClass('deletable')) {
				$('#sidebar-actions > a.delete').addClass('disabled');
			} else {
				$('#sidebar-actions > a.delete').removeClass('disabled');
			}
		},
		select : function(elem) {
			var itemElem = $(elem);
			var id = itemElem.attr('rel');
			$('li.task-list').removeClass('active');
			itemElem.addClass('active');
			list.controller.loadItems(elem, id);
		},
		showCreateInput: function(show, submit) {
			if (show) {
				$('span#add-list-label').hide();
				$('input#addList').show();
				$('input#addList').focus();
			} else {
				if (submit) {
					var title = $('input#addList').val();
					list.controller.createItem(title);
				}
				$('input#addList').hide();
				$('input#addList').val('');
				$('span#add-list-label').show();
			}
		},
		addItem : function (item, select) {
			if (item.deletable != 0) {
				item.delableClass = "deletable";
				item.icon = "icon-chevron-right";
			} else {
				item.icon = "icon-inbox";
			}
			var itemElem = $('#tmpl-list-item').tmpl(item);
			if (this.isSelect(item)) {
				$('li.task-list').removeClass('active');
				itemElem.addClass('active');
				list.controller.loadItems(itemElem, item.id);
			}
			itemElem.appendTo('ul.task_lists');
			if (select) {
				this.select(itemElem);
			}
			this.bindEvent(itemElem);
			this.onChangeItem();
		},
		bindEvent : function(item) {
			var $this = this;
			$(item).click(function(e) {
				if (!$(this).hasClass('active')) {
					$this.select(this);
				}
			});
			if ($(item).hasClass('deletable')) {
				$('a.noeditor', item).dblclick(function(e) {
					$this.showUpdateInput(this, true);
					e.stopPropagation();
				    return false;
				});
			}
		},
		createUpdateInputElement: function(title) {
			var editor = $('#tmpl-list-update').tmpl({title: title});
			$(editor).click(function(e) {
				e.stopPropagation();
			    return false;
			});
			var $this = this;
			$('input.update', editor).keybind('keydown', {
				'return': function(o) {
					$this.showUpdateInput(null, false, true);
				},
				'escape': function(o){
					$this.showUpdateInput(null, false, false);
				}
			});
			return editor;
		},
		showUpdateInput: function(elem, show, submit) {
			var $this = this;
			var elem = elem || null;
			if (elem == null) {
				elem = $('a.editor').prev('a.noeditor');
			}
			if (elem == null) {
				return;
			}
			if (show) {
				var title = $(elem).find('span.title').text();
				var editor = $this.createUpdateInputElement(title);
				$(elem).hide();
				editor.insertAfter(elem);
				editor.find('input#updateList').focus();
			} else {
				if (submit) {
					var input = $('a.editor').find('input#updateList');
					var title = $(input).val();
					var oldtitle = $(input).attr('oldvalue');
					if (title != oldtitle) {
						var id = $(elem).parent().attr('rel');
						list.controller.updateItem(id, title, function(reps) {
							$(elem).find('span.title').text(reps.item.list_title);
							$this.setTitle($(elem).parent());
						});
					}
				}
				$('a.editor').remove();
				$(elem).show();
			}
		}
	};
	list.controller = {
		loadItems: function(elem, id) {
			list.view.setTitle(elem);
			// get task items 
			TP.item.controller.getAll(id);
			TP.item.view.onChangeItem();
		},
		createItem: function(content, handler) {
			if (content && content != "") {
				$.post("?r=list/create", {list_title: content}, function(reps){
					if (reps.success) {
						list.view.addItem(reps.item, true);
						if (handler && typeof(handler) == "function") {
							handler(reps);
						}
					} else {
						TP.fn.msg("添加列表失败");
					}
				},"json");
			}
		},
		updateItem: function(id, content, handler) {
			if (content && content != "") {
				$.post("?r=list/update", {id: id, list_title: content}, function(reps){
					if (reps.success) {
						if (handler && typeof(handler) == "function") {
							handler(reps);
							list.view.onChangeItem();
						}
					} else {
						TP.fn.msg("更新列表失败");
					}
				},"json");
			}
		},
		deleteItem: function(listId, handler) {
			$.post("?r=list/delete", {id: listId}, function(reps){
				if (reps.success) {
					if (handler && typeof(handler) == "function") {
						handler(reps);
						list.view.onChangeItem();
					}
				} else {
					TP.fn.msg("删除列表失败");
				}
			},"json");
		},
		getAll : function() {
			$('ul.task_lists').empty();
			$.post("?r=list/all", {}, function(reps){
				for (idx in reps) {
					list.view.addItem(reps[idx]);
				}
			},"json");
		}
	};
	tp.mix("list", list);
})($, window.TP);

(function($, tp) {
	tp.mix("app", {
		closeSettings : function() {
			$('div#settings').modal('hide');
			$('div#change-result').html('');
		},
		search : function() {
			
		}
	});
})($, window.TP);
$(function() {
	TP.list.init();
	
	$('input#addItem').keybind('keydown', {
		'return': function(o) {
			var content = $(o.currentTarget).val();
			var listId = $('li.task-list.active').attr('rel');
			TP.item.controller.createItem(content, listId, function(reps){
				$(o.currentTarget).val("");
			});
		}
	});

	$('input#addList').keybind('keydown', {
		'return': function(o) {
			TP.list.view.showCreateInput(false, true);
		},
		'escape': function(o){
			TP.list.view.showCreateInput(false, false);
		}
	});
	
	TP.item.view.scroll = new iScroll('scrollable-item', {hScroll:false, hScrollbar: false, onBeforeScrollStart: false});
	TP.list.view.scroll = new iScroll('scrollable-list', {hScroll:false, hScrollbar: false, onBeforeScrollStart: false});
	
	// resize input box 
	var w = $('li#input-width').width();
	$('input#addItem').width(w-14);
	$(document).click(function(e){
		TP.list.view.showCreateInput(false, true);
		TP.list.view.showUpdateInput(null, false, true);
	});
	$('li.add-list').click(function(e){
		TP.list.view.showCreateInput(true);
		e.stopPropagation();
	    return false;
	});
	$('a.delete').click(function(e){
		var elem = $('li.task-list.active');
		if (elem != null && $(elem).hasClass('deletable')) {
			var listId = $(elem).attr('rel');
			var title = $(elem).find('span.title').text();
			if (confirm("该操作会永久删除列表["+ title +"]中所有任务,是否继续?")) {
				TP.list.controller.deleteItem(listId, function(reps) {
					var select = $(elem).next('li.task-list');
					if (select.size() <= 0) {
						select = $(elem).prev('li.task-list');
					}
					TP.list.view.select(select);
					$(elem).remove();
				});
			}
		}
	});

	TP.fn.ajaxForm($('form[data-async]'), function(data, status) {
		var $form = $(this);
		var target = $form.attr('data-target');
		if (data.success) {
			$form.find('input[type="password"]').each(function() {
				$(this).val('');
			});
			$(target).html('<div class="alert alert-success">' + data.error_msg + '</div>');
		} else {
			$(target).html('<div class="alert alert-error">' + data.error_msg + '</div>');
		}
	});
});
//-->
</script>

<style>
<!--
div#toolbar {
	background-color: #F0F0F0;
	padding-left: 18px;
}
div#toolbar img.avatar{
	margin-top: 3px;
}
div#toolbar a#search {
	float: right;
	margin-top: 12px;
	margin-right: 12px;
}
/** to make the anchor tag larger than the child image*/
div#toolbar a#user {
	display:inline-block;
}

div#toolbar div.dropdown {
	display: inline;
	padding: 0;
	margin: 0;
}
/** logo */
div#toolbar div#logo {
	display: inline;
	font-size: 24px;
	text-align: center;
	padding: 0;
	margin: 0;
}
/** settings */
.form-horizontal .info-label {
	float: left;
	width: 160px;
	text-align: right;
	color: #888;
}
-->
</style>
<div class="container-fluid height100">
	<div class="row-fluid height100">
		<div class="lists span3">
			<div id="toolbar">
				<div class="dropdown">
					<a href="#/me" id="user" class="dropdown-toggle" data-toggle="dropdown" data-target="#">
						<span></span>
						<img class="avatar" src="dist/app/images/users/32.png"/>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a tabindex="-1" href="#settings" data-toggle="modal">设置</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo Config::getUrl('logoutUrl');?>">退出</a></li>
                      </ul>
				</div>
				<div id="logo">
					<a class="button">
						<span class="logo">
							<img src="<?php echo Config::getInstance()->logo ?>">
						</span>
					</a>
					<input search-query=>
				</div>
				<a href="#/search" id="search">
					<i class="icon-search"></i>
				</a>
			</div>
			<div id="scrollable-list" class="scrollable">
					<div class="scroller" style="padding: 5px 0px 10px 0px;">
						<ul class="task_lists nav nav-pills nav-stacked">
				        </ul>
				        <ul class="nav nav-pills nav-stacked">
					        <li class="add-list">
								<a href="#list/new" style="height: 31px; line-height: 31px; padding-top: 0px; padding-bottom: 0px">
									<i class="icon-plus"></i>
									<span id="add-list-label">添加新列表</span>
									<span class="holder">
										<input type="text" name="addList" id="addList"  maxlength="63" class="input-small update" placeholder="添加新列表..." style="display: none;">
									</span>
								</a>
							</li>
				        </ul>
			        </div>
		        </div>
	        <div id="sidebar-actions" class="span3">
	        	<a class="delete">
	        		<span class="icon detail-trash"></span>
	        	</a>
	        	<a class="settings">
	        		<span class="icon settings"></span>
	        	</a>
	        </div>
		</div>
		<div style="width: 1px; background-color: gray; float: left" class="height100"></div>
		<div class="tasks span8 height100">
			<div class="add-tasks area">
				<ul class="task-items nav nav-tabs nav-stacked">
					<li id="input-width">
						<input type="text" name="addItem" id="addItem" maxlength="255" class="input-xxlarge" placeholder="添加一个任务...">
					</li>
				</ul>
			</div>
			<div id="scrollable-item" class="scrollable">
				<div class="scroller">
					<div class="area">
						<h3 class="heading">
							<text rel="label_tasks_heading">
								<i class="icon-list"></i>
								<span id="label_list_title" style="padding-left: 10px;"></span>
							</text>
						</h3>
						<ul class="todo-tasks task-items nav nav-tabs nav-stacked">
						</ul>
					</div>
					<div class="recently-completed area" style="padding: 5px 0px 10px 0px;">
						<h3 class="heading completed" style="display: none;">
							<text rel="label_completed_tasks_heading">
								<i class="icon-list"></i>
								<span style="padding-left: 10px;">最近完成</span>
							</text>
						</h3>
						<ul class="done-tasks task-items nav nav-tabs nav-stacked opacity80">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="settings" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>设置</h3>
		</div>
		<div class="modal-body">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#profiles" data-toggle="tab">个人信息</a></li>
				<li><a href="#changepasswd" data-toggle="tab">修改密码</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="profiles">
					<div class="form-horizontal">
					    <div class="control-group">
					        <div class="info-label">用户名</div>
					        <div class="controls">
					        	<?php echo $userInfo->username;?>
					        </div>
					    </div>
					    <div class="control-group">
					        <div class="info-label">电子邮件</div>
					        <div class="controls">
					        	<?php echo $userInfo->email;?>
					        </div>
					    </div>
					</div>
				</div>
				<div class="tab-pane" id="changepasswd">
					<div id="change-result"></div>
					<form class="form-horizontal" data-async action="?r=user/changepasswd" data-target="#change-result" method="post">
					    <input type="hidden" name="username" value="<?php echo $userInfo->username;?>">
					    <div class="control-group">
					        <label class="control-label" for="currentPasswd">当前密码</label>
					        <div class="controls">
					        	<input type="password" id="currentPasswd" name="currentPasswd" placeholder="当前密码">
					        </div>
					    </div>
					    <div class="control-group">
					        <label class="control-label" for="newPasswd">新密码</label>
					        <div class="controls">
					        	<input type="password" id="newPasswd" name="newPasswd" placeholder="新密码">
					        </div>
					    </div>
					    <div class="control-group">
					        <label class="control-label" for="verifyPasswd">确认密码</label>
					        <div class="controls">
					        	<input type="password" id="verifyPasswd" name="verifyPasswd" placeholder="确认密码">
					        </div>
					    </div>
					    <div class="control-group">
					   		<div class="controls">
						    	<button id="changePassword" type="submit" class="btn btn-primary">保存</button>
						    	<span style="margin-left: 20px;">
									<a href="?r=site/forget" class="default">忘记密码？</a>
								</span>
						    </div>
					    </div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" onclick="javascript:window.TP.app.closeSettings();">关闭</a>
		</div>
	</div>
</div>

