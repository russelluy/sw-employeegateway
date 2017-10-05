
            
            <!-- BEGIN PAGE TITLE -->
            <h3><?php the_title();?></h3>
             <div id="page-title">              
             <?php if (have_posts()) : ?>
                  
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
                          
                                         
						  <?php the_content();?>
                          <div class="clr"></div><br />                                                          
                          </div><!-- end of post -->           
                          <?php endwhile;?>
                        <?php endif;?>                                                              
                     </div>
                 </div> 
                 <?php get_sidebar();?>                         
            </div> 
            <!-- END OF CONTENT -->
            
