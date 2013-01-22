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
			msg : function (m, type) {
				var type = type || 'error';
				$.pnotify({
					title: m,
					type: type
				});
			},
			ajaxForm: function(form, handler) {
				$(form).live('submit', function(event) {
				    var $form = $(this);
				    $.ajax({
				        type: $form.attr('method'),
				        url: $form.attr('action'),
				        data: $form.serialize(),
				        dataType: 'json',
				        success: function(data, status) {
				        	if (handler && typeof(handler) == "function") {
				        		handler.call($form, data, status);
							}
				        }
				    });

				    event.preventDefault();
				});
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