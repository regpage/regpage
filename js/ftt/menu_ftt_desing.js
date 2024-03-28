// ссылки-кнопки
$("#ftt_navs .active").addClass('mark_menu_item');
$("#ftt_navs a").click(function () {
  $("#ftt_navs .active").removeClass('mark_menu_item');
  $("#ftt_navs .active").removeClass('active');
  $(this).addClass('active');
  $(this).addClass('mark_menu_item');
  $(this).parent().addClass('active-li-back');
});

// Мобильная / десктопная версия при старте страницы
if ($(window).width()<=769) { // Мобильная версия
  $("#ftt_navs ul").css("margin-left", "0px");
  $("#ftt_navs ul").css("margin-right", "0px");
  $("#ftt_navs").css("padding-left", "10px");
  $("#ftt_navs").css("padding-right", "10px");
  //$("#ftt_navs a").css("padding-left", "4px");
  //$("#ftt_navs a").css("padding-right", "4px");
//  $("#ftt_navs a").attr("style", "padding-left: 0px !important; padding-right: 0px !important;");
  //$("#ftt_navs a").attr("style", "");
  $("#ftt_navs .nav-link").hover(function(){
    $(this).css("font-weight", "normal");
    }, function(){
    //$(this).css("background-color", "pink");
  });
  // шрифт мобильной версии
  $("#menu_nav_ftt").css("font-size", "16px");
  // Уведомление об общении
  $(".fellowship_today").css("padding-left", "0px");
} else { // Десктоп версия
  // ширина контейнера кнопки
  $("#ftt_navs li").each(function () {
    $(this).width($(this).width()+1);
    $(this).addClass('text-center');
  });
}

// При изменении размера экрана
$(window).resize(function(){
  if ($(window).width()<=769) { // Мобильная версия
    // шрифт мобильной версии
    $("#menu_nav_ftt").css("font-size", "16px");
  } else {// Десктоп версия
    // шрифт мобильной версии
    $("#menu_nav_ftt").css("font-size", "14px");
  }
});
