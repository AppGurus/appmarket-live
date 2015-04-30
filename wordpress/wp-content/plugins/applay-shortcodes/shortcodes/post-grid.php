<?php
function parse_ia_post_grid($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$column = isset($atts['column']) ? $atts['column'] : '';
	
	$post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	$tag = isset($atts['tag']) ? $atts['tag'] : '';
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$count = isset($atts['count']) ? $atts['count'] : 8;
	$order = isset($atts['order']) ? $atts['order'] : 'DESC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
	$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
	
	$featured_item = isset($atts['featured_item']) ? $atts['featured_item'] : 0;
	$show_extra = isset($atts['show_extra']) ? $atts['show_extra'] : 1;
	
	$gallery = isset($atts['gallery']) ? $atts['gallery'] : ($atts['post_type']=='attachment'?1:'');
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	if($gallery){
		wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/js/colorbox/jquery.colorbox-min.js', array('jquery'), '', true );
	}
	//display
	ob_start();
	?>
        <div class="ia-grid-listing ia-post-grid ia-post-grid-<?php echo $column; echo $featured_item?' has-featured-item':''; echo ' '.$animation_class; ?>" data-delay=<?php echo $animation_delay; ?>>
            <div class="grid-wrap">
                <div class="grid-listing <?php echo (!$show_extra)?'no-overlay-bottom':'' ?>">
                    <?php $the_query = ia_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key);
					if ( $the_query->have_posts() ) {
						$count_p = 0;
						while ( $the_query->have_posts() ) { $the_query->the_post(); $count_p++; ?>
                        <div class="grid-item grid-post-id-<?php the_ID(); echo ($count_p==1&&$featured_item)?' featured-item-1':''?>">
                            <div class="grid-item-inner">
                                <div class="grid-item-content app-item dark-div">
                                    <div class="app-thumbnail">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" <?php if($gallery){ ?>class="colorbox-grid" data-rel="ia-post-grid-<?php echo get_post_format()=='gallery'?'gallery-'.get_the_ID():$ID; ?>" data-content=".grid-post-id-<?php the_ID();?>" <?php }//if gallery?> >
                                            <?php
											$thumbnail_size = ($count_p==1&&$featured_item)?'thumb_800x400':'thumb_500x500';
											if(has_post_thumbnail()){
												$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),$thumbnail_size, true);
											}elseif( get_post_type(get_the_ID())=='attachment' ){
												$thumbnail = wp_get_attachment_image_src(get_the_ID(),$thumbnail_size, true);
											}else{
												$thumbnail = ia_get_default_image();
											}?>
                                            <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                        </a>
                                    </div>
                                    <?php $icon = ia_get_app_icon(get_the_ID()); ?>
                                    <div class="grid-overlay <?php echo $icon?'grid-has-icon':'' ?>">
                                        <a class="overlay-top" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                        	<?php if($icon){
												echo '<img src="'.$icon.'" width="60" height="60" class="grip-app-icon" alt="'.the_title_attribute( 'echo=0' ).'" />';} ?>
                                        	<h4><?php the_title(); ?></h4>
                                            <div class="clearfix"></div>
                                        </a>
                                        <div class="overlay-bottom">
                                        	<?php if($post_type == 'product'){ 
											if (class_exists('Woocommerce')) {
											global $product;$average = $product->get_average_rating();
											if($average){
    										echo '<div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>';
											}?>
                                                <div>
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
                                            	<div><?php echo get_post_meta(get_the_ID(),'port-author-name',true); ?></div>
                                                <div><?php echo get_post_meta(get_the_ID(),'port-release',true); ?></div>
											<?php }else{?>
                                            	<div><?php echo __('By ','leafcolor').get_the_author(); ?></div>
                                                <div><?php _e('At ','leafcolor'); the_time( get_option( 'time_format' ) ); ?></div>
                                            <?php }
											}?>
                                        </div>
                                    </div>
                                </div><!--/app-item-->
                            </div>
                            <?php if($gallery){ ?>
                            <div class="hidden">
                            	<div class="popup-data dark-div">
									<?php if(has_post_thumbnail()){
										$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full', true); ?>
										<img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                    <?php }elseif(get_post_type(get_the_ID())=='attachment'){
										$thumbnail = wp_get_attachment_image_src(get_the_ID(),'full', true); ?>
                                        <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                    <?php }?>
                                    <div class="popup-data-content">
                                        <h3 class="font-2"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                                        <div><?php the_excerpt(); ?></div>
                                    </div>
                                </div>
                            </div><!--/hidden-->
                            <?php }//if gallery
							
							if($gallery && get_post_format()=='gallery'){ //setup popup gallery for post gallery
								$images=get_children('post_type=attachment&numberposts=-1&post_mime_type=image&post_parent='.get_the_ID());
								if(count($images) > 0){
							?>
							<div class="hidden">
                            	<?php foreach((array)$images as $attachment_id => $attachment){ ?>
                                <a href="#" title="<?php the_title_attribute(); ?>" class="colorbox-grid" data-rel="ia-post-grid-gallery-<?php echo get_the_ID(); ?>" data-content=".grid-attachment-id-<?php echo $attachment_id;?>" data-isgallery=true ></a>
                                <div class="grid-attachment-id-<?php echo $attachment_id;?>">
                                    <div class="popup-data popup-data-gallery dark-div">
                                        <?php $thumbnail = wp_get_attachment_image_src($attachment_id,'full', true); ?>
                                        <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                        <div class="popup-data-content">
                                            <h4><a href="<?php echo get_permalink($attachment_id); ?>"><?php echo get_the_title($attachment_id); ?></a></h4>
                                            <div><?php echo get_the_excerpt($attachment_id); ?></div>
                                            <a class="btn btn-default" href="javascript:void(0)" data-toggle="collapse" data-target="#share-in-popup-<?php echo $attachment_id; ?>"><?php _e('SHARE','leafcolor'); ?> <i class="fa fa-share"></i></a>
                                            <a href="<?php the_permalink(); ?>#comment" class="btn btn-default" title="<?php _e('View comments','leafcolor'); ?>"><?php comments_number(__('COMMENTS','leafcolor'),__('COMMENT (1)','leafcolor'),__('COMMENTS (%)','leafcolor')); ?></a>
                                            <div id="share-in-popup-<?php echo $attachment_id?>" class="popup-share collapse">
                                                <ul class="list-inline social-light">
                                                    <?php leafcolor_social_share($attachment_id); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!--/popup-data-->
                                </div><!--/grid-attachment-id-->
                                <?php } ?>
                            </div><!--/hidden-->
							<?php }//if count
							}//if format gallery ?>
                        </div><!--/grid-item-->
                        <?php
						}//while have_posts
					}//if have_posts
					wp_reset_postdata(); ?>
                </div>
            </div>
        </div><!--/app-grid-listing-->
	<?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'ia_post_grid', 'parse_ia_post_grid' );
