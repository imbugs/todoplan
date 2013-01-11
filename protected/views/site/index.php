<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<style>
<!--
a, a:hover {
	text-decoration: none;
	color: black;
}
.done-tasks span.title {
	text-decoration: line-through;
}
input.update {
	margin: 0;
	padding: 0px 5px 0px 5px;
}
div.area {
	margin-bottom: 10px;
}
.task-checkbox {
	cursor: pointer;
	width: 18px;
	height: 18px;
}
.task-items {
	padding: 0;
}
div.span3 h1 {
	height: 38px;
	line-height: 38px;
	min-height: 38px;
	text-align: center;
	padding: 0;
	margin: 0;
}
div.span8 {
	padding: 40px 0px 0px 0px;
}
span.title {
	margin-left: 5px;
}
input#addItem {
	border: 1px solid gray; 
}

div#sidebar-actions {
	position: absolute;
	margin-left: -10px;
	padding: 8px 0px 8px 10px;
	bottom: 30px;
	height: 40px;
	min-height: 40px;
	max-height: 40px;
	width: 23.6%;
	*width: 23.6%;
}
div#scrollable-list {
	top: 38px;
	bottom: 70px;
	width: 23.6%;
	*width: 23.6%;
}

div#scrollable-item {
	top: 90px;
	bottom: 50px;
	width:100%;
}

div.right-side-container {
	position: absolute;
	top: 90px;
	right: 0px;
	height: 60%;
	min-height: 60%;
	width: 35%;
}
div.right-side {
	position: absolute;
	z-index: 999;
	height: 100%;
	min-height: 100%;
	width: 100%;
	background-color: white;
	-webkit-border-radius: 20px;
	-moz-border-radius: 20px;
	border-radius: 20px 0px 0px 20px;
	border: solid 1px lightgray;
	border-right: none;
	-webkit-box-shadow: inset 0 5px 5px rgba(0, 0, 0, 0.1);
	-moz-box-shadow: inset 0 5px 5px rgba(0, 0, 0, 0.1);
	box-shadow: inset 0 5px 5px rgba(0, 0, 0, 0.1);
}

-->
</style>
<script id="tmpl-task-item" type="text/x-jquery-tmpl">
<li class="task-item" rel="${id}">
	<a href="#task/${id}">
		<span class="add-on task-checkbox">
			<i class="icon ${icon}"></i>
		</span>
		<span class="title">${title}</span>
	</a>
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

// item 
(function($, tp){
	tp.mix("item", {
		scroll: null,
		createItem : function(content, listId, handler) {
			var $this = this;
			$.post("?r=item/create", {title: content, list_id: listId}, function(reps) {
				if (reps.success) {
					$this.addItem(reps.item);
					if (handler && typeof(handler) == "function") {
						handler(reps);
					}
				} else {
					TP.fn.msg("添加任务失败");
				}
			},"json");
		},
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
		getAll : function (listId) {
			var $this = this;
			$('ul.todo-tasks').empty();
			$.post("?r=item/all", {done: false, list_id: listId}, function(reps){
				for (idx in reps) {
					$this.addItem(reps[idx], false);
				}
			},"json");
			$('ul.done-tasks').empty();
			$.post("?r=item/all", {done: true, list_id: listId}, function(reps){
				for (idx in reps) {
					$this.addItem(reps[idx], true);
				}
			},"json");
			this.onChangeItem();
		},
		bindEvent : function(item) {
			var $this = this;
			$('span.task-checkbox', item).click(function(e) {
				$this.done(this);
				e.stopPropagation();
			    return false;
			});
			$(item).click(function(e) {
				alert($('div.right-side').css('right', '40px'));
				e.stopPropagation();
			    return false;
			});
			
		},
		done : function(elem) {
			var $this = this;
			var itemElem = $(elem).parent().parent();
			var undo = itemElem.parent().hasClass('done-tasks');
			var id = itemElem.attr('rel');
			$.post("?r=item/done", {id: id, undo: undo}, function(reps){
				if (reps.success) {
					// 从todolist删除，加入donelist
					itemElem.remove();
					$this.addItem(reps.item, !undo);
				} else {
					TP.fn.msg("任务状态更新失败");
				}
			},"json");
		},
		__init : function (item, done) {
		}
	});
})($, window.TP);

