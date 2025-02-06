// Calls FUNCTION
// заполняем открытый бланк
function fullfill_blank (data_list) {
  // Настраиваем бланк
  // сбрасываем красные рамки
  let fields_id = ["#mdl_fld_fio", "#mdl_fld_phone", "#mdl_fld_country", "#mdl_fld_male", "#mdl_fld_region", "#mdl_fld_locality", "#mdl_fld_address", "#mdl_fld_operator","#mdl_fld_comment"];
  for (const element of fields_id) {
    $(element).css("border-color", "#ced4da");
  }
  // в соответствии с статусом
  if (data_list.status === "Входящая") {
    $("#mdl_fld_status option[value='Входящая']").show();
    $("#mdl_fld_operator option[value='_none_']").show();
    $("#mdl_btn_dlt_call").show();
    $("#mdl_btn_new_order").hide();
  } else {
    $("#mdl_fld_status option[value='Входящая']").hide();
    $("#mdl_fld_operator option[value='_none_']").hide();
    $("#mdl_btn_dlt_call").hide();
    $("#mdl_btn_new_order").show();
  }
  if (data_list.done === '1') {
    $("#mdl_btn_order_finished").show();
    $("#mdl_btn_new_order").hide();
    $("#mdl_btn_cancel").hide();
    if (data_list.status === "Заказ") {
      $("#mdl_fld_status option").hide();
      $("#mdl_fld_status option[value='В работе']").show();
      $("#mdl_fld_status option[value='Уточнение']").show();
      $("#mdl_fld_status option[value='Заказ']").show();
    } else {
      $("#mdl_fld_status option").show();
      $("#mdl_fld_status option[value='Заказ']").hide();
      $("#mdl_fld_status option[value='Входящая']").hide();
    }
  } else if (data_list.done === '0') {
    $("#mdl_btn_cancel").show();
    $("#mdl_btn_new_order").attr("disabled", false);
    $("#mdl_btn_order_finished").hide();
    if ($("#mdl_fld_status").val() === "_none_" || $("#mdl_fld_status").val() === "Заказ") {
      $("#mdl_btn_new_order").hide();
      $("#mdl_btn_cancel").show();
    } else if ($("#mdl_fld_status").val() !== "_none_" && $("#mdl_fld_status").val() !== "Заказ") {
      $("#mdl_btn_new_order").show();
      $("#mdl_btn_cancel").show();
    }
  }

  $("#modal_call_edit_add").attr("data-id", data_list["id"]);
  $("#modal_call_edit_add").attr("data-done", data_list["done"]);
  for (const string in data_list) {
    if (data_list.hasOwnProperty(string)) {
      if (string === "created_date") {
        $("#call_date").text(dateStrFromyyyymmddToddmmyyyy(data_list[string].slice(0,10)));
      } else if (string === "history") {
        $("#mdl_cal_history_content").html(data_list[string]);
      } else if (string === "phone" && data_list[string]) {
        $("#modal_call_edit_add [data-field='"+string+"']").val(phone_number_prepare(data_list[string]));
      } else {
        $("#modal_call_edit_add [data-field='"+string+"']").val(data_list[string]);
      }
    }
  }
  // отображаем кнопку Удалить при статусе повтор
  if ($("#mdl_fld_status").val() === "Повтор") {
    $("#mdl_btn_dlt_call").show();
  }
}

// получаем данные бланка и показываем заполненный бланк
function get_and_show_blank_data(id, get_to_work) {
  if (get_to_work) {
    get_to_work = "&get_to_work=1";
  } else {
    get_to_work = "";
  }
  fetch("api_reg.php?section=calls&type=get_call&id=" + id + get_to_work)
  .then(response => response.json()) // text
  .then(commits => {
    if (commits.result === "busy") {
      setCookie("showhint", 4, 1);
      setTimeout(function () {
        location.reload();
      }, 30);
    } else {
      fullfill_blank(commits.result[0]);
      $("#modal_call_edit_add").modal("show");
    }
  });
}

// проверить обязательные поля
function is_require_filds_empty(selectors_arr, error_text) {
  let check = false;
  for (const selector of selectors_arr) {
    if (!$(selector).val() || $(selector).val() === "_none_") {
      check = true;
      $(selector).css("border-color", "red");
    } else {
      $(selector).css("border-color", "#ced4da");
    }
  }

  if (check) {
    if (!error_text) {
      error_text = "Заполните обязательные поля.";
    }
    showError(error_text);
    return true;
  }
}

