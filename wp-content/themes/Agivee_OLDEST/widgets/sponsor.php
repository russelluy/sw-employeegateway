                     <div class="maincontent">
                     <?php echo ($bannertitle) ? $bannertitle : __('Sponsor','agivee');?>             
                     	<div id="sponsors">
                         <?php 
                          $banner1_img  = get_option('Ag_banner1');
                          $banner1_url  = get_option('Ag_banner1_url');
                          $banner2_img  = get_option('Ag_banner2');
                          $banner2_url  = get_option('Ag_banner2_url');
                          $banner3_img  = get_option('Ag_banner3');
                          $banner3_url  = get_option('Ag_banner3_url');
                          $banner4_img  = get_option('Ag_banner4');
                          $banner4_url  = get_option('Ag_banner4_url');
                          ?>                     	
                        	<div class="banner-img">
                            <a href="<?php if ($banner1_url)echo $banner1_url;?>"><img src="<?php if ($banner1_img) echo $banner1_img;else echo bloginfo('template_directory').'/images/sponsors/tf_260x120_v2.gif';?>" alt=""  /></a></div>
                          <div class="banner-img"><a href="<?php if ($banner1_url)echo $banner2_url;?>"><img src="<?php if ($banner1_img) echo $banner2_img;else echo bloginfo('template_directory').'/images/sponsors/gr_260x120_v1.gif';?>" alt=""  /></a></div>
                            <div class="banner-img"><a href="<?php if ($banner1_url)echo $banner3_url;?>"><img src="<?php if ($banner1_img) echo $banner3_img;else echo bloginfo('template_directory').'/images/sponsors/ad_260x120_v3.gif'?>" alt=""  /></a></div>
                            <div class="banner-img"><a href="<?php if ($banner1_url)echo $banner4_url;?>"><img src="<?php if ($banner1_img) echo $banner4_img;else echo bloginfo('template_directory').'/images/sponsors/aj_260x120_v1.gif';?>" alt=""  /></a></div>
                        </div>                                            
                     </div>