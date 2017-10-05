<?php get_header();?>
            <!-- BEGIN PAGE TITLE -->
             <div id="page-title">   
                  <div class="title"><!-- your title page -->
                  	 <h1><?php echo __('Portfolio','agivee');?></h1>
                  </div>
	  		         </div>            
            <!-- END OF PAGE TITLE -->
            
            <!-- BEGIN CONTENT -->
            <div id="content-inner-full">
                <?php
                  global $post;
                  if ( have_posts() ) :
                  $counter = 0;
                  while ( have_posts() ) : the_post();
                  $image_thumbnail = get_post_meta($post->ID, '_image_thumbnail', true );
                  $portfolio_link = get_post_meta($post->ID, '_portfolio_link', true );
                  $image_link = ($portfolio_link) ? $portfolio_link : $image_thumbnail;
                  $counter++;  
                ?>
                
               	 <div class="portfolio-box"><!-- portfolio 1 -->
                 	<div class="pf-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></div>
                    <div class="pf-content">
                    <?php if ($image_thumbnail) : ?>
                      <a href="<?php echo $image_link;?>" rel="prettyPhoto[portfolio]" >
                        <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $image_thumbnail;?>&amp;h=192&amp;w=216&amp;zc=1" alt=""  class="imgportfolio imgbox"/>
                      </a>                    
                    <?php else : ?>
        							<?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>
                        <a href="<?php echo get_post_meta($post->ID,"thumbnail",true);?>" title="<?php the_title();?>" rel="prettyPhoto[portfolio]">							
                        <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=192&amp;w=216&amp;zc=1" alt=""/></a>
                      <?php endif; ?>
                    <?php endif; ?>
                    <p><?php excerpt(40);?></p>
                    <a href="<?php the_permalink();?>"><?php echo __('Detail info &raquo;','agivee');?></a>
                    </div>
                 </div>
                 <?php endwhile;?>
                 <?php endif; ?>
                 <div class="clr"></div>
                  <div class="blog-pagination"><!-- page pagination -->                                       	     			
                  <?php 
        				  if (function_exists('wp_pagenavi')) :
        				    wp_pagenavi();
        				  else : 
        				?>
              		<div class="navigation">
              			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries','agivee')) ?></div>
              			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;','agivee')) ?></div>
              			<div class="clear"></div>
              		</div>
                <?php endif;?>                           
                  </div>
                           
            </div> 
            <!-- END OF CONTENT -->
            
<?php get_footer();?>