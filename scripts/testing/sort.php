<!DOCTYPE html>
<html>
<head>
  <style>
  .paginater{
    display: inline;
  }
  .page-link{
      text-decoration: none;
      text-align: center;
      margin: 5px;
      padding: 10px;
      display: inline-block;
  }

  .page-link:hover{
    background-color: rgba(234, 123, 0, 0.4);
    transition: 0.3s;
  }
  .active {
    background-color: rgb(234, 123, 0);
  }
  a{
    text-decoration: none;
  }
  a:visited, a:link{
    text-decoration: none;
    color: black;
  }
  .hide{
    display: none;
  }
  .outer-div
{
  padding: 30px;
  text-align: center;
  background-color: #f3f3f3;
}
.inner-div
{
  display: inline-block;
  padding: 50px;
  background-color: #ccc;
  border-radius: 3px;
}
  </style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 4,
            showPrevNext: false,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);

    var listElement = $this;
    var perPage = settings.perPage;
    var children = listElement.children().filter(function() {
      if(this.className != 'hide')
        return $(this);
    });
    var pager = $('.pager');

    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector).filter(function() {
          if(this.className != 'hide')
            return $(this);
        });
    }

    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }

    var numItems = children.length;
    var numPages = Math.ceil(numItems/perPage);

    pager.data("curr",0);

    if (settings.showPrevNext){
        $('<li class="paginater"><a href="#" class="prev_link page-link">«</a></li>').appendTo(pager);
    }

    var curr = 0;
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li class="paginater"><a href="#" class="page_link page-link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }

    if (settings.showPrevNext){
        $('<li class="paginater"><a href="#" class="next_link page-link">»</a></li>').appendTo(pager);
    }

    //pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
    //console.log(pager.children().eq(1));
    //console.log(pager.children().eq(1).children());
  	//pager.children().eq(1).addClass("active");
    pager.children().eq(1).children().addClass("active");
    children.hide();
    children.slice(0, perPage).show();

    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });

    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }

    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }

    function goTo(page){
        var startAt = page * perPage;
        var endOn = startAt + perPage;
        children = listElement.children().filter(function() {
          if(this.className != 'hide')
            return $(this);
        });
        console.log(children.css('display','none').slice(startAt, endOn));
        children.css('display','none').slice(startAt, endOn).show();

        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }

        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }

        pager.data("curr",page);
      	pager.children().children().removeClass("active");
        pager.children().eq(page+1).children().addClass("active");

    }
};


