<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=6" />
<script>
var beforeload = (new Date()).getTime();
</script>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/employeegateway.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/tab.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/nivoslider/nivoslider/jquerynivoslider.js"></script>


<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"  />
<link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/images/myfavicon.ico" type="image/x-icon" />
<title><?php if (is_home () ) { bloginfo('name'); echo " - "; bloginfo('description'); 
} elseif (is_category() ) {single_cat_title(); echo " - "; bloginfo('name');
} elseif (is_single() || is_page() ) {single_post_title(); echo " - "; bloginfo('name');
} elseif (is_search() ) {bloginfo('name'); echo " search results: "; echo wp_specialchars($s);
} else { wp_title('',true); }?></title>

<?php /*wp_head();*/ ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/jquery-ui.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/js/nivoslider/nivoslider/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('template_directory');?>/js/nivoslider/nivoslider/themes/default/default.css" type="text/css" media="screen" />

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


</head>
<body>
				<div style="display: none;position:absolute;z-index: 1000;width:100%;" id="pullermessager">
						<div class="wrapgroup1" >
							<div class="black">
								<div class="black_ra">
									<div class="black_ra_lft">
										R E S O U R C E S
									</div>
									<a href="#" id="pusherbr">
										<div class="black_ra_rt_a">
											<div class="black_ra_rt_aa">
												C L O S E
											</div>
											<div class="black_ra_rt_b">
												X
											</div>
										</div>
									</a>
								</div>
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Dropdown Resources')) {
						                     
						                    } ?>								
							</div>
							<div class="pulltail">
								<div class="pulltab">
									<a href="#"><img src="<?php bloginfo('template_directory');?>/images/pulltab.png" id="pusherr"  alt="Close" /></a>
								</div>
							</div>
							<div class="clear"></div>
						</div>
				</div>

				<div style="display: none;position:absolute;z-index: 1000;width:100%;" id="pullermessage">
						<div class="wrapgroup1" >
							<div class="black">
								<div class="black_ra">
									<div class="black_ra_lft">
										D E P A R T M E N T S
									</div>
									<a href="#" id="pusherb">
										<div class="black_ra_rt_a">
											<div class="black_ra_rt_aa">
												C L O S E
											</div>
											<div class="black_ra_rt_b">
												X
											</div>
										</div>
									</a>
								</div>
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Dropdown Departments')) {
						                      
						                     
						                    } ?>
							</div>
							<div class="pulltail">
								<div class="pulltab">
									<a href="#"><img src="<?php bloginfo('template_directory');?>/images/pulltab.png" id="pusher"  alt="Close" /></a>
								</div>
							</div>
							<div class="clear"></div>
						</div>
						</div>
						
						<div style="display: none;position:absolute;z-index: 1000;width:100%;" id="pullermessageh">
						<div class="wrapgroup1" >
							<div class="black">
								<div class="black_ra">
									<div class="black_ra_lft">
										H E L P
									</div>
									<a href="#" id="pusherbh">
										<div class="black_ra_rt_a" style="text-decoration:none;">
											<div class="black_ra_rt_aa">
												C L O S E
											</div>
											<div class="black_ra_rt_b">
												X
											</div>
										</div>
									</a>
								</div>
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Dropdown Help')) {	
						                    } ?>								
							</div>
							<div class="pulltail">
								<div class="pulltab">
									<a href="#"><img src="<?php bloginfo('template_directory');?>/images/pulltab.png" id="pusherh"  alt="Close" /></a>
								</div>
							</div>
							<div class="clear"></div>
						</div>
				
				</div>
						
				</div>
				
	<div class="new_pagewrap">
		<div class="new_pagewrap_wrap">
			<!-- BEGIN HEADER -->
            <div id="header">
            	<div id="top-header">
            		<div class="top-header_lft">
	                	<div class="logo">
	    							 
	    								<a id="logo-url" href="<?php bloginfo('url');?>"><img id="logo-url-img" src="<?php echo get_option('Ag_logo');?>" alt="<?php bloginfo('blogname');?>" /></a>								
	                  </div>
	                	 
	                    <div class="top-header_lft_bot">
	                    	<div class="top-header_lft_bot_lft">
	                    		<span id="greetingContainer1" nowrap="nowrap"></span>
					<input id="userid-value" type="hidden" value="<?php echo(isset($_SERVER['REMOTE_USER']) ? strtok($_SERVER['REMOTE_USER'],"@") : 'guest');?>"/>
	                    	</div>
	                    	<div class="top-header_lft_bot_mid">
	                    		<span id="greetingContainer" nowrap="nowrap">
	                    			<script language="JavaScript">
									  <!--
									    var now = new Date();
									    var days = new Array(
									      'Sunday','Monday','Tuesday',
									      'Wednesday','Thursday','Friday','Saturday');
									    var months = new Array(
									      'January','February','March','April','May',
									      'June','July','August','September','October',
									      'November','December');
									    var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
									    function fourdigits(number)	{
									      return (number < 1000) ? number + 1900 : number;}
									    today =  months[now.getMonth()] + " " +
									       date + ", " +
									       (fourdigits(now.getYear()));
									     document.write(today);
									  //-->
									</script>

	                    		
	                    		</span>
	                    	</div>
	                    	<div class="top-header_lft_bot_rt">
	                    		<a href="<?php bloginfo('template_directory');?>/notice/visionmission_ie6.html" target="_blank" id="mission_vision"><img src="<?php bloginfo('template_directory') ?>/images/VMTab.jpg" alt="Mission Vision" onMouseOver="this.src='<?php bloginfo('template_directory') ?>/images/VMTab_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory') ?>/images/VMTab.jpg'" border="0"></a>
	                    		
	                    	</div>
							<div id="update_explorer">
								<b>You are using an old version of Internet Explorer</b> which does not work well with our new features. Please update your browser to a more current version. Thank you.
							
							</div>
	                    	
	                    </div>
                    </div>
                    <div class="top-header_rt">
                    	<div class="top-header_rt_nav">
                    		<ul id="nav"> 
                    		
							   <li class="menuLink"><a href="http://retail01.safeway.com/"><img src="<?php bloginfo('template_directory') ?>/images/TopTab1.gif" onMouseOver="this.src='<?php bloginfo('template_directory') ?>/images/TopTab1_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory') ?>/images/TopTab1.gif'" alt="Retail Site" border="0"></a></li> 
							   <li class="menuLink"><a href="#"><img src="<?php bloginfo('template_directory') ?>/images/TopTab2.gif"id="pullerr" alt="Resources" onMouseOver="this.src='<?php bloginfo('template_directory') ?>/images/TopTab2_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory') ?>/images/TopTab2.gif'" border="0"></a></li> 
							   <li class="menuLink"><a href="#"><img src="<?php bloginfo('template_directory') ?>/images/TopTab3.gif" id="puller"  alt="Departments" onMouseOver="this.src='<?php bloginfo('template_directory') ?>/images/TopTab3_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory') ?>/images/TopTab3.gif'" border="0"></a></li> 
							   <li class="menuLink"><a href="#"><img src="<?php bloginfo('template_directory');?>/images/TopTab4.gif" id="pullerh"  alt="Help" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/TopTab4_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/TopTab4.gif'" border="0"></a></li>
							   <li class="menuLink"><a id="link-directory" href="/assets/directorylookup/ldaplookup.php" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/TopTab6.gif" id="pullerh"  alt="Directory" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/TopTab6_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/TopTab6.gif'" border="0"></a></li>
							   <li class="menuLink"><a href="https://mail.safeway.com/" target="_blank"><img src="<?php bloginfo('template_directory') ?>/images/TopTab5.gif" onMouseOver="this.src='<?php bloginfo('template_directory') ?>/images/TopTab5_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory') ?>/images/TopTab5.gif'" alt="Outlook Email" border="0"></a></li> 
							 </ul> 
                    		                    		
                    		<div class="clear"></div>
                    		
                    	</div>
	                </div>
                </div>
	        </div>
	       </div>
	      </div>
		 <?php if (!$external_request): ?> 
	    <div class="new_pagewrap_wrap_stretch">     
	    </div>
	    
	    <div class="new_menuwrap">
			<div class="new_menuwrap_wrap">
       
            <!-- BEGIN CONTENT -->
            <?php if (is_home()) echo '<div id="content">';
            endif;
            
