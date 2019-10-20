<!DOCTYPE html>
<html lang="en">
<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
$title = 'CU HvZ | ';
?>
<head>
	<?php require($_SERVER['DOCUMENT_ROOT'].'/layout/header.php'); ?>
	<script src="/js/tabs_2.0.js"></script>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/layout/navbar.php'; ?>

<script>

function formatData(data){
  // adds <br> tags where there are line breaks
  var formated = "";
  var eachLine = data.split('\n');
	var leadingWhitespace = true;
  for(var i = 0, l = eachLine.length; i < l; i++) {
			if(eachLine[i].length > 0 && leadingWhitespace){
				leadingWhitespace = false;
				formated = '<div style="white-space: pre-line">';
			}
			if(!leadingWhitespace){
				if(eachLine[i].indexOf("[ON_CAMPUS]") >= 0){
					formated += "<h5>On Campus</h5>";
				}else if(eachLine[i].indexOf("[OFF_CAMPUS]") >= 0){
					formated += "<h5>Off Campus</h5>";
				}else{
					formated += eachLine[i] + "\n";
				}
			}
  }

  // formats LINK[name][link] into an html link
  while(formated.indexOf("LINK[")!=-1){
    var start = formated.indexOf("LINK[")
    var link = formated.substring(start,formated.length);
    var link_name = link.substring(5,link.indexOf("]"));
    var temp = "LINK["+link_name+"][";
    start = formated.indexOf(temp)+temp.length;
    link = formated.substring(start,formated.length);
    link = link.substring(0,link.indexOf("]"));
    var to_replace = "LINK[" + link_name + "][" + link + "]";
    formated = formated.replace(to_replace, "<a href='"+link+"'>"+link_name+"</a>");
  }

	// formats LINK_NEW_TAB[name][link] into an html link
  while(formated.indexOf("LINK_NEW_TAB[")!=-1){
    var start = formated.indexOf("LINK_NEW_TAB[")
    var link = formated.substring(start,formated.length);
    var link_name = link.substring(13,link.indexOf("]"));
    var temp = "LINK_NEW_TAB["+link_name+"][";
    start = formated.indexOf(temp)+temp.length;
    link = formated.substring(start,formated.length);
    link = link.substring(0,link.indexOf("]"));
    var to_replace = "LINK_NEW_TAB[" + link_name + "][" + link + "]";
    formated = formated.replace(to_replace, "<a href='"+link+"' target='_blank' >"+link_name+"</a>");
  }

	// formats IMAGE[alt text][link] into an image
  while(formated.indexOf("IMAGE[")!=-1){
    var start = formated.indexOf("IMAGE[")
    var temp = formated.substring(start,formated.length);
    var imageLink = temp.substring(6,temp.indexOf("]"));
    var to_replace = "IMAGE[" + imageLink + "]";
    formated = formated.replace(to_replace, "<img src='" + imageLink + "' style='width: 100%;'>");
  }

	// Formats [ON_CAMPUS] and [OFF_CAMPUS] tags into headers
	formated = formated.replace("[ON_CAMPUS]", "<h5>On Campus</h5>");
	formated = formated.replace("[OFF_CAMPUS]", "<h5>Off Campus</h5>");

	formated += "</div>";
	console.log(formated);
  return formated;
}

function formatTabContent(divID)
{
	var element = document.getElementById(divID);
	element.innerHTML = formatData(element.innerHTML);
}
$(document).ready(function(){
	// Open Details tab by default
	openTab(event, 'Details');
	// Format the tabs html
	formatTabContent('Details');
	formatTabContent('Monday');
	formatTabContent('Tuesday');
	formatTabContent('Wednesday');
	formatTabContent('Thursday');
	formatTabContent('Friday');
});

</script>

