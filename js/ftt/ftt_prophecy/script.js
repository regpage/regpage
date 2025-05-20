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
function get_data_from_blank(elem) {
  let form_data = new FormData();
  let data = get_data_attr_blank(elem, get_data_fields_from_blank(elem));
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
      fill_blank(commits.result[0], elem)
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

function blank_fast_checked(id, checked) {
  let form_data = new FormData();
  form_data.set("data", JSON.stringify({id: id, checked: checked}));
  fetch("api_ftt.php?section=prophecy&type=set_checked", {
    method: 'POST',
    body: form_data
  })
  .then(response => response.json()) // text
  .then(commits => {
    showHint("Сохранено");
  });
}
