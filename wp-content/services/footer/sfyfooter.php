<?php 
	require( dirname(dirname(dirname(dirname( __FILE__ )))) . '/wp-load.php'  );
	
	echo 'The output file is writen to /var/www/assets/footer/footer.html';
	
	/*include("http://backstagedv.safeway.com/employeegateway/wp-content/themes/Agivee/footer.php?external=1");*/
	$ch = curl_init();
	$url = get_template_directory_uri() . "/footer.php?external=1";
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
	//echo 'here ' . $search_string;
	echo $data;
	//write to file
	$footerFile = "/var/www/assets/footer/footer.html";
	//$headerFile = "footer.txt";
	$fh = fopen($footerFile, 'w') or die("can't open file");
	$stringData = $data;
	fwrite($fh, $stringData);
	fclose($fh);
	
	/*include(dirname(dirname(dirname(dirname(dirname( __FILE__ ))))) . '/employeegateway/wp-content/themes/Agivee/footer.php');*/
?>