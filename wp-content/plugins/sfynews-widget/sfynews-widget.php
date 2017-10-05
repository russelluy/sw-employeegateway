<?php
/**
 * Plugin Name: SfyNews Widget
 * Plugin URI: http://safeway.com/widget
 * Description: A widget captures news feed
 * Version: 0.1
 * Author: Iftekhat Amin Sadi
 * Author URI:
 */

add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');


add_action('wp_print_scripts', 'sfynews_addscript');

function sfynews_addscript(){
	$plugin_dir = plugin_dir_url( __FILE__ );
	
	if(!is_admin()){
		wp_enqueue_script('jquery');
		wp_enqueue_script('sfynews', $plugin_dir . 'javascripts/sfynews.js', array('jquery'));
	}
}

 
 
/**
 * Add function to widgets_init that'll load the widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'sfy_load_widgetnews' );

/**
 * Register this widget.
 * 'SfyStocktracker_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function sfy_load_widgetnews() {
	register_widget( 'SfyNews_Widget' );
}

	
/*register short code*/
add_shortcode( 'newsfeed', array('SfyNews_Widget', 'newsfeed_func'));

/**
 * SfyStocktracker Widget class.
 * This class handles everything that needs to be handled with the widget:
 *
 * @since 0.1
 */

class SfyNews_Widget extends WP_Widget {

	/*feed url constants*/
	protected $feed_urls;
					
	/**
	 * Widget setup.
	 */
	function SfyNews_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sfynews', 'description' => __("A widget that shows news from feed") );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sfynews-widget' );
		/* Create the widget. */
		$this->WP_Widget( 'sfynews-widget', __('Safeway news widget'), $widget_ops, $control_ops );
		
		$this->feed_urls = array('feature' => 'http://news.safeway.com/Rss.aspx?FolderID=129',
					'industry' => 'http://news.safeway.com/Rss.aspx?FolderID=127',
					'rx' => 'http://news.safeway.com/Rss.aspx?FolderID=128');					
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
		
		//echo do_shortcode('[newsfeed]');
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	* shorcode functions
	*/
	// [newsfeed feed="industry" timeout=30]
	function newsfeed_func( $atts ) {
		$obj = new SfyNews_Widget;
		
		extract( shortcode_atts( array(
			'feed' => 'industry',
			'timeout' => 30,
		), $atts ) );
		$timeout = $timeout*60; //conver to seconds
		$content = $obj->feed_content($obj->feed_urls[$feed],$timeout);		
		return $content;
	}
	
	
	function feed_content($url,$timeout){
		if(function_exists('wp_cache_init')){
			if(wp_cache_get('sfynews_html_data' . $url) != ''){
				//echo 'from cache';
				wp_cache_init();
				$content = wp_cache_get('sfynews_html_data' . $url);
				wp_cache_close() ;
			}else{
				//echo 'not from cache';
				$content = $this->pull_data_from_rss($url,$timeout);
			}
		}else{
			$content = $this->pull_data_from_rss($url,$timeout);
		}
		
		return $content;
	}
	
	function pull_data_from_rss($url,$timeout){
		//echo 'timeout: ' . $timeout;
		$plugin_dir = plugin_dir_url( __FILE__ );
		$rss_data = $this->getUrlContent($url);
		if($rss_data['err'] == 0){
			$urlContent = $rss_data['content'];
			$feed = $this->getRSSFeed($urlContent);
			$content = '';
			
			foreach ( $feed as $feed_item) :
				$guid = $feed_item['guid'];
				$id = substr($guid, strpos($guid, "?")+1);
				$folderid = substr($url, strpos($url, "?")+1);
				$link = 'http://news.safeway.com/pagebuilder/ViewArticle.asp?' . $folderid . '&' . $id;

				$content = $content . '<p class="sfy_news_title" style="margin-bottom:0px;font-weight:bold;">';
				$title = strip_tags($feed_item['title']);
				$content = $content . '<a rel = "more_link" style="color:#287AE3;" href="' . $link . '">';
				$content = $content . $title;
				$content = $content . '</a>';

				$content = $content . '&nbsp;&nbsp;<a style="color: #FF0000;" href="mailto:?subject=News link&body=' . urlencode($link) . '">';
				$content = $content . '<img style="float:none;" src = "' . $plugin_dir . 'emailIcon.jpg"/>';
				$content = $content . '</a>';

				$content = $content . '</p>';
				
				$content = $content . '<p class="sfy_news_details" style="margin-bottom:10px;">';
				$desc = rtrim(strip_tags($feed_item['desc']),".");
				$content = $content . $desc;
							
				
				//$content = content . 'href="' . $link . '&' . folderid . '"';
				//$content = $content . '<a rel = "more_link" style="color: #FF0000;" href="' . $link . '">&nbsp;...&nbsp;more+</a>';

			
				$content = $content . '</p>';
				
				//$content = $content . $desc . '<br>';
			endforeach;
			
			if(function_exists('wp_cache_init')){
				wp_cache_init();
				wp_cache_delete('sfynews_html_data' . $url);
				wp_cache_add('sfynews_html_data' . $url, $content, 'default', $timeout);
				wp_cache_close() ;
			}
		}else{
			$content = $rss_data['content'];
		}
		
		return $content;
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
				'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
				'author' => $node->getElementsByTagName('author')->item(0)->nodeValue,
				'guid' => $node->getElementsByTagName('guid')->item(0)->nodeValue
			);
		
		array_push($arrFeeds, $itemRSS);
		}
		
		return $arrFeeds;
	}
	
	/*
	* Use curl to connet to server
	* ssl not required for this connect
	* Retrieve contents
	*/
	function getUrlContent($submit_url){
		$curl = curl_init();
		$params = '';
		//curl_setopt($curl, CURLOPT_SSLVERSION,2);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		curl_setopt($curl, CURLOPT_URL, $submit_url);
		curl_setopt($curl, CURLOPT_VERBOSE, 0);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		//curl_setopt($curl, CURLOPT_CAINFO,  '/wp-content/cert/PKI_Root_cacert.crt');
		//print_r(' CAINFO: '.CURLOPT_CAINFO.'  '. getcwd() . '\\PKI_Root_cacert.crt');
		
		$payload = 	curl_exec($curl);
		
		$err = curl_errno($curl); 
		
		if($err == 0){
			$content  = trim(substr($payload, strpos($payload, "\n\r"))) ; //descard the header data that precedes the xml content
		}else{
			$content = "News data cound not be retrieved";
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
	
	}
}
?>