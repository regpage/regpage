function statistics_dates() {
  // html
  let html = "<table>";
  // header
  let header = "<thead><tr><th class='extra_groups' style='text-align: left; vertical-align: top; min-width: 80px;'>Дата</th>"
  + "<th class='extra_groups' style='text-align: left; vertical-align: top; min-width: 90px;'>Команда</th>"
  + "<th class='extra_groups' style='text-align: left; vertical-align: top; min-width: 200px;'>Состав группы</th>"
  + "<th style='text-align: right; vertical-align: top; min-width: 40px;'>Л</th>"
  + "<th style='text-align: right; vertical-align: top; min-width: 40px;'>Б</th>"
  + "<th style='text-align: right; vertical-align: top; min-width: 40px;'>М</th>"
  + "<th style='text-align: right; vertical-align: top; min-width: 40px;'>Н</th>"
  + "<th style='text-align: right; vertical-align: top; min-width: 40px;'>П</th>"
  + "<th style='text-align: right; vertical-align: top; min-width: 40px;'>В</th>"
  + "<th style='text-align: right; vertical-align: top; min-width: 40px;'>С</th>"
  + "<th style='text-align: right; vertical-align: top; min-width: 40px;'>Д</th></tr></thead>";
  // ["Дата", "Команда", "Состав группы", "Л", "Б", "М", "Н", "П", "В", "С", "Д"]
  // body
  let body = "<tbody>";
  $("#list_content .list_string").each(function () {
    if ($(this).is(":visible")) {
      body += "<tr><td style='text-align: left; vertical-align: top; min-width: 80px;'>"
      + $(this).find("div:nth-child(1) span").text() + "</td><td style='text-align: left; vertical-align: top; min-width: 90px;'>"
      + $(this).find("div:nth-child(2) .col_n_2_2").text() + "</td><td style='text-align: left; vertical-align: top; min-width: 200px;'>"
      + $(this).find("div:nth-child(3) span").text() + "</td><td style='text-align: right; vertical-align: top; min-width: 40px;'>"
      + $(this).find("div:nth-child(4) span").text() + "</td><td style='text-align: right; vertical-align: top; min-width: 40px;'>"
      + $(this).find("div:nth-child(5) span").text() + "</td><td style='text-align: right; vertical-align: top; min-width: 40px;'>"
      + $(this).find("div:nth-child(6) span").text() + "</td><td style='text-align: right; vertical-align: top; min-width: 40px;'>"
      + $(this).find("div:nth-child(7) span").text() + "</td><td style='text-align: right; vertical-align: top; min-width: 40px;'>"
      + $(this).find("div:nth-child(8) span").text() + "</td><td style='text-align: right; vertical-align: top; min-width: 40px;'>"
      + $(this).find("div:nth-child(9) span").text() + "</td><td style='text-align: right; vertical-align: top; min-width: 40px;'>"
      + $(this).find("div:nth-child(10) span").text() + "</td><td style='text-align: right; vertical-align: top; min-width: 40px;'>"
      + $(this).find("div:nth-child(11) span").text()
      body += "</td></tr>";
    }
  });
  body += "</tbody>";
  html += header;
  html += body;
  html += "</table>";
  $("#gospel_report_dates").html(html);
}

