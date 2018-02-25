<?php require('includes/config.php');

// define page title
$title = 'CU HvZ | Events';

// include header template
require('layout/header.php');

include 'layout/navbar.php' ?>



<div class="lightslide">

 <div class="container">

  <div class="row">

	<!-- SIGNUP BOX -->
      <div class="content lightslide-box">
      	<table>
      		<tr>
      			<th></th>
      			<th>Title</th>
      			<th>Dates</th>
      			<th>Details</th>
      			<th></th>
      		</tr>
                  <?php
                  foreach ($weeklong->get_weeklongs() as $event) {
                        echo "<tr>";
                        echo "<td width='140px'>";
                        if($weeklong->is_active($event["id"])){ // Displays if event options
                              if($user->is_logged_in()){
                                    if($user->is_in_event($event["name"])){
                                          echo "<a href='/profile.php?leave=".$event["title"]."&eventId=".$event["name"]."'' >Leave event</a></td>";
                                    }else{
                                          echo "<a href='/profile.php?join=".$event["title"]."&eventId=".$event["name"]."'' >Join Now!</a></td>";
                                    }
                              }else{
                                    echo "<a href='/signup.php' >Make an account!</a> or <a href='/login.php' >Log in!</a></td>";
                              }
                              
                        }else{
                              if($event["active"] == 0){
                                  echo "Event has ended</td>"."\n";
                              }else{
                                  echo "Event isn't ready yet</td>"."\n";
                              };
                        }
                        echo "<td><a href='weeklong/info.php?name=".$event["name"]."'>".$event["title"]."</td>"; // Displays the title of the weeklong
                        echo "<td width='135px'>".$event["display_dates"]."</td>"; // Displays the dates for the event
                        echo "<td>".$weeklong->get_short_details($event["name"])."</td>"; // Displays the details of the event
                        echo "<td width='150px'><a href='weeklong/stats.php?name=".$event["name"]."'>View stats</a></td>"; // link to event info page
                        echo "</tr>";
                  }
                  ?>
      	</table>
      </div>
  </div> <!-- end row -->

 </div> <!-- end container -->

</div> <!-- end signup section -->

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<?php
// include footer template
require('layout/footer.php');
?>