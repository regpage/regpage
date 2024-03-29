// Cookies
function setCookie(name, value, exdays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=name + "=" + c_value + '; Secure';
}

function getCookie(name){
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + name + "=");
    if (c_start == -1){
        c_start = c_value.indexOf(name + "=");
    }
    if (c_start == -1){
        c_value = null;
    }
    else{
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1)
        {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}

function setCookieNew(name, value, options) {
    options = options || {};

    var expires = options.expires;
    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true){
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

// cash. Update page.
function doCheckCash() {
  var lastSesion = getCookie('time_cash_check');
  d = new Date();
  if (lastSesion !== 'undefined') {
    if ((d.getTime() - lastSesion) > 25000) {
      setCookie('time_cash_check', d.getTime());
      location.reload();
    }
  } else {
    setCookieNew('time_cash_check', d.getTime());
    location.reload();
  }
}

doCheckCash();

var myVar = setInterval(cashTimer, 1500);
function cashTimer() {
	var lastSesion = getCookie('time_cash_check');
	var d = new Date();
	if (lastSesion !== 'undefined') {
		if ((d.getTime() - lastSesion) > 25000) {
      setCookie('time_cash_check', d.getTime());
			location.reload();
		} else {
			setCookie('time_cash_check', d.getTime());
		}
	} else {
		setCookieNew('time_cash_check', d.getTime());
    location.reload();
	}

  //document.getElementById("demo").innerHTML = d.toLocaleTimeString();
}

// Message for user
// Message show

function showHint(html, time) {
  time = time || 2000;
  if (isNaN(time)) {
    time = 2000;
  }

	$("#globalHint > span").html (html);
	$("#globalHint").fadeIn();
	window.setTimeout(function() { $("#globalHint").fadeOut (); }, time);
	$(".close-alert").click(function() {
		$("#globalHint").attr('style','display: none;');
	});
}
// Error show
function showError(html, autohide) {
	$("#globalError > span").html (html);
  var a = $("#globalError > span").text();
  if (a.length === 0) {
    //window.location = "login.php?returl="+/\/[^\/]+$/g.exec (document.URL);
    var b = window.location.href;
    window.location = b;
  }
	$("#globalError").fadeIn();
	if (autohide || typeof autohide === "undefined") window.setTimeout(function() { $("#globalError").fadeOut (); }, 4000);
	$(".close-alert").click(function() {
		$("#globalError").attr('style','display: none;');
	});
}
// Help show
function showHelp(html, autohide, time) {
	if (time || typeof time === "undefined") time = 8000;
	$("#globalHelp > span").html (html);
	$("#globalHelp").fadeIn();
	if (autohide || typeof autohide === "undefined") window.setTimeout(function() { $("#globalHelp").fadeOut (); }, time);
	$(".close-alert").click(function() {
		$("#globalHelp").attr('style','display: none;');
	});
}
// STOP Message for user

// ФИО SHORT NAMES
// Lastname Firstname (without Middle name)
  function fullNameToNoMiddleName(fullName) {
    let names_parts;
    if (fullName) {
      names_parts = fullName.split(' ');
      if (names_parts[2]) {
        return names_parts[0] + ' ' + names_parts[1];
      } else {
        return fullName;
      }
    } else {
      return fullName;
    }
  }
// Lastname F.M. OR Lastname F.
	function fullNameToShortFirstMiddleNames(fullName, nameOnly) {
		var shortName;
		fullName ? fullName = fullName.split(' ') : '';
		if (fullName) {
			shortName = fullName[0] + ' ' + fullName[1][0] + '.';
		}
		if (fullName[2] && !nameOnly && fullName[2] !== '-') {
			shortName = shortName +" "+fullName[2][0] + '. ';
		}
		return shortName;
	}
// STOP SHORT NAMES

// ==== DATE ===
// текущая дата, получаем приводим к типу гггг.мм.дд
function date_now_gl () {
  // YYYY-MM-dd
  let date_now = new Date();
  let yyyy = date_now.getFullYear();
  let mm = date_now.getMonth()+1;
  let dd = date_now.getDate();
  if (mm <= 9) {
    mm = '0'+mm;
  }
  if (dd <= 9) {
    dd = '0'+dd;
  }
  return yyyy + '-' + mm + '-' + dd;
}
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

	// date convert mmyyyy to yyyymmdd & yyyymmdd to mmyyyy
	function dateStrToddmmyyyyToyyyymmdd(date, toRus, separator) {
		var yyyy, mm, dd;

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
    var yyyy, mm, dd;

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

  // ПОЛУЧИТЬ ВОЗРАСТ ПО ДАТЕ рождения
  function get_current_age(date) {
    return ((new Date().getTime() - new Date(date)) / (24 * 3600 * 365.25 * 1000)) | 0;
  }

  function compare_date(d1, d2, less) {
  	let current, dm;
  	if (!d2) {
  		current = new Date();
      current.setDate(current.getDate() - 1);
  		d1 = new Date(d1);
  		// Вчера и раньше от текущей даты
  		return (current - d1) > 0;
  	} else if (less) {
      d1 = new Date(d1);
  		d2 = new Date(d2);
  		// Вчера и раньше от d1
  		return (d1 - d2) > 0;
    } else {
  		d1 = new Date(d1);
  		d2 = new Date(d2);
  		// Разница между двумя датами в милисекундах
  		return d1 - d2;
  	}
  	// добавить вычесление количества дней если нет стандартной функции
  }
function modalInfoUniversal(text) {
  $('#modalUniversalInfo').modal().show();
  $('#universalInfoText').html(text);
}
// STOP DATES
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

function modalInfoUniversal(text) {
  // так же передавать селектор универсального окна и записывать в бади
  $('#modalUniversalInfo').modal().show();
  $('#universalInfoText').html(text);
}

function get_ftt_param(param, elem) {
  if (!param || !elem) {
    return "error";
  }
  fetch("ajax/ftt_request_ajax.php?type=get_ftt_param&param="+param)
  .then(response => response.json())
  .then(result => elem.html(result.result));
}

function he(str) {
    return str ? String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;') : "";
}

// Разделы Посещаемость и Чтение разделени книги и главы Библии
function split_book(text) {
  let book_slice = text;
  let book, chapter;
  book_slice = book_slice.split(" ");
  if (book_slice[2]) {
    book = book_slice[0] + " " + book_slice[1];
    chapter = book_slice[2];
  } else {
    book = book_slice[0];
    chapter = book_slice[1];
  }
  return [book, chapter];
}
