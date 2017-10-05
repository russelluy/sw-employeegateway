<?php
 $external_request1 = false;
 if(!empty($_GET) && isset($_GET['external']) ){
	require( dirname(dirname(dirname(dirname( __FILE__ )))) . '/wp-load.php'  );
	$external_request1 = true;
 }
?>
<?php if (!$external_request1): ?>
                 <!-- END OF BOTTOM BOX -->                 
            <?php if (is_home()) echo '</div>';?> 
            <!-- END OF CONTENT -->
            
            <!-- BEGIN FOOTER -->
            <div id="footer">
            	
              <div class="footer2">
<?php endif; ?> 
              			<ul id="nav"> 
                    		<li><a class="sprite-foot_logo1" href="http://www.safeway.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo2" href="http://www.vons.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo3" href="http://www.dominicks.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo4" href="http://www.randalls.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo5" href="http://www.tomthumb.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<!--<li><a class="sprite-foot_logo6" href="http://www.genuardis.com/IFL/Grocery/Home" target="_blank"></a></li>-->
                    		<li><a class="sprite-foot_logo7" href="http://www.pavilions.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo8" href="http://www.carrsqc.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		</ul>
<?php if (!$external_request1): ?>     
            	            <?php 
					if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Loadtime')) {
						                      
					} ?>   
<!-- Piwik --> 
<script type="text/javascript">
var pkBaseURL = "https://piwik.safeway.com/piwik/"; //(("https:" == document.location.protocol) ? "https://piwik.safeway.com/piwik/" : "http://piwik.safeway.com/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 12);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}

function widget_track_piwik(index,name,value,scope){
	//alert(index + " " + name + " " + value + " " + scope );
	piwikTracker.setCustomVariable(
		index, // Index, the number from 1 to 5 where this Custom Variable name is stored for the current page view
		name, // Name, the name of the variable, 
		value, // Value, 
		scope // Scope of the Custom Variable, "page" means the Custom Variable applies to the current page view
	);

	//alert(name);
	piwikTracker.trackPageView();
}

jQuery(function($){
	$(document).ready(function(){
		$("#pullerr").click(function(event) {
			widget_track_piwik(2, 'resourceslink', 'accessed', 'page');
		});
		$("#puller").click(function(event) {
			widget_track_piwik(3, 'departmentslink', 'accessed', 'page');
		});

	});
});    

</script><noscript><p><img src="https://piwik.safeway.com/piwik/piwik.php?idsite=12" style="border:0" alt="" /></p></noscript>

<!-- dummy link for recoding widget usage -->
<a id="powdummylink" href="#" onClick="javascript:widget_track_piwik(1, 'peopleoftheweek', 'accessed', 'page');"></a>    
     

<!-- End Piwik Tracking Code -->
 
              </div>
            </div>
            <!-- END OF FOOTER -->
            
            </div>
        </div>
    </div>
  <?php 
  $ga_code = get_option('Ag_ga_code');
  if ($ga_code) echo stripslashes($ga_code);
  ?>
 <?php wp_footer();?>   
</body>
</html>
<?php endif; ?>
