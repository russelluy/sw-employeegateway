<?php
/**
 * Plugin Name: SfyStocktracker Widget
 * Plugin URI: http://safeway.com/widget
 * Description: A widget that displays stock information in a ticker
 * Version: 0.1
 * Author: Iftekhat Amin Sadi
 * Author URI:
 */

/**
* Add action to load java scripts
*/
add_action('wp_print_scripts', 'sfystock_addscript');

function sfystock_addscript(){
	$plugin_dir = plugin_dir_url( __FILE__ );
	
	if(!is_admin()){
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery_easing', $plugin_dir . 'javascripts/jquery-easing.1.3.js', array('jquery'));
		wp_enqueue_script('jquery_codaslider', $plugin_dir . 'javascripts/jquery.coda-slider-2.0.js', array('jquery', 'jquery_easing'));
		wp_enqueue_script('jquery_liscroller', $plugin_dir . 'javascripts/jquery.webticker.js', array('jquery'));
		wp_enqueue_script('sfystock', $plugin_dir . 'javascripts/sfystock.js', array('jquery', 'jquery_easing', 'jquery_codaslider', 'jquery_liscroller'));
	}
}

/**
* Add action to load style sheet
*/
add_action('wp_print_styles', 'sfystock_addstyle');

function sfystock_addstyle(){
	$plugin_dir = plugin_dir_url( __FILE__ );
	
	if(!is_admin()){
		wp_enqueue_style( 'style_codaslider', $plugin_dir . 'stylesheets/coda-slider-2.0.css');
		wp_enqueue_style( 'style_liscroller', $plugin_dir . 'stylesheets/li-scroller.css');
	}
}
 
 
/**
 * Add function to widgets_init that'll load the widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'sfy_load_widgets' );

/**
 * Register this widget.
 * 'SfyStocktracker_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function sfy_load_widgets() {
	register_widget( 'SfyStocktracker_Widget' );
}

/**
 * SfyStocktracker Widget class.
 * This class handles everything that needs to be handled with the widget:
 *
 * @since 0.1
 */
