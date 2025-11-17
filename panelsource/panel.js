$(document).ready(function(){
  var sessionsGlobal = [];
  var tormozzz = [];
/*
  $('#copySessions').click(function() {
    if (window.confirm("Do you really want to copy sessions?")) {
      $.when(getSessionsAdmins()).then(eachSession());
    }
  });

  function copySessionsAdmins(member,session) {
    $.post('panelsource/panelAjax.php?copy_sessions', {member: member, session: session})
    .done(function(data){
    });
  }

  function eachSession() {
    $(sessionsGlobal).each(function(i) {
      copySessionsAdmins(sessionsGlobal[i].member_key, sessionsGlobal[i].session);
      if (window.confirm("Do you really want to copy session?")) {
        console.log('Ready', sessionsGlobal[i].member_key,' ', sessionsGlobal[i].session);
      } else {
        console.log('Failed', sessionsGlobal[i].member_key,' ', sessionsGlobal[i].session);
      }
    });
  }

  function getSessionsAdmins() {
    $.post('panelsource/panelAjax.php?get_sessions', {})
    .done(function(data){
      sessionsGlobal = data.sessions;
    });
  }
  */
  $('#onPracticesForStudentsPVOM').click(function() {
    if (window.confirm("Включить практики всем обучающимся?")) {
      $.get('panelsource/panelAjax.php?set_practices_pvom', {})
      .done(function(data){
        $('#noticeForAddPractices').text(data.result);
      })
    }
  });

  function getSatusStatistics(from, to) {
    $.get('panelsource/panelAjax.php?get_statistics_status', {from: from, to: to})
    .done(function(data){
      var count = [], unique_id_contacts_arr = [], unique_id_contacts = 0, statistics_crush = false;
      count['Всего'] = 0;
      count['Недозвон'] = 0;
      count['Ошибка'] = 0;
      count['Отказ'] = 0;
      count['Заказ'] = 0;
      count['Продолжение'] = 0;
      count['Завершение'] = 0;
      count['Вработе'] = 0;
      count['Безстатуса'] = 0;

      var array = data.result;
      for (var i = 0; i < array.length; i++) {
          count['Всего']++;
        if (array[i][1] === '1') {
          count['Недозвон']++;
        } else if (array[i][1] === '2') {
          count['Ошибка']++;
        } else if (array[i][1] === '3') {
          count['Отказ']++;
        } else if (array[i][1] === '4') {
          count['Заказ']++;
        } else if (array[i][1] === '5') {
          count['Продолжение']++;
        } else if (array[i][1] === '6') {
          count['Завершение']++;
        } else if (array[i][1] === '7') {
          count['Вработе']++;
        } else {
          count['Безстатуса']++;
        }

        if (unique_id_contacts_arr.indexOf(array[i][2]) === -1 && array[i][2]) {
          unique_id_contacts_arr.push(array[i][2]);
          unique_id_contacts++;
        }
        if (!array[i][2]) {
          statistics_crush = true;
        }
      }
      if (statistics_crush) {
        console.log(unique_id_contacts);
        unique_id_contacts = 'Не возможно посчитать.';
        //console.log('Ошибка 1.');
      }

      var html = '<tr><td>Обработано контактов</td><td><strong>'+unique_id_contacts+'</strong></td></tr><tr><td>Всего контактов</td><td>'+count['Всего']+'</td></tr><tr><td>Контактов в работе</td><td>'+count['Вработе']+'</td></tr><tr><td>Недозвон</td><td>'+count['Недозвон']+'</td></tr><tr><td>Ошибка</td><td>'+count['Ошибка']+'</td></tr><tr><td>Отказ</td><td>'+count['Отказ']+'</td></tr><tr><td>Заказ</td><td>'+count['Заказ']+'</td></tr><tr><td>Продолжение</td><td>'+count['Продолжение']+'</td></tr><tr><td>Завершение</td><td>'+count['Завершение']+'</td></tr><tr><td>Без статуса</td><td>'+count['Безстатуса']+'</td></tr>';
      $('#listStatStatistics').html(html);
    });
  }
  $('#statusesStatisticsBtn').click(function (e) {
    if (!$('#statusesStatisticsSelect').val()) {
      e.stopPropagation();
      $('#InfoStatisticStatusesContainer').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button> <strong>Ошибка!</strong> Выберите месяц из списка.</div>');
    } else {
      var x = $('#statusesStatisticsSelect').val();
      x = x.split('_')
      getSatusStatistics(x[0], x[1]);
    }
  });

  //Print element
    $('#printStatusesStatistics').click(function () {
      function printElem(elem){
        popup($(elem).html());
      }

      function popup(data){
        var mywindow = window.open('', 'Статистика', 'height=400,width=600');
        mywindow.document.write('<html><head><title>'+$('#statusesStatisticsSelect option:selected').text()+'</title>');
        mywindow.document.write('</head><body > <style>th {border-bottom: 1px solid black; text-align: left; border-collapse: collapse;} table, td {border-bottom: 1px solid black; text-align: left; border-collapse: collapse;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
      }
      printElem('#tableStatStatisticsPrint');
    });
  //Print element
  $('#dltSameStrOfLog').click(function () {
    fetch('panelsource/panelAjax.php?dlt_same_logstr')
  });

  $('#dlt99LogStr').click(function () {
    fetch('panelsource/panelAjax.php?dlt_99_logstr');
  });

  $('#dltDvlpLogStr').click(function () {
    fetch('panelsource/panelAjax.php?dlt_dvlp_logstr');
  });

  // Заявления ПВОМ
  $(".str_of_list").click(function () {
    let query = "application.php?member_key=" + $(this).attr("data-member_key");
    window.location = query;
  });

  $("#showModalUniversalConfirm, #showModalUniversalConfirmApplication").click(function (e) {
    if (e.target.id === "showModalUniversalConfirm") {
      $("#modalUniversalConfirm").attr("data-type", "1");
      $("#modalUniversalTitle").text("УДАЛЕНИЕ");
      $("#modalUniversalText").text("Удалить данные семестра?");
    } else if (e.target.id === "showModalUniversalConfirmApplication") {
      $("#modalUniversalConfirm").attr("data-type", "2");
      $("#modalUniversalTitle").text("УДАЛЕНИЕ");
      $("#modalUniversalText").text("Удалить заявления? Вопросы не будут удалены.");
    } else {
      $("#modalUniversalConfirm").attr("data-type", "0");
      $("#modalUniversalTitle").text("?");
      $("#modalUniversalText").text("?");
    }

  });

  // ******* П В О М  *********  //
  $("#modalUniversalOK").click(function () {
    if ($("#modalUniversalConfirm").attr("data-type") === "1") {
      fetch('panelsource/panelAjax.php?type=reset_semester')
      .then(response => response.text())
      .then(result => {
        setCookie("panel_tab_active", 'ftt', 1);
        if (result == 1) {
          $('#noticePlace .alert-success').addClass("show");
          setTimeout(function () {
            //location.reload();
          }, 1000);
        } else {
          $('#noticePlace .alert-danger').addClass("show");
          setTimeout(function () {
            //location.reload();
          }, 1000);
        }
      });
    } else if ($("#modalUniversalConfirm").attr("data-type") === "2") {
      fetch('panelsource/panelAjax.php?type=reset_applications')
      .then(response => response.text())
      .then(result => {
        setCookie("panel_tab_active", 'ftt', 1);
        if (result == 1) {
          $('#noticePlace .alert-success').addClass("show");
          setTimeout(function () {
            location.reload();
          }, 1000);
        } else {
          $('#noticePlace .alert-danger').addClass("show");
          setTimeout(function () {
            location.reload();
          }, 1000);
        }
      });
    }
  });

  $('#noticePlace .alert .close').click(function () {
    $(this).parent().removeClass("show");
  });

  if (getCookie('panel_tab_active') === "ftt") {
    setCookie('panel_tab_active') === "";
  }

  // auth link
  $(".auth_link").click(function () {
    fetch("panelsource/panelAjax.php?type=auth_link&member_key=" + $(this).attr("data-member_key"))
    .then(response => response.text())
    .then(result => {
      if (result === "OK") {
        location.reload();
      } else {
        showError("Неудача.");
      }
    });
  });

  // ШАБЛОНЫ ДЛЯ РАЗДЕЛА ОБЩЕНИЕ
  // удалить все шаблоны
  $("#dlt_all_fellowship_tmpl").click(function () {
    if (confirm("Удалить все шаблоны?")) {
      fetch("panelsource/content/ftt/fellowship_cntrl.php?type=dlt_all")
      .then(response => response.text())
      .then(result => {
        if (result) {
          //location.reload();
          $("#fellowship_tmpl_list").html("");
          showHint("Успешно.");
        } else {
          showError("Неудача.");
        }
      });
    }
  });

  // удалить шаблон
  $(".dlt_fellowship_tmpl").click(function () {
    let parent = $(this).parent();
    data_str.get(parent);
    if (confirm("Удалить шаблон" + " " + data_str.name + " " + data_str.day + " " + data_str.time + " " + data_str.duration + "?")) {
      fetch("panelsource/content/ftt/fellowship_cntrl.php?type=dlt&member_key=" + data_str.key + "&day=" + data_str.day
        + "&time=" + data_str.time + "&duration=" + data_str.duration)
      .then(response => response.text())
      .then(result => {
        if (result) {
          parent.remove();
          showHint("Успешно.");
          location.reload();
        } else {
          showError("Неудача.");
        }
      });
    }
  });

  // добавить шаблон
  $("#add_fellowship_tmpl").click(function () {
    $(".modal-title").text("Добавить шаблон");
    $("#add_fellowship_tmpl_modal").attr("data-add", "1");
    fellowship_blank_fillup(data_str.get());
  });
  // изменить шаблон
  $(".set_fellowship_tmpl").click(function () {
    $(".modal-title").text("Изменить шаблон");
    $("#add_fellowship_tmpl_modal").attr("data-add", "");
    fellowship_blank_fillup(data_str.get($(this).parent()));
  });

  // добавить / изменить шаблон запрос
  $("#set_fellowship_tmpl_modal").click(function (e) {
    data_str.get("save");
    if (!data_str.key || data_str.key === "_none_" || !data_str.day || data_str.day === "_none_" || !data_str.time || !data_str.duration) {
      e.preventDefault();
      e.stopPropagation();
      showError("Заполните все поля в форме.");
      return;
    }

    let type = "set";
    if ($("#add_fellowship_tmpl_modal").attr("data-add") === "1") {
      type = "add";
    }
    fetch("panelsource/content/ftt/fellowship_cntrl.php?type=" + type + "&member_key=" + data_str.key + "&day=" + data_str.day
      + "&time=" + data_str.time + "&duration=" + data_str.duration
      + "&cond_member_key=" + data_str.old_key + "&cond_day=" + data_str.old_day
      + "&cond_time=" + data_str.old_time + "&cond_duration=" + data_str.old_duration + "&comment=" + data_str.comment)
    .then(response => response.text())
    .then(result => {
      if (result) {
        showHint("Успешно.");
        setCookie("panel_tab_active", "ftt");
        setTimeout(function () {
          //location.reload();
        }, 300);
      } else {
        showError("Неудача.");
      }
    });
  });

  $("#add_fellowship_two_weeks").click(function () {
    if (confirm("Добавить записи на ближайшие две недели?")) {
      fetch("panelsource/necessary_scripts/add_fellowship.php?key=1cor15:45")
      .then(response => response.text())
      .then(result => {
        if (result) {
          showHint("Успешно.");
          $("#answer_add_fellowship").html(result);
        } else {
          showError("Неудача.");
        }
      });
    }
  });

  // объект с данными переданной строки или пустышка
  data_str = {
      get: function(elem) {
        if (elem === "save") {
          this.old_key = $("#add_fellowship_tmpl_modal").attr("data-member_key") || "";
          this.old_day = $("#add_fellowship_tmpl_modal").attr("data-day") || "";
          this.old_time = $("#add_fellowship_tmpl_modal").attr("data-time") || "";
          this.old_duration = $("#add_fellowship_tmpl_modal").attr("data-duration") || "";
          this.key = $("#fellowship_tmpl_serving_one_list_modal").val() || "";
          this.day = $("#fellowship_tmpl_days_modal").val() || "";
          this.time = $("#fellowship_tmpl_time_modal").val() || "";
          this.duration = $("#fellowship_tmpl_duration_modal").val() || "";
          this.comment = $("#fellowship_tmpl_comment_modal").val().trim() || "";
        } else if (elem) {
          this.key = elem.attr("data-member_key").trim() || "_none_";
          this.name = elem.find(".fellowship_tmpl_name").text().trim() || "";
          this.day = elem.find(".fellowship_tmpl_day").text().trim() || "_none_";
          this.time = elem.find(".fellowship_tmpl_time").text().trim() || "";
          this.duration = elem.find(".fellowship_tmpl_duration").text().trim() || "";
          this.comment = elem.find(".fellowship_tmpl_comment").text().trim() || "";
        } else {
          this.name = "";
          this.key = "_none_";
          this.day = "_none_";
          this.time = "";
          this.duration = "";
          this.comment = "";
        }
        return this;
      },
      name: "",
      key: "",
      day: "",
      time: "",
      duration: "",
      comment: ""
  }

  // заполнение бланка добавление/изменения общения данными переданной строки
  function fellowship_blank_fillup(data) {
    // заполняем данные в шапку
    $("#add_fellowship_tmpl_modal").attr("data-member_key", data.key);
    $("#add_fellowship_tmpl_modal").attr("data-day", data.day);
    $("#add_fellowship_tmpl_modal").attr("data-time", data.time);
    $("#add_fellowship_tmpl_modal").attr("data-duration", data.duration);
    $("#add_fellowship_tmpl_modal").attr("data-comment", data.comment);
    // заполняем поля данными
    $("#fellowship_tmpl_serving_one_list_modal").val(data.key);
    $("#fellowship_tmpl_days_modal").val(data.day);
    $("#fellowship_tmpl_time_modal").val(data.time);
    $("#fellowship_tmpl_duration_modal").val(data.duration);
    $("#fellowship_tmpl_comment_modal").val(data.comment)
  }

// ready page stop here
});
