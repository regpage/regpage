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
      && ($(this).attr("data-category_key") === $('#category_select').val() || $('#category_select').val() === "_all_")
      && search_result) {
       $(this).show();
     } else {
       $(this).hide();
     }
    });
  }
  $("#sevice_one_select, #semester_select, #time_zone_selected, #localities_select, #category_select").change(function() {
    //setCookie('filter_serving_one', $(this).val(), 1);
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
    if ($(".js-cd-panel-main").hasClass("cd-panel--is-visible")) {
      $(".js-cd-panel-main").removeClass("cd-panel--is-visible");
      clear_blank();
      $("#tab_content .active_str").removeClass("active_str");
    }
    setCookie("tab_selected", $("#change_tab option:selected").val());
    $("#tab_content .tab-pane").removeClass("active");
    $("#"+$(this).val()).addClass("active");
  });

  // BLANK
  // получаем данные пользователя
  function get_member_data(member_key) {
    let type = "get_member_data";
    if ($("#tab_service_one").hasClass("active")) {
      type = "get_member_data_staff";
      $("#semester").parent().hide();
    } else {
      if (!$("#semester").is(":visible")) {
        $("#semester").parent().show();
      }
    }
    fetch("ajax/ftt_list_ajax.php?type="+type+"&id="+member_key)
    .then(response => response.json())
    .then(commits => {
      $("#citizenship").val(commits.result["citizenship_key"]);
      $("#address").val(commits.result["address"]);
      $("#baptized").val(commits.result["baptized"]);
      $("#category").val(commits.result["category_key"]);
      $("#semester").val(commits.result["semester"]);
      $("#comment").val(commits.result["comment"]);
      $("#russianLanguage").val(commits.result["russian_lg"]);
      $("#document_type").val(commits.result["document_key"]);
      $("#document_num").val(commits.result["document_num"]);
      $("#document_date").val(commits.result["document_date"]);
      $("#document_auth").val(commits.result["document_auth"]);
      $("#document_num_tp").val(commits.result["tp_num"]);
      $("#document_auth_tp").val(commits.result["tp_auth"]);
      $("#document_date_tp").val(commits.result["tp_date"]);
      $("#document_name_tp").val(commits.result["tp_name"]);
      $("#spinner").modal("hide");
    });
  }
  // заполнение бланка
  function fill_blank() {
    $("#spinner").modal("show");
    $(".cd-panel").attr("data-member_key", $("#tab_content .active_str").attr("data-member_key"));
    $("#name").val($("#tab_content .active_str").attr("data-name"));
    $("#locality").val($("#tab_content .active_str").attr("data-locality_key"));
    $("#gender").val($("#tab_content .active_str").attr("data-male"));
    $("#birth_date").val($("#tab_content .active_str").attr("data-birth_date"));
    $("#email").val($("#tab_content .active_str").find(".m_email").text());
    $("#phone").val($("#tab_content .active_str").find(".m_cell_phone").text());
    get_member_data($("#tab_content .active_str").attr("data-member_key"));
  }
  // очистка бланка
  function clear_blank() {
    $(".cd-panel__content input").val("");
    $(".cd-panel__content select").val("_none_");
    $(".cd-panel").attr("data-member_key", "");
  }
  // close blank by the CLOSE button
  $(".cd-panel__close").click(function(e) {    
    e.preventDefault();
    $(".js-cd-panel-main").removeClass("cd-panel--is-visible");
    clear_blank();
    $("#tab_content .active_str").removeClass("active_str");
  });
  // strings
  //side panel
  $(".list_string").click(function() {
    if ($(".js-cd-panel-main").hasClass("cd-panel--is-visible") && $(this).hasClass("active_str")) {
      $(".js-cd-panel-main").removeClass("cd-panel--is-visible");
      $(this).removeClass("active_str");
      clear_blank();
    } else if ($(".js-cd-panel-main").hasClass("cd-panel--is-visible") && !$(this).hasClass("active_str")) {
      $("#tab_content .active_str").removeClass("active_str");
      clear_blank();
      $(this).addClass("active_str");
      fill_blank();
    } else {
      $(".js-cd-panel-main").addClass("cd-panel--is-visible");
      $(this).addClass("active_str");
      fill_blank();
    }
  });

  // мгновенное динамическое обновление при успешном сохранении
   function dinamic_list_updater(field, value) {
      if (field === "locality_key") {
        $(".active_str").attr("data-"+field, value);
        $(".active_str").find(".m_locality").text($("#locality option:selected").text());
      } else if (field === "name") {
        $(".active_str").attr("data-"+field, value);
        $(".active_str").find(".m_name").text(fullNameToNoMiddleName(value));
      } else if (field === "birth_date" ) {
        $(".active_str").attr("data-"+field, value);
        $(".active_str").find(".m_age").text(get_current_age(value));
      } else {
        // semester ect
       $(".active_str").attr("data-"+field, value);
       $(".active_str").find(".m_"+field).text(value);
      }
   }

  // save field
  function save_field(table, field, value, condition) {
    let condition_field, changed;
    if (table === "member") {
      condition_field = "key";
      changed = 1;
    } else if (table === "ftt_trainee") {
      condition_field = "member_key";
      changed = 0;
    } else {
      condition_field = "member_key";
      changed = 0;
    }
    // save field
    fetch("ajax/ftt_list_ajax.php?type=change_field&table="
    + table
    + "&field=" + field
    + "&value=" + value
    + "&condition=" + condition
    + "&condition_field=" + condition_field
    + "&changed=" + changed)
    .then(response => response.json())
    .then(commits => {
      // динамическое обновление строк
      dinamic_list_updater(field, value);
    });
  }

  // save input field
  // добавить уcловие на сохранение вставка (changed)
  $(".cd-panel__content input").change(function() {
    //return;
    save_field($(this).attr("data-table"), $(this).attr("data-field"), $(this).val(), $(".cd-panel").attr("data-member_key"));
  });
  // save select field
  $(".cd-panel__content select").change(function() {
    //return;
    save_field($(this).attr("data-table"), $(this).attr("data-field"), $(this).val(), $(".cd-panel").attr("data-member_key"));
  });

// DOCUMENT READY STOP
});
