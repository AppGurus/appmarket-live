// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_dropcap', function(editor, url) {
		editor.addButton('shortcode_dropcap', {
			text: '',
			tooltip: 'Dropcap',
			icon: 'icon-dropcap',
			id: 'dropcap_shortcode',
			onclick: function() {
				var shortcode = '[dropcap]'+tinymce.activeEditor.selection.getContent()+'[/dropcap]';
				editor.insertContent(shortcode);
			}
		});
	});
})();
