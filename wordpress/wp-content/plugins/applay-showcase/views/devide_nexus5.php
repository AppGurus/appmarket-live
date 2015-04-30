<?php global $global_devide_item ?>
<div class="ia-nexus5 ias-devide <?php echo $global_devide_item['orientation']?'landscape':''; ?>">
    <div class="device">
        <div class="button"></div>
        <div class="lock"></div>
        <div class="camera"></div>
        <div class="inner"></div>
        <div class="screen">
        	<?php echo iAppShowcase::ias_devide_content($global_devide_item); ?>
        </div>
    </div>
</div>