function save_call(then) {
  // проверки
  if (!$("#mdl_fld_phone").val() || !$("#mdl_fld_fio").val()) {
    showError("Заполните обязательные поля.");
    if (!$("#mdl_fld_phone").val()) {
      $("#mdl_fld_phone").css("border-color", "red");
    } else {
      $("#mdl_fld_phone").css("border-color", "#ced4da");
    }
    if (!$("#mdl_fld_fio").val()) {
      $("#mdl_fld_fio").css("border-color", "red");
    } else {
      $("#mdl_fld_fio").css("border-color", "#ced4da");
    }
    return;
  }
  $("#modal_call_edit_add").modal("hide");
  let data = {};
  if ($("#modal_call_edit_add").attr("data-id")) {
    data["id"] = $("#modal_call_edit_add").attr("data-id");
  } else {
    data["author_key"] = window.adminId;
  }
  $("#modal_call_edit_add input, #modal_call_edit_add select, #modal_call_edit_add textarea").each(function () {
    if ($(this).attr("data-field") && $(this).is(":visible")) {
      let text;
      if ($(this).val() === "_none_" || !$(this).val() || $(this).val() === "_all_") {
        if ($(this).attr("data-field") === "male") {
          text = "NULL";
        } else if ($(this).attr("data-field") === "status") {
          text = "Входящая";
        } else {
          text = "";
        }
      } else {
        if ($(this).attr("data-field") === "phone") {
          text = $(this).val();
          if (text.length === 1 && text[0] === "+") {
            text = "";
          } else if (text[0] === "+") {
            text = text.substring(1);
            text = text.replace(/\s/g, '');
          }
        } else {
          text = $(this).val();
          text = text.replaceAll("'", "&#39;");
        }
      }
      data[$(this).attr("data-field")] = text.replaceAll("`", "&#39;");
    }
  });
  // готоввим данные
  let form_data = new FormData();
  form_data.set("data", JSON.stringify(data));
  fetch("api_reg.php?section=calls&type=save_call", {
    method: 'POST',
    body: form_data
  })
  .then(response => response.text()) // json
  .then(commits => {
    if (then) {
      setCookie("showhint", 1, 1);
      setTimeout(function () {
        location.reload();
      }, 30);
    }
  });
}

function fio_tel_paste(paste_text) {
  if (paste_text) {
    paste_text = paste_text.replace(/\+/g, '');
    // особое правило
    if (paste_text.includes("Телефон:") && paste_text.includes("Ваше имя:")) {
      paste_text = paste_text.split("Телефон:");
      paste_text = paste_text[1].split("Ваше имя:");
      paste_text = paste_text[1] + " " + paste_text[0];
    }

    let text_position_number = paste_text.search(/\d/);
    let text_position_charter = paste_text.match(/[a-zA-Zа-яA-ЯЁё]/);
    if (!text_position_charter) {
      showError("В буфере обмена отсутствуют БУКВЫ");
      return;
    }
    if (text_position_number >= 0 && text_position_charter["index"] >= 0) {
      let text_number;
      let text_fio;
      if (text_position_number > text_position_charter["index"]) {
        text_number = paste_text.substring(text_position_number);
        text_fio = paste_text.substring(text_position_charter["index"], text_position_number);
      } else {
        text_number = paste_text.substring(text_position_number, text_position_charter["index"]);
        text_fio = paste_text.substring(text_position_charter["index"]);
      }
      setTimeout(function () {
        $("#mdl_fld_fio").val(text_fio.replace(/[^\s+a-zA-Zа-яA-ЯЁё]/g, '').trim());
        if (text_number) {
          $("#mdl_fld_phone").val(tel_mask_paste($("#mdl_fld_phone"), '', text_number));
        } else {
          $("#mdl_fld_phone").val("");
        }
      }, 10);
      if (text_number) {
        check_phone_dinamic(text_number);
      }
    }
    return;
  }
  /*document.addEventListener('paste', function(e) {
    let text = (e.clipboardData || window.clipboardData).getData('text').trim();
    if (!text) {
      return;
    }
    text = text.replace(/\+/g, '');
    // особое правило
    if (text.includes("Телефон:") && text.includes("Ваше имя:")) {
      text = text.split("Телефон:");
      text = text[1].split("Ваше имя:");
      text = text[1] + " " + text[0];
    }

    let text_position_number = text.search(/\d/);
    let text_position_charter = text.match(/[a-zA-Zа-яA-ЯЁё]/);
    // если в тексте нет букв
    if (!text_position_charter) {
      showError("В буфере обмена отсутствуют БУКВЫ");
      return;
    }
    if (text_position_number >= 0 && text_position_charter["index"] >= 0) {
      let text_number;
      let text_fio;
      if (text_position_number > text_position_charter["index"]) {
        text_number = text.substring(text_position_number);
        text_fio = text.substring(text_position_charter["index"], text_position_number);
      } else {
        text_number = text.substring(text_position_number, text_position_charter["index"]);
        text_fio = text.substring(text_position_charter["index"]);
      }
      setTimeout(function () {
        $("#mdl_fld_fio").val(text_fio.replace(/[^\s+a-zA-Zа-яA-ЯЁё]/g, '').trim());
        if (text_number) {
          $("#mdl_fld_phone").val(tel_mask_paste($("#mdl_fld_phone"), '', text_number));
        } else {
          $("#mdl_fld_phone").val("");
        }
      }, 10);
      if (text_number) {
        //check_phone_dinamic(text_number);
      }
    }
  });*/
}
// записываем фильтры в кукки
function filters_to_cookie(arr, all) {
  if (!arr.length) {
    return;
  }
  for (const elem of arr) {
    if ($("#" + elem).length) {
      let value = all || $("#" + elem).val();
      setCookie("calls-" + elem, value, 1);
    }
  }
}

