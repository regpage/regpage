/* ==== MAIN & GOSPEL START ==== */
$(document).ready(function(){

  // текущая дата гггг.мм.дд
  date_now_gl = date_now_gl ();
  // teams & groups
  global_gospel_groups_unic = [];
  for (const property in gospel_groups) {
    if (property) {
      if (global_gospel_groups_unic[gospel_groups[property]["team"]]) {
        if (gospel_groups[property]["group"] > global_gospel_groups_unic[gospel_groups[property]["team"]]) {
          global_gospel_groups_unic[gospel_groups[property]["team"]]=gospel_groups[property]["group"];
        }
      } else {
        global_gospel_groups_unic[gospel_groups[property]["team"]]=gospel_groups[property]["group"];
      }
    }
  }

let data_strings = ['id', 'date', 'author', 'gospel_team', 'gospel_group', 'place', 'group_members', 'flyers', 'people', 'prayers', 'baptism', 'meets_last', 'meets_current', 'meetings_last', 'meetings_current', 'first_contacts', 'further_contacts', 'homes', 'place_name', 'fgt_place', 'comment'];

$("#statistics_link").click(function () {
  location.pathname = "ftt_gospel_statistic";
});


// ==== ГОТОВО ЗДЕСЬ И ВЫШЕ

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

// Убираем ноль в поле при вводе
$(".recom_goal").click(function () {
  if ($(this).val() === "0") {
    $(this).val("");
  }
});

$('#date_field').change(function () {

  if ($(this).css('border-color') === 'rgb(255, 0, 0)') {
    $(this).css('border-color', 'lightgray');
  }
});

// проверка при закрытиии бланка не по кнопке сохранить
// НОВЫЙ БЛАНК БЛАГОВЕСТИЯ.
$('#modalAddEdit .close').click(function (e) {
  if (($('#fio_field').val() !== $("#modalAddEdit").attr("data-gospel_team") && $('#fio_field').val() !== '_none_') ||
    $('#date_field').val() !== $("#modalAddEdit").attr("data-date") ||
    ($('#gospel_group_field').val() !== $("#modalAddEdit").attr("data-gospel_group") && $('#gospel_group_field').val() !== '0') ||
    $('#flyers_field').val() !== $("#modalAddEdit").attr("data-flyers") ||
    $('#people_field').val() !== $("#modalAddEdit").attr("data-people") ||
    $('#prayers_field').val() !== $("#modalAddEdit").attr("data-prayers") ||
    $('#baptism_field').val() !== $("#modalAddEdit").attr("data-baptism") ||
    $('#meets_last_field').val() !== $("#modalAddEdit").attr("data-meets_last") ||
    $('#meets_current_field').val() !== $("#modalAddEdit").attr("data-meets_current") ||
    $('#meetings_last_field').val() !== $("#modalAddEdit").attr("data-meetings_last") ||
    $('#meetings_current_field').val() !== $("#modalAddEdit").attr("data-meetings_current") ||
    $('#homes_field').val() !== $("#modalAddEdit").attr("data-homes") ||
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

$('#modalAddEdit .modal-footer .close_modal_gospel').click(function (e) {
  // проверка при закрытиии бланка не по кнопке сохранить
  // НЕ ПРОВЕРЯЕТ ПЕРСОНАЛЬНУЮ СТАТИСТИКУ
  if (($('#fio_field').val() !== $("#modalAddEdit").attr("data-gospel_team") && $('#fio_field').val() !== '_none_') ||
    $('#date_field').val() !== $("#modalAddEdit").attr("data-date") ||
    ($('#gospel_group_field').val() !== $("#modalAddEdit").attr("data-gospel_group") && $('#gospel_group_field').val() !== '0') ||
    $('#flyers_field').val() !== $("#modalAddEdit").attr("data-flyers") ||
    $('#people_field').val() !== $("#modalAddEdit").attr("data-people") ||
    $('#prayers_field').val() !== $("#modalAddEdit").attr("data-prayers") ||
    $('#baptism_field').val() !== $("#modalAddEdit").attr("data-baptism") ||
    $('#meets_last_field').val() !== $("#modalAddEdit").attr("data-meets_last") ||
    $('#meets_current_field').val() !== $("#modalAddEdit").attr("data-meets_current") ||
    $('#meetings_last_field').val() !== $("#modalAddEdit").attr("data-meetings_last") ||
    $('#meetings_current_field').val() !== $("#modalAddEdit").attr("data-meetings_current") ||
    $('#homes_field').val() !== $("#modalAddEdit").attr("data-homes") ||
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

$("#add_comment").click(function () {
  $("#add_comment").slideUp();
  $("#comment_block").slideDown();
});

// ГОТОВО
// открыть бланк для добавления правки
$('#showModalAddEdit').click(function () {
  if (trainee_list_full[admin_id_gl] && !trainee_list_full[admin_id_gl]['gospel_team']) {
    showError("Не назначена команда благовестия");
    return;
  } else if (trainee_list_full[admin_id_gl] && trainee_list_full[admin_id_gl]['gospel_group'] == 0) {
    showError("Не назначена группа благовестия");
    return;
  }
  $("#delete_blank_gospel, #save_extra_help, #send_gospel_blank").show();
  $("#show_gospel_modal_list, #gospel_group_dropdown").attr('disabled', false);
  $("#modalAddEdit").modal("show");
  $("#add_comment").show();
  $("#comment_block").hide();
  $("#modalAddEdit input").attr('disabled', false);
  $("#modalAddEdit select").attr('disabled', false);
  $("#modalAddEdit textarea").attr('disabled', false);
  if (trainee_access) {
      $('#fio_field').attr("disabled", true);
  }
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
    $("#group_members_block").html(get_gospel_group_members());
    $("#group_members_block input").each(function () {
      add_remove_gospel_personal_block($(this));
    });
  } else {
    $('#gospelGroupNumber').text("");
    $("#modalAddEdit").attr("data-gospel_team", serving_ones_list_full[admin_id_gl]['gospel_team']);
    if (serving_ones_list_full[admin_id_gl]['gospel_team']) {
      $('#fio_field').val(serving_ones_list_full[admin_id_gl]['gospel_team']);
    } else {
      $('#fio_field').val("_none_");
    }
  }

  $('#info_of').hide();
  if (!$("#gospel_group_field").val() || $("#gospel_group_field").val() === '0') {
    $(".group_block").hide();
  } else if (!$(".group_block").is(":visible")) {
    $(".group_block").show();
  }

  // dropdown
  render_dropdown($("#fio_field").val());

  $("#gospel_group_dropdown_list .dropdown-item").click(function () {
    if ($(this).attr("data-group") === $("#gospel_group_field").val()) {
      return;
    }
    if (!check_blank_data()) {
      change_team($(this));
    }
  });
});

// удалить доп задание
$('#delete_blank_gospel').click(function () {
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

// save & send
$('#save_extra_help, #send_gospel_blank').click(function (e) {
  // проверяем бланк
  if (check_fields_gospel_blank()) {
    return;
  }

  let check = 0, counter = 0, error;
  $(".personal_block input").each(function () {
    counter++;
    check += Number($(this).val());
    if (counter===3) {
      if (check === 0) {
        showError("Поля участника " + trainee_list[$(this).parent().parent().attr("data-member_key")] + " не заполнены. Заполнните или удалите этот блок участника.");
        error = 1;
        return;
      }
      check = 0;
      counter = 0;
    }
  });
  if (error === 1) {
    return;
  }
  if ($(this).attr("id") === "send_gospel_blank") {
    save_data_blank(true);
  } else {
    save_data_blank();
  }

});

// клик по строке, загружаем форму
$(".list_string").click(function () {
  if ($(this).attr("data-author") !== admin_id_gl) {
    // $("#modalAddEdit input").attr('disabled', false);
    // $("#modalAddEdit select").attr('disabled', false);
    // $("#modalAddEdit textarea").attr('disabled', false);
  }
  if ($(this).attr('data-status') === "1" && trainee_access) {
    $("#modalAddEdit input").attr('disabled', true);
    $("#modalAddEdit select").attr('disabled', true);
    $("#modalAddEdit textarea").attr('disabled', true);
    $("#delete_blank_gospel, #save_extra_help, #send_gospel_blank").hide();
    $("#show_gospel_modal_list, #gospel_group_dropdown").attr('disabled', true);
  } else if ($(this).attr('data-status') === "1" && !trainee_access) {
    $("#send_gospel_blank").hide();
    $("#delete_blank_gospel, #save_extra_help").show();
    $("#show_gospel_modal_list, #gospel_group_dropdown").attr('disabled', false);
  } else  {
    $("#delete_blank_gospel, #save_extra_help, #send_gospel_blank").show();
    $("#show_gospel_modal_list, #gospel_group_dropdown").attr('disabled', false);
  }
  if (trainee_access) {
      $('#fio_field').attr("disabled", true);
  }
  $('#modalUniTitle').text('Статистика благовестия');
  $('#gospelGroupNumber').text($(this).attr('data-gospel_group'));

// fill
  // fields
  $('#fio_field').val($(this).attr('data-gospel_team'));
  $('#date_field').val($(this).attr('data-date'));
  $('#gospel_group_field').val($(this).attr('data-gospel_group'));
  $("#group_members_block").html(get_gospel_group_members());
/*
  for (var i = 0; i < group_members.length; i++) {
    if (i > 0) {
      list_group += ", ";
    }
     group_members_one = group_members[i];
     list_group += trainee_list[group_members_one.trim()];
  }
*/

  let group_members_list_html = "";
  if ($(this).attr('data-group_members')) {
    let group_members_list_render = $(this).attr('data-group_members');
    group_members_list_render = group_members_list_render.split(",");
    for (var i = 0; i < group_members_list_render.length; i++) {
      // add checkbox
      group_members_list_html += '<label class="form-check-label"><input type="checkbox" class="mr-1" value="'+group_members_list_render[i].trim()+'" data-name="'+
      trainee_list[group_members_list_render[i].trim()]
      +'" checked>'
      +trainee_list[group_members_list_render[i].trim()]+'</label><br>';
      // add block
      if (group_members_list_render[i].trim()) {
        add_remove_gospel_personal_block('', group_members_list_render[i].trim());
      }
    }
    if ($(this).attr('data-status') === "1") {
      $(".personal_block .fa-trash").hide();
    }
  }
  $('#group_members_block').html(group_members_list_html);
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
  //$("#modalAddEdit").attr("data-number", $(this).attr("data-number"));
  $("#modalAddEdit").attr("data-flyers", $(this).attr("data-flyers"));
  $("#modalAddEdit").attr("data-people", $(this).attr("data-people"));
  $("#modalAddEdit").attr("data-prayers", $(this).attr("data-prayers"));
  $("#modalAddEdit").attr("data-baptism", $(this).attr("data-baptism"));
  $("#modalAddEdit").attr("data-meets_last", $(this).attr("data-meets_last"));
  $("#modalAddEdit").attr("data-meets_current", $(this).attr("data-meets_current"));
  $("#modalAddEdit").attr("data-meetings_last", $(this).attr("data-meetings_last"));
  $("#modalAddEdit").attr("data-meetings_current", $(this).attr("data-meetings_current"));
  //$("#modalAddEdit").attr("data-first_contacts", $(this).attr("data-first_contacts"));
  //$("#modalAddEdit").attr("data-further_contacts", $(this).attr("data-further_contacts"));
  $("#modalAddEdit").attr("data-homes", $(this).attr("data-homes"));
  $("#modalAddEdit").attr("data-place_name", $(this).attr("data-place_name"));
  $("#modalAddEdit").attr("data-fgt_place", $(this).attr("data-fgt_place"));
  $("#modalAddEdit").attr("data-status", $(this).attr("data-status"));
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
  $("#group_members_block input").change(function () {
    add_remove_gospel_personal_block($(this));
  });
  // save personal block
  if ($(this).attr('data-group_members')) {
    fetch("ajax/ftt_gospel_ajax.php?type=get_gospel_members&id=" + $(this).attr("data-id"))
    .then(response => response.json())
    .then(commits => {
      let members_data = commits.result;
      for (var i = 0; i < members_data.length; i++) {
        $(".personal_block[data-member_key='" + members_data[i]['member_key']
        + "']").find(".first_contacts_field").val(members_data[i]['first_contacts']);
        $(".personal_block[data-member_key='" + members_data[i]['member_key']
        + "']").find(".further_contacts_field").val(members_data[i]['further_contacts']);
        $(".personal_block[data-member_key='" + members_data[i]['member_key']
        + "']").find(".number_field").val(members_data[i]['number']);
      }
    });
  }
  render_dropdown($('#fio_field').val());
  $("#gospel_group_dropdown_list .dropdown-item").click(function () {
    if ($(this).attr("data-group") === $("#gospel_group_field").val()) {
      return;
    }
    if (!check_blank_data()) {
      change_team($(this));
    }
  });
});

filters_list_show();

  $("#print_modal_open").click(function () {
    statistics_counter();
  });

  $("#print_modal_dates_open").click(function () {
    statistics_dates();
  });

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

      // получаем состав группы
      fetch("ajax/ftt_gospel_ajax.php?type=get_ftt_group_members&gospel_team="+$(this).val()
      +"&gospel_group=_all_")
      .then(response => response.json())
      .then(commits => {
        let html_list = "";
        let rere = commits.result;
        for (let something in rere) {
          if (rere.hasOwnProperty(something)) {
            for (let i = 0; i < rere[something].length; i++) {
              if (i === 0) {
                html_list += "<br><span>"+rere[something][i]["gospel_group"]+ ": "+
                fullNameToShortFirstMiddleNames(rere[something][i]["name"], true) +"</span>";
              } else {
                html_list += "<span>, "+
                fullNameToShortFirstMiddleNames(rere[something][i]["name"], true) +"</span>";
              }
            }
          }
        }
        $("#members_groups_print").html(html_list);
      });
    } else {
      if ($("#period_from_print").val() && $("#period_to_print").val()) {
        statistics_counter();

        if (e.target.id === "group_select_print" && $(this).val()) {
          $("#group_number_print").text("Группа "+$(this).val());
          // получаем состав группы
          fetch("ajax/ftt_gospel_ajax.php?type=get_ftt_group_members&gospel_team="+$("#team_select_print").val()
          +"&gospel_group="+$(this).val())
          .then(response => response.json())
          .then(commits => {
            let html_list = "";
            let rere = commits.result;
            for (let something in rere) {
              if (rere.hasOwnProperty(something)) {
                for (let i = 0; i < rere[something].length; i++) {
                  if (i === 0) {
                    html_list += "<br><span>"+rere[something][i]["gospel_group"]+ ": "+
                    fullNameToShortFirstMiddleNames(rere[something][i]["name"], true) +"</span>";
                  } else {
                    html_list += "<span>, "+
                    fullNameToShortFirstMiddleNames(rere[something][i]["name"], true) +"</span>";
                  }
                }
              }
            }
            $("#members_groups_print").html(html_list);
          });
        }
      }
    }
  });

  $("#print_button, #print_button_dates").click(function () {

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
    if ($(this).attr("id") === "print_button") {
      printElem("#gospel_body_print");
    } else if ($(this).attr("id") === "print_button_dates") {
      printElem("#gospel_report_dates");
    }

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
      let temp_data_group_members = $(this).attr('data-group_members');
      let data_group_members_find_result = false;
      if (temp_data_group_members && $('#author_select_desk').val()) {
         data_group_members_find_result = temp_data_group_members.includes($('#author_select_desk').val())
      }
      if (trainee_list_full[$('#author_select_desk').val()]['gospel_team'] === $(this).attr('data-gospel_team')
        && trainee_list_full[$('#author_select_desk').val()]['gospel_group'] === $(this).attr('data-gospel_group')
      || data_group_members_find_result) {
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



// смена команды
$('#fio_field').change(function () {
  $("#gospel_group_field").val(0);
  $("#gospelGroupNumber").text("");
  $(".group_block").hide();
  render_dropdown($(this).val());
  $("#gospel_group_dropdown_list .dropdown-item").click(function () {
    if (!check_blank_data()) {
      change_team($(this));
    }
  });

  if ($(this).css('border-color') === 'rgb(255, 0, 0)') {
    $(this).css('border-color', 'lightgray');
  }
  $(".personal_block").each(function () {
    $(this).remove();
  });
  $("#group_members_block").html('');
});

// смена группы
$("#gospel_group_dropdown_list .dropdown-item").click(function () {
  if ($(this).attr("data-group") === $("#gospel_group_field").val()) {
    return;
  }
  if (!check_blank_data()) {
    change_team($(this));
  }
});
// ==== BEGIN новый блок участников в бланке отчётности ====
$("#modal_extra_groups input[type='checkbox']").change(function () {
  let elem = $(this);
  if (elem.prop("checked")) {
    // add checkbox
    $("#group_members_block").append("<label class='form-check-label'><input type='checkbox' class='mr-1' data-name='" +
    elem.attr("data-0")+"' value='" + elem.val() + "' checked>" +
    elem.attr("data-0") +"</label><br>");
  } else {
    // remove checkbox
    $("#group_members_block input").each(function () {
      if ($(this).val() === elem.val()) {
        $(this).parent().remove();
      }
    });
  }
  // pessonal blocks add / remove
  add_remove_gospel_personal_block(elem);
  $("#group_members_block input").change(function () {
    add_remove_gospel_personal_block($(this));
  });
});

$("#show_gospel_modal_list").click(function () {
  let members_group = [];
  $("#group_members_block input").each(function (e) {
    members_group[e] = $(this).val();
  });

  $("#modal_extra_groups input[type='checkbox']").each(function () {
    if (members_group.includes($(this).val())) {
      $(this).prop("checked", "true");
    }
  });
});
// ==== END новый блок участников в бланке отчётности ====

// ==== СОРТИРОВКА ====
$(".sort_col").click(function (e) {
  let classes = e.target.className;
  classes = classes.split(" ");
  if ($(this).find("i").hasClass("fa")) {
    if ($(this).find("i").hasClass("fa-sort-desc")) {
      $(this).find("i").removeClass("fa-sort-desc").addClass("fa-sort-asc");
      setCookie('sorting', classes[1] + "-desc", 356);
    } else if ($(this).find("i").hasClass("fa-sort-asc")) {
      $(this).find("i").removeClass("fa-sort-asc").addClass("fa-sort-desc");
      setCookie('sorting', classes[1] + "-asc", 356);
    }
  } else {
    $(".sort_col i").removeClass("fa");
    $(".sort_col i").removeClass("fa-sort-desc");
    $(".sort_col i").addClass("hide_element");
    $(this).find("i").removeClass("hide_element");
    $(this).find("i").addClass("fa");
    $(this).find("i").addClass("fa-sort-desc");
    setCookie('sorting', classes[1] + "-asc", 356);
  }

  setTimeout(function () {
    location.reload();
  }, 30);
});

/*
$(".recom_goal").change(function () { //(!trainee_access || ftt_access_trainee) &&
  if (($("#team_goal_select").val() !== "_all_" && $("#group_goal_select").val() !== "_all_")) {
    fetch("ajax/ftt_gospel_ajax.php?type=set_ftt_gospel_goals&gospel_team="+$("#team_goal_select").val()+"&gospel_group="+$("#group_goal_select").val()+"&column="+$(this).attr("data-field")+"&value="+$(this).val())
    .then(response => response.json())
    .then(commits => console.log(commits.result));
  }
});
*/

if (trainee_access) {
  $("#team_goal_select").prop("disabled", true);
  $("#group_goal_select").prop("disabled", true);
  //$(".recom_goal").prop("disabled", true);
} else {
  // $(".recom_goal").prop("disabled", false);
}
// team
$("#team_goal_select").change(function () {
  $("#modalRecommended").find("input").attr("disabled", true);
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
// блокировка полей
  $("#modalRecommended").find("input").attr("disabled", true);
// подставляем значения
  if ($(this).val() !== "_all_") {
    fetch("ajax/ftt_gospel_ajax.php?type=get_ftt_gospel_goals&gospel_team="+$("#team_goal_select").val()+"&gospel_group="+$("#group_goal_select").val())
    .then(response => response.json())
    .then(commits => {
      $("#modalRecommended").find("input").attr("disabled", false);
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
        for (let i = 0; i < commits.result.length; i++) {
          if (commits.result[i].gospel_team) {
            flyers += Number(commits.result[i].flyers);
            people += Number(commits.result[i].people);
            prayers += Number(commits.result[i].prayers);
            baptism += Number(commits.result[i].baptism);
            fruit += Number(commits.result[i].fruit);
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

$("#mdl_btn_goals_save").click(function () {
  if (($("#team_goal_select").val() !== "_all_" && $("#group_goal_select").val() !== "_all_")) {
    fetch("ajax/ftt_gospel_ajax.php?type=set_ftt_gospel_goals&gospel_team=" + $("#team_goal_select").val() + "&gospel_group=" +$("#group_goal_select").val()
    + "&flyers=" + $("#semester_flyers").val()
    + "&people=" + $("#semester_people").val()
    + "&prayers=" + $("#semester_prayers").val()
    + "&baptism=" + $("#semester_baptism").val()
    + "&fruit=" + $("#semester_fruit").val())
    .then(response => response.json())
    .then(commits => {
      $("#modalRecommended").modal("hide");
    });
  } else {
    showError("Выберите команду и группу.");
  }
});

// DOCUMENT READY STOP
});
