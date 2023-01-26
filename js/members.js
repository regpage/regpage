renewComboLists('.members-lists-combo');
$('#modalEditMember').on('show', function() {
  // ЧАТ
  $("#supportTrigger").hide();
  setTimeout(function () {
      // error block for locality
      if (!$("#inputEmLocalityId").val() && !$("#emNewLocality").val() && !$("#inputEmLocalityId").parent(".control-group").hasClass("error")) {
        console.log(!$("#inputEmLocalityId").val() + " / " + !$("#emNewLocality").val() + " / " + !$("#inputEmLocalityId").parent().parent().hasClass("error"));
        $("#inputEmLocalityId").parent().parent().addClass("error");
      }
  }, 60);
  setTimeout(function () {
    showBlankEvents();
    $(".ftt_block").hide();
    $(".ftt_block").find('input').val("");
    $(".ftt_block").find('select').val("_none_");
  }, 50);
  setTimeout(function () {
    $('.emLocality').hide();
  }, 10);
  if ($('#modalEditMember').find('.emNewLocality').is(':visible')) {
    var newLocalityLength = $('#modalEditMember').find('.emNewLocality').val();
  }
  if (globalSingleCity && $('#modalEditMember').find('#btnDoSaveMember').hasClass('create')) {
    $('.emLocality option').each(function () {
        $(this).val() === '_none_' ? '' : $('.emLocality').val($(this).val());
    });
  }
  $('.modalListInput').hide();
  if (global_role_admin < 2) {
    $('#modalEditMember .handle-passport-info').hide();
    $('#modalEditMember .address_block').hide();
  }
});
$('#modalEditMember').on('hide', function() {
  // ЧАТ
  $("#supportTrigger").show();
  $('#modalEditMember').find('.emLocality').attr('data-value','');
  $('#modalEditMember').find('.emLocality').attr('data-text','');
  $('#modalEditMember').find('#inputEmLocalityId').attr('data-value_input','');
  $('#modalEditMember').find('#inputEmLocalityId').attr('data-text_input','');
  setTimeout(function () {
    if (!$('#modalEditMember').is(':visible')) {
      $('#modalEditMember .college-fields').find('input').each(function () {
        $(this).val() ? $(this).val('') : '';
      });
      $('#modalEditMember .school-fields').find('input').each(function () {
        $(this).val() ? $(this).val('') : '';
      });
    }
  }, 500);
});
history.pushState(null, null, location.href);
    window.onpopstate = function () {
      if ($('#modalEditMember').is(':visible')) {
        history.go(1);
        $('#modalEditMember').modal('hide');
      }
    };
// START bug cover main menu
$('#modalEditMember').hide();
// STOP bug cover main menu
$('#service_ones_pvom').change(function() {
  var serviceOne = '1';
  $(this).val() ? serviceOne = $(this).val() : '';
  if (serviceOne[0] == '9') {
    showError('Что бы выбрать этого служащего, дождитесь синхронизации базы с 1С . Это может занять некоторое время.')
    $(this).val('');
  }
});

// PRINT LIST
function print_rendering_elements(modal) {
  let page = [];
  if (modal) {
    page["title"] = "<html lang='ru'><head><title>Список</title></head>";
    page["style"] = "<style>th {border: 1px solid black; text-align: center; border-collapse: collapse; padding: 5px 0px;} table, td {border: 1px solid black; text-align: right; border-collapse: collapse;} .numpp {width: 30px; text-align: center;} .dates{width: 50px;} .fio{text-align: left; padding-left: 5px;} .age {text-align: center;} .bold{font-weight: bold;}</style>";
    page["header"] = "<body><h3>" + $("#selMemberLocality option:selected").text() + "</h3>";
    page["thead"] = "<table><thead><tr><th class='numpp'>№</th><th>ФИО</th><th class='dates'>Возр.</th><th class='dates'></th><th class='dates'></th><th class='dates'></th><th class='dates'></th><th class='dates'></th><th class='dates'></th></tr></thead>";
    page["end"] = "</table></body></html>";
  } else {
    page["tbody"] = "";
    let age, bold, selectors;
    if ($(window).width()<=769) {
      selectors = "#membersPhone tbody tr:visible";
    } else {
      selectors = "#members tbody tr:visible";
    }
    $(selectors).each(function (e) {
      if ($(this).attr("data-age") && $(this).attr("data-age") !== "null") {
        age = Math.floor($(this).attr("data-age"));
      } else {
        age = "";
      }

      if ($(this).attr("data-category") === "FT") {
        bold = "bold";
      } else {
        bold = "";
      }

      page["tbody"] += "<tbody><tr><td class='numpp'>" + (e + 1)
      + "</td><td class='fio " + bold + "'>" + $(this).attr("data-name")
      + "</td><td class='dates age'>" + age + "</td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td></tr>";
    });
    page["tbody"] += "</tbody>";
  }
  return page;
}

function print_page(element, is_preview) {
  function popup(table){
    let html = print_rendering_elements(true);
    let mywindow = window.open('', 'Список', 'height=800,width=1000');
    // рендерим страницу начало
    mywindow.document.write(html["title"]);
    mywindow.document.write(html["style"]);
    mywindow.document.write(html["header"]);
    mywindow.document.write(html["thead"]);
    mywindow.document.write(table);
    mywindow.document.write(html["end"]);
    // рендерим страницу конец
    //console.log(mywindow);
    if (!is_preview) {
      mywindow.print();
      mywindow.close();
    }
    return true;
  }

  function printElem(elem){
    popup($(elem).html());
  }

  printElem(element);
}

$("#btnPrintOpenModal").click(function () {
  //$("#modalPrintList").modal("show");
  let data = print_rendering_elements();
  $("#show_print_list").html(data["thead"] + data["tbody"]);
  // В мобильной версии можно предоставлять окно с результатом для дальнейшей печати или выгрузки
  print_page("#show_print_list");
});

// DESIGN
if ($(window).width()<=769) {
  $("body").css("font-size", "16px");
  $("#selMemberLocality").css("width", "208px");
  $("#selMemberCategory").css("width", "208px");
  $("#selMemberAttendMeeting").css("width", "208px");
  //$("#dropdownMenu1").parent().hide();
  $("#mblSortShow").parent().show();  
}

/*
$("#printListButton").click(function () {

});
*/
/*
// START hide empty city
function hideEmptyCity() {
  var city = [], members = [];
  $('#selMemberLocality option').each(function () {
    city.push($(this).val());
  });
  $('#members tbody tr').each(function () {
    members.push($(this).attr('data-locality'));
  });

  for (var i = 0; i < city.length; i++) {
    if (!(city[i].indexOf(',') !== -1 || city[i] === '_all_')) {
      var a = members.indexOf(city[i]);
      if (a === -1) {
        $('#selMemberLocality option').each(function () {
          if ($(this).val() == city[i]) {
            $(this).css('display', 'none');
          }
        });
      }
    }
  }
}
setTimeout(function () {
  hideEmptyCity();
}, 2000);
// STOP hide empty city
*/
