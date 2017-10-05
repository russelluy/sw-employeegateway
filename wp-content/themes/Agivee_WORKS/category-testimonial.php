                 <?php if (have_posts()) : ?>
                 <?php while (have_posts()) : the_post();?>
                   <blockquote>
                   <p><?php the_content();?></p>
                   </blockquote>
                   <strong><?php the_title();?></strong><div class="clr"></div><br />
                   <?php endwhile;?>
                   <?php endif;?>