// результаты поиска в окне
function search_results(text) {
  fetch("api_reg.php?section=calls&type=get_search_result&text=" + text)
  .then(response => response.json()) // text
  .then(commits => {
    search_results_render(commits.result);
  });
}
// рендерим результаты поиска
function search_results_render(data) {
  let html = "";
  for (const str of data) {
    let stage = "";
    if ((str.status !== "Входящая" && str.done === "0") || (str.status === "Уточнение" && str.done === "1")) { // текущие
      stage = 'В работе';
    } else if (str.status !== "Уточнение" && str.done === "1") {
      stage = 'Завершённые';
    } else if (str.status === "Входящая") {
      stage = 'Входящие';
    }
    let comment = str.comment;
    if (comment) {
      comment = str.comment.slice(0,30) + "...";
    }
    let badgeClass = "";
    if (str.status === 'В работе') {
      badgeClass = "secondary";
    } else if (str.status === 'Недозвон') {
      badgeClass = "warning";
    } else if (str.status === 'Ошибка') {
      badgeClass = "dark";
    } else if (str.status === 'Отказ') {
      badgeClass = "danger";
    } else if (str.status === 'Повтор') {
      badgeClass = "info";
    } else if (str.status === 'Уточнение') {
      badgeClass = "primary";
    } else if (str.status === 'Заказ') {
      badgeClass = "success";
    } else if (str.status === 'Входящая') {
      badgeClass = "light";
    }
    let time_str = str.created_date.split(" ");
    time_str = time_str[1].slice(0,5);
    let operator_txt = "не назначен";
    if (str.operator) {
      operator_txt = $("#flt_author option[value='" + str.operator + "']").text();
    }
    let author_txt = $("#flt_author option[value='" + str.author_key + "']").text();
    html += '<div class="row call_str_mdl pl-0" data-id="' + str.id + '"><div class="col-md-1 col-12 pl-sm-0 pl-3"><div>'
    + stage +'</div></div><div class="col-2 pl-3">'
    + dateStrFromyyyymmddToddmm(str.created_date) + ' ' + time_str + '</div><div class="col-md-2 col-9"><div ><a href="tel:+'
    + str.phone + '" class="d-sm-none pr-3">+' + str.phone + '</a><span class="d-none d-sm-inline">+'
    + str.phone + '</span></div></div><div class="col-md-2 col-12"><div ><span class="d-sm-none pr-3 font-weight-bold">'
    + str.name + '</span><span class="d-none d-sm-inline">' + str.name + '</span></div></div><div class="col-md-3 d-none d-sm-inline"><div>'
    + comment + '</div></div><div class="col-md-2 col-12"><div ><span class="badge badge-' + badgeClass + '" title="Администратор: '
    + author_txt + '\r\nОператор: ' + operator_txt + '">'
    + str.status + '</span><span class="d-sm-none pl-3">' + comment + '</span></div></div></div>';
  }
  if (!html) {
    html = "<div class='row pl-0 pt-2'><div class='col-12 pl-sm-0 pl-3'>Нет результатов</div></div>";
  }
  $("#search_results").html(html);
}

