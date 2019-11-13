<?php
if(isset($_POST['submit'])){
  if($_POST['submit'] == "Create Code" && !isset($processing)){
      // prevent multiple requests going through at once
      $processing = true;
      error_log("create code", 0);
      $type = $_POST["code_type"];
      $sideEffect = $_POST["side_effect"];
      $name = $_POST["name"];
      if(empty($name))
        $name = "NULL";
      else
        $name = "$name";

      $hex = $_POST["hex"];
      if(empty($hex))
        $hex = $hex = substr(md5(uniqid(rand(),'')),0,5);

      if(empty($sideEffect))
        $sideEffect = "NULL";

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

      $val = $_POST['val'];
      if(empty($val)){
        $val = '0';
      }

      $pointVal = $_POST['point_val'];
      if(empty($pointVal) || $pointVal == 0){
        $pointVal = '0';
      }
      $expiration = $_POST["expiration"];
      $expireAt5 = false;
      if(isset($_POST["expire_at_5"]))
        $expireAt5 = true;
      if(empty($expiration)){
        $currentTime = new DateTime(date('Y-m-d H:i:s'));
        $expiration = $currentTime->format('Y-m-d');
        // $expiration = "NULL";
      }
      if($expireAt5){
        $expiration = "$expiration 17:00:00";
      }else{
        $expiration = "$expiration 23:59:59";
      }

      error_log("type: $type, val: $val, point val: $pointVal, name: $name, uses: $numUses, single use: $singleUse, hex: $hex, location: $location, expiration: $expiration", 0);
      $query = "INSERT INTO ".$_SESSION["weeklong"]."_codes (name, hex, effect, side_effect, val, point_val, location_id, num_uses, single_use, expiration) VALUES
        ('$name', '$hex', '$type', '$sideEffect', '$val', '$pointVal', '$location', '$numUses', $singleUse, '$expiration')";
      $data = $database->executeQuery($query);
      if(isset($data["error"])){
        $codeMessage = array("error" => "error creating code");
      }else{
        $codeMessage = array("success" => "Code created with hex: $hex");
      }
  }
}

?>
<script>
function closeMessage(event){
  event.srcElement.parentNode.remove();
}
</script>
<?php
  if(isset($codeMessage)){
    if(isset($codeMessage["error"])){
      echo "<div class='bg-danger' style='margin: 0;'>".$codeMessage["error"]." <span onclick='closeMessage(event)'>&#x274C;</span></div>";
    }elseif(isset($codeMessage["success"])){
      echo "<div class='bg-success' style='margin: 0; display: inline-block;'>".$codeMessage["success"]." <span onclick='closeMessage(event)'>&#x274C;</span></div>";
    }
  }
?>
