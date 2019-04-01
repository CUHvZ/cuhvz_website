<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('America/Denver');

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

//include the user class, pass in the database connection
include($_SERVER['DOCUMENT_ROOT'].'/classes/Database.php');
include($_SERVER['DOCUMENT_ROOT'].'/classes/User.php');
include($_SERVER['DOCUMENT_ROOT'].'/classes/phpmailer/Mail.php');
include($_SERVER['DOCUMENT_ROOT'].'/classes/Weeklong.php');
include($_SERVER['DOCUMENT_ROOT'].'/classes/Token.php');
$user = new User($db);
$weeklong = new Weeklong($db);
if(Weeklong::active_event()){
	/*
	if(!$weeklong->is_set()){
		$weeklong->set_active_variables();
	}*/
	$weeklong->set_active_variables();
	$weeklong->check_event_time();
  $weeklong->check_starve_dates();
}

?>
