// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_countdown', function(editor, url) {
		editor.addButton('shortcode_countdown', {
			text: '',
			tooltip: 'Countdown Clock',
			id: 'countdown_shortcode',
			icon: 'icon-countdown',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Countdown Clock',
					body: [
						{type: 'textbox', name: 'year', label: 'Year' , value:"2015"},
						{type: 'listbox', 
							name: 'month', 
							label: 'Month', 
							'values': [
								{text: '1', value: '1'},
								{text: '2', value: '2'},
								{text: '3', value: '3'},
								{text: '4', value: '4'},
								{text: '5', value: '5'},
								{text: '6', value: '6'},
								{text: '7', value: '7'},
								{text: '8', value: '8'},
								{text: '9', value: '9'},
								{text: '10', value: '10'},
								{text: '11', value: '11'},
								{text: '12', value: '12'},
							]
						},
						{type: 'textbox', name: 'day', label: 'Day', value:"1"},
						{type: 'textbox', name: 'hour', label: 'Hour', value:"0"},
						{type: 'textbox', name: 'minute', label: 'Minute', value:"0"},
						{type: 'listbox', 
							name: 'show_second', 
							label: 'Show second?', 
							'values': [
								{text: 'Yes', value: '1'},
								{text: 'No', value: '0'}
							]
						},
						{type: 'textbox', name: 'bg_color', label: 'Background Color', value:"#", id: 'newcolorpicker_countdownbg'},
						{type: 'textbox', name: 'num_color', label: 'Number Color', value:"#", id: 'newcolorpicker_countdownnum'},
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
						editor.insertContent('[ia_countdown year="'+e.data.year+'" month="'+e.data.month+'" day="'+e.data.day+'" hour="'+e.data.hour+'" minute="'+e.data.minute+'" bg_color="'+e.data.bg_color+'" num_color="'+e.data.num_color+'" show_second="'+e.data.show_second+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
