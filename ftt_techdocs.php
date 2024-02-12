<?php
// Описание
require_once "preheader.php";
if ($memberId !== '000005716') {
  echo '<h1 style="margin-top: 70px; margin-left: 70px;">Пожалуйста, выберите другой раздел.</h1>';
  die();
}
// ==== CONTROLLER ==== //
$files = scandir('panelsource/techdocs/content');
// ==== VIEW ==== //
// HTML head
include_once "header2.php";

// Меню
include_once "nav2.php";
?>

<style media="screen">
#sidebar {
  overflow: hidden;
  z-index: 3;
}
#sidebar .list-group {
  min-width: 400px;
  background-color: #333;
  min-height: 100vh;
}
#sidebar i {
  margin-right: 6px;
}

#sidebar .list-group-item {
  border-radius: 0;
  background-color: #333;
  color: #ccc;
  border-left: 0;
  border-right: 0;
  border-color: #2c2c2c;
  white-space: nowrap;
}

/* highlight active menu */
#sidebar .list-group-item:not(.collapsed) {
  background-color: #222;
}

/* closed state */
#sidebar .list-group .list-group-item[aria-expanded="false"]::after {
  content: " \f0d7";
  font-family: FontAwesome;
  display: inline;
  text-align: right;
  padding-left: 5px;
}

/* open state */
#sidebar .list-group .list-group-item[aria-expanded="true"] {
  background-color: #222;
}
#sidebar .list-group .list-group-item[aria-expanded="true"]::after {
  content: " \f0da";
  font-family: FontAwesome;
  display: inline;
  text-align: right;
  padding-left: 5px;
}

/* level 1*/
#sidebar .list-group .collapse .list-group-item,
#sidebar .list-group .collapsing .list-group-item  {
  padding-left: 20px;
}

/* level 2*/
#sidebar .list-group .collapse > .collapse .list-group-item,
#sidebar .list-group .collapse > .collapsing .list-group-item {
  padding-left: 30px;
}

/* level 3*/
#sidebar .list-group .collapse > .collapse > .collapse .list-group-item {
  padding-left: 40px;
}

@media (max-width:768px) {
  #sidebar {
      min-width: 35px;
      max-width: 40px;
      overflow-y: auto;
      overflow-x: visible;
      transition: all 0.25s ease;
      transform: translateX(-45px);
      position: fixed;
  }

  #sidebar.show {
      transform: translateX(0);
  }

  #sidebar::-webkit-scrollbar{ width: 0px; }

  #sidebar, #sidebar .list-group {
      min-width: 1px;
      overflow: visible;
  }
  /* overlay sub levels on small screens */
  #sidebar .list-group .collapse.show, #sidebar .list-group .collapsing {
      position: relative;
      z-index: 1;
      width: 190px;
      top: 0;
  }
  #sidebar .list-group > .list-group-item {
      text-align: center;
      padding: .75rem .5rem;
  }
  /* hide caret icons of top level when collapsed */
  #sidebar .list-group > .list-group-item[aria-expanded="true"]::after,
  #sidebar .list-group > .list-group-item[aria-expanded="false"]::after {
      display:none;
  }
}

