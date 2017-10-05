<?php
	echo 'Output written to /wp-content/services/fftb/blogdata/blog.html';
	
	define('FFT_URL', 'http://foodforthought.safeway.com/featurefocus/feed/');
	
	$data = getUrlContent(FFT_URL);
	//echo $data['content'];
	$rss = getRSSFeed($data['content']);
	
	//write to file
	$headerFile = "blogdata/blog.html";
	//$headerFile = "blog.html";
	$fh = fopen($headerFile, 'w') or die("can't open file");
	$stringData = $rss['title'] . '<br/>' . $rss['desc'];
	fwrite($fh, $stringData);
	fclose($fh);
	
	/*
	* pares xml data for RSS feed
	*/
	function getRSSFeed($content){
		$doc = new DOMDocument();
		$doc->loadXML($content);
		foreach ($doc->getElementsByTagName('item') as $node) {
			$itemRSS = array ( 
				'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
				'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
				'link' => $node->getElementsByTagName('link')->item(0)->nodeValue
			);
		break;
		}
		
		return $itemRSS;
	}
	
	/*
	* Use curl to connet to server
	* ssl not required for this connect
	* Retrieve contents
	*/
	function getUrlContent($submit_url){
		$curl = curl_init();
		$params = '';
		//curl_setopt($curl, CURLOPT_SSLVERSION,2);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		curl_setopt($curl, CURLOPT_URL, $submit_url);
		curl_setopt($curl, CURLOPT_VERBOSE, 0);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		//curl_setopt($curl, CURLOPT_CAINFO,  '/wp-content/cert/PKI_Root_cacert.crt');
		//print_r(' CAINFO: '.CURLOPT_CAINFO.'  '. getcwd() . '\\PKI_Root_cacert.crt');
		
		$payload = 	curl_exec($curl);
		
		$err = curl_errno($curl); 
		
		if($err == 0){
			$content  = trim(substr($payload, strpos($payload, "\n\r"))) ; //descard the header data that precedes the xml content
		}else{
			$content = "Blog data cound not be retrieved";
		}
		
		$header  = curl_getinfo($curl);
		$errmsg  = curl_error($curl) ; 

		$data['content']	= $content;
		$data['header'] = $header;
		$data['err'] = $err;
		$data['errmsg'] = $errmsg;
		
		curl_close($curl);
		//print_r($data['header']);
		//print_r($data['err']);
		//print_r($data['errmsg']);
		return $data;//['content'];
	}
?>