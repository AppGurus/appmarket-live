<?php global $global_devide_item ?>
<div class="ia-ipad ias-devide <?php echo $global_devide_item['devide_color_ipadmini']?$global_devide_item['devide_color_ipadmini']:'silver'; echo $global_devide_item['orientation']?' landscape':''; ?>">
    <div class="device">
        <div class="inner"></div>
        <div class="camera"></div>
        <div class="screen">
        	<?php echo iAppShowcase::ias_devide_content($global_devide_item); ?>
        </div>
        <div class="home"></div>
    </div>
</div>