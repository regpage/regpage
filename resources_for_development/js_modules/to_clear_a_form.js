// Очистить форму
function clear_blank() {
  $('#some_form').find('input').val('');
  $('#some_form').find('select').val('_none_');
  $('#some_form').find('textarea').text('');
  $('#some_form').data('id', '');
}
