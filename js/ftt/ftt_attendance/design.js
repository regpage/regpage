//design
if ($(window).width()<=769) {
  // containers
  $("#main_row").attr('style', 'width: 100% !important;');
  // headers
  $("#list_header").hide();
  $("#extra_help_staff .nav-link").css("font-size","16px");
  $("#hight_line").css("margin-right", "0px");
  $(".nav-tabs a").css("padding-right", "8px");
  $(".nav-tabs a").css("padding-left", "8px");
  // columns
  //$(".col_n_3").attr('style', 'min-width: 0px !important;');
  $(".col_n_3").hide();
  //$("#list_content .col-5").hide();
  $("#list_content .col-2").attr('style', 'min-width: 0px !important;');
  //strings
  $('.period_col').css("padding-left", "5px");
  $(".list_string").addClass("mr-1");
  $(".list_string").addClass("mb-1");
  $(".card_header button").css("width", "300px");  

  $(".card_header button").css("padding-right", "5px");
  $(".card_header button").css("padding-left", "0px");
  if (trainee_access) {
    $("#filters_list").hide();
  }
  $("#filters_list").parent().removeClass("row");
  $("#filters_list").css("padding-left", "0px");
  $("#sevice_one_select").css("margin-bottom", "10px");
  $("#list_content").removeClass("row");
  $("#archive_list .modal-content").css("width","auto");
  $("#add_attendance_str").css("margin-right","auto");
  $(".card_header").css("margin-left", "0px");
  $("#tab_content_extra_help").attr("style", "font-size: 16px !important");
  $("#sevice_one_select").attr("style", "font-size: 16px !important");
  $("#period_select").attr("style", "font-size: 16px !important");
  $(".col_n_1").removeClass("col-2").addClass("col-8");
  $(".trainee_name").parent().hide();
  $("#period_select").addClass("mb-2");
  $("#sevice_one_select").addClass("mb-2");
  $("#filters_list").parent().addClass("pb-2");
  $("#filters_list").parent().css("border-bottom", "1px solid lightgray");
  $(".comment_mbl").show();
  $("#comment_modal").attr("style", "font-size: 16px !important");
  $("#modalAddEdit label").attr("style", "font-size: 16px !important");
  // строки 5 - 6 семестр
  $("#modal-block_2 .name_session").addClass("hide_element");
  $("#modal-block_2 h6").removeClass("hide_element");
  $("#modal-block_2 input").removeClass("ml-1");

  // Blank
  $("#status_of_blank").css("padding-left", "0px");
  $("#name_of_trainee").parent().parent().css("padding-right", "5px");
  $("#name_of_trainee").parent().parent().css("max-width", "200px");
  $("#modalAddEdit .btn-sm").removeClass("btn-sm");
} else if ($(window).width()<=991 && $(window).width()>769) {
  $("#current_extra_help").css("min-width", $(window).width()+"px");
  $(".card_header button").css("width", "180px");
}
