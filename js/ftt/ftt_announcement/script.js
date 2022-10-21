/* ==== ANNOUNCEMENT START ==== */
$(document).ready(function(){
  /* ==== DOCUMENT READY START ==== */
  // BLANK
  function blank_reset() {
    // fields
    $("#announcement_modal_edit input[type='checkbox']").prop("checked", false);
    $("#announcement_modal_list input[type='checkbox']").prop("checked", false);
    $("#announcement_modal_edit input[type='text']").val("");
    $("#announcement_date_publication").val(date_now_gl);
    $("#announcement_date_archivation").val("");
    $("#announcement_modal_edit select").val("01");
    // edit editor
    nicEditors.findEditor("announcement_text_editor").setContent("<span class='text-secondary'>Текст объявления...</span>");
    // attr data-
    $("#announcement_modal_edit").attr("data-id","");
    $("#announcement_modal_edit").attr("data-date","");
    $("#announcement_modal_edit").attr("data-id","");
  }

  function blank_fill() {
    $("#announcement_date_publication").val("");
    $("#announcement_date_archivation").val("");
    $("#announcement_date_publication").val("");
    $("#announcement_date_archivation").val("");
    $("#announcement_date_publication").val("");
    $("#announcement_date_archivation").val("");
  }

  function get_recipients() {
    let arr = [];
    return arr;
  }

  function get_data_fields() {
    data = {
      id: $("#announcement_modal_edit").attr("data-id"),
      recipients: get_recipients(),
      time_zone: $("#announcement_modal_time_zone").val(),
      publication_date: $("#announcement_date_publication").val(),
      publication_time: $("#announcement_time_publication").val(),
      archive_date: $("#announcement_date_archivation").val(),
      header: $("#announcement_text_header").val(),
      text: nicEditors.findEditor("announcement_text_editor").getContent(),
      comment: $("#announcement_staff_comment").val()
    };
    return data;
  }

  function blank_save() {
    console.log(get_data_fields());
  }

  $("#announcement_btn_save").click(function () {
    blank_save();
  });

  $("#announcement_add").click(function () {
    blank_reset();
  });

  // BLANK FIELDS BEHAVIORS
  // предусмотреть вставку
  $("#announcement_time_publication").keyup(function () {
    let time = $(this).val();
    if (time.length === 3 && time[2] !== ":") {
      $(this).val(String(time[0])+String(time[1])+':'+String(time[2]))
    } else if (time.length > 3 && time[2] !== ":") {
      $(this).val(String(time[0])+String(time[1])+':'+String(time[2]) + String(time[3]));
    }
  });
setTimeout(function () {
  // text editor place holder
  $(".nicEdit-main").click(function () {
    if (nicEditors.findEditor("announcement_text_editor").getContent().trim() === '<span class="text-secondary">Текст объявления...</span>') {
      nicEditors.findEditor("announcement_text_editor").setContent("");
    }
  });
}, 1100);

  // BLANK EXTRA LIST
  // Список получателей объявления, опция "по списку"
  $("#announcement_by_list").change(function () {
    if ($(this).prop("checked")) {

      $("#announcement_modal_list").modal("show");
      $("#announcement_list_editor").show();
    } else {
      $("#announcement_list_editor").hide();
    }

  });

  // Правка списка получателей объявления, опция "настроить".
  $("#announcement_list_editor").click(function (e) {
    e.stopPropagation();
    e.preventDefault();
    $("#announcement_modal_list").modal("show");
  });

  /* ==== DOCUMENT READY STOP ==== */
});
/* ==== ANNOUNCEMENT STOP ==== */
