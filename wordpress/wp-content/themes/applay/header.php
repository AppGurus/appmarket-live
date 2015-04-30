<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0">
<?php if(ot_get_option('favicon')):?>
<link rel="shortcut icon" type="ico" href="<?php echo esc_url(ot_get_option('favicon'));?>">
<?php endif;?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if(ot_get_option('favicon')):?>
<link rel="shortcut icon" type="ico" href="<?php echo esc_url(ot_get_option('favicon'));?>">
<?php endif;?>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<!--[if lte IE 9]>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" />
<![endif]-->
<?php if(ot_get_option('retina_logo')):?>
<style type="text/css" >
	@media only screen and (-webkit-min-device-pixel-ratio: 2),(min-resolution: 192dpi) {
		/* Retina Logo */
		.logo{background:url(<?php echo esc_url(ot_get_option('retina_logo')); ?>) no-repeat center; display:inline-block !important; background-size:contain;}
		.logo img{ opacity:0; visibility:hidden}
		.logo *{display:inline-block}
	}
</style>
<?php endif;?>
<?php wp_head(); ?>
</head>

<body <?php body_class() ?>>
<a style="height:0; position:absolute; top:0;" id="top"></a>
<?php if(ot_get_option('pre-loading',2)==1||(ot_get_option('pre-loading',2)==2&&(is_front_page()||is_page_template('page-templates/front-page.php')))){ ?>
<div id="pageloader" class="dark-div" style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:99999; background:<?php echo esc_attr(ot_get_option('loading_bg','#111')) ?>;">
    <div class="loader loader-2"><i></i><i></i><i></i><i></i></div>
</div>
<script>
setTimeout(function() {
    jQuery('#pageloader').fadeOut();
}, 30000);
</script>
<?php }?>

<?php
	//prepare page title
	global $page_title;
	if(is_search()){
		$page_title = __('Search Result: ','leafcolor').(isset($_GET['s'])?$_GET['s']:'');
	}elseif(is_category()){
		$page_title = single_cat_title('',false);
	}elseif(is_tag()){
		$page_title = single_tag_title('',false);
	}elseif(is_tax()){
		$page_title = single_term_title('',false);
	}elseif(is_author()){
		$page_title = __("Author: ",'leafcolor') . get_the_author();
	}elseif(is_day()){
		$page_title = __("Archives for ",'leafcolor') . date_i18n(get_option('date_format') ,strtotime(get_the_date()));
	}elseif(is_month()){
		$page_title = __("Archives for ",'leafcolor') . get_the_date('F, Y');
	}elseif(is_year()){
		$page_title = __("Archives for ",'leafcolor') . get_the_date('Y');
	}elseif(is_home()){
		if(get_option('page_for_posts')){ $page_title = get_the_title(get_option('page_for_posts'));
		}else{
			$page_title = get_bloginfo('name');
		}
	}elseif(is_404()){
		$page_title = ot_get_option('page404_title','404 - Page Not Found');
	}else if(  function_exists ( "is_shop" ) && is_shop()){
			$page_title = woocommerce_page_title($echo = false);
    }else{
		global $post;
		if($post){$page_title = $post->post_title;}
	}
?>
<div id="body-wrap">
    <div id="wrap">
        <header>
            <?php
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
            get_template_part( 'header', 'navigation' ); // load header-navigation.php 
            if($ct_hd !=''){
               get_template_part( 'header', 'frontpage' );
            }
            ?>
        </header>