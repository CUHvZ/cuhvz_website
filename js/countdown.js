function getTimeRemaining(endtime) {
  var arr = endtime.split(/[- :]/);
  date = new Date(arr[0], arr[1]-1, arr[2], arr[3], arr[4], arr[5]);
  var t = date - Date.parse(new Date());
  var seconds = Math.floor((t / 1000) % 60);
  var minutes = Math.floor((t / 1000 / 60) % 60);
  var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
  var days = Math.floor(t / (1000 * 60 * 60 * 24));
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}

function initializeClock(id, endtime) {
  
  var clock = $('#'+id);
  var daysSpan = clock.find('.days');
  var hoursSpan = clock.find('.hours');
  var minutesSpan = clock.find('.minutes');
  var secondsSpan = clock.find('.seconds');

  function updateClock() {
    var t = getTimeRemaining(endtime);

    daysSpan.html(t.days);
    hoursSpan.html(t.hours);
    minutesSpan.html(t.minutes);
    secondsSpan.html(t.seconds);

    if (t.total <= 0) {
      clearInterval(timeinterval);
    }
  }

  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
}

//var deadline = 'Sptember 28 2018 17:00:00 GMT-0600';
//initializeClock('clockdiv', deadline);
