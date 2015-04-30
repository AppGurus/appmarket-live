<?php
global $post;

global $global_showcase_count;
$global_showcase_count = $global_showcase_count?$global_showcase_count:0;
$global_showcase_count++;

$ias_style = get_post_meta($post->ID,'ias_style',true);
?>
<section class="iapp-showcase iapp-showcase-<?php echo $global_showcase_count; ?> showcase-style-<?php echo $ias_style; echo $ias_style=='listing'?' is-ias-carousel':'';?>">
<h2 class="hidden hide"><?php echo get_the_title($post->ID); ?></h2>
<?php
if($ias_style=='listing'){
	if($hero_devide = get_post_meta($post->ID,'hero_devide',true)){
		foreach($hero_devide as $devide_item){
			echo iAppShowcase::ias_devide($devide_item);
		}
	}
}elseif($ias_style=='hero'){
	echo '<div class="row">';
	if($hero_devide = get_post_meta($post->ID,'hero_devide',true)){
		if(count($hero_devide)==1){
			$col=12;
		}elseif(count($hero_devide)==2){
			$col=6;
		}elseif(count($hero_devide)==3){
			$col=4;
		}elseif(count($hero_devide)==6){
			$col=3;
		}else{
			$col=3;
		}
		foreach($hero_devide as $devide_item){
			echo '<div class="col-xs-'.$col.' hero-col">';
			echo iAppShowcase::ias_devide($devide_item);
			echo '</div>';
		}
	};
	echo '</div>';
}elseif($ias_style=='features'){
	$features_devide = array(
		'features_id' => $global_showcase_count,
		'devide' => get_post_meta($post->ID,'features_devide',true),
		'devide_color_'.get_post_meta($post->ID,'features_devide',true) => get_post_meta($post->ID,'features_devide_color_'.get_post_meta($post->ID,'features_devide',true),true),
		'content' => 'features',
		'features_autoplay' => get_post_meta($post->ID,'features_autoplay',true),
		'screen_item' => get_post_meta($post->ID,'screen_item',true),
	);
	if($features_devide){ ?>
    <div class="row">
    	<div class="col-md-4 col-md-push-4 col-sm-6 col-xs-7 feature-col feature-col-devide">
        	<?php echo iAppShowcase::ias_devide($features_devide); ?>
        </div>
    	<div class="col-md-4 col-md-pull-4 col-sm-6 col-xs-5 feature-col feature-col-text">
        <?php
		$count = 0;
		$second_path = '';
		foreach($features_devide['screen_item'] as $features_item){ ?>
        	<div class="features-control-item features-control-item-<?php echo $count ?> <?php echo $count%2==1?'visible-sm visible-xs':''; ?>" data-features-item=<?php echo $count ?> >
                <div class="media">
                    <div class="pull-left">
                        <div class="ia-icon">
                            <i class="fa <?php echo $features_item['feature_icon'] ?>"></i>
                        </div>
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading"><?php echo $features_item['title'] ?></h3>
                        <p class="hidden-xs"><?php echo $features_item['feature_description'] ?></p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div><!--/features-control-item-->
			<?php
			if($count%2==1){
				ob_start(); ?>
				<div class="features-control-item features-control-item-<?php echo $count ?>" data-features-item=<?php echo $count ?> >
                	<div class="media">
                        <div class="pull-right">
                            <div class="ia-icon">
                                <i class="fa <?php echo $features_item['feature_icon'] ?>"></i>
                            </div>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="media-heading"><?php echo $features_item['title'] ?></h3>
                            <p class="hidden-xs"><?php echo $features_item['feature_description'] ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
				</div><!--/features-control-item-->
				<?php 
				$output_string = ob_get_contents();
				ob_end_clean();
				$second_path .= $output_string;
			}//if %2=1
			$count++;
		}?>
        </div>
        <div class="col-md-4 hidden-sm hidden-xs second-features-col">
        	<?php echo $second_path; ?>
        </div>
    </div>
	<?php
	};
}elseif($ias_style=='layer'){
	$layer = array(
		'layers_id' => $global_showcase_count,
		//'devide' => get_post_meta($post->ID,'features_devide',true),
		'content' => 'layers',
		'screen_item' => get_post_meta($post->ID,'screen_item',true),
	);
	?>
    <?php echo iAppShowcase::ias_devide_content($layer); ?>
<?php }
?>
</section>