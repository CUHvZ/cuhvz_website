<div class="seven offset-by-one columns">

	<div class="section-heading darkgrey">Player Stats</div>

</div>

<div class="seven offset-by-one columns darkslide-box">

	<table class="userstats">
		<?php
		$stats = $user->get_game_stats();
		$event = $weeklong->get_weeklong($_SESSION["weeklong"]);
		echo "<div class='black'>";
        echo "<h3 class='title-link-black' style='margin: 0;'><a href='weeklong/info.php?name=".$event["name"]."'>".$event["title"]."</a></h3>";
        if($weeklong->is_active($event["id"])){ // Displays if event options
              //echo "<h3 style='margin: 0;'>";
              if($user->is_logged_in()){
                    if($user->is_in_event($event["name"])){
                          echo "Wanna leave this event?<h3 style='margin: 0;'>";
                          echo "<a href='/profile.php?leave=".$event["title"]."&eventId=".$event["name"]."'' >Leave event</a>";
                    }else{
                          echo "Wanna play in this event?<h3 style='margin: 0;'>";
                          echo "<a href='/profile.php?join=".$event["title"]."&eventId=".$event["name"]."'' >Join Now!</a>";
                    }
              }else{
                    echo "Wanna play in this event?<h3 style='margin: 0;'>";
                    echo "<a href='/login.php?join=".$event["title"]."&eventId=".$event["name"]."' >Join Now!</a></td>";
              }
                    echo "</h3>";
        }else{
              if($event["active"] == 0){
                     //echo "Event has ended</td>"."\n";
              }else{
                    echo "Event isn't ready yet</td>"."\n";
              }
        }
        echo "<p>".$event["display_dates"]." | ";
        echo "<a href='weeklong/info.php?name=".$event["name"]."' >mission details</a> | ";
        echo "<a href='weeklong/stats.php?name=".$event["name"]."' >stats</a></p>";
        echo "</div>";
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
		if($stats["status"] != "human"){
			$kill_count = $stats["kill_count"];
			$starve_date = $stats["starve_date"];
			echo "
			<tr>
				<td class='subheader deeporange'>Kill Count</td>
				<td class='subheadline'>$kill_count</td>
			</tr>
			<tr>
				<td class='subheader deeporange'>Starve Date</td>
				<td class='subheader'>$starve_date</td>
			</tr>
			";
		}
		?>
	</table>

	<?php
		/* Success message from logkill.php */
		if ( isset($_GET['success']) && $_GET['success'] == 1 )
		{
		   echo "<div class='bg-success'>Your kill has been registered and starve date(s) have been updated.</div>";
		}
		if ( isset($_GET['success']) && $_GET['success'] == 2 )
		{
		   echo "<div class='bg-success'>You have been successfully vaccinated.</div>";
		}

	?>

</div>
