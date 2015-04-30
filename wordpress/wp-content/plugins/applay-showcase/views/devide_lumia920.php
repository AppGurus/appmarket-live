<?php global $global_devide_item ?>
<div class="ia-lumia920 ias-devide <?php echo $global_devide_item['devide_color_lumia920']?$global_devide_item['devide_color_lumia920']:'yellow'; echo $global_devide_item['orientation']?' landscape':''; ?>">
    <div class="device">
        <div class="camera"></div>
        <div class="button"></div>
        <div class="lock"></div>
        <div class="speaker"></div>
        <div class="inner"></div>
        <div class="screen">
        	<?php echo iAppShowcase::ias_devide_content($global_devide_item); ?>
        </div>
    </div>
</div>