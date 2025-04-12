// отправляем заказ в CRM (подтверждение отправки)
$("#mdl_edit_btn_save").click(function () {
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

  //form_data.set("", $("#").val());

  form_data.set("data", JSON.stringify(data));
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
});
