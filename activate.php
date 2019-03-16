<?php
require('includes/config.php');

//collect values from the url
$user_id = trim($_GET['x']);
$active_token = trim($_GET['y']);

//if id is number and the active token is not empty carry on
if(is_numeric($user_id) && !empty($active_token)){
	$result = activateAccount($user_id);
	if($result){

		//redirect to login page
		header('Location: login.php?action=active');
		exit;

	} else {
		echo "Your account could not be activated. Please contact the mod team.";
	}

}

function activateAccount($userID){
	$database = new Database();
	$result = $database->update("user_stats", "activated = true", "id = $userID");
	$database->delete("tokens", "user_id = $userID AND token_type = 'ACTIVATION'");
	return $result;
}
?>
