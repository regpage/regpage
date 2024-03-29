<div class="row" style="margin-left: -2px; padding-top: 21px;">
  <button id="go_back" type="button" class="btn btn-secondary btn-sm ml-0">Назад</button>
  <button id="report_modal_open" type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#gospel_modal_statistic">Отчёт по группам</button>
  <button id="report_modal_open" type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#gospel_modal_statistic_personal">Персональные отчёты</button>
  <button id="report_group_os" type="button" class="btn btn-primary btn-sm ml-2">Графики</button>
</div>
<div>
  <?php
 // Группы
 if ($ftt_access['group'] === 'staff') {
   foreach ($teamsList as $key => $value){
     echo '<div class="team_chart">';
     gospelStatFun($key, $teamsList, false);
     echo '</div>';
   }
 }

?>
<script>

  $("h5").click(function () {
    let text = $(this).text();
    if ($(this).next().hasClass("d-none")) {
      $(this).next().removeClass("d-none");
      $(this).text(text.replace("+","-"));
    } else {
      $(this).next().addClass("d-none");
      $(this).text(text.replace("-","+"));
    }
  });

    $(".team_chart").each(function () {
      $(this).find(".d-flex").each(function () {
        $(this).before("<canvas height='50'></canvas>");
        el = $(this).prev()[0].getContext('2d');
        //$(this).before("<canvas></canvas>");
        data = getChartData($(this));
        /* Г Р А Ф И К */
        charts = new Chart(el, {
        // Тип графика
          type: 'line',
          // Создание графиков
          data: {
            // Точки графиков
            labels: data[0],
            // График
            datasets: [{
              label: "Группа " + data[2], // Название
              backgroundColor: 'transparent', // Цвет закраски
              borderColor: 'rgb(255, 99, 132)', // Цвет линии
              pointBackgroundColor: 'darkred',
              data: data[1] // Данные каждой точки графика
            }]
          },

          // Настройки графиков
          options: {}
        });
        /* Г Р А Ф И К  С Т О П */
      return;
      });
    });

    $("#go_back").click(function () {
      location.pathname = "ftt_gospel";
    });

  function getChartData(element) {
    let data = [];
    let label = [];
    let group = [];
    //data['team'] = element.find("h5").text();
    element.find(".one_chart").each(function () {
      label.push($(this).attr("data-period"));
      data.push($(this).attr("data-flyers"));
      group = $(this).attr("data-group");
    });
    return [label, data, group];
  }
</script>

</div>
