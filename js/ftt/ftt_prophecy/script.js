// валидация полей
function is_validation_fields_correct() {
  let check_error = true;
  $("#modal_edit_add_md .f_required").each(function() {
    if ($(this).val()) {
      $(this).css("border-color", "#ced4da");
    } else {
      check_error = false;
      $(this).css("border-color", "red");
    }
  });
  if (!check_error) {
    showError("Заполните необходимые поля");
    return false;
  } else {
    return true;
  }
}
// получаем данные полей с атрибутом name
function get_data_fields_from_blank(elem) {
  let obj = {};
  $(elem + " input, " + elem + " textarea, " + elem + " select").each(function() {
    if ($(this).attr("name")) {
      if ($(this).attr("type") === "checkbox") {
        obj[$(this).attr("name")] = $(this).prop("checked");
      } else {
        if ($(this).val()) {
          obj[$(this).attr("name")] = $(this).val().trim();
        } else {
          obj[$(this).attr("name")] = $(this).val();
        }
      }
    }
  });
  return obj;
}
// получаем данные атрибутов с данными из бланка
function get_data_attr_blank(elem, obj) {
  obj["id"] = $(elem).attr("data-id");
  if (!$(elem + " select[name='member_key']").length) {
    obj["member_key"] = window.adminId;
  }
  return obj;
}

// получаем данные бланка
function get_data_from_blank(elem, send) {
  let form_data = new FormData();
  let data = get_data_attr_blank(elem, get_data_fields_from_blank(elem));
  if (send) {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const formattedDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    data["send_date"] = formattedDateTime;
  }
  form_data.set("data", JSON.stringify(data));
  return form_data;
}

// сохраняем бланк пророчества
function save_blank(form_data, elem, reboot) {
  if (!Number(reboot)) {
    reboot = 300;
  }
  fetch("api_ftt.php?section=prophecy&type=set_line", {
    method: 'POST',
    body: form_data
  })
  .then(response => response.json()) // text
  .then(commits => {
    if (commits.result) {
      if (elem) {
        $(elem).modal("hide");
      }
      setTimeout(function () {
        location.reload();
      }, reboot);

    } else {
      showError("Сбой при сохранение.");
    }
  });
}

// получаем данные открываемого бланка
function get_data_for_blank(id, elem) {
  fetch("api_ftt.php?section=prophecy&type=get_line&id=" + id, {
  })
  .then(response => response.json()) // text
  .then(commits => {
    if (commits.result[0]["id"]) {
      fill_blank(commits.result[0], elem);
    } else {
      showError("Сбой при открытии.");
    }
  });
}

// удаление бланка
function dlt_prophecy_blank(id) {
  fetch("api_ftt.php?section=prophecy&type=dlt_line&id=" + id, {
  })
  .then(response => response.json()) // text
  .then(commits => {
    if (commits.result) {
      location.reload();
    } else {
      showError("Сбой при удалении.");
      setTimeout(function () {
        location.reload();
      }, 3000);
    }
  });
}

// заполняем бланк
function fill_blank(data, elem) {
  $(elem).attr("data-id", data["id"]);
  render_files_bar(data["id"], data["file"]);
  // правила отображения полей и кнопок при открытии бланка
  let blank_sent = 1;
  let date_checked = data["check_date"];
  // label
  if (data["send_date"] === '0000-00-00 00:00:00' || !data["send_date"]) {
    blank_sent = 0;
    $('<span class="ml-4 badge badge-secondary" style="align-self: center;">не отправлен</span>').insertAfter(elem + ' h5');
  } else if (data["checked"] === "1") {
    date_checked = data["check_date"];
    $('<span class="ml-4 badge badge-success" style="align-self: center;">проверено</span>').insertAfter(elem + ' h5');
  } else {
    $('<span class="ml-4 badge badge-warning" style="align-self: center;">на рассмотрении</span>').insertAfter(elem + ' h5');
  }
  rule_fo_blank(elem, trainee_access, blank_sent + Number(data["checked"]));

  let date_send = data["send_date"];
  if (data["send_date"] !== '0000-00-00 00:00:00' && data["send_date"]) {
    date_send = data["send_date"];
    $("#mdl_edit_btn_send_md").attr("disabled", "disabled");
  }

  // заполняем инфо блок
  $("#modal_info_blank").html("Отправлено: " + date_send + "<br>Проверено: " + date_checked);
  for (const variable in data) {
    if (data.hasOwnProperty(variable)) {
      $(elem + " input[name='" + variable + "'], " + elem + " select[name='" + variable + "'], " + elem + " textarea[name='" + variable + "']").each(function() {
        if ($(this).attr("type") === "checkbox") {
          if (data[variable] == 0) {
            $(this).prop("checked", false);
          } else {
            $(this).prop("checked", true);
          }

        } else {
          $(this).val(data[variable]);
        }
      });
    }
  }
}

// правило отобращения элементов в бланке
// variant rule_fo_blank(btns, fields)
// block for files
function rule_fo_blank(element, is_trainee, status) {
  // disabled / enabled fields
  // disabled / enabled buttons
  if (status == 0) {
    $(element).find(".fa-trash").parent().show();
  } else {
    $(element).find(".fa-trash").parent().hide();
  }
  if (is_trainee && (status == 1 || status == 2)) {
    $(element).find("input").attr("disabled", true);
    $(element).find("select").attr("disabled", true);
    $(element).find("textarea").attr("disabled", true);
    $(element).find(".btn-success").attr("disabled", true);
    $("#mdl_edit_btn_send_md").attr("disabled", true);
  } else {
    $(element).find("input").attr("disabled", false);
    $(element).find("select").attr("disabled", false);
    $(element).find("textarea").attr("disabled", false);
    $(element).find(".btn-success").attr("disabled", false);
    $("#mdl_edit_btn_send_md").attr("disabled", false);
  }
}
