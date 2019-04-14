<!DOCTYPE html>
<html lang="en">
<?php
require('includes/config.php');
$title = 'CU HvZ | Log Kill';
?>
<head>
	<?php require('layout/header.php'); ?>
</head>
<body>
	<?php
		include 'layout/navbar.php';
	?>

<?php
// if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<?php

if (isset($_POST['hex'])){
	$codeHex = $_POST['hex'];
	$weeklongName = $_SESSION["weeklong"];
	$database = new Database();
	$query = "select * from ".$weeklongName."_codes where hex='$codeHex'";
	$code = $database->executeQueryFetch($query);
	if(isset($code["id"])){
		if($code["num_uses"] + 0 > 0){
			// check the expiration is not null
			$error = checkExpiration($code);
			// continue if no errors
			if(empty($error)){
				$userID = $_SESSION['id'];
				$codeID = $code["id"];
				$effect = $code["effect"];

				// get player info
				$query = "select * from $weeklongName where user_id=$userID";
				$data = $database->executeQueryFetch($query);
				if(!isset($data["error"])){
					$error = applyEffect($code, $data, $database);
				}else{
					$error = $data["error"];
				}

				// apply effect


				// use code and update quantities
				$error = updateQuantities($code, $database);
			}
		}else{
			$error = "Code has no more uses left.";
		}
	}
	if(isset($error)){
		echo "<p class='bg-danger'>$error</p>";
	}
}

function applyEffect($code, $user, $database){
	$weeklongName = $_SESSION["weeklong"];
	$effect = $code["effect"];
	$userID = $_SESSION['id'];
	if($effect == "supply"){
		if($user["status"] == "human"){
			// check if user has used code or not

			// add 24 hours to human starve timer
		}else{
			return "You must be human to collect a supply drop";
		}
	}elseif($effect == "points"){
		$points = intval($code["side_effect"]);
		$query = "update $weeklongName set points=points+$points where user_id=$userID";
	}else{
		return "effect '$effect' not recognised"
	}
}

function checkExpiration($code){
	if($code["expiration"]){
		$expiration = new DateTime($code["expiration"]);
		$currentTime = new DateTime(date('Y-m-d H:i:s'));
		if($currentTime > $expiration){
			return "Code has expired.";
		}
	}
	return null;
}

function updateQuantities($code, $database){
	$query = "update ".$weeklongName."_codes set num_uses=num_uses-1 where id=$codeID";
	$data = $database->executeQuery($query);
	if(!isset($data["error"])){
		$query = "insert into ".$weeklongName."_used_codes (user_id, code_id) values ($userID, $codeID)";
		$data = $database->executeQuery($query);
		if(isset($data["error"]))
			return $data["error"];
	}else{
		return $data["error"];
	}
	return null;
}
?>

<section class="darkslide" id="logkill">
	<div class="container">
		<div class="row">
			<div class="twelve columns">
				Humans can input codes here that they have found. Codes can give you points or feed your starve timer.
				<form action='#' method='post' id='feedzombie'>
					<div class='subheader white'>Input code:</div>
					<input type='text' name='hex' required>
					<input class="button-primary" type="submit" name="submit" value="Submit" id="submit">
				</form>
			</div>
		</div>
	</div>
</section>

</body>

</html>
