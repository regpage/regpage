// Разделы Посещаемость и Чтение преобразоваваем разделени книги и главы Библии
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
// получаем и заполняем книги  и главы ВЗ/НЗ в окне старта
function set_book_chapter_fnote_start_mdl(bible_book, testament, footnotes) {
  let data;
    if (bible_book && bible_book !== "0" && bible_book !== "_none_") {
      data = split_book(bible_book);
    } else {
      data = split_book($("#bible_book_"+testament+"t option:nth-child(3)").attr("data-book") + " " + $("#bible_book_"+testament+"t option:nth-child(3)").attr("data-chapter"));
    }

    if (!footnotes) {
      footnotes = $(".reading_bible_title").attr("data-notes_"+testament+"t") === "1" ? true : false;
    } else {
      footnotes = footnotes == 1 ? true : false;
    }
    
    $("#mdl_book_"+testament+"t_start").val(data[0]);
    $("#mdl_chapter_"+testament+"t_start").val(data[1]);
    $("#mdl_footnotes_"+testament+"t_start").prop("checked", footnotes);
    $("#mdl_"+testament+"t_start").prop("checked", true);
    let found = bible_arr.find(e => e[0] === data[0]);
    if (found && found[1] === data[1]) {
      return false;
    } else {
      return true;
    }
}

// блокировка полей старта нз и/или вз
function disabled_bookfields_start_mdl(book, disabled, exception) {
  let selectors = ["#mdl_"+book+"t_start", "#mdl_book_"+book+"t_start", "#mdl_chapter_"+book+"t_start", "#mdl_footnotes_"+book+"t_start"];
  for (let i = 0; i < selectors.length; i++) {
    if (exception >= 0 && exception === i) {
      continue;
    } else {
      if (trainee_access && i === 3) {
        $(selectors[i]).attr("disabled", true);
      } else {
        $(selectors[i]).attr("disabled", disabled);
      }
    }
  }
}

// Заполнение поля глав данными по текущей книге ВЗ/НЗ
function fill_chapters_options_start_mdl(book, testament) {
  if (book && book !== "undefined") {
    let bible_chapter_html = "";
    let found = bible_arr.find(e => e[0] === book);
    // если в списке нет книг то главы не выводятся
    if ($("#mdl_book_"+testament+"t_start").val()) {
      for (let i = 1; i <= found[1]; i++) {
        bible_chapter_html += "<option value='"+i+"'>"+i;
      }
    }
    $("#mdl_chapter_"+testament+"t_start").html(bible_chapter_html);
  } else { // если данных нет
    let name_book = "Быт.";
    if(testament === "n") {
      name_book = "Мф.";
    }
    $("#mdl_book_"+testament+"t_start").val(name_book);
    $("#mdl_chapter_"+testament+"t_start").val(1);
  }
}

// получаем книги для окна старта
function get_books_for_start(bible_arr_tmp, book_read) {
  let ot_was_read_tmp = true, nt_was_read_tmp = true;
  let html_ot_tmp, html_nt_tmp;
  for (let i = 0; i < bible_arr_tmp.length; i++) {
    if (book_read.indexOf(bible_arr_tmp[i][0]) === -1) {
      if (i < 39) {
        ot_was_read_tmp = false;
        html_ot_tmp += "<option value='" + bible_arr_tmp[i][0] + "'>" + bible_arr_tmp[i][0];
      } else if (bible_arr_tmp[i][0]) {
        nt_was_read_tmp = false;
        html_nt_tmp += "<option value='" + bible_arr_tmp[i][0] + "'>" + bible_arr_tmp[i][0];
      }
    }
  }
  // если завет прочитан, заполняем список книг ВЗ для возможности нового старта
  if (ot_was_read_tmp) {
    for (let i = 0; i < bible_arr_tmp.length; i++) {
      if (i < 39) {
        html_ot_tmp += "<option value='" + bible_arr_tmp[i][0] + "'>" + bible_arr_tmp[i][0];
      }
    }
  }
  // если завет прочитан, заполняем список книг НЗ для возможности нового старта
  if (nt_was_read_tmp) {
    for (let i = 0; i < bible_arr_tmp.length; i++) {
      if (i >= 39) {
        html_nt_tmp += "<option value='" + bible_arr_tmp[i][0] + "'>" + bible_arr_tmp[i][0];
      }
    }
  }
  return {"ot":html_ot_tmp, "ot_complete": ot_was_read_tmp, "nt":html_nt_tmp, "nt_complete": nt_was_read_tmp};
}
