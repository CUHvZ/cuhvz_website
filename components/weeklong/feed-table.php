<?php

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
    }else{
			error_log("Updated starve timer for user: $zombieID", 0);
		}
  }


  // ---------------------------
  // Handle submit
  // ---------------------------
  if (isset($_POST['check_list'])){
  	$error = null;
    $zombieFeedto = null;
    if(isset($_POST['check_list']))
		  $zombieFeedto = $_POST['check_list'];
    error_log("feed to: ".implode("','", array_map('trim', $zombieFeedto)), 0);

    foreach($zombieFeedto as $zombieID){
      feedZombie($database, $zombieID);
    }
		header("Location: profile.php?kill=success");
	}
?>

	<h2 class='subheader white'>Select up to two zombies to feed:</h2>
	<p>Note: Feeding a zombie gives them 12 more hours. Maximum starve time is 48 hours</p>

	<div id='playerlist' class='playerlist' data-max-answers='2' style="overflow: visible;">

    <table class="stats-row feed-table">
      <thead>
        <tr class='add-line'>
          <th class="table-row">
            <div class="table-row">
                <span class="table-cell-username" onclick="sortTable('feed-table', 'username', 5)">Username</span>
                <!-- <br class="hide-mobile"> -->
                <span class="table-cell-number" onclick="sortTable('feed-table', 'kills', 5)">Kills</span>
                <span class="table-cell-number" onclick="sortTable('feed-table', 'points', 5)">Points</span>
                <span class="table-cell-number" onclick="sortTable('feed-table', 'starve', 5)">Hunger</span>
            </div>
          </th>
        </tr>
      </thead>
			<tbody id="feed-table">
				<?php
				  $userID = $_SESSION['id'];
				  $weeklongName = $_SESSION["weeklong"];
					$database = new Database();
					$query = "SELECT user_id, username, kill_count, starve_date, points FROM $weeklongName
					WHERE status='zombie' AND user_id!=$userID ORDER BY starve_date;";
					$data = $database->executeQueryFetchAll($query);
	        $eventStartDateString = $database->executeQueryFetch("select start_date from weeklongs where name='$weeklongName'")["start_date"];
					foreach($data as $zombie){
	          $starveTimer = (new StarveDate($zombie["starve_date"]))->getStarveTimer($eventStartDateString);
	          $points = $zombie["points"];
	          if($points == null){
	            $points = 0;
	          }
	          $kills = $zombie["kill_count"];
	          if($kills == null){
	            $kills = 0;
	          }
	          $username = $zombie["username"];
	          $zombieID = $zombie["user_id"];
	          $checkBox = "<input class='select' type='checkbox' name='check_list[]' value='$zombieID'/>";
	          echo "<tr class='add-line'>"."\n";
	            echo "<td class='table-row'";
	              echo "<div class='table-row'>";
	                echo "<span id='username' class='table-cell-username'>$checkBox $username</span>"."\n";
	                echo "<span id='kills' class='table-cell-number'>$kills</span>"."\n";
	                echo "<span id='points' class='table-cell-number'>$points</span>"."\n";
	                echo "<span class='red table-cell-number' id='starve'>$starveTimer</span>"."\n";
	              echo "</div>";
	            echo "</td>";
	          echo "</tr>"."\n";
					}
				?>
			</tbody>
		</table>
		<div class="outer-div">
		  <div class="inner-div">
		    <ul class="pagination pagination-lg pager" id="feed-table-pager"></ul>
		  </div>
		</div>
	</div>
