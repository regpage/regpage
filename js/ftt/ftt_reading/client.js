$(document).ready(function(){
  // *** С Т А Т И С Т И К А *** //
  // Статистика чтения библии
  $(".bible_statistic_btn").click(function () {
    $('#spinner').modal("show");
    // статистика с датами
    fetch("internal_api.php?category=ftt_reading&type=get_bible_deff&trainee_id=" + $(this).attr("data-member_key")) // ajax/ftt_reading_ajax.php?type=get_bible_deff
    .then(response => response.json())
    .then(commits => {
      let html = "";
      for (const variable in commits.result) {
        if (commits.result.hasOwnProperty(variable)) {
          html += "<div>" + variable + " - " + commits.result[variable] + "</div>";
        }
      }
      $("#bible_statistic_list").html(html);
      $('#spinner').modal("hide");
    });
/*
    fetch("ajax/ftt_attendance_ajax.php?type=get_bible_statistic&trainee_id=" + $(this).attr("data-member_key"))
    .then(response => response.json())
    .then(commits => {
      console.log(commits.result);
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
*/
    // статистика с датами
  /*  fetch("ajax/ftt_attendance_ajax.php?type=get_bible_statistic_dates&trainee_id=" + $(this).attr("data-member_key"))
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
    });*/

    /*setTimeout(function () {
      $("body").addClass("modal-open");
      $("body").attr("style", "padding-right: 15px;");
    }, 500);
    $("#mdl_bible_statistic").on("hide.bs.modal", function () {
      setTimeout(function () {
        $("body").addClass("modal-open");
      }, 500);
    });*/
  });

  // *** С Л У Ж А Щ И Е *** //
  // отметка книг служащими (прочитаные / не прочитанные)
  $(".edit_read_books_str").click(function () {
    // открываем окно
    $("#mdl_bible_check_book").modal("show");
    // подставляем имя обучающегося в форму
    $("#ftr_trainee_reading_check_mbl").val($(this).parent().parent().find(".btn").attr("data-member_key"));
    // получаем прочитанные книги выбранного обучающегося
    fetch("internal_api.php?category=ftt_reading&type=get_read_books&member_key=" + $("#ftr_trainee_reading_check_mbl").val()) // ajax/ftt_reading_ajax.php?type=get_read_book
    .then(response => response.json())
    .then(commits => {
      // заполняем форму полученными данными
      let read_data = commits.result, disabled;
      for (let i = 0; i < read_data.books.length; i++) {
        $("#mdl_bible_books_check input[data-book='"+read_data.books[i]+"']").prop("disabled", false);
        $("#mdl_bible_books_check input[data-book='"+read_data.books[i]+"']").prop("checked", true);
      }
    });
    // Получаем последнюю стартовую позицию
    setTimeout(function () {
      fetch("internal_api.php?category=ftt_reading&type=get_start_last&member_key=" + $("#ftr_trainee_reading_check_mbl").val() + "&both=1") // ajax/ftt_reading_ajax.php?
      .then(response => response.json())
      .then(commits => {
        // запролняем заголовок для ВЗ
        if (commits.result.ot.book) {
          // Если старт для ВЗ задан делаем пометку в заголовке "с/без прим."
          if (commits.result.ot.footnotes == "1") {
            $("#mdl_bible_books_check .col-6:first-child h5").html("ВЗ (с прим.)")
          } else {
            $("#mdl_bible_books_check .col-6:first-child h5").html("ВЗ (без прим.)")
          }
        } else {
          $("#mdl_bible_books_check .col-6:first-child h5").html("ВЗ");
        }
        // запролняем заголовок для НЗ
        if (commits.result.nt.book) {
          // Если старт для НЗ задан делаем пометку в заголовке "с/без прим."
          if (commits.result.nt.footnotes == "1") {
            $("#mdl_bible_books_check .col-6:nth-child(2) h5").html("НЗ (с прим.)");
          } else {
            $("#mdl_bible_books_check .col-6:nth-child(2) h5").html("НЗ (без прим.)");
          }
        } else {
          $("#mdl_bible_books_check .col-6:nth-child(2) h5").html("НЗ");
        }
      });
    }, 10);
  });

  // правка
  $(".edit_read").click(function () {
    $("#mdl_edit_read").attr("data-member_key", $(this).parent().parent().find(".btn").attr("data-member_key"));
    $("#mdl_edit_read_name").text(trainee_list[$(this).parent().parent().find(".btn").attr("data-member_key")]);
    $("#date_read").val(gl_date_now);
    $("#bible_book_ot").attr("data-book", "");
    $("#bible_book_ot").attr("data-chapter", "");
    $("#bible_book_ot").attr("data-notes", "");
    $("#bible_book_nt").attr("data-book", "");
    $("#bible_book_nt").attr("data-chapter", "");
    $("#bible_book_nt").attr("data-notes", "");

    // получаем данные по дате
    // ajax/ftt_reading_ajax.php?type=get_reading_data&
    fetch("internal_api.php?category=ftt_reading&type=get_reading&member_key="
    + $(this).parent().parent().find(".btn").attr("data-member_key") + "&date=" + gl_date_now)
    .then(response => response.json())
    .then(commits => {
      let data = commits.result;
      if (data["start"]["ot"]) {
        render_bible_chapters(data["last_reading"]["ot"]["book"], data["last_reading"]["ot"]["chapter"], "#bible_book_ot");
        $("#bible_book_ot").attr("data-book", data["last_reading"]["ot"]["book"]);
        $("#bible_book_ot").attr("data-chapter", data["last_reading"]["ot"]["chapter"]);
        $("#bible_book_ot").attr("data-notes", data["last_reading"]["ot"]["footnotes"]);
        if (data["reading"]["ot"] !== null) {
          $("#bible_book_ot").val(data["reading"]["ot"]["book"] + " " + data["reading"]["ot"]["chapter"]);
          $("#bible_book_ot").attr("data-id", data["reading"]["ot"]["id"]);
        } else {
          $("#bible_book_ot").attr("data-id", "");
        }
        $("#bible_book_ot").attr("disabled", false);
      } else {
        $("#bible_book_ot").val("_none_");
        $("#bible_book_ot").attr("disabled", true);
      }
      if (data["start"]["nt"]) {
        render_bible_chapters(data["last_reading"]["nt"]["book"], data["last_reading"]["nt"]["chapter"], "#bible_book_nt");
        $("#bible_book_nt").attr("data-book", data["last_reading"]["nt"]["book"]);
        $("#bible_book_nt").attr("data-chapter", data["last_reading"]["nt"]["chapter"]);
        $("#bible_book_nt").attr("data-notes", data["last_reading"]["nt"]["footnotes"]);
        if (data["reading"]["nt"] !== null) {
          $("#bible_book_nt").val(data["last_reading"]["nt"]["book"] + " " + data["last_reading"]["nt"]["chapter"]);
          $("#bible_book_nt").attr("data-id", data["reading"]["nt"]["id"]);
        } else {
          $("#bible_book_nt").attr("data-id", "");
        }
        $("#bible_book_nt").attr("disabled", false);
      } else {
        $("#bible_book_nt").val("_none_");
        $("#bible_book_nt").attr("disabled", true);
      }
      /*
      if (data["start_today"]) {
        $("#bible_book_nt").attr("disabled", true);
        $("#bible_book_ot").attr("disabled", true);
        $("#save_book_read").attr("disabled", true);
      } else {
        $("#save_book_read").attr("disabled", false);
      }
      */
    });
    $("#mdl_edit_read").modal("show");
  });

  // Архив
  $(".read_name .btn").click(function () {
    $("#mdl_reading_archive").modal("show");
    let member_key = $(this).attr("data-member_key");
    $("#mdl_history_read_name").text(trainee_list[member_key]);
    // получаем прочитанные книги выбранного обучающегося
    fetch("internal_api.php?category=ftt_reading&type=get_read_books&member_key=" + member_key) //ajax/ftt_reading_ajax.php?type=get_read_book
    .then(response => response.json())
    .then(commits => {
      let read_books = commits.result.books;
      // сприсок прочитанных книг
      let bible_books_html = "<i id='mdl_footnotes_ot_title'></i><br>", found;
      for (let i = 0; i < bible_arr.length; i++) {
        found = read_books.find(e => e === bible_arr[i][0]);
        if (found === undefined) {
          backgroung = "";
        } else {
          backgroung = "record_available";
        }

        if (i < 39) {
          bible_books_html += "<span class='d-inline-block " + backgroung + " p-1 mt-1' data-val='"+i+"'>" + noSpace(bible_arr[i][0]) + " </span>";
        } else {
          if (i === 39) {
            bible_books_html += "<br><br><i id='mdl_footnotes_nt_title'></i><br>";
          }
          bible_books_html += "<span class='d-inline-block " + backgroung + " p-1 mt-1' data-val='"+i+"'>" + noSpace(bible_arr[i][0]) + " </span>";
        }
      }
      $("#mdl_lest_reading_bible").html(bible_books_html);
    });
    setTimeout(function () {
      // получаем историю чтения
      fetch("internal_api.php?category=ftt_reading&type=get_history_reading_bible&member_key=" + member_key) // ajax/ftt_reading_ajax.php?type=get_history_reading_bible&
      .then(response => response.json())
      .then(commits => {
        calendar(commits.result);
      });
    }, 30);

    setTimeout(function () {
      // получаем историю чтения
      fetch("internal_api.php?category=ftt_reading&type=get_start_last&member_key=" + member_key) //ajax/ftt_reading_ajax.php?type=get_start_position
      .then(response => response.json())
      .then(commits => {
        let title_text_footnotes_yes = "С примечаниями";
        let title_text_footnotes_no = "Без примечаний";
        if (commits.result.ot.book) {
          if (commits.result.ot.footnotes == "1") {
            $("#mdl_footnotes_ot_title").text(title_text_footnotes_yes);
          } else {
            $("#mdl_footnotes_ot_title").text(title_text_footnotes_no);
          }
        }
        if (commits.result.nt.book) {
          if (commits.result.nt.footnotes == "1") {
            $("#mdl_footnotes_nt_title").text(title_text_footnotes_yes);
          } else {
            $("#mdl_footnotes_nt_title").text(title_text_footnotes_no);
          }
        }

      });
    }, 60);
  });

  // фильтр
  $("#read_sevice_one_select, #read_semester_select").change(function () {
    setCookie($(this).attr("data-cookie"), $(this).val());
    setTimeout(function () {
      location.reload();
    }, 30);
  });

  $("#ftr_trainee_reading_check_mbl").change(function () {
    $("#mdl_bible_books_check input").each(function () {
      $(this).prop("checked", false);
      $(this).prop("disabled", false);
    });
    let footnotes_ot="", footnotes_nt="";
    // получаем прочитанные книги выбранного обучающегося
    fetch("internal_api.php?category=ftt_reading&type=get_read_books&member_key=" + $(this).val()) //ajax/ftt_reading_ajax.php?type=get_read_book&
    .then(response => response.json())
    .then(commits => {
      let read_data = commits.result.books, disabled;
      for (let i = 0; i < read_data.length; i++) {
        //if (read_data[i][2] === 1) {
          //$("#mdl_bible_books_check input[data-book='"+read_data[i][0]+"']").prop("disabled", true);
        //} else {
          $("#mdl_bible_books_check input[data-book='"+read_data[i]+"']").prop("disabled", false);
        //}
        $("#mdl_bible_books_check input[data-book='"+read_data[i]+"']").prop("checked", true);
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
    fetch("internal_api.php?category=ftt_reading&type=set_read_book" + query)//ajax/ftt_reading_ajax.php
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
    let text_ot = "", text_nt = "", comma = "";
    if ($("#mdl_nt_start").prop("checked") && $("#mdl_ot_start").prop("checked")) {
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
      text_ot = $("#mdl_book_ot_start").val();
      if ($("#mdl_footnotes_ot_start").prop("checked")) {
        text_ot += " с прим.";
      }
    } else if ($("#mdl_nt_start").prop("checked")) {
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

    if ((($("#bible_book_ot").attr("data-notes") != footnotes_ot) && $("#bible_book_ot").attr("data-book")) || ($("#mdl_ot_start").prop("checked") && $("#mdl_ot_start").attr("data-complete") == "1")) {
      footnotes_ot_change = " Ветхому Завету";
    }
    if ((($("#bible_book_nt").attr("data-notes") != footnotes_nt) && $("#bible_book_nt").attr("data-book")) || ($("#mdl_nt_start").prop("checked") && $("#mdl_nt_start").attr("data-complete") == "1")) {
      footnotes_nt_change =  " Новому Завету";
    }
    if (($("#mdl_ot_start").prop("checked") && (footnotes_ot_change || $("#mdl_ot_start").attr("data-complete") == "1")) || ($("#mdl_nt_start").prop("checked") && (footnotes_nt_change || $("#mdl_nt_start").attr("data-complete") == "1"))) {
      if ((footnotes_ot_change && footnotes_nt_change) || ($("#mdl_ot_start").attr("data-complete") == "1" && $("#mdl_nt_start").attr("data-complete") == "1")) {
        and = " и";
      }
      if (confirm("Вы начинаете заново? Удалить предыдущую историю чтения по " + footnotes_ot_change + and + footnotes_nt_change + "?")) {
        sim = 1; // новый завет или ветхий?
        fetch("internal_api.php?category=ftt_reading&type=dlt_history_reading_bible&member_key=" + member_key + "&ot=" + footnotes_ot_change + "&nt=" + footnotes_nt_change) // ajax/ftt_reading_ajax.php?
        .then(response => response.json())
        .then(commits => {

        });
      } else {
        return;
      }
    }

    // отметка прочитанных книг по последней главе
    if (!$("#mdl_ot_start").attr("disabled") && $("#bible_book_ot").attr("data-book") && !footnotes_ot_change) {
      let ot_temp;
      if ($("#bible_book_ot").val()) {
        ot_temp = split_book($("#bible_book_ot").val());
      } else {
        ot_temp = split_book($("#bible_book_ot option:nth-child(3)").attr("data-book") + " " + $("#bible_book_ot option:nth-child(3)").attr("data-chapter"));
      }
      let found_temp = bible_arr.find(e => e[0] === ot_temp[0]);
      if (typeof found_temp !== 'undefined' && found_temp[1] === ot_temp[1]) {
        setTimeout(function () {
          let query_temp = "&member_key=" + member_key + "&book=" + ot_temp[0] + "&chapter=" + ot_temp[1];
          fetch("internal_api.php?category=ftt_reading&type=set_read_book_automatic&part=ot&checked=true" + query_temp) // ajax/ftt_reading_ajax.php?type=set_read_book
          .then(response => response.text())
          .then(commits => {

          });
        }, 30);
      }
    }
    if (!$("#mdl_nt_start").attr("disabled") && $("#bible_book_nt").attr("data-book") && !footnotes_nt_change) {
      let nt_temp;
      if ($("#bible_book_nt").val()) {
        nt_temp = split_book($("#bible_book_nt").val());
      } else {
        nt_temp = split_book($("#bible_book_nt option:nth-child(3)").attr("data-book") + " " + $("#bible_book_nt option:nth-child(3)").attr("data-chapter"));
      }
      let found_temp = bible_arr.find(e => e[0] === nt_temp[0]);
      if (typeof found_temp !== 'undefined' && found_temp[1] === nt_temp[1]) {
        setTimeout(function () {
          let query_temp = "&member_key=" + member_key + "&book=" + nt_temp[0] + "&chapter=" + nt_temp[1];
          fetch("internal_api.php?category=ftt_reading&type=set_read_book_automatic&part=nt&checked=true" + query_temp) // ajax/ftt_reading_ajax.php?type=set_read_book
          .then(response => response.text())
          .then(commits => {

          });
        }, 60);
      }
    }

    // query
    let book_nt_query, chapter_nt_query, book_ot_query, chapter_ot_query, chosen_book = 0;
    if ($("#mdl_ot_start").prop("checked")) {
      book_ot_query = $("#mdl_book_ot_start").val();
      chapter_ot_query = $("#mdl_chapter_ot_start").val();
    } else {
      book_ot_query = "";
      chapter_ot_query = 0;
    }
    if ($("#mdl_nt_start").prop("checked")) {
      book_nt_query = $("#mdl_book_nt_start").val();
      chapter_nt_query = $("#mdl_chapter_nt_start").val();
    } else {
      book_nt_query = "";
      chapter_nt_query = 0;
    }
    if (!$("#mdl_ot_start").prop("disabled")) {
      chosen_book = 1;
    }
    if (!$("#mdl_nt_start").prop("disabled")) {
      chosen_book += 2;
    }

    let param = "&member_key=" + member_key +
    "&date=" + date_now +
    "&chosen_book=" + chosen_book +
    "&book_ot=" + book_ot_query +
    "&chapter_ot=" + chapter_ot_query +
    "&footnotes_ot=" + footnotes_ot +
    "&book_nt=" + book_nt_query +
    "&chapter_nt=" + chapter_nt_query +
    "&footnotes_nt=" + footnotes_nt;
    $("#spinner").modal("show");

    fetch("internal_api.php?category=ftt_reading&type=set_start_reading_bible" + param) // ajax/ftt_reading_ajax.php?type=set_start_reading_bible
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
    $("#mdl_bible_start input[type='checkbox']").attr("disabled", false);
  });

  $("#mdl_book_ot_start, #mdl_book_nt_start").focus(function() {
    // ЕСЛИ ПРИ ПЕРЕБОРЕ ОПЦИЙ не обнаруживаются книги то выводит предупреждение что всё прочитано
    let counter = 0;

    $(this).find("option").each(function (e) {
      counter++;
      return;
    });

    if (counter < 1) {
      let text = "Вы прочитали все книги. Для выбора начала чтения с примечаниями обратитесь к служащим.";
      showHint(text, 10000);
    }
  });
  // смена книг в модальном окне
  $("#mdl_book_ot_start, #mdl_book_nt_start").change(function() {
    $("#set_start_reading_bible").attr("disabled", false);
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
    if ($("#date_read").val() !== gl_date_now) {
      showError("Старт может быть задан только на текущую дату.");
      return;
    }
    let selected_bible_book_ot = '';
    let selected_bible_book_nt = '';
    if ($("#bible_book_ot").val()) {
      selected_bible_book_ot = split_book($("#bible_book_ot").val());
    }
    if ($("#bible_book_nt").val()) {
      selected_bible_book_nt = split_book($("#bible_book_nt").val());
    }

    if (($("#bible_book_nt").val() && $("#bible_book_nt").val() !== '_none_' &&
        (selected_bible_book_nt[0] !== $("#bible_book_nt").attr("data-book") || selected_bible_book_nt[1] !== $("#bible_book_nt").attr("data-chapter")))
        || ($("#bible_book_ot").val() && $("#bible_book_ot").val() !== '_none_' &&
        (selected_bible_book_ot[0] !== $("#bible_book_ot").attr("data-book") || selected_bible_book_ot[1] !== $("#bible_book_ot").attr("data-chapter")))) {
      showError("Пожалуйста, сначала сохраните изменения, нажав кнопку «Записать».");
      return;
    }
    let member_key_data = $("#mdl_edit_read").attr("data-member_key");
    // если старт задаёт обучающийся
    if (trainee_access) {
      $("#mdl_bible_start").attr(window.adminId);
      member_key_data = window.adminId;
    }
    // настраиваем окно старта
    // получить прочитанные книги
    let ot_was_read = true, nt_was_read = true, ot_was_read_notes, nt_was_read_notes;
    fetch("internal_api.php?category=ftt_reading&type=get_read_books&member_key=" + member_key_data)
    .then(response => response.json())
    .then(commits => {
      // получаем options html прочитанных книг
      let data_reading = get_books_for_start(bible_arr, commits.result["books"]);
      let html_ot = data_reading["ot"];
      let html_nt = data_reading["nt"];
      ot_was_read = data_reading["ot_complete"];
      nt_was_read = data_reading["nt_complete"];
      ot_was_read_notes = commits.result["notes_ot"];
      nt_was_read_notes = commits.result["notes_nt"];
      $("#mdl_start_info").text("");

      if (ot_was_read) {
        show_msg_all_is_read(ot_was_read_notes, "o");
        $("#mdl_ot_start").attr("data-complete", 1);
      } else {
        $("#mdl_ot_start").attr("data-complete", "");
      }

      if (nt_was_read) {
        show_msg_all_is_read(nt_was_read_notes, "n");
        $("#mdl_nt_start").attr("data-complete", 1);
      } else {
        $("#mdl_nt_start").attr("data-complete", "");
      }
      // $("#mdl_book_ot_start").html(html_ot);
      // $("#mdl_book_nt_start").html(html_nt);
    });

    // получаем данные старта
    setTimeout(function () {
      fetch("internal_api.php?category=ftt_reading&type=get_start_last&member_key="
      + member_key_data + "&date=" + $("#date_read").val())
      .then(response => response.json())
      .then(commits => {
        let start_result = commits.result;
        // правила для окна старта
        let book_ot_start = $("#bible_book_ot").attr("data-book");
        let book_nt_start = $("#bible_book_nt").attr("data-book");

        // Если старт установлен сегодня
        /*if (commits.result.id) {
          book_ot_start = commits.result.book_ot;
          book_nt_start = commits.result.book_nt;
        }*/

        // блокируем поля старта вз и нз
        disabled_bookfields_start_mdl("o", true);
        disabled_bookfields_start_mdl("n", true);

        // Заполнение поля глав данными по текущей книге ВЗ и НЗ ИЛИ для старта
        fill_chapters_options_start_mdl(book_ot_start, "o");
        fill_chapters_options_start_mdl(book_nt_start, "n");

        // заполняем данными форму старт ВЗ и блокируем/разблокируем поля
        if (!$("#bible_book_ot").prop("disabled")) { // если поле в листе не заблокировано НЕ ВЕРНО ДЛЯ СЛУЖАЩИХ
          // получаем и заполняем книги  и главы ВЗ в окне старта
          let disabled_checkbox_start_ot;
          if (start_result.ot.id) {
            if (book_ot_start) {
              disabled_checkbox_start_ot = set_book_chapter_fnote_start_mdl(book_ot_start + " " + start_result.ot.chapter, "o", start_result.ot.footnotes);
              if ($("#date_read").val() === gl_date_now && !trainee_access) {
                disabled_bookfields_start_mdl("o", false);
              } else {
                disabled_bookfields_start_mdl("o", disabled_checkbox_start_ot);
              }
            }
          } else {
            disabled_checkbox_start_ot = set_book_chapter_fnote_start_mdl($("#bible_book_ot").val(), "o", start_result.ot.footnotes);
            if (!$("#bible_book_ot").attr("disabled") && !disabled_checkbox_start_ot && $("#date_read").val() === gl_date_now) {
              disabled_bookfields_start_mdl("o", disabled_checkbox_start_ot);
            }
          }
        } else {
          $("#mdl_ot_start").prop("checked", false);
          if ($("#date_read").val() === gl_date_now) {
            $("#mdl_ot_start").attr("disabled", false);
          } else {
            $("#mdl_ot_start").attr("disabled", true);
          }
        }

        // заполняем данными форму старт НЗ и блокируем/разблокируем поля
        if (!$("#bible_book_nt").prop("disabled")) {
          // получаем и заполняем книги  и главы НЗ в окне старта
          let disabled_checkbox_start_nt;
          if (start_result.nt.id) {
            if (book_nt_start) {
              disabled_checkbox_start_nt = set_book_chapter_fnote_start_mdl(book_nt_start + " " + start_result.nt.chapter, "n", start_result.nt.footnotes);
              if ($("#date_read").val() === gl_date_now && !trainee_access) {
                disabled_bookfields_start_mdl("n", false);
              } else {
                disabled_bookfields_start_mdl("n", disabled_checkbox_start_nt);
              }
            }
          } else {
            disabled_checkbox_start_nt = set_book_chapter_fnote_start_mdl($("#bible_book_nt").val(), "n", start_result.nt.footnotes);
            if (!$("#bible_book_nt").attr("disabled") && !disabled_checkbox_start_nt && $("#date_read").val() === gl_date_now) {
              disabled_bookfields_start_mdl("n", disabled_checkbox_start_nt);
            }
          }
        } else {
          $("#mdl_nt_start").prop("checked", false);
          if ($("#date_read").val() === gl_date_now) {
            $("#mdl_nt_start").attr("disabled", false);
          } else {
            $("#mdl_nt_start").attr("disabled", true);
          }
        }

        // если указанная книга отмечена как прочитаная или если все книги прочитаны
        if ($("#mdl_ot_start").prop("checked") && ((!$("#mdl_book_ot_start").val() && $("#mdl_book_ot_start option").val()) || ot_was_read)) {
          disabled_bookfields_start_mdl("o", false);
        } else if (!$("#mdl_ot_start").prop("checked") && ot_was_read) {
          disabled_bookfields_start_mdl("o", true);
          $("#mdl_ot_start").attr("disabled", false);
        }

        if ($("#mdl_nt_start").prop("checked") && ((!$("#mdl_book_nt_start").val() && $("#mdl_book_nt_start option").val()) || nt_was_read)) {
          disabled_bookfields_start_mdl("n", false);
        } else if (!$("#mdl_nt_start").prop("checked") && nt_was_read) {
          disabled_bookfields_start_mdl("n", true);
          $("#mdl_nt_start").attr("disabled", false);
        }

        // блокирование кнопки сохранения старта
        $("#set_start_reading_bible").attr("disabled", true);
      });
    }, 10);

    $("#mdl_bible_start").modal("show");

/*
========================
OLD VERSION
========================
*/




  });

  // change
  $("#mdl_ot_start, #mdl_nt_start").change(function () {
    if ($(this).attr("id") === "mdl_ot_start") {
      if ($(this).prop("checked")) {
        if (trainee_access !== "1") {
          $("#mdl_footnotes_ot_start").attr("disabled", false);
        }
        $("#mdl_book_ot_start").attr("disabled", false);
        $("#mdl_chapter_ot_start").attr("disabled", false);
      } else {
        $("#mdl_footnotes_ot_start").attr("disabled", true);
        $("#mdl_book_ot_start").attr("disabled", true);
        $("#mdl_chapter_ot_start").attr("disabled", true);
      }
    } else {
      if ($(this).prop("checked")) {
        if (trainee_access !== "1") {
          $("#mdl_footnotes_nt_start").attr("disabled", false);
        }
        $("#mdl_book_nt_start").attr("disabled", false);
        $("#mdl_chapter_nt_start").attr("disabled", false);
      } else {
        $("#mdl_footnotes_nt_start").attr("disabled", true);
        $("#mdl_book_nt_start").attr("disabled", true);
        $("#mdl_chapter_nt_start").attr("disabled", true);
      }
    }

    if (!$("#mdl_ot_start").attr("disabled") || !$("#mdl_nt_start").attr("disabled")) {
      $("#set_start_reading_bible").attr("disabled", false);
    } else {
      $("#set_start_reading_bible").attr("disabled", true);
    }
  });

  // save chapter
  function save_field_read(field, date, book, chapter, notes_ot, notes_nt, id) {
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
    + "&notes_nt=" + notes_nt
    + "&id=" + id;
    // ajax/ftt_reading_ajax.php?type=set_reading_bible
    fetch("internal_api.php?category=ftt_reading&type=set_reading" + data)
    .then(response => response.json())
    .then(commits => {
      //console.log(commits.result);
    });
  }

  // сохраняем чтение
$("#save_book_read").click(function () {
  let member_key_trainee;
  if (trainee_access === "1") {
    member_key_trainee = window.adminId;
  } else {
    member_key_trainee = $("#mdl_edit_read").attr("data-member_key");
  }
  if ($("#bible_book_ot").attr("disabled") && $("#bible_book_nt").attr("disabled")) {
    showError("Нельзя сохранить.");
    return;
  } else if ((!$("#bible_book_ot").val() || $("#bible_book_ot").val() === "_none_") && (!$("#bible_book_nt").val() || $("#bible_book_nt").val() === "_none_")) {
    showError("Укажите прочитанные главы в списке или выберите «нет» ");
    return;
  }

  if ($("#bible_book_ot").val() && $("#bible_book_ot").val() != 0 && $("#bible_book_ot").val() !== "_none_" && !$("#bible_book_ot").attr("disabled")) {
    let data_ot = split_book($("#bible_book_ot").val());
    if ($("#bible_book_ot").find('option:selected').attr('class') !== 'option_stop') {
      save_field_read($("#bible_book_ot").attr("data-field"), $("#date_read").val(), data_ot[0], data_ot[1], $("#bible_book_ot").attr("data-notes"), $("#bible_book_nt").attr("data-notes"), $("#bible_book_ot").attr("data-id"));
    }
    set_read_books($("#bible_book_ot"), member_key_trainee);
    if (trainee_access !== "1") {
      $("#bible_book_ot").attr("data-book", data_ot[0]);
      $("#bible_book_ot").attr("data-chapter", data_ot[1]);
    }
  }

  if ($("#bible_book_nt").val() && $("#bible_book_nt").val() != 0 && $("#bible_book_nt").val() !== "_none_" && !$("#bible_book_nt").attr("disabled")) {
    let data_nt = split_book($("#bible_book_nt").val());
    setTimeout(function () {
      if ($("#bible_book_nt").find('option:selected').attr('class') !== 'option_stop') {
        save_field_read($("#bible_book_nt").attr("data-field"), $("#date_read").val(), data_nt[0], data_nt[1], $("#bible_book_ot").attr("data-notes"), $("#bible_book_nt").attr("data-notes"), $("#bible_book_nt").attr("data-id"));
      }
    }, 50);
    setTimeout(function () {
      set_read_books($("#bible_book_nt"), member_key_trainee);
    }, 100);
    if (trainee_access !== "1") {
      $("#bible_book_nt").attr("data-book", data_nt[0]);
      $("#bible_book_nt").attr("data-chapter", data_nt[1] );
    }
  }
  if ($("#bible_book_ot").find('option:selected').attr('class') === 'option_stop') {
    $("#bible_book_ot").attr("disabled", true);
    $("#bible_book_ot").attr("data-book", "");
    $("#bible_book_ot").attr("data-chapter", "");
    $("#bible_book_ot").attr("data-notes", "");
    $("#bible_book_ot").attr("data-id", "");
  }

  if ($("#bible_book_nt").find('option:selected').attr('class') === 'option_stop') {
    $("#bible_book_nt").attr("disabled", true);
    $("#bible_book_nt").attr("data-book", "");
    $("#bible_book_nt").attr("data-chapter", "");
    $("#bible_book_nt").attr("data-notes", "");
    $("#bible_book_nt").attr("data-id", "");
  }
  showHint("Сохранено.");

  if (trainee_access === "1") {
    setTimeout(function () {
      location.reload();
    }, 700);
  } else {

  }
});

$("#date_read").change(function () {

  if (trainee_access === "1") {
    member_key = window.adminId;
  } else {
    member_key = $("#mdl_edit_read").attr("data-member_key");
  }

  fetch("internal_api.php?category=ftt_reading&type=get_reading&member_key=" // ajax/ftt_reading_ajax.php?type=get_reading_data&member_key=
  + member_key + "&date=" + $(this).val())
  .then(response => response.json())
  .then(commits => {
    let data = commits.result;
    if (data["start"]["ot"]) {
      render_bible_chapters(data["last_reading"]["ot"]["book"], data["last_reading"]["ot"]["chapter"], "#bible_book_ot");
      $("#bible_book_ot").attr("data-book", data["last_reading"]["ot"]["book"]);
      $("#bible_book_ot").attr("data-chapter", data["last_reading"]["ot"]["chapter"]);
      // в прежней версии нет
      $("#bible_book_ot").attr("data-notes", data["last_reading"]["ot"]["footnotes"]);
      if (data["reading"]["ot"] !== null) {
        $("#bible_book_ot").val(data["reading"]["ot"]["book"] + " " + data["reading"]["ot"]["chapter"]);
        $("#bible_book_ot").attr("data-id", data["reading"]["ot"]["id"]);
      } else {
        $("#bible_book_ot").attr("data-id", '');
      }
      $("#bible_book_ot").attr("disabled", false);
    } else {
      $("#bible_book_ot").val("_none_");
      $("#bible_book_ot").attr("disabled", true);
    }
    if (data["start"]["nt"]) {
      render_bible_chapters(data["last_reading"]["nt"]["book"], data["last_reading"]["nt"]["chapter"], "#bible_book_nt");
      $("#bible_book_nt").attr("data-book", data["last_reading"]["nt"]["book"]);
      $("#bible_book_nt").attr("data-chapter", data["last_reading"]["nt"]["chapter"]);
      // в прежней версии нет
      $("#bible_book_ot").attr("data-notes", data["last_reading"]["nt"]["footnotes"]);

      if (data["reading"]["nt"] !== null) {
        $("#bible_book_nt").val(data["reading"]["nt"]["book"] + " " + data["reading"]["nt"]["chapter"]);
        $("#bible_book_nt").attr("data-id", data["reading"]["nt"]["id"]);
      } else {
        $("#bible_book_nt").attr("data-id", '');
      }
      $("#bible_book_nt").attr("disabled", false);
    } else {
      $("#bible_book_nt").val("_none_");
      $("#bible_book_nt").attr("disabled", true);
    }
/*
    if (data["start_today"]) {
      $("#bible_book_nt").attr("disabled", true);
      $("#bible_book_ot").attr("disabled", true);
      $("#save_book_read").attr("disabled", true);
    } else {
      $("#save_book_read").attr("disabled", false);
    }
    */
  });
});

  $("#show_mdl_bible_statistic_semester").click(function() {
    get_data_reading_statistic_semester($("#bible_statistic_list_semester_data"), $("#read_sevice_one_select").val(), $("#read_semester_select").val());
  })

  $("#print_read_statistic").click(function () {
    print_report_reading("#bible_statistic_list_semester_data");
  });

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
