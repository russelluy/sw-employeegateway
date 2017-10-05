<?php
 $external_request = false;
  if(!empty($_GET) && isset($_GET['external']) ){
	require( dirname(dirname(dirname(dirname( __FILE__ )))) . '/wp-load.php'  );
	$external_request = true;
	 }
?>
<?php if (!$external_request): ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<script>
var beforeload = (new Date()).getTime();
</script>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"  />
<link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/images/myfavicon.ico" type="image/x-icon" />
<title><?php if (is_home () ) { bloginfo('name'); echo " - "; bloginfo('description'); 
} elseif (is_category() ) {single_cat_title(); echo " - "; bloginfo('name');
} elseif (is_single() || is_page() ) {single_post_title(); echo " - "; bloginfo('name');
} elseif (is_search() ) {bloginfo('name'); echo " search results: "; echo wp_specialchars($s);
} else { wp_title('',true); }?></title>
<meta name="generator" content="Bluefish 2.0.3" />
<meta name="robots" content="follow, all" />
<?php wp_enqueue_script("jquery"); ?>
<?php wp_enqueue_script("jquery-ui-core"); ?>
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!--[if lt IE 8]>
        <link href="<?php bloginfo('template_directory');?>/css/all-ie.css" rel="stylesheet" type="text/css" />
	<![endif]-->
<!--[if IE 7]>
		<link href="<?php bloginfo('template_directory');?>/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 6]>    
	<link href="<?php bloginfo('template_directory');?>/css/ie6.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/DD_belatedPNG.js"></script>
	<script type="text/javascript"> 
	   DD_belatedPNG.fix('.page-container-inner');
     DD_belatedPNG.fix('#slideshow-navigation a');
     DD_belatedPNG.fix('#slideshow-navigation .activeSlide');
	   DD_belatedPNG.fix('img');	       
	</script>	
<![endif]-->

</head>
<body>
<?php endif; ?>
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
						                      $services_page = get_option('Ag_services_pid');
						                      agivee_serviceslist($services_page,"<h2>".__('','agivee')."</h2>");
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
						                      $services_page = get_option('Ag_services_pid');
						                      agivee_serviceslist($services_page,"<h2>".__('','agivee')."</h2>");
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
					<?php if(isset($logoName)) : ?>
							<a id="logo-url" href="<?php bloginfo('url');?>"><img id="logo-url-img" src="<?php echo get_bloginfo('template_directory') . "/images/" . $logoName;?>" alt="<?php bloginfo('blogname');?>" /></a>
					<?php else: ?>
	    						<a id="logo-url" href="<?php bloginfo('url');?>"><img id="logo-url-img" src="<?php echo get_option('Ag_logo');?>" alt="<?php bloginfo('blogname');?>" /></a>								
					<?php endif; ?>
	                  </div>
	                	 
	                    <div class="top-header_lft_bot">
	                    	<div class="top-header_lft_bot_lft">
	                    		<span id="greetingContainer1" nowrap="nowrap"></span>
					<input id="userid-value" type="hidden" value="<?php echo(isset($_SERVER['REMOTE_USER']) ? strtok($_SERVER['REMOTE_USER'],"@") : 'guest');?>"/>
	                    	</div>
	                    	<div class="top-header_lft_bot_mid">
	                    		<span id="greetingContainer" nowrap="nowrap" >
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
	                    		<a href="/4mission/" id="mission_vision"><img src="<?php bloginfo('template_directory') ?>/images/VMTab.jpg" alt="Mission Vision" onMouseOver="this.src='<?php bloginfo('template_directory') ?>/images/VMTab_over.jpg'" onMouseOut="this.src='<?php bloginfo('template_directory') ?>/images/VMTab.jpg'" border="0"></a>
	                    		
	                    	</div>
	                    	
	                    </div>
                    </div>
                    <div class="top-header_rt">
                    	<div class="top-header_rt_nav" style="font-family:Arial;">
                    		<ul id="nav"> 
                    		
							   <li class="menuLink"><a href="http://retail01.safeway.com/"><img src="<?php bloginfo('template_directory') ?>/images/TopTab1.gif" onMouseOver="this.src='<?php bloginfo('template_directory') ?>/images/TopTab1_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory') ?>/images/TopTab1.gif'" alt="Retail Site" border="0"></a></li> 
							   <li class="menuLink"><a href="#"><img src="<?php bloginfo('template_directory') ?>/images/TopTab2.gif"id="pullerr" alt="Resources" onMouseOver="this.src='<?php bloginfo('template_directory') ?>/images/TopTab2_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory') ?>/images/TopTab2.gif'" border="0"></a></li> 
							   <li class="menuLink"><a href="#"><img src="<?php bloginfo('template_directory') ?>/images/TopTab3.gif" id="puller"  alt="Departments" onMouseOver="this.src='<?php bloginfo('template_directory') ?>/images/TopTab3_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory') ?>/images/TopTab3.gif'" border="0"></a></li> 
							   <li class="menuLink"><a href="#"><img src="<?php bloginfo('template_directory');?>/images/TopTab4.gif" id="pullerh"  alt="Help" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/TopTab4_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/TopTab4.gif'" border="0"></a></li>
							   <li class="menuLink"><a id="link-directory" href="/assets/directorylookup/ldaplookup.php" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/TopTab6.gif" id="pullerh"  alt="Directory" onMouseOver="this.src='<?php bloginfo('template_directory');?>/images/TopTab6_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory');?>/images/TopTab6.gif'" border="0"></a></li>
							   <li class="menuLink"><a href="https://mail.safeway.com/" target="_blank"><img src="<?php bloginfo('template_directory') ?>/images/TopTab5.gif" onMouseOver="this.src='<?php bloginfo('template_directory') ?>/images/TopTab5_over.gif'" onMouseOut="this.src='<?php bloginfo('template_directory') ?>/images/TopTab5.gif'" alt="Outlook Email" border="0"></a></li> 
							 	<!--<li class="menuLink"><a href="http://backstagegateway.safeway.com/portal/site/backstageportal/template.LOGOUT/action.process/"><img src="wp-content/themes/Agivee/images/TopTab6.gif" onMouseOver="this.src='wp-content/themes/Agivee/images/TopTab6_over.gif'" onMouseOut="this.src='wp-content/themes/Agivee/images/TopTab6.gif'" alt="Logout" border="0"></a></li>-->
							 </ul> 
                    		                    		
                    		<div class="clear"></div>
                    		
                    	</div>
	                    <!--<div class="top-header_rt_s">
	                    	<div id="search-box">
	                    		<div class="search-box_lft">
	                    		</div>
		                    		<div class="search-box_mid">
				                        <form method="get" id="search" action="<?php bloginfo('url'); ?>/" >
				                          <p><input type="text" name="s" id="s" value="<?php echo __('Search','agivee');?>" onblur="if (this.value == ''){this.value = '<?php echo __('Search','agivee');?>'; }" onfocus="if (this.value == '<?php echo __('Search','agivee');?>') {this.value = ''; }"  />&nbsp;
				                          <input type="submit" class="go" value="" />
				                          </p>                	
				                        </form>
			                    	</div> 
			                    <div class="search-box_rt">
	                    		</div>	
	                    	</div>
	                    </div>-->
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
            
