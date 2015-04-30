<?php global $global_devide_item; ?>
<div class="ias-devide-content ias-devide-content-image">
	<?php echo $global_devide_item['devide_url']?'<a href="'.$global_devide_item['devide_url'].'" title="'.$global_devide_item['title'].'">':''; ?>
	<img src="<?php echo $global_devide_item['content_image'] ?>" alt="<?php echo esc_attr($global_devide_item['title']) ?>" />
    <?php echo $global_devide_item['devide_url']?'</a>':''; ?>
</div>