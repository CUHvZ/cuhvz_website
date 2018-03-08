<?php
//include config
require_once('includes/config.php');

// check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: profile.php'); } 

// process login form if submitted
if(isset($_POST['submit'])){

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if($user->login($username,$password)){
		if(isset($_GET['join']) && isset($_GET['eventId'])){
			header('Location: profile.php?join='.$_GET['join']."&eventId=".$_GET['eventId']);
		}
		else{
			header('Location: profile.php');
		}
		exit;
	
	} else {
		$error[] = 'Wrong username/email password combination or your account has not been activated.';
	}

}// end if submit

// define page title
$title = 'HVZ CU BOULDER';

// include header template
require('layout/header.php'); 
?>

<!-- Begin Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<!--
<nav class="fixed-nav-bar">
<a href="#" class="rightborder">Home</a>
<a href="#playerinfo" class="rightborder">What is Humans vs Zombies?</a>

	<a href="subscribe.php" class="leftborder">Subscribe</a>
	<a href="#weeklong" class="leftborder">Weeklong Game Stats</a>

</nav>
-->
<!-- HVZ HEADLINE SECTION 
___________________________________________-->
<!--
<section class="lightslide contentwithnav">

 <div class="container">
  <div class="row">
    
    <div class="two columns">
      <img src="images/skull.png" class="u-max-full-width">
    </div>

    <div class="ten columns">

      <p class="grey subheader">
        University of Colorado <strong>Boulder</strong>
      </p>

      <h1 class="section-heading deepgrey">
        Humans <span class="white">versus</span> Zombies
      </h1>

    </div> 
  
  </div> 

  </div> 

</section> 
-->
<!-- END HVZ HEADLINE SECTION -->
<?php include 'layout/navbar.php'; ?>

<div class="lightslide contentwithnav" id="login">

<div class="container">	 
	 <div class="login lightslide-box" align="center">
      <h4 class="white">Please login.</h4>
      <!--<p>Registration for the Spring 2017 Weeklong Game has closed. Missed it? <a href="subscribe.php">Subscribe</a> for future game updates.<br></p>-->
      <hr>
	  <p>Not a member? <a href='./'>Sign-up now.</a></p>

			<form role="form" method="post" actionaction="" autocomplete="on">

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
							echo "<p class='bg-success'>Your account has been activated. Please login.</p>";
							break;
						case 'reset':
							echo "<p class='bg-success'>Please check your inbox for a reset link.</p>";
							break;
						case 'resetAccount':
							echo "<p class='bg-success'>Password changed, you may now login.</p>";
							break;
					}

				}

				
				?>

				<div class="form-group">
					<label>Username/Email</label>
					<input type="text" name="username" id="username" class="form-control input-lg u-full-width" placeholder="Username/Email" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
				</div>

				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" id="password" class="form-control input-lg u-full-width" placeholder="Password" tabindex="3">
				</div>
				
				<div class="row">
					<div style="float: left;">
						<input type="submit" name="submit" value="Login" class="btn btn-primary btn-block btn-lg button-primary" tabindex="5">
					</div>
				</div>

				<div class="row">
					<a href='retrieveUsername.php'>Forgot Username?</a> | 
					<a href='reset.php'>Forgot Password?</a>
				</div>

			</form>

			<hr>

	</div>

</div>

</div>

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

<?php 
require('layout/footer.php'); 
?>
