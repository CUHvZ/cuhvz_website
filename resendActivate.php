<?php
//include config
require_once('includes/config.php');

// check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: index.php'); } 
			

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
      <h4 class="white">Resend Activation Link</h4>
      <p><a href='login.php'>&#9664; Back to Login Page.</a></p>
      <hr>
	  <p>Please input the email associated with your account to resend your activation link.</p>

		<form role="form" method="post" action="" autocomplete="on">

			<input type="email" name="email" id="email" class="form-control input-lg u-full-width" placeholder="Email Address" value="" tabindex="1">

			
			<input type="submit" name="submit" value="Resend" class="btn btn-primary btn-block btn-lg button-primary" tabindex="2">

			<br>

	<?php
	if(isset($_POST['submit'])){

		$stmt = $db->prepare('SELECT id, email, username, active FROM users WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$memberID = $row['id'];
		$active = $row['active'];

		if(!empty($row['email'])){

			if($active == 'Yes'){
			echo 'Your account has already been activated. <a href="login.php">Login?</a>';
		} else {

			// send email
	$to = $_POST['email'];
	$subject = "CU Boulder HvZ Registration Confirmation";
	$body = "<p>Thank you for registering to play Humans vs Zombies at CU Boulder.</p>
	<p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$memberID&y=$active'>".DIR."activate.php?x=$memberID&y=$active</a></p>
	<p>- CU Boulder Humans vs Zombies Mod Team</p>";

	$mail = new Mail();
	$mail->setFrom(SITEEMAIL);
	$mail->addAddress($to);
	$mail->subject($subject);
	$mail->body($body);
	$mail->send();

	echo '<p class="bg-success">Success: We resent your activation link. Please check your email inbox and junk folder.</p>';
	}

		} else {
			echo '<p class="bg-danger">Email is not registered in our system.</p>';
		}
	

	}
	?>

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
