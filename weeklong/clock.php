<?php 
$date = date('Y-m-d H:i:s');
$start = strtotime($_SESSION["start_date"]);
if($start > $date){
	include "game_start_clock.php";
}
else if($start > strtotime($_SESSION["end_date"])){
	include "countdown.php";
}
else{
	// add code to display that the game has ended
}

?>