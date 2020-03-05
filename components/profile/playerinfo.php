<div>

	<table>
		<tr>
			<td class="subheader deeporange">User name</td>
			<td><?php echo $_SESSION['username']; ?></td>
		</tr>
		<tr>
			<td class="subheader deeporange">Email</td>
			<td><?php echo $_SESSION['email']; ?></td>
		</tr>
		<?php
			if($_SESSION['subscribed'] == 1){
				echo '<tr>';
					echo '<td class="deeporange"><a href="profile.php?action=unsubscribe">Unsubscribe</a></td>';
				echo '</tr>';
			}else{
				echo '<tr>';
					echo '<td class="deeporange"><a href="profile.php?action=subscribe">Resubscribe</a></td>';
				echo '</tr>';
			}
		?>
	</table><BR>
</div>
