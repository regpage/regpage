//design
if ($(window).width()<=769) {
  if (!ftt_access_trainee) {
    $(".col_n_11_2").parent().removeClass("hide_element");
  }
  if ($('#periods').val() === 'range') {
    $("#modalFilrets .filter_range").show();
  }

  $("#modalAddEdit .input-google.short_number_field").parent().css("padding-left", "0px");
  $("#people_field").addClass("mt-3");


  $('#filters_list').attr("style", "margin-bottom: 0px !important");
  $('#filters_list').css("padding-bottom", "8px");

  // buttons
  $('#print_modal_open').hide();

  // Скрыть фильтры
  $("#team_select").hide();
  $("#author_select_desk").hide();
  $("#periods").hide();
  $("#filters_button").show();
  $("#sort_button").show();
  // строки
  $(".col_n_10").hide();
  // containers
  $("#main_row").attr('style', 'width: 100% !important;');
  // headers
  $("#list_header div").hide();
  $(".sort_date").parent().attr("style", "min-width: 70px;");
  $(".sort_date").parent().show();
  $(".sort_team").parent().attr("style", "min-width: 100px");
  $(".sort_team").parent().show();
  $(".sort_group").parent().attr("style", "min-width: 150px");
  $(".sort_group").parent().show();
  // columns
  //$(".col_n_3").attr('style', 'min-width: 0px !important;');
  //$("#list_content .col-2").attr('style', 'min-width: 0px !important;');
  //select
  //$("#author_select_desk").attr('style', 'width: 80px;');
  // modal
  // buttons
  $(".col_n_1").removeClass("col-2").removeClass("col_n_1");
  //$(".col_n_2").attr("style", "min-width: 60px !important");
  $(".col_n_2").removeClass("col-2").addClass("col-4");
  $(".col_n_2").attr("style", "max-width: 90px !important; padding-right: 0px;");

  // бланк
  $("#modalFilrets .btn-sm").removeClass("btn-sm");
  $("#modalRecommended .btn-sm").removeClass("btn-sm");
  $("#modalAddEdit .btn-sm").removeClass("btn-sm");
  $("#modalRecommended .recom_goal").parent().addClass("mr-4");
  if ($(window).width()<=390) {
    $("#delete_extra_help").attr('style', 'margin-right: 80px;');
  } else {
    $("#delete_extra_help").attr('style', 'margin-right: 100px;');
  }
  // select
  $("#gospel_group_field").attr('style', 'width: 170px;');
  // list
  //$(".list_string .col_n_2").removeClass('col-4').addClass('col-8');

  $(".list_string .col_n_4").css("padding", "0px").removeClass('text-right');

  $(".list_string .col_n_4_2").each(function () {
    if ($(this).text()) {
      $(this).text('Л'+$(this).text());
    } else {
      $(this).text('Л0');
    }
  });
  $(".list_string .col_n_5").css("padding", "0px").removeClass('text-right');
  $(".list_string .col_n_5_2").each(function () {
    if ($(this).text()) {
      $(this).text('Б'+$(this).text());
    } else {
      $(this).text('Б0');
    }
  });
  $(".list_string .col_n_6").css("padding", "0px").removeClass('text-right');
  $(".list_string .col_n_6_2").each(function () {
    if ($(this).text()) {
      $(this).text('М'+$(this).text());
    } else {
      $(this).text('М0');
    }

  });
  $(".list_string .col_n_7").css("padding", "0px").removeClass('text-right');
  $(".list_string .col_n_7_2").each(function () {
    if ($(this).text()) {
      $(this).text('Н'+$(this).text());
    } else {
      $(this).text('Н0');
    }
  });
  $(".list_string .col_n_8").css("padding", "0px").removeClass('text-right');
  $(".list_string .col_n_8_2").each(function () {
    if ($(this).text()) {
      $(this).text('П'+$(this).text());
    } else {
      $(this).text('П0');
    }
  });

  $(".list_string .col_n_8").next().css("padding", "0px").removeClass('text-right');
  $(".list_string .col_n_8").next().find('span').each(function () {
    $(this).text('В'+$(this).text());
  });
  $(".list_string .col_n_8").next().next().css("padding", "0px").removeClass('text-right');
  $(".list_string .col_n_8").next().next().find('span').each(function () {
    $(this).text('С'+$(this).text());
  });
  $(".list_string .col_n_8").next().next().next().css("padding", "0px").removeClass('text-right');
  $(".list_string .col_n_8").next().next().next().find('span').each(function () {
    if (!$(this).hasClass("float-right")) {
      $(this).text('Д'+$(this).text());
    }
  });
} else {
  if ($('#periods').val() === 'range') {
    $(".filter_range").show();
  }
}
