// JavaScript Document
(function() {
    // Creates a new plugin class and a custom listbox
    tinymce.create('tinymce.plugins.shortcode_countdown_clock', {
        createControl: function(n, cm) {
            switch (n) {                
                case 'shortcode_countdown_clock':
                var c = cm.createSplitButton('shortcode_countdown_clock', {
                    title : 'Countdown clock',
					id: 'countdown_shortcode',
                    onclick : function() {
                    }
                });

                c.onRenderMenu.add(function(c, m) {
                    m.onShowMenu.add(function(c,m){
                        jQuery('#menu_'+c.id).height('auto').width('auto');
                        jQuery('#menu_'+c.id+'_co').height('auto').addClass('mceListBoxMenu'); 
                        var $menu = jQuery('#menu_'+c.id+'_co').find('tbody:first');
						var d = new Date();
						var n = d.getFullYear();
						var m=0;
						var hour=0;
						var day=0;
						var minute=0;
                        if($menu.data('added')) return;
                        $menu.append('');
                        html='<div style="padding:0 10px 10px">\
						<label>Year:<br />\
						<select name="year">';
						for(i=0;i<=10;i++){
							n=n+1;
							html+='<option value="'+n+'">'+n+'</option>';
						}
						html+='</select></label>\
						<label>Month:<br />\
						<select name="month">';
						for(j=0;j<12;j++){
							m=m+1;
							html+='<option value="'+m+'">'+m+'</option>';
						}
						html+='</select></label>\
						<label>Day:<br />\
						<select name="day">';
						for(k=0;k<31;k++){
							day=day+1;
							html+='<option value="'+day+'">'+day+'</option>';
						}
						html+='</select></label>\
						<label>Hour<br />\
						<select name="hour">';
						for(k=0;k<24;k++){
							hour=hour+1;
							html+='<option value="'+hour+'">'+hour+'</option>';
						}
						html+='</select></label>\
						<label>Minute<br />\
						<select name="minute">';
						for(k=0;k<60;k++){
							minute=minute+1;
							html+='<option value="'+minute+'">'+minute+'</option>';
						}
						html+='\
						</select></label>\
						<div class="form-item"><label for="color1">Background Color</label><input type="text" id="color-count" name="color-count" value="#" /></div><div id="picker-count"></div>\
						<div class="form-item"><label for="color1">Background Color</label><input type="text" id="color-count2" name="color-count2" value="#" /></div><div id="picker-count2"></div>\
						<div class="form-item"><label for="color1">Background Color</label><input type="text" id="color-count3" name="color-count3" value="#" /></div><div id="picker-count3"></div>\
						<label>Animation:<br />\
						<select name="animation">\
							<option value="">No</option>\
							<option value="top-to-bottom">Top to bottom</option>\
							<option value="bottom-to-top">Bottom to top</option>\
							<option value="left-to-right">Left to right</option>\
							<option value="right-to-left">Right to left</option>\
							<option value="appear">Appear</option>\
						</select></label>\
                        </div>';
						$menu.append(html);
						  jQuery(document).ready(function() {
							jQuery('#color-count').click(function(){
								jQuery('#menu_content_content_shortcode_countdown_clock_menu_tbl').css("width","207px");
								jQuery('#picker-count').farbtastic('#color-count').show();
								jQuery('#picker-count2').farbtastic('#color-count2').hide();
								jQuery('#picker-count3').farbtastic('#color-count3').hide();
							});
							jQuery('#color-count2').click(function(){
								jQuery('#menu_content_content_shortcode_countdown_clock_menu_tbl').css("width","207px");
								jQuery('#picker-count2').farbtastic('#color-count2').show();
								jQuery('#picker-count3').farbtastic('#color-count3').hide();
								jQuery('#picker-count').farbtastic('#color-count').hide();
							});
							jQuery('#color-count3').click(function(){
								jQuery('#menu_content_content_shortcode_countdown_clock_menu_tbl').css("width","207px");
								jQuery('#picker-count3').farbtastic('#color-count3').show();
								jQuery('#picker-count').farbtastic('#color-count').hide();
								jQuery('#picker-count2').farbtastic('#color-count2').hide();
							});
						  });

							jQuery('<input type="button" class="button" value="Insert" />').appendTo($menu)
                                .click(function(){
                       
                                var uID =  Math.floor((Math.random()*100)+1);
                              	var year = $menu.find('select[name=year]').val();
								var month = $menu.find('select[name=month]').val();
								var day = $menu.find('select[name=day]').val();
								var hour = $menu.find('select[name=hour]').val();
								var minute = $menu.find('select[name=minute]').val();
								var bg_color = ($menu.find('input[id=color-count]').val()) ? 'bg_color="'+$menu.find('input[id=color-count]').val()+'"' : '';
								var text_color = ($menu.find('input[id=color-count2]').val()) ? 'text_color="'+$menu.find('input[id=color-count2]').val()+'"' : '';
								var unit_color = ($menu.find('input[id=color-count3]').val()) ? 'text_color="'+$menu.find('input[id=color-count3]').val()+'"' : '';
								var animation = $menu.find('select[name=animation]').val();
								var  shortcode= '[countdown   year="'+year+'" month="'+month+'" hour="'+hour+'" minute="'+minute+'" '+bg_color+' '+text_color+' '+unit_color+' animation="'+ animation +'"]';
                                    tinymce.activeEditor.execCommand('mceInsertContent',false,shortcode);
                                    c.hideMenu();
                                }).wrap('<tr><td><div style="padding: 0 10px 10px"></div></td></tr>')
                 
                        $menu.data('added',true); 

                    });
                   // XSmall
					m.add({title : 'Countdown clock', 'class' : 'mceMenuItemTitle'}).setDisabled(1);

                 });
                // Return the new splitbutton instance
                return c;
                
            }
            return null;
        }
    });
    tinymce.PluginManager.add('shortcode_countdown_clock', tinymce.plugins.shortcode_countdown_clock);
})();