.collapse.show {
  visibility: visible;
}
.collapsing {
  visibility: visible;
  height: 0;
  -webkit-transition-property: height, visibility;
  transition-property: height, visibility;
  -webkit-transition-timing-function: ease-out;
  transition-timing-function: ease-out;
}
.collapsing.width {
  -webkit-transition-property: width, visibility;
  transition-property: width, visibility;
  width: 0;
  height: 100%;
  -webkit-transition-timing-function: ease-out;
  transition-timing-function: ease-out;
}
</style>
<div class="container-fluid">
    <div class="row d-flex d-md-block flex-nowrap wrapper">
        <div class="col-md-3 float-left col-1 pl-0 pr-0 collapse width show" id="sidebar">
            <div class="list-group border-0 text-center text-md-left pt-5">
              <h5 class="text-light ml-5 pt-2">Файлы</h5>
                <?php foreach ($files as $key => $value):
                    if ($value[0] !== '.'):
                      echo '<span class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-book"></i> <span class="d-none d-md-inline">'.$value.'</span></span>';
                    endif; ?>
                <?php endforeach; ?>
                <!-- <a href="#" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-book"></i> <span class="d-none d-md-inline">Item 4</span></a> -->
            </div>
        </div>
        <main class="col-md-9 float-left col px-5 pl-md-2 pt-2 main  pt-5">
            <a href="#" data-target="#sidebar" data-toggle="collapse"><i class="text-dark fa fa-navicon fa-lg py-2 p-1"></i></a>
            <div class="page-header">
                <h4 class="display_file_name float-left">Редактор</h4>
                <input id="new_file_field" class="ml-3" type="text" style="display:none;">
                <button id="new_file_btn_ok" class="ml-3" style="display:none;">OK</button>
                <div class="float-right">
                  <button id="new_file_btn_show" type="button">Новый</button>
                  <button id="save_file_btn" type="button" class="ml-3">Сохранить</button>
                </div>
            </div>
            <textarea id="text_editor" name="announcement_editor" style="width: 100%; height: 400px;"></textarea>
            <hr>
        </main>
    </div>
</div>
<img id="save_icon" src="img/save.png" height="32" style="display: none; position: fixed; bottom: 30px; right: 30px;" alt="">
<script src="extensions/nicedit/nicEdit.js"></script>
<script type="text/javascript">
/* ==== TECHDOCS START ==== */
$(document).ready(function() {
  // text editor nicEditor style

  new nicEditor().panelInstance("text_editor");
  $(".nicEdit-main").css("padding", "1px 5px").css("background-color", "#f7f7f7");
  $(".list-group-item").click(function () {
    $(".display_file_name").text($(this).text().trim());
    fetch("panelsource/techdocs/ajax/techdocs_ajax.php?type=get_file&patch=" + "../content/" + $(this).text().trim())
    .then(response => response.json())
    .then(commits => {
      nicEditors.findEditor("text_editor").setContent(commits);
    });
  });

  $("#save_file_btn").click(function () {
    if (check_data()) {
      save_file(prepare_data());
    }
  });

  $("#new_file_btn_show").click(function () {
    $("#new_file_field").show();
    $("#new_file_btn_ok").show();
    $(".display_file_name").text("");
    nicEditors.findEditor("text_editor").setContent("");
  });

  $("#new_file_btn_ok").click(function () {
    $(".display_file_name").text($("#new_file_field").val().trim());
    $("#new_file_field").hide();
    $("#new_file_btn_ok").hide();
    fetch("panelsource/techdocs/ajax/techdocs_ajax.php?type=save_file", {
      method: 'POST',
      body: prepare_data()})
    .then(response => response.text())
    .then(commits => {
      //console.log(commits);
    });
  });
  function check_data() {
    if (!$(".display_file_name").text()) {
      showError("Укажите имя файла и нажмите ОК.");
      return false;
    } else {
      return true;
    }
  }
  function save_file (data) {
    $("#save_icon").show();
    fetch("panelsource/techdocs/ajax/techdocs_ajax.php?type=save_file", {
      method: 'POST',
      body: data})
    .then(response => response.text())
    .then(commits => {
      $("#save_icon").hide();
      //console.log(commits);
      if (commits === "Data error.") {
        showError("Ошибка сохранения");
      } else if (commits === "File error.") {
        showError("Файл должен иметь расширение .txt");
      }
    });
  }
  function prepare_data() {
    let file_data = new FormData();
    let data = {
      name: $(".display_file_name").text().trim(),
      content: nicEditors.findEditor("text_editor").getContent(),
    };
    file_data.set("data", JSON.stringify(data));
    return file_data;
  }
});
</script>
  </body>
</html>
