<?php 
require('includes/config.php');

// if not logged in redirect to login page
if(!$user->is_logged_in()){ 
  header('Location: login.php'); 
} 
if(!$weeklong->active_event() || !$user->is_in_event($_SESSION["weeklong"]) || $user->get_game_stats()["status"] != "human"){
  header('Location: profile.php'); 
}

$title = 'HVZ CU Log KYS';

// include header template
require('layout/header.php');

require "layout/navbar.php";
?>

<!-- BEGIN DOCUMENT -->

<!-- HVZ HEADLINE SECTION -->

<!-- END HVZ HEADLINE SECTION -->

<!-- START KILLHUMAN.PHP -->

<?php

// DATABASE CONNECTION INFORMATION
// DATABASE CONNECTION INFORMATION
/*
$host = "server122.web-hosting.com";
$user = "cuhvmiwg";
$passwd = "Yummybrainz!2";
$dbname = "cuhvmiwg_hvz";
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die ("could not connect to server");
*/
if(isset($_POST["submit"])){
  $user_hex = $user->get_game_stats()["user_hex"];
  if(strtoupper($user_hex) == strtoupper($_POST["hex"])){
    header('Location: profile.php?kys='.$user_hex);
  }else{
    $error[] = "Input doesn't match your code. ".$user->get_game_stats()["user_hex"];
  }
}

?>

<!-- END KILLHUMAN.PHP -->


<!-- FEED ZOMBIE SELECTION TABLE -->

<section class="darkslide" id="logkill">
  <div class="container">
  <div class="row">
    <div class="twelve columns">
      <div class="subheadline orange">Are you sure you want give yourself up and join the horde?</div><br>
       <form action='' method='post' id='user_code'>
          <?php
          if(isset($error)){
            foreach($error as $error){
              echo '<p class="bg-danger">'.$error.'</p>';
            }
          }
          ?>
          <div class='subheader white'>
            Input your code to confirm:
          </div>
          <div>
            <input type='text' name='hex' required>
          </div>
        <input class="button-primary" type="submit" name="submit" value="KYS" id="submit">
      </form>
    </div>
  </div>
</div>
</section>

<?php
// insert clock

if($weeklong->active_event()){
  if($user->is_in_event($_SESSION["weeklong"])){
    require('weeklong/clock.php');  
  }
}
?>


<?php 
//include header template
require('layout/footer.php'); 
?>