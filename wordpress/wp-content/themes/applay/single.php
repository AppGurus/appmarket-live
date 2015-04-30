<?php 
global $global_page_layout;
$single_page_layout = get_post_meta(get_the_ID(),'sidebar_layout',true);
$content_padding = get_post_meta(get_the_ID(),'content_padding',true);
$layout = $single_page_layout ? $single_page_layout : ($global_page_layout ? $global_page_layout : ot_get_option('post_layout','right'));
$global_page_layout = $layout;
get_header();
?>
	<?php get_template_part( 'header', 'heading' ); ?>   
    <div id="body">
    	<div class="container">
        	<?php if($content_padding!='off'){ ?>
        	<div class="content-pad-3x">
            <?php }?>
                <div class="row">
                    <div id="content" class="<?php if($layout!='full'){ ?> col-md-9 <?php }else{ ?> col-md-12 <?php } if($layout == 'left'){ ?> revert-layout <?php }?>" role="main">
                        <article class="single-post-content single-content">
                        	<?php
							// The Loop
							while ( have_posts() ) : the_post();
								get_template_part('content','featured-image');
								echo '<h2 class="blog-title">'.get_the_title().'</h2>';
								get_template_part('content','single');
							endwhile;
							?>
                        </article>
                        <?php if(ot_get_option('enable_author')!='off'){ ?>
                        <div class="about-author">
							<div class="author-avatar">
								<?php 
								if(isset($_is_retina_)&&$_is_retina_){
										echo get_avatar( get_the_author_meta('email'), 100, get_template_directory_uri() . '/images/avatar-2x-retina.jpg' ); 
								}else{
										echo get_avatar( get_the_author_meta('email'), 100, get_template_directory_uri() . '/images/avatar-2x.jpg' ); 
								}?>
							</div>
							<div class="author-info">
								<h4 class="font-2"><?php the_author_posts_link(); ?></h4>
								<?php the_author_meta('description'); ?>
							</div>
							<div class="clearfix"></div>
						</div><!--/about-author-->
                        <?php }?>
                        <?php if(ot_get_option('single_navi')!='off'){ ?>
                        <div class="single-post-navigation">
                            <div class="row">
                            	<?php
								$p = get_adjacent_post(true, '', true);
								$n = get_adjacent_post(true, '', false);
								?>
                                <div class="single-post-navigation-item col-md-6 col-sm-6 col-xs-6 <?php if(empty($n)){ ?> no-border <?php }?>">
                                <?php
									
                                    if(!empty($p)){ echo '<a href="' . get_permalink($p->ID) . '" title="' . esc_attr($p->post_title) . '" class="maincolor2hover">
                                    <div class="single-post-navigation-item-content">
                                        <h4 class="font-2"><i class="fa fa-angle-left"></i> &nbsp;' . $p->post_title . '</h4>
                                    </div>
									</a>';}
                                ?>
                                </div>
                                <div class="single-post-navigation-item col-md-6 col-sm-6 col-xs-6 <?php if(empty($n)){?> hidden <?php }?>">
                                <?php
									if(!empty($n)) echo '<a href="' . get_permalink($n->ID) . '" title="' . esc_attr($n->post_title) . '" class="maincolor2hover pull-right">
									<div class="single-post-navigation-item-content">
										<h4 class="font-2">' . $n->post_title . '&nbsp; <i class="fa fa-angle-right"></i></h4>
									</div>
									</a>';  
								?>
                                </div>
                            </div>
                        </div><!--/simple-nav-->
                        <?php }?>
                        <?php comments_template( '', true ); ?>
                    </div><!--/content-->
                    <?php if($layout != 'full'){get_sidebar();} ?>
                </div><!--/row-->
            <?php if($content_padding!='off'){ ?>
            </div><!--/content-pad-3x-->
            <?php }?>
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>