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
    var children = listElement.children();
    var filteredChildren = children.filter(function() {
      if(this.className != 'hide')
        return $(this);
    });
    children = filteredChildren;
    var pager = $('.pager');

    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
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
        var startAt = page * perPage,
            endOn = startAt + perPage;
        var filteredChildren = children.filter(function() {
          if(this.className != 'hide')
            return $(this);
        });
        children = filteredChildren;
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

  $('#data').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:4});
  $('#human-table').pageMe({pagerSelector:'#human-table-pager',showPrevNext:true,hidePageNumbers:false,perPage:10});

});
function sortTable(id, index) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById(id);
  //console.log(table);
  switching = true;
  dir = table.value;
  //Set the sorting direction to ascending:
  if(dir == null)
    dir = "asc";
  /*Make a loop that will continue until
  no switching has been done:*/
  counter = 0;
  while (switching && counter < 10000) {
    counter++;
    //start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("tr");
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 0; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[index];
      y = rows[i + 1].getElementsByTagName("TD")[index];
      rows[i].style.display = 'none';
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      //console.log(x);
      //console.log(y);
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
  for(i=0; i<10; i++){
    rows[i].style.display = '';
  }
  paginator = document.getElementById(id+"-pager");
  links = paginator.getElementsByTagName("li");
  for(i=0;i<links.length;i++){
    //links[i].className = "paginater";
    links[i].firstChild.className = "page_link page-link";
  }
  //paginator.getElementsByTagName("li")[1].className = "paginater active";
  //console.log(paginator.getElementsByTagName("li"));
  //console.log(paginator.getElementsByTagName("li")[1].firstChild);
  //paginator.getElementsByTagName("li")[1].getElementsByTagName("a")[1].className = "page_link page-link active";
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
  <table>
    <thead>
      <tr class='table-hide-mobile add-line'>
        <th onclick="sortTable('data', 0)">Name</th>
        <th onclick="sortTable('data', 1)">Points</th>
      </tr>
    </thead>
    <tbody id="data">
    <tr class="hide"> <td>Row 54 Hidden</td> <td>0</td></tr>
    <tr class="hide"> <td>Row 23 Hidden</td> <td>0</td></tr>
    <tr class="hide"> <td>Row 32 Hidden</td> <td>0</td></tr>
      <tr> <td>Row 4</td> <td>0</td></tr>
      <tr> <td>Row 9</td> <td>3</td></tr>
      <tr class="hide"> <td>Row 33 Hidden</td> <td>1</td></tr>
      <tr class="hide"> <td>Row 15 Hidden</td> <td>0</td></tr>
      <tr> <td>Row 2</td> <td>6</td></tr>
      <tr> <td>Row 35</td> <td>3</td></tr>
      <tr class="hide"> <td>Row 12 Hidden</td> <td>3</td></tr>
      <tr class="hide"> <td>Row 17 Hidden</td> <td>10</td></tr>
      <tr class="hide"> <td>Row 4 Hidden</td> <td>8</td></tr>
      <tr> <td>Row 65</td> <td>3</td></tr>
      <tr> <td>Row 23</td> <td>7</td></tr>
      <tr> <td>Row 7</td> <td>0</td></tr>
      <tr> <td>Row 12</td> <td>1</td></tr>
      <tr class="hide"> <td>Row 17 Hidden</td> <td>3</td></tr>
      <tr class="hide"> <td>Row 8 Hidden</td> <td>7</td></tr>
      <tr class="hide"> <td>Row 29 Hidden</td> <td>9</td></tr>
      <tr> <td>Row 65</td> <td>1</td></tr>
      <tr> <td>Row 13</td> <td>0</td></tr>
      <tr> <td>Row 75</td> <td>6</td></tr>
      <tr class="hide"> <td>Row 25 Hidden</td> <td>20</td></tr>
      <tr class="hide"> <td>Row 16 Hidden</td> <td>0</td></tr>
      <tr> <td>Row 34</td> <td>1</td></tr>
      <tr> <td>Row 13</td> <td>0</td></tr>
    </tbody>
  </table>
<div class="col-md-12 text-center">
  <ul class="pagination pagination-lg pager" id="myPager"></ul>
</div>
<table>
  <thead>
    <tr class='table-hide-mobile add-line'>
      <th onclick="sortTable('human-table', 0)">Username</th>
      <th onclick="sortTable('human-table', 1)">Points</th>
      <th onclick="sortTable('human-table', 2)">Starve Timer</th>
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
