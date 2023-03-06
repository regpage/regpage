/* ==== DATE ==== */
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

// принимает даты в формате гггг-мм-дд
function compare_date(d1, d2) {
	let current, dm;
	if (!d2) {
		current = new Date();
    current.setDate(current.getDate() - 1);
		d1 = new Date(d1);
		// Вчера и раньше от текущей даты
		return (current - d1) > 0;
	} else {
		d1 = new Date(d1);
		d2 = new Date(d2);
		// Разница между двумя датами в милисекундах
		return d1 - d2;
	}
	// добавить вычесление количества дней если нет стандартной функции
}
/* ==== STOP DATE ==== */
