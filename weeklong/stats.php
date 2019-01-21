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
	<script src="/js/sort.js"></script>
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

  });
  </script>

</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/layout/navbar.php'; ?>


<?php

function getZombieType($status){
  if($status == "zombie"){
    return "regular";
  }else if($status == "zombie(suicide)"){
    return "suicide";
  }else if($status == "zombie(OZ)"){
    return "OZ";
  }
}
?>



<div class="lightslide">

  <div class="player_container">

    <div class="content lightslide-list" style="overflow: auto;">
      <div class="stats-header orange">Player Statistics</div>
      <div><!-- class="statistics"-->
        <?php
          $displayStats = false;
          if(isset($_GET["name"])){
            $name = $_GET["name"];
            if($weeklong->get_weeklong($name)){
              $displayStats = true;
              echo "<p class='status-header'>";
              echo "Humans: ".sizeof($weeklong->get_humans_from($name));
              echo " &emsp; Zombies: ".sizeof($weeklong->get_zombies_from($name));
              echo " &emsp; Deceased: ".sizeof($weeklong->get_deceased_from($name));
              echo "</p>";
            }
          }
        ?>
        <div style="margin: auto; text-align: center;">
          <span class="tab">
            <button class="tablink active" onclick="openTab(event, 'Humans')">Humans</button>
            <button class="tablink" onclick="openTab(event, 'Zombies')">Zombies</button>
          </span>
          <span class="tab">
            <button class="tablink" onclick="openTab(event, 'Deceased')">Deceased</button>
            <button class="tablink" onclick="openTab(event, 'Activity')">Activity</button>
          </span>
        </div>

        <div id="Humans" class="tabcontent" style="display: block;">
          <h3 class="row-header">Humans</h3>
          <table class="stats-row stats-table">
            <thead>
              <tr class='table-hide-mobile add-line'>
                <th onclick="sortTable('human-table', 'username', 15)">Username</th>
                <th onclick="sortTable('human-table', 'points', 15)">Points</th>
                <th onclick="sortTable('human-table', 'starve', 15)">Starve Timer</th>
              </tr>
            </thead>
            <tbody id="human-table" class="hide-mobile">
            <?php
              if($displayStats){
                $data=$weeklong->get_humans_from($name);
                foreach($data as $human){
                  $starve_date = new DateTime(date($human["starve_date"]));
                  $current_time = new DateTime(date('Y-m-d H:i:s'));
                  $end_time = new DateTime(date($weeklong->get_weeklong($name)["end_date"]));
                  if($current_time > $end_time){
                    $current_time = $end_time;
                  }
                  $time_left = $current_time->diff($starve_date);
                  $hours = $time_left->format('%H')+($time_left->format('%a')*24);
                  $formatTime = $hours.$time_left->format(':%I');
                  $points = $human["points"];
                  if($points == null){
                    $points = 0;
                  }
                  echo "<tr class='table-hide-mobile add-line'>"."\n";
                  echo "<td id='username'>".$human["username"]."</td>"."\n";
                  echo "<td id='points'>".$points."</td>"."\n";
                  echo "<td class='red' id='starve'>".$formatTime."</td>"."\n";
                  echo "</tr>"."\n";
                }
              }
            ?>
          </tbody>
						<thead>
							<tr class='table-show-mobile add-line'>
								<th>
									<div class="mobile-table-line-1" onclick="sortTable('human-table-mobile', 'username', 15)">Username</div>
									<div>
										<div class="mobile-table-line-2" onclick="sortTable('human-table-mobile', 'points', 15)">
											Points
										</div>
										<div class="mobile-table-line-2" onclick="sortTable('human-table-mobile', 'starve', 15)">
											Starve Timer
										</div>
									</div>
								</th>
							</tr>
						</thead>
          <tbody id="human-table-mobile" class="show-mobile">
            <?php
              if($displayStats){
                $data=$weeklong->get_humans_from($name);
                foreach($data as $human){
                  $starve_date = new DateTime(date($human["starve_date"]));
                  $current_time = new DateTime(date('Y-m-d H:i:s'));
                  $end_time = new DateTime(date($weeklong->get_weeklong($name)["end_date"]));
                  if($current_time > $end_time){
                    $current_time = $end_time;
                  }
                  $time_left = $current_time->diff($starve_date);
                  $hours = $time_left->format('%H')+($time_left->format('%a')*24);
                  $formatTime = $hours.$time_left->format(':%I:%S');
                  $points = $human["points"];
                  if($points == null){
                    $points = 0;
                  }

									echo "<tr class='add-line table-show-mobile'><td>";
											echo "<div class='mobile-table-line-1' id='username'>".$human["username"]."</div>";
											echo "<div>";
												echo "<div class='mobile-table-line-2' id='points'>".$points."</div>";
												echo "<div class='mobile-table-line-2 red' id='starve'>".$formatTime."</div>";
											echo "</div>";
									echo "</td></tr>";
                }
              }
            ?>
          </tbody>
          </table>
            <div class="outer-div">
              <div class="inner-div">
                <ul class="pagination pagination-lg pager hide-mobile" id="human-table-pager"></ul>
              </div>
            </div>
            <div class="outer-div">
							<div class="inner-div">
								<ul class="pagination pagination-lg pager show-mobile" id="human-table-mobile-pager"></ul>
							</div>
            </div>
        </div>

        <div id="Zombies" class="tabcontent">
          <h3 class="row-header">Zombies</h3>
          <table class="stats-row stats-table" id="zombie-table">
            <tbody>
              <tr class='add-line table-hide-mobile'>
                <th>Username</th>
                <th>Type</th>
                <th>Kills</th>
                <th style="line-height: 1.2em;">Starve Timer</th>
                <th>Points</th>
              </tr>
              <tr class='table-show-mobile'>
                <th colspan="2">Username</th>
                <th>Kills</th>
              </tr>
              <tr class="add-line table-show-mobile">
                <th>Starve Timer</th>
                <th>Type</th>
                <th>Points</th>
              </tr>
              <?php
              $data=$weeklong->get_zombies_from($name);
                if($displayStats && $data != null){
                  $data=$weeklong->get_zombies_from($name);
                  foreach($data as $zombie){
                    $status = getZombieType($zombie["status"]);
                    $starve_date = new DateTime(date($zombie["starve_date"]));
                    $current_time = new DateTime(date('Y-m-d H:i:s'));
                    $end_time = new DateTime(date($weeklong->get_weeklong($name)["end_date"]));
                    if($current_time > $end_time){
                      $current_time = $end_time;
                    }
                    $time_left = $current_time->diff($starve_date);
                    $hours = $time_left->format('%H')+($time_left->format('%a')*24);
                    $formatTime = $hours.$time_left->format(':%I:%S');
                    $points = $zombie["points"];
                    if($points == null){
                      $points = 0;
                    }
                    echo "<tr class='table-hide-mobile add-line'>";
                    echo "<td>".$zombie["username"]."</td>";
                    echo "<td>".$status."</td>";
                    echo "<td>".($zombie["kill_count"]+0)."</td>";
                    echo "<td class='red'>".$formatTime."</td>";
                    echo "<td>".$points."</td>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile'>";
                    echo "<td colspan='2'>".$zombie["username"]."</td>";
                    echo "<td>".($zombie["kill_count"]+0)."</td>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile add-line'>";
                    echo "<td class='red'>".$formatTime."</td>";
                    echo "<td>".$status."</td>";
                    echo "<td>".$points."</td>";
                    echo "</tr>";
                  }
                }
              ?>
            </tbody>
          </table>
        </div>

        <div id="Deceased" class="tabcontent">
          <h3 class="row-header">Deceased</h3>
          <table class="stats-row stats-table" id="dead-table">
            <tr class='table-hide-mobile'>
              <th>Username</th>
              <th>Starved</th>
              <th>Kills</th>
              <th>Points</th>
            </tr>
            <tr class='table-show-mobile'>
              <th>Username</th>
              <th>Kills</th>
            </tr>
            <tr class="add-line table-show-mobile">
              <th>Starved</th>
              <th>Points</th>
            </tr>
            <?php
              $data=$weeklong->get_deceased_from($name);
              if($displayStats && $data!=null){
                //$data=$weeklong->get_deceased_from($name);
                foreach($data as $dead){
                    $starve_date = new DateTime(date($dead["starve_date"]));
                    $formatTime = $starve_date->format('H:i m-d-Y');
                    $points = $dead["points"];
                    if($points == null){
                      $points = 0;
                    }
                    echo "<tr class='table-hide-mobile add-line'>";
                    echo "<td>".$dead["username"]."</td>";
                    echo "<td class='red'>".$formatTime."</td>";
                    echo "<td>".($dead["kill_count"])."</td>";
                    echo "<td>".$points."</td>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile'>";
                    echo "<td>".$dead["username"]."</td>";
                    echo "<td>".($zombie["kill_count"]+0)."</td>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile add-line'>";
                    echo "<td class='red'>".$formatTime."</td>";
                    echo "<td>".$points."</td>";
                    echo "</tr>";
                }
              }
            ?>
          </table>
        </div>

        <div id="Activity" class="tabcontent">
          <h3 class="row-header">Activity</h3>
          <table class="stats-row stats-table">
            <tr class='table-hide-mobile'>
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
              $data=$weeklong->get_activity($name);
              if($data == null){
                $filename = $_SERVER['DOCUMENT_ROOT']."/weeklong/".$name."/stats.csv";
                include_once($_SERVER['DOCUMENT_ROOT']."/scripts/readcsvfile.php");
              }
              foreach($data as $activity){
                $user_1 = $user->get_user_username($activity["user_1"]);
                $action = $activity["action"];
                $user_2 = $user->get_user_username($activity["user_2"]);
                $time = $activity["time"];
                echo "<tr class='table-hide-mobile'>";
                echo "<td>".$user_1."</td>";
                echo "<td>".$action."</td>";
                echo "<td>".$user_2."</td>";
                echo "<td>".$time."</td>";
                echo "</tr>";

                echo "<tr class='table-show-mobile'><td>".$user_1."</td></tr>";
                echo "<tr class='table-show-mobile'><td>".$action."</td></tr>";
                if($user_2 != null)
                  echo "<tr class='table-show-mobile'><td>".$user_2."</td></tr>";
                echo "<tr class='table-show-mobile'><td>".$time."</td></tr>";
              }
            ?>
          </table>
        </div>

        <script src="/js/tabs.js"></script>

      </div>
    </div>

  </div> <!-- end container -->

</div> <!-- end signup section -->

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

<!--<script src="/js/sort.js"></script>-->
<?php
// insert clock
if($weeklong->active_event()){
  require('clock.php');
}

// include footer template
require($_SERVER['DOCUMENT_ROOT'].'/layout/footer.php');
?>



</body>
</html>
