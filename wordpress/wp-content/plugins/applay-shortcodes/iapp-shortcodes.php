<?php
   /*
   Plugin Name: Applay - Shortcodes
   Plugin URI: http://www.leafcolor.com
   Description: Applay - Shortcodes
   Version: 1.0
   Author: Leafcolor
   Author URI: http://www.leafcolor.com
   License: GPL2
   */
if ( ! defined( 'IA_SHORTCODE_BASE_FILE' ) )
    define( 'IA_SHORTCODE_BASE_FILE', __FILE__ );
if ( ! defined( 'IA_SHORTCODE_BASE_DIR' ) )
    define( 'IA_SHORTCODE_BASE_DIR', dirname( IA_SHORTCODE_BASE_FILE ) );
if ( ! defined( 'IA_SHORTCODE_PLUGIN_URL' ) )
    define( 'IA_SHORTCODE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* ================================================================
 *
 * 
 * Class to register shortcode with TinyMCE editor
 *
 * Add to button to tinyMCE editor
 *
 */
class LeafColorShortcodes{
	
	function __construct()
	{
		add_action('init',array(&$this, 'init'));
	}
	
	function init(){		
		if(is_admin()){
			// CSS for button styling
			wp_enqueue_style("ia_shortcode_admin_style", IA_SHORTCODE_PLUGIN_URL . '/shortcodes/shortcodes.css');
		}

		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
	    	return;
		}
	 
		if ( get_user_option('rich_editing') == 'true' ) {
			add_filter( 'mce_external_plugins', array(&$this, 'regplugins'));
			add_filter( 'mce_buttons_3', array(&$this, 'regbtns') );
			
			// remove a button. Used to remove a button created by another plugin
			remove_filter('mce_buttons_3', array(&$this, 'remobtns'));
		}
	}
	
	function remobtns($buttons){
		// add a button to remove
		// array_push($buttons, 'ia_shortcode_collapse');
		return $buttons;	
	}
	
	function regbtns($buttons)
	{
		//array_push($buttons, 'shortcode_button_all');
		array_push($buttons, 'shortcode_button');
		array_push($buttons, 'shortcode_blog');
		array_push($buttons, 'shortcode_post_carousel');
		array_push($buttons, 'shortcode_post_grid');
		array_push($buttons, 'shortcode_testimonial');
		array_push($buttons, 'shortcode_dropcap');
		array_push($buttons, 'shortcode_iconbox');
		array_push($buttons, 'shortcode_member');	
		array_push($buttons, 'shortcode_heading');
		array_push($buttons, 'shortcode_countdown');	
		array_push($buttons, 'shortcode_woo');	
		array_push($buttons, 'shortcode_post_silder');	
		return $buttons;
	}
	
	function regplugins($plgs)
	{
		//$plgs['shortcode_button_all'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/button-shortcode.js';
		$plgs['shortcode_button'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/button.js';
		$plgs['shortcode_blog'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/blog.js';
		$plgs['shortcode_post_carousel'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-carousel.js';
		$plgs['shortcode_post_grid'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-grid.js';
		$plgs['shortcode_iconbox'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/iconbox.js';
		$plgs['shortcode_testimonial'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/testimonial.js';
		$plgs['shortcode_dropcap'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/dropcap.js';
		$plgs['shortcode_member'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/member.js';
		$plgs['shortcode_heading'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/heading.js';
		$plgs['shortcode_countdown'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/shortcode_countdown.js';
		$plgs['shortcode_woo'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/app-woo.js';
		$plgs['shortcode_post_silder'] = IA_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-slider.js';
		return $plgs;
	}
}

$lcshortcode = new LeafColorShortcodes();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); //for check plugin status
// Register element with visual composer and do shortcode


include('shortcodes/icon_box.php');
include('shortcodes/button.php');
include('shortcodes/dropcap.php');
include('shortcodes/heading.php');
include('shortcodes/testimonial.php');
include('shortcodes/blog.php');
include('shortcodes/countdown_clock.php');
include('shortcodes/post-carousel.php');
include('shortcodes/post-grid.php');
include('shortcodes/post-slider.php');
include('shortcodes/app-woo.php');

//add animation param
function ia_add_param() {
	if(class_exists('WPBMap')){
		//get default textblock params
		$shortcode_vc_column_text_tmp = WPBMap::getShortCode('vc_column_text');
		//get animation params
		$attributes = array();
		foreach($shortcode_vc_column_text_tmp['params'] as $param){
			if($param['param_name']=='css_animation'){
				$attributes = $param;
				break;
			}
		}
		if(!empty($attributes)){
			//add animation param
			vc_add_param('ia_iconbox', $attributes);
			vc_add_param('ia_button', $attributes);
			vc_add_param('ia_heading', $attributes);
			vc_add_param('ia_testimonial', $attributes);
			vc_add_param('ia_blog', $attributes);
			vc_add_param('ia_countdown', $attributes);
			vc_add_param('ia_post_carousel', $attributes);
			vc_add_param('ia_post_grid', $attributes);
			vc_add_param('ia_member', $attributes);
			vc_add_param('ia_woo', $attributes);
		}
		//delay param
		$delay = array(
			'type' => 'textfield',
			'heading' => __("Animation Delay",'leafcolor'),
			'param_name' => 'animation_delay',
			'description' => __("Enter Animation Delay in second (ex: 1.5)",'leafcolor')
		);
		vc_add_param('ia_iconbox', $delay);
		vc_add_param('ia_button', $delay);
		vc_add_param('ia_heading', $delay);
		vc_add_param('ia_testimonial', $delay);
		vc_add_param('ia_blog', $delay);
		vc_add_param('ia_countdown', $delay);
		vc_add_param('ia_post_carousel', $delay);
		vc_add_param('ia_post_grid', $delay);
		vc_add_param('ia_member', $delay);
		vc_add_param('ia_woo', $delay);
	}
}
add_action('wp_loaded', 'ia_add_param');

//load animation js
function ia_animation_scripts_styles() {
	global $wp_styles;
	wp_enqueue_script( 'waypoints' );
}
add_action( 'wp_enqueue_scripts', 'ia_animation_scripts_styles' );

//function
if(!function_exists('hex2rgb')){
	function hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
	}
}
function ia_shortcode_query($post_type='',$cat='',$tag='',$ids='',$count='',$order='',$orderby='',$meta_key='',$custom_args=''){
	if($post_type==''){ $post_type='post';}
	$args = array();
	if($custom_args!=''){ //custom array
		$args = $custom_args;
	}elseif($ids!=''){ //specify IDs
		$ids = explode(",", $ids);
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			'post__in' => $ids,
			'ignore_sticky_posts' => 1,
		);
	}elseif($ids=='' && $post_type!='product'){
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			'tag' => $tag,
			'ignore_sticky_posts' => 1,
		);
		if(!is_array($cat)) {
			$cats = explode(",",$cat);
			if(is_numeric($cats[0])){
				$args['category__in'] = $cats;
			}else{			 
				$args['category_name'] = $cat;
			}
		}elseif(count($cat) > 0){
			$args['category__in'] = $cat;
		}
	}else if($post_type=='product'){
		if($tag!=''){
			$tags = explode(",",$tag);
			if(is_numeric($tags[0])){$field_tag = 'term_id'; }
			else{ $field_tag = 'slug'; }
			if(count($tags)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($tags as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'product_tag',
							  'field' => $field_tag,
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'product_tag',
							  'field' => $field_tag,
							  'terms' => $tags,
						  )
				  );
			}
		}
		//cats
		if($cat!=''){
			$cats = explode(",",$cat);
			if(is_numeric($cats[0])){$field = 'term_id'; }
			else{ $field = 'slug'; }
			if(count($cats)>1){
				  $texo = array(
					  'relation' => 'OR',
				  );
				  foreach($cats as $iterm) {
					  $texo[] = 
						  array(
							  'taxonomy' => 'product_cat',
							  'field' => $field,
							  'terms' => $iterm,
						  );
				  }
			  }else{
				  $texo = array(
					  array(
							  'taxonomy' => 'product_cat',
							  'field' => $field,
							  'terms' => $cats,
						  )
				  );
			}
		}
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			'ignore_sticky_posts' => 1,
		);
		if(isset($texo)){
			$args += array('tax_query' => $texo);
		}
		
	}
	$args['post_status'] = $post_type=='attachment'?'inherit':'publish';
	
	$shortcode_query = new WP_Query($args);
	return $shortcode_query;
}