add_action( 'after_setup_theme', 'reg_ia_post_grid' );
function reg_ia_post_grid(){
	if(function_exists('wpb_map')){
	wpb_map( array(
	   "name" => __("Post Grid"),
	   "base" => "ia_post_grid",
	   "class" => "",
	   "icon" => "icon-post-grid",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
		  array(
			"type" => "textfield",
			"heading" => __("Grid Columns Number", "leafcolor"),
			"param_name" => "column",
			"value" => "",
			"description" => __("Default is 4", "leafcolor"),
		  ),
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
			"value" => "8",
			"description" => __("Number of posts to show. Default is 8", 'leafcolor'),
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
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Enable featured item", 'leafcolor'),
			 "param_name" => "featured_item",
			 "value" => array(
				__('No', 'leafcolor') => 0,
				__('Yes', 'leafcolor') => 1,
			 ),
			 "description" => 'First item will have 2x width'
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Show extra info", 'leafcolor'),
			 "param_name" => "show_extra",
			 "value" => array(
			 	__('Show', 'leafcolor') => 1,
				__('Hide', 'leafcolor') => 0,
			 ),
			 "description" => 'Show extra info when Hover'
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Enable Gallery Popup", 'leafcolor'),
			 "param_name" => "gallery",
			 "value" => array(
			 	__('No', 'leafcolor') => 0,
				__('Yes', 'leafcolor') => 1,
			 ),
			 "description" => __('Enable Gallery Popup when click on post thumbnail images','leafcolor')
		  ),
	   )
	));
	}
}