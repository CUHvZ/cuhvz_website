<?php


// $input = "00:05:00";
// // $data = strtotime($input);
$date = new DateTime(date('H:i:s', strtotime("00:04:10")));
error_log($date->format('i\m s\s'), 0);
// $date = new DateTime();
$date = (new DateTime())->setTime(0, 5, 0);
error_log($date->format('i\m s\s'), 0);
error_log($date->format('H:i:s'), 0);

// $change = date('H:i', strtotime("00:30"));
//
// $diff = $date-$change;
// error_log($diff, 0);
// $time = new DateTime($data);
// error_log($data->format('%I:%S'),0);


?>
