function openTab(tabToOpen, tabClass="tabcontent", setSession=true) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName(tabClass);
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  document.getElementById(tabToOpen).style.display = "block";

  removeHighlights();

  var button = document.getElementById(tabToOpen+"-tab-button");
  button.className += " active";

  if(setSession){
    var tab = [{"tabID": tabToOpen, "tabClass": tabClass}];
    sessionStorage.setItem('tabsToOpen', JSON.stringify(tab));
    sessionStorage.setItem("lastPageLoad", window.location.href);
  }
}

function removeHighlights(){
  var tabButtons = document.getElementsByClassName("tablink");
  var i;
  for (i = 0; i < tabButtons.length; i++) {
    tabButtons[i].className = tabButtons[i].className.replace(" active", "");
  }
  tabButtons = document.getElementsByClassName("tablink-full");
  for (i = 0; i < tabButtons.length; i++) {
    tabButtons[i].className = tabButtons[i].className.replace(" active", "");
  }
}

function hightlightTabs(){
  removeHighlights();

  var tabsToOpen = JSON.parse(sessionStorage.getItem('tabsToOpen'));
  var i;
  if(tabsToOpen != null){
    for (i = 0; i < tabsToOpen.length; i++) {
      var button = document.getElementById(tabsToOpen[i]["tabID"]+"-tab-button");
      button.className += " active";
    }
  }
}

function openNestedTab(tabToOpen, tabClass="tabcontent", tabLevel=1) {
  var currentTabs = JSON.parse(sessionStorage.getItem('tabsToOpen'));
  var tabsToOpen = [];
  var i;
  for (i = 0; i < tabLevel; i++) {
    tabsToOpen.push(currentTabs[i]);
  }
  tabsToOpen.push({"tabID": tabToOpen, "tabClass": tabClass});
  openTab(tabToOpen, tabClass, false);
  sessionStorage.setItem('tabsToOpen', JSON.stringify(tabsToOpen));
  sessionStorage.setItem("lastPageLoad", window.location.href);
  hightlightTabs();
}

$(function () {
  if(sessionStorage.getItem('lastPageLoad') == window.location.href){
    var tabsToOpen = JSON.parse(sessionStorage.getItem('tabsToOpen'));
    if(tabsToOpen != null){
      var tab, i;
      for (i = 0; i < tabsToOpen.length; i++) {
        // console.log(i);
        tab = tabsToOpen[i];
        // console.log(tabsToOpen[i]);
        openTab(tab["tabID"], tab["tabClass"], false);
      }
      hightlightTabs();
    }
  }else{
    sessionStorage.setItem("tabsToOpen", null);
    sessionStorage.setItem("lastPageLoad", window.location.href);
  }
});
