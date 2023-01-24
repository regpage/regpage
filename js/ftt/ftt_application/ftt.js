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
       list_desk.push("<hr><div class='row request-string' data-member_key='"+ list[i].member_key +"'><div class='col-3'><span>"+list[i].name+
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
  fetch("ajax/ftt_ajax.php?type=all_requests&guest=0&role="+$("#list_requests").attr("data-role"))
  .then(response => response.json())
  .then(result => rendoringListOfRequests(result.result));

  setTimeout(function () {
    // Получаем заявления гостей
    fetch("ajax/ftt_ajax.php?type=all_requests&guest=1&role="+$("#list_requests").attr("data-role"))
    .then(response => response.json())
    .then(result => rendoringListOfRequests(result.result, true));
  }, 50);
});
