// Message for user
// Message show

function showHint(html, time) {
  time = time || 2000;
  if (isNaN(time)) {
    time = 2000;
  }

	$("#globalHint > span").html (html);
	$("#globalHint").fadeIn();
	window.setTimeout(function() { $("#globalHint").fadeOut (); }, time);
	$(".close-alert").click(function() {
		$("#globalHint").attr('style','display: none;');
	});
}
// Error show
function showError(html, autohide) {
	$("#globalError > span").html (html);
  var a = $("#globalError > span").text();
  if (a.length === 0) {
    //window.location = "login.php?returl="+/\/[^\/]+$/g.exec (document.URL);
    var b = window.location.href;
    window.location = b;
  }
	$("#globalError").fadeIn();
	if (autohide || typeof autohide === "undefined") window.setTimeout(function() { $("#globalError").fadeOut (); }, 4000);
	$(".close-alert").click(function() {
		$("#globalError").attr('style','display: none;');
	});
}
// Help show
function showHelp(html, autohide, time) {
	if (time || typeof time === "undefined") time = 8000;
	$("#globalHelp > span").html (html);
	$("#globalHelp").fadeIn();
	if (autohide || typeof autohide === "undefined") window.setTimeout(function() { $("#globalHelp").fadeOut (); }, time);
	$(".close-alert").click(function() {
		$("#globalHelp").attr('style','display: none;');
	});
}
// STOP Message for user
