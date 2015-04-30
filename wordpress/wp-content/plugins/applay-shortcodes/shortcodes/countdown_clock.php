<?php
function parse_ia_countdown($atts, $content){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$year 		= isset($atts['year']) ? $atts['year'] : 2014;
	$month 		= isset($atts['month']) ? $atts['month'] : 1;
	$day 		= isset($atts['day']) ? $atts['day'] : 1;
	$hour 		= isset($atts['hour']) ? $atts['hour'] : 0;
	$minute		= isset($atts['minute']) ? $atts['minute'] : 0;
	$show_second= isset($atts['show_second']) ? $atts['show_second'] : 1;
	$bg_color	= isset($atts['bg_color']) ? $atts['bg_color'] : '';
	$num_color	= isset($atts['num_color']) ? $atts['num_color'] : '';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	wp_enqueue_script( 'final-countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array('jquery'), '', true );
	ob_start(); ?>
    <div class="ia_countdown ia_countdown-<?php echo $ID; echo ' '.$animation_class; ?>" data-countdown="<?php echo $year.'/'.$month.'/'.$day.' '.$hour.':'.$minute.':00' ?>" data-daylabel='<?php _e('Days','leafcolor') ?>' data-hourlabel='<?php _e('Hrs','leafcolor') ?>' data-minutelabel='<?php _e('Mins','leafcolor') ?>' data-secondlabel='<?php _e('Secs','leafcolor') ?>' data-showsecond='<?php echo $show_second ?>' data-delay=<?php echo $animation_delay; ?>></div>
    <?php if(($bg_color&&$bg_color!='#') || $num_color){ ?>
    <style scoped="scoped">
		<?php if($bg_color&&$bg_color!='#'){?>
		.ia_countdown-<?php echo $ID; ?> .countdown-number{
			background-color:<?php echo $bg_color ?>
		}
		.ia_countdown-<?php echo $ID; ?> .countdown-label{
			color:<?php echo $bg_color ?>
		}
		<?php }
		if($num_color){ ?>
		.ia_countdown-<?php echo $ID; ?> .countdown-number{
			color:<?php echo $num_color ?>
		}
		<?php }?>
	</style>
	<?php
	}
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'ia_countdown', 'parse_ia_countdown' );



/* Register shortcode with Visual Composer */

add_action( 'after_setup_theme', 'reg_ia_countdown' );
function reg_ia_countdown(){
	if(function_exists('wpb_map')){
	$current_year = date("Y");
	$years = array();
	for($i=0; $i<15; $i++){
		$years[$current_year+$i] = ($current_year+$i);
	}
	$months = array();
	for($i=1; $i<=12; $i++){
		$months[date("F", mktime(0, 0, 0, $i, 10))] = $i;
	}
	$days = array();
	for($i=1; $i<=31; $i++){
		$days[$i] = $i;
	}
	$hours = array();
	for($i=0; $i<=23; $i++){
		$hours[$i] = $i;
	}
	$minutes = array();
	for($i=0; $i<=59; $i++){
		$minutes[$i] = $i;
	}
	wpb_map( array(
	   "name" => __("Countdown"),
	   "base" => "ia_countdown",
	   "class" => "",
	   "icon" => "icon-countdown",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
	   	  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Year:", 'leafcolor'),
			 "param_name" => "year",
			 "value" => $years,
			 "description" => ''
		  ),	  
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Month", 'leafcolor'),
			 "param_name" => "month",
			 "value" => $months,
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Day", 'leafcolor'),
			 "param_name" => "day",
			 "value" => $days,
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Hour", 'leafcolor'),
			 "param_name" => "hour",
			 "value" => $hours,
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Minute", 'leafcolor'),
			 "param_name" => "minute",
			 "value" => $minutes,
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Show Second?", "leafcolor"),
			 "param_name" => "show_second",
			 "value" => array(
			 	__('Yes', 'leafcolor') => '1',
				__('No', 'leafcolor') => '0',
			 ),
			 "description" => __('Choose post type','leafcolor')
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Background Color", 'leafcolor'),
			 "param_name" => "bg_color",
			 "value" => '',
			 "description" => ''
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Number Color", 'leafcolor'),
			 "param_name" => "num_color",
			 "value" => '',
			 "description" => ''
		  ),
	   )
	));
	}
}