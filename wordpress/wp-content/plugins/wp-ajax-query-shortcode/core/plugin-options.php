<?php

/*

 * add option page

 */

add_action('admin_menu', 'waq_plugin_settings');
function waq_plugin_settings(){
    add_menu_page('Quick Ajax', 'Quick Ajax', 'administrator', 'waq_settings', 'waq_display_settings');
}
function register_waq_setting() {
	register_setting( 'waq_options_group', 'waq_options_group', 'waq_options_validate' );
	//Appearance settings
	add_settings_section('waq_settings_appe','','waq_settings_appe_html','waq_settings');
	add_settings_field('layout',__('Choose Layout','waq'),'waq_layout_html','waq_settings','waq_settings_appe');
	add_settings_field('col_width',__('Column Width','waq'),'waq_col_width_html','waq_settings','waq_settings_appe');
	//add_settings_field('waq_main_color',__('Main Color','waq'),'waq_main_color_html','waq_settings','waq_settings_appe');
	//Ajax settings
	add_settings_section('waq_settings_ajax','','waq_settings_ajax_html','waq_settings');
	add_settings_field('waq_ajax_style',__('Choose Ajax Style','waq'),'waq_ajax_style_html','waq_settings','waq_settings_ajax');
	add_settings_field('waq_button',__('Load More Button','waq'),'waq_button_html','waq_settings','waq_settings_ajax');
	add_settings_field('waq_button_icon',__('Load More Icon','waq'),'waq_button_icon_html','waq_settings','waq_settings_ajax');
	add_settings_field('waq_loading_image',__('Loading Image','waq'),'waq_loading_image_html','waq_settings','waq_settings_ajax');
	//post settings
	add_settings_section('waq_settings_post','','waq_settings_post_html','waq_settings');
	add_settings_field('waq_thumb_size',__('Thumbnail Size','waq'),'waq_thumb_size_html','waq_settings','waq_settings_post');
	add_settings_field('waq_post_title',__('Post Title','waq'),'waq_post_title_html','waq_settings','waq_settings_post');
	add_settings_field('waq_post_excerpt',__('Post Excerpt','waq'),'waq_post_excerpt_html','waq_settings','waq_settings_post');
	add_settings_field('waq_post_meta',__('Post Meta','waq'),'waq_post_meta_html','waq_settings','waq_settings_post');
	//add_settings_field('waq_post_background',__('Post background','waq'),'waq_post_background_html','waq_settings','waq_settings_post');
	add_settings_field('waq_thumb_hover',__('Thumbnail Hover Icon','waq'),'waq_thumb_hover_html','waq_settings','waq_settings_post');
	add_settings_field('waq_popup_theme',__('Popup Theme','waq'),'waq_popup_theme_html','waq_settings','waq_settings_post');
	add_settings_field('waq_border_hover',__('Hover Border','waq'),'waq_border_hover_html','waq_settings','waq_settings_post');
	//query settings
	add_settings_section('waq_settings_query','','waq_settings_query_html','waq_settings');
	add_settings_field('waq_cat',__('Choose category','waq'),'waq_cat_html','waq_settings','waq_settings_query');
	add_settings_field('waq_tag',__('Enter tags','waq'),'waq_tag_html','waq_settings','waq_settings_query');
	add_settings_field('waq_post_type',__('Post type','waq'),'waq_post_type_html','waq_settings','waq_settings_query');
	add_settings_field('waq_orderby',__('Order by','waq'),'waq_orderby_html','waq_settings','waq_settings_query');
	add_settings_field('waq_posts_per_page',__('Posts per page','waq'),'waq_posts_per_page_html','waq_settings','waq_settings_query');
	//other settings
	add_settings_section('waq_settings_other','','waq_settings_other_html','waq_settings');
	add_settings_field('waq_fontawesome',__('Turn off Font Awesome','waq'),'waq_fontawesome_html','waq_settings','waq_settings_other');
} 
add_action( 'admin_init', 'register_waq_setting' );

/*
 * render option page
 */
function waq_display_settings(){
$waq_options = get_option('waq_options_group');
$waq_button_font = isset($waq_options['button_font'])?$waq_options['button_font']:'';
$waq_post_title_font = isset($waq_options['post_title_font'])?$waq_options['post_title_font']:'';
$waq_post_excerpt_font = isset($waq_options['post_excerpt_font'])?$waq_options['post_excerpt_font']:'';
$waq_post_meta_font = isset($waq_options['post_meta_font'])?$waq_options['post_meta_font']:'';
?>
</pre>
<div class="wrap">
  <div class="mip-setting-page">
    <h1 class="mip-head"><i class="fa fa-cogs"></i> Quick Ajax Query Settings</h1>
    <div class="mip-setting-content">
    <?php if(isset($_GET['settings-updated'])&&$_GET['settings-updated']==true) {?>
    	<div class="form-group">
            <div class="form-label"></div>
            <div class="form-control">
            	<i class="fa fa-check"></i> Settings were saved.
            </div>
         </div>
    <?php } ?>
    <form action="options.php" method="post" name="options" id="mip-form" class="waq-data">
    	<?php settings_errors('med-settings-errors'); ?>
        <?php
			settings_fields('waq_options_group');
			do_settings_sections('waq_settings');
		?>
      	<div class="form-group">
            <div class="form-label"></div>
            <div class="form-control">
            	<button type="submit" title="Update Default Setting" name="submit" class="button"><i class="fa fa-check"></i> Update</button>
                <a href="#" title="Generate shortcode with current settings" class="button" id="waq-generate"><i class="fa fa-edit"></i> Generate shortcode</a>
                <span>Use generate shortcode if you want to create Ajax Query with overwrite default settings</span>
                <br />
                <textarea id="shortcode-area" style="width:94%;height:140px; margin-top:10px; display:none"></textarea>
            </div>
      	</div>
        <script type="text/javascript">
		jQuery(document).ready(function(){ 
			jQuery.getJSON('<?php echo WAQ_PATH ?>core/googlefont.php', function(data){
				var item1 = item2 = item3 = item4 ='';
				jQuery.each(data.items, function(key, val){
					if(val.family=='<?php echo $waq_button_font ?>'){
						item1 += '<option value="'+ val.family + '" selected="selected">'+val.family+'</option>';
					}else{
						item1 += '<option value="'+ val.family + '">'+val.family+'</option>';
					}
					if(val.family=='<?php echo $waq_post_title_font ?>'){
						item2 += '<option value="'+ val.family + '" selected="selected">'+val.family+'</option>';
					}else{
						item2 += '<option value="'+ val.family + '">'+val.family+'</option>';
					}
					if(val.family=='<?php echo $waq_post_excerpt_font ?>'){
						item3 += '<option value="'+ val.family + '" selected="selected">'+val.family+'</option>';
					}else{
						item3 += '<option value="'+ val.family + '">'+val.family+'</option>';
					}
					if(val.family=='<?php echo $waq_post_meta_font ?>'){
						item4 += '<option value="'+ val.family + '" selected="selected">'+val.family+'</option>';
					}else{
						item4 += '<option value="'+ val.family + '">'+val.family+'</option>';
					}
				});
				jQuery('select.font1').append(item1);
				jQuery('select.font2').append(item2);
				jQuery('select.font3').append(item3);
				jQuery('select.font4').append(item4);
				jQuery('.loading-font').remove();
				}); 
			});
		</script>
    </form>
    </div>
  </div>
</div>
<pre>
<?php
}

