$(document).ready(function(){
  $("#mdl_edit_btn_save").click(function () {
    if (is_validation_fields_correct()) {
      save_blank(get_data_from_blank());
    }
  });

  $("#temp_list_body .list_str").click(function () {

  });
// DOCUMENT READY END
});