$(document).ready(function(){

  $('#data').pageMe({pagerSelector:'#data-pager',showPrevNext:true,hidePageNumbers:false,perPage:4});
  $('#human-table').pageMe({pagerSelector:'#human-table-pager',showPrevNext:true,hidePageNumbers:false,perPage:10});

});
function sortTable(id, sortColumnIndex, perPage) {
  var table, rows, sorting, i, x, y, shouldSwap, dir, switchcount = 0;
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
  counter = 0;
  counterMax = rows.length * 1000;
  while (sorting && counter < 10000) {
    counter++;
    sorting = false;
    for (i = 0; i < (rows.length - 1); i++) {
      // start by saying there should be no switching:
      shouldSwap = false;
      // Get the text from the two elements you want to compare, one from current row and one from the next
      x = rows[i].getElementsByTagName("TD")[sortColumnIndex].outerText.toLowerCase();
      y = rows[i + 1].getElementsByTagName("TD")[sortColumnIndex].outerText.toLowerCase();
      rows[i].style.display = 'none';
      if(sortAscending) {
        if (x > y) {
          shouldSwap= true;
          break;
        }
      } else if(!sortAscending && x < y){
        shouldSwap= true;
        break;
      }
    }
    // make the swap
    if (shouldSwap) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      sorting = true;
      switchcount ++;
    }
  }
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
  for(i=0;i<links.length;i++){
    links[i].firstChild.className = "page_link page-link";
  }
  paginator.getElementsByTagName("li")[1].firstChild.className = "page_link page-link active";
  if(counter == 10000)
    console.log("counter limit reached")
  if(dir == "asc")
    table.value = "desc";
  else if(dir == "desc")
    table.value = "asc";
}
</script>
</head>
<body>
  <div class="outer-div"><div class="inner-div"></div></div>

  <table>
    <thead>
      <tr class='table-hide-mobile add-line'>
        <th onclick="sortTable('data', 0, 4)">Name</th>
        <th onclick="sortTable('data', 1, 4)">Points</th>
      </tr>
    </thead>
    <tbody id="data">
    <tr class="hide"> <td>Row b Hidden</td> <td>0</td></tr>
    <tr class="hide"> <td>Row d Hidden</td> <td>0</td></tr>
    <tr class="hide"> <td>Row k Hidden</td> <td>0</td></tr>
      <tr> <td>Row j</td> <td>0</td></tr>
      <tr> <td>Row s</td> <td>3</td></tr>
      <tr class="hide"> <td>Row e Hidden</td> <td>1</td></tr>
      <tr class="hide"> <td>Row w Hidden</td> <td>0</td></tr>
      <tr> <td>Row d</td> <td>6</td></tr>
      <tr> <td>Row x</td> <td>3</td></tr>
      <tr class="hide"> <td>Row v Hidden</td> <td>3</td></tr>
      <tr class="hide"> <td>Row o Hidden</td> <td>10</td></tr>
      <tr class="hide"> <td>Row j Hidden</td> <td>8</td></tr>
      <tr> <td>Row n</td> <td>3</td></tr>
      <tr> <td>Row c</td> <td>7</td></tr>
      <tr> <td>Row m</td> <td>0</td></tr>
      <tr> <td>Row w</td> <td>1</td></tr>
      <tr class="hide"> <td>Row j Hidden</td> <td>3</td></tr>
      <tr class="hide"> <td>Row c Hidden</td> <td>7</td></tr>
      <tr class="hide"> <td>Row o Hidden</td> <td>9</td></tr>
      <tr> <td>Row s</td> <td>1</td></tr>
      <tr> <td>Row i</td> <td>0</td></tr>
      <tr> <td>Row y</td> <td>6</td></tr>
      <tr class="hide"> <td>Row w Hidden</td> <td>20</td></tr>
      <tr class="hide"> <td>Row f Hidden</td> <td>0</td></tr>
      <tr> <td>Row kj</td> <td>1</td></tr>
      <tr> <td>Row f</td> <td>0</td></tr>
    </tbody>
  </table>
<div class="col-md-12 text-center">
  <ul class="pagination pagination-lg pager" id="data-pager"></ul>
</div>
<table>
  <thead>
    <tr class='table-hide-mobile add-line'>
      <th onclick="sortTable('human-table', 0, 10)">Username</th>
      <th onclick="sortTable('human-table', 1, 10)">Points</th>
      <th onclick="sortTable('human-table', 2, 10)">Starve Timer</th>
    </tr>
  </thead>
  <tbody  id="human-table">
<tr class='table-hide-mobile add-line'>
<td>Savvycappy</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>claudiasellis</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>magickayla</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Zakdebaggis</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Parone</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Xina5000</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>sydchan</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Krysten</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Rdubs</td>
<td>20</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>aliden</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>char7887</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>kriss</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Tlex</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Vanessa</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>hual0827</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>TheUnexpectedBidet</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Benjaminc037</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>jasminelucky</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>chdu1446</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>karasel</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Zargen19</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>LilBisch</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>brockknechtel</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>ancu2103</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>RedCurlyFury</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>GrandMasterChino</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>dsowders</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Mwillis25</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Yara</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Kirstenk</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Adam.Bender</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Bellaallen1015</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>lial3088</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>abal6725</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Emely17</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>r12v56kk</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Jehe3586</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>SeanDunk</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>dracoshooter187</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>MsAssassinLexi</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>legaer</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>drewdpham</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>NicoArhcer</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>timmellen</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>MilaBergmannR</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Swagatron</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Tez</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Luci</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>aziz626</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>prescottjd</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>ErinKugler7</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>meganborchardt</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>sophben</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>cammiep</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>thebirdman</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Abelgeb123</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Mancy</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Gcominelli</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>shellulose</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Thompson</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>berrybrown</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>phwu6529</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>skrieger</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Luwe8329</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Brucevalentine</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>ajkaras</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
<tr class='table-hide-mobile add-line'>
<td>Kellenposacki</td>
<td>0</td>
<td class='red'>22:52:32</td>
</tr>
</tbody>
</table>
<div class="col-md-12 text-center">
  <ul class="pagination pagination-lg pager" id="human-table-pager"></ul>
</div>
</body>
</html>