//header for setting section
function waq_settings_appe_html(){ ?>
	<h2 class="option-group"><i class="fa fa-laptop"></i> Appearance settings</h2>
<?php 

}

//header for setting section

function waq_settings_ajax_html(){ ?>

	<h2 class="option-group"><i class="fa fa-spinner"></i> Ajax settings</h2>

<?php 

}

//header for setting section

function waq_settings_play_html(){ ?>

	<h2 class="option-group"><i class="fa fa-play"></i> Play settings</h2>

<?php 

}

//header for setting section

function waq_settings_post_html(){ ?>

	<h2 class="option-group"><i class="fa fa-edit"></i> Post settings</h2>

<?php 

}

//header for setting section

function waq_settings_query_html(){ ?>



	<h2 class="option-group"><i class="fa fa-rss"></i> Query post settings</h2>

<?php 

}

//header for setting section

function waq_settings_other_html(){ ?>

	<h2 class="option-group"><i class="fa fa-plus-sign"></i> Other settings</h2>

<?php 

}

$waq_options = get_option('waq_options_group');

$waq_font_array=array('Arial','Tahoma','Verdana','Times New Roman','Lucida Sans Unicode');

//render options fields
function waq_layout_html(){
	global $waq_options;
	$layout = isset($waq_options['layout'])?$waq_options['layout']:'classic';
	$array = array(
		array(
			'name'=>'waq_options_group[layout]',
			'value' => 'classic',
			'label' => 'Classic',
			'icon' => 'fa fa-th-list fa-3x',
		),
		array(
			'name'=>'waq_options_group[layout]',
			'value' => 'timeline',
			'label' => 'Timeline',
			'icon' => 'fa fa-clock-o fa-3x',
		),
		array(
			'name'=>'waq_options_group[layout]',
			'value' => 'modern',
			'label' => 'Modern',
			'icon' => 'fa fa-th-large fa-3x',
		),
		array(
			'name'=>'waq_options_group[layout]',
			'value' => 'combo',
			'label' => 'Combo',
			'icon' => 'fa fa-random fa-3x',
		)
	);
	mip_image_radio($layout,$array);?>
    <span> Choose a layout (Classic - list, Modern - masonry, Combo - switch 2 layouts)</span>
<?php
}

//render options fields

function waq_col_width_html(){

	global $waq_options;

	$col_width = isset($waq_options['col_width'])?$waq_options['col_width']:'225'; ?>

    <input type="number" name="waq_options_group[col_width]" title="Column width" placeholder="Column width" value="<?php echo $col_width ?>" />

    <span>px (Ex: 225) Uses for column width in Modern layout and Thumbnail width in Classic layout</span>

<?php

}

//render options fields

function waq_ajax_style_html(){
	global $waq_options;
	$ajax_style = isset($waq_options['ajax_style'])?$waq_options['ajax_style']:'button';
	$array = array(
		array(
			'name'=>'waq_options_group[ajax_style]',
			'value' => 'scroll',
			'label' => 'Infinity Scroll',
			'icon' => 'fa fa-sort-amount-asc fa-3x',
		),
		array(
			'name'=>'waq_options_group[ajax_style]',
			'value' => 'button',
			'label' => 'Next button',
			'icon' => 'fa fa-arrow-circle-right fa-3x',
		)
	);
	mip_image_radio($ajax_style,$array);?>
<?php

}

function waq_button_html(){
	global $waq_options;
	$waq_button_label = isset($waq_options['button_label'])?$waq_options['button_label']:'View more';
	$waq_button_text_color = isset($waq_options['button_text_color'])?$waq_options['button_text_color']:'ffffff';
	$waq_button_bg_color = isset($waq_options['button_bg_color'])?$waq_options['button_bg_color']:'35aa47';
	$waq_button_font = isset($waq_options['button_font'])?$waq_options['button_font']:'0';
	$waq_button_size = isset($waq_options['button_size'])?$waq_options['button_size']:'14';
?>
	<input type="text" name="waq_options_group[button_label]" placeholder="Label" value="<?php echo $waq_button_label ?>" title="Label" />
    <i class="fa fa-adjust"></i><span> Color:</span>
    <input class="color" placeholder="Text Color" name="waq_options_group[button_text_color]" value="<?php echo $waq_button_text_color ?>" title="Text color">
    <i class="fa fa-tint"></i><span> Background:</span>
    <input class="color" placeholder="Background Color" name="waq_options_group[button_bg_color]" value="<?php echo $waq_button_bg_color ?>" title="Background color">
    <i class="fa fa-font"></i>
    <select class="font font1" name="waq_options_group[button_font]" title="Font">
        <option value="0">Choose Font</option>
        <?php
		global $waq_font_array;
		foreach($waq_font_array as $font){ ?>
			<option value="<?php echo $font ?>" <?php echo $font==$waq_button_font?'selected="selected"':'' ?> ><?php echo $font ?></option>
		<?php } ?>
        <option class="loading-font" disabled="disabled">Loading google font list...</option>
    </select>
    <i class="fa fa-text-height"></i>
    <input type="number" class="mini" name="waq_options_group[button_size]" title="Font Size" placeholder="Font size" value="<?php echo $waq_button_size ?>" />
    <span>px</span>
<?php
}

function waq_button_icon_html(){
	global $waq_options;
	$waq_button_icon = isset($waq_options['button_icon'])?$waq_options['button_icon']:'fa fa-double-angle-right';
?>
    <select style="font-family: 'FontAwesome', 'Helvetica';" name="waq_options_group[button_icon]">
    	<option value="0">Select icon...</option>
		<?php waq_font_awesome_option($waq_button_icon); ?>
	</select>
<?php
}

function waq_loading_image_html(){
	global $waq_options;
	$waq_loading_image = isset($waq_options['loading_image'])?$waq_options['loading_image']:'1';
	$array = array(
		array(
			'name'=>'waq_options_group[loading_image]',
			'value' => '1',
			'label' => '',
			'icon' => '<img src="'.WAQ_PATH.'images/gray.gif" width="88px" height="8px" />',
		),
		array(
			'name'=>'waq_options_group[loading_image]',
			'value' => '2',
			'label' => '',
			'icon' => '<i class="fa fa-spinner fa-spin fa-large"></i>',
		),
		array(
			'name'=>'waq_options_group[loading_image]',
			'value' => '3',
			'label' => '',
			'icon' => '<i class="fa fa-refresh fa-spin fa-large"></i>',
		),
		array(
			'name'=>'waq_options_group[loading_image]',
			'value' => '4',
			'label' => '',
			'icon' => '<i class="fa fa-cog fa-spin fa-large"></i>',
		)
	);
	mip_image_radio_custom($waq_loading_image,$array);
}

function waq_thumb_size_html(){

	global $waq_options;

	$waq_thumb_size = isset($waq_options['thumb_size'])?$waq_options['thumb_size']:'thumbnail';

?>

    <select name="waq_options_group[thumb_size]">

    <?php 

    $sizes = waq_list_thumbnail_sizes();

    foreach( $sizes as $size => $atts ): ?>

        <option value="<?php echo $size ?>" <?php echo $waq_thumb_size==$size?'selected':'' ?> ><?php echo $size . ' ' . implode( 'x', $atts ) ?></option>

    <?php endforeach; ?>

    </select>

<?php	

}

