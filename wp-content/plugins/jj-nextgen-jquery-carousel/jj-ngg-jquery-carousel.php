<?php
/*
Plugin Name: Safeway JJ NextGen JQuery Carousel
Description: Allows you to pick a gallery from the 'NextGen Gallery' plugin to use as a 'JQuery JCarousel'. Modification of original plugin was made for Safeway backstage gateway. Automatic update of this plugin has been disabled.
Author: JJ Coder
Version: 1.1.8
*/

if ( ! defined( 'WPJJNGGJ_CAROUSEL_PLUGIN_BASENAME' ) )
	define( 'WPJJNGGJ_CAROUSEL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'WPJJNGGJ_CAROUSEL_PLUGIN_NAME' ) )
	define( 'WPJJNGGJ_CAROUSEL_PLUGIN_NAME', trim( dirname( WPJJNGGJ_CAROUSEL_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'WPJJNGGJ_CAROUSEL_PLUGIN_DIR' ) )
	define( 'WPJJNGGJ_CAROUSEL_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . WPJJNGGJ_CAROUSEL_PLUGIN_NAME );

function WPJJNGGJ_CAROUSEL_set_plugin_meta($links, $file)
{
  $plugin = WPJJNGGJ_CAROUSEL_PLUGIN_BASENAME;
  if ($file == $plugin)
  {
    $links[] = '<a href="http://wordpress.org/extend/plugins/jj-nextgen-jquery-carousel/">' . 'Visit plugin site' . '</a>';
    $links[] = '<a href="http://www.redcross.org.nz/donate">' . 'Donate to Christchurch Quake' . '</a>';
  }
  return $links;
}
if( is_admin() )
{
  add_filter( 'plugin_row_meta', 'WPJJNGGJ_CAROUSEL_set_plugin_meta', 10, 2 );
}

add_filter('site_transient_update_plugins', 'dd_remove_update_ng');
function dd_remove_update_ng($value) {
	if($value && isset($value->response[ plugin_basename(__FILE__) ])){
	 unset($value->response[ plugin_basename(__FILE__) ]);
	 return $value;
 }
}

require_once WPJJNGGJ_CAROUSEL_PLUGIN_DIR . '/includes/application.php';

