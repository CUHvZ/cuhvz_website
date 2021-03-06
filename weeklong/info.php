<!DOCTYPE html>
<html lang="en">
<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
$title = 'CU HvZ | ';
?>
<head>
	<?php require($_SERVER['DOCUMENT_ROOT'].'/layout/header.php'); ?>
	<script src="/js/tabs-3.0.js"></script>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/layout/navbar.php'; ?>
<script src="/js/dataFormatter_v2.js"></script>
<script>
function formatTabContent(divID)
{
	var element = document.getElementById(divID);
	element.innerHTML = formatData(element.innerHTML);
}
$(document).ready(function(){
	// Open Details tab by default
	// openTab('Details');
	// Format the tabs html
	formatTabContent('Details');
	formatTabContent('Monday');
	formatTabContent('Tuesday');
	formatTabContent('Wednesday');
	formatTabContent('Thursday');
	formatTabContent('Friday');
});

</script>


<?php
	function formatInclude($text){
		$start = strpos($text, "INCLUDE[");
		if($start == null || $start == ""){
			return $text;
		}
		$temp = substr($text, $start);
		$end = strpos($temp, "]");
		$include = substr($temp, 0, $end);
		$include = str_replace("INCLUDE[", "", $include);
		$includeFile = file_get_contents($_SERVER['DOCUMENT_ROOT']."/weeklong/include/".$include);
		return str_replace("INCLUDE[$include]", $includeFile, $text);
	}
?>
<div id="signup" class="lightslide">

 <div class="container">

  <div class="row">

	<!-- SIGNUP BOX -->
      <div class="content lightslide-box">
        <?php
				$db = new Database();
				// These 2 queries allow php to recieve special characters from mysql
				$db->executeQuery('SET NAMES UTF8;');
				$db->executeQuery('SET COLLATION_CONNECTION=utf8_general_ci;');

				$weeklongID = null;
				$weeklongDetails = null;
				$weeklongStarted = false;
				if(isset($_SESSION["started"])){
					$weeklongStarted = $_SESSION["started"];
				}
        if(isset($_GET["id"])){
					$weeklongID = $_GET["id"];

					$query = "select * from weeklong_details where weeklong_id=$weeklongID;";
					$weeklongDetails = $db->executeQueryFetch($query);

					$event = $db->executeQueryFetch("SELECT * FROM weeklongs where id=$weeklongID;");
          echo "<h3 class='title-link' style='margin: 0;'><a href='/weeklong/info.php?id=$weeklongID'>".$event["title"]."</a></h3>";
          echo "<span>".$event["display_dates"].", ".substr($event["start_date"],0,4)." | ";
          	echo "<a href='/weeklong/stats.php?id=$weeklongID' >Stats</a> | ";
          	echo "<a href='".$weeklongDetails["waiver_link_path"]."' target='_blank'>Waiver</a>";
						if($weeklongStarted && $user->is_logged_in() && $user->is_in_event($event["name"])){
							echo " | <a href='/entercode.php' >Enter Code</a>";
							$weeklongName = $event["name"];
							$userID = $_SESSION['id'];
							$data = $db->executeQueryFetch("select status from $weeklongName where user_id=$userID");
							if($data["status"] == "zombie"){
								echo " | <a href='/logkill.php' >Log Kill</a>";
							}
						}
					echo "</span>";
        }
        if($weeklong->is_active($event["id"])){ // Displays if event options
					if($weeklongStarted){
						$weeklongID = $_SESSION["weeklong_id"];
						$startDate = $_SESSION["start_date"];
						$currentTime = new DateTime(date('Y-m-d H:i:s'));
						// Set deadlne to 9am + 8 hours = 5pm
						$lateSignupDeadline = date_add($startDate, date_interval_create_from_date_string("8 hours"));
						if($currentTime < $lateSignupDeadline){
							// Not passed 5pm yet
	            if(!$user->is_logged_in()){
	                  if(!$user->is_in_event($event["name"])){
											echo "<br/>";
											echo "<span>";
													echo "Late to the game? <a href='/login.php?joinEvent=$weeklongID'' >Join Now!</a>";
											echo "</span>";
	                  }
	            }else{
								echo "<br/>";
								echo "<span>";
										echo "Late to the game? <a href='/profile.php?joinEvent=$weeklongID'' >Join Now!</a>";
								echo "</span>";
	            }
						}
					}else{
						if(!$user->is_in_event($event["name"])){
							echo "<br/>";
							echo "<span>";
								echo "Wanna play in this event?";
								echo "<h3 style='margin: 0;'>";
									echo "<a href='/profile.php?joinEvent=$weeklongID'' >Join Now!</a>";
								echo "</h3>";
							echo "</span>";
						}
	        }
        }
				?>
      	<div class="white">
        </div>
			<div style="margin: auto; text-align: center;">
	 	 		<span class="tab">
	 	 			<button class="tablink small-tab active" id="Details-tab-button" onclick="openTab('Details')">Details</button>
				</span>
	 	 		<span class="tab">
	 	 			<button class="tablink small-tab" id="Monday-tab-button" onclick="openTab('Monday')">Monday</button>
	 	 		</span>
	 	 		<span class="tab">
	 			<button class="tablink small-tab" id="Tuesday-tab-button" onclick="openTab('Tuesday')">Tuesday</button>
	 	 		</span>
	 	 		<span class="tab">
	 			<button class="tablink small-tab" id="Wednesday-tab-button" onclick="openTab('Wednesday')">Wednesday</button>
	 	 		</span>
	 	 		<span class="tab">
	 			<button class="tablink small-tab" id="Thursday-tab-button" onclick="openTab('Thursday')">Thursday</button>
	 	 		</span>
	 	 		<span class="tab">
	 			<button class="tablink small-tab" id="Friday-tab-button" onclick="openTab('Friday')">Friday</button>
	 	 		</span>
	 	 	</div>

	 		<div id="tab-container">
	 		 	<div id="Details" class="tabcontent" style="display: block">
					<?php
						if($weeklongDetails != null){
							echo $weeklongDetails["details"];
						}
					?>
	 		 	</div>

	 		 	<div id="Monday" class="tabcontent">
					<?php
						if($weeklongDetails != null){
							echo formatInclude($weeklongDetails["monday"]);
						}
					?>
	 		 	</div>

	 			<div id="Tuesday" class="tabcontent">
					<?php
						echo formatInclude($weeklongDetails["tuesday"]);
					?>
	 		 	</div>

	 		 	<div id="Wednesday" class="tabcontent">
					<?php
						if($weeklongDetails != null){
							echo formatInclude($weeklongDetails["wednesday"]);
						}
					?>
	 		 	</div>

	 		 	<div id="Thursday" class="tabcontent">
					<?php
						if($weeklongDetails != null){
							echo formatInclude($weeklongDetails["thursday"]);
						}
					?>
	 		 	</div>

	 			<div id="Friday" class="tabcontent">
					<?php
						if($weeklongDetails != null){
							echo formatInclude($weeklongDetails["friday"]);
						}
					?>
	 		 	</div>
	 		</div>
  </div> <!-- end row -->

 </div> <!-- end container -->

</div> <!-- end signup section -->

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<br><br>

<?php
if(Weeklong::active_event()){
  include($_SERVER['DOCUMENT_ROOT'].'/weeklong/clock.php');
}
// include footer template
require($_SERVER['DOCUMENT_ROOT'].'/layout/footer.php');
?>

</body>
</html>
