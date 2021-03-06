<table class="stats-row stats-table">

  <thead>
    <tr class='add-line'>
      <th class="table-row">
        <div class="table-row">
          <span class="table-cell-username" onclick="sortTable('all-players-table', 'username', 15)">Username</span>
          <span class="table-cell-number" onclick="sortTable('all-players-table', 'points', 15)">Points</span>
          <span class="table-cell-number" onclick="sortTable('all-players-table', 'starve', 15)">Hunger</span>
        </div>
      </th>
    </tr>
  </thead>

  <tbody id="all-players-table">
    <?php
    if($displayStats){
      $query = "SELECT $weeklongName.*, users.username, users.admin FROM $weeklongName INNER JOIN users ON $weeklongName.user_id=users.id";
      $database = new Database();
      $data = $database->executeQueryFetchAll($query);
      $eventStartDateString = $database->executeQueryFetch("select start_date from weeklongs where name='$weeklongName'")["start_date"];
      foreach($data as $player){
        $starveDate = new StarveDate($player["starve_date"]);
        $points = $player["points"];
        if($points == null){
          $points = 0;
        }
        $username = $player["username"];
        $status = "";
        if($player["status_type"] == "poisoned"){
          $status = "<span class='tooltip' style='color: #40eb34;'>(Poisoned)</span>";
        }
        if($player["admin"] > 0)
          $username = $username."<sub style='color: #eb42f4;'>M</sub>";
        $style = "";
        if($player["status"] == "human")
            $style = "style='color: #34abeb;'";
        else if($player["status"] == "zombie")
            $style = "style='color: #40eb34;'";
        else if($player["status"] == "deceased")
            $style = "style='color: #ffffff; text-decoration: line-through;'";
        echo "<tr class='add-line'>"."\n";
          echo "<td class='table-row'";
            echo "<div class='table-row'>";
              echo "<span id='username' class='table-cell-username' $style>$username $status</span>"."\n";
              echo "<span id='points' class='table-cell-number'>".$points."</span>"."\n";
              echo "<span class='red table-cell-number' id='starve'>".$starveDate->getStarveTimer($eventStartDateString)."</span>"."\n";
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
    <ul class="pagination pagination-lg pager" id="all-players-table-pager"></ul>
  </div>
</div>
