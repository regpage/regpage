// получить данные о дистанционном обучении.
function participation_type_trainee(member_key, elem) {
  fetch("ajax/ftt_extra_help_ajax.php?type=get_participation_type&member_key=" + member_key)
  .then(response => response.json())
  .then(commits => {
    // console.log(commits.result);
    if (commits.result === "1") {
      elem.show();
    } else {
      elem.hide();
    }
  })
}
