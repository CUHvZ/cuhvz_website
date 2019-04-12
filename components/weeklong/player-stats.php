<div class="seven offset-by-one columns">

	<div class="section-heading darkgrey">Player Stats</div>

</div>

<div class="seven offset-by-one columns darkslide-box">

	<table class="userstats">
		<?php
		$id = $_SESSION['id'];
		$weeklongName = $_SESSION["weeklong"];
		$weeklongTitle = $_SESSION["title"];
		$query = "SELECT $weeklongName.*, users.id FROM $weeklongName INNER JOIN users ON $weeklongName.user_id=users.id where users.id=$id";
		$database = new Database();
		$stats = $database->executeQueryFetch($query);
		// $event = $weeklong->get_weeklong($_SESSION["weeklong"]);
		echo "<div class='black'>";
        echo "<h3 class='title-link-black' style='margin: 0;'><a href='weeklong/info.php?name=$weeklongName'>$weeklongTitle</a></h3>";
        if($weeklong->is_active($weeklongName)){ // Displays if event options
              //echo "<h3 style='margin: 0;'>";
              if($user->is_logged_in()){
                    if($user->is_in_event($weeklong)){
                          // echo "Wanna leave this event?<h3 style='margin: 0;'>";
                          // echo "<a href='/profile.php?leave=".$event["title"]."&eventId=".$event["name"]."'' >Leave event</a>";
                    }else{
                          echo "Wanna play in this event?<h3 style='margin: 0;'>";
                          echo "<a href='/profile.php?join=$weeklongTitle&eventId=$weeklongName'' >Join Now!</a>";
                    }
              }else{
                    echo "Wanna play in this event?<h3 style='margin: 0;'>";
                    echo "<a href='/login.php?join=$weeklongTitle&eventId=$weeklongName' >Join Now!</a></td>";
              }
                    echo "</h3>";
        }else{
              // if($event["active"] == 0){
              //        //echo "Event has ended</td>"."\n";
              // }else{
              //       echo "Event isn't ready yet</td>"."\n";
              // }
        }
        echo "<p>".$_SESSION["weeklong_dates"]." | ";
        echo "<a href='weeklong/info.php?name=$weeklongName' >mission details</a> | ";
        echo "<a href='weeklong/stats.php?name=$weeklongName' >stats</a></p>";
        echo "</div>";

				if($stats["status"] == "human"){
					echo "<div>";
						echo "Getting bored of being a human? <a href='/kys.php' >Join the horde here.</a>";
					echo "</div>";
				}
		?>
		<tr>
			<td class="subheader deeporange">User Code</td>
			<td class="subheadline"><?php echo $stats["user_hex"]; ?></td>
		</tr>
		<tr>
			<td class="subheader deeporange">Status</td>
			<td class="subheadline"><?php echo $stats["status"]; ?></td>
		</tr>
		<?php
		$starve_date = new DateTime(date($stats["starve_date"]));
		$current_time = new DateTime(date('Y-m-d H:i:s'));
		$end_time = new DateTime(date($_SESSION["end_date"]));
		if($current_time > $end_time){
			$current_time = $end_time;
		}
		$time_left = $current_time->diff($starve_date);
		$hours = $time_left->format('%H')+($time_left->format('%a')*24);
		$formatTime = $hours.$time_left->format(':%I:%S');
		$points = $stats["points"];
		echo "<tr>
						<td class='subheader deeporange'>Starve Timer</td>
						<td class='subheadline'>$formatTime</td>
					</tr>";
		echo "<tr>
						<td class='subheader deeporange'>Points</td>
						<td class='subheadline'>$points</td>
					</tr>";
		if($stats["status"] != "human"){
			$kill_count = $stats["kill_count"];
			echo "
			<tr>
				<td class='subheader deeporange'>Kills</td>
				<td class='subheadline'>$kill_count</td>
			</tr>";
		}
		?>
		<div>
			<input class='button-primary' type='submit' name='submit' value='Enter Code' id='submit' onclick="window.location='/entercode.php';">
			<?php
			if($stats["status"] == "zombie"){
				echo "<input class='button-primary' type='submit' name='submit' value='Log Kill' id='submit' onclick=\"window.location='/logkill.php';\">\n";
			}
			?>
		</div>
	</table>

	<?php
		/* Success message from logkill.php */
		// if ( isset($_GET['success']) && $_GET['success'] == 1 )
		// {
		//    echo "<div class='bg-success'>Your kill has been registered and starve date(s) have been updated.</div>";
		// }
		// if ( isset($_GET['success']) && $_GET['success'] == 2 )
		// {
		//    echo "<div class='bg-success'>You have been successfully vaccinated.</div>";
		// }

	?>

</div>
