<?php

$starve_date = new DateTime(date("2019-04-13 16:47:53"));
$current_time = new DateTime(date('Y-m-d H:i:s'));
$end_time = new DateTime(date("2019-04-19 20:00:00"));
if($current_time > $end_time){
  $current_time = $end_time;
}
if($starve_date < $current_time){
  $formatTime = "0:0";
}else{
  $time_left = $current_time->diff($starve_date);
  $hours = $time_left->format('%H')+($time_left->format('%a')*24);
  $formatTime = $hours.$time_left->format(':%I');
}
// error_log($formatTime, 0);


$starveDate = new DateTime(date("2019-04-16 19:40:45"));
$hours = 24;
error_log($starveDate->format('Y-m-d H:i:s'), 0);
$starveDate = date_add($starveDate, date_interval_create_from_date_string("$hours hours"));
error_log($starveDate->format('Y-m-d H:i:s'), 0);

public function addHours($hours){
  $starveDate = new DateTime(date("2019-04-16 19:40:45"));
  $maxStarveDate = date_add($starveDate, date_interval_create_from_date_string("48 hours"));
  $starveDate = date_add($starveDate, date_interval_create_from_date_string("$hours hours"));
  if($starveDate > $maxStarveDate)
    $starveDate = $maxStarveDate;
  return $starveDate->format('Y-m-d H:i:s');
}

 ?>
