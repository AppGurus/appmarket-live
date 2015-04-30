jQuery(document).ready(function(e) {
    jQuery('#mip-form .image-select input:radio').addClass('input_hidden');
	jQuery('#mip-form .image-select label').click(function(){
		jQuery(this).addClass('selected').siblings().removeClass('selected');
	});
});