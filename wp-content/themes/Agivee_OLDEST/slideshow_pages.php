             <?php $_slideshow_style = get_option('Ag_slideshow_style');?>
             <?php if ($_slideshow_style == 'style1') { ?> 
             <div id="slideshow">
                <?php
                  $featured_numtext = (get_option('Ag_numtext')) ? get_option('Ag_numtext') : 40;
                  foreach ($pages_array as $arr) :
                    $featured_slide = new WP_Query('page_id='.$arr);
                    while ($featured_slide->have_posts()): $featured_slide->the_post();
                    $thumbnail_image = get_post_meta($post->ID,'_page_thumbnail_image',true);
        					?>
                  <div class="slide-text">
                     <div class="img-slide">
                      <?php if ($thumbnail_image) : ?>
                        <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $thumbnail_image;?>&amp;h=283&amp;w=460&amp;zc=1" alt="<?php the_title(); ?>" class="slidehalf" />
                      <?php else : ?>
                        <?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>
                          <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=283&amp;w=460&amp;zc=1" alt="<?php the_title(); ?>" class="slidehalf" />
                        <?php else : ?>
                          <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php bloginfo('template_directory');?>/images/blank-images/nothumbnail-style1.jpg&amp;h=283&amp;w=460&amp;zc=1" alt="<?php the_title();?>" class="slidehalf"/>                     
                        <?php endif; ?>
                      <?php endif; ?>
                     </div>
                     <div class="text-slide">	
                     <h1><?php the_title();?></h1>
                     <p><?php excerpt($featured_numtext);?></p>
                     <a class="read_more" href="<?php the_permalink();?>"><?php echo __('Learn more &raquo;','agivee');?></a>
                     </div>
                  </div>
                <?php endwhile;?>
                <?php endforeach;?>
	  		     </div>
            <div id="box-nav-slider">
                <div id="slideshow-navigation"><div id="pager"></div></div>
            </div>
            <?php }else { ?>
             <div id="slideshow">
             <?php
                foreach ($pages_array as $arr) :
                $featured_slide = new WP_Query('page_id='.$arr);
                  while ($featured_slide->have_posts()): $featured_slide->the_post();
                  $thumbnail_image = get_post_meta($post->ID,'_page_thumbnail_image',true);
              ?>         
              <div class="slide-text">
              <?php if ($thumbnail_image) : ?>
                <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo $thumbnail_image;?>&amp;h=283&amp;w=460&amp;zc=1" alt="<?php the_title(); ?>" class="slidehalf" />
                <?php else : ?>
                  <?php if (get_post_meta($post->ID,"thumbnail",true)) : ?>
                  <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=283&amp;w=920&amp;zc=1" alt="<?php the_title(); ?>" class="slidehalf2" />
                  <?php else : ?>
                  <img src="<?php bloginfo('template_directory');?>/timthumb.php?src=<?php bloginfo('template_directory');?>/images/blank-images/nothumbnail-style2.jpg&amp;h=283&amp;w=920&amp;zc=1" alt="<?php the_title();?>" class="slidehalf2"/>                     
                <?php endif;?>
              <?php endif;?>	                     
              </div>
              <?php endwhile;?>
              <?php endforeach;?>
    	  		</div>
            <div id="box-nav-slider">
                <div id="slideshow-navigation"><div id="pager"></div></div>
            </div>
            <?php } ?>