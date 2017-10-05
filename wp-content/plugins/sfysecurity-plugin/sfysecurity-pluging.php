<?php
/**
 * Plugin Name: SfySecurity
 * Plugin URI: http://safeway.com/widget
 * Description: A plugin for managing secured artifacts for wordpress 
 * Version: 0.1
 * Author: Iftekhat Amin Sadi
 * Author URI:
 */
	require_once 'SFYWidgetSecurity.php';
	require_once 'SFYPageSecurity.php';
	require_once 'Utility.php';
	require_once 'SFYSecurityShortcode.php';
		
	
	if(is_admin()){
		//adds filter for adding textbox in widget control form to input security setting
		add_action('in_widget_form',array('SFYWidgetSecurity','security_setting_form_for_widget'));
		
		//adds a filter for updating widget security options
		add_filter('widget_update_callback', array('SFYWidgetSecurity','widget_security_setting_update'));
		
		//adds an action to include security input option box for page and post
		add_action( 'add_meta_boxes', array('SFYPageSecurity','add_page_post_security_metabox') );
		
		/* Do something with the data metabox for page/post security */
		add_action( 'save_post', array('SFYPageSecurity','sfysecurity_readaccess_postdata') );
		
		/**
		* Add action to load java scripts
		*/
		add_action('wp_print_scripts', 'sfysecurity_addscript');
		add_action('admin_init', 'sfysecurity_addstyle');
	}
	
	function sfysecurity_addstyle(){
		$plugin_dir = plugin_dir_url( __FILE__ );
		
		wp_enqueue_style('fancyboxstyle', $plugin_dir . '/js/fancybox/jquery.fancybox-1.3.4.css'); 
	}

	function sfysecurity_addscript(){
		$plugin_dir = plugin_dir_url( __FILE__ );
		
		if(is_admin()){
			wp_enqueue_script('jquery');
			//Fancybox
			wp_enqueue_script('mousewheel', $plugin_dir . '/js/fancybox/jquery.mousewheel-3.0.4.pack.js', array('jquery'));
			wp_enqueue_script('fancybox', $plugin_dir . '/js/fancybox/jquery.fancybox-1.3.4.pack.js', array('jquery'));
			
			wp_enqueue_script('sfysecurity', $plugin_dir . 'js/sfysecurity.js', array('jquery','mousewheel','fancybox' ));
		}
	}
	
	//adds filter for displaying widget content securedly
	add_filter('widget_display_callback', array('SFYWidgetSecurity','show_widget_content'));
	
	//Add basic security to all public "static" pages and posts [highest priority]
	add_action('wp', array('SFYPageSecurity','secure_post_content'),1);

	//Add basic security to dynamically displayed posts (such as on Blog Posts Page, ie: Home) [highest priority]
	add_filter('the_posts', array('SFYPageSecurity','filter_loops'),1);

	//Ensure that menus do not display protected pages (when using default menus only) [highest priority]
	add_filter('get_pages', array('SFYPageSecurity','filter_auto_menus'),1);
	//Ensure that menus do not display protected pages (when using WP3 custom menus only) [highest priority]
	add_filter('wp_get_nav_menu_items', array('SFYPageSecurity','filter_custom_menus'),1);
	
	//add security shortcode
	add_shortcode( 'sfysecure', array('SFYSecurityShortcode','sfysecure_shortcode') );
?>