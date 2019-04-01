<h3 class="row-header">Users</h3>

<style>
.status{
  width: 70px;
}
.starve{
  width: 100px;
  text-align: center;
}
option {
  color: black;
}
</style>

<?php

function buildPlayerrRow($player){
  echo "<div class='table-row'>";
    echo "<div class='cell-container add-line'>";
      echo "<div class='id cell'>".$player["user_id"]."</div>";
      echo "<div class='username cell'>".$player["username"]."</div>";
      echo "<div class='status cell'>".$player["status"]."</div>";
      echo "<div class='status cell'>".$player["status_type"]."</div>";
      echo "<div class='id cell'>".$player["kill_count"]."</div>";
      echo "<div class='id cell'>".$player["points"]."</div>";
      $starve_date = new DateTime(date($player["starve_date"]));
      $current_time = new DateTime(date('Y-m-d H:i:s'));
      $end_time = new DateTime(date($_SESSION["end_date"]));
      if($current_time > $end_time){
        $current_time = $end_time;
      }
      $time_left = $current_time->diff($starve_date);
      $hours = $time_left->format('%H')+($time_left->format('%a')*24);
      $formatTime = $hours.$time_left->format(':%I');
      echo "<div class='starve cell'>".$formatTime."</div>";
    echo "</div>";
  echo "</div>";
}


include $_SERVER["DOCUMENT_ROOT"]."/components/admin/functions/create_code.php";

?>

<div class="table">
    <div class="table-row">
      <div class="cell-container add-line">
        <div class="id cell">id</div>
        <div class="username cell">username</div>
        <div class="status cell">status</div>
        <div class="status cell">type</div>
        <div class="id cell">kills</div>
        <div class="id cell">points</div>
        <div class="starve cell">starve date</div>
      </div>
    </div>
    <?php
      $weeklongName = $_SESSION["weeklong"];
      $query = "SELECT * FROM  $weeklongName";
      $playerData = $database->executeQueryFetchAll($query);
      foreach ($playerData as $player) {
        buildPlayerrRow($player);
      }

    ?>
</div>
