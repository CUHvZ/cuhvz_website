<?php 
require('includes/config.php');

// if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

$title = 'HVZ CU Log Kill';

// include header template
require('layout/header.php');

require "layout/navbar.php";
?>

<!-- BEGIN DOCUMENT -->

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

$zombieFeeder = $_SESSION['username'];

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
    $query = "SELECT username, kill_count, starve_date FROM ".$_SESSION['weeklong']." WHERE status='zombie' ORDER BY starve_date;";

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
      <th onclick='sortTable(2)'>Kill Count</th>
      <th onclick='sortTable(3)' class='starve'>Time Remaining Unil Death</th>
      </tr>
      
    ";
    $data=$weeklong->get_zombies();
    //$data = $db->query($query);
    //$data->setFetchMode(PDO::FETCH_ASSOC);
    foreach($data as $row){
      print " 
        <tr class='subheader white'>
        <td class='select'>
        <input type='checkbox' name='check_list[]' value='$row[username]'>";
      echo "<td align='center'>".$row["username"]."</td>";
      echo "<td align='center'>".$row["kill_count"]."</td>";
    $current_time = new DateTime(date('Y-m-d H:i:s'));
    $starve_date = new DateTime(date($row["starve_date"]));
    $time_left = $current_time->diff($starve_date);
    $hours = $time_left->format('%H')+($time_left->format('%a')*24);
    print " <td class='red' align='center'>".$hours.$time_left->format(':%I:%S')."</td>";
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

if (isset($_POST['hex'])){
  $initHex = $_POST['hex'];
  $hex = strtolower($initHex);
  $victim = $weeklong->findVictim($hex);
  $zombieFeedto = $_POST['check_list'];

  if(strcmp($victim, "none") == 0)
  {
      echo "<p class='bg-danger'>Not a valid code.</p><br>";
  }
  else
  {
      $killReg = $weeklong->regKill($victim, $hex);
      if($killReg)
      {
        if($victim == "vaccine"){
          $weeklong->cure_zombie($zombieFeeder);
          header("Location: profile.php?success=2#profile");
        }else{
          $starveUpdate = $weeklong->updateStarve($victim, $zombieFeedto, $zombieFeeder);
          if($starveUpdate)
          {
            //echo implode("','", array_map('trim', $zombieFeedto));
              header("Location: profile.php?success=1#profile");
          }
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