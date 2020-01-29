<table class="stats-row stats-table" id="dead-table">
  <thead>
    <tr class='add-line'>
      <th class="table-row">
        <div class="table-row">
          <span class="table-cell-username" onclick="sortTable('deceased-table', 'username', 15)">Username</span>
          <span class="table-cell-number" onclick="sortTable('deceased-table', 'kills', 15)">Kills</span>
          <span class="table-cell-number" onclick="sortTable('deceased-table', 'points', 15)">Points</span>
          <br class="hide-mobile">
          <span class="table-cell-number" onclick="sortTable('deceased-table', 'starve', 15)">Starved</span>
        </div>
      </th>
    </tr>
  </thead>
  <tbody id="deceased-table">
    <?php
      $query = "SELECT $weeklongName.*, users.username, users.admin FROM $weeklongName INNER JOIN users ON $weeklongName.user_id=users.id where status='deceased'";
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
            $username = $dead["username"];
            if($dead["admin"] > 0)
              $username = $username."<sub style='color: #eb42f4;'>M</sub>";
            echo "<tr class='add-line'>"."\n";
              echo "<td class='table-row'";
                echo "<div class='table-row'>";
                  echo "<span id='username' class='table-cell-username'>".$username."</span>"."\n";
                  echo "<span id='kills' class='table-cell-number'>".$kills."</span>"."\n";
                  echo "<span id='points' class='table-cell-number'>".$points."</span>"."\n";
                  echo "<br class='hide-mobile'>";
                  echo "<span id='starve' class='break red table-cell-number'>".$formatTime."</span>"."\n";
                echo "</div>";
              echo "</td>";
            echo "</tr>"."\n";
        }
      }
    ?>
  </tbody>
</table>
<div class="outer-div">
  <div class="inner-div">
    <ul class="pagination pagination-lg pager" id="deceased-table-pager"></ul>
  </div>
</div>
