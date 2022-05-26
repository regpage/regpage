// ссылки-кнопки
$("#ftt_navs .active").addClass('mark_menu_item');
$("#ftt_navs .active").parent().addClass('active-li-back');
//$(".show-name-list b").text($("#ftt_navs .active").text());

$("#ftt_navs a").click(function () {
  $("#ftt_navs .active").removeClass('mark_menu_item');
  $("#ftt_navs .active").parent().removeClass('active-li-back');
  $(this).addClass('mark_menu_item');
  $(this).parent().addClass('active-li-back');

//  $(".show-name-list b").text($(this).text());
});

// стиль кнопок аккордиона
$('#ftt_schedule_container .btn').css('text-decoration', 'none');

$("#ftt_schedule_container .btn").click(function () {
  // прокрутка в мобильной версии
  let to_hash = $(this).parent().parent().attr('id');
  setTimeout(function () {
  if ($(window).width()<=769) {
    document.querySelector('#'+to_hash).scrollIntoView({
      behavior: 'smooth',
      block: 'nearest'
    });
  }
}, 300);
  if ($(this).hasClass('accordion-head')) {
    $(this).removeClass('accordion-head');
  } else {
    $('#ftt_schedule_container .accordion-head').removeClass('accordion-head');
    $(this).addClass('accordion-head');
    $(this).hover(function(){
    }, function(){
    });
  }
});

$("#ftt_schedule_container_2 .btn").click(function () {
  // прокрутка в мобильной версии
  let to_hash = $(this).parent().parent().attr('id');
  setTimeout(function () {
  if ($(window).width()<=769) {
    document.querySelector('#'+to_hash).scrollIntoView({
      behavior: 'smooth',
      block: 'nearest'
    });
  }
}, 300);
  if ($(this).hasClass('accordion-head')) {
    $(this).removeClass('accordion-head');
  } else {
    $('#ftt_schedule_container_2 .accordion-head').removeClass('accordion-head');
    $(this).addClass('accordion-head');
    $(this).hover(function(){
    }, function(){
    });
  }
});
// Служащие
// отобразить 5 и 6 семестры
$("#show_my_5_6").click(function () {
  if ($("#ftt_schedule_container_2").is(":visible")) {
    $("#ftt_schedule_container_2").hide();
  } else {
    $("#ftt_schedule_container_2").show();
  }
});
