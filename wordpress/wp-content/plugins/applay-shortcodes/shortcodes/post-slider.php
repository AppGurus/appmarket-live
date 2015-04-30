<?php
function parse_ia_post_slider($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	$tag = isset($atts['tag']) ? $atts['tag'] : '';
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$count = isset($atts['count']) ? $atts['count'] : 5;
	$order = isset($atts['order']) ? $atts['order'] : 'DESC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
	$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
	
	$auto_play = isset($atts['auto_play']) ? $atts['auto_play'] : 0;
	$height = isset($atts['height']) ? $atts['height'] : 0;
	
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start();
	?>
        <?php if($height){ ?>
        <style scoped="scoped">
		.ia-post-slider-<?php echo $ID;?> .slider-item-content{
			max-height:<?php echo $height; ?>px;
		}
		</style>
        <?php } ?>
    	<section class="ia-post-slider ia-post-slider-<?php echo $ID; echo ' '.$animation_class; ?>" data-delay=<?php echo $animation_delay; ?>>
            <div class="post-slider-wrap">
                <div class="is-carousel post-slider-carousel carousel-has-control single-carousel" data-items="<?php echo $visible ?>" data-navigation="1" data-autoplay="<?php echo $auto_play?$auto_play:'false'; ?>">
                <?php $the_query = ia_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key);
                if ( $the_query->have_posts() ) {
                    while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                    <div class="post-slider-item">
                        <div class="slider-item-content">
                            <div class="slider-thumbnail">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                                    <?php if(has_post_thumbnail()){
                                        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full', true);
                                    }elseif( get_post_type(get_the_ID())=='attachment' ){
                                        $thumbnail = wp_get_attachment_image_src(get_the_ID(),'full', true);
                                    }else{
                                        $thumbnail = ia_get_default_image();
                                    }?>
                                    <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                </a>
                            </div><!--slider-thumbnail-->
                            <?php $icon = ia_get_app_icon(get_the_ID()); ?>
                            <div class="post-slider-overlay">
                                <a class="post-slider-nav post-slider-prev" href="#"><i class="fa fa-angle-left"></i></a>
                                <a class="post-slider-nav post-slider-next" href="#"><i class="fa fa-angle-right"></i></a>
                                <a class="post-slider-overlay-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php if($icon){
                                        echo '<img src="'.$icon.'" width="100" height="100" class="app-icon" alt="'.the_title_attribute('echo=0').'"/>';} ?>
                                    <h4 class="post-slider-title"><?php the_title(); ?></h4>
                                    <?php if($post_type == 'product' && class_exists('Woocommerce')){ 
                                    global $product;?>
                                        <div class="small">
                                        <?php 
                                        $type = $product->product_type;
                                        if($type=='variable'){
                                            $price_html = $product->get_price(); ?>
                                                <span class="price"><?php _e('From  ','leafcolor') ?><?php  echo get_woocommerce_currency_symbol(); echo $price_html; ?></span>
                                            <?php 
                                        }else{
                                            if ( $price_html = $product->get_price_html() ) : ?>
                                                <span class="price"><?php echo $price_html; ?></span>
                                            <?php endif; 	
                                        }
                                        ?>
                                        </div>
                                    <?php }elseif($post_type == 'app_portfolio'){ ?>
                                        <div  class="small"><?php echo get_post_meta(get_the_ID(),'port-author-name',true); ?></div>
                                    <?php }else{?>
                                        <div  class="small"><?php the_time( get_option( 'time_format' ) ); ?></div>
                                    <?php }?>
                                    <div class="clearfix"></div>
                                </a>
                            </div>
                        </div><!--/app-item-->
                    </div><!--/post-carousel-item-->
                <?php
                    }//while have_posts
                }//if have_posts
                wp_reset_postdata();
                ?>
                </div>
            </div>
        </section><!--/ia-post-slider-->
	<?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'ia_post_slider', 'parse_ia_post_slider' );

add_action( 'after_setup_theme', 'reg_ia_post_slider' );
function reg_ia_post_slider(){
	if(function_exists('wpb_map')){
	wpb_map( array(
	   "name" => __("Post Slider"),
	   "base" => "ia_post_slider",
	   "class" => "",
	   "icon" => "icon-post-slider",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Post Type", "leafcolor"),
			 "param_name" => "post_type",
			 "value" => array(
			 	__('Post', 'leafcolor') => 'post',
				__('Product', 'leafcolor') => 'product',
				__('Portfolio', 'leafcolor') => 'app_portfolio',
				__('Attachment', 'leafcolor') => 'attachment',
			 ),
			 "description" => __('Choose post type','leafcolor')
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Category", "leafcolor"),
			"param_name" => "cat",
			"value" => "",
			"description" => __("List of cat ID (or slug), separated by a comma", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Tags", "leafcolor"),
			"param_name" => "tag",
			"value" => "",
			"description" => __("list of tags, separated by a comma", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("IDs", "leafcolor"),
			"param_name" => "ids",
			"value" => "",
			"description" => __("Specify post IDs to retrieve", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Count", "leafcolor"),
			"param_name" => "count",
			"value" => "5",
			"description" => __("Number of posts to show. Default is 5", 'leafcolor'),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Order", 'leafcolor'),
			 "param_name" => "order",
			 "value" => array(
			 	__('DESC', 'leafcolor') => 'DESC',
				__('ASC', 'leafcolor') => 'ASC',
			 ),
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Order by", 'leafcolor'),
			 "param_name" => "orderby",
			 "value" => array(
			 	__('Date', 'leafcolor') => 'date',
				__('ID', 'leafcolor') => 'ID',
				__('Author', 'leafcolor') => 'author',
			 	__('Title', 'leafcolor') => 'title',
				__('Name', 'leafcolor') => 'name',
				__('Modified', 'leafcolor') => 'modified',
			 	__('Parent', 'leafcolor') => 'parent',
				__('Random', 'leafcolor') => 'rand',
				__('Comment count', 'leafcolor') => 'comment_count',
				__('Menu order', 'leafcolor') => 'menu_order',
				__('Meta value', 'leafcolor') => 'meta_value',
				__('Meta value num', 'leafcolor') => 'meta_value_num',
				__('Post__in', 'leafcolor') => 'post__in',
				__('None', 'leafcolor') => 'none',
			 ),
			 "description" => ''
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Meta key", "leafcolor"),
			"param_name" => "meta_key",
			"value" => "",
			"description" => __("Name of meta key for ordering", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Auto play", "leafcolor"),
			"param_name" => "auto_play",
			"value" => "0",
			"description" => __("Auto play timeout miliseconds (Ex: 3000 for 3 seconds, or 0 for no autoplay)", "leafcolor"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Custom Max Height", "leafcolor"),
			"param_name" => "height",
			"value" => "0",
			"description" => __("Enter slider max height in number of px (ex: 600), default is auto", "leafcolor"),
		  ),
	   )
	));
	}
}