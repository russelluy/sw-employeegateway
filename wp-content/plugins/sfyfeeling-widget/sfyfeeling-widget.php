<?php
/**
 * Plugin Name: SfyFeeling Widget
 * Plugin URI: http://safeway.com/widget
 * Description: A widget that lets user specify how he/she is feeling today
 * Version: 0.1
 * Author: Iftekhat Amin Sadi
 * Author URI:
 */
define('DONOTCACHEDB', true);

define("EMOTION_TABLE", "EMOTION_LEVELS");
 
/**
 * Add function to widgets_init that'll load the widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'sfy_load_widgetfeeling' );

// if both logged in and not logged in users can send this AJAX request,
// add both of these actions, otherwise add only the appropriate one
add_action( 'wp_ajax_nopriv_myajax-submit', 'myajax_submit' );
add_action( 'wp_ajax_myajax-submit', 'myajax_submit' );


function myajax_submit() {
	global $wpdb;
		
	// get the submitted parameters    
	$emoID = $_POST['emoID'];     
	$user_name = $_POST['userID'];
	
	$insert = "INSERT INTO " . EMOTION_TABLE .
			" (USER_ID, FEELING_LEVEL_ID) " .
			"VALUES ('". $user_name . "'," . $emoID . ")";
			
	$results = $wpdb->query( $insert );

	// generate the response    
	$response = json_encode( array( 'success' => true, 'emoID' => $emoID, 'userId' => print_r($user_name,true) ) );     
	// response output    
	header( "Content-Type: application/json" );    
	echo $response;     
	
	if (function_exists('w3tc_pgcache_flush')) {
		w3tc_pgcache_flush();
	} 
	
	// IMPORTANT: don't forget to "exit"    
	exit;
} 

/**
* Add action to load java scripts
*/

add_action('wp_print_scripts', 'sfyfeeling_addscript');

function sfyfeeling_addscript(){
	$plugin_dir = plugin_dir_url( __FILE__ );
	
	//if not admin interface load related jQuery javascript
	if (!is_admin()) {
		wp_enqueue_script( 'my-ajax-request', $plugin_dir . 'js/sfyfeeling-script.js', 
		array('jquery'));
		
		$emo_level = last_emotion_level(); 
		$emo_level = ($emo_level == null ? 5 : $emo_level);
		$user_name = current_user();
		
		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
		wp_localize_script( 'my-ajax-request', 'MyAjax', array('pluginurl' => $plugin_dir ,'ajaxurl' => admin_url( 'admin-ajax.php' ),
																							'lastemo' => $emo_level, 
																							'userid' => $user_name ) ); 
	}
}

function current_user(){
	global $current_user; 
	get_currentuserinfo();
	//print_r($current_user->user_login);
	if($current_user->user_login == ''){
		$user_name = 'guest';
	}else{
		$user_name = $current_user->user_login;
	}
	
	return $user_name;
}

function last_emotion_level(){
	global $wpdb;
	
	$user_name = current_user();
	//print_r($current_user);
	//print_r('user ' . $user_name);
	
	$query = 'select FEELING_LEVEL_ID from ' .  EMOTION_TABLE . ' where USER_ID = \'' . $user_name . '\' order by ENTERED_TS desc LIMIT 1';
	$emo_level = $wpdb->get_var($query,0,0);
	return $emo_level;
}

/**
 * Register this widget.
 * 'SfyStocktracker_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function sfy_load_widgetfeeling() {
	register_widget( 'SfyFeeling_Widget' );
}

/**
 * SfyStocktracker Widget class.
 * This class handles everything that needs to be handled with the widget:
 *
 * @since 0.1
 */
class SfyFeeling_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function SfyFeeling_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sfyfeeling', 'description' => __("A widget that lets user input their mood level") );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sfyfeeling-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'sfyfeeling-widget', __('Safeway how are u feeling widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display widget componenets here */
		?>
		
		<!--Begin feeling form -->
				<div id="feelingform" title="How are you feeling today?">
					<div id="slider" style="width:390px;"></div>
					<div id="img_strip" style="padding-top:5px;">
						<img src = "<?php echo plugins_url( 'imgs/Emoticons_Group.gif', __FILE__ );?>" style="padding-left:0px;"/>
						</div>
				</div>
		<!--End feeling form -->
		
		<!--<button id="feelingbutton">i am feeling</button>-->
		<div id="feeling_widget" style="position: relative; background: url(<?php echo plugins_url( 'imgs/sample_aboutme.jpg', __FILE__ );?>); width: 277px; height: 107px;"> 
			<div style="position: absolute; top: 4.5em; right: 2em; width: 120px; padding: 4px; background-color: #fff; font-size: 11px;font-weight:bold;"> 
			<a id="link_feeling" style="color:#6f6f6f" href="#">I'm Feeling:</a> 
				<div style="position:relative;top:-20px;left:80px">
				<img id = "feeling-image" src = ""/>
				<input id="fi-value" type="hidden" value=""/>
				</div>
			</div>
		</div>		
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