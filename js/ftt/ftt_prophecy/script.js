// валидация полей
function is_validation_fields_correct() {
  $("#mdl_edit_date_md").css("border-color", "#ced4da");
  if (!$("#mdl_edit_date_md").val()) {
    $("#mdl_edit_date_md").css("border-color", "red");
    showError("Заполните необходимые поля");
    return false;
  }
  return true;
}
// получаем данные полей с атрибутом name
function get_fields_data_from_blank(id) {
  let obj = {};
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
function get_data_from_blank() {
  let form_data = new FormData();
  let data = get_fields_data_from_blank("#modal_edit_add_md");
  data["id"] = $("#modal_edit_add_md").attr("data-id");
  if (!$("#modal_edit_add_md select[name='member_key']").length) {
    data.member_key = window.adminId;
  }
  form_data.set("data", JSON.stringify(data));

  return form_data;
}

// сохраняем бланк пророчества
function save_blank(form_data) {
  fetch("api_ftt.php?section=prophecy&type=set_line", {
    method: 'POST',
    body: form_data
  })
  .then(response => response.json()) // text
  .then(commits => {
    if (commits.result) {
      location.reload();
    } else {
      showError("Сбой при сохранение.");
    }
  });
}

// получаем данные открываемого бланка
function get_data_for_blank(id) {
  fetch("api_ftt.php?section=prophecy&type=get_line&id=" + id, {
  })
  .then(response => response.json()) // text
  .then(commits => {
    if (commits.result) {

    } else {
      showError("Сбой при открытии.");
    }
  });
}
