/* ==== Attend START ==== */
$(document).ready(function(){
  /* ==== DOCUMENT READY START ==== */
  $("#attend_list input[type='checkbox']").change(function () {
    let value = 0;
    if ($(this).prop("checked")) {
      value = 1;
    }
    fetch("ajax/attend_ajax.php?type=change_checkbox&id="
    + $(this).parent().parent().attr("data-member_key") + "&field=" + $(this).attr("data-field")
    + "&value=" + value)
    .then(response => response.text())
    .then(commits => {
      console.log(commits);
    });
  });
  /* ==== DOCUMENT READY STOP ==== */
});