function waq_post_title_html(){

	global $waq_options;

	$waq_post_title_color = isset($waq_options['post_title_color'])?$waq_options['post_title_color']:'35aa47';

	$waq_post_title_font = isset($waq_options['post_title_font'])?$waq_options['post_title_font']:'';

	$waq_post_title_size = isset($waq_options['post_title_size'])?$waq_options['post_title_size']:'18';

	?>

    <i class="fa fa-adjust"></i>

    <input class="color" placeholder="Color" name="waq_options_group[post_title_color]" value="<?php echo $waq_post_title_color ?>" title="Text color">

    <i class="fa fa-font"></i>

    <select class="font font2" name="waq_options_group[post_title_font]" title="Font">

        <option value="0">Choose Font</option>

        <?php

        global $waq_font_array;

		foreach($waq_font_array as $font){ ?>

                <option value="<?php echo $font ?>" <?php echo $font==$waq_post_title_font?'selected="selected"':'' ?> ><?php echo $font ?></option>

            <?php }

        ?>

        <option class="loading-font" disabled="disabled">Loading google font list...</option>

    </select>

    <i class="fa fa-text-height"></i>

    <input type="number" class="mini" name="waq_options_group[post_title_size]" title="Font Size" placeholder="Font size" value="<?php echo $waq_post_title_size ?>" />

<?php

}

function waq_post_excerpt_html(){
	global $waq_options;
	$waq_post_excerpt_color = isset($waq_options['post_excerpt_color'])?$waq_options['post_excerpt_color']:'444444';
	$waq_post_excerpt_font = isset($waq_options['post_excerpt_font'])?$waq_options['post_excerpt_font']:'';
	$waq_post_excerpt_size = isset($waq_options['post_excerpt_size'])?$waq_options['post_excerpt_size']:'14';
	$waq_post_excerpt_limit = isset($waq_options['post_excerpt_limit'])?$waq_options['post_excerpt_limit']:'0';
?>
    <i class="fa fa-adjust"></i>
    <input class="color" placeholder="Color" name="waq_options_group[post_excerpt_color]" value="<?php echo $waq_post_excerpt_color ?>" title="Text color">
    <i class="fa fa-font"></i>
    <select class="font font3" name="waq_options_group[post_excerpt_font]" title="Font">
        <option value="0">Choose Font</option>
        <?php
		global $waq_font_array;
		foreach($waq_font_array as $font){ ?>
			<option value="<?php echo $font ?>" <?php echo $font==$waq_post_excerpt_font?'selected="selected"':'' ?> ><?php echo $font ?></option>
		<?php } ?>
        <option class="loading-font" disabled="disabled">Loading google font list...</option>
    </select>
    <i class="fa fa-text-height"></i>
    <input type="number" class="mini" name="waq_options_group[post_excerpt_size]" title="Font Size" placeholder="Font size" value="<?php echo $waq_post_excerpt_size ?>" />
    <span> Limit:</span>
    <input type="number" class="mini" name="waq_options_group[post_excerpt_limit]" title="Exerpt limit words number" placeholder="Limit words number" value="<?php echo $waq_post_excerpt_limit ?>" />
	<span> "0" for default<i> (This is global variable, effect all Quick Ajax Shortcodes)</i></span>
<?php
}

function waq_post_meta_html(){
	global $waq_options;
	$waq_post_meta_color = isset($waq_options['post_meta_color'])?$waq_options['post_meta_color']:'999999';
	$waq_post_meta_font = isset($waq_options['post_meta_font'])?$waq_options['post_meta_font']:'';
	$waq_post_meta_size = isset($waq_options['post_meta_size'])?$waq_options['post_meta_size']:'11';
?>

    <i class="fa fa-adjust"></i>

    <input class="color" placeholder="Color" name="waq_options_group[post_meta_color]" value="<?php echo $waq_post_meta_color ?>" title="Text color">

    <i class="fa fa-font"></i>

    <select class="font font4" name="waq_options_group[post_meta_font]" title="Font">

        <option value="0">Choose Font</option>

        <?php

		global $waq_font_array;

		foreach($waq_font_array as $font){ ?>

			<option value="<?php echo $font ?>" <?php echo $font==$waq_post_meta_font?'selected="selected"':'' ?> ><?php echo $font ?></option>

		<?php } ?>

        <option class="loading-font" disabled="disabled">Loading google font list...</option>

    </select>

    <i class="fa fa-text-height"></i>

    <input type="number" class="mini" name="waq_options_group[post_meta_size]" title="Font Size" placeholder="Font size" value="<?php echo $waq_post_meta_size ?>" />

<?php	

}

function waq_thumb_hover_html(){

	global $waq_options;

	$waq_thumb_hover_icon = isset($waq_options['thumb_hover_icon'])?$waq_options['thumb_hover_icon']:'fa-search';

	$waq_thumb_hover_color = isset($waq_options['thumb_hover_color'])?$waq_options['thumb_hover_color']:'35aa47';

	$waq_thumb_hover_bg = isset($waq_options['thumb_hover_bg'])?$waq_options['thumb_hover_bg']:'ffffff';

	$waq_thumb_hover_popup = isset($waq_options['thumb_hover_popup'])?$waq_options['thumb_hover_popup']:'1';

	?>

    <select style="font-family: 'FontAwesome', 'Helvetica';" name="waq_options_group[thumb_hover_icon]">

    	<option value="0">No icon</option>

		<?php waq_font_awesome_option($waq_thumb_hover_icon); ?>

	</select>

    <i class="fa fa-adjust"></i><span> Icon color:</span>

    <input class="color" placeholder="Icon Color" name="waq_options_group[thumb_hover_color]" value="<?php echo $waq_thumb_hover_color ?>" title="Icon color">

    <i class="fa fa-tint"></i><span> Background:</span>

    <input class="color" placeholder="Background Color" name="waq_options_group[thumb_hover_bg]" value="<?php echo $waq_thumb_hover_bg ?>" title="Background color">

    <span>&nbsp;&nbsp;&nbsp;When click thumb? </span>

<?php

	$array = array(
		array(
			'name'=>'waq_options_group[thumb_hover_popup]',
			'value' => '1',
			'label' => 'Popup Image',
			'icon' => 'fa-photo',
		),
		array(
			'name'=>'waq_options_group[thumb_hover_popup]',
			'value' => '0',
			'label' => 'Go to post',
			'icon' => 'fa-link',
		)
	);
	mip_image_radio($waq_thumb_hover_popup,$array);
}

function waq_popup_theme_html(){

	global $waq_options;

	$waq_popup_theme = isset($waq_options['popup_theme'])?$waq_options['popup_theme']:'0';

	?>

    <select name="waq_options_group[popup_theme]">

		<option value="0" <?php echo $waq_popup_theme=='0'?'selected="selected"':'' ?>>Default</option>

        <option value="facebook" <?php echo $waq_popup_theme=='facebook'?'selected="selected"':'' ?>>Facebook</option>

        <option value="light_rounded" <?php echo $waq_popup_theme=='light_rounded'?'selected="selected"':'' ?>>Light rounded</option>

        <option value="light_square" <?php echo $waq_popup_theme=='light_square'?'selected="selected"':'' ?>>Light square</option>

        <option value="dark_rounded" <?php echo $waq_popup_theme=='dark_rounded'?'selected="selected"':'' ?>>Dark rounded</option>

        <option value="dark_square" <?php echo $waq_popup_theme=='dark_square'?'selected="selected"':'' ?>>Dark square</option>

	</select>

<?php

}

