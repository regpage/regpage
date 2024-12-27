/* ==== Calls START ==== */
$(document).ready(function(){
  /* ==== DOCUMENT READY START ==== */
  // КУККИ
  // setCookie("calls-flt_author", "");
  // обработка поля телефон, инициализация

  // вставка и разбор фио и телефон
  $("#mdl_fld_fio").on("paste", function(e) {
    fio_tel_paste($(this), e);
  });
  // маска для ввода телефона
  $("#mdl_fld_phone").on("paste", function(e) {
    tel_mask_paste($(this), e);
  });

  $("#mdl_fld_phone").on("keydown", function(e) { // попробовать keydown keyup // change paste
    /***  Р Е Д А К Т И Р О В А Н И Е  ***/
    // ВВОД
    // РЕДАКТИРОВАНИЕ
    // Можно копировать данные и вставлять обратно выставляя курсор на прежнюю позицию
    if ((e.key === "x" && e.ctrlKey) || (e.key === "z" && e.ctrlKey) || (e.key === "v" && e.ctrlKey) || (e.ctrlKey || e.key === "ArrowDown" || e.key === "ArrowLeft" || e.key === "ArrowRight" || e.key === "ArrowUp" || e.key === "End" || e.key === "Home")) {
      return;
    }
    // тип действия
    if (e.key === 'Backspace' || e.key === 'Delete') { // удаление символов
      tel_mask_delete($(this), e, e.target.selectionStart);
    } else if ($(this).val().length === e.target.selectionStart) { // последовательный ввод курсор в конце
      tel_mask_input($(this), e, e.target.selectionStart);
    } else if ($(this).val().length !== e.target.selectionStart) { // редактирование
      tel_mask_edit($(this), e, e.target.selectionStart);
    }
  });
  // список применённых фильтров
  if ($("#flt_author").val() !== "_all_") {
    $("#flt_list").text("Включенные фильтры: автор — " + $("#flt_author option:selected").text());
  }

  if ($("#flt_gender").val() !== "_all_" && $("#flt_gender").val()) {
    if ($("#flt_list").text()) {
      $("#flt_list").text($("#flt_list").text() + ", " + $("#flt_gender option:selected").text());
    } else {
      $("#flt_list").text("Включенные фильтры: " + $("#flt_gender option:selected").text());
    }
  }

  if ($("#flt_operator").val() !== "_all_" && $("#flt_operator").val()) {
    if ($("#flt_list").text()) {
      $("#flt_list").text($("#flt_list").text() + ", оператор — " + $("#flt_operator option:selected").text());
    } else {
      $("#flt_list").text("Включенные фильтры: оператор — " + $("#flt_operator option:selected").text());
    }
  }

  if ($("#flt_search").val()) {
    if ($("#flt_list").text()) {
      $("#flt_list").text($("#flt_list").text() + ", " + $("#flt_search").val());
    } else {
      $("#flt_list").text("Включенные фильтры: " + $("#flt_search").val());
    }
  }

  if ($("#flt_list").text()) {
    $("#flt_list").html($("#flt_list").text() + " <i id='flt_list_cancel' class='cursor-pointer fa fa-close h6'></i>" );
  }
  // сброс списка фильтров
  $("#flt_list_cancel").click(function () {
    if (gl_calls_user_data["role"] === "1") {
      setCookie("calls-flt_author", window.adminId, 356);
    } else {
      setCookie("calls-flt_author", "_all_", 356);
    }
    if (gl_calls_user_data["male"] === "1") {
      setCookie("calls-flt_gender", "_all_", 356);
    }
    if ($("#flt_operator").val()) {
      setCookie("calls-flt_operator", "_all_", 356);
    }
    setCookie("calls-flt_search", "", 356);
    setTimeout(function () {
      location.reload();
    }, 30);
  });
  // сброс поля поиск
  // search
  $('#flt_search').click(function(event){
    event.stopPropagation();
    if ($(this).val().length > 0) {
      setTimeout(function () {
        if (!$('#flt_search').val()) {
          setCookie("calls-flt_search", '', 356);
          setTimeout(function () {
            location.reload();
          }, 30);
        }
      }, 30);
    }
  });
  // при выборе оператора в ручную статус не может быть Входящая
  $("#mdl_fld_operator").change(function () {
    if ($("#mdl_fld_operator").val() !== "_none_" && $("#mdl_fld_status").val() === "Входящая") {
      $("#mdl_fld_status").val("В работе");
    } else if ($("#mdl_fld_operator").val() === "_none_") {
      $("#mdl_fld_status").val("Входящая");
    }
  });
  // открыть новый бланк добавить новый звонок
  $("#addCalls").click(function () {
    let fields_id = ["#mdl_fld_fio", "#mdl_fld_phone", "#mdl_fld_country", "#mdl_fld_male", "#mdl_fld_region", "#mdl_fld_locality", "#mdl_fld_address", "#mdl_fld_operator","#mdl_fld_comment"];
    for (const element of fields_id) {
      $(element).css("border-color", "#ced4da");
    }
    $("#mdl_fld_status option").show();
    $("#mdl_fld_operator").attr("disabled", false);
    module_blank_clear($("#modal_call_edit_add"));
    $("#mdl_fld_country").val("RU");
    $("#call_time_zone").val("");
    $("#mdl_fld_status option[value='Входящая']").show();
    $("#mdl_fld_status").val("Входящая");
    $("#call_date").text(dateStrFromyyyymmddToddmmyyyy(date_now_gl()));
    /* ОТРЫВАЕТСЯ БЛАНК */
    $("#mdl_btn_dlt_call").hide();
    $("#mdl_btn_new_order").hide();
  });

  // открыть строку
  $(".call_str").click(function () {
    /* ОТРЫВАЕТСЯ БЛАНК */
    $("#mdl_fld_status option").show();
    $("#mdl_fld_operator").attr("disabled", false);
    $("#modal_call_edit_add").attr("data-done", "");
    module_blank_clear($("#modal_call_edit_add"));
    // открываем и показываем бланк
    get_and_show_blank_data($(this).attr("data-id"));
  });
  // взять в работу
  $(".get_to_work").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    // скрываем строку заявки взятой в работу в списке
    $(this).parent().parent().parent().hide();
    // настраиваем бланк
    $("#mdl_btn_dlt_call").hide();
    $("#mdl_btn_new_order").hide();
    $("#mdl_fld_operator").attr("disabled", true);
    // открываем и показываем бланк
    get_and_show_blank_data($(this).parent().parent().parent().attr("data-id"), "get_to_work");
  });
  // ручная смена статуса
  $("#mdl_fld_status").change(function () {
    if ($("#mdl_fld_status").val() !== "Входящая" && ($("#mdl_fld_operator").val() === "_none_" || !$("#mdl_fld_operator").val())) {
      $("#mdl_fld_operator").val(window.adminId);
    } else if ($("#mdl_fld_status").val() === "Входящая") {
      $("#mdl_fld_operator").val("_none_");
    }
    if ($("#modal_call_edit_add").attr("data-done") !== "1" && ($(this).val() === "_none_" || $(this).val() === "Заказ")) {
      $("#mdl_btn_new_order").hide();
      $("#mdl_btn_cancel").show();
      $("#mdl_btn_order_finished").hide();
    } else if ($("#modal_call_edit_add").attr("data-done") !== "1" && ($(this).val() !== "_none_" && $(this).val() !== "Заказ")) {
      if ($("#modal_call_edit_add").attr("data-id")) {
        $("#mdl_btn_new_order").show();
      }
      $("#mdl_btn_cancel").show();
      $("#mdl_btn_order_finished").hide();
    } else if ($("#modal_call_edit_add").attr("data-done") === "1") {
      $("#mdl_btn_new_order").hide();
      $("#mdl_btn_cancel").hide();
      $("#mdl_btn_order_finished").show();
    } else {
      if ($("#modal_call_edit_add").attr("data-id")) {
        $("#mdl_btn_new_order").show();
      }
      $("#mdl_btn_cancel").show();
      $("#mdl_btn_order_finished").hide();
    }
  });
  // добавить новый звонок (сохранить)
  $("#mdl_btn_save_call").click(function () {
    save_call(1);
  });
  // копирование в буфер
  // сделать модуль принимающий строку для копирования,
  // создание временного элемента (в виде точки рядом с вызывающим элементом) с последующим его удалением
  // помещением строки в буфер
  $('#btn_copy_to_buffer').click(function() {
    $("#mdl_fld_copy_text").val($("#mdl_fld_region").val() + " " + $("#mdl_fld_area").val() + " "
    + $("#mdl_fld_locality").val() + " " + $("#mdl_fld_address").val());
    let copyText = document.getElementById("mdl_fld_copy_text");
    $("#mdl_fld_copy_text").show();
    copyText.select();
    document.execCommand('copy');
    $("#mdl_fld_copy_text").hide();
    $("#mdl_fld_copy_text").val("");
  });

  $("#mdl_btn_new_order").click(function () {
    if (is_require_filds_empty(["#mdl_fld_fio", "#mdl_fld_phone", "#mdl_fld_country", "#mdl_fld_male", "#mdl_fld_region", "#mdl_fld_locality", "#mdl_fld_address", "#mdl_fld_operator"])) {
      return;
    }
    save_call();

    // продолжить здесь
    $("#mld_confirm_crm_send").modal("show");
  });
  // отправляем заказ в CRM (подтверждение отправки)
  $("#mdl_btn_new_order_send").click(function () {
    let form_data = new FormData();
    //{name: name, value3: country, value4: region, value5: area, value6: locality, value7: address, value8: index, value1: howMuch, phone: phone, email: email, value2: comment}

    form_data.set("name", $("#mdl_fld_fio").val());
    form_data.set("phone", $("#mdl_fld_phone").val());
    form_data.set("email", $("#mdl_fld_email").val());
    form_data.set("info", '');
    form_data.set("value1", "1");
    form_data.set("value2", $("#mdl_fld_comment").val() + "\r\n" + $("#mdl_fld_comment_extra").val());
    form_data.set("value3", $("#mdl_fld_country option:selected").text());
    form_data.set("value4", $("#mdl_fld_region").val());
    form_data.set("value5", $("#mdl_fld_area").val());
    form_data.set("value6", $("#mdl_fld_locality").val());
    form_data.set("value7", $("#mdl_fld_address").val());
    form_data.set("value8", $("#mdl_fld_index").val());
    form_data.set("male", $("#mdl_fld_male option:selected").text().trim());
    //form_data.set("note", $("#mdl_fld_comment_extra").val());

    fetch("api_reg.php?section=calls&type=crm_send&out=1&id=" + $("#modal_call_edit_add").attr("data-id"), {
      method: 'POST',
      body: form_data
    })
    .then(response => response.text()) // text
    .then(commits => {
      if (commits) {
        $(".calls_list .call_str[data-id='" + $("#modal_call_edit_add").attr("data-id") + "']").remove();
        $("#mld_confirm_crm_send").modal("hide");
        $("#modal_call_edit_add").modal("hide");
        showHint("Заказ отправлен в CRM.");
        /*setTimeout(function () {
          //location.reload();
        }, 700);*/
      }
    });
  });

  // удаляем карточку (открыть окно подтверждения)
  $("#mdl_btn_dlt_call").click(function () {
    $("#mld_confirm_dlt p").text("Удалить карточку звонка " + $("#modal_call_edit_add input[data-field='name']").val() + "?");
    $("#mld_confirm_dlt").modal("show");
  });

  // подтверждение удаление
  $("#mdl_btn_dlt_call_confirm").click(function () {
    fetch("api_reg.php?section=calls&type=dlt_call&id=" + $("#modal_call_edit_add").attr("data-id"))
    .then(response => response.text()) // text
    .then(commits => {
      if (commits) {
        $("#mld_confirm_dlt").modal("hide");
        showHint("Запись удалена.");
        setTimeout(function () {
          location.reload();
        }, 700);
      }
    });
  });

  // отменить заявку
  $("#mdl_btn_cancel").click(function () {
    if (is_require_filds_empty(["#mdl_fld_fio","#mdl_fld_phone","#mdl_fld_comment"])) {
      return;
    }
    save_call();
    setTimeout(function () {
      fetch("api_reg.php?section=calls&type=cancel_call&id=" + $("#modal_call_edit_add").attr("data-id"))
      .then(response => response.text()) // json
      .then(commits => {
        if (commits) {
          $("#modal_call_edit_add").modal("hide");
          showHint("Звонок отменён.");
          setTimeout(function () {
            location.reload();
          }, 700);
        }
      });
    }, 30);
  });

  // sorting
  $(".sort_col").click(function () {
    if ($(this).find("i").hasClass("fa-sort-desc")) {
      $(this).find("i").removeClass("fa-sort-desc");
      $(this).find("i").addClass("fa-sort-asc");
      setCookie('sorting-calls', $(this).attr("data-sort") + "-desc", 356);
    } else if ($(this).find("i").hasClass("fa-sort-asc")) {
      $(this).find("i").removeClass("fa-sort-asc");
      $(this).find("i").addClass("fa-sort-desc");
      setCookie('sorting-calls', $(this).attr("data-sort") + "-asc", 356);
    } else {
      $(".sort_col i").removeClass("fa");
      $(".sort_col i").removeClass("fa-sort-desc");
      $(".sort_col i").removeClass("fa-sort-asc");
      $(this).find("i").addClass("fa").addClass("fa-sort-desc");
      setCookie('sorting-calls', $(this).attr("data-sort") + "-asc", 356);
    }
    setTimeout(function () {
      location.reload();
    }, 30);
  });

  // Вкладки переключение
  $("#main_container_reg .nav-link").click(function () {
    if (!$(this).hasClass("active")) {
      setCookie('tab-calls', $(this).attr("data-tab_name"), 356);
      setTimeout(function () {
        location.reload();
      }, 30);
    }
  });

  // filters
  $("#flt_author, #flt_gender, #flt_operator").change(function () {
    setCookie("calls-" + $(this).attr("id"), $(this).val(), 356);
    setTimeout(function () {
      location.reload();
    }, 30);
  });
  // фильтры моб версия
  $("#flt_mbl_apply").click(function () {
    for (const elem of ["flt_author_mbl", "flt_gender_mbl", "flt_operator_mbl"]) {
      if ($("#" + elem).is(":visible")) {
        if (elem.includes("_mbl")) {
          let cookie_name = elem.split("_mbl")[0];
          setCookie("calls-" + cookie_name, $("#" + elem).val(), 356);
        }
      }
    }
    setTimeout(function () {
      location.reload();
    }, 30);
  });
  // search
  $("#flt_search").change(function () {
    if (!$(this).val() || $(this).val().length > 2) {
      set_сookie_encode("calls-" + $(this).attr("id"), $(this).val(), {expires: 365});
      setTimeout(function () {
        location.reload();
      }, 30);
    }
  });

  /* ==== DOCUMENT READY STOP ==== */
});
