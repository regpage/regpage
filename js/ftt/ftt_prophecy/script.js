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
  obj["id"] = $(elem).attr("data-id");
  $(id + " input, " + id + " textarea, " + id + " select").each(function() {
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

// получаем данные бланка
function get_data_from_blank(elem) {
  let form_data = new FormData();
  let data = get_data_fields_from_blank(elem);
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

// заполняем бланк
function fill_blank(data, elem) {
  for (const variable in data) {
    if (data.hasOwnProperty(variable)) {
      $(elem + " input[name='" + variable + "'], " + elem + " select[name='" + variable + "'], " + elem + " textarea[name='" + variable + "']").each(function() {
        if ($(this).attr("type") === "checkbox") {
          $(this).prop("checked", data[variable]);
        } else {
          $(this).val(data[variable]);
        }
      });
    }
  }
}