<div id="signup" class="lightslide">

 <div class="container">

  <div class="row">

	<!-- SIGNUP BOX -->
      <div class="content lightslide-box">
        <?php
				$db = new Database();
				$weeklongID = null;
				$weeklongDetails = null;
          if(isset($_GET["id"])){
						$weeklongID = $_GET["id"];

						$query = "select * from weeklong_details where weeklong_id=$weeklongID;";
						$weeklongDetails = $db->executeQueryFetch($query);

						$event = $db->executeQueryFetch("SELECT * FROM weeklongs where id=$weeklongID;");
            echo "<h3 class='title-link' style='margin: 0;'><a href='/weeklong/info.php?name=".$event["name"]."'>".$event["title"]."</a></h3>";
            echo "<p>".$event["display_dates"].", ".substr($event["start_date"],0,4)." | ";
            	echo "<a href='/weeklong/stats.php?name=".$event["name"]."' >stats</a> | ";
            	echo "<a href='".$weeklongDetails["waiver_link_path"]."' target='_blank'>waiver</a>";
						echo "</p>";
          }
          if($weeklong->is_active($event["id"])){ // Displays if event options
						if(isset($_SESSION["started"]) && !$_SESSION["started"]){
	            echo "Wanna play in this event?";
	            echo "<h3 style='margin: 0;'>";
	            if($user->is_logged_in()){
	                  if($user->is_in_event($event["name"])){
	                        // echo "<a href='/profile.php?leave=".$event["title"]."&eventId=".$event["name"]."'' >Leave event</a>";
	                  }else{
	                        echo "<a href='/profile.php?join=".$event["title"]."&eventId=".$event["name"]."'' >Join Now!</a>";
	                  }
	            }else{
	                  echo "<a href='/login.php?join=".$event["title"]."&eventId=".$event["name"]."' >Join Now!</a></td>";
	            }
	            echo "</h3>";
						}

          }else{
            if($event["active"] == 0){
                //echo "Event has ended</td>"."\n";
            }else{
                echo "Event isn't ready yet</td>"."\n";
            }
          }
?>
      	<div class="white">
        </div>
			<div style="margin: auto; text-align: center;">
	 	 		<span class="tab">
	 	 			<button class="tablink small-tab" id="Details-button" onclick="openTab(event, 'Details')">Details</button>
				</span>
	 	 		<span class="tab">
	 	 			<button class="tablink small-tab" id="Monday-button" onclick="openTab(event, 'Monday')">Monday</button>
	 	 		</span>
	 	 		<span class="tab">
	 			<button class="tablink small-tab" id="Tuesday-button" onclick="openTab(event, 'Tuesday')">Tuesday</button>
	 	 		</span>
	 	 		<span class="tab">
	 			<button class="tablink small-tab" id="Wednesday-button" onclick="openTab(event, 'Wednesday')">Wednesday</button>
	 	 		</span>
	 	 		<span class="tab">
	 			<button class="tablink small-tab" id="Thursday-button" onclick="openTab(event, 'Thursday')">Thursday</button>
	 	 		</span>
	 	 		<span class="tab">
	 			<button class="tablink small-tab" id="Friday-button" onclick="openTab(event, 'Friday')">Friday</button>
	 	 		</span>
	 	 	</div>

	 		<div id="tab-container">
	 		 	<div id="Details" class="tabcontent">
					<?php
						if($weeklongDetails != null){
							echo $weeklongDetails["details"];
						}
					?>
	 		 	</div>

	 		 	<div id="Monday" class="tabcontent">
					<?php
						if($weeklongDetails != null){
							echo $weeklongDetails["monday"];
						}
					?>
	 		 	</div>

	 			<div id="Tuesday" class="tabcontent">
					<?php
						if($weeklongDetails != null){
							echo $weeklongDetails["tuesday"];
						}
					?>
	 		 	</div>

	 		 	<div id="Wednesday" class="tabcontent">
					<?php
						if($weeklongDetails != null){
							echo $weeklongDetails["wednesday"];
						}
					?>
	 		 	</div>

	 		 	<div id="Thursday" class="tabcontent">
					<?php
						if($weeklongDetails != null){
							echo $weeklongDetails["thursday"];
						}
					?>
	 		 	</div>

	 			<div id="Friday" class="tabcontent">
					<?php
						if($weeklongDetails != null){
							echo $weeklongDetails["friday"];
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
// include footer template
require($_SERVER['DOCUMENT_ROOT'].'/layout/footer.php');
?>

</body>
</html>
