<?php
function parse_button($atts, $content=''){
	$ID = isset($atts['id']) ? $atts['id'] : '';
	$size = isset($atts['size']) ? $atts['size'] : '';
	$solid = isset($atts['solid']) ? $atts['solid'] : '';
	$link = isset($atts['link']) ? $atts['link'] : '#';

	$arrow = isset($atts['arrow']) ? $atts['arrow'] : (isset($atts['has_arrow']) ? $atts['has_arrow'] : 0);
	$icon = isset($atts['icon']) ? $atts['icon'] : '';
	$color = isset($atts['color']) ? $atts['color'] : '';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start(); 
		$style_bt ='';
		if($color && $color!='#'){
			$style_bt ='border-color:'.$color.';';
			if($solid){$style_bt .='background-color:'.$color.';'; }
			else{$style_bt .='color:'.$color.';';}
		}
		?>
    	<a class="btn<?php echo $ID?' button-'.$ID:''; echo $solid?' btn-primary':' btn-default'; echo $size=='big'?' btn-lg':''; echo ' '.$animation_class;  ?>" href="<?php echo $link ?>" <?php if($animation_delay){?> data-delay=<?php echo $animation_delay; ?> <?php }?> <?php if($style_bt){echo 'style="'.$style_bt.'"';}?>>
        <?php
			echo $icon?'<i class="fa '.$icon.'"></i>'.($content?'&nbsp;&nbsp;':''):'';
			echo $content;
			echo $arrow?'&nbsp;&nbsp;<i class="fa fa-angle-right"></i>':'';
		?>
        </a>
        <?php
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'ia_button', 'parse_button' );

add_action( 'after_setup_theme', 'reg_ia_button' );
function reg_ia_button(){
	if(function_exists('wpb_map')){
	wpb_map( array(
	   "name" => __("Applay Button",'leafcolor'),
	   "base" => "ia_button",
	   "class" => "",
	   "icon" => "icon-button",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
	   	  array(
			"type" => "textfield",
			"heading" => __("Button Text", "leafcolor"),
			"param_name" => "content",
			"value" => "",
			"description" => "",
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Button Link", "leafcolor"),
			"param_name" => "link",
			"value" => "",
			"description" => "",
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Icon", "leafcolor"),
			"param_name" => "icon",
			"value" => "",
			"description" => __("Font Awesome Icon (ex: fa-apple)", "leafcolor"),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Button Size", "leafcolor"),
			 "param_name" => "size",
			 "value" => array(
			 	__('Small', 'leafcolor') => 'small',
				__('Big', 'leafcolor') => 'big',
			 ),
			 "description" => "",
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Solid Background", 'leafcolor'),
			 "param_name" => "solid",
			 "value" => array(
			 	__('No', 'leafcolor') => 0,
				__('Yes', 'leafcolor') => 1,
			 ),
			 "description" => '',
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Has arrow?", 'leafcolor'),
			 "param_name" => "has_arrow",
			 "value" => array(
			 	__('Yes', 'leafcolor') => 1,
				__('No', 'leafcolor') => 0,
			 ),
			 "description" => "",
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Button Color", 'leafcolor'),
			 "param_name" => "color",
			 "value" => '',
			 "description" => '',
		  )
	   )
	));
	}
}