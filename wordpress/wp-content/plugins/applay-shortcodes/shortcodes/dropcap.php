<?php
function parse_leafcolor_dropcap($atts, $content){
	$html = '<span class="dropcap">'.$content.'</span>';
	return $html;
}
add_shortcode( 'dropcap', 'parse_leafcolor_dropcap' );




















