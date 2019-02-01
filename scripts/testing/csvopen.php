<?php

class StatsFilter {
    private $filterArray;

    function __construct($filterArray) {
      $this->filterArray = $filterArray;
    }

    function filterArray($var)
    {
      return in_array($var, $this->filterArray);
    }

    function matchArray($arrayToFilter) {
      $temp = array_filter($arrayToFilter, array($this, "filterArray"), ARRAY_FILTER_USE_KEY );
      return $temp;
    }

    function matchDataSet($data){
      $temp = [];
      foreach ($data as $entry) {
        array_push($temp, $this->matchArray($entry));
      }
      return $temp;
    }

    function sortOut($arrayToFilter, $type){
      function human($var)
      {
        return($var["status"] == "human");
      }
      function zombie($var)
      {
        $temp = is_numeric(strpos($var["status"], "zombie"));
        return $temp;
      }
      function deceased($var)
      {
        return($var["status"] == "deceased");
      }
      return array_filter($arrayToFilter, $type);
    }
}

$data = [];
$file = fopen("weeklongTest.csv","r");
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
$test = [];
$filter = new StatsFilter(array("username", "memberID", "status"));
$test = $filter->matchDataSet($data);
//print_r($test);

function test_odd($var)
{
  print_r($var);
return($var["status"] == "human");
}

//print_r(array_filter($test,"test_odd"));
$sortOut = $filter->sortOut($test, "deceased");
print_r($sortOut);

// foreach($data as $human){
//   echo json_encode($human).",\n";
// }
?>
