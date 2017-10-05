<?php
function eg_function() {
if(!is_admin()){
	
	//use a newer version of jquery
	 wp_deregister_script( 'jquery' );
	 wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-1.7.min.js');
	 wp_enqueue_script( 'jquery');
	
	//Dropdown Blk
	wp_enqueue_script('taba', get_template_directory_uri() . '/js/tab.js', array('jquery'));
	wp_enqueue_style('blkshine', get_template_directory_uri() . '/css/blkshine.css'); 
	//featured Sites Tabs???
	wp_enqueue_style('tabstyleb', get_template_directory_uri() . '/css/jquery-ui.css'); 
	wp_enqueue_script('jqueryminula', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'));
	wp_enqueue_script('featuredsitez', get_template_directory_uri() . '/js/featuredsites.js', array('jquery'));

	//Fancybox
	wp_enqueue_script('fancybox', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.pack.js"', array('jquery'));
	wp_enqueue_style('fancyboxstyle', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.css'); 
	//People Quiz
	wp_enqueue_style('quizstyle', get_template_directory_uri() . '/peoplequiz/jquiz.css'); 
	wp_enqueue_script('jquizb', get_template_directory_uri() . '/peoplequiz/jquiz.js"', array('jquery'));
	//STAYS
	wp_enqueue_script('ajaxtooltip', get_template_directory_uri() . '/fftbtooltip/jquery.tools.min.js', array('jquery'));	
	wp_enqueue_script('empgateway', get_template_directory_uri() . '/employeegateway/employeegateway.js', array('jquery', 'fancybox' , 'ajaxtooltip' ), '2.0', true);
	
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