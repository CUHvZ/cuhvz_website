<!DOCTYPE html>
<html lang="en">
<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
$title = 'CU HvZ | ';
?>
<head>
	<?php require($_SERVER['DOCUMENT_ROOT'].'/layout/header.php'); ?>

  <style>
  .paginater{
    display: inline;
  }
  .page-link{
      text-decoration: none;
      text-align: center;
      margin: 5px;
      padding: 10px;
      display: inline-block;
  }

  .page-link:hover{
    background-color: rgba(234, 123, 0, 0.4);
    transition: 0.3s;
  }
  .active {
    background-color: rgb(234, 123, 0);
  }
  .page-link:visited, .page-link:link{
    text-decoration: none;
    color: black;
  }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
  $.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 4,
            showPrevNext: false,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);

    var listElement = $this;
    var perPage = settings.perPage;
    var children = listElement.children();
    var pager = $('.pager');

    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }

    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }

    var numItems = children.length;
    var numPages = Math.ceil(numItems/perPage);

    pager.data("curr",0);

    if (settings.showPrevNext){
        $('<li class="paginater"><a href="#" class="prev_link page-link">«</a></li>').appendTo(pager);
    }

    var curr = 0;
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li class="paginater"><a href="#" class="page_link page-link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }

    if (settings.showPrevNext){
        $('<li class="paginater"><a href="#" class="next_link page-link">»</a></li>').appendTo(pager);
    }

    //pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
    //console.log(pager.children().eq(1));
    //console.log(pager.children().eq(1).children());
    //pager.children().eq(1).addClass("active");
    pager.children().eq(1).children().addClass("active");

    children.hide();
    children.slice(0, perPage).show();

    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });

    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }

    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }

    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;

        children.css('display','none').slice(startAt, endOn).show();

        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }

        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }

        pager.data("curr",page);
        pager.children().children().removeClass("active");
        pager.children().eq(page+1).children().addClass("active");

    }
  };

  $(document).ready(function(){

  $('#data').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:4});
  $('#human-table').pageMe({pagerSelector:'#human-table-pager',showPrevNext:true,hidePageNumbers:false,perPage:10});

  });
  /*
  paginate(id){
  $('#'+id).after('<div id="nav'+id+'"></div>');
  var rowsShown = 4;
  var rowsTotal = $('#'+id+' tbody tr').length;
  var numPages = rowsTotal/rowsShown;
  for(var i = 0;i < numPages;i++) {
      var pageNum = i + 1;
      $('#nav'+id).append('<a href="#" rel="'+i+'">'+pageNum+'</a> ');
  }
  $('#'+id+' tbody tr').hide();
  $('#'+id+' tbody tr').slice(0, rowsShown).show();
  $('#nav'+id+' a:first').addClass('active');
  $('#nav'+id+' a').bind('click', function(){

      $('#nav'+id+' a').removeClass('active');
      $(this).addClass('active');
      var currPage = $(this).attr('rel');
      var startItem = currPage * rowsShown;
      var endItem = startItem + rowsShown;
      $('#'+id+' tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).css('display','table-row').animate({opacity:1}, 300);
  });
  }*/
  function sortTable(id, index) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById(id);
    //console.log(table);
    switching = true;
    dir = table.value;
    //Set the sorting direction to ascending:
    if(dir == null)
      dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    counter = 0;
    while (switching && counter < 10000) {
      counter++;
      //start by saying: no switching is done:
      switching = false;
      rows = table.getElementsByTagName("tr");
      /*Loop through all table rows (except the
      first, which contains table headers):*/
      for (i = 0; i < (rows.length - 1); i++) {
        //start by saying there should be no switching:
        shouldSwitch = false;
        /*Get the two elements you want to compare,
        one from current row and one from the next:*/
        x = rows[i].getElementsByTagName("TD")[index];
        y = rows[i + 1].getElementsByTagName("TD")[index];
        rows[i].style.display = 'none';
        /*check if the two rows should switch place,
        based on the direction, asc or desc:*/
        //console.log(x);
        //console.log(y);
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /*If a switch has been marked, make the switch
        and mark that a switch has been done:*/
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        //Each time a switch is done, increase this count by 1:
        switchcount ++;
      } else {
        /*If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again.*/
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
    for(i=0; i<10; i++){
      rows[i].style.display = '';
    }
    paginator = document.getElementById(id+"-pager");
    links = paginator.getElementsByTagName("li");
    for(i=0;i<links.length;i++){
      //links[i].className = "paginater";
      links[i].firstChild.className = "page_link page-link";
    }
    //paginator.getElementsByTagName("li")[1].className = "paginater active";
    //console.log(paginator.getElementsByTagName("li"));
    //console.log(paginator.getElementsByTagName("li")[1].firstChild);
    //paginator.getElementsByTagName("li")[1].getElementsByTagName("a")[1].className = "page_link page-link active";
    paginator.getElementsByTagName("li")[1].firstChild.className = "page_link page-link active";
    if(counter == 10000)
      console.log("counter limit reached")
    if(dir == "asc")
      table.value = "desc";
    else if(dir == "desc")
      table.value = "asc";
  }
  </script>

</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/layout/navbar.php'; ?>


<?php

function getZombieType($status){
  if($status == "zombie"){
    return "regular";
  }else if($status == "zombie(suicide)"){
    return "suicide";
  }else if($status == "zombie(OZ)"){
    return "OZ";
  }
}
?>



<div class="lightslide">

  <div class="player_container">

    <div class="content lightslide-list" style="overflow: auto;">
      <div class="stats-header orange">Player Statistics</div>
      <div><!-- class="statistics"-->
        <?php
          $displayStats = false;
          if(isset($_GET["name"])){
            $name = $_GET["name"];
            if($weeklong->get_weeklong($name)){
              $displayStats = true;
              echo "<p class='status-header'>";
              echo "Humans: ".sizeof($weeklong->get_humans_from($name));
              echo " &emsp; Zombies: ".sizeof($weeklong->get_zombies_from($name));
              echo " &emsp; Deceased: ".sizeof($weeklong->get_deceased_from($name));
              echo "</p>";
            }
          }
        ?>
        <div style="margin: auto; text-align: center;">
          <span class="tab">
            <button class="tablink active" onclick="openTab(event, 'Humans')">Humans</button>
            <button class="tablink" onclick="openTab(event, 'Zombies')">Zombies</button>
          </span>
          <span class="tab">
            <button class="tablink" onclick="openTab(event, 'Deceased')">Deceased</button>
            <button class="tablink" onclick="openTab(event, 'Activity')">Activity</button>
          </span>
        </div>

        <div id="Humans" class="tabcontent" style="display: block;">
          <h3 class="row-header">Humans</h3>
          <table class="stats-row stats-table">
            <thead>
              <tr class='table-hide-mobile add-line'>
                <th onclick="sortTable('human-table', 0)">Username</th>
                <th>Points</th>
                <th>Starve Timer</th>
              </tr>
              <tr class='table-show-mobile'>
                <th colspan="2">Username</th>
              </tr>
              <tr class="add-line table-show-mobile">
                <th>Points</th>
                <th>Starve Timer</th>
              </tr>
            </thead>
            <tbody id="human-table">
            <?php
              if($displayStats){
                $data=$weeklong->get_humans_from($name);
                foreach($data as $human){
                  $starve_date = new DateTime(date($human["starve_date"]));
                  $current_time = new DateTime(date('Y-m-d H:i:s'));
                  $end_time = new DateTime(date($weeklong->get_weeklong($name)["end_date"]));
                  if($current_time > $end_time){
                    $current_time = $end_time;
                  }
                  $time_left = $current_time->diff($starve_date);
                  $hours = $time_left->format('%H')+($time_left->format('%a')*24);
                  $formatTime = $hours.$time_left->format(':%I:%S');
                  $points = $human["points"];
                  if($points == null){
                    $points = 0;
                  }
                  echo "<tr class='table-hide-mobile add-line'>"."\n";
                  echo "<td>".$human["username"]."</td>"."\n";
                  echo "<td>".$points."</td>"."\n";
                  echo "<td class='red'>".$formatTime."</td>"."\n";
                  echo "</tr>"."\n";
                  /*
                  echo "<tr class='table-show-mobile'>"."\n";
                  echo "<td colspan='2'>".$human["username"]."</td>"."\n";
                  echo "</tr>"."\n";

                  echo "<tr class='table-show-mobile add-line'>"."\n";
                  echo "<td>".$points."</td>"."\n";
                  echo "<td class='red'>".$formatTime."</td>"."\n";
                  echo "</tr>"."\n";
                  */
                }
              }
            ?>
          </tbody>
          </table>
          <div class="col-md-12 text-center">
            <ul class="pagination pagination-lg pager" id="human-table-pager"></ul>
          </div>
        </div>

        <div id="Zombies" class="tabcontent">
          <h3 class="row-header">Zombies</h3>
          <table class="stats-row stats-table" id="zombie-table">
            <tbody>
              <tr class='add-line table-hide-mobile'>
                <th>Username</th>
                <th>Type</th>
                <th>Kills</th>
                <th style="line-height: 1.2em;">Starve Timer</th>
                <th>Points</th>
              </tr>
              <tr class='table-show-mobile'>
                <th colspan="2">Username</th>
                <th>Kills</th>
              </tr>
              <tr class="add-line table-show-mobile">
                <th>Starve Timer</th>
                <th>Type</th>
                <th>Points</th>
              </tr>
              <?php
              $data=$weeklong->get_zombies_from($name);
                if($displayStats && $data != null){
                  $data=$weeklong->get_zombies_from($name);
                  foreach($data as $zombie){
                    $status = getZombieType($zombie["status"]);
                    $starve_date = new DateTime(date($zombie["starve_date"]));
                    $current_time = new DateTime(date('Y-m-d H:i:s'));
                    $end_time = new DateTime(date($weeklong->get_weeklong($name)["end_date"]));
                    if($current_time > $end_time){
                      $current_time = $end_time;
                    }
                    $time_left = $current_time->diff($starve_date);
                    $hours = $time_left->format('%H')+($time_left->format('%a')*24);
                    $formatTime = $hours.$time_left->format(':%I:%S');
                    $points = $zombie["points"];
                    if($points == null){
                      $points = 0;
                    }
                    echo "<tr class='table-hide-mobile add-line'>";
                    echo "<td>".$zombie["username"]."</td>";
                    echo "<td>".$status."</td>";
                    echo "<td>".($zombie["kill_count"]+0)."</td>";
                    echo "<td class='red'>".$formatTime."</td>";
                    echo "<td>".$points."</td>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile'>";
                    echo "<td colspan='2'>".$zombie["username"]."</td>";
                    echo "<td>".($zombie["kill_count"]+0)."</td>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile add-line'>";
                    echo "<td class='red'>".$formatTime."</td>";
                    echo "<td>".$status."</td>";
                    echo "<td>".$points."</td>";
                    echo "</tr>";
                  }
                }
              ?>
            </tbody>
          </table>
        </div>

        <div id="Deceased" class="tabcontent">
          <h3 class="row-header">Deceased</h3>
          <table class="stats-row stats-table" id="dead-table">
            <tr class='table-hide-mobile'>
              <th>Username</th>
              <th>Starved</th>
              <th>Kills</th>
              <th>Points</th>
            </tr>
            <tr class='table-show-mobile'>
              <th>Username</th>
              <th>Kills</th>
            </tr>
            <tr class="add-line table-show-mobile">
              <th>Starved</th>
              <th>Points</th>
            </tr>
            <?php
              $data=$weeklong->get_deceased_from($name);
              if($displayStats && $data!=null){
                //$data=$weeklong->get_deceased_from($name);
                foreach($data as $dead){
                    $starve_date = new DateTime(date($dead["starve_date"]));
                    $formatTime = $starve_date->format('H:i m-d-Y');
                    $points = $dead["points"];
                    if($points == null){
                      $points = 0;
                    }
                    echo "<tr class='table-hide-mobile add-line'>";
                    echo "<td>".$dead["username"]."</td>";
                    echo "<td class='red'>".$formatTime."</td>";
                    echo "<td>".($dead["kill_count"])."</td>";
                    echo "<td>".$points."</td>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile'>";
                    echo "<td>".$dead["username"]."</td>";
                    echo "<td>".($zombie["kill_count"]+0)."</td>";
                    echo "</tr>";

                    echo "<tr class='table-show-mobile add-line'>";
                    echo "<td class='red'>".$formatTime."</td>";
                    echo "<td>".$points."</td>";
                    echo "</tr>";
                }
              }
            ?>
          </table>
        </div>

        <div id="Activity" class="tabcontent">
          <h3 class="row-header">Activity</h3>
          <table class="stats-row stats-table">
            <tr class='table-hide-mobile'>
              <th></th>
              <th>Activity</th>
              <th></th>
              <th>Time</th>
            </tr>
            <tr class='table-show-mobile'>
              <th>Activity</th>
            </tr>
            <tr class='table-show-mobile add-line'>
              <th>Time</th>
            </tr>
            <?php
              $data=$weeklong->get_activity($name);
              if($data == null){
                $filename = $_SERVER['DOCUMENT_ROOT']."/weeklong/".$name."/stats.csv";
                include_once($_SERVER['DOCUMENT_ROOT']."/scripts/readcsvfile.php");
              }
              foreach($data as $activity){
                $user_1 = $user->get_user_username($activity["user_1"]);
                $action = $activity["action"];
                $user_2 = $user->get_user_username($activity["user_2"]);
                $time = $activity["time"];
                echo "<tr class='table-hide-mobile'>";
                echo "<td>".$user_1."</td>";
                echo "<td>".$action."</td>";
                echo "<td>".$user_2."</td>";
                echo "<td>".$time."</td>";
                echo "</tr>";

                echo "<tr class='table-show-mobile'><td>".$user_1."</td></tr>";
                echo "<tr class='table-show-mobile'><td>".$action."</td></tr>";
                if($user_2 != null)
                  echo "<tr class='table-show-mobile'><td>".$user_2."</td></tr>";
                echo "<tr class='table-show-mobile'><td>".$time."</td></tr>";
              }
            ?>
          </table>
        </div>

        <script src="/js/tabs.js"></script>

      </div>
    </div>

  </div> <!-- end container -->

</div> <!-- end signup section -->

<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

<!--<script src="/js/sort.js"></script>-->
<?php
// insert clock
if($weeklong->active_event()){
  require('clock.php');
}

// include footer template
require($_SERVER['DOCUMENT_ROOT'].'/layout/footer.php');
?>



</body>
</html>
