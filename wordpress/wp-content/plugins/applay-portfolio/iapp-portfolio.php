<?php
/*
Plugin Name: Applay portfolio
Plugin URI: http://www.leafcolor.com
Description: Applay portfolio plugin
Version: 1.0
Package: LeafColor 1.0
Author: LeafColor
Author URI: http://www.leafcolor.com
License: GPL2
*/

define( 'IAP_PATH', plugin_dir_url( __FILE__ ) );

//VC shortcode
require_once ('iapp-portfolio-shortcode.php');

// Make sure we don't expose any info if called directly
if ( !defined('ABSPATH') ){
	die('-1');
}
class iAppPortfolio{ //change this class name
	public function __construct()
    {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'template_include', array( $this, 'template_loader' ) );

    }
	public function plugin_path() {
		if ( $this->plugin_path ) return $this->plugin_path;

		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
	
	/*
	 * Load js and css
	 */
	function frontend_scripts(){
		wp_enqueue_style('ias-css', IAP_PATH.'style.css');
	}
	
	/*
	 * 
	 */	
	/*
	 * Post type
	 */
	function register_post_type(){
		$labels = array(
			'name'               => 'Portfolio',
			'singular_name'      => 'Portfolio',
			'add_new'            => 'Add Portfolio',
			'add_new_item'       => 'Add New Portfolio',
			'edit_item'          => 'Edit Portfolio',
			'new_item'           => 'New Portfolio',
			'all_items'          => 'All Portfolio',
			'view_item'          => 'View Portfolio',
			'search_items'       => 'Search Portfolio',
			'not_found'          => 'No Portfolio found',
			'not_found_in_trash' => 'No Portfolio found in Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Portfolio'
		);
		$portfolio_slug = '';
		if(function_exists('ot_get_option')){
			$portfolio_slug =  ot_get_option('portfolio_slug');
		}
		if($portfolio_slug==''){
			$portfolio_slug = 'portfolio';
		}

		if ( $portfolio_slug )
			$rewrite =  array( 'slug' => untrailingslashit( $portfolio_slug ), 'with_front' => false, 'feeds' => true );
		else
			$rewrite = false;
		
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'menu_icon' =>  'dashicons-portfolio',
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => $rewrite,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'comments'),
			'taxonomies' => array('post_tag','category'),
		);
		register_post_type( 'app_portfolio', $args );
	}
	/*
	 * 
	 */
	function template_loader($template){
		$find = array('iapp-portfolio.php');
		$file = '';			
		if(is_singular('app_portfolio')){
			$file = 'portfolio/single.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
		}
		if ( $file ) {
			$template = locate_template( $find );
			
			if ( ! $template ) $template = $this->plugin_path() . '/views/single-portfolio.php';
		}
		return $template;		
	}

}

$iAppPortfolio = new iAppPortfolio();