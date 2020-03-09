<?php
function applyEffect($code, $user, $database){
	$weeklongName = $_SESSION["weeklong"];
	$effect = $code["effect"];
	$sideEffect = $code["side_effect"];
	$userID = $user['user_id'];
	$userStatusType = $user['status_type'];
  $userStatus = $user["status"];
	$codeID = $code["id"];
	error_log("user: $userID, effect: $effect, side effect: $sideEffect, code ID: $codeID", 0);
	if(empty($userID))
		return "user id is null";
	if($effect == "supply"){
		if($userStatus == "human"){
			// ---------------------
			// Human Supply Drop
			// ---------------------

      // Default supply hours
			$hours = 24;
			if($code["val"] != 0)
				$hours = $code["val"];
      // Default points
			$points = 10;
      if($code["point_val"] != 0)
				$points = $code["point_val"];

			// add hours to starve timer
	    if($userStatusType == "poisoned"){
	      $hours = round($hours/2);
	      $points = round($points/2);
	    }
	    $starveDate = (new StarveDate($user["starve_date"]))->addHours($hours);
			$query = "update $weeklongName set starve_date='$starveDate',points=points+$points where user_id=$userID";
			$data = $database->executeQuery($query);
			if(isset($data["error"]))
				return $data["error"];
			$starveTimer = (new StarveDate($starveDate))->getStarveTimer();

			if($userStatusType == "poisoned" || $sideEffect == "poisoned"){
				// Default poison counter
		    $poisonCounter = 3;
				// Update poison counter
	      $statusData = json_decode($user['status_data'], true);
	      // Default number of supply drop until cure
	      if(isset($statusData["poisonCounter"]))
	        $poisonCounter = $statusData["poisonCounter"] - 1;
	      $newStatusType = "poisoned";
	      $statusData["poisonCounter"] = $poisonCounter;
	      if($poisonCounter <= 0){
	        unset($statusData["poisonCounter"]);
	        $newStatusType = "human";
	      }
	      $statusData = json_encode($statusData);
	      $query = "update $weeklongName set status_type='$newStatusType',status_data='$statusData' where user_id=$userID";
	      $database->executeQuery($query);
			}

	    if($sideEffect != "poisoned"){
	      echo "<p class='bg-success' style='margin: 0;'> &#10003; You collected a supply drop! You've earned $points points and added $hours hours to your starve timer. Your new starve timer is $starveTimer</p>";
	      if($userStatusType == "poisoned"){
	        if($poisonCounter <= 0){
	          echo "<p class='bg-success' style='margin: 0;'> &#10003; You've <strong>cured your poison</strong>! This supply drop was only half effective but your future supply drops will be fully effective!</p>";
	        }else{
	          echo "<p class='bg-warning' style='margin: 0;'>You're poisoned, this supply drop was only half effective. You need to collect $poisonCounter more to be cured.</p>";
	        }
	      }
	    }else{
	      echo "<p class='bg-warning' style='margin: 0;'> &#10003; You collected a <strong>poisoned</strong> supply drop! You've earned $points points and added $hours hours to your starve timer. Your new starve timer is $starveTimer</p>";
	      echo "<p class='bg-warning' style='margin: 0;'>Supply drops will be half effective until 3 unpoisoned supply drops have been collected.</p>";
	    }

		}elseif($userStatus == "zombie"){
			// ---------------------
			// Zombie Supply Drop
			// ---------------------
			// return "Error: You're a zombie, you can't collect supply drops.";
      // Default supply hours
			$hours = 6;
			if($code["val"] != 0)
				$hours = $code["val"];
      // Default points
			$points = 2;
			if($code["point_val"] != 0)
				$points = $code["point_val"];

			$starveDate = (new StarveDate($user["starve_date"]))->addHours($hours);
			$query = "update $weeklongName set starve_date='$starveDate',points=points+$points where user_id=$userID";
			$data = $database->executeQuery($query);
			if(isset($data["error"]))
				return $data["error"];
			$starveTimer = (new StarveDate($starveDate))->getStarveTimer();

			echo "<p class='bg-success' style='margin: 0;'> &#10003; You stolen a supply drop! You've earned $points points and added $hours hours to your starve timer. Your new starve timer is $starveTimer</p>";
		}else{
			return "You must be alive to collect a supply drop";
		}
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
		$starveTimer = (new StarveDate($starveDate))->getStarveTimer();
		if(isset($data["error"]))
			return $data["error"];
		echo "<p class='bg-success' style='margin: 0;'> &#10003; You've been fed $hours hours. Your new starve timer is $starveTimer!</p>";
	}elseif($effect == "mission"){
		$points = $code["point_val"];
		$hours = $code["val"];
		error_log("applying $points and adding $hours to user $userID", 0);
		$starveDate = (new StarveDate($user["starve_date"]))->addHours($hours);
		$query = "update $weeklongName set starve_date='$starveDate',points=points+$points where user_id=$userID";
		$data = $database->executeQuery($query);
		$starveTimer = (new StarveDate($starveDate))->getStarveTimer();
		if(isset($data["error"]))
			return $data["error"];
		echo "<p class='bg-success' style='margin: 0;'> &#10003; You've been fed $hours hours and earned $points points. Your new starve timer is $starveTimer!</p>";
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
