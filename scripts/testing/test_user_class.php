<?php

require "/home/josh/cuhvz_website/classes/user.php";

try {
	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

$user = new user($db);
$loggedIn = $user->login("Tester", "Password");
if($loggedIn){
  print_r("user successfully logged in \n");

  testIsActivated($user);




}else{
  print_r("user was not logged in \n");
}

function testIsActivated($user){
  $temp = $user->is_activated();
  print_r("is_activated returned: $temp \n");
}

?>
