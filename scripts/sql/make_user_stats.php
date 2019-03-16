<?php

$root = $_SERVER["DOCUMENT_ROOT"];
if(empty($root)){
  $root = "/home/josh/cuhvz_website/";
}

require $root."/classes/Database.php";

$db = new Database();

// Create user_stats table
$createUserStatsQuery = file_get_contents($root."scripts/sql/createUserStatsTable.sql");
$resultUserStatsQuery = $db->executeQuery($createUserStatsQuery);
if($resultUserStatsQuery){
  print_r("successfully created user_stats table\n");
}else{
  print_r("failed to create user_stats table\n");
}

// Create tokens table
$createTokensQuery = file_get_contents($root."scripts/sql/createTokensTable.sql");
$resultTokensQuery = $db->executeQuery($createTokensQuery);
if($resultTokensQuery){
  print_r("successfully created tokens table\n");
}else{
  print_r("failed to create tokens table\n");
}

populateUserStatsTable($db);

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

    $result = $db->executeQuery($insertUserStatsQuery);
    if(!$result){
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
