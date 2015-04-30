<?php
wp_enqueue_style( 'lightbox2', get_template_directory_uri() . '/js/colorbox/colorbox.css');
wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/js/colorbox/jquery.colorbox-min.js', array('jquery'), '', true );
global $global_devide_item_count;
$global_devide_item_count = $global_devide_item_count?$global_devide_item_count:0;
$global_devide_item_count++;

$autoplay = $global_devide_item['content_carousel_autoplay']==='0'?'false':($global_devide_item['content_carousel_autoplay']?$global_devide_item['content_carousel_autoplay']:'6000');

?>
<div class="ias-devide-content ias-devide-content-carousel">
    <div class="is-ias-carousel single-carousel" data-autoplay="<?php echo $autoplay; ?>" data-autoheight=false >
    <?php global $global_devide_item;
	if(!is_array($global_devide_item['content_carousel'])){
		$carousel = explode(',', $global_devide_item['content_carousel']);
	}else{
		$carousel = $global_devide_item['content_carousel'];
	}
    
    foreach( $carousel as $carousel_item){
		if(!is_numeric($global_devide_item['content_carousel'][0])){
			$item_custom = $carousel_item;
			$carousel_item = rand(0, 100000);
		}
		echo '<div class="is-ias-carousel-item color-item-'.$global_devide_item_count.$carousel_item.'">';
		echo $global_devide_item['devide_url']?'<a href="'.$global_devide_item['devide_url'].'" title="'.$global_devide_item['title'].'">':'<a href="#" class="colorbox-grid" data-rel="post-gallery-'.$global_devide_item_count.'" data-content=".color-item-'.$global_devide_item_count.$carousel_item.'">'; ?>
        <?php 
		if(is_numeric($global_devide_item['content_carousel'][0])){
			$thumbnail = wp_get_attachment_image_src($carousel_item,'full', true); 
		}else{
			$thumbnail[0] = $item_custom;
			$thumbnail[2] = $thumbnail[1]='';
		}?>
        <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" alt="<?php the_title_attribute(); ?>">
    	<?php echo $global_devide_item['devide_url']?'</a>':'</a>';
			if(!$global_devide_item['devide_url']){
		?>
        	<div class="hidden">
                <div class="popup-data dark-div">
                    <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                    <div class="popup-data-content">
                    	<?php if(is_numeric($global_devide_item['content_carousel'][0])){ ?>
                        <h5><a href="<?php echo get_permalink($carousel_item); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title($carousel_item); ?></a></h5>
                        <?php } ?>
                    </div>
                </div>
            </div><!--/hidden-->
	<?php }
		echo '</div>';
	} ?>
    </div>
</div>