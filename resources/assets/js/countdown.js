document.addEventListener("DOMContentLoaded", () => {
const $1 = elem => document.querySelector(elem);

const countdown = function(_config) {
  const tarDate = $1(_config.target).getAttribute('data-date').split('-');
  const day = parseInt(tarDate[0]);
  const month = parseInt(tarDate[1]);
  const year = parseInt(tarDate[2]);
  let tarTime = $1(_config.target).getAttribute('data-time');
  let tarhour, tarmin;

  if (tarTime != null) {
    tarTime = tarTime.split(':');
    tarhour = parseInt(tarTime[0]);
    tarmin = parseInt(tarTime[1]);
  }

  let months = [31, new Date().getFullYear() % 4 == 0 ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  let dateNow = new Date();
  let dayNow = dateNow.getDate();
  let monthNow = dateNow.getMonth() + 1;
  let yearNow = dateNow.getFullYear();
  let hourNow = dateNow.getHours();
  let minNow = dateNow.getMinutes();
  let count_day = 0, count_hour = 0, count_min = 0;
  let count_day_isSet = false;
  let isOver = false;

  // Set the date we're counting down to
  const countDownDate = new Date(year, month-1, day, tarhour, tarmin, 0, 0).getTime();

  $1(_config.target+' .day .word').innerHTML = _config.dayWord;
  $1(_config.target+' .hour .word').innerHTML = _config.hourWord;
  $1(_config.target+' .min .word').innerHTML = _config.minWord;
  $1(_config.target+' .sec .word').innerHTML = _config.secWord; 

  const updateTime = () => {
    // Get todays date and time
    const now = new Date().getTime();

    // Find the distance between now an the count down date
    const distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    requestAnimationFrame(updateTime);

    $1(_config.target+' .day .num').innerHTML = addZero(days);
    $1(_config.target+' .hour .num').innerHTML = addZero(hours);
    $1(_config.target+' .min .num').innerHTML = addZero(minutes);
    $1(_config.target+' .sec .num').innerHTML = addZero(seconds);

    // If the count down is over, write some text
    if (distance < 0) {
      $1(".countdown").innerHTML = "Finish";
    }
  }

  updateTime();
}





  const countdown1 = function(_config) {
    const tarDate = $1(_config.target).getAttribute('data-date').split('-');
    const day = parseInt(tarDate[0]);
    const month = parseInt(tarDate[1]);
    const year = parseInt(tarDate[2]);
    let tarTime = $1(_config.target).getAttribute('data-time');
    let tarhour, tarmin;

    if (tarTime != null) {
      tarTime = tarTime.split(':');
      tarhour = parseInt(tarTime[0]);
      tarmin = parseInt(tarTime[1]);
    }

    let months = [31, new Date().getFullYear() % 4 == 0 ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    let dateNow = new Date();
    let dayNow = dateNow.getDate();
    let monthNow = dateNow.getMonth() + 1;
    let yearNow = dateNow.getFullYear();
    let hourNow = dateNow.getHours();
    let minNow = dateNow.getMinutes();
    let count_day = 0, count_hour = 0, count_min = 0;
    let count_day_isSet = false;
    let isOver = false;

    // Set the date we're counting down to
    const countDownDate = new Date(year, month-1, day, tarhour, tarmin, 0, 0).getTime();

    $1(_config.target+' .day .word').innerHTML = _config.dayWord;
    $1(_config.target+' .hour .word').innerHTML = _config.hourWord;
    $1(_config.target+' .min .word').innerHTML = _config.minWord;
    $1(_config.target+' .sec .word').innerHTML = _config.secWord;

    const updateTime = () => {
      // Get todays date and time
      const now = new Date().getTime();

      // Find the distance between now an the count down date
      const distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      requestAnimationFrame(updateTime);

      $1(_config.target+' .day .num').innerHTML = addZero(days);
      $1(_config.target+' .hour .num').innerHTML = addZero(hours);
      $1(_config.target+' .min .num').innerHTML = addZero(minutes);
      $1(_config.target+' .sec .num').innerHTML = addZero(seconds);

      // If the count down is over, write some text
      if (distance < 0) {
        $1(".countdown1").innerHTML = "Finish";
      }
    }

    updateTime();
  }

const addZero = (x) => (x < 10 && x >= 0) ? "0"+x : x;

const myCountdown = new countdown({
  target: '.countdown',
  dayWord: 'jours',
  hourWord: 'heures',
  minWord: 'min',
  secWord: 'sec'
});

  const myCountdown1 = new countdown1({
    target: '.countdown1',
    dayWord: 'jours',
    hourWord: 'heures',
    minWord: 'min',
    secWord: 'sec'
  });
});


