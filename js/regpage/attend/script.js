
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
        fio = $(this).find('.data_name').text().trim();
        searchResult = true;
        if (fio.toLowerCase().indexOf(String(text.toLowerCase())) === -1) {
          searchResult = false;
        }
      } else {
        searchResult = true;
      }

      // фильтр по местности
      let localities = "";
      if ($("#flt_members_localities").length && $("#flt_members_localities").val()) {
        localities = $("#flt_members_localities").val();
      }

      if (localities !== "_all_" && localities) {
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
      if (getCookie("flt_members_localities")) {
        $("#flt_members_localities").val(getCookie("flt_members_localities"));
      }
  }

  // --- PRINT LIST functions --- //
  // Таблица посещаемости
  function print_badges(modal, blank) {
    let page = [];
    let blank_text = "";
    if (blank) {
      blank_text = " (бланк)";
    }
    if (modal) {
      page["title"] = "<html lang='ru'><head><title>Значки для видеообучения"+blank_text+"</title></head>";
      page["style"] = "<style>table, tr, td{border-collapse: collapse;}"
      +" td{border: 1px dashed gray; background: url('img/lsm-logo-g2.png') no-repeat; background-size: 160px 160px; background-position: 50% 100%; text-align: center; vertical-align: top;}"
      +" hr{border-color: black; border-width: 2px;}"
      +"p {padding: 5px;}</style>";
      page["header"] = "<body style='margin-top: 0px; margin-bottom: 0px;'>";
      page["thead"] = "<table>";
      page["end"] = "";
    } else {
      page["tbody"] = "<tbody>";
      let age, bold, selectors;
      if ($(window).width()<=769) {
        selectors = "#attend_list .attend_str:visible";
      } else {
        selectors = "#attend_list .attend_str:visible";
      }
      let counter_x = 0;
      if (!blank) {
        let topic;
        topic = $("#textTopicVTMdl").val();
        $("#textTopicVTMdl").val("");
        $(selectors).each(function (e) {
          counter_x = e;
          let name = $(this).find(".data_name").text().trim();
          let page_break;
          name = name.split(" ");
          if (e % 10 === 0 && e !== 0) {
            page_break = 'style="page-break-before: always"';
          } else {
            page_break = '';
          }
          if (e % 2 === 0 || e === 0) {
            page["tbody"] += '<tr '+page_break+'><td><div style="min-height: 200px !important; max-height: 200px !important; max-width: 330px !important; min-width: 330px !important; overflow:hidden;"><h2 style="margin-bottom: 0px; margin-top: 6px;">ВИДЕООБУЧЕНИЕ</h2><hr style="margin-top: 4px;">'
            +'<h4 style="margin-bottom: 0px; margin-top: 15px;">' + name[0]
            + '</h4><h1 style="margin-bottom: 0px;  margin-top: 5px;">' + name[1]
            + '</h1><p style="margin-bottom: 0px;  margin-top: 8px;">«' + topic + '»‎</p></div></td>';
          } else {
            page["tbody"] += '<td><div style="min-height: 200px !important; max-height: 200px !important; max-width: 330px !important; min-width: 330px !important; overflow:hidden;"><h2 style="margin-bottom: 0px; margin-top: 6px;">ВИДЕООБУЧЕНИЕ</h2><hr style="margin-top: 4px;">'
            +'<h4 style="margin-bottom: 0px; margin-top: 15px;">' + name[0]
            + '</h4><h1 style="margin-bottom: 0px;  margin-top: 5px;">' + name[1]
            + '</h1><p style="margin-bottom: 0px;  margin-top: 8px;">«‎' + topic + '»‎</p></div></td></tr>';
          }
        });
      } else {
        for (var i = 0; i < 33; i++) {
          page["tbody"] += "<tr><td></td><td></td></tr>";
        }
      }
      if (counter_x % 2 !== 0 || counter_x == 0) {
        page["tbody"] += "</tbody>";
      } else {
        page["tbody"] += "</tr></tbody>";
      }
    }
    return page;
  }

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
      page["tbody"] = "<tbody>";
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

          page["tbody"] += "<tr><td class='numpp'>" + (e + 1)
          + "</td><td class='fio " + bold + "'>" + $(this).find(".data_name").text()
          + "</td><td class='dates age'>" + age + "</td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td></tr>";
        });
      } else {
        for (var i = 0; i < 33; i++) {
          page["tbody"] += "<tr><td class='numpp' style='height: 25px;'></td><td class='fio' style='width: 400px;'></td><td class='dates age'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td><td class='dates'></td></tr>";
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
        let count_empty_strings = $("#textEmptyStrsVT").val();
        if (isNaN(count_empty_strings)) {
          count_empty_strings = 0;
        }
        $("#textEmptyStrsVT").val(10)
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
            temp = temp.split(",");
            if (!isNaN(temp[0])) {
              text_v = 'V';
              for (let i = 1; i <= 12; i++) {
                if (temp.includes(String(i))) {
                  miss[i] = "—";
                } else {
                  miss[i] = "";
                }
              }
            }
          }
          let fee;
          if (!$(this).find(".vt_fee_text").text() || $(this).find(".vt_fee_text").text() === "0") {
            fee = "";
          } else {
            fee = $(this).find(".vt_fee_text").text();
          }
          page["tbody"] += "<tr><td class='numpp'>" + (e + 1)
          + "</td><td class='fio " + bold + "'>" + fullNameToNoMiddleName($(this).find(".data_name").text())
          + "</td><td class='dates age'>"+ fee +"</td><td class='dates center'>"+ text_v
          +"</td><td class='dates center'>"+miss[1]+"</td><td class='dates center'>"+miss[2]
          +"</td><td class='dates center'>"+miss[3]+"</td><td class='dates center'>"+miss[4]
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
      } else if (type === "badges") {
        html = print_badges(true);
        mywindow = window.open('', 'Значки', 'height=1000,width=800');
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
// BLANK
// получаем данные пользователя
function get_member_data(member_key, age) {
  fetch("ajax/attend_ajax.php?type=get_member_data&id=" + member_key)
  .then(response => response.json())
  .then(commits => {
    //let fields = ['key', 'name', 'male', 'birth_date', 'locality_key', 'category_key', 'address', 'home_phone', 'cell_phone', 'email', 'document_key', 'document_num', 'document_date', 'document_auth', 'document_dep_code', 'citizenship_key', 'changed', 'new_locality', 'comment', 'admin_key', 'active', 'tp_num', 'tp_date', 'tp_auth', 'tp_name', 'english', 'school_start', 'school_end', 'college_start', 'college_end', 'college_key', 'college_comment', 'school_comment', 'russian_lg', 'baptized', 'attend_meeting', 'serving', 'college', 'document'];
    /*for (let i = 0; i < fields.length; i++) {
      $("#" + fields[i]).val(commits.result[fields[i] + "_key"]);
      $("#" + fields[i]).val(commits.result[fields[i]]);
    }*/

    $("#citizenship").val(commits.result["citizenship_key"]);
    $("#address").val(commits.result["address"]);
    $("#category").val(commits.result["category_key"]);
    $("#russianLanguage").val(commits.result["russian_lg"]);
    $("#comment").val(commits.result["comment"]);
    $("#emNewLocality").val(commits.result["new_locality"]);
    $("#gender").val(commits.result["male"]);
    $("#birth_date").val(commits.result["birth_date"]);
    $("#email").val(commits.result["email"]);
    $("#phone").val(commits.result["cell_phone"]);


    $("#emBaptized").val(commits.result["baptized"]);

    $("#emDocumentType").val(commits.result["document_key"]);
    $("#emDocumentNum").val(commits.result["document_num"]);
    $("#emDocumentDate").val(commits.result["document_date"]);
    $("#emDocumentAuth").val(commits.result["document_auth"]);

    $("#emDocumentNumTp").val(commits.result["tp_num"]);
    $("#emDocumentAuthTp").val(commits.result["tp_auth"]);
    $("#emDocumentDateTp").val(commits.result["tp_date"]);
    $("#emDocumentNameTp").val(commits.result["tp_name"]);

    handleSchoolAndCollegeFields(age, commits.result["category_key"], commits.result["school_start"], commits.result["school_end"], commits.result["college_start"], commits.result["college_end"], commits.result["college_key"], commits.result["college_comment"], "", "", commits.result["school_comment"]);

    $("#comment").val(commits.result["comment"]);

    if (commits.result["new_locality"]) {
      $("#locality").hide();
      $("#emNewLocality").show();
      $("#reset_locality").show();
    } else {
      $("#locality").show();
      $("#emNewLocality").hide();
      $("#reset_locality").hide();
    }
  });
}

// заполнение бланка
function fill_blank(str) {
  clear_blank();
  $("#modalAddEdit").attr("data-member_key", str.attr("data-member_key"));
  $("#name").val(str.find(".data_name").text());
  $("#locality").val(str.attr("data-locality_key"));
  get_member_data(str.attr("data-member_key"), str.find(".data_age").text());
}

// очистка бланка
function clear_blank() {
  $("#modalAddEdit input").val("");
  $("#modalAddEdit select").val("_none_");
  $("#gender").val(1);
  $("#russianLanguage").val(1);
  $("#modalAddEdit").attr("data-member_key", "");
  $("#localityControlGroup").parent().parent().hide();
}

// получаем данные полей бланка
function get_data_blank() {
  let data = {};
  data["condition"] = {};
  data["condition"]["field"] = "key";
  data["condition"]["value"] = $("#modalAddEdit").attr("data-member_key");
  data["table"] = "member";
  data["changed"] = 1;
  $("#modalAddEdit input").each(function () {
    data[$(this).attr("data-field")] = $(this).val();
  });
  $("#modalAddEdit select").each(function () {
    data[$(this).attr("data-field")] = $(this).val();
  });
  return data;
}
// сохранение бланка
function save_blank(data, add) {
  let data_post = new FormData();
  data_post.set("data", JSON.stringify(data));
  let ajax_path = "ajax/ftt_list_ajax.php?type=save_blank";
  if (add) {
    ajax_path = "ajax/attend_ajax.php?type=add_blank";
  }
  fetch(ajax_path, {
    method: 'POST',
    body: data_post
  })
  .then(response => response.text())
  .then(commits => {
    $("#spinner").modal("hide");
    location.reload();
  });
}

// валидация полей бланка
function valid_fields() {
  let required_fields = document.querySelectorAll(".required_field");
  let empty = 0, error;
  required_fields.forEach(el => {
    if ((el.id === "locality" && el.value === "_none_") || (el.id === "emNewLocality" && !el.value)) {
      empty++;
    } else if (!el.value || el.value === "_none_") {
      error = 1;
    }
  });
  if (empty === 2 || error) {
    return 1;
  } else {
    return false;
  }
}

// настройка бланка для студентов и школьников
function handleSchoolAndCollegeFields(age, categoryKey, schoolStart, schoolEnd, collegeStart, collegeEnd, college, collegeComment, collegeName, collegeShortName, schoolComment){

  /*$("#emSchoolStart").val(commits.result["school_start"] == 0 ? "" : commits.result["school_start"]);
  $("#emSchoolEnd").val(commits.result["school_end"] == 0 ? "" : commits.result["school_end"]);
  $("#emSchoolComment").val(commits.result["school_comment"] == 0 ? "" : commits.result["school_comment"]);

  $("#emCollege").val(commits.result["college_key"]);
  $("#emCollegeStart").val(commits.result["college_start"] == 0 ? "" : commits.result["college_start"]);
  $("#emCollegeEnd").val(commits.result["college_end"] == 0 ? "" : commits.result["college_end"]);
  $("#emCollegeComment").val(commits.result["college_comment"] == 0 ? "" : commits.result["college_comment"]);*/

  let isSchool = categoryKey === "SC" || categoryKey === "PS" || ( !isNaN(age) && age < 18 && age > 6 );
  let isCollege = categoryKey === "ST" || ( categoryKey === "SC" && !isNaN(age) && age > 15 ) || (!isNaN(age) && age > 18 && age < 25);


  if (isSchool) {
    // $('.school-fields').css('display', isSchool ? 'block' : 'none');
    $('.school-fields').show();
  } else {
    $('.school-fields').hide();
  }
  if (isCollege) {
    //$('.college-fields').css('display', isCollege ?'block' : 'none');
    $('.college-fields').show();
  } else {
    $('.college-fields').hide();
  }

  let currentYear = new Date().getFullYear();

  if(isSchool){
      $('#emSchoolStart').val(schoolStart>0 ? schoolStart : '');
      $('#emSchoolEnd').val(schoolEnd>0 ? schoolEnd : '');
      $('#emSchoolComment').val(schoolComment || '');
      var classLevel = schoolStart && schoolStart.length === 4 ? currentYear - schoolStart + 1 : '';
      $('#emClassLevel').html(classLevel > 0 && classLevel < 12 ? '('+classLevel+' класс)' : '');
      if(classLevel >= 9){
          $('.college-fields').css('display', 'block');
      }
  }

  if(isCollege){
      $('#emCollegeStart').val(collegeStart >0 ? collegeStart : '');
      $('#emCollegeEnd').val(collegeEnd >0 ? collegeEnd : '');
      $("#emCollege").val(college);
      //$('#emCollege').val(collegeShortName && collegeName ? collegeShortName + ' ('+collegeName+')' : '');
      //$('#emCollege').attr('data-college', college);
      $('#emCollegeComment').val(collegeComment || '');

      currentYear = parseInt(currentYear);
      var startCollege = collegeStart && collegeStart.length === 4 ? parseInt(collegeStart) : null ;
      var endCollege = collegeEnd && collegeEnd.length === 4 ? parseInt(collegeEnd) : null ;
      var courseLevel = startCollege ? currentYear - startCollege + 1 : null;

      if(startCollege && endCollege){
          if(currentYear < startCollege){
              courseLevel = "планирует поступить";
          } else if (currentYear === endCollege) {
              var currentMonth = new Date().getMonth();
              courseLevel = currentMonth >= 6 ? "обучение завершено" : courseLevel + " курс, окончание в этом году";
          } else if (currentYear > endCollege) {
              courseLevel = "учёба завершена";
          } else {
                courseLevel = courseLevel+" курс";
            }
        }

        $('.emCourseLevel').html(courseLevel ? '('+courseLevel+')' : '');
    }
}
