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

  // Выбор подраздела
  $(".members-lists-combo").change(function(){
      listsType = $(".members-lists-combo").val();
      switch (listsType) {
          case 'members': window.location = '/members'; break;
          case 'youth': window.location = '/youth'; break;
          case 'list': window.location = '/list'; break;
          case 'activity': window.location = '/activity'; break;
          case 'attend': window.location = '/attend'; break;
      }
  });

  // sorting
  $(".sort_col").click(function () {
    if ($(this).find("i").hasClass("fa-sort-desc")) {
      $(this).find("i").removeClass("fa-sort-desc");
      $(this).find("i").addClass("fa-sort-asc");
      setCookie('sorting-attend', $(this).attr("data-sort") + "-desc", 356);
    } else if ($(this).find("i").hasClass("fa-sort-asc")) {
      $(this).find("i").removeClass("fa-sort-asc");
      $(this).find("i").addClass("fa-sort-desc");
      setCookie('sorting-attend', $(this).attr("data-sort") + "-asc", 356);
    } else {
      $(".sort_col i").removeClass("fa");
      $(".sort_col i").removeClass("fa-sort-desc");
      $(".sort_col i").removeClass("fa-sort-asc");
      $(this).find("i").addClass("fa").addClass("fa-sort-desc");
      setCookie('sorting-attend', $(this).attr("data-sort") + "-asc", 356);
    }
    setTimeout(function () {
      location.reload();
    }, 30);
  });
  // search
  $('#field_search_text').click(function(event){
    event.stopPropagation();
    if ($(this).val().length > 0) {
      setTimeout(function () {
        if (!$('#field_search_text').val()) {
          filtersOfString();
        }
      }, 30);
    }
  });
  function filtersOfString() {
    $("#spinner").modal("show");
    setTimeout(function () {
      let ltm, pm, gm, am, vt;
    let text = $("#field_search_text").val().trim();
    $("#attend_list .attend_str").each(function () {
      // Search text
      if (text.length > 2) {
        fio = $(this).find('.data_name').text().trim();
        searchResult = true;
        if (fio.toLowerCase().indexOf(String(text.toLowerCase())) === -1) {
          searchResult = false;
        }
      } else {
        searchResult = true;
      }
      // STOP Search text
      ltm = $(this).find("input[data-field='attend_meeting']").prop("checked");
      pm = $(this).find("input[data-field='attend_pm']").prop("checked");
      gm = $(this).find("input[data-field='attend_gm']").prop("checked");
      am = $(this).find("input[data-field='attend_am']").prop("checked");
      vt = $(this).find("input[data-field='attend_vt']").prop("checked");
      if (($("#flt_members_localities").val() === $(this).attr("data-locality_key")
      || $("#flt_members_localities").val() === "_all_")
      && ($("#flt_members_category").val() === $(this).attr("data-category_key")
      || $("#flt_members_category").val() === "_all_") &&
      ($("#flt_members_attend").val() === "_all_"
      || ($("#flt_members_attend").val() === "5" && (ltm || pm || gm || am))
      || ($("#flt_members_attend").val() === "0" && (!ltm && !pm && !gm && !am))
      || ($("#flt_members_attend").val() === "1" && ltm)
      || ($("#flt_members_attend").val() === "2" && pm)
      || ($("#flt_members_attend").val() === "3" && gm)
      || ($("#flt_members_attend").val() === "4" && am)
      || ($("#flt_members_attend").val() === "6" && vt))
      && (!$("#field_search_text").val() || searchResult)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
    $("#spinner").modal("hide");
    }, 10);
  }
  // filters
  $("#flt_members_attend, #flt_members_category, #flt_members_localities, #field_search_text").change(function () {
    filtersOfString();
  });
  /* ==== DOCUMENT READY STOP ==== */
});
