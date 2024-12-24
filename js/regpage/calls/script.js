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
    $("#mdl_btn_dlt_call").show();
    $("#mdl_btn_new_order").hide();
  } else {
    $("#mdl_fld_status option[value='Входящая']").hide();
    $("#mdl_btn_dlt_call").hide();
    $("#mdl_btn_new_order").show();
  }
  if (data_list.done === '1') {
    if (data_list.status === "Заказ") {
      $("#mdl_btn_new_order").show();
      $("#mdl_btn_cancel").show();
      $("#mdl_btn_order_finished").hide();
      $("#mdl_fld_status option").hide();
      $("#mdl_fld_status option[value='Уточнение']").show();
      $("#mdl_fld_status option[value='Заказ']").show();
    } else {
      $("#mdl_btn_new_order").hide();
      $("#mdl_btn_cancel").hide();
      $("#mdl_btn_order_finished").show();
      $("#mdl_fld_status option").show();
      $("#mdl_fld_status option[value='Уточнение']").hide();
      $("#mdl_fld_status option[value='В работе']").hide();
    }
  } else if (data_list.done === '0') {
    $("#mdl_btn_cancel").show();
    $("#mdl_btn_new_order").attr("disabled", false).removeClass("btn-light").addClass("btn-primary").text("Новый заказ");
    if ($("#mdl_fld_status").val() === "_none_" || $("#mdl_fld_status").val() === "Заказ") {
      $("#mdl_btn_new_order").hide();
      $("#mdl_btn_cancel").show();
      $("#mdl_btn_order_finished").hide();
    } else if ($("#mdl_fld_status").val() !== "_none_" && $("#mdl_fld_status").val() !== "Заказ") {
      $("#mdl_btn_new_order").show();
      $("#mdl_btn_cancel").show();
      $("#mdl_btn_order_finished").hide();
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
    fullfill_blank(commits.result[0]);
    $("#modal_call_edit_add").modal("show");
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
      $("#modal_call_edit_add").modal("hide");
      showHint("Запись сохранена.");
      setTimeout(function () {
        location.reload();
      }, 700);
    }
  });
}

function fio_tel_paste(one, two, three) {
  document.addEventListener('paste', function(e) {
    let text = (e.clipboardData || window.clipboardData).getData('text').trim();
    if (!text) {
      return;
    }
    let text_position_number = text.search(/\d/);
    let text_position_charter = text.match(/[a-zA-Zа-яA-ЯЁё]/);
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
        $("#mdl_fld_fio").val(text_fio.replace(/[^\s+a-zA-Zа-яA-ЯЁё]/g, ''));
        $("#mdl_fld_phone").val(phone_number_prepare(text_number.replace(/[^+\d]/g, '')));
      }, 10);
    }
  });
}
