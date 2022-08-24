//design
if ($(window).width()<=769) {
  // containers
  $("#main_row").attr('style', 'width: 100% !important;');

  // headers

  // columns

  //strings
  $("#change_tab").removeClass("col-2").addClass("col-5");
  $("#list_header").hide();
  $(".list_string div").css("min-width", "");
  $(".list_string div").css("max-width", "");

  $(".list_string .d-none").removeClass("d-none");
  $(".list_string .col-2").addClass("pl-1");
  $(".list_string .col-3").addClass("pl-1");
  $(".list_string .col-3").prev().removeClass("col-2").addClass("col-4");
  $(".list_string .col-2").removeClass("col-2").addClass("col-12");
  

  $(".list_string .col-3").removeClass("col-3").addClass("col-8");

  $(".list_string .col-1").hide();

// Blank
  $(".cd-panel__container").css("width", "100%");
} else if ($(window).width()<=991 && $(window).width()>769) {

} else {
  $("#main_container").css("padding-top", "0");
}

$("#main_container").css("margin-top", "60px");
