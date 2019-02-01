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
}

//database credentials
define('DBHOST','localhost');
define('DBUSER','cuhvmiwg');
define('DBPASS','Yummybrainz!2');
define('DBNAME','cuhvmiwg_hvz');

//application address
define('DIR','http://cuhvz.com/');
define('SITEEMAIL','cuhvz@cuhvz.com');

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
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
$filter = new StatsFilter(array("username", "memberID"));
$test = $filter->matchDataSet($data);
//print_r($test);

foreach($data as $human){

	$points = $human["points"];
	if($points == null){
		$points = 0;
	}
	echo $human["username"]." ".$points."\n";
}





/*
$table = "weeklongTest";
try{
	$stmt = $db->prepare("SELECT * FROM ".$table.";");
	$stmt->execute();
	$data = $stmt->fetchAll();
	print_r($data);
	foreach ($data as $value) {
  	echo implode(" ", $value);
	}
}catch(PDOException $e){
	echo "database not found";
}

$stmt = $db->prepare('show columns from '.$table.';');
$stmt->execute();
$fieldData = $stmt->fetchAll();
$fields = [];
foreach ($fieldData as $value) {
	array_push($fields,$value["Field"]);
}

// $stmt = $db->prepare('select * from '.$table.';');
// $stmt->execute();
// $data = $stmt->fetchAll();

$fp = fopen('weeklongTest.csv', 'w');
fputcsv($fp, $fields);
foreach ($data as $line) {
	$data_line = [];
	foreach ($fields as $key) {
		array_push($data_line, $line[$key]);
	}
  fputcsv($fp, $data_line);

}

fclose($fp);
*/
?>
