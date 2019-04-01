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
$status = $user->get_game_stats()["status"];
if($status != "human"){ header('Location: login.php'); }
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
			if($code["expiration"]){
				$expiration = new DateTime($code["expiration"]);
				$currentTime = new DateTime(date('Y-m-d H:i:s'));
				if($currentTime > $expiration){
					$error = "Code has expired.";
				}
			}
			// continue if no errors
		}else{
			$error = "Code has no more uses left.";
		}
	}
	if(isset($error)){
		echo "<p class='bg-danger'>$error</p>";
	}
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
