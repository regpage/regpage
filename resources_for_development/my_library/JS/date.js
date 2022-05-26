// DATES
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
  // ==== ДАТЫ ===
	// date convert ddmmyyyy to yyyymmdd & yyyymmdd to mmyyyy
	function dateStrToddmmyyyyToyyyymmdd(date, toRus, separator) {
		let yyyy, mm, dd;

		if (!date) {
			console.log('function should receive the next parameter: DATE');
			return
		}

		if (toRus) {
			separator ? '' : separator = '.';
			yyyy = date.slice(0,4),
			mm = date.slice(5,7),
			dd = date.slice(8,10);
			date = dd + separator + mm + separator + yyyy;
		} else if (!toRus || toRus == 0){
			separator ? '' : separator = '-';
			yyyy = date.slice(6,10),
			mm = date.slice(3,5),
			dd = date.slice(0,2);
			date = yyyy + '-' + mm + '-' + dd;
		}
		return date
	}

  function dateStrFromyyyymmddToddmm(date, separator) {
    let yyyy, mm, dd;

    if (!date) {
      console.log('function should receive the next parameter: DATE');
      return;
    }

    separator ? '' : separator = '.';
    //yyyy = date.slice(0,4),
    mm = date.slice(5,7),
    dd = date.slice(8,10);
    date = dd + separator + mm;

    return date
  }

  // текущая дата, получаем приводим к типу гггг.мм.дд
  function date_now_gl () {
    // YYYY-MM-dd
    let date_now_gl = new Date();
    let yyyy = date_now_gl.getFullYear();
    let mm = date_now_gl.getMonth()+1;
    let dd = date_now_gl.getDate();
    if (mm < 9) {
      mm = '0'+mm;
    }
    if (dd < 9) {
      dd = '0'+dd;
    }
    return yyyy + '-' + mm + '-' + dd;
  }
  date_now_gl = date_now_gl ();
