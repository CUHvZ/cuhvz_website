<h3 class="row-header">Weeklong</h3>
<style>
.name {
  width: 100px;
}
.title {
  width: 250px;
}
.status {
  width: 60px;
  text-align: center;
}
</style>
<script>

function editRow(rowID){
  var row = document.getElementById(rowID);
  var elements = row.getElementsByClassName("cell");
  var editRow = document.createElement("DIV");
  editRow.className = row.className;
  editRow.id = row.id+"_editing";
  for (var i=0; i<elements.length; i++) {
    var e = elements[i];
    var classes = e.classList["value"];
    if(e.id == "name" || e.id == "title"){
      var eInput = document.createElement("INPUT");
      eInput.innerHTML = e.innerHTML;
      eInput.setAttribute("value", e.innerHTML);
      eInput.id = e.id;
      eInput.className = e.className;
      editRow.appendChild(eInput);
    } else if(e.id == "active" || e.id == "display") {
      var selector = document.createElement("SELECT");
      var optionT = document.createElement("OPTION");
      var optionF = document.createElement("OPTION");
      optionT.innerHTML = "T";
      optionT.setAttribute("value", 1);
      optionF.innerHTML = "F";
      optionF.setAttribute("value", 0);
      selector.id = e.id;
      // Display the current value correctly (first child will display first by default)
      if(e.innerHTML == 1){
        selector.appendChild(optionT);
        selector.appendChild(optionF);
      }else{
        selector.appendChild(optionF);
        selector.appendChild(optionT);
      }
      selector.id = e.id;
      selector.className = e.className;
      editRow.appendChild(selector);
    } else if(e.id == "id"){
      var eID = document.createElement("DIV");
      eID.innerHTML = e.innerHTML;
      eID.className = e.className;
      eID.value = e.innerHTML;
      eID.id = e.id;
      editRow.appendChild(eID);
    }else if(e.id == "edit") {
      var saveButton = document.createElement("INPUT");
      saveButton.id = e.id;
      saveButton.setAttribute("value", "Save");
      saveButton.setAttribute("type", "submit");
      saveButton.setAttribute("name", "submit");
      saveButton.setAttribute("onClick", "saveRow(\""+rowID+"\")");
      saveButton.setAttribute("id", "save-"+rowID);
      saveButton.className = "save-button btn btn-primary button-primary";
      editRow.appendChild(saveButton);
      var cancelButton = document.createElement("INPUT");
      cancelButton.setAttribute("value", "Cancel");
      cancelButton.setAttribute("type", "submit");
      cancelButton.setAttribute("name", "submit");
      cancelButton.setAttribute("onClick", "cancelEdit(\""+rowID+"\")");
      cancelButton.setAttribute("id", "cancel-"+rowID);
      cancelButton.className = "save-button btn btn-primary button-primary";
      editRow.appendChild(cancelButton);
    }
  }
  row.classList.add("hidden");
  row.parentElement.appendChild(editRow);
}

function cancelEdit(rowID){
  var row = document.getElementById(rowID);
  row.classList.remove("hidden");
  var editRow = document.getElementById(rowID+"_editing");
  editRow.remove();
}

function saveRow(rowID){
  var row = document.getElementById(rowID);
  var elements = row.getElementsByClassName("cell");
  var editRow = document.getElementById(rowID+"_editing");
  var editElements = editRow.getElementsByClassName("cell");

  var data = {};
  data["saveRow"] = {};
  var weeklongID;
  // Update values in display row
  for (var i=0; i<elements.length; i++) {
    var rowElement = elements[i];
    var edittedElement = editElements[i];
    if(rowElement.id == "name" || rowElement.id == "title" || rowElement.id == "active" || rowElement.id == "display"){
      rowElement.innerHTML = edittedElement.value;
    }else if(rowElement.id == "id"){
      weeklongID = edittedElement.innerHTML;
    }
    if(rowElement.id != 'edit'){
      data["saveRow"][rowElement.id] = edittedElement.value;
    }
  }
  data["saveRow"]["id"] = weeklongID;
  // Delete editing div
  editRow.remove();
  // Show update row
  row.classList.remove("hidden");
  //Send data with POST request
  var xhttp = new XMLHttpRequest();
  xhttp.open("POST", "admin.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("data="+JSON.stringify(data));
}
</script>

<?php

$root = $_SERVER["DOCUMENT_ROOT"];
if(empty($root)){
  $root = "/home/josh/cuhvz_website";
}

include $root."/components/admin/functions/create_weeklong.php";
if(isset($_POST['data'])){
  // error_log($_POST['data'], 0);
  $data = json_decode($_POST['data'], true);
  error_log( print_r( $data, true ) );

  if(isset($data['saveRow'])){
    // error_log("save: ".$data['save']);
    $id = $data['saveRow']["id"];
    $newName = addslashes($data['saveRow']["name"]);
    $newTitle = addslashes($data['saveRow']["title"]);
    $newActive = $data['saveRow']["active"];
    $newDisplay = $data['saveRow']["display"];
    $table = "weeklongs";
    $set = "name='$newName', title='$newTitle', active=$newActive, display=$newDisplay";
    $condition = "id=$id";
    // error_log("update $table set ".$set." where $condition");
    $database->update($table, $set, $condition);
  }
}

function buildWeeklonsRow($weeklong){
  $rowID = $weeklong["name"]."_".$weeklong["id"];
  echo "<div class='table-row'>";
    echo "<div class='cell-container add-line' id='$rowID'>\n";
      echo "<div class='id cell' id='id'>".$weeklong["id"]."</div>\n";
      echo "<div class='name cell' id='name'>".$weeklong["name"]."</div>\n";
      echo "<div class='title cell' id='title'>".$weeklong["title"]."</div>\n";
      echo "<div class='status cell' id='active'>".$weeklong["active"]."</div>\n";
      echo "<div class='status cell' id='display'>".$weeklong["display"]."</div>\n";
      echo "<div class='edit cell' id='edit'>\n";
        echo "<input type='image' class='edit_button' onclick='editRow(\"".$rowID."\")' src='images/settings_white.png' alt='edit' width='20' height='20'>\n";
      echo "</div>";
    echo "</div>";
  echo "</div>";
}

?>
<p/>
<div class="table">
    <div class="table-row">
      <div class="cell-container add-line">
        <div class="id cell">id</div>
        <div class="name cell">name</div>
        <div class="title cell">title</div>
        <div class="status cell">active</div>
        <div class="status cell">display</div>
        <div class="status cell"></div>
      </div>
    </div>
    <?php

      $query = "SELECT * FROM weeklongs";
      $weeklongData = $database->executeQueryFetchAll($query);
      foreach ($weeklongData as $weeklong) {
        buildWeeklonsRow($weeklong);
      }

    ?>
</div>
