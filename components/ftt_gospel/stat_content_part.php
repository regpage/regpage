<button id="report_modal_open" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#gospel_modal_statistic">Отчёт2</button>
<button id="report_modal_open" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#gospel_modal_statistic_personal">Отчёт3</button>
<button id="report_group_os" type="button" class="btn btn-primary btn-sm">Графики</button>
<div class="">
  <canvas id="stat_diagram_os"></canvas>
</div>
<div class="">
  <?php
 // Группы
 if ($ftt_access['group'] === 'staff') {
   foreach ($teamsList as $key => $value){
     echo '<div class="">';
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

  $("#report_group_os").click(function () {

  });
  let ctx = document.getElementById('stat_diagram_os').getContext('2d');
  let chart = new Chart(ctx, {
  // Тип графика
  type: 'line',

  // Создание графиков
  data: {
    // Точки графиков
    labels: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Февраль', 'Март'],
    // График
    datasets: [{
        label: 'Тестовая команда', // Название
        backgroundColor: 'transparent', // Цвет закраски
        borderColor: 'rgb(255, 99, 132)', // Цвет линии
        pointBackgroundColor: 'darkred',
        data: [0, 10, 5, 2, 150, 30, 50, 0, 10, 5, 2, 150, 30, 50, 90, 130] // Данные каждой точки графика
    }]
  },

  // Настройки графиков
  options: {}
});
</script>

</div>
