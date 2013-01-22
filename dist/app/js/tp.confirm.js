(function($, tp){
	tp.fn.confirm = function(msg, handler) {
		var modal = $('#tmpl-confirm-modal').tmpl({message: msg});
		$('a.btn', modal).on('click', function() {
			$('a.btn', modal).off('click');
			if ($(this).hasClass('confirm')) {
				if (handler && typeof(handler) == 'function') {
					handler();
				}
			}
			$(modal).modal('hide');
		});
		$(modal).on('hidden', function () {
			$(modal).remove();
		});
		$(modal).modal('show');
	};
})(jQuery, TP);
