
<!-- WEEKLONG SECTION -->
<div class="darkslide">
  <div class="container center">

    <div class="row">
      <img src="/images/grave.png" class="u-max-full-width">
      <h2 class="section-heading orange">
        <?php
          if(isset($_SESSION["title"])){
            $weeklongID = $_SESSION["weeklong_id"];
            $title = $_SESSION["title"];
            echo "<a href='/weeklong/info.php?id=$weeklongID'>$title</a>";
          }
          else
            echo "Weeklong Game";
        ?>
      </h2>
      <h5 class="deeporange">
      <?php
      if(isset($_SESSION["weeklong_dates"]))
      echo $_SESSION["weeklong_dates"];
      ?></h5>
      <br>

      <h5 class="subheader" id="game_state">Gametime Remaining</h5>

      <!-- Countdown Clock -->
      <div id="clockdiv">
        <div class="offset-by-two two columns">
          <span class="clocknumber subheader days">0</span><br>
          <span class="clocklabel">Days</span>
        </div>
        <div class="two columns">
          <span class="clocknumber subheader hours">0</span><br>
          <span class="clocklabel">Hrs</span>
        </div>
        <div class="two columns">
          <span class="clocknumber subheader minutes">0</span><br>
          <span class="clocklabel">Min</span>
        </div>
        <div class="two columns">
          <span class="clocknumber subheader seconds">0</span><br>
          <span class="clocklabel">Sec</span>
        </div>
      </div>
      <!-- End Countdown Clock -->
  </div> <!-- end row -->

  <br><br>

    <div class="row">
      <h2 class="subheadline"><span class="white" id="registered"><?php $countusers ?> Players Registered</span></h2>
      <?php
      // if(!$_SESSION["started"]){
      //   if($user->is_logged_in()){
      //     $signupLink = "/profile.php?joinEvent=$weeklongID";
      //   }else{
      //     $signupLink = "/login.php?joinEvent=$weeklongID";
      //   }
      //   echo "<p><a href='$signupLink'>Wanna play? Be sure to register for the game.</a></p>";
      // }
      $weeklongID = $_SESSION["weeklong_id"];
      $startDate = new DateTime(date($_SESSION["start_date"]));
      $currentTime = new DateTime(date('Y-m-d H:i:s'));
      $userLoggedIn = $user->is_logged_in();
      $userInEvent = false;
      if($userLoggedIn)
        $userInEvent = $user->is_in_event($_SESSION["weeklong"]);
      if($userLoggedIn){
        $signupLink = "/profile.php?joinEvent=$weeklongID";
      }else{
        $signupLink = "/signup.php?joinEvent=$weeklongID";
      }
      if($currentTime < $startDate){
        if(!$userInEvent)
          echo "<p><h5><a href='$signupLink'>Wanna play? Join now!</a></h5></p>";
      }else{
        $lateStartDate = $startDate->format('Y-m-d')." 17:00:00";
        $lateStartDate = new DateTime(date($lateStartDate));
        // error_log($lateStartDate->format('Y-m-d H:i:s'), 0);
        if($currentTime < $lateStartDate && !$userInEvent){
          $signupLink = $signupLink."&late=human";
          echo "<p><a href='$signupLink'>Late to the game? Hurry up and join now!</a></p>";
        }
      }

      ?>
      <img src="/images/zombie-head.png" class="u-max-full-width">
    </div>

   </div> <!-- end container -->

  </div>

 </div> <!-- end container -->

</div>
<?php
  $end_date = $_SESSION["start_date"];
?>
<script src="/js/countdown_1.0.js"></script>
<script>
/*
var end = <?= "\"".$end_date."\"" ?>;
console.log(end);
initializeClock('clockdiv', end);
*/
</script>
