function openTab(evt, tabName, tabContainer="tab-container") {
  var i, tabcontent, tablinks;
  console.log(tabcontent = $("#"+tabContainer));
  tabcontent = $("#"+tabContainer).find(".tabcontent");
  console.log(tabcontent);
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  var button = document.getElementById(tabName+"-button");
  console.log(button);
  if(button == null)
    evt.currentTarget.className += " active";
  else
    button.className += " active";
}
