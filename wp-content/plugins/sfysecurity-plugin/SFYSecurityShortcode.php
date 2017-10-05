<?php

add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');
add_filter('the_content', 'do_shortcode');
	

class SFYSecurityShortcode{
	//[sfysecure role='abc,def']http://securedlink/securedcontent[/sfycecure]
	function sfysecure_shortcode($atts, $content = null){
		extract( shortcode_atts( array(
		'role' => '',
		), $atts ) );
		
		if($atts != ''){
			$util = new Utility();
			if(!$util->is_user_in_role($role)){
				$content = '';
			}
		}
		$content = do_shortcode($content);
		return $content;
	}
}
?>