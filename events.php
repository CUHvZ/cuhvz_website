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
            <h1 class='white' ><strong>Week Longs</strong></h1>
            <?php
						$database = new Database();
						$weeklongs = $database->executeQueryFetchAll("SELECT * FROM weeklongs WHERE display=1 ORDER BY start_date DESC");
                  foreach ($weeklongs as $event) {
                        echo "<div class='white'>";
                        echo "<h4 class='title-link' style='margin: 0;'><a href='weeklong/info.php?id=".$event["id"]."'>".$event["title"]."</a></h4>";
												if($event["display"]){
													if($weeklong->is_active($event["id"])){ // Displays if event options
	                              //echo "<h3 style='margin: 0;'>";
	                              // if($user->is_logged_in()){
	                              //       if($user->is_in_event($event["name"])){
	                              //             // echo "Wanna leave this event?<h3 style='margin: 0;'>";
	                              //             // echo "<a href='/profile.php?leave=".$event["title"]."&eventId=".$event["name"]."' >Leave event</a>";
	                              //       }else{
																// 					if(!$_SESSION["started"]){
	                              //             echo "Wanna play in this event?<h3 style='margin: 0;'>";
	                              //             echo "<a href='/profile.php?join=".$event["title"]."&eventId=".$event["name"]."' >Join Now!</a>";
																// 					}else{
																// 						// Late to the game? Join now and become a zombie
																// 					}
	                              //       }
	                              // }else{
	                              //       echo "Wanna play in this event?<h3 style='margin: 0;'>";
	                              //       echo "<a href='/login.php?join=".$event["title"]."&eventId=".$event["name"]."' >Join Now!</a></td>";
	                              // }
																if($user->is_logged_in()){
													        $signupLink = "/profile.php?join=".$_SESSION['title']."&eventId=".$_SESSION['weeklong'];
													      }else{
													        $signupLink = "/login.php?join=".$_SESSION['title']."&eventId=".$_SESSION['weeklong'];
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
            <?php
							$lockins = $database->executeQueryFetchAll("SELECT * FROM lockins WHERE display=1 ORDER BY event_date DESC");
              foreach ($lockins as $event) {
								$lockinID = $event["id"];
								$lockinTitle = $event["title"];
								$lockinDate = formatLockinDates($event["event_date"]);
                echo "<div class='white'>";
								echo "<h4 class='title-link' style='margin: 0;'><a href='/lockin/info.php?id=$lockinID'>$lockinTitle</a></h3>";
								echo "<p>$lockinDate</p>";
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
