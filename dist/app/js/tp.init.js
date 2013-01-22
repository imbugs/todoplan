// init page 
$(function() {
	TP.list.init();

	$('input#addItem').keybind('keydown', {
		'return': function(o) {
			var content = $(o.currentTarget).val();
			var listId = $('li.task-list.active').attr('rel');
			TP.item.controller.createItem(content, listId, function(reps){
				TP.fn.msg('添加任务', 'success');
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
	
	// scroll
	TP.item.view.scroll = $('#scrollable-item').niceScroll("#scrollable-item .scroller",{boxzoom:false, autohidemode:false, cursorcolor: 'gray', bouncescroll: false});
	TP.list.view.scroll = $('#scrollable-list').niceScroll("#scrollable-list .scroller",{boxzoom:false, autohidemode:false, cursorcolor: 'gray', bouncescroll: false});
	
	// resize input box 
	var w = $('li#input-width').width();
	$('input#addItem').width(w-14);
	
	// add new list
	$(document).click(function(e){
		TP.list.view.showCreateInput(false, true);
		TP.list.view.showUpdateInput(null, false, true);
	});
	$('li.add-list').click(function(e){
		TP.list.view.showCreateInput(true);
		e.stopPropagation();
	    return false;
	});
	
	// delete list
	$('a.delete').click(function(e){
		var elem = $('li.task-list.active');
		if (elem != null && $(elem).hasClass('deletable')) {
			var listId = $(elem).attr('rel');
			var title = $(elem).find('span.title').text();
			if (confirm("该操作会永久删除列表["+ title +"]中所有任务,是否继续?")) {
				TP.list.controller.deleteItem(listId, function(reps) {
					TP.fn.msg('删除列表', 'info');
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

	// sortable
	$('ul.task-sortable').sortable({
		distance: 20,
		update: function( event, ui ) {
			var order = $(this).sortable('toArray', { attribute: "rel" });
			TP.item.controller.sortItem(order);
	}}).disableSelection();
    $('ul.list-sortable').sortable({
    	distance: 20,
    	items: "li.deletable",
        update: function( event, ui ) {
			var order = $(this).sortable('toArray', { attribute: "rel" });
			TP.list.controller.sortItem(order);
	}}).disableSelection();
    
	// settings
	$('a.settings').click(function(e) {
		TP.app.openSetting();
	});

	// search 
	$('a#search').click(function(e) {
		if ($('div.search-container').css('display') == 'none') {
			$('div#logo').hide();
			$('div.search-container').css('display', 'inline');
		} else {
			$('div#logo').show();
			$('div.search-container').css('display', 'none');
			TP.app.searchReset();
		}
	});

	$('input.search-item').keyup(function(e) {
		if($(this).val() != '') {
			TP.app.search($(this).val());
		} else {
			TP.app.searchReset();
		}
	});
	
	// change passwd
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