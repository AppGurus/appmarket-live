// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_button', function(editor, url) {
		editor.addButton('shortcode_button', {
			text: '',
			tooltip: 'Button',
			id: 'bt_shortcode',
			icon: 'icon-button',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Button',
					body: [
						{type: 'textbox', name: 'label', label: 'Button Text'},
						{type: 'textbox', name: 'links', label: 'Button Link'},
						{type: 'textbox', name: 'icon', label: 'Font Icon Awesome (fa-star)'},
						{type: 'listbox', 
							name: 'size', 
							label: 'Button Size', 
							'values': [
								{text: 'Small', value: 'small'},
								{text: 'Big', value: 'big'}
							]
						},
						{type: 'listbox', 
							name: 'solid', 
							label: 'Solid Background', 
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'}
							]
						},
						{type: 'listbox', 
							name: 'arrow', 
							label: 'Has arrow?', 
							'values': [
								{text: 'Yes', value: '1'},
								{text: 'No', value: '0'}
							]
						},
						{type: 'textbox', name: 'bgcolor', label: 'Button Color', value:"#", id: 'newcolorpicker_buttonbg'},
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
						editor.insertContent('[ia_button id="button_'+uID+'" size="'+e.data.size+'" solid="'+e.data.solid+'" link="'+e.data.links+'" icon="'+e.data.icon+'" arrow="'+e.data.arrow+'" color="'+e.data.bgcolor+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]'+e.data.label+'[/ia_button]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
