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
$data = null;
try {
	$stmt = $db->prepare("SELECT * FROM users;");
	$stmt->execute();
	$data = $stmt->fetchAll();
	//print_r($temp);

} catch(PDOException $e) {
		echo 'error getting players';
}

foreach ($data as $playerData) {
	$playerID = $playerData['id'];
	try {
		$stmt = $db->prepare("insert into user_stats (id, activated) values ($playerID, true);");
		$stmt->execute();
		echo "added ".$playerData["username"]."\n";
		//print_r($temp);

	} catch(PDOException $e) {
			echo "error inserting player ".$playerData['username']."\n";
	}
}

?>
