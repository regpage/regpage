<div id="btns_flts_panel" class="row mb-3">
  <div class="btn-group">
    <button id="addCalls" class="btn btn-success btn-sm" type="button" title="Добавить новый звонок" data-toggle="modal" data-target="#modal_call_edit_add">
      <i class="fa fa-plus"></i> Добавить
    </button>
  </div>
    <select id="flt_localities" class="form-control form-control-sm ml-2">
      <?php FTT_Select_fields::rendering($callsUsersList, MEMBER_ID, 'Все'); ?>
    </select>
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
<!-- заголовки колонок -->
<div class="row pb-2 mr-0 border-bottom">
  <div class="col pl-1">
    <b class="sort_col" data-sort="m.name">ФИО <i class="<?php echo $sort_fio_ico ?>"></i></b>
  </div>
  <div class="col pl-3">
    <b class="sort_col" data-sort="c.locality">Местность <i class="<?php echo $sort_locality_ico ?>"></i></b>
  </div>
  <div class="col pl-3">
    <span>Телефон</span>
  </div>
  <div class="col pl-3">
    <b class="sort_col" data-sort="c.status">Статус <i class="<?php echo $sort_status_ico ?>"></i></b>
  </div>
  <div class="col pl-3">
    <b class="sort_col" data-sort="operator_name">Ответственный <i class="<?php echo $sort_operator_ico ?>"></i></b>
  </div>
</div>

<div class="row mr-0 ml-0">
  <div class="calls_list container pl-0">
  <?php foreach (CallsDB::getCalls('', '', $sort_setting[0], $sort_setting[1]) as $key => $value): ?>
    <?php
/*
      if ($value['status'] === 'Входящая') {
        $badgeClass = 'secondary';
      } elseif ($value['status'] === 'В работе') {
        $badgeClass = "primary";
      } elseif ($value['status'] === 'Недозвон') {
        $badgeClass = "dark";
      } elseif ($value['status'] === 'Ошибка') {
        $badgeClass = "danger";
      } elseif ($value['status'] === 'Отказ') {
        $badgeClass = "warning";
      } elseif ($value['status'] === 'Повтор') {
        $badgeClass = "info";
      } elseif ($value['status'] === 'Уточнение') {
        $badgeClass = "light";
      } elseif ($value['status'] === 'Заказ') {
        $badgeClass = "success";
      }
*/
    ?>
    <div class="row call_str pl-0" data-id="<?php echo $value['id'] ?>" data-date="<?php echo $value['created_date'] ?>">
      <div class="col pl-2">
        <div class="">
          <?php echo $value['name'] ?>
        </div>
      </div>
      <div class="col">
        <div class="">
          <?php echo $value['locality'] ?>
        </div>
      </div>
      <div class="col">
        <div class="">
          <?php echo $value['phone'] ?>
        </div>
      </div>
      <div class="col">
        <div class="col_status">
          <?php echo $value['status']; ?>
        </div>
      </div>
      <div class="col">
        <div class="">
          <?php echo short_name::short($value['operator_name']) ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</div>
