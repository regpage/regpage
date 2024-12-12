/* ==== Calls START ==== */
$(document).ready(function(){
  /* ==== DOCUMENT READY START ==== */
  // добавить новый звонок
  $("#addCalls").click(function () {
    module_blank_clear($("#modal_call_edit_add"));
    $("#mdl_btn_dlt_call").hide();
  });
  // открыть строку
  $(".call_str").click(function () {
    module_blank_clear($("#modal_call_edit_add"));
    fetch("api_reg.php?section=calls&type=get_call&id=" + $(this).attr("data-id"))
    .then(response => response.json()) // text
    .then(commits => {
      //fullfill_blank(commits.result);
      let data_list = commits.result[0]
      $("#modal_call_edit_add").attr("data-id", data_list["id"]);
      for (const string in data_list) {
        if (data_list.hasOwnProperty(string)) {
          $("#modal_call_edit_add [data-field='"+string+"']").val(data_list[string]);
          data_list[string];
        }
      }

      $("#modal_call_edit_add").modal("show");

      if (!$("#mdl_btn_dlt_call").is(":visible")) {
        $("#mdl_btn_dlt_call").show();
      }
    });

  });

  // добавить новый звонок
  $("#mdl_btn_save_call").click(function () {
    let data = {};
    if ($("#modal_call_edit_add").attr("data-id")) {
      data["id"] = $("#modal_call_edit_add").attr("data-id");
    } else {
      data["author_key"] = window.adminId;
    }
    $("#modal_call_edit_add input, #modal_call_edit_add select, #modal_call_edit_add textarea").each(function () {
      if ($(this).attr("data-field") && $(this).is(":visible")) {
        let text;
        if ($(this).val() === "_none_" || !$(this).val()) {
          if ($(this).attr("data-field") === "male") {
            text = "NULL";
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
    $("#mdl_fld_copy_text").val($("#mdl_fld_locality").val() + "\r\n" + $("#mdl_fld_index").val() + "\r\n" + $("#mdl_fld_address").val());
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

  /* ==== DOCUMENT READY STOP ==== */
});
