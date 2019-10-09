function openTab(evt, tabToOpen, tabClass="tabcontent") {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName(tabClass);
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabToOpen).style.display = "block";
  var button = document.getElementById(tabToOpen+"-button");
  // console.log(button);
  if(button == null)
    evt.currentTarget.className += " active";
  else
    button.className += " active";
}
