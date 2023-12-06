function footer_btm(num, old, timeout) {
  // прибить футер new 62 & old 135
  if (old) {
    old = "#footer_block";
    if (!timeout) {
      timeout = 125;
    }
  } else {
    old = "#footer_info";
  }
  // новые разделы включая ПВОМ
  if (old === "#footer_info") {
    if (window.location.pathname === '/ftt_schedule.php' || window.location.pathname === '/ftt_schedule') {
      setTimeout(function () {
        if (($(window).height() - $("body").height() - num) > 0) {
          $(old).css("margin-top", $(window).height() - $("body").height() - num);
      	} else {
          $(old).css("margin-top", "50px");
        }
      }, 50);
    } else if (window.location.pathname === '/contacts.php' || window.location.pathname === '/contacts') {
      setTimeout(function () {
        if (($(window).height() - $("body").height() - num) > 0) {
          $(old).css("margin-top", $(window).height() - $("body").height() - num);
      	} else {
          $(old).css("margin-top", "50px");
        }
      }, 1000);
    } else {
      if (($(window).height() - $("body").height() - num) > 0) {
        $(old).css("margin-top", $(window).height() - $("body").height() - num);
    	} else {
        $(old).css("margin-top", "50px");
      }
    }
  } else { // старые разделы
    if (window.location.pathname === '/index.php' || window.location.pathname === '/index') {
      setTimeout(function () {
        if (($(window).height() - $("body").height() - num) > 0) {
          $(old).css("margin-top", $(window).height() - $("body").height() - num + 85);
        } else {
          $(old).css("margin-top", "50px");
        }
      }, 125);
    } else {
       setTimeout(function () {
         if (($(window).height() - $("body").height() - num) > 0) {
           $(old).css("margin-top", $(window).height() - $("body").height() - num);
       	 } else {
           $(old).css("margin-top", "50px");
         }
     }, timeout);
    }
  }
}
