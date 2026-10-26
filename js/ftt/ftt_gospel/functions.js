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
    // personal blocks
    $(".personal_block").each(function () {
      $(this).remove();
    });
  }
  $(".group_block").show();
}

// validation
function validation_fields(e) {
 // валидация значений полей
 if ($("#modalAddEdit").is(":visible")) {
   if ($('#modalAddEdit #fio_field').val() === '_none_') {
     showError('Заполните поля выделенные красной рамкой.');
     $('#modalAddEdit #fio_field').css('border-color', 'red');
     if ($('#modalAddEdit #date_field').val() === '') {
       $('#modalAddEdit #date_field').css('border-color', 'red');
     }
     e.stopPropagation();
     e.preventDefault();
     return false;
   } else {
     $('#modalAddEdit #fio_field').css('border-color', 'lightgray');
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
     e.stopPropagation();
     e.preventDefault();
     return false;
   }
   return true;
 }
}

// получить данные полей формы
function get_data_fields(send) {
 let data = new FormData();
   if ($("#modalAddEdit").attr("data-id")) {
   data.set('id', $("#modalAddEdit").attr("data-id"));
   }
   data.set('author', $("#modalAddEdit").attr("data-author"));
   data.set('fio_field', $('#fio_field').val());
   data.set('date_field', $('#date_field').val());
   data.set('gospel_group_field', $('#gospel_group_field').val());
   if (send) {
     data.set('status', 1);
   }

   let group_members_list = "";
   // members
   $("#group_members_block input:checked").each(function () {
     if (group_members_list) {
       group_members_list += ",";
     }
      group_members_list += $(this).val();
   });

   // member personal block
   let personal_block_arr = {};
   $(".personal_block").each(function () {
     if (!personal_block_arr.hasOwnProperty($(this).attr("data-member_key"))) {
       personal_block_arr[$(this).attr("data-member_key")] = {first_contacts: "", further_contacts: "", number: ""};
     }
     if ($(this).find("input").hasClass("further_contacts_field")) {
       personal_block_arr[$(this).attr("data-member_key")]["further_contacts"] = $(this).find("input").val();
     } else if ($(this).find("input").hasClass("first_contacts_field")) {
       personal_block_arr[$(this).attr("data-member_key")]["first_contacts"] = $(this).find("input").val();
     } else if ($(this).find("input").hasClass("number_field")) {
       personal_block_arr[$(this).attr("data-member_key")]["number"] = $(this).find("input").val();
     }
   });

   data.set('group_members_field', group_members_list);
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
   data.set('comment_field', $('#comment_field').val());
   data.set('archive_checkbox_field', $('#archive_checkbox_field').val());
   data.set('personal_blocks', JSON.stringify(personal_block_arr));

   return data;
 }

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
               gospel_group_data += "<br>";
             }
             gospel_group_data_tmp = gospel_group_data_tmp.split(" ");
             gospel_group_data += '<label class="form-check-label"><input type="checkbox" class="mr-1" checked value="'+gospel_groups[i]['member_key']+'">'+gospel_group_data_tmp[0]+" "+gospel_group_data_tmp[1][0]+'.</label>';
             i_count++;
           }
         }
       }
     }
   }
   return gospel_group_data;
 }

 // проверка полей бланка
 function check_fields_gospel_blank() {
   if (trainee_access && $("#modalAddEdit").attr("data-author") !== admin_id_gl) {
     showError('Нельзя сохранить.');
     return true;
   }
   // валидация значений полей
   if ($('#fio_field').val() === '_none_' || !$('#modalAddEdit #fio_field').val()) {
     showError('Заполните поля выделенные красной рамкой.');
     $('#fio_field').css('border-color', 'red');
     if ($('#date_field').val() === '') {
       $('#date_field').css('border-color', 'red');
     }
     return true;
   } else {
     $('#fio_field').css('border-color', 'lightgray');
   }

   if ($('#date_field').val() === '') {
     $('#date_field').css('border-color', 'red');
     return true;
   } else {
     $('#date_field').css('border-color', 'lightgray');
   }

   if (!$('#gospel_group_field').val() || $('#gospel_group_field').val() === '0') {
     showError('Не указана группа благовестия.');
     return true;
   }

   if (!$('#modalAddEdit .personal_block').attr("data-member_key")) {
     showError('Добавьте участников в бланк.');
     return true;
   }
   return false;
 }

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

 // смена группы
 // Подстановка данных для группы благовестия
 // dropdown
 function change_team(element) {
   $("#gospel_group_field").val(element.attr("data-group"));
   if (!$(".group_block").is(":visible")) {
     $(".group_block").show();
   }
   $(".group_block input").each(function () {
     $(this).val("");
   });
   $(".personal_block").each(function () {
     $(this).remove();
   });

   $("#gospelGroupNumber").text(element.attr("data-group"));
   let gospel_group_data = '';
   let gospel_group_data_tmp;
   let i_count = 0;
   for (let i = 0; i < gospel_groups.length; i++) {
     if (gospel_groups[i]) {
       if (gospel_groups[i]['team'] === $("#fio_field").val() && gospel_groups[i]['group'] == Number(element.attr("data-group"))) {
         gospel_group_data_tmp = trainee_list[gospel_groups[i]['member_key']];
         if (gospel_group_data_tmp) {
           if (i_count > 0) {
             gospel_group_data += "<br>";
           }
           // checkboxes
           gospel_group_data_tmp = gospel_group_data_tmp.split(" ");
           gospel_group_data += '<label class="form-check-label"> <input type="checkbox" class="mr-1" checked value="'+gospel_groups[i]['member_key']+'">'+gospel_group_data_tmp[0]+" "+gospel_group_data_tmp[1][0]+'.</label>';
           // personal blocks
           add_remove_gospel_personal_block('', gospel_groups[i]['member_key'])
           i_count++;
         }
       }
     }
   }
   if (gospel_group_data) {
     $("#group_members_block").html(gospel_group_data);
   } else {
     $("#group_members_block").html('');
   }
 }

 function check_blank_data() {

   let check_input = 0;
   $(".group_block input").each(function () {
     if ($(this).val()) {
       check_input = 1;
       return;
     }
   });
   if (check_input === 0) {
     $(".personal_block input").each(function () {
       if ($(this).val()) {
         check_input = 1;
         return;
       }
     });
   }
   if (check_input > 0) {
     console.log("I am");
     if (!confirm("Внимание! Данные будут удалены?")) {
       return true;
     }
   }
   return false;
 }

 // dropdown
 function render_dropdown(team) {

   let html_dropdown = "";
   for (var i = 1; i <= global_gospel_groups_unic[team]; i++) {
     html_dropdown += '<span class="dropdown-item cursor-pointer" data-group="'+i+'">'+i+'</span>';
   }

   $("#gospel_group_dropdown_list").html(html_dropdown);
 }

 function add_remove_gospel_personal_block(elem, key) {
   let member_key, checked;
   if (key) {
     member_key = key;
     checked = true;
   } else {
     member_key = elem.val();
     checked = elem.prop("checked");
   }
   if (checked) {
     // add block
     $("#show_gospel_modal_list").before('<div class="row personal_block" data-member_key="'+ member_key
     +'" style="margin-left: -16px; margin-right: -16px;"><div class="col-12 bg-secondary pt-1 pb-1 mb-3">'
     + '<h5 class="d-inline-block text-white mb-0">'+trainee_list[member_key]+'</h5><i class="fa fa-trash text-white" aria-hidden="true" style="cursor:pointer; float:right; font-size:18px; margin-top: 4px;"></i></div><div class="col-12"></div>'
     +'<div class="col-10 mb-3"><label class="label-google">Сколько было выходов в город на благовестие?</label></div><div class="col-2"><input type="number" class="input-google short_number_field number_field text-right" min="0" max="1000000"></div></div></div>'
     +'<div class="row personal_block mb-3" data-member_key="'+ member_key
     +'"><div class="col-10"><label class="label-google">Сколько было <u>новых</u> контактов по телефону или в переписке?</label></div><div class="col-2"><input type="number" class="input-google short_number_field first_contacts_field mt-3 text-right" min="0" max="1000000"></div></div>'
     +'<div class="row personal_block mb-3" data-member_key="'+ member_key
     +'"><div class="col-10"><label class="label-google">Сколько было <u>повторных</u> контактов по телефону или в переписке?</label></div><div class="col-2"><input type="number" class="input-google short_number_field further_contacts_field mt-3 text-right" min="0" max="1000000"></div></div>');
   } else {
     $(".personal_block").each(function () {
       if ($(this).attr("data-member_key") === elem.val()) {
         $(this).remove();
       }
     });
   }
   $(".personal_block i").click(function () {
     let member_key_dlt = $(this).parent().parent().attr("data-member_key");
     // remove personal block
     $(".personal_block").each(function () {
       if ($(this).attr("data-member_key") === member_key_dlt) {
         $(this).remove();
       }
     });
     // remove checkbox
     $("#group_members_block input").each(function () {
       if ($(this).val() === member_key_dlt) {
         $(this).parent().remove();
       }
     });
   });

   // mobile design for dynamic elements
   if ($(window).width()<=769) {
     $("#modalAddEdit .input-google.short_number_field").parent().css("padding-left", "0px");
   }
 }
