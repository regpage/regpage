/* ==== INFOBOARD START ==== */
$(document).ready(function(){
  // переключение между вкладками
  $("#announcement_nav_tabs .nav-link").click(function () {
    if ($(this).attr("href") === "#announcement_tab_1") {
      setCookie("tab_active", "outbox");
    } else if ($(this).attr("href") === "#announcement_tab_2") {
      setCookie("tab_active", "inbox");
    } else {
      return;
    }
    setTimeout(function () {
      location.reload();
    }, 30);
  });

  $(".list_str").click(function () {
    $("#modal_edit_add_md").attr("data-id", $(this).attr("data-id"));
    $("#mdl_infoboard_type").val($(this).attr("data-type"));
    // edit editor
    fetch("api_ftt.php?section=infoboard&type=get_position&id=" + $(this).attr("data-id"))
    .then(response => response.json())
    .then(commits => {
      if (commits.result[0]) {
        nicEditors.findEditor("mdl_niceditor_field").setContent(commits.result[0].text);
        $("#mdl_staff_comment").val(commits.result[0].comment);
        $("#modal_edit_add_md").modal("show");
      }
    });
  });

  // save
  $("#save_infoboard").click(function () {
    let data_field_post = {
      text: nicEditors.findEditor("mdl_niceditor_field").getContent(),
      comment: $("#mdl_staff_comment").val()
    }
    let blank_data = new FormData();
    blank_data.set("data", JSON.stringify(data_field_post));
    // edit editor
    fetch("api_ftt.php?section=infoboard&type=set_position&id=" + $("#modal_edit_add_md").attr("data-id"), {
      method: 'POST',
      body: blank_data
    })
    .then(response => response.json())
    .then(commits => {
      $("#modal_edit_add_md").modal("hide");
      location.reload();
    });
  });
});
