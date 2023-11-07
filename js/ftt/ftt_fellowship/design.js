//design
if ($(window).width()<=769) {
  // ------ FELLOWSHIP ------
  // fonts
  $("#main_container").css("font-size", "16px");
  $("#main_container button").css("font-size", "16px");
  $("#main_container select").css("font-size", "16px");
  $("#mdl_edit_fellowship_staff").css("font-size", "16px");
  $("#mdl_meet_trainee_to_record").css("font-size", "16px");
  $("#edit_meet_blank_record_confirm").css("font-size", "16px");
  $("button").css("font-size", "16px");
  $("input").css("font-size", "16px");
  $("select").css("font-size", "16px");
  $("textarea").css("font-size", "16px");
  $(".row_meet").hide();
  // BLANK
  $("#mdl_meet_date").parent().removeClass("col-6").addClass("col-5").addClass("pr-0");
  $("#mdl_meet_time").parent().removeClass("col-4").addClass("col-5");
  $("#mdl_meet_duration").parent().addClass("pl-0");
  // STAFF
  $(".fellowship_today").css("padding-left", "0px");
  $(".str_record_staff div:nth-child(1)").addClass("pl-0").css("min-width", "50px");
  $(".str_record_staff div:nth-child(2)").addClass("pl-0").css("min-width", "50px");
  $(".str_record_staff div:nth-child(3)").addClass("pl-0").css("min-width", "25px");
  $(".str_record_staff div:nth-child(4)").addClass("pl-0").addClass("pr-2").removeClass("col-2").addClass("col-4").css("max-width", "110px");
  $(".str_record_staff div:nth-child(5)").addClass("pl-0").addClass("pr-1").removeClass("col-2").addClass("col-3").css("min-width", "120px");
  $(".str_record_staff div:nth-child(6)").removeClass("col-5").addClass("col-12").addClass("pl-1");
  // TRAINEE
  $(".str_record div:nth-child(1)").addClass("pl-0").addClass("pr-1").css("min-width", "75px");
  $(".str_record div:nth-child(2)").addClass("pr-0").addClass("pl-0").css("min-width", "105px");
  $(".str_record div:nth-child(3)").addClass("pl-0").addClass("pr-0").css("min-width", "80px").text("(" + $(".str_record div:nth-child(3)").text() + " мин)");
  $(".str_record div:nth-child(4)").addClass("pl-0").addClass("pr-0").show();
  $(".str_record div:nth-child(5)").removeClass("col-3").addClass("col-12").css("padding-left", "75px");
  $(".str_record div:nth-child(6)").hide();

  if ($(window).width()<=390) {

  }
} else if ($(window).width()<=991 && $(window).width()>769) {

} else {

}
