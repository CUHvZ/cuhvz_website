<?php
  $weeklong_name = $_SESSION['weeklong'];
  $countusers = $db->query("SELECT count(1) FROM $weeklong_name WHERE status='human' OR status='zombie' OR status='zombie(OZ)' OR status='zombie(suicide)' OR status='deceased'")->fetchColumn();
?>


<!-- WEEKLONG SECTION -->
<div class="darkslide">
  <div class="container center">

    <div class="row">
      <img src="/images/grave.png" class="u-max-full-width">
      <h2 class="section-heading orange">Weeklong Game</h2>
      <h5 class="orange">
      <?php
      if(isset($_SESSION["weeklong_dates"]))
      echo $_SESSION["weeklong_dates"];
      ?>
      </h5>

      <h5 class="subheader">Game Begins In...</h5>

      <!-- Countdown Clock -->
      <div id="clockdiv">
        <div class="offset-by-two two columns">
          <span class="clocknumber subheader days"></span><br>
          <span class="clocklabel">Days</span>
        </div>
        <div class="two columns">
          <span class="clocknumber subheader hours"></span><br>
          <span class="clocklabel">Hrs</span>
        </div>
        <div class="two columns">
          <span class="clocknumber subheader minutes"></span><br>
          <span class="clocklabel">Min</span>
        </div>
        <div class="two columns">
          <span class="clocknumber subheader seconds"></span><br>
          <span class="clocklabel">Sec</span>
        </div>
      </div>
      <!-- End Countdown Clock -->
  </div> <!-- end row -->

<br><br>
<?php
$signupLink = "";
if($user->is_logged_in()){
  $signupLink = "'/profile.php?join=".$_SESSION['title']."&eventId=".$_SESSION['weeklong']."'";
}else{
  $signupLink = "'/login.php?join=".$_SESSION['title']."&eventId=".$_SESSION['weeklong']."'";
}
?>

  <div class="row">
    <h2 class="subheadline"><span class="white"><?= $countusers ?> Players Registered</span></h2>
    <p><a href=<?php echo $signupLink; ?>>Wanna play? Be sure to register for the game.</a></p>
    <img src="/images/zombie.png" class="u-max-full-width">
  </div>

 </div> <!-- end container -->

</div>

<?php
  $start_date = $_SESSION["start_date"];
?>

<script src="/js/clock.js"/></script>
<script>
var start = <?= "\"".$start_date."\"" ?>;
initializeClock('clockdiv', start);
</script>
