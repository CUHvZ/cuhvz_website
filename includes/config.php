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

//weeklong table in database
define("WEEKLONG","weeklongS18");
$WEEKLONG = 'weeklongS18';

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
include('classes/user.php');
include('classes/phpmailer/mail.php');
include('classes/weeklong.php');
$user = new User($db);
$weeklong = new Weeklong($db);
if($weeklong->is_active()){
  $weeklong->set_variables();
}

?>