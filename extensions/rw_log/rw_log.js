function rw_log(data, type) {
  let admin = $(".nav-link[href='/profile']").attr("title");
  if (!type) {
    type = "INFO";
  }

  fetch("extensions/rw_log/rw_log_ajax.php?type="+type+"&data="+data+"&admin="+admin+"&member_key="+window.adminId)
  /*.then(response => response.text())
  .then(result => {
    console.log("log");
  })*/
}
