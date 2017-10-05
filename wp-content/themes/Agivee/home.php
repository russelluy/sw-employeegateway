<?php get_header();?>

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
        <div class="contentbox_1">
          <div class="contentbox_1top"> <img src="<?php bloginfo('template_directory');?>/images/redtab_1.jpg" alt="Featured Sites" border="0" /> </div>
          <div class="contentbox_1box">
            <div class="contentbox_1boxin">
              <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Featured Sites')) {
						                      $services_page = get_option('Ag_services_pid');
						                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
						                    } ?>
            </div>
          </div>
          <div class="clear"></div>
        </div>

		<div class="contentbox_2">
          <div class="contentbox_2top"> 
          	<div class="sprite_2 redtab_4"></div>
          	<a class='sprite_2 redtab_4b' href="/employeegateway/index.php/archive/" id="link_archive" ></a> 
          	<a class='sprite_2 greentab4' href="<?php echo get_bookmark_field( 'link_url', 245 );?>" id="request_plus_featuredpromotions" ></a>
          </div>
          <div class="contentbox_2box">
            <div class="contentbox_2boxin">
              <div id="content3">
                <div class="maincontent">
	                  <?php 
																		$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
																		$temp = $wp_query;
																		$wp_query= null;
																		$wp_query = new WP_Query();
																		$wp_query-> query('category_name=ArchiveOrgChangesHome');
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
		
        <div class="contentbox_1b">
          <div class="contentbox_1top"> <a id="link_navi_gator"><img src="<?php bloginfo('template_directory');?>/images/redtab_10b.jpg" alt="Navigator" border="0" /></a> </div>
          <div class="contentbox_1box">
            <div class="aboutme_contentbox_2boxin" style="background:#dedede;height: 278px;margin:5px;#width:278px;#height: 288px;"> <!--<a id="quickguide" class="more_archive" target="_blank" href="?page_id=1204">Learn How</a> -->
              <div id="widget_navigator">
                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Navigator')) {
						                      $services_page = get_option('Ag_services_pid');
						                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
						                    } ?>
              </div>
              
              <div id="widget_archive" style = "display:none">
                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Archive')) {
						                      $services_page = get_option('Ag_services_pid');
						                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
						                    } ?>
              </div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="clear"></div>
        </div>

		
        </div>
		
		
      <div id="content2">
        <div style="float:left;">
          <div class="wrap_featuredfocus">
            <div class="tab_featuredfocus">
            	<div class="sprite_1 redtab_3"></div>
            	<a href="/notices/" target="_blank" class='sprite_1 yellowtab2'></a> 
            	<a href="https://forms.safeway.com/frevvo/web/tn/safeway.com/user/IT03GH/app/_FoMCkfEFEeCFV_a78DJncg/formtype/_PRSZ0MNdEeCOyMcEYS_MNA/popupform?locale=" id="request_plus_featuredfocus" class='sprite_1 greentab_3'></a> 
            </div>
            <div class="ffocus_slidebox_wrap"> 
              <div class="ffocus_slidebox">
                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Feature Focus')) {
						                      $services_page = get_option('Ag_services_pid');
						                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
						                    } ?>
              </div>
            </div>
            <div class="clear"></div>
          </div>
          
          <div class="content2_mid" style="float:left;margin-top:17px;width:677px;">
            <div class="content2_bottom" style="float:left;margin-top:3px;width:677px;">
              <div class="contentbox_7a">
                <div class="contentbox_7atop"> 
                	<a href= "#" id = "link_featured" class='sprite_3 redtab2'></a> 
                	<a href="#" id = "link_industry" class='sprite_3 yellowtab4'></a> 
                	<a href="#" id = "link_pharmacy" class='sprite_3 yellowtab'></a> 
                	<a href="https://forms.safeway.com/frevvo/web/tn/safeway.com/user/IT03GH/app/_FoMCkfEFEeCFV_a78DJncg/formtype/__o1t4N09EeCux72t6wo8NA/popupform?locale=" id="request_plus_news" class='sprite_3 greentab2'></a>
                 </div>
                <div class="contentbox_7abox" style="width:672px; float:left; border: 1px solid #C8C8C8;background:#fff;">
                  <div class="contentbox_7aboxin" style="background:#f4f4f4;height: 173px;margin: 4px auto;width: 664px;">
                    <div style="color: #666666; font-family: verdana; font-size: 11px;">
						<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Industry News')) {
						                      $services_page = get_option('Ag_services_pid');
						                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
						                    } ?>
											
                    </div>
                  </div>
                </div>
              </div>
              <div class="clear"></div>
            </div>

            <div class="contentbox_7" style="margin-top: 25px;">
	              <div class="contentbox_7top"> 
	              		<div class='sprite_4 redtab_7'></div> 
	              		<a href="http://videoexchange.safeway.com/"  target="_blank" class='sprite_4 greytab_7a'></a> 
	              		<a href="http://videoexchange.safeway.com/viewerportal/safeway/calendar.vp"  target="_blank" class='sprite_4 greytab_7b'></a> 
	              </div>
              <div class="contentbox_7box" style="width:672px; height:109px;float:left; border: 1px solid #C8C8C8;background:#fff;">
                <div class="contentbox_7boxin" style="background:#fff;height: 105px;margin: 4px auto;width: 664px;">
                  <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Video Carousel')) {
												                      $services_page = get_option('Ag_services_pid');
												                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
												                    } ?>
                </div>
              </div>
              <div class="clear"></div>
            </div>
          </div>
          
          
          
          <div class="content2_bottom" style="float:left;margin-top:27px;width:677px;">
            <div style="width:333px;float:left;margin-right: 7px;">
              <div style="width:335px; height:19px;float:left;"> 
              		<div class='sprite_5 redtab_learnlet1'></div>  
              		<a id="requestplus_ques_week" href="index.php/archive-technical-learnlet" class='sprite_5 redtab_learnlet2'></a> 
					<a id="requestplus_ques_week" href="https://forms.safeway.com:443/frevvo/web/tn/safeway.com/user/IT03GH/app/_f-vHgawEEeCVwMxXBtxh1g/formtype/_6RbB8LgLEeKL2qpiodAyMA/popupform?locale=" class='sprite_5 redtab_learnlet3'></a> 
              </div>
              <div style="width:670px; height:288px;#height:283px;float:left; border: 1px solid #C8C8C8;background:#fff;">
                <div style="background: #f4f4f4;height: 280px;width: 321px;margin: 4px 7px;float: left;">
                  <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Tech Learnlet')) {
												                    } ?>
                </div>
				<div style="background: #f4f4f4;height: 280px;margin: 4px 7px;width: 321px;float: left;">
                  <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Prof Learnlet')) {
												                    } ?>
                </div>
              </div>
              <div class="clear"></div>
            </div>
          </div>
          
          
          <div class="content2_bottom" style="float:left;margin-top:19px;width:677px;">
            <div style="width:333px;float:left;margin-right: 7px;">
              <div style="width:335px; height:19px;float:left;"> 
              		<div class='sprite_6 redtab_5b'></div> 
              		<a id="link_qtw_comment" href="<?php echo get_bookmark_field( 'link_url', 249 );?>"  target="_blank" class='sprite_6 yellowtab_5b'></a> 
              		<a id="requestplus_ques_week" href="https://forms.safeway.com/frevvo/web/tn/safeway.com/user/IT03GH/app/_FoMCkfEFEeCFV_a78DJncg/formtype/_BEycgOyqEeChOsQskn4d3w/popupform?locale="  target="_blank" class='sprite_6 greentab_5b'></a> 
              </div>
              <div style="width:331px; height:288px;#height:298px;float:left; border: 1px solid #C8C8C8;background:#fff;">
                <div style="background: #f4f4f4;height: 280px;width: 321px;margin: 4px auto;">
                  <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Question Week')) {
												                    } ?>
                </div>
              </div>
              <div class="clear"></div>
            </div>
            <div style="width:333px;float:left;">
              <div style="width:331px; height:19px;float:left;"> 
              		<div class='sprite_7 redtab_9'></div> 
                	<a id="safeway_about" href="<?php bloginfo('template_directory');?>/about/safewayads.html" class='sprite_7 yellowtab_9'></a> 
               </div>
              <div style="width:331px; height:288px;#height:298px;float:left; border: 1px solid #C8C8C8;background:#fff;">
                <div style="background: #f4f4f4;height: 280px;margin: 4px auto;width: 321px;">
                  <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('People Week')) {
												                    } ?>
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