function blank_repeat_fill_in(comment, operator) {
  let cor = "";
  if ($("#mdl_fld_comment").val()) {
    cor = "\r\n";
  }
  $("#mdl_fld_comment").val($("#mdl_fld_comment").val() + cor + comment).css("border-color", "blue");
  $("#mdl_fld_operator").val(operator).css("border-color", "blue");
  $("#mdl_fld_status").val("Повтор").css("border-color", "blue");
}

function blank_repeat_reset_installations() {
  if ($("#modal_call_edit_add").attr("data-temp_comment") || $("#modal_call_edit_add").attr("data-temp_operator") || $("#modal_call_edit_add").attr("data-temp_status")) {
    // сброс в случае если правка уже осуществрялась
    $("#mdl_fld_comment").val($("#modal_call_edit_add").attr("data-temp_comment"));
    $("#mdl_fld_operator").val($("#modal_call_edit_add").attr("data-temp_operator"));
    $("#mdl_fld_status").val($("#modal_call_edit_add").attr("data-temp_status"));
    // очищаем временные хранилища данных
    $("#modal_call_edit_add").attr("data-temp_comment", "");
    $("#modal_call_edit_add").attr("data-temp_operator", "");
    $("#modal_call_edit_add").attr("data-temp_status", "");
  }
}

function check_phone_dinamic(phone) {
  // сброс установок связанных со статусом Повтор
  blank_repeat_reset_installations();

  if (!phone || phone.length < 4) {
    return;
  }
  // спинер и кнопки
  $("#spinner_crm").show();
  $("#mdl_btn_save_call").attr("disabled", true);
  // собрать старые данные комментария и статуса и записать во временное поле
  $("#modal_call_edit_add").attr("data-temp_comment", $("#mdl_fld_comment").val());
  $("#modal_call_edit_add").attr("data-temp_operator", $("#mdl_fld_operator").val());
  $("#modal_call_edit_add").attr("data-temp_status", $("#mdl_fld_status").val());


  // убрать отменить заявку из бланка нового звонка тк она ещё не создана
  // изменить статус на повтор и дополнить комментарий
  // сделать откат в случае изменения номенра и прохода проверки иначе перезаписать новыми данными
  // очищать бланк при открытии
  // убрать проверки при сохранении
  // подсветить изменённые поля синим на 4 секунды?
  // уведомление Диме о повторе
  // при сохранении делать проверку мало ли кто то добавил параллельно
  // Запросы
  phone = phone.replace(/[^\d]/g, '');
  // запрос к Звонкам проверка наличия номера в базе на сайте регистрации
  fetch("api_reg.php?section=calls&type=check_phone_dinamic&status=" + $("#mdl_fld_status").val()
  + "&phone=" + phone + "&id=" + $("#modal_call_edit_add").attr("data-id"))
  .then(response => response.text()) // json
  .then(commits => {
    if (commits) {
      blank_repeat_fill_in(commits, "000004947");
      showHelp("Этот номер уже был в «Звонках».");
      $("#mdl_btn_save_call").attr("disabled", false);
    }
  });
  // запрос к срм лиды(заявки) проверка наличия номера в срм
  // проверка наличия номера в срм заявки
  setTimeout(function () {
    fetch("api_v1.php?out=1&type=crm_check_phone_lead"
    + "&phone=" + phone)
    .then(response => response.json()) // text
    .then(commits => {
      for (const lead in commits.leads.result) {
        if (commits.leads.result.hasOwnProperty(lead)) {
          if (commits.leads.result[lead].phone == phone) {
            blank_repeat_fill_in("Была заявка в CRM " + commits.leads.result[lead].created_at + "\r\nФИО: " + commits.leads.result[lead].name + "\r\n", "000004947");
            showHelp("Этот номер уже был в CRM.");
          }
        }
      }
      $("#mdl_btn_save_call").attr("disabled", false);
    });
  }, 10);
  // запрос к срм сделки(Заказы) проверка наличия номера в срм
  setTimeout(function () {
    fetch("api_v1.php?out=1&type=crm_check_phone_deal"
    + "&phone=" + phone)
    .then(response => response.text()) // json
    .then(commits => {
      // скрываем спиннер
      $("#spinner_crm").hide();
      $("#mdl_btn_save_call").attr("disabled", false);
      if (commits && commits !== "error") {
        blank_repeat_fill_in("Был заказ в CRM " + commits + "\r\n", "000004947");
        showHelp("Этот номер уже был в CRM.");
      }
    });
  }, 20);
  setTimeout(function () {
    if ($("#mdl_btn_save_call").attr("disabled")) {
      $("#mdl_btn_save_call").attr("disabled", false);
    }
  }, 5000);
}
