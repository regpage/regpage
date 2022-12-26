/* FRAME OLD CODE
setTimeout(function () {
  let frame_main = $("#frameFtt");
// + 470
  if ($(window).width()<=769) {
    $("#frameFtt").height($(frame_main[0].contentDocument).find(".tab-content").height() + $(frame_main[0].contentDocument).find(".flex-column").height() + 460);
    *//*
    if ($(window).width()<=769) {

    }
    *//*
  } else {
    //let frameDocument = getFrameDocument (frame_main);
    $("#frameFtt").height($(frame_main[0].contentDocument).find("#main_container").height() + 55);

  }
  $("#frameFtt").width($("#eventTabs").width());
  $("#spiner_wait").hide();
}, 2000);
*/
// menu ftt
// Мобильная
if ($(window).width()<=769) {
  // Меню ПВОМ в мобильной версии
  $(".ftt_menu_a").css("display", "inline-block");
  $("#ftt_trainee_block span").css("display", "inline-block");
  $(".ftt_menu_a").css("padding-left", "3px");
  $(".ftt_menu_a").css("padding-right", "3px");
  //$(".ftt_menu_a").css("padding", "8px");
  $("#ftt_trainee_block span").css("padding-left", "1px");
  $("#ftt_trainee_block span").css("padding-right", "1px");
  $("#ftt_trainee_block span").css("padding-top", "2px");
  $("#ftt_trainee_block span").css("padding-bottom", "18px");
  $("#ftt_trainee_block").css("padding-left", "10px");
  $("#ftt_trainee_block span").css("text-align", "center");
  $("#ftt_trainee_block").css("padding-right", "11px");
  // шрифт мобильной версии
  $(".ftt_menu_a").css("font-size", "16px");
  $("#ftt_trainee_block span").css("font-size", "16px");
  $("#ftt_trainee_block").attr("style", "margin-bottom: 10px; padding: 10px 11px 2px 10px;");
} else {
  if ($("body").height() < $(window).height()) {
    //console.log($(window).height());
		//console.log($("#eventTabs").height());
    //$("#eventTabs").height($(window).height() - ($("#eventTabs").height() - 190));
	}
  $("#ftt_trainee_block span").each(function () {
    $(this).css("display", "inline-block");
    $(this).css("text-align", "center");
    $(this).width($(this).width() + 13);
  });
}

// возвращает массив с датой год, месяц, день
function siparatedDate(date, separator) {
  //возвращает массив из 3 элементов, дату разбитую на три блока г м д
  if (!separator) {
    separator = "-";
  }
  return date.split(separator);
}

// if online no error arreve / depart
function secondCheckfields() {
  setFieldError ($(".datepicker, .datepicker-form"), false);
  $("#modalEditMember select").each(function () {
      if($(this).attr('valid') && $(this).hasClass('emCurrency')){
          setFieldError ($(this),
              $(this).parents (".controls").css('display')!='none' &&
              $(this).parents (isTabletWidth ? ".controls" : ".control-group").css('visibility')!='hidden' &&
              $(this).attr('disabled')!='disabled' &&
              (!$(this).val() || $(this).val()=="_none_"));
      }
  });
  $("#modalEditMember input[valid]").each(function () {
      setFieldError ($(this),
          $(this).parents(".controls").css('display')!='none' &&
          $(this).parents(isTabletWidth ? ".controls" : ".control-group").css('visibility')!='hidden' &&
          $(this).attr('disabled')!='disabled' &&
              (($(this).attr("valid").indexOf ("required")>=0 && ($(this).val().length==0 || $(this).val()=="__.__.____" || $(this).val()=="__.__")) ||
              ($(this).attr("valid").indexOf ("email")>=0 && ($(this).val().length>0 && /^[^@]+@[^@]+\.[^@]{2,5}$/.exec($(this).val())==null)) ||
              ($(this).attr("valid").indexOf ("integer")>=0 && (/^\d+$/.exec($(this).val())==null)) ||
              ($(this).attr("valid").indexOf ("required")>=0 && $(this).attr("valid").indexOf ("integer")>=0 && $(this).val()==0) ||
              ($(this).attr("valid").indexOf ("required")>=0 && $(this).val().trim()=='')
          )
      );
  });
}

