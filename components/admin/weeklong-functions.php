<h3 class="row-header">Weeklong</h3>
<?php

$root = $_SERVER["DOCUMENT_ROOT"];
if(empty($root)){
  $root = "/home/josh/cuhvz_website";
}

include $root."/components/admin/functions/create_weeklong.php";

?>

<div class="center">
  <?php

  // $database = new Database();
  // $weeklongs = $database->executeQueryFetchAll("SELECT * FROM weeklongs WHERE display=1 ORDER BY start_date DESC");
  // foreach ($weeklongs as $event){
  //   echo "<div>";
  //     echo "<h3>".$event["name"]."</h3>";
  //   echo "</div>";
  // }

  ?>
</div>
