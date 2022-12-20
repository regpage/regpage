<script>
let data_page = {"applicant":""};
data_page.applicant = "<?php echo $applicant;?>";
data_page.role = "<?php echo $serviceone_role;?>";
//data_page.viewer = "<?php //echo $serviceones_pvom;?>";
// блокировка полей
function blockApplicationFields() {
  $("input").attr("disabled","disabled");
  $("select").attr("disabled","disabled");
  $("textarea").attr("disabled","disabled");
  //$("#toModalDeleteMyRequest").attr("disabled","disabled");
  $("#toModalSendMyRequest").attr("disabled","disabled");
  $("#btnMdlSendMyRequest").attr("disabled","disabled");
  $("#btnMdlDeleteMyRequest").attr("disabled","disabled");
  $("#add_support_block_extra").attr("disabled","disabled");
  $(".delete_extra_string").hide();
  setTimeout(function () {
    $(".pic-delete").hide();
    if ($("#main_container").attr("data-status") === "2" && data_page.role === "1") {
      $("#toModalSendMyRequest").attr("disabled", false);
      $("#btnMdlSendMyRequest").attr("disabled", false);
    }
  }, 100);
  $("#donotshowmethat").attr("disabled",false);
}

// ВИД ЗАЯВЛЕНИЯ ДЛЯ ЗАЯВИТЕЛЯ И НЕ ЗАЯВИТЕЛЯ
if (!data_page.applicant) {
  // Блокируем если просматривает не заявитель
  blockApplicationFields();
  //$('button[data-target="#modalStartInfo"]').hide();
  // разблокировка данных для рекомендатора и служащих
  if (data_page.role === "1" && $("#main_container").attr("data-status") === "2") { // разблокировка данных для рекомендатора
    $(".recommendation_block input").attr("disabled",false);
    $(".recommendation_block select").attr("disabled",false);
    $(".recommendation_block textarea").attr("disabled",false);
  } else if (data_page.role === "3" && $("#main_container").attr("data-status") === "4") { // разблокировка данных для служащих
    $(".serviceone_block input").attr("disabled",false);
    $(".serviceone_block select").attr("disabled",false);
    $(".serviceone_block textarea").attr("disabled",false);
  }
} else if (data_page.applicant && ($("#main_container").attr("data-status") === "1")) {
  blockApplicationFields();
} else if (data_page.applicant && ($("#main_container").attr("data-status") === "0" || !$("#main_container").attr("data-status"))) {
  // разблокировано
} else {
  blockApplicationFields();
}
</script>

<script src="js/ftt/ftt_application/ftt_request.js?v17"></script>
<script src="js/ftt/ftt_application/design.js?v2"></script>
