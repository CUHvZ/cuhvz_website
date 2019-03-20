<?php
/*

This file is for creating test users for the users database

*/

define('DBHOST','localhost');
define('DBUSER','cuhvmiwg');
define('DBPASS','Yummybrainz!2');
define('DBNAME','cuhvmiwg_hvz');

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
require('../classes/user.php');
$user = new User($db);

createUser($db,"testuser","Password","test","user","test@gmail.com");
createUser($db,"Admin","Password","test","admin","admin@gmail.com");


function createUser($db,$username,$password,$firstName,$lastName,$email){


	$activasion = md5(uniqid(rand(),true));
	// hash the password
	$hashedpassword = password_hash($password, PASSWORD_BCRYPT);

	try {

		

	// else catch the exception and show the error
	} catch(PDOException $e) {
	    echo $e;
	}
	echo "\n";
}

?>