$('#modalEditMember').on('show',  function() {
  // ЧАТ
  $("#supportTrigger").hide();
  // if online
  if ($(".theActiveEvent").attr('data-online_event') === "1") {
    let thisParent = $(".theActiveEvent");
    //arriveDepartMyself($(thisParent).attr('data-start_date'),'.emArrDate');
    //arriveDepartMyself($(thisParent).attr('data-end_date'),'.emDepDate');
    $(".emArrDate").parent().hide();
    $(".emDepDate").parent().hide();
    $(".emArrTime").parent().hide();
    $(".emDepTime").parent().hide();

    setTimeout(function () {
      let datearrive = siparatedDate($(thisParent).attr('data-start_date'));
      let datedepart = siparatedDate($(thisParent).attr('data-end_date'));
      if ($(".emArrDate").parent().hasClass("error") || $(".emDepDate").parent().hasClass("error")) {
        $(".emArrDate").parent().removeClass("error");
        $(".emDepDate").parent().removeClass("error");
        $(".emArrDate").val(datearrive[2] + "." + datearrive[1]);
        $(".emDepDate").val(datedepart[2] + "." + datedepart[1]);
        // if ONLINE no DATA ARRIVE AND DEPART
        secondCheckfields();
      }
      $(".emArrDate").val(datearrive[2] + "." + datearrive[1]);
      $(".emDepDate").val(datedepart[2] + "." + datedepart[1]);
    }, 1500);
    //setTimeout(function () {
    //}, 2500);
  } else {
    // ПРОВЕРИТЬ НА НЕ ОНЛАЙН МЕРОПРИЯТ
    $(".emArrDate").attr("required", true);
    $(".emDepDate").attr("required", true);
    setTimeout(function () {
      var form = $('#modalEditMember');
      var a = parseDDMM (form.find(".emArrDate").val());
      var b = parseDDMM (form.find(".emDepDate").val());
        if(!$('.emArrDate').parent().hasClass('error') && !a){
          $('.emArrDate').parent().addClass('error');
        };
        if(!$('.emDepDate').parent().hasClass('error') && !b){
          $('.emDepDate').parent().addClass('error');
      };
  }, 1000);
  }

  handleFieldsByAdminRole(adminRole, $('.event-row.theActiveEvent').attr('data-private'), $('.event-row.theActiveEvent').attr('data-regstate_key'));
});

// hide the blank
$('#modalEditMember').on('hide',  function() {
  // ЧАТ
  $("#supportTrigger").show();
  setTimeout(function () {
    if (!($('#modalEditMember').find('.parking').is(':visible'))) {
      $('#modalEditMember').find('.emAvtomobileNumber').val() ? $('#modalEditMember').find('.emAvtomobileNumber').val(''):'';
      $('#modalEditMember').find('.emAvtomobile').val() ? $('#modalEditMember').find('.emAvtomobile').val(''):'';
      $('#modalEditMember').find('.emParking').val() != '_none_' ? $('#modalEditMember').find('.emParking').val(0) : '';
    }
  }, 500);
});
function showEmptyForm (eventId){
    window.currentEventId = eventId;

    $.getJSON('/ajax/guest.php', { eventId: eventId })
    .done (function(data){
        window.currentEventName=data.info.event_name;
        fillEditMember ('', data.info);
        $("#modalEditMember").modal('show');
    });
}

function showSuccessMessage (text, link){
    $("#regSuccessTitle").text (window.currentEventName);
    $("#regSuccessText").html (text);
    $("#regSuccessLink").html (link);
    if (link) $("#regSuccessNotes").show (); else $("#regSuccessNotes").hide ();
    $("#modalEditMember").addClass('hide').modal('hide');
    $("#modalRegSuccess").modal('show');
}
// START add event modal fields set

