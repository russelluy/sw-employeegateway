<?php
	require ('helper.php');
	
	if(isset($_GET['userid'])){
		$user_id = $_GET['userid'];
		$user_data = pull_data_from_ad($user_id,0);
		$return["user_name"] = $user_data->display_name;
		
		// Right here is where the json object gets wrapped in a function that was submitted under the name "callback"
		echo $_GET['callback']."(".json_encode($return).")";
	}
?>