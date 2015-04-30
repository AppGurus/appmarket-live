jQuery(document).ready(function() {
    //carousel
	jQuery(".is-ias-carousel").each(function(){
		var carousel_id = jQuery(this).attr('id');
		var auto_play = jQuery(this).data('autoplay');
		var auto_height = jQuery(this).data('autoheight');
		var items = jQuery(this).data('items');
		var navigation = jQuery(this).data('navigation');
		if(jQuery(this).hasClass('ias-features-carousel')){ //features carousel
			var feature_id = jQuery(this).data('features-id');
			jQuery(this).owlCarousel({
				singleItem:true,
				stopOnHover:true,
				autoHeight: auto_height,
				autoPlay: auto_play,
				addClassActive : true,
				afterInit: function(i){
					jQuery('.iapp-showcase-'+feature_id+' .features-control-item-0').addClass('active');
				},
				afterMove: function(i){
					var current = this.currentItem;
					jQuery('.iapp-showcase-'+feature_id+' .features-control-item').removeClass('active');
					jQuery('.iapp-showcase-'+feature_id+' .features-control-item-'+current).addClass('active');
				},
			});
		}else if(jQuery(this).hasClass('single-carousel')){ //single style
			jQuery(this).owlCarousel({
				singleItem:true,
				stopOnHover:true,
				autoHeight: auto_height,
				autoPlay: auto_play,
				addClassActive : true
			});
		}else{
			jQuery(this).owlCarousel({
				autoPlay: auto_play,
				stopOnHover:true,
				items: items?items:3,
				itemsDesktop: items?false:3,
				itemsDesktopSmall: items?(items>3?3:false):3,
				singleItem: items==1?true:false,
				navigation: navigation?true:false,
				navigationText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
				slideSpeed: 500,
				addClassActive : true
			});
		}
	});
	jQuery('.ias-devide').each(function(index, element) {
        var parent_width = jQuery(this).parent('.ias-devide-wrap').width();
		var devide_width = jQuery('.device',this).outerWidth();
		var scale = parent_width/devide_width;
		if(scale>1){ scale = 1;}
		var css = '-webkit-transform: scale('+ scale + '); transform: scale('+ scale + ');';
		jQuery('.device',this).attr('style', css);
		jQuery(this).height(jQuery('.device',this).outerHeight()*scale);
		
    });
	jQuery('.showcase-style-features').each(function(index, element) {
		var $this_feature = jQuery(this);
		var $this_feature_owl = jQuery(".ias-features-carousel",this).data('owlCarousel');
        jQuery('.features-control-item',this).click(function(e) {
            $this_feature_owl.goTo(jQuery(this).data('features-item'));
        });
    });
});//document ready
jQuery(window).resize(function(e) {
    ias_devide_resize();
	setTimeout(function(){
		ias_devide_resize();
	}, 300);
});
function ias_devide_resize(){
	jQuery('.ias-devide').each(function(index, element) {
		var parent_width = jQuery(this).parent('.ias-devide-wrap').width();
		var devide_width = jQuery('.device',this).outerWidth();
		//var max_scale = jQuery(this).data('scale')?jQuery(this).data('scale'):1;
		var scale = parent_width/devide_width;
		if(scale>1){ scale = 1;}
		var css = '-webkit-transform: scale('+ scale + '); transform: scale('+ scale + ');';
		jQuery('.device',this).attr('style', css);
		jQuery(this).height(jQuery('.device',this).outerHeight()*scale);
	});
}