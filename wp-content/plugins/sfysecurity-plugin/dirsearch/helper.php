<?php
	if(!defined('SFY_LDAP_URL'))
		define('SFY_LDAP_URL', 'ADLDAP01.SAFEWAY01.AD.SAFEWAY.COM');
	
	if(!defined('SFY_BASE_DN_ALL'))
		define('SFY_BASE_DN_ALL', 'DC=safeway01,DC=ad,DC=safeway,DC=com');
	
	if(!defined('SFY_LDAP_DOMAIN'))
		define('SFY_LDAP_DOMAIN', 'SAFEWAY01.AD.SAFEWAY.COM');
		
	if(!defined('SFY_APP_USERNAME'))
		define('SFY_APP_USERNAME', 'mn02qu');
	
	if(!defined('SFY_APP_PASSWORD'))
		define('SFY_APP_PASSWORD', 'Brggg35#');
		
	if(!defined('TYPE_GROUP'))
		define('TYPE_GROUP', 'group');
		
	if(!defined('TYPE_PERSON'))
		define('TYPE_PERSON', 'person');

	
	function pull_data_from_ad($user_id,$timeout, $criteria='all'){	
		$filter[0] = '(cn=' . $user_id . ')';
		
		$ldap_msg = new ldap_msg();
		$ad = @ldap_connect(SFY_LDAP_URL);
			  //or die("Couldn't connect to AD!");
		
		if($ad){
			$ads[0] = $ad;
			$ldap_msg->err_msg = $ldap_msg->err_msg .  " Connect successful to LDAP <br/> ";
			
			$bd = @ldap_bind($ad, SFY_APP_USERNAME . '@' . SFY_LDAP_DOMAIN, SFY_APP_PASSWORD);
				//or die("Couldn't bind to AD!");
			
			if($bd){
				@ldap_set_option($ad, LDAP_OPT_TIMELIMIT, $timeout);
				@ldap_set_option($ad, LDAP_OPT_NETWORK_TIMEOUT, $timeout);
				@ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
				@ldap_set_option($ad, LDAP_OPT_REFERRALS,0);
			
				$ldap_msg->err_msg = $ldap_msg->err_msg . " Bind successful to LDAP <br/> ";
				$dn[0] = SFY_BASE_DN_ALL;
				//$results = @ldap_search($ads, $dn, $filter, $attributes);
				$results = @ldap_search($ads, $dn, $filter);

				if($results){
					$data = Array();
					$j = 0;
					foreach($results as $result){
						if($result){
							
							$entries = @ldap_get_entries($ad, $result);
							
							foreach($entries as $entry)
							{
							$ldap_data = new ldap_data();
							$cn = '';
								//print_r($entry);
								if(isset($entry['objectclass'])){
									if(in_array(TYPE_GROUP,$entry['objectclass'])){
										$cn = isset($entry['cn'][0]) ? $entry['cn'][0] : '';
										$ldap_data->cn = $cn;
										$ldap_data->display_name = isset($entry['displayname'][0]) ? $entry['displayname'][0] : $cn;
										$ldap_data->type = TYPE_GROUP;
									}
									if(in_array(TYPE_PERSON,$entry['objectclass'])){
										$cn = isset($entry['cn'][0]) ? $entry['cn'][0] : '';
										$ldap_data->cn = $cn;
										$ldap_data->display_name = isset($entry['displayname'][0]) ? $entry['displayname'][0] : $cn;
										$ldap_data->type = TYPE_PERSON;
									}
								}
								if($cn != ''){
									if($criteria == 'all' || $criteria == $ldap_data->type){
										$data[$j] = $ldap_data;
										$j++;
									}
								}

							}
						}else{
							$ldap_msg->err_msg = $ldap_msg->err_msg . " ERROR: No result could be found <br/> ";
						}						
					}
				}
			}else{
				$ldap_msg->err_msg = $ldap_msg->err_msg . " ERROR: Bind unsuccessful <br/> ";
			}
		}else{
			$ldap_msg->err_msg = $ldap_msg->err_msg . " ERROR: Connect unsuccessful <br/> ";
		}
		
		$err_no = @ldap_errno($ad);
		if($err_no != 0){
			$ldap_msg->err_no = $err_no;
			$ldap_msg->err_msg = $ldap_data->err_msg . " LDAP ERROR: " . @ldap_error($ad) . "<br/>";
		}
		@ldap_unbind($ad);
		
		return $data;
	}

	class ldap_data{
		public $cn = '';
		public $display_name = '';
		public $type = '';
	}

	class ldap_msg{
		public $err_no = 0;
		public $err_msg = '';
	}
?>