//design
if ($(window).width()<=769) {
  // containers
  $(".list_header").hide();
  $(".list_string div").css("padding-right", "4px");
  $(".list_string div").css("padding-left", "4px");
  $(".list_string div:first-child").css("min-width", "46px");

  // OUTBOX
  $("#announcement_tab_1 .ftt_buttons_bar").css("margin-bottom", "0px");
  $("#announcement_tab_1 .ftt_buttons_bar").css("padding-bottom", "10px");
  $("#announcement_tab_1 .ftt_buttons_bar").css("border-bottom", "1px solid lightgray");
  $("#announcement_tab_1 .ftt_buttons_bar").css("margin-left", "9px");
  $("#announcement_tab_1 .ftt_buttons_bar").css("padding-left", "6px");
  $("#announcement_tab_1 .list_string div:first-child").next().removeClass("col-2").addClass("col-5");
  $("#announcement_tab_1 .list_string div:first-child").next().next().hide();
  $("#announcement_tab_1 .list_string div:first-child").next().next().next().hide();
  $("#announcement_tab_1 .list_string div:first-child").next().next().next().next().removeClass("col-2").addClass("col-5");
  $("#announcement_tab_1 .list_string div:first-child").next().next().next().next().find("span").addClass("float-right");
  $("#announcement_tab_1 .list_string div:first-child").next().next().next().next().next().show();
  $("#announcement_tab_1 .list_string div:first-child").next().next().next().next().next().next().show();

  // BLOCK
  $("#announcement_date_publication").parent().css("margin-right", "20px");
  $("#announcement_time_publication").css("min-width", "55px");
  $("#announcement_date_archivation").parent().css("padding-left", "0px");
  $("#announcement_to_archive").parent().removeClass("pl-0").addClass("pl-1");
  $("#label_time_field").removeClass("pl-4").addClass("pl-1");
  $("#label_time_field").parent().css("padding-right", "0px");
  $("#label_time_field").parent().css("min-width", "200px");
  $("#label_time_field").parent().next().css("padding-left", "5px");

  // INBOX
  $("#announcement_tab_2 .ftt_buttons_bar").css("padding-bottom", "10px");
  $("#announcement_tab_2 .ftt_buttons_bar").css("width", "100%");
  $("#announcement_tab_2 .ftt_buttons_bar").css("border-bottom", "1px solid lightgray");
  $("#flt_read").css("width", "150px");
  $("#announcement_tab_2 .list_string div:first-child").next().next().next().hide();
  $("#announcement_tab_2 .list_string div:first-child").next().removeClass("col-5").addClass("col-6");
} else {
  $(".list_header").show();
}
