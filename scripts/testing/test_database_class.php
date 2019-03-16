<?php

require "/home/josh/cuhvz_website/classes/Database.php";










function testConditions(){
  $cond1 = new Condition("user_id", 45);
  $cond2 = new Condition("username", "Tester");
  //print_r($cond1);
  echo $cond1."\n";
  echo $cond2."\n";
  $cond1->and($cond2);
  print_r($cond1);
  //print_r($cond2);
}

function testJoinWithUsers(){
  $database = new Database();
  $data = $database->joinWithUsers("user_stats", "id", "users.id=269");
  print_r($data);
}

function testCreatingWeeklongGames(){
  $database = new Database();
  $temp = $database->createWeeklong('X17', 'Some name', 'March 20th - 24th', '2017-04-20 15:00:00', '2017-03-24 23:00:00');
  print_r($temp);
}
?>
