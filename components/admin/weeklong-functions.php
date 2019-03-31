<h3 class="row-header">Weeklong</h3>
<style>
.name {
  width: 100px;
}
.title {
  width: 250px;
}
.status {
  width: 60px;
  text-align: center;
}
</style>
<?php

$root = $_SERVER["DOCUMENT_ROOT"];
if(empty($root)){
  $root = "/home/josh/cuhvz_website";
}

include $root."/components/admin/functions/create_weeklong.php";

function buildWeeklonsRow($weeklong){
  echo "<div class='table-row'>";
    echo "<div class='cell-container add-line'>";
      echo "<div class='id cell'>".$weeklong["id"]."</div>";
      echo "<div class='name cell'>".$weeklong["name"]."</div>";
      echo "<div class='title cell'>".$weeklong["title"]."</div>";
      echo "<div class='status cell'>".$weeklong["active"]."</div>";
      echo "<div class='status cell'>".$weeklong["display"]."</div>";
      // echo "<div class='edit cell'>";
      // echo "<input type='image' src='images/settings_white.png' alt='edit' width='20' height='20'>";
      // echo "</div>";
    echo "</div>";
  echo "</div>";
}

?>
<p/>
<div class="table">
    <div class="table-row">
      <div class="cell-container add-line">
        <div class="id cell">id</div>
        <div class="name cell">name</div>
        <div class="title cell">title</div>
        <div class="status cell">active</div>
        <div class="status cell">display</div>
      </div>
    </div>
    <?php

      $query = "SELECT * FROM weeklongs";
      $weeklongData = $database->executeQueryFetchAll($query);
      foreach ($weeklongData as $weeklong) {
        buildWeeklonsRow($weeklong);
      }

    ?>
</div>
