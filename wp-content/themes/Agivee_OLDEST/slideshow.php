		<?php 
    
      $pages_or_posts = get_option('Ag_pages_or_posts');
      $featured_pages = get_option('Ag_featured_pages');
      $excludeinclude_pages = get_option('Ag_featured_pages');
      if(is_array($excludeinclude_pages)) {
        $page_exclusions = implode(",",$excludeinclude_pages);
      }      
      $pages_array    = split(",",$page_exclusions);
      $pages_array    = array_diff($pages_array,array(""));
			
			if ($pages_or_posts == "pages") {
			 include (TEMPLATEPATH.'/slideshow_pages.php');
			}
      else if ($pages_or_posts == "posts") {
        include (TEMPLATEPATH.'/slideshow_posts.php');
      }
      else {
        include (TEMPLATEPATH.'/slideshow_posts.php');
      }
      
    ?>