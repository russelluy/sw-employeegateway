<?php
/*
Template Name: Blog
*/
?>

<?php get_header();?>
            
            <!-- BEGIN PAGE TITLE -->
             <div id="page-title">              
                  <div class="title"><!-- your title page -->
                  	 <h1><?php the_title();?></h1>
                  </div>
                  <?php $data = get_post_meta($post->ID, '_short_desc', true ); ?>
                  <?php if ($data) : ?>
                  <div class="desc"><!-- description about your page -->
                  <?php echo $data;?>
                  </div>
                  <?php endif;?>
	  		</div>            
            <!-- END OF PAGE TITLE -->
            
            <!-- BEGIN CONTENT -->
            <div id="content-inner">
               	<div id="content-left">
                     <div class="maincontent">
                     <?php
                          $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                          $blog_cats_include = get_option('Ag_blog_cats_include');
                          if(is_array($blog_cats_include)) {
                            $blog_include = implode(",",$blog_cats_include);
                          }
                          $blog_num = get_option('Ag_blog_num');
                          $numtext = (get_option('Ag_blogtext')) ? get_option('Ag_blogtext') : 40;
                          query_posts("cat=$blog_include&showposts=$blog_num&paged=$page");
                  
                          if ( have_posts() ) : 
                          while ( have_posts() ) : the_post();
                          $image_thumbnail = get_post_meta($post->ID, '_image_thumbnail', true );                        
                          $wp_query->is_home = false;
                      	?>                     
                          <div class="blog-post">
                          <?php if ($image_thumbnail) : ?>
                            <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $image_thumbnail;?>&amp;h=134&amp;w=134&amp;zc=1" alt="" class="imgleft" />
                          <?php else : ?>
                            <?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>  
                              <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=134&amp;w=134&amp;zc=1" alt="" class="imgleft" />
                            <?php endif; ?>
                          <?php endif; ?>
                          <h2><a href="<?php the_title();?></h2>
                          <div class="blog-posted">
                          <?php the_time('F d, Y');?>&nbsp; | &nbsp; <?php echo __('Posted by ', 'agivee');?> : <?php the_author_posts_link();?>&nbsp; | &nbsp; <?php the_category(',');?> &nbsp; | &nbsp;  <?php comments_popup_link(__('0 Comment', 'agivee'),__('1 Comment', 'agivee'),__('% Comments', 'agivee'));?>&raquo;
                          </div><br /><br /><br />
                          <p><?php excerpt($numtext);?></p>       
                          <div class="clear"></div>                   
                          </div>
                          <?php endwhile; endif;?>
                          <div class="blog-pagination"><!-- page pagination -->                                       	     			<?php 
                				  if (function_exists('wp_pagenavi')) :
                				    wp_pagenavi();
                				  else : 
                				?>
                      		<div class="navigation">
                      			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries', 'agivee')) ?></div>
                      			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;', 'agivee')) ?></div>
                      			<div class="clear"></div>
                      		</div>
                        <?php endif;?>                           
                          </div>                                  
                     </div>
                 </div>   
                 <?php wp_reset_query();?>
                 <?php get_sidebar();?>                      
            </div> 
            <!-- END OF CONTENT -->
            
            <?php get_footer();?>