
$(".remove-account").click(function(e){
    e.preventDefault();
    $("#reasonDeleteAccountModal").modal('show');
    $(".reason-remove-account").val('');
    $(".reason-remove-account").attr('disabled', false);
    $(".confirmRemoveAccount").attr('disabled', false);
    $.get('/ajax/contacts.php?check_remove_account', {member: memberId}).done(function(data){
      if (data.result > 0) {
        $(".confirmRemoveAccount").attr('disabled', true);
        $(".reason-remove-account").val('ПЕРЕД УДАЛЕНИЕМ ПЕРЕДАЙТЕ КАРТОЧКИ В РАЗДЕЛЕ КОНТАКТЫ');
        $(".reason-remove-account").attr('disabled', true);
      }
    });
});

$(".confirmRemoveAccount").click(function(){
    var reason = $(".reason-remove-account").val().trim();

    if(reason === ''){
        showError("Необходимо указать причину удаления учётной записи");
        return;
    }

    $.post('/ajax/login.php?remove_account', {member: memberId, reason : reason}).done(function(){
        window.location = '/';
    });
});

$('#logoutTotal').click(function() {
  $.get('ajax/login.php?logout_total', {memberId: memberId})
  .done (function() {
      window.location = "/";
  })
  .fail(function() {
  })
})
$(".btn-change-login").click(function(){
    $(".new-login").val('');
    $("#modalChangeLogin").modal('show');
    setTimeout(function(){
        $(".new-login").focus();
    }, 1000);
});

$(".btn-change-password").click(function(){
    $(".btn-save-password").attr('disabled', true);
    $(".emPassword, .emNewPassword, .emPasswordConfirm").val('');
    $("#modalChangePassword").modal('show');
    setTimeout(function(){
        $(".emPassword").focus();
    }, 1000);
});

function handlePasswordAlerts(){
    var confirmPassVal = $('.emPasswordConfirm').val(),
        passVal = $('.emNewPassword').val(),
        pass = $('.emPassword').val(),
        isPasswordHasError = false;

    if((pass.length < 5 && pass.length >= 0) || (passVal.length < 5 && passVal.length >= 0) || (passVal !== confirmPassVal && confirmPassVal.length >= 0)){
        isPasswordHasError = true;
    }

    if(isStringContainsWhitespace(confirmPassVal) || isStringContainsWhitespace(passVal)) {
        $('#passWhiteSpacesError').show();
        isPasswordHasError = true;
    }
    else{
        $('#passWhiteSpacesError').hide();
    }

    if(passVal.length < 5 && passVal.length > 0){
        $('#passLengthError').show();
        isPasswordHasError = true;
    }
    else{
        $('#passLengthError').hide();
    }

    if(passVal !== confirmPassVal && confirmPassVal.length > 0){
        $('#passError').show();
        isPasswordHasError = true;
    }
    else{
        $('#passError').hide();
    }

    $(".btn-save-password").attr('disabled', isPasswordHasError);
    return isPasswordHasError;
}
$('.emPassword').keyup(function(){
    var pass = $(this).val().trim();

    if(pass.length >= 5){
        $.post('/ajax/get.php?check_password', {pass: pass})
        .done(function(data){
            handlePasswordAlerts();
            if(data.result){
                $(".passRecProfile").css('display', 'none');
            }
            else{
                $(".passRecProfile").css('display', 'block');
            }
        });
    }
    else{
        handlePasswordAlerts();
        $(".passRecProfile").css('display', 'none');
    }
});

$('.emNewPassword, .emPasswordConfirm').keyup(function(){
    handlePasswordAlerts();
});

/*
$("#btnDoSendEventMsgAdmins").click (function (){
    if ($(this).hasClass('disabled')) return;

    $.ajax({type: "POST", url: "/ajax/set.php", data: {event:"", message: $("#sendMsgTextAdmin").val(), name:$("#sendMsgNameAdmin").val(), email:$("#sendMsgEmailAdmin").val(), admins:"События index.php"}})
    .done (function() {messageBox ('Ваше сообщение отправлено службе поддержки', $('#messageAdmins'));
        $("#sendMsgTextAdmins").val('');
    });
});
*/

function isStringContainsWhitespace(str){
    return str.indexOf(' ') >= 0;
}

$(".btn-save-password").click(function(){
    var pass = $(".emPassword").val().trim();
    var newPass = $(".emNewPassword").val().trim();
    var newPassConfirm = $(".emPasswordConfirm").val().trim();

    if($(".btn-save-password").attr('disabled') === 'disabled' || handlePasswordAlerts() || (newPass!== '' && newPass !== newPassConfirm)){
        $(".btn-save-password").attr('disabled', true);
        showError("Введите корректные данные для паролей");
        return;
    }

    $.post('/ajax/set.php?set_password', {pass:pass, newPass: newPass})
    .done(function(data){
        if(data.result){
            $("#modalChangePassword").modal('hide');
            showHint("Пароль успешно изменен!");
        }
        else{
            $(".btn-save-password").attr('disabled', true);
            showError("Введите корректные данные для паролей");
        }
    });
});

$('.saveProfile').click(function(){
    var el = $('#user-profile');
    let locality_prepare = '';
    let locality_new_prepare = '';
    if (el.find(".emLocalityNew").val()) {
      locality_new_prepare = el.find(".emLocalityNew").val();
      el.find(".emLocality").val("_none_");
    } else if (el.find(".emLocality").val() == "_none_" && !el.find(".emLocalityNew").val()) {
      showError('Поле "местность" или "новая местность" должны быть заполненны.');
    } else if (el.find(".emLocality").val() && !el.find(".emLocalityNew").val()) {
      locality_prepare = el.find(".emLocality").val();
    }

    $.post("/ajax/set.php?set_profile",{
        name: el.find(".emName").val (),
        birth_date: parseDate (el.find(".emBirthdate").val()),
        cell_phone: el.find(".emCellPhone").val(),
        locality_key: locality_prepare,
        new_locality: locality_new_prepare,
        gender: el.find('.emGender').val(),
        citizenship_key: el.find(".emCitizenship").val () == "_none_" ? "" : el.find(".emCitizenship").val(),
        notice_info : el.find('.emDispatch').prop('checked') === true ? 1 : 0,
        notice_reg : el.find('.emNotice').prop('checked') === true ? 1 : 0
    })
    .done (function(){
        var shortName;
        var fullName = el.find(".emName").val();
        fullName ? fullName = fullName.split(' ') : '';
        if (fullName) {
          shortName = fullName[0] + ' ' + fullName[1][0] + '. ';
        }
        if (fullName[2] && fullName[2] !== '-') {
          shortName = shortName + fullName[2][0] + '. ';
        }
        $('.user-name').text(shortName);
        showHint("Ваши данные успешно сохранены!");
    });
});

$('#modalShowChangeLoginInfoBtn').click(function(){
  window.location = '/login';
});
