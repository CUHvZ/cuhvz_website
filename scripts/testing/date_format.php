<?php

function addOrdinal($num){
  $lastNum = substr($num, strlen($num)-1, strlen($num));
  $lastNum = intval($lastNum);
  if($lastNum == 1)
    return intval($num)."st";
  else if($lastNum == 2)
    return intval($num)."nd";
  else if($lastNum == 3)
    return intval($num)."rd";
  else
    return intval($num)."th";
}

function formatLockinDates($startDate){
  $monthNames = array(
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  );
  $startDate = new DateTime($startDate);
  $day = $startDate->format('d');
  $day = addOrdinal($day);
  $month = $monthNames[intval($startDate->format('m'))-1];
  $year = $startDate->format('Y');
  return "$month $day $year, 9pm - 3am";
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

error_log(formatLockinDates("2018-03-23"), 0);
error_log(formatLockinDates("2018-11-16"), 0);
error_log(formatLockinDates("2019-04-19"), 0);
?>
