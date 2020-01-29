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
// Import code entry functions
require('weeklong/codeFunctions.php');
// ---------------------------
// Handle submit
// ---------------------------
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
?>

<section class="darkslide" id="logkill">
	<div class="container">
		<div class="row">
			<div class="twelve columns">
				Players can input codes here that they have found. Codes can give you points or feed your starve timer.
				<form action='#' method='post' autocomplete="off">
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
