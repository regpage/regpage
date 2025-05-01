$(document).ready(function(){
  $("#mdl_edit_btn_save_md").click(function () {
    if (is_validation_fields_correct()) {
      save_blank(get_data_from_blank());
    }
  });

  $("#temp_list_body .list_str").click(function () {
    $("#modal_edit_add_md").modal("show");
  });
// DOCUMENT READY END
});
