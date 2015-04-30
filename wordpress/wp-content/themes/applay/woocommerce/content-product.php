<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>
<li <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			//do_action( 'woocommerce_before_shop_loop_item_title' );
		$icon = get_post_meta(get_the_ID(),'app-icon',true);
		if($listing_style = ot_get_option('woocommerce_listing_style',1)){
			if(has_post_thumbnail(get_the_ID())){
				echo '<div class="thumb item-thumbnail">
					<a href="'.esc_url(get_permalink(get_the_ID())).'" title="'.the_title_attribute('echo=0').'">
						<div class="item-thumbnail">
							'.get_the_post_thumbnail(get_the_ID(),'thumb_263x263').'
							<div class="thumbnail-hoverlay main-color-1-bg"></div>
							<div class="thumbnail-hoverlay-icon"><i class="fa fa-search"></i></div>
						</div>
					</a>
				</div>';
			}
		}else{//if listing style ?>
        	<div class="simple-thumbnail">
            	<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>">
                	<?php if($icon){
						if($icon_id = ia_get_attachment_id_from_url($icon)){
							$thumbnail = wp_get_attachment_image_src($icon_id,'thumb_263x263', true);
							$icon = isset($thumbnail[0])?$thumbnail[0]:$icon;
						} ?>
                        <img src="<?php echo esc_url($icon); ?>" width="263" height="263" class="app-icon-img" />
					<?php $icon = 0;
					}else{
						the_post_thumbnail(get_the_ID(),'thumb_263x263');
					}?>
                </a>
            </div>
		<?php }//if listing style ?>
		<div class="item-content <?php if($icon){ ?> has-icon <?php }?>">
        	<?php if($icon){
			if($icon_id = ia_get_attachment_id_from_url($icon)){
				$thumbnail = wp_get_attachment_image_src($icon_id,'thumbnail', true);
				$icon = isset($thumbnail[0])?$thumbnail[0]:$icon;
			}
			?>
            <div class="app-icon">
            	<a href="<?php the_permalink(get_the_ID()) ?>" title="<?php the_title_attribute()?>">
                	<img src="<?php echo esc_url($icon); ?>" width="60" height="60" />
                </a>
            </div>
            <?php }?>
			<h4 class="product-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute() ?>" class="main-color-1-hover"><?php the_title(); ?></a></h4>
            <?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );
			?>
        </div>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</li>