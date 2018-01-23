<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'HVZ CU BOULDER';

//include header template
require('layout/header.php'); 


// get logged in user info
$username = $_SESSION['username'];
try {
	$stmt = $db->prepare("SELECT * FROM weeklongF17 WHERE username='$username'"); 
	$stmt->execute(); 
	$row = $stmt->fetch();
  $db = null;        // Disconnect
}
catch(PDOException $e) {
  echo $e->getMessage();
}
?>


<!-- BEGIN DOCUMENT -->

<!-- THE FIRST IS INTERESTING -->

<!-- NAVIGATION INCLUDE -->
<?php

  if($row['status'] == 'human'){
     require('layout/navbar-human.php');
  } else {
  require('layout/navbar-zombie.php');
  }

?>
<!-- NAVIGATION INCLUDE -->

<!-- HVZ HEADLINE SECTION 
___________________________________________-->

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

      <p class="grey subheader">
      <!-- XXX decoration, temporary -->
      <!-- <span class="deeporange">&#10006; &#10006; &#10006;</span> -->
      <!-- Welcome user -->
      Welcome, <?php echo $_SESSION['username']; ?>.
      <!-- Logout Option -->
      (<a href='logout.php'>Logout</a> || <a href="deleteAccount.php">Unregister?</a>)
      <!-- XXX decoration, temporary -->
      <!-- <span class="deeporange">&#10006; &#10006; &#10006;</span> -->
      </p>

    </div> 
  
  </div> <!-- end row -->

  </div> <!-- end container -->

</section> 

<!-- END HVZ HEADLINE SECTION -->


<!-- WEEKLONG GAME SECTION -->
<section class="darkslide">

  <div class="container center">

    <!-- Start Weeklong Headline Row -->
    <div class="row">
      <!--<img src="images/grave.png" class="u-max-full-width"></p>-->
      <h2 class="section-heading orange">Weeklong Game</h2>
      <h5 class="orange">March 19th - March 23rd</h5>
      <p class="description">
      You have successfully registered for the CU Boulder Weeklong HvZ game.
      <br>Be sure to look through the <a href="#playerinfo">Player Information</a> before the game.

      <hr>
    </div> <!-- End Weeklong Headline Row -->

    <!-- Start Weeklong Information Row -->
    <div class="row">

      <!-- Start Safety Waiver Column -->
      <div class="offset-by-one four columns">
        <h1 class="label">Safety Waiver</h1>
        <p class="description">Meanwhile, please download and sign the required safety waiver below.
        <strong class="white">Note</strong>: If you are under 18, you must have a parent or guardian sign the waiver.</p>
        <p><a class="button button-primary" href="doc/fa17-weeklong-waiver.pdf" target="_blank">Safety Waiver</a></p>
        <p><strong class="white">Safety waivers will be collected October 26th-28th (Wednesday through Friday) and on Monday, October 30th.</strong> Remember to bring them to us when you collect your bandana!</p>
        <br>
      </div> 
      <!-- End Safety Waiver Column -->

      <!-- Start Orientation Column -->
      <div class="five offset-by-one columns">
        <h1 class="label" id="orientation">Required Orientation</h1>
        <p class="description">All participants are required to take <a href="https://docs.google.com/forms/d/e/1FAIpQLSfQTk1wVTirIy7t_8vzUGqEXgrabPSOY6FRfvOKhewjQRk-yw/viewform" target="_blank">this orientation quiz</a>.</p> 

        <p>HvZ Mods will be collecting waivers and distributing player bandanas to those players at the <strong class="subheader white">UMC between 9:00am and 5:00pm on Monday, October 30th</strong>. You cannot participate without a bandana <strong class="subheader white">provided by us</strong>.</p>

        <p><a class="button button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSfQTk1wVTirIy7t_8vzUGqEXgrabPSOY6FRfvOKhewjQRk-yw/viewform" target="_blank">Orientation Quiz</a></p>

      </div> <!-- End Orientation Column -->
    </div> <!-- End Information Row -->
  </div> <!-- End container -->
</section> <!-- End section -->




<!-- GAME TIME COUNTDOWN SECTION
___________________________________________-->

<!-- <?php /* require('countdown.php'); */ ?> -->

<!-- END GAME TIME COUNTDOWN SECTION -->


<!-- THE SECOND IS RECOMMENDED -->

<!-- PROFILE INFO SECTION
___________________________________________-->

<section id="profile" class="lightslide">

	<div class="container">

	<div class="row">


		<div class="four columns">
			<div class="section-heading darkgrey">Profile</div>

			<table>
				<tr>
					<td class="subheader deeporange">User name</td>
					<td><?php echo "$row[username]"; ?></td>
				</tr>
				<tr>
					<td class="subheader deeporange">Email</td>
					<td><?php echo "$row[email]"; ?></td>
				</tr>
				<tr>
					<td class="subheader deeporange">User Code</td>
					<td class="subheader"><?php echo "$row[UserHex]"; ?></td>
				</tr>
			</table><BR>
		</div>


		<div class="seven offset-by-one columns">

			<div class="section-heading darkgrey">Player Stats</div>

		</div>
		
		<div class="seven offset-by-one columns darkslide-box">

			<table class="userstats">
				<tr>
					<td class="subheader deeporange">Status</td>
					<td class="subheader deeporange">Kill Count</td>
					<td class="subheader deeporange">Starve Date</td>
				</tr>
				<tr>
					<td class="subheadline"><?php echo "$row[status]"; ?></td>
					<td class="subheadline"><?php echo "$row[KillCount]"; ?></td>
					<td class="subheader"><?php echo "$row[StarveDate]"; ?></td>
				</tr>
			</table> 

			<?php
					/* Success message from logkill.php */
					if ( isset($_GET['success']) && $_GET['success'] == 1 )
					{
					   echo "<div class='bg-success'>Your kill has been registered and starve date(s) have been updated.</div>";
					}
				?>

		</div>

	</div>

  </div>

</section>

<!-- END PROFILE INFO SECTION -->

<?php 
require('playerinfo.php'); 
?>


<!-- END DOCUMENT -->

<!-- THE LAST IS THE DEATH RATTLE -->


<?php 
//include header template
require('layout/footer.php'); 
?>