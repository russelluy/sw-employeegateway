                <?php
                  $_feedburner_id = get_option('Ag_feedburner_id');
                  $_twitter_id = get_option('Ag_twitter_id');
                  $_flickr_user = get_option('Ag_flickr_user');
                  $_facebook_id = get_option('Ag_facebook_id');
                ?>                
                <h3><?php echo $titlesocial;?></h3>
                <ul id="social">
        					<li id="fb-icon"><a href="http://facebook.com/<?php echo $_facebook_id;?>"><span></span><?php echo __('Let\'s Get Personal','agivee');?></a></li>
        					<li id="twit-icon"><a href="http://twitter.com/<?php echo $_twitter_id;?>"><span></span><?php echo __('Tweet with Us','agivee');?></a></li>
        					<li id="flic-icon"><a href="http://flickr.com/<?php echo $_flickr_user;?>"><span></span><?php echo __('Check us Out','agivee');?></a></li>
        					<li id="rss-icon"><a href="http://feedburner.google.com/<?php echo $_feedburner_id;?>"><span></span><?php echo __('Subscribe to Our Feed','agivee');?></a></li>
        				</ul>
