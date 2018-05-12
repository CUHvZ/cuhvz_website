<?php 

require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');


// include header template
require('../layout/header.php');

include $_SERVER['DOCUMENT_ROOT'].'/layout/navbar.php' ?>

<div id="signup" class="lightslide">

 <div class="container">

  <div class="row">

	<!-- SIGNUP BOX -->
      <div class="content lightslide-box">
        <div class="white">
          <h3 class='title-link' style='margin: 0;'><a href='/lockin/info.php'>Close Encounters of the Undead Kind</a></h3>
          <p>March 23, 10pm - 2am</p>
        	<p>
            <a href="https://www.eventbrite.com/e/cu-hvz-close-encounters-of-the-undead-kind-tickets-44082774766?aff=es2" target="_blank">Sign up on the eventbrite to get your ticket!</a>
            <br/>
        		Don't forget to sign and bring your wavier! <br/>
            <a href="/weeklong/weeklongS18/lockin_waiver.pdf" target="_blank" >Close Encounters of the Undead Kind Lock-In waiver</a>
            <br/>
            <strong>Important note to all player under the age of 18:</strong>
            <br>
            Due to rules placed on us that are out of our control we require a parent/guardian to be present to sign your wavier in order to prove that a signature was not forged.
            If your parent cannot be present to sign your wavier you will not be allowed to participate in the lock-in.
        	</p>
        </div>
  </div> <!-- end row -->

 </div> <!-- end container -->

</div> <!-- end signup section -->

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<br><br>

<?php
// include footer template
require($_SERVER['DOCUMENT_ROOT'].'/layout/footer.php');
?>