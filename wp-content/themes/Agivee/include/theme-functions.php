<?php

/* Theme Functions  */
function excerpt($excerpt_length) {
  global $post;
	$content = $post->post_content;
	$words = explode(' ', $content, $excerpt_length + 1);
//	if(count($words) > $excerpt_length) :
//		array_pop($words);
//		array_push($words, '...');
//		$content = implode(' ', $words);
//	endif;
  
  $content = strip_tags($content);
  
	echo $content;

}

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div class="titlecomment">
			<?php echo get_avatar($comment,$size='48'); ?>
			<h3><?php comment_author_link() ?></h3>
			<span class="datecomment"><?php comment_date('F jS, Y') ?> on <?php comment_time() ?></span>
		</div>
		<div class="clear"></div>
  		<?php if ($comment->comment_approved == '0') : ?>
  		<p><?php echo __('Your comment is awaiting moderation.','agivee');?></p>
  		<?php endif; ?>
  		<?php comment_text() ?>
  		<div class="clear"></div>
      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>  			
	   </li>
<?php
}

function mytheme_ping($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			<?php echo get_avatar($comment,$size='48'); ?>
      <div class="placecomment">
        <h3><strong><?php comment_author_link() ?></strong>, <?php comment_date('F jS, Y') ?> on <?php comment_time() ?></h3>
        
  			<?php if ($comment->comment_approved == '0') : ?>
  			<p><?php echo __('Your comment is awaiting moderation.','agivee');?></p>
  			<?php endif; ?>
  			<p><?php comment_text() ?></p>
			</div>
      <div class="clear">
    </li>
<?php
}

function AG_add_javascripts() {
  wp_enqueue_scripts('jquery');
  //wp_enqueue_script( 'jquery.cycle.all', get_bloginfo('template_directory').'/js/jquery.cycle.all.js', array( 'jquery' ) );
  //wp_enqueue_script( 'jquery.prettyPhoto', get_bloginfo('template_directory').'/js/jquery.prettyPhoto.js', array( 'jquery' ) );
  //wp_enqueue_script( 'superfish', get_bloginfo('template_directory').'/js/superfish.js', array( 'jquery' ) );
  //wp_enqueue_script( 'functions', get_bloginfo('template_directory').'/js/functions.js', array( 'jquery' ) );
}

if (!is_admin()) {
  add_action( 'wp_print_scripts', 'AG_add_javascripts' ); 
}

add_action('wp_head', 'AG_add_stylesheet');

function AG_add_stylesheet() { ?>

<?php 
}

function get_related_post() {
  global $post;  
  echo '<div id="recentPostList">';
  echo '<div id="related-post-title"><h4>'.__('Related Posts','agivee').'</h4></div>';                                         
  $original_post = $post;
  $tags = wp_get_post_tags($post->ID);
  if ($tags) {
    $first_tag = $tags[0]->term_id;
    $args=array(
      'tag__in' => array($first_tag),
      'post__not_in' => array($post->ID),
      'showposts'=>2,
      'caller_get_posts'=>1
     );     
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) {
      while ($my_query->have_posts()) : $my_query->the_post(); 
      $image_thumbnail = get_post_meta($post->ID,"_image_thumbnail",true);
      ?>
          <div class="related-item-wrapper"><!-- related item -->                           
          <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
          <?php if ($image_thumbnail) : ?>
            <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $image_thumbnail;?>&amp;h=h=110&amp;w=150&amp;zc=1" alt="" class="imgleft" />
          <?php else : ?>          
            <?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>                 
            <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=110&amp;w=150&amp;zc=1" alt="" class="imgleft" />
            <?php endif; ?>
          <?php endif; ?>
          <?php excerpt(20);?>
          </div>          
      <?php endwhile;
    }
  }
  else {
    echo "<p>".__('There is no related post.','agivee')."</p>";
  }
  echo '</div>';
  
  $post = $original_post;
  wp_reset_query();  
}


function agivee_admin_add_javascripts() {
  wp_enqueue_script('jquery.tools.min', get_bloginfo('template_directory').'/js/tabs/jquery.tools.min.js', array('jquery'), '0.5');
}

if (is_admin()) {
  add_action( 'wp_print_scripts', 'agivee_admin_add_javascripts' );
}

/* Register Nav Menu Features For Wordpress 3.0 */
if (function_exists('register_nav_menus')) {
  register_nav_menus( array(
  	'topnav' => __( 'Main Navigation')
  ) );
}
/* Native Nagivation Pages List for Main Menu */
function agivee_topmenu_pages() {
  global $excludeinclude_pages;
  
  $excludeinclude_pages = get_option('Ag_excludeinclude_pages');
  if(is_array($excludeinclude_pages)) {
    $page_exclusions = implode(",",$excludeinclude_pages);
  }
?>
  <ul class="sf-menu">
    <li <?php if (is_home()) echo 'class="current"';?>><a href="<?php bloginfo('url');?>">Home</a></li>
    <?php wp_list_pages('title_li=&sort_column=menu_order&depth=4&exclude='.$page_exclusions);?>
  </ul> 

<?php
}

