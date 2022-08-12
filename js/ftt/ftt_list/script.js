/* ==== MAIN & ATTENDANCE START ==== */
$(document).ready(function(){

  // текущая дата гггг.мм.дд
  date_now_gl = date_now_gl ();

  // save select field
  /*
  function save_select_field(element, value) {
    field = element.attr("data-field");
    id = element.parent().parent().parent().attr("data-id");
    data = "&field="+field+"&value="+value+"&id="+id;
    fetch('ajax/ftt_list_ajax.php?type=updade_data_blank' + data)
    .then(response => response.json())
    .then(commits => {
      console.log(commits.result);
    });
 }
*/

// фильтры
 $("#sevice_one_select, #semester_select, #time_zone_selected, #localities_select").change(function(e) {
   //setCookie('filter_serving_one', $(this).val(), 1);
   //$("#spinner").modal();
   $("#list_content .list_string").each(function() {
     if (($(this).attr("data-serving_one") === $('#sevice_one_select').val() || $('#sevice_one_select').val() === "_all_")
     && ($(this).attr("data-semester") === $('#semester_select').val() || $('#semester_select').val() === "_all_")
     && ($(this).attr("data-time_zone") === $('#time_zone_selected').val() || $('#time_zone_selected').val() === "01")
     && ($(this).attr("data-locality_key") === $('#localities_select').val() || $('#localities_select').val() === "_all_")) {
      $(this).show();
    } else {
      $(this).hide();
    }
   });
 });

 $("#change_tab").change(function() {
   $("#tab_content .tab-pane").removeClass("active");
   $("#"+$(this).val()).addClass("active");
 });
// DOCUMENT READY STOP
});
