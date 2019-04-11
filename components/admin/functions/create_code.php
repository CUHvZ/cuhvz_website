<?php

if(isset($_POST['submit'])){
  if($_POST['submit'] == "CreateCode"){
      error_log("create code", 0);
      $type = $_POST["code_type"];
      $name = $_POST["name"];

      $hex = $_POST["hex"];
      if(empty($hex))
        $hex = $hex = substr(md5(uniqid(rand(),'')),0,5);

      $location = $_POST["location"];
      if(empty($location))
        $location = "NULL";

      $numUses = $_POST['num_uses'];
      $singleUse = false;
      if($_POST['num_uses'] <= 1){
        $numUses = 1;
        $singleUse = true;
      }

      if($singleUse)
        $singleUse = "true";
      else
        $singleUse = "false";

      $expiration = $_POST["expiration"];
      if(!empty($expiration))
        $expiration = $expiration." 23:59:59";
      else
        $expiration = "NULL";

      // error_log("type: $type, name: $name, uses: $numUses, single use: $singleUse, hex: $hex, location: $location, expiration: $expiration", 0);
      $query = "INSERT INTO ".$_SESSION["weeklong"]."_codes (name, hex, effect, location_id, num_uses, single_use, expiration) VALUES
        ('$name', '$hex', '$type', '$location', $numUses, $singleUse, '$expiration')";
      $database->executeQuery($query);
  }
}

?>


 <div class="container">

  <div class="row">

        <form role="form" method="post" action="" autocomplete="off">
		        <div class="row">
              <div class="two columns">
                  <label>Effect</label><br/>
                  <select name="code_type">
                    <option value="supply">supply</option>
                    <option value="points">points</option>
                    <option value="mission">mission</option>
                    <option value="revive">revive</option>
                  </select>
                </div>
                <!-- <div class="two columns">
                  <label>Side Effect</label><br/>
                  <select name="code_type">
                  </select>
                </div> -->
            </div>

          <div class="row">
            <div class="three columns">
                <label>Name</label>
                <input name="name" class="function-input input-lg u-full-width" placeholder="Name" required>
            </div>
            <div class="three columns">
                <label>Hex</label>
                <input name="hex" class="function-input u-full-width input-lg" placeholder="Blank for random">
            </div>

            <div class="three columns">
                <label>Location</label>
                <input name="location" class="function-input u-full-width input-lg" placeholder="For supply drops">
            </div>
          </div>

          <div class="row">
            <div class="four columns">
                <label>Number of uses</label>
                <input name="num_uses" class="function-input input-lg u-full-width" placeholder="Blank for single use">
            </div>

            <div class="three columns">
              <label>Expiration</label><br/>
              <input class="date" name="expiration" placeholder="MM/DD/YYYY" type="text"/>
            </div>
          </div>

          <div class="row">
            <div class="three columns">
                <input type="submit" name="submit" value="CreateCode" class="btn btn-primary btn-block btn-lg button-primary">
            </div>
          </div>
        </form>
      </div>
  </div>
 </div>
