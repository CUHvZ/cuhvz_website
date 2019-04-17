<table class="stats-row stats-table">
  <thead>
  <tr class='add-line table-hide-mobile'>
    <th onclick="sortTable('zombie-table', 'username', 15)">Username</th>
    <th>Type</th>
    <th onclick="sortTable('zombie-table', 'kills', 15)">Kills</th>
    <th  onclick="sortTable('zombie-table', 'starve', 15)" style="line-height: 1.2em;">Starve Timer</th>
    <th onclick="sortTable('zombie-table', 'points', 15)">Points</th>
  </tr>
  </thead>
  <tbody id="zombie-table" class="hide-mobile">
    <?php
      $query = "SELECT $name.*, users.username, users.admin FROM $name INNER JOIN users ON $name.user_id=users.id where status='zombie'";
      $database = new Database();
      $data = $database->executeQueryFetchAll($query);
      if($displayStats && $data != null){
        $data=$weeklong->get_zombies_from($name);
        foreach($data as $zombie){
          $status = $zombie["status_type"];
          $starveTimer = (new StarveDate($zombie["starve_date"]))->getStarveTimer();
          $points = $zombie["points"];
          if($points == null){
            $points = 0;
          }
          $kills = $zombie["kill_count"];
          if($kills == null){
            $kills = 0;
          }
          if($player["admin"] > 0)
            $style = "style='color: #eb42f4;'";
          else
            $style = "";
          echo "<tr class='table-hide-mobile add-line'>";
          echo "<td id='username' $style>".$zombie["username"]."</td>";
          echo "<td>".$status."</td>";
          echo "<td id='kills'>".$kills."</td>";
          echo "<td class='red' id='starve'>".$starveTimer."</td>";
          echo "<td id='points'>".$points."</td>";
          echo "</tr>";
        }
      }
    ?>
  </tbody>
  <thead>
    <tr class='table-show-mobile add-line'>
      <th>
        <div class="mobile-table-line-1" onclick="sortTable('zombie-table-mobile', 'username', 15)">Username</div>
        <div class="mobile-table-line-1" style='float: right;'>Type</div>
        <div>
          <div class="mobile-table-line-2" onclick="sortTable('zombie-table-mobile', 'kills', 15)">Kills</div>
          <div class="mobile-table-line-2" onclick="sortTable('zombie-table-mobile', 'points', 15)">Points</div>
          <div class="mobile-table-line-2" onclick="sortTable('zombie-table-mobile', 'starve', 15)">Starve Timer</div>
        </div>
      </th>
      </tr>
  </thead>
  <tbody id="zombie-table-mobile" class="show-mobile">
    <?php
      $query = "SELECT $name.*, users.username, users.admin FROM $name INNER JOIN users ON $name.user_id=users.id where status='zombie'";
      $database = new Database();
      $data = $database->executeQueryFetchAll($query);
      if($displayStats && $data != null){
        $data=$weeklong->get_zombies_from($name);
        foreach($data as $zombie){
          $status = $zombie["status_type"];
          $starveTimer = (new StarveDate($zombie["starve_date"]))->getStarveTimer();
          $points = $zombie["points"];
          if($points == null){
            $points = 0;
          }
          $kills = $zombie["kill_count"];
          if($kills == null){
            $kills = 0;
          }
          if($player["admin"] > 0)
            $style = "style='color: #eb42f4;'";
          else
            $style = "";
          echo "<tr class='add-line table-show-mobile'><td>";
              echo "<div class='mobile-table-line-1' id='username' $style>".$zombie["username"]."</div>";
              echo "<div class='mobile-table-line-1 red' style='float: right;'>".$status."</div>";
              echo "<div>";
                echo "<div class='mobile-table-line-2' id='kills'>".$kills."</div>";
                echo "<div class='mobile-table-line-2' id='points'>".$points."</div>";
                echo "<div class='mobile-table-line-2 red' id='starve'>".$starveTimer."</div>";
              echo "</div>";
          echo "</td></tr>";
        }
      }
    ?>
  </tbody>
</table>
<div class="outer-div">
  <div class="inner-div">
    <ul class="pagination pagination-lg pager hide-mobile" id="zombie-table-pager"></ul>
  </div>
</div>
<div class="outer-div">
  <div class="inner-div">
    <ul class="pagination pagination-lg pager show-mobile" id="zombie-table-mobile-pager"></ul>
  </div>
</div>
