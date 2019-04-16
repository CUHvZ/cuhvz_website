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
	// error_log("Attempting to enter code with input hex $codeHex and weeklong $weeklongName", 0);
	$database = new Database();
	$query = "select * from ".$weeklongName."_codes where hex='$codeHex'";
	$code = $database->executeQueryFetch($query);
	// error_log("codeID: ".$code["id"].", name: ".$code["name"].", hex: ".$code["hex"].", effect: ".$code["effect"].", side effect: ".$code["side_effect"], 0);
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
					// check if user has used code
					$error = checkIsUsed($code, $data, $database);
					if(empty($error)){
						$error = applyEffect($code, $data, $database);
						if(empty($error)){
							$error = updateQuantities($code, $database);
						}
					}
				}else{
					error_log("error getting user details from $weeklongName in code entry", 0);
				}
			}
		}else{
			$error = "Code has no more uses left.";
		}
	}else{
		error_log("code does not exist!", 0);
		$error = "'$codeHex' code does not exist!";
	}
	if(isset($error)){
		error_log("error entering code. $error. hex: $codeHex", 0);
		echo "<p class='bg-danger'>$error</p>";
	}
}

function applyEffect($code, $user, $database){
	$weeklongName = $_SESSION["weeklong"];
	$effect = $code["effect"];
	$userID = $user['user_id'];
	$codeID = $code["id"];
	error_log("user: $userID, effect: $effect, code ID: $codeID", 0);
	if(empty($userID))
		return "user id is null";
	if($effect == "supply"){
		if($user["status"] == "human"){
			// add 24 hours to human starve timer
			error_log("applying supply drop to user $userID", 0);
			$starveDate = (new StarveDate($user["starve_date"]))->addHours(24);
			$query = "update $weeklongName set starve_date='$starveDate',points=points+10 where user_id=$userID";
			$data = $database->executeQuery($query);
			if(isset($data["error"]))
				return $data["error"];
			$starveTimer = (new StarveDate($starveDate))->getStarveTimer();
			echo "<p class='bg-success' style='margin: 0;'> &#10003; You collected a supply drop! You're new starve time is $starveTimer</p>";
		}else{
			return "You must be human to collect a supply drop";
		}
	}elseif($effect == "points"){
		$points = intval($code["side_effect"]);
		error_log("applying $points to user $userID", 0);
		$query = "update $weeklongName set points=points+$points where user_id=$userID";
		$data = $database->executeQuery($query);
		if(isset($data["error"]))
			return $data["error"];
		echo "<p class='bg-success' style='margin: 0;'> &#10003; You received $points points!</p>";
	}else{
		return "effect '$effect' not recognised";
	}
	return null;
}

function checkIsUsed($code, $user, $database){
	$weeklongName = $_SESSION["weeklong"];
	$codeID = $code["id"];
	$userID = $_SESSION['id'];
	$query = "select * from ".$weeklongName."_used_codes where code_id=$codeID AND user_id=$userID";
	$data = $database->executeQueryFetch($query);
	if(!empty($data))
		return "You have already used this code";
	return null;
}

function checkExpiration($code){
	if($code["expiration"]){
		$expiration = new DateTime(date($code["expiration"]));
		$currentTime = new DateTime(date('Y-m-d H:i:s'));
		if($currentTime > $expiration){
			error_log("code has expired", 0);
			return "Code has expired.";
		}
	}
	return null;
}

function updateQuantities($code, $database){
	$weeklongName = $_SESSION["weeklong"];
	$codeID = $code["id"];
	$userID = $_SESSION['id'];
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
				Players can input codes here that they have found. Codes can give you points or feed your starve timer.
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
