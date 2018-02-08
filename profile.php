<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'HVZ CU BOULDER';

//include header template
require('layout/header.php'); 

?>


<!-- BEGIN DOCUMENT -->

<!-- THE FIRST IS INTERESTING -->

<!-- NAVIGATION INCLUDE -->
<?php
  include "layout/navbar.php";
  /*
  if($row['status'] == 'human'){
     require('layout/navbar-human.php');
  } else {
  require('layout/navbar-zombie.php');
  }
  */
?>
<!-- NAVIGATION INCLUDE -->

<!-- HVZ HEADLINE SECTION 
___________________________________________-->

<section class="lightslide contentwithnav">

 <div class="container">
  <div class="row">
    
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
      <!-- <span class="deeporange">&#10006; &#10006; &#10006;</span> -->
      <!-- Welcome user -->
      Welcome, <?php echo $_SESSION['username']; ?>.
      <!-- Logout Option -->
      <!--(<a href='logout.php'>Logout</a> || <a href="deleteAccount.php">Unregister?</a>)-->
      <!-- XXX decoration, temporary -->
      <!-- <span class="deeporange">&#10006; &#10006; &#10006;</span> -->
      </p>

    </div> 
  
  </div> <!-- end row -->

  </div> <!-- end container -->

</section> 

<!-- END HVZ HEADLINE SECTION -->







<!-- GAME TIME COUNTDOWN SECTION
___________________________________________-->

<!-- <?php /* require('countdown.php'); */ ?> -->

<!-- END GAME TIME COUNTDOWN SECTION -->


<!-- THE SECOND IS RECOMMENDED -->

<!-- PROFILE INFO SECTION
___________________________________________-->

<?php
//include "weeklong/player_stats.php";
?>

<!-- END PROFILE INFO SECTION -->

<?php 
//require('playerinfo.php'); 
?>


<!-- END DOCUMENT -->

<!-- THE LAST IS THE DEATH RATTLE -->


<?php 
//include header template
require('layout/footer.php'); 
?>