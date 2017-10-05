<?php
/**
 * Plugin Name: SfyLoadtime Widget
 * Plugin URI: http://safeway.com/widget
 * Description: A widget that shows load time of wordpress and saves that to database
 * Version: 0.1
 * Author: Iftekhat Amin Sadi
 * Author URI:
 */

//include('/var/www/assets/Apache_log4php-2.1.0/log4php/Logger.php');

define('EMPGATEWAY_LOG_FILE', '/var/log/employeegateway.log');
define('TIMEZONE', 'America/Phoenix');
/**
 * Add function to widgets_init that'll load the widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'sfy_load_widgetloadtime' );

/**
 * Register this widget.
 * 'SfyStocktracker_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function sfy_load_widgetloadtime() {
	register_widget( 'SfyLoadtime_Widget' );
}

/**
* Add action to load java scripts
*/

add_action('wp_print_scripts', 'sfyloadtime_addscript');

function sfyloadtime_addscript(){
	$plugin_dir = plugin_dir_url( __FILE__ );
	
	//if not admin interface load related jQuery javascript
	if (!is_admin()) {
		wp_enqueue_script( 'sfy-loadtime', $plugin_dir . 'js/sfyloadtime-script.js', 
		array('jquery'));
			
		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
		wp_localize_script( 'sfy-loadtime', 'LoadTime', array('ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); 
	}
}

// if both logged in and not logged in users can send this AJAX request,
// add both of these actions, otherwise add only the appropriate one
add_action( 'wp_ajax_nopriv_loadtime-submit', 'loadtime_submit' );
add_action( 'wp_ajax_loadtime-submit', 'loadtime_submit' );

function loadtime_submit() {
	// Tell log4php to use our configuration file.
	//Logger::configure( ABSPATH . 'wp-content/plugins/sfyloadtime-widget/log4php.xml');

	// Fetch a logger, it will inherit settings from the root logger
	//$log = Logger::getLogger('SfyLoadLogger');
	
	// get the submitted parameters  
	date_default_timezone_set(TIMEZONE);
	$timestamp = date("D M j G:i:s T Y");
	$loadTime = $_POST['loadTime'];  
	$location = $_POST['location'];  
	$userId = $_POST['userId']; 
	$bLoadTime = $_POST['bLoadTime']; 
	$useragent = '';
	if(isset($_SERVER['HTTP_USER_AGENT'])){
		$useragent = $_SERVER['HTTP_USER_AGENT'];
	}
	
	//$log->info("," . $timestamp . ',' . $location . ',' . $userId . ',' . $loadTime . ',' . $bLoadTime . ',' . $useragent);
	logemployeegateway($timestamp . "," . $location . "," . $userId . "," . $loadTime . "," . $bLoadTime . "," . $useragent . "\n");
	
	// generate the response    
	$response = json_encode( array( 'loaded' => true ) );     
	// response output    
	header( "Content-Type: application/json" );    
	echo $response;     
	
	// IMPORTANT: don't forget to "exit"    
	exit;
} 

function logemployeegateway($str){
	$fh = fopen(EMPGATEWAY_LOG_FILE, 'a') or die("can't open file");
	fwrite($fh, $str);
	fclose($fh);
}

/**
 * SfyLoadtime Widget class.
 * This class handles everything that needs to be handled with the widget:
 *
 * @since 0.1
 */
class SfyLoadtime_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function SfyLoadtime_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sfyloadtime', 'description' => __("A widget that shows and saves load time") );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sfyloadtime-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'sfyloadtime-widget', __('Safeway load time widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		
		/* Before widget (defined by themes). */
		echo $before_widget;
		
		$load_time = timer_stop( 0 );
		
		/* Display widget componenets here */
		date_default_timezone_set(TIMEZONE);
		$timestamp = date("D M j G:i:s T Y");
		//echo $timestamp;
		?>
		
		<input id="footer_loadtime" type="hidden" value="<?php echo $load_time; ?>"></input>
		<div style="text-align:center; color:#000000">Server process time&nbsp;<b><?php echo $load_time; ?></b>&nbspseconds. Page load time&nbsp;<div id="browser_load"></div>&nbsp;seconds.</div>     
		
		<?php
	
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Update configuration data. Strip tags for timeout value to remove HTML (important for text inputs). */
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		?>
		
		<!-- Widget settings user interface goes here -->
		<p>
			There is no settings for this widget currently
		</p>
	<?php
	}
}
?>
