//design
// phone
if ($(window).width()<=769) {
  //$("#save_book_read").
  $("#date_read").parent().attr("style", "");
  $("#show_me_start").attr("style", "min-width: 45px !important; height: 38px;");
  $("#mdl_lest_reading_bible").parent().removeClass("col-6").addClass("col-12");
  $("#mdl_cal_reading_bible").removeClass("col-6").addClass("col-12").addClass("pl-0").addClass("pr-0");
  // font size
  $("#main_container").css("font-size", "16px");
  $("#main_container button").css("font-size", "16px");
  $("#main_container select").css("font-size", "16px");
  $("#mdl_lest_reading_bible").css("font-size", "16px");
  // very small dysplay
  $(".read_name").css("min-width", "300px");
  $(".read_day").removeClass("mr-2").addClass("mr-1").addClass("mb-1");
  $("#read_sevice_one_select").parent().removeClass("col-2").addClass("col-6")

  if ($(window).width()<=390) {

  }

// tab
} else if ($(window).width()<=991 && $(window).width()>769) {

// desktop
} else {

}
