renewComboLists('.members-lists-combo');
$('#modalEditMember').on('show', function() {
  setTimeout(function () {
      // error block for locality
      if (!$("#inputEmLocalityId").val() && !$("#emNewLocality").val() && !$("#inputEmLocalityId").parent(".control-group").hasClass("error")) {
        console.log(!$("#inputEmLocalityId").val() + " / " + !$("#emNewLocality").val() + " / " + !$("#inputEmLocalityId").parent().parent().hasClass("error"));
        $("#inputEmLocalityId").parent().parent().addClass("error");
      }
  }, 60);
  setTimeout(function () {
    showBlankEvents();
    // проверить условия
    if ($('#inputEmLocalityId').val() === 'ПВОМ' && $('#selMemberLocality').find('option[value="001214"]').val() && $(".emCategory").val() === "FT") {
      $(".ftt_block").show();
      console.log(window.currentEditMemberId);
      fetch('ajax/members.php?trainee_data=1&id='+window.currentEditMemberId)
      .then(response => response.json())
      .then(result => {
        // Вставить данные в поля
        console.log(result.trainee);
      });
    } else {
      $(".ftt_block").hide();
      $(".ftt_block").find('input').val("");
      $(".ftt_block").find('select').val("_none_");
    }
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
});
$('#modalEditMember').on('hide', function() {
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
