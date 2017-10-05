             <?php $_slideshow_style = get_option('Ag_slideshow_style');?>
             <?php if ($_slideshow_style == 'style1') { ?> 
             <div id="slideshow">
                <?php
        					 global $post;
        					 $featured_cat = get_option('Ag_featured_cat');
        					 $featured_num = get_option('Ag_featured_number');
        					 $featured_numtext = (get_option('Ag_numtext')) ? get_option('Ag_numtext') : 40;
        					 $featured_slide = new WP_Query('category_name='.$featured_cat.'&showposts='.$featured_num);
        					 while ($featured_slide->have_posts()): $featured_slide->the_post();
        					 $image_thumbnail = get_post_meta($post->ID,"_image_thumbnail",true);
        					?>
                  <div class="slide-text">
                     <div class="img-slide">
                     <?php if ($image_thumbnail) : ?>
                      <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $image_thumbnail;?>&amp;h=283&amp;w=460&amp;zc=1" alt="<?php the_title(); ?>" class="slidehalf" />
                     <?php else : ?>
                        <?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>
                        <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=283&amp;w=460&amp;zc=1" alt="<?php the_title(); ?>" class="slidehalf" />
                        <?php else : ?>
                        <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php bloginfo('template_directory');?>/images/blank-images/nothumbnail-style1.jpg&amp;h=283&amp;w=460&amp;zc=1" alt="<?php the_title();?>" class="slidehalf"/>                     
                      <?php endif;?>
                    <?php endif;?>
                     </div>
                     <div class="text-slide">	
                     <h1><?php the_title();?></h1>
                     <p><?php excerpt($featured_numtext);?></p>
                     <a class="read_more" href="<?php the_permalink();?>"><?php echo __('Learn more &raquo;','agivee');?></a>
                     </div>
                  </div>
                <?php endwhile;?>
	  		     </div>
            <div id="box-nav-slider">
                <div id="slideshow-navigation"><div id="pager"></div></div>
            </div>
            <?php }else { ?>
             <div id="slideshow">
             <?php
    					 global $post;
    					 $featured_cat = get_option('Ag_featured_cat');
    					 $featured_num = get_option('Ag_featured_number');
    					 $featured_numtext = (get_option('Ag_numtext')) ? get_option('Ag_numtext') : 40;
    					 $featured_slide = new WP_Query('category_name='.$featured_cat.'&showposts='.$featured_num);
    					 while ($featured_slide->have_posts()): $featured_slide->the_post();
    					 $image_thumbnail = get_post_meta($post->ID,"_image_thumbnail",true);
              ?>         
              <div class="slide-text">
                <?php if ($image_thumbnail) : ?>
                  <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $image_thumbnail;?>&amp;h=283&amp;w=920&amp;zc=1" alt="<?php the_title(); ?>" class="slidehalf2" />
                <?php else : ?>
                  <?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>
                  <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=283&amp;w=920&amp;zc=1" alt="<?php the_title(); ?>" class="slidehalf2" />
                  <?php else : ?>
                  <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php bloginfo('template_directory');?>/images/blank-images/nothumbnail-style2.jpg&amp;h=283&amp;w=920&amp;zc=1" alt="<?php the_title();?>" class="slidehalf2"/>                     
                <?php endif;?>   
              <?php endif;?>                  
              </div>
              <?php endwhile;?>
    	  		</div>
            <div id="box-nav-slider">
                <div id="slideshow-navigation"><div id="pager"></div></div>
            </div>
            <?php } ?>