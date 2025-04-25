// валидация полей
function is_validation_fields_correct() {
  $("#mdl_edit_date").css("border-color", "#ced4da");
  if (!$("#mdl_edit_date").val()) {
    $("#mdl_edit_date").css("border-color", "red");
    showError("Заполните необходимые поля");
    return false;
  }
  return true;
}

// получаем данные бланка
function get_data_from_blank() {
  let form_data = new FormData();
  let data = {
    id: $("#modal_edit_add").attr("data-id"),
    date: $("#mdl_edit_date").val(),
    member_key: "",
    prophecy: $("#mdl_edit_prophecy").val().trim()
  };

  if ($("#mdl_edit_trainee_list").length) {
    data.member_key = $("#mdl_edit_trainee_list").val();
  } else {
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
