<?php 

require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');


// include header template
require('../layout/header.php');

include $_SERVER['DOCUMENT_ROOT'].'/layout/navbar.php' ?>

<script>
function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}
function setContent(file,id)
{
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, false);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                var allText = rawFile.responseText;
                document.getElementById(id).innerHTML = allText;
            }
        }
    }
    //rawFile.send(null);
}
$(document).ready(function(){
	var weeklong = getQueryVariable("name");
	var active = 0<?php if($weeklong->active_event()){ echo "+1"; } ?>;
  var page = "#events_button";
  $(page).attr("class", "active");
	if(!weeklong && active){
		weeklong = <?php echo '"'.$_SESSION["weeklong"].'"';?>;
	}
	if(weeklong.length>1){
		setContent(weeklong+"/details.txt","details"); 
		setContent(weeklong+"/on_campus_1.txt","on_campus_1"); 
		setContent(weeklong+"/on_campus_2.txt","on_campus_2"); 
		setContent(weeklong+"/on_campus_3.txt","on_campus_3"); 
		setContent(weeklong+"/on_campus_4.txt","on_campus_4"); 
		setContent(weeklong+"/on_campus_5.txt","on_campus_5"); 
		setContent(weeklong+"/off_campus_1.txt","off_campus_1"); 
		setContent(weeklong+"/off_campus_2.txt","off_campus_2"); 
		setContent(weeklong+"/off_campus_3.txt","off_campus_3"); 
		setContent(weeklong+"/off_campus_4.txt","off_campus_4"); 
		setContent(weeklong+"/off_campus_5.txt","off_campus_5"); 
	}
});
</script>

<div id="signup" class="lightslide">

 <div class="container">

  <div class="row">

	<!-- SIGNUP BOX -->
      <div class="content lightslide-box">
      	<div class="white">
          <h3>Details</h3>
        	<p id="details">
        		There is currently no active game. <a href="/events.php">Click here</a> to go back to the events page.
        	</p>
        </div>
        <div class="white">
          <h3><strong>Monday</strong></h3>
          <h5>On Campus</h5><p id="on_campus_1"></p>
          <h5>Off Campus</h5><p id="off_campus_1"></p>
        </div>        
        <div class="white">
          <h3><strong>Tuesday</strong></h3>
          <h5>On Campus</h5><p id="on_campus_2"></p>
          <h5>Off Campus</h5><p id="off_campus_2"></p>
        </div>
        <div class="white">
          <h3><strong>Wednesday</strong></h3>
          <h5>On Campus</h5><p id="on_campus_3"></p>
          <h5>Off Campus</h5><p id="off_campus_3"></p>
        </div>
        <div class="white">
          <h3><strong>Thursday</strong></h3>
          <h5>On Campus</h5><p id="on_campus_4"></p>
          <h5>Off Campus</h5><p id="off_campus_4"></p>
        </div>
        <div class="white">
          <h3><strong>Friday</strong></h3>
          <h5>On Campus</h5><p id="on_campus_5"></p>
          <h5>Off Campus</h5><p id="off_campus_5"></p>
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