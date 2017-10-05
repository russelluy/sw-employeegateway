<?php
/**
 * Plugin Name: SfyLinks Widget
 * Plugin URI: http://safeway.com/widget
 * Description: A widget captures news feed
 * Version: 0.1
 * Author: Iftekhat Amin Sadi
 * Author URI:
 */

add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');


/**
 * Add function to widgets_init that'll load the widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'sfy_load_widgetlinks' );

/**
 * Register this widget.
 * 'SfyStocktracker_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function sfy_load_widgetlinks() {
	register_widget( 'SfyLinks_Widget' );
}

	
/*register short code*/
add_shortcode( 'sfylinks', array('SfyLinks_Widget', 'sfylinks_func'));

/**
 * SfyStocktracker Widget class.
 * This class handles everything that needs to be handled with the widget:
 *
 * @since 0.1
 */

class SfyLinks_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function SfyLinks_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sfylinks', 'description' => __("A widget that shows links by group") );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sfynews-widget' );
		/* Create the widget. */
		$this->WP_Widget( 'sfylinks-widget', __('Safeway links widget'), $widget_ops, $control_ops );
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
	// [sfylinks group="resources" title="Communication" break=0 start = 0 end=0 timeout=30]
	//if start = 1 then start a column
	//if end = 1 then end a column
	//if break = 0 then ignore
	//if break = +ve number then give a column break after the specified number of links is printed out
	function sfylinks_func( $atts ) {
		$obj = new SfyLinks_Widget;
		
		extract( shortcode_atts( array(
			'group' => 'resources',
			'timeout' => 30,
			'title' => '',
			'title_link' => '',
			'break' => 0,
			'start' => 0,
			'end' => 0,
		), $atts ) );
		
		$timeout = $timeout*60; //conver to seconds
		
		/*$groups = explode(',',$group);
		foreach ($groups as $g):
			$group_data .= '\'' . $g . '\'' . ','; 
		endforeach;
		$group_data = rtrim($group_data, ',');*/
		$group = addslashes($group);		
		$content = $obj->get_links_by_group($group,$timeout, $title, $title_link, $break, $start, $end);		
		return $content;
	}
	
	
	function get_links_by_group($group,$timeout, $title, $title_link, $break, $start, $end){
		if(function_exists('wp_cache_init')){
			if(wp_cache_get('sfylinks_' . $group) != ''){
				//echo 'from cache';
				wp_cache_init();
				$content = wp_cache_get('sfylinks_' . $group);
				wp_cache_close() ;
			}else{
				//echo 'not from cache';
				$content = $this->pull_data_from_db($group, $title, $title_link, $break,$start,$end);
			}
		}else{
			$content = $this->pull_data_from_db($group,$title, $title_link, $break,$start,$end);
		}
		
		return $content;
	}
	
	function pull_data_from_db($group,$title,$title_link,$break,$start,$end){
		global $wpdb;
		
		$query = ' select links.link_id,links.link_url, links.link_name, links.link_target ' .
				' from wp_links as links join wp_term_relationships as termrel on links.link_id = termrel.object_id ' .
				' join wp_term_taxonomy as termtax on termrel.term_taxonomy_id = termtax.term_taxonomy_id ' .
				' join wp_terms as terms on termtax.term_id = terms.term_id where ' .
				' termtax.taxonomy = \'link_category\' and terms.name = \'' . $group . '\' order by links.link_name';
				
		$content .= ($start == 1 ? '<div class="black_rb_col">' : '');
		if($title_link != ''){
			$content .= '<a style="color:#9F0;font-family:verdana;font-size:13px;margin:10px 10px 20px 0;font-weight:bold;" href="' . $title_link . '" target="_blank">';
		}
		$content .= $title;
		if($title_link != ''){
			$content .= '</a>';
		}
		
		$content .= '<ul>';
		
		$result = $wpdb->get_results($query);
		$count = 1;
		foreach($result as $r){
			$content .= '<li>';
			$content .= '<a href = "' . $r->link_url . '" target = "' . $r->link_target . '">' . $r->link_name . '</a>';
			$content .= '</li>';
			
			if($count == $break){
				$content .= '</ul><div class="clear"></div></div><div class="black_rb_col"><ul>';
			}
			
			$count = $count + 1;
		}
		//$content .= 'test';
		$content .= '</ul>';
		$content .= ($end == 1 ? '<div class="clear"></div></div>' : '');
		
		return $content;
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