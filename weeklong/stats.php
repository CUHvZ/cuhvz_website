<?php

require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');


// include header template
require('../layout/header.php');

include $_SERVER['DOCUMENT_ROOT'].'/layout/navbar.php';

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
      <div class="subheadline orange" style="margin: 0; text-align: center; font-size: 50px;">Player Statistics</div>
      <div><!-- class="statistics"-->
        <?php
          $displayStats = false;
          if(isset($_GET["name"])){
            $name = $_GET["name"];
            if($weeklong->get_weeklong($name)){
              $displayStats = true;
              echo "<p class='subheadline' style='margin: 0; text-align: center; color: white; font-size: 20px;'>";
              echo "Humans: ".sizeof($weeklong->get_humans_from($name));
              echo " &emsp; Zombies: ".sizeof($weeklong->get_zombies_from($name));
              echo " &emsp; Deceased: ".sizeof($weeklong->get_deceased_from($name));
              echo "</p>";
            }
          }
        ?>
        <div class="tab">
          <button class="tablinks active" onclick="openTab(event, 'Humans')">Humans</button>
          <button class="tablinks" onclick="openTab(event, 'Zombies')">Zombies</button>
          <button class="tablinks" onclick="openTab(event, 'Deceased')">Deceased</button>
          <button class="tablinks" onclick="openTab(event, 'Activity')">Activity</button>
        </div>

        <div id="Humans" class="tabcontent" style="display: block;">
          <h3 class="row_header">Humans</h3>
          <table style="width:60%" class="stats_row">
            <tr>
              <th>Username</th>
              <th>Starve Timer</th>
              <th>Points</th>
            </tr>
            <?php
              if($displayStats){
                $data=$weeklong->get_humans_from($name);
                foreach($data as $human){
                  echo "<tr>";
                  echo "<td>".$human["username"]."</td>";
                  $starve_date = new DateTime(date($human["starve_date"]));
                  $current_time = new DateTime(date('Y-m-d H:i:s'));
                  $end_time = new DateTime(date($weeklong->get_weeklong($name)["end_date"]));
                  if($current_time > $end_time){
                    $current_time = $end_time;
                  }
                  $time_left = $current_time->diff($starve_date);
                  $hours = $time_left->format('%H')+($time_left->format('%a')*24);
                  echo "<th class='red'>".$hours.$time_left->format(':%I:%S')."</th>";
                  $points = $human["points"];
                  if($points == null){
                    $points = 0;
                  }
                  echo "<td>".$points."</td>";
                  echo "</tr>";
                }
              }
            ?>
          </table>
        </div>

        <div id="Zombies" class="tabcontent">
          <h3 class="row_header">Zombies</h3>
          <table style="width:60%" class="stats_row">
            <tr>
              <th>Username</th>
              <th>Type</th>
              <th>Kills</th>
              <th>Starve Timer</th>
              <th>Points</th>
            </tr>
            <?php
            $data=$weeklong->get_deceased_from($name);
              if($displayStats && $data != null){
                $data=$weeklong->get_zombies_from($name);
                foreach($data as $zombie){
                  echo "<tr>";
                  echo "<th>".$zombie["username"]."</th>";
                  echo "<th>".getZombieType($zombie["status"])."</th>";
                  echo "<th>".($zombie["kill_count"]+0)."</th>";
                  $starve_date = new DateTime(date($zombie["starve_date"]));
                  $current_time = new DateTime(date('Y-m-d H:i:s'));
                  $end_time = new DateTime(date($weeklong->get_weeklong($name)["end_date"]));
                  if($current_time > $end_time){
                    $current_time = $end_time;
                  }
                  $time_left = $current_time->diff($starve_date);
                  $hours = $time_left->format('%H')+($time_left->format('%a')*24);
                  echo "<th class='red'>".$hours.$time_left->format(':%I:%S')."</th>";
                  $points = $zombie["points"];
                  if($points == null){
                    $points = 0;
                  }
                  echo "<th>".$points."</th>";
                  echo "</tr>";
                }
              }
            ?>
          </table>
        </div>

        <div id="Deceased" class="tabcontent">
          <h3 class="row_header">Deceased</h3>
          <table style="width:60%" class="stats_row">
            <tr>
              <th>Username</th>
              <th>Starved</th>
              <th>Kills</th>
              <th>Points</th>
            </tr>
            <?php
              $data=$weeklong->get_deceased_from($name);
              if($displayStats && $data!=null){
                //$data=$weeklong->get_deceased_from($name);
                foreach($data as $dead){
                    echo "<tr>";
                    echo "<th>".$dead["username"]."</th>";
                    $starve_date = new DateTime(date($dead["starve_date"]));
                    echo "<th class='red'>".$starve_date->format('H:i m-d-Y')."</th>";
                    echo "<th>".($dead["kill_count"])."</th>";
                    $points = $dead["points"];
                    if($points == null){
                      $points = 0;
                    }
                    echo "<th>".$points."</th>";
                    echo "</tr>";
                }
              }
            ?>
          </table>
        </div>

        <div id="Activity" class="tabcontent">
          <h3 class="row_header">Activity</h3>
          <table style="width:60%" class="stats_row">
            <tr>
              <th></th>
              <th>Activity</th>
              <th></th>
              <th>Time</th>
            </tr>
            <?php
              $data=$weeklong->get_activity($name);
              if($data == null){
                $filename = $_SERVER['DOCUMENT_ROOT']."/weeklong/".$name."/stats.csv";
                include_once($_SERVER['DOCUMENT_ROOT']."/scripts/readcsvfile.php");
              }
              foreach($data as $activity){
                  echo "<tr>";
                  echo "<th>".$user->get_user_username($activity["user_1"])."</th>";
                  echo "<th>".$activity["action"]."</th>";
                  echo "<th>".$user->get_user_username($activity["user_2"])."</th>";
                  echo "<th>".$activity["time"]."</th>";
                  echo "</tr>";
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

<script src="/js/sort.js"></script>
<?php
// insert clock
if($weeklong->active_event()){
  require('clock.php');
}

// include footer template
require($_SERVER['DOCUMENT_ROOT'].'/layout/footer.php');
?>
