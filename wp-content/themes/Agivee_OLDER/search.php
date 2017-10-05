<?php get_header();?>
		<div style="background:#000;">
            <div class="bottom-header-bg">
	                <div id="bottom-header">
	                	<div id="nav-menu">
	                    <?php
	                      if (function_exists('wp_nav_menu')) { 
	                        wp_nav_menu( array('container_id'=>'','menu_id'=>'', 'menu_class' => 'sf-menu', 'theme_location' => 'topnav','fallback_cb'=>'agivee_topmenu_pages','sort_column' => 'menu_order', 'depth' =>3 ) );
	                      } else {  
	                        agivee_topmenu_pages();
	                      } ?>                          	
	                                             
	                    </div>
	                    <div id="sw_ticker">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Stock Tracker')) {
									} ?>
						</div>
						<a href="https://itwl.safeway.com/index.html" id="all_stocks"><img src="<?php bloginfo('template_directory');?>/images/flag_more.jpg" alt="More Stocks Info" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/flag_more_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/flag_more.jpg'" border="0"></a>

	                </div>
             	</div>
            </div>
           </div>
          <div class="clear"></div>
         </div>
            
          <div class="new_bodywrap">
			<div class="new_bodywrap_wrap">
					<div class="content_wrap_search">
					
		               	 <div id="content1">
			                  
		                 	  	<div class="clear"></div>
		                 	  </div>
		                 	  </div>
		                 	  
		                 	  <div class="contentbox_1search" style="float:left;background:#FFF;border: 1px solid #CCC;float: left;padding: 5px;width: 965px;margin-bottom:10px;">
		                 	  				
			                  			<!-- BEGIN PAGE TITLE -->
									             <div id="page-title">
									                <div class="title"><!-- your title page -->
									                  <h1><?php echo __('Search Results for ','agivee');?> "<?php echo $s;?>"</h1>
									                </div>
									      	  		</div>            
									            <!-- END OF PAGE TITLE -->
									            
									            <!-- BEGIN CONTENT -->
									            <div id="content-inner_search">
									               	<div id="content-left_search">
									                     <div class="maincontent_search">
									                        <?php if ( have_posts() ) :?>
									                        <?php while ( have_posts() ) : the_post(); ?>                     
									                          <div class="blog-post">
									                          <?php if (get_post_meta($post->ID,"thumbnail",true)) { ?>  
									                            <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=134&amp;w=134&amp;zc=1" alt="<?php the_title(); ?>" class="imgleft" />
									            <?php } else { ?>
									                    <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo bloginfo('template_directory');?>/images/blank-images/nothumbnail-blog.jpg&amp;h=134&amp;w=134&amp;zc=1" alt="<?php the_title(); ?>" class="imgleft" />               
									                  <?php } ?>
									                          <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
									                          <div class="blog-posted_search">
									                          <?php the_time('F d, Y');?>&nbsp; | &nbsp; <?php echo __('Posted by ');?>: <?php the_author_posts_link();?>&nbsp; | &nbsp; <?php the_category(',');?> &nbsp; | &nbsp;  <?php comments_popup_link(__('0 Comment','agivee'),__('1 Comment','agivee'),__('% Comments','agivee'));?>&raquo;
									                          </div>
									                          <p><?php excerpt(40);?></p>       
									                          <div class="clear"></div>                   
									                          </div>
									                          <?php endwhile;?>
									                          <?php else : ?>
									                          <h2><?php echo __('Nothing Found!','agivee');?></h2>
									                          <h4><?php echo __('try different search?','agivee');?></h4>
									                          <?php get_search_form();?>
									                          <?php endif;?>
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
									                 </div>   
									                 <?php wp_reset_query();?>
									                              
									            </div> 
									            <!-- END OF CONTENT -->
		                    		</div>
		                 		</div>
		                
		                  <div class="clear"></div>
	                 </div>
                 	<div class="clear"></div>
                </div>
              </div>
           </div>
		<script type="text/javascript">     
			jQuery(function ($) {
		/* You can safely use $ in this code block to reference jQuery */
				$(document).ready(function() {
					// do stuff when DOM is ready
					$("a#mission_vision").fancybox({
						'width'				: 970,
						'height'			: 589,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
				});
			});
	</script>
                 
        <?php get_footer();?>
        
        