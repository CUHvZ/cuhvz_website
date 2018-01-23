<?php require('includes/config.php');

// if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

// define page title
$title = 'HVZ CU BOULDER';

// include header template
require('layout/header.php');
?>

<!-- BEGIN DOCUMENT -->

<!-- NAVIGATION INCLUDE -->
<?php
require('layout/navbar-zombie.php'); 
?>

<!-- HVZ HEADLINE SECTION -->

<section class="lightslide contentwithnav">

 <div class="container">
  <div class="row">

    <!-- Start HVZ Headline Columns -->
    
    <div class="two columns">
      <img src="images/skull.png" class="u-max-full-width">
    </div>

    <div class="ten columns">

      <p class="grey subheader">
        University of Colorado <strong>Boulder</strong>
      </p>

      <h1 class="section-heading deepgrey">
        Humans <span class="white">versus</span> Zombies
      </h1>

      <p class="grey subheader">
      <!-- XXX decoration, temporary -->
      <span class="deeporange">&#10006; &#10006; &#10006;</span>
      <!-- Welcome user -->
      Welcome, <?php echo $_SESSION['username']; ?>.
      <!-- Logout Option -->
      <a class="grey" href='logout.php'>(Logout)</a>
      <!-- XXX decoration, temporary -->
      <span class="deeporange">&#10006; &#10006; &#10006;</span>
      </p>

    </div> 

    <!-- End headline columns -->
  
  </div> <!-- end row -->

  </div> <!-- end container -->

</section> 

<!-- END HVZ HEADLINE SECTION -->

<!-- START KILLHUMAN.PHP -->

<?php

// DATABASE CONNECTION INFORMATION
// DATABASE CONNECTION INFORMATION
$host = "server122.web-hosting.com";
$user = "cuhvmiwg";
$passwd = "Yummybrainz!2";
$dbname = "cuhvmiwg_hvz";
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die ("could not connect to server");

$zombieFeeder = $_SESSION['username'];

// CHECKS IF HEX MATCHES SOMETHING IN DATABASE AND RETURNS THE VICTIM'S EMAIL
function findVictim($cxn, $hex)
{
    $query_rng = "SELECT * FROM weeklongF17";
    $result_rng = mysqli_query($cxn,$query_rng) or die ("could not execute query_rng");
    $victim = "none";

    if(!empty($result_rng))
    {
        while ($row_rng = mysqli_fetch_array($result_rng))
        {
            $tempUsername = $row_rng['username'];
            $tempHex = $row_rng['UserHex'];
            if(strcmp($hex, $tempHex) == 0)
            {
                $victim = $tempUsername;
            }
        }
    }
    
    return $victim;
}

// REGISTERS A KILL FOR A HUMAN
// Takes victim's email address
function regKill($cxn, $victim)
{
    // CHECK STATUS
    $query_status = "SELECT * FROM weeklongF17 WHERE username='$victim'";
    $result_status = mysqli_query($cxn,$query_status) or die ("could not execute query_status");
    $row_status = mysqli_fetch_array($result_status);
    $status = $row_status['status'];
    
    if(strcmp($status, "human") == 0)
    {
        $query_updateKill = "UPDATE weeklongF17 SET status='zombie' WHERE username='$victim'"; // CHANGE BACK TO 'ZOMBIE' AFTER TESTING
        $result_updateKill = mysqli_query($cxn,$query_updateKill) or die ("could not execute query_updateKill");
        return TRUE;
    }
    if(strcmp($status, "vaccine") == 0)
    {
        $query_updateKill = "UPDATE weeklongF17 SET status='usedVaccine' WHERE username='$victim'"; // CHANGE BACK TO 'ZOMBIE' AFTER TESTING
        $result_updateKill = mysqli_query($cxn,$query_updateKill) or die ("could not execute query_updateKill");
        return TRUE;
    }
    else
    {
        echo "<p class='bg-danger'>The system does not recognize this person as a human. Check with an admin if this seems to be incorrect.</p>";
        return FALSE;
    }
}

?>

<!-- END KILLHUMAN.PHP -->


