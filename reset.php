<?php require('includes/config.php');

//if logged in redirect to user page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); }

//if form has been submitted process it
if(isset($_POST['submit'])){

	//email validation
	$email = $_POST['email'];
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address.';
	} else {
		$stmt = $db->prepare('SELECT email FROM weeklongF17 WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(empty($row['email'])){
			$error[] = 'Email provided is not recognized.';
		}

	}

	//if no errors have been created carry on
	if(!isset($error)){

		//create the activasion code
		$token = md5(uniqid(rand(),true));

		try {

			$stmt = $db->prepare("UPDATE weeklongF17 SET resetToken = :token, resetComplete='No' WHERE email = :email");
			$stmt->execute(array(
				':email' => $row['email'],
				':token' => $token
			));

			//send email
			$to = $row['email'];
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
			$mail->send();

			//redirect to index page
			header('Location: login.php?action=reset');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

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
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

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
