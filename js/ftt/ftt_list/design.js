//design
if ($(window).width()<=769) {
  // containers
  $("#main_row").attr('style', 'width: 100% !important;');

  // headers

  // columns

  //strings

  // Bootstrap tooltip
/*
  $("#list_content i").each(function () {
    $(this).attr("data-trigger", "click");
    $(this).tooltip();
  });
*/
} else if ($(window).width()<=991 && $(window).width()>769) {

} else {
  $("#main_container").css("padding-top", "0");
}

$("#main_container").css("margin-top", "60px");
$("#menu_nav_ftt").hide();
