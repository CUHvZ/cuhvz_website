<?php

if(isset($_POST['submit'])){
  if($_POST['submit'] == "Set Stun Timer" && !isset($processing)){
    // prevent multiple requests going through at once
    $processing = true;
    $weeklongName = $_SESSION["weeklong"];
    $minutes = $_POST["min"];
    $seconds = $_POST["sec"];
    if(empty($seconds)){
      $seconds = "00";
    }elseif($seconds < 10){
      $seconds = "0".$seconds;
    }
    if($minutes < 10){
      $minutes = "0".$minutes;
    }
    $stunTimer = "00:$minutes:$seconds";
    error_log("setting timer set to $stunTimer", 0);
    $query = "update weeklongs set stun_timer='$stunTimer' where name='$weeklongName'";
    $database = new Database();
    $data = $database->executeQuery($query);
    if(isset($data["error"])){
      $message = array("error" => "error updating stun timer");
    }else{
      $message = array("success" => "Stun timer updated");
    }
  }
}

?>


 <div class="container">

  <div class="row">

        <form role="form" method="post" action="" autocomplete="off">

          <div class="row">
            <div class="three columns">
                <label>Minutes</label>
                <input name="min" class="function-input input-lg u-full-width" type="number" required min="0" max="20">
            </div>
            <div class="three columns">
                <label>Seconds</label>
                <input name="sec" value="0" class="function-input u-full-width input-lg" type="number" min="0" max="59">
            </div>
          </div>

          <div class="row">
            <div class="three columns">
                <input type="submit" name="submit" value="Set Stun Timer" class="btn btn-primary btn-block btn-lg button-primary">
            </div>
          </div>
        </form>
      </div>
  </div>
 </div>
