function module_blank_clear (element) {
  element.attr("data-id", "");
  element.attr("data-date", "");
  element.find("input").val("");
  element.find("select").val("_all_");
  element.find("textarea").val("");
}
