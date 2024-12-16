<!-- Вкладки -->
<div class="row mb-3">
  <ul class="nav nav-tabs" role="tablist" style="margin-left: -15px;">
    <li class="nav-item">
      <a class="nav-link <?php // echo $tab_attendance_active; ?>" data-toggle="tab" href="#current_extra_help">
        Входящие
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php // echo $tab_permission_active; ?>" data-toggle="tab" href="#permission_tab">
         В работе <?php // echo $permission_statistics; ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php // echo $tab_permission_active; ?>" data-toggle="tab" href="#permission_tab">
         Завершённые <?php // echo $permission_statistics; ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php // echo $tab_missed_class_active; ?>" data-toggle="tab" href="#missed_class_tab">
        Статистика <?php // echo $missed_class_statistics; ?>
      </a>
    </li>
  </ul>
</div>
<!-- Фильтры и кнопки -->
<div id="btns_flts_panel" class="row mb-3">
  <div class="btn-group">
    <?php if ($tabCalls === 'incomming'): ?>
      <button id="addCalls" class="btn btn-success btn-sm" type="button" title="Добавить новый звонок" data-toggle="modal" data-target="#modal_call_edit_add">
        <i class="fa fa-plus"></i> Добавить
      </button>
    <?php endif; ?>
  </div>
    <select id="flt_localities" class="form-control form-control-sm ml-2">
      <?php FTT_Select_fields::rendering($callsUsersList, MEMBER_ID, 'Все'); ?>
    </select>
    <?php if ($tabCalls !== 'incomming'): ?>
      <select id="flt_statuses" class="form-control form-control-sm ml-2" value="">
        <option value="Входящая">Входящая
        <option value="В работе">В работе
        <option value="Недозвон">Недозвон
        <option value="Ошибка">Ошибка
        <option value="Отказ">Отказ
        <option value="Повтор">Повтор
        <option value="Уточнение">Уточнение
        <option value="Заказ">Заказ
      </select>
    <?php endif; ?>
    <select id="flt_countries" class="form-control form-control-sm ml-2" value="">
        <?php FTT_Select_fields::rendering($callsCountryListQuick, '', 'Все'); ?>
        <option disabled>-----------</option>
        <?php FTT_Select_fields::rendering($callsCountryList, '', ''); ?>
    </select>
    <select id="flt_users" class="form-control form-control-sm ml-2" value="">
        <?php FTT_Select_fields::rendering($callsLocalityList, '', 'Все'); ?>
    </select>
    <input type="text" class="form-control form-control-sm ml-2" value="" placeholder="Поиск">
</div>

<?php
if (false) {
  // code...
} elseif (false) {
  // code...
} elseif (false) {
  // code...
} else {
  // вкладка входящие
  require_once 'components/regpage/calls/content_incomming.php';
}
?>
