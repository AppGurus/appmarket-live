<?php
wp_enqueue_style( 'lightbox2', get_template_directory_uri() . '/js/colorbox/colorbox.css');
wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/js/colorbox/jquery.colorbox-min.js', array('jquery'), '', true );

global $global_devide_item;

global $global_devide_item_count;
$global_devide_item_count = $global_devide_item_count?$global_devide_item_count:0;
$global_devide_item_count++;
?>
<div class="ias-content-layers">
	<div class="ias-content-layers-inner">
    <?php
    $items = $global_devide_item['screen_item'];
	$count = count($items)+1;
    foreach( $items as $layer){
		$zindex = $count--;
		?>
        <div class="ias-layer-item ias-layer-item-<?php echo $zindex ?> ias-layer-popup-<?php echo $zindex.$global_devide_item_count; ?>" style="z-index:<?php echo $zindex ?>;">
        	<a href="<?php echo $layer['screen_url']?$layer['screen_url']:'#' ?>" title="<?php $layer['title'] ?>"
            <?php echo $layer['screen_url']?'':'class="colorbox-grid" data-rel="layers-gallery-'.$global_devide_item_count.'" data-content=".ias-layer-popup-'.$zindex.$global_devide_item_count.'"'; ?> >
            	<img src="<?php echo $layer['screen_image'] ?>" alt="<?php echo esc_attr($layer['title']) ?>" />
            </a>
            <div class="hidden">
                <div class="popup-data dark-div">
                    <img src="<?php echo $layer['screen_image'] ?>"  alt="<?php echo esc_attr($layer['title']) ?>"/>
                </div>
            </div><!--/hidden-->
        </div>
        <div class="clearfix"></div>
	<?php } ?>
    </div>
</div>