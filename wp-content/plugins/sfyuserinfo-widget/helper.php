<?php
	if(!defined('SFY_LDAP_URL'))
		define('SFY_LDAP_URL', 'ADLDAP01.SAFEWAY01.AD.SAFEWAY.COM');
	
	if(!defined('SFY_BASE_DN'))
		define('SFY_BASE_DN', 'OU=People,DC=safeway01,DC=ad,DC=safeway,DC=com');
	
	if(!defined('SFY_LDAP_DOMAIN'))
		define('SFY_LDAP_DOMAIN', 'SAFEWAY01.AD.SAFEWAY.COM');
	
	if(!defined('SFY_LDAP_TIMEOUT'))
		define('SFY_LDAP_TIMEOUT', 5);
		
	if(!defined('SFY_APP_USERNAME'))
		define('SFY_APP_USERNAME', 'mn02qu');
	
	if(!defined('SFY_APP_PASSWORD'))
		define('SFY_APP_PASSWORD', 'Brggg35#');

	function get_role_information($user_id,$timeout){
		$ldap_data = pull_data_from_ad($user_id, $timeout);
		
		$role_information = array();
		foreach($ldap_data->role as $roles){
			$temp = str_getcsv($roles);
			foreach($temp as $t){
				$r = explode("=", $t);
				if(in_array("CN", $r)){
					$role_information[] = $r[1];
					break;
				}
			}
		}
		
		return $role_information;
	}
	
	function pull_data_from_ad($user_id,$timeout){	
		$attributes = array("cn", "displayname", "mail", 'title', 'telephonenumber', 'memberof' );
		$filter = '(cn=' . $user_id . ')';
		
		$ad = @ldap_connect(SFY_LDAP_URL);
			  //or die("Couldn't connect to AD!");
			  
		$ldap_data = new ldap_data();
	  
		if($ad){
			$ldap_data->err_msg = $ldap_data->err_msg .  " Connect successful to LDAP <br/> ";
			
			$bd = @ldap_bind($ad, SFY_APP_USERNAME . '@' . SFY_LDAP_DOMAIN, SFY_APP_PASSWORD);
				//or die("Couldn't bind to AD!");
			
			if($bd){
				@ldap_set_option($ad, LDAP_OPT_TIMELIMIT, SFY_LDAP_TIMEOUT);
				@ldap_set_option($ad, LDAP_OPT_NETWORK_TIMEOUT, SFY_LDAP_TIMEOUT);
				@ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
				@ldap_set_option($ad, LDAP_OPT_REFERRALS,0);
			
				$ldap_data->err_msg = $ldap_data->err_msg . " Bind successful to LDAP <br/> ";
				$result = @ldap_search($ad, SFY_BASE_DN, $filter, $attributes);

				if($result){
					$entries = @ldap_get_entries($ad, $result);
					
					for ($i=0; $i<$entries["count"]; $i++)
					{
						
						$ldap_data->cn = (array_key_exists(0 , $entries[$i]['cn']) ? $entries[$i]['cn'][0] : 'N/A');
						$ldap_data->display_name = ($entries[$i]['displayname'] == null ? 'N/A' : (array_key_exists(0 , $entries[$i]['displayname']) ? $entries[$i]['displayname'][0] : 'N/A'));
						$ldap_data->email = ($entries[$i]['mail'] == null ? 'N/A' : (array_key_exists(0 , $entries[$i]['mail']) ? $entries[$i]['mail'][0] : 'N/A'));
						$ldap_data->title = ($entries[$i]['title'] == null ? 'N/A' : (array_key_exists(0 , $entries[$i]['title']) ? $entries[$i]['title'][0] : 'N/A'));
						$ldap_data->phone = ($entries[$i]['telephonenumber'] == null ? 'N/A' : (array_key_exists(0 , $entries[$i]['telephonenumber']) ? $entries[$i]['telephonenumber'][0] : 'N/A'));
						$temp = ($entries[$i]['memberof'] == null ? 'N/A' : (array_key_exists(54 , $entries[$i]['memberof']) ? $entries[$i]['memberof'][54] : 'N/A'));
						$ldap_data->department = '';//get_dept($temp); 
						$ldap_data->location = get_location($entries[$i]['dn']);
						$ldap_data->role = isset($entries[$i]['memberof']) ? $entries[$i]['memberof'] : '';
					}
				}else{
					$ldap_data->err_msg = $ldap_data->err_msg . " ERROR: No result could be found <br/> ";
				}
			}else{
				$ldap_data->err_msg = $ldap_data->err_msg . " ERROR: Bind unsuccessful <br/> ";
			}
		}else{
			$ldap_data->err_msg = $ldap_data->err_msg . " ERROR: Connect unsuccessful <br/> ";
		}
		
		$err_no = @ldap_errno($ad);
		if($err_no != 0){
			$ldap_data->err_no = $err_no;
			$ldap_data->err_msg = $ldap_data->err_msg . " LDAP ERROR: " . @ldap_error($ad) . "<br/>";
			
			$ldap_data->display_name = 'NA';
			$ldap_data->emilal = 'NA';
			$ldap_data->title = 'NA';
			$ldap_data->phone = 'NA';
			$ldap_data->department = 'NA';
		}
		@ldap_unbind($ad);
		
		return $ldap_data;
	}

	function get_location($str){
		$ou = str_getcsv($str);
		$loc = explode("=",$ou[1]);
		return $loc[1];
	}
	
	function get_dept($str){
		$tok = explode("," , $str);
		$ret = '';
		foreach($tok as $t){
			if(strpos($t,'CN=') !== false){
				$temp = explode("=", $t);
				$ret = $temp[1];
			}
		}
		
		return $ret;
	}
	
	class ldap_data{
		public $err_no = 0;
		public $err_msg = '';
		public $cn = '';
		public $display_name = '';
		public $email = '';
		public $title = '';
		public $phone = '';
		public $department = '';
		public $location = '';
		public $role = '';
	}

?>