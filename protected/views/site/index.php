<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>
	Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?> </i>
</h1>
<style>
<!--
.task-checkbox {
cursor: pointer;
width: 18px;
height: 18px;
background-color: black;
}

-->
</style>
<script id="tmpl-task-item" type="text/x-jquery-tmpl">
<li class="task-item" rel="${id}">
	<a href="#task/get&id=${id}">
		<span class="add-on task-checkbox">x</span>
		<span>${title}</span>
		<a>*</a>
	</a>
</li>
</script>
<script id="tmpl-list-item" type="text/x-jquery-tmpl">
<li class="task-list" rel="${id}">
	<a href="#list/get&id=${id}">
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
				item.prependTo('div.done-tasks');
			} else {
				item.appendTo('div.todo-tasks');
			}
			this.bindEvent(item);
		},
		getAll : function (listId) {
			var $this = this;
			$('div.todo-tasks').empty();
			$.post("?r=item/all", {done: false, list_id: listId}, function(reps){
				for (idx in reps) {
					$this.addItem(reps[idx], false);
				}
			},"json");
			$('div.done-tasks').empty();
			$.post("?r=item/all", {done: true, list_id: listId}, function(reps){
				for (idx in reps) {
					$this.addItem(reps[idx], true);
				}
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
		select : function(elem) {
			var itemElem = $(elem);
			var id = itemElem.attr('rel');
			TP.item.getAll(id);
		},
		addItem : function (item) {
			var item = $('#tmpl-list-item').tmpl(item);
			item.appendTo('ul.task_lists');
			this.bindEvent(item);
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
			TP.item.createItem(content, 999, function(reps){
				$(o.currentTarget).val("");
			});
		}
	});
});
//-->
</script>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="lists span3">
			<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
			<ul class="task_lists nav nav-pills nav-stacked">
	        </ul>
		</div>
		<div class="tasks span8">
			<div class="add-tasks">
				<input type="text" name="addItem" id="addItem" class="input-xxlarge search-query"
					maxlength="255" placeholder="添加一个任务...">
			</div>
			<div>
				<div class="todo-tasks">
				</div>
			</div>
			<div class="recently-completed">
				<h2 class="heading completed">
					<text rel="label_completed_tasks_heading">最近完成</text>
				</h2>
				<div class="done-tasks">
				</div>
			</div>
		</div>
	</div>
</div>

