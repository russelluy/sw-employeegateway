<?php get_header();?>
            <!-- BEGIN PAGE TITLE -->
             <div id="page-title">  
             <?php if (have_posts()) : ?>        
                  <div class="title"><!-- your title page -->
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
              <?php while (have_posts()) : the_post();?>            
               	<div id="content-left">
                 <div class="maincontent">
                  <?php the_content();?>
                 </div>
               </div>
               <?php endwhile;?> 
               <?php endif;?>   
                    <?php get_sidebar();?>            
            </div>
            <!-- END OF CONTENT -->
  


<?php get_footer();?>
