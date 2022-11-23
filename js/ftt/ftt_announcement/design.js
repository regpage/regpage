//design
if ($(window).width()<=769) {
  // containers
  $(".list_header").hide();
  $(".list_string div").css("padding-right", "4px");
  $(".list_string div").css("padding-left", "4px");
  $(".list_string div:first-child").css("min-width", "46px");

  // OUTBOX
  $("#announcement_add").parent().parent().addClass("mr-0");
  $("#announcement_add").css("max-width", "27%");
  $("#modal_flt_open").css("max-width", "25%");
  $("#modal_flt_open").show();
  $("#announcement_tab_1 select").hide();
  $("#announcement_tab_1 .ftt_buttons_bar").css("margin-bottom", "0px");
  $("#announcement_tab_1 .ftt_buttons_bar").css("padding-bottom", "10px");
  $("#announcement_tab_1 .ftt_buttons_bar").css("border-bottom", "1px solid lightgray");
  $("#announcement_tab_1 .ftt_buttons_bar").css("width", "100%");
  $("#announcement_tab_1 .ftt_buttons_bar").css("margin-left", "9px");
  $("#announcement_tab_1 .ftt_buttons_bar").css("padding-left", "6px");
  $("#announcement_tab_1 .list_string div:first-child").next().removeClass("col-2").addClass("col-3");
  $("#announcement_tab_1 .list_string div:first-child").next().next().hide();
  //$("#announcement_tab_1 .list_string div:first-child").next().next().next().hide();
  $("#announcement_tab_1 .list_string div:first-child").next().next().next().next().removeClass("col-2").addClass("col-4");
  $("#announcement_tab_1 .list_string div:first-child").next().next().next().next().find("span").addClass("float-right");
  $("#announcement_tab_1 .list_string div:first-child").next().next().next().next().next().show();
  $("#announcement_tab_1 .list_string div:first-child").next().next().next().next().next().next().show();

  // BLANK
  $("#announcement_to_14").parent().parent().parent().parent().addClass("pr-1");
  $("#announcement_to_14").parent().parent().parent().parent().removeClass("col-6").addClass("col-5");
  $("#announcement_to_14").parent().parent().parent().parent().next().removeClass("col-6").addClass("col-7");
  $("#announcement_to_14").parent().parent().parent().parent().next().addClass("pl-1");
  $("#announcement_to_14").parent().parent().parent().parent().next().addClass("pr-1");
  /*$("#announcement_date_publication").parent().css("margin-right", "20px");
  $("#announcement_time_publication").css("min-width", "55px");
  $("#announcement_date_archivation").parent().css("padding-left", "0px");
  $("#announcement_to_archive").parent().removeClass("pl-0").addClass("pl-1");
  $("#label_time_field").removeClass("pl-4").addClass("pl-1");
  $("#label_time_field").parent().css("padding-right", "0px");
  $("#label_time_field").parent().css("min-width", "200px");
  $("#label_time_field").parent().next().css("padding-left", "5px");*/

  // INBOX
  $("#announcement_tab_2 .ftt_buttons_bar").css("padding-bottom", "10px");
  $("#announcement_tab_2 .ftt_buttons_bar").css("width", "100%");
  $("#announcement_tab_2 .ftt_buttons_bar").css("border-bottom", "1px solid lightgray");
  $("#flt_read").css("width", "150px");
  $("#announcement_tab_2 .list_string div:first-child").next().next().next().hide();
  //$("#announcement_tab_2 .list_string div:first-child").next().removeClass("col-6").addClass("col-6");
  $("#announcement_tab_2").addClass("pl-0");
  $("#announcement_tab_2").parent().parent().addClass("pr-0");
  $(".list_string").addClass("mr-0");
} else {
  $(".list_header").show();
}

//let modal_footer_width = $("#announcement_modal_edit .modal-dialog").css("width") - $("#announcement_modal_edit .modal-modal-footer").css("padding-left") - $("#announcement_modal_edit .modal-modal-footer").css("padding-right") - 2;
$("#announcement_modal_edit .modal-footer div").css("width", "100%");
