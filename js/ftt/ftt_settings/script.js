$(document).ready(function(){
  // Переключение вкладок
  $("#main_container .nav-tabs .nav-link").click(function () {
    let href = $(this).attr("href");
    setCookie("ftt_settings_tab", href.slice(1));
    setTimeout(function () {
      location.reload();
    }, 30);
  });
  // Просмотр параметра в модальном окне
  $(".edit_param_btn").click(function () {
    $("#modalUniversalEditTitle").text($(this).attr("data-title"));
    $("#param_name_header").text($(this).attr("data-param"));
    $("#modalUniversalEdit textarea").val($(this).attr("data-param_value"));
    $("#modalUniversalEdit").attr("data-name", $(this).attr("data-param"));
    $("#modalUniversalEdit").modal("show");
  });

  // сохранение изменений параметров
  $("#modalUniversalEditOK").click(function () {
    let data = {
      name: $("#modalUniversalEdit").attr("data-name"),
      value: $("#modalUniversalEdit textarea").val()
    };

    fetch('ajax/ftt_settings_ajax.php?type=set_param', {
      method: 'POST',
      headers: {
      'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
    .then(response => response.text())
    .then(result => {
      $("#modalUniversalEdit").modal("hide");
      if (result == 1) {
        showHint("Операция успешно завершена.");
        setTimeout(function () {
          location.reload();
        }, 1500);
      } else {
        showError("Что то пошло не так.");
        setTimeout(function () {
          location.reload();
        }, 1500);
      }
    });
  });

  // очистить чтение библии.
  // Заявления ПВОМ
  $("#showModalUniversalConfirm, #showModalUniversalConfirmApplication, #showModalUniversalConfirmThree").click(function (e) {
    $("#modalUniversalTitle").text("Удаление");
    if (e.target.id === "showModalUniversalConfirm") {
      $("#modalUniversalConfirm").attr("data-type", "1");
      $("#modalUniversalText").text("Удалить данные семестра (включая прикреплённые файлы), кроме чтения Библии?");
    } else if (e.target.id === "showModalUniversalConfirmApplication") {
      $("#modalUniversalConfirm").attr("data-type", "2");
      $("#modalUniversalText").text("Удалить заявления? Вопросы не будут удалены.");
    } else if (e.target.id === "showModalUniversalConfirmThree") {
      $("#modalUniversalConfirm").attr("data-type", "3");
      $("#modalUniversalText").text("Удалить данные семестра ИСКЛЮЧАЯ ДОЛГИ, то есть остаются доп. помощь, пропущенные занятия, расписание, бланки посещаемости и чтение Библии. В разделах: доп.помощь, пропущенные занятия останутся только долги.");
    } else {
      $("#modalUniversalConfirm").attr("data-type", "0");
      $("#modalUniversalTitle").text("?");
      $("#modalUniversalText").text("?");
    }

  });

  // ПВОМ
  $("#modalUniversalOK").click(function () {
    if ($("#modalUniversalConfirm").attr("data-type") === "1" || $("#modalUniversalConfirm").attr("data-type") === "3") {
      let all = "";
      if ($("#modalUniversalConfirm").attr("data-type") === "1") {
        all = 1;
      }
      $("#spinner").show();
      fetch('ajax/ftt_settings_ajax.php?type=reset_semester&all=' + all)
      .then(response => response.text())
      .then(result => {
        if (result == 1) {
          showHint("Операция успешно завершена.");
          setTimeout(function () {
            //location.reload();
          }, 1500);
        } else {
          showError("Что то пошло не так.");
          setTimeout(function () {
            //location.reload();
          }, 1500);
        }
      });
    } else if ($("#modalUniversalConfirm").attr("data-type") === "2") {
      $("#spinner").show();
      fetch('ajax/ftt_settings_ajax.php?type=reset_applications')
      .then(response => response.text())
      .then(result => {
        if (result == 1) {
          showHint("Операция успешно завершена.");
          setTimeout(function () {
            //location.reload();
          }, 1500);
        } else {
          showError("Что то пошло не так.");
          setTimeout(function () {
            //location.reload();
          }, 1500);
        }
      });
    } else {
      partial_removal($("#modalUniversalConfirm").attr("data-type"));
    }
  });

  $('#noticePlace .alert .close').click(function () {
    $(this).parent().removeClass("show");
  });

  $(".partial_removal").click(function () {
    let text_files = "";
    let text_debt = " и оставить долги семестра";
    if ($(this).attr("data-type") === "partial_reset_skip") {
      text_files = ", включая прикреплённые файлы, ";
    } else if ($(this).attr("data-type") === "partial_reset_bible") {
      text_debt = " истории чтения Библии";
    }
    $("#modalUniversalConfirm").attr("data-type", $(this).attr("data-type"));
    $("#modalUniversalTitle").text("Удаление");
    $("#modalUniversalText").text("Частично удалить данные" + text_files + text_debt + "?");
  });

  function partial_removal(type) {
    if (!type || !isNaN(type)) {
      return;
    }
    $("#spinner").show();
    fetch("ajax/ftt_settings_ajax.php?type=" + type)
    .then(response => response.text())
    .then(result => {
      if (result == 1) {
        showHint("Операция успешно завершена.");
        setTimeout(function () {
          //location.reload();
        }, 1500);
      } else {
        showError("Что то пошло не так.");
        setTimeout(function () {
          //location.reload();
        }, 1500);
      }
    });
  }
});
