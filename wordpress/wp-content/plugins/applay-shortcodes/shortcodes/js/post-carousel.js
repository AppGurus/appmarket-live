// JavaScript Document
(function() {
    tinymce.PluginManager.add('shortcode_post_carousel', function(editor, url) {
		editor.addButton('shortcode_post_carousel', {
			text: '',
			tooltip: 'Post Carousel',
			id: 'post_carousel_shortcode',
			icon: 'icon-post-carousel',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Post Carousel',
					body: [
						{type: 'listbox', 
							name: 'post_type', 
							label: 'Post Type', 
							'values': [
								{text: 'Post', value: 'post'},
								{text: 'Product', value: 'product'},
								{text: 'Portfolio', value: 'app_portfolio'},
								{text: 'Attachment', value: 'attachment'}
							]
						},
						{type: 'textbox', name: 'cat', label: 'Category (List of cat ID or slug)'},
						{type: 'textbox', name: 'tag', label: 'Tags (List of tags, separated by a comma)'},
						{type: 'textbox', name: 'ids', label: 'Ids (Specify post IDs to retrieve)'},
						{type: 'textbox', name: 'number', label: 'Number of posts to show.'},
						{type: 'textbox', name: 'visible', label: 'Visible items'},
						{type: 'listbox', 
							name: 'order', 
							label: 'Order', 
							'values': [
								{text: 'DESC', value: 'DESC'},
								{text: 'ASC', value: 'ASC'}
							]
						},
						{type: 'listbox', 
							name: 'orderby', 
							label: 'Order by', 
							'values': [
								{text: 'Date', value: 'date'},
								{text: 'ID', value: 'ID'},
								{text: 'Author', value: 'author'},
								{text: 'Title', value: 'title'},
								{text: 'Name', value: 'name'},
								{text: 'Modified', value: 'modified'},
								{text: 'Parent', value: 'parent'},
								{text: 'Random', value: 'rand'},
								{text: 'Comment count', value: 'comment_count'},
								{text: 'Menu order', value: 'menu_order'},
								{text: 'Meta value', value: 'meta_value'},
								{text: 'Meta value num', value: 'meta_value_num'},
								{text: 'Post__in', value: 'post__in'},
								{text: 'None', value: 'none'}
							]
						},
						{type: 'textbox', name: 'meta_key', label: 'Meta key (Name of meta key for ordering)'},
						{type: 'listbox', 
							name: 'show_extra', 
							label: 'Show extra info', 
							'values': [
								{text: 'Show', value: '1'},
								{text: 'Hide', value: '0'}
							]
						},
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
						editor.insertContent('[ia_post_carousel post_type="'+e.data.post_type+'" cat="'+e.data.cat+'" tag="'+e.data.tag+'" ids="'+e.data.ids+'" count="'+e.data.number+'" visible="'+e.data.visible+'" order="'+e.data.order+'" orderby="'+e.data.orderby+'" meta_key="'+e.data.meta_key+'" show_extra="'+e.data.show_extra+'" css_animation="'+e.data.css_animation+'" animation_delay="'+e.data.animation_delay+'"]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
