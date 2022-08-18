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

// фильтры trainee
  function filter_trainee() {
    // Search
    let search = $("#search_field").val();
    let string;
    let search_result = true;

    // Filter
    $("#list_content .list_string").each(function() {
      // search
      string = $(this).find("span").first().text() + " " + $(this).find("div").first().next().find("span").text();
      string = string.toLowerCase();
      if (search.length > 3) {
        search_result = string.indexOf(search.toLowerCase()) !== -1;
      }
      // Filter
      if (($(this).attr("data-serving_one") === $('#sevice_one_select').val() || $('#sevice_one_select').val() === "_all_")
      && ($(this).attr("data-semester") === $('#semester_select').val() || $('#semester_select').val() === "_all_")
      && ($(this).attr("data-time_zone") === $('#time_zone_selected').val() || $('#time_zone_selected').val() === "01")
      && ($(this).attr("data-locality_key") === $('#localities_select').val() || $('#localities_select').val() === "_all_")
      && search_result) {
       $(this).show();
     } else {
       $(this).hide();
     }
    });
  }
 $("#sevice_one_select, #semester_select, #time_zone_selected, #localities_select").change(function() {
   //setCookie('filter_serving_one', $(this).val(), 1);
   //$("#spinner").modal();
   filter_trainee();
 });

 $("#search_field").keyup(function(e) {
   filter_trainee();
 });

 // фильтры staff
 function filter_staff() {
   // Search
   let search = $("#search_field_staff").val();
   let string;
   let search_result = true;

   // Filter
   $("#list_content_staff .list_string").each(function() {
     // search
     string = $(this).find("span").first().text() + " " + $(this).find("div").first().next().find("span").text();
     string = string.toLowerCase();
     if (search.length > 3) {
       search_result = string.indexOf(search.toLowerCase()) !== -1;
     }
     // Filter
     if (($(this).attr("data-time_zone") === $('#time_zones_staff').val() || $('#time_zones_staff').val() === "01")
     && ($(this).attr("data-locality_key") === $('#localities_staff').val() || $('#localities_staff').val() === "_all_")
     && search_result) {
      $(this).show();
    } else {
      $(this).hide();
    }
   });
 }
  $("#time_zones_staff, #localities_staff").change(function(e) {
    //setCookie('filter_serving_one', $(this).val(), 1);
    //$("#spinner").modal();
    filter_staff();
  });

  $("#search_field_staff").keyup(function(e) {
    filter_staff();
  });

  $("#change_tab").change(function() {
    $("#tab_content .tab-pane").removeClass("active");
    $("#"+$(this).val()).addClass("active");
  });

  // Sorting
  $(".sorting, .sorting_staff").click( function(e) {
    let cookie_name_sort = "sorting";
    let cookie_name_desc = "desc";
    if (e.target.className === "sorting_staff") {
      cookie_name_sort = "sorting_staff";
      cookie_name_desc = "desc_staff";
    }

   // sort cookie
   if (getCookie(cookie_name_sort) === $(this).attr("data-field")) {
     if (getCookie(cookie_name_desc) === "1") {
        setCookie(cookie_name_desc, "0");
     } else {
       setCookie(cookie_name_desc, "1");
     }
   } else {
     setCookie(cookie_name_sort, $(this).attr("data-field"));
     setCookie(cookie_name_desc, "1");
   }

   // reload page
   setTimeout(function () {
     location.reload();
   }, 30);
 });

 $("#change_tab").change(function (e) {
   setCookie("tab_selected", $("#change_tab option:selected").val());
 });

// strings
//side panel
$(".list_string").click(function() {
  // перезаполнять несли кликнули по новой строке при открытой карточке
  if ($(".js-cd-panel-main").hasClass("cd-panel--is-visible")) {
    $(".js-cd-panel-main").removeClass("cd-panel--is-visible");
  } else {
    $(".js-cd-panel-main").addClass("cd-panel--is-visible");
  }
});
$(".js-cd-close").click(function() {
  $(".js-cd-panel-main").removeClass("cd-panel--is-visible");
});

// DOCUMENT READY STOP
});
