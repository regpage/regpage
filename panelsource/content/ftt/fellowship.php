<?php
// подключаем контроллер подраздела
include_once 'panelsource/content/ftt/fellowship_cntrl.php';
?>
<!-- РУЧНОЕ ДОБАВЛЕНИЕ ЗАПИСЕЙ НА ОБЩЕНИЕ ПВОМ -->
<div class="row">
  <div class="col-10">
    <h4>РУЧНОЕ ДОБАВЛЕНИЕ ЗАПИСЕЙ НА ОБЩЕНИЕ НА 2 НЕДЕЛИ ВПЕРЁД</h4>
    <p>По умолчанию функция отключена. Список служащих задаётся вручную. День старта по умолчанию завтра. Перед использованием рекомендуется выгрузить базу и дополнительно таблицу ftt_fellowship</p>
    <a href="add_fellowship">Запустить скрипт</a>
  </div>
</div>
<hr class="mb-2 mt-3">
<div class="row">
  <div class="col-10">
    <h4>Добавить шаблоны для раздела Общение</h4>
    <p>Согласно этим шаблонам будет создаваться расписание общения в течении семестра.</p>
    <a href="add_fellowship_tmpl">Добавить новый</a>

  </div>
</div>
<hr class="mb-2 mt-3">
<div class="row">
  <div class="col-10">
    <h4>Текущие шаблоны для раздела Общение</h4>
    <p>Шаблоны которые на данный момент есть в базе данных.</p>
    <div id="fellowship_tmpl_list">
    <?php
    foreach ($fttFellowshipTmpl as $key => $value) {
      echo "<div data-member_key='{$value['serving_one']}'><span class='fellowship_tmpl_name'>{$value['name']}</span> <span class='fellowship_tmpl_day'> {$value['day']}</span> <span class='fellowship_tmpl_time'> {$value['time']}</span> <span class='fellowship_tmpl_duration'>{$value['duration']}</span> <span class='set_fellowship_tmpl cursor-pointer text-primary'> изменить</span> <span class='dlt_fellowship_tmpl cursor-pointer text-danger'> удалить</span></div>";
    }
    ?>
    </div>
    <span id="dlt_all_fellowship_tmpl" class="cursor-pointer text-danger">Удалить все</span>
  </div>
</div>
<hr class="mb-2 mt-3">
