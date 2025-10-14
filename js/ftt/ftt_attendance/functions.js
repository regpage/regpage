/*** Ф А Й Л  Г О Т О В И Т С Я  ***/
function render_bible_chapters(book, chapter, selector) {
  let sim_1, counter_1 = 0, cap_rend=10;
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
  $(selector).html(options);
}
/*** BIBLE READING STOP ***/

// === ПРОВЕРКА ПРОРОЧЕСТВОВАНИЯ НА ПРОШЛОМ СОБРАНИИ
// получаем бланк прошлого воскресенья
function last_prophecy(member_key, date_blank) {
  date_blank = subtract_dates(date_blank, 7);
  fetch("ajax/ftt_attendance_ajax.php?type=get_prev_week_blank&member_key=" + member_key + "&date_blank=" + date_blank)
  .then(response => response.json())
  .then(commits => {
    if (commits === "0") {
      $("#note_prophecy").html("Вы не пророчествовали<br>на прошлой неделе.");
      $("#note_prophecy").show();
    } else if (commits === "1" || commits === '' || commits === null) {
      $("#note_prophecy").hide();
    } else if (commits === "2") {
      $("#note_prophecy").html(dateStrFromyyyymmddToddmm(date_blank) + " лист не<br>отправлен!");
      $("#note_prophecy").show();
    } else {
      $("#note_prophecy").text("Ошибка.");
      $("#note_prophecy").show();
    }
  });
}
// ПОДРАЗДЕЛ ЛИСТЫ ОТСУТСТВИЯ
// FUNCTION
// PERMISSIONS
function prepare_archive() {
  let archive_sessions = "", checked;
  $("#modal_permission_block label").each(function () {
    if (!$(this).find("input").hasClass("select_all_session")) {
      checked = "<label class='form-check-label pl-1'><input type='checkbox' class='form-check-input' disabled> ";
      if ($(this).find("input").prop("checked")) {
        checked =  "<label class='form-check-label pl-1'><input type='checkbox' class='form-check-input' checked disabled> ";
      }
      archive_sessions = archive_sessions + checked +" "+ $(this).text() + "</label><br>";
    }
  });
  return archive_sessions;
}
