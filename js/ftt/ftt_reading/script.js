function noSpace(book_name)
{
  let booksNoSpace, temp;
  temp = book_name.split(' ');
    if (temp.length > 1) {
      booksNoSpace = temp.join("&nbsp");
    } else {
      booksNoSpace = book_name;
    }

  return booksNoSpace;
}

function set_read_books(elem) {
  let book = split_book(elem.val());
  let prev_book, part, notes, set, id_prev_book;
  let found = bible_arr.find(e => e[0] === book[0]);
  prev_book = elem.attr("data-book");
  notes = elem.attr("data-notes");
  if (elem.attr("id") === "bible_book_ot") {
    part = "ot";
  } else {
    part = "nt";
  }
  if (prev_book !== book[0]) {
    id_prev_book = get_id_book(prev_book);
    id_curr_book = get_id_book(book[0]);
    books = read_books_check(book[0], prev_book);
    if (id_curr_book > id_prev_book) {
      set = 1;
    } else if (id_curr_book < id_prev_book) {
      set = 0;
    }
    books = books.join();
    let query = "member_key=" + window.adminId
    + "&part=" + part
    + "&books=" + books
    + "&notes=" + notes
    + "&set=" + set;
    fetch("ajax/ftt_reading_ajax.php?type=set_read_book_by_book&" + query)
    .then(response => response.text())
    .then(commits => {
      //console.log(commits.result);
      //elem.attr("data-book", book[0]);
    });
  }
}

// проверяем книги
function read_books_check(current, previous) {
  let sim_1 = false;
  let books = [];
  for (let i = 0; i < bible_arr.length; i++) {
    if (bible_arr[i][0] === current) {
      break;
    } else if (bible_arr[i][0] === previous || sim_1) {
      sim_1 = true;
      books.push(i);
    }
  }
  if (books.length === 0) {
    sim_1 = false;
    for (let i = 0; i < bible_arr.length; i++) {
      if (bible_arr[i][0] === previous) {
        break;
      } else if (bible_arr[i][0] === current || sim_1) {
        sim_1 = true;
        books.push(i);
      }
    }
  }
  return books;
}
// получаем id книги Библии
function get_id_book(book) {
  let id = "";
  for (let i = 0; i < bible_arr.length; i++) {
    if (bible_arr[i][0] === book) {
      id = i;
      break;
    }
  }
  return id;
}

function render_bible_chapters(book, chapter, selector) {
  let sim_1, counter_1 = 0, cap_rend = 10;
  let options = "<option value='_none_' disabled selected>";
  if (selector === "#bible_book_ot") {
    options += "ВЗ"
  } else {
    options += "НЗ"
  }
  if (!book) {
    $(selector).html(options);
    return;
  }

  if (book === "Мал.") {
    cap_rend = cap_rend - 5 - chapter;
  }

  if (book === "Зах.") {
    if (chapter > 8) {
      cap_rend = cap_rend - chapter + 9;
    }
  }

  options += "<option value='0'>нет";
  for (let i = 0; i < bible_arr.length; i++) {
    if (sim_1 === 2) {
      break;
    }
    if ((bible_arr[i][0] === book || sim_1 === 1) && counter_1 < cap_rend) {
      for (let j = 1; j <= bible_arr[i][1]; j++) {
        if ((j >= chapter || sim_1 === 1) && counter_1 < cap_rend) {
          if (sim_1 === 2) {
            break;
          }
          if (counter_1 < cap_rend) {
            options += "<option data-book='" + bible_arr[i][0] + "' data-chapter='" + j + "'>" + bible_arr[i][0] + " " + j;
            counter_1 ++;
            sim_1 = 1;
          } else {
            sim_1 = 2;
          }
        }
      }
    }
  }
  if (book === "Мал.") {
    options += "<option class='option_stop' value='"+book+"'>Завершить";
  } else if (book === "Отк." || chapter > 12) {
    options += "<option class='option_stop' value='"+book+"'>Завершить";
  }
  $(selector).html(options);
}

