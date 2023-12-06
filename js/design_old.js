// Design old
if ($(window).width()<=769) {
  // menu
  $(".navbarmain .nav-link").css('font-weight', 'bold');
  // seaerch field
  $(".search-text").removeClass("span5");
  $(".search-text").css("width", "93%");
  $(".search-text").css("margin-top", "5px");
  $(".members-lists-combo").css("max-width", "auto");
  $(".members-lists-combo").css("width", "97%");
  $(".close-event-registration").css("display", "block");
} else {
  // прибить футер
  if (window.location.pathname === '/index.php' || window.location.pathname === '/index') {
    footer_btm(135, true);
  } else if (window.location.pathname === '/meetings.php' || window.location.pathname === '/meetings' || window.location.pathname === '/members.php' || window.location.pathname === '/members' || window.location.pathname === '/youth.php' || window.location.pathname === '/youth') {
    footer_btm(62, true, 1000);
  } else if (window.location.pathname === '/list.php' || window.location.pathname === '/list') {
    footer_btm(62, true, 1500);
  } else if (window.location.pathname !== '/reg.php' || window.location.pathname !== '/reg') {
    footer_btm(50, true);
  }
}
