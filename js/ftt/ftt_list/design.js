//design
if ($(window).width()<=769) {
  // containers
  $("#main_row").attr('style', 'width: 100% !important;');

  // headers
  $("#tab_service_one select").removeClass("col-2").addClass("col-5")
  $("#tab_content select").css("min-width", "110px");

  // Filters and buttons

  $("#filters_bar select").removeClass("mr-2").addClass("mr-1")
  $("#sevice_one_select").addClass("mt-2");
  $("#category_select").addClass("mt-2");

  // columns
  $("#list_header").hide();
  $("#list_header_staff").hide();

  //strings
  $("#tab_content").css("font-size", "16px");
  $("#change_tab").removeClass("col-2").addClass("col-5");

  $(".list_string div").css("min-width", "");
  $(".list_string div").css("max-width", "");

  $(".list_string .d-none").removeClass("d-none");
  $(".list_string .col-2").addClass("pl-1");
  $(".list_string .col-3").addClass("pl-1");
  $(".list_string .col-3").prev().removeClass("col-2").addClass("col-4");
  $(".list_string .col-2").removeClass("col-2").addClass("col-12");
  //$(".list_string .col-2").first().removeClass("col-2").addClass("col-12");

  $(".list_string .col-3").removeClass("col-3").addClass("col-8");
  //$(".list_string .col-2").first().removeClass("col-2").addClass("col-6");
  $(".list_string .col-1").hide();
  $(".list_string .m_email").hide();
  $(".list_string .m_cell_phone").hide();

  //$(".list_string .col-2").removeClass("col-2").addClass("col-6");
  //$(".list_string .col-1").removeClass("col-1").addClass("col");
  // Bootstrap tooltip
/*
  $("#list_content i").each(function () {
    $(this).attr("data-trigger", "click");
    $(this).tooltip();
  });
*/
// Blank
  $("#modalAddEdit .btn-sm").removeClass("btn-sm");
  $(".cd-panel__container").css("width", "100%");
} else if ($(window).width()<=991 && $(window).width()>769) {

} else {
  $("#main_container").css("padding-top", "0");
  $("#search_field").removeClass("w-50");
  $("#search_field").addClass("col-5");
  //$("#search_field").css("max-width", "189px");
  $("#change_tab").removeClass("w-50");
  $("#change_tab").removeClass("col-2").addClass("col-5");
  $("#change_tab").css("max-width", "");
}

$("#main_container").css("margin-top", "60px");
$("#menu_nav_ftt").hide();
