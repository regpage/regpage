// сохраняем бланк пророчества
function save_blank(form_data, elem, reboot) {
  if (!Number(reboot)) {
    reboot = 300;
  }
  fetch("api_ftt.php?section=prophecy&type=set_line", {
    method: 'POST',
    body: form_data
  })
  .then(response => response.json()) // text
  .then(commits => {
    if (commits.result) {
      if (elem) {
        $(elem).modal("hide");
      }
      setTimeout(function () {
        location.reload();
      }, reboot);

    } else {
      showError("Сбой при сохранение.");
    }
  });
}

// получаем данные открываемого бланка
function get_data_for_blank(id, elem) {
  fetch("api_ftt.php?section=prophecy&type=get_line&id=" + id, {
  })
  .then(response => response.json()) // text
  .then(commits => {
    if (commits.result[0]["id"]) {
      fill_blank(commits.result[0], elem);
    } else {
      showError("Сбой при открытии.");
    }
  });
}

// удаление бланка
function dlt_prophecy_blank(id) {
  fetch("api_ftt.php?section=prophecy&type=dlt_line&id=" + id, {
  })
  .then(response => response.json()) // text
  .then(commits => {
    if (commits.result) {
      location.reload();
    } else {
      showError("Сбой при удалении.");
      setTimeout(function () {
        location.reload();
      }, 3000);
    }
  });
}

function dlt_related_announcement_text(id_blank, id_announcement) {
  fetch("api_ftt.php?section=prophecy&type=dlt_related_announcement&id_blank="
    + id_blank + "&id_announcement=" + id_announcement, {
  })
  .then(response => response.json()) // text
  .then(commits => {
    if (commits.result) {

    } else {
      showError("Сбой при удалении.");
    }
  });
}
