$(document).ready(function(){
  // Мобильная версия
  if ($(window).width()<=769) {
    // bar
    $("#time_zone_select").removeClass("col-3").addClass("col-4");

    $("#ftt_schedule_list").removeClass("col-6");
    $("#ftt_schedule_list").addClass("col-12");
    $("#ftt_schedule_list").css("padding", "0");
    $("#ftt_schedule_container_2").removeClass("col-6");
    $("#ftt_schedule_container_2").addClass("col-12");
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
      $("#accordionExample .comment_col").removeClass("col-3").addClass("no-col").hide();
      // trainee
      $("#accordionExample .col-4").removeClass("col-4").addClass("col-8");
      $("#accordionExample .col-2").removeClass("col-2").addClass("col-4").attr('style', 'padding-left: 0px !important; padding-right: 10px !important; min-width: 100px');
      // staff
      $("#accordionExample .col-6").removeClass("col-6").addClass("col-8");
      $("#accordionExample .col-3").removeClass("col-3").addClass("col-4").attr('style', 'padding: 0px !important; min-width: 95px');
      // 5-6
      $("#accordionExample_2 .comment_col").removeClass("col-3").addClass("no-col").hide();
      $("#accordionExample_2 .col-6").removeClass("col-6").addClass("col-8");
      $("#accordionExample_2 .col-3").removeClass("col-3").addClass("col-4").attr('style', 'padding: 0px !important; min-width: 95px');
    } else {
      $("#accordionExample .comment_col").removeClass("col-3").addClass("no-col").hide();
      // trainee
      $("#accordionExample .col-4").removeClass("col-4").addClass("col-8");
      $("#accordionExample .col-2").removeClass("col-2").addClass("col-4").attr('style', 'padding-left: 0px !important; padding-right: 10px !important; min-width: 100px');
      // staff
      $("#accordionExample .col-6").removeClass("col-6").addClass("col-8");
      $("#accordionExample .col-3").removeClass("col-3").addClass("col-4").attr('style', 'padding-left: 0px !important; padding-right: 10px !important; min-width: 100px');
      // 5-6
      $("#accordionExample_2 .comment_col").removeClass("col-3").addClass("no-col").hide();
      $("#accordionExample_2 .col-6").removeClass("col-6").addClass("col-8");
      $("#accordionExample_2 .col-3").removeClass("col-3").addClass("col-4").attr('style', 'padding-left: 0px !important; padding-right: 10px !important; min-width: 100px');
    }
    // подсказки
    $("#ftt_schedule_container .comment_col").each(function () {
      if ($(this).attr("title")) {
        // OFF
        //$(this).parent().find("col-4").css('padding', '0px;')
        //$(this).html('<i class="fa fa-sticky-note" aria-hidden="true"></i>');
        // Bootstrap tooltip
        $(this).parent().attr('title',$(this).attr("title"));
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
    // подсказки
    $("#ftt_schedule_container .comment_col").each(function () {
      if ($(this).attr("title")) {
        // OFF
        //$(this).parent().find("col-4").css('padding', '0px;')
        //$(this).html('<i class="fa fa-sticky-note" aria-hidden="true"></i>');
        // Bootstrap tooltip
        $(this).find("i").attr('title',$(this).attr("title"));
        $(this).find("i").attr("data-trigger", "click");
        //$(this).prev().prev().html($(this).prev().prev().text() + ' <i class="fa fa-sticky-note" aria-hidden="true"></i>');
        $(this).find("i").tooltip();
        $(this).find("i").attr('title',$(this).attr("title"));
      }
    });
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
