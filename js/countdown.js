function getTimeRemaining(endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
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
  // var clock = document.getElementById(id);
  // var daysSpan = clock.querySelector('.days');
  // var hoursSpan = clock.querySelector('.hours');
  // var minutesSpan = clock.querySelector('.minutes');
  // var secondsSpan = clock.querySelector('.seconds');

  var clock = $('#'+id);
  var daysSpan = clock.find('.days');
  var hoursSpan = clock.find('.hours');
  var minutesSpan = clock.find('.minutes');
  var secondsSpan = clock.find('.seconds');

  function updateClock() {
    var t = getTimeRemaining(endtime);

    // console.log(t);

    // daysSpan.innerHTML = parseInt(t.days);
    // hoursSpan.innerHTML = parseInt(t.hours);
    // minutesSpan.innerHTML = parseInt(t.minutes);
    // secondsSpan.innerHTML = parseInt(t.seconds);

    daysSpan.html(t.days);
    hoursSpan.html(t.hours);
    minutesSpan.html(t.minutes);
    secondsSpan.html(t.seconds);

    clock.hide();
    clock.get(0).offsetHeight;
    clock.show();

    if (t.total <= 0) {
      clearInterval(timeinterval);
    }
  }

  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
}

//var deadline = 'Sptember 28 2018 17:00:00 GMT-0600';
//initializeClock('clockdiv', deadline);
