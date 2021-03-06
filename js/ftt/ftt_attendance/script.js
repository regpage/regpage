/* ==== MAIN & ATTENDANCE START ==== */
$(document).ready(function(){

  // текущая дата гггг.мм.дд
  date_now_gl = date_now_gl ();

  // save select field
  function save_select_field(element, value) {
    field = element.attr("data-field");
    id = element.parent().parent().parent().attr("data-id");
    data = "&field="+field+"&value="+value+"&id="+id+"&header=0";
    fetch('ajax/ftt_attendance_ajax.php?type=updade_data_blank' + data)
    .then(response => response.json())
    .then(commits => {
      console.log(commits.result);
    });
 }

 // send data
 function send_data_blank(id, late, extrahelp) {
   $("#modalAddEdit").modal("hide");
   $("#spinner").modal("show");
   // set extra help
   if (extrahelp[0]) {
     for (var i = 0; i < extrahelp.length; i++) {
       fetch('ajax/ftt_attendance_ajax.php?type=create_extrahelp'+extrahelp[i])
       .then(response => response.text())
       .then(commits => {
         console.log(commits);
       });
     }
   }

   // set extra help
   if (late[0]) {
     for (var i = 0; i < late.length; i++) {
       fetch('ajax/ftt_attendance_ajax.php?type=create_late'+late[i])
       .then(response => response.text())
       .then(commits => {
         console.log(commits);
       });
     }
   }

     // update
     fetch("ajax/ftt_attendance_ajax.php?type=updade_data_blank&id="+id+"&field=status&value=1&header=1")
     .then(response => response.json())
     .then(commits => {
       //dinamic_add_string(commits.result, true);
       //clear_blank();
       if (!late[0] && !extrahelp[0]) {
         location.reload();
       } else {
         setTimeout(function () {
           $('#spinner').modal("hide");
           location.reload();
         }, 500);
       }
     });
 }

  // send blank
 $('#send_blank').click(function (e) {
   e.preventDefault();
   e.stopPropagation();
   let create_extrahelp = [];
   let create_late = [];
   let reason;
   /*if (!trainee_access && ($("#modalAddEdit").attr("data-author") !== admin_id_gl && $("#modalAddEdit").attr("data-author")) && $("#modalAddEdit").attr("data-status") !== "1") {
     showError('Нельзя сохранить.');
     return;
   } else*/ if (trainee_access && $("#modalAddEdit").attr("data-status") === "1") {
     showError('Нельзя сохранить.');
     return;
   }
//
   // валидация значений полей
   let counter_valid = 0, extra_valid = 0;
   $("#modalAddEdit input[data-field='attend_time']").each(function () {
     if ((!$(this).prev().val() || !$(this).val()) && $(this).next().val() === "С" && $(this).parent().parent().parent().prev().find(".select_reason").val() !== "С") {
       /* && $(this).parent().parent().parent().prev().find(".name_session").text() !== "Приход в Центр обучения" &&
       $(this).parent().parent().parent().prev().prev().find(".select_reason").val() !== "С"*/
       $(this).css("border-color", "red");
       $(this).prev().css("border-color", "red");
       counter_valid++;
       extra_valid++;
     } else if (!$(this).val() && !$(this).next().val()) {
       $(this).css("border-color", "red");
       $(this).next().next().css("border-color", "red");
       counter_valid++;
     } else {
       if ($(this).css("border-color") === "red") {
        $(this).css("border-color", "lightgrey");
       }
       if (!$(this).next().val() && ($(this).hasClass("bg_color_pink") || $(this).hasClass("bg_color_yellow"))) {

       } else if ($(this).next().css("border-color") === "red") {

       }
       if ($(this).hasClass("bg_color_yellow")) { // && $(this).next().val() === "О"
         create_late.push("&id="+$(this).parent().parent().parent().attr("data-id")
         +"&delay="+$(this).next().next().next().next().val()
         + "&date="+$("#modalAddEdit").attr("data-date")
         +"&session_name="+$(this).parent().parent().find("h6").text()
         +"&member_key="+$("#modalAddEdit").attr("data-member_key")
         +"&end_time="+$(this).parent().parent().parent().attr("data-end_time")
         +"&id_attendance="+$("#modalAddEdit").attr("data-id"));
       } else if ($(this).hasClass("bg_color_pink")) { //&& $(this).next().val() === "О"
         let text_msg = "опоздание";
         if ($(this).parent().parent().parent().attr("data-end_time") === "1") {
           text_msg = "приход раньше";
         }
         let data_ddmm = dateStrFromyyyymmddToddmm($("#modalAddEdit").attr("data-date"));
         reason = data_ddmm + " " + $(this).parent().parent().find("h6").text() + " – "+text_msg+" на " + $(this).next().next().next().next().val() + " мин.";
         create_extrahelp.push("&id="+$(this).parent().parent().parent().attr("data-id")
         +"&reason="+reason+"&date="+$("#modalAddEdit").attr("data-date")
         +"&member_key="+$("#modalAddEdit").attr("data-member_key"));
       } else if (!$(this).val() && $(this).next().val() === "О") {
         let data_ddmm = dateStrFromyyyymmddToddmm($("#modalAddEdit").attr("data-date"));
         reason = data_ddmm + " " + $(this).parent().parent().find("h6").text() + " – отсутствие без разрешения.";
         create_extrahelp.push("&id="+$(this).parent().parent().parent().attr("data-id")
         +"&reason="+reason+"&date="+$("#modalAddEdit").attr("data-date")
         +"&member_key="+$("#modalAddEdit").attr("data-member_key"));
       }
     }
   });

   if (counter_valid > 0 && extra_valid === 0) {
      if (confirm('Незаполненные поля будут отмечены как «отсутствие без разрешения» (О). Отправить?')) {
        $("#modalAddEdit input[data-field='attend_time']").each(function () {
          if (!$(this).val() && !$(this).next().val()) {
            // отмечаем опоздания
            $(this).css("border-color", "none");
            $(this).next().next().css("border", "none");
            $(this).next().val("О");
            $(this).next().next().html('О');
            // Добавляем отсутствия в массив
            reason = $("#modalAddEdit").attr("data-date") + " " + $(this).parent().parent().find("h6").text() + " – отсутствие без разрешения.";
            create_extrahelp.push("&id="+$(this).parent().parent().parent().attr("data-id")
            +"&reason="+reason+"&date="+$("#modalAddEdit").attr("data-date")
            +"&member_key="+$("#modalAddEdit").attr("data-member_key"));
            // save select field
            field = $(this).next().attr("data-field");
            id = $(this).parent().parent().parent().attr("data-id");
            data = "&field="+field+"&value=О&id="+id+"&header=0";
            fetch('ajax/ftt_attendance_ajax.php?type=updade_data_blank' + data)
            .then(response => response.json())
            .then(commits => {
              console.log(commits.result);
            });
          }
        });
      } else {
        return;
      }
     //$("#show_error_span_mdl").slideDown();
   } else if (extra_valid > 0) {
     return;
   }
  send_data_blank($("#modalAddEdit").attr("data-id"), create_late, create_extrahelp);
 });

function open_blank(el_this) {
  let disabled = "", status;
  $("#modal-block_staff").hide();
  $("#modal-block_1").show();
  $("#modal-block_2").show();
  status_sheet = el_this.attr("data-status");
  // поля бланка для просмотра служащими отображаются в соответствии с семестром обучающегося
  if (!trainee_access) {
   $("#name_of_trainee").text(trainee_list[el_this.attr("data-member_key")]);
   let text_stts_for_blank = "<span class='badge badge-secondary text-right' style='font-size: 100%;'>Не отправлен</span>";
   if (status_sheet === "1") {
     let date_tmp, date_date, date_time;
      if (el_this.attr("data-date_send")) {
        date = el_this.attr("data-date_send");
        date = date.split(" ");
        date_date = dateStrFromyyyymmddToddmm(date[0]);
        date_time = date[1];
        date_time = date_time.split(":");
        date_time = date_time[0] + ":" + date_time[1];
      }
     text_stts_for_blank = "<span class='badge badge-success text-right' style='font-size: 100%;'>Отправлен "+date_date+" "+date_time+"</span>";
   }
   $("#status_of_blank").html(text_stts_for_blank);
   if (status_sheet === "0") {
     disabled = "disabled";
   }
   if (trainee_list_full[el_this.attr("data-member_key")]["semester"] < 5) {
     $(".practice_field").each(function () {
       if ($(this).attr("type") === "checkbox") {
         // $(this).parent().parent().parent().show();
       } else {
         if ($(this).attr("id") === "comment_modal") {
           $(this).parent().parent().parent().show();
         } else {
           if ($(this).attr("id") === "bible_reading") {
             $(this).parent().parent().parent().show();
           } else {
             $(this).parent().parent().parent().hide();
           }
         }
       }
     });
   } else if(trainee_list_full[el_this.attr("data-member_key")]["semester"] > 4) {
     $(".practice_field").each(function () {
       if ($(this).attr("type") === "number") {
        $(this).parent().parent().parent().show();
       } else {
         if ($(this).attr("id") === "comment_modal") {
           $(this).parent().parent().parent().show();
         } else {
           $(this).parent().parent().parent().hide();
         }
       }
     });
   }
  }
  let part_text = "";
  if (trainee_access) {
    part_text = el_this.find(".date_str").text() + " " + el_this.find(".date_str").attr("data-short");
  } else {
    part_text = el_this.text();
  }
  fetch("ajax/ftt_attendance_ajax.php?type=get_sessions&id=" + el_this.attr('data-id'))
  .then(response => response.json())
  .then(commits => {
    let srings = [], p="", c="", o="", v="", btn_text = "", disabled_extra = "", bg_light = "", mb_3 = "", extra_label= "";
    let minutes_rend, minutes_my_rend, deff_rend, bg_color_time, mb_2 = ""; //time_session_extra,
    let prev_reason;
    $("#date_attendance_modal").text(part_text);
    $("#comment_modal").val(el_this.attr('data-comment'));
    $("#modalAddEdit").attr("data-list", "");
    // sorting that

    commits.result.sort(function (a, b) {
      let nameA, nameB;

      if ((a["duration"] === "0" && a["attend_time"] && a['session_name'][a['session_name'].length-4] !== ":") || (b["duration"] === "0" && b["attend_time"] && b['session_name'][b['session_name'].length-4] !== ":")) {
        if ((a["duration"] === "0" && a["attend_time"]) && (b["duration"] === "0" && b["attend_time"])) {
          nameA=a["attend_time"], nameB=b["attend_time"];
        } else if (b["duration"] === "0" && b["attend_time"]) {
          nameA=a["session_time"], nameB=b["attend_time"];
        } else {
          nameA=a["attend_time"], nameB=b["session_time"];
        }
      } else {
        nameA=a["session_time"], nameB=b["session_time"];
      }
      if (String(nameA) < String(nameB)) { //сортируем строки по возрастанию
        return -1;
      }
      if (String(nameA) > String(nameB)) {
        return 1;
      }
      return 0;
    });

    for (var i = 0; i < commits.result.length; i++) {
      disabled_extra = "disabled";
      bg_light = "bg-light";
      mb_3 = "mb-2";
      mb_2 = "";
      extra_label = "<span class='hide_element' style='color: lightgray; font-size: 12px;'><span class='extra_label' style='padding-left: 192px;'>Начало служения</span><span style='padding-left: 12px;'>Окончание</span></span>";
      //time_session_extra ="";
      if (commits.result[i]['reason'] === "Р") {
        p = "selected"; c = ""; o = ""; v = "";
        btn_text = "Р";
      } else if (commits.result[i]['reason'] === "С") {
        if (commits.result[i]['session_name'].charAt(commits.result[i]['session_name'].length-4) === ":") {
          extra_label = "<span class='' style='color: lightgray; font-size: 12px;'><span class='extra_label' style='padding-left: 192px;'>Начало служения</span><span style='padding-left: 12px;'>Окончание</span></span>";
          mb_2 = "margin-bottom: 13px;";
          disabled_extra = "";
          bg_light = "";
        }
        p = ""; c = "selected"; o = ""; v = "";
        btn_text = "С";
        mb_3 = "mb-2";
        //time_session_extra = " ("+commits.result[i]['session_time']+") ";

      } else if (commits.result[i]['reason'] === "О") {
        p = ""; c = ""; o = "selected"; v = "";
        btn_text = "О";
      } else if (commits.result[i]['reason'] === "П") {
        p = ""; c = ""; o = ""; v = "selected";
        btn_text = "П";
      } else {
        p = ""; c = ""; o = ""; v = "";
        btn_text = "...";
      }

      commits.result[i]['attend_time'] ? minutes_my_rend = commits.result[i]['attend_time'].split(":") : minutes_my_rend="";
      commits.result[i]['session_time'] ? minutes_rend = commits.result[i]['session_time'].split(":") : minutes_rend="";
      if (minutes_my_rend && minutes_rend) {
        if (commits.result[i]['end_time'] === "1") {
          deff_rend = (minutes_rend[0]*60 + Number(minutes_rend[1])) - (minutes_my_rend[0]*60 + Number(minutes_my_rend[1]));
        } else {
          deff_rend = (minutes_my_rend[0]*60 + Number(minutes_my_rend[1])) - (minutes_rend[0]*60 + Number(minutes_rend[1]));
        }
     } else {
       deff_rend = 0;
     }

      if ((deff_rend > 0 && deff_rend < 20) && (btn_text === "..." || btn_text === "О")) {
        bg_color_time = "bg_color_yellow";
      } else if ((deff_rend >= 20 && (btn_text === "..." || btn_text === "О")) || (deff_rend === 0 && btn_text === "О")) {
        bg_color_time = "bg_color_pink";
      } else {
        bg_color_time = "";
      }
      let hide_element = "", hide_element_mbl = "";
      if ($(window).width()<=769) {
        hide_element_mbl = "hide_element";
      } else {
        hide_element = "hide_element";
      }
      // время начала мероприятия
      let render_session_name, time_val, disabled_service;
      time_val = commits.result[i]['session_time'];
      render_session_name = commits.result[i]['session_name'];
      if (render_session_name.charAt(render_session_name.length-4) === ":") {
        time_val = render_session_name.slice(-6 , -1);
        render_session_name = render_session_name.slice(0 , render_session_name.length-8);
      }
      // блокируем поля служения
      disabled_service = "";
      if (commits.result[i]['reason'] === "С" && commits.result[i]['session_name'].charAt(commits.result[i]['session_name'].length-4) !== ":") {
       disabled_service = "disabled";
      }

      // visit
      let visit_field = commits.result[i]['visit'], option_visit = '', drop_visit = '';

      if (commits.result[i]['visit'] === "1") {
        option_visit = "<option value='П' "+v+">П</option>";
        drop_visit = "<span class='dropdown-item cursor-pointer' data-val='П'>Посещение (П)</span>"
      }

      srings.push("<div class='row' data-id='"+commits.result[i]['id']+"' data-visit='"+visit_field+"' data-end_time='"+commits.result[i]['end_time']+"' data-correction_id='"+commits.result[i]['session_correction_id']+"' data-absence='"+
      commits.result[i]['absence']+"' data-late='"+commits.result[i]['late']+"' style='"+mb_2+"'><div class='col-12'><h6 class='"+hide_element+"'>"+ commits.result[i]['session_name']
      +"</h6>"+extra_label+"<div class='input-group "+mb_3+"'><span data-text='"+render_session_name
      +"' data-field='session_name' class='align-self-center name_session "+hide_element_mbl+"'>"+ commits.result[i]['session_name']
      +"</span><input type='time' data-val='"+time_val+"' value='"+commits.result[i]['session_time']
      +"' class='form-control "+bg_light+" mr-3 ' required data-field='session_time' "+disabled_extra+" "+disabled_service+"><input type='time' class='form-control mr-3  "+bg_color_time+"' data-field='attend_time' value='"+commits.result[i]['attend_time']
      +"' "+disabled+" "+disabled_service+"><select data-field='reason' class='select_reason bg-secondary text-light short_select_field hide_element'"
      +disabled+"><option value=''>...</option>"+option_visit+"<option value='Р' "+p+">Р</option><option value='С' "+c+">С</option><option value='О' "+o+">О</option></select><button type='button' class='btn btn-secondary dropdown-toggle-split' data-toggle='dropdown'>"+btn_text+"</button><div class='dropdown-menu'><span class='dropdown-item cursor-pointer' data-val='...'>...</span>"+drop_visit+"<span class='dropdown-item cursor-pointer' style='display: none;' data-val='П'>Посещение</span><span data-val='Р' class='dropdown-item cursor-pointer'>Разрешение (Р)</span><span class='dropdown-item cursor-pointer' data-val='С'>Служение (С)</span><span class='dropdown-item cursor-pointer' data-val='О'>Отстутствие (О)</span></div><input type='number' class='hide_element' value='"
      +deff_rend+"' data-field='late' disabled></div></div></div>");
    }
    if (commits.result[0]) {
     $("#modal-block_1").html(srings.join(" "));
   } else {
     $("#modal-block_1").html("<p><label style='color: red;'>В этот день учёт посещаемости не ведётся.</label></p>");
   }
    // DESIGN
    if ($(window).width()<=769) {
        $("input[type='time']").attr("style", "font-size: 16px !important; max-width: 105px !important;");
        // бланк
        $(".extra_label").attr('style', 'padding-left: 0px;');
        $(".extra_label").next().attr('style', 'padding-left: 40px;');
    }
    if ($(".extra_label").is(":visible")) {
      $(".extra_label").parent().parent().parent().addClass("mb-2");
    }

    // tooltip
    $("#modalAddEdit").find('[data-toggle="tooltip"]').tooltip();
    // customs select
    $(".dropdown-toggle-split").click(function (e) {
      let text = $(this).prev().prev().prev().prev().text();
      if ((status_sheet === "1" && trainee_access) || (status_sheet !== "1" && !trainee_access)) {
        e.stopPropagation(); //|| (text.charAt(text.length-4) !== ":" && $(this).text() === "С")
      }
    });
    $(".dropdown-item").click(function () {
      if (($(this).attr("data-val") === "С" && $(this).parent().prev().text() === "С") || ($(this).attr("data-val") === "Р" && $(this).parent().prev().text() === "Р") || ($(this).attr("data-val") === "О" && $(this).parent().prev().text() === "О") || ($(this).attr("data-val") === "..." && $(this).parent().prev().text() === "...") || ($(this).attr("data-val") === "П" && $(this).parent().prev().text() === "П")) {
        return;
      }

      if (!$(this).parent().prev().prev().prop("disabled")) {
        let prev_val = $(this).parent().prev().prev().val();
        $(this).parent().prev().prev().val($(this).attr("data-val"));
        save_select_field($(this).parent().prev().prev(), $(this).attr("data-val"));

        if ($(this).attr("data-val") === "С") {
          //session time
          $(this).parent().prev().prev().prev().prev().val("");
          $(this).parent().prev().prev().prev().prev().attr("disabled", false);
          $(this).parent().prev().prev().prev().prev().removeClass("bg-light");
          //attendance time
          $(this).parent().prev().prev().prev().val("");
          $(this).parent().prev().prev().prev().removeClass("bg_color_pink");
          $(this).parent().prev().prev().prev().removeClass("bg_color_yellow");
          // name session
          $(this).parent().prev().prev().prev().prev().prev().text($(this).parent().prev().prev().prev().prev().prev().text() + " (" + $(this).parent().prev().prev().prev().prev().attr("data-val")+")");
          $(this).parent().parent().prev().prev().text($(this).parent().parent().prev().prev().text() + " (" + $(this).parent().prev().prev().prev().prev().attr("data-val")+")");
          // extra lable
          $(this).parent().parent().prev().removeClass("hide_element");
          save_select_field($(this).parent().prev().prev().prev().prev().prev(), $(this).parent().prev().prev().prev().prev().prev().text());
        } else {
          if (prev_val === "С") {
            let current_element = $(this).parent().prev().prev().prev();
            let next_str, next_field_session, same_row = false, stop = false;
            $("#modal-block_1 .row").each(function (i) {
              if (stop) {
                return;
              }
              if ($(this).attr("data-id") === current_element.parent().parent().parent().attr("data-id")) {
                same_row = true;
                current_element.prop("disabled", false);
              } else if (same_row) {
                next_str = $(this).next();
                next_field_session = $(this).find("input[data-field='session_time']");
                // Если через одну строку от записи служения время начала сессии меньше то блокируем следующий
                  if (next_str.find("input[data-field='session_time']").val() && current_element.val() > next_str.find("input[data-field='session_time']").val()) {
                    if (next_field_session.next().val()) {
                      next_field_session.next().val("");
                      save_select_field(next_field_session.next(), next_field_session.next().val());
                    }
                    if (next_field_session.next().prop("disabled")) {
                      next_field_session.next().attr("disabled", false);
                    }
                    if (!next_field_session.prop("disabled")) {
                      next_field_session.attr("disabled", true);
                    }
                    if (next_field_session.next().next().val() === "С") {
                      next_field_session.next().next().val("...");
                      next_field_session.next().next().next().text("...");
                      save_select_field(next_field_session.next().next(), next_field_session.next().next().val());
                    }
                 } else if (next_field_session.next().prop("disabled")) {
                   next_field_session.next().prop("disabled", false);
                   next_field_session.next().next().val("");
                   next_field_session.next().next().next().text("...");
                   save_select_field(next_field_session.next().next(), next_field_session.next().next().val());
                 } else {
                   stop = true;
                 }
               }
            });
          }
          // сбрасываем и сохраняем мероприятие в изначальном состоянии
          let str_session_name = $(this).parent().parent().prev().prev().text();
          if (str_session_name.charAt(str_session_name.length-4) === ":") {
            save_select_field($(this).parent().prev().prev().prev().prev().prev(), $(this).parent().prev().prev().prev().prev().prev().attr("data-text"));
            $(this).parent().prev().prev().prev().prev().val($(this).parent().prev().prev().prev().prev().attr("data-val"));
            save_select_field($(this).parent().prev().prev().prev().prev(), $(this).parent().prev().prev().prev().prev().attr("data-val"));
          }
          $(this).parent().prev().prev().prev().prev().attr("disabled", true);
          $(this).parent().prev().prev().prev().prev().addClass("bg-light");
          $(this).parent().prev().prev().prev().prev().prev().text($(this).parent().prev().prev().prev().prev().prev().attr("data-text"));
          $(this).parent().parent().prev().prev().text($(this).parent().prev().prev().prev().prev().prev().attr("data-text"));
          $(this).parent().parent().prev().addClass("hide_element");
          // сбрасываем и сохраняем время прихода
          $(this).parent().prev().prev().prev().val("");
          save_select_field($(this).parent().prev().prev().prev(), "");
        }
        $(this).parent().prev().html($(this).attr("data-val"));
      }
    });

    if (status_sheet === "1" && trainee_access) {
      $('#modalAddEdit input').attr("disabled", true);
      $('#modalAddEdit select').attr("disabled", true);
      $('#send_blank').hide();
      $('#add_attendance_str').attr("style", "margin-right: 320px;");
    } else if (status_sheet === "0" && !trainee_access) {
      $('#modalAddEdit input').attr("disabled", true);
      $('#modalAddEdit select').attr("disabled", true);
      $('#send_blank').hide();
      $("#undo_attendance_str").prop("disabled", true);
      $('#add_attendance_str').attr("style", "margin-right: 320px;");
    } else {
     if (status_sheet === "1" && !trainee_access) {
       $('#send_blank').hide();
       $("#undo_attendance_str").prop("disabled", false);
     } else {
       $('#send_blank').show();
       $("#undo_attendance_str").prop("disabled", true);
     }

     $('#modalAddEdit select').attr("disabled", false);
     $('#comment_modal').attr("disabled", false);
     $('#add_attendance_str').attr("style", "margin-right: 300px;");
   }
    // change fields
    $('#modalAddEdit input').change(function () { //, #modalAddEdit select
      let element, field, value, id, data;
      element = $(this);
      field = $(this).attr("data-field");
      value = $(this).val();
      id = $(this).parent().parent().parent().attr("data-id");

      // update field
      if (!$(this).hasClass("bg-light") && $(this).attr("type") === "time") {
        let field_late, deff, absence, late;
        field_late = $(this).next().next().next().next().attr("data-field");
        deff = 0, late = 0, absence = 0, same_row = false;
        let minutes, minutes_my, sessiion_begin, my_attendance;
        // check
        if ($(this).attr("type") === "time" && value > $(this).prev().val() && $(this).next().val() !== "Р" && $(this).next().val() !== "П" && $(this).next().val() !== "С" && $(this).parent().parent().parent().attr("data-end_time") !== "1") {
           // time counter
           minutes = $(this).prev().val().split(":");
           minutes_my = value.split(":");
           sessiion_begin = minutes[0]*60 + Number(minutes[1]);
           my_attendance = minutes_my[0]*60 + Number(minutes_my[1]);
           // опоздание
           deff = my_attendance - sessiion_begin;

           $(this).next().next().next().next().val(deff);
           if (deff > 0 && deff < 20) {
             late = 1;
             absence = 0;
           if (!$(this).hasClass("bg_color_yellow")) {
              $(this).addClass("bg_color_yellow");
              $(this).removeClass("bg_color_pink");
           }
              //$(this).css("background-color", "yellow !important");
           } else if (deff >= 20) {
              late = 0;
              absence = 1;
              if (!$(this).hasClass("bg_color_pink")) {
                $(this).addClass("bg_color_pink");//$(this).css("background-color", "pink !important");
                $(this).removeClass("bg_color_yellow");
              }
            }
        } else if ($(this).attr("type") === "time" && value < $(this).prev().val() && $(this).next().val() !== "Р" && $(this).next().val() !== "П" && $(this).next().val() !== "С" && $(this).parent().parent().parent().attr("data-end_time") === "1") {
          // time counter
          minutes = $(this).prev().val().split(":");
          minutes_my = value.split(":");
          sessiion_begin = minutes[0]*60 + Number(minutes[1]);
          my_attendance = minutes_my[0]*60 + Number(minutes_my[1]);
          // приход раньше
          deff = sessiion_begin - my_attendance;

           $(this).next().next().next().next().val(deff);
           if (deff > 0 ) { //&& deff < 20
             late = 1;
             absence = 0;
             if (!$(this).hasClass("bg_color_yellow")) {
               $(this).addClass("bg_color_yellow");
               $(this).removeClass("bg_color_pink");
             }
           }
        } else if ($(this).attr("type") === "time" && $(this).attr("data-field") === "attend_time" && $(this).next().val() !== "С" && $(this).next().val() !== "Р" && $(this).next().val() !== "П" && $(this).parent().parent().parent().attr("data-end_time") !== "1") {
          minutes = $(this).prev().val().split(":");
          minutes_my = value.split(":");
          // приход раньше
          deff = (minutes_my[0]*60 + Number(minutes_my[1])) - (minutes[0]*60 + Number(minutes[1]));
          $(this).next().next().next().next().val(deff);
          if ($(this).next().next().next().next().val() < 1) {
            $(this).css("background-color", "white");
            $(this).removeClass("bg_color_yellow");
            $(this).removeClass("bg_color_pink");
            $(this).next().val("");
            $(this).next().next().html('...');
          } else if ($(this).next().next().next().next().val() > 0 && $(this).next().next().next().next().val() < 20) {
            if (!$(this).hasClass("bg_color_yellow")) {
             $(this).removeClass("bg_color_pink");
             $(this).addClass("bg_color_yellow");
            }
          } else if ($(this).next().next().next().next().val() >= 20) {
            if (!$(this).hasClass("bg_color_pink")) {
             $(this).removeClass("bg_color_yellow");
             $(this).addClass("bg_color_pink");
            }
          }
        } else if ($(this).attr("type") === "time" && $(this).attr("data-field") === "attend_time" && $(this).next().val() !== "С" && $(this).next().val() !== "Р" && $(this).next().val() !== "П" && $(this).parent().parent().parent().attr("data-end_time") === "1") {
          minutes = $(this).prev().val().split(":");
          minutes_my = value.split(":");
          // приход раньше
          deff = (minutes[0]*60 + Number(minutes[1])) - (minutes_my[0]*60 + Number(minutes_my[1]));
          $(this).next().next().next().next().val(deff);
          if ($(this).next().next().next().next().val() < 1) {
            $(this).css("background-color", "white");
            $(this).removeClass("bg_color_yellow");
            $(this).removeClass("bg_color_pink");
            $(this).next().val("");
            $(this).next().next().html('...');
          } else if ($(this).next().next().next().next().val() > 0 && $(this).next().next().next().next().val() < 20) {
            if (!$(this).hasClass("bg_color_yellow")) {
             $(this).removeClass("bg_color_pink");
             $(this).addClass("bg_color_yellow");
            }
          } else if ($(this).next().next().next().next().val() >= 20) {
            if (!$(this).hasClass("bg_color_pink")) {
             $(this).removeClass("bg_color_yellow");
             $(this).addClass("bg_color_pink");
            }
          }
        } else if ($(this).next().val() === "С" && $(this).attr("data-field") === "attend_time") {
          let current_element = $(this);
          let next_str, next_field_session, stop = false;
          $("#modal-block_1 .row").each(function (i) {
            if (stop) {
             return;
            }
            if ($(this).attr("data-id") === current_element.parent().parent().parent().attr("data-id")) {
              same_row = true;
            } else if (same_row) {
              next_str = $(this).next();
              next_field_session = $(this).find("input[data-field='session_time']");
              // Если через одну строку от записи служения время начала сессии меньше то блокируем следующий
                if ((next_str.find("input[data-field='session_time']").val() && current_element.val() > next_str.find("input[data-field='session_time']").val()) || (!next_str.find("input[data-field='session_time']").val() && next_str.find("input[data-field='session_time']").attr("data-val"))) {
                  if (!next_str.find("input[data-field='session_time']").val()) {
                    next_str.find("input[data-field='session_time']").val(next_str.find("input[data-field='session_time']").attr("data-val"));
                  }
                  if (next_field_session.next().val()) {
                    next_field_session.next().val("");
                    save_select_field(next_field_session.next(), next_field_session.next().val());
                  }
                  if (!next_field_session.next().prop("disabled")) {
                    next_field_session.next().attr("disabled", true);
                  }
                  if (next_field_session.next().hasClass("bg_color_pink")) {
                    next_field_session.next().removeClass("bg_color_pink");
                  }
                  if (next_field_session.next().hasClass("bg_color_yellow")) {
                    next_field_session.next().removeClass("bg_color_yellow");
                  }
                  if (!next_field_session.prop("disabled")) {
                    next_field_session.attr("disabled", true);
                  }
                  if (next_field_session.next().next().val() !== "С") {
                    next_field_session.next().next().val("С");
                    next_field_session.next().next().next().text("С");
                    save_select_field(next_field_session.next().next(), next_field_session.next().next().val());
                  } else {
                    let text_name_current, text_name_update;
                    text_name_current = $(this).find(".name_session").text();
                    if (text_name_current.charAt(text_name_current.length-4) === ":") {
                      $(this).find(".extra_label").parent().addClass("hide_element");
                      text_name_update = text_name_current.slice(0 , text_name_current.length-8);
                      $(this).find("h6").text(text_name_update);
                      $(this).find(".name_session").text(text_name_update);
                      save_select_field($(this).find(".name_session"), $(this).find(".name_session").text());
                    }
                  }
               } else if (next_field_session.next().prop("disabled")
               || ($(this).find("input[data-field='session_time']").val() && current_element.val() > $(this).find("input[data-field='session_time']").val())
               || next_field_session.prop("disabled") && !next_field_session.next().prop("disabled") && next_field_session.next().next().val() === "С") {
                 // || !next_field_session.next().prop("disabled")
                 if (current_element.val() > $(this).find("input[data-field='session_time']").val()) {
                   //next_str.find("input[data-field='session_time']").val() &&
                   let text_name_current, text_name_update;
                   text_name_current = next_field_session.prev().text();
                   if (text_name_current.charAt(text_name_current.length-4) === ":") {
                     $(this).find(".extra_label").parent().addClass("hide_element");
                     text_name_update = text_name_current.slice(0 , text_name_current.length-8);
                     $(this).find("h6").text(text_name_update);
                     $(this).find(".name_session").text(text_name_update);
                     save_select_field(next_field_session.prev(), next_field_session.prev().text());
                   }
                   next_field_session.val(next_field_session.attr("data-val"));
                   next_field_session.prop("diabled", true);
                   save_select_field(next_field_session, next_field_session.attr("data-val"));
                   next_field_session.next().val("");
                   next_field_session.next().prop("diabled", false);
                   save_select_field(next_field_session.next(), "");
                   next_field_session.next().next().val("С");
                   next_field_session.next().next().next().text("С");
                   save_select_field(next_field_session.next().next(), next_field_session.next().next().val());
                 } else {
                   next_field_session.next().prop("disabled", false);
                   next_field_session.next().next().val("");
                   next_field_session.next().next().next().text("...");
                   save_select_field(next_field_session.next().next(), next_field_session.next().next().val());
                 }
               } else {
                 stop = true;
               }
             }
          });
        }
        // save
        data = "&id="+id+"&field="+field+"&value="+value+"&value_late="+late+"&value_absence="+absence;
        fetch('ajax/ftt_attendance_ajax.php?type=updade_data_blank' + data)
        .then(response => response.json())
        .then(commits => {
          element.parent().parent().attr("data-absence", absence);
          element.parent().parent().attr("data-late", late);
        });
      } else if($(this).hasClass("practice_field")) {
        if ($(this).attr("type") === "checkbox" && $(this).prop("checked")) {
          $("#current_extra_help").find("[data-id="+$("#modalAddEdit").attr("data-id")+"]").find(".trainee_name").text("Да");
          value = 1;
        } else if ($(this).attr("type") === "checkbox") {
          value = 0;
          $("#current_extra_help").find("[data-id="+$("#modalAddEdit").attr("data-id")+"]").find(".trainee_name").text("");
        }
        if (field === "comment") {
          value = value.replace(/'/g, '"');
        } else {
          if (isNaN(value)) {
            showError("Данные должны быть числом.");
            $(this).css("border","1px solid red");
          } else {
            if ($(this).css("border-color", "red")) {
              $(this).css("border-color", "lightgray");
            }
          }
        }

        data = "&field="+field+"&value="+value+"&id="+$("#modalAddEdit").attr("data-id")+"&header=1";
        fetch('ajax/ftt_attendance_ajax.php?type=updade_data_blank' + data)
        .then(response => response.json())
        .then(commits => {
          $("#current_extra_help").find("[data-id="+$("#modalAddEdit").attr("data-id")+"]").attr("data-"+element.attr("data-field"), value);
          console.log(commits.result);
        });
      } else if ($(this).hasClass("select_reason")) {
        let is_reason;
        let late = 0;
        let absence = 0;
        if (value === "С" || value === "Р" || value === "П") {
          is_reason = 1;
        } else {
          is_reason = 0;
          if ($(this).next().val() > 0 && $(this).next().val() < 20) {
            late = 1;
            absence = 0;
          } else if ($(this).next().val() > 20) {
            late = 0;
            absence = 1;
          }
        }
        data = "&field="+field+"&value="+value+"&id="+id+"&header=0&reason="+is_reason+"&late="+late+"&absence="+absence;
        fetch('ajax/ftt_attendance_ajax.php?type=updade_data_blank' + data)
        .then(response => response.json())
        .then(commits => {
          element.parent().parent().attr("data-absence", absence);
          element.parent().parent().attr("data-late", late);
          console.log(commits.result);
        });
      } else {
        console.log("ERROR. EMPTY FIELDS");
      }
      if ($(this).css('border-color') === 'rgb(255, 0, 0)') {
        $(this).css('border-color', 'lightgray');
      }
    });
  });
    $("#morning_revival").val(el_this.attr("data-morning_revival"));
    $("#personal_prayer").val(el_this.attr("data-personal_prayer"));
    $("#common_prayer").val(el_this.attr("data-common_prayer"));
    $("#bible_reading").val(el_this.attr("data-bible_reading"));
    $("#ministry_reading").val(el_this.attr("data-ministry_reading"));

    // desabled
    if (el_this.attr("data-member_key") !== admin_id_gl) {
      $("#modalAddEdit input").attr('disabled', true);
      $("#modalAddEdit select").attr('disabled', true);
      $("#modalAddEdit textarea").attr('disabled', true);
    } else {
      $("#modalAddEdit input").attr('disabled', false);
      $("#modalAddEdit select").attr('disabled', false);
      $("#modalAddEdit textarea").attr('disabled', false);
      $("#group_members_field").attr('disabled', true);
    }

    // fill
    // attr
    $("#modalAddEdit").attr("data-id", el_this.attr("data-id"));
    $("#modalAddEdit").attr("data-date", el_this.attr("data-date"));
    $("#modalAddEdit").attr("data-author", el_this.attr("data-author"));
    $("#modalAddEdit").attr("data-member_key", el_this.attr("data-member_key"));
    $("#modalAddEdit").attr("data-comment", el_this.attr("data-comment"));
    $("#modalAddEdit").attr("data-status", el_this.attr("data-status"));
    $("#modalAddEdit").attr("data-date_send", el_this.attr("data-date_send"));

    // fields more
    let male_word = ' ';

    if (serving_ones_list_full[el_this.attr("data-author")]) {
      if (serving_ones_list_full[el_this.attr("data-author")]['male'] !== '1') {
        male_word = 'а ';
      }
    } else if (trainee_list_full[el_this.attr("data-author")]) {
      if (trainee_list_full[el_this.attr("data-author")]['male'] !== '1') {
        male_word = 'а ';
      }
    }

    let servise_one_author, servise_one_archivator;
    if (serving_ones_list_full[el_this.attr("data-author")]) {
      servise_one_author = serving_ones_list_full[el_this.attr("data-author")]['name'];
    } else {
      servise_one_author = trainee_list[el_this.attr("data-author")];
    }

    let text = 'Создал' + male_word + ' ' + servise_one_author;
    $('#author_of').text(text);
  }
  // конец открытия бланка
  // клик по строке, загружаем форму
  $(".list_string").click(function () {
    open_blank($(this));
  });

 // фильтры
  $('#sevice_one_select').change(function (e) {
    setCookie('filter_serving_one', $(this).val(), 1);
    $("#spinner").modal();
    setTimeout(function () {
      location.reload();
    }, 30);
  });

 // фильтр период
 $('#period_select').change(function (e) {
   setCookie('filter_period_att', $(this).val(), 1);
   $("#spinner").modal();
   setTimeout(function () {
     location.reload();
   }, 30);
 });

 // список применённых фильтров
 function filters_list_show() {
   /* let filters_text; */
   /*if ($(window).width()<=769) {*/
/*   if (trainee_access) {
       filters_text = "Фильтры: " + $("#period_select option:selected").text();
   } else {
       filters_text = "Фильтры: " + $("#sevice_one_select option:selected").text();
   }
*/
   /*} else {
     if ($("#author_select_desk").val()) {
       filters_text = "Фильтры: " + $("#author_select option:selected").text() + ", " + $("#period_select option:selected").text();
     } else {
       filters_text = "Фильтры: " + $("#period_select option:selected").text();
     }
   }*/
  /* $("#filters_list").text(filters_text);*/
 }
 //filters_list_show();

 // info of
 $("#info_of").click(function () {
   if ($("#date_of_archive").is(":visible")) {
     $("#date_of_archive").parent().hide();
   } else {
     $("#date_of_archive").parent().show();
   }
 });

 // закрытие по кнопке
 $('#modalAddEdit .btn-secondary').click(function (e) {
   if (trainee_access) {
    location.reload();
   }
   // открывам окно архива
   /*if ($("#modalAddEdit").attr("data-list") === "1") {
     setTimeout(function () {
       $('#archive_list').modal("show");
     }, 400);
   }*/
 });

 // закрытие на крестик
 $('#modalAddEdit .close').click(function (e) {
   if (trainee_access) {
    location.reload();
   }
   // открывам окно архива
   /*if ($("#modalAddEdit").attr("data-list") === "1") {
     setTimeout(function () {
       $('#archive_list').modal("show");
     }, 400);
   }*/
 });

 $('.card_header button').click(function (e) {
   $("#archive_list").modal("show");
   fetch("ajax/ftt_attendance_ajax.php?type=get_attendance_archive&member_key="+$(this).parent().parent().attr("data-member_key")+"&period=_all_")
   .then(response => response.json())
   .then(commits => {
     let res = commits.result;
     let html = [];
     let html_part_empty = "";
     if (getNameDayOfWeekByDayNumber(res[0].date, false, false, true) === 0) {
       for (let i = 0; i < 6; i++) {
         res.unshift("");
       }
     } else if (getNameDayOfWeekByDayNumber(res[0].date, false, false, true) === 2) {
       for (let i = 0; i < 1; i++) {
         res.unshift("");
       }
     } else if (getNameDayOfWeekByDayNumber(res[0].date, false, false, true) === 3) {
       for (let i = 0; i < 2; i++) {
         res.unshift("");
       }
     } else if (getNameDayOfWeekByDayNumber(res[0].date, false, false, true) === 4) {
       for (let i = 0; i < 3; i++) {
         res.unshift("");
       }
     } else if (getNameDayOfWeekByDayNumber(res[0].date, false, false, true) === 5) {
       for (let i = 0; i < 4; i++) {
         res.unshift("");
       }
     } else if (getNameDayOfWeekByDayNumber(res[0].date, false, false, true) === 6) {
       for (let i = 0; i < 5; i++) {
         res.unshift("");
       }
     }
     for (var i = 0; i < res.length; i++) {
       //res[i]['serving_one'];
       if (i % 7 === 0 && i > 0) {
           html.push("</div>");
       }
       let date = dateStrFromyyyymmddToddmm(res[i].date);
       let day = getNameDayOfWeekByDayNumber(res[i].date, true, true);
       let day_number = getNameDayOfWeekByDayNumber(res[i].date, false, false, true);
       let sunday_back, done_string;
       day_number === 0 ? sunday_back = "font-weight-bold" : sunday_back = "";
       res[i].status === '1' ? done_string = "green_string" : done_string = "";
       if (!res[i]) {
         day = "";
         date = "";
       }
       let html_part_span = "<span class='list_string list_string_archive link_day "+sunday_back+" "+done_string+"' data-id='"+res[i].id+"' data-date='"+date+"' data-member_key='"+res[i].member_key+"' data-status='"+res[i].status+"' data-date_send='"+res[i].date_send+"' data-bible='"+res[i].bible+"' data-morning_revival='"+res[i].morning_revival+"' data-personal_prayer='"+res[i].personal_prayer+"' data-common_prayer='"+res[i].common_prayer+"' data-bible_reading='"+res[i].bible_reading+"' data-ministry_reading='"+res[i].ministry_reading+"' data-serving_one='"+res[i].serving_one+"' data-comment='"+res[i].comment+"'>"+date+" "+day+"</span>";
       if (i % 7 === 0) {
        html.push("<div class='row archive_str' style='margin-bottom: 2px;' data-member_key='member_key'>"+html_part_span);
      } else {
        html.push(html_part_span);
      }
    }
    $("#archive_content").html(html.join(''));
    // клик по строке, загружаем форму
    $(".list_string_archive").click(function () {
      $("#archive_list").modal("hide");
      setTimeout(function () {
        $("#modalAddEdit").modal("show");
      }, 400);
      open_blank($(this));
    });
   });
 });

 $("#bible_reading, #morning_revival, #personal_prayer, #common_prayer, #ministry_reading").click(function () {
   if ($(this).val() === "0") {
     $(this).val("");
   }
 });

 $("#add_attendance_str").click(function() {
   if ($("#modal-block_staff").is(":visible")) {
     $("#modal-block_1").show();
     $("#modal-block_2").show();
     $("#modal-block_staff").hide();
     //if ($("#modal-block_staff").attr("data-changed") === "1") {
       $("#accordion_attendance").each(function () {

       })
       //let hi_bay = $("#accordion_attendance [data-id='"+$("#modalAddEdit").attr("data-id")+"']");
       //console.log(hi_bay.attr("data-id")); //.attr("data-id")
       open_blank($("#accordion_attendance [data-id='"+$("#modalAddEdit").attr("data-id")+"']"));
     //}
   } else {
     get_sessions_for_blank($("#modalAddEdit").attr("data-member_key"), $("#modalAddEdit").attr("data-date"));

     $("#modal-block_1").hide();
     $("#modal-block_2").hide();
     $("#modal-block_staff").show();
   }
  });

  // Правка мероприятий в бланке
  // формимуем список мероприятий из расписания
  function get_sessions_for_blank(member_key, date) {
    let semester_range;
    let day_of_date = "day"+getNameDayOfWeekByDayNumber(date, false, false, true);
    if (day_of_date === "day0") {
      day_of_date = "day7";
    }
    trainee_list_full[member_key]["semester"] > 4 ? semester_range = 2 : semester_range = 1;
    fetch("ajax/ftt_attendance_ajax.php?type=get_sessions_staff&semester_range="
    +semester_range+"&time_zone="+trainee_list_full[member_key]["time_zone"]+"&date="+date+"&day="+day_of_date)
    .then(response => response.json())
    .then(commits => {
      console.log(commits.result);
      // отметка включеных мероприятий
      let exist_session = [];
      $("#modal-block_1 .name_session").each(function () {
        exist_session.push($(this).next().attr("data-val"));
      });
      let sessions_staff = commits.result;
      let checked_str, no_checked;
      let html_staff_editor= "<div><label class='form-check-label'><input class='select_all_session form-check-input' type='checkbox'>Добавить/Удалить все</label></div><hr>";
      for (let session_str in sessions_staff) {
        if (sessions_staff.hasOwnProperty(session_str)) {
          if (sessions_staff[session_str]["attendance"] === "1" && sessions_staff[session_str][day_of_date]) {
            if (exist_session.indexOf(sessions_staff[session_str][day_of_date]) === -1) {
              no_checked = true;
              checked_str = "";
            } else {
              checked_str = "checked";
            }
            html_staff_editor += "<div><label class='form-check-label'><input type='checkbox' class='session_staff_str form-check-input' data-day='"+sessions_staff[session_str][day_of_date]
            +"' data-session_name='"+sessions_staff[session_str]["session_name"]+"' data-session_id='"+sessions_staff[session_str]["id"]
            +"' data-visit='"+sessions_staff[session_str]["visit"]+"' data-end_time='"+sessions_staff[session_str]["end_time"]
            +"' data-duration='"+sessions_staff[session_str]["duration"]+"' data-comment='"+sessions_staff[session_str]["comment"]
            +"' "+checked_str+">"+sessions_staff[session_str]["session_name"]+"</label></div>"
          }
        }
      }
      $("#modal-block_staff_body").html(html_staff_editor);
      $(".select_all_session").prop("checked", true);
      if (no_checked) {
        $(".select_all_session").prop("checked", false);
      }
      // построчное вкл/выкл мероприятий в бланке
      $(".session_staff_str").change(function () {
        console.log("I am here!");
      });
      // пакетные операции вкл/выкл мероприятий в бланке
      $(".select_all_session").change(function () {

        // Отслеживать включенные мероприятия и отмечать галочкали присутствующие в бланке, если все присутствуют помечать
        // "вкл выкл всё" отмеченным.
        // обычный сценарий это все включены все выключены, учитывать это

        if ($(this).prop("checked")) {
          if (confirm("Включить учёт в этот день?")) {
            let session_staff_str = new FormData();
            let session_staff_str_test = [];
            $(".session_staff_str").prop("checked", $(this).prop("checked"));
            $(".session_staff_str").each(function (e) {
              session_staff_str_test[e] = {};
              session_staff_str_test[e]["id_sheet"] = $("#modalAddEdit").attr("data-id");
              session_staff_str_test[e]["session_id"] = $(this).attr("data-session_id");
              session_staff_str_test[e]["session_name"] = $(this).attr("data-session_name");
              session_staff_str_test[e]["session_time"] = $(this).attr("data-day");
              session_staff_str_test[e]["duration"] = $(this).attr("data-duration");
              session_staff_str_test[e]["end_time"] = $(this).attr("data-end_time");
              session_staff_str_test[e]["visit"] = $(this).attr("data-visit");
            });

  // УЧИТЫВАТЬ СУЩЕСТВУЮЩИЕ СТРОКИ !!! Пока сделать ПАКЕТНЫЙ

              session_staff_str.set("data", JSON.stringify(session_staff_str_test));

              fetch("ajax/ftt_attendance_ajax.php?type=add_sessions_staff_all", {
                method: 'POST',
                body: session_staff_str
              })
              .then(response => response.text())
              .then(commits => {
                console.log(commits.result);
              // location.reload();
              });
          } else {
            //$(".session_staff_str").prop("checked", false);
            $(this).prop("checked", false);
          }
        } else {
          if (confirm("В этот день учёт не ведётся?")) {
            $(".session_staff_str").prop("checked", $(this).prop("checked"));
            //$("#modalAddEdit").modal("hide");
            fetch('ajax/ftt_attendance_ajax.php?type=dlt_sessions_in_blank&id='+$("#modalAddEdit").attr("data-id"))
            .then(response => response.json())
            .then(commits => {
            });
          } else {
            $(this).prop("checked", true);
          }
        }
      });
    });
    // лучше запускать при открытии соответствующего раздела.
    // Получаем данные из класса PHP аттендансе = 1
    // рендерим список
    // сверяем соответствие (наличие) и отмечаем галочками
    // Вопрос, нужна ли кнопка Применить? думаю ненужна.
    // при отметке всех галочек применяем функцию удалить всё/добавить всё
    // при снятии галочки удаляем мероприятие из таблицы аттенданс или добавляем при установки галочки
    //AJAX schedule_class::get();
  }
  // ОТКАТ
  // удаление мероприятий из бланка
  $("#undo_attendance_str").click(function () {
    // Условия
    if ($("#modalAddEdit").attr("data-status") === 0) {
      showError("Этот лист посещаемости не отправлен. Откат невозможен.");
      return;
    }
    let date_send_str = $("#modalAddEdit").attr("data-date_send");
    let date_send = new Date(date_send_str);
    let day_send = date_send.getDay();
    let day_current = new Date();
    let dayNumber_current = day_current.getDay();
    let result_date = (day_current - date_send) - ((day_send+1)*(24*60*60)*1000);
    // Откат возможен с вс по сб недели в который он отправлен
    if (day_send > day_current && date_send > day_current && Math.floor(result_date) > 1) {
      showError("Этот лист посещаемости находится в закрытом периоде. Откат невозможен.");
      return
    }

    // Убираем статус один и удаляем опаздания и прогулы


    // внести изменения в строку и в бланк или перезагрузить страницу?
  });
// DOCUMENT READY STOP
});
