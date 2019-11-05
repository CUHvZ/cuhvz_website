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
.function-input{
  background-color: transparent;
  border: 1px solid #D1D1D1;
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
      $starveDate = new StarveDate($player["starve_date"]);
      echo "<div class='starve cell'>".$starveDate->getStarveTimer()."</div>";
    echo "</div>";
  echo "</div>";
}


// include $_SERVER["DOCUMENT_ROOT"]."/components/admin/functions/create_code.php";

?>

<div class="content" style="overflow: auto;">
  <div style="margin: auto; text-align: center;">
    <span class="tab">
      <button class="tablink-full" id="CreateCode-tab-button" onclick="openNestedTab('CreateCode', 'active-game-tabs')">Create Code</button>
    </span>
    <span class="tab">
      <button class="tablink" id="StunTimer-tab-button" onclick="openNestedTab('StunTimer', 'active-game-tabs')">Stun Timer</button>
    </span>
  </div>
  <div>
    <div id="CreateCode" class="active-game-tabs tabcontent">
      <?php include $_SERVER['DOCUMENT_ROOT']."/components/admin/functions/create_code.php"; ?>
    </div>
    <!-- <div id="CreateCode" class="active-game-tabs tabcontent">
      <?php // include $_SERVER['DOCUMENT_ROOT']."/components/admin/functions/create_code.php"; ?>
    </div>
    <div id="CreateCode" class="active-game-tabs tabcontent">
      <?php // include $_SERVER['DOCUMENT_ROOT']."/components/admin/functions/create_code.php"; ?>
    </div> -->
    <div id="StunTimer" class="active-game-tabs tabcontent">
      <?php include $_SERVER['DOCUMENT_ROOT']."/components/admin/functions/set_stun_timer.php"; ?>
    </div>
  </div>
</div>
<!-- <div class="table">
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
      // $weeklongName = $_SESSION["weeklong"];
      // $query = "SELECT * FROM  $weeklongName";
      // $playerData = $database->executeQueryFetchAll($query);
      // foreach ($playerData as $player) {
      //   buildPlayerrRow($player);
      // }

    ?>
</div> -->
