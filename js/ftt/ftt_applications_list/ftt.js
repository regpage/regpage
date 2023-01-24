// FTT JS
$(document).ready(function() {
  // Переменная в которой будут храниться данные запросов. НО, возможно, это плохая идея
  // потому что необходимо постаянно перезапрашивать данные и обнавлять её содержимое
  console.log(data_page);
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

     console.log(list);
     let list_desk = [];
     for (var i = 0; i < list.length; i++) {
       // подготавливаем данные
       let request_status = "";
       if (list[i].stage == 0) {
         request_status = "Черновик";
       } else if (list[i].stage > 0 ) {
         request_status = "Отправлен";
       }
       let decision_text = "";
       if (list[i].decision === "deny") {
         decision_text = '<span class="badge badge-danger">отклонён</span>';
       } else if (list[i].decision === "approve") {
         decision_text = '<span class="badge badge-success">принят</span>';
       }

       //Рендорим список
       list_desk.push("<div class='row request-string' data-member_key='"+ list[i].member_key +"'><div class='col-3 pl-1'><span>"+list[i].name+
       "</span><br><span>"+ data_page.category[list[i].category_key] +"</span></div><div class='col'>"+list[i].locality_name+"</div><div class='col'><span>"+list[i].cell_phone+"</span><br><span>"+list[i].email+
       "</span></div><div class='col-2'><span>"+request_status+"</span><br><span>"+list[i].send_date+"</span></div><div class='col-2'>"+decision_text+"</div></div>");
       //<div class='col-1 request-trash'>🗑</div>
     }
     $(list_id).html(list_desk);

     // открываем строку
     $(".request-string").click(function () {
       let query = "application.php?member_key=" + $(this).attr("data-member_key");
       document.cookie = "application_back=1";
       window.location = query;

     });
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
});
