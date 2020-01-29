<!DOCTYPE html>
<html lang="en">
<?php
require('includes/config.php');
$title = 'CU HvZ | Log Kill';
// ---------------------------
// Helper functions
// ---------------------------
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

	$query = "update $weeklongName set kill_count=kill_count+1, starve_date='$newStarveDate', points=points+10 where user_id=$killerID";
	$error = $db->executeQuery($query);
	if(isset($error["error"])){
		error_log("Did not update zombie", 0);
	}
}
?>
<head>
	<?php require('layout/header.php'); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="/js/paginate.js"></script>
	<script src="/js/sort_v2.js"></script>
  <script>
	  $(document).ready(function(){
			var settings = {
				pagerSelector:'#feed-table-pager',
				showPrevNext:true,
				hidePageNumbers:false,
				perPage: 5
			};
	  	$('#feed-table').pageMe(settings);
			settings["pagerSelector"] = '#feed-table-pager';
	  });
  </script>
</head>
<body>
	<?php
		include 'layout/navbar.php';
		// if not logged in redirect to login page
		if(!$user->is_logged_in()){ header('Location: login.php'); }
		$status = $user->get_game_stats()["status"];
		if($status != "zombie"){ header('Location: login.php'); }
	?>

	<?php
	// ---------------------------
	// Handle submit
	// ---------------------------
	if (isset($_POST['hex'])){
		$error = null;
	  $hex = strtolower($_POST['hex']);

		$weeklongName = $_SESSION["weeklong"];

		$database = new Database();
		$query = "select * from $weeklongName where user_hex='$hex'";
		$victim = $database->executeQueryFetch($query);
		$userID = $_SESSION["id"];
		$userPlayer = $database->executeQueryFetch("select * from $weeklongName where user_id=$userID");
		if(isset($userPlayer["user_id"])){
			if($hex == $userPlayer["user_hex"]){
				$error = "You can't zombify yourself.";
			}
		}
		if($error == null && isset($victim["user_id"])){
			$isZombie = $victim["status"] == "zombie";
			// make sure victim is valid kill to register
			if(!$isZombie){
				convertVictim($database, $victim["user_id"]);
				addKill($database, $_SESSION['id']);
			}else{
				error_log("User is already a zombie", 0);
				$error = "User has already been zombified.";
			}
		}else{
			error_log("user does not exist", 0);
			$error = "Not a valid code.";
		}
	}
	// ---------------------------
	// Handle errors
	// ---------------------------
	if(isset($error)){
		echo "<p class='bg-danger'>$error</p>";
	}
	?>

	<section class="darkslide" id="logkill">
		<div class="container">
			<div class="row">
				<div class="twelve columns">
					<div class="subheadline orange">
						So you killed a human? Bravo.
					</div>
					<form action='#' method='post' id='feedzombie' autocomplete="off">
						<div class='subheader white'>Input Victim User code:
							<br/>
							<input type='text' name='hex' autocomplete="off" required>
							<?php include 'components/weeklong/feed-table.php'; ?>
							<input class="button-primary" type="submit" name="submit" value="Register Kill and Feed" id="submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
