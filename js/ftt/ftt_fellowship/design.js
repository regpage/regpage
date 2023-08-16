//design
if ($(window).width()<=769) {
  // **** FELLOWSHIP ****
  $(".row_meet").hide();
  $(".fellowship_today").css("padding-left", "0px");
  $(".str_record_staff div:nth-child(1)").addClass("pl-0").css("min-width", "50px");
  $(".str_record_staff div:nth-child(2)").addClass("pl-0").css("min-width", "50px");
  $(".str_record_staff div:nth-child(3)").addClass("pl-0").css("min-width", "50px");
  $(".str_record_staff div:nth-child(4)").addClass("pl-0").addClass("pr-2").removeClass("col-2").addClass("col-4").css("max-width", "110px");
  $(".str_record_staff div:nth-child(5)").addClass("pl-0").addClass("pr-1").removeClass("col-2").addClass("col-3").css("min-width", "120px");
  $(".str_record_staff div:nth-child(6)").removeClass("col-5").addClass("col-12").addClass("pl-1");
  if ($(window).width()<=390) {

  }
} else if ($(window).width()<=991 && $(window).width()>769) {

} else {

}
