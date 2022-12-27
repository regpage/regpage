// SCROLL UP
function handleScrollUp(){
		let height = $("body").height();
		//var scrollTop = $("body").scrollTop();

		height>600 && (window.pageYOffset > 300 || document.documentElement.scrollTop >300) ? $(".scroll-up").show() : $(".scroll-up").hide();

    if (height>600 && (window.pageYOffset > 300 || document.documentElement.scrollTop >50)) {
			// меню разделов пвом
			let = bar_top_position = '-77px';
			if ($("#menu_nav_ftt").hasClass("container-xl")) {
				if ($(window).width() < 769) {
					bar_top_position = '-157px';
				} else {
					bar_top_position = '-135px';
				}
			}
      if ($('.contactsBtnsBar').css('margin-top') !=='-77px' || $('.contactsBtnsBar').css('margin-top') !=='-157px' || $('.contactsBtnsBar').css('margin-top') !=='-233px' || $('.contactsBtnsBar').css('margin-top') !=='-135px') {
				if ($(window).width()>=769 && $(window).width()<1200) {
				//$('.contactsBtnsBar').css('padding-right','90px');
			} else if ($(window).width() < 769) {
				if (Number($('#footer_info a').css("font-size").split("p")[0]) < 16 && Number($('#footer_info a').css("font-size").split("p")[0]) > 10) {
					bar_top_position = '-230px';
				} else if (Number($('#footer_info a').css("font-size").split("p")[0]) > 16) {
					bar_top_position = '-247px';
				} else {
					bar_top_position = '-213px';
				}
			}
				$('.contactsBtnsBar').css('margin-top', bar_top_position);
				$('.contactsBtnsBar').css('border-bottom', '1px solid #ddd');
				$('.contactsBtnsBar').css('border-left', '1px solid #ddd');
				$('.contactsBtnsBar').css('border-right', '1px solid #ddd');
				$('.contactsBtnsBar').css('background-color', '#eee');
      }
			if (window.location.pathname === '/application.php') {
					// Фиксация панели кнопок страница Заявления
					//$("#buttons_bar").css("top","48px");
					//$("#buttons_bar").css("background-color","#eee");
					//$("#buttons_bar").addClass("fixed-top");
					//let element_position = $("#main_container");
					//$("#buttons_bar").css("left", element_position[0].offsetLeft+15);
					//$("#buttons_bar").css("width", element_position[0].offsetWidth);
					//$("#main_container").css("padding-top","60px");
					//$("#buttons_bar").attr("style", "")
					//$("#buttons_bar button").css("margin-top", "10px");
					//$("#buttons_bar button").css("margin-bottom", "10px");

					//$("#buttons_bar").css("border-button", "1px solid lightgrey");
					//$("#buttons_bar").css("border-radius", "5px");

					if ($(window).width()<=769) {
						//$("#main_container").css("padding-top","110px");
					} else {
						//$("#main_container").css("padding-top","60px");
						//$("#buttons_bar").css("border-left","1px solid lightgrey");
						//$("#buttons_bar").css("border-right","1px solid lightgrey");
						//$("#buttons_bar").css("position", "fixed");
						//$(".btn-group").css("margin-left", "auto");
						//$(".btn-group").css("margin-right", "auto");
					}
			}
    } else {
      if ($('.contactsBtnsBar').css('margin-top') !== '-50px') {
				$('.contactsBtnsBar').css('margin-top', '-50px');
				$('.contactsBtnsBar').css('border-bottom', 'none');
				$('.contactsBtnsBar').css('border-left', 'none');
				$('.contactsBtnsBar').css('border-right', 'none');
				$('.contactsBtnsBar').css('background-color', 'white');
      }
			if (window.location.pathname === '/application.php') {
					// Фиксация панели кнопок страница Заявления
					/*$("#buttons_bar").removeClass("fixed-top");
					$("#buttons_bar").css("top","0px");
					$("#buttons_bar").css("background-color", "white");
					$("#buttons_bar button").css("margin-top", "0px");
					$("#buttons_bar button").css("margin-bottom", "0px");
					$("#main_container").css("padding-top","20px");*/
					//$("#buttons_bar").css("border", "none");
					//$(".btn-group").css("padding", "0px");
					if ($(window).width()<=769) {
						//$(".btn-group").css("padding-left", "15px");
					} else {
						//$(".btn-g// меню разделов пвомroup").css("padding", "0px");
						/*$("#buttons_bar").css("border-left","none");
						$("#buttons_bar").css("border-right","none");*/
					}
			}
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
// STOP SCROLL UP

// START Menu & resize
// width


/*
if ($(window).width()>=1200) {
	//$('.contactsBtnsBar').css('padding-right','349px');
}
*/

if (window.location.pathname === '/contacts') {
	// меню разделов пвом
	if ($("#menu_nav_ftt").hasClass("container-xl")) {
		$("#leftSidepanel").parent().css("height", "0");
	}
	if ($(window).height()>=550) {
		var windowScreenHeight = $(window).height();
		var mainBlockHeight = windowScreenHeight;
		if (data_page.admin_role > 0 && windowScreenHeight < 675) {
			mainBlockHeight = mainBlockHeight - 170 - (windowScreenHeight - 550);
		} else if (data_page.admin_role === '0' && windowScreenHeight < 675) {
			mainBlockHeight = mainBlockHeight - 170 - (windowScreenHeight - 550);
		}else {
			mainBlockHeight = mainBlockHeight - 298;
		}
		var commentBlockHeight = windowScreenHeight - 339;
		var chatBlockHeight = windowScreenHeight - 370;

		chatBlockHeight+= 'px';
		commentBlockHeight+= 'px';
		mainBlockHeight+= 'px';

		if (Number($('#footer_info a').css("font-size").split("p")[0]) < 16 && Number($('#footer_info a').css("font-size").split("p")[0]) > 10  && $(window).width()<=769) {
			$('#personalBlankTab').css('height', "460px");
			$('#commentContact').parent().parent().css('height', "360px");
			$('#chatBlock').css('height', "329px");
			$('#saveContact').val("Сохр.");
			$('#cd-panel__close-watch').val("Закр.");
		} else if (Number($('#footer_info a').css("font-size").split("p")[0]) > 15 && $(window).width()<=769) {
			$('#personalBlankTab').css('height', "500px");
			$('#commentContact').parent().parent().css('height', "400px");
			$('#chatBlock').css('height', "369px");
			$('#saveContact').val("Сох");
			$('#cd-panel__close-watch').val("Зак");
		} else {
			if (($(window).height() - $('#personalBlankTab').height()) < 280 ) {
				$('#personalBlankTab').css('height', "410px");
				$('#commentContact').parent().parent().css('height', "320px");
				$('#chatBlock').css('height', "289px");
			} else {
				$('#personalBlankTab').css('height', mainBlockHeight);
			}
		}
	}

  if ($(window).width()>=769) {
		//$('.show-name-list').hide();
		$('#dropdownMenuContacts').hide();
    $('#listContactsMbl').hide();
    $('#listContacts').show();
    $('#selectAllChekboxMblShow').hide();
		if (data_page.admin_role === '0') {
			$('.contactsBtnsBar').css('padding-right', '200px');
		}
		if ($(window).width()>=769 && $(window).width()<1200) {
			$('#orderSentToContact').css('margin-right','5px');
		}
  } else {
		$("#contactsBtnsBar").css("border-bottom", "1px solid lightgrey");
		$("body").attr("style", "font-size: 18px !important");
		$('.bell-alarm').hide();
		$('.show-name-list').show();
    $('#listContactsMbl').show();
    $('#listContacts').hide();
    //$('#selectAllChekboxMblShow').show();
    $('#navbarNav ul').css('font-weight', 'bold');
    $('#navbarNav ul').css('padding', '10px');
    $('#addContact').html('<i class="fa fa-plus"></i>');
    $('#openUploadModal').html('<i class="fa fa-upload"></i>');
		$('#deleteContactsShowModal').html('<i class="fa fa-trash"></i>');
		$('#deleteArchiveContactBtn').val('Х');
		$('#appointResponsibleShow').html('<i class="fa fa-exchange"></i>');
		$('#appointStatusShow').html('<i class="fa fa-flag"></i>');
		$('#respStatistic').html('<i class="fa fa-list"></i>');
		$('#openFiltersPanelBtn').html('<i class="fa fa-filter"></i>');
// panel
		$('#addContact').parent().parent().css('min-width', '250px');
		$('#addContact').parent().parent().css('padding-left', '10px');
		$('#addContact').parent().parent().css('margin-bottom', '0px');
		$('#addContact').parent().css('padding-right', '5px');


		$('#contactsBtnsBar').css('width', (($(window).width()+15)+'px'));
		$('#contactsBtnsBar button').css('margin-bottom', '8px');
		$('#contactsBtnsBar').css('padding-right', '2px');
//
		$('#textFiltersForUsers').css('width', $('#textFiltersForUsers').parent().css('width'));
		$('#textFiltersForUsers').css('padding-left', '5px');

		$('.fa-question').parent().parent().css('margin-left', '0px');
    $('.divider-vertical').css('height', '0px');
    $('.divider-vertical').css('width', '120px');
    $('.divider-vertical').css('border-top', '1px solid  #716f6f');
    $('.divider-vertical').css('margin', '9px 9px');
    $('.nav-sub-container').css('min-width', '100%');
    $('#helpButton').hide();
    $('#helpButtonMbl').show();
		$('#phoneContact').parent().removeClass('col-6');
		$('#phoneContact').parent().addClass('col-5');
		$('#phoneContactCalling').addClass('col-1');
		$('#phoneContactCalling').show();

		$('.helpDeleteContact').css('margin-right', '10px');
		$('#deleteCntBtnBlank').html('<i class="fa fa-trash"></i>');
		$('#deleteCntBtnBlank').css('margin-right', '10px');

		//mobile
		if (data_page.admin_role === '0') {
			$('#listContactsMbl').css('padding-top', '30px');
		} else {
			if ($(window).width()<=381 && $('#respStatistic').is(':visible')) {
				//$('#periodLabel').css('margin-left', '120px');
				$('#listContactsMbl').css('padding-top', '50px');
			} else {
				$('#listContactsMbl').css('padding-top', '20px');
			}
		}

		$('.cd-panel__header-watch').css('width', '100%');
		$('.cd-panel__container-watch').css('width', '100%');
		$('#orderSentToContact').css('margin-right', '5px');
		$('#myBlanks').parent().attr('style', 'padding-right: 10px; margin-right: 8px; margin-top: 4px;');
		$('#periodsCombobox').parent().attr('style', 'padding-right: 10px; margin-right: 8px; margin-top: 4px;');

		$('#search-text').parent().css('padding-left','8px;');
		$('#search-text').parent().css('padding-right','10px;');
		$('#search-text').parent().css('margin-right','8px;');
		$('#search-text').parent().css('margin-top','4px');
		$('#search-text').parent().css('margin-bottom','0px !important;');
		var searchWidth = $(window).width()-50;
		searchWidth = String(searchWidth) + 'px !important';
		$('#search-text').css('max-width', searchWidth);
		$('#search-text').parent().hide();
		$('#openSearchFieldBtn').show();
		if ($(window).width()<525 && $(window).width()>380) {
			$('#adminNotes').attr('cols', '38');
		} else if ($(window).width()<=380 && $(window).width()>314) {
			$('#adminNotes').attr('cols', '30');
		} else if ($(window).width()<=314) {
			$('#adminNotes').attr('cols', '26');
		}
  }

// resize

  $(window).resize(function(){
    if ($(window).width()>=769) {
			data_page.isDesktop = 1;
			// menu
			$('#helpButton').show();
      $('#helpButtonMbl').hide();
			$('.show-name-list').hide();
			$('.divider-vertical').css('height', '34px');
      $('.divider-vertical').css('width', '0px');
      $('.divider-vertical').css('border-left', '1px solid  #716f6f');
      $('.divider-vertical').css('margin', '0px 9px');
			$('#navbarNav ul').css('font-weight', 'normal');
      $('#navbarNav ul').css('padding', '0');

			// Buttons bar & buttons
			$('#contactsBtnsBar').css('width', '1170px');
			$('#addContact').html('<i class="fa fa-plus"></i> Добавить');
	    $('#openUploadModal').html('<i class="fa fa-upload"></i> Загрузить');
			$('#deleteContactsShowModal').html('<i class="fa fa-trash"></i> Удалить');
			$('#appointResponsibleShow').html('<i class="fa fa-exchange"></i> Передать');
			$('#appointStatusShow').html('<i class="fa fa-flag"></i> Изменить статус');
			$('#respStatistic').html('<i class="fa fa-list"></i> Распределение');
			$('#openFiltersPanelBtn').html('Фильтры');
			$('#search-text').css('max-width', '100px !important;');
			$('#search-text').parent().css('padding-left','0px;');
			$('#search-text').parent().css('padding-right','0px;');
			$('#search-text').parent().css('margin-right','0px;');
			$('#search-text').parent().css('margin-top','0px');
			$('#search-text').parent().css('margin-bottom','0px !important;');
			$('#openSearchFieldBtn').hide();

			// List
			$('#listContactsMbl').hide();
			$('#listContacts').show();
			$('#selectAllChekboxMblShow').hide();

			// Blank
			$('#deleteArchiveContactBtn').val('Удалить');
			//$('#periodLabel').css('margin-left', '160px');
			$('.cd-panel__header-watch').css('width', '420px');
			$('.cd-panel__container-watch').css('width', '420px');
			$('#orderSentToContact').css('margin-right', '5px');
			if ($(window).width()>=525) {
				$('#adminNotes').attr('cols', '56');
			}

			// modal
			$('.helpDeleteContact').css('margin-right', '110px');
			$('#deleteCntBtnBlank').html('Удалить');
			$('#deleteCntBtnBlank').css('margin-right', '5px');

		/*
      $('.nav-sub-container').css('min-width', '1170px');
			$('#search-text').parent().attr('style', 'padding-left: 0; padding-right: 10px; margin-bottom: 0px !important;');
		*/
    } else if ($(window).width()<769) {
			data_page.isDesktop = 0;
			// menu
			$('#helpButton').hide();
			$('#helpButtonMbl').show();
			$('.show-name-list').show();
			$('.divider-vertical').css('height', '0px');
			$('.divider-vertical').css('width', '120px');
			$('.divider-vertical').css('border-top', '1px solid  #716f6f');
			$('.divider-vertical').css('margin', '9px 9px');
			$('.nav-sub-container').css('min-width', '100%');

			// Buttons bar & buttons
			$('#contactsBtnsBar').css('min-width', '100px');
			$('#addContact').html('<i class="fa fa-plus"></i>');
	    $('#openUploadModal').html('<i class="fa fa-upload"></i>');
			$('#deleteContactsShowModal').html('<i class="fa fa-trash"></i>');
			$('#appointResponsibleShow').html('<i class="fa fa-exchange"></i>');
			$('#appointStatusShow').html('<i class="fa fa-flag"></i>');
			$('#respStatistic').html('<i class="fa fa-list"></i>');
			$('#openFiltersPanelBtn').html('<i class="fa fa-filter"></i>');
			$('#search-text').parent().css('padding-left','8px;');
			$('#search-text').parent().css('padding-right','10px;');
			$('#search-text').parent().css('margin-right','8px;');
			$('#search-text').parent().css('margin-top','4px');
			$('#search-text').parent().css('margin-bottom','0px !important;');

			var searchWidth = $(window).width()-50;
			searchWidth = String(searchWidth) + 'px !important';
			$('#search-text').css('margin-bottom', searchWidth);
			$('#openSearchFieldBtn').show();
			if ($(window).width()<=381 && $('#respStatistic').is(':visible')) {
				//$('#periodLabel').css('margin-left', '120px');
				$('#listContactsMbl').css('padding-top', '80px');
			} else {
				$('#listContactsMbl').css('padding-top', '40px');
			}
			$('#contactsBtnsBar').css('width', (($(window).width()+15)+'px'));

			// List
			$('#listContactsMbl').show();
			$('#listContacts').hide();
			//$('#selectAllChekboxMblShow').show();

			// Blank
			$('#deleteArchiveContactBtn').val('Х');
			$('.cd-panel__header-watch').css('width', '100%');
			$('.cd-panel__container-watch').css('width', '100%');
			$('#orderSentToContact').css('margin-right', '5px');
			if ($(window).width()<525 && $(window).width()>380) {
				$('#adminNotes').attr('cols', '38');
			} else if ($(window).width()<=380 && $(window).width()>314) {
				$('#adminNotes').attr('cols', '30');
			} else if ($(window).width()<=314) {
				$('#adminNotes').attr('cols', '26');
			}

			// modal
			$('.helpDeleteContact').css('margin-right', '10px');
			$('#deleteCntBtnBlank').html('<i class="fa fa-trash"></i>');
			$('#deleteCntBtnBlank').css('margin-right', '10px');
			/*
			//mobile
			if (data_page.admin_role === '0') {
				$('#listContactsMbl').css('padding-top', '170px');
			} else {
				$('#listContactsMbl').css('padding-top', '210px');
			}

			$('#search-text').parent().attr('style', 'padding-left: 8px; padding-right: 10px; margin-right: 8px; margin-top: 4px;');
			*/
    }

  });
}
// STOP Menu & resize
// Заявление
if (window.location.pathname === "/application.php") {
	let element_pics_pass = $("input[data-field=passport_scan]").parent().parent().next();
	element_pics_pass.find(".col").hide();
	$(element_pics_pass.find("a")).each(function () {
		if ($(this).attr("href")) {
			$(this).parent().show();
		}
	});

	if ($(window).width()<=769) {
		$(".set_no").css("margin-left", "-65px");
		$(".i-width-350-px").removeClass("i-width-350-px").addClass("i-width-long-one");
		$("h5").removeClass("pl-3");
		$("h6").removeClass("pl-3");		
		$(".title_point").addClass("font-weight-bold");
		$(".grey_text").css("font-size", "16px");
		$(".form-check-label").css("font-weight", "normal");
		$(".btn-sm").removeClass("btn-sm");
		$("#main_container .container .col-12").css("padding-left", "0px");
		$("#main_container .container .col-12").css("padding-right", "0px");
		$("input[type='file']").each(function () {
			if ($(this).attr("id") === "point_passport_scan_2") {
				$(this).removeClass("b-width-100-px").css("width","138px");
			} else {
				$(this).removeClass("width-95-px").css("max-width","133px");
			}
		});
		$("body").attr("style", "font-size: 16px !important;");

		$("#toModalDeleteMyRequest").removeClass("mr-2").parent().addClass("text-right");
		//$(".btn-danger").html("<i class='fa fa-trash-o' aria-hidden='true'></i>");
		//$(".btn-success").html('<i class="fa fa-paper-plane-o" aria-hidden="true"></i>');
		$(".span-label-width-500").removeClass("span-label-width-500");
		// cols
		$(".col").css("min-width", "95%");
		$(".col-2").css("min-width", "95%");
		$(".col-4").css("min-width", "99%");
		$(".col-6").css("min-width", "95%");
		$(".col-8").css("min-width", "95%");
		$(".b-width-150-px").addClass("b-width-125-px").removeClass("b-width-150-px");
		// lables (spans)
		$(".span-label-width-120").removeClass("span-label-width-120");
		$(".span-label-width-180").removeClass("span-label-width-180");
		$(".span-label-width-200").removeClass("span-label-width-200");
		$(".span-label-width-210").addClass("span-label-width-120").removeClass("span-label-width-210");
		$(".span-label-width-500").removeClass("span-label-width-500");
		$("label[for=policy_agree]").addClass("b-width-250-px");
		// long field
		$(".i-width-long").each(function () {
			$(this).css("width","95%");
		});
		// select
		//$("select[data-field=locality_key]").addClass("b-width-150-px"); //b-width-200-px


		// Доп блоки
		$(".delete_extra_string").text("Удалить");
		// textarea width
		$(".t-width-long").each(function () {
			$(this).css("width","95%");
			$(this).css("height","160px");
		});

	} else {
		// long field
		let width_parent;
		let width_neigbor;
		$(".i-width-long").each(function () {
			let width_parent = $(this).parent().width();
			let width_neigbor = $(this).parent().find("span").width();
			$(this).css("width",width_parent-width_neigbor-46);
		});
		// textarea width
		$(".t-width-long").each(function () {
			$(this).css("width","95%");
		});
		$(".form-check-label").css("font-weight", "normal");
	}
}

// menu mobile the name of page
if ($(window).width()<=769) {
	$(".show-name-list").show();
	// main menu
	$(".navbarmain").css('height', '52px');
	$('.navbar .nav-link').attr('style', 'font-size: 17px !important; margin-top: 10px; font-weight: normal;');
	$('.nav-sub-container .help_link').parent().attr('style', 'margin-bottom: 10px; margin-top: 10px;');
	$(".nav-sub-container .divider-vertical").hide();
	$('.show-name-list').css('font-size', '17px');
	$('#main_container .tab-content .btn').css('font-size', '17px');
	//$('#main_container .tab-content select').css('font-size', '17px');
} else {
	/*console.log($(window).height());
	console.log($("#main_container").height());
	if (($("#main_container").height() + 117+91)< $(window).height()) {
		$("#footer_info").css("padding-top",($(window).height() - $("#main_container").height() - 160-125) + $("#main_container").height());
		console.log($(window).height());
		console.log($("#main_container").height());
	}*/
}