//list 
(function($, tp){
	tp.mix("list", {
		scroll: null,
		inboxId : -1,
		onChangeItem: function() {
			// 最后一步重新计算scroll 
			if (this.scroll != null) {
				this.scroll.refresh();
			}
		},
		loadItems: function(elem, id) {
			this.setTitle(elem);
			// get task items 
			TP.item.getAll(id);
		},
		select : function(elem) {
			var itemElem = $(elem);
			var id = itemElem.attr('rel');
			$('li.task-list').removeClass('active');
			itemElem.addClass('active');
			this.loadItems(elem, id);
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
		showCreateInput: function(show, submit) {
			if (show) {
				$('span#add-list-label').hide();
				$('input#addList').show();
				$('input#addList').focus();
			} else {
				if (submit) {
					var title = $('input#addList').val();
					this.createItem(title);
				}
				$('input#addList').hide();
				$('input#addList').val('');
				$('span#add-list-label').show();
			}
		},
		isSelect: function(item) {
			return item.id == this.inboxId || (this.inboxId < 0 && item.deletable == 0);
		},
		createItem: function(content, handler) {
			var $this = this;
			if (content && content != "") {
				$.post("?r=list/create", {list_title: content}, function(reps){
					if (reps.success) {
						$this.addItem(reps.item, true);
						if (handler && typeof(handler) == "function") {
							handler(reps);
						}
					} else {
						TP.fn.msg("添加列表失败");
					}
				},"json");
				this.onChangeItem();
			}
		},
		updateItem: function(elem, content, handler) {
			var $this = this;
			var id = $(elem).attr('rel');
			if (content && content != "") {
				$.post("?r=list/update", {id: id, list_title: content}, function(reps){
					if (reps.success) {
						if (handler && typeof(handler) == "function") {
							handler(reps);
							$this.onChangeItem();
						}
					} else {
						TP.fn.msg("更新列表失败");
					}
				},"json");
			}
		},
		deleteItem: function(listId, handler) {
			var $this = this;
			$.post("?r=list/delete", {id: listId}, function(reps){
				if (reps.success) {
					if (handler && typeof(handler) == "function") {
						handler(reps);
						$this.onChangeItem();
					}
				} else {
					TP.fn.msg("删除列表失败");
				}
			},"json");
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
				this.loadItems(itemElem, item.id);
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
						$this.updateItem($(elem).parent(), title, function(reps) {
							$(elem).find('span.title').text(reps.item.list_title);
							$this.setTitle($(elem).parent());
						});
					}
				}
				$('a.editor').remove();
				$(elem).show();
			}
		},
		getAll : function() {
			var $this = this;
			$('ul.task_lists').empty();
			$.post("?r=list/all", {}, function(reps){
				for (idx in reps) {
					$this.addItem(reps[idx]);
				}
			},"json");
		},
		init : function (item, done) {
			this.getAll();
		}
	});
})($, window.TP);

$(function() {
	TP.list.init();
	
	$('input#addItem').keybind('keydown', {
		'return': function(o) {
			var content = $(o.currentTarget).val();
			var listId = $('li.task-list.active').attr('rel');
			TP.item.createItem(content, listId, function(reps){
				$(o.currentTarget).val("");
			});
		}
	});

	$('input#addList').keybind('keydown', {
		'return': function(o) {
			TP.list.showCreateInput(false, true);
		},
		'escape': function(o){
			TP.list.showCreateInput(false, false);
		}
	});
	
	TP.item.scroll = new iScroll('scrollable-item', {hScroll:false, hScrollbar: false});
	TP.list.scroll = new iScroll('scrollable-list', {hScroll:false, hScrollbar: false});
	
	// resize input box 
	var w = $('li#input-width').width();
	$('input#addItem').width(w-14);
	$(document).click(function(e){
		TP.list.showCreateInput(false, true);
		TP.list.showUpdateInput(null, false, true);
	});
	$('li.add-list').click(function(e){
		TP.list.showCreateInput(true);
		e.stopPropagation();
	    return false;
	});
	$('a.delete').click(function(e){
		var elem = $('li.task-list.active');
		if (elem != null && $(elem).hasClass('deletable')) {
			var listId = $(elem).attr('rel');
			var title = $(elem).find('span.title').text();
			if (confirm("该操作会永久删除列表["+ title +"]中所有任务,是否继续?")) {
				TP.list.deleteItem(listId, function(reps) {
					var select = $(elem).next('li.task-list');
					if (select.size() <= 0) {
						select = $(elem).prev('li.task-list');
					}
					TP.list.select(select);
					$(elem).remove();
				});
			}
		}
	});
});
//-->
</script>

<div class="container-fluid height100">
	<div class="row-fluid height100">
		<div class="lists span3">
			<h1>
				<i><?php echo CHtml::encode(Yii::app()->name); ?></i>
			</h1>
			<div id="scrollable-list" class="scrollable">
					<div class="scroller">
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
	        	<a class="settings"><span class="icon settings"></span></a>
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
					<div class="recently-completed area" style="padding: 5px 0px 5px 0px;">
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
	<div class="right-side-container">
		<div id="item-detail-container" class="right-side">
			<span>XXXXXXXXXXXXXXXXXXXXXXXXXXX</span>
		</div>
	</div>
</div>

