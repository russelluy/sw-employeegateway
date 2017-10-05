<?php get_header();?>
            
            <!-- BEGIN PAGE TITLE -->
             <div id="page-title">
                <div class="title"><!-- your title page -->
                <?php if ( have_posts() ) :?>
               	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
               	  <?php /* If this is a category archive */ if (is_category()) { ?>
              		<h1><?php single_cat_title(); ?></h1>
               	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
              		<h1><?php echo __('Posts Tagged','agivee');?> <?php single_tag_title(); ?></h1>
               	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
              		<h1><?php echo __('Archive for','agivee');?> <?php the_time('F jS, Y'); ?></h1>
               	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
              		<h1><?php echo __('Archive for','agivee');?> <?php the_time('F, Y'); ?></h1>
               	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
              		<h1><?php echo __('Archive for','agivee');?> <?php the_time('Y'); ?></h1>
              	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
              		<h1><?php echo __('Author Archive','agivee');?></h1>
               	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
              		<h1><?php echo __('Blog Archives','agivee');?></h1>
               	  <?php } ?>
                </div>
      	  		</div>            
            <!-- END OF PAGE TITLE -->
            
            <!-- BEGIN CONTENT -->
            <div id="content-inner">
               	<div id="content-left">
                     <div class="maincontent">
                     <?php 
                     $testimonial_cat = get_option('Ag_testimonial_cid');
                     
                     if (is_category($testimonial_cat)) :                        
                      include (TEMPLATEPATH.'/category-testimonial.php');
                     else : ?>
                     <?php
                          while ( have_posts() ) : the_post();
                          $image_thumbnail = get_post_meta($post->ID, '_image_thumbnail', true );
                          $numtext = (get_option('Ag_blogtext')) ? get_option('Ag_blogtext') : 40;
                      	?>                     
                          <div class="blog-post">
                          <?php if ($image_thumbnail) : ?>
                            <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $image_thumbnail;?>&amp;h=134&amp;w=134&amp;zc=1" alt="" class="imgleft" />
                          <?php else : ?>
                            <?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>  
                              <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=134&amp;w=134&amp;zc=1" alt="" class="imgleft" />
                            <?php endif; ?>
                          <?php endif; ?>
                          <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                          <div class="blog-posted">
                          <?php the_time('F d, Y');?>&nbsp; | &nbsp; <?php echo __('Posted by ', 'agivee');?> : <?php the_author_posts_link();?>&nbsp; | &nbsp; <?php the_category(',');?> &nbsp; | &nbsp;  <?php comments_popup_link(__('0 Comment', 'agivee'),__('1 Comment', 'agivee'),__('% Comments', 'agivee'));?>&raquo;
                          </div><br /><br /><br />
                         <p><?php the_content();//excerpt($numtext);?></p>       
                          <div class="clear"></div>                   
                          </div>
                          <?php endwhile; endif;?>
                          <?php endif;?>
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