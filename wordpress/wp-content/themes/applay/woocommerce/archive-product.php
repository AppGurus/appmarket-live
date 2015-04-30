<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$layout = get_post_meta(get_option('woocommerce_shop_page_id'),'sidebar_layout',true);
$content_padding = get_post_meta(get_option('woocommerce_shop_page_id'),'content_padding',true);
if($layout==''){
	$layout =  ot_get_option('page_layout');
} 
get_header( 'shop' ); ?>
<?php get_template_part( 'header', 'heading' ); ?>  
<div class="container">
	<?php if($content_padding!='off'){ ?>
    <div class="content-pad-3x">
    <?php }?>
	<div class="row">
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		//do_action( 'woocommerce_before_main_content' );
	?>
		<div id="content" class="<?php if($layout != 'full' && $layout != 'true-full'){?> col-md-9 <?php }else{ ?>col-md-12 <?php } if($layout == 'left'){ ?> revert-layout <?php }?>">
		<?php // if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<?php
			if(class_exists('WCV_Vendor_Shop')){
				 WCV_Vendor_Shop::shop_description();
			}?>
			<!--<h1 class="page-title"><?php // woocommerce_page_title(); ?></h1>-->

		<?php //endif; ?>

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
	</div>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		//do_action( 'woocommerce_after_main_content' );
	?>
	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		if($layout != 'full' && $layout != 'true-full'){do_action( 'woocommerce_sidebar' );}
	?>
	</div>
    <?php if($content_padding!='off'){ ?>
    </div><!--/content-pad-3x-->
    <?php }?>
</div>
<?php get_footer( 'shop' ); ?>