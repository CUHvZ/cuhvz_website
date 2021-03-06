<table class="stats-row stats-table">
  <thead>
    <tr class='add-line'>
      <th class="table-row">
        <div class="table-row">
          <span class="table-cell-username" onclick="sortTable('human-table', 'username', 15)">Username</span>
          <span class="table-cell-number" onclick="sortTable('human-table', 'points', 15)">Points</span>
          <span class="table-cell-number" onclick="sortTable('human-table', 'starve', 15)">Hunger</span>
        </div>
      </th>
    </tr>
  </thead>
  <tbody id="human-table">
    <?php
    if($displayStats){
      $query = "SELECT $weeklongName.*, users.username, users.admin FROM $weeklongName INNER JOIN users ON $weeklongName.user_id=users.id where status='human'";
      $database = new Database();
      $data = $database->executeQueryFetchAll($query);
      $eventStartDateString = $database->executeQueryFetch("select start_date from weeklongs where name='$weeklongName'")["start_date"];
      foreach($data as $human){
        $starveTimer = (new StarveDate($human["starve_date"]))->getStarveTimer($eventStartDateString);
        $points = $human["points"];
        if($points == null){
          $points = 0;
        }
        $username = $human["username"];
        $status = "";
        if($human["status_type"] == "poisoned"){
          $status = "<span style='color: #40eb34;'>(Poisoned)</span>";
        }
        if($human["admin"] > 0)
          $username = $username."<sub style='color: #eb42f4;'>M</sub>";
        echo "<tr class='add-line'>"."\n";
          echo "<td class='table-row'";
            echo "<div class='table-row'>";
              echo "<span id='username' class='table-cell-username'>$username $status</span>"."\n";
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
    <ul class="pagination pagination-lg pager" id="human-table-pager"></ul>
  </div>
</div>
