<?php	
	define('SFYSECURITY_WIDGET_READ_ACCESS', 'sfysecurity_widget_readaccess');
		
	class SFYWidgetSecurity{
	
		/**
		*This function acts as a filter add two text box in widget admin panel. 
		*In the text box the administrator can specify user role for the particular widget
		*/
		public static function security_setting_form_for_widget($instance){
			$options = get_option($instance->option_name);
			$current_option = $options[$instance->number];
			
		?>
			<p>
				<label for="<?php echo $instance->get_field_id( SFYSECURITY_WIDGET_READ_ACCESS ); ?>">
					<?php _e('Secured read roles: '); ?>
				</label>
				<input id="<?php echo $instance->get_field_id( SFYSECURITY_WIDGET_READ_ACCESS ); ?>" 
					name="<?php echo $instance->get_field_name( SFYSECURITY_WIDGET_READ_ACCESS ); ?>" 
					value="<?php echo isset($current_option[SFYSECURITY_WIDGET_READ_ACCESS]) ? $current_option[SFYSECURITY_WIDGET_READ_ACCESS] : '';?>" style="width:100%;" />
				<a rel="popup_search" href="<?php echo plugin_dir_url( __FILE__ ) . '/' . 'dirsearch' . '/' . 'dirsearch.php?fieldid=' . $instance->get_field_id( SFYSECURITY_WIDGET_READ_ACCESS ); ?>">Search</a> 
			</p>	
		<?php
		}
		
		/**
		*This function acts as a filter to determine whether to show widget
		*content to a particular user based on role
		*/
		public static function show_widget_content($instance){
			//print_r($instance);
			if(!is_admin()){
				if(isset($instance[SFYSECURITY_WIDGET_READ_ACCESS])){
					$read_access_role = $instance[SFYSECURITY_WIDGET_READ_ACCESS];
					
					//echo 'here ' . is_user_in_role($read_access_role);
					$util = new Utility();
					if(!$util->is_user_in_role($read_access_role)){	
						$instance = false;
					}
				}
			}
			
			return $instance;
		}
		
		/**
		*This function acts as a filter for updating secutiry option
		*for a particular widget
		*/
		public static function widget_security_setting_update($instance){
			$val1 = $_POST['widget-' . $_POST['id_base']][$_POST['widget_number']][SFYSECURITY_WIDGET_READ_ACCESS];
			$instance[SFYSECURITY_WIDGET_READ_ACCESS] = $val1;//$new_instance['readaccess'];	
			return $instance;
		}
	}
?>