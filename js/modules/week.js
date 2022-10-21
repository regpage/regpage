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
/* ==== STOP WEEK ==== */
