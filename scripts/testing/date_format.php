<?php

function addOrdinal($num){
  $num = intval($num);
  if($num == 1)
    return $num."st";
  else if($num == 2)
    return $num."nd";
  else if($num == 3)
    return $num."rd";
  else
    return $num."th";
}

function formatWeeklongDates($startDate){
  $monthNames = array(
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  );
  $startDate = new DateTime($startDate);
  $firstDay = $startDate->format('d');
  $firstDay = addOrdinal($firstDay);
  $firstMonth = $monthNames[intval($startDate->format('m'))];
  $year = $startDate->format('Y');

  $endDate = date_add($startDate, date_interval_create_from_date_string('4 days'));
  $endDay = $endDate->format('d');
  $endDay = addOrdinal($endDay);
  $endMonth = $monthNames[intval($endDate->format('m'))];
  if($firstMonth == $endMonth)
    return "$firstMonth $firstDay - $endDay, $year";
  else
    return "$firstMonth $firstDay - $endMonth $endDay, $year";
}

$formattedDates = formatWeeklongDates("2018-09-27 07:00:00");
error_log($formattedDates, 0);

$date = new DateTime("04/15/2019");
$format = $date->format('Y-m-d')." 09:00:00";
error_log($format, 0);
?>
