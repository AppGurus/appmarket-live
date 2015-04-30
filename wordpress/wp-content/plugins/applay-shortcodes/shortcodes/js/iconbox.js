// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_iconbox', function(editor, url) {
		editor.addButton('shortcode_iconbox', {
			text: '',
			tooltip: 'Icon Box',
			id: 'iconbox_shortcode',
			icon: 'icon-iconbox',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Icon Box',
					body: [
						{type: 'textbox', name: 'icon', label: 'Icon ( For example: fa-star.)' , value:""},
						{type: 'textbox', name: 'heading', label: 'Heading' , value:"" },
						{type: 'textbox', name: 'content', label: 'Content text' , value:"" , multiline:true },
						{type: 'listbox', 
							name: 'layout', 
							label: 'Layout', 
							'values': [
								{text: 'Left', value: 'left'},
								{text: 'Right', value: 'right'},
								{text: 'Center', value: 'center'},
							]
						},
						{type: 'textbox', name: 'icon_color', label: 'Icon Color', value:"#", id: ''},
						{type: 'textbox', name: 'icon_background_hover', label: 'Icon Background Hover', value:"#", id: ''},
						{type: 'listbox', 
							name: 'css_animation', 
							label: 'CSS Animation', 
							'values': [
								{text: 'No', value: ''},
								{text: 'Top to bottom', value: 'top-to-bottom'},
								{text: 'Bottom to top', value: 'bottom-to-top'},
								{text: 'Left to right', value: 'left-to-right'},
								{text: 'Right to left', value: 'right-to-left'},
								{text: 'Appear from center', value: 'appear'}
							]
						},
						{type: 'textbox', name: 'animation_delay', label: 'Animation Delay'},
					],
					onsubmit: function(e) {
						var uID =  Math.floor((Math.random()*100)+1);
						// Insert content when the window form is submitted
						editor.insertContent('[ia_iconbox  icon="'+e.data.icon+'" heading="'+e.data.heading+'" layout="'+e.data.layout+'" icon_color="'+e.data.icon_color+'" icon_background_hover="'+e.data.icon_background_hover+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]'+e.data.content+'[/ia_iconbox]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