/* Remove Default Container for Nav Menu Features */
function agivee_nav_menu_args( $args = '' ) {
	$args['container'] = false;
	return $args;
} 
add_filter( 'wp_nav_menu_args', 'agivee_nav_menu_args' );

function get_shortcode_name($name) {
  if (strstr(get_shortcode_regex(),$name)) {
    return true;
  }
}

        
function detect_ext($file) {
  $ext = pathinfo($file, PATHINFO_EXTENSION);
  return $ext;
}

function is_quicktime($file) {
  $quicktime_file = array("mov","3gp","mp4");
  if (in_array(pathinfo($file, PATHINFO_EXTENSION),$quicktime_file)) {
    return true;
  } else {
    return false;
  }
}

function is_flash($file) {
  if (pathinfo($file, PATHINFO_EXTENSION) == "swf") {
    return true;
  } else {
    return false;
  }
}

function is_youtube($file) {
  if (preg_match('/youtube/i',$file)) {
    return true;
  } else {
    return false;
  }
}

function is_vimeo($file) {
  if (preg_match('/vimeo/i',$file)) {
    return true;
  } else {
    return false;
  }
}

function agivee_featuredproject($portocat,$num=2,$title) { 
  global $post;

  if(is_array($portocat)) {
    $portfolio_include = implode(",",$portocat);
  } else {
    $portfolio_include =  $portocat;
  }  
  ?>
  <?php echo $title;?>
     <div id="featured"><!-- begin of featured slider -->
     <?php
      $featured_portfolio = new WP_Query('cat='.$portfolio_include.'&showposts='.$num);
      
      while ($featured_portfolio->have_posts()) : $featured_portfolio->the_post();                             
      $image_thumbnail = get_post_meta($post->ID, '_image_thumbnail', true );
      $portfolio_link = get_post_meta($post->ID, '_portfolio_link', true );
      $image_link = ($portfolio_link) ? $portfolio_link : $image_thumbnail;      
      ?>
      <div class="featured-title">
     <div class="bg-featured">
     <?php if ($image_thumbnail) : ?>
     <a href="<?php echo $image_link;?>" rel="prettyPhoto[portfolio]"><img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $image_thumbnail;?>&amp;h=157&amp;w=274&amp;zc=1" alt="<?php the_title(); ?>" class="slidehalf" /></a>
     <?php else : ?>
       <?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>
         <a href="<?php get_post_meta($post->ID,"thumbnail",true);?>" rel="prettyPhoto[portfolio]">
         <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=157&amp;w=274&amp;zc=1" alt="<?php the_title(); ?>" class="slidehalf" /></a>
        <?php endif;?>
      <?php endif;?>
     </div><br />	
     <strong><a href="<?php the_permalink();?>"><?php the_title();?></a></strong><br />
     <p class="featured-text"><?php excerpt(20);?></p>
     </div>
     <?php endwhile;?>                             
 	 </div><!-- begin of featured slider -->
  
  <?php     
}

function agivee_serviceslist($service_page,$title) { 
  global $post;
  
  echo $title;
  ?>
  <?php
    $servicespid = get_page_by_title($service_page);
    query_posts('post_type=page&order=ASC&post_parent='.$servicespid->ID);
    $counter = 0; 
    while ( have_posts() ) : the_post();
    $thumbnail_image = get_post_meta($post->ID,'_page_thumbnail_image',true);
  ?>
  
     <p>
     <?php if ($thumbnail_image) : ?>
        <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $thumbnail_image;?>&amp;h=51&amp;w=49&amp;zc=1" alt="<?php the_title(); ?>" class="imgleft" />
     <?php else : ?>
      <?php if (get_post_meta($post->ID,"thumbnail",true)) { ?>  
        <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=51&amp;w=49&amp;zc=1" alt="<?php the_title(); ?>" class="imgleft" />
        <?php } ?>
      <?php endif;?>                     
     <strong><a href="<?php the_permalink();?>"><?php the_title();?></a></strong><br />
     <?php excerpt(8);?></p>    
     <div class="clr"></div>
    <?php endwhile;wp_reset_query();?>
  <!-- Services List End //-->      
  <?php
}


// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'agivee', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );


add_filter( 'category_template', 'my_category_template' );

function my_category_template() {
  
  $portfolio_cats_include = get_option('Ag_portfolio_cats_include');
  if(is_array($portfolio_cats_include)) {
    $portfolio_include = implode(",",$portfolio_cats_include);
  } 
  $testimonial_cat = get_option('Ag_testimonial_cid');
  
  if(is_array($portfolio_cats_include)) {
    foreach ($portfolio_cats_include as $catinclude) {
      if( is_category($catinclude))
        $template = locate_template( array( 'category-portfolio.php', 'category.php' ) );
      } 
  } else {
    if (is_category($portfolio_cats_include))
      $template = locate_template( array( 'category-portfolio.php', 'category.php' ) );
    elseif( is_category( $testimonial_cat) ) 
		  $template = locate_template( array( 'category-testimonial.php', 'category.php' ) );
    else 
      $template = locate_template( array( 'archive.php', 'category.php' ) );
  }
  return $template;
}

?>