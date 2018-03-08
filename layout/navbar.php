<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction(x) {
    document.getElementById("myDropdown2").classList.toggle("show");
    x.classList.toggle("change");
}

function toggle_menu() {
    document.getElementById("menu_button").classList.toggle("change");
    document.getElementById("dropdown_menu").classList.toggle("show");
}

function shortenWords(){
  var screenWidth = window.matchMedia( "(max-width: 480px)" );
  var button = document.getElementById("kys_button");
  //alert(button.innerText);
  if(screenWidth.matches){
    try{
      button.innerText = "KYS";
    }catch(err){}
    //alert(button.innerText);
  }
}

$(document).ready(function(){
  shortenWords();

  // Close the dropdown if the user clicks outside of it
  $('body').on('click touchstart', function(e){
    var classes = e.target.className;
    //alert(classes);
    var toggle = classes.indexOf("menu_button") & classes.indexOf("bar");
    if (toggle == -1) {
      var dropdown = document.getElementById("dropdown_menu");
      if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
      }
      var menu_button = document.getElementById("menu_button");
      if (menu_button.classList.contains('change')) {
        menu_button.classList.remove('change');
      }
    }
  });
})


</script>

<nav>
  	  <ul>
  	  <li></li>
      <li><a class="hideable" id="index_button" href="/index.php">Home</a></li>
      <li><a class="hideable" id="about_button" href="/about.php">About</a></li>
      <li><a class="hideable" id="mod_team_button" href="/mod_team.php">Mod Team</a></li>
      <li><a class="hideable" id="rules_button" href="/rules.php">Rules</a></li>
      <li><a class="hideable" id="events_button" href="/events.php">Events</a></li>
      <li><a class="hideable" id="media_button" href="/media.php">Media</a></li>
      <!--
      <div class="dropdown navbar">
        <button class="dropbtn" onclick="myFunction(this)">Menu
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="myDropdown2">
          <a id="index_button" href="/index.php">Home</a>
          <a id="about_button" href="/about.php">About</a>
          <a id="mod_team_button" href="/mod_team.php">Mod Team</a>
          <a id="rules_button" href="/rules.php">Rules</a>
          <a id="events_button" href="/events.php">Events</a>
          <a id="media_button" href="/media.php">Media</a>
        </div>
      </div>-->
      <div id="menu_button" class="menu_button menu-container dropdown navbar" onclick="toggle_menu()">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
        <div class="dropdown-content" id="dropdown_menu">
          <a class="menu_button" id="index_button_dropdown" href="/index.php">Home</a>
          <a class="menu_button" id="about_button_dropdown" href="/about.php">About</a>
          <a class="menu_button" id="mod_team_button_dropdown" href="/mod_team.php">Mod Team</a>
          <a class="menu_button" id="rules_button_dropdown" href="/rules.php">Rules</a>
          <a class="menu_button" id="events_button_dropdown" href="/events.php">Events</a>
          <a class="menu_button" id="media_button_dropdown" href="/media.php">Media</a>
        </div>
      </div>
      <?php
      if($user->is_logged_in()){
      	
        if($weeklong->active_event()){
          $kys_button_display = "none";
          $logkill_button_display = "none";
          if($user->is_in_event($_SESSION["weeklong"])){
            $status = $user->get_game_stats()["status"];
            if($status == "human"){
              $kys_button_display = "block";
            }else if(strpos($status, 'zombie') == 0){
              $logkill_button_display = "block";
            }
          }
          echo "<li style='display: ".$kys_button_display.";'><a id='kys_button' href='kys.php'>Join The Horde</a></li>";
          echo "<li style='display: ".$logkill_button_display.";'><a id='logkill_button' href='/logkill.php'>Log Kill</a></li>";
        }
        echo "<li><a style='float: right;' id='logout_button' href='/logout.php'>Logout</a></li>";
        echo "<li><a style='float: right;' id='profile_button' href='/profile.php'>Profile</a></li>";
        if($user->is_admin()){
          echo "<li><a style='float: right;' id='admin_button' href='#'>Admin</a></li>";
        }
      }else{
      	echo "<li><a style='float: right;' id='login_button' href='/login.php'>Login</a></li>";
      	echo "<li><a style='float: right;' id='signup_button' href='/signup.php'>Sign Up</a></li>";
      }
      
      
      ?>
      </ul>
</nav>