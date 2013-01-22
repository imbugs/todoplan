// nice scroll + jquery sortable patch 
(function($, win) {
	win.scrollControll = {
		interval : -1,
		eventX : null,
		doScrollUp : function (scroll) {
			var spd = 38 * 3;
			var top = scroll.getScrollTop();
			scroll.doScrollTop(top - spd, 38);
		}, 
		doScrollDown : function (scroll) {
			var spd = 38 * 3;
			var top = scroll.getScrollTop();
			scroll.doScrollTop(top + spd, 38);
		}
	};
	$super = {};
	if (!$.ui.ddmanager) {
		$.ui.ddmanager = {}; 
	} else {
		$super.drag = $.ui.ddmanager.drag;
	}
	$.extend($.ui.ddmanager, {
		current: null,
		drag : function(draggable, event) {
			if ($super.drag) {
				$super.drag.call(this, draggable, event);
			}
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
		}
	});
})($, window);
