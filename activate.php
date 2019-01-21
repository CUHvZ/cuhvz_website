<?php
require('includes/config.php');

//collect values from the url
$user_id = trim($_GET['x']);
$active_token = trim($_GET['y']);
//error_log("something", 0);
//if id is number and the active token is not empty carry on
if(is_numeric($user_id) && !empty($active_token)){

	//update users record set the active column to Yes where the memberID and active value match the ones provided in the array
	$stmt = $db->prepare("UPDATE users SET activated = 'Yes' WHERE id = :user_id AND activated = :active_token");
	$stmt->execute(array(
		':user_id' => $user_id,
		':active_token' => $active_token
	));

	//if the row was updated redirect the user
	if($stmt->rowCount() == 1){

		//redirect to login page
		header('Location: login.php?action=active');
		exit;

	} else {
		echo "Your account could not be activated. Please contact the mod team.";
	}

}
?>