class SfyStocktracker_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function SfyStocktracker_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sfystocktracker', 'description' => __("A widget that shows stock information in a ticker") );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sfystocktracker-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'sfystocktracker-widget', __('Safeway Stock Tracker'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$symbol = $instance['symbols'];
		$timeout = $instance['timeout'] * 60;//convert timeout into seconds
	
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display ticker data here */
		$this->displaytickerdata($symbol, $timeout);
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/*
	* Use curl to connet through ssl to server
	* Retrieve contents
	*/
	function getUrlContent($submit_url){
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_SSLVERSION,2);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		curl_setopt($curl, CURLOPT_URL, $submit_url);
		curl_setopt($curl, CURLOPT_VERBOSE, 0);
		curl_setopt($curl, CURLOPT_CAINFO,  '/wp-content/cert/PKI_Root_cacert.crt');
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		//print_r(' CAINFO: '.CURLOPT_CAINFO.'  '. getcwd() . '\\PKI_Root_cacert.crt');
		
		$payload = curl_exec($curl);
		
		$err = curl_errno($curl); 
		
		if($err == 0){
			$content  = trim(substr($payload, strpos($payload, "\n\r"))) ; //descard the header data that precedes the xml content
		}else{
			$content = 'Stock data could not be retrieved';
		}
		
		$header  = curl_getinfo($curl);
		$errmsg  = curl_error($curl) ; 

		$data['content']	= $content;
		$data['header'] = $header;
		$data['err'] = $err;
		$data['errmsg'] = $errmsg;
		
		curl_close($curl);
		//print_r($data['header']);
		//print_r($data['err']);
		//print_r($data['errmsg']);
		return $data;//['content'];
	}
	
	/*
	* pares xml data for RSS feed
	*/
	function getRSSFeed($content){
		$doc = new DOMDocument();
		$doc->loadXML($content);
		$arrFeeds = array();
		foreach ($doc->getElementsByTagName('item') as $node) {
			$itemRSS = array ( 
				'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
				'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
				'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
				'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
			);
		
		array_push($arrFeeds, $itemRSS);
		}
		
		return $arrFeeds;
	}
	
	function displaytickerdata($symbol, $timeout){
		$plugin_dir = plugin_dir_url( __FILE__ );
		//echo $symbol;
		$symbols = explode(",", $symbol);
		
		$canadian_rate_website = "https://itwl.safeway.com/ITWL/GetCDNExchange";
		$rss_data = $this->getUrlContent($canadian_rate_website);
		if($rss_data['err'] == 0){
			$canadian_rate = $rss_data['content'];
		}else{
			$canadian_rate = 0;
		}
		//echo 'canadia rate ' . $canadian_rate;
		
		$html_slider_start = '<div class="coda-slider hidden" id="coda-slider-1">';
		$html_panel_start = '<div class="panel"> <h2 class="title">Panel 1</h2>';
		$html_ticker1_start = 	'<UL id="ticker01">';
		$html_ticker2_start = 	'<UL id="ticker02">';	
		$html_data_us = '';
		$html_data_ca = '';
		foreach( $symbols as $s ) :
			$key_value = explode("=", $s);
			$key = $key_value[0];
			$value = $key_value[1];
			//$value = 'swy';
			if(function_exists('wp_cache_init')){
				if(wp_cache_get('sfystocktracker_html_data_us' . $key) != ''){
					//echo 'From cache';
					wp_cache_init();
					$cached_data_us = wp_cache_get('sfystocktracker_html_data_us' . $key);
					$cached_data_ca = wp_cache_get('sfystocktracker_html_data_ca' . $key);
					$cached_data_us = ($cached_data_us == '' ? '<li>' . $rss_data['content'] . '...</li>' : $cached_data_us);
					$cached_data_ca = ($cached_data_ca == '' ? '<li>' . $rss_data['content'] . '...</li>' : $cached_data_ca);
					$html_data_us = $html_data_us . $cached_data_us;
					$html_data_ca = $html_data_ca . $cached_data_ca;
					wp_cache_close() ;
				}else{
					//echo 'Not From cache';
					$html_data = $this->pull_data_from_rss($key,$value,$timeout,$canadian_rate);
					$html_data_us = $html_data_us . $html_data['html_data_us'];
					$html_data_ca = $html_data_ca . $html_data['html_data_ca'];
				}
			}else{
				$html_data = $this->pull_data_from_rss($key,$value,$timeout,$canadian_rate);
				$html_data_us = $html_data_us . $html_data['html_data_us'];
				$html_data_ca = $html_data_ca . $html_data['html_data_ca'];
			}
		endforeach;
		
		$html_ticker_end = '</ul>';
		$html_panel_end = '</div>';
		$html_slider_end = '</div>';
		
		$html_navigation = '<div id="coda-nav-1" class="coda-nav">' .
						'<a href="#1"><img style = "text-decoration: none;border: 0 none" src = "' . $plugin_dir . 'images/flag_us.jpg"/></a>' .
						'<a href="#2"><img style = "text-decoration: none;border: 0 none" src = "' . $plugin_dir . 'images/flag_ca.jpg"/></a>' .
						'</div>';
		
		$html_output = $html_slider_start . $html_panel_start . $html_ticker1_start . $html_data_us . $html_ticker_end . $html_panel_end . 
							$html_panel_start . $html_ticker2_start . $html_data_ca . $html_ticker_end . $html_panel_end . $html_navigation . $html_slider_end;
			
		echo $html_output;
		return;
	}
	
	function pull_data_from_rss($key,$value,$timeout,$canadian_rate){
		$plugin_dir = plugin_dir_url( __FILE__ );
		$html_data = array();
		
			$rss_data = $this->getUrlContent('https://itwl.safeway.com/ITWL/GetQuote?symbol=' . $value);
			$html_data_us = '';
			$temp_data_ca = '';
			if($rss_data['err'] == 0){
				$urlContent = $rss_data['content']; 
				$feed = $this->getRSSFeed($urlContent);
				
				foreach ( $feed as $feed_item) :
					$text = $feed_item['desc'];
					
					$text = preg_replace("/<.*?>/", "", $text); //purge all html tags
					$text = preg_replace("/&nbsp;/", " ", $text); //purge all &nbsp; 
					$data = preg_split("/[\s]+/",$text, -1, PREG_SPLIT_NO_EMPTY); //split the data based on space character
						
						
					$last = (array_key_exists(1, $data) == true ? $data[1] : "0");
					$last_ca = round($last * $canadian_rate, 2);
					
					$change = (array_key_exists(3, $data) == true ? $data[3] : "0");
					$change_ca = round($change * $canadian_rate, 2);
					
					$percent_change = (array_key_exists(6, $data) == true ? $data[6] : "0");
					$ticker_image = ((strpos($change, "-") === false) ? "tickertri.gif" : "tickertri_w.gif") ;
					
					$value_style = ((strpos($change, "-") === false) ? 'style="color:#2ff22f;padding:0px;margin:0px;"' : 'style="color:#fa5252;padding:0px;margin:0px;"');
					
					$key_style_start = (($key == 'SWY') ? '<span style="color:yellow;font-weight:bold;padding:0px;margin:0px;">' : '');
					$key_style_end = (($key == 'SWY') ? '</span>' : '');
					
					$logo_style = (($key == 'SWY') ? '<img style = "float:none" src="' . $plugin_dir . 'images/safeway.JPG" /> ' : '');
					
					$temp_data_us = '<li>' . $logo_style . $key_style_start . '(' . $key . ') ' . $key_style_end . '<span ' . $value_style. '>' . $last . ' ' .  $change . 
									'<img style = "float:none" src="' . $plugin_dir . 'images/' . $ticker_image . '" />' . $percent_change . '</span>...</li>';
					$temp_data_ca = '<li>' . $logo_style . $key_style_start . '(' . $key . ') ' . $key_style_end . '<span ' . $value_style. '>' . $last_ca . ' ' .  $change_ca . 
									'<img style = "float:none" src="' . $plugin_dir . 'images/' . $ticker_image . '" />' . $percent_change . '</span>...</li>';
					$html_data_us = $html_data_us . $temp_data_us;
					
					$html_data_ca = $html_data_ca . $temp_data_ca;
				endforeach;
				
				if(function_exists('wp_cache_init')){
					//echo $timeout;
					wp_cache_init();
					wp_cache_delete('sfystocktracker_html_data_us' . $key);
					wp_cache_delete('sfystocktracker_html_data_ca' . $key);
					wp_cache_add('sfystocktracker_html_data_us' . $key, $temp_data_us, 'default', $timeout);
					wp_cache_add('sfystocktracker_html_data_ca' . $key, $temp_data_ca, 'default', $timeout);
					wp_cache_close() ;
				}
			}else{
				$html_data_us = $html_data_us . '<li>' . $rss_data['content'] . '...</li>';
				$html_data_ca = $html_data_ca . '<li>' . $rss_data['content'] . '...</li>';
			}
		
		
		$html_data['html_data_us'] = $html_data_us;
		$html_data['html_data_ca'] = $html_data_ca;
		
		return $html_data;
	}
	
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for timeout value to remove HTML (important for text inputs). */
		$instance['symbols'] = strip_tags( $new_instance['symbols'] );
		$instance['timeout'] = strip_tags( $new_instance['timeout'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'timeout' => __('15'), 
		'symbols' => __('SWY=SWY,KR=KR,WAG=WAG,COST=COST,SVU=SVU,AHONY.PK=AHONY.PK,WFM=WFM,WMT=WMT'));
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
		
		<!-- Widget symbol: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'symbols' ); ?>">
				<?php _e('Symbol:'); ?>
			</label>
			<input id="<?php echo $this->get_field_id( 'symbols' ); ?>" 
				name="<?php echo $this->get_field_name( 'symbols' ); ?>" 
				value="<?php echo $instance['symbols']; ?>" style="width:100%;" />
		</p>

		<!-- Ticker refresh timeout Timeout: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'timeout' ); ?>">
				<?php _e('Timeout:'); ?>
			</label>
			<input id="<?php echo $this->get_field_id( 'timeout' ); ?>" 
				name="<?php echo $this->get_field_name( 'timeout' ); ?>" 
				value="<?php echo $instance['timeout']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
?>