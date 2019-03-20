<!DOCTYPE html>
<html lang="en">
<?php
require('includes/config.php');
$title = 'CU HvZ | Profile';
?>
<head>
	<?php require('layout/header.php'); ?>
</head>
<body>
	<?php include 'layout/navbar.php'; ?>


<?php
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>


<!-- BEGIN DOCUMENT -->

<!-- HVZ HEADLINE SECTION
___________________________________________-->
<?php
//echo '<p class="bg-danger">'.$error.'</p>';
if(!$user->is_activated()){
    if(isset($_GET['action']) && $_GET['action']=="resend"){
			$email  = "josh.brown.3255@gmail.com";
			$subject   = "My subject";
			$message = "Text message !";
			mail($email, $subject, $message);
      // $mail = $user->make_activation_email();
      // $mail->send();
      echo "<p class='bg-success' style='margin: 0;'> &#10003; Activation email sent.</p>";
    } else {
      echo "<p class='bg-danger' style='margin: 0;'> &#10003; Your account is not activated yet.
      <a href='profile.php?action=resend' class='resend'>Resend activation email.</a></p>";
    }
}

if(isset($_GET['join']) && isset($_GET['eventId'])){
  $eventName = $_GET['join'];
  if($user->join_event($_GET['eventId'])){
    echo "<p class='bg-success' style='margin: 0;'> &#10003; <strong>Thanks for signing up for $eventName!</strong> <br> We'll send you an updates, so makes sure to check your email!</p>";
  }
}
if(isset($_GET['leave']) && isset($_GET['eventId'])){
  $eventName = $_GET['join'];
  if($user->leave_event($_GET['eventId'])){
    echo "<p class='bg-success' style='margin: 0;'> &#10003; <strong>Sorry to see you go!</strong></p>";
  }
}
if(isset($_GET['kys'])){
  if($user->get_game_stats()["user_hex"] == $_GET['kys']){
    echo "<p class='bg-success' style='margin: 0;'> &#10003; <strong>Congratulations, you killed yoself.</strong></p>";
    echo "\n<script>\n";
    echo "document.getElementById('logkill_button').parentNode.style.display = 'block';\n";
    echo "document.getElementById('kys_button').parentNode.style.display = 'none';\n";
    echo "</script>\n";
    $user->kys();
  }
}
?>
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
      <!--(<a href='logout.php'>Logout</a> || <a href="deleteAccount.php">Unregister?</a>)-->
      <!-- XXX decoration, temporary -->
      <!-- <span class="deeporange">&#10006; &#10006; &#10006;</span> -->
      </p>

    </div>

  </div> <!-- end row -->
  <?php
  require('playerinfo.php');
  if($weeklong->active_event()){
    if($user->is_in_event($_SESSION["weeklong"])){
      include "weeklong/playerstats.php";
      echo "\n<script>\n";
      if($user->get_game_stats()["status"] == "human"){
        echo "document.getElementById('kys_button').parentNode.style.display = 'block';\n";
        echo "document.getElementById('logkill_button').parentNode.style.display = 'none';\n";
      }else{
        echo "document.getElementById('logkill_button').parentNode.style.display = 'block';\n";
        echo "document.getElementById('kys_button').parentNode.style.display = 'none';\n";
      }
      echo "</script>\n";

    }
  }
  ?>
  </div> <!-- end container -->

</section>

<!-- END HVZ HEADLINE SECTION -->







<!-- GAME TIME COUNTDOWN SECTION
___________________________________________-->

<?php
// insert clock

if($weeklong->active_event()){
  if($user->is_in_event($_SESSION["weeklong"])){
    require('weeklong/clock.php');
  }
}
?>


<?php
//include header template
require('layout/footer.php');
?>

</body>
</html>
