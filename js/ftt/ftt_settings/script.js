$(document).ready(function(){
  // Заявления ПВОМ
  $("#showModalUniversalConfirm, #showModalUniversalConfirmApplication").click(function (e) {
    if (e.target.id === "showModalUniversalConfirm") {
      $("#modalUniversalConfirm").attr("data-type", "1");
      $("#modalUniversalTitle").text("УДАЛЕНИЕ");
      $("#modalUniversalText").text("Удалить данные семестра (включая прикреплённые файлы)?");
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

  // ПВОМ
  $("#modalUniversalOK").click(function () {
    if ($("#modalUniversalConfirm").attr("data-type") === "1") {
      fetch('ajax/ftt_settings_ajax.php?type=reset_semester')
      .then(response => response.text())
      .then(result => {
        if (result == 1) {
          showHint("Операция успешно завершена.");
          setTimeout(function () {
            location.reload();
          }, 1000);
        } else {
          showError("Что то пошло не так.");
          setTimeout(function () {
            location.reload();
          }, 1000);
        }
      });
    } else if ($("#modalUniversalConfirm").attr("data-type") === "2") {
      fetch('ajax/ftt_settings_ajax.php?type=reset_applications')
      .then(response => response.text())
      .then(result => {
        if (result == 1) {
          showHint("Операция успешно завершена.");
          setTimeout(function () {
            location.reload();
          }, 1000);
        } else {
          showError("Что то пошло не так.");
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
});
