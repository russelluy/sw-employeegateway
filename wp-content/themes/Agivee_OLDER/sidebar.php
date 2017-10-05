                
                 <div id="side-box">
                 <?php
                  if($post->post_parent) {
                    $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&depth=1");
                  }else{
                    $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&depth=1");
                  }  
                  ?>
                  <?php if ($children) { ?>
                   	 <div class="maincontent">
                     <h2><?php echo __('More ','agivee');?><?php echo get_the_title($post->post_parent);?></h3>              
                     <ul class="blog-list">
                     	<?php echo $children;?>
                     </ul>                                                  
                     </div>                  
                <?php 
                  }
                ?>
                 
                    <?php 
                    if (is_page()) {
                    $pageslist = get_pages('parent=-1');
                    foreach ($pageslist as $pageitem) {
                      if (is_page($pageitem->ID)) {
                        $pagetitle = get_the_title($pageitem->ID);
                        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("$pagetitle")) :  
                          if (function_exists('dynamic_sidebar') && dynamic_sidebar('General Sidebar')) : endif;
                        endif; 
                      }
                    }
                    } else {
                      if (function_exists('dynamic_sidebar') && dynamic_sidebar('General Sidebar')) : endif;                     
                    }
                    ?>                                    
                 </div>     