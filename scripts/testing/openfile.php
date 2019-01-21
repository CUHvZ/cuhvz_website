<?php require('../../includes/config.php');

// define page title
$title = 'HVZ CU BOULDER';

// include header template
require('../../layout/header.php');

try{
	$stmt = $db->prepare("SELECT * FROM weeklongF18_activity;");
	$stmt->execute();
	$data = $stmt->fetchAll();
}catch(PDOException $e){
  //Data base not found
  $filename = "file.csv";
  include_once("opencsvfile.php");
}


?>
<table style="width:60%;" class="stats_row">
  <tr style="color: black;">
    <th></th>
    <th>Activity</th>
    <th></th>
    <th>Time</th>
  </tr>
  <?php
  foreach($data as $activity){
      echo "<tr>";
      echo "<th>".$user->get_user_username($activity["user_1"])."</th>";
      echo "<th>".$activity["action"]."</th>";
      echo "<th>".$user->get_user_username($activity["user_2"])."</th>";
      echo "<th>".$activity["time"]."</th>";
      echo "</tr>";
  }
  ?>
</table>
