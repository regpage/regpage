/* ==== START ==== */
$(document).ready(function(){
/*** DOCUMENT READY START ***/

  // strings

  // фильтры

  // Sorting

  // BLANK

  // заполнение бланка

  // очистка бланка
  function blank_reset(selector) {
    // fields
    $(selector + " input[type='checkbox']").prop("checked", false);
    $(selector + " input[type='checkbox']").val("");
    $(selector + " input[type='checkbox']").val("");
    $(selector + " select").val("_none_");
    // attr data-
    $(selector).attr("data-id","");
    $(selector).attr("data-date","");
  }
  // мгновенное динамическое обновление при успешном сохранении

  // save field

/*** DOCUMENT READY STOP ***/
});
/* ==== STOP ==== */
