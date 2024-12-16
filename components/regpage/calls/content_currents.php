<?php
/*
  if ($value['status'] === 'В работе') {
    $badgeClass = "secondary";
  } elseif ($value['status'] === 'Недозвон') {
    $badgeClass = "warning";
  } elseif ($value['status'] === 'Ошибка') {
    $badgeClass = "dark";
  } elseif ($value['status'] === 'Отказ') {
    $badgeClass = "danger";
  } elseif ($value['status'] === 'Повтор') {
    $badgeClass = "info";
  } elseif ($value['status'] === 'Уточнение') {
    $badgeClass = "primary";
  } elseif ($value['status'] === 'Заказ') {
    $badgeClass = "success";
  }
*/
?>
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
  <?php foreach (CallsDB::getCalls('currents', '', $sort_setting[0], $sort_setting[1]) as $key => $value): ?>
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
