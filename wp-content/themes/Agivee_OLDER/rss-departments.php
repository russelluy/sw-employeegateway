<?php
/*
Template Name: Custom Feed for Department
*/

$categories = array('Dept-Accounting', 'Dept-Communications', 'Dept-Customer Care' , 'Dept-Divisions', 'Dept-Facilities', 'Dept-Finance', 'Dept-Fuel &amp; Energy' , "Dept-Gov't Relations" , 'Dept-Human Resources', 'Dept-Info. Technology', 'Dept-Investor Relations', 'Dept-Marketing', 'Dept-Privacy/InfoSec', 'Dept-Real Estate', 'Dept-Records &amp; Content Mgmt', 'Dept-Risk Management', 'Dept-Supply Operations');
header("Content-Type: application/rss+xml; charset=UTF-8");
echo '<?xml version="1.0"?>';
?>

<rss version="2.0">
<channel>
 <title>Department Links</title>
  <link>https://backstage.safeway.com/employeegateway</link>
  <description>The links under Department.</description>
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