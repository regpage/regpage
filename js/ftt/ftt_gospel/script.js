$(document).ready(function(){

  /* ==== MAIN & EXTRA HELP START ==== */

  // текущая дата, получаем приводим к типу гггг.мм.дд
// ВЫНЕСТИ В МОДУЛЬ! <<<<< --------------
  function date_now_gl () {
    // YYYY-MM-dd
    let date_now_gl = new Date();
    let yyyy = date_now_gl.getFullYear();
    let mm = date_now_gl.getMonth()+1;
    let dd = date_now_gl.getDate();
    if (mm < 9) {
      mm = '0'+mm;
    }
    if (dd < 9) {
      dd = '0'+dd;
    }
    return yyyy + '-' + mm + '-' + dd;
  }
  date_now_gl = date_now_gl ();

let data_strings = ['id', 'date', 'author', 'gospel_team', 'gospel_group', 'place', 'group_members', 'flyers', 'people', 'prayers', 'baptism', 'meets_last', 'meets_current', 'meetings_last', 'meetings_current', 'first_contacts', 'further_contacts', 'homes', 'place_name', 'fgt_place', 'comment'];

// Очистить форму
function clear_blank() {
  if ($("#gospel_tab").is(":visible")) {
    for (var i = 0; i < data_strings.length; i++) {
      $('#modalAddEdit').attr('data-' + data_strings[i], '');
    }

    $('#modalAddEdit').find('input').val('');
    $('#modalAddEdit').find('select').val('_none_');
    $('#gospel_group_field').val('0');
    $('#modalAddEdit').find('textarea').val('');

    $('#modalAddEdit').find('#author_of').text('');

    $('#modalAddEdit #date_of_archive').parent().hide();
    // border field color
    $('#modalAddEdit input').css('border-color', 'lightgray');
    $('#modalAddEdit select').css('border-color', 'lightgray');
    $('#modalAddEdit textarea').css('border-color', 'lightgray');
    // info
    $('#modalAddEdit #info_of').show();
  }
}

  // получить данные полей формы
  function get_data_fields() {
    let data = new FormData();

    if ($("#modalAddEdit").attr("data-id")) {
      data.set('id', $("#modalAddEdit").attr("data-id"));
    }
    data.set('author', $("#modalAddEdit").attr("data-author"));

    data.set('fio_field', $('#fio_field').val());
    data.set('date_field', $('#date_field').val());
    data.set('gospel_group_field', $('#gospel_group_field').val());
    data.set('group_members_field', $('#group_members_field').val());
    data.set('number_field', $('#number_field').val());
    data.set('flyers_field', $('#flyers_field').val());
    data.set('people_field', $('#people_field').val());
    data.set('prayers_field', $('#prayers_field').val());
    data.set('baptism_field', $('#baptism_field').val());
    data.set('prayers_field', $('#prayers_field').val());
    data.set('meets_last_field', $('#meets_last_field').val());
    data.set('meets_current_field', $('#meets_current_field').val());
    data.set('meetings_last_field', $('#meetings_last_field').val());
    data.set('meetings_current_field', $('#meetings_current_field').val());
    data.set('homes_field', $('#homes_field').val());
    data.set('first_contacts_field', $('#first_contacts_field').val());
    data.set('further_contacts_field', $('#further_contacts_field').val());
    data.set('comment_field', $('#comment_field').val());
    data.set('archive_checkbox_field', $('#archive_checkbox_field').val());

    return data;
  }

// ==== ГОТОВО ЗДЕСЬ И ВЫШЕ
// validation
 function validation_fields(e) {
   // валидация значений полей
   if ($("#modalAddEdit").is(":visible")) {
     if ($('#modalAddEdit #fio_field').val() === '_none_') {
       e.stopPropagation();
       e.preventDefault();
       showError('Заполните поля выделенные красной рамкой.');
       $('#modalAddEdit #fio_field').css('border-color', 'red');
       if ($('#modalAddEdit #date_field').val() === '') {
         $('#modalAddEdit #date_field').css('border-color', 'red');
       }
       if ($('#modalAddEdit #reason_field').val() === '') {
         $('#modalAddEdit #reason_field').css('border-color', 'red');
       }
       return false;
     } else {
       $('#modalAddEdit #fio_field').css('border-color', 'lightgray');
     }
     return true;
   }

 }
// ========== НЕ ГОТОВО В ПОСЛЕДНЮЮ ОЧЕРЕДЬ
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
     element_upd.find('.date_create_text').text(data.date);
     element_upd.find('.set_to_archive').text(data.archive);
   } else {
     let short_reason_text = data.reason;
     if (short_reason_text[50]) {
       short_reason_text = short_reason_text.substr(0,50) + '...';
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
   +'" data-toggle="modal" data-target="#modalAddEdit"><div class="col-2 date_create_text pl-1">'+ data.date
   +'</div><div class="col-3"><span class="trainee_name">'+ trainee_list[data.member_key]
   +'</span><span class="semester_text"> ('+ data.semester
   +')</span><br><span class="serving_one_name" style="font-size: 12px; color: #AAA; '+hide_this+'">'+ serving_ones_list[data.ft_serving_one]
   +'</span></div><div class="col-5 reason_text">'+ short_reason_text
   +'</div><div class="col-2 set_to_archive_container"><input type="checkbox" class="set_to_archive" '+status+'></div></div>';
   $('#list_content').prepend(update_string);
   // привязываем событие клик новой строке
   $('#list_content').on('click', '.ftt_extra_help_string', function () {
     if ($(this).attr("data-archive") === '1') {
       $('#modalUniTitle').text('Статистика благовестия');
       $("#archive_checkbox_field").prop('checked', true);
     } else {
       $('#modalUniTitle').text('Статистика благовестия');
       $("#archive_checkbox_field").prop('checked', false);
     }
     // attr
     $("#modalAddEdit").attr("data-archive_date", $(this).attr("data-archived"));
     $("#modalAddEdit").attr("data-id", $(this).attr("data-id"));
     $("#modalAddEdit").attr("data-serving_one", $(this).attr("data-service_one_id"));
     $("#modalAddEdit").attr("data-trainee_id", $(this).attr("data-trainee_id"));
     $("#modalAddEdit").attr("data-author", $(this).attr("data-author"));
     $("#modalAddEdit").attr("data-reason", $(this).attr("data-reason"));
     $("#modalAddEdit").attr("data-comment", $(this).attr("data-comment"));
     $("#modalAddEdit").attr("data-date", $(this).find(".date_create_text").text());
     $("#modalAddEdit").attr("data-archive", $(this).attr("data-archive"));

     // fields
     $("#modalAddEdit #fio_field").val($(this).attr("data-trainee_id"));
     $("#modalAddEdit #reason_field").val($(this).attr("data-reason"));

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

     let text = 'Создал' + male_word + ' ' + servise_one_author;
     $('#author_of').text(text);
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

     $("#modalAddEdit #comment_field").val($(this).attr("data-comment"));
     $("#modalAddEdit #date_closed_field").val($(this).attr("data-archived"));
     $("#modalAddEdit #date_field").val($(this).find(".date_create_text").text());

     if (serving_ones_list[$(this).attr("data-author")]) {
       $("#modalAddEdit #author_field").val($(this).attr("data-author"));
     } else if (trainee_list[$(this).attr("data-author")]) {
       $("#modalAddEdit #author_field").val($(this).attr("data-author"));
     }
   });
 }
 }

// ===== В ПРОЦЕССЕ
// save data
function save_data_blank() {
  let data = get_data_fields();
  if ($("#modalAddEdit").attr("data-id")) {
    // update
    fetch('ajax/ftt_gospel_ajax.php?type=update_data_blank', {
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(commits => {
      //dinamic_add_string(commits.result, true);
      clear_blank();
      location.reload();
    });
  } else {
    // добавить новый
    fetch('ajax/ftt_gospel_ajax.php?type=add_data_blank', {
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(commits => {
      //dinamic_add_string(commits.result);
      clear_blank();
      location.reload();
    });
  }
}

$('#date_field').change(function () {

  if ($(this).css('border-color') === 'rgb(255, 0, 0)') {
    $(this).css('border-color', 'lightgray');
  }
});

$('#modalAddEdit .close').click(function (e) {
  // проверка при закрытиии бланка не по кнопке сохранить
  //ПРОРАБОТАТЬ И ВЕРНУТЬ
// $('#group_members_field').val() !== $("#modalAddEdit").attr("data-group_members") ||
  if (($('#fio_field').val() !== $("#modalAddEdit").attr("data-gospel_team") && $('#fio_field').val() !== '_none_') ||
    $('#date_field').val() !== $("#modalAddEdit").attr("data-date") ||
    ($('#gospel_group_field').val() !== $("#modalAddEdit").attr("data-gospel_group") && $('#gospel_group_field').val() !== '0') ||
    $('#number_field').val() !== $("#modalAddEdit").attr("data-number") ||
    $('#flyers_field').val() !== $("#modalAddEdit").attr("data-flyers") ||
    $('#people_field').val() !== $("#modalAddEdit").attr("data-people") ||
    $('#prayers_field').val() !== $("#modalAddEdit").attr("data-prayers") ||
    $('#baptism_field').val() !== $("#modalAddEdit").attr("data-baptism") ||
    $('#meets_last_field').val() !== $("#modalAddEdit").attr("data-meets_last") ||
    $('#meets_current_field').val() !== $("#modalAddEdit").attr("data-meets_current") ||
    $('#meetings_last_field').val() !== $("#modalAddEdit").attr("data-meetings_last") ||
    $('#meetings_current_field').val() !== $("#modalAddEdit").attr("data-meetings_current") ||
    $('#homes_field').val() !== $("#modalAddEdit").attr("data-homes") ||
    $('#first_contacts_field').val() !== $("#modalAddEdit").attr("data-first_contacts") ||
    $('#further_contacts_field').val() !== $("#modalAddEdit").attr("data-further_contacts") ||
    $('#comment_field').val() !== $("#modalAddEdit").attr("data-comment")) {
    if (confirm('Сохранить изменения?')) {
      if (validation_fields(e)) {
        save_data_blank();
      }
    } else {
        clear_blank();
    }
  } else {
    clear_blank();
  }
});

$('#modalAddEdit .btn-secondary').click(function (e) {
  // проверка при закрытиии бланка не по кнопке сохранить
  if (($('#fio_field').val() !== $("#modalAddEdit").attr("data-gospel_team") && $('#fio_field').val() !== '_none_') ||
    $('#date_field').val() !== $("#modalAddEdit").attr("data-date") ||
    ($('#gospel_group_field').val() !== $("#modalAddEdit").attr("data-gospel_group") && $('#gospel_group_field').val() !== '0') ||
    $('#group_members_field').val() !== $("#modalAddEdit").attr("data-group_members") ||
    $('#number_field').val() !== $("#modalAddEdit").attr("data-number") ||
    $('#flyers_field').val() !== $("#modalAddEdit").attr("data-flyers") ||
    $('#people_field').val() !== $("#modalAddEdit").attr("data-people") ||
    $('#prayers_field').val() !== $("#modalAddEdit").attr("data-prayers") ||
    $('#baptism_field').val() !== $("#modalAddEdit").attr("data-baptism") ||
    $('#meets_last_field').val() !== $("#modalAddEdit").attr("data-meets_last") ||
    $('#meets_current_field').val() !== $("#modalAddEdit").attr("data-meets_current") ||
    $('#meetings_last_field').val() !== $("#modalAddEdit").attr("data-meetings_last") ||
    $('#meetings_current_field').val() !== $("#modalAddEdit").attr("data-meetings_current") ||
    $('#homes_field').val() !== $("#modalAddEdit").attr("data-homes") ||
    $('#first_contacts_field').val() !== $("#modalAddEdit").attr("data-first_contacts") ||
    $('#further_contacts_field').val() !== $("#modalAddEdit").attr("data-further_contacts") ||
    $('#comment_field').val() !== $("#modalAddEdit").attr("data-comment")) {
    if (confirm('Сохранить изменения?')) {
      if (validation_fields(e)) {
        save_data_blank();
      }
    } else {
        clear_blank();
    }
  } else {
    clear_blank();
  }
});
// подобный код дублируется в $("#gospel_group_field").change() и в $('#fio_field').change()
function get_gospel_group_members() {
  let gospel_group_data = '';
  let gospel_group_data_tmp;
  let i_count = 0;
  for (var i = 0; i < gospel_groups.length; i++) {
    if (gospel_groups[i]) {
      if (trainee_list_full[admin_id_gl]) {
        if (gospel_groups[i]['team'] === trainee_list_full[admin_id_gl]['gospel_team'] && gospel_groups[i]['group'] === trainee_list_full[admin_id_gl]['gospel_group']) {
          gospel_group_data_tmp = trainee_list[gospel_groups[i]['member_key']];
          if (gospel_group_data_tmp) {
            if (i_count > 0) {
              gospel_group_data += ", ";
            }
            gospel_group_data_tmp = gospel_group_data_tmp.split(" ");
            gospel_group_data += gospel_group_data_tmp[0]+" "+gospel_group_data_tmp[1][0]+". ";
            i_count++;
          }
        }
      }
    }
  }
  return gospel_group_data;
}

$("#add_comment").click(function () {
  $("#add_comment").slideUp();
  $("#comment_block").slideDown();
});

// ГОТОВО
// открыть бланк для добавления правки
$('#showModalAddEdit').click(function () {
  $("#add_comment").show();
  $("#comment_block").hide();
  $("#modalAddEdit input").attr('disabled', false);
  $("#modalAddEdit select").attr('disabled', false);
  $("#modalAddEdit textarea").attr('disabled', false);

  $('#modalUniTitle').text('Статистика благовестия (новая)');
  $('#date_field').val(date_now_gl);
  $('#modalAddEdit').attr('data-date', date_now_gl);
  $('#modalAddEdit').attr('data-author', admin_id_gl);
  if (trainee_list_full[admin_id_gl]) {
    $("#modalAddEdit").attr("data-gospel_team", trainee_list_full[admin_id_gl]['gospel_team']);
    $('#fio_field').val(trainee_list_full[admin_id_gl]['gospel_team']);
    $("#modalAddEdit").attr("data-gospel_group", trainee_list_full[admin_id_gl]['gospel_group']);
    $('#gospel_group_field').val(trainee_list_full[admin_id_gl]['gospel_group']);
    $('#gospelGroupNumber').text(trainee_list_full[admin_id_gl]['gospel_group']);
  } else {
    $('#gospelGroupNumber').text(0);
    $("#modalAddEdit").attr("data-gospel_team", serving_ones_list_full[admin_id_gl]['gospel_team']);
    $('#fio_field').val(serving_ones_list_full[admin_id_gl]['gospel_team']);
  }

  $("#group_members_field").val(get_gospel_group_members());
  $('#info_of').hide();
  $('#gospel_group_field').hide();
});

// удалить доп задание
$('#modalAddEdit .btn-danger').click(function () {
  if (!$('#modalAddEdit').attr('data-id')) {
    showError('Бланк не сохранён. Его нельзя удалить.');
    return;
  }
  if (confirm('Удалить отчёт?')) {
    fetch('ajax/ftt_gospel_ajax.php?type=delete_blank&id='+ $('#modalAddEdit').attr('data-id'))
    .then(response => response.json())
    .then(commits => {
      $('.list_string[data-id='+$('#modalAddEdit').attr('data-id')+']').slideUp(300).removeClass('list_string').hide();
      clear_blank();
    });
  }
});
/*
// Помечаем как выполненное ДУБЛЬ ПРИ ДОБАВЛЕНИИ НОВОГО ОТЧЁТА УДАЛЁН!
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
*/
// save
$('#save_extra_help').click(function (e) {
  if (trainee_access && $("#modalAddEdit").attr("data-author") !== admin_id_gl) {
    showError('Нельзя сохранить.');
    return;
  }
  // валидация значений полей
  if ($('#modalAddEdit #fio_field').val() === '_none_') {
    e.stopPropagation();
    e.preventDefault();
    showError('Заполните поля выделенные красной рамкой.');
    $('#modalAddEdit #fio_field').css('border-color', 'red');
    if ($('#modalAddEdit #date_field').val() === '') {
      $('#modalAddEdit #date_field').css('border-color', 'red');
    }
    if ($('#modalAddEdit #reason_field').val() === '') {
      $('#modalAddEdit #reason_field').css('border-color', 'red');
    }
    return;
  } else {
    $('#modalAddEdit #fio_field').css('border-color', 'lightgray');
  }

  if ($('#modalAddEdit #date_field').val() === '') {
    e.stopPropagation();
    e.preventDefault();
    $('#modalAddEdit #date_field').css('border-color', 'red');
    if ($('#modalAddEdit #reason_field').val() === '') {
      $('#modalAddEdit #reason_field').css('border-color', 'red');
    }
    return;
  } else {
    $('#modalAddEdit #date_field').css('border-color', 'lightgray');
  }

  if ($('#modalAddEdit #reason_field').val() === '') {
    e.stopPropagation();
    e.preventDefault();
    $('#modalAddEdit #reason_field').css('border-color', 'red');
    return;
  } else {
    $('#modalAddEdit #reason_field').css('border-color', 'lightgray');
  }

  save_data_blank();

});

// клик по строкке, загружаем форму
$(".list_string").click(function () {
  if ($(this).attr("data-author") !== admin_id_gl) {
    $("#modalAddEdit input").attr('disabled', false);
    $("#modalAddEdit select").attr('disabled', false);
    $("#modalAddEdit textarea").attr('disabled', false);
  } else {
    $("#modalAddEdit input").attr('disabled', false);
    $("#modalAddEdit select").attr('disabled', false);
    $("#modalAddEdit textarea").attr('disabled', false);
  }
  $('#gospel_group_field').hide();
  $('#modalUniTitle').text('Статистика благовестия');
  $('#gospelGroupNumber').text($(this).attr('data-gospel_group'));

// fill
  // fields
  $('#fio_field').val($(this).attr('data-gospel_team'));
  $('#date_field').val($(this).attr('data-date'));
  $('#gospel_group_field').val($(this).attr('data-gospel_group'));
  $("#group_members_field").val(get_gospel_group_members());
/*
  for (var i = 0; i < group_members.length; i++) {
    if (i > 0) {
      list_group += ", ";
    }
     group_members_one = group_members[i];
     list_group += trainee_list[group_members_one.trim()];
  }
*/

  $('#group_members_field').val($(this).attr('data-group_members'));
  $('#number_field').val($(this).attr('data-number'));
  $('#flyers_field').val($(this).attr('data-flyers'));
  $('#people_field').val($(this).attr('data-people'));
  $('#prayers_field').val($(this).attr('data-prayers'));
  $('#baptism_field').val($(this).attr('data-baptism'));
  $('#meets_last_field').val($(this).attr('data-meets_last'));
  $('#meets_current_field').val($(this).attr('data-meets_current'));
  $('#meetings_last_field').val($(this).attr('data-meetings_last'));
  $('#meetings_current_field').val($(this).attr('data-meetings_current'));
  $('#homes_field').val($(this).attr('data-homes'));
  $('#first_contacts_field').val($(this).attr('data-first_contacts'));
  $('#further_contacts_field').val($(this).attr('data-further_contacts'));
  $('#comment_field').val($(this).attr('data-comment'));
  if ($(this).attr('data-comment')) {
    $("#add_comment").hide();
    $("#comment_block").show();
  } else {
    $("#add_comment").show();
    $("#comment_block").hide();
  }

  // attr
  $("#modalAddEdit").attr("data-id", $(this).attr("data-id"));
  $("#modalAddEdit").attr("data-date", $(this).attr("data-date"));
  $("#modalAddEdit").attr("data-author", $(this).attr("data-author"));
  $("#modalAddEdit").attr("data-gospel_team", $(this).attr("data-gospel_team"));
  $("#modalAddEdit").attr("data-gospel_group", $(this).attr("data-gospel_group"));
  $("#modalAddEdit").attr("data-place", $(this).attr("data-place"));
  $("#modalAddEdit").attr("data-group_members", $(this).attr("data-group_members"));
  $("#modalAddEdit").attr("data-number", $(this).attr("data-number"));
  $("#modalAddEdit").attr("data-flyers", $(this).attr("data-flyers"));
  $("#modalAddEdit").attr("data-people", $(this).attr("data-people"));
  $("#modalAddEdit").attr("data-prayers", $(this).attr("data-prayers"));
  $("#modalAddEdit").attr("data-baptism", $(this).attr("data-baptism"));
  $("#modalAddEdit").attr("data-meets_last", $(this).attr("data-meets_last"));
  $("#modalAddEdit").attr("data-meets_current", $(this).attr("data-meets_current"));
  $("#modalAddEdit").attr("data-meetings_last", $(this).attr("data-meetings_last"));
  $("#modalAddEdit").attr("data-meetings_current", $(this).attr("data-meetings_current"));
  $("#modalAddEdit").attr("data-first_contacts", $(this).attr("data-first_contacts"));
  $("#modalAddEdit").attr("data-further_contacts", $(this).attr("data-further_contacts"));
  $("#modalAddEdit").attr("data-homes", $(this).attr("data-homes"));
  $("#modalAddEdit").attr("data-place_name", $(this).attr("data-place_name"));
  $("#modalAddEdit").attr("data-fgt_place", $(this).attr("data-fgt_place"));
  $("#modalAddEdit").attr("data-comment", $(this).attr("data-comment"));

  // fields more
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

  let text = 'Создал' + male_word + ' ' + servise_one_author;
  $('#author_of').text(text);
});

// список применённых фильтров
function filters_list_show() {
  let filters_text;
  if ($(window).width()<=769) {
    if ($("#author_select_mbl").val()) {
      filters_text = "Фильтры: " + $("#author_select_mbl option:selected").text() + ", " + $("#team_select_mbl option:selected").text() + ", " + $("#periods_mbl option:selected").text();
    } else {
      filters_text = "Фильтры: " + $("#periods_mbl option:selected").text();
    }
  } else {
    if ($("#author_select_desk").val()) {
      filters_text = "Фильтры: " + $("#author_select_desk option:selected").text() + ", " + $("#team_select option:selected").text() + ", " + $("#periods option:selected").text();
    } else {
      filters_text = "Фильтры: " + $("#periods option:selected").text();
    }
  }
  $("#filters_list").text(filters_text);
}
filters_list_show();

  // Печать
  function statistics_counter() {
    // автоматизировать и вызывать другой запрос адаптированный для группб если понадобится
    // можно собирать данные в массив и группы заполнять при рендоринге
    // render_print_report(headers);  // вызывать из статистики предварительно передав туда хедерс
    $("#team_select_print").val(); //serving_ones_list_full[admin_id_gl]["gospel_team"]
    fetch("ajax/ftt_gospel_ajax.php?type=get_gospel_str&team="+$("#team_select_print").val()+"&period=_all_&from=&to=")
    .then(response => response.json())
    .then(commits => {
      let selected_group = $("#group_select_print").val();
      let stat = commits.result;
      // all time variable
      let flyers = 0, people = 0, prayers = 0, baptism = 0, meets_last = 0, meets_current = 0, meetings_last = 0;
      let meetings_current = 0, first_contacts = 0, further_contacts = 0, homes = 0;
      // period variable
      let period_from = new Date($("#period_from_print").val());
      let period_to = new Date($("#period_to_print").val());
      let range_flyers = 0, range_people = 0, range_prayers = 0, range_baptism = 0, range_meets_last = 0, range_meets_current = 0, range_meetings_last = 0;
      let range_meetings_current = 0, range_first_contacts = 0, range_further_contacts = 0, range_homes = 0;
      let group_stat = [];
      for (let i = 0; i < stat.length; i++) {
        // При условии что отчёт формируется по всем группам
        // Добавить массив с элементами по количеству групп. В каждой группе все элементы для боди.
        // В них записывать статистику и передавать в функцию рендеринга
        if (selected_group === stat[i].gospel_group && selected_group !== "_all_" && selected_group) {
          flyers += Number(stat[i].flyers);
          people += Number(stat[i].people);
          prayers += Number(stat[i].prayers);
          baptism += Number(stat[i].baptism);
          meets_last += Number(stat[i].meets_last);
          meets_current += Number(stat[i].meets_current);
          meetings_last += Number(stat[i].meetings_last);
          meetings_current += Number(stat[i].meetings_current);
          first_contacts += Number(stat[i].first_contacts);
          further_contacts += Number(stat[i].further_contacts);
          homes += Number(stat[i].homes);
          // periods
          let date_str = new Date(stat[i].date);
          if (date_str >= period_from && date_str <= period_to && (stat[i].gospel_team === $("#team_select_print").val() || $("#team_select_print").val() === "_all_")) {
            range_flyers += Number(stat[i].flyers);
            range_people += Number(stat[i].people);
            range_prayers += Number(stat[i].prayers);
            range_baptism += Number(stat[i].baptism);
            range_meets_last += Number(stat[i].meets_last);
            range_meets_current += Number(stat[i].meets_current);
            range_meetings_last += Number(stat[i].meetings_last);
            range_meetings_current += Number(stat[i].meetings_current);
            range_first_contacts += Number(stat[i].first_contacts);
            range_further_contacts += Number(stat[i].further_contacts);
            range_homes += Number(stat[i].homes);
          }
        }
        if (selected_group === "_all_" || !selected_group) {
          if (selected_group === "_all_" && $("#team_select_print").val() !== "_all_") {
            if (!group_stat[stat[i].gospel_group]) {
              group_stat[stat[i].gospel_group] = [];
              group_stat[stat[i].gospel_group]["flyers"] = 0;
              group_stat[stat[i].gospel_group]["people"] = 0;
              group_stat[stat[i].gospel_group]["prayers"] = 0;
              group_stat[stat[i].gospel_group]["baptism"] = 0;
              group_stat[stat[i].gospel_group]["meets_last"] = 0;
              group_stat[stat[i].gospel_group]["meets_current"] = 0;
              group_stat[stat[i].gospel_group]["meetings_last"] = 0;
              group_stat[stat[i].gospel_group]["meetings_current"] = 0;
              group_stat[stat[i].gospel_group]["first_contacts"] = 0;
              group_stat[stat[i].gospel_group]["further_contacts"] = 0;
              group_stat[stat[i].gospel_group]["homes"] = 0;
            }

            group_stat[stat[i].gospel_group]["flyers"] += Number(stat[i].flyers);
            group_stat[stat[i].gospel_group]["people"] += Number(stat[i].people);
            group_stat[stat[i].gospel_group]["prayers"] += Number(stat[i].prayers);
            group_stat[stat[i].gospel_group]["baptism"] += Number(stat[i].baptism);
            group_stat[stat[i].gospel_group]["meets_last"] += Number(stat[i].meets_last);
            group_stat[stat[i].gospel_group]["meets_current"] += Number(stat[i].meets_current);
            group_stat[stat[i].gospel_group]["meetings_last"] += Number(stat[i].meetings_last);
            group_stat[stat[i].gospel_group]["meetings_current"] += Number(stat[i].meetings_current);
            group_stat[stat[i].gospel_group]["first_contacts"] += Number(stat[i].first_contacts);
            group_stat[stat[i].gospel_group]["further_contacts"] += Number(stat[i].further_contacts);
            group_stat[stat[i].gospel_group]["homes"] += Number(stat[i].homes);
          }
          flyers += Number(stat[i].flyers);
          people += Number(stat[i].people);
          prayers += Number(stat[i].prayers);
          baptism += Number(stat[i].baptism);
          meets_last += Number(stat[i].meets_last);
          meets_current += Number(stat[i].meets_current);
          meetings_last += Number(stat[i].meetings_last);
          meetings_current += Number(stat[i].meetings_current);
          first_contacts += Number(stat[i].first_contacts);
          further_contacts += Number(stat[i].further_contacts);
          homes += Number(stat[i].homes);
          // periods
          let date_str = new Date(stat[i].date);
          if (date_str >= period_from && date_str <= period_to && (stat[i].gospel_team === $("#team_select_print").val() || $("#team_select_print").val() === "_all_")) {
            range_flyers += Number(stat[i].flyers);
            range_people += Number(stat[i].people);
            range_prayers += Number(stat[i].prayers);
            range_baptism += Number(stat[i].baptism);
            range_meets_last += Number(stat[i].meets_last);
            range_meets_current += Number(stat[i].meets_current);
            range_meetings_last += Number(stat[i].meetings_last);
            range_meetings_current += Number(stat[i].meetings_current);
            range_first_contacts += Number(stat[i].first_contacts);
            range_further_contacts += Number(stat[i].further_contacts);
            range_homes += Number(stat[i].homes);
          }
        }
      }
      if (selected_group === "_all_") {
        $(".extra_groups").remove();
        render_print_report(group_stat);
      } else {
        $(".extra_groups").remove();
      }
      $("#team_name_print").text($("#team_select_print option:selected").text() + ": " + dateStrToddmmyyyyToyyyymmdd($("#period_from_print").val(), true) + " — " + dateStrToddmmyyyyToyyyymmdd($("#period_to_print").val(), true));

      $("#flyers_all").text(flyers);
      $("#people_all").text(people);
      $("#prayers_all").text(prayers);
      $("#baptism_all").text(baptism);
      $("#meets_last_all").text(meets_last);
      $("#meets_current_all").text(meets_current);
      $("#meetings_last_all").text(meetings_last);
      $("#meetings_current_all").text(meetings_current);
      $("#first_contacts_all").text(first_contacts);
      $("#further_contacts_all").text(further_contacts);
      $("#homes_all").text(homes);

      $("#range_flyers").text(range_flyers);
      $("#range_people").text(range_people);
      $("#range_prayers").text(range_prayers);
      $("#range_baptism").text(range_baptism);
      $("#range_meets_last").text(range_meets_last);
      $("#range_meets_current").text(range_meets_current);
      $("#range_meetings_last").text(range_meetings_last);
      $("#range_meetings_current").text(range_meetings_current);
      $("#range_first_contacts").text(range_first_contacts);
      $("#range_further_contacts").text(range_further_contacts);
      $("#range_homes").text(range_homes);
    });
  }
  $("#print_modal_open").click(function () {
    statistics_counter();
  });
  // рендорим поля для групп в таблице отчёта
  function render_print_report(groups) {
    let groups_html, body_html;
    groups_html = "";
    let body_flyers = "", body_people = "", body_prayers = "", body_baptism = "", body_meets_last = "", body_meets_current = "", body_meetings_last = "", body_meetings_current = "", body_first_contacts = "", body_further_contacts = "", body_homes = "";
    for (let group in groups) {
      groups_html += '<th class="extra_groups" style="text-align: right; min-width: 80px;">Группа '+group+'</th>';
      body_flyers += "<td class='extra_groups' style='text-align: right; min-width: 80px;'>"+groups[group]["flyers"]+"</td>";
      body_people += "<td class='extra_groups' style='text-align: right; min-width: 85px;'>"+groups[group]["people"]+"</td>";
      body_prayers += "<td class='extra_groups' style='text-align: right; min-width: 80px;'>"+groups[group]["prayers"]+"</td>";
      body_baptism += "<td class='extra_groups' style='text-align: right; min-width: 80px;'>"+groups[group]["baptism"]+"</td>";
      body_meets_last += "<td class='extra_groups' style='text-align: right; min-width: 80px;'>"+groups[group]["meets_last"]+"</td>";
      body_meets_current += "<td class='extra_groups' style='text-align: right; min-width: 80px;'>"+groups[group]["meets_current"]+"</td>";
      body_meetings_last += "<td class='extra_groups' style='text-align: right; min-width: 80px;'>"+groups[group]["meetings_last"]+"</td>";
      body_meetings_current += "<td class='extra_groups' style='text-align: right; min-width: 80px;'>"+groups[group]["meetings_current"]+"</td>";
      body_first_contacts += "<td class='extra_groups' style='text-align: right; min-width: 80px;'>"+groups[group]["first_contacts"]+"</td>";
      body_further_contacts += "<td class='extra_groups' style='text-align: right; min-width: 80px;'>"+groups[group]["further_contacts"]+"</td>";
      body_homes += "<td class='extra_groups' style='text-align: right; min-width: 80px;'>"+groups[group]["homes"]+"</td>";
    }
    $(groups_html).insertAfter("#th_questions");
    $(body_flyers).insertAfter("#question_flyers");
    $(body_people).insertAfter("#question_people");
    $(body_prayers).insertAfter("#question_prayers");
    $(body_baptism).insertAfter("#question_baptism");
    $(body_meets_last).insertAfter("#question_meets_last");
    $(body_meets_current).insertAfter("#question_meets_current");
    $(body_meetings_last).insertAfter("#question_meetings_last");
    $(body_meetings_current).insertAfter("#question_meetings_current");
    $(body_first_contacts).insertAfter("#question_first_contacts");
    $(body_further_contacts).insertAfter("#question_further_contacts");
    $(body_homes).insertAfter("#question_homes");
  }

  $("#period_from_print, #period_to_print, #team_select_print, #group_select_print").change(function(e) {
    // group condition
    $("#group_number_print").text("");
    if (e.target.id === "group_select_print" && $(this).val() && $(this).val() !== "_all_") {
      $("#group_number_print").text("Группа "+$(this).val());
    }
    // team condition
    if (e.target.id === "team_select_print") {
      // формируем группы
      fetch("ajax/ftt_gospel_ajax.php?type=get_ftt_gospel_groups&gospel_team="+$(this).val())
      .then(response => response.json())
      .then(commits => {
        let headers = [];
        let html_options = "<option value='_all_'> Все группы";
        for (let i = 0; i < commits.result.length; i++) {
          html_options += "<option value='"+commits.result[i].gospel_group+"'>"+commits.result[i].gospel_group;
          headers.push(commits.result[i].gospel_group);
        }
        $("#group_select_print").html(html_options);
        if ($("#period_from_print").val() && $("#period_to_print").val()) {
          statistics_counter();
        }
      });
    } else {
      if ($("#period_from_print").val() && $("#period_to_print").val()) {
        statistics_counter();
      }
    }
  });

  $("#print_button").click(function () {

    function printElem(elem){
      popup($(elem).html());
    }

    function popup(data){
      let mywindow = window.open('', 'Благовестие', 'height=600,width=800');
      mywindow.document.write('<html><head><title>Благовестие. Для отправки на принтер нажмите Ctrl+P.</title>');
      mywindow.document.write('</head><body><style>th {border-bottom: 1px solid black; text-align: center; border-collapse: collapse;} table, td {border-bottom: 1px solid black; text-align: right; border-collapse: collapse;}</style>');
      mywindow.document.write(data);
      mywindow.document.write('</body></html>');
      //mywindow.print();
      //mywindow.close();
      //return true;
    }
    printElem('#gospel_body_print');
  });
// фильтры
$("#periods, #periods_mbl").change(function (e) {
  setCookie('filter_period', $(this).val(), 1);
  if ($(this).val() === "range") {
    if (e.target.id === "periods_mbl") {
      $("#modalFilrets .filter_range").show();
    } else {
      $(".filter_range").show();
      if (e.target.id !== "periods_mbl") {
        setTimeout(function () {
          location.reload();
        }, 30);
      }
    }
  } else {
    $(".filter_range").hide();
    if (e.target.id !== "periods_mbl") {
      setTimeout(function () {
        location.reload();
      }, 30);
    }
  }
});

// фильтр период
$("#period_from, #period_to").change(function(e) {
  setCookie(e.target.id, $(this).val(), 1);
  if ($("#period_to").val() && $("#period_from").val()) {
    setTimeout(function () {
      location.reload();
    }, 30);
  }
});

$(".period_from").change(function(e) {
  setCookie("period_from", $(this).val(), 1);
});

$(".period_to").change(function(e) {
  setCookie("period_to", $(this).val(), 1);
});

$("#apply_period").click(function(e) {
  e.preventDefault();
  e.stopPropagation();
  if ($("#periods_mbl").val() === "range") {
    if ($(".period_from").val() && $(".period_to").val()) {
      setTimeout(function () {
        location.reload();
      }, 30);
    } else {
      showError("Заполните поля, выделеные красным.");
      if (!$(".period_from").val()) {
        $(".period_from").css("border-color", "red");
      }
      if (!$(".period_to").val()) {
        $(".period_to").css("border-color", "red");
      }
    }
  } else {
    setTimeout(function () {
      location.reload();
    }, 30);
  }
});

$('#author_select_desk, #team_select').change(function (e) {
  filters_list_show();
  if (e.target.id === 'author_select_desk') {
    //setCookie('filter_trainee', $(this).val(), 1);
    $("#team_select").val("_all_");
  } else if (e.target.id === 'team_select') {
    setCookie('filter_team', $(this).val(), 1);
    $("#author_select_desk").val("_all_");
  }

  let group = '';
  $('.list_string').each(function() {
    group = '';

    if ($('#author_select_desk').val() === '_all_') {
      group = true;
    } else if (trainee_list_full[$('#author_select_desk').val()] && $('#author_select_desk').val() !== '_all_') {
      if (trainee_list_full[$('#author_select_desk').val()]['gospel_team'] === $(this).attr('data-gospel_team') &&  trainee_list_full[$('#author_select_desk').val()]['gospel_group'] === $(this).attr('data-gospel_group')) {
        group = true;
      } else {
        group = false;
      }
    }

    if (group && ($('#team_select').val() === $(this).attr('data-gospel_team') || $('#team_select').val() === '_all_')) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
});

$('#author_select_mbl, #team_select_mbl').change(function (e) {
  filters_list_show();
  if (e.target.id === 'author_select_mbl') {
    $("#team_select_mbl").val("_all_");
  } else if (e.target.id === 'team_select_mbl') {
    setCookie('filter_team', $(this).val(), 1);
    $("#author_select_mbl").val("_all_");
  }

  let group = '';
  $('.list_string').each(function() {
    group = '';

    if ($('#author_select_mbl').val() === '_all_') {
      group = true;
    } else if (trainee_list_full[$('#author_select_mbl').val()] && $('#author_select_mbl').val() !== '_all_') {
      if (trainee_list_full[$('#author_select_mbl').val()]['gospel_team'] === $(this).attr('data-gospel_team') &&  trainee_list_full[$('#author_select_mbl').val()]['gospel_group'] === $(this).attr('data-gospel_group')) {
        group = true;
      } else {
        group = false;
      }
    }

    if (group && ($('#team_select_mbl').val() === $(this).attr('data-gospel_team') || $('#team_select_mbl').val() === '_all_')) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
});

// info of
$("#info_of").click(function () {
  if ($("#date_of_archive").is(":visible")) {
    $("#date_of_archive").parent().hide();
  } else {
    $("#date_of_archive").parent().show();
  }
});

// edit gospel group
$("#gospelGroupNumber").click(function () {
  if ($("#gospel_group_field").is(":visible")) {
    $("#gospel_group_field").hide();
  } else {
    $("#gospel_group_field").show();
  }
});
// смена группы
// Подстановка данных для группы благовестия
$("#gospel_group_field").change(function () {
  $("#gospelGroupNumber").text($(this).val());
  let gospel_group_data = '';
  let gospel_group_data_tmp;
  let i_count = 0;
  for (let i = 0; i < gospel_groups.length; i++) {
    if (gospel_groups[i]) {
      if (gospel_groups[i]['team'] === $("#fio_field").val() && gospel_groups[i]['group'] == Number($(this).val())) {
        gospel_group_data_tmp = trainee_list[gospel_groups[i]['member_key']];
        if (gospel_group_data_tmp) {
          if (i_count > 0) {
            gospel_group_data += ", ";
          }
          gospel_group_data_tmp = gospel_group_data_tmp.split(" ");
          gospel_group_data += gospel_group_data_tmp[0]+" "+gospel_group_data_tmp[1][0]+".";
          i_count++;
        }
      }
    }
  }
  if (gospel_group_data) {
    $("#group_members_field").val(gospel_group_data);
  } else {
    $("#group_members_field").val('');
  }
});
// смена команды
$('#fio_field').change(function () {
  if ($(this).css('border-color') === 'rgb(255, 0, 0)') {
    $(this).css('border-color', 'lightgray');
  }
  // Подстановка данных для группы благовестия
  let gospel_group_data = '';
  let gospel_group_data_tmp;
  let i_count = 0;
  for (let i = 0; i < gospel_groups.length; i++) {
    if (gospel_groups[i]) {
      if (gospel_groups[i]['team'] === $("#fio_field").val() && gospel_groups[i]['group'] == Number($(this).val())) {
        gospel_group_data_tmp = trainee_list[gospel_groups[i]['member_key']];
        if (gospel_group_data_tmp) {
          if (i_count > 0) {
            gospel_group_data += ", ";
          }
          gospel_group_data_tmp = gospel_group_data_tmp.split(" ");
          gospel_group_data += gospel_group_data_tmp[0]+" "+gospel_group_data_tmp[1][0]+".";
          i_count++;
        }
      }
    }
  }
  if (gospel_group_data) {
    $("#group_members_field").val(gospel_group_data);
  } else {
    $("#group_members_field").val('');
  }
});

$(".sort_date, .sort_team, .sort_group").click(function (e) {

  $(".sort_date i, .sort_team i, .sort_group i").addClass("hide_element");
  if ($(this).hasClass("sort_date")) {
    $(".sort_team i").removeClass("fa");
    $(".sort_team i").removeClass("fa-sort-desc");
    $(".sort_team i").removeClass("fa-sort-asc");
    $(".sort_group i").removeClass("fa");
    $(".sort_group i").removeClass("fa-sort-desc");
    $(".sort_group i").removeClass("fa-sort-asc");
  } else if ($(this).hasClass("sort_team")) {
    $(".sort_date i").removeClass("fa");
    $(".sort_date i").removeClass("fa-sort-desc");
    $(".sort_date i").removeClass("fa-sort-asc");
    $(".sort_group i").removeClass("fa");
    $(".sort_group i").removeClass("fa-sort-desc");
    $(".sort_group i").removeClass("fa-sort-asc");
  } else if ($(this).hasClass("sort_group")) {
    $(".sort_team i").removeClass("fa");
    $(".sort_team i").removeClass("fa-sort-desc");
    $(".sort_team i").removeClass("fa-sort-asc");
    $(".sort_date i").removeClass("fa");
    $(".sort_date i").removeClass("fa-sort-desc");
    $(".sort_date i").removeClass("fa-sort-asc");
  }

  $(this).find("i").removeClass("hide_element");

  if ($(this).find("i").hasClass("fa-sort-desc")) {
    $(this).find("i").removeClass("fa-sort-desc").addClass("fa-sort-asc");
    setCookie('sorting', e.target.className + "-desc", 356);
  } else if ($(this).find("i").hasClass("fa-sort-asc")) {
    $(this).find("i").removeClass("fa-sort-asc").addClass("fa-sort-desc");
    setCookie('sorting', e.target.className + "-asc", 356);
  } else {
    $(this).find("i").addClass("fa");
    $(this).find("i").addClass("fa-sort-desc");
    setCookie('sorting', e.target.className + "-asc", 356);
  }
  setTimeout(function () {
    location.reload();
  }, 30);
});

$(".recom_goal").change(function () {
  if ((!trainee_access || ftt_access_trainee) && ($("#team_goal_select").val() !== "_all_" && $("#group_goal_select").val() && $("#group_goal_select").val() !== "_all_")) {
    fetch("ajax/ftt_gospel_ajax.php?type=set_ftt_gospel_goals&gospel_team="+$("#team_goal_select").val()+"&gospel_group="+$("#group_goal_select").val()+"&column="+$(this).attr("data-field")+"&value="+$(this).val())
    .then(response => response.json())
    .then(/*commits => console.log(commits.result)*/);
  }
});
if (!trainee_access) {
  // $(".recom_goal").prop("disabled", false);
} else {
   $("#team_goal_select").prop("disabled", true);
   $("#group_goal_select").prop("disabled", true);
   $(".recom_goal").prop("disabled", true);
}
// team
$("#team_goal_select").change(function () {
// формируем группы
  fetch("ajax/ftt_gospel_ajax.php?type=get_ftt_gospel_groups&gospel_team="+$(this).val())
  .then(response => response.json())
  .then(commits => {
    let html_options = "<option value='_all_'> Все группы";
    for (var i = 0; i < commits.result.length; i++) {
      html_options += "<option value='"+commits.result[i].gospel_group+"'>"+commits.result[i].gospel_group;
    }
    $("#group_goal_select").html(html_options);
    // статисика по комманде
      fetch("ajax/ftt_gospel_ajax.php?type=get_ftt_gospel_goals&gospel_team="+$("#team_goal_select").val()+"&gospel_group=_none_")
      .then(response => response.json())
      .then(commits => {
        let flyers = 0, people = 0, prayers = 0, baptism = 0, fruit = 0;
        for (var i = 0; i < commits.result.length; i++) {
          flyers += Number(commits.result[i].flyers);
          people += Number(commits.result[i].people);
          prayers += Number(commits.result[i].prayers);
          baptism += Number(commits.result[i].baptism);
          fruit += Number(commits.result[i].fruit);
        }
        $("#semester_flyers").val(flyers);
        $("#semester_people").val(people);
        $("#semester_prayers").val(prayers);
        $("#semester_baptism").val(baptism);
        $("#semester_fruit").val(fruit);
      });
  });
});

// group select
$("#group_goal_select").change(function () {
// подставляем значения
  if ($(this).val() !== "_all_") {
    fetch("ajax/ftt_gospel_ajax.php?type=get_ftt_gospel_goals&gospel_team="+$("#team_goal_select").val()+"&gospel_group="+$("#group_goal_select").val())
    .then(response => response.json())
    .then(commits => {
      if (commits.result["gospel_team"]) {
        $("#semester_flyers").val(commits.result.flyers);
        $("#semester_people").val(commits.result.people);
        $("#semester_prayers").val(commits.result.prayers);
        $("#semester_baptism").val(commits.result.baptism);
        $("#semester_fruit").val(commits.result.fruit);
      } else {
        $("#semester_flyers").val(0);
        $("#semester_people").val(0);
        $("#semester_prayers").val(0);
        $("#semester_baptism").val(0);
        $("#semester_fruit").val(0);
      }
    });
  } else {
    // статисика по комманде
      fetch("ajax/ftt_gospel_ajax.php?type=get_ftt_gospel_goals&gospel_team="+$("#team_goal_select").val()+"&gospel_group=_none_")
      .then(response => response.json())
      .then(commits => {
        let flyers = 0, people = 0, prayers = 0, baptism = 0, fruit = 0;
        for (var i = 0; i < commits.result.length; i++) {
          if (commits.result["gospel_team"]) {
            flyers += goals.flyers;
            people += goals.people;
            prayers += goals.prayers;
            baptism += goals.baptism;
            fruit += goals.fruit;
          }
        }
        $("#semester_flyers").val(flyers);
        $("#semester_people").val(people);
        $("#semester_prayers").val(prayers);
        $("#semester_baptism").val(baptism);
        $("#semester_fruit").val(fruit);
      });
  }
});
// Цели благовестия обработчик для служащих


/* ==== MAIN & GOSPEL STOP ==== */

// TRASH ++++++++++++++++++++++++++++++
/*
if (trainee_list_full[$('#author_select').val()]) {
  group.push($('#author_select').val());
  for (key in trainee_list_full) {
    if (trainee_list_full[key]['gospel_team'] === trainee_list_full[$(this).val()]['gospel_team'] && trainee_list_full[$(this).val()]['gospel_group'] === trainee_list_full[key]['gospel_group'] && key !== $('#author_select').val()) {
      group.push(key);
    }
  };
}*/
/*
$('#service_one_select').change(function (e) {
  let group = true;
  $('.list_string').each(function() {
    group = true;

    if ($('#service_one_select').val() === '_all_') {
      group = true;
    } else if (serving_ones_list_full[$('#service_one_select').val()] && $('#service_one_select').val() !== '_all_') {
      if (serving_ones_list_full[$('#service_one_select').val()]['gospel_team'] === $(this).attr('data-gospel_team')) {
        group = true;
      } else {
        group = false;
      }
    }

    if (group && ($('#team_select').val() === $(this).attr('data-gospel_team') || $('#team_select').val() === '_all_')) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
});
*/

// DOCUMENT READY STOP
});
