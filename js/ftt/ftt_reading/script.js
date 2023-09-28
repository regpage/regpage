$(document).ready(function(){
  // *** С Т А Т И С Т И К А *** //
  // Статистика чтения библии
  $(".bible_statistic_btn").click(function () {
    $('#spinner').modal("show");
    fetch("ajax/ftt_attendance_ajax.php?type=get_bible_statistic&trainee_id=" + $("#modalAddEdit").attr("data-member_key"))
    .then(response => response.json())
    .then(commits => {
      if (commits.result.length > 0) {
        $("#bible_statistic_list").find("canvas").remove();
        $("#bible_statistic_list").append("<canvas></canvas>");
        const brc = $("#bible_statistic_list").find("canvas")[0].getContext('2d');
        let books = [];
        let capters = [];
        let persent = [];
        for (var i = 0; i < commits.result.length; i++) {
          for (let column in commits.result[i]) {
              if (commits.result[i].hasOwnProperty(column)) {
                if (i === 0) {
                  books.push(commits.result[i][column]);
                } else if (i === 1) {
                  capters.push(commits.result[i][column]);
                } else if (i === 2) {
                  persent.push(commits.result[i][column]);
                }
              }
          }
        }

        new Chart(brc, {
          type: "bar",
          data: {
            labels: books,
            datasets: [{
              label: '100%',
              data: persent,
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
    });

    // статистика с датами
    fetch("ajax/ftt_attendance_ajax.php?type=get_bible_statistic_dates&trainee_id=" + $("#modalAddEdit").attr("data-member_key"))
    .then(response => response.json())
    .then(commits => {
      console.log(commits.result);
      if (commits.result.length > 0) {
        $("#bible_statistic_list_dates").find("canvas").remove();
        $("#bible_statistic_list_dates").append("<canvas></canvas>");
        const brc = $("#bible_statistic_list_dates").find("canvas")[0].getContext('2d');
        let books = [];
        let capters = [];
        let persent = [];
        for (var i = 0; i < commits.result.length; i++) {
          for (let column in commits.result[i]) {
              if (commits.result[i].hasOwnProperty(column)) {
                if (i === 0) {
                  books.push(commits.result[i][column] + " " + commits.result[i+3][column]);
                } else if (i === 1) {
                  capters.push(commits.result[i][column]);
                } else if (i === 2) {
                  persent.push(commits.result[i][column]);
                } else if (i === 3) {
                  persent.push(commits.result[i][column]);
                }
              }
          }
        }

        new Chart(brc, {
          type: "bar",
          data: {
            labels: books,
            datasets: [{
              label: '100%',
              data: persent,
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
      $('#spinner').modal("hide");
    });

    setTimeout(function () {
      $("body").addClass("modal-open");
      $("body").attr("style", "padding-right: 15px;");
    }, 500);
    $("#mdl_bible_statistic").on("hide.bs.modal", function () {
      setTimeout(function () {
        $("body").addClass("modal-open");
      }, 500);
    });
  });

  // *** С Л У Ж А Щ И Е *** //
  // отметка книг
  $(".edit_read_books_str").click(function () {
    $("#mdl_bible_check_book").modal("show");
    $("#ftr_trainee_reading_check_mbl").val($(this).parent().parent().find(".btn").attr("data-member_key"));

    // получаем прочитанные книги выбранного обучающегося
    fetch("ajax/ftt_reading_ajax.php?type=get_read_book&member_key=" + $("#ftr_trainee_reading_check_mbl").val())
    .then(response => response.json())
    .then(commits => {
      let read_data = commits.result, disabled;
      for (let i = 0; i < read_data.length; i++) {
        if (read_data[i][2] === 1) {
          $("#mdl_bible_books_check input[data-book='"+read_data[i][0]+"']").prop("disabled", true);
        } else {
          $("#mdl_bible_books_check input[data-book='"+read_data[i][0]+"']").prop("disabled", false);
        }
        $("#mdl_bible_books_check input[data-book='"+read_data[i][0]+"']").prop("checked", true);
      }
    });
  });

  // правка
  $(".edit_read").click(function () {
    $("#mdl_edit_read").attr("data-member_key", $(this).parent().parent().find(".btn").attr("data-member_key"));
    $("#mdl_edit_read_name").text(trainee_list[$(this).parent().parent().find(".btn").attr("data-member_key")]);
    $("#date_read").val(gl_date_now);
    // получаем данные по дате
    fetch("ajax/ftt_reading_ajax.php?type=get_reading_data&member_key="
    + $(this).parent().parent().find(".btn").attr("data-member_key") + "&date=" + gl_date_now)
    .then(response => response.json())
    .then(commits => {
      let data = commits.result;
      if (data["book_ot"]) {
        render_bible_chapters(data["book_ot"], data["chapter_ot"], "#bible_book_ot");
        $("#bible_book_ot").attr("data-book", data["book_ot"]);
        $("#bible_book_ot").attr("data-chapter", data["chapter_ot"]);
        if (data["today_ot"] > 0) {
          $("#bible_book_ot").val(data["book_ot"] + " " + data["chapter_ot"]);
        }
        $("#bible_book_ot").attr("disabled", false);
      } else {
        $("#bible_book_ot").val("");
        $("#bible_book_ot").attr("disabled", true);
      }
      if (data["book_nt"]) {
        render_bible_chapters(data["book_nt"], data["chapter_nt"], "#bible_book_nt");
        $("#bible_book_nt").attr("data-book", data["book_nt"]);
        $("#bible_book_nt").attr("data-chapter", data["chapter_nt"]);
        if (data["today_nt"] > 0) {
          $("#bible_book_nt").val(data["book_nt"] + " " + data["chapter_nt"]);
        }
        $("#bible_book_nt").attr("disabled", false);
      } else {
        $("#bible_book_nt").val("");
        $("#bible_book_nt").attr("disabled", true);
      }
      if (data["start_today"]) {
        $("#bible_book_nt").attr("disabled", true);
        $("#bible_book_ot").attr("disabled", true);
        $("#save_book_read").attr("disabled", true);
      } else {
        $("#save_book_read").attr("disabled", false);
      }
    });
    $("#mdl_edit_read").modal("show");
  });

  // Архив
  $(".read_name .btn").click(function () {
    $("#mdl_reading_archive").modal("show");
    // получаем прочитанные книги выбранного обучающегося
    fetch("ajax/ftt_reading_ajax.php?type=get_history_reading_bible&member_key=" + $(this).attr("data-member_key"))
    .then(response => response.json())
    .then(commits => {
      let history = commits.result;
      let html = "<div>";
      $("#mdl_history_read_name").text(trainee_list[$(this).attr("data-member_key")]);
      for (let i = 0; i < history.length; i++) {
        let bg_green = "";
        if (history[i]["chapter_nt"] > 0 || history[i]["chapter_ot"] > 0) {
          bg_green = "green_string";
        }
        html += "<span class='p-2 mb-2 d-inline-block " + bg_green + "'>" + dateStrFromyyyymmddToddmm(history[i]["date"]) + "</span> ";
      }
      $("#mdl_lest_reading_bible").html(html);
    });
  });
  // фильтр
  $("#read_sevice_one_select").change(function () {
    setCookie("flt_serving_one_read", $(this).val());
    setTimeout(function () {
      location.reload();
    }, 30);
  });

  $("#ftr_trainee_reading_check_mbl").change(function () {
    $("#mdl_bible_books_check input").each(function () {
      $(this).prop("checked", false);
      $(this).prop("disabled", false);
    });
    // получаем прочитанные книги выбранного обучающегося
    fetch("ajax/ftt_reading_ajax.php?type=get_read_book&member_key=" + $(this).val())
    .then(response => response.json())
    .then(commits => {
      let read_data = commits.result, disabled;
      for (let i = 0; i < read_data.length; i++) {
        if (read_data[i][2] === 1) {
          $("#mdl_bible_books_check input[data-book='"+read_data[i][0]+"']").prop("disabled", true);
        } else {
          $("#mdl_bible_books_check input[data-book='"+read_data[i][0]+"']").prop("disabled", false);
        }
        $("#mdl_bible_books_check input[data-book='"+read_data[i][0]+"']").prop("checked", true);
      }
    });
  });

  // Записываем прочитанную книгу для обучающегося
  $("#mdl_bible_books_check input").change(function () {
    if ($("#ftr_trainee_reading_check_mbl").val() === "_none_") {
      showError("Выберите обучающегося");
      $(this).prop("checked", false);
      return;
    }
    let query = "&member_key=" + $("#ftr_trainee_reading_check_mbl").val()
    + "&part=" + $(this).parent().parent().attr("data-part")
    + "&book=" + $(this).attr("data-book")
    + "&chapter=" + $(this).attr("data-chapter")
    + "&checked=" + $(this).prop("checked");
    fetch("ajax/ftt_reading_ajax.php?type=set_read_book" + query)
    .then(response => response.json())
    .then(commits => {
    });
  });

  $("#mdl_bible_check_book").on("hide.bs.modal", function () {
    $("#mdl_bible_books_check input").each(function () {
      $(this).prop("checked", false);
      $(this).prop("disabled", false);
    });
    $("#ftr_trainee_reading_check_mbl").val("_none_");
  });

  // *** О Б У Ч А Ю Щ И Е С Я *** //
  // ЧТЕНИЕ БИБЛИИ СТАРТ
  // сохраняем позицию старта
  $("#set_start_reading_bible").click(function () {
    let chosen_book = 0;
    let text_ot = "", text_nt = "", comma = "";
    if ($("#mdl_nt_start").prop("checked") && $("#mdl_ot_start").prop("checked")) {
      chosen_book = 3;
      text_ot = $("#mdl_book_ot_start").val();
      if ($("#mdl_footnotes_ot_start").prop("checked")) {
        text_ot += " с прим.";
      }
      comma = ", ";
      text_nt = $("#mdl_book_nt_start").val();
      if ($("#mdl_footnotes_nt_start").prop("checked")) {
        text_nt += " с прим.";
      }
    } else if ($("#mdl_ot_start").prop("checked")) {
      chosen_book = 1;
      text_ot = $("#mdl_book_ot_start").val();
      if ($("#mdl_footnotes_ot_start").prop("checked")) {
        text_ot += " с прим.";
      }
    } else if ($("#mdl_nt_start").prop("checked")) {
      chosen_book = 2;
      text_nt = $("#mdl_book_nt_start").val();
      if ($("#mdl_footnotes_nt_start").prop("checked")) {
        text_nt += " с прим.";
      }
    } else {
      showError("Выберите книгу.");
      return;
    }
    let member_key;
    if (trainee_access === "1") {
      member_key = window.adminId;
    } else {
      member_key = $("#mdl_edit_read").attr("data-member_key");
    }
    let date_now = date_now_gl();
    let footnotes_ot = $("#mdl_footnotes_ot_start").prop("checked") ? 1 : 0;
    let footnotes_nt = $("#mdl_footnotes_nt_start").prop("checked") ? 1 : 0;
    // clear history
    let footnotes_ot_change = "";
    let footnotes_nt_change = "";
    let and = "";
    if (($("#bible_book_ot").attr("data-notes") != footnotes_ot) && $("#bible_book_ot").attr("data-book")) {
      footnotes_ot_change = " Ветхому Завету";
    }
    if (($("#bible_book_nt").attr("data-notes") != footnotes_nt) && $("#bible_book_nt").attr("data-book")) {
      footnotes_nt_change =  " Новому Завету";
    }
    if (footnotes_ot_change || footnotes_nt_change) {
      if (footnotes_ot_change && footnotes_nt_change) {
        and = " и";
      }
      if (confirm("Вы начинаете заново? Удалить предыдущую историю чтения по" + footnotes_ot_change + and + footnotes_nt_change + "?")) {
        fetch("ajax/ftt_reading_ajax.php?type=dlt_history_reading_bible&member_key=" + member_key + "&ot=" + footnotes_ot_change + "&nt=" + footnotes_nt_change)
        .then(response => response.json())
        .then(commits => {

        });
      } else {
        return;
      }
    }
    // query
    let param = "&member_key=" + member_key +
    "&date=" + date_now +
    "&chosen_book=" + chosen_book +
    "&book_ot=" + $("#mdl_book_ot_start").val() +
    "&chapter_ot=" + $("#mdl_chapter_ot_start").val() +
    "&footnotes_ot=" + footnotes_ot +
    "&book_nt=" + $("#mdl_book_nt_start").val() +
    "&chapter_nt=" + $("#mdl_chapter_nt_start").val() +
    "&footnotes_nt=" + footnotes_nt;
    $("#spinner").modal("show");
    fetch("ajax/ftt_reading_ajax.php?type=set_start_reading_bible" + param)
    .then(response => response.json())
    .then(commits => {
      //console.log(commits.result);
      if (commits.result === "e001") {
        // error 001 некорректные входные данные
        showError("Запись не сохранена. Не корректные входные данные.");
        $("#spinner").modal("hide");
        return;
      } else if(commits.result) {
        showHint("Запись сохранена.");
      } else {
        showError("Запись не сохранена. Обратитесь в разработчику.");
        $("#spinner").modal("hide");
        return;
      }
      $("#spinner").modal("hide");
    });

    setTimeout(function () {
      $("#mdl_bible_start").modal("hide");
    }, 250);
    setTimeout(function () {
      location.reload();
    }, 700);
  });

  $("#mdl_bible_start").on("hide.bs.modal", function () {
    $("#mdl_bible_start input[type='checkbox']").prop("checked", false);
  });

  // смена книг в модальном окне
  $("#mdl_book_ot_start, #mdl_book_nt_start").change(function() {
    let bible_chapter_html = "";
    let found;
    found = bible_arr.find(e => e[0] === $(this).val());
    for (let i = 1; i <= found[1]; i++) {
      bible_chapter_html += "<option value='"+i+"'>"+i;
    }
    if ($(this).attr("id") === "mdl_book_ot_start") {
      $("#mdl_chapter_ot_start").html(bible_chapter_html);
    } else {
      $("#mdl_chapter_nt_start").html(bible_chapter_html);
    }
  });

  // открываем модальное окно старта
  $("#show_me_start").click(function () {
    if ($("#bible_book_ot").attr("disabled") && $("#bible_book_nt").attr("disabled")) {
      return;
    }

    if ($("#bible_book_ot").attr("data-book")) {
      let bible_chapter_html = "";
      let found = bible_arr.find(e => e[0] === $("#bible_book_ot").attr("data-book"));
      for (let i = 1; i <= found[1]; i++) {
        bible_chapter_html += "<option value='"+i+"'>"+i;
      }
      $("#mdl_chapter_ot_start").html(bible_chapter_html);
    } else {
      $("#mdl_book_ot_start").val("Быт.");
      $("#mdl_chapter_ot_start").val(1);
    }

    if ($("#bible_book_nt").attr("data-book")) {
      let bible_chapter_html = "";
      let found = bible_arr.find(e => e[0] === $("#bible_book_nt").attr("data-book"));
      for (let i = 1; i <= found[1]; i++) {
        bible_chapter_html += "<option value='"+i+"'>"+i;
      }
      $("#mdl_chapter_nt_start").html(bible_chapter_html);
    } else {
      $("#mdl_book_nt_start").val("Мф.");
      $("#mdl_chapter_nt_start").val(1);
    }
    $("#mdl_bible_start select").attr("disabled", true);
    $("#mdl_footnotes_ot_start").attr("disabled", true);
    $("#mdl_footnotes_nt_start").attr("disabled", true);
    let ot, nt;
    if (!$("#bible_book_ot").attr("disabled")) {
      if ($("#bible_book_ot").val() && $("#bible_book_ot").val() !== "0" && $("#bible_book_ot").val() !== "_none_") {
        ot = split_book($("#bible_book_ot").val());
        if (ot[0] !== $("#bible_book_ot").attr("data-book") || ot[1] !== $("#bible_book_ot").attr("data-chapter")) {
          showError("Пожалуйста, сначала сохраните изменения, нажав кнопку записать.");
          return;
        }
      } else {
        ot = split_book($("#bible_book_ot option:nth-child(3)").attr("data-book") + " " + $("#bible_book_ot option:nth-child(3)").attr("data-chapter"));
      }
      $("#mdl_book_ot_start").val(ot[0]);
      $("#mdl_chapter_ot_start").val(ot[1]);
      $("#mdl_footnotes_ot_start").prop("checked", $(".reading_bible_title").attr("data-notes_ot") === "1" ? true : false);
      let found = bible_arr.find(e => e[0] === ot[0]);
      if (found[1] === ot[1]) {
        $("#mdl_ot_start").attr("disabled", false);
        $("#mdl_ot_start").prop("checked", false);
        // при использовании этого варианта нужно доп правило для активации кнопки "сохр."
        //$("#mdl_bible_start select").attr("disabled", false);
        //$("#mdl_footnotes_ot_start").attr("disabled", false);
      } else {
        $("#mdl_ot_start").attr("disabled", true);
        $("#mdl_ot_start").prop("checked", true);
      }
    }
    if (!$("#bible_book_nt").attr("disabled")) {
      if ($("#bible_book_nt").val() && $("#bible_book_nt").val() !== "0" && $("#bible_book_nt").val() !== "_none_") {
        nt = split_book($("#bible_book_nt").val());
        if (nt[0] !== $("#bible_book_nt").attr("data-book") || nt[1] !== $("#bible_book_nt").attr("data-chapter")) {
          showError("Пожалуйста, сначала сохраните изменения, нажав кнопку записать.");
          return;
        }
      } else {
        nt = split_book($("#bible_book_nt option:nth-child(3)").attr("data-book") + " " + $("#bible_book_nt option:nth-child(3)").attr("data-chapter"));
      }
      $("#mdl_book_nt_start").val(nt[0]);
      $("#mdl_chapter_nt_start").val(nt[1]);
      $("#mdl_footnotes_nt_start").prop("checked", $(".reading_bible_title").attr("data-notes_nt") === "1" ? true : false);
      let found = bible_arr.find(e => e[0] === nt[0]);
      if (found[1] === nt[1]) {
        $("#mdl_nt_start").attr("disabled", false);
        $("#mdl_nt_start").prop("checked", false);
        //$("#mdl_bible_start select").attr("disabled", false);
        //$("#mdl_footnotes_nt_start").attr("disabled", false);
      } else {
        $("#mdl_nt_start").attr("disabled", true);
        $("#mdl_nt_start").prop("checked", true);
      }
    }

    $("#set_start_reading_bible").attr("disabled", true);
    $("#mdl_bible_start").modal("show");
  });

  $("#mdl_ot_start, #mdl_nt_start").change(function () {
    if ($(this).attr("id") === "mdl_ot_start") {
      if ($(this).prop("checked")) {
        $("#mdl_footnotes_ot_start").attr("disabled", false);
        $("#mdl_book_ot_start").attr("disabled", false);
        $("#mdl_chapter_ot_start").attr("disabled", false);
      } else {
        $("#mdl_footnotes_ot_start").attr("disabled", true);
        $("#mdl_book_ot_start").attr("disabled", true);
        $("#mdl_chapter_ot_start").attr("disabled", true);
      }
    } else {
      if ($(this).prop("checked")) {
        $("#mdl_footnotes_nt_start").attr("disabled", false);
        $("#mdl_book_nt_start").attr("disabled", false);
        $("#mdl_chapter_nt_start").attr("disabled", false);
      } else {
        $("#mdl_footnotes_nt_start").attr("disabled", true);
        $("#mdl_book_nt_start").attr("disabled", true);
        $("#mdl_chapter_nt_start").attr("disabled", true);
      }
    }

    if (($("#mdl_ot_start").prop("checked") && !$("#mdl_ot_start").attr("disabled")) || ($("#mdl_nt_start").prop("checked") && !$("#mdl_nt_start").attr("disabled"))) {
      $("#set_start_reading_bible").attr("disabled", false);
    } else {
      $("#set_start_reading_bible").attr("disabled", true);
    }
  });

  // save chapter
  function save_field_read(field, date, book, chapter, notes_ot, notes_nt) {
    let member_key;
    if (trainee_access === "1") {
      member_key = window.adminId;
    } else {
      member_key = $("#mdl_edit_read").attr("data-member_key");
    }
    let data = "&member_key=" + member_key
    + "&date=" + date
    + "&book_field=" + field + "&book=" + book + "&chapter=" + chapter
    + "&notes_ot=" + notes_ot
    + "&notes_nt=" + notes_nt;
    fetch("ajax/ftt_reading_ajax.php?type=set_reading_bible" + data)
    .then(response => response.text())
    .then(commits => {
      //console.log(commits.result);
    });
  }

  // сохраняем чтение
$("#save_book_read").click(function () {
  if ($("#bible_book_ot").attr("disabled") && $("#bible_book_nt").attr("disabled")) {
    showError("Нельзя сохранить.");
    return;
  } else if ((!$("#bible_book_ot").val() || $("#bible_book_ot").val() === "_none_") && (!$("#bible_book_nt").val() || $("#bible_book_nt").val() === "_none_")) {
    showError("Укажите прочитанные главы в списке или выберите «нет» ");
    return;
  }

  if ($("#bible_book_ot").val() && $("#bible_book_ot").val() != 0 && $("#bible_book_ot").val() !== "_none_" && !$("#bible_book_ot").attr("disabled")) {
    let data_ot = split_book($("#bible_book_ot").val());
    save_field_read($("#bible_book_ot").attr("data-field"), $("#date_read").val(), data_ot[0], data_ot[1], $("#bible_book_ot").attr("data-notes"), $("#bible_book_nt").attr("data-notes"));
    set_read_books($("#bible_book_ot"));
  }

  if ($("#bible_book_nt").val() && $("#bible_book_nt").val() != 0 && $("#bible_book_nt").val() !== "_none_" && !$("#bible_book_nt").attr("disabled")) {
    let data_nt = split_book($("#bible_book_nt").val());
    setTimeout(function () {
      save_field_read($("#bible_book_nt").attr("data-field"), $("#date_read").val(), data_nt[0], data_nt[1], $("#bible_book_ot").attr("data-notes"), $("#bible_book_nt").attr("data-notes"));
    }, 50);
    setTimeout(function () {
      set_read_books($("#bible_book_nt"));
    }, 100);
  }

  showHint("Сохранено.");

  if (trainee_access === "1") {
    setTimeout(function () {
      location.reload();
    }, 700);
  }
});

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

$("#date_read").change(function () {
  if (trainee_access === "1") {
    member_key = window.adminId;
  } else {
    member_key = $("#mdl_edit_read").attr("data-member_key");
  }
  fetch("ajax/ftt_reading_ajax.php?type=get_reading_data&member_key="
  + member_key + "&date=" + $(this).val())
  .then(response => response.json())
  .then(commits => {
    let data = commits.result;
    if (data["book_ot"]) {
      render_bible_chapters(data["book_ot"], data["chapter_ot"], "#bible_book_ot");
      $("#bible_book_ot").attr("data-book", data["book_ot"]);
      $("#bible_book_ot").attr("data-chapter", data["chapter_ot"]);
      if (data["today_ot"] > 0) {
        $("#bible_book_ot").val(data["book_ot"] + " " + data["chapter_ot"]);
      }
      $("#bible_book_ot").attr("disabled", false);
    } else {
      $("#bible_book_ot").val("");
      $("#bible_book_ot").attr("disabled", true);
    }
    if (data["book_nt"]) {
      render_bible_chapters(data["book_nt"], data["chapter_nt"], "#bible_book_nt");
      $("#bible_book_nt").attr("data-book", data["book_nt"]);
      $("#bible_book_nt").attr("data-chapter", data["chapter_nt"]);
      if (data["today_nt"] > 0) {
        $("#bible_book_nt").val(data["book_nt"] + " " + data["chapter_nt"]);
      }
      $("#bible_book_nt").attr("disabled", false);
    } else {
      $("#bible_book_nt").val("");
      $("#bible_book_nt").attr("disabled", true);
    }
    if (data["start_today"]) {
      $("#bible_book_nt").attr("disabled", true);
      $("#bible_book_ot").attr("disabled", true);
      $("#save_book_read").attr("disabled", true);
    } else {
      $("#save_book_read").attr("disabled", false);
    }
  });
});

function render_bible_chapters(book, chapter, selector) {
  let sim_1, counter_1 = 0;
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

  options += "<option value='0'>нет";
  for (let i = 0; i < bible_arr.length; i++) {
    if (sim_1 === 2) {
      break;
    }
    if ((bible_arr[i][0] === book || sim_1 === 1) && counter_1 < 10) {
      for (let j = 1; j <= bible_arr[i][1]; j++) {
        if ((j >= chapter || sim_1 === 1) && counter_1 < 10) {
          if (sim_1 === 2) {
            break;
          }
          if (counter_1 < 10) {
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
/*
// *** BIBLE SAVE HERE! *** //
if (e.target.id === "bible_book") {
  setTimeout(function () {
    fetch("ajax/ftt_attendance_ajax.php?type=get_bible_chapter&book=" + value)
    .then(response => response.json())
    .then(commits => {
      let options = "";
      for (let i = 1; i <= commits.result[0][1]; i++) {
        options += "<option value='" + i + "'>" + i;
      }
      $("#bible_chapter").html(options);
      save_select_field_extra("bible_chapter", 1, 1);
      $("#accordion_attendance .list_string[data-id='"+id+"']").attr("data-bible_book", value);
      $("#accordion_attendance .list_string[data-id='"+id+"']").attr("data-bible_chapter", 1);
    });
  }, 10);
} else {
  $("#accordion_attendance .list_string[data-id='"+id+"']").attr("data-bible_chapter", value);
}
*/
  //**** DOCUMENT READY END ****//
});
