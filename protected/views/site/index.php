<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<style>
<!--
a {
	text-decoration: none;
	color: black;
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

div.scrollable {
	position: absolute;
	z-index: 9;
	top: 90px;
	bottom: 50px;
	width:100%;
	overflow:auto;
}

input#addItem {
	border: 1px solid gray; 
}
-->
</style>
<script id="tmpl-task-item" type="text/x-jquery-tmpl">
<li class="task-item" rel="${id}">
	<a href="#task/${id}">
		<span class="add-on task-checkbox">
			<i class="icon-ok"></i>
		</span>
		<span class="title">${title}</span>
	</a>
</li>
</script>
<script id="tmpl-list-item" type="text/x-jquery-tmpl">
<li class="task-list" rel="${id}">
	<a href="#list/${id}">
		<i class="icon-chevron-right"></i>
		<span>${list_title}</span>
	</a>
</li>
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
			$.post("?r=item/create", {title: content, list_id: listId}, function(reps) {
				if (reps.success) {
					TP.item.addItem(reps.item);
					if (handler && typeof(handler) == "function") {
						handler(reps);
					}
				} else {
					TP.fn.msg("添加任务失败");
				}
			},"json");
		},
		addItem : function (item, done) {
			var item = $('#tmpl-task-item').tmpl(item);
			if (done) {
				item.prependTo('ul.done-tasks');
			} else {
				item.appendTo('ul.todo-tasks');
			}
			this.loadComplete();
			this.bindEvent(item);
		},
		loadComplete: function() {
			if (this.scroll != null) {
				this.scroll.refresh();
			}
		},
		getAll : function (listId) {
			var $this = this;
			var loadDone = false;
			$('ul.todo-tasks').empty();
			$.post("?r=item/all", {done: false, list_id: listId}, function(reps){
				for (idx in reps) {
					$this.addItem(reps[idx], false);
				}
				if (loadDone) {
					$this.loadComplete();
				}
				loadDone = true;
			},"json");
			$('ul.done-tasks').empty();
			$.post("?r=item/all", {done: true, list_id: listId}, function(reps){
				for (idx in reps) {
					$this.addItem(reps[idx], true);
				}
				if (loadDone) {
					$this.loadComplete();
				}
				loadDone = true;
			},"json");
		},
		bindEvent : function(item) {
			var $this = this;
			$('span.task-checkbox', item).click(function() {
				$this.done(this);
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
		inboxId : -1,
		select : function(elem) {
			var itemElem = $(elem);
			var id = itemElem.attr('rel');
			$('li.task-list').removeClass('active');
			itemElem.addClass('active');
			TP.item.getAll(id);
		},
		isSelect: function(item) {
			return item.id == this.inboxId || (this.inboxId < 0 && item.deletable == 0);
		},
		addItem : function (item) {
			var itemElem = $('#tmpl-list-item').tmpl(item);
			if (this.isSelect(item)) {
				$('li.task-list').removeClass('active');
				itemElem.addClass('active');
				TP.item.getAll(item.id);
			}
			itemElem.appendTo('ul.task_lists');
			this.bindEvent(itemElem);
		},
		bindEvent : function(item) {
			var $this = this;
			$(item).click(function() {
				$this.select(this);
			});
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
		__init : function (item, done) {
			this.getAll();
		}
	});
})($, window.TP);

$(function() {
	$('input#addItem').keybind('keydown', {
		'return': function(o) {
			var content = $(o.currentTarget).val();
			var listId = $('li.task-list.active').attr('rel');
			TP.item.createItem(content, listId, function(reps){
				$(o.currentTarget).val("");
			});
		}
	});
	TP.item.scroll = new iScroll('scrollable', {hScroll:false, hScrollbar: false});

	// resize input box 
	var w = $('li#input-width').width();
	$('input#addItem').width(w-14);
});
//-->
</script>

<div class="container-fluid height100">
	<div class="row-fluid height100">
		<div class="lists span3">
			<h1>
				<i><?php echo CHtml::encode(Yii::app()->name); ?></i>
			</h1>
			<ul class="task_lists nav nav-pills nav-stacked">
	        </ul>
	        <ul class="nav nav-pills nav-stacked">
		        <li class="add-list">
					<a href="#list/new">
						<i class="icon-plus"></i>
						<span>添加新列表</span>
					</a>
				</li>
	        </ul>
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
			<div id="scrollable" class="scrollable">
				<div id="scroller">
					<div class="area">
						<ul class="todo-tasks task-items nav nav-tabs nav-stacked">
						</ul>
					</div>
					<div class="recently-completed area" style="padding: 5px 0px 5px 0px;">
						<h3 class="heading completed">
							<text rel="label_completed_tasks_heading">最近完成</text>
						</h3>
						<ul class="done-tasks task-items nav nav-tabs nav-stacked">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

