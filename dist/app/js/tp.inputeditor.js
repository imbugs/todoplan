// input editor 
(function($, tp){
	/**
	 * elem, span.title container
	 * size, input-small as default
	 */
	var InputEditor = function(elem, size) {
		this.element = elem;
		this.size = size || "input-small";
		this.trigger = function(text) {
			console.log(text);
		};
		this.showInput = function() {
			this.remove();
			var title = this.element.find('span.title').text();
			var editorWrapper = $('#tmpl-input-editor').tmpl({title: title, size: this.size});
			$(editorWrapper).click(function(e) {
				e.stopPropagation();
			    return false;
			});
			this.element.find('span.title').hide();
			this.element.find('span.holder').append(editorWrapper);
			var editor = this.element.find('input.editor');
			editor.focus();
			this.bindEvent(editor);
		}
		this.bindEvent = function(editor) {
			var $this = this;
			$(editor).parent().click(function(e){
				e.stopPropagation();
			    return false;
			});
			$(document).click(function(e){
				$this.commit();
			});
			$(editor).keybind('keydown', {
				'return': function(o) {
					$this.commit();
				},
				'escape': function(o){
					$this.remove();
				}
			});
		},
		this.commit = function() {
			var editor = this.element.find('input.editor');
			if (editor.size() > 0) {
				var text = editor.val();
				if(text != editor.attr('oldvalue')) {
					this.trigger && this.trigger(text);
				}
			}
			this.remove();
		}
		this.remove = function() {
			this.element.find('span.holder').html('');
			this.element.find('span.title').show();
		}
	};
	tp.mix("editor", {
		InputEditor: InputEditor
	});
})($, window.TP);