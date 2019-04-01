<?php

if(isset($_POST['submit'])){
  if(isset($_POST['create_code'])){
    $type = $_POST["code_type"];
    $name = $_POST["name"];
    $numUses = $_POST["num_uses"];
    $sideEffect = $_POST["side_effect"];
    error_log("type: $type name: $name uses: $numUses side effect: $sideEffect", 0);
    $weeklongName = $_SESSION["weeklong"];
    $hex = substr(md5(uniqid(rand(),'')),0,5);
    if($numUses == 0)
      $numUses = "1";
    $query = "INSERT INTO ".$_SESSION["weeklong"]."_codes (name, hex, effect, num_uses) VALUES ('$name', '$hex', '$type', $numUses)";
    $data = $database->executeQuery($query);
    if(!isset($data["error"])){
      echo "<p class='bg-success' style='margin: 0;'> &#10003; Code has been created.</p>";
    }else{
      echo "<p class='bg-danger' style='margin: 0;'> &#10003; Error creating code.</p>";
    }
  }
}

?>

<div style="display: inline-block; padding: 20px;">
  <div class="center">
    <form role="form" method="post">
      Create a new weeklong code
      <br/>
      <span style="float: left;">
        <label>Code type</label><br/>
        <select name="code_type">
          <option value="supply">supply</option>
          <option value="points">points</option>
          <option value="mission">mission</option>
          <option value="revive">revive</option>
        </select>
      </span>
      <span style="float: left;">
        <label>Name</label><br/>
        <input type="text" name="name" required>
      </span>
      <span style="float: left;">
        <label>Number of uses</label><br/>
        <input type="number" name="num_uses" placeholder="leave blank for 1">
      </span>
      <span style="float: left;">
        <label>Side effect</label><br/>
        <input type="text" name="side_effect" placeholder="leave blank for no side effect"/>
      </span>
      <input type="hidden" name="tab" value="ActiveGame">
      <input type="hidden" name="create_code">
      <span style="float: left;">
        <br/>
        <input type="submit" name="submit" value="CreateCode" class="btn btn-primary btn-block btn-lg button-primary">
      </span>
    </form>
  </div>
</div>
