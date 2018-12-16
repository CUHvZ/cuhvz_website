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
            <tr class='table-hide-mobile add-line'>
              <th>Username</th>
              <th>Points</th>
              <th>Starve Timer</th>
            </tr>
            <tr class='table-show-mobile'>
              <th colspan="2">Username</th>
            </tr>
            <tr class="add-line table-show-mobile">
              <th>Points</th>
              <th>Starve Timer</th>
            </tr>
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
                  echo "<tr class='table-hide-mobile add-line'>";
                  echo "<td>".$human["username"]."</td>";
                  echo "<td>".$points."</td>";
                  echo "<th class='red'>".$formatTime."</th>";
                  echo "</tr>";

                  echo "<tr class='table-show-mobile'>";
                  echo "<td colspan='2'>".$human["username"]."</td>";
                  echo "</tr>";

                  echo "<tr class='table-show-mobile add-line'>";
                  echo "<th>".$points."</th>";
                  echo "<th class='red'>".$formatTime."</th>";
                  echo "</tr>";
                }
              }
            ?>
          </table>
        </div>

        <div id="Zombies" class="tabcontent">
          <h3 class="row-header">Zombies</h3>
          <table class="stats-row stats-table">
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
                    echo "<th>".$zombie["username"]."</th>";
                    echo "<th>".$status."</th>";
                    echo "<th>".($zombie["kill_count"]+0)."</th>";
                    echo "<th class='red'>".$formatTime."</th>";
                    echo "<th>".$points."</th>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile'>";
                    echo "<th colspan='2'>".$zombie["username"]."</th>";
                    echo "<th>".($zombie["kill_count"]+0)."</th>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile add-line'>";
                    echo "<th class='red'>".$formatTime."</th>";
                    echo "<th>".$status."</th>";
                    echo "<th>".$points."</th>";
                    echo "</tr>";
                  }
                }
              ?>
            </tbody>
          </table>
        </div>

        <div id="Deceased" class="tabcontent">
          <h3 class="row-header">Deceased</h3>
          <table class="stats-row stats-table">
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
                    echo "<th>".$dead["username"]."</th>";
                    echo "<th class='red'>".$formatTime."</th>";
                    echo "<th>".($dead["kill_count"])."</th>";
                    echo "<th>".$points."</th>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile'>";
                    echo "<th>".$dead["username"]."</th>";
                    echo "<th>".($zombie["kill_count"]+0)."</th>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile add-line'>";
                    echo "<th class='red'>".$formatTime."</th>";
                    echo "<th>".$points."</th>";
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
                echo "<th>".$user_1."</th>";
                echo "<th>".$action."</th>";
                echo "<th>".$user_2."</th>";
                echo "<th>".$time."</th>";
                echo "</tr>";

                echo "<tr class='table-show-mobile'><th>".$user_1."</th></tr>";
                echo "<tr class='table-show-mobile'><th>".$action."</th></tr>";
                if($user_2 != null)
                  echo "<tr class='table-show-mobile'><th>".$user_2."</th></tr>";
                echo "<tr class='table-show-mobile'><th>".$time."</th></tr>";
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
