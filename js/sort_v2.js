
function sortTable(id, sortColumn, perPage) {
  var table, rows, sorting, i, x, y, shouldSwap, dir, sortColumnIndex, switchcount = 0;
  table = document.getElementById(id);
  sorting = true;
  dir = table.value;
  // Set the sorting direction to ascending:
  if(table.value == null) {
    dir = "asc";
    sortAscending = true;
  } else {
    sortAscending = table.value == "asc";
  }
  // Counter in case infinite loop is encountered
  rows = table.getElementsByTagName("tr");
  function getElement(e){
    return e.querySelector("#"+sortColumn).outerText.toLowerCase();
  }
  function compare(a, b){
    a = getElement(a);
    b = getElement(b);
    // TODO
    var isnum = /^\d+$/.test(a);
    if(isnum){
      return (parseInt(a) < parseInt(b)) ? 1 : -1;
    }
    var resA = a.match(/[0-9]{1,2}:[0-9]{1,2}/g);
    if(resA != null){
      var arrayA = a.split(":");
      var arrayB = b.split(":");
      var timeA = parseInt(arrayA[0])*60+parseInt(arrayA[1]);
      var timeB = parseInt(arrayB[0])*60+parseInt(arrayB[1]);
      return (timeA > timeB) ? 1 : -1;
    }
    return a.localeCompare(b);
  }
  var tableLength = rows.length;
  [].slice.call(rows).sort(function(a, b) {
    if(sortAscending)
      return compare(a, b);
    else {
      return compare(b, a);
    }
  }).forEach(function(val, index) {
    val.style.display = 'none';
    val.parentNode.appendChild(val);
  });
  resetPaginator(id, rows, perPage);
  if(dir == "asc")
    table.value = "desc";
  else if(dir == "desc")
    table.value = "asc";
}

function resetPaginator(id, rows, perPage){
  // Display correct amount of items per page
  var index = 0, displayCount = 0;
  while(index < rows.length && displayCount < perPage){
    if(rows[index].className != "hide"){
      rows[index].style.display = '';
      displayCount++;
    }
    index++;
  }
  paginator = document.getElementById(id+"-pager");
  links = paginator.getElementsByTagName("li");
  var pager = $('.pager');
  pager.data("curr",0);
  pager.find('.prev_link').hide();
  pager.find('.next_link').show();
  for(i=1;i<links.length-1;i++){
    links[i].firstChild.className = "page_link page-link";
  }
  paginator.getElementsByTagName("li")[1].firstChild.className = "page_link page-link active";
}
