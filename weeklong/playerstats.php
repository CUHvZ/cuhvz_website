<div class="seven offset-by-one columns">

	<div class="section-heading darkgrey">Player Stats</div>

</div>

<div class="seven offset-by-one columns darkslide-box">

	<table class="userstats">
		<?php
		$stats = $user->get_game_stats();
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