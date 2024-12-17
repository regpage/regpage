<!-- Вкладки -->
<div class="row mb-3">
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_incomming_active; ?>" data-toggle="tab" href="#" data-tab_name="incomming">
        Входящие
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_currents_active; ?>" data-toggle="tab" href="#" data-tab_name="currents">
         В работе <?php // echo $permission_statistics; ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_finished_active; ?>" data-toggle="tab" href="#" data-tab_name="finished">
         Завершённые <?php // echo $permission_statistics; ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_statistics_active; ?>" data-toggle="tab" href="#" data-tab_name="statistics">
        Статистика <?php // echo $missed_class_statistics; ?>
      </a>
    </li>
  </ul>
</div>
<!-- Фильтры и кнопки -->
<div id="btns_flts_panel" class="row mb-3">
  <div class="btn-group">
    <?php if ($tabCalls === 'incomming'): ?>
      <button id="addCalls" class="btn btn-success btn-sm mr-2" type="button" title="Добавить новый звонок" data-toggle="modal" data-target="#modal_call_edit_add">
        <i class="fa fa-plus"></i> Новая заявка
      </button>
    <?php endif; ?>
  </div>
    <select id="flt_author" class="form-control form-control-sm mr-2">
      <?php FTT_Select_fields::rendering($callsUsersList, $fltAuthor, 'Все авторы'); ?>
    </select>
    <?php if ($tabCalls !== 'incomming'): ?>
      <!--<select id="flt_statuses" class="form-control form-control-sm ml-2" value="">
        <option value="Входящая">Входящая
        <option value="В работе">В работе
        <option value="Недозвон">Недозвон
        <option value="Ошибка">Ошибка
        <option value="Отказ">Отказ
        <option value="Повтор">Повтор
        <option value="Уточнение">Уточнение
        <option value="Заказ">Заказ
      </select>-->
      <select id="flt_operator" class="form-control form-control-sm mr-2">
        <?php FTT_Select_fields::rendering($callsUsersList, $fltOperator, 'Все операторы'); ?>
      </select>
    <?php endif; ?>
    <?php if ($callsUserData['male'] === '1'): ?>
      <select id="flt_gender" class="form-control form-control-sm mr-2" value="">
      <?php FTT_Select_fields::rendering(['1'=>'муж.', '0'=>'жен.'], $fltGender, 'Все'); ?>
      </select>
    <?php endif; ?>
    <input type="search" id="flt_search" class="form-control form-control-sm ml-2" value="<?php echo urldecode($fltSearch); ?>"><div class="input-group-append">
      <button id="btn_search" class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i></button>
    </div>
</div>
<!-- список фильтров  -->
<div class="row pl-0">
  <strong id="flt_list" class="text-danger"></strong>
</div>
<?php
if ($tabCalls === 'currents') {
  // вкладка текущие
  require_once 'components/regpage/calls/content_currents.php';
} elseif ($tabCalls === 'finished') {
  // вкладка завершённые
  require_once 'components/regpage/calls/content_finished.php';
} elseif ($tabCalls === 'statistics') {
  // вкладка статистика
  require_once 'components/regpage/calls/content_statistics.php';
} else {
  // вкладка входящие
  require_once 'components/regpage/calls/content_incomming.php';
}
?>
