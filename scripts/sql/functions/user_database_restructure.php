<?php

/*
This code edits the database and splits up the users table

users table
delete columns: activated, resetToken, and resetComplete

create user_stats table
transfer "activated" data from users table if activated=Yes

create tokens table
transfer "activated" tokens to if activated is a token
*/

// drop table users; drop table user_stats; drop table tokens; source users.sql;

$root = $_SERVER["DOCUMENT_ROOT"];
if(empty($root)){
  $root = "/home/josh/cuhvz_website";
}

require $root."/classes/Database.php";

$db = new Database();


$success = createUserStatsTable($db, $root);
$success = $success && createTokensTable($db, $root);
populateUserStatsTable($db);
alterUsers($db);
newWeeklongs($db, $root);

error_log("Done.", 0);

function newWeeklongs($db, $root){
  error_log("deleting and importing new weeklongs table...", 0);
  $drop = "drop table weeklongs";
  $db->executeQuery($drop);
  $query = file_get_contents($root."/scripts/sql/weeklongsNew.sql");
  $data = $db->executeQuery($query);
  if(isset($data["error"]))
    error_log("Error weeklongsNew.sql was not imported", 0);
  else
    error_log("imported weeklongsNew table", 0);
}

function alterUsers($db){
  error_log("altering user table...", 0);
  dropColumn($db, "activated");
  dropColumn($db, "resetToken");
  dropColumn($db, "resetComplete");

  $db->executeQuery("ALTER TABLE users CHANGE firstName first_name varchar(30);");
  $db->executeQuery("ALTER TABLE users CHANGE lastName last_name varchar(30);");
}

function dropColumn($db, $column){
  $dropQuery = "ALTER TABLE users DROP COLUMN $column;";
  if(!isset($db->executeQuery($dropQuery)["error"])){
    error_log("successfully dropped $column column", 0);
  }else{
    error_log("failed to drop $column column", 0);
  }
}

// Create user_stats table
function createUserStatsTable($db, $root){
  $createUserStatsQuery = file_get_contents($root."/scripts/sql/create_tables/createUserStatsTable.sql");
  $resultUserStatsQuery = $db->executeQuery($createUserStatsQuery);
  if(!isset($resultUserStatsQuery["error"])){
    error_log("successfully created user_stats table", 0);
    return true;
  }else{
    error_log("failed to create user_stats table", 0);
    return false;
  }
}

// Create tokens table
function createTokensTable($db, $root){
  $createTokensQuery = file_get_contents($root."/scripts/sql/create_tables/createTokensTable.sql");
  $resultTokensQuery = $db->executeQuery($createTokensQuery);
  if(!isset($resultTokensQuery["error"])){
    error_log("successfully created tokens table", 0);
  }else{
    error_log("failed to create tokens table", 0);
  }
}

// populate user_stats table
function populateUserStatsTable($db){
  error_log("populating user_stats and tokens tables...", 0);
  // get all users
  $getAllPlayersQuery = "select * from users;";
  $allUsers = $db->executeQueryFetchAll($getAllPlayersQuery);

  foreach ($allUsers as $user) {
    $userID = $user["id"];
    $activated = ($user["activated"] == "Yes") + 0;
    $insertUserStatsQuery = "insert into user_stats (id, activated) values ($userID, $activated);";
    if($activated == 0){
      addToken($db, $user);
    }

    if(isset($db->executeQuery($insertUserStatsQuery, false)["error"])){
      error_log("FAILED: user id:".$userID."", 0);
    }
  }
}

function addToken($db, $user){
  $userID = $user["id"];
  $activatedToken = $user["activated"];
  $now = (new DateTime(date('Y-m-d H:i:s')))->format('Y-m-d H:i:s');
  $insertTokenQuery = "INSERT INTO tokens (user_id, token, token_type, expiration) VALUES ($userID, '$activatedToken', 'ACTIVATION', '$now' + INTERVAL 1 DAY);";
  $result = $db->executeQuery($insertTokenQuery);
  if(isset($resultTokensQuery["error"])){
    error_log("FAILED: addToken with user id: $userID", 0);
  }
}


?>
