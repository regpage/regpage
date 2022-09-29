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
  $(".desk_show").hide();
  $(".mbl_show").removeClass("hide_element");
  $(".mbl_show").show();
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
  $("#period_select").attr("style", "font-size: 17px !important");
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

  // РАЗРЕШЕНИЯ
  // container
  // header
  $("#permission_list_header").removeClass("mb-2").addClass("mb-3");
  $("#permission_tab .row_corr").hide();
  $("#permission_flt_modal_o").show();
  $("#permission_list_header select").hide();
  $("#permission_ftr_modal select").css("font-size","17px");
  // columns
  $("#permission_tab .col-8").removeClass("col-8").addClass("col-6");
  //strings
  $("#list_permission .list_string div:first-child").addClass("pr-0");
  $("#list_permission .list_string div:first-child").css("max-width", "45px");
  $("#list_permission .list_string div:first-child").next().addClass("pl-2");

  if (!trainee_access) {
    $("#list_permission .list_string div:first-child").next().addClass("pr-2");
    $("#list_permission .list_string div:first-child").next().next().addClass("pl-2");
    $("#list_permission .list_string div:first-child").next().next().addClass("pr-2");
    $("#list_permission .list_string div:first-child").next().next().next().next().addClass("pl-0");
    $("#list_permission .list_string div:first-child").next().removeClass("col-4").addClass("col-7");
    $("#list_permission .list_string div:first-child").next().next().hide();
    $("#list_permission .list_string div:first-child").next().next().next().hide();
    $("#list_permission .list_string div:first-child").next().next().next().next().next().show();
    $("#list_permission .list_string div:first-child").next().next().next().next().next().next().show();
  } else {
    $("#list_permission .list_string div:first-child").next().next().css("padding-left", "10px");
  }

  // blank
  $("#info_of_permission").css("margin-left", "300px");
  $("#edit_permission_blank input").css("font-size","16px");
  $("#edit_permission_blank select").css("font-size","16px");
  $("#show_day_in_blank").parent().parent().removeClass("col-3").addClass("col-1");
  $("#show_day_in_blank").parent().parent().prev().removeClass("col-4").addClass("col-5");
  $("#show_day_in_blank").parent().parent().next().removeClass("col-4").addClass("col-6");


  // footer
  $("#edit_permission_blank .modal-footer .btn").css("font-size", "17px");

} else if ($(window).width()<=991 && $(window).width()>769) {
  $("#current_extra_help").css("min-width", $(window).width()+"px");
  $(".card_header button").css("width", "180px");
}
