<script>
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */

function toggleMainMenu() {
    document.getElementById("menu_button").classList.toggle("change");
    document.getElementById("dropdown_menu").classList.toggle("show");
}

function toggleProfileMenu() {
    document.getElementById("profile_dropdown_menu").classList.toggle("show");
}

$(document).ready(function(){

  // Close the dropdown if the user clicks outside of it
  $('body').on('click touchstart', function(e){
    var classes = e.target.className;
    //alert(classes);
    var mainMenuClicked = classes.indexOf("menu-item") & classes.indexOf("bar");
    if (mainMenuClicked == -1) {
      var dropdown = document.getElementById("dropdown_menu");
      if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
      }
      var menu_button = document.getElementById("menu_button");
      if (menu_button.classList.contains('change')) {
        menu_button.classList.remove('change');
      }
    }
    var profileMenuClicked = classes.indexOf("menu-item") & classes.indexOf("profile");
    if (profileMenuClicked == -1) {
      var profileDropdown = document.getElementById("profile_dropdown_menu");
      if (profileDropdown.classList.contains('show')) {
        profileDropdown.classList.remove('show');
      }
      var menu_button = document.getElementById("menu_button");
      if (menu_button.classList.contains('change')) {
        menu_button.classList.remove('change');
      }
    }
  });
})


</script>

<?php

$loginButton = "";
$signUpButton = "";
$profileButton = "";
$logoutButton = "";
$adminButton = "";
$activeEventButton = "";
$showProfileMenu = "display: none;";

$weeklongButton = "";
$statsButton = "";
$codeButton = "";
$killButton = "";

if($user->is_logged_in()){
  $showProfileMenu = "";
  if(Weeklong::active_event()){
    $kys_button_display = "none";
    $logkill_button_display = "none";
    if($user->is_in_event($_SESSION["weeklong"])){
      $weeklongID = $_SESSION["weeklong_id"];
      $weeklongButton = "<a class='menu-item' id='weeklong_button_dropdown' href='/weeklong/info.php?id=$weeklongID'>Weeklong</a>";
      $statsButton = "<a class='menu-item' id='stats_button_dropdown' href='/weeklong/stats.php?id=$weeklongID'>Stats</a>";
      $codeButton = "<a class='menu-item' id='code_button_dropdown' href='/entercode.php'>Enter Code</a>";
      $status = $user->get_game_stats()["status"];
      if($status == "human"){
        // echo "<li><a id='kys_button' href='/kys.php'>Join The Horde</a></li>";
        // echo "<li><a id='code_button' href='/entercode.php'>Code</a></li>";
      }else if($status == "zombie" && $_SESSION["started"]){
        $killButton = "<a class='menu-item' id='log_kill_button_dropdown' href='/logkill.php'>Log Kill</a>";
        // echo "<li><a id='logkill_button' href='/logkill.php'>Log Kill</a></li>";
      }
    }
    // echo "<li style='display: ".$kys_button_display.";'><a id='kys_button' href='/kys.php'>Join The Horde</a></li>";
    // echo "<li style='display: ".$logkill_button_display.";'><a id='logkill_button' href='/logkill.php'>Log Kill</a></li>";
  }
  $logoutButton = "<a class='hideable' style='float: right;' id='logout_button' href='/logout.php'>Logout</a>";
  $profileButton = "<a class='hideable' style='float: right;' id='profile_button' href='/profile.php'>Profile</a>";
  if($user->is_admin()){
    $adminButton = "<a class='hideable' style='float: right;' id='admin_button' href='/admin.php'>Admin</a>";
  }
}else{
  $joinEvent = "";
  if(isset($_GET['joinEvent'])){
    $weeklongID = $_GET["joinEvent"];
    $joinEvent = "?joinEvent=$weeklongID";
  }
  $loginButton = "<a style='float: right;' id='login_button' href='/login.php$joinEvent'>Login</a>";
  $signUpButton = "<a style='float: right;' id='signup_button' href='/signup.php$joinEvent'>Sign Up</a>";
}
?>

<nav>
  <div class="nav-container">
    <a class="hideable" id="index_button" href="/index.php">Home</a>
    <a class="hideable" id="rules_button" href="/rules.php">Rules</a>
    <a class="hideable" id="events_button" href="/events.php">Events</a>
    <?php
      echo $signUpButton;
      echo $loginButton;

      echo $logoutButton;
      echo $profileButton;
      echo $adminButton;
    ?>

    <div id="menu_button" class="menu_button menu-container dropdown-navbar" style="margin-bottom: 0;" onclick="toggleMainMenu()">
      <div class="bar1"></div>
      <div class="bar2"></div>
      <div class="bar3"></div>
      <div class="dropdown-content" id="dropdown_menu" style="left: 0; right: auto;">
        <a class="menu-item" id="index_button_dropdown" href="/index.php">Home</a>
        <a class="menu-item" id="rules_button_dropdown" href="/rules.php">Rules</a>
        <a class="menu-item" id="events_button_dropdown" href="/events.php">Events</a>
      </div>
    </div>
    <div id="profile_menu_button" class="menu_button menu-container dropdown-navbar" onclick="toggleProfileMenu()" style="float: right; <?php echo $showProfileMenu ?>">
      <div class="profile">
        <div class="profile-head"></div>
        <div class="profile-body"></div>
      </div>
      <div class="dropdown-content" id="profile_dropdown_menu" style="right: 0; left: auto;">
        <?php
          if($user->is_logged_in()){
            echo "<a class='menu-item' id='profile_button_dropdown' href='/profile.php'>Profile</a>";
            echo $weeklongButton;
            echo $statsButton;
            echo $codeButton;
            echo $killButton;

            if($user->is_admin()){
              echo  "<a class='menu-item' id='admin_button_dropdown' href='/admin.php'>Admin</a>";
            }
            echo "<a class='menu-item' id='logout_button_dropdown' href='/logout.php'>Logout</a>";
          }
        ?>
      </div>
    </div>

  </div>
</nav>
