<?php
/*
Template Name: Custom Feed for Resources
*/

$categories = array('Fast Find', 'Communications', 'Directories' , 'Employee Discounts', 'Employment', 'Forms', 'Health &amp; Wellness' , 'Newsletters' , 'Ordering', 'Reports', 'References', 'Training', 'Travel');

header("Content-Type: application/rss+xml; charset=UTF-8");
echo '<?xml version="1.0"?>';
?>

<rss version="2.0">
<channel>
 <title>Resource Links</title>
  <link>https://backstage.safeway.com/employeegateway</link>
  <description>The links under Resources.</description>
  <language>en-us</language>
  <pubDate><?php echo date(DATE_RSS, time()); ?></pubDate>
  <lastBuildDate><?php echo date(DATE_RSS, time()); ?></lastBuildDate>
  <managingEditor>admin@safeway.com</managingEditor>
  
  <?php

  foreach($categories as $category){
  $links = get_bookmarks( array(
			'orderby'        => 'name',
			'order'          => 'ASC',
			'category_name'  => $category
		));
	foreach ($links as $link) { ?>
		<item>
			<title><?php echo $link->link_name; ?></title>
			<link><?php echo $link->link_url; ?></link>    
		</item>
  <?php }
	} ?>
</channel>
</rss>