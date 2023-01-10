$(document).ready(function(){
document.cookie = "application_back=0";
  /**** ПОВЕДЕНИЕ ЭЛЕМЕНТОВ ****/
radio_buttons_behavior()
// COOKIE

if (getCookie("application_check") === '1') {
  validationFields();
  setCookie("application_check") === '0'
}

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
  if (localStorage.getItem('hide_info') === "1") {
    //!getCookie("hide_info")
    $("#modalStartInfo").modal().show();
  } else {
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
    if (!$("#point_marital_status").val() ||
    $("#point_marital_status").val() === "не состояла в браке" ||
    $("#point_marital_status").val() === "не состоял в браке" ||
    $("#point_marital_status").val() === "помолвлена" ||
    $("#point_marital_status").val() === "помолвлен") {
      $("#point_marital_info").parent().parent().hide();
      $("#point_spouse_name").parent().parent().hide();
      $("#point_spouse_age").parent().parent().hide();
      $("#point_spouse_occupation").parent().parent().hide();
      $("#point_spouse_faith").parent().parent().hide();
      $("#point_spouse_church").parent().parent().hide();
      $("#point_spouse_state").parent().parent().hide();
      $("#point_spouse_plans").parent().parent().hide();
      $("#point_spouse_consent").parent().parent().hide();
      supportBlockExtraRule(1);
    } else if ($("#point_marital_status").val() === "состою в браке") {
      $("#point_marital_info").parent().parent().find(".title_point").text("Дата заключения брака");
      $("#point_marital_info").parent().parent().show();
      $("#point_spouse_name").parent().parent().show();
      $("#point_spouse_age").parent().parent().show();
      $("#point_spouse_occupation").parent().parent().show();
      $("#point_spouse_faith").parent().parent().show();
      $("#point_spouse_church").parent().parent().show();
      $("#point_spouse_state").parent().parent().show();
      $("#point_spouse_plans").parent().parent().show();
      $("#point_spouse_consent").parent().parent().show();
      supportBlockExtraRule();
    } else if ($("#point_marital_status").val() === "разведена" || $("#point_marital_status").val() === "разведён") {
      $("#point_marital_info").parent().parent().find(".title_point").text("Дата развода");
      $("#point_marital_info").parent().parent().show();
      $("#point_spouse_name").parent().parent().hide();
      $("#point_spouse_age").parent().parent().hide();
      $("#point_spouse_occupation").parent().parent().hide();
      $("#point_spouse_faith").parent().parent().hide();
      $("#point_spouse_church").parent().parent().hide();
      $("#point_spouse_state").parent().parent().hide();
      $("#point_spouse_plans").parent().parent().hide();
      $("#point_spouse_consent").parent().parent().hide();
      supportBlockExtraRule();
    } else if ($("#point_marital_status").val() === "вдова" || $("#point_marital_status").val() === "вдовец") {
      $("#point_marital_info").parent().parent().find(".title_point").text("С какого времени");
      $("#point_marital_info").parent().parent().show();
      $("#point_spouse_name").parent().parent().hide();
      $("#point_spouse_age").parent().parent().hide();
      $("#point_spouse_occupation").parent().parent().hide();
      $("#point_spouse_faith").parent().parent().hide();
      $("#point_spouse_church").parent().parent().hide();
      $("#point_spouse_state").parent().parent().hide();
      $("#point_spouse_plans").parent().parent().hide();
      $("#point_spouse_consent").parent().parent().hide();
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
  function supportBlockExtraRule(hide) {
    if ($("#radio_point_support_0").prop("checked") && !hide) {
      $("#point_support_info").parent().parent().show();
      $("#add_support_block_extra").parent().parent().parent().parent().show();
    } else if ($("#radio_point_support_1").prop("checked")) {
      $("#point_support_info").parent().parent().hide();
      $("#add_support_block_extra").parent().parent().parent().parent().hide();
    } else {
      $("#point_support_info").parent().parent().hide();
      $("#add_support_block_extra").parent().parent().parent().parent().hide();
    }

    let three = 0;
    $("input[data-field=support_persons]").each(function (e) {
      if (e === 3 || e === 6 || e === 9) {
        three = 0;
      }
      if ($(this).val()) {
        three++;
        $(this).parent().parent().show();
      } else if (three === 0) {
        $(this).parent().parent().hide();
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

  // ПОВЕДЕНИЕ БЛОКОВ
  function hide_for_guest() {
    $("#radio_point_semester_0").parent().parent().parent().parent().parent().hide();
    $("#radio_point_will_be_two_years_0").parent().parent().parent().parent().parent().hide();
    $("#point_semester_pay").parent().parent().prev().prev().hide();
  }

  function hide_for_candidate() {
    $("#point_semester_pay").parent().parent().prev().hide();
  }

  function radio_buttons_behavior() {
    if ($("#radio_point_will_be_two_years_0").prop("checked")) {
      $("#point_how_many_semesters").parent().parent().hide();
      $("#point_how_many_explanation").parent().parent().hide();
    } else if ($("#radio_point_will_be_two_years_1").prop("checked")) {
      $("#point_how_many_semesters").parent().parent().show();
      $("#point_how_many_explanation").parent().parent().show();
    } else {
      $("#point_how_many_semesters").parent().parent().hide();
      $("#point_how_many_explanation").parent().parent().hide();
    }
    if ($("#radio_point_health_question40_0").prop("checked")) {
      $("#point_health_question41").parent().parent().show();
    } else if ($("#radio_point_health_question40_1").prop("checked")) {
      $("#point_health_question41").parent().parent().hide();
    } else {
      $("#point_health_question41").parent().parent().hide();
    }
    if ($("#radio_point_food_question7_0").prop("checked")) {
      $("#radio_point_health_question50_1").parent().parent().parent().parent().parent().show();
    } else if ($("#radio_point_food_question7_1").prop("checked")) {
      $("#radio_point_health_question50_1").parent().parent().parent().parent().parent().hide();
    } else {
      $("#radio_point_health_question50_1").parent().parent().parent().parent().parent().hide();
    }
    andOrCondition();
  }

  function andOrCondition() {
    if (!$("#main_container").attr("data-guest") && $("#radio_point_semester_0").prop("checked")) {
      $("#radio_point_will_be_two_years_0").parent().parent().parent().parent().parent().show();
    } else {
      $("#radio_point_will_be_two_years_0").parent().parent().parent().parent().parent().hide();
    }
  }

  function select_behavior() {
    if ($("#point_citizenship_key").val() === "RU") {
      $("#point_passport_exp").parent().parent().hide();
      $("#point_document_dep_code").parent().parent().show();
      $("#point_snils").parent().parent().show();
      $("#point_inn").parent().parent().show();
      $("#radio_point_reg_document_0").parent().parent().parent().parent().parent().hide();
    } else {
      $("#point_passport_exp").parent().parent().show();
      $("#point_document_dep_code").parent().parent().hide();
      $("#point_snils").parent().parent().hide();
      $("#point_inn").parent().parent().hide();
      $("#radio_point_reg_document_0").parent().parent().parent().parent().parent().show();
    }

    if ($("#point_church_life_period").val() === "не участвовал" || $("#point_church_life_period").val() === "не участвовала") {
      $("#point_church_life_date").parent().parent().hide();
      $("#point_first_church_life_city").parent().parent().hide();
      $("#point_next_church_life_city").parent().parent().hide();
      $("#point_church_life_city").parent().parent().hide();
      $("#point_church_life_city_when").parent().parent().hide();
      $("#point_church_service").parent().parent().hide();
    } else {
      $("#point_passport_exp").parent().parent().show();
      $("#point_first_church_life_city").parent().parent().show();
      $("#point_next_church_life_city").parent().parent().show();
      $("#point_church_life_city").parent().parent().show();
      $("#point_church_life_city_when").parent().parent().show();
      $("#point_church_service").parent().parent().show();
    }
  }

  function point_driver_license () {
    let point_driver_license = $("#point_driver_license").val();
    if (!point_driver_license || point_driver_license[0] === "н" || point_driver_license[0] === "Н") {
      $("#point_driving_experience").parent().parent().hide();
    } else {
      $("#point_driving_experience").parent().parent().show();
    }
  }

  if ($("#main_container").attr("data-guest") === "1") {
    hide_for_guest();
  } else {
    hide_for_candidate();
  }
  mariageBlockRules();
  supportBlockExtraRule();
  mentalProblemsBlockRule();
  dependencyProblemsBlockRule();
  ruleForInnAndKodPodrazdeleniya();
  point_driver_license();
  inputFileStyle();
  // radio_buttons_behavior(); перенесён в начало
  select_behavior();
  andOrCondition();
  $("#point_country_key").attr("disabled", true);

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
    if ($(this).is(":checked")) {
      localStorage.setItem('hide_info', "");
      //setCookie("hide_info", 1, 365);
    } else if (!$(this).is(":checked")) {
      //setCookie("hide_info", "", 365);
      localStorage.setItem('hide_info', "1");
    }
  });

  /**** ЗАПРОСЫ К БД ****/
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
      //console.log(result.result);
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
  function quickly_save_input(element) {
    if ($("#main_container").attr("data-status") > 0 && window.adminId === $("#point_member_key").attr("data-value")) {
      return;
    }
    if (element.hasClass("required_field") && element.val() && element.attr("required")) {
      element.removeClass("required_field");
    } else if (!element.hasClass("required_field") && !element.val() && element.attr("required")) {
      element.addClass("required_field");
    }

    if (element.attr("id") === "point_driver_license") {
      point_driver_license ();
    }

    if (element.next().next().hasClass("set_no") && element.next().next().is(":visible") && element.val()) {
      element.next().next().hide();
    } else if (element.next().next().hasClass("set_no") && !element.next().next().is(":visible") && !element.val()) {
      element.next().next().show();
    }

    let table = element.data("table");
    let field = element.data("field");
    let value = element.val();
    //value = value.replace(/\'/g, "\_");
    value = value.replace(/\"/g, "\'");
    let prev_value = element.attr("data-value");
    let id = $("#main_container").attr("data-id");
    let is_guest = $("#main_container").attr("data-guest");
    let prepare = "";

    // Иждевение и поддержна , соединение строк
    if (field === 'support_persons') {
      value = "";
      $("input[data-field=support_persons]").each(function (e) {
          prepare = element.val();
          prepare = prepare.replace(/\"/g, "\'");
          value = value + prepare + ";";
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
      let formData = new FormData();
      formData.append('data_post', value);
      id = $("#point_member_key").attr("data-value");
      if (!$("#main_container").attr("data-id") && !id) {
        id = window.adminId;
        let field_request = $("#point_another_names").val();
        fetch("ajax/ftt_request_ajax.php?type=set&table=ftt_request&field=another_names&data="+field_request+"&id=&guest="+is_guest)
        .then(response => response.json())
        .then(result => {
          //console.log(result.result);
          if (result.result > 1) {
            $("#main_container").attr("data-id", result.result);
          }
        });
      }
      fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&field="+field+"&data="+value+"&id="+id+"&guest="+is_guest, { method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(result => {
        //console.log(result.result);
        showSaveIcon();
      });
    } else {
      let formData = new FormData();
      formData.append('data_post', value);
      fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&field="+field+"&data="+value+"&id="+id+"&guest="+is_guest, {
					method: 'POST',
					body: formData
        })
      .then(response => response.json())
      .then(result => {
        //console.log(result.result);
        showSaveIcon();
        if (result.result > 1) {
          $("#main_container").attr("data-id", result.result);
        }
      });
    }
  }


  $("input[type=text], input[type=date], input[type=number], textarea").focusout(function(){
    quickly_save_input($(this));
  });

  // быстрое сохранение полей СПИСКИ ВЫБОРА
  $("select").change(function(){
    let table = $(this).data("table");
    let field = $(this).data("field");
    let value = $(this).val();
    let prev_value = $(this).data("value");
    let id = $("#main_container").attr("data-id");
    let is_guest = $("#main_container").attr("data-guest");
    select_behavior();
    // Показать иконку сохранения
    showSaveIcon(1);

    if ($(this).attr("id") === "point_marital_status") {
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
      //console.log(result.result);
      if (result.result > 1) {
        $("#main_container").attr("data-id", result.result);
      }
      showSaveIcon();
    });
  });

  // быстрое сохранение полей RADIO
  $("input[type=radio]").change(function(){
    if ($(this).parent().parent().parent().hasClass("required_field")) {
      $(this).parent().parent().parent().removeClass("required_field").css("padding-bottom", "2px");
    }
    $(this).parent().parent().parent().attr("data-value", $(this).val());
    let table = $(this).parent().parent().parent().attr('data-table');
    let field = $(this).parent().parent().parent().attr('data-field');
    let value = $(this).val();
    let id = $("#main_container").attr("data-id");
    let is_guest = $("#main_container").attr("data-guest") || 0;
    radio_buttons_behavior();
    supportBlockExtraRule();
    fetch("ajax/ftt_request_ajax.php?type=set&table="+table+"&field="+field+"&data="+value+"&id="+id+"&guest="+is_guest)
    .then(response => response.json())
    .then(result => {
        console.log(result.result)
        if (result.result > 1) {
          $("#main_container").attr("data-id", result.result);
        }
      });
  });

  // быстрое сохранение полей ЧЕКБОКСЫ
  $("input[type=checkbox]").change(function(){
    if ($(this).attr("id") === "donotshowmethat") {
      return;
    }
    if ($(this).next().hasClass("required_field") && $(this).prop("checked")) {
      $(this).next().removeClass("required_field").css("padding-bottom", "2px");
    } else if (!$(this).next().hasClass("required_field") && !$(this).prop("checked")) {
      $(this).next().addClass("required_field").css("padding-bottom", "0px");
    }
    // блоки рекомендации и собеседования
    if ($(this).attr("id") === "point_need_recommend") {
      $(this).prop("checked") ? $("#recommended_block").show() : $("#recommended_block").hide();
    } else if ($(this).attr("id") === "point_need_interview") {
      $(this).prop("checked") ? $("#interview_block").show() : $("#interview_block").hide();
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
    .then(result => {
      console.log(result.result)
      if (result.result > 1) {
        $("#main_container").attr("data-id", result.result);
      }
    });
  });

  // Upload a file
  $("input[type=file]").change(function(){
    // variables
    let formData = new FormData();
    let element = $(this);
    let field = $(this).attr('data-field');
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
        //console.log(result.result);
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
          element.parent().parent().find("img").each(function (e) {
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
    if ($(this).parent().parent().find("input[type='file']").attr("data-field")) {
      field = $(this).parent().parent().find("input[type='file']").attr("data-field");
    } else {
      field = $(this).parent().parent().prev().find("input[type='file']").attr("data-field");
    }
// УДАЛЕНИЕ БЛОБА
    let element = $(this);
    if (field === "passport_scan" && $(this).attr("data-pic") === "1") {
      field += "_2";
    } else if (field === "passport_scan" && $(this).attr("data-pic") === "2") {
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



  $("#toModalDeleteMyRequest").click(function (e) {
    if ($("#main_container").attr("data-status") && $("#main_container").attr("data-status") !== "0" && data_page.role !== "3") {
      e.stopPropagation();
      e.preventDefault();
      showError("Удаление заявления доступно только в статусе «Черновик». По всем вопросам обращайтесь к служащим ПВОМ.");
      return;
    }
    if (data_page.role === "3") {
      $("#modalDeleteMyRequest h5").text("Бланк заявления будет удалён безвозвратно. Продолжить?").css("background-color", "red").css("padding", "8px").addClass("rounded");
      $("#btnMdlDeleteMyRequest").attr("disabled", false);
    }

  });
    // Удалние заявления из модального окна
  $("#btnMdlDeleteMyRequest").click(function () {
    setCookie("wizard_step", 'wizard_step_1');
    setCookie("application_prepare", '');
    setCookie("application_check", '');
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
  // edit button
  $("#toEditMyRequest").click(function () {
    if ($("#point_name").attr("disabled")) {
      $("input").attr("disabled", false);
      $("textarea").attr("disabled", false);
      $("select").attr("disabled", false);
      $(".serviceone_block button").attr("disabled", false);
      /*if ($("#main_container").attr("data-status") === "2" && $("#service_recommendation_name").val() !== window.adminId) {

      }*/
    } else {
      $("input").attr("disabled", true);
      $("textarea").attr("disabled", true);
      $("select").attr("disabled", true);
      $(".serviceone_block button").attr("disabled", true);
    }

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
    // parsing condition
    function condition_parsing (element) {
      let operator;
      element = element.split("=");
      if (element.length > 1) {
        operator = "=";
      } else {
        element = element[0].split("<>");
        operator = "<>";
      }

      //let table = element[0].split(".");
      //table = table[0].trim();
      let field = element[0];
      field ? field = field.trim() : "";
      let value = element[1];
      value ? value = value.trim() : "";

      element = $("select[data-field='"+field+"']");
      if (element.length === 0) {
        element = $("input[data-field='"+field+"']");
      }

      if (element.length === 0) {
        element = $("div[data-field='"+field+"']");
      }

      /*table: table,*/
      return {field: field, value: value, element: element, operator: operator};
    }

    function condition_check(data) {
      if (data.element) {
        let elem = data.element;
        if (elem[0].localName === "select") {
          let some_var = data.value;
          let arr = some_var.split(",");
          for (let i = 0; i < arr.length; i++) {
            let temp_str_select_elem = arr[i];
            arr[i] = temp_str_select_elem.trim();
            if (arr[i][0] === "[") {
              arr[i] = arr[i].substring(1);
            } else if (arr[i][arr[i].length-1] === "]") {
              arr[i] = arr[i].slice(0, -1);
            }
            arr[i] = arr[i].toLowerCase();
          }
          if (data.operator === "=") {
            return !arr.includes(elem.val().toLowerCase())
          } else if (data['operator'] === "<>") {
            return arr.includes(elem.val().toLowerCase());
          }

        } else if (elem.attr("type") === "checkbox") {
          if (elem.val()) {
            return true;
          } else {
            return false;
          }
        } else if (elem.attr("type") === "text") {
          let input_condition = elem.val().toLowerCase();
          if (elem.attr("id") === "point_driver_license" && input_condition[0] === "н" && input_condition[1] === "е") {
            return true;
          } else if (elem.id === "point_driver_license") {
            return false;
          }

        } else if (elem.find("input").attr("type") === "radio") {
          return elem.attr("data-value").toLowerCase() !== data['value'].toLowerCase();
        }
      } else {
        return false;
      }
    }

    $("input[required]").each(function () {
      if ($(this).attr("data-display_condition") && condition_check(condition_parsing($(this).attr("data-display_condition")))) {
        // check cancel
      } else if ($(this).attr("type") === "checkbox" && !$(this).prop("checked")) {
        showError("Заполните все обязательные поля!");
        $(this).next().addClass("required_field");
        has_error++;
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
            $(this).addClass("required_field");
            $(this).css("width","auto");
            has_error++;
          }
        } else {
          // СОГЛАСИЕ СУПРУГА
          if ($(this).parent().parent().find("img").attr("src")) {
            check_check = "ok";
          }

          if (!$(this).val() && check_check === "error") {
            showError("Заполните все обязательные поля!");
            $(this).addClass("required_field");
            $(this).css("width","auto");
            has_error++;
          }
        }
      } else {
        if (!$(this).val()) {
          showError("Заполните все обязательные поля!");
          $(this).addClass("required_field");
          has_error++;
        }
      }
    });

    $("input[type='radio']").each(function () {
      if ($(this).parent().parent().parent().attr("data-display_condition") === "food_question7 = да" && !$("#radio_point_health_question50_1").is(":visible")) {

      } else if ($(this).parent().parent().parent().attr("data-display_condition") === "guest = 0 & semester = 1" && !$("#radio_point_semester_0").prop("checked")) {

      } else if ($(this).parent().parent().parent().attr("required")) {
        let arr_radio = $(this).parent().parent().parent().find("input[type='radio']:checked");
        if (arr_radio.length === 0) {
          if ($(this).attr("name") === "reg_document" && $("#point_citizenship_key").val() === "RU") {

          } else {
            showError("Заполните все обязательные поля!");
            $(this).parent().parent().parent().addClass("required_field");
            has_error++;
          }
        }
      }
    });

    $("select[required]:visible").each(function () {
      if (!$(this).val() || $(this).val() === "_none_") {
        showError("Заполните все обязательные поля!");
        $(this).addClass("required_field");
        has_error++;
      }
    });
    $("textarea[required]").each(function () {
      if ($(this).attr("data-display_condition") && condition_check(condition_parsing($(this).attr("data-display_condition")))) {

      } else if (!$(this).val()) {
        showError("Заполните все обязательные поля!");
        $(this).addClass("required_field");
        has_error++;
      }
    });

    showSaveIcon();
    return has_error;
  }

  // Отправка заявления
  // Возврат
  $("#back_to_master").click(function (e) {
    setCookie("application_prepare", '');
    setCookie("application_check", '1');
    setTimeout(function () {
      location.reload();
    }, 100);
  });
  // Валидация
  $("#send_application").click(function (e) {
    if ($(this).text() === "Предпросмотр") {
      setCookie("application_prepare", '1');
      setCookie("application_check", '1');
      setTimeout(function () {
        location.reload();
      }, 50);
    } else if (validationFields()) {

    } else {
      $("#modalSendMyRequest").modal("show");
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
          location.reload();
          /*
          blockApplicationFields();
          $("#main_container").attr("data-status", "1");
          $("#back_to_master").hide();
          $(".badge-secondary").removeClass("badge-secondary").addClass("badge-warning").text("на рассмотрении");
          //$("#toModalDeleteMyRequest").hide();
          $("#send_application").hide();
          showHint("Заявление отправлено служащим Полновременного обучения в Москве.");
          */
          /*setTimeout(function () {
            location.reload();
          }, 1500);*/
        }
      });
    } else if (data_page.role === "1") { // recommendator
      fetch("ajax/ftt_request_ajax.php?type=recommendation&id="+id)
      .then(response => response.json())
      .then(data => {
        if (data) {
          blockApplicationFields();
          $("#main_container").attr("data-status", "3");
          $("#back_to_master").hide();
          //$("#toModalDeleteMyRequest").hide();
          $("#send_application").hide();
          showHint("Заявление отправлено служащим Полновременного обучения в Москве. ????");
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
      show_hide_buttons();
    } else {
      // ПРЕДОСМОТР
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
      show_hide_buttons();
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
      show_hide_buttons();
    }
  });

  function show_hide_buttons() {
    if (!$(".wizard_step:visible").next().hasClass("wizard_step")) {
      $("#send_application").show();
      $("#send_application_text").show();
      $("#next_step").hide();
    } else if ($("#send_application").is(":visible")) {
      $("#send_application").hide();
      $("#send_application_text").hide();
      $("#next_step").show();
    }
  }
  show_hide_buttons();

  function simbol_counter(element) {
    return element.val().length;
  }
  $("input[type='text'], textarea").keyup(function () {
    // скрывем / показываем кнопку НЕТ
    if ($(this).next().next().hasClass("set_no") && $(this).next().next().is(":visible") && $(this).val()) {
      $(this).next().next().hide();
    } else if ($(this).next().next().hasClass("set_no") && !$(this).next().next().is(":visible") && !$(this).val()) {
      //$(this).next().next().show();
    }
    // счётчик слов
    if ($(this).attr("data-field") === "request_info") {
      let text_for_count = $(this).val();
      if (text_for_count) {
        text_for_count = text_for_count.split(" ");
        text_for_count = text_for_count.length;
      } else {
        text_for_count = 0;
      }
      $(this).next().css("color", "red").css("font-weight", "bold");
      $(this).next().text(250 - text_for_count);
    } else { // счётчик символов
      $(this).next().text($(this).attr("maxlength") - $(this).val().length);
    }
  });

  // быстрое заполнение полей
  $(".set_no").click(function () {
    if (!$(this).prev().prev().attr("disabled")) {
      $(this).prev().prev().val($(this).text());
      $(this).hide();
      quickly_save_input($(this).prev().prev());
    }
  });
  // Раздел служащие
  /*
  $(".serviceone_block input").attr("disabled", false);
  $(".serviceone_block select").attr("disabled", false);
  $(".serviceone_block textarea").attr("disabled", false);
  */
  $(".serviceone_block input[type='checkbox']").attr("disabled", false);
  // Рекомендации
  if ($("#point_need_recommend").prop("checked")) {
    if ($("#service_recommendation_name").val() === window.adminId && $("#main_container").attr("data-status") === "2") {
      $("#recommended_block textarea").attr("disabled",false);
      $("#recommended_block input[type='radio']").attr("disabled", false);
      $("#recommended_block button").attr("disabled", false);
    }
    $("#recommended_block").show()
  } else if (!$("#point_need_recommend").is(":visible")) {
    if ($("#service_recommendation_name").val() === window.adminId && $("#main_container").attr("data-status") > 1 ) {
      $("#recommended_block").show();
    } else {
      $("#recommended_block").hide();
    }
  } else {
    $("#recommended_block").hide();
  }

  // Собеседование
  $("#point_need_interview").prop("checked") ? $("#interview_block").show() : $("#interview_block").hide();

  // справка
  $(".interview_help_link").click(function () {
    $("#modal_info .container").html($(this).attr("tooltip"));
    $("#modal_info").modal("show");
  });

  function set_status(status) {
    if (!status) {
      showError("Статус не установлен.");
    }
    let id = $("#main_container").attr("data-id");
    fetch("ajax/ftt_request_ajax.php?type=set_status&status="+status+"&id="+id)
    .then(response => response.json())
    .then(result => {
      location.reload();
    });
  }

  // кнопка на рекомендацию
  $("#send_to_recommend").click(function () {
    set_status(2);
  });
  //
  $("#send_recommend_to").click(function () {
    if (!$("#point_recommendation_info").val() || $("#point_recommendation_status").val() === "_none_") {
      showError("Заполните все обязательные поля!");
      if ($("#point_recommendation_info").val() === "") {
        $("#point_recommendation_info").css("border-bottom", "2px solid red");
      }
      if (!$("#point_recommendation_status").val()) {
        $("#point_recommendation_status").css("border-bottom", "2px solid red");
      }
      return;
    }
    set_status(3);
  });

  // кнопка на собеседование
  $("#send_to_interview").click(function () {
    set_status(4);
  });
  // interview
  $("#send_interview_to").click(function () {
    if ($("#point_interview_status").val() === "_none_" || !$("#point_interview_info").val()) {
      showError("Заполните все обязательные поля!");
      if ($("#point_interview_info").val() === "") {
        $("#point_interview_info").css("border-bottom", "2px solid red");
      }
      if ($("#point_interview_status").val() === "_none_") {
        $("#point_interview_status").css("border-bottom", "2px solid red");
      }
      return;
    }
    set_status(5);
  });
  // Decision
  $("#send_decision_to").click(function () {
    if ($("#point_decision").val() === "_none_" || !$("#point_decision_info").val()) {
      showError("Заполните все обязательные поля!");
      if ($("#point_decision_info").val() === "") {
        $("#point_decision_info").css("border-bottom", "2px solid red");
      }
      if ($("#point_decision").val() === "_none_") {
        $("#point_decision").css("border-bottom", "2px solid red");
      }
      return;
    }
    set_status(6);
  });
  // enable disable show hide
  function service_block_behavior() {
    /*
    if ($("#main_container").attr("data-status") > 1 || $("#point_recommendation_status").attr("disabled")) {
      //$("#send_to_recommend").attr("disabled", true);
    }
    if ($("#main_container").attr("data-status") > 1 || $("#point_interview_status").attr("disabled")) {
      //$("#send_to_interview").attr("disabled", true);
    }*/
  }
  service_block_behavior();

  // PRINT
  $("#application_print").click(function() {

  });

  // DOWNLOAD
  $("#application_download").click(function() {
    // дата выгрузки
    let copytext = "Дата выгрузки — " + dateStrToddmmyyyyToyyyymmdd(date_now_gl(), true) + "\n";
    let file_name = $("#point_name").val();
    $("#main_container .container").each(function () {
      // check
      if (($(this).find("h4").text().trim() === "Рекомендация" && (!$("#point_need_recommend").prop("checked")
      || $("#service_recommendation_name").val() === "_none_"))
      || ($(this).find("h4").text().trim() === "Собеседование" && (!$("#point_need_interview").prop("checked")
      || $("#service_interview_name").val() === "_none_"))
      || ($(this).find("h4").text().trim() === "Решение" && $("#point_decision").val() === "_none_")) {
        // nothing
      } else {
        // get text for file
        copytext += "\n" + $(this).find("h4").text().trim() + "\n\n";
        $(this).find(".row").each(function () {

            if ($(this).find(".title_point").is(":visible")) {
              copytext += $(this).find(".title_point").text().trim();
            }

            if ($(this).find("input[type='text']").is(":visible")) {
              copytext += " — " + $(this).find("input[type='text']").val() + "\n";
            } else if ($(this).find("textarea").is(":visible")) {
              copytext += " — " + $(this).find("textarea").val() + "\n";
            } else if ($(this).find("input[type='radio']").is(":visible")) {
              copytext += " — " + $(this).find("input[type='radio']").parent().parent().parent().attr("data-value") + "\n";
            } else if ($(this).find("input[type='checkbox']").is(":visible")) {
              copytext += " — ";
              if ($(this).find("input[type='checkbox']").parent().text()) {
                $(this).find("input[type='checkbox']:checked").parent().each(function (i) {
                  if (i > 0) {
                    copytext += ", ";
                  }
                  copytext += $(this).text();
                });
                copytext += ".\n";
              } else {
                if ($(this).find("input[type='checkbox']:checked")) {
                  copytext += "Да\n"
                } else {
                  copytext += "Нет\n"
                }
              }
            } else if ($(this).find("select").is(":visible")) {
              copytext += " — " + $(this).find("select option:checked").text() + "\n";
            } else if ($(this).find("input[type='file']").is(":visible")) {
              copytext += " — ";
            if ($(this).find("input[type='file']").attr("id") === "point_passport_scan_2") {
              let counter_pics = 0;
              $(this).find("img").each(function() {
                counter_pics++
                if (counter_pics === 2 || counter_pics === 3) {
                  copytext += ", "
                }
                if ($(this).attr("src")) {
                  copytext += "файл " + counter_pics + " прилагается";
                } else {
                  copytext += "файл " + counter_pics + " не прилагается";
                }
                if (counter_pics === 3) {
                  copytext += "\n"
                }
              });
            } else {
              if ($(this).find("img").attr("src")) {
                copytext += "файл прилагается\n";
              } else {
                copytext += "файл не прилагается\n";
              }
            }
          } else if ($(this).find("input[type='date']").is(":visible")) {
            copytext += " — " + $(this).find("input[type='date']").val() + "\n";
          } else {
            //copytext += "\n";
          }
        });
      }
    });
    console.log(copytext.trim());
    downloadSys(copytext.trim(), file_name)
  });

  function downloadSys(file_text, file_name) {
    $("#modal_download").modal("show");
    $("#modal_download .container").html("");
    $("#modal_download .container").append("<h6>Ссылки для загрузки</h6>");

    let el = "<a href='"+`data:text/plain;charset=utf-8,${encodeURIComponent(file_text)}`+"' download='"+"Анкета_"+ file_name +".doc"+"'>"+"Анкета_"+ file_name +".doc"+"</a><br>";
    $("#modal_download .container").append(el);
    //el.attr("href", `data:text/plain;charset=utf-8,${encodeURIComponent(file_text)}`);
    //el.attr("download", "anketa_"+ file_name +".doc");
    // pics
    $("#main_container img").each(function (i) {
      let link_name = $(this).parent().attr("href");
      let file_name = $(this).parent().parent().parent().find("input").attr("data-field");
      let counter_pics_passport = "";
      if ( $(this).parent().parent().parent().find("input").attr("id") === "point_passport_scan_2") {
        counter_pics_passport = i+1;
      }
      if (link_name) {
        let elem = "<a href='"+$(this).parent().attr("href")+"' download='"+file_name + counter_pics_passport +"'>Скан " + file_name + " " + counter_pics_passport + "</a><br>";
        $("#modal_download .container").append(elem);
      }
    });
  }

  // нумерация вопросов для служащих
  function numQuestionsForStaff() {
    $("#main_container .text-white.bg-secondary").each(function (i) {
      $(this).find("h4").text(i+1 + ". " + $(this).find("h4").text());
      $(this).parent().find(".title_point").each(function (ii) {
        $(this).text((i+1) + "." + (ii+1) + ". " + $(this).text());
      });
    });
  }
  if (data_page.role > 1) {
    numQuestionsForStaff();
  }
}); // END document ready
