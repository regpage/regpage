/* ==== ANNOUNCEMENT START ==== */
$(document).ready(function(){
  /* ==== DOCUMENT READY START ==== */
  // BLANK
  // сбрасываем данные в бланке
  function blank_reset() {
    // fields
    $("#announcement_modal_edit input[type='checkbox']").prop("checked", false);
    $("#announcement_modal_list input[type='checkbox']").prop("checked", false);
    $("#announcement_modal_edit input[type='text']").val("");
    $("#announcement_date_publication").val("");
    $("#announcement_date_archivation").val("");
    $("#announcement_modal_edit select").val("01");
    $("#announcement_time_publication").val("00:00");

    // edit editor
    nicEditors.findEditor("announcement_text_editor").setContent("<span class='text-secondary'>Текст объявления...</span>");
    // attr data-
    $("#announcement_modal_edit").attr("data-id","");
    $("#announcement_modal_edit").attr("data-recipients","");
    $("#announcement_modal_edit").attr("data-publication","");
    $("#announcement_modal_edit").attr("data-author","");
    // other
    $("#announcement_list_editor").hide();
    // Кнопки
    $("#announcement_btn_save").show();
    $("#announcement_blank_delete").css("margin-right", "145px");
    // Цвета обрамления полей с ошибкой
    $("#announcement_date_publication").css("border-color", "#ced4da");
    $("#announcement_text_header").css("border-color", "#ced4da");
    $(".nicEdit-main").parent().css("border-color", "#ced4da");
  }

  // Заполняем бланк
  function blank_fill(data) {
    // готовим данные
    // Скрываем кнопку "Сохранить" у опубликованных объявлений
    if (data["publication"] === "1") {
      $("#announcement_btn_save").hide();
      $("#announcement_blank_delete").css("margin-right", "240px");
    } else if ($("#announcement_blank_delete").css("margin-right") !== "145px") {
      $("#announcement_btn_save").show();
      $("#announcement_blank_delete").css("margin-right", "145px");
    }

    // Заполняем список получателей в опции "По списку"
    let list_arr;
    if (data["list"]) {
      list_arr = data["list"].split(",");
      $("#announcement_modal_list input[type='checkbox']").each(function () {
        if (list_arr.includes($(this).val())) {
          $(this).prop("checked", true);
        }
      });
    }

    // Отображаем ссылку на список если чекбокс "По списку" включен
    if (data["by_list"] === "1") {
      $("#announcement_list_editor").show();
      data["by_list"] = "checked";
    } else {
      $("#announcement_list_editor").hide();
      data["by_list"] = "";
    }

    data["to_14"] === "1" ? data["to_14"] = "checked" : data["to_14"] = "";
    data["to_56"] === "1" ? data["to_56"] = "checked" : data["to_56"] = "";
    data["to_coordinators"] === "1" ? data["to_coordinators"] = "checked" : data["to_coordinators"] = "";
    data["to_servingones"] === "1" ? data["to_servingones"] = "checked" : data["to_servingones"] = "";
    // Заполняем поля
    $("#announcement_modal_edit").attr("data-id", data["id"]);
    $("#announcement_modal_edit").attr("data-publication", data["publication"]);
    $("#announcement_modal_edit").attr("data-author", data["member_key"]);
    $("#announcement_to_14").prop("checked", data["to_14"]);
    $("#announcement_to_56").prop("checked", data["to_56"]);
    $("#announcement_to_coordinators").prop("checked", data["to_coordinators"]);
    $("#announcement_to_servingones").prop("checked", data["to_servingones"]);
    $("#announcement_by_list").prop("checked", data["by_list"]);
    $("#announcement_modal_edit").attr("data-recipients", data["list"]);
    $("#announcement_modal_time_zone").val(data["time_zone"]);
    $("#announcement_date_publication").val(data["date"]);
    $("#announcement_time_publication").val(data["time"]);
    $("#announcement_date_archivation").val(data["archive_date"]);
    $("#announcement_text_header").val(data["header"]);
    nicEditors.findEditor("announcement_text_editor").setContent(data["content"]);
    $("#announcement_staff_comment").val(data["comment"]);
  }

  function get_recipients() {
    recipients_group;

    /*let arr = [];
    if ($("#announcement_by_list").prop("checked")) {
      return arr;
    }*/
    return arr;
  }

  function get_data_fields(to_public) {
    // получатели для не опубликованных объявлений формируются динамически, или все помещаются в лист?
    let recipients = "", publication = $("#announcement_modal_edit").attr("data-publication"), groups = "";
    if (to_public) {
      publication = to_public;
      //recipients = get_recipients();
      recipients = $("#announcement_modal_edit").attr("data-recipients");
      $("#announcement_to_14").prop("checked") ? groups += recipients_group['trainee_14'][$("#announcement_modal_time_zone").val()] : "";
      $("#announcement_to_56").prop("checked") ? groups += recipients_group['trainee_56'][$("#announcement_modal_time_zone").val()] : "";
      $("#announcement_to_coordinators").prop("checked") ? groups += recipients_group['coordinators'][$("#announcement_modal_time_zone").val()] : "";
      $("#announcement_to_servingones").prop("checked") ? groups += recipients_group["staff"][$("#announcement_modal_time_zone").val()] : "";
    } else {
      recipients = $("#announcement_modal_edit").attr("data-recipients");
    }

    let blank_data = new FormData();
    let data_field = {
      id: $("#announcement_modal_edit").attr("data-id"),
      publication: publication,
      author: $("#announcement_modal_edit").attr("data-author"),
      to_14: $("#announcement_to_14").prop("checked"),
      to_56: $("#announcement_to_56").prop("checked"),
      to_coordinators: $("#announcement_to_coordinators").prop("checked"),
      to_servingones: $("#announcement_to_servingones").prop("checked"),
      by_list: $("#announcement_by_list").prop("checked"),
      recipients: recipients,
      groups: groups,
      time_zone: $("#announcement_modal_time_zone").val(),
      publication_date: $("#announcement_date_publication").val(),
      publication_time: $("#announcement_time_publication").val(),
      archivation_date: $("#announcement_date_archivation").val(),
      header: $("#announcement_text_header").val(),
      content: nicEditors.findEditor("announcement_text_editor").getContent(),
      comment: $("#announcement_staff_comment").val()
    };
    blank_data.set("data", JSON.stringify(data_field));
    return blank_data;
  }

  // Проверка полей перед публикацией
  function blank_validation() {
    let error = "Выберите получателей. ";
    $("#announcement_modal_edit input[type='checkbox']:checked").each(function () {
      if ($(this).attr("id") ==="announcement_by_list" && error) {
        $("#announcement_modal_list input[type='checkbox']:checked").each(function () {
          error = "";
        });
      } else {
        error = "";
      }
    });

    if (!$("#announcement_date_publication").val()) {
      error += "Выберите дату публикации. ";
      $("#announcement_date_publication").css("border-color", "red");
    } else {
      $("#announcement_date_publication").css("border-color", "#ced4da");
    }

    if (!$("#announcement_text_header").val()) {
      error += "Введите заголовок. ";
      $("#announcement_text_header").css("border-color", "red");
    } else {
      $("#announcement_text_header").css("border-color", "#ced4da");
    }

    if (!nicEditors.findEditor("announcement_text_editor").getContent() || nicEditors.findEditor("announcement_text_editor").getContent() === '<span class="text-secondary">Текст объявления...</span>') {
      error += "Введите Текст объявления. ";
      $(".nicEdit-main").parent().css("border-color", "red");
    } else {
      $(".nicEdit-main").parent().css("border-color", "#ced4da");
    }
    return error;
  }
  function blank_save(to_public) {
    let validation = blank_validation();
    if (to_public && validation) {
      showError(validation);
      return;
    }
    fetch("ajax/ftt_announcement_ajax.php?type=save_announcement", {
      method: 'POST',
      body: get_data_fields(to_public)
    })
    .then(response => response.text())
    .then(commits => {
      $("#announcement_modal_edit").modal("hide");
      //console.log(commits.result);
      location.reload();
    });
  }

  // Фильтр списка
  function filter_list() {
    let is_archive;
    $("#list_announcement .list_string").each(function () {
      is_archive = false;
      if ($(this).attr("data-archive_date") === gl_date_now) {
        is_archive = true;
      } else if (compare_date($(this).attr("data-archive_date")) && $(this).attr("data-archive_date")) {
        is_archive = true;
      }
      if (($(this).attr("data-author") === $("#flt_service_ones").val() || $("#flt_service_ones").val() === "_all_")
      && ($(this).attr("data-time_zone") === $("#flt_time_zone").val() || $("#flt_time_zone").val() === "01")
      && (($(this).attr("data-publication") === $("#flt_public").val() && !is_archive) || $("#flt_public").val() === "_all_" || $("#flt_public").val() === "2")
      && ((is_archive && $("#flt_public").val() === "2") || $("#flt_public").val() === "_all_" || $("#flt_public").val() !== "2")) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  }

  // Фильтры списка
  $("#main_container .ftt_buttons_bar select").change(function () {
    filter_list();
  });
  // add/remove recipient
  $("#announcement_modal_list input[type='checkbox']").change(function () {
    let recipients = $("#announcement_modal_edit").attr("data-recipients");
    if ($("#announcement_modal_edit").attr("data-recipients")) {
      recipients = recipients.split(",");
    }
    if ($(this).prop("checked")) {
      if ($("#announcement_modal_edit").attr("data-recipients")) {
        if (!recipients.includes($(this).val())) {
          $("#announcement_modal_edit").attr("data-recipients", $("#announcement_modal_edit").attr("data-recipients")
          + "," + $(this).val())
        }
      } else {
        $("#announcement_modal_edit").attr("data-recipients", $(this).val())
      }
    } else if ($("#announcement_modal_edit").attr("data-recipients")) {
      let html = "";
      if (recipients.includes($(this).val())) {
        for (var i = 0; i < recipients.length; i++) {
          if (recipients[i] !== $(this).val()) {
            if (html) {
              html = html + "," + recipients[i];
            } else {
              html += recipients[i];
            }
          }
        }
        $("#announcement_modal_edit").attr("data-recipients", html)
      }
    }
  });

  $("#announcement_to_archive").click(function () {
    $("#announcement_date_archivation").val(date_now_gl);
  });

  $("#announcement_btn_save").click(function () {
    blank_save();
  });

  $("#announcement_blank_publication").click(function () {
    blank_save(1);
  });

  $("#announcement_add").click(function () {
    blank_reset();
    $("#announcement_modal_edit").attr("data-author", admin_id_gl);
    $("#announcement_date_publication").val(date_now_gl);
  });

  $(".list_string").click(function () {
    blank_reset();
    fetch("ajax/ftt_announcement_ajax.php?type=get_announcement&id=" + $(this).attr("data-id"))
    .then(response => response.json())
    .then(commits => {
      $("#announcement_modal_edit").modal("show");
      blank_fill(commits.result);
    });
  });

  // BLANK FIELDS BEHAVIORS
  // предусмотреть вставку
  $("#announcement_time_publication").keyup(function (e) {
    let time = $(this).val();
    if (e.keyCode !== 8 && e.keyCode !== 46 && e.keyCode !== 37 && e.keyCode !== 39 && e.keyCode !== 36 && e.keyCode !== 35) {
      if (time.length === 3 && time[2] !== ":") {
        /*if (time[3] === ":") {
          time[3] = "";
        } else if (time[1] === ":") {
          time[1] = "";
        } else if (time[0] === ":") {
          time[0] = "";
        }*/
        $(this).val(String(time[0])+String(time[1])+':'+String(time[2]));
      } else if (time.length > 3 && time[2] !== ":" && time[1] !== ":") {
      /*  if (time[3] === ":") {
          time[3] = "";
        } else if (time[1] === ":") {
          time[1] = "";
        } else if (time[0] === ":") {
          time[0] = "";
        }*/
        $(this).val(String(time[0])+String(time[1])+':'+String(time[2]) + String(time[3]));
      }
    }
  });

  $("#announcement_time_publication").click(function () {
    if ($(this).val() === "00:00") {
      $(this).val("");
    }
  });

  $("#announcement_time_publication").focusout(function () {
    if ($(this).val() === "") {
      $(this).val("00:00");
    }
  });

setTimeout(function () {
  // text editor place holder
  $(".nicEdit-main").click(function () {
    if (nicEditors.findEditor("announcement_text_editor").getContent().trim() === '<span class="text-secondary">Текст объявления...</span>') {
      nicEditors.findEditor("announcement_text_editor").setContent("");
    }
  });
}, 1100);

  // BLANK EXTRA LIST
  // Список получателей объявления, опция "по списку"
  $("#announcement_by_list").change(function () {
    if ($(this).prop("checked")) {

      $("#announcement_modal_list").modal("show");
      $("#announcement_list_editor").show();
    } else {
      $("#announcement_list_editor").hide();
    }

  });

  // Правка списка получателей объявления, опция "настроить".
  $("#announcement_list_editor").click(function (e) {
    e.stopPropagation();
    e.preventDefault();
    $("#announcement_modal_list").modal("show");
  });

  // удаление объявления.
  $("#announcement_blank_delete").click(function (e) {
    // Удаление опубликованных объявлений
    if (confirm("Удалить объявление?")) {
      fetch("ajax/ftt_announcement_ajax.php?type=delete_announcement&id=" + $("#announcement_modal_edit").attr("data-id"));
      $("#announcement_modal_edit").modal("hide");
      blank_reset();
      location.reload();
    }
  });

  /* ==== DOCUMENT READY STOP ==== */
});
/* ==== ANNOUNCEMENT STOP ==== */
