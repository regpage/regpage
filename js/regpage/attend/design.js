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
}
