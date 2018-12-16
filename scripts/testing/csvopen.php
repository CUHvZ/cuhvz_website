<?php
$data = [];
$file = fopen($filename,"r");
$fields = fgetcsv($file);
while(! feof($file))
  {
    $array = fgetcsv($file);
    if(!empty($array)){
      array_push($data, array_combine($fields, $array));
    }
  }
fclose($file);
//print_r($data);
?>
