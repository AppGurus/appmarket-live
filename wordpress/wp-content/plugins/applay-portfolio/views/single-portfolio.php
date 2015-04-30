<?php
get_header();
?>
<?php get_template_part( 'header', 'heading' );
$content_padding = get_post_meta(get_the_ID(),'port-ctpadding',true);
$port_sidebar = get_post_meta(get_the_ID(),'port_sidebar',true);
if(function_exists('ot_get_option') && $port_sidebar==''){
	$port_sidebar =  ot_get_option('portfolio_layout','right');
}
?>  
<div class="container">
    <?php if($content_padding!='off'){ ?>
    <div class="content-pad-3x">
    <?php }?>
	<div class="row">
            <div id="content" class="<?php echo $port_sidebar!='full'?'col-md-9':'col-md-12' ?><?php echo ($port_sidebar == 'left') ? " revert-layout":"";?>">
                        <article class="single-post-content portfolio single-content">
                        	<?php
							// The Loop
							while ( have_posts() ) : the_post();
							$devide = get_post_meta($post->ID,'devide',true);
							$orientation ='';
							if($devide!='def_themeoption' && $devide!='def' && $devide!='' ){
								$devide_color = get_post_meta($post->ID,'devide_color_'.$devide,true);
								$orientation = get_post_meta($post->ID,'orientation',true);
							}elseif($devide=='def_themeoption' || $devide==''){
								$devide = ot_get_option('devide','iphone5s');
								$devide_color = ot_get_option('devide_color_'.$devide,'silver');
								if($devide!='def'){
								$orientation = ot_get_option('orientation','0');
								}
							}

								?>
                                <div class="images-scr <?php if($orientation=='1'){ echo 'landscape-screenshot';} ?>">
                                
                                    <?php
                                        $images = get_post_meta(get_the_ID(),'app_screen_image',true);
										$images = explode(",", $images);
                                        $attachment_count =count($images);
                                        if ( has_post_thumbnail() || $attachment_count > 0) {
                                
                                            $image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
                                            $image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
                                            $image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
                                                'title' => $image_title
                                                ) );
                                            ?>
                                            <?php 
                                            if ( $attachment_count > 0 ) {
                                                if(class_exists('iAppShowcase') && $devide!='def'){
                                                    $devide_item = array(
                                                        'devide' => get_post_meta($post->ID,'devide',true),
                                                        'devide_color_'.get_post_meta($post->ID,'devide',true) => get_post_meta($post->ID,'devide_color_'.get_post_meta($post->ID,'devide',true),true),
                                                        'orientation' => get_post_meta($post->ID,'orientation',true),
                                                        'content' => 'carousel',
                                                        'content_carousel' => implode(',',$images),
                                                    );
                                                    echo iAppShowcase::ias_devide($devide_item);
                                                }else{
                                                ?>
                                                <div class="is-carousel single-carousel post-gallery content-image carousel-has-control product-ct" id="post-gallery-<?php the_ID() ?>" data-navigation=1>
                                                <?php
                                                    wp_enqueue_style( 'lightbox2', get_template_directory_uri() . '/js/colorbox/colorbox.css');
                                    wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/js/colorbox/jquery.colorbox-min.js', array('jquery'), '', true );
                                                foreach($images as $attachment_id){
                                                    $image_custom = wp_get_attachment_image_src( $attachment_id, 'shop_single' ); ?>
                                                    <div class="single-gallery-item single-gallery-item-<?php echo $attachment_id ?>">
                                                        <a href="<?php echo get_permalink($attachment_id); ?>" class="colorbox-grid" data-rel="post-gallery-<?php the_ID() ?>" data-content=".single-gallery-item-<?php echo $attachment_id ?>">
                                                        <img src='<?php echo $image_custom[0]; ?>'>
                                                        </a>
                                                        <div class="hidden">
                                                            <div class="popup-data dark-div">
                                                                <?php $thumbnail = wp_get_attachment_image_src($attachment_id,'full', true); ?>
                                                                <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                                                <div class="popup-data-content">
                                                                    <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
                                                                    <div><?php the_excerpt(); ?></div>
                                                                    <a class="btn btn-default" href="javascript:void(0)" data-toggle="collapse" data-target="#share-in-popup-<?php echo $attachment_id;?>"><?php _e('SHARE','leafcolor'); ?> <i class="fa fa-share"></i></a>
                                                                    <a href="<?php echo get_permalink($attachment_id); ?>#comment" class="btn btn-default popup-gallery-comment" title="<?php _e('View comments','leafcolor'); ?>"><?php _e('COMMENTS','leafcolor'); ?></a>
                                                                    <div id="share-in-popup-<?php echo $attachment_id;?>" class="popup-share collapse">
                                                                        <ul class="list-inline social-light">
                                                                            <?php leafcolor_social_share($attachment_id); ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!--/hidden-->
                                                    </div>
                                                <?php }//foreach attachments ?>
                                                </div><!--/is-carousel-->
                                                <?php
                                                }//else class exists
                                            }
                                        } else {
                                            echo get_the_post_thumbnail( get_the_ID(), 'full' ); ;
                                        }
                                    ?>
                                
                                </div>
								
                                <div class="info-app summary entry-summary <?php if($orientation=='1'){ echo 'landscape-screenshot';} ?>">
                                <h2 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h2>
                                <?php
                                $author = get_post_meta(get_the_ID(),'port-author-name',true);
                                $release = get_post_meta(get_the_ID(),'port-release',true);
                                $version = get_post_meta(get_the_ID(),'port-version',true);
                                $requirement = get_post_meta(get_the_ID(),'port-requirement',true);
                                if($author || $release || $version || $requirement){
                                $col = get_post_meta(get_the_ID(),'orientation',true)?3:6; ?>
                                <div class="app-meta">
                                    <div class="row">
                                        <?php if($author){ ?>
                                        <div class="col-md-<?php echo $col ?>">
                                            <div class="media">
                                                <div class="pull-left"><i class="fa fa-user"></i></div>
                                                <div class="media-body">
                                                    <?php _e('Author','leafcolor') ?>
                                                    <div class="media-heading"><?php echo $author ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } 
                                        if($release){ ?>
                                        <div class="col-md-<?php echo $col ?>">
                                            <div class="media">
                                                <div class="pull-left"><i class="fa fa-calendar"></i></div>
                                                <div class="media-body">
                                                    <?php _e('Release','leafcolor') ?>
                                                    <div class="media-heading"><?php echo $release ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } 
                                        if($version){ ?>
                                        <div class="col-md-<?php echo $col ?>">
                                            <div class="media">
                                                <div class="pull-left"><i class="fa fa-tag"></i></div>
                                                <div class="media-body">
                                                    <?php _e('Version','leafcolor') ?>
                                                    <div class="media-heading"><?php echo $version ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } 
                                        if($requirement){ ?>
                                        <div class="col-md-<?php echo $col ?>">
                                            <div class="media">
                                                <div class="pull-left"><i class="fa fa-check-square-o"></i></div>
                                                <div class="media-body">
                                                    <?php _e('Requirement','leafcolor') ?>
                                                    <div class="media-heading"><?php echo $requirement ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <a class="single_add_to_cart_button btn btn-primary btn-lg btn-block" href="#top"><i class="fa fa-download"></i> <?php _e('Download now','leafcolor'); ?></a>
                                </div><!--end info-->
                                <?php } ?>
                                <div class="clearfix"></div>
                                <div class="single-post-content-text content-pad">
                                    <?php the_content();?>
                                </div>
                                <?php
                                $pagiarg = array(
                                    'before'           => '<div class="single-post-pagi">'.__( 'Pages:','leafcolor'),
                                    'after'            => '</div>',
                                    'link_before'      => '<span type="button" class="btn btn-default btn-sm">',
                                    'link_after'       => '</span>',
                                    'next_or_number'   => 'number',
                                    'separator'        => ' ',
                                    'nextpagelink'     => __( 'Next page','leafcolor'),
                                    'previouspagelink' => __( 'Previous page','leafcolor'),
                                    'pagelink'         => '%',
                                    'echo'             => 1
                                );
                                wp_link_pages($pagiarg); ?>
                                <div class="clearfix"></div>
                                <div class="item-meta single-post-meta content-pad">
                                    <?php if(ot_get_option('port_author_info')!='off'){ ?>
                                    <div class="media">
                                        <div class="pull-left"><i class="fa fa-user"></i></div>
                                        <div class="media-body">
                                            <?php _e('Author','leafcolor') ?>
                                            <div class="media-heading"><?php the_author_posts_link(); ?></div>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <?php if(ot_get_option('port_published_date')!='off'){ ?>
                                    <div class="media">
                                        <div class="pull-left"><i class="fa fa-calendar"></i></div>
                                        <div class="media-body">
                                            <?php _e('Published','leafcolor') ?>
                                            <div class="media-heading"><?php the_time(get_option('date_format')); ?></div>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <?php if(ot_get_option('port_categories')!='off'){ ?>
                                    <div class="media">
                                        <div class="pull-left"><i class="fa fa-bookmark"></i></div>
                                        <div class="media-body">
                                            <?php _e('Categories','leafcolor') ?>
                                            <div class="media-heading"><?php the_category(' <span class="dot">.</span> '); ?></div>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <?php if(ot_get_option('port_single_tags')!='off' && has_tag()){ ?>
                                    <div class="media">
                                        <div class="pull-left"><i class="fa fa-tags"></i></div>
                                        <div class="media-body">
                                            <?php _e('Tags','leafcolor') ?>
                                            <div class="media-heading"><?php the_tags('', ', ', ''); ?></div>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <?php if(ot_get_option('port_cm_count')!='off'){ ?>
                                    <?php if(comments_open()){ ?>
                                    <div class="media">
                                        <div class="pull-left"><i class="fa fa-comment"></i></div>
                                        <div class="media-body">
                                            <?php _e('Comment','leafcolor') ?>
                                            <div class="media-heading"><a href="#comment"><?php comments_number(__('0 Comments','leafcolor'),__('1 Comment','leafcolor')); ?></a></div>
                                        </div>
                                    </div>
                                    <?php } //check comment open?>
                                    <?php }?>
                                </div>
                                <ul class="list-inline social-light single-post-share">
                                    <?php leafcolor_social_share(); ?>
                                </ul>
                                <?php
							endwhile;
							?>
                        </article>
                        <?php if(ot_get_option('port_enable_author')!='off'){ ?>
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
								<h4><?php the_author_posts_link(); ?></h4>
								<?php the_author_meta('description'); ?>
							</div>
							<div class="clearfix"></div>
						</div><!--/about-author-->
                        <?php }?>
                        <?php comments_template( '', true ); ?>
            </div>
            <?php
                if($port_sidebar != 'full'){ get_sidebar();}
            ?>
	</div>
     <?php if($content_padding!='off'){ ?>
     </div><!--/content-pad-3x-->
     <?php }?>
</div>
<?php get_template_part( 'body', 'bottom' ); // load body-bottom.php ?>
<?php get_template_part( 'main', 'bottom' ); // load main-bottom.php ?>
</div>
<?php get_footer(); ?>