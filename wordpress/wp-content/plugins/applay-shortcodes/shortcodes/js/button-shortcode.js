// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_button_leafcolor', function(editor, url) {
		editor.addButton('shortcode_button_leafcolor', {
			text: '',
			tooltip: 'Shortcode',
			id: 'bt_listshortcode',
			icon: 'icons',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Shortcode',
					body: [
						{type: 'button', name: 'Button', text: 'Button', label: 'Button' , id: 'id_button'},
						{type: 'button', name: 'Member', text: 'Member', label: 'Member' , id: 'id_member'},
						{type: 'button', name: 'Dropcap', text: 'Dropcap', label: 'Dropcap' , id: 'id_button_dropcap'},
						{type: 'button', name: 'Heading', text: 'Heading', label: 'Heading' , id: 'id_button_heading'},
						{type: 'button', name: 'Countdown Clock', text: 'Countdown Clock', label: 'Countdown Clock' , id: 'id_button_coundown'},
						{type: 'button', name: 'Testimonial', text: 'Testimonial', label: 'Testimonial' , id: 'id_button_testimonial'},
						{type: 'button', name: 'Blog', text: 'Blog', label: 'Blog' , id: 'id_button_blog'},
						{type: 'button', name: 'Post Carousel', text: 'Post Carousel', label: 'Post Carousel' , id: 'id_button_post_carousel'},
						{type: 'button', name: 'Post Grid', text: 'Post Grid', label: 'Post Grid' , id: 'id_button_post_grid'},
						{type: 'button', name: 'Post Scroller', text: 'Post Scroller', label: 'Post Scroller' , id: 'id_button_post_scroller'},
						{type: 'button', name: 'Textbox', text: 'Textbox', label: 'Textbox' , id: 'id_button_textbox'},
						{type: 'button', name: 'Course list table', text: 'Course list table', label: 'Course list table' , id: 'id_button_course_list'},
					],
				});
			}
		});
	});
})();
