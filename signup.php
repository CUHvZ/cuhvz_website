<?php require('includes/config.php');


// if logged in redirect to user page
if( $user->is_logged_in() ){ header('Location: profile.php'); }

// if form has been submitted process it
if(isset($_POST['submit'])){

	// very basic validation
	if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM weeklongF17 WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}
	}

	// password validation
	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}
	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}
	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	// phone validation
	if(strlen($_POST['phone']) != 10){
		$error[] = 'Invalid phone number. Please enter numbers only.';
	}

	// email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address.';
	} else {
		$stmt = $db->prepare('SELECT email FROM weeklongF17 WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}
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

			// insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO members (username,password,firstName,lastName,email,phone,active,UserHex) VALUES (:username, :password, :firstName, :lastName, :email, :phone, :active, :UserHex)');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':password' => $hashedpassword,
				':firstName' => $_POST['firstName'],
				':lastName' => $_POST['lastName'],
				':email' => $_POST['email'],
				':phone' => $_POST['phone'],
				':active' => $activasion,
				':UserHex' => $user_hex
			));
			$id = $db->lastInsertId('memberID');

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
			$mail->send();

			// redirect to index page
			header('Location: signup.php?action=joined');
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
<?php include 'layout/navbar.php' ?>
<!--
<nav>
<center>
<a href="#slideshow" class="cta">What is HVZ? Click to learn more.</a>
</center>
</nav>
-->
<!--
<div class="darkslide">

<div class="slider">
<img src="images/info/Fall2017/Slide01.jpg" />
<img src="images/info/Fall2017/Slide02.jpg" />
<img src="images/info/Fall2017/Slide03.jpg" />
<img src="images/info/Fall2017/Slide04.jpg" />
<img src="images/info/Fall2017/Slide05.jpg" />
<img src="images/info/Fall2017/Slide06.jpg" />
<img src="images/info/Fall2017/Slide07.jpg" />
<img src="images/info/Fall2017/Slide08.jpg" />
<img src="images/info/Fall2017/Slide09.jpg" />
<img src="images/info/Fall2017/Slide10.jpg" />
<img src="images/info/Fall2017/Slide11.jpg" />
<img src="images/info/Fall2017/Slide12.jpg" />
<img src="images/info/Fall2017/Slide13.jpg" />
<img src="images/info/Fall2017/Slide14.jpg" />
<img src="images/info/Fall2017/Slide15.jpg" />
<img src="images/info/Fall2017/Slide16.jpg" />
<img src="images/info/Fall2017/Slide17.jpg" />
<img src="images/info/Fall2017/Slide18.jpg" />
<img src="images/info/Fall2017/Slide19.jpg" />
<img src="images/info/Fall2017/Slide20.jpg" />
<img src="images/info/Fall2017/Slide21.jpg" />
<img src="images/info/Fall2017/Slide22.jpg" />
<img src="images/info/Fall2017/Slide23.jpg" />
<img src="images/info/Fall2017/Slide24.jpg" />
<img src="images/info/Fall2017/Slide25.jpg" />
<img src="images/info/Fall2017/Slide26.jpg" />

</div>

</div>
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
        <h4 class="white">Undergoing construction</h4>
        <p class="white">Check back later for updates on our next event!</p>
        <!--
      <h4 class="white">Register to play.</h4>
      <span class="white">Weeklong Game</span> (March 19th - March 23rd).
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
<!--    
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
                <input type="text" name="firstName" id="firstName" class="form-control input-lg u-full-width" placeholder="First Name" value="<?php if(isset($error)){ echo $_POST['firstName']; } ?>" tabindex="4">
            </div>
            <div class="six columns">
                <input type="text" name="lastName" id="lastName" class="form-control input-lg u-full-width" placeholder="Last Name" value="<?php if(isset($error)){ echo $_POST['lastName']; } ?>" tabindex="5">
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
<!--
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

<br><br>

<div class="darkslide" id="slideshow">
<div class="slideshow-container">
  <div class="mySlides">
    <img src="images/info/Fall2017/Slide01.jpg" style="width:100%">
  </div>

  <div class="mySlides">
    <img src="images/info/Fall2017/Slide02.jpg" style="width:100%">
  </div>

  <div class="mySlides">
    <img src="images/info/Fall2017/Slide03.jpg" style="width:100%">
  </div>
   <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide04.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide05.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide06.jpg" style="width:100%">
  </div>
  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide07.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide08.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide09.jpg" style="width:100%">
</div>

      <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide10.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide11.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide12.jpg" style="width:100%">
  </div>

        <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide13.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide14.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide15.jpg" style="width:100%">
  </div>

        <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide16.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide17.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide18.jpg" style="width:100%">
  </div>

      <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide19.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide20.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide21.jpg" style="width:100%">
  </div>

    <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide22.jpg" style="width:100%">
  </div>

        <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide23.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide24.jpg" style="width:100%">
  </div>

  <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide25.jpg" style="width:100%">
  </div>

        <div class="mySlides fade">
    <img src="images/info/Fall2017/Slide26.jpg" style="width:100%">
  </div>

  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<!--<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div> -->
</div>
<script src="js/slider.js"></script>

<?php
// insert clock
require('layout/clock.php');
?>




<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->


<?php
// include footer template
require('layout/footer.php');
?>

