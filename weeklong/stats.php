<!DOCTYPE html>
<html lang="en">
<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
$title = 'CU HvZ | ';
?>
<head>
	<?php require($_SERVER['DOCUMENT_ROOT'].'/layout/header.php'); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="/js/paginate.js"></script>
	<script src="/js/sort_v2.js"></script>
  <script>

  $(document).ready(function(){

		var settings = {
			pagerSelector:'#human-table-pager',
			showPrevNext:true,
			hidePageNumbers:false,
			perPage:15
		};
  	$('#human-table').pageMe(settings);
		settings["pagerSelector"] = '#human-table-mobile-pager';
  	$('#human-table-mobile').pageMe(settings);
		settings["pagerSelector"] = '#zombie-table-pager';
  	$('#zombie-table').pageMe(settings);
		settings["pagerSelector"] = '#zombie-table-mobile-pager';
  	$('#zombie-table-mobile').pageMe(settings);
		settings["pagerSelector"] = '#deceased-table-pager';
  	$('#deceased-table').pageMe(settings);
		settings["pagerSelector"] = '#deceased-table-mobile-pager';
  	$('#deceased-table-mobile').pageMe(settings);

		settings["pagerSelector"] = '#all-players-table-pager';
  	$('#all-players-table').pageMe(settings);
		settings["pagerSelector"] = '#all-players-table-mobile-pager';
  	$('#all-players-table-mobile').pageMe(settings);
  });
  </script>

</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/layout/navbar.php'; ?>

<div class="lightslide">

  <div class="player_container">

    <div class="content lightslide-list" style="overflow: auto;">
      <div class="stats-header orange">Player Statistics</div>
				<?php
          $displayStats = false;
					if(isset($_GET["name"])){
						$name = $_GET["name"];
						echo "<div class='stats-header'>";
						echo "Zombie Stun Timer: ";
						$query = "select stun_timer from weeklongs where name='$name'";
						$database = new Database();
						$data = $database->executeQueryFetch($query);
						if(!isset($data["error"])){
							$date = new DateTime(date('H:i:s', strtotime($data["stun_timer"])));
							echo $date->format('i\m s\s');
						}

						echo "</div>";
						echo "<div>";
            if($weeklong->get_weeklong($name)){
              $displayStats = true;
							$query = "select count(*) as num_players, count(CASE WHEN status='human' THEN status END) as num_humans, count(CASE WHEN status='zombie' THEN status END) as num_zombies, count(CASE WHEN status='deceased' THEN status END) as num_dead from $name;";
							$data = $database->executeQueryFetch($query);
							$numPlayers = $data["num_players"];
							$numHumans = $data["num_humans"];
							$numZombies = $data["num_zombies"];
							$numDead = $data["num_dead"];
							if($numPlayers == 0)
								$numPlayers = "0";
							if($numHumans == 0)
								$numHumans = "0";
							if($numZombies == 0)
								$numZombies = "0";
							if($numDead == 0)
								$numDead = "0";
              // echo "<p class='status-header'>";
              // echo "Humans: ".sizeof($weeklong->get_humans_from($name));
              // echo " &emsp; Zombies: ".sizeof($weeklong->get_zombies_from($name));
              // echo " &emsp; Deceased: ".sizeof($weeklong->get_deceased_from($name));
              // echo "</p>";
            }
          }
        ?>
				<div id="Top" style="display: block;">
          <h3 class="row-header">Top players</h3>
            <?php
						// make so angel never shows up
              include $_SERVER['DOCUMENT_ROOT']."/components/weeklong/top-players-table.php";
            ?>
        </div>
        <div style="margin: auto; text-align: center;">
          <span class="tab">
            <button class="tablink active" onclick="openTab(event, 'All')">All: <?php echo $numPlayers; ?></button>
            <button class="tablink" onclick="openTab(event, 'Humans')">Humans: <?php echo $numHumans; ?></button>
          </span>
          <span class="tab">
						<button class="tablink" onclick="openTab(event, 'Zombies')">Zombies: <?php echo $numZombies; ?></button>
            <button class="tablink" onclick="openTab(event, 'Deceased')">Dead: <?php echo $numDead; ?></button>
            <!-- <button class="tablink" onclick="openTab(event, 'Activity')">Activity</button> -->
          </span>
        </div>
				<div id="tab-container">
					<div id="All" class="tabcontent" style="display: block;">
	          <h3 class="row-header">All</h3>
	            <?php
	              include $_SERVER['DOCUMENT_ROOT']."/components/weeklong/all-players-table.php";
	            ?>
	        </div>

	        <div id="Humans" class="tabcontent">
	          <h3 class="row-header">Humans</h3>
	            <?php
	              include $_SERVER['DOCUMENT_ROOT']."/components/weeklong/human-table.php";
	            ?>
	        </div>

	        <div id="Zombies" class="tabcontent">
	          <h3 class="row-header">Zombies</h3>
						<?php
							include $_SERVER['DOCUMENT_ROOT']."/components/weeklong/zombie-table.php";
						?>
	        </div>

	        <div id="Deceased" class="tabcontent">
	          <h3 class="row-header">Dead</h3>
						<?php
							include $_SERVER['DOCUMENT_ROOT']."/components/weeklong/deceased-table.php";
						?>
	        </div>
				</div>
				<!--
        <div id="Activity" class="tabcontent">
          <h3 class="row-header">Activity</h3>
          <table class="stats-row stats-table">
            <tr class='table-hide-mobile add-line'>
              <th></th>
              <th>Activity</th>
              <th></th>
              <th>Time</th>
            </tr>
            <tr class='table-show-mobile'>
              <th>Activity</th>
            </tr>
            <tr class='table-show-mobile add-line'>
              <th>Time</th>
            </tr>
            <?php
						/*
              $data=$weeklong->get_activity($name);
              foreach($data as $activity){
                $user_1 = $user->get_user_username($activity["user_1"]);
                $action = $activity["action"];
                $user_2 = $user->get_user_username($activity["user_2"]);
                $time = $activity["time"];
                echo "<tr class='table-hide-mobile add-line'>";
	                echo "<td>".$user_1."</td>";
	                echo "<td>".$action."</td>";
	                echo "<td>".$user_2."</td>";
	                echo "<td>".$time."</td>";
                echo "</tr>";

                echo "<tr class='table-show-mobile'><td>".$user_1."</td></tr>";
                echo "<tr class='table-show-mobile'><td>".$action."</td></tr>";
                if($user_2 != null)
                  echo "<tr class='table-show-mobile'><td>".$user_2."</td></tr>";
                echo "<tr class='table-show-mobile add-line'><td>".$time."</td></tr>";
              }
							*/
            ?>
          </table>
        </div>
			-->

        <script src="/js/tabs_2.0.js"></script>

        <script src="/js/tabs.js"></script>

      </div>
    </div>

  </div> <!-- end container -->

</div> <!-- end signup section -->

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

<!--<script src="/js/sort_v2.js"></script>-->
<?php
// insert clock
if(Weeklong::active_event()){
  require('clock.php');
}

// include footer template
require($_SERVER['DOCUMENT_ROOT'].'/layout/footer.php');
?>



</body>
</html>
