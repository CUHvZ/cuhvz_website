<?php

// drop table users; drop table user_stats; drop table tokens; source users.sql;

$root = $_SERVER["DOCUMENT_ROOT"];
if(empty($root)){
  $root = "/home/josh/cuhvz_website/";
}

require $root."/classes/Database.php";

$db = new Database();

createUserStatsTable($db, $root);
createTokensTable($db, $root);
populateUserStatsTable($db);
alterUsers($db);

function alterUsers($db){
  print_r("altering user table...\n");
  dropColumn($db, "activated");
  dropColumn($db, "resetToken");
  dropColumn($db, "resetComplete");

  $db->executeQuery("ALTER TABLE users CHANGE firstName first_name varchar(30);");
  $db->executeQuery("ALTER TABLE users CHANGE lastName last_name varchar(30);");

  print_r("Done.\n");
}

function dropColumn($db, $column){
  $dropQuery = "ALTER TABLE users DROP COLUMN $column;";
  if($db->executeQuery($dropQuery)){
    print_r("successfully dropped $column column\n");
  }else{
    print_r("failed to drop $column column\n");
  }
}

// Create user_stats table
function createUserStatsTable($db, $root){
  $createUserStatsQuery = file_get_contents($root."scripts/sql/createUserStatsTable.sql");
  $resultUserStatsQuery = $db->executeQuery($createUserStatsQuery);
  if($resultUserStatsQuery){
    print_r("successfully created user_stats table\n");
  }else{
    print_r("failed to create user_stats table\n");
  }
}

// Create tokens table
function createTokensTable($db, $root){
  $createTokensQuery = file_get_contents($root."scripts/sql/createTokensTable.sql");
  $resultTokensQuery = $db->executeQuery($createTokensQuery);
  if($resultTokensQuery){
    print_r("successfully created tokens table\n");
  }else{
    print_r("failed to create tokens table\n");
  }
}

// populate user_stats table
function populateUserStatsTable($db){
  print_r("populating user_stats and tokens tables...\n");
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

    if(!$db->executeQuery($insertUserStatsQuery, false)){
      print_r("FAILED: user id:".$userID."\n");
    }
  }
  print_r("Done.\n");
}

function addToken($db, $user){
  $userID = $user["id"];
  $activatedToken = $user["activated"];
  $insertTokenQuery = "INSERT INTO tokens (user_id, token, token_type, expiration) VALUES ($userID, '$activatedToken', 'ACTIVATION', NOW() + INTERVAL 1 DAY);";
  $result = $db->executeQuery($insertTokenQuery);
  if(!$result){
    print_r("FAILED: addToken with user id:".$userID."\n");
  }
}


?>
