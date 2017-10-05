<?php get_header();?>

<div class="bottom-header-bg">
  <div id="bottom-header">
    <div id="nav-menu">
      <?php
	                      if (function_exists('wp_nav_menu')) { 
	                        wp_nav_menu( array('container_id'=>'','menu_id'=>'', 'menu_class' => 'sf-menu', 'theme_location' => 'topnav','fallback_cb'=>'agivee_topmenu_pages','sort_column' => 'menu_order', 'depth' =>3 ) );
	                      } else {  
	                        
	                      } ?>
    </div>
    <div id="sw_ticker">
      <?php /*if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Stock Tracker')) {
							  
									}*/ ?>
						<img src="<?php bloginfo('template_directory');?>/images/ie6_notcompatible7.jpg" alt="not compatible" style="position:absolute;margin-left:-100px;margin-top:2px;" />			
    </div>
    <a href="https://itwl.safeway.com/index.html" target="_blank" id="all_stocks"><img src="<?php bloginfo('template_directory');?>/images/flag_more.jpg" alt="More Stocks Info" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/flag_more_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/flag_more.jpg'" border="0"></a> </div>
</div>
</div>
</div>
<div class="clear"></div>
</div>
<div class="new_bodywrap">
  <div class="new_bodywrap_wrap">
    <div class="content_wrap">
      <div id="content1">
        <div class="contentbox_1">
          <div class="contentbox_1top"> <img src="<?php bloginfo('template_directory');?>/images/redtab_1.jpg" alt="Featured Sites" border="0" /> </div>
          <div class="contentbox_1box">
            <div class="contentbox_1boxin">
              <?php 
if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Featured Sites')) {
						                    } ?>
            </div>
          </div>
          <div class="clear"></div>
        </div>