$('.notRequired').click(function () {
  $(this).parent().find('div').is(':visible') ? $(this).parent().find('div').hide() : $(this).parent().find('div').show();
  var a = $(this).text(), b;
  if (a[0] == '-') {
    a = a.substring(1);
    b = '+' + a;
    $(this).text(b)
  } else if (a[0] == '+') {
    a = a.substring(1);
    b = '-' + a;
    $(this).text(b)
  }
});

function checkCurrencyAndContribFields() {
  if ($('.event-currency-modal').val() === '_none_') {
    $('.event-contrib-modal').attr('disabled', true);
    $('.event-contrib-modal').val('');
  } else {
    $('.event-contrib-modal').attr('disabled', false);
  }
}
checkCurrencyAndContribFields();
$('.event-currency-modal').change(function () {
  checkCurrencyAndContribFields();
});

$('#modalAddEditEvent').on('show', function () {
  setTimeout(function () {
  $('.notRequired').each(function () {
    var x = $(this).parent().find('input').val() ? $(this).parent().find('input').val() : 0;
    var y = $(this).parent().find('select').val() ? $(this).parent().find('select').val() : 0;
    var xLength, a = $(this).text(), b;
    x.length ? xLength = x.length : xLength = 0;
    if ((y == 0 || y == '_none_') && (x == 0 || xLength ==0)) {
      $(this).parent().find('div').hide();
      if (a[0] == '-') {
        a = a.substring(1);
        b = '+' + a;
        $(this).text(b)
      }
    } else {
      $(this).parent().find('div').show();
      if (a[0] == '+') {
       a = a.substring(1);
       b = '-' + a;
       $(this).text(b)
     }
    }
  })
  }, 500);
});

// STOP add event modal fields set

// START DENY FOR REGISTRATION ON PRIVATE
function handleFieldsByAdminRole(adminRole, isEventPrivate, regstate){
    $("#forAdminRegNotice").text('');
    if((adminRole == 1 || adminRole == 0) && isEventPrivate == 1){
        if (regstate == 'null') {
          $.getJSON('/ajax/guest.php?msg_privat')
          .done (function(data){
              $("#forAdminRegNotice").text(data);
          });
        }
    }
    else{
        if (!regstate || regstate=='05'){
        }
        else{
        }
    }
}
// STOP DENY FOR REGISTRATION ON PRIVATE

// Заявление на ПВОМ
$(".request-row").click(function () {
  setCookie("application_back", 0);
  setCookie("application_check", "");
  setCookie("application_prepare", "");
  setTimeout(function () {
    if (!$(this).hasClass("it_is_guest")) {
      window.location = "application.php";
    } else {
      window.location = "application.php?guest=1";
    }
  }, 50);
});

$(".application-row").click(function () {
  setCookie("application_back", 0);
  setCookie("application_check", "");
  setCookie("application_prepare", "");
  let hi_bye = $(this).attr("data-link");
  setTimeout(function () {
    window.location = hi_bye;
  }, 50);
});

function hideShowPVOMBlock(elem, show, set) {
  if (show) {
    elem.prev().prev().fadeOut(5);
    elem.prev().fadeOut(5);
    elem.css("padding-top", "0px");
    elem.text("Показать раздел");
    set ? localStorage.setItem('pvom_block', 1) : "";
  } else {
    elem.prev().prev().fadeIn(5);
    elem.prev().fadeIn(5);
    elem.css("padding-top", "10px");
    elem.text("Скрыть раздел");
    set ? localStorage.setItem('pvom_block', "") : "";
  }
}

$("#hideShowPVOMBlock").click(function () {
  hideShowPVOMBlock($(this), $(this).prev().is(":visible"), 1);
});
hideShowPVOMBlock($("#hideShowPVOMBlock"), localStorage.getItem('pvom_block'));
