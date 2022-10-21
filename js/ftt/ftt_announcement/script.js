/* ==== ANNOUNCEMENT START ==== */
$(document).ready(function(){
  /* ==== DOCUMENT READY START ==== */
  // BLANK
  function blank_reset() {
    // fields
    $("#announcement_modal_edit input[type='checkbox']").prop("checked", false);
    $("#announcement_modal_list input[type='checkbox']").prop("checked", false);
    $("#announcement_modal_edit input[type='text']").val("");
    $("#announcement_date_publication").val("");
    $("#announcement_date_archivation").val("");
    $("#announcement_modal_edit select").val("01");
    // edit editor
    nicEditors.findEditor("announcement_text_editor").setContent("<span class='text-secondary'>Текст объявления...</span>");
    // attr data-
    $("#announcement_modal_edit").attr("data-id","");
    $("#announcement_modal_edit").attr("data-recipients","");
    $("#announcement_modal_edit").attr("data-publication","");
    $("#announcement_modal_edit").attr("data-author","");
    // other
    $("#announcement_list_editor").hide();
  }

  function blank_fill(data) {
    data["to_14"] === "1" ? data["to_14"] = "checked" : data["to_14"] = "";
    data["to_56"] === "1" ? data["to_56"] = "checked" : data["to_56"] = "";
    data["to_coordinators"] === "1" ? data["to_coordinators"] = "checked" : data["to_coordinators"] = "";
    data["to_servingones"] === "1" ? data["to_servingones"] = "checked" : data["to_servingones"] = "";
    data["by_list"] === "1" ? data["by_list"] = "checked" : data["by_list"] = "";

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
    let arr = [];
    if ($("#announcement_by_list").prop("checked")) {
      return arr;
    }
    return arr;
  }

  function get_data_fields() {
    // получатели для не опубликованных объявлений вормируются динамически, или все помещаются в лист?
    let recipients;
    if ($("#announcement_modal_edit").attr("data-publication") === "1") {
      recipients = get_recipients();
    } else {
      recipients = $("#announcement_modal_edit").attr("data-recipients");
    }
    let blank_data = new FormData();
    let data_field = {
      id: $("#announcement_modal_edit").attr("data-id"),
      publication: $("#announcement_modal_edit").attr("data-publication"),
      author: $("#announcement_modal_edit").attr("data-author"),
      to_14: $("#announcement_to_14").prop("checked"),
      to_56: $("#announcement_to_56").prop("checked"),
      to_coordinators: $("#announcement_to_coordinators").prop("checked"),
      to_servingones: $("#announcement_to_servingones").prop("checked"),
      by_list: $("#announcement_by_list").prop("checked"),
      recipients: recipients,
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

  function blank_save() {
    console.log(get_data_fields());
    fetch("ajax/ftt_announcement_ajax.php?type=save_announcement", {
      method: 'POST',
      body: get_data_fields()
    })
    .then(response => response.json())
    .then(commits => {
      //console.log(commits.result);
    // location.reload();
    });
  }

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
      console.log(commits.result);
      $("#announcement_modal_edit").modal("show");
      blank_fill(commits.result);
    });
  });

  // BLANK FIELDS BEHAVIORS
  // предусмотреть вставку
  $("#announcement_time_publication").keyup(function () {
    let time = $(this).val();
    if (time.length === 3 && time[2] !== ":") {
      $(this).val(String(time[0])+String(time[1])+':'+String(time[2]))
    } else if (time.length > 3 && time[2] !== ":") {
      $(this).val(String(time[0])+String(time[1])+':'+String(time[2]) + String(time[3]));
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

  /* ==== DOCUMENT READY STOP ==== */
});
/* ==== ANNOUNCEMENT STOP ==== */
