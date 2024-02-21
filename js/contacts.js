// Contacts JS

$(document).ready(function(){

  // переход на карточку, для реализации событие клик на строке нужно переместить в функцию
  // РНР закомментирован
  /*if (idBlankGet) {
    setTimeout(function () {
      let get_str = $(".contacts_str[data-id='" + idBlankGet + "']");
    }, 1000);
  }*/

  if (data_page.admin_contacts_role === '0') { // 09-06-2022  admin_role
    $('#responsibleContact').html('<option value="'+window.adminId+'">'+fullNameToNoMiddleName(data_page.admin_name)+'');
  } else {
    /*var checkOption;
    $('#responsibleContact option').each(function() {
      if ($(this).val() === window.adminId) {
        checkOption = 1;
        $('#responsibleContact').val(window.adminId);
      }
    });
    if (!checkOption) {
      $('#responsibleContact').append('<option value="'+window.adminId+'">'+fullNameToNoMiddleName(data_page.admin_name)+'');
      $('#respShow').append('<option value="'+window.adminId+'">'+fullNameToNoMiddleName(data_page.admin_name)+'');
      $('#responsibleList').append('<option value="'+window.adminId+'">'+fullNameToNoMiddleName(data_page.admin_name)+'');
    }*/
  }

function contactsStringsLoad(x, idStr, sort) {
 if (!sort) {
  var tableData=[],tableDataMbl=[];
  function statusSwitch(x) {
    var result = '-';
    switch (x) {
      case '1':
      result = 'Недозвон';
      break;
      case '2':
      result = 'Ошибка';
      break;
      case '3':
      result = 'Отказ';
      break;
      case '4':
      result = 'Заказ';
      break;
      case '5':
      result = 'Продолжение';
      break;
      case '6':
      result = 'Завершение';
      break;
      case '7':
      result = 'В работе';
      break;
    }
    return result
  }

  var newString, prevAdm, dateorder, datesending, idStrMbl = '', idStrDsk = '',respChange = false;
  data_page.responsible_previous = [];
  for (var i = 0; i < x.length; i++) {

    idStrMbl = '';
    idStrDsk = '';

    if ($(window).width()>=769) {
      idStrDsk = idStr;
    } else {
      idStrMbl = idStr;
    }

    data_page.responsible_previous[x[i].responsible_previous] = x[i].responsible_previous;
    if (data_page.admin_contacts_role > 0) {
      !data_page.full_admin_list[x[i].responsible_previous] ? prevAdm = data_page.full_admin_list[x[i].responsible_previous] : prevAdm = data_page.full_admin_list[x[i].responsible_previous][0];
    } else {
      !data_page.full_admin_list[x[i].responsible_previous] ? prevAdm = data_page.full_admin_list[x[i].responsible_previous] : prevAdm = data_page.full_admin_list[x[i].responsible_previous][0];
    }
// ADD new responsibles in the list

    if (!data_page.members_responsibles[x[i].responsible_previous] && x[i].responsible_previous) {
      if (!data_page.full_admin_list[x[i].responsible]) {
        console.log('Error. Responsible is undefined');
        //data_page.members_responsibles[x[i].responsible_previous] = data_page.full_admin_list[x[i].responsible_previous];
      } else {
        //data_page.members_responsibles[x[i].responsible_previous] = data_page.full_admin_list[x[i].responsible_previous][0];
        respChange = true;
      }
    }

    if (!data_page.members_responsibles[x[i].responsible] && x[i].responsible) {
      if (!data_page.full_admin_list[x[i].responsible]) {
          console.log('Error. Responsible is undefined');
          data_page.members_responsibles[x[i].responsible] = data_page.full_admin_list[x[i].responsible];
      } else {
        data_page.members_responsibles[x[i].responsible] = data_page.full_admin_list[x[i].responsible][0];
        respChange = true;
      }
    }

// STOP ADD new responsibles in the list
// Режет только тут возможно как то влияет на источник.
    prevAdm ? prevAdm = fullNameToNoMiddleName(prevAdm) : prevAdm = '';
    statusSwitch(x[i].status);
    tempCom = x[i].comment;
    var comSlice = '';
    if (tempCom[1] && tempCom.indexOf('\n') >= 30) {
      comSlice = tempCom.slice(0,30) + '...';
    } else if (tempCom[1] && tempCom.indexOf('\n') < 30) {
      var pos = tempCom.indexOf('\n');
      comSlice = tempCom.slice(0,pos) + '...';
    }
    if (x[i].order_date === null || x[i].order_date === '' || x[i].order_date === 'null' || x[i].order_date === undefined || x[i].order_date === 'undefined') {
      dateorder = '';
    } else {
      dateorder = x[i].order_date.slice(0,10);
      dateorder = dateStrToddmmyyyyToyyyymmdd(dateorder, true);
    }
    if (x[i].sending_date === null || x[i].sending_date === '' || x[i].sending_date === 'null' || x[i].sending_date === undefined || x[i].sending_date === 'undefined') {
      datesending = '';
    } else {
      datesending = x[i].sending_date;
    }
    x[i].notice === '1' && x[i].responsible === window.adminId ? newString = 'bg-notice-string ' : newString = '';

    tableData.push('<tr class="'+newString+'contacts_str '+(idStrDsk === x[i].id ? 'active_string' : '')+' cursor-pointer" data-id="'+x[i].id+'" data-crm_id="'+x[i].crm_id+'" data-responsible_name ="'+x[i].member_name+'" data-other="'+(x[i].comment === ' '? '' : x[i].comment)+'"  data-date="'+x[i].time_stamp+'" data-index_post="'+x[i].index_post+'" data-address="'+(x[i].address === ' ' ? '' : x[i].address)+'" data-area="'+(x[i].area === ' ' ? '' : x[i].area)+'" data-country_key="'+x[i].country_key+'" data-email="'+x[i].email+'" data-male="'+x[i].male+'" data-order_date="'+dateorder+'" data-region="'+(x[i].region === ' ' ? '' : x[i].region)+'" data-region_work="'+(x[i].region_work === ' ' ? '': x[i].region_work)+'" data-responsible="'+x[i].responsible+'" data-responsible_previous="'+x[i].responsible_previous+'" data-responsible_previous_name="'+prevAdm+'" data-sending_date="'+datesending+'" data-status_key="'+x[i].status+'" data-period="'+x[i].project+'"><td><input class="checkboxString" type="checkbox"></td><td><span class="data_name">'+x[i].name+'</span><br><span class="grey_text short_comment" style="margin-left: 0">'+comSlice+'</span></td><td><span  class="data_locality">'+(x[i].locality === ' ' ? '' : x[i].locality)+'</span><br><span class="grey_text region_text" style="margin-left: 0">'+x[i].region+'</span></td><td class="data_phone">'+x[i].phone+'</td><td><span class="data_status">'+statusSwitch(x[i].status)+'</span><br><span class="grey_text" style="margin-left: 0">'+x[i].project+'</span></td><td><span class="data_responsible_sort_name">'+fullNameToNoMiddleName(x[i].member_name)+'</span>'+(x[i].notice === '2' ? ' <i class="fa fa-undo cursor-pointer" aria-hidden="true" data-id="'+x[i].id+'" title="Кликните здесь, чтобы восстановить контакт из корзины."></i>' : '')+(x[i].notice === '3' ? ' <i class="fa fa-archive cursor-pointer" aria-hidden="true" data-id="'+x[i].id+'" title="Кликните здесь, чтобы восстановить контакт из архива."></i>' : '')+'<br><span class="data_responsible_previous grey_text">'+prevAdm+'</span></td></tr>');

    tableDataMbl.push('<div style="border-bottom: 1px solid lightgrey; padding-bottom: 5px; padding-top: 5px;" class="'+newString+'contacts_str cursor-pointer '+(idStrMbl === x[i].id ? 'active_string' : '')+'" data-id="'+x[i].id+'" data-crm_id="'+x[i].crm_id+'" data-responsible_name ="'+x[i].member_name+'" data-other="'+(x[i].comment === ' '? '' : x[i].comment)+'"  data-date="'+x[i].time_stamp+'" data-index_post="'+x[i].index_post+'" data-address="'+(x[i].address === ' ' ? '' : x[i].address)+'" data-area="'+(x[i].area === ' ' ? '' : x[i].area)+'" data-country_key="'+x[i].country_key+'" data-email="'+x[i].email+'" data-male="'+x[i].male+'" data-order_date="'+dateorder+'" data-region="'+(x[i].region === ' ' ? '' : x[i].region)+'" data-region_work="'+(x[i].region_work === ' ' ? '': x[i].region_work)+'" data-responsible="'+x[i].responsible+'" data-responsible_previous="'+x[i].responsible_previous+'" data-responsible_previous_name="'+prevAdm+'" data-sending_date="'+datesending+'" data-status_key="'+x[i].status+'" data-period="'+x[i].project+'"><div><input class="checkboxString" type="checkbox" style="vertical-align: middle; margin-right: 10px;"><span> <b class="data_name">'+x[i].name+'</b> </span><br><span  class="data_locality" style="padding-left: 30px;">'+(x[i].locality === ' ' ? '' : x[i].locality)+'</span><span>, </span><span class="" style="margin-left: 0"> '+x[i].region+' </span></div><div class="data_phone" style="padding-left: 30px;"> <a href="tel:+'+x[i].phone+'">'+x[i].phone+'</a></div><div><span class="data_status" style="padding-left: 30px;">'+(statusSwitch(x[i].status) === '-' ? '' : statusSwitch(x[i].status)) +'</span>'+(x[i].notice === '2' ? '<i class="fa fa-undo cursor-pointer" aria-hidden="true" data-id="'+x[i].id+'" title="Кликните здесь, чтобы восстановить контакт." style="font-size: 18px;"></i>' : '')+(x[i].notice === '3' ? ' <i class="fa fa-archive cursor-pointer" aria-hidden="true" data-id="'+x[i].id+'" title="Кликните здесь, чтобы восстановить контакт из архива." style="font-size: 18px;"></i>' : '')+'</div></div>');
  }


// Фильтрация и добавление контактов не указанных у ответственного но имеющиеся в списке отключены
// THIS CODE SHOULD BE CHANCHED
// Проверить и убрать лишнюю фильтрацию, если динамично не добавляются ответственные из карточек
  if (respChange) {
    var sortable = [];

    for (var vehicle in data_page.members_responsibles) {
        sortable.push([vehicle, data_page.members_responsibles[vehicle]]);
    }

    sortable.sort(function(a, b) {
      if (a[1] > b[1]) {
        return 1;
      }
      if (a[1] < b[1]) {
        return -1;
      }
      return 0;
    });

    var options = [];
    options.push('<option selected value="_all_">Все ответственные');
    for (var variable17 = 0; variable17 < sortable.length; variable17++) {
        options.push('<option value="'+sortable[variable17][0]+'">'+fullNameToNoMiddleName(sortable[variable17][1])+'');
    }

    $('#respShow').html(options);
    options[0] = '<option selected value="_all_">';
    //$('#responsibleList').html(options);
    options.shift();
    $('#responsibleContact').html(options);
  }

   $('#listContacts tbody').html(tableData);
   $('#listContactsMbl').html(tableDataMbl);
 } else {
// Sort Start
   var stringsArr =[], tableDataSort=[], tableDataMblSort=[], isDsk = true;

   if ($(window).width()<769) {
     isDsk = false;
   }
   $('#desctop_visible .contacts_str').each(function() {
//attr & classes
   stringsArr.push ({
     id : $(this).attr('data-id'),
     crm_id : $(this).attr('data-crm_id'),
     responsible_name : $(this).attr('data-responsible_name'),
     other : $(this).attr('data-other'),
     time_stamp : $(this).attr('data-date'),
     index_post : $(this).attr('data-index_post'),
     address : $(this).attr('data-address'),
     area : $(this).attr('data-area'),
     country_key : $(this).attr('data-country_key'),
     email : $(this).attr('data-email'),
     male : $(this).attr('data-male'),
     order_date : $(this).attr('data-order_date'),
     region : $(this).attr('data-region'),
     region_work : $(this).attr('data-region_work'),
     responsible : $(this).attr('data-responsible'),
     responsible_previous : $(this).attr('data-responsible_previous'),
     responsible_previous_name : $(this).attr('data-responsible_previous_name'),
     sending_date : $(this).attr('data-sending_date'),
     status_key : $(this).attr('data-status_key'),
     name : $(this).find('.data_name').text(),
     shortComment : $(this).find('.short_comment').text(),
     locality : $(this).find('.data_locality').text(),
     regionText : $(this).find('.region_text').text(),
     data_phone: $(this).find('.data_phone').text(),
     data_status: $(this).find('.data_status').text(),
     responsible_sort_name: $(this).find('.data_responsible_sort_name').text(),
     responsible_previous_short_name: $(this).find('.data_responsible_previous').text(),
     active_string: $(this).hasClass('active_string'),
     notice: $(this).hasClass('bg-notice-string'),
     project: $(this).attr('data-period')
   });
 });

 if (sort === 'sortingByName') {
   stringsArr.sort(function (a, b) {
     if (a.name < b.name) {
       return 1;
     }
     if (a.name > b.name) {
       return -1;
     }
     return 0;
   });
 } else if (sort === 'sortingByName2') {
   stringsArr.sort(function (a, b) {
     if (a.name > b.name) {
       return 1;
     }
     if (a.name < b.name) {
       return -1;
     }
     return 0;
   });
 } else if (sort === 'sortingByLocality') {
   stringsArr.sort(function (a, b) {
     if (a.locality.toLowerCase() < b.locality.toLowerCase()) {
       return 1;
     }
     if (a.locality.toLowerCase() > b.locality.toLowerCase()) {
       return -1;
     }
     return 0;
   })
 } else if (sort === 'sortingByLocality2') {
     stringsArr.sort(function (a, b) {
       if (a.locality.toLowerCase() > b.locality.toLowerCase()) {
         return 1;
       }
       if (a.locality.toLowerCase() < b.locality.toLowerCase()) {
         return -1;
       }
       return 0;
     });
   }
   for (var i = 0; i < stringsArr.length; i++) {

   tableDataSort.push('<tr class="'+(stringsArr[i].notice ? 'bg-notice-string ' : '')+'contacts_str '+(stringsArr[i].active_string && isDsk ? 'active_string' : '')+' cursor-pointer" data-id="'+stringsArr[i].id+'" data-crm_id="'+stringsArr[i].crm_id+'" data-responsible_name ="'+stringsArr[i].responsible_name+'" data-other="'+ stringsArr[i].other+'"  data-date="'+stringsArr[i].time_stamp+'" data-index_post="'+stringsArr[i].index_post+'" data-address="'+stringsArr[i].address+'" data-area="'+stringsArr[i].area+'" data-country_key="'+stringsArr[i].country_key+'" data-email="'+stringsArr[i].email+'" data-male="'+stringsArr[i].male+'" data-order_date="'+stringsArr[i].order_date+'" data-region="'+stringsArr[i].region+'" data-region_work="'+stringsArr[i].region_work+'" data-responsible="'+stringsArr[i].responsible+'" data-responsible_previous="'+stringsArr[i].responsible_previous+'" data-responsible_previous_name="'+stringsArr[i].responsible_previous_name+'" data-sending_date="'+stringsArr[i].sending_date+'" data-status_key="'+stringsArr[i].status_key+'" data-period="'+stringsArr[i].project+'"><td><input class="checkboxString" type="checkbox"></td><td><span class="data_name">'+stringsArr[i].name+'</span><br><span class="grey_text short_comment" style="margin-left: 0">'+stringsArr[i].shortComment+'</span></td><td><span  class="data_locality">'+stringsArr[i].locality+'</span><br><span class="grey_text region_text" style="margin-left: 0">'+stringsArr[i].region+'</span></td><td class="data_phone">'+stringsArr[i].data_phone+'</td><td><span class="data_status">'+stringsArr[i].data_status+'</span><br><span class="grey_text" style="margin-left: 0">'+stringsArr[i].project+'</span></td><td><span class="data_responsible_sort_name">'+stringsArr[i].responsible_sort_name+'</span>'+(stringsArr[i].notice === '2' ? ' <i class="fa fa-undo cursor-pointer" aria-hidden="true" data-id="'+stringsArr[i].id+'" title="Кликните здесь, чтобы восстановить контакт."></i>' : '')+(x[i].notice === '3' ? ' <i class="fa fa-archive cursor-pointer" aria-hidden="true" data-id="'+x[i].id+'" title="Кликните здесь, чтобы восстановить контакт из архива."></i>' : '')+'<br><span class="data_responsible_previous grey_text">'+stringsArr[i].responsible_previous_short_name+'</span></td></tr>');

   tableDataMblSort.push('<div style="border-bottom: 1px solid lightgrey; padding-bottom: 5px; padding-top: 5px;" class="'+(stringsArr[i].notice ? 'bg-notice-string ' : '')+'contacts_str cursor-pointer" data-id="'+stringsArr[i].id+'" data-crm_id="'+stringsArr[i].crm_id+'" data-responsible_name ="'+stringsArr[i].responsible_name+'" data-other="'+stringsArr[i].other+'"  data-date="'+stringsArr[i].time_stamp+'" data-index_post="'+stringsArr[i].index_post+'" data-address="'+(stringsArr[i].address === ' ' ? '' : stringsArr[i].address)+'" data-area="'+(stringsArr[i].area === ' ' ? '' : stringsArr[i].area)+'" data-country_key="'+stringsArr[i].country_key+'" data-email="'+stringsArr[i].email+'" data-male="'+stringsArr[i].male+'" data-order_date="'+stringsArr[i].order_date+'" data-region="'+(stringsArr[i].region === ' ' ? '' : stringsArr[i].region)+'" data-region_work="'+stringsArr[i].region_work+'" data-responsible="'+stringsArr[i].responsible+'" data-responsible_previous="'+stringsArr[i].responsible_previous+'" data-responsible_previous_name="'+stringsArr[i].responsible_previous_name+'" data-sending_date="'+stringsArr[i].sending_date+'" data-status_key="'+stringsArr[i].status_key+'" data-period="'+stringsArr[i].project+'"><div><input class="checkboxString" type="checkbox"><span> <b class="data_name">'+stringsArr[i].name+'</b> </span><br><span  class="data_locality" style="padding-left: 20px;"> '+stringsArr[i].locality+'</span><span>, </span></span><span class="" style="margin-left: 0"> '+stringsArr[i].region+' </span></div><div class="data_phone" style="padding-left: 17px;"> <a href="tel:'+stringsArr[i].data_phone+'">'+stringsArr[i].data_phone+'</a></div><div><span class="data_status" style="padding-left: 17px;">'+stringsArr[i].data_status+'</span>'+(stringsArr[i].notice === '2' ? '<i class="fa fa-undo cursor-pointer" aria-hidden="true" data-id="'+stringsArr[i].id+'" title="Кликните здесь, чтобы восстановить контакт." style="font-size: 18px;"></i>' : '')+(x[i].notice === '3' ? ' <i class="fa fa-archive cursor-pointer" aria-hidden="true" data-id="'+x[i].id+'" title="Кликните здесь, чтобы восстановить контакт из архива." style="font-size: 18px;"></i>' : '')+'</div></div>');

 }
  $('#listContacts tbody').html(tableDataSort);
  $('#listContactsMbl').html(tableDataMblSort);
 }
 // Sort END
    $('#msgChatSend').click(function() {
      if ($('#kindOfList').val() === 'trash') {
        showError('Операции с карточками в корзине запрещены, сначала восстановите карточку.');
        return;
      }
      if (!$('#msgChatText').val() || !$('#saveContact').attr('data-id')) {
        return
      }
      var dataMsg ={
        text: $('#msgChatText').val(),
        id: $('#saveContact').attr('data-id')
      };
      $.get('/ajax/contacts.php?new_message', {data: dataMsg, list: true})
        .done (function(data) {
          if (data.messages) {
            historyBuilder(data.messages);
          }
        });
/*
      $.get('/ajax/contacts.php?get_messages', {id: $('#saveContact').attr('data-id')})
        .done (function(data) {
          historyBuilder(data.messages);
        });
*/
        $('#msgChatText').val('');
      });

   $('.contacts_str').click(function(e) {
     e.stopPropagation();
     if ($(this).hasClass('bg-notice-string')) {
       $(this).removeClass('bg-notice-string')
       deleteNoticesAboutContact($(this).attr('data-id'));
     }
     $('#orderDateEditIco').show();
     $('#orderDateEdit').parent().hide();
     if ($('.cd-panel-watch').hasClass('cd-panel--is-visible-watch')) {
      if (checkChangedForSave()) {
        if (!confirm('Изменения не сохранены, закрыть карточку?')) {
          return
        }
      }
     }
     if ($('#nameContact').css('border-color') === 'rgb(255, 0, 0)') {
       $('#nameContact').css('border-color', 'lightgrey');
     }
     if ($(this).hasClass('active_string')) {
      if ($('.cd-panel-watch').hasClass('cd-panel--is-visible-watch')) {
        $('.cd-panel-watch').removeClass('cd-panel--is-visible-watch');
        $('.cd-panel__close-watch').removeClass('cd-panel__close-watch-visible');
        $(this).removeClass('active_string')
      } else {
        $('.cd-panel-watch').addClass('cd-panel--is-visible-watch');
        $('.cd-panel__close-watch').addClass('cd-panel__close-watch-visible');
      }
     } else {
       if (data_page.admin_contacts_role !== '0') {
         $('#blankHistory').show();
       }
       $.get('/ajax/contacts.php?get_messages', {id: $(this).attr('data-id')})
         .done (function(data) {
           historyBuilder(data.messages);
         });
      $('.active_string') ? $('.active_string').removeClass('active_string') : '';
      $(this).addClass('active_string');
      if ($('.cd-panel-watch').hasClass('cd-panel--is-visible-watch')) {

      } else {
        $('.cd-panel-watch').addClass('cd-panel--is-visible-watch');
        $('.cd-panel__close-watch').addClass('cd-panel__close-watch-visible');
      }
     }
     var countryName = '';

     if (data_page.admin_contacts_role === '0') {
       var first = '', second = '';
       first = '<option value="'+$(this).attr('data-responsible')+'">'+fullNameToNoMiddleName($(this).attr('data-responsible_name'))+'';
       if ($(this).attr('data-responsible_previous')) {
        second = '<option value="'+$(this).attr('data-responsible_previous')+'">'+fullNameToNoMiddleName($(this).attr('data-responsible_previous_name'))+'';
       }
       $('#responsibleContact').html(first+second);
     }

     $(this).attr('data-country_key') ? countryName = data_page.country_list[$(this).attr('data-country_key')] : '';
     $('#nameContact').val($(this).find('.data_name').text());
     $('#phoneContact').val($(this).find('.data_phone').text());
     if ($(this).find('.data_phone').text()) {
       var phoneNumberTmp = $(this).find('.data_phone').text().trim();
       if (phoneNumberTmp[0] === '+' || phoneNumberTmp[0] === '8') {
        phoneNumberTmp = 'tel:' + phoneNumberTmp;
      } else {
        phoneNumberTmp = 'tel:+' + phoneNumberTmp;
      }
      $('#phoneContactCalling').attr('href', phoneNumberTmp);
    } else {
      $('#phoneContactCalling').attr('href', '#');
    }
     $('#emailContact').val($(this).attr('data-email'));
     $('#countryContact').val($(this).attr('data-country_key'));
     $('#maleContact').val($(this).attr('data-male'));
     $('#regionContact').val($(this).attr('data-region'));
     $('#areaContact').val($(this).attr('data-area'));
     $('#localityContact').val($(this).find('.data_locality').text());
     $('#indexContact').val($(this).attr('data-index_post'));
     $('#addressContact').val($(this).attr('data-address'));
     $('#commentContact').val($(this).attr('data-other'));
     $('#regionWorkContact').val($(this).attr('data-region_work'));
     $('#responsibleContact').val($(this).attr('data-responsible'));
     $('#responsibleContact').attr('data-responsible', $(this).attr('data-responsible'));
     $('#responsibleContact').attr('data-responsible_previous', $(this).attr('data-responsible_previous'));
     $('#link-for-russian-post').attr("href", "#");
     $('#link-for-russian-post').text("");
     if ($(this).attr('data-order_date') === 'null' || $(this).attr('data-order_date') === '00.00.0000' || $(this).attr('data-order_date') === 'undefined' || $(this).attr('data-order_date') === '') {
       $('#labelOrderDate').text('Заказа не было ');
       $('#orderDate').hide();
     } else if ($(this).attr('data-order_date') !== 'null' || $(this).attr('data-order_date') !== '00.00.0000'  || $(this).attr('data-order_date') !== 'undefined' || $(this).attr('data-order_date') !== '') {
       $('#labelOrderDate').text('Отправлен ');
       $('#orderDate').show();
     }

     if ($(this).attr('data-sending_date') === 'null' || $(this).attr('data-sending_date') === '' || $(this).attr('data-sending_date') === 'undefined') {
       $('#sendingDate').parent().hide();
     } else {
       //$('#sendingDate').parent().show();
     }

     $('#orderDate').text($(this).attr('data-order_date'));
     $('#sendingDate').text($(this).attr('data-sending_date'));

     $('#saveContact').attr('data-id', $(this).attr('data-id'));
     $('#saveContact').attr('data-id_admin', window.adminId);
     $('#statusContact').val($(this).attr('data-status_key'));
     $('#periodLabel').val($(this).attr('data-period'));

     // Check a send function
     if ($(this).attr('data-order_date') === '' || $(this).attr('data-order_date') === 'null' || $(this).attr('data-order_date') === 'undefined' || $(this).attr('data-order_date') === '00.00.0000') {
       $('#orderSentToContact').attr('disabled', false);
       $('#orderSentToContact').val('Отправить заказ');
       $('#orderDateEdit').val('');
     } else {
       $('#orderSentToContact').attr('disabled', true);
       $('#orderSentToContact').val('Заказ отправлен');
       var dateOrderChkeck = dateStrToddmmyyyyToyyyymmdd($(this).attr('data-order_date'), false);
       var dateOrder = new Date(dateOrderChkeck);
       var currentDate = new Date();

       $('#orderDateEdit').val(dateOrderChkeck);

       if (((currentDate.getFullYear() - dateOrder.getFullYear()) > 1) || ((currentDate.getFullYear() - dateOrder.getFullYear()) < 0)) {
         $('#orderSentToContact').attr('disabled', false);
         $('#orderSentToContact').val('Отправить заказ');
       } else if ((currentDate.getFullYear() - dateOrder.getFullYear()) === 1) {
         if (((currentDate.getMonth()-dateOrder.getMonth()) === -11) && (currentDate.getDate() < dateOrder.getDate())) {
           $('#orderSentToContact').attr('disabled', true);
           $('#orderSentToContact').val('Заказ отправлен');
         } else {
           $('#orderSentToContact').attr('disabled', false);
           $('#orderSentToContact').val('Отправить заказ');
         }
       } else if ((currentDate.getFullYear() - dateOrder.getFullYear()) === 0 ) {
         if (((currentDate.getMonth() - dateOrder.getMonth()) > 1) || ((currentDate.getMonth() - dateOrder.getMonth()) === 1 && (currentDate.getDate()>=dateOrder.getDate()))) {
           $('#orderSentToContact').attr('disabled', false);
           $('#orderSentToContact').val('Отправить заказ');
         } else if ((currentDate.getMonth() - dateOrder.getMonth()) <= 0) {
           $('#orderSentToContact').attr('disabled', true);
           $('#orderSentToContact').val('Заказ отправлен');
         } else {
           $('#orderSentToContact').attr('disabled', true);
           $('#orderSentToContact').val('Заказ отправлен');
         }
       } else {
         $('#orderSentToContact').attr('disabled', true);
         $('#orderSentToContact').val('Заказ отправлен');
       }
     }

     if (data_page.admin_contacts_role === '0' && $('#myBlanks').val() === '0') {
       $('#sideBarBlankContact').find('input').attr('disabled', true)
       $('#sideBarBlankContact').find('select').attr('disabled', true)
       $('#sideBarBlankContact').find('textarea').attr('disabled', true)
       $('#cd-panel__close-watch').attr('disabled', false)
     } else if (data_page.admin_contacts_role === '0' && $('#myBlanks').val() === '1' && $('#nameContact').attr('disabled') === 'disabled') {

       var dateOrderChkeckEx = dateStrToddmmyyyyToyyyymmdd($(this).attr('data-order_date'), false);

       var dateOrderEx = new Date(dateOrderChkeckEx);
       var currentDateEx = new Date();

       $('#orderDateEdit').val(dateOrderChkeckEx);

       $('#sideBarBlankContact').find('input').attr('disabled', false)
       $('#sideBarBlankContact').find('select').attr('disabled', false)
       $('#sideBarBlankContact').find('textarea').attr('disabled', false)

       if ($('#orderDate').text() === '' || $('#orderDate').text() === 'null' || $('#orderDate').text() === 'undefined' || $('#orderDate').text() === '00.00.0000') {
         $('#orderSentToContact').attr('disabled', false);
         $('#orderSentToContact').val('Отправить заказ');
       } else if(((currentDateEx.getFullYear()- dateOrderEx.getFullYear()) === 1) && ((currentDateEx.getMonth()-dateOrderEx.getMonth()) === -11) && (currentDateEx.getDate() < dateOrderEx.getDate())) {
         $('#orderSentToContact').attr('disabled', true);
         $('#orderSentToContact').val('Заказ отправлен');
       } else if ((((currentDateEx.getFullYear() - dateOrderEx.getFullYear()) === 0) && ((currentDateEx.getMonth() -dateOrderEx.getMonth()) === 1) && (currentDateEx.getDate() < dateOrderEx.getDate())) || (((currentDateEx.getFullYear() - dateOrderEx.getFullYear()) === 0) && ((currentDateEx.getMonth() - dateOrderEx.getMonth()) === 0))) {
         $('#orderSentToContact').attr('disabled', true);
         $('#orderSentToContact').val('Заказ отправлен');
       }
     }
   });

   $('.checkboxString').click(function (e) {
     e.stopPropagation();
     if ($('#kindOfList').val() === 'trash') {
       return;
     }
     if ($(this).prop('checked')) {
       $('#deleteContact').attr('disabled') ? $('#deleteContact').attr('disabled', false) : '';
       $('#deleteContactsShowModal').attr('disabled') ? $('#deleteContactsShowModal').attr('disabled', false) : '';
       $('#appointStatusShow').attr('disabled') ? $('#appointStatusShow').attr('disabled', false) : '';
       $('#appointResponsible').attr('disabled') ? $('#appointResponsible').attr('disabled', false) : '';
       $('#appointResponsibleShow').attr('disabled') ? $('#appointResponsibleShow').attr('disabled', false) : '';
     } else {
       $('#deleteContact').attr('disabled', true);
       $('#deleteContactsShowModal').attr('disabled', true);
       $('#appointStatusShow').attr('disabled', true);
       $('#appointResponsible').attr('disabled', true);
       $('#appointResponsibleShow').attr('disabled', true);
       $('.contacts_str').find('.checkboxString').each(function () {
         if ($(this).prop('checked')) {
           $('#deleteContact').attr('disabled', false);
           $('#deleteContactsShowModal').attr('disabled', false);
           $('#appointStatusShow').attr('disabled', false);
           $('#appointResponsible').attr('disabled', false);
           $('#appointResponsibleShow').attr('disabled', false);
         }
       });
       /*
       setTimeout(function () {
         if (counter === 0) {
           $('#deleteContact').attr('disabled', true);
           $('#appointResponsible').attr('disabled', true);
         }
       }, 120);*/
     }
   });
// TRASH RECOVER
   $('.fa-undo').click(function (e) {
     e.preventDefault();
     e.stopPropagation();
     if ($(window).height()<769) {
       currentString = $(this).parents('.contacts_str');
     } else {
       currentString = $(this).parents('tr');
     }
     var strId = $(this).attr('data-id');
     urlDlt = '/ajax/contacts.php?set_recover_string&id='+$(this).attr('data-id');
     fetch(urlDlt)
     .then(response => response.json())
     .then(result => {
       if (result === '1') {
         showHint('Востановлена карточка контакта - '+currentString.find('.data_name').text());
         currentString.hide();
         currentString.removeClass('contacts_str').addClass('contacts_str_recover');
         if ($('.cd-panel-watch').hasClass('cd-panel--is-visible-watch') && $('#saveContact').attr('data-id') === strId) {
           closeSidePanel();
           clearingBlankOfContact();
           getDataTrash();
         }
       } else {
         showError('Не удаётся восстановить карточку контакта - '+currentString.find('.data_name').text());
       }
     })
   });
// ARCHIVE RECOVER
   $('.fa-archive').click(function (e) {
     e.preventDefault();
     e.stopPropagation();
     var elem =  $(this).parents('tr');
     var strId = $(this).attr('data-id');
     //console.log(elem);
     if ($(window).height()<769) {
       currentString = $(this).parents('.contacts_str');
     } else {
       currentString = $(this).parents('tr');
     }
     currentString = $(this).parents('tr');
     urlDlt = '/ajax/contacts.php?set_recover_archived_string&id='+$(this).attr('data-id');
     fetch(urlDlt)
     .then(response => response.json())
     .then(result => {
       if (result === '1') {
         showHint('Востановлена карточка контакта - '+currentString.find('.data_name').text());
         currentString.hide();
         currentString.removeClass('contacts_str').addClass('contacts_str_recover');
         if ($('.cd-panel-watch').hasClass('cd-panel--is-visible-watch') && $('#saveContact').attr('data-id') === strId) {
           closeSidePanel();
           clearingBlankOfContact();
           getDataTrash();
         }
       } else {
         showError('Не удаётся восстановить карточку контакта - '+currentString.find('.data_name').text());
       }
     })
   });
// STOP
   $('.bell-alarm, .bell-alarm-mbl').click(function () {
     if ($(this).hasClass('this_sorted')) {
       filtersOfString();
       $('.bell-alarm').removeClass('this_sorted');
       $('.bell-alarm-mbl').removeClass('this_sorted');
     } else {
        if (window.location.pathname === '/contacts') {
         var cheking = 0;
         $('.contacts_str').each(function () {
           if ($(this).hasClass('bg-notice-string')) {
             cheking++;
             $(this).show();
           } else {
             $(this).hide();
           }
         });
         if (cheking === 0) {
           filtersOfString();
         } else {
           $('.bell-alarm').addClass('this_sorted');
           $('.bell-alarm-mbl').addClass('this_sorted');
         }
       }
     }
   });

   if (data_page.sort_new === 'sort_new') {
     $('.bell-alarm').addClass('this_sorted');
     $('.bell-alarm-mbl').addClass('this_sorted');
     $('.contacts_str').each(function () {
       if ($(this).hasClass('bg-notice-string')) {
         $(this).show();
       } else {
         $(this).hide();
       }
     });
     document.cookie = "sort_new=none";
   }

   setTimeout(function () {
     if (!data_page.sort_new) {
      filtersOfString();
     } else {
       data_page.sort_new = '';
       $('.contacts_str').each(function () {
         if ($(this).hasClass('bg-notice-string')) {
           $(this).show();
         } else {
           $(this).hide();
         }
       });
     }
     // УТОЧНИТЬ О РАБОТЕ СКРИПТА ПРИ ОТПРАВКЕ ЗАКАЗА
     if ($('#modalSpinner').is(':visible')) {
       $('#modalSpinner').hide();
       $('#saveSpinner').hide();
     }
   }, 50);
}

function historyBuilder(data) {
  var readyMessages = [], name, nameTmp = '', author, edit, dataLength;
  data ? dataLength = data.length : dataLength = 0;
  for (var i = 0; i < dataLength; i++) {
    author='', edit='', name = '';
    if (data[i].member_key === window.adminId) {
      name = $('.user-name').text();
      author = 1;
    } else {
      for (var variable in data_page.members_admin_responsibles) {
        if (data[i].member_key === variable) {
          nameTmp = data_page.members_admin_responsibles[variable].split(' ');
           name = nameTmp[0] + ' ' + nameTmp[1][0] + '. ';
          if (nameTmp[2]) {
            name = name + nameTmp[2][0] + '. ';
          }
        }
      }
      if (!name) {
        for (var variable in data_page.members_responsibles) {
          if (data[i].member_key === variable) {
            nameTmp = data_page.members_responsibles[variable].split(' ');
             name = nameTmp[0] + ' ' + nameTmp[1][0] + '. ';
            if (nameTmp[2]) {
              name = name + nameTmp[2][0] + '. ';
            }
          }
        }
      }
      if (!name) {
        name = data[i].member_key;
      }
    }
    if (author) {
      author = '<div class="row change_msg_div" style="display: none"><div class="col-9" style="padding-left: 0"><textarea rows="3" class="form-control form-control-sm change_msg_field">'+data[i].message+'</textarea></div><div class="col-3" style="padding-left: 5px; padding-right: 5px;"><input type="button" class="btn btn-success change_msg_ok btn-sm" value="Ок" style="margin-right: 10px;"><input type="button" class="btn btn-danger change_msg_cancel btn-sm" value="X"><input type="button" class="btn btn-warning change_msg_delete btn-sm" value="Удалить" style="margin-top: 5px;"></div></div>';
    } else {
      edit = 'style="display:none"';
    }
    var tempText = data[i].message;
    tempText = tempText.slice(0, 22);
    if (tempText === 'Назначен ответственный') {
      name = '';
      edit = 'style="display:none"';
    }

    readyMessages.push('<div data-id="'+data[i].id+'"><p data-member_id="'+data[i].member_key+'" data-date="'+data[i].time_stamp+'" style="margin-bottom: 3px;"><span class="about_message">'+name+' '+data[i].time_stamp+' </span><i class="cursor-pointer fa fa-pencil edit_history_msg" '+edit+'></i></p><p class="text_history_msg" style="margin-bottom: 0px;">'+data[i].message+'</p>'+author+'<hr style="margin-bottom: 8px; margin-top: 8px;"></div>');
  }
  $('#chatBlock').html(readyMessages);

  $('.edit_history_msg').click(function (e) {
    e.stopPropagation();
    if ($('#myBlanks').val() === '0' &&  data_page.admin_contacts_role === '0') {
      return
    }

    if ($(this).parent().parent().find('.change_msg_div').is(':visible')) {
      $(this).parent().parent().find('.change_msg_div').hide();
      $(this).parent().parent().find('.text_history_msg').show();
      return
    }

    $('#chatBlock').find('.change_msg_div').each(function () {
      if ($(this).is(':visible')) {
        $(this).hide();
        $(this).parent().find('.text_history_msg').show();
      }
    });

    $(this).parent().parent().find('.change_msg_div').show();
    $(this).parent().parent().find('.text_history_msg').hide();
  });

  $('.change_msg_ok').click(function (e) {
    e.stopPropagation();

    $(this).parent().parent().hide();
    $(this).parent().parent().parent().find('.text_history_msg').show();
    $(this).parent().parent().parent().find('.text_history_msg').text($(this).parent().parent().find('.change_msg_field').val());

    $.get('/ajax/contacts.php?update_message', {id: $(this).parent().parent().parent().attr('data-id'), text:$(this).parent().parent().parent().find('.change_msg_field').val()})
      .done (function(data) {
      });
  });

  $('.change_msg_cancel').click(function(e){
    e.stopPropagation();
    $(this).parent().parent().hide();
    $(this).parent().parent().parent().find('.text_history_msg').show();
  });

  $('.change_msg_delete').click(function(e){
    e.stopPropagation();
    if (confirm('Удалить запись?')) {
    $(this).parent().parent().parent().hide();
    $.get('/ajax/contacts.php?delete_message', {id: $(this).parent().parent().parent().attr('data-id')})
      .done (function(data) {
      });
    }
  });
}
  function messageFunction(type, id, responsible, updateChatNow) {
    var text, url;
    if (type === 'responsible') {
      text = 'Назначен ответственный ' + responsible;
    }
    var dataMsgFun = {
      text: text,
      id: id
    };
    url = '/ajax/contacts.php?new_message&data%5Btext%5D='+text+'&data%5Bid%5D='+id+'&list=false';
    if (updateChatNow) {
      fetch(url)
      .then(response => response.json())
      .then(commits => getMessages(commits.messages[0].group_id));
    } else {
      fetch(url);
    }
/*
    $.get('/ajax/contacts.php?new_message', {data: dataMsgFun, list: false})
      .done (function(data) {
      });
*/
  }

  function getMessages(id) {
      var url = 'ajax/contacts.php?get_messages&id='+id;
      fetch(url)
      .then(response => response.json())
      .then(commits => historyBuilder(commits.messages));
      /*
      $.get('/ajax/contacts.php?get_messages', {id: id})
      .done (function(data) {
        historyBuilder(data.messages);
      });
      */
    }

// notification
// add notice about contact
  function addNoticeAboutContact(idAdmin, idContact) {
    if (idContact) {
      $.get('/ajax/contacts.php?set_notice', {admin: idAdmin, contact: idContact})
      .done (function(data) {
      });
    }
  }
// delete notice about contact
  function deleteNoticesAboutContact(id) {
    $.get('/ajax/contacts.php?delete_notices', {id: id})
    .done (function(data) {
    });
  }

// ADD NEW CONTACT
  function clearingBlankOfContact() {
    $('#periodLabel').val('');
    $('.active_string').removeClass('active_string');
    $('#orderDateEditIco').show();
    $('#orderDateEdit').parent().hide();
    $('#sideBarBlankContact').find('input').each(function () {
      $(this).attr('type') !== 'button' ? $(this).val('') : '';
    });
    $('#phoneContactCalling').attr('href','#');
    $('#maleContact').val('_none_');
    $('#countryContact').val('');
    $('#commentContact').val('');
    $('#responsibleContact').attr('data-responsible_previous', '');
    $('#responsibleContact').attr('data-responsible', '');
    $('#orderDate').text('');
    $('#labelOrderDate').text('Заказа не было');
    $('#sendingDate').text('');
    $('#statusContact').val('');
    $('#saveContact').attr('data-id', '');
    $('#saveContact').attr('data-id_admin', window.adminId);
    $('#createdDate').text('');
    $('#chatBlock').text('');
    $('#link-for-russian-post').attr("href", "#");
    $('#link-for-russian-post').text("");
    $('#personalBlank').find('.nav-link').hasClass('active') ? '': $('#personalBlank').find('.nav-link').addClass('active');
    $('#personalBlankTab').hasClass('active') ? '': $('#personalBlankTab').addClass('active');
    $('#blankComment').find('.nav-link').hasClass('active') ? $('#blankComment').find('.nav-link').removeClass('active') : '';
    $('#blankCommentTab').hasClass('active') ? $('#blankCommentTab').removeClass('active') : '';
    $('#blankCommentTab').hasClass('show') ? $('#blankCommentTab').removeClass('show') : '';
    $('#blankHistory').find('.nav-link').hasClass('active') ? $('#blankHistory').find('.nav-link').removeClass('active') : '';
    $('#blankHistoryTab').hasClass('active') ? $('#blankHistoryTab').removeClass('active') : '';
    $('#blankHistoryTab').hasClass('show') ? $('#blankHistoryTab').removeClass('show') : '';
  }


  function saveEditContactQuick (dlt) {
    // check change of the responsible
    var currentResponsible = '', prevResponsible = '';
    if (($('#responsibleContact').val() && ($('#responsibleContact').val() === $('#responsibleContact').attr('data-responsible'))) || (!$('#responsibleContact').val() && $('#responsibleContact').attr('data-responsible'))) {
      // responsible has not been changed OR responsible has not been choisen
        currentResponsible = $('#responsibleContact').attr('data-responsible');
        prevResponsible = $('#responsibleContact').attr('data-responsible_previous');

    } else if (!$('#responsibleContact').val() && !$('#responsibleContact').attr('data-responsible')) {
      // create new contact AND no responsible choise
    currentResponsible = window.adminId;
    prevResponsible = $('#responsibleContact').attr('data-responsible_previous');
    } else if ($('#responsibleContact').val() && !$('#responsibleContact').attr('data-responsible')) {
      // create new contact AND responsible has been choisen
      currentResponsible = $('#responsibleContact').val();
      prevResponsible = $('#responsibleContact').attr('data-responsible_previous');
      // add notice
      if (currentResponsible !== window.adminId) {
        prevResponsible = window.adminId;
      }
    } else if ($('#responsibleContact').val() && $('#responsibleContact').attr('data-responsible') && ($('#responsibleContact').val() !== $('#responsibleContact').attr('data-responsible'))) {
      // responsible has been changed
        if ($('#responsibleContact').attr('data-responsible_previous') && window.adminId === $('#responsibleContact').attr('data-responsible_previous')) {
          currentResponsible = $('#responsibleContact').val();
          prevResponsible = $('#responsibleContact').attr('data-responsible_previous');
        } else {
          currentResponsible = $('#responsibleContact').val();
          prevResponsible = $('#responsibleContact').attr('data-responsible');
      }
    }

  // get data
      var data = {};
      data.id = $('#saveContact').attr('data-id');
      data.name = $('#nameContact').val();
      data.phone = $('#phoneContact').val();
      data.email = $('#emailContact').val();
      data.country = $('#countryContact').val();
      data.male = $('#maleContact').val();
      data.region = $('#regionContact').val();
      data.area = $('#areaContact').val();
      data.locality = $('#localityContact').val();
      data.index = $('#indexContact').val();
      data.address = $('#addressContact').val();
      data.comment = $('#commentContact').val();
      data.region_work = $('#regionWorkContact').val();
      data.status = $('#statusContact').val();
      data.responsible = currentResponsible;
      data.responsible_prev = prevResponsible;
      data.project = $('#periodLabel').val();

      if ($('#orderDate').text()) {
        data.order_date = dateStrToddmmyyyyToyyyymmdd($('#orderDate').text(), false);
      } else {
        data.order_date = null;
      }

      $('#saveContact').attr('data-id_admin') ? data.admin = $('#saveContact').attr('data-id_admin') : data.admin = window.adminId;
  // add status statistic.
      if ($('#saveContact').attr('data-id') && $('#statusContact').val() && $('#statusContact').val() !== $('.active_string').attr('data-status_key')) {
        $.get('/ajax/contacts.php?add_history_status', {status: $('#statusContact').val(), id_contact: $('#saveContact').attr('data-id')})
        .done (function(data) {
        });
      }
  // save
    let promise = $.post('/ajax/contacts.php', {type: 'save', blank_data: data})
        .done (function(data) {
          if (data.id && data.id !== 'update') {
            $.get('/ajax/contacts.php?add_history_status', {status: $('#statusContact').val(), id_contact: data.id})
            .done (function(data) {
            });

            $('#saveContact').attr('data-id', data.id);
            $('#saveContact').attr('data-id_admin', window.adminId);

            if ($('#responsibleContact').val()) {
              if ($('#responsibleContact').val() !== window.adminId) {
                if (data_page.admin_contacts_role === '0') {
                  messageFunction('responsible', data.id, fullNameToShortFirstMiddleNames($('#responsibleContact option:selected').text()));
                } else {
                  messageFunction('responsible', data.id, fullNameToShortFirstMiddleNames($('#responsibleContact option:selected').text()), true);
                }
              }
              $('#responsibleContact').attr('data-responsible', $('#responsibleContact').val());
            } else {
              $('#responsibleContact').attr('data-responsible', window.adminId);
              $('#responsibleContact').val(window.adminId);
            }

            // Page reload & don't update string & form
            if (data_page.admin_contacts_role === '0' && !dlt) {
                clearingBlankOfContact();
                closeSidePanel();
            }

          } else if (data.id === 'update') {
            if ($('#responsibleContact').val() !== $('#responsibleContact').attr('data-responsible') && $('#responsibleContact').val()) {
              // add message
              // !!!!!! THE PROMISE SOULD BE USE FROM HERE IF ROLE > 0
              if (data_page.admin_contacts_role === '0') {
                messageFunction('responsible', $('#saveContact').attr('data-id'), fullNameToShortFirstMiddleNames($('#responsibleContact option:selected').text()));
              } else {
                messageFunction('responsible', $('#saveContact').attr('data-id'), fullNameToShortFirstMiddleNames($('#responsibleContact option:selected').text()), true);
              }
              $('#responsibleContact').attr('data-responsible_previous', $('#responsibleContact').attr('data-responsible'));
              $('#responsibleContact').attr('data-responsible', $('#responsibleContact').val());
            } else if (!$('#responsibleContact').val() && $('#responsibleContact').attr('data-responsible') != window.adminId) {
              $('#responsibleContact').attr('data-responsible_previous', $('#responsibleContact').attr('data-responsible'));
              $('#responsibleContact').attr('data-responsible', window.adminId);
            }
            if (data_page.admin_contacts_role === '0' && !dlt) {
                clearingBlankOfContact();
                closeSidePanel();
            }
          } else {
            console.log('Error. No any answer.');
          }
        });

        promise.then(function (e) {
          //console.log(e);
        });
  }

  function saveEditContact() {
// checking
// check change of the responsible
  var currentResponsible = '', prevResponsible = '';
  if (($('#responsibleContact').val() && ($('#responsibleContact').val() === $('#responsibleContact').attr('data-responsible'))) || (!$('#responsibleContact').val() && $('#responsibleContact').attr('data-responsible'))) {
    // responsible has not been changed OR responsible has not been choisen
      currentResponsible = $('#responsibleContact').attr('data-responsible');
      prevResponsible = $('#responsibleContact').attr('data-responsible_previous');

  } else if (!$('#responsibleContact').val() && !$('#responsibleContact').attr('data-responsible')) {
    // create new contact AND no responsible choise
  currentResponsible = window.adminId;
  prevResponsible = $('#responsibleContact').attr('data-responsible_previous');
  } else if ($('#responsibleContact').val() && !$('#responsibleContact').attr('data-responsible')) {
    // create new contact AND responsible has been choisen
    currentResponsible = $('#responsibleContact').val();
    prevResponsible = $('#responsibleContact').attr('data-responsible_previous');
    // add notice
    if (currentResponsible !== window.adminId) {
      prevResponsible = window.adminId;
    }
  } else if ($('#responsibleContact').val() && $('#responsibleContact').attr('data-responsible') && ($('#responsibleContact').val() !== $('#responsibleContact').attr('data-responsible'))) {
    // responsible has been changed
      if ($('#responsibleContact').attr('data-responsible_previous') && window.adminId === $('#responsibleContact').attr('data-responsible_previous')) {
        currentResponsible = $('#responsibleContact').val();
        prevResponsible = $('#responsibleContact').attr('data-responsible_previous');
      } else {
        currentResponsible = $('#responsibleContact').val();
        prevResponsible = $('#responsibleContact').attr('data-responsible');
    }
  }

// get data
    var data = {};
    data.id = $('#saveContact').attr('data-id');
    data.name = $('#nameContact').val();
    data.phone = $('#phoneContact').val();
    data.email = $('#emailContact').val();
    data.country = $('#countryContact').val();
    data.male = $('#maleContact').val();
    data.region = $('#regionContact').val();
    data.area = $('#areaContact').val();
    data.locality = $('#localityContact').val();
    data.index = $('#indexContact').val();
    data.address = $('#addressContact').val();
    var comcomment = $('#commentContact').val();
    data.comment = comcomment.replace(/\"/g, "\'");
    data.region_work = $('#regionWorkContact').val();
    data.status = $('#statusContact').val();
    data.responsible = currentResponsible;
    data.responsible_prev = prevResponsible;
    data.project = $('#periodLabel').val();

    if ($('#orderDate').text()) {
      data.order_date = dateStrToddmmyyyyToyyyymmdd($('#orderDate').text(), false);
    } else {
      data.order_date = null;
    }

    $('#saveContact').attr('data-id_admin') ? data.admin = $('#saveContact').attr('data-id_admin') : data.admin = window.adminId;
// add status statistic.
    if ($('#saveContact').attr('data-id') && $('#statusContact').val() && $('#statusContact').val() !== $('.active_string').attr('data-status_key')) {
      $.get('/ajax/contacts.php?add_history_status', {status: $('#statusContact').val(), id_contact: $('#saveContact').attr('data-id')})
      .done (function(data) {
      });
    }
// save
  let promise = $.post('/ajax/contacts.php', {type: 'save', blank_data: data})
      .done (function(data) {
        if (data.id && data.id !== 'update') {
          $.get('/ajax/contacts.php?add_history_status', {status: $('#statusContact').val(), id_contact: data.id})
          .done (function(data) {
          });

          $('#saveContact').attr('data-id', data.id);
          $('#saveContact').attr('data-id_admin', window.adminId);

          if ($('#responsibleContact').val()) {
            if ($('#responsibleContact').val() !== window.adminId) {
              addNoticeAboutContact($('#responsibleContact').val(), data.id);
              if (data_page.admin_contacts_role === '0') {
                messageFunction('responsible', data.id, fullNameToShortFirstMiddleNames($('#responsibleContact option:selected').text()));
              } else {
                messageFunction('responsible', data.id, fullNameToShortFirstMiddleNames($('#responsibleContact option:selected').text()), true);
              }
            }
            $('#responsibleContact').attr('data-responsible', $('#responsibleContact').val());
          } else {
            $('#responsibleContact').attr('data-responsible', window.adminId);
            $('#responsibleContact').val(window.adminId);
          }

          // Page reload & don't update string & form
          if (data_page.admin_contacts_role === '0') {
              clearingBlankOfContact();
              closeSidePanel();
              contactsListUpdate();
          } else {
              contactsListUpdate(data.id);
          }

        } else if (data.id === 'update') {
          if ($('#responsibleContact').val() !== $('#responsibleContact').attr('data-responsible') && $('#responsibleContact').val()) {
            // add notice
            addNoticeAboutContact($('#responsibleContact').val(), $('#saveContact').attr('data-id'));

            // add message
            // !!!!!! THE PROMISE SOULD BE USE FROM HERE IF ROLE > 0
            if (data_page.admin_contacts_role === '0') {
              messageFunction('responsible', $('#saveContact').attr('data-id'), fullNameToShortFirstMiddleNames($('#responsibleContact option:selected').text()));
            } else {
              messageFunction('responsible', $('#saveContact').attr('data-id'), fullNameToShortFirstMiddleNames($('#responsibleContact option:selected').text()), true);
            }
            $('#responsibleContact').attr('data-responsible_previous', $('#responsibleContact').attr('data-responsible'));
            $('#responsibleContact').attr('data-responsible', $('#responsibleContact').val());
          } else if (!$('#responsibleContact').val() && $('#responsibleContact').attr('data-responsible') != window.adminId) {
            $('#responsibleContact').attr('data-responsible_previous', $('#responsibleContact').attr('data-responsible'));
            $('#responsibleContact').attr('data-responsible', window.adminId);
          }
          if (data_page.admin_contacts_role === '0') {
              clearingBlankOfContact();
              closeSidePanel();
              contactsListUpdate();
          } else {
            stringUpdater($('#saveContact').attr('data-id'));
          }
        } else {
          console.log('Error. No any answer.');
        }
        showHint('Карточка сохранена.');
      });

      promise.then(function (e) {
      });
/*
// ??? Catch error OR string/list don't updated  and reload list
// !!!!!! THE PROMISE SOULD BE USE FOR THIS IF ROLE > 0
// Слишком много противоречий
      setTimeout(function () {
          if ((data_page.admin_contacts_role !== '0') && ($('#saveContact').attr('data-id') !== $('.active_string').attr('data-id')) && ($('.active_string').find('.data_name').text().trim() !== $('#nameContact').val().trim())) {
            clearingBlankOfContact();
            $('.cd-panel-watch').removeClass('cd-panel--is-visible-watch');
            $('.cd-panel__close-watch').removeClass('cd-panel__close-watch-visible');
            contactsListUpdate();
      }
    }, 7450);
*/
  }

  $('#nameContact').keyup(function () {
    $('#nameContact').css('border-color', '#ced4da');
  });

  $('#countryContact,#maleContact').change(function () {
    $(this).css('border-color', '#ced4da');
  });

  $('#saveContact').click(function(e) {
    if ($('#kindOfList').val() === 'trash') {
      showError('Операции с карточками в корзине запрещены, сначала восстановите карточку.');
      return;
    }
    if (!$('#nameContact').val()) {
      showError('Заполните поле ФИО.');
      $('#nameContact').css('border-color', 'red');
      return
    }
    if (!$('#countryContact').val()) {
      showError('Заполните поле Страна.');
      $('#countryContact').css('border-color', 'red');
      return
    }
    if ($('#maleContact').val()==='_none_') {
      showError('Заполните поле Пол.');
      $('#maleContact').css('border-color', 'red');
      return
    }
    if (data_page.admin_contacts_role !== '0') {
      $('#blankHistory').show();
    }

    if ($('#statusContact').val() === '4' && $('#statusContact').val() !== $('.active_string').attr('data-status_key') && ( $('#orderSentToContact').attr('disabled') !== 'disabled' || !$('#saveContact').attr('data-id'))) {
      !$('#phoneContact').val() ? $('#phoneContact').css('border-color', 'red') : $('#phoneContact').css('border-color', '#ced4da');
      !$('#regionContact').val() ? $('#regionContact').css('border-color', 'red') : $('#regionContact').css('border-color', '#ced4da');
      !$('#localityContact').val() ? $('#localityContact').css('border-color', 'red') : $('#localityContact').css('border-color', '#ced4da');
      !$('#indexContact').val() ? $('#indexContact').css('border-color', 'red') : $('#indexContact').css('border-color', '#ced4da');
      !$('#addressContact').val() ? $('#addressContact').css('border-color', 'red') : $('#addressContact').css('border-color', '#ced4da');
      if (!$('#phoneContact').val() || !$('#regionContact').val() || !$('#localityContact').val() || !$('#indexContact').val() || !$('#addressContact').val()) {
        showError('Заполните поля выделенные красным цветом.');
        e.stopPropagation();
        return
      } else {
        $('#addressContact').css('border-color', '#ced4da');
        $('#indexContact').css('border-color', '#ced4da');
        $('#localityContact').css('border-color', '#ced4da');
        $('#regionContact').css('border-color', '#ced4da');
        $('#phoneContact').css('border-color', '#ced4da');
        $('#nameContact').css('border-color', '#ced4da');
        $('#saveConfirm').show();
      }
      $('#saveConfirm').find('h6').html('<b style="color: red;">Для сохранения без отправки данных в CRM измените статус.</b><br><br>Примечание к заказу');
      $('#adminNotes').val('');
    } else {
      saveEditContact();
      $('#modalSpinner').show();
      $('#saveSpinner').show();
      setTimeout(function () {
        if ($('#modalSpinner').is(':visible')) {
          $('#modalSpinner').hide();
          $('#saveSpinner').hide();
        }
      }, 7500);
    }
  });

// responsible delete
  function deleteContact() {
    var dataStr = [], dataError = [];
    $('.contacts_str').each(function () {
      if ($(this).is(':visible') && $(this).find('.checkboxString').prop('checked')) {
        if (data_page.admin_contacts_role === '0' && $(this).attr('data-responsible_previous')) {
          dataError.push($(this).find('.data_name').text());
        } else {
          if ($(this).attr('data-id')) {
            dataStr.push($(this).attr('data-id'));
          }
        }
        if ($(this).attr('data-id')=== $('#saveContact').attr('data-id')) {
          saveEditContact();
          setTimeout(function () {
            clearingBlankOfContact();
            closeSidePanel();
          }, 300);
        }
        if (data_page.admin_contacts_role === '0' && $(this).attr('data-responsible_previous')) {

        } else {
          $(this).hide();
          $(this).removeClass('contacts_str');
          $(this).addClass('contacts_str_trash');
        }
      }
    });

    // ПРОВЕРИТЬ на больших объёмах, возможно лучше действовать синхронно, что бы запрос не выполнился прежде формирования массива содержащего данные для запроса
    if (dataStr[0]) {
      $.post('/ajax/contacts.php', {type: 'delete_contact',delete_contacts_id: dataStr})
        .done (function(data) {
          $('#modalSpinner').hide();
          $('#saveSpinner').hide();
          showHint('Удалено строк: '+dataStr.length);
        });
    } else {
      $('#modalSpinner').hide();
      $('#saveSpinner').hide();
      showHint('Удалено 0 строк');
    }
/*
    setTimeout(function () {
      showHint('Удалено строк: '+dataStr.length)
      //contactsListUpdate();
    }, 100);
*/
    dataError[0] ? modalInfoUniversal('Эти контакты удаляются только администратором:<br>'+dataError.join('<br>')) : '';
  }

  $('#deleteContact').click(function() {
    $('#modalSpinner').show();
    $('#saveSpinner').show();

    setTimeout(function () {
      deleteContact();
    }, 30);

    $('#deleteContactsShowModal').attr('disabled', true);
    $('#appointStatusShow').attr('disabled', true);
    //$('#deleteContact').attr('disabled', true);
    $('#appointResponsible').attr('disabled', true);
    $('#appointResponsibleShow').attr('disabled', true);
    $('#checkAllStrings').prop('checked', false);
  });
// To archive
  function archiviateContact() {
    var dataStr = [];
    $('.contacts_str').each(function () {
      if ($(this).is(':visible') && $(this).find('.checkboxString').prop('checked')) {
        dataStr.push($(this).attr('data-id'));
        if ($(this).attr('data-id')=== $('#saveContact').attr('data-id')) {
          saveEditContactQuick();
          setTimeout(function () {
            clearingBlankOfContact();
            closeSidePanel();
          }, 300);
        }
        $(this).hide();
        $(this).removeClass('contacts_str');
        $(this).addClass('contacts_str_trash');
      }
    });

    $.post('/ajax/contacts.php', {type: 'archiviate_contact', archiviate_contacts_id: dataStr})
      .done (function(data) {
        $('#modalSpinner').hide();
        $('#saveSpinner').hide();
        showHint('Архивировано строк: '+dataStr.length);
      });
  }

  $('#archiviateContact').click(function() {
    $('#modalSpinner').show();
    $('#saveSpinner').show();

    setTimeout(function () {
      archiviateContact();
    }, 30);

    $('#deleteContactsShowModal').attr('disabled', true);
    $('#appointStatusShow').attr('disabled', true);
    //$('#deleteContact').attr('disabled', true);
    $('#appointResponsible').attr('disabled', true);
    $('#appointResponsibleShow').attr('disabled', true);
    $('#checkAllStrings').prop('checked', false);
  });

  function statusContacts() {
    var dataStr = [];
    $('.contacts_str').each(function () {
      if ($(this).is(':visible') && $(this).find('.checkboxString').prop('checked')) {
        dataStr.push($(this).attr('data-id'));
        if ($(this).attr('data-id')=== $('#saveContact').attr('data-id')) {
          clearingBlankOfContact();
          closeSidePanel();
        }
      }
    });

    // ПРОВЕРИТЬ на больших объёмах, возможно лучше действовать синхронно, что бы запрос не выполнился прежде формирования массива содержащего данные для запроса

    $.post('/ajax/contacts.php', {type: 'set_status_multiple', new_status: $('#comboStatusModal').val(), contact_id: dataStr})
      .done (function(data) {
      });

    setTimeout(function () {
      showHint('Назначен статус: '+$('#comboStatusModal option:selected').text())
      contactsListUpdate();
    }, 100);
  }

  $('#statusContactBtn').click(function() {
    statusContacts();
    //comboStatusModal statusContactBtn
    $('#deleteContactsShowModal').attr('disabled', true);
    $('#appointStatusShow').attr('disabled', true);
    $('#appointResponsible').attr('disabled', true);
    $('#appointResponsibleShow').attr('disabled', true);
    $('#checkAllStrings').prop('checked', false);
    $('#checkAllStrings').prop('checked', false);
  });

// responsible set
  function responsibleSetContact() {
    if (data_page.admin_contacts_role === '0') {
      // Новый запрос для админа 0 где нужно передать карточки разным предыдущим админам
      var listZero = [];
      $('.contacts_str').each(function () {
        if ($(this).is(':visible') && $(this).find('.checkboxString').prop('checked') && $(this).attr('data-responsible_previous')) {
          listZero.push([$(this).attr('data-id'), $(this).attr('data-responsible_previous'), $(this).attr('data-responsible_previous_name')]);
        }
      });
      if (listZero.length > 0) {
        $.post('/ajax/contacts.php', {type: 'responsible_set_zero',data: listZero})
          .done (function(data) {
          });
          setTimeout(function () {
            contactsListUpdate();
          }, 300);
      } else {
        showError('Невозможно вернуть контакт, так как не указан предыдущий ответственный.');
        contactsListUpdate();
      }
    } else {
      var data = [];
      $('.contacts_str').each(function () {
        if ($(this).is(':visible') && $(this).find('.checkboxString').prop('checked') && ($('#responsibleList').val() !== $(this).attr('data-responsible'))) {
          if ($(this).attr('data-responsible_previous') === window.adminId && $('#responsibleList').val() !== window.adminId) {
            data.push([$(this).attr('data-id'), $(this).attr('data-responsible_previous')]);
          } else {
            data.push([$(this).attr('data-id'), $(this).attr('data-responsible')]);
          }
          if ($(this).attr('data-id') === $('#saveContact').attr('data-id')) {
            if ($(this).attr('data-responsible_previous') !== window.adminId) {
              $('#responsibleContact').attr('data-responsible_previous', $('#responsibleContact').attr('data-responsible'));
            }
            $('#responsibleContact').attr('data-responsible', $('#responsibleList').val());
            $('#responsibleContact').val($('#responsibleList').val());
          }
        }
      });
      if (data.length === 0) {
        showHint('Назначаемый ответственный не должен совпадать с текущим ответственным');
        return
      }
      var responsibleArr = [$('#responsibleList').val(), fullNameToShortFirstMiddleNames($('#responsibleList option:selected').text(), true)];

    // ПРОВЕРИТЬ на больших объёмах, возможно лучше действовать синхронно, что бы запрос не выполнился прежде формирования массива содержащего данные для запроса
      $.post('/ajax/contacts.php', {type: 'responsible_set', responsible: responsibleArr, id: data})
        .done (function(data) {
        });

      setTimeout(function () {
        contactsListUpdate();
        showHint('Заказы переданы');
        $.get('/ajax/contacts.php?get_contacts_prev', {cont_role: data_page.admin_contacts_role})
              .done (function(data) {
                blankCounter.blank_count_their = data.contacts;
                //blankCounter.counter;
              })
      }, 300);
    }
  }

  function renewComboboxesResponsibles() {
    if (data_page.admin_contacts_role === "1" || data_page.admin_contacts_role === "2") {
      fetch('/ajax/contacts.php?get_short_statistics_for_comboboxes')
      .then(response => response.json())
      .then(commits => {
        addNumberToComboboxes(commits, true);
      });
    }
  }

  $('#appointResponsible , #appointResponsibleAdminZero').click(function(e) {

    if (data_page.admin_contacts_role === '0') {
      responsibleSetContact();
      $('#deleteContactsShowModal').attr('disabled', true);
      $('#appointStatusShow').attr('disabled', true);
      $('#deleteContact').attr('disabled', true);
      $('#appointResponsibleShow').attr('disabled', true);
      $('#checkAllStrings').prop('checked', false);
    } else {
      if ($('#responsibleList').val() === '_all_') {
        e.stopPropagation();
        showError('Выберите ответственного');
      } else {
        responsibleSetContact();
        $('#deleteContactsShowModal').attr('disabled', true);
        $('#appointStatusShow').attr('disabled', true);
        $('#deleteContact').attr('disabled', true);
        $('#appointResponsibleShow').attr('disabled', true);
        $('#checkAllStrings').prop('checked', false);
        setTimeout(function () {
          $('#appointResponsible').attr('disabled', true);
          $('.contacts_str').find('.checkboxString').each(function () {
            $(this).prop('checked', false);
          });
          renewComboboxesResponsibles();
        }, 300);
      }
    }
  });

  function contactsListUpdate(idStr) {
    let promise = $.get('/ajax/contacts.php?get_contacts', {role: data_page.admin_contacts_role})
      .done (function(data) {
        contactsStringsLoad(data.contacts, idStr);
      });
      promise.then(function (e) {
        //console.log(e);
      });
    }

    contactsListUpdate();

    function contactStringLoader(data) {
      //console.log(data);
      // Доделать для новых карточек добавление строк
      if (!data) {
        return
      }
      /*var countryName = '';
      $(this).attr('data-country_key') ? countryName = data_page.country_list[$(this).attr('data-country_key')] : '';*/

      if (data_page.admin_contacts_role === '0') {
        var first = '', second = '';
        first = '<option value="'+$('.active_string').attr('data-responsible')+'">'+fullNameToNoMiddleName($('.active_string').attr('data-responsible_name'))+'';
        if ($('.active_string').attr('data-responsible_previous')) {
         second = '<option value="'+$('.active_string').attr('data-responsible_previous')+'">'+fullNameToNoMiddleName($('.active_string').attr('data-responsible_previous_name'))+'';
        }
        $('#responsibleContact').html(first+second);
      }

        var email = data.email === ' ' ? '' : data.email;
        var region = data.region === ' ' ? '' : data.region;
        var area = data.area === ' ' ? '' : data.area;
        var locality = data.locality === ' ' ? '' : data.locality;
        var address = data.address === ' ' ? '' : data.address;
        var comment = data.comment === ' ' ? '' : data.comment;

// blank update
        $('#nameContact').val(data.name);
        $('#countryContact').val(data.country_key);
        $('#phoneContact').val(data.phone);
        $('#emailContact').val(email);
        $('#maleContact').val(data.male);
        $('#regionContact').val(region);
        $('#areaContact').val(area);
        $('#localityContact').val(locality);
        $('#indexContact').val(data.index_post);
        $('#addressContact').val(address);
        $('#commentContact').val(comment);
        $('#regionWorkContact').val(data.region_work);
        $('#responsibleContact').val(data.responsible);
        $('#responsibleContact').attr('data-responsible', data.responsible);
        $('#responsibleContact').attr('data-responsible_previous', data.responsible_previous);
        $('#saveContact').attr('data-id', data.id);
        $('#statusContact').val(data.status);
        $('#periodLabel').val(data.project);

// string update
        $('.active_string').find('.data_name').text(data.name);
        $('.active_string').attr('data-country_key', data.country_key);
        $('.active_string').find('.data_phone').text(data.phone);
        $('.active_string').attr('data-email', data.email);
        $('.active_string').attr('data-male', data.male);
        $('.active_string').attr('data-region', data.region);
        $('.active_string').attr('data-area', data.area);
        $('.active_string').find('.data_locality').text(data.locality);
        $('.active_string').attr('data-index_post', data.index_post);
        $('.active_string').attr('data-address', data.address);
        $('.active_string').attr('data-other', data.comment);
        $('.active_string').attr('data-region_work', data.region_work);
        $('.active_string').attr('data-responsible', data.responsible);
        $('.active_string').attr('data-responsible_previous', data.responsible_previous);
        $('.active_string').attr('data-id', data.id);
        $('.active_string').attr('data-period', data.project);
        $('.active_string').find('.data_status').next().next().text(data.project);
        $('.active_string').attr('data-status_key',data.status);
        $('.active_string').find('.data_status').text($('#statusContact option:selected').text());
        $('.active_string').find('.data_responsible_sort_name').text(fullNameToNoMiddleName(data.member_name));
        $('.active_string').find('.data_responsible_previous').text(fullNameToNoMiddleName(data_page.members_responsibles[data.responsible_previous]));

        if (data.order_date && data.order_date !== '0000-00-00') {
          dateOrd = dateStrToddmmyyyyToyyyymmdd(data.order_date, true);
          $('.active_string').attr('data-order_date', dateOrd);
          $('#orderDateEdit').val(data.order_date);
          $('#orderDate').text(dateOrd);
        } else {
          $('.active_string').attr('');
        }
        if ($('#modalSpinner').is(':visible')) {
          $('#modalSpinner').hide();
          $('#saveSpinner').hide();
        }
    }

    function stringUpdater(idStr) {
      $.get('/ajax/contacts.php?get_contact', {id: idStr})
      .done (function(data) {
        contactStringLoader(data.contact[0]);
      });
    }

  $('.cd-panel__close-watch').click(function(e) {
    e.preventDefault();
    if (checkChangedForSave()) {
      if (!confirm('Изменения не сохранены, закрыть карточку?')) {
        return
      }
    }
    setTimeout(function () {
      $('.cd-panel-watch').removeClass('cd-panel--is-visible-watch');
      $('.cd-panel__close-watch').removeClass('cd-panel__close-watch-visible');
      $('.active_string') ? $('.active_string').removeClass('active_string') : '';
    }, 50);
  });

  $('#cd-panel__close-watch').click(function() {
    if (checkChangedForSave()) {
      if (!confirm('Изменения не сохранены, закрыть карточку?')) {
        return
      }
    }
    setTimeout(function () {
      $('.cd-panel-watch').removeClass('cd-panel--is-visible-watch');
      $('.cd-panel__close-watch').removeClass('cd-panel__close-watch-visible');
      $('.active_string') ? $('.active_string').removeClass('active_string') : '';
    }, 50);
  });

  $('#addContact').click(function() {
    $('.active_string') ? $('.active_string').removeClass('active_string') : '';
    if (data_page.admin_contacts_role === '0') {
      $('#responsibleContact').html('<option value="'+window.adminId+'">'+fullNameToNoMiddleName(data_page.admin_name)+'');
    } else {
      $('#responsibleContact').val(window.adminId);
    }
    clearingBlankOfContact();
    $('#orderSentToContact').attr('disabled', false);
    $('#orderSentToContact').val('Отправить заказ');
    if ($('.cd-panel-watch').hasClass('cd-panel--is-visible-watch')) {

    } else {
      $('.cd-panel-watch').addClass('cd-panel--is-visible-watch');
      $('.cd-panel__close-watch').addClass('cd-panel__close-watch-visible');
    }

    $('#blankHistory').hide();
  });

  $('#checkAllStrings').click(function() {

    var counter;
    counters = 0;
      $('.contacts_str').each(function () {
        if (counters > 999) {
          return
        }
        if ($('#checkAllStrings').prop('checked')) {
          if ($(this).is(':visible')) {
            $(this).find('.checkboxString').prop('checked', true);
            if ($('#kindOfList').val() === 'trash') {
              return;
            }
            $('#deleteContact').attr('disabled') ? $('#deleteContact').attr('disabled', false) : '';
            $('#deleteContactsShowModal').attr('disabled') ? $('#deleteContactsShowModal').attr('disabled', false) : '';
            $('#appointStatusShow').attr('disabled') ? $('#appointStatusShow').attr('disabled', false) : '';
            $('#appointResponsible').attr('disabled') ? $('#appointResponsible').attr('disabled', false) : '';
            $('#appointResponsibleShow').attr('disabled') ? $('#appointResponsibleShow').attr('disabled', false) : '';
            counters++
          }
        } else {
          $(this).find('.checkboxString').prop('checked', false);
          $('#deleteContact').attr('disabled') ? '' : $('#deleteContact').attr('disabled', true);
          $('#deleteContactsShowModal').attr('disabled') ? '' : $('#deleteContactsShowModal').attr('disabled', true);
          $('#appointStatusShow').attr('disabled') ? '' : $('#appointStatusShow').attr('disabled', true);
          $('#appointResponsible').attr('disabled') ? '' : $('#appointResponsible').attr('disabled', true);
          $('#appointResponsibleShow').attr('disabled') ? '' : $('#appointResponsibleShow').attr('disabled', true);
        }
      });
  });
  $('.checkAllStrings').click(function() {
      $('.contacts_str').each(function () {
        if ($('.checkAllStrings').prop('checked')) {
          if ($(this).is(':visible')) {
            $(this).find('.checkboxString').prop('checked', true);
            $('#deleteContact').attr('disabled') ? $('#deleteContact').attr('disabled', false) : '';
            $('#deleteContactsShowModal').attr('disabled') ? $('#deleteContactsShowModal').attr('disabled', false) : '';
            $('#appointStatusShow').attr('disabled') ? $('#appointStatusShow').attr('disabled', false) : '';
            $('#appointResponsible').attr('disabled') ? $('#appointResponsible').attr('disabled', false) : '';
            $('#appointResponsibleShow').attr('disabled') ? $('#appointResponsibleShow').attr('disabled', false) : '';
          }
        } else {
          $(this).find('.checkboxString').prop('checked', false);
          $('#deleteContact').attr('disabled') ? '' : $('#deleteContact').attr('disabled', true);
          $('#deleteContactsShowModal').attr('disabled') ? '' : $('#deleteContactsShowModal').attr('disabled', true);
          $('#appointStatusShow').attr('disabled') ? '' : $('#appointStatusShow').attr('disabled', true);
          $('#appointResponsible').attr('disabled') ? '' : $('#appointResponsible').attr('disabled', true);
          $('#appointResponsibleShow').attr('disabled') ? '' : $('#appointResponsibleShow').attr('disabled', true);
        }
      });
  });
// SENTO ORDER TO
function sendTheOrder(ua) {

  var name = $('#nameContact').val(),
  country = $('#countryContact option:selected').text(),
  region = $('#regionContact').val(),
  area = $('#areaContact').val(),
  locality = $('#localityContact').val(),
  address = $('#addressContact').val(),
  index = $('#indexContact').val(),
  howMuch = 1,
  phone = $('#phoneContact').val(),
  email = $('#emailContact').val(),
  notesOfAdmin = $('#adminNotes').val(),
  commentNotForCrm = '',
  isFirstOrder = false,
  comment = 'Заказ отправил(а) ' + fullNameToNoMiddleName(data_page.admin_name)+'.';
  notesOfAdmin = notesOfAdmin.replace(/\"/g, "\'");
  var commentFromBlank = $('#commentContact').val();
  commentFromBlank = commentFromBlank.replace(/\"/g, "\'");
  var dateNow = new Date().toISOString().slice(0,10);
  var dateNow = dateStrToddmmyyyyToyyyymmdd(dateNow, true);
  var lastOrderTextIs = $('#orderDate').text();
  var lastOrderIs = $('#orderDateEdit').val();

  if ($('#orderDate').text() === '00.00.0000' || $('#orderDate').text() === '' || $('#orderDate').text() === 'null' || $('#orderDate').text() === null || $('#orderDate').text() === 'undefined' || $('#orderDate').text() === undefined) {
    isFirstOrder = true;
    $('#orderDate').text(dateNow);
    $('#orderDateEdit').val(dateNow);
    $('#labelOrderDate').text('Отправлен ');
    $('#orderDate').show();
  } else {
    comment = comment + ' Предыдущий заказ был ' + $('#orderDate').text() + '\n' + notesOfAdmin;
    commentNotForCrm =  commentNotForCrm + ' Предыдущий заказ был ' + $('#orderDate').text() + '. ' + notesOfAdmin + '\n';
    $('#orderDate').text(dateNow);
    $('#orderDateEdit').val(dateNow);
  }

  commentNotForCrm = commentNotForCrm + commentFromBlank;

  //$('#saveContact').attr('data-id_admin') ? data.admin = $('#saveContact').attr('data-id_admin') : data.admin = window.adminId;

  function addCrmId(crm_id) {
    if (crm_id.result === true) {
      crm_id = '';
    }
    var text = 'Отправлен заказ.';
    if (!isFirstOrder) {
      text = text + ' Предыдущий заказ был ' + lastOrderTextIs + '.';
    }
    $.get('/ajax/contacts.php?add_crm_id', {crm_id: crm_id, id: $('#saveContact').attr('data-id'), text: text, comment: commentNotForCrm, notes: notesOfAdmin})
    .done(function(data){
    });
  }

    if (ua === 'UA') {
      var textMessage = 'ФИО: '+ name +'<br>Страна: '+ country +'<br>Область: '+ region +'<br>Район: '+ area +'<br>Местность: '+ locality +'<br>Адрес: '+ address +'<br>Индекс:'+ index  +'<br>Количество: '+ howMuch +'<br>Телефон: '+ phone +'<br>Емайл: '+ email +'<br>Комментарий: '+ commentNotForCrm + '. ' + notesOfAdmin +'<br>Отправлено с сайта: '+ dateNow + '<br>Отправил: '+ fullNameToNoMiddleName(data_page.admin_name);
      $.post('ajax/contacts.php', {type: 'message_ua',text_message: textMessage, name: fullNameToNoMiddleName(data_page.admin_name)})
      .done (function(data) {
          if (data) {
            addCrmId(data);
            showHint('Заказ отправлен команде проекта BFA');
          } else {
            showError('Что то пошло не так, обратитесь в тех. поддержку');
            console.log(data);
            $('#orderDateEdit').val(lastOrderIs);
            $('#orderDate').text(lastOrderTextIs);
            saveEditContactQuick();
          }
      });
    } else if (ua === 'LV') {
      var textMessage = 'ФИО: '+ name +'<br>Страна: '+ country +'<br>Область: '+ region +'<br>Район: '+ area +'<br>Местность: '+ locality +'<br>Адрес: '+ address +'<br>Индекс:'+ index  +'<br>Количество: '+ howMuch +'<br>Телефон: '+ phone +'<br>Емайл: '+ email +'<br>Комментарий: '+ commentNotForCrm + '. ' + notesOfAdmin +'<br>Отправлено с сайта: '+ dateNow + '<br>Отправил: '+ fullNameToNoMiddleName(data_page.admin_name);
      $.post('ajax/contacts.php', {type: 'message_lv',text_message: textMessage, name: fullNameToNoMiddleName(data_page.admin_name)})
      .done (function(data) {
          if (data) {
            addCrmId(data);
            showHint('Заказ отправлен команде проекта BFA');
          } else {
            showError('Что то пошло не так, обратитесь в тех. поддержку');
            console.log(data);
            $('#orderDateEdit').val(lastOrderIs);
            $('#orderDate').text(lastOrderTextIs);
            saveEditContactQuick();
          }
      });
    } else {
      $.post('crmapi.php', {name: name, value3: country, value4: region, value5: area, value6: locality, value7: address, value8: index, value1: howMuch, phone: phone, email: email, value2: comment})
      .done (function(data) {
        if (data === 'Failed') {
          showError('Что то пошло не так, обратитесь в тех. поддержку');
          $('#orderDateEdit').val(lastOrderIs);
          $('#orderDate').text(lastOrderTextIs);
          saveEditContactQuick();
        } else {
          addCrmId(data);
          showHint('Заказ отправлен команде проекта BFA');
        }
      });
    }
  }
  //log to PHP
  function setStringToLog(message, status) {
    if (!status) {
      status = 'INFO';
    }
    var url='ajax/contacts.php?set_log_CRM&message='+message+'&status='+status;
    fetch(url);
  }
  $('#orderSentToContact').click(function(e) {

    if ($('#kindOfList').val() === 'trash') {
      showError('Операции с карточками в корзине запрещены, сначала восстановите карточку.');
      return;
    }

    !$('#nameContact').val() ? $('#nameContact').css('border-color', 'red') : $('#nameContact').css('border-color', '#ced4da');
    !$('#countryContact').val() ? $('#countryContact').css('border-color', 'red') : $('#countryContact').css('border-color', '#ced4da');
    $('#maleContact').val() === '_none_' ? $('#maleContact').css('border-color', 'red') : $('#maleContact').css('border-color', '#ced4da');
    !$('#phoneContact').val() ? $('#phoneContact').css('border-color', 'red') : $('#phoneContact').css('border-color', '#ced4da');
    !$('#regionContact').val() ? $('#regionContact').css('border-color', 'red') : $('#regionContact').css('border-color', '#ced4da');
    !$('#localityContact').val() ? $('#localityContact').css('border-color', 'red') : $('#localityContact').css('border-color', '#ced4da');
    !$('#indexContact').val() ? $('#indexContact').css('border-color', 'red') : $('#indexContact').css('border-color', '#ced4da');
    !$('#addressContact').val() ? $('#addressContact').css('border-color', 'red') : $('#addressContact').css('border-color', '#ced4da');
    if (!$('#nameContact').val() || !$('#phoneContact').val() || !$('#regionContact').val() || !$('#localityContact').val() || !$('#indexContact').val() || !$('#addressContact').val()) {
      showError('Заполните поля выделенные красным цветом.');
      //setStringToLog('КОНТАКТ ' + $('#nameContact').val() + ', ID - ' + $('#saveContact').attr('data-id')+' Нажатие на кнопку - ОТПРАВИТЬ ЗАКАЗ. Итог - неудача, НЕ ВСЕ ПОЛЯ ЗАПОЛНЕНЫ.', 'FATAL');
      e.stopPropagation();
      return
    } else {
      $('#nameContact').css('border-color', '#ced4da');
      $('#countryContact').css('border-color', '#ced4da');
      $('#maleContact').css('border-color', '#ced4da');
      $('#addressContact').css('border-color', '#ced4da');
      $('#indexContact').css('border-color', '#ced4da');
      $('#localityContact').css('border-color', '#ced4da');
      $('#regionContact').css('border-color', '#ced4da');
      $('#phoneContact').css('border-color', '#ced4da');
      $('#saveConfirm').show();
    }
    //setStringToLog('КОНТАКТ ' + $('#nameContact').val() + ', ID - ' + $('#saveContact').attr('data-id')+' Нажатие на кнопку - ОТПРАВИТЬ ЗАКАЗ. Итог - переход к модальному окну подтверждения.', 'WARNING');
    $('#saveConfirm').find('h6').html('Примечание к заказу');
    $('#adminNotes').val('');
  });

  $('#saveCancelConfirmBtn').click(function() {
    //setStringToLog('КОНТАКТ ' + $('#nameContact').val() + ', ID - ' + $('#saveContact').attr('data-id')+' Нажатие на кнопку - ОТМЕНИТЬ. Итог - закрытие модального окна подтверждения отправки заказа.', 'ERROR');
    $('#saveConfirm').hide();
  });

  $('#saveConfirmBtn').click(function() {
    //setStringToLog('КОНТАКТ ' + $('#nameContact').val() + ', ID - ' + $('#saveContact').attr('data-id')+' Нажатие на кнопку - ОТПРАВИТЬ в модальной форме заказа. Итог - необходимо проверить лог отправки в CRM.', 'WARNING');
    function sendOrderToCRMExtra() {
      if ($('#countryContact').val() === 'UA') {
        sendTheOrder('UA');
        $('#saveConfirm').hide();
      } else if ($('#countryContact').val() === 'LV') {
        sendTheOrder('LV');
        $('#saveConfirm').hide();
      } else {
        sendTheOrder();
        $('#saveConfirm').hide();
      }
      $('#orderSentToContact').val('Заказ отправлен');
      $('#orderSentToContact').attr('disabled', true);
    }

    $('#modalSpinner').show();
    $('#saveSpinner').show();
    if (data_page.admin_contacts_role !== '0') {
      $('#blankHistory').show();
    }
    $('#statusContact').val() !== '4' ? $('#statusContact').val('4') : '';

    if (!$('#saveContact').attr('data-id')) {
      saveEditContact();
      function tmpTempTemp() {
        sendOrderToCRMExtra();
        //console.log('I\m there!');
        $('#modalSpinner').show();
        $('#saveSpinner').show();
        setTimeout(function () {
          $('#modalSpinner').hide();
          $('#saveSpinner').hide();
        }, 2000);
      }
        setTimeout(function () {
          if ($('#modalSpinner').is(':visible')) {
            setTimeout(function () {
              if ($('#modalSpinner').is(':visible')) {
                setTimeout(function () {
                  if ($('#modalSpinner').is(':visible')) {
                    setTimeout(function () {
                      if ($('#modalSpinner').is(':visible')) {
                        setTimeout(function () {
                          if ($('#modalSpinner').is(':visible')) {
                            setTimeout(function () {
                              if ($('#modalSpinner').is(':visible')) {
                                setTimeout(function () {
                                  if ($('#modalSpinner').is(':visible')) {
                                    tmpTempTemp();
                                  } else {
                                    tmpTempTemp();
                                  }
                                }, 500);
                              }else {
                                tmpTempTemp();
                              }
                            }, 500);
                          }else {
                            tmpTempTemp();
                          }
                        }, 500);
                      }else {
                        tmpTempTemp();
                      }
                    }, 500);
                  }else {
                    tmpTempTemp();
                  }
                }, 500);
              }else {
                tmpTempTemp();
              }
            }, 500);
          }else {
            tmpTempTemp();
          }
          //console.log('I\m here!');
        }, 1000);

    } else {
      sendOrderToCRMExtra();
      setTimeout(function () {
        saveEditContact();
      }, 1500);
    }

    setTimeout(function () {
      if ($('#modalSpinner').is(':visible')) {
        $('#modalSpinner').hide();
        $('#saveSpinner').hide();
      }
    }, 2500);
  });

  $('#appointResponsibleShow').click(function() {
    if (data_page.admin_contacts_role !== '0') {
      $('#responsibleList').val('_all_');
      $('#listForSetRespAdminNoZero').html('');
      $('#setResponsibleModal').modal().show();
    } else {
      var lists = [];
      $('.contacts_str').each(function () {
        if ($(this).find('.checkboxString').prop('checked')) {
          lists.push($(this).find('.data_name').text() + ' 	&#8658; ' + $(this).attr('data-responsible_previous_name') + '<br>');
        }
      });
      $('#listForSetRespAdminZero').html(lists);
      $('#setResponsibleModalAdminZero').modal().show();
    }
  });

  $('#responsibleList').change(function() {
    var listsResponsibles = [];
    var nameTmp = $('#responsibleList option:selected').text();
    nameTmp = nameTmp.split(' ');
    nameTmp = nameTmp[0] +' '+ nameTmp[1];
    $('.contacts_str').each(function () {
      if ($(this).find('.checkboxString').prop('checked')) {
        listsResponsibles.push($(this).find('.data_name').text() + ' 	&#8658; ' + nameTmp + '<br>');
      }
    });
    $('#listForSetRespAdminNoZero').html(listsResponsibles);
  });

// checking changed any fields in the blank
    function checkChangedForSave() {
      if ($('#nameContact').val() === $('.active_string').find('.data_name').text() && $('#countryContact').val() === $('.active_string').attr('data-country_key') && $('#phoneContact').val() === $('.active_string').find('.data_phone').text() && $('#emailContact').val() === $('.active_string').attr('data-email') && $('#maleContact').val() === $('.active_string').attr('data-male') && $('#periodLabel').val() === $('.active_string').attr('data-period') && $('#regionContact').val() === $('.active_string').attr('data-region') && $('#areaContact').val() === $('.active_string').attr('data-area') && $('#localityContact').val() === $('.active_string').find('.data_locality').text() && $('#indexContact').val() === $('.active_string').attr('data-index_post') && $('#addressContact').val() === $('.active_string').attr('data-address') && $('#commentContact').val() === $('.active_string').attr('data-other') && $('#regionWorkContact').val() === $('.active_string').attr('data-region_work') && $('#responsibleContact').val() === $('.active_string').attr('data-responsible') && $('#responsibleContact').attr('data-responsible') === $('.active_string').attr('data-responsible') &&  $('#responsibleContact').attr('data-responsible_previous') === $('.active_string').attr('data-responsible_previous') &&  $('#saveContact').attr('data-id') === $('.active_string').attr('data-id') && ($('#statusContact').val() === $('.active_string').attr('data-status_key')) && (($('#orderDate').text() === $('.active_string').attr('data-order_date')) || ($('#orderDate').text() === '' &&  $(this).attr('data-order_date') === undefined))
      ){
        return false
      } else {
        return true
      }

      // (!$('.active_string').attr('data-status_key') && $('#statusContact').val() === null);
      //$('#sendingDate').text() === $(this).attr('data-sending_date');
    }

  $('#orderDate').hide();
  $('#sendingDate').parent().hide();

  function filtersOfString() {
    var containerElement;
    if (data_page.isDesktop === 1) {
      containerElement = '#listContacts .contacts_str';
    } else {
      containerElement = '#listContactsMbl .contacts_str';
    }

    var filterBlank, text, fio, loc, region, searchResult, periods, counter;
    counter = 0;
    text = $('#search-text').val().trim();
    $(containerElement).each(function() {
      // Search text
      if (text.length > 2) {
        fio = $(this).find('.data_name').text().trim();
        loc = $(this).find('.data_locality').text().trim();
        region = $(this).attr('data-region');
        searchResult = true;
        if (fio.toLowerCase().indexOf(String(text.toLowerCase())) === -1  && loc.toLowerCase().indexOf(String(text.toLowerCase())) === -1 && region.toLowerCase().indexOf(String(text.toLowerCase())) === -1) {
          searchResult = false;
        }
      } else {
        searchResult = true;
      }
      // STOP Search text
      //Filter currents blanks
      if (data_page.admin_contacts_role === '0') {
        filterBlank = ($('#myBlanks').val() === '1' && $(this).attr('data-responsible') === window.adminId) || ($('#myBlanks').val() === '0' && $(this).attr('data-responsible_previous') === window.adminId);
      } else {
        filterBlank = ($('#myBlanks').val() === '1' && $(this).attr('data-responsible') === window.adminId) || ($('#myBlanks').val() === '0' && $(this).attr('data-responsible_previous') === window.adminId) || ($('#myBlanks').val() === '_all_');
      }

      //Stop Filter currents blanks
      if ($('#myBlanks').val() === '0' &&  data_page.admin_contacts_role === '0') {
        $('#checkAllStrings').attr('disabled', true);
        $('#addContact').attr('disabled', true);
      } else {
        $('#checkAllStrings').attr('disabled', false);
        $('#addContact').attr('disabled', false);
      }

      if (($('#periodsCombobox').val() === '_all_' || $('#periodsCombobox').val() === $(this).attr('data-period')) && ($('#maleShow').val() === '_all_' || $('#maleShow').val() === $(this).attr('data-male')) && ($('#statusShow').val() === '_all_' || $('#statusShow').val() === $(this).attr('data-status_key')) && ($('#respShow').val() === '_all_' || ($('#respShow').val() === $(this).attr('data-responsible') || $('#respShow').val() === $(this).attr('data-responsible_previous'))) && ($('#leftPanelCountryFilter').val() === '_all_' || $('#leftPanelCountryFilter').val() === $(this).attr('data-country_key')) && ($('#leftPanelRegionFilter').val() === '_all_' || $('#leftPanelRegionFilter').val() === $(this).attr('data-region_work')) && filterBlank && searchResult) {
        $(this).show();
        counter++;
        if ($('#myBlanks').val() === '0' &&  data_page.admin_contacts_role === '0') {
          $(this).find('.checkboxString').attr('disabled', true);
        } else {
          $(this).find('.checkboxString').attr('disabled', false);
        }
      } else {
        $(this).hide();
        if ($('.cd-panel-watch').hasClass('cd-panel--is-visible-watch') && $('#saveContact').attr('data-id') === $(this).attr('data-id')) {
          clearingBlankOfContact();
          closeSidePanel();
        }
      }
    });
    return counter
  }

/*
  $('#search-text').bind("paste keyup", function(event){
    event.stopPropagation();
    filtersOfString();
    });
*/
  $('#searchBtn').click(function(){
    filtersOfString();
  });

  $('#search-text').keypress(function(event){
    if (event.which == 13) {
      filtersOfString();
    }
  });

    $('#search-text').click(function(event){
      event.stopPropagation();
      if ($(this).val().length > 0) {
        setTimeout(function () {
          if (!$('#search-text').val()) {
            filtersOfString();
          }
        }, 30);
      }
    });
// change date in the blank
    $('#orderDate').click(function(){
      if (data_page.admin_contacts_role === '0' && $('#myBlanks').val() === '0') {
        return
      }
      $('#orderDateEdit').parent().show();
      $('#commentContact').parent().parent().height($('#commentContact').parent().parent().height() - 50);
      $(this).hide();
    });

    $('#orderDateEditIcoCancel').click(function(){
      $('#orderDate').show();
      $('#orderDateEditIco').show();
      $('#commentContact').parent().parent().height($('#commentContact').parent().parent().height() + 50);
      $(this).parent().hide();
    });

    $('#orderDateEditIcoOk').click(function(){
      if ($('#orderDateEdit').val()) {
        $('#orderDate').show();
        var dateorder = dateStrToddmmyyyyToyyyymmdd($('#orderDateEdit').val(), true);
        $('#orderDate').text(dateorder);
        $('#labelOrderDate').text('Отправлен ');
      } else {
        $('#labelOrderDate').text('Заказа не было');
        $('#orderDate').hide();
        $('#orderDate').text('');
      }
      $('#orderDateEditIco').show();
      $('#commentContact').parent().parent().height($('#commentContact').parent().parent().height() + 50);
      $(this).parent().hide();
    });

    $('#sort-name-contact, #sort-name').click(function () {
      if ($(this).next().hasClass('icon_none')) {
        $(this).next().removeClass('icon_none');
        $(this).next().addClass('fa-caret-down');
        $('#sort-locality-contact').next().removeClass('fa-caret-down');
        $('#sort-locality-contact').next().removeClass('fa-caret-up');
        $('#sort-locality-contact').next().addClass('icon_none');
        $('#sort-locality').next().removeClass('fa-caret-down');
        $('#sort-locality').next().removeClass('fa-caret-up');
        $('#sort-locality').next().addClass('icon_none');
        contactsStringsLoad([], false, 'sortingByName2');
      } else if ($(this).next().hasClass('fa-caret-down')) {
        $(this).next().removeClass('fa-caret-down');
        $(this).next().addClass('fa-caret-up');
        contactsStringsLoad([], false, 'sortingByName')
      } else if ($(this).next().hasClass('fa-caret-up')) {
        $(this).next().removeClass('fa-caret-up');
        $(this).next().addClass('fa-caret-down');
        contactsStringsLoad([], false, 'sortingByName2')
      }
    });

    $('#sort-locality-contact, #sort-locality').click(function () {
      if ($(this).next().hasClass('icon_none')) {
        $(this).next().removeClass('icon_none');
        $(this).next().addClass('fa-caret-down');
        $('#sort-name-contact').next().removeClass('fa-caret-down');
        $('#sort-name-contact').next().removeClass('fa-caret-up');
        $('#sort-name-contact').next().addClass('icon_none');
        $('#sort-name').next().removeClass('fa-caret-down');
        $('#sort-name').next().removeClass('fa-caret-up');
        $('#sort-name').next().addClass('icon_none');
        contactsStringsLoad([], false, 'sortingByLocality2')
      } else if ($(this).next().hasClass('fa-caret-down')) {
        $(this).next().removeClass('fa-caret-down');
        $(this).next().addClass('fa-caret-up');
        contactsStringsLoad([], false, 'sortingByLocality')
      } else if ($(this).next().hasClass('fa-caret-up')) {
        $(this).next().removeClass('fa-caret-up');
        $(this).next().addClass('fa-caret-down');
        contactsStringsLoad([], false, 'sortingByLocality2')
      }
    });

    $('#deleteContactsShowModal').find('.fa-trash').click(function () {
      if ($('#deleteContactsShowModal').attr('disabled')) {
        showError('Выделите контакты для удаления');
      }
    });
    $('#appointResponsibleShow').find('.fa-exchange').click(function () {
      if ($('#deleteContactsShowModal').attr('disabled')) {
        showError('Выделите контакты, которые следует передать');
      }
    });
    $('#appointStatusShow').find('.fa-flag').click(function () {
      if ($('#deleteContactsShowModal').attr('disabled')) {
        showError('Выделите контакты для смены статуса');
      }
    });

    $('#deleteContactsShowModal').click(function () {

      if (data_page.admin_contacts_role === '0') {
        $('.helpDeleteContact').hide();
        $('#archiviateContact').attr('disabled', true);
        $('#archiviateContact').hide();
      }

      var list =[];
      $('.contacts_str').each(function () {
        if ($(this).is(':visible') && $(this).find('.checkboxString').prop('checked')) {
          list.push($(this).find('.data_name').text()+'<br>');
        }
      });
      $('#listDeleteStr').html(list);
    });

    $('#appointStatusShow').click(function () {
      var list =[];
      $('#comboStatusModal').val('');
      $('.contacts_str').each(function () {
        if ($(this).is(':visible') && $(this).find('.checkboxString').prop('checked')) {
          list.push($(this).find('.data_name').text()+'<br>');
        }
      });
      $('#listStatusStr').html(list);
    });

    $('#comboStatusModal').change(function() {
      if ($('#comboStatusModal').val()) {
        $('#statusContactBtn').attr('disabled', false)
      } else {
        $('#statusContactBtn').attr('disabled', true)
      }
    });
    $('#saveConfirmCrosForClose').click(function() {
      $('#saveConfirm').hide();
    });

    // notifications


    // STOP notifications
// STOP change date in the blank
  /*$('#openUploadModal').click(function() {
    $('#uploadModal').modal('show');
  });

// MODAL UPLOAD
  $('#closeUploadModal').click(function() {
    $('#uploadModal').modal('hide');
  });*/

  //$('#listContacts').html();

// START blank counter for statistics
// dinamic update data of statistics
// ДОбавить свойство при котором будут запускаться запросы и обновления статистики. Проверить связи.
  if (data_page.admin_contacts_role !== '0') {
    blankCounter.counter = setTimeout (function () {
      if (!blankCounter.blank_count_their[0]) {
        //console.log(blankCounter.blank_count_their);
        return;
      }
      var xex = [], arr = blankCounter.blank_count_their;
        for (var i = 0; i < arr.length; i++) {
            if (arr[i]['responsible'] in xex) {
              xex[arr[i]['responsible']] += 1;
            } else {
              xex[arr[i]['responsible']] = 1;
            }
        }
      blankCounter.blank_count_their_short  = xex;
    },2000);

    blankCounter.status_stat = setTimeout (function () {
      if (!blankCounter.blank_count_their[0]) {
        //console.log(blankCounter.blank_count_their);
        return
      }
      var xey = [];
      arr2 = blankCounter.blank_count_their;
      for (var ii = 0; ii < arr2.length; ii++) {
          if (arr2[ii]['responsible'] in xey) {
            xey[arr2[ii]['responsible']][0] += 1;
            if (Number(arr2[ii]['status'])) {
              xey[arr2[ii]['responsible']][Number(arr2[ii]['status'])] += 1;
            } else {
              xey[arr2[ii]['responsible']][8] += 1;
            }
          } else {
            xey[arr2[ii]['responsible']] = [0,0,0,0,0,0,0,0,0,'0']
            xey[arr2[ii]['responsible']][0] = 1;
            xey[arr2[ii]['responsible']][9] = arr2[ii]['member_name'];
            if (Number(arr2[ii]['status'])) {
              xey[arr2[ii]['responsible']][Number(arr2[ii]['status'])] = 1;
            } else {
              xey[arr2[ii]['responsible']][8] = 1;
            }
          }
        }
        blankCounter.blank_count_status = xey;
    },3000);

    function addNumberToComboboxes(data, update) {
      if (!data || Object.keys(data).length < 1) {
        return;
      }

      $("#responsibleList option").each(function () {
        if ($(this).val() in data) {

        } else {
          if ($(this).val() !== "_all_") {
            data[$(this).val()] = [$(this).text(),'Х'];
          }
        }
      });
      // ДОБАВИТЬ СОРТИРОВКУ МАССИВА ПО ФАМИЛИЯМ
      if (update === true) {
        var html = [];
        for (var key in data) {
          // Добавляем ответственного, которого нет в списке, но он есть, как предыдущий ответственный в карточках
          // удаляем существующих
          if (data_page.responsible_previous[key]) {
            delete data_page.responsible_previous[key];
          }
          if (data.hasOwnProperty(key)) {
             html.push('<option value="'+key+'">'+fullNameToNoMiddleName(data[key][0])+ ' - '+data[key][1]);
          }
        }
        // Добавляем недостающих ответственных
        for (let variable in data_page.responsible_previous) {
          if (data_page.responsible_previous.hasOwnProperty(variable)) {
            if (variable[0] !== undefined) {
              html.push('<option value="'+variable+'">'+fullNameToNoMiddleName(data_page.full_admin_list[variable][0])+'</option>');
            }
          }
        }

        let filterValue = $('#respShow').val();
        $('#responsibleContact').html(html);
        html.unshift('<option value="_all_">Все ответственные');
        $('#respShow').html(html)
        $('#responsibleList').html(html);
        $('#respShow').val(filterValue);
        return;
      }

      $('#respShow option').each(function () {
        if ($(this).val() in data) {
          $(this).text($(this).text() + ' - ' + data[$(this).val()]);
        }
      });

      $('#responsibleContact option').each(function () {
        if ($(this).val() in data) {
          $(this).text($(this).text() + ' - ' + data[$(this).val()]);
        }
      });

      $('#responsibleList option').each(function () {
        if ($(this).val() in data) {
          $(this).text($(this).text() + ' - ' + data[$(this).val()]);
        }
      });
    }

    function fillInStatusStatistic(data) {
      var html = [];
      for (i in data) {
        html.push('<tr><td style="text-align: left;">'+fullNameToNoMiddleName(data[i][9])+'</td><td class="bg-light"><b>'+(data[i][0] == '0' ? '-' : data[i][0])+'</b></td><td>'+(data[i][7] == '0' ? '-' : data[i][7]) +'</td><td> '+(data[i][1] == '0' ? '-' : data[i][1])+'</td><td>'+(data[i][2] == '0' ? '-' : data[i][2])+'</td><td>'+(data[i][3] == '0' ? '-' : data[i][3])+'</td><td>'+(data[i][4]  == '0' ? '-' : data[i][4])+'</td><td>'+(data[i][5]  == '0' ? '-' : data[i][5])+'</td><td> '+(data[i][6]  == '0' ? '-' : data[i][6])+'</td><td>'+(data[i][8] == '0' ? '-' : data[i][8]) +'</td></tr>');
      }
      $('#listMyResp').html(html);
    }

    $('#respStatistic').click(function () {
      $('#respWindowStatistic').show();
    });

    setTimeout(function () {
      renewComboboxesResponsibles();
      fillInStatusStatistic(blankCounter.blank_count_status);
      //console.log(blankCounter.blank_count_status);

    }, 4000);
  // STOP blank counter for statistics
  }

  $('#phoneContact').focusout(function () {
    if ($('#phoneContact').val()) {
      var phoneNumberTmp = $('#phoneContact').val().trim();
      if (phoneNumberTmp[0] === '+' || phoneNumberTmp[0] === '8') {
       phoneNumberTmp = 'tel:' + phoneNumberTmp;
     } else {
       phoneNumberTmp = 'tel:+' + phoneNumberTmp;
     }
     $('#phoneContactCalling').attr('href', phoneNumberTmp);
   } else {
     $('#phoneContactCalling').attr('href', '#');
   }
  });
//START Responsibles choise
  $('#respAdmin').show(function () {
    var htmlAdminsList =['<span class=""><label><input id="selectAllAdminsStrs" type="checkbox"> Отметить все</label><br></span>'];
    var visibility, attr;
    if (data_page.admin_contacts_role === '2') {
      for (var va500 in data_page.full_admin_list) {
        if (data_page.full_admin_list.hasOwnProperty(va500)) {
          if (data_page.my_responsibles.indexOf(va500) !== -1) {
            visibility = 'style="display: none"';
            attr = 'data-added="1"';
          } else {
            visibility = '';
            attr = '';
          }
            if (va500[0] === '0') {
              htmlAdminsList.push('<span class="list_admins_str" '+visibility+'><label class="font-weight-normal"><input type="checkbox" data-admin_key="'+va500+'" data-locality="'+data_page.full_admin_list[va500][1]+'" '+attr+'> '+fullNameToNoMiddleName(data_page.full_admin_list[va500][0])+'</label><br></span>');
            }
        }
      }
    } else {
      for (var va in data_page.my_localities_admins) {
        if (data_page.my_localities_admins.hasOwnProperty(va)) {
          if (data_page.my_responsibles.indexOf(va) !== -1) {
            visibility = 'style="display: none"';
            attr = 'data-added="1"';
          } else {
            visibility = '';
            attr = '';
          }
            htmlAdminsList.push('<span class="list_admins_str" '+visibility+'><label class="font-weight-normal"><input type="checkbox" data-admin_key="'+va+'" data-locality="'+data_page.my_localities_admins[va][1]+'" '+attr+'> '+fullNameToNoMiddleName(data_page.my_localities_admins[va][0])+'</label><br></span>');
        }
      }
    }
    $('#fullListOfAdmins').html(htmlAdminsList);

    // my admins
    var htmlMyAdminsList =['<span class=""><label><input id="selectAllMyAdminsStrs" type="checkbox"> Отметить все</label><br></span>'];
    var myResponsibles;

    if (data_page.my_responsibles) {
      myResponsibles = data_page.my_responsibles.split(',');
      for (var i = 0; i < myResponsibles.length; i++) {
        if (data_page.full_admin_list[myResponsibles[i]]) {
          htmlMyAdminsList.push('<span class="list_my_admins_str"><label class="font-weight-normal"><input data-admin_key="'+myResponsibles[i]+'" data-locality="'+data_page.full_admin_list[myResponsibles[i]][1]+'" type="checkbox"> '+fullNameToNoMiddleName(data_page.full_admin_list[myResponsibles[i]][0])+'</label><br></span>');
        }
      }
    }

    $('#myListOfAdmins').html(htmlMyAdminsList);

// for admin 2 Localities
// deny for contacts admin 0
      var htmlLocalitiesListCombo = ['<option value="_all_">Все местности</option>'];
      var htmlLocalitiesMyListCombo = ['<option value="_all_">Все местности</option>'];

      if (data_page.admin_contacts_role === '2') {
        for (var vari4 in data_page.locality) {
          if (data_page.locality.hasOwnProperty(vari4)) {
              htmlLocalitiesListCombo.push('<option value="'+vari4+'">'+data_page.locality[vari4]+'</option>');
          }
        }
        for (var vari2 in data_page.admin_localities) {
          if (data_page.admin_localities.hasOwnProperty(vari2)) {
              htmlLocalitiesMyListCombo.push('<option value="'+vari2+'">'+data_page.admin_localities[vari2]+'</option>');
          }
        }
      } else {
        for (var vari2 in data_page.admin_localities) {
          if (data_page.admin_localities.hasOwnProperty(vari2)) {
              htmlLocalitiesListCombo.push('<option value="'+vari2+'">'+data_page.admin_localities[vari2]+'</option>');
          }
        }
        for (var vari2 in data_page.admin_localities) {
          if (data_page.admin_localities.hasOwnProperty(vari2)) {
              htmlLocalitiesMyListCombo.push('<option value="'+vari2+'">'+data_page.admin_localities[vari2]+'</option>');
          }
        }
      }
// добавить местности админа вверху
      $('#filterRespFullList').html(htmlLocalitiesListCombo);
      $('#filterRespMyList').html(htmlLocalitiesMyListCombo);

// for supervisor, contacts admin 2 admins
    if (data_page.admin_contacts_role === '2') {
      var htmlAllAdminsListCombo =['<option value="_all_">Все ответственные</option>'];
      for (var vari in data_page.full_admin_list) {
        if (data_page.full_admin_list.hasOwnProperty(vari)) {
          if (vari === window.adminId) {
            htmlAllAdminsListCombo.push('<option value="'+vari+'" selected>'+fullNameToNoMiddleName(data_page.full_admin_list[vari][0])+'</option>');
          } else {
            if (vari[0] !== '9') {
              htmlAllAdminsListCombo.push('<option value="'+vari+'">'+fullNameToNoMiddleName(data_page.full_admin_list[vari][0])+'</option>');
            }
          }
        }
      }
      $('#fullAdminsListCombo').html(htmlAllAdminsListCombo);

      var htmlAllLocalitiesListCombo =['<option value="_all_">Все местности</option>'];
      for (var vari3 in data_page.locality) {
        if (data_page.locality.hasOwnProperty(vari3)) {
          if (vari3 == data_page.admin_locality) {
            htmlAllLocalitiesListCombo.push('<option value="'+vari3+'" selected>'+data_page.locality[vari3]+'</option>');
          } else {
            htmlAllLocalitiesListCombo.push('<option value="'+vari3+'">'+data_page.locality[vari3]+'</option>');
          }
        }
      }
      $('#allLocalitisesListCombo').html(htmlAllLocalitiesListCombo);

      $.get('/ajax/contacts.php?get_admin_role', {id: $('#fullAdminsListCombo').val()})
        .done (function(data) {
          $('#roleListCombo').val(data.result[0])
      });
    }
    if (data_page.admin_contacts_role === '2') {
      setTimeout(function () {
        addOptionsToCommboRole2();
      }, 300);
    }
/*
// for supervisor, contacts admin 2 Localities
    if (true) {
      var htmlAllLocalitiesListCombo =[];
      for (var vari in data_page.full_admin_list) {
        if (data_page.full_admin_list.hasOwnProperty(vari)) {
          if (vari === window.adminId) {
            htmlAllAdminsListCombo.push('<option value="'+vari+'" selected>'+fullNameToNoMiddleName(data_page.full_admin_list[vari][0])+'</option>');
          } else {
            htmlAllAdminsListCombo.push('<option value="'+vari+'">'+fullNameToNoMiddleName(data_page.full_admin_list[vari][0])+'</option>');
          }

        }
      }
      $('#fullAdminsListCombo').html(htmlAllAdminsListCombo);
    }
*/
  });

  function selectAllRespAdmins(id, strClass, parent) {
    if (id && strClass) {
      if ($('#'+id).prop('checked')) {
        $('#'+parent +' .'+strClass+':visible').each(function() {
          $(this).find('input').prop('checked', true);
        });
      } else {
        $('#'+parent +' .'+strClass).each(function() {
          $(this).find('input').prop('checked', false);
        });
      }
    }
  }
// для второго ИД работает не устойчиво
  $('#selectAllAdminsStrs, #selectAllMyAdminsStrs').click(function () {
    selectAllRespAdmins($(this).attr('id'), $(this).parent().parent().next().attr('class'), $(this).parent().parent().parent().attr('id'));
  });

  $('#addRespToMyList').click(function() {
    $('#fullListOfAdmins .list_admins_str:visible').each(function() {
      if ($(this).find('input').prop('checked')) {
        $(this).find('input').prop('checked',false);
        $(this).hide();
        $(this).attr('added', '1');
        $('#myListOfAdmins').append('<span class="list_my_admins_str"><label class="font-weight-normal"><input data-admin_key="'+$(this).find('input').attr('data-admin_key')+'" data-locality="'+$(this).find('input').attr('data-locality')+'" type="checkbox"> '+$(this).find('label').text()+'</label><br></span>');
      }
    });
    $('#selectAllAdminsStrs').prop('checked',false);
  });

  $('#removeRespFromMyList').click(function() {
    $('#myListOfAdmins .list_my_admins_str:visible').each(function() {
      if ($(this).find('input').prop('checked')) {
        $(this).find('input').prop('checked',false);
        $('#fullListOfAdmins [data-admin_key='+$(this).find('input').attr('data-admin_key')+']').parent().parent().show();
        $('#fullListOfAdmins [data-admin_key='+$(this).find('input').attr('data-admin_key')+']').attr('added', '');
        $(this).remove();
      }
    });

    $('#selectAllMyAdminsStrs').prop('checked',false);
  });

  $('#filterRespFullList, #filterRespMyList').change(function(e) {
    if (e.target.id === 'filterRespFullList') {

    }
    if (!$(this).next().find('span:nth-child(2)').attr('class')) {
        console.log('No any element');
        return
    }

    $('#'+$(this).next().attr('id')+' .'+$(this).next().find('span:nth-child(2)').attr('class')).each(function() {
        if (($(this).find('input').attr('data-locality') === $('#'+e.target.id).val() || $('#'+e.target.id).val() === '_all_') && $(this).find('input').attr('data-added') !== '1') {
          $(this).show();
        } else {
          $(this).hide();
        }
    });
  });

  $('#applyRespCoisen').click(function() {
    var admin_id, arrKeys, dblCheck, roleSet = '';
    if (data_page.admin_contacts_role === '2') {
      // GET ID MEMBER FROM COMBO BOX #fullAdminsListCombo
      admin_id = $('#fullAdminsListCombo').val();
      arrKeys = $('#fullAdminsListCombo').val();
      roleSet = $('#roleListCombo').val();
    } else if (data_page.admin_contacts_role === '1') {
      // GET ID MEMBER FROM COMBO BOX window.adminIdo
      admin_id = window.adminId;
      arrKeys = window.adminId;
    }
    dblCheck = arrKeys;
    $('#myListOfAdmins .list_my_admins_str').each(function() {
      if ($(this).find('input').attr('data-admin_key') && $(this).find('input').attr('data-admin_key') !== dblCheck) {
        arrKeys = arrKeys + ',' + $(this).find('input').attr('data-admin_key');
      }
    });

    $.post('/ajax/contacts.php', {type: 'set_resp_for_admin', id: admin_id, keys: arrKeys, role: roleSet})
      .done (function(data) {
    });
    setTimeout(function () {
      $.get('/ajax/contacts.php?get_resp_group', {id: admin_id})
        .done (function(data) {
        data_page.my_responsibles = data.result;
        if (data_page.admin_contacts_role === '1' || (data_page.admin_contacts_role === '2' && admin_id === window.adminId)) {
          var arr;
          var arrRespOptionsForCombo = ['<option value="_all_">Все ответственные</option>'];
          if (data_page.my_responsibles && data_page.my_responsibles !== window.adminId) {
            arr = data_page.my_responsibles.split(',');
          } else if (data_page.my_responsibles === window.adminId) {
            arr = [window.adminId];
          }
          for (var i = 0; i < arr.length; i++) {
            arrRespOptionsForCombo.push('<option value="'+arr[i]+'">'+fullNameToNoMiddleName(data_page.full_admin_list[arr[i]][0])+'</option>');
          }

          $('#respShow').html(arrRespOptionsForCombo);
          arrRespOptionsForCombo[0] = '<option value="_all_"></option>';
          $('#responsibleList').html(arrRespOptionsForCombo);
          arrRespOptionsForCombo.splice(0,1);
          $('#responsibleContact').html(arrRespOptionsForCombo);

          /*$('#respShow option').each(function () {
            if (data_page.my_responsibles.indexOf($(this).val()) === -1 && $(this).val() !== '_all_') {
              $(this).hide();
            } else {
              $(this).show();
            }
          });*/
        }
      });
    }, 300);
     showHint('Изменения сохранены.')
  });

  $('#saveUpdateGroupAdmin').click(function() {
    var check = 0;
    $('#myListOfAdmins .list_my_admins_str').each(function() {
      check++;
    });

    if ((($('#roleListCombo').val() === 'none' || $('#roleListCombo').val() === '0') && (data_page.my_responsibles !== $('#fullAdminsListCombo').val() && data_page.my_responsibles)) && check > 1) {
      showError('Что бы убрать пользователя, сперва уберите его ответственных.');
      return
      }
    $.get('/ajax/contacts.php?set_resp_group_role', {id: $('#fullAdminsListCombo').val(), role: $('#roleListCombo').val()})
      .done (function(data) {
    });
    //
  });

  function addOptionsToCommboRole2() {
    $.get('/ajax/contacts.php?get_localities_by_admin', {id: $('#fullAdminsListCombo').val()})
      .done (function(data) {
        var localitiesOptions = [];
        localitiesOptions[0] = '<option class="extra-option" value="_line_" disabled>---- Местность администратора ---- <option class="extra-option" value="'+$('#allLocalitisesListCombo').val()+'">'+data_page.locality[$('#allLocalitisesListCombo').val()]+'<option class="extra-option" value="_line_" disabled>-----------------------------------';

        if (Object.keys(data.result).length > 0) {
          localitiesOptions.push('<option class="extra-option" value="_line_" disabled>---- Зоны доступа администратора ----');

          for (var variable100 in data.result) {
            if (data.result.hasOwnProperty(variable100)) {
              localitiesOptions.push('<option class="extra-option" value="'+variable100+'">'+data.result[variable100]+'');
            }
          }
          localitiesOptions.push('<option class="extra-option" value="_line_" disabled>-----------------------------------');
        }

        $('#filterRespFullList option[value="_all_"]').after(localitiesOptions);
      });
  }

  $('#fullAdminsListCombo').change(function() {
    var listAdminResp2 =[];
    if ($(this).val() === '_all_') {
      $('#allLocalitisesListCombo').val('_all_');
      $('#roleListCombo').val('none');
      $('#applyRespCoisen').attr('disabled', 'disabled');
    } else {
      $('#allLocalitisesListCombo').val(data_page.full_admin_list[$(this).val()][1]);
      $.get('/ajax/contacts.php?get_admin_role', {id: $(this).val()})
        .done (function(data) {
          var listOfResp = ['<label><input id="selectAllMyAdminsStrs" type="checkbox"> Отметить все</label><br>'];
          if (data.result[0]) {
            $('#roleListCombo').val(data.result[0]);
            var arrayTmp100;
            if (data.result[1] && data.result[1] !== window.adminId) {
              arrayTmp100 = data.result[1].split(',');
              for (var j = 0; j < arrayTmp100.length; j++) {
                listAdminResp2[j] = arrayTmp100[j];
              }
              $('#fullListOfAdmins .list_admins_str').each(function () {
                if (listAdminResp2.indexOf($(this).find('input').attr('data-admin_key')) === -1) {
                  $(this).show();
                } else {
                  $(this).hide();
                }
              });
            } else if (data.result[1] === window.adminId) {
              arrayTmp100 = [window.adminId];
              $('#fullListOfAdmins .list_admins_str').each(function () {
                if (listAdminResp2.indexOf($(this).find('input').attr('data-admin_key')) !== window.adminId) {
                  $(this).show();
                } else {
                  $(this).hide();
                }
              });
            } else if (!data.result[1]){
              $('#fullListOfAdmins .list_admins_str').each(function () {
                  $(this).show();
              });
              arrayTmp100 = false;
            }
            if (arrayTmp100) {
              var a, b;
              for (var i = 0; i < arrayTmp100.length; i++) {
                a = data_page.full_admin_list[arrayTmp100[i]][0];
                b = data_page.full_admin_list[arrayTmp100[i]][1];
                listOfResp.push('<span class="list_my_admins_str"><label class="font-weight-normal"><input data-admin_key="'+arrayTmp100[i]+'" data-locality="'+b+'" type="checkbox"> '+fullNameToNoMiddleName(a)+'</label><br></span>');
              }
            }
            $('#myListOfAdmins').html(listOfResp);
          } else {
            $('#roleListCombo').val('none');
            $('#myListOfAdmins').html(listOfResp);
            $('#fullListOfAdmins .list_admins_str').each(function () {
                $(this).show();
            });
          }
      });

      $('#filterRespFullList').val('_all_');

      $('#filterRespFullList option').each(function() {
        if ($(this).hasClass('extra-option')) {
          $(this).remove();
        }
      });

      addOptionsToCommboRole2();

      //$('#allLocalitisesListCombo').val('_all_');
      //$('#roleListCombo').val('none');
      $('#applyRespCoisen').attr('disabled', false);

// FOR ROLE 2 SHOLD BE NEXT ACTIONS
//$('#filterRespFullList').html(val);
//$('#filterRespMyList').html(val);
//$('#fullListOfAdmins').html(val2);
//$('#myListOfAdmins').html(val3);

    }
/*
// GET ADMIN LOCALITIES GET ADMINS FROM THIS LOCALITIES GET PARTISIANTS CONTACTS ADD TO COMBOBOX ADD TO LIST HERE AND THERE
    var htmlAdminsList =['<span class=""><label><input id="selectAllAdminsStrs" type="checkbox"> Отметить все</label><br></span>'];
    var visibility, attr, adminArr[];

    for (var va in adminArr) {
      if (adminArr.hasOwnProperty(va)) {
        if (data_page.my_responsibles.indexOf(va) !== -1) {
          visibility = 'style="display: none"';
          attr = 'data-added="1"';
        } else {
          visibility = '';
          attr = '';
        }
          htmlAdminsList.push('<span class="list_admins_str" '+visibility+'><label class="font-weight-normal"><input type="checkbox" data-admin_key="'+va+'" data-locality="'+adminArr[va][1]+'" '+attr+'> '+fullNameToNoMiddleName(adminArr[va][0])+'</label><br></span>');
      }
    }
    $('#fullListOfAdmins').html(htmlAdminsList);
*/
    /*$.get('/ajax/contacts.php?set_resp_group_role', {id: $('#fullAdminsListCombo').val(), role: $('#roleListCombo').val()})
      .done (function(data) {
    });*/
  });

// START TRASH BASKET
/*

*/
// STOP TRASH BASKET

  $('#openLeftPanelBtn').click(function() {
    if ($('#leftSidepanel').css('width') === '200px') {
      $('#leftSidepanel').css('width', '0px');
    } else {
      $('#leftSidepanel').css('width', '200px');
    }
  });

  $('#leftPanelCloseBtn').click(function() {
    $('#leftSidepanel').css('width', '0px');
  });

  var currentsSelectValues = [];

  $('#openFiltersPanelBtn').click(function() {
    currentsSelectValues = [];
    $('#modalFiltersPanel select').each(function() {
      currentsSelectValues[$(this).attr('id')] = $(this).val();
    });
  });
/*
  $('#cancelFilters, #cancelFiltersX').click(function() {
    for (var variable in currentsSelectValues) {
      if (currentsSelectValues.hasOwnProperty(variable)) {
          $('#'+variable).val(currentsSelectValues[variable]);
      }
    }
    currentsSelectValues = [];
    filtersOfString();
  });


    $('#modalFiltersPanel').click(function(e) {
      if (e.target.ariaModal === 'true') {
        if (currentsSelectValues.length !== '0') {
          for (var variable in currentsSelectValues) {
            if (currentsSelectValues.hasOwnProperty(variable)) {
              $('#'+variable).val(currentsSelectValues[variable]);
            }
          }
          currentsSelectValues = [];
        filtersOfString();
        }
      }
    });
*/
  function getDataTrash() {
    url = '/ajax/contacts.php?get_thash_string';
      fetch(url)
      .then(response => response.json())
      .then(commits => contactsStringsLoad(commits));
  }
//stop TRASH function
// ARCHIVE function
  function getDataArchive() {
    url = '/ajax/contacts.php?get_archived_string';
      fetch(url)
      .then(response => response.json())
      .then(commits => contactsStringsLoad(commits));
  }
//stop ARCHIVE function
  $('#applyFilters').click(function(e) {
    $('#saveSpinner').show();
    $('#modalSpinner').show();
    // type of the list
    var currentNoticeText = $('#textFiltersForUsers').text();
    currentNoticeText.search('Удалённые');

    if ($('#kindOfList').val() === 'trash') {
    // TRASH && currentNoticeText.search('Удалённые') === -1
      closeSidePanel();
      clearingBlankOfContact();
      getDataTrash();
    } else if ($('#kindOfList').val() === 'archive') {
    // ARCHIVE && currentNoticeText.search('Архивированные') === -1
      closeSidePanel();
      clearingBlankOfContact();
      getDataArchive();
    } else if(currentNoticeText.search('Удалённые') !== -1 || currentNoticeText.search('Архивированные') !== -1) {
    // CURRENT
      closeSidePanel();
      clearingBlankOfContact();
      contactsListUpdate();
    }

/*  $('#applyFilters').html('<span class="spinner-border spinner-border-sm"></span>');
    setTimeout(function () {
      $('#applyFilters').html('Применить');
      //$(this).attr('disabled', false);
    }, 1500);
    //$(this).attr('disabled', true);
*/
    setTimeout(function () {
      var filtersText = 'Фильтры: ', textOfOption, tempText;
      $('#modalFiltersPanel select').each(function() {

      if ($(this).attr('id') === 'myBlanks' && ($(this).val() === '_all_' || $(this).val() === '0')) {
        if (filtersText !== 'Фильтры: ') {
          filtersText = filtersText + ', ';
        }
        if ($(this).val() === '_all_') {
          filtersText = filtersText + 'Все контакты';
        } else {
          filtersText = filtersText + 'Переданные контакты';
        }
      } else if ($(this).val() !== '_all_' && $(this).attr('id') !== 'myBlanks') {
        if (filtersText !== 'Фильтры: ') {
          filtersText = filtersText + ', ';
        }
        if ($(this).attr('id') === 'respShow') {
          textOfOption = $(this).find('option:selected').text();
          tempText = textOfOption.split('-');
          textOfOption = tempText[0];
        } else {
          textOfOption = $(this).find('option:selected').text();
        }
        filtersText = filtersText + textOfOption;
      }
    });
      if (filtersText !== 'Фильтры: ') {
        $('#textFiltersForUsers').html('');
        setTimeout(function () {
          if (filtersText.length > 40 && $(window).width()<=500) {
            filtersText = filtersText.slice(0,36);
          }
          filtersText = filtersOfString() + ' шт. ' + filtersText + ' <i id="clearTextFilters" class="fa fa-close h5 cursor-pointer"></i>';
          $('#textFiltersForUsers').html(filtersText);
          $('#clearTextFilters').click(function() {
            $('#saveSpinner').show();
            $('#modalSpinner').show();
            setTimeout(function () {
            $('#textFiltersForUsers').html('');
            var xslice = $('#listContactsMbl').css('padding-top');
            xslice = xslice.slice(0, (xslice.length-2));
            xslice = Number(xslice)- 10;
            xslice = xslice + 'px';
            $('#listContactsMbl').css('padding-top', xslice);
            $('#modalFiltersPanel select').each(function() {
              if ($(this).attr('id') === 'myBlanks') {
                $(this).val(1);
              } else if($(this).attr('id') === 'kindOfList') {
                if ($('#kindOfList').val() !== 'current') {
                  $(this).val('current');
                  closeSidePanel();
                  clearingBlankOfContact();
                  contactsListUpdate();
                }
              } else {
                $(this).val('_all_');
              }
            });
              filtersOfString();
              $('#saveSpinner').hide();
              $('#modalSpinner').hide();
            }, 50);
            $('#desctop_visible').css('padding-top', '0px');
          });
        }, 300);
      } else {
        $('#textFiltersForUsers').html('');
      }
// DESIGN
    var xslice = $('#listContactsMbl').css('padding-top');
    xslice = xslice.slice(0, (xslice.length-2));
    if (filtersText !== 'Фильтры: ' && $('#desctop_visible').css('padding-top') !== '30px') {
      xslice = Number(xslice) + 10;
      xslice = xslice + 'px';
      var xdesk = '30px';
    } else if (filtersText === 'Фильтры: ' && $('#desctop_visible').css('padding-top') === '30px') {
      xslice = Number(xslice) - 10;
      xslice = xslice + 'px';
      var xdesk = '0px';
    }

    $('#listContactsMbl').css('padding-top', xslice);
    $('#desctop_visible').css('padding-top', xdesk);
// STOP DESIGN
/*
$('#maleShow, #statusShow, #respShow, #myBlanks, #periodsCombobox, #leftPanelCountryFilter, #leftPanelRegionFilter').change(function (event) {
  event.stopPropagation();
  if (event.target.id === 'myBlanks' && event.target.value === '1' && $('#respShow').val() !== '_all_') {
    $('#respShow').val('_all_');
  }
  filtersOfString();
});
*/
    $('#saveSpinner').hide();
    $('#modalSpinner').hide();
    }, 30);
  });

  $('#openSearchFieldBtn').click(function() {
    if ($('#search-text').parent().is(':visible')) {
      if ($(window).width()<=381) {
        $('#listContactsMbl').css('padding-top', '80px');
      } else {
        $('#listContactsMbl').css('padding-top', '40px');
      }
      $('#search-text').parent().hide();
    } else {
      if ($(window).width()<=381) {
        $('#listContactsMbl').css('padding-top', '120px');
      } else {
        $('#listContactsMbl').css('padding-top', '90px');
      }
      $('#search-text').parent().show();
    }
  });
//STOP Responsibles choise

//Print element
  $('#printStatistics').click(function () {
    function printElem(elem){
      popup($(elem).html());
    }

    function popup(data){
      var mywindow = window.open('', 'Распределение', 'height=400,width=600');
      mywindow.document.write('<html><head><title>Распределение</title>');
      mywindow.document.write('</head><body > <style>th {border-bottom: 1px solid black; text-align: center; border-collapse: collapse;} table, td {border-bottom: 1px solid black; text-align: right; border-collapse: collapse;}</style>');
      mywindow.document.write(data);
      mywindow.document.write('</body></html>');
      //mywindow.print();
      //mywindow.close();
      //return true;
    }
    printElem('#tableStatPrint');
  });
//Print element

function renderGroupList(groups) {
  let list = '<br>';
  for (x in groups) {
    if (groups[x]) {
      list += '<div data-group="'+groups[x]+'"><span>'+groups[x]+' </span><input value="'+groups[x]+'" style="display: none;"><a href="#" class="editPeriodForBlanks"> править</a><a href="#" class="updatePeriodForBlanks" style="display: none;"> сохранить </a><a href="#" class="cancelPeriodForBlanks" style="display: none;"> отменить</a></div><br>' + " ";
    }
  }
    $('#listGroupsEdit').html(list);

    $('.editPeriodForBlanks').click(function () {
      $(this).parent().find('input').show();
      $(this).parent().find('span').hide();
      $(this).parent().find('.updatePeriodForBlanks').show();
      $(this).parent().find('.cancelPeriodForBlanks').show();
      $(this).hide();
    });

    $('.updatePeriodForBlanks').click(function () {
      var newName = $(this).parent().find('input').val();
      var oldName = $(this).parent().find('span').text();
      $(this).parent().find('input').hide();
      $(this).parent().find('span').show();
      $(this).parent().find('span').text(newName);
      $(this).parent().find('.editPeriodForBlanks').show();
      $(this).hide();
      $(this).next().hide();
      let url = '/ajax/contacts.php?set_new_name_for_group&old_name='+oldName+'&new_name='+newName;
      fetch(url)
      .then(response => response.json())
      .then(commits => {
        showHint('Операция затронула '+commits+' карточек.');
      });
    });

    $('.cancelPeriodForBlanks').click(function () {
      $(this).parent().find('input').val($(this).parent().find('span').text());
      $(this).parent().find('input').hide();
      $(this).parent().find('span').show();
      $(this).parent().find('.editPeriodForBlanks').show();
      $(this).hide();
      $(this).prev().hide();
    });
  }

  $('#periodLabelEdit').click(function () {
    fetch('/ajax/contacts.php?get_unique_group')
    .then(response => response.json())
    .then(commits => renderGroupList(commits));
  });

  $('#saveNewPeriod').click(function () {
    if ($('#fieldEditPeriod').val()) {
      var periodName = $('#fieldEditPeriod').val();
      var check = 0;
      $('#listGroupsEdit div').each(function() {
        if ($(this).attr('data-group') === periodName) {
          check = 1;
          return;
        }
      });
      if (check === 1) {
        showError('Внимание! Период '+periodName+' существует.');
        return;
      }
      let url = '/ajax/contacts.php?set_new_name_for_group&new_name='+periodName;
      fetch(url)
      .then(response => response.json())
      .then(commits => {
        showHint('Добавлен новый период '+periodName+'.');
        $('#fieldEditPeriod').val('');
        fetch('/ajax/contacts.php?get_unique_group')
        .then(response => response.json())
        .then(commits => renderGroupList(commits));
      });
    }
  });


/*
  $('#saveEditPeriod').click(function () {
    let elem = '<option value="'+$('#fieldEditPeriod').val()+'">'+$('#fieldEditPeriod').val();
    $('#periodLabel').prepend(elem);
    $('#periodLabel').val($('#fieldEditPeriod').val());
  });
*/
  if (data_page.admin_contacts_role === '0') {
    $('#blankHistory').hide();
  }

  $('.helpDeleteContact').click(function () {
    showHelp("Если данные больше не нужны, нажмите кнопку 'Удалить'. Если данные нужно сохранить для будущих рассылок или контактов, нажмите кнопку 'Переместить в архив'.");
  });

  $('#deleteArchiveContactBtn').click(function (e) {

    if (data_page.admin_contacts_role === '0') {
      if ($('#responsibleContact').attr('data-responsible_previous')) {
        e.preventDefault();
        e.stopPropagation();
        showHelp('Эту карточку может удалить только администратор.');
        return
      }
      $('.helpDeleteContact').hide();
      $('#archiveCntBtnBlank').attr('disabled', true);
      $('#archiveCntBtnBlank').hide();
    }

    if (!$('#saveContact').attr('data-id')) {
      e.preventDefault();
      e.stopPropagation();
      $('#deleteCntBtnBlank').attr('disabled', true);
      $('#archiveCntBtnBlank').attr('disabled', true);
      showError('Незозможно удалить несохраненную карточку');
      return;
    }
    $('#deleteCntBtnBlank').attr('disabled', false);
    $('#archiveCntBtnBlank').attr('disabled', false);
    $('#nameContactForDltArh').text($('#nameContact').val());
    $('#deleteArchiveContactMdl').attr('data-id', $('#saveContact').attr('data-id'));
  });

  $('#deleteCntBtnBlank,#archiveCntBtnBlank').click(function (e) {
    if (e.currentTarget.id === 'deleteCntBtnBlank') {
      if ($('.active_string').find('.fa-undo').is(':visible')) {
        showError('Эта карточка уже находится в корзине.');
        return;
      }
      var url = '/ajax/contacts.php?delete_one_contact&id='+$('#deleteArchiveContactMdl').attr('data-id');
      var msg = 'Контакт '+$('#nameContactForDltArh').text()+' удалён.';
    } else if (e.currentTarget.id === 'archiveCntBtnBlank') {
      if ($('.active_string').find('.fa-archive').is(':visible')) {
        showError('Эта карточка уже находится в архиве.');
        return;
      }
      var url = '/ajax/contacts.php?archive_one_contact&id='+$('#deleteArchiveContactMdl').attr('data-id');
      var msg = 'Контакт '+$('#nameContactForDltArh').text()+' заархивирован.';
    }
    spinerStart();
    saveEditContactQuick(true);
    //setTimeout(function () {
    //}, 100);
    fetch(url)
    .then(response => response.json())
    .then(commits => {
      showHint(msg);
      $('.active_string').removeClass('contacts_str').addClass('contacts_str_deleted');
      $('.active_string').hide();
      clearingBlankOfContact();
      closeSidePanel();
      spinerStop();
    });
  });

  function closeSidePanel() {
    $('.cd-panel-watch').removeClass('cd-panel--is-visible-watch');
    $('.cd-panel__close-watch').removeClass('cd-panel__close-watch-visible');
  }

  function spinerStart() {
    $('#modalSpinner').show();
    $('#saveSpinner').show();
  }

  function spinerStop() {
    $('#modalSpinner').hide();
    $('#saveSpinner').hide();
  }

  function spinerStartStopTime(interval) {
    !interval || isNaN(interval) ? interval = 1500 : '';
    spinerStart();
    setTimeout(function () {
      spinerStop();
    }, interval);
  }

  // Служба поддержки, окно. if mobile
  if ($(window).width()<=992) {
        $('#formHolder').attr('data-width','320px');
    /*
    $('#choiseHelpPoint').attr('data-height','');
    $('#choiseHelpPoint').attr('data-width','');
    */
  } else {
    $('#formHolder').attr('data-width','740px');
  }

  $('#checkOrderInCRM').click(function() {
    let dd, mm, yyyy, today, dateorder, limitday = 1;
    if ($("#orderDateEdit").val()) {
      dateorder = $("#orderDateEdit").val();
      dateorder = dateorder.split("-");
      dd = dateorder[2];
      mm = dateorder[1];
      yyyy = dateorder[0];
      today = new Date();
      dateorder = new Date(yyyy, mm-1, dd);
      limitday = (today - dateorder) / (3600 * 24 * 1000);
    }

    if ($('.contacts_str.active_string').is(':visible') && limitday > 2) {
      let leadId = $('.contacts_str.active_string').attr('data-crm_id');
      if (leadId) {
        let url='extensions/crm/order_status.php?lead_id='+leadId;
        fetch(url)
        .then(response => response.text())
        .then(result => {
          let message = result.split('-o-o->');
          //showHint(message[0], 5000);
          if (message[1] === "Завершение") {
            //$('#commentContact').parent().parent().height($('#commentContact').parent().parent().height() - 14);
            if (message[2] === "NONE") {
              $('#block-for-russian-post').html("Бандероль доставлена " + message[0]);
            } else {
              $("#link-for-russian-post").attr("href","https://www.pochta.ru/tracking#"+message[2]);
              $("#link-for-russian-post").html("Бандероль доставлена " + message[0]);
            }
          } else if (message[1] === 'Отправка') {
            $("#block-for-russian-post").html(message[1] + " " + message[2]);
          } else {
            $("#link-for-russian-post").attr("href","https://www.pochta.ru/tracking#"+message[2]);
            $("#link-for-russian-post").html(message[1] + ": " + message[2]);
          }
        });
      } else {
        showHint('Нет данных для запроса в СРМ', 5000);
      }
    } else {
      showHint('Данные временно отсутствуют', 5000);
    }
  });


});
