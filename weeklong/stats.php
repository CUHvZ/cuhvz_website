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
				<?php
					$database = new Database();
					$displayStats = false;
					$numPlayers = 0;
					$numHumans = 0;
					$numZombies = 0;
					$numDead = 0;
					$weeklongName = "";
					$weeklongTitle = "";
					$weeklongID = 0;
					$zombieTimer = "";
					if(isset($_GET["id"])){
						$weeklongID = $_GET["id"];
						$data = $database->executeQueryFetch("select * from weeklongs where id='$weeklongID'");
						if(!isset($data["error"])){
							$displayStats = true;
							$weeklongName = $data["name"];
							$weeklongTitle = $data["title"];
							$query = "select stun_timer from weeklongs where name='$weeklongName'";
							$data = $database->executeQueryFetch($query);
							if(!isset($data["error"])){
								$date = new DateTime(date('H:i:s', strtotime($data["stun_timer"])));
								$zombieTimer = $date->format('i\m s\s');
							}

							$query = "select count(*) as num_players, count(CASE WHEN status='human' THEN status END) as num_humans, count(CASE WHEN status='zombie' THEN status END) as num_zombies, count(CASE WHEN status='deceased' THEN status END) as num_dead from $weeklongName;";
							$data = $database->executeQueryFetch($query);
							if(!isset($data["error"])){
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
							}
						}
          }
        ?>
	      <h1 class='stats-header'><?php echo "<a class='white' href='/weeklong/info.php?id=$weeklongID'>$weeklongTitle</a>"; ?></h1>
	      <div class="stats-header orange">Player Statistics</div>
				<div class='stats-header'>
					Zombie Stun Timer: <?php echo $zombieTimer; ?>
				</div>
				<div id="Top" style="display: block;">
          <h3 class="row-header">Top players</h3>
            <?php
						// make so angel never shows up
              include $_SERVER['DOCUMENT_ROOT']."/components/weeklong/top-players-table.php";
            ?>
        </div>
        <div style="margin: auto; text-align: center;">
          <span class="tab">
            <button class="tablink active" id='All-tab-button' onclick="openTab('All')">All: <?php echo $numPlayers; ?></button>
            <button class="tablink" id='Humans-tab-button' onclick="openTab('Humans')">Humans: <?php echo $numHumans; ?></button>
          </span>
          <span class="tab">
						<button class="tablink" id='Zombies-tab-button' onclick="openTab('Zombies')">Zombies: <?php echo $numZombies; ?></button>
            <button class="tablink" id='Dead-tab-button' onclick="openTab('Deceased')">Dead: <?php echo $numDead; ?></button>
            <!-- <button class="tablink" onclick="openTab('Activity')">Activity</button> -->
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

        <script src="/js/tabs-3.0.js"></script>

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
