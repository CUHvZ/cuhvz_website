<div class="container">
  <?php include $_SERVER['DOCUMENT_ROOT']."/components/admin/functions/create_code.php"; ?>
	<div class="row">
		<form role="form" method="post" action="" autocomplete="off">

			<div class="row">
				<div class="two columns">
					<label>Effect</label><br />
					<select name="code_type">
						<option value="supply">supply</option>
						<option value="points">points</option>
						<option value="feed">feed</option>
						<option value="mission">mission</option>
						<!-- <option value="revive">revive</option> -->
					</select>
				</div>
				<div class="two columns">
					<label>Side Effect</label><br />
					<select name="side_effect">
						<option value="">None</option>
						<option value="poisoned">Poisoned</option>
					</select>
				</div>
				<div class="two columns">
					<label>Value</label><br />
					<input name="val" class="function-input input-lg u-full-width" type="number" placeholder="0" min=0>
				</div>
				<div class="two columns">
					<label>Point Value</label><br />
					<input name="point_val" class="function-input input-lg u-full-width" type="number" min=0 placeholder="10" autocomplete="off">
				</div>
			</div>

			<div class="row">
				<div class="three columns">
					<label>Name</label>
					<input name="name" class="function-input input-lg u-full-width" placeholder="NULL" autocomplete="off">
				</div>
				<div class="three columns">
					<label>Hex</label>
					<input name="hex" class="function-input u-full-width input-lg" placeholder="Blank for random" autocomplete="off">
				</div>

				<div class="three columns">
					<label>Location</label>
					<input name="location" class="function-input u-full-width input-lg" autocomplete="off">
				</div>
			</div>

			<div class="row">
				<div class="three columns">
					<label>Number of uses</label>
					<input name="num_uses" class="function-input input-lg u-full-width" placeholder="1" type="number" autocomplete="off">
				</div>

				<div class="three columns">
					<label>Expiration</label><br />
					<input class="date" name="expiration" placeholder="Default midnight" type="text" autocomplete="off"/><br />
					<input type='checkbox' name='expire_at_5'>Check for 5pm</input>
				</div>
			</div>

			<div class="row">
				<div class="three columns">
					<input type="submit" name="submit" value="Create Code" class="btn btn-primary btn-block btn-lg button-primary">
				</div>
			</div>
		</form>
	</div>
</div>
