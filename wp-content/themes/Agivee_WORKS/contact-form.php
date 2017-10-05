<?php
/*
Template Name: Contact Form
*/
?>

<?php 
//If the form is submitted
if(isset($_POST['submitted'])) {

	//Check to see if the honeypot captcha field was filled in
	if(trim($_POST['checking']) !== '') {
		$captchaError = true;
	} else {
	
		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$nameError = 'Please enter your name.';
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$emailError = 'Please enter your email address.';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}

		//Check to make sure that the name field is not empty
		if(trim($_POST['subject']) === '') {
			$subjectError = 'Please enter your subject.';
			$hasError = true;
		} else {
			$subject = trim($_POST['subject']);
		}			
		//Check to make sure comments were entered	
		if(trim($_POST['comments']) === '') {
			$commentError = 'Please enter your comments.';
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}
			
		//If there is no error, send the email
		if(!isset($hasError)) {
      
      $info_email = get_option('Ag_info_email');  
			$emailTo = $info_email;
			$subject = $subject;
			$sendCopy = trim($_POST['sendCopy']);
			$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
			$headers = 'From: My Site <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			mail($emailTo, $subject, $body, $headers);

			if($sendCopy == true) {
				$subject = $subject;
				$headers = 'From: Your Site <noreply@yourdomain.com>';
				mail($emailTo, $subject, $body, $headers);
			}

			$emailSent = true;

		}
	}
} ?>

        
        <?php get_header();?>
          <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/contact-form.js"></script>            
            <!-- BEGIN PAGE TITLE -->
             <div id="page-title">              
              <div class="title"><!-- your title page -->
              	 <h1><?php the_title();?></h1>
              </div>
              <?php $data = get_post_meta($post->ID, '_short_desc', true ); ?>
              <?php if ($data) : ?>
              <div class="desc"><!-- description about your page -->
              <?php echo $data;?>
              </div>
              <?php endif;?>
	  		     </div>            
            <!-- END OF PAGE TITLE -->
            
            <!-- BEGIN CONTENT -->
            <div id="content-inner">
               	<div id="content-left">
                     <div class="maincontent">
<?php if(isset($emailSent) && $emailSent == true) { ?>

                    	<div class="thanks">
                    		<h3>Thanks, <?=$name;?></h3>
                    		<p><?php echo __('Your email was successfully sent. I will be in touch soon.','agivee');?></p>
                    	</div>
                    
                    <?php } else { ?>
                    
                    	<?php if (have_posts()) : ?>
                    	
                    	<?php while (have_posts()) : the_post(); ?>
                    		<?php the_content(); ?>
                    		
                    		<?php if(isset($hasError) || isset($captchaError)) { ?>
                    			<p class="error"><?php echo __('There was an error submitting the form.','agivee');?><p>
                    		<?php } ?>
                    	
                    		<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
                    	
                    			<ol class="forms">
				<li><label for="contactName"><?php echo __('Name','agivee');?></label>
					<input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="requiredField" />
					<?php if($nameError != '') { ?>
						<span class="error"><?=$nameError;?></span> 
					<?php } ?>
				</li>
				
			 <li><label for="email"><?php echo __('Email','agivee');?></label>
					<input type="text" name="email" id="email-contact" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="requiredField email input" />
					<?php if($emailError != '') { ?>
						<span class="error"><?=$emailError;?></span>
					<?php } ?>
				</li>
  			 <li><label for="subject"><?php echo __('Subject','agivee');?></label>
					<input type="text" name="subject" id="subject" value="<?php if(isset($_POST['subject']))  echo $_POST['subject'];?>" class="requiredField subject input" />
					<?php if($subjectError != '') { ?>
						<span class="error"><?=$subjectError;?></span>
					<?php } ?>
				</li>
				
				<li class="textarea"><label for="commentsText"><?php echo __('Message','agivee');?></label>
					<textarea name="comments" id="commentsText" rows="20" cols="30" class="requiredField input"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
					<?php if($commentError != '') { ?>
						<span class="error"><?=$commentError;?></span> 
					<?php } ?>
				</li>				
				<li class="screenReader"><label for="checking" class="screenReader"><?php echo __('If you want to submit this form, do not enter anything in this field','agivee');?></label><input type="text" name="checking" id="checking" class="screenReader" value="<?php if(isset($_POST['checking']))  echo $_POST['checking'];?>" /></li>
				<li class="buttons"><input type="hidden" name="submitted" id="submitted" value="true" /><button type="submit" class="input-submit"></button></li>
			</ol>
                    		</form>
                    	
                    		<?php endwhile; ?>
                    	<?php endif; ?>
                    <?php } ?>

                     
                  	 </div>
                 </div>                 
                 <div id="side-box">
                   	 <div class="maincontent">
                     <h2><?php bloginfo('blogname');?> <?php echo __('on the map','agivee');?></h2>                            
                     	 <div class="google-map2"><p>
                        <?php 
                        $_mapimage = get_option('Ag_mapimage');
                        if ($_mapimage) { ?>
                        <img src="<?php echo stripslashes($_mapimage);?>" alt=""  /></p></div>
                        <? } else { ?>
                        <img src="<?php bloginfo('template_directory');?>/images/small-map.jpg" alt=""  /></p></div>
                        <?php  }?>
                        <?php 
                        $contactaddress = get_option('Ag_info_address');
                        $contactphone = get_option('Ag_info_phone');
                        $contactemail = get_option('Ag_info_email');
                        ?>
                        
                        <p><?php if ($contactaddress) echo stripslashes($contactaddress); else echo "18th Place, M1234 Heavenway Road<br />HW 5468, USA";?><br />
        				<?php echo __('Phone ','agivee');?>: <?php if ($contactphone) echo $contactphone; else echo "+62 1234 5678";?>,  <?php echo __('Email', 'agivee');?> : <?php if ($contactemail) echo $contactemail; else echo "info@agivee.com";?>
                        </p>
                     	 
                     </div>
                                                                             
                 </div>                         
            </div> 
            <!-- END OF CONTENT -->
            
            <?php get_footer();?>