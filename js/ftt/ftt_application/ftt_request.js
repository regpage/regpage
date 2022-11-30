$(document).ready(function(){
document.cookie = "application_back=0";
  /**** ПОВЕДЕНИЕ ЭЛЕМЕНТОВ ****/  

  // Показать / скрыть иконку сохранения
  function showSaveIcon(show) {
    if (show) {
      $("#save_icon").show();
    } else {
      $("#save_icon").hide();
    }
  }
/*
  // всплывающая подсказка при наведении
  $("[data-tooltip]").mousemove(function (eventObject) {
    console.log("I am here");
          $data_tooltip = $(this).attr("data-tooltip");
          $("#tooltip").text($data_tooltip)
                       .css({
                           "top" : eventObject.pageY + 5,
                          "left" : eventObject.pageX + 5
                       })
                       .show();

      }).mouseout(function () {

          $("#tooltip").hide()
                       .text("")
                       .css({
                           "top" : 0,
                          "left" : 0
                       });
    });

    // всплывающая подсказка при клики
    $("[data-tooltip]").click(function (eventObject) {
            $data_tooltip = $(this).attr("data-tooltip");
            $("#tooltip").text($data_tooltip)
                         .css({
                             "top" : eventObject.pageY + 5,
                            "left" : eventObject.pageX + 5
                         })
                         .show();

        }).mouseout(function () {

            $("#tooltip").hide()
                         .text("")
                         .css({
                             "top" : 0,
                            "left" : 0
                         });
      });
*/
  // кнопка назад временно не используется (удалена)
  $("#goToEventsPage").click(function(){
    window.location = $(this).attr("data-page");
  });

  // Показывать модально окно с информацией при старте.
  if (!getCookie("hide_info")) {
    $("#modalStartInfo").modal().show();
  } else {
    $("#modalStartInfo").find("button").text("Закрыть");
    $("#donotshowmethat").prop("checked", true);
  }

// Радиокнопки из чекбоксов (ИЛИ)
  $("input:checkbox").click(function(){
    let element = $(this).parent("div").parent("div");
    if ($(this).is(":checked")) {
       element.find("input:checkbox").not(this).prop("checked", false);
       //$(this).parent("div").parent("div").find("input:checkbox").not(this).prop("checked", false);
 		  //$('#group input:checkbox').not(this).prop('checked', false);
 	   }
  });
  // правило для ИНН и кода подразделения
  function ruleForInnAndKodPodrazdeleniya() {
    if ($("select[data-field=citizenship_key]").val() === "RU") {
      $("input[data-field=inn]").parent().parent().show();
    } else {
      $("input[data-field=inn]").parent().parent().hide();
    }
  }
  $("select[data-field=citizenship_key]").change(function(){
    ruleForInnAndKodPodrazdeleniya();
  });


  // Скрыть показать блоки семейного положения
  function mariageBlockRules() {
    if ($("#marriage_select").val() === "1" || !$("#marriage_select").val()) {
        $(".marriage_block").hide();
        $(".widow_block").hide();
        $(".divorce_block").hide();
        supportBlockExtraRule();

    } else if ($("#marriage_select").val() === "2") {
        $(".marriage_block").show();
        $(".widow_block").hide();
        $(".divorce_block").hide();
        supportBlockExtraRule();

    } else if ($("#marriage_select").val() === "3") {
        $(".marriage_block").hide();
        $(".widow_block").hide();
        $(".divorce_block").hide();
        supportBlockExtraRule();
    } else if ($("#marriage_select").val() === "4") {
        $(".marriage_block").hide();
        $(".widow_block").hide();
        $(".divorce_block").show();
        supportBlockExtraRule();
    } else if ($("#marriage_select").val() === "5") {
        $(".marriage_block").hide();
        $(".widow_block").show();
        $(".divorce_block").hide();
        supportBlockExtraRule();
    }
  }

// правило для псих здоровья
  function mentalProblemsBlockRule() {
    /*if ($("select[data-field=mental_problems]").val() === "yes") {
        $(".mental_problems_block").show();
        $(".mental_dependency_problems_block").show();
    } else {
        if ($("select[data-field=dependency_problems]").val() === "no" || $("select[data-field=dependency_problems]").val() === "") {
          $(".mental_dependency_problems_block").hide();
        }
        $(".mental_problems_block").hide();
    }*/
  }

  function dependencyProblemsBlockRule() {/*
    if ($("select[data-field=dependency_problems]").val() === "yes") {
        $(".dependency_problems_block").show();
        $(".mental_dependency_problems_block").show();
    } else {
      if ($("select[data-field=mental_problems]").val() === "no" || $("select[data-field=mental_problems]").val() === "") {
        $(".mental_dependency_problems_block").hide();
      }
        $(".dependency_problems_block").hide();
    }*/
  }
  // Правило показа блока иждевенцев
  function supportBlockExtraRule() {
    $(".who-extra").hide();
    let three = 0;
    $("input[data-field=support_persons]").each(function (e) {
      if (e === 3 || e === 6 || e === 9) {
        three = 0;
      }
      if ($(this).val() && !$(this).parent().parent().hasClass("who-extra")) {
        three++;
        $(".who-extra").show();
        $(this).parent().parent().show();
      } else if (three === 0 && !$(this).parent().parent().hasClass("who-extra")) {
        $(this).parent().parent().hide();
      } else if ($(this).parent().parent().hasClass("who-extra") && $(this).val()) {
        $(".who-extra").show();
      }
    });
  }
  // стилизация кнопки выгрузки картинок
  function inputFileStyle() {
    $("img").each(function () {
      if ($(this).attr("src")) {
        if ($(this).parent("a").parent("div").parent("div").find("input").attr("data-field") === "spouse_consent") {
          $(this).parent("a").parent("div").parent("div").find("input").css("width","95px");
        } else {
          $(this).parent("a").parent("div").parent("div").prev().find("input").css("width","100px");
        }
      }
    });
  }

  mariageBlockRules();
  mentalProblemsBlockRule();
  dependencyProblemsBlockRule();
  ruleForInnAndKodPodrazdeleniya();
  inputFileStyle();

  $("#add_support_block_extra").click(function () {
    if (!$(".first-extra").is(":visible")) {
      $(".first-extra").show();
      $(".who-extra").parent().next();
    } else if (!$(".second-extra").is(":visible")) {
      $(".second-extra").show();
    } else if (!$(".third-extra").is(":visible")) {
      $(".third-extra").show();
    } else if (!$(".fourth-extra").is(":visible")) {
      $(".fourth-extra").show();
    }
  });

  /**** COOKIE ****/
  $("#donotshowmethat").change(function () {
    if ($(this).is(":checked") && !getCookie("hide_info")) {
      setCookie("hide_info", 1, 365);
    } else if (!$(this).is(":checked") && getCookie("hide_info")){
      setCookie("hide_info", "", 365);
    } else if ($(this).is(":checked") && getCookie("hide_info")) {
      setCookie("hide_info", "", 365);
    } else if (!$(this).is(":checked") && !getCookie("hide_info")) {
      setCookie("hide_info", 1, 365);
    }
  });

  /**** ЗАПРОСЫ К БД ****/
  /*function quickFieldSave() {

  }*/
  // Удалить строки с иждевенцем
  $(".delete_extra_string").click(function () {
    // Показать иконку сохранения
    showSaveIcon(1);
    // скрываем строки
    $(this).parent().parent().hide();
    // очищаем поля
    $(this).parent().parent().find("input").val("");
    let counter = 0;
    // если скрыты все строки иждевения и поле о мат. обеспечении не заполнено то его также нужно скрыть иначе оставить.
    $(".support_block_extra input:visible").each(function (e) {
      /*if (!$(this).hasClass("who-extra") && $(this).val()) {
        counter += 1;
      }*/
      if ($(this).parent().parent().hasClass("who-extra") && !$(this).val()) {
        counter += 1;
      } else if (!$(this).parent().parent().hasClass("who-extra")) {
        counter += 1;
      }
      /*if (e === 11 && counter === 0) {
        $(".support_block_extra").hide();
      }*/
    });
    if (counter === 1) {
      $(".support_block_extra").hide();
    }

    let table = "ftt_request";
    let field = "support_persons";
    let value = "";
    let id = $("#main_container").attr("data-id");
    let is_guest = $("#main_container").attr("data-guest");
    // авто удаление при скрытии пользователем строки с иждевенцем
    $("input[data-field=support_persons]").each(function (e) {
        value += $(this).val() + ";" ;
        /*if (e === 12) {
          // Экранирование апострофа
          value = value.replace(/\"/g, "\'");
          fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&field="+field+"&data="+value+"&id="+id+"&guest="+is_guest)
          .then(response => response.json())
          .then(result => {
            showSaveIcon();
            if (result.result > 1) {
              $("#main_container").attr("data-id", result.result);
            }
          });
        }*/
    });
    fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&field="+field+"&data="+value+"&id="+id+"&guest="+is_guest)
    .then(response => response.json())
    .then(result => {
      console.log(result.result);
      showSaveIcon();
      if (result.result > 1) {
        $("#main_container").attr("data-id", result.result);
      }
    });
  });

  // !Внимание Лучше сохранять не на каждый символ а например через три символа и при потере фокуса, что бы не нагружать сервер.
/*
  $(".support_block_extra input").on("input", function () {

    // Показать иконку сохранения
    showSaveIcon(1);

    // Иждевение и поддержна , соединение строк
    let table = $(this).data("table");
    let field = $(this).data("field");
    let value = "";
    let id = $("#main_container").attr("data-id");
    let is_guest = $("#main_container").attr("data-guest");

    $("input[data-field=support_info]").each(function (e) {
        value += $(this).val() + ";" ;
        if (e === 12) {
          console.log(value);
          value = value.replace(/\"/g, "\'");
          fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&field="+field+"&data="+value+"&id="+id+"&guest="+is_guest)
          .then(response => response.json())
          .then(result => {
            console.log(result.result);
            showSaveIcon();
            if (result.result > 1) {
              $("#main_container").attr("data-id", result.result);
            }
          });
        }
    });
  });
*/

  // быстрое сохранение полей ТЕКСТОВЫЕ ПОЛЯ
  $("input[type=text], input[type=date], input[type=number], textarea").focusout(function(){
    let table = $(this).data("table");
    let field = $(this).data("field");
    let value = $(this).val();
    //value = value.replace(/\'/g, "\_");
    value = value.replace(/\"/g, "\'");
    let prev_value = $(this).data("value");
    let id = $("#main_container").attr("data-id");
    let is_guest = $("#main_container").attr("data-guest");
    let prepare = "";

    // Иждевение и поддержна , соединение строк
    if (field === 'support_persons') {
      value = "";
      $("input[data-field=support_persons]").each(function (e) {
          prepare = $(this).val();
          prepare = prepare.replace(/\"/g, "\'");
          value += prepare + ";";
          /*if (e === 12) {
            fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&field="+field+"&data="+value+"&id="+id+"&guest="+is_guest)
            .then(response => response.json())
            .then(result => {
              showSaveIcon();
              if (result.result > 1) {
                $("#main_container").attr("data-id", result.result);
              }
            });
          }*/
      });
    }

    // Если значения не изменились
    if (prev_value === value) {
      console.log("Same");
      return;
    }

    // Показать иконку сохранения
    showSaveIcon(1);

    // Настраиваем дату
    if (field === "birth_date") {
      //yyyy = value.slice(0,4),
			//mm = value.slice(5,7),
			//dd = value.slice(8,10);
			//value = yyyy + "-" + dd + "-" + mm;
    } else if (field === "baptized") {
      yyyy = value.slice(6, 10),
			mm = value.slice(3, 5),
			dd = value.slice(0, 2);
      //value = yyyy + "-" + dd + "-" + mm;
      let check_value = yyyy + "-" + mm + "-" + dd;
      let check_date = new Date(check_value);
      if (check_date == "Invalid Date") {
        field = 'baptize_date';
        table = 'ftt_request';
      } else {
        value = yyyy + "-" + mm + "-" + dd;
      }
    }

    if (table === "member") {
      //id = $("#member_fio").data("member_key");
      id = $("#point_member_key").attr("data-value");
      fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&field="+field+"&data="+value+"&id="+id+"&guest="+is_guest)
      .then(response => response.json())
      .then(result => {
        console.log(result.result);
        showSaveIcon();
      });
    } else {
      fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&field="+field+"&data="+value+"&id="+id+"&guest="+is_guest)
      .then(response => response.json())
      .then(result => {
        console.log(result.result);
        showSaveIcon();
        if (result.result > 1) {
          $("#main_container").attr("data-id", result.result);
        }
      });
    }
  });

  // быстрое сохранение полей СПИСКИ ВЫБОРА
  $("select").change(function(){
    let table = $(this).data("table");
    let field = $(this).data("field");
    let value = $(this).val();
    let prev_value = $(this).data("value");
    let id = $("#main_container").attr("data-id");
    let is_guest = $("#main_container").attr("data-guest");

    // Показать иконку сохранения
    showSaveIcon(1);

    if ($(this).attr("id") === "marriage_select") {
      mariageBlockRules();
    }/* else if ($(this).attr("data-field") === "mental_problems") {
      mentalProblemsBlockRule();
    } else if ($(this).attr("data-field") === "dependency_problems") {
      dependencyProblemsBlockRule();
    }*/
    // Если данные из таблицы member
    if (table === "member") {
      // id = $("#member_fio").data("member_key");
      id = $("#point_member_key").attr("data-value");

      // Обновляем страну если изменяется местность
      if (field === "locality_key") {
        let value_country_key;
        let request_id = $("#main_container").attr("data-id");
        let element = $(this);
        element.prop("disabled", true);

        // Получаем страну
        fetch("ajax/ftt_request_ajax.php?type=get_country_by_locality&locality_key="+value)
        .then(response => response.json())
        .then(result => {
          //$("#request_country_key").val(result.result);
          $("#point_country_key").val(result.result);
          showSaveIcon();
        });

        // Сохраняем страну
        setTimeout(function () {//$("#request_country_key").val()
          fetch("ajax/ftt_request_ajax.php?type=set&table=ftt_request&field=country_key&data="+$("#point_country_key").val()+"&id="+request_id+"&guest="+is_guest)
          .then(response => response.json())
          .then(result => {
            element.prop('disabled', false);
            if (result.result > 1) {
              $("#main_container").attr("data-id", result.result);
            }
        });
        }, 1000);
      }
    }
    // Сохраняем поле
    fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&data="+value+"&field="+field+"&id="+id+"&guest="+is_guest)
    .then(response => response.json())
    .then(result => {
      console.log(result.result);
      if (result.result > 1) {
        $("#main_container").attr("data-id", result.result);
      }
      showSaveIcon();
    });
  });

  // быстрое сохранение полей RADIO
  $("input[type=radio]").change(function(){
    let table = $(this).parent().parent().parent().attr('data-table');
    let field = $(this).parent().parent().parent().attr('data-field');
    let value = $(this).val();
    let id = $("#main_container").attr("data-id");
    let is_guest = $("#main_container").attr("data-guest") || 0;

    fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&field="+field+"&data="+value+"&id="+id+"&guest="+is_guest)
    .then(response => response.json())
    .then(result => console.log(result.result));
  });

  // быстрое сохранение полей ЧЕКБОКСЫ
  $("input[type=checkbox]").change(function(){
    if ($(this).attr("id") === "donotshowmethat") {
      console.log("does not require a request");
      return;
    }
    /*if (!$(this).is(":checked") && $(this).attr("id") !== "policy_agree") {
      console.log("Isn\'t checked");
      return;
    }*/
    let table;
    let field;
    let value;
    let id = $("#main_container").attr("data-id");
    let is_guest = $("#main_container").attr("data-guest") || 0;
    //let  member_key = $("#point_member_key").attr("data-value");

    // GROUP / REGULAR
    if ($(this).attr("data-table")) { // REGULAR
      table = $(this).data('table');
      field = $(this).data('field');
      value = 0;
      if ($(this).prop("checked")) {
        value = 1;
      }
    } else { // GROUP
      table = $(this).parent().parent().parent().attr('data-table');
      field = $(this).parent().parent().parent().attr('data-field');
      value = "";
      $(this).parent().parent().parent().find('input:checked').each(function () {
        if (value) {
          value = value + "," + $(this).val();
        } else {
          value = $(this).val();
        }
      });
    }

    fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&field="+field+"&data="+value+"&id="+id+"&guest="+is_guest)
    .then(response => response.json())
    .then(result => console.log(result.result));
  });

  // Upload a file
  $("input[type=file]").change(function(){
    // variables
    let formData = new FormData();
    let element = $(this);
    let field = $(this).data('field');
    let id;
    let is_guest = $("#main_container").attr("data-guest");
    let next_blob = "";

    if (!$(this)[0].files[0]) {
      console.log('Blob empty');
      return
    }
    for (var i = 0; i < $(this)[0].files.length; i++) {
      // Показать иконку сохранения
      showSaveIcon(1);
      // второй и третий блоб для загрузки
      if (i === 1) {
        next_blob = 1;
      } else if (i === 2) {
        next_blob = 2;
      }
      // если бланк не существует пытаемся получить id на второй итерации
      id = $("#main_container").attr("data-id");
      formData.append('blob', $(this)[0].files[i]);
      fetch("ajax/ftt_request_ajax.php?type=set_blob&field="+field+"&id="+id+"&guest="+is_guest+"&next_blob="+next_blob, {
  						method: 'POST',
    						body: formData
  		})
      .then(response => response.json())
      .then(result => {
        console.log(result.result);
        if (result.result > 1) {
          $("#main_container").attr("data-id", result.result);
        }
        showSaveIcon(false);
        updatePicOnThePage(field);
        element.css("color","black");
      });
    }

    // Отобразить загруженные картинки
    function updatePicOnThePage(field) {
      showSaveIcon(1);
      fetch("ajax/ftt_request_ajax.php?type=get_pic&field="+field+"&id="+id)
      .then(response => response.json())
      .then(result => {
        if (field === "passport_scan") {
          element.parent().parent().next().find("img").each(function (e) {
          $(this).attr("src",result.result[e]);
          $(this).parent().attr("href",result.result[e]);
          if (result.result[e]) {
            $(this).parent().parent().show();
            $(this).parent().parent().find("i").show();
          }
          });
        } else {
          element.parent().parent().find("img").attr("src",result.result[0]);
          element.parent().parent().find("a").attr("href",result.result[0]);
          element.parent().parent().find("i").show();
        }
        showSaveIcon(false);
      });
    }
  });

  // Поведение иконок удаления картинок
  $(".pic-delete").each(function () {
    if ($(this).parent().find("a").attr("href")) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });

  // удаление картинок
  $(".pic-delete").click(function () {
    let id = $("#main_container").attr("data-id");
    let field;
    if ($(this).parent().parent().find("input[type=file]").attr("data-field")) {
      field = $(this).parent().parent().find("input[type=file]").attr("data-field");
    } else {
      field = $(this).parent().parent().prev().find("input[type=file]").attr("data-field");
    }

    let element = $(this);
    if ($(this).parent().index() === 1 && field === "passport_scan") {
      field += "_2";
    } else if ($(this).parent().index() === 2 && field === "passport_scan") {
      field += "_3";
    }
    fetch("ajax/ftt_request_ajax.php?type=delete_pic&field="+field+"&id="+id)
    .then(response => response.json())
    .then(data => {
      showSaveIcon();
      if (data) {
        if (field !== "spouse_consent") {
          element.parent().hide();
        }
        element.hide();
        element.parent().find("a").attr("href","");
        element.parent().find("img").attr("src","");
        element.parent().parent().find("input[type=file]").val("");
      }
    });
  });

  // Удалние заявления из модального окна
  $("#btnMdlDeleteMyRequest").click(function () {
    let id = $("#main_container").attr("data-id");
    showSaveIcon(1);
    fetch("ajax/ftt_request_ajax.php?type=to_trash_request&id="+id)
    .then(response => response.json())
    .then(data => {
      showSaveIcon();
      if (data) {
        window.location = 'index';
      }
    });
  });

  // Валидация при отправке
  function validationFields() {
    showSaveIcon(true);
    let has_error = 0, check_extra;
/*
    // Проверка доп. блоков иждененцев
    // Можно автоматом переберать доп блоки исключая последний
    function checkExtraField(extra_block) {
      let check_extra = false;
      extra_block.find("input").each(function (e) {
        if ($(this).val()) {
          check_extra = true;
        }
        if (e === 2 && !check_extra) {
          extra_block.hide();
        } else if (e === 2 && check_extra) {
          if (!$(".who-extra").is(":visible")) {
            $(".who-extra").show();
          }
          check_extra = false;
        }
      });
    }

    // Проверка доп. блоков иждененцев
    $(".support_block_extra:visible").each(function (e) {
      if (e === 0 && $(".who-extra").is(":visible")) {
        $(".who-extra").hide();
      }
      if (e < 4){
        checkExtraField($(this));
      }
    });
*/
    // проверка полей паспортов. Если национальный заполнен значит загран не обязателен.
    if ($("input[data-field=document_date]").val() && $("input[data-field=document_num]").val()) {
      if ($("input[data-field=tp_num]").attr("required")) {
        $("input[data-field=tp_num]").css("border-color", "black");
        $("input[data-field=tp_auth]").css("border-color", "black");
        $("input[data-field=tp_date]").css("border-color", "black");
      }
      $("input[data-field=tp_num]").removeAttr("required");
      $("input[data-field=tp_auth]").removeAttr("required");
      $("input[data-field=tp_date]").removeAttr("required");
    } else {
      if (!$("input[data-field=tp_num]").attr("required")) {
        $("input[data-field=tp_num]").attr("required", true);
        $("input[data-field=tp_auth]").attr("required", true);
        $("input[data-field=tp_date]").attr("required", true);
      }
    }

    // проверка чекбоксов брат сестра
    /*
    if ($("#brother").prop("checked") || $("#sister").prop("checked")) {

    } else {
      showError("Заполните все обязательные поля!");
      $("#brother").parent().find("label").css("border","2px solid red");
      $("#sister").parent().find("label").css("border","2px solid red");
      has_error++;
    }
    */
    $("input[required]:visible").each(function () {
      if ($(this).attr("type") === "checkbox") {
        if ($(this).attr("id") === "policy_agree" && !$(this).prop("checked")) {
          showError("Заполните все обязательные поля!");
          $(this).parent().find("label").css("border","2px solid red");
          has_error++;
        }
      } else if ($(this).attr("type") === "file") {
        let check_check;
        check_check = "error";
        if ($(this).attr("data-field") === "passport_scan") {
          // ПАСПОРТ, СКАНЫ
          $(this).parent().parent().next().find("img").each(function () {
            if ($(this).attr("src")) {
              check_check = "ok";
            }
          });
          if (!$(this).val() && check_check === "error") {
            showError("Заполните все обязательные поля!");
            $(this).css("color","red");
            $(this).css("width","auto");
            has_error++;
          }
        } else {
          // СОГЛАСИЕ СУПРУГА
          if ($(this).parent().parent().find("img").attr("src")) {
            console.log(check_check);
            check_check = "ok";
          }

          if (!$(this).val() && check_check === "error") {
            showError("Заполните все обязательные поля!");
            $(this).css("color","red");
            $(this).css("width","auto");
            has_error++;
          }
        }
      } else {
        if (!$(this).val()) {
          showError("Заполните все обязательные поля!");
          $(this).css("border-color","red");
          has_error++;
        }
      }

    });
    $("select[required]:visible").each(function () {
      if (!$(this).val()) {
        showError("Заполните все обязательные поля!");
        $(this).css("border-color","red");
        has_error++;
      }
    });
    $("textarea[required]").each(function () {
      if (!$(this).val()) {
        showError("Заполните все обязательные поля!");
        $(this).css("border-color","red");
        has_error++;
      }
    });
    showSaveIcon();
    return has_error;
  }

  // Отправка заявления
  // Валидация
  $("#toModalSendMyRequest").click(function (e) {

    if (validationFields()) {
      e.stopPropagation();
      return;
    }
  });
  // Отправка
  $("#btnMdlSendMyRequest").click(function () {
    let id = $("#main_container").attr("data-id");
    showSaveIcon(1);
    // applicant
    if (data_page.role === "0" && data_page.applicant === "1") {
      fetch("ajax/ftt_request_ajax.php?type=to_send_request&id="+id)
      .then(response => response.json())
      .then(data => {
        if (data) {
          blockApplicationFields();
          $("#main_container").attr("data-status", "2");
          showHint("Заявление отправлено служащим Полновременного обучения в Москве.");
        }
      });
    } else if (data_page.role === "1") { // recommendator
      fetch("ajax/ftt_request_ajax.php?type=recommendation&id="+id)
      .then(response => response.json())
      .then(data => {
        if (data) {
          blockApplicationFields();
          $("#main_container").attr("data-status", "3");
          showHint("Заявление отправлено служащим Полновременного обучения в Москве.");
        }
      });
    }
    showSaveIcon();
  });
  // МАСТЕР (ВИЗАРД)
  // Следующий, Предыдущий.
  $("#next_step").click(function () {
    if ($(".wizard_step:visible").next().is(":hidden")) {
      let elem = $(".wizard_step:visible").next();
      setCookie("wizard_step", elem.attr("id"));
      $(".wizard_step:visible").hide().next().show();
      $("#wizard_pagination .link_custom_active").removeClass("link_custom_active");
      $("#wizard_pagination .link_custom[data-step='"+elem.attr("id")+"']" ).addClass("link_custom_active");
      $("html").animate({scrollTop:0}, '250');
    }
  });
  $("#prev_step").click(function () {
    if ($(".wizard_step:visible").prev().is(":hidden")) {
      let elem = $(".wizard_step:visible").prev();
      setCookie("wizard_step", elem.attr("id"));
      $(".wizard_step:visible").hide().prev().show();
      $("#wizard_pagination .link_custom_active").removeClass("link_custom_active");
      $("#wizard_pagination .link_custom[data-step='"+elem.attr("id")+"']" ).addClass("link_custom_active");
      $("html").animate({scrollTop:0}, '250');
    }
  });

  // Пагинация
  $("#wizard_pagination .link_custom").click(function () {
    if ($(this).hasClass("link_custom_active")) {
      return;
    } else {
      $("#wizard_pagination .link_custom_active").removeClass("link_custom_active");
      $(this).addClass("link_custom_active");
      $(".wizard_step").hide();
      $("#"+$(this).attr("data-step")).show();
      setCookie("wizard_step", $(this).attr("data-step"));
      $("html").animate({scrollTop:0}, '250');
    }
  });
}); // END document ready
