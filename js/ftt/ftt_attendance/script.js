/* ==== MAIN & ATTENDANCE START ==== */
$(document).ready(function(){
  // текущая дата гггг-мм-дд
  date_now_gl = date_now_gl ();

  // get cookie
  if (getCookie("tab_active") === "permission") {
    if (getCookie("flt_trainee") !== "") {
      setCookie("flt_trainee", "");
      filters_permissions();
    }
  }

  $("#extra_help_staff .nav-link").click(function () {
    if ($(this).attr("href") === "#permission_tab") {
      setCookie("tab_active", "permission");
      setTimeout(function () {
        location.reload();
      }, 30);
    } else if ($(this).attr("href") === "#missed_class_tab") {
      setCookie("tab_active", "missed_class");
      setTimeout(function () {
        location.reload();
      }, 30);
    } else if ($(this).attr("href") === "#meet_tab") {
      setCookie("tab_active", "meet");
      setTimeout(function () {
        location.reload();
      }, 30);
    } else {
      setCookie("tab_active", "");
      setTimeout(function () {
        location.reload();
      }, 30);
    }
  });

  // save select field
  function save_select_field(element, value) {
    let field = element.attr("data-field");
    let id = element.parent().parent().parent().attr("data-id");
    let data = "&field="+field+"&value="+value+"&id="+id+"&header=0";
    fetch('ajax/ftt_attendance_ajax.php?type=updade_data_blank' + data)
    .then(response => response.json())
    .then(commits => {
      //console.log(commits.result);
    });
 }

 function save_select_field_extra(field, value, header) {
   let id = $("#modalAddEdit").attr("data-id");
   if (field === "book_ot" || field === "book_nt") {
     let book, chapter;
     if (value == 0) {
       if (field === "book_ot") {
         value = $("#bible_book_ot option:nth-child(3)").attr("data-book") + " " + String("0");
       } else if (field === "book_nt") {
         value = $("#bible_book_nt option:nth-child(3)").attr("data-book") + " " + String("0");
       }
     }
     value = value.split(" ");
     if (value[2]) {
       book = value[0] + " " + value[1];
       chapter = value[2];
     } else {
       book = value[0];
       chapter = value[1];
     }

     let data = "&member_key=" + $("#modalAddEdit").attr("data-member_key")
     + "&date=" + $("#modalAddEdit").attr("data-date")
     + "&book_field=" + field + "&book=" + book + "&chapter=" + chapter
     + "&notes_ot=" + $(".reading_bible_title").attr("data-notes_ot")
     + "&notes_nt=" + $(".reading_bible_title").attr("data-notes_nt");
     fetch('ajax/ftt_reading_ajax.php?type=set_reading_bible' + data)
     .then(response => response.json())
     .then(commits => {
       //console.log(commits.result);
     });
   } else {
     let data = "&field="+field+"&value="+value+"&id="+id+"&header="+header;
     fetch('ajax/ftt_attendance_ajax.php?type=updade_data_blank' + data)
     .then(response => response.json())
     .then(commits => {
       //console.log(commits.result);
     });
   }
}

 // send data
 function send_data_blank(id, late, extrahelp) {
   $("#modalAddEdit").modal("hide");
   $("#spinner").modal("show");
   if (extrahelp.length > 0 || late.length > 0) {
     fetch("ajax/ftt_attendance_ajax.php?type=updade_mark_blank&id="+id+"&field=mark&value=1&header=1")
     .then(response => response.text())
     .then(commits => {
       //console.log(commits);
     });
   }
   // set extra help
   if (extrahelp[0]) {
     for (let i = 0; i < extrahelp.length; i++) {
       setTimeout(function () {
         fetch('ajax/ftt_attendance_ajax.php?type=create_extrahelp'+extrahelp[i])
         .then(response => response.text())
         .then(commits => {
           //console.log(commits);
         });
       }, 13);
     }
   }

   // set extra help
   if (late[0]) {
     for (let i = 0; i < late.length; i++) {
       setTimeout(function () {
         fetch('ajax/ftt_attendance_ajax.php?type=create_late'+late[i])
         .then(response => response.text())
         .then(commits => {
           //console.log(commits);
         });
       }, 10);
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

  // закрытие бланка
  $("#modalAddEdit").on("hide.bs.modal", function () {
    $("#bible_book_ot").show();
    $("#bible_book_nt").show();
  });

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
   } else if ($("#modalAddEdit").attr("data-status") === "2") {
     showError('Бланк не был отправлен. Нельзя сохранить.');
     return;
   }
   if ((!$("#bible_book_ot").val() && !$("#bible_book_ot").attr("disabled")) || (!$("#bible_book_nt").val()  && !$("#bible_book_nt").attr("disabled"))) {
     showError('Заполните поля чтения Библии.');
     if ($("#bible_book_ot").val() === "_none_") {
       $("#bible_book_ot").css("border-color", "red");
     } else {
       $("#bible_book_ot").css("border-color", "lightgray");
     }
     if ($("#bible_book_nt").val() === "_none_") {
       $("#bible_book_nt").css("border-color", "red");
     } else {
       $("#bible_book_nt").css("border-color", "lightgray");
     }
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
       if ($(this).hasClass("bg_color_yellow") && $(this).next().val() !== "Р") { // && $(this).next().val() === "О"
         create_late.push("&id="+$(this).parent().parent().parent().attr("data-id")
         +"&delay="+$(this).next().next().next().next().val()
         + "&date="+$("#modalAddEdit").attr("data-date")
         +"&session_name="+$(this).parent().parent().find("h6").text()
         +"&member_key="+$("#modalAddEdit").attr("data-member_key")
         +"&end_time="+$(this).parent().parent().parent().attr("data-end_time")
         +"&id_attendance="+$("#modalAddEdit").attr("data-id"));
       } else if ($(this).hasClass("bg_color_pink") && $(this).next().val() !== "Р") { //&& $(this).next().val() === "О"
         let text_msg = "опоздание";
         if ($(this).parent().parent().parent().attr("data-end_time") === "1") {
           text_msg = "приход раньше";
         }
         let data_ddmm = dateStrFromyyyymmddToddmm($("#modalAddEdit").attr("data-date"));
         reason = data_ddmm + " " + $(this).parent().parent().find("h6").text() + " – "+text_msg+" на " + $(this).next().next().next().next().val() + " мин.";
         if ($(this).next().next().next().next().val() == 0) {
           reason = data_ddmm+" "+$(this).parent().parent().find("h6").text()+" – отсутствие без разрешения";
         }
         create_extrahelp.push("&id="+$(this).parent().parent().parent().attr("data-id")
         +"&reason="+reason+"&date="+$("#modalAddEdit").attr("data-date")
         +"&member_key="+$("#modalAddEdit").attr("data-member_key")
         +"&attendance_id="+$("#modalAddEdit").attr("data-id"));
       } else if (!$(this).val() && $(this).next().val() === "О") {
         let data_ddmm = dateStrFromyyyymmddToddmm($("#modalAddEdit").attr("data-date"));
         reason = data_ddmm + " " + $(this).parent().parent().find("h6").text() + " – отсутствие без разрешения.";
         create_extrahelp.push("&id="+$(this).parent().parent().parent().attr("data-id")
         +"&reason="+reason+"&date="+$("#modalAddEdit").attr("data-date")
         +"&member_key="+$("#modalAddEdit").attr("data-member_key")
         +"&attendance_id="+$("#modalAddEdit").attr("data-id"));
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
            let session_text = $(this).parent().parent().find("h6").text();
            let data_ddmm = dateStrFromyyyymmddToddmm($("#modalAddEdit").attr("data-date"));
            reason = data_ddmm + " " + session_text + " – отсутствие без разрешения.";
            create_extrahelp.push("&id="+$(this).parent().parent().parent().attr("data-id")
            +"&reason="+reason+"&date="+$("#modalAddEdit").attr("data-date")
            +"&member_key="+$("#modalAddEdit").attr("data-member_key")
            +"&attendance_id="+$("#modalAddEdit").attr("data-id"));
            // save select field
            field = $(this).next().attr("data-field");
            id = $(this).parent().parent().parent().attr("data-id");
            data = "&field="+field+"&value=О&id="+id+"&header=0";
            fetch('ajax/ftt_attendance_ajax.php?type=updade_data_blank' + data)
            .then(response => response.json())
            .then(commits => {
              //console.log(commits.result);
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

 $('#modalAddEdit select').change(function (e) {
   let id = $("#modalAddEdit").attr("data-id");
   let value = $(this).val();
   save_select_field_extra($(this).attr("data-field"), value, 1);
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
   let text_stts_for_blank = "<span class='badge badge-secondary text-right' style='font-size: 100%;'>не отправлен</span>";
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
     text_stts_for_blank = "<span class='badge badge-success text-right' style='font-size: 100%;'>отправлен "+date_date+" "+date_time+"</span>";
   } else if (status_sheet === "2") {
     text_stts_for_blank = "<span class='badge badge-warning text-right' style='font-size: 100%;'>не был отправлен</span>";
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
           // *** BIBLE HERE *** //
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

      if ((deff_rend > 0 && deff_rend < 20) && (btn_text === "..." || btn_text === "О" || btn_text === "Р")) {
        bg_color_time = "bg_color_yellow";
      } else if ((deff_rend >= 20 && (btn_text === "..." || btn_text === "О" || btn_text === "Р")) || (deff_rend === 0 && btn_text === "О")) {
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

      if (commits.result[i]['visit'] === "1" || commits.result[i]['session_name'] === "Отбой") {
        option_visit = "<option value='П' "+v+">П</option>";
        drop_visit = "<span class='dropdown-item cursor-pointer' data-val='П'>Посещение (П)</span>"
      }
      let  text_success = "";
      let  text_success_btn = "btn-secondary";
      if (commits.result[i]['permission_sheet_id'] > 0) {
        text_success = "btn-success";
      }
      if (commits.result[i]['permission_sheet_id'] > 0 && commits.result[i]['reason'] === "Р") {
        text_success_btn = "btn-success";
      }

      srings.push("<div class='row' data-id='"+commits.result[i]['id']+"' data-visit='"+visit_field+"' data-end_time='"+commits.result[i]['end_time']+"' data-correction_id='"+commits.result[i]['session_correction_id']+"' data-absence='"+
      commits.result[i]['absence']+"' data-late='"+commits.result[i]['late']+"' data-permission_id='"+
      commits.result[i]['permission_sheet_id']+"' style='"+mb_2+"'><div class='col-12'><h6 class='"+hide_element+"'>"+ commits.result[i]['session_name']
      +"</h6>"+extra_label+"<div class='input-group "+mb_3+"'><span data-text='"+render_session_name
      +"' data-field='session_name' class='align-self-center name_session "+hide_element_mbl+"'>"+ commits.result[i]['session_name']
      +"</span><input type='time' data-val='"+time_val+"' value='"+commits.result[i]['session_time']
      +"' class='form-control "+bg_light+" mr-3 ' required data-field='session_time' "+disabled_extra+" "+disabled_service+"><input type='time' class='form-control mr-3  "+bg_color_time+"' data-field='attend_time' value='"+commits.result[i]['attend_time']
      +"' "+disabled+" "+disabled_service+"><select data-field='reason' class='select_reason bg-secondary text-light short_select_field hide_element'"
      +disabled+"><option value=''>...</option>"+option_visit+"<option value='Р' "+p
      +">Р</option><option value='С' "+c+">С</option><option value='О' "+o
      +">О</option></select><button type='button' class='btn dropdown-toggle-split "+
      text_success_btn+"' data-toggle='dropdown'>"+btn_text
      +"</button><div class='dropdown-menu'><span class='dropdown-item cursor-pointer' data-val='...'>...</span>"+drop_visit
      +"<span class='dropdown-item cursor-pointer' style='display: none;' data-val='П'>Посещение</span><span data-val='Р' class='dropdown-item cursor-pointer "+text_success+
      "'>Разрешение (Р)</span><span class='dropdown-item cursor-pointer' data-val='С'>Служение (С)</span><span class='dropdown-item cursor-pointer' data-val='О'>Отстутствие (О)</span></div><input type='number' class='hide_element' value='"
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
      if ((status_sheet === "1" && trainee_access) || (status_sheet !== "1" && !trainee_access && $("#modalAddEdit").attr("data-member_key") !== window.adminId) || status_sheet === "2") {
        e.stopPropagation(); //|| (text.charAt(text.length-4) !== ":" && $(this).text() === "С")
      }
    });
    $(".dropdown-item").click(function () {
      if (($(this).attr("data-val") === "С" && $(this).parent().prev().text() === "С")
      || ($(this).attr("data-val") === "Р" && $(this).parent().prev().text() === "Р")
      || ($(this).attr("data-val") === "О" && $(this).parent().prev().text() === "О")
      || ($(this).attr("data-val") === "..." && $(this).parent().prev().text() === "...")
      || ($(this).attr("data-val") === "П" && $(this).parent().prev().text() === "П")) {
        return;
      }

      if ($(this).attr("data-val") === "Р" && $(this).parent().parent().parent().parent().attr("data-permission_id") !== "0") {
        $(this).parent().prev().removeClass("btn-secondary").addClass("btn-success");
      } else if ($(this).parent().prev().hasClass("btn-success")) {
        $(this).parent().prev().removeClass("btn-success").addClass("btn-secondary");
      }
      // ночёвка
      if ($(this).attr("data-val") === "П" && $(this).parent().parent().find(".name_session").text() === "Отбой") {
        fetch("ajax/ftt_attendance_ajax.php?type=overnight&member_key=" + $("#modalAddEdit").attr("data-member_key")+"&date=" + $("#modalAddEdit").attr("data-date"))
        .then(response => response.json())
        .then(commits => {
          console.log(commits.result);
          if (commits.result) {
            $(this).parent().prev().prev().val("");
            $(this).parent().prev().text("...")
            save_select_field($(this).parent().prev().prev(), "");
            showError("В этом месяце уже была ночёвка у святых " + dateStrFromyyyymmddToddmm(commits.result) + ".");
          }
        });
      }
      if (!$(this).parent().prev().prev().prop("disabled")) {
        let prev_val = $(this).parent().prev().prev().val();
        let value_not_dot;
        $(this).parent().prev().prev().val($(this).attr("data-val"));
        if ($(this).attr("data-val") === "...") {
          value_not_dot = "";
        } else {
          value_not_dot = $(this).attr("data-val");
        }

        save_select_field($(this).parent().prev().prev(), value_not_dot);

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
          let session_text_change = $(this).parent().prev().prev().prev().prev().prev().attr("data-text").trim();
          if (session_text_change[session_text_change.length - 1] === ">") {
            session_text_change = session_text_change.split("<");
            session_text_change = session_text_change[0];
          }
          if (str_session_name.charAt(str_session_name.length-4) === ":") {
            save_select_field($(this).parent().prev().prev().prev().prev().prev(), session_text_change);
            $(this).parent().prev().prev().prev().prev().val($(this).parent().prev().prev().prev().prev().attr("data-val"));
            save_select_field($(this).parent().prev().prev().prev().prev(), $(this).parent().prev().prev().prev().prev().attr("data-val"));
          }
          $(this).parent().prev().prev().prev().prev().attr("disabled", true);
          $(this).parent().prev().prev().prev().prev().addClass("bg-light");
          $(this).parent().prev().prev().prev().prev().prev().text(session_text_change);
          $(this).parent().parent().prev().prev().text(session_text_change);
          $(this).parent().parent().prev().addClass("hide_element");

          // сбрасываем и сохраняем время прихода
          if ($(this).attr("data-val") !== "Р") {
            // очищаем поле времени прихода/ухода
            $(this).parent().prev().prev().prev().val("");
            $(this).parent().prev().prev().prev().removeClass("bg_color_pink");
            $(this).parent().prev().prev().prev().removeClass("bg_color_yellow");
            save_select_field($(this).parent().prev().prev().prev(), "");
          }
        }
        $(this).parent().prev().html($(this).attr("data-val"));
      }
    });

    if (status_sheet === "1" && (trainee_access || (!trainee_access && el_this.attr('data-member_key') === window.adminId))) {
      $('#modalAddEdit input').attr("disabled", true);
      $('#modalAddEdit select').attr("disabled", true);
      $('#send_blank').hide();
      $('#add_attendance_str').attr("disabled", true);
      $('#add_attendance_str').hide();
      $("#undo_attendance_str").prop("disabled", true);
      $("#undo_attendance_str").hide();
      $("#show_me_start").attr("disabled", true);
    } else if (status_sheet === "0" && (!trainee_access && el_this.attr('data-member_key') !== window.adminId)) {
      $('#modalAddEdit input').attr("disabled", true);
      $('#modalAddEdit select').attr("disabled", true);
      $('#send_blank').hide();
      $("#undo_attendance_str").prop("disabled", true);
      $("#undo_attendance_str").hide();
      if ($(window).width()<=769) {
        $('#add_attendance_str').attr("style", "margin-right: 196px;");
      } else {
        $('#add_attendance_str').attr("style", "margin-right: 355px;");
      }
      $('#add_attendance_str').attr("disabled", false);
      $('#add_attendance_str').show();
    } else if (status_sheet === "2") {
      $('#modalAddEdit input').attr("disabled", true);
      $('#modalAddEdit select').attr("disabled", true);
       $("#undo_attendance_str").prop("disabled", true);
       $("#undo_attendance_str").hide();
       $('#send_blank').hide();
       $('#send_blank').prop("disabled", true);
       $('#add_attendance_str').attr("disabled", true);
       $('#add_attendance_str').hide();
       $("#show_me_start").attr("disabled", true);
     } else if (status_sheet === "0" && (!trainee_access && el_this.attr('data-member_key') === window.adminId)) {
       $('#modalAddEdit select').attr("disabled", false);
       $('#modalAddEdit input').attr("disabled", false);
       $('#send_blank').show();
       $("#undo_attendance_str").hide();
       $('#add_attendance_str').hide();
       $("#show_me_start").attr("disabled", false);
     } else {
     if (status_sheet === "1" && (!trainee_access && el_this.attr('data-member_key') !== window.adminId)) {
       $('#send_blank').hide();
       $("#undo_attendance_str").prop("disabled", false);
       $("#undo_attendance_str").show();
       $('#add_attendance_str').attr("disabled", true);
       $('#add_attendance_str').hide();
     } else {
       $('#send_blank').show();
       $("#undo_attendance_str").prop("disabled", true);
       $("#undo_attendance_str").hide();
       $('#add_attendance_str').attr("disabled", true);
       $('#add_attendance_str').hide();
     }

     $('#modalAddEdit select').attr("disabled", false);
     $('#comment_modal').attr("disabled", false);
     $(".practice_field").attr("disabled", false);
     if ($(window).width()<=769) {
       $('#undo_attendance_str').attr("style", "margin-right: 190px;");
     } else {
       $('#undo_attendance_str').attr("style", "margin-right: 355px;");
     }
     $('#add_attendance_str').hide();
   }

   // Авто подстановка времени мероприятия в поле прихода .focusout()
    $("#modalAddEdit input[data-field='attend_time']").on("input", function (e) {
      if ($(window).width()<=769) {
        save_select_field($(this), $(this).val());
      }
    });

    $("#modalAddEdit input[data-field='attend_time']").click(function() {
      if ($(window).width()<=769) {
        if ($(this).val() || $(this).next().val() || $(this).attr("disabled")) {
          return;
        }
        $(this).val($(this).prev().val());
        let elem = $(this);
        setTimeout(function () {
          elem.val("");
        }, 0);
      }
    });

    // change fields
    $('#modalAddEdit input').change(function () { //, #modalAddEdit select
      if (($("#modalAddEdit").attr("data-status") === "1" && trainee_access) || ($("#modalAddEdit").attr("data-status") !== "1" && !trainee_access && $("#modalAddEdit").attr("data-member_key") !== window.adminId) || $("#modalAddEdit").attr("data-status") === "2") {
        showError("Данные не будут сохранены.");
        return;
      }
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
        } else if ($(this).attr("type") === "time" && $(this).attr("data-field") === "attend_time" && $(this).next().val() !== "С" && $(this).next().val() !== "П" && $(this).parent().parent().parent().attr("data-end_time") !== "1") {
          // && $(this).next().val() !== "Р"
          minutes = $(this).prev().val().split(":");
          minutes_my = value.split(":");
          // приход раньше
          deff = (minutes_my[0]*60 + Number(minutes_my[1])) - (minutes[0]*60 + Number(minutes[1]));
          $(this).next().next().next().next().val(deff);
          if ($(this).next().next().next().next().val() < 1) {
            $(this).css("background-color", "white");
            $(this).removeClass("bg_color_yellow");
            $(this).removeClass("bg_color_pink");
            if ($(this).next().val() !== "Р") {
              $(this).next().val("");
              $(this).next().next().html('...');
            }
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
        } else if ($(this).attr("type") === "time" && $(this).attr("data-field") === "attend_time" && $(this).next().val() !== "С" && $(this).next().val() !== "П" && $(this).parent().parent().parent().attr("data-end_time") === "1") {
          //&& $(this).next().val() !== "Р"
          minutes = $(this).prev().val().split(":");
          minutes_my = value.split(":");
          // приход раньше
          deff = (minutes[0]*60 + Number(minutes[1])) - (minutes_my[0]*60 + Number(minutes_my[1]));
          $(this).next().next().next().next().val(deff);
          if ($(this).next().next().next().next().val() < 1) {
            $(this).css("background-color", "white");
            $(this).removeClass("bg_color_yellow");
            $(this).removeClass("bg_color_pink");
            if ($(this).next().val() !== "Р") {
              $(this).next().val("");
              $(this).next().next().html('...');
            }
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
          //console.log(commits.result);
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
    //$("#bible_reading").val(el_this.attr("data-bible_reading"));
//    $("#bible_book").val(el_this.attr("data-bible_book"));
//    $("#bible_chapter").val(el_this.attr("data-bible_chapter"));
    $("#ministry_reading").val(el_this.attr("data-ministry_reading"));

    // desabled
    if (el_this.attr("data-member_key") !== admin_id_gl) {
      $("#modalAddEdit input").attr('disabled', true);
      $("#modalAddEdit select").attr('disabled', true);
      $("#modalAddEdit textarea").attr('disabled', true);
    } else {
      $("#modalAddEdit input").attr('disabled', false);
      // $("#modalAddEdit select").attr('disabled', false);
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

    // книга и глава библии
    // bible
    // *** BIBLE HERE *** //
    setTimeout(function () {
      fetch("ajax/ftt_reading_ajax.php?type=get_reading_data&member_key="
      + el_this.attr("data-member_key") + "&date=" + el_this.attr("data-date"))
      .then(response => response.json())
      .then(commits => {
        let reading_str = commits.result
        let notes_ot = "", notes_nt = "";
       if (reading_str === 0) {
          // Нет старта и сегодняшней строки
          $(".reading_bible_title").html("Чтение Библии" + " — выберите начало");
          //setTimeout(function () {
            $("#bible_book_ot").attr("disabled", true).css("background-color", "#f8f9fa");
            $("#bible_book_nt").attr("disabled", true).css("background-color", "#f8f9fa");
          //}, 250);
          return;
        } else {
          let comma = "";
          if (reading_str["book_nt"] && reading_str["book_ot"]) {
            comma = ",";
          }

          if (reading_str["read_footnotes_ot"] === "1") {
            notes_ot += " с прим.";
          }
          if (reading_str["read_footnotes_nt"] === "1") {
            notes_nt += " с прим.";
          }
          $(".reading_bible_title").text("Чтение Библии " + "(" + reading_str["book_ot"] + comma + " " + notes_ot + " " + reading_str["book_nt"] + " " + notes_nt + ")");
          $(".reading_bible_title").attr("data-notes_ot", reading_str["read_footnotes_ot"]);
          $(".reading_bible_title").attr("data-notes_nt", reading_str["read_footnotes_nt"]);
          $(".reading_bible_title").attr("data-book_ot", reading_str["book_ot"]);
          $(".reading_bible_title").attr("data-book_nt", reading_str["book_nt"]);
        }

        if (reading_str['book_ot'] && $("#modalAddEdit").attr("data-status") === "0") {
          $("#bible_book_ot").attr("disabled", false).css("background-color", "white");
          $("#bible_book_ot").show();
        } else {
          if (!reading_str['book_ot']) {
            $("#bible_book_ot").hide();
          }
          $("#bible_book_ot").attr("disabled", true).css("background-color", "#f8f9fa");
        }
        if (reading_str['book_nt'] && $("#modalAddEdit").attr("data-status") === "0") {
          $("#bible_book_nt").attr("disabled", false).css("background-color", "white");
          $("#bible_book_nt").show();
        } else {
          if (!reading_str['book_nt']) {
            $("#bible_book_nt").hide();
          }
          $("#bible_book_nt").attr("disabled", true).css("background-color", "#f8f9fa");
        }
        if ($("#modalAddEdit").attr("data-status") !== "0") {
          $("#show_me_start").attr("disabled", true).css("background-color", "#f8f9fa");
        } else {
          $("#show_me_start").attr("disabled", false).css("background-color", "white");
        }
        // OT
        render_bible_chapters(reading_str["book_ot"], reading_str['chapter_ot'], "#bible_book_ot");

        // NT
        render_bible_chapters(reading_str["book_nt"], reading_str['chapter_nt'], "#bible_book_nt");

        // устанавливаем значения
        // reading_str['today_ot'] должен быть 1 если запись существует и она === 0
        if (reading_str['chapter_ot'] && reading_str['today_ot']) {
          $("#bible_book_ot").val(reading_str["book_ot"] + " " + reading_str['chapter_ot']);
        } /*else if(reading_str['chapter_ot'] && reading_str['chapter_ot'] !== "0" && !reading_str['today_ot']) {
          $("#bible_book_ot").val(0);
        }*/
        if (reading_str['chapter_nt'] && reading_str['today_nt']) {
          $("#bible_book_nt").val(reading_str["book_nt"] + " " + reading_str['chapter_nt']);
        } /*else if(reading_str['chapter_nt'] && reading_str['chapter_nt'] !== "0" && !reading_str['today_nt']) {
          // $("#bible_book_nt").val(0);
        }*/

        if (reading_str['start_today'] == 1) {
          $("#bible_book_ot").attr("disabled", true).css("background-color", "#f8f9fa");
          $("#bible_book_nt").attr("disabled", true).css("background-color", "#f8f9fa");
        }

      });
    }, 100);

  }
  //*** конец открытия бланка ***//

  // клик по строке, загружаем форму
  $("#list_content .list_string").click(function () {
    open_blank($(this));
    // дизайн полей в моб версии бланка
    if ($(window).width()<=769) {
      setTimeout(function () {
        $("#morning_revival").css("min-width", $("#bible_book_ot").css("width"));
        $("#personal_prayer").css("min-width", $("#bible_book_ot").css("width"));
        $("#common_prayer").css("min-width", $("#bible_book_ot").css("width"));
        $("#ministry_reading").css("min-width", $("#bible_book_ot").css("width"));
      }, 200);
    }

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
       if (res[i].status === '1') {
         done_string = "green_string"
       } else if (res[i].status === '2') {
         done_string = "bg-warning";
       } else {
         done_string = "";
       }

       res[i].mark === '1' ? mark_string = "text-danger" : mark_string = "";
       if (!res[i]) {
         day = "";
         date = "";
       }
       let html_part_span = "<span class='list_string list_string_archive link_day "+sunday_back+" "+done_string+" "+mark_string+"' data-id='"+res[i].id+"' data-date='"+res[i].date+"' data-member_key='"+res[i].member_key+"' data-status='"+res[i].status+"' data-date_send='"+res[i].date_send+"' data-bible='"+res[i].bible+"' data-morning_revival='"+res[i].morning_revival+"' data-personal_prayer='"+res[i].personal_prayer+"' data-common_prayer='"+res[i].common_prayer+"' data-bible_reading='"+res[i].bible_reading+"' data-ministry_reading='"+res[i].ministry_reading+"' data-serving_one='"+res[i].serving_one+"' data-bible_book='"+res[i].bible_book+"' data-bible_chapter='"+res[i].bible_chapter+"' data-comment='"+res[i].comment+"'>"+date+" "+day+"</span>";
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
       /*$("#accordion_attendance").each(function () {

       })*/
       //let hi_bay = $("#accordion_attendance [data-id='"+$("#modalAddEdit").attr("data-id")+"']");
       //console.log(hi_bay.attr("data-id")); //.attr("data-id")
      open_blank($("#accordion_attendance [data-id='"+$("#modalAddEdit").attr("data-id")+"']"));
     //}
   } else {
     get_sessions_for_blank($("#modalAddEdit").attr("data-member_key"), $("#modalAddEdit").attr("data-date"), false);

     $("#modal-block_1").hide();
     $("#modal-block_2").hide();
     $("#modal-block_staff").show();
   }
  });

  // Правка мероприятий в бланке
  // формимуем список мероприятий из таблицы разрешения
  function get_sessions_permission_for_blank(member_key, date, permission_sheet_id) {
    let no_checked = false;
    fetch("ajax/ftt_attendance_ajax.php?type=get_permission&sheet_id=" + permission_sheet_id)
    .then(response => response.json())
    .then(commits => { // then start
      let sessions_staff = commits.result;
      let checked_str, id_field_extra;
      let html_staff_editor= "<div><label class='form-check-label'><input class='select_all_session form-check-input' type='checkbox'>Добавить/Удалить все</label></div><hr>";
      for (let session_str in sessions_staff) {
        if (sessions_staff.hasOwnProperty(session_str)) {
          if (sessions_staff[session_str]["checked"] === "1") {
            checked_str = "checked";
          } else {
            no_checked = true;
            checked_str = "";

          }

          if (!sessions_staff[session_str]["session_id"]) {
            id_field_extra = "";
          } else {
            id_field_extra = sessions_staff[session_str]["session_id"];
          }

          let end_time_session = "";
          if (sessions_staff[session_str]["duration"] && sessions_staff[session_str]["duration"] != "0") {
            end_time_session = " – " + time_plus_minutes(sessions_staff[session_str]["session_time"], sessions_staff[session_str]["duration"]);
          }

          html_staff_editor += "<div><label class='form-check-label'><input type='checkbox' class='session_staff_str form-check-input' data-day='"+sessions_staff[session_str]["session_time"]
          + "' data-id='" + sessions_staff[session_str]["id"]
          + "' data-session_name='" + sessions_staff[session_str]["session_name"] + "' data-session_id='" + id_field_extra
          + "' data-visit='" + sessions_staff[session_str]["visit"] + "' data-end_time='" + sessions_staff[session_str]["end_time"]
          + "' data-duration='"+sessions_staff[session_str]["duration"] + "' data-comment='" + sessions_staff[session_str]["comment"]
          + "' " + checked_str + ">" + sessions_staff[session_str]["session_name"] + " ("
          + sessions_staff[session_str]["session_time"]+""+end_time_session+")</label></div>"
        }
      }

      $("#modal_permission_block").html(html_staff_editor);
      // checked all
      $(".select_all_session").change(function () {
        if (($("#edit_permission_blank").attr("data-status") === "1" && trainee_access) || $("#edit_permission_blank").attr("data-status") === "2" || $("#edit_permission_blank").attr("data-status") === "3") {
          showError("Этот лист посещаемости отправлен. Радактирование невозможно.");
          $(this).prop("checked", !$(this).prop("checked"));
          return;
        }
        if ($(this).prop("checked")) {
          valid_modal_permission_field();
        } else {
          valid_modal_permission_field(1);
        }
        $("#modal_permission_block input[type='checkbox']").each(function () {
          if (!$(this).hasClass("select_all_session")) {
            $(this).prop("checked", $(".select_all_session").prop("checked"));
          }
        });
      });
      // checked sessions
      $("#modal_permission_block .session_staff_str").change(function () {
        if (($("#edit_permission_blank").attr("data-status") === "1" && trainee_access) || $("#edit_permission_blank").attr("data-status") === "2" || $("#edit_permission_blank").attr("data-status") === "3") {
          showError("Этот лист посещаемости отправлен. Радактирование невозможно.");
          $(this).prop("checked", !$(this).prop("checked"));
          return;
        }
        if ($("#modal_permission_block .session_staff_str:checked").length === 0) {
          valid_modal_permission_field(1);
        } else {
          valid_modal_permission_field();
        }
      });
      if (permission_sheet_id) {
        valid_modal_permission_field();
        //permission_session_checked(permission_sheet_id);
      }
      // вкл / выкл "Выбрать всё"
      $(".select_all_session").prop("checked", true);
      if (no_checked) {
        $(".select_all_session").prop("checked", false);
      }
      if (($("#edit_permission_blank").attr("data-status") === "1" && trainee_access) || $("#edit_permission_blank").attr("data-status") === "2" || $("#edit_permission_blank").attr("data-status") === "3") {
        $(".select_all_session").prop("disabled", false);
        $("#modal_permission_block input[type='checkbox']").attr("disabled", true);
      }
      // then end
    });
  }

  // формимуем список мероприятий из расписания
  function get_sessions_for_blank(member_key, date, permission, permission_sheet_id) {
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
      //console.log(commits.result);
      // отметка включеных мероприятий
      let exist_session = [];
      $("#modal-block_1 .name_session").each(function () {
        exist_session.push($(this).next().attr("data-val"));
      });
      let sessions_staff = commits.result;
      let checked_str, no_checked, id_field_extra;
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

            if (!sessions_staff[session_str]["id"]) {
              id_field_extra = "";
            } else {
              id_field_extra = sessions_staff[session_str]["id"];
            }

            let end_time_session = "";
            if (sessions_staff[session_str]["duration"] && sessions_staff[session_str]["duration"] !== "0") {
              end_time_session = " – " + time_plus_minutes(sessions_staff[session_str][day_of_date], sessions_staff[session_str]["duration"]);
            }

            html_staff_editor += "<div><label class='form-check-label'><input type='checkbox' class='session_staff_str form-check-input' data-day='"+sessions_staff[session_str][day_of_date]
            +"' data-session_name='"+sessions_staff[session_str]["session_name"]+"' data-session_id='"+id_field_extra
            +"' data-visit='"+sessions_staff[session_str]["visit"]+"' data-end_time='"+sessions_staff[session_str]["end_time"]
            +"' data-duration='"+sessions_staff[session_str]["duration"]+"' data-comment='"+sessions_staff[session_str]["comment"]
            +"' "+checked_str+">"+sessions_staff[session_str]["session_name"]+ " ("
            +sessions_staff[session_str][day_of_date]+""+end_time_session+")</label></div>"
          }
        }
      }

      if (permission) {
        // rendering
        $("#modal_permission_block").html(html_staff_editor);
        // checked all
        $(".select_all_session").click(function () {
          if ($(this).prop("checked")) {
            valid_modal_permission_field();
          } else {
            valid_modal_permission_field(1);
          }
          $("#modal_permission_block input[type='checkbox']").each(function () {
            if (!$(this).hasClass("select_all_session")) {
              $(this).prop("checked", $(".select_all_session").prop("checked"));
            }
          });
        });
        $("#modal_permission_block .session_staff_str").click(function () {
          if ($("#modal_permission_block .session_staff_str:checked").length === 0) {
            valid_modal_permission_field(1);
          } else {
            valid_modal_permission_field();
          }
        });
        if (permission_sheet_id) {
          valid_modal_permission_field();
          permission_session_checked(permission_sheet_id);
        }
        return;
      } else {
        $("#modal-block_staff_body").html(html_staff_editor);
      }

      $(".select_all_session").prop("checked", true);
      if (no_checked) {
        $(".select_all_session").prop("checked", false);
      }
      // построчное вкл/выкл мероприятий в бланке
      $("#modal-block_staff_body .session_staff_str").change(function () {
        if ($("#modalAddEdit").attr("data-status") === 1) {
          showError("Этот лист посещаемости отправлен. Радактирование невозможно.");
          return;
        }
        let session_staff_str_test = {};
        let session_staff_str = new FormData();
        let type = "";
        if ($(this).prop("checked")) {
          // проверить есть мероприятие в списке или нет
          type = "add_session_staff";
          session_staff_str_test;
          session_staff_str_test["id_sheet"] = $("#modalAddEdit").attr("data-id");
          session_staff_str_test["session_id"] =$(this).attr("data-session_id");
          session_staff_str_test["session_name"] = $(this).attr("data-session_name");
          session_staff_str_test["session_time"] =$(this).attr("data-day");
          session_staff_str_test["duration"] = $(this).attr("data-duration");
          session_staff_str_test["end_time"] = $(this).attr("data-end_time");
          session_staff_str_test["visit"] = $(this).attr("data-visit");
        } else {
          type = "dlt_session_staff";
          session_staff_str_test["id_sheet"] = $("#modalAddEdit").attr("data-id");
          session_staff_str_test["session_id"] =$(this).attr("data-session_id");
          session_staff_str_test["session_time"] =$(this).attr("data-day");
        }
        session_staff_str.set("data", JSON.stringify(session_staff_str_test));

        fetch("ajax/ftt_attendance_ajax.php?type="+type, {
          method: 'POST',
          body: session_staff_str
        })
        .then(response => response.text())
        .then(commits => {
          //console.log(commits.result);
        // location.reload();
        });
        //console.log("I am here!");
      });
      // пакетные операции вкл/выкл мероприятий в бланке
      $(".select_all_session").change(function () {
        if ($("#modalAddEdit").attr("data-status") === '1') {
          showError("Этот лист посещаемости отправлен. Радактирование невозможено.");
          return;
        } else if ($("#modalAddEdit").attr("data-status") === '2') {
          showError("Этот лист посещаемости не был отправлен. Радактирование невозможено.");
          return;
        }

        let a, b;
        let buttons = document.querySelectorAll('.session_staff_str');

        buttons.forEach(el => {
          if (el.checked) {
            a = 1;
          } else {
            b = 1;
          }
        });

        if (a && b) {
          $(this).prop("checked", !$(this).prop("checked"));
          showError("Выберете мероприятия в списке построчно.");
          return;
        }

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

              session_staff_str.set("data", JSON.stringify(session_staff_str_test));

              fetch("ajax/ftt_attendance_ajax.php?type=add_sessions_staff_all", {
                method: 'POST',
                body: session_staff_str
              })
              .then(response => response.text())
              .then(commits => {
                //console.log(commits.result);
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
  }
  // ОТКАТ
  // удаление мероприятий из бланка
  $("#undo_attendance_str").click(function () {
    if (!confirm("Отменить отправку бланка?")) {
      return;
    }
    // Условия
    if ($("#modalAddEdit").attr("data-status") === '0') {
      showError("Этот лист посещаемости не отправлен. Откат невозможен.");
      return;
    } else if ($("#modalAddEdit").attr("data-status") === '2') {
      showError("Этот лист посещаемости не был отправлен. Откат невозможен.");
      return;
    }
    let date_blank_str = $("#modalAddEdit").attr("data-date");
    let date_blank = new Date(date_blank_str);
    let day_blank = date_blank.getDay();
    let date_send_str = $("#modalAddEdit").attr("data-date_send");
    let date_send = new Date(date_send_str);
    let day_send = date_send.getDay();
    let date_current = new Date();
    let day_current = date_current.getDay();
    let result_date = (day_current - date_send) - ((day_send+1)*(24*60*60)*1000);
    let result_date_blank = (day_current - day_blank) - ((day_blank+1)*(24*60*60)*1000);
    let days_ago = (date_current - date_blank)/(24*60*60)/1000;

    // Откат возможен с вс по сб недели в который он отправлен
    //console.log(Math.floor(days_ago));
    //console.log(day_blank);
    //console.log(day_current);
    if (Math.floor(days_ago) > 7 || day_blank > day_current) {
      showError("Этот лист посещаемости находится в закрытом периоде. Откат невозможен.");
      return;
    }

    // Убираем статус один и удаляем опаздания и прогулы
    fetch("ajax/ftt_attendance_ajax.php?type=undo_status&id="+$("#modalAddEdit").attr("data-id"))
    .then(response => response.text())
    .then(commits => {
      setTimeout(function () {
        $('#spinner').modal("hide");
        location.reload();
      }, 500);
    });
    $("#modalAddEdit").modal("hide");
    $('#spinner').modal("show");
  });

  /*** BIBLE READING BEGIN ***/
  // ЧТЕНИЕ БИБЛИИ СТАРТ
  $("#show_me_start").click(function () {
    if ($(".reading_bible_title").attr("data-book_ot")) {
      let bible_chapter_html = "";
      let found = bible_arr.find(e => e[0] === $(".reading_bible_title").attr("data-book_ot"));
      if ($("#mdl_book_ot_start").val()) {
        for (let i = 1; i <= found[1]; i++) {
          bible_chapter_html += "<option value='"+i+"'>"+i;
        }
      }
      $("#mdl_chapter_ot_start").html(bible_chapter_html);
    } else {
      $("#mdl_book_ot_start").val("Быт.");
      $("#mdl_chapter_ot_start").val(1);
    }

    if ($(".reading_bible_title").attr("data-book_nt")) {
      let bible_chapter_html = "";
      let found = bible_arr.find(e => e[0] === $(".reading_bible_title").attr("data-book_nt"));
      if ($("#mdl_book_nt_start").val()) {
        for (let i = 1; i <= found[1]; i++) {
          bible_chapter_html += "<option value='"+i+"'>"+i;
        }
      }
      $("#mdl_chapter_nt_start").html(bible_chapter_html);
    } else {
      $("#mdl_book_nt_start").val("Мф.");
      $("#mdl_chapter_nt_start").val(1);
    }
    $("#mdl_bible_start select").attr("disabled", true);
    $("#mdl_footnotes_ot_start").attr("disabled", true);
    $("#mdl_footnotes_nt_start").attr("disabled", true);
    let ot, nt;
    if (!$("#bible_book_ot").attr("disabled")) {
      if ($("#bible_book_ot").val() && $("#bible_book_ot").val() !== "0" && $("#bible_book_ot").val() !== "_none_") {
        ot = split_book($("#bible_book_ot").val());
      } else {
        ot = split_book($("#bible_book_ot option:nth-child(3)").attr("data-book") + " " + $("#bible_book_ot option:nth-child(3)").attr("data-chapter"));
      }
      $("#mdl_book_ot_start").val(ot[0]);
      $("#mdl_chapter_ot_start").val(ot[1]);
      $("#mdl_footnotes_ot_start").prop("checked", $(".reading_bible_title").attr("data-notes_ot") === "1" ? true : false);
      let found = bible_arr.find(e => e[0] === ot[0]);
      if (found[1] === ot[1]) {
        $("#mdl_ot_start").attr("disabled", false);
        $("#mdl_ot_start").prop("checked", false);
      } else {
        $("#mdl_ot_start").attr("disabled", true);
        $("#mdl_ot_start").prop("checked", true);
      }
    } else if (!$("#bible_book_ot").is(":visible")) {
      $("#mdl_ot_start").attr("disabled", false);
    }

    if (!$("#bible_book_nt").attr("disabled")) {
      if ($("#bible_book_nt").val() && $("#bible_book_nt").val() !== "0" && $("#bible_book_nt").val() !== "_none_") {
        nt = split_book($("#bible_book_nt").val());
      } else {
        nt = split_book($("#bible_book_nt option:nth-child(3)").attr("data-book") + " " + $("#bible_book_nt option:nth-child(3)").attr("data-chapter"));
      }
      $("#mdl_book_nt_start").val(nt[0]);
      $("#mdl_chapter_nt_start").val(nt[1]);
      $("#mdl_footnotes_nt_start").prop("checked", $(".reading_bible_title").attr("data-notes_nt") === "1" ? true : false);
      let found = bible_arr.find(e => e[0] === nt[0]);
      if (found[1] === nt[1]) {
        $("#mdl_nt_start").attr("disabled", false);
        $("#mdl_nt_start").prop("checked", false);
      } else {
        $("#mdl_nt_start").attr("disabled", true);
        $("#mdl_nt_start").prop("checked", true);
      }
    } else if (!$("#bible_book_nt").is(":visible")) {
      $("#mdl_nt_start").attr("disabled", false);
    }

    $("#set_start_reading_bible").attr("disabled", true);
  });

  $("#bible_book_ot, #bible_book_nt").change(function (e) {
    /* НУЖНО ЕДИНОЕ ПРАВИЛО Данные для статистики это строки с последней главой без дат */
    /* ПРЕДУСМОТРЕТЬ ОТКАТ */
    /*checked это откат, то есть пролистывание назад */
    if (!$(this).val() || $(this).val() == 0 || $(this).val() === "_none_") {
      return;
    }
    let book = split_book($(this).val());
    let prev_book, part, notes, set, id_prev_book;
    let found = bible_arr.find(e => e[0] === book[0]);
    if ($(this).attr("id") === "bible_book_ot") {
      prev_book = $(".reading_bible_title").attr("data-book_ot");
      part = "ot";
      notes = $(".reading_bible_title").attr("data-notes_ot");
    } else {
      prev_book = $(".reading_bible_title").attr("data-book_nt");
      part = "nt";
      notes = $(".reading_bible_title").attr("data-notes_nt");
    }
    if (prev_book !== book[0]) {
      id_prev_book = get_id_book(prev_book);
      id_curr_book = get_id_book(book[0]);
      books = read_books_check(book[0], prev_book);
      if (id_curr_book > id_prev_book) {
        set = 1;
      } else if (id_curr_book < id_prev_book) {
        set = 0;
      }
      books = books.join();
      let query = "member_key=" + $("#modalAddEdit").attr("data-member_key")
      + "&part=" + part
      + "&books=" + books
      + "&notes=" + notes
      + "&set=" + set;
      fetch("ajax/ftt_reading_ajax.php?type=set_read_book_by_book&" + query)
      .then(response => response.text())
      .then(commits => {
        //console.log(commits.resilt);
        if (part === "ot") {
          $(".reading_bible_title").attr("data-book_ot", book[0]);
        } else {
          $(".reading_bible_title").attr("data-book_nt", book[0]);
        }
      });
    }
  });

  function read_books_check(current, previous) {
    let sim_1 = false;
    let books = [];
    for (let i = 0; i < bible_arr.length; i++) {
      if (bible_arr[i][0] === current) {
        break;
      } else if (bible_arr[i][0] === previous || sim_1) {
        sim_1 = true;
        books.push(i);
      }
    }
    if (books.length === 0) {
      sim_1 = false;
      for (let i = 0; i < bible_arr.length; i++) {
        if (bible_arr[i][0] === previous) {
          break;
        } else if (bible_arr[i][0] === current || sim_1) {
          sim_1 = true;
          books.push(i);
        }
      }
    }
    return books;
  }
  // получаем id книги Библии
  function get_id_book(book) {
    let id = "";
    for (let i = 0; i < bible_arr.length; i++) {
      if (bible_arr[i][0] === book) {
        id = i;
        break;
      }
    }
    return id;
  }

  $("#mdl_ot_start, #mdl_nt_start").change(function () {
    if ($(this).attr("id") === "mdl_ot_start") {
      if ($(this).prop("checked")) {
        if (trainee_access !== "1") {
          $("#mdl_footnotes_ot_start").attr("disabled", false);
        }
        $("#mdl_book_ot_start").attr("disabled", false);
        $("#mdl_chapter_ot_start").attr("disabled", false);
      } else {
        $("#mdl_footnotes_ot_start").attr("disabled", true);
        $("#mdl_book_ot_start").attr("disabled", true);
        $("#mdl_chapter_ot_start").attr("disabled", true);
      }
    } else {
      if ($(this).prop("checked")) {
        if (trainee_access !== "1") {
          $("#mdl_footnotes_nt_start").attr("disabled", false);
        }
        $("#mdl_book_nt_start").attr("disabled", false);
        $("#mdl_chapter_nt_start").attr("disabled", false);
      } else {
        $("#mdl_footnotes_nt_start").attr("disabled", true);
        $("#mdl_book_nt_start").attr("disabled", true);
        $("#mdl_chapter_nt_start").attr("disabled", true);
      }
    }

    if (($("#mdl_ot_start").prop("checked") && !$("#mdl_ot_start").attr("disabled")) || ($("#mdl_nt_start").prop("checked") && !$("#mdl_nt_start").attr("disabled"))) {
      $("#set_start_reading_bible").attr("disabled", false);
    } else {
      $("#set_start_reading_bible").attr("disabled", true);
    }
  });

  $("#mdl_book_ot_start, #mdl_book_nt_start").focus(function() {
    // ЕСЛИ ПРИ ПЕРЕБОРЕ ОПЦИЙ не обнаруживаются книги то выводит предупреждение что всё прочитано
    let counter = 0;

    $(this).find("option").each(function (e) {
      counter = e;
      if (e > 1) {
        return;
      }
    });
    if (counter <= 1) {
      let text = "Вы прочитали все книги. Для выбора начала чтения с примечаниями обратитесь к служащим.";
      showHint(text);
    }
  });

  $("#mdl_book_ot_start, #mdl_book_nt_start").change(function() {
    let bible_chapter_html = "";
    let found = bible_arr.find(e => e[0] === $(this).val());

    for (let i = 1; i <= found[1]; i++) {
      bible_chapter_html += "<option value='"+i+"'>"+i;
    }
    if ($(this).attr("id") === "mdl_book_ot_start") {
      $("#mdl_chapter_ot_start").html(bible_chapter_html);
    } else {
      $("#mdl_chapter_nt_start").html(bible_chapter_html);
    }
  });

  $("#mdl_bible_start").on("hide.bs.modal", function () {
    $("#mdl_bible_start input[type='checkbox']").prop("checked", false);
    $("#mdl_bible_start input[type='checkbox']").attr("disabled", false);
    setTimeout(function () {
      $("body").addClass("modal-open");
    }, 500);
  });

  // обучающийся
  $("#set_start_reading_bible").click(function () {
    let chosen_book = 0;
    let text_ot = "", text_nt = "", comma = "";
    if ($("#mdl_nt_start").prop("checked") && $("#mdl_ot_start").prop("checked")) {
      chosen_book = 3;
      text_ot = $("#mdl_book_ot_start").val();
      if ($("#mdl_footnotes_ot_start").prop("checked")) {
        text_ot += " с прим.";
      }
      comma = ", ";
      text_nt = $("#mdl_book_nt_start").val();
      if ($("#mdl_footnotes_nt_start").prop("checked")) {
        text_nt += " с прим.";
      }
    } else if ($("#mdl_ot_start").prop("checked")) {
      chosen_book = 1;
      text_ot = $("#mdl_book_ot_start").val();
      if ($("#mdl_footnotes_ot_start").prop("checked")) {
        text_ot += " с прим.";
      }
    } else if ($("#mdl_nt_start").prop("checked")) {
      chosen_book = 2;
      text_nt = $("#mdl_book_nt_start").val();
      if ($("#mdl_footnotes_nt_start").prop("checked")) {
        text_nt += " с прим.";
      }
    } else {
      showError("Выберите книгу.");
      return;
    }

    let footnotes_ot = $("#mdl_footnotes_ot_start").prop("checked") ? 1 : 0;
    let footnotes_nt = $("#mdl_footnotes_nt_start").prop("checked") ? 1 : 0;
    // clear history
    let footnotes_ot_change = "";
    let footnotes_nt_change = "";
    let and = "";
    if (($(".reading_bible_title").attr("data-notes_ot") != footnotes_ot) && $(".reading_bible_title").attr("data-book_ot")) {
      footnotes_ot_change = " Ветхому Завету";
    }
    if (($(".reading_bible_title").attr("data-notes_nt") != footnotes_nt) && $(".reading_bible_title").attr("data-book_nt")) {
      footnotes_nt_change =  " Новому Завету";
    }
    if (footnotes_ot_change || footnotes_nt_change) {
      if (footnotes_ot_change && footnotes_nt_change) {
        and = " и";
      }
      if (confirm("Вы начинаете заново? Удалить предыдущую историю чтения по" + footnotes_ot_change + and + footnotes_nt_change + "?")) {
        fetch("ajax/ftt_reading_ajax.php?type=dlt_history_reading_bible&member_key=" + window.adminId + "&ot=" + footnotes_ot_change + "&nt=" + footnotes_nt_change)
        .then(response => response.json())
        .then(commits => {

        });
      } else {
        return;
      }
    }

    // отметка прочитанных книг по последней главе
    if (!$("#mdl_ot_start").attr("disabled") && $("#bible_book_ot").is(":visible") && !footnotes_ot_change && $("#bible_book_ot").val() !== "_none_") {
      let ot_temp;
      if ($("#bible_book_ot").val()) {
        ot_temp = split_book($("#bible_book_ot").val());
      } else {
        ot_temp = split_book($("#bible_book_ot option:nth-child(3)").attr("data-book") + " " + $("#bible_book_ot option:nth-child(3)").attr("data-chapter"));
      }
      let found_temp = bible_arr.find(e => e[0] === ot_temp[0]);
      if (found_temp[1] === ot_temp[1]) {
        setTimeout(function () {
          let query_temp = "&member_key=" + $("#modalAddEdit").attr("data-member_key") + "&book=" + ot_temp[0] + "&chapter=" + ot_temp[1];
          fetch("ajax/ftt_reading_ajax.php?type=set_read_book&part=ot&checked=true" + query_temp)
          .then(response => response.text())
          .then(commits => {

          });
        }, 30);
      }
    }
    if (!$("#mdl_nt_start").attr("disabled") && $("#bible_book_nt").is(":visible") && !footnotes_nt_change && $("#bible_book_nt").val() !== "_none_") {
      let nt_temp;
      if ($("#bible_book_nt").val()) {
        nt_temp = split_book($("#bible_book_nt").val());
      } else {
        nt_temp = split_book($("#bible_book_nt option:nth-child(3)").attr("data-book") + " " + $("#bible_book_nt option:nth-child(3)").attr("data-chapter"));
      }

      let found_temp = bible_arr.find(e => e[0] === nt_temp[0]);
      if (found_temp[1] === nt_temp[1]) {
        setTimeout(function () {
          let query_temp = "&member_key=" + $("#modalAddEdit").attr("data-member_key") + "&book=" + nt_temp[0] + "&chapter=" + nt_temp[1];
          fetch("ajax/ftt_reading_ajax.php?type=set_read_book&part=nt&checked=true" + query_temp)
          .then(response => response.text())
          .then(commits => {

          });
        }, 60);
      }
    }
    // set data in html
    $(".reading_bible_title").text("Чтение Библии " + "(" + text_ot + comma + text_nt +")");
    $(".reading_bible_title").attr("data-notes_ot", footnotes_ot);
    $(".reading_bible_title").attr("data-notes_nt", footnotes_nt);
    $(".reading_bible_title").attr("data-book_ot", $("#mdl_book_ot_start").val());
    $(".reading_bible_title").attr("data-book_nt", $("#mdl_book_nt_start").val());
    // query
    let param = "&member_key=" + $("#modalAddEdit").attr("data-member_key") +
    "&date=" + $("#modalAddEdit").attr("data-date") +
    "&chosen_book=" + chosen_book +
    "&book_ot=" + $("#mdl_book_ot_start").val() +
    "&chapter_ot=" + $("#mdl_chapter_ot_start").val() +
    "&footnotes_ot=" + footnotes_ot +
    "&book_nt=" + $("#mdl_book_nt_start").val() +
    "&chapter_nt=" + $("#mdl_chapter_nt_start").val() +
    "&footnotes_nt=" + footnotes_nt;

    fetch("ajax/ftt_reading_ajax.php?type=set_start_reading_bible" + param)
    .then(response => response.json())
    .then(commits => {
      //console.log(commits.result);
      if (commits.result === "e001") {
        // error 001 некорректные входные данные
        showError("Запись не сохранена. Не корректные входные данные.");
        return;
      } else if(commits.result) {
        $("#bible_book_ot").attr("disabled", true).css("background-color", "#f8f9fa");
        $("#bible_book_nt").attr("disabled", true).css("background-color", "#f8f9fa");
        if (chosen_book === 3) {
          render_bible_chapters($("#mdl_book_ot_start").val(), $("#mdl_chapter_ot_start").val(), "#bible_book_ot");
          render_bible_chapters($("#mdl_book_nt_start").val(), $("#mdl_chapter_nt_start").val(), "#bible_book_nt");
          $("#bible_book_ot").show();
          $("#bible_book_nt").show();
        } else if (chosen_book === 1) {
          render_bible_chapters($("#mdl_book_ot_start").val(), $("#mdl_chapter_ot_start").val(), "#bible_book_ot");
          $("#bible_book_ot").show();
          $("#bible_book_nt").hide();
        } else if (chosen_book === 2) {
          render_bible_chapters($("#mdl_book_nt_start").val(), $("#mdl_chapter_nt_start").val(), "#bible_book_nt");
          $("#bible_book_ot").hide();
          $("#bible_book_nt").show();
        }
        showHint("Запись сохранена.");
      } else {
        showError("Запись не сохранена. Обратитесь в администратору.");
      }
      $("#mdl_bible_start").modal("hide");
    });
  });

  function render_bible_chapters(book, chapter, selector) {
    let sim_1, counter_1 = 0, cap_rend=10;
    let options = "<option value='_none_' disabled selected>";
    if (selector === "#bible_book_ot") {
      options += "ВЗ"
    } else {
      options += "НЗ"
    }
    if (!book) {
      $(selector).html(options);
      return;
    }

    if (book === "Мал.") {
      cap_rend = cap_rend - 5 - chapter;
    }

    if (book === "Зах.") {
      if (chapter > 8) {
        cap_rend = cap_rend - chapter + 9;
      }
    }

    options += "<option value='0'>нет";
    for (let i = 0; i < bible_arr.length; i++) {
      if (sim_1 === 2) {
        break;
      }
      if ((bible_arr[i][0] === book || sim_1 === 1) && counter_1 < cap_rend) {
        for (let j = 1; j <= bible_arr[i][1]; j++) {
          if ((j >= chapter || sim_1 === 1) && counter_1 < cap_rend) {
            if (sim_1 === 2) {
              break;
            }
            if (counter_1 < cap_rend) {
              options += "<option data-book='" + bible_arr[i][0] + "' data-chapter='" + j + "'>" + bible_arr[i][0] + " " + j;
              counter_1 ++;
              sim_1 = 1;
            } else {
              sim_1 = 2;
            }
          }
        }
      }
    }
    $(selector).html(options);
  }
  /*** BIBLE READING STOP ***/

  /*** ПОДРАЗДЕЛ РАЗРЕШЕНИЯ ***/
  // Bootstrap tooltip
  $("#list_content i").each(function () {
    let tooltip;
    tooltip = $(this).attr("title");
    $(this).attr("data-trigger", "click");
    $(this).tooltip();
    $(this).attr("title", tooltip);
  });

  // ПОДРАЗДЕЛ ЛИСТЫ ОТСУТСТВИЯ
  // FUNCTION
  // PERMISSIONS
  function prepare_archive() {
    let archive_sessions = "", checked;
    $("#modal_permission_block label").each(function () {
      if (!$(this).find("input").hasClass("select_all_session")) {
        checked = "<label class='form-check-label pl-1'><input type='checkbox' class='form-check-input' disabled> ";
        if ($(this).find("input").prop("checked")) {
          checked =  "<label class='form-check-label pl-1'><input type='checkbox' class='form-check-input' checked disabled> ";
        }
        archive_sessions = archive_sessions + checked +" "+ $(this).text() + "</label><br>";
      }
    });
    return archive_sessions;
  }
  function prepare_data(status) {
    let comment_extra = $("#permission_modal_comment_extra").val();
    if ($("#permission_modal_date").val() && compare_date($("#permission_modal_date").val()) && (status === 2 || status === 3)) {
      // на данный момент бланкти изменяюится
      //showHint("Так как дата прошедшая, лист посещаемости не изменён.");
      comment_extra += " Лист посещаемости за прошедшую дату. ";
    }
    //  сверить дату бланка и текущую дату
    // если статус 2 или 3 Выдать предупреждение и дописать это предупреждение к концу коментария служащего


    let archive_sessions = "";
    if (status !== 0 && status !== 1 && status !== 2 && status !== 3) {
      status = $("#edit_permission_blank").attr("data-status");
    }
    let serving_one = "";
    if (status === 0 || status === 1 || status === 2 || status === 3) {
      serving_one = admin_id_gl;
    }


    archive_sessions = prepare_archive();


    // prepare
    let session_str = new FormData();
    let type = "";
    let session_str_test = {
      sheet:{
        id:"",
        member_key: $("#edit_permission_blank").attr("data-member_key"),
        date: $("#edit_permission_blank").attr("data-date"),
        date_send: $("#edit_permission_blank").attr("data-send_date"),
        absence_date: $("#permission_modal_date").val(),
        status: status,
        serving_one: serving_one,
        archive_sessions: archive_sessions,
        comment_extra: comment_extra || "",
        comment: $("#permission_modal_comment").val(),
        trainee: trainee_access  || ""
      }
    };
    if ($("#edit_permission_blank").attr("data-id")) {
      session_str_test["sheet"]["id"] = $("#edit_permission_blank").attr("data-id");
    }

    $("#modal_permission_block input[type='checkbox']").each(function (i) {
      if (!$(this).hasClass("select_all_session")) {
        let checked_combobox = 0;
        if ($(this).prop("checked")) {
          checked_combobox = 1;
        }

        session_str_test[i];
        session_str_test[i] = {
          sheet_id: "",
          session_id: $(this).attr("data-session_id"),
          session_name: $(this).attr("data-session_name"),
          session_time: $(this).attr("data-day"),
          duration: $(this).attr("data-duration"),
          session_correction_id: "",
          checked: checked_combobox
        }
        if ($("#edit_permission_blank").attr("data-id")) {
          session_str_test[i]["sheet_id"] = $("#edit_permission_blank").attr("data-id");
        }
        if (!$(this).attr("data-session_id")) {
          session_str_test[i]["session_correction_id"] = $(this).attr("data-day");
        }
      }
    });
    session_str.set("data", JSON.stringify(session_str_test));
    return session_str;
  }

  function save_permissions(data) {
    // fetch
    fetch("ajax/ftt_attendance_ajax.php?type=set_permission", {
      method: 'POST',
      body: data
    })
    .then(response => response.text())
    .then(commits => {
      if (link_pb && !isNaN(link_pb)) {
        location.href = 'ftt_attendance';
      } else {
        location.reload();
      }
      //console.log(commits);
    });
  }

  function clear_blank(selector) {
    $(selector + " input").val("");
    $(selector).attr("data-id", "");
    $(selector).attr("data-member_key", "");
    $(selector).attr("data-date", "");
    $(selector).attr("data-absence_date", "");
    $(selector).attr("data-date_send", "");
    $(selector).attr("data-serving_one", "");
    $(selector).attr("data-status", "");
    $("#modal_permission_block").html("");
    $("#history_permission_block").html("");
    $('#author_of_permission').parent().hide();
    $('#author_of_permission').text("");
    $("#send_date_of_permission").text("");
    $("#sevice_one_of_permission").text("");
    $("#allow_date_of_permission").text("");
  }

  function valid_field() {
    if (!$("#trainee_select_permission").val() && !trainee_access) {
      $("#trainee_select_permission").css("border-color", "red");
      showError("Заполните обязательные поля.");
      return 1;
    }

    if (!$("#permission_modal_date").val()) {
      $("#permission_modal_date").css("border-color", "red");
      showError("Заполните обязательные поля.");
      return 1;
    }

    if (!$("#permission_modal_comment").val()) {
      $("#permission_modal_comment").css("border-color", "red");
      showError("Заполните обязательные поля.");
      return 1;
    }

    if ($("#modal_permission_block .session_staff_str:checked").length === 0) {
      showError("Отметьте хотя бы одно мероприятие.");
      return 1;
    }
  }

  function get_sessions_archive(sheet_id) {
    fetch("ajax/ftt_attendance_ajax.php?type=get_permission_archive&sheet_id="+sheet_id)
    .then(response => response.json())
    .then(commits => {
      if (commits.result) {
        $("#history_permission_block").html(commits.result);
      }
    });
  }

  function status_choisen(element, status) {

    if (isNaN(status) || status > 3) {
      status = 0;
    }

    status_array = {0: ["badge-secondary", "не отправлен"], 1: ["badge-warning","на рассмотрении"],
    2: ["badge-success", "одобрен"], 3: ["badge-danger","отклонён"]};
    element.removeClass("badge-secondary").removeClass("badge-warning").removeClass("badge-danger").removeClass("badge-success");
    element.addClass(status_array[status][0]).text(status_array[status][1]);
  }

  function fill_blank(element) {
    // behavior
    // buttons
    $("#send_permission_blank").attr("disabled", true).hide();
    // кнопка сохранить
    if (!trainee_access) {
      $("#save_permission_blank").attr("disabled", false).show();
    } else {
      $("#save_permission_blank").attr("disabled", true).hide();
    }
    if (element.attr("data-status") === "0" || !element.attr("data-status")) {
      $("#deny_permission_blank").attr("disabled", true).hide();
      $("#apply_permission_blank").attr("disabled", true).hide();
    }

    if (element.attr("data-status") === "2") {
      $("#apply_permission_blank").attr("disabled", true).hide();
      $("#deny_permission_blank").attr("disabled", false).show();
    }

    if (element.attr("data-status") === "3") {
      $("#apply_permission_blank").attr("disabled", false).show();
      $("#deny_permission_blank").attr("disabled", true).hide();
    }

    // fields
    $("#edit_permission_blank input").attr("disabled", true);
    $("#edit_permission_blank select").attr("disabled", true);

    $("#trainee_select_permission").css("border-color", "#ced4da");
    $("#permission_modal_date").css("border-color", "#ced4da");
    $("#permission_modal_comment").css("border-color", "#ced4da");

    if (element.attr("data-status") === "1") {
      $("#delete_permission_blank").attr("disabled", false).show();
      if (!trainee_access) {
        if ($(window).width()<=769) {
          $("#apply_permission_blank").text("Одоб");
          $("#deny_permission_blank").text("Откл");
          $("#save_permission_blank").text("Сохр");
          $("#close_permission_blank").text("Закр");
        }
        // buttons
        $("#deny_permission_blank").attr("disabled", false).show();
        $("#apply_permission_blank").attr("disabled", false).show();
        $("#edit_permission_blank input").attr("disabled", false);
        $("#edit_permission_blank select").attr("disabled", false);
      } else {

      }
    } else if (element.attr("data-status") === "2") {
      // buttons
      if (!trainee_access) {
        $("#deny_permission_blank").attr("disabled", false).show();
      }
      $("#trainee_select_permission").attr("disabled", true);
      $("#permission_modal_date").attr("disabled", true);
      $("#permission_modal_comment").attr("disabled", true);
      $("#delete_permission_blank").attr("disabled", true).hide();
    } else if (element.attr("data-status") === "3") {
      $("#trainee_select_permission").attr("disabled", true);
      $("#permission_modal_date").attr("disabled", true);
      $("#permission_modal_comment").attr("disabled", true);
      $("#delete_permission_blank").attr("disabled", true).hide();
    } else {
      if (!trainee_access) {

      } else {

      }
      // buttons
      $("#send_permission_blank").prop("disabled", false).show();
      $("#save_permission_blank").prop("disabled", false).show();
      $("#delete_permission_blank").prop("disabled", false).show();
      // fields
      $("#edit_permission_blank input").attr("disabled", false);
      $("#edit_permission_blank select").attr("disabled", false);
    }
    // get archive
    $("#history_permission_block").hide();
    let d1 = new Date(date_now_gl);
    let d2 = new Date(element.attr("data-absence_date"));
    let dm = d1 - d2;
    //let historic = false;

    if (dm > 0) {
      /*setTimeout(function () {
        get_sessions_archive(element.attr("data-id"));
      }, 30);*/
      //$("#history_permission_block").show();
      $("#modal_permission_block").show();
      //historic = true;
    } else {
      //$("#history_permission_block").hide();
      $("#modal_permission_block").show();
    }

    // select the status
    status_choisen($("#show_status_in_blank"), element.attr("data-status"));

    // NEW
    if (element.attr("id") === "permission_add") {

      $("#delete_permission_blank").hide();
      if (trainee_access) { // for trainee
        $("#edit_permission_blank").attr("data-member_key", admin_id_gl);
      } else { // for staff
        $("#edit_permission_blank").attr("data-member_key", "");
        $("#trainee_select_permission").val("_none_");
      }
      $("#permission_modal_date").val("");
      // day of the week
      if ($(window).width()<=769) {
        $("#show_day_in_blank").text("");
      } else {
        $("#show_day_in_blank").text("");
      }
      valid_modal_permission_field();
    } else { // EDIT
      // field
      $("#trainee_select_permission").val(element.attr("data-member_key"));
      $("#permission_modal_date").val(element.attr("data-absence_date"));
      $("#permission_modal_comment").val(element.attr("data-comment"));
      $("#permission_modal_comment_extra").val(element.attr("data-comment_extra"));
      // attr
      $("#edit_permission_blank").attr("data-id", element.attr("data-id"));
      $("#edit_permission_blank").attr("data-member_key", element.attr("data-member_key"));
      $("#edit_permission_blank").attr("data-date", element.attr("data-date"));
      $("#edit_permission_blank").attr("data-send_date", element.attr("data-date_send"));
      $("#edit_permission_blank").attr("data-absence_date", element.attr("data-absence_date"));
      $("#edit_permission_blank").attr("data-status", element.attr("data-status"));
      $("#edit_permission_blank").attr("data-serving_one", element.attr("data-serving_one"));
      $("#edit_permission_blank").attr("data-comment", element.attr("data-comment"));

      // day of the week
      if ($(window).width()<=769) {
        $("#show_day_in_blank").text(getNameDayOfWeekByDayNumber(element.attr("data-absence_date"), true));
      } else {
        $("#show_day_in_blank").text(getNameDayOfWeekByDayNumber(element.attr("data-absence_date"), false));
      }
      // Инфо в футере бланка
      let text_permission_status = "Отправлен ";
      if (element.attr("data-status") === "2" || element.attr("data-status") === "3") {
        text_permission_status = "Отправлен ";
        $("#send_date_of_permission").text(element.attr("data-date_send"));
        if (element.attr("data-serving_one")) {
          if (serving_ones_list[element.attr("data-serving_one")]) {
            $("#author_of_permission").text(text_permission_status); // + " " + serving_ones_list[element.attr("data-serving_one")]
          } else {
            $("#author_of_permission").text(text_permission_status); // + " " + trainee_list[element.attr("data-member_key")]
          }
        }
      } else if (element.attr("data-status") === "1") {
        $("#author_of_permission").text("Создан ");
        $("#send_date_of_permission").text(element.attr("data-date"));
        if (element.attr("data-serving_one")) {
          if (serving_ones_list[element.attr("data-serving_one")]) {
            $("#sevice_one_of_permission").text(text_permission_status + " " + serving_ones_list[element.attr("data-serving_one")]);
          } else {
            $("#sevice_one_of_permission").text(text_permission_status + " " + trainee_list[element.attr("data-serving_one")]);
          }

          $("#allow_date_of_permission").text(element.attr("data-date_send"));
        }
      }

      if (element.attr("data-status") === "2") {
        text_permission_status = "Одобрен ";
        $("#sevice_one_of_permission").text(text_permission_status + " " + serving_ones_list[element.attr("data-serving_one")]);
        $("#allow_date_of_permission").text(element.attr("data-date_decision"));
      } else if (element.attr("data-status") === "3") {
        text_permission_status = "Отклонён ";
        $("#sevice_one_of_permission").text(text_permission_status + " " + serving_ones_list[element.attr("data-serving_one")]);
        $("#allow_date_of_permission").text(element.attr("data-date_decision"));
      } else if (element.attr("data-status") === "0") {
        $("#author_of_permission").text("Создан ");
        $("#send_date_of_permission").text(element.attr("data-date"));
        $("#sevice_one_of_permission").text("");
        $("#allow_date_of_permission").text("");
      }
    }
    $("#permission_modal_comment_extra").attr("disabled", false);
    valid_modal_permission_field();
  }
  // не используется
  function permission_session_checked(sheet_id) {
    fetch("ajax/ftt_attendance_ajax.php?type=get_permission&sheet_id="+sheet_id)
    .then(response => response.json())
    .then(commits => {
      let data = commits.result;
      if ($("#edit_permission_blank").attr("data-status") === "2"
      || $("#edit_permission_blank").attr("data-status") === "3") {
        $("#modal_permission_block input").prop("disabled", true);
      } else if ($("#edit_permission_blank").attr("data-status") === "1" && trainee_access) {
        $("#modal_permission_block input").prop("disabled", true);
      } else {

      }
      for (let variable in data) {
        if (data.hasOwnProperty(variable)) {
          $("#modal_permission_block .session_staff_str").each(function () {
            if ($(this).attr("data-session_id") === data[variable]['session_id']) {
              $(this).prop("checked", "checked");
            }
          });
        }
      }
    });
  }
  // New permission
  $("#permission_add").click(function () {
    clear_blank("#edit_permission_blank");
    fill_blank($(this));
  });
  // open permission
  $("#list_permission .list_string").click(function () {
    if ($(this).attr("data-notice") === "1") {
      fetch("ajax/ftt_attendance_ajax.php?type=notice&id="+$(this).attr("data-id")+"&data=0");
      $(this).removeClass("bg-notice-string");
    }
    clear_blank("#edit_permission_blank");
    get_sessions_permission_for_blank($(this).attr("data-member_key"), $(this).attr("data-absence_date"), $(this).attr("data-id"));
    fill_blank($(this));
  });

  $("#permission_modal_comment").keyup(function () {
    valid_modal_permission_field();
  });
  $("#permission_modal_comment").change(function () {
    valid_modal_permission_field();
  });
  $("#permission_modal_date").change(function () {
    if (!$(this).val() || $(this).val() === "") {
      $("#modal_permission_block").html("");
    }/* else if (compare_date($(this).val()) || $(this).val().length > 10 || $(this).val().length === 0) {
      $(this).val("");
      showError("Нельзя создать бланк за прошедшую дату.");
      $("#modal_permission_block").html("");
    }*/ else if ($("#trainee_select_permission").val() === "_none_" && !$("#trainee_select_permission").val()) {

    } else {
      valid_modal_permission_field();
    }
    valid_modal_permission_field();
    if ($(this).val()) {
        // day of the week
        if ($(window).width()<=769) {
          $("#show_day_in_blank").text(getNameDayOfWeekByDayNumber($(this).val(), true));
        } else {
          $("#show_day_in_blank").text(getNameDayOfWeekByDayNumber($(this).val(), false));
        }
    } else {
      // day of the week
      $("#show_day_in_blank").text("");
    }

    if ($(this).val() && $("#edit_permission_blank").attr("data-absence_date") === $(this).val()
    && $("#trainee_select_permission").val() !== "_none_") {
      get_sessions_for_blank($("#edit_permission_blank").attr("data-member_key"), $("#edit_permission_blank").attr("data-absence_date"), true, $("#edit_permission_blank").attr("data-id"));
    } else if ($(this).val() && $("#trainee_select_permission").val() !== "_none_") {
      // ПРОДУМАТЬ У СЛУЖАЩИХ
      get_sessions_for_blank($("#edit_permission_blank").attr("data-member_key"), $(this).val(), true);
    }
  });
  // save permission
  $("#save_permission_blank").click(function () {
    if (valid_field()) {
      return;
    }
    save_permissions(prepare_data());
    $("#edit_permission_blank").modal("hide");
  });
  // send permission
  $("#send_permission_blank").click(function () {
    if (valid_field()) {
      return;
    }
    save_permissions(prepare_data(1));
    $("#edit_permission_blank").modal("hide");
  });

  $("#apply_permission_blank, #deny_permission_blank").click(function (e) {
    if (valid_field() && !compare_date($("#permission_modal_date").val())) {
      return;
    }
    if (e.target.id === "apply_permission_blank") {
      save_permissions(prepare_data(2));
    } else {
      save_permissions(prepare_data(3));
    }
    $("#edit_permission_blank").modal("hide");
  });

  // фильтры
  function filters_permissions() {
    $("#list_permission .list_string").each(function () {
      //
      if ($('#flt_sevice_one_permissions').val() === "_all_" && $('#ftr_trainee_permissions').val() === $(this).attr("data-member_key") && ($("#flt_permission_active").val() === $(this).attr("data-status") || $("#flt_permission_active").val() === "_all_")) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  }
  $('#ftr_trainee_permissions').change(function () {
    if ($(this).val() === "_all_") {
      $('#flt_sevice_one_permissions').val("_all_");
      setCookie('flt_sevice_one_permissions', $('#flt_sevice_one_permissions').val(), 1);
      setCookie("tab_active", "permission");
      setCookie("flt_trainee", "");
      setTimeout(function () {
        location.reload();
      }, 30);
    } else {
      $('#flt_sevice_one_permissions').val("_all_");
      setCookie('flt_sevice_one_permissions', $('#flt_sevice_one_permissions').val(), 1);
      setCookie("tab_active", "permission");
      setCookie("flt_trainee", $(this).val());
      setTimeout(function () {
        location.reload();
      }, 30);
    }
  });

  $('#flt_sevice_one_permissions').change(function () {
    if ($(this).val() === "_all_") {
      $('#ftr_trainee_permissions').val("_all_");
      setCookie('ftr_trainee_permissions', $('#ftr_trainee_permissions').val(), 1);
      setCookie("tab_active", "permission");
      setCookie("flt_sevice_one_permissions", "_all_");
      setTimeout(function () {
        location.reload();
      }, 30);
    } else {
      $('#ftr_trainee_permissions').val("_all_");
      setCookie('ftr_trainee_permissions', $('#ftr_trainee_permissions').val(), 1);
      setCookie("tab_active", "permission");
      setCookie("flt_sevice_one_permissions", $(this).val());
      setTimeout(function () {
        location.reload();
      }, 30);
    }
  });
/*
  $('#flt_sevice_one_permissions').change(function () {
    setCookie('flt_sevice_one_permissions', $(this).val(), 1);
    setCookie("tab_active", "permission");
    setTimeout(function () {
      location.reload();
    }, 30);
  });
*/

  // Фильтры
  $('#flt_permission_active').change(function () {
    setCookie('flt_permission_active', $(this).val(), 1);
    let notice = false;
    $("#list_permission .list_string").each(function () {
      if (trainee_access && $('#flt_permission_active').val() === "1" && $(this).attr("data-notice") === "1") {
        notice = true;
      } else {
        notice = false;
      }
      if ($('#flt_permission_active').val() === "_all_"
      || ($('#flt_permission_active').val() === $(this).attr("data-status") || notice)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  function valid_modal_permission_field(check_list) {
    let text_notice = "";
    if (!trainee_access) {
      if ($("#trainee_select_permission").val() === "_none_" || !$("#trainee_select_permission").val()) {
        $("#trainee_select_permission").css("border-color", "red");
        text_notice += "Выберите обучающегося";
      } else {
        $("#trainee_select_permission").css("border-color", "#ced4da");
      }
    }
    if ($("#permission_modal_date").val()) {
      $("#permission_modal_date").css("border-color", "#ced4da");
    } else {
      $("#permission_modal_date").css("border-color", "red");
      text_notice ? text_notice += ", укажите дату отсутствия" : text_notice = "Укажите дату отсутствия";
    }

    if (check_list) {
      text_notice ? text_notice += ", отметьте мероприятия, для которых требуется разрешение на отсутствие" : text_notice = "Отметьте мероприятия, для которых требуется разрешение на отсутствие";
    }

    if ($("#permission_modal_comment").val()) {
      $("#permission_modal_comment").css("border-color", "#ced4da");
    } else {
      $("#permission_modal_comment").css("border-color", "red");
      text_notice ? text_notice += " и укажите причину отсутствия" : text_notice = "Укажите причину отсутствия";
    }
    if ($("#trainee_select_permission").val() === "_none_" || !$("#permission_modal_date").val() || !$("#permission_modal_comment").val() || check_list) {
      $("#show_notice_permission_modal").text(text_notice+".");
      $("#show_notice_permission_modal:hidden").show();
    } else {
      $("#show_notice_permission_modal").hide();
    }
  }
  // blank
  $('#trainee_select_permission').change(function () {
    valid_modal_permission_field();
    $("#edit_permission_blank").attr("data-member_key", $(this).val());
    if ($(this).val() && $(this).val() !== "_none_" && $("#permission_modal_date").val()) {
      get_sessions_for_blank($("#edit_permission_blank").attr("data-member_key"), $("#edit_permission_blank").attr("data-absence_date"), true);
    } else {
      $("#modal_permission_block").html("");
    }
  });

  $("#info_of_permission").click(function () {
    if ($("#author_of_permission").is(":visible")) {
      $("#author_of_permission").parent().hide();
    } else {
      $("#author_of_permission").parent().show();
    }
  });

  // filters mobile
  $("#permission_ftr_modal_apply").click(function () {
    if ($("#modal_flt_permission_active").val() !== $("#flt_permission_active").val()
    && $("#modal_ftr_trainee_permissions").val() === $("#ftr_trainee_permissions").val()
    && $("#modal_flt_sevice_one_permissions").val() === $("#flt_sevice_one_permissions").val()) {
      $("#flt_permission_active").val($("#modal_flt_permission_active").val());
      setCookie('flt_permission_active', $("#modal_flt_permission_active").val(), 1);
      filters_permissions();
    } else if ($("#modal_flt_permission_active").val() === $("#flt_permission_active").val()
    && $("#modal_ftr_trainee_permissions").val() === $("#ftr_trainee_permissions").val()
    && $("#modal_flt_sevice_one_permissions").val() === $("#flt_sevice_one_permissions").val()) {

    } else {
      setCookie('flt_permission_active', $("#modal_flt_permission_active").val(), 1);
      setCookie('flt_sevice_one_permissions', $("#modal_flt_sevice_one_permissions").val(), 1);
      if ($("#modal_ftr_trainee_permissions").val() === "_all_") {
        setCookie("flt_trainee","", 1);
      } else {
        setCookie("flt_trainee",$("#modal_ftr_trainee_permissions").val(), 1);
      }
      setCookie("tab_active", "permission");
      setTimeout(function () {
        location.reload();
      }, 30);
    }
  });

  $("#modal_flt_permission_active, #modal_flt_sevice_one_permissions, #modal_ftr_trainee_permissions").change(function (e) {
    let fltr_id = e.target.id;
    if (fltr_id === "modal_ftr_trainee_permissions" && $(this).val() !== "_all_") {
      $('#modal_flt_sevice_one_permissions').val("_all_");
    }
    if (fltr_id === "modal_flt_sevice_one_permissions" && $(this).val() !== "_all_") {
      $('#modal_ftr_trainee_permissions').val("_all_");
    }
  });

  $("#delete_permission_blank").click(function () {
    if (confirm("Удалить лист отсутствия?")) {
      fetch("ajax/ftt_attendance_ajax.php?type=delete_permission_blank&id="+$("#edit_permission_blank").attr("data-id")).then(response => response.json())
      .then(commits => {
        if (commits) {
          if (link_pb && !isNaN(link_pb)) {
           location.href = "ftt_attendance";
         } else {
           location.reload();
         }
        }
      });
    }
  });

  // сортировка
  $(".sort_date, .sort_trainee").click(function (e) {
    if (e.target.id === "sort_date" || e.target.id === "sort_trainee") {
      setCookie('sorting', e.target.id + "-asc", 356);
      if (e.target.id === "sort_date") {
        $("#sort_trainee").prop("checked", false)
      } else {
        $("#sort_date").prop("checked", false);
      }
    } else {
      let sorting_name = e.target.className;
      $(".sort_date i, .sort_trainee i").addClass("hide_element");
      if ($(this).hasClass("sort_date")) {
        $(".sort_trainee i").removeClass("fa");
        $(".sort_trainee i").removeClass("fa-sort-desc");
        $(".sort_trainee i").removeClass("fa-sort-asc");
      } else if ($(this).hasClass("sort_traine")) {
        $(".sort_date i").removeClass("fa");
        $(".sort_date i").removeClass("fa-sort-desc");
        $(".sort_date i").removeClass("fa-sort-asc");
      }

      $(this).find("i").removeClass("hide_element");
      if ($(this).find("i").hasClass("fa-sort-desc")) {
        $(this).find("i").removeClass("fa-sort-desc").addClass("fa-sort-asc");
        setCookie('sorting', sorting_name + "-desc", 356);
      } else if ($(this).find("i").hasClass("fa-sort-asc")) {
        $(this).find("i").removeClass("fa-sort-asc").addClass("fa-sort-desc");
        setCookie('sorting', sorting_name + "-asc", 356);
      } else {
        $(this).find("i").addClass("fa");
        $(this).find("i").addClass("fa-sort-asc");
        setCookie('sorting', sorting_name + "-desc", 356);
      }
    }
    setTimeout(function () {
      location.reload();
    }, 30);
  });

  // LINK PB
  if (link_pb && !isNaN(link_pb)) {
      if ($("#list_permission .list_string[data-id='"+link_pb+"']")[0]) {
        $("#edit_permission_blank").modal("show");
        open_blank($("#list_permission .list_string[data-id='"+link_pb+"']").click());
        // cookie
        setCookie("tab_active", "permission");
      }
  }
  $('#close_permission_blank, #edit_permission_blank .close').click(function (e) {
    if (link_pb && !isNaN(link_pb)) {
     location.href = "ftt_attendance";
    }
  });

  /*** SKIP TAB ***/
  // get cookie

  if (!trainee_access) {
    setCookie("skip_sorting_true", '');
    if (getCookie("flt_sevice_one_skip") !== window.adminId) {
      setCookie("flt_sevice_one_skip", window.adminId);
    }
    setCookie("ftr_trainee_skip", "_all_");
    if (getCookie("flt_skip_done") !== "0") {
      setCookie("flt_skip_done", 0);
    }
  } else {
    setCookie("skip_sorting_true", '');
    if (getCookie("flt_skip_done") !== "0") {
      setCookie("flt_skip_done", 0);
    }
  }

  // open blank by click on the string
  $(".skip_string").click(function (e) {
    clear_skip_blank();
    fill_skip_blank($(this))
    $("#edit_skip_blank").modal("show");

  });

  // filters
  $("#flt_skip_done, #flt_sevice_one_skip, #ftr_trainee_skip").change(function (e) {
    filterSkip();
  });

  function clear_skip_blank() {
    // fields
    $("#edit_skip_blank input").val("");
    $("#edit_skip_blank input[type='checkbox']").prop("checked", false);
    $("#edit_skip_blank select").val("");
    $("#show_status_in_skip_blank").removeClass("badge-secondary").removeClass("badge-danger").removeClass("badge-warning").removeClass("badge-success").text("");
    $("#skip_pic").html("");
    $("#day_of_week_skip_blank").text("");

    // data
    $("#edit_skip_blank").attr("data-id", "");
    $("#edit_skip_blank").attr("data-member_key", "");
    $("#edit_skip_blank").attr("data-serving_one", "");
    $("#edit_skip_blank").attr("data-status", "");
    //info
    $('#author_of_skip').parent().hide();
    $('#author_of_skip').text("");
    $("#send_date_of_skip").text("");
    $("#sevice_one_of_skip").text("");
    $("#allow_date_of_skip").text("");
    // buttons
    $("#send_skip_blank").show();
    $("#save_skip_blank").show();
    // colors
    $("#skip_modal_topic").css("border-color", "lightgrey");
    $("#skip_modal_file").parent().css("border", "none");
  }

  function fill_skip_blank(elem) {
    // data
    $("#edit_skip_blank").attr("data-id", elem.attr("data-id"));
    $("#edit_skip_blank").attr("data-member_key", elem.attr("data-member_key"));
    $("#edit_skip_blank").attr("data-serving_one", elem.attr("data-serving_one"));
    $("#edit_skip_blank").attr("data-status", elem.attr("data-status"));
    $("#edit_skip_blank").attr("data-file", elem.attr("data-file"));

    // fields
    $("#trainee_select_skip").val(elem.attr("data-member_key"));
    $("#skip_modal_date").val(elem.attr("data-date"));
    $("#skip_modal_topic").val(elem.attr("data-topic"));
    $("#skip_modal_comment").val(elem.attr("data-comment"));

    // IDEA: перенести в инфо и оформить в <span>, но отображать над полями
    $("#skip_modal_session").val(elem.attr("data-session_name"));
    //$("#skip_modal_time").val(elem.attr("data-session_time"));
    $("#day_of_week_skip_blank").text(getNameDayOfWeekByDayNumber(elem.attr("data-date")));

    // pic
    if (elem.attr("data-file")) {
      let result_arr = elem.attr("data-file");
      result_arr = result_arr.split(";")
      for (var i = 0; i < result_arr.length; i++) {
        $("#skip_pic").append('<div class="col-10"><button type="button" data-toggle="modal" class="skip_modal_pic_preview_open btn btn-primary btn-sm mr-2 mb-2" data-target="#skip_modal_pic_preview">Просмотр</button><a class="skip_pic" href="' + result_arr[i] + '" target="_blank">скачать файл</a></div>'
        + '</div><div class="col-2 text-right"><i class="fa fa-trash text-danger cursor-pointer pic_skip_delete mr-3" aria-hidden="true" style="font-size: 1.5rem;"></i></div>');
      }
      $(".pic_skip_delete").click(function () {
        skip_pic_delete($(this));
      });
      $(".skip_modal_pic_preview_open").click(function () {
        show_pic_preview($(this));
      });
    }

    /*if (elem.attr("data-file")) {
      $("#pic_skip_delete").show();
    } else {
      $("#pic_skip_delete").hide();
    }
    if (elem.attr("data-file")) {
      $(".skip_pic").attr("href", );
      $(".skip_pic").text("скачать файл");
    }*/

    // buttons & behavior
    $("#send_skip_blank").hide();
    $("#save_skip_blank").show();
    $("#skip_modal_done").attr("disabled", false);
    $("#skip_modal_topic").attr("disabled", false);
    $("#skip_modal_comment").attr("disabled", false);
    $("#skip_modal_file").attr("disabled", false);
    if (elem.attr("data-status") === '0') {
      $("#skip_modal_done").attr("disabled", true);
      $("#send_skip_blank").show();
    } else if (elem.attr("data-status") === '1') {
      if (trainee_access) {
        $("#save_skip_blank").hide();
        $("#pic_skip_delete").hide();
        $("#skip_modal_topic").attr("disabled", true);
        $("#skip_modal_comment").attr("disabled", true);
        $("#skip_modal_file").attr("disabled", true);
      }
    } else if (elem.attr("data-status") === '2') {
        $("#save_skip_blank").hide();
        $("#pic_skip_delete").hide();
        $("#skip_modal_topic").attr("disabled", true);
        $("#skip_modal_comment").attr("disabled", true);
        $("#skip_modal_file").attr("disabled", true);
        $("#skip_modal_done").attr("disabled", true);
        $("#skip_modal_done").prop("checked", true);
    } else if (elem.attr("data-status") === '3') {
      $("#skip_modal_done").prop("checked", true);
    }
    // badge
    $("#show_status_in_skip_blank").removeClass("badge-secondary").removeClass("badge-danger").removeClass("badge-warning").removeClass("badge-success").text("");
    status_choisen($("#show_status_in_skip_blank"),elem.attr("data-status"));

    // info
    if (elem.attr("data-status") === '0') {
      $("#send_date_of_skip").text("Дата создания " + elem.attr("data-create_send"));
    } else {
      $("#send_date_of_skip").text("Дата отправки " + elem.attr("data-create_send"));
    }

    /*$('#author_of_skip').parent().hide();
    $('#author_of_skip').text("");
    $("#sevice_one_of_skip").text("");
    $("#allow_date_of_skip").text("");*/
  }

  // поведение
  $("#info_of_skip").click(function () {
    if ($("#author_of_skip").is(":visible")) {
      $("#author_of_skip").parent().hide();
    } else {
      $("#author_of_skip").parent().show();
    }
  });

  // pic
  $("#skip_modal_file").change(function () {
    let id = $("#edit_skip_blank").attr("data-id");
    let skip_data_blank = new FormData();
    $("#send_skip_blank").attr("disabled", true);
    $("#save_skip_blank").attr("disabled", true);
    if ($("#skip_modal_file")[0].files[0]) {
      for (var i = 0; i < $("#skip_modal_file")[0].files.length; i++) {
        skip_data_blank.set("blob"+i, $("#skip_modal_file")[0].files[i]);
      }
      $("#spinner_upload").show();
      fetch("ajax/ftt_attendance_ajax.php?type=set_pic&id=" + id, {
        method: 'POST',
        body: skip_data_blank
      })
      .then(response => response.json())
      .then(commits => {
        $("#send_skip_blank").attr("disabled", false);
        $("#save_skip_blank").attr("disabled", false);
        $("#spinner_upload").hide();
        if (commits.result[1][0] === "Н") {
          showError(commits.result[1]);
        } else if (commits.result[1]) {
          $("div[data-id='" + id + "']").attr("data-file", commits.result[0]);
          $("#skip_modal_file").parent().css("border", "none");
          let result_arr = commits.result[1];
          result_arr = result_arr.split(";");
          let list_pics_lenght = 0;
          $(".pic_skip_delete").each(function () {
            list_pics_lenght++;
          });
          for (let i = 0; i < result_arr.length; i++) {
            list_pics_lenght++;
            let res = $("#skip_pic").append('<div class="col-10"><button type="button" data-toggle="modal" class="btn btn-primary btn-sm mr-2 mb-2 skip_modal_pic_preview_open" data-target="#skip_modal_pic_preview">Просмотр</button><a class="skip_pic" href="' + result_arr[i] + '" target="_blank">скачать файл</a></div>'
            + '</div><div class="col-2 text-right"><i id="skip_dlt_btn_'+list_pics_lenght+'" class="fa fa-trash text-danger cursor-pointer pic_skip_delete mr-3" aria-hidden="true" style="font-size: 1.5rem;"></i></div>');

            $("#skip_dlt_btn_"+list_pics_lenght).click(function () {
              skip_pic_delete($(this));
            });
          }

          $(".skip_modal_pic_preview_open").click(function () {
            show_pic_preview($(this));
          });
        }
        /*if ($("#skip_modal_topic").val()) {
          $("#skip_modal_topic").css("border-color", "lightgrey");
        }*/
      });
    }
  });

  // save
  $("#save_skip_blank").click(function () {
    cookie_filters();
    setTimeout(function () {
      save_skip_blank();
    }, 30);
    $("#edit_skip_blank").modal("hide");
  });

  $("#send_skip_blank").click(function () {
    cookie_filters();
    if (!$("#skip_modal_topic").val()) {
      showError("Заполните поле тема.");
      $("#skip_modal_topic").css("border-color", "red");
      return;
    } else if(!$(".skip_pic").attr("href")) {
      showError("Прикрепите файл.");
      $("#skip_modal_file").parent().css("border", "1px solid red");
      return;
    }
    //$("#skip_modal_topic").css("border-color", "lightgrey");
    $("#skip_modal_file").parent().css("border", "none");
    setTimeout(function () {
      save_skip_blank(1);
    }, 30);
    $("#edit_skip_blank").modal("hide");
  });

  function save_skip_blank(send) {
    let skip_data_blank = new FormData();
    skip_data_blank_val = {};
    skip_data_blank_val["id"] = $("#edit_skip_blank").attr("data-id");
    skip_data_blank_val["topic"] = $("#skip_modal_topic").val();
    skip_data_blank_val["comment"] = $("#skip_modal_comment").val();
    if ($("#skip_modal_done").prop("checked")) {
      skip_data_blank_val["status"] = 2;
    } else if(send) {
      skip_data_blank_val["status"] = 1;
    } else {
      if ($("#edit_skip_blank").attr("data-status") === '2') {
        skip_data_blank_val["status"] = 1;
      } else {
        skip_data_blank_val["status"] = $("#edit_skip_blank").attr("data-status");
      }
    }

    skip_data_blank.set("data", JSON.stringify(skip_data_blank_val));
    fetch("ajax/ftt_attendance_ajax.php?type=set_skip_blank", {
      method: 'POST',
      body: skip_data_blank
    })
    .then(response => response.text())
    .then(commits => {
      setTimeout(function () {
        location.reload();
      }, 50);
    });
  }
  function cookie_filters() {
    setCookie("skip_sorting_true", 1, 1);
    setCookie("flt_skip_done", $("#flt_skip_done").val(), 1);
    if (!trainee_access) {
      setCookie("flt_sevice_one_skip", $("#flt_sevice_one_skip").val(), 1);
      setCookie("ftr_trainee_skip", $("#ftr_trainee_skip").val(), 1);
    }
  }
  // сортировка
  $(".skip_sort_date, .skip_sort_trainee").click(function (e) {
    cookie_filters();
    if (e.target.id === "skip_sort_date" || e.target.id === "skip_sort_trainee") {
      setCookie('skip_sorting', e.target.id + "-asc", 356);
      if (e.target.id === "skip_sort_date") {
        $("#skip_sort_trainee").prop("checked", false)
      } else {
        $("#skip_sort_date").prop("checked", false);
      }
    } else {
      let sorting_name = e.target.className;
      $(".skip_sort_date i, .skip_sort_trainee i").addClass("hide_element");
      if ($(this).hasClass("skip_sort_date")) {
        $(".skip_sort_trainee i").removeClass("fa");
        $(".skip_sort_trainee i").removeClass("fa-sort-desc");
        $(".skip_sort_trainee i").removeClass("fa-sort-asc");
      } else if ($(this).hasClass("skip_sort_traine")) {
        $(".skip_sort_date i").removeClass("fa");
        $(".skip_sort_date i").removeClass("fa-sort-desc");
        $(".skip_sort_date i").removeClass("fa-sort-asc");
      }

      $(this).find("i").removeClass("hide_element");
      if ($(this).find("i").hasClass("fa-sort-desc")) {
        $(this).find("i").removeClass("fa-sort-desc").addClass("fa-sort-asc");
        setCookie('skip_sorting', sorting_name + "-desc", 356);
      } else if ($(this).find("i").hasClass("fa-sort-asc")) {
        $(this).find("i").removeClass("fa-sort-asc").addClass("fa-sort-desc");
        setCookie('skip_sorting', sorting_name + "-asc", 356);
      } else {
        $(this).find("i").addClass("fa");
        $(this).find("i").addClass("fa-sort-asc");
        setCookie('skip_sorting', sorting_name + "-desc", 356);
      }
    }
    setTimeout(function () {
      location.reload();
    }, 30);
  });
  function skip_pic_delete(elem) {
    let patch = elem.parent().prev().find(".skip_pic").attr("href");
    if (!patch) {
      element.prev().remove();
      element.remove();
      return;
    }
    let id = $("#edit_skip_blank").attr("data-id");
    let element = elem.parent();
    // УДАЛЕНИЕ КАРТИНКИ
    fetch("ajax/ftt_attendance_ajax.php?type=delete_pic&id=" + id + "&patch=" + patch)
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

  $(".skip_modal_pic_preview_open").click(function () {
    show_pic_preview($(this));
  });
  // delete skip blank
  $("#delete_skip_blank").click(function () {
    if (confirm("Удалить бланк?")) {
      fetch("ajax/ftt_attendance_ajax.php?type=delete_skip&id=" + $("#edit_skip_blank").attr("data-id"))
      .then(response => response.json())
      .then(data => {
        location.reload();
      });
    }
  });

  $('#ftr_trainee_skip_mbl, #flt_sevice_one_skip_mbl').change(function (e) {
    if (e.target.id === "ftr_trainee_skip_mbl" && $(this).val() !== "_all_") {
      $('#flt_sevice_one_skip_mbl').val("_all_");
    } else if (e.target.id === "flt_sevice_one_skip_mbl" && $(this).val() !== "_all_") {
      $('#ftr_trainee_skip_mbl').val("_all_");
    }
  });

  $("#apply_filters_mbl").click(function () {
    $("#flt_skip_done").val($("#flt_skip_done_mbl").val());
    $('#flt_sevice_one_skip').val($('#flt_sevice_one_skip_mbl').val());
    $('#ftr_trainee_skip').val($('#ftr_trainee_skip_mbl').val());
    filterSkip();
  });

  function show_pic_preview(elem) {
    $("#skip_modal_pic_preview_container").attr("src", elem.next().attr("href"));
  }
  /*** SKIP TAB STOP ***/


// DOCUMENT READY STOP
});
