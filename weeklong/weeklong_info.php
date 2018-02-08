<!-- WEEKLONG GAME SECTION -->
<section class="darkslide">

  <div class="container center">

    <!-- Start Weeklong Headline Row -->
    <div class="row">
      <!--<img src="images/grave.png" class="u-max-full-width"></p>-->
      <h2 class="section-heading orange">Weeklong Game</h2>
      <h5 class="orange">
      <?php 
      if(isset($_SESSION["weeklong_dates"]))
      echo $_SESSION["weeklong_dates"];
      ?></h5>
      <p class="description">
      You have successfully registered for the CU Boulder Weeklong HvZ game.
      <br>Be sure to look through the <a href="#playerinfo">Player Information</a> before the game.

      <hr>
    </div> <!-- End Weeklong Headline Row -->

    <!-- Start Weeklong Information Row -->
    <div class="row">

      <!-- Start Safety Waiver Column -->
      <div class="offset-by-one four columns">
        <h1 class="label">Safety Waiver</h1>
        <p class="description">Meanwhile, please download and sign the required safety waiver below.
        <strong class="white">Note</strong>: If you are under 18, you must have a parent or guardian sign the waiver.</p>
        <p><a class="button button-primary" href="doc/fa17-weeklong-waiver.pdf" target="_blank">Safety Waiver</a></p>
        <p><strong class="white">Safety waivers will be collected October 26th-28th (Wednesday through Friday) and on Monday, October 30th.</strong> Remember to bring them to us when you collect your bandana!</p>
        <br>
      </div> 
      <!-- End Safety Waiver Column -->

      <!-- Start Orientation Column -->
      <div class="five offset-by-one columns">
        <h1 class="label" id="orientation">Required Orientation</h1>
        <p class="description">All participants are required to take <a href="https://docs.google.com/forms/d/e/1FAIpQLSfQTk1wVTirIy7t_8vzUGqEXgrabPSOY6FRfvOKhewjQRk-yw/viewform" target="_blank">this orientation quiz</a>.</p> 

        <p>HvZ Mods will be collecting waivers and distributing player bandanas to those players at the <strong class="subheader white">UMC between 9:00am and 5:00pm on Monday, October 30th</strong>. You cannot participate without a bandana <strong class="subheader white">provided by us</strong>.</p>

        <p><a class="button button-primary" href="https://docs.google.com/forms/d/e/1FAIpQLSfQTk1wVTirIy7t_8vzUGqEXgrabPSOY6FRfvOKhewjQRk-yw/viewform" target="_blank">Orientation Quiz</a></p>

      </div> <!-- End Orientation Column -->
    </div> <!-- End Information Row -->
  </div> <!-- End container -->
</section> <!-- End section -->