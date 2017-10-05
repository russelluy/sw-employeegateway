<?php
/*
Template Name: Template Archive Blank
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/featuredsites.js"></script>
<link href="<?php bloginfo('template_directory');?>/css/jquery-ui.css" rel="stylesheet" type="text/css" />

</head>
<body>
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>

				<div class="entry">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				</div>
		<?php endwhile; ?>
		
	<?php else : ?>
		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>

	<?php endif; ?>
</body>











	








