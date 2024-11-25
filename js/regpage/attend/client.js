/* ==== Attend START ==== */
$(document).ready(function(){
  /* ==== DOCUMENT READY START ==== */
  // применяем фильтры
  filtersOfString();

  // RENDERING
  setTimeout(function () {
    get_localities();
  }, 100);

  // сброс комментариев и взносов для списка (с учётом фильтров)
  $("#btn_reset_fee_comment").click(function () {
    $("#spinner").show();
    let members_for_reset = [];
    $("#attend_list .attend_str:visible").each(function () {
      if ($(this).find(".vt_fee_field").val() > 0 || $(this).find(".vt_comment_field").val()) {
        members_for_reset.push($(this).attr("data-member_key"));
        $(this).find(".vt_fee_field").val(0);
        $(this).find(".vt_comment_field").val("");
        $(this).find(".vt_fee_text").text("");
        $(this).find(".vt_comment_text").text("");
      }
    });
    let data = new FormData()
    if (members_for_reset.length === 0) {
      $("#spinner").hide();
      showHint("Взносы и комментарии отсутствуют в текущем списке.");
      return;
    }
    data.set("data", JSON.stringify(members_for_reset))
    fetch("/ajax/attend_ajax.php?type=reset_fee_comment", {
      method: 'POST',
      body: data
    })
    .then(response => response.text())
    .then(commits => {
      $("#spinner").hide();
      showHint("Данные удалены.");
    });
  });

  $("#add_member").click(function () {
    $("#modalAddEdit").modal("show");
  });

  // save checkbox
  $("#attend_list input[type='checkbox']").change(function () {
    let table = "attendance";
    let key = $(this).parent().parent().attr("data-member_key");
    if ($(this).attr("data-field") === "attend_meeting") {
      table = "member";
    }

    let value = 0;
    if ($(this).prop("checked")) {
      value = 1;
    }
    fetch("ajax/attend_ajax.php?type=change_checkbox&id="
    + key + "&table=" + table
    + "&field=" + $(this).attr("data-field")
    + "&value=" + value)
    /*.then(response => response.text())
    .then(commits => );*/
    // записываем текущего редактора
    setTimeout(function () {
      fetch("ajax/attend_ajax.php?type=change_checkbox&id="
      + key + "&table=attendance&field=editors"
      + "&value=" + window.adminId)
      /*.then(response => response.text())
      .then(commits => );*/
    }, 10);
  });
  // save text
  $(".vt_comment_field").change(function () {
    let key = $(this).parent().parent().attr("data-member_key");
    fetch("ajax/attend_ajax.php?type=change_checkbox&id="
    + key + "&table=attendance&field="
    + $(this).attr("data-field") + "&value=" + $(this).val())
    //$(this).parent().find("i").attr("title", $(this).val());
    /*.then(response => response.text())
    .then(commits => );*/
    // записываем текущего редактора
    let editors_keys;
    let editors_exist = "";
    if ($(this).attr("data-editors")) {
      editors_exist = $(this).attr("data-editors");
    }

    if (editors_exist.length > 9) {
      editors_keys = editors_exist.split(",");
      if (editors_keys[1]) {
        editors_keys = String(editors_keys[1]) + "," + String(window.adminId);
      } else {
        editors_keys = window.adminId;
      }
    } else if (editors_exist && editors_exist.length < 10) {
      editors_keys = editors_exist + "," + window.adminId;
    } else {
      editors_keys = window.adminId;
    }
    setTimeout(function () {
      fetch("ajax/attend_ajax.php?type=change_checkbox&id="
      + key + "&table=attendance&field=editors"
      + "&value=" + editors_keys)
      /*.then(response => response.text())
      .then(commits => );*/
    }, 10);
  });

  // save fee
  $(".vt_fee_field").change(function () {
    let key = $(this).parent().parent().attr("data-member_key");
    fetch("ajax/attend_ajax.php?type=change_checkbox&id="
    + key + "&table=attendance&field="
    + $(this).attr("data-field") + "&value=" + $(this).val())

    // записываем текущего редактора
    let editors_keys;
    let editors_exist = "";
    if ($(this).parent().next().find(".vt_comment_field").attr("data-editors")) {
      editors_exist = $(this).parent().next().find(".vt_comment_field").attr("data-editors");
    }

    if (editors_exist.length > 9) {
      editors_keys = editors_exist.split(",");
      if (editors_keys[1]) {
        editors_keys = String(editors_keys[1]) + "," + String(window.adminId);
      } else {
        editors_keys = window.adminId;
      }
    } else if (editors_exist && editors_exist.length < 10) {
      editors_keys = editors_exist + "," + window.adminId;
    } else {
      editors_keys = window.adminId;
    }
    setTimeout(function () {
      fetch("ajax/attend_ajax.php?type=change_checkbox&id="
      + key + "&table=attendance&field=editors"
      + "&value=" + editors_keys)
    }, 10);
  });

  // Выбор подраздела
  $("#members-lists-combo").change(function(){
      listsType = $(this).val();
      switch (listsType) {
          case 'members': window.location = '/members'; break;
          case 'youth': window.location = '/youth'; break;
          case 'list': window.location = '/list'; break;
          case 'activity': window.location = '/activity'; break;
          case 'attend': window.location = '/attend'; break;
      }
  });

  // string
  /*
  $(".attend_str .fa-comment").click(function(){
    if ($(this).parent().find(".vt_comment_field").is(":visible")) {
      $(this).parent().find(".vt_comment_field").hide();
      $(this).show();
    } else {
      $(this).parent().find(".vt_comment_field").show();
      $(this).hide();
    }
  });
*/
  $(".attend_str .vt_comment_text").click(function(){
    if ($(this).parent().find(".vt_comment_field").is(":visible")) {
      $(this).parent().find(".vt_comment_field").hide();
      $(this).show();
    } else {
      $(".attend_str .vt_comment_text").show();
      $(".attend_str .vt_comment_field").hide();
      $(this).hide();
      $(this).parent().find(".vt_comment_field").show();
      $(this).parent().find(".vt_comment_field").focus();
    }
  });
  // fee field show/hide
  $(".attend_str .vt_fee_text").click(function(){
    if ($(this).parent().find(".vt_fee_field").is(":visible")) {
      $(this).parent().find(".vt_fee_field").hide();
      $(this).show();
    } else {
      $(".attend_str .vt_fee_text").show();
      $(".attend_str .vt_fee_field").hide();
      $(this).hide();
      $(this).parent().find(".vt_fee_field").show();
      $(this).parent().find(".vt_fee_field").focus();
    }
  });

  // list, comment
  $(".vt_comment_field").keydown(function(e) {
      if(e.keyCode === 13) {
        e.preventDefault();
        $(this).next().text($(this).val());
        $(this).hide();
        $(this).next().show();
      } else if (e.keyCode === 27) {
        e.preventDefault();
        $(this).val($(this).next().text());
        $(this).hide();
        $(this).next().show();
      }
    });

    // list, fee
    $(".vt_fee_field").keydown(function(e) {
        if(e.keyCode === 13) {
          e.preventDefault();
          $(this).next().text($(this).val());
          $(this).hide();
          $(this).next().show();
        } else if (e.keyCode === 27) {
          e.preventDefault();
          $(this).val($(this).next().text());
          $(this).hide();
          $(this).next().show();
        }
      });

    $(".attend_str .vt_comment_field").focusout(function () {
      $(this).next().text($(this).val());
      $(this).hide();
      $(this).next().show();
    });

    $(".attend_str .vt_fee_field").focusout(function () {
      $(this).next().text($(this).val());
      $(this).hide();
      $(this).next().show();
    });

  // sorting
  $(".sort_col").click(function () {
    if ($(this).find("i").hasClass("fa-sort-desc")) {
      $(this).find("i").removeClass("fa-sort-desc");
      $(this).find("i").addClass("fa-sort-asc");
      setCookie('sorting-attend', $(this).attr("data-sort") + "-desc", 356);
    } else if ($(this).find("i").hasClass("fa-sort-asc")) {
      $(this).find("i").removeClass("fa-sort-asc");
      $(this).find("i").addClass("fa-sort-desc");
      setCookie('sorting-attend', $(this).attr("data-sort") + "-asc", 356);
    } else {
      $(".sort_col i").removeClass("fa");
      $(".sort_col i").removeClass("fa-sort-desc");
      $(".sort_col i").removeClass("fa-sort-asc");
      $(this).find("i").addClass("fa").addClass("fa-sort-desc");
      setCookie('sorting-attend', $(this).attr("data-sort") + "-asc", 356);
    }
    setTimeout(function () {
      location.reload();
    }, 30);
  });

  // search
  $('#field_search_text').click(function(event){
    event.stopPropagation();
    if ($(this).val().length > 0) {
      setTimeout(function () {
        if (!$('#field_search_text').val()) {
          filtersOfString();
        }
      }, 30);
    }
  });
  $("#flt_members_attend, #flt_members_category, #flt_members_localities, #field_search_text").change(function () {
    filtersOfString();
     if ($(this).attr("id") !== "field_search_text") {
        setCookie($(this).attr("id"), $(this).val(), 356);
     }
  });

  // Кастомные фильтры ДОРАБОТАТЬ
  $('#btn_show_custom_filters').click(function(){
      $('.filter_name_block').hide();
      $('.filter_name').text('');
      getFilters();
      $("#modal_custom_filters").modal('show');
  });

  $(".create_filter").click(function(){
      $('.filter_name_block').css('display', 'inline-block');
  });
  $('.remove_filter_confirm').click(function(){
      var filter_id = $(this).attr('data-filter_id');

      $.get('/ajax/members.php?remove_filter', {filter_id : filter_id})
      .done (function(data) {
          renderFilters(data.filters);
      });
  })

  $('.add-filter').click(function(){
      var filter_name = $('.filter_name').val().trim(),
          isDublicat = false;

      if(filter_name === ''){
          showError('Название фильтра не может быть пустым!');
          return
      }

      $("#modalFilters .filter_item").each(function(){
          var name = $(this).attr('data-name');

          if(name == filter_name){
              isDublicat = true;
          }
      });

      if(isDublicat){
          showError('Фильтр с таким названием уже существует и не может быть добавлен!');
      }
      else {
          $.get('/ajax/members.php?add_filter', {filter_name : filter_name})
          .done (function(data) {
              $('.filter_name').val('');
              showHint('Фильтр успешно добавлен');
              renderFilters(data.filters);
          });
      }
  });

  $('.save-filter-localities').click(function(){
      var modal = $("#modal_show_custom_filters"),
          filter_id = modal.attr('data-filter_id'),
          checkedLocalities = [];

      modal.find('.show_filters_list input').each(function(){
          var isChecked = $(this).prop('checked'),
              id = $(this).attr('id');

          if(isChecked){
              checkedLocalities.push(id);
          }
      });

      $.get('/ajax/members.php?save_filter_localities', {filter_id : filter_id, filter_localities: checkedLocalities.join(',')})
      .done (function(data) {
          renderFilters(data.filters);
      });
  });
  // --- PRINT LIST events --- //
  // Таблица посещаемости
  $("#btnPrintOpenModal, #btnPrintOpenModalBlank").click(function (e) {
    // В мобильной версии можно предоставлять окно с результатом для дальнейшей печати или выгрузки
    let data;
    if (e.target.id === "btnPrintOpenModal") {
      data = print_rendering_elements();
    } else {
      data = print_rendering_elements(false, true);
    }

    $("#show_print_list").html(data["thead"] + data["tbody"]);
    if (e.target.id === "btnPrintOpenModal") {
      print_page("#show_print_list");
    } else {
      print_page("#show_print_list", false, "blank");
    }

  });

  // Контрольный список ВО
  $("#btnPrintOpenModalControlListVT").click(function () {
    $("#modalEmptyStrsVT").modal("show");
  });

  $("#setEmptyStrsVT, #btnPrintOpenModalControlListVTBlank, #btnPrintOpenModalVT").click(function (e) {
    let filter_vt = $("#flt_members_attend").val();
    if (filter_vt !== "6") {
      $("#flt_members_attend").val("6");
      filtersOfString();
    }
    setTimeout(function () {
      let data;
      if (e.target.id === "btnPrintOpenModalVT") {
        data = print_rendering_elements_vt_list();
      } else if (e.target.id === "btnPrintOpenModalControlListVTBlank") {
        data = print_rendering_elements_vt(false, true);
      } else {
        data = print_rendering_elements_vt();
      }
      if (data.tbody === "</tbody>") {
        showError("Ошибка. В списке посещаемости нет отметок в колонке «В».");
        return;
      }
      $("#show_print_list").html(data["thead"] + data["tbody"]);
      // В мобильной версии можно предоставлять окно с результатом для дальнейшей печати или выгрузки

      if (e.target.id === "btnPrintOpenModalVT") {
        print_page("#show_print_list", false, "vt_list");
      } else if (e.target.id === "btnPrintOpenModalControlListVTBlank") {
        print_page("#show_print_list", false, "vt_blank");
      } else {
        print_page("#show_print_list", false, "vt");
      }
    }, 10);
    setTimeout(function () {
      if (filter_vt !== "6") {
        $("#flt_members_attend").val(filter_vt);
        filtersOfString();
      }
    }, 20);
  });

  // badge
  $("#btnPrintOpenModalBadgesVT").click(function () {
    $("#modalTopicVT").modal("show");
  });

  $("#setTopicVTMdl").click(function () {
    if (!$("#textTopicVTMdl").val().trim()) {
      showError("Тема не указана.");
      return;
    }
    let filter_vt = $("#flt_members_attend").val();
    if (filter_vt !== "6") {
      $("#flt_members_attend").val("6");
      filtersOfString();
    }
    setTimeout(function () {
      let data;
      data = print_badges();
      if (data.tbody === "</tbody>") {
        showError("Ошибка. В списке посещаемости нет отметок в колонке «В».");
        return;
      }
      $("#show_print_list").html(data["thead"] + data["tbody"]);
      // В мобильной версии можно предоставлять окно с результатом для дальнейшей печати или выгрузки
      // ???
      print_page("#show_print_list", true, "badges");

    }, 10);
    setTimeout(function () {
      if (filter_vt !== "6") {
        $("#flt_members_attend").val(filter_vt);
        filtersOfString();
      }
    }, 20);
    $("#modalTopicVT").modal("hide");
  });
  // Добавить нового участника
  $("#add_member_show_modal").click(function() {
    clear_blank();
    $("#modalAddEdit").modal("show");
  });
  // редактировать бланк
  $(".attend_str>div:last-child, .attend_str>div:first-child, .attend_str>div:nth-child(2)").click(function() {
    fill_blank($(this).parent());
    $("#modalAddEdit").modal("show");
  });

  // удаляем спиннер
  $("#spinner_attend").remove();

  // Статистика
  $(".btnShowStatistic").click(function(e){
      e.stopPropagation();
      var isTabletMode = $(document).width()<786,
          filterLocality = $('#selMemberLocality option:selected').text(),
          localitiesByFilter = [],
          countMembers = 0, countBelivers=0, countScholars = 0,
          countPreScholars = 0, countStudents = 0, countSaints = 0,
          countRespBrothers = 0, countFullTimers = 0, countTrainees = 0,
          countOthers = 0, countAttendances = 0,

          memberAgeIsNullList = [],

          countScholarsByAge = 0, countStudentsByAge = 0, countSaintsByAge = 0,
          countAttendancesScholarsByAge = 0, countAttendancesStudentsByAge = 0, countAttendancesSaintsByAge = 0,
          countAttendancesByAge = 0, countByAge = 0, countOlderByAge = 0,

          countAttendancesMembers = 0, countAttendancesBelivers=0, countAttendancesScholars = 0,
          countAttendancesPreScholars = 0, countAttendancesStudents = 0, countAttendancesSaints = 0,
          countAttendancesRespBrothers = 0, countAttendancesFullTimers = 0, countAttendancesTrainees = 0,
          countAttendancesOthers = 0, countAttendancesSaintsByOldAge = 0,
          averageAge = 0, averageAgeAttendances = 0;
      let members_keys_stat = [];
      $("#attend_list .attend_str:visible").each(function(){
          if($(this).css('display') !== 'none' && !$(this).hasClass('inactive-member')){
            members_keys_stat.push('"' + $(this).attr('data-member_key') + '"');
              countMembers ++;

              var name = $(this).find('.data_name').text(),
                  locality = $(this).attr('data-locality_key'),
                  category = $(this).attr('data-category_key'),
                  age = $(this).attr('data-age');

              if(!age || age == 'null'){
                  memberAgeIsNullList.push(name);
              } else {
                  if(age >=12 && age <= 17){
                      averageAge += parseInt(age);
                      countScholarsByAge++;
                      if($(this).attr('data-attendance') == 1){
                          averageAgeAttendances += parseInt(age);
                          countAttendancesScholarsByAge ++;
                      }
                  }
                  else if(age >=18 && age <= 25){
                      averageAge += parseInt(age);
                      countStudentsByAge++;
                      if($(this).attr('data-attendance') == 1){
                          averageAgeAttendances += parseInt(age);
                          countAttendancesStudentsByAge ++;
                      }
                  }
                  else if (age > 25 && age <= 60){
                      averageAge += parseInt(age);
                      countSaintsByAge++;
                      if($(this).attr('data-attendance') == 1){
                          averageAgeAttendances += parseInt(age);
                          countAttendancesSaintsByAge ++;
                      }
                  }
                  else if (age > 60){
                      averageAge += parseInt(age);
                      countOlderByAge++;
                      if($(this).attr('data-attendance') == 1){
                          averageAgeAttendances += parseInt(age);
                          countAttendancesSaintsByOldAge ++;
                      }
                  }
                  if($(this).attr('data-attendance') == 1){
                      countAttendancesByAge++;
                  }
                  countByAge++;
              }

              if(!locality.includes(localitiesByFilter)){ //!in_array(locality, localitiesByFilter)
                  localitiesByFilter.push(locality);
              }

              switch (category){
                  case 'BL': countBelivers++; break;
                  case 'SN': countSaints++; break;
                  case 'SC': countScholars++; break;
                  case 'PS': countPreScholars++; break;
                  case 'ST': countStudents++; break;
                  case 'RB': countRespBrothers++; break;
                  case 'FS': countFullTimers++; break;
                  case 'FT': countTrainees++; break;
                  case 'OT': countOthers++; break;
              }
          }
      });

      var statistic =
              (countPreScholars >0 ? "<tr><td>Дошкольники</td><td class='text-align'>"+countPreScholars+"</td><td class='text-align cat_ps'>"+countAttendancesPreScholars+"</td></tr>" : "" )+
              ( countScholars >0 ? "<tr><td>Школьники</td><td class='text-align'>"+countScholars+"</td><td class='text-align cat_sc'>"+countAttendancesScholars+"</td></tr>" : "" ) +
              ( countStudents >0 ? "<tr><td>Студенты</td><td class='text-align'>"+countStudents+"</td><td class='text-align cat_st'>"+countAttendancesStudents+"</td></tr>" : "" )+
              (countSaints >0 ? "<tr><td>Святые в церк. жизни</td><td class='text-align'>"+countSaints+"</td><td class='text-align cat_sn'>"+countAttendancesSaints+"</td></tr>" : "")+
              ( countRespBrothers >0 ? "<tr><td>Ответственные братья</td><td class='text-align'>"+countRespBrothers+"</td><td class='text-align cat_rb'>"+countAttendancesRespBrothers+"</td></tr>" : "" )+
              ( countFullTimers >0 ? "<tr><td>Полновременные служащие</td><td class='text-align'>"+countFullTimers+"</td><td class='text-align cat_fs'>"+countAttendancesFullTimers+"</td></tr>" : "" )+
              ( countTrainees >0 ? "<tr><td >Полновременно обучающиеся</td><td class='text-align'>"+countTrainees+"</td><td class='text-align ft'>"+countAttendancesTrainees+"</td></tr>" : "" )+
              ( countBelivers >0 ? "<tr><td>Верующие</td><td class='text-align'>"+countBelivers+"</td><td class='text-align cat_bl'>"+countAttendancesBelivers+"</td></tr>" : "" )+
              ( countOthers >0 ? "<tr><td>Другие</td><td class='text-align'>"+countOthers+"</td><td class='text-align cat_ot'>"+countAttendancesOthers+"</td></tr>" : "" ) +
              "<tr><td><strong>Всего</strong></td><td class='text-align'><strong>" + countMembers + "</strong></td><td class='text-align cat_all'><strong>"+countAttendances+"</strong></td></tr>";

      var additionalStatistic =
          (countScholarsByAge >0 ? "<tr><td>12-17 лет</td><td class='text-align'>"+countScholarsByAge+"</td><td class='text-align scholar_age'>"+
              countAttendancesScholarsByAge+"</td></tr>" : "")+
          ( countStudentsByAge >0 ? "<tr><td>18-25 лет</td><td class='text-align'>"+countStudentsByAge+"</td><td class='text-align student_age'>"+countAttendancesStudentsByAge+"</td></tr>" : "" ) +
          ( countSaintsByAge >0 ? "<tr><td>26-60 лет</td><td class='text-align'>"+countSaintsByAge+"</td><td class='text-align saint_age'>"+countAttendancesSaintsByAge+"</td></tr>" : "" )+
          ( countOlderByAge >0 ? "<tr><td>старше 60</td><td class='text-align'>"+countOlderByAge+"</td><td class='text-align older_age'>"+countAttendancesSaintsByOldAge+"</td></tr>" : "" )+
          "<tr><td><strong>Всего</strong></td><td class='text-align'><strong>" + (countScholarsByAge+countStudentsByAge+countSaintsByAge + countOlderByAge) + "</strong></td><td class='text-align all_age'><strong>"+(countAttendancesScholarsByAge+countAttendancesStudentsByAge+countAttendancesSaintsByAge + countAttendancesSaintsByOldAge)+"</strong></td></tr>"+
          ( countScholarsByAge>0 || countStudentsByAge> 0 || countSaintsByAge >0 ? "<tr><td>Средний возраст</td><td class='text-align'>"+(
              parseInt(averageAge / (countScholarsByAge + countStudentsByAge + countSaintsByAge + countOlderByAge)))+"</td>"+
          "<td class='text-align average_age'>"+ (
              parseInt(averageAgeAttendances / (countAttendancesScholarsByAge + countAttendancesStudentsByAge + countAttendancesSaintsByAge + countAttendancesSaintsByOldAge))) +"</td></tr>" : "" );

      if(memberAgeIsNullList.length == 0){
          var additionalTableTemplate = '<h3>По возрастам</h3>'+
              '<table class="table table-hover">'+
                '<thead>'+
                  '<tr>'+
                    '<th>Возраст</th>'+
                    '<th class="text-align">По списку</th>'+
                    '<th class="text-align">Посещают собрания</th>'+
                  '</tr>'+
                '</thead>'+
                '<tbody>'+ additionalStatistic + '</tbody>'+
              '</table>';
      }
      else{
          var additionalTableTemplate = '<h5>Данные для статистики (по возрастам) не сформированы, поскольку не указана дата рождения:</h5> <div>'+ memberAgeIsNullList.join(', ') + '</div>';
      }

      var tableTemplate = '<h5>По категориям</h5><table class="table table-hover">'+
            '<thead>'+
              '<tr>'+
                '<th>Категория</th>'+
                '<th class="text-align">По списку</th>'+
                '<th class="text-align">Посещают собрания</th>'+
              '</tr>'+
            '</thead>'+
            '<tbody>'+ statistic + '</tbody>'+
          '</table>';

      $("#modalStatistic").find(".modal-header h3").html("Статистика" +
          (filterLocality === 'Все местности' ? ' (' + localitiesByFilter.length + ')' : ' (' + filterLocality + ')'));
      $("#modalStatistic").find(".modal-body").html(tableTemplate + additionalTableTemplate);
      //$("#modalStatistic").find(".modal-footer").html("<div style='float:left;'><strong>Количество местностей — "+localitiesByFilter.length+"</strong></div>");
      // добавляем посещаемость
      setTimeout(function () {
        let members_keys_statistic = new FormData();
        members_keys_statistic.set("keys", members_keys_stat.join(','));
        fetch('ajax/members.php?type=get_statistic', {
          method: 'POST',
          body: members_keys_statistic
        })
        .then(response => response.json())
        .then(commits => {
          //console.log(commits.statistic);
          let cat_total = 0;
          let age_total = 0;
          if (commits.statistic.PS) {
            $(".cat_ps").text(commits.statistic.PS);
            cat_total += commits.statistic.PS;
          }
          if (commits.statistic.SC) {
            $(".cat_sc").text(commits.statistic.SC);
            cat_total += commits.statistic.SC;
          }
          if (commits.statistic.ST) {
            $(".cat_st").text(commits.statistic.ST);
            cat_total += commits.statistic.ST;
          }
          if (commits.statistic.SN) {
            $(".cat_sn").text(commits.statistic.SN);
            cat_total += commits.statistic.SN;
          }
          if (commits.statistic.RB) {
            $(".cat_rb").text(commits.statistic.RB);
            cat_total += commits.statistic.RB;
          }
          if (commits.statistic.FS) {
            $(".cat_fs").text(commits.statistic.FS);
            cat_total += commits.statistic.FS;
          }
          if (commits.statistic.FT) {
            $(".cat_ft").text(commits.statistic.FT);
            cat_total += commits.statistic.FT;
          }
          if (commits.statistic.BL) {
            $(".cat_bl").text(commits.statistic.BL);
            cat_total += commits.statistic.BL;
          }
          if (commits.statistic.OT) {
            $(".cat_ot").text(commits.statistic.OT);
            cat_total += commits.statistic.OT;
          }
          if (cat_total > 0) {
            $(".cat_all").text(cat_total);
          }
          if (commits.statistic["12_17"]) {
            $(".scholar_age").text(commits.statistic["12_17"]);
            age_total += commits.statistic["12_17"];
          }
          if (commits.statistic["18_25"]) {
            $(".student_age").text(commits.statistic["18_25"]);
            age_total += commits.statistic["18_25"];
          }
          if (commits.statistic["26_60"]) {
            $(".saint_age").text(commits.statistic["26_60"]);
            age_total += commits.statistic["26_60"];
          }
          if (commits.statistic["older_60"]) {
            $(".older_age").text(commits.statistic["older_60"]);
            age_total += commits.statistic["older_60"];
          }
          if (age_total > 0) {
            $(".all_age").text(cat_total);
          }
          if (commits.statistic.average_age) {
            $(".average_age").text(Math.round(commits.statistic.average_age / age_total));
          }
        });
      }, 100);

      $("#modalStatistic").modal('show');
  });
  // сохранение
  $("#save_blank").click(function() {
      if (valid_fields()) {
        showError('Заполните обязательные поля.');
        return;
      } else {
        $("#modalAddEdit").modal("hide");
        $("#spinner").modal("show");
        if ($("#modalAddEdit").attr("data-member_key")) {
          save_blank(get_data_blank());
        } else {
          save_blank(get_data_blank(), true);
        }
      }
  });
  /* ==== DOCUMENT READY STOP ==== */
});
