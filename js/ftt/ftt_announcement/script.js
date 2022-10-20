/* ==== ANNOUNCEMENT START ==== */
$(document).ready(function(){
  /* ==== DOCUMENT READY START ==== */
  // BLANK
  function blank_reset() {
    $("#announcement_modal_edit input[type='checkbox']").prop("checked", false);
    $("#announcement_modal_list input[type='checkbox']").prop("checked", false);
    $("#announcement_modal_list input[type='text']").val("");
    $("#announcement_modal_list input[type='date']").val(0);
    $("#announcement_modal_list select").val("01");
  }

  function blank_fill() {

  }

  function blank_save() {

  }

  $("#announcement_add").click(function () {
    blank_reset();
  });

  // BLANK FIELDS BEHAVIORS
  $("#public_time_field").keyup(function () {
    let time = $(this).val();
    if (time.length === 3 && time[2] !== ":") {
      $(this).val(String(time[0])+String(time[1])+':'+String(time[2]))
    }
  });

  // text editor place holder
  $(".nicEdit-main").click(function () {
    if ($(this).text().trim() === 'Текст объявления...') {
      $(this).text("");
    }
  });

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