// рендорим поля для групп в таблице отчёта
function render_print_report(groups) {
  let groups_html, body_html;
  groups_html = "";
  let body_flyers = "", body_people = "", body_prayers = "", body_baptism = "", body_meets_last = "", body_meets_current = "", body_meetings_last = "", body_meetings_current = "", body_first_contacts = "", body_further_contacts = "", body_homes = "";

  for (let group in groups) {
    groups_html += '<th class="extra_groups" style="text-align: right; min-width: 30px;">'+group+'</th>';
    body_flyers += "<td class='extra_groups' style='text-align: right;  vertical-align: top; min-width: 30px;'>"+groups[group]["flyers"]+"</td>";
    body_people += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 30px;'>"+groups[group]["people"]+"</td>";
    body_prayers += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 30px;'>"+groups[group]["prayers"]+"</td>";
    body_baptism += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 30px;'>"+groups[group]["baptism"]+"</td>";
    body_meets_last += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 30px;'>"+groups[group]["meets_last"]+"</td>";
    body_meets_current += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 30px;'>"+groups[group]["meets_current"]+"</td>";
    body_meetings_last += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 30px;'>"+groups[group]["meetings_last"]+"</td>";
    body_meetings_current += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 30px;'>"+groups[group]["meetings_current"]+"</td>";
    body_first_contacts += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 30px;'>"+groups[group]["first_contacts"]+"</td>";
    body_further_contacts += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 30px;'>"+groups[group]["further_contacts"]+"</td>";
    body_homes += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 30px;'>"+groups[group]["homes"]+"</td>";
  }
  $(groups_html).insertAfter("#th_questions");
  $(body_flyers).insertAfter("#question_flyers");
  $(body_people).insertAfter("#question_people");
  $(body_prayers).insertAfter("#question_prayers");
  $(body_baptism).insertAfter("#question_baptism");
  $(body_meets_last).insertAfter("#question_meets_last");
  $(body_meets_current).insertAfter("#question_meets_current");
  $(body_meetings_last).insertAfter("#question_meetings_last");
  $(body_meetings_current).insertAfter("#question_meetings_current");
  $(body_first_contacts).insertAfter("#question_first_contacts");
  $(body_further_contacts).insertAfter("#question_further_contacts");
  $(body_homes).insertAfter("#question_homes");
}
// Печать
function statistics_counter() {
  //$("#team_select_print").val(); //serving_ones_list_full[admin_id_gl]["gospel_team"]
  let all_groups = [];
  if ($("#group_select_print").val() === "_all_" && $("#team_select_print").val() !== "_all_") {
    $("#group_select_print option").each(function () {
      if ($(this).val() !== "_all_") {
        all_groups.push($(this).val());
      }
    });
  }

  fetch("ajax/ftt_gospel_ajax.php?type=get_gospel_str&team="+$("#team_select_print").val()+"&period=_all_&from=&to=")
  .then(response => response.json())
  .then(commits => {
    let selected_group = $("#group_select_print").val();
    let stat = commits.result;
    // all time variable
    let flyers = 0, people = 0, prayers = 0, baptism = 0, meets_last = 0, meets_current = 0, meetings_last = 0;
    let meetings_current = 0, first_contacts = 0, further_contacts = 0, homes = 0;
    // period variable
    let period_from = new Date($("#period_from_print").val());
    let period_to = new Date($("#period_to_print").val());
    let range_flyers = 0, range_people = 0, range_prayers = 0, range_baptism = 0, range_meets_last = 0, range_meets_current = 0, range_meetings_last = 0;
    let range_meetings_current = 0, range_first_contacts = 0, range_further_contacts = 0, range_homes = 0;
    let group_stat = [];
    for (let i = 0; i < stat.length; i++) {
      if (stat[i].gospel_group) {
        let key_arr = all_groups.indexOf(stat[i].gospel_group);
        if (key_arr !== -1) {
          all_groups.splice(key_arr, 1);
        }
      }
      // При условии что отчёт формируется по всем группам
      // Добавить массив с элементами по количеству групп. В каждой группе все элементы для боди.
      // В них записывать статистику и передавать в функцию рендеринга
      if (selected_group === stat[i].gospel_group && selected_group !== "_all_" && selected_group) {
        flyers += Number(stat[i].flyers);
        people += Number(stat[i].people);
        prayers += Number(stat[i].prayers);
        baptism += Number(stat[i].baptism);
        meets_last += Number(stat[i].meets_last);
        meets_current += Number(stat[i].meets_current);
        meetings_last += Number(stat[i].meetings_last);
        meetings_current += Number(stat[i].meetings_current);
        first_contacts += Number(stat[i].first_contacts);
        further_contacts += Number(stat[i].further_contacts);
        homes += Number(stat[i].homes);
        // periods
        let date_str = new Date(stat[i].date);
        if (date_str >= period_from && date_str <= period_to && (stat[i].gospel_team === $("#team_select_print").val() || $("#team_select_print").val() === "_all_")) {
          range_flyers += Number(stat[i].flyers);
          range_people += Number(stat[i].people);
          range_prayers += Number(stat[i].prayers);
          range_baptism += Number(stat[i].baptism);
          range_meets_last += Number(stat[i].meets_last);
          range_meets_current += Number(stat[i].meets_current);
          range_meetings_last += Number(stat[i].meetings_last);
          range_meetings_current += Number(stat[i].meetings_current);
          range_first_contacts += Number(stat[i].first_contacts);
          range_further_contacts += Number(stat[i].further_contacts);
          range_homes += Number(stat[i].homes);
        }
      }
      if (selected_group === "_all_" || !selected_group) {
        if (selected_group === "_all_" && $("#team_select_print").val() !== "_all_") {
          if (!group_stat[stat[i].gospel_group]) {
            group_stat[stat[i].gospel_group] = [];
            group_stat[stat[i].gospel_group]["flyers"] = 0;
            group_stat[stat[i].gospel_group]["people"] = 0;
            group_stat[stat[i].gospel_group]["prayers"] = 0;
            group_stat[stat[i].gospel_group]["baptism"] = 0;
            group_stat[stat[i].gospel_group]["meets_last"] = 0;
            group_stat[stat[i].gospel_group]["meets_current"] = 0;
            group_stat[stat[i].gospel_group]["meetings_last"] = 0;
            group_stat[stat[i].gospel_group]["meetings_current"] = 0;
            group_stat[stat[i].gospel_group]["first_contacts"] = 0;
            group_stat[stat[i].gospel_group]["further_contacts"] = 0;
            group_stat[stat[i].gospel_group]["homes"] = 0;
          }
          let date_str_group = new Date(stat[i].date);
          if (date_str_group >= period_from && date_str_group <= period_to) {
            group_stat[stat[i].gospel_group]["flyers"] += Number(stat[i].flyers);
            group_stat[stat[i].gospel_group]["people"] += Number(stat[i].people);
            group_stat[stat[i].gospel_group]["prayers"] += Number(stat[i].prayers);
            group_stat[stat[i].gospel_group]["baptism"] += Number(stat[i].baptism);
            group_stat[stat[i].gospel_group]["meets_last"] += Number(stat[i].meets_last);
            group_stat[stat[i].gospel_group]["meets_current"] += Number(stat[i].meets_current);
            group_stat[stat[i].gospel_group]["meetings_last"] += Number(stat[i].meetings_last);
            group_stat[stat[i].gospel_group]["meetings_current"] += Number(stat[i].meetings_current);
            group_stat[stat[i].gospel_group]["first_contacts"] += Number(stat[i].first_contacts);
            group_stat[stat[i].gospel_group]["further_contacts"] += Number(stat[i].further_contacts);
            group_stat[stat[i].gospel_group]["homes"] += Number(stat[i].homes);
          }
        }
        flyers += Number(stat[i].flyers);
        people += Number(stat[i].people);
        prayers += Number(stat[i].prayers);
        baptism += Number(stat[i].baptism);
        meets_last += Number(stat[i].meetings_last);
        meets_current += Number(stat[i].meets_current);
        meetings_last += Number(stat[i].meetings_last);
        meetings_current += Number(stat[i].meetings_current);
        first_contacts += Number(stat[i].first_contacts);
        further_contacts += Number(stat[i].further_contacts);
        homes += Number(stat[i].homes);
        // periods
        let date_str = new Date(stat[i].date);
        if (date_str >= period_from && date_str <= period_to && (stat[i].gospel_team === $("#team_select_print").val() || $("#team_select_print").val() === "_all_")) {
          range_flyers += Number(stat[i].flyers);
          range_people += Number(stat[i].people);
          range_prayers += Number(stat[i].prayers);
          range_baptism += Number(stat[i].baptism);
          range_meets_last += Number(stat[i].meets_last);
          range_meets_current += Number(stat[i].meets_current);
          range_meetings_last += Number(stat[i].meetings_last);
          range_meetings_current += Number(stat[i].meetings_current);
          range_first_contacts += Number(stat[i].first_contacts);
          range_further_contacts += Number(stat[i].further_contacts);
          range_homes += Number(stat[i].homes);
        }
      }
    }

    if (all_groups.length > 0) {
      // добавляем 0 для групп отсутствующих в массиве
      for (let j = 0; j < all_groups.length; j++) {
        group_stat[all_groups[j]] = {baptism: 0, first_contacts:0, flyers:0, further_contacts:0, homes:0, meetings_current:0, meetings_last:0, meets_current:0, meets_last:0, people:0, prayers:0};
      }
    }
    if (selected_group === "_all_") {
      $(".extra_groups").remove();
        render_print_report(group_stat);

    } else {
      $(".extra_groups").remove();
      // Получаем цели для колонки целей (только для групп)
      if ($("#group_select_print").val() && $("#group_select_print").val() !== "_all_") {
        fetch("ajax/ftt_gospel_ajax.php?type=get_ftt_gospel_goals&gospel_team=" +$("#team_select_print").val()+"&gospel_group="+$("#group_select_print").val())
        .then(response => response.json())
        .then(commits => {
          let goals = commits.result;
          let flyers = goals["flyers"] || 0;
          let people = goals["people"] || 0;
          let prayers = goals["prayers"] || 0;
          let baptism = goals["baptism"] || 0;
          let fruit = goals["fruit"] || 0;
          let groups_html = "", body_flyers = "", body_people = "", body_prayers = "", body_baptism = "", body_meets_last = "", body_meets_current = "", body_meetings_last = "", body_meetings_current = "", body_first_contacts = "", body_further_contacts = "", body_homes = "";
          // Цели
          if (goals) {
              groups_html += '<th class="extra_groups" style="text-align: right; vertical-align: top; min-width: 80px;">Цели</th>';
              body_flyers += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 80px;'>"+flyers+"</td>";
              body_people += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 80px;'>"+people+"</td>";
              body_prayers += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 80px;'>"+prayers+"</td>";
              body_baptism += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 80px;'>"+baptism+"</td>";
              body_meets_last += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 80px;'>"+fruit+"</td>";
              body_meets_current += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 80px;'></td>";
              body_meetings_last += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 80px;'></td>";
              body_meetings_current += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 80px;'></td>";
              body_first_contacts += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 80px;'></td>";
              body_further_contacts += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 80px;'></td>";
              body_homes += "<td class='extra_groups' style='text-align: right; vertical-align: top; min-width: 80px;'></td>";

              $(groups_html).insertAfter("#th_questions");
              $(body_flyers).insertAfter("#question_flyers");
              $(body_people).insertAfter("#question_people");
              $(body_prayers).insertAfter("#question_prayers");
              $(body_baptism).insertAfter("#question_baptism");
              $(body_meets_last).insertAfter("#question_meets_last");
              $(body_meets_current).insertAfter("#question_meets_current");
              $(body_meetings_last).insertAfter("#question_meetings_last");
              $(body_meetings_current).insertAfter("#question_meetings_current");
              $(body_first_contacts).insertAfter("#question_first_contacts");
              $(body_further_contacts).insertAfter("#question_further_contacts");
              $(body_homes).insertAfter("#question_homes");
          }
        });
      }
    }
    $("#team_name_print").text($("#team_select_print option:selected").text() + ": " + dateStrToddmmyyyyToyyyymmdd($("#period_from_print").val(), true) + " — " + dateStrToddmmyyyyToyyyymmdd($("#period_to_print").val(), true));

    $("#flyers_all").text(flyers);
    $("#people_all").text(people);
    $("#prayers_all").text(prayers);
    $("#baptism_all").text(baptism);
    $("#meets_last_all").text(meets_last);
    $("#meets_current_all").text(meets_current);
    $("#meetings_last_all").text(meetings_last);
    $("#meetings_current_all").text(meetings_current);
    $("#first_contacts_all").text(first_contacts);
    $("#further_contacts_all").text(further_contacts);
    $("#homes_all").text(homes);

    $("#range_flyers").text(range_flyers);
    $("#range_people").text(range_people);
    $("#range_prayers").text(range_prayers);
    $("#range_baptism").text(range_baptism);
    $("#range_meets_last").text(range_meets_last);
    $("#range_meets_current").text(range_meets_current);
    $("#range_meetings_last").text(range_meetings_last);
    $("#range_meetings_current").text(range_meetings_current);
    $("#range_first_contacts").text(range_first_contacts);
    $("#range_further_contacts").text(range_further_contacts);
    $("#range_homes").text(range_homes);
  });
}
