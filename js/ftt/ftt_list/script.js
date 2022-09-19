/* ==== MAIN & ATTENDANCE START ==== */
$(document).ready(function(){

  // текущая дата гггг.мм.дд
  date_now_gl = date_now_gl ();

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
      if (search.length >= 3) {
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
    if ($("#tab_trainee").hasClass("active")) {
      filter_trainee();
    } else {
      filter_staff();
    }
  });

  // reset search field
    $("#search_field").next().click(function () {
      if ($("#search_field").val()) {
        $("#search_field").val("");
        if ($("#tab_trainee").hasClass("active")) {
          filter_trainee();
        } else {
          filter_staff();
        }
      }
    });

  // фильтры staff
  function filter_staff() {
    // Search
    let search = $("#search_field").val();
    let string;
    let search_result = true;

    // Filter
    $("#list_content_staff .list_string").each(function() {
      // search
      string = $(this).find("span").first().text() + " " + $(this).find("div").first().next().find("span").text();
      string = string.toLowerCase();
      if (search.length >= 3) {
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
    filter_staff();
  });

  $("#search_field_staff").keyup(function(e) {
    filter_staff();
  });

  $("#change_tab").change(function() {
    $("#search_field").val("");
    filter_trainee();
    filter_staff();
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
    }

    fetch("ajax/ftt_list_ajax.php?type="+type+"&id="+member_key)
    .then(response => response.json())
    .then(commits => {
      $("#modalAddEdit").modal("show");
      $("#citizenship").val(commits.result["citizenship_key"]);
      $("#address").val(commits.result["address"]);
      $("#category").val(commits.result["category_key"]);
      $("#russianLanguage").val(commits.result["russian_lg"]);
      $("#comment").val(commits.result["comment"]);
      $("#emNewLocality").val(commits.result["new_locality"]);
      if (commits.result["new_locality"]) {
        $("#locality").hide();
        $("#emNewLocality").show();
        $("#reset_locality").show();
      } else {
        $("#locality").show();
        $("#emNewLocality").hide();
        $("#reset_locality").hide();
      }

      //$("#semester").val(commits.result["semester"]);
      //$("#spinner").modal("hide");
    });
  }
  // заполнение бланка
  function fill_blank() {
    //$("#spinner").modal("show");
    $("#modalAddEdit").attr("data-member_key", $("#tab_content .active_str").attr("data-member_key"));
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
    $("#modalAddEdit input").val("");
    $("#modalAddEdit").val("_none_");
    $("#modalAddEdit").attr("data-member_key", "");
    $("#localityControlGroup").parent().parent().hide();
  }

  // strings
  //side panel
  $(".list_string").click(function() {
    $(".active_str").removeClass("active_str");
    $(this).addClass("active_str");
    clear_blank();
    fill_blank();


  });

  // мгновенное динамическое обновление при успешном сохранении
  /*
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
*/
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
      // dinamic_list_updater(field, value);
    });
  }

  function get_data_blank() {
    let data = {};
    data["condition"] = {};
    data["condition"]["field"] = "key";
    data["condition"]["value"] = $("#modalAddEdit").attr("data-member_key");
    data["table"] = "member";
    data["changed"] = 1;
    $("#modalAddEdit input").each(function () {
      data[$(this).attr("data-field")] = $(this).val();
    });
    $("#modalAddEdit select").each(function () {
      data[$(this).attr("data-field")] = $(this).val();
    });
    return data;
  }

  function save_blank(data) {
    let data_post = new FormData();
    data_post.set("data", JSON.stringify(data));
    fetch("ajax/ftt_list_ajax.php?type=save_blank", {
      method: 'POST',
      body: data_post
    })
    .then(response => response.text())
    .then(commits => {
      $("#spinner").modal("hide");
      location.reload();
    });
  }

  function valid_fields() {
    let required_fields = document.querySelectorAll(".required_field");
    let empty = 0, error;
    required_fields.forEach(el => {
      if ((el.id === "locality" && el.value === "_none_") || (el.id === "emNewLocality" && !el.value)) {
        empty++;
      } else if (!el.value || el.value === "_none_") {
        error = 1;
      }
    });
    if (empty === 2 || error) {
      return 1;
    } else {
      return false;
    }
  }

  $("#save_blank").click(function() {
      if (valid_fields()) {
        showError('Заполните обязательные поля.');
        return;
      } else {
        $("#modalAddEdit").modal("hide");
        $("#spinner").modal("show");
        save_blank(get_data_blank());
      }
  });

  // отметка "Посещает собрания" в списке
  $(".attend_chbox, .attend_chbox_staff").click(function (e) {
    e.stopPropagation();
  });

  $(".attend_chbox, .attend_chbox_staff").change(function (e) {
    let checked;
    $(this).prop("checked") ? checked = 1 : checked = 0;
    save_field("member", $(this).attr("data-field"), checked, $(this).parent().parent().attr("data-member_key"));
  });

// new locality
  $("#new_locality").click(function () {
    if ($("#localityControlGroup").is(":visible")) {
      $("#localityControlGroup").parent().parent().hide();
    } else {
      $("#localityControlGroup").parent().parent().show();
    }
  });

  $("#emNewLocality").keydown(function () {
    $("#locality").val("_none_");
  });

  $("#emNewLocality").change(function () {
    $("#locality").val("_none_");
  });

  $("#locality").change(function () {
    $("#emNewLocality").val("");
    if ($(this).val() === "_new_") {
      $(this).val("_none_");
      $(this).hide();
      $("#emNewLocality").show();
      $("#reset_locality").show();
    }
  });

  $("#reset_locality").click(function () {
    if ($("#emNewLocality").val()) {
      $("#emNewLocality").val("");
    } else {
      $(this).hide();
      $("#emNewLocality").hide();
      $("#locality").show();
    }
  });

// DOCUMENT READY STOP
});