function waq_border_hover_html(){
	global $waq_options;
	$waq_border_hover_color = isset($waq_options['border_hover_color'])?$waq_options['border_hover_color']:'35AA47';
	$waq_border_hover_width = isset($waq_options['border_hover_width'])?$waq_options['border_hover_width']:'1';
?>
    <i class="fa fa-adjust"></i>
    <input class="color" placeholder="Border" name="waq_options_group[border_hover_color]" value="<?php echo $waq_border_hover_color ?>" title="Border color">
    <span><i class="fa fa-resize-horizontal"></i> Border width</span>
    <input class="mini" type="number" max="100" min="0" name="waq_options_group[border_hover_width]" title="Border width" value="<?php echo $waq_border_hover_width ?>" /><span> px&nbsp;&nbsp;(Use for Timeline color scheme also)</span>
<?php
}

function waq_cat_html(){
	global $waq_options;
	$waq_cat = isset($waq_options['cat'])?$waq_options['cat']:array();
	$cats = get_terms( 'category', 'hide_empty=0' );
	echo '<div class="waq_cat_checkbox">';
	if($cats){
		foreach ($cats as $acat){
			$checked = in_array($acat->term_id,$waq_cat)?'checked':'';
			echo '<div class="checkbox-item"><input type="checkbox" name="waq_options_group[cat][]" value="'.$acat->term_id.'" '.$checked.'/><span> '.$acat->name.' </span></div>';
		}
	}
	echo '</div>';
}

function waq_tag_html(){
	global $waq_options;
	$waq_tag = isset($waq_options['tag'])?$waq_options['tag']:'';
	?>
    <input type="text" name="waq_options_group[tag]" placeholder="Tags to include" value="<?php echo $waq_tag ?>" /><span> Ex: foo,bar,sample-tag (Uses tag slug)</span>
<?php
}

function waq_post_type_html(){
	global $waq_options;
	$waq_post_type = isset($waq_options['post_type'])?$waq_options['post_type']:array();
	$pargs = array(
		'public'   => true,
		'publicly_queryable' => true,
		'_builtin' => false
	);
	$output = 'names'; // names or objects, note names is the default
	$operator = 'and'; // 'and' or 'or'
	$post_types = get_post_types( $pargs, $output, $operator ); 
	$post_types[] = 'post';
	$post_types[] = 'attachment';
	sort($post_types);
	echo '<div class="waq_posttype_checkbox">';
	foreach ( $post_types  as $post_type ) {
		$checked = in_array($post_type,$waq_post_type)?'checked':'';
		echo '<div class="checkbox-item"><input type="checkbox" name="waq_options_group[post_type][]" value="'.$post_type.'" '.$checked.'/><span> '.$post_type.' </span></div>';
	}
	echo '</div>';
}

function waq_orderby_html(){
	global $waq_options;
	$waq_orderby = isset($waq_options['orderby'])?$waq_options['orderby']:'date';
	$waq_order = isset($waq_options['order'])?$waq_options['order']:'DESC';
	?>
    <select name="waq_options_group[orderby]">
    	<?php
			$options = array('ID','date','title','name','parent','author','modified','comment_count','menu_order','rand');
			foreach($options as $option){
				$selected = $option==$waq_orderby?'selected="selected"':'';
				echo '<option value="'.$option.'" '.$selected.' >'.$option.'</option>';
			}
		?>
    </select>
    <span> Order:</span>
    <select name="waq_options_group[order]">
    	<?php
			$options = array('ASC','DESC');
			foreach($options as $option){
				$selected = $option==$waq_order?'selected="selected"':'';
				echo '<option value="'.$option.'" '.$selected.' >'.$option.'</option>';
			}
		?>
    </select>
<?php

}
function waq_posts_per_page_html(){
	global $waq_options;
	$waq_posts_per_page = isset($waq_options['posts_per_page'])?$waq_options['posts_per_page']:'12';
	?>
    <input type="number" value="<?php echo $waq_posts_per_page ?>" name="waq_options_group[posts_per_page]" placeholder="Default = 12" />
<?php
}

function waq_rtl_html(){
	global $waq_options;
	$waq_rtl = isset($waq_options['waq_rtl'])?$waq_options['waq_rtl']:'0';
	?>
    <div class="waq_rtl_checkbox">
    <input type="checkbox" <?php echo $waq_rtl?'checked':'' ?> name="waq_options_group[waq_rtl]" value="1" /><span> Enable RTL mode</span>
    </div>
<?php
}

function waq_fontawesome_html(){

	global $waq_options;

	$waq_fontawesome = isset($waq_options['fontawesome'])?$waq_options['fontawesome']:'0';

	?>

    <div class="waq_fontawesome_checkbox">

    <input type="checkbox" <?php echo $waq_fontawesome?'checked':'' ?> name="waq_options_group[fontawesome]" value="1" /><span> Turn off loading plugin's Font Awesome. Check if your theme has already loaded this library</span>

    </div>

<?php

}



//validate

function waq_options_validate( $input ) {

    return $input;  

}



/*
 * build radio image select
 */
function mip_image_radio($option,$array){
?>
<span class="image-select">
	<?php foreach($array as $item){ ?>
    <input type="radio" name="<?php echo $item['name'] ?>" id="<?php echo $item['name'] ?>-<?php echo $item['value'] ?>" value="<?php echo $item['value'] ?>" <?php echo ($option==$item['value'])?'checked':'' ?> />
    <label for="<?php echo $item['name'] ?>-<?php echo $item['value'] ?>" class="<?php echo ($option==$item['value'])?'selected':'' ?>" ><i class="fa <?php echo $item['icon'] ?> fa-large"></i><br>
    <?php echo $item['label'] ?></label>
    <?php } ?>
</span>
<?php
}
function mip_image_radio_custom($option,$array){
?>
<span class="image-select">
	<?php foreach($array as $item){ ?>
    <input type="radio" name="<?php echo $item['name'] ?>" id="<?php echo $item['name'] ?>-<?php echo $item['value'] ?>" value="<?php echo $item['value'] ?>" <?php echo ($option==$item['value'])?'checked':'' ?> />
    <label for="<?php echo $item['name'] ?>-<?php echo $item['value'] ?>" class="<?php echo ($option==$item['value'])?'selected':'' ?>" ><?php echo $item['icon'] ?><br>
    <?php echo $item['label'] ?></label>
    <?php } ?>
</span>
<?php
}

/*
 * enqueue admin scripts
 */

function waq_admin_scripts() {
    wp_enqueue_script('jquery');
	wp_enqueue_script('jscolor', WAQ_PATH.'js/jscolor/jscolor.js', array('jquery'));
	wp_enqueue_script('wpajax_admin', plugins_url( 'admin.js', __FILE__ ), array('jquery'));
	wp_enqueue_style('wpajax_admin', plugins_url( 'admin.css', __FILE__ ));
	wp_enqueue_style('font-awesome', WAQ_PATH.'font-awesome/css/font-awesome.min.css');
}
add_action( 'admin_enqueue_scripts', 'waq_admin_scripts' );

/*
 * get list image sizes
 */
function waq_list_thumbnail_sizes(){
	global $_wp_additional_image_sizes;
	$sizes = array();
	foreach( get_intermediate_image_sizes() as $s ){
		$sizes[ $s ] = array( 0, 0 );
		if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ){
			$sizes[ $s ][0] = get_option( $s . '_size_w' );
			$sizes[ $s ][1] = get_option( $s . '_size_h' );
		}else{
			if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) )
			$sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'], );
		}
	}
	return $sizes;
}

