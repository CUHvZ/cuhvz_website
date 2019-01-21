<!DOCTYPE html>
<html lang="en">
<?php
require('includes/config.php');
$title = 'CU Boulder HvZ';
?>
<head>
	<?php require('layout/header.php'); ?>
</head>
<body>
	<?php include 'layout/navbar.php'; ?>

<div id="signup" class="lightslide">

 <div class="container">

  <div class="row">

	<!-- HEADLINE -->
      <div class="five columns">
      <h1 class="section-heading">Humans
      <span class="white">versus</span> Zombies</h1>
      <h2 class="grey subheader">University of Colorado <strong class="deeporange">Boulder</strong></h2>
      <img src="images/skull.png" class="u-max-full-width">
    </div> <!-- end headline -->

	<!-- SIGNUP BOX -->
      <div class="six columns lightslide-box">
        <h5>
          Humans vs Zombies is a modified tag game in which students use Nerf blasters, tactics, and teamwork to survive a mock zombie apocalypse. Once tagged by a zombie player, the human becomes a zombie. The nerf equipment is used to stun and temporarily disable the oncoming zombie threat. Humans vs Zombies at CU Boulder is an organization that hold large scale events where CU students, alumni, and students from other schools can gather and survive the apocalypse together.
        </h5>



 </div> <!-- end container -->

</div> <!-- end signup section -->

<br><br>

</div>
<script>

$(document).ready(function() {
  openFile("file.csv");
});

function openFile(fileName){
  $.ajax({
      type: "GET",
      url: fileName,
      dataType: "text",
      success: function(data) {processData(data);}
   });
}

function processData(allText) {
  var allTextLines = allText.split(/\r\n|\n/);
  var headers = allTextLines[0].split(',');
  var lines = [];

  for (var i=1; i<allTextLines.length; i++) {
  		var data = allTextLines[i].split(',');
  		if (data.length == headers.length) {

  				var tarr = [];
  				for (var j=0; j<headers.length; j++) {
  						tarr[headers[j]] = data[j];
  				}
  				lines.push(tarr);
  		}
  }

  console.log(lines);
}
</script>
<!--<script src="js/slider.js"></script>-->

<?php
// insert clock
if($weeklong->active_event()){
	require('weeklong/clock.php');
}
?>


<?php
// include footer template
require('layout/footer.php');
?>
</body>
</html>
