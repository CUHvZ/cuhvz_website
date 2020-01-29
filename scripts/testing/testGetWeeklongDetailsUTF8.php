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

try {
	$stmt = $db->prepare('SET NAMES UTF8;');
	$stmt->execute();
	$stmt = $db->prepare('SET COLLATION_CONNECTION=utf8_general_ci;');
	$stmt->execute();
	$stmt = $db->prepare("SELECT monday FROM weeklong_details where weeklong_id=5;");
	$stmt->execute();
	$temp = $stmt->fetchAll();
	print_r($temp);

} catch(PDOException $e) {
		echo '<p class="bg-danger">'.$e->getMessage().'</p>';
}

?>
