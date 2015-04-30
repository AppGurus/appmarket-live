<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;
?>
<div class="content-pad social-product">
    <ul class="list-inline social-light">
        <?php leafcolor_social_share(); ?>
    </ul>
</div>

<?php
if ( $products->have_posts() ) : ?>

	<div class="related-product">

		<h3><?php _e( 'Related Products', 'woocommerce' ); ?></h3>
		<div class="ev-content">
		<?php woocommerce_product_loop_start();
		$count_item = count($products);
		$i=0;
		 ?>
			<div class="row">
			<?php while ( $products->have_posts() ) : $products->the_post();
			$i++;
			 ?>
				<div class="col-sm-4 related-item">
					<?php if(has_post_thumbnail(get_the_ID())){ ?> 
                    		<div class="thumb"><a href="<?php echo esc_url(get_permalink(get_the_ID()))?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'thumb_80x80' ); ?></a></div>
                        <?php }?>
                        <div class="ev-title item-content"> <a class="main-color-1-hover" href="<?php echo esc_url(get_permalink(get_the_ID()))?>"><?php echo get_the_title(get_the_ID()); ?></a></div>
                        <div><?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?></div>
                        <div class="clear"></div>
				</div>
                 <?php  
				  //if(($i%3==0) && ($count_item > $i)){?>
					  <!--</div><div class="row">-->
                  <?php // }?>
			<?php endwhile; // end of the loop. ?>
			</div>
		<?php woocommerce_product_loop_end(); ?>
		</div>
	</div>

<?php endif;

wp_reset_postdata();
