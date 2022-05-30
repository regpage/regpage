$(document).ready(function(){
  // Мобильная версия
  if ($(window).width()<=769) {
    // меню разделов в мобильной версии ПВОМ
    $("#ftt_schedule_container .container").css("padding", "0px");
    //$("#ftt_navs a").css("padding-left", "8px");
    //$("#ftt_navs a").css("padding-right", "8px");
    $("#ftt_navs ul").css("margin-left", "0px");
    $("#ftt_navs ul").css("margin-right", "0px");
    $("#ftt_navs").css("padding-left", "10px");
    $("#ftt_navs").css("padding-right", "10px");
    // шрифт мобильной версии
    $(".container-xl").css("font-size", "16px");
    // расписание
    $("#ftt_sub_container").css("min-width", "100%");
    // разделы
    // Строки расписания
    if ($(window).width()<=386) {
      $("#accordionExample .col-6").removeClass("col-6").addClass("no-col").hide();
      $("#accordionExample .col-4").removeClass("col-4").addClass("col-8");
      $("#accordionExample .col-2").removeClass("col-2").addClass("col-4").attr('style', 'padding: 0px !important; min-width: 95px');
      // 5-6
      $("#accordionExample_2 .col-6").removeClass("col-6").addClass("no-col").hide();
      $("#accordionExample_2 .col-4").removeClass("col-4").addClass("col-8");
      $("#accordionExample_2 .col-2").removeClass("col-2").addClass("col-4").attr('style', 'padding: 0px !important; min-width: 95px');
    } else {
      $("#accordionExample .col-6").removeClass("col-6").addClass("no-col").hide();
      $("#accordionExample .col-4").removeClass("col-4").addClass("col-8");
      $("#accordionExample .col-2").removeClass("col-2").addClass("col-4").attr('style', 'padding-left: 0px !important; padding-right: 10px !important; min-width: 100px');
      // 5-6
      $("#accordionExample_2 .col-6").removeClass("col-6").addClass("no-col").hide();
      $("#accordionExample_2 .col-4").removeClass("col-4").addClass("col-8");
      $("#accordionExample_2 .col-2").removeClass("col-2").addClass("col-4").attr('style', 'padding-left: 0px !important; padding-right: 10px !important; min-width: 100px');
    }
    $("#accordionExample .no-col").each(function () {
      if ($(this).text()) {
        // OFF
        //$(this).parent().find("col-4").css('padding', '0px;')
        //$(this).html('<i class="fa fa-sticky-note" aria-hidden="true"></i>');
        // Bootstrap tooltip
        $(this).parent().attr('title',$(this).text());
        $(this).parent().attr('data-trigger', 'click');
        $(this).prev().prev().html($(this).prev().prev().text() + ' <i class="fa fa-sticky-note" aria-hidden="true"></i>');
        $(this).parent().tooltip();
      }
    });
    $("#accordionExample_2 .no-col").each(function () {
      if ($(this).text()) {
        // OFF
        //$(this).parent().find("col-4").css('padding', '0px;')
        //$(this).html('<i class="fa fa-sticky-note" aria-hidden="true"></i>');
        // Bootstrap tooltip
        $(this).parent().attr('title',$(this).text());
        $(this).parent().attr('data-trigger', 'click');
        $(this).prev().prev().html($(this).prev().prev().text() + ' <i class="fa fa-sticky-note" aria-hidden="true"></i>');
        $(this).parent().tooltip();
      }
    });
  } else { // desktop version
    $("#accordionExample .card-header").css("padding-top", "0px");
    $("#accordionExample .card-header").css("padding-bottom", "0px");
    //5-6
    $("#accordionExample_2 .card-header").css("padding-top", "0px");
    $("#accordionExample_2 .card-header").css("padding-bottom", "0px");
    /*$("#ftt_navs .nav-link").each(function () {
      if (!$(this).hasClass('active')) {
        $(this).css("padding-left", "8px");
        $(this).css("padding-left", "8px");
      }
    });*/
  }

  $(window).resize(function(){
    if ($(window).width()<=769) {
      // меню разделов в мобильной версии ПВОМ
      $("#ftt_schedule_container .container").css("padding", "0px");
      // шрифт мобильной версии
      $("#main_container").css("font-size", "16px");
      // расписание
      $("#ftt_sub_container").css("min-width", "100%");
      // разделы
    } else {

    }
  });
});
