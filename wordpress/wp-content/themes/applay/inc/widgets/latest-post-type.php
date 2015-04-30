<?php
/*
Plugin Name: Latest post
Plugin URI: http://www.leafcolor.com
Description: Adds a widget that can display recent posts from multiple categories or from custom post types.
Version: 1.0
Author: leafcolor
Author URI: http://www.leafcolor.com
*/
/*  

*/

class App_Recent_Posts extends WP_Widget {	

	function __construct() {
    	$widget_ops = array(
			'classname'   => 'app_recent_posts', 
			'description' => __('App Latest Posts ','leafcolor')
		);
    	parent::__construct('app-recent-posts', __('App - Latest Posts ','leafcolor'), $widget_ops);
	}


	function widget($args, $instance) {
		$cache = wp_cache_get('widget_app_recent_posts', 'widget');		
		if ( !is_array($cache) )
			$cache = array();

		if ( !isset( $argsxx['widget_id'] ) )
			$argsxx['widget_id'] = $this->id;
		if ( isset( $cache[ $argsxx['widget_id'] ] ) ) {
			echo $cache[ $argsxx['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);
		
		$ids 			= empty($instance['ids']) ? '' : $instance['ids'];
		$title 			= empty($instance['title']) ? '' : $instance['title'];
		$title          = apply_filters('widget_title', $title);
		$cats 			= empty($instance['cats']) ? '' : $instance['cats'];
		$post_type 			= empty($instance['post_type']) ? 'post' : $instance['post_type'];
		$tags 			= empty($instance['tags']) ? '' : $instance['tags'];
		$number 		= empty($instance['number']) ? 3 : $instance['number'];
		if($ids!=''){
			$ids = explode(",", $ids);
			$gc = array();
			foreach ( $ids as $grid_id ) {
				array_push($gc, $grid_id);
			}
			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $number,
				'orderby' => 'date',
				'order' => 'DESC',
				'post_status' => 'publish',
				'post__in' =>  $gc,
				'ignore_sticky_posts' => 1,
			);
		} else if($ids=='' && $post_type!='product') {
			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $number,
				'orderby' => 'date',
				'order' => 'DESC',
				'post_status' => 'publish',
			);
		
			if(!is_array($cats) && $cats!='') {
				$category = explode(",",$cats);
				if(is_numeric($cats[0])){
					$args['category__in'] = $category;
				}else{			 
					$args['category_name'] = $cats;
				}
			}elseif(count($cats) > 0){
				$args['category__in'] = $cats;
			}
			if($tags!=''){
				$args += array('tag' => $tags);
			}
		}else if($post_type=='product'){
			if($tags!=''){
				$tax = explode(",",$tags);
				if(is_numeric($tax[0])){$field_tag = 'term_id'; }
				else{ $field_tag = 'slug'; }
				if(count($tax)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($tax as $iterm) {
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
			if($cats!=''){
				$taxonomy = explode(",",$cats);
				if(is_numeric($taxonomy[0])){$field = 'term_id'; }
				else{ $field = 'slug'; }
				if(count($taxonomy)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($taxonomy as $iterm) {
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
				'posts_per_page' => $number,
				'orderby' => 'date',
				'order' => 'DESC',
				'post_status' => 'publish',
			);
			if(isset($texo)){
				$args += array('tax_query' => $texo);
			}
			
		}

		$the_query = new WP_Query( $args );
		$html = $before_widget;
		$html .='<div class="app-lastest">';
		if ( $title ) $html .= $before_title . $title . $after_title; 
		if($the_query->have_posts()):
			while($the_query->have_posts()): $the_query->the_post();
			$icon ='';
			if($post_type=='product'){$icon = get_post_meta(get_the_ID(),'app-icon',true);}
				$html .='<div class="item">';
					if(has_post_thumbnail(get_the_ID()) || $icon){
						$html .='<div class="thumb item-thumbnail">
							<a href="'.esc_url(get_permalink(get_the_ID())).'" title="'.the_title_attribute('echo=0').'">
								<div class="item-thumbnail">';
								if($icon){
									if($icon_id = ia_get_attachment_id_from_url($icon)){
										$thumbnail = wp_get_attachment_image_src($icon_id,'thumb_80x80', true);
										$icon = isset($thumbnail[0])?$thumbnail[0]:$icon;
									} 
									$html .='<img src="'.esc_url($icon).'" width="80" height="80" title="'.the_title_attribute('echo=0').'" />';
								}else{
									$html .= get_the_post_thumbnail(get_the_ID(),'thumb_80x80');
								}
								$html .='
									<div class="thumbnail-hoverlay main-color-1-bg"></div>
									<div class="thumbnail-hoverlay-icon"><i class="fa fa-search"></i></div>
								</div>
							</a>
						</div>';
					}
					$html .='<div class="app-details item-content">
						<h5><a href="'.get_permalink(get_the_ID()).'" title="'.the_title_attribute('echo=0').'" class="main-color-1-hover">'.the_title_attribute('echo=0').'</a></h5>
						<span>'.get_the_time(get_option('date_format'),get_the_ID()).'</span>
					</div>';
				$html .='<div class="clearfix"></div></div>';
			endwhile;
		endif;
		$html .='</div>';
		$html .= $after_widget;
		echo $html;
		wp_reset_postdata();
		$cache[$argsxx['widget_id']] = ob_get_flush();
		wp_cache_set('widget_app_recent_posts', $cache, 'widget');
	}
	
	function flush_widget_cache() {
		wp_cache_delete('widget_custom_type_posts', 'widget');
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['ids'] = strip_tags($new_instance['ids']);
		$instance['tags'] = strip_tags($new_instance['tags']);
        $instance['cats'] = strip_tags($new_instance['cats']);
		$instance['post_type'] = $new_instance['post_type'];
		$instance['number'] = absint($new_instance['number']);
		return $instance;
	}
	
	
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$ids = isset($instance['ids']) ? esc_attr($instance['ids']) : '';
		$cats = isset($instance['cats']) ? esc_attr($instance['cats']) : '';
		$tags = isset($instance['tags']) ? esc_attr($instance['tags']) : '';
		$post_type = isset($instance['post_type']) ? esc_attr($instance['post_type']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','leafcolor'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
      	<!-- /**/-->        
        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:','leafcolor'); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

      	<!-- /**/-->
        <p>
          <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post type','leafcolor'); ?></label> 
          <select name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>">
              <option value="post" <?php if($post_type=='post'){?> selected="selected"<?php }?>><?php _e('Post','leafcolor'); ?></option>
              <option value="app_portfolio" <?php if($post_type=='app_portfolio'){?> selected="selected"<?php }?>><?php _e('Portfolio','leafcolor'); ?></option>
              <option value="product" <?php if($post_type=='product'){?> selected="selected"<?php }?>><?php _e('Product','leafcolor'); ?></option>
            </select>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('ids'); ?>"><?php _e('ID list show:','leafcolor'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('ids'); ?>" name="<?php echo $this->get_field_name('ids'); ?>" type="text" value="<?php echo $ids; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e('Tags:','leafcolor'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('tags'); ?>" name="<?php echo $this->get_field_name('tags'); ?>" type="text" value="<?php echo $tags; ?>" />
        </p>
		<!--//-->
         <p>
            <label for="<?php echo $this->get_field_id('cats'); ?>" class="app-cat-widget"><?php _e('Categories:','leafcolor');?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('cats'); ?>" name="<?php echo $this->get_field_name('cats'); ?>" type="text" value="<?php echo $cats; ?>" />
        </p>
<?php
	}
}

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget("App_Recent_Posts");' ) );
?>