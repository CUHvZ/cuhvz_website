<nav class="navbar">
  	  <ul>
  	  <li></li>
      <li><a id="index_button" href="/index.php">Home</a></li>
      <li><a id="about_button" href="/about.php">About</a></li>
      <li><a id="mod_team_button" href="/mod_team.php">Mod Team</a></li>
      <li><a id="rules_button" href="/rules.php">Rules</a></li>
      <li><a id="events_button" href="/events.php">Events</a></li>
      <li><a id="media_button" href="/media.php">Media</a></li>
      <?php
      if($user->is_logged_in()){
      	echo "<li class='right-item'><a id='logout_button' href='/logout.php'>Logout</a></li>";
      	echo "<li class='right-item'><a id='profile_button' href='/profile.php'>Profile</a></li>";
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


        if($user->is_admin()){
          echo "<li class='right-item'><a id='admin_button' href='#'>Admin</a></li>";
        }
      }else{
      	echo "<li class='right-item'><a id='login_button' href='/login.php'>Login</a></li>";
      	echo "<li class='right-item'><a id='signup_button' href='/signup.php'>Sign Up</a></li>";
      }
      
      
      ?>
      </ul>
</nav>