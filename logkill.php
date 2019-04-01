<!DOCTYPE html>
<html lang="en">
<?php
require('includes/config.php');
$title = 'CU HvZ | Log Kill';
?>
<head>
	<?php require('layout/header.php'); ?>
</head>
<body>
	<?php
		include 'layout/navbar.php';
	?>

<?php
// if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
$status = $user->get_game_stats()["status"];
if($status != "zombie"){ header('Location: login.php'); }
?>

<?php

function convertVictim($db, $victimID){
	$weeklongName = $_SESSION["weeklong"];
	$query = "UPDATE $weeklongName SET status='zombie', status_type='normal' WHERE user_id=$victimID;";
	$db->executeQuery($query);
}

function addKill($db, $killerID){
	$weeklongName = $_SESSION["weeklong"];
	$query = "select * from $weeklongName where user_id=$killerID";
	$user = $db->executeQueryFetch($query);

	$starveDate = new DateTime($user["starve_date"]);
	$newStarveDate = date_add($starveDate, date_interval_create_from_date_string('24 hours'));

	$currentTime = new DateTime(date('Y-m-d H:i:s'));
	$maxStarveDate = date_add($currentTime, date_interval_create_from_date_string('48 hours'));
	if($maxStarveDate < $newStarveDate){
		$newStarveDate = $maxStarveDate;
	}
	$newStarveDate = $newStarveDate->format('Y-m-d H:i:s');

	$query = "update $weeklongName set kill_count=kill_count+1, starve_date='$newStarveDate' where user_id=$killerID";
	$error = $db->executeQuery($query);
	if(isset($error["error"])){
		error_log("Did not update zombie", 0);
	}
}

function feedZombie($db, $zombieID){
	$weeklongName = $_SESSION["weeklong"];
	$query = "select * from $weeklongName where user_id=$zombieID";
	$user = $db->executeQueryFetch($query);

	$starveDate = new DateTime($user["starve_date"]);
	$newStarveDate = date_add($starveDate, date_interval_create_from_date_string('12 hours'));
	$currentTime = new DateTime(date('Y-m-d H:i:s'));
	$maxStarveDate = date_add($currentTime, date_interval_create_from_date_string('48 hours'));
	if($maxStarveDate < $newStarveDate){
		$newStarveDate = $maxStarveDate;
	}
	$newStarveDate = $newStarveDate->format('Y-m-d H:i:s');
	$query = "update $weeklongName set starve_date='$newStarveDate' where user_id=$zombieID";
	$error = $db->executeQuery($query);
	if(isset($error["error"])){
		error_log("Did not update fed zombie timer", 0);
	}
}

if (isset($_POST['hex'])){
  $hex = strtolower($_POST['hex']);
  $zombieFeedto = null;
	if(isset($_POST['check_list']))
		$zombieFeedto = $_POST['check_list'];

	error_log("victim hex: $hex", 0);
	error_log("feed to: ".implode("','", array_map('trim', $zombieFeedto)), 0);

	$weeklongName = $_SESSION["weeklong"];

	$database = new Database();
	$query = "select * from $weeklongName where user_hex='$hex'";
	$victim = $database->executeQueryFetch($query);
	if(isset($victim["user_id"])){
		$isZombie = $victim["status"] == "zombie";
		$isSuicide = $victim["status_type"] == "suicide";
		error_log("user status: $isZombie is suicide: $isSuicide", 0);
		// make sure victim is valid kill to register
		if(!$isZombie || ($isZombie && $isSuicide)){
			convertVictim($database, $victim["user_id"]);
			addKill($database, $_SESSION['id']);
			foreach ($zombieFeedto as $zombieID) {
				feedZombie($database, $zombieID);
			}
			header("Location: profile.php?success=1#profile");
		}else{
			error_log("User is already a zombie", 0);
			$error = "User has already been zombified.";
		}
		$query = "UPDATE $weeklongName SET status=:status_change WHERE username=:victim;";
	}else{
		error_log("user does not exist", 0);
		$error = "Not a valid code.";
	}


	if(isset($error)){
		echo "<p class='bg-danger'>$error</p>";
	}
}
?>

<!-- BEGIN DOCUMENT -->

<!-- HVZ HEADLINE SECTION -->

<section class="lightslide contentwithnav">

 <div class="container">
  <div class="row">

    <!-- Start HVZ Headline Columns -->

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
      <span class="deeporange">&#10006; &#10006; &#10006;</span>
      <!-- Welcome user -->
      Welcome, <?php echo $_SESSION['username']; ?>.
      <!-- Logout Option -->
      <a class="grey" href='logout.php'>(Logout)</a>
      <!-- XXX decoration, temporary -->
      <span class="deeporange">&#10006; &#10006; &#10006;</span>
      </p>

    </div>

    <!-- End headline columns -->

  </div> <!-- end row -->

  </div> <!-- end container -->

</section>

<!-- END HVZ HEADLINE SECTION -->

<!-- START KILLHUMAN.PHP -->

<?php

$zombieFeeder = $_SESSION['username'];

?>

<!-- END KILLHUMAN.PHP -->


<!-- FEED ZOMBIE SELECTION TABLE -->

<section class="darkslide" id="logkill">
<div class="container">
<div class="row">
<div class="twelve columns">

<div class="subheadline orange">So you killed a human? Bravo.</div><br>


<form action='#' method='post' id='feedzombie'>
	<div class='subheader white'>Input Victim User code:</div> <input type='text' name='hex' required>

	<BR><BR>

	<h2 class='subheader white'>Select up to two zombies to feed:</h2>
	<p>Note: Maximum starve time is 48 hours</p>

	<div id='playerlist' class='playerlist' data-max-answers='2'>

		<table id='table1' class='feedzombiestable'>
			<tr class='subheader orange'>
				<th class='select'>Select</th>
				<th>Username</th>
				<th>Kill Count</th>
				<th class='starve'>Time Remaining Unil Death</th>
			</tr>
			<?php
				$database = new Database();
				$query = "SELECT user_id, username, kill_count, starve_date FROM ".$_SESSION['weeklong']."
				WHERE status='zombie' AND user_id!=".$_SESSION['id']." ORDER BY starve_date;";
				$data = $database->executeQueryFetchAll($query);
				foreach($data as $row){
		      echo "<tr class='subheader white'>";
			      echo "<td class='select'>";
			      echo "<input type='checkbox' name='check_list[]' value='$row[user_id]'>";
			      echo "<td align='center'>".$row["username"]."</td>";
			      echo "<td align='center'>".$row["kill_count"]."</td>";
				    $current_time = new DateTime(date('Y-m-d H:i:s'));
				    $starve_date = new DateTime(date($row["starve_date"]));
				    $time_left = $current_time->diff($starve_date);
				    $hours = $time_left->format('%H')+($time_left->format('%a')*24);
				    echo " <td class='red' align='center'>".$hours.$time_left->format(':%I:%S')."</td>";
			    echo " </tr>";
				}

			?>
		</table>
	</div>
	<input class="button-primary" type="submit" name="submit" value="Register Kill and Feed" id="submit">
</form>


<BR><BR>


</div>
</div>
</section>
<!-- END TEST TABLE #2 -->
  <script src="js/sort.js"></script>

</body>

</html>
