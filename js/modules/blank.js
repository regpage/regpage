function module_blank_clear (element) {
  element.attr("data-id", "");
  element.attr("data-date", "");
  element.find("input").val("");
  /* Странно что здесь указано _all_ а не _none_ возможно надо заменить*/
  element.find("select").val("_all_");
  element.find("textarea").val("");
}
