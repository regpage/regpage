/* ==== Attend START ==== */
$(document).ready(function(){
  /* ==== DOCUMENT READY START ==== */
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
    $(this).parent().find("i").attr("title", $(this).val());
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
  $(".attend_str .fa-comment").click(function(){
    if ($(this).parent().find(".vt_comment_field").is(":visible")) {
      $(this).parent().find(".vt_comment_field").hide();
      $(this).show();
    } else {
      $(this).parent().find(".vt_comment_field").show();
      $(this).hide();
    }
  });

  $(".attend_str .vt_comment_text").click(function(){
    if ($(this).parent().find(".vt_comment_field").is(":visible")) {
      $(this).parent().find(".vt_comment_field").hide();
      $(this).show();
    } else {
      $(this).parent().find(".vt_comment_field").show();
      $(this).hide();
    }
  });
  // list, comment
  $(".vt_comment_field").keydown(function(e) {
      if(e.keyCode === 13) {
        e.preventDefault();
        if ($(this).val()) {
          $(this).hide();
          $(this).next().text($(this).val());
          $(this).next().show();
        } else {
          $(this).hide();
          $(this).next().text($(this).val());
          $(this).prev().show();
        }
      }
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

  // filters
  function filtersOfString() {
    $("#spinner").modal("show");
    setTimeout(function () {
      let ltm, pm, gm, am, vt, no_ftt;
    let text = $("#field_search_text").val().trim();

    if ($("#flt_members_category").val() === "NF") {
      no_ftt = true;
    }

    $("#attend_list .attend_str").each(function () {
      // Search text
      if (text.length > 2) {
        fio = $(this).findfilters('.data_name').text().trim();
        searchResult = true;
        if (fio.toLowerCase().indexOf(String(text.toLowerCase())) === -1) {
          searchResult = false;
        }
      } else {
        searchResult = true;
      }

      let localities = $("#flt_members_localities").val();
      if (localities !== "_all_") {
        localities = $("#flt_members_localities").val();
        localities = localities.split(",");
      }
      // STOP Search text
      ltm = $(this).find("input[data-field='attend_meeting']").prop("checked");
      pm = $(this).find("input[data-field='attend_pm']").prop("checked");
      gm = $(this).find("input[data-field='attend_gm']").prop("checked");
      am = $(this).find("input[data-field='attend_am']").prop("checked");
      vt = $(this).find("input[data-field='attend_vt']").prop("checked");
      if ((localities.indexOf($(this).attr("data-locality_key")) !== -1 || localities === "_all_")
      && (($("#flt_members_category").val() === $(this).attr("data-category_key")
      || $("#flt_members_category").val() === "_all_") || (no_ftt && $(this).attr("data-category_key") !== "FT")) &&
      ($("#flt_members_attend").val() === "_all_"
      || ($("#flt_members_attend").val() === "5" && (ltm || pm || gm || am))
      || ($("#flt_members_attend").val() === "0" && (!ltm && !pm && !gm && !am))
      || ($("#flt_members_attend").val() === "1" && ltm)
      || ($("#flt_members_attend").val() === "2" && pm)
      || ($("#flt_members_attend").val() === "3" && gm)
      || ($("#flt_members_attend").val() === "4" && am)
      || ($("#flt_members_attend").val() === "6" && vt))
      && (!$("#field_search_text").val() || searchResult)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
    $("#spinner").modal("hide");
    }, 10);
  }

  $("#flt_members_attend, #flt_members_category, #flt_members_localities, #field_search_text").change(function () {
    filtersOfString();
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

  // Кастомные фильтры функции ДОРАБОТАТЬ
  function getFilters(){
    fetch("/ajax/members.php?get_filters")
    .then(response => response.json())
    .then(commits => {
      renderFilters(commits.filters);
    });
  }

  function renderFilters(filters){
      get_localities();

      var filters_list = [];

      for(var f in filters){
          var filter = filters[f],
              countItems = filter.value ? filter.value.split(',') : [];

          filters_list.push('<div class="filter_item" data-localities="'+filter.value+'" data-name="'+filter.name+'" data-id="'+filter.id+'">'+
              '<span class="fa fa-list-ul show_filter" title="Просмотреть фильтр"></span>'+
              '<span class="fa fa-pencil edit_filter" title="Редактировать фильтр"></span>'+
              '<span class="fa fa-trash remove_filter" title="Удалить фильтр"></span>'+
              '<span class="edit_filter_name">' +filter.name+ '</span>' +
              '<input class="filter_name_field" />'+
              '<span class="fa fa-check save_filter_name"></span>' +
              '<span>'+ (countItems.length > 0 ? " (" +countItems.length+ ") " : "") +'</span></div>');
      }

      $('.filters_list').html(filters_list.join(''));

      $('.remove_filter').click(function(){
          var filter_id = $(this).parents('.filter_item').attr('data-id'),
              filter_name = $(this).parents('.filter_item').attr('data-name'),
              modal = $('#modalRemoveFilterConfirmation');

          modal.find('.modal-body').text("Вы действительно хотите удалить данный фильтр - " + filter_name);
          modal.find('.remove_filter_confirm').attr('data-filter_id', filter_id);
          modal.modal('show');
      });

      $('.edit_filter').click(function(){
          var filter_name = $(this).parents('.filter_item').attr('data-name');

          $(this).parents('.filter_item').find('.edit_filter_name').css('display', 'none');
          $(this).parents('.filter_item').find('.save_filter_name').css('display', 'inline');
          $(this).parents('.filter_item').find('.filter_name_field').val(filter_name).css('display', 'inline');
      });

      $('.save_filter_name').click(function(){
          var filter_id = $(this).parents('.filter_item').attr('data-id'),
              filter_name = $(this).parents('.filter_item').find('.filter_name_field').val();

          $.get('/ajax/members.php?save_filter', {filter_id : filter_id, filter_name: filter_name})
          .done (function(data) {
              $(this).parents('.filter_item').find('.edit_filter_name').css('display', 'inline');
              $(this).parents('.filter_item').find('.filter_name_field').css('display', 'none');
              $(this).parents('.filter_item').find('.save_filter_name').css('display', 'none');

              renderFilters(data.filters);
          });
      });

      $('.show_filter').click(function(){
          var filter_id = $(this).parents('.filter_item').attr('data-id'),
              filter_name = $(this).parents('.filter_item').attr('data-name'),
              filter_localities = $(this).parents('.filter_item').attr('data-localities'),
              modal = $("#modal_show_custom_filters"),
              filter_localities_list = [];

          if(filter_localities){
              filter_localities_list = filter_localities.split(',');
          }

          let temp_localities_list = [];

          $("#flt_members_localities option").each(function(){
              var l = $(this).val(),
                  locality =  $(this).text();

              if(l){
                  temp_localities_list.push('<div style="margin-bottom: 5px;"><input style="margin-top:0" id="'+l+'" type="checkbox" '+(filter_localities_list.includes(l)? "checked" : "")+' /><label for="'+l+'" style="display:inline; margin-left: 10px;">'+locality+'</label></div>');
              }
          });

          modal.attr('data-filter_id', filter_id);
          modal.find('.modal-header h3').text(filter_name);
          modal.find('.show_filters_list').html(temp_localities_list.join(''));
          modal.modal('show');
      });
  }

  function get_localities(){
      $.get('/ajax/members.php?get_localities')
      .done (function(data) {
          renderLocalities(data.localities);
      });
  }

  function renderLocalities(localities){
      let localities_list = [],
          selectedLocality = global_admin_localities;

      localities_list.push("<option value='_all_' " + (selectedLocality =='_all_' ? 'selected' : '') +" >Все местности</option>");

      for (var l in localities){
          var locality = localities[l];
          localities_list.push("<option value='"+locality['id']+"' " + (selectedLocality == l ? 'selected' : '') +" >"+he(locality['name'])+"</option>");
      }

      $("#flt_members_localities").html(localities_list.join(''));
  }

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
  $("#btnPrintOpenModalControlListVT, #btnPrintOpenModalControlListVTBlank, #btnPrintOpenModalVT").click(function (e) {
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

  // --- PRINT LIST functions --- //
  // Таблица посещаемости
  function print_rendering_elements(modal, blank) {
    let page = [];
    let blank_text = "";
    if (blank) {
      blank_text = " (бланк)";
    }
    if (modal) {
      page["title"] = "<html lang='ru'><head><title>Таблица посещаемости"+blank_text+"</title></head>";
      page["style"] = "<style>th {border: 1px solid black; text-align: center; border-collapse: collapse; padding: 5px 0px;} table, td {border: 1px solid black; text-align: right; border-collapse: collapse;} .numpp {width: 30px; text-align: center;} .dates{width: 50px;} .fio{text-align: left; padding-left: 5px;} .age {text-align: center;} .bold{font-weight: bold;}</style>";
      page["header"] = "<body><h3>" + $("#flt_members_localities option:selected").text() + "</h3>";
      page["thead"] = "<table><thead><tr><th class='numpp'>№</th><th>ФИО</th><th class='dates'>Возр.</th><th class='dates'></th><th class='dates'></th><th class='dates'></th><th class='dates'></th><th class='dates'></th><th class='dates'></th></tr></thead>";
      page["end"] = "<tr><td colspan='3' style='text-align: right; height: 30px; padding-right: 15px;'><b>ГОСТЕЙ</b></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td colspan='3' style='text-align: right; height: 30px; padding-right: 15px;'><b>ВСЕГО</b></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td colspan='3' style='text-align: right; height: 30px; padding-right: 15px;'><b>ФУНКЦ.</b></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></table></body></html>";
    } else {
      page["tbody"] = "";
      let age, bold, selectors;
      if ($(window).width()<=769) {
        selectors = "#attend_list .attend_str:visible";
      } else {
        selectors = "#attend_list .attend_str:visible";
      }
      if (!blank) {
        $(selectors).each(function (e) {
          if ($(this).find(".data_age").text() && $(this).find(".data_age").text() !== "null"
          && !isNaN($(this).find(".data_age").text())) {
            age = Math.floor($(this).find(".data_age").text());
          } else {
            age = "";
          }

          if ($(this).attr("data-category_key") === "FT") {
            bold = "bold";
          } else {
            bold = "";
          }

          page["tbody"] += "<tbody><tr><td class='numpp'>" + (e + 1)
          + "</td><td class='fio " + bold + "'>" + $(this).find(".data_name").text()
          + "</td><td class='dates age'>" + age + "</td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td></tr>";
        });
      } else {
        for (var i = 0; i < 33; i++) {
          page["tbody"] += "<tbody><tr><td class='numpp' style='height: 25px;'></td><td class='fio' style='width: 400px;'></td><td class='dates age'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td></tr>";
        }
      }
      page["tbody"] += "</tbody>";
    }
    return page;
  }

  // Список ВО
  function print_rendering_elements_vt_list(modal) {
    let page = [];
    if (modal) {
      page["title"] = "<html lang='ru'><head><title>Список участников ВО</title></head>";
      page["style"] = "<style>th {border: 1px solid black; text-align: center; border-collapse: collapse; padding: 5px 0px;} table, td {border: 1px solid black; text-align: right; border-collapse: collapse;} .numpp {width: 30px; text-align: center;} .dates{width: 150px;} .fio{text-align: left; padding-left: 5px; width: 220px;} .age {text-align: center;} .bold{font-weight: bold;}</style>";
      page["header"] = "<body><strong>СПИСОК УЧАСТНИКОВ</strong>";
      page["thead"] = "<table><thead><tr><th class='numpp'>№</th><th>ФИО</th><th class='dates'></th><th class='dates'></th><th class='dates'></th></tr></thead>";
      page["end"] = "</table></body></html>";
    } else {
      page["tbody"] = "";
      let age, bold, selectors;
      if ($(window).width()<=769) {
        selectors = "#attend_list .attend_str:visible";
      } else {
        selectors = "#attend_list .attend_str:visible";
      }
      $(selectors).each(function (e) {
        if ($(this).find(".data_age").text() && $(this).find(".data_age").text() !== "null"
        && !isNaN($(this).find(".data_age").text())) {
          age = Math.floor($(this).find(".data_age").text());
        } else {
          age = "";
        }

        if ($(this).attr("data-category_key") === "FT") {
          bold = "bold";
        } else {
          bold = "";
        }

        page["tbody"] += "<tbody><tr><td class='numpp'>" + (e + 1)
        + "</td><td class='fio " + bold + "'>" + fullNameToNoMiddleName($(this).find(".data_name").text())
        + "</td><td class='dates'></td><td class='dates'></td><td class='dates'></td></tr>";
      });
      page["tbody"] += "</tbody>";
    }
    return page;
  }

  // Контрольный список ВО
  function print_rendering_elements_vt(modal, blank) {
    let blank_text = "";
    if (blank) {
      blank_text = " (бланк)";
    }
    /*let locality_text = "Местность ";
    $("#flt_members_localities option").each(function () {
      if ($(this).text() === "Москва") {
        locality_text = "Район ____";
      }
    });*/
    let page = [];
    if (modal) {
      page["title"] = "<html lang='ru'><head><title>Контрольный список"+blank_text+"</title></head>";
      page["style"] = "<style>th {border: 1px solid black; text-align: center; border-collapse: collapse; padding: 5px 0px;} table, td {border: 1px solid black; text-align: right; border-collapse: collapse;} .numpp {width: 30px; text-align: center;} .dates{width: 50px;} .fio{text-align: left; padding-left: 5px;} .age {text-align: center;} .bold{font-weight: bold;} .center{text-align: center;}</style>"; //" + $("#flt_members_localities option:selected").text() + "
      page["header"] = "<body><strong style='margin-left: 350px;'>КОНТРОЛЬНЫЙ СПИСОК ВИДЕООБУЧЕНИЯ</strong><br><br><span>Местность ______________________</span>"
      + "<span style='padding-left: 20px;'>Даты проведения обучения ___________________</span>"
      + "<span style='padding-left: 20px;'>Ответственный ___________________</span><br><br>";
      page["thead"] = "<table>"
      +"<thead>"
        +"<tr>"
          +"<th class='numpp' rowspan='2' style='text-align: center;'>№<br>п/п</th>"
          +"<th rowspan='2' style='text-align: center; width: 240px;'>Фамилия Имя</th>"
          +"<th class='' rowspan='2' style='text-align: center; padding: 0 5px; width: 100px;'>Взнос и<br>доп. сбор</th>"
          +"<th class='dates' rowspan='2' style='text-align: center; padding: 0 5px;'>Частич.<br>участие</th>"
          +"<th class='dates' colspan='12' style='text-align: center;'>Собрания, посещаемые участниками обучения</th>"
        +"</tr>"
        +"<tr>"
          +"<th class='dates'>1</th>"
          +"<th class='dates'>2</th>"
          +"<th class='dates'>3</th>"
          +"<th class='dates'>4</th>"
          +"<th class='dates'>5</th>"
          +"<th class='dates'>6</th>"
          +"<th class='dates'>7</th>"
          +"<th class='dates'>8</th>"
          +"<th class='dates'>9</th>"
          +"<th class='dates'>10</th>"
          +"<th class='dates'>11</th>"
          +"<th class='dates'>12</th>"
        +"</tr>"
      +"</thead>";
      page["end"] = "<tr><td class='numpp' colspan='2'>Итого ОТСУТСТВУЮЩИХ:</td>"
      + "<td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td></tr></table></body></html>";
    } else {
      page["tbody"] = "<tbody>";
      let age, bold, selectors;
      if ($(window).width()<=769) {
        selectors = "#attend_list .attend_str:visible";
      } else {
        selectors = "#attend_list .attend_str:visible";
      }
      if (!blank) {
        let count_empty_strings = prompt("Сколько добавить пустых строк?", 10);
        if (isNaN(count_empty_strings)) {
          count_empty_strings = 0;
        }
        $(selectors).each(function (e) {
          if ($(this).find(".data_age").text() && $(this).find(".data_age").text() !== "null"
          && !isNaN($(this).find(".data_age").text())) {
            age = Math.floor($(this).find(".data_age").text());
          } else {
            age = "";
          }

          if ($(this).attr("data-category_key") === "FT") {
            bold = "bold";
          } else {
            bold = "";
          }
          let text_v = "";
          let miss = ["","","","","","","","","","","","",""];
          if ($(this).find(".vt_comment_field").val()) {
            let temp = $(this).find(".vt_comment_field").val().trim();
            temp = temp.slice(",");
            if (!isNaN(temp[0])) {
              text_v = 'V';
              for (var i = 1; i <= 12; i++) {
                if (temp.includes(i)) {
                  miss[i] = "—";
                } else {
                  miss[i] = "";
                }
              }
            }
          }

          page["tbody"] += "<tr><td class='numpp'>" + (e + 1)
          + "</td><td class='fio " + bold + "'>" + fullNameToNoMiddleName($(this).find(".data_name").text())
          + "</td><td class='dates'></td><td class='dates center'>"+ text_v
          +"</td><td class='dates center'>"+miss[1]+"</td><td class='dates center'>"+miss[2]
          +"</td><td class='dates center'"+miss[3]+"></td><td class='dates center'>"+miss[4]
          +"</td><td class='dates center'>"+miss[5]+"</td><td class='dates center'>"+miss[6]
          +"</td><td class='dates center'>"+miss[7]+"</td><td class='dates center'>"+miss[8]
          +"</td><td class='dates center'>"+miss[9]+"</td><td class='dates center'>"+miss[10]
          +"</td><td class='dates center'>"+miss[11]+"</td><td class='dates center'>"+miss[12]
          +"</td></tr>";
        });
        for (let i = 0; i < count_empty_strings; i++) {
          page["tbody"] += "<tr><td class='numpp' style='height: 25px;'></td><td class='fio'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td></tr>";
        }
      } else {
        for (let i = 0; i < 20; i++) {
          page["tbody"] += "<tr><td class='numpp' style='height: 25px;'></td><td class='fio'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td></tr>";
        }
      }
      page["tbody"] += "</tbody>";
    }

    return page;
  }

  function print_page(element, is_preview, type) {
    function popup(table){
      let html, mywindow;
      if (type === "vt") {
        html = print_rendering_elements_vt(true);
        mywindow = window.open('', 'Контрольный список ВО', 'height=1000,width=800');
      } else if (type === "vt_blank") {
        html = print_rendering_elements_vt(true, true);
        mywindow = window.open('', 'Контрольный список ВО (бланк)', 'height=1000,width=800');
      } else if (type === "vt_list") {
        html = print_rendering_elements_vt_list(true);
        mywindow = window.open('', 'Список ВО', 'height=800,width=1000');
      } else if (type === "blank") {
        html = print_rendering_elements(true, true);
        mywindow = window.open('', 'Таблица посещаемости (бланк)', 'height=800,width=1000');
      } else {
        html = print_rendering_elements(true);
        mywindow = window.open('', 'Таблица посещаемости', 'height=800,width=1000');
      }

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

  // RENDERING
  get_localities();

  /* ==== DOCUMENT READY STOP ==== */
});
