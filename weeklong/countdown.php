

<!-- WEEKLONG SECTION -->
<div class="darkslide">
  <div class="container center">

    <div class="row">
      <img src="images/grave.png" class="u-max-full-width">
      <h2 class="section-heading orange">Weeklong Game</h2>
      <h5 class="deeporange">
      <?php 
      if(isset($_SESSION["weeklong_dates"]))
      echo $_SESSION["weeklong_dates"];
      ?></h5>
      <br>

      <h5 class="subheader">Gametime Remaining</h5>
  
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

 </div> <!-- end container -->

</div>




<script src="js/countdown.js"></script>
