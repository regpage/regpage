$(document).ready(function(){
  $("#mdl_edit_btn_save_md").click(function () {
    if (is_validation_fields_correct()) {
      let data = get_data_from_blank("#modal_edit_add_md");
      if (!$("#modal_edit_add_md select[name='member_key']").length) {
        data.member_key = window.adminId;
      }
      save_blank(data, "#modal_edit_add_md");
    }
  });

  $("#temp_list_body .list_str").click(function () {
    get_data_for_blank($(this).attr("data-id"), "#modal_edit_add_md");
    $("#modal_edit_add_md").modal("show");
  });
// DOCUMENT READY END
});
