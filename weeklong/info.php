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
function getQueryVariable(variable)
{
  var weeklongName = <?php echo "'".$_GET["name"]."'"?>;
  return(weeklongName);
}
function formatData(data){
  // adds <br> tags where there are line breaks
  var formated = "";
  var eachLine = data.split('\n');
  for(var i = 0, l = eachLine.length; i < l; i++) {
      formated += eachLine[i]+"<br>";
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
  return formated;
}

function setContent(dataSource, divID)
{
  var XMLHttpRequestObject = false;

  if (window.XMLHttpRequest) {
    XMLHttpRequestObject = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
  }

  if(XMLHttpRequestObject) {
    var obj = document.getElementById(divID);
    XMLHttpRequestObject.open("GET", dataSource);

    XMLHttpRequestObject.onreadystatechange = function()
    {
      if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
        var data = XMLHttpRequestObject.responseText;
        obj.innerHTML = formatData(data);

      }
    }

    XMLHttpRequestObject.send(null);
  }
}
$(document).ready(function(){
	var weeklong = getQueryVariable("name");
	var active = 0<?php if(Weeklong::active_event()){ echo "+1"; } ?>;
  var page = "#events_button";
  //$(page).attr("class", "active");
	if(!weeklong && active){
		weeklong = <?php echo '"'.$_SESSION["weeklong"].'"';?>;
    console.log(weeklong);
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
		setContent(weeklong+"/monday.txt","monday");
		setContent(weeklong+"/tuesday_2.txt","tuesday");
		setContent(weeklong+"/wednesday_2.txt","wednesday");
		setContent(weeklong+"/thursday_2.txt","thursday");
		setContent(weeklong+"/friday_2.txt","friday");
	}
	openTab(event, 'Details');
});
</script>

<div id="signup" class="lightslide">

 <div class="container">

  <div class="row">

	<!-- SIGNUP BOX -->
      <div class="content lightslide-box">
        <?php
          if(isset($_GET["name"])){
            $event = $weeklong->get_weeklong($_GET["name"]);
            echo "<h3 class='title-link' style='margin: 0;'><a href='/weeklong/info.php?name=".$event["name"]."'>".$event["title"]."</a></h3>";
            echo "<p>".$event["display_dates"].", ".substr($event["start_date"],0,4)." | ";
            echo "<a href='/weeklong/stats.php?name=".$event["name"]."' >stats</a></p>";
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
        	<p id="details">
        		There is currently no active game. <a href="/events.php">Click here</a> to go back to the events page.
        	</p>
	 		 	</div>

	 		 	<div id="Monday" class="tabcontent">
          <p id="monday"></p>
          <h5>On Campus</h5><p id="on_campus_1"></p>
          <h5>Off Campus</h5><p id="off_campus_1"></p>
	 		 	</div>

	 			<div id="Tuesday" class="tabcontent">
					<p id="tuesday"></p>
					<h5>On Campus</h5><p id="on_campus_2"></p>
					<h5>Off Campus</h5><p id="off_campus_2"></p>
	 		 	</div>

	 		 	<div id="Wednesday" class="tabcontent">
					<p id="wednesday"></p>
					<h5>On Campus</h5><p id="on_campus_3"></p>
					<h5>Off Campus</h5><p id="off_campus_3"></p>
	 		 	</div>

	 		 	<div id="Thursday" class="tabcontent">
					<p id="thursday"></p>
					<h5>On Campus</h5><p id="on_campus_4"></p>
					<h5>Off Campus</h5><p id="off_campus_4"></p>
	 		 	</div>

	 			<div id="Friday" class="tabcontent">
					<p id="friday"></p>
					<h5>On Campus</h5><p id="on_campus_5"></p>
					<h5>Off Campus</h5><p id="off_campus_5"></p>
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
