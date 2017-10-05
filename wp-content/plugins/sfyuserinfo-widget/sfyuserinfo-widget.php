<?php
/**
 * Plugin Name: SfyUserInfo Widget
 * Plugin URI: http://safeway.com/widget
 * Description: A widget that shows information about logged in user
 * Version: 0.1
 * Author: Iftekhat Amin Sadi
 * Author URI:
 */
 
/**
 * Add function to widgets_init that'll load the widget.
 * @since 0.1
 */

require('helper.php');
 
if(function_exists('add_action'))
	add_action( 'widgets_init', 'sfy_load_widgetuserinfo' );

/**
 * Register this widget.
 * 'SfyUserInfo_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function sfy_load_widgetuserinfo() {
	register_widget( 'SfyUserInfo_Widget' );
		
}

if(!is_admin()) :
	add_action('set_current_user', 'sfy_set_current_user');
	
	function sfy_set_current_user($id, $name){
		global $current_user;
		$current_user->user_login = (isset($_SERVER['REMOTE_USER']) ? strtok($_SERVER['REMOTE_USER'],"@") : '');
		$current_user->user_roles = get_role_information($current_user->user_login,5);
		return $current_user;
	}
endif;


/**
* Add action to load java scripts
*/

if(function_exists('add_action'))
	add_action('wp_print_scripts', 'sfyuserinfo_addscript');

function sfyuserinfo_addscript(){
	$plugin_dir = plugin_dir_url( __FILE__ );
	
	//if not admin interface load related jQuery javascript
	if (!is_admin()) {
		wp_enqueue_script( 'my-user-info', $plugin_dir . 'js/sfyuserinfo.js', 
		array('jquery'));
		
		$widget = new SfyUserInfo_Widget();
		
		//print_r($_SERVER);
		global $current_user;
		get_currentuserinfo();
		if($current_user->user_login == ''){
			$user_id = 'guest';
		}else{
			$user_id = $current_user->user_login;
		}
		
		$timeout = 60*60;
		$ldap_data = $widget->get_ldap_data($user_id,$timeout);
		
		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
		wp_localize_script( 'my-user-info', 'UserInfo', array('userid' => $user_id, 'username' => $ldap_data->display_name, 'dept' => $ldap_data->department , 
															'title' => $ldap_data->title , 'phone' => $ldap_data->phone , 'location' => $ldap_data->location ) ); 
	}
}

	
class SfyUserInfo_Widget extends WP_Widget{
	/**
	 * Widget setup.
	 */
	function SfyUserInfo_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sfyuserinfo', 'description' => __("A widget that that shows logedin user information") );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sfyuserinfo-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'sfyuserinfo-widget', __('Safeway user information widget'), $widget_ops, $control_ops );
	}

	function get_ldap_data($user_id,$timeout){
		$ldap_data = new ldap_data();
		
		if(function_exists('wp_cache_init')){
			if(wp_cache_get('sfyuserinfo_name_' . $user_id) != ''){
				//echo 'from cache';
				wp_cache_init();
				$ldap_data->display_name = wp_cache_get('sfyuserinfo_name_' . $user_id);
				$ldap_data->emilal = wp_cache_get('sfyuserinfo_email_' . $user_id);
				$ldap_data->title = wp_cache_get('sfyuserinfo_title_' . $user_id);
				$ldap_data->phone = wp_cache_get('sfyuserinfo_phone_' . $user_id);
				$ldap_data->department = wp_cache_get('sfyuserinfo_department_' . $user_id);
				$ldap_data->location = wp_cache_get('sfyuserinfo_location_' . $user_id);
				wp_cache_close() ;
			}else{
				//echo 'not from cache';
				$ldap_data = pull_data_from_ad($user_id,$timeout);
				$this->cache_ldap_data($user_id, $ldap_data, $timeout);
			}
		}else{
			$ldap_data = pull_data_from_ad($user_id,$timeout);
		}
		
		return $ldap_data;
	}
	
	function cache_ldap_data($user_id, $ldap_data, $timeout){
		if(function_exists('wp_cache_init')){
			wp_cache_init();
			wp_cache_delete('sfyuserinfo_name_' . $user_id);
			wp_cache_delete('sfyuserinfo_email_' . $user_id);
			wp_cache_delete('sfyuserinfo_title_' . $user_id);
			wp_cache_delete('sfyuserinfo_phone_' . $user_id);
			wp_cache_delete('sfyuserinfo_department_' . $user_id);
			wp_cache_delete('sfyuserinfo_location_' . $user_id);
			
			wp_cache_add('sfyuserinfo_name_' . $user_id, $ldap_data->display_name, 'default', $timeout);
			wp_cache_add('sfyuserinfo_email_' . $user_id, $ldap_data->emilal, 'default', $timeout);
			wp_cache_add('sfyuserinfo_title_' . $user_id, $ldap_data->title, 'default', $timeout);
			wp_cache_add('sfyuserinfo_phone_' . $user_id, $ldap_data->phone, 'default', $timeout);
			wp_cache_add('sfyuserinfo_department_' . $user_id, $ldap_data->department, 'default', $timeout);
			wp_cache_add('sfyuserinfo_location_' . $user_id, $ldap_data->location, 'default', $timeout);
			wp_cache_close() ;
		}
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
		
		<div id="aboutme_widget" style="position: relative; background: url(<?php echo plugins_url( 'imgs/aboutme.JPG', __FILE__ );?>); width: 277px; height: 109px;"> 
			<div style="position: absolute; top: 1.0em; left: 1.6em; width: 240px; padding: 0px;"> 
				<div style="font-size:11px;font-family:sans-serif;">
					<span style="font-weight:700;">Name: <span style="color:black;"><script type="text/javascript">document.write(UserInfo.username)</script></span></span><br/>
					<!--<span style="font-weight:500;">Dept: <script type="text/javascript">document.write(UserInfo.dept)</script></span><br/>-->
					<span style="font-weight:500;">Title: <script type="text/javascript">document.write(UserInfo.title)</script></span><br/>
					<span style="font-weight:500;">Tel:  <script type="text/javascript">document.write(UserInfo.phone)</script></span><br/>
					<a href="https://idservices.safeway.com/idm/user/login.jsp" target="_blank" style="color:#287AE3">Update profile</a>
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

//$test = new SfyUserInfo_Widget();
//$test->print_ldap_data();
?>