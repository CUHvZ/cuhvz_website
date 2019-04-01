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

// TODO make this not hard coded
$lockin_events = array("fall18", "spring18");

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
                        echo "<h4 class='title-link' style='margin: 0;'><a href='weeklong/info.php?name=".$event["name"]."'>".$event["title"]."</a></h3>";
												if($event["display"]){
													if($weeklong->is_active($event["id"])){ // Displays if event options
	                              //echo "<h3 style='margin: 0;'>";
	                              if($user->is_logged_in()){
	                                    if($user->is_in_event($event["name"])){
	                                          echo "Wanna leave this event?<h3 style='margin: 0;'>";
	                                          echo "<a href='/profile.php?leave=".$event["title"]."&eventId=".$event["name"]."' >Leave event</a>";
	                                    }else{
	                                          echo "Wanna play in this event?<h3 style='margin: 0;'>";
	                                          echo "<a href='/profile.php?join=".$event["title"]."&eventId=".$event["name"]."' >Join Now!</a>";
	                                    }
	                              }else{
	                                    echo "Wanna play in this event?<h3 style='margin: 0;'>";
	                                    echo "<a href='/login.php?join=".$event["title"]."&eventId=".$event["name"]."' >Join Now!</a></td>";
	                              }
	                                    echo "</h3>";
	                        }else{
	                              if($event["active"] == 0){
	                                     //echo "Event has ended</td>"."\n";
	                              }else{
	                                    echo "Event isn't ready yet</td>"."\n";
	                              }
	                        }
	                        echo "<p>".$event["display_dates"]." | ";
	                        echo "<a href='weeklong/info.php?name=".$event["name"]."' >mission details</a> | ";
	                        echo "<a href='weeklong/stats.php?name=".$event["name"]."' >stats</a></p>";
	                        echo "</div>";
												}
											}
            ?>
            <!-- Lockins -->
            <h1 class='white' ><strong>Lock-Ins</strong></h1>
            <?php
                  foreach ($lockin_events as $eventName) {
                        echo "<div class='white'>";
                        include $_SERVER['DOCUMENT_ROOT'].'/lockin/details/'.$eventName.'/title.php';
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
if($weeklong->active_event()){
  require('weeklong/clock.php');
}
// include footer template
require('layout/footer.php');
?>
</body>
</html>