<div class="contentbox_2">
          <div class="contentbox_2top"> <img src="<?php bloginfo('template_directory');?>/images/redtab_4.jpg" alt="Organizational Changes" border="0" /> <a href="<?php echo get_bookmark_field( 'link_url', 9 );?>" id="request_plus_featuredpromotions"><img src="<?php bloginfo('template_directory');?>/images/greentab4.jpg" alt="Request" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greentab4_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greentab4.jpg'" border="0"></a> </div>
          <div class="contentbox_2box">
            <div class="contentbox_2boxin">
              <div id="content3">
                <div class="maincontent">
                  <?php 
																	/*if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Org Changes')) {
												                    }*/
																	$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
																	$temp = $wp_query;
																	$wp_query= null;
																	$wp_query = new WP_Query();
																	$wp_query->query("paged=$page&cat=36&posts_per_page=10");
																	echo '<ul>';
																	while ($wp_query->have_posts()) : 
																		$wp_query->the_post();
																		echo '<li>' . $post->post_content . '</li>';
																	endwhile;
																	echo '</ul><div class="clear"></div>';
																	if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
																	$wp_query = null; $wp_query = $temp;
																	?>
                </div>
              </div>
            </div>
          </div>
          <div class="clear"></div>
        </div>
        <div class="contentbox_1">
          <div class="contentbox_1top"> <a id="link_navi_gator"><img src="<?php bloginfo('template_directory');?>/images/redtab_10b.jpg" alt="Navigator" border="0" /></a> <a href="#" id="link_about_me"><img src="<?php bloginfo('template_directory');?>/images/redtab_10c.jpg" alt="About Me" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/redtab_10c_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/redtab_10c.jpg'" border="0"></a> </div>
          <div class="contentbox_1box">
            <div class="aboutme_contentbox_2boxin" style="background:#dedede;height: 245px;margin:5px;#width:278px;"> <!--<a id="quickguide" class="poplight" href="#">Quick Guide</a> -->
            
              <div id="widget_navigator">
                <?php /*if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Navigator')) {
						                     
						                    }*/ ?>
				<img src="<?php bloginfo('template_directory');?>/images/ie6_notcompatible4.jpg" alt="not compatible" style="position:relative;left:-6px;margin-top:-5px;"/>
              </div>
              <div id="widget_about-me" style = "display:none">
                <?php /*if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('About Me')) {
						                     
						                    }*/ ?>
				<img src="<?php bloginfo('template_directory');?>/images/ie6_notcompatible5.jpg" alt="not compatible" style="position:relative;left:-6px;margin-top:-5px;"/>
              </div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="clear"></div>
        </div>
        
      </div>
      <div id="content2">
        <div style="float:left;">
          <div style="width:660px;float:left;margin-right: 10px;">
            <div style="width:333px; height:19px;float:left;"> <img src="<?php bloginfo('template_directory');?>/images/redtab_3.jpg" alt="Feature Focus" border="0" /> <a href="<?php bloginfo('template_directory');?>/notice/index_ie6.html" target="_blank" ><img src="<?php bloginfo('template_directory');?>/images/yellowtab2.jpg" alt="Notices" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/yellowtab2_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/yellowtab2.jpg'" border="0"></a> <a id="safeway_advertisement" href="<?php bloginfo('template_directory');?>/ads/safewayads.html" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/yellowtab3.jpg" alt="Ads" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/yellowtab3_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/yellowtab3.jpg'" border="0"></a> <a href="<?php echo get_bookmark_field( 'link_url', 8 );?>" id="request_plus_featuredfocus"><img src="<?php bloginfo('template_directory');?>/images/greentab_3.jpg" alt="Request" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greentab_3_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greentab_3.jpg'" border="0"></a> </div>
            <div style="width:671px; height:318px;float:left; border: 1px solid #C8C8C8;background:#fff;"> 
              <div style="height: 318px;margin: 4px auto;width: 660px;#margin-top:4px;">
                <!--<img src="<?php /*bloginfo('template_directory');*/?>/images/ie6_notcompatible1.jpg" alt="not compatible" />-->
                 <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Feature Focus')) {
						                     
					                    } ?>
                
              </div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="content2_mid" style="float:left;margin-top:6px;width:677px;">
            <div class="content2_bottom" style="float:left;margin-top:3px;width:685px;">
              <div class="contentbox_7a">
                <div class="contentbox_7atop"> <a href= "#" id = "link_featured"> <img src="<?php bloginfo('template_directory');?>/images/redtab2.jpg" alt="Featured News" border="0" /></a> <a href="#" id = "link_industry"><img src="<?php bloginfo('template_directory');?>/images/yellowtab4.jpg" alt="Industry News" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/yellowtab4_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/yellowtab4.jpg'" border="0"></a> <a href="#" id = "link_pharmacy"><img src="<?php bloginfo('template_directory');?>/images/yellowtab.jpg" alt="Rx" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/yellowtab_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/yellowtab.jpg'" border="0"></a> <a href="<?php echo get_bookmark_field( 'link_url', 10 );?>" id="request_plus_news"><img src="<?php bloginfo('template_directory');?>/images/greentab2.jpg" alt="Request" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greentab2_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greentab2.jpg'" border="0"></a> </div>
                <div class="contentbox_7abox" style="width:672px; float:left; border: 1px solid #C8C8C8;background:#fff;">
                  <div class="contentbox_7aboxin" style="background:#f4f4f4;height: 140px;margin: 4px auto;width: 664px;">
                    <div style="color: #666666; font-family: verdana; font-size: 11px;">
                      <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Industry News')) {
						                    } ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clear"></div>
            </div>
            <div class="contentbox_7" style="margin-top: 20px;">
              <div class="contentbox_7top"> <img src="<?php bloginfo('template_directory');?>/images/redtab_7.jpg" alt="Featured Videos" border="0" /> <a href="http://video.safeway.com/viewerportal/safeway/login.vp?redirectUrl=home.vp"  target="_blank"><img src="<?php bloginfo('template_directory');?>/images/greytab_7a.jpg" alt="Video Exchange" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greytab_7a_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greytab_7a.jpg'" border="0"></a> <a href="<?php echo get_bookmark_field( 'link_url', 12 );?>"  target="_blank"><img src="<?php bloginfo('template_directory');?>/images/greytab_7b.jpg" alt="All Videos" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greytab_7b_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greytab_7b.jpg'" border="0"></a> </div>
              <div class="contentbox_7box" style="width:672px; height:109px;float:left; border: 1px solid #C8C8C8;background:#fff;">
                <div class="contentbox_7boxin" style="background:#fff;height: 105px;margin: 4px auto;width: 664px;">
                  <?php /*if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Video Carousel')) {
												                    }*/ ?>
					<img src="<?php bloginfo('template_directory');?>/images/ie6_notcompatible6.jpg" alt="not compatible" />												
                </div>
              </div>
              <div class="clear"></div>
            </div>
          </div>
          <div class="content2_bottom" style="float:left;margin-top:19px;width:690px;">
            <div style="width:333px;float:left;margin-right: 10px;">
              <div style="width:335px; height:19px;float:left;"> <img src="<?php bloginfo('template_directory');?>/images/redtab_5b.jpg" alt="Question of the week" border="0" /> <a id="link_qtw_comment" href="<?php echo get_bookmark_field( 'link_url', 249 );?>"  target="_blank"><img src="<?php bloginfo('template_directory');?>/images/yellowtab_5b.jpg" alt="Comments" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/yellowtab_5b_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/yellowtab_5b.jpg'" border="0"></a> <a id="requestplus_ques_week" href="<?php echo get_bookmark_field( 'link_url', 250 );?>"  target="_blank"><img src="<?php bloginfo('template_directory');?>/images/greentab_5b.jpg" alt="Request" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greentab_5b_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greentab_5b.jpg'" border="0"></a> </div>
              <div style="width:331px; height:288px;float:left; border: 1px solid #C8C8C8;background:#fff;">
                <div style="background: #f4f4f4;height: 280px;margin: 4px auto;width: 321px;">
                  <img src="<?php bloginfo('template_directory');?>/images/ie6_notcompatible2.jpg" alt="not compatible" />
                </div>
              </div>
              <div class="clear"></div>
            </div>
            <div style="width:333px;float:left;">
              <div style="width:331px; height:19px;float:left;"> <img src="<?php bloginfo('template_directory');?>/images/redtab_9.jpg" alt="People of the week" border="0" /> 
                <!-- <a id="safeway_advertisement" href="<?php bloginfo('template_directory');?>/ads/safewayads.html"><img src="<?php bloginfo('template_directory');?>/images/yellowtab3.jpg" alt="Ads" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/yellowtab3_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/yellowtab3.jpg'" border="0"></a>--> 
                <a id="safeway_about" href="<?php bloginfo('template_directory');?>/about/safewayads.html"><img src="<?php bloginfo('template_directory');?>/images/yellowtab_9.jpg" alt="About" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/yellowtab_9_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/yellowtab_9.jpg'" border="0"></a> </div>
              <div style="width:331px; height:288px;float:left; border: 1px solid #C8C8C8;background:#fff;">
                <div style="background: #f4f4f4;height: 280px;margin: 4px auto;width: 321px;">
                  <img src="<?php bloginfo('template_directory');?>/images/ie6_notcompatible3.jpg" alt="not compatible" />
                </div>
              </div>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
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