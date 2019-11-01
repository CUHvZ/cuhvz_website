<table class="stats-row stats-table">
  <thead>
    <tr class='add-line'>
      <th class="table-row">
        <div class="table-row">
          <span class="table-cell-username" onclick="sortTable('zombie-table', 'username', 15)">Username</span><br>
          <span class="table-cell-status">Type</span>
          <span class="table-cell-number" onclick="sortTable('zombie-table', 'kills', 15)">Kills</span>
          <span class="table-cell-number" onclick="sortTable('zombie-table', 'points', 15)">Points</span>
          <span class="table-cell-number" onclick="sortTable('zombie-table', 'starve', 15)">Hunger</span>
        </div>
      </th>
    </tr>
  </thead>
  <tbody id="zombie-table">
    <?php
      $query = "SELECT $weeklongName.*, users.username, users.admin FROM $weeklongName INNER JOIN users ON $weeklongName.user_id=users.id where status='zombie'";
      $database = new Database();
      $data = $database->executeQueryFetchAll($query);
      $eventStartDateString = $database->executeQueryFetch("select start_date from weeklongs where name='$weeklongName'")["start_date"];
      if($displayStats && $data != null){
        foreach($data as $zombie){
          $status = $zombie["status_type"];
          $starveTimer = (new StarveDate($zombie["starve_date"]))->getStarveTimer($eventStartDateString);
          $points = $zombie["points"];
          if($points == null){
            $points = 0;
          }
          $kills = $zombie["kill_count"];
          if($kills == null){
            $kills = 0;
          }
          $username = $zombie["username"];
          if($zombie["admin"] > 0)
            $username = $username."<sub style='color: #eb42f4;'>M</sub>";
          echo "<tr class='add-line'>"."\n";
            echo "<td class='table-row'";
              echo "<div class='table-row'>";
                echo "<span id='username' class='table-cell-username'>".$username."</span><br>"."\n";
                echo "<span class='table-cell-status'>".$status."</span>"."\n";
                echo "<span id='kills' class='table-cell-number'>".$kills."</span>"."\n";
                echo "<span id='points' class='table-cell-number'>".$points."</span>"."\n";
                echo "<span class='red table-cell-number' id='starve'>".$starveTimer."</span>"."\n";
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
    <ul class="pagination pagination-lg pager" id="zombie-table-pager"></ul>
  </div>
</div>
