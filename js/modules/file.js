// PICS
// pic
$(".ftt_extra_help_string").click(function () {
  if ($(this).attr("data-file")) {
    let result_arr = $(this).attr("data-file");
    result_arr = result_arr.split(";")
    for (var i = 0; i < result_arr.length; i++) {
      $("#extrahelp_pic").append('<div class="col-10"><button type="button" data-toggle="modal" class="extrahelp_modal_pic_preview_open btn btn-primary btn-sm mr-2 mb-2" data-target="#extrahelp_modal_pic_preview">Посмотреть файл</button><a class="extrahelp_pic" href="' + result_arr[i] + '" target="_blank">скачать файл</a></div>'
      + '</div><div class="col-2 text-right"><i class="fa fa-trash text-danger cursor-pointer pic_extrahelp_delete mr-3" aria-hidden="true" style="font-size: 1.5rem;"></i></div>');
    }
    $(".pic_extrahelp_delete").click(function () {
      pic_delete($(this));
    });
    $(".extrahelp_modal_pic_preview_open").click(function () {
      show_pic_preview($(this));
    });
  }
});

// set pics
// pic
$("#extrahelp_modal_file").change(function () {
let id = $("#modalAddEditExtraHelp").attr("data-id");
let extrahelp_data_blank = new FormData();

if ($("#extrahelp_modal_file")[0].files[0]) {
  for (var i = 0; i < $("#extrahelp_modal_file")[0].files.length; i++) {
    extrahelp_data_blank.set("blob"+i, $("#extrahelp_modal_file")[0].files[i]);
  }
  $("#spinner_upload").show();
  fetch("ajax/ftt_extra_help_ajax.php?type=set_pic&id=" + id, {
    method: 'POST',
    body: extrahelp_data_blank
  })
  .then(response => response.json())
  .then(commits => {
    $("#spinner_upload").hide();
    if (commits.result[1][0] === "Н") {
      showError(commits.result[1]);
    } else if (commits.result[1]) {
      $("div[data-id='" + id + "']").attr("data-file", commits.result[0]);
      $("#extrahelp_modal_file").parent().css("border", "none");
      let result_arr = commits.result[1];
      result_arr = result_arr.split(";");
      let list_pics_lenght = 0;
      $(".pic_extrahelp_delete").each(function () {
        list_pics_lenght++;
      });
      for (let i = 0; i < result_arr.length; i++) {
        list_pics_lenght++;
        let res = $("#extrahelp_pic").append('<div class="col-10"><button type="button" data-toggle="modal" class="btn btn-primary btn-sm mr-2 mb-2 extrahelp_modal_pic_preview_open" data-target="#extrahelp_modal_pic_preview">Посмотреть файл</button><a class="extrahelp_pic" href="' + result_arr[i] + '" target="_blank">скачать файл</a></div>'
        + '</div><div class="col-2 text-right"><i id="extrahelp_dlt_btn_'+list_pics_lenght+'" class="fa fa-trash text-danger cursor-pointer pic_extrahelp_delete mr-3" aria-hidden="true" style="font-size: 1.5rem;"></i></div>');

        $("#extrahelp_dlt_btn_"+list_pics_lenght).click(function () {
          pic_delete($(this));
        });
      }

      $(".extrahelp_modal_pic_preview_open").click(function () {
        show_pic_preview($(this));
      });
    }
  });
}
});

// удалить картинку
function pic_delete(elem) {
let patch = elem.parent().prev().find(".extrahelp_pic").attr("href");
if (!patch) {
  element.prev().remove();
  element.remove();
  return;
}
let id = $("#modalAddEditExtraHelp").attr("data-id");
let element = elem.parent();
// УДАЛЕНИЕ КАРТИНКИ
fetch("ajax/ftt_extra_help_ajax.php?type=delete_pic&id=" + id + "&patch=" + patch)
.then(response => response.json())
.then(data => {
  if (data) {
    element.prev().remove();
    element.remove();
    let pathes = $("div[data-id='" + id + "']").attr("data-file");
    let check = "";
    pathes = pathes.split(";");
    for (let i = 0; i < pathes.length; i++) {
      if (pathes[i] === patch) {
        check = i;
        break;
      }
    }
    pathes.splice(check, 1);
    $("div[data-id='" + id + "']").attr("data-file", pathes.join(";"));
  }
});
}

$(".extrahelp_modal_pic_preview_open").click(function () {
show_pic_preview($(this));
});

function show_pic_preview(elem) {
$("#extrahelp_modal_pic_preview_container").attr("src", elem.next().attr("href"));
}
