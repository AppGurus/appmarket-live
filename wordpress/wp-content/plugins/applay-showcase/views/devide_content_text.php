<?php global $global_devide_item; ?>
<div class="ias-devide-content ias-devide-content-text">
	<?php
	echo $global_devide_item['devide_url']?'<a href="'.$global_devide_item['devide_url'].'" title="'.$global_devide_item['title'].'">':'';
	echo apply_filters('the_content', $global_devide_item['content_text']);
	echo $global_devide_item['devide_url']?'</a>':'';
	?>
</div>