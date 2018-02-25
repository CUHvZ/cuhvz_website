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

<div class="lightslide">

  <div class="player_container">


    <!-- SIGNUP BOX -->
    <div class="content lightslide-list" style="overflow: auto;">
    <div class="subheadline orange" style="margin-left: 50px; text-align: center; font-size: 50px;">Player Statistics</div><br>
      

      <?php
      if(isset($_GET["name"])){
        $name = $_GET["name"];
        $data=$weeklong->get_humans_from($name);
        echo "
        <div class='border_container human'>
        <table class='humanlist'>
        <tr class='subheader white'><th><h3><strong>Humans: ".sizeof($data)."</strong></h3></th></tr>
        <tr class='subheader orange'>
        <th>Username</th>
        </tr>";
        foreach($data as $row){
          echo "<tr class='subheader white'>";
          echo "<td align='center'>".$row["username"]."</td>";
          //echo "<td align='center'>".$row["kill_count"]."</td>";
          $current_time = new DateTime(date('Y-m-d H:i:s'));
          $starve_date = new DateTime(date($row["starve_date"]));
          $time_left = $current_time->diff($starve_date);
          $hours = $time_left->format('%H')+($time_left->format('%a')*24);
          echo " </tr>";
        }
        echo "</table></div>";
        $data=$weeklong->get_zombies_from($name);        
        echo "
        <div class='border_container zombie'>
        <table class='zombielist'>
          <tr class='subheader white' style='align: center;'><th></th><th><h3><strong>Zombies: ".sizeof($data)."</strong></h3></th></tr>
          <tr class='subheader orange'>
          <th>Username</th>
          <th>Kill Count</th>
          <th>Time Remaining Unil Death</th>";
          foreach($data as $zombie){
            echo "<tr class='subheader white'>";
            echo "<td align='center'>".$zombie["username"]."</td>";
            echo "<td align='center'>".$zombie["kill_count"]."</td>";
            $current_time = new DateTime(date('Y-m-d H:i:s'));
            $starve_date = new DateTime(date($zombie["starve_date"]));
            $time_left = $current_time->diff($starve_date);
            $hours = $time_left->format('%H')+($time_left->format('%a')*24);
            echo " <td class='red' align='center'>".$hours.$time_left->format(':%I:%S')."</td>";
            echo " </tr>";
          }
          echo "</tr>";
        echo "</table></div>";
          $data=$weeklong->get_deceased_from($name);
        echo "
        <div class='deceased'>
        <table class='deadlist'>
          <tr class='subheader white' style='align: center;'><th></th><th><h3><strong>Deceased: ".sizeof($data)."</strong></h3></th></tr>
          <tr class='subheader orange'>
          <th>Username</th>
          <th>Kill Count</th>
          <th class='starve'>Time of Death</th>";
          foreach($data as $dead){
            echo "<tr class='subheader white'>";
            echo "<td align='center'>".$dead["username"]."</td>";
            echo "<td align='center'>".$dead["kill_count"]."</td>";
            $starve_date = new DateTime(date($dead["starve_date"]));
            echo " <td class='red' align='center'>".$starve_date->format('H:i m-d-Y')."</td>";
            echo " </tr>";
          }
          echo "</tr>";
        echo "</table></div>";
      }
      ?>
      </div>

  </div> <!-- end container -->

</div> <!-- end signup section -->

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script src="/js/sort.js"></script>
<?php
// include footer template
require($_SERVER['DOCUMENT_ROOT'].'/layout/footer.php');
?>