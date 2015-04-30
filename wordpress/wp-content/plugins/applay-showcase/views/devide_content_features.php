<?php global $global_devide_item;

$autoplay = $global_devide_item['features_autoplay']==='0'?'false':($global_devide_item['features_autoplay']?$global_devide_item['features_autoplay']:'3500');
?>
<div class="ias-devide-content ias-devide-content-features">
    <div class="is-ias-carousel single-carousel ias-features-carousel" data-autoplay="<?php echo $autoplay; ?>" data-autoheight=false data-features-id=<?php echo $global_devide_item['features_id']; ?>>
    <?php
    $carousel = $global_devide_item['screen_item'];
    foreach( $carousel as $carousel_item){
		echo $carousel_item['screen_url']?'<a href="'.$carousel_item['screen_url'].'" title="'.$carousel_item['title'].'">':''; ?>
        <img src="<?php echo $carousel_item['screen_image'] ?>" alt="<?php echo $carousel_item['title'] ?>"/>
    	<?php echo $carousel_item['screen_url']?'</a>':''; 
	} ?>
    </div>
</div>