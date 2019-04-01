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
