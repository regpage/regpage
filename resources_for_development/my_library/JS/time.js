// TIME
  function time_plus_minutes(time, minutes) {
    time = time.split(":");
    time = (time[0] * 60 * 60) + (time[1] * 60) + (minutes * 60);
    let h = parseInt(time / (60 * 60));
    let m = parseInt((time - (h * 60 * 60)) / (60));

    if (h < 10) {
      h = "0" + String(h);
    }

    if (m < 10) {
      m = "0" + String(m);
    }

    return h+":"+m;
  }
// STOP TIME
