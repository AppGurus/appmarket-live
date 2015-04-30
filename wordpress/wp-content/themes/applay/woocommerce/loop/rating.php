<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>
<?php 
$type = $product->product_type;
if($type=='variable'){
	$price_html = $product->get_price(); ?>
		<span class="price"><?php _e('From  ','leafcolor') ?><?php  echo get_woocommerce_currency_symbol(); echo $price_html; ?></span>
	<?php 
}else{
	if ( $price_html = $product->get_price_html() ) : ?>
		<span class="price"><?php echo $price_html; ?></span>
	<?php endif; 	
}
?>

<?php
if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
	return;
?>

<?php if ( $rating_html = $product->get_rating_html() ) : ?>
	<?php echo $rating_html; ?>
<?php endif; ?>