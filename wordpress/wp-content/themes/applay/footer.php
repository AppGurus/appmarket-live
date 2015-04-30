<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 */
?>
		<div id="bottom-sidebar">
            <div class="container">
                <div class="row normal-sidebar">
                    <?php
                    if ( is_active_sidebar( 'bottom_sidebar' ) ) :
                        dynamic_sidebar( 'bottom_sidebar' );
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <footer class="dark-div main-color-2-bg <?php if(ot_get_option('fixed_footer')!='off'){ ?> fixed-effect <?php }?>">
        	<div class="footer-inner fixed-effect-inner">
        	<section id="bottom">
            	<div class="section-inner">
                	<div class="container">
                    	<div class="row normal-sidebar">
							<?php
                            if ( is_active_sidebar( 'footer_sidebar' ) ) :
                                dynamic_sidebar( 'footer_sidebar' );
                            endif;
                            ?>
                		</div>
                    </div>
                </div>
            </section>
            <div id="bottom-nav">
                <div class="container">
                	<?php if(ot_get_option('off_gototop')!='off'){?>
                    <div class="text-center back-to-top-wrap">
                        <a class="back-to-top main-color-2-bg" href="#top" title="<?php _e('Go to top','leafcolor'); ?>"><i class="fa fa-angle-double-up"></i></a>
                    </div>
                    <?php }?>
                    <div class="row footer-content">
                        <div class="copyright col-md-6">
							<?php if(ot_get_option('copyright')){
                                echo ot_get_option('copyright');
                            }else{
                                _e('Applay WordPress Theme by Leafcolor &copy;','leafcolor');
                            }?>
                        </div>
                        <nav class="col-md-6 footer-social">
                        	<?php 
							$social_account = array(
								'facebook',
								'twitter',
								'linkedin',
								'tumblr',
								'google-plus',
								'pinterest',
								'youtube',
								'flickr',
							);
							?>
                            <ul class="list-inline pull-right social-list">
                            	<?php 
								$social_link_open = ot_get_option('social_link_open');
								foreach($social_account as $social){
									if($link = ot_get_option('acc_'.$social,false)){ ?>
                                            <li><a href="<?php echo esc_url($link) ?>" <?php if($social_link_open=='on'){?>target="_blank" <?php }?> class="btn btn-default social-icon"><i class="fa fa-<?php echo esc_attr($social) ?>"></i></a></li>
								<?php }
								}//foreach
								if($custom_acc = ot_get_option('custom_acc')){
									foreach($custom_acc as $a_social){ ?>
										<li><a href="<?php echo esc_url($a_social['link']) ?>" <?php if($social_link_open=='on'){?>target="_blank" <?php }?> class="btn btn-default social-icon"><i class="fa <?php echo esc_attr($a_social['icon']) ?>"></i></a></li>
									<?php }
								}
								?>
                            </ul>
                        </nav>
                    </div><!--/row-->
                </div><!--/container-->
            </div>
            </div>
        </footer><!--/footer-inner-->
        </div><!--wrap-->
    </div><!--/body-wrap-->
    <div class="mobile-menu-wrap dark-div <?php if(ot_get_option('nav_style',false)){?> <?php }else{?> visible-xs <?php }?>">
        <a href="#" class="mobile-menu-toggle"><i class="fa fa-times"></i></a>
        <ul class="mobile-menu">
            <?php
				if(has_nav_menu( 'off-canvas-menus' )){
					  wp_nav_menu(array(
						  'theme_location'  => 'off-canvas-menus',
						  'container' => false,
						  'items_wrap' => '%3$s',
					  ));
				}elseif(has_nav_menu( 'primary-menus' )){
                    wp_nav_menu(array(
                        'theme_location'  => 'primary-menus',
                        'container' => false,
                        'items_wrap' => '%3$s',
                    ));	
                }else{?>
                    <li><a href="<?php echo home_url(); ?>"><?php _e('Home','leafcolor') ?></a></li>
                    <?php wp_list_pages('depth=1&number=4&title_li=' ); ?>
            <?php } ?>
            <?php if(ot_get_option('enable_search')!='off'){ ?>
            <li><a href="#" class="search-toggle"><i class="fa fa-search"></i></a></li>
            <?php } ?>
        </ul>
    </div>
	<?php if(ot_get_option('enable_search')!='off'){ ?>
    <div id="off-canvas-search" class="dark-div">
    	<div class="search-inner">
        <div class="container">
            <form action="<?php echo home_url() ?>">
                <input type="text" name="s" id="s" class="form-control search-field font-2" placeholder="<?php _e('TYPE AND HIT ENTER...','leafcolors') ?>" autocomplete="off">
                <a href="#" class="search-toggle"><i class="fa fa-times"></i></a>
            </form>
        </div>
        </div>
    </div>
	<?php } //if search ?>
    
<?php echo ot_get_option('google_analytics_code', ''); ?>    
<?php wp_footer(); ?>
</body>
</html>
