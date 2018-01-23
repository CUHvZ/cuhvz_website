<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'HVZ CU BOULDER';

//include header template
require('layout/header.php'); 

// get logged in user info
$username = $_SESSION['username'];

?>

<!-- FEED ZOMBIE SELECTION TABLE -->

<!-- NAVIGATION INCLUDE -->
<?php
  $stmt = $db->prepare("SELECT * FROM weeklongF17 WHERE username='$username'"); 
  $stmt->execute(); 
  $row = $stmt->fetch();

  if($row['status'] == 'human'){
     require('layout/navbar-human.php');
  } else {
  require('layout/navbar-zombie.php');
  }

?>

<!-- NAVIGATION INCLUDE END -->

<!-- GAME TIME COUNTDOWN SECTION
___________________________________________-->

<?php require('countdown.php'); ?>

<!-- END GAME TIME COUNTDOWN SECTION -->


<section class="darkslide" id="logkill"><center>
<div class="container">
<div class="row">
<div class="twelve columns">

<div class="section-heading">Game Stats</div>

<hr>

<?php

$countusers = $db->query("SELECT count(1) FROM weeklongF17")->fetchColumn();
$sth = $db->prepare("SELECT status FROM weeklongF17");
$sth->execute();

/* Fetch all of the values of the first column */
$result = $sth->fetchAll(PDO::FETCH_COLUMN, 0);
//var_dump($result);
//print_r($result);
//print_r(array_count_values($result));
$TotalHuman = array_count_values($result)['human'];
$TotalZombie = array_count_values($result)['zombie'];
$TotalDeceased = array_count_values($result)['deceased'];

?>


<table class="gamestats">
  <thead>
  <tr class='subheader orange'>
    <th>Total Humans</th>
    <th>Total Zombies</th>
    <th>Total Deceased</th>
  </tr>
</thead>

<tbody>
<tr>
<td class="section-heading"><?php echo $TotalHuman ?></td>
<td class="section-heading"><?php echo $TotalZombie ?></td>
<td class="section-heading"><?php echo $TotalDeceased ?></td>
</tr>
</tbody>

</table>

</div>
</div>
</div>
</center>
</section>




<section class="darkslide" id="logkill"><center>
<div class="container">
<div class="row">
<div class="twelve columns">

<div class="section-heading">Gamer List</div>

<hr>

 <?php
  try {
    $query = "SELECT username, status, KillCount, StarveDate FROM weeklongF17 WHERE status = 'human' OR status = 'zombie' OR status = 'deceased' ORDER BY StarveDate DESC";

  print "
    
    <table id='table1'>
    <tr class='subheader orange'>
    <th onclick='sortTable(0)'>Username</th>
    <th onclick='sortTable(1)'>Status</th>
    <th onclick='sortTable(2)'>Kill Count</th>
    <th onclick='sortTable(3)' class='starve'>Starve Date</th>
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
 </center>
 </section>

<script src="js/sort.js"></script>

</body>
</html>



