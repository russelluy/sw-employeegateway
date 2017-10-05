<?php
/*
Plugin Name: Serve theme ie6 when browser is ie6
Plugin URI: 
Description: this plugin will serve ie6 theme when browse is ie6
Author: Nathan Rice
Author URI: 
Version: 1.0
*/
if(!is_admin()) :
add_filter('template', 'serve_default_to_iesix');
add_filter('option_template', 'serve_default_to_iesix');
add_filter('option_stylesheet', 'serve_default_to_iesix');
function serve_default_to_iesix($theme) {
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6') !== false)
		$theme = 'ie6';

	return $theme;
}
endif;
?>