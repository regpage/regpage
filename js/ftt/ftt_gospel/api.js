// save data
function save_data_blank(send) {
  let data = get_data_fields(send);
  if ($("#modalAddEdit").attr("data-id")) {
    // update
    fetch('ajax/ftt_gospel_ajax.php?type=update_data_blank', {
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(commits => {
      //dinamic_add_string(commits.result, true);
      clear_blank();
      location.reload();
    });
  } else {
    // добавить новый
    fetch('ajax/ftt_gospel_ajax.php?type=add_data_blank', {
      method: 'POST',
      body: data
    })
    .then(response => response.json())
    .then(commits => {
      //dinamic_add_string(commits.result);
      clear_blank();
      location.reload();
    });
  }
}
