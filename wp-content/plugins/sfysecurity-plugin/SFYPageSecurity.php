<?php
	define('SFYSECURITY_PAGE_READ_ACCESS', 'sfysecurity_page_readaccess');
	define('SFYSECURITY_PAGE_WRITE_ACCESS', 'sfysecurity_page_writeaccess');
	
	class SFYPageSecurity{
		/**
		* Adds the meta box container
		*/
		public static function add_page_post_security_metabox(){
			add_meta_box( 
				'sfysecurity_pagepost_metabox',
				__( 'Page/Post Security for Safeway','sfysecurity_textdomain'),
				array('SFYPageSecurity','render_meta_box_content'),
				'post',
				'side'
			);
			add_meta_box( 
				'sfysecurity_pagepost_metabox',
				__( 'Page/Post Security for Safeway', 'sfysecurity_textdomain'),
				array('SFYPageSecurity','render_meta_box_content'),
				'page',
				'side'
			);
		}
		
		/**
		* Render Meta Box content
		*/
		public static function render_meta_box_content($post) {
			// Use nonce for verification
			wp_nonce_field( plugin_basename( __FILE__ ), 'sfysecurity_pagepost_access' );
			//echo SFYSECURITY_PAGE_READ_ACCESS;
			$data = get_post_meta($post->ID, SFYSECURITY_PAGE_READ_ACCESS, true);
			// The actual fields for data entry
			echo '<label for="pagepost_securityrole_read">';
			_e("Secured read roles", 'sfysecurity_textdomain' );
			echo '</label> ';
			echo '<input type="text" id="pagepost_securityrole_read" name="pagepost_securityrole_read" value="' . print_r($data,true) . '" size="25" />';
			?>
			<a rel="popup_search" href="<?php echo plugin_dir_url( __FILE__ ) . '/' . 'dirsearch' . '/' . 'dirsearch.php?fieldid=pagepost_securityrole_read'; ?>">Search</a> 
			<?php
		}
		
		/* When the post is saved, saves our custom data */
		function sfysecurity_readaccess_postdata( $post_id ) {
		  // verify if this is an auto save routine. 
		  // If it is our form has not been submitted, so we dont want to do anything
		  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			 return;

		  // verify this came from the our screen and with proper authorization,
		  // because save_post can be triggered at other times

		  if ( !wp_verify_nonce( $_POST['sfysecurity_pagepost_access'], plugin_basename( __FILE__ ) ) )
			  return;

		  
		  // Check permissions
		  if ( 'page' == $_POST['post_type'] ) 
		  {
			if ( !current_user_can( 'edit_page', $post_id ) )
				return;
		  }
		  else
		  {
			if ( !current_user_can( 'edit_post', $post_id ) )
				return;
		  }

		  // OK, we're authenticated: we need to find and save the data

		  $data = $_POST['pagepost_securityrole_read'];
		
		  // Do something with $mydata 
		  // using add_post_meta(), update_post_meta()
		  update_post_meta($post_id, SFYSECURITY_PAGE_READ_ACCESS, $data);
		}
		
		
		public static function secure_post_content( $wp ){
			//check for individual page security if...
			if(!is_home() && !is_category() && !is_tag() && !is_feed() && !is_tax() && !is_admin() && !is_404() && !is_archive() && !is_search()){
				global $post;
				$page_id = $post->ID;
				$plugin_dir = plugin_dir_url( __FILE__ );
				$util = new Utility();
				if(!$util->is_pageaccess_allowed($page_id)){
					//redirect to access denied page
					 $redir_link = $plugin_dir . 'accessdenied.html';
					 wp_redirect($redir_link);
                     exit(sprintf(__('Access Denied. Redirecting to %s','safeway-page-security'),$redir_link)); //Regular die to prevent restricted content from slipping out
				}
			}
		}
		
		public static function filter_loops($content){
			if(!is_admin()){
				$util = new Utility();
				 foreach($content as $post->key => $post->value){
					$page_id = $post->value->ID;
					if(!$util->is_pageaccess_allowed($page_id)){
						//print_r($post->value->post_content) ;
						unset($content[$post->key]);
						$post->value->post_content = 'Access denied';
						$content[$post->key] = $post->value;
					}
				 }
			}
			//Adjust top-level array key numbers to be concurrent (since a gap between numbers can cause wp to freak out)
			$content = array_merge($content,array());
			
			return $content;
		}
		
		public static function filter_auto_menus($content){
			if(!is_admin()){
				$util = new Utility();
				 foreach($content as $post->key => $post->value){
					$page_id = $post->value->ID;
					if(!$util->is_pageaccess_allowed($page_id)){
						unset($content[$post->key]);
					}
				 }
			}
			//Adjust top-level array key numbers to be concurrent (since a gap between numbers can cause wp to freak out)
			$content = array_merge($content,array());

			return $content;
		}
		
		public static function filter_custom_menus($content){
			if(!is_admin()){
				$util = new Utility();
				 foreach($content as $post->key => $post->value){
					$page_id = $post->value->ID;
					if(!$util->is_pageaccess_allowed($page_id)){
						unset($content[$post->key]);
					}
				 }
			}
			//Adjust top-level array key numbers to be concurrent (since a gap between numbers can cause wp to freak out)
			$content = array_merge($content,array());

			return $content;
		}
	}
?>