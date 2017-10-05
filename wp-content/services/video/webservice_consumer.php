<?php
	require( dirname(dirname(dirname(dirname( __FILE__ )))) . '/wp-load.php'  );
	
	global $wpdb;
	define("PICTURE_TABLE", $wpdb->prefix . "ngg_pictures");
	define("WEBSERVICEDATA_TABLE", $wpdb->prefix . "sfyvideo_webservicedata");
	define("GALLERY_TABLE", $wpdb->prefix . "ngg_gallery");
	define("OUTPUT_DIR", "videos-pics");
	
	consume_video_data();

	function consume_video_data(){
		$setting_info = new SettingsInformation();
		//get output directory from wp_ngg_galley table of NextGen plugin
		$setting_info->output_dir = dirname(dirname(dirname(dirname( __FILE__ )))) . '/' . get_output_directory(OUTPUT_DIR);
		
		$allData = get_video_webservice_data();
		if($allData != null){
			clear_data($setting_info);
			save_data($allData, $setting_info);
			
			echo '<pre>';
				print_r($allData);
			echo '</pre>';
		}
	}
	
	function save_data($data, $setting_info){
		global $wpdb;
		
		//make a temporary dir to save original images
		rrmdir($setting_info->output_dir . '/tmp','');
		mkdir($setting_info->output_dir . '/tmp');
		
		$gallery_id = $wpdb->get_var($wpdb->prepare("SELECT gid FROM " . GALLERY_TABLE . " WHERE name = %s", OUTPUT_DIR));
		
		$table_status = $wpdb->get_row("SHOW TABLE STATUS LIKE '" . PICTURE_TABLE . "'");
		$i = $table_status->Auto_increment;
		
		foreach($data as $d):
			//$url = get_image_request_url($d->imageURI);
			$url = $d->imageURI;
			$image_name = $i . '.jpg';
			
			$ret = save_video_image($url, $image_name, $setting_info);
			
			if($ret == 0){
				$insert_webservicedata = "INSERT INTO " . WEBSERVICEDATA_TABLE .
				" (VIDEO_ID, TITLE, DESCRIPTION, IMAGE_URI, VIDEO_URI) " .
				"VALUES ('". $d->id . "','" . $wpdb->escape($d->title) . "','" . $wpdb->escape($d->description) . "','" . $d->imageURI . "','" . $d->videoURI . "')";
				$wpdb->query( $insert_webservicedata );
			
				$wpdb->insert(PICTURE_TABLE, array('image_slug' => $i, 'post_id' => 0, 'galleryid' => $gallery_id , 
				'filename' => $image_name, 'exclude' => 0, 'sortorder' => 0, 'alttext' => $d->videoURI, 'description' => $d->title ));
				
				$i = $i + 1;
			}
		endforeach;
		
	}
	
	function save_video_image($url, $output_image, $setting_info){
		$curl = curl_init();
		$payload = null;
		$err = 0;
		
		if($curl === 'FALSE'){echo 'Could not initialze curl'; }
		else {
			/*$fields = array(
				'principalID'=>urlencode(''),
				'password'=>urlencode('')
				);*/

			//foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			//$fields_string = rtrim($fields_string,'&');
			
			$save_to = $setting_info->output_dir . '/tmp/' . $output_image;

			//curl_setopt($curl, CURLOPT_SSLVERSION,2);
			//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_BINARYTRANSFER, 1);
			//curl_setopt($curl, CURLOPT_POST, count($fields));
			//curl_setopt($curl, CURLOPT_POSTFIELDS,$fields_string);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_VERBOSE, 0);

			$payload = 	curl_exec($curl);

			$header  = curl_getinfo($curl);
			$err     = curl_errno($curl); 
			$errmsg  = curl_error($curl) ; 

			//$content  = trim(substr($payload, strpos($payload, "\n\r")));
			//$content  = trim(substr($content, strpos($content, "\n\r")));
			//$content  = trim(substr($content, strpos($content, "\n\r")));
			$content = $payload;
			
			$fp = fopen($save_to, "wb");
			fwrite($fp, $content); 
			fclose($fp);	
		}
		curl_close($curl);
		create_thumbnail_image($save_to, $setting_info->output_dir . '/' . $output_image, 136);  
		
		return (($payload == null || $err != 0) ? -1 : 0);
	}
	
	function get_image_request_url($url){
		$loginURL = 'https://video.safeway.com/viewerportal/safeway/login.vp?redirectUrl=';
		
		$redirect = trim(substr($url, strrpos($url, "/")));
		$redirect = ltrim($redirect, '/');
		$redirect = str_replace("?","%3F",$redirect);
		$redirect = str_replace("=","%3D",$redirect);
		
		$imageURL = $loginURL . $redirect;

		return $imageURL;
	}
	
	function create_thumbnail_image($src, $dest, $desired_width){
		/* read the source image */
		$source_image = imagecreatefromjpeg($src);
		$width = imagesx($source_image);
		$height = imagesy($source_image);
		
		/* find the "desired height" of this thumbnail, relative to the desired width  */
		$desired_height = floor($height*($desired_width/$width));
		
		/*override desired width and height to a perdefined one*/
		//$desired_width = 136;
		//$desired_height = 101;
		
		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width,$desired_height);
		
		/* copy source image at a resized size */
		imagecopyresampled($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
		
		/* create the physical thumbnail image to its destination */
		imagejpeg($virtual_image,$dest,100);
	}

	function get_video_webservice_data(){
		//make two pass the first pass will have rawlinks set to false
		//the second pass will have rawlink set to true
		$rawlink = false;
		$allData = array();
		for($i = 1; $i <= 2; $i++){
			try{
				$webservice_url = "http://video.safeway.com/serviceportal/ProgramService_v5?wsdl";
				$webservice_ns = 'http://qumu.com/service/v5_0/program';
				
				$client = @new SoapClient($webservice_url, array("exceptions" => 1));
				
				$serviceContext = $client->ServiceContext;

				//set attribute values for serrvicecontext : REQUIRED
				$serviceContext->domain = "safeway";
				$serviceContext->displayMode = 0;
				$serviceContext->rawLinks = $rawlink;
				
				//no attribute of resultsetparam is set
				$resultsetParams = $client->ResultSetParams;
				$findFeatured = $client->findFeatured;
				$findFeatured->rsp = $resultsetParams ;

				//prepare a header with servicecontext
				$input_header = new SoapHeader($webservice_ns, 'srvctx', $serviceContext);
				
				//pass servicecontext as header when calling findfeatured webservice function
				$program_result_set = $client->__soapCall("findFeatured", array($findFeatured), null, $input_header);
				
				foreach($program_result_set->return->results as $program):	
					$videoData = new VideoData();
					
					$id = $program->identifier;
				
					$videoData->id = $id;
					$videoData->title = $program->name;
					$videoData->description = $program->shortDescription;
					
					//find details of the video from id of the video.
					//this is needed to ge thumbnail image link and video link
					$findDetailsById = $client->findDetailsById;
					$findDetailsById->id = $id;
					$programdetails_result_set =  $client->__soapCall("findDetailsById", array($findDetailsById), null, $input_header);

					foreach($programdetails_result_set->return->content as $link):
						if ($link->role == "I"){
							//save thumnail image link in the second pass
							if($i == 2){
								$allData[$id]->imageURI = $link->uri;
							}
						} 
						else if ($link->role == "P"){
							$videoData->videoURI = $link->uri;
						}
					endforeach;
					
					//save data to data array in the first pass only
					if($i == 1){
						$allData[$id] = $videoData;
					}
				endforeach;
			}catch(SoapFault $E){
				echo $E->faultstring;
				return null;
			}
			
			$rawlink = true;
		}
		
		return $allData;
	}
	
	function get_output_directory($folder_name){
		global $wpdb;
		$folder_path = $wpdb->get_var($wpdb->prepare("SELECT path FROM " . GALLERY_TABLE . " WHERE name = %s", $folder_name));
		
		return $folder_path;
	}
	
	function clear_data($setting_info){
		global $wpdb;
		
		$clear_directory = false;
		$current = date("F j, Y, g:i a"); 
		if(!get_option('sfy_clear_videodirectory_ts')){
			add_option('sfy_clear_videodirectory_ts',$current);
			$clear_directory = true;
		}else{
			$previous = get_option('sfy_clear_videodirectory_ts');
			$d1 = new DateTime($previous);
			$d2 = new DateTime($current);
			$diff = $d1->diff($d2); 			
			$day = $diff->format('%d'); 
			$hour = $diff->format('%h'); 
			$min = $diff->format('%i'); 
			if($hour > 20){
				update_option('sfy_clear_videodirectory_ts',$current);
				$clear_directory = true;
			}
		}
				
		$wpdb->query( 'delete from ' . PICTURE_TABLE );
		$wpdb->query( 'delete from ' . WEBSERVICEDATA_TABLE );
		if($clear_directory){
			rrmdir($setting_info->output_dir, $setting_info->output_dir);
		}
	}
	
	function rrmdir($dir, $exclude_dir) {
		if (is_dir($dir)) {
		 $objects = scandir($dir);
		 foreach ($objects as $object) {
		   if ($object != "." && $object != "..") {
			 if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object, $exclude_dir); else unlink($dir."/".$object);
		   }
		 }
		 reset($objects);
		 if($dir != $exclude_dir)
			rmdir($dir);
		}
	} 
	
	class VideoData{
		public $id = '';
		public $title = '';
		public $description = '';
		public $imageURI = '';
		public $videoURI = '';
	}

	class SettingsInformation{
		public  $output_dir = '';
	}
?>