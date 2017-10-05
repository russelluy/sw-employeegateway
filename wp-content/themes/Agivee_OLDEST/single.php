<?php get_header();?>
            
            <!-- BEGIN PAGE TITLE -->
             <div id="page-title">              
             <?php if (have_posts()) : ?>
                  <div class="title"><!-- your title page -->
                  	 <h1><?php the_title();?></h1>
                  </div>
	  		     </div>            
            <!-- END OF PAGE TITLE -->
            
            <!-- BEGIN CONTENT -->
            <div id="content-inner">
               	<div id="content-left">
                     <div class="maincontent">
                       <?php while (have_posts()) : the_post(); 
                          $image_thumbnail = get_post_meta($post->ID,"_image_thumbnail",true);
                          $portfolio_link = get_post_meta($post->ID,"_portfolio_link",true);             
                       ?> 
                          <div class="blog-post">      
                          <div class="blog-posted-inner">
                          <?php the_time('F d, Y');?>&nbsp; | &nbsp; <?php echo __('Posted by :','agivee');?> <?php the_author_posts_link();?>&nbsp; | &nbsp; <?php the_category(',');?> &nbsp; | &nbsp;  <?php comments_popup_link(__('0 Comment','agivee'),__('1 Comment','agivee'),__('% Comments','agivee'));?>&raquo;
                          </div>
                          <?php 
                            if ($portfolio_link) {
                              if (is_youtube($portfolio_link)) { ?>
                                <div class="movie_container"><a href="<?php echo $portfolio_link;?>?width=610&amp;height=305"  rel="youtube"></a></div>
                              <?php
                              } else if (is_vimeo($portfolio_link)) { ?>
                                <div class="movie_container"><a href="<?php echo $portfolio_link;?>"  rel="vimeo"></a></div>    
                              <?php  
                              } else if (is_quicktime($portfolio_link)) { 
                                ?>
                                <div class="movie_container"><a href="<?php echo $portfolio_link;?>?width=610&amp;height=305"  rel="quicktime"></a></div>
                                <?php
                              } else { ?>
                                <div class="movie_container"><a href="<?php echo $portfolio_link;?>?width=610&amp;height=305"  rel="flash"></a></div>
                                <?php
                              }
                            } else {
                            if ($image_thumbnail) : ?>
                            <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $image_thumbnail;?>&amp;h=134&amp;w=134&amp;zc=1" alt="" class="imgleft" />
                          <?php else : ?>
                            <?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>  
                              <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=134&amp;w=134&amp;zc=1" alt="" class="imgleft" />
                            <?php endif;
                            endif; 
                            }
                          ?>                              
						  <?php the_content();?>
                          <div class="clr"></div><br />
                          <?php if (function_exists('get_related_post')) { get_related_post();} ?>                                 
                          <div class="clr"></div>
                          <?php comments_template('', true); ?>                                                             
                          </div><!-- end of post -->           
                          <?php endwhile;?>
                        <?php endif;?>                                                              
                     </div>
                 </div> 
                 <?php get_sidebar();?>                         
            </div> 
            <!-- END OF CONTENT -->
            
            <?php get_footer();?>