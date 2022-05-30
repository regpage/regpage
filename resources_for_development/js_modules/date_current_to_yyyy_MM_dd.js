function date_now_gl () {
  // YYYY-MM-dd
  let date_now_gl = new Date();
  let yyyy = date_now_gl.getFullYear();
  let mm = date_now_gl.getMonth()+1;
  let dd = date_now_gl.getDate();
  if (mm < 9) {
    mm = '0'+mm;
  }
  return yyyy + '-' + mm + '-' + dd;
}
