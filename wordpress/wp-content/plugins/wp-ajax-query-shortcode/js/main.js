$j = jQuery;
function wp_ajax_query_shortcodeclassic(ajaxParam){
	var item_showed = jQuery('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-content .ajax-item').length;
	if(item_showed<9999){
		$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').addClass('show');
		ajax_running=1;
		var param1 = { action: 'wp_ajax_query' };
		var param = $j.extend({}, param1, ajaxParam);
		param['offset'] = param['offset']*1 + item_showed*1;
		$j.ajax({
			type: "GET",
			url: ajaxParam['home_url']+"wp-admin/admin-ajax.php",
			dataType: 'html',
			data: (param),
			success: function(data){
				if(data=='-11'||data.replace(/(\r\n|\n|\r)/gm,"")=='-11'){
					//$j('.wp-ajax-query-button').remove();
					$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-button a').html('<i class="fa fa-times"></i> No more');
					$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-button a').fadeOut(1000, function(){ $j(this).remove();});
					//$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').removeClass('show');
					$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').remove();
					ajax_running=0;
				}else{
					$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').removeClass('show');
					$j(data).hide().appendTo('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-content').slideDown('slow').imagesLoaded( function(){
						wp_ajax_query_resize();
					});
					jQuery("a[rel^='prettyPhoto']").prettyPhoto({});
					ajax_running=0;
				}
			}
		});
	}
}
function wp_ajax_query_shortcodemodern(ajaxParam){
	var item_showed = jQuery('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-content .ajax-item').length;
	if(item_showed<9999){
		$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').addClass('show');
		ajax_running=1;
		var param1 = { action: 'wp_ajax_query' };
		var param = $j.extend({}, param1, ajaxParam);
		param['offset'] = param['offset']*1 + item_showed*1;
		$j.ajax({
			type: "GET",
			url: ajaxParam['home_url']+"wp-admin/admin-ajax.php",
			dataType: 'html',
			data: (param),
			success: function(data){
				if(data=='-11'||data.replace(/(\r\n|\n|\r)/gm,"")=='-11'){
					//$j('.wp-ajax-query-button').remove();
					$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-button a').html('<i class="fa fa-times"></i> No more');
					$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-query-button a').fadeOut(1500, function(){ $j(this).remove();});
					//$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').removeClass('show');
					$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').remove();
					ajax_running=0;
				}else{
					$j('#waq'+ajaxParam['waq_id']+' .wp-ajax-loading-images').removeClass('show');
					$j('#waq'+ajaxParam['waq_id']+'.modern .wp-ajax-query-content').append(data).imagesLoaded( function(){
						wp_ajax_query_resize();
						$j('#waq'+ajaxParam['waq_id']+'.modern .wp-ajax-query-content').masonry( 'reload' );
					});
					jQuery("a[rel^='prettyPhoto']").prettyPhoto({});
					ajax_running=0;
				}
			}
		});
	}	
}
function waq_isScrolledIntoView(elem){ //in visible
    var docViewTop = jQuery(window).scrollTop();
    var docViewBottom = docViewTop + jQuery(window).height();
    var elemTop = jQuery(elem).offset().top;
    var elemBottom = elemTop + jQuery(elem).height();
    return ((elemBottom <= docViewBottom + 50) && (elemTop >= docViewTop));
}
$j(window).resize(function(){
	wp_ajax_query_resize();
	$j('.modern .wp-ajax-query-content').masonry( 'reload' );
});
$j(window).load(function(){
	wp_ajax_query_resize();
});
function wp_ajax_query_resize(){
	//var height = $j('.ajax-item-thumb img').height();
	$j('.ajax-item-thumb').height( function(){
		return $j(this).children('img').height();	
	});
}
jQuery(document).ready(function(e) {
	jQuery('.ajax-layout-toggle').click(function(e){
		jQuery(this).closest('.wp-ajax-query-shortcode').toggleClass('comboed');
		wp_ajax_query_resize();
		jQuery(this).closest('.wp-ajax-query-shortcode').find('.wp-ajax-query-content').masonry( 'reload' );
    });
});