<!-- FEED ZOMBIE SELECTION TABLE -->

<section class="darkslide" id="logkill">
<div class="container">
<div class="row">
<div class="twelve columns">

<div class="subheadline orange">So you killed a human? Bravo.</div><br>

 <?php
  try {
    $query = "SELECT username, status, KillCount, StarveDate FROM weeklongF17 WHERE status='zombie'";

  print "
    <form action='#' method='post' id='feedzombie'>
    <div class='subheader white'>Input Victim User code:</div> <input type='text' name='hex' required>

    <BR><BR>

    <h2 class='subheader white'>Select zombies to feed:</h2>
    <P>Choose up to three (3) zombies to feed. Click the table headers to sort.
    <br>
    <strong>Remember to select yourself if you wanna eat!</strong></p>
    
    <div id='playerlist' class='playerlist' data-max-answers='3'>
    
    <table id='table1' class='feedzombiestable'>
    <tr class='subheader orange'>
    <th class='select'>Select</th>
    <th onclick='sortTable(1)'>Username</th>
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
      <td class='select'>
      <input type='checkbox' name='check_list[]' value='$row[username]'>
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


<BR><BR>

 

<?php 

if (isset($_POST['check_list'])) 
{
  $initHex = $_POST['hex'];
  $hex = strtolower($initHex);
  $victim = findVictim($cxn, $hex);
  $zombieFeedto = $_POST['check_list'];


// UPDATES STARVE DATES
// Takes victim's and zombie's email address
function updateStarve($cxn, $victim, $zombieFeedto, $zombieFeeder)
{
    date_default_timezone_set('America/Denver');
    
    $currTime = date('Y-m-d H:i:s');
    
    // GET NEW STARVE TIME
    $twoHrFut_Str = strtotime("$currTime +2 days");
    $twoHrFut_Unix = date('Y-m-d H:i', $twoHrFut_Str);
    $targetTime = date('Y-m-d H:i:s', strtotime($twoHrFut_Unix));
    
    // STARVE TIMER FOR ZOMBIE
    $query_updateZombieStarve = "UPDATE weeklongF17 SET StarveDate='$targetTime' WHERE username IN('" . implode("','", array_map('trim', $zombieFeedto)) ."')";
    $result_updateZombieStarve = mysqli_query($cxn,$query_updateZombieStarve) or die ("could not execute query_updateZombieStarve");
    
    $query_killRow = "SELECT * FROM weeklongF17 WHERE username='$zombieFeeder'";
    $result_killRow = mysqli_query($cxn,$query_killRow) or die ("could not execute query_killRow");
    $row_killRow = mysqli_fetch_array($result_killRow);
    $currKill = $row_killRow['KillCount'];
    
    $newKill = $currKill + 1;
    $query_updateKill = "UPDATE weeklongF17 SET KillCount='$newKill' WHERE username='$zombieFeeder'";
    $result_updateKill = mysqli_query($cxn,$query_updateKill) or die ("could not execute query_updateKill");
    
    // STARVE TIMER FOR HUMAN-NOW-ZOMBIE
    $query_newZombieStarve = "UPDATE weeklongF17 SET StarveDate='$targetTime' WHERE username = '$victim'";
    $result_newZombieStarve = mysqli_query($cxn,$query_newZombieStarve) or die ("could not execute query_newZombieStarve");
    
    return TRUE;
}


if(strcmp($victim, "none") == 0)
{
    echo "<p class='bg-danger'>Not a valid code.</p><br>";
}
else
{
    $killReg = regKill($cxn, $victim);
    if($killReg)
    {
        //echo "Kill Registered <br>";
        $starveUpdate = updateStarve($cxn, $victim, $zombieFeedto, $zombieFeeder);
        if($starveUpdate)
        {
            header("Location: profile.php?success=1#profile");
        }
    }
}

}
?>


 <input class="button-primary" type="submit" name="submit" value="Register Kill and Feed" id="submit">
</form>

</div>
</div>
</section>
<!-- END TEST TABLE #2 -->

























  <script src="js/sort.js"></script>

</body>

</html>