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
    var shortName;
    fullName ? fullName = fullName.split(' ') : '';
    if (fullName) shortName = fullName[0] + ' ' + fullName[1];
    return shortName;
  }
// Lastname F.M. OR Lastname F.
	function fullNameToShortFirstMiddleNames(fullName, nameOnly) {
		var shortName;
		fullName ? fullName = fullName.split(' ') : '';
		if (fullName) {
			shortName = fullName[0] + ' ' + fullName[1][0] + '. ';
		}
		if (fullName[2] && !nameOnly && fullName[2] !== '-') {
			shortName = shortName + fullName[2][0] + '. ';
		}
		return shortName;
	}
// STOP SHORT NAMES

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
// STOP DATES

function modalInfoUniversal(text) {
  $('#modalUniversalInfo').modal().show();
  $('#universalInfoText').html(text);
}
