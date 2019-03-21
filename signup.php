<?php

function isValid($str) {
    return !preg_match('/[^A-Za-z0-9.#\\-$]/', $str);
}

function isValidName($str) {
    return !preg_match('/[^A-Za-z.#\\-$]/', strip($str));
}

function strip($str){
	return str_replace(' ', '', $str);
}

require('includes/config.php');
//require $_SERVER["DOCUMENT_ROOT"]."/classes/Database.php";

$database = new Database();

// if logged in redirect to user page
//if( $user->is_logged_in() ){ header('Location: profile.php'); }

// if form has been submitted process it
if(isset($_POST['submit'])){

	// very basic validation
	if(empty(isValid($_POST['username']))){
		$error[] = 'Username contains invalid character';
	}else if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	} else {
    $username = $_POST['username'];
		$row = $database->executeQueryFetch("SELECT username FROM users WHERE username = '$username'");

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}
	}

	// password validation
	if(strlen(str_replace(' ', '', $_POST['password'])) == 0){
		$error[] = 'Enter a password';
	}else if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short';
	}else if(strlen($_POST['passwordConfirm']) == 0){
		$error[] = 'You must confirm your password';
	}else if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match';
	}

	// phone validation
	$phone = preg_replace('/[^0-9]/', '', $_POST['phone']);
	if(strlen($phone) != 10 && strlen($phone) != 0){
		$error[] = 'Invalid phone number. Please enter numbers only.';
	}else if(strlen($phone) == 0){
		$phone = false;
	}

	// email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address.';
	} else {
    $email = $_POST['email'];
		$row = $database->executeQueryFetch("SELECT email FROM users WHERE email = '$email'");

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}
	}

	// name validation
	if(strlen(strip($_POST['first_name'])) == 0){
		$error[] = 'Enter your first name';
	}else if(empty(isValidName($_POST['first_name']))){
		$error[] = 'First name contains invalid character.';
	}

	if(strlen(strip($_POST['last_name'])) == 0){
		$error[] = 'Enter your last name';
	}else if(empty(isValidName($_POST['last_name']))){
		$error[] = 'Last name contains invalid character.';
	}



	// if no errors have been created carry on
	if(!isset($error)){

		// hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		// create the activation code
		$activasion = md5(uniqid(rand(),true));

		// create random user hex
		$user_hex = substr(md5(uniqid(rand(),'')),0,5);

		try {

      $username = $_POST['username'];
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $email = $_POST['email'];

      $fields = "username,password,first_name,last_name,email";
      $values = "'$username', '$hashedpassword', '$first_name', '$last_name', '$email'";

      // insert into database
			if($phone){
        $fields = "username,password,first_name,last_name,email,phone";
        $values = "'$username', '$hashedpassword', '$first_name', '$last_name', '$email', '$phone'";
			}
      $database->insert("users", $fields, $values);
      $id = $database->lastInsertId('id');

      $database->insert("user_stats", "id", $id);

      $fields = "user_id, token, token_type, expiration";
      $values = "$id, '$activasion', 'ACTIVATION', NOW() + INTERVAL 1 DAY";
      $database->insert("tokens", $fields, $values);

			// send email
			$to = $_POST['email'];
			$subject = "CU Boulder HvZ Registration Confirmation";
			$body = "<p>Thank you for registering to play Humans vs Zombies at CU Boulder.</p>
			<p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>- CU BOULDER HVZ TEAM</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
      $mail->isSMTP();
			$mail->send();

			// redirect to profile page
      $user->login($_POST['username'], $_POST['password']);
      //header('Location: signup.php?action=joined');
      header('Location: profile.php');
			exit;

		// else catch the exception and show the error
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

?>


<!-- Begin Primary Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<!DOCTYPE html>
<html lang="en">
<?php
$title = 'CU HvZ | ';
?>
<head>
	<?php require('layout/header.php'); ?>
</head>
<body>
	<?php include 'layout/navbar.php'; ?>


<div id="signup" class="lightslide">

 <div class="container">

  <div class="row">

	<!-- HEADLINE -->
      <div class="five columns">
      <h1 class="section-heading">Humans
      <span class="white">versus</span> Zombies</h1>
      <h2 class="grey subheader">University of Colorado <strong class="deeporange">Boulder</strong></h2>
      <img src="images/skull.png" class="u-max-full-width">
    </div> <!-- end headline -->

	<!-- SIGNUP BOX -->
      <div class="six columns lightslide-box">
      <h4 class="white">Register to play.</h4>
      <hr>
	  <p>Already registered? <a href='login.php'>Login.</a></p>

	  	<?php
		// check for any errors, error messages
		if(isset($error)){
		foreach($error as $error){
		echo '<p class="bg-danger"> &#10006; '.$error.'</p>';
		}
		}

		// if action is joined show success message
		if(isset($_GET['action']) && $_GET['action'] == 'joined'){
		echo "<p class='bg-success'> &#10003; <strong>Thanks for signing up!</strong> <br> We sent you an activation link to complete your registration. Please check your email inbox.</p>";
		}
		?>

		<!-- BEGIN SIGNUP FORM -->

        <form role="form" method="post" action="" autocomplete="off">

          <div class="row">
            <div class="twelve columns">
            <input type="text" name="username" id="username" class="form-control input-lg u-full-width" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
            <input type="text" name="phone" id="phone" class="form-control input-lg u-full-width" placeholder="Phone Number" value="<?php if(isset($error)){ echo $_POST['phone']; } ?>" tabindex="2">
            <input type="email" name="email" id="email" class="form-control input-lg u-full-width" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="3">
            </div>
          </div>

		  <div class="row">
            <div class="six columns">
                <input type="text" name="first_name" id="first_name" class="form-control input-lg u-full-width" placeholder="First Name" value="<?php if(isset($error)){ echo $_POST['first_name']; } ?>" tabindex="4">
            </div>
            <div class="six columns">
                <input type="text" name="last_name" id="last_name" class="form-control input-lg u-full-width" placeholder="Last Name" value="<?php if(isset($error)){ echo $_POST['last_name']; } ?>" tabindex="5">
            </div>
          </div>

          <div class="row">
            <div class="six columns">
                <input type="password" name="password" id="password" class="form-control input-lg u-full-width" placeholder="Password" tabindex="6">
            </div>
            <div class="six columns">
                <input type="password" name="passwordConfirm" id="passwordConfirm" class="u-full-width form-control input-lg" placeholder="Confirm Password" tabindex="7">
            </div>
          </div>

          <!-- TERMS & CONDITIONS CHECKBOX
          <div class="row">
            <div class="twelve columns">
                <input type="checkbox" tabindex="6">
                <span class="label-body">I agree to the <a href="#">Terms and Conditions.</a></span>
            </div>
          </div>
          -->

          <div class="row">
            <div class="twelve columns">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block btn-lg button-primary" tabindex="8">
            </div>
          </div>

        </form>

      </div> <!-- end signup box -->

  </div> <!-- end row -->

 </div> <!-- end container -->

</div> <!-- end signup section -->

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->


<?php
// include footer template
require('layout/footer.php');
?>

</body>
</html>
