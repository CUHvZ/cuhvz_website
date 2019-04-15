<!DOCTYPE html>
<html lang="en">
<?php
require('includes/config.php');
$title = 'CU HvZ | KYS';
?>
<head>
	<?php require('layout/header.php'); ?>
	<script>
	function confirmKYS(e){
	    if(!confirm('Are you sure you want give yourself up and join the horde?'))e.preventDefault();
	}
	</script>
</head>
<body>
<?php
include 'layout/navbar.php';

// if not logged in redirect to login page
if(!$user->is_logged_in()){
  header('Location: login.php');
}
// check if:
// 1. weeklong is active
// 2. user is in weeklong
// 3. user is a human
if(!$weeklong->active_event() || !$user->is_in_event($_SESSION["weeklong"]) || $user->get_game_stats()["status"] != "human"){
  header('Location: profile.php');
}
// ---------------------------
// if submitted then kill user
// ---------------------------
if(isset($_POST["submit"])){
	$database = new Database();
	$now = (new DateTime(date('Y-m-d H:i:s')))->format('Y-m-d H:i:s');
	$query = "update ".$_SESSION["weeklong"]." set status='zombie', status_type='suicide', starve_date=('$now' + INTERVAL 2 DAY) where user_id=".$_SESSION['id'];
	$data = $database->executeQuery($query);
	if(!isset($data["error"])){
    echo "<p class='bg-success' style='margin: 0;'> &#10003; <strong>Congratulations, you killed yoself.</strong></p>";
	}else{
		echo "<p class='bg-danger'> Something went wrong tring to join the horde.</p>";
	}
}

?>

<section class="darkslide" id="logkill">
  <div class="container">
  <div class="row">
    <div class="twelve columns">
      <div class="subheadline orange">Are you sure you want give yourself up and join the horde?</div><br>
       <form action='' method='post' id='user_code'>
        <input class="button-primary" type="submit" name="submit" value="Join The Horde" id="submit" onclick="confirmKYS(event)">
      </form>
    </div>
  </div>
</div>
</section>

<?php
// insert clock

if(Weeklong::active_event()){
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
