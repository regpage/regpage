// FTT JS
$(document).ready(function() {
  // Переменная в которой будут храниться данные запросов. НО, возможно, это плохая идея
  // потому что необходимо постаянно перезапрашивать данные и обнавлять её содержимое

  if (getCookie("tap_request_for") === "active") {
    setCookie("tap_request_for", "");
    showHint("Заявление добавлено на сайт.");
  }

  // Нужно додумать
  let requests = {};

  // Рендорим список заявлений
   function rendoringListOfRequests(list, guest) {
     // Проверяем аргумент
     if (!list) {
       $("#requests-list").html("<h1>Нет заявлений.</h1>");
       return;
     }

     let list_id = "#requests-list";

     if (guest) {
       list_id = "#requests-guest-list";
       $("#requests-guest-list").prev().prev().find("h3").text("Гости (" + list.length+")");
     } else {
       $("#requests-list").prev().prev().find("h3").text("Кандидаты (" + list.length+")");
     }

     let list_desk = [];
     for (var i = 0; i < list.length; i++) {
       // подготавливаем данные
       let request_status = "";
       if (list[i].stage == 0) {
         request_status = '<span class="badge badge-secondary">черновик</span>';
       } else if (list[i].stage > 0 ) {
         request_status = '<span class="badge badge-info">отправлен</span>';
       }
       let decision_text = "";
       if (list[i].decision === "deny") {
         decision_text = '<span class="badge badge-danger">отклонён</span>';
       } else if (list[i].decision === "approve") {
         decision_text = '<span class="badge badge-success">принят</span>';
       }

       //Рендорим список
       list_desk.push("<div class='row request-string' data-member_key='"+ list[i].member_key +"'><div class='col-3 pl-1'><span>"+list[i].name+
       "</span><br><span class='grey_text'>"+ data_page.category[list[i].category_key] +"</span></div><div class='col'>"+list[i].locality_name+"</div><div class='col'><span>"+list[i].cell_phone+"</span><br><span class='grey_text'>"+list[i].email+
       "</span></div><div class='col-2'><span>"+request_status+"</span><br><span class='grey_text'>"+list[i].send_date+"</span></div><div class='col-2'>"+decision_text+"</div></div>");
       //<div class='col-1 request-trash'>🗑</div>
     }
     $(list_id).html(list_desk);

     // открываем строку
     $(".request-string").click(function () {
       let query = "application.php?member_key=" + $(this).attr("data-member_key");
       document.cookie = "application_back=1";
       window.location = query;

     });
     if ($(window).width()<=769) {
       $(".request-string div:nth-child(1)").removeClass("col-3").addClass("col-7");
       $(".request-string div:nth-child(2)").removeClass("col-2").addClass("col-5");
       $(".request-string div:nth-child(3)").removeClass("col").addClass("col-7").addClass("pl-1");
       $(".request-string div:nth-child(4)").removeClass("col-2").addClass("col-5");
       $(".request-string div:nth-child(5)").addClass("pl-1");

       $("#header_candidate div:nth-child(3)").hide();
       $("#header_candidate div:nth-child(4)").hide();
       $("#header_candidate div:nth-child(5)").hide();

       $("#header_guest div:nth-child(3)").hide();
       $("#header_guest div:nth-child(4)").hide();
       $("#header_guest div:nth-child(5)").hide();
     }
   }

  // Получаем заявления
  // Все заявления для тех у кого зона ответственности ПВОМ
  //&admin_id=" + data_page.admin_id
  // GET COOKIE FOR SORTING sort : m.name_up, m.name_down, m.locality_up, m.locality_down
  fetch("ajax/ftt_ajax.php?type=all_requests&guest=0&role="+$("#list_requests").attr("data-role")+"&sort="
  + getCookie("sorting"))
  .then(response => response.json())
  .then(result => rendoringListOfRequests(result.result));

  setTimeout(function () {
    // Получаем заявления гостей
    fetch("ajax/ftt_ajax.php?type=all_requests&guest=1&role="+$("#list_requests").attr("data-role")
    +"&sort="+getCookie("sorting_g"))
    .then(response => response.json())
    .then(result => rendoringListOfRequests(result.result, true));
  }, 50);

  // сортировка кандидаты
  $("#header_candidate .sort_fio, #header_candidate .sort_locality").click(function (e) {
    $("#header_candidate .sort_fio i, #header_candidate .sort_locality i").addClass("hide_element");
    if ($(this).hasClass("sort_fio")) {
      $("#header_candidate .sort_locality i").removeClass("fa");
      $("#header_candidate .sort_locality i").removeClass("fa-sort-desc");
      $("#header_candidate .sort_locality i").removeClass("fa-sort-asc");
    } else if ($(this).hasClass("sort_locality")) {
      $("#header_candidate .sort_fio i").removeClass("fa");
      $("#header_candidate .sort_fio i").removeClass("fa-sort-desc");
      $("#header_candidate .sort_fio i").removeClass("fa-sort-asc");
    }

    $(this).find("i").removeClass("hide_element");

    if ($(this).find("i").hasClass("fa-sort-desc")) {
      $(this).find("i").removeClass("fa-sort-desc").addClass("fa-sort-asc");
      setCookie('sorting', e.target.className + "-desc", 356);
    } else if ($(this).find("i").hasClass("fa-sort-asc")) {
      $(this).find("i").removeClass("fa-sort-asc").addClass("fa-sort-desc");
      setCookie('sorting', e.target.className + "-asc", 356);
    } else {
      $(this).find("i").addClass("fa");
      $(this).find("i").addClass("fa-sort-desc");
      setCookie('sorting', e.target.className + "-asc", 356);
    }
    setTimeout(function () {
      location.reload();
    }, 30);
  });

  // сортировка гости
  $("#header_guest .sort_fio, #header_guest .sort_locality").click(function (e) {
    $("#header_guest .sort_fio i, #header_guest .sort_locality i").addClass("hide_element");
    if ($(this).hasClass("sort_fio")) {
      $("#header_guest .sort_locality i").removeClass("fa");
      $("#header_guest .sort_locality i").removeClass("fa-sort-desc");
      $("#header_guest .sort_locality i").removeClass("fa-sort-asc");
    } else if ($(this).hasClass("sort_locality")) {
      $("#header_guest .sort_fio i").removeClass("fa");
      $("#header_guest .sort_fio i").removeClass("fa-sort-desc");
      $("#header_guest .sort_fio i").removeClass("fa-sort-asc");
    }

    $(this).find("i").removeClass("hide_element");

    if ($(this).find("i").hasClass("fa-sort-desc")) {
      $(this).find("i").removeClass("fa-sort-desc").addClass("fa-sort-asc");
      setCookie('sorting_g', e.target.className + "-desc", 356);
    } else if ($(this).find("i").hasClass("fa-sort-asc")) {
      $(this).find("i").removeClass("fa-sort-asc").addClass("fa-sort-desc");
      setCookie('sorting_g', e.target.className + "-asc", 356);
    } else {
      $(this).find("i").addClass("fa");
      $(this).find("i").addClass("fa-sort-desc");
      setCookie('sorting_g', e.target.className + "-asc", 356);
    }
    setTimeout(function () {
      location.reload();
    }, 30);
  });

  $("#btn_add_new_application").click(function () {
    if (!$("#select_member_new_application").val()) {
      showError("Пожалуйста, выберите кандидата из списка.")
      return;
    }
    let member_key = $("#select_member_new_application_list option[value='"
    + $("#select_member_new_application").val() + "']").attr("data-id");

    if (!member_key) {
      showError("Пожалуйста, выберите кандидата из списка.");
      return;
    }
    let guest = $("#new_guest_application").prop("checked") ? 1 : 0;
    fetch("ajax/ftt_ajax.php?type=add_application&guest="+guest+"&member_key="+member_key)
    .then(response => response.json())
    .then(commits => {
      if (commits.result) {
        showHint("Заявление для кандидата " + $("#select_member_new_application").val() + " добавлено на сайт.");
        /*$("#member_new_application_list").prepend('<div class="row mb-3" data-id="'
        + member_key
        + '"><div class="col-11">' + $("#select_member_new_application").val()
        + '</div><div class="col-1"><i class="fa fa-trash cursor-pointer" style="font-size:18px;" aria-hidden="true"></i></div></div>');*/
      } else {
        showError("Заявление уже было добавлено.");
      }
    });
  });
  /*$(".fa-trash").click(function () {
    let elem = $(this).parent().parent();
    if (confirm("Удалить заявление " + $(this).parent().prev().find("div").text())) {
      fetch("ajax/ftt_ajax.php?type=dlt_application&member_key="+elem.attr("data-id"))
      .then(response => response.json())
      .then(commits => {
        if (commits.result) {
          elem.hide();
        } else {
          showError("Заявление уже было удалено.");
        }
      });
    }
  });*/
  $("#modal_dlt_add_new_application .btn-secondary").click(function () {
    setTimeout(function () {
      location.reload();
    }, 100);
  });

  function flt_allow_deny() {
    let deny, allow;
    $("#requests-list .request-string").each(function () {
      allow = $(this).find(".badge-success").hasClass("badge") && $("#flt_allow_deny").val() === "badge-success";
      deny = $(this).find(".badge-danger").hasClass("badge") && $("#flt_allow_deny").val() === "badge-danger";
      if ($("#flt_allow_deny").val() === "_all_" || allow || deny) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });

    $("#requests-guest-list .request-string").each(function () {
      if ($("#flt_allow_deny").val() === "_all_" || allow || deny) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  }
  $("#flt_allow_deny").change(function () {
    flt_allow_deny();
  });

  $(".btn_approve_request").click(function () {
    $("#modal_add_request_for").modal("show");
    $("#modal_add_request_for").attr("data-id", $(this).parent().parent().attr("data-id"));
    $("#modal_add_request_for").attr("data-guest", $(this).parent().parent().attr("data-guest"));
    if ($(this).parent().parent().attr("data-guest") === "1") {
      $("#modal_add_request_for h5").text("Создать заявление в качестве ГОСТЯ");
    } else {
      $("#modal_add_request_for h5").text("Создать заявление");
    }

  });

  $("#mdl_btn_approve_request, #mdl_btn_approve_request_guest").click(function () {
    let id = $("#modal_add_request_for").attr("data-id");
    let guest = $("#modal_add_request_for").attr("data-guest");
    if ($(this).attr("id") === 'mdl_btn_approve_request') {
      guest = 0;
    } else {
      guest = 1;
    }
    fetch("ajax/ftt_ajax.php?type=approve_request_for&guest="+guest+"&id="+id)
    .then(response => response.json())
    .then(result => {
      setCookie("tap_request_for", "active");
      setTimeout(function () {
        location.reload();
      }, 30);
    });
  });

  $(".btn_delete_request").click(function () {
    $("#modal_dlt_request_for").modal("show");
    $("#modal_dlt_request_for").attr("data-id", $(this).parent().parent().attr("data-id"));
  });

  $("#mdl_btn_delete_request").click(function () {
    let id = $("#modal_dlt_request_for").attr("data-id");
    fetch("ajax/ftt_ajax.php?type=dlt_request_for&id="+id)
    .then(response => response.json())
    .then(result => {
      $("#tab_request_for .str_of_list[data-id='"+id+"']").hide();
      $("#modal_dlt_request_for").modal("hide");
    });
  });

  $("#mdl_open_recruit").click(function () {
    if ($(this).text().trim() === "Остановить приём заявлений") {
      $("#btn_open_recruit").hide();
      $("#btn_stop_recruit").show();
      $("#modal_open_recruit h5").text("Остановить приём заявлений?")
    } else {
      $("#btn_open_recruit").show();
      $("#btn_stop_recruit").hide();
      $("#modal_open_recruit h5").text("Открыть приём заявлений?")
    }
  });

  $("#btn_open_recruit, #btn_stop_recruit").click(function () {
    let status = 1;
    if ($(this).attr("id") === "btn_stop_recruit") {
      status = "";
    }
    fetch("ajax/ftt_ajax.php?type=recruit_status&status="+status)
    .then(response => response.json())
    .then(result => {
      location.reload();
    });
  });

/*** DOCUMENT READY END ***/
});
