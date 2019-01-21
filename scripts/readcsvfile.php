<?php
$data = [];
$file = fopen($filename,"r");
$fields = fgetcsv($file);
$counter = 0;
if($file){
  while(!feof($file) && $counter < 1000)
    {
      $counter++;
      $array = fgetcsv($file);
      if(!empty($array)){
        array_push($data, array_combine($fields, $array));
      }
    }
}

fclose($file);
?>
