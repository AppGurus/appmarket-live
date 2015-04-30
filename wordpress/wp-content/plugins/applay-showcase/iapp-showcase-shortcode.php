<?php
function parse_ias_showcase($atts, $content=''){
	$class = isset($atts['class']) ? $atts['class'] : rand(10,9999);
	$showcase = isset($atts['showcase']) ? $atts['showcase'] : 0;
	//display
	ob_start();
	$showcase_query = new WP_Query( 'post_type=iapp_showcase&posts_per_page=1&p='.$showcase );
	if ( $showcase_query->have_posts() ) {
		while ( $showcase_query->have_posts() ) {
			$showcase_query->the_post(); ?>
            <div class="iapp-showcase-shortcode iapp-showcase-shortcode-<?php echo $class; ?>">
				<?php require('views/single.php'); ?>
            </div><!--/iapp-showcase-shortcode-->
            <?php
		}
	}
	wp_reset_postdata();
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'ias_showcase', 'parse_ias_showcase' );

add_action( 'after_setup_theme', 'reg_ias_showcase' );
function reg_ias_showcase(){
	if(function_exists('wpb_map')){
	$showcase_array = array(
		__('Choose a Showcase','leafcolor') => 0
	);
	$showcase_query = new WP_Query( 'post_type=iapp_showcase&posts_per_page=-1' );
	if ( $showcase_query->have_posts() ) {
		while ( $showcase_query->have_posts() ) {
			$showcase_query->the_post();
			$showcase_array[get_the_title()] = get_the_ID();
		}
	}
	wp_reset_postdata();
	wpb_map( array(
	   "name" => __("Showcase"),
	   "base" => "ias_showcase",
	   "class" => "",
	   "icon" => "icon-showcase",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Showcase", "leafcolor"),
			 "param_name" => "showcase",
			 "value" => $showcase_array,
			 "description" => __('Choose a showcase','leafcolor')
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("CSS class", "leafcolor"),
			"param_name" => "class",
			"value" => "",
			"description" => __("", "leafcolor"),
		  ),
	   )
	));
	}
}