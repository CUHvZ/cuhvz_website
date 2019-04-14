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
error_log($formatTime, 0);



 ?>
