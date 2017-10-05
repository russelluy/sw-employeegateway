
                 <!-- END OF BOTTOM BOX -->                 
            <?php if (is_home()) echo '</div>';?> 
            <!-- END OF CONTENT -->
            <!-- BEGIN FOOTER -->
            <div id="footer">

              <div class="footer2">
              			<ul id="nav"> 
                    		<li><a class="sprite-foot_logo1" href="http://www.safeway.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo2" href="http://www.vons.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo3" href="http://www.dominicks.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo4" href="http://www.randalls.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo5" href="http://www.tomthumb.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo6" href="http://www.genuardis.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo7" href="http://www.pavilions.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		<li><a class="sprite-foot_logo8" href="http://www.carrsqc.com/IFL/Grocery/Home" target="_blank"></a></li>
                    		</ul>       
            	            <?php
						/*if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Loadtime')) {
												  
						}*/
					?>    
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
 <?php /*wp_footer();*/?>  
 
</body>
</html>
