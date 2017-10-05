<?php
	/*
	Plugin Name: Safeway Clear Cache
	Plugin URI: 
	Description: Enable editors to clear W3 Total Cache and Widget Cache.
	Author: Iftekhar Sadi
	Version: 1.0
	Author URI: 
	Donate link: 
	*/
	
	function clear_cache(){
		//cleare widget cache
		$cachedir = WP_CONTENT_DIR.'/widget-cache';
		if(class_exists('WCache')){
			$wcache = new WCache($cachedir);
			$wcache->clear();
			
			echo '<div id="message" class="updated">Widget Cache cleaned successfully.</div>';
		}
		
		//clear w3 total cache
		if( class_exists('W3_Plugin_TotalCacheAdmin') ){
			$plugin_totalcacheadmin = & w3_instance('W3_Plugin_TotalCacheAdmin');
			
			$plugin_totalcacheadmin->flush_all();
			$plugin_totalcacheadmin->flush_pgcache();
			$plugin_totalcacheadmin->flush_dbcache();
			$plugin_totalcacheadmin->flush_objectcache();
			$plugin_totalcacheadmin->flush_minify();
			
			echo '<div id="message" class="updated">W3 Total Cache cleaned successfully.</div>';
		}

	}
	
	function sfy_clear_cache() 
	{
		echo '<h1>Please click the submit button to clear all cache</h1>';
		
		if ($_POST['clear_submit']){
			clear_cache();
		}
		?>
		<form name="sfy_clear" method="post" action="">
			<input name="clear_submit" id="clear_submit" class="button-primary" value="Submit" type="submit" />'
		</form>
		<?php
	}
	
	function sfy_clearcache_add_to_menu() 
	{
		add_menu_page('Safeway Clear Cache', 'Safeway Clear Cache', 7, 'clear_cache', 'sfy_clear_cache' );
	}
	
	add_action('admin_menu', 'sfy_clearcache_add_to_menu');
?>