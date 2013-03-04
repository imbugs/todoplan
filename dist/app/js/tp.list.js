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
				this.scroll.resize();
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
					list.controller.createItem(title, function(reps) { TP.fn.msg('添加列表', 'success'); });
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
			// to drop item 
			$('a', itemElem).droppable({
		    	hoverClass: 'drop-box',
		    	tolerance: 'pointer',
		        drop: function( event, ui ) {
			        var listId = $(this).parent().attr('rel');
			        if (!ui.draggable.hasClass('droppable')) {
			        	var taskId = ui.draggable.attr('rel');
				        var data = {id: taskId, list_id: listId};
				        TP.item.controller.updateItem(data, function(reps) {
					        TP.fn.msg('移动任务', 'success');
				        	ui.draggable.remove();
					    });
			        }
		        }
		    });
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
						var data = {id: id, list_title: title};
						list.controller.updateItem(data, function(reps) {
							TP.fn.msg('更新列表', 'success');
							$(elem).find('span.title').text(reps.item.list_title);
							$this.setTitle($(elem).parent());
							list.view.onChangeItem();
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
		updateItem: function(data, handler) {
			// data: {id: id, list_title: content}
			for (idx in data) {
				if (!(data[idx] && data[idx] != "")) {
					return;
				}
			}
			$.post("?r=list/update", data , function(reps){
				if (reps.success) {
					if (handler && typeof(handler) == "function") {
						handler(reps);
					}
				} else {
					TP.fn.msg("更新列表失败");
				}
			},"json");
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
		},
		sortItem: function(order) {
			$.post('?r=list/sort', {order: order}, function(reps) { TP.fn.msg('调整列表顺序', 'success'); }, "json");
		}
	};
	tp.mix("list", list);
})($, window.TP);