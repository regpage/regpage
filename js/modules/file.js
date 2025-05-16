/* перечислить
поля,
классы и
id
необходимые для работы модуля
ПЕРЕДАВАТЬ ПУТИ (РАЗДЕЛ + КОМАНДА) ДО AJAX сейчас привязан prophecy
 */
// PICS
// предосмотр картинки
$(".modal_btn_pic_preview_open").click(function () {
  show_pic_preview($(this));
});
// рендеринг панели управления прикреплёнными изображениями
function render_files_bar(id, path) {
  if (path) {
    let result_arr = path.split(";");
    for (var i = 0; i < result_arr.length; i++) {
      $("#modal_container_pics").append('<div class="col-10"><button type="button" data-toggle="modal" class="modal_btn_pic_preview_open btn btn-primary btn-sm mr-2 mb-2">Посмотреть файл</button><a class="modal_link_donwload_pic" href="' + result_arr[i] + '" target="_blank">скачать файл</a></div>'
      + '</div><div class="col-2 text-right"><i class="fa fa-trash text-danger cursor-pointer modal_pic_btn_delete mr-3" aria-hidden="true" style="font-size: 1.5rem;"></i></div>');
    }
    $(".modal_pic_btn_delete").click(function () {
      pic_delete($(this), id);
    });
    $(".modal_btn_pic_preview_open").click(function () {
      show_pic_preview($(this));
    });
  }
}

// set pics
function modal_file_upload(id, file_field_id) {
  let extrahelp_data_blank = new FormData();

  if (file_field_id[0].files[0]) {
    for (var i = 0; i < file_field_id[0].files.length; i++) {
      extrahelp_data_blank.set("blob"+i, file_field_id[0].files[i]);
    }
    $("#spinner_upload").show();
    fetch("api_ftt.php?section=prophecy&type=set_pic&id=" + id, {
      method: 'POST',
      body: extrahelp_data_blank
    })
    .then(response => response.json())
    .then(commits => {
      $("#spinner_upload").hide();
      if (commits.result[1][0] === "Н") {
        showError(commits.result[1]);
      } else if (commits.result[1]) {
        file_field_id.parent().css("border", "none");
        let result_arr = commits.result[1];
        result_arr = result_arr.split(";");
        let list_pics_lenght = 0;
        $(".modal_pic_btn_delete").each(function () {
          list_pics_lenght++;
        });
        for (let i = 0; i < result_arr.length; i++) {
          list_pics_lenght++;
          let res = $("#modal_container_pics").append('<div class="col-10"><button type="button" data-toggle="modal" class="btn btn-primary btn-sm mr-2 mb-2 modal_btn_pic_preview_open">Посмотреть файл</button><a class="modal_link_donwload_pic" href="' + result_arr[i] + '" target="_blank">скачать файл</a></div>'
          + '</div><div class="col-2 text-right"><i id="modal_pic_btn_dlt_'+list_pics_lenght+'" class="fa fa-trash text-danger cursor-pointer modal_pic_btn_delete mr-3" aria-hidden="true" style="font-size: 1.5rem;"></i></div>');

          $("#modal_pic_btn_dlt_"+list_pics_lenght).click(function () {
            pic_delete($(this), id);
          });
        }
        // предосмотр катринки
        $(".modal_btn_pic_preview_open").click(function () {
          show_pic_preview($(this));
        });
      }
    });
  }
}

// удалить картинку
function pic_delete(elem, id) {
  let patch = elem.parent().prev().find(".modal_link_donwload_pic").attr("href");
  if (!patch) {
    element.prev().remove();
    element.remove();
    return;
  }
  //let id = elem.attr("data-id");
  let element = elem.parent();
  // УДАЛЕНИЕ КАРТИНКИ
  fetch("api_ftt.php?section=prophecy&type=delete_pic&id=" + id + "&patch=" + patch)
  .then(response => response.json())
  .then(data => {
    if (data) {
      element.prev().remove();
      element.remove();      
    }
  });
}

// показать превью
function show_pic_preview(elem) {
  if (!$("#modal_pic_preview_temp").length) {
    $("body").append('<div id="modal_pic_preview_temp" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-xl"><div class="modal-content"><div class="modal-header"><button type="button" class="close pt-1 pb-1" data-dismiss="modal" aria-hidden="true">x</button></div><div class="modal-body"><img id="modal_pic_preview_container_temp" class="w-100" src="" alt=""></div></div></div></div>');
  }
  $("#modal_pic_preview_container_temp").attr("src", elem.next().attr("href"));
  $("#modal_pic_preview_temp").modal("show")
}

function reset_modal_file_block() {
  $("#modal_container_pics").html("");
}
