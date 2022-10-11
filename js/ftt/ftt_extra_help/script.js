$(document).ready(function(){

  /* ==== MAIN & EXTRA HELP START ==== */

  // текущая дата гггг.мм.дд
  date_now_gl = date_now_gl ();

// Очистить форму
function clear_blank() {
  if ($("#current_extra_help").is(":visible")) {
    $('#modalAddEditExtraHelp').find('input').val('');
    if (trainee_access !== "1" || ftt_access_trainee) {
      $('#modalAddEditExtraHelp').find('select').val('_none_');
    }
    $('#modalAddEditExtraHelp').find('#reason_field').val('');
    $('#modalAddEditExtraHelp').find('#archive_checkbox_field').prop('checked', false);
    $('#modalAddEditExtraHelp').find('#author_of_extrahelp').text('');
    $('#modalAddEditExtraHelp').find('#archivator_of_extrahelp').text('');
    $('#modalAddEditExtraHelp').attr('data-id', '');
    $('#modalAddEditExtraHelp').attr('data-author', '');
    $('#modalAddEditExtraHelp').attr('data-trainee_id', '');
    $('#modalAddEditExtraHelp').attr('data-reason', '');
    $('#modalAddEditExtraHelp').attr('data-comment', '');
    $('#modalAddEditExtraHelp').attr('data-date', '');
    $('#modalAddEditExtraHelp').attr('data-archive', '');
    $('#modalAddEditExtraHelp').attr('data-serving_one', '');
    $('#modalAddEditExtraHelp').attr('data-archive_date', '');
    $('#modalAddEditExtraHelp').attr('data-service_one_archived_id', '');

    $('#modalAddEditExtraHelp #date_of_archive').parent().hide();

    // border field color
    $('#modalAddEditExtraHelp #fio_field').css('border-color', 'lightgray');
    $('#modalAddEditExtraHelp #date_field').css('border-color', 'lightgray');
    $('#modalAddEditExtraHelp #reason_field').css('border-color', 'lightgray');

    // info
    $('#modalAddEditExtraHelp #info_of_extrahelp').show();
  }

  // LATE
  if ($("#current_late").is(":visible")) {
    $('#modalAddEditLate').find('input').val('');
    $('#modalAddEditLate').find('select').val('_none_');
    $('#modalAddEditLate').find('#session_name_field').val('');
    $('#modalAddEditLate').find('#done_checkbox_field').prop('checked', false);
    $('#modalAddEditLate').find('#author_of_late').text('');

    $('#modalAddEditLate').attr('data-id', '');
    $('#modalAddEditLate').attr('data-author', '');
    $('#modalAddEditLate').attr('data-trainee_id', '');
    $('#modalAddEditLate').attr('data-reason', '');
    $('#modalAddEditLate').attr('data-comment', '');
    $('#modalAddEditLate').attr('data-date', '');
    $('#modalAddEditLate').attr('data-archive', '');
    $('#modalAddEditLate').attr('data-serving_one', '');
    $('#modalAddEditLate').attr('data-archive_date', '');
    $('#modalAddEditLate').attr('data-service_one_archived_id', '');

    $('#modalAddEditLate #fio_field_late').css('border-color', 'lightgray');
    $('#modalAddEditLate #date_field_late').css('border-color', 'lightgray');
    $('#modalAddEditLate #session_name_field').css('border-color', 'lightgray');
    $('#modalAddEditLate #minutes_field').css('border-color', 'lightgray');
    $('#modalAddEditLate #date_of_archive_late').parent().hide();

    // info
    $('#modalAddEditLate #info_of_late').show();
  }
}

// получить данные полей формы
function get_data_fields() {
 data = new FormData();
 data.append('id', $("#modalAddEditExtraHelp").attr('data-id'));
 data.append('date', $("#modalAddEditExtraHelp #date_field").val());
 data.append('member_key', $("#modalAddEditExtraHelp #fio_field").val());
 data.append('reason', $("#modalAddEditExtraHelp #reason_field").val());

 if ($("#archive_checkbox_field").prop("checked")) {
  if ($("#modalAddEditExtraHelp").attr('data-archive') !== 1) {
    data.append('serving_one', admin_id_gl);
    data.append('archive_date', date_now_gl);
  } else {
    data.append('serving_one', $('#modalAddEditExtraHelp').attr('data-service_one_archived_id'));
    data.append('archive_date', $("#modalAddEditExtraHelp #date_closed_field").val());
  }
  data.append('archive', 1);
} else {
  data.append('serving_one', '');
  data.append('archive', 0);
  data.append('archive_date', "0000-00-00");
}
 data.append('author', $("#modalAddEditExtraHelp").attr("data-author"));
 if ($("#modalAddEditExtraHelp #comment_field").val()) {
  data.append('comment', $("#modalAddEditExtraHelp #comment_field").val());
} else {
  data.append('comment', "");
}


 return data;
}

// validation
 function validation_fields(e) {
   // валидация значений полей extra help
   if ($("#modalAddEditExtraHelp").is(":visible")) {
     if ($('#modalAddEditExtraHelp #fio_field').val() === '_none_') {
       e.stopPropagation();
       e.preventDefault();
       showError('Заполните поля выделенные красной рамкой.');
       $('#modalAddEditExtraHelp #fio_field').css('border-color', 'red');
       if ($('#modalAddEditExtraHelp #date_field').val() === '') {
         $('#modalAddEditExtraHelp #date_field').css('border-color', 'red');
       }
       if ($('#modalAddEditExtraHelp #reason_field').val() === '') {
         $('#modalAddEditExtraHelp #reason_field').css('border-color', 'red');
       }
       return false;
     } else {
       $('#modalAddEditExtraHelp #fio_field').css('border-color', 'lightgray');
     }

     if ($('#modalAddEditExtraHelp #date_field').val() === '') {
       e.stopPropagation();
       e.preventDefault();
       $('#modalAddEditExtraHelp #date_field').css('border-color', 'red');
       if ($('#modalAddEditExtraHelp #reason_field').val() === '') {
         $('#modalAddEditExtraHelp #reason_field').css('border-color', 'red');
       }
       return false;
     } else {
       $('#modalAddEditExtraHelp #date_field').css('border-color', 'lightgray');
     }

     if ($('#modalAddEditExtraHelp #reason_field').val() === '') {
       e.stopPropagation();
       e.preventDefault();
       $('#modalAddEditExtraHelp #reason_field').css('border-color', 'red');
       return false;
     } else {
       $('#modalAddEditExtraHelp #reason_field').css('border-color', 'lightgray');
     }
     return true;
   }

   // валидация значений полей late
   if ($("#modalAddEditLate").is(":visible")) {
     if ($('#modalAddEditLate #fio_field_late').val() === '_none_') {
       e.stopPropagation();
       e.preventDefault();
       showError('Заполните поля выделенные красной рамкой.');
       $('#modalAddEditLate #fio_field_late').css('border-color', 'red');
       if ($('#modalAddEditLate #date_field_late').val() === '') {
         $('#modalAddEditLate #date_field_late').css('border-color', 'red');
       }
       if ($('#modalAddEditLate #session_name_field').val() === '') {
         $('#modalAddEditLate #session_name_field').css('border-color', 'red');
       }
       return false;
     } else {
       $('#modalAddEditLate #fio_field_late').css('border-color', 'lightgray');
     }

     if ($('#modalAddEditLate #date_field_late').val() === '') {
       e.stopPropagation();
       e.preventDefault();
       $('#modalAddEditLate #date_field_late').css('border-color', 'red');
       if ($('#modalAddEditLate #session_name_field').val() === '') {
         $('#modalAddEditLate #session_name_field').css('border-color', 'red');
       }
       return false;
     } else {
       $('#modalAddEditLate #date_field_late').css('border-color', 'lightgray');
     }
     // session name
     if ($('#modalAddEditLate #session_name_field').val() === '') {
       e.stopPropagation();
       e.preventDefault();
       $('#modalAddEditLate #session_name_field').css('border-color', 'red');
       return false;
     } else {
       $('#modalAddEditLate #session_name_field').css('border-color', 'lightgray');
     }
     // minutes
     if ($('#modalAddEditLate #minutes_field').val() === '') {
       e.stopPropagation();
       e.preventDefault();
       $('#modalAddEditLate #minutes_field').css('border-color', 'red');
       return false;
     } else {
       $('#modalAddEditLate #minutes_field').css('border-color', 'lightgray');
     }

     return true;
   }
 }

 function dinamic_add_string(data, update) {
   let status = "", hide_this = "", checked_class = "";
   if (data.archive === '1') {
     status = 'checked';
     checked_class = "green_string";
     if ($("#tasks_select").val() !== "_all_") {
       hide_this = 'display: none;';
     }
   }
   if (update) {
     let element_upd = $('.ftt_extra_help_string[data-id='+data.feh_id+']');
     if (checked_class) {
       element_upd.addClass(checked_class);
       element_upd.find(".set_to_archive").prop("checked", true);
       element_upd.attr('data-archived',data.archive_date);
     } else {
       element_upd.removeClass('green_string');
       element_upd.find(".set_to_archive").prop("checked", false);
       element_upd.attr('data-archived', '0000-00-00');

     }
     if (hide_this) {
       element_upd.hide();
     }
     let short_reason_text = data.reason;
     if (short_reason_text[50]) {
       short_reason_text = short_reason_text.substr(0,50) + '...';
     }

     element_upd.attr('data-service_one_id',data.ft_serving_one);
     element_upd.attr('data-service_one_archived_id',data.archivator);
     element_upd.attr('data-trainee_id',data.member_key);
     element_upd.attr('data-archive',data.archive);
     element_upd.attr('data-comment',data.comment);
     element_upd.attr('data-author',data.author);
     element_upd.attr('data-id',data.feh_id);
     element_upd.attr('data-semester',data.semester);
     element_upd.attr('data-date',data.date);
     element_upd.attr('data-reason',data.reason);
     element_upd.find('.trainee_name').text(trainee_list[data.member_key]);
     element_upd.find('.serving_one_name').text(serving_ones_list[data.ft_serving_one]);
     //element_upd.find('.semester_text').text(data.semester);
     element_upd.find('.reason_text').text(short_reason_text);
     element_upd.find('.date_create_text').text(dateStrFromyyyymmddToddmm(data.date));
     element_upd.find('.set_to_archive').text(data.archive);
     element_upd.find('.fa-sticky-note').parent().attr("title", data.comment);
   } else {
     let short_reason_text = data.reason;
     let hide_name = "";
     let col = "col-5";
     let reason_text = "reason_text";
     if (short_reason_text[50]) {
       short_reason_text = short_reason_text.substr(0,50) + '...';
     }
     if (!ftt_access_trainee && trainee_access === "1" && $(window).width()>=769) {
       hide_name = "hide_element";
       col = "col-8";
     } else if (!ftt_access_trainee && trainee_access === "1" && $(window).width()<=769) {
       location.reload();
     }
     if ($(window).width()<=769) {
       reason_text = "";
     }
   // новая карточка
   let update_string = '<div style="'+hide_this+'" class="row ftt_extra_help_string '+checked_class
   +'" data-service_one_id="'+ data.ft_serving_one
   +'" data-service_one_archived_id="'+ data.archivator
   +'" data-trainee_id="'+ data.member_key
   +'" data-archive="'+ data.archive
   +'" data-comment="'+ data.comment
   +'" data-author="'+ data.author
   +'" data-archived="'+ data.archive_date
   +'" data-reason="'+ data.reason
   +'" data-id="'+ data.feh_id
   +'" data-semester="'+ data.semester
   +'" data-date="'+ data.date
   +'" data-toggle="modal" data-target="#modalAddEditExtraHelp"><div class="col-2 date_create_text pl-1">'+ dateStrFromyyyymmddToddmm(data.date)
   +'</div><div class="col-3 '+ hide_name +'"><span class="trainee_name">'+ trainee_list[data.member_key]
   +'</span><span class="semester_text"> ('+ data.semester
   +')</span><br><span class="serving_one_name light_text_grey" style="'+hide_this+'">'+ serving_ones_list[data.ft_serving_one]
   +'</span></div><div class="'+col+' '+reason_text+'">'+ short_reason_text
   +'</div><div class="col-2 set_to_archive_container"><input type="checkbox" class="set_to_archive" '+status+'></div></div>';
   $('#list_content').prepend(update_string);
   // привязываем событие клик новой строке
   $('#list_content').on('click', '.ftt_extra_help_string', function () {
     if ($(this).attr("data-archive") === '1') {
       $('#modalUniTitle').text('Доп. задание (выполнено)');
       $("#archive_checkbox_field").prop('checked', true);
     } else {
       $('#modalUniTitle').text('Доп. задание (текущее)');
       $("#archive_checkbox_field").prop('checked', false);
     }
     // attr
     $("#modalAddEditExtraHelp").attr("data-archive_date", $(this).attr("data-archived"));
     $("#modalAddEditExtraHelp").attr("data-id", $(this).attr("data-id"));
     $("#modalAddEditExtraHelp").attr("data-serving_one", $(this).attr("data-service_one_id"));
     $("#modalAddEditExtraHelp").attr("data-trainee_id", $(this).attr("data-trainee_id"));
     $("#modalAddEditExtraHelp").attr("data-author", $(this).attr("data-author"));
     $("#modalAddEditExtraHelp").attr("data-reason", $(this).attr("data-reason"));
     $("#modalAddEditExtraHelp").attr("data-comment", $(this).attr("data-comment"));
     $("#modalAddEditExtraHelp").attr("data-date", $(this).attr("data-date"));
     $("#modalAddEditExtraHelp").attr("data-archive", $(this).attr("data-archive"));

     // fields
     $("#modalAddEditExtraHelp #fio_field").val($(this).attr("data-trainee_id"));
     $("#modalAddEditExtraHelp #reason_field").val($(this).attr("data-reason"));

     let male_word = ' ' , create_word = "Создал";
     let servise_one_author, servise_one_archivator;
     if ($(this).attr("data-author")) {
        if (serving_ones_list_full[$(this).attr("data-author")]) {
         if (serving_ones_list_full[$(this).attr("data-author")]['male'] !== '1') {
            male_word = 'а ';
          }
        }
        if (serving_ones_list_full[$(this).attr("data-author")]) {
          if (serving_ones_list_full[$(this).attr("data-author")]['name']) {
            servise_one_author = serving_ones_list_full[$(this).attr("data-author")]['name'];
          } else {
            servise_one_author = trainee_list_full[$(this).attr("data-author")]['name'];
          }
        }
      } else {
        create_word = "Создано ";
        servise_one_author = "автоматически";
      }

     let text = create_word + male_word + ' ' + servise_one_author;
     $('#author_of_extrahelp').text(text);
     male_word = ' ';
     if (serving_ones_list_full[$(this).attr("data-service_one_archived_id")]['male'] !== '1') {
       male_word = 'а ';
     }
     if ($(this).attr("data-archive") === '1') {
       if (serving_ones_list_full[$(this).attr("data-service_one_archived_id")]['name']) {
         servise_one_archivator = serving_ones_list_full[$(this).attr("data-service_one_archived_id")]['name'];
       } else {
         servise_one_archivator = trainee_list_full[$(this).attr("data-service_one_archived_id")]['name'];
       }
       let text2 = ', закрыл' + male_word + ' ' + servise_one_archivator;
       $('#archivator_of_extrahelp').text(text2);
     }

     $("#modalAddEditExtraHelp #comment_field").val($(this).attr("data-comment"));
     $("#modalAddEditExtraHelp #date_closed_field").val($(this).attr("data-archived"));
     $("#modalAddEditExtraHelp #date_field").val($(this).attr("data-date"));
     if ($(this).attr("data-service_one_archived_id")) {
       $("#modalAddEditExtraHelp #service_one_field").val($(this).attr("data-service_one_archived_id"));
     } else {
       $("#modalAddEditExtraHelp #service_one_field").val("_none_");
     }

     if (serving_ones_list[$(this).attr("data-author")]) {
       $("#modalAddEditExtraHelp #author_field").val($(this).attr("data-author"));
     } else if (trainee_list[$(this).attr("data-author")]) {
       $("#modalAddEditExtraHelp #author_field").val($(this).attr("data-author"));
     }
   });

   // привязываем статус
   $('#list_content').on('click','.set_to_archive', function (e) {
     e.stopPropagation();
     if (ftt_access_trainee || trainee_access) {
      showError("Ошибка. Не достаточно прав.");
      return;
     }
     let archive = 1;
     if ($(this).hasClass('badge-success')) {
       archive = 0;
     }

     let this_string = $(this);
     fetch('ajax/ftt_extra_help_ajax.php?type=set_extra_help_done&id=' + $(this).parent().parent().attr('data-id')+'&archive='+archive)
     .then(response => response.text())
     .then(commits => {
       if (archive === 1) {
         $(this_string).addClass('green_string');
         $(this_string).parent().parent().attr('data-archive', 1);
         $(this_string).parent().parent().attr('data-service_one_archived_id', admin_id_gl);
         $(this_string).parent().parent().attr('data-archived', date_now_gl);
         $(this_string).parent().parent().hide();
       } else {
         $(this_string).removeClass('green_string');
         $(this_string).parent().parent().attr('data-archive', '0');
         $(this_string).parent().parent().attr('data-service_one_archived_id', '');
         $(this_string).parent().parent().attr('data-archived', '');
       }
     });
   });
 }
 }

// save data
function save_extra_help_data() {
  let data = get_data_fields();
  if ($("#modalAddEditExtraHelp").attr("data-id")) {
    // update
    fetch('ajax/ftt_extra_help_ajax.php?type=update_extra_help', {
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(commits => {
      dinamic_add_string(commits.result, true);
      clear_blank();
    });
  } else {
    // добавить новый
    fetch('ajax/ftt_extra_help_ajax.php?type=add_extra_help', {
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(commits => {
      dinamic_add_string(commits.result);
      clear_blank();
    });
  }
}

$('#fio_field, #date_field, #reason_field, #comment_field').change(function () {
  if ($(this).css('border-color') === 'rgb(255, 0, 0)') {
    $(this).css('border-color', 'lightgray');
  }
});

$('#modalAddEditExtraHelp .close').click(function (e) {
  if ($("#save_extra_help").prop("disabled")) {
    clear_blank();
    return;
  }
  if ($("#modalAddEditExtraHelp").attr("data-archive") === "1" && $("#archive_checkbox_field").prop("checked")) {
    clear_blank();
    return;
  }
  let checked_check = "0";
  if ($("#archive_checkbox_field").prop("checked")) {
    checked_check = "1";
  }

  if (!$('#modalAddEditExtraHelp').attr('data-id') && $("#fio_field").val() === '_none_' && checked_check === "0" && !$("#reason_field").val() && !$("#comment_field").val() && ($('#modalAddEditExtraHelp').attr('data-date') === $("#date_field").val())) {
    clear_blank();
    return;
  }

  if ($('#modalAddEditExtraHelp').attr('data-reason') !== $("#reason_field").val() || $('#modalAddEditExtraHelp').attr('data-comment') !== $("#comment_field").val() || $('#modalAddEditExtraHelp').attr('data-date') !== $("#date_field").val() || ($('#modalAddEditExtraHelp').attr('data-trainee_id') !== $("#fio_field").val() && $("#fio_field").val() !== '_none_') || $('#modalAddEditExtraHelp').attr('data-archive') !== checked_check) {
    if (confirm('Сохранить изменения?')) {
      if (validation_fields(e)) {
        if (!$('#modalAddEditExtraHelp').attr('data-author')) {
          $('#modalAddEditExtraHelp').attr('data-author', admin_id_gl);
        }
        save_extra_help_data();
        return;
      } else {
        return;
      }
    }
  }
  clear_blank();
});

$('#modalAddEditExtraHelp .btn-secondary').click(function (e) {
  if ($("#save_extra_help").prop("disabled")) {
    clear_blank();
    return;
  }
  let checked_check = "0";
  if ($("#archive_checkbox_field").prop("checked")) {
    checked_check = "1";
  }

  if (!$('#modalAddEditExtraHelp').attr('data-id') && $("#fio_field").val() === '_none_' && checked_check === "0" && !$("#reason_field").val() && !$("#comment_field").val() && ($('#modalAddEditExtraHelp').attr('data-date') === $("#date_field").val())) {
    clear_blank();
    return;
  }

  if ($('#modalAddEditExtraHelp').attr('data-reason') !== $("#reason_field").val() || $('#modalAddEditExtraHelp').attr('data-comment') !== $("#comment_field").val() || $('#modalAddEditExtraHelp').attr('data-date') !== $("#date_field").val() || ($('#modalAddEditExtraHelp').attr('data-trainee_id') !== $("#fio_field").val() && $("#fio_field").val() !== '_none_') || $('#modalAddEditExtraHelp').attr('data-archive') !== checked_check) {
    if (confirm('Сохранить изменения?')) {
      if (validation_fields(e)) {
        if (!$('#modalAddEditExtraHelp').attr('data-author')) {
          $('#modalAddEditExtraHelp').attr('data-author', admin_id_gl);
        }
        save_extra_help_data();
        return;
      } else {
        return;
      }
    }
  }
  clear_blank();
});

// открыть бланк для добавления правки дап задания
$('#showModalAddEditExtraHelp').click(function () {
  if (trainee_access) {
    $("#modalAddEditExtraHelp #fio_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #reason_field").attr('disabled', false);
    $("#archive_checkbox_field").attr('disabled', true);
    $("#modalAddEditExtraHelp #date_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #save_extra_help").attr('disabled', false);
  } else {
    $("#modalAddEditExtraHelp #fio_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #reason_field").attr('disabled', false);
    $("#archive_checkbox_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #date_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #save_extra_help").attr('disabled', false);
  }
  $('#modalUniTitle').text('Доп. задание (новое)');
  $('#date_field').val(date_now_gl);
  $('#author_field').val(admin_id_gl);
  $('#modalAddEditExtraHelp').attr('data-date', date_now_gl);
  $('#modalAddEditExtraHelp').attr('data-author', admin_id_gl);
  $('#info_of_extrahelp').hide();
});

// удалить доп задание
$('#modalAddEditExtraHelp .btn-danger').click(function () {
  if (!$('#modalAddEditExtraHelp').attr('data-id')) {
    showError('Бланк не сохранён. Его нельзя удалить.');
    return;
  }
  if (confirm('Удалить доп. задание?')) {
    fetch('ajax/ftt_extra_help_ajax.php?type=delete_extra_help&id='+ $('#modalAddEditExtraHelp').attr('data-id'))
    .then(response => response.json())
    .then(commits => {
      $('.ftt_extra_help_string[data-id='+$('#modalAddEditExtraHelp').attr('data-id')+']').slideUp(300).removeClass('ftt_extra_help_string').hide();
      clear_blank();
    });
  }
});

// Помечаем как выполненное
$(".set_to_archive").click(function (e) {
  e.stopPropagation();
  if (ftt_access_trainee || trainee_access) {
    if (e.target.checked) {
      $(this).prop("checked", false);
    } else {
      $(this).prop("checked", true);
    }
   showError("Ошибка. Не достаточно прав.");
   return;
  }
  let archive = 1;
  if (!e.target.checked) {
    archive = 0;
  }

  let this_string = $(this);
  fetch('ajax/ftt_extra_help_ajax.php?type=set_extra_help_done&id=' + $(this).parent().parent().attr('data-id')+'&archive='+archive)
  .then(response => response.text())
  .then(commits => {
    if (archive === 1) {
      $(this_string).parent().parent().addClass('green_string');
      $(this_string).parent().parent().attr('data-archive', 1);
      $(this_string).parent().parent().attr('data-service_one_archived_id', admin_id_gl);
      $(this_string).parent().parent().attr('data-archived', date_now_gl);
      if ($('#tasks_select').val() !== '_all_') {
        $(this_string).parent().parent().slideUp(300);//.hide()
      }
    } else {
      $(this_string).parent().parent().removeClass('green_string');
      $(this_string).parent().parent().attr('data-archive', '0');
      $(this_string).parent().parent().attr('data-service_one_archived_id', '');
      $(this_string).parent().parent().attr('data-archived', '');
    }
  });
});

// save
$('#save_extra_help').click(function (e) {
  if (trainee_access && $("#modalAddEditExtraHelp").attr("data-author") !== admin_id_gl) {
    showError('Нельзя сохранить.');
    return;
  }
  // валидация значений полей
  if ($('#modalAddEditExtraHelp #fio_field').val() === '_none_') {
    e.stopPropagation();
    e.preventDefault();
    showError('Заполните поля выделенные красной рамкой.');
    $('#modalAddEditExtraHelp #fio_field').css('border-color', 'red');
    if ($('#modalAddEditExtraHelp #date_field').val() === '') {
      $('#modalAddEditExtraHelp #date_field').css('border-color', 'red');
    }
    if ($('#modalAddEditExtraHelp #reason_field').val() === '') {
      $('#modalAddEditExtraHelp #reason_field').css('border-color', 'red');
    }
    return;
  } else {
    $('#modalAddEditExtraHelp #fio_field').css('border-color', 'lightgray');
  }

  if ($('#modalAddEditExtraHelp #date_field').val() === '') {
    e.stopPropagation();
    e.preventDefault();
    $('#modalAddEditExtraHelp #date_field').css('border-color', 'red');
    if ($('#modalAddEditExtraHelp #reason_field').val() === '') {
      $('#modalAddEditExtraHelp #reason_field').css('border-color', 'red');
    }
    return;
  } else {
    $('#modalAddEditExtraHelp #date_field').css('border-color', 'lightgray');
  }

  if ($('#modalAddEditExtraHelp #reason_field').val() === '') {
    e.stopPropagation();
    e.preventDefault();
    $('#modalAddEditExtraHelp #reason_field').css('border-color', 'red');
    return;
  } else {
    $('#modalAddEditExtraHelp #reason_field').css('border-color', 'lightgray');
  }

  save_extra_help_data();

});

// клик по строкке, загружаем форму
$(".ftt_extra_help_string").click(function () {
  if (trainee_access && $(this).attr("data-author") !== admin_id_gl) {
    $("#modalAddEditExtraHelp #fio_field").attr('disabled', true);
    $("#modalAddEditExtraHelp #reason_field").attr('disabled', true);
    $("#archive_checkbox_field").attr('disabled', true);
    $("#modalAddEditExtraHelp #date_field").attr('disabled', true);
    $("#modalAddEditExtraHelp #save_extra_help").attr('disabled', true);
  } else {
    $("#modalAddEditExtraHelp #fio_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #reason_field").attr('disabled', false);
    $("#archive_checkbox_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #date_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #save_extra_help").attr('disabled', false);
  }
  if ($(this).attr("data-archive") === '1') {
    $('#modalUniTitle').text('Доп. задание (выполнено)');
    $("#archive_checkbox_field").prop('checked', true);
  } else {
    $('#modalUniTitle').text('Доп. задание (текущее)');
    $("#archive_checkbox_field").prop('checked', false);
  }
  // attr
  $("#modalAddEditExtraHelp").attr("data-archive_date", $(this).attr("data-archived"));
  $("#modalAddEditExtraHelp").attr("data-id", $(this).attr("data-id"));
  $("#modalAddEditExtraHelp").attr("data-serving_one", $(this).attr("data-service_one_id"));
  $("#modalAddEditExtraHelp").attr("data-trainee_id", $(this).attr("data-trainee_id"));
  $("#modalAddEditExtraHelp").attr("data-author", $(this).attr("data-author"));
  $("#modalAddEditExtraHelp").attr("data-reason", $(this).attr("data-reason"));
  $("#modalAddEditExtraHelp").attr("data-comment", $(this).attr("data-comment"));
  $("#modalAddEditExtraHelp").attr("data-date", $(this).attr("data-date"));
  $("#modalAddEditExtraHelp").attr("data-archive", $(this).attr("data-archive"));

  // fields
  $("#modalAddEditExtraHelp #fio_field").val($(this).attr("data-trainee_id"));
  $("#modalAddEditExtraHelp #reason_field").val($(this).attr("data-reason"));
  let male_word = ' ', create_word = 'Создал';
  let servise_one_author, servise_one_archivator;
  if ($(this).attr("data-author")) {
    if (serving_ones_list_full[$(this).attr("data-author")]) {
      if (serving_ones_list_full[$(this).attr("data-author")]['male'] !== '1') {
        male_word = 'а ';
      }
    } else if (trainee_list_full[$(this).attr("data-author")]) {
      if (trainee_list_full[$(this).attr("data-author")]['male'] !== '1') {
        male_word = 'а ';
      }
    }

    if (serving_ones_list_full[$(this).attr("data-author")]) {
      servise_one_author = serving_ones_list_full[$(this).attr("data-author")]['name'];
    } else {
      servise_one_author = trainee_list[$(this).attr("data-author")];
    }
  } else {
    create_word = "Создано";
    servise_one_author = "Автоматически";
  }
  let text = create_word + male_word + ' ' + servise_one_author;
  $('#author_of_extrahelp').text(text);

  if ($(this).attr("data-archive") === '1') {
    if (serving_ones_list_full[$(this).attr("data-service_one_archived_id")]['name']) {
      servise_one_archivator = serving_ones_list_full[$(this).attr("data-service_one_archived_id")]['name'];
    } else {
      servise_one_archivator = trainee_list_full[$(this).attr("data-service_one_archived_id")]['name'];
    }
    let text2 = ', закрыл' + male_word + ' ' + servise_one_archivator + ' ' + $(this).attr("data-archived");
    $('#archivator_of_extrahelp').text(text2);
  }


  $("#modalAddEditExtraHelp #comment_field").val($(this).attr("data-comment"));
  $("#modalAddEditExtraHelp #date_closed_field").val($(this).attr("data-archived"));
  $("#modalAddEditExtraHelp #date_field").val($(this).attr("data-date"));
  if ($(this).attr("data-service_one_archived_id")) {
    $("#modalAddEditExtraHelp #service_one_field").val($(this).attr("data-service_one_archived_id"));
  } else {
    $("#modalAddEditExtraHelp #service_one_field").val("_none_");
  }

  if (serving_ones_list[$(this).attr("data-author")]) {
    $("#modalAddEditExtraHelp #author_field").val($(this).attr("data-author"));
  } else if (trainee_list[$(this).attr("data-author")]) {
    $("#modalAddEditExtraHelp #author_field").val($(this).attr("data-author"));
  }
});

// фильтры
function filters_apply() {
  if ($("#semesters_select").val()) {
    $('.ftt_extra_help_string').each(function() {
      if (($('#tasks_select').val() === $(this).attr('data-archive') || $('#tasks_select').val() === '_all_') &&
        ($('#semesters_select').val() === $(this).attr('data-semester') || $('#semesters_select').val() === '_all_') &&
        ($('#trainee_select').val() === $(this).attr('data-trainee_id') || $('#trainee_select').val() === '_all_') &&
        ($('#sevice_one_select').val() === $(this).attr('data-service_one_id') || $('#sevice_one_select').val() === '_all_')) {
          if ($('#sevice_one_select').val() === '_all_') {
            if ($(window).width()>769) {
              $(this).find('.serving_one_name').show();
            }
          } else {
            $(this).find('.serving_one_name').hide();
          }
          $(this).show();
        } else {
          $(this).hide();
        }
    });
  } else {
    $('.ftt_extra_help_string').each(function() {
      if ($('#tasks_select').val() === $(this).attr('data-archive') || $('#tasks_select').val() === '_all_') {
          if ($('#sevice_one_select').val() === '_all_') {
            if ($(window).width()>769) {
              $(this).find('.serving_one_name').show();
            }
          } else {
            $(this).find('.serving_one_name').hide();
          }
          $(this).show();
        } else {
          $(this).hide();
        }
    });
  }
  filters_list_show();
}

filters_apply();

$('#tasks_select, #semesters_select, #sevice_one_select, #trainee_select').change(function (e) {
  setCookie(e.target.id, $(this).val(), 356);
  if ($("#semesters_select").val()) {
    $('.ftt_extra_help_string').each(function() {
      if (($('#tasks_select').val() === $(this).attr('data-archive') || $('#tasks_select').val() === '_all_') &&
        ($('#semesters_select').val() === $(this).attr('data-semester') || $('#semesters_select').val() === '_all_') &&
        ($('#trainee_select').val() === $(this).attr('data-trainee_id') || $('#trainee_select').val() === '_all_') &&
        ($('#sevice_one_select').val() === $(this).attr('data-service_one_id') || $('#sevice_one_select').val() === '_all_')) {
          if ($('#sevice_one_select').val() === '_all_') {
            if ($(window).width()>769) {
              $(this).find('.serving_one_name').show();
            }
          } else {
            $(this).find('.serving_one_name').hide();
          }
          $(this).show();
        } else {
          $(this).hide();
        }
    });
  } else {
    $('.ftt_extra_help_string').each(function() {
      if ($('#tasks_select').val() === $(this).attr('data-archive') || $('#tasks_select').val() === '_all_') {
          if ($('#sevice_one_select').val() === '_all_') {
            if ($(window).width()>769) {
              $(this).find('.serving_one_name').show();
            }
          } else {
            $(this).find('.serving_one_name').hide();
          }
          $(this).show();
        } else {
          $(this).hide();
        }
    });
  }
  filters_list_show();
});

// фильтры
$('#tasks_select_mbl, #semesters_select_mbl, #sevice_one_select_mbl, #trainee_select_mbl').change(function (e) {
  setCookie(e.target.id.slice(0, -4), $(this).val(), 356);
  if ($("#semesters_select_mbl").val()) {
    $('.ftt_extra_help_string').each(function() {
      if (($('#tasks_select_mbl').val() === $(this).attr('data-archive') || $('#tasks_select_mbl').val() === '_all_') &&
        ($('#semesters_select_mbl').val() === $(this).attr('data-semester') || $('#semesters_select_mbl').val() === '_all_') &&
        ($('#trainee_select_mbl').val() === $(this).attr('data-trainee_id') || $('#trainee_select_mbl').val() === '_all_') &&
        ($('#sevice_one_select_mbl').val() === $(this).attr('data-service_one_id') || $('#sevice_one_select_mbl').val() === '_all_')) {
          if ($('#sevice_one_select_mbl').val() === '_all_') {
            if ($(window).width()>769) {
              $(this).find('.serving_one_name').show();
            }
          } else {
            $(this).find('.serving_one_name').hide();
          }
          $(this).show();
        } else {
          $(this).hide();
        }
    });
  } else {
    $('.ftt_extra_help_string').each(function() {
      if ($('#tasks_select_mbl').val() === $(this).attr('data-archive') || $('#tasks_select_mbl').val() === '_all_') {
          if ($('#sevice_one_select_mbl').val() === '_all_') {
            if ($(window).width()>769) {
              $(this).find('.serving_one_name').show();
            }
          } else {
            $(this).find('.serving_one_name').hide();
          }
          $(this).show();
        } else {
          $(this).hide();
        }
    });
  }
  filters_list_show();
});

// список применённых фильтров
function filters_list_show() {
  let filters_text;
  if ($(window).width()<=769) {
    if ($("#sevice_one_select_mbl").val()) {
      filters_text = "Фильтры: " + $("#trainee_select_mbl option:selected").text() + ", " + $("#semesters_select_mbl option:selected").text() + ", " + $("#sevice_one_select_mbl option:selected").text() + ", " + $("#tasks_select_mbl option:selected").text();
    } else {
      filters_text = "Фильтры: " + $("#tasks_select_mbl option:selected").text();
    }
  } else {
    if ($("#sevice_one_select").val()) {
      filters_text = "Фильтры: " + $("#trainee_select option:selected").text() + ", " + $("#semesters_select option:selected").text() + ", " + $("#sevice_one_select option:selected").text() + ", " + $("#tasks_select option:selected").text();
    } else {
      filters_text = "Фильтры: " + $("#tasks_select option:selected").text();
    }
  }
  $("#filters_list").text(filters_text);
}
filters_list_show();

$("#info_of_extrahelp").click(function () {
  if ($("#date_of_archive").is(":visible")) {
    $("#date_of_archive").parent().hide();
  } else {
    $("#date_of_archive").parent().show();
  }
});
  $("#archive_checkbox_field").change(function (e) {
    if (ftt_access_trainee || trainee_access) {
      if (e.target.checked) {
        $(this).prop("checked", false);
      } else {
        $(this).prop("checked", true);
      }
      showError("Ошибка. Не достаточно прав.");
      return;
    } else {
      if (e.target.checked) {
        $("#archivator_of_extrahelp").show();
      } else {
        $("#archivator_of_extrahelp").hide();
      }
    }
  });

  function rendering_report_extra_help() {
    fetch("ajax/ftt_extra_help_ajax.php?type=get_print_report&service_one_key="+$("#sevice_one_print_report").val())
    .then(response => response.json())
    .then(commits => {
      let result = commits.result;
      let html = "<h3 class='hide_element'>Статистика доп. заданий</h3><p class='hide_element'> Служащий: "+$("#sevice_one_print_report option:selected").text()
      +"</p><table class='table'><thead><tr><th style='text-align: left;'><b>Обучающийся</b></th><th style='text-align: right;'><b>Доп. заданий</b></th></tr><thead><tbody>";
      for (let variable in result) {
        if (result.hasOwnProperty(variable) && variable !== "count") {
          let count_e_h = "";
          if (result[variable] > 0) {
            count_e_h = result[variable];
          }
          html = html + "<tr><td style='width: 250px; text-align: left;'>"+ trainee_list[variable] +"</td><td style='text-align: right;'>"+ count_e_h +"</td></tr>";
        }
      }
      html += "<tr><td style='width: 250px; text-align: left;'>Всего</td><td style='text-align: right;'>"+ result["count"] +"</td></tr></tbody></table>";
      $("#modalShortStatisticsTbl").html(html);
    });
  }

  $("#showModalShortStatistics").click(function () {
    $("#sevice_one_print_report").val($("#sevice_one_select").val());
    rendering_report_extra_help();
  });

  $("#sevice_one_print_report").change(function () {
    rendering_report_extra_help();
  });

  $("#btn_print_report").click(function () {

    function printElem(elem){
      popup($(elem).html());
    }
//th {border-bottom: 1px solid black; text-align: center; border-collapse: separate;}
    function popup(data){
      let mywindow = window.open('', 'Благовестие', 'height=600,width=800');
      mywindow.document.write('<html><head><title>Доп. задания. Для отправки на принтер нажмите Ctrl+P.</title>');
      mywindow.document.write('</head><body><style> td {border-bottom: 1px solid black; text-align: right;} th {border-bottom: 1px solid black; text-align: center;}</style>');
      mywindow.document.write(data);
      mywindow.document.write('</body></html>');
      //mywindow.print();
      //mywindow.close();
      //return true;
    }
    printElem("#modalShortStatisticsTbl");
  });

/* ==== MAIN & EXTRA HELP STOP ==== */
/* ==== LATE START ==== */

// Помечаем как учтённое
$(".set_to_done").click(function (e) {
  e.stopPropagation();
  if (ftt_access_trainee || trainee_access) {
    if (e.target.checked) {
      $(this).prop("checked", false);
    } else {
      $(this).prop("checked", true);
    }
   showError("Ошибка. Не достаточно прав.");
   return;
  }
  let done = 1;
  if (!e.target.checked) {
    done = 0;
  }

  let this_string = $(this);
  fetch('ajax/ftt_extra_help_ajax.php?type=set_late_done&id=' + $(this).parent().parent().attr('data-id')+'&done='+done)
  .then(response => response.text())
  .then(commits => {
    if (done === 1) {
      $(this_string).parent().parent().addClass('green_string');
      $(this_string).parent().parent().attr('data-archive', 1);
      if ($('#tasks_select_late').val() !== '_all_') {
        $(this_string).parent().parent().slideUp(300);//.hide()
      }
    } else {
      $(this_string).parent().parent().removeClass('green_string');
      $(this_string).parent().parent().attr('data-archive', '0');
    }
  });
});

// получить данные полей формы late
function get_data_fields_late() {
 data = new FormData();
 data.append('id', $("#modalAddEditLate").attr('data-id'));
 data.append('date', $("#modalAddEditLate #date_field_late").val());
 data.append('member_key', $("#modalAddEditLate #fio_field_late").val());
 data.append('session_name', $("#modalAddEditLate #session_name_field").val());

 if ($("#done_checkbox_field").prop("checked")) {

  /*if ($("#modalAddEditLate").attr('data-archive') !== 1) {
    //data.append('serving_one', admin_id_gl);
  } else {
    //data.append('serving_one', $('#modalAddEditLate').attr('data-service_one_archived_id'));
  }*/
  data.append('done', 1);
} else {
  //data.append('serving_one', '');
  data.append('done', 0);
}
 data.append('author', $("#modalAddEditLate").attr("data-author"));
 data.append('delay', $("#modalAddEditLate #minutes_field").val());
 //data.append('archive_date', $("#modalAddEditLate #date_closed_field").val());

 return data;
}

// save data late
function save_late_data() {
  let data = get_data_fields_late();
  if ($("#modalAddEditLate").attr("data-id")) {
    // update
    fetch('ajax/ftt_extra_help_ajax.php?type=update_late', {
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(commits => {
      dinamic_add_string_late(commits.result, true);
      clear_blank();
    });
  } else {
    // добавить новый
    fetch('ajax/ftt_extra_help_ajax.php?type=add_late', {
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(commits => {
      dinamic_add_string_late(commits.result);
      clear_blank();
    });
  }
}

// check
$('#modalAddEditLate .close').click(function (e) {
  let checked_check = "0";
  if ($("#done_checkbox_field").prop("checked")) {
    checked_check = "1";
  }
  if (!$('#modalAddEditLate').attr('data-id') && $("#fio_field_late").val() === '_none_' && checked_check === "0" && !$("#session_name_field").val() && !$("#minutes_field").val() && ($('#modalAddEditLate').attr('data-date') === $("#date_field_late").val())) {
    return;
    clear_blank();
  }

  if ($('#modalAddEditLate').attr('data-reason') !== $("#session_name_field").val() || $('#modalAddEditLate').attr('data-comment') !== $("#minutes_field").val() || $('#modalAddEditLate').attr('data-date') !== $("#date_field_late").val() || ($('#modalAddEditLate').attr('data-trainee_id') !== $("#fio_field_late").val() && $("#fio_field_late").val() !== '_none_') || $('#modalAddEditLate').attr('data-archive') !== checked_check) {
    if (confirm('Сохранить изменения?')) {
      if (validation_fields(e)) {
        if (!$('#modalAddEditLate').attr('data-author')) {
          $('#modalAddEditLate').attr('data-author', admin_id_gl);
        }
        save_late_data();
        return;
      } else {
        return;
      }
    }
  }
  clear_blank();
});

// check 2
$('#modalAddEditLate .btn-secondary').click(function (e) {
  if ($("#modalAddEditExtraHelp").attr("data-archive") === "1" && $("#archive_checkbox_field").prop("checked")) {
    clear_blank();
    return;
  }
  let checked_check = "0";
  if ($("#done_checkbox_field").prop("checked")) {
    checked_check = "1";
  }

  if (!$('#modalAddEditLate').attr('data-id') && $("#fio_field_late").val() === '_none_' && checked_check === "0" && !$("#session_name_field").val() && !$("#minutes_field").val() && ($('#modalAddEditLate').attr('data-date') === $("#date_field_late").val())) {
    return;
    clear_blank();
  }

  if ($('#modalAddEditLate').attr('data-reason') !== $("#session_name_field").val() || $('#modalAddEditLate').attr('data-comment') !== $("#minutes_field").val() || $('#modalAddEditLate').attr('data-date') !== $("#date_field_late").val() || ($('#modalAddEditLate').attr('data-trainee_id') !== $("#fio_field_late").val() && $("#fio_field_late").val() !== '_none_') || $('#modalAddEditLate').attr('data-archive') !== checked_check) {
    if (confirm('Сохранить изменения?')) {
      if (validation_fields(e)) {
        if (!$('#modalAddEditLate').attr('data-author')) {
          $('#modalAddEditLate').attr('data-author', admin_id_gl);
        }
        save_late_data();
        return;
      } else {
        return;
      }
    }
  }
  clear_blank();
});

// save
$('#save_late').click(function (e) {
  if (trainee_access && $("#modalAddEditLate").attr("data-author") !== admin_id_gl) {
    showError('Нельзя сохранить.');
    return;
  }
  // валидация значений полей
  if ($('#modalAddEditLate #fio_field_late').val() === '_none_') {
    e.stopPropagation();
    e.preventDefault();
    showError('Заполните поля выделенные красной рамкой.');
    $('#modalAddEditLate #fio_field_late').css('border-color', 'red');
    if ($('#modalAddEditLate #date_field_late').val() === '') {
      $('#modalAddEditLate #date_field_late').css('border-color', 'red');
    }
    if ($('#modalAddEditLate #session_name_field').val() === '') {
      $('#modalAddEditLate #session_name_field').css('border-color', 'red');
    }
    return;
  } else {
    $('#modalAddEditLate #fio_field_late').css('border-color', 'lightgray');
  }

  if ($('#modalAddEditLate #date_field_late').val() === '') {
    e.stopPropagation();
    e.preventDefault();
    $('#modalAddEditLate #date_field_late').css('border-color', 'red');
    if ($('#modalAddEditLate #session_name_field').val() === '') {
      $('#modalAddEditLate #session_name_field').css('border-color', 'red');
    }
    return;
  } else {
    $('#modalAddEditLate #date_field_late').css('border-color', 'lightgray');
  }
  // session_name
  if ($('#modalAddEditLate #session_name_field').val() === '') {
    e.stopPropagation();
    e.preventDefault();
    $('#modalAddEditLate #session_name_field').css('border-color', 'red');
    return;
  } else {
    $('#modalAddEditLate #session_name_field').css('border-color', 'lightgray');
  }

  // minutes
  if ($('#modalAddEditLate #minutes_field').val() === '') {
    e.stopPropagation();
    e.preventDefault();
    $('#modalAddEditLate #minutes_field').css('border-color', 'red');
    return false;
  } else {
    $('#modalAddEditLate #minutes_field').css('border-color', 'lightgray');
  }
  save_late_data();
});

// filters
$('#trainee_select_late, #semesters_select_late, #sevice_one_select_late, #tasks_select_late').change(function (e) {
  $('.ftt_late_string').each(function() {
    if (($('#tasks_select_late').val() === $(this).attr('data-archive') || $('#tasks_select_late').val() === '_all_') &&
     ($('#semesters_select_late').val() === $(this).attr('data-semester') || $('#semesters_select_late').val() === '_all_') &&
      ($('#trainee_select_late').val() === $(this).attr('data-trainee_id') || $('#trainee_select_late').val() === '_all_') &&
    ($('#sevice_one_select_late').val() === $(this).attr('data-service_one_id') || $('#sevice_one_select_late').val() === '_all_')) {
      if ($('#sevice_one_select_late').val() === '_all_') {
        if ($(window).width()>769) {
          $(this).find('.serving_one_name').show();
        }
      } else {
        $(this).find('.serving_one_name').hide();
      }
      $(this).show();
    } else {
      $(this).hide();
    }
  });
  filters_list_show_late();
});

// filters mbl
$('#trainee_select_late_mbl, #semesters_select_late_mbl, #sevice_one_select_late_mbl, #tasks_select_late_mbl').change(function (e) {
  $('.ftt_late_string').each(function() {
    if (($('#tasks_select_late_mbl').val() === $(this).attr('data-archive') || $('#tasks_select_late_mbl').val() === '_all_') &&
     ($('#semesters_select_late_mbl').val() === $(this).attr('data-semester') || $('#semesters_select_late_mbl').val() === '_all_') &&
      ($('#trainee_select_late_mbl').val() === $(this).attr('data-trainee_id') || $('#trainee_select_late_mbl').val() === '_all_') &&
    ($('#sevice_one_select_late_mbl').val() === $(this).attr('data-service_one_id') || $('#sevice_one_select_late_mbl').val() === '_all_')) {
      if ($('#sevice_one_select_late_mbl').val() === '_all_') {
        if ($(window).width()>769) {
          $(this).find('.serving_one_name').show();
        }
      } else {
        $(this).find('.serving_one_name').hide();
      }
      $(this).show();
    } else {
      $(this).hide();
    }
  });
  filters_list_show_late();
});

// список применённых фильтров для ОПОЗДАНИЙ
function filters_list_show_late() {
  let filters_text;
  if ($(window).width()<=769) {
    if ($("#sevice_one_select_late_mbl").val()) {
      filters_text = "Фильтры: " + $("#trainee_select_late_mbl option:selected").text() + ", " + $("#semesters_select_late_mbl option:selected").text() + ", " + $("#sevice_one_select_late_mbl option:selected").text() + ", " + $("#tasks_select_late_mbl option:selected").text();
    } else {
      filters_text = "Фильтры: " + $("#tasks_select_late_mbl option:selected").text();
    }
  } else {
    if ($("#sevice_one_select_late").val()) {
      filters_text = "Фильтры: " + $("#trainee_select_late option:selected").text() + ", " + $("#semesters_select_late option:selected").text() + ", " + $("#sevice_one_select_late option:selected").text() + ", " + $("#tasks_select_late option:selected").text();
    } else {
      filters_text = "Фильтры: " + $("#tasks_select_late option:selected").text();
    }
  }
  $("#filters_list_late").text(filters_text);
}
filters_list_show_late();

// delete_late
// удалить доп задание
$('#modalAddEditLate .btn-danger').click(function () {
  if (!$('#modalAddEditLate').attr('data-id')) {
    showError('Бланк не сохранён. Его нельзя удалить.');
    return;
  }
  if (confirm('Удалить доп. задание?')) {
    fetch('ajax/ftt_extra_help_ajax.php?type=delete_late&id='+ $('#modalAddEditLate').attr('data-id'))
    .then(response => response.json())
    .then(commits => {
      $('.ftt_late_string[data-id='+$('#modalAddEditLate').attr('data-id')+']').slideUp(300).removeClass('ftt_late_string').hide();
      clear_blank();
    });
  }
});

// клик по строкке LATE, загружаем форму
$(".ftt_late_string").click(function () {
  if (trainee_access && $(this).attr("data-author") !== admin_id_gl) {
    $("#modalAddEditLate #fio_field_late").attr('disabled', true);
    $("#modalAddEditLate #session_name_field").attr('disabled', true);
    $("#done_checkbox_field").attr('disabled', true);
    $("#modalAddEditLate #date_field_late").attr('disabled', true);
    $("#modalAddEditLate #save_late").attr('disabled', true);
  } else {
    $("#modalAddEditLate #fio_field_late").attr('disabled', false);
    $("#modalAddEditLate #session_name_field").attr('disabled', false);
    $("#done_checkbox_field").attr('disabled', false);
    $("#modalAddEditLate #date_field_late").attr('disabled', false);
    $("#modalAddEditLate #save_late").attr('disabled', false);
  }
  if ($(this).attr("data-archive") === '1') {
    $('#modalUniTitle_late').text('Опоздание (учтено)');
    $("#done_checkbox_field").prop('checked', true);
  } else {
    $('#modalUniTitle_late').text('Опоздание (текущее)');
    $("#done_checkbox_field").prop('checked', false);
  }

  // attr
  //$("#modalAddEditLate").attr("data-archive_date", $(this).attr("data-archived"));
  $("#modalAddEditLate").attr("data-id", $(this).attr("data-id"));
  $("#modalAddEditLate").attr("data-serving_one", $(this).attr("data-service_one_id"));
  $("#modalAddEditLate").attr("data-trainee_id", $(this).attr("data-trainee_id"));
  $("#modalAddEditLate").attr("data-author", $(this).attr("data-author"));
  $("#modalAddEditLate").attr("data-reason", $(this).attr("data-reason"));
  $("#modalAddEditLate").attr("data-comment", $(this).attr("data-delay"));
  $("#modalAddEditLate").attr("data-date", $(this).attr("data-date"));
  $("#modalAddEditLate").attr("data-archive", $(this).attr("data-archive"));

  // fields
  $("#modalAddEditLate #fio_field_late").val($(this).attr("data-trainee_id"));
  $("#modalAddEditLate #session_name_field").val($(this).attr("data-reason"));
  let male_word = ' ';

  if (serving_ones_list_full[$(this).attr("data-author")]) {
    if (serving_ones_list_full[$(this).attr("data-author")]['male'] !== '1') {
      male_word = 'а ';
    }
  } else if (trainee_list_full[$(this).attr("data-author")]) {
    if (trainee_list_full[$(this).attr("data-author")]['male'] !== '1') {
      male_word = 'а ';
    }
  }

  let servise_one_author, servise_one_archivator;
  if (serving_ones_list_full[$(this).attr("data-author")]) {
    servise_one_author = serving_ones_list_full[$(this).attr("data-author")]['name'];
  } else {
    servise_one_author = trainee_list[$(this).attr("data-author")];
  }
  let greate_this = "Создал";
  if (!$(this).attr("data-author")) {
    greate_this = "Создано";
    male_word = "";
    servise_one_author = "автоматически";
  }
  let text = greate_this + male_word + ' ' + servise_one_author;
  $('#author_of_late').text(text);

  //$("#modalAddEditLate #comment_field").val($(this).attr("data-comment"));
  $("#modalAddEditLate #minutes_field").val($(this).attr("data-delay"));
  $("#modalAddEditLate #date_field_late").val($(this).attr("data-date"));

  if (serving_ones_list[$(this).attr("data-author")]) {
    $("#modalAddEditLate #author_field_late").val($(this).attr("data-author"));
  } else if (trainee_list[$(this).attr("data-author")]) {
    $("#modalAddEditLate #author_field_late").val($(this).attr("data-author"));
  }
});

// открыть бланк для добавления правки LATE
$('#showModalAddEditLate').click(function () {
  if (trainee_access) {
    $("#modalAddEditExtraHelp #fio_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #reason_field").attr('disabled', false);
    $("#archive_checkbox_field").attr('disabled', true);
    $("#modalAddEditExtraHelp #date_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #save_extra_help").attr('disabled', false);
  } else {
    $("#modalAddEditExtraHelp #fio_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #reason_field").attr('disabled', false);
    $("#archive_checkbox_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #date_field").attr('disabled', false);
    $("#modalAddEditExtraHelp #save_extra_help").attr('disabled', false);
  }
  $('#modalUniTitle_late').text('Опоздание (новое)');
  $('#date_field_late').val(date_now_gl);
  $('#author_field_late').val(admin_id_gl);
  $('#modalAddEditLate').attr('data-date', date_now_gl);
  $('#modalAddEditLate').attr('data-author', admin_id_gl);
  $('#info_of_late').hide();
});

// INFO SHOW
$("#info_of_late").click(function () {
  if ($("#date_of_archive_late").is(":visible")) {
    $("#date_of_archive_late").parent().hide();
  } else {
    $("#date_of_archive_late").parent().show();
  }
});

// динамика
function dinamic_add_string_late(data, update) {
  let status = "", hide_this = "", checked_class = "";
  if (data.done === '1') {
    status = 'checked';
    checked_class = "green_string";
    if ($("#tasks_select_late").val() !== "_all_") {
      hide_this = 'display: none;';
    }
  }
  if (update) {
    let element_upd = $('.ftt_late_string[data-id='+data.feh_id+']');
    if (checked_class) {
      element_upd.addClass(checked_class);
      element_upd.find(".set_to_archive").prop("checked", true);
    } else {
      element_upd.removeClass('green_string');
      element_upd.find(".set_to_done").prop("checked", false);
    }
    if (hide_this) {
      element_upd.hide();
    }
    let short_reason_text = data.session_name;
    if (short_reason_text[50]) {
      short_reason_text = short_reason_text.substr(0,50) + '...';
    }

    element_upd.attr('data-service_one_id',data.ft_serving_one);
    element_upd.attr('data-delay',data.delay);
    element_upd.attr('data-trainee_id',data.member_key);
    element_upd.attr('data-archive',data.done);
    //element_upd.attr('data-comment',data.comment);
    element_upd.attr('data-author',data.author);
    //element_upd.attr('data-archived',data.archive_date);
    element_upd.attr('data-id',data.feh_id);
    element_upd.attr('data-semester',data.semester);
    element_upd.attr('data-date',data.date);
    element_upd.attr('data-reason',data.session_name);
    element_upd.find('.trainee_name').text(trainee_list[data.member_key]);
    element_upd.find('.serving_one_name').text(serving_ones_list[data.ft_serving_one]);
    element_upd.find('.text_min').text(data.delay);
    element_upd.find('.reason_text').text(short_reason_text);
    element_upd.find('.date_create_text').text(dateStrFromyyyymmddToddmm(data.date));
    element_upd.find('.set_to_done').text(data.done);
  } else {
    let short_reason_text = data.session_name;
    if (short_reason_text[50]) {
      short_reason_text = short_reason_text.substr(0,50) + '...';
    }
  // новая карточка
  let update_string = '<div style="'+hide_this+'" class="row ftt_late_string '+checked_class
  +'" data-service_one_id="'+ data.ft_serving_one
  //+'" data-service_one_archived_id="'+ data.archivator
  +'" data-trainee_id="'+ data.member_key
  +'" data-archive="'+ data.done
  +'" data-comment="'+ ''
  +'" data-author="'+ data.author
  +'" data-delay="'+ data.delay
  +'" data-reason="'+ data.session_name
  +'" data-id="'+ data.feh_id
  +'" data-semester="'+ data.semester
  +'" data-date="'+ data.date
  +'" data-toggle="modal" data-target="#modalAddEditLate"><div class="col-2 date_create_text pl-1">'+ dateStrFromyyyymmddToddmm(data.date)
  +'</div><div class="col-3"><span class="trainee_name">'+ trainee_list[data.member_key]
  +'</span><span class="semester_text"> ('+ data.semester
  +')</span><br><span class="serving_one_name" style="font-size: 12px; color: #AAA; '+hide_this+'">'+ serving_ones_list[data.ft_serving_one]
  +'</span></div><div class="col-5 reason_text">'+ short_reason_text
  +'</div><div class="col-1 text_min">' + data.delay
  +'</div><div class="col-2 set_to_archive_container"><input type="checkbox" class="set_to_archive" '+status+'></div></div>';
  $('#list_content_late').prepend(update_string);
  // привязываем событие клик новой строке
  $('#list_content_late').on('click', '.ftt_late_string', function () {
    if ($(this).attr("data-archive") === '1') {
      $('#modalUniTitle_late').text('Опоздание (учтено)');
      $("#done_checkbox_field").prop('checked', true);
    } else {
      $('#modalUniTitle_late').text('Опоздание (текущее)');
      $("#done_checkbox_field").prop('checked', false);
    }
    // attr
    //$("#modalAddEditLate").attr("data-archive_date", $(this).attr("data-archived"));
    $("#modalAddEditLate").attr("data-id", $(this).attr("data-id"));
    $("#modalAddEditLate").attr("data-serving_one", $(this).attr("data-service_one_id"));
    $("#modalAddEditLate").attr("data-trainee_id", $(this).attr("data-trainee_id"));
    $("#modalAddEditLate").attr("data-author", $(this).attr("data-author"));
    $("#modalAddEditLate").attr("data-reason", $(this).attr("data-reason"));
    $("#modalAddEditLate").attr("data-comment", $(this).attr("data-delay"));
    $("#modalAddEditLate").attr("data-date", $(this).attr("data-date"));
    //$("#modalAddEditLate").attr("data-archive", $(this).attr("data-archive"));

    // fields
    $("#modalAddEditLate #fio_field_late").val($(this).attr("data-trainee_id"));
    $("#modalAddEditLate #session_name_field").val($(this).attr("data-reason"));
    $("#modalAddEditLate #date_field_late").val($(this).attr("data-date"));
    $("#modalAddEditLate #minutes_field").val($(this).attr("data-delay"));

    let male_word = ' ';
    if (serving_ones_list_full[$(this).attr("data-author")]) {
      if (serving_ones_list_full[$(this).attr("data-author")]['male'] !== '1') {
        male_word = 'а ';
      }
    }

    let servise_one_author, servise_one_archivator;
    if (serving_ones_list_full[$(this).attr("data-author")]) {
      if (serving_ones_list_full[$(this).attr("data-author")]['name']) {
        servise_one_author = serving_ones_list_full[$(this).attr("data-author")]['name'];
      } else {
        servise_one_author = trainee_list_full[$(this).attr("data-author")]['name'];
      }
    }
    let greate_this = "Создал";
    if (!$(this).attr("data-author")) {
      greate_this = "Создано";
      male_word = "";
      servise_one_author = "автоматически";
    }

    let text = greate_this + male_word + ' ' + servise_one_author;
    $('#author_of_late').text(text);
    male_word = ' ';

    $("#modalAddEditExtraHelp #minutes_field").val($(this).attr("data-delay"));
    //$("#modalAddEditExtraHelp #date_closed_field").val($(this).attr("data-archived"));
    $("#modalAddEditExtraHelp #date_field_late").val($(this).attr("data-date"));

    if (serving_ones_list[$(this).attr("data-author")]) {
      $("#modalAddEditExtraHelp #author_field").val($(this).attr("data-author"));
    } else if (trainee_list[$(this).attr("data-author")]) {
      $("#modalAddEditExtraHelp #author_field").val($(this).attr("data-author"));
    }
  });

  // привязываем статус
  $('#list_content_late').on('click','.set_to_done', function (e) {
    e.stopPropagation();
    if (ftt_access_trainee || trainee_access) {
     showError("Ошибка. Не достаточно прав.");
     return;
    }
    let done = 1;
    if ($(this).hasClass('badge-success')) {
      done = 0;
    }

    let this_string = $(this);
    fetch('ajax/ftt_extra_help_ajax.php?type=set_late_done&id=' + $(this).parent().parent().attr('data-id')+'&done='+done)
    .then(response => response.text())
    .then(commits => {
      if (done === 1) {
        $(this_string).addClass('green_string');
        $(this_string).parent().parent().attr('data-archive', 1);
        //$(this_string).parent().parent().attr('data-service_one_archived_id', admin_id_gl);
        //$(this_string).parent().parent().attr('data-archived', date_now_gl);
        $(this_string).parent().parent().hide();
      } else {
        $(this_string).removeClass('green_string');
        $(this_string).parent().parent().attr('data-archive', '0');
        //$(this_string).parent().parent().attr('data-service_one_archived_id', '');
        //$(this_string).parent().parent().attr('data-archived', '');
      }
    });
  });
}
}
// сортировка
$(".sort_date, .sort_trainee").click(function (e) {
  if (e.target.id === "sort_date" || e.target.id === "sort_trainee") {
    setCookie('sorting', e.target.id + "-asc", 356);
    if (e.target.id === "sort_date") {
      $("#sort_trainee").prop("checked", false)
    } else {
      $("#sort_date").prop("checked", false);
    }
  } else {
    let sorting_name = e.target.className;
    $(".sort_date i, .sort_trainee i").addClass("hide_element");
    if ($(this).hasClass("sort_date")) {
      $(".sort_trainee i").removeClass("fa");
      $(".sort_trainee i").removeClass("fa-sort-desc");
      $(".sort_trainee i").removeClass("fa-sort-asc");
    } else if ($(this).hasClass("sort_traine")) {
      $(".sort_date i").removeClass("fa");
      $(".sort_date i").removeClass("fa-sort-desc");
      $(".sort_date i").removeClass("fa-sort-asc");
    }

    $(this).find("i").removeClass("hide_element");
    if ($(this).find("i").hasClass("fa-sort-desc")) {
      $(this).find("i").removeClass("fa-sort-desc").addClass("fa-sort-asc");
      setCookie('sorting', sorting_name + "-desc", 356);
    } else if ($(this).find("i").hasClass("fa-sort-asc")) {
      $(this).find("i").removeClass("fa-sort-asc").addClass("fa-sort-desc");
      setCookie('sorting', sorting_name + "-asc", 356);
    } else {
      $(this).find("i").addClass("fa");
      $(this).find("i").addClass("fa-sort-asc");
      setCookie('sorting', sorting_name + "-desc", 356);
    }
  }
  setTimeout(function () {
    location.reload();
  }, 30);
});

// Проверка отметки "Учтено" для опозданий.
$("#done_checkbox_field").click(function (e) {
  if (ftt_access_trainee || trainee_access) {
    if (e.target.checked) {
      $(this).prop("checked", false);
    } else {
      $(this).prop("checked", true);
    }
    showError("Ошибка. Не достаточно прав.");
    return;
  }
});

// DOCUMENT READY STOP
});
