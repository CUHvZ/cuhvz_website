<!DOCTYPE html>
<html lang="en">
<?php
require('includes/config.php');
$title = 'CU HvZ | Events';
?>
<head>
	<?php require('layout/header.php'); ?>
</head>
<body>
	<?php include 'layout/navbar.php'; ?>


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

?>



<div class="lightslide">

 <div class="container">

  <div class="row">

      <div class="content lightslide-box">
            <!-- Upcoming
            <h1 class='white' ><strong>Upcoming Event</strong></h1>
            <div class='white'>
            </div> -->
            <!-- Weeklongs -->
            <h1 class='white' ><strong>Weeklongs</strong></h1>
						<div>
							An HvZ weeklong is a whole-campus game of zombie tag. During a single week, players play the game alongside attending classes and carrying out their lives. But the game is only played outside 8:00-5:00. Starting as a human player, you will do your best to avoid being tagged by zombie players while also completing mission objectives. In short: you will try to survive the week.
							<br/><br/>
							Players are marked by a bandana, provided by us. Human players wear their bandana on their arm. Zombie players wear their bandana on their forehead. Game moderators will be marked by two bandanas. When you are zombified, you move your bandana from your arm to your head. You are now a zombie.
							<br/><br/>
							For a list of the complete rules visit the <a href="/rules.php">rules page</a>
						</div>
						<hr/>
            <?php
						$database = new Database();
						$weeklongs = $database->executeQueryFetchAll("SELECT * FROM weeklongs WHERE display=1 ORDER BY start_date DESC");
                  foreach ($weeklongs as $event) {
                        echo "<div class='white'>";
                        echo "<h4 class='title-link' style='margin: 0;'><a href='weeklong/info.php?id=".$event["id"]."'>".$event["title"]."</a></h4>";
												if($event["display"]){
													if($weeklong->is_active($event["id"])){ // Displays if event options
														$weeklongID = $_SESSION["weeklong_id"];
														if($user->is_logged_in()){
											        $signupLink = "/profile.php?joinEvent=$weeklongID";
											      }else{
											        $signupLink = "/signup.php?joinEvent=$weeklongID";
											      }
											      if(!$_SESSION["started"]){
											        echo "<h4 style='margin: 0;'><a href='$signupLink'>Join Now!</a></h4>";
											      }else{
											        $startDate = new DateTime(date($_SESSION["start_date"]));
											        $lateStartDate = $startDate->format('Y-m-d')." 17:00:00";
											        $currentTime = new DateTime(date('Y-m-d H:i:s'));
											        $lateStartDate = new DateTime(date($lateStartDate));
											        // error_log($lateStartDate->format('Y-m-d H:i:s'), 0);
											        if($currentTime < $lateStartDate){
											          $signupLink = $signupLink."&late=human";
											          echo "<h5 style='margin: 0;'><a href='$signupLink'>Late to the game? Hurry up and join now!</a></h5>";
											        }else{
											          // $signupLink = $signupLink."&late=zombie";
											          // echo "<h5 style='margin: 0;'><a href='$signupLink'>Late to the game? Join now and start as a zombie</a></h5>";
											        }
											      }
                            // echo "</h3>";
	                        }
	                        echo "<p>".$event["display_dates"]." | ";
	                        echo "<a href='weeklong/info.php?id=".$event["id"]."' >mission details</a> | ";
	                        echo "<a href='weeklong/stats.php?id=".$event["id"]."' >stats</a></p>";
	                        echo "</div>";
												}
											}
            ?>
            <!-- Lockins -->
            <h1 class='white' ><strong>Lock-Ins</strong></h1>
						<div>
							An HvZ lock-in is a huge game of zombie tag that occurs in the Engineering center about once a semester, usually the friday before spring or fall break. The night usually consists of 2 rounds. In these rounds there will be a couple of people that start off as zombies that are trying to turn all of the humans into zombies. The humans meanwhile are attempting to complete a mission before they are all zombified. If the humans complete this mission they win. If all of the humans are zombified before they can complete their mission the zombies win. Zombies can turn humans by tagging them, humans can defend themselves with nerf blaster or sock bombs.
						</div>
						<br/>
						<div>
							Check-in begins at 9 pm and doors close at 10 pm. Make sure to arrive to the event before doors closing, we are not allowed to let anyone in after that. There is parking available in the engineering parking structure and the C4C parking lot. <a href='/images/where-to-park.png' target='_blank'>Where to park.</a>
						</div>
						<br/>
						<div>
							Need a map of the engineering center?
							<br/>
							<a href='/images/ec-maps/basement.png' target='_blank'>Basement</a> |
							<a href='/images/ec-maps/first-floor.png' target='_blank'>1st floor</a> |
							<a href='/images/ec-maps/second-floor.png' target='_blank'>2nd floor</a> |
							<a href='/images/ec-maps/printable.pdf' target='_blank'>Full map</a> |
							<a href='/images/ec-maps/printable-single-sheet.pdf' target='_blank'>Full map (single page)</a>
						</div>
						<hr/>
            <?php
							$lockins = $database->executeQueryFetchAll("SELECT * FROM lockins WHERE display=1 ORDER BY event_date DESC");
              foreach ($lockins as $event) {
								$lockinID = $event["id"];
								$lockinTitle = $event["title"];
								$lockinDate = formatLockinDates($event["event_date"]);
								$waiverLink = $event["waiver_link_path"];
								$active = $event["active"];
                echo "<div class='white'>";
								echo "<h4 class='title-link' style='margin: 0;'><a href='/lockin/info.php?id=$lockinID'>$lockinTitle</a></h3>";
								echo "<p>$lockinDate | <a href='$waiverLink' target='_blank'>Waiver</a>";
								if($active){
									$eventbriteLink = $event["eventbrite"];
									$blasterLink = $event["blaster_eventbrite"];
									echo " | <a href='$eventbriteLink' target='_blank'>Tickets</a>";
									echo " | <a href='$blasterLink' target='_blank'>Blaster Rental</a>";
								}
								echo "</p>";
                echo "</div>";
              }
            ?>
      </div>
  </div> <!-- end row -->

 </div> <!-- end container -->

</div> <!-- end signup section -->

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<?php
if(Weeklong::active_event()){
  require('weeklong/clock.php');
}
// include footer template
require('layout/footer.php');
?>
</body>
</html>
