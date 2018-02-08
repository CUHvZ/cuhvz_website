<section id="profile" class="lightslide">

	<div class="container">

	<div class="row">


		<div class="four columns">
			<div class="section-heading darkgrey">Profile</div>

			<table>
				<tr>
					<td class="subheader deeporange">User name</td>
					<td><?php echo "$row[username]"; ?></td>
				</tr>
				<tr>
					<td class="subheader deeporange">Email</td>
					<td><?php echo "$row[email]"; ?></td>
				</tr>
				<tr>
					<td class="subheader deeporange">User Code</td>
					<td class="subheader"><?php echo "$row[UserHex]"; ?></td>
				</tr>
			</table><BR>
		</div>


		<div class="seven offset-by-one columns">

			<div class="section-heading darkgrey">Player Stats</div>

		</div>
		
		<div class="seven offset-by-one columns darkslide-box">

			<table class="userstats">
				<tr>
					<td class="subheader deeporange">Status</td>
					<td class="subheader deeporange">Kill Count</td>
					<td class="subheader deeporange">Starve Date</td>
				</tr>
				<tr>
					<td class="subheadline"><?php echo "$row[status]"; ?></td>
					<td class="subheadline"><?php echo "$row[KillCount]"; ?></td>
					<td class="subheader"><?php echo "$row[StarveDate]"; ?></td>
				</tr>
			</table> 

			<?php
					/* Success message from logkill.php */
					if ( isset($_GET['success']) && $_GET['success'] == 1 )
					{
					   echo "<div class='bg-success'>Your kill has been registered and starve date(s) have been updated.</div>";
					}
				?>

		</div>

	</div>

  </div>

</section>