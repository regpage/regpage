// DOCUMENT READY BEGIN
$(document).ready(function(){
  // pic
  $("#modal_field_file").click(function (e) {
    if (!$("#modal_edit_add_md").attr("data-id")) {
      if (!$("#mdl_edit_date_md").val()) {
        e.preventDefault();
        showError("Сначала заполните дату");
        $("#mdl_edit_date_md").css("border-color", "red");
      } else {
        $("#mdl_edit_date_md").css("border-color", "#ced4da");
      }
      if ($("#mdl_edit_trainee_list_md").length && ($("#mdl_edit_trainee_list_md").val() === "_none_" || !$("#mdl_edit_trainee_list_md").val())) {
        e.preventDefault();
        showError("Сначала выберите обучающегося");
        $("#mdl_edit_trainee_list_md").css("border-color", "red");
      } else {
        $("#mdl_edit_trainee_list_md").css("border-color", "#ced4da");
      }
    }
  });
  // добавление файла
  $("#modal_field_file").change(function () {
    let obj_data = {id: ""};
    if (!$("#modal_edit_add_md").attr("data-id")) {
      obj_data["date"] = $("#mdl_edit_date_md").val();
      if ($("#mdl_edit_trainee_list_md").length) {
        obj_data["member_key"] = $("#mdl_edit_trainee_list_md").val();
      } else {
        obj_data["member_key"] = window.adminId;
      }
    } else {
      obj_data["id"] = $("#modal_edit_add_md").attr("data-id");
    }
    modal_file_upload($("#modal_edit_add_md"), $(this), obj_data);
  });
  // сохранение бланка
  $("#mdl_edit_btn_save_md").click(function () {
    if (is_validation_fields_correct()) {
      let data = get_data_from_blank("#modal_edit_add_md");
      save_blank(data, "#modal_edit_add_md");
    }
  });
  // отправление бланка
  $("#mdl_edit_btn_send_md").click(function () {
    if (is_validation_fields_correct()) {
      let data = get_data_from_blank("#modal_edit_add_md", true);
      save_blank(data, "#modal_edit_add_md");
    }
  });
  // открываем бланк
  $("#temp_list_body .list_str, #addProphecy").click(function () {
    $("#modal_edit_add_md .modal-header .badge").remove();
    $("#modal_info_blank").hide();
    $("#modal_info_blank").html("");
    reset_modal_file_block();
    module_blank_clear($("#modal_edit_add_md"));
    if ($(this).attr("id") !== "addProphecy") {
      get_data_for_blank($(this).attr("data-id"), "#modal_edit_add_md");
    } else {
      // правила отображения полей и кнопок при открытии бланка
      rule_fo_blank("#modal_edit_add_md", 0, 0);
    }
    $("#modal_edit_add_md").modal("show");
  });
  // удалить бланк
  $("#mdl_edit_btn_dlt_md").click(function () {
    if (confirm("Удалить бланк?")) {
      dlt_prophecy_blank($("#modal_edit_add_md").attr("data-id"));
    }
  });

  // фильтры
  $("#flt_list_trainees, #flt_list_weeks, #flt_list_servingone, #flt_list_currents").change(function () {
    if ($(this).attr("id") === "flt_list_servingone") {
      setCookie("prophecy_staff-flt_list_trainees", "_all_");
    }
    setCookie("prophecy_staff-" + $(this).attr("id"), $(this).val());
    setTimeout(function () {
      location.reload();
    }, 30);
  });
  // мобильные фильтры

  $("#modal_ftr_apply").click(function () {
    let modal = "modal_";
    $("#modal_mobile_fiters select").each(function() {
      let id = $(this).attr("id");
      if (id.includes(modal)) {
        id = id.substring(modal.length);
        setCookie("prophecy_staff-" + id, $(this).val());
      }
    });
    if ($("#" + modal + "flt_list_servingone").val() !== $("#flt_list_servingone").val()) {
      setCookie("prophecy_staff-flt_list_trainees", "_all_");
    }
    setTimeout(function () {
      location.reload();
    }, 100);
  });
  // инфо блок показать скрыть
  $("#modal_info_blank_visibility").click(function () {
    if ($("#modal_info_blank").is(":visible")) {
      $("#modal_info_blank").fadeOut();
    } else {
      $("#modal_info_blank").fadeIn();
    }
  });
// DOCUMENT READY END
});