// CALENDAR
function calendar(records) {
  let Cal = function(divId) {
    //Сохраняем идентификатор div
    this.divId = divId;
    // Дни недели с понедельника
    this.DaysOfWeek = [
      'Пн',
      'Вт',
      'Ср',
      'Чт',
      'Пт',
      'Сб',
      'Вс'
    ];
    // Месяцы начиная с января
    this.Months =['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
    //Устанавливаем текущий месяц, год
    let d = new Date();
    this.currMonth = d.getMonth();
    this.currYear = d.getFullYear();
    this.currDay = d.getDate();
  };
  // Переход к следующему месяцу
  Cal.prototype.nextMonth = function() {
    if ( this.currMonth == 11 ) {
      this.currMonth = 0;
      this.currYear = this.currYear + 1;
    }
    else {
      this.currMonth = this.currMonth + 1;
    }
    this.showcurr();
  };
  // Переход к предыдущему месяцу
  Cal.prototype.previousMonth = function() {
    if ( this.currMonth == 0 ) {
      this.currMonth = 11;
      this.currYear = this.currYear - 1;
    }
    else {
      this.currMonth = this.currMonth - 1;
    }
    this.showcurr();
  };
  // Показать текущий месяц
  Cal.prototype.showcurr = function() {
    this.showMonth(this.currYear, this.currMonth);
  };
  // Показать месяц (год, месяц)
  Cal.prototype.showMonth = function(y, m) {
    let d = new Date()
    // Первый день недели в выбранном месяце
    , firstDayOfMonth = new Date(y, m, 7).getDay()
    // Последний день выбранного месяца
    , lastDateOfMonth =  new Date(y, m+1, 0).getDate()
    // Последний день предыдущего месяца
    , lastDayOfLastMonth = m == 0 ? new Date(y-1, 11, 0).getDate() : new Date(y, m, 0).getDate();
    let html = '<table>';
    // Запись выбранного месяца и года
    html += '<thead><tr>';
    html += '<td colspan="7">' + this.Months[m] + ' ' + y + '</td>';
    html += '</tr></thead>';
    // заголовок дней недели
    html += '<tr class="days">';
    for(let i=0; i < this.DaysOfWeek.length;i++) {
      html += '<td>' + this.DaysOfWeek[i] + '</td>';
    }
    html += '</tr>';
    // Записываем дни
    let i=1;
    do {
      let dow = new Date(y, m, i).getDay();
      // Начать новую строку в понедельник
      if ( dow == 1 ) {
        html += '<tr>';
      }
      // Если первый день недели не понедельник показать последние дни предыдущего месяца
      else if ( i == 1 ) {
        html += '<tr>';
        let k = lastDayOfLastMonth - firstDayOfMonth+1;
        for(let j=0; j < firstDayOfMonth; j++) {
          html += '<td class="not-current">' + k + '</td>';
          k++;
        }
      }
      // Записываем текущий день в цикл
      let chk = new Date();
      let chkY = chk.getFullYear();
      let chkM = chk.getMonth();
      if (chkY == y && chkM == m && i == this.currDay) { //this.currMonth
        let record_available = "", not_available = "";
        let date_record = chkY + '-' + (m < 9 ? '0' + String(m+1) : m+1)  + '-' + i;
        let books_read = "";
        // проверка, добавление класса
        found = records.find(e => e["date"] === date_record);

        if (found !== undefined) {
          if (found["date"] === date_record) {
            if (found["chapter_nt"] > 0 || found["chapter_ot"] > 0) {
              record_available = "record_available";
              if (found["book_nt"] && found["chapter_nt"] > 0) {
                books_read = found["book_nt"] + " " + found["chapter_nt"] + "; ";
              }
              if (found["book_ot"] && found["chapter_ot"] > 0) {
                books_read += found["book_ot"] + " " + found["chapter_ot"] + "; ";
              }
            } else {
              record_available = "record_not_available";
              books_read = "Нет";
            }
          }
        }

        html += '<td class="today ' + record_available + '" data-date="' + date_record + '">' + i + '</td>';
      } else {
        // проверка, добавление класса
        let record_available = "", day_date = i;
        let date_record = y + '-' + (m < 9 ? '0' + String(m+1) : m+1)  + '-' + (i < 10 ? '0' + String(day_date) : day_date);
        let books_read = "";
        found = records.find(e => e["date"] === date_record);

        if (found !== undefined) {
          if (found["date"] === date_record) {
            if (found["chapter_nt"] > 0 || found["chapter_ot"] > 0) {
              record_available = "record_available";
              if (found["book_nt"] && found["chapter_nt"] > 0) {
                books_read = found["book_nt"] + " " + found["chapter_nt"] + "; ";
              } else if(found["book_nt"]) {
                books_read = found["book_nt"] + " нет;";
              }
              if (found["book_ot"] && found["chapter_ot"] > 0) {
                books_read += found["book_ot"] + " " + found["chapter_ot"] + "; ";
              } else if(found["book_ot"]) {
                books_read += found["book_ot"] + " нет;";
              }
            } else {
              record_available = "record_not_available";
              books_read = "Нет";
            }
          }
        }

        html += '<td class="normal ' + record_available + '" data-toggle="tooltip" data-date="' + date_record + '" title="' + books_read + '">' + i + '</td>';
      }
      // закрыть строку в воскресенье
      if (dow == 0) {
        html += '</tr>';
      }
      // Если последний день месяца не воскресенье, показать первые дни следующего месяца
      else if ( i == lastDateOfMonth ) {
        let k=1;
        for(dow; dow < 7; dow++) {
          html += '<td class="not-current">' + k + '</td>';
          k++;
        }
      }
      i++;
    }while(i <= lastDateOfMonth);
    // Конец таблицы
    html += '</table>';
    // Записываем HTML в div
    document.getElementById(this.divId).innerHTML = html;
    $('[data-toggle="tooltip"]').tooltip();

  };

  // Начать календарь
  let c = new Cal("divCal");
  c.showcurr();
  // Привязываем кнопки «Следующий» и «Предыдущий»
  getId('btnNext').onclick = function() {
    c.nextMonth();
  };
  getId('btnPrev').onclick = function() {
    c.previousMonth();
  };

  // Получить элемент по id
  function getId(id) {
    return document.getElementById(id);
  }
}

function get_data_reading_statistic_semester(elem, filter, semesters) {
  fetch("ajax/ftt_reading_ajax.php?type=get_reading_statistic_semester&filter=" + filter + "&semesters=" + semesters)
  .then(response => response.json())
  .then(commits => {
    render_reading_statistic_semester(commits.result, elem);
  });
}

function render_reading_statistic_semester(data, elem) {
  // html
  // перебрать данные подсветить жирным прочитанные книги
  // печать один обучающийся 1 страница
  // полосы прокрутки везде
  let render_html = "<table><tbody>";
  for (const string in data) {
    if (data.hasOwnProperty(string)) {
      // Ветхий Завет (с примечаниями или без)
      let notes_ot_text = "без примечаний";
      if (data[string]["reading"]["notes_ot"] == 1) {
        notes_ot_text = "с примечаниями";
      }

      let notes_nt_text = "без примечаний";
      if (data[string]["reading"]["notes_nt"] == 1) {
        notes_nt_text = "с примечаниями";
      }
      // start
      let start_ot = "";
      let start_nt = "";
      if (!data[string]["start"]['book_ot']) {
        start_ot = "(сейчас не читает)";
      }
      if (!data[string]["start"]['book_nt']) {
        start_nt = "(сейчас не читает)";
      }

      render_html += "<tr><td>"
      render_html += data[string]["trainee"][0] + " (" +  data[string]["trainee"][4] + ")<br><br>";
      render_html += "Ветхий Завет " + notes_ot_text + " — " + data[string]["ot_in_Percent"] + " " + start_ot + "<br>";
      render_html += render_list_bible_books(data[string]["books"], 0, 39, data[string]["reading"]["books"]);
      render_html += "<br><br>";
      render_html += "Новый Завет " + notes_nt_text + " — " + data[string]["nt_in_Percent"] + " " + start_nt + "<br>";
      render_html += render_list_bible_books(data[string]["books"], 39, 66, data[string]["reading"]["books"]);
      render_html += "<br><hr>";
      render_html += "</td></tr>"
    }
  }
  render_html += "</tbody></table>";
  elem.html(render_html);
}

function render_list_bible_books(books, start, end, read_books) {
  if (!read_books) {
    read_books = [];
  }
  let render_html_list_bible_books = "";
  for (let i = start; i < end; i++) {
    if (read_books.includes(books[i][0])) {
      render_html_list_bible_books += "<b>" + books[i][0] + "</b> ";
    } else {
      render_html_list_bible_books += books[i][0] + " ";
    }
  }
  return render_html_list_bible_books;
}

function print_report_reading(selector) {

  function printElem(elem){
    popup($(elem).html());
  }

  function popup(data){
    let mywindow = window.open('', 'Статистика', 'height=600,width=800');
    mywindow.document.write('<html><head><title>Чтение. Для отправки на принтер нажмите Ctrl+P.</title>');
    mywindow.document.write('</head><body><style>td {vertical-align: top; text-align: left;} </style>'); // tr {height: 270mm;}
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');
    //mywindow.print();
    //mywindow.close();
    //return true;
  }

  printElem(selector);
}
