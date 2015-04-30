<?php global $global_devide_item ?>
<div class="ia-s5 ias-devide <?php echo $global_devide_item['devide_color_galaxys5']?$global_devide_item['devide_color_galaxys5']:'white'; echo $global_devide_item['orientation']?' landscape':''; ?>">
    <div class="device">
        <div class="lock"></div>
        <div class="home"></div>
        <div class="camera"></div>
        <div class="speaker"></div>
        <div class="sensor"></div>
        <div class="inner"></div>
        <div class="screen">
        	<?php echo iAppShowcase::ias_devide_content($global_devide_item); ?>
        </div>
    </div>
</div>