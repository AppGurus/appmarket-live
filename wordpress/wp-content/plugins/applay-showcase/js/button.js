// JavaScript Document
/*(function() {
    // Creates a new plugin class and a custom listbox
    tinymce.create('tinymce.plugins.ecs_button', {
        createControl: function(n, cm) {
            switch (n) {                
                case 'ecs_button':
                var c = cm.createSplitButton('ecs_button', {
                    title : 'Easy Carousel',
                    onclick : function() {
						selected = tinyMCE.activeEditor.selection.getContent();
						if( selected ){
							//If text is selected when button is clicked
							//Wrap shortcode around it.
							content =  '[carousel]'+selected+'[/carousel]';
						}else{
							content =  '[carousel]';
						}
						tinymce.execCommand('mceInsertContent', false, content);
                    },
					//image: url + '/button.png',
                });

                c.onRenderMenu.add(function(c, m) {
                    m.onShowMenu.add(function(c,m){
                        jQuery('#menu_'+c.id).height('auto').width('auto');
                        jQuery('#menu_'+c.id+'_co').height('auto').addClass('mceListBoxMenu'); 
                        var $menu = jQuery('#menu_'+c.id+'_co').find('tbody:first');
                        if($menu.data('added')) return;
                        $menu.append('');
                        $menu.append('<tr><td><div style="padding:10px 10px 10px">\
						<strong>Custom query post</strong><br>\
						<label>Cat ID (Ex:1,2)<br />\
                        <input type="text" name="cat" value="" /></label><br />\
						<label>Tags (Ex:foo,bar)<br />\
                        <input type="text" name="tag" value="" /></label><br />\
						<label>Post type (Ex:post)<br />\
                        <input type="text" name="post_type" value="" /></label><br />\
						<label>Number of posts (Ex:30)<br />\
                        <input type="text" name="posts_per_page" value="" /></label><br />\
						<label>Order by (Ex:date)<br />\
                        <input type="text" name="orderby" value="" /></label><br />\
						<label>Order<br />\
                        <select name="order">\
						<option value="">Choose..</option>\
						<option value="DESC">Descending</option>\
						<option value="ASC">Ascending</option>\
						</select></label><br />\
                        </div></td></tr>');

                        jQuery('<input type="button" class="button" value="Insert" />').appendTo($menu)
                                .click(function(){
								var cat = $menu.find('input[name=cat]').val();
								var tag = $menu.find('input[name=tag]').val();
								var post_type = $menu.find('input[name=post_type]').val();
								var posts_per_page = $menu.find('input[name=posts_per_page]').val();
								var orderby = $menu.find('input[name=orderby]').val();
								var order = $menu.find('select[name=order]').val();
								var shortcode = '[carousel cat="'+cat+'" tag="'+tag+'" post_type="'+post_type+'" posts_per_page="'+posts_per_page+'" orderby="'+orderby+'" order="'+order+'"][/carousel]<br />';
                                tinymce.activeEditor.execCommand('mceInsertContent',false,shortcode);
                                    c.hideMenu();
                                }).wrap('<tr><td><div style="padding: 0 10px 10px"></div></td></tr>')
                 
                        $menu.data('added',true); 

                    });

                   // XSmall
					m.add({title : 'Easy Carousel', 'class' : 'mceMenuItemTitle'}).setDisabled(1);

                 });
                // Return the new splitbutton instance
                return c;
                
            }
            return null;
        }
    });
    tinymce.PluginManager.add('ecs_button', tinymce.plugins.ecs_button);
})();
*/
jQuery(document).ready(function($) {
    tinymce.create('tinymce.plugins.ecs_plugin', {
        init : function(ed, url) {
                // Register command for when button is clicked
                ed.addCommand('ecs_insert_shortcode', function() {
                    selected = tinyMCE.activeEditor.selection.getContent();

                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content =  '[ezcarousel]'+selected+'[/ezcarousel]';
                    }else{
                        content =  '[ezcarousel][/ezcarousel]';
                    }
                    tinymce.execCommand('mceInsertContent', false, content);
                });

            // Register buttons - trigger above command when clicked
            ed.addButton('ecs_button', {title : 'Insert Carousel', cmd : 'ecs_insert_shortcode', image: url + '/button.png' });
        },   
    });

    // Register our TinyMCE plugin
    // first parameter is the button ID1
    // second parameter must match the first parameter of the tinymce.create() function above
    tinymce.PluginManager.add('ecs_button', tinymce.plugins.ecs_plugin);
});