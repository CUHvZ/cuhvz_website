<!DOCTYPE html>
<html lang="en">
<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
$title = 'CU HvZ | ';
?>
<head>
	<?php require($_SERVER['DOCUMENT_ROOT'].'/layout/header.php'); ?>
	<script src="/js/dataFormatter.js"></script>
	<script>
	function formatContent(divID)
	{
		var element = document.getElementById(divID);
		element.innerHTML = formatData(element.innerHTML);
	}
	$(document).ready(function(){
		formatContent('Details');
	});

	</script>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/layout/navbar.php'; ?>

<?php
function addOrdinal($num){
  $lastNum = substr($num, strlen($num)-1, strlen($num));
  $lastNum = intval($lastNum);
  if($lastNum == 1)
    return intval($num)."st";
  else if($lastNum == 2)
    return intval($num)."nd";
  else if($lastNum == 3)
    return intval($num)."rd";
  else
    return intval($num)."th";
}

function formatLockinDates($startDate){
  $monthNames = array(
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  );
  $startDate = new DateTime($startDate);
  $day = $startDate->format('d');
  $day = addOrdinal($day);
  $month = $monthNames[intval($startDate->format('m'))-1];
  $year = $startDate->format('Y');
  return "$month $day $year, 9pm - 3am";
}
// $detail_directory = $_SERVER['DOCUMENT_ROOT'].'/lockin/details';
$lockinID = 0;
$lockinTitle = "";
$lockinDate = "";
$database = new Database();
// These 2 queries allow php to recieve special characters from mysql
$database->executeQuery('SET NAMES UTF8;');
$database->executeQuery('SET COLLATION_CONNECTION=utf8_general_ci;');
$details = "";
$waiverLink = "";
$active = false;
if(isset($_GET["id"])){
	$lockinID = $_GET["id"];
	$data = $database->executeQueryFetch("SELECT * FROM lockins WHERE id=$lockinID");
	$lockinTitle = $data["title"];
	$lockinDate = formatLockinDates($data["event_date"]);
	$details = $data["details"];
	$waiverLink = $data["waiver_link_path"];
	$active = $data["active"];
}

?>

<div id="signup" class="lightslide">

 <div class="container">

  <div class="row">
      <div class="content lightslide-box">
        <div class="white">
          <?php
            // include $detail_directory.'/'.$lockinName.'/title.php';
						echo "<h4 class='title-link' style='margin: 0;'><a href='/lockin/info.php?id=$lockinID'>$lockinTitle</a></h3>";
					  echo "<p>";
							echo "$lockinDate | <a href='$waiverLink' target='_blank'>Waiver</a>";
							if($active){
								$eventbriteLink = $data["eventbrite"];
								$blasterLink = $data["blaster_eventbrite"];
								echo " | <a href='$eventbriteLink' target='_blank'>Tickets</a>";
								echo " | <a href='$blasterLink' target='_blank'>Blaster Rental</a>";
							}
						echo "<br>Doors open at 9pm and close at 10pm</p>";
          ?>
        </div>
				<div id="Details">
          <?php
            echo $details;
          ?>
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


</body>
</html>
