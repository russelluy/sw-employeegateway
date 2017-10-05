                <img src="<?php bloginfo('template_directory');?>/images/twitter-footer.jpg" alt="" class="twitter" />
                <h3><?php echo ($titletwitter) ? $titletwitter: __('Twitter Update..!!','agivee');?></h3>
                <div id="twitter_update_list">
                <?php 
                $twitter_username = ($twitterid) ? $twitterid : get_option('Ag_twitter_id');
                $twitter_num = ($twitternum) ? $twitternum : 1;
                ?>
                <script src="http://twitter.com/javascripts/blogger.js" type="text/javascript"></script>
                <script src="http://twitter.com/statuses/user_timeline/<?php echo $twitter_username;?>.json?callback=twitterCallback2&amp;count=<?php echo $twitter_num;?>" type="text/javascript"></script>      
                </div>          
