function formatDate(date) {
  var monthNames = [
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  ];

  var day = date.getDate();
  var monthIndex = date.getMonth();
  var year = date.getFullYear();

  return day + ' ' + monthNames[monthIndex] + ' ' + year;
}

Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}

function addOrdinal(num){
  if(num == 1)
    return num + "st";
  else if(num == 2)
    return num + "nd";
  else if(num == 3)
    return num + "rd";
  else
    return num + "th";
}

function formatWeeklongDates(startDate) {
  var monthNames = [
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  ];

  var firstDay = startDate.getDate();
  if(firstDay == 1)
    firstDay = firstDay + "st";
  else if(firstDay == 2)
    firstDay = firstDay + "nd";
  else if(firstDay == 3)
    firstDay = firstDay + "rd";
  else
    firstDay = firstDay + "th";
  var firstMonth = monthNames[startDate.getMonth()];
  var year = date.getFullYear();

  var endDate = startDate.addDays(5);
  var endDay = endDate.getDate();
  if(endDay == 1)
    endDay = endDay + "st";
  else if(endDay == 2)
    endDay = endDay + "nd";
  else if(endDay == 3)
    endDay = endDay + "rd";
  else
    endDay = endDay + "th";
  var endMonth = monthNames[endDate.getMonth()];

  if(firstMonth != endMonth){
    return firstMonth + " " + firstDay + " - " + endMonth + " " + endDay + ", " + year;
  }else{
    return firstMonth + " " + firstDay + " - " + endDay + ", " + year;
  }

  //return day + ' ' + monthNames[monthIndex] + ' ' + year;
}


var date = new Date("2018-09-27 07:00:00");
console.log(formatWeeklongDates(date));
//console.log(formatDate(date));
//console.log(formatDate(date.addDays(5)));
