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
	//include($_SERVER['DOCUMENT_ROOT'].'/classes/User.php');
	//$user = new User($db);
for($i = 1; $i<=20; $i++){
	createUser($db,"testuser".$i,"Password","test","user","test".$i."@gmail.com");
	$temp = get_user_hash($db,"testuser".$i);
	//print_r($temp);
	join_event($db,$temp["id"],"testuser".$i);
}
//createUser($db,"testuser","Password","test","user","test@gmail.com");


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

function join_event($db, $user_id, $username){
$user_hex = substr(md5(uniqid(rand(),'')),0,5);
try{
	$stmt = $db->prepare('INSERT INTO weeklongS18 (user_id,username, user_hex) VALUES (:user_id, :username, :user_hex)');
	$stmt->execute(array(
		':user_id' => $user_id,
		':username' => $username,
		':user_hex' => $user_hex ));
	return true;
}catch(PDOException $e) {
	$errorMessage = $e->getMessage();
	if (!strpos($errorMessage, 'Duplicate entry')) { // this will throw out the duplicate error
	    echo '<p class="bg-danger" style="margin: 0;">'.$errorMessage.'</p>';
	    echo "<p class='bg-danger' style='margin: 0;'> &#10003; <strong>Something went wrong tring to sign up for $event!</strong> <br> Try logging out and logging back in. Contact the mod team if this problem continues.</p>";
	}
    return false;
}
}

function get_user_hash($db,$username){
	try {
		$stmt = $db->prepare('SELECT * FROM users WHERE username = :username;');
		$stmt->execute(array('username' => $username));
		return $stmt->fetch();

	} catch(PDOException $e) {
	    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
	}
}
?>
