<!--
THIS PAGE IS NOT DONE
-->

<?php require('includes/config.php');

// if form has been submitted process it
if(isset($_POST['submit'])){

	// email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address.';
	} else {
		$stmt = $db->prepare('SELECT email FROM subscribers WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}
	}


	// if no errors have been created carry on
	if(!isset($error)){

		try {

			// insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO subscribers (email) VALUES (:email)');
			$stmt->execute(array(
				':email' => $_POST['email'],
			));
			$id = $db->lastInsertId('subscriberID');

      // redirect to index page
      header('Location: subscribe.php?success=1');

			// send email
			$to = $_POST['email'];
			$subject = "CU HVZ Subscription Confirmation";
			$body = "<p>You have successfully subscribed to CU Humans vs Zombies. We'll keep you updated on future games!</p>
			<p>- CU Boulder Humans VS Zombies Mod Team</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			exit;

		// else catch the exception and show the error
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


<!-- Begin Primary Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

<!--
<nav>
<center>
<a href="#slideshow" class="cta">What is HVZ? Click to learn more.</a>
</center>
</nav>
-->

<!-- SLIDE #1 - SIGNUP -->

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

      <p>Thank you for a very successful Spring 2017 Weeklong and Lock-in game! Stay tuned for upcoming CU Humans Versus Zombies games. Meanwhile, be sure to follow us on <a href="http://www.facebook.com/HvZatCU/" target="_blank">Facebook</a> and subscribe to the mailist list below.</p>
      <!--<p><a href='login.php'>&#9664; Back to Login Page.</a><br>Input your email to get future CU HVZ updates.</p>-->

    <hr>

    <h4>Subscribe</h4>
    <p>Feel free to subscribe to our mailist list for updates.</p>

	  	<?php
		// check for any errors, error messages
		if(isset($error)){
		foreach($error as $error){
		echo '<p class="bg-danger"> &#10006; '.$error.'</p>';
		}
		}
    ?>

		<!-- BEGIN SIGNUP FORM -->
        <form role="form" method="post" action="" autocomplete="off">

          <div class="row">
            <div class="twelve columns">
            <input type="email" name="email" id="email" class="form-control input-lg u-full-width" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="3">
            </div>
          </div>

          <div class="row">
            <div class="twelve columns">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block btn-lg button-primary" tabindex="7">
            </div>
          </div>

        </form>

      <?php
      // if action is joined show success message
      if ( isset($_GET['success']) && $_GET['success'] == 1 )
          {
         echo "<p class='bg-success'>You have successfully subscribed to CU Humans vs Zombies. We'll keep you updated on future games!</p>";
          }
      ?>

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
