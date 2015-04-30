<?php
global $page_title;
$ct_hd = get_post_meta(get_the_ID(),'header_content',true);
if(function_exists('is_shop') && is_shop()){
	$ct_hd ='';
	$id_ot = get_option('woocommerce_shop_page_id');
	if($id_ot!=''){
		$ct_hd = get_post_meta($id_ot,'header_content',true);
	}
}
if( is_home()){
	$ct_hd ='';
	$id_ot = get_option('page_for_posts');
	if($id_ot!=''){
		$ct_hd = get_post_meta($id_ot,'header_content',true);
	}
}
if(!is_page_template('page-templates/front-page.php') && $ct_hd==''){
$heading_bg = ot_get_option('heading_bg');
if($heading_bg){ ?>
<style scoped="scoped">
.page-heading{
	background-image:url(<?php echo esc_url($heading_bg['background-image']) ?>);
	background-color:<?php echo esc_attr($heading_bg['background-color']) ?>;
	background-position:<?php echo esc_attr($heading_bg['background-position']) ?>;
	background-repeat:<?php echo esc_attr($heading_bg['background-repeat']) ?>;
	background-size:<?php echo $heading_bg['background-size'] ?>;
	background-attachment:<?php echo esc_attr($heading_bg['background-attachment']) ?>;
}
</style>
<?php } //if heading_bg
if(is_singular('app_portfolio') || is_singular('product')){ ?>
    <div class="page-heading main-color-1-bg dark-div">
        <div class="container">
            <div class="row">
                <?php if($icon = get_post_meta(get_the_ID(),'app-icon',true)){ ?>
                <div class="col-md-2 col-sm-3 col-xs-12">
                    <img src="<?php echo esc_url($icon); ?>" class="icon-appport"/>
                </div>
                <?php }?>
                <div class="col-md-10 col-sm-9 col-xs-12">
                    <h1><?php echo esc_attr($page_title) ?></h1>
                    <div class="app-store-link">
                        <?php if($apple = get_post_meta(get_the_ID(),'store-link-apple',true)){ ?>
                        <a class="btn btn-default btn-store btn-store-apple" href="<?php echo esc_url($apple) ?>" target="_blank">
                            <i class="fa fa-apple"></i>
                            <div class="btn-store-text">
                                <span><?php _e("Download from","leafcolor") ?></span><br />
                                <?php _e("APP STORE","leafcolor") ?>
                            </div>
                        </a>
                        <?php }//if apple ?>
                        <?php if($google = get_post_meta(get_the_ID(),'store-link-google',true)){ ?>
                        <a class="btn btn-default btn-store btn-store-google" href="<?php echo esc_url($google) ?>" target="_blank">
                            <i class="fa fa-google"></i>
                            <div class="btn-store-text">
                                <span><?php _e("Download from","leafcolor") ?></span><br />
                                <?php _e("PLAY STORE","leafcolor") ?>
                            </div>
                        </a>
                        <?php }//if google ?>
                        <?php if($windows = get_post_meta(get_the_ID(),'store-link-windows',true)){ ?>
                        <a class="btn btn-default btn-store btn-store-windows" href="<?php echo esc_url($windows) ?>" target="_blank">
                            <i class="fa fa-windows"></i>
                            <div class="btn-store-text">
                                <span><?php _e("Download from","leafcolor") ?></span><br />
                                <?php _e("WINDOWS STORE","leafcolor") ?>
                            </div>
                        </a>
                        <?php }//if windows ?>
                        <?php if($file = get_post_meta(get_the_ID(),'app-port-file',true) && is_singular('app_portfolio')){ ?>
                        <a class="btn btn-default btn-store btn-store-file" href="<?php echo esc_url($file) ?>" target="_blank">
                            <i class="fa fa-download"></i>
                            <div class="btn-store-text">
                                <span><?php _e("Download","leafcolor") ?></span><br />
                                <?php _e("INSTALLATION FILE","leafcolor") ?>
                            </div>
                        </a>
                        <?php }//if file ?>
                    </div>
                </div>
            </div><!--/row-->
        </div><!--/container-->
    </div><!--/page-heading-->
    <?php
    $heading_bg = get_post_meta(get_the_ID(),'app-banner',true);
    $darkness = get_post_meta(get_the_ID(),'banner-darkness',true);
    if( $heading_bg || $darkness ){ ?>
        <style scoped="scoped">
        <?php if($heading_bg){ ?>
        .page-heading{
            background-image:url(<?php echo esc_url($heading_bg) ?>);
            background-position: center center;
            background-size: cover;
            background-attachment: fixed;
        }
        <?php }
        if($darkness){ ?>
        .page-heading:before{
            background:rgba(0,0,0,<?php echo esc_attr($darkness/100); ?>);
        }
        <?php } ?>
        </style>
    <?php } //if bg
}else{ ?>
<div class="page-heading main-color-1-bg dark-div">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <h1><?php echo esc_attr($page_title) ?></h1>
            </div>
            <?php if(is_active_sidebar('pathway_sidebar')){
                    echo '<div class="pathway pathway-sidebar col-md-4 col-sm-4 hidden-xs text-right">';
                        dynamic_sidebar('pathway_sidebar');
                    echo '</div>';
                }else{?>
            <div class="pathway col-md-4 col-sm-4 hidden-xs text-right">
                <?php if(function_exists('ia_breadcrumbs')){ ia_breadcrumbs(); } ?>
            </div>
            <?php } ?>
        </div><!--/row-->
    </div><!--/container-->
</div><!--/page-heading-->
<?php 
}//else product
}//if not front page ?>

<div class="top-sidebar">
    <div class="container">
        <div class="row">
            <?php
                if ( is_active_sidebar( 'top_sidebar' ) ) :
                    dynamic_sidebar( 'top_sidebar' );
                endif;
             ?>
        </div><!--/row-->
    </div><!--/container-->
</div><!--/Top sidebar-->