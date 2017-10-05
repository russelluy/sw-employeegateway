<?php
function eg_function() {
if(!is_admin()){
	//wp_enqueue_script( 'jquery' );
	
	//Tutorial
	/*wp_enqueue_script('poplight', '/wp-content/themes/Agivee/js/tooltip/popup.js', array('jquery'));
	wp_enqueue_script('27', '/wp-content/themes/Agivee/js/tooltip/close.js', array('jquery'));
	wp_enqueue_script('hover', '/wp-content/themes/Agivee/js/tooltip/hover.js', array('jquery'));
	wp_enqueue_script('tooltip', '/wp-content/themes/Agivee/js/tooltip/tooltip.js', array('jquery'));
	wp_enqueue_script('tooltip2', '/wp-content/themes/Agivee/js/tooltip/tooltipright.js', array('jquery'));
	wp_enqueue_script('tooltip3', '/wp-content/themes/Agivee/js/tooltip/top.js', array('jquery'));
	wp_enqueue_script('tooltip4', '/wp-content/themes/Agivee/js/tooltip/bottom.js', array('jquery'));
	wp_enqueue_script('tooltip5', '/wp-content/themes/Agivee/js/tooltip/tooltipleft.js', array('jquery'));
	wp_enqueue_style('tooltip', '/wp-content/themes/Agivee/tooltip.css');*/
	
	//use a newer version of jquery
	 wp_deregister_script( 'jquery' );
	 wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-1.7.min.js');
	 wp_enqueue_script( 'jquery');
	
	//Tutorial Popup
	/*wp_enqueue_script('colorbox', get_template_directory_uri() . '/js/tutorial/jquery.colorbox.js', array('jquery'));
	wp_enqueue_script('popup', get_template_directory_uri() . '/js/tutorial/popup.js', array('jquery'));
	wp_enqueue_style('colorbox', get_template_directory_uri() . '/css/popup/colorbox.css');*/
	//Dropdown Blk
	wp_enqueue_script('taba', get_template_directory_uri() . '/js/tab.js', array('jquery'));
	wp_enqueue_style('blkshine', get_template_directory_uri() . '/css/blkshine.css'); 
	//featured Sites Tabs???
	wp_enqueue_style('tabstyleb', get_template_directory_uri() . '/css/jquery-ui.css'); 
	wp_enqueue_script('jqueryminula', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'));
	wp_enqueue_script('featuredsitez', get_template_directory_uri() . '/js/featuredsites.js', array('jquery'));
	//Video Carousel
	//wp_enqueue_script('jqueryjcarousel', get_template_directory_uri() . '/lib/jquery.jcarousel.min.js"', array('jquery'));
	wp_enqueue_script('vidcarousel', get_template_directory_uri() . '/js/vidcarousel.js"', array('jquery'));
	wp_enqueue_style('videocarousel', get_template_directory_uri() . '/skins/tango/skin.css'); 
	//Fancybox
	//wp_enqueue_script('jqueryjcarousel', get_template_directory_uri() . '/lib/jquery.jcarousel.min.js"', array('jquery'));
	wp_enqueue_script('mousewheel', get_template_directory_uri() . '/fancybox/jquery.mousewheel-3.0.4.pack.js"', array('jquery'));
	wp_enqueue_script('fancybox', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.pack.js"', array('jquery'));
	wp_enqueue_style('fancyboxstyle', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.css'); 
	//People Quiz
	wp_enqueue_style('quizstyle', get_template_directory_uri() . '/peoplequiz/jquiz.css'); 
	wp_enqueue_script('jquizb', get_template_directory_uri() . '/peoplequiz/jquiz.js"', array('jquery'));
	//Croc
	wp_enqueue_script('flashcroc', get_template_directory_uri() . '/js/flashcroc.js"', array('jquery'));
	wp_enqueue_script('tinyslide', get_template_directory_uri() . '/js/compressed.js', array('jquery'));
	wp_enqueue_script('ajaxtooltip', get_template_directory_uri() . '/fftbtooltip/jquery.tools.min.js', array('jquery'));
	wp_enqueue_script('empgateway', get_template_directory_uri() . '/employeegateway/employeegateway.js', array('jquery', 'fancybox' , 'ajaxtooltip' ), '2.0', true);
	//Slider
	//wp_enqueue_script('nivoSlider', plugins_url() . '/nivo-slider/scripts/nivo-slider/jquery.nivo.slider.pack.js', array('jquery'));
	//wp_enqueue_script('slider', get_template_directory_uri() . '/nivoslider/js/slider.js', array('jquery'));
	//wp_enqueue_style('nivo-slider.css', get_template_directory_uri() . '/nivoslider/nivo-slider.css');


	}
}    

 add_action('init', 'eg_function');
 
    
$inc_path = (TEMPLATEPATH.'/include/');

require_once ($inc_path.'theme-options.php');
require_once ($inc_path.'theme-functions.php');
require_once ($inc_path.'theme-widgets.php');
require_once ($inc_path.'metabox.php');
require_once ($inc_path.'admin-interface.php');

function mytheme_add_admin() {
	global $themename, $shortname, $options;
	if ( $_GET['page'] == basename(__FILE__) ) {
		if ( 'save' == $_REQUEST['action'] ) {
				foreach ($options as $value) {
					update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
				foreach ($options as $value) {
					if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
				header("Location: themes.php?page=functions.php&saved=true");
				die;
		} else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				delete_option( $value['id'] ); }
			header("Location: themes.php?page=functions.php&reset=true");
			die;
		}
	}
	add_menu_page($themename." Options", $themename, 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

add_action('admin_menu', 'mytheme_add_admin');
?>