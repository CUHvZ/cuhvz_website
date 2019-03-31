<?php

$root = $_SERVER["DOCUMENT_ROOT"];
if(empty($root)){
  $root = "/home/josh/cuhvz_website";
}

require $root."/classes/Database.php";

$db = new Database();
$db->suppressErrors();

$users = "describe users;";
$data = $db->executeQuery($users);
if(!isset($data["error"])){
  $dropUsers = "drop table users";
  $data = $db->executeQuery($dropUsers);
  if(isset($data["error"])){
    error_log("error dropping users table", 0);
  }else{
    error_log("Dropped table users", 0);
  }
}
else{
  error_log("users table does not exist", 0);
}

$tokens = "describe tokens;";
$data = $db->executeQuery($tokens);
if(!isset($data["error"])){
  $dropTokens = "drop table tokens";
  $data = $db->executeQuery($dropTokens);
  if(isset($data["error"])){
    error_log("error dropping users tokens", 0);
  }else{
    error_log("Dropped table tokens", 0);
  }
}
else{
  error_log("tokens table does not exist", 0);
}

$user_stats = "describe user_stats;";
$data = $db->executeQuery($user_stats);
if(!isset($data["error"])){
  $dropUserStats = "drop table user_stats";
  $data = $db->executeQuery($dropUserStats);
  if(isset($data["error"])){
    error_log("error dropping users tokens", 0);
  }else{
    error_log("Dropped table tokens", 0);
  }
}
else{
  error_log("tokens table does not exist", 0);
}

?>