//add tinyMCE button
// init process for registering our button
add_action('init', 'waq_shortcode_button_init');
function waq_shortcode_button_init() {
	//Abort early if the user will never see TinyMCE
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
	   return;
	//Add a callback to regiser our tinymce plugin   
	add_filter("mce_external_plugins", "waq_register_tinymce_plugin"); 
	// Add a callback to add our button to the TinyMCE toolbar
	add_filter('mce_buttons', 'waq_add_tinymce_button');
}

//This callback registers our plug-in
function waq_register_tinymce_plugin($plugin_array) {
    $plugin_array['waq_button'] = WAQ_PATH . 'js/button.js';
    return $plugin_array;
}

//This callback adds our button to the toolbar
function waq_add_tinymce_button($buttons) {
    //Add the button ID to the $button array
    $buttons[] = "waq_button";
    return $buttons;
}

function waq_font_awesome_option($default=''){
	$icons = array(
		'fa-adjust' => '&#xf042;',
		'fa-adn' => '&#xf170;',
		'fa-align-center' => '&#xf037;',
		'fa-align-justify' => '&#xf039;',
		'fa-align-left' => '&#xf036;',
		'fa-align-right' => '&#xf038;',
		'fa-ambulance' => '&#xf0f9;',
		'fa-anchor' => '&#xf13d;',
		'fa-android' => '&#xf17b;',
		'fa-angellist' => '&#xf209;',
		'fa-angle-double-down' => '&#xf103;',
		'fa-angle-double-left' => '&#xf100;',
		'fa-angle-double-right' => '&#xf101;',
		'fa-angle-double-up' => '&#xf102;',
		'fa-angle-down' => '&#xf107;',
		'fa-angle-left' => '&#xf104;',
		'fa-angle-right' => '&#xf105;',
		'fa-angle-up' => '&#xf106;',
		'fa-apple' => '&#xf179;',
		'fa-archive' => '&#xf187;',
		'fa-area-chart' => '&#xf1fe;',
		'fa-arrow-circle-down' => '&#xf0ab;',
		'fa-arrow-circle-left' => '&#xf0a8;',
		'fa-arrow-circle-o-down' => '&#xf01a;',
		'fa-arrow-circle-o-left' => '&#xf190;',
		'fa-arrow-circle-o-right' => '&#xf18e;',
		'fa-arrow-circle-o-up' => '&#xf01b;',
		'fa-arrow-circle-right' => '&#xf0a9;',
		'fa-arrow-circle-up' => '&#xf0aa;',
		'fa-arrow-down' => '&#xf063;',
		'fa-arrow-left' => '&#xf060;',
		'fa-arrow-right' => '&#xf061;',
		'fa-arrow-up' => '&#xf062;',
		'fa-arrows' => '&#xf047;',
		'fa-arrows-alt' => '&#xf0b2;',
		'fa-arrows-h' => '&#xf07e;',
		'fa-arrows-v' => '&#xf07d;',
		'fa-asterisk' => '&#xf069;',
		'fa-at' => '&#xf1fa;',
		'fa-automobile (alias)' => '&#xf1b9;',
		'fa-backward' => '&#xf04a;',
		'fa-ban' => '&#xf05e;',
		'fa-bank (alias)' => '&#xf19c;',
		'fa-bar-chart' => '&#xf080;',
		'fa-bar-chart-o (alias)' => '&#xf080;',
		'fa-barcode' => '&#xf02a;',
		'fa-bars' => '&#xf0c9;',
		'fa-beer' => '&#xf0fc;',
		'fa-behance' => '&#xf1b4;',
		'fa-behance-square' => '&#xf1b5;',
		'fa-bell' => '&#xf0f3;',
		'fa-bell-o' => '&#xf0a2;',
		'fa-bell-slash' => '&#xf1f6;',
		'fa-bell-slash-o' => '&#xf1f7;',
		'fa-bicycle' => '&#xf206;',
		'fa-binoculars' => '&#xf1e5;',
		'fa-birthday-cake' => '&#xf1fd;',
		'fa-bitbucket' => '&#xf171;',
		'fa-bitbucket-square' => '&#xf172;',
		'fa-bitcoin (alias)' => '&#xf15a;',
		'fa-bold' => '&#xf032;',
		'fa-bolt' => '&#xf0e7;',
		'fa-bomb' => '&#xf1e2;',
		'fa-book' => '&#xf02d;',
		'fa-bookmark' => '&#xf02e;',
		'fa-bookmark-o' => '&#xf097;',
		'fa-briefcase' => '&#xf0b1;',
		'fa-btc' => '&#xf15a;',
		'fa-bug' => '&#xf188;',
		'fa-building' => '&#xf1ad;',
		'fa-building-o' => '&#xf0f7;',
		'fa-bullhorn' => '&#xf0a1;',
		'fa-bullseye' => '&#xf140;',
		'fa-bus' => '&#xf207;',
		'fa-cab (alias)' => '&#xf1ba;',
		'fa-calculator' => '&#xf1ec;',
		'fa-calendar' => '&#xf073;',
		'fa-calendar-o' => '&#xf133;',
		'fa-camera' => '&#xf030;',
		'fa-camera-retro' => '&#xf083;',
		'fa-car' => '&#xf1b9;',
		'fa-caret-down' => '&#xf0d7;',
		'fa-caret-left' => '&#xf0d9;',
		'fa-caret-right' => '&#xf0da;',
		'fa-caret-square-o-down' => '&#xf150;',
		'fa-caret-square-o-left' => '&#xf191;',
		'fa-caret-square-o-right' => '&#xf152;',
		'fa-caret-square-o-up' => '&#xf151;',
		'fa-caret-up' => '&#xf0d8;',
		'fa-cc' => '&#xf20a;',
		'fa-cc-amex' => '&#xf1f3;',
		'fa-cc-discover' => '&#xf1f2;',
		'fa-cc-mastercard' => '&#xf1f1;',
		'fa-cc-paypal' => '&#xf1f4;',
		'fa-cc-stripe' => '&#xf1f5;',
		'fa-cc-visa' => '&#xf1f0;',
		'fa-certificate' => '&#xf0a3;',
		'fa-chain (alias)' => '&#xf0c1;',
		'fa-chain-broken' => '&#xf127;',
		'fa-check' => '&#xf00c;',
		'fa-check-circle' => '&#xf058;',
		'fa-check-circle-o' => '&#xf05d;',
		'fa-check-square' => '&#xf14a;',
		'fa-check-square-o' => '&#xf046;',
		'fa-chevron-circle-down' => '&#xf13a;',
		'fa-chevron-circle-left' => '&#xf137;',
		'fa-chevron-circle-right' => '&#xf138;',
		'fa-chevron-circle-up' => '&#xf139;',
		'fa-chevron-down' => '&#xf078;',
		'fa-chevron-left' => '&#xf053;',
		'fa-chevron-right' => '&#xf054;',
		'fa-chevron-up' => '&#xf077;',
		'fa-child' => '&#xf1ae;',
		'fa-circle' => '&#xf111;',
		'fa-circle-o' => '&#xf10c;',
		'fa-circle-o-notch' => '&#xf1ce;',
		'fa-circle-thin' => '&#xf1db;',
		'fa-clipboard' => '&#xf0ea;',
		'fa-clock-o' => '&#xf017;',
		'fa-close (alias)' => '&#xf00d;',
		'fa-cloud' => '&#xf0c2;',
		'fa-cloud-download' => '&#xf0ed;',
		'fa-cloud-upload' => '&#xf0ee;',
		'fa-cny (alias)' => '&#xf157;',
		'fa-code' => '&#xf121;',
		'fa-code-fork' => '&#xf126;',
		'fa-codepen' => '&#xf1cb;',
		'fa-coffee' => '&#xf0f4;',
		'fa-cog' => '&#xf013;',
		'fa-cogs' => '&#xf085;',
		'fa-columns' => '&#xf0db;',
		'fa-comment' => '&#xf075;',
		'fa-comment-o' => '&#xf0e5;',
		'fa-comments' => '&#xf086;',
		'fa-comments-o' => '&#xf0e6;',
		'fa-compass' => '&#xf14e;',
		'fa-compress' => '&#xf066;',
		'fa-copy (alias)' => '&#xf0c5;',
		'fa-copyright' => '&#xf1f9;',
		'fa-credit-card' => '&#xf09d;',
		'fa-crop' => '&#xf125;',
		'fa-crosshairs' => '&#xf05b;',
		'fa-css3' => '&#xf13c;',
		'fa-cube' => '&#xf1b2;',
		'fa-cubes' => '&#xf1b3;',
		'fa-cut (alias)' => '&#xf0c4;',
		'fa-cutlery' => '&#xf0f5;',
		'fa-dashboard (alias)' => '&#xf0e4;',
		'fa-database' => '&#xf1c0;',
		'fa-dedent (alias)' => '&#xf03b;',
		'fa-delicious' => '&#xf1a5;',
		'fa-desktop' => '&#xf108;',
		'fa-deviantart' => '&#xf1bd;',
		'fa-digg' => '&#xf1a6;',
		'fa-dollar (alias)' => '&#xf155;',
		'fa-dot-circle-o' => '&#xf192;',
		'fa-download' => '&#xf019;',
		'fa-dribbble' => '&#xf17d;',
		'fa-dropbox' => '&#xf16b;',
		'fa-drupal' => '&#xf1a9;',
		'fa-edit (alias)' => '&#xf044;',
		'fa-eject' => '&#xf052;',
		'fa-ellipsis-h' => '&#xf141;',
		'fa-ellipsis-v' => '&#xf142;',
		'fa-empire' => '&#xf1d1;',
		'fa-envelope' => '&#xf0e0;',
		'fa-envelope-o' => '&#xf003;',
		'fa-envelope-square' => '&#xf199;',
		'fa-eraser' => '&#xf12d;',
		'fa-eur' => '&#xf153;',
		'fa-euro (alias)' => '&#xf153;',
		'fa-exchange' => '&#xf0ec;',
		'fa-exclamation' => '&#xf12a;',
		'fa-exclamation-circle' => '&#xf06a;',
		'fa-exclamation-triangle' => '&#xf071;',
		'fa-expand' => '&#xf065;',
		'fa-external-link' => '&#xf08e;',
		'fa-external-link-square' => '&#xf14c;',
		'fa-eye' => '&#xf06e;',
		'fa-eye-slash' => '&#xf070;',
		'fa-eyedropper' => '&#xf1fb;',
		'fa-facebook' => '&#xf09a;',
		'fa-facebook-square' => '&#xf082;',
		'fa-fast-backward' => '&#xf049;',
		'fa-fast-forward' => '&#xf050;',
		'fa-fax' => '&#xf1ac;',
		'fa-female' => '&#xf182;',
		'fa-fighter-jet' => '&#xf0fb;',
		'fa-file' => '&#xf15b;',
		'fa-file-archive-o' => '&#xf1c6;',
		'fa-file-audio-o' => '&#xf1c7;',
		'fa-file-code-o' => '&#xf1c9;',
		'fa-file-excel-o' => '&#xf1c3;',
		'fa-file-image-o' => '&#xf1c5;',
		'fa-file-movie-o (alias)' => '&#xf1c8;',
		'fa-file-o' => '&#xf016;',
		'fa-file-pdf-o' => '&#xf1c1;',
		'fa-file-photo-o (alias)' => '&#xf1c5;',
		'fa-file-picture-o (alias)' => '&#xf1c5;',
		'fa-file-powerpoint-o' => '&#xf1c4;',
		'fa-file-sound-o (alias)' => '&#xf1c7;',
		'fa-file-text' => '&#xf15c;',
		'fa-file-text-o' => '&#xf0f6;',
		'fa-file-video-o' => '&#xf1c8;',
		'fa-file-word-o' => '&#xf1c2;',
		'fa-file-zip-o (alias)' => '&#xf1c6;',
		'fa-files-o' => '&#xf0c5;',
		'fa-film' => '&#xf008;',
		'fa-filter' => '&#xf0b0;',
		'fa-fire' => '&#xf06d;',
		'fa-fire-extinguisher' => '&#xf134;',
		'fa-flag' => '&#xf024;',
		'fa-flag-checkered' => '&#xf11e;',
		'fa-flag-o' => '&#xf11d;',
		'fa-flash (alias)' => '&#xf0e7;',
		'fa-flask' => '&#xf0c3;',
		'fa-flickr' => '&#xf16e;',
		'fa-floppy-o' => '&#xf0c7;',
		'fa-folder' => '&#xf07b;',
		'fa-folder-o' => '&#xf114;',
		'fa-folder-open' => '&#xf07c;',
		'fa-folder-open-o' => '&#xf115;',
		'fa-font' => '&#xf031;',
		'fa-forward' => '&#xf04e;',
		'fa-foursquare' => '&#xf180;',
		'fa-frown-o' => '&#xf119;',
		'fa-futbol-o' => '&#xf1e3;',
		'fa-gamepad' => '&#xf11b;',
		'fa-gavel' => '&#xf0e3;',
		'fa-gbp' => '&#xf154;',
		'fa-ge (alias)' => '&#xf1d1;',
		'fa-gear (alias)' => '&#xf013;',
		'fa-gears (alias)' => '&#xf085;',
		'fa-gift' => '&#xf06b;',
		'fa-git' => '&#xf1d3;',
		'fa-git-square' => '&#xf1d2;',
		'fa-github' => '&#xf09b;',
		'fa-github-alt' => '&#xf113;',
		'fa-github-square' => '&#xf092;',
		'fa-gittip' => '&#xf184;',
		'fa-glass' => '&#xf000;',
		'fa-globe' => '&#xf0ac;',
		'fa-google' => '&#xf1a0;',
		'fa-google-plus' => '&#xf0d5;',
		'fa-google-plus-square' => '&#xf0d4;',
		'fa-google-wallet' => '&#xf1ee;',
		'fa-graduation-cap' => '&#xf19d;',
		'fa-group (alias)' => '&#xf0c0;',
		'fa-h-square' => '&#xf0fd;',
		'fa-hacker-news' => '&#xf1d4;',
		'fa-hand-o-down' => '&#xf0a7;',
		'fa-hand-o-left' => '&#xf0a5;',
		'fa-hand-o-right' => '&#xf0a4;',
		'fa-hand-o-up' => '&#xf0a6;',
		'fa-hdd-o' => '&#xf0a0;',
		'fa-header' => '&#xf1dc;',
		'fa-headphones' => '&#xf025;',
		'fa-heart' => '&#xf004;',
		'fa-heart-o' => '&#xf08a;',
		'fa-history' => '&#xf1da;',
		'fa-home' => '&#xf015;',
		'fa-hospital-o' => '&#xf0f8;',
		'fa-html5' => '&#xf13b;',
		'fa-ils' => '&#xf20b;',
		'fa-image (alias)' => '&#xf03e;',
		'fa-inbox' => '&#xf01c;',
		'fa-indent' => '&#xf03c;',
		'fa-info' => '&#xf129;',
		'fa-info-circle' => '&#xf05a;',
		'fa-inr' => '&#xf156;',
		'fa-instagram' => '&#xf16d;',
		'fa-institution (alias)' => '&#xf19c;',
		'fa-ioxhost' => '&#xf208;',
		'fa-italic' => '&#xf033;',
		'fa-joomla' => '&#xf1aa;',
		'fa-jpy' => '&#xf157;',
		'fa-jsfiddle' => '&#xf1cc;',
		'fa-key' => '&#xf084;',
		'fa-keyboard-o' => '&#xf11c;',
		'fa-krw' => '&#xf159;',
		'fa-language' => '&#xf1ab;',
		'fa-laptop' => '&#xf109;',
		'fa-lastfm' => '&#xf202;',
		'fa-lastfm-square' => '&#xf203;',
		'fa-leaf' => '&#xf06c;',
		'fa-legal (alias)' => '&#xf0e3;',
		'fa-lemon-o' => '&#xf094;',
		'fa-level-down' => '&#xf149;',
		'fa-level-up' => '&#xf148;',
		'fa-life-bouy (alias)' => '&#xf1cd;',
		'fa-life-buoy (alias)' => '&#xf1cd;',
		'fa-life-ring' => '&#xf1cd;',
		'fa-life-saver (alias)' => '&#xf1cd;',
		'fa-lightbulb-o' => '&#xf0eb;',
		'fa-line-chart' => '&#xf201;',
		'fa-link' => '&#xf0c1;',
		'fa-linkedin' => '&#xf0e1;',
		'fa-linkedin-square' => '&#xf08c;',
		'fa-linux' => '&#xf17c;',
		'fa-list' => '&#xf03a;',
		'fa-list-alt' => '&#xf022;',
		'fa-list-ol' => '&#xf0cb;',
		'fa-list-ul' => '&#xf0ca;',
		'fa-location-arrow' => '&#xf124;',
		'fa-lock' => '&#xf023;',
		'fa-long-arrow-down' => '&#xf175;',
		'fa-long-arrow-left' => '&#xf177;',
		'fa-long-arrow-right' => '&#xf178;',
		'fa-long-arrow-up' => '&#xf176;',
		'fa-magic' => '&#xf0d0;',
		'fa-magnet' => '&#xf076;',
		'fa-mail-forward (alias)' => '&#xf064;',
		'fa-mail-reply (alias)' => '&#xf112;',
		'fa-mail-reply-all (alias)' => '&#xf122;',
		'fa-male' => '&#xf183;',
		'fa-map-marker' => '&#xf041;',
		'fa-maxcdn' => '&#xf136;',
		'fa-meanpath' => '&#xf20c;',
		'fa-medkit' => '&#xf0fa;',
		'fa-meh-o' => '&#xf11a;',
		'fa-microphone' => '&#xf130;',
		'fa-microphone-slash' => '&#xf131;',
		'fa-minus' => '&#xf068;',
		'fa-minus-circle' => '&#xf056;',
		'fa-minus-square' => '&#xf146;',
		'fa-minus-square-o' => '&#xf147;',
		'fa-mobile' => '&#xf10b;',
		'fa-mobile-phone (alias)' => '&#xf10b;',
		'fa-money' => '&#xf0d6;',
		'fa-moon-o' => '&#xf186;',
		'fa-mortar-board (alias)' => '&#xf19d;',
		'fa-music' => '&#xf001;',
		'fa-navicon (alias)' => '&#xf0c9;',
		'fa-newspaper-o' => '&#xf1ea;',
		'fa-openid' => '&#xf19b;',
		'fa-outdent' => '&#xf03b;',
		'fa-pagelines' => '&#xf18c;',
		'fa-paint-brush' => '&#xf1fc;',
		'fa-paper-plane' => '&#xf1d8;',
		'fa-paper-plane-o' => '&#xf1d9;',
		'fa-paperclip' => '&#xf0c6;',
		'fa-paragraph' => '&#xf1dd;',
		'fa-paste (alias)' => '&#xf0ea;',
		'fa-pause' => '&#xf04c;',
		'fa-paw' => '&#xf1b0;',
		'fa-paypal' => '&#xf1ed;',
		'fa-pencil' => '&#xf040;',
		'fa-pencil-square' => '&#xf14b;',
		'fa-pencil-square-o' => '&#xf044;',
		'fa-phone' => '&#xf095;',
		'fa-phone-square' => '&#xf098;',
		'fa-photo (alias)' => '&#xf03e;',
		'fa-picture-o' => '&#xf03e;',
		'fa-pie-chart' => '&#xf200;',
		'fa-pied-piper' => '&#xf1a7;',
		'fa-pied-piper-alt' => '&#xf1a8;',
		'fa-pinterest' => '&#xf0d2;',
		'fa-pinterest-square' => '&#xf0d3;',
		'fa-plane' => '&#xf072;',
		'fa-play' => '&#xf04b;',
		'fa-play-circle' => '&#xf144;',
		'fa-play-circle-o' => '&#xf01d;',
		'fa-plug' => '&#xf1e6;',
		'fa-plus' => '&#xf067;',
		'fa-plus-circle' => '&#xf055;',
		'fa-plus-square' => '&#xf0fe;',
		'fa-plus-square-o' => '&#xf196;',
		'fa-power-off' => '&#xf011;',
		'fa-print' => '&#xf02f;',
		'fa-puzzle-piece' => '&#xf12e;',
		'fa-qq' => '&#xf1d6;',
		'fa-qrcode' => '&#xf029;',
		'fa-question' => '&#xf128;',
		'fa-question-circle' => '&#xf059;',
		'fa-quote-left' => '&#xf10d;',
		'fa-quote-right' => '&#xf10e;',
		'fa-ra (alias)' => '&#xf1d0;',
		'fa-random' => '&#xf074;',
		'fa-rebel' => '&#xf1d0;',
		'fa-recycle' => '&#xf1b8;',
		'fa-reddit' => '&#xf1a1;',
		'fa-reddit-square' => '&#xf1a2;',
		'fa-refresh' => '&#xf021;',
		'fa-remove (alias)' => '&#xf00d;',
		'fa-renren' => '&#xf18b;',
		'fa-reorder (alias)' => '&#xf0c9;',
		'fa-repeat' => '&#xf01e;',
		'fa-reply' => '&#xf112;',
		'fa-reply-all' => '&#xf122;',
		'fa-retweet' => '&#xf079;',
		'fa-rmb (alias)' => '&#xf157;',
		'fa-road' => '&#xf018;',
		'fa-rocket' => '&#xf135;',
		'fa-rotate-left (alias)' => '&#xf0e2;',
		'fa-rotate-right (alias)' => '&#xf01e;',
		'fa-rouble (alias)' => '&#xf158;',
		'fa-rss' => '&#xf09e;',
		'fa-rss-square' => '&#xf143;',
		'fa-rub' => '&#xf158;',
		'fa-ruble (alias)' => '&#xf158;',
		'fa-rupee (alias)' => '&#xf156;',
		'fa-save (alias)' => '&#xf0c7;',
		'fa-scissors' => '&#xf0c4;',
		'fa-search' => '&#xf002;',
		'fa-search-minus' => '&#xf010;',
		'fa-search-plus' => '&#xf00e;',
		'fa-send (alias)' => '&#xf1d8;',
		'fa-send-o (alias)' => '&#xf1d9;',
		'fa-share' => '&#xf064;',
		'fa-share-alt' => '&#xf1e0;',
		'fa-share-alt-square' => '&#xf1e1;',
		'fa-share-square' => '&#xf14d;',
		'fa-share-square-o' => '&#xf045;',
		'fa-shekel (alias)' => '&#xf20b;',
		'fa-sheqel (alias)' => '&#xf20b;',
		'fa-shield' => '&#xf132;',
		'fa-shopping-cart' => '&#xf07a;',
		'fa-sign-in' => '&#xf090;',
		'fa-sign-out' => '&#xf08b;',
		'fa-signal' => '&#xf012;',
		'fa-sitemap' => '&#xf0e8;',
		'fa-skype' => '&#xf17e;',
		'fa-slack' => '&#xf198;',
		'fa-sliders' => '&#xf1de;',
		'fa-slideshare' => '&#xf1e7;',
		'fa-smile-o' => '&#xf118;',
		'fa-soccer-ball-o (alias)' => '&#xf1e3;',
		'fa-sort' => '&#xf0dc;',
		'fa-sort-alpha-asc' => '&#xf15d;',
		'fa-sort-alpha-desc' => '&#xf15e;',
		'fa-sort-amount-asc' => '&#xf160;',
		'fa-sort-amount-desc' => '&#xf161;',
		'fa-sort-asc' => '&#xf0de;',
		'fa-sort-desc' => '&#xf0dd;',
		'fa-sort-down (alias)' => '&#xf0dd;',
		'fa-sort-numeric-asc' => '&#xf162;',
		'fa-sort-numeric-desc' => '&#xf163;',
		'fa-sort-up (alias)' => '&#xf0de;',
		'fa-soundcloud' => '&#xf1be;',
		'fa-space-shuttle' => '&#xf197;',
		'fa-spinner' => '&#xf110;',
		'fa-spoon' => '&#xf1b1;',
		'fa-spotify' => '&#xf1bc;',
		'fa-square' => '&#xf0c8;',
		'fa-square-o' => '&#xf096;',
		'fa-stack-exchange' => '&#xf18d;',
		'fa-stack-overflow' => '&#xf16c;',
		'fa-star' => '&#xf005;',
		'fa-star-half' => '&#xf089;',
		'fa-star-half-empty (alias)' => '&#xf123;',
		'fa-star-half-full (alias)' => '&#xf123;',
		'fa-star-half-o' => '&#xf123;',
		'fa-star-o' => '&#xf006;',
		'fa-steam' => '&#xf1b6;',
		'fa-steam-square' => '&#xf1b7;',
		'fa-step-backward' => '&#xf048;',
		'fa-step-forward' => '&#xf051;',
		'fa-stethoscope' => '&#xf0f1;',
		'fa-stop' => '&#xf04d;',
		'fa-strikethrough' => '&#xf0cc;',
		'fa-stumbleupon' => '&#xf1a4;',
		'fa-stumbleupon-circle' => '&#xf1a3;',
		'fa-subscript' => '&#xf12c;',
		'fa-suitcase' => '&#xf0f2;',
		'fa-sun-o' => '&#xf185;',
		'fa-superscript' => '&#xf12b;',
		'fa-support (alias)' => '&#xf1cd;',
		'fa-table' => '&#xf0ce;',
		'fa-tablet' => '&#xf10a;',
		'fa-tachometer' => '&#xf0e4;',
		'fa-tag' => '&#xf02b;',
		'fa-tags' => '&#xf02c;',
		'fa-tasks' => '&#xf0ae;',
		'fa-taxi' => '&#xf1ba;',
		'fa-tencent-weibo' => '&#xf1d5;',
		'fa-terminal' => '&#xf120;',
		'fa-text-height' => '&#xf034;',
		'fa-text-width' => '&#xf035;',
		'fa-th' => '&#xf00a;',
		'fa-th-large' => '&#xf009;',
		'fa-th-list' => '&#xf00b;',
		'fa-thumb-tack' => '&#xf08d;',
		'fa-thumbs-down' => '&#xf165;',
		'fa-thumbs-o-down' => '&#xf088;',
		'fa-thumbs-o-up' => '&#xf087;',
		'fa-thumbs-up' => '&#xf164;',
		'fa-ticket' => '&#xf145;',
		'fa-times' => '&#xf00d;',
		'fa-times-circle' => '&#xf057;',
		'fa-times-circle-o' => '&#xf05c;',
		'fa-tint' => '&#xf043;',
		'fa-toggle-down (alias)' => '&#xf150;',
		'fa-toggle-left (alias)' => '&#xf191;',
		'fa-toggle-off' => '&#xf204;',
		'fa-toggle-on' => '&#xf205;',
		'fa-toggle-right (alias)' => '&#xf152;',
		'fa-toggle-up (alias)' => '&#xf151;',
		'fa-trash' => '&#xf1f8;',
		'fa-trash-o' => '&#xf014;',
		'fa-tree' => '&#xf1bb;',
		'fa-trello' => '&#xf181;',
		'fa-trophy' => '&#xf091;',
		'fa-truck' => '&#xf0d1;',
		'fa-try' => '&#xf195;',
		'fa-tty' => '&#xf1e4;',
		'fa-tumblr' => '&#xf173;',
		'fa-tumblr-square' => '&#xf174;',
		'fa-turkish-lira (alias)' => '&#xf195;',
		'fa-twitch' => '&#xf1e8;',
		'fa-twitter' => '&#xf099;',
		'fa-twitter-square' => '&#xf081;',
		'fa-umbrella' => '&#xf0e9;',
		'fa-underline' => '&#xf0cd;',
		'fa-undo' => '&#xf0e2;',
		'fa-university' => '&#xf19c;',
		'fa-unlink (alias)' => '&#xf127;',
		'fa-unlock' => '&#xf09c;',
		'fa-unlock-alt' => '&#xf13e;',
		'fa-unsorted (alias)' => '&#xf0dc;',
		'fa-upload' => '&#xf093;',
		'fa-usd' => '&#xf155;',
		'fa-user' => '&#xf007;',
		'fa-user-md' => '&#xf0f0;',
		'fa-users' => '&#xf0c0;',
		'fa-video-camera' => '&#xf03d;',
		'fa-vimeo-square' => '&#xf194;',
		'fa-vine' => '&#xf1ca;',
		'fa-vk' => '&#xf189;',
		'fa-volume-down' => '&#xf027;',
		'fa-volume-off' => '&#xf026;',
		'fa-volume-up' => '&#xf028;',
		'fa-warning (alias)' => '&#xf071;',
		'fa-wechat (alias)' => '&#xf1d7;',
		'fa-weibo' => '&#xf18a;',
		'fa-weixin' => '&#xf1d7;',
		'fa-wheelchair' => '&#xf193;',
		'fa-wifi' => '&#xf1eb;',
		'fa-windows' => '&#xf17a;',
		'fa-won (alias)' => '&#xf159;',
		'fa-wordpress' => '&#xf19a;',
		'fa-wrench' => '&#xf0ad;',
		'fa-xing' => '&#xf168;',
		'fa-xing-square' => '&#xf169;',
		'fa-yahoo' => '&#xf19e;',
		'fa-yelp' => '&#xf1e9;',
		'fa-yen (alias)' => '&#xf157;',
		'fa-youtube' => '&#xf167;',
		'fa-youtube-play' => '&#xf16a;',
		'fa-youtube-square' => '&#xf166;',
	);
	ksort($icons);
	foreach($icons as $name=>$icon){
		$selected = $default==$name?'selected="selected"':'';
		echo '<option value="'.$name.'" '.$selected.' >'.$icon.' '.$name.'</option>';
	}
}