<?php

$root = $_SERVER["DOCUMENT_ROOT"];
if(empty($root)){
  $root = "/home/josh/cuhvz_website";
}

require $root."/classes/Database.php";

//$lines = include($root."/scripts/sql/old_tables/users.sql");

$db = new Database();

$query = file_get_contents($root."/scripts/sql/old_tables/users.sql");
$data = $db->executeQuery($query);
if(isset($data["error"]))
  error_log("Error. users.sql was not imported", 0);
else
  error_log("imported users table", 0);

?>
