<?php 
	//echo dirname(dirname(dirname(dirname( __FILE__ ))));
	require( dirname(dirname(dirname(dirname( __FILE__ )))) . '/wp-load.php'  );
	
	echo 'The output file is writen to /var/www/assets/header/header/html';
	
	//include("http://backstagedv.safeway.com/employeegateway/wp-content/themes/Agivee/header.php?external=1&logo=safeway-logo250.jpg");
	$ch = curl_init();
	$url = get_template_directory_uri() . "/header.php?external=1";
	$search_string = get_template_directory_uri() . '/images';
	$home_uri = dirname(get_option('home'));
	//echo $home_uri;
	$replace_string = $home_uri . '/assets/images';
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_USERPWD, 'mn02qu:Brggg35#');
	//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$data = curl_exec($ch);
	curl_close($ch);
	$data = str_replace($search_string, $replace_string, $data);
	//echo 'here ' . $search_string;
	echo $data;
	//write to file
	$headerFile = "/var/www/assets/header/header.html";
	//$headerFile = "header.txt";
	$fh = fopen($headerFile, 'w') or die("can't open file");
	$stringData = $data;
	fwrite($fh, $stringData);
	fclose($fh);
	
	/*include(dirname(dirname(dirname(dirname(dirname( __FILE__ ))))) . '/employeegateway/wp-content/themes/Agivee/header.php');*/
?>