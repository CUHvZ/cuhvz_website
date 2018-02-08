<nav class="navbar">

      <!--<a style="display: block;" href="signup.php">
   	  <img src="/images/hvzLogo.png" width="60" height="60" alt="">
  	  </a>-->
  	  <ul>
  	  <li></li>
      <li><a id="index_button" href="index.php">Home</a></li>
      <li><a id="about_button" href="about.php">About</a></li>
      <li><a id="mod_team_button" href="#">Mod Team</a></li>
      <li><a id="rules_button" href="#">Rules</a></li>
      <li><a id="events_button" href="#">Events</a></li>
      <li><a id="media_button" href="#">Media</a></li>
      <?php
      if($user->is_logged_in()){
      	echo "<li class='right-item'><a id='logout_button' href='logout.php'>Logout</a></li>";
      	echo "<li class='right-item'><a id='profile_button' href='profile.php'>Profile</a></li>";
        if($user->is_admin()){
          echo "<li class='right-item'><a id='admin_button' href='#'>Admin</a></li>";
        }
      }else{
      	echo "<li class='right-item'><a id='login_button' href='login.php'>Login</a></li>";
      	echo "<li class='right-item'><a id='signup_button' href='signup.php'>Sign Up</a></li>";
      }
      
      
      ?>
      </ul>

</nav>