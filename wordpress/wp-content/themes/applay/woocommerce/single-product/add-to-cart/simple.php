<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product;

if ( ! $product->is_purchasable() ) return;
?>

<?php
	// Availability
	$availability = $product->get_availability();

	if ( $availability['availability'] )
		echo apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>', $availability['availability'] );
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>
	 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	 	<?php
		$woo_listing_mode = get_post_meta(get_the_ID(),'product-mode',true);
		if($woo_listing_mode==''){
			$woo_listing_mode = ot_get_option('woo_listing_mode');
		}
        if($woo_listing_mode!='on'){
	 		if ( ! $product->is_sold_individually() )
	 			woocommerce_quantity_input( array(
	 				'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
	 				'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
	 			) );
		}
	 	?>

	 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
		<?php
        if($woo_listing_mode!='on'){
		?>
	 	<button type="submit" class="single_add_to_cart_button btn btn-primary btn-lg btn-block"><i class="fa fa-shopping-cart"></i> <?php echo $product->single_add_to_cart_text(); ?></button>
		<?php }else{
			$app_link = get_post_meta(get_the_ID(),'store-link-apple',true);
			$gg_link = get_post_meta(get_the_ID(),'store-link-google',true);
			$win_link = get_post_meta(get_the_ID(),'store-link-windows',true);
			if(($app_link =='' && $gg_link =='')){
				$link_dl = $win_link;
			}else if(($app_link =='' && $win_link =='')){
				$link_dl = $gg_link;
			}else if(($gg_link =='' && $win_link =='')){
				$link_dl = $app_link;
			}else{
				$link_dl = '#top';
			}
		?>
        <a class="single_add_to_cart_button btn btn-primary btn-lg btn-block" href="<?php echo $link_dl;?>" <?php if($link_dl != '#top'){?>  target="_blank" <?php }?>><i class="fa fa-download"></i> <?php _e('Download now','leafcolor'); ?></a>
        <?php } ?>
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>