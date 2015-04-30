<?php
/*
Plugin Name: Applay Showcase
Plugin URI: http://www.leafcolor.com
Description: Applay Showcase plugin
Version: 1.0
Package: Leafcolor 1.0
Author: LeafColor
Author URI: http://www.leafcolor.com
License: GPL2
*/

define( 'IAS_PATH', plugin_dir_url( __FILE__ ) );

//load option tree for post meta
//include_once ('option-tree/ot-loader.php');

//load plugin option
require_once ('admin/plugin-options.php');

//template loader
require_once ('iapp-showcase-template-loader.class.php');

//VC shortcode
require_once ('iapp-showcase-shortcode.php');

// Make sure we don't expose any info if called directly
if ( !defined('ABSPATH') ){
	die('-1');
}

class iAppShowcase{ //change this class name
	public function __construct()
    {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'after_setup_theme', array( $this, 'post_meta' ) );
		add_filter( 'the_content', array( $this, 'filter_showcase_content' ));
		add_shortcode( 'iapp_showcase', array( $this, 'shortcode' ) ); //change shortcode name
    }
	
	/*
	 * Load js and css
	 */
	function frontend_scripts(){
		wp_enqueue_style( 'owl-carousel', IAS_PATH.'js/owl-carousel/owl.carousel.css');
		wp_enqueue_style( 'owl-carousel-theme', IAS_PATH.'js/owl-carousel/owl.theme.css');
		wp_enqueue_style('ias-css', IAS_PATH.'style.css');
		wp_enqueue_style('ias-devide', IAS_PATH.'devices/assets/style.css');
		$options = $this->get_all_option();
		if($options['no_fontawesome']==0){
			wp_enqueue_style('font-awesome', IAS_PATH.'font-awesome/css/font-awesome.min.css');
		}
		wp_enqueue_script('owl-carousel', IAS_PATH.'js/owl-carousel/owl.carousel.min.js', array('jquery'),1, true );
		wp_enqueue_script('ias-js', IAS_PATH.'js/main.js',array('jquery'),1,true);
	}
	
	/*
	 * Setup and do shortcode
	 */
	function shortcode($atts,$content=""){
		//get shortcode parameter
		$atts['id'] = isset($atts['id'])?$atts['id']:1;
		$atts['showcase_id'] = isset($atts['showcase_id'])?$atts['showcase_id']:'';
		//display
		ob_start(); ?>
        <section class="iapp-showcase">
        	<?php require_once ('views/devide_iphone5s.php'); ?>
        </section>
		<?php
		//return
		$output_string=ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
	
	/*
	 * Post type
	 */
	function register_post_type(){
		$labels = array(
			'name'               => 'Showcase',
			'singular_name'      => 'Showcase',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Showcase',
			'edit_item'          => 'Edit Showcase',
			'new_item'           => 'New Showcase',
			'all_items'          => 'All Showcases',
			'view_item'          => 'View Showcase',
			'search_items'       => 'Search Showcase',
			'not_found'          => 'No Showcase found',
			'not_found_in_trash' => 'No Showcase found in Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Showcase'
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'menu_icon'			 => 'dashicons-smartphone',
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'comments')
		);
		register_post_type( 'iapp_showcase', $args );
	}
	/*
	 * Post meta
	 */
	function post_meta(){
		//option tree
		$meta_box = array(
			'id'        => 'ias_meta_box', //change this
			'title'     => 'Showcase options',
			'desc'      => '',
			'pages'     => array( 'iapp_showcase' ),
			'context'   => 'normal',
			'priority'	=> 'high',
			'fields'    => array(
				array(
					'id'          => 'ias_style',
					'label'       => __( 'Style', 'leafcolor' ),
					'desc'        => __( '', 'leafcolor' ),
					'std'         => '',
					'type'        => 'radio-image',
					'section'     => '',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '',
					'class'       => '',
					'condition'   => '',
					'choices'     => array(
					  array(
						'value'       => 'listing',
						'label'       => __( 'Listing', 'leafcolor' ),
						'src'         => IAS_PATH.'images/option-listing.png'
					  ),
					  array(
						'value'       => 'hero',
						'label'       => __( 'Hero', 'leafcolor' ),
						'src'         => IAS_PATH.'images/option-hero.png'
					  ),
					  array(
						'value'       => 'features',
						'label'       => __( 'Features Carousel', 'leafcolor' ),
						'src'         => IAS_PATH.'images/option-features.png'
					  ),
					  array(
						'value'       => 'layer',
						'label'       => __( 'Screen Layers', 'leafcolor' ),
						'src'         => IAS_PATH.'images/option-layer.png'
					  )
					)
				),//end ias_style
				//hero
			    array(
					'label'       => 'Devides',
					'id'          => 'hero_devide',
					'type'        => 'list-item',
					'class'       => '',
					'desc'        => __( 'Add devide for Hero or Listing section', 'leafcolor' ),
					'condition'	  => 'ias_style:is(hero),ias_style:is(listing)',
					'operator'	  => 'or',
					'choices'     => array(),
					'settings'    => array(
						array(
							'label'       => __( 'Devide', 'leafcolor' ),
							'id'          => 'devide',
							'type'        => 'select',
							'desc'        => '',
							'std'         => '',
							'rows'        => '',
							'post_type'   => '',
							'taxonomy'    => '',
							'choices'     => array(
								array(
									'value'       => 'iphone5s',
									'label'       => __( 'iPhone 5S', 'leafcolor' ),
									'src'         => ''
								),
								array(
									'value'       => 'iphone5c',
									'label'       => __( 'iPhone 5C', 'leafcolor' ),
									'src'         => ''
								),
								array(
									'value'       => 'iphone4s',
									'label'       => __( 'iPhone 4S', 'leafcolor' ),
									'src'         => ''
								),
								array(
									'value'       => 'nexus5',
									'label'       => __( 'Nexus 5', 'leafcolor' ),
									'src'         => ''
								),
								array(
									'value'       => 'lumia920',
									'label'       => __( 'Lumia 920', 'leafcolor' ),
									'src'         => ''
								),
								array(
									'value'       => 'galaxys5',
									'label'       => __( 'Galaxy S5', 'leafcolor' ),
									'src'         => ''
								),
								array(
									'value'       => 'htcone',
									'label'       => __( 'HTC One', 'leafcolor' ),
									'src'         => ''
								),
								array(
									'value'       => 'ipadmini',
									'label'       => __( 'iPad Mini', 'leafcolor' ),
									'src'         => ''
								),
							),
						),//end devide
						//color
						array(
							'id'          => 'devide_color_iphone5s',
							'label'       => __( 'Devide color', 'leafcolor' ),
							'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
							'std'         => 'silver',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(iphone5s)',
							'choices'     => array(
							  array(
								'value'       => 'silver',
								'label'       => __( 'Silver', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/black.png'
							  ),
							  array(
								'value'       => 'gold',
								'label'       => __( 'Gold', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/gold.png'
							  )
							)
						),//end features 5s color
						array(
							'id'          => 'devide_color_iphone5c',
							'label'       => __( 'Devide color', 'leafcolor' ),
							'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
							'std'         => 'green',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(iphone5c)',
							'choices'     => array(
							  array(
								'value'       => 'green',
								'label'       => __( 'Green', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/green.png'
							  ),
							  array(
								'value'       => 'white',
								'label'       => __( 'White', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'red',
								'label'       => __( 'Red', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/red.png'
							  ),
							  array(
								'value'       => 'yellow',
								'label'       => __( 'Yellow', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/yellow.png'
							  ),
							  array(
								'value'       => 'blue',
								'label'       => __( 'Blue', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/blue.png'
							  )
							)
						),//end features 5c color
						array(
							'id'          => 'devide_color_lumia920',
							'label'       => __( 'Devide color', 'leafcolor' ),
							'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
							'std'         => 'yellow',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(lumia920)',
							'choices'     => array(
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/black.png'
							  ),
							  array(
								'value'       => 'white',
								'label'       => __( 'White', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'yellow',
								'label'       => __( 'Yellow', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/yellow.png'
							  ),
							  array(
								'value'       => 'red',
								'label'       => __( 'Red', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/red.png'
							  ),
							  array(
								'value'       => 'blue',
								'label'       => __( 'Blue', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/blue.png'
							  )
							)
						),//end features lumia color
						array(
							'id'          => 'devide_color_ipadmini',
							'label'       => __( 'Devide color', 'leafcolor' ),
							'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
							'std'         => 'silver',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(ipadmini)',
							'choices'     => array(
							  array(
								'value'       => 'silver',
								'label'       => __( 'Silver', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/black.png'
							  )
							)
						),//end features ipadmini color
						array(
							'id'          => 'devide_color_iphone4s',
							'label'       => __( 'Devide color', 'leafcolor' ),
							'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
							'std'         => 'silver',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(iphone4s)',
							'choices'     => array(
							  array(
								'value'       => 'silver',
								'label'       => __( 'Silver', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/black.png'
							  )
							)
						),//end features 4s color
						array(
							'id'          => 'devide_color_galaxys5',
							'label'       => __( 'Devide color', 'leafcolor' ),
							'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
							'std'         => 'white',
							'type'        => 'radio-image',
							'condition'   => 'devide:is(galaxys5)',
							'choices'     => array(
							  array(
								'value'       => 'white',
								'label'       => __( 'White', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/white.png'
							  ),
							  array(
								'value'       => 'black',
								'label'       => __( 'Black', 'leafcolor' ),
								'src'         => IAS_PATH.'/images/black.png'
							  )
							)
						),//end features s5 color
						array(
							'label'       => __( 'Screen Content', 'leafcolor' ),
							'id'          => 'content',
							'type'        => 'select',
							'desc'        => __( 'Choose Screen Content', 'leafcolor' ),
							'std'         => '',
							'rows'        => '',
							'choices'     => array(
								array(
									'value'       => 'image',
									'label'       => __( 'Single Image', 'leafcolor' ),
									'src'         => ''
								),
								array(
									'value'       => 'carousel',
									'label'       => __( 'Images Carousel', 'leafcolor' ),
									'src'         => ''
								),
								array(
									'value'       => 'iframe',
									'label'       => __( 'Iframe', 'leafcolor' ),
									'src'         => ''
								),
								array(
									'value'       => 'text',
									'label'       => __( 'Custom Content text', 'leafcolor' ),
									'src'         => ''
								),
							)
						),//end content
						array(
							'label'       => __( 'Image', 'leafcolor' ),
							'id'          => 'content_image',
							'type'        => 'upload',
							'desc'        => '',
							'std'         => '',
							'rows'        => '',
							'condition'	  => 'content:is(image)',
							'choices'     => array()
						),//end image
						array(
							'label'       => __( 'Carousel', 'leafcolor' ),
							'id'          => 'content_carousel',
							'type'        => 'gallery',
							'desc'        => __( 'Create gallery images for carousel', 'leafcolor' ),
							'std'         => '',
							'rows'        => '',
							'condition'	  => 'content:is(carousel)',
							'choices'     => array()
						),//end gallery
						array(
							'label'       => __( 'Carousel Autoplay Timeout', 'leafcolor' ),
							'id'          => 'content_carousel_autoplay',
							'type'        => 'text',
							'desc'        => __( 'Enter miliseconds timeout for autoplay. (Default is 6000, enter 0 for no auto)', 'leafcolor' ),
							'std'         => '',
							'rows'        => '',
							'condition'	  => 'content:is(carousel)',
							'choices'     => array()
						),//end autoplay
						array(
							'label'       => __( 'Iframe URL', 'leafcolor' ),
							'id'          => 'content_iframe',
							'type'        => 'text',
							'desc'        => __( 'Enter iframe URL', 'leafcolor' ),
							'std'         => '',
							'rows'        => '',
							'condition'	  => 'content:is(iframe)',
							'choices'     => array()
						),//end iframe
						array(
							'label'       => __( 'Custom Content Text', 'leafcolor' ),
							'id'          => 'content_text',
							'type'        => 'textarea',
							'desc'        => __( '', 'leafcolor' ),
							'std'         => '',
							'rows'        => '8',
							'condition'	  => 'content:is(text)',
							'choices'     => array()
						),//end text
						array(
							'label'       => __( 'URL', 'leafcolor' ),
							'id'          => 'devide_url',
							'type'        => 'text',
							'desc'        => __( 'Destination URL when click on devide content', 'leafcolor' ),
							'std'         => '',
							'rows'        => '',
							'condition'	  => '',
							'choices'     => array()
						),//end url
					),
				),//end hero_devide
				//features carousel
				array(
					'label'       => __( 'Devide', 'leafcolor' ),
					'id'          => 'features_devide',
					'type'        => 'select',
					'desc'        => __( 'Choose devide to display features carousel', 'leafcolor' ),
					'std'         => '',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'condition'	  => 'ias_style:is(features)',
					'choices'     => array(
						array(
							'value'       => 'iphone5s',
							'label'       => __( 'iPhone 5S', 'leafcolor' ),
							'src'         => ''
						),
						array(
							'value'       => 'iphone5c',
							'label'       => __( 'iPhone 5C', 'leafcolor' ),
							'src'         => ''
						),
						array(
							'value'       => 'iphone4s',
							'label'       => __( 'iPhone 4S', 'leafcolor' ),
							'src'         => ''
						),
						array(
							'value'       => 'nexus5',
							'label'       => __( 'Nexus 5', 'leafcolor' ),
							'src'         => ''
						),
						array(
							'value'       => 'lumia920',
							'label'       => __( 'Lumia 920', 'leafcolor' ),
							'src'         => ''
						),
						array(
							'value'       => 'galaxys5',
							'label'       => __( 'Galaxy S5', 'leafcolor' ),
							'src'         => ''
						),
						array(
							'value'       => 'htcone',
							'label'       => __( 'HTC One', 'leafcolor' ),
							'src'         => ''
						),
						array(
							'value'       => 'ipadmini',
							'label'       => __( 'iPad Mini', 'leafcolor' ),
							'src'         => ''
						),
					),
				),//end features devide
				array(
					'id'          => 'features_devide_color_iphone5s',
					'label'       => __( 'Devide color', 'leafcolor' ),
					'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
					'std'         => 'silver',
					'type'        => 'radio-image',
					'section'     => '',
					'class'       => '',
					'condition'   => 'features_devide:is(iphone5s),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'silver',
						'label'       => __( 'Silver', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/black.png'
					  ),
					  array(
						'value'       => 'gold',
						'label'       => __( 'Gold', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/gold.png'
					  )
					)
				),//end features 5s color
				array(
					'id'          => 'features_devide_color_iphone5c',
					'label'       => __( 'Devide color', 'leafcolor' ),
					'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
					'std'         => 'green',
					'type'        => 'radio-image',
					'condition'   => 'features_devide:is(iphone5c),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'green',
						'label'       => __( 'Green', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/green.png'
					  ),
					  array(
						'value'       => 'white',
						'label'       => __( 'White', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'red',
						'label'       => __( 'Red', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/red.png'
					  ),
					  array(
						'value'       => 'yellow',
						'label'       => __( 'Yellow', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/yellow.png'
					  ),
					  array(
						'value'       => 'blue',
						'label'       => __( 'Blue', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/blue.png'
					  )
					)
				),//end features 5c color
				array(
					'id'          => 'features_devide_color_lumia920',
					'label'       => __( 'Devide color', 'leafcolor' ),
					'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
					'std'         => 'yellow',
					'type'        => 'radio-image',
					'condition'   => 'features_devide:is(lumia920),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/black.png'
					  ),
					  array(
						'value'       => 'white',
						'label'       => __( 'White', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'yellow',
						'label'       => __( 'Yellow', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/yellow.png'
					  ),
					  array(
						'value'       => 'red',
						'label'       => __( 'Red', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/red.png'
					  ),
					  array(
						'value'       => 'blue',
						'label'       => __( 'Blue', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/blue.png'
					  )
					)
				),//end features lumia color
				array(
					'id'          => 'features_devide_color_ipadmini',
					'label'       => __( 'Devide color', 'leafcolor' ),
					'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
					'std'         => 'silver',
					'type'        => 'radio-image',
					'condition'   => 'features_devide:is(ipadmini),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'silver',
						'label'       => __( 'Silver', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/black.png'
					  )
					)
				),//end features ipadmini color
				array(
					'id'          => 'features_devide_color_iphone4s',
					'label'       => __( 'Devide color', 'leafcolor' ),
					'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
					'std'         => 'silver',
					'type'        => 'radio-image',
					'condition'   => 'features_devide:is(iphone4s),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'silver',
						'label'       => __( 'Silver', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/black.png'
					  )
					)
				),//end features 4s color
				array(
					'id'          => 'features_devide_color_galaxys5',
					'label'       => __( 'Devide color', 'leafcolor' ),
					'desc'        => __( 'Choose devide\'s color style', 'leafcolor' ),
					'std'         => 'white',
					'type'        => 'radio-image',
					'condition'   => 'features_devide:is(galaxys5),ias_style:is(features)',
					'choices'     => array(
					  array(
						'value'       => 'white',
						'label'       => __( 'White', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/white.png'
					  ),
					  array(
						'value'       => 'black',
						'label'       => __( 'Black', 'leafcolor' ),
						'src'         => IAS_PATH.'/images/black.png'
					  )
					)
				),//end features s5 color
				array(
					'label'       => __( 'Autoplay Timeout', 'leafcolor' ),
					'id'          => 'features_autoplay',
					'type'        => 'text',
					'desc'        => __( 'Enter miliseconds timeout for autoplay. (Default is 3500, enter 0 for no auto)', 'leafcolor' ),
					'std'         => '',
					'rows'        => '',
					'condition'	  => 'ias_style:is(features)',
					'choices'     => array()
				),//end autoplay
				array(
					'label'       => 'Screen Items',
					'id'          => 'screen_item',
					'type'        => 'list-item',
					'class'       => '',
					'desc'        => __( 'Add Screen Item for Features Carousel or Screen Layers section', 'leafcolor' ),
					'condition'	  => 'ias_style:is(features),ias_style:is(layer)',
					'operator'	  => 'or',
					'choices'     => array(),
					'settings'    => array(
						array(
							'label'       => __( 'Feature Icon', 'leafcolor' ),
							'id'          => 'feature_icon',
							'type'        => 'text',
							'desc'        => __( 'Enter Font Awesome icon class (Ex: fa-star) (Only used for Features Carousel)', 'leafcolor' ),
							'std'         => '',
							'rows'        => '',
							//'condition'	  => 'ias_style:is(features)',
							'choices'     => array()
						),//end feature_icon
						array(
							'label'       => __( 'Feature Description', 'leafcolor' ),
							'id'          => 'feature_description',
							'type'        => 'textarea',
							'desc'        => __( 'Enter Feature\'s Description (Only used for Features Carousel)', 'leafcolor' ),
							'std'         => '',
							'rows'        => '',
							//'condition'	  => 'ias_style:is(features)',
							'choices'     => array()
						),//end feature_text
						array(
							'label'       => __( 'Screen Image', 'leafcolor' ),
							'id'          => 'screen_image',
							'type'        => 'upload',
							'desc'        => '',
							'std'         => '',
							'rows'        => '',
							'post_type'   => '',
							'taxonomy'    => '',
							'choices'     => array(),
						),//end screen image
						array(
							'label'       => __( 'URL', 'leafcolor' ),
							'id'          => 'screen_url',
							'type'        => 'text',
							'desc'        => __( 'Destination URL when click on screen (Optional)', 'leafcolor' ),
							'std'         => '',
							'rows'        => '',
							'condition'	  => '',
							'choices'     => array()
						),//end url
					),
				),//end features item
		  	)
		);
		if (function_exists('ot_register_meta_box')) {
			ot_register_meta_box( $meta_box );
		}
	}
	/*
	 *
	 */
	function filter_showcase_content($content) {
		if( is_singular('iapp_showcase') ) {
			ob_start();
				require_once ('views/single.php');
            //return
            $output_string=ob_get_contents();
            ob_end_clean();
			$content = $output_string.$content;	
		}
		return $content;
	}
	/*
	 * Get all plugin options
	 */
	function get_all_option(){
		$options = get_option('ias_options_group');
		$options['no_fontawesome'] = isset($options['load_fontawesome'])?$options['no_fontawesome']:0;
		return $options;
	}
	/*devide*/
	static function ias_devide($devide_item){
		global $global_devide_item;
		$global_devide_item = $devide_item;
		$devide = $devide_item['devide']?$devide_item['devide']:'iphone5s';
		global $global_devide_item_count;
		$global_devide_item_count = $global_devide_item_count?$global_devide_item_count:0;
		$global_devide_item_count++;
		ob_start(); ?>
        	<div class="ias-devide-wrap ias-devide-<?php echo $global_devide_item_count ?>">
        		<?php require('views/devide_'.$devide.'.php'); ?>
            </div>
		<?php
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
	static function ias_devide_content($devide_item){
		global $global_devide_item;
		$global_devide_item = $devide_item;
		$devide_content = $devide_item['content']?$devide_item['content']:'image';
		ob_start();
			require('views/devide_content_'.$devide_content.'.php');
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}
$iAppShowcase = new iAppShowcase();