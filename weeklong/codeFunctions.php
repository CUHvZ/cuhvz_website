<?php
function applyEffect($code, $user, $database){
	$weeklongName = $_SESSION["weeklong"];
	$effect = $code["effect"];
	$userID = $user['user_id'];
	$codeID = $code["id"];
	error_log("user: $userID, effect: $effect, code ID: $codeID", 0);
	if(empty($userID))
		return "user id is null";
	if($effect == "supply"){
		if($user["status"] == "human"){
			$hours = 24;
			if($code["val"] != 0)
				$hours = $code["val"];

			$points = 10;
			if($code["point_val"] != 0)
				$points = $code["point_val"];

		}elseif($user["status"] == "zombie"){
			$hours = 6;
			if($code["val"] != 0)
				$hours = $code["val"];

			$points = 5;
			if($code["point_val"] != 0)
				$points = $code["point_val"];

		}else{
			return "You must be alive to collect a supply drop";
		}
		// add hours to starve timer
		$starveDate = (new StarveDate($user["starve_date"]))->addHours($hours);
		$query = "update $weeklongName set starve_date='$starveDate',points=points+$points where user_id=$userID";
		$data = $database->executeQuery($query);
		if(isset($data["error"]))
			return $data["error"];
		$starveTimer = (new StarveDate($starveDate))->getStarveTimer();
		echo "<p class='bg-success' style='margin: 0;'> &#10003; You collected a supply drop! Your earned $points points and added $hours hours to your starve timer.</p>";
	}elseif($effect == "points"){
		$points = $code["point_val"];
		error_log("applying $points to user $userID", 0);
		$query = "update $weeklongName set points=points+$points where user_id=$userID";
		$data = $database->executeQuery($query);
		if(isset($data["error"]))
			return $data["error"];
		echo "<p class='bg-success' style='margin: 0;'> &#10003; You received $points points!</p>";
	}elseif($effect == "feed"){
		$hours = $code["val"];
		error_log("adding $hours to user $userID", 0);
		$starveDate = (new StarveDate($user["starve_date"]))->addHours($hours);
		$query = "update $weeklongName set starve_date='$starveDate' where user_id=$userID";
		$data = $database->executeQuery($query);
		if(isset($data["error"]))
			return $data["error"];
		echo "<p class='bg-success' style='margin: 0;'> &#10003; You've been fed!</p>";
	}else{
		return "effect '$effect' not recognised";
	}
	return null;
}

function checkIsUsed($code, $user, $database){
	$weeklongName = $_SESSION["weeklong"];
	$codeID = $code["id"];
	$userID = $_SESSION['id'];
	$query = "select * from ".$weeklongName."_used_codes where code_id=$codeID AND user_id=$userID";
	$data = $database->executeQueryFetch($query);
	if(!empty($data))
		return "You have already used this code";
	return null;
}

function checkExpiration($code){
	if($code["expiration"]){
		$expiration = new DateTime(date($code["expiration"]));
		$currentTime = new DateTime(date('Y-m-d H:i:s'));
		if($currentTime > $expiration){
			error_log("code has expired", 0);
			return "Code has expired.";
		}
	}
	return null;
}

function updateQuantities($code, $database){
	$weeklongName = $_SESSION["weeklong"];
	$codeID = $code["id"];
	$userID = $_SESSION['id'];
	$query = "update ".$weeklongName."_codes set num_uses=num_uses-1 where id=$codeID";
	$data = $database->executeQuery($query);
	if(!isset($data["error"])){
		$query = "insert into ".$weeklongName."_used_codes (user_id, code_id) values ($userID, $codeID)";
		$data = $database->executeQuery($query);
		if(isset($data["error"]))
			return $data["error"];
	}else{
		return $data["error"];
	}
	return null;
}
?>
