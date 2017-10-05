<?php
/*
Template Name: Template Learnlet Modal
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<script>
var beforeload = (new Date()).getTime();
</script>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"  />
<link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/images/myfavicon.ico" type="image/x-icon" />
<title><?php if (is_home () ) { bloginfo('name'); echo " - "; bloginfo('description'); 
} elseif (is_category() ) {single_cat_title(); echo " - "; bloginfo('name');
} elseif (is_single() || is_page() ) {single_post_title(); echo " - "; bloginfo('name');
} elseif (is_search() ) {bloginfo('name'); echo " search results: "; echo wp_specialchars($s);
} else { wp_title('',true); }?></title>
<meta name="generator" content="Bluefish 2.0.3" />
<meta name="robots" content="follow, all" />
<?php wp_enqueue_script("jquery"); ?>
<?php wp_enqueue_script("jquery-ui-core"); ?>
<?php wp_head(); ?>

</head>
  <div style="margin-top:-10px;">

            
            <!-- BEGIN CONTENT -->
            <div id="content-inner-full">
              <?php if (have_posts()) { ?>
              <?php while (have_posts()) : the_post();?>
               <div class="maincontent">
                <?php the_content();?>
               </div>
               <?php endwhile;?>
                 <?php } ?> 
                 
                 <?php get_sidebar();?>                    
            </div>
            <!-- END OF CONTENT -->
               
  </div>
  <div style="display:none;">
		<?php get_footer();?>
	</div>










	








