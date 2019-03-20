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

//if logged in redirect to user page
if( $user->is_logged_in() ){ header('Location: profile.php'); }

$database = new Database();
$userID = 0;
$tokenID = 0;
if(isset($_GET['key'])){
	$activationToken = $_GET['key'];
	$query = "select * from tokens where token='$activationToken'";
	$result = $database->executeQueryFetch($query);
	// token does not exist in database
	if(!$result){
		$stop = "Invalid token provided, please use the link provided in the reset email.";
	}
	// an error occured executing database query
	else	if(isset($result["error"])){
		$stop = "Error occured validating token.";
	}	else {
		$tokenID = $result["id"];
		// test if token has expired
		$expired = $database->isTokenExpired($tokenID);
		if($expired){
			$stop = "Reset token has expired.";
		}else{
			$userID = $result["user_id"];
		}
	}
}

//if form has been submitted process it
if(isset($_POST['submit'])){

	// get userID value
	if(isset($_POST['userID'])){
		$userID = $_POST['userID'];
	}else{
		array_push($errors, "ERROR: User id is null.");
	}

	// get tokenID value
	if(isset($_POST['tokenID'])){
		$tokenID = $_POST['tokenID'];
	}else{
		array_push($errors, "ERROR: Token id is null.");
	}

	//basic validation
	if(strlen($_POST['password']) < 8){
		array_push($errors, "Password must be 8 characters or longer.");
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		array_push($errors, "Passwords do not match.");
	}

	//if no errors have been created carry on
	if(empty($errors)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		try {
			$database->update("users", "password='$hashedpassword'", "id=$userID");
			$database->delete("tokens", "id=$tokenID");

			//redirect to index page
			header('Location: login.php?action=resetAccount');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
				error_log($e, 0);
				array_push($errors, "Error occured updating your password.");
		}

	}

}
?>



<div class="lightslide">

<div class="container">

	<div class="row">

	<!-- HEADLINE -->
    <div class="five columns">
      <h1 class="section-heading">Humans
      <span class="white">versus</span> Zombies</h1>
      <h2 class="grey subheader">University of Colorado <strong class="deeporange">Boulder</strong></h2>
      <img src="images/skull.png" class="u-max-full-width">
    </div> <!-- end headline -->



      <div class="six columns lightslide-box">

      <h4 class="white">Reset Your Password.</h4>
	  <p><a href='login.php'>&#9664; Back to Login Page.</a></p>
	  <hr>

	    	<?php if(isset($stop)){

	    		echo "<p class='bg-danger'>$stop</p>";
					echo "<p><a href='reset.php'>Forgot Password?</a></p>";

	    	} else { ?>

				<form role="form" method="post" action="" autocomplete="off">

					<?php
					//check for any errors
					if(isset($errors)){
						foreach($errors as $error){
							echo '<p class="bg-danger">'.$error.'</p>';
						}
					}

					//check the action
					/*
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
							break;
					}
					*/
					?>


					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="password" id="password" class="form-control input-lg" placeholder="New Password" tabindex="1">
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm New Password" tabindex="1">
							</div>
						</div>
					</div>
					<input type="hidden" name="userID" id="userID" value="<?php echo $userID; ?>">
					<input type="hidden" name="tokenID" id="tokenID" value="<?php echo $tokenID; ?>">
					<div class="row">
						<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Change Password" class="btn btn-primary btn-block btn-lg button-primary" tabindex="3"></div>
					</div>
				</form>

			<?php } ?>

		</div>
	</div>
</div>

</div>

<?php
//include header template
require('layout/footer.php');
?>
