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
		$_SESSION['username'] = $username;
		header('Location: profile.php');
		exit;
	
	} else {
		$error[] = 'Wrong username or password or your account has not been activated.';
	}

}// end if submit

// define page title
$title = 'HVZ CU BOULDER';

// include header template
require('layout/header.php'); 
?>

<!-- Begin Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

<nav class="fixed-nav-bar">
<a href="#" class="rightborder">Home</a>
<a href="#playerinfo" class="rightborder">What is Humans vs Zombies?</a>
<!--<a href="#lockin" class="rightborder cta">Now open! Spring Lock-in Game</a>-->

	<a href="subscribe.php" class="leftborder">Subscribe</a>
	<a href="#weeklong" class="leftborder">Weeklong Game Stats</a>

</nav>

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


<div class="lightslide contentwithnav" id="login">

<div class="container">

	<div class="row">

	<!-- HEADLINE -->
    <div class="five columns">
      <h1 class="section-heading">CU HVZ Weeklong Game</h1>
      <!--<img src="images/grave.png" class="u-max-full-width">-->
	 
		 <?php

		$countusers = $db->query("SELECT count(1) FROM weeklongF17")->fetchColumn();
		$sth = $db->prepare("SELECT status FROM weeklongF17");
		$sth->execute();

		/* Fetch all of the values of the first column */
		$result = $sth->fetchAll(PDO::FETCH_COLUMN, 0);
		//var_dump($result);
		//print_r($result);
		//print_r(array_count_values($result));
		$TotalHuman = array_count_values($result)['human'];
		$TotalZombie = array_count_values($result)['zombie'];
		$TotalDeceased = array_count_values($result)['deceased'];

		?>
		<hr>

		<table class="gamestats" style="border: 1px #000 solid">
		  <thead>
		  <tr class='subheader white' style="background-color: #222">
		    <th>Total Humans</th>
		    <th>Total Zombies</th>
		    <th>Total Deceased</th>
		  </tr>
		</thead>

		<tbody>

		<tr>
		<td class="subheadline grey"><?php echo $TotalHuman ?></td>
		<td class="subheadline grey"><?php echo $TotalZombie ?></td>
		<td class="subheadline grey"><?php echo $TotalDeceased ?></td>
		</tr>

		</tbody>

		</table>

    </div> <!-- end headline -->

	 
	 <div class="six offset-by-one columns lightslide-box">
      <h4 class="white">Please login.</h4>
      <!--<p>Registration for the Spring 2017 Weeklong Game has closed. Missed it? <a href="subscribe.php">Subscribe</a> for future game updates.<br></p>-->
      <hr>
	  <p>Not a member? <a href='./'>Sign-up now.</a></p>

			<form role="form" method="post" action="" autocomplete="on">

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
					<a href='retrieveUsername.php'>Forgot your Username?</a><br>
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="Username" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
				</div>

				<div class="form-group">
				<a href='reset.php'>Forgot your Password?</a> <br>
					<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
				</div>
				
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Login" class="btn btn-primary btn-block btn-lg button-primary" tabindex="5"></div>
				</div>

				 <p>
					 <!-- <a href='resendActivate.php'>Click to resend activation link.</a> -->
					 <a href='deleteAccount.php'>Click to Unregister / Delete Account.</a>
				 </p>

			</form>

			<hr>

			
		

		</div>

	</div>

</div>

</div>

<!-- BEGIN LOCKIN -->
<!--
<div class="lightslide" id="lockin">

<div class="container">

	<div class="row">
