// FTT FELLOWSHIP
$(document).ready(function(){
  /*** FELLOWSHIP TAB START ***/
  $("#meet_add").click(function () {
    if ($("#meet_serving_ones_list_calendar").val() !== '_all_') {
      // это не возможно тк при закрытии бланка раздел перезагружается
      get_records_cal($("#meet_serving_ones_list_calendar").val());
    } else if (trainee_list_full[window.adminId]["male"] === "1" && trainee_access === "1") {
      //get_communication_list("pvom_br");
      get_records_cal("pvom_br");
    } else {
      //get_communication_list("_all_");
      get_records_cal("_all_");
    }
  });

  // получаем данные
  function get_records_cal(pvom_br) {
    fetch("ajax/ftt_fellowship_ajax.php?type=get_communication_list&serving_ones="+pvom_br+"&sort=meet_sort_servingone-asc")
    .then(response => response.json())
    .then(commits => {
      calendar(commits.result);
    });
  }
  $("#meet_serving_ones_list_calendar").change(function () {
    get_records_cal($("#meet_serving_ones_list_calendar").val());
  });
  // страрый вариант получаем данные
  /*
  function get_communication_list(pvom_br) {
    fetch("ajax/ftt_fellowship_ajax.php?type=get_communication_list&member_id=_all_&serving_ones="+pvom_br+"&sort=meet_sort_date-asc&canceled=0")
    .then(response => response.json())
    .then(commits => {
      render_communication_list(commits.result);
    });
    setTimeout(function () {
      fetch("ajax/ftt_fellowship_ajax.php?type=get_communication_list&member_id=_all_&serving_ones=kbk&sort=meet_sort_date-asc&canceled=0")
      .then(response => response.json())
      .then(commits => {
        render_communication_list(commits.result, true);
      });
    }, 10);
  }
*/
/*
  // старый вариант рендерим
  function render_communication_list(data, kbk) {
    let html = "", weeks = [], blocks = {};

    // получаем дату
    let d = new Date();

    // получаем даты на 4 недели от полученного понедельника
    weeks = get_curr_week_dates(4);

    for (let variable in data) {
      html += '<div class="d-flex meet_serving_one" data-serving_one="' + variable + '"><span style="align-self: center; max-width: 100px;">'
      + serving_ones_list[variable] + '</span>';
      if (data.hasOwnProperty(variable)) {
        blocks[variable] = {1:[], 2:[], 3:[], 4:[]};
        let obj = data[variable], weeks_active;
        for (let key in obj) {
          if (obj.hasOwnProperty(key)) {
            let str = obj[key];
            let bg = "";
            let key_week = weeks.indexOf(str["date"]);
            weeks_active = {first: "text-danger", second: "text-danger", third: "text-danger", fourth: "text-danger"};
            // block
            // date
            if (key_week < 7) {
              blocks[variable][1].push({id: str["id"], serving_one: str["serving_one"], category: str["category"],
              date: str["date"], time: str["time"], duration: str["duration"], trainee: str["trainee"],
              comment_train: str["comment_train"], comment_serv: str["comment_serv"], canceled: str["canceled"]});
              weeks_active.first = "text-success";
            } else if (key_week > 6 && key_week < 14) {
              blocks[variable][2].push({id: str["id"], serving_one: str["serving_one"], category: str["category"],
              date: str["date"], time: str["time"], duration: str["duration"], trainee: str["trainee"],
              comment_train: str["comment_train"], comment_serv: str["comment_serv"], canceled: str["canceled"]});
              weeks_active.second = "text-success";
            } else if (key_week > 13 && key_week < 21) {
              blocks[variable][3].push({id: str["id"], serving_one: str["serving_one"], category: str["category"],
              date: str["date"], time: str["time"], duration: str["duration"], trainee: str["trainee"],
              comment_train: str["comment_train"], comment_serv: str["comment_serv"], canceled: str["canceled"]});
              weeks_active.third = "text-success";
            } else if (key_week > 20) {
              blocks[variable][4].push({id: str["id"], serving_one: str["serving_one"], category: str["category"],
              date: str["date"], time: str["time"], duration: str["duration"], trainee: str["trainee"],
              comment_train: str["comment_train"], comment_serv: str["comment_serv"], canceled: str["canceled"]});
              weeks_active.fourth = "text-success";
            }
          }
        }
        // квадратики
        let week_class = "week_records";
        if (kbk) {
          week_class = "week_records_kbk";
        }

        // цвет на данных
        html += '<i class="fa fa-square cursor-pointer ml-3 mr-3 '+weeks_active.first+' ' + week_class + ' " data-week="1" style="font-size:48px; align-self: center;"></i>'
        +'<i class="fa fa-square cursor-pointer mr-3 '+weeks_active.second+' ' + week_class + '" data-week="2" style="font-size:48px; align-self: center;"></i>'
        +'<i class="fa fa-square cursor-pointer mr-3 '+weeks_active.third+' ' + week_class + '" data-week="3" style="font-size:48px; align-self: center;"></i>'
        +'<i class="fa fa-square cursor-pointer '+weeks_active.fourth+' ' + week_class + '" data-week="4" style="font-size:48px; align-self: center;"></i><br>';
      }

      html += '</div>';
    }
    if (kbk) {
      $("#list_staff_kbk").html(html);
    } else {
      $("#list_staff_pvom").html(html);
    }


    // open blank
    $(".communication_str").click(function () {
      if (!$(this).attr("data-trainee")) {
        $("#edit_meet_blank_confirm h5").text("Записаться на общение "
        + $(this).text() + "?");
        $("#edit_meet_blank_confirm").attr("data-trainee", window.adminId);
        $("#edit_meet_blank_confirm").attr("data-id", $(this).attr("data-id"));
        $("#edit_meet_blank_confirm").modal("show");
      } else {
        showError("Время не доступно для записи");
      }
    });

    // to record
    if (kbk) {
      // открываем выбранную неделю
      $(".week_records_kbk").click(function () {
        // рендерим список записей служащего
        set_communication_record_check($(this), blocks, 1);

      });
    } else {
      $(".week_records").click(function () {
        // рендерим список записей служащего
        set_communication_record_check($(this), blocks);
      });
    }
  }
*/
  function set_communication_record_check(elem, blocks, kbk) {
    if (elem.hasClass("text-danger")) {
      return;
    }
    if (kbk) {
      kbk = "_kbk";
    } else {
      kbk = "";
    }
    let html_time = "", str, date_prev;
    str = blocks[String(elem.parent().attr("data-serving_one"))][elem.attr("data-week")];

    for (let i = 0; i < str.length; i++) {
      if (date_prev !== str[i]["date"]) {
        if (html_time) {
          html_time += '<br><br><strong class="pt-2 pb-2">' + dateStrFromyyyymmddToddmm(str[i]["date"]) + '</strong><br>';
        } else {
          html_time += '<strong class="pb-2">' + serving_ones_list[str[i]["serving_one"]] + '</strong><br>';
          html_time += '<strong class="pt-2 pb-2">' + dateStrFromyyyymmddToddmm(str[i]["date"]) + '</strong><br>';
        }
      }

      let disabled = "", checked = "", hidden = "display: none !important;";
      if (str[i]["trainee"] && str[i]["trainee"] === window.adminId) {
        checked = "checked";
        hidden = "";
      } else if (str[i]["trainee"]) {
        disabled = "disabled";
        checked = "checked";
      }

      html_time += '<span style="vertical-align: middle;">' + str[i]["time"]
      + " — " + time_plus_minutes(str[i]["time"], str[i]["duration"])
      + '</span><span class="meet_checked cursor-pointer link_custom' + kbk + ' ml-1 mr-3" data-id="' + str[i]["id"]
      + '" data-from="' + str[i]["time"] + '" data-to="' + time_plus_minutes(str[i]["time"], str[i]["duration"])
      + '" data-date="'+str[i]["date"]+'" style="vertical-align: middle;" ' + checked + ' ' + disabled
      + '>Записаться</span>';
    }
    // Добавляем контент
    $("#list_possible_records").html(html_time);

    // Сохраняем значение
    $(".meet_checked" + kbk).change(function () {
      let trainee = window.adminId;
      let checked_time = 0;
      if ($(this).prop("checked")) {
        checked_time = 1;
        if (!$(this).next().hasClass("d-inline-block")) {
          $(this).next().addClass("d-inline-block");
        }
        $(this).next().show();
      } else {
        $(this).next().removeClass("d-inline-block");
        $(this).next().hide();
        $(this).next().val("");
      }
      fetch("ajax/ftt_fellowship_ajax.php?type=set_communication_record&id="
      + $(this).attr("data-id") + "&trainee=" + trainee + "&checked=" + checked_time + "&time_from=" + $(this).attr("data-from") + "&time_to=" + $(this).attr("data-to") + "&date=" + $(this).attr("data-date"))
      .then(response => response.json())
      .then(commits => {
        if ($(this).prop("checked")) {
          if (commits.result !== true) {
            showError("На это время и дату уже назначена встреча с " + serving_ones_list[commits.result] + ". Запись не сохранена.");
            $(this).prop("checked", false);
          } else {
            showHint("Запись на общение сохранена.");
          }
        } else {
          showHint("Запись на общение отменена.");
        }
      });
    });
    // открываем окно
    $("#mdl_meet_trainee_to_record").modal("show");
  }

  $("#mdl_meet_trainee_to_record").on("hide.bs.modal", function () {
    setTimeout(function () {
      $("body").addClass("modal-open");
    }, 500);
  });

  // open record
  $(".str_record").click(function () {
    fill_meet_staff_blank($(this), 1);
  });

  $("#undo_meet_blank").click(function () {
    cancel_meet_blank($("#edit_meet_blank_record").attr("data-id"));
  });

  $("#edit_meet_blank").on("hide.bs.modal", function () {
    setTimeout(function () {
      location.reload();
    }, 50);
  });
  // сортировка
  $("#meet_sort_date, #meet_sort_servingone, #meet_sort_trainee, #meet_sort_time").click(function (e) {
    //cookie_filters();
    if (!$(this).find("i").is(":visible") || ($(this).find("i").is(":visible") && $(this).find("i").hasClass("fa-sort-desc"))) {
      setCookie('meet_sorting', e.target.id + "-asc", 356);
    } else if ($(this).find("i").is(":visible") && $(this).find("i").hasClass("fa-sort-asc")) {
      setCookie('meet_sorting', e.target.id + "-desc", 356);
    }
    /*
    else {
      let sorting_name = e.target.className;
      $(".meet_sort_date i, .meet_sort_servingone i").addClass("hide_element");
      if ($(this).hasClass("meet_sort_date")) {
        $(".meet_sort_servingone i").removeClass("fa");
        $(".meet_sort_servingone i").removeClass("fa-sort-desc");
        $(".meet_sort_servingone i").removeClass("fa-sort-asc");
      } else if ($(this).hasClass("meet_sort_servingone")) {
        $(".meet_sort_date i").removeClass("fa");
        $(".meet_sort_date i").removeClass("fa-sort-desc");
        $(".meet_sort_date i").removeClass("fa-sort-asc");
      }

      $(this).find("i").removeClass("hide_element");
      if ($(this).find("i").hasClass("fa-sort-desc")) {
        $(this).find("i").removeClass("fa-sort-desc").addClass("fa-sort-asc");
        setCookie('skip_sorting', sorting_name + "-desc", 356);
      } else if ($(this).find("i").hasClass("fa-sort-asc")) {
        $(this).find("i").removeClass("fa-sort-asc").addClass("fa-sort-desc");
        setCookie('skip_sorting', sorting_name + "-asc", 356);
      } else {
        $(this).find("i").addClass("fa");
        $(this).find("i").addClass("fa-sort-asc");
        setCookie('skip_sorting', sorting_name + "-desc", 356);
      }
    }
    */
    setTimeout(function () {
      location.reload();
    }, 30);
  });

  /***    MEET STAFF   ***/
  $(".str_record_staff").click(function () {
    fill_meet_staff_blank($(this));
  });

  $("#mdl_edit_fellowship_staff").on("hide.bs.modal",function () {
    reset_meet_staff_blank($(this));
  });

  $("#mdl_btn_meet_ok").click(function () {
    if (trainee_access) {
      meet_comment_change($("#mdl_meet_comment_trainee").val(), 1);
    } else {
      save_meet_staff_blank();
    }
    $("#mdl_edit_fellowship_staff").modal("hide");
    setTimeout(function () {
      location.reload();
    }, 300);
  });

  $("#meet_cancel").click(function () {
    if (!$("#mdl_edit_fellowship_staff").attr("data-trainee")) {
      return;
    }
    if (confirm("Отменить запись на общение?")) {
      cancel_meet_blank($("#mdl_edit_fellowship_staff").attr("data-id"),$("#mdl_meet_comment_trainee").val());
      setTimeout(function () {
        $("#mdl_edit_fellowship_staff").modal("hide");
      }, 750);
    }
  });

  // cancel meet
  function cancel_meet_blank(id, comment) {
    fetch("ajax/ftt_fellowship_ajax.php?type=cancel_communication_record&id=" + id + "&comment=" + comment)
    .then(response => response.json())
    .then(commits => {
      showHint("Запись успешно отменена");
      setTimeout(function () {
        location.reload();
      }, 1500);
    });
  }
  // заполнеие бланка
  function fill_meet_staff_blank(elem, trainee) {
    if (trainee) {
      $("#mdl_edit_fellowship_staff input").attr("disabled", true);
      $("#mdl_edit_fellowship_staff select").attr("disabled", true);
    }
    // data
    $("#mdl_edit_fellowship_staff").attr("data-id", elem.attr("data-id"));
    $("#mdl_edit_fellowship_staff").attr("data-date", elem.attr("data-date"));
    $("#mdl_edit_fellowship_staff").attr("data-trainee", elem.attr("data-trainee"));
    $("#mdl_edit_fellowship_staff").attr("data-comment", elem.attr("data-comment"));
    // fields
    $("#mdl_meet_trainee_list").val(elem.attr("data-trainee"));
    $("#mdl_meet_serving_ones_list").val(elem.attr("data-serving_one"));
    $("#mdl_meet_date").val(elem.attr("data-date"));
    $("#mdl_meet_duration").val(elem.attr("data-duration"));
    $("#mdl_meet_time").val(elem.attr("data-time"));
    $("#mdl_meet_comment_trainee").val(elem.attr("data-comment"));
    $("#mdl_edit_fellowship_staff").modal("show");
  }

  function reset_meet_staff_blank(elem) {
    elem.attr("data-trainee", "");
    elem.attr("data-comment", "");
    module_blank_clear(elem);
  }

  function save_meet_staff_blank() {
    let data_temp = {};
    let data = new FormData();
    data_temp["id"] = $("#mdl_edit_fellowship_staff").attr("data-id");
    data_temp["date"] = $("#mdl_meet_date").val();
    data_temp["time"] = $("#mdl_meet_time").val();
    data_temp["duration"] = $("#mdl_meet_duration").val();
    data_temp["serving_one"] = $("#mdl_meet_serving_ones_list").val();
    data_temp["trainee"] = $("#mdl_meet_trainee_list").val();
    data_temp["comment_train"] = $("#mdl_meet_comment_trainee").val();
    data_temp["comment_serv"] = ""; //$("#mdl_meet_comment_serving_one").val()
    data.set("data", JSON.stringify(data_temp));

    fetch("ajax/ftt_fellowship_ajax.php?type=set_meet_staff_blank", {
      method: 'POST',
      body: data
    })
    .then(response => response.text())
    .then(commits => {
      $("#mdl_edit_fellowship_staff").modal("hide");
      showHint("Данные сохранены");
    });
  }

  $("#meet_serving_ones_list, #meet_trainee_select").change(function (e) {
    if (e.target.id === "meet_serving_ones_list") {
      setCookie('meet_flt_staff', $(this).val(), 356);
      setTimeout(function () {
        location.reload();
      }, 50);
    } else if (e.target.id === "meet_trainee_select") {
      setCookie('meet_flt_trainee', $(this).val(), 356);
      setTimeout(function () {
        location.reload();
      }, 50);
    }
    //flt_fellowship($(this));
  });
  // mobile filters
  $("#flt_sevice_one_meet_mbl, #ftr_trainee_meet_mbl").change(function (e) {
    if ($(this).attr("id") === "flt_sevice_one_meet_mbl") {
      setCookie('meet_flt_staff', $(this).val(), 356);
    } else if ($(this).attr("id") === "ftr_trainee_meet_mbl") {
      setCookie('meet_flt_trainee', $(this).val(), 356);
    }
  });
  // apply the filters of the modal
  $("#apply_filters_meet_mbl").click(function () {
    setTimeout(function () {
      location.reload();
    }, 50);
  });

  // фильтры
  /*
  function flt_fellowship(elem) {
    $("").each(function () {
      if ($(this)) {

      } else {

      }
    });
  }
  */
  // CALENDAR
  function calendar(records) {

    //let html = '<div class="calendar-wrapper"><button id="btnPrev" type="button">Предыдущий</button><button id="btnNext" type="button">Следующий</button><div id="divCal"></div>';
    let Cal = function(divId) {
      //Сохраняем идентификатор div
      this.divId = divId;
      // Дни недели с понедельника
      this.DaysOfWeek = [
        'Пн',
        'Вт',
        'Ср',
        'Чт',
        'Пт',
        'Сб',
        'Вс'
      ];
      // Месяцы начиная с января
      this.Months =['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
      //Устанавливаем текущий месяц, год
      let d = new Date();
      this.currMonth = d.getMonth();
      this.currYear = d.getFullYear();
      this.currDay = d.getDate();
    };
    // Переход к следующему месяцу
    Cal.prototype.nextMonth = function() {
      if ( this.currMonth == 11 ) {
        this.currMonth = 0;
        this.currYear = this.currYear + 1;
      }
      else {
        this.currMonth = this.currMonth + 1;
      }
      this.showcurr();
    };
    // Переход к предыдущему месяцу
    Cal.prototype.previousMonth = function() {
      if ( this.currMonth == 0 ) {
        this.currMonth = 11;
        this.currYear = this.currYear - 1;
      }
      else {
        this.currMonth = this.currMonth - 1;
      }
      this.showcurr();
    };
    // Показать текущий месяц
    Cal.prototype.showcurr = function() {
      this.showMonth(this.currYear, this.currMonth);
    };
    // Показать месяц (год, месяц)
    Cal.prototype.showMonth = function(y, m) {
      let d = new Date()
      // Первый день недели в выбранном месяце
      , firstDayOfMonth = new Date(y, m, 7).getDay()
      // Последний день выбранного месяца
      , lastDateOfMonth =  new Date(y, m+1, 0).getDate()
      // Последний день предыдущего месяца
      , lastDayOfLastMonth = m == 0 ? new Date(y-1, 11, 0).getDate() : new Date(y, m, 0).getDate();
      let html = '<table>';
      // Запись выбранного месяца и года
      html += '<thead><tr>';
      html += '<td colspan="7">' + this.Months[m] + ' ' + y + '</td>';
      html += '</tr></thead>';
      // заголовок дней недели
      html += '<tr class="days">';
      for(let i=0; i < this.DaysOfWeek.length;i++) {
        html += '<td>' + this.DaysOfWeek[i] + '</td>';
      }
      html += '</tr>';
      // Записываем дни
      let i=1;
      do {
        let dow = new Date(y, m, i).getDay();
        // Начать новую строку в понедельник
        if ( dow == 1 ) {
          html += '<tr>';
        }
        // Если первый день недели не понедельник показать последние дни предыдущего месяца
        else if (i == 1) {
          html += '<tr>';
          let k = lastDayOfLastMonth - firstDayOfMonth+1;
          for(let j=0; j < firstDayOfMonth; j++) {
            html += '<td class="not-current">' + k + '</td>';
            k++;
          }
        }
        // Записываем текущий день в цикл
        let chk = new Date();
        let chkY = chk.getFullYear();
        let chkM = chk.getMonth();
        if (chkY == y && chkM == m && i == this.currDay) { //this.currMonth
          let record_available = "", not_available = "";
          let date_record = chkY + '-' + (m < 9 ? '0' + String(m+1) : m+1)  + '-' + i;
          let sim = "";
          // проверка, добавление класса
          for (let variable in records) {
            if (records.hasOwnProperty(variable)) {
              records[variable].find(function (str, i) {
                if (str.date && str.date === date_record && (!record_available || !sim)) {
                  if (!str.trainee || str.trainee === window.adminId) {
                    record_available = "record_available";
                  } else if (str.trainee) {
                    sim = 1;
                  }
                }
              });
            }
          }
          if (!record_available && sim) {
            record_available = "record_not_available";
          }
          html += '<td class="today ' + record_available + '" data-date="' + date_record + '">' + i + '</td>';
        } else {
          // проверка, добавление класса
          let record_available = "", day_date = i;
          let date_record = y + '-' + (m < 9 ? '0' + String(m+1) : m+1)  + '-' + (i < 10 ? '0' + String(day_date) : day_date);
          let sim = "";
          for (let variable in records) {
            if (records.hasOwnProperty(variable)) {
              records[variable].find(function (str, i) {
                if (str.date && str.date === date_record && (!record_available || !sim)) {
                  if (!str.trainee || str.trainee === window.adminId) {
                    record_available = "record_available";
                  } else if (str.trainee) {
                    sim = 1;
                  }
                }
              });
            }
          }
          if (!record_available && sim) {
            record_available = "record_not_available";
          }
          html += '<td class="normal ' + record_available + '" data-date="' + date_record + '">' + i + '</td>';
        }
        // закрыть строку в воскресенье
        if (dow == 0) {
          html += '</tr>';
        }
        // Если последний день месяца не воскресенье, показать первые дни следующего месяца
        else if ( i == lastDateOfMonth ) {
          let k=1;
          for(dow; dow < 7; dow++) {
            html += '<td class="not-current">' + k + '</td>';
            k++;
          }
        }
        i++;
      }while(i <= lastDateOfMonth);
      // Конец таблицы
      html += '</table>';
      // Записываем HTML в div
      document.getElementById(this.divId).innerHTML = html;
      // open time list
      $(".normal, .today").click(function () {
        if (!$(this).hasClass("record_available")) {
          return;
        }
        let serving_ones_arg;
        if ($("#meet_serving_ones_list_calendar").val() === "_all_" || !$("#meet_serving_ones_list_calendar").val()) {
          if (trainee_list_full[window.adminId]["male"] === "1") {
            serving_ones_arg = "pvom_br";
          } else {
            serving_ones_arg = "_all_";
          }
        } else {
          serving_ones_arg = $("#meet_serving_ones_list_calendar").val();
        }
        fetch("ajax/ftt_fellowship_ajax.php?type=get_meet_by_date&date=" + $(this).attr("data-date") + "&serving_ones="+serving_ones_arg)
        .then(response => response.json())
        .then(commits => {
          day_records = commits.result;
          let html_checkboxes = "", first = 1;
          // рендерим время
          for (let variable in day_records) {
            if (day_records.hasOwnProperty(variable)) {
              let value_records = day_records[variable];
              let str_id = value_records.find(str => str.date === $(this).attr("data-date"));
              if (str_id !== undefined) {
                if (first) {
                  html_checkboxes = '<div class="mb-2"><strong class="pt-2 pb-2 date_record_header">' + dateStrFromyyyymmddToddmm($(this).attr("data-date")) + '</strong><br>';
                  html_checkboxes += '<strong class="pb-2 name_record_header">' + serving_ones_list[variable] + '</strong></div>';
                } else {
                  html_checkboxes += '<div class="mt-3 mb-2"><strong class="pb-2 name_record_header">' + serving_ones_list[variable] + '</strong></div>';
                }
                first = 0;
              }

              for (let variable_1 in value_records) {
                if (value_records.hasOwnProperty(variable_1)) {
                  let value_record = value_records[variable_1];
                  if (value_record["date"] === $(this).attr("data-date")) {
                    let disabled = "", busy = "", my = "", text = "Записаться";
                    if (value_record["trainee"] && value_record["trainee"] === window.adminId) {
                      busy = "1";
                      my = "1";
                      text = "Вы записаны"
                    } else if (value_record["trainee"]) {
                      busy = "1";
                      text = "Недоступно"
                    }
                    value_record["comment"] === undefined ? value_record["comment"] = "" : "";
                    html_checkboxes += '<div class="mb-2"><span class="d-inline-block font-weight-normal pt-2 pb-2" style="vertical-align: middle; width: 105px;">' + value_record["time"]
                    + " — " + time_plus_minutes(value_record["time"], value_record["duration"])
                    + '</span><span id="checkbox_time_' + value_record["id"] + '" class="pb-2 meet_checked mr-3 cursor-pointer link_custom" data-id="' + value_record["id"]
                    + '" data-from="' + value_record["time"] + '" data-to="' + time_plus_minutes(value_record["time"], value_record["duration"])
                    + '" data-serving_one="' + variable + '" data-date="'+value_record["date"]+'" data-comment="'+value_record["comment_train"]+'" data-busy="' + busy + '"  data-my="' + my + '"  style="vertical-align: middle;"'
                    + '>'+text+'</span>';
                  }
                }
              }
            }
          }
          $("#list_possible_records").html(html_checkboxes);
          // ОТКРЫВАЕМ ОКНО ПОДТВЕРЖДЕНИЕ
          $(".meet_checked").click(function () { // + kbk
            // учитывать "свои" сохранённые записи и чужие!
            if ($(this).attr("data-busy") === "1" && $(this).attr("data-my") !== "1") {
              return;
            }
            $("#edit_meet_blank_record_confirm").modal("show");
            // заполняем атрибуты
            $("#edit_meet_blank_record_confirm").attr("data-id", $(this).attr("data-id"));
            $("#edit_meet_blank_record_confirm").attr("data-serving_one", $(this).attr("data-serving_one"));
            $("#edit_meet_blank_record_confirm").attr("data-date", $(this).attr("data-date"));
            $("#edit_meet_blank_record_confirm").attr("data-from", $(this).attr("data-from"));
            $("#edit_meet_blank_record_confirm").attr("data-to", $(this).attr("data-to"));
            $("#edit_meet_blank_record_confirm").attr("data-busy", $(this).attr("data-busy"));
            $("#edit_meet_blank_record_confirm").attr("data-my", $(this).attr("data-my"));
            if ($(this).attr("data-my") === "1") {
              $("#confirm_meet_record").removeClass("btn-success").addClass("btn-danger").text("Отменить");
              $("#edit_meet_blank_record_confirm h5").text("Отменить запись");
            } else {
              $("#confirm_meet_record").removeClass("btn-danger").addClass("btn-success").text("Записаться");
              $("#edit_meet_blank_record_confirm h5").text("Подтвердите запись");
            }
            // заполняем поля и пр.
            if ($(this).attr("data-comment")) {
              $(".meet_comment_trainee_time").val($(this).attr("data-comment"));
            } else {
              $(".meet_comment_trainee_time").val("");
            }
            $("#time_record_for_success").text(dateStrFromyyyymmddToddmm($(this).attr("data-date")) + " " + serving_ones_list[$(this).attr("data-serving_one")] + " с " + $(this).attr("data-from") + " по " + $(this).attr("data-to"));
          });
          // открываем окно
          $("#mdl_meet_trainee_to_record").modal("show");
        });
      });
    };

    // Начать календарь
    let c = new Cal("divCal");
    c.showcurr();
    // Привязываем кнопки «Следующий» и «Предыдущий»
    getId('btnNext').onclick = function() {
      c.nextMonth();
    };
    getId('btnPrev').onclick = function() {
      c.previousMonth();
    };

    // Получить элемент по id
    function getId(id) {
      return document.getElementById(id);
    }
  }
  // Сохраняем / отменяем запись
  $("#confirm_meet_record").click(function () {
    let trainee_key = window.adminId;
    let comment_trainee = $(".meet_comment_trainee_time");
    let checked_time = 1;
    let id = $("#edit_meet_blank_record_confirm").attr("data-id");
    if ($("#edit_meet_blank_record_confirm").attr("data-busy") === "1" && $("#edit_meet_blank_record_confirm").attr("data-my") === "1") {
      checked_time = 0;
    } else if ($("#edit_meet_blank_record_confirm").attr("data-busy") === "1") {
      showError("Это время занято.");
      return;
    }

    fetch("ajax/ftt_fellowship_ajax.php?type=set_communication_record&id=" + id
    + "&trainee=" + trainee_key + "&checked=" + checked_time + "&time_from=" + $("#edit_meet_blank_record_confirm").attr("data-from")
    + "&time_to=" + $("#edit_meet_blank_record_confirm").attr("data-to") + "&date=" + $("#edit_meet_blank_record_confirm").attr("data-date")
    + "&comment=" + $(".meet_comment_trainee_time").val())
    .then(response => response.json())
    .then(commits => {
      let el = $(".meet_checked[data-id='" + id + "']");
      if (checked_time) {
        if (commits.result !== true) {
          let check_error = commits.result.split("_");
          if (check_error[0] === "error" && check_error[1] === "busy") {
            showError("К сожалению это время уже занято.");
          } else if (check_error[0] === "error" && check_error[1] === "intersection") {
            showError("На это время и дату уже назначена встреча с " + serving_ones_list[String(check_error[2])] + ". Запись не сохранена.");
          }
          $(this).prop("checked", false);
        } else {
          showHint("Запись на общение сохранена.");
          el.attr("data-busy", 1);
          el.attr("data-my", 1);
          el.attr("data-comment", $(".meet_comment_trainee_time").val());
          el.text("Вы записаны");
        }
      } else {
        showHint("Запись на общение отменена.");
        el.attr("data-busy", "");
        el.attr("data-my", "");
        el.attr("data-comment", "");
        el.text("Записаться");
      }
    });
  });
  // сохраняем ИЗМЕНЕНИЯ в комментарий
  $(".meet_comment_trainee_time").change(function () {
    if ($("#edit_meet_blank_record_confirm").attr("data-my") === "1") {
      meet_comment_change($(this).val());
      $(".meet_checked[data-id='" + $("#edit_meet_blank_record_confirm").attr("data-id") + "']").attr("data-comment", $(".meet_comment_trainee_time").val());
    }
  });
  // сохраняем комментарий
  function meet_comment_change(comm, blank) {
    let id;
    if (blank) {
      id = $("#mdl_edit_fellowship_staff").attr("data-id");
      if (comm === $("#mdl_edit_fellowship_staff").attr("data-comment")) {
        return;
      }
    } else {
      id = $("#edit_meet_blank_record_confirm").attr("data-id");
      if (comm === $("#edit_meet_blank_record_confirm").attr("data-comment")) {
        return;
      }
    }
    fetch("ajax/ftt_fellowship_ajax.php?type=set_communication_comment_trainee&comment=" + comm + "&id=" + id)
    .then(response => response.text())
    .then(commits => {

    });
  }
  /*** FELLOWSHIP TAB STOP ***/
});
