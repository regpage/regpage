<?php
// подключаем контроллер подраздела
include_once 'panelsource/content/ftt/fellowship_cntrl.php';
?>
<!-- РУЧНОЕ ДОБАВЛЕНИЕ ЗАПИСЕЙ НА ОБЩЕНИЕ ПВОМ -->
<div class="row">
  <div class="col-10">
    <h4>РУЧНОЕ ДОБАВЛЕНИЕ ЗАПИСЕЙ НА ОБЩЕНИЕ НА 2 НЕДЕЛИ ВПЕРЁД</h4>
    <p>По умолчанию функция отключена. Список служащих задаётся вручную. День старта по умолчанию завтра. Перед использованием рекомендуется выгрузить базу и дополнительно таблицу ftt_fellowship</p>
    <strong id="add_fellowship_two_weeks" class="cursor-pointer text-primary">Запустить скрипт</strong>
  </div>
</div>
<hr class="mb-2 mt-3">
<div class="row">
  <div class="col-10">
    <h4>Добавить шаблоны для раздела Общение</h4>
    <p>Согласно этим шаблонам будет создаваться расписание общения в течении семестра.</p>
    <strong id="add_fellowship_tmpl" class="cursor-pointer text-primary" data-toggle="modal" data-target="#add_fellowship_tmpl_modal">Добавить новый</strong>

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
      echo "<div data-member_key='{$value['serving_one']}'><span class='fellowship_tmpl_name'>{$value['name']}</span> <span class='fellowship_tmpl_day'> {$value['day']}</span> <span class='fellowship_tmpl_time'> {$value['time']}</span> <span class='fellowship_tmpl_duration'>{$value['duration']}</span> <span class='set_fellowship_tmpl cursor-pointer text-primary' data-toggle='modal' data-target='#add_fellowship_tmpl_modal'> изменить</span> <span class='dlt_fellowship_tmpl cursor-pointer text-danger'> удалить</span></div>";
    }
    ?>
    </div>
  </div>
</div>
<div class="row mt-2">
  <div class="col-10">
    <strong id="dlt_all_fellowship_tmpl" class="cursor-pointer text-danger">Удалить все</strong>
  </div>
</div>
<hr class="mb-2 mt-3">

<!-- modal -->
<div id="add_fellowship_tmpl_modal" class="modal hide fade" tabindex="-1" data-toggle="modal" role="dialog" aria-hidden="true" data-add="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Добавить шаблон</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <select id="fellowship_tmpl_serving_one_list_modal" class="form-control form-control-sm">
              <option value="_none_">-------</option>
              <?php foreach ($fellowship_serving_one_list as $key => $value): ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-2">
            <select id="fellowship_tmpl_days_modal" class="form-control form-control-sm">
              <option value="_none_">--</option>
              <option value="пн">пн</option>
              <option value="вт">вт</option>
              <option value="ср">ср</option>
              <option value="чт">чт</option>
              <option value="пт">пт</option>
              <option value="сб">сб</option>
              <option value="вс">вс</option>
            </select>
          </div>
          <div class="col-3">
            <input type="time" id="fellowship_tmpl_time_modal" class="form-control form-control-sm" value="">
          </div>
          <div class="col-2">
            <input type="number" id="fellowship_tmpl_duration_modal" class="form-control form-control-sm" value="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
        <button type="button" id="set_fellowship_tmpl_modal" class="btn btn-primary" data-dismiss="modal">Сохранить</button>
      </div>
    </div>
  </div>
</div>
