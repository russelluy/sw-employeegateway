<?php
/*
Template Name: Services
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
                     <h2>What we offers ?</h2>
                        <?php
                          global $post;
                          
                          $services_page = get_option('Ag_services_pid');
                          $servicespid = get_page_by_title($services_page);
                          if ($post->ID) {
                            query_posts('post_type=page&order=ASC&post_parent='.$post->ID);
                          } else {
                            query_posts('post_type=page&order=ASC&post_parent='.$servicespid->ID);
                          }
                          $counter = 0; 
                          while ( have_posts() ) : the_post();
                          $thumbnail_image = get_post_meta($post->ID,'_page_thumbnail_image',true);
                          $counter++;
                      	?>
                         <div class="service-item">
                          <div class="services-icon">
                              <?php if ($thumbnail_image) : ?>
                                <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $thumbnail_image;?>&amp;h=67&amp;w=67&amp;zc=" alt="" class="imgleft" />
                              <?php else : ?>                          
                                <?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>  
                                  <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=67&amp;w=67&amp;zc=1" alt="" class="imgleft" />
                                  <?php endif;?>
                              <?php endif;?>
                              </div>
                            <p><strong><a href="<?php the_permalink();?>"><?php the_title();?></a></strong><br />
                            <?php excerpt(20);?>
                            </p>
                         </div>	
                         <?php if ($counter ==1 || $counter ==3) echo '<div class="spacer">&nbsp;</div>';?>                         
                         <?php endwhile;?>
                     </div>
                 </div>            
                 <?php wp_reset_query();?>
                 <?php get_sidebar();?>             
            </div> 
            <!-- END OF CONTENT -->
            
            <?php get_footer();?>