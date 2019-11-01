<div class="seven offset-by-one columns">

	<div class="section-heading darkgrey">Player Stats</div>

</div>

<div class="seven offset-by-one columns darkslide-box">

	<table class="userstats">
		<?php
		$id = $_SESSION['id'];
		$weeklongName = $_SESSION["weeklong"];
		$weeklongTitle = $_SESSION["title"];
		$weeklongID = $_SESSION["weeklong_id"];
		$query = "SELECT $weeklongName.*, users.id FROM $weeklongName INNER JOIN users ON $weeklongName.user_id=users.id where users.id=$id";
		$database = new Database();
		$stats = $database->executeQueryFetch($query);
		// $event = $weeklong->get_weeklong($_SESSION["weeklong"]);
		echo "<div class='black'>";
        echo "<h3 class='title-link-black' style='margin: 0;'><a href='weeklong/info.php?id=$weeklongID'>$weeklongTitle</a></h3>";
        if($weeklong->is_active($weeklongName)){ // Displays if event options
              //echo "<h3 style='margin: 0;'>";
              if($user->is_logged_in()){
                    if($user->is_in_event($weeklong)){
                          // echo "Wanna leave this event?<h3 style='margin: 0;'>";
                          // echo "<a href='/profile.php?leave=".$event["title"]."&eventId=".$event["name"]."'' >Leave event</a>";
                    }else{
                          echo "Wanna play in this event?<h3 style='margin: 0;'>";
                          echo "<a href='/profile.php?joinEvent=$weeklongID' >Join Now!</a>";
                    }
              }else{
                    echo "Wanna play in this event?<h3 style='margin: 0;'>";
                    echo "<a href='/login.php?joinEvent=$weeklongID' >Join Now!</a></td>";
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
        echo "<a href='weeklong/info.php?id=$weeklongID' >mission details</a> | ";
        echo "<a href='weeklong/stats.php?id=$weeklongID' >stats</a></p>";
        echo "</div>";

				if($stats["status"] == "human" && $_SESSION["started"]){
					echo "<div>";
						echo "Getting bored of being a human? <a href='/kys.php' >Join the horde here.</a>";
					echo "</div>";
				}
				if(!$_SESSION["started"] && $stats["status"] != "zombie"){
					echo "<div>";
						echo "Want to start out a zombie? You get 50 bonus starting points if you do.";
						echo "<input class='button-primary' type='submit' name='oz' value='Become an Original Zombie' id='submit' onclick=\"window.location='/oz.php';\">\n";
					echo "</div>";
				}
		?>
		<tr>
			<td class="subheader deeporange">User Code</td>
			<td class="subheadline"><?php echo $stats["user_hex"]; ?></td>
		</tr>
		<tr>
			<td class="subheader deeporange">Status</td>
			<td class="subheadline">
				<?php
					echo $stats["status"];
					if($stats["status"] == "zombie")
						echo " (".$stats["status_type"].")";
				?>
			</td>
		</tr>
		<?php
		$eventStartDateString = $database->executeQueryFetch("select start_date from weeklongs where name='$weeklongName'")["start_date"];
		$starveTimer = (new StarveDate($stats["starve_date"]))->getStarveTimer($eventStartDateString);
		$points = $stats["points"];
		echo "<tr>
						<td class='subheader deeporange'>Starve Timer</td>
						<td class='subheadline'>$starveTimer</td>
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
