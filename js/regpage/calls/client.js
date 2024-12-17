/* ==== Calls START ==== */
$(document).ready(function(){
  /* ==== DOCUMENT READY START ==== */
  // КУККИ
  // setCookie("calls-flt_author", "");

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

  // открыть новый бланк добавить новый звонок
  $("#addCalls").click(function () {
    $("#mdl_fld_status option").show();
    $("#mdl_fld_operator").attr("disabled", false);
    module_blank_clear($("#modal_call_edit_add"));
    $("#mdl_fld_country").val("RU");
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
    if ($(this).val() !== "_none_") {
      $("#mdl_btn_new_order").show();
    } else {
      $("#mdl_btn_new_order").hide();
    }
  });
  // добавить новый звонок
  $("#mdl_btn_save_call").click(function () {
    // проверки
    if (!$("#mdl_fld_phone").val() || !$("#mdl_fld_fio").val()) {
      showError("Заполните обязательные поля.");
      if (!$("#mdl_fld_phone").val()) {
        $("#mdl_fld_phone").css("border-color", "red");
      } else {
        $("#mdl_fld_phone").css("border-color", "#ced4da");
      }
      if (!$("#mdl_fld_fio").val()) {
        $("#mdl_fld_fio").css("border-color", "red");
      } else {
        $("#mdl_fld_fio").css("border-color", "#ced4da");
      }
      return;
    }
    let data = {};
    if ($("#modal_call_edit_add").attr("data-id")) {
      data["id"] = $("#modal_call_edit_add").attr("data-id");
    } else {
      data["author_key"] = window.adminId;
    }
    $("#modal_call_edit_add input, #modal_call_edit_add select, #modal_call_edit_add textarea").each(function () {
      if ($(this).attr("data-field") && $(this).is(":visible")) {
        let text;
        if ($(this).val() === "_none_" || !$(this).val() || $(this).val() === "_all_") {
          if ($(this).attr("data-field") === "male") {
            text = "NULL";
          } else if ($(this).attr("data-field") === "status") {
            text = "Входящая";
          } else {
            text = "";
          }
        } else {
          text = $(this).val();
          text = text.replaceAll("'", "&#39;");
        }
        data[$(this).attr("data-field")] = text.replaceAll("`", "&#39;");
      }
    });
    // готоввим данные
    let form_data = new FormData();
    form_data.set("data", JSON.stringify(data));
    fetch("api_reg.php?section=calls&type=save_call", {
      method: 'POST',
      body: form_data
    })
    .then(response => response.text()) // json
    .then(commits => {
      // console.log(commits.result);
      $("#modal_call_edit_add").modal("hide");
      showHint("Запись сохранена.");
      setTimeout(function () {
        location.reload();
      }, 700);
    });
  });
  // копирование в буфер
  // сделать модуль принимающий строку для копирования,
  // создание временного элемента (в виде точки рядом с вызывающим элементом) с последующим его удалением
  // помещением строки в буфер
  $('#btn_copy_to_buffer').click(function() {
    $("#mdl_fld_copy_text").val($("#mdl_fld_region").val() + "\r\n" + $("#mdl_fld_area").val() + "\r\n"
    + $("#mdl_fld_locality").val() + "\r\n" + $("#mdl_fld_address").val());
    let copyText = document.getElementById("mdl_fld_copy_text");
    $("#mdl_fld_copy_text").show();
    copyText.select();
    document.execCommand('copy');
    $("#mdl_fld_copy_text").hide();
    $("#mdl_fld_copy_text").val("");
  });

  // удаляем карточку
  $("#mdl_btn_dlt_call").click(function () {
    $("#mld_confirm_dlt p").text("Удалить карточку звонка " + $("#modal_call_edit_add input[data-field='name']").val() + "?");
    $("#mld_confirm_dlt").modal("show");
  });

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
