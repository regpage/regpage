if ($(window).width()<=769) {
  // filtes & buttons
  $("#members-lists-combo").addClass("mb-2");
  $("#field_search_text").attr("style","width: "+$("#members-lists-combo").css("width")+";");

  $("#flt_members_localities").addClass("ml-3").addClass("mb-2");
  $("#flt_members_category").addClass("mb-2");

  // column names
  $("#col_name .col-1").attr("style", "padding-left: 15px; !important");
  $("#col_name").find(".pl-1").removeClass("pl-1").addClass("pl-0");
  $("b[data-sort='age']").text("Л");

  // rows container
  $("#attend_list").removeClass("pl-2");

  // rows
  $(".attend_str").removeClass("pl-1");
  $(".attend_str .col-3:nth-child(1)").addClass("pr-1");
  $(".attend_str .col-3:nth-child(2)").addClass("pr-1").addClass("pl-1");
} else if ($(window).width() > 769 && $(window).width() <= 1199) {
  $("#attend_list").addClass("mx-1");
  $(".attend_str .data_name").parent().attr("style", "max-width:160px;");
  $(".attend_str .data_name").parent().next().attr("style", "max-width:160px;");
  if ($(window).width() < 1001) {
    $("#col_name").hide();
    $(".attend_str .data_age").parent().attr("style", "max-width:30px;");
    $(".attend_str .vt_comment_text").parent().attr("style", "max-width:60px;");    
  } else {
    $("#col_name b[data-sort='name']").parent().attr("style", "max-width:160px;");
    $("#col_name b[data-sort='locality']").parent().attr("style", "max-width:160px;");
  }
}
