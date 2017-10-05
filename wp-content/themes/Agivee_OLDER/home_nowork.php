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
			                   <div id="slider1">
											<div class="panelContainer">
												<div class="panel" title=".">
													<div class="wrapper">
																	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Box 6')) {
										                      $services_page = get_option('Ag_services_pid');
										                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
										     } ?>
													</div>
												</div>
												<div class="panel" title=".">
													<div class="wrapper">
														<p>CANADA eget eros vulputate tincidunt. Etiam sapien urna, auctor a, viverra sit amet, convallis a, enim. Nullam ut nulla. Nam laoreet massa aliquet tortor. </p>
													</div>
												</div>		
											</div><!-- .panelContainer -->
										</div><!-- #slider1 -->
	                    	
	                    	
	                    </div>
	                </div>
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
			                  	<div class="contentbox_1top">
			                  		<img src="<?php bloginfo('template_directory');?>/images/redtab_1.jpg" alt="Other Sites" border="0" />
		                 	  	</div>
			                  	<div class="contentbox_1box">
			                  	
										<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Box 7')) {
						                      $services_page = get_option('Ag_services_pid');
						                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
						                    } ?>
		                 	  		
		                 	  	</div>
		                 	  	<div class="clear"></div>
		                 	  </div>
		                 	  <div class="contentbox_2">
			                  	<div class="contentbox_2top">
			                  		<img src="<?php bloginfo('template_directory');?>/images/redtab_2.jpg" alt="Other Sites" border="0" />
			                  		<a href="#"><img src="<?php bloginfo('template_directory');?>/images/greytab_2.jpg" alt="Other Sites" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greytab_2_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greytab_2.jpg'" border="0"></a>
			                  		<a href="#"><img src="<?php bloginfo('template_directory');?>/images/greentab_2.jpg" alt="Other Sites" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greentab_2_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greentab_2.jpg'" border="0"></a>
		                 	  	</div>
			                  	<div class="contentbox_2box">
			                  		<div class="contentbox_2boxin">
			                  			<div id="content3">
						                  <div class="maincontent">
						                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Box 3')) {
						                      $services_page = get_option('Ag_services_pid');
						                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
						                    } ?>
						                  </div>
						                 </div>	
			                  		
		                 	  		</div>
		                 	  	</div>
		                 	  	<div class="clear"></div>
		                 	  </div>
		                 </div>
		                 <div id="content2">
		                 	<div style="float:left;">
		                    	<div style="width:333px;float:left;margin-right: 10px;">
				                  	<div style="width:331px; height:19px;float:left;">
				                  		<img src="<?php bloginfo('template_directory');?>/images/redtab_3.jpg" alt="Other Sites" border="0" />
				                  		<a href="#"><img src="<?php bloginfo('template_directory');?>/images/greentab_3.jpg" alt="Other Sites" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greentab_3_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greentab_3.jpg'" border="0"></a>
			                 	  	</div>
				                  	<div style="width:331px; height:315px;float:left; border: 1px solid #C8C8C8;background:#fff;">
				                  		<div style="background: #999;height: 307px;margin: 4px auto;width: 321px;">
				                  			
							                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Box 4')) {
						                      $services_page = get_option('Ag_services_pid');
						                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
						                    } ?>
						                      
			                 	  		</div>
			                 	  	</div>
			                 	  	<div class="clear"></div>
		                 	  </div>
		                 	  <div style="width:331px;float:right;">
				                  	<div style="width:331px; height:19px;float:left;">
				                  		<img src="<?php bloginfo('template_directory');?>/images/redtab_4.jpg" alt="Other Sites" border="0" />
				                  		<a href="#"><img src="<?php bloginfo('template_directory');?>/images/greentab_4.jpg" alt="Other Sites" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greentab_4_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greentab_4.jpg'" border="0"></a>
			                 	  	</div>
				                  	<div style="width:331px; height:315px;float:left; border: 1px solid #C8C8C8;background:#fff;">
				                  		<div style="height: 307px;margin: 4px auto;width: 321px;background:#999;">
				                  			<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Box 5')) {
						                      $services_page = get_option('Ag_services_pid');
						                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
						                    } ?>
						                    
						                    
						                    <script type="text/javascript" src="compressed.js"></script>
											<script type="text/javascript">
											        $('slideshow_focus').style.display='none';
											        $('wrapper_focus').style.display='block';
											        $('slideshow_promo').style.display='none';
											        $('wrapper_promo').style.display='block';
											        var slideshow_focus=new TINY.slideshow("slideshow_focus");
											        var slideshow_promo=new TINY.slideshow("slideshow_promo");
											        window.onload=function(){
											                slideshow_focus.auto=true;
											                slideshow_focus.speed=5;
											                slideshow_focus.link="linkhover_focus";
											                slideshow_focus.info="information_focus";
											                slideshow_focus.info = false;
											                slideshow_focus.thumbs="slider_focus";
											                slideshow_focus.left="slideleft_focus";
											                slideshow_focus.right="slideright_focus";
											                slideshow_focus.scrollSpeed=4;
											                slideshow_focus.spacing=1;
											                slideshow_focus.active="#fff";
											                slideshow_focus.init("slideshow_focus","image_focus","imgprev_focus","imgnext_focus","imglink_focus");
											                slideshow_promo.auto=true;
											                slideshow_promo.speed=5;
											                slideshow_promo.link="linkhover_promo";
											                slideshow_promo.info="information_promo";
											                slideshow_promo.info = false;
											                slideshow_promo.thumbs="slider_promo";
											                slideshow_promo.left="slideleft_promo";
											                slideshow_promo.right="slideright_promo";
											                slideshow_promo.scrollSpeed=4;
											                slideshow_promo.spacing=1;
											                slideshow_promo.active="#fff";
											                slideshow_promo.init("slideshow_promo","image_promo","imgprev_promo","imgnext_promo","imglink_promo");
											        }
											</script>

							                   						                    
			                 	  		</div>
			                 	  	</div>
			                 	  	<div class="clear"></div>
		                 	  </div>
		                 	  <div class="content2_mid" style="float:left;margin-top:17px;width:677px;">
												<div class="content2_mid_lft">
																<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Box 8')) {
																	  $portfolio_cid = get_option('Ag_portfolio_cid');
																	  $portfolio_cat = get_cat_ID($portfolio_cid);                      
																	  agivee_featuredproject($portfolio_cat,3,"<h2>".__('Featured Message','agivee')."</h2>");
																	} ?>
												 </div>    	
												  <div class="content2_mid_rt" style="float:left;width:417px; ">
														
						
																			<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Box 2')) {
																			  $portfolio_cid = get_option('Ag_portfolio_cid');
																			  $portfolio_cat = get_cat_ID($portfolio_cid);                      
																			  agivee_featuredproject($portfolio_cat,3,"<h2>".__('Featured Message','agivee')."</h2>");
																			} ?>
																
														
														
												 </div>
												 <div class="content2_bottom" style="float:left;margin-top:19px;width:677px;">												 
														<div class="contentbox_7">
														
										                  	<div class="contentbox_7top">
										                  		<img src="<?php bloginfo('template_directory');?>/images/redtab_7.jpg" alt="Other Sites" border="0" />
											                  		<a href="#"><img src="<?php bloginfo('template_directory');?>/images/greytab_7a.jpg" alt="Other Sites" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greytab_7a_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greytab_7a.jpg'" border="0"></a>
											                  		<a href="#"><img src="<?php bloginfo('template_directory');?>/images/greytab_7b.jpg" alt="Other Sites" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/greytab_7b_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/greytab_7b.jpg'" border="0"></a>
									                 	  	</div>
										                  	<div class="contentbox_7box" style="width:672px; height:109px;float:left; border: 1px solid #C8C8C8;background:#fff;">
										                  		<div class="contentbox_7boxin" style="background:#fff;height: 105px;margin: 4px auto;width: 664px;">
										                  			
																	  <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Box 1')) {
												                      $services_page = get_option('Ag_services_pid');
												                      agivee_serviceslist($services_page,"<h2>".__('Our Services','agivee')."</h2>");
												                    } ?>
					
									                 	  		</div>
									                 	  	</div>
								                 	  		<div class="clear"></div>	
								                 	  			
														</div>
												</div>
												<div class="content2_bottom" style="float:left;margin-top:19px;width:677px;">												 
														<div style="width:333px;float:left;margin-right: 10px;">
											                  	<div style="width:331px; height:19px;float:left;">
											                  		<img src="<?php bloginfo('template_directory');?>/images/redtab_8.jpg" alt="Other Sites" border="0" />
											                  		
										                 	  	</div>
											                  	<div style="width:331px; height:288px;float:left; border: 1px solid #C8C8C8;background:#fff;">
											                  		<div style="background: #f4f4f4;height: 280px;margin: 4px auto;width: 321px;">
											                  			<div style="color: #333;font-size: 11px;font-style: italic;font-weight: bold;padding: 12px;">
											                  			Which Department has the best customer service?</div>
											                  				<div style="float:left;margin-bottom: 20px;">
																                      <div style="float: left; font-size: 10px;line-height: 21px;margin-left: 15px;width: 130px;">
														                  					<input type="radio" name="group1" value="Milk" style="margin-right:6px;">  Accounting<br />
																							<input type="radio" name="group1" value="Butter" style="margin-right:6px;">Communications<br />
																							<input type="radio" name="group1" value="Cheese" style="margin-right:6px;">Customer Care<br />
																							<input type="radio" name="group1" value="Milk" style="margin-right:6px;">Divisions<br />
																							<input type="radio" name="group1" value="Butter" style="margin-right:6px;">Facilities<br />
																							<input type="radio" name="group1" value="Cheese" style="margin-right:6px;">Finance<br />
																							<input type="radio" name="group1" value="Milk" style="margin-right:6px;">Fuel & Energy<br />
																							<input type="radio" name="group1" value="Butter" style="margin-right:6px;">Gov't Relations<br />
																							<input type="radio" name="group1" value="Cheese" style="margin-right:6px;">Human Resources
														                  				</div>
																	                   <div style="float: left;line-height: 21px;width: 153px;">
																	                   		<input type="radio" name="group1" value="Milk" style="margin-right:6px;">Privacy/InfoSec<br />
																							<input type="radio" name="group1" value="Butter" style="margin-right:6px;">Info. Technology<br />
																							<input type="radio" name="group1" value="Cheese" style="margin-right:6px;">Investor Relations<br />
																							<input type="radio" name="group1" value="Milk" style="margin-right:6px;">Marketing<br />
																							<input type="radio" name="group1" value="Butter" style="margin-right:6px;">Real Estate<br />
																							<input type="radio" name="group1" value="Cheese" style="margin-right:6px;">Records & Content Mgmt<br />
																							<input type="radio" name="group1" value="Milk" style="margin-right:6px;">Risk Management<br />
																							<input type="radio" name="group1" value="Butter" style="margin-right:6px;">Supply Operations
														                  				</div> 
											                  				</div>
											                  				<div style="margin: 0 auto;text-align: center;">
											                  					<input type="image" border="0" onmouseout="this.src='wp-content/themes/Agivee/images/share_button.jpg'" onmouseover="this.src='wp-content/themes/Agivee/images/share_button_over.jpg'" alt="Submit" value="Submit" src="wp-content/themes/Agivee/images/share_button.jpg">
											                  				</div>  
										                 	  		</div>
										                 	  	</div>
										                 	  	<div class="clear"></div>
									                 	  </div>
									                 	  
									                 	  <div style="width:333px;float:right;">
											                  	<div style="width:331px; height:19px;float:left;">
											                  		<img src="<?php bloginfo('template_directory');?>/images/redtab_9.jpg" alt="Other Sites" border="0" />
											                  		
										                 	  	</div>
											                  	<div style="width:331px; height:288px;float:left; border: 1px solid #C8C8C8;background:#fff;">
											                  		<div style="background: #f4f4f4;height: 280px;margin: 4px auto;width: 321px;">
											                  				<div style="float:left;width:152px ">
											                  						<div style="width:152px;margin-left: 20px;margin-top: 10px; ">
											                  								<div style="cursor: pointer;height: 17px;margin: 87px 0 0 44px;position: absolute;width: 61px;#margin:87px 0 0 -65px;">
											                  									<a href="#"><img src="<?php bloginfo('template_directory');?>/images/followme.png" alt="Follow me" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/followme_over.png'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/followme.png'" border="0"></a>
											                  								</div>
											                  								<img src="wp-content/themes/Agivee/images/sampspic_1.jpg" style="border: 1px solid #C8C8C8; float: left; padding: 3px;" />
											                  						</div>
											                  						<div style="float:left;width:152px;text-align:center;margin-top:10px;">
													                  								<form method=post name=f1 action='dd-check.php'>
														                  									<select name='cat' onchange="reload(this.form)" style="width:145px;margin-bottom:5px;border:1px solid #C8C8C8;height: 23px;padding: 2px;">
														                  										<option value=''>What's my First Name?</option>
														                  										<option value='Jeremy'>Jeremy</option>
														                  										<option value='Peter'>Peter</option>
														                  										<option value='Dan'>Dan</option>
														                  										<option value='Russell'>Russell</option>
														                  									</select>
														                  									<select name='subcat' style="width:145px;margin-bottom:5px;border:1px solid #C8C8C8;height: 23px;padding: 2px;">
															                  									<option value=''>What's my Last Name?</option>
															                  									<option value='Apple'>Person</option>
															                  									<option value='Banana'>Pryor</option>
															                  									<option value='Baseball'>Uy</option>
															                  									<option value='Blkes'>Davis</option>															                  								
													                  										</select>
													                  										<br />
													                  										
													                  								</form>
													                  								<br />
											                  						<a href="#" style="color:#287AE3">I dont know his/her name</a>
											                  						</div>											                  						
											                  				</div>
														                   <div style="float:right;width:152px ">
														                   			<div style="width:152px;margin-left: 20px;margin-top: 10px; ">
														                   				<div style="cursor: pointer;height: 17px;margin: 87px 0 0 44px;position: absolute;width: 61px;#margin:87px 0 0 -65px;">
											                  									<a href="#"><img src="<?php bloginfo('template_directory');?>/images/followme.png" alt="Follow me" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/followme_over.png'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/followme.png'" border="0"></a>
											                  								</div>
											                  								<img src="wp-content/themes/Agivee/images/sampspic_2.jpg" style="border: 1px solid #C8C8C8; float: left; padding: 3px;" />
											                  						</div>
											                  						<div style="float:left; text-align:center;width:152px;margin-top: 10px; ">
											                  								<form method=post name=f1 action='dd-check.php'>
														                  									<select name='cat' onchange="reload(this.form)" style="width:145px;margin-bottom:5px;border:1px solid #C8C8C8;height: 23px;padding: 2px;">
														                  										<option value=''>What's my First Name?</option>
														                  										<option value='Patricia'>Patricia</option>
														                  										<option value='Maybeline'>Maybelline</option>
														                  										<option value='Stephanie'>Stephanie</option>
														                  										<option value='Kristin'>Kristin</option>
														                  									</select>
														                  									<select name='subcat' style="width:145px;margin-bottom:5px;border:1px solid #C8C8C8;height: 23px;padding: 2px;">
															                  									<option value=''>What's my Last Name?</option>
															                  									<option value='Discala'>Discala</option>
															                  									<option value='Chan'>Chan</option>
															                  									<option value='Jacubus'>Jacubus</option>
															                  									<option value='Jachner'>Jachner</option>															                  								
													                  										</select>
													                  										<br />
													                  										
													                  								</form>
													                  								<br />
													                  								<a href="#" style="color:#287AE3">I dont know his/her name</a>
											                  						</div>
														                   		
											                  				</div>     
										                 	  		</div>
										                 	  	</div>
										                 	  	<div class="clear"></div>
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
        
        