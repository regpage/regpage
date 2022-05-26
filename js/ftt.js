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

     list_id = "#requests-list";

     if (guest) {
       list_id = "#requests-guest-list";
     }

     console.log(list);
     let list_desk = [];
     for (var i = 0; i < list.length; i++) {
       // подготавливаем данные
       let request_status = "";
       if (list[i].request_status == 1) {
         request_status = "Черновик";
       } else if (list[i].request_status == 2) {
         request_status = "Отправлен";
       }
       //Рендорим список
       list_desk.push("<hr><div class='row request-string' data-member_key='"+ list[i].member_key +"'><div class='col-3'><span>"+list[i].name+
       "</span><br><span>"+ data_page.category[list[i].category_key] +"</span></div><div class='col'>"+list[i].locality_name+"</div><div class='col'><span>"+list[i].cell_phone+"</span><br><span>"+list[i].email+
       "</span></div><div class='col-2'><span>"+request_status+"</span><br><span>"+list[i].send_date+"</span></div><div class='col-2'>"+list[i].decision+"</div><div class='col-1 request-trash'>🗑</div></div>");
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

  // Получаем заявления гостей
  fetch("ajax/ftt_ajax.php?type=all_requests&guest=1&role="+$("#list_requests").attr("data-role"))
  .then(response => response.json())
  .then(result => rendoringListOfRequests(result.result, true));

});
