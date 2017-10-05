<?php
class Utility{
	public function is_user_in_role($access_role){
		$access_allowed = true;
		
		global $current_user; 
		get_currentuserinfo();
	
		if($current_user->user_login == ''){
			$user_name = 'guest';
		}else{
			$user_name = $current_user->user_login;
		}
		
		$allowed_roles = explode(",", $access_role);
		//print_r($current_user->caps);
		//echo 'allowed ' . $user_name;
		//print_r($allowed_roles);
		
		if(!empty($allowed_roles)){
			if(!empty($allowed_roles[0])){
				//echo 'key exists ' . in_array ('user_name',$allowed_roles);
				if(!in_array($user_name,$allowed_roles)){
					$access_allowed = false;
				}
			}
		}
		
		return $access_allowed;
	}
	
	public function is_pageaccess_allowed($page_id){
		$access_allowed = true;
		
		$access_role = get_post_meta($page_id, SFYSECURITY_PAGE_READ_ACCESS,true);
		
		$access_allowed = $this->is_user_in_role($access_role);
		
		return $access_allowed;
	}
}
?>