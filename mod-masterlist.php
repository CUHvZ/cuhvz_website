<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'HVZ CU BOULDER';

//include header template
require('layout/header.php'); 

?>

<!-- FEED ZOMBIE SELECTION TABLE -->

<!-- NAVIGATION INCLUDE -->
<nav class="fixed-nav-bar">

<a href="mod/index.php" class="rightborder">Mod Portal</a>

<a href="mod-emailer" class="rightborder">Email List</a>

<a href="mod-masterlist.php#vaccine" class="rightborder">Vaccine List</a>

<a href="mod-masterlist.php#players" class="rightborder">Gamer List</a>

  <a href="logout.php" class="leftborder">Log out</a>
  <a href="profile.php" class="leftborder">Player Portal</a>

</nav>

<!-- NAVIGATION INCLUDE END -->

<!-- ORIENTATION LIST -->

<section class="darkslide" id="orient">
<div class="container">
<div class="row">
<div class="twelve columns">

<div class="subheadline">Orientation</div>

<?php

$countusers = $db->query("SELECT count(1) FROM weeklongF17")->fetchColumn();
$sth = $db->prepare("SELECT orient FROM weeklongF17");
$sth->execute();

/* Fetch all of the values of the first column */
$result = $sth->fetchAll(PDO::FETCH_COLUMN, 0);
//var_dump($result);
//print_r($result);
//print_r(array_count_values($result));
$result = array_replace($result,array_fill_keys(array_keys($result, null),''));
$Session1 = array_count_values($result)['2:00pm'];
$Session2 = array_count_values($result)['2:20pm'];
$Session3 = array_count_values($result)['2:40pm'];

?>

Session 1 (2:00pm): <?php echo $Session1 ?><br>
Session 2 (2:20pm): <?php echo $Session2 ?><br>
Session 3 (2:40pm): <?php echo $Session3 ?><br>

 </div> 
 </div>
 </div>
 </section>


<!-- VACCINE LIST -->

<section class="darkslide" id="vaccine">
<div class="container">
<div class="row">
<div class="twelve columns">

<div class="subheadline">Vaccine List</div>

 <?php
  try {
    $query = "SELECT username, UserHex, status, StarveDate FROM weeklongF17 WHERE status='vaccine' OR status='UsedVaccine' ORDER BY username";

  print "
    
    <table id='table2'>
    <tr class='subheader orange'>
    <th>Username</th>
    <th>User Hex</th>
    <th>Status</th>
    <th class='starve'>Date Used</th>
    </tr>
    
  ";

  $data = $db->query($query);
  $data->setFetchMode(PDO::FETCH_ASSOC);
  foreach($data as $row){
   print " 
      <tr>
   ";
   foreach ($row as $name=>$value){
   print " <td>$value</td>";
   } // end field loop
   print " </tr>";
  } // end record loop
  print "</table>";
  } catch(PDOException $e) {
   echo 'ERROR: ' . $e->getMessage();
  } // end try
 ?>
 </div> <!-- end playerlist list -->
 </div>
 </div>
 </section>

<!-- GAMER LIST -->

<section class="darkslide" id="players">
<div class="container">
<div class="row">
<div class="twelve columns">

<div class="subheadline">Gamer List</div>

 <?php
  try {
    $query = "SELECT username, UserHex, status, KillCount, StarveDate FROM weeklongF17 WHERE status='human' OR status='zombie' OR status='deceased' ORDER BY StarveDate DESC";

  print "
    
    <table id='table1'>
    <tr class='subheader orange'>
    <th onclick='sortTable(0)'>Username</th>
    <th onclick='sortTable(1)'>User Hex</th>
    <th onclick='sortTable(2)'>Status</th>
    <th onclick='sortTable(3)'>Kill Count</th>
    <th onclick='sortTable(4)' class='starve'>Starve Date</th>
    </tr>
    
  ";

  $data = $db->query($query);
  $data->setFetchMode(PDO::FETCH_ASSOC);
  foreach($data as $row){
   print " 
      <tr>
   ";
   foreach ($row as $name=>$value){
   print " <td>$value</td>";
   } // end field loop
   print " </tr>";
  } // end record loop
  print "</table>";
  } catch(PDOException $e) {
   echo 'ERROR: ' . $e->getMessage();
  } // end try
 ?>
 </div> <!-- end playerlist list -->
 </div>
 </div>
 </section>

<script src="js/sort.js"></script>
</body>
</html>