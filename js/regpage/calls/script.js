// Calls FUNCTION
// заполняем открытый бланк
function fullfill_blank (data_list) {
  // Настраиваем бланк
  if (data_list.status === "Входящая") {
    $("#mdl_btn_dlt_call").show();
    $("#mdl_btn_new_order").hide();
  } else {
    $("#mdl_btn_dlt_call").hide();
    $("#mdl_btn_new_order").show();
  }
  if (data_list.done === '1') {
    $("#mdl_btn_cancel").hide();
    $("#mdl_btn_new_order").attr("disabled", true).removeClass("btn-primary").addClass("btn-light").text("Заявка завершена");
    if (data_list.status === "Заказ") {
      $("#mdl_fld_status option").hide();
      $("#mdl_fld_status option[value='Уточнение']").show();
      $("#mdl_fld_status option[value='Заказ']").show();
    } else {
      $("#mdl_fld_status option").show();
      $("#mdl_fld_status option[value='Уточнение']").hide();
      $("#mdl_fld_status option[value='В работе']").hide();
    }
  } else if (data_list.done === '0') {
    $("#mdl_btn_cancel").show();
    $("#mdl_btn_new_order").attr("disabled", false).removeClass("btn-light").addClass("btn-primary").text("Новый заказ");
  }
  $("#modal_call_edit_add").attr("data-id", data_list["id"]);
  for (const string in data_list) {
    if (data_list.hasOwnProperty(string)) {
      if (string === "created_date") {
        $("#call_date").text(dateStrFromyyyymmddToddmmyyyy(data_list[string].slice(0,10)));
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
