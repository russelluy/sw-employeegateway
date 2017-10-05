<?php
/*
Template Name: Template New Page
*/
?>
<?php get_header();?>

<div class="new_menuwrap">
			<div class="new_menuwrap_wrap">
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
							  $services_page = get_option('Ag_services_pid');
							  agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
									} ?>
    </div>
    <a href="https://itwl.safeway.com/index.html" id="all_stocks"><img src="<?php bloginfo('template_directory');?>/images/flag_more.jpg" alt="More Stocks Info" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/flag_more_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/flag_more.jpg'" border="0"></a> </div>
</div>
</div>
</div>
<div class="clear"></div>
</div>
<div class="new_bodywrap">
  <div class="new_bodywrap_wrap">
    <div class="content_wrap">
      <div id="content1">
      
        
		
		
		
      <div id="content2">
        <div style="float:left;">
         <!-- start of Feature Focus -->
          <div style="width:971px;float:left;margin-top: 10px;margin-left: 7px;">
            
            <div class="ffocus_slidebox" style="width:970px; float:left; border: 1px solid #C8C8C8;background:#fff;"> 
              <div style="min-height: 300px; margin: 4px auto;width: 960px;#margin-top:4px;border:1px solid #ccc;">
               
               
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
            <br /><br />
            
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
            </div>
            <div class="clear"></div>
          </div>
          <!-- end of Feature Focus -->
          
          
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
</div>
</div>
<?php get_footer();?>












	