-->
	<!-- HEADLINE -->
	<!--
    <div class="five columns">
      <h1 class="section-heading">Spring '17 Lock-in
      Game</h1>
      <img src="images/ecentrance.jpg" width="80%">

    </div> -->
	<!-- end headline -->

	<!-- 
	 <div class="six offset-by-one columns darkslide-box">
      <h4 class="deepgrey">CU HvZ Souljourn</h4>

      <p class="subheader">
      Friday, March 24th, 2017 9:00PM <BR>
	  CU Engineering Center (South Entrance)</p>

	  <p>
	  9:00PM - Doors Open, Check-in begins<BR>
	  9:40PM - Doors Close, Check-in ends<BR>
	  10:00PM - Game Start<BR>
	  2:00AM - Game End<BR>
	  </p>

	  <p>You will begin as a human player. If a zombie tags you, you will become a zombie. Shooting zombie players with nerf darts (or hitting them with sock bombs) will stun them briefly. In addition to your own survival, you will have round-specific missions and goals to focus on.<BR>
	</p>

	<p><a href="https://www.eventbrite.com/e/cu-hvz-souljourn-tickets-32426597827" target="_blank">Click to learn more.</a></p>

	<a class="button button-primary" href="https://www.eventbrite.com/e/cu-hvz-souljourn-tickets-32426597827" target="_blank">Register to Play</a>
		
	  </div>

	</div>

</div>

</div>
-->
<!-- END LOCK IN -->

<!-- GAME TIME COUNTDOWN SECTION
___________________________________________-->


<!-- WEEKLONG SECTION -->
<div class="darkslide" id="weeklong">
  <div class="container center">

    <div class="row">
      <!--
      <img src="images/grave.png" class="u-max-full-width"> -->
      <h2 class="section-heading orange">Weeklong Game</h2>
      <h5 class="deeporange">March 19th - March 23rd</h5>
      Are you registered to play? <a href="#login">Click to login.</a>
      <br><BR><BR>

      <h5 class="subheader">Gametime Remaining</h5>
      <hr>
  
      <!-- Countdown Clock -->
      <div id="clockdiv">
        <div class="offset-by-two two columns">
          <span class="clocknumber subheader days"></span><br>
          <span class="clocklabel">Days</span>
        </div>
        <div class="two columns">
          <span class="clocknumber subheader hours"></span><br>
          <span class="clocklabel">Hrs</span>
        </div>
        <div class="two columns">
          <span class="clocknumber subheader minutes"></span><br>
          <span class="clocklabel">Min</span>
        </div>
        <div class="two columns">
          <span class="clocknumber subheader seconds"></span><br>
          <span class="clocklabel">Sec</span>
        </div>
      </div>
      <!-- End Countdown Clock -->

</div>

<BR><BR>

<div class="row">

<!-- END GAME TIME COUNTDOWN SECTION -->

<center>

<div class="twelve columns">

<h5 class="subheader">Most Recent Activity</h5>

<hr>

 <?php
  try {
    $query = "SELECT username, status, KillCount, StarveDate FROM weeklongF17 WHERE status = 'human' OR status = 'zombie' OR status = 'deceased' ORDER BY StarveDate DESC LIMIT 10";

  print "
    
    <table id='table1'>
    <tr class='subheader orange'>
    <th onclick='sortTable(0)'>Username</th>
    <th onclick='sortTable(1)'>Status</th>
    <th onclick='sortTable(2)'>Kill Count</th>
    <th onclick='sortTable(3)' class='starve'>Starve Date</th>
    </tr>
    
  ";

  $data = $db->query($query);
  $data->setFetchMode(PDO::FETCH_ASSOC);
  foreach($data as $row){
   print " 
      <tr>
   ";
   foreach ($row as $name=>$value){
   print " <td>$value</td>";
   } // end field loop
   print " </tr>";
  } // end record loop
  print "</table>";
  } catch(PDOException $e) {
   echo 'ERROR: ' . $e->getMessage();
  } // end try
 ?>
 </div> <!-- end playerlist list -->
 </center>
 </div>
 </BR>
 </BR>
 </div>
 </div>
 </div>
 </div>
 </center>
 </section>

 <?php 
require('playerinfo.php'); 
?>

<script src="js/countdown.js"></script>
<script src="js/sort.js"></script>


<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

<?php 
require('layout/footer.php'); 
?>
