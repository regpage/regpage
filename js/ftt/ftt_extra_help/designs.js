
//design
if ($(window).width()<=769) {
  // containers
  $("#main_row").attr('style', 'width: 100% !important;');

  // headers
  $("#list_header div").hide();
  $("#list_header .sort_date").parent().show();
  $("#list_header .sort_trainee").parent().show();

  // buttons
  $("#modalFilrets .btn-sm").removeClass("btn-sm");
  $("#modalFilrets_late .btn-sm").removeClass("btn-sm");
  $("#modalAddEditExtraHelp .btn-sm").removeClass("btn-sm");
  $("#modalAddEditLate .btn-sm").removeClass("btn-sm");
  if ($(window).width()<=390) {
    $("#delete_extra_help").attr('style', 'margin-right: 95px;');
  } else {
    $("#delete_extra_help").attr('style', 'margin-right: 115px;');
  }
  //$("#sort_button").show();
  // columns
  $(".reason_text").attr('style', 'min-width: 0px !important;');
  $("#list_content .col-2").attr('style', 'min-width: 0px !important;');
  $("#current_extra_help .reason_text").removeClass("col-5").hide();
  //$("#current_extra_help .serving_one_name").hide();
  $(".serving_one_name").hide();
  $(".reson_mbl").parent().removeClass("col-3").addClass("col-8");
  $(".reson_mbl").show();
  $(".reson_mbl").parent().show();

  // filters extrahelp
  $("#trainee_select").hide();
  $("#semesters_select").hide();
  $("#sevice_one_select").hide();
  $("#tasks_select").hide();
  $("#filters_button").show();

  // filters late
  $("#trainee_select_late").hide();
  $("#semesters_select_late").hide();
  $("#sevice_one_select_late").hide();
  $("#tasks_select_late").hide();
  $("#filters_button_late").show();
  // === LATE ===

  // headers
  $("#list_header_late").hide();
}
