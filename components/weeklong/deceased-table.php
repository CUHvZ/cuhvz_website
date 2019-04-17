<table class="stats-row stats-table" id="dead-table">
  <thead>
    <tr class='table-hide-mobile add-line'>
      <th onclick="sortTable('deceased-table', 'username', 15)">Username</th>
      <th onclick="sortTable('deceased-table', 'starve', 15)">Starved</th>
      <th onclick="sortTable('deceased-table', 'kills', 15)">Kills</th>
      <th onclick="sortTable('deceased-table', 'points', 15)">Points</th>
    </tr>
  </thead>
  <tbody id="deceased-table" class="hide-mobile">
    <?php
      $query = "SELECT $name.*, users.username, users.admin FROM $name INNER JOIN users ON $name.user_id=users.id where status='deceased'";
      $database = new Database();
      $data = $database->executeQueryFetchAll($query);
      if($displayStats && $data!=null){
        foreach($data as $dead){
            $starve_date = new DateTime(date($dead["starve_date"]));
            $formatTime = $starve_date->format('H:i m-d-Y');
            $points = $dead["points"];
            if($points == null){
              $points = 0;
            }
            $kills = $dead["kill_count"];
            if($kills == null){
              $kills = 0;
            }
            if($player["admin"] > 0)
              $style = "style='color: #eb42f4;'";
            else
              $style = "";
            echo "<tr class='table-hide-mobile add-line'>";
            echo "<td id='username' $style>".$dead["username"]."</td>";
            echo "<td class='red' id='starve'>".$formatTime."</td>";
            echo "<td id='kills'>".$kills."</td>";
            echo "<td id='points'>".$points."</td>";
            echo "</tr>";
        }
      }
    ?>
  </tbody>
  <thead>
    <tr class='table-show-mobile add-line'>
      <th>
        <div class="mobile-table-line-1" onclick="sortTable('deceased-table-mobile', 'username', 15)">Username</div>
        <div class="mobile-table-line-2" onclick="sortTable('deceased-table-mobile', 'kills', 15)" style='float: right'>Kills</div>
        <div>
          <div class="mobile-table-line-2" onclick="sortTable('deceased-table-mobile', 'starve', 15)">Starve Timer</div>
          <div class="mobile-table-line-2" onclick="sortTable('deceased-table-mobile', 'points', 15)" style='float: right'>Points</div>
        </div>
      </th>
      </tr>
  </thead>
  <tbody id="deceased-table-mobile" class="show-mobile">
    <?php
      $query = "SELECT $name.*, users.username, users.admin FROM $name INNER JOIN users ON $name.user_id=users.id where status='deceased'";
      $database = new Database();
      $data = $database->executeQueryFetchAll($query);
      if($displayStats && $data!=null){
        foreach($data as $dead){
            $starve_date = new DateTime(date($dead["starve_date"]));
            $formatTime = $starve_date->format('H:i m-d-Y');
            $points = $dead["points"];
            if($points == null){
              $points = 0;
            }
            $kills = $dead["kill_count"];
            if($kills == null){
              $kills = 0;
            }
            if($player["admin"] > 0)
              $style = "style='color: #eb42f4;'";
            else
              $style = "";
            echo "<tr class='add-line table-show-mobile'><td>";
                echo "<div class='mobile-table-line-1' id='username' $style>".$dead["username"]."</div>";
                echo "<div class='mobile-table-line-2' id='kills' style='float: right'>".$kills."</div>";
                echo "<div>";
                  echo "<div class='mobile-table-line-1 red' id='starve'>".$formatTime."</div>";
                  echo "<div class='mobile-table-line-2' id='points' style='float: right'>".$points."</div>";
                echo "</div>";
            echo "</td></tr>";
        }
      }
    ?>
  </tbody>
</table>
<div class="outer-div">
  <div class="inner-div">
    <ul class="pagination pagination-lg pager hide-mobile" id="deceased-table-pager"></ul>
  </div>
</div>
<div class="outer-div">
  <div class="inner-div">
    <ul class="pagination pagination-lg pager show-mobile" id="deceased-table-mobile-pager"></ul>
  </div>
</div>
