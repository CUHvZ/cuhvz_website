<?php
$date = "";
$activeLevel = Weeklong::active_event();
$stateDisplay = "";
if(Weeklong::active_event()){
	if(!$_SESSION["started"]){
		$stateDisplay = "Game Begins In...";
		$date = $_SESSION["start_date"];
	}else{
		$stateDisplay = "Gametime Remaining";
		$date = $_SESSION["end_date"];
	}
	include "countdown.php";
}
?>
<!-- <script type="text/javascript" src="jquery-1.4.3.min.js"></script> -->

<script type="text/javascript">
  $(document).ready( function() {
		// var stateDisplay = document.getElementById("game_state");
		// stateDisplay.innerHTML = <?= "\"".$stateDisplay."\"" ?>;
		$('#game_state').html(<?= "\"".$stateDisplay."\"" ?>);
		var date = <?= "\"".$date."\"" ?>;
		initializeClock('clockdiv', date);

		<?php
		$weeklong_name = $_SESSION['weeklong'];
		$database = new Database();
		$countusers = $database->executeQueryCount("SELECT count(*) FROM $weeklong_name");
		// $countusers = $db->query("SELECT count(*) FROM $weeklong_name")->fetchColumn();
		?>
		var count = <?= "\"".$countusers."\"" ?>;
		// var playersRegistered = document.getElementById("registered");
		// playersRegistered.innerHTML = count + "  Players Registered";
		$('#registered').html(count + "  Players Registered");
  } );

</script>
