(function($, tp) {
	tp.mix("app", {
		openSetting: function() {
			$('div#settings').modal('show');
		},
		closeSettings : function() {
			$('div#settings').modal('hide');
			$('div#change-result').html('');
		},
		search : function(pattern) {
			if (pattern && pattern != null && pattern != "") {
				var regExp = new RegExp(pattern);
				$('li.task-item').each(function(idx) {
					var title = $(this).find('span.title').text();
					if(regExp.test(title)) {
						$(this).show();
					} else {
						$(this).hide();
					}
				});
			}
		},
		searchReset: function() {
			$('li.task-item').each(function(idx) {
				$(this).show();
			});
		},
		updateEmail: function(email, handler) {
			if (email && email != "") {
				$.post("?r=user/changemail", {email: email}, function(reps){
					if (reps.success) {
						if (handler && typeof(handler) == "function") {
							handler(reps);
						}
					} else {
						TP.fn.msg(reps.error_msg);
					}
				},"json");
			}
		}
	});
})($, window.TP);