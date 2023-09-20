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
function save_field_read(field, date, book, chapter, notes_ot, notes_nt) {
  let data = "&member_key=" + window.adminId
  + "&date=" + date
  + "&book_field=" + field + "&book=" + book + "&chapter=" + chapter
  + "&notes_ot=" + notes_ot
  + "&notes_nt=" + notes_nt;
  fetch("ajax/ftt_reading_ajax.php?type=set_reading_bible" + data)
  .then(response => response.text())
  .then(commits => {
    console.log(commits.result);
  });
}

// сохраняем чтение
$("#save_book_read").click(function () {
  if ($("#bible_book_ot").attr("disabled") && $("#bible_book_nt").attr("disabled")) {
    return;
  }
  let data_nt = split_book($("#bible_book_nt").val());
  if ($("#bible_book_ot").val() && $("#bible_book_ot").val() != 0 && $("#bible_book_ot").val() !== "_none_" && !$("#bible_book_ot").attr("disabled")) {
    let data_ot = split_book($("#bible_book_ot").val());
    save_field_read($("#bible_book_ot").attr("data-field"), $("#date_read").val(), data_ot[0], data_ot[1], $("#bible_book_ot").attr("data-notes"), $("#bible_book_nt").attr("data-notes"));
    set_read_books($("#bible_book_ot"));
  }
  if ($("#bible_book_nt").val() && $("#bible_book_nt").val() != 0 && $("#bible_book_nt").val() !== "_none_" && !$("#bible_book_nt").attr("disabled")) {
    setTimeout(function () {
      save_field_read($("#bible_book_nt").attr("data-field"), $("#date_read").val(), data_nt[0], data_nt[1], $("#bible_book_ot").attr("data-notes"), $("#bible_book_nt").attr("data-notes"));
    }, 50);
    setTimeout(function () {
      set_read_books($("#bible_book_nt"));
    }, 100);
  }
  setTimeout(function () {
    location.reload();
  }, 250);

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
  fetch("ajax/ftt_reading_ajax.php?type=get_reading_data&member_key="
  + window.adminId + "&date=" + $(this).val())
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
      $("#bible_book_nt").attr("disabled", true);
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
