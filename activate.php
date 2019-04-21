<!DOCTYPE html>
<html lang="en">
<?php
require('includes/config.php');
// require($_SERVER['DOCUMENT_ROOT'].'/classes/phpmailer/Mail.php');
$title = 'CU HvZ | ';
?>
<head>
	<?php require('layout/header.php'); ?>
</head>
<body>
<?php
include 'layout/navbar.php';

$errors = [];

//collect values from the url
$userID = trim($_GET['x']);
$activeToken = trim($_GET['y']);
$database = new Database();
validateToken($database, $userID, $activeToken, $errors);
if(empty($errors)){
	$result = activateAccount($database, $userID, $errors);
	if($result){
		//redirect to login page
		header('Location: profile.php?action=activated');
		exit;
	}
}


function validateToken($database, $userID, $token, &$errors){
	$query = "select * from tokens where token='$token'";
	$result = $database->executeQueryFetch($query);
	// token does not exist in database
	if(!$result){
		array_push($errors, "Activation token is not valid.");
	}
	// an error occured executing database query
	else	if(isset($result["error"])){
		array_push($errors, "Error occured validating token.");
	}	else {
		$tokenID = $result["id"];
		// test if token has expired
		$expired = $database->isTokenExpired($tokenID);
		if($expired){
			array_push($errors, "Token has expired.");
		}else{
			$userID = $result["user_id"];
		}
	}
}

function activateAccount($database, $userID, &$errors){
	$result = $database->update("user_stats", "activated = true", "id = $userID");
	if(isset($result["error"])){
		array_push($errors, "Your account could not be activated. Please contact the mod team.");
		return false;
	}
	$database->delete("tokens", "user_id = $userID AND token_type = 'ACTIVATION'");
	return true;
}
?>

<div class="lightslide">

<div class="container">

	<div class="row">
	    	<?php
				if(isset($errors)){
					foreach($errors as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}
				?>
		</div>
	</div>
</div>

</div>

<?php
//include header template
require('layout/footer.php');
?>
