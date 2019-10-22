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
      foreach($data as $player){
        $starveDate = new StarveDate($player["starve_date"]);
        $points = $player["points"];
        if($points == null){
          $points = 0;
        }
        $username = $player["username"];
        if($player["admin"] > 0)
          $username = $username."<sub style='color: #eb42f4;'>M</sub>";
        $style = "";
        if($player["status"] == "human")
            $style = "style='color: #34abeb;'";
        else if(strrpos($player["status"], "zombie") >= 0)
            $style = "style='color: #40eb34;'";
        else if(strrpos($player["status"], "dead") >= 0)
            $style = "style='color: #ff0000;'";
        echo "<tr class='add-line'>"."\n";
          echo "<td class='table-row'";
            echo "<div class='table-row'>";
              echo "<span id='username' class='table-cell-username' $style>".$username."</span>"."\n";
              echo "<span id='points' class='table-cell-number'>".$points."</span>"."\n";
              echo "<span class='red table-cell-number' id='starve'>".$starveDate->getStarveTimer()."</span>"."\n";
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
