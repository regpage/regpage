//design
if ($(window).width()<=769) {
  $("#main_container .col-5").removeClass("col-5").addClass("col-12").addClass("mb-2").parent().addClass("mb-3");
  $("#main_container .i-width-370-px").removeClass("i-width-370-px").addClass("i-width-350-px");

}

/*
// ДИЗАЙН
// SCROLL UP
function handleScrollUp(){
		let height = $("body").height();

    //  кнопка подняться наверх страницы
    height>600 && (window.pageYOffset > 300 || document.documentElement.scrollTop >300) ? $(".scroll-up").show() : $(".scroll-up").hide();

    // Фиксация панели кнопок
    if (height>600 && (window.pageYOffset > 300 || document.documentElement.scrollTop >50)) {
      $("#buttons_bar").css("top","55px");
      //$("#buttons_bar").css("max-width","1120px");
      $("#buttons_bar").css("margin-left","auto");
      $("#buttons_bar").css("margin-right","auto");
      $("#buttons_bar").addClass("fixed-top");
    }
}

window.onscroll = function() {
		handleScrollUp();
};

$(".scroll-up").click(function(e){
		e.stopPropagation();

		//scrollTo(document.body, 0, 500);
	//  setTimeout(function(){
				document.body.scrollTop = document.documentElement.scrollTop = 0;
//    }, 500);
		$('body').animate({
				scrollTop: 0
		}, 500);
});

*/
