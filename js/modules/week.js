/* ==== WEEK ==== */
// get (today or from date parameter) Name Day Of Week By Day Number true = short name / false = full name
function getNameDayOfWeekByDayNumber(date, short, no_capital, number) {
  let day;

  if (date) {
    day = new Date(date);
  } else {
    day = new Date();
  }

  let dayNumber = day.getDay();

  if (number) {
    return dayNumber;
  }

  let weekday = new Array(7);

  if (short && !no_capital) {
    weekday[0] = "Вс";
    weekday[1] = "Пн";
    weekday[2] = "Вт";
    weekday[3] = "Ср";
    weekday[4] = "Чт";
    weekday[5] = "Пт";
    weekday[6] = "Сб";
  } else if (short && no_capital) {
    weekday[0] = "вс";
    weekday[1] = "пн";
    weekday[2] = "вт";
    weekday[3] = "ср";
    weekday[4] = "чт";
    weekday[5] = "пт";
    weekday[6] = "сб";
  } else {
    weekday[0] = "Воскресенье";
    weekday[1] = "Понедельник";
    weekday[2] = "Вторник";
    weekday[3] = "Среда";
    weekday[4] = "Четверг";
    weekday[5] = "Пятница";
    weekday[6] = "Суббота";
  }
  return weekday[dayNumber];
}


function get_curr_week_begin_end () {
  let d = get_current_monday();
  let result = [];
  result.push(d.toISOString().split('T')[0]);
  d.setDate(d.getDate() + 6);
  result.push(d.toISOString().split('T')[0]);

  return result;
}


function get_curr_week_dates (week) {
  if (!week || isNaN(week)) {
    week = 1;
  }
  let count = week * 7;
  let d = get_current_monday();
  let weeks = [], temp;
  for (let i = 0; i < count; i++) {
    if (i === 0) {
      temp = d.toISOString().split('T')[0];
    } else {
      d.setDate(d.getDate() + 1);
      temp = d.toISOString().split('T')[0];
    }
    weeks.push(temp);
  }
  return weeks;
}


function get_current_monday (yyyymmdd) {

  let d = new Date();
  let week_day = d.getDay();

  // получаем понедельник текущей недели
  if (week_day === 1) {
    week_day = 0;
  } else if (week_day === 0) {
    week_day = 6;
  } else {
    week_day = week_day-1;
  }

  if (yyyymmdd) {
    d.setDate(d.getDate() - week_day);
    return d.toISOString().split('T')[0];
  } else {
    d.setDate(d.getDate() - week_day);
    return d;
  }
}

/* ==== STOP WEEK ==== */
