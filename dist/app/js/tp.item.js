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
				this.scroll.resize();
			}
		},
		bindEvent : function(elem) {
			var $this = this;
			// done  
			$('span.task-checkbox', elem).click(function(e) {
				var itemElem = $(this).parent().parent();
				var undo = itemElem.parent().hasClass('done-tasks');
				var id = itemElem.attr('rel')
				item.controller.done(id, undo, function(reps){
					// 从todolist删除，加入donelist 
					if (undo) {
						TP.fn.msg('取消已完成任务', 'success');
					} else {
						TP.fn.msg('完成任务', 'success');
					}
					itemElem.remove();
				});
				e.stopPropagation();
			    return false;
			});
			// remove 
			$('i.icon-remove', elem).click(function(e){
				var element = $(this).parent().parent();
				var id = $(element).parent().attr('rel');
				var title = $(element).find('span.title').text();
				if (confirm("确定删除 [" + title + "] ?")) {
					TP.item.controller.deleteItem(id, function(reps){
						TP.fn.msg('删除任务', 'info');
						$(element).parent().remove();
					});
				}
				e.stopPropagation();
			    return false;
			});
			// edit , element : <a/> 
			function editTitle(element) {
				var inputEditor = new tp.editor.InputEditor($(element), "input-item-editor");
				inputEditor.showInput();
				var id = $(element).parent().attr('rel');
				inputEditor.trigger = function(title) {
					TP.item.controller.updateItem({id: id, title: title}, function(reps) {
						TP.fn.msg('更新任务', 'success');
						$('span.title', element).text(reps.item.title);
					});
				};
			}

			function showHide(e) {
				if($(collaspe).hasClass('in')){
					$(collaspe).collapse('hide');
				} else {
					$(titleElem).addClass('expand'); //fix last item radius 
					$(collaspe).collapse('show');
				}
			}
			var titleElem = $('a.item-title', elem);
			// icon edit 
			$('i.icon-edit', elem).click(function(e){
				var element = $(this).parent().parent();
				editTitle(element);
				e.stopPropagation();
			    return false;
			});
			// showhide & dblclick edit 
			$(titleElem).click(function(e) {
			    var that = this;
			    setTimeout(function() {
			        var dblclick = parseInt($(that).data('double'), 10);
			        if (dblclick > 0) {
			            $(that).data('double', dblclick-1);
			        } else {
			        	showHide(e);
			        }
			    }, 200);
			}).dblclick(function(e) {
			    $(this).data('double', 2);
			 	// edit title by dblclick 
			    var element = $(this);
			 	if (element.is('li')) {
				 	// use <a/> as the param 
				 	element = element.find('a');
			 	}
				editTitle(element);
				e.stopPropagation();
			    return false;
			});
			// show hide detail 
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
						TP.fn.msg('更新任务内容', 'success');
						expandingTextarea.setValue(reps.item.content);
					});
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
					TP.fn.msg("更新任务失败");
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
		},
		sortItem: function(order) {
			$.post('?r=item/sort', {order: order}, function(reps) { TP.fn.msg("调整任务顺序", 'success'); }, "json");
		}
	};
	tp.mix("item", item);
})($, window.TP);