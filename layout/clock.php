<?php
  $countusers = $db->query("SELECT count(1) FROM weeklongF17 WHERE status='human' OR status='zombie' OR status='deceased'")->fetchColumn();
?>
 

<!-- WEEKLONG SECTION -->
<div class="darkslide">
  <div class="container center">

    <div class="row">
      <img src="images/grave.png" class="u-max-full-width">
      <h2 class="section-heading orange">Weeklong Game</h2>
      <h5 class="orange">March 19th - March 23rd</h5>

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

  <div class="row">
    <h2 class="subheadline"><span class="white"><?= $countusers ?> Gamers</span> Playing</h2>
    <p>Wanna play? Be sure to <a href="#">register</a> for the game.</p>
    <img src="images/zombie.png" class="u-max-full-width">
  </div>

 </div> <!-- end container -->

</div>


<script src="js/clock.js"></script>
