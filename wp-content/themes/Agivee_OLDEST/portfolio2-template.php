<?php
/*
Template Name: Portfolio Alternative
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
            <div id="content-inner-full">
            	<div class="main-portfolio">
            	   <?php
            	   $porto_desc = get_option('Ag_porto_desc');
            	   echo "<p>$porto_desc</p>";
            	   ?>
            	   <div class="clr"></div>
                <?php
                  global $post;
                  $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                  $portfolio_cats_include = get_option('Ag_portfolio_cats_include');
                  if(is_array($portfolio_cats_include)) {
                    $portfolio_include = implode(",",$portfolio_cats_include);
                  } 
                  $porto_num = (get_option('Ag_porto_num2')) ? get_option('Ag_porto_num2') : 8;
                  $counter = 0;
                  query_posts('cat='.$portfolio_include.'&showposts='.$porto_num.'&paged='.$page);
                  if ( have_posts() ) :
                  while ( have_posts() ) : the_post();
                  $image_thumbnail = get_post_meta($post->ID, '_image_thumbnail', true );
                  $portfolio_link = get_post_meta($post->ID, '_portfolio_link', true );
                  $image_link = ($portfolio_link) ? $portfolio_link : $image_thumbnail;
                  
                  $counter++; 
                  $wp_query->is_home = false; 
                ?>
                    <div <?php if ($counter == 4 || $counter == 8) echo 'class="pf-gall-nomargin"'; else echo 'class="pf-gall"';?>><!-- portfolio 1 -->
                    <?php if ($image_thumbnail) : ?>
                      <a href="<?php echo $image_link;?>" rel="prettyPhoto[portfolio]" >
                        <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $image_thumbnail;?>&amp;h=122&amp;w=200&amp;zc=1" alt=""  class="pf-img"/>
                      </a>                    
                    <?php else : ?>                    
                      <?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>
                          <a  href="<?php echo get_post_meta($post->ID,"thumbnail",true);?>" title="<?php the_title();?>"  rel="prettyPhoto[portfolio]">							
                          <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=122&amp;w=200&amp;zc=1" alt="" class="pf-img" /></a>
                      <?php endif;?>
                    <?php endif;?>                          
                    </div>       
                    <?php endwhile;?>
                    <?php endif;?>  
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
            </div> 
            <!-- END OF CONTENT -->
            
            <?php get_footer();?>