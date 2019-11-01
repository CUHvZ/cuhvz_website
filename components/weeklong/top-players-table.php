<table class="stats-row stats-table">
  <thead>
    <tr class='add-line'>
      <th class="table-row">
        <div class="table-row">
          <span class="table-cell-username">Username</span>
          <span class="table-cell-number">Points</span>
          <span class="table-cell-number">Hunger</span>
        </div>
      </th>
    </tr>
  </thead>
  <tbody id="top-players-table">
    <?php
    if($displayStats){
      $query = "SELECT $weeklongName.*, users.username, users.admin FROM $weeklongName INNER JOIN users ON $weeklongName.user_id=users.id where users.admin=0 order by points DESC limit 3";
      $database = new Database();
      $data = $database->executeQueryFetchAll($query);
      $eventStartDateString = $database->executeQueryFetch("select start_date from weeklongs where name='$weeklongName'")["start_date"];
      foreach($data as $player){
        $starveTimer = (new StarveDate($player["starve_date"]))->getStarveTimer($eventStartDateString);
        $points = $player["points"];
        if($points == null){
          $points = 0;
        }
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
              echo "<span class='table-cell-username' $style>".$player["username"]."</span>"."\n";
              echo "<span class='table-cell-number'>".$points."</span>"."\n";
              echo "<span class='red table-cell-number'>".$starveTimer."</span>"."\n";
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
    <ul class="pagination pagination-lg pager hide-mobile" id="top-players-table-pager"></ul>
  </div>
</div>
<div class="outer-div">
  <div class="inner-div">
    <ul class="pagination pagination-lg pager show-mobile" id="top-players-table-mobile-pager"></ul>
  </div>
</div>
