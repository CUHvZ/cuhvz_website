<?php
$date = "";
$activeLevel = $weeklong->active_event();
$stateDisplay = "";
if($activeLevel == 1){
	$activeLevel = "level 1";
	$stateDisplay = "Game Begins In...";
	$date = $_SESSION["start_date"];
	include "weeklong/countdown.php";
}else if ($activeLevel == 2){
	$activeLevel = "level 2";
	$stateDisplay = "Gametime Remaining";
	$date = $_SESSION["end_date"];
	include "weeklong/countdown.php";
}else{
	$activeLevel = "not 1 or 2";
	include "countdown.php";
}
?>
<script>
console.log(<?= "\"ActiveLevel: ".$activeLevel."\"" ?>);
var stateDisplay = document.getElementById("game_state");
stateDisplay.innerHTML = <?= "\"".$stateDisplay."\"" ?>;
var date = <?= "\"".$date."\"" ?>;
console.log();
initializeClock('clockdiv', date);
</script>
