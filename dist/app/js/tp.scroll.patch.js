// nice scroll + jquery sortable patch 
(function($, win) {
	win.scrollControll = {
		interval : -1,
		eventX : null,
		iconTask : null,
		doScrollUp : function (scroll) {
			var spd = 38 * 3;
			var top = scroll.getScrollTop();
			scroll.doScrollTop(top - spd, 38);
		}, 
		doScrollDown : function (scroll) {
			var spd = 38 * 3;
			var top = scroll.getScrollTop();
			scroll.doScrollTop(top + spd, 38);
		},
		showIcon : function(event) {
			$('li.ui-sortable-helper').hide();
			if (scrollControll.iconTask == null) {
				scrollControll.iconTask = $('<i class="icon-tasks" style="position: fixed; top:-100px; left: -100px; z-index: 9999;"></i>');
				$('div.container').append(scrollControll.iconTask);
			}
			scrollControll.iconTask.css('top', event.pageY - 15);
			scrollControll.iconTask.css('left', event.pageX + 20);
			if (scrollControll.iconTask != null) {
				if ($('a.drop-box').size() > 0) {
					scrollControll.iconTask.removeClass('icon-tasks');
					scrollControll.iconTask.addClass('icon-download-alt');
				} else {
					scrollControll.iconTask.removeClass('icon-download-alt');
					scrollControll.iconTask.addClass('icon-tasks');
				}
			}
		},
		hideIcon: function() {
			$('li.ui-sortable-helper').show();
			if (scrollControll.iconTask != null) {
				scrollControll.iconTask.remove();
				scrollControll.iconTask = null;
			}
		}
	};
	$super = {};
	if (!$.ui.ddmanager) {
		$.ui.ddmanager = {}; 
	} else {
		$super.drag = $.ui.ddmanager.drag;
		$super.drop = $.ui.ddmanager.drop;
	}
	$.extend($.ui.ddmanager, {
		current: null,
		drag : function(draggable, event) {
			if ($super.drag) {
				$super.drag.call(this, draggable, event);
			}
			// 上下滚动
			var scroll = null;
			if (this.current != null && this.current.element.hasClass('todo-tasks')) {
				scroll = TP.item.view.scroll;
			} else if (this.current != null && this.current.element.hasClass('task_lists')) {
				scroll = TP.list.view.scroll;
			}
			if (scroll != null) {
				if(event.pageY - scroll.getOffset().top < 0) {
					scrollControll.doScrollUp(scroll);
				} else if(scroll.win.height() - (event.pageY - scroll.getOffset().top) < 0) {
					scrollControll.doScrollDown(scroll);
				}
			}
			// 水平拖动变化
			var left = $('div#scrollable-item').offset().left;
			if (event.pageX < left) {
				scrollControll.showIcon(event);
			} else {
				scrollControll.hideIcon();
			}
		},
		drop: function( draggable, event ) {
			if ($super.drop) {
				$super.drop.call(this, draggable, event);
			}
			scrollControll.hideIcon();
		}
	});
})($, window);
