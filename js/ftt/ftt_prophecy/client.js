// DOCUMENT READY BEGIN
$(document).ready(function(){
  // pic
  $("#modal_field_file").change(function () {
    modal_file_upload($("#modal_edit_add_md").attr("data-id"), $(this));
  });
  // сохранение бланка
  $("#mdl_edit_btn_save_md").click(function () {
    if (is_validation_fields_correct()) {
      let data = get_data_from_blank("#modal_edit_add_md");
      save_blank(data, "#modal_edit_add_md");
    }
  });

  // открываем бланк
  $("#temp_list_body .list_str, #addProphecy").click(function () {    
    reset_modal_file_block();
    module_blank_clear($("#modal_edit_add_md"));
    if ($(this).attr("id") !== "addProphecy") {
      get_data_for_blank($(this).attr("data-id"), "#modal_edit_add_md");
    }
    $("#modal_edit_add_md").modal("show");
  });

  // файл

  /*$(".ftt_extra_help_string").click(function () {

  });*/
// DOCUMENT READY END
});
