<?php
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
$table = "weeklongF18";
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
/*
$stmt = $db->prepare('select * from '.$table.';');
$stmt->execute();
$data = $stmt->fetchAll();
*/
$fp = fopen($table.'.csv', 'w');
fputcsv($fp, $fields);
foreach ($data as $line) {
	$data_line = [];
	foreach ($fields as $key) {
		array_push($data_line, $line[$key]);
	}
  fputcsv($fp, $data_line);

}

fclose($fp);

?>
