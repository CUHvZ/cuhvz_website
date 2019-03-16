<?php

$root = $_SERVER["DOCUMENT_ROOT"];
if(empty($root)){
  $root = "/home/josh/cuhvz_website/";
}

require $root."/classes/user.php";

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
$db = new Database();
$loggedIn = $user->login("Tester", "Password");
if($loggedIn){
  print_r("user successfully logged in \n");

  // testActivateUser($user);
  // testIsActivated($user);




}else{
  print_r("user was not logged in \n");
}

function testActivateUser($user){
  $temp = $user->activateAccount() + 0;
  print_r("activateAccount returned: $temp \n");
}

function testIsActivated($user){
  $temp = $user->is_activated() + 0;
  print_r("is_activated returned: $temp \n");
}

// INSERT INTO tokens (user_id, token, token_type, expiration) VALUES (269, '72195b20868a796a66df194156cb315a', 'ACTIVATION', NOW() + INTERVAL 1 DAY);

?>
