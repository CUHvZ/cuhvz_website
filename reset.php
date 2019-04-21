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
	<?php include 'layout/navbar.php'; ?>


<?php

$errors = [];

//if logged in redirect to user page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); }

//if form has been submitted process it
if(isset($_POST['submit'])){

  $database = new Database();
	//email validation
	$email = $_POST['email'];
	validateEmail($database, $email, $errors);

	if(empty($errors)){
		$resetToken = md5(uniqid(rand(),true));
		$data = $database->getUserDataByEmail($email);
		if(isset($data["error"])){
			array_push($errors, "Error occured accessing user data.");
		}else{
			$userID = $data["id"];
			$token = new Token($userID, Token::$PASS_RESET);
			// delete any duplicate entries
			$database->deleteDuplicateTokens($userID, Token::$PASS_RESET);
			// insert new token
			$error = $database->executeQuery($token->getQuery());
			if(!isset($error["error"])){
				sendPasswordResetEmail($email, $token->getValue(), $errors);
			}
			if(empty($errors)){
				//redirect to profile page
				header('Location: login.php?action=reset');
				exit;
			}
		}
	}
}

function validateEmail($db, $email, &$errors){
	$indexAt = strpos($email, "@");
	// checks is email is blank before @
	if(empty(substr($email, 0, $indexAt))){
		array_push($errors, 'Please enter a valid email address.');
	}
	// checks if email is in a valid format
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		array_push($errors, 'Please enter a valid email address.');
	} else {
		$data = $db->executeQueryFetch("SELECT email FROM users WHERE email = '$email'");
		//error_log($data, 0);
		if(isset($data["error"])){
			error_log("error occured validating email.", 0);
			array_push($errors, "An error occured trying to access the database. Please contact the Mod team.");
		}else{
			if(!isset($data["email"]))
				array_push($errors, 'Email does not exist.');
		}
	}
}

function sendPasswordResetEmail($email, $token, &$errors){
	try{
		$to = $email;
		$subject = "CU Boulder HvZ Password Reset";
		$body = "<p>Someone requested that the password associated with your CU Boulder HvZ account be reset.</p>
		<p>If this was a mistake, please ignore this email.</p>
		<p>To reset your password, click here: <a href='".DIR."resetPassword.php?key=$token'>".DIR."resetPassword.php?key=$token</a></p>
		<p>- CU Boulder HvZ Team";

		$mail = new Mail();
		$mail->setFrom(SITEEMAIL);
		$mail->addAddress($to);
		$mail->subject($subject);
		$mail->body($body);
		error_log($mail->Mailer, 0);
		$mail->isSMTP();
		$mail->send();
	//else catch the exception and show the error.
	} catch(PDOException $e) {
		error_log($e, 0);
		array_push($errors, 'Error occured send email.');
	}
}

// define page title
$title = 'HVZ CU BOULDER';

// include header template
require('layout/header.php');
?>

<!-- Begin Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

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

      <h4 class="white">Reset Password</h4>
	  <p><a href='login.php'>&#9664; Back to Login Page.</a></p>
	  <hr>
	  <p>Input your email to reset your account.</p>

			<form role="form" method="post" action="" autocomplete="off">

				<?php
				//check for any errors
				if(!empty($errors)){
					foreach($errors as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}else{
					if(isset($_GET['action'])){

						//check the action
						switch ($_GET['action']) {
							case 'active':
								echo "<p class='bg-success'>Your account is now active you may now log in.</p>";
								break;
							case 'reset':
								echo "<p class='bg-success'>Please check your inbox for a reset link.</p>";
								break;
						}
					}
				}
				?>

				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg u-full-width" placeholder="Email" value="" tabindex="1">
				</div>

				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Reset" class="btn btn-primary btn-block btn-lg button-primary" tabindex="2"></div>
				</div>

			</form>
		</div>
	</div>

</div>

</div>

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

<?php
//include header template
require('layout/footer.php');
?>

</body>
</html>
