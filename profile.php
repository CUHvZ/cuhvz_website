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


if(isset($_GET['joinEvent'])){
	error_log("join event", 0);
	if(!$user->is_in_event($_SESSION["weeklong"])){
		$database = new Database();
	  $weeklongID = $_GET['joinEvent'];
		$query = "select title, name from weeklongs where id=$weeklongID";
		$data = $database->executeQueryFetch($query);
		$weeklongName = null;
		$weeklongTitle = null;
		if(!isset($data["error"])){
			$weeklongName = $data["name"];
			$weeklongTitle = $data["title"];
		}
		if($weeklongName != null){
			$user_hex = substr(md5(uniqid(rand(),'')),0,5);

			$query = "select user_hex from $weeklongName";
			$data = $database->executeQueryFetchAll($query);
			$takenHexes = [];
			foreach($data as $row){
				array_push($takenHexes, $row[0]);
			}
			while(in_array($user_hex, $takenHexes)){
				$user_hex = substr(md5(uniqid(rand(),'')),0,5);
			}

			$username = $_SESSION['username'];
			$userID = $_SESSION['id'];


			$now = (new DateTime(date('Y-m-d H:i:s')))->format('Y-m-d H:i:s');
			$status = "human";
			if(isset($_GET['late']) && $_GET['late']=="zombie"){
				$status = "zombie";
			}
			$query = "INSERT INTO $weeklongName (user_id,username, user_hex, status, status_type, starve_date) VALUES ($userID, '$username', '$user_hex', '$status', 'normal', ('$now' + INTERVAL 2 DAY))";

			$error = $database->executeQuery($query);
			if(!isset($error["error"])){
				echo "<p class='bg-success' style='margin: 0;'> &#10003; <strong>Thanks for signing up for $weeklongTitle!</strong> <br> We'll send you daily updates, so makes sure to check your email and checkout the website!</p>";
			}else{
				echo "<p class='bg-danger' style='margin: 0;'> &#10003; <strong>Something went wrong tring to sign up for $weeklongTitle!</strong> <br> Try logging out and logging back in. Contact the mod team if this problem continues.</p>";
			}
		}
	}
}

if(isset($_GET['kill'])){
  if($_GET['kill'] == "success"){
    echo "<p class='bg-success' style='margin: 0;'>Nice kill</p>";
  }
}


// if(isset($_GET['leave']) && isset($_GET['eventId'])){
//   $eventName = $_GET['join'];
//   if($user->leave_event($_GET['eventId'])){
//     echo "<p class='bg-success' style='margin: 0;'> &#10003; <strong>Sorry to see you go!</strong></p>";
//   }
// }
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
  if(Weeklong::active_event()){
    if($user->is_in_event($_SESSION["weeklong"])){
      include "components/weeklong/player-stats.php";
      echo "\n<script>\n";
      if($user->get_game_stats()["status"] == "human"){
        // echo "document.getElementById('kys_button').parentNode.style.display = 'block';\n";
        // echo "document.getElementById('logkill_button').parentNode.style.display = 'none';\n";
      }else{
        // echo "document.getElementById('logkill_button').parentNode.style.display = 'block';\n";
        // echo "document.getElementById('kys_button').parentNode.style.display = 'none';\n";
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

if(Weeklong::active_event()){
  require('weeklong/clock.php');
}
?>


<?php
//include header template
require('layout/footer.php');
?>

</body>
</html>
