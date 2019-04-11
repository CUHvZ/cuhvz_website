<table class="stats-row stats-table">
  <thead>
    <tr class='table-hide-mobile add-line'>
      <th onclick="sortTable('all-players-table', 'username', 15)">Username</th>
      <th onclick="sortTable('all-players-table', 'points', 15)">Points</th>
      <th>Status</th>
      <th onclick="sortTable('all-players-table', 'starve', 15)">Starve Timer</th>
    </tr>
  </thead>
  <tbody id="all-players-table" class="hide-mobile">
    <?php
    if($displayStats){
      $query = "SELECT $name.*, users.username FROM $name INNER JOIN users ON $name.user_id=users.id";
      $database = new Database();
      $data = $database->executeQueryFetchAll($query);
      foreach($data as $player){
        $starve_date = new DateTime(date($player["starve_date"]));
        $current_time = new DateTime(date('Y-m-d H:i:s'));
        $end_time = new DateTime(date($weeklong->get_weeklong($name)["end_date"]));
        if($current_time > $end_time){
          $current_time = $end_time;
        }
        $time_left = $current_time->diff($starve_date);
        $hours = $time_left->format('%H')+($time_left->format('%a')*24);
        $formatTime = $hours.$time_left->format(':%I');
        $points = $player["points"];
        if($points == null){
          $points = 0;
        }
        if($player["status"] == "deceased")
          $formatTime = "0:0:0";
        echo "<tr class='table-hide-mobile add-line'>"."\n";
        echo "<td id='username'>".$player["username"]."</td>"."\n";
        echo "<td id='points'>".$points."</td>"."\n";
        echo "<td id='points'>".$player["status"]."</td>"."\n";
        echo "<td class='red' id='starve'>".$formatTime."</td>"."\n";
        echo "</tr>"."\n";
      }
    }
    ?>
  </tbody>

  <thead>
    <tr class='table-show-mobile add-line'>
      <th>
        <div>
          <div class="mobile-table-line-1" onclick="sortTable('all-players-table-mobile', 'username', 15)">Username</div>
          <div class="mobile-table-line-1">Status</div>
        </div>
        <div>
          <div class="mobile-table-line-2" onclick="sortTable('all-players-table-mobile', 'points', 15)">
            Points
          </div>
          <div class="mobile-table-line-2" onclick="sortTable('all-players-table-mobile', 'starve', 15)">
            Starve Timer
          </div>
        </div>
      </th>
    </tr>
  </thead>

  <tbody id="all-players-table-mobile" class="show-mobile">
  <?php
    if($displayStats){
      $query = "SELECT $name.*, users.username FROM $name INNER JOIN users ON $name.user_id=users.id";
      $database = new Database();
      $data = $database->executeQueryFetchAll($query);
      foreach($data as $player){
        $starve_date = new DateTime(date($player["starve_date"]));
        $current_time = new DateTime(date('Y-m-d H:i:s'));
        $end_time = new DateTime(date($weeklong->get_weeklong($name)["end_date"]));
        if($current_time > $end_time){
          $current_time = $end_time;
        }
        $time_left = $current_time->diff($starve_date);
        $hours = $time_left->format('%H')+($time_left->format('%a')*24);
        $formatTime = $hours.$time_left->format(':%I:%S');
        $points = $player["points"];
        if($points == null){
          $points = 0;
        }
        if($player["status"] == "deceased")
          $formatTime = "0:0:0";

        echo "<tr class='add-line table-show-mobile'><td>";
            echo "<div>";
              echo "<div class='mobile-table-line-1' id='username'>".$player["username"]."</div>";
              echo "<div class='mobile-table-line-1' id='username'>".$player["status"]."</div>";
            echo "</div>";
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
    <ul class="pagination pagination-lg pager hide-mobile" id="all-players-table-pager"></ul>
  </div>
</div>
<div class="outer-div">
  <div class="inner-div">
    <ul class="pagination pagination-lg pager show-mobile" id="all-players-table-mobile-pager"></ul>
  </div>
</div>