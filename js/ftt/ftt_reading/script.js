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
    $("#bible_book_ot").attr("data-book", "");
    $("#bible_book_ot").attr("data-chapter", "");
    $("#bible_book_ot").attr("data-notes", "");
    $("#bible_book_nt").attr("data-book");
    $("#bible_book_nt").attr("data-chapter", "");
    $("#bible_book_nt").attr("data-notes", "");

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

  // Архив
  $(".read_name .btn").click(function () {
    $("#mdl_reading_archive").modal("show");
    let member_key = $(this).attr("data-member_key");
    $("#mdl_history_read_name").text(trainee_list[member_key]);
    // получаем прочитанные книги выбранного обучающегося
    fetch("ajax/ftt_reading_ajax.php?type=get_read_book&member_key=" + member_key)
    .then(response => response.json())
    .then(commits => {
      let read_books = commits.result;
      // сприсок прочитанных книг
      let bible_books_html = "", found;
      for (let i = 0; i < bible_arr.length; i++) {
        found = read_books.find(e => e[0] === bible_arr[i][0]);
        if (found === undefined) {
          backgroung = "";
        } else {
          backgroung = "record_available";
        }

        if (i < 39) {
          bible_books_html += "<span class='d-inline-block " + backgroung + " p-1 mt-1' data-val='"+i+"'>" + noSpace(bible_arr[i][0]) + " </span>";
        } else {
          if (i === 39) {
            bible_books_html += "<br><br>";
          }
          bible_books_html += "<span class='d-inline-block " + backgroung + " p-1 mt-1' data-val='"+i+"'>" + noSpace(bible_arr[i][0]) + " </span>";
        }
      }
      $("#mdl_lest_reading_bible").html(bible_books_html);
    });
    setTimeout(function () {
      // получаем историю чтения
      fetch("ajax/ftt_reading_ajax.php?type=get_history_reading_bible&member_key=" + member_key)
      .then(response => response.json())
      .then(commits => {
        calendar(commits.result);
      });
    }, 30);
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
      if (confirm("Вы начинаете заново? Удалить предыдущую историю чтения по " + footnotes_ot_change + and + footnotes_nt_change + "?")) {
        sim = 1; // новый завет или ветхий?
        fetch("ajax/ftt_reading_ajax.php?type=dlt_history_reading_bible&member_key=" + member_key + "&ot=" + footnotes_ot_change + "&nt=" + footnotes_nt_change)
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
      if (found_temp[1] === ot_temp[1]) {
        setTimeout(function () {
          let query_temp = "&member_key=" + member_key + "&book=" + ot_temp[0] + "&chapter=" + ot_temp[1];
          fetch("ajax/ftt_reading_ajax.php?type=set_read_book&part=ot&checked=true" + query_temp)
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
      if (found_temp[1] === nt_temp[1]) {
        setTimeout(function () {
          let query_temp = "&member_key=" + member_key + "&book=" + nt_temp[0] + "&chapter=" + nt_temp[1];
          fetch("ajax/ftt_reading_ajax.php?type=set_read_book&part=nt&checked=true" + query_temp)
          .then(response => response.text())
          .then(commits => {

          });
        }, 60);
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
    $("#mdl_bible_start input[type='checkbox']").attr("disabled", false);
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

    if ($("#date_read").val() !== gl_date_now) {
      showError("Старт может быть задан только на текущую дату.");
      return;
    }
    let member_key;
    if (trainee_access === "1") {
      member_key = window.adminId;
    } else {
      member_key = $("#mdl_edit_read").attr("data-member_key");
    }
    fetch("ajax/ftt_reading_ajax.php?type=get_start_reading_bible&member_key=" + member_key + "&date=" + gl_date_now)
    .then(response => response.json())
    .then(commits => {
      let data_book_ot, data_book_nt;
      let result = commits.result;
      if (result["id"]) {
        data_book_ot = result["book_ot"];
        data_book_nt = result["book_nt"];
      } else {
        data_book_ot = $("#bible_book_ot").attr("data-book");
        data_book_nt = $("#bible_book_nt").attr("data-book");
      }
      if ($("#bible_book_ot").attr("data-book") && data_book_ot) {
        let bible_chapter_html = "";
        let found = bible_arr.find(e => e[0] === data_book_ot);
        for (let i = 1; i <= found[1]; i++) {
          bible_chapter_html += "<option value='"+i+"'>"+i;
        }
        $("#mdl_chapter_ot_start").html(bible_chapter_html);
      } else {
        $("#mdl_book_ot_start").val("Быт.");
        $("#mdl_chapter_ot_start").val(1);
      }

      if ($("#bible_book_nt").attr("data-book") && data_book_nt) {
        let bible_chapter_html = "";
        let found = bible_arr.find(e => e[0] === data_book_nt);
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
      if ($("#bible_book_ot").attr("data-book") && data_book_ot) {
        if ($("#bible_book_ot").val() && $("#bible_book_ot").val() !== "0" && $("#bible_book_ot").val() !== "_none_") {
          if (result["id"]) {
            ot = [result["book_ot"], result["chapter_ot"]];
          } else {
            ot = split_book($("#bible_book_ot").val());
            if (ot[0] !== $("#bible_book_ot").attr("data-book") || ot[1] !== $("#bible_book_ot").attr("data-chapter")) {
              showError("Пожалуйста, сначала сохраните изменения, нажав кнопку записать.");
              return;
            }
          }
        } else {
          if (result["id"]) {
            ot = [result["book_ot"], result["chapter_ot"]];
          } else {
            ot = split_book($("#bible_book_ot option:nth-child(3)").attr("data-book") + " " + $("#bible_book_ot option:nth-child(3)").attr("data-chapter"));
          }
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
      if ($("#bible_book_nt").attr("data-book") && data_book_nt) {
        if ($("#bible_book_nt").val() && $("#bible_book_nt").val() !== "0" && $("#bible_book_nt").val() !== "_none_") {
          if (result["id"]) {
            nt = [result["book_nt"], result["chapter_nt"]];
          } else {
            nt = split_book($("#bible_book_nt").val());
            if (nt[0] !== $("#bible_book_nt").attr("data-book") || nt[1] !== $("#bible_book_nt").attr("data-chapter")) {
              showError("Пожалуйста, сначала сохраните изменения, нажав кнопку записать.");
              return;
            }
          }
        } else {
          if (result["id"]) {
            nt = [result["book_nt"], result["chapter_nt"]];
          } else {
            nt = split_book($("#bible_book_nt option:nth-child(3)").attr("data-book") + " " + $("#bible_book_nt option:nth-child(3)").attr("data-chapter"));
          }
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
    if (trainee_access !== "1") {
      $("#bible_book_ot").attr("data-book", data_ot[0]);
      $("#bible_book_ot").attr("data-chapter", data_ot[1] );
    }
  }

  if ($("#bible_book_nt").val() && $("#bible_book_nt").val() != 0 && $("#bible_book_nt").val() !== "_none_" && !$("#bible_book_nt").attr("disabled")) {
    let data_nt = split_book($("#bible_book_nt").val());
    setTimeout(function () {
      save_field_read($("#bible_book_nt").attr("data-field"), $("#date_read").val(), data_nt[0], data_nt[1], $("#bible_book_ot").attr("data-notes"), $("#bible_book_nt").attr("data-notes"));
    }, 50);
    setTimeout(function () {
      set_read_books($("#bible_book_nt"));
    }, 100);
    if (trainee_access !== "1") {
      $("#bible_book_nt").attr("data-book", data_nt[0]);
      $("#bible_book_nt").attr("data-chapter", data_nt[1] );
    }
  }

  showHint("Сохранено.");

  if (trainee_access === "1") {
    setTimeout(function () {
      location.reload();
    }, 700);
  } else {

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


  //**** DOCUMENT READY END ****//
});
