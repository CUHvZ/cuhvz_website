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
$database = new Database();
if(!$user->is_activated()){
    if(isset($_GET['action']) && $_GET['action']=="resend"){
			$userID = $_SESSION['id'];
			$userEmail = $_SESSION['email'];
      $token = new Token($userID, Token::$ACTIVATE);
      $error = $database->executeQuery($token->getQuery());
			if(!isset($error["error"])){
				$tokenValue = $token->getValue();
				$subject = "CU Boulder HvZ Registration Confirmation";
				$body = "<p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$userID&y=$tokenValue'>".DIR."activate.php?x=$userID&y=$tokenValue</a></p>
				<p>- CU BOULDER HVZ TEAM</p>";

				$mail = new Mail();
				$mail->setFrom(SITEEMAIL);
				$mail->addAddress($userEmail);
				$mail->subject($subject);
				$mail->body($body);
	      $mail->isSMTP();
				$mail->send();
	      echo "<p class='bg-success' style='margin: 0;'> &#10003; Activation email sent.</p>";
			}
    } else {
      echo "<p class='bg-danger' style='margin: 0;'> &#10003; Your account is not activated yet.
      <a href='profile.php?action=resend' class='resend'>Resend activation email.</a></p>";
    }
}


if(isset($_GET['action']) && $_GET['action']=="activated"){
	echo "<p class='bg-success' style='margin: 0;'> &#10003; Your account has been activated.</p>";
}


if(isset($_GET['join']) && isset($_GET['eventId'])){
  $eventName = $_GET['join'];

	$user_hex = substr(md5(uniqid(rand(),'')),0,5);
	// $query =
	// try{
	// 	$stmt = $this->_db->prepare('INSERT INTO '.$event.' (user_id,username, user_hex) VALUES (:user_id, :username, :user_hex)');
	// 	$stmt->execute(array(
	// 		':user_id' => $_SESSION['id'],
	// 		':username' => $_SESSION['username'],
	// 		':user_hex' => $user_hex ));
	// 	return true;
	// }catch(PDOException $e) {
	// 	$errorMessage = $e->getMessage();
	// 	if (!strpos($errorMessage, 'Duplicate entry')) { // this will throw out the duplicate error
	// 			echo '<p class="bg-danger" style="margin: 0;">'.$errorMessage.'</p>';
	// 			echo "<p class='bg-danger' style='margin: 0;'> &#10003; <strong>Something went wrong tring to sign up for $event!</strong> <br> Try logging out and logging back in. Contact the mod team if this problem continues.</p>";
	// 	}
	// 		return false;
	// }

  // if($user->join_event($_GET['eventId'])){
  //   echo "<p class='bg-success' style='margin: 0;'> &#10003; <strong>Thanks for signing up for $eventName!</strong> <br> We'll send you an updates, so makes sure to check your email!</p>";
  // }
}


if(isset($_GET['leave']) && isset($_GET['eventId'])){
  $eventName = $_GET['join'];
  if($user->leave_event($_GET['eventId'])){
    echo "<p class='bg-success' style='margin: 0;'> &#10003; <strong>Sorry to see you go!</strong></p>";
  }
}


if(isset($_GET['kys'])){
  if($user->get_game_stats()["user_hex"] == $_GET['kys']){
		$database = new Database();
		$query = "update ".$_SESSION["weeklong"]." set status='zombie', status_type='suicide' where user_id=".$_SESSION['id'];
		$data = $database->executeQuery($query);
		if(!isset($data["error"])){
	    echo "<p class='bg-success' style='margin: 0;'> &#10003; <strong>Congratulations, you killed yoself.</strong></p>";
	    echo "\n<script>\n";
	    echo "document.getElementById('logkill_button').parentNode.style.display = 'block';\n";
	    echo "document.getElementById('kys_button').parentNode.style.display = 'none';\n";
	    echo "</script>\n";
		}
  }
}
?>
<section class="lightslide contentwithnav">

 <div class="container">
  <div class="row hide-mobile">

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
  require('components/profile/playerinfo.php');
  if($weeklong->active_event()){
    if($user->is_in_event($_SESSION["weeklong"])){
      include "components/weeklong/player-stats.php";
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
