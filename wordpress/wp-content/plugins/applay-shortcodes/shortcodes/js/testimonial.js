// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_testimonial', function(editor, url) {
		editor.addButton('shortcode_testimonial', {
			text: '',
			tooltip: 'Testimonials',
			id: 'testimonial_shortcode',
			icon: 'icon-testimonial',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Testimonials',
					body: [
						{type: 'listbox', 
							name: 'autoscroll', 
							label: 'Auto Scroll', 
							'values': [
								{text: 'Yes', value: '1'},
								{text: 'No', value: '0'}
							]
						},
						{type: 'textbox', name: 'number', label: 'Number of Testimonials'},
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
						var number = e.data.number?e.data.number:2;
						var shortcode_output ='[ia_testimonial scroll="'+e.data.autoscroll+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]';
						for(i=0; i<number; i++){
							shortcode_output +='[ia_testimonial_item name="John Doe" title="Professor" avatar="1780" ]This is my testimonial content [/ia_testimonial_item]';
						}
						shortcode_output +='[/ia_testimonial]';
						// Insert content when the window form is submitted
						editor.insertContent(shortcode_output+'<br class="nc"/>');
					}
				});
			}
		});
	});
})();
