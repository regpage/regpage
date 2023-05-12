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
  if ($("#main_container").attr("data-status") === "2" && (data_page.role === "1" || data_page.role === "3") && window.adminId === $("#service_recommendation_name").val()) { // разблокировка данных для рекомендатора
    $("#point_recommendation_status").attr("disabled",false);
    $("#recommended_block textarea").attr("disabled",false);
    //$("#recommended_block input[type='radio']").attr("disabled", false);
    $("#recommended_block button").attr("disabled", false);
  } else if ($("#main_container").attr("data-status") === "4" && (data_page.role === "3" || data_page.role === "2")  && window.adminId === $("#service_interview_name").val()) { // разблокировка данных для служащих
    $("#interview_block input").attr("disabled",false);
    //$("#interview_block select").attr("disabled",false);
    $("#point_interview_status").attr("disabled",false);
    $("#interview_block textarea").attr("disabled",false);
  } else if (($("#main_container").attr("data-status") && $("#main_container").attr("data-status") !== "0" && $("#main_container").attr("data-status") !== "6") && data_page.role === "3") {
    // recommend block
    $("#recommended_block textarea").attr("disabled",false);
    $("#recommended_block button").attr("disabled", false);
    $("#recommended_block select").attr("disabled", false);
    $("#recommended_block button").attr("disabled", false);
    // interview block
    $("#interview_block select").attr("disabled",false);
    $("#interview_block input").attr("disabled",false);
    $("#interview_block textarea").attr("disabled",false);
    $("#interview_block button").attr("disabled", false);
    // main service block
    $("#point_decision").attr("disabled",false);
    $("#point_decision_info").attr("disabled",false);
  }
} else if (data_page.applicant && ($("#main_container").attr("data-status") === "1")) {
  blockApplicationFields();
} else if (data_page.applicant && ($("#main_container").attr("data-status") === "0" || !$("#main_container").attr("data-status"))) {
  // разблокировано
} else {
  blockApplicationFields();
}

</script>

<script src="extensions/rw_log/rw_log.js?v1"></script>
<script src="js/modules/date.js?v1"></script>
<script src="js/ftt/ftt_application/ftt_request.js?v38"></script>
<script src="js/ftt/ftt_application/design.js?v3"></script>
