                <img src="<?php $_footer_logo = get_option('Ag_footer_logo'); if ($_footer_logo) : echo $_footer_logo;?> <?php else : ?> <?php bloginfo('template_directory');?>/images/footer-logo.gif<?php endif;?>" alt="" />
                 <?php
                $contactaddress = get_option('Ag_info_address');
                $contactphone = get_option('Ag_info_phone');
                $contactemail = get_option('Ag_info_email');
                ?>
                
                <p><?php if ($contactaddress) echo stripslashes($contactaddress); else echo "";?><br />
				<br />
                <?php $footer_text = get_option('Ag_footer_text');?>
                <?php if ($footer_text) echo stripslashes($footer_text);else echo "";?> <br />
                </p>
